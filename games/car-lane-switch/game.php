<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root--car-lane-switch {
	max-width: 500px;
	margin: 0 auto;
	text-align: center;
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--car-lane-switch');

	games.forEach(function (game) {
		// no-op
	});
});
JS;

if (!function_exists('zo_game_car_lane_switch_render')) {
	function zo_game_car_lane_switch_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-car-lane-switch-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--car-lane-switch" id="<?php echo esc_attr($instance_id); ?>">
			<p>Car Lane Switch</p>
			<p>by Asker</p>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'car-lane-switch',
	'name'            => 'Car Lane Switch',
	'author'          => 'Asker',
	'description'     => 'Test game.',
	'render_callback' => 'zo_game_car_lane_switch_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);