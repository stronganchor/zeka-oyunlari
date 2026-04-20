<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--breakout-1000 {
	max-width: 1020px;
	margin: 0 auto;
	padding: 20px;
	border: 2px solid #d9e2ec;
	border-radius: 22px;
	background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
	box-sizing: border-box;
	font-family: Arial, sans-serif;
}

.zo-game-root--breakout-1000 .zo-b1-title {
	margin: 0 0 10px;
	font-size: 32px;
	line-height: 1.2;
	text-align: center;
	color: #111827;
}

.zo-game-root--breakout-1000 .zo-b1-desc {
	margin: 0 0 18px;
	font-size: 15px;
	line-height: 1.55;
	text-align: center;
	color: #4b5563;
}

.zo-game-root--breakout-1000 .zo-b1-top {
	display: grid;
	grid-template-columns: repeat(5, minmax(0, 1fr));
	gap: 10px;
	margin-bottom: 16px;
}

.zo-game-root--breakout-1000 .zo-b1-stat {
	border: 2px solid #d7e0ea;
	border-radius: 14px;
	padding: 12px;
	background: #f4f7fb;
	text-align: center;
}

.zo-game-root--breakout-1000 .zo-b1-stat-label {
	display: block;
	font-size: 13px;
	font-weight: 700;
	color: #51606f;
	margin-bottom: 4px;
}

.zo-game-root--breakout-1000 .zo-b1-stat-value {
	display: block;
	font-size: 24px;
	font-weight: 700;
	line-height: 1.1;
	color: #111827;
}

.zo-game-root--breakout-1000 .zo-b1-board-wrap {
	border: 2px solid #dbe4ee;
	border-radius: 16px;
	padding: 14px;
	background: #fbfdff;
	box-sizing: border-box;
}

.zo-game-root--breakout-1000 .zo-b1-canvas {
	display: block;
	width: 100%;
	max-width: 940px;
	margin: 0 auto;
	background: #09111f;
	border-radius: 14px;
	border: 2px solid #1e293b;
	touch-action: none;
}

.zo-game-root--breakout-1000 .zo-b1-controls {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 10px;
	margin-top: 16px;
}

.zo-game-root--breakout-1000 .zo-b1-button {
	border: 0;
	border-radius: 12px;
	padding: 12px 14px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	box-sizing: border-box;
}

.zo-game-root--breakout-1000 .zo-b1-button--start {
	background: #10b981;
	color: #ffffff;
}

.zo-game-root--breakout-1000 .zo-b1-button--restart {
	background: #e5e7eb;
	color: #111827;
}

.zo-game-root--breakout-1000 .zo-b1-button--left,
.zo-game-root--breakout-1000 .zo-b1-button--right {
	background: #2563eb;
	color: #ffffff;
}

.zo-game-root--breakout-1000 .zo-b1-status {
	min-height: 24px;
	margin-top: 14px;
	text-align: center;
	font-size: 16px;
	font-weight: 700;
	color: #374151;
}

.zo-game-root--breakout-1000 .zo-b1-status.is-good {
	color: #15803d;
}

.zo-game-root--breakout-1000 .zo-b1-status.is-bad {
	color: #dc2626;
}

.zo-game-root--breakout-1000 .zo-b1-status.is-info {
	color: #2563eb;
}

.zo-game-root--breakout-1000 .zo-b1-help {
	margin-top: 10px;
	text-align: center;
	font-size: 14px;
	line-height: 1.5;
	color: #4b5563;
}

@media (max-width: 780px) {
	.zo-game-root.zo-game-root--breakout-1000 {
		padding: 16px;
	}

	.zo-game-root--breakout-1000 .zo-b1-title {
		font-size: 26px;
	}

	.zo-game-root--breakout-1000 .zo-b1-top,
	.zo-game-root--breakout-1000 .zo-b1-controls {
		grid-template-columns: 1fr 1fr;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--breakout-1000');

	games.forEach(function (game) {
		const canvas = game.querySelector('.zo-b1-canvas');
		const ctx = canvas.getContext('2d');

		const levelEl = game.querySelector('.zo-b1-level');
		const scoreEl = game.querySelector('.zo-b1-score');
		const livesEl = game.querySelector('.zo-b1-lives');
		const blocksEl = game.querySelector('.zo-b1-blocks');
		const goalEl = game.querySelector('.zo-b1-goal');
		const statusEl = game.querySelector('.zo-b1-status');

		const startButton = game.querySelector('.zo-b1-button--start');
		const restartButton = game.querySelector('.zo-b1-button--restart');
		const leftButton = game.querySelector('.zo-b1-button--left');
		const rightButton = game.querySelector('.zo-b1-button--right');

		const WIDTH = 940;
		const HEIGHT = 580;
		const MAX_LEVEL = 1000;
		const COLORS = ['#ef4444', '#f97316', '#facc15', '#22c55e', '#38bdf8', '#a855f7', '#ec4899', '#14b8a6'];

		canvas.width = WIDTH;
		canvas.height = HEIGHT;

		let paddle = null;
		let ball = null;
		let bricks = [];
		let score = 0;
		let lives = 25;
		let level = 1;
		let playing = false;
		let gameEnded = false;
		let leftPressed = false;
		let rightPressed = false;
		let animationId = null;

		function setStatus(text, type) {
			statusEl.textContent = text;
			statusEl.className = 'zo-b1-status';
			if (type) {
				statusEl.classList.add(type);
			}
		}

		function getLevelConfig(levelNumber) {
			const rows = 3 + ((levelNumber - 1) % 8);
			const cols = 6 + (((levelNumber - 1) / 8) % 7 | 0);
			const gap = Math.max(4, 10 - (((levelNumber - 1) / 120) | 0));
			const brickHeight = Math.max(14, 28 - (((levelNumber - 1) / 140) | 0));
			const topOffset = 56 + (((levelNumber - 1) % 4) * 6);
			const totalGap = (cols - 1) * gap;
			const brickWidth = Math.floor((WIDTH - 90 - totalGap) / cols);
			const speed = Math.min(10.5, 4.1 + ((levelNumber - 1) * 0.012));
			const paddleWidth = Math.max(82, 150 - (((levelNumber - 1) / 18) | 0));
			const hits = 1 + (((levelNumber - 1) / 90) | 0);

			return {
				rows: rows,
				cols: cols,
				gap: gap,
				brickHeight: brickHeight,
				brickWidth: brickWidth,
				speed: speed,
				paddleWidth: paddleWidth,
				topOffset: topOffset,
				hits: Math.min(4, hits)
			};
		}

		function updateHud() {
			levelEl.textContent = String(level);
			scoreEl.textContent = String(score);
			livesEl.textContent = String(lives);
			blocksEl.textContent = String(bricks.length);
			goalEl.textContent = String(level) + ' / ' + String(MAX_LEVEL);
		}

		function createPaddle(config) {
			return {
				width: config.paddleWidth,
				height: 16,
				x: (WIDTH / 2) - (config.paddleWidth / 2),
				y: HEIGHT - 44,
				speed: 9
			};
		}

		function createBall(config) {
			return {
				size: 16,
				x: WIDTH / 2,
				y: HEIGHT - 68,
				vx: config.speed * (Math.random() < 0.5 ? -1 : 1),
				vy: -config.speed
			};
		}

		function createBricks(levelNumber) {
			const config = getLevelConfig(levelNumber);
			const totalWidth = (config.cols * config.brickWidth) + ((config.cols - 1) * config.gap);
			const startX = Math.floor((WIDTH - totalWidth) / 2);
			const list = [];

			for (let row = 0; row < config.rows; row++) {
				for (let col = 0; col < config.cols; col++) {
					const seed = levelNumber + row + col;
					list.push({
						x: startX + (col * (config.brickWidth + config.gap)),
						y: config.topOffset + (row * (config.brickHeight + config.gap)),
						width: config.brickWidth,
						height: config.brickHeight,
						color: COLORS[(row + col + levelNumber) % COLORS.length],
						hitsLeft: Math.min(config.hits, 1 + (seed % config.hits))
					});
				}
			}

			return list;
		}

		function resetBallAndPaddle() {
			const config = getLevelConfig(level);
			paddle = createPaddle(config);
			ball = createBall(config);
		}

		function loadLevel(levelNumber) {
			level = levelNumber;
			bricks = createBricks(level);
			resetBallAndPaddle();
			updateHud();
			setStatus('Level ' + level + ' is ready. Press start.', 'info');
			draw();
		}

		function restartWholeGame() {
			score = 0;
			lives = 25;
			playing = false;
			gameEnded = false;
			loadLevel(1);
		}

		function startLevel() {
			if (gameEnded) {
				return;
			}

			playing = true;
			setStatus('Game started. Beat all 1000 levels.', 'info');
		}

		function drawRoundedRect(x, y, width, height, radius, fill) {
			ctx.beginPath();
			ctx.moveTo(x + radius, y);
			ctx.lineTo(x + width - radius, y);
			ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
			ctx.lineTo(x + width, y + height - radius);
			ctx.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
			ctx.lineTo(x + radius, y + height);
			ctx.quadraticCurveTo(x, y + height, x, y + height - radius);
			ctx.lineTo(x, y + radius);
			ctx.quadraticCurveTo(x, y, x + radius, y);
			ctx.closePath();
			ctx.fillStyle = fill;
			ctx.fill();
		}

		function drawBrick(brick) {
			drawRoundedRect(brick.x, brick.y, brick.width, brick.height, 6, brick.color);
			ctx.lineWidth = 2;
			ctx.strokeStyle = 'rgba(255,255,255,0.85)';
			ctx.strokeRect(brick.x, brick.y, brick.width, brick.height);

			if (brick.hitsLeft > 1) {
				ctx.fillStyle = '#ffffff';
				ctx.font = 'bold 14px Arial';
				ctx.textAlign = 'center';
				ctx.fillText(String(brick.hitsLeft), brick.x + (brick.width / 2), brick.y + (brick.height / 2) + 5);
			}
		}

		function draw() {
			ctx.clearRect(0, 0, WIDTH, HEIGHT);
			ctx.fillStyle = '#09111f';
			ctx.fillRect(0, 0, WIDTH, HEIGHT);

			bricks.forEach(drawBrick);
			drawRoundedRect(paddle.x, paddle.y, paddle.width, paddle.height, 8, '#ffffff');

			ctx.beginPath();
			ctx.arc(ball.x, ball.y, ball.size / 2, 0, Math.PI * 2);
			ctx.fillStyle = '#ffffff';
			ctx.fill();

			if (!playing && !gameEnded) {
				ctx.fillStyle = 'rgba(9, 17, 31, 0.35)';
				ctx.fillRect(0, 0, WIDTH, HEIGHT);
				ctx.fillStyle = '#ffffff';
				ctx.font = 'bold 36px Arial';
				ctx.textAlign = 'center';
				ctx.fillText('Level ' + level, WIDTH / 2, HEIGHT / 2 - 10);
				ctx.font = '20px Arial';
				ctx.fillText('Press start to continue your 1000 level run', WIDTH / 2, HEIGHT / 2 + 28);
			}

			if (gameEnded) {
				ctx.fillStyle = 'rgba(9, 17, 31, 0.5)';
				ctx.fillRect(0, 0, WIDTH, HEIGHT);
				ctx.fillStyle = '#ffffff';
				ctx.font = 'bold 40px Arial';
				ctx.textAlign = 'center';
				ctx.fillText(lives <= 0 ? 'Game Over' : 'You Won', WIDTH / 2, HEIGHT / 2 - 6);
				ctx.font = '22px Arial';
				ctx.fillText('Press restart to play again', WIDTH / 2, HEIGHT / 2 + 34);
			}
		}

		function circleHitsRect(circleX, circleY, radius, rect) {
			const closestX = Math.max(rect.x, Math.min(circleX, rect.x + rect.width));
			const closestY = Math.max(rect.y, Math.min(circleY, rect.y + rect.height));
			const dx = circleX - closestX;
			const dy = circleY - closestY;
			return (dx * dx) + (dy * dy) <= radius * radius;
		}

		function handlePaddleMove() {
			if (leftPressed) {
				paddle.x -= paddle.speed;
			}
			if (rightPressed) {
				paddle.x += paddle.speed;
			}

			if (paddle.x < 0) {
				paddle.x = 0;
			}
			if (paddle.x + paddle.width > WIDTH) {
				paddle.x = WIDTH - paddle.width;
			}
		}

		function handleBallMove() {
			ball.x += ball.vx;
			ball.y += ball.vy;

			if (ball.x - (ball.size / 2) <= 0) {
				ball.x = ball.size / 2;
				ball.vx *= -1;
			}
			if (ball.x + (ball.size / 2) >= WIDTH) {
				ball.x = WIDTH - (ball.size / 2);
				ball.vx *= -1;
			}
			if (ball.y - (ball.size / 2) <= 0) {
				ball.y = ball.size / 2;
				ball.vy *= -1;
			}

			const paddleRect = {
				x: paddle.x,
				y: paddle.y,
				width: paddle.width,
				height: paddle.height
			};

			if (ball.vy > 0 && circleHitsRect(ball.x, ball.y, ball.size / 2, paddleRect)) {
				ball.y = paddle.y - (ball.size / 2);
				ball.vy = -Math.abs(ball.vy);

				const offset = (ball.x - (paddle.x + (paddle.width / 2))) / (paddle.width / 2);
				ball.vx = offset * 6.3;

				if (Math.abs(ball.vx) < 2) {
					ball.vx = ball.vx < 0 ? -2 : 2;
				}
			}

			for (let i = 0; i < bricks.length; i++) {
				const brick = bricks[i];

				if (!circleHitsRect(ball.x, ball.y, ball.size / 2, brick)) {
					continue;
				}

				brick.hitsLeft -= 1;
				score += 10;

				const fromLeft = Math.abs((ball.x + (ball.size / 2)) - brick.x);
				const fromRight = Math.abs((ball.x - (ball.size / 2)) - (brick.x + brick.width));
				const fromTop = Math.abs((ball.y + (ball.size / 2)) - brick.y);
				const fromBottom = Math.abs((ball.y - (ball.size / 2)) - (brick.y + brick.height));
				const minHit = Math.min(fromLeft, fromRight, fromTop, fromBottom);

				if (minHit === fromLeft || minHit === fromRight) {
					ball.vx *= -1;
				} else {
					ball.vy *= -1;
				}

				if (brick.hitsLeft <= 0) {
					bricks.splice(i, 1);
					score += 25;
				}

				updateHud();
				break;
			}

			if (ball.y - (ball.size / 2) > HEIGHT) {
				lives -= 1;
				updateHud();

				if (lives <= 0) {
					playing = false;
					gameEnded = true;
					setStatus('You lost all lives. Game over.', 'bad');
					draw();
					return;
				}

				playing = false;
				resetBallAndPaddle();
				setStatus('You lost a life. Level ' + level + ' will restart.', 'bad');
			}

			if (bricks.length === 0) {
				if (level < MAX_LEVEL) {
					playing = false;
					setStatus('Level ' + level + ' cleared. Level ' + (level + 1) + ' is next.', 'good');
					loadLevel(level + 1);
				} else {
					playing = false;
					gameEnded = true;
					setStatus('You beat all 1000 levels.', 'good');
				}
			}
		}

		function loop() {
			handlePaddleMove();

			if (playing && !gameEnded) {
				handleBallMove();
			}

			draw();
			animationId = window.requestAnimationFrame(loop);
		}

		document.addEventListener('keydown', function (event) {
			if (!game.contains(document.activeElement) && document.activeElement !== document.body) {
				return;
			}

			if (event.key === 'ArrowLeft') {
				leftPressed = true;
				event.preventDefault();
			}

			if (event.key === 'ArrowRight') {
				rightPressed = true;
				event.preventDefault();
			}
		});

		document.addEventListener('keyup', function (event) {
			if (event.key === 'ArrowLeft') {
				leftPressed = false;
			}

			if (event.key === 'ArrowRight') {
				rightPressed = false;
			}
		});

		leftButton.addEventListener('pointerdown', function () {
			leftPressed = true;
		});
		rightButton.addEventListener('pointerdown', function () {
			rightPressed = true;
		});
		leftButton.addEventListener('pointerup', function () {
			leftPressed = false;
		});
		rightButton.addEventListener('pointerup', function () {
			rightPressed = false;
		});
		leftButton.addEventListener('pointerleave', function () {
			leftPressed = false;
		});
		rightButton.addEventListener('pointerleave', function () {
			rightPressed = false;
		});

		canvas.addEventListener('pointermove', function (event) {
			const rect = canvas.getBoundingClientRect();
			const scaleX = WIDTH / rect.width;
			const x = (event.clientX - rect.left) * scaleX;
			paddle.x = x - (paddle.width / 2);

			if (paddle.x < 0) {
				paddle.x = 0;
			}
			if (paddle.x + paddle.width > WIDTH) {
				paddle.x = WIDTH - paddle.width;
			}
		});

		startButton.addEventListener('click', function () {
			startLevel();
		});

		restartButton.addEventListener('click', function () {
			restartWholeGame();
		});

		restartWholeGame();

		if (!animationId) {
			loop();
		}
	});
});
JS;

if (!function_exists('zo_game_breakout_1000_render')) {
	function zo_game_breakout_1000_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-breakout-1000-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--breakout-1000" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-b1-title">Breakout 1000</h2>
			<p class="zo-b1-desc">Break the blocks and survive a huge 1000 level run. Each level is generated automatically, so the brick layout, paddle size, speed, and durability keep changing as you go higher.</p>

			<div class="zo-b1-top">
				<div class="zo-b1-stat">
					<span class="zo-b1-stat-label">Level</span>
					<span class="zo-b1-stat-value zo-b1-level">1</span>
				</div>
				<div class="zo-b1-stat">
					<span class="zo-b1-stat-label">Score</span>
					<span class="zo-b1-stat-value zo-b1-score">0</span>
				</div>
				<div class="zo-b1-stat">
					<span class="zo-b1-stat-label">Lives</span>
					<span class="zo-b1-stat-value zo-b1-lives">25</span>
				</div>
				<div class="zo-b1-stat">
					<span class="zo-b1-stat-label">Blocks</span>
					<span class="zo-b1-stat-value zo-b1-blocks">0</span>
				</div>
				<div class="zo-b1-stat">
					<span class="zo-b1-stat-label">Goal</span>
					<span class="zo-b1-stat-value zo-b1-goal">1 / 1000</span>
				</div>
			</div>

			<div class="zo-b1-board-wrap">
				<canvas class="zo-b1-canvas" width="940" height="580"></canvas>

				<div class="zo-b1-controls">
					<button type="button" class="zo-b1-button zo-b1-button--start">Start</button>
					<button type="button" class="zo-b1-button zo-b1-button--restart">Restart</button>
					<button type="button" class="zo-b1-button zo-b1-button--left">Left</button>
					<button type="button" class="zo-b1-button zo-b1-button--right">Right</button>
				</div>

				<div class="zo-b1-status" aria-live="polite">Level 1 is ready. Press start.</div>
				<div class="zo-b1-help">Use the left and right arrow keys, move the paddle with your mouse, or tap the buttons below the board.</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'breakout-1000',
	'name'            => 'Breakout 1000',
	'author'          => 'Arslan',
	'description'     => 'A breakout game with 1000 generated levels, changing brick patterns, smaller paddles, faster balls, and stronger bricks as levels rise.',
	'render_callback' => 'zo_game_breakout_1000_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
