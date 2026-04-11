<?php

if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('zo_game_echo_cartographer_render')) {
	function zo_game_echo_cartographer_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-echo-cartographer-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--echo-cartographer" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-ec" data-pulse-radius="4" data-reveal-turns="2">
				<div class="zo-ec__panel">
					<div>
						<p class="zo-ec__eyebrow">Echo Cartographer</p>
						<h2 class="zo-ec__title">Map the dark. Stay quieter than the things below.</h2>
					</div>
					<p class="zo-ec__intro">You are a lost survey drone buried in a dead megacity. Send sonar pulses to reveal walls, traps, enemies, and hidden passages, then reach the exit before the hunters lock onto your sound.</p>
				</div>

				<div class="zo-ec__stats" aria-label="Game stats">
					<div class="zo-ec__stat">
						<span class="zo-ec__stat-label">Sector</span>
						<strong class="zo-ec__level">1</strong>
					</div>
					<div class="zo-ec__stat">
						<span class="zo-ec__stat-label">Pulses</span>
						<strong class="zo-ec__pulses">0</strong>
					</div>
					<div class="zo-ec__stat">
						<span class="zo-ec__stat-label">Noise</span>
						<strong class="zo-ec__noise">Quiet</strong>
					</div>
					<div class="zo-ec__stat">
						<span class="zo-ec__stat-label">Scans left</span>
						<strong class="zo-ec__reveal">0</strong>
					</div>
				</div>

				<div class="zo-ec__layout">
					<div class="zo-ec__board-wrap">
						<div class="zo-ec__board" role="grid" aria-label="Echo Cartographer map"></div>
					</div>

					<div class="zo-ec__sidebar">
						<div class="zo-ec__legend">
							<p class="zo-ec__legend-title">Legend</p>
							<div class="zo-ec__legend-items">
								<span><i class="zo-ec__swatch is-drone"></i>You</span>
								<span><i class="zo-ec__swatch is-exit"></i>Exit</span>
								<span><i class="zo-ec__swatch is-trap"></i>Trap</span>
								<span><i class="zo-ec__swatch is-enemy"></i>Hunter</span>
								<span><i class="zo-ec__swatch is-hidden"></i>Hidden path</span>
							</div>
						</div>

						<div class="zo-ec__controls">
							<div class="zo-ec__move-pad" aria-label="Movement controls">
								<button type="button" class="zo-ec__move" data-move="up">Up</button>
								<div class="zo-ec__move-row">
									<button type="button" class="zo-ec__move" data-move="left">Left</button>
									<button type="button" class="zo-ec__move" data-move="down">Down</button>
									<button type="button" class="zo-ec__move" data-move="right">Right</button>
								</div>
							</div>

							<div class="zo-ec__actions">
								<button type="button" class="zo-ec__pulse">Send Sonar Pulse</button>
								<button type="button" class="zo-ec__restart">Restart Sector</button>
							</div>
						</div>

						<div class="zo-ec__notes">
							<p class="zo-ec__notes-title">How to survive</p>
							<ul class="zo-ec__notes-list">
								<li>Use arrow keys or the buttons to move one tile at a time.</li>
								<li>Sonar reveals nearby tiles for a short time and uncovers hidden corridors.</li>
								<li>Every pulse alerts the hunters and makes them surge toward the sound.</li>
								<li>Avoid traps, avoid hunters, and reach all 3 exits to finish the run.</li>
							</ul>
						</div>

						<p class="zo-ec__message" aria-live="polite">The city is silent. Move carefully or send a pulse.</p>
					</div>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'echo-cartographer',
	'name'            => 'Echo Cartographer',
	'author'          => 'Asker',
	'description'     => 'A sonar-stealth maze where each scan reveals the ruins but attracts sound-hunting enemies.',
	'render_callback' => 'zo_game_echo_cartographer_render',
);
