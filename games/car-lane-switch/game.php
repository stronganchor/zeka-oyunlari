<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 980px;
	margin: 0 auto;
	font-family: inherit;
}

.zo-game-root--car-lane-switch .zo-car-game {
	position: relative;
	border-radius: 24px;
	overflow: hidden;
	background: linear-gradient(180deg, #f4b37d 0%, #f7d3b0 18%, #5b5f66 18%, #45484e 100%);
	box-shadow: 0 18px 38px rgba(0, 0, 0, 0.22);
	padding: 0;
}

.zo-game-root--car-lane-switch .zo-car-screen {
	position: relative;
	height: 680px;
	overflow: hidden;
	background:
		radial-gradient(circle at 50% 16%, rgba(255, 230, 165, 0.95) 0%, rgba(255, 206, 120, 0.65) 10%, rgba(255, 186, 120, 0.08) 24%, transparent 30%),
		linear-gradient(180deg, #8ea1c2 0%, #f3c3a0 17%, #f4bf8f 26%, #7f7c85 27%, #494d54 100%);
}

.zo-game-root--car-lane-switch .zo-car-game[data-theme="night"] .zo-car-screen {
	background:
		radial-gradient(circle at 50% 18%, rgba(255, 238, 170, 0.75) 0%, rgba(255, 216, 122, 0.25) 12%, rgba(255, 216, 122, 0.06) 22%, transparent 28%),
		linear-gradient(180deg, #111b33 0%, #2b3554 18%, #3d3f48 18%, #30333a 100%);
}

.zo-game-root--car-lane-switch .zo-car-game[data-theme="snow"] .zo-car-screen {
	background:
		radial-gradient(circle at 50% 16%, rgba(255, 244, 199, 0.85) 0%, rgba(255, 220, 165, 0.35) 12%, transparent 24%),
		linear-gradient(180deg, #b5d2e6 0%, #f5dcc6 18%, #7f8c98 18%, #59616c 100%);
}

.zo-game-root--car-lane-switch .zo-car-game[data-theme="desert"] .zo-car-screen {
	background:
		radial-gradient(circle at 50% 16%, rgba(255, 236, 160, 0.9) 0%, rgba(255, 208, 109, 0.45) 12%, transparent 24%),
		linear-gradient(180deg, #b6a5a1 0%, #f0c38e 18%, #76645b 18%, #5b4c45 100%);
}

.zo-game-root--car-lane-switch .zo-car-game[data-theme="mountain"] .zo-car-screen {
	background:
		radial-gradient(circle at 50% 16%, rgba(255, 235, 175, 0.9) 0%, rgba(255, 207, 125, 0.42) 12%, transparent 24%),
		linear-gradient(180deg, #92a7c6 0%, #f0c39f 18%, #6d7178 18%, #4c5158 100%);
}

.zo-game-root--car-lane-switch .zo-car-scene {
	position: absolute;
	inset: 0;
}

.zo-game-root--car-lane-switch .zo-car-skyline {
	position: absolute;
	left: 50%;
	bottom: 55%;
	transform: translateX(-50%);
	width: 48%;
	height: 13%;
	display: flex;
	align-items: flex-end;
	gap: 4px;
	opacity: 0.55;
}

.zo-game-root--car-lane-switch .zo-car-skyline-bar {
	flex: 1 1 auto;
	background: rgba(95, 83, 99, 0.55);
	border-radius: 4px 4px 0 0;
}

.zo-game-root--car-lane-switch .zo-car-horizon-hills {
	position: absolute;
	left: 0;
	right: 0;
	bottom: 54%;
	height: 15%;
	pointer-events: none;
}

.zo-game-root--car-lane-switch .zo-car-hill {
	position: absolute;
	bottom: 0;
	border-radius: 50% 50% 0 0;
	background: rgba(89, 74, 90, 0.38);
	filter: blur(1px);
}

.zo-game-root--car-lane-switch .zo-car-water {
	position: absolute;
	left: 0;
	right: 0;
	bottom: 52%;
	height: 4%;
	background: linear-gradient(180deg, rgba(114, 130, 167, 0.5) 0%, rgba(90, 98, 123, 0.18) 100%);
}

.zo-game-root--car-lane-switch .zo-car-palm {
	position: absolute;
	z-index: 2;
	width: 16px;
	height: 170px;
	transform-origin: bottom center;
	opacity: 0.9;
}

.zo-game-root--car-lane-switch .zo-car-palm::before {
	content: '';
	position: absolute;
	left: 6px;
	bottom: 0;
	width: 4px;
	height: 100%;
	background: linear-gradient(180deg, #4a372e 0%, #2f241f 100%);
	border-radius: 999px;
}

.zo-game-root--car-lane-switch .zo-car-palm::after {
	content: '';
	position: absolute;
	left: -36px;
	top: -6px;
	width: 88px;
	height: 88px;
	border-radius: 50%;
	background:
		conic-gradient(
			from 0deg,
			rgba(0, 0, 0, 0) 0deg,
			rgba(0, 0, 0, 0) 18deg,
			#263d2a 18deg,
			#263d2a 32deg,
			rgba(0, 0, 0, 0) 32deg,
			rgba(0, 0, 0, 0) 50deg,
			#2f4d36 50deg,
			#2f4d36 64deg,
			rgba(0, 0, 0, 0) 64deg,
			rgba(0, 0, 0, 0) 82deg,
			#29452f 82deg,
			#29452f 96deg,
			rgba(0, 0, 0, 0) 96deg,
			rgba(0, 0, 0, 0) 114deg,
			#35593d 114deg,
			#35593d 128deg,
			rgba(0, 0, 0, 0) 128deg,
			rgba(0, 0, 0, 0) 146deg,
			#2d4a33 146deg,
			#2d4a33 160deg,
			rgba(0, 0, 0, 0) 160deg,
			rgba(0, 0, 0, 0) 360deg
		);
	transform: rotate(12deg);
}

.zo-game-root--car-lane-switch .zo-car-road-perspective {
	position: absolute;
	left: 50%;
	bottom: 0;
	transform: translateX(-50%);
	width: 86%;
	height: 82%;
	clip-path: polygon(34% 0, 66% 0, 100% 100%, 0 100%);
	background: linear-gradient(180deg, #5a5d65 0%, #43464d 18%, #3f4248 100%);
	box-shadow: inset 0 0 0 2px rgba(255, 255, 255, 0.04);
}

.zo-game-root--car-lane-switch .zo-car-road-edge-left,
.zo-game-root--car-lane-switch .zo-car-road-edge-right {
	position: absolute;
	bottom: 0;
	height: 80%;
	width: 24%;
	background: linear-gradient(180deg, #867264 0%, #575e66 22%, #40454d 100%);
	z-index: 1;
}

.zo-game-root--car-lane-switch .zo-car-road-edge-left {
	left: 0;
	clip-path: polygon(100% 0, 100% 100%, 0 100%, 0 78%);
}

.zo-game-root--car-lane-switch .zo-car-road-edge-right {
	right: 0;
	clip-path: polygon(0 0, 100% 78%, 100% 100%, 0 100%);
}

.zo-game-root--car-lane-switch .zo-car-guard {
	position: absolute;
	height: 6px;
	background: linear-gradient(180deg, #b9b9bb 0%, #666 100%);
	border-radius: 999px;
	box-shadow: 0 2px 4px rgba(0, 0, 0, 0.18);
	z-index: 2;
}

.zo-game-root--car-lane-switch .zo-car-guard--left {
	left: 6%;
	bottom: 39%;
	width: 34%;
	transform: rotate(-15deg);
}

.zo-game-root--car-lane-switch .zo-car-guard--right {
	right: 6%;
	bottom: 39%;
	width: 34%;
	transform: rotate(15deg);
}

.zo-game-root--car-lane-switch .zo-car-road-lanes {
	position: absolute;
	inset: 0;
	z-index: 3;
}

.zo-game-root--car-lane-switch .zo-car-lane-line {
	position: absolute;
	top: 10%;
	bottom: 0;
	width: 1.5%;
	transform: translateX(-50%);
	background:
		repeating-linear-gradient(
			180deg,
			rgba(255, 255, 255, 0.96) 0 52px,
			transparent 52px 108px
		);
	filter: blur(0.2px);
	opacity: 0.95;
}

.zo-game-root--car-lane-switch .zo-car-lane-line--1 { left: 20%; }
.zo-game-root--car-lane-switch .zo-car-lane-line--2 { left: 40%; }
.zo-game-root--car-lane-switch .zo-car-lane-line--3 { left: 60%; }
.zo-game-root--car-lane-switch .zo-car-lane-line--4 { left: 80%; }

.zo-game-root--car-lane-switch .zo-car-sign-bridge {
	position: absolute;
	left: 50%;
	top: 18%;
	transform: translateX(-50%);
	width: 58%;
	height: 10px;
	background: #535252;
	border-radius: 999px;
	z-index: 4;
}

.zo-game-root--car-lane-switch .zo-car-sign-bridge::before,
.zo-game-root--car-lane-switch .zo-car-sign-bridge::after {
	content: '';
	position: absolute;
	top: 0;
	width: 8px;
	height: 120px;
	background: linear-gradient(180deg, #666 0%, #444 100%);
}

.zo-game-root--car-lane-switch .zo-car-sign-bridge::before { left: 0; }
.zo-game-root--car-lane-switch .zo-car-sign-bridge::after { right: 0; }

.zo-game-root--car-lane-switch .zo-car-sign {
	position: absolute;
	top: -16px;
	width: 24%;
	min-width: 110px;
	background: linear-gradient(180deg, #30694a 0%, #1d4d35 100%);
	color: #dbe9d7;
	border-radius: 10px;
	padding: 12px 10px;
	text-align: center;
	font-weight: 800;
	font-size: 14px;
	letter-spacing: 0.5px;
	box-shadow: inset 0 0 0 2px rgba(255, 255, 255, 0.12);
}

.zo-game-root--car-lane-switch .zo-car-sign--left { left: 17%; }
.zo-game-root--car-lane-switch .zo-car-sign--right { right: 17%; }

.zo-game-root--car-lane-switch .zo-car-sign-arrow {
	display: block;
	font-size: 18px;
	line-height: 1;
	margin-top: 6px;
}

.zo-game-root--car-lane-switch .zo-car-road {
	position: absolute;
	left: 50%;
	bottom: 0;
	transform: translateX(-50%);
	width: 70%;
	height: 82%;
	z-index: 8;
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
	width: 14%;
	max-width: 96px;
	min-width: 54px;
	aspect-ratio: 0.94 / 1.3;
	border-radius: 18px 18px 14px 14px;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 0;
}

.zo-game-root--car-lane-switch .zo-car-shell {
	position: absolute;
	inset: 0;
	border-radius: inherit;
	box-shadow: inset 0 0 0 3px rgba(255, 255, 255, 0.14), 0 12px 22px rgba(0, 0, 0, 0.22);
}

.zo-game-root--car-lane-switch .zo-car-player .zo-car-shell {
	background: linear-gradient(180deg, #ff5b57 0%, #c41414 100%);
}

.zo-game-root--car-lane-switch .zo-car-obstacle .zo-car-shell {
	background: linear-gradient(180deg, #4c81ff 0%, #2049bd 100%);
}

.zo-game-root--car-lane-switch .zo-car-obstacle--truck .zo-car-shell {
	background: linear-gradient(180deg, #f8a442 0%, #cf6500 100%);
}

.zo-game-root--car-lane-switch .zo-car-ghost .zo-car-shell {
	background: linear-gradient(180deg, #d8d8d8 0%, #7f7f7f 100%);
	box-shadow: inset 0 0 0 3px rgba(255, 255, 255, 0.12);
}

.zo-game-root--car-lane-switch .zo-car-window {
	position: absolute;
	left: 18%;
	right: 18%;
	top: 12%;
	height: 28%;
	border-radius: 16px 16px 14px 14px;
	background: linear-gradient(180deg, rgba(196, 232, 255, 0.95) 0%, rgba(82, 102, 128, 0.92) 100%);
}

.zo-game-root--car-lane-switch .zo-car-lightbar {
	position: absolute;
	left: 14%;
	right: 14%;
	bottom: 12%;
	height: 11%;
	border-radius: 999px;
	background: linear-gradient(180deg, rgba(255, 79, 68, 0.98) 0%, rgba(186, 18, 18, 1) 100%);
	box-shadow: 0 0 14px rgba(255, 65, 65, 0.8);
}

.zo-game-root--car-lane-switch .zo-car-player {
	bottom: 28px;
	z-index: 12;
	transition: left 0.18s ease, transform 0.18s ease, filter 0.18s ease;
}

.zo-game-root--car-lane-switch .zo-car-player.is-drifting {
	transition: left 0.1s ease, transform 0.1s ease, filter 0.18s ease;
}

.zo-game-root--car-lane-switch .zo-car-player.is-drift-left {
	transform: translateX(-50%) rotate(-9deg);
}

.zo-game-root--car-lane-switch .zo-car-player.is-drift-right {
	transform: translateX(-50%) rotate(9deg);
}

.zo-game-root--car-lane-switch .zo-car-player.is-powerup .zo-car-shell {
	box-shadow: 0 0 0 10px rgba(255, 214, 98, 0.18), inset 0 0 0 3px rgba(255, 255, 255, 0.14), 0 12px 22px rgba(0, 0, 0, 0.22);
}

.zo-game-root--car-lane-switch .zo-car-ghost {
	bottom: 28px;
	z-index: 7;
	opacity: 0.22;
	filter: grayscale(1);
	pointer-events: none;
}

.zo-game-root--car-lane-switch .zo-car-obstacle {
	top: -130px;
	z-index: 10;
}

.zo-game-root--car-lane-switch .zo-car-coin,
.zo-game-root--car-lane-switch .zo-car-powerup {
	z-index: 11;
	display: flex;
	align-items: center;
	justify-content: center;
}

.zo-game-root--car-lane-switch .zo-car-coin {
	width: 36px;
	height: 36px;
	border-radius: 50%;
	font-size: 24px;
	background: radial-gradient(circle at 35% 35%, #fff9c5 0%, #ffd95d 45%, #e0a700 100%);
	box-shadow: 0 6px 12px rgba(0, 0, 0, 0.18);
}

.zo-game-root--car-lane-switch .zo-car-powerup {
	width: 44px;
	height: 44px;
	border-radius: 50%;
	font-size: 22px;
	background: linear-gradient(180deg, rgba(255, 255, 255, 0.98) 0%, rgba(221, 243, 255, 0.96) 100%);
	box-shadow: 0 6px 14px rgba(0, 0, 0, 0.18);
	border: 3px solid rgba(255, 255, 255, 0.92);
}

.zo-game-root--car-lane-switch .zo-car-powerup--shield {
	box-shadow: 0 0 0 4px rgba(72, 178, 255, 0.18), 0 6px 14px rgba(0, 0, 0, 0.18);
}

.zo-game-root--car-lane-switch .zo-car-powerup--slow {
	box-shadow: 0 0 0 4px rgba(126, 222, 161, 0.18), 0 6px 14px rgba(0, 0, 0, 0.18);
}

.zo-game-root--car-lane-switch .zo-car-powerup--magnet {
	box-shadow: 0 0 0 4px rgba(255, 219, 77, 0.18), 0 6px 14px rgba(0, 0, 0, 0.18);
}

.zo-game-root--car-lane-switch .zo-car-powerup--turbo {
	box-shadow: 0 0 0 4px rgba(255, 140, 107, 0.18), 0 6px 14px rgba(0, 0, 0, 0.18);
}

.zo-game-root--car-lane-switch .zo-car-panel-stack {
	position: absolute;
	z-index: 20;
	display: flex;
	flex-direction: column;
	gap: 12px;
	top: 34px;
}

.zo-game-root--car-lane-switch .zo-car-panel-stack--left { left: 28px; }
.zo-game-root--car-lane-switch .zo-car-panel-stack--right {
	right: 28px;
	align-items: flex-end;
}

.zo-game-root--car-lane-switch .zo-car-hud-panel {
	position: relative;
	background: linear-gradient(180deg, rgba(19, 20, 24, 0.72) 0%, rgba(35, 36, 41, 0.62) 100%);
	backdrop-filter: blur(2px);
	color: #fff;
	padding: 14px 20px 14px 18px;
	min-width: 150px;
	box-shadow: 0 12px 22px rgba(0, 0, 0, 0.18);
	clip-path: polygon(0 0, 100% 0, 92% 100%, 0 100%);
}

.zo-game-root--car-lane-switch .zo-car-hud-panel--right {
	clip-path: polygon(8% 0, 100% 0, 100% 100%, 0 100%);
	padding: 14px 18px 14px 20px;
	text-align: right;
}

.zo-game-root--car-lane-switch .zo-car-hud-label {
	display: block;
	font-size: 14px;
	font-weight: 800;
	letter-spacing: 0.7px;
	text-transform: uppercase;
	opacity: 0.92;
}

.zo-game-root--car-lane-switch .zo-car-hud-value {
	display: block;
	margin-top: 3px;
	font-size: 36px;
	font-weight: 800;
	line-height: 1;
	letter-spacing: -0.5px;
}

.zo-game-root--car-lane-switch .zo-car-hud-sub {
	font-size: 14px;
	font-weight: 700;
	margin-left: 5px;
	opacity: 0.9;
}

.zo-game-root--car-lane-switch .zo-car-pause-top {
	position: absolute;
	right: 18px;
	top: 18px;
	z-index: 24;
	width: 58px;
	height: 58px;
	border: 0;
	border-radius: 14px;
	background: rgba(14, 16, 22, 0.6);
	backdrop-filter: blur(2px);
	color: #fff;
	font-size: 28px;
	font-weight: 900;
	line-height: 1;
	cursor: pointer;
	box-shadow: 0 10px 18px rgba(0, 0, 0, 0.2);
}

.zo-game-root--car-lane-switch .zo-car-bottom-controls {
	position: absolute;
	left: 0;
	right: 0;
	bottom: 18px;
	z-index: 21;
	display: flex;
	justify-content: space-between;
	align-items: flex-end;
	padding: 0 22px;
	pointer-events: none;
}

.zo-game-root--car-lane-switch .zo-car-controls-group,
.zo-game-root--car-lane-switch .zo-car-controls-group-right {
	display: flex;
	gap: 18px;
	pointer-events: auto;
}

.zo-game-root--car-lane-switch .zo-car-circle-btn {
	width: 120px;
	height: 120px;
	border-radius: 50%;
	border: 3px solid rgba(112, 210, 255, 0.65);
	background: radial-gradient(circle at 50% 35%, rgba(24, 50, 73, 0.48) 0%, rgba(16, 20, 30, 0.66) 68%, rgba(12, 18, 28, 0.78) 100%);
	color: #fff;
	font-size: 58px;
	font-weight: 800;
	cursor: pointer;
	box-shadow: 0 0 0 3px rgba(107, 211, 255, 0.08), 0 0 22px rgba(86, 200, 255, 0.34), inset 0 0 20px rgba(30, 111, 160, 0.16);
	display: flex;
	align-items: center;
	justify-content: center;
	line-height: 1;
}

.zo-game-root--car-lane-switch .zo-car-circle-btn:active {
	transform: scale(0.98);
}

.zo-game-root--car-lane-switch .zo-car-circle-btn--ability {
	font-size: 54px;
	color: #74d3ff;
	opacity: 0.42;
	border-color: rgba(112, 210, 255, 0.28);
	box-shadow: 0 0 0 3px rgba(107, 211, 255, 0.04), inset 0 0 20px rgba(30, 111, 160, 0.06);
}

.zo-game-root--car-lane-switch .zo-car-circle-btn--ability.is-ready {
	opacity: 1;
	border-color: rgba(112, 210, 255, 0.9);
	box-shadow: 0 0 0 3px rgba(107, 211, 255, 0.12), 0 0 28px rgba(86, 200, 255, 0.52), inset 0 0 20px rgba(30, 111, 160, 0.2);
}

.zo-game-root--car-lane-switch .zo-car-circle-btn--small {
	width: 106px;
	height: 106px;
	border-color: rgba(255, 255, 255, 0.24);
	box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.04), inset 0 0 20px rgba(255, 255, 255, 0.05);
	font-size: 46px;
	color: rgba(255, 255, 255, 0.88);
}

.zo-game-root--car-lane-switch .zo-car-middle-toolbar {
	position: relative;
	z-index: 23;
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	padding: 14px 16px 16px;
	background: linear-gradient(180deg, rgba(255, 255, 255, 0.96) 0%, rgba(244, 246, 248, 0.96) 100%);
	border-top: 1px solid rgba(0, 0, 0, 0.05);
}

.zo-game-root--car-lane-switch .zo-car-select,
.zo-game-root--car-lane-switch .zo-car-toolbar-btn {
	height: 42px;
	border: 0;
	border-radius: 12px;
	padding: 0 14px;
	font-size: 14px;
	font-weight: 700;
	background: #fff;
	color: #17324d;
	box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
	box-sizing: border-box;
}

.zo-game-root--car-lane-switch .zo-car-select {
	min-width: 135px;
}

.zo-game-root--car-lane-switch .zo-car-toolbar-btn {
	cursor: pointer;
}

.zo-game-root--car-lane-switch .zo-car-toolbar-btn[aria-pressed="true"] {
	background: #17324d;
	color: #fff;
}

.zo-game-root--car-lane-switch .zo-car-status-row {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	padding: 0 16px 16px;
	background: linear-gradient(180deg, rgba(244, 246, 248, 0.96) 0%, rgba(239, 242, 245, 0.96) 100%);
}

.zo-game-root--car-lane-switch .zo-car-status,
.zo-game-root--car-lane-switch .zo-car-active-powers,
.zo-game-root--car-lane-switch .zo-car-event-banner {
	flex: 1 1 100%;
	min-height: 22px;
	font-size: 14px;
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
}

.zo-game-root--car-lane-switch .zo-car-power-pill {
	background: #fff;
	color: #17324d;
	border-radius: 999px;
	padding: 7px 12px;
	font-size: 13px;
	font-weight: 700;
	box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
}

.zo-game-root--car-lane-switch .zo-car-power-pill.is-empty {
	opacity: 0.8;
}

.zo-game-root--car-lane-switch .zo-car-overlay {
	position: absolute;
	inset: 0;
	z-index: 30;
	display: flex;
	align-items: center;
	justify-content: center;
	background: rgba(10, 18, 28, 0.56);
	padding: 18px;
	box-sizing: border-box;
}

.zo-game-root--car-lane-switch .zo-car-overlay[hidden] {
	display: none;
}

.zo-game-root--car-lane-switch .zo-car-panel {
	width: 100%;
	max-width: 450px;
	background: #fff;
	border-radius: 22px;
	padding: 22px 18px;
	text-align: center;
	box-shadow: 0 18px 38px rgba(0, 0, 0, 0.26);
}

.zo-game-root--car-lane-switch .zo-car-panel-title {
	margin: 0 0 8px;
	font-size: 28px;
	color: #16304a;
}

.zo-game-root--car-lane-switch .zo-car-panel-text {
	margin: 0 0 14px;
	font-size: 15px;
	line-height: 1.5;
	color: #3e5568;
}

.zo-game-root--car-lane-switch .zo-car-panel-countdown {
	font-size: 58px;
	font-weight: 800;
	line-height: 1;
	color: #e44949;
	margin: 8px 0 14px;
	min-height: 58px;
}

.zo-game-root--car-lane-switch .zo-car-parent-box {
	margin-top: 14px;
	padding-top: 14px;
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
	box-shadow: 0 8px 16px rgba(23, 50, 77, 0.18);
}

.zo-game-root--car-lane-switch .zo-car-btn--accent {
	background: #e44949;
}

.zo-game-root--car-lane-switch .zo-car-btn--gold {
	background: #b98700;
}

@media (max-width: 900px) {
	.zo-game-root--car-lane-switch .zo-car-screen {
		height: 600px;
	}

	.zo-game-root--car-lane-switch .zo-car-circle-btn {
		width: 102px;
		height: 102px;
		font-size: 50px;
	}

	.zo-game-root--car-lane-switch .zo-car-circle-btn--small {
		width: 92px;
		height: 92px;
		font-size: 40px;
	}

	.zo-game-root--car-lane-switch .zo-car-hud-value {
		font-size: 30px;
	}
}

@media (max-width: 700px) {
	.zo-game-root--car-lane-switch .zo-car-screen {
		height: 520px;
	}

	.zo-game-root--car-lane-switch .zo-car-panel-stack {
		top: 16px;
		gap: 8px;
	}

	.zo-game-root--car-lane-switch .zo-car-panel-stack--left { left: 12px; }
	.zo-game-root--car-lane-switch .zo-car-panel-stack--right { right: 12px; }

	.zo-game-root--car-lane-switch .zo-car-hud-panel {
		min-width: 118px;
		padding: 10px 14px;
	}

	.zo-game-root--car-lane-switch .zo-car-hud-label {
		font-size: 11px;
	}

	.zo-game-root--car-lane-switch .zo-car-hud-value {
		font-size: 22px;
	}

	.zo-game-root--car-lane-switch .zo-car-hud-sub {
		font-size: 11px;
	}

	.zo-game-root--car-lane-switch .zo-car-pause-top {
		width: 48px;
		height: 48px;
		font-size: 22px;
		right: 10px;
		top: 10px;
	}

	.zo-game-root--car-lane-switch .zo-car-bottom-controls {
		padding: 0 10px;
		bottom: 10px;
	}

	.zo-game-root--car-lane-switch .zo-car-controls-group,
	.zo-game-root--car-lane-switch .zo-car-controls-group-right {
		gap: 10px;
	}

	.zo-game-root--car-lane-switch .zo-car-circle-btn {
		width: 78px;
		height: 78px;
		font-size: 38px;
		border-width: 2px;
	}

	.zo-game-root--car-lane-switch .zo-car-circle-btn--ability {
		font-size: 34px;
	}

	.zo-game-root--car-lane-switch .zo-car-circle-btn--small {
		width: 72px;
		height: 72px;
		font-size: 30px;
	}

	.zo-game-root--car-lane-switch .zo-car-middle-toolbar {
		padding: 12px;
	}

	.zo-game-root--car-lane-switch .zo-car-select,
	.zo-game-root--car-lane-switch .zo-car-toolbar-btn {
		min-width: 0;
		flex: 1 1 45%;
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
		const screen = game.querySelector('.zo-car-screen');
		const road = game.querySelector('.zo-car-road');
		const player = game.querySelector('.zo-car-player');
		const ghost = game.querySelector('.zo-car-ghost');
		const scoreValue = game.querySelector('.zo-car-score');
		const distanceValue = game.querySelector('.zo-car-distance');
		const streakValue = game.querySelector('.zo-car-streak');
		const speedValue = game.querySelector('.zo-car-speed');
		const coinValue = game.querySelector('.zo-car-coins');
		const heartValue = game.querySelector('.zo-car-hearts');
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
		const pauseBtn = game.querySelector('.zo-car-pause-top');
		const parentBtn = game.querySelector('.zo-car-parent');
		const resetScoresBtn = game.querySelector('.zo-car-reset-scores');
		const resetUnlocksBtn = game.querySelector('.zo-car-reset-unlocks');
		const closeParentBtn = game.querySelector('.zo-car-close-parent');
		const leftBtn = game.querySelector('.zo-car-left');
		const rightBtn = game.querySelector('.zo-car-right');
		const turboBtn = game.querySelector('.zo-car-turbo');
		const pauseBottomBtn = game.querySelector('.zo-car-pause-bottom');
		const skinSelect = game.querySelector('.zo-car-skin');
		const difficultySelect = game.querySelector('.zo-car-difficulty');
		const themeSelect = game.querySelector('.zo-car-theme');
		const languageSelect = game.querySelector('.zo-car-language');
		const soundToggle = game.querySelector('.zo-car-sound');
		const activePowers = game.querySelector('.zo-car-active-powers');
		const skyline = game.querySelector('.zo-car-skyline');
		const hills = game.querySelector('.zo-car-horizon-hills');
		const palms = game.querySelector('.zo-car-palms');

		const lanePercents = [10, 30, 50, 70, 90];
		const obstacleTypes = ['car', 'truck'];
		const powerTypes = ['shield', 'slow', 'magnet', 'turbo'];
		const storageKeys = {
			best: 'zo_car_lane_switch_best_v6',
			unlocks: 'zo_car_lane_switch_unlocks_v6',
			bestRun: 'zo_car_lane_switch_best_run_v6',
			totalCoins: 'zo_car_lane_switch_total_coins_v6'
		};

		const translations = {
			en: {
				title: 'Car Lane Switch',
				instructions: 'Use arrow keys or buttons. Five lanes. Turbo button lights only when turbo is ready.',
				skin: { red: 'Red Car', blue: 'Blue Car', green: 'Green Car', purple: 'Purple Car' },
				difficulty: { easy: 'Easy', medium: 'Medium', hard: 'Hard' },
				theme: { city: 'City', desert: 'Desert', snow: 'Snow', night: 'Night', mountain: 'Mountain' },
				language: { en: 'English', tr: 'Türkçe', de: 'Deutsch', es: 'Español' },
				soundOn: 'Sound On',
				soundOff: 'Sound Off',
				score: 'Score',
				distance: 'Distance',
				streak: 'Near Miss',
				speed: 'Speed',
				coins: 'Coins',
				lives: 'Lives',
				left: '◀',
				right: '▶',
				start: 'Start',
				playAgain: 'Play Again',
				restart: 'Restart',
				pause: 'Pause',
				resume: 'Resume',
				parent: 'Parent Menu',
				noPowerups: 'No saved power-ups',
				statusReady: 'Choose your setup, then press Start.',
				statusGo: 'Go. Dodge traffic and collect bonuses.',
				statusPaused: 'Paused.',
				statusResume: 'Back on the road.',
				statusCrash: 'Crash. You lost a life.',
				statusGameOver: 'Game over. Try again.',
				statusNearMiss: 'Near miss bonus.',
				statusPowerSaved: 'Power-up saved until all lives are gone.',
				statusTurboReady: 'Turbo ready. Press the lightning button.',
				statusTurboUsed: 'Turbo used. Side movement is faster for a short time.',
				statusResetScores: 'Scores reset.',
				statusResetUnlocks: 'Unlocks reset.',
				eventCoinRain: 'Event: Coin Rain',
				eventRoadwork: 'Event: Roadwork',
				getReady: 'Get Ready',
				countdownText: 'The race starts after the countdown.',
				overlaySetup: 'Higher camera view. Five lanes. Turbo is now a real use button.',
				pausedTitle: 'Paused',
				pausedText: 'Press Resume or pause again to continue.',
				parentTitle: 'Parent Menu',
				parentStats: 'Best score: {best} | Unlocked maps: {maps} | Total coins: {coins}',
				resetScores: 'Reset Scores',
				resetUnlocks: 'Reset Unlocks',
				close: 'Close',
				gameOverTitle: 'Game Over',
				gameOverText: 'Score: {score} | Coins: {coins} | Best: {best}',
				pills: {
					shield: '🛡 Shield',
					slow: '🐢 Slow',
					magnet: '🧲 Magnet',
					turbo: '⚡ Turbo Ready'
				},
				signLeft: 'DOWNTOWN',
				signRight: 'BEACH ROAD'
			},
			tr: {
				title: 'Araba Şerit Değiştir',
				instructions: 'Ok tuşları veya düğmelerle oynanır. Beş şerit. Turbo düğmesi sadece hazırken parlar.',
				skin: { red: 'Kırmızı Araba', blue: 'Mavi Araba', green: 'Yeşil Araba', purple: 'Mor Araba' },
				difficulty: { easy: 'Kolay', medium: 'Orta', hard: 'Zor' },
				theme: { city: 'Şehir', desert: 'Çöl', snow: 'Kar', night: 'Gece', mountain: 'Dağ' },
				language: { en: 'English', tr: 'Türkçe', de: 'Deutsch', es: 'Español' },
				soundOn: 'Ses Açık',
				soundOff: 'Ses Kapalı',
				score: 'Skor',
				distance: 'Mesafe',
				streak: 'Kıl Payı',
				speed: 'Hız',
				coins: 'Para',
				lives: 'Can',
				left: '◀',
				right: '▶',
				start: 'Başlat',
				playAgain: 'Tekrar Oyna',
				restart: 'Yeniden Başlat',
				pause: 'Duraklat',
				resume: 'Devam Et',
				parent: 'Ebeveyn Menüsü',
				noPowerups: 'Kayıtlı güç yok',
				statusReady: 'Ayarlarını seç, sonra Başlat’a bas.',
				statusGo: 'Başla. Trafikten kaç ve bonusları topla.',
				statusPaused: 'Duraklatıldı.',
				statusResume: 'Yola geri dönüldü.',
				statusCrash: 'Çarpıştın. Bir can gitti.',
				statusGameOver: 'Oyun bitti. Tekrar dene.',
				statusNearMiss: 'Kıl payı bonusu.',
				statusPowerSaved: 'Güç canlar bitene kadar saklanır.',
				statusTurboReady: 'Turbo hazır. Şimşek düğmesine bas.',
				statusTurboUsed: 'Turbo kullanıldı. Bir süre sağa sola daha hızlı gidersin.',
				statusResetScores: 'Skorlar sıfırlandı.',
				statusResetUnlocks: 'Kilitler sıfırlandı.',
				eventCoinRain: 'Etkinlik: Para Yağmuru',
				eventRoadwork: 'Etkinlik: Yol Çalışması',
				getReady: 'Hazır Ol',
				countdownText: 'Yarış geri sayımdan sonra başlar.',
				overlaySetup: 'Kamera daha yukarıda. Beş şerit var. Turbo artık gerçek bir kullanım düğmesi.',
				pausedTitle: 'Duraklatıldı',
				pausedText: 'Devam Et’e bas ya da tekrar duraklat.',
				parentTitle: 'Ebeveyn Menüsü',
				parentStats: 'En iyi skor: {best} | Açık harita: {maps} | Toplam para: {coins}',
				resetScores: 'Skorları Sıfırla',
				resetUnlocks: 'Kilitleri Sıfırla',
				close: 'Kapat',
				gameOverTitle: 'Oyun Bitti',
				gameOverText: 'Skor: {score} | Para: {coins} | En iyi: {best}',
				pills: {
					shield: '🛡 Kalkan',
					slow: '🐢 Yavaş',
					magnet: '🧲 Mıknatıs',
					turbo: '⚡ Turbo Hazır'
				},
				signLeft: 'MERKEZ',
				signRight: 'SAHİL YOLU'
			},
			de: {
				title: 'Auto Spurwechsel',
				instructions: 'Mit Pfeiltasten oder Knöpfen spielen. Fünf Spuren. Turbo leuchtet nur wenn es bereit ist.',
				skin: { red: 'Rotes Auto', blue: 'Blaues Auto', green: 'Grünes Auto', purple: 'Lila Auto' },
				difficulty: { easy: 'Leicht', medium: 'Mittel', hard: 'Schwer' },
				theme: { city: 'Stadt', desert: 'Wüste', snow: 'Schnee', night: 'Nacht', mountain: 'Berg' },
				language: { en: 'English', tr: 'Türkçe', de: 'Deutsch', es: 'Español' },
				soundOn: 'Ton An',
				soundOff: 'Ton Aus',
				score: 'Punkte',
				distance: 'Distanz',
				streak: 'Beinahe',
				speed: 'Tempo',
				coins: 'Münzen',
				lives: 'Leben',
				left: '◀',
				right: '▶',
				start: 'Start',
				playAgain: 'Nochmal',
				restart: 'Neu Start',
				pause: 'Pause',
				resume: 'Weiter',
				parent: 'Elternmenü',
				noPowerups: 'Keine gespeicherten Power-ups',
				statusReady: 'Wähle deine Einstellungen und drücke Start.',
				statusGo: 'Los. Weiche aus und sammle Boni.',
				statusPaused: 'Pausiert.',
				statusResume: 'Weiter geht’s.',
				statusCrash: 'Crash. Ein Leben verloren.',
				statusGameOver: 'Spiel vorbei. Versuch es erneut.',
				statusNearMiss: 'Beinahe-Unfall Bonus.',
				statusPowerSaved: 'Power-up bleibt bis alle Leben weg sind.',
				statusTurboReady: 'Turbo bereit. Drücke den Blitzknopf.',
				statusTurboUsed: 'Turbo benutzt. Seitliche Bewegung ist kurz schneller.',
				statusResetScores: 'Punkte zurückgesetzt.',
				statusResetUnlocks: 'Freischaltungen zurückgesetzt.',
				eventCoinRain: 'Event: Münzregen',
				eventRoadwork: 'Event: Baustelle',
				getReady: 'Bereit',
				countdownText: 'Das Rennen startet nach dem Countdown.',
				overlaySetup: 'Höhere Kamerasicht. Fünf Spuren. Turbo ist jetzt ein echter Knopf.',
				pausedTitle: 'Pausiert',
				pausedText: 'Drücke Weiter oder Pause erneut.',
				parentTitle: 'Elternmenü',
				parentStats: 'Bestwert: {best} | Freigeschaltete Karten: {maps} | Gesamtmünzen: {coins}',
				resetScores: 'Punkte Löschen',
				resetUnlocks: 'Freischaltungen Löschen',
				close: 'Schließen',
				gameOverTitle: 'Spiel Vorbei',
				gameOverText: 'Punkte: {score} | Münzen: {coins} | Bestwert: {best}',
				pills: {
					shield: '🛡 Schild',
					slow: '🐢 Langsam',
					magnet: '🧲 Magnet',
					turbo: '⚡ Turbo Bereit'
				},
				signLeft: 'INNENSTADT',
				signRight: 'STRANDSTRASSE'
			},
			es: {
				title: 'Cambio de Carril',
				instructions: 'Usa flechas o botones. Cinco carriles. Turbo solo se enciende cuando está listo.',
				skin: { red: 'Coche Rojo', blue: 'Coche Azul', green: 'Coche Verde', purple: 'Coche Morado' },
				difficulty: { easy: 'Fácil', medium: 'Medio', hard: 'Difícil' },
				theme: { city: 'Ciudad', desert: 'Desierto', snow: 'Nieve', night: 'Noche', mountain: 'Montaña' },
				language: { en: 'English', tr: 'Türkçe', de: 'Deutsch', es: 'Español' },
				soundOn: 'Sonido Sí',
				soundOff: 'Sonido No',
				score: 'Puntos',
				distance: 'Distancia',
				streak: 'Casi',
				speed: 'Velocidad',
				coins: 'Monedas',
				lives: 'Vidas',
				left: '◀',
				right: '▶',
				start: 'Empezar',
				playAgain: 'Otra Vez',
				restart: 'Reiniciar',
				pause: 'Pausa',
				resume: 'Seguir',
				parent: 'Menú Padres',
				noPowerups: 'Sin poderes guardados',
				statusReady: 'Elige tu configuración y pulsa Empezar.',
				statusGo: 'Vamos. Esquiva y recoge bonos.',
				statusPaused: 'En pausa.',
				statusResume: 'De nuevo en marcha.',
				statusCrash: 'Choque. Perdiste una vida.',
				statusGameOver: 'Fin del juego. Inténtalo otra vez.',
				statusNearMiss: 'Bono por casi chocar.',
				statusPowerSaved: 'El poder queda guardado hasta perder todas las vidas.',
				statusTurboReady: 'Turbo listo. Pulsa el botón del rayo.',
				statusTurboUsed: 'Turbo usado. El movimiento lateral es más rápido por un momento.',
				statusResetScores: 'Puntuaciones borradas.',
				statusResetUnlocks: 'Desbloqueos borrados.',
				eventCoinRain: 'Evento: Lluvia de Monedas',
				eventRoadwork: 'Evento: Obras',
				getReady: 'Prepárate',
				countdownText: 'La carrera empieza después de la cuenta atrás.',
				overlaySetup: 'Vista más alta. Cinco carriles. Turbo ahora es un botón real.',
				pausedTitle: 'En Pausa',
				pausedText: 'Pulsa Seguir o Pausa otra vez.',
				parentTitle: 'Menú Padres',
				parentStats: 'Mejor puntuación: {best} | Mapas desbloqueados: {maps} | Monedas totales: {coins}',
				resetScores: 'Borrar Puntos',
				resetUnlocks: 'Borrar Desbloqueos',
				close: 'Cerrar',
				gameOverTitle: 'Fin del Juego',
				gameOverText: 'Puntos: {score} | Monedas: {coins} | Mejor: {best}',
				pills: {
					shield: '🛡 Escudo',
					slow: '🐢 Lento',
					magnet: '🧲 Imán',
					turbo: '⚡ Turbo Listo'
				},
				signLeft: 'CENTRO',
				signRight: 'CAMINO PLAYA'
			}
		};

		const difficultySettings = {
			easy: {
				baseSpeed: 118,
				spawnGap: 1.95,
				speedGain: 1.2,
				coinGap: 1.0,
				powerGap: 6.6,
				sideMoveDuration: 0.22
			},
			medium: {
				baseSpeed: 138,
				spawnGap: 1.65,
				speedGain: 1.55,
				coinGap: 0.95,
				powerGap: 6.0,
				sideMoveDuration: 0.18
			},
			hard: {
				baseSpeed: 160,
				spawnGap: 1.38,
				speedGain: 1.9,
				coinGap: 0.9,
				powerGap: 5.5,
				sideMoveDuration: 0.16
			}
		};

		const skins = {
			red: { background: 'linear-gradient(180deg, #ff5b57 0%, #c41414 100%)' },
			blue: { background: 'linear-gradient(180deg, #4c81ff 0%, #2049bd 100%)' },
			green: { background: 'linear-gradient(180deg, #57d26a 0%, #138c2b 100%)' },
			purple: { background: 'linear-gradient(180deg, #b27bff 0%, #6630c8 100%)' }
		};

		const mapUnlockCosts = {
			city: 0,
			desert: 0,
			snow: 60,
			night: 120,
			mountain: 180
		};

		let bestScore = 0;
		let totalCoins = 0;
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
			totalCoins = parseInt(window.localStorage.getItem(storageKeys.totalCoins), 10) || 0;
		} catch (err) {
			totalCoins = 0;
		}

		try {
			const unlockRaw = window.localStorage.getItem(storageKeys.unlocks);
			if (unlockRaw) {
				unlocks = Object.assign(unlocks, JSON.parse(unlockRaw) || {});
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

		let laneIndex = 2;
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
		let distanceKm = 0;
		let nearMissCount = 0;
		let speed = difficultySettings.medium.baseSpeed;
		let countdownTimer = null;
		let soundEnabled = false;
		let audioContext = null;
		let lives = 10;
		let savedPowers = {
			shield: false,
			slow: false,
			magnet: false,
			turbo: false
		};
		let turboActiveTimer = 0;
		let eventState = {
			type: '',
			timer: 0,
			cooldown: 10
		};
		let driftTimer = 0;
		let currentRunPath = [];
		let runTime = 0;
		let currentSideMoveDuration = difficultySettings.medium.sideMoveDuration;

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

		function updateMoveDuration() {
			const base = getSettings().sideMoveDuration;
			currentSideMoveDuration = turboActiveTimer > 0 ? Math.max(0.08, base * 0.45) : base;
			player.style.transitionDuration = currentSideMoveDuration + 's, ' + currentSideMoveDuration + 's, 0.18s';
		}

		function updateTurboButton() {
			const isReady = savedPowers.turbo;
			turboBtn.classList.toggle('is-ready', !!isReady);
			turboBtn.disabled = !isReady;
			turboBtn.setAttribute('aria-pressed', turboActiveTimer > 0 ? 'true' : 'false');
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
			} else if (type === 'turbo') {
				frequency = 760;
				duration = 0.12;
				wave = 'sawtooth';
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

		function updateHud() {
			scoreValue.textContent = score.toLocaleString();
			distanceValue.textContent = distanceKm.toFixed(2) + ' km';
			streakValue.textContent = nearMissCount + ' s';
			speedValue.textContent = Math.round(speed).toLocaleString();
			coinValue.textContent = totalCoins.toLocaleString();
			heartValue.textContent = String(lives);
		}

		function updateCarShellColors() {
			const skin = skins[skinSelect.value] || skins.red;
			const playerShell = player.querySelector('.zo-car-shell');
			const ghostShell = ghost.querySelector('.zo-car-shell');
			if (playerShell) {
				playerShell.style.background = skin.background;
			}
			if (ghostShell) {
				ghostShell.style.background = 'linear-gradient(180deg, #d8d8d8 0%, #7f7f7f 100%)';
			}
		}

		function saveUnlocks() {
			try {
				window.localStorage.setItem(storageKeys.unlocks, JSON.stringify(unlocks));
			} catch (err) {}
		}

		function saveTotalCoins() {
			try {
				window.localStorage.setItem(storageKeys.totalCoins, String(totalCoins));
			} catch (err) {}
		}

		function unlockMapsByCoins() {
			Object.keys(mapUnlockCosts).forEach(function (mapName) {
				if (!unlocks[mapName] && totalCoins >= mapUnlockCosts[mapName]) {
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
			player.classList.toggle('is-powerup', hasSavedPower || turboActiveTimer > 0);
			updateMoveDuration();
			updateTurboButton();
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
				activePowers.textContent = '';
				const empty = document.createElement('span');
				empty.className = 'zo-car-power-pill is-empty';
				empty.textContent = t().noPowerups;
				activePowers.appendChild(empty);
				return;
			}

			activePowers.textContent = '';
			active.forEach(function (label) {
				const pill = document.createElement('span');
				pill.className = 'zo-car-power-pill';
				pill.textContent = label;
				activePowers.appendChild(pill);
			});
		}

		function setEventBanner(text) {
			eventBanner.textContent = text || '';
		}

		function setSavedPower(type) {
			savedPowers[type] = true;
			updatePowerClasses();
			updatePowerPills();

			if (type === 'turbo') {
				setStatus(t().statusTurboReady, false);
			} else {
				setStatus(t().statusPowerSaved, false);
			}

			playTone('power');
		}

		function clearSavedPowers() {
			savedPowers.shield = false;
			savedPowers.slow = false;
			savedPowers.magnet = false;
			savedPowers.turbo = false;
			turboActiveTimer = 0;
			updatePowerClasses();
			updatePowerPills();
		}

		function activateTurboNow() {
			if (!savedPowers.turbo) {
				return;
			}
			savedPowers.turbo = false;
			turboActiveTimer = 5;
			updatePowerClasses();
			updatePowerPills();
			setStatus(t().statusTurboUsed, false);
			playTone('turbo');
		}

		function getOpenLanes() {
			const blocked = {};
			obstacles.forEach(function (item) {
				if (item.y < 160) {
					blocked[item.lane] = true;
				}
			});
			const lanes = [];
			for (let i = 0; i < lanePercents.length; i += 1) {
				if (!blocked[i]) {
					lanes.push(i);
				}
			}
			if (!lanes.length) {
				lanes.push(Math.floor(Math.random() * lanePercents.length));
			}
			return lanes;
		}

		function createCarElement(extraClass) {
			const el = document.createElement('div');
			el.className = extraClass;
			el.innerHTML = '<span class="zo-car-shell"></span><span class="zo-car-window"></span><span class="zo-car-lightbar"></span>';
			return el;
		}

		function spawnObstacle() {
			const type = obstacleTypes[Math.floor(Math.random() * obstacleTypes.length)];
			const obstacle = createCarElement('zo-car-obstacle' + (type === 'truck' ? ' zo-car-obstacle--truck' : ''));
			const laneChoices = getOpenLanes();
			const lane = laneChoices[Math.floor(Math.random() * laneChoices.length)];
			obstacle.style.left = lanePercents[lane] + '%';
			obstacle.style.top = '-130px';
			road.appendChild(obstacle);

			obstacles.push({
				el: obstacle,
				lane: lane,
				y: -130,
				passed: false,
				nearBonusGiven: false,
				height: type === 'truck' ? 118 : 108,
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
				height: 36
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
				height: 44,
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
			eventState.cooldown = 10 + Math.random() * 6;
			setEventBanner('');
		}

		function updateEvent(delta) {
			eventState.cooldown = Math.max(0, eventState.cooldown - delta);

			if (!eventState.type) {
				if (Math.random() < 0.0015) {
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
			window.setTimeout(function () {
				updatePowerClasses();
			}, 180);
		}

		function endGame(message) {
			running = false;
			ended = true;
			paused = false;
			pauseBtn.textContent = '❚❚';
			pauseBottomBtn.textContent = t().pause;

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
					window.localStorage.setItem(storageKeys.best, String(bestScore));
				} catch (err) {}

				bestRun = {
					score: score,
					path: currentRunPath.slice(0, 800)
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
					score: score.toLocaleString(),
					coins: totalCoins.toLocaleString(),
					best: bestScore.toLocaleString()
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
				best: bestScore.toLocaleString(),
				maps: count,
				coins: totalCoins.toLocaleString()
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
			distanceKm = 0;
			nearMissCount = 0;
			lives = 10;
			laneIndex = 2;
			runTime = 0;
			currentRunPath = [{ time: 0, lane: laneIndex }];
			eventState.type = '';
			eventState.timer = 0;
			eventState.cooldown = 10;
			driftTimer = 0;
			turboActiveTimer = 0;

			speed = getSettings().baseSpeed;

			clearAllFalling();
			setPlayerLane();
			updateCarShellColors();
			applyTheme();
			updateHud();
			clearSavedPowers();
			pauseBtn.textContent = '❚❚';
			pauseBottomBtn.textContent = t().pause;
			setStatus(t().statusReady, false);
			setEventBanner('');
			showOverlay(t().title, t().overlaySetup, t().start, '');
			updateGhost(0);
			updateParentStats();
		}

		function reallyStartGame() {
			clearAllFalling();
			score = 0;
			distanceKm = 0;
			nearMissCount = 0;
			lives = 10;
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
			eventState.cooldown = 8 + Math.random() * 5;
			driftTimer = 0;
			laneIndex = 2;
			turboActiveTimer = 0;
			speed = getSettings().baseSpeed;

			setPlayerLane();
			updateCarShellColors();
			applyTheme();
			updateHud();
			updatePowerClasses();
			updatePowerPills();
			hideOverlay();
			pauseBtn.textContent = '❚❚';
			pauseBottomBtn.textContent = t().pause;
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

			updateCarShellColors();
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

		function setPauseButtonsPausedState() {
			pauseBtn.textContent = paused ? '▶' : '❚❚';
			pauseBottomBtn.textContent = paused ? t().resume : t().pause;
		}

		function pauseGame() {
			if (!running && !paused) {
				return;
			}
			paused = !paused;

			if (paused) {
				if (animationFrame) {
					cancelAnimationFrame(animationFrame);
					animationFrame = null;
				}
				setPauseButtonsPausedState();
				setStatus(t().statusPaused, false);
				showOverlay(t().pausedTitle, t().pausedText, t().resume, '');
				playTone('pause');
			} else {
				hideOverlay();
				lastTime = 0;
				setPauseButtonsPausedState();
				setStatus(t().statusResume, false);
				playTone('go');
				animationFrame = requestAnimationFrame(loop);
			}
		}

		function markLaneChange(direction) {
			driftTimer = 0.18;
			player.classList.add('is-drifting');
			player.classList.remove('is-drift-left', 'is-drift-right');
			player.classList.add(direction === 'left' ? 'is-drift-left' : 'is-drift-right');
			currentRunPath.push({
				time: runTime,
				lane: laneIndex
			});
			if (currentRunPath.length > 800) {
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
			laneIndex = Math.min(lanePercents.length - 1, laneIndex + 1);
			if (laneIndex !== oldLane) {
				setPlayerLane();
				markLaneChange('right');
			}
		}

		function intersectsLane(yTop, yBottom, lane) {
			const playerTop = road.clientHeight - player.offsetHeight - 28;
			const playerBottom = playerTop + player.offsetHeight - 10;
			return lane === laneIndex && yBottom >= playerTop && yTop <= playerBottom;
		}

		function collectCoin(item, index) {
			totalCoins += 1;
			score += 1;
			saveTotalCoins();
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
				nearMissCount += 1;
				if (score > bestScore) {
					bestScore = score;
				}
				updateHud();
				setStatus(t().statusNearMiss, false);
				playTone('near');
			}
		}

		function buildScenery() {
			skyline.innerHTML = '';
			hills.innerHTML = '';
			palms.innerHTML = '';

			for (let i = 0; i < 12; i += 1) {
				const bar = document.createElement('span');
				bar.className = 'zo-car-skyline-bar';
				bar.style.height = (18 + Math.random() * 70) + '%';
				skyline.appendChild(bar);
			}

			const hillData = [
				{ left: '-4%', width: '33%', height: '54%' },
				{ left: '20%', width: '38%', height: '65%' },
				{ left: '56%', width: '30%', height: '52%' },
				{ left: '74%', width: '28%', height: '45%' }
			];

			hillData.forEach(function (item) {
				const hill = document.createElement('span');
				hill.className = 'zo-car-hill';
				hill.style.left = item.left;
				hill.style.width = item.width;
				hill.style.height = item.height;
				hills.appendChild(hill);
			});

			const palmData = [
				{ left: '8%', bottom: '57%', scale: 0.95, rotate: -1 },
				{ left: '22%', bottom: '70%', scale: 0.45, rotate: 2 },
				{ left: '77%', bottom: '70%', scale: 0.45, rotate: -2 },
				{ left: '90%', bottom: '58%', scale: 1.08, rotate: 2 }
			];

			palmData.forEach(function (item) {
				const palm = document.createElement('span');
				palm.className = 'zo-car-palm';
				palm.style.left = item.left;
				palm.style.bottom = item.bottom;
				palm.style.transform = 'scale(' + item.scale + ') rotate(' + item.rotate + 'deg)';
				palms.appendChild(palm);
			});
		}

		function applyTranslations() {
			const dict = t();

			game.querySelector('.zo-car-sign-text--left').textContent = dict.signLeft;
			game.querySelector('.zo-car-sign-text--right').textContent = dict.signRight;

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

			game.querySelector('.zo-car-hud-label--score').textContent = dict.score;
			game.querySelector('.zo-car-hud-label--distance').textContent = dict.distance;
			game.querySelector('.zo-car-hud-label--streak').textContent = dict.streak;
			game.querySelector('.zo-car-hud-label--speed').textContent = dict.speed;
			game.querySelector('.zo-car-hud-label--coins').textContent = dict.coins;
			game.querySelector('.zo-car-hud-label--lives').textContent = dict.lives;

			leftBtn.textContent = dict.left;
			rightBtn.textContent = dict.right;
			pauseBottomBtn.textContent = paused ? dict.resume : dict.pause;
			restartBtn.textContent = dict.restart;
			parentBtn.textContent = dict.parent;
			startBtn.textContent = running ? dict.resume : dict.start;
			resetScoresBtn.textContent = dict.resetScores;
			resetUnlocksBtn.textContent = dict.resetUnlocks;
			closeParentBtn.textContent = dict.close;
			soundToggle.textContent = soundEnabled ? dict.soundOn : dict.soundOff;

			updateHud();
			updatePowerPills();
			updateParentStats();
			updateTurboButton();

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

			if (turboActiveTimer > 0) {
				turboActiveTimer = Math.max(0, turboActiveTimer - delta);
				if (turboActiveTimer === 0) {
					updatePowerClasses();
				}
			}

			const settings = getSettings();
			const slowFactor = savedPowers.slow ? 0.72 : 1;

			speed += delta * settings.speedGain;
			const moveSpeed = speed * slowFactor;

			spawnTimer += delta;
			coinTimer += delta;
			powerTimer += delta;
			distanceKm += (moveSpeed * delta) / 1000;

			let obstacleGap = Math.max(1.08, settings.spawnGap - score * 0.002);
			let coinGap = settings.coinGap;
			let powerGap = settings.powerGap;

			if (eventState.type === 'coin-rain') {
				coinGap = 0.34;
			}
			if (eventState.type === 'roadwork') {
				obstacleGap *= 0.86;
			}

			if (spawnTimer >= obstacleGap) {
				spawnTimer = 0;
				spawnObstacle();
				if (eventState.type === 'roadwork' && Math.random() < 0.22) {
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

			const roadHeight = road.clientHeight;
			const playerTop = roadHeight - player.offsetHeight - 28;
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
						if (item.el.parentNode) {
							item.el.parentNode.removeChild(item.el);
						}
						obstacles.splice(i, 1);
						setStatus(t().statusCrash, true);
						loseLife();
						continue;
					}

					if (item.el.parentNode) {
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
					score += 1;
					if (score > bestScore) {
						bestScore = score;
					}
					updateHud();
				}

				if (itemTop > roadHeight + 140) {
					if (item.el.parentNode) {
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
					const nextLeft = currentLeft + (targetLeft - currentLeft) * Math.min(1, delta * 4.0);
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

				if (itemTop > roadHeight + 90) {
					if (item.el.parentNode) {
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

				if (itemTop > roadHeight + 90) {
					if (item.el.parentNode) {
						item.el.parentNode.removeChild(item.el);
					}
					powerups.splice(i, 1);
				}
			}

			if (Math.random() < 0.012) {
				playMusicStep();
			}

			updateHud();
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
			pauseGame();
		});

		pauseBottomBtn.addEventListener('click', function () {
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
			totalCoins = 0;
			bestRun = null;
			try {
				window.localStorage.removeItem(storageKeys.best);
				window.localStorage.removeItem(storageKeys.bestRun);
				window.localStorage.removeItem(storageKeys.totalCoins);
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

		turboBtn.addEventListener('click', function () {
			activateTurboNow();
		});

		skinSelect.addEventListener('change', function () {
			updateCarShellColors();
		});

		themeSelect.addEventListener('change', function () {
			applyTheme();
		});

		difficultySelect.addEventListener('change', function () {
			if (!running) {
				speed = getSettings().baseSpeed;
				updateMoveDuration();
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
			} else if (event.key === 'ArrowUp') {
				event.preventDefault();
				activateTurboNow();
			} else if (event.key === ' ' || event.key === 'Enter') {
				event.preventDefault();
				if (running || paused) {
					pauseGame();
				} else {
					startCountdown();
				}
			} else if (event.key === 'p' || event.key === 'P') {
				event.preventDefault();
				pauseGame();
			}
		});

		let touchStartX = 0;
		screen.addEventListener('touchstart', function (event) {
			if (!event.changedTouches || !event.changedTouches.length) {
				return;
			}
			touchStartX = event.changedTouches[0].clientX;
		}, { passive: true });

		screen.addEventListener('touchend', function (event) {
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

		function initDecor() {
			buildScenery();
		}

		function initStaticCars() {
			player.innerHTML = '<span class="zo-car-shell"></span><span class="zo-car-window"></span><span class="zo-car-lightbar"></span>';
			ghost.innerHTML = '<span class="zo-car-shell"></span><span class="zo-car-window"></span><span class="zo-car-lightbar"></span>';
		}

		game.setAttribute('tabindex', '0');
		initStaticCars();
		initDecor();
		refreshThemeOptions();
		applyTheme();
		updateCarShellColors();
		setPlayerLane();
		updateMoveDuration();
		updateHud();
		updatePowerPills();
		updateTurboButton();
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
				<div class="zo-car-screen">
					<div class="zo-car-scene">
						<div class="zo-car-water" aria-hidden="true"></div>

						<div class="zo-car-horizon-hills" aria-hidden="true"></div>
						<div class="zo-car-skyline" aria-hidden="true"></div>
						<div class="zo-car-palms" aria-hidden="true"></div>

						<div class="zo-car-road-edge-left" aria-hidden="true"></div>
						<div class="zo-car-road-edge-right" aria-hidden="true"></div>
						<div class="zo-car-guard zo-car-guard--left" aria-hidden="true"></div>
						<div class="zo-car-guard zo-car-guard--right" aria-hidden="true"></div>

						<div class="zo-car-road-perspective" aria-hidden="true">
							<div class="zo-car-road-lanes">
								<div class="zo-car-lane-line zo-car-lane-line--1"></div>
								<div class="zo-car-lane-line zo-car-lane-line--2"></div>
								<div class="zo-car-lane-line zo-car-lane-line--3"></div>
								<div class="zo-car-lane-line zo-car-lane-line--4"></div>
							</div>
						</div>

						<div class="zo-car-sign-bridge" aria-hidden="true">
							<div class="zo-car-sign zo-car-sign--left">
								<span class="zo-car-sign-text zo-car-sign-text--left">DOWNTOWN</span>
								<span class="zo-car-sign-arrow">↓</span>
							</div>
							<div class="zo-car-sign zo-car-sign--right">
								<span class="zo-car-sign-text zo-car-sign-text--right">BEACH ROAD</span>
								<span class="zo-car-sign-arrow">↓</span>
							</div>
						</div>

						<div class="zo-car-road">
							<div class="zo-car-ghost" aria-hidden="true"></div>
							<div class="zo-car-player" aria-hidden="true"></div>
						</div>
					</div>

					<div class="zo-car-panel-stack zo-car-panel-stack--left">
						<div class="zo-car-hud-panel">
							<span class="zo-car-hud-label zo-car-hud-label--score">Score</span>
							<span class="zo-car-hud-value zo-car-score">0</span>
						</div>

						<div class="zo-car-hud-panel">
							<span class="zo-car-hud-label zo-car-hud-label--distance">Distance</span>
							<span class="zo-car-hud-value zo-car-distance">0.00 km</span>
						</div>

						<div class="zo-car-hud-panel">
							<span class="zo-car-hud-label zo-car-hud-label--streak">Near Miss</span>
							<span class="zo-car-hud-value zo-car-streak">0 s</span>
						</div>
					</div>

					<div class="zo-car-panel-stack zo-car-panel-stack--right">
						<div class="zo-car-hud-panel zo-car-hud-panel--right">
							<span class="zo-car-hud-label zo-car-hud-label--speed">Speed</span>
							<span class="zo-car-hud-value"><span class="zo-car-speed">0</span><span class="zo-car-hud-sub">KM/H</span></span>
						</div>

						<div class="zo-car-hud-panel zo-car-hud-panel--right">
							<span class="zo-car-hud-label zo-car-hud-label--coins">Coins</span>
							<span class="zo-car-hud-value zo-car-coins">0</span>
						</div>

						<div class="zo-car-hud-panel zo-car-hud-panel--right">
							<span class="zo-car-hud-label zo-car-hud-label--lives">Lives</span>
							<span class="zo-car-hud-value zo-car-hearts">10</span>
						</div>
					</div>

					<button type="button" class="zo-car-pause-top" aria-label="Pause game">❚❚</button>

					<div class="zo-car-bottom-controls">
						<div class="zo-car-controls-group">
							<button type="button" class="zo-car-circle-btn zo-car-left" aria-label="Move left">◀</button>
							<button type="button" class="zo-car-circle-btn zo-car-right" aria-label="Move right">▶</button>
						</div>

						<div class="zo-car-controls-group-right">
							<button type="button" class="zo-car-circle-btn zo-car-circle-btn--ability zo-car-turbo" aria-label="Use turbo" disabled>⚡</button>
							<button type="button" class="zo-car-circle-btn zo-car-circle-btn--small zo-car-pause-bottom" aria-label="Pause game">❚❚</button>
						</div>
					</div>

					<div class="zo-car-overlay">
						<div class="zo-car-panel">
							<h3 class="zo-car-panel-title">Car Lane Switch</h3>
							<p class="zo-car-panel-text">Higher camera view. Five lanes. Turbo is now a real use button.</p>
							<div class="zo-car-panel-countdown"></div>
							<div class="zo-car-buttons">
								<button type="button" class="zo-car-btn zo-car-btn--accent zo-car-start">Start</button>
							</div>

							<div class="zo-car-parent-box" hidden>
								<div class="zo-car-parent-stats">Best score: 0 | Unlocked maps: 2 | Total coins: 0</div>
								<div class="zo-car-buttons">
									<button type="button" class="zo-car-btn zo-car-reset-scores">Reset Scores</button>
									<button type="button" class="zo-car-btn zo-car-btn--gold zo-car-reset-unlocks">Reset Unlocks</button>
									<button type="button" class="zo-car-btn zo-car-close-parent">Close</button>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="zo-car-middle-toolbar">
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

					<button type="button" class="zo-car-toolbar-btn zo-car-sound" aria-pressed="false">Sound Off</button>
					<button type="button" class="zo-car-toolbar-btn zo-car-restart">Restart</button>
					<button type="button" class="zo-car-toolbar-btn zo-car-parent">Parent Menu</button>
				</div>

				<div class="zo-car-status-row">
					<div class="zo-car-status" aria-live="polite">Choose your setup, then press Start.</div>
					<div class="zo-car-active-powers" aria-live="polite">
						<span class="zo-car-power-pill is-empty">No saved power-ups</span>
					</div>
					<div class="zo-car-event-banner" aria-live="polite"></div>
				</div>
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
	'description'     => 'A slower lane-switching driving game with 5 lanes, a higher camera view, arrow keys, pause controls, and a real turbo-use button.',
	'render_callback' => 'zo_game_car_lane_switch_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
