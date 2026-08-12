<?php
/**
 * Plugin Name: ZekÃ¢ OyunlarÄ±
 * Plugin URI: https://github.com/stronganchor/zeka-oyunlari
 * Description: Simple modular game framework for zekÃ¢.com so kids can publish WordPress-based games and share them with friends.
<<<<<<< HEAD
 * Version: 1.5.83.asker.arslan
=======
 * Version: 1.5.82.asker.arslan
>>>>>>> c9b2ffd55d47ebaff3f72acc62b462cd6b9c957c
 * Update URI: https://github.com/stronganchor/zeka-oyunlari
 * Author: Anadolu TasarÄ±m
 * Author URI: https://github.com/stronganchor/zeka-oyunlari
 * Text Domain: zeka-oyunlari
 * Requires at least: 6.0
 * Requires PHP: 7.4
 */

if (!defined('ABSPATH')) {
	exit;
}

<<<<<<< HEAD
define('ZO_PLUGIN_VERSION', '1.5.83.asker.arslan');
=======
define('ZO_PLUGIN_VERSION', '1.5.82.asker.arslan');
>>>>>>> c9b2ffd55d47ebaff3f72acc62b462cd6b9c957c
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

	add_filter(
		$update_checker->getUniqueName('vcs_update_detection_strategies'),
		'zo_use_branch_update_detection_strategy',
		10,
		2
	);

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

function zo_use_branch_update_detection_strategy($strategies, $slug) {
	if (!is_array($strategies) || empty($strategies['branch'])) {
		return $strategies;
	}

	return array('branch' => $strategies['branch']);
}

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
		'ZekÃ¢ content look up',
		'ZekÃ¢ content look up',
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
			'message' => $has_settings ? count($option_names) . ' Site Kit opt…170766 tokens truncated…(normalize(b.getAttribute("data-title")));}if(sortValue==="category"){return normalize(a.getAttribute("data-category-label")).localeCompare(normalize(b.getAttribute("data-category-label")))||normalize(a.getAttribute("data-title")).localeCompare(normalize(b.getAttribute("data-title")));}return normalize(a.getAttribute("data-title")).localeCompare(normalize(b.getAttribute("data-title")));});visible.forEach(function(card){grid.appendChild(card);});updateCount(visible.length);if(empty){empty.hidden=visible.length!==0;}}button.addEventListener("click",function(){if(panel.hasAttribute("hidden")){openPanel(true);}else{closePanel();}});if(close){close.addEventListener("click",closePanel);}if(input){input.addEventListener("input",applyFilters);}if(category){category.addEventListener("change",applyFilters);}if(sort){sort.addEventListener("change",applyFilters);}if(reset){reset.addEventListener("click",function(event){event.preventDefault();if(input){input.value="";}if(category){category.value="all";}if(sort){sort.value="title";}applyFilters();openPanel(true);});}applyFilters();})();</script>';

	echo '<p class="zo-games-grid__intro">' . esc_html(zo_get_interface_text('intro', $language)) . '</p>';

	$game_items = array();

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

		if (!empty($author_filters) && !in_array($owner, $author_filters, true)) {
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

	if ($limit > 0) {
		$game_items = array_slice($game_items, 0, $limit);
	}

	$shown = count($game_items);
	$has_results = $shown > 0;

	echo '<p class="zo-games-grid__count" data-zo-games-count data-count-template="' . esc_attr(zo_get_interface_text('results_count', $language)) . '">' . esc_html(sprintf(zo_get_interface_text('results_count', $language), $shown)) . '</p>';

	echo '<section class="zo-games-grid__feature-section" data-zo-recent-section hidden aria-label="' . esc_attr(zo_get_interface_text('recently_played', $language)) . '">';
	echo '<h2 class="zo-games-grid__feature-title">' . esc_html(zo_get_interface_text('recently_played', $language)) . '</h2>';
	echo '<div class="zo-games-grid__mini-row" data-zo-recent-list></div>';
	echo '</section>';
	if ($author_filter === 'asker') {
		echo '<div class="zo-games-grid__footer zo-games-grid__footer--badge-link">';
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
		$owner = isset($item['owner']) ? zo_normalize_game_owner($item['owner']) : '';
		$author = $item['author'];
		$title = $item['title'];
		$excerpt = $item['excerpt'];
		$url = $item['url'];
		$category = $item['category'];
		$category_label = zo_get_game_category_label($category, $language);
		$category_icon = zo_get_game_category_icon($category);
		$timestamp = (int) $item['timestamp'];
		$popular_badge_limit = $author_filter === '' ? 3 : 2;
		$is_popular = !$filters_open && $index < $popular_badge_limit;
		$search_text = $title . ' ' . $excerpt . ' ' . $slug . ' ' . $author . ' ' . $category_label;

		echo '<article class="zo-games-grid__card" data-zo-game-card data-slug="' . esc_attr($slug) . '" data-title="' . esc_attr($title) . '" data-url="' . esc_url($url) . '" data-thumb="' . esc_url($item['thumbnail_url']) . '" data-category="' . esc_attr($category) . '" data-category-label="' . esc_attr($category_label) . '" data-owner="' . esc_attr($owner) . '" data-timestamp="' . esc_attr((string) $timestamp) . '" data-search="' . esc_attr($search_text) . '">';

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
			$author_class = 'zo-games-grid__author';
			if ($owner !== '') {
				$author_class .= ' zo-games-grid__author--' . $owner;
			}
			echo '<p class="' . esc_attr($author_class) . '">' . esc_html($author) . '</p>';
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
		echo '<p class="zo-games-grid__empty">Filtreye uyan oyun bulunamadÄ±.</p>';
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
	$games_url = zo_get_owner_games_url('asker', $language);

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
	echo '<a class="zo-badge-showcase__back" href="' . esc_url($games_url) . '">' . esc_html(zo_get_interface_text('asker_games_link', $language)) . '</a>';
	echo '</div>';
	echo zo_get_badge_center_script($language);
	echo '</div>';

	return ob_get_clean();
}
add_shortcode('zeka_rozetleri', 'zo_badge_showcase_shortcode');
add_shortcode('zeka_badge_showcase', 'zo_badge_showcase_shortcode');

/**
 * Print Elementor's frontend configuration when add-ons enqueue its runtime on
 * the virtual game archive. Elementor normally prints this configuration only
 * after rendering Elementor-authored content, which the archive does not have.
 */
function zo_ensure_elementor_archive_config() {
	if (!is_post_type_archive('zeka_oyunu') || !class_exists('\\Elementor\\Plugin')) {
		return;
	}

	$elementor = \Elementor\Plugin::$instance;

	if (isset($elementor->frontend) && method_exists($elementor->frontend, 'enqueue_scripts')) {
		$elementor->frontend->enqueue_scripts();
	}
}
add_action('wp_enqueue_scripts', 'zo_ensure_elementor_archive_config', 999);

function zo_locate_game_template($template) {
	if (is_post_type_archive('zeka_oyunu')) {
		$archive_template = ZO_PLUGIN_DIR . 'templates/archive-zeka-oyunu.php';

		return file_exists($archive_template) ? $archive_template : $template;
	}

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

