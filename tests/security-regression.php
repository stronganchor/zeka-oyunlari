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

if (!empty($failures)) {
	fwrite(STDERR, "FAILED\n- " . implode("\n- ", $failures) . "\n");
	exit(1);
}

echo "PASS: Zeka report security invariants\n";
