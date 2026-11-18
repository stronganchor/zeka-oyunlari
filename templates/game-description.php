<?php
/** Standalone public guide; no gameplay or saved-progress code is executed. */
if (!defined('ABSPATH')) { exit; }
$language = zo_get_current_language();
$module = zo_get_requested_description_module();
if (!$module) {
	status_header(404);
	nocache_headers();
	echo '<!doctype html><html lang="' . esc_attr($language) . '"><head><meta charset="utf-8"><meta name="robots" content="noindex"><title>' . esc_html(zo_game_guide_text('missing', $language)) . '</title></head><body><h1>' . esc_html(zo_game_guide_text('missing', $language)) . '</h1><a href="' . esc_url(zo_get_owner_games_url('asker', $language)) . '">' . esc_html(zo_game_guide_text('back', $language)) . '</a></body></html>';
	return;
}
status_header(200);
$guide = zo_get_game_guide($module, $language);
$metadata = zo_get_localized_game_display_metadata($module, $language);
$name = $metadata['name'];
$title = sprintf(zo_game_guide_text('title', $language), $name);
$available = !isset($module['available']) || $module['available'] !== false;
$description = $available ? $guide['steps'][0] : zo_game_guide_text('unavailable', $language);
$intro = $available ? ($metadata['description'] ?? '') : $description;
// This prototype currently uses ordered symbols rather than time-travel logic.
if ($module['slug'] === 'time-traveler-puzzle') { $intro = $description; }
$canonical = zo_get_game_description_url($module['slug'], $language);
$posts = zo_get_game_posts_by_slug();
$post = $posts[$module['slug']] ?? null;
$play_url = $post instanceof WP_Post ? get_permalink($post) : add_query_arg('zo_game_module', $module['slug'], home_url('/'));
$play_url = add_query_arg('zo_lang', $language, $play_url);
?>
<!doctype html>
<html lang="<?php echo esc_attr($language); ?>">
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo esc_html($title . ' | ' . get_bloginfo('name')); ?></title>
	<meta name="description" content="<?php echo esc_attr($name . '. ' . $description); ?>">
	<?php if (!$available) : ?><meta name="robots" content="noindex,follow"><?php endif; ?>
	<link rel="canonical" href="<?php echo esc_url($canonical); ?>">
	<?php foreach (zo_get_game_language_availability($module['slug']) as $code) : ?>
	<?php if (zo_get_game_guide($module, $code)) : ?>
	<link rel="alternate" hreflang="<?php echo esc_attr($code); ?>" href="<?php echo esc_url(zo_get_game_description_url($module['slug'], $code)); ?>">
	<?php endif; ?>
	<?php endforeach; ?>
	<link rel="stylesheet" href="<?php echo esc_url(ZO_PLUGIN_URL . 'assets/game-guides.css?ver=' . ZO_PLUGIN_VERSION); ?>">
	<?php if (function_exists('wp_site_icon')) { wp_site_icon(); } ?>
</head>
<body class="zo-description-body">
	<main class="zo-description-page">
		<nav class="zo-description-page__nav" aria-label="<?php echo esc_attr(zo_game_guide_text('languages', $language)); ?>">
			<a href="<?php echo esc_url(zo_get_owner_games_url('asker', $language)); ?>"><?php echo esc_html(zo_game_guide_text('back', $language)); ?></a>
			<?php foreach (zo_get_language_options() as $code => $label) : ?>
			<?php if (zo_get_game_guide($module, $code)) : ?>
			<a href="<?php echo esc_url(zo_get_game_description_url($module['slug'], $code)); ?>" lang="<?php echo esc_attr($code); ?>" hreflang="<?php echo esc_attr($code); ?>"<?php if ($code === $language) { echo ' aria-current="page"'; } ?>><?php echo esc_html($label); ?></a>
			<?php endif; ?>
			<?php endforeach; ?>
		</nav>
		<h1><?php echo esc_html($title); ?></h1>
		<p class="zo-description-page__intro"><?php echo esc_html($intro); ?></p>
		<?php if ($available) : ?>
		<a class="zo-description-page__play" href="<?php echo esc_url($play_url); ?>"><?php echo esc_html(zo_game_guide_text('play', $language)); ?></a>
		<?php endif; ?>
		<?php echo zo_render_game_guide($module, $language); ?>
	</main>
</body>
</html>
