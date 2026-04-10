<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 560px;
	margin: 0 auto;
	padding: 16px;
	text-align: center;
	font-family: Arial, sans-serif;
	box-sizing: border-box;
}

.zo-game-root * {
	box-sizing: border-box;
}

.zo-egypt-card {
	background: #fff8e7;
	border: 2px solid #d9b86c;
	border-radius: 16px;
	padding: 16px;
	box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
}

.zo-egypt-title {
	margin: 0 0 8px;
	font-size: 28px;
	line-height: 1.2;
}

.zo-egypt-text {
	margin: 0 0 14px;
	font-size: 16px;
	line-height: 1.5;
}

.zo-egypt-stats {
	display: flex;
	justify-content: center;
	gap: 10px;
	flex-wrap: wrap;
	margin-bottom: 14px;
}

.zo-egypt-stat {
	background: #fff;
	border: 1px solid #d9b86c;
	border-radius: 999px;
	padding: 8px 12px;
	font-weight: bold;
	font-size: 14px;
}

.zo-egypt-scene {
	position: relative;
	height: 200px;
	margin: 14px 0 18px;
	border-radius: 14px;
	overflow: hidden;
	background: linear-gradient(to bottom, #bfe7ff 0%, #e9f7ff 40%, #f1d18a 40%, #ddb35a 100%);
	border: 2px solid #d9b86c;
}

.zo-egypt-sun {
	position: absolute;
	top: 18px;
	right: 24px;
	width: 46px;
	height: 46px;
	border-radius: 50%;
	background: #ffd34d;
}

.zo-egypt-pyramid {
	position: absolute;
	bottom: 58px;
	width: 0;
	height: 0;
	border-left: 56px solid transparent;
	border-right: 56px solid transparent;
	border-bottom: 92px solid #c89c4e;
}

.zo-egypt-pyramid--1 {
	left: 52px;
}

.zo-egypt-pyramid--2 {
	left: 150px;
	bottom: 50px;
	border-left-width: 44px;
	border-right-width: 44px;
	border-bottom-width: 72px;
}

.zo-egypt-ground {
	position: absolute;
	left: 0;
	right: 0;
	bottom: 0;
	height: 58px;
	background: #ddb35a;
}

.zo-egypt-runner {
	position: absolute;
	left: 28px;
	bottom: 48px;
	font-size: 34px;
	line-height: 1;
	user-select: none;
	transition: bottom 0.12s linear, transform 0.12s linear;
}

.zo-egypt-runner.is-jumping {
	transform: translateY(-4px);
}

.zo-egypt-obstacle {
	position: absolute;
	right: -60px;
	bottom: 48px;
	font-size: 34px;
	line-height: 1;
	user-select: none;
}

.zo-egypt-controls {
	display: flex;
	justify-content: center;
	gap: 10px;
	flex-wrap: wrap;
	margin-bottom: 10px;
}

.zo-egypt-btn {
	appearance: none;
	border: 0;
	border-radius: 12px;
	padding: 12px 16px;
	font-size: 16px;
	font-weight: bold;
	cursor: pointer;
	background: #c98d2b;
	color: #fff;
	min-width: 120px;
}

.zo-egypt-btn:hover,
.zo-egypt-btn:focus {
	opacity: 0.92;
}

.zo-egypt-btn:disabled {
	opacity: 0.6;
	cursor: default;
}

.zo-egypt-status {
	min-height: 24px;
	font-size: 15px;
	font-weight: bold;
	margin-top: 8px;
}

.zo-egypt-help {
	margin-top: 10px;
	font-size: 14px;
	line-height: 1.5;
}

@media (max-width: 480px) {
	.zo-egypt-title {
		font-size: 24px;
	}

	.zo-egypt-scene {
		height: 180px;
	}

	.zo-egypt-runner,
	.zo-egypt-obstacle {
		font-size: 30px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--misir-piramit-kacisi');

	games.forEach(function (game) {
		const startBtn = game.querySelector('.zo-egypt-start');
		const restartBtn = game.querySelector('.zo-egypt-restart');
		const jumpBtn = game.querySelector('.zo-egypt-jump');
		const scoreEl = game.querySelector('.zo-egypt-score');
		const bestEl = game.querySelector('.zo-egypt-best');
		const statusEl = game.querySelector('.zo-egypt-status');
		const runner = game.querySelector('.zo-egypt-runner');
		const obstacle = game.querySelector('.zo-egypt-obstacle');
		const scene = game.querySelector('.zo-egypt-scene');

		let animationId = null;
		let running = false;
		let score = 0;
		let best = 0;
		let obstacleX = 520;
		let obstacleSpeed = 4.5;
		let playerBottom = 48;
		let jumpVelocity = 0;
		let gravity = 0.75;
		let isJumping = false;
		let frameCount = 0;

		function resetGame() {
			running = false;
			score = 0;
			obstacleX = scene.clientWidth + 40;
			obstacleSpeed = 4.5;
			playerBottom = 48;
			jumpVelocity = 0;
			isJumping = false;
			frameCount = 0;
			runner.style.bottom = playerBottom + 'px';
			runner.classList.remove('is-jumping');
			obstacle.style.right = (-obstacleX) + 'px';
			scoreEl.textContent = 'Skor: 0';
			statusEl.textContent = 'Hazır. Başla butonuna bas.';
			startBtn.disabled = false;
			jumpBtn.disabled = true;
			cancelLoop();
		}

		function cancelLoop() {
			if (animationId) {
				cancelAnimationFrame(animationId);
				animationId = null;
			}
		}

		function startGame() {
			if (running) {
				return;
			}
			running = true;
			score = 0;
			obstacleX = scene.clientWidth + 20;
			obstacleSpeed = 4.5;
			playerBottom = 48;
			jumpVelocity = 0;
			isJumping = false;
			frameCount = 0;
			startBtn.disabled = true;
			jumpBtn.disabled = false;
			statusEl.textContent = 'Kaç. Zıpla. Hazineden puan topla.';
			loop();
		}

		function jump() {
			if (!running || isJumping) {
				return;
			}
			isJumping = true;
			jumpVelocity = 11.5;
			runner.classList.add('is-jumping');
		}

		function updatePlayer() {
			if (!isJumping) {
				return;
			}

			playerBottom += jumpVelocity;
			jumpVelocity -= gravity;

			if (playerBottom <= 48) {
				playerBottom = 48;
				jumpVelocity = 0;
				isJumping = false;
				runner.classList.remove('is-jumping');
			}

			runner.style.bottom = playerBottom + 'px';
		}

		function updateObstacle() {
			obstacleX -= obstacleSpeed;

			if (obstacleX < -50) {
				obstacleX = scene.clientWidth + Math.floor(Math.random() * 80);
				score += 1;
				scoreEl.textContent = 'Skor: ' + score;

				if (score > best) {
					best = score;
					bestEl.textContent = 'En iyi: ' + best;
				}

				if (score > 0 && score % 5 === 0) {
					obstacleSpeed += 0.45;
				}
			}

			obstacle.style.right = (-obstacleX) + 'px';
		}

		function hitTest() {
			const playerX = 28;
			const playerWidth = 28;
			const obstacleWidth = 28;
			const obstacleLeft = obstacleX;
			const obstacleRight = obstacleX + obstacleWidth;
			const playerLeft = playerX;
			const playerRight = playerX + playerWidth;

			const horizontalHit = obstacleRight > playerLeft && obstacleLeft < playerRight;
			const verticalHit = playerBottom < 88;

			return horizontalHit && verticalHit;
		}

		function gameOver() {
			running = false;
			jumpBtn.disabled = true;
			startBtn.disabled = false;
			statusEl.textContent = 'Yakalandın. Tekrar dene.';
			cancelLoop();
		}

		function loop() {
			if (!running) {
				return;
			}

			frameCount += 1;
			updatePlayer();
			updateObstacle();

			if (hitTest()) {
				gameOver();
				return;
			}

			animationId = requestAnimationFrame(loop);
		}

		startBtn.addEventListener('click', startGame);
		restartBtn.addEventListener('click', resetGame);
		jumpBtn.addEventListener('click', jump);

		game.addEventListener('keydown', function (event) {
			if (event.code === 'Space' || event.code === 'ArrowUp') {
				event.preventDefault();
				jump();
			}
		});

		scene.addEventListener('click', function () {
			jump();
		});

		resetGame();
		bestEl.textContent = 'En iyi: 0';
		game.setAttribute('tabindex', '0');
	});
});
JS;

if (!function_exists('zo_game_misir_piramit_kacisi_render')) {
	function zo_game_misir_piramit_kacisi_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-misir-piramit-kacisi-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--misir-piramit-kacisi" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-egypt-card">
				<h3 class="zo-egypt-title">Mısır Piramit Kaçışı</h3>
				<p class="zo-egypt-text">Küçük kaşif piramitlerin önünden koşuyor. Mumyaya çarpmadan zıpla ve hazine puanları topla.</p>

				<div class="zo-egypt-stats">
					<div class="zo-egypt-stat zo-egypt-score">Skor: 0</div>
					<div class="zo-egypt-stat zo-egypt-best">En iyi: 0</div>
				</div>

				<div class="zo-egypt-scene" aria-label="Oyun alanı">
					<div class="zo-egypt-sun"></div>
					<div class="zo-egypt-pyramid zo-egypt-pyramid--1"></div>
					<div class="zo-egypt-pyramid zo-egypt-pyramid--2"></div>
					<div class="zo-egypt-ground"></div>
					<div class="zo-egypt-runner" aria-hidden="true">🧒</div>
					<div class="zo-egypt-obstacle" aria-hidden="true">🧟</div>
				</div>

				<div class="zo-egypt-controls">
					<button type="button" class="zo-egypt-btn zo-egypt-start">Başla</button>
					<button type="button" class="zo-egypt-btn zo-egypt-jump">Zıpla</button>
					<button type="button" class="zo-egypt-btn zo-egypt-restart">Sıfırla</button>
				</div>

				<div class="zo-egypt-status">Hazır. Başla butonuna bas.</div>
				<div class="zo-egypt-help">Bilgisayarda boşluk tuşu veya yukarı ok ile. Telefonda oyun alanına ya da Zıpla butonuna dokun.</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'misir-piramit-kacisi',
	'name'            => 'Mısır Piramit Kaçışı',
	'author'          => 'Arslan',
	'description'     => 'Mısır temalı basit koşu ve zıplama oyunu.',
	'render_callback' => 'zo_game_misir_piramit_kacisi_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);