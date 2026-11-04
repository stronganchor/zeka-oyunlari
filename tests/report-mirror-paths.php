<?php
/**
 * Offline admin report-mirror path regression. No files, network or WP data.
 * Run: php tests/report-mirror-paths.php
 * Optional: ZO_TEST_WP_FUNCTIONS points at an actual wp-includes/functions.php.
 * Incident-baseline proof: git show c53bd9b:zeka-oyunlari.php |
 *   php tests/report-mirror-paths.php --source-stdin
 */
if (PHP_SAPI !== 'cli') {
	http_response_code(404);
	exit;
}
error_reporting(E_ALL);

/** Extract actual named function bodies without bootstrapping WordPress. */
function load_source_function($source, $name) {
	$tokens = token_get_all($source);
	for ($i = 0, $total = count($tokens); $i < $total; $i++) {
		if (!is_array($tokens[$i]) || $tokens[$i][0] !== T_FUNCTION) {
			continue;
		}
		$j = $i + 1;
		while (isset($tokens[$j]) && is_array($tokens[$j]) && $tokens[$j][0] === T_WHITESPACE) {
			$j++;
		}
		if (!isset($tokens[$j]) || !is_array($tokens[$j]) || $tokens[$j][0] !== T_STRING || $tokens[$j][1] !== $name) {
			continue;
		}
		$function = '';
		$depth = 0;
		$opened = false;
		for (; $i < $total; $i++) {
			$token = $tokens[$i];
			$function .= is_array($token) ? $token[1] : $token;
			if ($token === '{') { $depth++; $opened = true; }
			if ($token === '}') { $depth--; }
			if ($opened && $depth === 0) {
				eval($function);
				return;
			}
		}
	}
	throw new RuntimeException('Required source function not found: ' . $name);
}

$core_path = getenv('ZO_TEST_WP_FUNCTIONS');
if (is_string($core_path) && $core_path !== '') {
	$core = file_get_contents($core_path);
	if (!is_string($core)) { throw new RuntimeException('Could not read the requested WordPress core.'); }
	foreach (array('wp_is_stream', 'path_is_absolute', 'wp_normalize_path') as $name) {
		load_source_function($core, $name);
	}
} else {
	require __DIR__ . '/fixtures/wordpress-path-functions.php';
}

define('ABSPATH', '/srv/zeka-fixture/public/');
define('WP_CONTENT_DIR', '/srv/zeka-fixture/public-content');
define('WP_PLUGIN_DIR', '/srv/zeka-fixture/public-plugins');
define('WPMU_PLUGIN_DIR', '/srv/zeka-fixture/shared-mu-plugins');
function trailingslashit($path) { return rtrim($path, '/\\') . '/'; }
function untrailingslashit($path) { return rtrim($path, '/\\'); }
function plugin_dir_path($path) { return '/srv/zeka-fixture/public/wp-content/plugins/zeka-oyunlari/'; }
function apply_filters($name, $value) { return $GLOBALS['override_active'] ? $GLOBALS['override_dir'] : $value; }
function wp_mkdir_p($path) { $GLOBALS['mkdir_attempts'][] = $path; return false; }
function is_wp_error($value) { return $value instanceof WP_Error; }
class WP_Error {
	private $message;
	public function __construct($code, $message) { $this->message = $message; }
	public function get_error_message() { return $this->message; }
}

$source = in_array('--source-stdin', $argv, true) ? stream_get_contents(STDIN) : file_get_contents(dirname(__DIR__) . '/zeka-oyunlari.php');
if (!is_string($source)) { throw new RuntimeException('Could not read plugin source.'); }
foreach (array('zo_get_codex_report_mirror_dir', 'zo_get_public_report_mirror_roots', 'zo_report_mirror_path_is_within', 'zo_prepare_codex_report_mirror_dir', 'zo_write_codex_game_report_snapshot') as $name) {
	load_source_function($source, $name);
}

$checks = 0;
function check($condition, $message) {
	$GLOBALS['checks']++;
	if (!$condition) { throw new RuntimeException('FAILED: ' . $message); }
}
function configured($value) {
	$GLOBALS['override_active'] = true;
	$GLOBALS['override_dir'] = $value;
	return zo_get_codex_report_mirror_dir();
}
$GLOBALS['override_active'] = false;
$GLOBALS['mkdir_attempts'] = array();
$_SERVER['DOCUMENT_ROOT'] = '/srv/zeka-fixture/alternate-public';

check(function_exists('path_is_absolute'), 'supported WordPress API is available');
check(!function_exists('wp_is_absolute_path'), 'the unsupported API is deliberately not stubbed');
check(zo_get_codex_report_mirror_dir() === '/srv/zeka-fixture/.private/zeka-oyunlari/codex-reports', 'default mirror stays outside the WordPress root');
check(configured('/srv/zeka-fixture/private/reports') === '/srv/zeka-fixture/private/reports', 'absolute private POSIX path remains accepted');
check(configured('  /srv/zeka-fixture/private/reports/  ') === '/srv/zeka-fixture/private/reports', 'ordinary whitespace/trailing slash normalization remains accepted');

foreach (array('', ' ', '.', 'private/reports', './private', '../private', 'C:private', '/srv/private/../public/reports', "/srv/private\0/reports", array('invalid'), false, null) as $path) {
	check(configured($path) === '', 'invalid or relative path fails closed');
}
foreach (array(ABSPATH, WP_CONTENT_DIR, WP_PLUGIN_DIR, WPMU_PLUGIN_DIR, $_SERVER['DOCUMENT_ROOT']) as $root) {
	check(configured(trailingslashit($root) . 'reports') === '', 'every public root denies nested report mirrors');
}
check(configured('/srv/zeka-fixture/public-other/reports') !== '', 'component boundary does not reject a private sibling');
check(zo_report_mirror_path_is_within('/srv/zeka-fixture/public/reports', ABSPATH), 'public child containment remains enforced');
check(!zo_report_mirror_path_is_within('/srv/zeka-fixture/public-other/reports', ABSPATH), 'sibling is not contained by a shared string prefix');

if (DIRECTORY_SEPARATOR === '\\') {
	$_SERVER['DOCUMENT_ROOT'] = 'C:/zeka-fixture-public';
	check(in_array('C:/zeka-fixture-public', zo_get_public_report_mirror_roots(), true), 'native Windows public root remains protected after normalization');
	check(configured('C:/zeka-fixture-private/reports') === 'C:/zeka-fixture-private/reports', 'native drive path uses supported core check with native separators');
	check(configured('c:\\zeka-fixture-public\\reports') === '', 'native Windows public destination is rejected');
	check(configured('C:/zeka-fixture-private/../zeka-fixture-public/reports') === '', 'native Windows traversal is rejected');
} else {
	check(configured('C:/__zeka_nonexistent_normalized_windows_path') === '', 'non-native Windows drive path fails closed on POSIX');
}
$_SERVER['DOCUMENT_ROOT'] = '/srv/zeka-fixture/alternate-public';

// Registered streams must not invoke a wrapper's filesystem callbacks.
class ZekaMirrorFixtureStream {
	public $context;
	public function url_stat($path, $flags) { $GLOBALS['stream_stats']++; return array('mode' => 0040000); }
}
$GLOBALS['stream_stats'] = 0;
stream_wrapper_register('zofixture', ZekaMirrorFixtureStream::class);
try {
	foreach (array('php://memory', 'php://filter/resource=fixture', 'file:///srv/private', 'http://example.invalid/private', 'phar://fixture/private', 'zofixture://private') as $path) {
		check(configured($path) === '', 'stream wrapper is rejected as a mirror path');
	}
	check($GLOBALS['stream_stats'] === 0, 'path guard does not stat a registered stream wrapper');
} finally {
	stream_wrapper_unregister('zofixture');
}
foreach (array("/srv/invalid\0/root", 'file:///srv/public', 'relative/public') as $root) {
	$_SERVER['DOCUMENT_ROOT'] = $root;
	check(!in_array($root, zo_get_public_report_mirror_roots(), true), 'invalid public roots cannot reach the core filesystem check');
}

// Execute the exact snapshot -> prepare -> path chain from the fatal stack.
// A denied mkdir is a normal soft error; no filesystem operations occur.
$_SERVER['DOCUMENT_ROOT'] = '/srv/zeka-fixture/alternate-public';
$GLOBALS['mkdir_attempts'] = array();
configured('/srv/zeka-fixture/private/reports');
$snapshot = zo_write_codex_game_report_snapshot(50);
check($GLOBALS['mkdir_attempts'] === array('/srv/zeka-fixture/private/reports'), 'snapshot reaches private directory preparation');
check($snapshot['path'] === '' && $snapshot['count'] === 0 && strpos($snapshot['error'], 'Could not create') !== false, 'unwritable private destination produces a soft error instead of a fatal');
$GLOBALS['mkdir_attempts'] = array();
configured(ABSPATH . 'reports');
$snapshot = zo_write_codex_game_report_snapshot(50);
check($GLOBALS['mkdir_attempts'] === array(), 'public destination is rejected before directory creation');
check($snapshot['path'] === '' && strpos($snapshot['error'], 'outside every public web root') !== false, 'invalid destination remains a guarded soft error');

echo 'PASS: ' . $checks . ' report-mirror path and admin snapshot checks' . PHP_EOL;
