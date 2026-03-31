<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root--secret-star-sprint {
	max-width: 560px;
	margin: 0 auto;
	padding: 18px;
	background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
	border-radius: 18px;
	color: #ffffff;
	box-sizing: border-box;
	font-family: inherit;
}

.zo-game-root--secret-star-sprint * {
	box-sizing: border-box;
}

.zo-game-root--secret-star-sprint .zo-secret-title {
	font-size: 28px;
	font-weight: 700;
	margin: 0 0 10px;
}

.zo-game-root--secret-star-sprint .zo-secret-subtitle {
	font-size: 15px;
	line-height: 1.5;
	margin: 0 0 16px;
	color: #dbeafe;
}

.zo-game-root--secret-star-sprint .zo-secret-panel {
	display: grid;
	grid-template-columns: repeat(3, minmax(0, 1fr));
	gap: 10px;
	margin-bottom: 14px;
}

.zo-game-root--secret-star-sprint .zo-secret-stat {
	background: rgba(255, 255, 255, 0.12);
	border-radius: 14px;
	padding: 10px 12px;
	text-align: center;
}

.zo-game-root--secret-star-sprint .zo-secret-label {
	display: block;
	font-size: 12px;
	color: #bfdbfe;
	margin-bottom: 4px;
}

.zo-game-root--secret-star-sprint .zo-secret-value {
	display: block;
	font-size: 22px;
	font-weight: 700;
}

.zo-game-root--secret-star-sprint .zo-secret-status {
	min-height: 26px;
	margin: 0 0 14px;
	font-size: 15px;
	font-weight: 600;
	color: #fde68a;
}

.zo-game-root--secret-star-sprint .zo-secret-arena {
	position: relative;
	height: 320px;
	border-radius: 18px;
	overflow: hidden;
	background:
		radial-gradient(circle at 20% 20%, rgba(255, 255, 255, 0.18) 0 2px, transparent 3px),
		radial-gradient(circle at 70% 30%, rgba(255, 255, 255, 0.14) 0 2px, transparent 3px),
		radial-gradient(circle at 50% 80%, rgba(255, 255, 255, 0.12) 0 2px, transparent 3px),
		linear-gradient(180deg, #1d4ed8 0%, #172554 100%);
	border: 2px solid rgba(255, 255, 255, 0.14);
	margin-bottom: 14px;
	touch-action: manipulation;
}

.zo-game-root--secret-star-sprint .zo-secret-center {
	position: absolute;
	inset: 0;
	display: flex;
	align-items: center;
	justify-content: center;
	padding: 18px;
	text-align: center;
	pointer-events: none;
	color: #dbeafe;
	font-size: 18px;
	font-weight: 600;
}

.zo-game-root--secret-star-sprint .zo-secret-star {
	position: absolute;
	border: 0;
	border-radius: 999px;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 28px;
	line-height: 1;
	cursor: pointer;
	user-select: none;
	background: radial-gradient(circle at 35% 35%, #fff7ae 0%, #facc15 55%, #f59e0b 100%);
	box-shadow: 0 10px 18px rgba(0, 0, 0, 0.24);
	transform: scale(1);
	transition: transform 0.12s ease;
}

.zo-game-root--secret-star-sprint .zo-secret-star:active {
	transform: scale(0.92);
}

.zo-game-root--secret-star-sprint .zo-secret-controls {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	justify-content: center;
}

.zo-game-root--secret-star-sprint .zo-secret-btn {
	border: 0;
	border-radius: 999px;
	padding: 12px 18px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	background: #facc15;
	color: #111827;
	min-width: 140px;
}

.zo-game-root--secret-star-sprint .zo-secret-btn:hover {
	filter: brightness(1.05);
}

.zo-game-root--secret-star-sprint .zo-secret-btn--secondary {
	background: #e2e8f0;
}

@media (max-width: 520px) {
	.zo-game-root--secret-star-sprint {
		padding: 14px;
	}

	.zo-game-root--secret-star-sprint .zo-secret-title {
		font-size: 24px;
	}

	.zo-game-root--secret-star-sprint .zo-secret-panel {
		grid-template-columns: 1fr;
	}

	.zo-game-root--secret-star-sprint .zo-secret-arena {
		height: 280px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--secret-star-sprint');

	games.forEach(function (game) {
		const arena = game.querySelector('.zo-secret-arena');
		const centerText = game.querySelector('.zo-secret-center');
		const scoreEl = game.querySelector('.zo-secret-score');
		const timeEl = game.querySelector('.zo-secret-time');
		const targetEl = game.querySelector('.zo-secret-target');
		const statusEl = game.querySelector('.zo-secret-status');
		const startBtn = game.querySelector('.zo-secret-start');
		const restartBtn = game.querySelector('.zo-secret-restart');

		if (!arena || !scoreEl || !timeEl || !targetEl || !statusEl || !startBtn || !restartBtn) {
			return;
		}

		let score = 0;
		let timeLeft = 20;
		let active = false;
		let timerId = null;
		let starTimeout = null;
		let currentStar = null;
		const targetScore = 12;

		targetEl.textContent = String(targetScore);

		function clearCurrentStar() {
			if (currentStar && currentStar.parentNode) {
				currentStar.parentNode.removeChild(currentStar);
			}
			currentStar = null;
		}

		function clearTimers() {
			if (timerId) {
				window.clearInterval(timerId);
				timerId = null;
			}
			if (starTimeout) {
				window.clearTimeout(starTimeout);
				starTimeout = null;
			}
		}

		function updatePanel() {
			scoreEl.textContent = String(score);
			timeEl.textContent = String(timeLeft);
		}

		function endGame() {
			active = false;
			clearTimers();
			clearCurrentStar();
			centerText.hidden = false;

			if (score >= targetScore) {
				centerText.textContent = 'You found the hidden stars.';
				statusEl.textContent = 'You win.';
			} else {
				centerText.textContent = 'Try again and catch more stars.';
				statusEl.textContent = 'Time is up.';
			}
		}

		function scheduleNextStar() {
			if (!active) {
				return;
			}

			starTimeout = window.setTimeout(function () {
				spawnStar();
			}, 250 + Math.floor(Math.random() * 500));
		}

		function spawnStar() {
			if (!active) {
				return;
			}

			clearCurrentStar();

			const star = document.createElement('button');
			const size = 48 + Math.floor(Math.random() * 24);
			const maxLeft = Math.max(0, arena.clientWidth - size - 8);
			const maxTop = Math.max(0, arena.clientHeight - size - 8);
			const left = 4 + Math.floor(Math.random() * (maxLeft + 1));
			const top = 4 + Math.floor(Math.random() * (maxTop + 1));
			const life = 700 + Math.floor(Math.random() * 850);

			star.type = 'button';
			star.className = 'zo-secret-star';
			star.setAttribute('aria-label', 'Catch the star');
			star.textContent = '⭐';
			star.style.width = size + 'px';
			star.style.height = size + 'px';
			star.style.left = left + 'px';
			star.style.top = top + 'px';

			star.addEventListener('click', function () {
				if (!active) {
					return;
				}

				score += 1;
				updatePanel();
				statusEl.textContent = 'Nice catch.';
				clearCurrentStar();
				scheduleNextStar();
			});

			arena.appendChild(star);
			currentStar = star;

			starTimeout = window.setTimeout(function () {
				if (!active) {
					return;
				}
				clearCurrentStar();
				statusEl.textContent = 'Too slow. Watch for the next one.';
				scheduleNextStar();
			}, life);
		}

		function startGame() {
			clearTimers();
			clearCurrentStar();

			score = 0;
			timeLeft = 20;
			active = true;
			updatePanel();

			centerText.hidden = true;
			statusEl.textContent = 'Catch ' + targetScore + ' stars before time runs out.';

			timerId = window.setInterval(function () {
				timeLeft -= 1;
				updatePanel();

				if (timeLeft <= 0) {
					endGame();
				}
			}, 1000);

			scheduleNextStar();
		}

		startBtn.addEventListener('click', function () {
			startGame();
		});

		restartBtn.addEventListener('click', function () {
			startGame();
		});

		updatePanel();
		centerText.hidden = false;
		centerText.textContent = 'Press Start to begin.';
		statusEl.textContent = 'Private game. Embed directly where you want it.';
	});
});
JS;

if (!function_exists('zo_game_secret_star_sprint_render')) {
	function zo_game_secret_star_sprint_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-secret-star-sprint-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--secret-star-sprint" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-secret-title">Secret Star Sprint</h2>
			<p class="zo-secret-subtitle">Catch the hidden stars before time runs out. Tap or click fast.</p>

			<div class="zo-secret-panel">
				<div class="zo-secret-stat">
					<span class="zo-secret-label">Score</span>
					<span class="zo-secret-value zo-secret-score">0</span>
				</div>
				<div class="zo-secret-stat">
					<span class="zo-secret-label">Time</span>
					<span class="zo-secret-value"><span class="zo-secret-time">20</span>s</span>
				</div>
				<div class="zo-secret-stat">
					<span class="zo-secret-label">Target</span>
					<span class="zo-secret-value zo-secret-target">12</span>
				</div>
			</div>

			<p class="zo-secret-status">Catch the stars.</p>

			<div class="zo-secret-arena">
				<div class="zo-secret-center">Press Start to begin.</div>
			</div>

			<div class="zo-secret-controls">
				<button type="button" class="zo-secret-btn zo-secret-start">Start</button>
				<button type="button" class="zo-secret-btn zo-secret-btn--secondary zo-secret-restart">Restart</button>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'secret-star-sprint',
	'name'            => 'Secret Star Sprint',
	'author'          => 'Private',
	'description'     => 'A private star-catching game meant to be embedded directly.',
	'render_callback' => 'zo_game_secret_star_sprint_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);