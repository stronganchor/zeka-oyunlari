<?php
if (!defined('ABSPATH')) {
	exit;
}

$language = function_exists('zo_get_current_language') ? zo_get_current_language() : 'tr';
$site_name = get_bloginfo('name');
$page_titles = array(
	'tr' => 'Oyunlar',
	'en' => 'Games',
	'de' => 'Spiele',
	'fr' => 'Jeux',
	'es-mx' => 'Juegos',
	'es-es' => 'Juegos',
);
$page_title = isset($page_titles[$language]) ? $page_titles[$language] : 'Oyunlar';
$page_intro = function_exists('zo_get_interface_text') ? zo_get_interface_text('intro', $language) : '';

if (!is_string($page_title) || $page_title === '') {
	$page_title = 'Oyunlar';
}

if (!is_string($page_intro)) {
	$page_intro = '';
}

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?php echo esc_attr($page_intro); ?>">
	<title><?php echo esc_html($page_title . ($site_name ? ' | ' . $site_name : '')); ?></title>
	<?php wp_head(); ?>
	<style>
		body {
			margin: 0;
			background: #fff;
		}

		.zo-games-archive {
			box-sizing: border-box;
			width: min(100%, 1160px);
			margin: 0 auto;
			padding: 18px 16px 42px;
		}

		.zo-games-archive .zo-games-grid-wrap {
			margin: 0 auto;
		}

		@media (max-width: 700px) {
			.zo-games-archive {
				padding: 12px 10px 32px;
			}
		}
	</style>
</head>
<body <?php body_class('zo-games-archive-page'); ?>>
<?php wp_body_open(); ?>
<main class="zo-games-archive">
	<?php
	if (function_exists('zo_games_grid_shortcode')) {
		echo zo_games_grid_shortcode(array('author' => 'asker,arslan'));
	}
	?>
</main>
<?php wp_footer(); ?>
</body>
</html>
