<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root--roster-1000 {
	max-width: 1120px;
	margin: 0 auto;
	padding: 16px;
	box-sizing: border-box;
	font-family: Arial, sans-serif;
	color: #10233d;
}

.zo-game-root--roster-1000 * {
	box-sizing: border-box;
}

.zo-game-root--roster-1000 .zo-r1-shell {
	background: linear-gradient(180deg, #fff9ec 0%, #eef7ff 100%);
	border: 1px solid #d8e6f2;
	border-radius: 24px;
	padding: 18px;
	box-shadow: 0 16px 36px rgba(16, 35, 61, 0.08);
}

.zo-game-root--roster-1000 .zo-r1-title {
	margin: 0 0 8px;
	text-align: center;
	font-size: 34px;
	line-height: 1.15;
}

.zo-game-root--roster-1000 .zo-r1-subtitle {
	margin: 0 0 18px;
	text-align: center;
	font-size: 15px;
	line-height: 1.55;
	color: #47607d;
}

.zo-game-root--roster-1000 .zo-r1-topbar {
	display: grid;
	grid-template-columns: 1.4fr 1fr;
	gap: 16px;
	margin-bottom: 16px;
}

.zo-game-root--roster-1000 .zo-r1-stats,
.zo-game-root--roster-1000 .zo-r1-controls {
	background: rgba(255, 255, 255, 0.88);
	border: 1px solid #dbe8f4;
	border-radius: 18px;
	padding: 14px;
}

.zo-game-root--roster-1000 .zo-r1-stat-grid {
	display: grid;
	grid-template-columns: repeat(5, minmax(0, 1fr));
	gap: 10px;
}

.zo-game-root--roster-1000 .zo-r1-stat {
	background: #f4f9ff;
	border: 1px solid #d8e6f2;
	border-radius: 14px;
	padding: 10px;
	text-align: center;
}

.zo-game-root--roster-1000 .zo-r1-stat-label {
	display: block;
	font-size: 12px;
	font-weight: 700;
	color: #5f7690;
	margin-bottom: 5px;
	text-transform: uppercase;
}

.zo-game-root--roster-1000 .zo-r1-stat-value {
	display: block;
	font-size: 23px;
	font-weight: 800;
	color: #10233d;
}

.zo-game-root--roster-1000 .zo-r1-stat-value--hero {
	font-size: 15px;
	line-height: 1.3;
}

.zo-game-root--roster-1000 .zo-r1-controls {
	display: flex;
	flex-direction: column;
	gap: 10px;
}

.zo-game-root--roster-1000 .zo-r1-button-row,
.zo-game-root--roster-1000 .zo-r1-pad {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
}

.zo-game-root--roster-1000 .zo-r1-btn,
.zo-game-root--roster-1000 .zo-r1-page-btn {
	border: 0;
	border-radius: 12px;
	padding: 11px 14px;
	font: inherit;
	font-size: 14px;
	font-weight: 700;
	cursor: pointer;
}

.zo-game-root--roster-1000 .zo-r1-btn--primary {
	background: #0f766e;
	color: #fff;
}

.zo-game-root--roster-1000 .zo-r1-btn--secondary,
.zo-game-root--roster-1000 .zo-r1-page-btn {
	background: #dbeafe;
	color: #12335c;
}

.zo-game-root--roster-1000 .zo-r1-btn--warn {
	background: #f97316;
	color: #fff;
}

.zo-game-root--roster-1000 .zo-r1-move {
	min-width: 78px;
	background: #1d4ed8;
	color: #fff;
}

.zo-game-root--roster-1000 .zo-r1-layout {
	display: grid;
	grid-template-columns: minmax(0, 1.35fr) minmax(320px, 0.95fr);
	gap: 16px;
}

.zo-game-root--roster-1000 .zo-r1-arena-wrap,
.zo-game-root--roster-1000 .zo-r1-side {
	background: rgba(255, 255, 255, 0.88);
	border: 1px solid #dbe8f4;
	border-radius: 20px;
	padding: 14px;
}

.zo-game-root--roster-1000 .zo-r1-canvas {
	display: block;
	width: 100%;
	height: auto;
	border-radius: 18px;
	background: radial-gradient(circle at top, #243b63 0%, #10233d 58%, #091423 100%);
	border: 1px solid #27486f;
	touch-action: none;
}

.zo-game-root--roster-1000 .zo-r1-status {
	margin-top: 12px;
	min-height: 48px;
	padding: 12px 14px;
	border-radius: 14px;
	background: #eff6ff;
	border: 1px solid #bfdbfe;
	font-size: 14px;
	font-weight: 700;
	line-height: 1.45;
	color: #1d4ed8;
}

.zo-game-root--roster-1000 .zo-r1-side-head {
	display: flex;
	justify-content: space-between;
	align-items: center;
	gap: 10px;
	margin-bottom: 10px;
}

.zo-game-root--roster-1000 .zo-r1-side-title {
	margin: 0;
	font-size: 20px;
}

.zo-game-root--roster-1000 .zo-r1-page-label {
	font-size: 13px;
	font-weight: 700;
	color: #5f7690;
}

.zo-game-root--roster-1000 .zo-r1-shop-meta {
	display: flex;
	flex-wrap: wrap;
	align-items: center;
	gap: 10px;
	margin-bottom: 10px;
}

.zo-game-root--roster-1000 .zo-r1-total {
	font-size: 13px;
	font-weight: 700;
	color: #47607d;
}

.zo-game-root--roster-1000 .zo-r1-jump {
	display: flex;
	flex-wrap: wrap;
	align-items: center;
	gap: 8px;
}

.zo-game-root--roster-1000 .zo-r1-input {
	width: 96px;
	border: 1px solid #bfdbfe;
	border-radius: 12px;
	padding: 10px 12px;
	font: inherit;
	font-size: 14px;
	color: #12335c;
	background: #ffffff;
}

.zo-game-root--roster-1000 .zo-r1-roster {
	display: grid;
	grid-template-columns: 1fr;
	gap: 10px;
	max-height: 620px;
	overflow: auto;
	padding-right: 4px;
}

.zo-game-root--roster-1000 .zo-r1-card {
	border: 1px solid #dbe8f4;
	border-radius: 16px;
	padding: 12px;
	background: #fbfdff;
}

.zo-game-root--roster-1000 .zo-r1-card.is-owned {
	background: #f0fdf4;
	border-color: #a7f3d0;
}

.zo-game-root--roster-1000 .zo-r1-card.is-selected {
	background: #fff7ed;
	border-color: #fdba74;
}

.zo-game-root--roster-1000 .zo-r1-card-top {
	display: flex;
	justify-content: space-between;
	gap: 8px;
	align-items: center;
	margin-bottom: 8px;
}

.zo-game-root--roster-1000 .zo-r1-card-name {
	font-size: 16px;
	font-weight: 800;
}

.zo-game-root--roster-1000 .zo-r1-card-badge {
	padding: 4px 8px;
	border-radius: 999px;
	font-size: 11px;
	font-weight: 800;
	text-transform: uppercase;
	background: #dbeafe;
	color: #1d4ed8;
}

.zo-game-root--roster-1000 .zo-r1-card-stats {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 8px;
	margin-bottom: 10px;
}

.zo-game-root--roster-1000 .zo-r1-mini {
	background: #f4f9ff;
	border: 1px solid #dbe8f4;
	border-radius: 12px;
	padding: 8px;
	text-align: center;
}

.zo-game-root--roster-1000 .zo-r1-mini strong {
	display: block;
	font-size: 15px;
}

.zo-game-root--roster-1000 .zo-r1-mini span {
	display: block;
	font-size: 11px;
	font-weight: 700;
	color: #5f7690;
	text-transform: uppercase;
}

.zo-game-root--roster-1000 .zo-r1-card-text {
	margin: 0 0 10px;
	font-size: 13px;
	line-height: 1.45;
	color: #47607d;
}

.zo-game-root--roster-1000 .zo-r1-card-actions {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
}

.zo-game-root--roster-1000 .zo-r1-help {
	margin-top: 12px;
	padding: 12px 14px;
	border-radius: 14px;
	background: #fffaf0;
	border: 1px solid #fde68a;
	font-size: 13px;
	line-height: 1.55;
	color: #7c5d18;
}

@media (max-width: 980px) {
	.zo-game-root--roster-1000 .zo-r1-topbar,
	.zo-game-root--roster-1000 .zo-r1-layout {
		grid-template-columns: 1fr;
	}
}

@media (max-width: 720px) {
	.zo-game-root--roster-1000 {
		padding: 10px;
	}

	.zo-game-root--roster-1000 .zo-r1-shell {
		padding: 12px;
	}

	.zo-game-root--roster-1000 .zo-r1-title {
		font-size: 28px;
	}

	.zo-game-root--roster-1000 .zo-r1-stat-grid,
	.zo-game-root--roster-1000 .zo-r1-card-stats {
		grid-template-columns: 1fr 1fr;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--roster-1000');

	games.forEach(function (game) {
		const canvas = game.querySelector('.zo-r1-canvas');
		if (!canvas) {
			return;
		}

		const ctx = canvas.getContext('2d');
		const startButton = game.querySelector('.zo-r1-start');
		const restartButton = game.querySelector('.zo-r1-restart');
		const nextButton = game.querySelector('.zo-r1-next');
		const prevPageButton = game.querySelector('.zo-r1-prev-page');
		const nextPageButton = game.querySelector('.zo-r1-next-page');
		const rosterEl = game.querySelector('.zo-r1-roster');
		const statusEl = game.querySelector('.zo-r1-status');
		const pageLabelEl = game.querySelector('.zo-r1-page-label');
		const totalEl = game.querySelector('.zo-r1-total');
		const jumpInput = game.querySelector('.zo-r1-jump-input');
		const jumpButton = game.querySelector('.zo-r1-jump-btn');

		const coinsEl = game.querySelector('.zo-r1-coins');
		const levelEl = game.querySelector('.zo-r1-level');
		const enemiesEl = game.querySelector('.zo-r1-enemies');
		const heroEl = game.querySelector('.zo-r1-hero');
		const winsEl = game.querySelector('.zo-r1-wins');

		const WIDTH = 760;
		const HEIGHT = 520;
		const HERO_RADIUS = 15;
		const ENEMY_RADIUS = 12;
		const PAGE_SIZE = 12;
		const TOTAL_CHARACTERS = 1000;
		const REWARD_PER_WIN = 50;

		canvas.width = WIDTH;
		canvas.height = HEIGHT;

		const archetypes = [
			{name: 'Spark', speed: 1.35, power: 0.82, rate: 1.25, aura: '#fde047', bio: 'Fast feet and quick shots.'},
			{name: 'Shield', speed: 0.9, power: 1.05, rate: 0.86, aura: '#93c5fd', bio: 'Stays alive longer in rough waves.'},
			{name: 'Nova', speed: 1.08, power: 1.18, rate: 0.94, aura: '#fca5a5', bio: 'Big hits with steady control.'},
			{name: 'Echo', speed: 1.16, power: 0.94, rate: 1.12, aura: '#c4b5fd', bio: 'Balanced arena duelist.'},
			{name: 'Bloom', speed: 1.02, power: 0.9, rate: 1.3, aura: '#86efac', bio: 'Rapid fire pressure specialist.'},
			{name: 'Stone', speed: 0.84, power: 1.28, rate: 0.8, aura: '#fdba74', bio: 'Slow, tough, and heavy-handed.'}
		];

		const state = {
			running: false,
			levelActive: false,
			gameOver: false,
			coins: 150,
			level: 1,
			wins: 0,
			page: 0,
			lastTime: 0,
			selectedId: 1,
			owned: {1: true},
			keys: {
				up: false,
				down: false,
				left: false,
				right: false
			},
			hero: null,
			enemies: [],
			projectiles: [],
			spawnTimer: 0,
			spawned: 0,
			targetEnemyCount: 0,
			touchTarget: null
		};

		function getCharacter(id) {
			const seed = id - 1;
			const archetype = archetypes[seed % archetypes.length];
			const tier = Math.floor(seed / 200) + 1;
			const tierBoost = tier * 0.12;
			const power = +(8 + ((seed % 9) * 1.2) + (tierBoost * 4) + (archetype.power * 4)).toFixed(1);
			const speed = +(2.1 + ((seed % 7) * 0.12) + (archetype.speed * 0.85)).toFixed(2);
			const fireRate = +(0.45 + ((seed % 5) * 0.06) + (archetype.rate * 0.3)).toFixed(2);
			const hp = Math.round(90 + ((seed % 11) * 8) + (tierBoost * 55) + (archetype.power * 18));
			const price = id === 1 ? 0 : Math.round(90 + (tier * 55) + ((seed % 25) * 13) + (id * 0.8));
			return {
				id: id,
				name: archetype.name + ' #' + String(id),
				tier: 'Tier ' + String(tier),
				power: power,
				speed: speed,
				fireRate: fireRate,
				hp: hp,
				price: price,
				color: archetype.aura,
				bio: archetype.bio
			};
		}

		function setStatus(text) {
			statusEl.textContent = text;
		}

		function clamp(value, min, max) {
			return Math.max(min, Math.min(max, value));
		}

		function updateHud() {
			coinsEl.textContent = String(state.coins);
			levelEl.textContent = String(state.level);
			enemiesEl.textContent = String(Math.max(0, state.enemies.length));
			heroEl.textContent = getCharacter(state.selectedId).name;
			winsEl.textContent = String(state.wins);
			pageLabelEl.textContent = 'Page ' + String(state.page + 1) + ' / ' + String(Math.ceil(TOTAL_CHARACTERS / PAGE_SIZE));
			totalEl.textContent = 'Showing heroes ' + String((state.page * PAGE_SIZE) + 1) + '-' + String(Math.min(TOTAL_CHARACTERS, ((state.page + 1) * PAGE_SIZE))) + ' of ' + String(TOTAL_CHARACTERS);
		}

		function createHero() {
			const character = getCharacter(state.selectedId);
			return {
				x: WIDTH / 2,
				y: HEIGHT / 2,
				radius: HERO_RADIUS,
				speed: character.speed * 2.2,
				maxHp: character.hp,
				hp: character.hp,
				damage: character.power,
				fireInterval: Math.max(0.18, 1.4 - (character.fireRate * 0.38)),
				cooldown: 0,
				color: character.color
			};
		}

		function enemyGoalCount(level) {
			return 3 + level;
		}

		function createEnemy(index) {
			const side = Math.floor(Math.random() * 4);
			let x = 0;
			let y = 0;

			if (side === 0) {
				x = 18;
				y = Math.random() * HEIGHT;
			} else if (side === 1) {
				x = WIDTH - 18;
				y = Math.random() * HEIGHT;
			} else if (side === 2) {
				x = Math.random() * WIDTH;
				y = 18;
			} else {
				x = Math.random() * WIDTH;
				y = HEIGHT - 18;
			}

			const base = 28 + (state.level * 7);
			const variance = (index % 5) * 4;
			const aiLevel = 1 + (state.level * 0.03);
			return {
				x: x,
				y: y,
				radius: ENEMY_RADIUS + ((state.level % 4 === 0 && index % 3 === 0) ? 3 : 0),
				hp: base + variance,
				maxHp: base + variance,
				speed: 0.72 + (state.level * 0.028) + ((index % 4) * 0.05),
				damage: 9 + Math.floor(state.level * 0.45),
				cooldown: Math.max(0.55, 1.9 - (state.level * 0.014)),
				reload: Math.max(0.55, 1.9 - (state.level * 0.014)),
				strafe: ((index % 2 === 0) ? 1 : -1) * aiLevel,
				color: state.level % 2 === 0 ? '#fb7185' : '#f97316'
			};
		}

		function resetForSelectedHero(fullReset) {
			state.running = false;
			state.levelActive = false;
			state.gameOver = false;
			state.lastTime = 0;
			state.hero = createHero();
			state.enemies = [];
			state.projectiles = [];
			state.spawnTimer = 0;
			state.spawned = 0;
			state.targetEnemyCount = enemyGoalCount(state.level);
			state.touchTarget = null;

			if (fullReset) {
				state.level = 1;
				state.wins = 0;
				state.coins = 150;
				state.targetEnemyCount = enemyGoalCount(state.level);
			}

			updateHud();
			renderRoster();
			setStatus('Pick or buy a character, then press Start. Each cleared wave gives 50 coins.');
			draw();
		}

		function beginLevel() {
			if (state.gameOver) {
				return;
			}

			state.running = true;
			state.levelActive = true;
			state.lastTime = performance.now();
			setStatus('Level ' + state.level + ' started. Enemies get tougher and more numerous every wave.');
			window.requestAnimationFrame(loop);
		}

		function nextLevel() {
			state.running = false;
			state.levelActive = false;
			state.level += 1;
			state.wins += 1;
			state.coins += REWARD_PER_WIN;
			state.hero = createHero();
			state.enemies = [];
			state.projectiles = [];
			state.spawnTimer = 0;
			state.spawned = 0;
			state.targetEnemyCount = enemyGoalCount(state.level);
			updateHud();
			renderRoster();
			setStatus('Wave cleared. You earned 50 coins. Press Next Wave when you are ready for level ' + state.level + '.');
			draw();
		}

		function loseGame() {
			state.running = false;
			state.levelActive = false;
			state.gameOver = true;
			setStatus('Your hero was defeated on level ' + state.level + '. Buy a stronger character or restart the run.');
			draw();
		}

		function tryBuyCharacter(id) {
			const character = getCharacter(id);
			if (state.owned[id]) {
				state.selectedId = id;
				state.hero = createHero();
				updateHud();
				renderRoster();
				setStatus(character.name + ' is now selected.');
				draw();
				return;
			}

			if (state.coins < character.price) {
				setStatus('Not enough coins for ' + character.name + '. Win more waves to earn 50 coins each time.');
				return;
			}

			state.coins -= character.price;
			state.owned[id] = true;
			state.selectedId = id;
			state.hero = createHero();
			updateHud();
			renderRoster();
			setStatus('Bought ' + character.name + ' for ' + character.price + ' coins.');
			draw();
		}

		function renderRoster() {
			const start = state.page * PAGE_SIZE;
			const end = Math.min(TOTAL_CHARACTERS, start + PAGE_SIZE);
			let html = '';

			for (let i = start + 1; i <= end; i++) {
				const character = getCharacter(i);
				const owned = !!state.owned[i];
				const selected = state.selectedId === i;
				const classes = ['zo-r1-card'];

				if (owned) {
					classes.push('is-owned');
				}
				if (selected) {
					classes.push('is-selected');
				}

				html += ''
					+ '<div class="' + classes.join(' ') + '">'
					+ '<div class="zo-r1-card-top">'
					+ '<div class="zo-r1-card-name">' + character.name + '</div>'
					+ '<div class="zo-r1-card-badge">' + character.tier + '</div>'
					+ '</div>'
					+ '<div class="zo-r1-card-stats">'
					+ '<div class="zo-r1-mini"><strong>' + character.hp + '</strong><span>HP</span></div>'
					+ '<div class="zo-r1-mini"><strong>' + character.power + '</strong><span>Power</span></div>'
					+ '<div class="zo-r1-mini"><strong>' + character.speed + '</strong><span>Speed</span></div>'
					+ '<div class="zo-r1-mini"><strong>' + character.fireRate + '</strong><span>Rapid</span></div>'
					+ '</div>'
					+ '<p class="zo-r1-card-text">' + character.bio + ' Cost: ' + character.price + ' coins.</p>'
					+ '<div class="zo-r1-card-actions">'
					+ '<button type="button" class="zo-r1-btn zo-r1-btn--secondary zo-r1-card-action" data-id="' + character.id + '">'
					+ (owned ? (selected ? 'Selected' : 'Select') : 'Buy')
					+ '</button>'
					+ '</div>'
					+ '</div>';
			}

			rosterEl.innerHTML = html;

			rosterEl.querySelectorAll('.zo-r1-card-action').forEach(function (button) {
				button.addEventListener('click', function () {
					const id = parseInt(button.getAttribute('data-id') || '0', 10);
					if (id > 0) {
						tryBuyCharacter(id);
					}
				});
			});
		}

		function jumpToHero() {
			const id = parseInt(jumpInput.value || '0', 10);
			if (id < 1 || id > TOTAL_CHARACTERS) {
				setStatus('Enter a hero number from 1 to 1000.');
				return;
			}

			state.page = Math.floor((id - 1) / PAGE_SIZE);
			renderRoster();
			updateHud();
			setStatus('Jumped to hero #' + String(id) + '.');
		}

		function fireProjectile(from, target, damage, color, speed, friendly) {
			const dx = target.x - from.x;
			const dy = target.y - from.y;
			const distance = Math.max(1, Math.sqrt((dx * dx) + (dy * dy)));
			state.projectiles.push({
				x: from.x,
				y: from.y,
				vx: (dx / distance) * speed,
				vy: (dy / distance) * speed,
				damage: damage,
				color: color,
				friendly: friendly,
				life: 1.6
			});
		}

		function nearestEnemy() {
			let best = null;
			let bestDistance = Infinity;

			state.enemies.forEach(function (enemy) {
				const dx = enemy.x - state.hero.x;
				const dy = enemy.y - state.hero.y;
				const distance = Math.sqrt((dx * dx) + (dy * dy));
				if (distance < bestDistance) {
					best = enemy;
					bestDistance = distance;
				}
			});

			return best;
		}

		function updateHero(delta) {
			let moveX = 0;
			let moveY = 0;

			if (state.keys.left) {
				moveX -= 1;
			}
			if (state.keys.right) {
				moveX += 1;
			}
			if (state.keys.up) {
				moveY -= 1;
			}
			if (state.keys.down) {
				moveY += 1;
			}

			if (state.touchTarget) {
				const dx = state.touchTarget.x - state.hero.x;
				const dy = state.touchTarget.y - state.hero.y;
				const distance = Math.sqrt((dx * dx) + (dy * dy));
				if (distance > 10) {
					moveX += dx / distance;
					moveY += dy / distance;
				}
			}

			if (moveX !== 0 || moveY !== 0) {
				const norm = Math.sqrt((moveX * moveX) + (moveY * moveY));
				state.hero.x += (moveX / norm) * state.hero.speed * 60 * delta;
				state.hero.y += (moveY / norm) * state.hero.speed * 60 * delta;
			}

			state.hero.x = clamp(state.hero.x, state.hero.radius, WIDTH - state.hero.radius);
			state.hero.y = clamp(state.hero.y, state.hero.radius, HEIGHT - state.hero.radius);

			state.hero.cooldown -= delta;
			const target = nearestEnemy();
			if (target && state.hero.cooldown <= 0) {
				fireProjectile(state.hero, target, state.hero.damage, state.hero.color, 6.4, true);
				state.hero.cooldown = state.hero.fireInterval;
			}
		}

		function updateEnemySpawns(delta) {
			if (state.spawned >= state.targetEnemyCount) {
				return;
			}

			state.spawnTimer -= delta;
			if (state.spawnTimer > 0) {
				return;
			}

			state.enemies.push(createEnemy(state.spawned));
			state.spawned += 1;
			state.spawnTimer = Math.max(0.18, 0.8 - (state.level * 0.012));
		}

		function updateEnemies(delta) {
			for (let i = state.enemies.length - 1; i >= 0; i--) {
				const enemy = state.enemies[i];
				const dx = state.hero.x - enemy.x;
				const dy = state.hero.y - enemy.y;
				const distance = Math.max(1, Math.sqrt((dx * dx) + (dy * dy)));
				const orbitX = -dy / distance;
				const orbitY = dx / distance;

				enemy.x += ((dx / distance) * enemy.speed + (orbitX * 0.22 * enemy.strafe)) * 60 * delta;
				enemy.y += ((dy / distance) * enemy.speed + (orbitY * 0.22 * enemy.strafe)) * 60 * delta;

				enemy.x = clamp(enemy.x, enemy.radius, WIDTH - enemy.radius);
				enemy.y = clamp(enemy.y, enemy.radius, HEIGHT - enemy.radius);

				enemy.cooldown -= delta;
				if (distance < 140 && enemy.cooldown <= 0) {
					fireProjectile(enemy, state.hero, enemy.damage, '#fecaca', 4.8 + (state.level * 0.03), false);
					enemy.cooldown = enemy.reload;
				}

				if (distance < enemy.radius + state.hero.radius + 4) {
					state.hero.hp -= enemy.damage * 0.35 * delta * 60;
				}

				if (enemy.hp <= 0) {
					state.enemies.splice(i, 1);
				}
			}
		}

		function updateProjectiles(delta) {
			for (let i = state.projectiles.length - 1; i >= 0; i--) {
				const projectile = state.projectiles[i];
				projectile.x += projectile.vx * 60 * delta;
				projectile.y += projectile.vy * 60 * delta;
				projectile.life -= delta;

				if (projectile.life <= 0 || projectile.x < -20 || projectile.x > WIDTH + 20 || projectile.y < -20 || projectile.y > HEIGHT + 20) {
					state.projectiles.splice(i, 1);
					continue;
				}

				if (projectile.friendly) {
					let hitEnemy = null;
					for (let j = 0; j < state.enemies.length; j++) {
						const enemy = state.enemies[j];
						const dx = projectile.x - enemy.x;
						const dy = projectile.y - enemy.y;
						if ((dx * dx) + (dy * dy) <= Math.pow(enemy.radius + 4, 2)) {
							hitEnemy = enemy;
							break;
						}
					}

					if (hitEnemy) {
						hitEnemy.hp -= projectile.damage;
						state.projectiles.splice(i, 1);
						continue;
					}
				} else {
					const hx = projectile.x - state.hero.x;
					const hy = projectile.y - state.hero.y;
					if ((hx * hx) + (hy * hy) <= Math.pow(state.hero.radius + 4, 2)) {
						state.hero.hp -= projectile.damage;
						state.projectiles.splice(i, 1);
					}
				}
			}
		}

		function drawArenaBackground() {
			ctx.clearRect(0, 0, WIDTH, HEIGHT);

			const gridSize = 38;
			ctx.fillStyle = '#10233d';
			ctx.fillRect(0, 0, WIDTH, HEIGHT);
			ctx.strokeStyle = 'rgba(147, 197, 253, 0.08)';
			ctx.lineWidth = 1;

			for (let x = 0; x < WIDTH; x += gridSize) {
				ctx.beginPath();
				ctx.moveTo(x, 0);
				ctx.lineTo(x, HEIGHT);
				ctx.stroke();
			}

			for (let y = 0; y < HEIGHT; y += gridSize) {
				ctx.beginPath();
				ctx.moveTo(0, y);
				ctx.lineTo(WIDTH, y);
				ctx.stroke();
			}
		}

		function drawHero() {
			const hero = state.hero;
			ctx.beginPath();
			ctx.fillStyle = hero.color;
			ctx.arc(hero.x, hero.y, hero.radius, 0, Math.PI * 2);
			ctx.fill();

			ctx.strokeStyle = '#ffffff';
			ctx.lineWidth = 2;
			ctx.stroke();

			ctx.fillStyle = '#ffffff';
			ctx.fillRect(hero.x - 22, hero.y - 28, 44, 6);
			ctx.fillStyle = '#22c55e';
			ctx.fillRect(hero.x - 22, hero.y - 28, 44 * Math.max(0, hero.hp / hero.maxHp), 6);
		}

		function drawEnemies() {
			state.enemies.forEach(function (enemy) {
				ctx.beginPath();
				ctx.fillStyle = enemy.color;
				ctx.arc(enemy.x, enemy.y, enemy.radius, 0, Math.PI * 2);
				ctx.fill();

				ctx.strokeStyle = '#fff7ed';
				ctx.lineWidth = 2;
				ctx.stroke();

				ctx.fillStyle = '#ffffff';
				ctx.fillRect(enemy.x - 18, enemy.y - 24, 36, 5);
				ctx.fillStyle = '#fb7185';
				ctx.fillRect(enemy.x - 18, enemy.y - 24, 36 * Math.max(0, enemy.hp / enemy.maxHp), 5);
			});
		}

		function drawProjectiles() {
			state.projectiles.forEach(function (projectile) {
				ctx.beginPath();
				ctx.fillStyle = projectile.color;
				ctx.arc(projectile.x, projectile.y, projectile.friendly ? 4 : 5, 0, Math.PI * 2);
				ctx.fill();
			});
		}

		function drawOverlay() {
			if (state.running) {
				return;
			}

			ctx.fillStyle = 'rgba(7, 16, 28, 0.28)';
			ctx.fillRect(0, 0, WIDTH, HEIGHT);
			ctx.fillStyle = '#ffffff';
			ctx.textAlign = 'center';

			if (state.gameOver) {
				ctx.font = 'bold 36px Arial';
				ctx.fillText('Run Over', WIDTH / 2, HEIGHT / 2 - 8);
				ctx.font = '20px Arial';
				ctx.fillText('Restart or buy a stronger fighter from the roster.', WIDTH / 2, HEIGHT / 2 + 28);
				return;
			}

			ctx.font = 'bold 34px Arial';
			ctx.fillText('Roster 1000 Arena', WIDTH / 2, HEIGHT / 2 - 8);
			ctx.font = '20px Arial';
			ctx.fillText(state.level === 1 ? 'Press Start to begin your run.' : 'Press Next Wave to continue to level ' + state.level + '.', WIDTH / 2, HEIGHT / 2 + 28);
		}

		function draw() {
			drawArenaBackground();
			drawProjectiles();
			drawEnemies();
			drawHero();
			drawOverlay();
		}

		function update(delta) {
			updateHero(delta);
			updateEnemySpawns(delta);
			updateEnemies(delta);
			updateProjectiles(delta);

			if (state.hero.hp <= 0) {
				state.hero.hp = 0;
				updateHud();
				loseGame();
				return;
			}

			if (state.spawned >= state.targetEnemyCount && state.enemies.length === 0) {
				updateHud();
				nextLevel();
				return;
			}

			updateHud();
		}

		function loop(timestamp) {
			if (!state.running) {
				draw();
				return;
			}

			const delta = Math.min(0.033, (timestamp - state.lastTime) / 1000);
			state.lastTime = timestamp;
			update(delta);
			draw();

			if (state.running) {
				window.requestAnimationFrame(loop);
			}
		}

		function updateKeyState(isDown, key) {
			if (key === 'ArrowUp' || key === 'w' || key === 'W') {
				state.keys.up = isDown;
			}
			if (key === 'ArrowDown' || key === 's' || key === 'S') {
				state.keys.down = isDown;
			}
			if (key === 'ArrowLeft' || key === 'a' || key === 'A') {
				state.keys.left = isDown;
			}
			if (key === 'ArrowRight' || key === 'd' || key === 'D') {
				state.keys.right = isDown;
			}
		}

		game.addEventListener('keydown', function (event) {
			updateKeyState(true, event.key);
			if (/Arrow|w|a|s|d|W|A|S|D/.test(event.key)) {
				event.preventDefault();
			}
		});

		game.addEventListener('keyup', function (event) {
			updateKeyState(false, event.key);
		});

		canvas.addEventListener('pointerdown', function (event) {
			const rect = canvas.getBoundingClientRect();
			state.touchTarget = {
				x: (event.clientX - rect.left) * (WIDTH / rect.width),
				y: (event.clientY - rect.top) * (HEIGHT / rect.height)
			};
			game.focus();
		});

		canvas.addEventListener('pointermove', function (event) {
			if (!state.touchTarget) {
				return;
			}
			const rect = canvas.getBoundingClientRect();
			state.touchTarget = {
				x: (event.clientX - rect.left) * (WIDTH / rect.width),
				y: (event.clientY - rect.top) * (HEIGHT / rect.height)
			};
		});

		canvas.addEventListener('pointerup', function () {
			state.touchTarget = null;
		});

		canvas.addEventListener('pointerleave', function () {
			state.touchTarget = null;
		});

		game.querySelectorAll('.zo-r1-move').forEach(function (button) {
			const dir = button.getAttribute('data-dir');
			button.addEventListener('pointerdown', function () {
				state.keys[dir] = true;
				game.focus();
			});
			button.addEventListener('pointerup', function () {
				state.keys[dir] = false;
			});
			button.addEventListener('pointerleave', function () {
				state.keys[dir] = false;
			});
		});

		startButton.addEventListener('click', function () {
			if (!state.levelActive && !state.gameOver) {
				beginLevel();
				game.focus();
			}
		});

		nextButton.addEventListener('click', function () {
			if (!state.levelActive && !state.gameOver && state.level > 1) {
				beginLevel();
				game.focus();
			}
		});

		restartButton.addEventListener('click', function () {
			state.selectedId = 1;
			state.owned = {1: true};
			state.page = 0;
			resetForSelectedHero(true);
			game.focus();
		});

		prevPageButton.addEventListener('click', function () {
			state.page = Math.max(0, state.page - 1);
			renderRoster();
			updateHud();
		});

		nextPageButton.addEventListener('click', function () {
			state.page = Math.min(Math.ceil(TOTAL_CHARACTERS / PAGE_SIZE) - 1, state.page + 1);
			renderRoster();
			updateHud();
		});

		jumpButton.addEventListener('click', function () {
			jumpToHero();
		});

		jumpInput.addEventListener('keydown', function (event) {
			if (event.key === 'Enter') {
				event.preventDefault();
				jumpToHero();
			}
		});

		resetForSelectedHero(true);
		game.setAttribute('tabindex', '0');
	});
});
JS;

if (!function_exists('zo_game_roster_1000_render')) {
	function zo_game_roster_1000_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-roster-1000-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--roster-1000" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-r1-shell">
				<h2 class="zo-r1-title">Roster 1000</h2>
				<p class="zo-r1-subtitle">Fight through endless arena waves, earn 50 coins for every win, and grow your team by buying from a generated roster of 1000 heroes. Higher levels send more enemies with smarter movement and stronger attacks.</p>

				<div class="zo-r1-topbar">
					<div class="zo-r1-stats">
						<div class="zo-r1-stat-grid">
							<div class="zo-r1-stat">
								<span class="zo-r1-stat-label">Coins</span>
								<span class="zo-r1-stat-value zo-r1-coins">150</span>
							</div>
							<div class="zo-r1-stat">
								<span class="zo-r1-stat-label">Level</span>
								<span class="zo-r1-stat-value zo-r1-level">1</span>
							</div>
							<div class="zo-r1-stat">
								<span class="zo-r1-stat-label">Enemies</span>
								<span class="zo-r1-stat-value zo-r1-enemies">0</span>
							</div>
							<div class="zo-r1-stat">
								<span class="zo-r1-stat-label">Hero</span>
								<span class="zo-r1-stat-value zo-r1-stat-value--hero zo-r1-hero">Spark #1</span>
							</div>
							<div class="zo-r1-stat">
								<span class="zo-r1-stat-label">Wins</span>
								<span class="zo-r1-stat-value zo-r1-wins">0</span>
							</div>
						</div>
					</div>

					<div class="zo-r1-controls">
						<div class="zo-r1-button-row">
							<button type="button" class="zo-r1-btn zo-r1-btn--primary zo-r1-start">Start</button>
							<button type="button" class="zo-r1-btn zo-r1-btn--secondary zo-r1-next">Next Wave</button>
							<button type="button" class="zo-r1-btn zo-r1-btn--warn zo-r1-restart">Restart Run</button>
						</div>
						<div class="zo-r1-pad">
							<button type="button" class="zo-r1-btn zo-r1-move" data-dir="up">Up</button>
							<button type="button" class="zo-r1-btn zo-r1-move" data-dir="left">Left</button>
							<button type="button" class="zo-r1-btn zo-r1-move" data-dir="down">Down</button>
							<button type="button" class="zo-r1-btn zo-r1-move" data-dir="right">Right</button>
						</div>
						<div class="zo-r1-help">Use arrow keys or WASD on desktop. On mobile, tap the arena to move toward that point or use the move buttons. Clear each wave to earn 50 coins, then buy stronger characters.</div>
					</div>
				</div>

				<div class="zo-r1-layout">
					<div class="zo-r1-arena-wrap">
						<canvas class="zo-r1-canvas" width="760" height="520" aria-label="Roster 1000 arena"></canvas>
						<div class="zo-r1-status" aria-live="polite">Pick or buy a character, then press Start. Each cleared wave gives 50 coins.</div>
					</div>

					<div class="zo-r1-side">
						<div class="zo-r1-side-head">
							<h3 class="zo-r1-side-title">1000 Hero Shop</h3>
							<div class="zo-r1-button-row">
								<button type="button" class="zo-r1-page-btn zo-r1-prev-page">Prev</button>
								<span class="zo-r1-page-label">Page 1 / 84</span>
								<button type="button" class="zo-r1-page-btn zo-r1-next-page">Next</button>
							</div>
						</div>

						<div class="zo-r1-shop-meta">
							<div class="zo-r1-total">Showing heroes 1-12 of 1000</div>
							<div class="zo-r1-jump">
								<input type="number" min="1" max="1000" step="1" class="zo-r1-input zo-r1-jump-input" placeholder="Hero #" aria-label="Jump to hero number">
								<button type="button" class="zo-r1-btn zo-r1-btn--secondary zo-r1-jump-btn">Go</button>
							</div>
						</div>

						<div class="zo-r1-roster"></div>
					</div>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'roster-1000',
	'name'            => 'Roster 1000',
	'author'          => 'Asker',
	'description'     => 'An endless arena game with 1000 buyable characters, harder AI every level, more enemies per wave, and 50 coins for every win.',
	'render_callback' => 'zo_game_roster_1000_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
