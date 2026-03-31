<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 1120px;
	margin: 0 auto;
	text-align: center;
}

.zo-game-root--mini-brawl-roster {
	font-family: Arial, sans-serif;
	background: linear-gradient(180deg, #1f2d45 0%, #172235 100%);
	color: #ffffff;
	border-radius: 18px;
	padding: 16px;
	box-sizing: border-box;
}

.zo-game-root--mini-brawl-roster * {
	box-sizing: border-box;
}

.zo-game-root--mini-brawl-roster .mbr-title {
	font-size: 30px;
	font-weight: 700;
	margin-bottom: 8px;
	color: #9ddbff;
}

.zo-game-root--mini-brawl-roster .mbr-instructions {
	font-size: 15px;
	line-height: 1.5;
	color: #d6e1f5;
	margin-bottom: 14px;
}

.zo-game-root--mini-brawl-roster .mbr-topbar {
	display: grid;
	grid-template-columns: repeat(7, minmax(0, 1fr));
	gap: 10px;
	margin-bottom: 14px;
}

.zo-game-root--mini-brawl-roster .mbr-stat {
	background: rgba(255,255,255,0.08);
	border: 1px solid rgba(255,255,255,0.12);
	border-radius: 14px;
	padding: 10px 12px;
	font-size: 15px;
	font-weight: 700;
}

.zo-game-root--mini-brawl-roster .mbr-row {
	display: flex;
	justify-content: center;
	gap: 10px;
	flex-wrap: wrap;
	margin-bottom: 14px;
}

.zo-game-root--mini-brawl-roster .mbr-difficulty-btn,
.zo-game-root--mini-brawl-roster .mbr-btn,
.zo-game-root--mini-brawl-roster .mbr-shop-btn {
	appearance: none;
	border: 1px solid #5d7cd1;
	background: #2c4f9e;
	color: #fff;
	border-radius: 12px;
	padding: 12px 16px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
}

.zo-game-root--mini-brawl-roster .mbr-difficulty-btn:hover,
.zo-game-root--mini-brawl-roster .mbr-difficulty-btn:focus,
.zo-game-root--mini-brawl-roster .mbr-btn:hover,
.zo-game-root--mini-brawl-roster .mbr-btn:focus,
.zo-game-root--mini-brawl-roster .mbr-shop-btn:hover,
.zo-game-root--mini-brawl-roster .mbr-shop-btn:focus {
	background: #3a63c2;
	outline: none;
}

.zo-game-root--mini-brawl-roster .mbr-difficulty-btn.is-active {
	background: #ffd84c;
	color: #1a1a1a;
	border-color: #ffd84c;
}

.zo-game-root--mini-brawl-roster .mbr-shop-btn[disabled],
.zo-game-root--mini-brawl-roster .mbr-btn[disabled] {
	opacity: 0.5;
	cursor: default;
}

.zo-game-root--mini-brawl-roster .mbr-panels {
	display: grid;
	grid-template-columns: 1.2fr 1fr;
	gap: 14px;
	margin-bottom: 14px;
	align-items: start;
}

.zo-game-root--mini-brawl-roster .mbr-panel {
	background: rgba(255,255,255,0.08);
	border: 1px solid rgba(255,255,255,0.12);
	border-radius: 16px;
	padding: 14px;
}

.zo-game-root--mini-brawl-roster .mbr-panel-title {
	font-size: 15px;
	font-weight: 700;
	color: #d8e4ff;
	margin-bottom: 10px;
	text-transform: uppercase;
	letter-spacing: 0.06em;
}

.zo-game-root--mini-brawl-roster .mbr-team-card {
	background: rgba(0,0,0,0.16);
	border: 1px solid rgba(255,255,255,0.10);
	border-radius: 14px;
	padding: 12px;
	text-align: left;
}

.zo-game-root--mini-brawl-roster .mbr-team-name {
	font-size: 22px;
	font-weight: 700;
	margin-bottom: 6px;
}

.zo-game-root--mini-brawl-roster .mbr-team-meta {
	font-size: 14px;
	line-height: 1.5;
	color: #d7e2f6;
}

.zo-game-root--mini-brawl-roster .mbr-roster-head {
	display: flex;
	gap: 10px;
	flex-wrap: wrap;
	margin-bottom: 10px;
}

.zo-game-root--mini-brawl-roster .mbr-input {
	flex: 1 1 180px;
	width: 100%;
	padding: 12px 14px;
	font-size: 15px;
	border: 1px solid #90a9e4;
	border-radius: 12px;
	background: #fff;
	color: #1a2240;
	outline: none;
}

.zo-game-root--mini-brawl-roster .mbr-input:focus {
	border-color: #4a73de;
	box-shadow: 0 0 0 3px rgba(74, 115, 222, 0.12);
}

.zo-game-root--mini-brawl-roster .mbr-roster-list {
	display: flex;
	flex-direction: column;
	gap: 8px;
	max-height: 360px;
	overflow-y: auto;
	padding-right: 4px;
}

.zo-game-root--mini-brawl-roster .mbr-roster-item {
	display: grid;
	grid-template-columns: 1fr auto;
	gap: 10px;
	align-items: center;
	background: rgba(0,0,0,0.16);
	border: 1px solid rgba(255,255,255,0.10);
	border-radius: 12px;
	padding: 10px 12px;
	text-align: left;
}

.zo-game-root--mini-brawl-roster .mbr-roster-name {
	font-size: 16px;
	font-weight: 700;
	margin-bottom: 4px;
}

.zo-game-root--mini-brawl-roster .mbr-roster-meta {
	font-size: 13px;
	line-height: 1.45;
	color: #d7e2f6;
}

.zo-game-root--mini-brawl-roster .mbr-roster-buy {
	min-width: 110px;
}

.zo-game-root--mini-brawl-roster .mbr-board-wrap {
	position: relative;
	width: 100%;
	max-width: 980px;
	margin: 0 auto 14px;
}

.zo-game-root--mini-brawl-roster .mbr-board {
	position: relative;
	width: 100%;
	aspect-ratio: 920 / 560;
	background: linear-gradient(180deg, #3e8c55 0%, #2f6d43 100%);
	border: 3px solid #274836;
	border-radius: 18px;
	overflow: hidden;
	touch-action: none;
	user-select: none;
}

.zo-game-root--mini-brawl-roster .mbr-bush {
	position: absolute;
	background: #2c8f45;
	border: 2px solid rgba(0,0,0,0.15);
	border-radius: 12px;
}

.zo-game-root--mini-brawl-roster .mbr-fighter,
.zo-game-root--mini-brawl-roster .mbr-shot,
.zo-game-root--mini-brawl-roster .mbr-pack {
	position: absolute;
}

.zo-game-root--mini-brawl-roster .mbr-fighter {
	border-radius: 50%;
	border: 3px solid rgba(255,255,255,0.65);
	box-shadow: inset 0 0 0 2px rgba(0,0,0,0.12);
}

.zo-game-root--mini-brawl-roster .mbr-fighter--player {
	background: #3a7bff;
}

.zo-game-root--mini-brawl-roster .mbr-fighter--enemy {
	background: #ff5757;
}

.zo-game-root--mini-brawl-roster .mbr-fighter-name {
	position: absolute;
	left: 50%;
	bottom: calc(100% + 6px);
	transform: translateX(-50%);
	font-size: 11px;
	font-weight: 700;
	color: #fff;
	white-space: nowrap;
	text-shadow: 0 1px 2px rgba(0,0,0,0.45);
}

.zo-game-root--mini-brawl-roster .mbr-fighter-hp {
	position: absolute;
	left: 50%;
	top: calc(100% + 6px);
	transform: translateX(-50%);
	width: 58px;
	height: 8px;
	background: rgba(0,0,0,0.35);
	border-radius: 999px;
	overflow: hidden;
}

.zo-game-root--mini-brawl-roster .mbr-fighter-hp-fill {
	height: 100%;
	background: #55e086;
}

.zo-game-root--mini-brawl-roster .mbr-shot {
	border-radius: 50%;
	background: #ffe15a;
}

.zo-game-root--mini-brawl-roster .mbr-pack {
	width: 26px;
	height: 26px;
	background: #9be7ff;
	border: 2px solid #1c5c74;
	border-radius: 8px;
	box-shadow: inset 0 0 0 2px rgba(255,255,255,0.2);
}

.zo-game-root--mini-brawl-roster .mbr-pack::before,
.zo-game-root--mini-brawl-roster .mbr-pack::after {
	content: '';
	position: absolute;
	background: #1c5c74;
}

.zo-game-root--mini-brawl-roster .mbr-pack::before {
	left: 50%;
	top: 4px;
	transform: translateX(-50%);
	width: 4px;
	height: 16px;
}

.zo-game-root--mini-brawl-roster .mbr-pack::after {
	top: 50%;
	left: 4px;
	transform: translateY(-50%);
	width: 16px;
	height: 4px;
}

.zo-game-root--mini-brawl-roster .mbr-overlay {
	position: absolute;
	inset: 0;
	display: flex;
	align-items: center;
	justify-content: center;
	padding: 20px;
	background: rgba(11, 19, 30, 0.5);
	z-index: 10;
}

.zo-game-root--mini-brawl-roster .mbr-overlay[hidden] {
	display: none;
}

.zo-game-root--mini-brawl-roster .mbr-panel-pop {
	background: rgba(20, 31, 48, 0.96);
	border: 1px solid rgba(255,255,255,0.14);
	border-radius: 18px;
	padding: 24px;
	max-width: 580px;
	width: 100%;
}

.zo-game-root--mini-brawl-roster .mbr-panel-pop-title {
	font-size: 32px;
	font-weight: 700;
	margin-bottom: 10px;
}

.zo-game-root--mini-brawl-roster .mbr-panel-pop-text {
	font-size: 16px;
	line-height: 1.55;
	color: #dce7fb;
	margin-bottom: 14px;
}

.zo-game-root--mini-brawl-roster .mbr-btn-row {
	display: flex;
	justify-content: center;
	gap: 10px;
	flex-wrap: wrap;
}

.zo-game-root--mini-brawl-roster .mbr-log {
	background: rgba(255,255,255,0.08);
	border: 1px solid rgba(255,255,255,0.12);
	border-radius: 14px;
	padding: 12px;
	font-size: 14px;
	line-height: 1.5;
	color: #e5eefc;
	min-height: 48px;
	margin-bottom: 12px;
}

.zo-game-root--mini-brawl-roster .mbr-mobile-controls {
	display: grid;
	grid-template-columns: repeat(3, 72px);
	grid-template-rows: repeat(2, 72px);
	gap: 8px;
	justify-content: center;
	margin-top: 12px;
}

.zo-game-root--mini-brawl-roster .mbr-move {
	appearance: none;
	border: 1px solid #4f648f;
	background: #233552;
	color: #fff;
	border-radius: 14px;
	font-size: 28px;
	font-weight: 700;
	cursor: pointer;
}

.zo-game-root--mini-brawl-roster .mbr-move:hover,
.zo-game-root--mini-brawl-roster .mbr-move:focus {
	background: #2f4870;
	outline: none;
}

.zo-game-root--mini-brawl-roster .mbr-move--up {
	grid-column: 2;
	grid-row: 1;
}

.zo-game-root--mini-brawl-roster .mbr-move--left {
	grid-column: 1;
	grid-row: 2;
}

.zo-game-root--mini-brawl-roster .mbr-move--down {
	grid-column: 2;
	grid-row: 2;
}

.zo-game-root--mini-brawl-roster .mbr-move--right {
	grid-column: 3;
	grid-row: 2;
}

.zo-game-root--mini-brawl-roster .mbr-controls {
	font-size: 14px;
	line-height: 1.5;
	color: #d6e1f5;
}

@media (max-width: 980px) {
	.zo-game-root--mini-brawl-roster .mbr-topbar {
		grid-template-columns: repeat(4, minmax(0, 1fr));
	}

	.zo-game-root--mini-brawl-roster .mbr-panels {
		grid-template-columns: 1fr;
	}
}

@media (max-width: 640px) {
	.zo-game-root--mini-brawl-roster .mbr-title {
		font-size: 26px;
	}

	.zo-game-root--mini-brawl-roster .mbr-topbar {
		grid-template-columns: repeat(2, minmax(0, 1fr));
	}

	.zo-game-root--mini-brawl-roster .mbr-panel-pop-title {
		font-size: 28px;
	}

	.zo-game-root--mini-brawl-roster .mbr-difficulty-btn,
	.zo-game-root--mini-brawl-roster .mbr-btn,
	.zo-game-root--mini-brawl-roster .mbr-shop-btn {
		width: 100%;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--mini-brawl-roster');

	games.forEach(function (game) {
		const CONFIG = {
			width: 920,
			height: 560,
			fighterSize: 32,
			baseEnemyCount: 4,
			shotSize: 8,
			shotSpeed: 360,
			packCount: 3,
			rosterCount: 1000
		};

		const difficultySettings = {
			kolay: { enemySpeed: 90, enemyDamage: 8, enemyFireDelay: 1.55, enemyAimRange: 240, levelScale: 0.09, label: 'Kolay', loseMoneyRate: 0.08 },
			orta:  { enemySpeed: 120, enemyDamage: 11, enemyFireDelay: 1.10, enemyAimRange: 300, levelScale: 0.13, label: 'Orta', loseMoneyRate: 0.12 },
			zor:   { enemySpeed: 150, enemyDamage: 15, enemyFireDelay: 0.80, enemyAimRange: 380, levelScale: 0.17, label: 'Zor', loseMoneyRate: 0.16 }
		};

		const bushes = [
			{ x: 100, y: 80, w: 120, h: 80 },
			{ x: 360, y: 60, w: 180, h: 90 },
			{ x: 700, y: 100, w: 110, h: 75 },
			{ x: 180, y: 300, w: 140, h: 90 },
			{ x: 470, y: 280, w: 120, h: 110 },
			{ x: 710, y: 330, w: 120, h: 80 }
		];

		const syllablesA = ['Bra', 'Ko', 'Za', 'Mi', 'Ta', 'Re', 'Lu', 'Va', 'Ni', 'Po', 'Ka', 'Su', 'Fi', 'Ro', 'Je', 'Xe', 'Do', 'Ga', 'Te', 'Hu'];
		const syllablesB = ['lon', 'tek', 'zar', 'mio', 'tan', 'rex', 'luna', 'vok', 'nix', 'pop', 'kra', 'sor', 'fex', 'rin', 'jax', 'xel', 'dor', 'gan', 'tor', 'hup'];

		const els = {
			board: game.querySelector('[data-role="board"]'),
			bushes: game.querySelector('[data-role="bushes"]'),
			packs: game.querySelector('[data-role="packs"]'),
			shots: game.querySelector('[data-role="shots"]'),
			fighters: game.querySelector('[data-role="fighters"]'),
			alive: game.querySelector('[data-role="alive"]'),
			hp: game.querySelector('[data-role="hp"]'),
			elims: game.querySelector('[data-role="elims"]'),
			diff: game.querySelector('[data-role="difficulty-label"]'),
			level: game.querySelector('[data-role="level"]'),
			money: game.querySelector('[data-role="money"]'),
			currentName: game.querySelector('[data-role="current-name"]'),
			currentCost: game.querySelector('[data-role="current-cost"]'),
			currentStats: game.querySelector('[data-role="current-stats"]'),
			log: game.querySelector('[data-role="log"]'),
			overlay: game.querySelector('[data-role="overlay"]'),
			overlayTitle: game.querySelector('[data-role="overlay-title"]'),
			overlayText: game.querySelector('[data-role="overlay-text"]'),
			startBtn: game.querySelector('[data-role="start-btn"]'),
			nextBtn: game.querySelector('[data-role="next-btn"]'),
			restartBtn: game.querySelector('[data-role="restart-btn"]'),
			diffBtns: game.querySelectorAll('[data-difficulty]'),
			moveBtns: game.querySelectorAll('[data-move]'),
			search: game.querySelector('[data-role="search"]'),
			rosterList: game.querySelector('[data-role="roster-list"]')
		};

		const state = {
			difficulty: 'orta',
			player: null,
			enemies: [],
			shots: [],
			packs: [],
			elims: 0,
			lastTime: 0,
			rafId: null,
			running: false,
			gameOver: false,
			levelCleared: false,
			level: 1,
			money: 40,
			keys: { up: false, down: false, left: false, right: false },
			log: 'Karakter seç ve başla.',
			roster: [],
			ownedIds: new Set([1]),
			selectedId: 1
		};

		function scaleX(value) {
			return (value / CONFIG.width) * 100;
		}

		function scaleY(value) {
			return (value / CONFIG.height) * 100;
		}

		function clamp(value, min, max) {
			return Math.max(min, Math.min(max, value));
		}

		function dist(ax, ay, bx, by) {
			const dx = bx - ax;
			const dy = by - ay;
			return Math.sqrt(dx * dx + dy * dy);
		}

		function randomRange(min, max) {
			return min + Math.random() * (max - min);
		}

		function circleHit(a, b, radiusA, radiusB) {
			return dist(a.x, a.y, b.x, b.y) <= radiusA + radiusB;
		}

		function spawnPoint(index) {
			const points = [
				{ x: 80, y: 80 },
				{ x: 840, y: 80 },
				{ x: 840, y: 470 },
				{ x: 80, y: 470 },
				{ x: 460, y: 500 },
				{ x: 460, y: 80 },
				{ x: 120, y: 260 },
				{ x: 800, y: 260 }
			];
			return points[index % points.length];
		}

		function makeRoster() {
			const roster = [];
			for (let i = 1; i <= CONFIG.rosterCount; i++) {
				const name = syllablesA[i % syllablesA.length] + syllablesB[(i * 3) % syllablesB.length] + ' #' + i;
				const cost = i === 1 ? 0 : Math.max(8, Math.floor(i * 1.8));
				const hp = 92 + Math.floor(cost * 1.5);
				const damage = 10 + Math.floor(cost * 0.26);
				const speed = 130 + Math.min(190, Math.floor(cost * 0.18));
				roster.push({
					id: i,
					name: name,
					cost: cost,
					hp: hp,
					damage: damage,
					speed: speed
				});
			}
			roster[0].name = 'Başlangıççı #1';
			roster[0].hp = 100;
			roster[0].damage = 18;
			roster[0].speed = 160;
			return roster;
		}

		function selectedBrawler() {
			return state.roster.find(function (r) { return r.id === state.selectedId; }) || state.roster[0];
		}

		function makeFighter(id, name, type, x, y, hp, damage, speed) {
			return {
				id: id,
				name: name,
				type: type,
				x: x,
				y: y,
				size: CONFIG.fighterSize,
				hp: hp,
				maxHp: hp,
				damage: damage,
				speed: speed,
				fireCooldown: 0,
				wanderX: x,
				wanderY: y,
				wanderTimer: 0,
				alive: true
			};
		}

		function updateDifficultyButtons() {
			els.diffBtns.forEach(function (btn) {
				const value = btn.getAttribute('data-difficulty');
				btn.classList.toggle('is-active', value === state.difficulty);
			});
		}

		function showOverlay(title, text, mode) {
			els.overlayTitle.textContent = title;
			els.overlayText.textContent = text;
			els.startBtn.hidden = mode !== 'start';
			els.nextBtn.hidden = mode !== 'next';
			els.restartBtn.hidden = mode === 'start';
			els.overlay.hidden = false;
		}

		function hideOverlay() {
			els.overlay.hidden = true;
		}

		function updateHud() {
			const aliveEnemies = state.enemies.filter(function (e) { return e.alive; }).length;
			const aliveTotal = (state.player && state.player.alive ? 1 : 0) + aliveEnemies;
			const current = selectedBrawler();

			els.alive.textContent = String(aliveTotal);
			els.hp.textContent = state.player ? String(Math.max(0, Math.round(state.player.hp))) + ' / ' + String(state.player.maxHp) : current.hp + ' / ' + current.hp;
			els.elims.textContent = String(state.elims);
			els.diff.textContent = difficultySettings[state.difficulty].label;
			els.level.textContent = String(state.level);
			els.money.textContent = String(state.money);
			els.currentName.textContent = current.name;
			els.currentCost.textContent = current.cost === 0 ? 'Başlangıç' : String(current.cost);
			els.currentStats.textContent = 'HP ' + current.hp + ' • Güç ' + current.damage + ' • Hız ' + current.speed;
			els.log.textContent = state.log;
		}

		function renderBushes() {
			els.bushes.innerHTML = '';
			bushes.forEach(function (b) {
				const el = document.createElement('div');
				el.className = 'mbr-bush';
				el.style.left = scaleX(b.x) + '%';
				el.style.top = scaleY(b.y) + '%';
				el.style.width = scaleX(b.w) + '%';
				el.style.height = scaleY(b.h) + '%';
				els.bushes.appendChild(el);
			});
		}

		function renderPacks() {
			els.packs.innerHTML = '';
			state.packs.forEach(function (pack) {
				if (pack.used) return;
				const el = document.createElement('div');
				el.className = 'mbr-pack';
				el.style.left = scaleX(pack.x - 13) + '%';
				el.style.top = scaleY(pack.y - 13) + '%';
				els.packs.appendChild(el);
			});
		}

		function renderShots() {
			els.shots.innerHTML = '';
			state.shots.forEach(function (shot) {
				const el = document.createElement('div');
				el.className = 'mbr-shot';
				el.style.left = scaleX(shot.x - CONFIG.shotSize / 2) + '%';
				el.style.top = scaleY(shot.y - CONFIG.shotSize / 2) + '%';
				el.style.width = scaleX(CONFIG.shotSize) + '%';
				el.style.height = scaleY(CONFIG.shotSize) + '%';
				els.shots.appendChild(el);
			});
		}

		function fighterEl(fighter) {
			const wrap = document.createElement('div');
			wrap.className = 'mbr-fighter mbr-fighter--' + fighter.type;
			wrap.style.left = scaleX(fighter.x - fighter.size / 2) + '%';
			wrap.style.top = scaleY(fighter.y - fighter.size / 2) + '%';
			wrap.style.width = scaleX(fighter.size) + '%';
			wrap.style.height = scaleY(fighter.size) + '%';

			const name = document.createElement('div');
			name.className = 'mbr-fighter-name';
			name.textContent = fighter.name;
			wrap.appendChild(name);

			const hp = document.createElement('div');
			hp.className = 'mbr-fighter-hp';
			const hpFill = document.createElement('div');
			hpFill.className = 'mbr-fighter-hp-fill';
			hpFill.style.width = Math.max(0, (fighter.hp / fighter.maxHp) * 100) + '%';
			hp.appendChild(hpFill);
			wrap.appendChild(hp);

			return wrap;
		}

		function renderFighters() {
			els.fighters.innerHTML = '';
			if (state.player && state.player.alive) {
				els.fighters.appendChild(fighterEl(state.player));
			}
			state.enemies.forEach(function (enemy) {
				if (enemy.alive) {
					els.fighters.appendChild(fighterEl(enemy));
				}
			});
		}

		function renderRoster() {
			const query = (els.search.value || '').toLowerCase().trim();
			els.rosterList.innerHTML = '';

			state.roster.filter(function (item) {
				if (!query) return true;
				return item.name.toLowerCase().indexOf(query) !== -1 || String(item.id).indexOf(query) !== -1;
			}).slice(0, 40).forEach(function (item) {
				const row = document.createElement('div');
				row.className = 'mbr-roster-item';

				const left = document.createElement('div');
				const name = document.createElement('div');
				name.className = 'mbr-roster-name';
				name.textContent = item.name;
				left.appendChild(name);

				const meta = document.createElement('div');
				meta.className = 'mbr-roster-meta';
				meta.textContent = 'Fiyat: ' + item.cost + ' • HP ' + item.hp + ' • Güç ' + item.damage + ' • Hız ' + item.speed;
				left.appendChild(meta);
				row.appendChild(left);

				const btn = document.createElement('button');
				btn.type = 'button';
				btn.className = 'mbr-shop-btn mbr-roster-buy';

				if (state.ownedIds.has(item.id)) {
					btn.textContent = item.id === state.selectedId ? 'Seçili' : 'Seç';
					btn.disabled = item.id === state.selectedId;
					btn.addEventListener('click', function () {
						if (state.running) return;
						state.selectedId = item.id;
						state.log = item.name + ' seçildi.';
						renderAll();
						game.focus();
					});
				} else {
					btn.textContent = 'Satın Al';
					btn.disabled = state.running || state.money < item.cost;
					btn.addEventListener('click', function () {
						if (state.running) return;
						if (state.money < item.cost) {
							state.log = 'Bunun için yeterli paran yok.';
							updateHud();
							return;
						}
						state.money -= item.cost;
						state.ownedIds.add(item.id);
						state.selectedId = item.id;
						state.log = item.name + ' satın alındı ve seçildi.';
						renderAll();
						game.focus();
					});
				}

				row.appendChild(btn);
				els.rosterList.appendChild(row);
			});
		}

		function renderAll() {
			renderPacks();
			renderShots();
			renderFighters();
			updateHud();
			renderRoster();
		}

		function allFighters() {
			const arr = [];
			if (state.player && state.player.alive) arr.push(state.player);
			state.enemies.forEach(function (e) {
				if (e.alive) arr.push(e);
			});
			return arr;
		}

		function fireShot(owner, targetX, targetY, damage) {
			const dx = targetX - owner.x;
			const dy = targetY - owner.y;
			const distance = Math.sqrt(dx * dx + dy * dy) || 1;

			state.shots.push({
				x: owner.x,
				y: owner.y,
				vx: (dx / distance) * CONFIG.shotSpeed,
				vy: (dy / distance) * CONFIG.shotSpeed,
				damage: damage,
				ownerId: owner.id,
				ownerType: owner.type,
				life: 1.8
			});
		}

		function nearestTarget(from, targets) {
			let best = null;
			let bestD = Infinity;

			targets.forEach(function (t) {
				if (!t.alive || t.id === from.id) return;
				const d = dist(from.x, from.y, t.x, t.y);
				if (d < bestD) {
					bestD = d;
					best = t;
				}
			});

			return { target: best, distance: bestD };
		}

		function startLevel() {
			const diff = difficultySettings[state.difficulty];
			const current = selectedBrawler();
			const enemyLevelMul = 1 + ((state.level - 1) * diff.levelScale);
			const enemyCount = CONFIG.baseEnemyCount + Math.floor((state.level - 1) / 4);

			state.player = makeFighter('player', current.name, 'player', spawnPoint(0).x, spawnPoint(0).y, current.hp, current.damage, current.speed);
			state.enemies = [];
			state.shots = [];
			state.packs = [];
			state.levelCleared = false;
			state.running = true;
			state.gameOver = false;
			state.lastTime = 0;

			for (let i = 0; i < enemyCount; i++) {
				const p = spawnPoint(i + 1);
				const baseCost = 10 + Math.floor((state.level * 3) + (i * 4));
				const enemyHp = Math.round(85 + (baseCost * 1.4) * enemyLevelMul);
				const enemyDamage = Math.round(8 + (baseCost * 0.22) * enemyLevelMul);
				const enemySpeed = Math.round((110 + Math.min(160, baseCost * 0.14)) * enemyLevelMul);
				const enemyName = 'AI ' + (i + 1);
				state.enemies.push(makeFighter('enemy-' + i, enemyName, 'enemy', p.x, p.y, enemyHp, enemyDamage, enemySpeed));
			}

			for (let i = 0; i < CONFIG.packCount; i++) {
				state.packs.push({
					x: randomRange(100, CONFIG.width - 100),
					y: randomRange(100, CONFIG.height - 100),
					used: false
				});
			}

			state.log = 'Level ' + state.level + ' başladı. AI rakipler gücüne göre saldırır.';
			hideOverlay();
			renderAll();
			state.rafId = window.requestAnimationFrame(loop);
		}

		function resetFullGame() {
			state.level = 1;
			state.money = 40;
			state.elims = 0;
			state.running = false;
			state.gameOver = false;
			state.levelCleared = false;
			const current = selectedBrawler();
			state.player = makeFighter('player', current.name, 'player', spawnPoint(0).x, spawnPoint(0).y, current.hp, current.damage, current.speed);
			state.enemies = [];
			state.shots = [];
			state.packs = [];
			state.log = 'Karakter seç ve oyunu başlat.';
			updateDifficultyButtons();
			renderBushes();
			renderAll();
			showOverlay('Sonsuz Roster Brawl', '1000 kişi var. Parayla daha iyi kişi alabilirsin. Kazanırsan az para gelir. Kaybedersen para gider.', 'start');
		}

		function movePlayer(dt) {
			let dx = 0;
			let dy = 0;

			if (state.keys.left) dx -= 1;
			if (state.keys.right) dx += 1;
			if (state.keys.up) dy -= 1;
			if (state.keys.down) dy += 1;

			const len = Math.sqrt(dx * dx + dy * dy) || 1;
			if (dx !== 0 || dy !== 0) {
				state.player.x += (dx / len) * state.player.speed * dt;
				state.player.y += (dy / len) * state.player.speed * dt;
				state.player.x = clamp(state.player.x, state.player.size / 2, CONFIG.width - state.player.size / 2);
				state.player.y = clamp(state.player.y, state.player.size / 2, CONFIG.height - state.player.size / 2);
			}
		}

		function playerAutoFire(dt) {
			if (!state.player || !state.player.alive) return;

			state.player.fireCooldown -= dt;
			if (state.player.fireCooldown <= 0) {
				const target = nearestTarget(state.player, state.enemies.filter(function (e) { return e.alive; }));
				if (target.target) {
					fireShot(state.player, target.target.x, target.target.y, state.player.damage);
					state.player.fireCooldown = Math.max(0.24, 0.62 - (state.player.damage * 0.004));
				}
			}
		}

		function aiMoveAndFire(dt) {
			const diff = difficultySettings[state.difficulty];
			const everyone = allFighters();

			state.enemies.forEach(function (enemy) {
				if (!enemy.alive) return;

				enemy.fireCooldown -= dt;
				enemy.wanderTimer -= dt;

				const result = nearestTarget(enemy, everyone);
				const target = result.target;
				const targetDistance = result.distance;
				if (!target) return;

				let moveToX = target.x;
				let moveToY = target.y;

				if (targetDistance > diff.enemyAimRange || enemy.wanderTimer <= 0) {
					enemy.wanderX = clamp(target.x + randomRange(-90, 90), enemy.size / 2, CONFIG.width - enemy.size / 2);
					enemy.wanderY = clamp(target.y + randomRange(-90, 90), enemy.size / 2, CONFIG.height - enemy.size / 2);
					enemy.wanderTimer = randomRange(0.7, 1.4);
				}

				if (targetDistance < 120) {
					moveToX = enemy.x - (target.x - enemy.x);
					moveToY = enemy.y - (target.y - enemy.y);
				} else {
					moveToX = enemy.wanderX;
					moveToY = enemy.wanderY;
				}

				const dx = moveToX - enemy.x;
				const dy = moveToY - enemy.y;
				const len = Math.sqrt(dx * dx + dy * dy) || 1;

				enemy.x += (dx / len) * enemy.speed * dt;
				enemy.y += (dy / len) * enemy.speed * dt;
				enemy.x = clamp(enemy.x, enemy.size / 2, CONFIG.width - enemy.size / 2);
				enemy.y = clamp(enemy.y, enemy.size / 2, CONFIG.height - enemy.size / 2);

				const enemyDelay = Math.max(0.22, diff.enemyFireDelay - (enemy.damage * 0.006));

				if (targetDistance <= diff.enemyAimRange && enemy.fireCooldown <= 0) {
					fireShot(enemy, target.x, target.y, enemy.damage);
					enemy.fireCooldown = enemyDelay;
				}
			});
		}

		function updateShots(dt) {
			const everyone = allFighters();

			state.shots.forEach(function (shot) {
				shot.x += shot.vx * dt;
				shot.y += shot.vy * dt;
				shot.life -= dt;
			});

			state.shots = state.shots.filter(function (shot) {
				if (shot.life <= 0) return false;
				if (shot.x < 0 || shot.x > CONFIG.width || shot.y < 0 || shot.y > CONFIG.height) return false;

				for (let i = 0; i < everyone.length; i++) {
					const fighter = everyone[i];
					if (!fighter.alive || fighter.id === shot.ownerId) continue;

					if (circleHit({ x: shot.x, y: shot.y }, fighter, CONFIG.shotSize / 2, fighter.size / 2)) {
						fighter.hp -= shot.damage;

						if (fighter.hp <= 0) {
							fighter.hp = 0;
							fighter.alive = false;

							if (shot.ownerType === 'player' && fighter.type === 'enemy') {
								state.elims += 1;
								state.money += 2;
								state.log = fighter.name + ' düştü. +2 para.';
							} else if (fighter.type === 'player') {
								state.log = 'Sen düştün.';
							}
						} else if (fighter.type === 'player') {
							state.log = 'AI sana vurdu.';
						}

						return false;
					}
				}

				return true;
			});
		}

		function updatePacks() {
			if (!state.player || !state.player.alive) return;

			state.packs.forEach(function (pack) {
				if (pack.used) return;

				if (circleHit({ x: pack.x, y: pack.y }, state.player, 13, state.player.size / 2)) {
					pack.used = true;
					state.player.hp = Math.min(state.player.maxHp, state.player.hp + 28);
					state.log = 'Can paketi aldın.';
				}
			});

			state.enemies.forEach(function (enemy) {
				if (!enemy.alive) return;
				state.packs.forEach(function (pack) {
					if (pack.used) return;
					if (circleHit({ x: pack.x, y: pack.y }, enemy, 13, enemy.size / 2)) {
						pack.used = true;
						enemy.hp = Math.min(enemy.maxHp, enemy.hp + 20);
					}
				});
			});
		}

		function endRunLose() {
			state.running = false;
			state.gameOver = true;
			const diff = difficultySettings[state.difficulty];
			const loss = Math.min(state.money, Math.max(3, Math.floor(state.money * diff.loseMoneyRate)));
			state.money -= loss;
			renderAll();
			showOverlay('Kaybettin', 'Level ' + state.level + ' içinde düştün. -' + loss + ' para gitti.', 'lose');
		}

		function endRunWin() {
			state.running = false;
			state.levelCleared = true;
			const reward = 6 + Math.floor(state.level * 2);
			state.money += reward;
			renderAll();
			showOverlay('Level ' + state.level + ' Bitti', 'Kazandın. +' + reward + ' para aldın. İstersen sonraki leveli sen başlat.', 'next');
			state.level += 1;
		}

		function checkEnd() {
			const aliveEnemies = state.enemies.filter(function (e) { return e.alive; }).length;

			if (!state.player.alive) {
				endRunLose();
				return true;
			}

			if (aliveEnemies === 0) {
				endRunWin();
				return true;
			}

			return false;
		}

		function loop(timestamp) {
			if (!state.running) return;

			if (!state.lastTime) {
				state.lastTime = timestamp;
			}

			const dt = Math.min(0.05, (timestamp - state.lastTime) / 1000);
			state.lastTime = timestamp;

			movePlayer(dt);
			playerAutoFire(dt);
			aiMoveAndFire(dt);
			updateShots(dt);
			updatePacks();
			renderAll();

			if (!checkEnd()) {
				state.rafId = window.requestAnimationFrame(loop);
			}
		}

		function setDifficulty(value) {
			if (state.running) return;
			state.difficulty = value;
			state.log = difficultySettings[value].label + ' seçildi.';
			updateDifficultyButtons();
			updateHud();
		}

		els.diffBtns.forEach(function (btn) {
			btn.addEventListener('click', function () {
				setDifficulty(btn.getAttribute('data-difficulty'));
				game.focus();
			});
		});

		els.startBtn.addEventListener('click', function () {
			startLevel();
			game.focus();
		});

		els.nextBtn.addEventListener('click', function () {
			startLevel();
			game.focus();
		});

		els.restartBtn.addEventListener('click', function () {
			resetFullGame();
			game.focus();
		});

		els.search.addEventListener('input', function () {
			renderRoster();
		});

		game.addEventListener('keydown', function (e) {
			if (e.key === 'ArrowUp' || e.key === 'w' || e.key === 'W') {
				state.keys.up = true;
				e.preventDefault();
			}
			if (e.key === 'ArrowDown' || e.key === 's' || e.key === 'S') {
				state.keys.down = true;
				e.preventDefault();
			}
			if (e.key === 'ArrowLeft' || e.key === 'a' || e.key === 'A') {
				state.keys.left = true;
				e.preventDefault();
			}
			if (e.key === 'ArrowRight' || e.key === 'd' || e.key === 'D') {
				state.keys.right = true;
				e.preventDefault();
			}
			if ((e.key === '1' || e.key === '2' || e.key === '3') && !state.running) {
				if (e.key === '1') setDifficulty('kolay');
				if (e.key === '2') setDifficulty('orta');
				if (e.key === '3') setDifficulty('zor');
				e.preventDefault();
			}
			if ((e.key === ' ' || e.key === 'Enter') && !state.running) {
				startLevel();
				e.preventDefault();
			}
		});

		game.addEventListener('keyup', function (e) {
			if (e.key === 'ArrowUp' || e.key === 'w' || e.key === 'W') state.keys.up = false;
			if (e.key === 'ArrowDown' || e.key === 's' || e.key === 'S') state.keys.down = false;
			if (e.key === 'ArrowLeft' || e.key === 'a' || e.key === 'A') state.keys.left = false;
			if (e.key === 'ArrowRight' || e.key === 'd' || e.key === 'D') state.keys.right = false;
		});

		els.moveBtns.forEach(function (btn) {
			btn.addEventListener('pointerdown', function () {
				const move = btn.getAttribute('data-move');
				state.keys[move] = true;
				game.focus();
			});
			btn.addEventListener('pointerup', function () {
				const move = btn.getAttribute('data-move');
				state.keys[move] = false;
			});
			btn.addEventListener('pointerleave', function () {
				const move = btn.getAttribute('data-move');
				state.keys[move] = false;
			});
			btn.addEventListener('pointercancel', function () {
				const move = btn.getAttribute('data-move');
				state.keys[move] = false;
			});
		});

		state.roster = makeRoster();
		renderBushes();
		resetFullGame();
	});
});
JS;

if (!function_exists('zo_game_mini_brawl_roster_render')) {
	function zo_game_mini_brawl_roster_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-mini-brawl-roster-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--mini-brawl-roster" id="<?php echo esc_attr($instance_id); ?>" tabindex="0">
			<div class="mbr-title">Roster Brawl 1000</div>
			<div class="mbr-instructions">1000 kişi var. Parayla daha iyi kişi al. Fiyat yükseldikçe saldırı, can ve hız da yükselir. Kazanırsan daha az para gelir. Kaybedersen para kaybedersin.</div>

			<div class="mbr-topbar">
				<div class="mbr-stat">Hayatta: <span data-role="alive">5</span></div>
				<div class="mbr-stat">Canın: <span data-role="hp">100 / 100</span></div>
				<div class="mbr-stat">Düşen: <span data-role="elims">0</span></div>
				<div class="mbr-stat">Zorluk: <span data-role="difficulty-label">Orta</span></div>
				<div class="mbr-stat">Level: <span data-role="level">1</span></div>
				<div class="mbr-stat">Para: <span data-role="money">40</span></div>
				<div class="mbr-stat">Seçili: <span data-role="current-name">Başlangıççı #1</span></div>
			</div>

			<div class="mbr-row">
				<button type="button" class="mbr-difficulty-btn" data-difficulty="kolay">Kolay</button>
				<button type="button" class="mbr-difficulty-btn is-active" data-difficulty="orta">Orta</button>
				<button type="button" class="mbr-difficulty-btn" data-difficulty="zor">Zor</button>
			</div>

			<div class="mbr-panels">
				<div class="mbr-panel">
					<div class="mbr-panel-title">Seçili Kişi</div>
					<div class="mbr-team-card">
						<div class="mbr-team-name" data-role="current-name">Başlangıççı #1</div>
						<div class="mbr-team-meta">Fiyat: <span data-role="current-cost">Başlangıç</span></div>
						<div class="mbr-team-meta" data-role="current-stats">HP 100 • Güç 18 • Hız 160</div>
					</div>
				</div>

				<div class="mbr-panel">
					<div class="mbr-panel-title">1000 Kişilik Market</div>
					<div class="mbr-roster-head">
						<input type="text" class="mbr-input" data-role="search" placeholder="İsim veya numara ara" autocomplete="off" />
					</div>
					<div class="mbr-roster-list" data-role="roster-list"></div>
				</div>
			</div>

			<div class="mbr-board-wrap">
				<div class="mbr-board" data-role="board">
					<div data-role="bushes"></div>
					<div data-role="packs"></div>
					<div data-role="shots"></div>
					<div data-role="fighters"></div>

					<div class="mbr-overlay" data-role="overlay">
						<div class="mbr-panel-pop">
							<div class="mbr-panel-pop-title" data-role="overlay-title">Roster Brawl 1000</div>
							<div class="mbr-panel-pop-text" data-role="overlay-text">Karakter seç ve başla.</div>
							<div class="mbr-btn-row">
								<button type="button" class="mbr-btn" data-role="start-btn">Başla</button>
								<button type="button" class="mbr-btn" data-role="next-btn" hidden>Sonraki Level</button>
								<button type="button" class="mbr-btn" data-role="restart-btn">Yeniden Başlat</button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="mbr-log" data-role="log">Karakter seç ve başla.</div>

			<div class="mbr-mobile-controls">
				<button type="button" class="mbr-move mbr-move--up" data-move="up" aria-label="Yukarı">↑</button>
				<button type="button" class="mbr-move mbr-move--left" data-move="left" aria-label="Sol">←</button>
				<button type="button" class="mbr-move mbr-move--down" data-move="down" aria-label="Aşağı">↓</button>
				<button type="button" class="mbr-move mbr-move--right" data-move="right" aria-label="Sağ">→</button>
			</div>

			<div class="mbr-controls">Hareket: ok tuşları veya WASD. Başlat: Space veya Enter. Daha pahalı kişi daha güçlü vurur. Kaybedersen para düşer.</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'mini-brawl-roster',
	'name'            => 'Roster Brawl 1000',
	'author'          => 'Arslan',
	'description'     => 'An endless arena game with 1000 buyable characters whose attack scales with cost, lower win rewards, and money loss on defeat.',
	'render_callback' => 'zo_game_mini_brawl_roster_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);