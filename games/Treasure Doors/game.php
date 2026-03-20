<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 580px;
	margin: 0 auto;
	text-align: center;
	font-family: Arial, sans-serif;
}

.zo-game-root--treasure-doors .zo-td-card {
	background: #ffffff;
	border: 3px solid #222;
	border-radius: 18px;
	padding: 20px;
	box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}

.zo-game-root--treasure-doors .zo-td-title {
	font-size: 28px;
	font-weight: 700;
	margin: 0 0 10px;
	color: #222;
}

.zo-game-root--treasure-doors .zo-td-subtitle {
	font-size: 16px;
	line-height: 1.5;
	margin: 0 0 16px;
	color: #444;
}

.zo-game-root--treasure-doors .zo-td-status {
	min-height: 28px;
	font-size: 18px;
	font-weight: 700;
	margin: 12px 0 16px;
	color: #0b5;
}

.zo-game-root--treasure-doors .zo-td-stats {
	display: flex;
	justify-content: center;
	gap: 12px;
	flex-wrap: wrap;
	margin-bottom: 16px;
}

.zo-game-root--treasure-doors .zo-td-stat {
	background: #f4f4f4;
	border: 2px solid #ddd;
	border-radius: 999px;
	padding: 8px 14px;
	font-size: 14px;
	font-weight: 700;
	color: #333;
}

.zo-game-root--treasure-doors .zo-td-board {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 10px;
	margin-bottom: 16px;
}

.zo-game-root--treasure-doors .zo-td-door {
	appearance: none;
	border: 3px solid #222;
	background: linear-gradient(180deg, #7c5cff 0%, #5130d1 100%);
	color: #fff;
	border-radius: 16px;
	min-height: 95px;
	font-size: 18px;
	font-weight: 700;
	cursor: pointer;
	padding: 10px;
	transition: transform 0.12s ease;
}

.zo-game-root--treasure-doors .zo-td-door:hover,
.zo-game-root--treasure-doors .zo-td-door:focus {
	transform: translateY(-2px);
	outline: none;
}

.zo-game-root--treasure-doors .zo-td-door.is-treasure {
	background: linear-gradient(180deg, #ffd95a 0%, #e2a500 100%);
	color: #222;
}

.zo-game-root--treasure-doors .zo-td-door.is-trap {
	background: linear-gradient(180deg, #ff8f8f 0%, #d73c3c 100%);
}

.zo-game-root--treasure-doors .zo-td-actions {
	display: flex;
	justify-content: center;
	gap: 10px;
	flex-wrap: wrap;
}

.zo-game-root--treasure-doors .zo-td-btn {
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

.zo-game-root--treasure-doors .zo-td-btn:hover,
.zo-game-root--treasure-doors .zo-td-btn:focus {
	background: #000;
	outline: none;
}

.zo-game-root--treasure-doors .zo-td-help {
	margin-top: 14px;
	font-size: 14px;
	color: #555;
	line-height: 1.5;
}

@media (max-width: 520px) {
	.zo-game-root--treasure-doors .zo-td-board {
		grid-template-columns: repeat(2, 1fr);
	}

	.zo-game-root--treasure-doors .zo-td-door {
		min-height: 90px;
		font-size: 16px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--treasure-doors');

	games.forEach(function (game) {
		const doors = Array.prototype.slice.call(game.querySelectorAll('.zo-td-door'));
		const statusEl = game.querySelector('.zo-td-status');
		const levelEl = game.querySelector('.zo-td-level-value');
		const scoreEl = game.querySelector('.zo-td-score-value');
		const heartsEl = game.querySelector('.zo-td-hearts-value');
		const restartBtn = game.querySelector('.zo-td-restart');
		const revealBtn = game.querySelector('.zo-td-reveal');

		let level = 1;
		let score = 0;
		let hearts = 3;
		let treasureIndex = 0;
		let locked = false;

		function chooseTreasure() {
			treasureIndex = Math.floor(Math.random() * doors.length);
		}

		function resetDoors() {
			doors.forEach(function (door, index) {
				door.disabled = false;
				door.classList.remove('is-treasure');
				door.classList.remove('is-trap');
				door.textContent = 'Chest ' + (index + 1);
				door.setAttribute('aria-label', 'Chest ' + (index + 1));
			});
		}

		function updateStats() {
			levelEl.textContent = String(level);
			scoreEl.textContent = String(score);
			heartsEl.textContent = String(hearts);
		}

		function setStatus(text) {
			statusEl.textContent = text;
		}

		function startLevel() {
			locked = false;
			resetDoors();
			chooseTreasure();
			updateStats();
			setStatus('Find the treasure chest.');
		}

		function showTreasure() {
			doors.forEach(function (door, index) {
				door.disabled = true;
				if (index === treasureIndex) {
					door.classList.add('is-treasure');
					door.textContent = 'TREASURE';
				}
			});
		}

		function finishGame(win) {
			locked = true;
			showTreasure();

			if (win) {
				setStatus('You won the treasure hunt.');
			} else {
				setStatus('Game over. The treasure was hidden too well.');
			}
		}

		doors.forEach(function (door, index) {
			door.addEventListener('click', function () {
				if (locked) {
					return;
				}

				if (index === treasureIndex) {
					door.classList.add('is-treasure');
					door.textContent = 'TREASURE';
					score += 1;
					locked = true;
					updateStats();

					if (score >= 6) {
						finishGame(true);
						return;
					}

					setStatus('You found the treasure. Next level...');
					setTimeout(function () {
						level += 1;
						startLevel();
					}, 900);
				} else {
					door.classList.add('is-trap');
					door.textContent = 'TRAP';
					door.disabled = true;
					hearts -= 1;
					updateStats();

					if (hearts <= 0) {
						finishGame(false);
					} else {
						setStatus('That was a trap. Try another chest.');
					}
				}
			});
		});

		restartBtn.addEventListener('click', function () {
			level = 1;
			score = 0;
			hearts = 3;
			startLevel();
		});

		revealBtn.addEventListener('click', function () {
			if (locked) {
				return;
			}

			locked = true;
			showTreasure();
			setStatus('There it is. Press restart to play again.');
		});

		startLevel();
	});
});
JS;

if (!function_exists('zo_game_treasure_doors_render')) {
	function zo_game_treasure_doors_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-treasure-doors-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--treasure-doors" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-td-card">
				<h2 class="zo-td-title">Treasure Doors</h2>
				<p class="zo-td-subtitle">Pick chests and try to find the hidden treasure. Reach 6 treasures before you lose all 3 hearts.</p>

				<div class="zo-td-stats">
					<div class="zo-td-stat">Level: <span class="zo-td-level-value">1</span></div>
					<div class="zo-td-stat">Score: <span class="zo-td-score-value">0</span></div>
					<div class="zo-td-stat">Hearts: <span class="zo-td-hearts-value">3</span></div>
				</div>

				<div class="zo-td-status" aria-live="polite">Find the treasure chest.</div>

				<div class="zo-td-board">
					<button type="button" class="zo-td-door">Chest 1</button>
					<button type="button" class="zo-td-door">Chest 2</button>
					<button type="button" class="zo-td-door">Chest 3</button>
					<button type="button" class="zo-td-door">Chest 4</button>
					<button type="button" class="zo-td-door">Chest 5</button>
					<button type="button" class="zo-td-door">Chest 6</button>
					<button type="button" class="zo-td-door">Chest 7</button>
					<button type="button" class="zo-td-door">Chest 8</button>
				</div>

				<div class="zo-td-actions">
					<button type="button" class="zo-td-btn zo-td-restart">Restart</button>
					<button type="button" class="zo-td-btn zo-td-reveal">Reveal Treasure</button>
				</div>

				<div class="zo-td-help">One chest has treasure. Wrong picks are traps and cost a heart.</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'treasure-doors',
	'name'            => 'Treasure Doors',
	'author'          => 'Arslan',
	'description'     => 'A simple treasure hunt game where players pick the correct chest and avoid traps.',
	'render_callback' => 'zo_game_treasure_doors_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);