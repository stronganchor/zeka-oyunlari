<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 860px;
	margin: 0 auto;
	text-align: center;
}

.zo-game-root--breakout-blast {
	font-family: Arial, sans-serif;
	background: linear-gradient(180deg, #101522 0%, #1b2540 100%);
	color: #ffffff;
	border-radius: 18px;
	padding: 16px;
	box-sizing: border-box;
}

.zo-game-root--breakout-blast * {
	box-sizing: border-box;
}

.zo-game-root--breakout-blast .bb-title {
	font-size: 30px;
	font-weight: 700;
	margin-bottom: 8px;
	color: #9ddcff;
}

.zo-game-root--breakout-blast .bb-instructions {
	font-size: 15px;
	line-height: 1.5;
	color: #d4dcef;
	margin-bottom: 14px;
}

.zo-game-root--breakout-blast .bb-topbar {
	display: flex;
	justify-content: space-between;
	align-items: center;
	gap: 10px;
	flex-wrap: wrap;
	margin-bottom: 12px;
}

.zo-game-root--breakout-blast .bb-stat {
	background: rgba(255,255,255,0.08);
	border: 1px solid rgba(255,255,255,0.14);
	border-radius: 999px;
	padding: 8px 14px;
	font-size: 15px;
	font-weight: 700;
}

.zo-game-root--breakout-blast .bb-board-wrap {
	position: relative;
	width: 100%;
	max-width: 800px;
	margin: 0 auto;
}

.zo-game-root--breakout-blast .bb-board {
	position: relative;
	width: 100%;
	aspect-ratio: 4 / 3;
	background: #05070d;
	border: 3px solid #3a4d7a;
	border-radius: 16px;
	overflow: hidden;
	touch-action: none;
	box-shadow: inset 0 0 0 2px rgba(255,255,255,0.05);
}

.zo-game-root--breakout-blast .bb-brick {
	position: absolute;
	border-radius: 6px;
	border: 2px solid rgba(255,255,255,0.7);
}

.zo-game-root--breakout-blast .bb-paddle {
	position: absolute;
	background: #ffffff;
	border-radius: 10px;
}

.zo-game-root--breakout-blast .bb-ball {
	position: absolute;
	background: #ffffff;
	border-radius: 50%;
}

.zo-game-root--breakout-blast .bb-overlay {
	position: absolute;
	inset: 0;
	display: flex;
	align-items: center;
	justify-content: center;
	padding: 20px;
	background: rgba(5, 8, 15, 0.78);
}

.zo-game-root--breakout-blast .bb-overlay[hidden] {
	display: none;
}

.zo-game-root--breakout-blast .bb-panel {
	background: rgba(19, 28, 49, 0.96);
	border: 1px solid rgba(255,255,255,0.16);
	border-radius: 18px;
	padding: 20px;
	max-width: 440px;
	width: 100%;
}

.zo-game-root--breakout-blast .bb-panel-title {
	font-size: 34px;
	font-weight: 700;
	margin-bottom: 10px;
}

.zo-game-root--breakout-blast .bb-panel-text {
	font-size: 16px;
	line-height: 1.55;
	color: #d7e1f7;
	margin-bottom: 14px;
}

.zo-game-root--breakout-blast .bb-btn-row {
	display: flex;
	justify-content: center;
	gap: 10px;
	flex-wrap: wrap;
}

.zo-game-root--breakout-blast .bb-btn {
	appearance: none;
	border: 1px solid #6b8de3;
	background: #284785;
	color: #ffffff;
	border-radius: 12px;
	padding: 11px 16px;
	font-size: 16px;
	font-weight: 700;
	cursor: pointer;
	min-width: 140px;
}

.zo-game-root--breakout-blast .bb-btn:hover,
.zo-game-root--breakout-blast .bb-btn:focus {
	background: #3358a5;
	outline: none;
}

.zo-game-root--breakout-blast .bb-controls {
	margin-top: 14px;
	font-size: 14px;
	color: #cad6f3;
	line-height: 1.5;
}

@media (max-width: 640px) {
	.zo-game-root--breakout-blast .bb-title {
		font-size: 26px;
	}

	.zo-game-root--breakout-blast .bb-panel-title {
		font-size: 28px;
	}

	.zo-game-root--breakout-blast .bb-btn {
		width: 100%;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--breakout-blast');

	games.forEach(function (game) {
		const board = game.querySelector('[data-role="board"]');
		const bricksLayer = game.querySelector('[data-role="bricks"]');
		const paddleEl = game.querySelector('[data-role="paddle"]');
		const ballEl = game.querySelector('[data-role="ball"]');
		const scoreEl = game.querySelector('[data-role="score"]');
		const livesEl = game.querySelector('[data-role="lives"]');
		const overlay = game.querySelector('[data-role="overlay"]');
		const overlayTitle = game.querySelector('[data-role="overlay-title"]');
		const overlayText = game.querySelector('[data-role="overlay-text"]');
		const startBtn = game.querySelector('[data-role="start-btn"]');
		const restartBtn = game.querySelector('[data-role="restart-btn"]');

		const CONFIG = {
			width: 800,
			height: 600,
			paddleWidth: 120,
			paddleHeight: 15,
			paddleSpeed: 8,
			ballSize: 16,
			bricksRows: 6,
			bricksCols: 10,
			brickWidth: 70,
			brickHeight: 25,
			brickGap: 8,
			topOffset: 70,
			startLives: 3
		};

		const BRICK_COLORS = ['#f05050', '#ffaa46', '#f0dc5a', '#50dc78', '#50a0ff', '#b464ff'];

		const state = {
			score: 0,
			lives: CONFIG.startLives,
			bricks: [],
			paddle: {
				x: CONFIG.width / 2 - CONFIG.paddleWidth / 2,
				y: CONFIG.height - 50,
				width: CONFIG.paddleWidth,
				height: CONFIG.paddleHeight
			},
			ball: {
				x: CONFIG.width / 2 - CONFIG.ballSize / 2,
				y: CONFIG.height / 2,
				size: CONFIG.ballSize,
				vx: 5,
				vy: -5
			},
			leftPressed: false,
			rightPressed: false,
			pointerActive: false,
			running: false,
			started: false,
			rafId: null
		};

		function randomBallXSpeed() {
			return Math.random() < 0.5 ? -5 : 5;
		}

		function createBricks() {
			const bricks = [];
			const totalWidth = CONFIG.bricksCols * CONFIG.brickWidth + (CONFIG.bricksCols - 1) * CONFIG.brickGap;
			const startX = (CONFIG.width - totalWidth) / 2;

			for (let row = 0; row < CONFIG.bricksRows; row++) {
				for (let col = 0; col < CONFIG.bricksCols; col++) {
					bricks.push({
						x: startX + col * (CONFIG.brickWidth + CONFIG.brickGap),
						y: CONFIG.topOffset + row * (CONFIG.brickHeight + CONFIG.brickGap),
						width: CONFIG.brickWidth,
						height: CONFIG.brickHeight,
						color: BRICK_COLORS[row % BRICK_COLORS.length]
					});
				}
			}

			return bricks;
		}

		function resetBallAndPaddle() {
			state.paddle.x = CONFIG.width / 2 - CONFIG.paddleWidth / 2;
			state.paddle.y = CONFIG.height - 50;
			state.ball.x = CONFIG.width / 2 - CONFIG.ballSize / 2;
			state.ball.y = CONFIG.height / 2;
			state.ball.vx = randomBallXSpeed();
			state.ball.vy = -5;
		}

		function resetGame() {
			state.score = 0;
			state.lives = CONFIG.startLives;
			state.bricks = createBricks();
			state.started = false;
			state.running = false;
			resetBallAndPaddle();
			updateHud();
			render();
			showOverlay(
				'Breakout',
				'Move with Left and Right arrows, or drag on mobile. Break all the bricks with the ball.',
				true
			);
		}

		function updateHud() {
			scoreEl.textContent = String(state.score);
			livesEl.textContent = String(state.lives);
		}

		function scaleX(value) {
			return (value / CONFIG.width) * 100;
		}

		function scaleY(value) {
			return (value / CONFIG.height) * 100;
		}

		function render() {
			paddleEl.style.left = scaleX(state.paddle.x) + '%';
			paddleEl.style.top = scaleY(state.paddle.y) + '%';
			paddleEl.style.width = scaleX(state.paddle.width) + '%';
			paddleEl.style.height = scaleY(state.paddle.height) + '%';

			ballEl.style.left = scaleX(state.ball.x) + '%';
			ballEl.style.top = scaleY(state.ball.y) + '%';
			ballEl.style.width = scaleX(state.ball.size) + '%';
			ballEl.style.height = scaleY(state.ball.size) + '%';

			bricksLayer.innerHTML = '';
			state.bricks.forEach(function (brick) {
				const el = document.createElement('div');
				el.className = 'bb-brick';
				el.style.left = scaleX(brick.x) + '%';
				el.style.top = scaleY(brick.y) + '%';
				el.style.width = scaleX(brick.width) + '%';
				el.style.height = scaleY(brick.height) + '%';
				el.style.background = brick.color;
				bricksLayer.appendChild(el);
			});
		}

		function showOverlay(title, text, startVisible) {
			overlayTitle.textContent = title;
			overlayText.textContent = text;
			startBtn.hidden = !startVisible;
			restartBtn.hidden = false;
			overlay.hidden = false;
		}

		function hideOverlay() {
			overlay.hidden = true;
		}

		function rectsIntersect(a, b) {
			return (
				a.x < b.x + b.width &&
				a.x + a.width > b.x &&
				a.y < b.y + b.height &&
				a.y + a.height > b.y
			);
		}

		function ballRect() {
			return {
				x: state.ball.x,
				y: state.ball.y,
				width: state.ball.size,
				height: state.ball.size
			};
		}

		function paddleRect() {
			return {
				x: state.paddle.x,
				y: state.paddle.y,
				width: state.paddle.width,
				height: state.paddle.height
			};
		}

		function updatePaddle() {
			if (state.leftPressed) {
				state.paddle.x -= CONFIG.paddleSpeed;
			}
			if (state.rightPressed) {
				state.paddle.x += CONFIG.paddleSpeed;
			}

			if (state.paddle.x < 0) {
				state.paddle.x = 0;
			}
			if (state.paddle.x + state.paddle.width > CONFIG.width) {
				state.paddle.x = CONFIG.width - state.paddle.width;
			}
		}

		function updateBall() {
			state.ball.x += state.ball.vx;
			state.ball.y += state.ball.vy;

			if (state.ball.x <= 0) {
				state.ball.x = 0;
				state.ball.vx *= -1;
			}
			if (state.ball.x + state.ball.size >= CONFIG.width) {
				state.ball.x = CONFIG.width - state.ball.size;
				state.ball.vx *= -1;
			}
			if (state.ball.y <= 0) {
				state.ball.y = 0;
				state.ball.vy *= -1;
			}

			const bRect = ballRect();
			const pRect = paddleRect();

			if (rectsIntersect(bRect, pRect) && state.ball.vy > 0) {
				state.ball.y = state.paddle.y - state.ball.size;
				state.ball.vy *= -1;

				const offset = ((state.ball.x + state.ball.size / 2) - (state.paddle.x + state.paddle.width / 2)) / (state.paddle.width / 2);
				state.ball.vx = Math.round(offset * 6);
				if (state.ball.vx === 0) {
					state.ball.vx = Math.random() < 0.5 ? -2 : 2;
				}
			}

			for (let i = 0; i < state.bricks.length; i++) {
				const brick = state.bricks[i];
				if (!rectsIntersect(ballRect(), brick)) {
					continue;
				}

				state.bricks.splice(i, 1);
				state.score += 10;
				updateHud();

				const ballBottom = state.ball.y + state.ball.size;
				const ballTop = state.ball.y;

				if (Math.abs(ballBottom - brick.y) < 10 && state.ball.vy > 0) {
					state.ball.vy *= -1;
				} else if (Math.abs(ballTop - (brick.y + brick.height)) < 10 && state.ball.vy < 0) {
					state.ball.vy *= -1;
				} else {
					state.ball.vx *= -1;
				}
				break;
			}

			if (state.ball.y > CONFIG.height) {
				state.lives -= 1;
				updateHud();

				if (state.lives <= 0) {
					stopLoop();
					showOverlay('Game Over', 'Final Score: ' + state.score, false);
					return;
				}

				resetBallAndPaddle();
			}

			if (state.bricks.length === 0) {
				stopLoop();
				showOverlay('You Win', 'Final Score: ' + state.score, false);
			}
		}

		function tick() {
			if (!state.running) {
				return;
			}

			updatePaddle();
			updateBall();
			render();

			if (state.running) {
				state.rafId = window.requestAnimationFrame(tick);
			}
		}

		function startLoop() {
			if (state.running) {
				return;
			}
			state.running = true;
			state.started = true;
			hideOverlay();
			state.rafId = window.requestAnimationFrame(tick);
		}

		function stopLoop() {
			state.running = false;
			if (state.rafId) {
				window.cancelAnimationFrame(state.rafId);
				state.rafId = null;
			}
		}

		function movePaddleToPointer(clientX) {
			const rect = board.getBoundingClientRect();
			const x = ((clientX - rect.left) / rect.width) * CONFIG.width;
			state.paddle.x = x - state.paddle.width / 2;

			if (state.paddle.x < 0) {
				state.paddle.x = 0;
			}
			if (state.paddle.x + state.paddle.width > CONFIG.width) {
				state.paddle.x = CONFIG.width - state.paddle.width;
			}

			render();
		}

		game.addEventListener('keydown', function (e) {
			if (e.key === 'ArrowLeft') {
				state.leftPressed = true;
				e.preventDefault();
			}
			if (e.key === 'ArrowRight') {
				state.rightPressed = true;
				e.preventDefault();
			}
			if (e.key === ' ' || e.key === 'Spacebar') {
				if (!state.running && overlay.hidden === false) {
					startLoop();
				}
				e.preventDefault();
			}
		});

		game.addEventListener('keyup', function (e) {
			if (e.key === 'ArrowLeft') {
				state.leftPressed = false;
			}
			if (e.key === 'ArrowRight') {
				state.rightPressed = false;
			}
		});

		board.addEventListener('pointerdown', function (e) {
			state.pointerActive = true;
			movePaddleToPointer(e.clientX);
			board.setPointerCapture(e.pointerId);
		});

		board.addEventListener('pointermove', function (e) {
			if (!state.pointerActive) {
				return;
			}
			movePaddleToPointer(e.clientX);
		});

		board.addEventListener('pointerup', function () {
			state.pointerActive = false;
		});

		board.addEventListener('pointercancel', function () {
			state.pointerActive = false;
		});

		startBtn.addEventListener('click', function () {
			startLoop();
			game.focus();
		});

		restartBtn.addEventListener('click', function () {
			stopLoop();
			resetGame();
			game.focus();
		});

		resetGame();
	});
});
JS;

if (!function_exists('zo_game_breakout_blast_render')) {
	function zo_game_breakout_blast_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-breakout-blast-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--breakout-blast" id="<?php echo esc_attr($instance_id); ?>" tabindex="0">
			<div class="bb-title">Breakout Blast</div>
			<div class="bb-instructions">Break every brick with the ball. Use Left and Right arrows on desktop, or drag inside the board on mobile.</div>

			<div class="bb-topbar">
				<div class="bb-stat">Score: <span data-role="score">0</span></div>
				<div class="bb-stat">Lives: <span data-role="lives">3</span></div>
			</div>

			<div class="bb-board-wrap">
				<div class="bb-board" data-role="board">
					<div data-role="bricks"></div>
					<div class="bb-paddle" data-role="paddle"></div>
					<div class="bb-ball" data-role="ball"></div>

					<div class="bb-overlay" data-role="overlay">
						<div class="bb-panel">
							<div class="bb-panel-title" data-role="overlay-title">Breakout</div>
							<div class="bb-panel-text" data-role="overlay-text">Move paddle with Left and Right arrows. Break all the bricks with the ball.</div>
							<div class="bb-btn-row">
								<button type="button" class="bb-btn" data-role="start-btn">Start</button>
								<button type="button" class="bb-btn" data-role="restart-btn">Restart</button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="bb-controls">Restart is always available. Win by clearing all bricks. Lose when lives reach zero.</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'breakout-blast',
	'name'            => 'Breakout Blast',
	'author'          => 'Arslan',
	'description'     => 'A browser-based breakout game with score, lives, restart, and mobile support.',
	'render_callback' => 'zo_game_breakout_blast_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);