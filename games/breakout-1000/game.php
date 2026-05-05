<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--breakout-1000 {
	width: min(100%, 1040px);
	margin: 0 auto;
	padding: 14px;
	box-sizing: border-box;
	border: 2px solid #1e293b;
	border-radius: 8px;
	background: #0a0a10;
	color: #f8fafc;
	font-family: Arial, sans-serif;
}

.zo-game-root--breakout-1000 * {
	box-sizing: border-box;
}

.zo-b1000-head {
	display: grid;
	grid-template-columns: 1fr auto;
	gap: 12px;
	align-items: end;
	margin-bottom: 10px;
}

.zo-b1000-title {
	margin: 0;
	font-size: clamp(26px, 4vw, 42px);
	line-height: 1.05;
}

.zo-b1000-subtitle {
	margin: 6px 0 0;
	color: #94a3b8;
	font-size: 14px;
	line-height: 1.4;
}

.zo-b1000-stats {
	display: flex;
	flex-wrap: wrap;
	justify-content: flex-end;
	gap: 8px;
}

.zo-b1000-stat {
	min-width: 104px;
	padding: 8px 10px;
	border: 1px solid #334155;
	border-radius: 8px;
	background: #111827;
	text-align: center;
}

.zo-b1000-stat span {
	display: block;
	margin-top: 2px;
	font-size: 20px;
	font-weight: 700;
	color: #ffffff;
}

.zo-b1000-canvas-wrap {
	position: relative;
	overflow: hidden;
	border: 2px solid #1e293b;
	border-radius: 8px;
	background: #050712;
}

.zo-b1000-canvas {
	display: block;
	width: 100%;
	aspect-ratio: 900 / 650;
	background: #0a0a10;
	touch-action: none;
}

.zo-b1000-controls {
	display: grid;
	grid-template-columns: repeat(5, minmax(0, 1fr));
	gap: 8px;
	margin-top: 10px;
}

.zo-b1000-button {
	min-height: 42px;
	border: 0;
	border-radius: 8px;
	background: #1f2937;
	color: #f8fafc;
	font-weight: 700;
	cursor: pointer;
}

.zo-b1000-button--launch {
	background: #0891b2;
}

.zo-b1000-button--restart {
	background: #4f46e5;
}

.zo-b1000-button--pause {
	background: #ca8a04;
}

.zo-b1000-button--move {
	background: #2563eb;
}

.zo-b1000-status {
	min-height: 24px;
	margin-top: 10px;
	text-align: center;
	color: #cbd5e1;
	font-weight: 700;
}

.zo-b1000-help {
	margin-top: 8px;
	color: #94a3b8;
	font-size: 13px;
	line-height: 1.45;
	text-align: center;
}

@media (max-width: 760px) {
	.zo-b1000-head {
		grid-template-columns: 1fr;
	}

	.zo-b1000-stats {
		justify-content: flex-start;
	}

	.zo-b1000-controls {
		grid-template-columns: 1fr 1fr;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	document.querySelectorAll('.zo-game-root--breakout-1000').forEach(function (root) {
		if (root.dataset.ready === '1') {
			return;
		}
		root.dataset.ready = '1';

		const canvas = root.querySelector('.zo-b1000-canvas');
		const ctx = canvas.getContext('2d');
		const levelEl = root.querySelector('[data-level]');
		const scoreEl = root.querySelector('[data-score]');
		const livesEl = root.querySelector('[data-lives]');
		const blocksEl = root.querySelector('[data-blocks]');
		const statusEl = root.querySelector('.zo-b1000-status');
		const buttons = {
			launch: root.querySelector('[data-launch]'),
			restart: root.querySelector('[data-restart]'),
			pause: root.querySelector('[data-pause]'),
			left: root.querySelector('[data-left]'),
			right: root.querySelector('[data-right]')
		};

		const WIDTH = 900;
		const HEIGHT = 650;
		const PADDLE_WIDTH = 130;
		const PADDLE_HEIGHT = 16;
		const PADDLE_SPEED = 540;
		const BALL_RADIUS = 8;
		const START_LIVES = 3;
		const BRICK_ROWS = 8;
		const BRICK_COLS = 12;
		const BRICK_GAP = 5;
		const BRICK_TOP = 80;
		const BRICK_LEFT = 45;
		const BRICK_HEIGHT = 24;
		const MAX_LEVELS = 1000;
		const BRICK_COLORS = ['#dc3c3c', '#f08c2d', '#f0d246', '#46d26e', '#5096f0', '#aa64f0', '#f064b4', '#50dcdc'];

		canvas.width = WIDTH;
		canvas.height = HEIGHT;

		let paddle;
		let ball;
		let bricks;
		let texts;
		let level;
		let score;
		let lives;
		let paused;
		let gameOver;
		let wonAll;
		let leftDown;
		let rightDown;
		let lastTime;

		function seededRandom(seed) {
			let value = seed % 2147483647;
			if (value <= 0) {
				value += 2147483646;
			}
			return function () {
				value = value * 16807 % 2147483647;
				return (value - 1) / 2147483646;
			};
		}

		function randomChoice(values) {
			return values[Math.floor(Math.random() * values.length)];
		}

		function rectsOverlap(a, b) {
			return a.x < b.x + b.w && a.x + a.w > b.x && a.y < b.y + b.h && a.y + a.h > b.y;
		}

		function ballRect() {
			return {
				x: ball.x - BALL_RADIUS,
				y: ball.y - BALL_RADIUS,
				w: BALL_RADIUS * 2,
				h: BALL_RADIUS * 2
			};
		}

		function makePaddle() {
			return {
				w: PADDLE_WIDTH,
				h: PADDLE_HEIGHT,
				x: WIDTH / 2 - PADDLE_WIDTH / 2,
				y: HEIGHT - 60
			};
		}

		function resetBall() {
			ball = {
				x: WIDTH / 2,
				y: HEIGHT - 90,
				dx: randomChoice([-1, 1]) * 3.5 * 60,
				dy: -4.5 * 60,
				stuck: true
			};
		}

		function generateLevel(levelNumber) {
			const rng = seededRandom(levelNumber * 99991);
			const brickWidth = Math.floor((WIDTH - BRICK_LEFT * 2 - BRICK_GAP * (BRICK_COLS - 1)) / BRICK_COLS);
			const difficulty = Math.min(1, levelNumber / MAX_LEVELS);
			const generated = [];

			for (let row = 0; row < BRICK_ROWS; row++) {
				for (let col = 0; col < BRICK_COLS; col++) {
					const patternType = levelNumber % 10;
					let include = true;

					if (patternType === 1) {
						include = (row + col + levelNumber) % 2 === 0;
					} else if (patternType === 2) {
						include = row === col % BRICK_ROWS || row === (BRICK_COLS - 1 - col) % BRICK_ROWS;
					} else if (patternType === 3) {
						include = [0, 1, 6, 7].indexOf(row) !== -1 || [0, 1, 10, 11].indexOf(col) !== -1;
					} else if (patternType === 4) {
						include = Math.abs(col - (BRICK_COLS / 2 - 0.5)) + Math.abs(row - (BRICK_ROWS / 2 - 0.5)) < 6;
					} else if (patternType === 5) {
						include = rng() > 0.25;
					} else if (patternType === 6) {
						include = col % 3 !== row % 3;
					} else if (patternType === 7) {
						include = row <= col % BRICK_ROWS;
					} else if (patternType === 8) {
						include = row >= col % BRICK_ROWS || rng() > 0.65;
					} else if (patternType === 9) {
						include = Math.sin((col + levelNumber) * 0.9) + row / 2 > 1.5;
					}

					if (!include) {
						continue;
					}

					let hits = 1;
					const hitChance = difficulty * 0.75 + row * 0.04;
					if (rng() < hitChance) hits = 2;
					if (levelNumber > 100 && rng() < difficulty * 0.35) hits = 3;
					if (levelNumber > 400 && rng() < difficulty * 0.20) hits = 4;
					if (levelNumber > 750 && rng() < difficulty * 0.12) hits = 5;

					const roll = rng();
					let special = null;
					if (roll < 0.012) special = 'life';
					else if (roll < 0.04) special = 'wide';
					else if (roll < 0.07) special = 'slow';

					generated.push({
						x: BRICK_LEFT + col * (brickWidth + BRICK_GAP),
						y: BRICK_TOP + row * (BRICK_HEIGHT + BRICK_GAP),
						w: brickWidth,
						h: BRICK_HEIGHT,
						hits: hits,
						maxHits: hits,
						color: BRICK_COLORS[(row + col + levelNumber) % BRICK_COLORS.length],
						special: special
					});
				}
			}

			return generated.length < 10 ? generateLevel(levelNumber + 10) : generated;
		}

		function resetGame() {
			level = 1;
			score = 0;
			lives = START_LIVES;
			paddle = makePaddle();
			resetBall();
			bricks = generateLevel(level);
			texts = [];
			paused = false;
			gameOver = false;
			wonAll = false;
			leftDown = false;
			rightDown = false;
			statusEl.textContent = 'Level 1 ready. Press Space or Launch.';
			updateHud();
		}

		function nextLevel() {
			level += 1;
			if (level > MAX_LEVELS) {
				wonAll = true;
				statusEl.textContent = 'You beat all 1000 levels!';
				return;
			}
			bricks = generateLevel(level);
			resetBall();
			const shrink = Math.min(60, Math.floor(level / 20));
			paddle.w = PADDLE_WIDTH - shrink;
			paddle.x = WIDTH / 2 - paddle.w / 2;
			statusEl.textContent = 'Level ' + level + ' ready. Launch the ball.';
		}

		function launch() {
			if (!gameOver && !wonAll) {
				ball.stuck = false;
				statusEl.textContent = 'Break every brick.';
			}
		}

		function togglePause() {
			if (!gameOver && !wonAll) {
				paused = !paused;
				statusEl.textContent = paused ? 'Paused. Press P to continue.' : 'Game resumed.';
			}
		}

		function addText(text, x, y, color) {
			texts.push({ text: text, x: x, y: y, color: color, life: 60 });
		}

		function bounceFromPaddle() {
			const offset = Math.max(-1, Math.min(1, (ball.x - (paddle.x + paddle.w / 2)) / (paddle.w / 2)));
			const angle = offset * (65 * Math.PI / 180);
			const speed = Math.max(300, Math.sqrt(ball.dx * ball.dx + ball.dy * ball.dy));
			ball.dx = speed * Math.sin(angle);
			ball.dy = -Math.abs(speed * Math.cos(angle));
		}

		function handleCollisions() {
			const bRect = ballRect();
			if (rectsOverlap(bRect, { x: paddle.x, y: paddle.y, w: paddle.w, h: paddle.h }) && ball.dy > 0) {
				ball.y = paddle.y - BALL_RADIUS;
				bounceFromPaddle();
			}

			for (let i = 0; i < bricks.length; i++) {
				const brick = bricks[i];
				if (!rectsOverlap(bRect, brick)) {
					continue;
				}

				brick.hits -= 1;
				const overlapLeft = bRect.x + bRect.w - brick.x;
				const overlapRight = brick.x + brick.w - bRect.x;
				const overlapTop = bRect.y + bRect.h - brick.y;
				const overlapBottom = brick.y + brick.h - bRect.y;
				const minOverlap = Math.min(overlapLeft, overlapRight, overlapTop, overlapBottom);

				if (minOverlap === overlapLeft || minOverlap === overlapRight) {
					ball.dx *= -1;
				} else {
					ball.dy *= -1;
				}

				if (brick.hits <= 0) {
					score += 100 + brick.maxHits * 20;
					addText('+100', brick.x, brick.y, '#f0d246');
					if (brick.special === 'life') {
						lives += 1;
						addText('+1 LIFE', brick.x, brick.y - 15, '#46d26e');
					} else if (brick.special === 'wide') {
						paddle.w = Math.min(220, paddle.w + 25);
						addText('WIDER', brick.x, brick.y - 15, '#50dcdc');
					} else if (brick.special === 'slow') {
						ball.dx *= 0.85;
						ball.dy *= 0.85;
						addText('SLOW', brick.x, brick.y - 15, '#5096f0');
					}
					bricks.splice(i, 1);
					if (bricks.length % 10 === 0) {
						ball.dx *= 1.03;
						ball.dy *= 1.03;
					}
				}
				break;
			}
		}

		function update(dt) {
			if (paused || gameOver || wonAll) {
				return;
			}

			if (leftDown) paddle.x -= PADDLE_SPEED * dt;
			if (rightDown) paddle.x += PADDLE_SPEED * dt;
			paddle.x = Math.max(0, Math.min(WIDTH - paddle.w, paddle.x));

			if (ball.stuck) {
				ball.x = paddle.x + paddle.w / 2;
				ball.y = paddle.y - BALL_RADIUS - 2;
			} else {
				ball.x += ball.dx * dt;
				ball.y += ball.dy * dt;

				if (ball.x - BALL_RADIUS <= 0) {
					ball.x = BALL_RADIUS;
					ball.dx *= -1;
				}
				if (ball.x + BALL_RADIUS >= WIDTH) {
					ball.x = WIDTH - BALL_RADIUS;
					ball.dx *= -1;
				}
				if (ball.y - BALL_RADIUS <= 0) {
					ball.y = BALL_RADIUS;
					ball.dy *= -1;
				}
				handleCollisions();
			}

			texts.forEach(function (text) {
				text.y -= 30 * dt;
				text.life -= 60 * dt;
			});
			texts = texts.filter(function (text) {
				return text.life > 0;
			});

			if (ball.y - BALL_RADIUS > HEIGHT) {
				lives -= 1;
				if (lives <= 0) {
					gameOver = true;
					statusEl.textContent = 'Game over. Press R or Restart.';
				} else {
					resetBall();
					statusEl.textContent = 'Life lost. Launch again.';
				}
			}

			if (bricks.length === 0) {
				score += 1000;
				nextLevel();
			}

			updateHud();
		}

		function updateHud() {
			levelEl.textContent = level + ' / ' + MAX_LEVELS;
			scoreEl.textContent = String(score);
			livesEl.textContent = String(lives);
			blocksEl.textContent = String(bricks.length);
		}

		function drawRoundedRect(x, y, w, h, r, fill, stroke) {
			ctx.beginPath();
			ctx.moveTo(x + r, y);
			ctx.lineTo(x + w - r, y);
			ctx.quadraticCurveTo(x + w, y, x + w, y + r);
			ctx.lineTo(x + w, y + h - r);
			ctx.quadraticCurveTo(x + w, y + h, x + w - r, y + h);
			ctx.lineTo(x + r, y + h);
			ctx.quadraticCurveTo(x, y + h, x, y + h - r);
			ctx.lineTo(x, y + r);
			ctx.quadraticCurveTo(x, y, x + r, y);
			ctx.closePath();
			ctx.fillStyle = fill;
			ctx.fill();
			if (stroke) {
				ctx.strokeStyle = stroke;
				ctx.stroke();
			}
		}

		function shade(hex, amount) {
			const value = parseInt(hex.slice(1), 16);
			const r = Math.max(40, Math.floor(((value >> 16) & 255) * amount));
			const g = Math.max(40, Math.floor(((value >> 8) & 255) * amount));
			const b = Math.max(40, Math.floor((value & 255) * amount));
			return 'rgb(' + r + ',' + g + ',' + b + ')';
		}

		function drawBackground() {
			ctx.fillStyle = '#0a0a10';
			ctx.fillRect(0, 0, WIDTH, HEIGHT);
			const rng = seededRandom(level);
			for (let i = 0; i < 60; i++) {
				const starX = Math.floor(rng() * WIDTH);
				const starY = Math.floor(rng() * HEIGHT);
				const s = 35 + Math.floor(rng() * 45);
				ctx.fillStyle = 'rgb(' + s + ',' + s + ',' + (s + 20) + ')';
				ctx.beginPath();
				ctx.arc(starX, starY, 1, 0, Math.PI * 2);
				ctx.fill();
			}
			ctx.fillStyle = '#23232d';
			ctx.fillRect(0, 50, WIDTH, 2);
		}

		function drawText(text, x, y, size, color, align) {
			ctx.fillStyle = color;
			ctx.font = '700 ' + size + 'px Arial';
			ctx.textAlign = align || 'left';
			ctx.textBaseline = 'middle';
			ctx.fillText(text, x, y);
		}

		function draw() {
			drawBackground();

			bricks.forEach(function (brick) {
				const brightness = brick.hits / brick.maxHits;
				drawRoundedRect(brick.x, brick.y, brick.w, brick.h, 5, shade(brick.color, brightness), '#f8fafc');
				if (brick.maxHits > 1) {
					drawText(String(brick.hits), brick.x + brick.w / 2, brick.y + brick.h / 2 + 1, 14, '#0a0a10', 'center');
				}
				if (brick.special === 'life') {
					ctx.fillStyle = '#ffffff';
					ctx.beginPath();
					ctx.arc(brick.x + brick.w / 2, brick.y + brick.h / 2, 5, 0, Math.PI * 2);
					ctx.fill();
				} else if (brick.special === 'wide') {
					drawRoundedRect(brick.x + 20, brick.y + 7, brick.w - 40, brick.h - 14, 4, '#ffffff');
				} else if (brick.special === 'slow') {
					ctx.strokeStyle = '#0a0a10';
					ctx.lineWidth = 2;
					ctx.beginPath();
					ctx.arc(brick.x + brick.w / 2, brick.y + brick.h / 2, 5, 0, Math.PI * 2);
					ctx.stroke();
				}
			});

			drawRoundedRect(paddle.x, paddle.y, paddle.w, paddle.h, 8, '#f0f0f0');
			drawRoundedRect(paddle.x + 5, paddle.y + 3, paddle.w - 10, paddle.h - 6, 6, '#50dcdc');

			ctx.fillStyle = '#f0f0f0';
			ctx.beginPath();
			ctx.arc(ball.x, ball.y, BALL_RADIUS, 0, Math.PI * 2);
			ctx.fill();
			ctx.fillStyle = '#50dcdc';
			ctx.beginPath();
			ctx.arc(ball.x - 2, ball.y - 2, 3, 0, Math.PI * 2);
			ctx.fill();

			texts.forEach(function (text) {
				drawText(text.text, text.x, text.y, 18, text.color, 'left');
			});

			drawText('Level: ' + level + '/' + MAX_LEVELS, 20, 27, 24, '#f0f0f0');
			drawText('Score: ' + score, WIDTH / 2, 27, 24, '#f0f0f0', 'center');
			drawText('Lives: ' + lives, WIDTH - 20, 27, 24, '#f0f0f0', 'right');
			drawText('Move: A/D or Arrows   Launch: Space   Pause: P   Restart: R', WIDTH / 2, HEIGHT - 18, 18, '#78788c', 'center');

			if (ball.stuck && !gameOver && !wonAll) {
				drawText('Press SPACE to launch', WIDTH / 2, HEIGHT / 2 + 150, 24, '#f0f0f0', 'center');
			}
			if (paused) {
				drawCenterMessage('PAUSED', 'Press P to continue');
			}
			if (gameOver) {
				drawCenterMessage('GAME OVER', 'Press R to restart');
			}
			if (wonAll) {
				drawCenterMessage('YOU BEAT ALL 1000 LEVELS!', 'Press R to play again');
			}
		}

		function drawCenterMessage(title, subtitle) {
			ctx.fillStyle = 'rgba(10,10,16,0.72)';
			ctx.fillRect(0, 0, WIDTH, HEIGHT);
			drawText(title, WIDTH / 2, HEIGHT / 2 - 40, 52, '#f0f0f0', 'center');
			drawText(subtitle, WIDTH / 2, HEIGHT / 2 + 25, 24, '#78788c', 'center');
		}

		function loop(now) {
			const dt = Math.min(0.033, ((now || 0) - (lastTime || now || 0)) / 1000);
			lastTime = now || 0;
			update(dt);
			draw();
			requestAnimationFrame(loop);
		}

		function pointerToPaddle(event) {
			const rect = canvas.getBoundingClientRect();
			const x = (event.clientX - rect.left) / rect.width * WIDTH;
			paddle.x = Math.max(0, Math.min(WIDTH - paddle.w, x - paddle.w / 2));
		}

		window.addEventListener('keydown', function (event) {
			if (event.code === 'ArrowLeft' || event.code === 'KeyA') leftDown = true;
			if (event.code === 'ArrowRight' || event.code === 'KeyD') rightDown = true;
			if (event.code === 'Space') launch();
			if (event.code === 'KeyP') togglePause();
			if (event.code === 'KeyR') resetGame();
			if (['ArrowLeft', 'ArrowRight', 'Space'].indexOf(event.code) !== -1) {
				event.preventDefault();
			}
		});
		window.addEventListener('keyup', function (event) {
			if (event.code === 'ArrowLeft' || event.code === 'KeyA') leftDown = false;
			if (event.code === 'ArrowRight' || event.code === 'KeyD') rightDown = false;
		});
		canvas.addEventListener('pointerdown', function (event) {
			pointerToPaddle(event);
			canvas.setPointerCapture(event.pointerId);
		});
		canvas.addEventListener('pointermove', pointerToPaddle);
		buttons.launch.addEventListener('click', launch);
		buttons.restart.addEventListener('click', resetGame);
		buttons.pause.addEventListener('click', togglePause);
		buttons.left.addEventListener('pointerdown', function () { leftDown = true; });
		buttons.left.addEventListener('pointerup', function () { leftDown = false; });
		buttons.left.addEventListener('pointerleave', function () { leftDown = false; });
		buttons.right.addEventListener('pointerdown', function () { rightDown = true; });
		buttons.right.addEventListener('pointerup', function () { rightDown = false; });
		buttons.right.addEventListener('pointerleave', function () { rightDown = false; });

		resetGame();
		requestAnimationFrame(loop);
	});
});
JS;

if (!function_exists('zo_game_breakout_1000_render')) {
	function zo_game_breakout_1000_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-breakout-1000-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--breakout-1000" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-b1000-head">
				<div>
					<h2 class="zo-b1000-title">Breakout - 1000 Levels</h2>
					<p class="zo-b1000-subtitle">A browser PHP version of Arslan's pygame Breakout: deterministic levels, special bricks, shrinking paddle, faster ball, pause, restart, and 1000 levels.</p>
				</div>
				<div class="zo-b1000-stats" aria-label="Game stats">
					<div class="zo-b1000-stat">Level <span data-level>1 / 1000</span></div>
					<div class="zo-b1000-stat">Score <span data-score>0</span></div>
					<div class="zo-b1000-stat">Lives <span data-lives>3</span></div>
					<div class="zo-b1000-stat">Bricks <span data-blocks>0</span></div>
				</div>
			</div>
			<div class="zo-b1000-canvas-wrap">
				<canvas class="zo-b1000-canvas" width="900" height="650" aria-label="Breakout 1000 game board"></canvas>
			</div>
			<div class="zo-b1000-controls">
				<button type="button" class="zo-b1000-button zo-b1000-button--move" data-left>Left</button>
				<button type="button" class="zo-b1000-button zo-b1000-button--launch" data-launch>Launch</button>
				<button type="button" class="zo-b1000-button zo-b1000-button--pause" data-pause>Pause</button>
				<button type="button" class="zo-b1000-button zo-b1000-button--restart" data-restart>Restart</button>
				<button type="button" class="zo-b1000-button zo-b1000-button--move" data-right>Right</button>
			</div>
			<div class="zo-b1000-status" aria-live="polite">Level 1 ready. Press Space or Launch.</div>
			<div class="zo-b1000-help">Move with A/D, arrow keys, mouse, touch, or the Left/Right buttons. Launch with Space. Pause with P. Restart with R.</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'breakout-1000',
	'name'            => 'Breakout - 1000 Levels',
	'author'          => 'Arslan',
	'description'     => 'A PHP browser version of Arslan\'s pygame Breakout with 1000 deterministic levels, special bricks, 3 lives, pause, restart, and mobile controls.',
	'render_callback' => 'zo_game_breakout_1000_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
