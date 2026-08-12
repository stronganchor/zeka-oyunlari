<?php
/**
 * Static security regression checks for the single-file plugin.
 */

$source_path = dirname(__DIR__) . '/zeka-oyunlari.php';
$source = file_get_contents($source_path);
if (!is_string($source)) {
	fwrite(STDERR, "Could not read zeka-oyunlari.php.\n");
	exit(1);
}

$roster_path = dirname(__DIR__) . '/games/roster-1000/game.php';
$roster_source = file_get_contents($roster_path);
if (!is_string($roster_source)) {
	fwrite(STDERR, "Could not read games/roster-1000/game.php.\n");
	exit(1);
}

$agent_rules = file_get_contents(dirname(__DIR__) . '/AGENTS.md');
$security_policy = file_get_contents(dirname(__DIR__) . '/SECURITY.md');
if (!is_string($agent_rules) || !is_string($security_policy)) {
	fwrite(STDERR, "Could not read AGENTS.md or SECURITY.md.\n");
	exit(1);
}

$failures = array();
$require_text = static function ($needle, $message) use ($source, &$failures) {
	if (strpos($source, $needle) === false) {
		$failures[] = $message;
	}
};

if (!preg_match('/^\s*\*\s+Version:\s+([^\s]+)$/m', $source, $header_match) ||
	!preg_match("/define\\('ZO_PLUGIN_VERSION',\\s*'([^']+)'\\);/", $source, $constant_match) ||
	$header_match[1] !== $constant_match[1]) {
	$failures[] = 'Plugin header and ZO_PLUGIN_VERSION must remain synchronized.';
}

$require_text("'.private/zeka-oyunlari/codex-reports'", 'The default report mirror must remain outside the WordPress webroot.');
$require_text("defined('ZO_CODEX_REPORT_MIRROR_DIR')", 'The private report mirror must remain explicitly configurable.');
$require_text("zo_get_public_report_mirror_roots()", 'Configured report paths must remain checked against public roots.');
$require_text("add_action('init', 'zo_remove_legacy_public_report_mirror', 1)", 'Legacy public report files must be removed independently of private mirror availability.');
$require_text('if (is_link($path))', 'Private report writes must reject a symlink destination.');
$require_text("zo_write_private_report_mirror_file(\$jsonl_path, \$jsonl)", 'The JSONL mirror must remain a bounded rewrite of recent reports.');
$require_text('zo_game_report_global_rate_allowed()', 'The public report handler must retain its site-wide rate limit.');
$require_text('zo_game_report_storage_available()', 'The public report handler must retain its total storage cap.');

$handler_start = strpos($source, 'function zo_handle_game_report_submission()');
$insert_start = strpos($source, 'wp_insert_post(', $handler_start);
$global_check = strpos($source, 'zo_game_report_global_rate_allowed()', $handler_start);
$storage_check = strpos($source, 'zo_game_report_storage_available()', $handler_start);
$global_increment = strpos($source, 'zo_increment_game_report_global_rate();', $insert_start);

if ($handler_start === false || $insert_start === false ||
	$global_check === false || $global_check > $insert_start ||
	$storage_check === false || $storage_check > $insert_start ||
	$global_increment === false) {
	$failures[] = 'Global rate/storage checks must run before insertion and increment only after a successful insert.';
}

if (strpos($source, 'FILE_APPEND') !== false) {
	$failures[] = 'The private JSONL mirror must not return to unbounded append behavior.';
}

$account_disable = strpos($source, 'SECURITY HARD-DISABLE (2026-08-12)');
$disabled_notice = strpos($source, 'Game accounts are temporarily disabled', $account_disable);
$legacy_wordpress_account = strpos($source, 'wp_insert_user(', $account_disable);
$account_cleanup_stop = strpos($source, "wp_add_inline_script('zo-account-security-cleanup'", $account_disable);
$legacy_pin_storage = strpos($source, 'localStorage.setItem(storeKey', $account_disable);

if ($account_disable === false || $disabled_notice === false ||
	$legacy_wordpress_account === false || $disabled_notice > $legacy_wordpress_account ||
	$account_cleanup_stop === false || $legacy_pin_storage === false ||
	$account_cleanup_stop > $legacy_pin_storage) {
	$failures[] = 'The insecure game-account UI and legacy PIN code must remain hard-disabled before any credential path can execute.';
}

$roster_disable = strpos($roster_source, 'SECURITY BAND-AID (2026-08-12)');
$roster_early_return = strpos($roster_source, "'render_callback' => 'zo_game_roster_1000_security_disabled_render'", $roster_disable);
$roster_legacy_handler = strpos($roster_source, 'function zo_roster_1000_ajax_load_progress()', $roster_disable);

if ($roster_disable === false || $roster_early_return === false ||
	$roster_legacy_handler === false || $roster_early_return > $roster_legacy_handler) {
	$failures[] = 'Roster 1000 must remain disabled before any legacy account/progress code can register.';
}

if (strpos($roster_source, '5549 tokens truncated') !== false) {
	$failures[] = 'Roster 1000 must not contain a generated truncation marker in executable source.';
}

if (strpos($roster_source, 'wp_ajax_nopriv_zo_roster_1000') !== false) {
	$failures[] = 'Roster 1000 must not restore anonymous account or progress AJAX handlers.';
}

if (strpos($agent_rules, 'explicit approval from an adult') === false ||
	strpos($agent_rules, 'Never store a password or PIN') === false ||
	strpos($security_policy, 'Game-account creation and the Roster 1000 game are intentionally disabled') === false) {
	$failures[] = 'The adult-approval and credential-safety project guidance must remain documented.';
}

if (!empty($failures)) {
	fwrite(STDERR, "FAILED\n- " . implode("\n- ", $failures) . "\n");
	exit(1);
}

echo "PASS: Zeka report and game-account security invariants\n";
