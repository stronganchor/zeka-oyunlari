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
$game_owner = $post_id && function_exists('zo_get_game_owner_for_post') ? zo_get_game_owner_for_post($post_id) : '';
if ($game_owner === '' && function_exists('zo_get_game_owner_for_module')) {
	$game_owner = zo_get_game_owner_for_module($module);
}
$games_url  = $game_owner !== '' && function_exists('zo_get_owner_games_url') ? zo_get_owner_games_url($game_owner, $language) : $back_url;

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

		.zo-game-page__progress {
			display: grid;
			gap: 9px;
			max-width: 680px;
			margin: 14px 0 0;
			font-family: Arial, sans-serif;
		}

		.zo-game-page__progress-track {
			height: 9px;
			border-radius: 999px;
			background: rgba(226, 232, 240, 0.16);
			overflow: hidden;
		}

		.zo-game-page__progress-fill {
			display: block;
			width: 0;
			height: 100%;
			border-radius: inherit;
			background: linear-gradient(90deg, #14b8a6, #38bdf8);
			transition: width 220ms ease;
		}

		.zo-game-page__progress-steps {
			display: flex;
			flex-wrap: wrap;
			gap: 8px;
		}

		.zo-game-page__progress-step {
			display: inline-flex;
			align-items: center;
			min-height: 30px;
			padding: 0 10px;
			border-radius: 999px;
			background: rgba(255, 255, 255, 0.08);
			color: #cbd5e1;
			font-size: 0.82rem;
			font-weight: 800;
		}

		.zo-game-page__progress-step.is-active {
			background: #0f766e;
			color: #fff;
		}

		.zo-game-page__stats {
			display: grid;
			grid-template-columns: repeat(3, minmax(0, 1fr));
			gap: 10px;
			max-width: 680px;
			margin: 12px 0 0;
			font-family: Arial, sans-serif;
		}

		.zo-game-page__stat {
			min-width: 0;
			padding: 10px 12px;
			border: 1px solid rgba(203, 213, 225, 0.18);
			border-radius: 12px;
			background: rgba(255, 255, 255, 0.08);
		}

		.zo-game-page__stat-label {
			display: block;
			margin-bottom: 4px;
			color: #bfdbfe;
			font-family: Arial, sans-serif;
			font-size: 0.74rem;
			font-weight: 900;
			line-height: 1.15;
			text-transform: uppercase;
		}

		.zo-game-page__stat-value {
			display: block;
			color: #f8fafc;
			font-size: 0.98rem;
			font-weight: 900;
			line-height: 1.25;
			overflow-wrap: anywhere;
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
			margin: 42px auto 0;
			padding: 0 0 36px;
			font-family: Arial, sans-serif;
			text-align: center;
		}

		.zo-game-page__bottom-actions .zo-game-page__back {
			margin: 0 auto;
		}

		@media (max-width: 640px) {
			.zo-game-page__header {
				position: sticky;
				top: 0;
				z-index: 40;
				padding: 8px 10px 6px;
				background: rgba(15, 23, 42, 0.94);
				backdrop-filter: blur(10px);
			}

			.zo-game-page__back {
				min-height: 38px;
				padding: 0 12px;
				font-size: 0.9rem;
			}

			.zo-game-page__main {
				padding: 0 10px 22px;
			}

			.zo-game-page__meta {
				margin-bottom: 8px;
			}

			.zo-game-page__title {
				margin-bottom: 5px;
				font-size: clamp(22px, 8vw, 30px);
			}

			.zo-game-page__description {
				display: -webkit-box;
				-webkit-box-orient: vertical;
				-webkit-line-clamp: 2;
				overflow: hidden;
				font-size: 0.92rem;
				line-height: 1.42;
			}

			.zo-game-page__tags,
			.zo-game-page__progress-steps {
				flex-wrap: nowrap;
				overflow-x: auto;
				padding-bottom: 4px;
				scrollbar-width: none;
			}

			.zo-game-page__tags::-webkit-scrollbar,
			.zo-game-page__progress-steps::-webkit-scrollbar {
				display: none;
			}

			.zo-game-page__progress {
				margin-top: 8px;
				gap: 7px;
			}

			.zo-game-page__progress-track {
				height: 7px;
			}

			.zo-game-page__stats {
				grid-template-columns: repeat(3, minmax(92px, 1fr));
				gap: 8px;
				overflow-x: auto;
				padding-bottom: 4px;
				scrollbar-width: none;
			}

			.zo-game-page__stats::-webkit-scrollbar {
				display: none;
			}

			.zo-game-page__stat {
				padding: 8px 10px;
			}

			.zo-game-page__stage .zo-game-shell,
			.zo-game-page__stage .zo-game-root {
				min-height: calc(100vh - 84px);
			}

			.zo-game-page__related {
				margin-top: 18px;
			}

			.zo-game-page__related-title {
				font-size: 1.12rem;
			}

			.zo-game-page__related-grid {
				display: flex;
				gap: 12px;
				overflow-x: auto;
				padding: 0 4px 10px;
				scroll-snap-type: x mandatory;
				scrollbar-width: none;
			}

			.zo-game-page__related-grid::-webkit-scrollbar {
				display: none;
			}

			.zo-game-page__related-card {
				flex: 0 0 min(82vw, 310px);
				scroll-snap-align: start;
			}

			.zo-game-page__bottom-actions {
				padding-bottom: 42px;
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
				<div class="zo-game-page__progress" data-zo-game-progress aria-label="<?php echo esc_attr(function_exists('zo_get_interface_text') ? zo_get_interface_text('game_progress', $language) : 'Game progress'); ?>">
					<div class="zo-game-page__progress-track" aria-hidden="true">
						<span class="zo-game-page__progress-fill" data-zo-progress-fill></span>
					</div>
					<div class="zo-game-page__progress-steps">
						<span class="zo-game-page__progress-step" data-zo-progress-step="opened"><?php echo esc_html(function_exists('zo_get_interface_text') ? zo_get_interface_text('progress_opened', $language) : 'Opened'); ?></span>
						<span class="zo-game-page__progress-step" data-zo-progress-step="favorite"><?php echo esc_html(function_exists('zo_get_interface_text') ? zo_get_interface_text('progress_favorite', $language) : 'Favorite'); ?></span>
						<?php if (in_array($game_owner, array('asker', 'arslan'), true)) : ?>
						<span class="zo-game-page__progress-step" data-zo-progress-step="streak"><?php echo esc_html(function_exists('zo_get_interface_text') ? zo_get_interface_text('progress_streak', $language) : 'Streak counting'); ?></span>
						<?php endif; ?>
					</div>
				</div>
				<div class="zo-game-page__stats" data-zo-game-stats aria-label="<?php echo esc_attr(function_exists('zo_get_interface_text') ? zo_get_interface_text('game_stats', $language) : 'Game stats'); ?>">
					<div class="zo-game-page__stat">
						<span class="zo-game-page__stat-label"><?php echo esc_html(function_exists('zo_get_interface_text') ? zo_get_interface_text('stat_plays', $language) : 'Plays'); ?></span>
						<span class="zo-game-page__stat-value" data-zo-stat-plays>1</span>
					</div>
					<div class="zo-game-page__stat">
						<span class="zo-game-page__stat-label"><?php echo esc_html(function_exists('zo_get_interface_text') ? zo_get_interface_text('stat_last_played', $language) : 'Last played'); ?></span>
						<span class="zo-game-page__stat-value" data-zo-stat-last><?php echo esc_html(date_i18n(get_option('date_format'))); ?></span>
					</div>
					<div class="zo-game-page__stat">
						<span class="zo-game-page__stat-label"><?php echo esc_html(function_exists('zo_get_interface_text') ? zo_get_interface_text('stat_favorite', $language) : 'Favorite'); ?></span>
						<span class="zo-game-page__stat-value" data-zo-stat-favorite><?php echo esc_html(function_exists('zo_get_interface_text') ? zo_get_interface_text('stat_no', $language) : 'No'); ?></span>
					</div>
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
				<a class="zo-game-page__back" href="<?php echo esc_url($games_url); ?>"><?php echo esc_html(function_exists('zo_get_interface_text') ? zo_get_interface_text('back_to_games', $language) : 'Back to games'); ?></a>
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
			var previous = null;
			items = items.filter(function(item) {
				if (item && item.slug === game.slug) {
					previous = item;
					return false;
				}
				return item;
			});
			game.plays = Number(previous && previous.plays || 0) + 1;
			game.lastPlayed = new Date().toISOString();
			items.unshift(game);
			localStorage.setItem(key, JSON.stringify(items.slice(0, 20)));

			var stats = document.querySelector('[data-zo-game-stats]');
			if (stats) {
				var plays = stats.querySelector('[data-zo-stat-plays]');
				var last = stats.querySelector('[data-zo-stat-last]');
				var favorite = stats.querySelector('[data-zo-stat-favorite]');
				var favorites = JSON.parse(localStorage.getItem('zoFavoriteGames') || '[]');
				if (plays) {
					plays.textContent = String(game.plays);
				}
				if (last) {
					last.textContent = new Date(game.lastPlayed).toLocaleDateString();
				}
				if (favorite && Array.isArray(favorites)) {
					favorite.textContent = favorites.some(function(item) { return item && item.slug === game.slug; }) ? <?php echo wp_json_encode(function_exists('zo_get_interface_text') ? zo_get_interface_text('stat_yes', $language) : 'Yes'); ?> : <?php echo wp_json_encode(function_exists('zo_get_interface_text') ? zo_get_interface_text('stat_no', $language) : 'No'); ?>;
				}
			}
		} catch (error) {}
	})();
	</script>
	<script>
	(function(){
		var root = document.querySelector('[data-zo-game-progress]');
		if (!root) {
			return;
		}
		var slug = <?php echo wp_json_encode($slug); ?>;
		var owner = <?php echo wp_json_encode($game_owner); ?>;
		var active = { opened: true, favorite: false, streak: false };

		function read(key, fallback) {
			try {
				var value = JSON.parse(localStorage.getItem(key) || fallback);
				return value;
			} catch (error) {
				return JSON.parse(fallback);
			}
		}

		var favorites = read('zoFavoriteGames', '[]');
		if (Array.isArray(favorites)) {
			active.favorite = favorites.some(function(item) {
				return item && item.slug === slug;
			});
		}

		active.streak = owner === 'asker' || owner === 'arslan';

		var steps = Array.prototype.slice.call(root.querySelectorAll('[data-zo-progress-step]'));
		var activeCount = 0;
		steps.forEach(function(step) {
			var key = step.getAttribute('data-zo-progress-step');
			var isActive = !!active[key];
			step.classList.toggle('is-active', isActive);
			if (isActive) {
				activeCount++;
			}
		});

		var fill = root.querySelector('[data-zo-progress-fill]');
		if (fill && steps.length) {
			fill.style.width = Math.round((activeCount / steps.length) * 100) + '%';
		}
	})();
	</script>
	<?php if (in_array($game_owner, array('asker', 'arslan'), true)) : ?>
	<script>
	(function(){
		var key = <?php echo wp_json_encode($game_owner === 'arslan' ? 'zoArslanPlayStreak' : 'zoAskerPlayStreak'); ?>;
		var today = new Date();
		var dayKey = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-' + String(today.getDate()).padStart(2, '0');
		var lastTick = Date.now();

		function read() {
			try {
				var data = JSON.parse(localStorage.getItem(key) || '{}');
				if (!data || typeof data !== 'object') {
					data = {};
				}
				if (!data.days || typeof data.days !== 'object') {
					data.days = {};
				}
				return data;
			} catch (error) {
				return { days: {} };
			}
		}

		function write(data) {
			try {
				localStorage.setItem(key, JSON.stringify(data));
			} catch (error) {}
		}

		function addSeconds(seconds) {
			if (!seconds || seconds < 1) {
				return;
			}
			var data = read();
			data.days[dayKey] = Math.min(86400, Number(data.days[dayKey] || 0) + seconds);
			write(data);
		}

		function tick() {
			var now = Date.now();
			var seconds = Math.floor((now - lastTick) / 1000);
			lastTick = now;
			if (document.visibilityState === 'visible') {
				addSeconds(Math.min(seconds, 15));
			}
		}

		window.setInterval(tick, 10000);
		window.addEventListener('pagehide', tick);
		document.addEventListener('visibilitychange', function() {
			lastTick = Date.now();
		});
	})();
	</script>
	<?php endif; ?>
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
