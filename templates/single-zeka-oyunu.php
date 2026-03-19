<?php
if (!defined('ABSPATH')) {
	exit;
}

$post_id = get_queried_object_id();
$slug    = function_exists('zo_resolve_game_slug_for_post') ? zo_resolve_game_slug_for_post($post_id) : '';
$module  = $slug !== '' && function_exists('zo_get_game_module') ? zo_get_game_module($slug) : null;

if (!$module || !is_array($module)) {
	status_header(404);
	nocache_headers();
	echo '<!doctype html><html><body><p>Oyun bulunamadi.</p></body></html>';
	return;
}

$back_url   = function_exists('zo_get_game_back_url') ? zo_get_game_back_url($post_id) : home_url('/');
$page_title = get_the_title($post_id);

if (!is_string($page_title) || $page_title === '') {
	$page_title = (string) $module['name'];
}

$site_name = get_bloginfo('name');
$style_url = function_exists('zo_get_game_style_url') ? zo_get_game_style_url($module) : '';
$script_url = function_exists('zo_get_game_script_url') ? zo_get_game_script_url($module) : '';
$inline_style = !empty($module['inline_style']) && is_string($module['inline_style']) ? $module['inline_style'] : '';
$inline_script = !empty($module['inline_script']) && is_string($module['inline_script']) ? $module['inline_script'] : '';
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
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
			padding: 0 20px 20px;
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

		@media (max-width: 640px) {
			.zo-game-page__header {
				padding: 14px 14px 8px;
			}

			.zo-game-page__main {
				padding: 0 14px 14px;
			}

			.zo-game-page__stage .zo-game-shell,
			.zo-game-page__stage .zo-game-root {
				min-height: calc(100vh - 84px);
			}
		}
	</style>
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
			<a class="zo-game-page__back" href="<?php echo esc_url($back_url); ?>">Geri Dön</a>
		</header>
		<main class="zo-game-page__main">
			<div class="zo-game-page__stage">
				<?php echo zo_render_game($slug, $post_id); ?>
			</div>
		</main>
	</div>
	<?php if ($script_url !== '') : ?>
	<script src="<?php echo esc_url($script_url); ?>"></script>
	<?php endif; ?>
	<?php if ($inline_script !== '') : ?>
	<script><?php echo $inline_script; ?></script>
	<?php endif; ?>
</body>
</html>
