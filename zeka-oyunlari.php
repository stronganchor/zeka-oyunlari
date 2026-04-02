<?php
/**
 * Plugin Name: Zekâ Oyunları
 * Plugin URI: https://github.com/stronganchor/zeka-oyunlari
 * Description: Simple modular game framework for zekâ.com so kids can publish WordPress-based games and share them with friends.
 * Version: 1.2.4.1
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

define('ZO_PLUGIN_VERSION', '1.2.0.2');
define('ZO_PLUGIN_FILE', __FILE__);
define('ZO_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('ZO_PLUGIN_URL', plugin_dir_url(__FILE__));

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

function zo_load_game_module_file($file) {
	static $loaded_modules = array();

	$file = (string) $file;

	if ($file === '') {
		return null;
	}

	if (array_key_exists($file, $loaded_modules)) {
		return $loaded_modules[$file];
	}

	try {
		$module = require $file;
	} catch (Throwable $throwable) {
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

	if (!is_array($module)) {
		$loaded_modules[$file] = null;

		return null;
	}

	$loaded_modules[$file] = $module;

	return $loaded_modules[$file];
}

function zo_load_game_modules() {
	static $modules = null;

	if ($modules !== null) {
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

		$modules[$slug] = $module;
	}

	ksort($modules);

	return $modules;
}
add_action('plugins_loaded', 'zo_load_game_modules', 1);

function zo_get_game_modules() {
	return zo_load_game_modules();
}

function zo_get_game_module($slug) {
	$slug    = sanitize_title($slug);
	$modules = zo_get_game_modules();

	return isset($modules[$slug]) ? $modules[$slug] : null;
}

function zo_get_game_slug_for_post($post_id) {
	return sanitize_title((string) get_post_meta($post_id, '_zo_game_slug', true));
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

function zo_get_current_request_url() {
	if (empty($_SERVER['REQUEST_URI']) || !is_string($_SERVER['REQUEST_URI'])) {
		return '';
	}

	$url = home_url(wp_unslash($_SERVER['REQUEST_URI']));

	return is_string($url) ? esc_url_raw($url) : '';
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

	return $url;
}

function zo_get_game_back_url($post_id = 0) {
	$current_url = $post_id ? get_permalink($post_id) : '';

	if (!empty($_GET['zo_back']) && is_string($_GET['zo_back'])) {
		$candidate = wp_unslash($_GET['zo_back']);
		$candidate = wp_validate_redirect($candidate, '');

		if ($candidate !== '' && $candidate !== $current_url) {
			return $candidate;
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
		$excerpt       = zo_get_default_game_post_excerpt($module);
		$existing_post = $posts_by_slug[$slug] ?? null;

		if ($existing_post instanceof WP_Post) {
			if ((string) get_post_meta($existing_post->ID, '_zo_game_autogenerated', true) === '1') {
				$update = array('ID' => $existing_post->ID);

				if ($existing_post->post_title !== $module['name']) {
					$update['post_title'] = $module['name'];
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

			continue;
		}

		$post_id = wp_insert_post(
			wp_slash(
				array(
					'post_type'    => 'zeka_oyunu',
					'post_status'  => 'publish',
					'post_title'   => $module['name'],
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

function zo_add_game_meta_box() {
	add_meta_box(
		'zo_game_module_box',
		'Oyun Modülü',
		'zo_render_game_meta_box',
		'zeka_oyunu',
		'side',
		'high'
	);
}
add_action('add_meta_boxes', 'zo_add_game_meta_box');

function zo_render_game_meta_box($post) {
	wp_nonce_field('zo_save_game_module', 'zo_game_module_nonce');

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

function zo_save_game_meta($post_id) {
	if (!isset($_POST['zo_game_module_nonce']) || !wp_verify_nonce($_POST['zo_game_module_nonce'], 'zo_save_game_module')) {
		return;
	}

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	$slug = isset($_POST['zo_game_slug']) ? sanitize_title(wp_unslash($_POST['zo_game_slug'])) : '';

	if ($slug && zo_get_game_module($slug)) {
		update_post_meta($post_id, '_zo_game_slug', $slug);
	} else {
		delete_post_meta($post_id, '_zo_game_slug');
	}
}
add_action('save_post_zeka_oyunu', 'zo_save_game_meta');

function zo_get_style_handle($slug) {
	return 'zo-game-style-' . sanitize_title($slug);
}

function zo_get_script_handle($slug) {
	return 'zo-game-script-' . sanitize_title($slug);
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

	if (is_singular('zeka_oyunu')) {
		wp_enqueue_script('jquery');

		$post_id = get_queried_object_id();
		$slug    = zo_resolve_game_slug_for_post($post_id);

		if ($slug) {
			zo_enqueue_game_assets_by_slug($slug);
		}
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
	$module = zo_get_game_module($slug);

	if (!$module) {
		return '<div class="zo-game-shell"><p>Oyun bulunamadı.</p></div>';
	}

	zo_enqueue_game_assets_by_slug($slug);

	$html = '';

	if (!empty($module['render_callback']) && is_callable($module['render_callback'])) {
		$result = call_user_func($module['render_callback'], (int) $post_id, $module);

		if (is_string($result)) {
			$html = $result;
		}
	}

	if (trim($html) === '') {
		$html = '<p>Bu oyun henüz görüntülenemiyor.</p>';
	}

	return '<div class="zo-game-shell zo-game-shell--' . esc_attr($module['slug']) . '">' . $html . '</div>';
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
	$css    = '
.zo-games-grid-wrap {
	width: min(100%, 1120px);
	margin: 0 auto;
}
.zo-games-grid__toolbar {
	display: flex;
	justify-content: flex-start;
	margin: 0 0 20px;
}
.zo-games-grid__home {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	min-height: 42px;
	padding: 0 16px;
	border-radius: 999px;
	background: #1d4ed8;
	color: #fff;
	font-weight: 600;
	text-decoration: none;
}
.zo-games-grid__home:hover,
.zo-games-grid__home:focus {
	background: #1e40af;
	color: #fff;
	text-decoration: none;
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
.zo-games-grid__thumb {
	display: block;
	aspect-ratio: 16 / 10;
	background: #f3f4f6;
}
.zo-games-grid__thumb img {
	display: block;
	width: 100%;
	height: 100%;
	object-fit: cover;
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
.zo-games-grid:empty {
	display: none;
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
	$show_home_button = false;

	if ($limit === 0) {
		return '';
	}

	if (empty($modules)) {
		return '<p class="zo-games-grid__empty">Henüz oyun bulunamadı.</p>';
	}

	zo_enqueue_grid_styles();

	$posts_by_slug = zo_get_game_posts_by_slug();
	$home_url      = home_url('/');

	if (!is_front_page() && !is_home() && is_string($home_url) && $home_url !== '') {
		$show_home_button = true;
	}

	ob_start();
	$has_results = false;
	$shown       = 0;

	echo '<div class="zo-games-grid-wrap">';

	if ($show_home_button) {
		echo '<div class="zo-games-grid__toolbar"><a class="zo-games-grid__home" href="' . esc_url($home_url) . '">Ana Sayfaya Dön</a></div>';
	}

	echo '<div class="zo-games-grid">';

	foreach ($modules as $slug => $module) {
		if ($author_filter !== '' && (($module['author_key'] ?? '') !== $author_filter)) {
			continue;
		}

		if ($limit > 0 && $shown >= $limit) {
			break;
		}

		$post    = $posts_by_slug[$slug] ?? null;
		$title   = $post instanceof WP_Post ? get_the_title($post) : $module['name'];
		$excerpt = $post instanceof WP_Post ? get_the_excerpt($post) : '';
		$url     = $post instanceof WP_Post ? zo_get_game_launch_url($post) : '';

		$has_results = true;
		$shown++;

		if ($excerpt === '' && !empty($module['description']) && is_string($module['description'])) {
			$excerpt = $module['description'];
		}

		echo '<article class="zo-games-grid__card">';

		if ($post instanceof WP_Post && has_post_thumbnail($post)) {
			echo '<a class="zo-games-grid__thumb" href="' . esc_url($url) . '">';
			echo get_the_post_thumbnail($post, 'large');
			echo '</a>';
		}

		echo '<div class="zo-games-grid__body">';

		if (!empty($module['author']) && is_string($module['author'])) {
			echo '<p class="zo-games-grid__author">' . esc_html($module['author']) . '</p>';
		}

		if ($url !== '') {
			echo '<h3 class="zo-games-grid__title"><a href="' . esc_url($url) . '">' . esc_html($title) . '</a></h3>';
		} else {
			echo '<h3 class="zo-games-grid__title">' . esc_html($title) . '</h3>';
		}

		if ($excerpt !== '') {
			echo '<p class="zo-games-grid__excerpt">' . esc_html($excerpt) . '</p>';
		}

		if ($title !== $module['name']) {
			echo '<div class="zo-games-grid__module">' . esc_html($module['name']) . '</div>';
		}

		if ($url !== '') {
			echo '<div class="zo-games-grid__actions"><a class="zo-games-grid__button" href="' . esc_url($url) . '">Oyunu Aç</a></div>';
		}

		echo '</div>';
		echo '</article>';
	}

	echo '</div>';

	if (!$has_results) {
		echo '<p class="zo-games-grid__empty">Filtreye uyan oyun bulunamadı.</p>';
	}

	echo '</div>';

	return ob_get_clean();
}
add_shortcode('zeka_oyunlari_grid', 'zo_games_grid_shortcode');

function zo_locate_game_template($template) {
	if (!is_singular('zeka_oyunu')) {
		return $template;
	}

	$post_id = get_queried_object_id();
	$slug    = zo_resolve_game_slug_for_post($post_id);

	if ($slug === '' || !zo_get_game_module($slug)) {
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
