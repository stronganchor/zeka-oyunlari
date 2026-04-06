<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 640px;
	margin: 0 auto;
	padding: 16px;
	box-sizing: border-box;
	font-family: Arial, sans-serif;
	text-align: center;
}

.zo-game-root * {
	box-sizing: border-box;
}

.zo-game-root--fruit-slice .zo-fruit-slice-card {
	background: #f7f7f7;
	border: 2px solid #d9d9d9;
	border-radius: 16px;
	padding: 16px;
	box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.zo-game-root--fruit-slice .zo-fruit-slice-title {
	margin: 0 0 8px;
	font-size: 28px;
	line-height: 1.2;
}

.zo-game-root--fruit-slice .zo-fruit-slice-instructions {
	margin: 0 0 14px;
	font-size: 16px;
	line-height: 1.5;
	color: #333;
}

.zo-game-root--fruit-slice .zo-fruit-slice-topbar {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap: 10px;
	margin-bottom: 14px;
}

.zo-game-root--fruit-slice .zo-fruit-slice-stat {
	background: #ffffff;
	border: 2px solid #e3e3e3;
	border-radius: 12px;
	padding: 10px 14px;
	min-width: 110px;
	font-weight: bold;
	font-size: 16px;
}

.zo-game-root--fruit-slice .zo-fruit-slice-arena {
	position: relative;
	width: 100%;
	height: 360px;
	border-radius: 16px;
	border: 3px solid #cfd8dc;
	background: linear-gradient(180deg, #dff6ff 0%, #eefaf0 100%);
	overflow: hidden;
	touch-action: manipulation;
	user-select: none;
}

.zo-game-root--fruit-slice .zo-fruit-slice-target {
	position: absolute;
	width: 78px;
	height: 78px;
	border: none;
	border-radius: 50%;
	font-size: 38px;
	line-height: 1;
	display: flex;
	align-items: center;
	justify-content: center;
	cursor: pointer;
	box-shadow: 0 6px 14px rgba(0, 0, 0, 0.18);
	transform: translate(-50%, -50%);
	transition: transform 0.08s ease;
}

.zo-game-root--fruit-slice .zo-fruit-slice-target:active {
	transform: translate(-50%, -50%) scale(0.93);
}

.zo-game-root--fruit-slice .zo-fruit-slice-target--fruit {
	background: #ffffff;
}

.zo-game-root--fruit-slice .zo-fruit-slice-target--bomb {
	background: #2f3640;
	color: #ffffff;
}

.zo-game-root--fruit-slice .zo-fruit-slice-overlay {
	position: absolute;
	inset: 0;
	display: flex;
	align-items: center;
	justify-content: center;
	padding: 16px;
	background: rgba(255, 255, 255, 0.86);
}

.zo-game-root--fruit-slice .zo-fruit-slice-overlay[hidden] {
	display: none;
}

.zo-game-root--fruit-slice .zo-fruit-slice-overlay-box {
	background: #ffffff;
	border: 2px solid #d7d7d7;
	border-radius: 16px;
	padding: 18px;
	width: 100%;
	max-width: 360px;
	box-shadow: 0 8px 18px rgba(0, 0, 0, 0.12);
}

.zo-game-root--fruit-slice .zo-fruit-slice-message {
	margin: 0 0 12px;
	font-size: 22px;
	font-weight: bold;
	line-height: 1.35;
	color: #222;
}

.zo-game-root--fruit-slice .zo-fruit-slice-buttons {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap: 10px;
	margin-top: 14px;
}

.zo-game-root--fruit-slice .zo-fruit-slice-btn {
	border: none;
	border-radius: 12px;
	padding: 12px 18px;
	font-size: 16px;
	font-weight: bold;
	cursor: pointer;
	background: #4caf50;
	color: #fff;
}

.zo-game-root--fruit-slice .zo-fruit-slice-btn--secondary {
	background: #2196f3;
}

.zo-game-root--fruit-slice .zo-fruit-slice-status {
	margin-top: 14px;
	min-height: 24px;
	font-size: 16px;
	font-weight: bold;
	color: #333;
}

@media (max-width: 480px) {
	.zo-game-root--fruit-slice .zo-fruit-slice-arena {
		height: 320px;
	}

	.zo-game-root--fruit-slice .zo-fruit-slice-target {
		width: 70px;
		height: 70px;
		font-size: 34px;
	}

	.zo-game-root--fruit-slice .zo-fruit-slice-title {
		font-size: 24px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--fruit-slice');

	games.forEach(function (game) {
		const arena = game.querySelector('.zo-fruit-slice-arena');
		const scoreEl = game.querySelector('.zo-fruit-slice-score');
		const timeEl = game.querySelector('.zo-fruit-slice-time');
		const livesEl = game.querySelector('.zo-fruit-slice-lives');
		const statusEl = game.querySelector('.zo-fruit-slice-status');
		const overlay = game.querySelector('.zo-fruit-slice-overlay');
		const overlayMessage = game.querySelector('.zo-fruit-slice-message');
		const startBtn = game.querySelector('.zo-fruit-slice-start');
		const restartBtn = game.querySelector('.zo-fruit-slice-restart');

		let score = 0;
		let timeLeft = 30;
		let lives = 3;
		let timerId = null;
		let spawnId = null;
		let running = false;

		const fruitIcons = ['🍎', '🍉', '🍌', '🍓', '🍒', '🍊', '🍍', '🥝'];

		function updateHud() {
			scoreEl.textContent = String(score);
			timeEl.textContent = String(timeLeft);
			livesEl.textContent = String(lives);
		}

		function clearTargets() {
			const targets = arena.querySelectorAll('.zo-fruit-slice-target');
			targets.forEach(function (target) {
				target.remove();
			});
		}

		function showOverlay(message) {
			overlayMessage.textContent = message;
			overlay.hidden = false;
		}

		function hideOverlay() {
			overlay.hidden = true;
		}

		function randomBetween(min, max) {
			return Math.random() * (max - min) + min;
		}

		function spawnTarget() {
			if (!running) {
				return;
			}

			const rect = arena.getBoundingClientRect();
			const size = window.innerWidth <= 480 ? 70 : 78;
			const half = size / 2;
			const maxX = Math.max(half, rect.width - half);
			const maxY = Math.max(half, rect.height - half);

			const isBomb = Math.random() < 0.22;
			const target = document.createElement('button');

			target.type = 'button';
			target.className = 'zo-fruit-slice-target ' + (isBomb ? 'zo-fruit-slice-target--bomb' : 'zo-fruit-slice-target--fruit');
			target.textContent = isBomb ? '💣' : fruitIcons[Math.floor(Math.random() * fruitIcons.length)];
			target.style.left = randomBetween(half, maxX) + 'px';
			target.style.top = randomBetween(half, maxY) + 'px';

			const lifeTime = isBomb ? 1400 : 1250;

			target.addEventListener('click', function () {
				if (!running) {
					return;
				}

				if (isBomb) {
					lives--;
					statusEl.textContent = 'Bomb hit. Be careful.';
				} else {
					score++;
					statusEl.textContent = 'Nice slice.';
				}

				updateHud();
				target.remove();
				checkEnd();
			});

			arena.appendChild(target);

			window.setTimeout(function () {
				if (!running) {
					return;
				}

				if (target.parentNode) {
					if (!isBomb) {
						lives--;
						statusEl.textContent = 'You missed a fruit.';
						updateHud();
						checkEnd();
					}
					target.remove();
				}
			}, lifeTime);
		}

		function checkEnd() {
			if (lives <= 0) {
				endGame('Game over. Score: ' + score);
				return true;
			}

			if (timeLeft <= 0) {
				endGame('Time up. Final score: ' + score);
				return true;
			}

			return false;
		}

		function endGame(message) {
			running = false;
			window.clearInterval(timerId);
			window.clearInterval(spawnId);
			timerId = null;
			spawnId = null;
			clearTargets();
			showOverlay(message);
		}

		function startGame() {
			score = 0;
			timeLeft = 30;
			lives = 3;
			running = true;
			statusEl.textContent = 'Slice the fruit. Avoid bombs.';
			updateHud();
			clearTargets();
			hideOverlay();

			window.clearInterval(timerId);
			window.clearInterval(spawnId);

			timerId = window.setInterval(function () {
				if (!running) {
					return;
				}

				timeLeft--;
				updateHud();
				checkEnd();
			}, 1000);

			spawnTarget();

			spawnId = window.setInterval(function () {
				spawnTarget();
			}, 700);
		}

		startBtn.addEventListener('click', function () {
			startGame();
		});

		restartBtn.addEventListener('click', function () {
			startGame();
		});

		updateHud();
		showOverlay('Press Start to play Fruit Slice.');
	});
});
JS;

if (!function_exists('zo_game_fruit_slice_render')) {
	function zo_game_fruit_slice_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-fruit-slice-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--fruit-slice" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-fruit-slice-card">
				<h2 class="zo-fruit-slice-title">Fruit Slice</h2>
				<p class="zo-fruit-slice-instructions">Tap the fruit fast. Do not tap bombs. Missed fruit costs a life.</p>

				<div class="zo-fruit-slice-topbar">
					<div class="zo-fruit-slice-stat">Score: <span class="zo-fruit-slice-score">0</span></div>
					<div class="zo-fruit-slice-stat">Time: <span class="zo-fruit-slice-time">30</span></div>
					<div class="zo-fruit-slice-stat">Lives: <span class="zo-fruit-slice-lives">3</span></div>
				</div>

				<div class="zo-fruit-slice-arena">
					<div class="zo-fruit-slice-overlay">
						<div class="zo-fruit-slice-overlay-box">
							<p class="zo-fruit-slice-message">Press Start to play Fruit Slice.</p>
							<div class="zo-fruit-slice-buttons">
								<button type="button" class="zo-fruit-slice-btn zo-fruit-slice-start">Start</button>
							</div>
						</div>
					</div>
				</div>

				<div class="zo-fruit-slice-status">Slice the fruit. Avoid bombs.</div>

				<div class="zo-fruit-slice-buttons">
					<button type="button" class="zo-fruit-slice-btn zo-fruit-slice-restart">Restart</button>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'fruit-slice',
	'name'            => 'Fruit Slice',
	'author'          => 'Arslan',
	'description'     => 'A fast fruit tapping game for kids. Tap fruit, avoid bombs, and beat the timer.',
	'render_callback' => 'zo_game_fruit_slice_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);