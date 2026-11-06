<?php
/** Offline admission/concurrency tests; no WordPress, database, mail or uploads. */
if (PHP_SAPI !== 'cli') {
	http_response_code(404);
	exit;
}
error_reporting(E_ALL);
define('MINUTE_IN_SECONDS', 60);
define('HOUR_IN_SECONDS', 3600);
define('DAY_IN_SECONDS', 86400);
define('DB_NAME', 'offline_zeka_fixture');
define('ARRAY_A', 'ARRAY_A');

class WP_Error {
	private $code;
	public function __construct($code, $message = '') { $this->code = $code; }
	public function get_error_code() { return $this->code; }
}
class ReportRedirect extends RuntimeException {}
function is_wp_error($value) { return $value instanceof WP_Error; }
function apply_filters($name, $value) { return $GLOBALS['filters'][$name] ?? $value; }
// Match WordPress's recursive slash/unslash calling convention.
function wp_slash($value) {
	if (is_array($value)) { return array_map('wp_slash', $value); }
	return is_string($value) ? addslashes($value) : $value;
}
function wp_unslash($value) {
	if (is_array($value)) { return array_map('wp_unslash', $value); }
	return is_string($value) ? stripslashes($value) : $value;
}
function sanitize_key($value) { return preg_replace('/[^a-z0-9_-]/', '', strtolower($value)); }
function sanitize_title($value) { return sanitize_key($value); }
function sanitize_text_field($value) { return trim(strip_tags($value)); }
function sanitize_textarea_field($value) { return sanitize_text_field($value); }
function sanitize_email($value) { return filter_var($value, FILTER_SANITIZE_EMAIL); }
function esc_url_raw($value) { return $value; }
function wp_salt($scheme) { return 'offline-fixture-key'; }
function wp_verify_nonce($nonce, $action) { return $nonce === 'fixture'; }
function zo_get_current_language() { return 'en'; }
function zo_get_language_options() { return array('en' => 'English'); }
function zo_get_game_module($slug) { return $slug === 'fixture-game' ? array('title' => 'Fixture') : null; }
function home_url($path) { return 'https://fixture.invalid' . $path; }
function add_query_arg($key, $value, $url = null) {
	if (is_array($key)) { $url = $value; $args = $key; } else { $args = array($key => $value); }
	return $url . (strpos($url, '?') === false ? '?' : '&') . http_build_query($args);
}
function wp_safe_redirect($url) { $GLOBALS['redirect'] = $url; }
function current_time($format) { return gmdate('Y-m-d H:i:s'); }
function get_current_user_id() { return 0; }
function zo_append_codex_game_report_mirror($id) { $GLOBALS['mirrors'][] = $id; }
function wp_check_filetype($name, $types) {
	return array('type' => $types[strtolower(pathinfo($name, PATHINFO_EXTENSION))] ?? false);
}

/** A shared database with separate simulated connections for interleaved workers. */
class ReportDatabase {
	public $posts = 'fixture_posts';
	public $postmeta = 'fixture_postmeta';
	public $last_error = '';
	public $rows = array();
	public $owner = null;
	public $waits = 0;
	public $release_calls = 0;
	public $fail_lock = false;
	public $fail_count = false;
	public $fail_meta_read = false;
	public $lose_lock_after_insert = false;
	public $fail_release = false;
	public $throw_release = false;
	public $lock_names = array();
	public function prepare($sql, ...$args) { return array($sql, $args); }
	public function connection() { $fiber = Fiber::getCurrent(); return $fiber ? spl_object_id($fiber) : 0; }
	public function get_row($query, $output) {
		$this->last_error = '';
		list($sql, $args) = $query;
		if (strpos($sql, 'SELECT meta_value') === false || $output !== ARRAY_A) { throw new RuntimeException('Unexpected row query'); }
		if ($this->fail_meta_read) { $this->last_error = 'fixture read failure'; return null; }
		$meta = $this->rows[$args[0]]['meta_input'] ?? array();
		return array_key_exists($args[1], $meta) ? array('meta_value' => (string) $meta[$args[1]]) : null;
	}
	public function get_var($query) {
		$this->last_error = '';
		list($sql, $args) = $query;
		if (strpos($sql, 'GET_LOCK(') !== false) {
			if (!preg_match('/GET_LOCK\\(%s,\\s*1\\)/', $sql)) { throw new RuntimeException('Lock wait must remain one second.'); }
			$this->lock_names[] = $args[0];
			if ($this->fail_lock) { return null; }
			while ($this->owner !== null && $this->owner !== $this->connection()) {
				$this->waits++;
				Fiber::suspend('waiting for lock');
			}
			$this->owner = $this->connection();
			return '1';
		}
		if (strpos($sql, 'IS_USED_LOCK(') !== false) { return $this->owner === $this->connection() ? '1' : '0'; }
		if (strpos($sql, 'RELEASE_LOCK(') !== false) {
			$this->release_calls++;
			if ($this->throw_release) { throw new RuntimeException('fixture release failure'); }
			if ($this->fail_release) { $this->last_error = 'fixture release failure'; return null; }
			if ($this->owner === $this->connection()) { $this->owner = null; return '1'; }
			return null;
		}
		if (strpos($sql, 'SELECT meta_value') !== false) {
			if ($this->fail_meta_read) { $this->last_error = 'fixture read failure'; return null; }
			$value = $this->rows[$args[0]]['meta_input'][$args[1]] ?? null;
			return $value === '' ? null : $value;
		}
		if (strpos($sql, 'COUNT(') !== false) {
			if ($this->fail_count) { $this->last_error = 'fixture count failure'; return null; }
			$count = 0;
			foreach ($this->rows as $row) {
				if ($row['post_type'] !== $args[0]) { continue; }
				if (isset($args[1]) && $row['post_date_gmt'] <= $args[1]) { continue; }
				if (isset($args[2]) && ($row['meta_input'][$args[2]] ?? null) !== $args[3]) { continue; }
				$count++;
			}
			return (string) $count;
		}
		throw new RuntimeException('Unexpected fixture query: ' . $sql);
	}
}
function wp_insert_post($data, $return_error) {
	$GLOBALS['insert_attempts']++;
	if ($GLOBALS['insert_fails']) { return new WP_Error('fixture_insert'); }
	if ($GLOBALS['suspend_insert'] && Fiber::getCurrent()) {
		$GLOBALS['suspend_insert'] = false;
		Fiber::suspend('inside admission lock');
	}
	$db = $GLOBALS['wpdb'];
	// Core unslashes post fields, and update_post_meta unslashes meta_input.
	$data = wp_unslash($data);
	$id = count($db->rows) + 1;
	while (isset($db->rows[$id])) { $id++; }
	if ($GLOBALS['missing_meta'] !== null) { unset($data['meta_input'][$GLOBALS['missing_meta']]); }
	$db->rows[$id] = $data;
	if ($db->lose_lock_after_insert) { $db->owner = null; }
	return $id;
}
function wp_delete_post($id, $force) { unset($GLOBALS['wpdb']->rows[$id]); $GLOBALS['deleted_posts'][] = $id; return true; }
function update_post_meta($id, $key, $value) {
	if ($GLOBALS['attachment_meta_fails']) { return false; }
	$GLOBALS['wpdb']->rows[$id]['meta_input'][$key] = $value;
	return 1;
}
function wp_handle_upload($file, $overrides) {
	$GLOBALS['upload_calls']++;
	return array('file' => 'fixture-upload.png', 'type' => 'image/png');
}
function wp_insert_attachment($data, $file, $parent) { return $GLOBALS['attachment_fails'] ? new WP_Error('attachment') : 501; }
function wp_generate_attachment_metadata($id, $file) { return array(); }
function wp_update_attachment_metadata($id, $meta) { return true; }
function wp_delete_attachment($id, $force) { $GLOBALS['deleted_attachments'][] = $id; }
function wp_delete_file($path) { $GLOBALS['deleted_files'][] = $path; }

$source = file_get_contents(dirname(__DIR__) . '/zeka-oyunlari.php');
$start = strpos($source, 'function zo_game_report_global_rate_limit()');
$handler = strpos($source, 'function zo_handle_game_report_submission()', $start);
$stop = strpos($source, "add_action('admin_post_zo_submit_game_report'", $handler);
if ($start === false || $handler === false || $stop === false) { throw new RuntimeException('Admission source not found.'); }
eval(substr($source, $start, $handler - $start));
// Redirects end a real request. Turn only those exits into catchable test signals.
eval(str_replace('exit;', 'throw new ReportRedirect();', substr($source, $handler, $stop - $handler)));

$checks = 0;
function check($condition, $message) {
	$GLOBALS['checks']++;
	if (!$condition) { throw new RuntimeException('FAILED: ' . $message); }
}
function reset_fixture() {
	$GLOBALS['wpdb'] = new ReportDatabase();
	$GLOBALS['filters'] = array();
	$GLOBALS['insert_attempts'] = 0;
	$GLOBALS['insert_fails'] = false;
	$GLOBALS['missing_meta'] = null;
	$GLOBALS['suspend_insert'] = false;
	$GLOBALS['upload_calls'] = 0;
	$GLOBALS['attachment_fails'] = false;
	$GLOBALS['attachment_meta_fails'] = false;
	$GLOBALS['deleted_files'] = array();
	$GLOBALS['deleted_posts'] = array();
	$GLOBALS['deleted_attachments'] = array();
	$GLOBALS['mirrors'] = array();
	$GLOBALS['redirect'] = '';
	$_SERVER = array('REMOTE_ADDR' => '192.0.2.1');
	$_POST = array('zo_report_nonce' => 'fixture', 'zo_game_slug' => 'fixture-game', 'zo_message' => 'A useful report message');
	$_FILES = array();
}
function fixture_post($peer = 'other', $duplicate = 'other', $age = 0) {
	return array('post_type' => 'zo_game_report', 'post_status' => 'private', 'post_date_gmt' => gmdate('Y-m-d H:i:s', time() - $age),
		'meta_input' => array('_zo_report_peer_hash' => $peer, '_zo_report_duplicate_hash' => $duplicate));
}
function admit($peer, $duplicate = null) {
	return zo_insert_admitted_game_report(array('post_title' => 'Fixture', 'post_content' => 'A useful report', 'meta_input' => array('empty_field' => '')), $peer, $duplicate ?? $peer);
}
function submit_handler() {
	try { zo_handle_game_report_submission(); } catch (ReportRedirect $signal) {}
}
function run_pair($first_peer, $second_peer) {
	$GLOBALS['suspend_insert'] = true;
	$a = new Fiber(static function () use ($first_peer) { return admit($first_peer); });
	$b = new Fiber(static function () use ($second_peer) { return admit($second_peer); });
	check($a->start() === 'inside admission lock', 'first worker holds admission lock before insertion');
	check($b->start() === 'waiting for lock', 'second connection cannot read admission state while locked');
	$a->resume(); $b->resume();
	check($a->isTerminated() && $b->isTerminated(), 'both workers finish');
	check(!is_wp_error($a->getReturn()) && is_wp_error($b->getReturn()), 'only one worker receives the remaining slot');
	check($GLOBALS['wpdb']->owner === null, 'concurrent workers release the database lock');
}

$temp = sys_get_temp_dir() . '/zeka-admission-' . bin2hex(random_bytes(8));
mkdir($temp . '/wp-admin/includes', 0700, true);
file_put_contents($temp . '/wp-admin/includes/file.php', '<?php');
file_put_contents($temp . '/wp-admin/includes/image.php', '<?php');
$png = $temp . '/fixture.png';
file_put_contents($png, base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+a5XcAAAAASUVORK5CYII='));
define('ABSPATH', $temp . '/');
try {
	reset_fixture();
	check(zo_game_report_global_rate_limit() === 30 && zo_game_report_storage_cap() === 1000, 'conservative existing default budgets preserved');
	check(!is_wp_error(admit('first')), 'ordinary private report admitted');
	check($GLOBALS['wpdb']->rows[1]['post_status'] === 'private', 'admitted row remains private');
	check($GLOBALS['wpdb']->rows[1]['post_date_gmt'] === gmdate('Y-m-d H:i:s'), 'admission timestamp is UTC');
	check(is_wp_error(admit('first', 'another message')), 'same peer cannot send another report within five minutes');
	check(!is_wp_error(admit('second')), 'another peer can send a legitimate report');
	check(strlen($GLOBALS['wpdb']->lock_names[0]) <= 64, 'lock name fits MySQL bound');
	$first_lock = $GLOBALS['wpdb']->lock_names[0];
	$GLOBALS['wpdb']->posts = 'another_site_posts';
	check(!is_wp_error(admit('third')), 'another site uses its own admission lock');
	check(end($GLOBALS['wpdb']->lock_names) !== $first_lock, 'lock scope includes the site table');

	reset_fixture(); run_pair('same-peer', 'same-peer');
	check(count($GLOBALS['wpdb']->rows) === 1, 'same-peer concurrency retains one report');
	reset_fixture(); $GLOBALS['filters']['zo_game_report_global_rate_limit'] = 5;
	for ($i = 0; $i < 4; $i++) { $GLOBALS['wpdb']->rows[$i + 1] = fixture_post('seed-' . $i); }
	run_pair('first-peer', 'second-peer');
	check(count($GLOBALS['wpdb']->rows) === 5, 'cross-peer concurrency cannot exceed the global rate');
	reset_fixture(); $GLOBALS['filters']['zo_game_report_storage_cap'] = 100;
	for ($i = 0; $i < 99; $i++) { $GLOBALS['wpdb']->rows[$i + 1] = fixture_post('seed-' . $i, 'seed', 2 * DAY_IN_SECONDS); }
	run_pair('first-peer', 'second-peer');
	check(count($GLOBALS['wpdb']->rows) === 100, 'concurrent submissions cannot exceed retained storage cap');

	reset_fixture(); $GLOBALS['wpdb']->rows[1] = fixture_post('peer', 'duplicate', 301);
	check(is_wp_error(admit('peer', 'duplicate')), 'duplicate persists beyond per-peer cooldown');
	check(!is_wp_error(admit('peer', 'different')), 'different useful report allowed after cooldown');
	reset_fixture(); $GLOBALS['wpdb']->rows[1] = fixture_post('peer', 'duplicate', 31 * DAY_IN_SECONDS);
	check(!is_wp_error(admit('peer', 'duplicate')), 'expired duplicate may be reported again');
	reset_fixture();
	$GLOBALS['filters']['zo_game_report_global_rate_limit'] = 5;
	for ($i = 0; $i < 5; $i++) { $GLOBALS['wpdb']->rows[$i + 1] = fixture_post('seed-' . $i, 'seed', 3601); }
	check(!is_wp_error(admit('new')), 'rolling global window excludes older accepted reports');

	foreach (array('fail_lock', 'fail_count', 'fail_meta_read', 'lose_lock_after_insert') as $failure) {
		reset_fixture(); $GLOBALS['wpdb']->$failure = true;
		check(is_wp_error(admit('peer')), $failure . ' rejects admission');
		check(count($GLOBALS['wpdb']->rows) === 0, $failure . ' leaves no admitted/partial report');
		check($GLOBALS['wpdb']->owner === null, $failure . ' releases lock');
	}
	foreach (array('_zo_report_peer_hash', '_zo_report_duplicate_hash', 'empty_field') as $missing) {
		reset_fixture(); $GLOBALS['missing_meta'] = $missing;
		check(is_wp_error(admit('peer')), 'missing metadata rejects: ' . $missing);
		check(count($GLOBALS['wpdb']->rows) === 0, 'partial report rolled back: ' . $missing);
	}
	reset_fixture(); $GLOBALS['insert_fails'] = true;
	check(is_wp_error(admit('peer')), 'failed insertion rejects admission');
	check($GLOBALS['wpdb']->owner === null && count($GLOBALS['wpdb']->rows) === 0, 'failed insertion releases lock without a row');

	reset_fixture(); submit_handler();
	check(strpos($GLOBALS['redirect'], 'sent=1') !== false && count($GLOBALS['wpdb']->rows) === 1, 'actual public handler completes an ordinary report');
	check($GLOBALS['wpdb']->rows[1]['meta_input']['_zo_report_email'] === '' && $GLOBALS['wpdb']->rows[1]['meta_input']['_zo_report_browser'] === '', 'empty optional fields survive real wpdb row readback semantics');
	check($GLOBALS['upload_calls'] === 0, 'report without screenshot does not enter upload path');
	$row = reset($GLOBALS['wpdb']->rows);
	check(strpos(json_encode($row), '192.0.2.1') === false, 'private peer metadata stores a hash, not the raw IP');
	reset_fixture();
	$quote_text = 'A "quoted" report with apostrophe\'s and C:\\Games\\fixture';
	$_POST['zo_message'] = wp_slash($quote_text);
	$_POST['zo_browser'] = wp_slash('Browser "Name" C:\\Apps');
	submit_handler();
	check(count($GLOBALS['wpdb']->rows) === 1 && $GLOBALS['wpdb']->rows[1]['post_content'] === $quote_text, 'quoted and backslashed report text round-trips through WordPress slashing');
	check($GLOBALS['wpdb']->rows[1]['meta_input']['_zo_report_browser'] === 'Browser "Name" C:\\Apps', 'quoted and backslashed metadata round-trips through meta_input');
	reset_fixture(); $_POST['zo_message'] = array('nested'); submit_handler();
	check($GLOBALS['insert_attempts'] === 0, 'nested form input rejected before insertion');
	reset_fixture(); $_POST['zo_message'] = str_repeat('a', 4097); submit_handler();
	check($GLOBALS['insert_attempts'] === 0, 'oversized form input rejected before insertion');
	reset_fixture(); $_SERVER['CONTENT_LENGTH'] = (string) (2 * 1024 * 1024 + 1); submit_handler();
	check($GLOBALS['insert_attempts'] === 0, 'oversized advertised multipart request rejected');
	reset_fixture(); $_POST[str_repeat('k', 65)] = ''; submit_handler();
	check($GLOBALS['insert_attempts'] === 0, 'oversized form key rejected');
	reset_fixture(); $_POST = array();
	for ($i = 0; $i < 20; $i++) { $_POST[str_repeat('k', 60) . $i] = str_repeat('v', 350); }
	check(!zo_game_report_request_is_bounded(), 'form key bytes count toward aggregate parsed-input cap');
	reset_fixture(); $_FILES['unexpected_file'] = $file ?? array(); submit_handler();
	check($GLOBALS['insert_attempts'] === 0, 'unknown multipart upload key rejected');
	reset_fixture(); $_SERVER['REMOTE_ADDR'] = 'invalid'; submit_handler();
	check($GLOBALS['insert_attempts'] === 0, 'missing valid peer identity fails closed');
	reset_fixture(); $_SERVER['HTTP_X_FORWARDED_FOR'] = '203.0.113.9'; submit_handler(); submit_handler();
	check(count($GLOBALS['wpdb']->rows) === 1, 'spoofed forwarded headers do not change peer budget');
	reset_fixture(); $_SERVER['REMOTE_ADDR'] = '2001:db8::1'; submit_handler();
	$_SERVER['REMOTE_ADDR'] = '2001:0db8:0:0:0:0:0:1'; $_POST['zo_message'] = 'Another useful report'; submit_handler();
	check(count($GLOBALS['wpdb']->rows) === 1, 'equivalent IPv6 spellings share the same peer budget');

	$file = array('name' => 'fixture.png', 'tmp_name' => $png, 'size' => filesize($png), 'error' => UPLOAD_ERR_OK);
	reset_fixture(); check(zo_game_report_screenshot_is_allowed($file), 'ordinary bounded screenshot accepted');
	$invalid = $file; $invalid['size'] = 1048577;
	check(!zo_game_report_screenshot_is_allowed($invalid), 'screenshots above one MiB rejected');
	$invalid = $file; $invalid['name'] = 'fixture.jpg';
	check(!zo_game_report_screenshot_is_allowed($invalid), 'image and extension MIME mismatch rejected');
	$invalid = $file; $invalid['name'] = array('nested');
	check(!zo_game_report_screenshot_is_allowed($invalid), 'nested file metadata rejected');
	$wide_png = $temp . '/wide.png';
	$wide_data = file_get_contents($png);
	$wide_data = substr_replace($wide_data, pack('N', 4097), 16, 4);
	file_put_contents($wide_png, $wide_data);
	$invalid = $file; $invalid['tmp_name'] = $wide_png;
	check(!zo_game_report_screenshot_is_allowed($invalid), 'oversized decoded image dimensions rejected');
	unlink($wide_png);
	$large_png = $temp . '/large.png';
	file_put_contents($large_png, file_get_contents($png) . str_repeat('x', 1048576));
	$invalid = $file; $invalid['tmp_name'] = $large_png;
	check(!zo_game_report_screenshot_is_allowed($invalid), 'actual screenshot bytes checked independently of advertised size');
	unlink($large_png);
	foreach (array('fail_lock', 'fail_count', 'fail_meta_read') as $failure) {
		reset_fixture(); $_FILES['zo_screenshot'] = $file; $GLOBALS['wpdb']->$failure = true; submit_handler();
		check($GLOBALS['upload_calls'] === 0, $failure . ' cannot start screenshot processing');
	}
	foreach (array('fail_release', 'throw_release') as $failure) {
		reset_fixture(); $_FILES['zo_screenshot'] = $file; $GLOBALS['wpdb']->$failure = true; submit_handler();
		check($GLOBALS['upload_calls'] === 0 && count($GLOBALS['wpdb']->rows) === 0, $failure . ' rolls back before any screenshot work');
		check(strpos($GLOBALS['redirect'], 'report_error=rate') !== false, $failure . ' returns a rejection');
	}
	reset_fixture(); $_FILES['zo_screenshot'] = $file; $GLOBALS['attachment_fails'] = true; submit_handler();
	check($GLOBALS['upload_calls'] === 1 && $GLOBALS['deleted_files'] === array('fixture-upload.png'), 'failed attachment deletes uploaded file');
	reset_fixture(); $_FILES['zo_screenshot'] = $file; $GLOBALS['attachment_meta_fails'] = true; submit_handler();
	check($GLOBALS['deleted_attachments'] === array(501), 'failed report attachment link removes attachment and its files');
	reset_fixture(); $_FILES['zo_screenshot'] = $file; submit_handler();
	check($GLOBALS['upload_calls'] === 1 && $GLOBALS['wpdb']->rows[1]['meta_input']['_zo_report_screenshot_id'] === 501, 'valid admitted screenshot is attached to its private report');
	echo 'PASS: ' . $checks . " report admission, concurrency and failure checks\n";
} finally {
	unlink($png);
	unlink($temp . '/wp-admin/includes/file.php');
	unlink($temp . '/wp-admin/includes/image.php');
	rmdir($temp . '/wp-admin/includes'); rmdir($temp . '/wp-admin'); rmdir($temp);
}
