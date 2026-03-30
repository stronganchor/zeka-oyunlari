<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 520px;
	margin: 0 auto;
	font-family: inherit;
}

.zo-game-root--car-lane-switch .zo-car-game {
	background: linear-gradient(180deg, #bfe7ff 0%, #eaf7ff 42%, #74c365 42%, #5daa4f 100%);
	border-radius: 20px;
	padding: 16px;
	box-sizing: border-box;
	box-shadow: 0 10px 24px rgba(0, 0, 0, 0.12);
}

.zo-game-root--car-lane-switch .zo-car-title {
	margin: 0 0 8px;
	font-size: 28px;
	line-height: 1.2;
	text-align: center;
	color: #17324d;
}

.zo-game-root--car-lane-switch .zo-car-instructions {
	margin: 0 0 14px;
	font-size: 14px;
	line-height: 1.5;
	text-align: center;
	color: #21415d;
	background: rgba(255, 255, 255, 0.7);
	padding: 10px 12px;
	border-radius: 12px;
}

.zo-game-root--car-lane-switch .zo-car-hud {
	display: flex;
	gap: 10px;
	justify-content: space-between;
	flex-wrap: wrap;
	margin-bottom: 12px;
}

.zo-game-root--car-lane-switch .zo-car-chip {
	flex: 1 1 30%;
	min-width: 120px;
	background: rgba(255, 255, 255, 0.9);
	border-radius: 12px;
	padding: 10px 12px;
	text-align: center;
	box-sizing: border-box;
}

.zo-game-root--car-lane-switch .zo-car-chip-label {
	display: block;
	font-size: 12px;
	color: #4b6072;
	margin-bottom: 4px;
}

.zo-game-root--car-lane-switch .zo-car-chip-value {
	display: block;
	font-size: 20px;
	font-weight: 700;
	color: #17324d;
}

.zo-game-root--car-lane-switch .zo-car-track-wrap {
	position: relative;
}

.zo-game-root--car-lane-switch .zo-car-track {
	position: relative;
	width: 100%;
	height: 460px;
	border-radius: 18px;
	overflow: hidden;
	background:
		linear-gradient(90deg, #4f4f4f 0%, #585858 8%, #4b4b4b 50%, #585858 92%, #4f4f4f 100%);
	box-shadow: inset 0 0 0 4px rgba(255, 255, 255, 0.08);
	touch-action: manipulation;
	user-select: none;
}

.zo-game-root--car-lane-switch .zo-car-grass-left,
.zo-game-root--car-lane-switch .zo-car-grass-right {
	position: absolute;
	top: 0;
	bottom: 0;
	width: 16%;
	background:
		repeating-linear-gradient(
			180deg,
			#68b74d 0px,
			#68b74d 24px,
			#5ca844 24px,
			#5ca844 48px
		);
	z-index: 1;
}

.zo-game-root--car-lane-switch .zo-car-grass-left {
	left: 0;
}

.zo-game-root--car-lane-switch .zo-car-grass-right {
	right: 0;
}

.zo-game-root--car-lane-switch .zo-car-road {
	position: absolute;
	top: 0;
	bottom: 0;
	left: 16%;
	right: 16%;
	z-index: 2;
}

.zo-game-root--car-lane-switch .zo-car-road::before,
.zo-game-root--car-lane-switch .zo-car-road::after {
	content: '';
	position: absolute;
	top: 0;
	bottom: 0;
	width: 6px;
	background:
		repeating-linear-gradient(
			180deg,
			rgba(255, 255, 255, 0.85) 0px,
			rgba(255, 255, 255, 0.85) 26px,
			transparent 26px,
			transparent 52px
		);
	opacity: 0.9;
}

.zo-game-root--car-lane-switch .zo-car-road::before {
	left: 33.333%;
	transform: translateX(-50%);
}

.zo-game-root--car-lane-switch .zo-car-road::after {
	left: 66.666%;
	transform: translateX(-50%);
}

.zo-game-root--car-lane-switch .zo-car-player,
.zo-game-root--car-lane-switch .zo-car-obstacle {
	position: absolute;
	width: 20%;
	max-width: 72px;
	min-width: 54px;
	aspect-ratio: 0.78 / 1;
	transform: translateX(-50%);
	border-radius: 16px 16px 10px 10px;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 34px;
	line-height: 1;
	will-change: top, left, transform;
}

.zo-game-root--car-lane-switch .zo-car-player {
	bottom: 18px;
	z-index: 5;
	background: linear-gradient(180deg, #ff5757 0%, #d71f1f 100%);
	box-shadow:
		inset 0 0 0 3px rgba(255, 255, 255, 0.26),
		0 8px 16px rgba(0, 0, 0, 0.22);
}

.zo-game-root--car-lane-switch .zo-car-player::before,
.zo-game-root--car-lane-switch .zo-car-obstacle::before {
	content: '';
	position: absolute;
	top: 12%;
	left: 18%;
	right: 18%;
	height: 22%;
	border-radius: 10px;
	background: rgba(180, 235, 255, 0.9);
}

.zo-game-root--car-lane-switch .zo-car-player::after,
.zo-game-root--car-lane-switch .zo-car-obstacle::after {
	content: '';
	position: absolute;
	bottom: 10%;
	left: 16%;
	right: 16%;
	height: 12%;
	border-radius: 10px;
	background: rgba(255, 225, 120, 0.92);
}

.zo-game-root--car-lane-switch .zo-car-obstacle {
	top: -120px;
	z-index: 4;
	background: linear-gradient(180deg, #4b7dff 0%, #2248b5 100%);
	box-shadow:
		inset 0 0 0 3px rgba(255, 255, 255, 0.22),
		0 8px 16px rgba(0, 0, 0, 0.2);
}

.zo-game-root--car-lane-switch .zo-car-obstacle--truck {
	background: linear-gradient(180deg, #ffa643 0%, #d76c00 100%);
}

.zo-game-root--car-lane-switch .zo-car-obstacle--oil {
	background: linear-gradient(180deg, #2a2a2a 0%, #000 100%);
	border-radius: 50%;
	aspect-ratio: 1 / 1;
	font-size: 26px;
}

.zo-game-root--car-lane-switch .zo-car-obstacle--oil::before,
.zo-game-root--car-lane-switch .zo-car-obstacle--oil::after {
	display: none;
}

.zo-game-root--car-lane-switch .zo-car-overlay {
	position: absolute;
	inset: 0;
	z-index: 8;
	display: flex;
	align-items: center;
	justify-content: center;
	background: rgba(10, 24, 39, 0.58);
	padding: 18px;
	box-sizing: border-box;
}

.zo-game-root--car-lane-switch .zo-car-overlay[hidden] {
	display: none;
}

.zo-game-root--car-lane-switch .zo-car-panel {
	width: 100%;
	max-width: 320px;
	background: #ffffff;
	border-radius: 18px;
	padding: 18px 16px;
	text-align: center;
	box-shadow: 0 12px 28px rgba(0, 0, 0, 0.22);
}

.zo-game-root--car-lane-switch .zo-car-panel-title {
	margin: 0 0 8px;
	font-size: 24px;
	color: #16304a;
}

.zo-game-root--car-lane-switch .zo-car-panel-text {
	margin: 0 0 14px;
	font-size: 15px;
	line-height: 1.5;
	color: #3e5568;
}

.zo-game-root--car-lane-switch .zo-car-buttons {
	display: flex;
	gap: 10px;
	justify-content: center;
	flex-wrap: wrap;
	margin-top: 14px;
}

.zo-game-root--car-lane-switch .zo-car-btn {
	appearance: none;
	border: 0;
	border-radius: 999px;
	padding: 12px 18px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	background: #17324d;
	color: #fff;
	box-shadow: 0 6px 14px rgba(23, 50, 77, 0.2);
	transition: transform 0.15s ease, opacity 0.15s ease;
}

.zo-game-root--car-lane-switch .zo-car-btn:hover,
.zo-game-root--car-lane-switch .zo-car-btn:focus {
	transform: translateY(-1px);
}

.zo-game-root--car-lane-switch .zo-car-btn:active {
	transform: translateY(1px);
}

.zo-game-root--car-lane-switch .zo-car-btn--accent {
	background: #e44949;
}

.zo-game-root--car-lane-switch .zo-car-controls {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 10px;
	margin-top: 14px;
}

.zo-game-root--car-lane-switch .zo-car-control {
	appearance: none;
	border: 0;
	border-radius: 16px;
	padding: 14px 10px;
	font-size: 16px;
	font-weight: 700;
	cursor: pointer;
	background: rgba(255, 255, 255, 0.88);
	color: #17324d;
	box-shadow: 0 8px 18px rgba(0, 0, 0, 0.12);
}

.zo-game-root--car-lane-switch .zo-car-status {
	margin-top: 12px;
	min-height: 24px;
	text-align: center;
	font-size: 15px;
	font-weight: 700;
	color: #17324d;
}

.zo-game-root--car-lane-switch .zo-car-status.is-danger {
	color: #b21f1f;
}

@media (max-width: 560px) {
	.zo-game-root--car-lane-switch .zo-car-track {
		height: 400px;
	}

	.zo-game-root--car-lane-switch .zo-car-title {
		font-size: 24px;
	}

	.zo-game-root--car-lane-switch .zo-car-player,
	.zo-game-root--car-lane-switch .zo-car-obstacle {
		font-size: 28px;
		min-width: 48px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--car-lane-switch');

	games.forEach(function (game) {
		if (game.dataset.zoCarReady === '1') {
			return;
		}
		game.dataset.zoCarReady = '1';

		const track = game.querySelector('.zo-car-track');
		const road = game.querySelector('.zo-car-road');
		const player = game.querySelector('.zo-car-player');
		const scoreValue = game.querySelector('.zo-car-score');
		const bestValue = game.querySelector('.zo-car-best');
		const speedValue = game.querySelector('.zo-car-speed');
		const status = game.querySelector('.zo-car-status');
		const overlay = game.querySelector('.zo-car-overlay');
		const overlayTitle = game.querySelector('.zo-car-panel-title');
		const overlayText = game.querySelector('.zo-car-panel-text');
		const startBtn = game.querySelector('.zo-car-start');
		const restartBtn = game.querySelector('.zo-car-restart');
		const leftBtn = game.querySelector('.zo-car-left');
		const rightBtn = game.querySelector('.zo-car-right');

		const lanePercents = [16.66, 50, 83.33];
		const obstacleTypes = ['car', 'truck', 'oil'];
		const bestKey = 'zo_car_lane_switch_best';
		let bestScore = 0;

		try {
			bestScore = parseInt(window.localStorage.getItem(bestKey), 10) || 0;
		} catch (err) {
			bestScore = 0;
		}

		let laneIndex = 1;
		let obstacles = [];
		let animationFrame = null;
		let lastTime = 0;
		let spawnTimer = 0;
		let running = false;
		let ended = false;
		let score = 0;
		let speed = 260;

		bestValue.textContent = String(bestScore);

		function setPlayerLane() {
			player.style.left = lanePercents[laneIndex] + '%';
		}

		function setStatus(message, danger) {
			status.textContent = message;
			status.classList.toggle('is-danger', !!danger);
		}

		function updateHud() {
			scoreValue.textContent = String(score);
			speedValue.textContent = String(Math.round(speed / 26));
			bestValue.textContent = String(bestScore);
		}

		function clearObstacles() {
			obstacles.forEach(function (item) {
				if (item.el && item.el.parentNode) {
					item.el.parentNode.removeChild(item.el);
				}
			});
			obstacles = [];
		}

		function showOverlay(title, text, buttonText) {
			overlayTitle.textContent = title;
			overlayText.textContent = text;
			startBtn.textContent = buttonText;
			overlay.hidden = false;
		}

		function hideOverlay() {
			overlay.hidden = true;
		}

		function spawnObstacle() {
			const type = obstacleTypes[Math.floor(Math.random() * obstacleTypes.length)];
			const obstacle = document.createElement('div');
			obstacle.className = 'zo-car-obstacle';

			if (type === 'truck') {
				obstacle.classList.add('zo-car-obstacle--truck');
				obstacle.textContent = '🚚';
			} else if (type === 'oil') {
				obstacle.classList.add('zo-car-obstacle--oil');
				obstacle.textContent = '🛞';
			} else {
				obstacle.textContent = '🚙';
			}

			const lane = Math.floor(Math.random() * 3);
			obstacle.style.left = lanePercents[lane] + '%';
			obstacle.style.top = '-90px';

			road.appendChild(obstacle);

			obstacles.push({
				el: obstacle,
				lane: lane,
				y: -90,
				passed: false,
				height: type === 'oil' ? 52 : 86,
				type: type
			});
		}

		function endGame() {
			running = false;
			ended = true;

			if (animationFrame) {
				cancelAnimationFrame(animationFrame);
				animationFrame = null;
			}

			if (score > bestScore) {
				bestScore = score;
				try {
					window.localStorage.setItem(bestKey, String(bestScore));
				} catch (err) {
					/* no storage */
				}
			}

			updateHud();
			setStatus('Crash. Tap restart and try again.', true);
			showOverlay('Game Over', 'Score: ' + score + ' | Best: ' + bestScore, 'Play Again');
		}

		function resetGame() {
			if (animationFrame) {
				cancelAnimationFrame(animationFrame);
				animationFrame = null;
			}

			running = false;
			ended = false;
			lastTime = 0;
			spawnTimer = 0;
			score = 0;
			speed = 260;
			laneIndex = 1;

			clearObstacles();
			setPlayerLane();
			updateHud();
			setStatus('Use left and right to dodge cars.', false);
			showOverlay('Car Lane Switch', 'Tap Start. Switch lanes and survive as long as you can.', 'Start');
		}

		function startGame() {
			clearObstacles();
			score = 0;
			speed = 260;
			spawnTimer = 0;
			lastTime = 0;
			running = true;
			ended = false;
			laneIndex = 1;
			setPlayerLane();
			updateHud();
			setStatus('Go. Stay away from traffic.', false);
			hideOverlay();
			animationFrame = requestAnimationFrame(loop);
		}

		function moveLeft() {
			if (!running && !ended) {
				return;
			}
			laneIndex = Math.max(0, laneIndex - 1);
			setPlayerLane();
		}

		function moveRight() {
			if (!running && !ended) {
				return;
			}
			laneIndex = Math.min(2, laneIndex + 1);
			setPlayerLane();
		}

		function loop(timestamp) {
			if (!running) {
				return;
			}

			if (!lastTime) {
				lastTime = timestamp;
			}

			const delta = (timestamp - lastTime) / 1000;
			lastTime = timestamp;

			speed += delta * 6;
			spawnTimer += delta;

			const spawnGap = Math.max(0.55, 1.15 - score * 0.015);

			if (spawnTimer >= spawnGap) {
				spawnTimer = 0;
				spawnObstacle();
			}

			const trackHeight = track.clientHeight;
			const playerTop = trackHeight - player.offsetHeight - 18;
			const playerBottom = playerTop + player.offsetHeight - 10;

			obstacles = obstacles.filter(function (item) {
				item.y += speed * delta;
				item.el.style.top = item.y + 'px';

				const itemTop = item.y;
				const itemBottom = item.y + item.height;

				if (!item.passed && itemBottom >= playerTop && itemTop <= playerBottom && item.lane === laneIndex) {
					endGame();
					return false;
				}

				if (!item.passed && itemTop > playerBottom) {
					item.passed = true;
					score += 1;
					if (score > bestScore) {
						bestScore = score;
					}
					updateHud();
				}

				if (itemTop > trackHeight + 120) {
					if (item.el && item.el.parentNode) {
						item.el.parentNode.removeChild(item.el);
					}
					return false;
				}

				return true;
			});

			animationFrame = requestAnimationFrame(loop);
		}

		startBtn.addEventListener('click', function () {
			startGame();
		});

		restartBtn.addEventListener('click', function () {
			resetGame();
		});

		leftBtn.addEventListener('click', function () {
			moveLeft();
		});

		rightBtn.addEventListener('click', function () {
			moveRight();
		});

		game.addEventListener('keydown', function (event) {
			if (event.key === 'ArrowLeft') {
				event.preventDefault();
				moveLeft();
			} else if (event.key === 'ArrowRight') {
				event.preventDefault();
				moveRight();
			} else if (event.key === ' ' || event.key === 'Enter') {
				if (!running) {
					event.preventDefault();
					startGame();
				}
			}
		});

		let touchStartX = 0;
		track.addEventListener('touchstart', function (event) {
			if (!event.changedTouches || !event.changedTouches.length) {
				return;
			}
			touchStartX = event.changedTouches[0].clientX;
		}, { passive: true });

		track.addEventListener('touchend', function (event) {
			if (!event.changedTouches || !event.changedTouches.length) {
				return;
			}
			const touchEndX = event.changedTouches[0].clientX;
			const diff = touchEndX - touchStartX;

			if (Math.abs(diff) < 20) {
				return;
			}

			if (diff < 0) {
				moveLeft();
			} else {
				moveRight();
			}
		}, { passive: true });

		track.addEventListener('click', function (event) {
			if (event.target.closest('.zo-car-overlay')) {
				return;
			}
			const rect = track.getBoundingClientRect();
			const x = event.clientX - rect.left;
			if (x < rect.width / 2) {
				moveLeft();
			} else {
				moveRight();
			}
		});

		setPlayerLane();
		updateHud();
		game.setAttribute('tabindex', '0');
		resetGame();
	});
});
JS;

if (!function_exists('zo_game_car_lane_switch_render')) {
	function zo_game_car_lane_switch_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-car-lane-switch-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--car-lane-switch" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-car-game">
				<h2 class="zo-car-title">Car Lane Switch</h2>
				<p class="zo-car-instructions">Switch lanes to avoid traffic. Use the left and right buttons, arrow keys, tap left or right, or swipe on mobile.</p>

				<div class="zo-car-hud">
					<div class="zo-car-chip">
						<span class="zo-car-chip-label">Score</span>
						<span class="zo-car-chip-value zo-car-score">0</span>
					</div>
					<div class="zo-car-chip">
						<span class="zo-car-chip-label">Best</span>
						<span class="zo-car-chip-value zo-car-best">0</span>
					</div>
					<div class="zo-car-chip">
						<span class="zo-car-chip-label">Speed</span>
						<span class="zo-car-chip-value zo-car-speed">10</span>
					</div>
				</div>

				<div class="zo-car-track-wrap">
					<div class="zo-car-track">
						<div class="zo-car-grass-left" aria-hidden="true"></div>
						<div class="zo-car-road">
							<div class="zo-car-player" aria-hidden="true">🚗</div>
						</div>
						<div class="zo-car-grass-right" aria-hidden="true"></div>

						<div class="zo-car-overlay">
							<div class="zo-car-panel">
								<h3 class="zo-car-panel-title">Car Lane Switch</h3>
								<p class="zo-car-panel-text">Tap Start. Move between 3 lanes and dodge every obstacle.</p>
								<div class="zo-car-buttons">
									<button type="button" class="zo-car-btn zo-car-btn--accent zo-car-start">Start</button>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="zo-car-controls">
					<button type="button" class="zo-car-control zo-car-left">⬅ Left</button>
					<button type="button" class="zo-car-control zo-car-right">Right ➡</button>
				</div>

				<div class="zo-car-buttons">
					<button type="button" class="zo-car-btn zo-car-restart">Restart</button>
				</div>

				<div class="zo-car-status" aria-live="polite">Use left and right to dodge cars.</div>
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
	'description'     => 'An amazing fast lane-switching driving game for kids.',
	'render_callback' => 'zo_game_car_lane_switch_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);