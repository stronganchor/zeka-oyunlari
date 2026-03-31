<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 980px;
	margin: 0 auto;
	text-align: center;
}

.zo-game-root--mini-brawl-arena {
	font-family: Arial, sans-serif;
	background: linear-gradient(180deg, #1f2d45 0%, #172235 100%);
	color: #ffffff;
	border-radius: 18px;
	padding: 16px;
	box-sizing: border-box;
}

.zo-game-root--mini-brawl-arena * {
	box-sizing: border-box;
}

.zo-game-root--mini-brawl-arena .mba-title {
	font-size: 30px;
	font-weight: 700;
	margin-bottom: 8px;
	color: #9ddbff;
}

.zo-game-root--mini-brawl-arena .mba-instructions {
	font-size: 15px;
	line-height: 1.5;
	color: #d6e1f5;
	margin-bottom: 14px;
}

.zo-game-root--mini-brawl-arena .mba-topbar {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 10px;
	margin-bottom: 14px;
}

.zo-game-root--mini-brawl-arena .mba-stat {
	background: rgba(255,255,255,0.08);
	border: 1px solid rgba(255,255,255,0.12);
	border-radius: 14px;
	padding: 10px 12px;
	font-size: 15px;
	font-weight: 700;
}

.zo-game-root--mini-brawl-arena .mba-difficulty {
	display: flex;
	justify-content: center;
	gap: 10px;
	flex-wrap: wrap;
	margin-bottom: 14px;
}

.zo-game-root--mini-brawl-arena .mba-difficulty-btn,
.zo-game-root--mini-brawl-arena .mba-btn {
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

.zo-game-root--mini-brawl-arena .mba-difficulty-btn:hover,
.zo-game-root--mini-brawl-arena .mba-difficulty-btn:focus,
.zo-game-root--mini-brawl-arena .mba-btn:hover,
.zo-game-root--mini-brawl-arena .mba-btn:focus {
	background: #3a63c2;
	outline: none;
}

.zo-game-root--mini-brawl-arena .mba-difficulty-btn.is-active {
	background: #ffd84c;
	color: #1a1a1a;
	border-color: #ffd84c;
}

.zo-game-root--mini-brawl-arena .mba-board-wrap {
	position: relative;
	width: 100%;
	max-width: 920px;
	margin: 0 auto 14px;
}

.zo-game-root--mini-brawl-arena .mba-board {
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

.zo-game-root--mini-brawl-arena .mba-bush {
	position: absolute;
	background: #2c8f45;
	border: 2px solid rgba(0,0,0,0.15);
	border-radius: 12px;
}

.zo-game-root--mini-brawl-arena .mba-fighter,
.zo-game-root--mini-brawl-arena .mba-shot,
.zo-game-root--mini-brawl-arena .mba-pack {
	position: absolute;
}

.zo-game-root--mini-brawl-arena .mba-fighter {
	border-radius: 50%;
	border: 3px solid rgba(255,255,255,0.65);
	box-shadow: inset 0 0 0 2px rgba(0,0,0,0.12);
}

.zo-game-root--mini-brawl-arena .mba-fighter--player {
	background: #3a7bff;
}

.zo-game-root--mini-brawl-arena .mba-fighter--enemy {
	background: #ff5757;
}

.zo-game-root--mini-brawl-arena .mba-fighter-name {
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

.zo-game-root--mini-brawl-arena .mba-fighter-hp {
	position: absolute;
	left: 50%;
	top: calc(100% + 6px);
	transform: translateX(-50%);
	width: 54px;
	height: 8px;
	background: rgba(0,0,0,0.35);
	border-radius: 999px;
	overflow: hidden;
}

.zo-game-root--mini-brawl-arena .mba-fighter-hp-fill {
	height: 100%;
	background: #55e086;
}

.zo-game-root--mini-brawl-arena .mba-shot {
	border-radius: 50%;
	background: #ffe15a;
}

.zo-game-root--mini-brawl-arena .mba-pack {
	width: 26px;
	height: 26px;
	background: #9be7ff;
	border: 2px solid #1c5c74;
	border-radius: 8px;
	box-shadow: inset 0 0 0 2px rgba(255,255,255,0.2);
}

.zo-game-root--mini-brawl-arena .mba-pack::before,
.zo-game-root--mini-brawl-arena .mba-pack::after {
	content: '';
	position: absolute;
	background: #1c5c74;
}

.zo-game-root--mini-brawl-arena .mba-pack::before {
	left: 50%;
	top: 4px;
	transform: translateX(-50%);
	width: 4px;
	height: 16px;
}

.zo-game-root--mini-brawl-arena .mba-pack::after {
	top: 50%;
	left: 4px;
	transform: translateY(-50%);
	width: 16px;
	height: 4px;
}

.zo-game-root--mini-brawl-arena .mba-overlay {
	position: absolute;
	inset: 0;
	display: flex;
	align-items: center;
	justify-content: center;
	padding: 20px;
	background: rgba(11, 19, 30, 0.5);
	z-index: 10;
}

.zo-game-root--mini-brawl-arena .mba-overlay[hidden] {
	display: none;
}

.zo-game-root--mini-brawl-arena .mba-panel {
	background: rgba(20, 31, 48, 0.96);
	border: 1px solid rgba(255,255,255,0.14);
	border-radius: 18px;
	padding: 24px;
	max-width: 480px;
	width: 100%;
}

.zo-game-root--mini-brawl-arena .mba-panel-title {
	font-size: 32px;
	font-weight: 700;
	margin-bottom: 10px;
}

.zo-game-root--mini-brawl-arena .mba-panel-text {
	font-size: 16px;
	line-height: 1.55;
	color: #dce7fb;
	margin-bottom: 14px;
}

.zo-game-root--mini-brawl-arena .mba-btn-row {
	display: flex;
	justify-content: center;
	gap: 10px;
	flex-wrap: wrap;
}

.zo-game-root--mini-brawl-arena .mba-log {
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

.zo-game-root--mini-brawl-arena .mba-mobile-controls {
	display: grid;
	grid-template-columns: repeat(3, 72px);
	grid-template-rows: repeat(2, 72px);
	gap: 8px;
	justify-content: center;
	margin-top: 12px;
}

.zo-game-root--mini-brawl-arena .mba-move {
	appearance: none;
	border: 1px solid #4f648f;
	background: #233552;
	color: #fff;
	border-radius: 14px;
	font-size: 28px;
	font-weight: 700;
	cursor: pointer;
}

.zo-game-root--mini-brawl-arena .mba-move:hover,
.zo-game-root--mini-brawl-arena .mba-move:focus {
	background: #2f4870;
	outline: none;
}

.zo-game-root--mini-brawl-arena .mba-move--up {
	grid-column: 2;
	grid-row: 1;
}

.zo-game-root--mini-brawl-arena .mba-move--left {
	grid-column: 1;
	grid-row: 2;
}

.zo-game-root--mini-brawl-arena .mba-move--down {
	grid-column: 2;
	grid-row: 2;
}

.zo-game-root--mini-brawl-arena .mba-move--right {
	grid-column: 3;
	grid-row: 2;
}

.zo-game-root--mini-brawl-arena .mba-controls {
	font-size: 14px;
	line-height: 1.5;
	color: #d6e1f5;
}

@media (max-width: 640px) {
	.zo-game-root--mini-brawl-arena .mba-title {
		font-size: 26px;
	}

	.zo-game-root--mini-brawl-arena .mba-topbar {
		grid-template-columns: repeat(2, minmax(0, 1fr));
	}

	.zo-game-root--mini-brawl-arena .mba-panel-title {
		font-size: 28px;
	}

	.zo-game-root--mini-brawl-arena .mba-difficulty-btn,
	.zo-game-root--mini-brawl-arena .mba-btn {
		width: 100%;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--mini-brawl-arena');

	games.forEach(function (game) {
		const CONFIG = {
			width: 920,
			height: 560,
			fighterSize: 32,
			playerSpeed: 160,
			playerHp: 100,
			playerDamage: 18,
			enemyCount: 4,
			shotSize: 8,
			shotSpeed: 360,
			packCount: 3
		};

		const difficultySettings = {
			kolay: { enemySpeed: 90, enemyDamage: 8, enemyFireDelay: 1550, enemyAimRange: 240, label: 'Kolay' },
			orta:  { enemySpeed: 120, enemyDamage: 11, enemyFireDelay: 1100, enemyAimRange: 300, label: 'Orta' },
			zor:   { enemySpeed: 150, enemyDamage: 15, enemyFireDelay: 800, enemyAimRange: 380, label: 'Zor' }
		};

		const bushes = [
			{ x: 100, y: 80, w: 120, h: 80 },
			{ x: 360, y: 60, w: 180, h: 90 },
			{ x: 700, y: 100, w: 110, h: 75 },
			{ x: 180, y: 300, w: 140, h: 90 },
			{ x: 470, y: 280, w: 120, h: 110 },
			{ x: 710, y: 330, w: 120, h: 80 }
		];

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
			log: game.querySelector('[data-role="log"]'),
			overlay: game.querySelector('[data-role="overlay"]'),
			overlayTitle: game.querySelector('[data-role="overlay-title"]'),
			overlayText: game.querySelector('[data-role="overlay-text"]'),
			startBtn: game.querySelector('[data-role="start-btn"]'),
			restartBtn: game.querySelector('[data-role="restart-btn"]'),
			diffBtns: game.querySelectorAll('[data-difficulty]'),
			moveBtns: game.querySelectorAll('[data-move]')
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
			keys: { up: false, down: false, left: false, right: false },
			pointerX: CONFIG.width / 2,
			pointerY: CONFIG.height / 2,
			log: 'Zorluk seç ve başla.'
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
				{ x: 460, y: 500 }
			];
			return points[index % points.length];
		}

		function makeFighter(id, name, type, x, y) {
			return {
				id: id,
				name: name,
				type: type,
				x: x,
				y: y,
				size: CONFIG.fighterSize,
				hp: CONFIG.playerHp,
				maxHp: CONFIG.playerHp,
				fireCooldown: 0,
				wanderX: x,
				wanderY: y,
				wanderTimer: 0,
				alive: true
			};
		}

		function resetGame() {
			const diff = difficultySettings[state.difficulty];

			state.player = makeFighter('player', 'Sen', 'player', spawnPoint(0).x, spawnPoint(0).y);
			state.enemies = [];
			state.shots = [];
			state.packs = [];
			state.elims = 0;
			state.lastTime = 0;
			state.running = false;
			state.gameOver = false;
			state.log = diff.label + ' seçildi. Başla tuşuna bas.';
			state.pointerX = state.player.x;
			state.pointerY = state.player.y;

			for (let i = 0; i < CONFIG.enemyCount; i++) {
				const p = spawnPoint(i + 1);
				state.enemies.push(makeFighter('enemy-' + i, 'AI ' + (i + 1), 'enemy', p.x, p.y));
			}

			for (let i = 0; i < CONFIG.packCount; i++) {
				state.packs.push({
					x: randomRange(100, CONFIG.width - 100),
					y: randomRange(100, CONFIG.height - 100),
					used: false
				});
			}

			updateDifficultyButtons();
			renderBushes();
			render();
			showOverlay('Mini Brawl Arena', 'Toplam 5 kişi var. Sen + 4 AI. Zorluk: ' + diff.label + '.', true);
		}

		function updateDifficultyButtons() {
			els.diffBtns.forEach(function (btn) {
				const value = btn.getAttribute('data-difficulty');
				btn.classList.toggle('is-active', value === state.difficulty);
			});
		}

		function showOverlay(title, text, showStart) {
			els.overlayTitle.textContent = title;
			els.overlayText.textContent = text;
			els.startBtn.hidden = !showStart;
			els.restartBtn.hidden = false;
			els.overlay.hidden = false;
		}

		function hideOverlay() {
			els.overlay.hidden = true;
		}

		function updateHud() {
			const aliveEnemies = state.enemies.filter(function (e) { return e.alive; }).length;
			const aliveTotal = (state.player && state.player.alive ? 1 : 0) + aliveEnemies;
			els.alive.textContent = String(aliveTotal) + ' / 5';
			els.hp.textContent = state.player ? String(Math.max(0, Math.round(state.player.hp))) : '0';
			els.elims.textContent = String(state.elims);
			els.diff.textContent = difficultySettings[state.difficulty].label;
			els.log.textContent = state.log;
		}

		function renderBushes() {
			els.bushes.innerHTML = '';
			bushes.forEach(function (b) {
				const el = document.createElement('div');
				el.className = 'mba-bush';
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
				if (pack.used) {
					return;
				}
				const el = document.createElement('div');
				el.className = 'mba-pack';
				el.style.left = scaleX(pack.x - 13) + '%';
				el.style.top = scaleY(pack.y - 13) + '%';
				els.packs.appendChild(el);
			});
		}

		function renderShots() {
			els.shots.innerHTML = '';
			state.shots.forEach(function (shot) {
				const el = document.createElement('div');
				el.className = 'mba-shot';
				el.style.left = scaleX(shot.x - CONFIG.shotSize / 2) + '%';
				el.style.top = scaleY(shot.y - CONFIG.shotSize / 2) + '%';
				el.style.width = scaleX(CONFIG.shotSize) + '%';
				el.style.height = scaleY(CONFIG.shotSize) + '%';
				els.shots.appendChild(el);
			});
		}

		function fighterEl(fighter) {
			const wrap = document.createElement('div');
			wrap.className = 'mba-fighter mba-fighter--' + fighter.type;
			wrap.style.left = scaleX(fighter.x - fighter.size / 2) + '%';
			wrap.style.top = scaleY(fighter.y - fighter.size / 2) + '%';
			wrap.style.width = scaleX(fighter.size) + '%';
			wrap.style.height = scaleY(fighter.size) + '%';

			const name = document.createElement('div');
			name.className = 'mba-fighter-name';
			name.textContent = fighter.name;
			wrap.appendChild(name);

			const hp = document.createElement('div');
			hp.className = 'mba-fighter-hp';
			const hpFill = document.createElement('div');
			hpFill.className = 'mba-fighter-hp-fill';
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

		function render() {
			renderPacks();
			renderShots();
			renderFighters();
			updateHud();
		}

		function allFighters() {
			const arr = [];
			if (state.player && state.player.alive) {
				arr.push(state.player);
			}
			state.enemies.forEach(function (e) {
				if (e.alive) {
					arr.push(e);
				}
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
				life: 1.6
			});
		}

		function nearestTarget(from, targets) {
			let best = null;
			let bestD = Infinity;

			targets.forEach(function (t) {
				if (!t.alive || t.id === from.id) {
					return;
				}
				const d = dist(from.x, from.y, t.x, t.y);
				if (d < bestD) {
					bestD = d;
					best = t;
				}
			});

			return { target: best, distance: bestD };
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
				state.player.x += (dx / len) * CONFIG.playerSpeed * dt;
				state.player.y += (dy / len) * CONFIG.playerSpeed * dt;
				state.player.x = clamp(state.player.x, state.player.size / 2, CONFIG.width - state.player.size / 2);
				state.player.y = clamp(state.player.y, state.player.size / 2, CONFIG.height - state.player.size / 2);
			}
		}

		function aiMoveAndFire(dt) {
			const diff = difficultySettings[state.difficulty];
			const everyone = allFighters();

			state.enemies.forEach(function (enemy) {
				if (!enemy.alive) {
					return;
				}

				enemy.fireCooldown -= dt;
				enemy.wanderTimer -= dt;

				const result = nearestTarget(enemy, everyone);
				const target = result.target;
				const targetDistance = result.distance;

				if (!target) {
					return;
				}

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

				enemy.x += (dx / len) * diff.enemySpeed * dt;
				enemy.y += (dy / len) * diff.enemySpeed * dt;
				enemy.x = clamp(enemy.x, enemy.size / 2, CONFIG.width - enemy.size / 2);
				enemy.y = clamp(enemy.y, enemy.size / 2, CONFIG.height - enemy.size / 2);

				if (targetDistance <= diff.enemyAimRange && enemy.fireCooldown <= 0) {
					fireShot(enemy, target.x, target.y, diff.enemyDamage);
					enemy.fireCooldown = diff.enemyFireDelay / 1000;
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
				if (shot.life <= 0) {
					return false;
				}
				if (shot.x < 0 || shot.x > CONFIG.width || shot.y < 0 || shot.y > CONFIG.height) {
					return false;
				}

				for (let i = 0; i < everyone.length; i++) {
					const fighter = everyone[i];
					if (!fighter.alive || fighter.id === shot.ownerId) {
						continue;
					}

					if (circleHit({ x: shot.x, y: shot.y }, fighter, CONFIG.shotSize / 2, fighter.size / 2)) {
						fighter.hp -= shot.damage;

						if (fighter.hp <= 0) {
							fighter.hp = 0;
							fighter.alive = false;

							if (shot.ownerType === 'player' && fighter.type === 'enemy') {
								state.elims += 1;
								state.log = fighter.name + ' düştü.';
							} else if (fighter.type === 'player') {
								state.log = 'Sen düştün.';
							}
						} else if (fighter.type === 'player') {
							state.log = 'Vuruldun.';
						}

						return false;
					}
				}

				return true;
			});
		}

		function updatePacks() {
			if (!state.player || !state.player.alive) {
				return;
			}

			state.packs.forEach(function (pack) {
				if (pack.used) {
					return;
				}

				if (circleHit({ x: pack.x, y: pack.y }, state.player, 13, state.player.size / 2)) {
					pack.used = true;
					state.player.hp = Math.min(state.player.maxHp, state.player.hp + 28);
					state.log = 'Can paketi aldın.';
				}
			});

			state.enemies.forEach(function (enemy) {
				if (!enemy.alive) {
					return;
				}
				state.packs.forEach(function (pack) {
					if (pack.used) {
						return;
					}
					if (circleHit({ x: pack.x, y: pack.y }, enemy, 13, enemy.size / 2)) {
						pack.used = true;
						enemy.hp = Math.min(enemy.maxHp, enemy.hp + 20);
					}
				});
			});
		}

		function playerAutoFire(dt) {
			if (!state.player || !state.player.alive) {
				return;
			}

			state.player.fireCooldown -= dt;
			if (state.player.fireCooldown <= 0) {
				const target = nearestTarget(state.player, state.enemies.filter(function (e) { return e.alive; }));
				if (target.target) {
					fireShot(state.player, target.target.x, target.target.y, CONFIG.playerDamage);
					state.player.fireCooldown = 0.45;
				}
			}
		}

		function checkEnd() {
			const aliveEnemies = state.enemies.filter(function (e) { return e.alive; }).length;

			if (!state.player.alive) {
				state.running = false;
				state.gameOver = true;
				showOverlay('Kaybettin', 'Bütün AI düşmeden sen düştün. Zorluk: ' + difficultySettings[state.difficulty].label + '.', false);
				return true;
			}

			if (aliveEnemies === 0) {
				state.running = false;
				state.gameOver = true;
				showOverlay('Kazandın', '4 AI rakibin hepsini yendin. Zorluk: ' + difficultySettings[state.difficulty].label + '.', false);
				return true;
			}

			return false;
		}

		function loop(timestamp) {
			if (!state.running) {
				return;
			}

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
			render();

			if (!checkEnd()) {
				state.rafId = window.requestAnimationFrame(loop);
			}
		}

		function startGame() {
			resetGame();
			hideOverlay();
			state.running = true;
			state.lastTime = 0;
			state.log = 'Oyun başladı. 4 AI rakip var.';
			render();
			state.rafId = window.requestAnimationFrame(loop);
		}

		function setDifficulty(value) {
			state.difficulty = value;
			resetGame();
			game.focus();
		}

		els.diffBtns.forEach(function (btn) {
			btn.addEventListener('click', function () {
				setDifficulty(btn.getAttribute('data-difficulty'));
			});
		});

		els.startBtn.addEventListener('click', function () {
			startGame();
			game.focus();
		});

		els.restartBtn.addEventListener('click', function () {
			startGame();
			game.focus();
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
				startGame();
				e.preventDefault();
			}
		});

		game.addEventListener('keyup', function (e) {
			if (e.key === 'ArrowUp' || e.key === 'w' || e.key === 'W') {
				state.keys.up = false;
			}
			if (e.key === 'ArrowDown' || e.key === 's' || e.key === 'S') {
				state.keys.down = false;
			}
			if (e.key === 'ArrowLeft' || e.key === 'a' || e.key === 'A') {
				state.keys.left = false;
			}
			if (e.key === 'ArrowRight' || e.key === 'd' || e.key === 'D') {
				state.keys.right = false;
			}
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

		resetGame();
	});
});
JS;

if (!function_exists('zo_game_mini_brawl_arena_render')) {
	function zo_game_mini_brawl_arena_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-mini-brawl-arena-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--mini-brawl-arena" id="<?php echo esc_attr($instance_id); ?>" tabindex="0">
			<div class="mba-title">Mini Brawl Arena</div>
			<div class="mba-instructions">Oyunda toplam 5 kişi var: sen ve 4 AI rakip. Zorluğu seç. Sonra hareket edip rakipleri yen.</div>

			<div class="mba-topbar">
				<div class="mba-stat">Hayatta: <span data-role="alive">5 / 5</span></div>
				<div class="mba-stat">Canın: <span data-role="hp">100</span></div>
				<div class="mba-stat">Düşen Rakip: <span data-role="elims">0</span></div>
				<div class="mba-stat">Zorluk: <span data-role="difficulty-label">Orta</span></div>
			</div>

			<div class="mba-difficulty">
				<button type="button" class="mba-difficulty-btn" data-difficulty="kolay">Kolay</button>
				<button type="button" class="mba-difficulty-btn is-active" data-difficulty="orta">Orta</button>
				<button type="button" class="mba-difficulty-btn" data-difficulty="zor">Zor</button>
			</div>

			<div class="mba-board-wrap">
				<div class="mba-board" data-role="board">
					<div data-role="bushes"></div>
					<div data-role="packs"></div>
					<div data-role="shots"></div>
					<div data-role="fighters"></div>

					<div class="mba-overlay" data-role="overlay">
						<div class="mba-panel">
							<div class="mba-panel-title" data-role="overlay-title">Mini Brawl Arena</div>
							<div class="mba-panel-text" data-role="overlay-text">Toplam 5 kişi var. Sen ve 4 AI rakip. Zorluğu seçip başla.</div>
							<div class="mba-btn-row">
								<button type="button" class="mba-btn" data-role="start-btn">Başla</button>
								<button type="button" class="mba-btn" data-role="restart-btn">Yeniden Başlat</button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="mba-log" data-role="log">Zorluk seç ve başla.</div>

			<div class="mba-mobile-controls">
				<button type="button" class="mba-move mba-move--up" data-move="up" aria-label="Yukarı">↑</button>
				<button type="button" class="mba-move mba-move--left" data-move="left" aria-label="Sol">←</button>
				<button type="button" class="mba-move mba-move--down" data-move="down" aria-label="Aşağı">↓</button>
				<button type="button" class="mba-move mba-move--right" data-move="right" aria-label="Sağ">→</button>
			</div>

			<div class="mba-controls">Hareket: ok tuşları veya WASD. Zorluk seçimi: Kolay, Orta, Zor. Saldırı otomatik olur.</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'mini-brawl-arena',
	'name'            => 'Mini Brawl Arena',
	'author'          => 'Arslan',
	'description'     => 'A simple arena battle game with 1 player, 4 AI enemies, and selectable easy, medium, or hard difficulty.',
	'render_callback' => 'zo_game_mini_brawl_arena_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);