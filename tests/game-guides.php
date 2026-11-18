<?php
/** Offline guide coverage, routing, escaping and actual-template rendering. */
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
ob_start();
require __DIR__ . '/game-listing.php';
ob_end_clean();
listing_load_function($source, 'zo_locate_game_template');
listing_load_function($source, 'zo_render_game');
function is_post_type_archive($type) { return $GLOBALS['guide_archive'] ?? false; }
function get_bloginfo($key) { return $key === 'name' ? 'Zekâ Test' : 'UTF-8'; }
function bloginfo($key) { echo get_bloginfo($key); }
function status_header($code) { $GLOBALS['guide_status'] = $code; }
function nocache_headers() { $GLOBALS['guide_nocache'] = true; }
function get_permalink($post) { return '/oyunlar/published-test/'; }
function zo_enqueue_game_assets_by_slug($slug) {}
function zo_translate_multilingual_runtime_text($html, $lang) { return $html; }
function zo_render_game_report_link($slug, $lang) { return ''; }

$catalog = array();
foreach (glob(dirname(__DIR__) . '/games/*/game.php') as $path) {
	$game_source = file_get_contents($path);
	if (!preg_match('/[\'"]author[\'"]\s*=>\s*[\'"]asker[\'"]/i', $game_source)) { continue; }
	preg_match_all('/[\'"]slug[\'"]\s*=>\s*[\'"]([^\'"]+)/', $game_source, $slugs);
	preg_match_all('/[\'"]name[\'"]\s*=>\s*[\'"]([^\'"]+)/', $game_source, $names);
	$slug = end($slugs[1]);
	$catalog[$slug] = array('slug'=>$slug, 'name'=>end($names[1]), 'description'=>'Source-reviewed game by Asker.', 'author'=>'Asker', 'author_key'=>'asker');
}
$catalog['roster-1000'] = $roster + array('author_key'=>'asker');
listing_check(count($catalog) === 86, 'Fixture covers all 86 current Asker modules. Update content when modules change.');
$GLOBALS['listing_modules'] = $catalog;
$page_count = 0;
$canonical_urls = array();
$page_titles = array();
$preview = '';
foreach ($catalog as $slug => $module) {
	foreach (array_keys(zo_get_language_options()) as $language) {
		$GLOBALS['listing_language'] = $language;
		$_GET = array('zo_game_description'=>$slug, 'zo_lang'=>$language);
		$guide = zo_get_game_guide($module, $language);
		if (!zo_is_game_available_for_language($slug, $language)) {
			listing_check($guide === null && zo_get_game_description_url($slug, $language) === '', $slug . ' retains its language restriction.');
			listing_check(zo_get_requested_description_module() === null, 'Restricted language has no public description.');
			continue;
		}
		listing_check(is_array($guide), $slug . ' has content in ' . $language);
		listing_check(count($guide['steps']) >= ($slug === 'roster-1000' ? 1 : 2) && count($guide['rules']) >= 1 && strlen($guide['benefits']) > 20, $slug . ' has complete content in ' . $language);
		$compact = zo_render_game_guide($module, $language, true);
		listing_check(strpos($compact, 'data-zo-game-description-link') !== false, 'Below-game guide links to its full page.');
		listing_check(zo_get_requested_description_module()['slug'] === $slug, 'Public guide route resolves the expected module.');
		$GLOBALS['guide_archive'] = true;
		listing_check(zo_locate_game_template('/theme/index.php') === ZO_PLUGIN_DIR . 'templates/game-description.php', 'Description route takes priority over archive template.');
		listing_check(zo_game_description_canonical_redirect('/wrong-redirect/') === false, 'WordPress canonical redirect preserves guide query.');
		ob_start();
		include ZO_PLUGIN_DIR . 'templates/game-description.php';
		$html = ob_get_clean();
		$dom = listing_dom($html);
		listing_check($GLOBALS['guide_status'] === 200 && $dom->query('//h1')->length === 1, 'Valid guide returns one heading and HTTP 200.');
		listing_check($dom->query('//html[@lang="' . $language . '"]')->length === 1, 'Document language matches guide content.');
		listing_check($dom->query('//script')->length === 0, 'Guide is fully readable with JavaScript disabled.');
		listing_check($dom->query('//meta[@name="description"]')->length === 1, 'Guide includes a description meta tag.');
		$canonical = $dom->query('//link[@rel="canonical"]')->item(0)->getAttribute('href');
		listing_check(!isset($canonical_urls[$canonical]) && strpos($canonical, 'zo_nonce') === false && strpos($canonical, 'zo_back') === false, 'Guide canonical is unique and stable.');
		$canonical_urls[$canonical] = true;
		$title = $dom->query('//title')->item(0)->textContent;
		listing_check(!isset($page_titles[$language][$title]), 'Page title distinguishes the game in ' . $language);
		$page_titles[$language][$title] = true;
		if ($slug === 'roster-1000') {
			listing_check($dom->query('//a[@class="zo-description-page__play"]')->length === 0, 'Unavailable page has no play link.');
			listing_check($dom->query('//meta[@name="robots" and @content="noindex,follow"]')->length === 1, 'Unavailable page avoids promotional indexing.');
		} else {
			listing_check($dom->query('//section//ol/li')->length >= 2 && $dom->query('//section//ul/li')->length >= 1, 'Instructions and rules are server-rendered lists.');
			$play = $dom->query('//a[@class="zo-description-page__play"]')->item(0)->getAttribute('href');
			parse_str(parse_url($play, PHP_URL_QUERY), $play_args);
			listing_check(($play_args['zo_lang'] ?? '') === $language && ($play_args['zo_game_module'] ?? '') === $slug && !isset($play_args['zo_game_description']), 'Play link opens the actual game in the same language.');
		}
		foreach ($dom->query('//link[@rel="alternate"]') as $alternate) {
			listing_check(in_array($alternate->getAttribute('hreflang'), zo_get_game_language_availability($slug), true), 'Alternate languages are available for this game.');
		}
		$page_count++;
		if ($slug === 'binary-puzzle' && $language === 'tr') { $preview = $html; }
	}
}
$GLOBALS['listing_language'] = 'en';
foreach (array('missing-game', 'binary-puzzle/../../', array('binary-puzzle'), '', 'Binary-Puzzle') as $bad) {
	$_GET = array('zo_game_description'=>$bad);
	listing_check(zo_get_requested_description_module() === null, 'Invalid guide query is rejected.');
	ob_start(); include ZO_PLUGIN_DIR . 'templates/game-description.php'; $missing_html = ob_get_clean();
	listing_check($GLOBALS['guide_status'] === 404 && strpos($missing_html, 'noindex') !== false, 'Invalid guide gives a non-indexable 404.');
}
$other = array('slug'=>'arslan-only-test','name'=>'Other Game','author_key'=>'arslan');
$GLOBALS['listing_modules'][$other['slug']] = $other;
listing_check(zo_get_game_guide($other, 'en') === null && zo_render_game_description_link($other, 'en') === '', 'Other authors are outside this change.');
$_GET = array('zo_game_description'=>$other['slug']);
listing_check(zo_get_requested_description_module() === null, 'Other author route is unavailable.');
$_GET = array();
listing_check(zo_game_description_canonical_redirect('/original/') === '/original/', 'Unrelated canonical redirects retain normal behavior.');
$GLOBALS['guide_archive'] = false;
// Use the actual game wrapper, with an inert game callback. Guide must follow gameplay.
$GLOBALS['listing_modules']['binary-puzzle']['render_callback'] = function () { return '<div id="inert-game">Game</div>'; };
$rendered = zo_render_game('binary-puzzle');
listing_check(strpos($rendered, 'inert-game') < strpos($rendered, 'zo-game-guide--compact'), 'Shared rendering places guide below gameplay.');
// Hostile source metadata must remain text in link attributes and page headings.
$GLOBALS['listing_modules']['adana-clock']['name'] = '<img src=x onerror=alert(1)> & "clock"';
$_GET = array('zo_game_description'=>'adana-clock');
ob_start(); include ZO_PLUGIN_DIR . 'templates/game-description.php'; $escaped = ob_get_clean();
listing_check(listing_dom($escaped)->query('//h1//img | //script | //*[@onerror]')->length === 0, 'Source metadata is escaped in rendered HTML.');
if (in_array('--preview', $argv, true)) {
	echo $preview;
} else {
	echo 'PASS: ' . $GLOBALS['listing_checks'] . ' assertions; ' . count($catalog) . ' Asker modules, ' . $page_count . " localized guide pages\n";
}
