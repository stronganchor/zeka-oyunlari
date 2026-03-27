<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root--car-lane-switch {
	max-width: 500px;
	margin: 0 auto;
	text-align: center;
	font-family: Arial, sans-serif;
	color: #ffffff;
}

.zo-game-root--car-lane-switch .zo-car-wrap {
	background: #0f172a;
	border-radius: 18px;
	padding: 14px;
	box-shadow: 0 10px 24px rgba(0, 0, 0, 0.18);
}

.zo-game-root--car-lane-switch .zo-car-title {
	margin: 0 0 8px;
	font-size: 24px;
	font-weight: 700;
	color: #ffffff;
}

.zo-game-root--car-lane-switch .zo-car-instructions {
	margin: 0 0 12px;
	font-size: 14px;
	line-height: 1.5;
	color: #cbd5e1;
}

.zo-game-root--car-lane-switch .zo-car-canvas {
	display: block;
	width: 100%;
	height: auto;
	background: #111827;
	border-radius: 14px;
	border: 2px solid #334155;
}

.zo-game-root--car-lane-switch .zo-car-panel {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 8px;
	margin-top: 12px;
}

.zo-game-root--car-lane-switch .zo-car-stat {
	background: #1e293b;
	border-radius: 12px;
	padding: 10px 8px;
}

.zo-game-root--car-lane-switch .zo-car-stat-number {
	display: block;
	font-size: 22px;
	font-weight: 700;
	color: #ffffff;
}

.zo-game-root--car-lane-switch .zo-car-stat-label {
	display: block;
	margin-top: 4px;
	font-size: 12px;
	color: #cbd5e1;
}

.zo-game-root--car-lane-switch .zo-car-status {
	margin-top: 12px;
	min-height: 22px;
	font-size: 14px;
	font-weight: 700;
	color: #93c5fd;
}

.zo-game-root--car-lane-switch .zo-car-buttons {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap: 8px;
	margin-top: 12px;
}

.zo-game-root--car-lane-switch .zo-car-btn {
	border: 0;
	border-radius: 12px;
	padding: 10px 14px;
	font-size: 14px;
	font-weight: 700;
	cursor: pointer;
	color: #ffffff;
}

.zo-game-root--car-lane-switch .zo-car-btn--start {
	background: #10b981;
}

.zo-game-root--car-lane-switch .zo-car-btn--reset {
	background: #ef4444;
}

.zo-game-root--car-lane-switch .zo-car-btn--left,
.zo-game-root--car-lane-switch .zo-car-btn--right {
	background: #2563eb;
}

.zo-game-root--car-lane-switch .zo-car-mobile {
	display: none;
	gap: 8px;
	justify-content: center;
	margin-top: 10px;
}

.zo-game-root--car-lane-switch .zo-car-credit {
	margin: 12px 0 0;
	font-size: 12px;
	color: #94a3b8;
}

@media (max-width: 640px) {
	.zo-game-root--car-lane-switch .zo-car-mobile {
		display: flex;
	}

	.zo-game-root--car-lane-switch .zo-car-panel {
		grid-template-columns: 1fr;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--car-lane-switch');

	games.forEach(function (game) {
		const canvas = game.querySelector('.zo-car-canvas');
		const ctx = canvas.getContext('2d');

		const startBtn = game.querySelector('.zo-car-btn--start');
		const resetBtn = game.querySelector('.zo-car-btn--reset');
		const leftBtn = game.querySelector('.zo-car-btn--left');
		const rightBtn = game.querySelector('.zo-car-btn--right');

		const scoreEl = game.querySelector('.zo-car-score');
		const speedEl = game.querySelector('.zo-car-speed');
		const bestEl = game.querySelector('.zo-car-best');
		const statusEl = game.querySelector('.zo-car-status');

		const laneCenters = [125, 250, 375];

		let lane = 1;
		let carY = 520;
		let obstacles = [];
		let speed = 4;
		let score = 0;
		let best = 0;
		let running = false;
		let animationId = null;
		let spawnTick = 0;

		function updateStats() {
			scoreEl.textContent = String(score);
			speedEl.textContent = speed.toFixed(1);
			bestEl.textContent = String(best);
		}

		function setStatus(message) {
			statusEl.textContent = message;
		}

		function resetGame() {
			lane = 1;
			obstacles = [];
			speed = 4;
			score = 0;
			spawnTick = 0;
			running = false;
			updateStats();
			setStatus('Press Start to play.');
			draw();
		}

		function spawnObstacle() {
			const laneIndex = Math.floor(Math.random() * 3);
			obstacles.push({
				lane: laneIndex,
				x: laneCenters[laneIndex],
				y: -60,
				w: 46,
				h: 82
			});
		}

		function moveLeft() {
			if (lane > 0) {
				lane--;
			}
		}

		function moveRight() {
			if (lane < 2) {
				lane++;
			}
		}

		function rectsOverlap(a, b) {
			return !(
				a.x + a.w / 2 < b.x - b.w / 2 ||
				a.x - a.w / 2 > b.x + b.w / 2 ||
				a.y + a.h / 2 < b.y - b.h / 2 ||
				a.y - a.h / 2 > b.y + b.h / 2
			);
		}

		function update() {
			if (!running) {
				return;
			}

			spawnTick++;

			if (spawnTick >= Math.max(20, Math.floor(60 - (speed * 5)))) {
				spawnObstacle();
				spawnTick = 0;
			}

			for (let i = 0; i < obstacles.length; i++) {
				obstacles[i].y += speed;
			}

			const car = {
				x: laneCenters[lane],
				y: carY,
				w: 48,
				h: 84
			};

			for (let i = 0; i < obstacles.length; i++) {
				if (rectsOverlap(car, obstacles[i])) {
					running = false;
					if (score > best) {
						best = score;
					}
					updateStats();
					setStatus('Crash. Press Start or Reset.');
					return;
				}
			}

			const kept = [];
			for (let i = 0; i < obstacles.length; i++) {
				if (obstacles[i].y - obstacles[i].h / 2 <= 660) {
					kept.push(obstacles[i]);
				} else {
					score++;
					if (score > best) {
						best = score;
					}
					if (score % 5 === 0) {
						speed += 0.5;
					}
				}
			}
			obstacles = kept;

			updateStats();
			setStatus('Avoid the red cars.');
		}

		function drawRoad() {
			ctx.fillStyle = '#1f2937';
			ctx.fillRect(65, 0, 370, 640);

			ctx.strokeStyle = '#475569';
			ctx.lineWidth = 6;
			ctx.beginPath();
			ctx.moveTo(65, 0);
			ctx.lineTo(65, 640);
			ctx.moveTo(435, 0);
			ctx.lineTo(435, 640);
			ctx.stroke();

			ctx.strokeStyle = '#cbd5e1';
			ctx.lineWidth = 4;
			ctx.setLineDash([18, 18]);
			ctx.beginPath();
			ctx.moveTo(190, 0);
			ctx.lineTo(190, 640);
			ctx.moveTo(315, 0);
			ctx.lineTo(315, 640);
			ctx.stroke();
			ctx.setLineDash([]);
		}

		function drawPlayerCar() {
			const x = laneCenters[lane];

			ctx.fillStyle = '#2563eb';
			ctx.fillRect(x - 24, carY - 42, 48, 84);

			ctx.fillStyle = '#93c5fd';
			ctx.fillRect(x - 16, carY - 28, 32, 20);

			ctx.fillStyle = '#0f172a';
			ctx.beginPath();
			ctx.arc(x - 16, carY - 28, 8, 0, Math.PI * 2);
			ctx.arc(x + 16, carY - 28, 8, 0, Math.PI * 2);
			ctx.arc(x - 16, carY + 28, 8, 0, Math.PI * 2);
			ctx.arc(x + 16, carY + 28, 8, 0, Math.PI * 2);
			ctx.fill();
		}

		function drawObstacles() {
			for (let i = 0; i < obstacles.length; i++) {
				const o = obstacles[i];

				ctx.fillStyle = '#ef4444';
				ctx.fillRect(o.x - o.w / 2, o.y - o.h / 2, o.w, o.h);

				ctx.fillStyle = '#fecaca';
				ctx.fillRect(o.x - 14, o.y - 28, 28, 18);

				ctx.fillStyle = '#111827';
				ctx.beginPath();
				ctx.arc(o.x - 14, o.y - 28, 8, 0, Math.PI * 2);
				ctx.arc(o.x + 14, o.y - 28, 8, 0, Math.PI * 2);
				ctx.arc(o.x - 14, o.y + 28, 8, 0, Math.PI * 2);
				ctx.arc(o.x + 14, o.y + 28, 8, 0, Math.PI * 2);
				ctx.fill();
			}
		}

		function draw() {
			ctx.clearRect(0, 0, canvas.width, canvas.height);
			drawRoad();
			drawObstacles();
			drawPlayerCar();
		}

		function loop() {
			update();
			draw();
			animationId = window.requestAnimationFrame(loop);
		}

		function startGame() {
			if (!running) {
				running = true;
				setStatus('Go.');
			}
		}

		document.addEventListener('keydown', function (e) {
			if (!game.isConnected) {
				return;
			}

			if (e.key === 'ArrowLeft') {
				e.preventDefault();
				moveLeft();
			}

			if (e.key === 'ArrowRight') {
				e.preventDefault();
				moveRight();
			}
		});

		canvas.addEventListener('click', function () {
			if (lane < 2) {
				moveRight();
			} else {
				lane = 0;
			}
		});

		startBtn.addEventListener('click', function () {
			startGame();
		});

		resetBtn.addEventListener('click', function () {
			resetGame();
			startGame();
		});

		leftBtn.addEventListener('click', function () {
			moveLeft();
		});

		rightBtn.addEventListener('click', function () {
			moveRight();
		});

		resetGame();

		if (!animationId) {
			loop();
		}
	});
});
JS;

if (!function_exists('zo_game_car_lane_switch_render')) {
	function zo_game_car_lane_switch_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-car-lane-switch-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--car-lane-switch" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-car-wrap">
				<h2 class="zo-car-title">Car Lane Switch</h2>
				<p class="zo-car-instructions">Use left and right to switch lanes. Avoid the red cars. Tap the road on mobile to change lanes.</p>

				<canvas class="zo-car-canvas" width="500" height="640"></canvas>

				<div class="zo-car-panel">
					<div class="zo-car-stat">
						<span class="zo-car-stat-number zo-car-score">0</span>
						<span class="zo-car-stat-label">Score</span>
					</div>
					<div class="zo-car-stat">
						<span class="zo-car-stat-number zo-car-speed">4.0</span>
						<span class="zo-car-stat-label">Speed</span>
					</div>
					<div class="zo-car-stat">
						<span class="zo-car-stat-number zo-car-best">0</span>
						<span class="zo-car-stat-label">Best</span>
					</div>
				</div>

				<div class="zo-car-status">Press Start to play.</div>

				<div class="zo-car-buttons">
					<button type="button" class="zo-car-btn zo-car-btn--start">Start</button>
					<button type="button" class="zo-car-btn zo-car-btn--reset">Reset</button>
				</div>

				<div class="zo-car-mobile">
					<button type="button" class="zo-car-btn zo-car-btn--left">Left</button>
					<button type="button" class="zo-car-btn zo-car-btn--right">Right</button>
				</div>

				<p class="zo-car-credit">by Asker</p>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'car-lane-switch',
	'name'            => 'Car Lane Switch',
	'author'          => 'Asker',
	'description'     => 'Switch lanes and avoid the red cars.',
	'render_callback' => 'zo_game_car_lane_switch_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);