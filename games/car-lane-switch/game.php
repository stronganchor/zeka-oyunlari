<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 700px;
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

.zo-game-root--car-lane-switch .zo-car-game[data-theme="mountain"] {
	background: linear-gradient(180deg, #cce7ff 0%, #eef7ff 38%, #7eb06f 38%, #5d8750 100%);
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
	background: rgba(255, 255, 255, 0.74);
	padding: 10px 12px;
	border-radius: 12px;
}

.zo-game-root--car-lane-switch .zo-car-topbar {
	display: grid;
	grid-template-columns: repeat(5, minmax(0, 1fr));
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
	display: grid;
	grid-template-columns: repeat(6, minmax(0, 1fr));
	gap: 10px;
	margin-bottom: 12px;
}

.zo-game-root--car-lane-switch .zo-car-chip {
	background: rgba(255, 255, 255, 0.9);
	border-radius: 12px;
	padding: 10px 8px;
	text-align: center;
	box-sizing: border-box;
	min-width: 0;
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

.zo-game-root--car-lane-switch .zo-car-hearts {
	letter-spacing: 2px;
}

.zo-game-root--car-lane-switch .zo-car-track-wrap {
	position: relative;
}

.zo-game-root--car-lane-switch .zo-car-track {
	position: relative;
	width: 100%;
	height: 500px;
	border-radius: 18px;
	overflow: hidden;
	background: linear-gradient(90deg, #4f4f4f 0%, #585858 8%, #4b4b4b 50%, #585858 92%, #4f4f4f 100%);
	box-shadow: inset 0 0 0 4px rgba(255, 255, 255, 0.08);
	touch-action: manipulation;
	user-select: none;
}

.zo-game-root--car-lane-switch .zo-car-game[data-theme="city"] .zo-car-track {
	background: linear-gradient(90deg, #4f4f4f 0%, #5a5a5a 8%, #4a4a4a 50%, #5a5a5a 92%, #4f4f4f 100%);
}

.zo-game-root--car-lane-switch .zo-car-game[data-theme="desert"] .zo-car-track {
	background: linear-gradient(90deg, #6f645b 0%, #786d64 8%, #675d55 50%, #786d64 92%, #6f645b 100%);
}

.zo-game-root--car-lane-switch .zo-car-game[data-theme="snow"] .zo-car-track {
	background: linear-gradient(90deg, #737b86 0%, #818a96 8%, #6d7580 50%, #818a96 92%, #737b86 100%);
}

.zo-game-root--car-lane-switch .zo-car-game[data-theme="night"] .zo-car-track {
	background: linear-gradient(90deg, #21252c 0%, #2b3039 8%, #1a1e25 50%, #2b3039 92%, #21252c 100%);
}

.zo-game-root--car-lane-switch .zo-car-game[data-theme="mountain"] .zo-car-track {
	background: linear-gradient(90deg, #585858 0%, #636363 8%, #515151 50%, #636363 92%, #585858 100%);
}

.zo-game-root--car-lane-switch .zo-car-bg {
	position: absolute;
	inset: 0;
	z-index: 1;
	pointer-events: none;
	overflow: hidden;
}

.zo-game-root--car-lane-switch .zo-car-sky-detail {
	position: absolute;
	top: 16px;
	left: 0;
	right: 0;
	height: 110px;
}

.zo-game-root--car-lane-switch .zo-car-cloud,
.zo-game-root--car-lane-switch .zo-car-light,
.zo-game-root--car-lane-switch .zo-car-tree,
.zo-game-root--car-lane-switch .zo-car-house,
.zo-game-root--car-lane-switch .zo-car-mountain {
	position: absolute;
}

.zo-game-root--car-lane-switch .zo-car-cloud {
	width: 80px;
	height: 28px;
	border-radius: 999px;
	background: rgba(255, 255, 255, 0.75);
	animation: zoCarCloudDrift 20s linear infinite;
}

.zo-game-root--car-lane-switch .zo-car-cloud::before,
.zo-game-root--car-lane-switch .zo-car-cloud::after {
	content: '';
	position: absolute;
	background: rgba(255, 255, 255, 0.75);
	border-radius: 999px;
}

.zo-game-root--car-lane-switch .zo-car-cloud::before {
	width: 28px;
	height: 28px;
	left: 10px;
	top: -10px;
}

.zo-game-root--car-lane-switch .zo-car-cloud::after {
	width: 34px;
	height: 34px;
	right: 12px;
	top: -13px;
}

.zo-game-root--car-lane-switch .zo-car-mountain {
	bottom: 0;
	width: 0;
	height: 0;
	border-left: 60px solid transparent;
	border-right: 60px solid transparent;
	border-bottom: 70px solid rgba(90, 120, 120, 0.42);
}

.zo-game-root--car-lane-switch .zo-car-house {
	bottom: 0;
	width: 34px;
	height: 26px;
	background: rgba(255, 255, 255, 0.7);
}

.zo-game-root--car-lane-switch .zo-car-house::before {
	content: '';
	position: absolute;
	left: -4px;
	right: -4px;
	top: -13px;
	border-left: 21px solid transparent;
	border-right: 21px solid transparent;
	border-bottom: 13px solid rgba(215, 97, 97, 0.88);
}

.zo-game-root--car-lane-switch .zo-car-tree {
	bottom: 0;
	width: 18px;
	height: 34px;
}

.zo-game-root--car-lane-switch .zo-car-tree::before {
	content: '';
	position: absolute;
	left: -10px;
	top: 0;
	width: 38px;
	height: 26px;
	background: rgba(56, 140, 64, 0.9);
	border-radius: 50%;
}

.zo-game-root--car-lane-switch .zo-car-tree::after {
	content: '';
	position: absolute;
	left: 7px;
	top: 18px;
	width: 4px;
	height: 16px;
	background: rgba(116, 78, 44, 0.9);
}

.zo-game-root--car-lane-switch .zo-car-light {
	bottom: 0;
	width: 4px;
	height: 34px;
	background: rgba(210, 210, 210, 0.9);
}

.zo-game-root--car-lane-switch .zo-car-light::before {
	content: '';
	position: absolute;
	top: -8px;
	left: -5px;
	width: 14px;
	height: 14px;
	border-radius: 50%;
	background: rgba(255, 237, 160, 0.95);
	box-shadow: 0 0 14px rgba(255, 237, 160, 0.9);
}

.zo-game-root--car-lane-switch .zo-car-side {
	position: absolute;
	top: 0;
	bottom: 0;
	width: 16%;
	z-index: 2;
	overflow: hidden;
}

.zo-game-root--car-lane-switch .zo-car-side--left {
	left: 0;
}

.zo-game-root--car-lane-switch .zo-car-side--right {
	right: 0;
}

.zo-game-root--car-lane-switch .zo-car-side-surface {
	position: absolute;
	inset: 0;
	background: repeating-linear-gradient(180deg, #68b74d 0px, #68b74d 24px, #5ca844 24px, #5ca844 48px);
}

.zo-game-root--car-lane-switch .zo-car-game[data-theme="city"] .zo-car-side-surface {
	background: repeating-linear-gradient(180deg, #89939f 0px, #89939f 24px, #7a858f 24px, #7a858f 48px);
}

.zo-game-root--car-lane-switch .zo-car-game[data-theme="desert"] .zo-car-side-surface {
	background: repeating-linear-gradient(180deg, #d7a867 0px, #d7a867 24px, #ca9755 24px, #ca9755 48px);
}

.zo-game-root--car-lane-switch .zo-car-game[data-theme="snow"] .zo-car-side-surface {
	background: repeating-linear-gradient(180deg, #f3f8fc 0px, #f3f8fc 24px, #e4edf4 24px, #e4edf4 48px);
}

.zo-game-root--car-lane-switch .zo-car-game[data-theme="night"] .zo-car-side-surface {
	background: repeating-linear-gradient(180deg, #1e3c2b 0px, #1e3c2b 24px, #173121 24px, #173121 48px);
}

.zo-game-root--car-lane-switch .zo-car-game[data-theme="mountain"] .zo-car-side-surface {
	background: repeating-linear-gradient(180deg, #6e975f 0px, #6e975f 24px, #618251 24px, #618251 48px);
}

.zo-game-root--car-lane-switch .zo-car-side-items {
	position: absolute;
	inset: 0;
}

.zo-game-root--car-lane-switch .zo-car-road {
	position: absolute;
	top: 0;
	bottom: 0;
	left: 16%;
	right: 16%;
	z-index: 3;
}

.zo-game-root--car-lane-switch .zo-car-road::before,
.zo-game-root--car-lane-switch .zo-car-road::after {
	content: '';
	position: absolute;
	top: 0;
	bottom: 0;
	width: 6px;
	background: repeating-linear-gradient(180deg, rgba(255, 255, 255, 0.85) 0px, rgba(255, 255, 255, 0.85) 26px, transparent 26px, transparent 52px);
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
.zo-game-root--car-lane-switch .zo-car-powerup,
.zo-game-root--car-lane-switch .zo-car-ghost {
	position: absolute;
	transform: translateX(-50%);
	will-change: top, left, transform;
}

.zo-game-root--car-lane-switch .zo-car-player,
.zo-game-root--car-lane-switch .zo-car-obstacle,
.zo-game-root--car-lane-switch .zo-car-ghost {
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
	z-index: 9;
	background: linear-gradient(180deg, #ff5757 0%, #d71f1f 100%);
	box-shadow: inset 0 0 0 3px rgba(255, 255, 255, 0.26), 0 8px 16px rgba(0, 0, 0, 0.22);
	transition: left 0.14s ease, transform 0.14s ease, filter 0.14s ease;
}

.zo-game-root--car-lane-switch .zo-car-player.is-drifting {
	transition: left 0.09s ease, transform 0.09s ease, filter 0.14s ease;
}

.zo-game-root--car-lane-switch .zo-car-player.is-drift-left {
	transform: translateX(-50%) rotate(-8deg);
}

.zo-game-root--car-lane-switch .zo-car-player.is-drift-right {
	transform: translateX(-50%) rotate(8deg);
}

.zo-game-root--car-lane-switch .zo-car-player.is-powerup {
	box-shadow: 0 0 0 8px rgba(255, 219, 77, 0.25), inset 0 0 0 3px rgba(255, 255, 255, 0.26), 0 8px 16px rgba(0, 0, 0, 0.22);
}

.zo-game-root--car-lane-switch .zo-car-player::before,
.zo-game-root--car-lane-switch .zo-car-obstacle::before,
.zo-game-root--car-lane-switch .zo-car-ghost::before {
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
.zo-game-root--car-lane-switch .zo-car-obstacle::after,
.zo-game-root--car-lane-switch .zo-car-ghost::after {
	content: '';
	position: absolute;
	bottom: 10%;
	left: 16%;
	right: 16%;
	height: 12%;
	border-radius: 10px;
	background: rgba(255, 225, 120, 0.92);
}

.zo-game-root--car-lane-switch .zo-car-ghost {
	bottom: 18px;
	z-index: 4;
	opacity: 0.25;
	pointer-events: none;
	filter: grayscale(1);
	background: linear-gradient(180deg, #d9d9d9 0%, #8b8b8b 100%);
	box-shadow: inset 0 0 0 3px rgba(255, 255, 255, 0.18);
}

.zo-game-root--car-lane-switch .zo-car-obstacle {
	top: -120px;
	z-index: 6;
	background: linear-gradient(180deg, #4b7dff 0%, #2248b5 100%);
	box-shadow: inset 0 0 0 3px rgba(255, 255, 255, 0.22), 0 8px 16px rgba(0, 0, 0, 0.2);
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
	z-index: 7;
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

.zo-game-root--car-lane-switch .zo-car-event-banner {
	margin: 10px 0 0;
	min-height: 26px;
	text-align: center;
	font-size: 14px;
	font-weight: 700;
	color: #17324d;
}

.zo-game-root--car-lane-switch .zo-car-overlay {
	position: absolute;
	inset: 0;
	z-index: 14;
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
	max-width: 420px;
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

.zo-game-root--car-lane-switch .zo-car-parent-box {
	margin-top: 14px;
	padding-top: 12px;
	border-top: 1px solid rgba(0, 0, 0, 0.08);
}

.zo-game-root--car-lane-switch .zo-car-parent-box[hidden] {
	display: none;
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

.zo-game-root--car-lane-switch .zo-car-btn--gold {
	background: #b98700;
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

.zo-game-root--car-lane-switch .zo-car-medal {
	font-size: 18px;
}

@keyframes zoCarCloudDrift {
	0% {
		transform: translateX(-120px);
	}
	100% {
		transform: translateX(820px);
	}
}

@media (max-width: 720px) {
	.zo-game-root--car-lane-switch .zo-car-topbar {
		grid-template-columns: repeat(2, minmax(0, 1fr));
	}

	.zo-game-root--car-lane-switch .zo-car-hud {
		grid-template-columns: repeat(3, minmax(0, 1fr));
	}

	.zo-game-root--car-lane-switch .zo-car-track {
		height: 430px;
	}

	.zo-game-root--car-lane-switch .zo-car-title {
		font-size: 24px;
	}

	.zo-game-root--car-lane-switch .zo-car-player,
	.zo-game-root--car-lane-switch .zo-car-obstacle,
	.zo-game-root--car-lane-switch .zo-car-ghost {
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
		const ghost = game.querySelector('.zo-car-ghost');
		const sideLeft = game.querySelector('.zo-car-side--left .zo-car-side-items');
		const sideRight = game.querySelector('.zo-car-side--right .zo-car-side-items');
		const skyDetail = game.querySelector('.zo-car-sky-detail');
		const scoreValue = game.querySelector('.zo-car-score');
		const bestValue = game.querySelector('.zo-car-best');
		const speedValue = game.querySelector('.zo-car-speed');
		const coinValue = game.querySelector('.zo-car-coins');
		const heartValue = game.querySelector('.zo-car-hearts');
		const medalValue = game.querySelector('.zo-car-medal');
		const mapValue = game.querySelector('.zo-car-map-name');
		const status = game.querySelector('.zo-car-status');
		const eventBanner = game.querySelector('.zo-car-event-banner');
		const overlay = game.querySelector('.zo-car-overlay');
		const overlayTitle = game.querySelector('.zo-car-panel-title');
		const overlayText = game.querySelector('.zo-car-panel-text');
		const countdownEl = game.querySelector('.zo-car-panel-countdown');
		const parentBox = game.querySelector('.zo-car-parent-box');
		const parentStats = game.querySelector('.zo-car-parent-stats');
		const startBtn = game.querySelector('.zo-car-start');
		const restartBtn = game.querySelector('.zo-car-restart');
		const pauseBtn = game.querySelector('.zo-car-pause');
		const parentBtn = game.querySelector('.zo-car-parent');
		const resetScoresBtn = game.querySelector('.zo-car-reset-scores');
		const resetUnlocksBtn = game.querySelector('.zo-car-reset-unlocks');
		const closeParentBtn = game.querySelector('.zo-car-close-parent');
		const leftBtn = game.querySelector('.zo-car-left');
		const rightBtn = game.querySelector('.zo-car-right');
		const skinSelect = game.querySelector('.zo-car-skin');
		const difficultySelect = game.querySelector('.zo-car-difficulty');
		const themeSelect = game.querySelector('.zo-car-theme');
		const languageSelect = game.querySelector('.zo-car-language');
		const soundToggle = game.querySelector('.zo-car-sound');
		const activePowers = game.querySelector('.zo-car-active-powers');

		const lanePercents = [16.66, 50, 83.33];
		const obstacleTypes = ['car', 'truck', 'oil'];
		const powerTypes = ['shield', 'slow', 'magnet', 'turbo'];
		const storageKeys = {
			best: 'zo_car_lane_switch_best_v3',
			unlocks: 'zo_car_lane_switch_unlocks_v3',
			bestRun: 'zo_car_lane_switch_best_run_v3'
		};

		const translations = {
			en: {
				title: 'Car Lane Switch',
				instructions: 'Switch lanes to dodge traffic, collect coins, and grab power-ups. Use buttons, arrow keys, tap left or right, or swipe on mobile.',
				skin: { red: 'Red Car', blue: 'Blue Car', green: 'Green Car', purple: 'Purple Car' },
				difficulty: { easy: 'Easy', medium: 'Medium', hard: 'Hard' },
				theme: { city: 'City', desert: 'Desert', snow: 'Snow', night: 'Night', mountain: 'Mountain' },
				language: { en: 'English', tr: 'Türkçe', de: 'Deutsch', es: 'Español' },
				soundOn: 'Sound On',
				soundOff: 'Sound Off',
				score: 'Score',
				coins: 'Coins',
				hearts: 'Lives',
				best: 'Best',
				speed: 'Speed',
				medal: 'Medal',
				map: 'Map',
				left: '⬅ Left',
				right: 'Right ➡',
				pause: 'Pause',
				resume: 'Resume',
				restart: 'Restart',
				parent: 'Parent Menu',
				start: 'Start',
				playAgain: 'Play Again',
				noPowerups: 'No saved power-ups',
				statusReady: 'Choose your setup, then press Start.',
				statusGo: 'Go. Dodge traffic and collect bonuses.',
				statusPaused: 'Paused.',
				statusResume: 'Back on the road.',
				statusCrash: 'Crash. You lost a life.',
				statusGameOver: 'Game over. Try again.',
				statusNearMiss: 'Near miss bonus.',
				statusPowerSaved: 'Power-up saved until your lives run out.',
				statusResetScores: 'Scores reset.',
				statusResetUnlocks: 'Unlocks reset.',
				eventNone: '',
				eventCoinRain: 'Event: Coin Rain',
				eventRoadwork: 'Event: Roadwork',
				getReady: 'Get Ready',
				countdownText: 'Lane switching starts after the countdown.',
				overlaySetup: 'Pick your car, difficulty, road theme, and language. Collect coins to unlock new maps.',
				pausedTitle: 'Paused',
				pausedText: 'Tap Resume or press Pause again to continue.',
				parentTitle: 'Parent Menu',
				parentStats: 'Best score: {best} | Unlocked maps: {maps}',
				resetScores: 'Reset Scores',
				resetUnlocks: 'Reset Unlocks',
				close: 'Close',
				gameOverTitle: 'Game Over',
				gameOverText: 'Score: {score} | Coins: {coins} | Best: {best} | Medal: {medal}',
				heartsDisplay: '❤'.repeat(3),
				medals: { none: 'None', bronze: 'Bronze', silver: 'Silver', gold: 'Gold' },
				pills: {
					shield: '🛡 Shield',
					slow: '🐢 Slow',
					magnet: '🧲 Magnet',
					turbo: '⚡ Turbo'
				}
			},
			tr: {
				title: 'Araba Şerit Değiştir',
				instructions: 'Trafikten kaçmak için şerit değiştir, para topla ve güçlendirmeleri al. Düğmeleri, ok tuşlarını, sola sağa dokunmayı ya da mobilde kaydırmayı kullan.',
				skin: { red: 'Kırmızı Araba', blue: 'Mavi Araba', green: 'Yeşil Araba', purple: 'Mor Araba' },
				difficulty: { easy: 'Kolay', medium: 'Orta', hard: 'Zor' },
				theme: { city: 'Şehir', desert: 'Çöl', snow: 'Kar', night: 'Gece', mountain: 'Dağ' },
				language: { en: 'English', tr: 'Türkçe', de: 'Deutsch', es: 'Español' },
				soundOn: 'Ses Açık',
				soundOff: 'Ses Kapalı',
				score: 'Skor',
				coins: 'Para',
				hearts: 'Can',
				best: 'En İyi',
				speed: 'Hız',
				medal: 'Madalya',
				map: 'Harita',
				left: '⬅ Sol',
				right: 'Sağ ➡',
				pause: 'Duraklat',
				resume: 'Devam Et',
				restart: 'Yeniden Başlat',
				parent: 'Ebeveyn Menüsü',
				start: 'Başlat',
				playAgain: 'Tekrar Oyna',
				noPowerups: 'Kayıtlı güç yok',
				statusReady: 'Ayarlarını seç, sonra Başlat’a bas.',
				statusGo: 'Başla. Trafikten kaç ve bonusları topla.',
				statusPaused: 'Duraklatıldı.',
				statusResume: 'Yola geri dönüldü.',
				statusCrash: 'Çarpıştın. Bir can gitti.',
				statusGameOver: 'Oyun bitti. Tekrar dene.',
				statusNearMiss: 'Kıl payı bonusu.',
				statusPowerSaved: 'Güçlendirme canların bitene kadar saklanır.',
				statusResetScores: 'Skorlar sıfırlandı.',
				statusResetUnlocks: 'Kilitler sıfırlandı.',
				eventNone: '',
				eventCoinRain: 'Etkinlik: Para Yağmuru',
				eventRoadwork: 'Etkinlik: Yol Çalışması',
				getReady: 'Hazır Ol',
				countdownText: 'Şerit değiştirme geri sayımdan sonra başlar.',
				overlaySetup: 'Arabayı, zorluğu, haritayı ve dili seç. Yeni haritaları açmak için para topla.',
				pausedTitle: 'Duraklatıldı',
				pausedText: 'Devam Et’e dokun ya da yeniden Duraklat düğmesine bas.',
				parentTitle: 'Ebeveyn Menüsü',
				parentStats: 'En iyi skor: {best} | Açık harita: {maps}',
				resetScores: 'Skorları Sıfırla',
				resetUnlocks: 'Kilitleri Sıfırla',
				close: 'Kapat',
				gameOverTitle: 'Oyun Bitti',
				gameOverText: 'Skor: {score} | Para: {coins} | En iyi: {best} | Madalya: {medal}',
				heartsDisplay: '❤'.repeat(3),
				medals: { none: 'Yok', bronze: 'Bronz', silver: 'Gümüş', gold: 'Altın' },
				pills: {
					shield: '🛡 Kalkan',
					slow: '🐢 Yavaş',
					magnet: '🧲 Mıknatıs',
					turbo: '⚡ Turbo'
				}
			},
			de: {
				title: 'Auto Spurwechsel',
				instructions: 'Wechsle die Spur, weiche dem Verkehr aus, sammle Münzen und hole Power-ups. Nutze Tasten, Pfeile, Tippen oder Wischen auf Mobilgeräten.',
				skin: { red: 'Rotes Auto', blue: 'Blaues Auto', green: 'Grünes Auto', purple: 'Lila Auto' },
				difficulty: { easy: 'Leicht', medium: 'Mittel', hard: 'Schwer' },
				theme: { city: 'Stadt', desert: 'Wüste', snow: 'Schnee', night: 'Nacht', mountain: 'Berg' },
				language: { en: 'English', tr: 'Türkçe', de: 'Deutsch', es: 'Español' },
				soundOn: 'Ton An',
				soundOff: 'Ton Aus',
				score: 'Punkte',
				coins: 'Münzen',
				hearts: 'Leben',
				best: 'Bestwert',
				speed: 'Tempo',
				medal: 'Medaille',
				map: 'Karte',
				left: '⬅ Links',
				right: 'Rechts ➡',
				pause: 'Pause',
				resume: 'Weiter',
				restart: 'Neu Start',
				parent: 'Elternmenü',
				start: 'Start',
				playAgain: 'Nochmal',
				noPowerups: 'Keine gespeicherten Power-ups',
				statusReady: 'Wähle deine Einstellungen und drücke Start.',
				statusGo: 'Los. Weiche aus und sammle Boni.',
				statusPaused: 'Pausiert.',
				statusResume: 'Weiter geht’s.',
				statusCrash: 'Crash. Ein Leben verloren.',
				statusGameOver: 'Spiel vorbei. Versuch es erneut.',
				statusNearMiss: 'Beinahe-Unfall Bonus.',
				statusPowerSaved: 'Power-up bleibt bis alle Leben weg sind.',
				statusResetScores: 'Punkte zurückgesetzt.',
				statusResetUnlocks: 'Freischaltungen zurückgesetzt.',
				eventNone: '',
				eventCoinRain: 'Event: Münzregen',
				eventRoadwork: 'Event: Baustelle',
				getReady: 'Bereit',
				countdownText: 'Der Spurwechsel startet nach dem Countdown.',
				overlaySetup: 'Wähle Auto, Schwierigkeit, Karte und Sprache. Sammle Münzen, um neue Karten freizuschalten.',
				pausedTitle: 'Pausiert',
				pausedText: 'Tippe auf Weiter oder drücke Pause erneut.',
				parentTitle: 'Elternmenü',
				parentStats: 'Bestwert: {best} | Freigeschaltete Karten: {maps}',
				resetScores: 'Punkte Löschen',
				resetUnlocks: 'Freischaltungen Löschen',
				close: 'Schließen',
				gameOverTitle: 'Spiel Vorbei',
				gameOverText: 'Punkte: {score} | Münzen: {coins} | Bestwert: {best} | Medaille: {medal}',
				heartsDisplay: '❤'.repeat(3),
				medals: { none: 'Keine', bronze: 'Bronze', silver: 'Silber', gold: 'Gold' },
				pills: {
					shield: '🛡 Schild',
					slow: '🐢 Langsam',
					magnet: '🧲 Magnet',
					turbo: '⚡ Turbo'
				}
			},
			es: {
				title: 'Cambio de Carril',
				instructions: 'Cambia de carril para esquivar el tráfico, recoge monedas y consigue poderes. Usa botones, flechas, tocar o deslizar en móvil.',
				skin: { red: 'Coche Rojo', blue: 'Coche Azul', green: 'Coche Verde', purple: 'Coche Morado' },
				difficulty: { easy: 'Fácil', medium: 'Medio', hard: 'Difícil' },
				theme: { city: 'Ciudad', desert: 'Desierto', snow: 'Nieve', night: 'Noche', mountain: 'Montaña' },
				language: { en: 'English', tr: 'Türkçe', de: 'Deutsch', es: 'Español' },
				soundOn: 'Sonido Sí',
				soundOff: 'Sonido No',
				score: 'Puntos',
				coins: 'Monedas',
				hearts: 'Vidas',
				best: 'Mejor',
				speed: 'Velocidad',
				medal: 'Medalla',
				map: 'Mapa',
				left: '⬅ Izq',
				right: 'Der ➡',
				pause: 'Pausa',
				resume: 'Seguir',
				restart: 'Reiniciar',
				parent: 'Menú Padres',
				start: 'Empezar',
				playAgain: 'Otra Vez',
				noPowerups: 'Sin poderes guardados',
				statusReady: 'Elige tu configuración y pulsa Empezar.',
				statusGo: 'Vamos. Esquiva y recoge bonos.',
				statusPaused: 'En pausa.',
				statusResume: 'De nuevo en marcha.',
				statusCrash: 'Choque. Perdiste una vida.',
				statusGameOver: 'Fin del juego. Inténtalo otra vez.',
				statusNearMiss: 'Bono por casi chocar.',
				statusPowerSaved: 'El poder se guarda hasta que se acaben tus vidas.',
				statusResetScores: 'Puntuaciones borradas.',
				statusResetUnlocks: 'Desbloqueos borrados.',
				eventNone: '',
				eventCoinRain: 'Evento: Lluvia de Monedas',
				eventRoadwork: 'Evento: Obras',
				getReady: 'Prepárate',
				countdownText: 'El cambio de carril empieza después de la cuenta atrás.',
				overlaySetup: 'Elige coche, dificultad, mapa e idioma. Recoge monedas para desbloquear nuevos mapas.',
				pausedTitle: 'En Pausa',
				pausedText: 'Pulsa Seguir o vuelve a pulsar Pausa.',
				parentTitle: 'Menú Padres',
				parentStats: 'Mejor puntuación: {best} | Mapas desbloqueados: {maps}',
				resetScores: 'Borrar Puntos',
				resetUnlocks: 'Borrar Desbloqueos',
				close: 'Cerrar',
				gameOverTitle: 'Fin del Juego',
				gameOverText: 'Puntos: {score} | Monedas: {coins} | Mejor: {best} | Medalla: {medal}',
				heartsDisplay: '❤'.repeat(3),
				medals: { none: 'Ninguna', bronze: 'Bronce', silver: 'Plata', gold: 'Oro' },
				pills: {
					shield: '🛡 Escudo',
					slow: '🐢 Lento',
					magnet: '🧲 Imán',
					turbo: '⚡ Turbo'
				}
			}
		};

		const difficultySettings = {
			easy: {
				baseSpeed: 220,
				spawnGap: 1.28,
				speedGain: 4.2,
				coinGap: 1.35,
				powerGap: 6.6
			},
			medium: {
				baseSpeed: 270,
				spawnGap: 1.05,
				speedGain: 6.0,
				coinGap: 1.15,
				powerGap: 5.8
			},
			hard: {
				baseSpeed: 330,
				spawnGap: 0.86,
				speedGain: 8.2,
				coinGap: 1.0,
				powerGap: 5.0
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
				ground: 'linear-gradient(180deg, #b07bff 0%, #6f38d0 100%)',
				background: 'linear-gradient(180deg, #b07bff 0%, #6f38d0 100%)'
			}
		};

		const mapUnlockCosts = {
			city: 0,
			desert: 0,
			snow: 60,
			night: 120,
			mountain: 180
		};

		let bestScore = 0;
		let unlocks = {
			city: true,
			desert: true,
			snow: false,
			night: false,
			mountain: false
		};
		let bestRun = null;

		try {
			bestScore = parseInt(window.localStorage.getItem(storageKeys.best), 10) || 0;
		} catch (err) {
			bestScore = 0;
		}

		try {
			const unlockRaw = window.localStorage.getItem(storageKeys.unlocks);
			if (unlockRaw) {
				const parsedUnlocks = JSON.parse(unlockRaw);
				unlocks = Object.assign(unlocks, parsedUnlocks || {});
			}
		} catch (err) {}

		try {
			const bestRunRaw = window.localStorage.getItem(storageKeys.bestRun);
			if (bestRunRaw) {
				bestRun = JSON.parse(bestRunRaw);
			}
		} catch (err) {
			bestRun = null;
		}

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
		let lives = 3;
		let savedPowers = {
			shield: false,
			slow: false,
			magnet: false,
			turbo: false
		};
		let eventState = {
			type: '',
			timer: 0,
			cooldown: 8
		};
		let driftTimer = 0;
		let driftDir = '';
		let nearMissActive = {};
		let currentRunPath = [];
		let runTime = 0;

		function t() {
			return translations[languageSelect.value] || translations.en;
		}

		function replaceTokens(text, replacements) {
			let result = text;
			Object.keys(replacements).forEach(function (key) {
				result = result.replace(new RegExp('\\{' + key + '\\}', 'g'), replacements[key]);
			});
			return result;
		}

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
			} else if (type === 'near') {
				frequency = 960;
				duration = 0.07;
				wave = 'triangle';
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

		function updateGhost(runSeconds) {
			if (!bestRun || !bestRun.path || !bestRun.path.length) {
				ghost.style.display = 'none';
				return;
			}

			ghost.style.display = 'flex';
			let lane = bestRun.path[0].lane;
			for (let i = 0; i < bestRun.path.length; i += 1) {
				if (bestRun.path[i].time <= runSeconds) {
					lane = bestRun.path[i].lane;
				} else {
					break;
				}
			}
			ghost.style.left = lanePercents[lane] + '%';
		}

		function setStatus(message, danger) {
			status.textContent = message;
			status.classList.toggle('is-danger', !!danger);
		}

		function getMedal(scoreValueNumber) {
			if (scoreValueNumber >= 80) {
				return 'gold';
			}
			if (scoreValueNumber >= 45) {
				return 'silver';
			}
			if (scoreValueNumber >= 20) {
				return 'bronze';
			}
			return 'none';
		}

		function updateHud() {
			scoreValue.textContent = String(score);
			coinValue.textContent = String(coinScore);
			speedValue.textContent = String(Math.round(speed / 26));
			bestValue.textContent = String(bestScore);
			heartValue.textContent = '❤'.repeat(Math.max(0, lives));
			const medalKey = getMedal(score);
			medalValue.textContent = t().medals[medalKey];
			mapValue.textContent = t().theme[themeSelect.value] || themeSelect.value;
		}

		function updateSkin() {
			const skin = skins[skinSelect.value] || skins.red;
			player.textContent = skin.emoji;
			player.style.background = skin.background;
			ghost.textContent = skin.emoji;
		}

		function saveUnlocks() {
			try {
				window.localStorage.setItem(storageKeys.unlocks, JSON.stringify(unlocks));
			} catch (err) {}
		}

		function unlockMapsByCoins() {
			Object.keys(mapUnlockCosts).forEach(function (mapName) {
				if (!unlocks[mapName] && coinScore >= mapUnlockCosts[mapName]) {
					unlocks[mapName] = true;
				}
			});
			saveUnlocks();
			refreshThemeOptions();
		}

		function refreshThemeOptions() {
			Array.prototype.forEach.call(themeSelect.options, function (option) {
				const value = option.value;
				const name = t().theme[value] || value;
				if (unlocks[value]) {
					option.textContent = name;
					option.disabled = false;
				} else {
					option.textContent = name + ' 🔒 ' + mapUnlockCosts[value];
					option.disabled = true;
				}
			});

			if (!unlocks[themeSelect.value]) {
				themeSelect.value = 'city';
			}
		}

		function applyTheme() {
			if (!unlocks[themeSelect.value]) {
				themeSelect.value = 'city';
			}
			gameWrap.setAttribute('data-theme', themeSelect.value);
			buildBackground();
			updateHud();
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
			parentBox.hidden = true;
		}

		function updatePowerClasses() {
			const hasSavedPower = savedPowers.shield || savedPowers.slow || savedPowers.magnet || savedPowers.turbo;
			player.classList.toggle('is-powerup', hasSavedPower);
		}

		function updatePowerPills() {
			const active = [];
			const labels = t().pills;

			if (savedPowers.shield) {
				active.push(labels.shield);
			}
			if (savedPowers.slow) {
				active.push(labels.slow);
			}
			if (savedPowers.magnet) {
				active.push(labels.magnet);
			}
			if (savedPowers.turbo) {
				active.push(labels.turbo);
			}

			if (!active.length) {
				activePowers.innerHTML = '<span class="zo-car-power-pill is-empty">' + t().noPowerups + '</span>';
				return;
			}

			activePowers.innerHTML = active.map(function (label) {
				return '<span class="zo-car-power-pill">' + label + '</span>';
			}).join('');
		}

		function setEventBanner(text) {
			eventBanner.textContent = text || '';
		}

		function setSavedPower(type) {
			savedPowers[type] = true;
			updatePowerClasses();
			updatePowerPills();
			setStatus(t().statusPowerSaved, false);
			playTone('power');
		}

		function clearSavedPowers() {
			savedPowers.shield = false;
			savedPowers.slow = false;
			savedPowers.magnet = false;
			savedPowers.turbo = false;
			updatePowerClasses();
			updatePowerPills();
		}

		function getOpenLanes() {
			const blocked = {};
			obstacles.forEach(function (item) {
				if (item.y < 120) {
					blocked[item.lane] = true;
				}
			});
			const lanes = [];
			for (let i = 0; i < 3; i += 1) {
				if (!blocked[i]) {
					lanes.push(i);
				}
			}
			if (!lanes.length) {
				lanes.push(Math.floor(Math.random() * 3));
			}
			return lanes;
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

			const laneChoices = getOpenLanes();
			const lane = laneChoices[Math.floor(Math.random() * laneChoices.length)];
			obstacle.style.left = lanePercents[lane] + '%';
			obstacle.style.top = '-90px';
			road.appendChild(obstacle);

			obstacles.push({
				el: obstacle,
				lane: lane,
				y: -90,
				passed: false,
				nearBonusGiven: false,
				height: type === 'oil' ? 52 : 86,
				type: type
			});
		}

		function spawnCoin() {
			const coin = document.createElement('div');
			coin.className = 'zo-car-coin';
			coin.textContent = '🪙';
			const laneChoices = getOpenLanes();
			const lane = laneChoices[Math.floor(Math.random() * laneChoices.length)];
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

			const laneChoices = getOpenLanes();
			const lane = laneChoices[Math.floor(Math.random() * laneChoices.length)];
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

		function maybeStartEvent() {
			if (eventState.type || eventState.cooldown > 0) {
				return;
			}
			const roll = Math.random();
			if (roll < 0.45) {
				eventState.type = 'coin-rain';
				eventState.timer = 4.2;
				setEventBanner(t().eventCoinRain);
			} else if (roll < 0.75) {
				eventState.type = 'roadwork';
				eventState.timer = 5.5;
				setEventBanner(t().eventRoadwork);
			}
		}

		function stopEvent() {
			eventState.type = '';
			eventState.timer = 0;
			eventState.cooldown = 8 + Math.random() * 6;
			setEventBanner('');
		}

		function updateEvent(delta) {
			eventState.cooldown = Math.max(0, eventState.cooldown - delta);

			if (!eventState.type) {
				if (Math.random() < 0.0025) {
					maybeStartEvent();
				}
				return;
			}

			eventState.timer -= delta;
			if (eventState.timer <= 0) {
				stopEvent();
			}
		}

		function loseLife() {
			lives -= 1;
			updateHud();
			playTone('crash');

			if (lives <= 0) {
				clearSavedPowers();
				endGame(t().statusGameOver);
				return;
			}

			setStatus(t().statusCrash, true);
			player.classList.add('is-powerup');
			window.setTimeout(function () {
				updatePowerClasses();
			}, 180);

			if (lives <= 0) {
				clearSavedPowers();
			}
		}

		function endGame(message) {
			running = false;
			ended = true;
			paused = false;
			pauseBtn.textContent = t().pause;
			pauseBtn.setAttribute('aria-pressed', 'false');

			if (countdownTimer) {
				window.clearTimeout(countdownTimer);
				countdownTimer = null;
			}

			if (animationFrame) {
				cancelAnimationFrame(animationFrame);
				animationFrame = null;
			}

			const medalKey = getMedal(score);

			if (score > bestScore) {
				bestScore = score;
				try {
					window.localStorage.setItem(storageKeys.best, String(bestScore));
				} catch (err) {}

				bestRun = {
					score: score,
					path: currentRunPath.slice(0, 600)
				};

				try {
					window.localStorage.setItem(storageKeys.bestRun, JSON.stringify(bestRun));
				} catch (err) {}
			}

			updateHud();
			updatePowerPills();
			updatePowerClasses();
			setStatus(message || t().statusGameOver, true);

			showOverlay(
				t().gameOverTitle,
				replaceTokens(t().gameOverText, {
					score: score,
					coins: coinScore,
					best: bestScore,
					medal: t().medals[medalKey]
				}),
				t().playAgain,
				''
			);

			updateParentStats();
		}

		function updateParentStats() {
			const count = Object.keys(unlocks).filter(function (key) {
				return unlocks[key];
			}).length;
			parentStats.textContent = replaceTokens(t().parentStats, {
				best: bestScore,
				maps: count
			});
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
			lives = 3;
			laneIndex = 1;
			runTime = 0;
			currentRunPath = [{ time: 0, lane: laneIndex }];
			eventState.type = '';
			eventState.timer = 0;
			eventState.cooldown = 6;
			driftTimer = 0;
			driftDir = '';

			const settings = getSettings();
			speed = settings.baseSpeed;

			clearAllFalling();
			setPlayerLane();
			updateSkin();
			applyTheme();
			updateHud();
			clearSavedPowers();
			pauseBtn.textContent = t().pause;
			pauseBtn.setAttribute('aria-pressed', 'false');
			setStatus(t().statusReady, false);
			setEventBanner('');
			showOverlay(t().title, t().overlaySetup, t().start, '');
			updateGhost(0);
			updateParentStats();
		}

		function reallyStartGame() {
			clearAllFalling();
			score = 0;
			coinScore = 0;
			lives = 3;
			spawnTimer = 0;
			coinTimer = 0;
			powerTimer = 0;
			lastTime = 0;
			runTime = 0;
			currentRunPath = [{ time: 0, lane: laneIndex }];
			running = true;
			ended = false;
			paused = false;
			eventState.type = '';
			eventState.timer = 0;
			eventState.cooldown = 5 + Math.random() * 4;
			driftTimer = 0;
			driftDir = '';
			laneIndex = 1;
			speed = getSettings().baseSpeed;

			setPlayerLane();
			updateSkin();
			applyTheme();
			updateHud();
			updatePowerClasses();
			updatePowerPills();
			hideOverlay();
			pauseBtn.textContent = t().pause;
			pauseBtn.setAttribute('aria-pressed', 'false');
			setStatus(t().statusGo, false);
			setEventBanner('');
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

			updateSkin();
			applyTheme();
			showOverlay(t().getReady, t().countdownText, t().start, '3');

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
				pauseBtn.textContent = t().resume;
				pauseBtn.setAttribute('aria-pressed', 'true');
				setStatus(t().statusPaused, false);
				showOverlay(t().pausedTitle, t().pausedText, t().resume, '');
				playTone('pause');
			} else {
				hideOverlay();
				lastTime = 0;
				pauseBtn.textContent = t().pause;
				pauseBtn.setAttribute('aria-pressed', 'false');
				setStatus(t().statusResume, false);
				playTone('go');
				animationFrame = requestAnimationFrame(loop);
			}
		}

		function markLaneChange(direction) {
			driftTimer = 0.18;
			driftDir = direction;
			player.classList.add('is-drifting');
			player.classList.remove('is-drift-left', 'is-drift-right');
			player.classList.add(direction === 'left' ? 'is-drift-left' : 'is-drift-right');
			currentRunPath.push({
				time: runTime,
				lane: laneIndex
			});
			if (currentRunPath.length > 600) {
				currentRunPath.shift();
			}
		}

		function moveLeft() {
			if (ended || countdownTimer) {
				return;
			}
			const oldLane = laneIndex;
			laneIndex = Math.max(0, laneIndex - 1);
			if (laneIndex !== oldLane) {
				setPlayerLane();
				markLaneChange('left');
			}
		}

		function moveRight() {
			if (ended || countdownTimer) {
				return;
			}
			const oldLane = laneIndex;
			laneIndex = Math.min(2, laneIndex + 1);
			if (laneIndex !== oldLane) {
				setPlayerLane();
				markLaneChange('right');
			}
		}

		function intersectsLane(yTop, yBottom, lane) {
			const playerTop = track.clientHeight - player.offsetHeight - 18;
			const playerBottom = playerTop + player.offsetHeight - 10;
			return lane === laneIndex && yBottom >= playerTop && yTop <= playerBottom;
		}

		function collectCoin(item, index) {
			coinScore += 1;
			score += savedPowers.turbo ? 2 : 1;
			unlockMapsByCoins();
			updateHud();
			playTone('coin');
			if (item.el && item.el.parentNode) {
				item.el.parentNode.removeChild(item.el);
			}
			coins.splice(index, 1);
		}

		function collectPowerup(item, index) {
			setSavedPower(item.type);
			if (item.el && item.el.parentNode) {
				item.el.parentNode.removeChild(item.el);
			}
			powerups.splice(index, 1);
		}

		function updateDrift(delta) {
			if (driftTimer > 0) {
				driftTimer -= delta;
				if (driftTimer <= 0) {
					player.classList.remove('is-drifting', 'is-drift-left', 'is-drift-right');
				}
			}
		}

		function checkNearMiss(item, playerTop, playerBottom) {
			if (item.nearBonusGiven) {
				return;
			}
			if (item.lane === laneIndex) {
				return;
			}

			const isAdjacent = Math.abs(item.lane - laneIndex) === 1;
			if (!isAdjacent) {
				return;
			}

			const itemTop = item.y;
			const itemBottom = item.y + item.height;
			const distance = Math.min(Math.abs(itemTop - playerBottom), Math.abs(itemBottom - playerTop));

			if (distance < 18 && itemBottom >= playerTop - 20 && itemTop <= playerBottom + 20) {
				item.nearBonusGiven = true;
				score += 2;
				if (score > bestScore) {
					bestScore = score;
				}
				updateHud();
				setStatus(t().statusNearMiss, false);
				playTone('near');
			}
		}

		function buildBackground() {
			skyDetail.innerHTML = '';
			sideLeft.innerHTML = '';
			sideRight.innerHTML = '';

			for (let i = 0; i < 3; i += 1) {
				const cloud = document.createElement('div');
				cloud.className = 'zo-car-cloud';
				cloud.style.top = (10 + i * 18) + 'px';
				cloud.style.left = (i * 140) + 'px';
				cloud.style.animationDelay = (i * -5) + 's';
				skyDetail.appendChild(cloud);
			}

			if (themeSelect.value === 'mountain') {
				for (let i = 0; i < 4; i += 1) {
					const mountain = document.createElement('div');
					mountain.className = 'zo-car-mountain';
					mountain.style.left = (i * 80 + 10) + 'px';
					mountain.style.borderLeftWidth = (50 + (i % 2) * 18) + 'px';
					mountain.style.borderRightWidth = (50 + (i % 2) * 18) + 'px';
					mountain.style.borderBottomWidth = (55 + i * 8) + 'px';
					skyDetail.appendChild(mountain);
				}
			}

			for (let i = 0; i < 7; i += 1) {
				const itemLeft = document.createElement('div');
				const itemRight = document.createElement('div');
				const mod = i % 3;

				if (themeSelect.value === 'city') {
					itemLeft.className = mod === 0 ? 'zo-car-house' : 'zo-car-light';
					itemRight.className = mod === 1 ? 'zo-car-house' : 'zo-car-light';
				} else if (themeSelect.value === 'desert') {
					itemLeft.className = mod === 0 ? 'zo-car-tree' : 'zo-car-light';
					itemRight.className = mod === 2 ? 'zo-car-tree' : 'zo-car-light';
				} else if (themeSelect.value === 'snow') {
					itemLeft.className = mod === 0 ? 'zo-car-tree' : 'zo-car-house';
					itemRight.className = mod === 1 ? 'zo-car-tree' : 'zo-car-house';
				} else if (themeSelect.value === 'night') {
					itemLeft.className = mod === 0 ? 'zo-car-light' : 'zo-car-house';
					itemRight.className = mod === 1 ? 'zo-car-light' : 'zo-car-house';
				} else {
					itemLeft.className = mod === 0 ? 'zo-car-tree' : 'zo-car-light';
					itemRight.className = mod === 1 ? 'zo-car-tree' : 'zo-car-light';
				}

				itemLeft.style.top = (i * 80 + 24) + 'px';
				itemRight.style.top = (i * 80 + 50) + 'px';
				itemLeft.style.left = (i % 2 === 0 ? 18 : 52) + 'px';
				itemRight.style.left = (i % 2 === 0 ? 40 : 14) + 'px';

				sideLeft.appendChild(itemLeft);
				sideRight.appendChild(itemRight);
			}
		}

		function applyTranslations() {
			const dict = t();

			game.querySelector('.zo-car-title').textContent = dict.title;
			game.querySelector('.zo-car-instructions').textContent = dict.instructions;

			Array.prototype.forEach.call(skinSelect.options, function (option) {
				option.textContent = dict.skin[option.value];
			});
			Array.prototype.forEach.call(difficultySelect.options, function (option) {
				option.textContent = dict.difficulty[option.value];
			});
			Array.prototype.forEach.call(languageSelect.options, function (option) {
				option.textContent = dict.language[option.value];
			});

			refreshThemeOptions();

			game.querySelector('.zo-car-chip-label--score').textContent = dict.score;
			game.querySelector('.zo-car-chip-label--coins').textContent = dict.coins;
			game.querySelector('.zo-car-chip-label--hearts').textContent = dict.hearts;
			game.querySelector('.zo-car-chip-label--best').textContent = dict.best;
			game.querySelector('.zo-car-chip-label--speed').textContent = dict.speed;
			game.querySelector('.zo-car-chip-label--medal').textContent = dict.medal;
			game.querySelector('.zo-car-chip-label--map').textContent = dict.map;

			leftBtn.textContent = dict.left;
			rightBtn.textContent = dict.right;
			pauseBtn.textContent = paused ? dict.resume : dict.pause;
			restartBtn.textContent = dict.restart;
			parentBtn.textContent = dict.parent;
			startBtn.textContent = running ? dict.resume : dict.start;
			resetScoresBtn.textContent = dict.resetScores;
			resetUnlocksBtn.textContent = dict.resetUnlocks;
			closeParentBtn.textContent = dict.close;

			updateHud();
			updatePowerPills();
			updateParentStats();

			if (!running && !paused && !ended) {
				setStatus(dict.statusReady, false);
				showOverlay(dict.title, dict.overlaySetup, dict.start, countdownEl.textContent);
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
			runTime += delta;

			updateGhost(runTime);
			updateDrift(delta);
			updateEvent(delta);

			const settings = getSettings();
			const slowFactor = savedPowers.slow ? 0.72 : 1;
			const turboBonus = savedPowers.turbo ? 68 : 0;

			speed += delta * settings.speedGain * (savedPowers.turbo ? 1.2 : 1);
			const moveSpeed = (speed + turboBonus) * slowFactor;

			spawnTimer += delta;
			coinTimer += delta;
			powerTimer += delta;

			let obstacleGap = Math.max(0.45, settings.spawnGap - score * 0.008);
			let coinGap = settings.coinGap;
			let powerGap = settings.powerGap;

			if (eventState.type === 'coin-rain') {
				coinGap = 0.35;
			}
			if (eventState.type === 'roadwork') {
				obstacleGap *= 0.72;
			}

			if (spawnTimer >= obstacleGap) {
				spawnTimer = 0;
				spawnObstacle();
				if (eventState.type === 'roadwork' && Math.random() < 0.5) {
					spawnObstacle();
				}
			}

			if (coinTimer >= coinGap) {
				coinTimer = 0;
				spawnCoin();
			}

			if (powerTimer >= powerGap) {
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

				checkNearMiss(item, playerTop, playerBottom);

				if (!item.passed && itemBottom >= playerTop && itemTop <= playerBottom && item.lane === laneIndex) {
					if (savedPowers.shield) {
						savedPowers.shield = false;
						updatePowerClasses();
						updatePowerPills();
						if (item.el && item.el.parentNode) {
							item.el.parentNode.removeChild(item.el);
						}
						obstacles.splice(i, 1);
						setStatus(t().statusCrash, true);
						loseLife();
						continue;
					}

					if (item.el && item.el.parentNode) {
						item.el.parentNode.removeChild(item.el);
					}
					obstacles.splice(i, 1);
					loseLife();

					if (!running) {
						return;
					}
					continue;
				}

				if (!item.passed && itemTop > playerBottom) {
					item.passed = true;
					score += savedPowers.turbo ? 2 : 1;
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

				if (savedPowers.magnet) {
					const targetLeft = playerCenterLaneX;
					const currentLeft = parseFloat(item.el.style.left);
					const nextLeft = currentLeft + (targetLeft - currentLeft) * Math.min(1, delta * 5.5);
					item.el.style.left = nextLeft + '%';
					item.lane = Math.abs(nextLeft - playerCenterLaneX) < 8 ? laneIndex : item.lane;
				}

				item.el.style.top = item.y + 'px';

				const itemTop = item.y;
				const itemBottom = item.y + item.height;
				if (intersectsLane(itemTop, itemBottom, item.lane) || (savedPowers.magnet && itemBottom >= playerTop && itemTop <= playerBottom)) {
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

		parentBtn.addEventListener('click', function () {
			showOverlay(t().parentTitle, '', t().close, '');
			parentBox.hidden = false;
			updateParentStats();
		});

		closeParentBtn.addEventListener('click', function () {
			parentBox.hidden = true;
			if (!running && !paused) {
				showOverlay(t().title, t().overlaySetup, t().start, '');
			} else if (paused) {
				showOverlay(t().pausedTitle, t().pausedText, t().resume, '');
			}
		});

		resetScoresBtn.addEventListener('click', function () {
			bestScore = 0;
			bestRun = null;
			try {
				window.localStorage.removeItem(storageKeys.best);
				window.localStorage.removeItem(storageKeys.bestRun);
			} catch (err) {}
			updateHud();
			updateParentStats();
			setStatus(t().statusResetScores, false);
		});

		resetUnlocksBtn.addEventListener('click', function () {
			unlocks = {
				city: true,
				desert: true,
				snow: false,
				night: false,
				mountain: false
			};
			saveUnlocks();
			refreshThemeOptions();
			themeSelect.value = 'city';
			applyTheme();
			updateParentStats();
			setStatus(t().statusResetUnlocks, false);
		});

		leftBtn.addEventListener('click', function () {
			moveLeft();
		});

		rightBtn.addEventListener('click', function () {
			moveRight();
		});

		skinSelect.addEventListener('change', function () {
			updateSkin();
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

		languageSelect.addEventListener('change', function () {
			applyTranslations();
		});

		soundToggle.addEventListener('click', function () {
			soundEnabled = !soundEnabled;
			soundToggle.setAttribute('aria-pressed', soundEnabled ? 'true' : 'false');
			soundToggle.textContent = soundEnabled ? t().soundOn : t().soundOff;
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
		updateSkin();
		refreshThemeOptions();
		applyTheme();
		setPlayerLane();
		updateHud();
		updatePowerPills();
		applyTranslations();
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
				<p class="zo-car-instructions">Switch lanes to dodge traffic, collect coins, and grab power-ups. Use buttons, arrow keys, tap left or right, or swipe on mobile.</p>

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
						<option value="mountain">Mountain</option>
					</select>

					<select class="zo-car-select zo-car-language" aria-label="Choose language">
						<option value="en" selected>English</option>
						<option value="tr">Türkçe</option>
						<option value="de">Deutsch</option>
						<option value="es">Español</option>
					</select>

					<button type="button" class="zo-car-btn zo-car-sound" aria-pressed="false">Sound Off</button>
				</div>

				<div class="zo-car-hud">
					<div class="zo-car-chip">
						<span class="zo-car-chip-label zo-car-chip-label--score">Score</span>
						<span class="zo-car-chip-value zo-car-score">0</span>
					</div>
					<div class="zo-car-chip">
						<span class="zo-car-chip-label zo-car-chip-label--coins">Coins</span>
						<span class="zo-car-chip-value zo-car-coins">0</span>
					</div>
					<div class="zo-car-chip">
						<span class="zo-car-chip-label zo-car-chip-label--hearts">Lives</span>
						<span class="zo-car-chip-value zo-car-hearts">❤❤❤</span>
					</div>
					<div class="zo-car-chip">
						<span class="zo-car-chip-label zo-car-chip-label--best">Best</span>
						<span class="zo-car-chip-value zo-car-best">0</span>
					</div>
					<div class="zo-car-chip">
						<span class="zo-car-chip-label zo-car-chip-label--speed">Speed</span>
						<span class="zo-car-chip-value zo-car-speed">10</span>
					</div>
					<div class="zo-car-chip">
						<span class="zo-car-chip-label zo-car-chip-label--medal">Medal</span>
						<span class="zo-car-chip-value zo-car-medal">None</span>
					</div>
				</div>

				<div class="zo-car-hud">
					<div class="zo-car-chip">
						<span class="zo-car-chip-label zo-car-chip-label--map">Map</span>
						<span class="zo-car-chip-value zo-car-map-name">City</span>
					</div>
				</div>

				<div class="zo-car-track-wrap">
					<div class="zo-car-track">
						<div class="zo-car-bg">
							<div class="zo-car-sky-detail"></div>
						</div>

						<div class="zo-car-side zo-car-side--left">
							<div class="zo-car-side-surface"></div>
							<div class="zo-car-side-items"></div>
						</div>

						<div class="zo-car-road">
							<div class="zo-car-ghost" aria-hidden="true">🚗</div>
							<div class="zo-car-player" aria-hidden="true">🚗</div>
						</div>

						<div class="zo-car-side zo-car-side--right">
							<div class="zo-car-side-surface"></div>
							<div class="zo-car-side-items"></div>
						</div>

						<div class="zo-car-overlay">
							<div class="zo-car-panel">
								<h3 class="zo-car-panel-title">Car Lane Switch</h3>
								<p class="zo-car-panel-text">Pick your car, difficulty, road theme, and language. Collect coins to unlock new maps.</p>
								<div class="zo-car-panel-countdown"></div>
								<div class="zo-car-buttons">
									<button type="button" class="zo-car-btn zo-car-btn--accent zo-car-start">Start</button>
								</div>

								<div class="zo-car-parent-box" hidden>
									<div class="zo-car-parent-stats">Best score: 0 | Unlocked maps: 2</div>
									<div class="zo-car-buttons">
										<button type="button" class="zo-car-btn zo-car-reset-scores">Reset Scores</button>
										<button type="button" class="zo-car-btn zo-car-btn--gold zo-car-reset-unlocks">Reset Unlocks</button>
										<button type="button" class="zo-car-btn zo-car-close-parent">Close</button>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="zo-car-event-banner" aria-live="polite"></div>
				</div>

				<div class="zo-car-controls">
					<button type="button" class="zo-car-control zo-car-left">⬅ Left</button>
					<button type="button" class="zo-car-control zo-car-right">Right ➡</button>
				</div>

				<div class="zo-car-buttons">
					<button type="button" class="zo-car-btn zo-car-pause" aria-pressed="false">Pause</button>
					<button type="button" class="zo-car-btn zo-car-restart">Restart</button>
					<button type="button" class="zo-car-btn zo-car-parent">Parent Menu</button>
				</div>

				<div class="zo-car-active-powers" aria-live="polite">
					<span class="zo-car-power-pill is-empty">No saved power-ups</span>
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
	'description'     => 'A lane-switching driving game with lives, languages, unlockable maps, ghost replay, medals, events, and saved power-ups.',
	'render_callback' => 'zo_game_car_lane_switch_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);