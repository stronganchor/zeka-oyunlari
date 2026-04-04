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
	min-width: 122px;
}

.zo-soccer-panel strong {
	display: block;
	font-size: 20px;
	color: #1d2a1d;
}

.zo-soccer-panel span {
	display: block;
	font-size: 13px;
	color: #445244;
	margin-top: 4px;
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
.zo-soccer-pass-line,
.zo-soccer-preview-dot {
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

.zo-soccer-preview-dot {
	width: 7px;
	height: 7px;
	border-radius: 50%;
	background: rgba(255,255,255,0.72);
	display: none;
}

.zo-soccer-preview-dot.is-active {
	display: block;
}

.zo-soccer-controls {
	margin-top: 14px;
	display: flex;
	flex-direction: column;
	gap: 10px;
	align-items: center;
}

.zo-soccer-buttons,
.zo-soccer-actionbar,
.zo-soccer-cornerbar {
	display: flex;
	gap: 8px;
	flex-wrap: wrap;
	justify-content: center;
}

.zo-soccer-btn.is-active {
	background: #1565c0;
}

.zo-soccer-help,
.zo-soccer-decision,
.zo-soccer-upgrades {
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

.zo-soccer-upgrades-title {
	font-size: 16px;
	font-weight: 700;
	color: #1d2a1d;
	margin-bottom: 8px;
}

.zo-soccer-upgrades-grid {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	justify-content: center;
}

.zo-soccer-upgrade-card {
	background: #f8faf7;
	border: 2px solid #dfe7d8;
	border-radius: 12px;
	padding: 10px;
	min-width: 160px;
	max-width: 210px;
}

.zo-soccer-upgrade-card strong {
	display: block;
	margin-bottom: 4px;
	color: #1d2a1d;
	font-size: 15px;
}

.zo-soccer-upgrade-card span {
	display: block;
	font-size: 13px;
	margin-bottom: 8px;
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
	.zo-soccer-decision,
	.zo-soccer-upgrades {
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
		const coinsEl = game.querySelector('.zo-status-coins');
		const speedLevelEl = game.querySelector('.zo-status-speed-level');
		const smartLevelEl = game.querySelector('.zo-status-smart-level');
		const shootingLevelEl = game.querySelector('.zo-status-shooting-level');
		const passingLevelEl = game.querySelector('.zo-status-passing-level');
		const defenseLevelEl = game.querySelector('.zo-status-defense-level');
		const restartBtn = game.querySelector('.zo-soccer-restart');
		const startBtn = game.querySelector('.zo-soccer-start');
		const buySpeedBtn = game.querySelector('.zo-buy-speed');
		const buySmartBtn = game.querySelector('.zo-buy-smart');
		const buyShootingBtn = game.querySelector('.zo-buy-shooting');
		const buyPassingBtn = game.querySelector('.zo-buy-passing');
		const buyDefenseBtn = game.querySelector('.zo-buy-defense');
		const targetEl = game.querySelector('.zo-soccer-target');
		const passLineEl = game.querySelector('.zo-soccer-pass-line');
		const decisionBox = game.querySelector('.zo-soccer-decision');
		const decisionText = game.querySelector('.zo-soccer-decision-text');
		const actionButtons = Array.from(game.querySelectorAll('.zo-action-btn'));
		const cornerButtons = Array.from(game.querySelectorAll('.zo-corner-btn'));

		const FIELD_W = 1120;
		const FIELD_H = 630;
		const PLAYER_RADIUS = 14;
		const BALL_R = 8;
		const GOAL_TOP = 250;
		const GOAL_BOTTOM = 380;
		const GOAL_LEFT_X = 0;
		const GOAL_RIGHT_X = FIELD_W;
		const MATCH_TIME = 300;
		const BASE_INTERCEPT_RADIUS = 110;
		const BASE_CHASE_RADIUS = 70;
		const BASE_DECISION_PASS_POWER = 180;
		const BASE_DECISION_SHOT_POWER = 340;
		const BASE_RED_PASS_POWER = 220;
		const BASE_RED_SHOT_POWER = 250;
		const BASE_KICK_LOCK = 0.35;

		let animationId = null;
		let lastTime = 0;
		let running = false;
		let started = false;
		let userScore = 0;
		let aiScore = 0;
		let remaining = MATCH_TIME;
		let coins = 0;
		let speedLevel = 0;
		let smartLevel = 0;
		let shootingLevel = 0;
		let passingLevel = 0;
		let defenseLevel = 0;
		let restartType = null;
		let restartTeam = null;
		let restartSpot = null;
		let decisionMode = false;
		let decisionPlayer = null;
		let decisionTarget = null;
		let decisionContext = 'normal';
		let actionMode = 'pass';
		let cornerMode = 'penalty';
		let previewDots = [];

		function getBlueSpeedMultiplier() {
			return 1 + (speedLevel * 0.12);
		}

		function getBlueInterceptRadius() {
			return BASE_INTERCEPT_RADIUS * (1 + smartLevel * 0.10 + defenseLevel * 0.08);
		}

		function getBlueChaseRadius() {
			return BASE_CHASE_RADIUS * (1 + smartLevel * 0.10 + defenseLevel * 0.06);
		}

		function getDecisionPassPower(len) {
			const raw = clamp(len * 1.4, BASE_DECISION_PASS_POWER, BASE_DECISION_SHOT_POWER);
			return raw * (1 + passingLevel * 0.10);
		}

		function getDecisionShotPower() {
			return BASE_DECISION_SHOT_POWER * (1 + shootingLevel * 0.12);
		}

		function getDecisionCrossPower() {
			return 220 + (passingLevel * 14);
		}

		function getDecisionCornerPower() {
			return 240 + (passingLevel * 18) + (shootingLevel * 12);
		}

		function getRedPassPower() {
			return BASE_RED_PASS_POWER;
		}

		function getRedShotPower() {
			return BASE_RED_SHOT_POWER;
		}

		function getKickLockTime() {
			return Math.max(0.14, BASE_KICK_LOCK - (smartLevel * 0.04) - (passingLevel * 0.03));
		}

		function getDefenseTouchPower() {
			return 36 + (defenseLevel * 8);
		}

		function getSpeedUpgradeCost() {
			return 6 + (speedLevel * 6);
		}

		function getSmartUpgradeCost() {
			return 8 + (smartLevel * 8);
		}

		function getShootingUpgradeCost() {
			return 10 + (shootingLevel * 10);
		}

		function getPassingUpgradeCost() {
			return 9 + (passingLevel * 9);
		}

		function getDefenseUpgradeCost() {
			return 7 + (defenseLevel * 7);
		}

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
				baseSpeed: options.speed,
				speed: options.speed,
				vx: 0,
				vy: 0,
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
				spin: 0,
				el: null,
				kick_lock_timer: 0,
				kick_ignore_player: null
			}
		};

		function buildPreviewDots() {
			for (let i = 0; i < 24; i++) {
				const dot = document.createElement('div');
				dot.className = 'zo-soccer-preview-dot';
				field.appendChild(dot);
				previewDots.push(dot);
			}
		}

		function hidePreviewDots() {
			previewDots.forEach(function (dot) {
				dot.classList.remove('is-active');
			});
		}

		function updateActionButtons() {
			actionButtons.forEach(function (btn) {
				btn.classList.toggle('is-active', btn.getAttribute('data-action') === actionMode);
			});

			cornerButtons.forEach(function (btn) {
				btn.classList.toggle('is-active', btn.getAttribute('data-corner') === cornerMode);
			});
		}

		function applyBlueUpgrades() {
			const speedMultiplier = getBlueSpeedMultiplier();
			state.players.forEach(function (player) {
				if (player.team === 'blue') {
					player.speed = player.baseSpeed * speedMultiplier;
				} else {
					player.speed = player.baseSpeed;
				}
			});
		}

		function updateModeLabel() {
			if (decisionMode) {
				modeEl.textContent = decisionContext === 'corner' ? 'Corner' : 'Decision';
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
			coinsEl.textContent = String(coins);
			speedLevelEl.textContent = String(speedLevel);
			smartLevelEl.textContent = String(smartLevel);
			shootingLevelEl.textContent = String(shootingLevel);
			passingLevelEl.textContent = String(passingLevel);
			defenseLevelEl.textContent = String(defenseLevel);

			buySpeedBtn.textContent = 'Speed (' + getSpeedUpgradeCost() + ')';
			buySmartBtn.textContent = 'Smart (' + getSmartUpgradeCost() + ')';
			buyShootingBtn.textContent = 'Shooting (' + getShootingUpgradeCost() + ')';
			buyPassingBtn.textContent = 'Passing (' + getPassingUpgradeCost() + ')';
			buyDefenseBtn.textContent = 'Defense (' + getDefenseUpgradeCost() + ')';

			buySpeedBtn.disabled = coins < getSpeedUpgradeCost();
			buySmartBtn.disabled = coins < getSmartUpgradeCost();
			buyShootingBtn.disabled = coins < getShootingUpgradeCost();
			buyPassingBtn.disabled = coins < getPassingUpgradeCost();
			buyDefenseBtn.disabled = coins < getDefenseUpgradeCost();

			updateActionButtons();
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

		function clearDecisionState() {
			decisionMode = false;
			decisionPlayer = null;
			decisionTarget = null;
			decisionContext = 'normal';
			state.players.forEach(function (p) {
				p.el.classList.remove('zo-soccer-player--decision');
			});
			decisionBox.classList.remove('is-active');
			targetEl.classList.remove('is-active');
			passLineEl.classList.remove('is-active');
			hidePreviewDots();
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
			state.ball.spin = 0;
			state.ball.kick_lock_timer = 0;
			state.ball.kick_ignore_player = null;
			restartType = null;
			restartTeam = null;
			restartSpot = null;
			clearDecisionState();
		}

		function simulateTrajectory(startX, startY, velX, velY, spin) {
			const points = [];
			let px = startX;
			let py = startY;
			let pvx = velX;
			let pvy = velY;
			let pspin = spin;

			for (let i = 0; i < 24; i++) {
				const oldVx = pvx;
				pvx += -pvy * pspin * 0.018;
				pvy += oldVx * pspin * 0.018;

				px += pvx * 0.05;
				py += pvy * 0.05;

				pvx *= 0.985;
				pvy *= 0.985;
				pspin *= 0.985;

				if (py <= BALL_R) {
					py = BALL_R;
					pvy *= -0.82;
				}
				if (py >= FIELD_H - BALL_R) {
					py = FIELD_H - BALL_R;
					pvy *= -0.82;
				}

				points.push({ x: px, y: py });
			}

			return points;
		}

		function renderPreviewDots(startX, startY, velX, velY, spin) {
			const points = simulateTrajectory(startX, startY, velX, velY, spin);
			const rect = field.getBoundingClientRect();
			const scaleX = rect.width / FIELD_W;
			const scaleY = rect.height / FIELD_H;

			previewDots.forEach(function (dot, index) {
				if (points[index]) {
					dot.classList.add('is-active');
					dot.style.left = (points[index].x * scaleX) + 'px';
					dot.style.top = (points[index].y * scaleY) + 'px';
				} else {
					dot.classList.remove('is-active');
				}
			});
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

				const kickData = getDecisionKickData(decisionTarget.x, decisionTarget.y);
				renderPreviewDots(kickData.startX, kickData.startY, kickData.vx, kickData.vy, kickData.spin);
			} else {
				targetEl.classList.remove('is-active');
				passLineEl.classList.remove('is-active');
				hidePreviewDots();
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
			applyBlueUpgrades();
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

				const smartBonus = player.team === 'blue' ? (smartLevel * 10 + passingLevel * 8) : 0;
				const total = forwardScore + spacingScore + roleBonus + smartBonus;

				if (total > bestScore) {
					bestScore = total;
					best = mate;
				}
			});

			return best;
		}

		function getCornerKicker(team) {
			let best = null;
			let bestDist = Infinity;

			state.players.forEach(function (player) {
				if (player.team !== team || player.isGoalie) {
					return;
				}
				const d = distance(player, { x: restartSpot.x, y: restartSpot.y });
				if (d < bestDist) {
					bestDist = d;
					best = player;
				}
			});

			return best;
		}

		function getCornerPresetTarget() {
			if (!restartSpot) {
				return { x: FIELD_W - 150, y: FIELD_H / 2 };
			}

			const isTop = restartSpot.y < FIELD_H / 2;

			if (cornerMode === 'near_post') {
				return { x: FIELD_W - 70, y: isTop ? GOAL_TOP + 18 : GOAL_BOTTOM - 18 };
			}
			if (cornerMode === 'far_post') {
				return { x: FIELD_W - 62, y: isTop ? GOAL_BOTTOM - 18 : GOAL_TOP + 18 };
			}
			if (cornerMode === 'goal') {
				return { x: GOAL_RIGHT_X, y: (GOAL_TOP + GOAL_BOTTOM) / 2 };
			}

			return { x: FIELD_W - 140, y: FIELD_H / 2 };
		}

		function setupBlueCornerPositions() {
			const isTop = restartSpot.y < FIELD_H / 2;

			state.players.forEach(function (player) {
				if (player.team === 'blue') {
					if (player.isGoalie) {
						player.x = 86;
						player.y = 315;
						return;
					}

					if (player === decisionPlayer) {
						player.x = restartSpot.x - 18;
						player.y = restartSpot.y;
						return;
					}

					if (player.position === 'forward') {
						player.x = FIELD_W - 185;
						if (player.label === 'LF') {
							player.y = 280;
						} else if (player.label === 'RF') {
							player.y = 355;
						} else {
							player.y = 315;
						}
						return;
					}

					if (player.position === 'midfielder') {
						player.x = FIELD_W - 260;
						player.y = isTop ? 220 : 410;
						return;
					}

					if (player.position === 'wing') {
						player.x = FIELD_W - 320;
						player.y = isTop ? 155 : 475;
						return;
					}

					player.x = FIELD_W - 410;
					player.y = player.baseHomeY;
					return;
				}

				if (player.isGoalie) {
					player.x = 1034;
					player.y = 315;
				} else if (player.position === 'defender') {
					player.x = FIELD_W - 115;
					player.y = player.baseHomeY;
				} else if (player.position === 'midfielder') {
					player.x = FIELD_W - 165;
					player.y = player.baseHomeY;
				} else {
					player.x = FIELD_W - 235;
					player.y = player.baseHomeY;
				}
			});
		}

		function startDecisionMode(player, context) {
			decisionMode = true;
			running = false;
			decisionPlayer = player;
			decisionContext = context || 'normal';
			decisionTarget = {
				x: player.team === 'blue' ? player.x + 140 : player.x - 140,
				y: player.y
			};

			if (decisionContext === 'corner') {
				setupBlueCornerPositions();
				decisionTarget = getCornerPresetTarget();
			} else {
				const best = findBestPassTarget(player);
				if (best) {
					decisionTarget = { x: best.x, y: best.y };
				}
			}

			state.players.forEach(function (p) {
				p.el.classList.toggle('zo-soccer-player--decision', p === player);
			});

			decisionBox.classList.add('is-active');
			if (decisionContext === 'corner') {
				decisionText.textContent = 'Blue korner. Use near post, far post, penalty spot, or goal. You can still click anywhere on the field.';
				setMessage('Choose korner kick');
			} else {
				decisionText.textContent = 'Use pass, shoot, or cross. Click anywhere. Clicking inside the goal also shoots.';
				setMessage('Choose pass, shot, or cross');
			}
			updateHud();
			render();
		}

		function finishDecisionKick() {
			clearDecisionState();
			running = true;
			updateHud();
			animationId = requestAnimationFrame(loop);
		}

		function getDecisionKickData(targetX, targetY) {
			const dx = targetX - decisionPlayer.x;
			const dy = targetY - decisionPlayer.y;
			const len = Math.sqrt(dx * dx + dy * dy) || 1;
			const nx = dx / len;
			const ny = dy / len;
			const startX = decisionPlayer.x + nx * 24;
			const startY = decisionPlayer.y + ny * 24;
			const insideGoal =
				targetX >= FIELD_W - 18 &&
				targetY >= GOAL_TOP &&
				targetY <= GOAL_BOTTOM;

			let power = getDecisionPassPower(len);
			let spin = 0;

			if (decisionContext === 'corner') {
				if (cornerMode === 'goal' || insideGoal) {
					power = getDecisionShotPower();
				} else {
					power = getDecisionCornerPower();
				}
				spin = (targetY - decisionPlayer.y) * 0.0022;
			} else {
				if (actionMode === 'shoot' || insideGoal) {
					power = getDecisionShotPower();
					spin = (targetY - decisionPlayer.y) * 0.0024;
				} else if (actionMode === 'cross') {
					power = getDecisionCrossPower();
					spin = (targetY - decisionPlayer.y) * 0.0018;
				} else {
					power = getDecisionPassPower(len);
					spin = (targetY - decisionPlayer.y) * 0.0011;
				}
			}

			return {
				startX: startX,
				startY: startY,
				vx: nx * power,
				vy: ny * power,
				spin: spin
			};
		}

		function endDecisionModeAndKick(targetX, targetY) {
			if (!decisionMode || !decisionPlayer) {
				return;
			}

			const kick = getDecisionKickData(targetX, targetY);

			state.ball.x = kick.startX;
			state.ball.y = kick.startY;
			state.ball.vx = kick.vx;
			state.ball.vy = kick.vy;
			state.ball.spin = kick.spin;
			state.ball.kick_lock_timer = getKickLockTime();
			state.ball.kick_ignore_player = decisionPlayer;

			if (decisionContext === 'corner') {
				restartType = null;
				restartTeam = null;
				restartSpot = null;
				setMessage(cornerMode === 'goal' ? 'Korner shot' : 'Korner taken');
				finishDecisionKick();
				return;
			}

			coins += 51;

			if (actionMode === 'shoot') {
				setMessage('Shot taken. +51 coins');
			} else if (actionMode === 'cross') {
				setMessage('Cross played. +51 coins');
			} else {
				setMessage('Pass made. +51 coins');
			}

			finishDecisionKick();
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

			const runOffset = player.team === 'blue' ? 110 : -110;
			const runSide = player.label === 'LF' ? -42 : (player.label === 'RF' ? 42 : 0);

			return {
				x: player.baseHomeX + (player.team === 'blue' ? sideFactor * 0.58 : -sideFactor * 0.58) + runOffset * 0.14,
				y: player.baseHomeY + (ball.y - player.baseHomeY) * 0.18 + runSide * Math.min(1, Math.abs(ball.x - FIELD_W / 2) / 260)
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
			const interceptRadius = team === 'blue' ? getBlueInterceptRadius() : BASE_INTERCEPT_RADIUS;

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

			if (bestDist <= interceptRadius) {
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
			const interceptRadius = player.team === 'blue' ? getBlueInterceptRadius() : BASE_INTERCEPT_RADIUS;
			const chaseRadius = player.team === 'blue' ? getBlueChaseRadius() : BASE_CHASE_RADIUS;

			if (restartType) {
				if (restartType === 'corner' && restartTeam === 'blue') {
					return;
				}

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

				const goalieThreat = player.team === 'blue' ? ball.x < 205 : ball.x > 915;
				const crossThreat = player.team === 'blue' ? ball.x > FIELD_W - 185 : ball.x < 185;

				if (goalieThreat) {
					targetX = player.team === 'blue' ? 58 : 1062;
					targetY = clamp(ball.y, 220, 410);
				} else if (crossThreat && ball.y > 150 && ball.y < FIELD_H - 150) {
					targetX = player.team === 'blue' ? 128 : 992;
					targetY = clamp(ball.y, 240, 390);
				}
			} else {
				const roleHome = getRoleHomeShift(player, ball);
				targetX = roleHome.x;
				targetY = roleHome.y;

				const primary = player.team === 'blue' ? primaryBlue : primaryRed;
				const support = player.team === 'blue' ? supportBlue : supportRed;
				const ballDist = distance(player, ball);

				if (player === primary && ballDist <= interceptRadius) {
					targetX = ball.x + (player.team === 'blue' ? -4 : 4);
					targetY = ball.y;
				} else if (player === support && ballDist <= interceptRadius) {
					targetX = ball.x + (player.team === 'blue' ? -28 : 28);
					targetY = ball.y + (player.baseHomeY < FIELD_H / 2 ? -26 : 26);
				} else if (ballDist <= chaseRadius && player.position !== 'defender') {
					targetX = ball.x + (player.team === 'blue' ? -18 : 18);
					targetY = ball.y;
				}

				if (player.team === 'blue' && player.position === 'defender') {
					const enemyPressure = ball.x < 230;
					if (enemyPressure) {
						targetX = ball.x - 20;
						targetY = ball.y;
					}
				}

				if (player.team === 'blue' && player.position === 'forward') {
					const runGap = player.label === 'LF' ? -55 : (player.label === 'RF' ? 55 : 0);
					targetX += 38;
					targetY += runGap * Math.min(1, Math.abs(ball.x - FIELD_W / 2) / 280);
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
			if (state.ball.kick_lock_timer > 0 || decisionMode) {
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

			const controlDistance = 22 - Math.min(4, smartLevel);
			if (bestDist <= controlDistance) {
				return owner;
			}

			return null;
		}

		function maybeAiPassOrShoot(player) {
			if (restartType) {
				if (restartType === 'corner' && restartTeam === 'blue') {
					return;
				}
				if (player.team === restartTeam && distance(player, state.ball) < 24) {
					handleRestartKick(player.team);
				}
				return;
			}

			if (player.team === 'blue') {
				startDecisionMode(player, 'normal');
				return;
			}

			const towardLeft = player.team === 'red';
			const closeToGoal = towardLeft ? state.ball.x < 210 : state.ball.x > FIELD_W - 210;

			if (closeToGoal || (player.position === 'forward' && Math.random() > 0.55)) {
				kickBallToward(towardLeft ? -24 : FIELD_W + 24, FIELD_H / 2 + (Math.random() * 130 - 65), getRedShotPower());
				state.ball.spin = (Math.random() * 2 - 1) * 0.14;
				state.ball.kick_lock_timer = 0.22;
				state.ball.kick_ignore_player = player;
				return;
			}

			const best = findBestPassTarget(player);

			if (best) {
				kickBallToward(best.x, best.y, getRedPassPower());
			} else {
				kickBallToward(towardLeft ? 120 : FIELD_W - 120, FIELD_H / 2, getRedPassPower() + 10);
			}

			state.ball.spin = 0;
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

					if (player.isGoalie) {
						const defendRightGoal = player.team === 'red';
						const defendLeftGoal = player.team === 'blue';
						const closeToOwnGoal = defendRightGoal ? state.ball.x > FIELD_W - 120 : state.ball.x < 120;

						if (closeToOwnGoal) {
							state.ball.x = player.x + (defendRightGoal ? -22 : 22);
							state.ball.y = player.y;
							state.ball.vx = defendRightGoal ? -240 : 240;
							state.ball.vy = (Math.random() * 120) - 60;
							state.ball.spin = 0;
							state.ball.kick_lock_timer = 0.20;
							state.ball.kick_ignore_player = player;
							return;
						}
					}

					if (player.team === 'blue' && player.position === 'defender' && state.ball.x < 210) {
						state.ball.x = player.x + 24;
						state.ball.y = player.y;
						state.ball.vx = 310 + (defenseLevel * 12);
						state.ball.vy = (Math.random() * 160) - 80;
						state.ball.spin = 0;
						state.ball.kick_lock_timer = 0.20;
						state.ball.kick_ignore_player = player;
						return;
					}

					state.ball.x += nx * overlap;
					state.ball.y += ny * overlap;

					let touchPower = 36;
					if (player.team === 'blue') {
						touchPower = getDefenseTouchPower();
					}

					state.ball.vx += nx * touchPower;
					state.ball.vy += ny * touchPower;

					if (player.team === 'blue') {
						state.ball.vx += 3 + defenseLevel;
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
			state.ball.spin = 0;
			state.ball.kick_lock_timer = 0;
			state.ball.kick_ignore_player = null;

			if (team === 'blue') {
				const kicker = getCornerKicker('blue');
				if (kicker) {
					startDecisionMode(kicker, 'corner');
				}
				setMessage('Blue korner');
			} else {
				setMessage('Red korner');
			}
		}

		function handleRestartKick(team) {
			if (!restartType || !restartSpot) {
				return;
			}

			if (restartType === 'corner') {
				const targetX = team === 'blue' ? FIELD_W - 220 : 220;
				const targetY = FIELD_H / 2 + (Math.random() * 140 - 70);
				const power = team === 'blue' ? getDecisionCornerPower() : 230;
				kickBallToward(targetX, targetY, power);
				state.ball.spin = (Math.random() * 2 - 1) * 0.12;
				state.ball.kick_lock_timer = team === 'blue' ? getKickLockTime() : 0.22;
				state.ball.kick_ignore_player = null;
				setMessage((team === 'blue' ? 'Blue' : 'Red') + ' korner kick');
			}

			restartType = null;
			restartTeam = null;
			restartSpot = null;
		}

		function applyBallPhysics(dt) {
			const oldVx = state.ball.vx;
			state.ball.vx += -state.ball.vy * state.ball.spin * dt * 4.2;
			state.ball.vy += oldVx * state.ball.spin * dt * 4.2;

			state.ball.x += state.ball.vx * dt;
			state.ball.y += state.ball.vy * dt;

			state.ball.vx *= 0.988;
			state.ball.vy *= 0.988;
			state.ball.spin *= 0.989;
		}

		function handlePostRebounds() {
			const postRadius = 9;
			const leftPosts = [
				{ x: 18, y: GOAL_TOP },
				{ x: 18, y: GOAL_BOTTOM }
			];
			const rightPosts = [
				{ x: FIELD_W - 18, y: GOAL_TOP },
				{ x: FIELD_W - 18, y: GOAL_BOTTOM }
			];

			leftPosts.concat(rightPosts).forEach(function (post) {
				const dx = state.ball.x - post.x;
				const dy = state.ball.y - post.y;
				const dist = Math.sqrt(dx * dx + dy * dy);
				const minDist = BALL_R + postRadius;

				if (dist > 0 && dist < minDist) {
					const nx = dx / dist;
					const ny = dy / dist;
					state.ball.x = post.x + nx * minDist;
					state.ball.y = post.y + ny * minDist;

					const dot = state.ball.vx * nx + state.ball.vy * ny;
					state.ball.vx = (state.ball.vx - 2 * dot * nx) * 0.82;
					state.ball.vy = (state.ball.vy - 2 * dot * ny) * 0.82;
					state.ball.spin *= 0.7;
				}
			});
		}

		function updateBall(dt) {
			if (state.ball.kick_lock_timer > 0) {
				state.ball.kick_lock_timer -= dt;
				if (state.ball.kick_lock_timer <= 0) {
					state.ball.kick_lock_timer = 0;
					state.ball.kick_ignore_player = null;
				}
			}

			applyBallPhysics(dt);

			if (state.ball.y <= BALL_R) {
				state.ball.y = BALL_R;
				state.ball.vy *= -0.84;
				state.ball.spin *= 0.82;
			}
			if (state.ball.y >= FIELD_H - BALL_R) {
				state.ball.y = FIELD_H - BALL_R;
				state.ball.vy *= -0.84;
				state.ball.spin *= 0.82;
			}

			handlePostRebounds();

			const inGoalOpening = state.ball.y >= GOAL_TOP && state.ball.y <= GOAL_BOTTOM;

			if (!inGoalOpening) {
				if (state.ball.x <= BALL_R) {
					state.ball.x = BALL_R;
					state.ball.vx *= -0.84;
					state.ball.spin *= 0.82;
				}
				if (state.ball.x >= FIELD_W - BALL_R) {
					state.ball.x = FIELD_W - BALL_R;
					state.ball.vx *= -0.84;
					state.ball.spin *= 0.82;
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
					coins += 10;
					updateHud();
					setMessage('Blue wins. +10 coins');
				} else if (userScore < aiScore) {
					coins += 4;
					updateHud();
					setMessage('Red wins. +4 coins');
				} else {
					coins += 6;
					updateHud();
					setMessage('Draw match. +6 coins');
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
			applyBlueUpgrades();
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

		buySpeedBtn.addEventListener('click', function () {
			const cost = getSpeedUpgradeCost();
			if (coins < cost) {
				return;
			}
			coins -= cost;
			speedLevel += 1;
			applyBlueUpgrades();
			updateHud();
			setMessage('Blue speed upgraded');
		});

		buySmartBtn.addEventListener('click', function () {
			const cost = getSmartUpgradeCost();
			if (coins < cost) {
				return;
			}
			coins -= cost;
			smartLevel += 1;
			updateHud();
			setMessage('Blue smart upgraded');
		});

		buyShootingBtn.addEventListener('click', function () {
			const cost = getShootingUpgradeCost();
			if (coins < cost) {
				return;
			}
			coins -= cost;
			shootingLevel += 1;
			updateHud();
			setMessage('Blue shooting upgraded');
		});

		buyPassingBtn.addEventListener('click', function () {
			const cost = getPassingUpgradeCost();
			if (coins < cost) {
				return;
			}
			coins -= cost;
			passingLevel += 1;
			updateHud();
			setMessage('Blue passing upgraded');
		});

		buyDefenseBtn.addEventListener('click', function () {
			const cost = getDefenseUpgradeCost();
			if (coins < cost) {
				return;
			}
			coins -= cost;
			defenseLevel += 1;
			updateHud();
			setMessage('Blue defense upgraded');
		});

		actionButtons.forEach(function (btn) {
			btn.addEventListener('click', function () {
				actionMode = btn.getAttribute('data-action');
				updateActionButtons();
				render();
			});
		});

		cornerButtons.forEach(function (btn) {
			btn.addEventListener('click', function () {
				cornerMode = btn.getAttribute('data-corner');
				if (decisionMode && decisionContext === 'corner') {
					decisionTarget = getCornerPresetTarget();
					render();
				}
				updateActionButtons();
			});
		});

		buildEntities();
		buildPreviewDots();
		applyBlueUpgrades();
		updateActionButtons();
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
						<strong class="zo-status-coins">0</strong>
						<span>Coins</span>
					</div>
					<div class="zo-soccer-panel">
						<strong class="zo-status-speed-level">0</strong>
						<span>Speed</span>
					</div>
					<div class="zo-soccer-panel">
						<strong class="zo-status-smart-level">0</strong>
						<span>Smartness</span>
					</div>
					<div class="zo-soccer-panel">
						<strong class="zo-status-shooting-level">0</strong>
						<span>Shooting</span>
					</div>
					<div class="zo-soccer-panel">
						<strong class="zo-status-passing-level">0</strong>
						<span>Passing</span>
					</div>
					<div class="zo-soccer-panel">
						<strong class="zo-status-defense-level">0</strong>
						<span>Defense</span>
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
						<button type="button" class="zo-soccer-btn zo-buy-speed">Speed (6)</button>
						<button type="button" class="zo-soccer-btn zo-buy-smart">Smart (8)</button>
						<button type="button" class="zo-soccer-btn zo-buy-shooting">Shooting (10)</button>
						<button type="button" class="zo-soccer-btn zo-buy-passing">Passing (9)</button>
						<button type="button" class="zo-soccer-btn zo-buy-defense">Defense (7)</button>
					</div>

					<div class="zo-soccer-actionbar">
						<button type="button" class="zo-soccer-btn zo-action-btn is-active" data-action="pass">Pass</button>
						<button type="button" class="zo-soccer-btn zo-action-btn" data-action="shoot">Shoot</button>
						<button type="button" class="zo-soccer-btn zo-action-btn" data-action="cross">Cross</button>
					</div>

					<div class="zo-soccer-cornerbar">
						<button type="button" class="zo-soccer-btn zo-corner-btn" data-corner="near_post">Near Post</button>
						<button type="button" class="zo-soccer-btn zo-corner-btn" data-corner="far_post">Far Post</button>
						<button type="button" class="zo-soccer-btn zo-corner-btn is-active" data-corner="penalty">Penalty Spot</button>
						<button type="button" class="zo-soccer-btn zo-corner-btn" data-corner="goal">Goal</button>
					</div>

					<div class="zo-soccer-help">
						This version adds predicted ball path, pass / shoot / cross buttons, targetable corners, defender clearances, better forward runs, goalkeeper step-out on crosses, curved shots, and rebounds from goalkeeper and posts.
					</div>

					<div class="zo-soccer-upgrades">
						<div class="zo-soccer-upgrades-title">Team Upgrades</div>
						<div class="zo-soccer-upgrades-grid">
							<div class="zo-soccer-upgrade-card">
								<strong>Speed</strong>
								<span>Blue players run faster.</span>
							</div>
							<div class="zo-soccer-upgrade-card">
								<strong>Smartness</strong>
								<span>Better spacing and support.</span>
							</div>
							<div class="zo-soccer-upgrade-card">
								<strong>Shooting</strong>
								<span>Stronger direct shots.</span>
							</div>
							<div class="zo-soccer-upgrade-card">
								<strong>Passing</strong>
								<span>Better passes and corners.</span>
							</div>
							<div class="zo-soccer-upgrade-card">
								<strong>Defense</strong>
								<span>Better clearances and pressure.</span>
							</div>
						</div>
					</div>

					<div class="zo-soccer-decision">
						<div class="zo-soccer-decision-text">Choose where to kick.</div>
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
	'description'     => 'A slow 5 minute soccer match with AI players, corner kicks, shooting, trajectory preview, and team upgrades.',
	'render_callback' => 'zo_game_soccer_match_ai_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);