<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 560px;
	margin: 0 auto;
	text-align: center;
	font-family: Arial, sans-serif;
}

.zo-game-root--odd-one-out .zo-ooo-card {
	background: #ffffff;
	border: 3px solid #222;
	border-radius: 18px;
	padding: 20px;
	box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}

.zo-game-root--odd-one-out .zo-ooo-title {
	font-size: 28px;
	font-weight: 700;
	margin-bottom: 10px;
}

.zo-game-root--odd-one-out .zo-ooo-subtitle {
	font-size: 15px;
	color: #555;
	margin-bottom: 16px;
}

.zo-game-root--odd-one-out .zo-ooo-status {
	min-height: 24px;
	font-weight: 700;
	margin-bottom: 12px;
	color: #0b5;
}

.zo-game-root--odd-one-out .zo-ooo-stats {
	display: flex;
	justify-content: center;
	gap: 10px;
	margin-bottom: 14px;
	flex-wrap: wrap;
}

.zo-game-root--odd-one-out .zo-ooo-stat {
	background: #f4f4f4;
	border: 2px solid #ddd;
	border-radius: 999px;
	padding: 6px 12px;
	font-size: 13px;
	font-weight: 700;
}

.zo-game-root--odd-one-out .zo-ooo-grid {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 10px;
	margin-bottom: 16px;
}

.zo-game-root--odd-one-out .zo-ooo-tile {
	aspect-ratio: 1 / 1;
	border-radius: 14px;
	border: 3px solid #222;
	cursor: pointer;
	transition: transform 0.12s ease, box-shadow 0.12s ease;
}

.zo-game-root--odd-one-out .zo-ooo-tile:hover {
	transform: scale(1.05);
	box-shadow: 0 0 0 4px rgba(0,0,0,0.08);
}

.zo-game-root--odd-one-out .zo-ooo-tile.correct {
	box-shadow: 0 0 0 6px rgba(76, 175, 80, 0.4);
}

.zo-game-root--odd-one-out .zo-ooo-tile.wrong {
	box-shadow: 0 0 0 6px rgba(244, 67, 54, 0.4);
}

.zo-game-root--odd-one-out .zo-ooo-actions {
	display: flex;
	justify-content: center;
	gap: 10px;
}

.zo-game-root--odd-one-out .zo-ooo-btn {
	border: 2px solid #222;
	background: #222;
	color: #fff;
	border-radius: 999px;
	padding: 8px 14px;
	font-weight: 700;
	cursor: pointer;
}

.zo-game-root--odd-one-out .zo-ooo-btn:hover {
	background: #000;
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--odd-one-out');

	games.forEach(function (game) {
		const grid = game.querySelector('.zo-ooo-grid');
		const statusEl = game.querySelector('.zo-ooo-status');
		const scoreEl = game.querySelector('.zo-ooo-score');
		const roundEl = game.querySelector('.zo-ooo-round');
		const restartBtn = game.querySelector('.zo-ooo-restart');

		let score = 0;
		let round = 1;
		let correctIndex = 0;
		let tiles = [];

		function randomColor(base) {
			const variance = 25;
			const r = base.r + Math.floor(Math.random() * variance);
			const g = base.g + Math.floor(Math.random() * variance);
			const b = base.b + Math.floor(Math.random() * variance);
			return 'rgb(' + r + ',' + g + ',' + b + ')';
		}

		function newRound() {
			grid.innerHTML = '';
			tiles = [];

			const base = {
				r: 100 + Math.floor(Math.random() * 100),
				g: 100 + Math.floor(Math.random() * 100),
				b: 100 + Math.floor(Math.random() * 100)
			};

			correctIndex = Math.floor(Math.random() * 16);

			for (let i = 0; i < 16; i++) {
				const tile = document.createElement('div');
				tile.className = 'zo-ooo-tile';

				if (i === correctIndex) {
					tile.style.background = 'rgb(' + (base.r + 60) + ',' + (base.g + 60) + ',' + (base.b + 60) + ')';
				} else {
					tile.style.background = randomColor(base);
				}

				tile.addEventListener('click', function () {
					if (i === correctIndex) {
						tile.classList.add('correct');
						score++;
						statusEl.textContent = 'Correct!';
					} else {
						tile.classList.add('wrong');
						statusEl.textContent = 'Wrong!';
					}

					scoreEl.textContent = score;

					setTimeout(function () {
						round++;
						roundEl.textContent = round;
						newRound();
					}, 600);
				});

				grid.appendChild(tile);
				tiles.push(tile);
			}

			statusEl.textContent = 'Find the different color';
		}

		restartBtn.addEventListener('click', function () {
			score = 0;
			round = 1;
			scoreEl.textContent = score;
			roundEl.textContent = round;
			newRound();
		});

		newRound();
	});
});
JS;

if (!function_exists('zo_game_odd_one_out_render')) {
	function zo_game_odd_one_out_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-odd-one-out-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--odd-one-out" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-ooo-card">
				<div class="zo-ooo-title">Odd One Out</div>
				<div class="zo-ooo-subtitle">Find the slightly different color</div>

				<div class="zo-ooo-stats">
					<div class="zo-ooo-stat">Score: <span class="zo-ooo-score">0</span></div>
					<div class="zo-ooo-stat">Round: <span class="zo-ooo-round">1</span></div>
				</div>

				<div class="zo-ooo-status">Find the different color</div>
				<div class="zo-ooo-grid"></div>

				<div class="zo-ooo-actions">
					<button class="zo-ooo-btn zo-ooo-restart">Restart</button>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'odd-one-out',
	'name'            => 'Odd One Out',
	'author'          => 'Arslan',
	'description'     => 'Find the tile that is slightly different.',
	'render_callback' => 'zo_game_odd_one_out_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);