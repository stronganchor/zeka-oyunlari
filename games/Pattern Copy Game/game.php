<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 680px;
	margin: 0 auto;
	text-align: center;
	font-family: Arial, sans-serif;
}

.zo-game-root--pattern-copy-game .zo-pcg-card {
	background: #ffffff;
	border: 3px solid #222;
	border-radius: 18px;
	padding: 20px;
	box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}

.zo-game-root--pattern-copy-game .zo-pcg-title {
	font-size: 28px;
	font-weight: 700;
	margin: 0 0 10px;
	color: #222;
}

.zo-game-root--pattern-copy-game .zo-pcg-subtitle {
	font-size: 16px;
	line-height: 1.5;
	margin: 0 0 16px;
	color: #444;
}

.zo-game-root--pattern-copy-game .zo-pcg-status {
	min-height: 28px;
	font-size: 18px;
	font-weight: 700;
	margin: 12px 0 16px;
	color: #0b5;
}

.zo-game-root--pattern-copy-game .zo-pcg-stats {
	display: flex;
	justify-content: center;
	gap: 12px;
	flex-wrap: wrap;
	margin-bottom: 16px;
}

.zo-game-root--pattern-copy-game .zo-pcg-stat {
	background: #f4f4f4;
	border: 2px solid #ddd;
	border-radius: 999px;
	padding: 8px 14px;
	font-size: 14px;
	font-weight: 700;
	color: #333;
}

.zo-game-root--pattern-copy-game .zo-pcg-section-title {
	font-size: 16px;
	font-weight: 700;
	margin: 10px 0 10px;
	color: #222;
}

.zo-game-root--pattern-copy-game .zo-pcg-grid-wrap {
	display: grid;
	grid-template-columns: repeat(2, minmax(0, 1fr));
	gap: 18px;
	margin-bottom: 16px;
}

.zo-game-root--pattern-copy-game .zo-pcg-grid-box {
	background: #fafafa;
	border: 2px solid #ddd;
	border-radius: 16px;
	padding: 14px;
}

.zo-game-root--pattern-copy-game .zo-pcg-grid {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 8px;
	max-width: 260px;
	margin: 0 auto;
}

.zo-game-root--pattern-copy-game .zo-pcg-cell {
	appearance: none;
	border: 2px solid #222;
	border-radius: 10px;
	background: #fff;
	aspect-ratio: 1 / 1;
	cursor: pointer;
	transition: transform 0.12s ease, box-shadow 0.12s ease, background 0.12s ease;
	padding: 0;
}

.zo-game-root--pattern-copy-game .zo-pcg-cell:hover,
.zo-game-root--pattern-copy-game .zo-pcg-cell:focus {
	transform: scale(1.04);
	outline: none;
	box-shadow: 0 0 0 4px rgba(0, 0, 0, 0.08);
}

.zo-game-root--pattern-copy-game .zo-pcg-cell.is-on {
	background: #4caf50;
}

.zo-game-root--pattern-copy-game .zo-pcg-cell.is-locked {
	cursor: default;
}

.zo-game-root--pattern-copy-game .zo-pcg-cell.is-wrong {
	background: #f44336;
}

.zo-game-root--pattern-copy-game .zo-pcg-cell.is-correct {
	background: #4caf50;
}

.zo-game-root--pattern-copy-game .zo-pcg-actions {
	display: flex;
	justify-content: center;
	gap: 10px;
	flex-wrap: wrap;
	margin-top: 8px;
}

.zo-game-root--pattern-copy-game .zo-pcg-btn {
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

.zo-game-root--pattern-copy-game .zo-pcg-btn:hover,
.zo-game-root--pattern-copy-game .zo-pcg-btn:focus {
	background: #000;
	outline: none;
}

.zo-game-root--pattern-copy-game .zo-pcg-help {
	margin-top: 14px;
	font-size: 14px;
	color: #555;
	line-height: 1.5;
}

@media (max-width: 640px) {
	.zo-game-root--pattern-copy-game .zo-pcg-grid-wrap {
		grid-template-columns: 1fr;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--pattern-copy-game');

	games.forEach(function (game) {
		const targetGrid = game.querySelector('.zo-pcg-grid--target');
		const playerGrid = game.querySelector('.zo-pcg-grid--player');
		const statusEl = game.querySelector('.zo-pcg-status');
		const roundEl = game.querySelector('.zo-pcg-round-value');
		const scoreEl = game.querySelector('.zo-pcg-score-value');
		const livesEl = game.querySelector('.zo-pcg-lives-value');
		const checkBtn = game.querySelector('.zo-pcg-check');
		const clearBtn = game.querySelector('.zo-pcg-clear');
		const restartBtn = game.querySelector('.zo-pcg-restart');

		let round = 1;
		let score = 0;
		let lives = 3;
		let targetPattern = [];
		let playerPattern = [];
		let targetButtons = [];
		let playerButtons = [];
		let locked = false;

		function randomPattern() {
			const pattern = new Array(16).fill(false);
			const onCount = 4 + Math.floor(Math.random() * 4);
			let placed = 0;

			while (placed < onCount) {
				const index = Math.floor(Math.random() * 16);
				if (!pattern[index]) {
					pattern[index] = true;
					placed += 1;
				}
			}

			return pattern;
		}

		function renderGrid(gridEl, buttonsStore, isPlayer) {
			gridEl.innerHTML = '';
			buttonsStore.length = 0;

			for (let i = 0; i < 16; i++) {
				const btn = document.createElement('button');
				btn.type = 'button';
				btn.className = 'zo-pcg-cell' + (isPlayer ? '' : ' is-locked');
				btn.setAttribute('aria-label', (isPlayer ? 'Your grid cell ' : 'Pattern cell ') + (i + 1));

				if (isPlayer) {
					btn.addEventListener('click', function () {
						if (locked) {
							return;
						}
						playerPattern[i] = !playerPattern[i];
						updatePlayerGrid();
					});
				}

				gridEl.appendChild(btn);
				buttonsStore.push(btn);
			}
		}

		function updateTargetGrid() {
			targetButtons.forEach(function (btn, index) {
				btn.classList.remove('is-on');
				if (targetPattern[index]) {
					btn.classList.add('is-on');
				}
			});
		}

		function updatePlayerGrid() {
			playerButtons.forEach(function (btn, index) {
				btn.classList.remove('is-on', 'is-wrong', 'is-correct');
				if (playerPattern[index]) {
					btn.classList.add('is-on');
				}
			});
		}

		function updateStats() {
			roundEl.textContent = String(round);
			scoreEl.textContent = String(score);
			livesEl.textContent = String(lives);
		}

		function setStatus(text) {
			statusEl.textContent = text;
		}

		function startRound() {
			locked = false;
			targetPattern = randomPattern();
			playerPattern = new Array(16).fill(false);
			updateTargetGrid();
			updatePlayerGrid();
			updateStats();
			setStatus('Copy the pattern on the right grid.');
		}

		function markResult(correct) {
			playerButtons.forEach(function (btn, index) {
				btn.classList.remove('is-on');
				if (playerPattern[index] === targetPattern[index]) {
					if (playerPattern[index]) {
						btn.classList.add('is-correct');
					}
				} else {
					btn.classList.add('is-wrong');
				}
			});

			if (correct) {
				score += 1;
				updateStats();
				setStatus('Correct. Next round...');
				locked = true;

				if (score >= 6) {
					setStatus('You won Pattern Copy Game.');
					return;
				}

				window.setTimeout(function () {
					round += 1;
					startRound();
				}, 900);
			} else {
				lives -= 1;
				updateStats();
				locked = true;

				if (lives <= 0) {
					setStatus('Game over.');
					return;
				}

				setStatus('Not quite right. A new pattern is coming...');
				window.setTimeout(function () {
					round += 1;
					startRound();
				}, 1000);
			}
		}

		checkBtn.addEventListener('click', function () {
			if (locked) {
				return;
			}

			let correct = true;
			for (let i = 0; i < 16; i++) {
				if (playerPattern[i] !== targetPattern[i]) {
					correct = false;
					break;
				}
			}

			markResult(correct);
		});

		clearBtn.addEventListener('click', function () {
			if (locked) {
				return;
			}
			playerPattern = new Array(16).fill(false);
			updatePlayerGrid();
			setStatus('Grid cleared. Copy the pattern again.');
		});

		restartBtn.addEventListener('click', function () {
			round = 1;
			score = 0;
			lives = 3;
			startRound();
		});

		renderGrid(targetGrid, targetButtons, false);
		renderGrid(playerGrid, playerButtons, true);
		startRound();
	});
});
JS;

if (!function_exists('zo_game_pattern_copy_game_render')) {
	function zo_game_pattern_copy_game_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-pattern-copy-game-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--pattern-copy-game" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-pcg-card">
				<h2 class="zo-pcg-title">Pattern Copy Game</h2>
				<p class="zo-pcg-subtitle">Look at the pattern on the left and copy it on the right. Get 6 correct before you lose all 3 lives.</p>

				<div class="zo-pcg-stats">
					<div class="zo-pcg-stat">Round: <span class="zo-pcg-round-value">1</span></div>
					<div class="zo-pcg-stat">Score: <span class="zo-pcg-score-value">0</span></div>
					<div class="zo-pcg-stat">Lives: <span class="zo-pcg-lives-value">3</span></div>
				</div>

				<div class="zo-pcg-status" aria-live="polite">Copy the pattern on the right grid.</div>

				<div class="zo-pcg-grid-wrap">
					<div class="zo-pcg-grid-box">
						<div class="zo-pcg-section-title">Pattern</div>
						<div class="zo-pcg-grid zo-pcg-grid--target"></div>
					</div>
					<div class="zo-pcg-grid-box">
						<div class="zo-pcg-section-title">Your Copy</div>
						<div class="zo-pcg-grid zo-pcg-grid--player"></div>
					</div>
				</div>

				<div class="zo-pcg-actions">
					<button type="button" class="zo-pcg-btn zo-pcg-check">Check</button>
					<button type="button" class="zo-pcg-btn zo-pcg-clear">Clear</button>
					<button type="button" class="zo-pcg-btn zo-pcg-restart">Restart</button>
				</div>

				<div class="zo-pcg-help">Tap squares in your grid to turn them on or off. Then press Check.</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'pattern-copy-game',
	'name'            => 'Pattern Copy Game',
	'author'          => 'Arslan',
	'description'     => 'A simple visual memory game where players copy a pattern from one grid to another.',
	'render_callback' => 'zo_game_pattern_copy_game_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);