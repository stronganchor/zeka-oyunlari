<?php
/**
 * Plugin Name: Zekâ Oyunları
 * Plugin URI: https://github.com/stronganchor/zeka-oyunlari
 * Description: Simple modular game framework for zekâ.com so kids can publish WordPress-based games and share them with friends.
 * Version: 1.0.0
 * Author: Anadolu Tasarım
 * Author URI: https://github.com/stronganchor/zeka-oyunlari
 * Text Domain: zeka-oyunlari
 * Requires at least: 6.0
 * Requires PHP: 7.4
 */

if (!defined('ABSPATH')) {
	exit;
}

define('ZO_PLUGIN_VERSION', '1.0.0');
define('ZO_PLUGIN_FILE', __FILE__);
define('ZO_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('ZO_PLUGIN_URL', plugin_dir_url(__FILE__));

register_activation_hook(__FILE__, 'zo_plugin_activate');
register_deactivation_hook(__FILE__, 'zo_plugin_deactivate');

function zo_plugin_activate() {
	zo_register_game_post_type();
	flush_rewrite_rules();
}

function zo_plugin_deactivate() {
	flush_rewrite_rules();
}

function zo_get_game_modules() {
	static $modules = null;

	if ($modules !== null) {
		return $modules;
	}

	$modules = array();
	$files   = glob(ZO_PLUGIN_DIR . 'games/*/game.php');

	if (empty($files)) {
		return $modules;
	}

	foreach ($files as $file) {
		$module = include $file;

		if (!is_array($module)) {
			continue;
		}

		if (empty($module['slug']) || empty($module['name'])) {
			continue;
		}

		$slug   = sanitize_title($module['slug']);
		$folder = basename(dirname($file));

		$module['slug']   = $slug;
		$module['folder'] = $folder;
		$module['dir']    = trailingslashit(ZO_PLUGIN_DIR . 'games/' . $folder);
		$module['url']    = trailingslashit(ZO_PLUGIN_URL . 'games/' . $folder);

		$modules[$slug] = $module;
	}

	ksort($modules);

	return $modules;
}

function zo_get_game_module($slug) {
	$slug    = sanitize_title($slug);
	$modules = zo_get_game_modules();

	return isset($modules[$slug]) ? $modules[$slug] : null;
}

function zo_get_game_slug_for_post($post_id) {
	return sanitize_title((string) get_post_meta($post_id, '_zo_game_slug', true));
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
		$style_file = $module['dir'] . 'style.css';
		$script_file = $module['dir'] . 'script.js';

		if (file_exists($style_file)) {
			wp_register_style(
				zo_get_style_handle($module['slug']),
				$module['url'] . 'style.css',
				array(),
				(string) filemtime($style_file)
			);
		}

		if (file_exists($script_file)) {
			wp_register_script(
				zo_get_script_handle($module['slug']),
				$module['url'] . 'script.js',
				array(),
				(string) filemtime($script_file),
				true
			);
		}
	}
}
add_action('wp_enqueue_scripts', 'zo_register_game_assets', 5);

function zo_enqueue_game_assets_by_slug($slug) {
	$slug = sanitize_title($slug);

	if (!$slug) {
		return;
	}

	$style_handle  = zo_get_style_handle($slug);
	$script_handle = zo_get_script_handle($slug);

	if (wp_style_is($style_handle, 'registered')) {
		wp_enqueue_style($style_handle);
	}

	if (wp_script_is($script_handle, 'registered')) {
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
		$post_id = get_queried_object_id();
		$slug    = zo_get_game_slug_for_post($post_id);

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
