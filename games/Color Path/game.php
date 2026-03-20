<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 620px;
	margin: 0 auto;
	text-align: center;
	font-family: Arial, sans-serif;
}

.zo-game-root--color-path .zo-cp-card {
	background: #ffffff;
	border: 3px solid #222;
	border-radius: 18px;
	padding: 20px;
	box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}

.zo-game-root--color-path .zo-cp-title {
	font-size: 28px;
	font-weight: 700;
	margin: 0 0 10px;
	color: #222;
}

.zo-game-root--color-path .zo-cp-subtitle {
	font-size: 16px;
	line-height: 1.5;
	margin: 0 0 16px;
	color: #444;
}

.zo-game-root--color-path .zo-cp-status {
	min-height: 28px;
	font-size: 18px;
	font-weight: 700;
	margin: 12px 0 16px;
	color: #0b5;
}

.zo-game-root--color-path .zo-cp-stats {
	display: flex;
	justify-content: center;
	gap: 12px;
	flex-wrap: wrap;
	margin-bottom: 16px;
}

.zo-game-root--color-path .zo-cp-stat {
	background: #f4f4f4;
	border: 2px solid #ddd;
	border-radius: 999px;
	padding: 8px 14px;
	font-size: 14px;
	font-weight: 700;
	color: #333;
}

.zo-game-root--color-path .zo-cp-target-wrap {
	margin-bottom: 16px;
}

.zo-game-root--color-path .zo-cp-target-label {
	font-size: 14px;
	font-weight: 700;
	color: #555;
	margin-bottom: 8px;
}

.zo-game-root--color-path .zo-cp-target {
	width: 120px;
	height: 48px;
	margin: 0 auto;
	border: 3px solid #222;
	border-radius: 999px;
}

.zo-game-root--color-path .zo-cp-grid {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 10px;
	margin-bottom: 16px;
}

.zo-game-root--color-path .zo-cp-tile {
	appearance: none;
	border: 3px solid #222;
	border-radius: 16px;
	min-height: 88px;
	cursor: pointer;
	transition: transform 0.12s ease, box-shadow 0.12s ease, opacity 0.12s ease;
}

.zo-game-root--color-path .zo-cp-tile:hover,
.zo-game-root--color-path .zo-cp-tile:focus {
	transform: translateY(-2px);
	outline: none;
	box-shadow: 0 0 0 4px rgba(0,0,0,0.08);
}

.zo-game-root--color-path .zo-cp-tile.is-correct {
	box-shadow: 0 0 0 5px rgba(76, 175, 80, 0.35);
}

.zo-game-root--color-path .zo-cp-tile.is-wrong {
	box-shadow: 0 0 0 5px rgba(244, 67, 54, 0.35);
	opacity: 0.7;
}

.zo-game-root--color-path .zo-cp-actions {
	display: flex;
	justify-content: center;
	gap: 10px;
	flex-wrap: wrap;
}

.zo-game-root--color-path .zo-cp-btn {
	appearance: none;
	border: 2px solid #222;
	background: #222;
	color: #fff;
	border-radius: 999px;
	padding: 10px 16px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
}

.zo-game-root--color-path .zo-cp-btn:hover,
.zo-game-root--color-path .zo-cp-btn:focus {
	background: #000;
	outline: none;
}

.zo-game-root--color-path .zo-cp-help {
	margin-top: 14px;
	font-size: 14px;
	color: #555;
	line-height: 1.5;
}

@media (max-width: 520px) {
	.zo-game-root--color-path .zo-cp-grid {
		grid-template-columns: repeat(2, 1fr);
	}

	.zo-game-root--color-path .zo-cp-tile {
		min-height: 82px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--color-path');

	games.forEach(function (game) {
		const grid = game.querySelector('.zo-cp-grid');
		const statusEl = game.querySelector('.zo-cp-status');
		const scoreEl = game.querySelector('.zo-cp-score-value');
		const roundEl = game.querySelector('.zo-cp-round-value');
		const livesEl = game.querySelector('.zo-cp-lives-value');
		const targetEl = game.querySelector('.zo-cp-target');
		const restartBtn = game.querySelector('.zo-cp-restart');

		let score = 0;
		let round = 1;
		let lives = 3;
		let targetColor = '';
		let correctIndex = 0;
		let locked = false;
		let tiles = [];

		function randomInt(max) {
			return Math.floor(Math.random() * max);
		}

		function makeColor() {
			const r = 60 + randomInt(170);
			const g = 60 + randomInt(170);
			const b = 60 + randomInt(170);
			return 'rgb(' + r + ', ' + g + ', ' + b + ')';
		}

		function updateStats() {
			scoreEl.textContent = String(score);
			roundEl.textContent = String(round);
			livesEl.textContent = String(lives);
		}

		function setStatus(text) {
			statusEl.textContent = text;
		}

		function buildRound() {
			locked = false;
			grid.innerHTML = '';
			tiles = [];
			targetColor = makeColor();
			correctIndex = randomInt(8);
			targetEl.style.background = targetColor;

			for (let i = 0; i < 8; i++) {
				const tile = document.createElement('button');
				tile.type = 'button';
				tile.className = 'zo-cp-tile';

				let tileColor;
				if (i === correctIndex) {
					tileColor = targetColor;
				} else {
					tileColor = makeColor();
					while (tileColor === targetColor) {
						tileColor = makeColor();
					}
				}

				tile.style.background = tileColor;
				tile.setAttribute('aria-label', 'Color tile ' + (i + 1));

				tile.addEventListener('click', function () {
					if (locked) {
						return;
					}

					if (i === correctIndex) {
						tile.classList.add('is-correct');
						score += 1;
						updateStats();
						locked = true;

						if (score >= 8) {
							setStatus('You won Color Path.');
							return;
						}

						setStatus('Correct. Next round...');
						window.setTimeout(function () {
							round += 1;
							updateStats();
							buildRound();
							setStatus('Match the target color.');
						}, 700);
					} else {
						tile.classList.add('is-wrong');
						tile.disabled = true;
						lives -= 1;
						updateStats();

						if (lives <= 0) {
							locked = true;
							tiles[correctIndex].classList.add('is-correct');
							setStatus('Game over.');
						} else {
							setStatus('Wrong color. Try again.');
						}
					}
				});

				grid.appendChild(tile);
				tiles.push(tile);
			}
		}

		function resetGame() {
			score = 0;
			round = 1;
			lives = 3;
			updateStats();
			buildRound();
			setStatus('Match the target color.');
		}

		restartBtn.addEventListener('click', function () {
			resetGame();
		});

		resetGame();
	});
});
JS;

if (!function_exists('zo_game_color_path_render')) {
	function zo_game_color_path_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-color-path-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--color-path" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-cp-card">
				<h2 class="zo-cp-title">Color Path</h2>
				<p class="zo-cp-subtitle">Find the tile that matches the target color. Win by getting 8 correct before losing all 3 lives.</p>

				<div class="zo-cp-stats">
					<div class="zo-cp-stat">Score: <span class="zo-cp-score-value">0</span></div>
					<div class="zo-cp-stat">Round: <span class="zo-cp-round-value">1</span></div>
					<div class="zo-cp-stat">Lives: <span class="zo-cp-lives-value">3</span></div>
				</div>

				<div class="zo-cp-status" aria-live="polite">Match the target color.</div>

				<div class="zo-cp-target-wrap">
					<div class="zo-cp-target-label">Target Color</div>
					<div class="zo-cp-target"></div>
				</div>

				<div class="zo-cp-grid"></div>

				<div class="zo-cp-actions">
					<button type="button" class="zo-cp-btn zo-cp-restart">Restart</button>
				</div>

				<div class="zo-cp-help">Original concept and code. No borrowed characters, brands, music, or art. You can release it as CC0 if you want.</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'color-path',
	'name'            => 'Color Path',
	'author'          => 'Arslan',
	'description'     => 'An original color matching game with no third-party characters or copyrighted story elements.',
	'render_callback' => 'zo_game_color_path_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);