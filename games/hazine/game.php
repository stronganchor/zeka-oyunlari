<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 500px;
	margin: 0 auto;
	text-align: center;
	font-family: Arial, sans-serif;
}

.zo-egypt-title {
	font-size: 22px;
	margin-bottom: 10px;
}

.zo-egypt-grid {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 10px;
	margin: 15px 0;
}

.zo-egypt-tile {
	background: #f4d03f;
	border-radius: 8px;
	padding: 20px;
	cursor: pointer;
	font-size: 18px;
	user-select: none;
}

.zo-egypt-tile.hidden {
	background: #d5d8dc;
}

.zo-egypt-info {
	margin-top: 10px;
	font-size: 16px;
}

.zo-egypt-btn {
	margin-top: 10px;
	padding: 8px 12px;
	border: none;
	background: #af7ac5;
	color: white;
	border-radius: 6px;
	cursor: pointer;
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--misir-hazine');

	games.forEach(function (game) {
		const tiles = game.querySelectorAll('.zo-egypt-tile');
		const info = game.querySelector('.zo-egypt-info');
		const resetBtn = game.querySelector('.zo-egypt-btn');

		let treasureIndex = Math.floor(Math.random() * tiles.length);
		let gameOver = false;

		function resetGame() {
			treasureIndex = Math.floor(Math.random() * tiles.length);
			gameOver = false;
			info.textContent = "Hazineyi bul!";
			tiles.forEach(t => {
				t.classList.remove('hidden');
				t.textContent = "?";
			});
		}

		tiles.forEach(function (tile, index) {
			tile.addEventListener('click', function () {
				if (gameOver) return;

				if (index === treasureIndex) {
					tile.textContent = "💎";
					info.textContent = "Kazandın! Hazineyi buldun!";
					gameOver = true;
				} else {
					tile.textContent = "💀";
					tile.classList.add('hidden');
					info.textContent = "Yanlış! Tekrar dene.";
				}
			});
		});

		resetBtn.addEventListener('click', resetGame);

		resetGame();
	});
});
JS;

if (!function_exists('zo_game_misir_hazine_render')) {
	function zo_game_misir_hazine_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-misir-hazine-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--misir-hazine" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-egypt-title">Mısır Hazine Oyunu 🏺</div>
			<div>Bir piramitte gizli hazineyi bul!</div>

			<div class="zo-egypt-grid">
				<div class="zo-egypt-tile">?</div>
				<div class="zo-egypt-tile">?</div>
				<div class="zo-egypt-tile">?</div>
				<div class="zo-egypt-tile">?</div>
				<div class="zo-egypt-tile">?</div>
				<div class="zo-egypt-tile">?</div>
				<div class="zo-egypt-tile">?</div>
				<div class="zo-egypt-tile">?</div>
				<div class="zo-egypt-tile">?</div>
			</div>

			<div class="zo-egypt-info">Hazineyi bul!</div>
			<button class="zo-egypt-btn">Yeniden Başlat</button>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'misir-hazine',
	'name'            => 'Mısır Hazine Oyunu',
	'author'          => 'Asker',
	'description'     => 'Piramitte gizli hazineyi bulma oyunu',
	'render_callback' => 'zo_game_misir_hazine_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);