<?php

if (!defined('ABSPATH')) {
	exit;
}

$inline_style = <<<'CSS'
.zo-game-root--base-defense * {
	box-sizing: border-box;
}

.zo-game-root--base-defense {
	max-width: 1120px;
	margin: 0 auto;
	padding: 16px;
	font-family: Arial, sans-serif;
	color: #1f2937;
}

.zo-game-root--base-defense .zo-bd-wrap {
	background: #ffffff;
	border: 1px solid #dbe3ea;
	border-radius: 22px;
	padding: 18px;
	box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
}

.zo-game-root--base-defense .zo-bd-title {
	margin: 0 0 8px;
	text-align: center;
	font-size: 32px;
	line-height: 1.2;
	color: #0f172a;
}

.zo-game-root--base-defense .zo-bd-subtitle {
	margin: 0 0 18px;
	text-align: center;
	font-size: 15px;
	line-height: 1.5;
	color: #475569;
}

.zo-game-root--base-defense .zo-bd-topbar {
	display: flex;
	flex-wrap: wrap;
	gap: 12px;
	justify-content: space-between;
	align-items: center;
	margin-bottom: 16px;
}

.zo-game-root--base-defense .zo-bd-stats {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
}

.zo-game-root--base-defense .zo-bd-stat {
	background: #f3f6fa;
	border: 1px solid #dbe3ea;
	border-radius: 12px;
	padding: 10px 14px;
	font-size: 14px;
	font-weight: 700;
}

.zo-game-root--base-defense .zo-bd-controls {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	align-items: center;
}

.zo-game-root--base-defense .zo-bd-btn,
.zo-game-root--base-defense .zo-bd-select {
	border-radius: 12px;
	border: 1px solid #cfd8e3;
	font: inherit;
	font-size: 15px;
}

.zo-game-root--base-defense .zo-bd-btn {
	padding: 10px 16px;
	font-weight: 700;
	cursor: pointer;
	background: #ffffff;
	color: #1f2937;
}

.zo-game-root--base-defense .zo-bd-btn--primary {
	background: #2563eb;
	border-color: #2563eb;
	color: #ffffff;
}

.zo-game-root--base-defense .zo-bd-btn--danger {
	background: #ef4444;
	border-color: #ef4444;
	color: #ffffff;
}

.zo-game-root--base-defense .zo-bd-select {
	padding: 10px 12px;
	background: #ffffff;
	color: #1f2937;
}

.zo-game-root--base-defense .zo-bd-layout {
	display: grid;
	grid-template-columns: 1fr 300px;
	gap: 16px;
}

.zo-game-root--base-defense .zo-bd-board-wrap {
	background: #f8fafc;
	border: 1px solid #dbe3ea;
	border-radius: 18px;
	padding: 12px;
}

.zo-game-root--base-defense .zo-bd-canvas {
	display: block;
	width: 100%;
	height: auto;
	background: linear-gradient(180deg, #dbeafe 0%, #dcfce7 100%);
	border: 1px solid #cfd8e3;
	border-radius: 14px;
	cursor: crosshair;
	touch-action: none;
}

.zo-game-root--base-defense .zo-bd-side {
	background: #f8fafc;
	border: 1px solid #dbe3ea;
	border-radius: 18px;
	padding: 14px;
}

.zo-game-root--base-defense .zo-bd-side h3 {
	margin: 0 0 10px;
	font-size: 18px;
	color: #0f172a;
}

.zo-game-root--base-defense .zo-bd-side p,
.zo-game-root--base-defense .zo-bd-side li {
	font-size: 14px;
	line-height: 1.5;
	color: #475569;
}

.zo-game-root--base-defense .zo-bd-side ul {
	margin: 0 0 14px;
	padding-left: 18px;
}

.zo-game-root--base-defense .zo-bd-card-list {
	display: grid;
	grid-template-columns: 1fr;
	gap: 10px;
	margin-bottom: 14px;
}

.zo-game-root--base-defense .zo-bd-card {
	border: 1px solid #dbe3ea;
	background: #ffffff;
	border-radius: 14px;
	padding: 10px;
}

.zo-game-root--base-defense .zo-bd-card-title {
	font-size: 15px;
	font-weight: 800;
	color: #0f172a;
	margin-bottom: 4px;
}

.zo-game-root--base-defense .zo-bd-card-text {
	font-size: 13px;
	line-height: 1.45;
	color: #475569;
}

.zo-game-root--base-defense .zo-bd-message {
	margin-top: 12px;
	padding: 12px 14px;
	border-radius: 12px;
	background: #eff6ff;
	border: 1px solid #bfdbfe;
	font-size: 14px;
	font-weight: 700;
	color: #1d4ed8;
	min-height: 48px;
}

@media (max-width: 920px) {
	.zo-game-root--base-defense .zo-bd-layout {
		grid-template-columns: 1fr;
	}
}

@media (max-width: 640px) {
	.zo-game-root--base-defense {
		padding: 10px;
	}

	.zo-game-root--base-defense .zo-bd-wrap {
		padding: 12px;
	}

	.zo-game-root--base-defense .zo-bd-title {
		font-size: 26px;
	}
}
CSS;

$inline_script = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const roots = document.querySelectorAll('.zo-game-root--base-defense');

	roots.forEach(function (root) {
		const canvas = root.querySelector('.zo-bd-canvas');
		if (!canvas) {
			return;
		}

		const ctx = canvas.getContext('2d');
		const startButton = root.querySelector('.zo-bd-start');
		const restartButton = root.querySelector('.zo-bd-restart');
		const speedSelect = root.querySelector('.zo-bd-select');
		const goldEl = root.querySelector('.zo-bd-gold');
		const waveEl = root.querySelector('.zo-bd-wave');
		const playerBaseEl = root.querySelector('.zo-bd-player-base');
		const enemyBaseEl = root.querySelector('.zo-bd-enemy-base');
		const selectedTowerEl = root.querySelector('.zo-bd-selected-tower');
		const messageEl = root.querySelector('.zo-bd-message');

		const WIDTH = 860;
		const HEIGHT = 460;
		const LANE_Y = [130, 230, 330];
		const TILE_SIZE = 44;

		const towerDefs = {
			arrow: {
				key: 'arrow',
				name: 'Arrow Tower',
				cost: 40,
				range: 150,
				damage: 10,
				cooldownMax: 28,
				color: '#2563eb'
			},
			cannon: {
				key: 'cannon',
				name: 'Cannon Tower',
				cost: 70,
				range: 120,
				damage: 22,
				cooldownMax: 48,
				color: '#ef4444'
			},
			frost: {
				key: 'frost',
				name: 'Frost Tower',
				cost: 60,
				range: 135,
				damage: 8,
				cooldownMax: 36,
				color: '#06b6d4',
				slow: 0.55,
				slowTicks: 65
			}
		};

		const unitDefs = {
			grunt: {
				key: 'grunt',
				hp: 42,
				speed: 0.70,
				damage: 7,
				color: '#f59e0b',
				reward: 10,
				size: 24
			},
			tank: {
				key: 'tank',
				hp: 90,
				speed: 0.42,
				damage: 12,
				color: '#7c3aed',
				reward: 18,
				size: 30
			},
			runner: {
				key: 'runner',
				hp: 24,
				speed: 1.05,
				damage: 5,
				color: '#22c55e',
				reward: 8,
				size: 20
			}
		};

		const buildSpots = [
			{x: 180, y: 80, lane: 0},
			{x: 320, y: 80, lane: 0},
			{x: 460, y: 80, lane: 0},
			{x: 250, y: 180, lane: 1},
			{x: 390, y: 180, lane: 1},
			{x: 530, y: 180, lane: 1},
			{x: 180, y: 380, lane: 2},
			{x: 320, y: 380, lane: 2},
			{x: 460, y: 380, lane: 2}
		];

		const state = {
			running: false,
			gameOver: false,
			lastTime: 0,
			gameSpeed: 1,
			gold: 120,
			wave: 1,
			playerBaseHp: 240,
			enemyBaseHp: 240,
			selectedTower: 'arrow',
			towers: [],
			enemies: [],
			projectiles: [],
			spawnQueue: [],
			spawnTimer: 0,
			enemyAttackTimer: 0,
			playerAttackTimer: 0,
			winner: ''
		};

		function setMessage(text) {
			messageEl.textContent = text;
		}

		function clamp(value, min, max) {
			return Math.max(min, Math.min(max, value));
		}

		function updateStats() {
			goldEl.textContent = String(Math.floor(state.gold));
			waveEl.textContent = String(state.wave);
			playerBaseEl.textContent = String(Math.max(0, Math.floor(state.playerBaseHp)));
			enemyBaseEl.textContent = String(Math.max(0, Math.floor(state.enemyBaseHp)));
			selectedTowerEl.textContent = towerDefs[state.selectedTower].name;
		}

		function resetGame() {
			state.running = false;
			state.gameOver = false;
			state.lastTime = 0;
			state.gameSpeed = parseFloat(speedSelect.value || '1') || 1;
			state.gold = 120;
			state.wave = 1;
			state.playerBaseHp = 240;
			state.enemyBaseHp = 240;
			state.selectedTower = 'arrow';
			state.towers = [];
			state.enemies = [];
			state.projectiles = [];
			state.spawnQueue = [];
			state.spawnTimer = 0;
			state.enemyAttackTimer = 0;
			state.playerAttackTimer = 0;
			state.winner = '';
			prepareWave(state.wave);
			updateStats();
			setMessage('Press Start. Place towers on the gray pads.');
			draw();
		}

		function prepareWave(wave) {
			state.spawnQueue = [];
			const count = 6 + (wave * 2);

			for (let i = 0; i < count; i++) {
				let typeKey = 'grunt';

				if (wave >= 2 && i % 4 === 0) {
					typeKey = 'runner';
				}
				if (wave >= 3 && i % 5 === 0) {
					typeKey = 'tank';
				}

				state.spawnQueue.push({
					typeKey: typeKey,
					lane: i % 3
				});
			}
		}

		function getSpotAt(x, y) {
			for (let i = 0; i < buildSpots.length; i++) {
				const spot = buildSpots[i];
				const dx = x - spot.x;
				const dy = y - spot.y;
				if (Math.sqrt((dx * dx) + (dy * dy)) <= 22) {
					return spot;
				}
			}
			return null;
		}

		function isSpotOccupied(spot) {
			for (let i = 0; i < state.towers.length; i++) {
				if (state.towers[i].spotIndex === buildSpots.indexOf(spot)) {
					return true;
				}
			}
			return false;
		}

		function buildTower(spot) {
			const def = towerDefs[state.selectedTower];
			if (!def) {
				return;
			}

			if (isSpotOccupied(spot)) {
				setMessage('That build spot is already used.');
				return;
			}

			if (state.gold < def.cost) {
				setMessage('Not enough gold for ' + def.name + '.');
				return;
			}

			state.gold -= def.cost;
			state.towers.push({
				typeKey: def.key,
				x: spot.x,
				y: spot.y,
				lane: spot.lane,
				cooldown: 0,
				spotIndex: buildSpots.indexOf(spot)
			});
			updateStats();
			setMessage(def.name + ' built.');
		}

		function spawnEnemy() {
			if (!state.spawnQueue.length) {
				return;
			}

			const next = state.spawnQueue.shift();
			const def = unitDefs[next.typeKey];
			if (!def) {
				return;
			}

			state.enemies.push({
				typeKey: next.typeKey,
				lane: next.lane,
				x: WIDTH - 115,
				y: LANE_Y[next.lane],
				hp: def.hp,
				maxHp: def.hp,
				speed: def.speed,
				damage: def.damage,
				color: def.color,
				reward: def.reward,
				size: def.size,
				slowTicks: 0,
				slowFactor: 1
			});
		}

		function createProjectile(fromX, fromY, target, def) {
			state.projectiles.push({
				x: fromX,
				y: fromY,
				target: target,
				damage: def.damage,
				color: def.color,
				speed: 5.2,
				slow: def.slow || 0,
				slowTicks: def.slowTicks || 0
			});
		}

		function findTargetForTower(tower, def) {
			let best = null;
			let bestProgress = -Infinity;

			for (let i = 0; i < state.enemies.length; i++) {
				const enemy = state.enemies[i];
				if (enemy.lane !== tower.lane || enemy.hp <= 0) {
					continue;
				}

				const dx = enemy.x - tower.x;
				const dy = enemy.y - tower.y;
				const dist = Math.sqrt((dx * dx) + (dy * dy));

				if (dist <= def.range) {
					if (enemy.x > bestProgress) {
						best = enemy;
						bestProgress = enemy.x;
					}
				}
			}

			return best;
		}

		function updateTowers(delta) {
			for (let i = 0; i < state.towers.length; i++) {
				const tower = state.towers[i];
				const def = towerDefs[tower.typeKey];

				if (!def) {
					continue;
				}

				if (tower.cooldown > 0) {
					tower.cooldown -= delta;
				}

				const target = findTargetForTower(tower, def);
				if (target && tower.cooldown <= 0) {
					createProjectile(tower.x, tower.y, target, def);
					tower.cooldown = def.cooldownMax;
				}
			}
		}

		function updateProjectiles(delta) {
			for (let i = state.projectiles.length - 1; i >= 0; i--) {
				const p = state.projectiles[i];

				if (!p.target || p.target.hp <= 0) {
					state.projectiles.splice(i, 1);
					continue;
				}

				const dx = p.target.x - p.x;
				const dy = p.target.y - p.y;
				const dist = Math.sqrt((dx * dx) + (dy * dy));

				if (dist <= 6) {
					p.target.hp -= p.damage;

					if (p.slow && p.slowTicks) {
						p.target.slowFactor = Math.min(p.target.slowFactor, p.slow);
						p.target.slowTicks = Math.max(p.target.slowTicks, p.slowTicks);
					}

					if (p.target.hp <= 0) {
						state.gold += p.target.reward;
					}

					state.projectiles.splice(i, 1);
					continue;
				}

				const step = p.speed * delta;
				p.x += (dx / dist) * step;
				p.y += (dy / dist) * step;
			}
		}

		function updateEnemies(delta) {
			for (let i = state.enemies.length - 1; i >= 0; i--) {
				const enemy = state.enemies[i];

				if (enemy.hp <= 0) {
					state.enemies.splice(i, 1);
					continue;
				}

				if (enemy.slowTicks > 0) {
					enemy.slowTicks -= delta;
				} else {
					enemy.slowFactor = 1;
				}

				const effectiveSpeed = enemy.speed * enemy.slowFactor * delta;
				enemy.x -= effectiveSpeed;

				if (enemy.x <= 95) {
					state.playerBaseHp -= enemy.damage;
					state.enemies.splice(i, 1);
				}
			}
		}

		function updateBaseAttacks(delta) {
			state.playerAttackTimer += delta;
			state.enemyAttackTimer += delta;

			if (state.playerAttackTimer >= 95) {
				state.playerAttackTimer = 0;
				state.enemyBaseHp -= 5 + (state.towers.length * 0.5);
			}

			if (state.enemyAttackTimer >= 125) {
				state.enemyAttackTimer = 0;
				state.playerBaseHp -= 3 + (state.wave * 0.3);
			}
		}

		function maybeAdvanceWave() {
			if (state.spawnQueue.length === 0 && state.enemies.length === 0) {
				state.wave += 1;
				state.gold += 35;
				prepareWave(state.wave);
				setMessage('Wave ' + state.wave + ' begins.');
			}
		}

		function update(delta) {
			state.gameSpeed = parseFloat(speedSelect.value || '1') || 1;
			const scaledDelta = delta * state.gameSpeed;

			state.spawnTimer += scaledDelta;
			if (state.spawnTimer >= 45 && state.spawnQueue.length > 0) {
				state.spawnTimer = 0;
				spawnEnemy();
			}

			updateTowers(scaledDelta);
			updateProjectiles(scaledDelta);
			updateEnemies(scaledDelta);
			updateBaseAttacks(scaledDelta);
			maybeAdvanceWave();

			if (state.playerBaseHp <= 0) {
				state.playerBaseHp = 0;
				state.running = false;
				state.gameOver = true;
				state.winner = 'Enemy';
				setMessage('You lost. Your base fell.');
			}

			if (state.enemyBaseHp <= 0) {
				state.enemyBaseHp = 0;
				state.running = false;
				state.gameOver = true;
				state.winner = 'Player';
				setMessage('You won. The enemy base fell.');
			}

			updateStats();
		}

		function drawBases() {
			ctx.save();

			ctx.fillStyle = '#2563eb';
			ctx.fillRect(28, 155, 72, 150);
			ctx.fillStyle = '#60a5fa';
			ctx.fillRect(38, 135, 52, 22);
			ctx.fillStyle = '#ffffff';
			ctx.font = 'bold 16px Arial';
			ctx.textAlign = 'center';
			ctx.fillText('BASE', 64, 230);

			ctx.fillStyle = '#7c2d12';
			ctx.fillRect(WIDTH - 100, 155, 72, 150);
			ctx.fillStyle = '#ea580c';
			ctx.fillRect(WIDTH - 90, 135, 52, 22);
			ctx.fillStyle = '#ffffff';
			ctx.fillText('BASE', WIDTH - 64, 230);

			ctx.restore();
		}

		function drawRoads() {
			ctx.save();

			for (let i = 0; i < LANE_Y.length; i++) {
				const y = LANE_Y[i];

				ctx.fillStyle = '#64748b';
				ctx.fillRect(95, y - 22, WIDTH - 190, 44);

				for (let x = 110; x < WIDTH - 110; x += 40) {
					ctx.fillStyle = '#cbd5e1';
					ctx.fillRect(x, y - 3, 20, 6);
				}
			}

			ctx.restore();
		}

		function drawBuildSpots() {
			ctx.save();

			for (let i = 0; i < buildSpots.length; i++) {
				const spot = buildSpots[i];
				const occupied = state.towers.some(function (tower) {
					return tower.spotIndex === i;
				});

				ctx.beginPath();
				ctx.fillStyle = occupied ? '#94a3b8' : '#e5e7eb';
				ctx.strokeStyle = '#64748b';
				ctx.lineWidth = 2;
				ctx.arc(spot.x, spot.y, 22, 0, Math.PI * 2);
				ctx.fill();
				ctx.stroke();
			}

			ctx.restore();
		}

		function drawTowers() {
			ctx.save();

			for (let i = 0; i < state.towers.length; i++) {
				const tower = state.towers[i];
				const def = towerDefs[tower.typeKey];

				ctx.fillStyle = def.color;
				ctx.fillRect(tower.x - 16, tower.y - 16, 32, 32);
				ctx.strokeStyle = '#0f172a';
				ctx.lineWidth = 2;
				ctx.strokeRect(tower.x - 16, tower.y - 16, 32, 32);

				ctx.fillStyle = '#ffffff';
				ctx.font = 'bold 12px Arial';
				ctx.textAlign = 'center';
				ctx.fillText(def.key === 'arrow' ? 'A' : (def.key === 'cannon' ? 'C' : 'F'), tower.x, tower.y + 4);
			}

			ctx.restore();
		}

		function drawEnemies() {
			ctx.save();

			for (let i = 0; i < state.enemies.length; i++) {
				const enemy = state.enemies[i];

				ctx.fillStyle = enemy.color;
				ctx.beginPath();
				ctx.arc(enemy.x, enemy.y, enemy.size / 2, 0, Math.PI * 2);
				ctx.fill();

				ctx.strokeStyle = '#0f172a';
				ctx.lineWidth = 2;
				ctx.stroke();

				ctx.fillStyle = '#ffffff';
				ctx.fillRect(enemy.x - 16, enemy.y - 24, 32, 5);
				ctx.fillStyle = '#22c55e';
				ctx.fillRect(enemy.x - 16, enemy.y - 24, 32 * (enemy.hp / enemy.maxHp), 5);

				if (enemy.slowFactor < 1) {
					ctx.strokeStyle = '#06b6d4';
					ctx.lineWidth = 2;
					ctx.beginPath();
					ctx.arc(enemy.x, enemy.y, (enemy.size / 2) + 4, 0, Math.PI * 2);
					ctx.stroke();
				}
			}

			ctx.restore();
		}

		function drawProjectiles() {
			ctx.save();

			for (let i = 0; i < state.projectiles.length; i++) {
				const p = state.projectiles[i];
				ctx.beginPath();
				ctx.fillStyle = p.color;
				ctx.arc(p.x, p.y, 4, 0, Math.PI * 2);
				ctx.fill();
			}

			ctx.restore();
		}

		function drawOverlay() {
			if (state.running) {
				return;
			}

			ctx.save();
			ctx.fillStyle = 'rgba(15, 23, 42, 0.12)';
			ctx.fillRect(0, 0, WIDTH, HEIGHT);

			ctx.fillStyle = '#0f172a';
			ctx.textAlign = 'center';

			if (state.gameOver) {
				ctx.font = 'bold 36px Arial';
				ctx.fillText(state.winner === 'Player' ? 'Victory' : 'Defeat', WIDTH / 2, HEIGHT / 2 - 10);
				ctx.font = 'bold 18px Arial';
				ctx.fillText('Press Restart to play again.', WIDTH / 2, HEIGHT / 2 + 28);
			} else {
				ctx.font = 'bold 34px Arial';
				ctx.fillText('Base Defense', WIDTH / 2, HEIGHT / 2 - 10);
				ctx.font = 'bold 18px Arial';
				ctx.fillText('Place towers, then press Start.', WIDTH / 2, HEIGHT / 2 + 28);
			}

			ctx.restore();
		}

		function draw() {
			ctx.clearRect(0, 0, WIDTH, HEIGHT);

			drawRoads();
			drawBases();
			drawBuildSpots();
			drawTowers();
			drawEnemies();
			drawProjectiles();
			drawOverlay();
		}

		function loop(timestamp) {
			if (!state.running) {
				draw();
				return;
			}

			const deltaMs = timestamp - state.lastTime;
			state.lastTime = timestamp;
			const delta = Math.min(deltaMs / 16.67, 2);

			update(delta);
			draw();

			if (state.running) {
				requestAnimationFrame(loop);
			}
		}

		canvas.addEventListener('click', function (event) {
			const rect = canvas.getBoundingClientRect();
			const x = (event.clientX - rect.left) * (canvas.width / rect.width);
			const y = (event.clientY - rect.top) * (canvas.height / rect.height);
			const spot = getSpotAt(x, y);

			if (spot) {
				buildTower(spot);
			}
		});

		startButton.addEventListener('click', function () {
			if (state.gameOver) {
				return;
			}

			if (!state.running) {
				state.running = true;
				state.lastTime = performance.now();
				setMessage('Defend your base and destroy theirs.');
				requestAnimationFrame(loop);
			}
		});

		restartButton.addEventListener('click', function () {
			resetGame();
		});

		root.querySelectorAll('.zo-bd-pick-tower').forEach(function (button) {
			button.addEventListener('click', function () {
				const key = button.getAttribute('data-tower');
				if (towerDefs[key]) {
					state.selectedTower = key;
					updateStats();
					setMessage('Selected: ' + towerDefs[key].name);
				}
			});
		});

		speedSelect.addEventListener('change', function () {
			state.gameSpeed = parseFloat(speedSelect.value || '1') || 1;
		});

		resetGame();
	});
});
JS;

if (!function_exists('zo_base_defense_render')) {
	function zo_base_defense_render($post_id = 0, $game = array()) {
		$game_id = 'zo-base-defense-' . wp_rand(1000, 999999);

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--base-defense" id="<?php echo esc_attr($game_id); ?>">
			<div class="zo-bd-wrap">
				<h2 class="zo-bd-title">Base Defense</h2>
				<p class="zo-bd-subtitle">Tower defense with bases. Build towers on the pads, stop enemy waves, and wear down the enemy base.</p>

				<div class="zo-bd-topbar">
					<div class="zo-bd-stats">
						<div class="zo-bd-stat">Gold: <span class="zo-bd-gold">120</span></div>
						<div class="zo-bd-stat">Wave: <span class="zo-bd-wave">1</span></div>
						<div class="zo-bd-stat">Your Base: <span class="zo-bd-player-base">240</span></div>
						<div class="zo-bd-stat">Enemy Base: <span class="zo-bd-enemy-base">240</span></div>
						<div class="zo-bd-stat">Selected: <span class="zo-bd-selected-tower">Arrow Tower</span></div>
					</div>

					<div class="zo-bd-controls">
						<select class="zo-bd-select" aria-label="Game speed">
							<option value="1">Speed x1</option>
							<option value="1.5">Speed x1.5</option>
							<option value="2">Speed x2</option>
						</select>
						<button type="button" class="zo-bd-btn zo-bd-btn--primary zo-bd-start">Start</button>
						<button type="button" class="zo-bd-btn zo-bd-btn--danger zo-bd-restart">Restart</button>
					</div>
				</div>

				<div class="zo-bd-layout">
					<div class="zo-bd-board-wrap">
						<canvas class="zo-bd-canvas" width="860" height="460" aria-label="Base defense battlefield"></canvas>
						<div class="zo-bd-message">Press Start. Place towers on the gray pads.</div>
					</div>

					<div class="zo-bd-side">
						<h3>Towers</h3>

						<div class="zo-bd-card-list">
							<div class="zo-bd-card">
								<div class="zo-bd-card-title">Arrow Tower - 40 gold</div>
								<div class="zo-bd-card-text">Fast shots. Good basic damage.</div>
								<button type="button" class="zo-bd-btn zo-bd-pick-tower" data-tower="arrow" style="margin-top:8px;">Pick Arrow</button>
							</div>

							<div class="zo-bd-card">
								<div class="zo-bd-card-title">Cannon Tower - 70 gold</div>
								<div class="zo-bd-card-text">Slower. Hits much harder.</div>
								<button type="button" class="zo-bd-btn zo-bd-pick-tower" data-tower="cannon" style="margin-top:8px;">Pick Cannon</button>
							</div>

							<div class="zo-bd-card">
								<div class="zo-bd-card-title">Frost Tower - 60 gold</div>
								<div class="zo-bd-card-text">Deals damage and slows enemies.</div>
								<button type="button" class="zo-bd-btn zo-bd-pick-tower" data-tower="frost" style="margin-top:8px;">Pick Frost</button>
							</div>
						</div>

						<h3>How to Play</h3>
						<ul>
							<li>Click a tower type.</li>
							<li>Click a gray build pad to place it.</li>
							<li>Enemy units come from the right.</li>
							<li>If they reach your base, your base loses HP.</li>
							<li>Your towers also help wear down the enemy base over time.</li>
							<li>Destroy the enemy base before yours falls.</li>
						</ul>

						<p>You can build before pressing Start, or during battle if you have enough gold.</p>
					</div>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'base-defense',
	'name'            => 'Base Defense',
	'author'          => 'Arslan',
	'description'     => 'A tower defense game with bases on both sides.',
	'render_callback' => 'zo_base_defense_render',
	'inline_style'    => $inline_style,
	'inline_script'   => $inline_script,
);