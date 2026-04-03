<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root--soccer-match-ai {
	max-width: 1200px;
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
	min-width: 130px;
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

.zo-soccer-field {
	position: relative;
	width: 100%;
	max-width: 1120px;
	height: 630px;
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
	outline: none;
	user-select: none;
	touch-action: none;
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
	width: 150px;
	height: 150px;
	margin-left: -75px;
	margin-top: -75px;
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
	width: 145px;
	height: 250px;
	border: 4px solid rgba(255,255,255,0.95);
}

.zo-soccer-smallbox-left,
.zo-soccer-smallbox-right {
	top: 250px;
	width: 65px;
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
	top: 250px;
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

.zo-soccer-corner-arc--tl { left: -17px; top: -17px; }
.zo-soccer-corner-arc--tr { right: -17px; top: -17px; }
.zo-soccer-corner-arc--bl { left: -17px; bottom: -17px; }
.zo-soccer-corner-arc--br { right: -17px; bottom: -17px; }

.zo-soccer-player,
.zo-soccer-ball,
.zo-soccer-target,
.zo-soccer-pass-line {
	position: absolute;
	transform: translate(-50%, -50%);
	pointer-events: none;
}

.zo-soccer-player {
	width: 24px;
	height: 38px;
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
	height: 14px;
	margin-left: -9px;
	border-radius: 7px 7px 6px 6px;
	border: 1px solid rgba(0,0,0,0.16);
}

.zo-soccer-player__legs {
	position: absolute;
	left: 50%;
	top: 26px;
	width: 18px;
	height: 10px;
	margin-left: -9px;
}

.zo-soccer-player__legs::before,
.zo-soccer-player__legs::after {
	content: '';
	position: absolute;
	top: 0;
	width: 4px;
	height: 10px;
	background: #202020;
	border-radius: 3px;
}

.zo-soccer-player__legs::before { left: 3px; }
.zo-soccer-player__legs::after { right: 3px; }

.zo-soccer-player__label {
	position: absolute;
	left: 50%;
	top: 38px;
	transform: translateX(-50%);
	font-size: 9px;
	font-weight: 700;
	line-height: 1;
	padding: 2px 5px;
	border-radius: 8px;
	white-space: nowrap;
	background: rgba(255,255,255,0.88);
	color: #1d2a1d;
}

.zo-soccer-player__marker {
	position: absolute;
	left: 50%;
	top: -12px;
	transform: translateX(-50%);
	width: 10px;
	height: 10px;
	border-radius: 50%;
	background: transparent;
}

.zo-soccer-player--decision .zo-soccer-player__marker {
	background: #ffd54f;
	box-shadow: 0 0 0 3px rgba(255, 213, 79, 0.28);
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
	width: 24px;
	height: 24px;
	border-radius: 50%;
	border: 3px dashed rgba(255,255,255,0.92);
	display: none;
}

.zo-soccer-target.is-active {
	display: block;
}

.zo-soccer-pass-line {
	height: 4px;
	background: rgba(255,255,255,0.92);
	transform-origin: left center;
	display: none;
	border-radius: 4px;
}

.zo-soccer-pass-line.is-active {
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
.zo-soccer-decision {
	background: #fff;
	border: 2px solid #dfe7d8;
	border-radius: 12px;
	padding: 10px 14px;
	font-size: 14px;
	line-height: 1.45;
	color: #334233;
	max-width: 1120px;
	width: 100%;
}

.zo-soccer-decision {
	display: none;
}

.zo-soccer-decision.is-active {
	display: block;
}

@media (max-width: 900px) {
	.zo-soccer-field {
		height: 560px;
	}
}

@media (max-width: 700px) {
	.zo-soccer-field {
		height: 450px;
	}

	.zo-soccer-player__label {
		font-size: 8px;
	}
}

@media (max-width: 520px) {
	.zo-soccer-field {
		height: 360px;
	}

	.zo-soccer-panel {
		min-width: 104px;
		padding: 8px 10px;
	}

	.zo-soccer-help,
	.zo-soccer-decision {
		font-size: 13px;
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
		const modeEl = game.querySelector('.zo-status-mode');
		const restartBtn = game.querySelector('.zo-soccer-restart');
		const startBtn = game.querySelector('.zo-soccer-start');
		const targetEl = game.querySelector('.zo-soccer-target');
		const passLineEl = game.querySelector('.zo-soccer-pass-line');
		const decisionBox = game.querySelector('.zo-soccer-decision');
		const decisionText = game.querySelector('.zo-soccer-decision-text');

		const FIELD_W = 1120;
		const FIELD_H = 630;
		const PLAYER_RADIUS = 14;
		const BALL_R = 8;
		const GOAL_TOP = 250;
		const GOAL_BOTTOM = 380;
		const MATCH_TIME = 300;
		const INTERCEPT_RADIUS = 110;
		const CHASE_RADIUS = 70;

		let animationId = null;
		let lastTime = 0;
		let running = false;
		let started = false;
		let userScore = 0;
		let aiScore = 0;
		let remaining = MATCH_TIME;
		let restartType = null;
		let restartTeam = null;
		let restartSpot = null;
		let decisionMode = false;
		let decisionPlayer = null;
		let decisionTarget = null;

		function clamp(value, min, max) {
			return Math.max(min, Math.min(max, value));
		}

		function distance(a, b) {
			const dx = a.x - b.x;
			const dy = a.y - b.y;
			return Math.sqrt(dx * dx + dy * dy);
		}

		function createPlayer(team, position, label, homeX, homeY, options) {
			return {
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
				el: null
			};
		}

		const bluePlayers = [
			createPlayer('blue', 'goalie', 'GK', 86, 315, { speed: 82, isGoalie: true }),
			createPlayer('blue', 'defender', 'CB', 195, 225, { speed: 84 }),
			createPlayer('blue', 'defender', 'CB', 195, 405, { speed: 84 }),
			createPlayer('blue', 'wing', 'LW', 340, 110, { speed: 88 }),
			createPlayer('blue', 'wing', 'RW', 340, 520, { speed: 88 }),
			createPlayer('blue', 'midfielder', 'CM', 420, 245, { speed: 88 }),
			createPlayer('blue', 'midfielder', 'CM', 420, 385, { speed: 88 }),
			createPlayer('blue', 'forward', 'LF', 565, 175, { speed: 90 }),
			createPlayer('blue', 'forward', 'RF', 565, 455, { speed: 90 }),
			createPlayer('blue', 'forward', 'ST', 650, 315, { speed: 92 }),
			createPlayer('blue', 'defender', 'SW', 120, 315, { speed: 82 })
		];

		const redPlayers = [
			createPlayer('red', 'goalie', 'GK', 1034, 315, { speed: 82, isGoalie: true }),
			createPlayer('red', 'defender', 'CB', 925, 225, { speed: 84 }),
			createPlayer('red', 'defender', 'CB', 925, 405, { speed: 84 }),
			createPlayer('red', 'wing', 'LW', 780, 110, { speed: 88 }),
			createPlayer('red', 'wing', 'RW', 780, 520, { speed: 88 }),
			createPlayer('red', 'midfielder', 'CM', 700, 245, { speed: 88 }),
			createPlayer('red', 'midfielder', 'CM', 700, 385, { speed: 88 }),
			createPlayer('red', 'forward', 'LF', 555, 175, { speed: 90 }),
			createPlayer('red', 'forward', 'RF', 555, 455, { speed: 90 }),
			createPlayer('red', 'forward', 'ST', 470, 315, { speed: 92 }),
			createPlayer('red', 'defender', 'SW', 1000, 315, { speed: 82 })
		];

		const state = {
			players: bluePlayers.concat(redPlayers),
			ball: {
				x: FIELD_W / 2,
				y: FIELD_H / 2,
				vx: 0,
				vy: 0,
				el: null,
				kick_lock_timer: 0,
				kick_ignore_player: null
			}
		};

		function updateModeLabel() {
			if (decisionMode) {
				modeEl.textContent = 'Decision';
			} else if (running) {
				modeEl.textContent = 'Live';
			} else {
				modeEl.textContent = 'Stopped';
			}
		}

		function setMessage(text) {
			messageEl.textContent = text;
		}

		function updateHud() {
			scoreUserEl.textContent = String(userScore);
			scoreAiEl.textContent = String(aiScore);
			const mins = Math.floor(remaining / 60);
			const secs = Math.max(0, Math.ceil(remaining % 60));
			timerEl.textContent = mins + ':' + String(secs).padStart(2, '0');
			updateModeLabel();
		}

		function buildEntities() {
			field.querySelectorAll('.zo-soccer-player, .zo-soccer-ball').forEach(function (node) {
				node.remove();
			});

			state.players.forEach(function (player) {
				const el = document.createElement('div');
				el.className = 'zo-soccer-player ' +
					(player.team === 'blue' ? 'zo-soccer-player--blue ' : 'zo-soccer-player--red ') +
					(player.isGoalie ? 'zo-soccer-player--goalie' : '');

				el.innerHTML =
					'<div class="zo-soccer-player__marker"></div>' +
					'<div class="zo-soccer-player__head"></div>' +
					'<div class="zo-soccer-player__body"></div>' +
					'<div class="zo-soccer-player__legs"></div>' +
					'<div class="zo-soccer-player__label">' + player.label + '</div>';

				field.appendChild(el);
				player.el = el;
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
				player.el.classList.remove('zo-soccer-player--decision');
			});
			state.ball.x = FIELD_W / 2;
			state.ball.y = FIELD_H / 2;
			state.ball.vx = 0;
			state.ball.vy = 0;
			state.ball.kick_lock_timer = 0;
			state.ball.kick_ignore_player = null;
			restartType = null;
			restartTeam = null;
			restartSpot = null;
			decisionMode = false;
			decisionPlayer = null;
			decisionTarget = null;
			targetEl.classList.remove('is-active');
			passLineEl.classList.remove('is-active');
			decisionBox.classList.remove('is-active');
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

			if (decisionMode && decisionTarget && decisionPlayer) {
				const startX = decisionPlayer.x * scaleX;
				const startY = decisionPlayer.y * scaleY;
				const endX = decisionTarget.x * scaleX;
				const endY = decisionTarget.y * scaleY;
				const dx = endX - startX;
				const dy = endY - startY;
				const len = Math.sqrt(dx * dx + dy * dy);
				const angle = Math.atan2(dy, dx) * 180 / Math.PI;

				targetEl.classList.add('is-active');
				targetEl.style.left = endX + 'px';
				targetEl.style.top = endY + 'px';

				passLineEl.classList.add('is-active');
				passLineEl.style.left = startX + 'px';
				passLineEl.style.top = startY + 'px';
				passLineEl.style.width = len + 'px';
				passLineEl.style.transform = 'translate(0, -50%) rotate(' + angle + 'deg)';
			} else {
				targetEl.classList.remove('is-active');
				passLineEl.classList.remove('is-active');
			}
		}

		function resetMatch() {
			userScore = 0;
			aiScore = 0;
			remaining = MATCH_TIME;
			started = false;
			running = false;
			lastTime = 0;
			resetPositions();
			updateHud();
			setMessage('Press Start Match');
			if (animationId) {
				cancelAnimationFrame(animationId);
				animationId = null;
			}
			render();
		}

		function kickBallToward(targetX, targetY, power) {
			const dx = targetX - state.ball.x;
			const dy = targetY - state.ball.y;
			const dist = Math.sqrt(dx * dx + dy * dy) || 1;
			state.ball.vx = (dx / dist) * power;
			state.ball.vy = (dy / dist) * power;
		}

		function findBestPassTarget(player) {
			const teammates = state.players.filter(function (other) {
				return other.team === player.team && other !== player;
			});

			let best = null;
			let bestScore = -999999;

			teammates.forEach(function (mate) {
				const forwardScore = player.team === 'blue' ? (mate.x - player.x) : (player.x - mate.x);
				const spacingScore = 160 - Math.abs(mate.y - player.y);
				const roleBonus =
					(mate.position === 'forward' ? 38 : 0) +
					(mate.position === 'wing' ? 20 : 0) +
					(mate.position === 'midfielder' ? 12 : 0);

				const total = forwardScore + spacingScore + roleBonus;

				if (total > bestScore) {
					bestScore = total;
					best = mate;
				}
			});

			return best;
		}

		function startDecisionMode(player) {
			decisionMode = true;
			running = false;
			decisionPlayer = player;
			decisionTarget = {
				x: player.team === 'blue' ? player.x + 140 : player.x - 140,
				y: player.y
			};

			const best = findBestPassTarget(player);
			if (best) {
				decisionTarget = { x: best.x, y: best.y };
			}

			state.players.forEach(function (p) {
				p.el.classList.toggle('zo-soccer-player--decision', p === player);
			});

			decisionBox.classList.add('is-active');
			decisionText.textContent = 'Your teammate has the ball. Move the target and click or tap to kick in exactly that direction.';
			setMessage('Choose ball direction');
			updateHud();
			render();
		}

		function endDecisionModeAndKick(targetX, targetY) {
			if (!decisionMode || !decisionPlayer) {
				return;
			}

			const dx = targetX - decisionPlayer.x;
			const dy = targetY - decisionPlayer.y;
			const len = Math.sqrt(dx * dx + dy * dy) || 1;
			const nx = dx / len;
			const ny = dy / len;
			const distancePower = clamp(len * 1.4, 180, 340);

			state.ball.x = decisionPlayer.x + nx * 24;
			state.ball.y = decisionPlayer.y + ny * 24;
			state.ball.vx = nx * distancePower;
			state.ball.vy = ny * distancePower;
			state.ball.kick_lock_timer = 0.35;
			state.ball.kick_ignore_player = decisionPlayer;

			decisionMode = false;
			running = true;
			decisionPlayer = null;
			decisionTarget = null;
			state.players.forEach(function (p) {
				p.el.classList.remove('zo-soccer-player--decision');
			});
			decisionBox.classList.remove('is-active');
			setMessage('Ball kicked');
			updateHud();
			animationId = requestAnimationFrame(loop);
		}

		function getRoleHomeShift(player, ball) {
			const sideFactor = player.team === 'blue'
				? clamp((ball.x - FIELD_W / 2) / 2.8, -90, 140)
				: clamp((FIELD_W / 2 - ball.x) / 2.8, -90, 140);

			if (player.position === 'defender') {
				return {
					x: player.baseHomeX + (player.team === 'blue' ? sideFactor * 0.18 : -sideFactor * 0.18),
					y: player.baseHomeY + (ball.y - player.baseHomeY) * 0.08
				};
			}

			if (player.position === 'wing') {
				const topWing = player.baseHomeY < FIELD_H / 2;
				return {
					x: player.baseHomeX + (player.team === 'blue' ? sideFactor * 0.34 : -sideFactor * 0.34),
					y: topWing ? clamp(ball.y - 90, 70, 230) : clamp(ball.y + 90, FIELD_H - 230, FIELD_H - 70)
				};
			}

			if (player.position === 'midfielder') {
				return {
					x: player.baseHomeX + (player.team === 'blue' ? sideFactor * 0.42 : -sideFactor * 0.42),
					y: player.baseHomeY + (ball.y - player.baseHomeY) * 0.22
				};
			}

			return {
				x: player.baseHomeX + (player.team === 'blue' ? sideFactor * 0.58 : -sideFactor * 0.58),
				y: player.baseHomeY + (ball.y - player.baseHomeY) * 0.18
			};
		}

		function getNearestChaser(team) {
			let best = null;
			let bestDist = Infinity;

			state.players.forEach(function (player) {
				if (player.team !== team || player.isGoalie) {
					return;
				}
				const d = distance(player, state.ball);
				if (d < bestDist) {
					bestDist = d;
					best = player;
				}
			});

			return best;
		}

		function getSupportChaser(team, primary) {
			let best = null;
			let bestDist = Infinity;

			state.players.forEach(function (player) {
				if (player.team !== team || player.isGoalie || player === primary) {
					return;
				}
				const d = distance(player, state.ball);
				if (d < bestDist) {
					bestDist = d;
					best = player;
				}
			});

			if (bestDist <= INTERCEPT_RADIUS) {
				return best;
			}
			return null;
		}

		function aiMovePlayer(player, dt) {
			const ball = state.ball;
			let targetX = player.baseHomeX;
			let targetY = player.baseHomeY;

			const primaryBlue = getNearestChaser('blue');
			const primaryRed = getNearestChaser('red');
			const supportBlue = getSupportChaser('blue', primaryBlue);
			const supportRed = getSupportChaser('red', primaryRed);

			if (restartType) {
				if (restartTeam === player.team) {
					if (restartType === 'corner') {
						if (player.isGoalie) {
							targetX = player.team === 'blue' ? 86 : 1034;
							targetY = 315;
						} else if (player.position === 'wing') {
							targetX = restartSpot.x + (player.team === 'blue' ? 70 : -70);
							targetY = clamp(restartSpot.y + (player.baseHomeY < FIELD_H / 2 ? 70 : -70), 85, FIELD_H - 85);
						} else if (player.position === 'forward') {
							targetX = player.team === 'blue' ? FIELD_W - 200 : 200;
							targetY = clamp(player.baseHomeY, 150, FIELD_H - 150);
						} else {
							targetX = player.baseHomeX + (player.team === 'blue' ? 45 : -45);
							targetY = player.baseHomeY;
						}
					}
				} else {
					targetX = player.baseHomeX;
					targetY = player.baseHomeY;
				}
			} else if (player.isGoalie) {
				targetX = player.team === 'blue' ? 86 : 1034;
				targetY = clamp(ball.y, 240, 390);

				const goalieThreat = player.team === 'blue' ? ball.x < 180 : ball.x > 940;
				if (goalieThreat) {
					targetX = player.team === 'blue' ? 58 : 1062;
					targetY = clamp(ball.y, 220, 410);
				}
			} else {
				const roleHome = getRoleHomeShift(player, ball);
				targetX = roleHome.x;
				targetY = roleHome.y;

				const primary = player.team === 'blue' ? primaryBlue : primaryRed;
				const support = player.team === 'blue' ? supportBlue : supportRed;
				const ballDist = distance(player, ball);

				if (player === primary && ballDist <= INTERCEPT_RADIUS) {
					targetX = ball.x + (player.team === 'blue' ? -4 : 4);
					targetY = ball.y;
				} else if (player === support && ballDist <= INTERCEPT_RADIUS) {
					targetX = ball.x + (player.team === 'blue' ? -28 : 28);
					targetY = ball.y + (player.baseHomeY < FIELD_H / 2 ? -26 : 26);
				} else if (ballDist <= CHASE_RADIUS && player.position !== 'defender') {
					targetX = ball.x + (player.team === 'blue' ? -18 : 18);
					targetY = ball.y;
				}
			}

			const dx = targetX - player.x;
			const dy = targetY - player.y;
			const dist = Math.sqrt(dx * dx + dy * dy);

			if (dist > 1) {
				player.vx = (dx / dist) * player.speed;
				player.vy = (dy / dist) * player.speed;
			} else {
				player.vx *= 0.7;
				player.vy *= 0.7;
			}

			player.x += player.vx * dt;
			player.y += player.vy * dt;
		}

		function keepPlayersInBounds() {
			state.players.forEach(function (player) {
				player.x = clamp(player.x, PLAYER_RADIUS, FIELD_W - PLAYER_RADIUS);
				player.y = clamp(player.y, PLAYER_RADIUS, FIELD_H - PLAYER_RADIUS);
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
					const minDist = 24;

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

		function getBallOwner() {
			if (state.ball.kick_lock_timer > 0) {
				return null;
			}

			let owner = null;
			let bestDist = Infinity;

			state.players.forEach(function (player) {
				const d = distance(player, state.ball);
				if (d < bestDist) {
					bestDist = d;
					owner = player;
				}
			});

			if (bestDist <= 22) {
				return owner;
			}

			return null;
		}

		function maybeAiPassOrShoot(player) {
			if (restartType) {
				if (player.team === restartTeam && distance(player, state.ball) < 24) {
					handleRestartKick(player.team);
				}
				return;
			}

			if (player.team === 'blue') {
				startDecisionMode(player);
				return;
			}

			const towardLeft = player.team === 'red';
			const closeToGoal = towardLeft ? state.ball.x < 210 : state.ball.x > FIELD_W - 210;

			if (closeToGoal || (player.position === 'forward' && Math.random() > 0.55)) {
				kickBallToward(towardLeft ? -24 : FIELD_W + 24, FIELD_H / 2 + (Math.random() * 130 - 65), 250);
				state.ball.kick_lock_timer = 0.22;
				state.ball.kick_ignore_player = player;
				return;
			}

			const best = findBestPassTarget(player);

			if (best) {
				kickBallToward(best.x, best.y, 220);
			} else {
				kickBallToward(towardLeft ? 120 : FIELD_W - 120, FIELD_H / 2, 230);
			}

			state.ball.kick_lock_timer = 0.22;
			state.ball.kick_ignore_player = player;
		}

		function pushBallFromPlayers() {
			state.players.forEach(function (player) {
				if (state.ball.kick_lock_timer > 0 && player === state.ball.kick_ignore_player) {
					return;
				}

				const dx = state.ball.x - player.x;
				const dy = state.ball.y - player.y;
				const dist = Math.sqrt(dx * dx + dy * dy);
				const minDist = PLAYER_RADIUS + BALL_R;

				if (dist > 0 && dist < minDist) {
					const nx = dx / dist;
					const ny = dy / dist;
					const overlap = minDist - dist;

					state.ball.x += nx * overlap;
					state.ball.y += ny * overlap;

					const touchPower = 36;
					state.ball.vx += nx * touchPower;
					state.ball.vy += ny * touchPower;

					if (player.team === 'blue') {
						state.ball.vx += 3;
					} else {
						state.ball.vx -= 3;
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
			state.ball.kick_lock_timer = 0;
			state.ball.kick_ignore_player = null;
			setMessage((team === 'blue' ? 'Blue' : 'Red') + ' corner');
		}

		function handleRestartKick(team) {
			if (!restartType || !restartSpot) {
				return;
			}

			if (restartType === 'corner') {
				const targetX = team === 'blue' ? FIELD_W - 220 : 220;
				const targetY = FIELD_H / 2 + (Math.random() * 140 - 70);
				kickBallToward(targetX, targetY, 230);
				state.ball.kick_lock_timer = 0.22;
				state.ball.kick_ignore_player = null;
				setMessage((team === 'blue' ? 'Blue' : 'Red') + ' corner kick');
			}

			restartType = null;
			restartTeam = null;
			restartSpot = null;
		}

		function updateBall(dt) {
			if (state.ball.kick_lock_timer > 0) {
				state.ball.kick_lock_timer -= dt;
				if (state.ball.kick_lock_timer <= 0) {
					state.ball.kick_lock_timer = 0;
					state.ball.kick_ignore_player = null;
				}
			}

			state.ball.x += state.ball.vx * dt;
			state.ball.y += state.ball.vy * dt;

			state.ball.vx *= 0.988;
			state.ball.vy *= 0.988;

			if (state.ball.y <= BALL_R && state.ball.x > 0 && state.ball.x < FIELD_W) {
				state.ball.y = BALL_R;
				state.ball.vy *= -0.84;
			}
			if (state.ball.y >= FIELD_H - BALL_R && state.ball.x > 0 && state.ball.x < FIELD_W) {
				state.ball.y = FIELD_H - BALL_R;
				state.ball.vy *= -0.84;
			}

			const inGoalOpening = state.ball.y >= GOAL_TOP && state.ball.y <= GOAL_BOTTOM;

			if (!inGoalOpening) {
				if (state.ball.x <= BALL_R && state.ball.y > 28 && state.ball.y < FIELD_H - 28) {
					state.ball.x = BALL_R;
					state.ball.vx *= -0.84;
				}
				if (state.ball.x >= FIELD_W - BALL_R && state.ball.y > 28 && state.ball.y < FIELD_H - 28) {
					state.ball.x = FIELD_W - BALL_R;
					state.ball.vx *= -0.84;
				}
			}

			if (state.ball.x < -16 && inGoalOpening) {
				aiScore += 1;
				updateHud();
				setMessage('Red scored');
				resetPositions();
				return;
			}

			if (state.ball.x > FIELD_W + 16 && inGoalOpening) {
				userScore += 1;
				updateHud();
				setMessage('Blue scored');
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
			state.players.forEach(function (player) {
				aiMovePlayer(player, dt);
			});

			separatePlayers();
			keepPlayersInBounds();
		}

		function loop(ts) {
			if (!running || decisionMode) {
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
					setMessage('Blue wins');
				} else if (userScore < aiScore) {
					setMessage('Red wins');
				} else {
					setMessage('Draw match');
				}
				return;
			}

			updatePlayers(dt);
			pushBallFromPlayers();
			updateBall(dt);

			const owner = getBallOwner();
			if (owner && !decisionMode) {
				maybeAiPassOrShoot(owner);
			}

			updateHud();
			render();

			if (running && !decisionMode) {
				animationId = requestAnimationFrame(loop);
			}
		}

		function startMatch() {
			if (running || decisionMode) {
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
			updateHud();
			field.focus();
			animationId = requestAnimationFrame(loop);
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

		field.addEventListener('mousemove', function (e) {
			if (!decisionMode) {
				return;
			}
			decisionTarget = fieldPointFromEvent(e);
			render();
		});

		field.addEventListener('touchmove', function (e) {
			if (!decisionMode) {
				return;
			}
			e.preventDefault();
			decisionTarget = fieldPointFromEvent(e);
			render();
		}, { passive: false });

		field.addEventListener('mousedown', function (e) {
			if (!decisionMode) {
				return;
			}
			e.preventDefault();
			const point = fieldPointFromEvent(e);
			endDecisionModeAndKick(point.x, point.y);
		});

		field.addEventListener('touchstart', function (e) {
			if (!decisionMode) {
				return;
			}
			e.preventDefault();
			const point = fieldPointFromEvent(e);
			endDecisionModeAndKick(point.x, point.y);
		}, { passive: false });

		startBtn.addEventListener('click', function () {
			startMatch();
		});

		restartBtn.addEventListener('click', function () {
			resetMatch();
			field.focus();
		});

		buildEntities();
		resetMatch();
	});
});
JS;

if (!function_exists('zo_game_soccer_match_ai_render')) {
	function zo_game_soccer_match_ai_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-soccer-match-ai-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--soccer-match-ai" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-soccer-wrap">
				<div class="zo-soccer-topbar">
					<div class="zo-soccer-panel">
						<strong class="zo-score-user">0</strong>
						<span>Blue Team</span>
					</div>
					<div class="zo-soccer-panel">
						<strong class="zo-score-ai">0</strong>
						<span>Red Team</span>
					</div>
					<div class="zo-soccer-panel">
						<strong class="zo-status-timer">5:00</strong>
						<span>Match Time</span>
					</div>
					<div class="zo-soccer-panel">
						<strong class="zo-status-mode">Stopped</strong>
						<span>Game Mode</span>
					</div>
					<div class="zo-soccer-panel">
						<strong class="zo-status-message">Press Start Match</strong>
						<span>Status</span>
					</div>
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
					<div class="zo-soccer-pass-line"></div>
				</div>

				<div class="zo-soccer-controls">
					<div class="zo-soccer-buttons">
						<button type="button" class="zo-soccer-btn zo-soccer-start">Start Match</button>
						<button type="button" class="zo-soccer-btn zo-soccer-restart">Restart</button>
					</div>

					<div class="zo-soccer-help">
						All players are AI. Only one or two nearby players go to the ball. When blue gets the ball, the game pauses and your click decides the exact kick direction. The kicker is temporarily ignored right after the kick so the ball keeps the direction you chose.
					</div>

					<div class="zo-soccer-decision">
						<div class="zo-soccer-decision-text">Your teammate has the ball. Move the target and click or tap to kick in exactly that direction.</div>
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
	'description'     => 'A slow 5 minute soccer match where all players are AI and you decide the exact direction of blue team kicks.',
	'render_callback' => 'zo_game_soccer_match_ai_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);