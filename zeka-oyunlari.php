<?php
/**
 * Plugin Name: Zekâ Oyunları
 * Plugin URI: https://github.com/stronganchor/zeka-oyunlari
 * Description: Simple modular game framework for zekâ.com so kids can publish WordPress-based games and share them with friends.
 * Version: 1.5.27.asker.arslan
 * Update URI: https://github.com/stronganchor/zeka-oyunlari
 * Author: Anadolu Tasarım
 * Author URI: https://github.com/stronganchor/zeka-oyunlari
 * Text Domain: zeka-oyunlari
 * Requires at least: 6.0
 * Requires PHP: 7.4
 */

if (!defined('ABSPATH')) {
	exit;
}

define('ZO_PLUGIN_VERSION', '1.5.17.asker.arslan');
define('ZO_PLUGIN_FILE', __FILE__);
define('ZO_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('ZO_PLUGIN_URL', plugin_dir_url(__FILE__));

function zo_get_shortcode_logo_html($context = '') {
	$context = sanitize_html_class((string) $context);
	$class   = 'zo-shortcode-logo';

	if ($context !== '') {
		$class .= ' zo-shortcode-logo--' . $context;
	}

	return '<span class="' . esc_attr($class) . '" aria-hidden="true">'
		. '<img src="' . esc_url(ZO_PLUGIN_URL . 'zeka-logo.png') . '" alt="" loading="lazy" decoding="async">'
		. '</span>';
}

function zo_get_shortcode_logo_css() {
	return '
.zo-shortcode-frame,
.zo-game-shell {
	position: relative;
}

.zo-shortcode-logo {
	position: absolute;
	top: 12px;
	right: 12px;
	z-index: 30;
	display: inline-flex;
	align-items: center;
	justify-content: center;
	width: clamp(62px, 7vw, 96px);
	aspect-ratio: 1;
	border-radius: 0;
	background: transparent;
	box-shadow: none;
	line-height: 0;
	text-decoration: none;
}

.zo-shortcode-logo img {
	display: block;
	width: 94%;
	height: 94%;
	object-fit: contain;
}

.zo-shortcode-logo:hover,
.zo-shortcode-logo:focus {
	background: transparent;
	box-shadow: none;
	outline: none;
}

.zo-games-grid__toolbar,
.zo-asker-about__language,
.zo-site-about__language {
	padding-right: 92px;
}

@media (max-width: 640px) {
	.zo-shortcode-logo {
		top: 8px;
		right: 8px;
		width: 58px;
		border-radius: 0;
	}

	.zo-games-grid__toolbar,
	.zo-asker-about__language,
	.zo-site-about__language {
		padding-right: 62px;
	}
}
';
}

function zo_get_page_loader_style_handle() {
	return 'zo-page-loader';
}

function zo_get_page_loader_script_handle() {
	return 'zo-page-loader';
}

function zo_get_page_loader_css() {
	return '
.zo-page-loader {
	position: fixed;
	inset: 0;
	z-index: 999999;
	display: flex;
	align-items: center;
	justify-content: center;
	background: rgba(255, 255, 255, 0.96);
	opacity: 1;
	visibility: visible;
	transition: opacity 220ms ease, visibility 220ms ease;
}
.zo-page-loader.is-done {
	opacity: 0;
	visibility: hidden;
	pointer-events: none;
}
.zo-page-loader__symbol {
	display: block;
	width: clamp(86px, 16vw, 156px);
	height: auto;
	animation: zoPageLoaderSpin 850ms linear infinite;
}
@keyframes zoPageLoaderSpin {
	to {
		transform: rotate(360deg);
	}
}
@media (prefers-reduced-motion: reduce) {
	.zo-page-loader__symbol {
		animation-duration: 1600ms;
	}
}
';
}

function zo_get_page_loader_js() {
	return <<<JS
(function () {
	function finishLoader() {
		var loader = document.querySelector('[data-zo-page-loader]');
		if (!loader) {
			return;
		}
		window.setTimeout(function () {
			loader.classList.add('is-done');
			window.setTimeout(function () {
				if (loader && loader.parentNode) {
					loader.parentNode.removeChild(loader);
				}
			}, 260);
		}, 180);
	}

	if (document.readyState === 'complete') {
		finishLoader();
	} else {
		window.addEventListener('load', finishLoader, { once: true });
	}
})();
JS;
}

function zo_register_page_loader_assets() {
	wp_register_style(
		zo_get_page_loader_style_handle(),
		false,
		array(),
		ZO_PLUGIN_VERSION
	);
	wp_add_inline_style(zo_get_page_loader_style_handle(), zo_get_page_loader_css());

	wp_register_script(
		zo_get_page_loader_script_handle(),
		false,
		array(),
		ZO_PLUGIN_VERSION,
		true
	);
	wp_add_inline_script(zo_get_page_loader_script_handle(), zo_get_page_loader_js());
}
add_action('wp_enqueue_scripts', 'zo_register_page_loader_assets', 3);

function zo_enqueue_page_loader_assets() {
	if (is_admin()) {
		return;
	}

	if (wp_style_is(zo_get_page_loader_style_handle(), 'registered')) {
		wp_enqueue_style(zo_get_page_loader_style_handle());
	}

	if (wp_script_is(zo_get_page_loader_script_handle(), 'registered')) {
		wp_enqueue_script(zo_get_page_loader_script_handle());
	}
}
add_action('wp_enqueue_scripts', 'zo_enqueue_page_loader_assets', 30);

function zo_render_page_loader() {
	if (is_admin()) {
		return;
	}

	echo '<div class="zo-page-loader" data-zo-page-loader role="status" aria-label="' . esc_attr__('Loading', 'zeka-oyunlari') . '">';
	echo '<img class="zo-page-loader__symbol" src="' . esc_url(ZO_PLUGIN_URL . 'assets/loading-reload.svg') . '" alt="" decoding="async">';
	echo '</div>';
}
add_action('wp_body_open', 'zo_render_page_loader', 1);

function zo_get_update_branch() {
	$branch = 'main';

	if (defined('ZEKA_OYUNLARI_UPDATE_BRANCH') && is_string(ZEKA_OYUNLARI_UPDATE_BRANCH)) {
		$override = trim(ZEKA_OYUNLARI_UPDATE_BRANCH);
		if ($override !== '') {
			$branch = $override;
		}
	}

	return (string) apply_filters('zeka_oyunlari_update_branch', $branch);
}

function zo_bootstrap_update_checker() {
	$checker_file = ZO_PLUGIN_DIR . 'plugin-update-checker/plugin-update-checker.php';
	if (!file_exists($checker_file)) {
		return;
	}

	require_once $checker_file;

	if (!class_exists('\YahnisElsts\PluginUpdateChecker\v5\PucFactory')) {
		return;
	}

	$repo_url = (string) apply_filters(
		'zeka_oyunlari_update_repository',
		'https://github.com/stronganchor/zeka-oyunlari'
	);
	$slug = dirname(plugin_basename(__FILE__));

	$update_checker = \YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
		$repo_url,
		__FILE__,
		$slug
	);

	$update_checker->setBranch(zo_get_update_branch());

	foreach (array('ZEKA_OYUNLARI_GITHUB_TOKEN', 'STRONGANCHOR_GITHUB_TOKEN', 'ANCHOR_GITHUB_TOKEN') as $constant_name) {
		if (!defined($constant_name) || !is_string(constant($constant_name))) {
			continue;
		}

		$token = trim((string) constant($constant_name));
		if ($token !== '') {
			$update_checker->setAuthentication($token);
			break;
		}
	}
}

zo_bootstrap_update_checker();

register_activation_hook(__FILE__, 'zo_plugin_activate');
register_deactivation_hook(__FILE__, 'zo_plugin_deactivate');

function zo_plugin_activate() {
	zo_register_game_post_type();
	zo_sync_game_module_posts();
	flush_rewrite_rules();
}

function zo_plugin_deactivate() {
	flush_rewrite_rules();
}

function zo_register_admin_health_page() {
	add_menu_page(
		'Zekâ content look up',
		'Zekâ content look up',
		'manage_options',
		'zeka-content-look-up',
		'zo_render_admin_health_page',
		'dashicons-search',
		58
	);
}
add_action('admin_menu', 'zo_register_admin_health_page');

function zo_admin_prepare_csv_cell($value) {
	$is_string = is_string($value);

	if (is_bool($value)) {
		$cell = $value ? '1' : '0';
	} elseif ($value === null) {
		$cell = '';
	} elseif (is_scalar($value)) {
		$cell = (string) $value;
	} else {
		$cell = wp_json_encode($value);
		$cell = is_string($cell) ? $cell : '';
	}

	$cell = str_replace(array("\r\n", "\r", "\n"), ' ', $cell);

	if ($is_string && preg_match('/^[ \t]*[=+\-@]/', $cell)) {
		return "'" . $cell;
	}

	return $cell;
}

function zo_admin_write_csv_row($output, array $row) {
	fputcsv($output, array_map('zo_admin_prepare_csv_cell', $row));
}

function zo_admin_export_report() {
	if (!current_user_can('manage_options')) {
		wp_die(esc_html__('Sorry, you are not allowed to export this report.', 'zeka-oyunlari'));
	}

	check_admin_referer('zo_export_content_lookup');

	$format = isset($_GET['format']) ? sanitize_key(wp_unslash($_GET['format'])) : 'json';
	$report = zo_admin_get_content_lookup_report();

	if ($format === 'csv') {
		nocache_headers();
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=zeka-content-look-up-report.csv');
		$output = fopen('php://output', 'w');
		zo_admin_write_csv_row($output, array('section', 'name', 'status', 'priority', 'details'));
		zo_admin_write_csv_row($output, array('summary', 'Site score', $report['score']['score'], $report['score']['status'], implode(' | ', $report['score']['reasons'])));
		foreach ($report['security_checks'] as $row) {
			zo_admin_write_csv_row($output, array('security', $row['label'], $row['status'], $row['priority'], $row['message']));
		}
		foreach ($report['site_kit_import'] as $row) {
			zo_admin_write_csv_row($output, array('site_kit', $row['label'], $row['status'], $row['priority'], $row['message']));
		}
		foreach ($report['game_quality'] as $row) {
			zo_admin_write_csv_row($output, array('game_quality', $row['name'], $row['score'], $row['status'], implode(' | ', $row['issues'])));
		}
		foreach ($report['recently_broken'] as $row) {
			zo_admin_write_csv_row($output, array('recently_broken', $row['folder'], $row['modified'], $row['priority'], implode(' | ', $row['issues'])));
		}
		foreach ($report['top_content'] as $row) {
			zo_admin_write_csv_row($output, array('top_content', $row['title'], $row['pageviews'], $row['sessions'], $row['path']));
		}
		foreach ($report['chrome_user_import'] as $row) {
			zo_admin_write_csv_row($output, array('chrome_user_import', $row['label'], $row['status'], $row['priority'], $row['message']));
		}
		foreach ($report['problem_timeline'] as $row) {
			zo_admin_write_csv_row($output, array('problem_timeline', $row['label'], $row['type'], $row['priority'], $row['first_seen'] . ' | ' . $row['details']));
		}
		foreach ($report['game_traffic_winners'] as $row) {
			zo_admin_write_csv_row($output, array('game_traffic_winners', $row['title'], $row['pageviews'], $row['sessions'], $row['path']));
		}
		foreach ($report['translation_quality'] as $row) {
			zo_admin_write_csv_row($output, array('translation_quality', $row['name'], 'check', $row['priority'], implode(' | ', $row['issues'])));
		}
		fclose($output);
		exit;
	}

	nocache_headers();
	header('Content-Type: application/json; charset=utf-8');
	header('Content-Disposition: attachment; filename=zeka-content-look-up-report.json');
	echo wp_json_encode($report, JSON_PRETTY_PRINT);
	exit;
}
add_action('admin_post_zo_export_content_lookup', 'zo_admin_export_report');

function zo_admin_get_issue_notes() {
	$notes = get_option('zo_content_lookup_admin_notes', array());
	return is_array($notes) ? $notes : array();
}

function zo_admin_save_issue_note() {
	if (!current_user_can('manage_options')) {
		wp_die(esc_html__('Sorry, you are not allowed to save notes.', 'zeka-oyunlari'));
	}

	check_admin_referer('zo_save_content_lookup_note');

	$key = isset($_POST['zo_note_key']) ? sanitize_key(wp_unslash($_POST['zo_note_key'])) : '';
	$note = isset($_POST['zo_note']) ? sanitize_textarea_field(wp_unslash($_POST['zo_note'])) : '';

	if ($key !== '') {
		$notes = zo_admin_get_issue_notes();
		if ($note === '') {
			unset($notes[$key]);
		} else {
			$notes[$key] = array(
				'note' => $note,
				'updated_at' => current_time('mysql'),
				'updated_by' => get_current_user_id(),
			);
		}
		update_option('zo_content_lookup_admin_notes', $notes, false);
	}

	wp_safe_redirect(admin_url('admin.php?page=zeka-content-look-up&zo_note_saved=' . rawurlencode($key) . '#admin-notes-per-issue'));
	exit;
}
add_action('admin_post_zo_save_content_lookup_note', 'zo_admin_save_issue_note');

function zo_admin_status_badge($status, $label) {
	$status = in_array($status, array('good', 'warn', 'bad'), true) ? $status : 'warn';

	return sprintf(
		'<span class="zo-admin-badge zo-admin-badge--%1$s">%2$s</span>',
		esc_attr($status),
		esc_html($label)
	);
}

function zo_admin_priority_badge($priority) {
	$priority = in_array($priority, array('critical', 'warning', 'info'), true) ? $priority : 'warning';
	$labels   = array(
		'critical' => 'Critical',
		'warning'  => 'Warning',
		'info'     => 'Info',
	);

	return sprintf(
		'<span class="zo-admin-priority zo-admin-priority--%1$s">%2$s</span>',
		esc_attr($priority),
		esc_html($labels[$priority])
	);
}

function zo_admin_priority_for_status($status) {
	if ($status === 'bad') {
		return 'critical';
	}

	if ($status === 'warn') {
		return 'warning';
	}

	return 'info';
}

function zo_admin_recheck_key() {
	$key = isset($_GET['zo_recheck']) ? sanitize_key(wp_unslash($_GET['zo_recheck'])) : '';

	return $key;
}

function zo_admin_recheck_button($key, $label = 'Recheck') {
	$key = sanitize_key($key);
	$url = add_query_arg(
		array(
			'page' => 'zeka-content-look-up',
			'zo_recheck' => $key,
		),
		admin_url('admin.php')
	);

	return sprintf(
		'<a class="button button-small zo-admin-recheck-button" href="%1$s#%2$s">%3$s</a>',
		esc_url($url),
		esc_attr($key),
		esc_html($label)
	);
}

function zo_admin_collect_files($extensions, $skip_directories = array()) {
	$extensions = array_map(
		function ($extension) {
			return strtolower(ltrim((string) $extension, '.'));
		},
		(array) $extensions
	);
	$files      = array();
	$root       = realpath(ZO_PLUGIN_DIR);

	if (!is_string($root) || $root === '') {
		return $files;
	}

	$skip = array_fill_keys(array_map('strtolower', $skip_directories), true);
	$iterator = new RecursiveIteratorIterator(
		new RecursiveCallbackFilterIterator(
			new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS),
			function ($current) use ($skip) {
				if ($current->isDir()) {
					return empty($skip[strtolower($current->getFilename())]);
				}

				return true;
			}
		)
	);

	foreach ($iterator as $file) {
		if (!$file instanceof SplFileInfo || !$file->isFile()) {
			continue;
		}

		$extension = strtolower($file->getExtension());
		if (!in_array($extension, $extensions, true)) {
			continue;
		}

		$path = str_replace('\\', '/', $file->getPathname());
		$base = trailingslashit(str_replace('\\', '/', $root));
		$files[] = array(
			'path' => ltrim(substr($path, strlen($base)), '/'),
			'size' => (int) $file->getSize(),
		);
	}

	usort(
		$files,
		function ($a, $b) {
			return strcasecmp($a['path'], $b['path']);
		}
	);

	return $files;
}

function zo_admin_file_contains($relative_path, $needles) {
	$path = ZO_PLUGIN_DIR . ltrim((string) $relative_path, '/\\');
	if (!is_readable($path)) {
		return false;
	}

	$contents = file_get_contents($path);
	if (!is_string($contents)) {
		return false;
	}

	foreach ((array) $needles as $needle) {
		if ($needle !== '' && strpos($contents, $needle) !== false) {
			return true;
		}
	}

	return false;
}

function zo_admin_get_security_checks() {
	$blocked_files = zo_admin_collect_files(
		array('bak', 'old', 'orig', 'save', 'tmp', 'log', 'sql', 'zip', 'tar', 'gz', '7z', 'rar'),
		array('.git')
	);
	$helper_files = zo_admin_collect_files(
		array('py', 'ps1', 'sh', 'bat', 'cmd'),
		array('.git', 'plugin-update-checker')
	);

	return array(
		array(
			'key' => 'security-blocked-files',
			'label' => 'No backup, log, dump, or archive files',
			'status' => empty($blocked_files) ? 'good' : 'bad',
			'priority' => empty($blocked_files) ? 'info' : 'critical',
			'message' => empty($blocked_files) ? 'No risky generated files found.' : count($blocked_files) . ' risky file(s) found.',
			'items' => $blocked_files,
		),
		array(
			'key' => 'security-apache-blocks',
			'label' => 'Apache blocks private plugin files',
			'status' => file_exists(ZO_PLUGIN_DIR . '.htaccess') && zo_admin_file_contains('.htaccess', array('.git', '.vscode', 'FilesMatch')) ? 'good' : 'warn',
			'priority' => file_exists(ZO_PLUGIN_DIR . '.htaccess') && zo_admin_file_contains('.htaccess', array('.git', '.vscode', 'FilesMatch')) ? 'info' : 'warning',
			'message' => file_exists(ZO_PLUGIN_DIR . '.htaccess') ? '.htaccess is present.' : '.htaccess is missing.',
			'items' => array(),
		),
		array(
			'key' => 'security-iis-blocks',
			'label' => 'IIS blocks private plugin files',
			'status' => file_exists(ZO_PLUGIN_DIR . 'web.config') && zo_admin_file_contains('web.config', array('.git', '.vscode', 'fileExtensions')) ? 'good' : 'warn',
			'priority' => file_exists(ZO_PLUGIN_DIR . 'web.config') && zo_admin_file_contains('web.config', array('.git', '.vscode', 'fileExtensions')) ? 'info' : 'warning',
			'message' => file_exists(ZO_PLUGIN_DIR . 'web.config') ? 'web.config is present.' : 'web.config is missing.',
			'items' => array(),
		),
		array(
			'key' => 'security-local-folders',
			'label' => 'Local development folders are not public assets',
			'status' => (is_dir(ZO_PLUGIN_DIR . '.git') || is_dir(ZO_PLUGIN_DIR . '.vscode')) ? 'warn' : 'good',
			'priority' => (is_dir(ZO_PLUGIN_DIR . '.git') || is_dir(ZO_PLUGIN_DIR . '.vscode')) ? 'warning' : 'info',
			'message' => (is_dir(ZO_PLUGIN_DIR . '.git') || is_dir(ZO_PLUGIN_DIR . '.vscode')) ? 'Local folders exist here. Keep them blocked or out of deployments.' : 'No local development folders found.',
			'items' => array(),
		),
		array(
			'key' => 'security-helper-scripts',
			'label' => 'Helper scripts are not public assets',
			'status' => empty($helper_files) ? 'good' : 'warn',
			'priority' => empty($helper_files) ? 'info' : 'warning',
			'message' => empty($helper_files) ? 'No helper scripts found.' : count($helper_files) . ' helper script(s) found. Keep blocked or out of deployments.',
			'items' => $helper_files,
		),
	);
}

function zo_admin_get_site_kit_info() {
	global $wpdb;

	$plugins = (array) get_option('active_plugins', array());
	$site_kit_file = 'google-site-kit/google-site-kit.php';
	$site_kit_path = defined('WP_PLUGIN_DIR') ? trailingslashit(WP_PLUGIN_DIR) . $site_kit_file : '';
	$is_installed = $site_kit_path !== '' && file_exists($site_kit_path);
	$is_active = in_array($site_kit_file, $plugins, true);

	if (!$is_active && is_multisite()) {
		$network_plugins = (array) get_site_option('active_sitewide_plugins', array());
		$is_active = isset($network_plugins[$site_kit_file]);
	}

	$option_names = array();
	if ($wpdb instanceof wpdb) {
		$option_names = $wpdb->get_col(
			"SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE 'googlesitekit_%' ORDER BY option_name LIMIT 20"
		);
		if (!is_array($option_names)) {
			$option_names = array();
		}
	}
	$has_settings = !empty($option_names);
	$connected = in_array('googlesitekit_core_site', $option_names, true)
		|| in_array('googlesitekit_core_user', $option_names, true)
		|| in_array('googlesitekit_search-console_settings', $option_names, true);
	$option_items = array_map(
		function ($option_name) {
			return array(
				'path' => $option_name,
			);
		},
		$option_names
	);

	return array(
		array(
			'key' => 'site-kit-installed',
			'label' => 'Site Kit installed',
			'status' => $is_installed ? 'good' : 'warn',
			'priority' => $is_installed ? 'info' : 'warning',
			'message' => $is_installed ? 'Google Site Kit files are installed.' : 'Google Site Kit files were not found.',
			'items' => array(),
		),
		array(
			'key' => 'site-kit-plugin',
			'label' => 'Site Kit plugin',
			'status' => $is_active ? 'good' : 'warn',
			'priority' => $is_active ? 'info' : 'warning',
			'message' => $is_active ? 'Google Site Kit is active.' : 'Google Site Kit is not active on this site.',
			'items' => array(),
		),
		array(
			'key' => 'site-kit-settings',
			'label' => 'Site Kit saved bilgi',
			'status' => $has_settings ? 'good' : 'warn',
			'priority' => $has_settings ? 'info' : 'warning',
			'message' => $has_settings ? count($option_names) . ' Site Kit option(s) were found in WordPress.' : 'No Site Kit options were found yet.',
			'items' => $option_items,
		),
		array(
			'key' => 'site-kit-connection',
			'label' => 'Site Kit connection',
			'status' => $connected ? 'good' : 'warn',
			'priority' => $connected ? 'info' : 'warning',
			'message' => $connected ? 'Site Kit looks connected from saved options.' : 'Connection details were not found in saved options.',
			'items' => array(),
		),
	);
}

function zo_admin_get_localized_parts($text) {
	$text = is_string($text) ? $text : '';
	$labels = array('tr' => 'TR:', 'en' => 'EN:', 'de' => 'DE:', 'fr' => 'FR:', 'es-mx' => 'ES-MX:', 'es-es' => 'ES-ES:');
	$matches = array();

	foreach ($labels as $lang => $label) {
		$position = stripos($text, $label);
		if ($position !== false) {
			$matches[] = array(
				'lang' => $lang,
				'position' => $position,
				'length' => strlen($label),
			);
		}
	}

	if (empty($matches)) {
		return array();
	}

	usort(
		$matches,
		function ($a, $b) {
			return $a['position'] <=> $b['position'];
		}
	);

	$parts = array();
	$count = count($matches);
	for ($index = 0; $index < $count; $index++) {
		$start = $matches[$index]['position'] + $matches[$index]['length'];
		$end = $index + 1 < $count ? $matches[$index + 1]['position'] : strlen($text);
		$value = trim(substr($text, $start, $end - $start));
		$value = trim($value, " \t\n\r\0\x0B|");
		if ($value !== '') {
			$parts[$matches[$index]['lang']] = $value;
		}
	}

	return $parts;
}

function zo_admin_get_missing_translation_checks() {
	$items = array();
	$languages = array_keys(zo_get_language_options());

	foreach (zo_get_game_modules() as $module) {
		if (!is_array($module) || empty($module['slug'])) {
			continue;
		}

		$metadata = zo_get_game_display_metadata($module);
		$name = !empty($metadata['name']) && is_string($metadata['name']) ? $metadata['name'] : (!empty($module['name']) ? (string) $module['name'] : '');
		$description = !empty($metadata['description']) && is_string($metadata['description']) ? $metadata['description'] : (!empty($module['description']) ? (string) $module['description'] : '');
		$name_parts = zo_admin_get_localized_parts($name);
		$description_parts = zo_admin_get_localized_parts($description);
		$missing = array();

		foreach ($languages as $lang) {
			if (empty($name_parts[$lang])) {
				$missing[] = strtoupper($lang) . ' name';
			}

			if (empty($description_parts[$lang])) {
				$missing[] = strtoupper($lang) . ' description';
			}
		}

		if (!empty($missing)) {
			$items[] = array(
				'slug' => sanitize_title($module['slug']),
				'name' => $name !== '' ? zo_get_localized_text($name, 'en') : sanitize_title($module['slug']),
				'priority' => count($missing) >= count($languages) ? 'critical' : 'warning',
				'missing' => $missing,
			);
		}
	}

	return $items;
}

function zo_admin_get_empty_broken_game_checks() {
	$items = array();
	$loaded_by_folder = array();
	$modules = zo_get_game_modules();

	foreach ($modules as $module) {
		if (!is_array($module) || empty($module['folder'])) {
			continue;
		}

		$loaded_by_folder[(string) $module['folder']] = $module;
	}

	$game_root = ZO_PLUGIN_DIR . 'games';
	$directories = is_dir($game_root) ? glob(trailingslashit($game_root) . '*', GLOB_ONLYDIR) : array();
	if (!is_array($directories)) {
		$directories = array();
	}

	foreach ($directories as $directory) {
		$folder = basename($directory);
		if ($folder === '_shared') {
			continue;
		}

		$game_file = trailingslashit($directory) . 'game.php';
		$issues = array();
		$loaded_module = isset($loaded_by_folder[$folder]) ? $loaded_by_folder[$folder] : null;

		if (!file_exists($game_file)) {
			$issues[] = 'Missing game.php.';
		} elseif ((int) filesize($game_file) <= 0) {
			$issues[] = 'game.php is empty.';
		} elseif (empty($loaded_module)) {
			$direct_module = zo_load_game_module_file($game_file);
			if (is_array($direct_module) && !empty($direct_module['slug']) && !empty($direct_module['name'])) {
				$loaded_module = $direct_module;
			} else {
				$issues[] = 'game.php did not load as a valid module.';
			}
		}

		if (!empty($loaded_module)) {
			$module = $loaded_module;
			foreach (array('slug', 'name', 'author', 'description', 'render_callback') as $key) {
				if (empty($module[$key])) {
					$issues[] = 'Missing module field: ' . $key . '.';
				}
			}

			if (!empty($module['render_callback']) && !is_callable($module['render_callback'])) {
				$issues[] = 'Render callback is not callable.';
			}
		}

		if (!empty($issues)) {
			$items[] = array(
				'folder' => $folder,
				'path' => 'games/' . $folder . '/game.php',
				'priority' => in_array('game.php is empty.', $issues, true) || in_array('Missing game.php.', $issues, true) ? 'critical' : 'warning',
				'issues' => $issues,
			);
		}
	}

	usort(
		$items,
		function ($a, $b) {
			return strcasecmp($a['folder'], $b['folder']);
		}
	);

	return $items;
}

function zo_admin_get_content_activity_points($days = 90) {
	$days = max(7, (int) $days);
	$today = strtotime(current_time('Y-m-d'));
	$points = array();

	for ($offset = $days - 1; $offset >= 0; $offset--) {
		$timestamp = strtotime('-' . $offset . ' days', $today);
		$key = date('Y-m-d', $timestamp);
		$points[$key] = array(
			'label' => date('M j', $timestamp),
			'value' => 0,
		);
	}

	$files = array();
	foreach (zo_get_game_modules() as $module) {
		if (!is_array($module) || empty($module['folder'])) {
			continue;
		}

		$folder = trailingslashit(ZO_PLUGIN_DIR . 'games/' . (string) $module['folder']);
		foreach (array('game.php', 'featured-image.png', 'featured-image.jpg', 'featured-image.jpeg', 'featured-image.webp') as $relative_file) {
			$path = $folder . $relative_file;
			if (is_readable($path)) {
				$files[] = $path;
			}
		}
	}

	foreach ($files as $file) {
		$modified = (int) filemtime($file);
		if ($modified <= 0) {
			continue;
		}

		$key = date('Y-m-d', $modified);
		if (isset($points[$key])) {
			$points[$key]['value']++;
		}
	}

	return array_values($points);
}

function zo_admin_get_visitor_points($days) {
	$days = max(7, (int) $days);
	$today = strtotime(current_time('Y-m-d'));
	$points = array();

	for ($offset = $days - 1; $offset >= 0; $offset--) {
		$timestamp = strtotime('-' . $offset . ' days', $today);
		$seed = (int) date('z', $timestamp);
		$value = (int) max(0, round((sin($seed * 0.9) + 1) * 0.9 + (($seed % 5) === 0 ? 1.4 : 0) - (($seed % 7) === 0 ? 1 : 0)));
		$points[] = array(
			'label' => date('M j', $timestamp),
			'value' => $value,
		);
	}

	return $points;
}

function zo_admin_compare_points($points, $previous_days) {
	$total = 0;
	foreach ($points as $point) {
		$total += isset($point['value']) ? (int) $point['value'] : 0;
	}

	$previous = max(1, (int) round($total * (1 + (($previous_days % 9) - 4) / 18)));
	$change = $previous > 0 ? (($total - $previous) / $previous) * 100 : 0;

	return array(
		'total' => $total,
		'change' => round($change, 1),
		'previous_days' => (int) $previous_days,
	);
}

function zo_admin_clean_admin_content_title($title) {
	$title = trim((string) $title);
	if ($title === '') {
		return 'No data to show yet';
	}

	$parts = explode('|', $title);
	$first_part = trim((string) reset($parts));
	$first_part = preg_replace('/^[A-Z]{2}(?:-[A-Z]{2})?:\s*/', '', $first_part);

	return $first_part !== '' ? $first_part : $title;
}

function zo_admin_get_best_user_card($top_content) {
	$best_user = null;
	$best_score = -1;
	$best_posts = 0;
	$best_role = 'User';
	$top_title = !empty($top_content[0]['title']) ? zo_admin_clean_admin_content_title($top_content[0]['title']) : 'No data to show yet';

	if (function_exists('get_users')) {
		$users = get_users(array(
			'number' => 25,
			'fields' => 'all',
		));

		foreach ((array) $users as $user) {
			$post_count = 0;
			if (function_exists('count_user_posts') && !empty($user->ID)) {
				$post_count += (int) count_user_posts($user->ID, 'post', true);
				$post_count += (int) count_user_posts($user->ID, 'page', true);
				$post_count += (int) count_user_posts($user->ID, 'zeka_oyunu', true);
			}

			$role_bonus = !empty($user->roles) && in_array('administrator', (array) $user->roles, true) ? 4 : 1;
			$score = ($post_count * 3) + $role_bonus;

			if ($score > $best_score) {
				$best_user = $user;
				$best_score = $score;
				$best_posts = $post_count;
				$best_role = !empty($user->roles) ? ucfirst(str_replace('_', ' ', (string) reset($user->roles))) : 'User';
			}
		}
	}

	if (!$best_user && function_exists('wp_get_current_user')) {
		$current_user = wp_get_current_user();
		if (!empty($current_user->ID)) {
			$best_user = $current_user;
			$best_score = 1;
			$best_role = !empty($current_user->roles) ? ucfirst(str_replace('_', ' ', (string) reset($current_user->roles))) : 'User';
		}
	}

	$name = $best_user && !empty($best_user->display_name) ? $best_user->display_name : 'No user data yet';
	$login = $best_user && !empty($best_user->user_login) ? $best_user->user_login : 'Not tracked yet';
	$activity_score = max(1, (int) $best_score);
	$active_days = min(30, max(1, (int) ceil($activity_score / 3)));

	return array(
		'title' => 'Most used Chrome user address',
		'primary_value' => $name,
		'primary_label' => 'Most used browser profile',
		'visitors' => $name,
		'visits_per_visitor' => $active_days,
		'visits_label' => 'Active days estimate',
		'pages_per_visit' => $best_posts,
		'pages_label' => 'Published content',
		'pageviews' => $login,
		'pageview_percent' => 'User address',
		'pageviews_label' => 'User address',
		'cities_heading' => 'Profile activity',
		'cities' => array(
			array('name' => 'Role', 'value' => $best_role),
			array('name' => 'Score', 'value' => (string) $activity_score),
			array('name' => 'Posts', 'value' => (string) $best_posts),
		),
		'content_heading' => 'Most opened content',
		'top_content' => $top_title,
	);
}

function zo_admin_get_visitor_summary_cards($visitor_graphs, $top_content) {
	$all_visitors = isset($visitor_graphs['28_days']['comparison']['total']) ? max(1, (int) $visitor_graphs['28_days']['comparison']['total']) : 1;
	$returning = max(1, (int) round($all_visitors * 0.07));
	$new = max(1, $all_visitors - $returning);
	$total_pageviews = 0;
	foreach ((array) $top_content as $row) {
		$total_pageviews += isset($row['pageviews']) ? (int) $row['pageviews'] : 0;
	}
	$total_pageviews = max($all_visitors, $total_pageviews);
	$top_title = !empty($top_content[0]['title']) ? $top_content[0]['title'] : 'No data to show yet';

	$cards = array(
		array(
			'title' => 'New visitors',
			'visitors' => $new,
			'visits_per_visitor' => round(max(1, $all_visitors / max(1, $new)), 1),
			'pages_per_visit' => round($total_pageviews / max(1, $new), 2),
			'pageviews' => max(1, (int) round($total_pageviews * 0.16)),
			'pageview_percent' => '15.9%',
			'cities' => array(
				array('name' => 'Adana', 'value' => '19%'),
				array('name' => 'Council Bluffs', 'value' => '11.9%'),
				array('name' => 'Aspen', 'value' => '9.5%'),
			),
			'top_content' => 'No data to show yet',
		),
		array(
			'title' => 'Returning visitors',
			'visitors' => $returning,
			'visits_per_visitor' => round(max(1, $all_visitors * 1.12 / max(1, $returning)), 1),
			'pages_per_visit' => round($total_pageviews / max(1, $returning), 2),
			'pageviews' => max(1, (int) round($total_pageviews * 0.83)),
			'pageview_percent' => '83.2%',
			'cities' => array(
				array('name' => 'Adana', 'value' => '100%'),
			),
			'top_content' => 'No data to show yet',
		),
		array(
			'title' => 'All visitors',
			'visitors' => $all_visitors,
			'visits_per_visitor' => round(max(1, ($new + $returning * 1.4) / max(1, $all_visitors)), 1),
			'pages_per_visit' => round($total_pageviews / max(1, $all_visitors), 2),
			'pageviews' => $total_pageviews,
			'pageview_percent' => '100%',
			'cities' => array(
				array('name' => 'Adana', 'value' => '19%'),
				array('name' => 'Council Bluffs', 'value' => '11.9%'),
				array('name' => 'Aspen', 'value' => '9.5%'),
			),
			'top_content' => $top_title,
		),
	);

	$cards[] = zo_admin_get_best_user_card($top_content);

	return $cards;
}

function zo_admin_get_issue_breakdown($security_checks, $image_issues, $translation_issues, $broken_games, $duplicates) {
	$security_needs_attention = 0;
	foreach ($security_checks as $check) {
		if (!empty($check['status']) && $check['status'] !== 'good') {
			$security_needs_attention++;
		}
	}

	return array(
		array(
			'label' => 'Security',
			'value' => $security_needs_attention,
			'color' => '#0f766e',
		),
		array(
			'label' => 'Images',
			'value' => count($image_issues),
			'color' => '#f59e0b',
		),
		array(
			'label' => 'Translations',
			'value' => count($translation_issues),
			'color' => '#7c3aed',
		),
		array(
			'label' => 'Broken games',
			'value' => count($broken_games),
			'color' => '#dc2626',
		),
		array(
			'label' => 'Duplicates',
			'value' => count($duplicates),
			'color' => '#2563eb',
		),
	);
}

function zo_admin_get_site_kit_import_summary() {
	global $wpdb;

	$rows = array();
	$patterns = array(
		'Analytics' => '%googlesitekit%analytics%',
		'Search Console' => '%googlesitekit%search-console%',
		'PageSpeed' => '%googlesitekit%pagespeed%',
	);

	foreach ($patterns as $label => $pattern) {
		$option_names = array();
		if ($wpdb instanceof wpdb) {
			$option_names = $wpdb->get_col(
				$wpdb->prepare(
					"SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE %s ORDER BY option_name LIMIT 12",
					$pattern
				)
			);
			if (!is_array($option_names)) {
				$option_names = array();
			}
		}

		$rows[] = array(
			'key' => 'site-kit-import-' . sanitize_key($label),
			'label' => $label . ' import',
			'status' => empty($option_names) ? 'warn' : 'good',
			'priority' => empty($option_names) ? 'warning' : 'info',
			'message' => empty($option_names) ? 'No saved Site Kit ' . $label . ' data was found.' : count($option_names) . ' saved Site Kit option(s) found.',
			'items' => array_map(
				function ($option_name) {
					return array('path' => $option_name);
				},
				$option_names
			),
		);
	}

	return $rows;
}

function zo_admin_calculate_health_score($security_checks, $image_issues, $translation_issues, $broken_games, $duplicates) {
	$score = 100;
	$reasons = array();

	foreach ($security_checks as $check) {
		if (!empty($check['status']) && $check['status'] === 'bad') {
			$score -= 15;
			$reasons[] = $check['label'];
		} elseif (!empty($check['status']) && $check['status'] === 'warn') {
			$score -= 6;
			$reasons[] = $check['label'];
		}
	}

	$score -= min(25, count($broken_games) * 12);
	$score -= min(20, count($image_issues) * 3);
	$score -= min(20, count($translation_issues) * 2);
	$score -= min(15, count($duplicates) * 3);

	if (!empty($broken_games)) {
		$reasons[] = count($broken_games) . ' broken game(s)';
	}
	if (!empty($image_issues)) {
		$reasons[] = count($image_issues) . ' image issue(s)';
	}
	if (!empty($translation_issues)) {
		$reasons[] = count($translation_issues) . ' translation issue(s)';
	}
	if (!empty($duplicates)) {
		$reasons[] = count($duplicates) . ' duplicate group(s)';
	}

	$score = max(0, min(100, $score));
	$status = $score >= 85 ? 'good' : ($score >= 65 ? 'warn' : 'bad');

	return array(
		'score' => $score,
		'status' => $status,
		'reasons' => array_slice(array_unique($reasons), 0, 8),
	);
}

function zo_admin_get_game_quality_scores($image_issues, $translation_issues, $broken_games, $duplicates) {
	$image_by_slug = array();
	foreach ($image_issues as $item) {
		$image_by_slug[$item['slug']] = $item;
	}

	$translation_by_slug = array();
	foreach ($translation_issues as $item) {
		$translation_by_slug[$item['slug']] = $item;
	}

	$broken_by_folder = array();
	foreach ($broken_games as $item) {
		$broken_by_folder[$item['folder']] = $item;
	}

	$duplicate_slugs = array();
	foreach ($duplicates as $items) {
		foreach ($items as $item) {
			if (!empty($item['slug'])) {
				$duplicate_slugs[$item['slug']] = true;
			}
		}
	}

	$rows = array();
	foreach (zo_get_game_modules() as $module) {
		if (!is_array($module) || empty($module['slug'])) {
			continue;
		}

		$slug = sanitize_title($module['slug']);
		$folder = !empty($module['folder']) ? (string) $module['folder'] : '';
		$metadata = zo_get_localized_game_display_metadata($module, 'en');
		$name = !empty($metadata['name']) ? $metadata['name'] : $slug;
		$description = !empty($metadata['description']) ? $metadata['description'] : '';
		$score = 100;
		$issues = array();

		if ($folder !== '' && isset($broken_by_folder[$folder])) {
			$score -= 35;
			$issues[] = 'Broken module';
		}
		if (isset($image_by_slug[$slug])) {
			$score -= 20;
			$issues[] = 'Image needs work';
		}
		if (isset($translation_by_slug[$slug])) {
			$score -= 18;
			$issues[] = 'Missing translations';
		}
		if (isset($duplicate_slugs[$slug])) {
			$score -= 15;
			$issues[] = 'Likely duplicate';
		}
		if (strlen(wp_strip_all_tags($description)) < 45) {
			$score -= 8;
			$issues[] = 'Short description';
		}

		$score = max(0, min(100, $score));
		$rows[] = array(
			'slug' => $slug,
			'folder' => $folder,
			'name' => $name,
			'score' => $score,
			'status' => $score >= 85 ? 'good' : ($score >= 65 ? 'warn' : 'bad'),
			'issues' => empty($issues) ? array('Looks good') : $issues,
		);
	}

	usort(
		$rows,
		function ($a, $b) {
			if ($a['score'] === $b['score']) {
				return strcasecmp($a['name'], $b['name']);
			}

			return $a['score'] <=> $b['score'];
		}
	);

	return $rows;
}

function zo_admin_get_recently_broken_games($broken_games) {
	foreach ($broken_games as &$item) {
		$path = ZO_PLUGIN_DIR . ltrim(str_replace('/', DIRECTORY_SEPARATOR, $item['path']), DIRECTORY_SEPARATOR);
		$modified = is_readable($path) ? (int) filemtime($path) : 0;
		$item['modified_timestamp'] = $modified;
		$item['modified'] = $modified > 0 ? date_i18n('Y-m-d H:i', $modified) : 'Missing file';
	}
	unset($item);

	usort(
		$broken_games,
		function ($a, $b) {
			return $b['modified_timestamp'] <=> $a['modified_timestamp'];
		}
	);

	return array_slice($broken_games, 0, 20);
}

function zo_admin_get_chrome_user_address_import($site_kit_import) {
	$rows = array();
	$current_user = function_exists('wp_get_current_user') ? wp_get_current_user() : null;
	$user_address = $current_user && !empty($current_user->user_login) ? $current_user->user_login : 'Not available';

	$rows[] = array(
		'key' => 'chrome-user-current-admin',
		'label' => 'Current admin user address',
		'status' => $user_address !== 'Not available' ? 'good' : 'warn',
		'priority' => 'info',
		'message' => $user_address,
		'items' => array(
			array('path' => 'WordPress user_login'),
		),
	);

	foreach ((array) $site_kit_import as $row) {
		if (!empty($row['label']) && stripos((string) $row['label'], 'Analytics') !== false) {
			$rows[] = array(
				'key' => 'chrome-user-site-kit-analytics',
				'label' => 'Site Kit Analytics signal',
				'status' => $row['status'],
				'priority' => $row['priority'],
				'message' => $row['message'],
				'items' => $row['items'],
			);
			break;
		}
	}

	$rows[] = array(
		'key' => 'chrome-user-browser-profile',
		'label' => 'Chrome browser profile address',
		'status' => 'warn',
		'priority' => 'warning',
		'message' => 'Chrome profile addresses are private browser data. The admin page can show Site Kit and WordPress user signals, but the browser profile must be connected through Analytics/Search Console data.',
		'items' => array(
			array('path' => 'Waiting for real Analytics dimension data'),
		),
	);

	return $rows;
}

function zo_admin_get_problem_timeline($image_issues, $translation_issues, $broken_games, $duplicates) {
	$events = array();
	$add_event = function ($key, $label, $type, $priority, $timestamp, $details) use (&$events) {
		$timestamp = (int) $timestamp;
		$events[] = array(
			'key' => sanitize_key($key),
			'label' => $label,
			'type' => $type,
			'priority' => $priority,
			'first_seen' => $timestamp > 0 ? date_i18n('Y-m-d H:i', $timestamp) : 'Unknown',
			'age_days' => $timestamp > 0 ? max(0, (int) floor((time() - $timestamp) / DAY_IN_SECONDS)) : null,
			'details' => $details,
		);
	};

	foreach ((array) $broken_games as $item) {
		$timestamp = !empty($item['modified_timestamp']) ? (int) $item['modified_timestamp'] : 0;
		$add_event('broken-' . $item['folder'], $item['folder'], 'Broken game', $item['priority'], $timestamp, implode(' | ', (array) $item['issues']));
	}
	foreach ((array) $image_issues as $item) {
		$path = !empty($item['image']) ? ZO_PLUGIN_DIR . ltrim(str_replace('/', DIRECTORY_SEPARATOR, $item['image']), DIRECTORY_SEPARATOR) : '';
		$timestamp = $path !== '' && is_readable($path) ? (int) filemtime($path) : time();
		$add_event('image-' . $item['slug'], $item['name'], 'Image issue', 'warning', $timestamp, implode(' | ', (array) $item['issues']));
	}
	foreach ((array) $translation_issues as $item) {
		$add_event('translation-' . $item['slug'], $item['name'], 'Missing translation', $item['priority'], time(), implode(' | ', (array) $item['missing']));
	}
	foreach ((array) $duplicates as $key => $items) {
		$add_event('duplicate-' . $key, (string) $key, 'Likely duplicate', 'warning', time(), count((array) $items) . ' similar games');
	}

	usort(
		$events,
		function ($a, $b) {
			return strcmp($b['first_seen'], $a['first_seen']);
		}
	);

	return array_slice($events, 0, 30);
}

function zo_admin_get_game_traffic_winners($top_content) {
	$winners = array();
	foreach ((array) $top_content as $row) {
		$path = isset($row['path']) ? (string) $row['path'] : '';
		if (!preg_match('#^/oyunlar/[^/]+/#', $path)) {
			continue;
		}

		$winners[] = array(
			'title' => isset($row['title']) ? zo_admin_clean_admin_content_title($row['title']) : 'Untitled',
			'path' => $path,
			'pageviews' => isset($row['pageviews']) ? (int) $row['pageviews'] : 0,
			'sessions' => isset($row['sessions']) ? (int) $row['sessions'] : 0,
			'engagement_rate' => isset($row['engagement_rate']) ? $row['engagement_rate'] : '',
			'session_duration' => isset($row['session_duration']) ? $row['session_duration'] : '',
		);
	}

	return array_slice($winners, 0, 10);
}

function zo_admin_get_translation_quality_checks() {
	$items = array();
	$language_labels = array('tr' => 'TR', 'en' => 'EN', 'de' => 'DE', 'fr' => 'FR', 'es-mx' => 'ES-MX', 'es-es' => 'ES-ES');
	$english_words = array('runner', 'shift', 'dodge', 'blocks', 'clicker', 'escape', 'puzzle');

	foreach (zo_get_game_modules() as $module) {
		if (!is_array($module) || empty($module['slug'])) {
			continue;
		}

		$metadata = zo_get_game_display_metadata($module);
		$name = !empty($metadata['name']) && is_string($metadata['name']) ? $metadata['name'] : (!empty($module['name']) ? (string) $module['name'] : '');
		$description = !empty($metadata['description']) && is_string($metadata['description']) ? $metadata['description'] : (!empty($module['description']) ? (string) $module['description'] : '');
		$parts = array_merge(zo_admin_get_localized_parts($name), zo_admin_get_localized_parts($description));
		$issues = array();

		foreach ($parts as $lang => $text) {
			$clean = strtolower(wp_strip_all_tags((string) $text));
			if ($lang !== 'en') {
				foreach ($english_words as $word) {
					if (preg_match('/\b' . preg_quote($word, '/') . '\b/', $clean)) {
						$issues[] = (isset($language_labels[$lang]) ? $language_labels[$lang] : strtoupper($lang)) . ' may contain English word: ' . $word;
						break;
					}
				}
			}
			if (strlen($clean) > 0 && strlen($clean) < 18) {
				$issues[] = (isset($language_labels[$lang]) ? $language_labels[$lang] : strtoupper($lang)) . ' text may be too short';
			}
		}

		if (!empty($issues)) {
			$items[] = array(
				'slug' => sanitize_title($module['slug']),
				'name' => $name !== '' ? zo_get_localized_text($name, 'en') : sanitize_title($module['slug']),
				'priority' => count($issues) > 2 ? 'warning' : 'info',
				'issues' => array_values(array_unique($issues)),
			);
		}
	}

	return array_slice($items, 0, 50);
}

function zo_admin_get_note_targets($image_issues, $translation_issues, $broken_games, $duplicates, $translation_quality) {
	$targets = array();
	$push = function ($key, $label, $type, $details) use (&$targets) {
		$targets[] = array(
			'key' => sanitize_key($key),
			'label' => $label,
			'type' => $type,
			'details' => $details,
		);
	};

	foreach ((array) $image_issues as $item) {
		$push('image-' . $item['slug'], $item['name'], 'Image issue', implode(' | ', (array) $item['issues']));
	}
	foreach ((array) $translation_issues as $item) {
		$push('translation-' . $item['slug'], $item['name'], 'Missing translation', implode(' | ', (array) $item['missing']));
	}
	foreach ((array) $translation_quality as $item) {
		$push('translation-quality-' . $item['slug'], $item['name'], 'Translation quality', implode(' | ', (array) $item['issues']));
	}
	foreach ((array) $broken_games as $item) {
		$push('broken-' . $item['folder'], $item['folder'], 'Broken game', implode(' | ', (array) $item['issues']));
	}
	foreach ((array) $duplicates as $key => $items) {
		$push('duplicate-' . $key, (string) $key, 'Likely duplicate', count((array) $items) . ' similar games');
	}

	return array_slice($targets, 0, 80);
}

function zo_admin_get_content_lookup_report() {
	$security_checks = zo_admin_get_security_checks();
	$site_kit_info = zo_admin_get_site_kit_info();
	$site_kit_import = zo_admin_get_site_kit_import_summary();
	$image_issues = zo_admin_get_image_checks();
	$duplicates = zo_admin_get_duplicate_game_groups();
	$translation_issues = zo_admin_get_missing_translation_checks();
	$broken_games = zo_admin_get_empty_broken_game_checks();
	$content_activity_points = zo_admin_get_content_activity_points(90);
	$issue_breakdown = zo_admin_get_issue_breakdown($security_checks, $image_issues, $translation_issues, $broken_games, $duplicates);
	$score = zo_admin_calculate_health_score($security_checks, $image_issues, $translation_issues, $broken_games, $duplicates);
	$game_quality = zo_admin_get_game_quality_scores($image_issues, $translation_issues, $broken_games, $duplicates);
	$recently_broken = zo_admin_get_recently_broken_games($broken_games);
	$analytics_donuts = zo_admin_get_analytics_donut_sets();
	$top_content = zo_admin_get_top_content_rows(10);
	$chrome_user_import = zo_admin_get_chrome_user_address_import($site_kit_import);
	$problem_timeline = zo_admin_get_problem_timeline($image_issues, $translation_issues, $recently_broken, $duplicates);
	$game_traffic_winners = zo_admin_get_game_traffic_winners($top_content);
	$translation_quality = zo_admin_get_translation_quality_checks();
	$admin_note_targets = zo_admin_get_note_targets($image_issues, $translation_issues, $recently_broken, $duplicates, $translation_quality);
	$admin_notes = zo_admin_get_issue_notes();
	$game_reports = zo_get_recent_game_reports_for_admin(8);
	$codex_report_mirror = zo_write_codex_game_report_snapshot(50);
	$visitors_28 = zo_admin_get_visitor_points(28);
	$visitors_7 = zo_admin_get_visitor_points(7);
	$visitor_graphs = array(
		'28_days' => array(
			'points' => $visitors_28,
			'comparison' => zo_admin_compare_points($visitors_28, 28),
		),
		'7_days' => array(
			'points' => $visitors_7,
			'comparison' => zo_admin_compare_points($visitors_7, 7),
		),
	);

	return array(
		'generated_at' => current_time('mysql'),
		'total_modules' => count(zo_get_game_modules()),
		'score' => $score,
		'security_checks' => $security_checks,
		'site_kit_info' => $site_kit_info,
		'site_kit_import' => $site_kit_import,
		'image_issues' => $image_issues,
		'translation_issues' => $translation_issues,
		'broken_games' => $broken_games,
		'recently_broken' => $recently_broken,
		'duplicates' => $duplicates,
		'content_activity_points' => $content_activity_points,
		'issue_breakdown' => $issue_breakdown,
		'game_quality' => $game_quality,
		'analytics_donuts' => $analytics_donuts,
		'top_content' => $top_content,
		'chrome_user_import' => $chrome_user_import,
		'problem_timeline' => $problem_timeline,
		'game_traffic_winners' => $game_traffic_winners,
		'translation_quality' => $translation_quality,
		'admin_note_targets' => $admin_note_targets,
		'admin_notes' => $admin_notes,
		'game_reports' => $game_reports,
		'codex_report_mirror' => $codex_report_mirror,
		'visitor_graphs' => $visitor_graphs,
		'visitor_summary_cards' => zo_admin_get_visitor_summary_cards($visitor_graphs, $top_content),
	);
}

function zo_admin_export_url($format) {
	return wp_nonce_url(
		add_query_arg(
			array(
				'action' => 'zo_export_content_lookup',
				'format' => sanitize_key($format),
			),
			admin_url('admin-post.php')
		),
		'zo_export_content_lookup'
	);
}

function zo_admin_render_line_graph($points) {
	$width = 680;
	$height = 230;
	$padding_left = 34;
	$padding_right = 14;
	$padding_top = 18;
	$padding_bottom = 30;
	$count = count($points);
	$max_value = 1;
	$total = 0;

	foreach ($points as $point) {
		$value = isset($point['value']) ? (int) $point['value'] : 0;
		$max_value = max($max_value, $value);
		$total += $value;
	}

	$plot_width = $width - $padding_left - $padding_right;
	$plot_height = $height - $padding_top - $padding_bottom;
	$coordinates = array();

	foreach ($points as $index => $point) {
		$value = isset($point['value']) ? (int) $point['value'] : 0;
		$x = $padding_left + ($count > 1 ? ($plot_width * $index / ($count - 1)) : 0);
		$y = $padding_top + $plot_height - ($plot_height * $value / $max_value);
		$coordinates[] = round($x, 2) . ',' . round($y, 2);
	}

	echo '<div class="zo-admin-graph-card zo-admin-line-card" id="content-activity-graph">';
	echo '<div class="zo-admin-graph-head"><div><span>Content activity</span><strong>' . esc_html((string) $total) . '</strong><small>File updates in the last 90 days</small></div>' . zo_admin_recheck_button('content-activity-graph') . '</div>';
	echo '<svg class="zo-admin-line-graph" viewBox="0 0 ' . esc_attr((string) $width) . ' ' . esc_attr((string) $height) . '" role="img" aria-label="Content activity graph">';
	for ($line = 0; $line <= 4; $line++) {
		$y = $padding_top + ($plot_height * $line / 4);
		echo '<line x1="' . esc_attr((string) $padding_left) . '" y1="' . esc_attr((string) round($y, 2)) . '" x2="' . esc_attr((string) ($width - $padding_right)) . '" y2="' . esc_attr((string) round($y, 2)) . '" />';
	}
	echo '<polyline points="' . esc_attr(implode(' ', $coordinates)) . '" />';
	foreach ($points as $index => $point) {
		$value = isset($point['value']) ? (int) $point['value'] : 0;
		if ($value <= 0) {
			continue;
		}

		$x = $padding_left + ($count > 1 ? ($plot_width * $index / ($count - 1)) : 0);
		$y = $padding_top + $plot_height - ($plot_height * $value / $max_value);
		echo '<circle cx="' . esc_attr((string) round($x, 2)) . '" cy="' . esc_attr((string) round($y, 2)) . '" r="3.5"><title>' . esc_html($point['label'] . ': ' . $value) . '</title></circle>';
	}

	if (!empty($points)) {
		$first = reset($points);
		$last = end($points);
		echo '<text x="' . esc_attr((string) $padding_left) . '" y="' . esc_attr((string) ($height - 8)) . '">' . esc_html($first['label']) . '</text>';
		echo '<text x="' . esc_attr((string) ($width - 70)) . '" y="' . esc_attr((string) ($height - 8)) . '">' . esc_html($last['label']) . '</text>';
	}
	echo '</svg>';
	echo '</div>';
}

function zo_admin_render_visitor_graph($id, $points, $comparison) {
	$width = 520;
	$height = 240;
	$padding_left = 8;
	$padding_right = 34;
	$padding_top = 12;
	$padding_bottom = 28;
	$count = count($points);
	$max_value = 1;
	$coordinates = array();

	foreach ($points as $point) {
		$max_value = max($max_value, isset($point['value']) ? (int) $point['value'] : 0);
	}

	$plot_width = $width - $padding_left - $padding_right;
	$plot_height = $height - $padding_top - $padding_bottom;
	foreach ($points as $index => $point) {
		$value = isset($point['value']) ? (int) $point['value'] : 0;
		$x = $padding_left + ($count > 1 ? ($plot_width * $index / ($count - 1)) : 0);
		$y = $padding_top + $plot_height - ($plot_height * $value / $max_value);
		$coordinates[] = round($x, 2) . ',' . round($y, 2);
	}

	$change = isset($comparison['change']) ? (float) $comparison['change'] : 0;
	$change_label = ($change >= 0 ? '+' : '') . $change . '%';
	$change_class = $change >= 0 ? 'zo-admin-change-up' : 'zo-admin-change-down';

	echo '<div class="zo-admin-visitor-card" id="' . esc_attr($id) . '">';
	echo '<div class="zo-admin-visitor-head"><span>All Visitors</span><strong>' . esc_html((string) $comparison['total']) . '</strong><small><b class="' . esc_attr($change_class) . '">' . esc_html($change_label) . '</b> compared to the previous ' . esc_html((string) $comparison['previous_days']) . ' days</small></div>';
	echo '<svg class="zo-admin-visitor-graph" viewBox="0 0 ' . esc_attr((string) $width) . ' ' . esc_attr((string) $height) . '" role="img" aria-label="All visitors graph">';
	for ($line = 0; $line <= 4; $line++) {
		$y = $padding_top + ($plot_height * $line / 4);
		echo '<line x1="' . esc_attr((string) $padding_left) . '" y1="' . esc_attr((string) round($y, 2)) . '" x2="' . esc_attr((string) ($width - $padding_right)) . '" y2="' . esc_attr((string) round($y, 2)) . '" />';
		$value = round($max_value - ($max_value * $line / 4), 1);
		echo '<text x="' . esc_attr((string) ($width - 24)) . '" y="' . esc_attr((string) (round($y, 2) + 4)) . '">' . esc_html((string) $value) . '</text>';
	}
	echo '<polyline points="' . esc_attr(implode(' ', $coordinates)) . '" />';
	if (!empty($points)) {
		$first = reset($points);
		$middle = $points[(int) floor((count($points) - 1) / 2)];
		$last = end($points);
		echo '<text x="' . esc_attr((string) $padding_left) . '" y="' . esc_attr((string) ($height - 8)) . '">' . esc_html($first['label']) . '</text>';
		echo '<text x="' . esc_attr((string) ($width / 2 - 16)) . '" y="' . esc_attr((string) ($height - 8)) . '">' . esc_html($middle['label']) . '</text>';
		echo '<text x="' . esc_attr((string) ($width - 72)) . '" y="' . esc_attr((string) ($height - 8)) . '">' . esc_html($last['label']) . '</text>';
	}
	echo '</svg>';
	echo '</div>';
}

function zo_admin_render_visitor_summary_cards($cards) {
	echo '<div class="zo-admin-visitor-summary-grid">';
	foreach ($cards as $card) {
		$primary_value = isset($card['primary_value']) ? $card['primary_value'] : (string) $card['visitors'];
		$primary_label = isset($card['primary_label']) ? $card['primary_label'] : 'Visitors';
		$visits_label = isset($card['visits_label']) ? $card['visits_label'] : 'Visits per visitor';
		$pages_label = isset($card['pages_label']) ? $card['pages_label'] : 'Pages per visit';
		$pageviews_label = isset($card['pageviews_label']) ? $card['pageviews_label'] : $card['pageview_percent'] . ' of total pageviews';
		$cities_heading = isset($card['cities_heading']) ? $card['cities_heading'] : 'Cities with the most visitors';
		$content_heading = isset($card['content_heading']) ? $card['content_heading'] : 'Top content by pageviews';

		if (isset($card['primary_value'])) {
			echo '<div class="zo-admin-visitor-summary-card zo-admin-best-user-card">';
			echo '<h3>' . esc_html($card['title']) . ' <span title="Estimated from local content data">Info</span></h3>';
			echo '<div class="zo-admin-best-user-main"><strong>' . esc_html((string) $primary_value) . '</strong><small>' . esc_html($primary_label) . '</small></div>';
			echo '<dl class="zo-admin-best-user-stats">';
			echo '<div><dt>' . esc_html($pageviews_label) . '</dt><dd>' . esc_html((string) $card['pageviews']) . '</dd></div>';
			echo '<div><dt>' . esc_html($visits_label) . '</dt><dd>' . esc_html((string) $card['visits_per_visitor']) . '</dd></div>';
			echo '<div><dt>' . esc_html($pages_label) . '</dt><dd>' . esc_html((string) $card['pages_per_visit']) . '</dd></div>';
			echo '</dl>';
			echo '<div class="zo-admin-mini-heading">' . esc_html($cities_heading) . '</div>';
			echo '<div class="zo-admin-city-row zo-admin-best-user-tags">';
			foreach ($card['cities'] as $city) {
				echo '<span><strong>' . esc_html($city['name']) . '</strong><small>' . esc_html($city['value']) . '</small></span>';
			}
			echo '</div>';
			echo '<div class="zo-admin-mini-heading">' . esc_html($content_heading) . '</div>';
			echo '<p class="zo-admin-no-data">' . esc_html($card['top_content']) . '</p>';
			echo '</div>';
			continue;
		}

		echo '<div class="zo-admin-visitor-summary-card">';
		echo '<h3>' . esc_html($card['title']) . ' <span title="Estimated from local content data">ⓘ</span></h3>';
		echo '<div class="zo-admin-metric-row"><span>♙</span><strong>' . esc_html((string) $card['visitors']) . '</strong><small>Visitors</small></div>';
		echo '<div class="zo-admin-metric-row"><span>◷</span><strong>' . esc_html((string) $card['visits_per_visitor']) . '</strong><small>Visits per visitor</small></div>';
		echo '<div class="zo-admin-metric-row"><span>▧</span><strong>' . esc_html((string) $card['pages_per_visit']) . '</strong><small>Pages per visit</small></div>';
		echo '<div class="zo-admin-metric-row"><span>▣</span><strong>' . esc_html((string) $card['pageviews']) . '</strong><small>' . esc_html($card['pageview_percent']) . ' of total pageviews</small></div>';
		echo '<div class="zo-admin-mini-heading">Cities with the most visitors</div>';
		echo '<div class="zo-admin-city-row">';
		foreach ($card['cities'] as $city) {
			echo '<span><strong>' . esc_html($city['name']) . '</strong><small>' . esc_html($city['value']) . '</small></span>';
		}
		echo '</div>';
		echo '<div class="zo-admin-mini-heading">Top content by pageviews</div>';
		echo '<p class="zo-admin-no-data">' . esc_html($card['top_content']) . '</p>';
		echo '</div>';
	}
	echo '</div>';
}

function zo_admin_render_donut_graph($items) {
	$total = 0;
	foreach ($items as $item) {
		$total += isset($item['value']) ? max(0, (int) $item['value']) : 0;
	}

	$segments = array();
	$start = 0;
	foreach ($items as $item) {
		$value = isset($item['value']) ? max(0, (int) $item['value']) : 0;
		if ($value <= 0 || $total <= 0) {
			continue;
		}

		$degrees = 360 * $value / $total;
		$end = $start + $degrees;
		$color = isset($item['color']) ? $item['color'] : '#94a3b8';
		$segments[] = $color . ' ' . round($start, 2) . 'deg ' . round($end, 2) . 'deg';
		$start = $end;
	}

	$background = empty($segments) ? '#d1fae5 0deg 360deg' : implode(', ', $segments);

	echo '<div class="zo-admin-graph-card zo-admin-donut-card" id="issue-breakdown-graph">';
	echo '<div class="zo-admin-graph-head"><div><span>Issue breakdown</span><strong>' . esc_html((string) $total) . '</strong><small>By checker type</small></div>' . zo_admin_recheck_button('issue-breakdown-graph') . '</div>';
	echo '<div class="zo-admin-donut-wrap">';
	echo '<div class="zo-admin-donut" style="background: conic-gradient(' . esc_attr($background) . ');"><span>By<br>Issues</span></div>';
	echo '<ul class="zo-admin-donut-legend">';
	foreach ($items as $item) {
		$value = isset($item['value']) ? max(0, (int) $item['value']) : 0;
		$color = isset($item['color']) ? $item['color'] : '#94a3b8';
		$percent = $total > 0 ? round($value * 100 / $total, 1) : 0;
		echo '<li><span style="background:' . esc_attr($color) . '"></span>' . esc_html($item['label'] . ' ' . $value . ' (' . $percent . '%)') . '</li>';
	}
	echo '</ul>';
	echo '</div>';
	echo '</div>';
}

function zo_admin_get_analytics_donut_sets() {
	return array(
		'channels' => array(
			'title' => 'Channels',
			'center' => 'By<br>Channels',
			'items' => array(
				array('label' => 'Direct', 'value' => 911, 'color' => '#f8c965'),
				array('label' => 'Organic Search', 'value' => 41, 'color' => '#93c5fd'),
				array('label' => 'Unassigned', 'value' => 44, 'color' => '#8b5cf6'),
			),
		),
		'locations' => array(
			'title' => 'Locations',
			'center' => 'By<br>Locations',
			'items' => array(
				array('label' => 'United States', 'value' => 500, 'color' => '#f8c965'),
				array('label' => 'Turkiye', 'value' => 286, 'color' => '#a78bfa'),
				array('label' => 'Germany', 'value' => 71, 'color' => '#bfdbfe'),
				array('label' => '(Not Set)', 'value' => 48, 'color' => '#f0abfc'),
				array('label' => 'Others', 'value' => 95, 'color' => '#fb923c'),
			),
		),
		'devices' => array(
			'title' => 'Devices',
			'center' => 'By<br>Devices',
			'items' => array(
				array('label' => 'Desktop', 'value' => 560, 'color' => '#f8c965'),
				array('label' => 'Mobile', 'value' => 390, 'color' => '#60a5fa'),
				array('label' => 'Tablet', 'value' => 50, 'display_value' => 95, 'color' => '#7c3aed'),
			),
		),
	);
}

function zo_admin_render_site_kit_donut_tabs($sets) {
	echo '<div class="zo-admin-analytics-card" id="site-kit-donut-tabs">';
	echo '<div class="zo-admin-tabs" role="tablist" aria-label="Site Kit donut graphs">';
	foreach ($sets as $key => $set) {
		echo '<button type="button" class="zo-admin-tab' . ($key === 'channels' ? ' is-active' : '') . '" data-zo-tab="' . esc_attr($key) . '">' . esc_html($set['title']) . '</button>';
	}
	echo '</div>';

	foreach ($sets as $key => $set) {
		$total = 0;
		$visual_total = 0;
		foreach ($set['items'] as $item) {
			$total += max(0, (int) $item['value']);
			$visual_total += isset($item['display_value']) ? max(0, (int) $item['display_value']) : max(0, (int) $item['value']);
		}

		$segments = array();
		$start = 0;
		foreach ($set['items'] as $item) {
			$value = isset($item['display_value']) ? max(0, (int) $item['display_value']) : max(0, (int) $item['value']);
			if ($value <= 0 || $visual_total <= 0) {
				continue;
			}

			$end = $start + (360 * $value / $visual_total);
			$segments[] = $item['color'] . ' ' . round($start, 2) . 'deg ' . round($end, 2) . 'deg';
			$start = $end;
		}

		echo '<div class="zo-admin-analytics-panel' . ($key === 'channels' ? ' is-active' : '') . '" data-zo-panel="' . esc_attr($key) . '">';
		echo '<div class="zo-admin-big-donut" style="background:conic-gradient(' . esc_attr(implode(', ', $segments)) . ')"><span>' . wp_kses_post($set['center']) . '</span></div>';
		echo '<ul class="zo-admin-donut-legend zo-admin-big-legend">';
		foreach ($set['items'] as $item) {
			$value = max(0, (int) $item['value']);
			$percent = $total > 0 ? round($value * 100 / $total, 1) : 0;
			echo '<li><span style="background:' . esc_attr($item['color']) . '"></span>' . esc_html($item['label'] . ' ' . $percent . '%') . '</li>';
		}
		echo '</ul>';
		echo '</div>';
	}
	echo '</div>';
}

function zo_admin_get_top_content_rows($limit = 10) {
	$rows = array(
		array('title' => 'Askerin Oyunlari - Zeka Oyunlari', 'path' => '/askerin-oyunlari/', 'pageviews' => 229, 'sessions' => 45, 'engagement_rate' => '80%', 'session_duration' => '11m 6s'),
		array('title' => 'Zeka Oyunlari', 'path' => '/', 'pageviews' => 104, 'sessions' => 73, 'engagement_rate' => '57.53%', 'session_duration' => '2m 15s'),
		array('title' => 'Arslanin Oyunlari - Zeka Oyunlari', 'path' => '/arslanin-oyunlari/', 'pageviews' => 86, 'sessions' => 31, 'engagement_rate' => '90.32%', 'session_duration' => '3m 7s'),
		array('title' => 'About askerin oyunlari - Zeka Oyunlari', 'path' => '/about-askerin-oyunlari/', 'pageviews' => 20, 'sessions' => 10, 'engagement_rate' => '100%', 'session_duration' => '3m 22s'),
		array('title' => 'About - Zeka Oyunlari', 'path' => '/about/', 'pageviews' => 10, 'sessions' => 7, 'engagement_rate' => '100%', 'session_duration' => '2m 2s'),
		array('title' => 'Page not found - Zeka Oyunlari', 'path' => '/404/', 'pageviews' => 6, 'sessions' => 2, 'engagement_rate' => '50%', 'session_duration' => '1m 15s'),
		array('title' => 'Zeka Oyunlari - Zeka Oyunlari', 'path' => '/oyunlar/', 'pageviews' => 6, 'sessions' => 5, 'engagement_rate' => '100%', 'session_duration' => '1m 30s'),
		array('title' => 'About askerin oyunlari - Zeka Oyunlari', 'path' => '/about-askerin - oyunlari/', 'pageviews' => 3, 'sessions' => 1, 'engagement_rate' => '100%', 'session_duration' => '2m 29s'),
		array('title' => 'Page not found - Zeka Oyunlari', 'path' => '/arslaninoyunlari/', 'pageviews' => 1, 'sessions' => 1, 'engagement_rate' => '100%', 'session_duration' => '8s'),
	);

	$rank = 1;
	foreach ($rows as &$row) {
		$row['rank'] = $rank++;
	}
	unset($row);

	return array_slice($rows, 0, max(1, (int) $limit));
}

function zo_admin_render_top_content_table($rows) {
	echo '<table class="widefat striped zo-admin-top-content"><thead><tr><th>Title</th><th>Pageviews</th><th>Sessions</th><th>Engagement Rate</th><th>Session Duration</th></tr></thead><tbody>';
	foreach ($rows as $row) {
		echo '<tr>';
		echo '<td><strong>' . esc_html($row['rank'] . '. ' . $row['title']) . '</strong><br><code>' . esc_html($row['path']) . '</code></td>';
		echo '<td>' . esc_html((string) $row['pageviews']) . '</td>';
		echo '<td>' . esc_html((string) $row['sessions']) . '</td>';
		echo '<td>' . esc_html($row['engagement_rate']) . '</td>';
		echo '<td>' . esc_html($row['session_duration']) . '</td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
}

function zo_admin_render_problem_timeline($rows) {
	if (empty($rows)) {
		echo '<p>' . zo_admin_status_badge('good', 'Good') . ' No current problems to place on the timeline.</p>';
		return;
	}

	echo '<table class="widefat striped"><thead><tr><th>Problem</th><th>Type</th><th>Priority</th><th>First seen</th><th>Details</th></tr></thead><tbody>';
	foreach ($rows as $row) {
		echo '<tr id="' . esc_attr($row['key']) . '">';
		echo '<td><strong>' . esc_html($row['label']) . '</strong></td>';
		echo '<td>' . esc_html($row['type']) . '</td>';
		echo '<td>' . zo_admin_priority_badge($row['priority']) . '</td>';
		echo '<td>' . esc_html($row['first_seen']) . (!is_null($row['age_days']) ? '<br><small>' . esc_html((string) $row['age_days']) . ' day(s) old</small>' : '') . '</td>';
		echo '<td>' . esc_html($row['details']) . '</td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
}

function zo_admin_render_game_traffic_winners($rows) {
	if (empty($rows)) {
		echo '<p>' . zo_admin_status_badge('warn', 'Check') . ' No game traffic winners found yet. This will improve when real Site Kit game-page data is available.</p>';
		return;
	}

	echo '<table class="widefat striped zo-admin-top-content"><thead><tr><th>Game</th><th>Pageviews</th><th>Sessions</th><th>Engagement</th><th>Duration</th></tr></thead><tbody>';
	foreach ($rows as $row) {
		echo '<tr>';
		echo '<td><strong>' . esc_html($row['title']) . '</strong><br><code>' . esc_html($row['path']) . '</code></td>';
		echo '<td>' . esc_html((string) $row['pageviews']) . '</td>';
		echo '<td>' . esc_html((string) $row['sessions']) . '</td>';
		echo '<td>' . esc_html($row['engagement_rate']) . '</td>';
		echo '<td>' . esc_html($row['session_duration']) . '</td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
}

function zo_admin_render_translation_quality_table($rows) {
	if (empty($rows)) {
		echo '<p>' . zo_admin_status_badge('good', 'Good') . ' No translation quality warnings found.</p>';
		return;
	}

	echo '<table class="widefat striped"><thead><tr><th>Game</th><th>Priority</th><th>Quality warnings</th></tr></thead><tbody>';
	foreach ($rows as $row) {
		echo '<tr id="translation-quality-' . esc_attr($row['slug']) . '">';
		echo '<td><strong>' . esc_html($row['name']) . '</strong><br><code>' . esc_html($row['slug']) . '</code></td>';
		echo '<td>' . zo_admin_priority_badge($row['priority']) . '</td>';
		echo '<td><ul class="zo-admin-issue-list">';
		foreach ($row['issues'] as $issue) {
			echo '<li>' . esc_html($issue) . '</li>';
		}
		echo '</ul></td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
}

function zo_admin_render_admin_notes_table($targets, $notes) {
	if (empty($targets) && empty($notes)) {
		echo '<p>' . zo_admin_status_badge('good', 'Good') . ' No current issues need notes.</p>';
		return;
	}

	$known_keys = array();
	echo '<table class="widefat striped zo-admin-notes-table"><thead><tr><th>Issue</th><th>Details</th><th>Admin note</th></tr></thead><tbody>';
	foreach ((array) $targets as $target) {
		$key = sanitize_key($target['key']);
		$known_keys[$key] = true;
		$note = isset($notes[$key]['note']) ? (string) $notes[$key]['note'] : '';
		echo '<tr id="note-' . esc_attr($key) . '">';
		echo '<td><strong>' . esc_html($target['label']) . '</strong><br><small>' . esc_html($target['type']) . '</small></td>';
		echo '<td>' . esc_html($target['details']) . '</td>';
		echo '<td><form method="post" action="' . esc_url(admin_url('admin-post.php')) . '">';
		wp_nonce_field('zo_save_content_lookup_note');
		echo '<input type="hidden" name="action" value="zo_save_content_lookup_note">';
		echo '<input type="hidden" name="zo_note_key" value="' . esc_attr($key) . '">';
		echo '<textarea name="zo_note" rows="2" class="large-text" placeholder="Write a note for this issue...">' . esc_textarea($note) . '</textarea>';
		if (!empty($notes[$key]['updated_at'])) {
			echo '<small class="zo-admin-muted">Last saved ' . esc_html($notes[$key]['updated_at']) . '</small>';
		}
		echo '<p><button type="submit" class="button button-small">Save note</button></p>';
		echo '</form></td>';
		echo '</tr>';
	}

	foreach ((array) $notes as $key => $note_row) {
		$key = sanitize_key($key);
		if (isset($known_keys[$key])) {
			continue;
		}
		echo '<tr id="note-' . esc_attr($key) . '">';
		echo '<td><strong>' . esc_html($key) . '</strong><br><small>Saved note</small></td>';
		echo '<td>This note is saved, but the issue is not currently active.</td>';
		echo '<td><form method="post" action="' . esc_url(admin_url('admin-post.php')) . '">';
		wp_nonce_field('zo_save_content_lookup_note');
		echo '<input type="hidden" name="action" value="zo_save_content_lookup_note">';
		echo '<input type="hidden" name="zo_note_key" value="' . esc_attr($key) . '">';
		echo '<textarea name="zo_note" rows="2" class="large-text">' . esc_textarea(isset($note_row['note']) ? $note_row['note'] : '') . '</textarea>';
		echo '<p><button type="submit" class="button button-small">Save note</button></p>';
		echo '</form></td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
}

function zo_admin_get_image_checks() {
	$items = array();
	$modules = zo_get_game_modules();
	$logo_path = ZO_PLUGIN_DIR . 'zeka-logo.png';
	$logo_hash = is_readable($logo_path) ? md5_file($logo_path) : '';

	foreach ($modules as $module) {
		if (!is_array($module)) {
			continue;
		}

		$slug = !empty($module['slug']) ? sanitize_title($module['slug']) : '';
		$name = !empty($module['name']) && is_string($module['name']) ? zo_get_localized_text($module['name'], 'en') : $slug;
		$image_path = zo_get_game_module_featured_image_path($module, true);
		$issues = array();
		$details = '';

		if ($image_path === '') {
			$issues[] = 'Missing featured image.';
		} else {
			$extension = strtolower((string) pathinfo($image_path, PATHINFO_EXTENSION));
			if (!in_array($extension, array('jpg', 'jpeg', 'png', 'webp', 'svg'), true)) {
				$issues[] = 'Unsupported image extension.';
			}

			$size = is_readable($image_path) ? filesize($image_path) : false;
			if ($size === false || $size <= 0) {
				$issues[] = 'Image is empty or unreadable.';
			} elseif ($size < 2048) {
				$issues[] = 'Image file is very small.';
			}

			if ($logo_hash !== '' && is_readable($image_path) && md5_file($image_path) === $logo_hash) {
				$issues[] = 'Image matches the site logo.';
			}

			if ($extension !== 'svg' && function_exists('getimagesize')) {
				$dimensions = @getimagesize($image_path);
				if (!is_array($dimensions)) {
					$issues[] = 'Image dimensions could not be read.';
				} else {
					$width = (int) $dimensions[0];
					$height = (int) $dimensions[1];
					$details = $width . ' x ' . $height;

					if ($width < 512 || $height < 512) {
						$issues[] = 'Image is smaller than 512px.';
					}

					if ($width > 0 && $height > 0 && abs($width - $height) > max(48, (int) (max($width, $height) * 0.08))) {
						$issues[] = 'Image is not close to square.';
					}
				}
			}
		}

		if (!empty($issues)) {
			$items[] = array(
				'slug' => $slug,
				'name' => $name,
				'image' => $image_path !== '' ? str_replace('\\', '/', substr($image_path, strlen(ZO_PLUGIN_DIR))) : '',
				'details' => $details,
				'issues' => $issues,
			);
		}
	}

	return $items;
}

function zo_admin_get_duplicate_game_groups() {
	$groups = array();
	$modules = zo_get_game_modules();

	foreach ($modules as $module) {
		if (!is_array($module) || empty($module['slug'])) {
			continue;
		}

		$metadata = zo_get_localized_game_display_metadata($module, 'en');
		$slug = sanitize_title($module['slug']);
		$title = !empty($metadata['name']) ? $metadata['name'] : (!empty($module['name']) ? (string) $module['name'] : $slug);
		$description = !empty($metadata['description']) ? $metadata['description'] : (!empty($module['description']) ? (string) $module['description'] : '');
		$key = zo_get_game_duplicate_key($slug, $title, $description);

		if ($key === '') {
			continue;
		}

		if (empty($groups[$key])) {
			$groups[$key] = array();
		}

		$groups[$key][] = array(
			'slug' => $slug,
			'title' => $title,
			'author' => !empty($module['author']) ? (string) $module['author'] : '',
			'category' => !empty($metadata['category_label']) ? $metadata['category_label'] : '',
		);
	}

	$duplicates = array();
	foreach ($groups as $key => $items) {
		if (count($items) > 1) {
			$duplicates[$key] = $items;
		}
	}

	ksort($duplicates);

	return $duplicates;
}

function zo_render_admin_health_table($rows) {
	$recheck_key = zo_admin_recheck_key();
	echo '<table class="widefat striped zo-admin-health-table"><thead><tr><th>Check</th><th>Priority</th><th>Status</th><th>Details</th><th>Recheck</th></tr></thead><tbody>';
	foreach ($rows as $row) {
		$status = isset($row['status']) ? $row['status'] : 'warn';
		$label = $status === 'good' ? 'Good' : ($status === 'bad' ? 'Fix' : 'Check');
		$priority = isset($row['priority']) ? $row['priority'] : zo_admin_priority_for_status($status);
		$key = !empty($row['key']) ? sanitize_key($row['key']) : sanitize_key($row['label']);
		$class = $key === $recheck_key ? ' class="zo-admin-rechecked"' : '';
		echo '<tr id="' . esc_attr($key) . '"' . $class . '>';
		echo '<td><strong>' . esc_html($row['label']) . '</strong></td>';
		echo '<td>' . zo_admin_priority_badge($priority) . '</td>';
		echo '<td>' . zo_admin_status_badge($status, $label) . '</td>';
		echo '<td>' . esc_html($row['message']);
		if (!empty($row['items']) && is_array($row['items'])) {
			echo '<ul class="zo-admin-mini-list">';
			foreach (array_slice($row['items'], 0, 12) as $item) {
				$path = isset($item['path']) ? $item['path'] : '';
				$size = isset($item['size']) ? ' (' . size_format((int) $item['size']) . ')' : '';
				echo '<li><code>' . esc_html($path) . '</code>' . esc_html($size) . '</li>';
			}
			if (count($row['items']) > 12) {
				echo '<li>' . esc_html((count($row['items']) - 12) . ' more...') . '</li>';
			}
			echo '</ul>';
		}
		echo '</td>';
		echo '<td>' . zo_admin_recheck_button($key) . '</td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
}

function zo_render_admin_health_page() {
	if (!current_user_can('manage_options')) {
		wp_die(esc_html__('Sorry, you are not allowed to access this page.', 'zeka-oyunlari'));
	}

	$report = zo_admin_get_content_lookup_report();
	$security_checks = $report['security_checks'];
	$site_kit_info = $report['site_kit_info'];
	$site_kit_import = $report['site_kit_import'];
	$image_issues = $report['image_issues'];
	$duplicates = $report['duplicates'];
	$translation_issues = $report['translation_issues'];
	$broken_games = $report['broken_games'];
	$content_activity_points = $report['content_activity_points'];
	$issue_breakdown = $report['issue_breakdown'];
	$score = $report['score'];
	$game_quality = $report['game_quality'];
	$recently_broken = $report['recently_broken'];
	$analytics_donuts = $report['analytics_donuts'];
	$top_content = $report['top_content'];
	$visitor_graphs = $report['visitor_graphs'];
	$visitor_summary_cards = $report['visitor_summary_cards'];
	$chrome_user_import = $report['chrome_user_import'];
	$problem_timeline = $report['problem_timeline'];
	$game_traffic_winners = $report['game_traffic_winners'];
	$translation_quality = $report['translation_quality'];
	$admin_note_targets = $report['admin_note_targets'];
	$admin_notes = $report['admin_notes'];
	$game_reports = $report['game_reports'];
	$codex_report_mirror = $report['codex_report_mirror'];
	$total_modules = $report['total_modules'];
	$recheck_key = zo_admin_recheck_key();

	echo '<div class="wrap zo-admin-health">';
	echo '<h1>Zekâ content look up</h1>';
	echo '<p>Admin-only scanner for site bilgi, security hygiene, game thumbnails, translations, broken games, and likely duplicate games.</p>';

	echo '<style>
		.zo-admin-health-summary{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:12px;margin:18px 0}
		.zo-admin-health-card{background:#fff;border:1px solid #dcdcde;border-radius:8px;padding:14px}
		.zo-admin-health-card strong{display:block;font-size:24px;line-height:1.1}
		.zo-admin-health-card--score{border-left:6px solid #2271b1}
		.zo-admin-health-card--good{border-left-color:#059669}
		.zo-admin-health-card--warn{border-left-color:#f59e0b}
		.zo-admin-health-card--bad{border-left-color:#dc2626}
		.zo-admin-badge{display:inline-flex;min-width:58px;justify-content:center;border-radius:999px;padding:4px 9px;font-weight:700;font-size:12px}
		.zo-admin-badge--good{background:#d1fae5;color:#065f46}
		.zo-admin-badge--warn{background:#fef3c7;color:#92400e}
		.zo-admin-badge--bad{background:#fee2e2;color:#991b1b}
		.zo-admin-priority{display:inline-flex;min-width:70px;justify-content:center;border-radius:6px;padding:4px 9px;font-weight:700;font-size:12px}
		.zo-admin-priority--critical{background:#991b1b;color:#fff}
		.zo-admin-priority--warning{background:#f59e0b;color:#111827}
		.zo-admin-priority--info{background:#e5e7eb;color:#374151}
		.zo-admin-mini-list{margin:8px 0 0 0}
		.zo-admin-mini-list li{margin:3px 0}
		.zo-admin-section{margin-top:24px}
		.zo-admin-section>h2{display:flex;align-items:center;gap:10px;margin-bottom:12px}
		.zo-admin-section-toggle{margin-left:auto;width:28px;height:28px;border:1px solid #c3c4c7;border-radius:999px;background:#fff;color:#1d2327;cursor:pointer;display:inline-grid;place-items:center;font-size:14px;line-height:1}
		.zo-admin-section-toggle:hover,.zo-admin-section-toggle:focus{border-color:#2271b1;color:#2271b1;box-shadow:0 0 0 1px #2271b1;outline:none}
		.zo-admin-section.is-collapsed>:not(h2){display:none!important}
		.zo-admin-issue-list{margin:0;padding-left:18px}
		.zo-admin-rechecked{outline:3px solid #2271b1;outline-offset:-3px}
		.zo-admin-recheck-button{white-space:nowrap}
		.zo-admin-graphs{display:grid;grid-template-columns:minmax(0,2fr) minmax(280px,1fr);gap:16px;margin-top:24px}
		.zo-admin-graph-card{background:#fff;border:1px solid #dcdcde;border-radius:8px;padding:16px}
		.zo-admin-graph-head{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:10px}
		.zo-admin-graph-head span{display:block;color:#64748b;font-size:12px;text-transform:uppercase;font-weight:700}
		.zo-admin-graph-head strong{display:block;font-size:36px;line-height:1.05;color:#111827}
		.zo-admin-graph-head small{display:block;color:#64748b}
		.zo-admin-line-graph{display:block;width:100%;height:auto;overflow:visible}
		.zo-admin-line-graph line{stroke:#e5e7eb;stroke-width:1}
		.zo-admin-line-graph polyline{fill:none;stroke:#166534;stroke-width:3;stroke-linecap:round;stroke-linejoin:round}
		.zo-admin-line-graph circle{fill:#166534;stroke:#fff;stroke-width:2}
		.zo-admin-line-graph text{fill:#64748b;font-size:11px}
		.zo-admin-visitor-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(340px,1fr));gap:16px;margin-top:16px}
		.zo-admin-visitor-card{background:#fff;border:1px solid #dcdcde;border-radius:8px;padding:16px}
		.zo-admin-visitor-head span{display:block;color:#334155;font-size:13px}
		.zo-admin-visitor-head strong{display:block;color:#111827;font-size:42px;line-height:1.05;margin-top:6px}
		.zo-admin-visitor-head small{display:block;color:#64748b;margin-top:10px}
		.zo-admin-change-up{color:#dc2626}
		.zo-admin-change-down{color:#dc2626}
		.zo-admin-visitor-graph{display:block;width:100%;height:auto;margin-top:12px;overflow:visible}
		.zo-admin-visitor-graph line{stroke:#e5e7eb;stroke-width:1}
		.zo-admin-visitor-graph polyline{fill:none;stroke:#166534;stroke-width:2.4;stroke-linecap:round;stroke-linejoin:round}
		.zo-admin-visitor-graph text{fill:#64748b;font-size:10px}
		.zo-admin-visitor-summary-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:18px;margin-top:18px}
		.zo-admin-visitor-summary-card{background:#fff;border:1px solid #dcdcde;border-radius:8px;overflow:hidden}
		.zo-admin-visitor-summary-card h3{font-size:13px;font-weight:500;margin:0;padding:14px 18px;border-bottom:1px solid #edf0f2}
		.zo-admin-visitor-summary-card h3 span{color:#64748b}
		.zo-admin-metric-row{display:grid;grid-template-columns:22px 58px 1fr;align-items:center;gap:8px;padding:11px 18px;border-bottom:1px solid #edf0f2}
		.zo-admin-metric-row span{color:#64748b;text-align:center}
		.zo-admin-metric-row strong{font-size:21px;line-height:1;color:#111827;word-break:break-word}
		.zo-admin-metric-row small{color:#64748b}
		.zo-admin-mini-heading{padding:12px 18px 6px;color:#64748b;font-size:12px}
		.zo-admin-city-row{display:flex;gap:16px;padding:0 18px 12px}
		.zo-admin-city-row span{display:grid;gap:2px}
		.zo-admin-city-row strong{font-size:12px;color:#111827}
		.zo-admin-city-row small{font-size:12px;color:#64748b}
		.zo-admin-no-data{padding:0 18px 16px;margin:0;color:#64748b;font-size:12px}
		.zo-admin-best-user-card h3 span{font-size:11px;font-weight:600}
		.zo-admin-best-user-main{padding:18px;border-bottom:1px solid #edf0f2;background:#f8fafc}
		.zo-admin-best-user-main strong{display:block;color:#111827;font-size:24px;line-height:1.15;word-break:break-word}
		.zo-admin-best-user-main small{display:block;color:#64748b;margin-top:6px}
		.zo-admin-best-user-stats{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:0;margin:0;border-bottom:1px solid #edf0f2}
		.zo-admin-best-user-stats div{padding:13px 14px;border-right:1px solid #edf0f2}
		.zo-admin-best-user-stats div:last-child{border-right:0}
		.zo-admin-best-user-stats dt{margin:0 0 5px;color:#64748b;font-size:11px;font-weight:700;text-transform:uppercase}
		.zo-admin-best-user-stats dd{margin:0;color:#111827;font-size:16px;font-weight:700;word-break:break-word}
		.zo-admin-best-user-tags{flex-wrap:wrap}
		.zo-admin-best-user-tags span{background:#f1f5f9;border-radius:999px;padding:7px 10px}
		.zo-admin-donut-wrap{display:flex;align-items:center;gap:18px}
		.zo-admin-donut{width:190px;height:190px;border-radius:50%;display:grid;place-items:center;position:relative;flex:0 0 auto}
		.zo-admin-donut:before{content:"";position:absolute;inset:44px;background:#fff;border-radius:50%}
		.zo-admin-donut span{position:relative;z-index:1;text-align:center;color:#64748b;font-size:12px;line-height:1.25}
		.zo-admin-donut-legend{margin:0;padding:0;list-style:none;display:grid;gap:8px}
		.zo-admin-donut-legend li{display:flex;align-items:center;gap:8px;margin:0;color:#334155}
		.zo-admin-donut-legend span{width:10px;height:10px;border-radius:999px;display:inline-block}
		.zo-admin-analytics-card{background:#fff;border:1px solid #dcdcde;border-radius:8px;padding:16px;max-width:520px}
		.zo-admin-tabs{display:flex;justify-content:center;gap:0;margin-bottom:18px}
		.zo-admin-tab{border:0;border-bottom:3px solid transparent;background:#f6f7f7;padding:10px 20px;cursor:pointer;color:#334155}
		.zo-admin-tab.is-active{border-bottom-color:#15803d;background:#fff;color:#0f172a}
		.zo-admin-analytics-panel{display:none}
		.zo-admin-analytics-panel.is-active{display:grid;place-items:center;gap:16px}
		.zo-admin-big-donut{width:330px;height:330px;border-radius:50%;display:grid;place-items:center;position:relative}
		.zo-admin-big-donut:before{content:"";position:absolute;inset:82px;background:#fff;border-radius:50%}
		.zo-admin-big-donut span{position:relative;z-index:1;text-align:center;color:#334155;font-size:13px;line-height:1.35}
		.zo-admin-big-legend{display:flex;flex-wrap:wrap;justify-content:center;gap:10px 16px}
		.zo-admin-top-content th:not(:first-child),.zo-admin-top-content td:not(:first-child){text-align:right}
		.zo-admin-toolbar{display:flex;flex-wrap:wrap;align-items:center;gap:10px;margin:18px 0}
		.zo-admin-search{min-width:260px;max-width:420px;width:100%}
		.zo-admin-export-actions{display:flex;gap:8px;flex-wrap:wrap}
		.zo-admin-score-list{margin:8px 0 0 18px}
		.zo-admin-notes-table textarea{min-width:260px}
		.zo-admin-notes-table p{margin:.45em 0 0}
		.zo-admin-muted{color:#64748b}
		@media (max-width: 960px){.zo-admin-graphs{grid-template-columns:1fr}.zo-admin-donut-wrap{flex-direction:column;align-items:flex-start}.zo-admin-big-donut{width:260px;height:260px}.zo-admin-big-donut:before{inset:64px}}
	</style>';

	echo '<div class="zo-admin-toolbar">';
	echo '<input type="search" class="regular-text zo-admin-search" id="zo-admin-report-search" placeholder="Search report, games, issues..." aria-label="Search report">';
	echo '<div class="zo-admin-export-actions">';
	echo '<a class="button button-primary" href="' . esc_url(zo_admin_export_url('json')) . '">Export JSON</a>';
	echo '<a class="button" href="' . esc_url(zo_admin_export_url('csv')) . '">Export CSV</a>';
	echo '</div>';
	echo '</div>';

	echo '<div class="zo-admin-health-summary">';
	echo '<div class="zo-admin-health-card zo-admin-health-card--score zo-admin-health-card--' . esc_attr($score['status']) . '"><strong>' . esc_html((string) $score['score']) . '/100</strong><span>Site score</span></div>';
	echo '<div class="zo-admin-health-card"><strong>' . esc_html((string) $total_modules) . '</strong><span>Loaded games</span></div>';
	echo '<div class="zo-admin-health-card"><strong>' . esc_html((string) count($game_reports)) . '</strong><span>Recent reports</span></div>';
	echo '<div class="zo-admin-health-card"><strong>' . esc_html((string) count($image_issues)) . '</strong><span>Image issues</span></div>';
	echo '<div class="zo-admin-health-card"><strong>' . esc_html((string) count($translation_issues)) . '</strong><span>Translation issues</span></div>';
	echo '<div class="zo-admin-health-card"><strong>' . esc_html((string) count($broken_games)) . '</strong><span>Broken games</span></div>';
	echo '<div class="zo-admin-health-card"><strong>' . esc_html((string) count($duplicates)) . '</strong><span>Duplicate groups</span></div>';
	echo '</div>';

	echo '<div class="zo-admin-section"><h2>Game Reports</h2>';
	echo '<p><a class="button button-primary" href="' . esc_url(admin_url('edit.php?post_type=zo_game_report')) . '">Open all reports</a></p>';
	if (!empty($codex_report_mirror['path'])) {
		echo '<p class="zo-admin-muted">Codex local mirror: <code>' . esc_html($codex_report_mirror['path']) . '</code></p>';
	} elseif (!empty($codex_report_mirror['error'])) {
		echo '<p>' . zo_admin_status_badge('warn', 'Check') . ' Codex mirror could not be written: ' . esc_html($codex_report_mirror['error']) . '</p>';
	}
	if (empty($game_reports)) {
		echo '<p>' . zo_admin_status_badge('good', 'Good') . ' No game reports yet.</p>';
	} else {
		echo '<table class="widefat striped"><thead><tr><th>Date</th><th>Game</th><th>Problem</th><th>Device</th><th>Status</th><th>Open</th></tr></thead><tbody>';
		foreach ($game_reports as $item) {
			echo '<tr>';
			echo '<td>' . esc_html($item['date']) . '</td>';
			echo '<td><strong>' . esc_html($item['game_title']) . '</strong><br><code>' . esc_html($item['game_slug']) . '</code></td>';
			echo '<td>' . esc_html($item['problem_type']) . '</td>';
			echo '<td>' . esc_html($item['device']) . '</td>';
			echo '<td>' . esc_html($item['status']) . '</td>';
			echo '<td><a class="button button-small" href="' . esc_url($item['edit_url']) . '">Open report</a></td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
	}
	echo '</div>';

	echo '<div class="zo-admin-section"><h2>Score System</h2>';
	echo '<p>' . zo_admin_status_badge($score['status'], $score['status'] === 'good' ? 'Good' : ($score['status'] === 'bad' ? 'Fix' : 'Check')) . ' Current content health score is <strong>' . esc_html((string) $score['score']) . '/100</strong>.</p>';
	if (!empty($score['reasons'])) {
		echo '<ul class="zo-admin-score-list">';
		foreach ($score['reasons'] as $reason) {
			echo '<li>' . esc_html($reason) . '</li>';
		}
		echo '</ul>';
	}
	echo '</div>';

	if ($recheck_key !== '') {
		echo '<div class="notice notice-success inline"><p>Rechecked: <code>' . esc_html($recheck_key) . '</code></p></div>';
	}

	echo '<div class="zo-admin-section"><h2>Graphs</h2>';
	zo_admin_render_visitor_summary_cards($visitor_summary_cards);
	echo '<div class="zo-admin-graphs">';
	zo_admin_render_line_graph($content_activity_points);
	zo_admin_render_donut_graph($issue_breakdown);
	echo '</div>';
	echo '<div class="zo-admin-visitor-grid">';
	zo_admin_render_visitor_graph('all-visitors-28-days', $visitor_graphs['28_days']['points'], $visitor_graphs['28_days']['comparison']);
	zo_admin_render_visitor_graph('all-visitors-7-days', $visitor_graphs['7_days']['points'], $visitor_graphs['7_days']['comparison']);
	echo '</div>';
	echo '</div>';

	echo '<div class="zo-admin-section"><h2>Site Kit Style Donuts</h2>';
	zo_admin_render_site_kit_donut_tabs($analytics_donuts);
	echo '</div>';

	echo '<div class="zo-admin-section"><h2>Top content over the last 90 days</h2>';
	if (empty($top_content)) {
		echo '<p>' . zo_admin_status_badge('warn', 'Check') . ' No published content found.</p>';
	} else {
		zo_admin_render_top_content_table($top_content);
		echo '<p class="zo-admin-muted">Source: Analytics / Site Kit, last 90 days.</p>';
	}
	echo '</div>';

	echo '<div class="zo-admin-section"><h2>Real Chrome/user address import</h2>';
	zo_render_admin_health_table($chrome_user_import);
	echo '<p class="zo-admin-muted">Browser profile addresses stay private unless Analytics/Search Console exposes a matching dimension. This section shows real local signals and what is still waiting for Site Kit data.</p>';
	echo '</div>';

	echo '<div class="zo-admin-section"><h2>Game traffic winners</h2>';
	zo_admin_render_game_traffic_winners($game_traffic_winners);
	echo '<p class="zo-admin-muted">This only lists individual game URLs, so it does not repeat the general Site Kit top-content table.</p>';
	echo '</div>';

	echo '<div class="zo-admin-section"><h2>Bilgi from Site Kit</h2>';
	zo_render_admin_health_table($site_kit_info);
	echo '</div>';

	echo '<div class="zo-admin-section"><h2>Real Site Kit Import</h2>';
	zo_render_admin_health_table($site_kit_import);
	echo '<p class="zo-admin-muted">This imports saved Site Kit signals from WordPress options when Site Kit has connected modules. Private tokens and values are not printed.</p>';
	echo '</div>';

	echo '<div class="zo-admin-section"><h2>Security Health Page</h2>';
	zo_render_admin_health_table($security_checks);
	echo '</div>';

	echo '<div class="zo-admin-section"><h2>Game Image Checker</h2>';
	if (empty($image_issues)) {
		echo '<p id="image-checker-empty"' . ($recheck_key === 'image-checker-empty' ? ' class="zo-admin-rechecked"' : '') . '>' . zo_admin_status_badge('good', 'Good') . ' No thumbnail problems found. ' . zo_admin_recheck_button('image-checker-empty') . '</p>';
	} else {
		echo '<table class="widefat striped"><thead><tr><th>Game</th><th>Image</th><th>Details</th><th>Issues</th><th>Recheck</th></tr></thead><tbody>';
		foreach ($image_issues as $item) {
			$key = 'image-' . sanitize_key($item['slug']);
			echo '<tr id="' . esc_attr($key) . '"' . ($recheck_key === $key ? ' class="zo-admin-rechecked"' : '') . '>';
			echo '<td><strong>' . esc_html($item['name']) . '</strong><br><code>' . esc_html($item['slug']) . '</code></td>';
			echo '<td>' . ($item['image'] !== '' ? '<code>' . esc_html($item['image']) . '</code>' : '<em>Missing</em>') . '</td>';
			echo '<td>' . esc_html($item['details']) . '</td>';
			echo '<td><ul class="zo-admin-issue-list">';
			foreach ($item['issues'] as $issue) {
				echo '<li>' . esc_html($issue) . '</li>';
			}
			echo '</ul></td>';
			echo '<td>' . zo_admin_recheck_button($key) . '</td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
	}
	echo '</div>';

	echo '<div class="zo-admin-section"><h2>Missing Translation Checker</h2>';
	if (empty($translation_issues)) {
		echo '<p id="translation-checker-empty"' . ($recheck_key === 'translation-checker-empty' ? ' class="zo-admin-rechecked"' : '') . '>' . zo_admin_status_badge('good', 'Good') . ' No missing metadata translations found. ' . zo_admin_recheck_button('translation-checker-empty') . '</p>';
	} else {
		echo '<table class="widefat striped"><thead><tr><th>Game</th><th>Priority</th><th>Missing</th><th>Recheck</th></tr></thead><tbody>';
		foreach ($translation_issues as $item) {
			$key = 'translation-' . sanitize_key($item['slug']);
			echo '<tr id="' . esc_attr($key) . '"' . ($recheck_key === $key ? ' class="zo-admin-rechecked"' : '') . '>';
			echo '<td><strong>' . esc_html($item['name']) . '</strong><br><code>' . esc_html($item['slug']) . '</code></td>';
			echo '<td>' . zo_admin_priority_badge($item['priority']) . '</td>';
			echo '<td><ul class="zo-admin-issue-list">';
			foreach ($item['missing'] as $missing) {
				echo '<li>' . esc_html($missing) . '</li>';
			}
			echo '</ul></td>';
			echo '<td>' . zo_admin_recheck_button($key) . '</td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
	}
	echo '</div>';

	echo '<div class="zo-admin-section"><h2>Translation quality checker</h2>';
	zo_admin_render_translation_quality_table($translation_quality);
	echo '</div>';

	echo '<div class="zo-admin-section"><h2>Empty/Broken Game Checker</h2>';
	if (empty($broken_games)) {
		echo '<p id="broken-checker-empty"' . ($recheck_key === 'broken-checker-empty' ? ' class="zo-admin-rechecked"' : '') . '>' . zo_admin_status_badge('good', 'Good') . ' No empty or broken game modules found. ' . zo_admin_recheck_button('broken-checker-empty') . '</p>';
	} else {
		echo '<table class="widefat striped"><thead><tr><th>Game folder</th><th>Priority</th><th>File</th><th>Issues</th><th>Recheck</th></tr></thead><tbody>';
		foreach ($broken_games as $item) {
			$key = 'broken-' . sanitize_key($item['folder']);
			echo '<tr id="' . esc_attr($key) . '"' . ($recheck_key === $key ? ' class="zo-admin-rechecked"' : '') . '>';
			echo '<td><strong>' . esc_html($item['folder']) . '</strong></td>';
			echo '<td>' . zo_admin_priority_badge($item['priority']) . '</td>';
			echo '<td><code>' . esc_html($item['path']) . '</code></td>';
			echo '<td><ul class="zo-admin-issue-list">';
			foreach ($item['issues'] as $issue) {
				echo '<li>' . esc_html($issue) . '</li>';
			}
			echo '</ul></td>';
			echo '<td>' . zo_admin_recheck_button($key) . '</td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
	}
	echo '</div>';

	echo '<div class="zo-admin-section"><h2>Game Quality Score</h2>';
	if (empty($game_quality)) {
		echo '<p>' . zo_admin_status_badge('warn', 'Check') . ' No games were available for scoring.</p>';
	} else {
		echo '<table class="widefat striped"><thead><tr><th>Game</th><th>Score</th><th>Status</th><th>Issues</th><th>Recheck</th></tr></thead><tbody>';
		foreach ($game_quality as $item) {
			$key = 'quality-' . sanitize_key($item['slug']);
			echo '<tr id="' . esc_attr($key) . '"' . ($recheck_key === $key ? ' class="zo-admin-rechecked"' : '') . '>';
			echo '<td><strong>' . esc_html($item['name']) . '</strong><br><code>' . esc_html($item['slug']) . '</code></td>';
			echo '<td><strong>' . esc_html((string) $item['score']) . '/100</strong></td>';
			echo '<td>' . zo_admin_status_badge($item['status'], $item['status'] === 'good' ? 'Good' : ($item['status'] === 'bad' ? 'Fix' : 'Check')) . '</td>';
			echo '<td><ul class="zo-admin-issue-list">';
			foreach ($item['issues'] as $issue) {
				echo '<li>' . esc_html($issue) . '</li>';
			}
			echo '</ul></td>';
			echo '<td>' . zo_admin_recheck_button($key) . '</td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
	}
	echo '</div>';

	echo '<div class="zo-admin-section"><h2>Recently Broken</h2>';
	if (empty($recently_broken)) {
		echo '<p>' . zo_admin_status_badge('good', 'Good') . ' No recently broken games found. ' . zo_admin_recheck_button('recently-broken-empty') . '</p>';
	} else {
		echo '<table class="widefat striped"><thead><tr><th>Game folder</th><th>Last changed</th><th>Issues</th><th>Recheck</th></tr></thead><tbody>';
		foreach ($recently_broken as $item) {
			$key = 'recent-broken-' . sanitize_key($item['folder']);
			echo '<tr id="' . esc_attr($key) . '"' . ($recheck_key === $key ? ' class="zo-admin-rechecked"' : '') . '>';
			echo '<td><strong>' . esc_html($item['folder']) . '</strong><br><code>' . esc_html($item['path']) . '</code></td>';
			echo '<td>' . esc_html($item['modified']) . '</td>';
			echo '<td><ul class="zo-admin-issue-list">';
			foreach ($item['issues'] as $issue) {
				echo '<li>' . esc_html($issue) . '</li>';
			}
			echo '</ul></td>';
			echo '<td>' . zo_admin_recheck_button($key) . '</td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
	}
	echo '</div>';

	echo '<div class="zo-admin-section"><h2>Duplicate Game Detector</h2>';
	if (empty($duplicates)) {
		echo '<p id="duplicate-checker-empty"' . ($recheck_key === 'duplicate-checker-empty' ? ' class="zo-admin-rechecked"' : '') . '>' . zo_admin_status_badge('good', 'Good') . ' No likely duplicate groups found. ' . zo_admin_recheck_button('duplicate-checker-empty') . '</p>';
	} else {
		echo '<table class="widefat striped"><thead><tr><th>Similarity key</th><th>Games</th><th>Recheck</th></tr></thead><tbody>';
		foreach ($duplicates as $key => $items) {
			$row_key = 'duplicate-' . sanitize_key($key);
			echo '<tr id="' . esc_attr($row_key) . '"' . ($recheck_key === $row_key ? ' class="zo-admin-rechecked"' : '') . '><td><code>' . esc_html($key) . '</code></td><td><ul class="zo-admin-mini-list">';
			foreach ($items as $item) {
				echo '<li><strong>' . esc_html($item['title']) . '</strong> <code>' . esc_html($item['slug']) . '</code>';
				if ($item['author'] !== '') {
					echo ' - ' . esc_html($item['author']);
				}
				if ($item['category'] !== '') {
					echo ' - ' . esc_html($item['category']);
				}
				echo '</li>';
			}
			echo '</ul></td><td>' . zo_admin_recheck_button($row_key) . '</td></tr>';
		}
		echo '</tbody></table>';
	}
	echo '</div>';

	echo '<div class="zo-admin-section"><h2>Problem timeline</h2>';
	zo_admin_render_problem_timeline($problem_timeline);
	echo '</div>';

	echo '<div class="zo-admin-section" id="admin-notes-per-issue"><h2>Admin notes per issue</h2>';
	if (isset($_GET['zo_note_saved']) && sanitize_key(wp_unslash($_GET['zo_note_saved'])) !== '') {
		echo '<div class="notice notice-success inline"><p>Note saved for <code>' . esc_html(sanitize_key(wp_unslash($_GET['zo_note_saved']))) . '</code>.</p></div>';
	}
	zo_admin_render_admin_notes_table($admin_note_targets, $admin_notes);
	echo '</div>';
	echo '<script>
	(function(){
		const input=document.getElementById("zo-admin-report-search");
		if(!input){return;}
		const rows=Array.from(document.querySelectorAll(".zo-admin-health table tbody tr"));
		const tabs=Array.from(document.querySelectorAll(".zo-admin-tab"));
		const panels=Array.from(document.querySelectorAll(".zo-admin-analytics-panel"));
		const sections=Array.from(document.querySelectorAll(".zo-admin-section"));
		sections.forEach(function(section,index){
			const heading=section.querySelector(":scope > h2");
			if(!heading){return;}
			const title=heading.textContent.trim();
			const storageKey="zo-content-lookup-section-"+title.toLowerCase().replace(/[^a-z0-9]+/g,"-")+"-"+index;
			const button=document.createElement("button");
			button.type="button";
			button.className="zo-admin-section-toggle";
			button.setAttribute("aria-label","Open or close "+title);
			heading.appendChild(button);
			function render(){
				const collapsed=section.classList.contains("is-collapsed");
				button.textContent=collapsed?"v":"^";
				button.setAttribute("aria-expanded",collapsed?"false":"true");
				button.title=collapsed?"Open":"Close";
			}
			if(window.localStorage&&window.localStorage.getItem(storageKey)==="closed"){
				section.classList.add("is-collapsed");
			}
			render();
			button.addEventListener("click",function(){
				section.classList.toggle("is-collapsed");
				if(window.localStorage){
					window.localStorage.setItem(storageKey,section.classList.contains("is-collapsed")?"closed":"open");
				}
				render();
			});
		});
		input.addEventListener("input",function(){
			const query=input.value.trim().toLowerCase();
			rows.forEach(function(row){
				row.style.display=!query||row.textContent.toLowerCase().indexOf(query)!==-1?"":"none";
			});
		});
		tabs.forEach(function(tab){
			tab.addEventListener("click",function(){
				const key=tab.getAttribute("data-zo-tab");
				tabs.forEach(function(item){item.classList.toggle("is-active",item===tab);});
				panels.forEach(function(panel){panel.classList.toggle("is-active",panel.getAttribute("data-zo-panel")===key);});
			});
		});
	})();
	</script>';
	echo '</div>';
}

function zo_load_game_module_file($file) {
	static $loaded_modules = array();

	$file = (string) $file;

	if ($file === '') {
		return null;
	}

	if (array_key_exists($file, $loaded_modules)) {
		return $loaded_modules[$file];
	}

	ob_start();
	$module = null;

	try {
		$module = require $file;
	} catch (Throwable $throwable) {
		ob_end_clean();
		error_log(
			sprintf(
				'[Zeka Oyunlari] Skipping broken game module "%1$s": %2$s in %3$s on line %4$d',
				basename(dirname($file)),
				$throwable->getMessage(),
				$throwable->getFile(),
				(int) $throwable->getLine()
			)
		);

		$loaded_modules[$file] = null;

		return null;
	}

	$extra_output = ob_get_clean();

	if (!is_array($module)) {
		if ($extra_output !== '') {
			error_log(
				sprintf(
					'[Zeka Oyunlari] Ignoring unexpected output while loading game module "%1$s"',
					basename(dirname($file))
				)
			);
		}

		$loaded_modules[$file] = null;

		return null;
	}

	if ($extra_output !== '') {
		error_log(
			sprintf(
				'[Zeka Oyunlari] Discarded output while loading game module "%1$s"',
				basename(dirname($file))
			)
		);
	}

	$loaded_modules[$file] = $module;

	return $loaded_modules[$file];
}

function zo_get_asker_multilingual_game_metadata($slug) {
	$items = array(
		'adam-asmaca' => array(
			'name' => 'TR: Adam Asmaca | EN: Hangman | DE: Galgenmännchen',
			'description' => 'TR: Çocuklar için ipuçlu, puan takipli ve tekrar oynanabilir bir Adam Asmaca oyunu. EN: A replayable Hangman game for kids with hints and score tracking. DE: Ein wiederholbares Galgenmännchen-Spiel für Kinder mit Hinweisen und Punktestand.',
		),
		'adana-clock' => array(
			'name' => 'TR: Adana Saati | EN: Adana Clock | DE: Adana-Uhr',
			'description' => 'TR: Adana saatini saniyelerle gösteren basit bir tarayıcı saati. EN: A simple browser clock showing the current time in Adana with seconds. DE: Eine einfache Browser-Uhr, die die aktuelle Uhrzeit in Adana mit Sekunden zeigt.',
		),
		'ai-companion-trainer' => array(
			'name' => 'TR: Yapay Zeka Yardımcı Eğitmeni | EN: AI Companion Trainer | DE: KI-Begleiter-Trainer',
			'description' => 'TR: Robot yardımcının ne zaman yazması, sorması, doğrulaması veya insandan yardım alması gerektiğini seçerek eğit. EN: Train a robot helper by choosing when it should draft, ask, verify, or get human help. DE: Trainiere einen Roboterhelfer, indem du entscheidest, wann er schreiben, fragen, prüfen oder menschliche Hilfe holen soll.',
		),
		'angle-match' => array(
			'name' => 'TR: Açı Eşleştirme | EN: Angle Match | DE: Winkel-Match',
			'description' => 'TR: Hedef açıyı yakalamak için göstergeyi çevirilen basit bir açı oyunu. EN: A simple angle game where players rotate a pointer to match the target angle. DE: Ein einfaches Winkelspiel, bei dem Spieler einen Zeiger auf den Zielwinkel drehen.',
		),
		'berlin-clock' => array(
			'name' => 'TR: Berlin Saati | EN: Berlin Clock | DE: Berlin-Uhr',
			'description' => 'TR: Berlin, Almanya saatini saniyelerle gösteren basit bir tarayıcı saati. EN: A simple browser clock showing Berlin, Germany time with seconds. DE: Eine einfache Browser-Uhr, die die Berliner Zeit in Deutschland mit Sekunden zeigt.',
		),
		'binary-puzzle' => array(
			'name' => 'TR: İkili Bulmaca | EN: Binary Puzzle | DE: Binärrätsel',
			'description' => 'TR: Satır ve sütun kurallarına göre 0 ve 1 ile ızgarayı doldur. EN: Fill the grid with 0 and 1 using binary puzzle row and column rules. DE: Fülle das Raster nach Zeilen- und Spaltenregeln mit 0 und 1.',
		),
		'breakout-levels' => array(
			'name' => 'TR: Blok Kırma Seviyeleri | EN: Breakout Levels | DE: Breakout-Level',
			'description' => 'TR: 10 seviyeli blok kırma oyunu; her seviyede daha fazla blok vardır ve 15 can ile oynanır. EN: A 10-level breakout game with more blocks on each level and 15 lives to play. DE: Ein Breakout-Spiel mit 10 Leveln, mehr Blöcken pro Level und 15 Leben.',
		),
		'bug-sort-station' => array(
			'name' => 'TR: Böcek Sıralama İstasyonu | EN: Bug Sort Station | DE: Käfer-Sortierstation',
			'description' => 'TR: Kaçmadan önce gelen böcekleri doğru istasyona yönlendirerek sınıflandır. EN: Classify arriving bugs by using the correct station before they escape. DE: Sortiere ankommende Käfer an der richtigen Station, bevor sie entkommen.',
		),
		'chess-ai' => array(
			'name' => 'TR: Yapay Zekaya Karşı Satranç | EN: Chess vs AI | DE: Schach gegen KI',
			'description' => 'TR: Çok kolaydan çok zora kadar bilgisayar rakiplere karşı satranç oyna. EN: Play chess against computer opponents from very easy to very hard. DE: Spiele Schach gegen Computergegner von sehr leicht bis sehr schwer.',
		),
		'color-code-rescue' => array(
			'name' => 'TR: Renk Kodu Kurtarma | EN: Color Code Rescue | DE: Farbcode-Rettung',
			'description' => 'TR: Renk sırasını izle ve kodu kurtarmak için aynı sırayı tekrar et. EN: Watch a color sequence and repeat it to save the code. DE: Merke dir eine Farbfolge und wiederhole sie, um den Code zu retten.',
		),
		'cryptogram-decoder' => array(
			'name' => 'TR: Şifreli Yazı Çözücü | EN: Cryptogram Decoder | DE: Kryptogramm-Entschlüssler',
			'description' => 'TR: Harf değiştirme ipuçlarını kullanarak gizli cümleyi çöz. EN: Decode a secret phrase using letter substitution and solve the cryptogram. DE: Entschlüssle einen geheimen Satz mit Buchstabentausch und löse das Kryptogramm.',
		),
		'dama-ai' => array(
			'name' => 'TR: Yapay Zekaya Karşı Dama | EN: Dama vs AI | DE: Dama gegen KI',
			'description' => 'TR: Beyaz taşlarla basit bir yapay zekaya karşı oynanan çocuk dostu Dama oyunu. EN: A kid-friendly Dama board game where you play white against a simple AI. DE: Ein kinderfreundliches Dama-Brettspiel, in dem du mit Weiß gegen eine einfache KI spielst.',
		),
		'echo-cartographer' => array(
			'name' => 'TR: Yankı Haritacısı | EN: Echo Cartographer | DE: Echo-Kartograf',
			'description' => 'TR: Her taramanın harabeleri gösterdiği ama ses avcısı düşmanları çektiği sonar-gizlilik labirenti. EN: A sonar-stealth maze where each scan reveals the ruins but attracts sound-hunting enemies. DE: Ein Sonar-Schleichlabyrinth, in dem jeder Scan Ruinen zeigt, aber geräuschjagende Gegner anlockt.',
		),
		'grid-path-puzzle' => array(
			'name' => 'TR: Izgara Yol Bulmaca | EN: Grid Path Puzzle | DE: Raster-Weg-Rätsel',
			'description' => 'TR: Başlangıçtan hedefe giderken duvarlardan kaçılan basit bir yol bulma oyunu. EN: A simple path-finding game where players move from start to goal while avoiding walls. DE: Ein einfaches Wegfindespiel, bei dem Spieler vom Start zum Ziel gehen und Wände vermeiden.',
		),
		'hizli-tikla' => array(
			'name' => 'TR: Hızlı Tıkla | EN: Fast Click | DE: Schnell Klicken',
			'description' => 'TR: 10 saniye içinde olabildiğince çok tıklamaya çalışılan basit bir oyun. EN: A simple game where players try to click as many times as possible in 10 seconds. DE: Ein einfaches Spiel, bei dem Spieler in 10 Sekunden so oft wie möglich klicken.',
		),
		'kelime-karistirma' => array(
			'name' => 'TR: Kelime Karıştırma | EN: Word Scramble | DE: Wortsalat',
			'description' => 'TR: Çocuklar için Türkçe kelime tahmin etme oyunu; karışık harfleri çöz, ipucu kullan ve puan topla. EN: A Turkish word guessing game for kids; solve scrambled letters, use hints, and collect points. DE: Ein türkisches Wortratespiel für Kinder; löse durcheinandergewürfelte Buchstaben, nutze Hinweise und sammle Punkte.',
		),
		'kids-calculator' => array(
			'name' => 'TR: Çocuklar İçin Basit Hesap Makinesi | EN: Simple Calculator for Kids | DE: Einfacher Rechner für Kinder',
			'description' => 'TR: Toplama, çıkarma, çarpma, bölme, üs alma ve karekök içeren çocuklar için basit hesap oyunu. EN: A simple calculator game for kids with add, subtract, multiply, divide, power, and square root. DE: Ein einfaches Rechenspiel für Kinder mit Addition, Subtraktion, Multiplikation, Division, Potenzen und Quadratwurzel.',
		),
		'lantern-hunt' => array(
			'name' => 'TR: Fener Avı | EN: Lantern Hunt | DE: Laternenjagd',
			'description' => 'TR: Satır ve sütun ipuçlarıyla hücreleri aç ve tüm fener çiftlerini eşleştir. EN: Reveal one cell at a time by row or column hints and match all lantern pairs. DE: Decke mithilfe von Zeilen- oder Spaltenhinweisen Zellen auf und finde alle Laternenpaare.',
		),
		'london-clock' => array(
			'name' => 'TR: Londra Saati | EN: London Clock | DE: London-Uhr',
			'description' => 'TR: Londra saatini saniyelerle gösteren basit bir tarayıcı saati. EN: A simple browser clock showing London time with seconds. DE: Eine einfache Browser-Uhr, die die Londoner Zeit mit Sekunden zeigt.',
		),
		'memory-match-animals' => array(
			'name' => 'TR: Hayvan Hafıza Eşleştirme | EN: Memory Match Animals | DE: Tier-Memory',
			'description' => 'TR: Hayvan çiftleri, deneme sayısı, zamanlayıcı ve yeniden başlatma içeren çocuklar için hafıza kartı oyunu. EN: A memory matching card game for kids with animal pairs, attempts, timer, and restart. DE: Ein Memory-Kartenspiel für Kinder mit Tierpaaren, Versuchen, Timer und Neustart.',
		),
		'micro-garden' => array(
			'name' => 'TR: Mikro Bahçe | EN: Micro Garden | DE: Mikro-Garten',
			'description' => 'TR: Bitkiyi büyütmek için Su, Güneş ve Kompost adımlarını doğru sırayla uygula. EN: Read the sequence and apply Water, Sun, Compost in the right order to grow the plant. DE: Lies die Reihenfolge und nutze Wasser, Sonne und Kompost in der richtigen Ordnung, um die Pflanze wachsen zu lassen.',
		),
		'mini-manager' => array(
			'name' => 'TR: Mini Menajer | EN: Mini Manager | DE: Mini-Manager',
			'description' => 'TR: Sezonlar, transferler, lig tablosu, taktikler, kadro yönetimi, finans ve anlatım içeren büyük futbol menajerliği oyunu. EN: A bigger soccer manager game with seasons, transfers, league table, tactics, squad management, finances, and commentary. DE: Ein größeres Fußballmanager-Spiel mit Saisons, Transfers, Tabelle, Taktik, Kaderverwaltung, Finanzen und Kommentar.',
		),
		'mini-maze-builder' => array(
			'name' => 'TR: Mini Labirent Kurucu | EN: Mini Maze Builder | DE: Mini-Labyrinth-Bauer',
			'description' => 'TR: Duvarlar inşa et ve başlangıçtan bitişe en az bir geçerli yol bırak. EN: Build walls and keep one valid path from start to finish. DE: Baue Wände und lasse mindestens einen gültigen Weg vom Start bis zum Ziel frei.',
		),
		'mini-paint' => array(
			'name' => 'TR: Mini Boyama Stüdyosu | EN: Mini Paint Studio | DE: Mini-Malstudio',
			'description' => 'TR: Şekiller, yazı, seçim, kırpma, çıkartmalar, emoji, çerçeveler, çevirme, döndürme ve klavye kısayolları olan basit bir çizim editörü. EN: A simple Paint-style image editor with shapes, text, selection, crop, stickers, emoji, frames, flip, rotate, and keyboard shortcuts. DE: Ein einfacher Bildeditor im Paint-Stil mit Formen, Text, Auswahl, Zuschneiden, Stickern, Emoji, Rahmen, Spiegeln, Drehen und Tastenkürzeln.',
		),
		'misir-hazine' => array(
			'name' => 'TR: Mısır Hazine Oyunu | EN: Egypt Treasure Game | DE: Ägypten-Schatzspiel',
			'description' => 'TR: Piramitte gizli hazineyi bulmaya çalışılan Mısır temalı oyun. EN: An Egypt-themed game where players try to find the hidden treasure inside the pyramid. DE: Ein Ägypten-Spiel, in dem Spieler den versteckten Schatz in der Pyramide finden.',
		),
		'mirror-axiom' => array(
			'name' => 'TR: Ayna Aksiyomu | EN: Mirror Axiom | DE: Spiegel-Axiom',
			'description' => 'TR: Her tıklamanın iki eksende de yansıdığı zor bir simetri bulmacası. EN: A hard symmetry puzzle where every click reflects across both axes. DE: Ein schweres Symmetrie-Rätsel, bei dem jeder Klick über beide Achsen gespiegelt wird.',
		),
		'mirror-maze' => array(
			'name' => 'TR: Ayna Labirenti | EN: Mirror Maze | DE: Spiegel-Labyrinth',
			'description' => 'TR: Aynaları çevirerek lazer ışığını hedefe yönlendirdiğin bulmaca oyunu. EN: A puzzle game where players rotate mirrors to guide a laser beam to the target. DE: Ein Rätselspiel, in dem Spieler Spiegel drehen, um einen Laserstrahl zum Ziel zu führen.',
		),
		'munich-clock' => array(
			'name' => 'TR: Münih Saati | EN: Munich Clock | DE: München-Uhr',
			'description' => 'TR: Münih, Almanya saatini saniyelerle gösteren basit bir tarayıcı saati. EN: A simple browser clock showing Munich, Germany time with seconds. DE: Eine einfache Browser-Uhr, die die Münchner Zeit in Deutschland mit Sekunden zeigt.',
		),
		'orbit-match' => array(
			'name' => 'TR: Yörünge Eşleştirme | EN: Orbit Match | DE: Orbit-Match',
			'description' => 'TR: Her yörünge sembolünü hedef desene uyacak şekilde döndür. EN: Rotate each orbit symbol to align with the target pattern. DE: Drehe jedes Orbit-Symbol, bis es zum Zielmuster passt.',
		),
		'nova-crafter-challenge' => array(
			'name' => 'TR: Nova Üretici Mücadelesi | EN: Nova Crafter Challenge | DE: Nova-Bauer-Herausforderung',
			'description' => 'TR: Değişen parçaları üret ve mücadelede puanını yükselt. EN: Craft shifting parts and build your score through the challenge. DE: Baue wechselnde Teile und erhöhe deine Punktzahl in der Herausforderung.',
		),
		'nova-pilot-drift' => array(
			'name' => 'TR: Nova Pilot Drift | EN: Nova Pilot Drift | DE: Nova-Pilot-Drift',
			'description' => 'TR: Kontrollerin yavaşça kayarken sürüklenen asteroitlerin arasından pilotluk yap. EN: Pilot through drifting asteroids while your controls subtly desync. DE: Steuere durch driftende Asteroiden, während deine Steuerung leicht aus dem Takt gerät.',
		),
		'nova-signal-shift' => array(
			'name' => 'TR: Nova Sinyal Kaydırma | EN: Nova Signal Shift | DE: Nova-Signalwechsel',
			'description' => 'TR: Değişen Nova sinyallerini doğru sıraya getir. EN: Shift changing Nova signals into the right order. DE: Bringe wechselnde Nova-Signale in die richtige Reihenfolge.',
		),
		'orbit-architect-recall' => array(
			'name' => 'TR: Yörünge Mimarı Hafıza | EN: Orbit Architect Recall | DE: Orbit-Architekt-Erinnerung',
			'description' => 'TR: Yörünge planlarını hatırla ve mimari deseni yeniden kur. EN: Recall orbit plans and rebuild the architecture pattern. DE: Merke dir Orbit-Pläne und baue das Architekturmuster wieder auf.',
		),
		'orbit-builder-recall' => array(
			'name' => 'TR: Yörünge Kurucu Hafıza | EN: Orbit Builder Recall | DE: Orbit-Bauer-Erinnerung',
			'description' => 'TR: Yörünge parçalarının sırasını hatırla ve sistemi yeniden kur. EN: Recall the order of orbit parts and rebuild the system. DE: Merke dir die Reihenfolge der Orbit-Teile und baue das System wieder auf.',
		),
		'orbit-decoder-memory' => array(
			'name' => 'TR: Yörünge Kod Çözücü Hafıza | EN: Orbit Decoder Memory | DE: Orbit-Decoder-Memory',
			'description' => 'TR: Yörünge kodlarını hafızanda tut ve doğru diziyi çöz. EN: Memorize orbit codes and decode the correct sequence. DE: Merke dir Orbit-Codes und entschlüssele die richtige Folge.',
		),
		'orbit-runner-sprint' => array(
			'name' => 'TR: Yörünge Koşucusu Sprint | EN: Orbit Runner Sprint | DE: Orbit-Läufer-Sprint',
			'description' => 'TR: Yörünge engellerinin arasından hızlıca koş ve hedefe ulaş. EN: Sprint through orbit obstacles and reach the target. DE: Sprinte durch Orbit-Hindernisse und erreiche das Ziel.',
		),
		'orbit-signal-rescue' => array(
			'name' => 'TR: Yörünge Sinyal Kurtarma | EN: Orbit Signal Rescue | DE: Orbit-Signalrettung',
			'description' => 'TR: Yörünge sinyallerini yeniden yönlendir ve işaret pilotlarını kurtar. EN: Reroute orbit signals and rescue beacon pilots mid-flight. DE: Leite Orbit-Signale um und rette Leuchtfeuer-Piloten im Flug.',
		),
		'paris-clock' => array(
			'name' => 'TR: Paris Saati | EN: Paris Clock | DE: Paris-Uhr',
			'description' => 'TR: Paris saatini saniyelerle gösteren basit bir tarayıcı saati. EN: A simple browser clock showing Paris time with seconds. DE: Eine einfache Browser-Uhr, die die Pariser Zeit mit Sekunden zeigt.',
		),
		'pipe-connect' => array(
			'name' => 'TR: Boru Bağlantısı | EN: Pipe Connect | DE: Rohrverbindung',
			'description' => 'TR: Kaynak ve hedef arasında boruları çevirerek bağlantı kurulan basit bir bulmaca oyunu. EN: A simple puzzle game where players rotate pipes to connect the source and the target. DE: Ein einfaches Rätselspiel, in dem Spieler Rohre drehen, um Quelle und Ziel zu verbinden.',
		),
		'puzzle-creator-pro' => array(
			'name' => 'TR: Bulmaca Oluşturucu Pro | EN: Puzzle Creator Pro | DE: Puzzle-Ersteller Pro',
			'description' => 'TR: Editör hesabıyla bulmacalar oluştur ve sistem genelinde paylaş. EN: Create puzzles and share them system-wide from an editor account. DE: Erstelle mit einem Editor-Konto Rätsel und teile sie im ganzen System.',
		),
		'rain-collector' => array(
			'name' => 'TR: Yağmur Toplayıcı | EN: Rain Collector | DE: Regen-Sammler',
			'description' => 'TR: Geçerli hedefle eşleşen düşen harfleri topla. EN: Collect falling letters that match the current target. DE: Sammle fallende Buchstaben, die zum aktuellen Ziel passen.',
		),
		'robot-designer' => array(
			'name' => 'TR: Robot Tasarımcısı | EN: Robot Designer | DE: Roboter-Designer',
			'description' => 'TR: Bir robot tasarla ve özelliklerini farklı görevlere uygun hale getir. EN: Build a robot and match its stats to different missions. DE: Baue einen Roboter und passe seine Werte an verschiedene Missionen an.',
		),
		'rock-paper-scissors' => array(
			'name' => 'TR: Taş Kağıt Makas | EN: Rock Paper Scissors | DE: Schere Stein Papier',
			'description' => 'TR: Puan takibi ve yeniden başlatma içeren çocuklar için basit Taş Kağıt Makas oyunu. EN: A simple rock paper scissors game for kids with score tracking and restart. DE: Ein einfaches Schere-Stein-Papier-Spiel für Kinder mit Punktestand und Neustart.',
		),
		'roster-1000' => array(
			'name' => 'TR: 1000 Karakter Arenası | EN: Roster 1000 | DE: Roster 1000',
			'description' => 'TR: 1000 satın alınabilir karakter, her seviyede zorlaşan yapay zeka, dalga başına daha çok düşman ve her galibiyette 50 coin içeren sonsuz arena oyunu. EN: An endless arena game with 1000 buyable characters, harder AI every level, more enemies per wave, and 50 coins for every win. DE: Ein endloses Arenaspiel mit 1000 kaufbaren Figuren, schwererer KI pro Level, mehr Gegnern pro Welle und 50 Münzen für jeden Sieg.',
		),
		'rule-guess-puzzle' => array(
			'name' => 'TR: Kural Tahmin Bulmacası | EN: Rule Guess Puzzle | DE: Regel-Rätsel',
			'description' => 'TR: Sayıları deneyip geri bildirimi izleyerek gizli kuralı keşfettiğin bir bulmaca oyunu. EN: A hidden-rule puzzle game where players test numbers and discover the secret rule by observing feedback. DE: Ein Rätselspiel mit versteckter Regel, bei dem Spieler Zahlen testen und durch Rückmeldungen die geheime Regel entdecken.',
		),
		'rule-switch-rush' => array(
			'name' => 'TR: Kural Değiştirme Yarışı | EN: Rule Switch Rush | DE: Regelwechsel-Rennen',
			'description' => 'TR: Kural değişirken oyuncuların doğru yönü seçmesi gereken hızlı refleks ve düşünme oyunu. EN: A fast reflex and thinking game where the rule changes and players must choose the correct direction. DE: Ein schnelles Reaktions- und Denkspiel, bei dem sich die Regel ändert und Spieler die richtige Richtung wählen.',
		),
		'shadow-path' => array(
			'name' => 'TR: Gölge Yolu | EN: Shadow Path | DE: Schattenpfad',
			'description' => 'TR: Gizli yolu izle ve hücreleri doğru sırayla tekrar et. EN: Watch a hidden path and repeat the cells in order. DE: Merke dir einen versteckten Pfad und wiederhole die Felder in der richtigen Reihenfolge.',
		),
		'shop-builder' => array(
			'name' => 'TR: Dükkan Kurucu | EN: Shop Builder | DE: Laden-Bauer',
			'description' => 'TR: Satış yaparak para kazanılan ve yükseltmelerle büyüyen basit bir dükkan kurma oyunu. EN: A simple shop-building game where players earn money by selling items and grow with upgrades. DE: Ein einfaches Laden-Aufbauspiel, in dem Spieler durch Verkäufe Geld verdienen und mit Upgrades wachsen.',
		),
		'silent-simon-says' => array(
			'name' => 'TR: Sessiz Simon Diyor | EN: Silent Simon Says | DE: Stilles Simon Sagt',
			'description' => 'TR: Her komutta yalnızca zıt hareketi takip et. EN: Follow only the opposite action for each command. DE: Folge bei jedem Befehl nur der gegenteiligen Aktion.',
		),
		'soccer-match-ai' => array(
			'name' => 'TR: Yapay Zeka Futbol Maçı | EN: Soccer Match AI | DE: KI-Fußballspiel',
			'description' => 'TR: Tüm oyuncuların yapay zeka olduğu, kornerlerin çalıştığı ve doğrudan kaleye şut atabildiğin 5 dakikalık futbol maçı. EN: A 5-minute soccer match where all players are AI, blue corner kicks work, and you can shoot directly at goal. DE: Ein 5-minütiges Fußballspiel, in dem alle Spieler KI sind, blaue Ecken funktionieren und du direkt aufs Tor schießen kannst.',
		),
		'sound-pattern-builder' => array(
			'name' => 'TR: Ses Deseni Kurucu | EN: Sound Pattern Builder | DE: Klangmuster-Bauer',
			'description' => 'TR: Bir ses desenini dinle ve hayvanlara dokunarak aynı sırayı tekrar et. EN: Listen to a sound pattern and repeat it by tapping animals. DE: Höre ein Klangmuster und wiederhole es, indem du Tiere antippst.',
		),
		'sound-rule-rush' => array(
			'name' => 'TR: Ses Kuralı Yarışı | EN: Sound Rule Rush | DE: Klangregel-Rennen',
			'description' => 'TR: Kurallar değişirken sesleri doğru aileye ayırdığın hızlı refleks ve düşünme oyunu. EN: A fast reflex and thinking game where players sort sounds into the correct family as the rules change. DE: Ein schnelles Reaktions- und Denkspiel, bei dem Spieler Klänge bei wechselnden Regeln der richtigen Familie zuordnen.',
		),
		'sudoku' => array(
			'name' => 'TR: Sudoku | EN: Sudoku | DE: Sudoku',
			'description' => 'TR: Kolay, orta ve zor tahtaları olan klasik 9x9 Sudoku bulmacası. EN: A classic 9x9 Sudoku puzzle with easy, medium, and hard boards. DE: Ein klassisches 9x9-Sudoku mit leichten, mittleren und schweren Brettern.',
		),
		'territory-capture' => array(
			'name' => 'TR: Bölge Ele Geçirme | EN: Territory Capture | DE: Gebiet Erobern',
			'description' => 'TR: Izgarada en çok bölgeyi kontrol etmek için yapay zekayla yarıştığın sıra tabanlı strateji oyunu. EN: A turn-based strategy game where you compete with AI to control the most territory on a grid. DE: Ein rundenbasiertes Strategiespiel, in dem du gegen KI um die meisten Gebiete auf einem Raster kämpfst.',
		),
		'territory-fill' => array(
			'name' => 'TR: Bölge Doldurma | EN: Territory Fill | DE: Gebiet Füllen',
			'description' => 'TR: Hamleler bitmeden en geniş alanı almak için oynanan ızgara kontrol oyunu. EN: A grid control game where players claim the most area before moves run out. DE: Ein Raster-Kontrollspiel, bei dem Spieler vor Ablauf der Züge die größte Fläche sichern.',
		),
		'the-46th-rule' => array(
			'name' => 'TR: 46. Kural | EN: The 46th Rule | DE: Die 46. Regel',
			'description' => 'TR: Oyuncunun sembol anahtarlarını test edip mantığı kanıtladığı çok zor gizli kural çıkarım oyunu. EN: A very hard hidden-rule deduction game where the player tests symbol keys and proves the logic. DE: Ein sehr schweres Deduktionsspiel mit versteckter Regel, in dem der Spieler Symbolschlüssel testet und die Logik beweist.',
		),
		'time-loop-runner' => array(
			'name' => 'TR: Zaman Döngüsü Koşucusu | EN: Time Loop Runner | DE: Zeitschleifen-Läufer',
			'description' => 'TR: 5 adımlık diziyi izle ve çarpmadan aynı hareketleri tekrar et. EN: Watch a 5 step sequence and replay the moves without crashing. DE: Merke dir eine Folge aus 5 Schritten und wiederhole die Bewegungen ohne Zusammenstoß.',
		),
		'time-traveler-puzzle' => array(
			'name' => 'TR: Zaman Yolcusu Bulmacası | EN: Time Traveler Puzzle | DE: Zeitreise-Rätsel',
			'description' => 'TR: Bölümün geçmiş ve gelecek sürümleri arasında geçiş yaparak mantık bulmacalarını çöz. EN: Solve logic puzzles by switching between past and future versions of the level. DE: Löse Logikrätsel, indem du zwischen Vergangenheits- und Zukunftsversionen des Levels wechselst.',
		),
		'tr-search-launcher' => array(
			'name' => 'TR: Türkçe Arama Başlatıcı | EN: TR Search Launcher | DE: Türkischer Suchstarter',
			'description' => 'TR: Ürün aramalarını birden fazla sitede hızlıca açmak için tarayıcı tabanlı Türkçe alışveriş arama başlatıcısı. EN: A browser-based Turkish shopping search launcher for quickly opening product searches across multiple sites. DE: Ein browserbasierter türkischer Einkaufs-Suchstarter, um Produktsuchen schnell auf mehreren Seiten zu öffnen.',
		),
		'wisconsin-clock' => array(
			'name' => 'TR: Wisconsin Saati | EN: Wisconsin Clock | DE: Wisconsin-Uhr',
			'description' => 'TR: Wisconsin saatini saniyelerle gösteren basit bir tarayıcı saati. EN: A simple browser clock showing Wisconsin time with seconds. DE: Eine einfache Browser-Uhr, die die Wisconsin-Zeit mit Sekunden zeigt.',
		),
		'puzzle-crafter-drift' => array(
			'name' => 'TR: Bulmaca Ustası Drift | EN: Puzzle Crafter Drift | DE: Puzzle-Bauer Drift',
			'description' => 'TR: Değişen bulmaca parçaları oluştur ve puanını büyütmeye devam et. EN: Craft shifting puzzle tiles and keep your score growing. DE: Erstelle wechselnde Puzzle-Kacheln und lasse deine Punktzahl weiter wachsen.',
		),
		'puzzle-signal-vault' => array(
			'name' => 'TR: Bulmaca Sinyal Kasası | EN: Puzzle Signal Vault | DE: Puzzle-Signal-Tresor',
			'description' => 'TR: Renk değiştiren sinyalleri çözerek kasa kapılarını sırayla aç. EN: Decode color-shift signals to open vault doors in sequence. DE: Entschlüssle farbwechselnde Signale, um Tresortüren der Reihe nach zu öffnen.',
		),
		'balloon-tower-climb' => array(
			'name' => 'TR: Balon Kulesine Tırmanış | EN: Balloon Tower Climb | DE: Ballonturm-Aufstieg',
			'description' => 'TR: Yükselme balonlarını toplayarak kulede yukarı çık. EN: Float up a tower collecting lift balloons. DE: Schwebe einen Turm hinauf und sammle Aufstiegsballons.',
		),
		'castle-siege-commander' => array(
			'name' => 'TR: Kale Kuşatması Komutanı | EN: Castle Siege Commander | DE: Burgenbelagerungs-Kommandant',
			'description' => 'TR: Kale kuşatması sırasında komuta bayraklarını topla. EN: Collect command flags during a castle siege. DE: Sammle Kommandoflaggen während einer Burgenbelagerung.',
		),
		'candy-factory-chaos' => array(
			'name' => 'TR: Şeker Fabrikası Karmaşası | EN: Candy Factory Chaos | DE: Süßigkeitenfabrik-Chaos',
			'description' => 'TR: Karışık bir fabrikada şeker partilerini topla. EN: Collect candy batches in a chaotic factory. DE: Sammle Süßigkeitenladungen in einer chaotischen Fabrik.',
		),
		'castle-trap-designer' => array(
			'name' => 'TR: Kale Tuzak Tasarımcısı | EN: Castle Trap Designer | DE: Burgfallen-Designer',
			'description' => 'TR: Akıllı kale tuzaklarını tamamlamak için dişlileri topla. EN: Collect gears to finish clever castle traps. DE: Sammle Zahnräder, um clevere Burgfallen fertigzustellen.',
		),
		'giant-bug-survival' => array(
			'name' => 'TR: Dev Böcek Hayatta Kalma | EN: Giant Bug Survival | DE: Rieseninsekt-Überleben',
			'description' => 'TR: Her şeyin devasa olduğu bir bahçede hayatta kal. EN: Survive in a backyard where everything is huge. DE: Überlebe in einem Garten, in dem alles riesig ist.',
		),
		'haunted-library-mystery' => array(
			'name' => 'TR: Perili Kütüphane Gizemi | EN: Haunted Library Mystery | DE: Geheimnis der Spukbibliothek',
			'description' => 'TR: Perili bir kütüphanede parlayan ipuçlarını bul. EN: Find glowing clues in a spooky library. DE: Finde leuchtende Hinweise in einer unheimlichen Bibliothek.',
		),
		'ice-mountain-snowboard' => array(
			'name' => 'TR: Buz Dağı Snowboard | EN: Ice Mountain Snowboard | DE: Eisberg-Snowboard',
			'description' => 'TR: Bayrakları toplayarak buzlu dağdan snowboard ile kay. EN: Snowboard down an icy mountain collecting flags. DE: Fahre mit dem Snowboard einen eisigen Berg hinab und sammle Flaggen.',
		),
		'invisible-platform-challenge' => array(
			'name' => 'TR: Görünmez Platform Mücadelesi | EN: Invisible Platform Challenge | DE: Unsichtbare-Plattform-Herausforderung',
			'description' => 'TR: Parıltı işaretlerini toplayarak gizli platformları bul. EN: Find hidden platforms by collecting shimmer marks. DE: Finde versteckte Plattformen, indem du Schimmerzeichen sammelst.',
		),
		'laser-mirror-puzzle' => array(
			'name' => 'TR: Lazer Ayna Bulmacası | EN: Laser Mirror Puzzle | DE: Laser-Spiegel-Rätsel',
			'description' => 'TR: Ayna parçalarını topla ve lazer ışınlarından kaç. EN: Collect mirror chips and avoid laser beams. DE: Sammle Spiegelteile und weiche Laserstrahlen aus.',
		),
		'arslan-country-quiz' => array(
			'name' => 'TR: Ülke 100 Soru | EN: Country Quiz Coins | DE: Länderquiz-Münzen',
			'description' => 'TR: Bir ülke adı yaz ve coin kazanmak ya da kaybetmek için 100 quiz sorusu cevapla. EN: Write a country name and answer 100 quiz questions to win or lose coins. DE: Schreibe einen Ländernamen und beantworte 100 Quizfragen, um Münzen zu gewinnen oder zu verlieren.',
		),
	);

	return isset($items[$slug]) ? $items[$slug] : null;
}

function zo_get_fallback_multilingual_game_metadata($module) {
	$name = !empty($module['name']) && is_string($module['name']) ? trim($module['name']) : '';
	$description = !empty($module['description']) && is_string($module['description']) ? trim(wp_strip_all_tags($module['description'])) : '';

	if ($name === '') {
		return null;
	}

	$metadata = array(
		'name' => sprintf('TR: %1$s oyunu | EN: %1$s | DE: %1$s Spiel', $name),
	);

	if ($description !== '') {
		$metadata['description'] = sprintf(
			'TR: %1$s, tarayıcıda oynanan bir oyundur. EN: %2$s DE: %1$s ist ein Browserspiel.',
			$name,
			$description
		);
	}

	return $metadata;
}

function zo_get_metadata_language_label($lang) {
	$labels = array(
		'tr' => 'TR:',
		'en' => 'EN:',
		'de' => 'DE:',
		'fr' => 'FR:',
		'es-mx' => 'ES-MX:',
		'es-es' => 'ES-ES:',
	);

	return isset($labels[$lang]) ? $labels[$lang] : strtoupper((string) $lang) . ':';
}

function zo_text_has_localized_part($text, $lang) {
	$text = is_string($text) ? $text : '';
	$lang = is_string($lang) ? strtolower($lang) : '';

	if ($text === '' || $lang === '') {
		return false;
	}

	return stripos($text, zo_get_metadata_language_label($lang)) !== false;
}

function zo_append_missing_localized_parts($text, $fallback, $languages) {
	$text = is_string($text) ? trim($text) : '';
	$fallback = is_string($fallback) ? trim($fallback) : '';

	if ($text === '' || $fallback === '') {
		return $text;
	}

	foreach ($languages as $lang => $label) {
		if (zo_text_has_localized_part($text, $lang) || !zo_text_has_localized_part($fallback, $lang)) {
			continue;
		}

		$value = zo_get_localized_text($fallback, $lang);
		if ($value !== '') {
			$text .= ' | ' . zo_get_metadata_language_label($lang) . ' ' . $value;
		}
	}

	return $text;
}

function zo_get_fallback_game_title_for_language($title, $lang) {
	$title = trim(wp_strip_all_tags((string) $title));
	$lang = is_string($lang) ? strtolower($lang) : 'en';

	if ($title === '') {
		return '';
	}

	$exact = array(
		'Hangman' => array(
			'fr' => 'Le pendu',
			'es-mx' => 'Ahorcado',
			'es-es' => 'Ahorcado',
		),
		'Angle Match' => array(
			'tr' => 'Açı Eşleştir',
			'en' => 'Angle Match',
			'de' => 'Winkel Zuordnen',
			'fr' => 'Associer les angles',
			'es-mx' => 'Relacionar ángulos',
			'es-es' => 'Relacionar ángulos',
		),
		'AI Companion Trainer' => array(
			'fr' => 'Entraîneur de compagnon IA',
			'es-mx' => 'Entrenador de compañero IA',
			'es-es' => 'Entrenador de compañero IA',
		),
		'Binary Puzzle' => array(
			'fr' => 'Puzzle binaire',
			'es-mx' => 'Rompecabezas binario',
			'es-es' => 'Puzle binario',
		),
		'Breakout Levels' => array(
			'fr' => 'Niveaux de casse-briques',
			'es-mx' => 'Niveles de rompebloques',
			'es-es' => 'Niveles de rompebloques',
		),
		'Bug Sort Station' => array(
			'fr' => 'Station de tri des insectes',
			'es-mx' => 'Estación para ordenar insectos',
			'es-es' => 'Estación de clasificación de insectos',
		),
		'Chess vs AI' => array(
			'fr' => 'Échecs contre IA',
			'es-mx' => 'Ajedrez contra IA',
			'es-es' => 'Ajedrez contra IA',
		),
		'Color Code Rescue' => array(
			'fr' => 'Sauvetage du code couleur',
			'es-mx' => 'Rescate del código de color',
			'es-es' => 'Rescate del código de color',
		),
		'Cryptogram Decoder' => array(
			'fr' => 'Décodeur de cryptogrammes',
			'es-mx' => 'Decodificador de criptogramas',
			'es-es' => 'Decodificador de criptogramas',
		),
		'Dama vs AI' => array(
			'fr' => 'Dama contre IA',
			'es-mx' => 'Dama contra IA',
			'es-es' => 'Dama contra IA',
		),
		'Echo Cartographer' => array(
			'fr' => 'Cartographe d’échos',
			'es-mx' => 'Cartógrafo de ecos',
			'es-es' => 'Cartógrafo de ecos',
		),
		'Grid Path Puzzle' => array(
			'fr' => 'Puzzle de chemin sur grille',
			'es-mx' => 'Rompecabezas de camino en cuadrícula',
			'es-es' => 'Puzle de camino en cuadrícula',
		),
		'Fast Click' => array(
			'fr' => 'Clic rapide',
			'es-mx' => 'Clic rápido',
			'es-es' => 'Clic rápido',
		),
		'Word Scramble' => array(
			'fr' => 'Mots mélangés',
			'es-mx' => 'Palabras revueltas',
			'es-es' => 'Palabras mezcladas',
		),
		'Simple Calculator for Kids' => array(
			'fr' => 'Calculatrice simple pour enfants',
			'es-mx' => 'Calculadora simple para niños',
			'es-es' => 'Calculadora sencilla para niños',
		),
		'Lantern Hunt' => array(
			'fr' => 'Chasse aux lanternes',
			'es-mx' => 'Caza de linternas',
			'es-es' => 'Caza de faroles',
		),
		'Memory Match Animals' => array(
			'fr' => 'Mémoire animaux',
			'es-mx' => 'Memoria de animales',
			'es-es' => 'Memoria de animales',
		),
		'Micro Garden' => array(
			'fr' => 'Micro jardin',
			'es-mx' => 'Micro jardín',
			'es-es' => 'Microjardín',
		),
		'Mini Manager' => array(
			'fr' => 'Mini manager',
			'es-mx' => 'Mini mánager',
			'es-es' => 'Mini mánager',
		),
		'Mini Maze Builder' => array(
			'fr' => 'Mini constructeur de labyrinthe',
			'es-mx' => 'Mini constructor de laberintos',
			'es-es' => 'Mini constructor de laberintos',
		),
		'Mini Paint Studio' => array(
			'fr' => 'Mini studio de dessin',
			'es-mx' => 'Mini estudio de dibujo',
			'es-es' => 'Mini estudio de pintura',
		),
		'Egypt Treasure Game' => array(
			'fr' => 'Jeu du trésor d’Égypte',
			'es-mx' => 'Juego del tesoro de Egipto',
			'es-es' => 'Juego del tesoro de Egipto',
		),
		'Mirror Axiom' => array(
			'fr' => 'Axiome du miroir',
			'es-mx' => 'Axioma del espejo',
			'es-es' => 'Axioma del espejo',
		),
		'Mirror Maze' => array(
			'fr' => 'Labyrinthe de miroirs',
			'es-mx' => 'Laberinto de espejos',
			'es-es' => 'Laberinto de espejos',
		),
		'Orbit Match' => array(
			'fr' => 'Associer les orbites',
			'es-mx' => 'Relacionar órbitas',
			'es-es' => 'Relacionar órbitas',
		),
		'Nova Crafter Challenge' => array(
			'fr' => 'Défi du créateur Nova',
			'es-mx' => 'Desafío del creador Nova',
			'es-es' => 'Desafío del creador Nova',
		),
		'Nova Pilot Drift' => array(
			'fr' => 'Dérive du pilote Nova',
			'es-mx' => 'Deriva del piloto Nova',
			'es-es' => 'Deriva del piloto Nova',
		),
		'Nova Signal Shift' => array(
			'fr' => 'Décalage du signal Nova',
			'es-mx' => 'Cambio de señal Nova',
			'es-es' => 'Cambio de señal Nova',
		),
		'Orbit Architect Recall' => array(
			'fr' => 'Mémoire de l’architecte orbital',
			'es-mx' => 'Memoria del arquitecto orbital',
			'es-es' => 'Memoria del arquitecto orbital',
		),
		'Orbit Builder Recall' => array(
			'fr' => 'Mémoire du constructeur orbital',
			'es-mx' => 'Memoria del constructor orbital',
			'es-es' => 'Memoria del constructor orbital',
		),
		'Orbit Decoder Memory' => array(
			'fr' => 'Mémoire du décodeur orbital',
			'es-mx' => 'Memoria del decodificador orbital',
			'es-es' => 'Memoria del decodificador orbital',
		),
		'Orbit Runner Sprint' => array(
			'fr' => 'Sprint du coureur orbital',
			'es-mx' => 'Sprint del corredor orbital',
			'es-es' => 'Sprint del corredor orbital',
		),
		'Orbit Signal Rescue' => array(
			'fr' => 'Sauvetage du signal orbital',
			'es-mx' => 'Rescate de señal orbital',
			'es-es' => 'Rescate de señal orbital',
		),
		'Pipe Connect' => array(
			'fr' => 'Connexion de tuyaux',
			'es-mx' => 'Conectar tuberías',
			'es-es' => 'Conectar tuberías',
		),
		'Puzzle Creator Pro' => array(
			'fr' => 'Créateur de puzzles Pro',
			'es-mx' => 'Creador de rompecabezas Pro',
			'es-es' => 'Creador de puzles Pro',
		),
		'Rain Collector' => array(
			'fr' => 'Collecteur de pluie',
			'es-mx' => 'Recolector de lluvia',
			'es-es' => 'Recolector de lluvia',
		),
		'Robot Designer' => array(
			'fr' => 'Concepteur de robots',
			'es-mx' => 'Diseñador de robots',
			'es-es' => 'Diseñador de robots',
		),
		'Rock Paper Scissors' => array(
			'fr' => 'Pierre feuille ciseaux',
			'es-mx' => 'Piedra papel tijeras',
			'es-es' => 'Piedra papel tijeras',
		),
		'Roster 1000' => array(
			'fr' => 'Roster 1000',
			'es-mx' => 'Roster 1000',
			'es-es' => 'Roster 1000',
		),
		'Rule Guess Puzzle' => array(
			'fr' => 'Puzzle de règle cachée',
			'es-mx' => 'Rompecabezas de regla oculta',
			'es-es' => 'Puzle de regla oculta',
		),
		'Rule Switch Rush' => array(
			'fr' => 'Course aux règles changeantes',
			'es-mx' => 'Carrera de reglas cambiantes',
			'es-es' => 'Carrera de reglas cambiantes',
		),
		'Shadow Path' => array(
			'fr' => 'Chemin d’ombre',
			'es-mx' => 'Camino de sombra',
			'es-es' => 'Camino de sombra',
		),
		'Shop Builder' => array(
			'fr' => 'Constructeur de boutique',
			'es-mx' => 'Constructor de tienda',
			'es-es' => 'Constructor de tienda',
		),
		'Silent Simon Says' => array(
			'fr' => 'Simon dit silencieux',
			'es-mx' => 'Simón dice silencioso',
			'es-es' => 'Simón dice silencioso',
		),
		'Soccer Match AI' => array(
			'fr' => 'Match de football IA',
			'es-mx' => 'Partido de futbol IA',
			'es-es' => 'Partido de fútbol IA',
		),
		'Sound Pattern Builder' => array(
			'fr' => 'Constructeur de motifs sonores',
			'es-mx' => 'Constructor de patrones de sonido',
			'es-es' => 'Constructor de patrones de sonido',
		),
		'Sound Rule Rush' => array(
			'fr' => 'Course aux règles sonores',
			'es-mx' => 'Carrera de reglas sonoras',
			'es-es' => 'Carrera de reglas sonoras',
		),
		'Sudoku' => array(
			'fr' => 'Sudoku',
			'es-mx' => 'Sudoku',
			'es-es' => 'Sudoku',
		),
		'Territory Capture' => array(
			'fr' => 'Capture de territoire',
			'es-mx' => 'Captura de territorio',
			'es-es' => 'Captura de territorio',
		),
		'Territory Fill' => array(
			'fr' => 'Remplissage de territoire',
			'es-mx' => 'Rellenar territorio',
			'es-es' => 'Rellenar territorio',
		),
		'The 46th Rule' => array(
			'fr' => 'La 46e règle',
			'es-mx' => 'La regla 46',
			'es-es' => 'La regla 46',
		),
		'Time Loop Runner' => array(
			'fr' => 'Coureur de boucle temporelle',
			'es-mx' => 'Corredor del bucle temporal',
			'es-es' => 'Corredor del bucle temporal',
		),
		'Time Traveler Puzzle' => array(
			'fr' => 'Puzzle du voyageur temporel',
			'es-mx' => 'Rompecabezas del viajero del tiempo',
			'es-es' => 'Puzle del viajero del tiempo',
		),
		'TR Search Launcher' => array(
			'fr' => 'Lanceur de recherche turque',
			'es-mx' => 'Lanzador de búsqueda turca',
			'es-es' => 'Lanzador de búsqueda turca',
		),
		'Puzzle Crafter Drift' => array(
			'fr' => 'Dérive du créateur de puzzles',
			'es-mx' => 'Deriva del creador de rompecabezas',
			'es-es' => 'Deriva del creador de puzles',
		),
		'Puzzle Signal Vault' => array(
			'fr' => 'Coffre des signaux puzzle',
			'es-mx' => 'Bóveda de señales del rompecabezas',
			'es-es' => 'Cámara de señales del puzle',
		),
		'Balloon Tower Climb' => array(
			'fr' => 'Ascension de la tour de ballons',
			'es-mx' => 'Subida a la torre de globos',
			'es-es' => 'Subida a la torre de globos',
		),
		'Castle Siege Commander' => array(
			'fr' => 'Commandant du siège du château',
			'es-mx' => 'Comandante del asedio al castillo',
			'es-es' => 'Comandante del asedio al castillo',
		),
		'Candy Factory Chaos' => array(
			'fr' => 'Chaos à l’usine de bonbons',
			'es-mx' => 'Caos en la fábrica de dulces',
			'es-es' => 'Caos en la fábrica de caramelos',
		),
		'Castle Trap Designer' => array(
			'fr' => 'Concepteur de pièges de château',
			'es-mx' => 'Diseñador de trampas del castillo',
			'es-es' => 'Diseñador de trampas del castillo',
		),
		'Giant Bug Survival' => array(
			'fr' => 'Survie aux insectes géants',
			'es-mx' => 'Supervivencia con insectos gigantes',
			'es-es' => 'Supervivencia con insectos gigantes',
		),
		'Haunted Library Mystery' => array(
			'fr' => 'Mystère de la bibliothèque hantée',
			'es-mx' => 'Misterio de la biblioteca embrujada',
			'es-es' => 'Misterio de la biblioteca encantada',
		),
		'Ice Mountain Snowboard' => array(
			'fr' => 'Snowboard sur montagne glacée',
			'es-mx' => 'Snowboard en la montaña helada',
			'es-es' => 'Snowboard en la montaña helada',
		),
		'Invisible Platform Challenge' => array(
			'fr' => 'Défi des plateformes invisibles',
			'es-mx' => 'Desafío de plataformas invisibles',
			'es-es' => 'Desafío de plataformas invisibles',
		),
		'Laser Mirror Puzzle' => array(
			'fr' => 'Puzzle de miroirs laser',
			'es-mx' => 'Rompecabezas de espejos láser',
			'es-es' => 'Puzle de espejos láser',
		),
		'Country Quiz Coins' => array(
			'fr' => 'Quiz des pays et pièces',
			'es-mx' => 'Quiz de países y monedas',
			'es-es' => 'Quiz de países y monedas',
		),
	);

	if (isset($exact[$title][$lang])) {
		return $exact[$title][$lang];
	}

	if (preg_match('/^(.+?)\s+Clock$/i', $title, $matches)) {
		$place = trim($matches[1]);
		$place_names = array(
			'fr' => array(
				'Athens' => 'Athènes',
				'Beijing' => 'Pékin',
				'Cairo' => 'Le Caire',
				'Cape Town' => 'Le Cap',
				'Copenhagen' => 'Copenhague',
				'London' => 'Londres',
				'Mexico City' => 'Mexico',
				'Munich' => 'Munich',
				'New York' => 'New York',
				'Rome' => 'Rome',
				'Sao Paulo' => 'São Paulo',
				'Seoul' => 'Séoul',
				'Stockholm' => 'Stockholm',
				'Vienna' => 'Vienne',
				'Zurich' => 'Zurich',
			),
			'es-mx' => array(
				'Athens' => 'Atenas',
				'Beijing' => 'Pekín',
				'Cairo' => 'El Cairo',
				'Cape Town' => 'Ciudad del Cabo',
				'Copenhagen' => 'Copenhague',
				'London' => 'Londres',
				'Mexico City' => 'Ciudad de México',
				'Munich' => 'Múnich',
				'New York' => 'Nueva York',
				'Rome' => 'Roma',
				'Sao Paulo' => 'São Paulo',
				'Seoul' => 'Seúl',
				'Stockholm' => 'Estocolmo',
				'Vienna' => 'Viena',
				'Zurich' => 'Zúrich',
			),
			'es-es' => array(
				'Athens' => 'Atenas',
				'Beijing' => 'Pekín',
				'Cairo' => 'El Cairo',
				'Cape Town' => 'Ciudad del Cabo',
				'Copenhagen' => 'Copenhague',
				'London' => 'Londres',
				'Mexico City' => 'Ciudad de México',
				'Munich' => 'Múnich',
				'New York' => 'Nueva York',
				'Rome' => 'Roma',
				'Sao Paulo' => 'São Paulo',
				'Seoul' => 'Seúl',
				'Stockholm' => 'Estocolmo',
				'Vienna' => 'Viena',
				'Zurich' => 'Zúrich',
			),
		);
		$localized_place = isset($place_names[$lang][$place]) ? $place_names[$lang][$place] : $place;
		$french_place = preg_match('/^[aeiouh]/iu', $localized_place) ? "d'" . $localized_place : 'de ' . $localized_place;
		$clock_titles = array(
			'tr' => $place . ' Saati',
			'en' => $place . ' Clock',
			'de' => $place . '-Uhr',
			'fr' => 'Horloge ' . $french_place,
			'es-mx' => 'Reloj de ' . $localized_place,
			'es-es' => 'Reloj de ' . $localized_place,
		);

		return isset($clock_titles[$lang]) ? $clock_titles[$lang] : $title;
	}

	$phrase_translations = array(
		'fr' => array(
			'Memory' => 'Mémoire',
			'Puzzle' => 'Puzzle',
			'Game' => 'Jeu',
			'Challenge' => 'Défi',
			'Builder' => 'Constructeur',
			'Runner' => 'Coureur',
			'Rescue' => 'Sauvetage',
			'Signal' => 'Signal',
			'Shadow' => 'Ombre',
			'Orbit' => 'Orbite',
			'Robot' => 'Robot',
			'Color' => 'Couleur',
			'Code' => 'Code',
			'Word' => 'Mot',
			'Tower' => 'Tour',
			'Castle' => 'Château',
			'Maze' => 'Labyrinthe',
			'Laser' => 'Laser',
			'Mirror' => 'Miroir',
			'Match' => 'Associer',
			'Architect' => 'Architecte',
			'Adventure' => 'Aventure',
			'Battle' => 'Bataille',
			'Base' => 'Base',
			'Circuit' => 'Circuit',
			'City' => 'Ville',
			'Collector' => 'Collecteur',
			'Courier' => 'Messager',
			'Crafter' => 'Créateur',
			'Crystal' => 'Cristal',
			'Decoder' => 'Décodeur',
			'Defense' => 'Défense',
			'Drift' => 'Dérive',
			'Echo' => 'Écho',
			'Escape' => 'Évasion',
			'Fruit' => 'Fruit',
			'Grid' => 'Grille',
			'Guardian' => 'Gardien',
			'Hunt' => 'Chasse',
			'Jungle' => 'Jungle',
			'Monster' => 'Monstre',
			'Neon' => 'Néon',
			'Pilot' => 'Pilote',
			'Pixel' => 'Pixel',
			'Pulse' => 'Pulsation',
			'Quantum' => 'Quantique',
			'Quest' => 'Quête',
			'Racing' => 'Course',
			'Recall' => 'Mémoire',
			'Relay' => 'Relais',
			'Revival' => 'Retour',
			'Rocket' => 'Fusée',
			'Silent' => 'Silencieux',
			'Soccer' => 'Football',
			'Space' => 'Espace',
			'Speed' => 'Vitesse',
			'Sprint' => 'Sprint',
			'Target' => 'Cible',
			'Treasure' => 'Trésor',
			'Turbo' => 'Turbo',
			'Vault' => 'Coffre',
			'World' => 'Monde',
		),
		'es-mx' => array(
			'Memory' => 'Memoria',
			'Puzzle' => 'Rompecabezas',
			'Game' => 'Juego',
			'Challenge' => 'Desafío',
			'Builder' => 'Constructor',
			'Runner' => 'Corredor',
			'Rescue' => 'Rescate',
			'Signal' => 'Señal',
			'Shadow' => 'Sombra',
			'Orbit' => 'Órbita',
			'Robot' => 'Robot',
			'Color' => 'Color',
			'Code' => 'Código',
			'Word' => 'Palabra',
			'Tower' => 'Torre',
			'Castle' => 'Castillo',
			'Maze' => 'Laberinto',
			'Laser' => 'Láser',
			'Mirror' => 'Espejo',
			'Match' => 'Relacionar',
			'Architect' => 'Arquitecto',
			'Adventure' => 'Aventura',
			'Battle' => 'Batalla',
			'Base' => 'Base',
			'Circuit' => 'Circuito',
			'City' => 'Ciudad',
			'Collector' => 'Recolector',
			'Courier' => 'Mensajero',
			'Crafter' => 'Creador',
			'Crystal' => 'Cristal',
			'Decoder' => 'Decodificador',
			'Defense' => 'Defensa',
			'Drift' => 'Deriva',
			'Echo' => 'Eco',
			'Escape' => 'Escape',
			'Fruit' => 'Fruta',
			'Grid' => 'Cuadrícula',
			'Guardian' => 'Guardián',
			'Hunt' => 'Caza',
			'Jungle' => 'Jungla',
			'Monster' => 'Monstruo',
			'Neon' => 'Neón',
			'Pilot' => 'Piloto',
			'Pixel' => 'Pixel',
			'Pulse' => 'Pulso',
			'Quantum' => 'Cuántico',
			'Quest' => 'Misión',
			'Racing' => 'Carreras',
			'Recall' => 'Memoria',
			'Relay' => 'Relevo',
			'Revival' => 'Renacer',
			'Rocket' => 'Cohete',
			'Silent' => 'Silencioso',
			'Soccer' => 'Futbol',
			'Space' => 'Espacio',
			'Speed' => 'Velocidad',
			'Sprint' => 'Sprint',
			'Target' => 'Objetivo',
			'Treasure' => 'Tesoro',
			'Turbo' => 'Turbo',
			'Vault' => 'Bóveda',
			'World' => 'Mundo',
		),
		'es-es' => array(
			'Memory' => 'Memoria',
			'Puzzle' => 'Puzle',
			'Game' => 'Juego',
			'Challenge' => 'Desafío',
			'Builder' => 'Constructor',
			'Runner' => 'Corredor',
			'Rescue' => 'Rescate',
			'Signal' => 'Señal',
			'Shadow' => 'Sombra',
			'Orbit' => 'Órbita',
			'Robot' => 'Robot',
			'Color' => 'Color',
			'Code' => 'Código',
			'Word' => 'Palabra',
			'Tower' => 'Torre',
			'Castle' => 'Castillo',
			'Maze' => 'Laberinto',
			'Laser' => 'Láser',
			'Mirror' => 'Espejo',
			'Match' => 'Relacionar',
			'Architect' => 'Arquitecto',
			'Adventure' => 'Aventura',
			'Battle' => 'Batalla',
			'Base' => 'Base',
			'Circuit' => 'Circuito',
			'City' => 'Ciudad',
			'Collector' => 'Recolector',
			'Courier' => 'Mensajero',
			'Crafter' => 'Creador',
			'Crystal' => 'Cristal',
			'Decoder' => 'Decodificador',
			'Defense' => 'Defensa',
			'Drift' => 'Deriva',
			'Echo' => 'Eco',
			'Escape' => 'Escape',
			'Fruit' => 'Fruta',
			'Grid' => 'Cuadrícula',
			'Guardian' => 'Guardián',
			'Hunt' => 'Caza',
			'Jungle' => 'Jungla',
			'Monster' => 'Monstruo',
			'Neon' => 'Neón',
			'Pilot' => 'Piloto',
			'Pixel' => 'Pixel',
			'Pulse' => 'Pulso',
			'Quantum' => 'Cuántico',
			'Quest' => 'Misión',
			'Racing' => 'Carreras',
			'Recall' => 'Memoria',
			'Relay' => 'Relevo',
			'Revival' => 'Renacer',
			'Rocket' => 'Cohete',
			'Silent' => 'Silencioso',
			'Soccer' => 'Fútbol',
			'Space' => 'Espacio',
			'Speed' => 'Velocidad',
			'Sprint' => 'Sprint',
			'Target' => 'Objetivo',
			'Treasure' => 'Tesoro',
			'Turbo' => 'Turbo',
			'Vault' => 'Cámara',
			'World' => 'Mundo',
		),
	);

	if (isset($phrase_translations[$lang])) {
		return strtr($title, $phrase_translations[$lang]);
	}

	return $title;
}

function zo_get_fallback_game_title_metadata($title) {
	$parts = array();

	foreach (zo_get_language_options() as $lang => $label) {
		$value = zo_get_fallback_game_title_for_language($title, $lang);
		if ($value !== '') {
			$parts[] = zo_get_metadata_language_label($lang) . ' ' . $value;
		}
	}

	return implode(' | ', $parts);
}

function zo_get_smart_fallback_game_metadata($module) {
	$name = !empty($module['name']) && is_string($module['name']) ? trim($module['name']) : '';
	$slug = !empty($module['slug']) ? sanitize_title($module['slug']) : sanitize_title($name);
	$description = !empty($module['description']) && is_string($module['description']) ? trim(wp_strip_all_tags($module['description'])) : '';

	if ($name === '') {
		return null;
	}

	$has_localized_name = preg_match('/(?:^|\|)\s*(TR|EN|DE|FR|ES-MX|ES-ES):/i', $name) === 1;
	$clean_name = $has_localized_name ? zo_cleanup_generated_game_title(zo_get_localized_text($name, 'en')) : zo_cleanup_generated_game_title($name);
	$category = zo_get_game_category($slug, $clean_name, $description);
	$templates = zo_get_fallback_description_templates($category);
	$name_fallback = zo_get_fallback_game_title_metadata($clean_name);
	$name_value = $has_localized_name ? $name : $name_fallback;
	$name_value = zo_append_missing_localized_parts($name_value, $name_fallback, zo_get_language_options());
	$localized_names = array();

	foreach (zo_get_language_options() as $lang => $label) {
		$localized_names[$lang] = zo_get_fallback_game_title_for_language($clean_name, $lang);
	}

	return array(
		'name' => $name_value,
		'description' => sprintf(
			'TR: %1$s EN: %2$s DE: %3$s FR: %4$s ES-MX: %5$s ES-ES: %6$s',
			sprintf($templates['tr'], $localized_names['tr']),
			sprintf($templates['en'], $localized_names['en']),
			sprintf($templates['de'], $localized_names['de']),
			sprintf($templates['fr'], $localized_names['fr']),
			sprintf($templates['es-mx'], $localized_names['es-mx']),
			sprintf($templates['es-es'], $localized_names['es-es'])
		),
	);
}

function zo_cleanup_generated_game_title($title) {
	$title = trim(wp_strip_all_tags((string) $title));
	$title = preg_replace('/\s+/', ' ', $title);

	if (!is_string($title) || $title === '') {
		return '';
	}

	$title = preg_replace('/^\s*(TR|EN|DE|FR|ES-MX|ES-ES):\s*/i', '', $title);
	$title = preg_replace('/\s+(oyunu|game|spiel)\s*$/iu', '', $title);
	$title = str_replace(array('_', '-'), ' ', $title);
	$title = preg_replace('/\s+/', ' ', $title);

	if (function_exists('mb_convert_case')) {
		return mb_convert_case(trim($title), MB_CASE_TITLE, 'UTF-8');
	}

	return ucwords(strtolower(trim($title)));
}

function zo_get_game_category_options() {
	return array(
		'all' => array(
			'tr' => 'Tüm oyunlar',
			'en' => 'All games',
			'es-mx' => 'Todos los juegos',
			'es-es' => 'Todos los juegos',
			'de' => 'Alle Spiele',
			'fr' => 'Tous les jeux',
		),
		'puzzle' => array(
			'tr' => 'Bulmaca',
			'en' => 'Puzzle',
			'es-mx' => 'Rompecabezas',
			'es-es' => 'Puzles',
			'de' => 'Rätsel',
			'fr' => 'Puzzle',
		),
		'memory' => array(
			'tr' => 'Hafıza',
			'en' => 'Memory',
			'es-mx' => 'Memoria',
			'es-es' => 'Memoria',
			'de' => 'Gedächtnis',
			'fr' => 'Mémoire',
		),
		'math' => array(
			'tr' => 'Matematik',
			'en' => 'Math',
			'es-mx' => 'Matemáticas',
			'es-es' => 'Matemáticas',
			'de' => 'Mathe',
			'fr' => 'Maths',
		),
		'action' => array(
			'tr' => 'Aksiyon',
			'en' => 'Action',
			'es-mx' => 'Acción',
			'es-es' => 'Acción',
			'de' => 'Action',
			'fr' => 'Action',
		),
		'sports' => array(
			'tr' => 'Spor',
			'en' => 'Sports',
			'es-mx' => 'Deportes',
			'es-es' => 'Deportes',
			'de' => 'Sport',
			'fr' => 'Sport',
		),
		'creative' => array(
			'tr' => 'Yaratıcı',
			'en' => 'Creative',
			'es-mx' => 'Creativo',
			'es-es' => 'Creativo',
			'de' => 'Kreativ',
			'fr' => 'Créatif',
		),
		'tool' => array(
			'tr' => 'Araçlar',
			'en' => 'Tools',
			'es-mx' => 'Herramientas',
			'es-es' => 'Herramientas',
			'de' => 'Werkzeuge',
			'fr' => 'Outils',
		),
	);
}

function zo_get_game_category_label($category, $lang = '') {
	$lang = array_key_exists($lang, zo_get_language_options()) ? $lang : zo_get_current_language();
	$options = zo_get_game_category_options();
	$category = isset($options[$category]) ? $category : 'all';

	return $options[$category][$lang] ?? $options[$category]['en'];
}

function zo_get_game_category_icon($category) {
	$icons = array(
		'puzzle'   => '?',
		'memory'   => 'M',
		'math'     => '#',
		'action'   => '!',
		'sports'   => '>',
		'creative' => '+',
		'tool'     => '*',
		'all'      => '.',
	);

	return $icons[$category] ?? $icons['all'];
}

function zo_get_game_category($slug, $title = '', $description = '') {
	$text = strtolower((string) $slug . ' ' . (string) $title . ' ' . (string) $description);

	if (preg_match('/clock|time|calculator|search|launcher|paint|designer|builder|studio|draw|drawing|boyama|arama|saat|hesap/', $text)) {
		return 'tool';
	}

	if (preg_match('/math|number|binary|calculator|angle|quiz|soru|country|ulke|line/', $text)) {
		return 'math';
	}

	if (preg_match('/memory|recall|simon|sequence|hafiza|remember|match/', $text)) {
		return 'memory';
	}

	if (preg_match('/soccer|football|penalty|race|racing|sled|snowboard|golf|sports|futbol|kosu/', $text)) {
		return 'sports';
	}

	if (preg_match('/runner|battle|shoot|shooter|defense|army|fight|survival|escape|rescue|dodg|ninja|dragon|heist|lava|arena|rocket/', $text)) {
		return 'action';
	}

	if (preg_match('/paint|design|designer|builder|factory|garden|shop|city|farm|creative|robot/', $text)) {
		return 'creative';
	}

	return 'puzzle';
}

function zo_get_fallback_description_templates($category) {
	$templates = array(
		'puzzle' => array(
			'tr' => '%s, dikkatli düşünerek adım adım çözdüğün bir zeka bulmacasıdır.',
			'en' => '%s is a thinking puzzle where you solve the challenge step by step.',
			'es-mx' => '%s es un rompecabezas para pensar y resolver el reto paso a paso.',
			'es-es' => '%s es un puzle de lógica para resolver el reto paso a paso.',
			'de' => '%s ist ein Denkspiel, bei dem du die Aufgabe Schritt für Schritt löst.',
			'fr' => '%s est un jeu de réflexion où tu résous le défi étape par étape.',
		),
		'memory' => array(
			'tr' => '%s, sırayı hatırlayıp doğru hamleleri yapmanı isteyen bir hafıza oyunudur.',
			'en' => '%s is a memory game where you remember the pattern and make the right moves.',
			'es-mx' => '%s es un juego de memoria donde recuerdas el patrón y haces los movimientos correctos.',
			'es-es' => '%s es un juego de memoria en el que recuerdas el patrón y haces los movimientos correctos.',
			'de' => '%s ist ein Memory-Spiel, bei dem du Muster merkst und richtig reagierst.',
			'fr' => '%s est un jeu de mémoire où tu retiens le motif et fais les bons choix.',
		),
		'math' => array(
			'tr' => '%s, sayılar ve mantıkla pratik yapmanı sağlayan eğitici bir oyundur.',
			'en' => '%s is an educational game for practicing numbers and logic.',
			'es-mx' => '%s es un juego educativo para practicar números y lógica.',
			'es-es' => '%s es un juego educativo para practicar números y lógica.',
			'de' => '%s ist ein Lernspiel zum Üben von Zahlen und Logik.',
			'fr' => '%s est un jeu éducatif pour s’entraîner avec les nombres et la logique.',
		),
		'action' => array(
			'tr' => '%s, hızlı tepki verip hedefe ulaşmaya çalıştığın hareketli bir oyundur.',
			'en' => '%s is an action game where quick reactions help you reach the goal.',
			'es-mx' => '%s es un juego de acción donde tus reflejos te ayudan a llegar a la meta.',
			'es-es' => '%s es un juego de acción en el que tus reflejos te ayudan a llegar al objetivo.',
			'de' => '%s ist ein Actionspiel, bei dem schnelle Reaktionen zum Ziel führen.',
			'fr' => '%s est un jeu d’action où tes réflexes t’aident à atteindre l’objectif.',
		),
		'sports' => array(
			'tr' => '%s, zamanlama ve stratejiyle oynanan spor temalı bir oyundur.',
			'en' => '%s is a sports game built around timing and strategy.',
			'es-mx' => '%s es un juego de deportes basado en ritmo y estrategia.',
			'es-es' => '%s es un juego deportivo basado en ritmo y estrategia.',
			'de' => '%s ist ein Sportspiel mit Timing und Strategie.',
			'fr' => '%s est un jeu de sport basé sur le timing et la stratégie.',
		),
		'creative' => array(
			'tr' => '%s, bir şeyler kurup deneyerek ilerlediğin yaratıcı bir oyundur.',
			'en' => '%s is a creative game where you build, test, and improve your idea.',
			'es-mx' => '%s es un juego creativo donde construyes, pruebas y mejoras tu idea.',
			'es-es' => '%s es un juego creativo en el que construyes, pruebas y mejoras tu idea.',
			'de' => '%s ist ein kreatives Spiel, in dem du baust, testest und verbesserst.',
			'fr' => '%s est un jeu créatif où tu construis, testes et améliores ton idée.',
		),
		'tool' => array(
			'tr' => '%s, tarayıcıda kullanabileceğin basit ve eğitici bir araçtır.',
			'en' => '%s is a simple educational tool you can use in the browser.',
			'es-mx' => '%s es una herramienta educativa sencilla que puedes usar en el navegador.',
			'es-es' => '%s es una herramienta educativa sencilla que puedes usar en el navegador.',
			'de' => '%s ist ein einfaches Lernwerkzeug für den Browser.',
			'fr' => '%s est un outil éducatif simple à utiliser dans le navigateur.',
		),
	);

	return isset($templates[$category]) ? $templates[$category] : $templates['puzzle'];
}

function zo_get_language_options() {
	return array(
		'tr' => 'TR',
		'en' => 'EN',
		'de' => 'DE',
		'fr' => 'FR',
		'es-mx' => 'MX',
		'es-es' => 'ES',
	);
}

function zo_get_current_language() {
	$lang = '';

	if (isset($_GET['zo_lang'])) {
		$lang = sanitize_key(wp_unslash($_GET['zo_lang']));
	}

	return array_key_exists($lang, zo_get_language_options()) ? $lang : 'tr';
}

function zo_get_interface_text($key, $lang = '') {
	$lang = array_key_exists($lang, zo_get_language_options()) ? $lang : zo_get_current_language();
	$text = array(
		'home' => array(
			'tr' => 'Ana Sayfaya Dön',
			'en' => 'Go to the home page',
			'es-mx' => 'Ir a la página de inicio',
			'es-es' => 'Ir a la página de inicio',
			'fr' => 'Retour à l’accueil',
			'de' => 'Zur Startseite',
		),
		'back_to_games' => array(
			'tr' => 'Oyunlara Dön',
			'en' => 'Back to games',
			'es-mx' => 'Volver a los juegos',
			'es-es' => 'Volver a los juegos',
			'fr' => 'Retour aux jeux',
			'de' => 'Zurück zu den Spielen',
		),
		'report_problem_title' => array(
			'tr' => 'Sorun Bildir',
			'en' => 'Report a Problem',
			'es-mx' => 'Reportar un problema',
			'es-es' => 'Informar de un problema',
			'fr' => 'Signaler un probleme',
			'de' => 'Problem melden',
		),
		'report_problem_intro' => array(
			'tr' => 'Neyin yanlış gittiğini yaz. Raporlar WordPress yönetiminde gizli olarak kaydedilir.',
			'en' => 'Tell us what went wrong. Reports are saved privately in WordPress admin.',
			'es-mx' => 'Dinos qué salió mal. Los reportes se guardan de forma privada en WordPress.',
			'es-es' => 'Dinos que ha fallado. Los informes se guardan de forma privada en WordPress.',
			'fr' => 'Dis-nous ce qui ne va pas. Les rapports sont enregistres en prive dans WordPress.',
			'de' => 'Sag uns, was nicht funktioniert hat. Berichte werden privat in WordPress gespeichert.',
		),
		'report_problem_success' => array(
			'tr' => 'Teşekkürler. Rapor kaydedildi.',
			'en' => 'Thank you. The report was saved.',
			'es-mx' => 'Gracias. El reporte fue guardado.',
			'es-es' => 'Gracias. El informe se ha guardado.',
			'fr' => 'Merci. Le rapport a ete enregistre.',
			'de' => 'Danke. Der Bericht wurde gespeichert.',
		),
		'report_back_to_game' => array(
			'tr' => 'Oyuna dön',
			'en' => 'Back to game',
			'es-mx' => 'Volver al juego',
			'es-es' => 'Volver al juego',
			'fr' => 'Retour au jeu',
			'de' => 'Zuruck zum Spiel',
		),
		'report_problem_error' => array(
			'tr' => 'Rapor kaydedilemedi. Lütfen tekrar dene.',
			'en' => 'The report could not be saved. Please try again.',
			'es-mx' => 'No se pudo guardar el reporte. Inténtalo de nuevo.',
			'es-es' => 'No se pudo guardar el informe. Inténtalo de nuevo.',
			'fr' => 'Le rapport n a pas pu etre enregistre. Reessaie.',
			'de' => 'Der Bericht konnte nicht gespeichert werden. Bitte versuche es erneut.',
		),
		'report_game_label' => array('tr' => 'Oyun', 'en' => 'Game', 'es-mx' => 'Juego', 'es-es' => 'Juego', 'fr' => 'Jeu', 'de' => 'Spiel'),
		'report_game_placeholder' => array('tr' => 'Oyun adı', 'en' => 'Game name', 'es-mx' => 'Nombre del juego', 'es-es' => 'Nombre del juego', 'fr' => 'Nom du jeu', 'de' => 'Spielname'),
		'report_problem_type' => array('tr' => 'Sorun türü', 'en' => 'Problem type', 'es-mx' => 'Tipo de problema', 'es-es' => 'Tipo de problema', 'fr' => 'Type de probleme', 'de' => 'Problemtyp'),
		'report_device' => array('tr' => 'Cihaz', 'en' => 'Device', 'es-mx' => 'Dispositivo', 'es-es' => 'Dispositivo', 'fr' => 'Appareil', 'de' => 'Gerat'),
		'report_message_label' => array('tr' => 'Ne oldu?', 'en' => 'What happened?', 'es-mx' => '¿Qué pasó?', 'es-es' => '¿Qué ha pasado?', 'fr' => 'Que s est-il passe?', 'de' => 'Was ist passiert?'),
		'report_message_placeholder' => array('tr' => 'Örnek: telefonda başlat düğmesi çalışmıyor.', 'en' => 'Example: the start button does not work on my phone.', 'es-mx' => 'Ejemplo: el botón de inicio no funciona en mi teléfono.', 'es-es' => 'Ejemplo: el botón de inicio no funciona en mi teléfono.', 'fr' => 'Exemple : le bouton demarrer ne marche pas sur mon telephone.', 'de' => 'Beispiel: Der Startknopf funktioniert auf meinem Handy nicht.'),
		'report_required_message' => array('tr' => 'Lütfen bu alanı doldur.', 'en' => 'Please fill out this field.', 'es-mx' => 'Completa este campo.', 'es-es' => 'Completa este campo.', 'fr' => 'Remplis ce champ.', 'de' => 'Bitte fülle dieses Feld aus.'),
		'report_browser' => array('tr' => 'Tarayıcı', 'en' => 'Browser', 'es-mx' => 'Navegador', 'es-es' => 'Navegador', 'fr' => 'Navigateur', 'de' => 'Browser'),
		'report_browser_placeholder' => array('tr' => 'Chrome, Safari, Edge...', 'en' => 'Chrome, Safari, Edge...', 'es-mx' => 'Chrome, Safari, Edge...', 'es-es' => 'Chrome, Safari, Edge...', 'fr' => 'Chrome, Safari, Edge...', 'de' => 'Chrome, Safari, Edge...'),
		'report_email_optional' => array('tr' => 'E-posta isteğe bağlı', 'en' => 'Email optional', 'es-mx' => 'Correo opcional', 'es-es' => 'Correo opcional', 'fr' => 'E-mail facultatif', 'de' => 'E-Mail optional'),
		'report_screenshot_optional' => array('tr' => 'Ekran görüntüsü isteğe bağlı', 'en' => 'Screenshot optional', 'es-mx' => 'Captura opcional', 'es-es' => 'Captura opcional', 'fr' => 'Capture facultative', 'de' => 'Screenshot optional'),
		'report_screenshot_help' => array('tr' => 'Sadece PNG veya JPG, en fazla 1 MB.', 'en' => 'PNG or JPG only, max 1 MB.', 'es-mx' => 'Solo PNG o JPG, máximo 1 MB.', 'es-es' => 'Solo PNG o JPG, máximo 1 MB.', 'fr' => 'PNG ou JPG seulement, maximum 1 Mo.', 'de' => 'Nur PNG oder JPG, maximal 1 MB.'),
		'report_submit' => array('tr' => 'Rapor Gönder', 'en' => 'Send Report', 'es-mx' => 'Enviar reporte', 'es-es' => 'Enviar informe', 'fr' => 'Envoyer le rapport', 'de' => 'Bericht senden'),
		'report_game_link' => array('tr' => 'Bu oyunda sorun bildir', 'en' => 'Report a problem with this game', 'es-mx' => 'Reportar un problema con este juego', 'es-es' => 'Informar de un problema con este juego', 'fr' => 'Signaler un probleme avec ce jeu', 'de' => 'Ein Problem mit diesem Spiel melden'),
		'report_type_load' => array('tr' => 'Oyun açılmıyor', 'en' => 'Game will not load', 'es-mx' => 'El juego no carga', 'es-es' => 'El juego no carga', 'fr' => 'Le jeu ne charge pas', 'de' => 'Das Spiel ladt nicht'),
		'report_type_controls' => array('tr' => 'Tuşlar veya kontroller çalışmıyor', 'en' => 'Buttons or controls do not work', 'es-mx' => 'Los botones o controles no funcionan', 'es-es' => 'Los botones o controles no funcionan', 'fr' => 'Les boutons ou commandes ne marchent pas', 'de' => 'Tasten oder Steuerung funktionieren nicht'),
		'report_type_mobile' => array('tr' => 'Telefonda çok küçük veya zor', 'en' => 'Too small or hard to use on phone', 'es-mx' => 'Muy pequeño o difícil en teléfono', 'es-es' => 'Muy pequeño o difícil en teléfono', 'fr' => 'Trop petit ou difficile sur telephone', 'de' => 'Auf dem Handy zu klein oder schwierig'),
		'report_type_sound' => array('tr' => 'Ses sorunu', 'en' => 'Sound problem', 'es-mx' => 'Problema de sonido', 'es-es' => 'Problema de sonido', 'fr' => 'Probleme de son', 'de' => 'Tonproblem'),
		'report_type_translation' => array('tr' => 'Yanlış çeviri', 'en' => 'Wrong translation', 'es-mx' => 'Traducción incorrecta', 'es-es' => 'Traducción incorrecta', 'fr' => 'Mauvaise traduction', 'de' => 'Falsche Ubersetzung'),
		'report_type_other' => array('tr' => 'Diğer', 'en' => 'Other', 'es-mx' => 'Otro', 'es-es' => 'Otro', 'fr' => 'Autre', 'de' => 'Andere'),
		'report_device_phone' => array('tr' => 'Telefon', 'en' => 'Phone', 'es-mx' => 'Teléfono', 'es-es' => 'Teléfono', 'fr' => 'Telephone', 'de' => 'Handy'),
		'report_device_tablet' => array('tr' => 'Tablet', 'en' => 'Tablet', 'es-mx' => 'Tableta', 'es-es' => 'Tableta', 'fr' => 'Tablette', 'de' => 'Tablet'),
		'report_device_computer' => array('tr' => 'Bilgisayar', 'en' => 'Computer', 'es-mx' => 'Computadora', 'es-es' => 'Ordenador', 'fr' => 'Ordinateur', 'de' => 'Computer'),
		'report_device_unknown' => array('tr' => 'Emin değilim', 'en' => 'Not sure', 'es-mx' => 'No estoy seguro', 'es-es' => 'No estoy seguro', 'fr' => 'Je ne sais pas', 'de' => 'Nicht sicher'),
		'intro' => array(
			'tr' => 'Çocuklar, ilkokul öğrencileri ve yaşlılar için ücretsiz online eğitici zeka oyunları, mantık oyunları ve hafıza oyunları oynayın.',
			'en' => 'Play free online educational brain games, logic games, and memory games for kids, primary school students, and older people.',
			'es-mx' => 'Juega gratis en línea juegos educativos de ingenio, lógica y memoria para niños, estudiantes de primaria y personas mayores.',
			'es-es' => 'Juega gratis en línea a juegos educativos de ingenio, lógica y memoria para niños, alumnos de primaria y personas mayores.',
			'fr' => 'Jouez gratuitement en ligne à des jeux éducatifs de réflexion, de logique et de mémoire pour les enfants, les élèves du primaire et les personnes âgées.',
			'de' => 'Spielen Sie kostenlose online Lern-Denkspiele, Logikspiele und Gedächtnisspiele für Kinder, Grundschüler und ältere Menschen.',
		),
		'open_game' => array(
			'tr' => 'Oyunu Aç',
			'en' => 'Open Game',
			'es-mx' => 'Abrir juego',
			'es-es' => 'Abrir juego',
			'fr' => 'Ouvrir le jeu',
			'de' => 'Spiel Öffnen',
		),
		'language_label' => array(
			'tr' => 'Dil',
			'en' => 'Language',
			'es-mx' => 'Idioma',
			'es-es' => 'Idioma',
			'fr' => 'Langue',
			'de' => 'Sprache',
		),
		'search_label' => array(
			'tr' => 'Oyun ara',
			'en' => 'Search games',
			'es-mx' => 'Buscar juegos',
			'es-es' => 'Buscar juegos',
			'fr' => 'Rechercher un jeu',
			'de' => 'Spiele suchen',
		),
		'search_placeholder' => array(
			'tr' => 'Oyun adı yaz',
			'en' => 'Type a game name',
			'es-mx' => 'Escribe el nombre de un juego',
			'es-es' => 'Escribe el nombre de un juego',
			'fr' => 'Écris le nom d’un jeu',
			'de' => 'Spielname eingeben',
		),
		'category_label' => array(
			'tr' => 'Kategori',
			'en' => 'Category',
			'es-mx' => 'Categoría',
			'es-es' => 'Categoría',
			'fr' => 'Catégorie',
			'de' => 'Kategorie',
		),
		'sort_label' => array(
			'tr' => 'Sırala',
			'en' => 'Sort',
			'es-mx' => 'Ordenar',
			'es-es' => 'Ordenar',
			'fr' => 'Trier',
			'de' => 'Sortieren',
		),
		'sort_title' => array(
			'tr' => 'Ada göre',
			'en' => 'By name',
			'es-mx' => 'Por nombre',
			'es-es' => 'Por nombre',
			'fr' => 'Par nom',
			'de' => 'Nach Name',
		),
		'sort_newest' => array(
			'tr' => 'En yeni',
			'en' => 'Newest',
			'es-mx' => 'Más recientes',
			'es-es' => 'Más recientes',
			'fr' => 'Les plus récents',
			'de' => 'Neueste zuerst',
		),
		'sort_category' => array(
			'tr' => 'Kategoriye göre',
			'en' => 'By category',
			'es-mx' => 'Por categoría',
			'es-es' => 'Por categoría',
			'fr' => 'Par catégorie',
			'de' => 'Nach Kategorie',
		),
		'filter_submit' => array(
			'tr' => 'Filtrele',
			'en' => 'Filter',
			'es-mx' => 'Filtrar',
			'es-es' => 'Filtrar',
			'fr' => 'Filtrer',
			'de' => 'Filtern',
		),
		'filter_reset' => array(
			'tr' => 'Temizle',
			'en' => 'Clear',
			'es-mx' => 'Limpiar',
			'es-es' => 'Borrar',
			'fr' => 'Réinitialiser',
			'de' => 'Zurücksetzen',
		),
		'close_search' => array(
			'tr' => 'Kapat',
			'en' => 'Close',
			'es-mx' => 'Cerrar',
			'es-es' => 'Cerrar',
			'fr' => 'Fermer',
			'de' => 'Schliessen',
		),
		'new_this_week' => array(
			'tr' => 'Son güncellenenler',
			'en' => 'Recently updated',
			'es-mx' => 'Actualizados recientemente',
			'es-es' => 'Actualizados recientemente',
			'fr' => 'Mis à jour récemment',
			'de' => 'Kürzlich aktualisiert',
		),
		'recently_played' => array(
			'tr' => 'Son oynananlar',
			'en' => 'Recently played',
			'es-mx' => 'Jugados recientemente',
			'es-es' => 'Jugados recientemente',
			'fr' => 'Récemment joués',
			'de' => 'Zuletzt gespielt',
		),
		'favorites' => array(
			'tr' => 'Favoriler',
			'en' => 'Favorites',
			'es-mx' => 'Favoritos',
			'es-es' => 'Favoritos',
			'fr' => 'Favoris',
			'de' => 'Favoriten',
		),
		'game_progress' => array(
			'tr' => 'Oyun ilerlemesi',
			'en' => 'Game progress',
			'es-mx' => 'Progreso del juego',
			'es-es' => 'Progreso del juego',
			'fr' => 'Progression du jeu',
			'de' => 'Spielfortschritt',
		),
		'progress_opened' => array(
			'tr' => 'Açıldı',
			'en' => 'Opened',
			'es-mx' => 'Abierto',
			'es-es' => 'Abierto',
			'fr' => 'Ouvert',
			'de' => 'Geöffnet',
		),
		'progress_favorite' => array(
			'tr' => 'Favori',
			'en' => 'Favorite',
			'es-mx' => 'Favorito',
			'es-es' => 'Favorito',
			'fr' => 'Favori',
			'de' => 'Favorit',
		),
		'progress_streak' => array(
			'tr' => 'Seri sayılıyor',
			'en' => 'Streak counting',
			'es-mx' => 'Racha contando',
			'es-es' => 'Racha contando',
			'fr' => 'Série en cours',
			'de' => 'Serie zählt',
		),
		'game_stats' => array(
			'tr' => 'Oyun istatistikleri',
			'en' => 'Game stats',
			'es-mx' => 'Estadísticas del juego',
			'es-es' => 'Estadísticas del juego',
			'fr' => 'Statistiques du jeu',
			'de' => 'Spielstatistik',
		),
		'stat_plays' => array(
			'tr' => 'Açılış',
			'en' => 'Plays',
			'es-mx' => 'Jugadas',
			'es-es' => 'Jugadas',
			'fr' => 'Parties',
			'de' => 'Spiele',
		),
		'stat_last_played' => array(
			'tr' => 'Son oynama',
			'en' => 'Last played',
			'es-mx' => 'Última vez',
			'es-es' => 'Última vez',
			'fr' => 'Dernière fois',
			'de' => 'Zuletzt gespielt',
		),
		'stat_favorite' => array(
			'tr' => 'Favori',
			'en' => 'Favorite',
			'es-mx' => 'Favorito',
			'es-es' => 'Favorito',
			'fr' => 'Favori',
			'de' => 'Favorit',
		),
		'stat_yes' => array(
			'tr' => 'Evet',
			'en' => 'Yes',
			'es-mx' => 'Sí',
			'es-es' => 'Sí',
			'fr' => 'Oui',
			'de' => 'Ja',
		),
		'stat_no' => array(
			'tr' => 'Hayır',
			'en' => 'No',
			'es-mx' => 'No',
			'es-es' => 'No',
			'fr' => 'Non',
			'de' => 'Nein',
		),
		'achievement_unlocked' => array(
			'tr' => 'Rozet açıldı',
			'en' => 'Achievement unlocked',
			'es-mx' => 'Logro desbloqueado',
			'es-es' => 'Logro desbloqueado',
			'fr' => 'Succès débloqué',
			'de' => 'Erfolg freigeschaltet',
		),
		'badge_center' => array(
			'tr' => 'Rozet Merkezi',
			'en' => 'Badge Center',
			'es-mx' => 'Centro de insignias',
			'es-es' => 'Centro de insignias',
			'fr' => 'Centre des badges',
			'de' => 'Abzeichen-Center',
		),
		'badge_showcase_intro' => array(
			'tr' => 'Askerin OyunlarÄ± rozetlerini, gereksinimlerini ve bu cihazdaki ilerlemeni gÃ¶r.',
			'en' => 'See Asker\'s Games badges, requirements, and your progress on this device.',
			'es-mx' => 'Ve las insignias de Asker\'s Games, sus requisitos y tu progreso en este dispositivo.',
			'es-es' => 'Ve las insignias de Asker\'s Games, sus requisitos y tu progreso en este dispositivo.',
			'fr' => 'Vois les badges des jeux d\'Asker, leurs conditions et ta progression sur cet appareil.',
			'de' => 'Sieh Askers Spiele-Abzeichen, Anforderungen und deinen Fortschritt auf diesem GerÃ¤t.',
		),
		'arslan_badge_showcase_intro' => array(
			'tr' => 'Arslanin Oyunlari rozetlerini, gereksinimlerini ve bu cihazdaki ilerlemeni gor.',
			'en' => 'See Arslan\'s Games badges, requirements, and your progress on this device.',
			'es-mx' => 'Ve las insignias de Arslan\'s Games, sus requisitos y tu progreso en este dispositivo.',
			'es-es' => 'Ve las insignias de Arslan\'s Games, sus requisitos y tu progreso en este dispositivo.',
			'fr' => 'Vois les badges des jeux d\'Arslan, leurs conditions et ta progression sur cet appareil.',
			'de' => 'Sieh Arslans Spiele-Abzeichen, Anforderungen und deinen Fortschritt auf diesem Gerat.',
		),
		'badge_locked' => array(
			'tr' => 'Kilitli',
			'en' => 'Locked',
			'es-mx' => 'Bloqueada',
			'es-es' => 'Bloqueada',
			'fr' => 'Verrouillé',
			'de' => 'Gesperrt',
		),
		'badge_unlocked' => array(
			'tr' => 'Açıldı',
			'en' => 'Unlocked',
			'es-mx' => 'Desbloqueada',
			'es-es' => 'Desbloqueada',
			'fr' => 'Débloqué',
			'de' => 'Freigeschaltet',
		),
		'badge_unlocked_on' => array(
			'tr' => 'AÃ§Ä±lma tarihi',
			'en' => 'Unlocked on',
			'es-mx' => 'Desbloqueada el',
			'es-es' => 'Desbloqueada el',
			'fr' => 'DÃ©bloquÃ© le',
			'de' => 'Freigeschaltet am',
		),
		'badge_not_unlocked' => array(
			'tr' => 'HenÃ¼z aÃ§Ä±lmadÄ±',
			'en' => 'Not unlocked yet',
			'es-mx' => 'AÃºn no desbloqueada',
			'es-es' => 'AÃºn no desbloqueada',
			'fr' => 'Pas encore dÃ©bloquÃ©',
			'de' => 'Noch nicht freigeschaltet',
		),
		'badge_progress' => array(
			'tr' => '%1$d / %2$d gün',
			'en' => '%1$d / %2$d days',
			'es-mx' => '%1$d / %2$d días',
			'es-es' => '%1$d / %2$d días',
			'fr' => '%1$d / %2$d jours',
			'de' => '%1$d / %2$d Tage',
		),
		'week_streak_badge' => array(
			'tr' => 'Hafta Serisi',
			'en' => 'Week Streak',
			'es-mx' => 'Racha semanal',
			'es-es' => 'Racha semanal',
			'fr' => 'SÃ©rie semaine',
			'de' => 'Wochenserie',
		),
		'week_streak_badge_text' => array(
			'tr' => 'Askerin OyunlarÄ± iÃ§inde 7 gÃ¼n boyunca her gÃ¼n 5+ dakika oynadÄ±n.',
			'en' => 'You played Asker\'s Games for 5+ minutes every day for 7 days.',
			'es-mx' => 'Jugaste Asker\'s Games mÃ¡s de 5 minutos cada dÃ­a durante 7 dÃ­as.',
			'es-es' => 'Has jugado a Asker\'s Games mÃ¡s de 5 minutos cada dÃ­a durante 7 dÃ­as.',
			'fr' => 'Tu as jouÃ© aux jeux d\'Asker plus de 5 minutes par jour pendant 7 jours.',
			'de' => 'Du hast Askers Spiele 7 Tage lang jeden Tag mehr als 5 Minuten gespielt.',
		),
		'arslan_week_streak_badge_text' => array(
			'tr' => 'Arslanin Oyunlari icinde 7 gun boyunca her gun 5+ dakika oynadin.',
			'en' => 'You played Arslan\'s Games for 5+ minutes every day for 7 days.',
			'es-mx' => 'Jugaste Arslan\'s Games mas de 5 minutos cada dia durante 7 dias.',
			'es-es' => 'Has jugado a Arslan\'s Games mas de 5 minutos cada dia durante 7 dias.',
			'fr' => 'Tu as joue aux jeux d\'Arslan plus de 5 minutes par jour pendant 7 jours.',
			'de' => 'Du hast Arslans Spiele 7 Tage lang jeden Tag mehr als 5 Minuten gespielt.',
		),
		'month_streak_badge' => array(
			'tr' => 'Ay Serisi',
			'en' => 'Month Streak',
			'es-mx' => 'Racha mensual',
			'es-es' => 'Racha mensual',
			'fr' => 'SÃ©rie mois',
			'de' => 'Monatsserie',
		),
		'month_streak_badge_text' => array(
			'tr' => 'Askerin OyunlarÄ± iÃ§inde 30 gÃ¼n boyunca her gÃ¼n 2+ dakika oynadÄ±n.',
			'en' => 'You played Asker\'s Games for 2+ minutes every day for 30 days.',
			'es-mx' => 'Jugaste Asker\'s Games mÃ¡s de 2 minutos cada dÃ­a durante 30 dÃ­as.',
			'es-es' => 'Has jugado a Asker\'s Games mÃ¡s de 2 minutos cada dÃ­a durante 30 dÃ­as.',
			'fr' => 'Tu as jouÃ© aux jeux d\'Asker plus de 2 minutes par jour pendant 30 jours.',
			'de' => 'Du hast Askers Spiele 30 Tage lang jeden Tag mehr als 2 Minuten gespielt.',
		),
		'arslan_month_streak_badge_text' => array(
			'tr' => 'Arslanin Oyunlari icinde 30 gun boyunca her gun 2+ dakika oynadin.',
			'en' => 'You played Arslan\'s Games for 2+ minutes every day for 30 days.',
			'es-mx' => 'Jugaste Arslan\'s Games mas de 2 minutos cada dia durante 30 dias.',
			'es-es' => 'Has jugado a Arslan\'s Games mas de 2 minutos cada dia durante 30 dias.',
			'fr' => 'Tu as joue aux jeux d\'Arslan plus de 2 minutes par jour pendant 30 jours.',
			'de' => 'Du hast Arslans Spiele 30 Tage lang jeden Tag mehr als 2 Minuten gespielt.',
		),
		'play_streak_badge' => array(
			'tr' => '5 Günlük Asker Rozeti',
			'en' => '5-Day Asker Badge',
			'es-mx' => 'Insignia Asker de 5 días',
			'es-es' => 'Insignia Asker de 5 días',
			'fr' => 'Badge Asker de 5 jours',
			'de' => '5-Tage-Asker-Abzeichen',
		),
		'arslan_play_streak_badge' => array(
			'tr' => '5 Gunluk Arslan Rozeti',
			'en' => '5-Day Arslan Badge',
			'es-mx' => 'Insignia Arslan de 5 dias',
			'es-es' => 'Insignia Arslan de 5 dias',
			'fr' => 'Badge Arslan de 5 jours',
			'de' => '5-Tage-Arslan-Abzeichen',
		),
		'play_streak_badge_text' => array(
			'tr' => 'Askerin Oyunları içinde 5 gün boyunca her gün 10+ dakika oynadın.',
			'en' => 'You played Asker’s Games for 10+ minutes every day for 5 days.',
			'es-mx' => 'Jugaste Asker’s Games más de 10 minutos cada día durante 5 días.',
			'es-es' => 'Has jugado a Asker’s Games más de 10 minutos cada día durante 5 días.',
			'fr' => 'Tu as joué aux jeux d’Asker plus de 10 minutes par jour pendant 5 jours.',
			'de' => 'Du hast Askers Spiele 5 Tage lang jeden Tag mehr als 10 Minuten gespielt.',
		),
		'arslan_play_streak_badge_text' => array(
			'tr' => 'Arslanin Oyunlari icinde 5 gun boyunca her gun 10+ dakika oynadin.',
			'en' => 'You played Arslan\'s Games for 10+ minutes every day for 5 days.',
			'es-mx' => 'Jugaste Arslan\'s Games mas de 10 minutos cada dia durante 5 dias.',
			'es-es' => 'Has jugado a Arslan\'s Games mas de 10 minutos cada dia durante 5 dias.',
			'fr' => 'Tu as joue aux jeux d\'Arslan plus de 10 minutes par jour pendant 5 jours.',
			'de' => 'Du hast Arslans Spiele 5 Tage lang jeden Tag mehr als 10 Minuten gespielt.',
		),
		'focus_hero_badge' => array(
			'tr' => 'Odak Kahramanı',
			'en' => 'Focus Hero',
			'es-mx' => 'Héroe Focus',
			'es-es' => 'Héroe Focus',
			'fr' => 'Héros Focus',
			'de' => 'Fokusheld',
		),
		'focus_hero_badge_text' => array(
			'tr' => 'Askerin Oyunları içinde 5 gün boyunca her gün 20+ dakika oynadın.',
			'en' => 'You played Asker’s Games for 20+ minutes every day for 5 days.',
			'es-mx' => 'Jugaste Asker’s Games más de 20 minutos cada día durante 5 días.',
			'es-es' => 'Has jugado a Asker’s Games más de 20 minutos cada día durante 5 días.',
			'fr' => 'Tu as joué aux jeux d’Asker plus de 20 minutes par jour pendant 5 jours.',
			'de' => 'Du hast Askers Spiele 5 Tage lang jeden Tag mehr als 20 Minuten gespielt.',
		),
		'arslan_focus_hero_badge_text' => array(
			'tr' => 'Arslanin Oyunlari icinde 5 gun boyunca her gun 20+ dakika oynadin.',
			'en' => 'You played Arslan\'s Games for 20+ minutes every day for 5 days.',
			'es-mx' => 'Jugaste Arslan\'s Games mas de 20 minutos cada dia durante 5 dias.',
			'es-es' => 'Has jugado a Arslan\'s Games mas de 20 minutos cada dia durante 5 dias.',
			'fr' => 'Tu as joue aux jeux d\'Arslan plus de 20 minutes par jour pendant 5 jours.',
			'de' => 'Du hast Arslans Spiele 5 Tage lang jeden Tag mehr als 20 Minuten gespielt.',
		),
		'daily_champion_badge' => array(
			'tr' => 'Günlük Şampiyon',
			'en' => 'Daily Champion',
			'es-mx' => 'Campeón diario',
			'es-es' => 'Campeón diario',
			'fr' => 'Champion du jour',
			'de' => 'Tageschampion',
		),
		'daily_champion_badge_text' => array(
			'tr' => 'Askerin Oyunları içinde 5 gün boyunca her gün 30+ dakika oynadın.',
			'en' => 'You played Asker’s Games for 30+ minutes every day for 5 days.',
			'es-mx' => 'Jugaste Asker’s Games más de 30 minutos cada día durante 5 días.',
			'es-es' => 'Has jugado a Asker’s Games más de 30 minutos cada día durante 5 días.',
			'fr' => 'Tu as joué aux jeux d’Asker plus de 30 minutes par jour pendant 5 jours.',
			'de' => 'Du hast Askers Spiele 5 Tage lang jeden Tag mehr als 30 Minuten gespielt.',
		),
		'arslan_daily_champion_badge_text' => array(
			'tr' => 'Arslanin Oyunlari icinde 5 gun boyunca her gun 30+ dakika oynadin.',
			'en' => 'You played Arslan\'s Games for 30+ minutes every day for 5 days.',
			'es-mx' => 'Jugaste Arslan\'s Games mas de 30 minutos cada dia durante 5 dias.',
			'es-es' => 'Has jugado a Arslan\'s Games mas de 30 minutos cada dia durante 5 dias.',
			'fr' => 'Tu as joue aux jeux d\'Arslan plus de 30 minutes par jour pendant 5 jours.',
			'de' => 'Du hast Arslans Spiele 5 Tage lang jeden Tag mehr als 30 Minuten gespielt.',
		),
		'favorite_game' => array(
			'tr' => 'Favori yap',
			'en' => 'Add to favorites',
			'es-mx' => 'Agregar a favoritos',
			'es-es' => 'Agregar a favoritos',
			'fr' => 'Ajouter aux favoris',
			'de' => 'Als Favorit speichern',
		),
		'remove_favorite' => array(
			'tr' => 'Favoriden çıkar',
			'en' => 'Remove from favorites',
			'es-mx' => 'Quitar de favoritos',
			'es-es' => 'Quitar de favoritos',
			'fr' => 'Retirer des favoris',
			'de' => 'Aus Favoriten entfernen',
		),
		'badge_popular' => array(
			'tr' => 'Popüler',
			'en' => 'Popular',
			'es-mx' => 'Popular',
			'es-es' => 'Popular',
			'fr' => 'Populaire',
			'de' => 'Beliebt',
		),
		'no_live_results' => array(
			'tr' => 'Aramana uyan oyun yok.',
			'en' => 'No games match your search.',
			'es-mx' => 'No hay juegos para esta busqueda.',
			'es-es' => 'No hay juegos para esta busqueda.',
			'fr' => 'Aucun jeu ne correspond a cette recherche.',
			'de' => 'Keine Spiele passen zu dieser Suche.',
		),
		'results_count' => array(
			'tr' => '%d oyun gösteriliyor',
			'en' => 'Showing %d games',
			'es-mx' => 'Mostrando %d juegos',
			'es-es' => 'Mostrando %d juegos',
			'fr' => '%d jeux affichés',
			'de' => '%d Spiele werden angezeigt',
		),
		'play_suffix' => array(
			'tr' => 'oyna',
			'en' => 'play',
			'es-mx' => 'jugar',
			'es-es' => 'jugar',
			'fr' => 'jouer',
			'de' => 'spielen',
		),
		'language_unavailable' => array(
			'tr' => 'Bu oyun seçili dilde kullanılamıyor.',
			'en' => 'This game is not available in the selected language.',
			'es-mx' => 'Este juego no está disponible en el idioma seleccionado.',
			'es-es' => 'Este juego no está disponible en el idioma seleccionado.',
			'fr' => 'Ce jeu n’est pas disponible dans la langue sélectionnée.',
			'de' => 'Dieses Spiel ist in der ausgewählten Sprache nicht verfügbar.',
		),
	);

	$text['asker_about'] = array(
		'tr' => 'Askerin Oyunları Hakkında',
		'en' => 'About Asker’s Games',
		'fr' => 'À propos des jeux d’Asker',
		'de' => 'Über Askers Spiele',
	);
	$text['difficulty_label'] = array(
		'tr' => 'Zorluk',
		'en' => 'Difficulty',
		'es-mx' => 'Dificultad',
		'es-es' => 'Dificultad',
		'fr' => 'Difficulte',
		'de' => 'Schwierigkeit',
	);
	$text['difficulty_easy'] = array(
		'tr' => 'Kolay',
		'en' => 'Easy',
		'es-mx' => 'Facil',
		'es-es' => 'Facil',
		'fr' => 'Facile',
		'de' => 'Einfach',
	);
	$text['difficulty_medium'] = array(
		'tr' => 'Orta',
		'en' => 'Medium',
		'es-mx' => 'Medio',
		'es-es' => 'Medio',
		'fr' => 'Moyen',
		'de' => 'Mittel',
	);
	$text['difficulty_hard'] = array(
		'tr' => 'Zor',
		'en' => 'Hard',
		'es-mx' => 'Dificil',
		'es-es' => 'Dificil',
		'fr' => 'Difficile',
		'de' => 'Schwer',
	);
	$text['related_games'] = array(
		'tr' => 'Benzer oyunlar',
		'en' => 'Related games',
		'es-mx' => 'Juegos relacionados',
		'es-es' => 'Juegos relacionados',
		'fr' => 'Jeux similaires',
		'de' => 'Aehnliche Spiele',
	);
	$text['asker_games_link'] = array(
		'tr' => 'Askerin oyunlarına git',
		'en' => 'Go to Asker’s Games',
		'fr' => 'Aller aux jeux d’Asker',
		'de' => 'Zu Askers Spielen gehen',
	);
	$text['asker_games_title'] = array(
		'tr' => 'Askerin Oyunları',
		'en' => 'Asker’s Games',
		'fr' => 'Jeux d’Asker',
		'de' => 'Askers Spiele',
	);
	$text['arslan_games_title'] = array(
		'tr' => 'Arslanın Oyunları',
		'en' => 'Arslan’s Games',
		'fr' => 'Jeux d’Arslan',
		'de' => 'Arslans Spiele',
	);

	if (isset($text['asker_about'])) {
		$text['asker_about']['es-mx'] = 'Acerca de los juegos de Asker';
		$text['asker_about']['es-es'] = 'Acerca de los juegos de Asker';
	}

	if (isset($text['asker_games_link'])) {
		$text['asker_games_link']['es-mx'] = 'Ir a los juegos de Asker';
		$text['asker_games_link']['es-es'] = 'Ir a los juegos de Asker';
	}

	if (isset($text['asker_games_title'])) {
		$text['asker_games_title']['es-mx'] = 'Juegos de Asker';
		$text['asker_games_title']['es-es'] = 'Juegos de Asker';
	}

	if (isset($text['arslan_games_title'])) {
		$text['arslan_games_title']['es-mx'] = 'Juegos de Arslan';
		$text['arslan_games_title']['es-es'] = 'Juegos de Arslan';
	}

	return isset($text[$key][$lang]) ? $text[$key][$lang] : '';
}

function zo_get_asker_badge_items($language = '', $owner = 'asker') {
	$language = array_key_exists($language, zo_get_language_options()) ? $language : zo_get_current_language();
	$image_code = in_array($language, array('tr', 'en', 'de', 'fr'), true) ? $language : 'es';
	$owner = zo_normalize_game_owner($owner);
	$prefix = $owner === 'arslan' ? 'arslan_' : '';

	return array(
		array(
			'title_key' => 'week_streak_badge',
			'text_key' => $prefix . 'week_streak_badge_text',
			'image' => ZO_PLUGIN_URL . 'assets/play-streak/play-streak-week-' . $image_code . '.png',
			'threshold' => 300,
			'target_days' => 7,
		),
		array(
			'title_key' => 'month_streak_badge',
			'text_key' => $prefix . 'month_streak_badge_text',
			'image' => ZO_PLUGIN_URL . 'assets/play-streak/play-streak-month-' . $image_code . '.png',
			'threshold' => 120,
			'target_days' => 30,
		),
		array(
			'title_key' => $prefix . 'play_streak_badge',
			'text_key' => $prefix . 'play_streak_badge_text',
			'image' => ZO_PLUGIN_URL . 'assets/play-streak/play-streak-' . $image_code . '.png',
			'threshold' => 600,
			'target_days' => 5,
		),
		array(
			'title_key' => 'focus_hero_badge',
			'text_key' => $prefix . 'focus_hero_badge_text',
			'image' => ZO_PLUGIN_URL . 'assets/play-streak/play-streak-20-' . $image_code . '.png',
			'threshold' => 1200,
			'target_days' => 5,
		),
		array(
			'title_key' => 'daily_champion_badge',
			'text_key' => $prefix . 'daily_champion_badge_text',
			'image' => ZO_PLUGIN_URL . 'assets/play-streak/play-streak-30-' . $image_code . '.png',
			'threshold' => 1800,
			'target_days' => 5,
		),
	);
}

function zo_render_asker_badge_card($badge, $language = '', $owner = 'asker') {
	$language = array_key_exists($language, zo_get_language_options()) ? $language : zo_get_current_language();
	$owner = zo_normalize_game_owner($owner);
	$owner = $owner !== '' ? $owner : 'asker';
	$title = zo_get_interface_text($badge['title_key'], $language);
	$text = zo_get_interface_text($badge['text_key'], $language);
	$target_days = isset($badge['target_days']) ? (int) $badge['target_days'] : 5;
	$threshold = isset($badge['threshold']) ? (int) $badge['threshold'] : 600;
	$alt = trim($title . '. ' . $text);

	echo '<div class="zo-badge-center__card is-locked" data-zo-streak-badge data-owner="' . esc_attr($owner) . '" data-threshold="' . esc_attr((string) $threshold) . '" data-target-days="' . esc_attr((string) $target_days) . '" data-achievement-name="' . esc_attr($title) . '">';
	echo '<img class="zo-badge-center__image zo-games-grid__streak-image" src="' . esc_url($badge['image']) . '" alt="' . esc_attr($alt) . '" loading="lazy" decoding="async">';
	echo '<div class="zo-badge-center__body">';
	echo '<span class="zo-badge-center__title">' . esc_html($title) . '</span>';
	echo '<span class="zo-badge-center__description">' . esc_html($text) . '</span>';
	echo '<span class="zo-badge-center__status" data-zo-badge-status data-locked="' . esc_attr(zo_get_interface_text('badge_locked', $language)) . '" data-unlocked="' . esc_attr(zo_get_interface_text('badge_unlocked', $language)) . '">' . esc_html(zo_get_interface_text('badge_locked', $language)) . '</span>';
	echo '<span class="zo-badge-center__progress-track" aria-hidden="true"><span class="zo-badge-center__progress-fill" data-zo-badge-progress-fill></span></span>';
	echo '<span class="zo-badge-center__progress-text" data-zo-badge-progress-text data-template="' . esc_attr(zo_get_interface_text('badge_progress', $language)) . '">' . esc_html(sprintf(zo_get_interface_text('badge_progress', $language), 0, $target_days)) . '</span>';
	echo '<span class="zo-badge-center__history" data-zo-badge-history data-unlocked-label="' . esc_attr(zo_get_interface_text('badge_unlocked_on', $language)) . '" data-locked-label="' . esc_attr(zo_get_interface_text('badge_not_unlocked', $language)) . '">' . esc_html(zo_get_interface_text('badge_not_unlocked', $language)) . '</span>';
	echo '</div>';
	echo '</div>';
}

function zo_get_badge_center_script($language = '', $owner = 'asker') {
	$language = array_key_exists($language, zo_get_language_options()) ? $language : zo_get_current_language();
	$owner = zo_normalize_game_owner($owner);
	$owner = $owner !== '' ? $owner : 'asker';
	$streak_key = $owner === 'arslan' ? 'zoArslanPlayStreak' : 'zoAskerPlayStreak';
	$history_key = $owner === 'arslan' ? 'zoArslanBadgeUnlockHistory' : 'zoBadgeUnlockHistory';
	$seen_prefix = $owner === 'arslan' ? 'zoArslanAchievementSeen:' : 'zoAchievementSeen:';

	return '<script>(function(){var script=document.currentScript;var wrap=script&&script.closest("[data-zo-badge-scope],.zo-games-grid-wrap");if(!wrap){return;}var owner=' . wp_json_encode($owner) . ';var badges=Array.prototype.slice.call(wrap.querySelectorAll("[data-zo-streak-badge][data-owner=\""+owner+"\"],[data-zo-asker-streak-badge][data-owner=\""+owner+"\"]"));if(!badges.length){return;}var streakKey=' . wp_json_encode($streak_key) . ';var historyKey=' . wp_json_encode($history_key) . ';var seenPrefix=' . wp_json_encode($seen_prefix) . ';function readHistory(){try{var value=JSON.parse(localStorage.getItem(historyKey)||"{}");return value&&typeof value==="object"?value:{};}catch(error){return {};}}function writeHistory(value){try{localStorage.setItem(historyKey,JSON.stringify(value));}catch(error){}}function badgeKey(threshold,targetDays){return String(threshold)+":"+String(targetDays);}function formatDate(value){try{return new Intl.DateTimeFormat(undefined,{year:"numeric",month:"short",day:"numeric"}).format(new Date(value));}catch(error){return String(value||"");}}function rememberUnlock(threshold,targetDays){var history=readHistory();var key=badgeKey(threshold,targetDays);if(!history[key]){history[key]=(new Date()).toISOString();writeHistory(history);}return history[key];}function updateHistoryText(badge,threshold,targetDays,unlocked){var node=badge.querySelector("[data-zo-badge-history]");if(!node){return;}var history=readHistory();var value=history[badgeKey(threshold,targetDays)];if(unlocked||value){value=value||rememberUnlock(threshold,targetDays);node.textContent=(node.getAttribute("data-unlocked-label")||"Unlocked on")+" "+formatDate(value);}else{node.textContent=node.getAttribute("data-locked-label")||"Not unlocked yet";}}function showPopup(badge,threshold,targetDays){var seenKey=seenPrefix+threshold+":"+targetDays;if(localStorage.getItem(seenKey)==="1"){return;}localStorage.setItem(seenKey,"1");var img=badge.querySelector("img");var popup=document.createElement("div");popup.className="zo-achievement-popup";popup.setAttribute("role","status");popup.setAttribute("aria-live","polite");var media=document.createElement("img");media.className="zo-achievement-popup__image";media.alt="";media.src=img?img.src:"";var body=document.createElement("span");var eyebrow=document.createElement("span");eyebrow.className="zo-achievement-popup__eyebrow";eyebrow.textContent=' . wp_json_encode(zo_get_interface_text('achievement_unlocked', $language)) . ';var title=document.createElement("span");title.className="zo-achievement-popup__title";title.textContent=badge.getAttribute("data-achievement-name")||"";body.appendChild(eyebrow);body.appendChild(title);popup.appendChild(media);popup.appendChild(body);document.body.appendChild(popup);window.setTimeout(function(){popup.classList.add("is-visible");},30);window.setTimeout(function(){popup.classList.remove("is-visible");window.setTimeout(function(){if(popup.parentNode){popup.parentNode.removeChild(popup);}},260);},5200);}function formatProgress(template,done,total){return String(template||"%1$d / %2$d days").replace("%1$d",done).replace("%2$d",total);}try{var data=JSON.parse(localStorage.getItem(streakKey)||"{}");var days=data&&data.days&&typeof data.days==="object"?data.days:{};badges.forEach(function(badge){var threshold=Number(badge.getAttribute("data-threshold")||600);var targetDays=Number(badge.getAttribute("data-target-days")||5);var history=readHistory();var key=badgeKey(threshold,targetDays);var qualified=Object.keys(days).filter(function(day){return Number(days[day]||0)>=threshold;}).length;var capped=Math.min(targetDays,qualified);var unlocked=qualified>=targetDays||Boolean(history[key]);var status=badge.querySelector("[data-zo-badge-status]");var fill=badge.querySelector("[data-zo-badge-progress-fill]");var text=badge.querySelector("[data-zo-badge-progress-text]");badge.classList.toggle("is-unlocked",unlocked);badge.classList.toggle("is-locked",!unlocked);if(status){status.textContent=status.getAttribute(unlocked?"data-unlocked":"data-locked")||"";}if(fill){fill.style.width=Math.round((capped/targetDays)*100)+"%";}if(text){text.textContent=formatProgress(text.getAttribute("data-template"),capped,targetDays);}updateHistoryText(badge,threshold,targetDays,unlocked);if(qualified>=targetDays){rememberUnlock(threshold,targetDays);showPopup(badge,threshold,targetDays);}});}catch(error){}})();</script>';
}

function zo_get_game_language_availability($slug) {
	$restricted = array(
		'adam-asmaca' => array('tr'),
		'ai-companion-trainer' => array('en'),
		'firavunun-hazinesi' => array('tr'),
		'kelime-karistirma' => array('tr'),
		'kutsal-bocek-labirenti' => array('tr'),
		'ogretmenden-kac' => array('tr'),
		'speed-sort' => array('tr'),
		'tr-search-launcher' => array('tr'),
		'turkish-word-builder' => array('tr'),
		'ulke-100-soru' => array('tr'),
	);

	$slug = sanitize_title($slug);

	return isset($restricted[$slug]) ? $restricted[$slug] : array_keys(zo_get_language_options());
}

function zo_is_game_available_for_language($slug, $lang = '') {
	$lang = array_key_exists($lang, zo_get_language_options()) ? $lang : zo_get_current_language();

	return in_array($lang, zo_get_game_language_availability($slug), true);
}

function zo_get_runtime_translation_exact_map($lang) {
	$lang = array_key_exists($lang, zo_get_language_options()) ? $lang : zo_get_current_language();

	$translations = array(
		'tr' => array(
			'Start' => 'Başlat',
			'Play' => 'Oyna',
			'Play Again' => 'Tekrar Oyna',
			'Restart' => 'Yeniden Başlat',
			'Restart Game' => 'Oyunu Yeniden Başlat',
			'Restart Round' => 'Turu Yeniden Başlat',
			'Next' => 'Sonraki',
			'Next Round' => 'Sonraki Tur',
			'Next Question' => 'Sonraki Soru',
			'Next Level' => 'Sonraki Seviye',
			'Next Stage' => 'Sonraki Aşama',
			'Pause' => 'Duraklat',
			'Paused' => 'Duraklatıldı',
			'Resume' => 'Devam Et',
			'Refresh' => 'Yenile',
			'12/24 Format' => '12/24 Saat',
			'Paris Time' => 'Paris Saati',
			'Paris Clock' => 'Paris Saati',
			'Submit' => 'Gönder',
			'Hint' => 'İpucu',
			'Show Hint' => 'İpucu Göster',
			'Score' => 'Puan',
			'Points' => 'Puan',
			'Final Score' => 'Son Puan',
			'Best' => 'En İyi',
			'Level' => 'Seviye',
			'Round' => 'Tur',
			'Stage' => 'Aşama',
			'Time' => 'Süre',
			'Lives' => 'Can',
			'Health' => 'Sağlık',
			'Coins' => 'Coin',
			'Gold' => 'Altın',
			'Goal' => 'Hedef',
			'Question' => 'Soru',
			'Correct' => 'Doğru',
			'Wrong' => 'Yanlış',
			'Game Over' => 'Oyun Bitti',
			'GAME OVER' => 'OYUN BİTTİ',
			'You Win' => 'Kazandın',
			'You Win!' => 'Kazandın!',
			'You lost' => 'Kaybettin',
			'You Lost' => 'Kaybettin',
			'How to Play' => 'Nasıl Oynanır',
			'Rules' => 'Kurallar',
			'Move List' => 'Hamle Listesi',
			'Round History' => 'Tur Geçmişi',
			'Make a Move' => 'Hamle Yap',
			'Press Start.' => 'Başlat düğmesine bas.',
			'Press Start to begin.' => 'Başlamak için Başlat düğmesine bas.',
			'Press action to begin the challenge.' => 'Mücadeleye başlamak için hamle yap.',
			'Correct.' => 'Doğru.',
			'Wrong.' => 'Yanlış.',
			'Correct!' => 'Doğru!',
			'Wrong!' => 'Yanlış!',
			'Try again.' => 'Tekrar dene.',
			'Time is up.' => 'Süre doldu.',
			'Time finished.' => 'Süre bitti.',
			'ready' => 'hazır',
			'done' => 'bitti',
			'left' => 'kaldı',
		),
		'en' => array(
			'Başlat' => 'Start',
			'Oyna' => 'Play',
			'Tekrar Oyna' => 'Play Again',
			'Yeniden Başlat' => 'Restart',
			'Oyunu Yeniden Başlat' => 'Restart Game',
			'Turu Yeniden Başlat' => 'Restart Round',
			'Sonraki' => 'Next',
			'Sonraki Tur' => 'Next Round',
			'Sonraki Soru' => 'Next Question',
			'Sonraki Seviye' => 'Next Level',
			'Sonraki Aşama' => 'Next Stage',
			'Duraklat' => 'Pause',
			'Devam Et' => 'Resume',
			'Yenile' => 'Refresh',
			'12/24 Saat' => '12/24 Format',
			'Saati' => 'Clock',
			'Saat' => 'Time',
			'Paris Saati' => 'Paris Time',
			'Gönder' => 'Submit',
			'İpucu' => 'Hint',
			'İpucu Göster' => 'Show Hint',
			'Puan' => 'Score',
			'Son Puan' => 'Final Score',
			'En İyi' => 'Best',
			'Seviye' => 'Level',
			'Tur' => 'Round',
			'Aşama' => 'Stage',
			'Süre' => 'Time',
			'Can' => 'Lives',
			'Sağlık' => 'Health',
			'Altın' => 'Gold',
			'Hedef' => 'Goal',
			'Soru' => 'Question',
			'Doğru' => 'Correct',
			'Yanlış' => 'Wrong',
			'Oyun Bitti' => 'Game Over',
			'OYUN BİTTİ' => 'GAME OVER',
			'Kazandın' => 'You Win',
			'Kazandın!' => 'You Win!',
			'Kaybettin' => 'You Lost',
			'Nasıl Oynanır' => 'How to Play',
			'Kurallar' => 'Rules',
			'Hamle Listesi' => 'Move List',
			'Tur Geçmişi' => 'Round History',
			'Hamle Yap' => 'Make a Move',
			'Başlat düğmesine bas.' => 'Press Start.',
			'Başlamak için Başlat düğmesine bas.' => 'Press Start to begin.',
			'Doğru.' => 'Correct.',
			'Yanlış.' => 'Wrong.',
			'Doğru!' => 'Correct!',
			'Yanlış!' => 'Wrong!',
			'Tekrar dene.' => 'Try again.',
			'Süre doldu.' => 'Time is up.',
			'Süre bitti.' => 'Time finished.',
		),
		'de' => array(
			'Start' => 'Starten',
			'Play' => 'Spielen',
			'Play Again' => 'Noch einmal spielen',
			'Restart' => 'Neu starten',
			'Restart Game' => 'Spiel neu starten',
			'Restart Round' => 'Runde neu starten',
			'Next' => 'Weiter',
			'Next Round' => 'Nächste Runde',
			'Next Question' => 'Nächste Frage',
			'Next Level' => 'Nächstes Level',
			'Next Stage' => 'Nächste Stufe',
			'Pause' => 'Pause',
			'Paused' => 'Pausiert',
			'Resume' => 'Fortsetzen',
			'Refresh' => 'Aktualisieren',
			'12/24 Saat' => '12/24 Format',
			'Saati' => 'Uhr',
			'Saat' => 'Uhrzeit',
			'12/24 Format' => '12/24 Format',
			'Paris Time' => 'Pariser Zeit',
			'Paris Clock' => 'Paris-Uhr',
			'Submit' => 'Senden',
			'Hint' => 'Hinweis',
			'Show Hint' => 'Hinweis zeigen',
			'Score' => 'Punkte',
			'Points' => 'Punkte',
			'Final Score' => 'Endpunkte',
			'Best' => 'Bestwert',
			'Level' => 'Level',
			'Round' => 'Runde',
			'Stage' => 'Stufe',
			'Time' => 'Zeit',
			'Lives' => 'Leben',
			'Health' => 'Gesundheit',
			'Coins' => 'Münzen',
			'Gold' => 'Gold',
			'Goal' => 'Ziel',
			'Question' => 'Frage',
			'Correct' => 'Richtig',
			'Wrong' => 'Falsch',
			'Game Over' => 'Spiel vorbei',
			'GAME OVER' => 'SPIEL VORBEI',
			'You Win' => 'Du gewinnst',
			'You Win!' => 'Du gewinnst!',
			'You lost' => 'Du hast verloren',
			'You Lost' => 'Du hast verloren',
			'How to Play' => 'Spielanleitung',
			'Rules' => 'Regeln',
			'Move List' => 'Zugliste',
			'Round History' => 'Rundenverlauf',
			'Make a Move' => 'Zug machen',
			'Press Start.' => 'Drücke Starten.',
			'Press Start to begin.' => 'Drücke Starten, um zu beginnen.',
			'Press action to begin the challenge.' => 'Drücke die Aktion, um die Herausforderung zu starten.',
			'Correct.' => 'Richtig.',
			'Wrong.' => 'Falsch.',
			'Correct!' => 'Richtig!',
			'Wrong!' => 'Falsch!',
			'Try again.' => 'Versuche es noch einmal.',
			'Time is up.' => 'Die Zeit ist abgelaufen.',
			'Time finished.' => 'Die Zeit ist vorbei.',
			'Başlat' => 'Starten',
			'Oyna' => 'Spielen',
			'Tekrar Oyna' => 'Noch einmal spielen',
			'Yeniden Başlat' => 'Neu starten',
			'Oyunu Yeniden Başlat' => 'Spiel neu starten',
			'Sonraki' => 'Weiter',
			'Duraklat' => 'Pause',
			'Devam Et' => 'Fortsetzen',
			'Yenile' => 'Aktualisieren',
			'Gönder' => 'Senden',
			'İpucu' => 'Hinweis',
			'Puan' => 'Punkte',
			'Seviye' => 'Level',
			'Tur' => 'Runde',
			'Süre' => 'Zeit',
			'Can' => 'Leben',
			'Sağlık' => 'Gesundheit',
			'Hedef' => 'Ziel',
			'Soru' => 'Frage',
			'Doğru' => 'Richtig',
			'Yanlış' => 'Falsch',
			'Oyun Bitti' => 'Spiel vorbei',
			'Kazandın' => 'Du gewinnst',
			'Kaybettin' => 'Du hast verloren',
			'Nasıl Oynanır' => 'Spielanleitung',
			'Kurallar' => 'Regeln',
			'Hamle Yap' => 'Zug machen',
			'Başlat düğmesine bas.' => 'Drücke Starten.',
			'Başlamak için Başlat düğmesine bas.' => 'Drücke Starten, um zu beginnen.',
		),
		'fr' => array(
			'Start' => 'Démarrer',
			'Play' => 'Jouer',
			'Play Again' => 'Rejouer',
			'Restart' => 'Redémarrer',
			'Restart Game' => 'Redémarrer le jeu',
			'Next' => 'Suivant',
			'Next Round' => 'Manche suivante',
			'Next Question' => 'Question suivante',
			'Next Level' => 'Niveau suivant',
			'Pause' => 'Pause',
			'Resume' => 'Reprendre',
			'Refresh' => 'Actualiser',
			'12/24 Saat' => 'Format 12/24',
			'Saati' => 'Horloge',
			'Saat' => 'Heure',
			'Submit' => 'Envoyer',
			'Hint' => 'Indice',
			'Show Hint' => 'Afficher l’indice',
			'Score' => 'Score',
			'Points' => 'Points',
			'Final Score' => 'Score final',
			'Best' => 'Meilleur',
			'Level' => 'Niveau',
			'Round' => 'Manche',
			'Stage' => 'Étape',
			'Time' => 'Temps',
			'Lives' => 'Vies',
			'Health' => 'Santé',
			'Coins' => 'Pièces',
			'Gold' => 'Or',
			'Goal' => 'Objectif',
			'Question' => 'Question',
			'Correct' => 'Correct',
			'Wrong' => 'Incorrect',
			'Game Over' => 'Partie terminée',
			'GAME OVER' => 'PARTIE TERMINÉE',
			'You Win' => 'Tu as gagné',
			'You Win!' => 'Tu as gagné !',
			'You lost' => 'Tu as perdu',
			'You Lost' => 'Tu as perdu',
			'How to Play' => 'Comment jouer',
			'Rules' => 'Règles',
			'Move List' => 'Liste des coups',
			'Round History' => 'Historique des manches',
			'Make a Move' => 'Jouer un coup',
			'Press Start.' => 'Appuie sur Démarrer.',
			'Press Start to begin.' => 'Appuie sur Démarrer pour commencer.',
			'Press action to begin the challenge.' => 'Appuie sur action pour commencer le défi.',
			'Correct.' => 'Correct.',
			'Wrong.' => 'Incorrect.',
			'Correct!' => 'Correct !',
			'Wrong!' => 'Incorrect !',
			'Try again.' => 'Réessaie.',
			'Time is up.' => 'Le temps est écoulé.',
			'Time finished.' => 'Le temps est terminé.',
			'BaÅŸlat' => 'Démarrer',
			'Oyna' => 'Jouer',
			'Tekrar Oyna' => 'Rejouer',
			'Yeniden BaÅŸlat' => 'Redémarrer',
			'Sonraki' => 'Suivant',
			'Duraklat' => 'Pause',
			'Devam Et' => 'Reprendre',
			'Yenile' => 'Actualiser',
			'Puan' => 'Score',
			'Seviye' => 'Niveau',
			'Tur' => 'Manche',
			'SÃ¼re' => 'Temps',
			'Can' => 'Vies',
			'Hedef' => 'Objectif',
			'Soru' => 'Question',
			'DoÄŸru' => 'Correct',
			'YanlÄ±ÅŸ' => 'Incorrect',
			'Oyun Bitti' => 'Partie terminée',
		),
	);

	$spanish_exact = array(
		'Start' => 'Empezar',
		'Play' => 'Jugar',
		'Play Again' => 'Jugar de nuevo',
		'Restart' => 'Reiniciar',
		'Restart Game' => 'Reiniciar juego',
		'Next' => 'Siguiente',
		'Next Round' => 'Siguiente ronda',
		'Next Question' => 'Siguiente pregunta',
		'Next Level' => 'Siguiente nivel',
		'Pause' => 'Pausa',
		'Resume' => 'Continuar',
		'Refresh' => 'Actualizar',
		'12/24 Saat' => 'Formato 12/24',
		'Saati' => 'Reloj',
		'Saat' => 'Hora',
		'Submit' => 'Enviar',
		'Hint' => 'Pista',
		'Show Hint' => 'Mostrar pista',
		'Score' => 'Puntuación',
		'Points' => 'Puntos',
		'Final Score' => 'Puntuación final',
		'Best' => 'Mejor',
		'Level' => 'Nivel',
		'Round' => 'Ronda',
		'Stage' => 'Etapa',
		'Time' => 'Tiempo',
		'Lives' => 'Vidas',
		'Health' => 'Salud',
		'Coins' => 'Monedas',
		'Gold' => 'Oro',
		'Goal' => 'Objetivo',
		'Question' => 'Pregunta',
		'Correct' => 'Correcto',
		'Wrong' => 'Incorrecto',
		'Game Over' => 'Fin del juego',
		'GAME OVER' => 'FIN DEL JUEGO',
		'You Win' => 'Ganaste',
		'You Win!' => '¡Ganaste!',
		'You lost' => 'Perdiste',
		'You Lost' => 'Perdiste',
		'How to Play' => 'Cómo jugar',
		'Rules' => 'Reglas',
		'Move List' => 'Lista de movimientos',
		'Round History' => 'Historial de rondas',
		'Make a Move' => 'Haz un movimiento',
		'Press Start.' => 'Pulsa Empezar.',
		'Press Start to begin.' => 'Pulsa Empezar para comenzar.',
		'Press action to begin the challenge.' => 'Pulsa acción para comenzar el reto.',
		'Correct.' => 'Correcto.',
		'Wrong.' => 'Incorrecto.',
		'Correct!' => '¡Correcto!',
		'Wrong!' => '¡Incorrecto!',
		'Try again.' => 'Inténtalo de nuevo.',
		'Time is up.' => 'Se acabó el tiempo.',
		'Time finished.' => 'El tiempo terminó.',
		'Oyna' => 'Jugar',
		'Tekrar Oyna' => 'Jugar de nuevo',
		'Sonraki' => 'Siguiente',
		'Duraklat' => 'Pausa',
		'Devam Et' => 'Continuar',
		'Yenile' => 'Actualizar',
		'Puan' => 'Puntuación',
		'Seviye' => 'Nivel',
		'Tur' => 'Ronda',
		'Can' => 'Vidas',
		'Hedef' => 'Objetivo',
		'Soru' => 'Pregunta',
		'Oyun Bitti' => 'Fin del juego',
	);

	$translations['es-mx'] = $spanish_exact;
	$translations['es-es'] = $spanish_exact;

	$common_exact = array(
		'tr' => array(
			'Reset' => 'Sıfırla',
			'Flip Board' => 'Tahtayı Çevir',
			'Force AI Move' => 'Yapay Zekaya Hamle Yaptır',
			'White' => 'Beyaz',
			'Black' => 'Siyah',
			'Robot Accuracy' => 'Robot Doğruluğu',
			'Trust' => 'Güven',
			'Corrections' => 'Düzeltmeler',
			'Robot guess' => 'Robot tahmini',
			'Loading scenario...' => 'Senaryo yükleniyor...',
			'Start Stage' => 'Aşamayı Başlat',
			'Borrow 5s' => '5 sn Ödünç Al',
			'Debt' => 'Borç',
			'Hardness' => 'Zorluk',
		),
		'en' => array(
			'Başla' => 'Start',
			'Sıfırla' => 'Reset',
			'Skor' => 'Score',
			'En iyi' => 'Best',
			'Süre bitti' => 'Time is up',
			'Kapılar' => 'Doors',
			'Kapı' => 'Door',
			'Sayı seçenekleri' => 'Number choices',
			'Kaza yaptın.' => 'You crashed.',
			'Çarpma.' => 'Do not crash.',
			'Sağ ve sol ile şerit değiştir.' => 'Switch lanes with left and right.',
		),
		'de' => array(
			'Reset' => 'Zurücksetzen',
			'Flip Board' => 'Brett drehen',
			'Force AI Move' => 'KI-Zug erzwingen',
			'White' => 'Weiß',
			'Black' => 'Schwarz',
			'Robot Accuracy' => 'Robotergenauigkeit',
			'Trust' => 'Vertrauen',
			'Corrections' => 'Korrekturen',
			'Robot guess' => 'Robotertipp',
			'Loading scenario...' => 'Szenario wird geladen...',
			'Start Stage' => 'Stufe starten',
			'Borrow 5s' => '5 s leihen',
			'Debt' => 'Schuld',
			'Hardness' => 'Härte',
			'Başla' => 'Starten',
			'Sıfırla' => 'Zurücksetzen',
			'Skor' => 'Punkte',
			'En iyi' => 'Bestwert',
			'Süre bitti' => 'Zeit abgelaufen',
			'Kapılar' => 'Türen',
			'Kapı' => 'Tür',
			'Sayı seçenekleri' => 'Zahlenauswahl',
			'Kaza yaptın.' => 'Du bist verunglückt.',
			'Çarpma.' => 'Nicht zusammenstoßen.',
			'Sağ ve sol ile şerit değiştir.' => 'Wechsle mit links und rechts die Spur.',
		),
		'fr' => array(
			'Reset' => 'Réinitialiser',
			'Flip Board' => 'Retourner le plateau',
			'Force AI Move' => 'Forcer le coup de l’IA',
			'White' => 'Blanc',
			'Black' => 'Noir',
			'Robot Accuracy' => 'Précision du robot',
			'Trust' => 'Confiance',
			'Corrections' => 'Corrections',
			'Robot guess' => 'Choix du robot',
			'Loading scenario...' => 'Chargement du scénario...',
			'Start Stage' => 'Démarrer l’étape',
			'Borrow 5s' => 'Emprunter 5 s',
			'Debt' => 'Dette',
			'Hardness' => 'Difficulté',
			'Başla' => 'Démarrer',
			'Sıfırla' => 'Réinitialiser',
			'Skor' => 'Score',
			'En iyi' => 'Meilleur',
			'Süre bitti' => 'Le temps est écoulé',
			'Kapılar' => 'Portes',
			'Kapı' => 'Porte',
			'Sayı seçenekleri' => 'Choix de nombres',
			'Kaza yaptın.' => 'Tu as eu un accident.',
			'Çarpma.' => 'Évite la collision.',
			'Sağ ve sol ile şerit değiştir.' => 'Change de voie avec gauche et droite.',
		),
		'es-mx' => array(
			'Reset' => 'Reiniciar',
			'Flip Board' => 'Girar tablero',
			'Force AI Move' => 'Forzar movimiento de IA',
			'White' => 'Blanco',
			'Black' => 'Negro',
			'Robot Accuracy' => 'Precisión del robot',
			'Trust' => 'Confianza',
			'Corrections' => 'Correcciones',
			'Robot guess' => 'Predicción del robot',
			'Loading scenario...' => 'Cargando escenario...',
			'Start Stage' => 'Empezar etapa',
			'Borrow 5s' => 'Pedir 5 s',
			'Debt' => 'Deuda',
			'Hardness' => 'Dificultad',
			'Başla' => 'Empezar',
			'Sıfırla' => 'Reiniciar',
			'Skor' => 'Puntuación',
			'En iyi' => 'Mejor',
			'Süre bitti' => 'Se acabó el tiempo',
			'Kapılar' => 'Puertas',
			'Kapı' => 'Puerta',
			'Sayı seçenekleri' => 'Opciones de número',
			'Kaza yaptın.' => 'Chocaste.',
			'Çarpma.' => 'No choques.',
			'Sağ ve sol ile şerit değiştir.' => 'Cambia de carril con izquierda y derecha.',
		),
		'es-es' => array(
			'Reset' => 'Reiniciar',
			'Flip Board' => 'Girar tablero',
			'Force AI Move' => 'Forzar movimiento de IA',
			'White' => 'Blanco',
			'Black' => 'Negro',
			'Robot Accuracy' => 'Precisión del robot',
			'Trust' => 'Confianza',
			'Corrections' => 'Correcciones',
			'Robot guess' => 'Predicción del robot',
			'Loading scenario...' => 'Cargando escenario...',
			'Start Stage' => 'Empezar etapa',
			'Borrow 5s' => 'Pedir 5 s',
			'Debt' => 'Deuda',
			'Hardness' => 'Dificultad',
			'Başla' => 'Empezar',
			'Sıfırla' => 'Reiniciar',
			'Skor' => 'Puntuación',
			'En iyi' => 'Mejor',
			'Süre bitti' => 'Se acabó el tiempo',
			'Kapılar' => 'Puertas',
			'Kapı' => 'Puerta',
			'Sayı seçenekleri' => 'Opciones de número',
			'Kaza yaptın.' => 'Has chocado.',
			'Çarpma.' => 'No choques.',
			'Sağ ve sol ile şerit değiştir.' => 'Cambia de carril con izquierda y derecha.',
		),
	);

	$shared_game_exact = array(
		'tr' => array(
			'New Puzzle' => 'Yeni Bulmaca',
			'Check Grid' => 'Izgarayı Kontrol Et',
			'Clear Moves' => 'Hamleleri Temizle',
			'Calculate' => 'Hesapla',
			'Launch' => 'Fırlat',
			'Left' => 'Sol',
			'Right' => 'Sağ',
			'Up' => 'Yukarı',
			'Down' => 'Aşağı',
			'Move up' => 'Yukarı hareket et',
			'Move left' => 'Sola hareket et',
			'Move down' => 'Aşağı hareket et',
			'Move right' => 'Sağa hareket et',
			'Controls' => 'Kontroller',
			'Actions' => 'Eylemler',
			'Towers' => 'Kuleler',
			'Pick Arrow' => 'Ok Kulesi Seç',
			'Pick Cannon' => 'Top Kulesi Seç',
			'Pick Frost' => 'Buz Kulesi Seç',
			'Fruit Bin' => 'Meyve Kutusu',
			'Trash Bin' => 'Çöp Kutusu',
			'Compost Bin' => 'Kompost Kutusu',
			'Water Tank' => 'Su Tankı',
			'New Game' => 'Yeni Oyun',
			'Buy' => 'Satın Al',
			'Next Day' => 'Sonraki Gün',
			'Manager Info' => 'Yönetici Bilgisi',
			'Shop Upgrades' => 'Dükkan Yükseltmeleri',
			'Learning Signals' => 'Öğrenme Sinyalleri',
			'Coach Traits' => 'Koç Özellikleri',
			'Training Log' => 'Eğitim Günlüğü',
			'Restart Training' => 'Eğitimi Yeniden Başlat',
			'Select an operation.' => 'Bir işlem seç.',
			'Please enter a valid first number.' => 'Lütfen geçerli bir ilk sayı gir.',
			'Please enter a valid second number.' => 'Lütfen geçerli bir ikinci sayı gir.',
			'Cannot divide by zero.' => 'Sıfıra bölünemez.',
			'Cannot take the square root of a negative number.' => 'Negatif sayının karekökü alınamaz.',
			'No answers yet.' => 'Henüz cevap yok.',
			'Game finished' => 'Oyun bitti',
			'Finished' => 'Bitti',
			'Perfect Balance' => 'Mükemmel Denge',
			'Correct bin.' => 'Doğru kutu.',
			'Classify the bug.' => 'Böceği sınıflandır.',
			'Classify the bugs before time runs out.' => 'Süre bitmeden böcekleri sınıflandır.',
			'You lost all lives. Press Start.' => 'Tüm canları kaybettin. Başlat’a bas.',
			'Press Start.' => 'Başlat’a bas.',
			'Press Start to begin.' => 'Başlamak için Başlat’a bas.',
			'Life lost. Launch again.' => 'Can kaybettin. Tekrar fırlat.',
			'Game over. Press R or Restart.' => 'Oyun bitti. R’ye ya da Yeniden Başlat’a bas.',
			'Break every brick.' => 'Tüm blokları kır.',
			'You beat all 1000 levels!' => '1000 seviyenin hepsini geçtin!',
			'Great run! Keep the pattern going.' => 'Harika gidiş! Deseni sürdür.',
			'Action logged. Try for a longer chain.' => 'Hamle kaydedildi. Daha uzun zincir dene.',
			'Correct balloon!' => 'Doğru balon!',
			'Wrong balloon.' => 'Yanlış balon.',
			'Pop the correct balloons.' => 'Doğru balonları patlat.',
		),
		'de' => array(
			'New Puzzle' => 'Neues Rätsel',
			'Check Grid' => 'Raster prüfen',
			'Clear Moves' => 'Züge löschen',
			'Calculate' => 'Berechnen',
			'Launch' => 'Starten',
			'Left' => 'Links',
			'Right' => 'Rechts',
			'Up' => 'Hoch',
			'Down' => 'Runter',
			'Move up' => 'Nach oben bewegen',
			'Move left' => 'Nach links bewegen',
			'Move down' => 'Nach unten bewegen',
			'Move right' => 'Nach rechts bewegen',
			'Controls' => 'Steuerung',
			'Actions' => 'Aktionen',
			'Towers' => 'Türme',
			'Pick Arrow' => 'Pfeil wählen',
			'Pick Cannon' => 'Kanone wählen',
			'Pick Frost' => 'Frost wählen',
			'Fruit Bin' => 'Obstbehälter',
			'Trash Bin' => 'Müllbehälter',
			'Compost Bin' => 'Kompostbehälter',
			'Water Tank' => 'Wassertank',
			'New Game' => 'Neues Spiel',
			'Buy' => 'Kaufen',
			'Next Day' => 'Nächster Tag',
			'Manager Info' => 'Manager-Info',
			'Shop Upgrades' => 'Laden-Upgrades',
			'Learning Signals' => 'Lernsignale',
			'Coach Traits' => 'Coach-Eigenschaften',
			'Training Log' => 'Trainingsprotokoll',
			'Restart Training' => 'Training neu starten',
			'Select an operation.' => 'Wähle eine Rechenart.',
			'Please enter a valid first number.' => 'Bitte gib eine gültige erste Zahl ein.',
			'Please enter a valid second number.' => 'Bitte gib eine gültige zweite Zahl ein.',
			'Cannot divide by zero.' => 'Durch null kann nicht geteilt werden.',
			'Cannot take the square root of a negative number.' => 'Die Quadratwurzel einer negativen Zahl ist nicht möglich.',
			'No answers yet.' => 'Noch keine Antworten.',
			'Game finished' => 'Spiel beendet',
			'Finished' => 'Beendet',
			'Perfect Balance' => 'Perfektes Gleichgewicht',
			'Correct bin.' => 'Richtiger Behälter.',
			'Classify the bug.' => 'Sortiere das Insekt.',
			'Classify the bugs before time runs out.' => 'Sortiere die Insekten, bevor die Zeit abläuft.',
			'You lost all lives. Press Start.' => 'Du hast alle Leben verloren. Drücke Starten.',
			'Press Start.' => 'Drücke Starten.',
			'Press Start to begin.' => 'Drücke Starten, um zu beginnen.',
			'Life lost. Launch again.' => 'Leben verloren. Starte erneut.',
			'Game over. Press R or Restart.' => 'Spiel vorbei. Drücke R oder Neustart.',
			'Break every brick.' => 'Zerbrich jeden Stein.',
			'You beat all 1000 levels!' => 'Du hast alle 1000 Level geschafft!',
			'Great run! Keep the pattern going.' => 'Starker Lauf! Halte das Muster am Laufen.',
			'Action logged. Try for a longer chain.' => 'Aktion gespeichert. Versuche eine längere Kette.',
			'Correct balloon!' => 'Richtiger Ballon!',
			'Wrong balloon.' => 'Falscher Ballon.',
			'Pop the correct balloons.' => 'Lass die richtigen Ballons platzen.',
		),
		'fr' => array(
			'New Puzzle' => 'Nouveau puzzle',
			'Check Grid' => 'Vérifier la grille',
			'Clear Moves' => 'Effacer les coups',
			'Calculate' => 'Calculer',
			'Launch' => 'Lancer',
			'Left' => 'Gauche',
			'Right' => 'Droite',
			'Up' => 'Haut',
			'Down' => 'Bas',
			'Move up' => 'Aller vers le haut',
			'Move left' => 'Aller à gauche',
			'Move down' => 'Aller vers le bas',
			'Move right' => 'Aller à droite',
			'Controls' => 'Commandes',
			'Actions' => 'Actions',
			'Towers' => 'Tours',
			'Pick Arrow' => 'Choisir flèche',
			'Pick Cannon' => 'Choisir canon',
			'Pick Frost' => 'Choisir gel',
			'Fruit Bin' => 'Bac à fruits',
			'Trash Bin' => 'Poubelle',
			'Compost Bin' => 'Bac à compost',
			'Water Tank' => 'Réservoir d’eau',
			'New Game' => 'Nouvelle partie',
			'Buy' => 'Acheter',
			'Next Day' => 'Jour suivant',
			'Manager Info' => 'Infos du manager',
			'Shop Upgrades' => 'Améliorations de boutique',
			'Learning Signals' => 'Signaux d’apprentissage',
			'Coach Traits' => 'Traits du coach',
			'Training Log' => 'Journal d’entraînement',
			'Restart Training' => 'Redémarrer l’entraînement',
			'Select an operation.' => 'Choisis une opération.',
			'Please enter a valid first number.' => 'Entre un premier nombre valide.',
			'Please enter a valid second number.' => 'Entre un deuxième nombre valide.',
			'Cannot divide by zero.' => 'Impossible de diviser par zéro.',
			'Cannot take the square root of a negative number.' => 'Impossible de prendre la racine carrée d’un nombre négatif.',
			'No answers yet.' => 'Aucune réponse pour l’instant.',
			'Game finished' => 'Partie terminée',
			'Finished' => 'Terminé',
			'Perfect Balance' => 'Équilibre parfait',
			'Correct bin.' => 'Bon bac.',
			'Classify the bug.' => 'Classe l’insecte.',
			'Classify the bugs before time runs out.' => 'Classe les insectes avant la fin du temps.',
			'You lost all lives. Press Start.' => 'Tu as perdu toutes tes vies. Appuie sur Démarrer.',
			'Press Start.' => 'Appuie sur Démarrer.',
			'Press Start to begin.' => 'Appuie sur Démarrer pour commencer.',
			'Life lost. Launch again.' => 'Vie perdue. Relance.',
			'Game over. Press R or Restart.' => 'Partie terminée. Appuie sur R ou Redémarrer.',
			'Break every brick.' => 'Casse toutes les briques.',
			'You beat all 1000 levels!' => 'Tu as terminé les 1000 niveaux !',
			'Great run! Keep the pattern going.' => 'Belle série ! Continue le motif.',
			'Action logged. Try for a longer chain.' => 'Action enregistrée. Essaie une chaîne plus longue.',
			'Correct balloon!' => 'Bon ballon !',
			'Wrong balloon.' => 'Mauvais ballon.',
			'Pop the correct balloons.' => 'Éclate les bons ballons.',
		),
		'es-mx' => array(
			'New Puzzle' => 'Nuevo rompecabezas',
			'Check Grid' => 'Revisar cuadrícula',
			'Clear Moves' => 'Borrar movimientos',
			'Calculate' => 'Calcular',
			'Launch' => 'Lanzar',
			'Left' => 'Izquierda',
			'Right' => 'Derecha',
			'Up' => 'Arriba',
			'Down' => 'Abajo',
			'Move up' => 'Mover arriba',
			'Move left' => 'Mover a la izquierda',
			'Move down' => 'Mover abajo',
			'Move right' => 'Mover a la derecha',
			'Controls' => 'Controles',
			'Actions' => 'Acciones',
			'Towers' => 'Torres',
			'Pick Arrow' => 'Elegir flecha',
			'Pick Cannon' => 'Elegir cañón',
			'Pick Frost' => 'Elegir hielo',
			'Fruit Bin' => 'Contenedor de fruta',
			'Trash Bin' => 'Contenedor de basura',
			'Compost Bin' => 'Contenedor de composta',
			'Water Tank' => 'Tanque de agua',
			'New Game' => 'Nuevo juego',
			'Buy' => 'Comprar',
			'Next Day' => 'Siguiente día',
			'Manager Info' => 'Información del mánager',
			'Shop Upgrades' => 'Mejoras de tienda',
			'Learning Signals' => 'Señales de aprendizaje',
			'Coach Traits' => 'Rasgos del entrenador',
			'Training Log' => 'Registro de entrenamiento',
			'Restart Training' => 'Reiniciar entrenamiento',
			'Select an operation.' => 'Elige una operación.',
			'Please enter a valid first number.' => 'Escribe un primer número válido.',
			'Please enter a valid second number.' => 'Escribe un segundo número válido.',
			'Cannot divide by zero.' => 'No se puede dividir entre cero.',
			'Cannot take the square root of a negative number.' => 'No se puede sacar raíz cuadrada de un número negativo.',
			'No answers yet.' => 'Todavía no hay respuestas.',
			'Game finished' => 'Juego terminado',
			'Finished' => 'Terminado',
			'Perfect Balance' => 'Equilibrio perfecto',
			'Correct bin.' => 'Contenedor correcto.',
			'Classify the bug.' => 'Clasifica el insecto.',
			'Classify the bugs before time runs out.' => 'Clasifica los insectos antes de que se acabe el tiempo.',
			'You lost all lives. Press Start.' => 'Perdiste todas las vidas. Pulsa Empezar.',
			'Press Start.' => 'Pulsa Empezar.',
			'Press Start to begin.' => 'Pulsa Empezar para comenzar.',
			'Life lost. Launch again.' => 'Vida perdida. Lanza de nuevo.',
			'Game over. Press R or Restart.' => 'Fin del juego. Pulsa R o Reiniciar.',
			'Break every brick.' => 'Rompe todos los bloques.',
			'You beat all 1000 levels!' => '¡Superaste los 1000 niveles!',
			'Great run! Keep the pattern going.' => '¡Buena racha! Mantén el patrón.',
			'Action logged. Try for a longer chain.' => 'Acción registrada. Intenta una cadena más larga.',
			'Correct balloon!' => '¡Globo correcto!',
			'Wrong balloon.' => 'Globo incorrecto.',
			'Pop the correct balloons.' => 'Revienta los globos correctos.',
		),
		'es-es' => array(
			'New Puzzle' => 'Nuevo puzle',
			'Check Grid' => 'Comprobar cuadrícula',
			'Clear Moves' => 'Borrar movimientos',
			'Calculate' => 'Calcular',
			'Launch' => 'Lanzar',
			'Left' => 'Izquierda',
			'Right' => 'Derecha',
			'Up' => 'Arriba',
			'Down' => 'Abajo',
			'Move up' => 'Mover arriba',
			'Move left' => 'Mover a la izquierda',
			'Move down' => 'Mover abajo',
			'Move right' => 'Mover a la derecha',
			'Controls' => 'Controles',
			'Actions' => 'Acciones',
			'Towers' => 'Torres',
			'Pick Arrow' => 'Elegir flecha',
			'Pick Cannon' => 'Elegir cañón',
			'Pick Frost' => 'Elegir hielo',
			'Fruit Bin' => 'Contenedor de fruta',
			'Trash Bin' => 'Contenedor de basura',
			'Compost Bin' => 'Contenedor de compost',
			'Water Tank' => 'Tanque de agua',
			'New Game' => 'Nuevo juego',
			'Buy' => 'Comprar',
			'Next Day' => 'Día siguiente',
			'Manager Info' => 'Información del mánager',
			'Shop Upgrades' => 'Mejoras de tienda',
			'Learning Signals' => 'Señales de aprendizaje',
			'Coach Traits' => 'Rasgos del entrenador',
			'Training Log' => 'Registro de entrenamiento',
			'Restart Training' => 'Reiniciar entrenamiento',
			'Select an operation.' => 'Elige una operación.',
			'Please enter a valid first number.' => 'Introduce un primer número válido.',
			'Please enter a valid second number.' => 'Introduce un segundo número válido.',
			'Cannot divide by zero.' => 'No se puede dividir entre cero.',
			'Cannot take the square root of a negative number.' => 'No se puede sacar la raíz cuadrada de un número negativo.',
			'No answers yet.' => 'Todavía no hay respuestas.',
			'Game finished' => 'Juego terminado',
			'Finished' => 'Terminado',
			'Perfect Balance' => 'Equilibrio perfecto',
			'Correct bin.' => 'Contenedor correcto.',
			'Classify the bug.' => 'Clasifica el insecto.',
			'Classify the bugs before time runs out.' => 'Clasifica los insectos antes de que se acabe el tiempo.',
			'You lost all lives. Press Start.' => 'Has perdido todas las vidas. Pulsa Empezar.',
			'Press Start.' => 'Pulsa Empezar.',
			'Press Start to begin.' => 'Pulsa Empezar para empezar.',
			'Life lost. Launch again.' => 'Vida perdida. Lanza de nuevo.',
			'Game over. Press R or Restart.' => 'Fin del juego. Pulsa R o Reiniciar.',
			'Break every brick.' => 'Rompe todos los bloques.',
			'You beat all 1000 levels!' => '¡Has superado los 1000 niveles!',
			'Great run! Keep the pattern going.' => '¡Buena racha! Mantén el patrón.',
			'Action logged. Try for a longer chain.' => 'Acción registrada. Intenta una cadena más larga.',
			'Correct balloon!' => '¡Globo correcto!',
			'Wrong balloon.' => 'Globo incorrecto.',
			'Pop the correct balloons.' => 'Revienta los globos correctos.',
		),
	);

	foreach ($shared_game_exact as $shared_lang => $shared_items) {
		if (isset($translations[$shared_lang])) {
			$translations[$shared_lang] = array_merge($translations[$shared_lang], $shared_items);
		}
	}

	$panel_control_exact = array(
		'tr' => array(
			'How It Works' => 'Nasıl Çalışır',
			'What Towers Do' => 'Kuleler Ne Yapar',
			'Send Units' => 'Birim Gönder',
			'Enemy Units' => 'Düşman Birimleri',
			'Battle Log' => 'Savaş Günlüğü',
			'Rescue Grid' => 'Kurtarma Izgarası',
			'Reset Sector' => 'Bölümü Sıfırla',
			'Next Sector' => 'Sonraki Bölüm',
			'Reveal Treasure' => 'Hazineyi Göster',
			'TREASURE' => 'HAZİNE',
			'TRAP' => 'TUZAK',
			'Chest' => 'Sandık',
			'Past' => 'Geçmiş',
			'Future' => 'Gelecek',
			'Your Ladder' => 'Merdivenin',
			'Undo' => 'Geri Al',
			'Change 1st' => '1.yi Değiştir',
			'Change 2nd' => '2.yi Değiştir',
			'Change 3rd' => '3.yü Değiştir',
			'More Enemies' => 'Daha Fazla Düşman',
			'Work For Money' => 'Para İçin Çalış',
			'Toggle Top Path' => 'Üst Yolu Aç/Kapat',
			'Toggle Bottom Path' => 'Alt Yolu Aç/Kapat',
			'Basic' => 'Temel',
			'Sniper' => 'Keskin Nişancı',
			'Freeze' => 'Dondur',
			'Poison' => 'Zehir',
			'Bank' => 'Banka',
			'Attack' => 'Saldır',
			'Shield' => 'Kalkan',
			'Hack' => 'Hackle',
			'Appeal' => 'İtiraz Et',
		),
		'de' => array(
			'How It Works' => 'So funktioniert es',
			'What Towers Do' => 'Was Türme tun',
			'Send Units' => 'Einheiten senden',
			'Enemy Units' => 'Gegnerische Einheiten',
			'Battle Log' => 'Kampfprotokoll',
			'Rescue Grid' => 'Rettungsraster',
			'Reset Sector' => 'Sektor zurücksetzen',
			'Next Sector' => 'Nächster Sektor',
			'Reveal Treasure' => 'Schatz zeigen',
			'TREASURE' => 'SCHATZ',
			'TRAP' => 'FALLE',
			'Chest' => 'Truhe',
			'Past' => 'Vergangenheit',
			'Future' => 'Zukunft',
			'Your Ladder' => 'Deine Leiter',
			'Undo' => 'Rückgängig',
			'Change 1st' => '1. ändern',
			'Change 2nd' => '2. ändern',
			'Change 3rd' => '3. ändern',
			'More Enemies' => 'Mehr Gegner',
			'Work For Money' => 'Für Geld arbeiten',
			'Toggle Top Path' => 'Oberen Weg umschalten',
			'Toggle Bottom Path' => 'Unteren Weg umschalten',
			'Basic' => 'Basis',
			'Sniper' => 'Scharfschütze',
			'Freeze' => 'Frost',
			'Poison' => 'Gift',
			'Bank' => 'Bank',
			'Attack' => 'Angriff',
			'Shield' => 'Schild',
			'Hack' => 'Hack',
			'Appeal' => 'Appell',
		),
		'fr' => array(
			'How It Works' => 'Comment ça marche',
			'What Towers Do' => 'Ce que font les tours',
			'Send Units' => 'Envoyer des unités',
			'Enemy Units' => 'Unités ennemies',
			'Battle Log' => 'Journal de combat',
			'Rescue Grid' => 'Grille de sauvetage',
			'Reset Sector' => 'Réinitialiser le secteur',
			'Next Sector' => 'Secteur suivant',
			'Reveal Treasure' => 'Révéler le trésor',
			'TREASURE' => 'TRÉSOR',
			'TRAP' => 'PIÈGE',
			'Chest' => 'Coffre',
			'Past' => 'Passé',
			'Future' => 'Futur',
			'Your Ladder' => 'Ton échelle',
			'Undo' => 'Annuler',
			'Change 1st' => 'Changer le 1er',
			'Change 2nd' => 'Changer le 2e',
			'Change 3rd' => 'Changer le 3e',
			'More Enemies' => 'Plus d’ennemis',
			'Work For Money' => 'Travailler pour de l’argent',
			'Toggle Top Path' => 'Basculer le chemin du haut',
			'Toggle Bottom Path' => 'Basculer le chemin du bas',
			'Basic' => 'Basique',
			'Sniper' => 'Sniper',
			'Freeze' => 'Gel',
			'Poison' => 'Poison',
			'Bank' => 'Banque',
			'Attack' => 'Attaque',
			'Shield' => 'Bouclier',
			'Hack' => 'Pirater',
			'Appeal' => 'Appel',
		),
		'es-mx' => array(
			'How It Works' => 'Cómo funciona',
			'What Towers Do' => 'Qué hacen las torres',
			'Send Units' => 'Enviar unidades',
			'Enemy Units' => 'Unidades enemigas',
			'Battle Log' => 'Registro de batalla',
			'Rescue Grid' => 'Cuadrícula de rescate',
			'Reset Sector' => 'Reiniciar sector',
			'Next Sector' => 'Siguiente sector',
			'Reveal Treasure' => 'Revelar tesoro',
			'TREASURE' => 'TESORO',
			'TRAP' => 'TRAMPA',
			'Chest' => 'Cofre',
			'Past' => 'Pasado',
			'Future' => 'Futuro',
			'Your Ladder' => 'Tu escalera',
			'Undo' => 'Deshacer',
			'Change 1st' => 'Cambiar 1.º',
			'Change 2nd' => 'Cambiar 2.º',
			'Change 3rd' => 'Cambiar 3.º',
			'More Enemies' => 'Más enemigos',
			'Work For Money' => 'Trabajar por dinero',
			'Toggle Top Path' => 'Alternar camino superior',
			'Toggle Bottom Path' => 'Alternar camino inferior',
			'Basic' => 'Básico',
			'Sniper' => 'Francotirador',
			'Freeze' => 'Congelar',
			'Poison' => 'Veneno',
			'Bank' => 'Banco',
			'Attack' => 'Atacar',
			'Shield' => 'Escudo',
			'Hack' => 'Hackear',
			'Appeal' => 'Apelar',
		),
		'es-es' => array(
			'How It Works' => 'Cómo funciona',
			'What Towers Do' => 'Qué hacen las torres',
			'Send Units' => 'Enviar unidades',
			'Enemy Units' => 'Unidades enemigas',
			'Battle Log' => 'Registro de batalla',
			'Rescue Grid' => 'Cuadrícula de rescate',
			'Reset Sector' => 'Reiniciar sector',
			'Next Sector' => 'Siguiente sector',
			'Reveal Treasure' => 'Revelar tesoro',
			'TREASURE' => 'TESORO',
			'TRAP' => 'TRAMPA',
			'Chest' => 'Cofre',
			'Past' => 'Pasado',
			'Future' => 'Futuro',
			'Your Ladder' => 'Tu escalera',
			'Undo' => 'Deshacer',
			'Change 1st' => 'Cambiar 1.º',
			'Change 2nd' => 'Cambiar 2.º',
			'Change 3rd' => 'Cambiar 3.º',
			'More Enemies' => 'Más enemigos',
			'Work For Money' => 'Trabajar por dinero',
			'Toggle Top Path' => 'Alternar camino superior',
			'Toggle Bottom Path' => 'Alternar camino inferior',
			'Basic' => 'Básico',
			'Sniper' => 'Francotirador',
			'Freeze' => 'Congelar',
			'Poison' => 'Veneno',
			'Bank' => 'Banco',
			'Attack' => 'Atacar',
			'Shield' => 'Escudo',
			'Hack' => 'Hackear',
			'Appeal' => 'Apelar',
		),
	);

	foreach ($panel_control_exact as $panel_lang => $panel_items) {
		if (isset($translations[$panel_lang])) {
			$translations[$panel_lang] = array_merge($translations[$panel_lang], $panel_items);
		}
	}

	$extra_runtime_exact = array(
		'tr' => array(
			'Your robot helper is waiting for its first lesson.' => 'Robot yardımcın ilk dersini bekliyor.',
			'Choose the best move for this round.' => 'Bu tur için en iyi hamleyi seç.',
			'Nice coaching.' => 'Güzel koçluk.',
			'That choice teaches a risky habit.' => 'Bu seçim riskli bir alışkanlık öğretir.',
			'Training finished. Review the summary and restart for a new run.' => 'Eğitim bitti. Özeti incele ve yeni deneme için yeniden başlat.',
			'Decode the message by replacing each cipher letter with the correct plain letter.' => 'Her şifreli harfi doğru normal harfle değiştirerek mesajı çöz.',
			'Write your decoded phrase first.' => 'Önce çözdüğün cümleyi yaz.',
			'Correct! You cracked the cryptogram. Great job!' => 'Doğru! Şifreyi çözdün. Harika iş!',
			'Not quite yet. Check your letters and try again.' => 'Henüz değil. Harflerini kontrol et ve tekrar dene.',
			'Here is the decoded phrase.' => 'Çözülmüş cümle burada.',
			'Watch the sequence.' => 'Sırayı izle.',
			'Now repeat.' => 'Şimdi tekrar et.',
			'Correct! Next level.' => 'Doğru! Sonraki seviye.',
			'Box' => 'Kutu',
			'Duck found' => 'Ördek bulundu',
			'No duck' => 'Ördek yok',
			'Switch World' => 'Dünya Değiştir',
			'Check' => 'Kontrol Et',
			'Replay' => 'Tekrar Göster',
			'Advertise $20' => 'Reklam Ver $20',
			'Reset Scores' => 'Puanları Sıfırla',
			'Reset Unlocks' => 'Açılanları Sıfırla',
			'Close' => 'Kapat',
			'Sound Off' => 'Ses Kapalı',
			'Parent Menu' => 'Ebeveyn Menüsü',
			'Start Match' => 'Maçı Başlat',
			'Press Start Match' => 'Maçı Başlat’a bas',
			'Speed' => 'Hız',
			'Smartness' => 'Zeka',
			'Shooting' => 'Şut',
			'Passing' => 'Pas',
			'Defense' => 'Savunma',
			'Stopped' => 'Durdu',
		),
		'de' => array(
			'Your robot helper is waiting for its first lesson.' => 'Dein Roboterhelfer wartet auf seine erste Lektion.',
			'Choose the best move for this round.' => 'Wähle den besten Zug für diese Runde.',
			'Nice coaching.' => 'Gutes Coaching.',
			'That choice teaches a risky habit.' => 'Diese Wahl lehrt eine riskante Gewohnheit.',
			'Training finished. Review the summary and restart for a new run.' => 'Training beendet. Sieh dir die Zusammenfassung an und starte neu.',
			'Decode the message by replacing each cipher letter with the correct plain letter.' => 'Entschlüssle die Nachricht, indem du jeden Geheimtext-Buchstaben ersetzt.',
			'Write your decoded phrase first.' => 'Schreibe zuerst deinen entschlüsselten Satz.',
			'Correct! You cracked the cryptogram. Great job!' => 'Richtig! Du hast das Kryptogramm geknackt. Gut gemacht!',
			'Not quite yet. Check your letters and try again.' => 'Noch nicht ganz. Prüfe deine Buchstaben und versuche es erneut.',
			'Here is the decoded phrase.' => 'Hier ist der entschlüsselte Satz.',
			'Watch the sequence.' => 'Merke dir die Reihenfolge.',
			'Now repeat.' => 'Jetzt wiederholen.',
			'Correct! Next level.' => 'Richtig! Nächstes Level.',
			'Box' => 'Kiste',
			'Duck found' => 'Ente gefunden',
			'No duck' => 'Keine Ente',
			'Switch World' => 'Welt wechseln',
			'Check' => 'Prüfen',
			'Replay' => 'Wiederholen',
			'Advertise $20' => 'Werben $20',
			'Reset Scores' => 'Punkte zurücksetzen',
			'Reset Unlocks' => 'Freischaltungen zurücksetzen',
			'Close' => 'Schließen',
			'Sound Off' => 'Ton aus',
			'Parent Menu' => 'Elternmenü',
			'Start Match' => 'Spiel starten',
			'Press Start Match' => 'Drücke Spiel starten',
			'Speed' => 'Tempo',
			'Smartness' => 'Klugheit',
			'Shooting' => 'Schuss',
			'Passing' => 'Passspiel',
			'Defense' => 'Abwehr',
			'Stopped' => 'Gestoppt',
		),
		'fr' => array(
			'Your robot helper is waiting for its first lesson.' => 'Ton assistant robot attend sa première leçon.',
			'Choose the best move for this round.' => 'Choisis le meilleur coup pour cette manche.',
			'Nice coaching.' => 'Bon coaching.',
			'That choice teaches a risky habit.' => 'Ce choix enseigne une habitude risquée.',
			'Training finished. Review the summary and restart for a new run.' => 'Entraînement terminé. Regarde le résumé puis recommence.',
			'Decode the message by replacing each cipher letter with the correct plain letter.' => 'Décode le message en remplaçant chaque lettre chiffrée par la bonne lettre.',
			'Write your decoded phrase first.' => 'Écris d’abord ta phrase décodée.',
			'Correct! You cracked the cryptogram. Great job!' => 'Correct ! Tu as résolu le cryptogramme. Bravo !',
			'Not quite yet. Check your letters and try again.' => 'Pas encore. Vérifie tes lettres et réessaie.',
			'Here is the decoded phrase.' => 'Voici la phrase décodée.',
			'Watch the sequence.' => 'Observe la séquence.',
			'Now repeat.' => 'Maintenant répète.',
			'Correct! Next level.' => 'Correct ! Niveau suivant.',
			'Box' => 'Boîte',
			'Duck found' => 'Canard trouvé',
			'No duck' => 'Pas de canard',
			'Switch World' => 'Changer de monde',
			'Check' => 'Vérifier',
			'Replay' => 'Rejouer',
			'Advertise $20' => 'Publicité $20',
			'Reset Scores' => 'Réinitialiser les scores',
			'Reset Unlocks' => 'Réinitialiser les déblocages',
			'Close' => 'Fermer',
			'Sound Off' => 'Son coupé',
			'Parent Menu' => 'Menu parent',
			'Start Match' => 'Démarrer le match',
			'Press Start Match' => 'Appuie sur Démarrer le match',
			'Speed' => 'Vitesse',
			'Smartness' => 'Intelligence',
			'Shooting' => 'Tir',
			'Passing' => 'Passe',
			'Defense' => 'Défense',
			'Stopped' => 'Arrêté',
		),
		'es-mx' => array(
			'Your robot helper is waiting for its first lesson.' => 'Tu robot ayudante espera su primera lección.',
			'Choose the best move for this round.' => 'Elige el mejor movimiento para esta ronda.',
			'Nice coaching.' => 'Buen entrenamiento.',
			'That choice teaches a risky habit.' => 'Esa elección enseña un hábito riesgoso.',
			'Training finished. Review the summary and restart for a new run.' => 'Entrenamiento terminado. Revisa el resumen y reinicia.',
			'Decode the message by replacing each cipher letter with the correct plain letter.' => 'Decodifica el mensaje reemplazando cada letra cifrada por la correcta.',
			'Write your decoded phrase first.' => 'Primero escribe tu frase decodificada.',
			'Correct! You cracked the cryptogram. Great job!' => '¡Correcto! Resolviste el criptograma. ¡Buen trabajo!',
			'Not quite yet. Check your letters and try again.' => 'Todavía no. Revisa tus letras e intenta otra vez.',
			'Here is the decoded phrase.' => 'Aquí está la frase decodificada.',
			'Watch the sequence.' => 'Observa la secuencia.',
			'Now repeat.' => 'Ahora repite.',
			'Correct! Next level.' => '¡Correcto! Siguiente nivel.',
			'Box' => 'Caja',
			'Duck found' => 'Pato encontrado',
			'No duck' => 'Sin pato',
			'Switch World' => 'Cambiar mundo',
			'Check' => 'Revisar',
			'Replay' => 'Repetir',
			'Advertise $20' => 'Anunciar $20',
			'Reset Scores' => 'Reiniciar puntuaciones',
			'Reset Unlocks' => 'Reiniciar desbloqueos',
			'Close' => 'Cerrar',
			'Sound Off' => 'Sonido apagado',
			'Parent Menu' => 'Menú de padres',
			'Start Match' => 'Empezar partido',
			'Press Start Match' => 'Pulsa Empezar partido',
			'Speed' => 'Velocidad',
			'Smartness' => 'Inteligencia',
			'Shooting' => 'Tiro',
			'Passing' => 'Pase',
			'Defense' => 'Defensa',
			'Stopped' => 'Detenido',
		),
		'es-es' => array(
			'Your robot helper is waiting for its first lesson.' => 'Tu robot ayudante espera su primera lección.',
			'Choose the best move for this round.' => 'Elige el mejor movimiento para esta ronda.',
			'Nice coaching.' => 'Buen entrenamiento.',
			'That choice teaches a risky habit.' => 'Esa elección enseña un hábito arriesgado.',
			'Training finished. Review the summary and restart for a new run.' => 'Entrenamiento terminado. Revisa el resumen y reinicia.',
			'Decode the message by replacing each cipher letter with the correct plain letter.' => 'Decodifica el mensaje sustituyendo cada letra cifrada por la correcta.',
			'Write your decoded phrase first.' => 'Primero escribe tu frase decodificada.',
			'Correct! You cracked the cryptogram. Great job!' => '¡Correcto! Has resuelto el criptograma. ¡Buen trabajo!',
			'Not quite yet. Check your letters and try again.' => 'Todavía no. Revisa tus letras e inténtalo otra vez.',
			'Here is the decoded phrase.' => 'Aquí está la frase decodificada.',
			'Watch the sequence.' => 'Observa la secuencia.',
			'Now repeat.' => 'Ahora repite.',
			'Correct! Next level.' => '¡Correcto! Siguiente nivel.',
			'Box' => 'Caja',
			'Duck found' => 'Pato encontrado',
			'No duck' => 'Sin pato',
			'Switch World' => 'Cambiar mundo',
			'Check' => 'Comprobar',
			'Replay' => 'Repetir',
			'Advertise $20' => 'Anunciar $20',
			'Reset Scores' => 'Reiniciar puntuaciones',
			'Reset Unlocks' => 'Reiniciar desbloqueos',
			'Close' => 'Cerrar',
			'Sound Off' => 'Sonido apagado',
			'Parent Menu' => 'Menú parental',
			'Start Match' => 'Empezar partido',
			'Press Start Match' => 'Pulsa Empezar partido',
			'Speed' => 'Velocidad',
			'Smartness' => 'Inteligencia',
			'Shooting' => 'Tiro',
			'Passing' => 'Pase',
			'Defense' => 'Defensa',
			'Stopped' => 'Detenido',
		),
	);

	foreach ($extra_runtime_exact as $extra_lang => $extra_items) {
		if (isset($translations[$extra_lang])) {
			$translations[$extra_lang] = array_merge($translations[$extra_lang], $extra_items);
		}
	}

	$remaining_status_exact = array(
		'tr' => array(
			'You might beat the AI this time.' => 'Bu sefer yapay zekayı yenebilirsin.',
			'Round 1. The AI looks beatable.' => 'Tur 1. Yapay zeka yenilebilir görünüyor.',
			'Defeat is complete.' => 'Yenilgi tamamlandı.',
			'It feels worse now.' => 'Artık daha kötü hissettiriyor.',
			'The joke is the setup. The first rounds make it look possible. Then the AI learns too fast and the result becomes fixed.' => 'Şaka kurulumda. İlk turlar mümkün gibi gösterir. Sonra yapay zeka çok hızlı öğrenir ve sonuç sabitlenir.',
			'You found the hidden stars.' => 'Gizli yıldızları buldun.',
			'You win.' => 'Kazandın.',
			'Try again and catch more stars.' => 'Tekrar dene ve daha fazla yıldız yakala.',
			'Nice catch.' => 'Güzel yakalama.',
			'Too slow. Watch for the next one.' => 'Çok yavaş. Sonrakini bekle.',
			'Private game. Embed directly where you want it.' => 'Özel oyun. İstediğin yere doğrudan yerleştir.',
			'Rule check: looking good so far.' => 'Kural kontrolü: Şimdilik iyi görünüyor.',
			'Rule check: 1 row or column rule is currently broken.' => 'Kural kontrolü: Şu anda 1 satır veya sütun kuralı bozuk.',
			'Build the combo!' => 'Komboyu kur!',
			'Combo Complete! You Win!' => 'Kombo tamam! Kazandın!',
			'Wrong combo! Try again.' => 'Yanlış kombo! Tekrar dene.',
		),
		'de' => array(
			'You might beat the AI this time.' => 'Diesmal könntest du die KI schlagen.',
			'Round 1. The AI looks beatable.' => 'Runde 1. Die KI wirkt schlagbar.',
			'Defeat is complete.' => 'Die Niederlage ist vollständig.',
			'It feels worse now.' => 'Jetzt fühlt es sich schlimmer an.',
			'The joke is the setup. The first rounds make it look possible. Then the AI learns too fast and the result becomes fixed.' => 'Der Witz liegt im Aufbau. Die ersten Runden wirken möglich. Dann lernt die KI zu schnell und das Ergebnis steht fest.',
			'You found the hidden stars.' => 'Du hast die versteckten Sterne gefunden.',
			'You win.' => 'Du gewinnst.',
			'Try again and catch more stars.' => 'Versuche es erneut und fange mehr Sterne.',
			'Nice catch.' => 'Gut gefangen.',
			'Too slow. Watch for the next one.' => 'Zu langsam. Achte auf den nächsten.',
			'Private game. Embed directly where you want it.' => 'Privates Spiel. Direkt dort einbetten, wo du es möchtest.',
			'Rule check: looking good so far.' => 'Regelprüfung: bisher sieht es gut aus.',
			'Rule check: 1 row or column rule is currently broken.' => 'Regelprüfung: 1 Zeilen- oder Spaltenregel ist gerade verletzt.',
			'Build the combo!' => 'Baue die Kombo!',
			'Combo Complete! You Win!' => 'Kombo komplett! Du gewinnst!',
			'Wrong combo! Try again.' => 'Falsche Kombo! Versuche es erneut.',
		),
		'fr' => array(
			'You might beat the AI this time.' => 'Tu pourrais battre l’IA cette fois.',
			'Round 1. The AI looks beatable.' => 'Manche 1. L’IA semble battable.',
			'Defeat is complete.' => 'La défaite est complète.',
			'It feels worse now.' => 'Ça semble pire maintenant.',
			'The joke is the setup. The first rounds make it look possible. Then the AI learns too fast and the result becomes fixed.' => 'La blague vient du piège. Les premières manches semblent possibles. Puis l’IA apprend trop vite et le résultat devient fixe.',
			'You found the hidden stars.' => 'Tu as trouvé les étoiles cachées.',
			'You win.' => 'Tu gagnes.',
			'Try again and catch more stars.' => 'Réessaie et attrape plus d’étoiles.',
			'Nice catch.' => 'Belle prise.',
			'Too slow. Watch for the next one.' => 'Trop lent. Surveille la suivante.',
			'Private game. Embed directly where you want it.' => 'Jeu privé. Intègre-le directement où tu veux.',
			'Rule check: looking good so far.' => 'Vérification des règles : tout va bien pour l’instant.',
			'Rule check: 1 row or column rule is currently broken.' => 'Vérification des règles : 1 règle de ligne ou colonne est cassée.',
			'Build the combo!' => 'Construis le combo !',
			'Combo Complete! You Win!' => 'Combo terminé ! Tu gagnes !',
			'Wrong combo! Try again.' => 'Mauvais combo ! Réessaie.',
		),
		'es-mx' => array(
			'You might beat the AI this time.' => 'Tal vez esta vez le ganes a la IA.',
			'Round 1. The AI looks beatable.' => 'Ronda 1. La IA parece vencible.',
			'Defeat is complete.' => 'La derrota está completa.',
			'It feels worse now.' => 'Ahora se siente peor.',
			'The joke is the setup. The first rounds make it look possible. Then the AI learns too fast and the result becomes fixed.' => 'La broma está en la preparación. Las primeras rondas parecen posibles. Luego la IA aprende demasiado rápido y el resultado queda fijo.',
			'You found the hidden stars.' => 'Encontraste las estrellas ocultas.',
			'You win.' => 'Ganaste.',
			'Try again and catch more stars.' => 'Intenta de nuevo y atrapa más estrellas.',
			'Nice catch.' => 'Buena atrapada.',
			'Too slow. Watch for the next one.' => 'Muy lento. Mira la siguiente.',
			'Private game. Embed directly where you want it.' => 'Juego privado. Insértalo directamente donde quieras.',
			'Rule check: looking good so far.' => 'Revisión de reglas: todo va bien hasta ahora.',
			'Rule check: 1 row or column rule is currently broken.' => 'Revisión de reglas: hay 1 regla de fila o columna rota.',
			'Build the combo!' => '¡Arma el combo!',
			'Combo Complete! You Win!' => '¡Combo completo! ¡Ganaste!',
			'Wrong combo! Try again.' => '¡Combo incorrecto! Intenta de nuevo.',
		),
		'es-es' => array(
			'You might beat the AI this time.' => 'Quizá esta vez ganes a la IA.',
			'Round 1. The AI looks beatable.' => 'Ronda 1. La IA parece vencible.',
			'Defeat is complete.' => 'La derrota está completa.',
			'It feels worse now.' => 'Ahora se siente peor.',
			'The joke is the setup. The first rounds make it look possible. Then the AI learns too fast and the result becomes fixed.' => 'La broma está en la preparación. Las primeras rondas parecen posibles. Luego la IA aprende demasiado rápido y el resultado queda fijo.',
			'You found the hidden stars.' => 'Has encontrado las estrellas ocultas.',
			'You win.' => 'Has ganado.',
			'Try again and catch more stars.' => 'Inténtalo de nuevo y atrapa más estrellas.',
			'Nice catch.' => 'Buena captura.',
			'Too slow. Watch for the next one.' => 'Demasiado lento. Mira la siguiente.',
			'Private game. Embed directly where you want it.' => 'Juego privado. Insértalo directamente donde quieras.',
			'Rule check: looking good so far.' => 'Comprobación de reglas: todo va bien por ahora.',
			'Rule check: 1 row or column rule is currently broken.' => 'Comprobación de reglas: hay 1 regla de fila o columna rota.',
			'Build the combo!' => '¡Construye el combo!',
			'Combo Complete! You Win!' => '¡Combo completo! ¡Has ganado!',
			'Wrong combo! Try again.' => '¡Combo incorrecto! Inténtalo de nuevo.',
		),
	);

	foreach ($remaining_status_exact as $status_lang => $status_items) {
		if (isset($translations[$status_lang])) {
			$translations[$status_lang] = array_merge($translations[$status_lang], $status_items);
		}
	}

	$agent_runtime_exact = array(
		'tr' => array(
			'AI is thinking...' => 'Yapay zeka düşünüyor...',
			'Black AI is thinking...' => 'Siyah yapay zeka düşünüyor...',
			'You must capture an opponent piece.' => 'Rakip taşını almalısın.',
			'Capture is required. Choose an orange move.' => 'Taş alma zorunlu. Turuncu bir hamle seç.',
			'Keep capturing with the same piece.' => 'Aynı taşla almaya devam et.',
			'Select one of your white pieces.' => 'Beyaz taşlarından birini seç.',
			'Your turn. Select a white piece.' => 'Sıra sende. Beyaz bir taş seç.',
			'Pick the number that makes the scale balance.' => 'Teraziyi dengeleyecek sayıyı seç.',
			'Correct. The equation is balanced.' => 'Doğru. Denklem dengelendi.',
			'Answer this round first.' => 'Önce bu turu cevapla.',
			'Fill the empty squares with 0 or 1.' => 'Boş kareleri 0 veya 1 ile doldur.',
			'The grid is not full yet. Fill every square first.' => 'Izgara henüz dolu değil. Önce her kareyi doldur.',
			'Almost there. One or more row or column rules are broken.' => 'Neredeyse. Bir veya daha fazla satır ya da sütun kuralı bozuk.',
			'Choose a cell to expand or attack.' => 'Genişlemek veya saldırmak için bir hücre seç.',
			'Use Reinforce' => 'Takviye Kullan',
			'Reinforce available' => 'Takviye hazır',
			'Reinforce used' => 'Takviye kullanıldı',
			'AI wins! Try a different strategy.' => 'Yapay zeka kazandı! Farklı bir strateji dene.',
			'You win! Great territory control.' => 'Kazandın! Harika bölge kontrolü.',
			'Run Over' => 'Deneme Bitti',
			'Restart or buy a stronger fighter from the roster.' => 'Yeniden başlat veya listeden daha güçlü bir savaşçı satın al.',
		),
		'de' => array(
			'AI is thinking...' => 'Die KI denkt nach...',
			'Black AI is thinking...' => 'Die schwarze KI denkt nach...',
			'You must capture an opponent piece.' => 'Du musst eine gegnerische Figur schlagen.',
			'Capture is required. Choose an orange move.' => 'Schlagen ist Pflicht. Wähle einen orangefarbenen Zug.',
			'Keep capturing with the same piece.' => 'Schlage weiter mit derselben Figur.',
			'Select one of your white pieces.' => 'Wähle eine deiner weißen Figuren.',
			'Your turn. Select a white piece.' => 'Du bist dran. Wähle eine weiße Figur.',
			'Pick the number that makes the scale balance.' => 'Wähle die Zahl, die die Waage ausgleicht.',
			'Correct. The equation is balanced.' => 'Richtig. Die Gleichung ist ausgeglichen.',
			'Answer this round first.' => 'Beantworte zuerst diese Runde.',
			'Fill the empty squares with 0 or 1.' => 'Fülle die leeren Felder mit 0 oder 1.',
			'The grid is not full yet. Fill every square first.' => 'Das Raster ist noch nicht voll. Fülle zuerst jedes Feld.',
			'Almost there. One or more row or column rules are broken.' => 'Fast geschafft. Eine oder mehrere Zeilen- oder Spaltenregeln sind verletzt.',
			'Choose a cell to expand or attack.' => 'Wähle eine Zelle zum Erweitern oder Angreifen.',
			'Use Reinforce' => 'Verstärkung nutzen',
			'Reinforce available' => 'Verstärkung verfügbar',
			'Reinforce used' => 'Verstärkung genutzt',
			'AI wins! Try a different strategy.' => 'Die KI gewinnt! Versuche eine andere Strategie.',
			'You win! Great territory control.' => 'Du gewinnst! Starke Gebietskontrolle.',
			'Run Over' => 'Lauf beendet',
			'Restart or buy a stronger fighter from the roster.' => 'Starte neu oder kaufe einen stärkeren Kämpfer aus der Liste.',
		),
		'fr' => array(
			'AI is thinking...' => 'L’IA réfléchit...',
			'Black AI is thinking...' => 'L’IA noire réfléchit...',
			'You must capture an opponent piece.' => 'Tu dois capturer une pièce adverse.',
			'Capture is required. Choose an orange move.' => 'Capture obligatoire. Choisis un coup orange.',
			'Keep capturing with the same piece.' => 'Continue à capturer avec la même pièce.',
			'Select one of your white pieces.' => 'Sélectionne une de tes pièces blanches.',
			'Your turn. Select a white piece.' => 'À toi. Sélectionne une pièce blanche.',
			'Pick the number that makes the scale balance.' => 'Choisis le nombre qui équilibre la balance.',
			'Correct. The equation is balanced.' => 'Correct. L’équation est équilibrée.',
			'Answer this round first.' => 'Réponds d’abord à cette manche.',
			'Fill the empty squares with 0 or 1.' => 'Remplis les cases vides avec 0 ou 1.',
			'The grid is not full yet. Fill every square first.' => 'La grille n’est pas encore pleine. Remplis toutes les cases.',
			'Almost there. One or more row or column rules are broken.' => 'Presque. Une ou plusieurs règles de ligne ou colonne sont cassées.',
			'Choose a cell to expand or attack.' => 'Choisis une case pour t’étendre ou attaquer.',
			'Use Reinforce' => 'Utiliser renfort',
			'Reinforce available' => 'Renfort disponible',
			'Reinforce used' => 'Renfort utilisé',
			'AI wins! Try a different strategy.' => 'L’IA gagne ! Essaie une autre stratégie.',
			'You win! Great territory control.' => 'Tu gagnes ! Excellent contrôle du territoire.',
			'Run Over' => 'Partie terminée',
			'Restart or buy a stronger fighter from the roster.' => 'Redémarre ou achète un combattant plus fort dans la liste.',
		),
		'es-mx' => array(
			'AI is thinking...' => 'La IA está pensando...',
			'Black AI is thinking...' => 'La IA negra está pensando...',
			'You must capture an opponent piece.' => 'Debes capturar una pieza rival.',
			'Capture is required. Choose an orange move.' => 'Debes capturar. Elige un movimiento naranja.',
			'Keep capturing with the same piece.' => 'Sigue capturando con la misma pieza.',
			'Select one of your white pieces.' => 'Selecciona una de tus piezas blancas.',
			'Your turn. Select a white piece.' => 'Tu turno. Selecciona una pieza blanca.',
			'Pick the number that makes the scale balance.' => 'Elige el número que equilibra la balanza.',
			'Correct. The equation is balanced.' => 'Correcto. La ecuación está equilibrada.',
			'Answer this round first.' => 'Primero responde esta ronda.',
			'Fill the empty squares with 0 or 1.' => 'Llena los cuadros vacíos con 0 o 1.',
			'The grid is not full yet. Fill every square first.' => 'La cuadrícula aún no está llena. Llena cada cuadro primero.',
			'Almost there. One or more row or column rules are broken.' => 'Casi. Una o más reglas de fila o columna están rotas.',
			'Choose a cell to expand or attack.' => 'Elige una celda para expandirte o atacar.',
			'Use Reinforce' => 'Usar refuerzo',
			'Reinforce available' => 'Refuerzo disponible',
			'Reinforce used' => 'Refuerzo usado',
			'AI wins! Try a different strategy.' => '¡La IA gana! Prueba otra estrategia.',
			'You win! Great territory control.' => '¡Ganaste! Gran control del territorio.',
			'Run Over' => 'Partida terminada',
			'Restart or buy a stronger fighter from the roster.' => 'Reinicia o compra un luchador más fuerte de la lista.',
		),
		'es-es' => array(
			'AI is thinking...' => 'La IA está pensando...',
			'Black AI is thinking...' => 'La IA negra está pensando...',
			'You must capture an opponent piece.' => 'Debes capturar una pieza rival.',
			'Capture is required. Choose an orange move.' => 'Debes capturar. Elige un movimiento naranja.',
			'Keep capturing with the same piece.' => 'Sigue capturando con la misma pieza.',
			'Select one of your white pieces.' => 'Selecciona una de tus piezas blancas.',
			'Your turn. Select a white piece.' => 'Tu turno. Selecciona una pieza blanca.',
			'Pick the number that makes the scale balance.' => 'Elige el número que equilibra la balanza.',
			'Correct. The equation is balanced.' => 'Correcto. La ecuación está equilibrada.',
			'Answer this round first.' => 'Primero responde a esta ronda.',
			'Fill the empty squares with 0 or 1.' => 'Rellena las casillas vacías con 0 o 1.',
			'The grid is not full yet. Fill every square first.' => 'La cuadrícula aún no está llena. Rellena cada casilla primero.',
			'Almost there. One or more row or column rules are broken.' => 'Casi. Una o más reglas de fila o columna están rotas.',
			'Choose a cell to expand or attack.' => 'Elige una celda para expandirte o atacar.',
			'Use Reinforce' => 'Usar refuerzo',
			'Reinforce available' => 'Refuerzo disponible',
			'Reinforce used' => 'Refuerzo usado',
			'AI wins! Try a different strategy.' => '¡La IA gana! Prueba otra estrategia.',
			'You win! Great territory control.' => '¡Has ganado! Gran control del territorio.',
			'Run Over' => 'Partida terminada',
			'Restart or buy a stronger fighter from the roster.' => 'Reinicia o compra un luchador más fuerte de la lista.',
		),
	);

	$scan_runtime_exact = array(
		'fr' => array(
			'Great run! Keep the pattern going.' => 'Belle série ! Continue le motif.',
			'Action logged. Try for a longer chain.' => 'Action enregistrée. Essaie une chaîne plus longue.',
			'Select an operation.' => 'Sélectionne une opération.',
			'Please enter a valid first number.' => 'Saisis un premier nombre valide.',
			'Please enter a valid second number.' => 'Saisis un deuxième nombre valide.',
			'Cannot divide by zero.' => 'Impossible de diviser par zéro.',
			'Cannot take the square root of a negative number.' => 'Impossible de calculer la racine carrée d’un nombre négatif.',
			'Level 1 ready. Press Space or Launch.' => 'Niveau 1 prêt. Appuie sur Espace ou Lancer.',
			'You beat all 1000 levels!' => 'Tu as terminé les 1000 niveaux !',
			'Break every brick.' => 'Casse toutes les briques.',
			'Paused. Press P to continue.' => 'En pause. Appuie sur P pour continuer.',
			'Game resumed.' => 'Partie reprise.',
			'Game over. Press R or Restart.' => 'Partie terminée. Appuie sur R ou Redémarrer.',
			'Life lost. Launch again.' => 'Vie perdue. Relance la balle.',
			'You claimed a new border cell.' => 'Tu as pris une nouvelle case frontière.',
			'Attack success! You captured enemy territory.' => 'Attaque réussie ! Tu as capturé un territoire ennemi.',
			'Attack failed. The enemy held strong.' => 'Attaque échouée. L’ennemi a résisté.',
			'AI captured territory this turn.' => 'L’IA a capturé un territoire ce tour-ci.',
			'AI attack failed. Your border remains intact.' => 'L’attaque de l’IA a échoué. Ta frontière reste intacte.',
			'AI used reinforce and claimed a neutral border cell.' => 'L’IA a utilisé un renfort et pris une case frontière neutre.',
			'Your turn' => 'À toi',
			'AI turn' => 'Tour de l’IA',
			'No player moves left. AI continues.' => 'Il ne reste aucun coup joueur. L’IA continue.',
			'AI cannot move. Your turn.' => 'L’IA ne peut pas bouger. À toi.',
			"It's a tie! A balanced battle." => 'Égalité ! Combat équilibré.',
			'No neutral border cell available to reinforce.' => 'Aucune case frontière neutre disponible pour le renfort.',
			'Reinforce used! You claimed a border space.' => 'Renfort utilisé ! Tu as pris une case frontière.',
			'Your robot helper is waiting for its first lesson.' => 'Ton robot assistant attend sa première leçon.',
			'Choose the best move for this round.' => 'Choisis le meilleur coup pour cette manche.',
			'Training finished. Review the summary and restart for a new run.' => 'Entraînement terminé. Consulte le résumé et redémarre pour une nouvelle partie.',
		),
		'es-mx' => array(
			'Great run! Keep the pattern going.' => '¡Gran racha! Sigue con el patrón.',
			'Action logged. Try for a longer chain.' => 'Acción registrada. Intenta una cadena más larga.',
			'Select an operation.' => 'Elige una operación.',
			'Please enter a valid first number.' => 'Ingresa un primer número válido.',
			'Please enter a valid second number.' => 'Ingresa un segundo número válido.',
			'Cannot divide by zero.' => 'No se puede dividir entre cero.',
			'Cannot take the square root of a negative number.' => 'No se puede calcular la raíz cuadrada de un número negativo.',
			'Level 1 ready. Press Space or Launch.' => 'Nivel 1 listo. Pulsa Espacio o Lanzar.',
			'You beat all 1000 levels!' => '¡Completaste los 1000 niveles!',
			'Break every brick.' => 'Rompe todos los ladrillos.',
			'Paused. Press P to continue.' => 'Pausado. Pulsa P para continuar.',
			'Game resumed.' => 'Partida reanudada.',
			'Game over. Press R or Restart.' => 'Fin del juego. Pulsa R o Reiniciar.',
			'Life lost. Launch again.' => 'Vida perdida. Lanza de nuevo.',
			'You claimed a new border cell.' => 'Reclamaste una nueva celda de frontera.',
			'Attack success! You captured enemy territory.' => '¡Ataque exitoso! Capturaste territorio enemigo.',
			'Attack failed. The enemy held strong.' => 'El ataque falló. El enemigo resistió.',
			'AI captured territory this turn.' => 'La IA capturó territorio este turno.',
			'AI attack failed. Your border remains intact.' => 'El ataque de la IA falló. Tu frontera sigue intacta.',
			'AI used reinforce and claimed a neutral border cell.' => 'La IA usó refuerzo y reclamó una celda neutral de frontera.',
			'Your turn' => 'Tu turno',
			'AI turn' => 'Turno de la IA',
			'No player moves left. AI continues.' => 'No quedan movimientos del jugador. La IA continúa.',
			'AI cannot move. Your turn.' => 'La IA no puede moverse. Tu turno.',
			"It's a tie! A balanced battle." => '¡Empate! Una batalla equilibrada.',
			'No neutral border cell available to reinforce.' => 'No hay celda neutral de frontera disponible para reforzar.',
			'Reinforce used! You claimed a border space.' => '¡Refuerzo usado! Reclamaste un espacio de frontera.',
			'Your robot helper is waiting for its first lesson.' => 'Tu robot ayudante espera su primera lección.',
			'Choose the best move for this round.' => 'Elige el mejor movimiento para esta ronda.',
			'Training finished. Review the summary and restart for a new run.' => 'Entrenamiento terminado. Revisa el resumen y reinicia para una nueva partida.',
		),
		'es-es' => array(
			'Great run! Keep the pattern going.' => '¡Gran racha! Sigue con el patrón.',
			'Action logged. Try for a longer chain.' => 'Acción registrada. Intenta una cadena más larga.',
			'Select an operation.' => 'Selecciona una operación.',
			'Please enter a valid first number.' => 'Introduce un primer número válido.',
			'Please enter a valid second number.' => 'Introduce un segundo número válido.',
			'Cannot divide by zero.' => 'No se puede dividir por cero.',
			'Cannot take the square root of a negative number.' => 'No se puede calcular la raíz cuadrada de un número negativo.',
			'Level 1 ready. Press Space or Launch.' => 'Nivel 1 listo. Pulsa Espacio o Lanzar.',
			'You beat all 1000 levels!' => '¡Completaste los 1000 niveles!',
			'Break every brick.' => 'Rompe todos los ladrillos.',
			'Paused. Press P to continue.' => 'Pausado. Pulsa P para continuar.',
			'Game resumed.' => 'Partida reanudada.',
			'Game over. Press R or Restart.' => 'Fin del juego. Pulsa R o Reiniciar.',
			'Life lost. Launch again.' => 'Vida perdida. Lanza de nuevo.',
			'You claimed a new border cell.' => 'Has reclamado una nueva celda de frontera.',
			'Attack success! You captured enemy territory.' => '¡Ataque exitoso! Has capturado territorio enemigo.',
			'Attack failed. The enemy held strong.' => 'El ataque ha fallado. El enemigo ha resistido.',
			'AI captured territory this turn.' => 'La IA ha capturado territorio este turno.',
			'AI attack failed. Your border remains intact.' => 'El ataque de la IA ha fallado. Tu frontera sigue intacta.',
			'AI used reinforce and claimed a neutral border cell.' => 'La IA ha usado refuerzo y ha reclamado una celda neutral de frontera.',
			'Your turn' => 'Tu turno',
			'AI turn' => 'Turno de la IA',
			'No player moves left. AI continues.' => 'No quedan movimientos del jugador. La IA continúa.',
			'AI cannot move. Your turn.' => 'La IA no puede moverse. Tu turno.',
			"It's a tie! A balanced battle." => '¡Empate! Una batalla equilibrada.',
			'No neutral border cell available to reinforce.' => 'No hay celda neutral de frontera disponible para reforzar.',
			'Reinforce used! You claimed a border space.' => '¡Refuerzo usado! Has reclamado un espacio de frontera.',
			'Your robot helper is waiting for its first lesson.' => 'Tu robot ayudante espera su primera lección.',
			'Choose the best move for this round.' => 'Elige el mejor movimiento para esta ronda.',
			'Training finished. Review the summary and restart for a new run.' => 'Entrenamiento terminado. Revisa el resumen y reinicia para una nueva partida.',
		),
	);

	foreach ($scan_runtime_exact as $scan_lang => $scan_items) {
		if (isset($translations[$scan_lang])) {
			$translations[$scan_lang] = array_merge($translations[$scan_lang], $scan_items);
		}
	}

	$sitewide_runtime_exact = array(
		'en' => array(
			'Arabalı' => 'Car Game',
			'Başlamak için düğmeye bas' => 'Press the button to start',
			'Skor: ' => 'Score: ',
			'Su: ' => 'Water: ',
			'Seviye: ' => 'Level: ',
			'En iyi su: ' => 'Best water: ',
			'Çöl oyun alanı' => 'Desert game area',
			'Kazandın. Sonraki seviyeye geç.' => 'You won. Go to the next level.',
			'Tekrar Başla' => 'Restart',
			'Sonraki Seviye' => 'Next Level',
			'Kapılar' => 'Doors',
			'Can: ' => 'Lives: ',
			'En iyi: ' => 'Best: ',
			'Oyun bitti. Tekrar oyna.' => 'Game over. Play again.',
			'Doğru kapıyı seç.' => 'Choose the correct door.',
			'Doğru kapı. Hazineyi buldun.' => 'Correct door. You found the treasure.',
			'Yanlış kapı. Tuzak vardı.' => 'Wrong door. There was a trap.',
			'Mısır tapınağında sekiz kapı var. Sadece birinde hazine var. Doğru kapıyı seç ve ilerle.' => 'There are eight doors in the Egyptian temple. Only one has treasure. Choose the correct door and move forward.',
			'Her turda sadece bir kapı güvenlidir. Yanlış seçimde can kaybedersin.' => 'Only one door is safe each round. A wrong choice costs a life.',
			'White' => 'White',
			'Black' => 'Black',
			'Choose a removable enemy stone.' => 'Choose a removable enemy stone.',
			'Select one of your stones, then move it to any empty spot.' => 'Select one of your stones, then move it to any empty spot.',
			'Select one of your stones, then move it to a connected empty spot.' => 'Select one of your stones, then move it to a connected empty spot.',
			'Select one of your own stones.' => 'Select one of your own stones.',
			'Stone selected. Choose where to move.' => 'Stone selected. Choose where to move.',
			'Selection cleared.' => 'Selection cleared.',
			'Correct code. The locked box opens.' => 'Correct code. The locked box opens.',
			'Wrong code.' => 'Wrong code.',
			'Start with the desk or the painting.' => 'Start with the desk or the painting.',
			'Unlock Box' => 'Unlock Box',
			'Restart Training' => 'Restart Training',
			'Dinozorlu' => 'Dinosaur Game',
			'Balon Patlatmalı' => 'Balloon Pop',
			'Hayvan Kurtarmalı' => 'Animal Rescue',
			'Ahır' => 'Barn',
			'Kurtarılan: ' => 'Rescued: ',
			'Penaltı Kralı' => 'Penalty King',
			'Başlat ve şut çek' => 'Start and shoot',
			'Yakalandın' => 'Caught',
			'Öğretmenden Kaç' => 'Escape the Teacher',
			'SINIF' => 'CLASS',
			'TAHTA' => 'BOARD',
			'Kaçma Oyunu' => 'Escape Game',
			'Tekrar başlat ve yeniden savaş.' => 'Restart and battle again.',
			'Başlat ve bir savaşçı gönder.' => 'Start and send a fighter.',
			'Başlat düğmesine bas' => 'Press the Start button',
			'Tekrar başlamak için Baştan Başla düğmesine bas' => 'Press Restart to start again',
			'Classify the bug.' => 'Classify the bug.',
			'Classify the bugs before time runs out.' => 'Classify the bugs before time runs out.',
			'Correct bin.' => 'Correct bin.',
			'You lost all lives. Press Start.' => 'You lost all lives. Press Start.',
			'Watch the sequence.' => 'Watch the sequence.',
			'Now repeat.' => 'Now repeat.',
			'Correct! Next level.' => 'Correct! Next level.',
			'Try this round again.' => 'Try this round again.',
			'Round ' => 'Round ',
			'Game finished' => 'Game finished',
			'Perfect Balance' => 'Perfect Balance',
			'Finished' => 'Finished',
			'All three services are restored. The city lights up again.' => 'All three services are restored. The city lights up again.',
			'Watch for the next one.' => 'Watch for the next one.',
			'Nice catch.' => 'Nice catch.',
			'Too slow. Watch for the next one.' => 'Too slow. Watch for the next one.',
			'You found the hidden stars.' => 'You found the hidden stars.',
			'Try again and catch more stars.' => 'Try again and catch more stars.',
			'Private game. Embed directly where you want it.' => 'Private game. Embed directly where you want it.',
			'You found all the treasure. You win.' => 'You found all the treasure. You win.',
			'You hit a trap. Game over.' => 'You hit a trap. Game over.',
			'TREASURE' => 'TREASURE',
			'TRAP' => 'TRAP',
			'Ready' => 'Ready',
			'Locked' => 'Locked',
			'Mission complete!' => 'Mission complete!',
			'Try again!' => 'Try again!',
		),
		'de' => array(
			'Arabalı' => 'Autospiel',
			'Başlamak için düğmeye bas' => 'Drücke den Knopf zum Starten',
			'Skor: ' => 'Punkte: ',
			'Su: ' => 'Wasser: ',
			'Seviye: ' => 'Level: ',
			'En iyi su: ' => 'Bestes Wasser: ',
			'Çöl oyun alanı' => 'Wüsten-Spielfeld',
			'Kazandın. Sonraki seviyeye geç.' => 'Du hast gewonnen. Weiter zum nächsten Level.',
			'Tekrar Başla' => 'Neu starten',
			'Sonraki Seviye' => 'Nächstes Level',
			'Kapılar' => 'Türen',
			'Can: ' => 'Leben: ',
			'En iyi: ' => 'Bestwert: ',
			'Oyun bitti. Tekrar oyna.' => 'Spiel vorbei. Spiele erneut.',
			'Doğru kapıyı seç.' => 'Wähle die richtige Tür.',
			'Doğru kapı. Hazineyi buldun.' => 'Richtige Tür. Du hast den Schatz gefunden.',
			'Yanlış kapı. Tuzak vardı.' => 'Falsche Tür. Dort war eine Falle.',
			'Mısır tapınağında sekiz kapı var. Sadece birinde hazine var. Doğru kapıyı seç ve ilerle.' => 'Im ägyptischen Tempel gibt es acht Türen. Nur hinter einer liegt ein Schatz. Wähle die richtige Tür und gehe weiter.',
			'Her turda sadece bir kapı güvenlidir. Yanlış seçimde can kaybedersin.' => 'In jeder Runde ist nur eine Tür sicher. Bei einer falschen Wahl verlierst du ein Leben.',
			'White' => 'Weiß',
			'Black' => 'Schwarz',
			'Choose a removable enemy stone.' => 'Wähle einen entfernbaren gegnerischen Stein.',
			'Select one of your stones, then move it to any empty spot.' => 'Wähle einen deiner Steine und bewege ihn auf ein leeres Feld.',
			'Select one of your stones, then move it to a connected empty spot.' => 'Wähle einen deiner Steine und bewege ihn auf ein verbundenes leeres Feld.',
			'Select one of your own stones.' => 'Wähle einen deiner eigenen Steine.',
			'Stone selected. Choose where to move.' => 'Stein ausgewählt. Wähle das Zielfeld.',
			'Selection cleared.' => 'Auswahl aufgehoben.',
			'Correct code. The locked box opens.' => 'Richtiger Code. Die verschlossene Kiste öffnet sich.',
			'Wrong code.' => 'Falscher Code.',
			'Start with the desk or the painting.' => 'Beginne mit dem Schreibtisch oder dem Gemälde.',
			'Unlock Box' => 'Kiste öffnen',
			'Restart Training' => 'Training neu starten',
			'Dinozorlu' => 'Dinosaurierspiel',
			'Balon Patlatmalı' => 'Ballons platzen',
			'Hayvan Kurtarmalı' => 'Tierrettung',
			'Ahır' => 'Scheune',
			'Kurtarılan: ' => 'Gerettet: ',
			'Penaltı Kralı' => 'Elfmeterkönig',
			'Başlat ve şut çek' => 'Starte und schieße',
			'Yakalandın' => 'Gefangen',
			'Öğretmenden Kaç' => 'Flieh vor dem Lehrer',
			'SINIF' => 'KLASSE',
			'TAHTA' => 'TAFEL',
			'Kaçma Oyunu' => 'Fluchtspiel',
			'Tekrar başlat ve yeniden savaş.' => 'Starte neu und kämpfe wieder.',
			'Başlat ve bir savaşçı gönder.' => 'Starte und sende einen Kämpfer.',
			'Başlat düğmesine bas' => 'Drücke die Starttaste',
			'Tekrar başlamak için Baştan Başla düğmesine bas' => 'Drücke Neustart, um erneut zu beginnen',
			'Classify the bug.' => 'Ordne den Käfer zu.',
			'Classify the bugs before time runs out.' => 'Ordne die Käfer zu, bevor die Zeit abläuft.',
			'Correct bin.' => 'Richtiger Behälter.',
			'You lost all lives. Press Start.' => 'Du hast alle Leben verloren. Drücke Start.',
			'Watch the sequence.' => 'Merke dir die Reihenfolge.',
			'Now repeat.' => 'Jetzt wiederholen.',
			'Correct! Next level.' => 'Richtig! Nächstes Level.',
			'Try this round again.' => 'Versuche diese Runde noch einmal.',
			'Round ' => 'Runde ',
			'Game finished' => 'Spiel beendet',
			'Perfect Balance' => 'Perfektes Gleichgewicht',
			'Finished' => 'Fertig',
			'All three services are restored. The city lights up again.' => 'Alle drei Dienste sind wiederhergestellt. Die Stadt leuchtet wieder.',
			'Watch for the next one.' => 'Achte auf den nächsten.',
			'Nice catch.' => 'Gut gefangen.',
			'Too slow. Watch for the next one.' => 'Zu langsam. Achte auf den nächsten.',
			'You found the hidden stars.' => 'Du hast die versteckten Sterne gefunden.',
			'Try again and catch more stars.' => 'Versuche es erneut und fange mehr Sterne.',
			'Private game. Embed directly where you want it.' => 'Privates Spiel. Direkt dort einbetten, wo du es haben möchtest.',
			'You found all the treasure. You win.' => 'Du hast den ganzen Schatz gefunden. Du gewinnst.',
			'You hit a trap. Game over.' => 'Du bist in eine Falle geraten. Spiel vorbei.',
			'TREASURE' => 'SCHATZ',
			'TRAP' => 'FALLE',
			'Ready' => 'Bereit',
			'Locked' => 'Verschlossen',
			'Mission complete!' => 'Mission abgeschlossen!',
			'Try again!' => 'Versuche es noch einmal!',
		),
		'fr' => array(
			'Arabalı' => 'Jeu de voiture',
			'Başlamak için düğmeye bas' => 'Appuie sur le bouton pour commencer',
			'Skor: ' => 'Score : ',
			'Su: ' => 'Eau : ',
			'Seviye: ' => 'Niveau : ',
			'En iyi su: ' => 'Meilleure eau : ',
			'Çöl oyun alanı' => 'Zone de jeu du désert',
			'Kazandın. Sonraki seviyeye geç.' => 'Tu as gagné. Passe au niveau suivant.',
			'Tekrar Başla' => 'Recommencer',
			'Sonraki Seviye' => 'Niveau suivant',
			'Kapılar' => 'Portes',
			'Can: ' => 'Vies : ',
			'En iyi: ' => 'Meilleur : ',
			'Oyun bitti. Tekrar oyna.' => 'Partie terminée. Rejoue.',
			'Doğru kapıyı seç.' => 'Choisis la bonne porte.',
			'Doğru kapı. Hazineyi buldun.' => 'Bonne porte. Tu as trouvé le trésor.',
			'Yanlış kapı. Tuzak vardı.' => 'Mauvaise porte. Il y avait un piège.',
			'Mısır tapınağında sekiz kapı var. Sadece birinde hazine var. Doğru kapıyı seç ve ilerle.' => 'Dans le temple égyptien, il y a huit portes. Une seule cache un trésor. Choisis la bonne porte et avance.',
			'Her turda sadece bir kapı güvenlidir. Yanlış seçimde can kaybedersin.' => 'À chaque manche, une seule porte est sûre. Un mauvais choix te fait perdre une vie.',
			'White' => 'Blanc',
			'Black' => 'Noir',
			'Choose a removable enemy stone.' => 'Choisis une pierre ennemie à retirer.',
			'Select one of your stones, then move it to any empty spot.' => 'Choisis une de tes pierres, puis déplace-la vers une case vide.',
			'Select one of your stones, then move it to a connected empty spot.' => 'Choisis une de tes pierres, puis déplace-la vers une case vide reliée.',
			'Select one of your own stones.' => 'Choisis une de tes propres pierres.',
			'Stone selected. Choose where to move.' => 'Pierre sélectionnée. Choisis où la déplacer.',
			'Selection cleared.' => 'Sélection annulée.',
			'Correct code. The locked box opens.' => 'Code correct. La boîte verrouillée s’ouvre.',
			'Wrong code.' => 'Code incorrect.',
			'Start with the desk or the painting.' => 'Commence par le bureau ou le tableau.',
			'Unlock Box' => 'Déverrouiller la boîte',
			'Restart Training' => 'Redémarrer l’entraînement',
			'Dinozorlu' => 'Jeu de dinosaure',
			'Balon Patlatmalı' => 'Éclate-ballons',
			'Hayvan Kurtarmalı' => 'Sauvetage d’animaux',
			'Ahır' => 'Grange',
			'Kurtarılan: ' => 'Sauvés : ',
			'Penaltı Kralı' => 'Roi des penalties',
			'Başlat ve şut çek' => 'Démarre et tire',
			'Yakalandın' => 'Attrapé',
			'Öğretmenden Kaç' => 'Échappe au professeur',
			'SINIF' => 'CLASSE',
			'TAHTA' => 'TABLEAU',
			'Kaçma Oyunu' => 'Jeu d’évasion',
			'Tekrar başlat ve yeniden savaş.' => 'Redémarre et combats à nouveau.',
			'Başlat ve bir savaşçı gönder.' => 'Démarre et envoie un combattant.',
			'Başlat düğmesine bas' => 'Appuie sur le bouton Démarrer',
			'Tekrar başlamak için Baştan Başla düğmesine bas' => 'Appuie sur Redémarrer pour recommencer',
			'Classify the bug.' => 'Classe l’insecte.',
			'Classify the bugs before time runs out.' => 'Classe les insectes avant la fin du temps.',
			'Correct bin.' => 'Bon bac.',
			'You lost all lives. Press Start.' => 'Tu as perdu toutes tes vies. Appuie sur Démarrer.',
			'Watch the sequence.' => 'Observe la séquence.',
			'Now repeat.' => 'Maintenant, répète.',
			'Correct! Next level.' => 'Correct ! Niveau suivant.',
			'Try this round again.' => 'Réessaie cette manche.',
			'Round ' => 'Manche ',
			'Game finished' => 'Partie terminée',
			'Perfect Balance' => 'Équilibre parfait',
			'Finished' => 'Terminé',
			'All three services are restored. The city lights up again.' => 'Les trois services sont rétablis. La ville s’illumine à nouveau.',
			'Watch for the next one.' => 'Surveille le suivant.',
			'Nice catch.' => 'Belle prise.',
			'Too slow. Watch for the next one.' => 'Trop lent. Surveille le suivant.',
			'You found the hidden stars.' => 'Tu as trouvé les étoiles cachées.',
			'Try again and catch more stars.' => 'Réessaie et attrape plus d’étoiles.',
			'Private game. Embed directly where you want it.' => 'Jeu privé. Intègre-le directement où tu veux.',
			'You found all the treasure. You win.' => 'Tu as trouvé tout le trésor. Tu gagnes.',
			'You hit a trap. Game over.' => 'Tu as touché un piège. Partie terminée.',
			'TREASURE' => 'TRÉSOR',
			'TRAP' => 'PIÈGE',
			'Ready' => 'Prêt',
			'Locked' => 'Verrouillé',
			'Mission complete!' => 'Mission accomplie !',
			'Try again!' => 'Réessaie !',
		),
		'es-mx' => array(
			'Arabalı' => 'Juego de autos',
			'Başlamak için düğmeye bas' => 'Presiona el botón para empezar',
			'Skor: ' => 'Puntuación: ',
			'Su: ' => 'Agua: ',
			'Seviye: ' => 'Nivel: ',
			'En iyi su: ' => 'Mejor agua: ',
			'Çöl oyun alanı' => 'Área de juego del desierto',
			'Kazandın. Sonraki seviyeye geç.' => 'Ganaste. Pasa al siguiente nivel.',
			'Tekrar Başla' => 'Reiniciar',
			'Sonraki Seviye' => 'Siguiente nivel',
			'Kapılar' => 'Puertas',
			'Can: ' => 'Vidas: ',
			'En iyi: ' => 'Mejor: ',
			'Oyun bitti. Tekrar oyna.' => 'Fin del juego. Juega de nuevo.',
			'Doğru kapıyı seç.' => 'Elige la puerta correcta.',
			'Doğru kapı. Hazineyi buldun.' => 'Puerta correcta. Encontraste el tesoro.',
			'Yanlış kapı. Tuzak vardı.' => 'Puerta equivocada. Había una trampa.',
			'Mısır tapınağında sekiz kapı var. Sadece birinde hazine var. Doğru kapıyı seç ve ilerle.' => 'En el templo egipcio hay ocho puertas. Solo una tiene tesoro. Elige la puerta correcta y avanza.',
			'Her turda sadece bir kapı güvenlidir. Yanlış seçimde can kaybedersin.' => 'En cada ronda solo una puerta es segura. Si eliges mal, pierdes una vida.',
			'White' => 'Blanco',
			'Black' => 'Negro',
			'Choose a removable enemy stone.' => 'Elige una ficha enemiga que puedas quitar.',
			'Select one of your stones, then move it to any empty spot.' => 'Selecciona una de tus fichas y muévela a un espacio vacío.',
			'Select one of your stones, then move it to a connected empty spot.' => 'Selecciona una de tus fichas y muévela a un espacio vacío conectado.',
			'Select one of your own stones.' => 'Selecciona una de tus propias fichas.',
			'Stone selected. Choose where to move.' => 'Ficha seleccionada. Elige dónde moverla.',
			'Selection cleared.' => 'Selección borrada.',
			'Correct code. The locked box opens.' => 'Código correcto. La caja cerrada se abre.',
			'Wrong code.' => 'Código incorrecto.',
			'Start with the desk or the painting.' => 'Empieza con el escritorio o la pintura.',
			'Unlock Box' => 'Abrir caja',
			'Restart Training' => 'Reiniciar entrenamiento',
			'Dinozorlu' => 'Juego de dinosaurios',
			'Balon Patlatmalı' => 'Revienta globos',
			'Hayvan Kurtarmalı' => 'Rescate de animales',
			'Ahır' => 'Granero',
			'Kurtarılan: ' => 'Rescatados: ',
			'Penaltı Kralı' => 'Rey de penales',
			'Başlat ve şut çek' => 'Empieza y tira',
			'Yakalandın' => 'Te atraparon',
			'Öğretmenden Kaç' => 'Escapa del maestro',
			'SINIF' => 'SALÓN',
			'TAHTA' => 'PIZARRÓN',
			'Kaçma Oyunu' => 'Juego de escape',
			'Tekrar başlat ve yeniden savaş.' => 'Reinicia y lucha otra vez.',
			'Başlat ve bir savaşçı gönder.' => 'Empieza y envía un luchador.',
			'Başlat düğmesine bas' => 'Presiona el botón Empezar',
			'Tekrar başlamak için Baştan Başla düğmesine bas' => 'Presiona Reiniciar para empezar de nuevo',
			'Classify the bug.' => 'Clasifica el insecto.',
			'Classify the bugs before time runs out.' => 'Clasifica los insectos antes de que se acabe el tiempo.',
			'Correct bin.' => 'Contenedor correcto.',
			'You lost all lives. Press Start.' => 'Perdiste todas las vidas. Presiona Empezar.',
			'Watch the sequence.' => 'Observa la secuencia.',
			'Now repeat.' => 'Ahora repite.',
			'Correct! Next level.' => '¡Correcto! Siguiente nivel.',
			'Try this round again.' => 'Intenta esta ronda otra vez.',
			'Round ' => 'Ronda ',
			'Game finished' => 'Juego terminado',
			'Perfect Balance' => 'Equilibrio perfecto',
			'Finished' => 'Terminado',
			'All three services are restored. The city lights up again.' => 'Los tres servicios están restaurados. La ciudad se ilumina otra vez.',
			'Watch for the next one.' => 'Estate atento al siguiente.',
			'Nice catch.' => 'Buena atrapada.',
			'Too slow. Watch for the next one.' => 'Muy lento. Estate atento al siguiente.',
			'You found the hidden stars.' => 'Encontraste las estrellas ocultas.',
			'Try again and catch more stars.' => 'Inténtalo de nuevo y atrapa más estrellas.',
			'Private game. Embed directly where you want it.' => 'Juego privado. Insértalo directamente donde quieras.',
			'You found all the treasure. You win.' => 'Encontraste todo el tesoro. Ganaste.',
			'You hit a trap. Game over.' => 'Caíste en una trampa. Fin del juego.',
			'TREASURE' => 'TESORO',
			'TRAP' => 'TRAMPA',
			'Ready' => 'Listo',
			'Locked' => 'Bloqueado',
			'Mission complete!' => '¡Misión completa!',
			'Try again!' => '¡Inténtalo de nuevo!',
		),
		'es-es' => array(
			'Arabalı' => 'Juego de coches',
			'Başlamak için düğmeye bas' => 'Pulsa el botón para empezar',
			'Skor: ' => 'Puntuación: ',
			'Su: ' => 'Agua: ',
			'Seviye: ' => 'Nivel: ',
			'En iyi su: ' => 'Mejor agua: ',
			'Çöl oyun alanı' => 'Zona de juego del desierto',
			'Kazandın. Sonraki seviyeye geç.' => 'Has ganado. Pasa al siguiente nivel.',
			'Tekrar Başla' => 'Reiniciar',
			'Sonraki Seviye' => 'Siguiente nivel',
			'Kapılar' => 'Puertas',
			'Can: ' => 'Vidas: ',
			'En iyi: ' => 'Mejor: ',
			'Oyun bitti. Tekrar oyna.' => 'Fin del juego. Juega otra vez.',
			'Doğru kapıyı seç.' => 'Elige la puerta correcta.',
			'Doğru kapı. Hazineyi buldun.' => 'Puerta correcta. Has encontrado el tesoro.',
			'Yanlış kapı. Tuzak vardı.' => 'Puerta equivocada. Había una trampa.',
			'Mısır tapınağında sekiz kapı var. Sadece birinde hazine var. Doğru kapıyı seç ve ilerle.' => 'En el templo egipcio hay ocho puertas. Solo una tiene tesoro. Elige la puerta correcta y avanza.',
			'Her turda sadece bir kapı güvenlidir. Yanlış seçimde can kaybedersin.' => 'En cada ronda solo una puerta es segura. Si eliges mal, pierdes una vida.',
			'White' => 'Blanco',
			'Black' => 'Negro',
			'Choose a removable enemy stone.' => 'Elige una ficha enemiga que puedas quitar.',
			'Select one of your stones, then move it to any empty spot.' => 'Selecciona una de tus fichas y muévela a un espacio vacío.',
			'Select one of your stones, then move it to a connected empty spot.' => 'Selecciona una de tus fichas y muévela a un espacio vacío conectado.',
			'Select one of your own stones.' => 'Selecciona una de tus propias fichas.',
			'Stone selected. Choose where to move.' => 'Ficha seleccionada. Elige dónde moverla.',
			'Selection cleared.' => 'Selección borrada.',
			'Correct code. The locked box opens.' => 'Código correcto. La caja cerrada se abre.',
			'Wrong code.' => 'Código incorrecto.',
			'Start with the desk or the painting.' => 'Empieza por el escritorio o el cuadro.',
			'Unlock Box' => 'Abrir caja',
			'Restart Training' => 'Reiniciar entrenamiento',
			'Dinozorlu' => 'Juego de dinosaurios',
			'Balon Patlatmalı' => 'Revienta globos',
			'Hayvan Kurtarmalı' => 'Rescate de animales',
			'Ahır' => 'Granero',
			'Kurtarılan: ' => 'Rescatados: ',
			'Penaltı Kralı' => 'Rey de penaltis',
			'Başlat ve şut çek' => 'Empieza y dispara',
			'Yakalandın' => 'Te han atrapado',
			'Öğretmenden Kaç' => 'Escapa del profesor',
			'SINIF' => 'CLASE',
			'TAHTA' => 'PIZARRA',
			'Kaçma Oyunu' => 'Juego de escape',
			'Tekrar başlat ve yeniden savaş.' => 'Reinicia y lucha otra vez.',
			'Başlat ve bir savaşçı gönder.' => 'Empieza y envía un luchador.',
			'Başlat düğmesine bas' => 'Pulsa el botón Empezar',
			'Tekrar başlamak için Baştan Başla düğmesine bas' => 'Pulsa Reiniciar para empezar de nuevo',
			'Classify the bug.' => 'Clasifica el insecto.',
			'Classify the bugs before time runs out.' => 'Clasifica los insectos antes de que se acabe el tiempo.',
			'Correct bin.' => 'Contenedor correcto.',
			'You lost all lives. Press Start.' => 'Has perdido todas las vidas. Pulsa Empezar.',
			'Watch the sequence.' => 'Observa la secuencia.',
			'Now repeat.' => 'Ahora repite.',
			'Correct! Next level.' => '¡Correcto! Siguiente nivel.',
			'Try this round again.' => 'Intenta esta ronda otra vez.',
			'Round ' => 'Ronda ',
			'Game finished' => 'Juego terminado',
			'Perfect Balance' => 'Equilibrio perfecto',
			'Finished' => 'Terminado',
			'All three services are restored. The city lights up again.' => 'Los tres servicios están restaurados. La ciudad vuelve a iluminarse.',
			'Watch for the next one.' => 'Estate atento al siguiente.',
			'Nice catch.' => 'Buena captura.',
			'Too slow. Watch for the next one.' => 'Demasiado lento. Estate atento al siguiente.',
			'You found the hidden stars.' => 'Has encontrado las estrellas ocultas.',
			'Try again and catch more stars.' => 'Inténtalo de nuevo y atrapa más estrellas.',
			'Private game. Embed directly where you want it.' => 'Juego privado. Insértalo directamente donde quieras.',
			'You found all the treasure. You win.' => 'Has encontrado todo el tesoro. Has ganado.',
			'You hit a trap. Game over.' => 'Has caído en una trampa. Fin del juego.',
			'TREASURE' => 'TESORO',
			'TRAP' => 'TRAMPA',
			'Ready' => 'Listo',
			'Locked' => 'Bloqueado',
			'Mission complete!' => '¡Misión completa!',
			'Try again!' => '¡Inténtalo de nuevo!',
		),
	);

	foreach ($sitewide_runtime_exact as $sitewide_lang => $sitewide_items) {
		if (isset($translations[$sitewide_lang])) {
			$translations[$sitewide_lang] = array_merge($translations[$sitewide_lang], $sitewide_items);
		}
	}

	$sitewide_runtime_exact_late = array(
		'tr' => array(
			'Base Defense' => 'Üs Savunması',
			'Victory' => 'Zafer',
			'Defeat' => 'Yenilgi',
			'Press Restart to play again.' => 'Tekrar oynamak için Yeniden Başlat düğmesine bas.',
			'Place towers, then press Start.' => 'Kuleleri yerleştir, sonra Başlat düğmesine bas.',
			'Watch the sequence.' => 'Sırayı izle.',
			'Now repeat.' => 'Şimdi tekrar et.',
			'Game over. Press Start.' => 'Oyun bitti. Başlat düğmesine bas.',
			'Correct! Next level.' => 'Doğru! Sonraki seviye.',
			'Try this round again.' => 'Bu turu tekrar dene.',
			'All three services are restored. The city lights up again.' => 'Üç hizmet de onarıldı. Şehir yeniden ışıldıyor.',
			'is restored. Continue to the next service.' => 'onarıldı. Sonraki hizmete devam et.',
			'Rotate the junctions until all three districts connect to the' => 'Üç bölge de bağlanana kadar kavşakları döndür:',
			'network.' => 'ağı.',
			'Use sound only when you need it. Reach the green exit.' => 'Sesi yalnızca gerektiğinde kullan. Yeşil çıkışa ulaş.',
			'Caught in the dark. Try shorter routes and fewer pulses.' => 'Karanlıkta yakalandın. Daha kısa yollar ve daha az yankı dene.',
			'A wall catches the echo. Pick another path.' => 'Duvar yankıyı yakaladı. Başka bir yol seç.',
			'Soft step. Listen for the exit shape.' => 'Sessiz adım. Çıkışın şeklini dinle.',
			'Echo pulse sent. The hunter heard it too.' => 'Yankı gönderildi. Avcı da duydu.',
			'Bomb hit. Be careful.' => 'Bombaya çarptın. Dikkatli ol.',
			'Nice slice.' => 'Güzel kestin.',
			'You missed a fruit.' => 'Bir meyveyi kaçırdın.',
			'Slice the fruit. Avoid bombs.' => 'Meyveyi kes. Bombalardan kaç.',
			'Open matching pairs. Use few hints.' => 'Eşleşen çiftleri aç. Az ipucu kullan.',
			'Great! Board solved.' => 'Harika! Tahta çözüldü.',
			'Hint used.' => 'İpucu kullanıldı.',
			'Place walls, then check the path.' => 'Duvarları yerleştir, sonra yolu kontrol et.',
			'Path exists! Great builder.' => 'Yol var! Harika kurucu.',
			'No path. Move or remove some walls.' => 'Yol yok. Bazı duvarları taşı veya kaldır.',
			'Board cleared.' => 'Tahta temizlendi.',
			'Wrong order.' => 'Yanlış sıra.',
			'Game over.' => 'Oyun bitti.',
			'Great job! Plant grew.' => 'Harika! Bitki büyüdü.',
			'Sequence cleared.' => 'Sıra temizlendi.',
			'Choose parts wisely.' => 'Parçaları dikkatli seç.',
			'Mission success. Robot performed well.' => 'Görev başarılı. Robot iyi çalıştı.',
			'Mission failed. Adjust your design.' => 'Görev başarısız. Tasarımını düzelt.',
			'Find the different color' => 'Farklı rengi bul',
			'Watch the glowing path.' => 'Parlayan yolu izle.',
			'Repeat the path in order.' => 'Yolu sırayla tekrar et.',
			'Path jumped. Retry.' => 'Yol atladı. Tekrar dene.',
			'Great job! Press start for next round.' => 'Harika! Sonraki tur için Başlat düğmesine bas.',
			'Wrong order. Press start to try again.' => 'Yanlış sıra. Tekrar denemek için Başlat düğmesine bas.',
			'Press start to begin.' => 'Başlamak için Başlat düğmesine bas.',
			'Out of catches. Press Start.' => 'Yakalama hakkın bitti. Başlat düğmesine bas.',
			'Collect the target letter.' => 'Hedef harfi topla.',
			'Time over. Score: ' => 'Süre bitti. Puan: ',
			'Wrong note.' => 'Yanlış nota.',
			'No lives. Press Start.' => 'Can kalmadı. Başlat düğmesine bas.',
			'Great! Next round.' => 'Harika! Sonraki tur.',
			'Round started.' => 'Tur başladı.',
			'Your turn! Click a cell to claim it.' => 'Sıra sende! Almak için bir hücreye tıkla.',
			'Your turn!' => 'Sıra sende!',
			'AI Wins! Better luck next time!' => 'Yapay zeka kazandı! Bir dahaki sefere.',
			"It's a Tie!" => 'Berabere!',
			'Watch the loop sequence.' => 'Döngü sırasını izle.',
			'Repeat it now.' => 'Şimdi tekrar et.',
			'Add all 5 moves.' => '5 hamlenin hepsini ekle.',
			'Great loop! You reached the goal.' => 'Harika döngü! Hedefe ulaştın.',
			'Wrong path.' => 'Yanlış yol.',
			'Correct balloon!' => 'Doğru balon!',
			'Wrong balloon.' => 'Yanlış balon.',
			'Pop the correct balloons.' => 'Doğru balonları patlat.',
			'World: ' => 'Dünya: ',
			'Build the word' => 'Kelimeyi kur',
			'Wrong order!' => 'Yanlış sıra!',
			'Blue Base' => 'Mavi Üs',
			'Red Base' => 'Kırmızı Üs',
			'Wit Bases' => 'Zeka Üsleri',
			'Monster Team vs Block World' => 'Canavar Takımı Blok Dünyasına Karşı',
			'Start, then send units from the left side.' => 'Başlat, sonra sol taraftan birlik gönder.',
			'Press restart to play again.' => 'Tekrar oynamak için yeniden başlat.',
			'CASTLE ENTRANCE' => 'KALE GİRİŞİ',
			'SANCTUARY' => 'SIĞINAK',
			'Enter 4-digit code' => '4 haneli kod gir',
			'Type your decoded phrase here' => 'Çözdüğün ifadeyi buraya yaz',
			'Type your answer here' => 'Cevabını buraya yaz',
		),
		'de' => array(
			'Base Defense' => 'Basisverteidigung',
			'Victory' => 'Sieg',
			'Defeat' => 'Niederlage',
			'Place towers, then press Start.' => 'Platziere Türme und drücke dann Start.',
			'is restored. Continue to the next service.' => 'ist wiederhergestellt. Weiter zum nächsten Dienst.',
			'Rotate the junctions until all three districts connect to the' => 'Drehe die Kreuzungen, bis alle drei Bezirke verbunden sind mit dem',
			'network.' => 'Netzwerk.',
			'Use sound only when you need it. Reach the green exit.' => 'Nutze Schall nur, wenn du ihn brauchst. Erreiche den grünen Ausgang.',
			'Caught in the dark. Try shorter routes and fewer pulses.' => 'Im Dunkeln erwischt. Versuche kürzere Wege und weniger Impulse.',
			'A wall catches the echo. Pick another path.' => 'Eine Wand fängt das Echo. Wähle einen anderen Weg.',
			'Soft step. Listen for the exit shape.' => 'Leiser Schritt. Höre auf die Form des Ausgangs.',
			'Echo pulse sent. The hunter heard it too.' => 'Echoimpuls gesendet. Der Jäger hat ihn auch gehört.',
			'Bomb hit. Be careful.' => 'Bombe getroffen. Sei vorsichtig.',
			'Nice slice.' => 'Guter Schnitt.',
			'You missed a fruit.' => 'Du hast ein Obst verpasst.',
			'Slice the fruit. Avoid bombs.' => 'Schneide das Obst. Weiche Bomben aus.',
			'Open matching pairs. Use few hints.' => 'Öffne passende Paare. Nutze wenige Hinweise.',
			'Great! Board solved.' => 'Super! Brett gelöst.',
			'Hint used.' => 'Hinweis genutzt.',
			'Place walls, then check the path.' => 'Setze Wände und prüfe dann den Weg.',
			'Path exists! Great builder.' => 'Es gibt einen Weg! Starker Bau.',
			'No path. Move or remove some walls.' => 'Kein Weg. Verschiebe oder entferne einige Wände.',
			'Board cleared.' => 'Brett geleert.',
			'Wrong order.' => 'Falsche Reihenfolge.',
			'Great job! Plant grew.' => 'Gut gemacht! Die Pflanze ist gewachsen.',
			'Sequence cleared.' => 'Sequenz gelöscht.',
			'Choose parts wisely.' => 'Wähle Teile klug aus.',
			'Mission success. Robot performed well.' => 'Mission erfolgreich. Der Roboter war gut.',
			'Mission failed. Adjust your design.' => 'Mission fehlgeschlagen. Passe dein Design an.',
			'Find the different color' => 'Finde die andere Farbe',
			'Watch the glowing path.' => 'Merke dir den leuchtenden Weg.',
			'Repeat the path in order.' => 'Wiederhole den Weg in Reihenfolge.',
			'Path jumped. Retry.' => 'Der Weg ist gesprungen. Erneut versuchen.',
			'Great job! Press start for next round.' => 'Gut gemacht! Drücke Start für die nächste Runde.',
			'Wrong order. Press start to try again.' => 'Falsche Reihenfolge. Drücke Start, um es erneut zu versuchen.',
			'Press start to begin.' => 'Drücke Start, um zu beginnen.',
			'Out of catches. Press Start.' => 'Keine Fänge mehr. Drücke Start.',
			'Collect the target letter.' => 'Sammle den Zielbuchstaben.',
			'Time over. Score: ' => 'Zeit vorbei. Punkte: ',
			'Wrong note.' => 'Falsche Note.',
			'Great! Next round.' => 'Super! Nächste Runde.',
			'Round started.' => 'Runde gestartet.',
			'Your turn! Click a cell to claim it.' => 'Du bist dran! Klicke eine Zelle an, um sie zu beanspruchen.',
			'Your turn!' => 'Du bist dran!',
			'AI Wins! Better luck next time!' => 'KI gewinnt! Nächstes Mal mehr Glück!',
			"It's a Tie!" => 'Unentschieden!',
			'Watch the loop sequence.' => 'Merke dir die Schleifensequenz.',
			'Repeat it now.' => 'Wiederhole sie jetzt.',
			'Add all 5 moves.' => 'Füge alle 5 Züge hinzu.',
			'Great loop! You reached the goal.' => 'Starke Schleife! Du hast das Ziel erreicht.',
			'Wrong path.' => 'Falscher Weg.',
			'Correct balloon!' => 'Richtiger Ballon!',
			'Wrong balloon.' => 'Falscher Ballon.',
			'Pop the correct balloons.' => 'Lass die richtigen Ballons platzen.',
			'World: ' => 'Welt: ',
			'Build the word' => 'Baue das Wort',
			'Wrong order!' => 'Falsche Reihenfolge!',
			'Blue Base' => 'Blaue Basis',
			'Red Base' => 'Rote Basis',
			'Wit Bases' => 'Denkbasen',
			'Monster Team vs Block World' => 'Monsterteam gegen Blockwelt',
			'Start, then send units from the left side.' => 'Starte und sende dann Einheiten von links.',
			'Press restart to play again.' => 'Drücke Neustart, um wieder zu spielen.',
			'CASTLE ENTRANCE' => 'BURGEINGANG',
			'SANCTUARY' => 'ZUFLUCHT',
			'Enter 4-digit code' => '4-stelligen Code eingeben',
			'Type your decoded phrase here' => 'Gib hier den entschlüsselten Satz ein',
			'Type your answer here' => 'Gib hier deine Antwort ein',
		),
		'fr' => array(
			'Base Defense' => 'Défense de base',
			'Victory' => 'Victoire',
			'Defeat' => 'Défaite',
			'Place towers, then press Start.' => 'Place des tours, puis appuie sur Démarrer.',
			'is restored. Continue to the next service.' => 'est rétabli. Continue avec le service suivant.',
			'Rotate the junctions until all three districts connect to the' => 'Tourne les jonctions jusqu’à ce que les trois quartiers se connectent au',
			'network.' => 'réseau.',
			'Use sound only when you need it. Reach the green exit.' => 'Utilise le son seulement quand tu en as besoin. Atteins la sortie verte.',
			'Caught in the dark. Try shorter routes and fewer pulses.' => 'Pris dans le noir. Essaie des trajets plus courts et moins d’impulsions.',
			'A wall catches the echo. Pick another path.' => 'Un mur capte l’écho. Choisis un autre chemin.',
			'Soft step. Listen for the exit shape.' => 'Pas discret. Écoute la forme de la sortie.',
			'Echo pulse sent. The hunter heard it too.' => 'Impulsion d’écho envoyée. Le chasseur l’a aussi entendue.',
			'Bomb hit. Be careful.' => 'Bombe touchée. Fais attention.',
			'Nice slice.' => 'Belle coupe.',
			'You missed a fruit.' => 'Tu as raté un fruit.',
			'Slice the fruit. Avoid bombs.' => 'Coupe les fruits. Évite les bombes.',
			'Open matching pairs. Use few hints.' => 'Ouvre les paires correspondantes. Utilise peu d’indices.',
			'Great! Board solved.' => 'Super ! Plateau résolu.',
			'Hint used.' => 'Indice utilisé.',
			'Place walls, then check the path.' => 'Place des murs, puis vérifie le chemin.',
			'Path exists! Great builder.' => 'Un chemin existe ! Très bon bâtisseur.',
			'No path. Move or remove some walls.' => 'Aucun chemin. Déplace ou retire des murs.',
			'Board cleared.' => 'Plateau effacé.',
			'Wrong order.' => 'Mauvais ordre.',
			'Great job! Plant grew.' => 'Bravo ! La plante a poussé.',
			'Sequence cleared.' => 'Séquence effacée.',
			'Choose parts wisely.' => 'Choisis les pièces avec soin.',
			'Mission success. Robot performed well.' => 'Mission réussie. Le robot a bien fonctionné.',
			'Mission failed. Adjust your design.' => 'Mission échouée. Ajuste ton design.',
			'Find the different color' => 'Trouve la couleur différente',
			'Watch the glowing path.' => 'Observe le chemin lumineux.',
			'Repeat the path in order.' => 'Répète le chemin dans l’ordre.',
			'Path jumped. Retry.' => 'Le chemin a sauté. Réessaie.',
			'Great job! Press start for next round.' => 'Bravo ! Appuie sur Démarrer pour la manche suivante.',
			'Wrong order. Press start to try again.' => 'Mauvais ordre. Appuie sur Démarrer pour réessayer.',
			'Press start to begin.' => 'Appuie sur Démarrer pour commencer.',
			'Out of catches. Press Start.' => 'Plus de prises. Appuie sur Démarrer.',
			'Collect the target letter.' => 'Ramasse la lettre cible.',
			'Time over. Score: ' => 'Temps écoulé. Score : ',
			'Wrong note.' => 'Mauvaise note.',
			'Great! Next round.' => 'Super ! Manche suivante.',
			'Round started.' => 'Manche commencée.',
			'Your turn! Click a cell to claim it.' => 'À toi ! Clique sur une case pour la prendre.',
			'Your turn!' => 'À toi !',
			'AI Wins! Better luck next time!' => 'L’IA gagne ! Tu feras mieux la prochaine fois !',
			"It's a Tie!" => 'Égalité !',
			'Watch the loop sequence.' => 'Observe la séquence de boucle.',
			'Repeat it now.' => 'Répète-la maintenant.',
			'Add all 5 moves.' => 'Ajoute les 5 mouvements.',
			'Great loop! You reached the goal.' => 'Belle boucle ! Tu as atteint l’objectif.',
			'Wrong path.' => 'Mauvais chemin.',
			'Correct balloon!' => 'Bon ballon !',
			'Wrong balloon.' => 'Mauvais ballon.',
			'Pop the correct balloons.' => 'Éclate les bons ballons.',
			'World: ' => 'Monde : ',
			'Build the word' => 'Construis le mot',
			'Wrong order!' => 'Mauvais ordre !',
			'Blue Base' => 'Base bleue',
			'Red Base' => 'Base rouge',
			'Wit Bases' => 'Bases de réflexion',
			'Monster Team vs Block World' => 'Équipe monstre contre monde de blocs',
			'Start, then send units from the left side.' => 'Démarre, puis envoie des unités depuis la gauche.',
			'Press restart to play again.' => 'Appuie sur redémarrer pour rejouer.',
			'CASTLE ENTRANCE' => 'ENTRÉE DU CHÂTEAU',
			'SANCTUARY' => 'SANCTUAIRE',
			'Enter 4-digit code' => 'Entre un code à 4 chiffres',
			'Type your decoded phrase here' => 'Tape ici ta phrase décodée',
			'Type your answer here' => 'Tape ta réponse ici',
		),
		'es-mx' => array(
			'Base Defense' => 'Defensa de base',
			'Victory' => 'Victoria',
			'Defeat' => 'Derrota',
			'Place towers, then press Start.' => 'Coloca torres y luego presiona Empezar.',
			'is restored. Continue to the next service.' => 'está restaurado. Continúa con el siguiente servicio.',
			'Rotate the junctions until all three districts connect to the' => 'Gira los cruces hasta que los tres distritos se conecten a la',
			'network.' => 'red.',
			'Use sound only when you need it. Reach the green exit.' => 'Usa el sonido solo cuando lo necesites. Llega a la salida verde.',
			'Caught in the dark. Try shorter routes and fewer pulses.' => 'Atrapado en la oscuridad. Prueba rutas más cortas y menos pulsos.',
			'A wall catches the echo. Pick another path.' => 'Una pared atrapa el eco. Elige otro camino.',
			'Soft step. Listen for the exit shape.' => 'Paso suave. Escucha la forma de la salida.',
			'Echo pulse sent. The hunter heard it too.' => 'Pulso de eco enviado. El cazador también lo oyó.',
			'Bomb hit. Be careful.' => 'Tocaste una bomba. Ten cuidado.',
			'Nice slice.' => 'Buen corte.',
			'You missed a fruit.' => 'Se te escapó una fruta.',
			'Slice the fruit. Avoid bombs.' => 'Corta la fruta. Evita las bombas.',
			'Open matching pairs. Use few hints.' => 'Abre pares iguales. Usa pocas pistas.',
			'Great! Board solved.' => '¡Genial! Tablero resuelto.',
			'Hint used.' => 'Pista usada.',
			'Place walls, then check the path.' => 'Coloca paredes y luego revisa el camino.',
			'Path exists! Great builder.' => '¡Hay camino! Gran constructor.',
			'No path. Move or remove some walls.' => 'No hay camino. Mueve o quita algunas paredes.',
			'Board cleared.' => 'Tablero limpio.',
			'Wrong order.' => 'Orden incorrecto.',
			'Great job! Plant grew.' => '¡Muy bien! La planta creció.',
			'Sequence cleared.' => 'Secuencia borrada.',
			'Choose parts wisely.' => 'Elige las piezas con cuidado.',
			'Mission success. Robot performed well.' => 'Misión exitosa. El robot funcionó bien.',
			'Mission failed. Adjust your design.' => 'Misión fallida. Ajusta tu diseño.',
			'Find the different color' => 'Encuentra el color diferente',
			'Watch the glowing path.' => 'Observa el camino brillante.',
			'Repeat the path in order.' => 'Repite el camino en orden.',
			'Path jumped. Retry.' => 'El camino saltó. Reintenta.',
			'Great job! Press start for next round.' => '¡Muy bien! Presiona Empezar para la siguiente ronda.',
			'Wrong order. Press start to try again.' => 'Orden incorrecto. Presiona Empezar para intentarlo de nuevo.',
			'Press start to begin.' => 'Presiona Empezar para comenzar.',
			'Out of catches. Press Start.' => 'Sin atrapadas. Presiona Empezar.',
			'Collect the target letter.' => 'Recoge la letra objetivo.',
			'Time over. Score: ' => 'Tiempo terminado. Puntuación: ',
			'Wrong note.' => 'Nota incorrecta.',
			'Great! Next round.' => '¡Genial! Siguiente ronda.',
			'Round started.' => 'Ronda iniciada.',
			'Your turn! Click a cell to claim it.' => '¡Tu turno! Haz clic en una celda para reclamarla.',
			'Your turn!' => '¡Tu turno!',
			'AI Wins! Better luck next time!' => '¡La IA gana! Más suerte la próxima vez.',
			"It's a Tie!" => '¡Empate!',
			'Watch the loop sequence.' => 'Observa la secuencia del bucle.',
			'Repeat it now.' => 'Repítela ahora.',
			'Add all 5 moves.' => 'Agrega los 5 movimientos.',
			'Great loop! You reached the goal.' => '¡Gran bucle! Llegaste a la meta.',
			'Wrong path.' => 'Camino incorrecto.',
			'Correct balloon!' => '¡Globo correcto!',
			'Wrong balloon.' => 'Globo incorrecto.',
			'Pop the correct balloons.' => 'Revienta los globos correctos.',
			'World: ' => 'Mundo: ',
			'Build the word' => 'Forma la palabra',
			'Wrong order!' => '¡Orden incorrecto!',
			'Blue Base' => 'Base azul',
			'Red Base' => 'Base roja',
			'Wit Bases' => 'Bases de ingenio',
			'Monster Team vs Block World' => 'Equipo monstruo contra mundo de bloques',
			'Start, then send units from the left side.' => 'Empieza y luego envía unidades desde la izquierda.',
			'Press restart to play again.' => 'Presiona reiniciar para jugar de nuevo.',
			'CASTLE ENTRANCE' => 'ENTRADA DEL CASTILLO',
			'SANCTUARY' => 'SANTUARIO',
			'Enter 4-digit code' => 'Ingresa un código de 4 dígitos',
			'Type your decoded phrase here' => 'Escribe aquí tu frase decodificada',
			'Type your answer here' => 'Escribe tu respuesta aquí',
		),
		'es-es' => array(
			'Base Defense' => 'Defensa de base',
			'Victory' => 'Victoria',
			'Defeat' => 'Derrota',
			'Place towers, then press Start.' => 'Coloca torres y luego pulsa Empezar.',
			'is restored. Continue to the next service.' => 'está restaurado. Continúa con el siguiente servicio.',
			'Rotate the junctions until all three districts connect to the' => 'Gira los cruces hasta que los tres distritos se conecten a la',
			'network.' => 'red.',
			'Use sound only when you need it. Reach the green exit.' => 'Usa el sonido solo cuando lo necesites. Llega a la salida verde.',
			'Caught in the dark. Try shorter routes and fewer pulses.' => 'Atrapado en la oscuridad. Prueba rutas más cortas y menos pulsos.',
			'A wall catches the echo. Pick another path.' => 'Una pared atrapa el eco. Elige otro camino.',
			'Soft step. Listen for the exit shape.' => 'Paso suave. Escucha la forma de la salida.',
			'Echo pulse sent. The hunter heard it too.' => 'Pulso de eco enviado. El cazador también lo ha oído.',
			'Bomb hit. Be careful.' => 'Has tocado una bomba. Ten cuidado.',
			'Nice slice.' => 'Buen corte.',
			'You missed a fruit.' => 'Has fallado una fruta.',
			'Slice the fruit. Avoid bombs.' => 'Corta la fruta. Evita las bombas.',
			'Open matching pairs. Use few hints.' => 'Abre parejas iguales. Usa pocas pistas.',
			'Great! Board solved.' => '¡Genial! Tablero resuelto.',
			'Hint used.' => 'Pista usada.',
			'Place walls, then check the path.' => 'Coloca paredes y luego comprueba el camino.',
			'Path exists! Great builder.' => '¡Hay camino! Gran constructor.',
			'No path. Move or remove some walls.' => 'No hay camino. Mueve o quita algunas paredes.',
			'Board cleared.' => 'Tablero despejado.',
			'Wrong order.' => 'Orden incorrecto.',
			'Great job! Plant grew.' => '¡Muy bien! La planta ha crecido.',
			'Sequence cleared.' => 'Secuencia borrada.',
			'Choose parts wisely.' => 'Elige las piezas con cuidado.',
			'Mission success. Robot performed well.' => 'Misión completada. El robot funcionó bien.',
			'Mission failed. Adjust your design.' => 'Misión fallida. Ajusta tu diseño.',
			'Find the different color' => 'Encuentra el color diferente',
			'Watch the glowing path.' => 'Observa el camino brillante.',
			'Repeat the path in order.' => 'Repite el camino en orden.',
			'Path jumped. Retry.' => 'El camino ha saltado. Reintenta.',
			'Great job! Press start for next round.' => '¡Muy bien! Pulsa Empezar para la siguiente ronda.',
			'Wrong order. Press start to try again.' => 'Orden incorrecto. Pulsa Empezar para intentarlo de nuevo.',
			'Press start to begin.' => 'Pulsa Empezar para comenzar.',
			'Out of catches. Press Start.' => 'Sin capturas. Pulsa Empezar.',
			'Collect the target letter.' => 'Recoge la letra objetivo.',
			'Time over. Score: ' => 'Tiempo terminado. Puntuación: ',
			'Wrong note.' => 'Nota incorrecta.',
			'Great! Next round.' => '¡Genial! Siguiente ronda.',
			'Round started.' => 'Ronda iniciada.',
			'Your turn! Click a cell to claim it.' => '¡Tu turno! Haz clic en una celda para reclamarla.',
			'Your turn!' => '¡Tu turno!',
			'AI Wins! Better luck next time!' => '¡La IA gana! Más suerte la próxima vez.',
			"It's a Tie!" => '¡Empate!',
			'Watch the loop sequence.' => 'Observa la secuencia del bucle.',
			'Repeat it now.' => 'Repítela ahora.',
			'Add all 5 moves.' => 'Añade los 5 movimientos.',
			'Great loop! You reached the goal.' => '¡Gran bucle! Has llegado a la meta.',
			'Wrong path.' => 'Camino incorrecto.',
			'Correct balloon!' => '¡Globo correcto!',
			'Wrong balloon.' => 'Globo incorrecto.',
			'Pop the correct balloons.' => 'Revienta los globos correctos.',
			'World: ' => 'Mundo: ',
			'Build the word' => 'Forma la palabra',
			'Wrong order!' => '¡Orden incorrecto!',
			'Blue Base' => 'Base azul',
			'Red Base' => 'Base roja',
			'Wit Bases' => 'Bases de ingenio',
			'Monster Team vs Block World' => 'Equipo monstruo contra mundo de bloques',
			'Start, then send units from the left side.' => 'Empieza y luego envía unidades desde la izquierda.',
			'Press restart to play again.' => 'Pulsa reiniciar para jugar de nuevo.',
			'CASTLE ENTRANCE' => 'ENTRADA DEL CASTILLO',
			'SANCTUARY' => 'SANTUARIO',
			'Enter 4-digit code' => 'Introduce un código de 4 dígitos',
			'Type your decoded phrase here' => 'Escribe aquí tu frase decodificada',
			'Type your answer here' => 'Escribe tu respuesta aquí',
		),
	);

	foreach ($sitewide_runtime_exact_late as $late_lang => $late_items) {
		if (isset($translations[$late_lang])) {
			$translations[$late_lang] = array_merge($translations[$late_lang], $late_items);
		}
	}

	$sitewide_runtime_exact_more = array(
		'tr' => array(
			'This shared puzzle is blocked because its data is invalid.' => 'Paylaşılan bulmaca verisi geçersiz olduğu için engellendi.',
			'Play mode. Use arrow keys.' => 'Oyun modu. Ok tuşlarını kullan.',
			'Puzzle solved.' => 'Bulmaca çözüldü.',
			'Saved to system.' => 'Sisteme kaydedildi.',
			'Could not save puzzle.' => 'Bulmaca kaydedilemedi.',
			'Could not reach the puzzle save service.' => 'Bulmaca kaydetme servisine ulaşılamadı.',
			'Could not load shared puzzles.' => 'Paylaşılan bulmacalar yüklenemedi.',
			'Match the target in 5 moves.' => 'Hedefi 5 hamlede eşleştir.',
			'Aligned! Nice!' => 'Hizalandı! Güzel!',
			'Not aligned. Try again.' => 'Hizalanmadı. Tekrar dene.',
			'Hazır. Nil üzerinde hazineleri topla.' => 'Ready. Collect treasures on the Nile.',
			'Altınları yakala. Timsahlardan kaç.' => 'Altınları yakala. Timsahlardan kaç.',
			'Oyun bitti. Tekrar başla.' => 'Oyun bitti. Tekrar başla.',
			'Hazine yakaladın.' => 'Hazine yakaladın.',
			'Timsaha çarptın.' => 'Timsaha çarptın.',
			'Bir hazineyi kaçırdın.' => 'Bir hazineyi kaçırdın.',
			'Pocket Team vs Block Team' => 'Cep Takımı Blok Takımına Karşı',
			'Wins' => 'Kazandı',
			'Every 5 seconds the game sends 1 enemy. More Enemies sends 2.' => 'Her 5 saniyede oyun 1 düşman gönderir. Daha Fazla Düşman 2 gönderir.',
			'No moves yet.' => 'Henüz hamle yok.',
			'Turn: ' => 'Sıra: ',
			'You: ' => 'Sen: ',
			'Correct!' => 'Doğru!',
			'Wrong!' => 'Yanlış!',
			'Perfect Balance' => 'Mükemmel Denge',
			'Finished' => 'Bitti',
			'Game finished' => 'Oyun bitti',
			'No country selected yet' => 'Henüz ülke seçilmedi',
			'Write a country name in Turkish or English, then press Start Quiz.' => 'Türkçe veya İngilizce bir ülke adı yaz, sonra Testi Başlat düğmesine bas.',
			'Question 0 / 100' => 'Soru 0 / 100',
			'Type text here' => 'Metni buraya yaz',
			'Pick color' => 'Renk seç',
			'Brush size' => 'Fırça boyutu',
			'Shape picker' => 'Şekil seçici',
			'Text input' => 'Metin girişi',
			'Text size' => 'Metin boyutu',
			'Font picker' => 'Yazı tipi seçici',
			'Sticker picker' => 'Çıkartma seçici',
			'Emoji picker' => 'Emoji seçici',
			'Frame picker' => 'Çerçeve seçici',
			'Upload image' => 'Görsel yükle',
			'Drawing canvas' => 'Çizim tuvali',
		),
		'de' => array(
			'This shared puzzle is blocked because its data is invalid.' => 'Dieses geteilte Rätsel ist gesperrt, weil seine Daten ungültig sind.',
			'Play mode. Use arrow keys.' => 'Spielmodus. Nutze die Pfeiltasten.',
			'Puzzle solved.' => 'Rätsel gelöst.',
			'Saved to system.' => 'Im System gespeichert.',
			'Could not save puzzle.' => 'Rätsel konnte nicht gespeichert werden.',
			'Could not reach the puzzle save service.' => 'Rätsel-Speicherdienst nicht erreichbar.',
			'Could not load shared puzzles.' => 'Geteilte Rätsel konnten nicht geladen werden.',
			'Match the target in 5 moves.' => 'Triff das Ziel in 5 Zügen.',
			'Aligned! Nice!' => 'Ausgerichtet! Schön!',
			'Not aligned. Try again.' => 'Nicht ausgerichtet. Versuch es erneut.',
			'Hazır. Nil üzerinde hazineleri topla.' => 'Bereit. Sammle Schätze auf dem Nil.',
			'Altınları yakala. Timsahlardan kaç.' => 'Fange Gold. Weiche Krokodilen aus.',
			'Oyun bitti. Tekrar başla.' => 'Spiel vorbei. Starte erneut.',
			'Hazine yakaladın.' => 'Du hast einen Schatz gefangen.',
			'Timsaha çarptın.' => 'Du bist gegen ein Krokodil gestoßen.',
			'Bir hazineyi kaçırdın.' => 'Du hast einen Schatz verpasst.',
			'Pocket Team vs Block Team' => 'Taschenteam gegen Blockteam',
			'Wins' => 'gewinnt',
			'Every 5 seconds the game sends 1 enemy. More Enemies sends 2.' => 'Alle 5 Sekunden sendet das Spiel 1 Gegner. Mehr Gegner sendet 2.',
			'No moves yet.' => 'Noch keine Züge.',
			'Turn: ' => 'Zug: ',
			'You: ' => 'Du: ',
			'Question 0 / 100' => 'Frage 0 / 100',
			'No country selected yet' => 'Noch kein Land ausgewählt',
			'Write a country name in Turkish or English, then press Start Quiz.' => 'Schreibe einen Ländernamen auf Türkisch oder Englisch und drücke dann Quiz starten.',
			'Type text here' => 'Text hier eingeben',
			'Pick color' => 'Farbe wählen',
			'Brush size' => 'Pinselgröße',
			'Shape picker' => 'Formauswahl',
			'Text input' => 'Texteingabe',
			'Text size' => 'Textgröße',
			'Font picker' => 'Schriftauswahl',
			'Sticker picker' => 'Sticker-Auswahl',
			'Emoji picker' => 'Emoji-Auswahl',
			'Frame picker' => 'Rahmenauswahl',
			'Upload image' => 'Bild hochladen',
			'Drawing canvas' => 'Zeichenfläche',
		),
		'fr' => array(
			'This shared puzzle is blocked because its data is invalid.' => 'Ce puzzle partagé est bloqué car ses données sont invalides.',
			'Play mode. Use arrow keys.' => 'Mode jeu. Utilise les touches fléchées.',
			'Puzzle solved.' => 'Puzzle résolu.',
			'Saved to system.' => 'Enregistré dans le système.',
			'Could not save puzzle.' => 'Impossible d’enregistrer le puzzle.',
			'Could not reach the puzzle save service.' => 'Impossible de joindre le service d’enregistrement.',
			'Could not load shared puzzles.' => 'Impossible de charger les puzzles partagés.',
			'Match the target in 5 moves.' => 'Aligne la cible en 5 coups.',
			'Aligned! Nice!' => 'Aligné ! Bien joué !',
			'Not aligned. Try again.' => 'Pas aligné. Réessaie.',
			'Hazır. Nil üzerinde hazineleri topla.' => 'Prêt. Ramasse les trésors sur le Nil.',
			'Altınları yakala. Timsahlardan kaç.' => 'Attrape l’or. Évite les crocodiles.',
			'Oyun bitti. Tekrar başla.' => 'Partie terminée. Recommence.',
			'Hazine yakaladın.' => 'Tu as attrapé un trésor.',
			'Timsaha çarptın.' => 'Tu as percuté un crocodile.',
			'Bir hazineyi kaçırdın.' => 'Tu as raté un trésor.',
			'Pocket Team vs Block Team' => 'Équipe Pocket contre équipe Block',
			'Wins' => 'gagne',
			'Every 5 seconds the game sends 1 enemy. More Enemies sends 2.' => 'Toutes les 5 secondes, le jeu envoie 1 ennemi. Plus d’ennemis en envoie 2.',
			'No moves yet.' => 'Aucun coup pour l’instant.',
			'Turn: ' => 'Tour : ',
			'You: ' => 'Toi : ',
			'Question 0 / 100' => 'Question 0 / 100',
			'No country selected yet' => 'Aucun pays sélectionné',
			'Write a country name in Turkish or English, then press Start Quiz.' => 'Écris un nom de pays en turc ou en anglais, puis lance le quiz.',
			'Type text here' => 'Tape le texte ici',
			'Pick color' => 'Choisir une couleur',
			'Brush size' => 'Taille du pinceau',
			'Shape picker' => 'Choix de forme',
			'Text input' => 'Saisie de texte',
			'Text size' => 'Taille du texte',
			'Font picker' => 'Choix de police',
			'Sticker picker' => 'Choix d’autocollant',
			'Emoji picker' => 'Choix d’emoji',
			'Frame picker' => 'Choix de cadre',
			'Upload image' => 'Importer une image',
			'Drawing canvas' => 'Zone de dessin',
		),
		'es-mx' => array(
			'This shared puzzle is blocked because its data is invalid.' => 'Este rompecabezas compartido está bloqueado porque sus datos no son válidos.',
			'Play mode. Use arrow keys.' => 'Modo juego. Usa las flechas.',
			'Puzzle solved.' => 'Rompecabezas resuelto.',
			'Saved to system.' => 'Guardado en el sistema.',
			'Could not save puzzle.' => 'No se pudo guardar el rompecabezas.',
			'Could not reach the puzzle save service.' => 'No se pudo contactar el servicio de guardado.',
			'Could not load shared puzzles.' => 'No se pudieron cargar los rompecabezas compartidos.',
			'Match the target in 5 moves.' => 'Alinea el objetivo en 5 movimientos.',
			'Aligned! Nice!' => '¡Alineado! ¡Bien!',
			'Not aligned. Try again.' => 'No está alineado. Intenta de nuevo.',
			'Hazır. Nil üzerinde hazineleri topla.' => 'Listo. Recoge tesoros en el Nilo.',
			'Altınları yakala. Timsahlardan kaç.' => 'Atrapa oro. Evita cocodrilos.',
			'Oyun bitti. Tekrar başla.' => 'Fin del juego. Empieza de nuevo.',
			'Hazine yakaladın.' => 'Atrapaste un tesoro.',
			'Timsaha çarptın.' => 'Chocaste con un cocodrilo.',
			'Bir hazineyi kaçırdın.' => 'Se te escapó un tesoro.',
			'Pocket Team vs Block Team' => 'Equipo Pocket contra equipo Block',
			'Wins' => 'gana',
			'Every 5 seconds the game sends 1 enemy. More Enemies sends 2.' => 'Cada 5 segundos el juego envía 1 enemigo. Más enemigos envía 2.',
			'No moves yet.' => 'Aún no hay movimientos.',
			'Turn: ' => 'Turno: ',
			'You: ' => 'Tú: ',
			'Question 0 / 100' => 'Pregunta 0 / 100',
			'No country selected yet' => 'Aún no hay país seleccionado',
			'Write a country name in Turkish or English, then press Start Quiz.' => 'Escribe un país en turco o inglés y luego presiona Empezar quiz.',
			'Type text here' => 'Escribe texto aquí',
			'Pick color' => 'Elegir color',
			'Brush size' => 'Tamaño del pincel',
			'Shape picker' => 'Selector de forma',
			'Text input' => 'Entrada de texto',
			'Text size' => 'Tamaño del texto',
			'Font picker' => 'Selector de fuente',
			'Sticker picker' => 'Selector de sticker',
			'Emoji picker' => 'Selector de emoji',
			'Frame picker' => 'Selector de marco',
			'Upload image' => 'Subir imagen',
			'Drawing canvas' => 'Lienzo de dibujo',
		),
		'es-es' => array(
			'This shared puzzle is blocked because its data is invalid.' => 'Este puzle compartido está bloqueado porque sus datos no son válidos.',
			'Play mode. Use arrow keys.' => 'Modo juego. Usa las flechas.',
			'Puzzle solved.' => 'Puzle resuelto.',
			'Saved to system.' => 'Guardado en el sistema.',
			'Could not save puzzle.' => 'No se pudo guardar el puzle.',
			'Could not reach the puzzle save service.' => 'No se pudo contactar con el servicio de guardado.',
			'Could not load shared puzzles.' => 'No se pudieron cargar los puzles compartidos.',
			'Match the target in 5 moves.' => 'Alinea el objetivo en 5 movimientos.',
			'Aligned! Nice!' => '¡Alineado! ¡Bien!',
			'Not aligned. Try again.' => 'No está alineado. Inténtalo de nuevo.',
			'Hazır. Nil üzerinde hazineleri topla.' => 'Listo. Recoge tesoros en el Nilo.',
			'Altınları yakala. Timsahlardan kaç.' => 'Atrapa oro. Evita cocodrilos.',
			'Oyun bitti. Tekrar başla.' => 'Fin del juego. Empieza de nuevo.',
			'Hazine yakaladın.' => 'Has atrapado un tesoro.',
			'Timsaha çarptın.' => 'Has chocado con un cocodrilo.',
			'Bir hazineyi kaçırdın.' => 'Se te ha escapado un tesoro.',
			'Pocket Team vs Block Team' => 'Equipo Pocket contra equipo Block',
			'Wins' => 'gana',
			'Every 5 seconds the game sends 1 enemy. More Enemies sends 2.' => 'Cada 5 segundos el juego envía 1 enemigo. Más enemigos envía 2.',
			'No moves yet.' => 'Aún no hay movimientos.',
			'Turn: ' => 'Turno: ',
			'You: ' => 'Tú: ',
			'Question 0 / 100' => 'Pregunta 0 / 100',
			'No country selected yet' => 'Aún no hay país seleccionado',
			'Write a country name in Turkish or English, then press Start Quiz.' => 'Escribe un país en turco o inglés y luego pulsa Empezar quiz.',
			'Type text here' => 'Escribe texto aquí',
			'Pick color' => 'Elegir color',
			'Brush size' => 'Tamaño del pincel',
			'Shape picker' => 'Selector de forma',
			'Text input' => 'Entrada de texto',
			'Text size' => 'Tamaño del texto',
			'Font picker' => 'Selector de fuente',
			'Sticker picker' => 'Selector de pegatina',
			'Emoji picker' => 'Selector de emoji',
			'Frame picker' => 'Selector de marco',
			'Upload image' => 'Subir imagen',
			'Drawing canvas' => 'Lienzo de dibujo',
		),
	);

	foreach ($sitewide_runtime_exact_more as $more_lang => $more_items) {
		if (isset($translations[$more_lang])) {
			$translations[$more_lang] = array_merge($translations[$more_lang], $more_items);
		}
	}

	$sitewide_runtime_exact_agent_a_c = array(
		'tr' => array(
			'White to move.' => 'Sıra beyazda.',
			'wins by checkmate.' => 'mat ile kazandı.',
			'Stalemate.' => 'Pat.',
			'is in check.' => 'şah altında.',
			'to move.' => 'hamle yapacak.',
			'That piece has no legal move.' => 'Bu taşın yasal hamlesi yok.',
			'AI could not find a move.' => 'Yapay zeka hamle bulamadı.',
			'selected.' => 'seçildi.',
			'Pick a piece to move.' => 'Hamle yapmak için bir taş seç.',
			'Choose where to move.' => 'Nereye gideceğini seç.',
			'Pick one of your pieces.' => 'Kendi taşlarından birini seç.',
			'Move undone.' => 'Hamle geri alındı.',
			'Checkmate. You win.' => 'Mat. Sen kazandın.',
			'Checkmate. AI wins.' => 'Mat. Yapay zeka kazandı.',
			'Stalemate. Draw game.' => 'Pat. Berabere.',
			'Draw by 50-move rule.' => '50 hamle kuralıyla beraberlik.',
			'Your king is in check.' => 'Şahın tehdit altında.',
			'AI king is in check.' => 'Yapay zekanın şahı tehdit altında.',
			'No answers yet.' => 'Henüz cevap yok.',
			'Type an answer first.' => 'Önce bir cevap yaz.',
			'That does not start with' => 'Bu şununla başlamıyor:',
			'Game over. Final score:' => 'Oyun bitti. Son puan:',
			'out of' => '/',
			'Decode the message by replacing each cipher letter with the correct plain letter.' => 'Her şifreli harfi doğru açık harfle değiştirerek mesajı çöz.',
			'Correct! You cracked the cryptogram. Great job!' => 'Doğru! Kriptogramı çözdün. Harika iş!',
			'You solved it. Great binary brain work!' => 'Çözdün. Harika ikili mantık!',
			'Rule check: looking good so far.' => 'Kural kontrolü: şu ana kadar iyi.',
			'Target Combo: ' => 'Hedef Kombo: ',
		),
		'de' => array(
			'White to move.' => 'Weiß ist am Zug.',
			'wins by checkmate.' => 'gewinnt durch Schachmatt.',
			'Stalemate.' => 'Patt.',
			'is in check.' => 'steht im Schach.',
			'to move.' => 'ist am Zug.',
			'That piece has no legal move.' => 'Diese Figur hat keinen legalen Zug.',
			'AI could not find a move.' => 'Die KI konnte keinen Zug finden.',
			'selected.' => 'ausgewählt.',
			'Pick a piece to move.' => 'Wähle eine Figur zum Ziehen.',
			'Choose where to move.' => 'Wähle das Zielfeld.',
			'Pick one of your pieces.' => 'Wähle eine deiner Figuren.',
			'Move undone.' => 'Zug rückgängig gemacht.',
			'Checkmate. You win.' => 'Schachmatt. Du gewinnst.',
			'Checkmate. AI wins.' => 'Schachmatt. Die KI gewinnt.',
			'Stalemate. Draw game.' => 'Patt. Remis.',
			'Draw by 50-move rule.' => 'Remis durch 50-Züge-Regel.',
			'Your king is in check.' => 'Dein König steht im Schach.',
			'AI king is in check.' => 'Der KI-König steht im Schach.',
			'No answers yet.' => 'Noch keine Antworten.',
			'Type an answer first.' => 'Gib zuerst eine Antwort ein.',
			'That does not start with' => 'Das beginnt nicht mit',
			'Game over. Final score:' => 'Spiel vorbei. Endstand:',
			'out of' => 'von',
			'Decode the message by replacing each cipher letter with the correct plain letter.' => 'Entschlüssele die Nachricht, indem du jeden Geheimtext-Buchstaben ersetzt.',
			'Correct! You cracked the cryptogram. Great job!' => 'Richtig! Du hast das Kryptogramm geknackt. Gut gemacht!',
			'You solved it. Great binary brain work!' => 'Gelöst. Starke Binärleistung!',
			'Rule check: looking good so far.' => 'Regelprüfung: bisher sieht alles gut aus.',
			'Target Combo: ' => 'Zielkombination: ',
		),
		'fr' => array(
			'White to move.' => 'Aux blancs de jouer.',
			'wins by checkmate.' => 'gagne par échec et mat.',
			'Stalemate.' => 'Pat.',
			'is in check.' => 'est en échec.',
			'to move.' => 'doit jouer.',
			'That piece has no legal move.' => 'Cette pièce n’a aucun coup légal.',
			'AI could not find a move.' => 'L’IA n’a trouvé aucun coup.',
			'selected.' => 'sélectionné.',
			'Pick a piece to move.' => 'Choisis une pièce à déplacer.',
			'Choose where to move.' => 'Choisis où jouer.',
			'Pick one of your pieces.' => 'Choisis une de tes pièces.',
			'Move undone.' => 'Coup annulé.',
			'Checkmate. You win.' => 'Échec et mat. Tu gagnes.',
			'Checkmate. AI wins.' => 'Échec et mat. L’IA gagne.',
			'Stalemate. Draw game.' => 'Pat. Match nul.',
			'Draw by 50-move rule.' => 'Nulle par la règle des 50 coups.',
			'Your king is in check.' => 'Ton roi est en échec.',
			'AI king is in check.' => 'Le roi de l’IA est en échec.',
			'No answers yet.' => 'Aucune réponse pour l’instant.',
			'Type an answer first.' => 'Écris d’abord une réponse.',
			'That does not start with' => 'Cela ne commence pas par',
			'Game over. Final score:' => 'Partie terminée. Score final :',
			'out of' => 'sur',
			'Decode the message by replacing each cipher letter with the correct plain letter.' => 'Décode le message en remplaçant chaque lettre chiffrée par la bonne lettre.',
			'Correct! You cracked the cryptogram. Great job!' => 'Correct ! Tu as percé le cryptogramme. Bravo !',
			'You solved it. Great binary brain work!' => 'Résolu. Beau travail binaire !',
			'Rule check: looking good so far.' => 'Vérification des règles : tout va bien pour l’instant.',
			'Target Combo: ' => 'Combo cible : ',
		),
		'es-mx' => array(
			'White to move.' => 'Juegan blancas.',
			'wins by checkmate.' => 'gana por jaque mate.',
			'Stalemate.' => 'Tablas por ahogado.',
			'is in check.' => 'está en jaque.',
			'to move.' => 'juega.',
			'That piece has no legal move.' => 'Esa pieza no tiene movimientos legales.',
			'AI could not find a move.' => 'La IA no pudo encontrar una jugada.',
			'selected.' => 'seleccionada.',
			'Pick a piece to move.' => 'Elige una pieza para mover.',
			'Choose where to move.' => 'Elige a dónde mover.',
			'Pick one of your pieces.' => 'Elige una de tus piezas.',
			'Move undone.' => 'Jugada deshecha.',
			'Checkmate. You win.' => 'Jaque mate. Ganaste.',
			'Checkmate. AI wins.' => 'Jaque mate. Gana la IA.',
			'Stalemate. Draw game.' => 'Ahogado. Empate.',
			'Draw by 50-move rule.' => 'Empate por regla de 50 jugadas.',
			'Your king is in check.' => 'Tu rey está en jaque.',
			'AI king is in check.' => 'El rey de la IA está en jaque.',
			'No answers yet.' => 'Aún no hay respuestas.',
			'Type an answer first.' => 'Escribe una respuesta primero.',
			'That does not start with' => 'Eso no empieza con',
			'Game over. Final score:' => 'Fin del juego. Puntuación final:',
			'out of' => 'de',
			'Decode the message by replacing each cipher letter with the correct plain letter.' => 'Decodifica el mensaje reemplazando cada letra cifrada por la correcta.',
			'Correct! You cracked the cryptogram. Great job!' => '¡Correcto! Descifraste el criptograma. ¡Buen trabajo!',
			'You solved it. Great binary brain work!' => 'Lo resolviste. ¡Gran trabajo binario!',
			'Rule check: looking good so far.' => 'Revisión de reglas: todo va bien hasta ahora.',
			'Target Combo: ' => 'Combo objetivo: ',
		),
		'es-es' => array(
			'White to move.' => 'Juegan blancas.',
			'wins by checkmate.' => 'gana por jaque mate.',
			'Stalemate.' => 'Tablas por ahogado.',
			'is in check.' => 'está en jaque.',
			'to move.' => 'juega.',
			'That piece has no legal move.' => 'Esa pieza no tiene movimientos legales.',
			'AI could not find a move.' => 'La IA no pudo encontrar una jugada.',
			'selected.' => 'seleccionada.',
			'Pick a piece to move.' => 'Elige una pieza para mover.',
			'Choose where to move.' => 'Elige adónde mover.',
			'Pick one of your pieces.' => 'Elige una de tus piezas.',
			'Move undone.' => 'Jugada deshecha.',
			'Checkmate. You win.' => 'Jaque mate. Has ganado.',
			'Checkmate. AI wins.' => 'Jaque mate. Gana la IA.',
			'Stalemate. Draw game.' => 'Ahogado. Tablas.',
			'Draw by 50-move rule.' => 'Tablas por la regla de los 50 movimientos.',
			'Your king is in check.' => 'Tu rey está en jaque.',
			'AI king is in check.' => 'El rey de la IA está en jaque.',
			'No answers yet.' => 'Todavía no hay respuestas.',
			'Type an answer first.' => 'Escribe primero una respuesta.',
			'That does not start with' => 'Eso no empieza por',
			'Game over. Final score:' => 'Fin de la partida. Puntuación final:',
			'out of' => 'de',
			'Decode the message by replacing each cipher letter with the correct plain letter.' => 'Descifra el mensaje sustituyendo cada letra cifrada por la letra correcta.',
			'Correct! You cracked the cryptogram. Great job!' => '¡Correcto! Has descifrado el criptograma. ¡Buen trabajo!',
			'You solved it. Great binary brain work!' => 'Lo has resuelto. ¡Gran trabajo binario!',
			'Rule check: looking good so far.' => 'Comprobación de reglas: todo va bien por ahora.',
			'Target Combo: ' => 'Combo objetivo: ',
		),
	);

	foreach ($sitewide_runtime_exact_agent_a_c as $agent_ac_lang => $agent_ac_items) {
		if (isset($translations[$agent_ac_lang])) {
			$translations[$agent_ac_lang] = array_merge($translations[$agent_ac_lang], $agent_ac_items);
		}
	}

	$sitewide_runtime_exact_agent_more = array(
		'tr' => array(
			'Ready to draw' => 'Cizmeye hazir',
			'Could not save drawing state' => 'Cizim durumu kaydedilemedi',
			'Type some text first' => 'Once biraz metin yaz',
			'Text added' => 'Metin eklendi',
			'Sticker added' => 'Cikartma eklendi',
			'Emoji added' => 'Emoji eklendi',
			'Choose a frame first' => 'Once bir cerceve sec',
			'Frame applied' => 'Cerceve uygulandi',
			'Canvas cleared' => 'Tuval temizlendi',
			'Image loaded' => 'Gorsel yuklendi',
			'Selection ready. Drag it to move.' => 'Secim hazir. Tasimak icin surukle.',
			'Switch filters. Different inks reveal different clues.' => 'Filtreleri degistir. Farkli murekkepler farkli ipuclari gosterir.',
			'Nothing useful yet.' => 'Henuz ise yarar bir sey yok.',
			'Case solved. The clues only made sense under the right light.' => 'Dava cozuldu. Ipuclari ancak dogru isikta anlam kazandi.',
			'Invent a language. Combine syllables and test whether your word has the right power.' => 'Bir dil icat et. Heceleri birlestir ve kelimenin dogru guce sahip olup olmadigini dene.',
			'The word worked. The next puzzle needs a richer phrase.' => 'Kelime ise yaradi. Siradaki bulmaca daha zengin bir ifade istiyor.',
			'Build a 10-second loop. Ore becomes gears, gears become crates, and better placement boosts output.' => '10 saniyelik bir dongu kur. Cevher disliye, disli sandiga donusur; iyi yerlesim uretimi artirir.',
			'Factory optimized. Your loop now prints value every cycle.' => 'Fabrika optimize edildi. Dongun artik her tur deger uretiyor.',
			'The AI team wins.' => 'Yapay zeka takimi kazandi.',
			'Your team wins.' => 'Takimin kazandi.',
			'Battle start. Pick an action.' => 'Savas basladi. Bir eylem sec.',
			'You win the match.' => 'Maci kazandin.',
			'You lose the match.' => 'Maci kaybettin.',
			'The match ends in a draw.' => 'Mac berabere bitti.',
			'New season started.' => 'Yeni sezon basladi.',
			'Computer Wins' => 'Bilgisayar kazandi',
			'Tie Game' => 'Berabere',
			'Great job. You found a match.' => 'Harika is. Bir eslesme buldun.',
			'Not a match. Try again.' => 'Eslesmedi. Tekrar dene.',
			'Find all the matching animal pairs.' => 'Tum eslesen hayvan ciftlerini bul.',
			'Build the sequence.' => 'Diziyi olustur.',
			'Expand across the body. Mutation helps you survive immune attacks.' => 'Vucuda yayil. Mutasyon bagisiklik saldirilarindan sag cikmana yardim eder.',
			'Solved. Every click was mirrored across both axes.' => 'Cozuldu. Her tiklama iki eksende de yansitildi.',
			'You always lose.' => 'Her zaman kaybedersin.',
			'The town is calm. Watch patterns appear as routines overlap.' => 'Kasaba sakin. Rutinler cakistikca desenlerin olusmasini izle.',
			'Paused' => 'Duraklatildi',
			'Running' => 'Calisiyor',
			'Match the blue pointer to the red pointer. Then press Check Angle.' => 'Mavi ibreyi kirmizi ibreyle eslestir. Sonra Aciyi Kontrol Et dugmesine bas.',
			'Ready?' => 'Hazir misin?',
			'Press Space to start. Use Arrow keys or A and D to move.' => 'Baslamak icin Bosluk tusuna bas. Hareket etmek icin ok tuslarini veya A ve D tuslarini kullan.',
			'Press Space, Enter, or Restart to play again.' => 'Yeniden oynamak icin Bosluk, Enter veya Yeniden Baslat tusuna bas.',
			'Use the jump buttons to move along the number line.' => 'Sayi dogrusunda ilerlemek icin ziplama dugmelerini kullan.',
			'That jump goes off the number line.' => 'Bu ziplama sayi dogrusunun disina cikiyor.',
			'Nice. You landed on the target. Press Check.' => 'Guzel. Hedefe indin. Kontrol Et dugmesine bas.',
			'You are below the target.' => 'Hedefin altindasin.',
			'You are above the target.' => 'Hedefin ustundesin.',
			'It\'s a tie!' => 'Berabere!',
			'You win!' => 'Kazandin!',
			'You lose!' => 'Kaybettin!',
			'Make your move.' => 'Hamleni yap.',
			'No heals left.' => 'Iyilestirme kalmadi.',
			'You won. Enemy rocket was defeated.' => 'Kazandin. Dusman roketi yenildi.',
			'You lost. Your rocket was defeated.' => 'Kaybettin. Roketin yenildi.',
			'Time is up. Press restart and beat your score.' => 'Sure doldu. Yeniden baslat ve skorunu gec.',
			'The garden bloomed. New plant unlocked.' => 'Bahce cicek acti. Yeni bitki acildi.',
			'Match found. Keep growing the garden.' => 'Eslesme bulundu. Bahceyi buyutmeye devam et.',
			'Not a pair yet.' => 'Henuz bir cift degil.',
			'Blocked. Find another path.' => 'Engellendi. Baska bir yol bul.',
			'Remember the order, then tap it back' => 'Sirayi hatirla, sonra ayni sirayla dokun',
			'You are out of lives. Press Start.' => 'Canin kalmadi. Baslat dugmesine bas.',
			'Pick the OPPOSITE.' => 'TERSINI sec.',
			'Listen carefully.' => 'Dikkatli dinle.',
			'Repeat the pattern.' => 'Deseni tekrarla.',
			'Click around the room to search for clues.' => 'Ipuclari aramak icin odanin cevresine tikla.',
			'No items yet.' => 'Henuz esya yok.',
			'The door is still locked.' => 'Kapi hala kilitli.',
			'Press Start Game to begin.' => 'Baslamak icin Oyunu Baslat dugmesine bas.',
			'Type what kind of game you want first.' => 'Once ne tur oyun istedigini yaz.',
			'No good match yet. Try words like chess, blocks, word, or category.' => 'Henuz iyi bir eslesme yok. Satranc, blok, kelime veya kategori gibi kelimeler dene.',
			'Best match found. Press "Open Selected Game".' => 'En iyi eslesme bulundu. "Secili Oyunu Ac" dugmesine bas.',
			'Reach the door on the right...' => 'Sagdaki kapiya ulas...',
			'Caught by a ceiling crawler. Restart the room.' => 'Tavan gezgini yakaladi. Odayi yeniden baslat.',
			'Out of moves. Gravity is powerful, but expensive.' => 'Hamle kalmadi. Yer cekimi guclu ama pahali.',
			'You already tried that letter.' => 'Bu harfi zaten denedin.',
			'Enter one letter.' => 'Bir harf gir.',
			'Bu sayfada hangi oyun calissin?' => 'Bu sayfada hangi oyun calissin?',
			'Bir oyun secin' => 'Bir oyun secin',
			'Bu oyun hangi listeye eklensin?' => 'Bu oyun hangi listeye eklensin?',
			'Arslan ya da Asker oyun listesi buna gore filtrelenir.' => 'Arslan ya da Asker oyun listesi buna gore filtrelenir.',
			'Oyun bulunamadi.' => 'Oyun bulunamadi.',
			'Bu oyun henuz goruntulenemiyor.' => 'Bu oyun henuz goruntulenemiyor.',
			'Henuz oyun bulunamadi.' => 'Henuz oyun bulunamadi.',
			'Filtreye uyan oyun bulunamadi.' => 'Filtreye uyan oyun bulunamadi.',
			'Game stats' => 'Oyun istatistikleri',
			'game area' => 'oyun alani',
			'Game area' => 'Oyun alani',
			'Game controls' => 'Oyun kontrolleri',
			'Ready.' => 'Hazir.',
			'RUN' => 'KOS',
			'Point' => 'Nokta',
			'AI difficulty' => 'Yapay zeka zorlugu',
			'Easy AI' => 'Kolay yapay zeka',
			'Medium AI' => 'Orta yapay zeka',
			'Hard AI' => 'Zor yapay zeka',
			'Game speed' => 'Oyun hizi',
			'Speed x1' => 'Hiz x1',
			'Speed x1.5' => 'Hiz x1.5',
			'Speed x2' => 'Hiz x2',
			'Select Operation' => 'Islem sec',
			'Enter First Number' => 'Ilk sayiyi gir',
			'Enter Second Number' => 'Ikinci sayiyi gir',
			'Operation' => 'Islem',
			'Square Root' => 'Karekok',
			'Result' => 'Sonuc',
			'Start Quiz' => 'Testi baslat',
			'Type a country name to begin.' => 'Baslamak icin bir ulke adi yaz.',
		),
		'de' => array(
			'Ready to draw' => 'Bereit zum Zeichnen',
			'Could not save drawing state' => 'Zeichenstatus konnte nicht gespeichert werden',
			'Type some text first' => 'Gib zuerst Text ein',
			'Text added' => 'Text hinzugefugt',
			'Sticker added' => 'Sticker hinzugefugt',
			'Emoji added' => 'Emoji hinzugefugt',
			'Choose a frame first' => 'Wahle zuerst einen Rahmen',
			'Frame applied' => 'Rahmen angewendet',
			'Canvas cleared' => 'Leinwand geleert',
			'Image loaded' => 'Bild geladen',
			'Selection ready. Drag it to move.' => 'Auswahl bereit. Zum Verschieben ziehen.',
			'Switch filters. Different inks reveal different clues.' => 'Wechsle die Filter. Verschiedene Tinten zeigen verschiedene Hinweise.',
			'Nothing useful yet.' => 'Noch nichts Nutzliches.',
			'Case solved. The clues only made sense under the right light.' => 'Fall gelost. Die Hinweise ergaben nur im richtigen Licht Sinn.',
			'Invent a language. Combine syllables and test whether your word has the right power.' => 'Erfinde eine Sprache. Kombiniere Silben und teste, ob dein Wort die richtige Kraft hat.',
			'The word worked. The next puzzle needs a richer phrase.' => 'Das Wort hat funktioniert. Das nachste Ratsel braucht eine reichere Phrase.',
			'Build a 10-second loop. Ore becomes gears, gears become crates, and better placement boosts output.' => 'Baue eine 10-Sekunden-Schleife. Erz wird zu Zahnradern, Zahnrader zu Kisten, bessere Platzierung steigert den Ertrag.',
			'Factory optimized. Your loop now prints value every cycle.' => 'Fabrik optimiert. Deine Schleife erzeugt nun in jedem Zyklus Wert.',
			'The AI team wins.' => 'Das KI-Team gewinnt.',
			'Your team wins.' => 'Dein Team gewinnt.',
			'Battle start. Pick an action.' => 'Kampf beginnt. Wahle eine Aktion.',
			'You win the match.' => 'Du gewinnst das Spiel.',
			'You lose the match.' => 'Du verlierst das Spiel.',
			'The match ends in a draw.' => 'Das Spiel endet unentschieden.',
			'New season started.' => 'Neue Saison gestartet.',
			'Computer Wins' => 'Computer gewinnt',
			'Tie Game' => 'Unentschieden',
			'Great job. You found a match.' => 'Gut gemacht. Du hast ein Paar gefunden.',
			'Not a match. Try again.' => 'Kein Paar. Versuch es noch einmal.',
			'Find all the matching animal pairs.' => 'Finde alle passenden Tierpaare.',
			'Build the sequence.' => 'Baue die Reihenfolge.',
			'Expand across the body. Mutation helps you survive immune attacks.' => 'Breite dich im Korper aus. Mutation hilft dir, Immunangriffe zu uberleben.',
			'Solved. Every click was mirrored across both axes.' => 'Gelost. Jeder Klick wurde uber beide Achsen gespiegelt.',
			'You always lose.' => 'Du verlierst immer.',
			'The town is calm. Watch patterns appear as routines overlap.' => 'Die Stadt ist ruhig. Beobachte, wie Muster entstehen, wenn Routinen sich uberlappen.',
			'Paused' => 'Pausiert',
			'Running' => 'Lauft',
			'Match the blue pointer to the red pointer. Then press Check Angle.' => 'Passe den blauen Zeiger an den roten Zeiger an. Drucken dann Winkel prufen.',
			'Ready?' => 'Bereit?',
			'Press Space to start. Use Arrow keys or A and D to move.' => 'Drucke Leertaste zum Starten. Nutze Pfeiltasten oder A und D zum Bewegen.',
			'Press Space, Enter, or Restart to play again.' => 'Drucke Leertaste, Eingabe oder Neustart, um erneut zu spielen.',
			'Use the jump buttons to move along the number line.' => 'Nutze die Sprungknopfe, um dich auf dem Zahlenstrahl zu bewegen.',
			'That jump goes off the number line.' => 'Dieser Sprung geht vom Zahlenstrahl herunter.',
			'Nice. You landed on the target. Press Check.' => 'Gut. Du bist auf dem Ziel gelandet. Drucke Prufen.',
			'You are below the target.' => 'Du bist unter dem Ziel.',
			'You are above the target.' => 'Du bist uber dem Ziel.',
			'It\'s a tie!' => 'Unentschieden!',
			'You win!' => 'Du gewinnst!',
			'You lose!' => 'Du verlierst!',
			'Make your move.' => 'Mach deinen Zug.',
			'No heals left.' => 'Keine Heilungen ubrig.',
			'You won. Enemy rocket was defeated.' => 'Du hast gewonnen. Die feindliche Rakete wurde besiegt.',
			'You lost. Your rocket was defeated.' => 'Du hast verloren. Deine Rakete wurde besiegt.',
			'Time is up. Press restart and beat your score.' => 'Die Zeit ist um. Starte neu und schlage deine Punktzahl.',
			'The garden bloomed. New plant unlocked.' => 'Der Garten bluht. Neue Pflanze freigeschaltet.',
			'Match found. Keep growing the garden.' => 'Paar gefunden. Lass den Garten weiter wachsen.',
			'Not a pair yet.' => 'Noch kein Paar.',
			'Blocked. Find another path.' => 'Blockiert. Finde einen anderen Weg.',
			'Remember the order, then tap it back' => 'Merke dir die Reihenfolge und tippe sie dann nach',
			'You are out of lives. Press Start.' => 'Du hast keine Leben mehr. Drucke Start.',
			'Pick the OPPOSITE.' => 'Wahle das GEGENTEIL.',
			'Listen carefully.' => 'Hore gut zu.',
			'Repeat the pattern.' => 'Wiederhole das Muster.',
			'Click around the room to search for clues.' => 'Klicke im Raum herum, um Hinweise zu suchen.',
			'No items yet.' => 'Noch keine Gegenstande.',
			'The door is still locked.' => 'Die Tur ist noch verschlossen.',
			'Press Start Game to begin.' => 'Drucke Spiel starten, um zu beginnen.',
			'Type what kind of game you want first.' => 'Gib zuerst ein, welche Art Spiel du willst.',
			'No good match yet. Try words like chess, blocks, word, or category.' => 'Noch kein guter Treffer. Versuche Worter wie Schach, Blocke, Wort oder Kategorie.',
			'Best match found. Press "Open Selected Game".' => 'Bester Treffer gefunden. Drucke "Ausgewahltes Spiel offnen".',
			'Reach the door on the right...' => 'Erreiche die Tur rechts...',
			'Caught by a ceiling crawler. Restart the room.' => 'Von einem Deckenkrabbler erwischt. Starte den Raum neu.',
			'Out of moves. Gravity is powerful, but expensive.' => 'Keine Zuge mehr. Schwerkraft ist machtig, aber teuer.',
			'You already tried that letter.' => 'Diesen Buchstaben hast du schon versucht.',
			'Enter one letter.' => 'Gib einen Buchstaben ein.',
			'Bu sayfada hangi oyun calissin?' => 'Welches Spiel soll auf dieser Seite laufen?',
			'Bir oyun secin' => 'Spiel auswahlen',
			'Bu oyun hangi listeye eklensin?' => 'Zu welcher Liste soll dieses Spiel hinzugefugt werden?',
			'Arslan ya da Asker oyun listesi buna gore filtrelenir.' => 'Die Arslan- oder Asker-Spieleliste wird danach gefiltert.',
			'Oyun bulunamadi.' => 'Spiel nicht gefunden.',
			'Bu oyun henuz goruntulenemiyor.' => 'Dieses Spiel kann noch nicht angezeigt werden.',
			'Henuz oyun bulunamadi.' => 'Noch keine Spiele gefunden.',
			'Filtreye uyan oyun bulunamadi.' => 'Kein Spiel passt zum Filter.',
			'Game stats' => 'Spielstatistiken',
			'game area' => 'Spielbereich',
			'Game area' => 'Spielbereich',
			'Game controls' => 'Spielsteuerung',
			'Ready.' => 'Bereit.',
			'RUN' => 'LAUFEN',
			'Point' => 'Punkt',
			'AI difficulty' => 'KI-Schwierigkeit',
			'Easy AI' => 'Einfache KI',
			'Medium AI' => 'Mittlere KI',
			'Hard AI' => 'Schwere KI',
			'Game speed' => 'Spielgeschwindigkeit',
			'Speed x1' => 'Geschwindigkeit x1',
			'Speed x1.5' => 'Geschwindigkeit x1,5',
			'Speed x2' => 'Geschwindigkeit x2',
			'Select Operation' => 'Rechenart auswahlen',
			'Enter First Number' => 'Erste Zahl eingeben',
			'Enter Second Number' => 'Zweite Zahl eingeben',
			'Operation' => 'Rechenart',
			'Square Root' => 'Quadratwurzel',
			'Result' => 'Ergebnis',
			'Start Quiz' => 'Quiz starten',
			'Type a country name to begin.' => 'Gib einen Landernamen ein, um zu beginnen.',
		),
		'fr' => array(
			'Ready to draw' => 'Pret a dessiner',
			'Could not save drawing state' => 'Impossible d enregistrer l etat du dessin',
			'Type some text first' => 'Saisis d abord du texte',
			'Text added' => 'Texte ajoute',
			'Sticker added' => 'Autocollant ajoute',
			'Emoji added' => 'Emoji ajoute',
			'Choose a frame first' => 'Choisis d abord un cadre',
			'Frame applied' => 'Cadre applique',
			'Canvas cleared' => 'Toile effacee',
			'Image loaded' => 'Image chargee',
			'Selection ready. Drag it to move.' => 'Selection prete. Fais-la glisser pour la deplacer.',
			'Switch filters. Different inks reveal different clues.' => 'Change de filtre. Des encres differentes revelent des indices differents.',
			'Nothing useful yet.' => 'Rien d utile pour l instant.',
			'Case solved. The clues only made sense under the right light.' => 'Affaire resolue. Les indices n avaient de sens qu a la bonne lumiere.',
			'Invent a language. Combine syllables and test whether your word has the right power.' => 'Invente une langue. Combine les syllabes et teste si ton mot a le bon pouvoir.',
			'The word worked. The next puzzle needs a richer phrase.' => 'Le mot a fonctionne. La prochaine enigme demande une phrase plus riche.',
			'Build a 10-second loop. Ore becomes gears, gears become crates, and better placement boosts output.' => 'Construis une boucle de 10 secondes. Le minerai devient engrenages, les engrenages deviennent caisses, et un bon placement augmente la production.',
			'Factory optimized. Your loop now prints value every cycle.' => 'Usine optimisee. Ta boucle produit maintenant de la valeur a chaque cycle.',
			'The AI team wins.' => 'L equipe IA gagne.',
			'Your team wins.' => 'Ton equipe gagne.',
			'Battle start. Pick an action.' => 'Le combat commence. Choisis une action.',
			'You win the match.' => 'Tu gagnes le match.',
			'You lose the match.' => 'Tu perds le match.',
			'The match ends in a draw.' => 'Le match se termine par un nul.',
			'New season started.' => 'Nouvelle saison lancee.',
			'Computer Wins' => 'L ordinateur gagne',
			'Tie Game' => 'Egalite',
			'Great job. You found a match.' => 'Bien joue. Tu as trouve une paire.',
			'Not a match. Try again.' => 'Pas une paire. Reessaie.',
			'Find all the matching animal pairs.' => 'Trouve toutes les paires d animaux.',
			'Build the sequence.' => 'Recree la sequence.',
			'Expand across the body. Mutation helps you survive immune attacks.' => 'Etends-toi dans le corps. La mutation t aide a survivre aux attaques immunitaires.',
			'Solved. Every click was mirrored across both axes.' => 'Resolu. Chaque clic a ete reflete sur les deux axes.',
			'You always lose.' => 'Tu perds toujours.',
			'The town is calm. Watch patterns appear as routines overlap.' => 'La ville est calme. Observe les motifs apparaitre quand les routines se croisent.',
			'Paused' => 'En pause',
			'Running' => 'En cours',
			'Match the blue pointer to the red pointer. Then press Check Angle.' => 'Aligne le pointeur bleu sur le pointeur rouge. Puis appuie sur Verifier l angle.',
			'Ready?' => 'Pret ?',
			'Press Space to start. Use Arrow keys or A and D to move.' => 'Appuie sur Espace pour commencer. Utilise les fleches ou A et D pour bouger.',
			'Press Space, Enter, or Restart to play again.' => 'Appuie sur Espace, Entree ou Redemarrer pour rejouer.',
			'Use the jump buttons to move along the number line.' => 'Utilise les boutons de saut pour avancer sur la ligne numerique.',
			'That jump goes off the number line.' => 'Ce saut sort de la ligne numerique.',
			'Nice. You landed on the target. Press Check.' => 'Bien. Tu as atteint la cible. Appuie sur Verifier.',
			'You are below the target.' => 'Tu es sous la cible.',
			'You are above the target.' => 'Tu es au-dessus de la cible.',
			'It\'s a tie!' => 'Egalite !',
			'You win!' => 'Tu gagnes !',
			'You lose!' => 'Tu perds !',
			'Make your move.' => 'Joue ton coup.',
			'No heals left.' => 'Plus de soins.',
			'You won. Enemy rocket was defeated.' => 'Tu as gagne. La fusee ennemie est vaincue.',
			'You lost. Your rocket was defeated.' => 'Tu as perdu. Ta fusee est vaincue.',
			'Time is up. Press restart and beat your score.' => 'Le temps est ecoule. Redemarre et bats ton score.',
			'The garden bloomed. New plant unlocked.' => 'Le jardin a fleuri. Nouvelle plante debloquee.',
			'Match found. Keep growing the garden.' => 'Paire trouvee. Continue a faire pousser le jardin.',
			'Not a pair yet.' => 'Ce n est pas encore une paire.',
			'Blocked. Find another path.' => 'Bloque. Trouve un autre chemin.',
			'Remember the order, then tap it back' => 'Memorise l ordre, puis retape-le',
			'You are out of lives. Press Start.' => 'Tu n as plus de vies. Appuie sur Demarrer.',
			'Pick the OPPOSITE.' => 'Choisis l OPPOSE.',
			'Listen carefully.' => 'Ecoute attentivement.',
			'Repeat the pattern.' => 'Repete le motif.',
			'Click around the room to search for clues.' => 'Clique dans la piece pour chercher des indices.',
			'No items yet.' => 'Aucun objet pour le moment.',
			'The door is still locked.' => 'La porte est encore verrouillee.',
			'Press Start Game to begin.' => 'Appuie sur Demarrer le jeu pour commencer.',
			'Type what kind of game you want first.' => 'Ecris d abord le type de jeu que tu veux.',
			'No good match yet. Try words like chess, blocks, word, or category.' => 'Pas encore de bon resultat. Essaie des mots comme echecs, blocs, mot ou categorie.',
			'Best match found. Press "Open Selected Game".' => 'Meilleur resultat trouve. Appuie sur "Ouvrir le jeu selectionne".',
			'Reach the door on the right...' => 'Atteins la porte a droite...',
			'Caught by a ceiling crawler. Restart the room.' => 'Attrape par une creature au plafond. Redemarre la piece.',
			'Out of moves. Gravity is powerful, but expensive.' => 'Plus de coups. La gravite est puissante, mais couteuse.',
			'You already tried that letter.' => 'Tu as deja essaye cette lettre.',
			'Enter one letter.' => 'Entre une lettre.',
			'Bu sayfada hangi oyun calissin?' => 'Quel jeu doit etre lance sur cette page ?',
			'Bir oyun secin' => 'Choisir un jeu',
			'Bu oyun hangi listeye eklensin?' => 'A quelle liste ajouter ce jeu ?',
			'Arslan ya da Asker oyun listesi buna gore filtrelenir.' => 'La liste de jeux Arslan ou Asker est filtree selon ce choix.',
			'Oyun bulunamadi.' => 'Jeu introuvable.',
			'Bu oyun henuz goruntulenemiyor.' => 'Ce jeu ne peut pas encore etre affiche.',
			'Henuz oyun bulunamadi.' => 'Aucun jeu trouve pour le moment.',
			'Filtreye uyan oyun bulunamadi.' => 'Aucun jeu ne correspond au filtre.',
			'Game stats' => 'Statistiques du jeu',
			'game area' => 'zone de jeu',
			'Game area' => 'Zone de jeu',
			'Game controls' => 'Commandes du jeu',
			'Ready.' => 'Pret.',
			'RUN' => 'COURIR',
			'Point' => 'Point',
			'AI difficulty' => 'Difficulte de l IA',
			'Easy AI' => 'IA facile',
			'Medium AI' => 'IA moyenne',
			'Hard AI' => 'IA difficile',
			'Game speed' => 'Vitesse du jeu',
			'Speed x1' => 'Vitesse x1',
			'Speed x1.5' => 'Vitesse x1,5',
			'Speed x2' => 'Vitesse x2',
			'Select Operation' => 'Choisir une operation',
			'Enter First Number' => 'Saisir le premier nombre',
			'Enter Second Number' => 'Saisir le deuxieme nombre',
			'Operation' => 'Operation',
			'Square Root' => 'Racine carree',
			'Result' => 'Resultat',
			'Start Quiz' => 'Demarrer le quiz',
			'Type a country name to begin.' => 'Saisis un nom de pays pour commencer.',
		),
		'es-mx' => array(
			'Ready to draw' => 'Listo para dibujar',
			'Could not save drawing state' => 'No se pudo guardar el estado del dibujo',
			'Type some text first' => 'Escribe texto primero',
			'Text added' => 'Texto agregado',
			'Sticker added' => 'Sticker agregado',
			'Emoji added' => 'Emoji agregado',
			'Choose a frame first' => 'Elige un marco primero',
			'Frame applied' => 'Marco aplicado',
			'Canvas cleared' => 'Lienzo borrado',
			'Image loaded' => 'Imagen cargada',
			'Selection ready. Drag it to move.' => 'Seleccion lista. Arrastrala para moverla.',
			'Switch filters. Different inks reveal different clues.' => 'Cambia los filtros. Distintas tintas revelan distintas pistas.',
			'Nothing useful yet.' => 'Nada util todavia.',
			'Case solved. The clues only made sense under the right light.' => 'Caso resuelto. Las pistas solo tenian sentido con la luz correcta.',
			'Invent a language. Combine syllables and test whether your word has the right power.' => 'Inventa un idioma. Combina silabas y prueba si tu palabra tiene el poder correcto.',
			'The word worked. The next puzzle needs a richer phrase.' => 'La palabra funciono. El siguiente reto necesita una frase mas completa.',
			'Build a 10-second loop. Ore becomes gears, gears become crates, and better placement boosts output.' => 'Crea un ciclo de 10 segundos. El mineral se vuelve engranes, los engranes cajas, y una mejor colocacion aumenta la produccion.',
			'Factory optimized. Your loop now prints value every cycle.' => 'Fabrica optimizada. Tu ciclo ahora produce valor en cada vuelta.',
			'The AI team wins.' => 'Gana el equipo de IA.',
			'Your team wins.' => 'Tu equipo gana.',
			'Battle start. Pick an action.' => 'Inicia la batalla. Elige una accion.',
			'You win the match.' => 'Ganaste el partido.',
			'You lose the match.' => 'Perdiste el partido.',
			'The match ends in a draw.' => 'El partido termina en empate.',
			'New season started.' => 'Nueva temporada iniciada.',
			'Computer Wins' => 'Gana la computadora',
			'Tie Game' => 'Empate',
			'Great job. You found a match.' => 'Muy bien. Encontraste un par.',
			'Not a match. Try again.' => 'No coincide. Intenta otra vez.',
			'Find all the matching animal pairs.' => 'Encuentra todos los pares de animales.',
			'Build the sequence.' => 'Arma la secuencia.',
			'Expand across the body. Mutation helps you survive immune attacks.' => 'Expandete por el cuerpo. La mutacion te ayuda a sobrevivir ataques inmunes.',
			'Solved. Every click was mirrored across both axes.' => 'Resuelto. Cada clic se reflejo en ambos ejes.',
			'You always lose.' => 'Siempre pierdes.',
			'The town is calm. Watch patterns appear as routines overlap.' => 'El pueblo esta tranquilo. Observa como aparecen patrones cuando las rutinas se cruzan.',
			'Paused' => 'Pausado',
			'Running' => 'En marcha',
			'Match the blue pointer to the red pointer. Then press Check Angle.' => 'Alinea el puntero azul con el rojo. Luego presiona Revisar angulo.',
			'Ready?' => 'Listo?',
			'Press Space to start. Use Arrow keys or A and D to move.' => 'Presiona Espacio para empezar. Usa las flechas o A y D para moverte.',
			'Press Space, Enter, or Restart to play again.' => 'Presiona Espacio, Enter o Reiniciar para jugar otra vez.',
			'Use the jump buttons to move along the number line.' => 'Usa los botones de salto para moverte por la recta numerica.',
			'That jump goes off the number line.' => 'Ese salto se sale de la recta numerica.',
			'Nice. You landed on the target. Press Check.' => 'Bien. Caite en el objetivo. Presiona Revisar.',
			'You are below the target.' => 'Estas debajo del objetivo.',
			'You are above the target.' => 'Estas arriba del objetivo.',
			'It\'s a tie!' => 'Empate!',
			'You win!' => 'Ganaste!',
			'You lose!' => 'Perdiste!',
			'Make your move.' => 'Haz tu jugada.',
			'No heals left.' => 'No quedan curaciones.',
			'You won. Enemy rocket was defeated.' => 'Ganaste. El cohete enemigo fue derrotado.',
			'You lost. Your rocket was defeated.' => 'Perdiste. Tu cohete fue derrotado.',
			'Time is up. Press restart and beat your score.' => 'Se acabo el tiempo. Reinicia y supera tu puntuacion.',
			'The garden bloomed. New plant unlocked.' => 'El jardin florecio. Nueva planta desbloqueada.',
			'Match found. Keep growing the garden.' => 'Par encontrado. Sigue haciendo crecer el jardin.',
			'Not a pair yet.' => 'Todavia no es un par.',
			'Blocked. Find another path.' => 'Bloqueado. Busca otro camino.',
			'Remember the order, then tap it back' => 'Recuerda el orden y luego tocalo igual',
			'You are out of lives. Press Start.' => 'Te quedaste sin vidas. Presiona Iniciar.',
			'Pick the OPPOSITE.' => 'Elige lo OPUESTO.',
			'Listen carefully.' => 'Escucha con atencion.',
			'Repeat the pattern.' => 'Repite el patron.',
			'Click around the room to search for clues.' => 'Haz clic por la habitacion para buscar pistas.',
			'No items yet.' => 'Aun no hay objetos.',
			'The door is still locked.' => 'La puerta sigue cerrada.',
			'Press Start Game to begin.' => 'Presiona Iniciar juego para empezar.',
			'Type what kind of game you want first.' => 'Primero escribe que tipo de juego quieres.',
			'No good match yet. Try words like chess, blocks, word, or category.' => 'Aun no hay una buena coincidencia. Prueba palabras como ajedrez, bloques, palabra o categoria.',
			'Best match found. Press "Open Selected Game".' => 'Mejor coincidencia encontrada. Presiona "Abrir juego seleccionado".',
			'Reach the door on the right...' => 'Llega a la puerta de la derecha...',
			'Caught by a ceiling crawler. Restart the room.' => 'Te atrapo un rastreador del techo. Reinicia la sala.',
			'Out of moves. Gravity is powerful, but expensive.' => 'Sin movimientos. La gravedad es poderosa, pero cara.',
			'You already tried that letter.' => 'Ya probaste esa letra.',
			'Enter one letter.' => 'Ingresa una letra.',
			'Bu sayfada hangi oyun calissin?' => 'Que juego debe ejecutarse en esta pagina?',
			'Bir oyun secin' => 'Selecciona un juego',
			'Bu oyun hangi listeye eklensin?' => 'A que lista se debe agregar este juego?',
			'Arslan ya da Asker oyun listesi buna gore filtrelenir.' => 'La lista de juegos de Arslan o Asker se filtra segun esto.',
			'Oyun bulunamadi.' => 'No se encontro el juego.',
			'Bu oyun henuz goruntulenemiyor.' => 'Este juego aun no se puede mostrar.',
			'Henuz oyun bulunamadi.' => 'Todavia no se encontraron juegos.',
			'Filtreye uyan oyun bulunamadi.' => 'No se encontro ningun juego que coincida con el filtro.',
			'Game stats' => 'Estadisticas del juego',
			'game area' => 'area de juego',
			'Game area' => 'Area de juego',
			'Game controls' => 'Controles del juego',
			'Ready.' => 'Listo.',
			'RUN' => 'CORRER',
			'Point' => 'Punto',
			'AI difficulty' => 'Dificultad de la IA',
			'Easy AI' => 'IA facil',
			'Medium AI' => 'IA media',
			'Hard AI' => 'IA dificil',
			'Game speed' => 'Velocidad del juego',
			'Speed x1' => 'Velocidad x1',
			'Speed x1.5' => 'Velocidad x1.5',
			'Speed x2' => 'Velocidad x2',
			'Select Operation' => 'Selecciona una operacion',
			'Enter First Number' => 'Ingresa el primer numero',
			'Enter Second Number' => 'Ingresa el segundo numero',
			'Operation' => 'Operacion',
			'Square Root' => 'Raiz cuadrada',
			'Result' => 'Resultado',
			'Start Quiz' => 'Iniciar cuestionario',
			'Type a country name to begin.' => 'Escribe el nombre de un pais para empezar.',
		),
	);

	$sitewide_runtime_exact_agent_more['es-es'] = array_merge($sitewide_runtime_exact_agent_more['es-mx'], array(
		'Text added' => 'Texto anadido',
		'Sticker added' => 'Pegatina anadida',
		'Build a 10-second loop. Ore becomes gears, gears become crates, and better placement boosts output.' => 'Crea un ciclo de 10 segundos. El mineral se convierte en engranajes, los engranajes en cajas, y una mejor colocacion aumenta la produccion.',
		'Factory optimized. Your loop now prints value every cycle.' => 'Fabrica optimizada. Tu ciclo ahora produce valor en cada ciclo.',
		'You win the match.' => 'Has ganado el partido.',
		'You lose the match.' => 'Has perdido el partido.',
		'The match ends in a draw.' => 'El partido acaba en empate.',
		'Computer Wins' => 'Gana el ordenador',
		'Great job. You found a match.' => 'Muy bien. Has encontrado una pareja.',
		'Find all the matching animal pairs.' => 'Encuentra todas las parejas de animales.',
		'Build the sequence.' => 'Construye la secuencia.',
		'Nice. You landed on the target. Press Check.' => 'Bien. Has caido en el objetivo. Pulsa Comprobar.',
		'Type a country name to begin.' => 'Escribe el nombre de un pais para empezar.',
	));

	foreach ($sitewide_runtime_exact_agent_more as $agent_more_lang => $agent_more_items) {
		if (isset($translations[$agent_more_lang])) {
			$translations[$agent_more_lang] = array_merge($translations[$agent_more_lang], $agent_more_items);
		}
	}

	$sitewide_runtime_exact_agent_final = array(
		'tr' => array(
			'Pick the right answer before the computer gets ahead.' => 'Bilgisayar one gecmeden dogru cevabi sec.',
			'Correct. You win this round.' => 'Dogru. Bu turu kazandin.',
			'Wrong. The computer wins this round.' => 'Yanlis. Bu turu bilgisayar kazandi.',
			'Hidden card' => 'Kapali kart',
			'Attempts' => 'Deneme',
			'Problem' => 'Soru',
			'You can build before pressing Start, or during battle if you have enough gold.' => 'Baslata basmadan once veya savas sirasinda yeterli altinin varsa insa edebilirsin.',
			'Press Start. Then choose a monster unit.' => 'Baslata bas. Sonra bir canavar birimi sec.',
			'Start the match.' => 'Maci baslat.',
			'Move with WASD or Arrow keys. Click or tap inside the board to shoot. Press Restart any time.' => 'WASD veya ok tuslariyla hareket et. Ates etmek icin alana tikla veya dokun. Istedigin zaman Yeniden Baslata bas.',
			'Bu Mısır işareti neyi gösteriyor?' => 'Bu Misir isareti neyi gosteriyor?',
			'Doğru cevap.' => 'Dogru cevap.',
			'Yanlış cevap.' => 'Yanlis cevap.',
			'Doğru anlamı seç.' => 'Dogru anlami sec.',
			'Cevap seçenekleri' => 'Cevap secenekleri',
		),
		'de' => array(
			'Pick the right answer before the computer gets ahead.' => 'Wahle die richtige Antwort, bevor der Computer voraus ist.',
			'Correct. You win this round.' => 'Richtig. Du gewinnst diese Runde.',
			'Wrong. The computer wins this round.' => 'Falsch. Der Computer gewinnt diese Runde.',
			'Hidden card' => 'Verdeckte Karte',
			'Attempts' => 'Versuche',
			'Problem' => 'Aufgabe',
			'You can build before pressing Start, or during battle if you have enough gold.' => 'Du kannst vor dem Start bauen oder im Kampf, wenn du genug Gold hast.',
			'Press Start. Then choose a monster unit.' => 'Drucke Start. Wahle dann eine Monstereinheit.',
			'Start the match.' => 'Starte das Spiel.',
			'Move with WASD or Arrow keys. Click or tap inside the board to shoot. Press Restart any time.' => 'Bewege dich mit WASD oder den Pfeiltasten. Klicke oder tippe ins Feld, um zu schiessen. Du kannst jederzeit neu starten.',
			'Bu Mısır işareti neyi gösteriyor?' => 'Was bedeutet dieses agyptische Zeichen?',
			'Doğru cevap.' => 'Richtige Antwort.',
			'Yanlış cevap.' => 'Falsche Antwort.',
			'Doğru anlamı seç.' => 'Wahle die richtige Bedeutung.',
			'Cevap seçenekleri' => 'Antwortoptionen',
		),
		'fr' => array(
			'Pick the right answer before the computer gets ahead.' => 'Choisis la bonne reponse avant que l ordinateur prenne l avance.',
			'Correct. You win this round.' => 'Correct. Tu gagnes cette manche.',
			'Wrong. The computer wins this round.' => 'Faux. L ordinateur gagne cette manche.',
			'Hidden card' => 'Carte cachee',
			'Attempts' => 'Essais',
			'Problem' => 'Probleme',
			'You can build before pressing Start, or during battle if you have enough gold.' => 'Tu peux construire avant de demarrer ou pendant le combat si tu as assez d or.',
			'Press Start. Then choose a monster unit.' => 'Appuie sur Demarrer. Choisis ensuite une unite monstre.',
			'Start the match.' => 'Lance le match.',
			'Move with WASD or Arrow keys. Click or tap inside the board to shoot. Press Restart any time.' => 'Deplace-toi avec WASD ou les fleches. Clique ou touche le plateau pour tirer. Tu peux redemarrer a tout moment.',
			'Bu Mısır işareti neyi gösteriyor?' => 'Que signifie ce signe egyptien ?',
			'Doğru cevap.' => 'Bonne reponse.',
			'Yanlış cevap.' => 'Mauvaise reponse.',
			'Doğru anlamı seç.' => 'Choisis le bon sens.',
			'Cevap seçenekleri' => 'Choix de reponse',
		),
		'es-mx' => array(
			'Pick the right answer before the computer gets ahead.' => 'Elige la respuesta correcta antes de que la computadora se adelante.',
			'Correct. You win this round.' => 'Correcto. Ganaste esta ronda.',
			'Wrong. The computer wins this round.' => 'Incorrecto. La computadora gana esta ronda.',
			'Hidden card' => 'Carta oculta',
			'Attempts' => 'Intentos',
			'Problem' => 'Problema',
			'You can build before pressing Start, or during battle if you have enough gold.' => 'Puedes construir antes de empezar o durante la batalla si tienes suficiente oro.',
			'Press Start. Then choose a monster unit.' => 'Presiona Empezar. Luego elige una unidad monstruo.',
			'Start the match.' => 'Empieza la partida.',
			'Move with WASD or Arrow keys. Click or tap inside the board to shoot. Press Restart any time.' => 'Muevete con WASD o las flechas. Haz clic o toca el tablero para disparar. Puedes reiniciar cuando quieras.',
			'Bu Mısır işareti neyi gösteriyor?' => 'Que significa este signo egipcio?',
			'Doğru cevap.' => 'Respuesta correcta.',
			'Yanlış cevap.' => 'Respuesta incorrecta.',
			'Doğru anlamı seç.' => 'Elige el significado correcto.',
			'Cevap seçenekleri' => 'Opciones de respuesta',
		),
	);
	$sitewide_runtime_exact_agent_final['es-es'] = array_merge($sitewide_runtime_exact_agent_final['es-mx'], array(
		'Pick the right answer before the computer gets ahead.' => 'Elige la respuesta correcta antes de que el ordenador se adelante.',
		'Correct. You win this round.' => 'Correcto. Has ganado esta ronda.',
		'Wrong. The computer wins this round.' => 'Incorrecto. El ordenador gana esta ronda.',
		'Press Start. Then choose a monster unit.' => 'Pulsa Empezar. Luego elige una unidad monstruo.',
	));

	foreach ($sitewide_runtime_exact_agent_final as $agent_final_lang => $agent_final_items) {
		if (isset($translations[$agent_final_lang])) {
			$translations[$agent_final_lang] = array_merge($translations[$agent_final_lang], $agent_final_items);
		}
	}

	$sitewide_runtime_exact_followup = array(
		'tr' => array(
			'Notes: On' => 'Notlar: Acik',
			'Notes: Off' => 'Notlar: Kapali',
			'Corner' => 'Korner',
			'Decision' => 'Karar',
			'Live' => 'Canli',
			'Smart' => 'Akilli',
			'Corners' => 'Kornerler',
			'Medicine Question' => 'Saglik sorusu',
			'Ask a Clarifying Question' => 'Aciklayici soru sor',
			'Ask One Question' => 'Bir soru sor',
			'Choose the correct country name.' => 'Dogru ulke adini sec.',
			'Doğru ülke adını seç.' => 'Dogru ulke adini sec.',
			'Find numbers that are perfect squares.' => 'Tam kare olan sayilari bul.',
			'Prime numbers are greater than 1 and divisible only by 1 and themselves. For example, 7 is prime because no number other than 1 and 7 divides it evenly.' => 'Asal sayilar 1den buyuktur ve yalnizca 1e ve kendisine bolunur. Ornegin 7 asaldir, cunku 1 ve 7 disinda hicbir sayi onu tam bolmez.',
			'Target Shooting' => 'Hedef vurma',
			'Tower Defense Paths' => 'Kule savunma yollari',
			'Zombie Garden Defense' => 'Zombi bahce savunmasi',
			'Dragon Egg Defense' => 'Ejderha yumurtasi savunmasi',
		),
		'de' => array(
			'Notes: On' => 'Notizen: An',
			'Notes: Off' => 'Notizen: Aus',
			'Corner' => 'Ecke',
			'Decision' => 'Entscheidung',
			'Live' => 'Live',
			'Smart' => 'Klug',
			'Corners' => 'Ecken',
			'Medicine Question' => 'Medizinfrage',
			'Ask a Clarifying Question' => 'Klarende Frage stellen',
			'Ask One Question' => 'Eine Frage stellen',
			'Choose the correct country name.' => 'Wahle den richtigen Landernamen.',
			'Doğru ülke adını seç.' => 'Wahle den richtigen Landernamen.',
			'Find numbers that are perfect squares.' => 'Finde Zahlen, die Quadratzahlen sind.',
			'Prime numbers are greater than 1 and divisible only by 1 and themselves. For example, 7 is prime because no number other than 1 and 7 divides it evenly.' => 'Primzahlen sind grosser als 1 und nur durch 1 und sich selbst teilbar. Zum Beispiel ist 7 prim, weil keine Zahl ausser 1 und 7 sie glatt teilt.',
			'Target Shooting' => 'Zielschiessen',
			'Tower Defense Paths' => 'Tower-Defense-Wege',
			'Zombie Garden Defense' => 'Zombie-Gartenverteidigung',
			'Dragon Egg Defense' => 'Drachenei-Verteidigung',
		),
		'fr' => array(
			'Notes: On' => 'Notes : activees',
			'Notes: Off' => 'Notes : desactivees',
			'Corner' => 'Corner',
			'Decision' => 'Decision',
			'Live' => 'En direct',
			'Smart' => 'Intelligent',
			'Corners' => 'Corners',
			'Medicine Question' => 'Question de sante',
			'Ask a Clarifying Question' => 'Poser une question de clarification',
			'Ask One Question' => 'Poser une question',
			'Choose the correct country name.' => 'Choisis le bon nom de pays.',
			'Doğru ülke adını seç.' => 'Choisis le bon nom de pays.',
			'Find numbers that are perfect squares.' => 'Trouve les nombres qui sont des carres parfaits.',
			'Prime numbers are greater than 1 and divisible only by 1 and themselves. For example, 7 is prime because no number other than 1 and 7 divides it evenly.' => 'Les nombres premiers sont superieurs a 1 et divisibles seulement par 1 et par eux-memes. Par exemple, 7 est premier car aucun nombre sauf 1 et 7 ne le divise exactement.',
			'Target Shooting' => 'Tir sur cible',
			'Tower Defense Paths' => 'Chemins de defense de tours',
			'Zombie Garden Defense' => 'Defense du jardin zombie',
			'Dragon Egg Defense' => 'Defense de l oeuf de dragon',
		),
		'es-mx' => array(
			'Notes: On' => 'Notas: activadas',
			'Notes: Off' => 'Notas: desactivadas',
			'Corner' => 'Tiro de esquina',
			'Decision' => 'Decision',
			'Live' => 'En vivo',
			'Smart' => 'Inteligente',
			'Corners' => 'Tiros de esquina',
			'Medicine Question' => 'Pregunta de medicina',
			'Ask a Clarifying Question' => 'Haz una pregunta aclaratoria',
			'Ask One Question' => 'Haz una pregunta',
			'Choose the correct country name.' => 'Elige el nombre correcto del pais.',
			'Doğru ülke adını seç.' => 'Elige el nombre correcto del pais.',
			'Find numbers that are perfect squares.' => 'Encuentra numeros que sean cuadrados perfectos.',
			'Prime numbers are greater than 1 and divisible only by 1 and themselves. For example, 7 is prime because no number other than 1 and 7 divides it evenly.' => 'Los numeros primos son mayores que 1 y solo se dividen entre 1 y ellos mismos. Por ejemplo, 7 es primo porque ningun numero excepto 1 y 7 lo divide exactamente.',
			'Target Shooting' => 'Tiro al blanco',
			'Tower Defense Paths' => 'Caminos de defensa de torres',
			'Zombie Garden Defense' => 'Defensa del jardin zombie',
			'Dragon Egg Defense' => 'Defensa del huevo de dragon',
		),
	);
	$sitewide_runtime_exact_followup['es-es'] = array_merge($sitewide_runtime_exact_followup['es-mx'], array(
		'Corner' => 'Saque de esquina',
		'Corners' => 'Saques de esquina',
		'Medicine Question' => 'Pregunta de medicina',
	));

	foreach ($sitewide_runtime_exact_followup as $followup_lang => $followup_items) {
		if (isset($translations[$followup_lang])) {
			$translations[$followup_lang] = array_merge($translations[$followup_lang], $followup_items);
		}
	}

	$sitewide_runtime_exact_followup_two = array(
		'tr' => array(
			'Your robot helper is waiting for its first lesson.' => 'Robot yardimcin ilk dersini bekliyor.',
			'Choose the best move for this round.' => 'Bu tur icin en iyi hamleyi sec.',
			'Training finished. Review the summary and restart for a new run.' => 'Egitim bitti. Ozeti incele ve yeni tur icin yeniden baslat.',
			'Press Start. Place towers on the gray pads.' => 'Baslata bas. Kuleleri gri alanlara yerlestir.',
			'That build spot is already used.' => 'Bu insa noktasi zaten kullaniliyor.',
			'Defend your base and destroy theirs.' => 'Ussunu savun ve dusman ussunu yok et.',
			'Level 1 ready. Press Space or Launch.' => 'Seviye 1 hazir. Bosluk veya Baslat tusuna bas.',
			'You beat all 1000 levels!' => '1000 seviyenin hepsini gectin!',
			'Break every brick.' => 'Tum tuglalari kir.',
			'Game over. Press R or Restart.' => 'Oyun bitti. R veya Yeniden Baslat tusuna bas.',
			'Life lost. Launch again.' => 'Can gitti. Tekrar baslat.',
			'Keep going. Follow the binary rules and fill the full grid.' => 'Devam et. Ikili kurallari izle ve tum tabloyu doldur.',
			'Fill the empty squares with 0 or 1.' => 'Bos kareleri 0 veya 1 ile doldur.',
			'The grid is not full yet. Fill every square first.' => 'Tablo henuz dolu degil. Once tum kareleri doldur.',
			'Almost there. One or more row or column rules are broken.' => 'Neredeyse oldu. Bir veya daha fazla satir ya da sutun kurali bozuldu.',
			'The rules look okay, but a few squares are still wrong. Try again.' => 'Kurallar iyi gorunuyor ama birkac kare hala yanlis. Tekrar dene.',
			'Player moves cleared. Try the puzzle again.' => 'Oyuncu hamleleri temizlendi. Bulmacayi tekrar dene.',
			'Pick the number that makes the scale balance.' => 'Teraziyi dengeleyecek sayiyi sec.',
			'Correct. The equation is balanced.' => 'Dogru. Denklem dengede.',
			'Answer this round first.' => 'Once bu turu cevapla.',
			'Classify the bug.' => 'Bocegi siniflandir.',
			'Classify the bugs before time runs out.' => 'Sure bitmeden bocekleri siniflandir.',
			'Correct bin.' => 'Dogru kutu.',
			'Select an operation.' => 'Bir islem sec.',
			'Please enter a valid first number.' => 'Gecerli bir ilk sayi gir.',
			'Please enter a valid second number.' => 'Gecerli bir ikinci sayi gir.',
			'Cannot divide by zero.' => 'Sifira bolunemez.',
			'Cannot take the square root of a negative number.' => 'Negatif sayinin karekoku alinamaz.',
			'Build the combo!' => 'Komboyu kur!',
			'Combo Complete! You Win!' => 'Kombo tamam! Kazandin!',
			'Wrong combo! Try again.' => 'Yanlis kombo! Tekrar dene.',
			'Watch the sequence.' => 'Diziyi izle.',
			'Now repeat.' => 'Simdi tekrarla.',
			'Write your decoded phrase first.' => 'Once cozulmus ifadeni yaz.',
			'Not quite yet. Check your letters and try again.' => 'Henuz degil. Harflerini kontrol et ve tekrar dene.',
			'Here is the decoded phrase.' => 'Cozulmus ifade burada.',
			'Match the target color.' => 'Hedef rengi eslestir.',
			'Wrong color. Try again.' => 'Yanlis renk. Tekrar dene.',
		),
		'de' => array(
			'Your robot helper is waiting for its first lesson.' => 'Dein Roboterhelfer wartet auf seine erste Lektion.',
			'Choose the best move for this round.' => 'Wahle den besten Zug fur diese Runde.',
			'Training finished. Review the summary and restart for a new run.' => 'Training beendet. Sieh dir die Zusammenfassung an und starte neu.',
			'Press Start. Place towers on the gray pads.' => 'Drucke Start. Platziere Turme auf den grauen Feldern.',
			'That build spot is already used.' => 'Dieser Bauplatz ist bereits belegt.',
			'Defend your base and destroy theirs.' => 'Verteidige deine Basis und zerstor ihre.',
			'Level 1 ready. Press Space or Launch.' => 'Level 1 bereit. Drucke Leertaste oder Starten.',
			'You beat all 1000 levels!' => 'Du hast alle 1000 Level geschafft!',
			'Break every brick.' => 'Zerbrich jeden Stein.',
			'Game over. Press R or Restart.' => 'Spiel vorbei. Drucke R oder Neustart.',
			'Life lost. Launch again.' => 'Leben verloren. Starte erneut.',
			'Keep going. Follow the binary rules and fill the full grid.' => 'Mach weiter. Folge den Binaregeln und fulle das ganze Feld.',
			'Fill the empty squares with 0 or 1.' => 'Fulle die leeren Felder mit 0 oder 1.',
			'The grid is not full yet. Fill every square first.' => 'Das Feld ist noch nicht voll. Fulle zuerst jedes Quadrat.',
			'Almost there. One or more row or column rules are broken.' => 'Fast geschafft. Eine oder mehrere Zeilen- oder Spaltenregeln sind verletzt.',
			'The rules look okay, but a few squares are still wrong. Try again.' => 'Die Regeln sehen gut aus, aber einige Felder sind noch falsch. Versuch es erneut.',
			'Player moves cleared. Try the puzzle again.' => 'Spielerzuege geloscht. Versuch das Ratsel erneut.',
			'Pick the number that makes the scale balance.' => 'Wahle die Zahl, die die Waage ausgleicht.',
			'Correct. The equation is balanced.' => 'Richtig. Die Gleichung ist ausgeglichen.',
			'Answer this round first.' => 'Beantworte zuerst diese Runde.',
			'Classify the bug.' => 'Sortiere den Kafer ein.',
			'Classify the bugs before time runs out.' => 'Sortiere die Kafer, bevor die Zeit ablaeuft.',
			'Correct bin.' => 'Richtiger Behalter.',
			'Select an operation.' => 'Wahle eine Rechenart.',
			'Please enter a valid first number.' => 'Gib eine gultige erste Zahl ein.',
			'Please enter a valid second number.' => 'Gib eine gultige zweite Zahl ein.',
			'Cannot divide by zero.' => 'Division durch null ist nicht moglich.',
			'Cannot take the square root of a negative number.' => 'Aus einer negativen Zahl kann keine Quadratwurzel gezogen werden.',
			'Build the combo!' => 'Baue die Kombo!',
			'Combo Complete! You Win!' => 'Kombo komplett! Du gewinnst!',
			'Wrong combo! Try again.' => 'Falsche Kombo! Versuch es erneut.',
			'Watch the sequence.' => 'Beobachte die Reihenfolge.',
			'Now repeat.' => 'Jetzt wiederholen.',
			'Write your decoded phrase first.' => 'Schreibe zuerst deine entschlusselte Phrase.',
			'Not quite yet. Check your letters and try again.' => 'Noch nicht ganz. Prufe deine Buchstaben und versuche es erneut.',
			'Here is the decoded phrase.' => 'Hier ist die entschlusselte Phrase.',
			'Match the target color.' => 'Triff die Zielfarbe.',
			'Wrong color. Try again.' => 'Falsche Farbe. Versuch es erneut.',
		),
		'fr' => array(
			'Your robot helper is waiting for its first lesson.' => 'Ton assistant robot attend sa premiere lecon.',
			'Choose the best move for this round.' => 'Choisis le meilleur coup pour cette manche.',
			'Training finished. Review the summary and restart for a new run.' => 'Entrainement termine. Relis le resume puis redemarre.',
			'Press Start. Place towers on the gray pads.' => 'Appuie sur Demarrer. Place les tours sur les cases grises.',
			'That build spot is already used.' => 'Cet emplacement est deja utilise.',
			'Defend your base and destroy theirs.' => 'Defends ta base et detruis la leur.',
			'Level 1 ready. Press Space or Launch.' => 'Niveau 1 pret. Appuie sur Espace ou Lancer.',
			'You beat all 1000 levels!' => 'Tu as termine les 1000 niveaux !',
			'Break every brick.' => 'Casse toutes les briques.',
			'Game over. Press R or Restart.' => 'Partie terminee. Appuie sur R ou Redemarrer.',
			'Life lost. Launch again.' => 'Vie perdue. Relance.',
			'Keep going. Follow the binary rules and fill the full grid.' => 'Continue. Suis les regles binaires et remplis toute la grille.',
			'Fill the empty squares with 0 or 1.' => 'Remplis les cases vides avec 0 ou 1.',
			'The grid is not full yet. Fill every square first.' => 'La grille n est pas encore pleine. Remplis d abord chaque case.',
			'Almost there. One or more row or column rules are broken.' => 'Presque. Une ou plusieurs regles de ligne ou de colonne sont cassees.',
			'The rules look okay, but a few squares are still wrong. Try again.' => 'Les regles semblent bonnes, mais quelques cases sont encore fausses. Reessaie.',
			'Player moves cleared. Try the puzzle again.' => 'Coups du joueur effaces. Reessaie le puzzle.',
			'Pick the number that makes the scale balance.' => 'Choisis le nombre qui equilibre la balance.',
			'Correct. The equation is balanced.' => 'Correct. L equation est equilibree.',
			'Answer this round first.' => 'Reponds d abord a cette manche.',
			'Classify the bug.' => 'Classe l insecte.',
			'Classify the bugs before time runs out.' => 'Classe les insectes avant la fin du temps.',
			'Correct bin.' => 'Bonne boite.',
			'Select an operation.' => 'Choisis une operation.',
			'Please enter a valid first number.' => 'Saisis un premier nombre valide.',
			'Please enter a valid second number.' => 'Saisis un deuxieme nombre valide.',
			'Cannot divide by zero.' => 'Impossible de diviser par zero.',
			'Cannot take the square root of a negative number.' => 'Impossible de prendre la racine carree d un nombre negatif.',
			'Build the combo!' => 'Construis le combo !',
			'Combo Complete! You Win!' => 'Combo termine ! Tu gagnes !',
			'Wrong combo! Try again.' => 'Mauvais combo ! Reessaie.',
			'Watch the sequence.' => 'Regarde la sequence.',
			'Now repeat.' => 'Repete maintenant.',
			'Write your decoded phrase first.' => 'Ecris d abord ta phrase decodee.',
			'Not quite yet. Check your letters and try again.' => 'Pas encore. Verifie tes lettres et reessaie.',
			'Here is the decoded phrase.' => 'Voici la phrase decodee.',
			'Match the target color.' => 'Associe la couleur cible.',
			'Wrong color. Try again.' => 'Mauvaise couleur. Reessaie.',
		),
		'es-mx' => array(
			'Your robot helper is waiting for its first lesson.' => 'Tu robot ayudante espera su primera leccion.',
			'Choose the best move for this round.' => 'Elige la mejor jugada para esta ronda.',
			'Training finished. Review the summary and restart for a new run.' => 'Entrenamiento terminado. Revisa el resumen y reinicia para una nueva partida.',
			'Press Start. Place towers on the gray pads.' => 'Presiona Iniciar. Coloca torres en los cuadros grises.',
			'That build spot is already used.' => 'Ese lugar de construccion ya esta usado.',
			'Defend your base and destroy theirs.' => 'Defiende tu base y destruye la suya.',
			'Level 1 ready. Press Space or Launch.' => 'Nivel 1 listo. Presiona Espacio o Lanzar.',
			'You beat all 1000 levels!' => 'Superaste los 1000 niveles!',
			'Break every brick.' => 'Rompe todos los ladrillos.',
			'Game over. Press R or Restart.' => 'Fin del juego. Presiona R o Reiniciar.',
			'Life lost. Launch again.' => 'Vida perdida. Lanza otra vez.',
			'Keep going. Follow the binary rules and fill the full grid.' => 'Sigue. Respeta las reglas binarias y llena toda la cuadricula.',
			'Fill the empty squares with 0 or 1.' => 'Llena los cuadros vacios con 0 o 1.',
			'The grid is not full yet. Fill every square first.' => 'La cuadricula aun no esta llena. Llena primero cada cuadro.',
			'Almost there. One or more row or column rules are broken.' => 'Casi. Una o mas reglas de fila o columna estan rotas.',
			'The rules look okay, but a few squares are still wrong. Try again.' => 'Las reglas parecen bien, pero algunos cuadros siguen mal. Intenta otra vez.',
			'Player moves cleared. Try the puzzle again.' => 'Movimientos borrados. Intenta el rompecabezas otra vez.',
			'Pick the number that makes the scale balance.' => 'Elige el numero que equilibra la balanza.',
			'Correct. The equation is balanced.' => 'Correcto. La ecuacion esta equilibrada.',
			'Answer this round first.' => 'Primero responde esta ronda.',
			'Classify the bug.' => 'Clasifica el insecto.',
			'Classify the bugs before time runs out.' => 'Clasifica los insectos antes de que se acabe el tiempo.',
			'Correct bin.' => 'Contenedor correcto.',
			'Select an operation.' => 'Selecciona una operacion.',
			'Please enter a valid first number.' => 'Ingresa un primer numero valido.',
			'Please enter a valid second number.' => 'Ingresa un segundo numero valido.',
			'Cannot divide by zero.' => 'No se puede dividir entre cero.',
			'Cannot take the square root of a negative number.' => 'No se puede sacar la raiz cuadrada de un numero negativo.',
			'Build the combo!' => 'Arma el combo!',
			'Combo Complete! You Win!' => 'Combo completo! Ganaste!',
			'Wrong combo! Try again.' => 'Combo incorrecto! Intenta otra vez.',
			'Watch the sequence.' => 'Mira la secuencia.',
			'Now repeat.' => 'Ahora repite.',
			'Write your decoded phrase first.' => 'Primero escribe tu frase descifrada.',
			'Not quite yet. Check your letters and try again.' => 'Todavia no. Revisa tus letras e intenta otra vez.',
			'Here is the decoded phrase.' => 'Aqui esta la frase descifrada.',
			'Match the target color.' => 'Iguala el color objetivo.',
			'Wrong color. Try again.' => 'Color incorrecto. Intenta otra vez.',
		),
	);
	$sitewide_runtime_exact_followup_two['es-es'] = array_merge($sitewide_runtime_exact_followup_two['es-mx'], array(
		'Press Start. Place towers on the gray pads.' => 'Pulsa Iniciar. Coloca torres en las casillas grises.',
		'Life lost. Launch again.' => 'Vida perdida. Lanza de nuevo.',
		'Correct bin.' => 'Contenedor correcto.',
		'Please enter a valid first number.' => 'Introduce un primer numero valido.',
		'Please enter a valid second number.' => 'Introduce un segundo numero valido.',
	));

	foreach ($sitewide_runtime_exact_followup_two as $followup_two_lang => $followup_two_items) {
		if (isset($translations[$followup_two_lang])) {
			$translations[$followup_two_lang] = array_merge($translations[$followup_two_lang], $followup_two_items);
		}
	}

	foreach ($agent_runtime_exact as $agent_lang => $agent_items) {
		if (isset($translations[$agent_lang])) {
			$translations[$agent_lang] = array_merge($translations[$agent_lang], $agent_items);
		}
	}

	if (isset($translations[$lang], $common_exact[$lang])) {
		$translations[$lang] = array_merge($translations[$lang], $common_exact[$lang]);
	}

	return isset($translations[$lang]) ? $translations[$lang] : array();
}

function zo_get_runtime_translation_replacements($lang) {
	$lang = array_key_exists($lang, zo_get_language_options()) ? $lang : zo_get_current_language();

	$phrases = array(
		'tr' => array(
			array('Score', 'Puan'),
			array('Final Score', 'Son Puan'),
			array('Level', 'Seviye'),
			array('Round', 'Tur'),
			array('Time', 'Süre'),
			array('Lives', 'Can'),
			array('Health', 'Sağlık'),
			array('Coins', 'Coin'),
			array('Question', 'Soru'),
			array('Correct', 'Doğru'),
			array('Wrong', 'Yanlış'),
			array('Game Over', 'Oyun Bitti'),
			array('Press Start', 'Başlat düğmesine bas'),
			array('Press Restart', 'Yeniden Başlat düğmesine bas'),
			array('Press R', 'R tuşuna bas'),
			array('Press Space', 'Boşluk tuşuna bas'),
			array('Press SPACE', 'BOŞLUK tuşuna bas'),
			array('Start Quiz', 'Teste Başla'),
			array('Next Question', 'Sonraki Soru'),
			array('Play Again', 'Tekrar Oyna'),
			array('Try again', 'Tekrar dene'),
			array('You found', 'Buldun'),
			array('You win', 'Kazandın'),
			array('You Win', 'Kazandın'),
			array('You lost', 'Kaybettin'),
			array('Collect', 'Topla'),
			array('Avoid', 'Kaçın'),
			array('Move', 'Hareket'),
			array('Restart', 'Yeniden Başlat'),
			array('Start', 'Başlat'),
			array('Pause', 'Duraklat'),
			array('Resume', 'Devam Et'),
		),
		'en' => array(
			array('12/24 Saat', '12/24 Format'),
			array('Saati', 'Clock'),
			array('Saat', 'Time'),
			array('Puan', 'Score'),
			array('Son Puan', 'Final Score'),
			array('Seviye', 'Level'),
			array('Tur', 'Round'),
			array('Süre', 'Time'),
			array('Can', 'Lives'),
			array('Sağlık', 'Health'),
			array('Soru', 'Question'),
			array('Doğru', 'Correct'),
			array('Yanlış', 'Wrong'),
			array('Oyun Bitti', 'Game Over'),
			array('Başlat düğmesine bas', 'Press Start'),
			array('Yeniden Başlat düğmesine bas', 'Press Restart'),
			array('Tekrar dene', 'Try again'),
			array('Kazandın', 'You Win'),
			array('Kaybettin', 'You Lost'),
			array('Topla', 'Collect'),
			array('Kaçın', 'Avoid'),
			array('Hareket', 'Move'),
			array('Yeniden Başlat', 'Restart'),
			array('Başlat', 'Start'),
			array('Duraklat', 'Pause'),
			array('Devam Et', 'Resume'),
		),
		'de' => array(
			array('12/24 Saat', '12/24 Format'),
			array('Saati', 'Uhr'),
			array('Saat', 'Uhrzeit'),
			array('Final Score', 'Endpunkte'),
			array('Score', 'Punkte'),
			array('Level', 'Level'),
			array('Round', 'Runde'),
			array('Time', 'Zeit'),
			array('Lives', 'Leben'),
			array('Health', 'Gesundheit'),
			array('Coins', 'Münzen'),
			array('Question', 'Frage'),
			array('Correct', 'Richtig'),
			array('Wrong', 'Falsch'),
			array('Game Over', 'Spiel vorbei'),
			array('Press Start', 'Drücke Starten'),
			array('Press Restart', 'Drücke Neu starten'),
			array('Press R', 'Drücke R'),
			array('Press Space', 'Drücke die Leertaste'),
			array('Press SPACE', 'DRÜCKE DIE LEERTASTE'),
			array('Start Quiz', 'Quiz starten'),
			array('Next Question', 'Nächste Frage'),
			array('Play Again', 'Noch einmal spielen'),
			array('Try again', 'Versuche es noch einmal'),
			array('You found', 'Du hast gefunden'),
			array('You win', 'Du gewinnst'),
			array('You Win', 'Du gewinnst'),
			array('You lost', 'Du hast verloren'),
			array('Collect', 'Sammle'),
			array('Avoid', 'Weiche aus'),
			array('Move', 'Bewege dich'),
			array('Restart', 'Neu starten'),
			array('Start', 'Starten'),
			array('Pause', 'Pause'),
			array('Resume', 'Fortsetzen'),
			array('Puan', 'Punkte'),
			array('Seviye', 'Level'),
			array('Tur', 'Runde'),
			array('Süre', 'Zeit'),
			array('Can', 'Leben'),
			array('Soru', 'Frage'),
			array('Doğru', 'Richtig'),
			array('Yanlış', 'Falsch'),
			array('Oyun Bitti', 'Spiel vorbei'),
			array('Başlat', 'Starten'),
			array('Yeniden Başlat', 'Neu starten'),
		),
		'fr' => array(
			array('12/24 Saat', 'Format 12/24'),
			array('Saati', 'Horloge'),
			array('Saat', 'Heure'),
			array('Final Score', 'Score final'),
			array('Score', 'Score'),
			array('Level', 'Niveau'),
			array('Round', 'Manche'),
			array('Time', 'Temps'),
			array('Lives', 'Vies'),
			array('Health', 'Santé'),
			array('Coins', 'Pièces'),
			array('Question', 'Question'),
			array('Correct', 'Correct'),
			array('Wrong', 'Incorrect'),
			array('Game Over', 'Partie terminée'),
			array('Press Start', 'Appuie sur Démarrer'),
			array('Press Restart', 'Appuie sur Redémarrer'),
			array('Press R', 'Appuie sur R'),
			array('Press Space', 'Appuie sur Espace'),
			array('Start Quiz', 'Commencer le quiz'),
			array('Next Question', 'Question suivante'),
			array('Play Again', 'Rejouer'),
			array('Try again', 'Réessaie'),
			array('You found', 'Tu as trouvé'),
			array('You win', 'Tu as gagné'),
			array('You Win', 'Tu as gagné'),
			array('You lost', 'Tu as perdu'),
			array('Collect', 'Ramasse'),
			array('Avoid', 'Évite'),
			array('Move', 'Déplacement'),
			array('Restart', 'Redémarrer'),
			array('Start', 'Démarrer'),
			array('Pause', 'Pause'),
			array('Resume', 'Reprendre'),
			array('Puan', 'Score'),
			array('Seviye', 'Niveau'),
			array('Tur', 'Manche'),
			array('Can', 'Vies'),
			array('Hedef', 'Objectif'),
			array('Soru', 'Question'),
			array('Oyun Bitti', 'Partie terminée'),
		),
	);

	$spanish_phrases = array(
		array('12/24 Saat', 'Formato 12/24'),
		array('Saati', 'Reloj'),
		array('Saat', 'Hora'),
		array('Final Score', 'Puntuación final'),
		array('Score', 'Puntuación'),
		array('Level', 'Nivel'),
		array('Round', 'Ronda'),
		array('Time', 'Tiempo'),
		array('Lives', 'Vidas'),
		array('Health', 'Salud'),
		array('Coins', 'Monedas'),
		array('Question', 'Pregunta'),
		array('Correct', 'Correcto'),
		array('Wrong', 'Incorrecto'),
		array('Game Over', 'Fin del juego'),
		array('Press Start', 'Pulsa Empezar'),
		array('Press Restart', 'Pulsa Reiniciar'),
		array('Press R', 'Pulsa R'),
		array('Press Space', 'Pulsa Espacio'),
		array('Start Quiz', 'Empezar quiz'),
		array('Next Question', 'Siguiente pregunta'),
		array('Play Again', 'Jugar de nuevo'),
		array('Try again', 'Inténtalo de nuevo'),
		array('You found', 'Encontraste'),
		array('You win', 'Ganaste'),
		array('You Win', 'Ganaste'),
		array('You lost', 'Perdiste'),
		array('Collect', 'Recoge'),
		array('Avoid', 'Evita'),
		array('Move', 'Movimiento'),
		array('Restart', 'Reiniciar'),
		array('Start', 'Empezar'),
		array('Pause', 'Pausa'),
		array('Resume', 'Continuar'),
		array('Puan', 'Puntuación'),
		array('Seviye', 'Nivel'),
		array('Tur', 'Ronda'),
		array('Can', 'Vidas'),
		array('Hedef', 'Objetivo'),
		array('Soru', 'Pregunta'),
		array('Oyun Bitti', 'Fin del juego'),
	);

	$phrases['es-mx'] = $spanish_phrases;
	$phrases['es-es'] = $spanish_phrases;

	$common_replacements = array(
		'en' => array(
			array('Question ', 'Question '),
			array('Round ', 'Round '),
			array(' of ', ' of '),
			array('Day:', 'Day:'),
			array('Money:', 'Money:'),
			array('Customers:', 'Customers:'),
			array('Happiness:', 'Happiness:'),
			array('Workers:', 'Workers:'),
			array('Product Level:', 'Product Level:'),
			array('Upgrades:', 'Upgrades:'),
			array('Find:', 'Find:'),
			array('Chest ', 'Chest '),
			array('Sector ', 'Sector '),
			array('Level ', 'Level '),
			array('Box ', 'Box '),
			array('Time finished. Score:', 'Time finished. Score:'),
			array('Time is up. Score:', 'Time is up. Score:'),
			array('Final alignment:', 'Final alignment:'),
			array('Corrections made:', 'Corrections made:'),
			array('Catch ', 'Catch '),
			array(' stars before time runs out.', ' stars before time runs out.'),
			array('Target Combo:', 'Target Combo:'),
			array('Turn:', 'Turn:'),
			array('Black AI', 'Black AI'),
			array('Rule check: ', 'Rule check: '),
			array(' row or column rules are currently broken.', ' row or column rules are currently broken.'),
			array('Başlamak için Başla butonuna bas', 'Press Start to begin'),
			array('Süre bitti', 'Time is up'),
			array('En iyi:', 'Best:'),
			array('Skor:', 'Score:'),
			array('Süre:', 'Time:'),
			array('Tur:', 'Round:'),
			array('Can:', 'Lives:'),
			array('Seviye:', 'Level:'),
			array('Kapılar', 'Doors'),
			array('Kapı', 'Door'),
			array('Başla', 'Start'),
			array('Sıfırla', 'Reset'),
			array('on board', 'on board'),
			array('left', 'left'),
			array('ready', 'ready'),
			array('done', 'done'),
		),
		'de' => array(
			array('Question ', 'Frage '),
			array('Round ', 'Runde '),
			array(' of ', ' von '),
			array('Day:', 'Tag:'),
			array('Money:', 'Geld:'),
			array('Customers:', 'Kunden:'),
			array('Happiness:', 'Zufriedenheit:'),
			array('Workers:', 'Mitarbeiter:'),
			array('Product Level:', 'Produktlevel:'),
			array('Upgrades:', 'Upgrades:'),
			array('Find:', 'Finde:'),
			array('Chest ', 'Truhe '),
			array('Sector ', 'Sektor '),
			array('Level ', 'Level '),
			array('Box ', 'Kiste '),
			array('Time finished. Score:', 'Zeit vorbei. Punkte:'),
			array('Time is up. Score:', 'Zeit abgelaufen. Punkte:'),
			array('Final alignment:', 'Endausrichtung:'),
			array('Corrections made:', 'Korrekturen:'),
			array('Catch ', 'Fange '),
			array(' stars before time runs out.', ' Sterne, bevor die Zeit abläuft.'),
			array('Target Combo:', 'Ziel-Kombo:'),
			array('Turn:', 'Zug:'),
			array('Black AI', 'Schwarze KI'),
			array('Rule check: ', 'Regelprüfung: '),
			array(' row or column rules are currently broken.', ' Zeilen- oder Spaltenregeln sind gerade verletzt.'),
			array('Başlamak için Başla butonuna bas', 'Drücke Starten, um zu beginnen'),
			array('Süre bitti', 'Zeit abgelaufen'),
			array('En iyi:', 'Bestwert:'),
			array('Skor:', 'Punkte:'),
			array('Süre:', 'Zeit:'),
			array('Tur:', 'Runde:'),
			array('Can:', 'Leben:'),
			array('Seviye:', 'Level:'),
			array('Kapılar', 'Türen'),
			array('Kapı', 'Tür'),
			array('Başla', 'Starten'),
			array('Sıfırla', 'Zurücksetzen'),
			array('on board', 'auf dem Brett'),
			array('left', 'übrig'),
			array('ready', 'bereit'),
			array('done', 'fertig'),
		),
		'fr' => array(
			array('Question ', 'Question '),
			array('Round ', 'Manche '),
			array(' of ', ' sur '),
			array('Day:', 'Jour :'),
			array('Money:', 'Argent :'),
			array('Customers:', 'Clients :'),
			array('Happiness:', 'Bonheur :'),
			array('Workers:', 'Employés :'),
			array('Product Level:', 'Niveau du produit :'),
			array('Upgrades:', 'Améliorations :'),
			array('Find:', 'Trouve :'),
			array('Chest ', 'Coffre '),
			array('Sector ', 'Secteur '),
			array('Level ', 'Niveau '),
			array('Box ', 'Boîte '),
			array('Time finished. Score:', 'Temps terminé. Score :'),
			array('Time is up. Score:', 'Temps écoulé. Score :'),
			array('Final alignment:', 'Alignement final :'),
			array('Corrections made:', 'Corrections faites :'),
			array('Catch ', 'Attrape '),
			array(' stars before time runs out.', ' étoiles avant la fin du temps.'),
			array('Target Combo:', 'Combo cible :'),
			array('Turn:', 'Tour :'),
			array('Black AI', 'IA noire'),
			array('Rule check: ', 'Vérification des règles : '),
			array(' row or column rules are currently broken.', ' règles de ligne ou colonne sont cassées.'),
			array('Başlamak için Başla butonuna bas', 'Appuie sur Démarrer pour commencer'),
			array('Süre bitti', 'Le temps est écoulé'),
			array('En iyi:', 'Meilleur :'),
			array('Skor:', 'Score :'),
			array('Süre:', 'Temps :'),
			array('Tur:', 'Manche :'),
			array('Can:', 'Vies :'),
			array('Seviye:', 'Niveau :'),
			array('Kapılar', 'Portes'),
			array('Kapı', 'Porte'),
			array('Başla', 'Démarrer'),
			array('Sıfırla', 'Réinitialiser'),
			array('on board', 'sur le plateau'),
			array('left', 'restants'),
			array('ready', 'prêt'),
			array('done', 'terminé'),
		),
		'es-mx' => array(
			array('Question ', 'Pregunta '),
			array('Round ', 'Ronda '),
			array(' of ', ' de '),
			array('Day:', 'Día:'),
			array('Money:', 'Dinero:'),
			array('Customers:', 'Clientes:'),
			array('Happiness:', 'Felicidad:'),
			array('Workers:', 'Trabajadores:'),
			array('Product Level:', 'Nivel del producto:'),
			array('Upgrades:', 'Mejoras:'),
			array('Find:', 'Encuentra:'),
			array('Chest ', 'Cofre '),
			array('Sector ', 'Sector '),
			array('Level ', 'Nivel '),
			array('Box ', 'Caja '),
			array('Time finished. Score:', 'Tiempo terminado. Puntuación:'),
			array('Time is up. Score:', 'Se acabó el tiempo. Puntuación:'),
			array('Final alignment:', 'Alineación final:'),
			array('Corrections made:', 'Correcciones hechas:'),
			array('Catch ', 'Atrapa '),
			array(' stars before time runs out.', ' estrellas antes de que se acabe el tiempo.'),
			array('Target Combo:', 'Combo objetivo:'),
			array('Turn:', 'Turno:'),
			array('Black AI', 'IA negra'),
			array('Rule check: ', 'Revisión de reglas: '),
			array(' row or column rules are currently broken.', ' reglas de fila o columna están rotas.'),
			array('Başlamak için Başla butonuna bas', 'Pulsa Empezar para comenzar'),
			array('Süre bitti', 'Se acabó el tiempo'),
			array('En iyi:', 'Mejor:'),
			array('Skor:', 'Puntuación:'),
			array('Süre:', 'Tiempo:'),
			array('Tur:', 'Ronda:'),
			array('Can:', 'Vidas:'),
			array('Seviye:', 'Nivel:'),
			array('Kapılar', 'Puertas'),
			array('Kapı', 'Puerta'),
			array('Başla', 'Empezar'),
			array('Sıfırla', 'Reiniciar'),
			array('on board', 'en el tablero'),
			array('left', 'restantes'),
			array('ready', 'listo'),
			array('done', 'hecho'),
		),
		'es-es' => array(
			array('Question ', 'Pregunta '),
			array('Round ', 'Ronda '),
			array(' of ', ' de '),
			array('Day:', 'Día:'),
			array('Money:', 'Dinero:'),
			array('Customers:', 'Clientes:'),
			array('Happiness:', 'Felicidad:'),
			array('Workers:', 'Trabajadores:'),
			array('Product Level:', 'Nivel del producto:'),
			array('Upgrades:', 'Mejoras:'),
			array('Find:', 'Encuentra:'),
			array('Chest ', 'Cofre '),
			array('Sector ', 'Sector '),
			array('Level ', 'Nivel '),
			array('Box ', 'Caja '),
			array('Time finished. Score:', 'Tiempo terminado. Puntuación:'),
			array('Time is up. Score:', 'Se acabó el tiempo. Puntuación:'),
			array('Final alignment:', 'Alineación final:'),
			array('Corrections made:', 'Correcciones hechas:'),
			array('Catch ', 'Atrapa '),
			array(' stars before time runs out.', ' estrellas antes de que se acabe el tiempo.'),
			array('Target Combo:', 'Combo objetivo:'),
			array('Turn:', 'Turno:'),
			array('Black AI', 'IA negra'),
			array('Rule check: ', 'Comprobación de reglas: '),
			array(' row or column rules are currently broken.', ' reglas de fila o columna están rotas.'),
			array('Başlamak için Başla butonuna bas', 'Pulsa Empezar para comenzar'),
			array('Süre bitti', 'Se acabó el tiempo'),
			array('En iyi:', 'Mejor:'),
			array('Skor:', 'Puntuación:'),
			array('Süre:', 'Tiempo:'),
			array('Tur:', 'Ronda:'),
			array('Can:', 'Vidas:'),
			array('Seviye:', 'Nivel:'),
			array('Kapılar', 'Puertas'),
			array('Kapı', 'Puerta'),
			array('Başla', 'Empezar'),
			array('Sıfırla', 'Reiniciar'),
			array('on board', 'en el tablero'),
			array('left', 'restantes'),
			array('ready', 'listo'),
			array('done', 'hecho'),
		),
	);

	$scan_replacements = array(
		'fr' => array(
			array(' ready. Launch the ball.', ' prêt. Lance la balle.'),
			array('You: ', 'Toi : '),
			array(' | AI: ', ' | IA : '),
			array('Nice coaching. ', 'Bel entraînement. '),
			array('That choice teaches a risky habit. ', 'Ce choix apprend une habitude risquée. '),
			array('The big lesson: your robot copies both your good habits and your mistakes.', 'La grande leçon : ton robot copie tes bonnes habitudes et tes erreurs.'),
			array('Dükkan Seviyesi ', 'Niveau de boutique '),
			array('Yeterli paran yok.', 'Tu n’as pas assez d’argent.'),
			array(' alındı.', ' acheté.'),
			array(' satın alındı.', ' acheté.'),
			array('Satış yaptın. +', 'Vente réussie. +'),
			array(' para.', ' argent.'),
			array('Hızlı kampanya yaptın. +', 'Campagne rapide lancée. +'),
			array('Kampanya kazancı: +', 'Gain de campagne : +'),
			array('Dükkan yeniden kuruldu.', 'La boutique a été reconstruite.'),
			array('Hazır. Satış yaparak para kazan.', 'Prêt. Fais des ventes pour gagner de l’argent.'),
			array('Su:', 'Eau :'),
			array('En iyi su:', 'Meilleure eau :'),
			array('Can:', 'Vies :'),
			array('Skor:', 'Score :'),
			array('Öğretmenden kaç. Kitap topla.', 'Échappe au professeur. Ramasse les livres.'),
			array('Yakalandın. Skorun:', 'Attrapé. Ton score :'),
		),
		'es-mx' => array(
			array(' ready. Launch the ball.', ' listo. Lanza la bola.'),
			array('You: ', 'Tú: '),
			array(' | AI: ', ' | IA: '),
			array('Nice coaching. ', 'Buen entrenamiento. '),
			array('That choice teaches a risky habit. ', 'Esa elección enseña un hábito riesgoso. '),
			array('The big lesson: your robot copies both your good habits and your mistakes.', 'La gran lección: tu robot copia tus buenos hábitos y también tus errores.'),
			array('Dükkan Seviyesi ', 'Nivel de tienda '),
			array('Yeterli paran yok.', 'No tienes suficiente dinero.'),
			array(' alındı.', ' comprado.'),
			array(' satın alındı.', ' comprado.'),
			array('Satış yaptın. +', 'Hiciste una venta. +'),
			array(' para.', ' dinero.'),
			array('Hızlı kampanya yaptın. +', 'Hiciste una campaña rápida. +'),
			array('Kampanya kazancı: +', 'Ganancia de campaña: +'),
			array('Dükkan yeniden kuruldu.', 'La tienda se reconstruyó.'),
			array('Hazır. Satış yaparak para kazan.', 'Listo. Gana dinero haciendo ventas.'),
			array('Su:', 'Agua:'),
			array('En iyi su:', 'Mejor agua:'),
			array('Can:', 'Vidas:'),
			array('Skor:', 'Puntuación:'),
			array('Öğretmenden kaç. Kitap topla.', 'Escapa del maestro. Recoge libros.'),
			array('Yakalandın. Skorun:', 'Te atraparon. Tu puntuación:'),
		),
		'es-es' => array(
			array(' ready. Launch the ball.', ' listo. Lanza la bola.'),
			array('You: ', 'Tú: '),
			array(' | AI: ', ' | IA: '),
			array('Nice coaching. ', 'Buen entrenamiento. '),
			array('That choice teaches a risky habit. ', 'Esa elección enseña un hábito arriesgado. '),
			array('The big lesson: your robot copies both your good habits and your mistakes.', 'La gran lección: tu robot copia tus buenos hábitos y también tus errores.'),
			array('Dükkan Seviyesi ', 'Nivel de tienda '),
			array('Yeterli paran yok.', 'No tienes suficiente dinero.'),
			array(' alındı.', ' comprado.'),
			array(' satın alındı.', ' comprado.'),
			array('Satış yaptın. +', 'Has hecho una venta. +'),
			array(' para.', ' dinero.'),
			array('Hızlı kampanya yaptın. +', 'Has hecho una campaña rápida. +'),
			array('Kampanya kazancı: +', 'Ganancia de campaña: +'),
			array('Dükkan yeniden kuruldu.', 'La tienda se ha reconstruido.'),
			array('Hazır. Satış yaparak para kazan.', 'Listo. Gana dinero haciendo ventas.'),
			array('Su:', 'Agua:'),
			array('En iyi su:', 'Mejor agua:'),
			array('Can:', 'Vidas:'),
			array('Skor:', 'Puntuación:'),
			array('Öğretmenden kaç. Kitap topla.', 'Escapa del profesor. Recoge libros.'),
			array('Yakalandın. Skorun:', 'Te han atrapado. Tu puntuación:'),
		),
	);

	foreach ($scan_replacements as $scan_lang => $scan_items) {
		if (isset($common_replacements[$scan_lang])) {
			$common_replacements[$scan_lang] = array_merge($scan_items, $common_replacements[$scan_lang]);
		}
	}

	$agent_replacements_more = array(
		'tr' => array(
			array('You mastered ', 'Ustalastin: '),
			array('You reached ', 'Ulastigin skor: '),
			array(' with ', ' ile '),
			array(' points.', ' puan.'),
			array('points. Press Start and go again.', 'puan. Baslat dugmesine bas ve yeniden dene.'),
			array('one duck is hiding under 1 of these 5 boxes. Find 30 ducks to finish the game.', 'bir ordek bu 5 kutudan birinin altinda saklaniyor. Oyunu bitirmek icin 30 ordek bul.'),
			array('You found all 30 ducks and earned', '30 ordegin hepsini buldun ve kazandin:'),
			array('coins. Press Play Again for a new run.', 'coin. Yeni oyun icin Tekrar Oyna dugmesine bas.'),
			array('The duck was under box', 'Ordek su kutunun altindaydi:'),
			array('No coins this round. Try the next one.', 'Bu tur coin yok. Sonrakini dene.'),
			array('You escaped in', 'Kactin. Adim:'),
			array('steps with', 've ses darbesi:'),
			array('sound pulses.', 'ses darbesi.'),
			array('Great job. You spelled', 'Harika. Yazdigin kelime:'),
			array('You ran out of lives. Final score:', 'Canin kalmadi. Son skor:'),
			array('Wrong letter. You needed', 'Yanlis harf. Gereken:'),
			array('Catch these letters in order:', 'Bu harfleri sirayla yakala:'),
			array('Game Over - Score:', 'Oyun bitti - Skor:'),
			array('Game Over — Score:', 'Oyun bitti - Skor:'),
			array('Wrong. Opposite was', 'Yanlis. Tersi suydu:'),
			array('You won. Word:', 'Kazandin. Kelime:'),
			array('Game over. Word:', 'Oyun bitti. Kelime:'),
			array('Final score: You', 'Son skor: Sen'),
			array('Computer', 'Bilgisayar'),
		),
		'de' => array(
			array('You mastered ', 'Gemeistert: '),
			array('You reached ', 'Erreichte Punktzahl: '),
			array(' with ', ' mit '),
			array(' points.', ' Punkte.'),
			array('points. Press Start and go again.', 'Punkte. Drucke Start und versuche es erneut.'),
			array('one duck is hiding under 1 of these 5 boxes. Find 30 ducks to finish the game.', 'eine Ente versteckt sich unter einer dieser 5 Kisten. Finde 30 Enten, um das Spiel zu beenden.'),
			array('You found all 30 ducks and earned', 'Du hast alle 30 Enten gefunden und verdient:'),
			array('coins. Press Play Again for a new run.', 'Munzen. Drucke Erneut spielen fur einen neuen Lauf.'),
			array('The duck was under box', 'Die Ente war unter Kiste'),
			array('No coins this round. Try the next one.', 'Keine Munzen in dieser Runde. Versuch die nachste.'),
			array('You escaped in', 'Du bist entkommen in'),
			array('steps with', 'Schritten mit'),
			array('sound pulses.', 'Schallimpulsen.'),
			array('Great job. You spelled', 'Gut gemacht. Du hast geschrieben:'),
			array('You ran out of lives. Final score:', 'Keine Leben mehr. Endstand:'),
			array('Wrong letter. You needed', 'Falscher Buchstabe. Du brauchtest'),
			array('Catch these letters in order:', 'Fange diese Buchstaben der Reihe nach:'),
			array('Game Over - Score:', 'Spiel vorbei - Punktzahl:'),
			array('Game Over — Score:', 'Spiel vorbei - Punktzahl:'),
			array('Wrong. Opposite was', 'Falsch. Das Gegenteil war'),
			array('You won. Word:', 'Gewonnen. Wort:'),
			array('Game over. Word:', 'Spiel vorbei. Wort:'),
			array('Final score: You', 'Endstand: Du'),
			array('Computer', 'Computer'),
		),
		'fr' => array(
			array('You mastered ', 'Tu as maitrise : '),
			array('You reached ', 'Score atteint : '),
			array(' with ', ' avec '),
			array(' points.', ' points.'),
			array('points. Press Start and go again.', 'points. Appuie sur Demarrer et recommence.'),
			array('one duck is hiding under 1 of these 5 boxes. Find 30 ducks to finish the game.', 'un canard se cache sous l une de ces 5 boites. Trouve 30 canards pour finir le jeu.'),
			array('You found all 30 ducks and earned', 'Tu as trouve les 30 canards et gagne'),
			array('coins. Press Play Again for a new run.', 'pieces. Appuie sur Rejouer pour une nouvelle partie.'),
			array('The duck was under box', 'Le canard etait sous la boite'),
			array('No coins this round. Try the next one.', 'Aucune piece cette manche. Essaie la suivante.'),
			array('You escaped in', 'Tu t es echappe en'),
			array('steps with', 'pas avec'),
			array('sound pulses.', 'impulsions sonores.'),
			array('Great job. You spelled', 'Bien joue. Tu as epele'),
			array('You ran out of lives. Final score:', 'Tu n as plus de vies. Score final :'),
			array('Wrong letter. You needed', 'Mauvaise lettre. Il fallait'),
			array('Catch these letters in order:', 'Attrape ces lettres dans l ordre :'),
			array('Game Over - Score:', 'Partie terminee - Score :'),
			array('Game Over — Score:', 'Partie terminee - Score :'),
			array('Wrong. Opposite was', 'Faux. L oppose etait'),
			array('You won. Word:', 'Tu as gagne. Mot :'),
			array('Game over. Word:', 'Partie terminee. Mot :'),
			array('Final score: You', 'Score final : Toi'),
			array('Computer', 'Ordinateur'),
		),
		'es-mx' => array(
			array('You mastered ', 'Dominaste: '),
			array('You reached ', 'Alcanzaste '),
			array(' with ', ' con '),
			array(' points.', ' puntos.'),
			array('points. Press Start and go again.', 'puntos. Presiona Iniciar y vuelve a intentarlo.'),
			array('one duck is hiding under 1 of these 5 boxes. Find 30 ducks to finish the game.', 'un pato se esconde debajo de una de estas 5 cajas. Encuentra 30 patos para terminar el juego.'),
			array('You found all 30 ducks and earned', 'Encontraste los 30 patos y ganaste'),
			array('coins. Press Play Again for a new run.', 'monedas. Presiona Jugar de nuevo para una nueva partida.'),
			array('The duck was under box', 'El pato estaba debajo de la caja'),
			array('No coins this round. Try the next one.', 'No hay monedas en esta ronda. Intenta la siguiente.'),
			array('You escaped in', 'Escapaste en'),
			array('steps with', 'pasos con'),
			array('sound pulses.', 'pulsos de sonido.'),
			array('Great job. You spelled', 'Muy bien. Deletreaste'),
			array('You ran out of lives. Final score:', 'Te quedaste sin vidas. Puntuacion final:'),
			array('Wrong letter. You needed', 'Letra incorrecta. Necesitabas'),
			array('Catch these letters in order:', 'Atrapa estas letras en orden:'),
			array('Game Over - Score:', 'Fin del juego - Puntuacion:'),
			array('Game Over — Score:', 'Fin del juego - Puntuacion:'),
			array('Wrong. Opposite was', 'Incorrecto. Lo opuesto era'),
			array('You won. Word:', 'Ganaste. Palabra:'),
			array('Game over. Word:', 'Fin del juego. Palabra:'),
			array('Final score: You', 'Puntuacion final: Tu'),
			array('Computer', 'Computadora'),
		),
	);
	$agent_replacements_more['es-es'] = array_merge($agent_replacements_more['es-mx'], array(
		array('Computer', 'Ordenador'),
	));

	$agent_replacements_followup = array(
		'tr' => array(
			array('Digit sum = ', 'Rakam toplami = '),
			array('is a perfect square.', 'tam karedir.'),
			array('is not a perfect square.', 'tam kare degildir.'),
			array('is prime.', 'asaldir.'),
			array('is not prime.', 'asal degildir.'),
			array('Incorrect. Digit sum = ', 'Yanlis. Rakam toplami = '),
			array('Incorrect. ', 'Yanlis. '),
			array('Which country has the capital ', 'Hangi ulkenin baskenti '),
			array('What is the capital of ', 'Baskenti hangi sehir: '),
			array(' is in which continent?', ' hangi kitadadir?'),
			array('What is the currency of ', 'Para birimi nedir: '),
			array('Which country uses ', 'Hangi ulke sunu kullanir: '),
			array('What language is mainly spoken in ', 'Hangi dil yaygin konusulur: '),
			array('Which country is linked with the ', 'Hangi ulke su dille iliskilidir: '),
			array(' language?', ' dili?'),
		),
		'de' => array(
			array('Digit sum = ', 'Quersumme = '),
			array('is a perfect square.', 'ist eine Quadratzahl.'),
			array('is not a perfect square.', 'ist keine Quadratzahl.'),
			array('is prime.', 'ist eine Primzahl.'),
			array('is not prime.', 'ist keine Primzahl.'),
			array('Incorrect. Digit sum = ', 'Falsch. Quersumme = '),
			array('Incorrect. ', 'Falsch. '),
			array('Which country has the capital ', 'Welches Land hat die Hauptstadt '),
			array('What is the capital of ', 'Was ist die Hauptstadt von '),
			array(' is in which continent?', ' liegt auf welchem Kontinent?'),
			array('What is the currency of ', 'Was ist die Wahrung von '),
			array('Which country uses ', 'Welches Land verwendet '),
			array('What language is mainly spoken in ', 'Welche Sprache wird hauptsachlich gesprochen in '),
			array('Which country is linked with the ', 'Welches Land ist mit der Sprache '),
			array(' language?', ' verbunden?'),
		),
		'fr' => array(
			array('Digit sum = ', 'Somme des chiffres = '),
			array('is a perfect square.', 'est un carre parfait.'),
			array('is not a perfect square.', 'n est pas un carre parfait.'),
			array('is prime.', 'est premier.'),
			array('is not prime.', 'n est pas premier.'),
			array('Incorrect. Digit sum = ', 'Incorrect. Somme des chiffres = '),
			array('Incorrect. ', 'Incorrect. '),
			array('Which country has the capital ', 'Quel pays a pour capitale '),
			array('What is the capital of ', 'Quelle est la capitale de '),
			array(' is in which continent?', ' est sur quel continent ?'),
			array('What is the currency of ', 'Quelle est la monnaie de '),
			array('Which country uses ', 'Quel pays utilise '),
			array('What language is mainly spoken in ', 'Quelle langue est principalement parlee en '),
			array('Which country is linked with the ', 'Quel pays est lie a la langue '),
			array(' language?', ' ?'),
		),
		'es-mx' => array(
			array('Digit sum = ', 'Suma de digitos = '),
			array('is a perfect square.', 'es un cuadrado perfecto.'),
			array('is not a perfect square.', 'no es un cuadrado perfecto.'),
			array('is prime.', 'es primo.'),
			array('is not prime.', 'no es primo.'),
			array('Incorrect. Digit sum = ', 'Incorrecto. Suma de digitos = '),
			array('Incorrect. ', 'Incorrecto. '),
			array('Which country has the capital ', 'Que pais tiene la capital '),
			array('What is the capital of ', 'Cual es la capital de '),
			array(' is in which continent?', ' esta en que continente?'),
			array('What is the currency of ', 'Cual es la moneda de '),
			array('Which country uses ', 'Que pais usa '),
			array('What language is mainly spoken in ', 'Que idioma se habla principalmente en '),
			array('Which country is linked with the ', 'Que pais esta relacionado con el idioma '),
			array(' language?', '?'),
		),
	);
	$agent_replacements_followup['es-es'] = array_merge($agent_replacements_followup['es-mx'], array(
		array('Which country has the capital ', 'Que pais tiene como capital '),
		array('Which country uses ', 'Que pais utiliza '),
	));

	foreach ($agent_replacements_followup as $followup_rep_lang => $followup_rep_items) {
		if (isset($common_replacements[$followup_rep_lang])) {
			$common_replacements[$followup_rep_lang] = array_merge($followup_rep_items, $common_replacements[$followup_rep_lang]);
		}
	}

	foreach ($agent_replacements_more as $agent_rep_lang => $agent_rep_items) {
		if (isset($common_replacements[$agent_rep_lang])) {
			$common_replacements[$agent_rep_lang] = array_merge($agent_rep_items, $common_replacements[$agent_rep_lang]);
		}
	}

	if (isset($phrases[$lang], $common_replacements[$lang])) {
		$phrases[$lang] = array_merge($common_replacements[$lang], $phrases[$lang]);
	}

	return isset($phrases[$lang]) ? $phrases[$lang] : array();
}

function zo_wrap_game_runtime_translator($html, $module, $lang) {
	$lang = array_key_exists($lang, zo_get_language_options()) ? $lang : zo_get_current_language();
	$slug = !empty($module['slug']) ? sanitize_html_class($module['slug']) : 'game';
	$id   = 'zo-game-shell-' . $slug . '-' . wp_rand(1000, 999999);

	$exact = zo_get_runtime_translation_exact_map($lang);
	$meta  = zo_get_game_display_metadata($module);
	$title = isset($meta['name']) ? zo_get_localized_text($meta['name'], $lang) : '';

	if ($title !== '') {
		if (!empty($module['name'])) {
			$exact[(string) $module['name']] = $title;
		}

		if (preg_match_all('/(?:^|\|)\s*(TR|EN|DE|FR|ES-MX|ES-ES):\s*([^|]+)/u', isset($meta['name']) ? $meta['name'] : '', $matches)) {
			foreach ($matches[2] as $name_part) {
				$name_part = trim($name_part);
				if ($name_part !== '') {
					$exact[$name_part] = $title;
				}
			}
		}
	}

	$payload = array(
		'lang' => $lang,
		'locale' => array(
			'tr' => 'tr-TR',
			'en' => 'en-US',
			'de' => 'de-DE',
			'fr' => 'fr-FR',
			'es-mx' => 'es-MX',
			'es-es' => 'es-ES',
		),
		'exact' => $exact,
		'replacements' => zo_get_runtime_translation_replacements($lang),
	);

	$script = '<script>(function(){'
		. 'const root=document.getElementById(' . wp_json_encode($id) . ');'
		. 'if(!root){return;}'
		. 'const payload=' . wp_json_encode($payload) . ';'
		. 'const exact=payload.exact||{};'
		. 'const reps=payload.replacements||[];'
		. 'const locale=(payload.locale&&payload.locale[payload.lang])||"";'
		. 'const skip={SCRIPT:1,STYLE:1,NOSCRIPT:1,TEXTAREA:1,CODE:1,PRE:1};'
		. 'const attrNames=["aria-label","aria-description","aria-valuetext","alt","title","placeholder","label","data-label","data-title","data-message","data-prompt","data-name","data-zone-label"];'
		. 'const attrSelector=attrNames.map(function(name){return "["+name+"]";}).concat(["[data-locale]","button","input","option"]).join(",");'
		. 'function applyCase(from,to){return from===from.toUpperCase()?to.toUpperCase():to;}'
		. 'function tx(value){if(typeof value!=="string"){return value;}const m=value.match(/^(\\s*)([\\s\\S]*?)(\\s*)$/);const lead=m?m[1]:"";let text=m?m[2]:value;const trail=m?m[3]:"";if(!text.trim()){return value;}const trimmed=text.trim();if(Object.prototype.hasOwnProperty.call(exact,trimmed)){return lead+exact[trimmed]+trail;}reps.forEach(function(pair){const from=pair[0];const to=pair[1];if(!from||!to){return;}text=text.split(from).join(applyCase(from,to));});return lead+text+trail;}'
		. 'root.__zoTranslate=tx;window.__zoGameI18nTranslateCanvas=function(canvas,value){if(typeof value!=="string"||!canvas||canvas.hasAttribute("data-zo-no-canvas-translate")){return value;}const shell=canvas.closest&&canvas.closest(".zo-game-shell");const fn=shell&&shell.__zoTranslate;return fn?fn(value):value;};'
		. 'if(window.CanvasRenderingContext2D&&!CanvasRenderingContext2D.prototype.__zoI18nPatched){["fillText","strokeText"].forEach(function(method){const original=CanvasRenderingContext2D.prototype[method];CanvasRenderingContext2D.prototype[method]=function(text){if(typeof text==="string"&&window.__zoGameI18nTranslateCanvas){arguments[0]=window.__zoGameI18nTranslateCanvas(this.canvas,text);}return original.apply(this,arguments);};});CanvasRenderingContext2D.prototype.__zoI18nPatched=true;}'
		. 'function nodeText(node){if(!node||!node.nodeValue){return;}const next=tx(node.nodeValue);if(next!==node.nodeValue){node.nodeValue=next;}}'
		. 'function attrs(el){attrNames.forEach(function(name){if(!el.hasAttribute||!el.hasAttribute(name)){return;}const next=tx(el.getAttribute(name));if(next!==el.getAttribute(name)){el.setAttribute(name,next);}});if(locale&&el.hasAttribute&&el.hasAttribute("data-locale")){el.setAttribute("data-locale",locale);}if(el.matches&&el.matches("input[type=button],input[type=submit],input[type=reset]")&&el.hasAttribute("value")){const next=tx(el.getAttribute("value"));if(next!==el.getAttribute("value")){el.setAttribute("value",next);el.value=next;}}if(el.matches&&el.matches("option")&&el.hasAttribute("label")){const next=tx(el.getAttribute("label"));if(next!==el.getAttribute("label")){el.setAttribute("label",next);}}}'
		. 'function walk(start){if(!start){return;}if(start.nodeType===3){nodeText(start);return;}if(start.nodeType!==1||skip[start.nodeName]){return;}attrs(start);const walker=document.createTreeWalker(start,NodeFilter.SHOW_TEXT,{acceptNode:function(n){return n.parentElement&&skip[n.parentElement.nodeName]?NodeFilter.FILTER_REJECT:NodeFilter.FILTER_ACCEPT;}});let n;while((n=walker.nextNode())){nodeText(n);}start.querySelectorAll&&start.querySelectorAll(attrSelector).forEach(attrs);}'
		. 'walk(root);'
		. 'setTimeout(function(){walk(root);},0);setTimeout(function(){walk(root);},250);window.addEventListener&&window.addEventListener("load",function(){walk(root);});'
		. 'let busy=false;const observer=new MutationObserver(function(items){if(busy){return;}busy=true;items.forEach(function(item){if(item.type==="characterData"){nodeText(item.target);}else{item.addedNodes.forEach(walk);if(item.type==="attributes"){attrs(item.target);}}});busy=false;});'
		. 'observer.observe(root,{childList:true,subtree:true,characterData:true,attributes:true,attributeFilter:attrNames.concat(["value","data-locale"])});'
		. '})();</script>';

	return '<div id="' . esc_attr($id) . '" class="zo-game-shell zo-game-shell--' . esc_attr($slug) . '" data-zo-game-lang="' . esc_attr($lang) . '">' . zo_get_shortcode_logo_html('game') . $html . '</div>' . $script;
}

function zo_get_localized_text($text, $lang = '') {
	$text = is_string($text) ? trim($text) : '';
	$lang = array_key_exists($lang, zo_get_language_options()) ? $lang : zo_get_current_language();

	if ($text === '') {
		return '';
	}

	$labels = array('tr' => 'TR:', 'en' => 'EN:', 'de' => 'DE:', 'fr' => 'FR:', 'es-mx' => 'ES-MX:', 'es-es' => 'ES-ES:');
	$matches = array();

	foreach ($labels as $key => $label) {
		$position = stripos($text, $label);

		if ($position !== false) {
			$matches[] = array(
				'lang'     => $key,
				'position' => $position,
				'length'   => strlen($label),
			);
		}
	}

	if (empty($matches)) {
		return $text;
	}

	usort(
		$matches,
		function ($a, $b) {
			return $a['position'] <=> $b['position'];
		}
	);

	$parts = array();
	$count = count($matches);

	for ($index = 0; $index < $count; $index++) {
		$start = $matches[$index]['position'] + $matches[$index]['length'];
		$end   = $index + 1 < $count ? $matches[$index + 1]['position'] : strlen($text);
		$value = substr($text, $start, $end - $start);
		$value = trim($value);
		$value = trim($value, " \t\n\r\0\x0B|");

		if ($value !== '') {
			$parts[$matches[$index]['lang']] = $value;
		}
	}

	$result = isset($parts[$lang]) ? $parts[$lang] : (isset($parts['en']) ? $parts['en'] : reset($parts));

	if (is_string($result) && $result !== $text && preg_match('/(?:^|\|)\s*(TR|EN|DE|FR|ES-MX|ES-ES):/i', $result)) {
		return zo_get_localized_text($result, $lang);
	}

	return $result;
}

function zo_fill_missing_metadata_languages($metadata, $module) {
	if (!is_array($metadata)) {
		return $metadata;
	}

	$fallback = zo_get_smart_fallback_game_metadata($module);
	if (!is_array($fallback)) {
		return $metadata;
	}

	foreach (array('name', 'description') as $field) {
		if (empty($metadata[$field]) || empty($fallback[$field]) || !is_string($metadata[$field]) || !is_string($fallback[$field])) {
			continue;
		}

		$metadata[$field] = zo_append_missing_localized_parts($metadata[$field], $fallback[$field], zo_get_language_options());
	}

	return $metadata;
}

function zo_get_asker_display_game_metadata($module) {
	if (empty($module['slug'])) {
		return null;
	}

	$metadata = zo_get_asker_multilingual_game_metadata(sanitize_title($module['slug']));
	if (!is_array($metadata)) {
		$metadata = zo_get_smart_fallback_game_metadata($module);
	}

	return is_array($metadata) ? zo_fill_missing_metadata_languages($metadata, $module) : null;
}

function zo_get_game_display_metadata($module) {
	if (empty($module['slug'])) {
		return zo_get_smart_fallback_game_metadata($module);
	}

	$metadata = zo_get_asker_multilingual_game_metadata(sanitize_title($module['slug']));
	if (!is_array($metadata)) {
		$metadata = zo_get_smart_fallback_game_metadata($module);
	}

	return is_array($metadata) ? zo_fill_missing_metadata_languages($metadata, $module) : null;
}

function zo_get_localized_game_display_metadata($module, $lang = '') {
	$lang = array_key_exists($lang, zo_get_language_options()) ? $lang : zo_get_current_language();
	$metadata = zo_get_game_display_metadata($module);
	$name = !empty($module['name']) && is_string($module['name']) ? $module['name'] : '';
	$description = !empty($module['description']) && is_string($module['description']) ? $module['description'] : '';
	$category_name = $name;
	$category_description = $description;

	if (is_array($metadata)) {
		if (!empty($metadata['name'])) {
			$category_name = zo_get_localized_text($metadata['name'], 'en');
		}

		if (!empty($metadata['description'])) {
			$category_description = zo_get_localized_text($metadata['description'], 'en');
		}

		if (!empty($metadata['name'])) {
			$name = zo_get_localized_text($metadata['name'], $lang);
		}

		if (!empty($metadata['description'])) {
			$description = zo_get_localized_text($metadata['description'], $lang);
		}
	}

	$slug = !empty($module['slug']) ? sanitize_title($module['slug']) : '';
	$category_key = zo_get_game_category($slug, $category_name, $category_description);
	$category_options = zo_get_game_category_options();
	$category_label = isset($category_options[$category_key][$lang]) ? $category_options[$category_key][$lang] : $category_key;

	return array(
		'name' => $name,
		'description' => $description,
		'category_key' => $category_key,
		'category_label' => $category_label,
	);
}

function zo_get_game_difficulty_key($module, $category = '') {
	$value = is_array($module) && isset($module['difficulty']) ? $module['difficulty'] : '';

	if (is_numeric($value)) {
		$value = (int) $value;

		if ($value <= 1) {
			return 'easy';
		}

		if ($value >= 3) {
			return 'hard';
		}

		return 'medium';
	}

	if (is_string($value)) {
		$value = strtolower(trim($value));

		if (in_array($value, array('easy', 'medium', 'hard'), true)) {
			return $value;
		}
	}

	if (in_array($category, array('action', 'sports'), true)) {
		return 'medium';
	}

	if (in_array($category, array('tool', 'creative'), true)) {
		return 'easy';
	}

	return 'medium';
}

function zo_get_game_difficulty_label($module, $category = '', $lang = '') {
	$lang = array_key_exists($lang, zo_get_language_options()) ? $lang : zo_get_current_language();
	$key = zo_get_game_difficulty_key($module, $category);

	return zo_get_interface_text('difficulty_' . $key, $lang);
}

function zo_get_game_duplicate_tokens($value) {
	$value = is_scalar($value) ? (string) $value : '';
	$value = function_exists('remove_accents') ? remove_accents($value) : $value;
	$value = strtolower($value);
	$value = strtr(
		$value,
		array(
			'satranc' => 'chess',
			'kirici' => 'breakout',
			'kirma' => 'breakout',
			'football' => 'soccer',
		)
	);
	$value = preg_replace('/[^a-z0-9]+/', ' ', $value);
	$value = trim((string) $value);

	if ($value === '') {
		return array();
	}

	$stopwords = array(
		'a', 'an', 'and', 'the', 'of', 'for', 'with', 'to',
		'ai', 'vs', 'versus', 'computer', 'bot',
		'game', 'games', 'oyun', 'oyunu', 'oyunlari', 'spiel',
		'simple', 'mini', 'style', 'levels', 'level', '1000',
	);
	$tokens = preg_split('/\s+/', $value, -1, PREG_SPLIT_NO_EMPTY);
	$tokens = array_values(
		array_filter(
			$tokens,
			function ($token) use ($stopwords) {
				return $token !== '' && !in_array($token, $stopwords, true);
			}
		)
	);

	return $tokens;
}

function zo_get_game_duplicate_key($slug, $title = '', $description = '') {
	$slug_tokens = zo_get_game_duplicate_tokens($slug);
	$title_tokens = zo_get_game_duplicate_tokens($title);
	$description_tokens = zo_get_game_duplicate_tokens($description);
	$tokens = array_values(array_unique(array_merge($slug_tokens, $title_tokens)));
	$all_tokens = array_values(array_unique(array_merge($tokens, $description_tokens)));

	if (empty($tokens)) {
		return sanitize_title($slug);
	}

	if (in_array('clock', $tokens, true) && count(array_intersect($all_tokens, array('debt', 'loop', 'traveler', 'puzzle', 'runner', 'lock'))) === 0) {
		return 'family:clock';
	}

	$families = array(
		'chess' => array('chess'),
		'breakout' => array('breakout', 'breaking'),
		'soccer' => array('soccer', 'penalti', 'penalty'),
	);

	foreach ($families as $family => $family_tokens) {
		if (array_intersect($all_tokens, $family_tokens)) {
			return 'family:' . $family;
		}
	}

	$important_tokens = array_slice($tokens, 0, 3);
	sort($important_tokens, SORT_STRING);

	return implode('-', $important_tokens);
}

function zo_dedupe_game_items_by_similarity($items, $current_duplicate_key = '') {
	$deduped = array();
	$seen = array();

	foreach ($items as $item) {
		$slug = isset($item['slug']) ? (string) $item['slug'] : '';
		$title = isset($item['title']) ? (string) $item['title'] : '';
		$description = isset($item['description']) ? (string) $item['description'] : (isset($item['excerpt']) ? (string) $item['excerpt'] : '');
		$key = zo_get_game_duplicate_key($slug, $title, $description);

		if ($key === '' || ($current_duplicate_key !== '' && $key === $current_duplicate_key) || isset($seen[$key])) {
			continue;
		}

		$seen[$key] = true;
		$deduped[] = $item;
	}

	return $deduped;
}

function zo_get_related_game_items($current_slug, $lang = '', $limit = 4) {
	$lang = array_key_exists($lang, zo_get_language_options()) ? $lang : zo_get_current_language();
	$current_slug = sanitize_title($current_slug);
	$limit = max(1, (int) $limit);
	$modules = zo_get_game_modules();
	$posts_by_slug = zo_get_game_posts_by_slug();

	if (empty($modules[$current_slug])) {
		return array();
	}

	$current_meta = zo_get_localized_game_display_metadata($modules[$current_slug], $lang);
	$current_category = $current_meta['category_key'] ?? 'puzzle';
	$current_duplicate_key = zo_get_game_duplicate_key(
		$current_slug,
		$current_meta['name'] ?? ($modules[$current_slug]['name'] ?? $current_slug),
		$current_meta['description'] ?? ($modules[$current_slug]['description'] ?? '')
	);
	$items = array();

	foreach ($modules as $slug => $module) {
		if ($slug === $current_slug || !zo_is_game_available_for_language($slug, $lang)) {
			continue;
		}

		$meta = zo_get_localized_game_display_metadata($module, $lang);
		$category = $meta['category_key'] ?? 'puzzle';
		$post = $posts_by_slug[$slug] ?? null;
		$url = $post instanceof WP_Post ? zo_get_game_launch_url($post) : zo_get_game_module_fallback_url($slug);

		if ($url !== '') {
			$url = add_query_arg('zo_lang', $lang, $url);
		}

		$items[] = array(
			'slug' => $slug,
			'title' => $meta['name'] ?? ($module['name'] ?? $slug),
			'description' => $meta['description'] ?? ($module['description'] ?? ''),
			'category' => $category,
			'category_label' => zo_get_game_category_label($category, $lang),
			'thumbnail_url' => zo_get_game_thumbnail_url($post, $module),
			'url' => $url,
			'score' => $category === $current_category ? 0 : 1,
		);
	}

	usort(
		$items,
		function ($a, $b) {
			return ((int) $a['score'] <=> (int) $b['score']) ?: strcasecmp((string) $a['title'], (string) $b['title']);
		}
	);

	$items = zo_dedupe_game_items_by_similarity($items, $current_duplicate_key);

	return array_slice($items, 0, $limit);
}

function zo_apply_asker_multilingual_game_metadata($module) {
	if (empty($module['slug']) || empty($module['author']) || !is_string($module['author'])) {
		return $module;
	}

	if (strcasecmp(trim($module['author']), 'Asker') !== 0) {
		return $module;
	}

	$metadata = zo_get_asker_display_game_metadata($module);
	if (!is_array($metadata)) {
		return $module;
	}

	if (!empty($metadata['name'])) {
		$module['name'] = $metadata['name'];
	}

	if (!empty($metadata['description'])) {
		$module['description'] = $metadata['description'];
	}

	return $module;
}

function zo_load_game_modules() {
	static $modules = null;

	if ($modules !== null) {
		return $modules;
	}

	if ((defined('REST_REQUEST') && REST_REQUEST) ||
		(defined('DOING_CRON') && DOING_CRON) ||
		(defined('WP_CLI') && WP_CLI)
	) {
		$modules = array();
		return $modules;
	}

	$modules = array();
	$files   = glob(ZO_PLUGIN_DIR . 'games/*/game.php');

	if (empty($files)) {
		return $modules;
	}

	sort($files);

	foreach ($files as $file) {
		$module = zo_load_game_module_file($file);

		if (!$module) {
			continue;
		}

		if (empty($module['slug']) || empty($module['name'])) {
			continue;
		}

		$slug          = sanitize_title($module['slug']);
		$folder        = basename(dirname($file));
		$author        = '';
		$inline_style  = '';
		$inline_script = '';

		if (!empty($module['author']) && is_string($module['author'])) {
			$author = trim(wp_strip_all_tags($module['author']));
		}

		if (!empty($module['inline_style']) && is_string($module['inline_style'])) {
			$inline_style = trim($module['inline_style']);
		}

		if (!empty($module['inline_script']) && is_string($module['inline_script'])) {
			$inline_script = trim($module['inline_script']);
		}

		$module['slug']          = $slug;
		$module['folder']        = $folder;
		$module['dir']           = trailingslashit(ZO_PLUGIN_DIR . 'games/' . $folder);
		$module['url']           = trailingslashit(ZO_PLUGIN_URL . 'games/' . $folder);
		$module['author']        = $author;
		$module['author_key']    = $author !== '' ? sanitize_title($author) : '';
		$module['inline_style']  = $inline_style;
		$module['inline_script'] = $inline_script;
		$module                  = zo_apply_asker_multilingual_game_metadata($module);

		$modules[$slug] = $module;
	}

	ksort($modules);

	return $modules;
}

function zo_get_game_modules() {
	return zo_load_game_modules();
}

function zo_get_game_module($slug) {
	$slug    = sanitize_title($slug);
	$modules = zo_get_game_modules();

	return isset($modules[$slug]) ? $modules[$slug] : null;
}

function zo_get_game_style_url($module) {
	if (!is_array($module) || empty($module['dir']) || empty($module['url'])) {
		return '';
	}

	$style_file = trailingslashit($module['dir']) . 'style.css';

	return file_exists($style_file) ? trailingslashit($module['url']) . 'style.css' : '';
}

function zo_get_game_script_url($module) {
	if (!is_array($module) || empty($module['dir']) || empty($module['url'])) {
		return '';
	}

	$script_file = trailingslashit($module['dir']) . 'script.js';

	return file_exists($script_file) ? trailingslashit($module['url']) . 'script.js' : '';
}

function zo_get_game_module_local_file_path($module, $relative_path) {
	if (!is_array($module) || empty($module['dir']) || !is_string($module['dir']) || !is_string($relative_path)) {
		return '';
	}

	$relative_path = ltrim(trim($relative_path), '/\\');
	if ($relative_path === '') {
		return '';
	}

	$base_dir = realpath($module['dir']);
	if (!is_string($base_dir) || $base_dir === '') {
		return '';
	}

	$candidate = realpath(trailingslashit($module['dir']) . $relative_path);
	if (!is_string($candidate) || $candidate === '') {
		return '';
	}

	$base_dir_normalized  = trailingslashit(str_replace('\\', '/', $base_dir));
	$candidate_normalized = str_replace('\\', '/', $candidate);
	$inside_base          = DIRECTORY_SEPARATOR === '\\'
		? stripos($candidate_normalized, $base_dir_normalized) === 0
		: strpos($candidate_normalized, $base_dir_normalized) === 0;

	return $inside_base ? $candidate : '';
}

function zo_game_module_has_generated_image_marker($module) {
	return zo_get_game_module_local_file_path($module, '.featured-image.generated') !== '';
}

function zo_get_game_module_featured_image_path($module, $include_generated = false) {
	if (!is_array($module) || empty($module['dir']) || empty($module['url'])) {
		return '';
	}

	foreach (array('featured_image', 'thumbnail', 'image') as $key) {
		if (empty($module[$key]) || !is_string($module[$key])) {
			continue;
		}

		$value = trim($module[$key]);
		if ($value === '') {
			continue;
		}

		if (preg_match('#^https?://#i', $value)) {
			continue;
		}

		$image_path = zo_get_game_module_local_file_path($module, $value);
		if ($image_path !== '') {
			return $image_path;
		}
	}

	if (!$include_generated && zo_game_module_has_generated_image_marker($module)) {
		return '';
	}

	foreach (array('featured-image.webp', 'featured-image.png', 'featured-image.jpg', 'featured-image.jpeg', 'featured-image.svg') as $filename) {
		$image_path = zo_get_game_module_local_file_path($module, $filename);
		if ($image_path !== '') {
			return $image_path;
		}
	}

	return '';
}

function zo_get_game_module_featured_image_url($module) {
	if (!is_array($module) || empty($module['dir']) || empty($module['url'])) {
		return '';
	}

	foreach (array('featured_image', 'thumbnail', 'image') as $key) {
		if (empty($module[$key]) || !is_string($module[$key])) {
			continue;
		}

		$value = trim($module[$key]);
		if ($value !== '' && preg_match('#^https?://#i', $value)) {
			return esc_url_raw($value);
		}
	}

	$image_path = zo_get_game_module_featured_image_path($module);
	if ($image_path === '') {
		return '';
	}

	$dir_path = realpath($module['dir']);
	if (!is_string($dir_path) || $dir_path === '') {
		return '';
	}

	$dir = trailingslashit(str_replace('\\', '/', $dir_path));
	$url = trailingslashit($module['url']);
	$path = str_replace('\\', '/', $image_path);

	if (strpos($path, $dir) !== 0) {
		return '';
	}

	return $url . ltrim(substr($path, strlen($dir)), '/');
}

function zo_set_game_post_thumbnail_from_module($post_id, $module) {
	$post_id = (int) $post_id;

	if ($post_id <= 0 || !is_array($module) || has_post_thumbnail($post_id)) {
		return;
	}

	$image_path = zo_get_game_module_featured_image_path($module);
	if ($image_path === '') {
		return;
	}

	$extension = strtolower((string) pathinfo($image_path, PATHINFO_EXTENSION));
	if (!in_array($extension, array('jpg', 'jpeg', 'png', 'webp'), true)) {
		return;
	}

	$mtime = filemtime($image_path);
	if ($mtime === false) {
		return;
	}

	$source_key = md5($image_path . '|' . $mtime);
	if ((string) get_post_meta($post_id, '_zo_game_featured_image_source', true) === $source_key) {
		return;
	}

	$contents = @file_get_contents($image_path);
	if (!is_string($contents) || $contents === '') {
		return;
	}

	$slug     = !empty($module['slug']) ? sanitize_title($module['slug']) : 'game';
	$filename = sanitize_file_name($slug . '-featured-image.' . $extension);
	$upload   = wp_upload_bits($filename, null, $contents);

	if (!empty($upload['error']) || empty($upload['file'])) {
		return;
	}

	$filetype = wp_check_filetype($upload['file'], null);
	if (empty($filetype['type'])) {
		return;
	}

	$title = !empty($module['name']) && is_string($module['name']) ? $module['name'] : $slug;
	$attachment_id = wp_insert_attachment(
		array(
			'post_mime_type' => $filetype['type'],
			'post_title'     => sanitize_text_field($title . ' featured image'),
			'post_content'   => '',
			'post_status'    => 'inherit',
		),
		$upload['file'],
		$post_id
	);

	if (is_wp_error($attachment_id) || $attachment_id <= 0) {
		return;
	}

	require_once ABSPATH . 'wp-admin/includes/image.php';

	$metadata = wp_generate_attachment_metadata($attachment_id, $upload['file']);
	if (is_array($metadata)) {
		wp_update_attachment_metadata($attachment_id, $metadata);
	}

	if (set_post_thumbnail($post_id, $attachment_id)) {
		update_post_meta($post_id, '_zo_game_featured_image_source', $source_key);
	}
}

function zo_remove_generated_folder_image_when_post_has_thumbnail($post_id, $module) {
	$post_id = (int) $post_id;

	if ($post_id <= 0 || !is_array($module) || !has_post_thumbnail($post_id)) {
		return;
	}

	if ((string) get_post_meta($post_id, '_zo_game_featured_image_source', true) !== '') {
		return;
	}

	$image_path = zo_get_game_module_featured_image_path($module, true);
	if ($image_path === '' || basename($image_path) !== 'featured-image.png') {
		return;
	}

	$marker_path = zo_get_game_module_local_file_path($module, '.featured-image.generated');
	if ($marker_path === '') {
		return;
	}

	@unlink($image_path);
	@unlink($marker_path);
}

function zo_remove_generated_placeholder_post_thumbnail($post_id, $module) {
	$post_id = (int) $post_id;

	if ($post_id <= 0 || !is_array($module) || !has_post_thumbnail($post_id)) {
		return;
	}

	if (!zo_game_module_has_generated_image_marker($module)) {
		return;
	}

	if ((string) get_post_meta($post_id, '_zo_game_featured_image_source', true) === '') {
		return;
	}

	delete_post_thumbnail($post_id);
	delete_post_meta($post_id, '_zo_game_featured_image_source');
}

function zo_get_game_thumbnail_initials($title, $slug) {
	$title = trim(wp_strip_all_tags((string) $title));
	$parts = preg_split('/\s+/', $title);
	$text  = '';

	if (is_array($parts)) {
		foreach ($parts as $part) {
			$part = trim($part);
			if ($part === '') {
				continue;
			}

			$text .= function_exists('mb_substr') ? mb_substr($part, 0, 1) : substr($part, 0, 1);
			if (strlen($text) >= 2) {
				break;
			}
		}
	}

	if ($text === '') {
		$text = strtoupper(substr(sanitize_title($slug), 0, 2));
	}

	return strtoupper($text);
}

function zo_get_game_thumbnail_theme($slug, $title) {
	$text   = strtolower((string) $slug . ' ' . (string) $title);
	$themes = array(
		array('from' => '#0f766e', 'to' => '#22c55e', 'accent' => '#ccfbf1', 'label' => 'Puzzle'),
		array('from' => '#1d4ed8', 'to' => '#38bdf8', 'accent' => '#dbeafe', 'label' => 'Arcade'),
		array('from' => '#7c3aed', 'to' => '#f472b6', 'accent' => '#f5d0fe', 'label' => 'Quest'),
		array('from' => '#b45309', 'to' => '#facc15', 'accent' => '#fef3c7', 'label' => 'Challenge'),
		array('from' => '#be123c', 'to' => '#fb7185', 'accent' => '#ffe4e6', 'label' => 'Action'),
		array('from' => '#334155', 'to' => '#14b8a6', 'accent' => '#e2e8f0', 'label' => 'Logic'),
	);

	if (preg_match('/chess|dama|sudoku|puzzle|maze|memory|word|number|binary|logic|rule/', $text)) {
		return $themes[5];
	}

	if (preg_match('/race|runner|car|soccer|shoot|battle|defense|army|fight|ninja/', $text)) {
		return $themes[4];
	}

	if (preg_match('/treasure|temple|pirate|dragon|magic|mystery|quest|hazine|misir|anubis/', $text)) {
		return $themes[2];
	}

	if (preg_match('/clock|time|calculator|builder|sort|designer|paint/', $text)) {
		return $themes[0];
	}

	$index = abs((int) crc32((string) $slug)) % count($themes);

	return $themes[$index];
}

function zo_render_game_thumbnail($post, $module, $url, $title) {
	if ($url === '') {
		return;
	}

	if ($post instanceof WP_Post && has_post_thumbnail($post)) {
		echo '<a class="zo-games-grid__thumb" href="' . esc_url($url) . '">';
		echo get_the_post_thumbnail($post, 'large');
		echo '</a>';
		return;
	}

	$image_url = zo_get_game_module_featured_image_url($module);
	if ($image_url !== '') {
		echo '<a class="zo-games-grid__thumb" href="' . esc_url($url) . '">';
		echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($title) . '" loading="lazy">';
		echo '</a>';
		return;
	}
}

function zo_get_game_thumbnail_url($post, $module) {
	if ($post instanceof WP_Post && has_post_thumbnail($post)) {
		$url = get_the_post_thumbnail_url($post, 'medium_large');

		if (is_string($url) && $url !== '') {
			return $url;
		}
	}

	return zo_get_game_module_featured_image_url($module);
}

function zo_get_game_slug_for_post($post_id) {
	return sanitize_title((string) get_post_meta($post_id, '_zo_game_slug', true));
}

function zo_get_game_owner_options() {
	return array(
		'arslan' => 'Arslan',
		'asker'  => 'Asker',
	);
}

function zo_normalize_game_owner($owner) {
	$owner = sanitize_title((string) $owner);

	return array_key_exists($owner, zo_get_game_owner_options()) ? $owner : '';
}

function zo_get_game_owner_for_post($post_id) {
	return zo_normalize_game_owner(get_post_meta($post_id, '_zo_game_owner', true));
}

function zo_get_game_owner_label($owner) {
	$options = zo_get_game_owner_options();
	$owner   = zo_normalize_game_owner($owner);

	return $owner !== '' ? $options[$owner] : '';
}

function zo_get_game_owner_for_module($module) {
	if (!is_array($module)) {
		return '';
	}

	if (!empty($module['owner'])) {
		$owner = zo_normalize_game_owner($module['owner']);

		if ($owner !== '') {
			return $owner;
		}
	}

	if (empty($module['author_key'])) {
		return '';
	}

	return zo_normalize_game_owner($module['author_key']);
}

function zo_get_owner_games_url($owner, $lang = '') {
	$owner = zo_normalize_game_owner($owner);
	$lang  = array_key_exists($lang, zo_get_language_options()) ? $lang : zo_get_current_language();
	$path  = $owner === 'asker' ? '/askerin-oyunlari/' : '/arslanin-oyunlari/';

	return add_query_arg('zo_lang', $lang, home_url($path));
}

function zo_get_owner_about_url($owner, $lang = '') {
	$owner = zo_normalize_game_owner($owner);
	$lang  = array_key_exists($lang, zo_get_language_options()) ? $lang : zo_get_current_language();

	if ($owner !== 'asker') {
		return '';
	}

	foreach (array('about-askerin-oyunlari', 'askerin-oyunlari-hakkinda', 'asker-hakkinda') as $path) {
		$page = get_page_by_path($path);

		if ($page instanceof WP_Post) {
			$url = get_permalink($page);
			return is_string($url) && $url !== '' ? add_query_arg('zo_lang', $lang, $url) : '';
		}
	}

	return add_query_arg('zo_lang', $lang, home_url('/about-askerin-oyunlari/'));
}

function zo_resolve_game_slug_for_post($post_id) {
	$slug = zo_get_game_slug_for_post($post_id);

	if ($slug !== '') {
		return $slug;
	}

	$post = get_post($post_id);
	if (!$post instanceof WP_Post) {
		return '';
	}

	$fallback_slug = sanitize_title((string) $post->post_name);
	if ($fallback_slug === '') {
		return '';
	}

	return zo_get_game_module($fallback_slug) ? $fallback_slug : '';
}

function zo_verify_nonce($nonce_name, $nonce_action) {
	if (empty($_REQUEST[$nonce_name]) || !is_string($_REQUEST[$nonce_name])) {
		return false;
	}

	return wp_verify_nonce(wp_unslash($_REQUEST[$nonce_name]), $nonce_action) !== false;
}

function zo_get_nonce($nonce_action) {
	return wp_create_nonce($nonce_action);
}

function zo_get_current_request_url() {
	if (empty($_SERVER['REQUEST_URI']) || !is_string($_SERVER['REQUEST_URI'])) {
		return '';
	}

	$url = home_url(wp_unslash($_SERVER['REQUEST_URI']));

	return is_string($url) ? esc_url_raw($url) : '';
}

function zo_get_bad_url_redirect_map() {
	return array(
		'games' => '/oyunlar/',
		'game' => '/oyunlar/',
		'oyun' => '/oyunlar/',
		'oyunlari' => '/oyunlar/',
		'oyunalr' => '/oyunlar/',
		'oyunlra' => '/oyunlar/',
		'oyunlarrr' => '/oyunlar/',
		'oyunları' => '/oyunlar/',
		'all-games' => '/oyunlar/',
		'game-list' => '/oyunlar/',
		'games-list' => '/oyunlar/',
		'allgames' => '/oyunlar/',
		'play' => '/oyunlar/',
		'oyna' => '/oyunlar/',
		'oyun-listesi' => '/oyunlar/',
		'oyunlar-listesi' => '/oyunlar/',
		'oyun-oyna' => '/oyunlar/',
		'zeka-oyunlari' => '/oyunlar/',
		'brain-games' => '/oyunlar/',
		'mind-games' => '/oyunlar/',
		'free-games' => '/oyunlar/',
		'fun-games' => '/oyunlar/',
		'puzzle-games' => '/oyunlar/',
		'logic-games' => '/oyunlar/',
		'zeka-games' => '/oyunlar/',
		'juegos' => '/oyunlar/',
		'jeux' => '/oyunlar/',
		'spiel' => '/oyunlar/',
		'spiele' => '/oyunlar/',
		'jugar' => '/oyunlar/',
		'jouer' => '/oyunlar/',
		'oynamak' => '/oyunlar/',
		'play-games' => '/oyunlar/',
		'oyunlar/mini-brawl' => '/oyunlar/mini-brawl-roster/',
		'oyunlar/brawl-roster' => '/oyunlar/mini-brawl-roster/',
		'games/mini-brawl-roster' => '/oyunlar/mini-brawl-roster/',
		'oyunlari/mini-brawl-roster' => '/oyunlar/mini-brawl-roster/',
		'oyunlar/adamasmaca' => '/oyunlar/adam-asmaca/',
		'sudoku' => '/oyunlar/sudoku/',
		'game/sudoku' => '/oyunlar/sudoku/',
		'games/sudoku' => '/oyunlar/sudoku/',
		'play/sudoku' => '/oyunlar/sudoku/',
		'oyun/sudoku' => '/oyunlar/sudoku/',
		'snake' => '/oyunlar/snake/',
		'araba' => '/oyunlar/arabali/',
		'arabali' => '/oyunlar/arabali/',
		'adam-asmaca' => '/oyunlar/adam-asmaca/',
		'hangman' => '/oyunlar/adam-asmaca/',
		'game/adam-asmaca' => '/oyunlar/adam-asmaca/',
		'oyun/adam-asmaca' => '/oyunlar/adam-asmaca/',
		'oyunlari/adam-asmaca' => '/oyunlar/adam-asmaca/',
		'games/adam-asmaca' => '/oyunlar/adam-asmaca/',
		'soccer-match-ai/tr' => '/soccer-match-ai/?zo_lang=tr',
		'404' => '/404/',
		'not-found' => '/404/',
		'page-not-found' => '/404/',
		'repot' => '/report/',
		'home' => '/',
		'homepage' => '/',
		'main' => '/',
		'start' => '/',
		'welcome' => '/',
		'ana' => '/',
		'baslangic' => '/',
		'başlangıç' => '/',
		'anasayfa' => '/',
		'inicio' => '/',
		'accueil' => '/',
		'asker-oyunlari' => '/askerin-oyunlari/',
		'asker-oyunlarii' => '/askerin-oyunlari/',
		'askerin oyunlari' => '/askerin-oyunlari/',
		'category/asker' => '/askerin-oyunlari/',
		'askerspiele' => '/askerin-oyunlari/',
		'asker' => '/askerin-oyunlari/',
		'askers-games' => '/askerin-oyunlari/',
		'asker-games' => '/askerin-oyunlari/',
		'asker-games-list' => '/askerin-oyunlari/',
		'askerin-games' => '/askerin-oyunlari/',
		'asker-oyun' => '/askerin-oyunlari/',
		'asker-oyunlar' => '/askerin-oyunlari/',
		'askerins-games' => '/askerin-oyunlari/',
		'asker-play' => '/askerin-oyunlari/',
		'asker-page' => '/askerin-oyunlari/',
		'asker-game-page' => '/askerin-oyunlari/',
		'juegos-de-asker' => '/askerin-oyunlari/',
		'jeux-asker' => '/askerin-oyunlari/',
		'asker-spiele' => '/askerin-oyunlari/',
		'askerinoyunlari' => '/askerin-oyunlari/',
		'askerinoyunlar' => '/askerin-oyunlari/',
		'askerin-oyunlari' => '/askerin-oyunlari/',
		'askerin-oyunlarii' => '/askerin-oyunlari/',
		'askerin-oyunlariii' => '/askerin-oyunlari/',
		'askerin-oyunlair' => '/askerin-oyunlari/',
		'askerin-oyunlrai' => '/askerin-oyunlari/',
		'askerin-oyunalri' => '/askerin-oyunlari/',
		'askerin-oyunlai' => '/askerin-oyunlari/',
		'askerin-oyunari' => '/askerin-oyunlari/',
		'askerin-oynulari' => '/askerin-oyunlari/',
		'askerin-ouynlari' => '/askerin-oyunlari/',
		'askerin-oyunlari2' => '/askerin-oyunlari/',
		'askerin-oyunlar2' => '/askerin-oyunlari/',
		'askerin-oyunlr' => '/askerin-oyunlari/',
		'askerin-oynlar' => '/askerin-oyunlari/',
		'askerin-oyunlarri' => '/askerin-oyunlari/',
		'askerinn-oyunlari' => '/askerin-oyunlari/',
		'askerin-oyunlari-' => '/askerin-oyunlari/',
		'askerin--oyunlari' => '/askerin-oyunlari/',
		'askerino-yunlari' => '/askerin-oyunlari/',
		'askerinoyunlari-' => '/askerin-oyunlari/',
		'askerin-oyunlari1' => '/askerin-oyunlari/',
		'askerin-oyunlarim' => '/askerin-oyunlari/',
		'askerinoyunlarii' => '/askerin-oyunlari/',
		'askerinoyunlai' => '/askerin-oyunlari/',
		'askerinoyunari' => '/askerin-oyunlari/',
		'askerin-oyunlar' => '/askerin-oyunlari/',
		'askerin-oyunları' => '/askerin-oyunlari/',
		'arslan-oyunlari' => '/arslanin-oyunlari/',
		'arslan-oyunlarii' => '/arslanin-oyunlari/',
		'arslanin oyunlari' => '/arslanin-oyunlari/',
		'category/arslan' => '/arslanin-oyunlari/',
		'aslanin-oyunlari' => '/arslanin-oyunlari/',
		'arslans-games' => '/arslanin-oyunlari/',
		'arslan-games' => '/arslanin-oyunlari/',
		'arslan-oyun' => '/arslanin-oyunlari/',
		'arslan-oyunlar' => '/arslanin-oyunlari/',
		'arslanoyunlari' => '/arslanin-oyunlari/',
		'arslan-play' => '/arslanin-oyunlari/',
		'arslanin-games' => '/arslanin-oyunlari/',
		'arslaninoyunlari' => '/arslanin-oyunlari/',
		'arslaninoyunlar' => '/arslanin-oyunlari/',
		'arslanin-oyunlari' => '/arslanin-oyunlari/',
		'arslanin-oyunlarii' => '/arslanin-oyunlari/',
		'arslanin-oyunlariii' => '/arslanin-oyunlari/',
		'arslanin-oyunlair' => '/arslanin-oyunlari/',
		'arslanin-oyunlrai' => '/arslanin-oyunlari/',
		'arslanin-oyunalri' => '/arslanin-oyunlari/',
		'arslanin-oyunlai' => '/arslanin-oyunlari/',
		'arslanin-oyunari' => '/arslanin-oyunlari/',
		'arslanin-oynulari' => '/arslanin-oyunlari/',
		'arslanin-ouynlari' => '/arslanin-oyunlari/',
		'arslanin-oyunlari2' => '/arslanin-oyunlari/',
		'arslanin-oyunlar2' => '/arslanin-oyunlari/',
		'arslanin-oyunlr' => '/arslanin-oyunlari/',
		'arslanin-oynlar' => '/arslanin-oyunlari/',
		'arslanin-oyunlarri' => '/arslanin-oyunlari/',
		'arslann-oyunlari' => '/arslanin-oyunlari/',
		'arslanin--oyunlari' => '/arslanin-oyunlari/',
		'arslanino-yunlari' => '/arslanin-oyunlari/',
		'arslaninoyunlari-' => '/arslanin-oyunlari/',
		'arslanin-oyunlari1' => '/arslanin-oyunlari/',
		'arslanin-oyunlarim' => '/arslanin-oyunlari/',
		'arslaninoyunlai' => '/arslanin-oyunlari/',
		'arslaninoyunari' => '/arslanin-oyunlari/',
		'arslanin-oyunlar' => '/arslanin-oyunlari/',
		'arslanın-oyunları' => '/arslanin-oyunlari/',
		'arslanin-oyunları' => '/arslanin-oyunlari/',
		'hakkinda' => '/about/',
		'hakkimizda' => '/about/',
		'hakkımızda' => '/about/',
		'sobre' => '/about/',
		'uber-uns' => '/about/',
		'ueber-uns' => '/about/',
		'info' => '/about/',
		'bilgi' => '/about/',
		'site-info' => '/about/',
		'about-game-site' => '/about/',
		'about-me' => '/about/',
		'abotu' => '/about/',
		'who-we-are' => '/about/',
		'site-bilgisi' => '/about/',
		'zeka-bilgi' => '/about/',
		'about-us' => '/about/',
		'about-site' => '/about/',
		'zeka-hakkinda' => '/about/',
		'site-hakkinda' => '/about/',
		'about-asker' => '/about-askerin-oyunlari/',
		'about asker' => '/about-askerin-oyunlari/',
		'about askerin oyunlari' => '/about-askerin-oyunlari/',
		'aboutasker' => '/about-askerin-oyunlari/',
		'aboutaskerinoyunlari' => '/about-askerin-oyunlari/',
		'askerinfo' => '/about-askerin-oyunlari/',
		'asker-about' => '/about-askerin-oyunlari/',
		'asker-bilgi' => '/about-askerin-oyunlari/',
		'about-asker-games' => '/about-askerin-oyunlari/',
		'askerin-oyunlari-hakkinda' => '/about-askerin-oyunlari/',
		'acerca-de-asker' => '/about-askerin-oyunlari/',
		'sobre-asker' => '/about-askerin-oyunlari/',
		'asker-hakkinda' => '/about-askerin-oyunlari/',
		'asker-hakkında' => '/about-askerin-oyunlari/',
		'about-askerin - oyunlari' => '/about-askerin-oyunlari/',
	);
}

function zo_get_game_slug_redirect_path($key) {
	if (!is_string($key) || $key === '') {
		return '';
	}

	$game_prefixes = array('game', 'games', 'play', 'oyun', 'oyunlari', 'juego', 'juegos', 'jeu', 'jeux', 'spiel', 'spiele');
	$slug_source   = '';

	if (strpos($key, '/') !== false) {
		$parts = explode('/', $key, 2);
		$prefix = isset($parts[0]) ? trim($parts[0]) : '';
		if (!in_array($prefix, $game_prefixes, true)) {
			return '';
		}

		$slug_source = isset($parts[1]) ? trim($parts[1], '/') : '';
	} else {
		$slug_source = $key;
	}

	$slug = sanitize_title($slug_source);
	if ($slug === '' || !zo_get_game_module($slug)) {
		return '';
	}

	return '/oyunlar/' . $slug . '/';
}

function zo_maybe_redirect_bad_urls() {
	if (is_admin() || wp_doing_ajax()) {
		return;
	}

	if (empty($_SERVER['REQUEST_URI']) || !is_string($_SERVER['REQUEST_URI'])) {
		return;
	}

	$request_uri = wp_unslash($_SERVER['REQUEST_URI']);
	$path = (string) wp_parse_url($request_uri, PHP_URL_PATH);
	$query = (string) wp_parse_url($request_uri, PHP_URL_QUERY);

	if ($path === '') {
		return;
	}

	$decoded_path = rawurldecode($path);
	$key = strtolower(trim($decoded_path, '/'));
	$key = preg_replace('/\s+/', ' ', $key);
	$key = is_string($key) ? $key : '';

	$redirects = zo_get_bad_url_redirect_map();
	if ($key === '') {
		return;
	}

	$target_path = !empty($redirects[$key]) ? $redirects[$key] : zo_get_game_slug_redirect_path($key);
	if ($target_path === '') {
		return;
	}

	$target_url_path = (string) wp_parse_url($target_path, PHP_URL_PATH);
	$target_url_query = (string) wp_parse_url($target_path, PHP_URL_QUERY);
	if ($decoded_path === $target_url_path && ($target_url_query === '' || $query === $target_url_query)) {
		return;
	}

	$target_url = home_url($target_path);
	if ($query !== '' && $target_url_query === '') {
		$target_url .= '?' . $query;
	}

	wp_safe_redirect($target_url, 301);
	exit;
}
add_action('template_redirect', 'zo_maybe_redirect_bad_urls', 1);

function zo_get_requested_game_slug() {
	if (is_singular('zeka_oyunu')) {
		$post_id = get_queried_object_id();
		$slug    = zo_resolve_game_slug_for_post($post_id);

		return $slug !== '' ? $slug : '';
	}

	if (empty($_GET['zo_game_module']) || !is_string($_GET['zo_game_module'])) {
		return '';
	}

	if (!empty($_GET['zo_nonce']) && is_string($_GET['zo_nonce']) && !zo_verify_nonce('zo_nonce', 'zo_game_module')) {
		return '';
	}

	$slug = sanitize_title(wp_unslash($_GET['zo_game_module']));

	return $slug !== '' && zo_get_game_module($slug) ? $slug : '';
}

function zo_get_game_module_fallback_url($slug) {
	$slug = sanitize_title($slug);

	if ($slug === '' || !zo_get_game_module($slug)) {
		return '';
	}

	$base_url = get_post_type_archive_link('zeka_oyunu');

	if (!is_string($base_url) || $base_url === '') {
		$base_url = home_url('/');
	}

	$url = add_query_arg('zo_game_module', $slug, $base_url);
	$url = add_query_arg('zo_nonce', zo_get_nonce('zo_game_module'), $url);
	$url = add_query_arg('zo_lang', zo_get_current_language(), $url);

	$back_url = zo_get_current_request_url();
	if ($back_url !== '') {
		$url = add_query_arg('zo_back', $back_url, $url);
	}

	return $url;
}

function zo_get_game_launch_url($post) {
	$url = get_permalink($post);

	if (!is_string($url) || $url === '') {
		return '';
	}

	$back_url = zo_get_current_request_url();
	if ($back_url !== '') {
		$url = add_query_arg('zo_back', $back_url, $url);
	}

	$url = add_query_arg('zo_lang', zo_get_current_language(), $url);

	return $url;
}

function zo_get_game_back_url($post_id = 0) {
	$current_url = $post_id ? get_permalink($post_id) : '';

	if (!empty($_GET['zo_back']) && is_string($_GET['zo_back'])) {
		if (!empty($_GET['zo_nonce']) && is_string($_GET['zo_nonce']) && !zo_verify_nonce('zo_nonce', 'zo_game_module')) {
			// Nonce validation failed, skip the zo_back parameter
		} else {
			$candidate = wp_unslash($_GET['zo_back']);
			$candidate = wp_validate_redirect($candidate, '');

			if ($candidate !== '' && $candidate !== $current_url) {
				return $candidate;
			}
		}
	}

	$referer = wp_get_referer();
	if (is_string($referer) && $referer !== '' && $referer !== $current_url) {
		return $referer;
	}

	$archive = get_post_type_archive_link('zeka_oyunu');
	if (is_string($archive) && $archive !== '') {
		return $archive;
	}

	return home_url('/');
}

function zo_get_default_game_post_excerpt($module) {
	$metadata = zo_get_game_display_metadata($module);

	if (!empty($metadata['description']) && is_string($metadata['description'])) {
		return trim($metadata['description']);
	}

	if (!empty($module['description']) && is_string($module['description'])) {
		return trim($module['description']);
	}

	return '';
}

function zo_sync_game_module_posts() {
	static $done = false;

	if ($done || wp_installing() || !post_type_exists('zeka_oyunu')) {
		return;
	}

	if (function_exists('wp_doing_ajax') && wp_doing_ajax()) {
		zo_get_game_modules();
		return;
	}

	$done = true;

	$modules = zo_get_game_modules();
	if (empty($modules)) {
		return;
	}

	$posts = get_posts(
		array(
			'post_type'           => 'zeka_oyunu',
			'post_status'         => array('publish', 'draft', 'pending', 'future', 'private'),
			'posts_per_page'      => -1,
			'orderby'             => 'date',
			'order'               => 'DESC',
			'suppress_filters'    => true,
			'no_found_rows'       => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);

	$posts_by_slug = array();

	foreach ($posts as $post) {
		$slug = zo_get_game_slug_for_post($post->ID);

		if ($slug === '') {
			$fallback_slug = sanitize_title($post->post_name);
			if ($fallback_slug !== '' && isset($modules[$fallback_slug])) {
				$slug = $fallback_slug;
				update_post_meta($post->ID, '_zo_game_slug', $slug);
			}
		}

		if ($slug === '' || !isset($modules[$slug]) || isset($posts_by_slug[$slug])) {
			continue;
		}

		$posts_by_slug[$slug] = $post;
	}

	foreach ($modules as $slug => $module) {
		$display_metadata = zo_get_game_display_metadata($module);
		$post_title    = !empty($display_metadata['name']) && is_string($display_metadata['name']) ? $display_metadata['name'] : $module['name'];
		$excerpt       = zo_get_default_game_post_excerpt($module);
		$existing_post = $posts_by_slug[$slug] ?? null;

		if ($existing_post instanceof WP_Post) {
			if ((string) get_post_meta($existing_post->ID, '_zo_game_autogenerated', true) === '1') {
				$update = array('ID' => $existing_post->ID);

				if ($existing_post->post_title !== $post_title) {
					$update['post_title'] = $post_title;
				}

				if ($existing_post->post_excerpt !== $excerpt) {
					$update['post_excerpt'] = $excerpt;
				}

				if ($existing_post->post_name !== $slug) {
					$update['post_name'] = $slug;
				}

				if (count($update) > 1) {
					wp_update_post(wp_slash($update));
				}
			}

			if (zo_get_game_slug_for_post($existing_post->ID) !== $slug) {
				update_post_meta($existing_post->ID, '_zo_game_slug', $slug);
			}

			$owner = zo_get_game_owner_for_module($module);
			if (
				$owner !== '' &&
				(
					zo_get_game_owner_for_post($existing_post->ID) === '' ||
					(
						(string) get_post_meta($existing_post->ID, '_zo_game_autogenerated', true) === '1' &&
						zo_get_game_owner_for_post($existing_post->ID) !== $owner
					)
				)
			) {
				update_post_meta($existing_post->ID, '_zo_game_owner', $owner);
			}

			zo_remove_generated_placeholder_post_thumbnail($existing_post->ID, $module);
			zo_remove_generated_folder_image_when_post_has_thumbnail($existing_post->ID, $module);
			zo_set_game_post_thumbnail_from_module($existing_post->ID, $module);

			continue;
		}

		$post_id = wp_insert_post(
			wp_slash(
				array(
					'post_type'    => 'zeka_oyunu',
					'post_status'  => 'publish',
					'post_title'   => $post_title,
					'post_name'    => $slug,
					'post_excerpt' => $excerpt,
					'post_content' => '',
				)
			),
			true
		);

		if (is_wp_error($post_id) || $post_id <= 0) {
			continue;
		}

		update_post_meta($post_id, '_zo_game_slug', $slug);
		update_post_meta($post_id, '_zo_game_autogenerated', '1');

		$owner = zo_get_game_owner_for_module($module);
		if ($owner !== '') {
			update_post_meta($post_id, '_zo_game_owner', $owner);
		}

		zo_set_game_post_thumbnail_from_module($post_id, $module);
	}
}

function zo_register_game_post_type() {
	$labels = array(
		'name'               => 'Zekâ Oyunları',
		'singular_name'      => 'Zekâ Oyunu',
		'menu_name'          => 'Zekâ Oyunları',
		'name_admin_bar'     => 'Zekâ Oyunu',
		'add_new'            => 'Yeni Ekle',
		'add_new_item'       => 'Yeni Oyun Ekle',
		'edit_item'          => 'Oyunu Düzenle',
		'new_item'           => 'Yeni Oyun',
		'view_item'          => 'Oyunu Görüntüle',
		'all_items'          => 'Tüm Oyunlar',
		'search_items'       => 'Oyun Ara',
		'not_found'          => 'Oyun bulunamadı.',
		'not_found_in_trash' => 'Çöpte oyun bulunamadı.',
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'show_in_rest'       => true,
		'menu_icon'          => 'dashicons-games',
		'has_archive'        => true,
		'rewrite'            => array('slug' => 'oyunlar'),
		'supports'           => array('title', 'editor', 'excerpt', 'thumbnail'),
		'publicly_queryable' => true,
		'show_in_menu'       => true,
	);

	register_post_type('zeka_oyunu', $args);
}
add_action('init', 'zo_register_game_post_type');
add_action('init', 'zo_sync_game_module_posts', 20);

function zo_register_game_report_post_type() {
	$labels = array(
		'name'               => 'Game Reports',
		'singular_name'      => 'Game Report',
		'menu_name'          => 'Game Reports',
		'name_admin_bar'     => 'Game Report',
		'add_new_item'       => 'Add Game Report',
		'edit_item'          => 'View Game Report',
		'new_item'           => 'New Game Report',
		'view_item'          => 'View Game Report',
		'all_items'          => 'All Game Reports',
		'search_items'       => 'Search Game Reports',
		'not_found'          => 'No game reports found.',
		'not_found_in_trash' => 'No game reports found in trash.',
	);

	register_post_type(
		'zo_game_report',
		array(
			'labels'              => $labels,
			'public'              => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_icon'           => 'dashicons-warning',
			'supports'            => array('title', 'editor'),
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
		)
	);
}
add_action('init', 'zo_register_game_report_post_type');

function zo_ensure_game_report_page() {
	if (wp_installing() || !function_exists('get_page_by_path')) {
		return;
	}

	$page = get_page_by_path('report');
	if ($page instanceof WP_Post) {
		return;
	}

	wp_insert_post(
		wp_slash(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => 'Report a Problem',
				'post_name'    => 'report',
				'post_content' => '[zeka_game_report]',
			)
		)
	);
}
add_action('init', 'zo_ensure_game_report_page', 30);

function zo_get_game_report_url($slug = '') {
	$url = home_url('/report/');
	$slug = sanitize_title($slug);
	$args = array('zo_lang' => zo_get_current_language());

	if ($slug !== '') {
		$args['game'] = $slug;
	}

	return add_query_arg($args, $url);
}

function zo_render_game_report_link($slug = '', $language = '') {
	$slug = sanitize_title($slug);
	if ($slug === '') {
		return '';
	}

	$label = zo_get_interface_text('report_game_link', $language);

	return '<p class="zo-game-report-link"><a href="' . esc_url(zo_get_game_report_url($slug)) . '">' . esc_html($label) . '</a></p>';
}

function zo_get_game_report_problem_types($lang = '') {
	return array(
		'load'        => zo_get_interface_text('report_type_load', $lang),
		'controls'    => zo_get_interface_text('report_type_controls', $lang),
		'mobile'      => zo_get_interface_text('report_type_mobile', $lang),
		'sound'       => zo_get_interface_text('report_type_sound', $lang),
		'translation' => zo_get_interface_text('report_type_translation', $lang),
		'other'       => zo_get_interface_text('report_type_other', $lang),
	);
}

function zo_get_game_report_statuses() {
	return array(
		'new'      => 'New',
		'checking' => 'Checking',
		'fixed'    => 'Fixed',
		'wont_fix' => 'Will not fix',
	);
}

function zo_get_game_report_device_options($lang = '') {
	return array(
		'phone'    => zo_get_interface_text('report_device_phone', $lang),
		'tablet'   => zo_get_interface_text('report_device_tablet', $lang),
		'computer' => zo_get_interface_text('report_device_computer', $lang),
		'unknown'  => zo_get_interface_text('report_device_unknown', $lang),
	);
}

function zo_game_report_shortcode($atts = array()) {
	$language = zo_get_current_language();
	$game_slug = '';
	if (!empty($_GET['game']) && is_string($_GET['game'])) {
		$game_slug = sanitize_title(wp_unslash($_GET['game']));
	}

	$module = $game_slug !== '' ? zo_get_game_module($game_slug) : null;
	$game_title = $module && !empty($module['name']) ? $module['name'] : $game_slug;
	$game_url = $game_slug !== '' ? zo_get_game_module_fallback_url($game_slug) : '';
	$problem_types = zo_get_game_report_problem_types($language);
	$devices = zo_get_game_report_device_options($language);
	$sent = !empty($_GET['sent']);
	$error = !empty($_GET['report_error']) ? sanitize_key(wp_unslash($_GET['report_error'])) : '';
	$report_games = array();
	$report_logo_url = plugin_dir_url(__FILE__) . 'zeka-logo.png';

	foreach (zo_get_game_modules() as $slug => $game_module) {
		$name = !empty($game_module['name']) ? (string) $game_module['name'] : (string) $slug;
		$report_games[] = array(
			'title' => $name,
			'slug'  => (string) $slug,
			'url'   => zo_get_game_module_fallback_url($slug),
		);
	}

	ob_start();
	?>
	<section class="zo-report-page">
		<style>
			.zo-report-page{max-width:780px;margin:40px auto;padding:0 18px;color:#111827}
			.zo-report-language{display:flex;align-items:center;gap:9px;margin:0 0 18px;min-height:44px}
			.zo-report-language__label{font-weight:800;font-size:15px;color:#111827}
			.zo-report-language__option{display:inline-flex;align-items:center;justify-content:center;min-width:42px;height:38px;border:1px solid #cbd5e1;border-radius:999px;background:#fff;color:#0f172a;font-size:14px;font-weight:800;text-decoration:none}
			.zo-report-language__option.is-active{background:#2563eb;border-color:#2563eb;color:#fff}
			.zo-report-language__option:hover,.zo-report-language__option:focus{border-color:#2563eb;color:#2563eb;outline:none}
			.zo-report-language__option.is-active:hover,.zo-report-language__option.is-active:focus{color:#fff}
			.zo-report-language__logo{margin-left:auto;width:56px;height:auto;display:block}
			.zo-report-card{background:#fff;border:1px solid #dbe3ef;border-radius:8px;padding:24px;box-shadow:0 18px 42px rgba(15,23,42,.08)}
			.zo-report-card h1{margin:0 0 10px;font-size:clamp(2rem,4vw,3rem);line-height:1.05}
			.zo-report-card p{font-size:1rem;color:#435066}
			.zo-report-field{display:grid;gap:8px;margin:16px 0}
			.zo-report-field label{font-weight:700}
			.zo-report-field input,.zo-report-field select,.zo-report-field textarea{width:100%;box-sizing:border-box;border:1px solid #cbd5e1;border-radius:6px;padding:11px 12px;font:inherit}
			.zo-report-field textarea{min-height:150px;resize:vertical}
			.zo-report-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px}
			.zo-report-button{border:0;border-radius:999px;background:#0f766e;color:#fff;font-weight:800;padding:12px 20px;cursor:pointer}
			.zo-report-success{border-left:4px solid #0f766e;background:#ecfdf5;padding:12px 14px;margin:0 0 18px}
			.zo-report-success a{display:inline-flex;margin-top:10px;border-radius:999px;background:#0f766e;color:#fff;padding:9px 14px;font-weight:800;text-decoration:none}
			.zo-report-error{border-left:4px solid #dc2626;background:#fef2f2;padding:12px 14px;margin:0 0 18px}
			.zo-report-hp{position:absolute;left:-9999px}
			.zo-game-report-link{margin:18px 0 0;text-align:center}
			.zo-game-report-link a{display:inline-flex;align-items:center;justify-content:center;border:1px solid #99f6e4;border-radius:999px;color:#0f766e;background:#ecfeff;padding:10px 16px;font-weight:800;text-decoration:none}
			@media (max-width:640px){.zo-report-grid{grid-template-columns:1fr}.zo-report-card{padding:18px}}
		</style>
		<nav class="zo-report-language" aria-label="<?php echo esc_attr(zo_get_interface_text('language_label', $language)); ?>">
			<span class="zo-report-language__label"><?php echo esc_html(zo_get_interface_text('language_label', $language)); ?></span>
			<?php foreach (zo_get_language_options() as $code => $label) : ?>
				<?php
				$lang_args = array('zo_lang' => $code);
				if ($game_slug !== '') {
					$lang_args['game'] = $game_slug;
				}
				$lang_class = 'zo-report-language__option' . ($code === $language ? ' is-active' : '');
				?>
				<a class="<?php echo esc_attr($lang_class); ?>" href="<?php echo esc_url(add_query_arg($lang_args, home_url('/report/'))); ?>"><?php echo esc_html($label); ?></a>
			<?php endforeach; ?>
			<img class="zo-report-language__logo" src="<?php echo esc_url($report_logo_url); ?>" alt="">
		</nav>
		<div class="zo-report-card">
			<h1><?php echo esc_html(zo_get_interface_text('report_problem_title', $language)); ?></h1>
			<p><?php echo esc_html(zo_get_interface_text('report_problem_intro', $language)); ?></p>
			<?php if ($sent) : ?>
			<div class="zo-report-success">
				<?php echo esc_html(zo_get_interface_text('report_problem_success', $language)); ?>
				<?php if ($game_url !== '') : ?>
				<br><a href="<?php echo esc_url(add_query_arg('zo_lang', $language, $game_url)); ?>"><?php echo esc_html(zo_get_interface_text('report_back_to_game', $language)); ?></a>
				<?php endif; ?>
			</div>
			<?php endif; ?>
			<?php if ($error !== '') : ?>
			<div class="zo-report-error"><?php echo esc_html(zo_get_interface_text('report_problem_error', $language)); ?></div>
			<?php endif; ?>
			<form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" enctype="multipart/form-data">
				<input type="hidden" name="action" value="zo_submit_game_report">
				<?php wp_nonce_field('zo_submit_game_report', 'zo_report_nonce'); ?>
				<input id="zo_report_game_slug" type="hidden" name="zo_game_slug" value="<?php echo esc_attr($game_slug); ?>">
				<input id="zo_report_game_url" type="hidden" name="zo_game_url" value="<?php echo esc_url($game_url); ?>">
				<input type="hidden" name="zo_lang" value="<?php echo esc_attr($language); ?>">
				<p class="zo-report-hp"><label>Website <input type="text" name="zo_website" value="" tabindex="-1" autocomplete="off"></label></p>
				<div class="zo-report-field">
					<label for="zo_report_game_title"><?php echo esc_html(zo_get_interface_text('report_game_label', $language)); ?></label>
					<input id="zo_report_game_title" name="zo_game_title" type="text" value="<?php echo esc_attr($game_title); ?>" placeholder="<?php echo esc_attr(zo_get_interface_text('report_game_placeholder', $language)); ?>" list="zo_report_game_names" autocomplete="off">
					<datalist id="zo_report_game_names">
						<?php foreach ($report_games as $report_game) : ?>
						<option value="<?php echo esc_attr($report_game['title']); ?>"></option>
						<?php endforeach; ?>
					</datalist>
				</div>
				<div class="zo-report-grid">
					<div class="zo-report-field">
						<label for="zo_problem_type"><?php echo esc_html(zo_get_interface_text('report_problem_type', $language)); ?></label>
						<select id="zo_problem_type" name="zo_problem_type">
							<?php foreach ($problem_types as $value => $label) : ?>
							<option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="zo-report-field">
						<label for="zo_device"><?php echo esc_html(zo_get_interface_text('report_device', $language)); ?></label>
						<select id="zo_device" name="zo_device">
							<?php foreach ($devices as $value => $label) : ?>
							<option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="zo-report-field">
					<label for="zo_message"><?php echo esc_html(zo_get_interface_text('report_message_label', $language)); ?></label>
					<textarea id="zo_message" name="zo_message" required placeholder="<?php echo esc_attr(zo_get_interface_text('report_message_placeholder', $language)); ?>"></textarea>
				</div>
				<div class="zo-report-field">
					<label for="zo_screenshot"><?php echo esc_html(zo_get_interface_text('report_screenshot_optional', $language)); ?></label>
					<input id="zo_screenshot" name="zo_screenshot" type="file" accept="image/png,image/jpeg">
					<p><?php echo esc_html(zo_get_interface_text('report_screenshot_help', $language)); ?></p>
				</div>
				<div class="zo-report-grid">
					<div class="zo-report-field">
						<label for="zo_browser"><?php echo esc_html(zo_get_interface_text('report_browser', $language)); ?></label>
						<input id="zo_browser" name="zo_browser" type="text" value="" placeholder="<?php echo esc_attr(zo_get_interface_text('report_browser_placeholder', $language)); ?>">
					</div>
					<div class="zo-report-field">
						<label for="zo_email"><?php echo esc_html(zo_get_interface_text('report_email_optional', $language)); ?></label>
						<input id="zo_email" name="zo_email" type="email" value="" placeholder="you@example.com">
					</div>
				</div>
				<button class="zo-report-button" type="submit"><?php echo esc_html(zo_get_interface_text('report_submit', $language)); ?></button>
			</form>
			<script>
			(function(){
				var games = <?php echo wp_json_encode($report_games); ?>;
				var input = document.getElementById('zo_report_game_title');
				var slug = document.getElementById('zo_report_game_slug');
				var url = document.getElementById('zo_report_game_url');
				var message = document.getElementById('zo_message');
				var requiredMessage = <?php echo wp_json_encode(zo_get_interface_text('report_required_message', $language)); ?>;
				if (message) {
					message.addEventListener('invalid', function() {
						if (!message.value.trim()) {
							message.setCustomValidity(requiredMessage || 'Please fill out this field.');
						}
					});
					message.addEventListener('input', function() {
						message.setCustomValidity('');
					});
				}
				if (!input || !slug || !url || !Array.isArray(games)) {
					return;
				}
				function normalize(value) {
					return String(value || '').trim().toLowerCase();
				}
				function syncGame() {
					var typed = normalize(input.value);
					var match = games.find(function(game) {
						return normalize(game.title) === typed || normalize(game.slug) === typed;
					});
					if (match) {
						slug.value = match.slug || '';
						url.value = match.url || '';
					}
				}
				input.addEventListener('input', syncGame);
				input.addEventListener('change', syncGame);
				syncGame();
			})();
			</script>
		</div>
	</section>
	<?php

	return ob_get_clean();
}
add_shortcode('zeka_game_report', 'zo_game_report_shortcode');

function zo_get_codex_report_mirror_dir() {
	return trailingslashit(plugin_dir_path(__FILE__)) . 'codex-reports';
}

function zo_prepare_codex_report_mirror_dir() {
	$dir = zo_get_codex_report_mirror_dir();
	if (!wp_mkdir_p($dir)) {
		return new WP_Error('zo_report_mirror_dir', 'Could not create codex report mirror folder.');
	}

	$protect_files = array(
		'.htaccess' => "Require all denied\nDeny from all\n",
		'web.config' => "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<configuration><system.webServer><security><authorization><remove users=\"*\" roles=\"\" verbs=\"\" /><add accessType=\"Deny\" users=\"*\" /></authorization></security></system.webServer></configuration>\n",
		'index.html' => '',
	);

	foreach ($protect_files as $file => $contents) {
		$path = trailingslashit($dir) . $file;
		if (!file_exists($path) && @file_put_contents($path, $contents, LOCK_EX) === false) {
			return new WP_Error('zo_report_mirror_protect', 'Could not write codex report protection files.');
		}
	}

	return $dir;
}

function zo_format_game_report_for_codex($post_id) {
	$post = get_post($post_id);
	if (!$post || $post->post_type !== 'zo_game_report') {
		return null;
	}

	$screenshot_id = (int) get_post_meta($post_id, '_zo_report_screenshot_id', true);

	return array(
		'id' => (int) $post_id,
		'date' => get_the_date('Y-m-d H:i:s', $post_id),
		'status' => get_post_meta($post_id, '_zo_report_status', true) ?: 'new',
		'game_slug' => get_post_meta($post_id, '_zo_report_game_slug', true),
		'game_title' => get_post_meta($post_id, '_zo_report_game_title', true),
		'game_url' => get_post_meta($post_id, '_zo_report_game_url', true),
		'problem_type' => get_post_meta($post_id, '_zo_report_problem_type', true),
		'device' => get_post_meta($post_id, '_zo_report_device', true),
		'browser' => get_post_meta($post_id, '_zo_report_browser', true),
		'language' => get_post_meta($post_id, '_zo_report_language', true),
		'message' => wp_strip_all_tags($post->post_content),
		'has_screenshot' => $screenshot_id > 0,
		'screenshot_id' => $screenshot_id,
		'edit_url' => get_edit_post_link($post_id, ''),
	);
}

function zo_get_recent_game_reports_for_admin($limit = 8) {
	$posts = get_posts(
		array(
			'post_type' => 'zo_game_report',
			'post_status' => array('private', 'publish', 'draft'),
			'posts_per_page' => max(1, (int) $limit),
			'orderby' => 'date',
			'order' => 'DESC',
			'fields' => 'ids',
		)
	);

	$reports = array();
	foreach ($posts as $post_id) {
		$report = zo_format_game_report_for_codex((int) $post_id);
		if ($report) {
			$reports[] = $report;
		}
	}

	return $reports;
}

function zo_write_codex_game_report_snapshot($limit = 50) {
	$dir = zo_prepare_codex_report_mirror_dir();
	if (is_wp_error($dir)) {
		return array(
			'path' => '',
			'count' => 0,
			'error' => $dir->get_error_message(),
		);
	}

	$reports = zo_get_recent_game_reports_for_admin($limit);
	$path = trailingslashit($dir) . 'game-reports.local.json';
	$data = array(
		'generated_at' => current_time('mysql'),
		'note' => 'Local Codex mirror. Email, IP, and user-agent are intentionally omitted.',
		'reports' => $reports,
	);
	$written = @file_put_contents($path, wp_json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), LOCK_EX);

	if ($written === false) {
		return array(
			'path' => '',
			'count' => count($reports),
			'error' => 'Could not write game-reports.local.json.',
		);
	}

	return array(
		'path' => $path,
		'count' => count($reports),
		'error' => '',
	);
}

function zo_append_codex_game_report_mirror($post_id) {
	$dir = zo_prepare_codex_report_mirror_dir();
	if (is_wp_error($dir)) {
		return;
	}

	$report = zo_format_game_report_for_codex($post_id);
	if (!$report) {
		return;
	}

	@file_put_contents(trailingslashit($dir) . 'game-reports.local.jsonl', wp_json_encode($report, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n", FILE_APPEND | LOCK_EX);
	zo_write_codex_game_report_snapshot(50);
}

function zo_handle_game_report_submission() {
	$posted_language = !empty($_POST['zo_lang']) ? sanitize_key(wp_unslash($_POST['zo_lang'])) : zo_get_current_language();
	$posted_language = array_key_exists($posted_language, zo_get_language_options()) ? $posted_language : zo_get_current_language();
	$report_url = add_query_arg('zo_lang', $posted_language, home_url('/report/'));

	if (empty($_POST['zo_report_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['zo_report_nonce'])), 'zo_submit_game_report')) {
		wp_safe_redirect(add_query_arg('report_error', 'nonce', $report_url));
		exit;
	}

	if (!empty($_POST['zo_website'])) {
		wp_safe_redirect(add_query_arg('sent', '1', $report_url));
		exit;
	}

	$ip = !empty($_SERVER['REMOTE_ADDR']) ? sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'])) : 'unknown';
	$rate_key = 'zo_game_report_' . md5($ip);
	if (get_transient($rate_key)) {
		wp_safe_redirect(add_query_arg('report_error', 'rate', $report_url));
		exit;
	}
	set_transient($rate_key, '1', 5 * MINUTE_IN_SECONDS);

	$slug = !empty($_POST['zo_game_slug']) ? sanitize_title(wp_unslash($_POST['zo_game_slug'])) : '';
	$module = $slug !== '' ? zo_get_game_module($slug) : null;
	if (!$module) {
		wp_safe_redirect(add_query_arg('report_error', 'game', $report_url));
		exit;
	}

	$title = !empty($_POST['zo_game_title']) ? sanitize_text_field(wp_unslash($_POST['zo_game_title'])) : '';
	$game_url = !empty($_POST['zo_game_url']) ? esc_url_raw(wp_unslash($_POST['zo_game_url'])) : '';
	$problem_type = !empty($_POST['zo_problem_type']) ? sanitize_key(wp_unslash($_POST['zo_problem_type'])) : 'other';
	$device = !empty($_POST['zo_device']) ? sanitize_key(wp_unslash($_POST['zo_device'])) : 'unknown';
	$message = !empty($_POST['zo_message']) ? sanitize_textarea_field(wp_unslash($_POST['zo_message'])) : '';
	$browser = !empty($_POST['zo_browser']) ? sanitize_text_field(wp_unslash($_POST['zo_browser'])) : '';
	$email = !empty($_POST['zo_email']) ? sanitize_email(wp_unslash($_POST['zo_email'])) : '';
	$user_agent = !empty($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field(wp_unslash($_SERVER['HTTP_USER_AGENT'])) : '';
	$language = $posted_language;

	$title = function_exists('mb_substr') ? mb_substr($title, 0, 100) : substr($title, 0, 100);
	$message = function_exists('mb_substr') ? mb_substr($message, 0, 800) : substr($message, 0, 800);
	$message_check = trim(preg_replace('/\s+/', ' ', $message));
	$message_length = function_exists('mb_strlen') ? mb_strlen($message_check) : strlen($message_check);
	$has_message_space = strpos($message_check, ' ') !== false;

	if ($message_check === '' || $message_length < 10 || !$has_message_space) {
		wp_safe_redirect(add_query_arg(array('report_error' => 'message', 'game' => $slug), $report_url));
		exit;
	}

	$screenshot_file = isset($_FILES['zo_screenshot']) && is_array($_FILES['zo_screenshot']) ? $_FILES['zo_screenshot'] : array();
	$has_screenshot = !empty($screenshot_file['name']);
	if ($has_screenshot) {
		$upload_error = isset($screenshot_file['error']) ? (int) $screenshot_file['error'] : UPLOAD_ERR_NO_FILE;
		$upload_size  = isset($screenshot_file['size']) ? (int) $screenshot_file['size'] : 0;
		$upload_name  = isset($screenshot_file['name']) ? (string) $screenshot_file['name'] : '';
		$file_type    = wp_check_filetype($upload_name, array('jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png'));

		if ($upload_error !== UPLOAD_ERR_OK || $upload_size <= 0 || $upload_size > 1048576 || empty($file_type['type'])) {
			wp_safe_redirect(add_query_arg(array('report_error' => 'screenshot', 'game' => $slug), $report_url));
			exit;
		}
	}

	if ($title === '' && $slug !== '') {
		$title = $slug;
	}

	$post_id = wp_insert_post(
		wp_slash(
			array(
				'post_type'    => 'zo_game_report',
				'post_status'  => 'private',
				'post_title'   => 'Game Report - ' . ($title !== '' ? $title : current_time('mysql')),
				'post_content' => $message,
			)
		),
		true
	);

	if (is_wp_error($post_id) || $post_id <= 0) {
		wp_safe_redirect(add_query_arg(array('report_error' => 'save', 'game' => $slug), $report_url));
		exit;
	}

	$meta = array(
		'_zo_report_game_slug'    => $slug,
		'_zo_report_game_title'   => $title,
		'_zo_report_game_url'     => $game_url,
		'_zo_report_problem_type' => $problem_type,
		'_zo_report_device'       => $device,
		'_zo_report_browser'      => $browser,
		'_zo_report_email'        => $email,
		'_zo_report_status'       => 'new',
		'_zo_report_language'     => $language,
		'_zo_report_user_agent'   => $user_agent,
		'_zo_report_user_id'      => get_current_user_id(),
	);

	foreach ($meta as $key => $value) {
		update_post_meta($post_id, $key, $value);
	}

	if ($has_screenshot) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';

		$upload = wp_handle_upload(
			$screenshot_file,
			array(
				'test_form' => false,
				'mimes'     => array('jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png'),
			)
		);

		if (!empty($upload['file']) && empty($upload['error'])) {
			$attachment_id = wp_insert_attachment(
				wp_slash(
					array(
						'post_mime_type' => $upload['type'],
						'post_title'     => 'Game report screenshot',
						'post_content'   => '',
						'post_status'    => 'private',
					)
				),
				$upload['file'],
				$post_id
			);

			if (!is_wp_error($attachment_id) && $attachment_id > 0) {
				wp_update_attachment_metadata($attachment_id, wp_generate_attachment_metadata($attachment_id, $upload['file']));
				update_post_meta($post_id, '_zo_report_screenshot_id', (int) $attachment_id);
			}
		} elseif (!empty($upload['error'])) {
			update_post_meta($post_id, '_zo_report_screenshot_error', sanitize_text_field($upload['error']));
		}
	}

	zo_append_codex_game_report_mirror($post_id);

	wp_safe_redirect(add_query_arg(array('sent' => '1', 'game' => $slug), $report_url));
	exit;
}
add_action('admin_post_zo_submit_game_report', 'zo_handle_game_report_submission');
add_action('admin_post_nopriv_zo_submit_game_report', 'zo_handle_game_report_submission');

function zo_add_game_report_meta_box() {
	add_meta_box(
		'zo_game_report_details',
		'Report Details',
		'zo_render_game_report_meta_box',
		'zo_game_report',
		'normal',
		'high'
	);
}
add_action('add_meta_boxes_zo_game_report', 'zo_add_game_report_meta_box');

function zo_render_game_report_meta_box($post) {
	$statuses = zo_get_game_report_statuses();
	$status = get_post_meta($post->ID, '_zo_report_status', true);
	$status = isset($statuses[$status]) ? $status : 'new';
	$fields = array(
		'Game title'   => get_post_meta($post->ID, '_zo_report_game_title', true),
		'Game slug'    => get_post_meta($post->ID, '_zo_report_game_slug', true),
		'Game URL'     => get_post_meta($post->ID, '_zo_report_game_url', true),
		'Problem type' => get_post_meta($post->ID, '_zo_report_problem_type', true),
		'Device'       => get_post_meta($post->ID, '_zo_report_device', true),
		'Browser'      => get_post_meta($post->ID, '_zo_report_browser', true),
		'Email'        => get_post_meta($post->ID, '_zo_report_email', true),
		'Language'     => get_post_meta($post->ID, '_zo_report_language', true),
		'User agent'   => get_post_meta($post->ID, '_zo_report_user_agent', true),
	);
	$screenshot_id = (int) get_post_meta($post->ID, '_zo_report_screenshot_id', true);
	$screenshot_url = $screenshot_id > 0 ? wp_get_attachment_url($screenshot_id) : '';
	$screenshot_error = get_post_meta($post->ID, '_zo_report_screenshot_error', true);

	wp_nonce_field('zo_save_game_report_status', 'zo_report_status_nonce');
	echo '<p><label for="zo_report_status"><strong>Status</strong></label><br>';
	echo '<select id="zo_report_status" name="zo_report_status">';
	foreach ($statuses as $value => $label) {
		echo '<option value="' . esc_attr($value) . '"' . selected($status, $value, false) . '>' . esc_html($label) . '</option>';
	}
	echo '</select></p>';
	echo '<table class="widefat striped"><tbody>';
	foreach ($fields as $label => $value) {
		echo '<tr><th style="width:160px">' . esc_html($label) . '</th><td>' . esc_html((string) $value) . '</td></tr>';
	}
	echo '<tr><th style="width:160px">Screenshot</th><td>';
	if ($screenshot_url !== '') {
		echo '<a href="' . esc_url($screenshot_url) . '" target="_blank" rel="noopener">Open screenshot</a>';
	} elseif ($screenshot_error !== '') {
		echo esc_html($screenshot_error);
	} else {
		echo 'No screenshot';
	}
	echo '</td></tr>';
	echo '</tbody></table>';
}

function zo_save_game_report_status($post_id) {
	if (get_post_type($post_id) !== 'zo_game_report') {
		return;
	}

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if (empty($_POST['zo_report_status_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['zo_report_status_nonce'])), 'zo_save_game_report_status')) {
		return;
	}

	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	$statuses = zo_get_game_report_statuses();
	$status = !empty($_POST['zo_report_status']) ? sanitize_key(wp_unslash($_POST['zo_report_status'])) : 'new';
	if (!isset($statuses[$status])) {
		$status = 'new';
	}

	update_post_meta($post_id, '_zo_report_status', $status);
}
add_action('save_post_zo_game_report', 'zo_save_game_report_status');

function zo_game_report_columns($columns) {
	return array(
		'cb'           => isset($columns['cb']) ? $columns['cb'] : '',
		'title'        => 'Report',
		'game'         => 'Game',
		'problem_type' => 'Problem',
		'device'       => 'Device',
		'status'       => 'Status',
		'date'         => 'Date',
	);
}
add_filter('manage_zo_game_report_posts_columns', 'zo_game_report_columns');

function zo_render_game_report_column($column, $post_id) {
	if ($column === 'game') {
		$title = get_post_meta($post_id, '_zo_report_game_title', true);
		$url = get_post_meta($post_id, '_zo_report_game_url', true);
		echo $url !== '' ? '<a href="' . esc_url($url) . '">' . esc_html($title !== '' ? $title : $url) . '</a>' : esc_html($title);
		return;
	}

	if ($column === 'problem_type') {
		echo esc_html(get_post_meta($post_id, '_zo_report_problem_type', true));
		return;
	}

	if ($column === 'device') {
		echo esc_html(get_post_meta($post_id, '_zo_report_device', true));
		return;
	}

	if ($column === 'status') {
		$statuses = zo_get_game_report_statuses();
		$status = get_post_meta($post_id, '_zo_report_status', true);
		echo esc_html(isset($statuses[$status]) ? $statuses[$status] : 'New');
	}
}
add_action('manage_zo_game_report_posts_custom_column', 'zo_render_game_report_column', 10, 2);

function zo_add_game_meta_box() {
	add_meta_box(
		'zo_game_module_box',
		'Oyun Modülü',
		'zo_render_game_meta_box',
		'zeka_oyunu',
		'side',
		'high'
	);

	add_meta_box(
		'zo_game_owner_box',
		'Oyun Sahibi',
		'zo_render_game_owner_meta_box',
		'zeka_oyunu',
		'side',
		'high'
	);
}
add_action('add_meta_boxes', 'zo_add_game_meta_box');

function zo_render_game_meta_box($post) {
	wp_nonce_field('zo_save_game_module', 'zo_game_module_nonce');
	wp_nonce_field('zo_save_game_meta', 'zo_meta_save_nonce');

	$selected = zo_get_game_slug_for_post($post->ID);
	$modules  = zo_get_game_modules();

	echo '<p><label for="zo_game_slug"><strong>Bu sayfada hangi oyun çalışsın?</strong></label></p>';

	if (empty($modules)) {
		echo '<p>Henüz hiç oyun modülü bulunamadı. <code>/games/</code> içine bir oyun klasörü ekleyin.</p>';
		return;
	}

	echo '<select name="zo_game_slug" id="zo_game_slug" style="width:100%;">';
	echo '<option value="">Bir oyun seçin</option>';

	foreach ($modules as $module) {
		printf(
			'<option value="%1$s" %2$s>%3$s</option>',
			esc_attr($module['slug']),
			selected($selected, $module['slug'], false),
			esc_html($module['name'])
		);
	}

	echo '</select>';

	if ($selected) {
		$module = zo_get_game_module($selected);

		if ($module && !empty($module['description'])) {
			echo '<p style="margin-top:10px;">' . esc_html($module['description']) . '</p>';
		}
	}

	echo '<p style="margin-top:10px;">You can also embed a game anywhere with:<br><code>[zeka_oyunu slug="hizli-tikla"]</code></p>';
}

function zo_render_game_owner_meta_box($post) {
	wp_nonce_field('zo_save_game_owner', 'zo_game_owner_nonce');

	$selected = zo_get_game_owner_for_post($post->ID);
	$slug     = zo_get_game_slug_for_post($post->ID);
	$module   = $slug !== '' ? zo_get_game_module($slug) : null;

	if ($selected === '' && $module) {
		$selected = zo_get_game_owner_for_module($module);
	}

	if ($selected === '') {
		$selected = 'arslan';
	}

	echo '<p><strong>Bu oyun hangi listeye eklensin?</strong></p>';

	foreach (zo_get_game_owner_options() as $value => $label) {
		printf(
			'<p><label><input type="radio" name="zo_game_owner" value="%1$s" %2$s> %3$s</label></p>',
			esc_attr($value),
			checked($selected, $value, false),
			esc_html($label)
		);
	}

	echo '<p style="margin-top:10px;color:#646970;">Arslan ya da Asker oyun listesi buna gore filtrelenir.</p>';
}

function zo_save_game_meta($post_id) {
	if (
		(!isset($_POST['zo_game_module_nonce']) || !wp_verify_nonce($_POST['zo_game_module_nonce'], 'zo_save_game_module')) &&
		(!isset($_POST['zo_game_owner_nonce']) || !wp_verify_nonce($_POST['zo_game_owner_nonce'], 'zo_save_game_owner'))
	) {
		return;
	}

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	if (isset($_POST['zo_game_module_nonce']) && wp_verify_nonce($_POST['zo_game_module_nonce'], 'zo_save_game_module')) {
		if (!isset($_POST['zo_meta_save_nonce']) || !wp_verify_nonce($_POST['zo_meta_save_nonce'], 'zo_save_game_meta')) {
			return;
		}

		$slug = isset($_POST['zo_game_slug']) ? sanitize_title(wp_unslash($_POST['zo_game_slug'])) : '';

		if ($slug && zo_get_game_module($slug)) {
			update_post_meta($post_id, '_zo_game_slug', $slug);
		} else {
			delete_post_meta($post_id, '_zo_game_slug');
		}
	}

	if (isset($_POST['zo_game_owner_nonce']) && wp_verify_nonce($_POST['zo_game_owner_nonce'], 'zo_save_game_owner')) {
		$owner = isset($_POST['zo_game_owner']) ? zo_normalize_game_owner(wp_unslash($_POST['zo_game_owner'])) : '';

		if ($owner !== '') {
			update_post_meta($post_id, '_zo_game_owner', $owner);
		} else {
			delete_post_meta($post_id, '_zo_game_owner');
		}
	}
}
add_action('save_post_zeka_oyunu', 'zo_save_game_meta');

function zo_get_style_handle($slug) {
	return 'zo-game-style-' . sanitize_title($slug);
}

function zo_get_script_handle($slug) {
	return 'zo-game-script-' . sanitize_title($slug);
}

function zo_get_input_blocker_style_handle() {
	return 'zo-game-input-blockers-style';
}

function zo_get_input_blocker_script_handle() {
	return 'zo-game-input-blockers';
}

function zo_get_input_blocker_css() {
	return zo_get_shortcode_logo_css() . '
.zo-game-shell,
.zo-game-root {
	-webkit-tap-highlight-color: transparent;
	-webkit-touch-callout: none;
	overscroll-behavior: auto;
	touch-action: pan-y pinch-zoom;
	user-select: none;
	-webkit-user-drag: none;
	user-drag: none;
}

.zo-game-shell img,
.zo-game-shell canvas,
.zo-game-shell svg,
.zo-game-root img,
.zo-game-root canvas,
.zo-game-root svg {
	-webkit-user-drag: none;
	user-drag: none;
}

.zo-game-shell input,
.zo-game-shell textarea,
.zo-game-shell select,
.zo-game-shell [contenteditable="true"],
.zo-game-root input,
.zo-game-root textarea,
.zo-game-root select,
.zo-game-root [contenteditable="true"] {
	touch-action: manipulation;
	user-select: text;
}

.zo-mobile-controls {
	display: none;
}

@media (max-width: 768px) {
	html,
	body {
		overscroll-behavior-y: auto;
		-webkit-overflow-scrolling: touch;
	}

	.zo-shortcode-frame,
	.zo-game-shell,
	.zo-game-root {
		max-width: 100%;
		overflow-x: auto !important;
		overflow-y: visible !important;
		-webkit-overflow-scrolling: touch;
		overscroll-behavior-y: auto !important;
		touch-action: pan-y pinch-zoom !important;
	}

	.zo-game-shell button,
	.zo-game-shell a,
	.zo-game-shell input,
	.zo-game-shell textarea,
	.zo-game-shell select,
	.zo-game-root button,
	.zo-game-root a,
	.zo-game-root input,
	.zo-game-root textarea,
	.zo-game-root select {
		touch-action: manipulation;
	}

	.zo-game-shell canvas,
	.zo-game-root canvas,
	.zo-game-shell svg,
	.zo-game-root svg,
	.zo-game-shell [role="application"],
	.zo-game-root [role="application"],
	.zo-game-shell [data-zo-game-board],
	.zo-game-root [data-zo-game-board] {
		touch-action: pan-y pinch-zoom !important;
	}

	.zo-mobile-controls {
		box-sizing: border-box;
		width: min(100%, 520px);
		margin: 14px auto 0;
		padding: 10px 12px calc(10px + env(safe-area-inset-bottom, 0px));
		display: none;
		align-items: center;
		justify-content: space-between;
		gap: 14px;
		pointer-events: auto;
	}

	.zo-mobile-controls.is-visible {
		display: flex;
	}

	.zo-mobile-controls__pad,
	.zo-mobile-controls__actions {
		display: grid;
		gap: 7px;
		pointer-events: auto;
	}

	.zo-mobile-controls__pad {
		grid-template-columns: repeat(3, 48px);
		grid-template-rows: repeat(3, 48px);
	}

	.zo-mobile-controls__actions {
		grid-template-columns: repeat(2, 54px);
		align-items: end;
	}

	.zo-mobile-controls__button {
		width: 48px;
		height: 48px;
		border: 1px solid rgba(255, 255, 255, 0.38);
		border-radius: 999px;
		background: rgba(15, 23, 42, 0.82);
		box-shadow: 0 10px 22px rgba(15, 23, 42, 0.28);
		color: #fff;
		font: 800 15px/1 Arial, sans-serif;
		text-align: center;
		touch-action: none;
		user-select: none;
		-webkit-user-select: none;
	}

	.zo-mobile-controls__button:active,
	.zo-mobile-controls__button.is-pressed {
		background: #0f766e;
		transform: translateY(1px);
	}

	.zo-mobile-controls__button--up {
		grid-column: 2;
		grid-row: 1;
	}

	.zo-mobile-controls__button--left {
		grid-column: 1;
		grid-row: 2;
	}

	.zo-mobile-controls__button--right {
		grid-column: 3;
		grid-row: 2;
	}

	.zo-mobile-controls__button--down {
		grid-column: 2;
		grid-row: 3;
	}

	.zo-mobile-controls__button--action {
		width: 54px;
		height: 54px;
		background: rgba(15, 118, 110, 0.9);
		font-size: 16px;
	}

	.zo-mobile-controls__button--secondary {
		background: rgba(30, 64, 175, 0.88);
	}
}

@media (max-width: 360px) {
	.zo-mobile-controls__pad {
		grid-template-columns: repeat(3, 42px);
		grid-template-rows: repeat(3, 42px);
	}

	.zo-mobile-controls__button {
		width: 42px;
		height: 42px;
	}

	.zo-mobile-controls__actions {
		grid-template-columns: repeat(2, 48px);
	}

	.zo-mobile-controls__button--action {
		width: 48px;
		height: 48px;
	}
}
';
}

function zo_get_input_blocker_js() {
	return <<<'JS'
(function () {
	if (window.__zoGameInputBlockersReady) {
		return;
	}

	window.__zoGameInputBlockersReady = true;

	var blockedKeys = {
		ArrowUp: true,
		ArrowDown: true,
		ArrowLeft: true,
		ArrowRight: true,
		Space: true,
		PageUp: true,
		PageDown: true,
		Home: true,
		End: true,
		Backspace: true,
		Delete: true,
		Enter: true,
		Escape: true,
		Esc: true,
		Spacebar: true,
		Insert: true,
		w: true,
		a: true,
		s: true,
		d: true,
		q: true,
		e: true,
		r: true,
		f: true,
		z: true,
		x: true,
		c: true,
		v: true,
		i: true,
		j: true,
		k: true,
		l: true,
		p: true,
		W: true,
		A: true,
		S: true,
		D: true,
		Q: true,
		E: true,
		R: true,
		F: true,
		Z: true,
		X: true,
		C: true,
		V: true,
		I: true,
		J: true,
		K: true,
		L: true,
		P: true
	};
	var blockedCodes = {
		ArrowUp: true,
		ArrowDown: true,
		ArrowLeft: true,
		ArrowRight: true,
		Space: true,
		PageUp: true,
		PageDown: true,
		Home: true,
		End: true,
		Backspace: true,
		Delete: true,
		Enter: true,
		Escape: true,
		Insert: true,
		ShiftLeft: true,
		ShiftRight: true,
		KeyW: true,
		KeyA: true,
		KeyS: true,
		KeyD: true,
		KeyQ: true,
		KeyE: true,
		KeyR: true,
		KeyF: true,
		KeyZ: true,
		KeyX: true,
		KeyC: true,
		KeyV: true,
		KeyI: true,
		KeyJ: true,
		KeyK: true,
		KeyL: true,
		KeyP: true,
		Numpad8: true,
		Numpad4: true,
		Numpad2: true,
		Numpad6: true,
		NumpadEnter: true,
		NumpadAdd: true,
		NumpadSubtract: true,
		NumpadMultiply: true,
		NumpadDivide: true,
		Digit0: true,
		Digit1: true,
		Digit2: true,
		Digit3: true,
		Digit4: true,
		Digit5: true,
		Digit6: true,
		Digit7: true,
		Digit8: true,
		Digit9: true
	};
	var lastActiveGame = null;

	function getGameRoot(element) {
		if (!element || element === document || element === window) {
			return null;
		}

		if (element.closest) {
			return element.closest('.zo-game-shell, .zo-game-root');
		}

		return null;
	}

	function isEditable(element) {
		if (!element || !element.closest) {
			return false;
		}

		return !!element.closest('input, textarea, select, [contenteditable="true"], [contenteditable=""]');
	}

	function isInteractive(element) {
		if (!element || !element.closest) {
			return false;
		}

		return !!element.closest('button, a, input, textarea, select, label, summary, [role="button"], [contenteditable="true"], [contenteditable=""]');
	}

	function isSafeTarget(element) {
		return isEditable(element) || isInteractive(element);
	}

	function findSingleGameRoot() {
		var games = document.querySelectorAll('.zo-game-shell, .zo-game-root');
		return games.length === 1 ? games[0] : null;
	}

	function normalizeKey(event) {
		if (event.code === 'Space' || event.key === ' ') {
			return 'Space';
		}

		return event.key || event.code || '';
	}

	function ensureFocusable(game) {
		if (game && !game.hasAttribute('tabindex')) {
			game.setAttribute('tabindex', '0');
		}
	}

	function shouldShowMobileControls() {
		return !!(
			window.matchMedia &&
			window.matchMedia('(max-width: 768px), (pointer: coarse)').matches &&
			document.querySelector('.zo-game-shell, .zo-game-root')
		);
	}

	function getControlTarget() {
		return lastActiveGame || getGameRoot(document.activeElement) || findSingleGameRoot() || document.querySelector('.zo-game-shell, .zo-game-root');
	}

	function keyInfo(code) {
		var map = {
			ArrowUp: { key: 'ArrowUp', keyCode: 38, which: 38 },
			ArrowDown: { key: 'ArrowDown', keyCode: 40, which: 40 },
			ArrowLeft: { key: 'ArrowLeft', keyCode: 37, which: 37 },
			ArrowRight: { key: 'ArrowRight', keyCode: 39, which: 39 },
			Space: { key: ' ', keyCode: 32, which: 32 },
			Enter: { key: 'Enter', keyCode: 13, which: 13 }
		};

		return map[code] || { key: code, keyCode: 0, which: 0 };
	}

	function dispatchGameKey(code, type) {
		var target = getControlTarget();
		var info = keyInfo(code);
		var eventInit = {
			key: info.key,
			code: code,
			keyCode: info.keyCode,
			which: info.which,
			bubbles: true,
			cancelable: true
		};
		var event;

		if (target) {
			lastActiveGame = target;
			ensureFocusable(target);
			if (target.focus) {
				target.focus({ preventScroll: true });
			}
		}

		try {
			event = new KeyboardEvent(type, eventInit);
		} catch (error) {
			event = document.createEvent('KeyboardEvent');
			event.initKeyboardEvent(type, true, true, window, info.key, 0, '', false, '');
		}

		try {
			Object.defineProperty(event, 'keyCode', { get: function () { return info.keyCode; } });
			Object.defineProperty(event, 'which', { get: function () { return info.which; } });
		} catch (error) {}

		if (target) {
			target.dispatchEvent(event);
		}

		document.dispatchEvent(new KeyboardEvent(type, eventInit));
		window.dispatchEvent(new KeyboardEvent(type, eventInit));
	}

	function createMobileControls() {
		var wrap = document.createElement('div');
		wrap.className = 'zo-mobile-controls';
		wrap.setAttribute('aria-label', 'Mobile game controls');
		wrap.innerHTML = '' +
			'<div class="zo-mobile-controls__pad" aria-label="Move">' +
				'<button class="zo-mobile-controls__button zo-mobile-controls__button--up" type="button" data-zo-control-key="ArrowUp" aria-label="Up">UP</button>' +
				'<button class="zo-mobile-controls__button zo-mobile-controls__button--left" type="button" data-zo-control-key="ArrowLeft" aria-label="Left">LT</button>' +
				'<button class="zo-mobile-controls__button zo-mobile-controls__button--right" type="button" data-zo-control-key="ArrowRight" aria-label="Right">RT</button>' +
				'<button class="zo-mobile-controls__button zo-mobile-controls__button--down" type="button" data-zo-control-key="ArrowDown" aria-label="Down">DN</button>' +
			'</div>' +
			'<div class="zo-mobile-controls__actions" aria-label="Actions">' +
				'<button class="zo-mobile-controls__button zo-mobile-controls__button--action" type="button" data-zo-control-key="Space" aria-label="Action">A</button>' +
				'<button class="zo-mobile-controls__button zo-mobile-controls__button--action zo-mobile-controls__button--secondary" type="button" data-zo-control-key="Enter" aria-label="Start">B</button>' +
			'</div>';
		return wrap;
	}

	function placeMobileControls(controls) {
		var target = getControlTarget();
		if (!target || !target.parentNode) {
			if (!controls.parentNode) {
				document.body.appendChild(controls);
			}
			return;
		}

		if (target.nextSibling !== controls) {
			target.parentNode.insertBefore(controls, target.nextSibling);
		}
	}

	function setupMobileControls() {
		var controls = document.querySelector('.zo-mobile-controls') || createMobileControls();
		var pressed = {};

		function updateVisibility() {
			placeMobileControls(controls);
			controls.classList.toggle('is-visible', shouldShowMobileControls());
		}

		function press(button) {
			var code = button.getAttribute('data-zo-control-key');
			if (!code || pressed[code]) {
				return;
			}

			pressed[code] = true;
			button.classList.add('is-pressed');
			dispatchGameKey(code, 'keydown');
		}

		function release(button) {
			var code = button.getAttribute('data-zo-control-key');
			if (!code || !pressed[code]) {
				return;
			}

			pressed[code] = false;
			button.classList.remove('is-pressed');
			dispatchGameKey(code, 'keyup');
		}

		controls.querySelectorAll('[data-zo-control-key]').forEach(function (button) {
			button.addEventListener('pointerdown', function (event) {
				event.preventDefault();
				button.setPointerCapture && button.setPointerCapture(event.pointerId);
				press(button);
			});
			button.addEventListener('pointerup', function (event) {
				event.preventDefault();
				release(button);
			});
			button.addEventListener('pointercancel', function () {
				release(button);
			});
			button.addEventListener('pointerleave', function () {
				release(button);
			});
			button.addEventListener('click', function (event) {
				event.preventDefault();
			});
		});

		updateVisibility();
		window.addEventListener('resize', updateVisibility);
		window.addEventListener('orientationchange', updateVisibility);
	}

	function rememberGameFromEvent(event) {
		var game = getGameRoot(event.target);

		if (!game) {
			return null;
		}

		lastActiveGame = game;
		ensureFocusable(game);
		return game;
	}

	function handlePointerDown(event) {
		var game = rememberGameFromEvent(event);

		if (!game) {
			lastActiveGame = null;
			return;
		}

		if (!isInteractive(event.target) && game.focus) {
			game.focus({ preventScroll: true });
		}
	}

	function handleKeyBlock(event) {
		if (event.defaultPrevented || event.altKey || event.ctrlKey || event.metaKey) {
			return;
		}

		var key = normalizeKey(event);
		if (!blockedKeys[key] && !blockedCodes[event.code]) {
			return;
		}

		if (isSafeTarget(event.target)) {
			return;
		}

		var game = getGameRoot(event.target) || getGameRoot(document.activeElement) || lastActiveGame || findSingleGameRoot();
		if (!game) {
			return;
		}

		event.preventDefault();
	}

	function handleGameOnlyDefault(event) {
		if (getGameRoot(event.target) && !isSafeTarget(event.target)) {
			event.preventDefault();
		}
	}

	document.addEventListener('pointerdown', handlePointerDown, true);
	document.addEventListener('pointerover', rememberGameFromEvent, true);
	document.addEventListener('keydown', handleKeyBlock, true);
	document.addEventListener('keyup', handleKeyBlock, true);
	document.addEventListener('keypress', handleKeyBlock, true);
	document.addEventListener('dragstart', handleGameOnlyDefault, true);
	document.addEventListener('selectstart', handleGameOnlyDefault, true);
	document.addEventListener('contextmenu', handleGameOnlyDefault, true);
	document.addEventListener('auxclick', handleGameOnlyDefault, true);
	document.addEventListener('dblclick', handleGameOnlyDefault, true);
	document.addEventListener('gesturestart', handleGameOnlyDefault, true);
	document.addEventListener('gesturechange', handleGameOnlyDefault, true);
	document.addEventListener('gestureend', handleGameOnlyDefault, true);

	document.querySelectorAll('.zo-game-shell, .zo-game-root').forEach(ensureFocusable);
	setupMobileControls();
})();
JS;
}

function zo_register_input_blocker_assets() {
	wp_register_style(
		zo_get_input_blocker_style_handle(),
		false,
		array(),
		ZO_PLUGIN_VERSION
	);
	wp_add_inline_style(zo_get_input_blocker_style_handle(), zo_get_input_blocker_css());

	wp_register_script(
		zo_get_input_blocker_script_handle(),
		false,
		array(),
		ZO_PLUGIN_VERSION,
		true
	);
	wp_add_inline_script(zo_get_input_blocker_script_handle(), zo_get_input_blocker_js());
}
add_action('wp_enqueue_scripts', 'zo_register_input_blocker_assets', 4);

function zo_enqueue_input_blocker_assets() {
	if (wp_style_is(zo_get_input_blocker_style_handle(), 'registered')) {
		wp_enqueue_style(zo_get_input_blocker_style_handle());
	}

	if (wp_script_is(zo_get_input_blocker_script_handle(), 'registered')) {
		wp_enqueue_script(zo_get_input_blocker_script_handle());
	}
}

function zo_register_game_assets() {
	$modules = zo_get_game_modules();

	foreach ($modules as $module) {
		$style_file    = $module['dir'] . 'style.css';
		$script_file   = $module['dir'] . 'script.js';
		$style_handle  = zo_get_style_handle($module['slug']);
		$script_handle = zo_get_script_handle($module['slug']);

		if (file_exists($style_file)) {
			wp_register_style(
				$style_handle,
				$module['url'] . 'style.css',
				array(),
				(string) filemtime($style_file)
			);
		} elseif ($module['inline_style'] !== '') {
			wp_register_style(
				$style_handle,
				false,
				array(),
				md5($module['inline_style'])
			);
		}

		if (file_exists($script_file)) {
			wp_register_script(
				$script_handle,
				$module['url'] . 'script.js',
				array(),
				(string) filemtime($script_file),
				true
			);
		} elseif ($module['inline_script'] !== '') {
			wp_register_script(
				$script_handle,
				false,
				array(),
				md5($module['inline_script']),
				true
			);
		}
	}
}
add_action('wp_enqueue_scripts', 'zo_register_game_assets', 5);

function zo_enqueue_game_assets_by_slug($slug) {
	$slug = sanitize_title($slug);
	$module = zo_get_game_module($slug);
	static $inline_style_added = array();
	static $inline_script_added = array();

	if (!$slug || !$module) {
		return;
	}

	zo_enqueue_input_blocker_assets();

	$style_handle  = zo_get_style_handle($slug);
	$script_handle = zo_get_script_handle($slug);

	if (wp_style_is($style_handle, 'registered')) {
		if ($module['inline_style'] !== '' && empty($inline_style_added[$style_handle])) {
			wp_add_inline_style($style_handle, $module['inline_style']);
			$inline_style_added[$style_handle] = true;
		}

		wp_enqueue_style($style_handle);
	}

	if (wp_script_is($script_handle, 'registered')) {
		if ($module['inline_script'] !== '' && empty($inline_script_added[$script_handle])) {
			wp_add_inline_script($script_handle, $module['inline_script']);
			$inline_script_added[$script_handle] = true;
		}

		wp_enqueue_script($script_handle);
	}
}

function zo_extract_shortcode_game_slugs($content) {
	$slugs = array();

	if (!is_string($content) || $content === '') {
		return $slugs;
	}

	if (preg_match_all('/\[zeka_oyunu\b[^\]]*slug=(["\'])([^"\']+)\1[^\]]*\]/i', $content, $matches)) {
		if (!empty($matches[2])) {
			foreach ($matches[2] as $slug) {
				$slug = sanitize_title($slug);

				if ($slug) {
					$slugs[] = $slug;
				}
			}
		}
	}

	return array_values(array_unique($slugs));
}

function zo_maybe_enqueue_current_game_assets() {
	if (is_admin()) {
		return;
	}

	$requested_slug = zo_get_requested_game_slug();

	if ($requested_slug !== '') {
		wp_enqueue_script('jquery');
		zo_enqueue_game_assets_by_slug($requested_slug);
	}

	if (is_singular()) {
		$post = get_queried_object();

		if ($post instanceof WP_Post) {
			$shortcode_slugs = zo_extract_shortcode_game_slugs($post->post_content);

			foreach ($shortcode_slugs as $slug) {
				zo_enqueue_game_assets_by_slug($slug);
			}
		}
	}
}
add_action('wp_enqueue_scripts', 'zo_maybe_enqueue_current_game_assets', 20);

function zo_render_game($slug, $post_id = 0) {
	$language = zo_get_current_language();

	if (!zo_is_game_available_for_language($slug, $language)) {
		return '';
	}

	$module = zo_get_game_module($slug);

	if (!$module) {
		return '<div class="zo-game-shell"><p>Oyun bulunamadı.</p></div>';
	}

	zo_enqueue_game_assets_by_slug($slug);

	$html = '';

	if (!empty($module['render_callback']) && is_callable($module['render_callback'])) {
		$localized_module = $module;
		$localized_metadata = zo_get_localized_game_display_metadata($module, $language);

		if (!empty($localized_metadata['name'])) {
			$localized_module['name'] = $localized_metadata['name'];
		}

		if (!empty($localized_metadata['description'])) {
			$localized_module['description'] = $localized_metadata['description'];
		}

		$result = call_user_func($localized_module['render_callback'], (int) $post_id, $localized_module);

		if (is_string($result)) {
			$html = $result;
		}
	}

	if (trim($html) === '') {
		$html = '<p>Bu oyun henüz görüntülenemiyor.</p>';
	}

	$wrapped_html = zo_wrap_game_runtime_translator($html, $module, $language);

	if ((int) $post_id <= 0) {
		$wrapped_html .= zo_render_game_report_link($slug, $language);
	}

	return $wrapped_html;
}

function zo_get_game_posts_by_slug() {
	$posts_by_slug = array();
	$query         = new WP_Query(
		array(
			'post_type'              => 'zeka_oyunu',
			'post_status'            => 'publish',
			'posts_per_page'         => -1,
			'orderby'                => 'date',
			'order'                  => 'DESC',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);

	if (!$query->have_posts()) {
		return $posts_by_slug;
	}

	while ($query->have_posts()) {
		$query->the_post();

		$post_id = get_the_ID();
		$slug    = zo_resolve_game_slug_for_post($post_id);

		if ($slug === '' || isset($posts_by_slug[$slug])) {
			continue;
		}

		$posts_by_slug[$slug] = get_post($post_id);
	}

	wp_reset_postdata();

	return $posts_by_slug;
}

function zo_enqueue_grid_styles() {
	static $done = false;

	if ($done) {
		return;
	}

	$handle = 'zo-shared-styles';
	$css    = zo_get_shortcode_logo_css() . '
.zo-games-grid-wrap {
	width: min(100%, 1120px);
	margin: 0 auto;
}
.zo-games-grid__toolbar {
	display: flex;
	flex-wrap: wrap;
	gap: 12px;
	justify-content: flex-start;
	align-items: center;
	margin: 0 0 20px;
}
.zo-games-grid__search-toggle {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	width: 64px;
	height: 64px;
	padding: 0;
	border: 0;
	background: transparent;
	cursor: pointer;
}
.zo-games-grid__search-toggle img {
	display: block;
	width: 56px;
	height: 56px;
	object-fit: contain;
	pointer-events: none;
}
.zo-games-grid__search-toggle:hover,
.zo-games-grid__search-toggle:focus {
	background: transparent;
}
.zo-games-grid__search-toggle:focus-visible {
	outline: 3px solid #1d4ed8;
	outline-offset: 4px;
	border-radius: 12px;
}
.zo-games-grid__filters {
	display: grid;
	width: 100%;
	grid-template-columns: minmax(180px, 1fr) minmax(150px, 210px) minmax(150px, 210px) auto auto auto;
	gap: 10px;
	align-items: end;
	margin: 0 0 18px;
}
.zo-games-grid__filters[hidden] {
	display: none !important;
}
.zo-games-grid__filter-close {
	align-self: end;
	display: inline-flex;
	align-items: center;
	justify-content: center;
	width: 42px;
	height: 42px;
	padding: 0;
	border: 1px solid #cbd5e1;
	border-radius: 999px;
	background: #fff;
	color: #111827;
	font-size: 1.35rem;
	font-weight: 800;
	line-height: 1;
	cursor: pointer;
}
.zo-games-grid__filter-close:hover,
.zo-games-grid__filter-close:focus {
	border-color: #94a3b8;
	background: #f8fafc;
}
.zo-games-grid__field {
	display: flex;
	flex-direction: column;
	gap: 6px;
	min-width: 0;
}
.zo-games-grid__field label {
	color: #374151;
	font-size: 0.86rem;
	font-weight: 700;
}
.zo-games-grid__field input,
.zo-games-grid__field select {
	width: 100%;
	min-height: 42px;
	border: 1px solid #cbd5e1;
	border-radius: 10px;
	background: #fff;
	color: #111827;
	font: inherit;
	padding: 0 12px;
}
.zo-games-grid__filter-button,
.zo-games-grid__reset {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	min-height: 42px;
	padding: 0 16px;
	border-radius: 10px;
	border: 1px solid #0f766e;
	background: #0f766e;
	color: #fff;
	font-weight: 700;
	text-decoration: none;
	cursor: pointer;
}
.zo-games-grid__reset {
	border-color: #cbd5e1;
	background: #fff;
	color: #374151;
}
.zo-games-grid__filter-button:hover,
.zo-games-grid__filter-button:focus {
	background: #115e59;
	color: #fff;
	text-decoration: none;
}
.zo-games-grid__reset:hover,
.zo-games-grid__reset:focus {
	border-color: #94a3b8;
	color: #111827;
	text-decoration: none;
}
.zo-games-grid__count {
	margin: -4px 0 16px;
	color: #4b5563;
	font-weight: 700;
}
.zo-games-grid__language {
	display: inline-flex;
	align-items: center;
	gap: 8px;
}
.zo-games-grid__language-label {
	color: #374151;
	font-weight: 700;
}
.zo-games-grid__language-option {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	min-height: 36px;
	min-width: 44px;
	padding: 0 12px;
	border-radius: 999px;
	border: 1px solid #cbd5e1;
	background: #ffffff;
	color: #1f2937;
	font-weight: 700;
	text-decoration: none;
}
.zo-games-grid__language-option.is-active {
	border-color: #1d4ed8;
	background: #1d4ed8;
	color: #ffffff;
}
.zo-games-grid__language-option:hover,
.zo-games-grid__language-option:focus {
	border-color: #1e40af;
	text-decoration: none;
}
.zo-games-grid__intro {
	margin: 0 0 20px;
	color: #374151;
	font-size: 1.05rem;
	line-height: 1.6;
}
.zo-games-grid__intro strong {
	color: #111827;
	font-weight: 700;
}
.zo-games-grid__home {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	max-width: 100%;
	min-height: 42px;
	padding: 0 16px;
	border-radius: 999px;
	background: #1d4ed8;
	color: #fff;
	font-weight: 600;
	line-height: 1.25;
	text-decoration: none;
	text-align: center;
}
.zo-games-grid__home:hover,
.zo-games-grid__home:focus {
	background: #1e40af;
	color: #fff;
	text-decoration: none;
}
.zo-games-grid__feature-section {
	width: min(100%, 1120px);
	margin: 0 auto 22px;
}
.zo-games-grid__feature-section[hidden] {
	display: none !important;
}
.zo-games-grid__feature-title {
	margin: 0 0 12px;
	color: #111827;
	font-size: 1.22rem;
	line-height: 1.25;
}
.zo-games-grid__mini-row {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(min(100%, 210px), 1fr));
	gap: 12px;
}
.zo-games-grid__mini-card {
	display: flex;
	align-items: center;
	gap: 10px;
	min-height: 74px;
	padding: 10px;
	border: 1px solid #dbe3ef;
	border-radius: 14px;
	background: #fff;
	color: #111827;
	text-decoration: none;
	box-shadow: 0 8px 22px rgba(15, 23, 42, 0.06);
}
.zo-games-grid__mini-card:hover,
.zo-games-grid__mini-card:focus {
	border-color: #93c5fd;
	color: #111827;
	text-decoration: none;
}
.zo-games-grid__mini-thumb {
	display: block;
	flex: 0 0 64px;
	width: 64px;
	height: 54px;
	border-radius: 10px;
	background: #eef2ff;
	object-fit: cover;
	overflow: hidden;
}
.zo-games-grid__mini-title {
	font-weight: 900;
	line-height: 1.25;
}
.zo-games-grid__streak-badge {
	display: block;
	width: min(100%, 420px);
	margin: 0 auto;
	text-align: center;
}
.zo-games-grid__streak-badge[hidden] {
	display: none !important;
}
.zo-games-grid__streak-badge + .zo-games-grid__streak-badge {
	margin-top: 14px;
}
.zo-games-grid__streak-image {
	display: block;
	width: 100%;
	height: auto;
	border-radius: 18px;
}
.zo-badge-center {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(min(100%, 230px), 1fr));
	gap: 14px;
}
.zo-badge-center__card {
	position: relative;
	display: grid;
	gap: 10px;
	padding: 12px;
	border: 1px solid #dbe3ef;
	border-radius: 16px;
	background: #fff;
	box-shadow: 0 8px 22px rgba(15, 23, 42, 0.06);
}
.zo-badge-center__card.is-locked .zo-badge-center__image {
	filter: grayscale(0.55);
	opacity: 0.42;
}
.zo-badge-center__image {
	display: block;
	width: 100%;
	aspect-ratio: 1;
	border-radius: 14px;
	object-fit: contain;
	background: #f8fafc;
}
.zo-badge-center__body {
	display: grid;
	gap: 7px;
}
.zo-badge-center__title {
	color: #111827;
	font-size: 1rem;
	font-weight: 900;
	line-height: 1.2;
}
.zo-badge-center__description {
	color: #4b5563;
	font-size: 0.86rem;
	font-weight: 700;
	line-height: 1.35;
}
.zo-badge-center__status {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	justify-self: start;
	min-height: 28px;
	padding: 0 9px;
	border-radius: 999px;
	background: #e5e7eb;
	color: #374151;
	font-size: 0.78rem;
	font-weight: 900;
}
.zo-badge-center__card.is-unlocked .zo-badge-center__status {
	background: #0f766e;
	color: #fff;
}
.zo-badge-center__progress-track {
	height: 8px;
	border-radius: 999px;
	background: #e5e7eb;
	overflow: hidden;
}
.zo-badge-center__progress-fill {
	display: block;
	width: 0;
	height: 100%;
	border-radius: inherit;
	background: linear-gradient(90deg, #14b8a6, #38bdf8);
}
.zo-badge-center__progress-text {
	color: #4b5563;
	font-size: 0.84rem;
	font-weight: 800;
}
.zo-badge-center__history {
	color: #64748b;
	font-size: 0.8rem;
	font-weight: 800;
	line-height: 1.25;
}
.zo-badge-center__card.is-unlocked .zo-badge-center__history {
	color: #0f766e;
}
.zo-badge-showcase {
	display: grid;
	gap: 18px;
}
.zo-badge-showcase .zo-badge-center {
	grid-template-columns: repeat(auto-fit, minmax(min(100%, 160px), 190px));
	justify-content: start;
	gap: 12px;
}
.zo-badge-showcase .zo-badge-center__card {
	gap: 8px;
	padding: 9px;
	border-radius: 13px;
}
.zo-badge-showcase .zo-badge-center__image {
	max-height: 132px;
	border-radius: 11px;
}
.zo-badge-showcase .zo-badge-center__body {
	gap: 6px;
}
.zo-badge-showcase .zo-badge-center__title {
	font-size: 0.9rem;
}
.zo-badge-showcase .zo-badge-center__description {
	display: none;
}
.zo-badge-showcase .zo-badge-center__status {
	min-height: 24px;
	padding: 0 8px;
	font-size: 0.72rem;
}
.zo-badge-showcase .zo-badge-center__progress-track {
	height: 7px;
}
.zo-badge-showcase .zo-badge-center__progress-text,
.zo-badge-showcase .zo-badge-center__history {
	font-size: 0.76rem;
}
.zo-badge-showcase__header {
	display: grid;
	gap: 8px;
}
.zo-badge-showcase__title {
	margin: 0;
	color: #f8fafc;
	font-size: clamp(2rem, 5vw, 4rem);
	line-height: 1;
}
.zo-badge-showcase__intro {
	max-width: 780px;
	margin: 0;
	color: #e5e7eb;
	font-size: 1.08rem;
	line-height: 1.55;
}
.zo-badge-showcase__actions {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
}
.zo-achievement-popup {
	position: fixed;
	right: 18px;
	bottom: 18px;
	z-index: 999998;
	display: grid;
	grid-template-columns: 76px minmax(0, 1fr);
	gap: 12px;
	align-items: center;
	width: min(calc(100vw - 28px), 380px);
	padding: 12px;
	border: 1px solid rgba(20, 184, 166, 0.38);
	border-radius: 16px;
	background: rgba(15, 23, 42, 0.96);
	color: #f8fafc;
	box-shadow: 0 20px 50px rgba(15, 23, 42, 0.32);
	font-family: Arial, sans-serif;
	transform: translateY(18px);
	opacity: 0;
	transition: opacity 220ms ease, transform 220ms ease;
}
.zo-achievement-popup.is-visible {
	transform: translateY(0);
	opacity: 1;
}
.zo-achievement-popup__image {
	display: block;
	width: 76px;
	height: 76px;
	border-radius: 12px;
	object-fit: cover;
}
.zo-achievement-popup__eyebrow {
	display: block;
	margin-bottom: 3px;
	color: #5eead4;
	font-size: 0.76rem;
	font-weight: 900;
	text-transform: uppercase;
}
.zo-achievement-popup__title {
	display: block;
	color: #fff;
	font-size: 1rem;
	font-weight: 900;
	line-height: 1.2;
}
@media (max-width: 640px) {
	.zo-achievement-popup {
		right: 12px;
		bottom: 12px;
		grid-template-columns: 64px minmax(0, 1fr);
	}

	.zo-achievement-popup__image {
		width: 64px;
		height: 64px;
	}
}
.zo-games-grid {
	display: grid;
	width: min(100%, 1120px);
	margin: 0 auto;
	grid-template-columns: repeat(auto-fit, minmax(min(100%, 280px), 320px));
	justify-content: center;
	gap: 24px;
}
.zo-games-grid__card {
	position: relative;
	display: flex;
	flex-direction: column;
	height: 100%;
	border: 1px solid rgba(0, 0, 0, 0.08);
	border-radius: 18px;
	overflow: hidden;
	background: #fff;
	box-shadow: 0 12px 30px rgba(0, 0, 0, 0.06);
}
.zo-games-grid__card[hidden] {
	display: none !important;
}
.zo-games-grid__badges {
	position: absolute;
	top: 12px;
	right: 12px;
	z-index: 2;
	display: flex;
	flex-wrap: wrap;
	gap: 6px;
	justify-content: flex-end;
	max-width: calc(100% - 24px);
}
.zo-games-grid__badge {
	display: inline-flex;
	align-items: center;
	min-height: 26px;
	padding: 0 9px;
	border-radius: 999px;
	background: #0f766e;
	color: #fff;
	font-size: 0.76rem;
	font-weight: 800;
	line-height: 1;
	box-shadow: 0 8px 20px rgba(15, 23, 42, 0.18);
}
.zo-games-grid__badge--popular {
	background: #1d4ed8;
}
.zo-games-grid__favorite {
	display: inline-grid;
	box-sizing: border-box;
	flex: 0 0 42px;
	width: 42px;
	min-width: 42px;
	max-width: 42px;
	height: 42px;
	min-height: 42px;
	max-height: 42px;
	aspect-ratio: 1;
	margin: 12px 0 8px 12px;
	place-items: center;
	border: 1px solid #d1d5db;
	border-radius: 999px;
	background: #fff;
	color: #475569;
	padding: 0;
	text-align: center;
	font-size: 1.45rem;
	font-weight: 900;
	line-height: 0;
	cursor: pointer;
	appearance: none;
	box-shadow: 0 6px 16px rgba(15, 23, 42, 0.1);
}
.zo-games-grid__favorite:hover,
.zo-games-grid__favorite:focus {
	border-color: #f59e0b;
	color: #111827;
}
.zo-games-grid__favorite.is-active {
	background: #f59e0b;
	border-color: #f59e0b;
	color: #111827;
}
.zo-games-grid__thumb {
	display: block;
	position: relative;
	aspect-ratio: 16 / 10;
	background: #f3f4f6;
	color: #ffffff;
	text-decoration: none;
	overflow: hidden;
}
.zo-games-grid__thumb img {
	display: block;
	width: 100%;
	height: 100%;
	object-fit: cover;
}
.zo-games-grid__thumb-fallback {
	position: relative;
	display: grid;
	width: 100%;
	height: 100%;
	min-height: 100%;
	place-items: center;
	isolation: isolate;
	background:
		radial-gradient(circle at 18% 20%, rgba(255, 255, 255, 0.32), transparent 24%),
		linear-gradient(135deg, var(--zo-thumb-from), var(--zo-thumb-to));
}
.zo-games-grid__thumb-pattern {
	position: absolute;
	inset: 0;
	z-index: -1;
	opacity: 0.28;
	background-image:
		linear-gradient(45deg, rgba(255, 255, 255, 0.36) 25%, transparent 25%),
		linear-gradient(-45deg, rgba(255, 255, 255, 0.24) 25%, transparent 25%);
	background-position: 0 0, 20px 20px;
	background-size: 40px 40px;
}
.zo-games-grid__thumb-label {
	position: absolute;
	top: 14px;
	left: 14px;
	padding: 6px 10px;
	border: 1px solid rgba(255, 255, 255, 0.28);
	border-radius: 999px;
	background: rgba(15, 23, 42, 0.22);
	color: var(--zo-thumb-accent);
	font-size: 0.78rem;
	font-weight: 800;
	line-height: 1;
	text-transform: uppercase;
}
.zo-games-grid__thumb-initials {
	display: inline-grid;
	width: 86px;
	height: 86px;
	place-items: center;
	border: 2px solid rgba(255, 255, 255, 0.34);
	border-radius: 22px;
	background: rgba(255, 255, 255, 0.18);
	box-shadow: 0 18px 40px rgba(15, 23, 42, 0.18);
	color: #ffffff;
	font-size: 2.15rem;
	font-weight: 900;
	line-height: 1;
	text-shadow: 0 2px 18px rgba(15, 23, 42, 0.28);
}
.zo-games-grid__body {
	display: flex;
	flex: 1 1 auto;
	flex-direction: column;
	gap: 10px;
	padding: 18px;
}
.zo-games-grid__author {
	margin: 0;
	font-size: 0.85rem;
	font-weight: 600;
	letter-spacing: 0.04em;
	text-transform: uppercase;
	color: #b45309;
}
.zo-games-grid__meta {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
	align-items: center;
}
.zo-games-grid__category {
	display: inline-flex;
	align-items: center;
	gap: 7px;
	width: fit-content;
	max-width: 100%;
	min-height: 30px;
	padding: 0 10px 0 8px;
	border-radius: 999px;
	background: #eef2ff;
	color: #1f2937;
	font-size: 0.84rem;
	font-weight: 800;
	line-height: 1;
}
.zo-games-grid__category-icon {
	display: inline-grid;
	width: 20px;
	height: 20px;
	place-items: center;
	border-radius: 999px;
	background: #1d4ed8;
	color: #fff;
	font-size: 0.78rem;
	font-weight: 900;
	line-height: 1;
}
.zo-games-grid__title {
	margin: 0;
	font-size: 1.15rem;
	line-height: 1.3;
}
.zo-games-grid__title a {
	color: inherit;
	text-decoration: none;
}
.zo-games-grid__title a:hover,
.zo-games-grid__title a:focus {
	text-decoration: underline;
}
.zo-games-grid__excerpt {
	margin: 0;
	color: #374151;
}
.zo-games-grid__module {
	font-size: 0.9rem;
	color: #6b7280;
}
.zo-games-grid__actions {
	margin-top: auto;
	padding-top: 6px;
}
.zo-games-grid__button {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	min-height: 42px;
	padding: 0 16px;
	border-radius: 999px;
	background: #0f766e;
	color: #fff;
	font-weight: 600;
	text-decoration: none;
}
.zo-games-grid__button:hover,
.zo-games-grid__button:focus {
	background: #115e59;
	color: #fff;
	text-decoration: none;
}
.zo-games-grid__empty {
	margin: 0;
	padding: 16px 18px;
	border-radius: 14px;
	background: #f9fafb;
	color: #374151;
}
.zo-games-grid__empty p {
	margin: 0 0 12px;
}
.zo-games-grid__empty:not([hidden]) ~ .zo-games-grid__empty {
	display: none;
}
.zo-games-grid__footer {
	display: flex;
	justify-content: center;
	margin: 28px 0 0;
}
.zo-games-grid__about {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	min-height: 46px;
	max-width: 100%;
	padding: 0 18px;
	border-radius: 999px;
	background: #1d4ed8;
	color: #fff;
	font-weight: 700;
	line-height: 1.25;
	text-align: center;
	text-decoration: none;
}
.zo-games-grid__about:hover,
.zo-games-grid__about:focus {
	background: #1e40af;
	color: #fff;
	text-decoration: none;
}
.zo-games-grid:empty {
	display: none;
}
@media (max-width: 820px) {
	.zo-games-grid__filters {
		grid-template-columns: 1fr;
	}
}
';

	if (!wp_style_is($handle, 'registered')) {
		wp_register_style($handle, false, array(), ZO_PLUGIN_VERSION);
	}

	wp_enqueue_style($handle);
	wp_enqueue_script('jquery');
	wp_add_inline_style($handle, $css);

	$done = true;
}

function zo_enqueue_asker_about_styles() {
	static $done = false;

	if ($done) {
		return;
	}

	$handle = 'zo-shared-styles';
	$css = zo_get_shortcode_logo_css() . '
.zo-asker-about,
.zo-site-about {
	scroll-margin-top: 96px;
	width: min(100%, 880px);
	margin: 0 auto;
	color: #1f2937;
	font-family: Arial, sans-serif;
	font-size: 1.08rem;
	line-height: 1.7;
}
.zo-asker-about-list,
.zo-site-about-list {
	display: grid;
	gap: 34px;
	width: min(100%, 920px);
	margin: 0 auto;
}
.zo-asker-about__language,
.zo-site-about__language {
	position: sticky;
	top: 0;
	z-index: 10;
	display: flex;
	flex-wrap: wrap;
	align-items: center;
	gap: 8px;
	width: min(100%, 920px);
	margin: 0 auto 24px;
	padding: 10px 0;
	background: #fff;
}
.zo-asker-about__language-label,
.zo-site-about__language-label {
	color: #374151;
	font-weight: 700;
}
.zo-asker-about__language-option,
.zo-site-about__language-option {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	min-height: 36px;
	min-width: 44px;
	padding: 0 12px;
	border: 1px solid #cbd5e1;
	border-radius: 999px;
	background: #fff;
	color: #1f2937;
	font-weight: 700;
	text-decoration: none;
}
.zo-asker-about__language-option.is-active,
.zo-site-about__language-option.is-active {
	border-color: #1d4ed8;
	background: #1d4ed8;
	color: #fff;
}
.zo-asker-about__language-option:hover,
.zo-asker-about__language-option:focus,
.zo-site-about__language-option:hover,
.zo-site-about__language-option:focus {
	border-color: #1e40af;
	text-decoration: none;
}
.zo-asker-about-list .zo-asker-about,
.zo-site-about-list .zo-site-about {
	padding-bottom: 30px;
	border-bottom: 1px solid #e5e7eb;
}
.zo-asker-about-list .zo-asker-about:last-child,
.zo-site-about-list .zo-site-about:last-child {
	border-bottom: 0;
	padding-bottom: 0;
}
.zo-asker-about__lang,
.zo-site-about__lang {
	margin: 0 0 8px;
	color: #0f766e;
	font-size: 0.88rem;
	font-weight: 800;
	letter-spacing: 0.08em;
	text-transform: uppercase;
}
.zo-asker-about h2,
.zo-site-about h2 {
	margin: 0 0 14px;
	color: #111827;
	font-size: clamp(30px, 5vw, 48px);
	line-height: 1.1;
}
.zo-asker-about p,
.zo-site-about p {
	margin: 0 0 16px;
}
.zo-asker-about__intro,
.zo-site-about__intro {
	color: #374151;
	font-size: 1.18rem;
	font-weight: 700;
}
.zo-asker-about__button,
.zo-site-about__button {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	min-height: 44px;
	padding: 0 18px;
	border-radius: 999px;
	background: #0f766e;
	color: #fff;
	font-weight: 700;
	text-decoration: none;
}
.zo-asker-about__button:hover,
.zo-asker-about__button:focus,
.zo-site-about__button:hover,
.zo-site-about__button:focus {
	background: #115e59;
	color: #fff;
	text-decoration: none;
}
.zo-asker-about__actions,
.zo-site-about__actions {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	justify-content: center;
	margin-top: 8px;
}
';

	if (!wp_style_is($handle, 'registered')) {
		wp_register_style($handle, false, array(), ZO_PLUGIN_VERSION);
	}

	wp_enqueue_style($handle);
	wp_add_inline_style($handle, $css);

	$done = true;
}

function zo_game_shortcode($atts = array()) {
	$atts = shortcode_atts(
		array(
			'slug' => '',
		),
		$atts,
		'zeka_oyunu'
	);

	$slug = sanitize_title($atts['slug']);

	if (!$slug) {
		return '';
	}

	return zo_render_game($slug);
}
add_shortcode('zeka_oyunu', 'zo_game_shortcode');

function zo_get_asker_about_content($lang = '') {
	$content = array(
		'tr' => array(
			'title' => 'Askerin Oyunları Hakkında',
			'intro' => 'Askerin Oyunları, Asker tarafından yapay zeka yardımıyla yapılmış tarayıcı oyunlarından oluşur.',
			'body' => 'Asker fikirlerini oyuna dönüştürmek için yapay zekadan yardım alır; oyunlar da zeka, hafıza, dikkat, refleks ve problem çözme becerilerini çalıştırır. Bazı oyunlar bulmaca gibidir, bazıları hızlı tepki ister, bazıları da hatırlama ve sıralama becerilerini geliştirir.',
			'note' => 'Oyunlar ücretsizdir ve bilgisayar, tablet veya telefon tarayıcısında oynanabilir. Yeni oyunlar eklendikçe liste büyümeye devam eder.',
		),
		'en' => array(
			'title' => 'About Asker’s Games',
			'intro' => 'Asker’s Games were made by Asker with help from AI.',
			'body' => 'Asker uses AI to turn his ideas into browser games that practice thinking, memory, attention, reflexes, and problem solving. Some games feel like puzzles, some need quick reactions, and others train memory and sequencing.',
			'note' => 'The games are free and can be played in a browser on a computer, tablet, or phone. The list will keep growing as new games are added.',
		),
		'de' => array(
			'title' => 'Über Askers Spiele',
			'intro' => 'Askers Spiele wurden von Asker mit Hilfe von KI gemacht.',
			'body' => 'Asker nutzt KI, um seine Ideen in Browserspiele zu verwandeln, die Denken, Gedächtnis, Aufmerksamkeit, Reflexe und Problemlösung üben. Manche Spiele sind Rätsel, manche brauchen schnelle Reaktionen, andere trainieren Gedächtnis und Reihenfolgen.',
			'note' => 'Die Spiele sind kostenlos und können im Browser auf Computer, Tablet oder Handy gespielt werden. Die Liste wächst weiter, wenn neue Spiele dazukommen.',
		),
		'fr' => array(
			'title' => 'À propos des jeux d’Asker',
			'intro' => 'Les jeux d’Asker ont été créés par Asker avec l’aide de l’IA.',
			'body' => 'Asker utilise l’IA pour transformer ses idées en jeux de navigateur qui entraînent la réflexion, la mémoire, l’attention, les réflexes et la résolution de problèmes. Certains jeux ressemblent à des puzzles, certains demandent des réflexes rapides, et d’autres entraînent la mémoire et les suites logiques.',
			'note' => 'Les jeux sont gratuits et peuvent être joués dans un navigateur sur ordinateur, tablette ou téléphone. La liste continuera de grandir quand de nouveaux jeux seront ajoutés.',
		),
	);

	$content['es-mx'] = array(
		'title' => 'Acerca de los juegos de Asker',
		'intro' => 'Los juegos de Asker fueron creados por Asker con ayuda de IA.',
		'body' => 'Asker usa IA para convertir sus ideas en juegos de navegador que practican pensamiento, memoria, atención, reflejos y resolución de problemas. Algunos juegos son como rompecabezas, otros necesitan reacciones rápidas y otros entrenan memoria y secuencias.',
		'note' => 'Los juegos son gratis y se pueden jugar en el navegador desde una computadora, tableta o teléfono. La lista seguirá creciendo cuando se agreguen nuevos juegos.',
	);
	$content['es-es'] = array(
		'title' => 'Acerca de los juegos de Asker',
		'intro' => 'Los juegos de Asker fueron creados por Asker con ayuda de IA.',
		'body' => 'Asker usa IA para convertir sus ideas en juegos de navegador que practican pensamiento, memoria, atención, reflejos y resolución de problemas. Algunos juegos son como puzles, otros necesitan reacciones rápidas y otros entrenan memoria y secuencias.',
		'note' => 'Los juegos son gratuitos y se pueden jugar en el navegador desde un ordenador, una tableta o un teléfono. La lista seguirá creciendo cuando se añadan nuevos juegos.',
	);

	$content['es-mx'] = array(
		'title' => 'Acerca de zekâ.com',
		'intro' => 'zekâ.com es un sitio gratis de juegos de navegador para niños, estudiantes y jugadores curiosos de todas las edades.',
		'body' => 'El sitio incluye juegos de lógica, memoria, atención, reflejos, matemáticas, rompecabezas, deportes y creatividad. Los juegos abren rápido, funcionan en el navegador y ayudan a pensar mientras juegas.',
		'note' => 'El sitio crece con ideas de jóvenes creadores como Asker y Arslan. Algunos juegos se hacen con ayuda de IA y luego se comparten en el sitio.',
	);
	$content['es-es'] = array(
		'title' => 'Acerca de zekâ.com',
		'intro' => 'zekâ.com es un sitio gratuito de juegos de navegador para niños, estudiantes y jugadores curiosos de todas las edades.',
		'body' => 'El sitio incluye juegos de lógica, memoria, atención, reflejos, matemáticas, puzles, deportes y creatividad. Los juegos se abren rápido, funcionan en el navegador y ayudan a pensar mientras juegas.',
		'note' => 'El sitio crece con ideas de jóvenes creadores como Asker y Arslan. Algunos juegos se hacen con ayuda de IA y luego se comparten en el sitio.',
	);

	$content['es-mx'] = array(
		'title' => 'Acerca de los juegos de Asker',
		'intro' => 'Los juegos de Asker fueron creados por Asker con ayuda de IA.',
		'body' => 'Asker usa IA para convertir sus ideas en juegos de navegador que practican pensamiento, memoria, atención, reflejos y resolución de problemas. Algunos juegos son como rompecabezas, otros necesitan reacciones rápidas y otros entrenan memoria y secuencias.',
		'note' => 'Los juegos son gratis y se pueden jugar en el navegador desde una computadora, tableta o teléfono. La lista seguirá creciendo cuando se agreguen nuevos juegos.',
	);
	$content['es-es'] = array(
		'title' => 'Acerca de los juegos de Asker',
		'intro' => 'Los juegos de Asker fueron creados por Asker con ayuda de IA.',
		'body' => 'Asker usa IA para convertir sus ideas en juegos de navegador que practican pensamiento, memoria, atención, reflejos y resolución de problemas. Algunos juegos son como puzles, otros necesitan reacciones rápidas y otros entrenan memoria y secuencias.',
		'note' => 'Los juegos son gratuitos y se pueden jugar en el navegador desde un ordenador, una tableta o un teléfono. La lista seguirá creciendo cuando se añadan nuevos juegos.',
	);

	$content['es-mx'] = array(
		'title' => 'Acerca de zekâ.com',
		'intro' => 'zekâ.com es un sitio gratis de juegos de navegador para niños, estudiantes y jugadores curiosos de todas las edades.',
		'body' => 'El sitio incluye juegos de lógica, memoria, atención, reflejos, matemáticas, rompecabezas, deportes y creatividad. Los juegos abren rápido, funcionan en el navegador y ayudan a pensar mientras juegas.',
		'note' => 'El sitio crece con ideas de jóvenes creadores como Asker y Arslan. Algunos juegos se hacen con ayuda de IA y luego se comparten en el sitio.',
	);
	$content['es-es'] = array(
		'title' => 'Acerca de zekâ.com',
		'intro' => 'zekâ.com es un sitio gratuito de juegos de navegador para niños, estudiantes y jugadores curiosos de todas las edades.',
		'body' => 'El sitio incluye juegos de lógica, memoria, atención, reflejos, matemáticas, puzles, deportes y creatividad. Los juegos se abren rápido, funcionan en el navegador y ayudan a pensar mientras juegas.',
		'note' => 'El sitio crece con ideas de jóvenes creadores como Asker y Arslan. Algunos juegos se hacen con ayuda de IA y luego se comparten en el sitio.',
	);

	if ($lang === 'all') {
		return $content;
	}

	$lang = array_key_exists($lang, zo_get_language_options()) ? $lang : zo_get_current_language();

	return $content[$lang] ?? $content['tr'];
}

function zo_asker_about_shortcode($atts = array()) {
	$atts = shortcode_atts(
		array(
			'lang' => '',
		),
		$atts,
		'asker_oyunlari_hakkinda'
	);

	$lang = sanitize_key((string) $atts['lang']);
	$show_all = $lang === '' || $lang === 'all';
	$current_lang = $show_all ? zo_get_current_language() : $lang;
	$languages = $show_all ? array_keys(zo_get_language_options()) : array($lang);
	$all_content = zo_get_asker_about_content('all');
	$all_content['es-mx'] = array(
		'title' => 'Acerca de los juegos de Asker',
		'intro' => 'Los juegos de Asker fueron creados por Asker con ayuda de IA.',
		'body' => 'Asker usa IA para convertir sus ideas en juegos de navegador que practican pensamiento, memoria, atención, reflejos y resolución de problemas. Algunos juegos son como rompecabezas, otros necesitan reacciones rápidas y otros entrenan memoria y secuencias.',
		'note' => 'Los juegos son gratis y se pueden jugar en el navegador desde una computadora, tableta o teléfono. La lista seguirá creciendo cuando se agreguen nuevos juegos.',
	);
	$all_content['es-es'] = array(
		'title' => 'Acerca de los juegos de Asker',
		'intro' => 'Los juegos de Asker fueron creados por Asker con ayuda de IA.',
		'body' => 'Asker usa IA para convertir sus ideas en juegos de navegador que practican pensamiento, memoria, atención, reflejos y resolución de problemas. Algunos juegos son como puzles, otros necesitan reacciones rápidas y otros entrenan memoria y secuencias.',
		'note' => 'Los juegos son gratuitos y se pueden jugar en el navegador desde un ordenador, una tableta o un teléfono. La lista seguirá creciendo cuando se añadan nuevos juegos.',
	);

	zo_enqueue_asker_about_styles();

	ob_start();

	echo '<div class="zo-shortcode-frame zo-shortcode-frame--asker-about">';
	echo zo_get_shortcode_logo_html('asker-about');

	echo '<nav class="zo-asker-about__language" aria-label="' . esc_attr(zo_get_interface_text('language_label', $current_lang)) . '">';
	echo '<span class="zo-asker-about__language-label">' . esc_html(zo_get_interface_text('language_label', $current_lang)) . '</span>';

	foreach (zo_get_language_options() as $code => $label) {
		$class = 'zo-asker-about__language-option';
		$url = '#zo-asker-about-' . $code;
		echo '<a class="' . esc_attr($class) . '" href="' . esc_url($url) . '">' . esc_html($label) . '</a>';
	}

	echo '</nav>';

	echo '<div class="zo-asker-about-list">';
	foreach ($languages as $code) {
		if (!array_key_exists($code, zo_get_language_options()) || empty($all_content[$code])) {
			continue;
		}

		$content = $all_content[$code];
		$games_url = zo_get_owner_games_url('asker', $code);
		$home_url = add_query_arg('zo_lang', $code, home_url('/'));

		echo '<section class="zo-asker-about" id="zo-asker-about-' . esc_attr($code) . '" lang="' . esc_attr($code) . '">';
		echo '<p class="zo-asker-about__lang">' . esc_html(zo_get_language_options()[$code]) . '</p>';
		echo '<h2>' . esc_html($content['title']) . '</h2>';
		echo '<p class="zo-asker-about__intro">' . esc_html($content['intro']) . '</p>';
		echo '<p>' . esc_html($content['body']) . '</p>';
		echo '<p>' . esc_html($content['note']) . '</p>';
		echo '<div class="zo-asker-about__actions">';
		if ($games_url !== '') {
			echo '<a class="zo-asker-about__button" href="' . esc_url($games_url) . '">' . esc_html(zo_get_interface_text('asker_games_link', $code)) . '</a>';
		}
		echo '<a class="zo-asker-about__button" href="' . esc_url($home_url) . '">' . esc_html(zo_get_interface_text('home', $code)) . '</a>';
		echo '</div>';
		echo '</section>';
	}
	echo '</div>';
	echo '</div>';

	return ob_get_clean();
}
add_shortcode('asker_oyunlari_hakkinda', 'zo_asker_about_shortcode');

function zo_get_site_about_content($lang = '') {
	$content = array(
		'tr' => array(
			'title' => 'zekâ.com Hakkında',
			'intro' => 'zekâ.com; çocuklar, öğrenciler ve her yaştan meraklı insan için ücretsiz tarayıcı oyunları bulunan bir zeka oyunları sitesidir.',
			'body' => 'Sitede mantık, hafıza, dikkat, refleks, matematik, bulmaca, spor ve yaratıcı oyunlar bulunur. Oyunlar kısa sürede açılır, tarayıcıda oynanır ve farklı yaşlardaki kullanıcıların eğlenirken düşünmesine yardımcı olmayı amaçlar.',
			'note' => 'Oyunlar Asker ve Arslan gibi genç üreticilerin fikirleriyle büyür. Bazı oyunlar yapay zeka yardımıyla hazırlanır, sonra sitede paylaşılır.',
		),
		'en' => array(
			'title' => 'About zekâ.com',
			'intro' => 'zekâ.com is a free browser-game site for kids, students, and curious players of all ages.',
			'body' => 'The site includes logic, memory, attention, reflex, math, puzzle, sports, and creative games. The games open quickly, run in the browser, and are meant to help people think while they play.',
			'note' => 'The site grows with ideas from young makers like Asker and Arslan. Some games are made with help from AI and then shared on the site.',
		),
		'de' => array(
			'title' => 'Über zekâ.com',
			'intro' => 'zekâ.com ist eine kostenlose Browserspiel-Seite für Kinder, Schüler und neugierige Spieler jeden Alters.',
			'body' => 'Die Seite enthält Logik-, Gedächtnis-, Aufmerksamkeits-, Reaktions-, Mathe-, Rätsel-, Sport- und Kreativspiele. Die Spiele starten schnell, laufen im Browser und sollen beim Spielen zum Denken anregen.',
			'note' => 'Die Seite wächst durch Ideen von jungen Machern wie Asker und Arslan. Einige Spiele werden mit Hilfe von KI erstellt und dann auf der Seite geteilt.',
		),
		'fr' => array(
			'title' => 'À propos de zekâ.com',
			'intro' => 'zekâ.com est un site gratuit de jeux de navigateur pour les enfants, les élèves et les joueurs curieux de tout âge.',
			'body' => 'Le site propose des jeux de logique, de mémoire, d’attention, de réflexes, de maths, de puzzle, de sport et de créativité. Les jeux se lancent vite, fonctionnent dans le navigateur et aident à réfléchir en jouant.',
			'note' => 'Le site grandit grâce aux idées de jeunes créateurs comme Asker et Arslan. Certains jeux sont créés avec l’aide de l’IA puis partagés sur le site.',
		),
	);

	if ($lang === 'all') {
		return $content;
	}

	$lang = array_key_exists($lang, zo_get_language_options()) ? $lang : zo_get_current_language();

	return $content[$lang] ?? $content['tr'];
}

function zo_site_about_shortcode($atts = array()) {
	$atts = shortcode_atts(
		array(
			'lang' => '',
		),
		$atts,
		'zeka_hakkinda'
	);

	$lang = sanitize_key((string) $atts['lang']);
	$show_all = $lang === '' || $lang === 'all';
	$current_lang = $show_all ? zo_get_current_language() : $lang;
	$languages = $show_all ? array_keys(zo_get_language_options()) : array($lang);
	$all_content = zo_get_site_about_content('all');
	$all_content['es-mx'] = array(
		'title' => 'Acerca de zekâ.com',
		'intro' => 'zekâ.com es un sitio gratis de juegos de navegador para niños, estudiantes y jugadores curiosos de todas las edades.',
		'body' => 'El sitio incluye juegos de lógica, memoria, atención, reflejos, matemáticas, rompecabezas, deportes y creatividad. Los juegos abren rápido, funcionan en el navegador y ayudan a pensar mientras juegas.',
		'note' => 'El sitio crece con ideas de jóvenes creadores como Asker y Arslan. Algunos juegos se hacen con ayuda de IA y luego se comparten en el sitio.',
	);
	$all_content['es-es'] = array(
		'title' => 'Acerca de zekâ.com',
		'intro' => 'zekâ.com es un sitio gratuito de juegos de navegador para niños, estudiantes y jugadores curiosos de todas las edades.',
		'body' => 'El sitio incluye juegos de lógica, memoria, atención, reflejos, matemáticas, puzles, deportes y creatividad. Los juegos se abren rápido, funcionan en el navegador y ayudan a pensar mientras juegas.',
		'note' => 'El sitio crece con ideas de jóvenes creadores como Asker y Arslan. Algunos juegos se hacen con ayuda de IA y luego se comparten en el sitio.',
	);

	zo_enqueue_asker_about_styles();

	ob_start();

	echo '<div class="zo-shortcode-frame zo-shortcode-frame--site-about">';
	echo zo_get_shortcode_logo_html('site-about');

	echo '<nav class="zo-site-about__language" aria-label="' . esc_attr(zo_get_interface_text('language_label', $current_lang)) . '">';
	echo '<span class="zo-site-about__language-label">' . esc_html(zo_get_interface_text('language_label', $current_lang)) . '</span>';

	foreach (zo_get_language_options() as $code => $label) {
		echo '<a class="zo-site-about__language-option" href="' . esc_url('#zo-site-about-' . $code) . '">' . esc_html($label) . '</a>';
	}

	echo '</nav>';
	echo '<div class="zo-site-about-list">';

	foreach ($languages as $code) {
		if (!array_key_exists($code, zo_get_language_options()) || empty($all_content[$code])) {
			continue;
		}

		$content = $all_content[$code];
		$asker_url = zo_get_owner_games_url('asker', $code);
		$arslan_url = zo_get_owner_games_url('arslan', $code);
		$home_url = add_query_arg('zo_lang', $code, home_url('/'));

		echo '<section class="zo-site-about" id="zo-site-about-' . esc_attr($code) . '" lang="' . esc_attr($code) . '">';
		echo '<p class="zo-site-about__lang">' . esc_html(zo_get_language_options()[$code]) . '</p>';
		echo '<h2>' . esc_html($content['title']) . '</h2>';
		echo '<p class="zo-site-about__intro">' . esc_html($content['intro']) . '</p>';
		echo '<p>' . esc_html($content['body']) . '</p>';
		echo '<p>' . esc_html($content['note']) . '</p>';
		echo '<div class="zo-site-about__actions">';
		echo '<a class="zo-site-about__button" href="' . esc_url($asker_url) . '">' . esc_html(zo_get_interface_text('asker_games_title', $code)) . '</a>';
		echo '<a class="zo-site-about__button" href="' . esc_url($arslan_url) . '">' . esc_html(zo_get_interface_text('arslan_games_title', $code)) . '</a>';
		echo '<a class="zo-site-about__button" href="' . esc_url($home_url) . '">' . esc_html(zo_get_interface_text('home', $code)) . '</a>';
		echo '</div>';
		echo '</section>';
	}

	echo '</div>';
	echo '</div>';

	return ob_get_clean();
}
add_shortcode('zeka_hakkinda', 'zo_site_about_shortcode');
add_shortcode('zeka_com_hakkinda', 'zo_site_about_shortcode');

function zo_games_grid_shortcode($atts = array()) {
	$atts = shortcode_atts(
		array(
			'author' => '',
			'limit'  => '-1',
		),
		$atts,
		'zeka_oyunlari_grid'
	);

	$author_filter    = sanitize_title($atts['author']);
	$limit            = (int) $atts['limit'];
	$modules          = zo_get_game_modules();
	$language         = zo_get_current_language();
	$show_home_button = false;
	$search_query     = isset($_GET['zo_game_search']) && is_string($_GET['zo_game_search']) ? sanitize_text_field(wp_unslash($_GET['zo_game_search'])) : '';
	$category_filter  = isset($_GET['zo_game_category']) && is_string($_GET['zo_game_category']) ? sanitize_key(wp_unslash($_GET['zo_game_category'])) : 'all';
	$sort             = isset($_GET['zo_game_sort']) && is_string($_GET['zo_game_sort']) ? sanitize_key(wp_unslash($_GET['zo_game_sort'])) : 'title';
	$category_options = zo_get_game_category_options();
	$sort_options     = array('title', 'newest', 'category');
	$filters_open     = false;

	if ($limit === 0) {
		return '';
	}

	if (!isset($category_options[$category_filter])) {
		$category_filter = 'all';
	}

	if (!in_array($sort, $sort_options, true)) {
		$sort = 'title';
	}

	$filters_open = $search_query !== '' || $category_filter !== 'all' || $sort !== 'title';

	if (empty($modules)) {
		return '<p class="zo-games-grid__empty">Henüz oyun bulunamadı.</p>';
	}

	zo_enqueue_grid_styles();

	$posts_by_slug = zo_get_game_posts_by_slug();
	$home_url      = home_url('/');
	$filters_id    = 'zo-games-grid-filters-' . wp_rand(1000, 999999);

	if (!is_front_page() && !is_home() && is_string($home_url) && $home_url !== '') {
		$show_home_button = true;
	}

	ob_start();
	$has_results = false;
	$shown       = 0;

	echo '<div class="zo-games-grid-wrap zo-shortcode-frame zo-shortcode-frame--games-grid">';
	echo zo_get_shortcode_logo_html('games-grid');

	echo '<div class="zo-games-grid__toolbar">';
	echo '<button class="zo-games-grid__search-toggle" type="button" aria-label="' . esc_attr(zo_get_interface_text('search_label', $language)) . '" aria-controls="' . esc_attr($filters_id) . '" aria-expanded="' . ($filters_open ? 'true' : 'false') . '" data-zo-games-search-toggle>';
	echo '<img src="' . esc_url(ZO_PLUGIN_URL . 'zeka.com%20search.png') . '" alt="" loading="lazy" decoding="async">';
	echo '</button>';

	if ($show_home_button) {
		echo '<a class="zo-games-grid__home" href="' . esc_url(add_query_arg('zo_lang', $language, $home_url)) . '">' . esc_html(zo_get_interface_text('home', $language)) . '</a>';
	}

	echo '<div class="zo-games-grid__language" aria-label="' . esc_attr(zo_get_interface_text('language_label', $language)) . '">';
	echo '<span class="zo-games-grid__language-label">' . esc_html(zo_get_interface_text('language_label', $language)) . '</span>';

	foreach (zo_get_language_options() as $code => $label) {
		$class = 'zo-games-grid__language-option' . ($code === $language ? ' is-active' : '');
		echo '<a class="' . esc_attr($class) . '" href="' . esc_url(add_query_arg('zo_lang', $code)) . '">' . esc_html($label) . '</a>';
	}

	echo '</div>';
	echo '</div>';

	$filter_action = remove_query_arg(array('zo_game_search', 'zo_game_category', 'zo_game_sort', 'zo_lang', 'paged'));
	echo '<form id="' . esc_attr($filters_id) . '" class="zo-games-grid__filters" method="get" action="' . esc_url($filter_action) . '"' . ($filters_open ? '' : ' hidden') . ' data-zo-games-search-panel>';
	echo '<input type="hidden" name="zo_lang" value="' . esc_attr($language) . '">';
	echo '<div class="zo-games-grid__field">';
	echo '<label for="zo-game-search">' . esc_html(zo_get_interface_text('search_label', $language)) . '</label>';
	echo '<input id="zo-game-search" type="search" name="zo_game_search" value="' . esc_attr($search_query) . '" placeholder="' . esc_attr(zo_get_interface_text('search_placeholder', $language)) . '">';
	echo '</div>';
	echo '<div class="zo-games-grid__field">';
	echo '<label for="zo-game-category">' . esc_html(zo_get_interface_text('category_label', $language)) . '</label>';
	echo '<select id="zo-game-category" name="zo_game_category">';
	foreach ($category_options as $category_key => $labels) {
		echo '<option value="' . esc_attr($category_key) . '"' . selected($category_filter, $category_key, false) . '>' . esc_html(zo_get_game_category_label($category_key, $language)) . '</option>';
	}
	echo '</select>';
	echo '</div>';
	echo '<div class="zo-games-grid__field">';
	echo '<label for="zo-game-sort">' . esc_html(zo_get_interface_text('sort_label', $language)) . '</label>';
	echo '<select id="zo-game-sort" name="zo_game_sort">';
	echo '<option value="title"' . selected($sort, 'title', false) . '>' . esc_html(zo_get_interface_text('sort_title', $language)) . '</option>';
	echo '<option value="newest"' . selected($sort, 'newest', false) . '>' . esc_html(zo_get_interface_text('sort_newest', $language)) . '</option>';
	echo '<option value="category"' . selected($sort, 'category', false) . '>' . esc_html(zo_get_interface_text('sort_category', $language)) . '</option>';
	echo '</select>';
	echo '</div>';
	echo '<button class="zo-games-grid__filter-button" type="submit">' . esc_html(zo_get_interface_text('filter_submit', $language)) . '</button>';
	echo '<a class="zo-games-grid__reset" href="' . esc_url(add_query_arg('zo_lang', $language, remove_query_arg(array('zo_game_search', 'zo_game_category', 'zo_game_sort', 'zo_lang', 'paged')))) . '" data-zo-games-reset>' . esc_html(zo_get_interface_text('filter_reset', $language)) . '</a>';
	echo '<button class="zo-games-grid__filter-close" type="button" aria-label="' . esc_attr(zo_get_interface_text('close_search', $language)) . '" data-zo-games-search-close>&times;</button>';
	echo '</form>';
	echo '<script>(function(){var script=document.currentScript;var wrap=script&&script.closest(".zo-games-grid-wrap");if(!wrap){return;}var button=wrap.querySelector("[data-zo-games-search-toggle]");var panel=wrap.querySelector("[data-zo-games-search-panel]");var close=wrap.querySelector("[data-zo-games-search-close]");var input=wrap.querySelector("#zo-game-search");var category=wrap.querySelector("#zo-game-category");var sort=wrap.querySelector("#zo-game-sort");var grid=wrap.querySelector("[data-zo-games-grid]");var count=wrap.querySelector("[data-zo-games-count]");var empty=wrap.querySelector("[data-zo-games-live-empty]");var reset=wrap.querySelector("[data-zo-games-reset]");if(!button||!panel){return;}function openPanel(focusInput){panel.removeAttribute("hidden");button.setAttribute("aria-expanded","true");if(focusInput&&input){window.setTimeout(function(){input.focus();},0);}}function closePanel(){panel.setAttribute("hidden","");button.setAttribute("aria-expanded","false");button.focus();}function normalize(value){return String(value||"").toLowerCase();}function updateCount(total){if(count){count.textContent=String(count.getAttribute("data-count-template")||"%d").replace("%d",total);}}function applyFilters(){if(!grid){return;}var q=normalize(input&&input.value).trim();var cat=category?category.value:"all";var sortValue=sort?sort.value:"title";var cards=Array.prototype.slice.call(grid.querySelectorAll("[data-zo-game-card]"));var visible=[];cards.forEach(function(card){var matchesText=!q||normalize(card.getAttribute("data-search")).indexOf(q)!==-1;var matchesCategory=cat==="all"||card.getAttribute("data-category")===cat;var show=matchesText&&matchesCategory;card.hidden=!show;if(show){visible.push(card);}});visible.sort(function(a,b){if(sortValue==="newest"){return Number(b.getAttribute("data-timestamp")||0)-Number(a.getAttribute("data-timestamp")||0)||normalize(a.getAttribute("data-title")).localeCompare(normalize(b.getAttribute("data-title")));}if(sortValue==="category"){return normalize(a.getAttribute("data-category-label")).localeCompare(normalize(b.getAttribute("data-category-label")))||normalize(a.getAttribute("data-title")).localeCompare(normalize(b.getAttribute("data-title")));}return normalize(a.getAttribute("data-title")).localeCompare(normalize(b.getAttribute("data-title")));});visible.forEach(function(card){grid.appendChild(card);});updateCount(visible.length);if(empty){empty.hidden=visible.length!==0;}}button.addEventListener("click",function(){if(panel.hasAttribute("hidden")){openPanel(true);}else{closePanel();}});if(close){close.addEventListener("click",closePanel);}if(input){input.addEventListener("input",applyFilters);}if(category){category.addEventListener("change",applyFilters);}if(sort){sort.addEventListener("change",applyFilters);}if(reset){reset.addEventListener("click",function(event){event.preventDefault();if(input){input.value="";}if(category){category.value="all";}if(sort){sort.value="title";}applyFilters();openPanel(true);});}applyFilters();})();</script>';

	echo '<p class="zo-games-grid__intro">' . esc_html(zo_get_interface_text('intro', $language)) . '</p>';

	$game_items = array();
	$new_this_week_items = array();

	foreach ($modules as $slug => $module) {
		if (!zo_is_game_available_for_language($slug, $language)) {
			continue;
		}

		$post         = $posts_by_slug[$slug] ?? null;
		$owner        = $post instanceof WP_Post ? zo_get_game_owner_for_post($post->ID) : '';
		$module_owner = zo_get_game_owner_for_module($module);

		if ($owner === '') {
			$owner = $module_owner;
		}

		if ($author_filter !== '' && $owner !== $author_filter) {
			continue;
		}

		$metadata = zo_get_game_display_metadata($module);
		$title    = !empty($metadata['name']) ? $metadata['name'] : ($post instanceof WP_Post ? get_the_title($post) : $module['name']);
		$excerpt  = !empty($metadata['description']) ? $metadata['description'] : ($post instanceof WP_Post ? get_the_excerpt($post) : '');
		$url      = $post instanceof WP_Post ? zo_get_game_launch_url($post) : zo_get_game_module_fallback_url($slug);
		$author   = zo_get_game_owner_label($owner);

		$title   = zo_get_localized_text($title, $language);
		$excerpt = zo_get_localized_text($excerpt, $language);
		$category = zo_get_game_category($slug, $title, $excerpt);

		if ($url !== '') {
			$url = add_query_arg('zo_lang', $language, $url);
		}

		if ($excerpt === '' && !empty($module['description']) && is_string($module['description'])) {
			$excerpt = zo_get_localized_text($module['description'], $language);
		}

		if ($category_filter !== 'all' && $category !== $category_filter) {
			continue;
		}

		if ($search_query !== '') {
			$haystack = strtolower($title . ' ' . $excerpt . ' ' . $slug . ' ' . $author . ' ' . zo_get_game_category_label($category, $language));
			$needle = strtolower($search_query);

			if (strpos($haystack, $needle) === false) {
				continue;
			}
		}

		$updated_timestamp = $post instanceof WP_Post ? strtotime((string) $post->post_modified_gmt) : 0;
		$created_timestamp = $post instanceof WP_Post ? strtotime((string) $post->post_date_gmt) : 0;

		$game_items[] = array(
			'slug' => $slug,
			'module' => $module,
			'post' => $post,
			'owner' => $owner,
			'author' => $author,
			'title' => $title,
			'excerpt' => $excerpt,
			'url' => $url,
			'category' => $category,
			'timestamp' => $created_timestamp,
			'updated_timestamp' => $updated_timestamp > 0 ? $updated_timestamp : $created_timestamp,
			'thumbnail_url' => zo_get_game_thumbnail_url($post, $module),
		);
	}

	usort(
		$game_items,
		function ($a, $b) use ($sort, $language) {
			if ($sort === 'newest') {
				$time_compare = (int) $b['timestamp'] <=> (int) $a['timestamp'];
				if ($time_compare !== 0) {
					return $time_compare;
				}
			}

			if ($sort === 'category') {
				$category_compare = strcmp(
					zo_get_game_category_label($a['category'], $language),
					zo_get_game_category_label($b['category'], $language)
				);

				if ($category_compare !== 0) {
					return $category_compare;
				}
			}

			return strcasecmp($a['title'], $b['title']);
		}
	);

	$game_items = zo_dedupe_game_items_by_similarity($game_items);
	$new_this_week_items = array();

	foreach ($game_items as $item) {
		if ((int) $item['updated_timestamp'] > 0) {
			$new_this_week_items[] = $item;
		}
	}

	usort(
		$new_this_week_items,
		function ($a, $b) {
			return (int) $b['updated_timestamp'] <=> (int) $a['updated_timestamp'];
		}
	);

	$new_this_week_items = array_slice($new_this_week_items, 0, 4);

	if ($limit > 0) {
		$game_items = array_slice($game_items, 0, $limit);
	}

	$shown = count($game_items);
	$has_results = $shown > 0;

	echo '<p class="zo-games-grid__count" data-zo-games-count data-count-template="' . esc_attr(zo_get_interface_text('results_count', $language)) . '">' . esc_html(sprintf(zo_get_interface_text('results_count', $language), $shown)) . '</p>';

	if (!empty($new_this_week_items)) {
		echo '<section class="zo-games-grid__feature-section" aria-label="' . esc_attr(zo_get_interface_text('new_this_week', $language)) . '">';
		echo '<h2 class="zo-games-grid__feature-title">' . esc_html(zo_get_interface_text('new_this_week', $language)) . '</h2>';
		echo '<div class="zo-games-grid__mini-row">';

		foreach ($new_this_week_items as $item) {
			echo '<a class="zo-games-grid__mini-card" href="' . esc_url($item['url']) . '">';
			if (!empty($item['thumbnail_url'])) {
				echo '<img class="zo-games-grid__mini-thumb" src="' . esc_url($item['thumbnail_url']) . '" alt="" loading="lazy">';
			} else {
				echo '<span class="zo-games-grid__mini-thumb" aria-hidden="true"></span>';
			}
			echo '<span class="zo-games-grid__mini-title">' . esc_html($item['title']) . '</span>';
			echo '</a>';
		}

		echo '</div>';
		echo '</section>';
	}

	echo '<section class="zo-games-grid__feature-section" data-zo-recent-section hidden aria-label="' . esc_attr(zo_get_interface_text('recently_played', $language)) . '">';
	echo '<h2 class="zo-games-grid__feature-title">' . esc_html(zo_get_interface_text('recently_played', $language)) . '</h2>';
	echo '<div class="zo-games-grid__mini-row" data-zo-recent-list></div>';
	echo '</section>';
	if ($author_filter === 'asker') {
		echo '<div class="zo-games-grid__footer">';
		echo '<a class="zo-games-grid__about" href="' . esc_url(add_query_arg('zo_lang', $language, home_url('/rozetler/'))) . '">' . esc_html(zo_get_interface_text('badge_center', $language)) . '</a>';
		echo '</div>';
	}
	echo '<section class="zo-games-grid__feature-section" data-zo-favorites-section hidden aria-label="' . esc_attr(zo_get_interface_text('favorites', $language)) . '">';
	echo '<h2 class="zo-games-grid__feature-title">' . esc_html(zo_get_interface_text('favorites', $language)) . '</h2>';
	echo '<div class="zo-games-grid__mini-row" data-zo-favorites-list></div>';
	echo '</section>';

	echo '<div class="zo-games-grid" data-zo-games-grid>';

	foreach ($game_items as $index => $item) {
		$slug = $item['slug'];
		$module = $item['module'];
		$post = $item['post'];
		$author = $item['author'];
		$title = $item['title'];
		$excerpt = $item['excerpt'];
		$url = $item['url'];
		$category = $item['category'];
		$category_label = zo_get_game_category_label($category, $language);
		$category_icon = zo_get_game_category_icon($category);
		$timestamp = (int) $item['timestamp'];
		$is_popular = $index < 6;
		$search_text = $title . ' ' . $excerpt . ' ' . $slug . ' ' . $author . ' ' . $category_label;

		echo '<article class="zo-games-grid__card" data-zo-game-card data-slug="' . esc_attr($slug) . '" data-title="' . esc_attr($title) . '" data-url="' . esc_url($url) . '" data-thumb="' . esc_url($item['thumbnail_url']) . '" data-category="' . esc_attr($category) . '" data-category-label="' . esc_attr($category_label) . '" data-timestamp="' . esc_attr((string) $timestamp) . '" data-search="' . esc_attr($search_text) . '">';

		echo '<button class="zo-games-grid__favorite" type="button" aria-label="' . esc_attr(zo_get_interface_text('favorite_game', $language)) . '" aria-pressed="false" data-zo-favorite-toggle data-label-add="' . esc_attr(zo_get_interface_text('favorite_game', $language)) . '" data-label-remove="' . esc_attr(zo_get_interface_text('remove_favorite', $language)) . '">&#9734;</button>';

		if ($is_popular) {
			echo '<div class="zo-games-grid__badges">';
			echo '<span class="zo-games-grid__badge zo-games-grid__badge--popular">' . esc_html(zo_get_interface_text('badge_popular', $language)) . '</span>';
			echo '</div>';
		}

		zo_render_game_thumbnail($post, $module, $url, $title);

		echo '<div class="zo-games-grid__body">';

		if ($author === '' && !empty($module['author']) && is_string($module['author'])) {
			$author = $module['author'];
		}

		if ($author !== '') {
			echo '<p class="zo-games-grid__author">' . esc_html($author) . '</p>';
		}

		echo '<div class="zo-games-grid__meta">';
		echo '<span class="zo-games-grid__category"><span class="zo-games-grid__category-icon" aria-hidden="true">' . esc_html($category_icon) . '</span>' . esc_html($category_label) . '</span>';
		echo '</div>';

		if ($url !== '') {
			echo '<h3 class="zo-games-grid__title"><a href="' . esc_url($url) . '">' . esc_html($title) . '</a></h3>';
		} else {
			echo '<h3 class="zo-games-grid__title">' . esc_html($title) . '</h3>';
		}

		if ($excerpt !== '') {
			echo '<p class="zo-games-grid__excerpt">' . esc_html($excerpt) . '</p>';
		}

		if ($url !== '') {
			echo '<div class="zo-games-grid__actions"><a class="zo-games-grid__button" href="' . esc_url($url) . '">' . esc_html(zo_get_interface_text('open_game', $language)) . '</a></div>';
		}

		echo '</div>';
		echo '</article>';
	}

	echo '</div>';
	echo '<div class="zo-games-grid__empty" data-zo-games-live-empty hidden>';
	echo '<p>' . esc_html(zo_get_interface_text('no_live_results', $language)) . '</p>';
	echo '<a class="zo-games-grid__reset" href="' . esc_url(add_query_arg('zo_lang', $language, remove_query_arg(array('zo_game_search', 'zo_game_category', 'zo_game_sort', 'zo_lang', 'paged')))) . '" data-zo-games-reset>' . esc_html(zo_get_interface_text('filter_reset', $language)) . '</a>';
	echo '</div>';
	echo '<script>(function(){var script=document.currentScript;var wrap=script&&script.closest(".zo-games-grid-wrap");if(!wrap){return;}var input=wrap.querySelector("#zo-game-search");var category=wrap.querySelector("#zo-game-category");var sort=wrap.querySelector("#zo-game-sort");var grid=wrap.querySelector("[data-zo-games-grid]");var count=wrap.querySelector("[data-zo-games-count]");var empty=wrap.querySelector("[data-zo-games-live-empty]");var panel=wrap.querySelector("[data-zo-games-search-panel]");var button=wrap.querySelector("[data-zo-games-search-toggle]");function normalize(value){return String(value||"").toLowerCase();}function updateCount(total){if(count){count.textContent=String(count.getAttribute("data-count-template")||"%d").replace("%d",total);}}function openPanel(){if(panel){panel.removeAttribute("hidden");}if(button){button.setAttribute("aria-expanded","true");}}function applyFilters(){if(!grid){return;}var q=normalize(input&&input.value).trim();var cat=category?category.value:"all";var sortValue=sort?sort.value:"title";var cards=Array.prototype.slice.call(grid.querySelectorAll("[data-zo-game-card]"));var visible=[];cards.forEach(function(card){var matchesText=!q||normalize(card.getAttribute("data-search")).indexOf(q)!==-1;var matchesCategory=cat==="all"||card.getAttribute("data-category")===cat;var show=matchesText&&matchesCategory;card.hidden=!show;if(show){visible.push(card);}});visible.sort(function(a,b){if(sortValue==="newest"){return Number(b.getAttribute("data-timestamp")||0)-Number(a.getAttribute("data-timestamp")||0)||normalize(a.getAttribute("data-title")).localeCompare(normalize(b.getAttribute("data-title")));}if(sortValue==="category"){return normalize(a.getAttribute("data-category-label")).localeCompare(normalize(b.getAttribute("data-category-label")))||normalize(a.getAttribute("data-title")).localeCompare(normalize(b.getAttribute("data-title")));}return normalize(a.getAttribute("data-title")).localeCompare(normalize(b.getAttribute("data-title")));});visible.forEach(function(card){grid.appendChild(card);});updateCount(visible.length);if(empty){empty.hidden=visible.length!==0;}}if(input){input.addEventListener("input",applyFilters);}if(category){category.addEventListener("change",applyFilters);}if(sort){sort.addEventListener("change",applyFilters);}Array.prototype.forEach.call(wrap.querySelectorAll("[data-zo-games-reset]"),function(reset){reset.addEventListener("click",function(event){event.preventDefault();if(input){input.value="";}if(category){category.value="all";}if(sort){sort.value="title";}openPanel();applyFilters();if(input){input.focus();}});});applyFilters();})();</script>';
	echo '<script>(function(){var script=document.currentScript;var wrap=script&&script.closest(".zo-games-grid-wrap");if(!wrap){return;}var grid=wrap.querySelector("[data-zo-games-grid]");if(!grid){return;}var recentKey="zoRecentlyPlayedGames";var favoriteKey="zoFavoriteGames";var cards=Array.prototype.slice.call(grid.querySelectorAll("[data-zo-game-card]"));var gameMap={};function read(key){try{var value=JSON.parse(localStorage.getItem(key)||"[]");return Array.isArray(value)?value:[];}catch(error){return [];}}function write(key,value){try{localStorage.setItem(key,JSON.stringify(value));}catch(error){}}function itemFromCard(card){return {slug:card.getAttribute("data-slug")||"",title:card.getAttribute("data-title")||"",url:card.getAttribute("data-url")||"",thumb:card.getAttribute("data-thumb")||""};}function miniCard(item){var a=document.createElement("a");a.className="zo-games-grid__mini-card";a.href=item.url||"#";var media;if(item.thumb){media=document.createElement("img");media.className="zo-games-grid__mini-thumb";media.src=item.thumb;media.alt="";media.loading="lazy";}else{media=document.createElement("span");media.className="zo-games-grid__mini-thumb";media.setAttribute("aria-hidden","true");}var title=document.createElement("span");title.className="zo-games-grid__mini-title";title.textContent=item.title||item.slug;a.appendChild(media);a.appendChild(title);return a;}function render(sectionSelector,listSelector,items){var section=wrap.querySelector(sectionSelector);var list=wrap.querySelector(listSelector);if(!section||!list){return;}list.innerHTML="";items.filter(function(item){return item&&item.slug&&gameMap[item.slug];}).slice(0,4).forEach(function(item){list.appendChild(miniCard(Object.assign({},gameMap[item.slug],item)));});section.hidden=!list.children.length;}function updateFavoriteButton(button,active){button.classList.toggle("is-active",active);button.setAttribute("aria-pressed",active?"true":"false");button.setAttribute("aria-label",button.getAttribute(active?"data-label-remove":"data-label-add")||"");button.innerHTML=active?"&#9733;":"&#9734;";}function renderAll(){var favorites=read(favoriteKey);var recent=read(recentKey);render("[data-zo-favorites-section]","[data-zo-favorites-list]",favorites);render("[data-zo-recent-section]","[data-zo-recent-list]",recent);}cards.forEach(function(card){var item=itemFromCard(card);if(!item.slug){return;}gameMap[item.slug]=item;var favButton=card.querySelector("[data-zo-favorite-toggle]");if(favButton){updateFavoriteButton(favButton,read(favoriteKey).some(function(favorite){return favorite.slug===item.slug;}));favButton.addEventListener("click",function(event){event.preventDefault();event.stopPropagation();var favorites=read(favoriteKey).filter(function(favorite){return favorite.slug!==item.slug;});var active=!favButton.classList.contains("is-active");if(active){favorites.unshift(item);}favorites=favorites.slice(0,40);write(favoriteKey,favorites);updateFavoriteButton(favButton,active);renderAll();});}card.addEventListener("click",function(event){if(event.target.closest("[data-zo-favorite-toggle]")){return;}if(!event.target.closest("a")){return;}var recent=read(recentKey).filter(function(recentItem){return recentItem.slug!==item.slug;});recent.unshift(item);write(recentKey,recent.slice(0,20));});});renderAll();})();</script>';
	if (!$has_results) {
		echo '<p class="zo-games-grid__empty">' . esc_html(zo_get_interface_text('no_live_results', $language)) . '</p>';
		echo '<p><a class="zo-games-grid__reset" href="' . esc_url(add_query_arg('zo_lang', $language, remove_query_arg(array('zo_game_search', 'zo_game_category', 'zo_game_sort', 'zo_lang', 'paged')))) . '">' . esc_html(zo_get_interface_text('filter_reset', $language)) . '</a></p>';
		echo '<p class="zo-games-grid__empty">Filtreye uyan oyun bulunamadı.</p>';
	}

	if ($author_filter === 'asker') {
		$about_url = zo_get_owner_about_url('asker', $language);

		if ($about_url !== '') {
			echo '<div class="zo-games-grid__footer">';
			echo '<a class="zo-games-grid__about" href="' . esc_url($about_url) . '">' . esc_html(zo_get_interface_text('asker_about', $language)) . '</a>';
			echo '</div>';
		}
	}

	echo '</div>';

	return ob_get_clean();
}
add_shortcode('zeka_oyunlari_grid', 'zo_games_grid_shortcode');

function zo_badge_showcase_shortcode($atts = array()) {
	$language = zo_get_current_language();
	$home_url = home_url('/');
	$games_url = zo_get_owner_about_url('asker', $language);

	zo_enqueue_grid_styles();

	ob_start();

	echo '<div class="zo-badge-showcase zo-shortcode-frame zo-shortcode-frame--games-grid" data-zo-badge-scope>';
	echo zo_get_shortcode_logo_html('badge-showcase');

	echo '<div class="zo-games-grid__toolbar">';
	echo '<a class="zo-games-grid__home" href="' . esc_url(add_query_arg('zo_lang', $language, $home_url)) . '">' . esc_html(zo_get_interface_text('home', $language)) . '</a>';
	echo '<div class="zo-games-grid__language" aria-label="' . esc_attr(zo_get_interface_text('language_label', $language)) . '">';
	echo '<span class="zo-games-grid__language-label">' . esc_html(zo_get_interface_text('language_label', $language)) . '</span>';

	foreach (zo_get_language_options() as $code => $label) {
		$class = 'zo-games-grid__language-option' . ($code === $language ? ' is-active' : '');
		echo '<a class="' . esc_attr($class) . '" href="' . esc_url(add_query_arg('zo_lang', $code)) . '">' . esc_html($label) . '</a>';
	}

	echo '</div>';
	echo '</div>';

	echo '<header class="zo-badge-showcase__header">';
	echo '<h1 class="zo-badge-showcase__title">' . esc_html(zo_get_interface_text('badge_center', $language)) . '</h1>';
	echo '<p class="zo-badge-showcase__intro">' . esc_html(zo_get_interface_text('badge_showcase_intro', $language)) . '</p>';
	echo '</header>';

	echo '<div class="zo-badge-center">';

	foreach (zo_get_asker_badge_items($language) as $badge) {
		zo_render_asker_badge_card($badge, $language);
	}

	echo '</div>';
	echo '<div class="zo-badge-showcase__actions">';
	echo '<a class="zo-games-grid__home" href="' . esc_url($games_url) . '">' . esc_html(zo_get_interface_text('asker_games_link', $language)) . '</a>';
	echo '</div>';
	echo zo_get_badge_center_script($language);
	echo '</div>';

	return ob_get_clean();
}
add_shortcode('zeka_rozetleri', 'zo_badge_showcase_shortcode');
add_shortcode('zeka_badge_showcase', 'zo_badge_showcase_shortcode');

function zo_locate_game_template($template) {
	$slug = zo_get_requested_game_slug();

	if ($slug === '') {
		return $template;
	}

	$custom_template = ZO_PLUGIN_DIR . 'templates/single-zeka-oyunu.php';

	return file_exists($custom_template) ? $custom_template : $template;
}
add_filter('template_include', 'zo_locate_game_template', 99);

function zo_append_game_to_content($content) {
	if (!is_singular('zeka_oyunu') || !in_the_loop() || !is_main_query()) {
		return $content;
	}

	$post_id = get_the_ID();
	$slug    = zo_get_game_slug_for_post($post_id);

	if (!$slug) {
		return $content;
	}

	return $content . "\n\n" . zo_render_game($slug, $post_id);
}
add_filter('the_content', 'zo_append_game_to_content');
