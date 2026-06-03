<?php
if (!defined('ABSPATH')) {
	exit;
}

$post_id = get_queried_object_id();
$slug    = function_exists('zo_get_requested_game_slug') ? zo_get_requested_game_slug() : '';
$module  = $slug !== '' && function_exists('zo_get_game_module') ? zo_get_game_module($slug) : null;

if (!$module || !is_array($module)) {
	status_header(404);
	nocache_headers();
	echo '<!doctype html><html><body><p>Oyun bulunamadi.</p></body></html>';
	return;
}

$back_url   = function_exists('zo_get_game_back_url') ? zo_get_game_back_url($post_id) : home_url('/');
$language   = function_exists('zo_get_current_language') ? zo_get_current_language() : 'tr';
$page_title = $post_id ? get_the_title($post_id) : '';

if (function_exists('zo_is_game_available_for_language') && !zo_is_game_available_for_language($slug, $language)) {
	$owner = $post_id && function_exists('zo_get_game_owner_for_post') ? zo_get_game_owner_for_post($post_id) : '';

	if ($owner === '' && function_exists('zo_get_game_owner_for_module')) {
		$owner = zo_get_game_owner_for_module($module);
	}

	$redirect_url = function_exists('zo_get_owner_games_url') ? zo_get_owner_games_url($owner, $language) : home_url('/');
	wp_safe_redirect($redirect_url, 302);
	exit;
}

if (!is_string($page_title) || $page_title === '') {
	$page_title = (string) $module['name'];
}

$display_metadata = null;

if (function_exists('zo_get_game_display_metadata')) {
	$display_metadata = zo_get_game_display_metadata($module);
}

if (is_array($display_metadata) && !empty($display_metadata['name'])) {
	$page_title = (string) $display_metadata['name'];
} elseif (!empty($module['name'])) {
	$page_title = (string) $module['name'];
}

if (function_exists('zo_get_localized_text')) {
	$page_title = zo_get_localized_text($page_title, $language);
}

$site_name = get_bloginfo('name');
$back_url = add_query_arg('zo_lang', $language, $back_url);
$style_url = function_exists('zo_get_game_style_url') ? zo_get_game_style_url($module) : '';
$script_url = function_exists('zo_get_game_script_url') ? zo_get_game_script_url($module) : '';
$inline_style = !empty($module['inline_style']) && is_string($module['inline_style']) ? $module['inline_style'] : '';
$inline_script = !empty($module['inline_script']) && is_string($module['inline_script']) ? $module['inline_script'] : '';
$module_description = !empty($module['description']) && is_string($module['description']) ? trim(wp_strip_all_tags($module['description'])) : '';

if (is_array($display_metadata) && !empty($display_metadata['description'])) {
	$module_description = trim(wp_strip_all_tags((string) $display_metadata['description']));
}

if (function_exists('zo_get_localized_text')) {
	$module_description = zo_get_localized_text($module_description, $language);
}

$seo_keywords = function_exists('zo_get_interface_text') ? zo_get_interface_text('intro', $language) : '';
$play_suffix = function_exists('zo_get_interface_text') ? zo_get_interface_text('play_suffix', $language) : 'oyna';
$seo_description = trim($page_title . ' ' . $play_suffix . '. ' . $seo_keywords);
$game_category = 'puzzle';
$game_category_label = '';
$difficulty_key = 'medium';
$difficulty_label = '';
$related_games = array();
$game_thumbnail_url = function_exists('zo_get_game_thumbnail_url') ? zo_get_game_thumbnail_url($post_id ? get_post($post_id) : null, $module) : '';

if ($module_description !== '') {
	$seo_description = trim($page_title . ' ' . $play_suffix . '. ' . $module_description . ' ' . $seo_keywords);
}

if (function_exists('zo_get_localized_game_display_metadata')) {
	$localized_metadata = zo_get_localized_game_display_metadata($module, $language);

	if (is_array($localized_metadata)) {
		$game_category = !empty($localized_metadata['category_key']) ? (string) $localized_metadata['category_key'] : $game_category;
		$game_category_label = !empty($localized_metadata['category_label']) ? (string) $localized_metadata['category_label'] : '';
	}
}

if ($game_category_label === '' && function_exists('zo_get_game_category_label')) {
	$game_category_label = zo_get_game_category_label($game_category, $language);
}

if (function_exists('zo_get_game_difficulty_key')) {
	$difficulty_key = zo_get_game_difficulty_key($module, $game_category);
}

if (function_exists('zo_get_game_difficulty_label')) {
	$difficulty_label = zo_get_game_difficulty_label($module, $game_category, $language);
}

if (function_exists('zo_get_related_game_items')) {
	$related_games = zo_get_related_game_items($slug, $language, 4);
}

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?php echo esc_attr($seo_description); ?>">
	<title><?php echo esc_html($page_title . ($site_name ? ' | ' . $site_name : '')); ?></title>
	<?php if (function_exists('wp_site_icon')) { wp_site_icon(); } ?>
	<style>
		html, body {
			margin: 0;
			min-height: 100%;
			background: #0f172a;
			color: #e2e8f0;
			font-family: Georgia, "Times New Roman", serif;
		}

		body {
			min-height: 100vh;
		}

		.zo-game-page {
			min-height: 100vh;
			display: flex;
			flex-direction: column;
		}

		.zo-game-page__header {
			display: flex;
			align-items: center;
			padding: 18px 20px;
		}

		.zo-game-page__back {
			display: inline-flex;
			align-items: center;
			gap: 8px;
			padding: 10px 16px;
			border-radius: 999px;
			background: rgba(15, 118, 110, 0.95);
			color: #fff;
			font-weight: 600;
			text-decoration: none;
			box-shadow: 0 10px 30px rgba(15, 23, 42, 0.22);
		}

		.zo-game-page__back:hover,
		.zo-game-page__back:focus {
			background: #115e59;
			color: #fff;
			text-decoration: none;
		}

		.zo-game-page__main {
			flex: 1 1 auto;
			display: flex;
			flex-direction: column;
			padding: 0 20px 20px;
		}

		.zo-game-page__meta {
			width: min(100%, 1400px);
			margin: 0 auto 16px;
		}

		.zo-game-page__title {
			margin: 0 0 8px;
			color: #f8fafc;
			font-family: Arial, sans-serif;
			font-size: clamp(26px, 4vw, 42px);
			line-height: 1.15;
		}

		.zo-game-page__description {
			max-width: 900px;
			margin: 0;
			color: #cbd5e1;
			font-family: Arial, sans-serif;
			font-size: 1rem;
			line-height: 1.55;
		}

		.zo-game-page__tags {
			display: flex;
			flex-wrap: wrap;
			gap: 8px;
			margin: 12px 0 0;
			font-family: Arial, sans-serif;
		}

		.zo-game-page__tag {
			display: inline-flex;
			align-items: center;
			gap: 6px;
			min-height: 32px;
			padding: 0 11px;
			border-radius: 999px;
			background: rgba(255, 255, 255, 0.1);
			color: #f8fafc;
			font-size: 0.86rem;
			font-weight: 800;
		}

		.zo-game-page__tag--difficulty {
			background: #0f766e;
			color: #fff;
		}

		.zo-game-page__stage {
			flex: 1 1 auto;
			width: min(100%, 1400px);
			margin: 0 auto;
			display: flex;
			align-items: stretch;
			justify-content: center;
		}

		.zo-game-page__stage .zo-game-shell {
			flex: 1 1 auto;
			width: 100%;
			min-height: calc(100vh - 110px);
		}

		.zo-game-page__stage .zo-game-root {
			width: 100%;
			min-height: calc(100vh - 110px);
		}

		.zo-game-page__related {
			width: min(100%, 1400px);
			margin: 24px auto 0;
			font-family: Arial, sans-serif;
		}

		.zo-game-page__related-title {
			margin: 0 0 14px;
			color: #f8fafc;
			font-size: 1.35rem;
			line-height: 1.2;
		}

		.zo-game-page__related-grid {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(min(100%, 220px), 1fr));
			gap: 14px;
		}

		.zo-game-page__related-card {
			display: flex;
			flex-direction: column;
			gap: 8px;
			min-height: 100%;
			padding: 14px;
			border: 1px solid rgba(203, 213, 225, 0.22);
			border-radius: 14px;
			background: rgba(255, 255, 255, 0.08);
			color: #e2e8f0;
			text-decoration: none;
		}

		.zo-game-page__related-card:hover,
		.zo-game-page__related-card:focus {
			border-color: rgba(191, 219, 254, 0.7);
			background: rgba(255, 255, 255, 0.12);
			color: #fff;
			text-decoration: none;
		}

		.zo-game-page__related-thumb {
			display: block;
			width: 100%;
			aspect-ratio: 16 / 9;
			border-radius: 10px;
			background: rgba(226, 232, 240, 0.14);
			object-fit: cover;
			overflow: hidden;
		}

		.zo-game-page__related-category {
			color: #bfdbfe;
			font-size: 0.78rem;
			font-weight: 800;
			text-transform: uppercase;
		}

		.zo-game-page__related-name {
			color: inherit;
			font-size: 1rem;
			font-weight: 900;
			line-height: 1.25;
		}

		.zo-game-page__related-description {
			color: #cbd5e1;
			font-size: 0.9rem;
			line-height: 1.45;
		}

		.zo-game-page__bottom-actions {
			width: min(100%, 1400px);
			margin: 24px auto 0;
			font-family: Arial, sans-serif;
		}

		@media (max-width: 640px) {
			.zo-game-page__header {
				padding: 14px 14px 8px;
			}

			.zo-game-page__back {
				min-height: 38px;
				padding: 0 12px;
				font-size: 0.9rem;
			}

			.zo-game-page__main {
				padding: 0 14px 14px;
			}

			.zo-game-page__meta {
				margin-bottom: 12px;
			}

			.zo-game-page__stage .zo-game-shell,
			.zo-game-page__stage .zo-game-root {
				min-height: calc(100vh - 84px);
			}
		}
	</style>
	<?php if (function_exists('zo_get_input_blocker_css')) : ?>
	<style><?php echo zo_get_input_blocker_css(); ?></style>
	<?php endif; ?>
	<?php if ($style_url !== '') : ?>
	<link rel="stylesheet" href="<?php echo esc_url($style_url); ?>">
	<?php endif; ?>
	<?php if ($inline_style !== '') : ?>
	<style><?php echo $inline_style; ?></style>
	<?php endif; ?>
</head>
<body>
	<div class="zo-game-page">
		<header class="zo-game-page__header">
			<a class="zo-game-page__back" href="<?php echo esc_url($back_url); ?>"><?php echo esc_html(function_exists('zo_get_interface_text') ? zo_get_interface_text('home', $language) : 'Geri Dön'); ?></a>
		</header>
		<main class="zo-game-page__main">
			<div class="zo-game-page__meta">
				<h1 class="zo-game-page__title"><?php echo esc_html($page_title); ?></h1>
				<?php if ($module_description !== '') : ?>
				<p class="zo-game-page__description"><?php echo esc_html($module_description); ?></p>
				<?php endif; ?>
				<div class="zo-game-page__tags">
					<?php if ($game_category_label !== '') : ?>
					<span class="zo-game-page__tag"><?php echo esc_html($game_category_label); ?></span>
					<?php endif; ?>
					<?php if ($difficulty_label !== '') : ?>
					<span class="zo-game-page__tag zo-game-page__tag--difficulty"><?php echo esc_html((function_exists('zo_get_interface_text') ? zo_get_interface_text('difficulty_label', $language) : 'Difficulty') . ': ' . $difficulty_label); ?></span>
					<?php endif; ?>
				</div>
			</div>
			<div class="zo-game-page__stage">
				<?php echo zo_render_game($slug, $post_id); ?>
			</div>
			<?php if (!empty($related_games)) : ?>
			<section class="zo-game-page__related" aria-label="<?php echo esc_attr(function_exists('zo_get_interface_text') ? zo_get_interface_text('related_games', $language) : 'Related games'); ?>">
				<h2 class="zo-game-page__related-title"><?php echo esc_html(function_exists('zo_get_interface_text') ? zo_get_interface_text('related_games', $language) : 'Related games'); ?></h2>
				<div class="zo-game-page__related-grid">
					<?php foreach ($related_games as $related) : ?>
						<a class="zo-game-page__related-card" href="<?php echo esc_url($related['url']); ?>">
							<?php if (!empty($related['thumbnail_url'])) : ?>
							<img class="zo-game-page__related-thumb" src="<?php echo esc_url($related['thumbnail_url']); ?>" alt="" loading="lazy">
							<?php else : ?>
							<span class="zo-game-page__related-thumb" aria-hidden="true"></span>
							<?php endif; ?>
							<span class="zo-game-page__related-category"><?php echo esc_html($related['category_label']); ?></span>
							<span class="zo-game-page__related-name"><?php echo esc_html($related['title']); ?></span>
							<?php if (!empty($related['description'])) : ?>
							<span class="zo-game-page__related-description"><?php echo esc_html(wp_trim_words(wp_strip_all_tags($related['description']), 18)); ?></span>
							<?php endif; ?>
						</a>
					<?php endforeach; ?>
				</div>
			</section>
			<?php endif; ?>
			<div class="zo-game-page__bottom-actions">
				<a class="zo-game-page__back" href="<?php echo esc_url($back_url); ?>"><?php echo esc_html(function_exists('zo_get_interface_text') ? zo_get_interface_text('back_to_games', $language) : 'Back to games'); ?></a>
			</div>
		</main>
	</div>
	<script>
	(function(){
		try {
			var game = {
				slug: <?php echo wp_json_encode($slug); ?>,
				title: <?php echo wp_json_encode($page_title); ?>,
				url: <?php echo wp_json_encode(get_permalink($post_id) ? add_query_arg('zo_lang', $language, get_permalink($post_id)) : home_url('/')); ?>,
				thumb: <?php echo wp_json_encode($game_thumbnail_url); ?>
			};
			if (!game.slug) {
				return;
			}
			var key = 'zoRecentlyPlayedGames';
			var items = JSON.parse(localStorage.getItem(key) || '[]');
			if (!Array.isArray(items)) {
				items = [];
			}
			items = items.filter(function(item) {
				return item && item.slug !== game.slug;
			});
			items.unshift(game);
			localStorage.setItem(key, JSON.stringify(items.slice(0, 20)));
		} catch (error) {}
	})();
	</script>
	<?php if ($script_url !== '') : ?>
	<script src="<?php echo esc_url($script_url); ?>"></script>
	<?php endif; ?>
	<?php if ($inline_script !== '') : ?>
	<script><?php echo $inline_script; ?></script>
	<?php endif; ?>
	<?php if (function_exists('zo_get_input_blocker_js')) : ?>
	<script><?php echo zo_get_input_blocker_js(); ?></script>
	<?php endif; ?>
</body>
</html>
