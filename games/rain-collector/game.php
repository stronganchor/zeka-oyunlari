<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--rain-collector {
	max-width: 560px;
	margin: 0 auto;
	padding: 14px;
	border: 2px solid #d8e2ec;
	border-radius: 14px;
	background: #f1f9ff;
	font-family: Arial, sans-serif;
	box-sizing: border-box;
}

.zo-rc-title {
	text-align: center;
	margin: 0 0 10px;
}

.zo-rc-sky {
	position: relative;
	height: 230px;
	overflow: hidden;
	border: 2px dashed #93c5fd;
	border-radius: 12px;
	background: linear-gradient(180deg, #dbeafe, #e0f2fe);
}

.zo-rc-drop {
	position: absolute;
	top: -24px;
	width: 40px;
	height: 34px;
	border: 0;
	border-radius: 17px;
	background: #0f172a;
	color: #fff;
	font-weight: 700;
	cursor: pointer;
}

@keyframes zo-rc-fall {
	to {
		transform: translateY(220px);
	}
}

.zo-rc-drop {
	animation: zo-rc-fall 2.4s linear forwards;
}

.zo-rc-controls {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 8px;
	margin-top: 12px;
	text-align: center;
}

.zo-rc-start,
.zo-rc-stat {
	border-radius: 10px;
	padding: 10px;
}

.zo-rc-start {
	border: 0;
	background: #2563eb;
	color: #fff;
	font-weight: 700;
	cursor: pointer;
}

.zo-rc-stat {
	background: #eef2ff;
}

.zo-rc-target {
	font-weight: 700;
	font-size: 18px;
	text-align: center;
	margin-top: 8px;
}

.zo-rc-status {
	min-height: 24px;
	margin-top: 8px;
	text-align: center;
	font-weight: 700;
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root');

	games.forEach(function (game) {
		if (!game.classList.contains('zo-game-root--rain-collector')) {
			return;
		}

		const sky = game.querySelector('.zo-rc-sky');
		const startBtn = game.querySelector('.zo-rc-start');
		const targetEl = game.querySelector('.zo-rc-target-value');
		const scoreEl = game.querySelector('.zo-rc-score');
		const timeEl = game.querySelector('.zo-rc-time');
		const livesEl = game.querySelector('.zo-rc-lives');
		const status = game.querySelector('.zo-rc-status');

		const symbols = ['A', 'B', 'C', 'D', 'E', 'F'];
		let running = false;
		let score = 0;
		let lives = 3;
		let timeLeft = 30;
		let target = 'A';
		let spawnInterval = null;
		let timerInterval = null;
		let targetInterval = null;

		function pickTarget() {
			target = symbols[Math.floor(Math.random() * symbols.length)];
			targetEl.textContent = target;
		}

		function updateHud() {
			scoreEl.textContent = String(score);
			livesEl.textContent = String(lives);
			timeEl.textContent = String(timeLeft) + 's';
		}

		function stopGame() {
			running = false;
			if (spawnInterval) {
				clearInterval(spawnInterval);
				spawnInterval = null;
			}
			if (timerInterval) {
				clearInterval(timerInterval);
				timerInterval = null;
			}
			if (targetInterval) {
				clearInterval(targetInterval);
				targetInterval = null;
			}
			while (sky.firstChild) {
				sky.removeChild(sky.firstChild);
			}
		}

		function missOne() {
			lives -= 1;
			updateHud();
			if (lives <= 0) {
				stopGame();
				status.textContent = 'Out of catches. Press Start.';
			}
		}

		function popDrop(drop) {
			if (!running) {
				return;
			}
			const symbol = drop.textContent;
			if (symbol === target) {
				score += 1;
			} else {
				missOne();
			}
			updateHud();
			if (drop.parentNode) {
				sky.removeChild(drop);
			}
		}

		function spawnDrop() {
			if (!running) {
				return;
			}
			const symbol = symbols[Math.floor(Math.random() * symbols.length)];
			const drop = document.createElement('button');
			drop.type = 'button';
			drop.className = 'zo-rc-drop';
			drop.style.left = String(Math.floor(Math.random() * 90)) + '%';
			drop.textContent = symbol;
			sky.appendChild(drop);
			drop.addEventListener('click', function () {
				popDrop(drop);
			});
			drop.addEventListener('animationend', function () {
				if (running && drop.parentNode) {
					if (symbol === target) {
						missOne();
					}
					sky.removeChild(drop);
				}
			});
		}

		function startRound() {
			stopGame();
			running = true;
			score = 0;
			lives = 3;
			timeLeft = 30;
			updateHud();
			pickTarget();
			status.textContent = 'Collect the target letter.';
			targetInterval = setInterval(function () {
				pickTarget();
			}, 5000);
			spawnInterval = setInterval(function () {
				spawnDrop();
			}, 700);
			timerInterval = setInterval(function () {
				timeLeft -= 1;
				updateHud();
				if (timeLeft <= 0) {
					stopGame();
					status.textContent = 'Time over. Score: ' + score;
				}
			}, 1000);
		}

		startBtn.addEventListener('click', function () {
			startRound();
		});

		updateHud();
		status.textContent = 'Press Start.';
	});
});
JS;

if (!function_exists('zo_game_rain_collector_render')) {
	function zo_game_rain_collector_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-rain-collector-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--rain-collector" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-rc-title">Rain Collector</h2>
			<div class="zo-rc-sky"></div>
			<div class="zo-rc-target">Collect: <span class="zo-rc-target-value">A</span></div>
			<div class="zo-rc-controls">
				<div class="zo-rc-stat">Score: <span class="zo-rc-score">0</span></div>
				<div class="zo-rc-stat">Time: <span class="zo-rc-time">30s</span></div>
				<div class="zo-rc-stat">Lives: <span class="zo-rc-lives">3</span></div>
				<button type="button" class="zo-rc-start">Start</button>
			</div>
			<div class="zo-rc-status">Press Start.</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'rain-collector',
	'name'            => 'Rain Collector',
	'author'          => 'Asker',
	'description'     => 'Collect falling letters that match the current target.',
	'render_callback' => 'zo_game_rain_collector_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
