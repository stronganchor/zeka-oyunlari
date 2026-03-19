<?php

if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('zo_game_hizli_tikla_render')) {
	function zo_game_hizli_tikla_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-hizli-tikla-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--hizli-tikla" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-ht">
				<h2 class="zo-ht__title">Hızlı Tıkla</h2>
				<p class="zo-ht__intro">10 saniyede olabildiğince çok tıkla.</p>

				<div class="zo-ht__stats">
					<div class="zo-ht__stat">
						<span class="zo-ht__label">Skor</span>
						<strong class="zo-ht__score">0</strong>
					</div>

					<div class="zo-ht__stat">
						<span class="zo-ht__label">Süre</span>
						<strong class="zo-ht__time">10</strong>
					</div>
				</div>

				<button type="button" class="zo-ht__button">Başla</button>
				<p class="zo-ht__message" aria-live="polite">Butona basınca oyun başlar.</p>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'hizli-tikla',
	'name'            => 'Hızlı Tıkla',
	'author'          => 'Asker',
	'description'     => '10 saniyelik basit bir tıklama oyunu.',
	'render_callback' => 'zo_game_hizli_tikla_render',
);