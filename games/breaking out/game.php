<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--breakout-levels {
	max-width: 980px;
	margin: 0 auto;
	padding: 20px;
	border: 2px solid #d9e2ec;
	border-radius: 18px;
	background: #ffffff;
	box-sizing: border-box;
	font-family: Arial, sans-serif;
}

.zo-game-root--breakout-levels .zo-bl-title {
	margin: 0 0 10px;
	font-size: 30px;
	line-height: 1.2;
	text-align: center;
	color: #1f2937;
}

.zo-game-root--breakout-levels .zo-bl-desc {
	margin: 0 0 18px;
	font-size: 15px;
	line-height: 1.5;
	text-align: center;
	color: #4b5563;
}

.zo-game-root--breakout-levels .zo-bl-top {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 10px;
	margin-bottom: 16px;
}

.zo-game-root--breakout-levels .zo-bl-stat {
	border: 2px solid #d7e0ea;
	border-radius: 14px;
	padding: 12px;
	background: #f4f7fb;
	text-align: center;
}

.zo-game-root--breakout-levels .zo-bl-stat-label {
	display: block;
	font-size: 13px;
	font-weight: 700;
	color: #51606f;
	margin-bottom: 4px;
}

.zo-game-root--breakout-levels .zo-bl-stat-value {
	display: block;
	font-size: 24px;
	font-weight: 700;
	line-height: 1.1;
	color: #111827;
}

.zo-game-root--breakout-levels .zo-bl-board-wrap {
	border: 2px solid #dbe4ee;
	border-radius: 16px;
	padding: 14px;
	background: #fbfdff;
	box-sizing: border-box;
}

.zo-game-root--breakout-levels .zo-bl-canvas {
	display: block;
	width: 100%;
	max-width: 900px;
	margin: 0 auto;
	background: #0f172a;
	border-radius: 14px;
	border: 2px solid #1e293b;
	touch-action: none;
}

.zo-game-root--breakout-levels .zo-bl-controls {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 10px;
	margin-top: 16px;
}

.zo-game-root--breakout-levels .zo-bl-button {
	border: 0;
	border-radius: 12px;
	padding: 12px 14px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	box-sizing: border-box;
}

.zo-game-root--breakout-levels .zo-bl-button--start {
	background: #10b981;
	color: #ffffff;
}

.zo-game-root--breakout-levels .zo-bl-button--restart {
	background: #e5e7eb;
	color: #111827;
}

.zo-game-root--breakout-levels .zo-bl-button--left,
.zo-game-root--breakout-levels .zo-bl-button--right {
	background: #2997aa;
	color: #ffffff;
}

.zo-game-root--breakout-levels .zo-bl-status {
	min-height: 24px;
	margin-top: 14px;
	text-align: center;
	font-size: 16px;
	font-weight: 700;
	color: #374151;
}

.zo-game-root--breakout-levels .zo-bl-status.is-good {
	color: #15803d;
}

.zo-game-root--breakout-levels .zo-bl-status.is-bad {
	color: #dc2626;
}

.zo-game-root--breakout-levels .zo-bl-status.is-info {
	color: #2563eb;
}

.zo-game-root--breakout-levels .zo-bl-help {
	margin-top: 10px;
	text-align: center;
	font-size: 14px;
	line-height: 1.5;
	color: #4b5563;
}

@media (max-width: 760px) {
	.zo-game-root.zo-game-root--breakout-levels {
		padding: 16px;
	}

	.zo-game-root--breakout-levels .zo-bl-title {
		font-size: 25px;
	}

	.zo-game-root--breakout-levels .zo-bl-top,
	.zo-game-root--breakout-levels .zo-bl-controls {
		grid-template-columns: 1fr 1fr;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--breakout-levels');

	games.forEach(function (game) {
		const canvas = game.querySelector('.zo-bl-canvas');
		const ctx = canvas.getContext('2d');

		const levelEl = game.querySelector('.zo-bl-level');
		const scoreEl = game.querySelector('.zo-bl-score');
		const livesEl = game.querySelector('.zo-bl-lives');
		const blocksEl = game.querySelector('.zo-bl-blocks');
		const statusEl = game.querySelector('.zo-bl-status');

		const startButton = game.querySelector('.zo-bl-button--start');
		const restartButton = game.querySelector('.zo-bl-button--restart');
		const leftButton = game.querySelector('.zo-bl-button--left');
		const rightButton = game.querySelector('.zo-bl-button--right');

		const WIDTH = 900;
		const HEIGHT = 560;
		canvas.width = WIDTH;
		canvas.height = HEIGHT;

		const LEVELS = [
			{ rows: 3, cols: 6, brickWidth: 120, brickHeight: 28, gap: 10, speed: 4.2 },
			{ rows: 3, cols: 7, brickWidth: 102, brickHeight: 28, gap: 10, speed: 4.5 },
			{ rows: 4, cols: 7, brickWidth: 102, brickHeight: 26, gap: 8, speed: 4.8 },
			{ rows: 4, cols: 8, brickWidth: 90, brickHeight: 26, gap: 8, speed: 5.0 },
			{ rows: 5, cols: 8, brickWidth: 90, brickHeight: 24, gap: 8, speed: 5.2 },
			{ rows: 5, cols: 9, brickWidth: 80, brickHeight: 24, gap: 8, speed: 5.4 },
			{ rows: 6, cols: 9, brickWidth: 80, brickHeight: 22, gap: 7, speed: 5.6 },
			{ rows: 6, cols: 10, brickWidth: 71, brickHeight: 22, gap: 7, speed: 5.8 },
			{ rows: 7, cols: 10, brickWidth: 71, brickHeight: 20, gap: 6, speed: 6.0 },
			{ rows: 8, cols: 10, brickWidth: 71, brickHeight: 18, gap: 6, speed: 6.2 }
		];

		const COLORS = ['#ef4444', '#f97316', '#facc15', '#22c55e', '#38bdf8', '#a855f7', '#ec4899', '#14b8a6'];

		let paddle = null;
		let ball = null;
		let bricks = [];
		let score = 0;
		let lives = 15;
		let level = 1;
		let playing = false;
		let gameEnded = false;
		let leftPressed = false;
		let rightPressed = false;
		let animationId = null;

		function setStatus(text, type) {
			statusEl.textContent = text;
			statusEl.className = 'zo-bl-status';
			if (type) {
				statusEl.classList.add(type);
			}
		}

		function updateHud() {
			levelEl.textContent = String(level);
			scoreEl.textContent = String(score);
			livesEl.textContent = String(lives);
			blocksEl.textContent = String(bricks.length);
		}

		function createPaddle() {
			return {
				width: 150,
				height: 16,
				x: (WIDTH / 2) - 75,
				y: HEIGHT - 44,
				speed: 8
			};
		}

		function createBall(speed) {
			return {
				size: 16,
				x: WIDTH / 2,
				y: HEIGHT - 66,
				vx: speed * (Math.random() < 0.5 ? -1 : 1),
				vy: -speed
			};
		}

		function createBricks(levelIndex) {
			const cfg = LEVELS[levelIndex];
			const totalWidth = (cfg.cols * cfg.brickWidth) + ((cfg.cols - 1) * cfg.gap);
			const startX = (WIDTH - totalWidth) / 2;
			const topOffset = 60;
			const list = [];

			for (let row = 0; row < cfg.rows; row++) {
				for (let col = 0; col < cfg.cols; col++) {
					list.push({
						x: startX + (col * (cfg.brickWidth + cfg.gap)),
						y: topOffset + (row * (cfg.brickHeight + cfg.gap)),
						width: cfg.brickWidth,
						height: cfg.brickHeight,
						color: COLORS[row % COLORS.length]
					});
				}
			}

			return list;
		}

		function resetBallAndPaddle() {
			const speed = LEVELS[level - 1].speed;
			paddle = createPaddle();
			ball = createBall(speed);
		}

		function loadLevel(levelNumber) {
			level = levelNumber;
			bricks = createBricks(level - 1);
			resetBallAndPaddle();
			updateHud();
			setStatus('Seviye ' + level + ' hazır. Başlat düğmesine bas.', 'info');
			draw();
		}

		function restartWholeGame() {
			score = 0;
			lives = 15;
			playing = false;
			gameEnded = false;
			loadLevel(1);
		}

		function startLevel() {
			if (gameEnded) {
				return;
			}
			playing = true;
			setStatus('Oyun başladı.', 'info');
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

		function draw() {
			ctx.clearRect(0, 0, WIDTH, HEIGHT);

			ctx.fillStyle = '#0f172a';
			ctx.fillRect(0, 0, WIDTH, HEIGHT);

			bricks.forEach(function (brick) {
				drawRoundedRect(brick.x, brick.y, brick.width, brick.height, 6, brick.color);
				ctx.lineWidth = 2;
				ctx.strokeStyle = '#ffffff';
				ctx.strokeRect(brick.x, brick.y, brick.width, brick.height);
			});

			drawRoundedRect(paddle.x, paddle.y, paddle.width, paddle.height, 8, '#ffffff');

			ctx.beginPath();
			ctx.arc(ball.x, ball.y, ball.size / 2, 0, Math.PI * 2);
			ctx.fillStyle = '#ffffff';
			ctx.fill();

			if (!playing && !gameEnded) {
				ctx.fillStyle = 'rgba(15, 23, 42, 0.25)';
				ctx.fillRect(0, 0, WIDTH, HEIGHT);

				ctx.fillStyle = '#ffffff';
				ctx.font = 'bold 34px Arial';
				ctx.textAlign = 'center';
				ctx.fillText('Seviye ' + level, WIDTH / 2, HEIGHT / 2 - 10);
				ctx.font = '20px Arial';
				ctx.fillText('Başlat düğmesine bas', WIDTH / 2, HEIGHT / 2 + 28);
			}

			if (gameEnded) {
				ctx.fillStyle = 'rgba(15, 23, 42, 0.45)';
				ctx.fillRect(0, 0, WIDTH, HEIGHT);
				ctx.fillStyle = '#ffffff';
				ctx.font = 'bold 40px Arial';
				ctx.textAlign = 'center';
				ctx.fillText(lives <= 0 ? 'Oyun Bitti' : 'Kazandın', WIDTH / 2, HEIGHT / 2 - 6);
				ctx.font = '22px Arial';
				ctx.fillText('Tekrar başlamak için Baştan Başla düğmesine bas', WIDTH / 2, HEIGHT / 2 + 34);
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
				ball.vx = offset * 6;

				if (Math.abs(ball.vx) < 2) {
					ball.vx = ball.vx < 0 ? -2 : 2;
				}
			}

			for (let i = 0; i < bricks.length; i++) {
				const brick = bricks[i];

				if (!circleHitsRect(ball.x, ball.y, ball.size / 2, brick)) {
					continue;
				}

				bricks.splice(i, 1);
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

				updateHud();
				break;
			}

			if (ball.y - (ball.size / 2) > HEIGHT) {
				lives -= 1;
				updateHud();

				if (lives <= 0) {
					playing = false;
					gameEnded = true;
					setStatus('Tüm canlar bitti. Oyun bitti.', 'bad');
					draw();
					return;
				}

				playing = false;
				resetBallAndPaddle();
				setStatus('Can gitti. Seviye ' + level + ' tekrar başlıyor.', 'bad');
			}

			if (bricks.length === 0) {
				if (level < 10) {
					playing = false;
					setStatus('Seviye ' + level + ' bitti. Şimdi seviye ' + (level + 1) + '.', 'good');
					loadLevel(level + 1);
				} else {
					playing = false;
					gameEnded = true;
					setStatus('Seviye 10 bitti. Oyunu kazandın.', 'good');
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

if (!function_exists('zo_game_breakout_levels_render')) {
	function zo_game_breakout_levels_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-breakout-levels-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--breakout-levels" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-bl-title">Breakout Levels</h2>
			<p class="zo-bl-desc">Top ile blokları kır. Toplam 10 seviye var. Her seviyede daha çok blok var. 10. seviye bitince kazanırsın.</p>

			<div class="zo-bl-top">
				<div class="zo-bl-stat">
					<span class="zo-bl-stat-label">Seviye</span>
					<span class="zo-bl-stat-value zo-bl-level">1</span>
				</div>
				<div class="zo-bl-stat">
					<span class="zo-bl-stat-label">Puan</span>
					<span class="zo-bl-stat-value zo-bl-score">0</span>
				</div>
				<div class="zo-bl-stat">
					<span class="zo-bl-stat-label">Can</span>
					<span class="zo-bl-stat-value zo-bl-lives">15</span>
				</div>
				<div class="zo-bl-stat">
					<span class="zo-bl-stat-label">Kalan Blok</span>
					<span class="zo-bl-stat-value zo-bl-blocks">0</span>
				</div>
			</div>

			<div class="zo-bl-board-wrap">
				<canvas class="zo-bl-canvas" width="900" height="560"></canvas>

				<div class="zo-bl-controls">
					<button type="button" class="zo-bl-button zo-bl-button--start">Başlat</button>
					<button type="button" class="zo-bl-button zo-bl-button--restart">Baştan Başla</button>
					<button type="button" class="zo-bl-button zo-bl-button--left">Sola</button>
					<button type="button" class="zo-bl-button zo-bl-button--right">Sağa</button>
				</div>

				<div class="zo-bl-status" aria-live="polite">Seviye 1 hazır. Başlat düğmesine bas.</div>
				<div class="zo-bl-help">Klavye ile sol ve sağ ok tuşlarını kullanabilir veya alttaki düğmelere basabilirsin.</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'breakout-levels',
	'name'            => 'Breakout Levels',
	'author'          => 'Asker',
	'description'     => '10 seviyeli breakout oyunu. Her seviyede daha fazla blok var. 15 can ile oynanır.',
	'render_callback' => 'zo_game_breakout_levels_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);