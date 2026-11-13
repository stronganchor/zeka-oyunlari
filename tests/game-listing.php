<?php
/** Offline listing/translation regression; run with PHP CLI, or --fixture for browser QA. */
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
error_reporting(E_ALL);
define('ABSPATH', dirname(__DIR__) . '/');
define('ZO_PLUGIN_URL', '/');
define('ZO_PLUGIN_VERSION', 'test');

// Evaluate named production functions without running WordPress hooks or data writes.
function listing_load_function($source, $name) {
	$tokens = token_get_all($source);
	for ($i = 0, $total = count($tokens); $i < $total; $i++) {
		if (!is_array($tokens[$i]) || $tokens[$i][0] !== T_FUNCTION) { continue; }
		$j = $i + 1;
		while (isset($tokens[$j]) && is_array($tokens[$j]) && $tokens[$j][0] === T_WHITESPACE) { $j++; }
		if (!isset($tokens[$j]) || !is_array($tokens[$j]) || $tokens[$j][1] !== $name) { continue; }
		$function = ''; $depth = 0; $opened = false;
		for (; $i < $total; $i++) {
			$token = $tokens[$i];
			$function .= is_array($token) ? $token[1] : $token;
			if ($token === '{') { $depth++; $opened = true; }
			if ($token === '}') { $depth--; }
			if ($opened && $depth === 0) { eval($function); return; }
		}
	}
	throw new RuntimeException('Missing production function: ' . $name);
}

// WordPress boundary fixtures. remove_accents covers the input alphabet exercised here.
class WP_Post {}
function remove_accents($value) { return strtr($value, array('ç'=>'c','Ç'=>'C','ğ'=>'g','Ğ'=>'G','ö'=>'o','Ö'=>'O','ş'=>'s','Ş'=>'S','ü'=>'u','Ü'=>'U','é'=>'e','É'=>'E','â'=>'a','Â'=>'A')); }
function esc_attr($value) { return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8'); }
function esc_html($value) { return esc_attr($value); }
function esc_url($value) { return esc_attr($value); }
function sanitize_title($value) { return trim(strtolower(preg_replace('/[^a-zA-Z0-9-]+/', '-', $value)), '-'); }
function sanitize_key($value) { return sanitize_title($value); }
function sanitize_html_class($value) { return sanitize_title($value); }
function sanitize_text_field($value) { return trim(strip_tags($value)); }
function wp_strip_all_tags($value) { return strip_tags($value); }
function wp_unslash($value) { return stripslashes($value); }
function wp_rand($min, $max) { static $id = 1000; return ++$id; }
function wp_json_encode($value) { return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); }
function absint($value) { return abs((int) $value); }
function shortcode_atts($defaults, $atts, $name) { return array_merge($defaults, $atts); }
function home_url($path = '/') { return $path; }
function get_post_type_archive_link($type) { return '/oyunlar/'; }
function is_front_page() { return false; }
function is_home() { return false; }
function add_query_arg($key, $value, $url = '/') {
	$args = is_array($key) ? $key : array($key => $value);
	if (is_array($key)) { $url = $value; }
	return $url . (strpos($url, '?') === false ? '?' : '&') . http_build_query($args);
}
function remove_query_arg($keys, $url = '/') { return $url; }
function selected($value, $expected, $echo = true) { $text = $value === $expected ? ' selected' : ''; if ($echo) { echo $text; } return $text; }
function wp_register_style() {}
function wp_style_is() { return false; }
function wp_enqueue_style() {}
function wp_enqueue_script() {}
function wp_add_inline_style($handle, $css) { $GLOBALS['listing_css'] = $css; }
function zo_get_current_language() { return $GLOBALS['listing_language'] ?? 'tr'; }
function zo_get_game_modules() { return $GLOBALS['listing_modules']; }
function zo_get_game_posts_by_slug() { return array(); }
function zo_get_game_display_metadata($module) {
	$metadata = zo_get_asker_multilingual_game_metadata($module['slug']);
	return is_array($metadata) ? $metadata : array('name' => $module['name'], 'description' => $module['description']);
}
function zo_get_game_owner_for_module($module) { return 'asker'; }
function zo_get_game_owner_label($owner) { return 'Asker'; }
function zo_normalize_game_owner($owner) { return $owner; }
function zo_get_owner_games_url($owner, $lang) { return '/' . $owner . '/?zo_lang=' . $lang; }
function zo_get_game_module_fallback_url($slug) { return '/oyunlar/' . $slug . '/'; }
function zo_get_game_module_featured_image_url($module) { return '/games/' . $module['slug'] . '/featured-image.png'; }
function zo_dedupe_game_items_by_similarity($items) { return $items; }
function zo_get_owner_about_url($owner, $lang = '') { return '/about/'; }

$source = file_get_contents(dirname(__DIR__) . '/zeka-oyunlari.php');
listing_load_function($source, 'zo_get_asker_multilingual_game_metadata');
foreach (array('zo_get_language_options', 'zo_normalize_game_search', 'zo_get_game_category', 'zo_get_game_category_options', 'zo_get_game_category_label', 'zo_get_game_category_icon', 'zo_get_localized_text', 'zo_get_localized_game_display_metadata', 'zo_get_interface_text', 'zo_get_shortcode_logo_html', 'zo_get_shortcode_logo_css', 'zo_render_game_thumbnail', 'zo_get_game_thumbnail_url', 'zo_is_game_available_for_language', 'zo_get_game_language_availability', 'zo_enqueue_grid_styles', 'zo_games_grid_shortcode', 'zo_count_mojibake_markers', 'zo_fix_mojibake_text', 'zo_fix_runtime_replacement_pairs', 'zo_get_runtime_translation_exact_map', 'zo_get_runtime_translation_replacements', 'zo_wrap_game_runtime_translator') as $name) {
	listing_load_function($source, $name);
}
$echo = require dirname(__DIR__) . '/games/echo-cartographer/game.php';
$roster = require dirname(__DIR__) . '/games/roster-1000/game.php';
$modules = array(
	$roster,
	array('slug'=>'binary-puzzle', 'name'=>'TR: İkili Bulmaca | EN: Binary Puzzle', 'description'=>'Fill the grid with 0 and 1.'),
	array('slug'=>'soccer-match-ai', 'name'=>'TR: Yapay Zeka Futbol Maçı | EN: Soccer Match AI', 'description'=>'Play a soccer match before time runs out.'),
	$echo,
	array('slug'=>'time-loop-runner', 'name'=>'TR: Zaman Döngüsü Koşucusu | EN: Time Loop Runner', 'description'=>'Watch a sequence and repeat it.'),
	array('slug'=>'time-traveler-puzzle', 'name'=>'TR: Zaman Yolcusu Bulmacası | EN: Time Traveler Puzzle', 'description'=>'Switch between past and future.'),
);
$GLOBALS['listing_modules'] = array_column($modules, null, 'slug');
$_GET = array();
$grid = zo_games_grid_shortcode(array('author'=>'asker'));
$wrapped = zo_wrap_game_runtime_translator(zo_game_echo_cartographer_render(), $echo, 'tr');

function listing_check($ok, $message) {
	if (!$ok) { throw new RuntimeException($message); }
	$GLOBALS['listing_checks'] = ($GLOBALS['listing_checks'] ?? 0) + 1;
}
function listing_dom($html) {
	$dom = new DOMDocument();
	@$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
	return new DOMXPath($dom);
}
$xpath = listing_dom($grid);
$disabled = $xpath->query('//article[@data-slug="roster-1000"]')->item(0);
listing_check($disabled !== null, 'Unavailable game remains listed.');
listing_check($disabled->getAttribute('data-url') === '', 'Unavailable game has no launch URL.');
listing_check($xpath->query('.//a | .//button', $disabled)->length === 0, 'Unavailable game has no play/favorite links.');
listing_check($xpath->query('.//img', $disabled)->length === 1, 'Unavailable game retains its cover.');
listing_check(strpos($disabled->textContent, 'Şu anda kullanılamıyor') !== false, 'Unavailable status is visible.');
listing_check(strpos($grid, 'badge--popular') === false, 'No invented popularity badges.');
listing_check($roster['available'] === false && $roster['render_callback'] === 'zo_game_roster_1000_security_disabled_render', 'Roster security disable remains intact.');
foreach (array('ikili','İKİLİ','IKILI',"I\u{0307}kili") as $query) {
	$_GET = array('zo_game_search'=>$query);
	$results = listing_dom(zo_games_grid_shortcode(array('author'=>'asker')));
	listing_check($results->query('//article[@data-slug="binary-puzzle"]')->length === 1, 'Server search finds ' . $query);
	listing_check($results->query('//article')->length === 1, 'Search returns only the matching game.');
}
listing_check(zo_normalize_game_search('ÇIĞ ŞÖLENİ') === 'cig soleni', 'Turkish accents and dotless I fold without mbstring.');
$_GET = array('zo_game_category'=>'sports');
$sports = listing_dom(zo_games_grid_shortcode(array('author'=>'asker')));
listing_check($sports->query('//article[@data-slug="soccer-match-ai"]')->length === 1, 'Sports filter includes football.');
foreach (zo_get_language_options() as $language => $label) {
	foreach (array('soccer-match-ai'=>'sports','echo-cartographer'=>'puzzle','time-loop-runner'=>'memory','time-traveler-puzzle'=>'puzzle') as $slug => $expected) {
		$metadata = zo_get_localized_game_display_metadata($GLOBALS['listing_modules'][$slug], $language);
		listing_check($metadata['category_key'] === $expected, $slug . ' has the same category in ' . $language);
	}
	listing_check(zo_get_interface_text('game_unavailable', $language) !== '', 'Unavailable status is localized for ' . $language);
}
listing_check(zo_get_game_category('angle-match', '', 'Match the angle before time runs out.') === 'math', 'Angle matching stays mathematics.');
listing_check(zo_get_game_category('adana-clock', '', '') === 'tool', 'Clocks stay tools.');
$_GET = array();

if (in_array('--fixture', $argv, true)) {
	$cards = array();
	foreach ($xpath->query('//article') as $article) {
		$attributes = array();
		foreach ($article->attributes as $attribute) { $attributes[$attribute->name] = $attribute->value; }
		$cards[] = $attributes;
	}
	echo wp_json_encode(array('grid'=>$grid, 'cards'=>$cards, 'css'=>$GLOBALS['listing_css'], 'echo'=>$wrapped, 'echo_css'=>$echo['inline_style'], 'echo_script'=>$echo['inline_script'], 'translations'=>$echo['runtime_translations']['tr']));
} else {
	echo 'PASS: ' . $GLOBALS['listing_checks'] . " listing, search, category and unavailable-game checks\n";
}
