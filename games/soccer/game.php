<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root--soccer-match-ai {
	max-width: 1100px;
	margin: 0 auto;
	text-align: center;
	font-family: Arial, sans-serif;
}

.zo-game-root--soccer-match-ai * {
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
	flex-wrap: wrap;
	gap: 10px;
	justify-content: center;
	margin-bottom: 12px;
}

.zo-soccer-panel {
	background: #fff;
	border: 2px solid #dfe7d8;
	border-radius: 12px;
	padding: 10px 14px;
	min-width: 120px;
}

.zo-soccer-panel strong {
	display: block;
	font-size: 20px;
	color: #1d2a1d;
}

.zo-soccer-panel span {
	display: block;
	font-size: 14px;
	color: #445244;
	margin-top: 4px;
}

.zo-soccer-rolebar {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
	justify-content: center;
	margin-bottom: 12px;
}

.zo-soccer-rolebtn,
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

.zo-soccer-rolebtn.is-active {
	background: #1565c0;
}

.zo-soccer-btn:hover,
.zo-soccer-rolebtn:hover {
	opacity: 0.92;
}

.zo-soccer-btn[disabled] {
	opacity: 0.45;
	cursor: default;
}

.zo-soccer-field {
	position: relative;
	width: 100%;
	max-width: 1040px;
	height: 620px;
	margin: 0 auto;
	background:
		linear-gradient(
			to bottom,
			#3aa655 0%,
			#3aa655 10%,
			#349a4f 10%,
			#349a4f 20%,
			#3aa655 20%,
			#3aa655 30%,
			#349a4f 30%,
			#349a4f 40%,
			#3aa655 40%,
			#3aa655 50%,
			#349a4f 50%,
			#349a4f 60%,
			#3aa655 60%,
			#3aa655 70%,
			#349a4f 70%,
			#349a4f 80%,
			#3aa655 80%,
			#3aa655 90%,
			#349a4f 90%,
			#349a4f 100%
		);
	border: 4px solid #fff;
	border-radius: 18px;
	overflow: hidden;
	touch-action: none;
	outline: none;
	user-select: none;
}

.zo-soccer-line-mid,
.zo-soccer-circle,
.zo-soccer-dot,
.zo-soccer-box-left,
.zo-soccer-box-right,
.zo-soccer-goal-left,
.zo-soccer-goal-right,
.zo-soccer-smallbox-left,
.zo-soccer-smallbox-right,
.zo-soccer-corner-arc {
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
	width: 140px;
	height: 140px;
	margin-left: -70px;
	margin-top: -70px;
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
	top: 190px;
	width: 130px;
	height: 240px;
	border: 4px solid rgba(255,255,255,0.95);
}

.zo-soccer-smallbox-left,
.zo-soccer-smallbox-right {
	top: 245px;
	width: 60px;
	height: 130px;
	border: 4px solid rgba(255,255,255,0.95);
}

.zo-soccer-box-left,
.zo-soccer-smallbox-left {
	left: 0;
	border-left: none;
	border-radius: 0 10px 10px 0;
}

.zo-soccer-box-right,
.zo-soccer-smallbox-right {
	right: 0;
	border-right: none;
	border-radius: 10px 0 0 10px;
}

.zo-soccer-goal-left,
.zo-soccer-goal-right {
	top: 245px;
	width: 18px;
	height: 130px;
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

.zo-soccer-corner-arc {
	width: 34px;
	height: 34px;
	border: 4px solid rgba(255,255,255,0.95);
	border-radius: 50%;
}

.zo-soccer-corner-arc--tl {
	left: -17px;
	top: -17px;
}

.zo-soccer-corner-arc--tr {
	right: -17px;
	top: -17px;
}

.zo-soccer-corner-arc--bl {
	left: -17px;
	bottom: -17px;
}

.zo-soccer-corner-arc--br {
	right: -17px;
	bottom: -17px;
}

.zo-soccer-player,
.zo-soccer-ball,
.zo-soccer-target {
	position: absolute;
	transform: translate(-50%, -50%);
	pointer-events: none;
}

.zo-soccer-player {
	width: 26px;
	height: 40px;
}

.zo-soccer-player__arrow {
	position: absolute;
	left: 50%;
	top: -18px;
	transform: translateX(-50%);
	width: 0;
	height: 0;
	border-left: 8px solid transparent;
	border-right: 8px solid transparent;
	border-bottom: 12px solid #ffd54f;
	display: none;
}

.zo-soccer-player--user .zo-soccer-player__arrow {
	display: block;
}

.zo-soccer-player__head {
	position: absolute;
	left: 50%;
	top: 1px;
	width: 12px;
	height: 12px;
	margin-left: -6px;
	border-radius: 50%;
	background: #f2c59a;
	border: 1px solid rgba(0,0,0,0.18);
}

.zo-soccer-player__body {
	position: absolute;
	left: 50%;
	top: 12px;
	width: 18px;
	height: 15px;
	margin-left: -9px;
	border-radius: 7px 7px 6px 6px;
	border: 1px solid rgba(0,0,0,0.16);
}

.zo-soccer-player__legs {
	position: absolute;
	left: 50%;
	top: 27px;
	width: 18px;
	height: 11px;
	margin-left: -9px;
}

.zo-soccer-player__legs::before,
.zo-soccer-player__legs::after {
	content: '';
	position: absolute;
	top: 0;
	width: 4px;
	height: 11px;
	background: #202020;
	border-radius: 3px;
}

.zo-soccer-player__legs::before {
	left: 3px;
}

.zo-soccer-player__legs::after {
	right: 3px;
}

.zo-soccer-player__name {
	position: absolute;
	left: 50%;
	top: 40px;
	transform: translateX(-50%);
	font-size: 10px;
	font-weight: 700;
	line-height: 1;
	padding: 2px 5px;
	border-radius: 8px;
	white-space: nowrap;
	background: rgba(255,255,255,0.85);
	color: #1d2a1d;
	display: none;
}

.zo-soccer-player--user .zo-soccer-player__name {
	display: block;
}

.zo-soccer-player--blue .zo-soccer-player__body {
	background: #1e88e5;
}

.zo-soccer-player--red .zo-soccer-player__body {
	background: #e53935;
}

.zo-soccer-player--goalie.zo-soccer-player--blue .zo-soccer-player__body {
	background: #7b1fa2;
}

.zo-soccer-player--goalie.zo-soccer-player--red .zo-soccer-player__body {
	background: #ef6c00;
}

.zo-soccer-ball {
	width: 16px;
	height: 16px;
	border-radius: 50%;
	background: radial-gradient(circle at 35% 35%, #ffffff 0%, #ffffff 55%, #ededed 100%);
	border: 2px solid #222;
	box-shadow: 0 1px 0 rgba(0,0,0,0.15);
}

.zo-soccer-target {
	width: 26px;
	height: 26px;
	border-radius: 50%;
	border: 3px dashed rgba(255,255,255,0.9);
	display: none;
}

.zo-soccer-target.is-active {
	display: block;
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

.zo-soccer-help,
.zo-soccer-shop {
	background: #fff;
	border: 2px solid #dfe7d8;
	border-radius: 12px;
	padding: 10px 14px;
	font-size: 14px;
	line-height: 1.45;
	color: #334233;
	max-width: 980px;
	width: 100%;
}

.zo-soccer-shop-title {
	font-weight: 700;
	font-size: 16px;
	margin-bottom: 8px;
	color: #1d2a1d;
}

.zo-soccer-mobilepad {
	display: none;
	grid-template-columns: repeat(3, 60px);
	grid-template-rows: repeat(3, 60px);
	gap: 8px;
	justify-content: center;
	margin-top: 4px;
}

.zo-soccer-padbtn {
	border: none;
	border-radius: 12px;
	background: #fff;
	border: 2px solid #dfe7d8;
	font-size: 24px;
	font-weight: 700;
	color: #1d2a1d;
}

.zo-soccer-padbtn:active {
	transform: scale(0.97);
}

@media (max-width: 820px) {
	.zo-soccer-field {
		height: 540px;
	}
}

@media (max-width: 700px) {
	.zo-soccer-field {
		height: 460px;
	}

	.zo-soccer-mobilepad {
		display: grid;
	}
}

@media (max-width: 520px) {
	.zo-soccer-field {
		height: 380px;
	}

	.zo-soccer-panel {
		min-width: 100px;
		padding: 8px 10px;
	}

	.zo-soccer-help,
	.zo-soccer-shop {
		font-size: 13px;
	}

	.zo-soccer-player__name {
		font-size: 9px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--soccer-match-ai');

	games.forEach(function (game) {
		const field = game.querySelector('.zo-soccer-field');
		const scoreUserEl = game.querySelector('.zo-score-user');
		const scoreAiEl = game.querySelector('.zo-score-ai');
		const timerEl = game.querySelector('.zo-status-timer');
		const messageEl = game.querySelector('.zo-status-message');
		const coinsEl = game.querySelector('.zo-status-coins');
		const speedEl = game.querySelector('.zo-status-speed');
		const roleEl = game.querySelector('.zo-status-role');
		const restartBtn = game.querySelector('.zo-soccer-restart');
		const startBtn = game.querySelector('.zo-soccer-start');
		const buy1Btn = game.querySelector('.zo-buy-speed-1');
		const buy2Btn = game.querySelector('.zo-buy-speed-2');
		const targetEl = game.querySelector('.zo-soccer-target');
		const padButtons = game.querySelectorAll('.zo-soccer-padbtn');
		const roleButtons = game.querySelectorAll('.zo-soccer-rolebtn');

		const FIELD_W = 1040;
		const FIELD_H = 620;
		const PLAYER_RADIUS = 14;
		const USER_RADIUS = 16;
		const BALL_R = 8;
		const GOAL_TOP = 245;
		const GOAL_BOTTOM = 375;
		const MATCH_TIME = 90;

		let animationId = null;
		let lastTime = 0;
		let running = false;
		let started = false;
		let userScore = 0;
		let aiScore = 0;
		let remaining = MATCH_TIME;
		let coins = 0;
		let userBaseSpeed = 190;
		let dragTarget = null;
		let restartType = null;
		let restartTeam = null;
		let restartSpot = null;
		let roleMode = 'forward';
		let userInput = { up: false, down: false, left: false, right: false };

		function clamp(value, min, max) {
			return Math.max(min, Math.min(max, value));
		}

		function distance(a, b) {
			const dx = a.x - b.x;
			const dy = a.y - b.y;
			return Math.sqrt(dx * dx + dy * dy);
		}

		function createPlayer(role, team, position, label, homeX, homeY, options) {
			return {
				role: role,
				team: team,
				position: position,
				label: label,
				x: homeX,
				y: homeY,
				homeX: homeX,
				homeY: homeY,
				baseHomeX: homeX,
				baseHomeY: homeY,
				vx: 0,
				vy: 0,
				speed: options.speed,
				isGoalie: !!options.isGoalie,
				el: null,
				nameEl: null
			};
		}

		const bluePlayers = [
			createPlayer('user', 'blue', 'forward', 'YOU', 560, 310, { speed: userBaseSpeed }),
			createPlayer('ally', 'blue', 'goalie', 'GK', 86, 310, { speed: 142, isGoalie: true }),
			createPlayer('ally', 'blue', 'defender', 'CB', 190, 220, { speed: 145 }),
			createPlayer('ally', 'blue', 'defender', 'CB', 190, 400, { speed: 145 }),
			createPlayer('ally', 'blue', 'wing', 'LW', 330, 105, { speed: 150 }),
			createPlayer('ally', 'blue', 'wing', 'RW', 330, 515, { speed: 150 }),
			createPlayer('ally', 'blue', 'midfielder', 'CM', 390, 235, { speed: 150 }),
			createPlayer('ally', 'blue', 'midfielder', 'CM', 390, 385, { speed: 150 }),
			createPlayer('ally', 'blue', 'forward', 'LF', 530, 165, { speed: 154 }),
			createPlayer('ally', 'blue', 'forward', 'RF', 530, 455, { speed: 154 }),
			createPlayer('ally', 'blue', 'forward', 'ST', 620, 310, { speed: 156 })
		];

		const redPlayers = [
			createPlayer('enemy', 'red', 'goalie', 'GK', 954, 310, { speed: 142, isGoalie: true }),
			createPlayer('enemy', 'red', 'defender', 'CB', 850, 220, { speed: 145 }),
			createPlayer('enemy', 'red', 'defender', 'CB', 850, 400, { speed: 145 }),
			createPlayer('enemy', 'red', 'wing', 'LW', 710, 105, { speed: 150 }),
			createPlayer('enemy', 'red', 'wing', 'RW', 710, 515, { speed: 150 }),
			createPlayer('enemy', 'red', 'midfielder', 'CM', 650, 235, { speed: 150 }),
			createPlayer('enemy', 'red', 'midfielder', 'CM', 650, 385, { speed: 150 }),
			createPlayer('enemy', 'red', 'forward', 'LF', 510, 165, { speed: 154 }),
			createPlayer('enemy', 'red', 'forward', 'RF', 510, 455, { speed: 154 }),
			createPlayer('enemy', 'red', 'forward', 'ST', 420, 310, { speed: 156 }),
			createPlayer('enemy', 'red', 'defender', 'SW', 910, 310, { speed: 146 })
		];

		const state = {
			players: bluePlayers.concat(redPlayers),
			ball: {
				x: FIELD_W / 2,
				y: FIELD_H / 2,
				vx: 0,
				vy: 0,
				el: null
			}
		};

		const user = bluePlayers[0];

		const roleHomes = {
			defender: { x: 230, y: 310, label: 'YOU' },
			wing: { x: 330, y: 105, label: 'YOU' },
			midfielder: { x: 410, y: 310, label: 'YOU' },
			forward: { x: 560, y: 310, label: 'YOU' }
		};

		function setUserRole(role) {
			roleMode = role;
			user.position = role;
			user.baseHomeX = roleHomes[role].x;
			user.baseHomeY = roleHomes[role].y;
			user.homeX = user.baseHomeX;
			user.homeY = user.baseHomeY;
			roleButtons.forEach(function (btn) {
				btn.classList.toggle('is-active', btn.getAttribute('data-role') === role);
			});
			roleEl.textContent = role.charAt(0).toUpperCase() + role.slice(1);
			if (!started) {
				user.x = user.homeX;
				user.y = user.homeY;
				render();
			}
			setMessage('Role: ' + role.charAt(0).toUpperCase() + role.slice(1));
		}

		function buildEntities() {
			field.querySelectorAll('.zo-soccer-player, .zo-soccer-ball').forEach(function (node) {
				node.remove();
			});

			state.players.forEach(function (player, index) {
				const el = document.createElement('div');
				el.className = 'zo-soccer-player ' +
					(index === 0 ? 'zo-soccer-player--user ' : '') +
					(player.team === 'blue' ? 'zo-soccer-player--blue ' : 'zo-soccer-player--red ') +
					(player.isGoalie ? 'zo-soccer-player--goalie' : '');

				el.innerHTML = '' +
					'<div class="zo-soccer-player__arrow"></div>' +
					'<div class="zo-soccer-player__head"></div>' +
					'<div class="zo-soccer-player__body"></div>' +
					'<div class="zo-soccer-player__legs"></div>' +
					'<div class="zo-soccer-player__name"></div>';

				field.appendChild(el);
				player.el = el;
				player.nameEl = el.querySelector('.zo-soccer-player__name');
				if (player.nameEl) {
					player.nameEl.textContent = player.label;
				}
			});

			const ballEl = document.createElement('div');
			ballEl.className = 'zo-soccer-ball';
			field.appendChild(ballEl);
			state.ball.el = ballEl;
		}

		function resetPositions() {
			state.players.forEach(function (player) {
				player.homeX = player.baseHomeX;
				player.homeY = player.baseHomeY;
				player.x = player.homeX;
				player.y = player.homeY;
				player.vx = 0;
				player.vy = 0;
			});
			state.ball.x = FIELD_W / 2;
			state.ball.y = FIELD_H / 2;
			state.ball.vx = 0;
			state.ball.vy = 0;
			dragTarget = null;
			restartType = null;
			restartTeam = null;
			restartSpot = null;
			targetEl.classList.remove('is-active');
		}

		function updateHud() {
			scoreUserEl.textContent = String(userScore);
			scoreAiEl.textContent = String(aiScore);
			timerEl.textContent = String(Math.max(0, Math.ceil(remaining)));
			coinsEl.textContent = String(coins);
			speedEl.textContent = String(userBaseSpeed);
			roleEl.textContent = roleMode.charAt(0).toUpperCase() + roleMode.slice(1);
			buy1Btn.disabled = coins < 5 || userBaseSpeed >= 210;
			buy2Btn.disabled = coins < 10 || userBaseSpeed >= 230;
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

			if (dragTarget) {
				targetEl.classList.add('is-active');
				targetEl.style.left = (dragTarget.x * scaleX) + 'px';
				targetEl.style.top = (dragTarget.y * scaleY) + 'px';
			} else {
				targetEl.classList.remove('is-active');
			}
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

		function getNearestTeammate(passer) {
			let best = null;
			let bestDist = Infinity;

			state.players.forEach(function (player) {
				if (player !== passer && player.team === passer.team) {
					const d = distance(passer, player);
					if (d < bestDist) {
						bestDist = d;
						best = player;
					}
				}
			});

			return best;
		}

		function kickBallToward(targetX, targetY, power) {
			const dx = targetX - state.ball.x;
			const dy = targetY - state.ball.y;
			const dist = Math.sqrt(dx * dx + dy * dy) || 1;
			state.ball.vx = (dx / dist) * power;
			state.ball.vy = (dy / dist) * power;
		}

		function userPass() {
			if (restartType) {
				handleRestartKick(user.team);
				return;
			}
			const d = distance(user, state.ball);
			if (d > 38) {
				return;
			}
			const teammate = getNearestTeammate(user);
			if (!teammate) {
				return;
			}
			kickBallToward(teammate.x, teammate.y, 250);
			setMessage('Pass');
		}

		function userShoot() {
			if (restartType) {
				handleRestartKick(user.team);
				return;
			}
			const d = distance(user, state.ball);
			if (d > 38) {
				return;
			}
			kickBallToward(FIELD_W + 24, FIELD_H / 2, 350);
			setMessage('Shot');
		}

		function applyUserMovement(dt) {
			let targetX = null;
			let targetY = null;

			if (dragTarget) {
				targetX = dragTarget.x;
				targetY = dragTarget.y;
			} else {
				let mx = 0;
				let my = 0;

				if (userInput.up) my -= 1;
				if (userInput.down) my += 1;
				if (userInput.left) mx -= 1;
				if (userInput.right) mx += 1;

				if (mx !== 0 || my !== 0) {
					const len = Math.sqrt(mx * mx + my * my);
					targetX = user.x + (mx / len) * 60;
					targetY = user.y + (my / len) * 60;
				}
			}

			if (targetX !== null && targetY !== null) {
				const dx = targetX - user.x;
				const dy = targetY - user.y;
				const dist = Math.sqrt(dx * dx + dy * dy);

				if (dist > 3) {
					user.vx = (dx / dist) * userBaseSpeed;
					user.vy = (dy / dist) * userBaseSpeed;
				} else {
					user.vx *= 0.7;
					user.vy *= 0.7;
				}
			} else {
				user.vx *= 0.78;
				user.vy *= 0.78;
			}

			user.x += user.vx * dt;
			user.y += user.vy * dt;
		}

		function getRoleHomeShift(player, ball) {
			const sideFactor = player.team === 'blue'
				? clamp((ball.x - FIELD_W / 2) / 2.1, -120, 180)
				: clamp((FIELD_W / 2 - ball.x) / 2.1, -120, 180);

			if (player.position === 'defender') {
				return {
					x: player.baseHomeX + (player.team === 'blue' ? sideFactor * 0.22 : -sideFactor * 0.22),
					y: player.baseHomeY + (ball.y - player.baseHomeY) * 0.10
				};
			}

			if (player.position === 'wing') {
				const topWing = player.baseHomeY < FIELD_H / 2;
				return {
					x: player.baseHomeX + (player.team === 'blue' ? sideFactor * 0.40 : -sideFactor * 0.40),
					y: topWing ? clamp(ball.y - 95, 70, 220) : clamp(ball.y + 95, FIELD_H - 220, FIELD_H - 70)
				};
			}

			if (player.position === 'midfielder') {
				return {
					x: player.baseHomeX + (player.team === 'blue' ? sideFactor * 0.50 : -sideFactor * 0.50),
					y: player.baseHomeY + (ball.y - player.baseHomeY) * 0.28
				};
			}

			return {
				x: player.baseHomeX + (player.team === 'blue' ? sideFactor * 0.68 : -sideFactor * 0.68),
				y: player.baseHomeY + (ball.y - player.baseHomeY) * 0.22
			};
		}

		function aiMovePlayer(player, dt) {
			const ball = state.ball;
			let targetX = player.baseHomeX;
			let targetY = player.baseHomeY;

			if (restartType) {
				if (restartTeam === player.team) {
					if (restartType === 'corner') {
						if (player.isGoalie) {
							targetX = player.team === 'blue' ? 86 : 954;
							targetY = 310;
						} else if (player.position === 'wing') {
							targetX = restartSpot.x + (player.team === 'blue' ? 70 : -70);
							targetY = clamp(restartSpot.y + (player.baseHomeY < FIELD_H / 2 ? 65 : -65), 80, FIELD_H - 80);
						} else if (player.position === 'forward') {
							targetX = player.team === 'blue' ? FIELD_W - 180 : 180;
							targetY = clamp(player.baseHomeY, 150, FIELD_H - 150);
						} else {
							targetX = player.baseHomeX + (player.team === 'blue' ? 50 : -50);
							targetY = player.baseHomeY;
						}
					}
				} else {
					if (player.isGoalie) {
						targetX = player.team === 'blue' ? 86 : 954;
						targetY = 310;
					} else if (player.position === 'defender') {
						targetX = player.baseHomeX;
						targetY = player.baseHomeY;
					} else {
						targetX = player.baseHomeX + (player.team === 'blue' ? -25 : 25);
						targetY = player.baseHomeY;
					}
				}
			} else if (player.isGoalie) {
				targetX = player.team === 'blue' ? 86 : 954;
				targetY = clamp(ball.y, 235, 385);

				const goalieThreat = player.team === 'blue' ? ball.x < 170 : ball.x > 870;
				if (goalieThreat) {
					targetX = player.team === 'blue' ? 54 : 986;
					targetY = clamp(ball.y, 220, 400);
				}
			} else {
				const roleHome = getRoleHomeShift(player, ball);
				targetX = roleHome.x;
				targetY = roleHome.y;

				const ballDist = distance(player, ball);
				const attackSide = player.team === 'blue' ? ball.x > FIELD_W * 0.42 : ball.x < FIELD_W * 0.58;

				if (player.position === 'defender') {
					if ((player.team === 'blue' && ball.x < FIELD_W * 0.46) || (player.team === 'red' && ball.x > FIELD_W * 0.54)) {
						if (ballDist < 175) {
							targetX = ball.x + (player.team === 'blue' ? -14 : 14);
							targetY = ball.y;
						}
					}
				} else if (player.position === 'wing') {
					if (ballDist < 130 || attackSide) {
						targetX = ball.x + (player.team === 'blue' ? -10 : 10);
						targetY = ball.y + (player.baseHomeY < FIELD_H / 2 ? -45 : 45);
					}
				} else if (player.position === 'midfielder') {
					if (ballDist < 145 || attackSide) {
						targetX = ball.x + (player.team === 'blue' ? -8 : 8);
						targetY = ball.y;
					}
				} else if (player.position === 'forward') {
					if (ballDist < 160 || attackSide) {
						targetX = ball.x + (player.team === 'blue' ? -6 : 6);
						targetY = ball.y;
					}
				}
			}

			const dx = targetX - player.x;
			const dy = targetY - player.y;
			const dist = Math.sqrt(dx * dx + dy * dy);

			if (dist > 1) {
				player.vx = (dx / dist) * player.speed;
				player.vy = (dy / dist) * player.speed;
			} else {
				player.vx *= 0.75;
				player.vy *= 0.75;
			}

			player.x += player.vx * dt;
			player.y += player.vy * dt;
		}

		function keepPlayersInBounds() {
			state.players.forEach(function (player, index) {
				const radius = index === 0 ? USER_RADIUS : PLAYER_RADIUS;
				player.x = clamp(player.x, radius, FIELD_W - radius);
				player.y = clamp(player.y, radius, FIELD_H - radius);
			});
		}

		function separatePlayers() {
			for (let i = 0; i < state.players.length; i++) {
				for (let j = i + 1; j < state.players.length; j++) {
					const a = state.players[i];
					const b = state.players[j];
					const dx = b.x - a.x;
					const dy = b.y - a.y;
					const dist = Math.sqrt(dx * dx + dy * dy) || 0.01;
					const minDist = (i === 0 || j === 0) ? 28 : 24;

					if (dist < minDist) {
						const overlap = (minDist - dist) / 2;
						const nx = dx / dist;
						const ny = dy / dist;
						a.x -= nx * overlap;
						a.y -= ny * overlap;
						b.x += nx * overlap;
						b.y += ny * overlap;
					}
				}
			}
		}

		function maybeAiPassOrShoot(player) {
			if (restartType) {
				if (player.team === restartTeam && distance(player, state.ball) < 30) {
					handleRestartKick(player.team);
				}
				return;
			}

			const d = distance(player, state.ball);
			if (d > 28) {
				return;
			}

			const towardLeft = player.team === 'red';

			if (player.isGoalie) {
				const teammate = getNearestTeammate(player);
				if (teammate) {
					kickBallToward(teammate.x, teammate.y, 220);
				}
				return;
			}

			const closeToGoal = towardLeft ? state.ball.x < 190 : state.ball.x > FIELD_W - 190;

			if (closeToGoal || (player.position === 'forward' && Math.random() > 0.45)) {
				kickBallToward(towardLeft ? -24 : FIELD_W + 24, FIELD_H / 2 + (Math.random() * 130 - 65), 300);
				return;
			}

			const teammates = state.players.filter(function (other) {
				return other.team === player.team && other !== player;
			});

			let best = null;
			let bestScore = -99999;

			teammates.forEach(function (mate) {
				let forwardScore = towardLeft ? (player.x - mate.x) : (mate.x - player.x);
				let spacingScore = 140 - Math.abs(player.y - mate.y);
				let roleBonus = 0;

				if (mate.position === 'forward') roleBonus += 40;
				if (mate.position === 'wing') roleBonus += 20;
				if (mate.position === 'midfielder') roleBonus += 10;

				const total = forwardScore + spacingScore + roleBonus;
				if (total > bestScore) {
					bestScore = total;
					best = mate;
				}
			});

			if (best) {
				kickBallToward(best.x, best.y, 220);
			}
		}

		function pushBallFromPlayers() {
			state.players.forEach(function (player, index) {
				const dx = state.ball.x - player.x;
				const dy = state.ball.y - player.y;
				const dist = Math.sqrt(dx * dx + dy * dy);
				const radius = index === 0 ? USER_RADIUS : PLAYER_RADIUS;
				const minDist = radius + BALL_R;

				if (dist > 0 && dist < minDist) {
					const nx = dx / dist;
					const ny = dy / dist;
					const overlap = minDist - dist;

					state.ball.x += nx * overlap;
					state.ball.y += ny * overlap;

					const kickPower = index === 0 ? 170 : 150;
					state.ball.vx += nx * kickPower;
					state.ball.vy += ny * kickPower;

					if (player.team === 'blue') {
						state.ball.vx += 18;
					} else {
						state.ball.vx -= 18;
					}

					if (index !== 0) {
						maybeAiPassOrShoot(player);
					}
				}
			});
		}

		function setupCorner(team, side, vertical) {
			restartType = 'corner';
			restartTeam = team;
			const x = side === 'left' ? 20 : FIELD_W - 20;
			const y = vertical === 'top' ? 20 : FIELD_H - 20;
			restartSpot = { x: x, y: y };
			state.ball.x = x;
			state.ball.y = y;
			state.ball.vx = 0;
			state.ball.vy = 0;
			setMessage((team === 'blue' ? 'Blue' : 'Red') + ' corner');
		}

		function handleRestartKick(team) {
			if (!restartType || !restartSpot) {
				return;
			}

			if (restartType === 'corner') {
				const targetX = team === 'blue' ? FIELD_W - 170 : 170;
				const targetY = FIELD_H / 2 + (Math.random() * 180 - 90);
				kickBallToward(targetX, targetY, 290);
				setMessage((team === 'blue' ? 'Blue' : 'Red') + ' corner kick');
			}

			restartType = null;
			restartTeam = null;
			restartSpot = null;
		}

		function updateBall(dt) {
			state.ball.x += state.ball.vx * dt;
			state.ball.y += state.ball.vy * dt;

			state.ball.vx *= 0.989;
			state.ball.vy *= 0.989;

			if (state.ball.y <= BALL_R && state.ball.x > 0 && state.ball.x < FIELD_W) {
				state.ball.y = BALL_R;
				state.ball.vy *= -0.88;
			}
			if (state.ball.y >= FIELD_H - BALL_R && state.ball.x > 0 && state.ball.x < FIELD_W) {
				state.ball.y = FIELD_H - BALL_R;
				state.ball.vy *= -0.88;
			}

			const inGoalOpening = state.ball.y >= GOAL_TOP && state.ball.y <= GOAL_BOTTOM;

			if (!inGoalOpening) {
				if (state.ball.x <= BALL_R && state.ball.y > 28 && state.ball.y < FIELD_H - 28) {
					state.ball.x = BALL_R;
					state.ball.vx *= -0.88;
				}
				if (state.ball.x >= FIELD_W - BALL_R && state.ball.y > 28 && state.ball.y < FIELD_H - 28) {
					state.ball.x = FIELD_W - BALL_R;
					state.ball.vx *= -0.88;
				}
			}

			if (state.ball.x < -16 && inGoalOpening) {
				aiScore += 1;
				coins += 1;
				updateHud();
				setMessage('AI scored');
				resetPositions();
				return;
			}

			if (state.ball.x > FIELD_W + 16 && inGoalOpening) {
				userScore += 1;
				coins += 3;
				updateHud();
				setMessage('You scored');
				resetPositions();
				return;
			}

			if (!inGoalOpening) {
				if (state.ball.x < 0 && state.ball.y < 55) {
					setupCorner('red', 'left', 'top');
					return;
				}
				if (state.ball.x < 0 && state.ball.y > FIELD_H - 55) {
					setupCorner('red', 'left', 'bottom');
					return;
				}
				if (state.ball.x > FIELD_W && state.ball.y < 55) {
					setupCorner('blue', 'right', 'top');
					return;
				}
				if (state.ball.x > FIELD_W && state.ball.y > FIELD_H - 55) {
					setupCorner('blue', 'right', 'bottom');
					return;
				}
			}
		}

		function updatePlayers(dt) {
			applyUserMovement(dt);

			state.players.forEach(function (player, index) {
				if (index !== 0) {
					aiMovePlayer(player, dt);
				}
			});

			separatePlayers();
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
					coins += 5;
					updateHud();
					setMessage('You win. +5 coins');
				} else if (userScore < aiScore) {
					setMessage('AI wins');
				} else {
					coins += 2;
					updateHud();
					setMessage('Draw. +2 coins');
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

		function fieldPointFromEvent(event) {
			const rect = field.getBoundingClientRect();
			const clientX = typeof event.clientX === 'number' ? event.clientX : (event.touches && event.touches[0] ? event.touches[0].clientX : rect.left);
			const clientY = typeof event.clientY === 'number' ? event.clientY : (event.touches && event.touches[0] ? event.touches[0].clientY : rect.top);
			return {
				x: clamp(((clientX - rect.left) / rect.width) * FIELD_W, 0, FIELD_W),
				y: clamp(((clientY - rect.top) / rect.height) * FIELD_H, 0, FIELD_H)
			};
		}

		function beginDrag(event) {
			event.preventDefault();
			dragTarget = fieldPointFromEvent(event);
			field.focus();
		}

		function moveDrag(event) {
			if (!dragTarget) {
				return;
			}
			event.preventDefault();
			dragTarget = fieldPointFromEvent(event);
		}

		function endDrag(event) {
			if (event) {
				event.preventDefault();
			}
			dragTarget = null;
		}

		game.addEventListener('keydown', function (e) {
			if (['ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'w', 'W', 'a', 'A', 's', 'S', 'd', 'D'].indexOf(e.key) !== -1) {
				e.preventDefault();
				setInputFromKey(e.key, true);
			}
			if (e.code === 'Space') {
				e.preventDefault();
				userPass();
			}
			if (e.key === 'Enter') {
				e.preventDefault();
				userShoot();
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
			if (e.code === 'Space') {
				e.preventDefault();
				userPass();
			}
			if (e.key === 'Enter') {
				e.preventDefault();
				userShoot();
			}
		});

		field.addEventListener('keyup', function (e) {
			setInputFromKey(e.key, false);
		});

		field.addEventListener('mousedown', beginDrag);
		field.addEventListener('mousemove', moveDrag);
		field.addEventListener('mouseup', endDrag);
		field.addEventListener('mouseleave', endDrag);

		field.addEventListener('touchstart', beginDrag, { passive: false });
		field.addEventListener('touchmove', moveDrag, { passive: false });
		field.addEventListener('touchend', endDrag, { passive: false });
		field.addEventListener('touchcancel', endDrag, { passive: false });

		padButtons.forEach(function (btn) {
			const dir = btn.getAttribute('data-dir');

			function press(stateValue) {
				if (dir === 'up') userInput.up = stateValue;
				if (dir === 'down') userInput.down = stateValue;
				if (dir === 'left') userInput.left = stateValue;
				if (dir === 'right') userInput.right = stateValue;
				field.focus();
			}

			btn.addEventListener('touchstart', function (e) {
				e.preventDefault();
				press(true);
			}, { passive: false });

			btn.addEventListener('touchend', function (e) {
				e.preventDefault();
				press(false);
			}, { passive: false });

			btn.addEventListener('mousedown', function (e) {
				e.preventDefault();
				press(true);
			});

			btn.addEventListener('mouseup', function () {
				press(false);
			});

			btn.addEventListener('mouseleave', function () {
				press(false);
			});
		});

		roleButtons.forEach(function (btn) {
			btn.addEventListener('click', function () {
				setUserRole(btn.getAttribute('data-role'));
				field.focus();
			});
		});

		startBtn.addEventListener('click', function () {
			startMatch();
		});

		restartBtn.addEventListener('click', function () {
			resetMatch();
			field.focus();
		});

		buy1Btn.addEventListener('click', function () {
			if (coins >= 5 && userBaseSpeed < 210) {
				coins -= 5;
				userBaseSpeed += 10;
				updateHud();
				setMessage('Speed upgraded');
			}
		});

		buy2Btn.addEventListener('click', function () {
			if (coins >= 10 && userBaseSpeed < 230) {
				coins -= 10;
				userBaseSpeed += 20;
				updateHud();
				setMessage('Big speed upgrade');
			}
		});

		buildEntities();
		setUserRole('forward');
		resetMatch();
	});
});
JS;

if (!function_exists('zo_game_soccer_match_ai_render')) {
	function zo_game_soccer_match_ai_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-soccer-match-ai-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--soccer-match-ai" id="<?php echo esc_attr($instance_id); ?>" tabindex="0">
			<div class="zo-soccer-wrap">
				<div class="zo-soccer-topbar">
					<div class="zo-soccer-panel">
						<strong class="zo-score-user">0</strong>
						<span>Your Team</span>
					</div>
					<div class="zo-soccer-panel">
						<strong class="zo-score-ai">0</strong>
						<span>AI Team</span>
					</div>
					<div class="zo-soccer-panel">
						<strong class="zo-status-timer">90</strong>
						<span>Seconds Left</span>
					</div>
					<div class="zo-soccer-panel">
						<strong class="zo-status-coins">0</strong>
						<span>Coins</span>
					</div>
					<div class="zo-soccer-panel">
						<strong class="zo-status-speed">190</strong>
						<span>Your Speed</span>
					</div>
					<div class="zo-soccer-panel">
						<strong class="zo-status-role">Forward</strong>
						<span>Your Role</span>
					</div>
					<div class="zo-soccer-panel">
						<strong class="zo-status-message">Press Start Match</strong>
						<span>Status</span>
					</div>
				</div>

				<div class="zo-soccer-rolebar">
					<button type="button" class="zo-soccer-rolebtn" data-role="defender">Defence</button>
					<button type="button" class="zo-soccer-rolebtn" data-role="wing">Wing</button>
					<button type="button" class="zo-soccer-rolebtn" data-role="midfielder">Midfield</button>
					<button type="button" class="zo-soccer-rolebtn is-active" data-role="forward">Forward</button>
				</div>

				<div class="zo-soccer-field" tabindex="0" aria-label="Soccer field game area">
					<div class="zo-soccer-line-mid"></div>
					<div class="zo-soccer-circle"></div>
					<div class="zo-soccer-dot"></div>
					<div class="zo-soccer-box-left"></div>
					<div class="zo-soccer-box-right"></div>
					<div class="zo-soccer-smallbox-left"></div>
					<div class="zo-soccer-smallbox-right"></div>
					<div class="zo-soccer-goal-left"></div>
					<div class="zo-soccer-goal-right"></div>
					<div class="zo-soccer-corner-arc zo-soccer-corner-arc--tl"></div>
					<div class="zo-soccer-corner-arc zo-soccer-corner-arc--tr"></div>
					<div class="zo-soccer-corner-arc zo-soccer-corner-arc--bl"></div>
					<div class="zo-soccer-corner-arc zo-soccer-corner-arc--br"></div>
					<div class="zo-soccer-target"></div>
				</div>

				<div class="zo-soccer-controls">
					<div class="zo-soccer-buttons">
						<button type="button" class="zo-soccer-btn zo-soccer-start">Start Match</button>
						<button type="button" class="zo-soccer-btn zo-soccer-restart">Restart</button>
						<button type="button" class="zo-soccer-btn zo-buy-speed-1">Buy +10 Speed (5 coins)</button>
						<button type="button" class="zo-soccer-btn zo-buy-speed-2">Buy +20 Speed (10 coins)</button>
					</div>

					<div class="zo-soccer-help">
						Choose your role: Defence, Wing, Midfield, or Forward. Use arrow keys or WASD to move. Press Space to pass. Press Enter to shoot. You can also drag on the field with mouse or touch. Players stay spread out in real positions, and corner kicks happen from the corner.
					</div>

					<div class="zo-soccer-shop">
						<div class="zo-soccer-shop-title">Upgrades</div>
						<div>Score goals and win matches to earn coins. Use coins to make your player faster.</div>
					</div>

					<div class="zo-soccer-mobilepad">
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
	'description'     => 'A soccer match game with proper player spacing, role selection, and corner kicks.',
	'render_callback' => 'zo_game_soccer_match_ai_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);