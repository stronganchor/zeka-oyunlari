<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 720px;
	margin: 0 auto;
	text-align: center;
}

.zo-game-root--dodge-the-blocks {
	font-family: Arial, sans-serif;
	background: #111827;
	color: #ffffff;
	border-radius: 18px;
	padding: 16px;
	box-sizing: border-box;
}

.zo-game-root--dodge-the-blocks * {
	box-sizing: border-box;
}

.zo-game-root--dodge-the-blocks .dtb-title {
	font-size: 30px;
	font-weight: 700;
	margin-bottom: 8px;
	color: #ffffff;
}

.zo-game-root--dodge-the-blocks .dtb-instructions {
	font-size: 15px;
	line-height: 1.5;
	color: #d1d5db;
	margin-bottom: 14px;
}

.zo-game-root--dodge-the-blocks .dtb-topbar {
	display: flex;
	justify-content: center;
	gap: 12px;
	flex-wrap: wrap;
	margin-bottom: 14px;
}

.zo-game-root--dodge-the-blocks .dtb-stat {
	background: rgba(255,255,255,0.08);
	border: 1px solid rgba(255,255,255,0.12);
	border-radius: 999px;
	padding: 10px 16px;
	font-size: 16px;
	font-weight: 700;
	min-width: 120px;
}

.zo-game-root--dodge-the-blocks .dtb-board-wrap {
	position: relative;
	width: 100%;
	max-width: 640px;
	margin: 0 auto 14px;
}

.zo-game-root--dodge-the-blocks .dtb-board {
	position: relative;
	width: 100%;
	aspect-ratio: 640 / 420;
	background: #111827;
	border: 3px solid #374151;
	border-radius: 16px;
	overflow: hidden;
	touch-action: none;
	user-select: none;
}

.zo-game-root--dodge-the-blocks .dtb-grid-line {
	position: absolute;
	top: 0;
	bottom: 0;
	width: 1px;
	background: #374151;
	opacity: 0.9;
}

.zo-game-root--dodge-the-blocks .dtb-player,
.zo-game-root--dodge-the-blocks .dtb-obstacle {
	position: absolute;
}

.zo-game-root--dodge-the-blocks .dtb-player {
	background: #ffffff;
	border-radius: 4px;
}

.zo-game-root--dodge-the-blocks .dtb-obstacle {
	background: #ef4444;
	border-radius: 4px;
}

.zo-game-root--dodge-the-blocks .dtb-overlay {
	position: absolute;
	inset: 0;
	display: flex;
	align-items: center;
	justify-content: center;
	padding: 20px;
	background: rgba(0, 0, 0, 0.45);
	z-index: 5;
}

.zo-game-root--dodge-the-blocks .dtb-overlay[hidden] {
	display: none;
}

.zo-game-root--dodge-the-blocks .dtb-panel {
	background: rgba(24, 28, 36, 0.95);
	border: 1px solid rgba(255,255,255,0.12);
	border-radius: 18px;
	padding: 22px;
	max-width: 520px;
	width: 100%;
}

.zo-game-root--dodge-the-blocks .dtb-panel-title {
	font-size: 32px;
	font-weight: 700;
	margin-bottom: 10px;
}

.zo-game-root--dodge-the-blocks .dtb-panel-text {
	font-size: 16px;
	line-height: 1.5;
	color: #e5e7eb;
	margin-bottom: 14px;
}

.zo-game-root--dodge-the-blocks .dtb-btn-row {
	display: flex;
	justify-content: center;
	gap: 10px;
	flex-wrap: wrap;
}

.zo-game-root--dodge-the-blocks .dtb-btn {
	appearance: none;
	border: 1px solid #5578d8;
	background: #2c4f9e;
	color: #fff;
	border-radius: 12px;
	padding: 12px 18px;
	font-size: 16px;
	font-weight: 700;
	cursor: pointer;
	min-width: 150px;
}

.zo-game-root--dodge-the-blocks .dtb-btn:hover,
.zo-game-root--dodge-the-blocks .dtb-btn:focus {
	background: #3a63c2;
	outline: none;
}

.zo-game-root--dodge-the-blocks .dtb-mobile-controls {
	display: flex;
	justify-content: center;
	gap: 12px;
	flex-wrap: wrap;
}

.zo-game-root--dodge-the-blocks .dtb-move {
	appearance: none;
	border: 1px solid #4b5563;
	background: #1f2937;
	color: #fff;
	border-radius: 12px;
	padding: 12px 22px;
	font-size: 18px;
	font-weight: 700;
	cursor: pointer;
	min-width: 110px;
}

.zo-game-root--dodge-the-blocks .dtb-move:hover,
.zo-game-root--dodge-the-blocks .dtb-move:focus {
	background: #374151;
	outline: none;
}

.zo-game-root--dodge-the-blocks .dtb-controls {
	font-size: 14px;
	color: #cbd5e1;
	line-height: 1.5;
	margin-top: 12px;
}

@media (max-width: 640px) {
	.zo-game-root--dodge-the-blocks .dtb-title {
		font-size: 26px;
	}

	.zo-game-root--dodge-the-blocks .dtb-panel-title {
		font-size: 28px;
	}

	.zo-game-root--dodge-the-blocks .dtb-btn,
	.zo-game-root--dodge-the-blocks .dtb-move {
		width: 100%;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--dodge-the-blocks');

	games.forEach(function (game) {
		const CONFIG = {
			width: 640,
			height: 420,
			fps: 60,
			playerSize: 18,
			obstacleSize: 16,
			step: 18,
			laneGap: 8
		};

		const board = game.querySelector('[data-role="board"]');
		const gridLayer = game.querySelector('[data-role="grid"]');
		const playerEl = game.querySelector('[data-role="player"]');
		const obstaclesLayer = game.querySelector('[data-role="obstacles"]');
		const scoreEl = game.querySelector('[data-role="score"]');
		const bestEl = game.querySelector('[data-role="best"]');
		const overlay = game.querySelector('[data-role="overlay"]');
		const overlayTitle = game.querySelector('[data-role="overlay-title"]');
		const overlayText = game.querySelector('[data-role="overlay-text"]');
		const startBtn = game.querySelector('[data-role="start-btn"]');
		const restartBtn = game.querySelector('[data-role="restart-btn"]');
		const leftBtn = game.querySelector('[data-role="move-left"]');
		const rightBtn = game.querySelector('[data-role="move-right"]');

		const state = {
			playerX: (CONFIG.width - CONFIG.playerSize) / 2,
			playerY: CONFIG.height - CONFIG.playerSize - 8,
			obstacles: [],
			running: false,
			gameOver: false,
			spawnTimer: 0,
			scoreFrames: 0,
			bestScore: 0,
			lastTimestamp: 0,
			rafId: null,
			pointerId: null
		};

		function lanesCount() {
			return Math.max(1, Math.floor(CONFIG.width / (CONFIG.obstacleSize + CONFIG.laneGap)));
		}

		function scoreDisplayValue() {
			return Math.floor(state.scoreFrames / CONFIG.fps);
		}

		function clamp(value, min, max) {
			return Math.max(min, Math.min(max, value));
		}

		function scaleX(value) {
			return (value / CONFIG.width) * 100;
		}

		function scaleY(value) {
			return (value / CONFIG.height) * 100;
		}

		function playerRect() {
			return {
				x: state.playerX,
				y: state.playerY,
				width: CONFIG.playerSize,
				height: CONFIG.playerSize
			};
		}

		function rectsIntersect(a, b) {
			return (
				a.x < b.x + b.width &&
				a.x + a.width > b.x &&
				a.y < b.y + b.height &&
				a.y + a.height > b.y
			);
		}

		function drawGrid() {
			gridLayer.innerHTML = '';
			for (let x = 0; x < CONFIG.width; x += 20) {
				const line = document.createElement('div');
				line.className = 'dtb-grid-line';
				line.style.left = scaleX(x) + '%';
				gridLayer.appendChild(line);
			}
		}

		function spawnObstacle() {
			const lanes = lanesCount();
			const laneIndex = Math.floor(Math.random() * lanes);
			const x = laneIndex * (CONFIG.obstacleSize + CONFIG.laneGap);
			const speed = 120 + Math.min(400, state.scoreFrames * 0.06);

			state.obstacles.push({
				x: x,
				y: -CONFIG.obstacleSize,
				v: speed
			});
		}

		function moveLeft() {
			state.playerX = Math.max(0, state.playerX - CONFIG.step);
			renderPlayer();
		}

		function moveRight() {
			state.playerX = Math.min(CONFIG.width - CONFIG.playerSize, state.playerX + CONFIG.step);
			renderPlayer();
		}

		function resetForRun() {
			state.playerX = (CONFIG.width - CONFIG.playerSize) / 2;
			state.playerY = CONFIG.height - CONFIG.playerSize - 8;
			state.obstacles = [];
			state.running = true;
			state.gameOver = false;
			state.spawnTimer = 0;
			state.scoreFrames = 0;
			state.lastTimestamp = 0;
			updateHud();
			hideOverlay();
			render();
		}

		function stopLoop() {
			if (state.rafId) {
				window.cancelAnimationFrame(state.rafId);
				state.rafId = null;
			}
		}

		function startGame() {
			resetForRun();
			stopLoop();
			state.rafId = window.requestAnimationFrame(loop);
		}

		function endGame() {
			state.gameOver = true;
			state.running = false;
			const finalScore = scoreDisplayValue();
			state.bestScore = Math.max(state.bestScore, finalScore);
			updateHud();
			showOverlay('Game Over — Score: ' + finalScore, 'Press Space, Enter, or Restart to play again.', false);
		}

		function showOverlay(title, text, showStart) {
			overlayTitle.textContent = title;
			overlayText.textContent = text;
			startBtn.hidden = !showStart;
			restartBtn.hidden = false;
			overlay.hidden = false;
		}

		function hideOverlay() {
			overlay.hidden = true;
		}

		function updateHud() {
			scoreEl.textContent = String(scoreDisplayValue());
			bestEl.textContent = String(state.bestScore);
		}

		function update(dt) {
			if (!state.running || state.gameOver) {
				return;
			}

			state.spawnTimer += dt;
			const spawnEvery = Math.max(120, 350 - state.scoreFrames * 0.6);

			if (state.spawnTimer >= spawnEvery) {
				state.spawnTimer = 0;
				spawnObstacle();
			}

			for (let i = 0; i < state.obstacles.length; i++) {
				state.obstacles[i].y += state.obstacles[i].v * dt / 1000;
			}

			state.obstacles = state.obstacles.filter(function (o) {
				return o.y < CONFIG.height + CONFIG.obstacleSize;
			});

			const player = playerRect();

			for (let i = 0; i < state.obstacles.length; i++) {
				const o = state.obstacles[i];
				const obstacleRect = {
					x: o.x,
					y: o.y,
					width: CONFIG.obstacleSize,
					height: CONFIG.obstacleSize
				};

				if (rectsIntersect(player, obstacleRect)) {
					endGame();
					return;
				}
			}

			state.scoreFrames += Math.max(1, Math.floor(dt / 16));
			updateHud();
		}

		function renderPlayer() {
			playerEl.style.left = scaleX(state.playerX) + '%';
			playerEl.style.top = scaleY(state.playerY) + '%';
			playerEl.style.width = scaleX(CONFIG.playerSize) + '%';
			playerEl.style.height = scaleY(CONFIG.playerSize) + '%';
		}

		function renderObstacles() {
			obstaclesLayer.innerHTML = '';

			state.obstacles.forEach(function (o) {
				const el = document.createElement('div');
				el.className = 'dtb-obstacle';
				el.style.left = scaleX(o.x) + '%';
				el.style.top = scaleY(o.y) + '%';
				el.style.width = scaleX(CONFIG.obstacleSize) + '%';
				el.style.height = scaleY(CONFIG.obstacleSize) + '%';
				obstaclesLayer.appendChild(el);
			});
		}

		function render() {
			renderPlayer();
			renderObstacles();
		}

		function loop(timestamp) {
			if (!state.running) {
				return;
			}

			if (!state.lastTimestamp) {
				state.lastTimestamp = timestamp;
			}

			const dt = timestamp - state.lastTimestamp;
			state.lastTimestamp = timestamp;

			update(dt);
			render();

			if (state.running) {
				state.rafId = window.requestAnimationFrame(loop);
			}
		}

		function pointerMoveTo(clientX) {
			const rect = board.getBoundingClientRect();
			const x = ((clientX - rect.left) / rect.width) * CONFIG.width;
			const snapped = Math.round(x / CONFIG.step) * CONFIG.step;
			state.playerX = clamp(snapped, 0, CONFIG.width - CONFIG.playerSize);
			renderPlayer();
		}

		game.addEventListener('keydown', function (e) {
			if (e.key === 'ArrowLeft' || e.key === 'a' || e.key === 'A') {
				moveLeft();
				e.preventDefault();
			} else if (e.key === 'ArrowRight' || e.key === 'd' || e.key === 'D') {
				moveRight();
				e.preventDefault();
			} else if (e.key === ' ' || e.key === 'Enter') {
				if (state.gameOver || !state.running) {
					startGame();
				}
				e.preventDefault();
			}
		});

		leftBtn.addEventListener('click', function () {
			moveLeft();
			game.focus();
		});

		rightBtn.addEventListener('click', function () {
			moveRight();
			game.focus();
		});

		startBtn.addEventListener('click', function () {
			startGame();
			game.focus();
		});

		restartBtn.addEventListener('click', function () {
			startGame();
			game.focus();
		});

		board.addEventListener('pointerdown', function (e) {
			state.pointerId = e.pointerId;
			board.setPointerCapture(e.pointerId);
			pointerMoveTo(e.clientX);
			game.focus();
		});

		board.addEventListener('pointermove', function (e) {
			if (state.pointerId === e.pointerId) {
				pointerMoveTo(e.clientX);
			}
		});

		board.addEventListener('pointerup', function (e) {
			if (state.pointerId === e.pointerId) {
				state.pointerId = null;
			}
		});

		board.addEventListener('pointercancel', function (e) {
			if (state.pointerId === e.pointerId) {
				state.pointerId = null;
			}
		});

		drawGrid();
		updateHud();
		render();
		showOverlay('Ready?', 'Press Space to start. Use Arrow keys or A and D to move.', true);
	});
});
JS;

if (!function_exists('zo_game_dodge_the_blocks_render')) {
	function zo_game_dodge_the_blocks_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-dodge-the-blocks-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--dodge-the-blocks" id="<?php echo esc_attr($instance_id); ?>" tabindex="0">
			<div class="dtb-title">Dodge The Blocks</div>
			<div class="dtb-instructions">Move left and right to avoid falling red blocks. Use Arrow keys or A and D. Press Space or Enter to start and restart.</div>

			<div class="dtb-topbar">
				<div class="dtb-stat">Score: <span data-role="score">0</span></div>
				<div class="dtb-stat">Best: <span data-role="best">0</span></div>
			</div>

			<div class="dtb-board-wrap">
				<div class="dtb-board" data-role="board">
					<div data-role="grid"></div>
					<div data-role="obstacles"></div>
					<div class="dtb-player" data-role="player"></div>

					<div class="dtb-overlay" data-role="overlay">
						<div class="dtb-panel">
							<div class="dtb-panel-title" data-role="overlay-title">Ready?</div>
							<div class="dtb-panel-text" data-role="overlay-text">Press Space to start. Use Arrow keys or A and D to move.</div>
							<div class="dtb-btn-row">
								<button type="button" class="dtb-btn" data-role="start-btn">Start</button>
								<button type="button" class="dtb-btn" data-role="restart-btn">Restart</button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="dtb-mobile-controls">
				<button type="button" class="dtb-move" data-role="move-left">← Left</button>
				<button type="button" class="dtb-move" data-role="move-right">Right →</button>
			</div>

			<div class="dtb-controls">Desktop: Arrow keys or A and D. Mobile: tap buttons or drag inside the board.</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'dodge-the-blocks',
	'name'            => 'Dodge The Blocks',
	'author'          => 'Arslan',
	'description'     => 'A browser-based dodge game where you avoid falling red blocks.',
	'render_callback' => 'zo_game_dodge_the_blocks_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);