<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 760px;
	margin: 0 auto;
	padding: 16px;
	box-sizing: border-box;
	font-family: Arial, sans-serif;
	text-align: center;
}

.zo-game-root * {
	box-sizing: border-box;
}

.zo-game-root--soccer-vs-ai .zo-soccer-card {
	background: #f8fafc;
	border: 2px solid #d9e2ec;
	border-radius: 18px;
	padding: 16px;
	box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}

.zo-game-root--soccer-vs-ai .zo-soccer-title {
	margin: 0 0 8px;
	font-size: 28px;
	line-height: 1.2;
}

.zo-game-root--soccer-vs-ai .zo-soccer-help {
	margin: 0 0 14px;
	font-size: 16px;
	line-height: 1.5;
	color: #333;
}

.zo-game-root--soccer-vs-ai .zo-soccer-topbar {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap: 10px;
	margin-bottom: 14px;
}

.zo-game-root--soccer-vs-ai .zo-soccer-stat {
	background: #ffffff;
	border: 2px solid #dde5ee;
	border-radius: 12px;
	padding: 10px 14px;
	min-width: 120px;
	font-weight: bold;
	font-size: 16px;
}

.zo-game-root--soccer-vs-ai .zo-soccer-field {
	position: relative;
	width: 100%;
	height: 440px;
	border: 4px solid #2e7d32;
	border-radius: 18px;
	background:
		linear-gradient(90deg, transparent 49.5%, #ffffff 49.5%, #ffffff 50.5%, transparent 50.5%),
		repeating-linear-gradient(
			180deg,
			#66bb6a 0px,
			#66bb6a 40px,
			#5cad60 40px,
			#5cad60 80px
		);
	overflow: hidden;
	touch-action: none;
	user-select: none;
}

.zo-game-root--soccer-vs-ai .zo-soccer-center-circle {
	position: absolute;
	left: 50%;
	top: 50%;
	width: 120px;
	height: 120px;
	border: 3px solid rgba(255, 255, 255, 0.95);
	border-radius: 50%;
	transform: translate(-50%, -50%);
	pointer-events: none;
}

.zo-game-root--soccer-vs-ai .zo-soccer-goal {
	position: absolute;
	top: 50%;
	width: 18px;
	height: 120px;
	transform: translateY(-50%);
	background: rgba(255, 255, 255, 0.92);
	border: 3px solid #cfd8dc;
}

.zo-game-root--soccer-vs-ai .zo-soccer-goal--left {
	left: 0;
	border-left: none;
	border-radius: 0 10px 10px 0;
}

.zo-game-root--soccer-vs-ai .zo-soccer-goal--right {
	right: 0;
	border-right: none;
	border-radius: 10px 0 0 10px;
}

.zo-game-root--soccer-vs-ai .zo-soccer-player,
.zo-game-root--soccer-vs-ai .zo-soccer-ai,
.zo-game-root--soccer-vs-ai .zo-soccer-ball {
	position: absolute;
	border-radius: 50%;
	transform: translate(-50%, -50%);
}

.zo-game-root--soccer-vs-ai .zo-soccer-player,
.zo-game-root--soccer-vs-ai .zo-soccer-ai {
	width: 42px;
	height: 42px;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 22px;
	font-weight: bold;
	color: #ffffff;
	box-shadow: 0 6px 14px rgba(0, 0, 0, 0.18);
	pointer-events: none;
}

.zo-game-root--soccer-vs-ai .zo-soccer-player {
	background: #1e88e5;
}

.zo-game-root--soccer-vs-ai .zo-soccer-ai {
	background: #ef5350;
}

.zo-game-root--soccer-vs-ai .zo-soccer-ball {
	width: 24px;
	height: 24px;
	background: radial-gradient(circle at 35% 35%, #ffffff 0%, #ffffff 45%, #e6e6e6 100%);
	border: 2px solid #263238;
	box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
	pointer-events: none;
}

.zo-game-root--soccer-vs-ai .zo-soccer-controls {
	display: grid;
	grid-template-columns: repeat(3, 72px);
	grid-template-rows: repeat(2, 60px);
	justify-content: center;
	gap: 8px;
	margin: 16px auto 0;
	max-width: 240px;
}

.zo-game-root--soccer-vs-ai .zo-soccer-control {
	border: none;
	border-radius: 12px;
	font-size: 24px;
	font-weight: bold;
	background: #ffffff;
	border: 2px solid #d8e0ea;
	cursor: pointer;
	touch-action: manipulation;
}

.zo-game-root--soccer-vs-ai .zo-soccer-control--up {
	grid-column: 2;
	grid-row: 1;
}

.zo-game-root--soccer-vs-ai .zo-soccer-control--left {
	grid-column: 1;
	grid-row: 2;
}

.zo-game-root--soccer-vs-ai .zo-soccer-control--down {
	grid-column: 2;
	grid-row: 2;
}

.zo-game-root--soccer-vs-ai .zo-soccer-control--right {
	grid-column: 3;
	grid-row: 2;
}

.zo-game-root--soccer-vs-ai .zo-soccer-buttons {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap: 10px;
	margin-top: 14px;
}

.zo-game-root--soccer-vs-ai .zo-soccer-btn {
	border: none;
	border-radius: 12px;
	padding: 12px 18px;
	font-size: 16px;
	font-weight: bold;
	cursor: pointer;
	color: #ffffff;
	background: #1e88e5;
}

.zo-game-root--soccer-vs-ai .zo-soccer-btn--shoot {
	background: #fb8c00;
}

.zo-game-root--soccer-vs-ai .zo-soccer-btn--restart {
	background: #222;
}

.zo-game-root--soccer-vs-ai .zo-soccer-message {
	margin-top: 14px;
	min-height: 48px;
	padding: 12px;
	background: #ffffff;
	border: 2px solid #dde5ee;
	border-radius: 14px;
	font-size: 16px;
	font-weight: bold;
	line-height: 1.4;
	color: #222;
}

@media (max-width: 640px) {
	.zo-game-root--soccer-vs-ai .zo-soccer-field {
		height: 380px;
	}

	.zo-game-root--soccer-vs-ai .zo-soccer-player,
	.zo-game-root--soccer-vs-ai .zo-soccer-ai {
		width: 38px;
		height: 38px;
		font-size: 20px;
	}

	.zo-game-root--soccer-vs-ai .zo-soccer-ball {
		width: 22px;
		height: 22px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--soccer-vs-ai');

	games.forEach(function (game) {
		const field = game.querySelector('.zo-soccer-field');
		const playerEl = game.querySelector('.zo-soccer-player');
		const aiEl = game.querySelector('.zo-soccer-ai');
		const ballEl = game.querySelector('.zo-soccer-ball');

		const playerScoreEl = game.querySelector('.zo-soccer-player-score');
		const aiScoreEl = game.querySelector('.zo-soccer-ai-score');
		const timeEl = game.querySelector('.zo-soccer-time');
		const messageEl = game.querySelector('.zo-soccer-message');

		const restartBtn = game.querySelector('.zo-soccer-btn--restart');
		const shootBtn = game.querySelector('.zo-soccer-btn--shoot');
		const moveButtons = game.querySelectorAll('.zo-soccer-control');

		let player = { x: 120, y: 220, r: 21 };
		let ai = { x: 620, y: 220, r: 21 };
		let ball = { x: 380, y: 220, vx: 0, vy: 0, r: 12 };

		let playerScore = 0;
		let aiScore = 0;
		let timeLeft = 60;
		let timerId = null;
		let animationId = null;
		let running = false;
		let keys = {};
		let fieldWidth = 760;
		let fieldHeight = 440;
		let goalTop = 160;
		let goalBottom = 280;

		function updateFieldSize() {
			fieldWidth = field.clientWidth;
			fieldHeight = field.clientHeight;
			goalTop = (fieldHeight / 2) - 60;
			goalBottom = (fieldHeight / 2) + 60;
		}

		function clamp(value, min, max) {
			return Math.max(min, Math.min(max, value));
		}

		function distance(a, b) {
			const dx = a.x - b.x;
			const dy = a.y - b.y;
			return Math.sqrt((dx * dx) + (dy * dy));
		}

		function setMessage(text) {
			messageEl.textContent = text;
		}

		function updateHud() {
			playerScoreEl.textContent = String(playerScore);
			aiScoreEl.textContent = String(aiScore);
			timeEl.textContent = String(timeLeft);
		}

		function draw() {
			playerEl.style.left = player.x + 'px';
			playerEl.style.top = player.y + 'px';

			aiEl.style.left = ai.x + 'px';
			aiEl.style.top = ai.y + 'px';

			ballEl.style.left = ball.x + 'px';
			ballEl.style.top = ball.y + 'px';
		}

		function resetPositions(kickoffToPlayer) {
			updateFieldSize();

			player.x = fieldWidth * 0.2;
			player.y = fieldHeight * 0.5;

			ai.x = fieldWidth * 0.8;
			ai.y = fieldHeight * 0.5;

			ball.x = kickoffToPlayer ? fieldWidth * 0.35 : fieldWidth * 0.65;
			ball.y = fieldHeight * 0.5;
			ball.vx = 0;
			ball.vy = 0;

			draw();
		}

		function kickBall(from, targetX, targetY, power) {
			const dx = targetX - from.x;
			const dy = targetY - from.y;
			const len = Math.sqrt((dx * dx) + (dy * dy)) || 1;

			ball.vx = (dx / len) * power;
			ball.vy = (dy / len) * power;
		}

		function playerNearBall() {
			return distance(player, ball) < (player.r + ball.r + 10);
		}

		function aiNearBall() {
			return distance(ai, ball) < (ai.r + ball.r + 10);
		}

		function handlePlayerInput() {
			const speed = 4.2;
			let moveX = 0;
			let moveY = 0;

			if (keys.ArrowUp || keys.w || keys.W) {
				moveY -= speed;
			}
			if (keys.ArrowDown || keys.s || keys.S) {
				moveY += speed;
			}
			if (keys.ArrowLeft || keys.a || keys.A) {
				moveX -= speed;
			}
			if (keys.ArrowRight || keys.d || keys.D) {
				moveX += speed;
			}

			player.x = clamp(player.x + moveX, player.r, fieldWidth - player.r);
			player.y = clamp(player.y + moveY, player.r, fieldHeight - player.r);
		}

		function handleAi() {
			const aiSpeed = 3.2;
			const defendBias = ball.x < fieldWidth * 0.58 ? 1 : 0;
			let targetX = ball.x;
			let targetY = ball.y;

			if (defendBias) {
				targetX = Math.max(fieldWidth * 0.55, ball.x);
			}

			const dx = targetX - ai.x;
			const dy = targetY - ai.y;
			const len = Math.sqrt((dx * dx) + (dy * dy)) || 1;

			if (len > 2) {
				ai.x = clamp(ai.x + (dx / len) * aiSpeed, ai.r, fieldWidth - ai.r);
				ai.y = clamp(ai.y + (dy / len) * aiSpeed, ai.r, fieldHeight - ai.r);
			}

			if (aiNearBall()) {
				const shootChance = ball.x < fieldWidth * 0.55 ? 0.2 : 0.75;

				if (Math.random() < shootChance) {
					const targetGoalY = goalTop + 12 + Math.random() * (goalBottom - goalTop - 24);
					kickBall(ai, 0, targetGoalY, 7.2);
					setMessage('AI shoots.');
				} else {
					const passY = clamp(ball.y + (Math.random() * 80 - 40), 20, fieldHeight - 20);
					kickBall(ai, fieldWidth * 0.55, passY, 5.3);
					setMessage('AI dribbles.');
				}
			}
		}

		function handleCollisions() {
			const pushStrength = 0.75;

			if (playerNearBall()) {
				const dx = ball.x - player.x;
				const dy = ball.y - player.y;
				const len = Math.sqrt((dx * dx) + (dy * dy)) || 1;

				ball.x = player.x + (dx / len) * (player.r + ball.r + 1);
				ball.y = player.y + (dy / len) * (player.r + ball.r + 1);

				ball.vx += (dx / len) * pushStrength;
				ball.vy += (dy / len) * pushStrength;
			}

			if (aiNearBall()) {
				const dx = ball.x - ai.x;
				const dy = ball.y - ai.y;
				const len = Math.sqrt((dx * dx) + (dy * dy)) || 1;

				ball.x = ai.x + (dx / len) * (ai.r + ball.r + 1);
				ball.y = ai.y + (dy / len) * (ai.r + ball.r + 1);

				ball.vx += (dx / len) * pushStrength;
				ball.vy += (dy / len) * pushStrength;
			}
		}

		function updateBall() {
			ball.x += ball.vx;
			ball.y += ball.vy;

			ball.vx *= 0.985;
			ball.vy *= 0.985;

			if (Math.abs(ball.vx) < 0.03) {
				ball.vx = 0;
			}
			if (Math.abs(ball.vy) < 0.03) {
				ball.vy = 0;
			}

			const inGoalVertical = ball.y > goalTop && ball.y < goalBottom;

			if (ball.y <= ball.r) {
				ball.y = ball.r;
				ball.vy *= -0.9;
			}
			if (ball.y >= fieldHeight - ball.r) {
				ball.y = fieldHeight - ball.r;
				ball.vy *= -0.9;
			}

			if (ball.x <= ball.r) {
				if (inGoalVertical) {
					playerScore++;
					updateHud();
					setMessage('Goal for you.');
					resetPositions(false);
					return;
				}
				ball.x = ball.r;
				ball.vx *= -0.9;
			}

			if (ball.x >= fieldWidth - ball.r) {
				if (inGoalVertical) {
					aiScore++;
					updateHud();
					setMessage('AI scores.');
					resetPositions(true);
					return;
				}
				ball.x = fieldWidth - ball.r;
				ball.vx *= -0.9;
			}
		}

		function endGame() {
			running = false;
			window.clearInterval(timerId);
			timerId = null;

			if (playerScore > aiScore) {
				setMessage('You win ' + playerScore + ' to ' + aiScore + '.');
			} else if (aiScore > playerScore) {
				setMessage('AI wins ' + aiScore + ' to ' + playerScore + '.');
			} else {
				setMessage('Draw game ' + playerScore + ' to ' + aiScore + '.');
			}
		}

		function tick() {
			if (!running) {
				return;
			}

			handlePlayerInput();
			handleAi();
			handleCollisions();
			updateBall();
			draw();

			animationId = window.requestAnimationFrame(tick);
		}

		function startGame() {
			updateFieldSize();

			playerScore = 0;
			aiScore = 0;
			timeLeft = 60;
			running = true;
			keys = {};

			updateHud();
			resetPositions(true);
			setMessage('Game started. Move and shoot.');

			if (timerId) {
				window.clearInterval(timerId);
			}

			timerId = window.setInterval(function () {
				if (!running) {
					return;
				}

				timeLeft--;
				updateHud();

				if (timeLeft <= 0) {
					endGame();
				}
			}, 1000);

			if (animationId) {
				window.cancelAnimationFrame(animationId);
			}
			animationId = window.requestAnimationFrame(tick);
		}

		function playerShoot() {
			if (!running || !playerNearBall()) {
				return;
			}

			const targetGoalY = goalTop + 15 + Math.random() * (goalBottom - goalTop - 30);
			kickBall(player, fieldWidth, targetGoalY, 7.4);
			setMessage('You shoot.');
		}

		document.addEventListener('keydown', function (event) {
			if (!game.contains(document.activeElement) && document.activeElement && document.activeElement.tagName) {
				// keep controls available even when buttons are focused
			}
			keys[event.key] = true;

			if (event.key === ' ' || event.code === 'Space') {
				event.preventDefault();
				playerShoot();
			}
		});

		document.addEventListener('keyup', function (event) {
			delete keys[event.key];
		});

		moveButtons.forEach(function (button) {
			function press() {
				const dir = button.getAttribute('data-dir');
				keys[dir] = true;
			}

			function release() {
				const dir = button.getAttribute('data-dir');
				delete keys[dir];
			}

			button.addEventListener('mousedown', press);
			button.addEventListener('mouseup', release);
			button.addEventListener('mouseleave', release);
			button.addEventListener('touchstart', function (event) {
				event.preventDefault();
				press();
			}, { passive: false });
			button.addEventListener('touchend', function (event) {
				event.preventDefault();
				release();
			}, { passive: false });
			button.addEventListener('touchcancel', function (event) {
				event.preventDefault();
				release();
			}, { passive: false });
		});

		shootBtn.addEventListener('click', function () {
			playerShoot();
		});

		restartBtn.addEventListener('click', function () {
			startGame();
		});

		window.addEventListener('resize', function () {
			updateFieldSize();
			player.x = clamp(player.x, player.r, fieldWidth - player.r);
			player.y = clamp(player.y, player.r, fieldHeight - player.r);
			ai.x = clamp(ai.x, ai.r, fieldWidth - ai.r);
			ai.y = clamp(ai.y, ai.r, fieldHeight - ai.r);
			ball.x = clamp(ball.x, ball.r, fieldWidth - ball.r);
			ball.y = clamp(ball.y, ball.r, fieldHeight - ball.r);
			draw();
		});

		startGame();
	});
});
JS;

if (!function_exists('zo_game_soccer_vs_ai_render')) {
	function zo_game_soccer_vs_ai_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-soccer-vs-ai-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--soccer-vs-ai" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-soccer-card">
				<h2 class="zo-soccer-title">Soccer vs AI</h2>
				<p class="zo-soccer-help">You are blue. The AI is red. Use arrow keys or WASD to move. Press Space or Shoot when close to the ball.</p>

				<div class="zo-soccer-topbar">
					<div class="zo-soccer-stat">You: <span class="zo-soccer-player-score">0</span></div>
					<div class="zo-soccer-stat">AI: <span class="zo-soccer-ai-score">0</span></div>
					<div class="zo-soccer-stat">Time: <span class="zo-soccer-time">60</span></div>
				</div>

				<div class="zo-soccer-field">
					<div class="zo-soccer-goal zo-soccer-goal--left"></div>
					<div class="zo-soccer-goal zo-soccer-goal--right"></div>
					<div class="zo-soccer-center-circle"></div>
					<div class="zo-soccer-player">Y</div>
					<div class="zo-soccer-ai">AI</div>
					<div class="zo-soccer-ball"></div>
				</div>

				<div class="zo-soccer-controls">
					<button type="button" class="zo-soccer-control zo-soccer-control--up" data-dir="ArrowUp">▲</button>
					<button type="button" class="zo-soccer-control zo-soccer-control--left" data-dir="ArrowLeft">◀</button>
					<button type="button" class="zo-soccer-control zo-soccer-control--down" data-dir="ArrowDown">▼</button>
					<button type="button" class="zo-soccer-control zo-soccer-control--right" data-dir="ArrowRight">▶</button>
				</div>

				<div class="zo-soccer-buttons">
					<button type="button" class="zo-soccer-btn zo-soccer-btn--shoot">Shoot</button>
					<button type="button" class="zo-soccer-btn zo-soccer-btn--restart">Restart</button>
				</div>

				<div class="zo-soccer-message">Game started. Move and shoot.</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'soccer-vs-ai',
	'name'            => 'Soccer vs AI',
	'author'          => 'Arslan',
	'description'     => 'A simple soccer game where you play against an AI opponent.',
	'render_callback' => 'zo_game_soccer_vs_ai_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);