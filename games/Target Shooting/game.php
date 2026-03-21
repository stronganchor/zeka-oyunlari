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

.zo-game-root--target-shooting .zo-tsg-card {
	background: #ffffff;
	border: 3px solid #222;
	border-radius: 18px;
	padding: 20px;
	box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}

.zo-game-root--target-shooting .zo-tsg-title {
	font-size: 28px;
	font-weight: 700;
	margin: 0 0 10px;
	color: #222;
}

.zo-game-root--target-shooting .zo-tsg-subtitle {
	font-size: 16px;
	line-height: 1.5;
	margin: 0 0 16px;
	color: #444;
}

.zo-game-root--target-shooting .zo-tsg-status {
	min-height: 28px;
	font-size: 18px;
	font-weight: 700;
	margin: 12px 0 16px;
	color: #0b5;
}

.zo-game-root--target-shooting .zo-tsg-stats {
	display: flex;
	justify-content: center;
	gap: 12px;
	flex-wrap: wrap;
	margin-bottom: 16px;
}

.zo-game-root--target-shooting .zo-tsg-stat {
	background: #f4f4f4;
	border: 2px solid #ddd;
	border-radius: 999px;
	padding: 8px 14px;
	font-size: 14px;
	font-weight: 700;
	color: #333;
}

.zo-game-root--target-shooting .zo-tsg-arena {
	position: relative;
	width: 100%;
	max-width: 520px;
	height: 360px;
	margin: 0 auto 16px;
	border: 3px solid #222;
	border-radius: 18px;
	background: linear-gradient(180deg, #dff3ff 0%, #b7e3ff 55%, #9ed38c 55%, #84bf70 100%);
	overflow: hidden;
	touch-action: manipulation;
	cursor: crosshair;
}

.zo-game-root--target-shooting .zo-tsg-target {
	position: absolute;
	width: 84px;
	height: 84px;
	border-radius: 50%;
	background:
		radial-gradient(circle at center, #ffd54f 0 14%, #d32f2f 14% 30%, #ffffff 30% 46%, #d32f2f 46% 62%, #ffffff 62% 78%, #d32f2f 78% 100%);
	border: 3px solid #222;
	box-sizing: border-box;
	transform: translate(-50%, -50%);
	cursor: pointer;
}

.zo-game-root--target-shooting .zo-tsg-burst {
	position: absolute;
	width: 70px;
	height: 70px;
	border-radius: 50%;
	border: 4px solid rgba(255, 193, 7, 0.9);
	transform: translate(-50%, -50%);
	pointer-events: none;
	animation: zoTargetBurst 0.35s ease-out forwards;
}

@keyframes zoTargetBurst {
	0% {
		opacity: 0.9;
		transform: translate(-50%, -50%) scale(0.4);
	}
	100% {
		opacity: 0;
		transform: translate(-50%, -50%) scale(1.5);
	}
}

.zo-game-root--target-shooting .zo-tsg-actions {
	display: flex;
	justify-content: center;
	gap: 10px;
	flex-wrap: wrap;
	margin-top: 8px;
}

.zo-game-root--target-shooting .zo-tsg-btn {
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

.zo-game-root--target-shooting .zo-tsg-btn:hover,
.zo-game-root--target-shooting .zo-tsg-btn:focus {
	background: #000;
	outline: none;
}

.zo-game-root--target-shooting .zo-tsg-help {
	margin-top: 14px;
	font-size: 14px;
	color: #555;
	line-height: 1.5;
}

@media (max-width: 520px) {
	.zo-game-root--target-shooting .zo-tsg-arena {
		height: 300px;
	}

	.zo-game-root--target-shooting .zo-tsg-target {
		width: 70px;
		height: 70px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--target-shooting');

	games.forEach(function (game) {
		const arena = game.querySelector('.zo-tsg-arena');
		const statusEl = game.querySelector('.zo-tsg-status');
		const scoreEl = game.querySelector('.zo-tsg-score-value');
		const hitsEl = game.querySelector('.zo-tsg-hits-value');
		const missesEl = game.querySelector('.zo-tsg-misses-value');
		const timeEl = game.querySelector('.zo-tsg-time-value');
		const restartBtn = game.querySelector('.zo-tsg-restart');

		let score = 0;
		let hits = 0;
		let misses = 0;
		let timeLeft = 30;
		let timerId = null;
		let moveId = null;
		let targetX = 100;
		let targetY = 100;
		let targetVX = 2.2;
		let targetVY = 1.7;
		let playing = false;
		let targetEl = null;

		function setStatus(text) {
			statusEl.textContent = text;
		}

		function updateStats() {
			scoreEl.textContent = String(score);
			hitsEl.textContent = String(hits);
			missesEl.textContent = String(misses);
			timeEl.textContent = String(timeLeft);
		}

		function removeTarget() {
			if (targetEl && targetEl.parentNode) {
				targetEl.parentNode.removeChild(targetEl);
			}
			targetEl = null;
		}

		function createBurst(x, y) {
			const burst = document.createElement('div');
			burst.className = 'zo-tsg-burst';
			burst.style.left = x + 'px';
			burst.style.top = y + 'px';
			arena.appendChild(burst);

			window.setTimeout(function () {
				if (burst.parentNode) {
					burst.parentNode.removeChild(burst);
				}
			}, 380);
		}

		function placeTarget() {
			removeTarget();

			const rect = arena.getBoundingClientRect();
			const size = window.innerWidth <= 520 ? 70 : 84;
			const minX = size / 2 + 6;
			const maxX = rect.width - size / 2 - 6;
			const minY = size / 2 + 6;
			const maxY = rect.height - size / 2 - 6;

			targetX = Math.max(minX, Math.min(maxX, rect.width * 0.5));
			targetY = Math.max(minY, Math.min(maxY, rect.height * 0.35));
			targetVX = Math.random() > 0.5 ? 2.2 : -2.2;
			targetVY = Math.random() > 0.5 ? 1.7 : -1.7;

			targetEl = document.createElement('button');
			targetEl.type = 'button';
			targetEl.className = 'zo-tsg-target';
			targetEl.setAttribute('aria-label', 'Target');
			targetEl.style.left = targetX + 'px';
			targetEl.style.top = targetY + 'px';

			targetEl.addEventListener('click', function (event) {
				event.stopPropagation();

				if (!playing) {
					return;
				}

				hits += 1;
				score += 10;
				updateStats();
				setStatus('Nice hit.');

				createBurst(targetX, targetY);

				const rectNow = arena.getBoundingClientRect();
				const sizeNow = targetEl.offsetWidth || size;
				const minNowX = sizeNow / 2 + 6;
				const maxNowX = rectNow.width - sizeNow / 2 - 6;
				const minNowY = sizeNow / 2 + 6;
				const maxNowY = rectNow.height - sizeNow / 2 - 6;

				targetX = minNowX + Math.random() * (maxNowX - minNowX);
				targetY = minNowY + Math.random() * (maxNowY - minNowY);
				targetVX = (Math.random() > 0.5 ? 1 : -1) * (1.8 + Math.random() * 1.6);
				targetVY = (Math.random() > 0.5 ? 1 : -1) * (1.4 + Math.random() * 1.4);
				targetEl.style.left = targetX + 'px';
				targetEl.style.top = targetY + 'px';
			});

			arena.appendChild(targetEl);
		}

		function moveTarget() {
			if (!playing || !targetEl) {
				return;
			}

			const rect = arena.getBoundingClientRect();
			const size = targetEl.offsetWidth || 84;
			const minX = size / 2 + 6;
			const maxX = rect.width - size / 2 - 6;
			const minY = size / 2 + 6;
			const maxY = rect.height - size / 2 - 6;

			targetX += targetVX;
			targetY += targetVY;

			if (targetX <= minX || targetX >= maxX) {
				targetVX *= -1;
				targetX = Math.max(minX, Math.min(maxX, targetX));
			}

			if (targetY <= minY || targetY >= maxY) {
				targetVY *= -1;
				targetY = Math.max(minY, Math.min(maxY, targetY));
			}

			targetEl.style.left = targetX + 'px';
			targetEl.style.top = targetY + 'px';
		}

		function stopGame() {
			playing = false;

			if (timerId) {
				window.clearInterval(timerId);
				timerId = null;
			}

			if (moveId) {
				window.clearInterval(moveId);
				moveId = null;
			}

			removeTarget();

			if (score >= 120) {
				setStatus('Great job. You won.');
			} else {
				setStatus('Time is up. Press Restart to play again.');
			}
		}

		function startGame() {
			score = 0;
			hits = 0;
			misses = 0;
			timeLeft = 30;
			playing = true;
			updateStats();
			setStatus('Tap the moving target.');

			arena.innerHTML = '';
			placeTarget();

			if (timerId) {
				window.clearInterval(timerId);
			}
			timerId = window.setInterval(function () {
				timeLeft -= 1;
				updateStats();

				if (timeLeft <= 0) {
					stopGame();
				}
			}, 1000);

			if (moveId) {
				window.clearInterval(moveId);
			}
			moveId = window.setInterval(function () {
				moveTarget();
			}, 16);
		}

		arena.addEventListener('click', function (event) {
			if (!playing) {
				return;
			}

			if (event.target === arena) {
				misses += 1;
				updateStats();
				setStatus('Miss. Try again.');
			}
		});

		restartBtn.addEventListener('click', function () {
			startGame();
		});

		startGame();
	});
});
JS;

if (!function_exists('zo_game_target_shooting_render')) {
	function zo_game_target_shooting_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-target-shooting-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--target-shooting" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-tsg-card">
				<h2 class="zo-tsg-title">Target Shooting</h2>
				<p class="zo-tsg-subtitle">Tap the moving target as many times as you can before time runs out. Each hit gives 10 points.</p>

				<div class="zo-tsg-stats">
					<div class="zo-tsg-stat">Score: <span class="zo-tsg-score-value">0</span></div>
					<div class="zo-tsg-stat">Hits: <span class="zo-tsg-hits-value">0</span></div>
					<div class="zo-tsg-stat">Misses: <span class="zo-tsg-misses-value">0</span></div>
					<div class="zo-tsg-stat">Time: <span class="zo-tsg-time-value">30</span></div>
				</div>

				<div class="zo-tsg-status" aria-live="polite">Tap the moving target.</div>

				<div class="zo-tsg-arena"></div>

				<div class="zo-tsg-actions">
					<button type="button" class="zo-tsg-btn zo-tsg-restart">Restart</button>
				</div>

				<div class="zo-tsg-help">Goal: reach 120 points before the timer ends.</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'target-shooting',
	'name'            => 'Target Shooting',
	'author'          => 'Arslan',
	'description'     => 'A simple target tapping game where players hit a moving target before time runs out.',
	'render_callback' => 'zo_game_target_shooting_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);