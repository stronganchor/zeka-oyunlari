<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 620px;
	margin: 0 auto;
	font-family: inherit;
}

.zo-game-root--car-lane-switch .zo-car-game {
	background: linear-gradient(180deg, #bfe7ff 0%, #eaf7ff 42%, #74c365 42%, #5daa4f 100%);
	border-radius: 22px;
	padding: 16px;
	box-sizing: border-box;
	box-shadow: 0 10px 24px rgba(0, 0, 0, 0.12);
	position: relative;
	overflow: hidden;
}

.zo-game-root--car-lane-switch .zo-car-game[data-theme="desert"] {
	background: linear-gradient(180deg, #ffd79f 0%, #fff0cf 42%, #d7a867 42%, #c58d49 100%);
}

.zo-game-root--car-lane-switch .zo-car-game[data-theme="snow"] {
	background: linear-gradient(180deg, #dff1ff 0%, #f6fbff 42%, #e9f4fb 42%, #cfe4ef 100%);
}

.zo-game-root--car-lane-switch .zo-car-game[data-theme="night"] {
	background: linear-gradient(180deg, #13213b 0%, #1b3358 42%, #203d2d 42%, #16291f 100%);
}

.zo-game-root--car-lane-switch .zo-car-title {
	margin: 0 0 8px;
	font-size: 28px;
	line-height: 1.2;
	text-align: center;
	color: #17324d;
}

.zo-game-root--car-lane-switch .zo-car-game[data-theme="night"] .zo-car-title,
.zo-game-root--car-lane-switch .zo-car-game[data-theme="night"] .zo-car-status,
.zo-game-root--car-lane-switch .zo-car-game[data-theme="night"] .zo-car-instructions {
	color: #e7f0ff;
}

.zo-game-root--car-lane-switch .zo-car-instructions {
	margin: 0 0 14px;
	font-size: 14px;
	line-height: 1.5;
	text-align: center;
	color: #21415d;
	background: rgba(255, 255, 255, 0.72);
	padding: 10px 12px;
	border-radius: 12px;
}

.zo-game-root--car-lane-switch .zo-car-topbar {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 8px;
	margin-bottom: 10px;
}

.zo-game-root--car-lane-switch .zo-car-select {
	width: 100%;
	box-sizing: border-box;
	border: 0;
	border-radius: 12px;
	padding: 10px 12px;
	font-size: 14px;
	font-weight: 700;
	background: rgba(255, 255, 255, 0.92);
	color: #17324d;
	box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08);
}

.zo-game-root--car-lane-switch .zo-car-hud {
	display: flex;
	gap: 10px;
	justify-content: space-between;
	flex-wrap: wrap;
	margin-bottom: 12px;
}

.zo-game-root--car-lane-switch .zo-car-chip {
	flex: 1 1 30%;
	min-width: 120px;
	background: rgba(255, 255, 255, 0.9);
	border-radius: 12px;
	padding: 10px 12px;
	text-align: center;
	box-sizing: border-box;
}

.zo-game-root--car-lane-switch .zo-car-chip-label {
	display: block;
	font-size: 12px;
	color: #4b6072;
	margin-bottom: 4px;
}

.zo-game-root--car-lane-switch .zo-car-chip-value {
	display: block;
	font-size: 20px;
	font-weight: 700;
	color: #17324d;
}

.zo-game-root--car-lane-switch .zo-car-track-wrap {
	position: relative;
}

.zo-game-root--car-lane-switch .zo-car-track {
	position: relative;
	width: 100%;
	height: 480px;
	border-radius: 18px;
	overflow: hidden;
	background:
		linear-gradient(90deg, #4f4f4f 0%, #585858 8%, #4b4b4b 50%, #585858 92%, #4f4f4f 100%);
	box-shadow: inset 0 0 0 4px rgba(255, 255, 255, 0.08);
	touch-action: manipulation;
	user-select: none;
}

.zo-game-root--car-lane-switch .zo-car-game[data-theme="city"] .zo-car-track {
	background:
		linear-gradient(90deg, #4f4f4f 0%, #5a5a5a 8%, #4a4a4a 50%, #5a5a5a 92%, #4f4f4f 100%);
}

.zo-game-root--car-lane-switch .zo-car-game[data-theme="desert"] .zo-car-track {
	background:
		linear-gradient(90deg, #6f645b 0%, #786d64 8%, #675d55 50%, #786d64 92%, #6f645b 100%);
}

.zo-game-root--car-lane-switch .zo-car-game[data-theme="snow"] .zo-car-track {
	background:
		linear-gradient(90deg, #737b86 0%, #818a96 8%, #6d7580 50%, #818a96 92%, #737b86 100%);
}

.zo-game-root--car-lane-switch .zo-car-game[data-theme="night"] .zo-car-track {
	background:
		linear-gradient(90deg, #21252c 0%, #2b3039 8%, #1a1e25 50%, #2b3039 92%, #21252c 100%);
}

.zo-game-root--car-lane-switch .zo-car-grass-left,
.zo-game-root--car-lane-switch .zo-car-grass-right {
	position: absolute;
	top: 0;
	bottom: 0;
	width: 16%;
	background:
		repeating-linear-gradient(
			180deg,
			#68b74d 0px,
			#68b74d 24px,
			#5ca844 24px,
			#5ca844 48px
		);
	z-index: 1;
}

.zo-game-root--car-lane-switch .zo-car-game[data-theme="city"] .zo-car-grass-left,
.zo-game-root--car-lane-switch .zo-car-game[data-theme="city"] .zo-car-grass-right {
	background:
		repeating-linear-gradient(
			180deg,
			#89939f 0px,
			#89939f 24px,
			#7a858f 24px,
			#7a858f 48px
		);
}

.zo-game-root--car-lane-switch .zo-car-game[data-theme="desert"] .zo-car-grass-left,
.zo-game-root--car-lane-switch .zo-car-game[data-theme="desert"] .zo-car-grass-right {
	background:
		repeating-linear-gradient(
			180deg,
			#d7a867 0px,
			#d7a867 24px,
			#ca9755 24px,
			#ca9755 48px
		);
}

.zo-game-root--car-lane-switch .zo-car-game[data-theme="snow"] .zo-car-grass-left,
.zo-game-root--car-lane-switch .zo-car-game[data-theme="snow"] .zo-car-grass-right {
	background:
		repeating-linear-gradient(
			180deg,
			#f3f8fc 0px,
			#f3f8fc 24px,
			#e4edf4 24px,
			#e4edf4 48px
		);
}

.zo-game-root--car-lane-switch .zo-car-game[data-theme="night"] .zo-car-grass-left,
.zo-game-root--car-lane-switch .zo-car-game[data-theme="night"] .zo-car-grass-right {
	background:
		repeating-linear-gradient(
			180deg,
			#1e3c2b 0px,
			#1e3c2b 24px,
			#173121 24px,
			#173121 48px
		);
}

.zo-game-root--car-lane-switch .zo-car-grass-left {
	left: 0;
}

.zo-game-root--car-lane-switch .zo-car-grass-right {
	right: 0;
}

.zo-game-root--car-lane-switch .zo-car-road {
	position: absolute;
	top: 0;
	bottom: 0;
	left: 16%;
	right: 16%;
	z-index: 2;
}

.zo-game-root--car-lane-switch .zo-car-road::before,
.zo-game-root--car-lane-switch .zo-car-road::after {
	content: '';
	position: absolute;
	top: 0;
	bottom: 0;
	width: 6px;
	background:
		repeating-linear-gradient(
			180deg,
			rgba(255, 255, 255, 0.85) 0px,
			rgba(255, 255, 255, 0.85) 26px,
			transparent 26px,
			transparent 52px
		);
	opacity: 0.9;
}

.zo-game-root--car-lane-switch .zo-car-road::before {
	left: 33.333%;
	transform: translateX(-50%);
}

.zo-game-root--car-lane-switch .zo-car-road::after {
	left: 66.666%;
	transform: translateX(-50%);
}

.zo-game-root--car-lane-switch .zo-car-player,
.zo-game-root--car-lane-switch .zo-car-obstacle,
.zo-game-root--car-lane-switch .zo-car-coin,
.zo-game-root--car-lane-switch .zo-car-powerup {
	position: absolute;
	transform: translateX(-50%);
	will-change: top, left, transform;
}

.zo-game-root--car-lane-switch .zo-car-player,
.zo-game-root--car-lane-switch .zo-car-obstacle {
	width: 20%;
	max-width: 72px;
	min-width: 54px;
	aspect-ratio: 0.78 / 1;
	border-radius: 16px 16px 10px 10px;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 34px;
}

.zo-game-root--car-lane-switch .zo-car-player {
	bottom: 18px;
	z-index: 7;
	background: linear-gradient(180deg, #ff5757 0%, #d71f1f 100%);
	box-shadow:
		inset 0 0 0 3px rgba(255, 255, 255, 0.26),
		0 8px 16px rgba(0, 0, 0, 0.22);
	transition: left 0.14s ease, transform 0.14s ease, filter 0.14s ease;
}

.zo-game-root--car-lane-switch .zo-car-player.is-shielded {
	box-shadow:
		0 0 0 8px rgba(72, 178, 255, 0.28),
		inset 0 0 0 3px rgba(255, 255, 255, 0.26),
		0 8px 16px rgba(0, 0, 0, 0.22);
	filter: saturate(1.15);
}

.zo-game-root--car-lane-switch .zo-car-player.is-magnetized {
	box-shadow:
		0 0 0 8px rgba(255, 219, 77, 0.28),
		inset 0 0 0 3px rgba(255, 255, 255, 0.26),
		0 8px 16px rgba(0, 0, 0, 0.22);
}

.zo-game-root--car-lane-switch .zo-car-player.is-turbo {
	transform: translateX(-50%) scale(1.05);
}

.zo-game-root--car-lane-switch .zo-car-player::before,
.zo-game-root--car-lane-switch .zo-car-obstacle::before {
	content: '';
	position: absolute;
	top: 12%;
	left: 18%;
	right: 18%;
	height: 22%;
	border-radius: 10px;
	background: rgba(180, 235, 255, 0.9);
}

.zo-game-root--car-lane-switch .zo-car-player::after,
.zo-game-root--car-lane-switch .zo-car-obstacle::after {
	content: '';
	position: absolute;
	bottom: 10%;
	left: 16%;
	right: 16%;
	height: 12%;
	border-radius: 10px;
	background: rgba(255, 225, 120, 0.92);
}

.zo-game-root--car-lane-switch .zo-car-obstacle {
	top: -120px;
	z-index: 5;
	background: linear-gradient(180deg, #4b7dff 0%, #2248b5 100%);
	box-shadow:
		inset 0 0 0 3px rgba(255, 255, 255, 0.22),
		0 8px 16px rgba(0, 0, 0, 0.2);
}

.zo-game-root--car-lane-switch .zo-car-obstacle--truck {
	background: linear-gradient(180deg, #ffa643 0%, #d76c00 100%);
}

.zo-game-root--car-lane-switch .zo-car-obstacle--oil {
	background: linear-gradient(180deg, #2a2a2a 0%, #000 100%);
	border-radius: 50%;
	aspect-ratio: 1 / 1;
	font-size: 26px;
}

.zo-game-root--car-lane-switch .zo-car-obstacle--oil::before,
.zo-game-root--car-lane-switch .zo-car-obstacle--oil::after {
	display: none;
}

.zo-game-root--car-lane-switch .zo-car-coin,
.zo-game-root--car-lane-switch .zo-car-powerup {
	z-index: 6;
	display: flex;
	align-items: center;
	justify-content: center;
}

.zo-game-root--car-lane-switch .zo-car-coin {
	width: 34px;
	height: 34px;
	border-radius: 50%;
	font-size: 22px;
	background: radial-gradient(circle at 35% 35%, #fff9c5 0%, #ffd95d 45%, #e0a700 100%);
	box-shadow: 0 6px 12px rgba(0, 0, 0, 0.18);
}

.zo-game-root--car-lane-switch .zo-car-powerup {
	width: 42px;
	height: 42px;
	border-radius: 50%;
	font-size: 22px;
	background: linear-gradient(180deg, #ffffff 0%, #ddf3ff 100%);
	box-shadow: 0 6px 14px rgba(0, 0, 0, 0.18);
	border: 3px solid rgba(255, 255, 255, 0.9);
}

.zo-game-root--car-lane-switch .zo-car-powerup--shield {
	box-shadow: 0 0 0 4px rgba(72, 178, 255, 0.2), 0 6px 14px rgba(0, 0, 0, 0.18);
}

.zo-game-root--car-lane-switch .zo-car-powerup--slow {
	box-shadow: 0 0 0 4px rgba(126, 222, 161, 0.22), 0 6px 14px rgba(0, 0, 0, 0.18);
}

.zo-game-root--car-lane-switch .zo-car-powerup--magnet {
	box-shadow: 0 0 0 4px rgba(255, 219, 77, 0.24), 0 6px 14px rgba(0, 0, 0, 0.18);
}

.zo-game-root--car-lane-switch .zo-car-powerup--turbo {
	box-shadow: 0 0 0 4px rgba(255, 140, 107, 0.22), 0 6px 14px rgba(0, 0, 0, 0.18);
}

.zo-game-root--car-lane-switch .zo-car-overlay {
	position: absolute;
	inset: 0;
	z-index: 12;
	display: flex;
	align-items: center;
	justify-content: center;
	background: rgba(10, 24, 39, 0.58);
	padding: 18px;
	box-sizing: border-box;
}

.zo-game-root--car-lane-switch .zo-car-overlay[hidden] {
	display: none;
}

.zo-game-root--car-lane-switch .zo-car-panel {
	width: 100%;
	max-width: 380px;
	background: #ffffff;
	border-radius: 18px;
	padding: 18px 16px;
	text-align: center;
	box-shadow: 0 12px 28px rgba(0, 0, 0, 0.22);
}

.zo-game-root--car-lane-switch .zo-car-panel-title {
	margin: 0 0 8px;
	font-size: 24px;
	color: #16304a;
}

.zo-game-root--car-lane-switch .zo-car-panel-text {
	margin: 0 0 14px;
	font-size: 15px;
	line-height: 1.5;
	color: #3e5568;
}

.zo-game-root--car-lane-switch .zo-car-panel-countdown {
	font-size: 52px;
	font-weight: 800;
	line-height: 1;
	color: #e44949;
	margin: 8px 0 14px;
	min-height: 52px;
}

.zo-game-root--car-lane-switch .zo-car-buttons {
	display: flex;
	gap: 10px;
	justify-content: center;
	flex-wrap: wrap;
	margin-top: 14px;
}

.zo-game-root--car-lane-switch .zo-car-btn {
	appearance: none;
	border: 0;
	border-radius: 999px;
	padding: 12px 18px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	background: #17324d;
	color: #fff;
	box-shadow: 0 6px 14px rgba(23, 50, 77, 0.2);
	transition: transform 0.15s ease, opacity 0.15s ease;
}

.zo-game-root--car-lane-switch .zo-car-btn:hover,
.zo-game-root--car-lane-switch .zo-car-btn:focus {
	transform: translateY(-1px);
}

.zo-game-root--car-lane-switch .zo-car-btn:active {
	transform: translateY(1px);
}

.zo-game-root--car-lane-switch .zo-car-btn--accent {
	background: #e44949;
}

.zo-game-root--car-lane-switch .zo-car-btn[aria-pressed="true"] {
	background: #2f7d32;
}

.zo-game-root--car-lane-switch .zo-car-controls {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 10px;
	margin-top: 14px;
}

.zo-game-root--car-lane-switch .zo-car-control {
	appearance: none;
	border: 0;
	border-radius: 16px;
	padding: 14px 10px;
	font-size: 16px;
	font-weight: 700;
	cursor: pointer;
	background: rgba(255, 255, 255, 0.88);
	color: #17324d;
	box-shadow: 0 8px 18px rgba(0, 0, 0, 0.12);
}

.zo-game-root--car-lane-switch .zo-car-status {
	margin-top: 12px;
	min-height: 24px;
	text-align: center;
	font-size: 15px;
	font-weight: 700;
	color: #17324d;
}

.zo-game-root--car-lane-switch .zo-car-status.is-danger {
	color: #b21f1f;
}

.zo-game-root--car-lane-switch .zo-car-active-powers {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
	justify-content: center;
	margin-top: 10px;
	min-height: 34px;
}

.zo-game-root--car-lane-switch .zo-car-power-pill {
	background: rgba(255, 255, 255, 0.92);
	color: #17324d;
	border-radius: 999px;
	padding: 7px 12px;
	font-size: 13px;
	font-weight: 700;
	box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08);
}

.zo-game-root--car-lane-switch .zo-car-power-pill.is-empty {
	opacity: 0.7;
}

@media (max-width: 640px) {
	.zo-game-root--car-lane-switch .zo-car-topbar {
		grid-template-columns: repeat(2, minmax(0, 1fr));
	}

	.zo-game-root--car-lane-switch .zo-car-track {
		height: 420px;
	}

	.zo-game-root--car-lane-switch .zo-car-title {
		font-size: 24px;
	}

	.zo-game-root--car-lane-switch .zo-car-player,
	.zo-game-root--car-lane-switch .zo-car-obstacle {
		font-size: 28px;
		min-width: 48px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--car-lane-switch');

	games.forEach(function (game) {
		if (game.dataset.zoCarReady === '1') {
			return;
		}
		game.dataset.zoCarReady = '1';

		const gameWrap = game.querySelector('.zo-car-game');
		const track = game.querySelector('.zo-car-track');
		const road = game.querySelector('.zo-car-road');
		const player = game.querySelector('.zo-car-player');
		const scoreValue = game.querySelector('.zo-car-score');
		const bestValue = game.querySelector('.zo-car-best');
		const speedValue = game.querySelector('.zo-car-speed');
		const coinValue = game.querySelector('.zo-car-coins');
		const status = game.querySelector('.zo-car-status');
		const overlay = game.querySelector('.zo-car-overlay');
		const overlayTitle = game.querySelector('.zo-car-panel-title');
		const overlayText = game.querySelector('.zo-car-panel-text');
		const countdownEl = game.querySelector('.zo-car-panel-countdown');
		const startBtn = game.querySelector('.zo-car-start');
		const restartBtn = game.querySelector('.zo-car-restart');
		const pauseBtn = game.querySelector('.zo-car-pause');
		const leftBtn = game.querySelector('.zo-car-left');
		const rightBtn = game.querySelector('.zo-car-right');
		const skinSelect = game.querySelector('.zo-car-skin');
		const difficultySelect = game.querySelector('.zo-car-difficulty');
		const themeSelect = game.querySelector('.zo-car-theme');
		const soundToggle = game.querySelector('.zo-car-sound');
		const activePowers = game.querySelector('.zo-car-active-powers');

		const lanePercents = [16.66, 50, 83.33];
		const obstacleTypes = ['car', 'truck', 'oil'];
		const powerTypes = ['shield', 'slow', 'magnet', 'turbo'];
		const bestKey = 'zo_car_lane_switch_best_v2';

		let bestScore = 0;

		try {
			bestScore = parseInt(window.localStorage.getItem(bestKey), 10) || 0;
		} catch (err) {
			bestScore = 0;
		}

		const difficultySettings = {
			easy: {
				baseSpeed: 220,
				spawnGap: 1.28,
				speedGain: 4.2,
				coinGap: 1.3,
				powerGap: 7.5
			},
			medium: {
				baseSpeed: 270,
				spawnGap: 1.05,
				speedGain: 6.2,
				coinGap: 1.1,
				powerGap: 6.2
			},
			hard: {
				baseSpeed: 330,
				spawnGap: 0.86,
				speedGain: 8.4,
				coinGap: 1.0,
				powerGap: 5.2
			}
		};

		const skins = {
			red: {
				emoji: '🚗',
				background: 'linear-gradient(180deg, #ff5757 0%, #d71f1f 100%)'
			},
			blue: {
				emoji: '🚙',
				background: 'linear-gradient(180deg, #59a7ff 0%, #205fd0 100%)'
			},
			green: {
				emoji: '🚕',
				background: 'linear-gradient(180deg, #59d96b 0%, #198f34 100%)'
			},
			purple: {
				emoji: '🚘',
				background: 'linear-gradient(180deg, #b07bff 0%, #6f38d0 100%)'
			}
		};

		let laneIndex = 1;
		let obstacles = [];
		let coins = [];
		let powerups = [];
		let animationFrame = null;
		let lastTime = 0;
		let spawnTimer = 0;
		let coinTimer = 0;
		let powerTimer = 0;
		let running = false;
		let ended = false;
		let paused = false;
		let score = 0;
		let coinScore = 0;
		let speed = difficultySettings.medium.baseSpeed;
		let countdownTimer = null;
		let soundEnabled = false;
		let audioContext = null;
		let activePowerTimers = {
			shield: 0,
			slow: 0,
			magnet: 0,
			turbo: 0
		};

		bestValue.textContent = String(bestScore);

		function getSettings() {
			return difficultySettings[difficultySelect.value] || difficultySettings.medium;
		}

		function ensureAudio() {
			if (!soundEnabled) {
				return null;
			}
			if (!audioContext) {
				const AudioCtor = window.AudioContext || window.webkitAudioContext;
				if (!AudioCtor) {
					return null;
				}
				audioContext = new AudioCtor();
			}
			if (audioContext.state === 'suspended') {
				audioContext.resume().catch(function () {});
			}
			return audioContext;
		}

		function playTone(type) {
			if (!soundEnabled) {
				return;
			}
			const ctx = ensureAudio();
			if (!ctx) {
				return;
			}

			const now = ctx.currentTime;
			const osc = ctx.createOscillator();
			const gain = ctx.createGain();

			let frequency = 440;
			let duration = 0.12;
			let wave = 'sine';

			if (type === 'coin') {
				frequency = 880;
				duration = 0.08;
				wave = 'triangle';
			} else if (type === 'power') {
				frequency = 660;
				duration = 0.14;
				wave = 'square';
			} else if (type === 'crash') {
				frequency = 180;
				duration = 0.22;
				wave = 'sawtooth';
			} else if (type === 'go') {
				frequency = 520;
				duration = 0.1;
				wave = 'square';
			} else if (type === 'beep') {
				frequency = 420;
				duration = 0.08;
				wave = 'square';
			} else if (type === 'pause') {
				frequency = 250;
				duration = 0.08;
			}

			osc.type = wave;
			osc.frequency.setValueAtTime(frequency, now);
			gain.gain.setValueAtTime(0.0001, now);
			gain.gain.exponentialRampToValueAtTime(0.08, now + 0.01);
			gain.gain.exponentialRampToValueAtTime(0.0001, now + duration);

			osc.connect(gain);
			gain.connect(ctx.destination);

			osc.start(now);
			osc.stop(now + duration + 0.02);
		}

		function playMusicStep() {
			if (!running || paused || !soundEnabled) {
				return;
			}
			const ctx = ensureAudio();
			if (!ctx) {
				return;
			}

			const now = ctx.currentTime;
			const notes = [262, 330, 392, 523];
			const note = notes[Math.floor(Math.random() * notes.length)];

			const osc = ctx.createOscillator();
			const gain = ctx.createGain();

			osc.type = 'triangle';
			osc.frequency.setValueAtTime(note, now);
			gain.gain.setValueAtTime(0.0001, now);
			gain.gain.exponentialRampToValueAtTime(0.018, now + 0.01);
			gain.gain.exponentialRampToValueAtTime(0.0001, now + 0.18);

			osc.connect(gain);
			gain.connect(ctx.destination);

			osc.start(now);
			osc.stop(now + 0.2);
		}

		function setPlayerLane() {
			player.style.left = lanePercents[laneIndex] + '%';
		}

		function setStatus(message, danger) {
			status.textContent = message;
			status.classList.toggle('is-danger', !!danger);
		}

		function updateHud() {
			scoreValue.textContent = String(score);
			coinValue.textContent = String(coinScore);
			speedValue.textContent = String(Math.round(speed / 26));
			bestValue.textContent = String(bestScore);
		}

		function updatePlayerSkin() {
			const skin = skins[skinSelect.value] || skins.red;
			player.textContent = skin.emoji;
			player.style.background = skin.background;
		}

		function applyTheme() {
			gameWrap.setAttribute('data-theme', themeSelect.value);
		}

		function clearList(list) {
			list.forEach(function (item) {
				if (item.el && item.el.parentNode) {
					item.el.parentNode.removeChild(item.el);
				}
			});
			list.length = 0;
		}

		function clearAllFalling() {
			clearList(obstacles);
			clearList(coins);
			clearList(powerups);
		}

		function showOverlay(title, text, buttonText, countText) {
			overlayTitle.textContent = title;
			overlayText.textContent = text;
			startBtn.textContent = buttonText;
			countdownEl.textContent = countText || '';
			overlay.hidden = false;
		}

		function hideOverlay() {
			overlay.hidden = true;
		}

		function updatePowerClasses() {
			player.classList.toggle('is-shielded', activePowerTimers.shield > 0);
			player.classList.toggle('is-magnetized', activePowerTimers.magnet > 0);
			player.classList.toggle('is-turbo', activePowerTimers.turbo > 0);
		}

		function updatePowerPills() {
			const active = [];
			if (activePowerTimers.shield > 0) {
				active.push('🛡 Shield ' + Math.ceil(activePowerTimers.shield));
			}
			if (activePowerTimers.slow > 0) {
				active.push('🐢 Slow ' + Math.ceil(activePowerTimers.slow));
			}
			if (activePowerTimers.magnet > 0) {
				active.push('🧲 Magnet ' + Math.ceil(activePowerTimers.magnet));
			}
			if (activePowerTimers.turbo > 0) {
				active.push('⚡ Turbo ' + Math.ceil(activePowerTimers.turbo));
			}

			if (!active.length) {
				activePowers.innerHTML = '<span class="zo-car-power-pill is-empty">No active power-ups</span>';
				return;
			}

			activePowers.innerHTML = active.map(function (label) {
				return '<span class="zo-car-power-pill">' + label + '</span>';
			}).join('');
		}

		function activatePower(type) {
			if (type === 'shield') {
				activePowerTimers.shield = 6;
				setStatus('Shield active. One crash is blocked.', false);
			} else if (type === 'slow') {
				activePowerTimers.slow = 5;
				setStatus('Slow motion active.', false);
			} else if (type === 'magnet') {
				activePowerTimers.magnet = 6;
				setStatus('Coin magnet active.', false);
			} else if (type === 'turbo') {
				activePowerTimers.turbo = 4.5;
				setStatus('Turbo active. Extra speed and score.', false);
			}

			updatePowerClasses();
			updatePowerPills();
			playTone('power');
		}

		function spawnObstacle() {
			const type = obstacleTypes[Math.floor(Math.random() * obstacleTypes.length)];
			const obstacle = document.createElement('div');
			obstacle.className = 'zo-car-obstacle';

			if (type === 'truck') {
				obstacle.classList.add('zo-car-obstacle--truck');
				obstacle.textContent = '🚚';
			} else if (type === 'oil') {
				obstacle.classList.add('zo-car-obstacle--oil');
				obstacle.textContent = '🛞';
			} else {
				obstacle.textContent = '🚙';
			}

			const lane = Math.floor(Math.random() * 3);
			obstacle.style.left = lanePercents[lane] + '%';
			obstacle.style.top = '-90px';
			road.appendChild(obstacle);

			obstacles.push({
				el: obstacle,
				lane: lane,
				y: -90,
				passed: false,
				height: type === 'oil' ? 52 : 86,
				type: type
			});
		}

		function spawnCoin() {
			const coin = document.createElement('div');
			coin.className = 'zo-car-coin';
			coin.textContent = '🪙';
			const lane = Math.floor(Math.random() * 3);
			coin.style.left = lanePercents[lane] + '%';
			coin.style.top = '-40px';
			road.appendChild(coin);

			coins.push({
				el: coin,
				lane: lane,
				y: -40,
				height: 34
			});
		}

		function spawnPowerup() {
			const type = powerTypes[Math.floor(Math.random() * powerTypes.length)];
			const powerup = document.createElement('div');
			powerup.className = 'zo-car-powerup zo-car-powerup--' + type;

			if (type === 'shield') {
				powerup.textContent = '🛡';
			} else if (type === 'slow') {
				powerup.textContent = '🐢';
			} else if (type === 'magnet') {
				powerup.textContent = '🧲';
			} else {
				powerup.textContent = '⚡';
			}

			const lane = Math.floor(Math.random() * 3);
			powerup.style.left = lanePercents[lane] + '%';
			powerup.style.top = '-48px';
			road.appendChild(powerup);

			powerups.push({
				el: powerup,
				lane: lane,
				y: -48,
				height: 42,
				type: type
			});
		}

		function endGame(message) {
			running = false;
			ended = true;
			paused = false;
			pauseBtn.textContent = 'Pause';
			pauseBtn.setAttribute('aria-pressed', 'false');

			if (countdownTimer) {
				window.clearTimeout(countdownTimer);
				countdownTimer = null;
			}

			if (animationFrame) {
				cancelAnimationFrame(animationFrame);
				animationFrame = null;
			}

			if (score > bestScore) {
				bestScore = score;
				try {
					window.localStorage.setItem(bestKey, String(bestScore));
				} catch (err) {}
			}

			updateHud();
			updatePowerPills();
			updatePowerClasses();
			setStatus(message || 'Crash. Tap restart and try again.', true);
			showOverlay('Game Over', 'Score: ' + score + ' | Coins: ' + coinScore + ' | Best: ' + bestScore, 'Play Again', '');
			playTone('crash');
		}

		function consumeShield() {
			activePowerTimers.shield = 0;
			updatePowerClasses();
			updatePowerPills();
			setStatus('Shield saved you.', false);
		}

		function resetGame() {
			if (animationFrame) {
				cancelAnimationFrame(animationFrame);
				animationFrame = null;
			}
			if (countdownTimer) {
				window.clearTimeout(countdownTimer);
				countdownTimer = null;
			}

			running = false;
			ended = false;
			paused = false;
			lastTime = 0;
			spawnTimer = 0;
			coinTimer = 0;
			powerTimer = 0;
			score = 0;
			coinScore = 0;
			laneIndex = 1;
			activePowerTimers.shield = 0;
			activePowerTimers.slow = 0;
			activePowerTimers.magnet = 0;
			activePowerTimers.turbo = 0;

			const settings = getSettings();
			speed = settings.baseSpeed;

			clearAllFalling();
			setPlayerLane();
			updateHud();
			updatePlayerSkin();
			applyTheme();
			updatePowerClasses();
			updatePowerPills();
			pauseBtn.textContent = 'Pause';
			pauseBtn.setAttribute('aria-pressed', 'false');
			setStatus('Choose your setup, then press Start.', false);
			showOverlay('Car Lane Switch', 'Pick a car skin, difficulty, road theme, and sound. Then survive traffic, collect coins, and grab power-ups.', 'Start', '');
		}

		function reallyStartGame() {
			clearAllFalling();
			score = 0;
			coinScore = 0;
			spawnTimer = 0;
			coinTimer = 0;
			powerTimer = 0;
			lastTime = 0;
			running = true;
			ended = false;
			paused = false;
			laneIndex = 1;
			activePowerTimers.shield = 0;
			activePowerTimers.slow = 0;
			activePowerTimers.magnet = 0;
			activePowerTimers.turbo = 0;
			speed = getSettings().baseSpeed;

			setPlayerLane();
			updatePlayerSkin();
			applyTheme();
			updateHud();
			updatePowerClasses();
			updatePowerPills();
			hideOverlay();
			pauseBtn.textContent = 'Pause';
			pauseBtn.setAttribute('aria-pressed', 'false');
			setStatus('Go. Dodge traffic and collect bonuses.', false);
			playTone('go');
			animationFrame = requestAnimationFrame(loop);
		}

		function startCountdown() {
			if (running) {
				return;
			}
			if (countdownTimer) {
				window.clearTimeout(countdownTimer);
				countdownTimer = null;
			}

			updatePlayerSkin();
			applyTheme();
			showOverlay('Get Ready', 'Lane switching starts after the countdown.', 'Start', '3');

			const values = ['3', '2', '1', 'GO'];
			let index = 0;

			function nextStep() {
				countdownEl.textContent = values[index];

				if (values[index] === 'GO') {
					playTone('go');
				} else {
					playTone('beep');
				}

				index += 1;

				if (index < values.length) {
					countdownTimer = window.setTimeout(nextStep, 700);
				} else {
					countdownTimer = window.setTimeout(function () {
						countdownEl.textContent = '';
						countdownTimer = null;
						reallyStartGame();
					}, 450);
				}
			}

			nextStep();
		}

		function pauseGame() {
			if (!running) {
				return;
			}
			paused = !paused;

			if (paused) {
				if (animationFrame) {
					cancelAnimationFrame(animationFrame);
					animationFrame = null;
				}
				pauseBtn.textContent = 'Resume';
				pauseBtn.setAttribute('aria-pressed', 'true');
				setStatus('Paused.', false);
				showOverlay('Paused', 'Tap Resume or press Pause again to continue.', 'Resume', '');
				playTone('pause');
			} else {
				hideOverlay();
				lastTime = 0;
				pauseBtn.textContent = 'Pause';
				pauseBtn.setAttribute('aria-pressed', 'false');
				setStatus('Back on the road.', false);
				playTone('go');
				animationFrame = requestAnimationFrame(loop);
			}
		}

		function moveLeft() {
			if (ended || countdownTimer) {
				return;
			}
			laneIndex = Math.max(0, laneIndex - 1);
			setPlayerLane();
		}

		function moveRight() {
			if (ended || countdownTimer) {
				return;
			}
			laneIndex = Math.min(2, laneIndex + 1);
			setPlayerLane();
		}

		function intersectsLane(yTop, yBottom, lane) {
			const playerTop = track.clientHeight - player.offsetHeight - 18;
			const playerBottom = playerTop + player.offsetHeight - 10;
			return lane === laneIndex && yBottom >= playerTop && yTop <= playerBottom;
		}

		function collectCoin(item, index) {
			coinScore += 1;
			score += activePowerTimers.turbo > 0 ? 2 : 1;
			if (score > bestScore) {
				bestScore = score;
			}
			updateHud();
			playTone('coin');
			if (item.el && item.el.parentNode) {
				item.el.parentNode.removeChild(item.el);
			}
			coins.splice(index, 1);
		}

		function collectPowerup(item, index) {
			activatePower(item.type);
			if (item.el && item.el.parentNode) {
				item.el.parentNode.removeChild(item.el);
			}
			powerups.splice(index, 1);
		}

		function tickPowers(delta) {
			let changed = false;
			Object.keys(activePowerTimers).forEach(function (key) {
				if (activePowerTimers[key] > 0) {
					activePowerTimers[key] = Math.max(0, activePowerTimers[key] - delta);
					changed = true;
				}
			});

			if (changed) {
				updatePowerClasses();
				updatePowerPills();
			}
		}

		function loop(timestamp) {
			if (!running || paused) {
				return;
			}

			if (!lastTime) {
				lastTime = timestamp;
			}

			const delta = (timestamp - lastTime) / 1000;
			lastTime = timestamp;

			const settings = getSettings();
			const slowFactor = activePowerTimers.slow > 0 ? 0.68 : 1;
			const turboBonus = activePowerTimers.turbo > 0 ? 68 : 0;

			speed += delta * settings.speedGain * (activePowerTimers.turbo > 0 ? 1.25 : 1);
			const moveSpeed = (speed + turboBonus) * slowFactor;

			spawnTimer += delta;
			coinTimer += delta;
			powerTimer += delta;

			tickPowers(delta);

			const spawnGap = Math.max(0.45, settings.spawnGap - score * 0.01);
			if (spawnTimer >= spawnGap) {
				spawnTimer = 0;
				spawnObstacle();
			}

			if (coinTimer >= settings.coinGap) {
				coinTimer = 0;
				spawnCoin();
			}

			if (powerTimer >= settings.powerGap) {
				powerTimer = 0;
				spawnPowerup();
			}

			const trackHeight = track.clientHeight;
			const playerTop = trackHeight - player.offsetHeight - 18;
			const playerBottom = playerTop + player.offsetHeight - 10;
			const playerCenterLaneX = lanePercents[laneIndex];

			for (let i = obstacles.length - 1; i >= 0; i -= 1) {
				const item = obstacles[i];
				item.y += moveSpeed * delta;
				item.el.style.top = item.y + 'px';

				const itemTop = item.y;
				const itemBottom = item.y + item.height;

				if (!item.passed && itemBottom >= playerTop && itemTop <= playerBottom && item.lane === laneIndex) {
					if (activePowerTimers.shield > 0) {
						consumeShield();
						if (item.el && item.el.parentNode) {
							item.el.parentNode.removeChild(item.el);
						}
						obstacles.splice(i, 1);
						continue;
					}
					endGame('Crash. Tap restart and try again.');
					return;
				}

				if (!item.passed && itemTop > playerBottom) {
					item.passed = true;
					score += activePowerTimers.turbo > 0 ? 2 : 1;
					if (score > bestScore) {
						bestScore = score;
					}
					updateHud();
				}

				if (itemTop > trackHeight + 120) {
					if (item.el && item.el.parentNode) {
						item.el.parentNode.removeChild(item.el);
					}
					obstacles.splice(i, 1);
				}
			}

			for (let i = coins.length - 1; i >= 0; i -= 1) {
				const item = coins[i];
				item.y += moveSpeed * delta;

				if (activePowerTimers.magnet > 0) {
					const targetLeft = playerCenterLaneX;
					const currentLeft = parseFloat(item.el.style.left);
					const nextLeft = currentLeft + (targetLeft - currentLeft) * Math.min(1, delta * 5.5);
					item.el.style.left = nextLeft + '%';
					item.lane = Math.abs(nextLeft - playerCenterLaneX) < 8 ? laneIndex : item.lane;
				}

				item.el.style.top = item.y + 'px';

				const itemTop = item.y;
				const itemBottom = item.y + item.height;
				if (intersectsLane(itemTop, itemBottom, item.lane) || (activePowerTimers.magnet > 0 && itemBottom >= playerTop && itemTop <= playerBottom)) {
					collectCoin(item, i);
					continue;
				}

				if (itemTop > trackHeight + 80) {
					if (item.el && item.el.parentNode) {
						item.el.parentNode.removeChild(item.el);
					}
					coins.splice(i, 1);
				}
			}

			for (let i = powerups.length - 1; i >= 0; i -= 1) {
				const item = powerups[i];
				item.y += moveSpeed * delta;
				item.el.style.top = item.y + 'px';

				const itemTop = item.y;
				const itemBottom = item.y + item.height;
				if (intersectsLane(itemTop, itemBottom, item.lane)) {
					collectPowerup(item, i);
					continue;
				}

				if (itemTop > trackHeight + 80) {
					if (item.el && item.el.parentNode) {
						item.el.parentNode.removeChild(item.el);
					}
					powerups.splice(i, 1);
				}
			}

			if (Math.random() < 0.02) {
				playMusicStep();
			}

			animationFrame = requestAnimationFrame(loop);
		}

		startBtn.addEventListener('click', function () {
			if (paused) {
				pauseGame();
				return;
			}
			startCountdown();
		});

		restartBtn.addEventListener('click', function () {
			resetGame();
		});

		pauseBtn.addEventListener('click', function () {
			if (!running && !paused) {
				return;
			}
			pauseGame();
		});

		leftBtn.addEventListener('click', function () {
			moveLeft();
		});

		rightBtn.addEventListener('click', function () {
			moveRight();
		});

		skinSelect.addEventListener('change', function () {
			updatePlayerSkin();
		});

		themeSelect.addEventListener('change', function () {
			applyTheme();
		});

		difficultySelect.addEventListener('change', function () {
			if (!running) {
				speed = getSettings().baseSpeed;
				updateHud();
			}
		});

		soundToggle.addEventListener('click', function () {
			soundEnabled = !soundEnabled;
			soundToggle.setAttribute('aria-pressed', soundEnabled ? 'true' : 'false');
			soundToggle.textContent = soundEnabled ? 'Sound On' : 'Sound Off';
			if (soundEnabled) {
				ensureAudio();
				playTone('go');
			}
		});

		game.addEventListener('keydown', function (event) {
			if (event.key === 'ArrowLeft') {
				event.preventDefault();
				moveLeft();
			} else if (event.key === 'ArrowRight') {
				event.preventDefault();
				moveRight();
			} else if (event.key === ' ' || event.key === 'Enter') {
				event.preventDefault();
				if (running || paused) {
					pauseGame();
				} else {
					startCountdown();
				}
			}
		});

		let touchStartX = 0;
		track.addEventListener('touchstart', function (event) {
			if (!event.changedTouches || !event.changedTouches.length) {
				return;
			}
			touchStartX = event.changedTouches[0].clientX;
		}, { passive: true });

		track.addEventListener('touchend', function (event) {
			if (!event.changedTouches || !event.changedTouches.length) {
				return;
			}
			const touchEndX = event.changedTouches[0].clientX;
			const diff = touchEndX - touchStartX;

			if (Math.abs(diff) < 20) {
				return;
			}

			if (diff < 0) {
				moveLeft();
			} else {
				moveRight();
			}
		}, { passive: true });

		track.addEventListener('click', function (event) {
			if (event.target.closest('.zo-car-overlay')) {
				return;
			}
			const rect = track.getBoundingClientRect();
			const x = event.clientX - rect.left;
			if (x < rect.width / 2) {
				moveLeft();
			} else {
				moveRight();
			}
		});

		game.setAttribute('tabindex', '0');
		updatePlayerSkin();
		applyTheme();
		setPlayerLane();
		updateHud();
		updatePowerPills();
		resetGame();
	});
});
JS;

if (!function_exists('zo_game_car_lane_switch_render')) {
	function zo_game_car_lane_switch_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-car-lane-switch-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--car-lane-switch" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-car-game" data-theme="city">
				<h2 class="zo-car-title">Car Lane Switch</h2>
				<p class="zo-car-instructions">Switch lanes to dodge traffic, collect coins, and grab power-ups. Use left and right buttons, arrow keys, tap left or right, or swipe on mobile.</p>

				<div class="zo-car-topbar">
					<select class="zo-car-select zo-car-skin" aria-label="Choose car skin">
						<option value="red">Red Car</option>
						<option value="blue">Blue Car</option>
						<option value="green">Green Car</option>
						<option value="purple">Purple Car</option>
					</select>

					<select class="zo-car-select zo-car-difficulty" aria-label="Choose difficulty">
						<option value="easy">Easy</option>
						<option value="medium" selected>Medium</option>
						<option value="hard">Hard</option>
					</select>

					<select class="zo-car-select zo-car-theme" aria-label="Choose road theme">
						<option value="city" selected>City</option>
						<option value="desert">Desert</option>
						<option value="snow">Snow</option>
						<option value="night">Night</option>
					</select>

					<button type="button" class="zo-car-btn zo-car-sound" aria-pressed="false">Sound Off</button>
				</div>

				<div class="zo-car-hud">
					<div class="zo-car-chip">
						<span class="zo-car-chip-label">Score</span>
						<span class="zo-car-chip-value zo-car-score">0</span>
					</div>
					<div class="zo-car-chip">
						<span class="zo-car-chip-label">Coins</span>
						<span class="zo-car-chip-value zo-car-coins">0</span>
					</div>
					<div class="zo-car-chip">
						<span class="zo-car-chip-label">Best</span>
						<span class="zo-car-chip-value zo-car-best">0</span>
					</div>
					<div class="zo-car-chip">
						<span class="zo-car-chip-label">Speed</span>
						<span class="zo-car-chip-value zo-car-speed">10</span>
					</div>
				</div>

				<div class="zo-car-track-wrap">
					<div class="zo-car-track">
						<div class="zo-car-grass-left" aria-hidden="true"></div>
						<div class="zo-car-road">
							<div class="zo-car-player" aria-hidden="true">🚗</div>
						</div>
						<div class="zo-car-grass-right" aria-hidden="true"></div>

						<div class="zo-car-overlay">
							<div class="zo-car-panel">
								<h3 class="zo-car-panel-title">Car Lane Switch</h3>
								<p class="zo-car-panel-text">Pick your car, difficulty, road theme, and sound. Then press Start.</p>
								<div class="zo-car-panel-countdown"></div>
								<div class="zo-car-buttons">
									<button type="button" class="zo-car-btn zo-car-btn--accent zo-car-start">Start</button>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="zo-car-controls">
					<button type="button" class="zo-car-control zo-car-left">⬅ Left</button>
					<button type="button" class="zo-car-control zo-car-right">Right ➡</button>
				</div>

				<div class="zo-car-buttons">
					<button type="button" class="zo-car-btn zo-car-pause" aria-pressed="false">Pause</button>
					<button type="button" class="zo-car-btn zo-car-restart">Restart</button>
				</div>

				<div class="zo-car-active-powers" aria-live="polite">
					<span class="zo-car-power-pill is-empty">No active power-ups</span>
				</div>

				<div class="zo-car-status" aria-live="polite">Choose your setup, then press Start.</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'car-lane-switch',
	'name'            => 'Car Lane Switch',
	'author'          => 'Asker',
	'description'     => 'A lane-switching driving game with coins, power-ups, themes, sound, and difficulty modes.',
	'render_callback' => 'zo_game_car_lane_switch_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);