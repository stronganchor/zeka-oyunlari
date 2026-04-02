<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root--soccer-match {
	max-width: 760px;
	margin: 0 auto;
	text-align: center;
	font-family: Arial, sans-serif;
}

.zo-game-root--soccer-match * {
	box-sizing: border-box;
}

.zo-soccer-wrap {
	background: #f4f7f2;
	border: 2px solid #d7e0d0;
	border-radius: 18px;
	padding: 14px;
}

.zo-soccer-topbar {
	display: flex;
	justify-content: space-between;
	align-items: center;
	gap: 10px;
	flex-wrap: wrap;
	margin-bottom: 12px;
}

.zo-soccer-scoreboard {
	display: flex;
	gap: 10px;
	flex-wrap: wrap;
	justify-content: center;
}

.zo-soccer-scorebox,
.zo-soccer-status {
	background: #ffffff;
	border: 2px solid #dfe7d8;
	border-radius: 12px;
	padding: 10px 14px;
	min-width: 120px;
}

.zo-soccer-scorebox strong,
.zo-soccer-status strong {
	display: block;
	font-size: 18px;
	color: #1d2a1d;
}

.zo-soccer-scorebox span,
.zo-soccer-status span {
	display: block;
	font-size: 14px;
	color: #445244;
	margin-top: 4px;
}

.zo-soccer-field {
	position: relative;
	width: 100%;
	max-width: 720px;
	height: 440px;
	margin: 0 auto;
	background:
		linear-gradient(
			to bottom,
			#3aa655 0%,
			#3aa655 12.5%,
			#349a4f 12.5%,
			#349a4f 25%,
			#3aa655 25%,
			#3aa655 37.5%,
			#349a4f 37.5%,
			#349a4f 50%,
			#3aa655 50%,
			#3aa655 62.5%,
			#349a4f 62.5%,
			#349a4f 75%,
			#3aa655 75%,
			#3aa655 87.5%,
			#349a4f 87.5%,
			#349a4f 100%
		);
	border: 4px solid #ffffff;
	border-radius: 18px;
	overflow: hidden;
	touch-action: none;
	outline: none;
}

.zo-soccer-line-mid,
.zo-soccer-circle,
.zo-soccer-box-left,
.zo-soccer-box-right,
.zo-soccer-goal-left,
.zo-soccer-goal-right,
.zo-soccer-dot {
	position: absolute;
	pointer-events: none;
}

.zo-soccer-line-mid {
	left: 50%;
	top: 0;
	width: 4px;
	height: 100%;
	margin-left: -2px;
	background: rgba(255,255,255,0.95);
}

.zo-soccer-circle {
	left: 50%;
	top: 50%;
	width: 110px;
	height: 110px;
	margin-left: -55px;
	margin-top: -55px;
	border: 4px solid rgba(255,255,255,0.95);
	border-radius: 50%;
}

.zo-soccer-dot {
	width: 10px;
	height: 10px;
	background: rgba(255,255,255,0.95);
	border-radius: 50%;
	left: 50%;
	top: 50%;
	margin-left: -5px;
	margin-top: -5px;
}

.zo-soccer-box-left,
.zo-soccer-box-right {
	top: 120px;
	width: 95px;
	height: 200px;
	border: 4px solid rgba(255,255,255,0.95);
}

.zo-soccer-box-left {
	left: 0;
	border-left: none;
	border-radius: 0 10px 10px 0;
}

.zo-soccer-box-right {
	right: 0;
	border-right: none;
	border-radius: 10px 0 0 10px;
}

.zo-soccer-goal-left,
.zo-soccer-goal-right {
	top: 165px;
	width: 18px;
	height: 110px;
	background: rgba(255,255,255,0.95);
}

.zo-soccer-goal-left {
	left: 0;
	border-radius: 0 6px 6px 0;
}

.zo-soccer-goal-right {
	right: 0;
	border-radius: 6px 0 0 6px;
}

.zo-soccer-player,
.zo-soccer-ball {
	position: absolute;
	border-radius: 50%;
	transform: translate(-50%, -50%);
	user-select: none;
	pointer-events: none;
}

.zo-soccer-player {
	width: 28px;
	height: 28px;
	box-shadow: 0 2px 0 rgba(0,0,0,0.18);
}

.zo-soccer-player::after {
	content: '';
	position: absolute;
	left: 50%;
	top: 50%;
	width: 9px;
	height: 9px;
	margin-left: -4.5px;
	margin-top: -4.5px;
	border-radius: 50%;
	background: rgba(255,255,255,0.9);
}

.zo-soccer-player--user {
	background: #1976d2;
}

.zo-soccer-player--ally {
	background: #44a5ff;
}

.zo-soccer-player--enemy {
	background: #d83a3a;
}

.zo-soccer-ball {
	width: 18px;
	height: 18px;
	background:
		radial-gradient(circle at 35% 35%, #ffffff 0%, #ffffff 55%, #efefef 100%);
	border: 2px solid #222;
	box-shadow: 0 1px 0 rgba(0,0,0,0.15);
}

.zo-soccer-controls {
	margin-top: 14px;
	display: flex;
	flex-direction: column;
	gap: 10px;
	align-items: center;
}

.zo-soccer-buttons {
	display: flex;
	gap: 8px;
	flex-wrap: wrap;
	justify-content: center;
}

.zo-soccer-btn {
	border: none;
	border-radius: 10px;
	padding: 10px 14px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	background: #1d2a1d;
	color: #fff;
}

.zo-soccer-btn:hover {
	opacity: 0.92;
}

.zo-soccer-help {
	background: #ffffff;
	border: 2px solid #dfe7d8;
	border-radius: 12px;
	padding: 10px 14px;
	font-size: 14px;
	line-height: 1.45;
	color: #334233;
	max-width: 720px;
}

.zo-soccer-mobilepad {
	display: none;
	grid-template-columns: repeat(3, 62px);
	grid-template-rows: repeat(3, 62px);
	gap: 8px;
	justify-content: center;
	margin-top: 6px;
}

.zo-soccer-padbtn {
	border: none;
	border-radius: 12px;
	background: #ffffff;
	border: 2px solid #dfe7d8;
	font-size: 24px;
	font-weight: 700;
	color: #1d2a1d;
}

.zo-soccer-padbtn:active {
	transform: scale(0.97);
}

@media (max-width: 700px) {
	.zo-soccer-field {
		height: 400px;
	}

	.zo-soccer-mobilepad {
		display: grid;
	}
}

@media (max-width: 520px) {
	.zo-soccer-field {
		height: 360px;
	}

	.zo-soccer-scorebox,
	.zo-soccer-status {
		min-width: 100px;
		padding: 8px 10px;
	}

	.zo-soccer-help {
		font-size: 13px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--soccer-match');

	games.forEach(function (game) {
		const field = game.querySelector('.zo-soccer-field');
		const scoreUser = game.querySelector('.zo-score-user');
		const scoreAi = game.querySelector('.zo-score-ai');
		const timerEl = game.querySelector('.zo-status-timer');
		const messageEl = game.querySelector('.zo-status-message');
		const restartBtn = game.querySelector('.zo-soccer-restart');
		const startBtn = game.querySelector('.zo-soccer-start');
		const padButtons = game.querySelectorAll('.zo-soccer-padbtn');

		const FIELD_W = 720;
		const FIELD_H = 440;
		const PLAYER_R = 14;
		const BALL_R = 9;
		const GOAL_TOP = 165;
		const GOAL_BOTTOM = 275;
		const MATCH_TIME = 60;

		let animationId = null;
		let lastTime = 0;
		let running = false;
		let started = false;
		let userScore = 0;
		let aiScore = 0;
		let remaining = MATCH_TIME;
		let userInput = { up: false, down: false, left: false, right: false };

		function clamp(value, min, max) {
			return Math.max(min, Math.min(max, value));
		}

		function distance(a, b) {
			const dx = a.x - b.x;
			const dy = a.y - b.y;
			return Math.sqrt(dx * dx + dy * dy);
		}

		function makePlayer(role, team, x, y) {
			return {
				role: role,
				team: team,
				x: x,
				y: y,
				vx: 0,
				vy: 0,
				speed: role === 'user' ? 168 : 132,
				el: null
			};
		}

		const state = {
			ball: { x: FIELD_W / 2, y: FIELD_H / 2, vx: 0, vy: 0 },
			players: [
				makePlayer('user', 'blue', 130, FIELD_H / 2),
				makePlayer('ally', 'blue', 240, 135),
				makePlayer('ally', 'blue', 240, 305),
				makePlayer('enemy', 'red', 585, FIELD_H / 2),
				makePlayer('enemy', 'red', 480, 135),
				makePlayer('enemy', 'red', 480, 305)
			]
		};

		function buildPlayers() {
			field.querySelectorAll('.zo-soccer-player, .zo-soccer-ball').forEach(function (node) {
				node.remove();
			});

			state.players.forEach(function (player) {
				const el = document.createElement('div');
				el.className = 'zo-soccer-player zo-soccer-player--' + player.role;
				field.appendChild(el);
				player.el = el;
			});

			const ballEl = document.createElement('div');
			ballEl.className = 'zo-soccer-ball';
			field.appendChild(ballEl);
			state.ball.el = ballEl;
		}

		function resetPositions() {
			state.ball.x = FIELD_W / 2;
			state.ball.y = FIELD_H / 2;
			state.ball.vx = 0;
			state.ball.vy = 0;

			state.players[0].x = 130;
			state.players[0].y = FIELD_H / 2;
			state.players[1].x = 240;
			state.players[1].y = 135;
			state.players[2].x = 240;
			state.players[2].y = 305;
			state.players[3].x = 585;
			state.players[3].y = FIELD_H / 2;
			state.players[4].x = 480;
			state.players[4].y = 135;
			state.players[5].x = 480;
			state.players[5].y = 305;

			state.players.forEach(function (player) {
				player.vx = 0;
				player.vy = 0;
			});
		}

		function resetMatch() {
			userScore = 0;
			aiScore = 0;
			remaining = MATCH_TIME;
			started = false;
			running = false;
			lastTime = 0;
			userInput.up = false;
			userInput.down = false;
			userInput.left = false;
			userInput.right = false;
			resetPositions();
			updateHud();
			setMessage('Press Start Match');
			if (animationId) {
				cancelAnimationFrame(animationId);
				animationId = null;
			}
			render();
		}

		function updateHud() {
			scoreUser.textContent = String(userScore);
			scoreAi.textContent = String(aiScore);
			timerEl.textContent = String(Math.max(0, Math.ceil(remaining)));
		}

		function setMessage(text) {
			messageEl.textContent = text;
		}

		function render() {
			const rect = field.getBoundingClientRect();
			const scaleX = rect.width / FIELD_W;
			const scaleY = rect.height / FIELD_H;

			state.players.forEach(function (player) {
				player.el.style.left = (player.x * scaleX) + 'px';
				player.el.style.top = (player.y * scaleY) + 'px';
			});

			state.ball.el.style.left = (state.ball.x * scaleX) + 'px';
			state.ball.el.style.top = (state.ball.y * scaleY) + 'px';
		}

		function applyUserMovement(dt) {
			const user = state.players[0];
			let mx = 0;
			let my = 0;

			if (userInput.up) my -= 1;
			if (userInput.down) my += 1;
			if (userInput.left) mx -= 1;
			if (userInput.right) mx += 1;

			if (mx !== 0 || my !== 0) {
				const len = Math.sqrt(mx * mx + my * my);
				mx /= len;
				my /= len;
				user.vx = mx * user.speed;
				user.vy = my * user.speed;
			} else {
				user.vx *= 0.80;
				user.vy *= 0.80;
			}

			user.x += user.vx * dt;
			user.y += user.vy * dt;
		}

		function aiMovePlayer(player, dt) {
			const ball = state.ball;
			const attackingRight = player.team === 'blue';
			let homeX = player.team === 'blue' ? 240 : 480;
			let homeY = player.y;

			if (player.role === 'enemy') {
				if (player === state.players[3]) {
					homeX = 585;
					homeY = FIELD_H / 2;
				} else if (player === state.players[4]) {
					homeX = 480;
					homeY = 135;
				} else {
					homeX = 480;
					homeY = 305;
				}
			} else {
				if (player === state.players[1]) {
					homeX = 240;
					homeY = 135;
				} else if (player === state.players[2]) {
					homeX = 240;
					homeY = 305;
				}
			}

			let targetX = homeX;
			let targetY = homeY;

			const ballOnTheirSide = attackingRight ? ball.x > FIELD_W * 0.45 : ball.x < FIELD_W * 0.55;
			const nearestDistance = distance(player, ball);

			if (nearestDistance < 140 || ballOnTheirSide) {
				targetX = ball.x + (attackingRight ? -12 : 12);
				targetY = ball.y;
			}

			const dx = targetX - player.x;
			const dy = targetY - player.y;
			const dist = Math.sqrt(dx * dx + dy * dy);

			if (dist > 1) {
				player.vx = (dx / dist) * player.speed * 0.88;
				player.vy = (dy / dist) * player.speed * 0.88;
			} else {
				player.vx *= 0.8;
				player.vy *= 0.8;
			}

			player.x += player.vx * dt;
			player.y += player.vy * dt;
		}

		function keepPlayersInBounds() {
			state.players.forEach(function (player) {
				player.x = clamp(player.x, PLAYER_R, FIELD_W - PLAYER_R);
				player.y = clamp(player.y, PLAYER_R, FIELD_H - PLAYER_R);
			});
		}

		function pushBallFromPlayers() {
			state.players.forEach(function (player) {
				const dx = state.ball.x - player.x;
				const dy = state.ball.y - player.y;
				const dist = Math.sqrt(dx * dx + dy * dy);
				const minDist = PLAYER_R + BALL_R;

				if (dist > 0 && dist < minDist) {
					const nx = dx / dist;
					const ny = dy / dist;
					const overlap = minDist - dist;

					state.ball.x += nx * overlap;
					state.ball.y += ny * overlap;

					const kickPower = player.role === 'user' ? 210 : 185;
					state.ball.vx += nx * kickPower;
					state.ball.vy += ny * kickPower;

					if (player.team === 'blue') {
						state.ball.vx += 28;
					} else {
						state.ball.vx -= 28;
					}
				}
			});
		}

		function updateBall(dt) {
			state.ball.x += state.ball.vx * dt;
			state.ball.y += state.ball.vy * dt;

			state.ball.vx *= 0.992;
			state.ball.vy *= 0.992;

			if (state.ball.y <= BALL_R) {
				state.ball.y = BALL_R;
				state.ball.vy *= -0.9;
			}
			if (state.ball.y >= FIELD_H - BALL_R) {
				state.ball.y = FIELD_H - BALL_R;
				state.ball.vy *= -0.9;
			}

			const inGoalOpening = state.ball.y >= GOAL_TOP && state.ball.y <= GOAL_BOTTOM;

			if (!inGoalOpening) {
				if (state.ball.x <= BALL_R) {
					state.ball.x = BALL_R;
					state.ball.vx *= -0.9;
				}
				if (state.ball.x >= FIELD_W - BALL_R) {
					state.ball.x = FIELD_W - BALL_R;
					state.ball.vx *= -0.9;
				}
			}

			if (state.ball.x < -10 && inGoalOpening) {
				aiScore += 1;
				updateHud();
				setMessage('AI scored');
				resetPositions();
			}

			if (state.ball.x > FIELD_W + 10 && inGoalOpening) {
				userScore += 1;
				updateHud();
				setMessage('You scored');
				resetPositions();
			}
		}

		function updatePlayers(dt) {
			applyUserMovement(dt);
			aiMovePlayer(state.players[1], dt);
			aiMovePlayer(state.players[2], dt);
			aiMovePlayer(state.players[3], dt);
			aiMovePlayer(state.players[4], dt);
			aiMovePlayer(state.players[5], dt);
			keepPlayersInBounds();
		}

		function loop(ts) {
			if (!running) {
				return;
			}

			if (!lastTime) {
				lastTime = ts;
			}

			let dt = (ts - lastTime) / 1000;
			lastTime = ts;

			if (dt > 0.03) {
				dt = 0.03;
			}

			remaining -= dt;
			if (remaining <= 0) {
				remaining = 0;
				running = false;
				updateHud();
				render();

				if (userScore > aiScore) {
					setMessage('You win');
				} else if (userScore < aiScore) {
					setMessage('AI wins');
				} else {
					setMessage('Draw match');
				}
				return;
			}

			updatePlayers(dt);
			pushBallFromPlayers();
			updateBall(dt);
			updateHud();
			render();

			animationId = requestAnimationFrame(loop);
		}

		function startMatch() {
			if (running) {
				return;
			}
			if (!started) {
				userScore = 0;
				aiScore = 0;
				remaining = MATCH_TIME;
				resetPositions();
				started = true;
			}
			running = true;
			lastTime = 0;
			setMessage('Match in progress');
			field.focus();
			animationId = requestAnimationFrame(loop);
		}

		function setInputFromKey(key, isDown) {
			if (key === 'ArrowUp' || key === 'w' || key === 'W') userInput.up = isDown;
			if (key === 'ArrowDown' || key === 's' || key === 'S') userInput.down = isDown;
			if (key === 'ArrowLeft' || key === 'a' || key === 'A') userInput.left = isDown;
			if (key === 'ArrowRight' || key === 'd' || key === 'D') userInput.right = isDown;
		}

		game.addEventListener('keydown', function (e) {
			if (['ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'w', 'W', 'a', 'A', 's', 'S', 'd', 'D'].indexOf(e.key) !== -1) {
				e.preventDefault();
				setInputFromKey(e.key, true);
			}
		});

		game.addEventListener('keyup', function (e) {
			setInputFromKey(e.key, false);
		});

		field.addEventListener('keydown', function (e) {
			if (['ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'w', 'W', 'a', 'A', 's', 'S', 'd', 'D'].indexOf(e.key) !== -1) {
				e.preventDefault();
				setInputFromKey(e.key, true);
			}
		});

		field.addEventListener('keyup', function (e) {
			setInputFromKey(e.key, false);
		});

		padButtons.forEach(function (btn) {
			const dir = btn.getAttribute('data-dir');

			function press(stateValue) {
				if (dir === 'up') userInput.up = stateValue;
				if (dir === 'down') userInput.down = stateValue;
				if (dir === 'left') userInput.left = stateValue;
				if (dir === 'right') userInput.right = stateValue;
			}

			btn.addEventListener('touchstart', function (e) {
				e.preventDefault();
				press(true);
				field.focus();
			}, { passive: false });

			btn.addEventListener('touchend', function (e) {
				e.preventDefault();
				press(false);
			}, { passive: false });

			btn.addEventListener('mousedown', function (e) {
				e.preventDefault();
				press(true);
				field.focus();
			});

			btn.addEventListener('mouseup', function () {
				press(false);
			});

			btn.addEventListener('mouseleave', function () {
				press(false);
			});
		});

		startBtn.addEventListener('click', function () {
			startMatch();
		});

		restartBtn.addEventListener('click', function () {
			resetMatch();
			field.focus();
		});

		buildPlayers();
		resetMatch();
	});
});
JS;

if (!function_exists('zo_game_soccer_match_render')) {
	function zo_game_soccer_match_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-soccer-match-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--soccer-match" id="<?php echo esc_attr($instance_id); ?>" tabindex="0">
			<div class="zo-soccer-wrap">
				<div class="zo-soccer-topbar">
					<div class="zo-soccer-scoreboard">
						<div class="zo-soccer-scorebox">
							<strong class="zo-score-user">0</strong>
							<span>Your Team</span>
						</div>
						<div class="zo-soccer-scorebox">
							<strong class="zo-score-ai">0</strong>
							<span>AI Team</span>
						</div>
						<div class="zo-soccer-status">
							<strong class="zo-status-timer">60</strong>
							<span>Seconds Left</span>
						</div>
						<div class="zo-soccer-status">
							<strong class="zo-status-message">Press Start Match</strong>
							<span>Match Status</span>
						</div>
					</div>
				</div>

				<div class="zo-soccer-field" tabindex="0" aria-label="Soccer field game area">
					<div class="zo-soccer-line-mid"></div>
					<div class="zo-soccer-circle"></div>
					<div class="zo-soccer-dot"></div>
					<div class="zo-soccer-box-left"></div>
					<div class="zo-soccer-box-right"></div>
					<div class="zo-soccer-goal-left"></div>
					<div class="zo-soccer-goal-right"></div>
				</div>

				<div class="zo-soccer-controls">
					<div class="zo-soccer-buttons">
						<button type="button" class="zo-soccer-btn zo-soccer-start">Start Match</button>
						<button type="button" class="zo-soccer-btn zo-soccer-restart">Restart</button>
					</div>

					<div class="zo-soccer-help">
						Use arrow keys or WASD to control one blue player. The other two blue players are AI teammates. Score more goals than the red AI team before time runs out.
					</div>

					<div class="zo-soccer-mobilepad" aria-hidden="false">
						<div></div>
						<button type="button" class="zo-soccer-padbtn" data-dir="up">↑</button>
						<div></div>
						<button type="button" class="zo-soccer-padbtn" data-dir="left">←</button>
						<div></div>
						<button type="button" class="zo-soccer-padbtn" data-dir="right">→</button>
						<div></div>
						<button type="button" class="zo-soccer-padbtn" data-dir="down">↓</button>
						<div></div>
					</div>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'soccer-match-ai',
	'name'            => 'Soccer Match AI',
	'author'          => 'Asker',
	'description'     => 'A soccer match game where you control one player and the other teammates are AI.',
	'render_callback' => 'zo_game_soccer_match_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);