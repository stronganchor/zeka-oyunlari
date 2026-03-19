<?php

if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('zo_game_dama_ai_render')) {
	function zo_game_dama_ai_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-dama-ai-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--dama-ai" id="<?php echo esc_attr($instance_id); ?>" data-game="dama-ai">
			<div class="zo-dama-ai">
				<div class="zo-dama-ai__header">
					<h3 class="zo-dama-ai__title">Dama vs AI</h3>
					<p class="zo-dama-ai__instructions">
						You are White. Tap one of your pieces, then tap a highlighted square to move.
						Captures are required. Reach the far side to become a king. Beat the black AI.
					</p>
				</div>

				<div class="zo-dama-ai__topbar">
					<div class="zo-dama-ai__status-wrap">
						<div class="zo-dama-ai__turn" data-role="turn">Turn: White</div>
						<div class="zo-dama-ai__status" data-role="status">Select a white piece to begin.</div>
					</div>
					<button type="button" class="zo-dama-ai__restart" data-action="restart">Restart Game</button>
				</div>

				<div class="zo-dama-ai__board-wrap">
					<div class="zo-dama-ai__board" data-role="board" aria-label="Dama board"></div>
				</div>

				<div class="zo-dama-ai__legend">
					<span><span class="zo-dama-ai__legend-piece zo-dama-ai__legend-piece--white"></span> You</span>
					<span><span class="zo-dama-ai__legend-piece zo-dama-ai__legend-piece--black"></span> AI</span>
					<span><span class="zo-dama-ai__legend-king">K</span> King</span>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'dama-ai',
	'name'            => 'Dama vs AI',
	'author'          => 'Asker',
	'description'     => 'A kid-friendly Dama board game where you play white against a simple AI.',
	'render_callback' => 'zo_game_dama_ai_render',
);