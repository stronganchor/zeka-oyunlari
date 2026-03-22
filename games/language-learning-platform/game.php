<?php
if (!defined('ABSPATH')) { exit; }

if (!function_exists('zo_game_test_render')) {
	function zo_game_test_render() {
		ob_start();
		?>
		<div>TEST GAME WORKS</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug' => 'language-learning-platform',
	'name' => 'Test Game',
	'author' => 'Asker',
	'description' => 'test',
	'render_callback' => 'zo_game_test_render',
);