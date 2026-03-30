<?php

if (!defined('ABSPATH')) {
	exit;
}

$inline_style = <<<'CSS'
.zo-game-root--monster-vs-block-world * {
	box-sizing: border-box;
}

.zo-game-root--monster-vs-block-world {
	max-width: 1120px;
	margin: 0 auto;
	padding: 16px;
	font-family: Arial, sans-serif;
	color: #1f2937;
}

.zo-game-root--monster-vs-block-world .zo-mvb-wrap {
	background: #ffffff;
	border: 1px solid #dbe3ea;
	border-radius: 22px;
	padding: 18px;
	box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

.zo-game-root--monster-vs-block-world .zo-mvb-title {
	margin: 0 0 8px;
	text-align: center;
	font-size: 32px;
	line-height: 1.2;
	color: #0f172a;
}

.zo-game-root--monster-vs-block-world .zo-mvb-subtitle {
	margin: 0 0 18px;
	text-align: center;
	font-size: 15px;
	line-height: 1.5;
	color: #475569;
}

.zo-game-root--monster-vs-block-world .zo-mvb-topbar {
	display: flex;
	flex-wrap: wrap;
	gap: 12px;
	justify-content: space-between;
	align-items: center;
	margin-bottom: 16px;
}

.zo-game-root--monster-vs-block-world .zo-mvb-stats {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
}

.zo-game-root--monster-vs-block-world .zo-mvb-stat {
	background: #f3f6fa;
	border: 1px solid #dbe3ea;
	border-radius: 12px;
	padding: 10px 14px;
	font-size: 14px;
	font-weight: 700;
}

.zo-game-root--monster-vs-block-world .zo-mvb-controls {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	align-items: center;
}

.zo-game-root--monster-vs-block-world .zo-mvb-btn {
	padding: 10px 16px;
	border-radius: 12px;
	border: 1px solid #cfd8e3;
	background: #ffffff;
	color: #1f2937;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
}

.zo-game-root--monster-vs-block-world .zo-mvb-btn--primary {
	background: #2563eb;
	border-color: #2563eb;
	color: #ffffff;
}

.zo-game-root--monster-vs-block-world .zo-mvb-btn--danger {
	background: #ef4444;
	border-color: #ef4444;
	color: #ffffff;
}

.zo-game-root--monster-vs-block-world .zo-mvb-layout {
	display: grid;
	grid-template-columns: 1fr 340px;
	gap: 16px;
}

.zo-game-root--monster-vs-block-world .zo-mvb-board-wrap {
	background: #f8fafc;
	border: 1px solid #dbe3ea;
	border-radius: 18px;
	padding: 12px;
}

.zo-game-root--monster-vs-block-world .zo-mvb-canvas {
	display: block;
	width: 100%;
	height: auto;
	background: linear-gradient(180deg, #bfdbfe 0%, #dcfce7 100%);
	border: 1px solid #cfd8e3;
	border-radius: 14px;
}

.zo-game-root--monster-vs-block-world .zo-mvb-side {
	background: #f8fafc;
	border: 1px solid #dbe3ea;
	border-radius: 18px;
	padding: 14px;
}

.zo-game-root--monster-vs-block-world .zo-mvb-side h3 {
	margin: 0 0 10px;
	font-size: 18px;
	color: #0f172a;
}

.zo-game-root--monster-vs-block-world .zo-mvb-side p,
.zo-game-root--monster-vs-block-world .zo-mvb-side li {
	font-size: 14px;
	line-height: 1.5;
	color: #475569;
}

.zo-game-root--monster-vs-block-world .zo-mvb-side ul {
	margin: 0 0 14px;
	padding-left: 18px;
}

.zo-game-root--monster-vs-block-world .zo-mvb-unit-grid {
	display: grid;
	grid-template-columns: 1fr;
	gap: 10px;
	margin-bottom: 14px;
}

.zo-game-root--monster-vs-block-world .zo-mvb-unit-btn {
	width: 100%;
	text-align: left;
	padding: 10px 12px;
	border-radius: 12px;
	border: 1px solid #cfd8e3;
	background: #ffffff;
	font: inherit;
	font-size: 14px;
	font-weight: 700;
	cursor: pointer;
	transition: opacity 0.15s ease, transform 0.15s ease, background 0.15s ease;
}

.zo-game-root--monster-vs-block-world .zo-mvb-unit-btn:hover,
.zo-game-root--monster-vs-block-world .zo-mvb-unit-btn:focus {
	outline: none;
	transform: translateY(-1px);
	background: #f8fafc;
}

.zo-game-root--monster-vs-block-world .zo-mvb-unit-btn.is-used,
.zo-game-root--monster-vs-block-world .zo-mvb-unit-btn:disabled {
	opacity: 0.55;
	cursor: not-allowed;
	background: #e5e7eb;
}

.zo-game-root--monster-vs-block-world .zo-mvb-message {
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

.zo-game-root--monster-vs-block-world .zo-mvb-note {
	margin-top: 12px;
	padding: 12px 14px;
	border-radius: 12px;
	background: #fefce8;
	border: 1px solid #fde68a;
	font-size: 13px;
	line-height: 1.5;
	color: #854d0e;
}

@media (max-width: 920px) {
	.zo-game-root--monster-vs-block-world .zo-mvb-layout {
		grid-template-columns: 1fr;
	}
}

@media (max-width: 640px) {
	.zo-game-root--monster-vs-block-world {
		padding: 10px;
	}

	.zo-game-root--monster-vs-block-world .zo-mvb-wrap {
		padding: 12px;
	}

	.zo-game-root--monster-vs-block-world .zo-mvb-title {
		font-size: 26px;
	}
}
CSS;

$inline_script = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const roots = document.querySelectorAll('.zo-game-root--monster-vs-block-world');

	roots.forEach(function (root) {
		const canvas = root.querySelector('.zo-mvb-canvas');
		if (!canvas) {
			return;
		}

		const ctx = canvas.getContext('2d');
		const startButton = root.querySelector('.zo-mvb-start');
		const restartButton = root.querySelector('.zo-mvb-restart');
		const energyEl = root.querySelector('.zo-mvb-energy');
		const leftBaseEl = root.querySelector('.zo-mvb-left-base');
		const rightBaseEl = root.querySelector('.zo-mvb-right-base');
		const winnerEl = root.querySelector('.zo-mvb-winner');
		const messageEl = root.querySelector('.zo-mvb-message');
		const spawnButtons = root.querySelectorAll('.zo-mvb-unit-btn');

		const WIDTH = 920;
		const HEIGHT = 460;
		const GROUND_Y = 320;

		const playerUnitDefs = {
			firecub: {
				key: 'firecub',
				name: 'Fire Cub',
				cost: 28,
				hp: 48,
				damage: 8,
				speed: 1.30,
				range: 24,
				emoji: '🔥',
				fill: '#fdba74'
			},
			leafasaur: {
				key: 'leafasaur',
				name: 'Leafasaur',
				cost: 45,
				hp: 80,
				damage: 12,
				speed: 0.92,
				range: 28,
				emoji: '🌿',
				fill: '#86efac'
			},
			watertoad: {
				key: 'watertoad',
				name: 'Watertoad',
				cost: 40,
				hp: 66,
				damage: 10,
				speed: 1.05,
				range: 34,
				emoji: '💧',
				fill: '#93c5fd'
			},
			shadowzap: {
				key: 'shadowzap',
				name: 'Shadow Zap',
				cost: 58,
				hp: 54,
				damage: 18,
				speed: 1.45,
				range: 30,
				emoji: '⚡',
				fill: '#ddd6fe'
			}
		};

		const enemyUnitDefs = {
			steveguy: {
				key: 'steveguy',
				name: 'Block Steve',
				cost: 28,
				hp: 56,
				damage: 8,
				speed: 1.0,
				range: 24,
				emoji: '🧍',
				fill: '#c7d2fe'
			},
			pickaxeman: {
				key: 'pickaxeman',
				name: 'Pickaxe Man',
				cost: 40,
				hp: 76,
				damage: 12,
				speed: 0.82,
				range: 28,
				emoji: '⛏️',
				fill: '#fde68a'
			},
			swordfighter: {
				key: 'swordfighter',
				name: 'Sword Fighter',
				cost: 46,
				hp: 68,
				damage: 15,
				speed: 1.10,
				range: 26,
				emoji: '🗡️',
				fill: '#fecaca'
			},
			bowman: {
				key: 'bowman',
				name: 'Block Bowman',
				cost: 52,
				hp: 50,
				damage: 17,
				speed: 1.02,
				range: 38,
				emoji: '🏹',
				fill: '#bfdbfe'
			}
		};

		const state = {
			running: false,
			gameOver: false,
			lastTime: 0,
			playerEnergy: 55,
			enemyEnergy: 55,
			playerEnergyMax: 100,
			enemyEnergyMax: 100,
			playerBaseHp: 340,
			enemyBaseHp: 340,
			units: [],
			enemySpawnTimer: 0,
			winner: '-',
			playerUsed: {
				firecub: false,
				leafasaur: false,
				watertoad: false,
				shadowzap: false
			}
		};

		function clamp(value, min, max) {
			return Math.max(min, Math.min(max, value));
		}

		function setMessage(text) {
			messageEl.textContent = text;
		}

		function updateStats() {
			energyEl.textContent = Math.floor(state.playerEnergy);
			leftBaseEl.textContent = Math.max(0, Math.floor(state.playerBaseHp));
			rightBaseEl.textContent = Math.max(0, Math.floor(state.enemyBaseHp));
			winnerEl.textContent = state.winner;
		}

		function updateSpawnButtons() {
			spawnButtons.forEach(function (btn) {
				const key = btn.getAttribute('data-unit');
				const used = !!state.playerUsed[key];
				btn.disabled = used;
				btn.classList.toggle('is-used', used);

				if (playerUnitDefs[key]) {
					const def = playerUnitDefs[key];
					btn.textContent = def.emoji + ' ' + def.name + ' - ' + def.cost + ' energy' + (used ? ' - USED' : ' - ONE TIME');
				}
			});
		}

		function getPlayerDef(key) {
			return playerUnitDefs[key] || null;
		}

		function getEnemyDef(key) {
			return enemyUnitDefs[key] || null;
		}

		function createUnit(team, typeKey) {
			const def = team === 'left' ? getPlayerDef(typeKey) : getEnemyDef(typeKey);
			if (!def) {
				return null;
			}

			const startX = team === 'left' ? 105 : WIDTH - 151;

			return {
				team: team,
				typeKey: typeKey,
				name: def.name,
				x: startX,
				y: GROUND_Y,
				w: 48,
				h: 48,
				hp: def.hp,
				maxHp: def.hp,
				damage: def.damage,
				speed: def.speed,
				range: def.range,
				emoji: def.emoji,
				fill: def.fill,
				cooldown: 0
			};
		}

		function spawnPlayer(typeKey) {
			if (!state.running || state.gameOver) {
				return;
			}

			const def = getPlayerDef(typeKey);
			if (!def) {
				return;
			}

			if (state.playerUsed[typeKey]) {
				setMessage(def.name + ' can only be used one time.');
				return;
			}

			if (state.playerEnergy < def.cost) {
				setMessage('Not enough energy for ' + def.name + '.');
				return;
			}

			state.playerEnergy -= def.cost;
			state.playerUsed[typeKey] = true;
			state.units.push(createUnit('left', typeKey));
			updateStats();
			updateSpawnButtons();
			setMessage(def.name + ' joined the battle.');
		}

		function spawnEnemyAuto() {
			if (!state.running || state.gameOver) {
				return;
			}

			const options = ['steveguy', 'steveguy', 'pickaxeman', 'swordfighter', 'bowman'];
			const pick = options[Math.floor(Math.random() * options.length)];
			const def = getEnemyDef(pick);

			if (def && state.enemyEnergy >= def.cost) {
				state.enemyEnergy -= def.cost;
				state.units.push(createUnit('right', pick));
			}
		}

		function getEnemyTarget(unit) {
			let best = null;
			let bestDist = Infinity;

			for (let i = 0; i < state.units.length; i++) {
				const other = state.units[i];
				if (other === unit || other.team === unit.team || other.hp <= 0) {
					continue;
				}

				const dist = Math.abs((other.x + other.w / 2) - (unit.x + unit.w / 2));
				if (dist < bestDist) {
					bestDist = dist;
					best = other;
				}
			}

			return {
				target: best,
				distance: bestDist
			};
		}

		function updateUnits(delta) {
			for (let i = 0; i < state.units.length; i++) {
				const unit = state.units[i];
				if (unit.hp <= 0) {
					continue;
				}

				if (unit.cooldown > 0) {
					unit.cooldown -= delta;
				}

				const info = getEnemyTarget(unit);
				const target = info.target;

				if (target) {
					if (info.distance <= unit.range + 24) {
						if (unit.cooldown <= 0) {
							target.hp -= unit.damage;
							unit.cooldown = 28;
						}
					} else {
						if (unit.team === 'left') {
							unit.x += unit.speed;
						} else {
							unit.x -= unit.speed;
						}
					}
				} else {
					if (unit.team === 'left') {
						const distToBase = (WIDTH - 94) - (unit.x + unit.w / 2);
						if (distToBase <= unit.range + 28) {
							if (unit.cooldown <= 0) {
								state.enemyBaseHp -= unit.damage;
								unit.cooldown = 30;
							}
						} else {
							unit.x += unit.speed;
						}
					} else {
						const distToBase = (unit.x + unit.w / 2) - 94;
						if (distToBase <= unit.range + 28) {
							if (unit.cooldown <= 0) {
								state.playerBaseHp -= unit.damage;
								unit.cooldown = 30;
							}
						} else {
							unit.x -= unit.speed;
						}
					}
				}

				unit.x = clamp(unit.x, 48, WIDTH - 96);
			}

			state.units = state.units.filter(function (unit) {
				return unit.hp > 0;
			});
		}

		function update(delta) {
			state.playerEnergy = Math.min(state.playerEnergyMax, state.playerEnergy + 0.22 * delta);
			state.enemyEnergy = Math.min(state.enemyEnergyMax, state.enemyEnergy + 0.24 * delta);

			state.enemySpawnTimer += delta;
			if (state.enemySpawnTimer >= 85) {
				state.enemySpawnTimer = 0;
				spawnEnemyAuto();
			}

			updateUnits(delta);

			if (state.playerBaseHp <= 0) {
				state.playerBaseHp = 0;
				state.running = false;
				state.gameOver = true;
				state.winner = 'Minecraft Team';
				setMessage('Minecraft Team wins.');
			} else if (state.enemyBaseHp <= 0) {
				state.enemyBaseHp = 0;
				state.running = false;
				state.gameOver = true;
				state.winner = 'Pokémon Team';
				setMessage('Pokémon Team wins.');
			}

			updateStats();
		}

		function drawBackground() {
			ctx.clearRect(0, 0, WIDTH, HEIGHT);

			ctx.fillStyle = '#93c5fd';
			ctx.fillRect(0, 0, WIDTH, 88);

			ctx.fillStyle = '#86efac';
			ctx.fillRect(0, 320, WIDTH, 140);

			ctx.fillStyle = '#64748b';
			ctx.fillRect(0, 304, WIDTH, 16);

			for (let i = 0; i < WIDTH; i += 64) {
				ctx.fillStyle = i % 128 === 0 ? 'rgba(255,255,255,0.12)' : 'rgba(0,0,0,0.05)';
				ctx.fillRect(i, 320, 32, 140);
			}
		}

		function drawBase(x, hp, label, colors) {
			ctx.save();

			ctx.fillStyle = colors.main;
			ctx.fillRect(x, 180, 82, 140);
			ctx.fillStyle = colors.top;
			ctx.fillRect(x + 10, 156, 62, 24);

			ctx.fillStyle = '#ffffff';
			ctx.font = 'bold 15px Arial';
			ctx.textAlign = 'center';
			ctx.fillText(label, x + 41, 248);

			ctx.fillStyle = '#ffffff';
			ctx.fillRect(x + 12, 330, 58, 10);
			ctx.fillStyle = '#22c55e';
			ctx.fillRect(x + 12, 330, Math.max(0, 58 * (hp / 340)), 10);

			ctx.restore();
		}

		function drawUnit(unit) {
			ctx.save();

			ctx.fillStyle = unit.fill;
			ctx.fillRect(unit.x, unit.y, unit.w, unit.h);
			ctx.strokeStyle = '#1f2937';
			ctx.lineWidth = 2;
			ctx.strokeRect(unit.x, unit.y, unit.w, unit.h);

			ctx.font = '24px Arial';
			ctx.textAlign = 'center';
			ctx.textBaseline = 'middle';
			ctx.fillText(unit.emoji, unit.x + unit.w / 2, unit.y + unit.h / 2 + 2);

			ctx.fillStyle = '#ffffff';
			ctx.fillRect(unit.x, unit.y - 10, unit.w, 5);
			ctx.fillStyle = '#22c55e';
			ctx.fillRect(unit.x, unit.y - 10, unit.w * (unit.hp / unit.maxHp), 5);

			ctx.restore();
		}

		function drawOverlay() {
			if (state.running) {
				return;
			}

			ctx.save();
			ctx.fillStyle = 'rgba(15, 23, 42, 0.14)';
			ctx.fillRect(0, 0, WIDTH, HEIGHT);

			ctx.fillStyle = '#0f172a';
			ctx.textAlign = 'center';

			if (state.gameOver) {
				ctx.font = 'bold 34px Arial';
				ctx.fillText(state.winner + ' Wins', WIDTH / 2, HEIGHT / 2 - 12);
				ctx.font = 'bold 18px Arial';
				ctx.fillText('Press Restart to play again.', WIDTH / 2, HEIGHT / 2 + 22);
			} else {
				ctx.font = 'bold 34px Arial';
				ctx.fillText('Pokémon Team vs Minecraft Team', WIDTH / 2, HEIGHT / 2 - 12);
				ctx.font = 'bold 18px Arial';
				ctx.fillText('Start, then summon each Pokémon one time.', WIDTH / 2, HEIGHT / 2 + 22);
			}

			ctx.restore();
		}

		function draw() {
			drawBackground();

			drawBase(44, state.playerBaseHp, 'POKÉMON', {
				main: '#2563eb',
				top: '#60a5fa'
			});

			drawBase(WIDTH - 126, state.enemyBaseHp, 'MINECRAFT', {
				main: '#92400e',
				top: '#d97706'
			});

			for (let i = 0; i < state.units.length; i++) {
				drawUnit(state.units[i]);
			}

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

		function resetGame() {
			state.running = false;
			state.gameOver = false;
			state.lastTime = 0;
			state.playerEnergy = 55;
			state.enemyEnergy = 55;
			state.playerBaseHp = 340;
			state.enemyBaseHp = 340;
			state.units = [];
			state.enemySpawnTimer = 0;
			state.winner = '-';
			state.playerUsed = {
				firecub: false,
				leafasaur: false,
				watertoad: false,
				shadowzap: false
			};
			updateStats();
			updateSpawnButtons();
			setMessage('Press Start. Then each Pokémon can be used one time.');
			draw();
		}

		startButton.addEventListener('click', function () {
			if (state.running) {
				return;
			}

			if (state.gameOver) {
				resetGame();
			}

			state.running = true;
			state.lastTime = performance.now();
			setMessage('Battle started. Use each Pokémon carefully.');
			requestAnimationFrame(loop);
		});

		restartButton.addEventListener('click', function () {
			resetGame();
		});

		spawnButtons.forEach(function (btn) {
			btn.addEventListener('click', function () {
				spawnPlayer(btn.getAttribute('data-unit'));
			});
		});

		resetGame();
	});
});
JS;

if (!function_exists('zo_monster_vs_block_world_render')) {
	function zo_monster_vs_block_world_render($post_id = 0, $game = array()) {
		$game_id = 'zo-monster-vs-block-world-' . wp_rand(1000, 999999);

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--monster-vs-block-world" id="<?php echo esc_attr($game_id); ?>">
			<div class="zo-mvb-wrap">
				<h2 class="zo-mvb-title">Pokémon Team vs Minecraft Team</h2>
				<p class="zo-mvb-subtitle">Left side uses one-time Pokémon summons. Right side sends Minecraft people.</p>

				<div class="zo-mvb-topbar">
					<div class="zo-mvb-stats">
						<div class="zo-mvb-stat">Energy: <span class="zo-mvb-energy">55</span></div>
						<div class="zo-mvb-stat">Pokémon Base: <span class="zo-mvb-left-base">340</span></div>
						<div class="zo-mvb-stat">Minecraft Base: <span class="zo-mvb-right-base">340</span></div>
						<div class="zo-mvb-stat">Winner: <span class="zo-mvb-winner">-</span></div>
					</div>

					<div class="zo-mvb-controls">
						<button type="button" class="zo-mvb-btn zo-mvb-btn--primary zo-mvb-start">Start</button>
						<button type="button" class="zo-mvb-btn zo-mvb-btn--danger zo-mvb-restart">Restart</button>
					</div>
				</div>

				<div class="zo-mvb-layout">
					<div class="zo-mvb-board-wrap">
						<canvas class="zo-mvb-canvas" width="920" height="460" aria-label="Pokémon vs Minecraft battle"></canvas>
						<div class="zo-mvb-message">Press Start. Then each Pokémon can be used one time.</div>
					</div>

					<div class="zo-mvb-side">
						<h3>Pokémon Team</h3>

						<div class="zo-mvb-unit-grid">
							<button type="button" class="zo-mvb-unit-btn" data-unit="firecub">🔥 Fire Cub - 28 energy - ONE TIME</button>
							<button type="button" class="zo-mvb-unit-btn" data-unit="leafasaur">🌿 Leafasaur - 45 energy - ONE TIME</button>
							<button type="button" class="zo-mvb-unit-btn" data-unit="watertoad">💧 Watertoad - 40 energy - ONE TIME</button>
							<button type="button" class="zo-mvb-unit-btn" data-unit="shadowzap">⚡ Shadow Zap - 58 energy - ONE TIME</button>
						</div>

						<h3>Minecraft Team</h3>
						<ul>
							<li>🧍 Block Steve</li>
							<li>⛏️ Pickaxe Man</li>
							<li>🗡️ Sword Fighter</li>
							<li>🏹 Block Bowman</li>
						</ul>

						<h3>How It Works</h3>
						<ul>
							<li>Start the match.</li>
							<li>Energy fills over time.</li>
							<li>Each Pokémon can only be summoned one time.</li>
							<li>Minecraft people keep coming from the right side.</li>
							<li>Destroy the other base first.</li>
						</ul>

						<div class="zo-mvb-note">
							This is still a fan-style custom game. It does not include official sprites or copied game assets.
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'monster-vs-block-world',
	'name'            => 'Pokémon Team vs Minecraft Team',
	'author'          => 'Arslan',
	'description'     => 'Pokémon on one side with one-time summons and Minecraft people on the other side.',
	'render_callback' => 'zo_monster_vs_block_world_render',
	'inline_style'    => $inline_style,
	'inline_script'   => $inline_script,
);<?php

if (!defined('ABSPATH')) {
	exit;
}

$inline_style = <<<'CSS'
.zo-game-root--monster-vs-block-world * {
	box-sizing: border-box;
}

.zo-game-root--monster-vs-block-world {
	max-width: 1120px;
	margin: 0 auto;
	padding: 16px;
	font-family: Arial, sans-serif;
	color: #1f2937;
}

.zo-game-root--monster-vs-block-world .zo-mvb-wrap {
	background: #ffffff;
	border: 1px solid #dbe3ea;
	border-radius: 22px;
	padding: 18px;
	box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

.zo-game-root--monster-vs-block-world .zo-mvb-title {
	margin: 0 0 8px;
	text-align: center;
	font-size: 32px;
	line-height: 1.2;
	color: #0f172a;
}

.zo-game-root--monster-vs-block-world .zo-mvb-subtitle {
	margin: 0 0 18px;
	text-align: center;
	font-size: 15px;
	line-height: 1.5;
	color: #475569;
}

.zo-game-root--monster-vs-block-world .zo-mvb-topbar {
	display: flex;
	flex-wrap: wrap;
	gap: 12px;
	justify-content: space-between;
	align-items: center;
	margin-bottom: 16px;
}

.zo-game-root--monster-vs-block-world .zo-mvb-stats {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
}

.zo-game-root--monster-vs-block-world .zo-mvb-stat {
	background: #f3f6fa;
	border: 1px solid #dbe3ea;
	border-radius: 12px;
	padding: 10px 14px;
	font-size: 14px;
	font-weight: 700;
}

.zo-game-root--monster-vs-block-world .zo-mvb-controls {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	align-items: center;
}

.zo-game-root--monster-vs-block-world .zo-mvb-btn {
	padding: 10px 16px;
	border-radius: 12px;
	border: 1px solid #cfd8e3;
	background: #ffffff;
	color: #1f2937;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
}

.zo-game-root--monster-vs-block-world .zo-mvb-btn--primary {
	background: #2563eb;
	border-color: #2563eb;
	color: #ffffff;
}

.zo-game-root--monster-vs-block-world .zo-mvb-btn--danger {
	background: #ef4444;
	border-color: #ef4444;
	color: #ffffff;
}

.zo-game-root--monster-vs-block-world .zo-mvb-layout {
	display: grid;
	grid-template-columns: 1fr 340px;
	gap: 16px;
}

.zo-game-root--monster-vs-block-world .zo-mvb-board-wrap {
	background: #f8fafc;
	border: 1px solid #dbe3ea;
	border-radius: 18px;
	padding: 12px;
}

.zo-game-root--monster-vs-block-world .zo-mvb-canvas {
	display: block;
	width: 100%;
	height: auto;
	background: linear-gradient(180deg, #bfdbfe 0%, #dcfce7 100%);
	border: 1px solid #cfd8e3;
	border-radius: 14px;
}

.zo-game-root--monster-vs-block-world .zo-mvb-side {
	background: #f8fafc;
	border: 1px solid #dbe3ea;
	border-radius: 18px;
	padding: 14px;
}

.zo-game-root--monster-vs-block-world .zo-mvb-side h3 {
	margin: 0 0 10px;
	font-size: 18px;
	color: #0f172a;
}

.zo-game-root--monster-vs-block-world .zo-mvb-side p,
.zo-game-root--monster-vs-block-world .zo-mvb-side li {
	font-size: 14px;
	line-height: 1.5;
	color: #475569;
}

.zo-game-root--monster-vs-block-world .zo-mvb-side ul {
	margin: 0 0 14px;
	padding-left: 18px;
}

.zo-game-root--monster-vs-block-world .zo-mvb-unit-grid {
	display: grid;
	grid-template-columns: 1fr;
	gap: 10px;
	margin-bottom: 14px;
}

.zo-game-root--monster-vs-block-world .zo-mvb-unit-btn {
	width: 100%;
	text-align: left;
	padding: 10px 12px;
	border-radius: 12px;
	border: 1px solid #cfd8e3;
	background: #ffffff;
	font: inherit;
	font-size: 14px;
	font-weight: 700;
	cursor: pointer;
	transition: opacity 0.15s ease, transform 0.15s ease, background 0.15s ease;
}

.zo-game-root--monster-vs-block-world .zo-mvb-unit-btn:hover,
.zo-game-root--monster-vs-block-world .zo-mvb-unit-btn:focus {
	outline: none;
	transform: translateY(-1px);
	background: #f8fafc;
}

.zo-game-root--monster-vs-block-world .zo-mvb-unit-btn.is-used,
.zo-game-root--monster-vs-block-world .zo-mvb-unit-btn:disabled {
	opacity: 0.55;
	cursor: not-allowed;
	background: #e5e7eb;
}

.zo-game-root--monster-vs-block-world .zo-mvb-message {
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

.zo-game-root--monster-vs-block-world .zo-mvb-note {
	margin-top: 12px;
	padding: 12px 14px;
	border-radius: 12px;
	background: #fefce8;
	border: 1px solid #fde68a;
	font-size: 13px;
	line-height: 1.5;
	color: #854d0e;
}

@media (max-width: 920px) {
	.zo-game-root--monster-vs-block-world .zo-mvb-layout {
		grid-template-columns: 1fr;
	}
}

@media (max-width: 640px) {
	.zo-game-root--monster-vs-block-world {
		padding: 10px;
	}

	.zo-game-root--monster-vs-block-world .zo-mvb-wrap {
		padding: 12px;
	}

	.zo-game-root--monster-vs-block-world .zo-mvb-title {
		font-size: 26px;
	}
}
CSS;

$inline_script = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const roots = document.querySelectorAll('.zo-game-root--monster-vs-block-world');

	roots.forEach(function (root) {
		const canvas = root.querySelector('.zo-mvb-canvas');
		if (!canvas) {
			return;
		}

		const ctx = canvas.getContext('2d');
		const startButton = root.querySelector('.zo-mvb-start');
		const restartButton = root.querySelector('.zo-mvb-restart');
		const energyEl = root.querySelector('.zo-mvb-energy');
		const leftBaseEl = root.querySelector('.zo-mvb-left-base');
		const rightBaseEl = root.querySelector('.zo-mvb-right-base');
		const winnerEl = root.querySelector('.zo-mvb-winner');
		const messageEl = root.querySelector('.zo-mvb-message');
		const spawnButtons = root.querySelectorAll('.zo-mvb-unit-btn');

		const WIDTH = 920;
		const HEIGHT = 460;
		const GROUND_Y = 320;

		const playerUnitDefs = {
			firecub: {
				key: 'firecub',
				name: 'Fire Cub',
				cost: 28,
				hp: 48,
				damage: 8,
				speed: 1.30,
				range: 24,
				emoji: '🔥',
				fill: '#fdba74'
			},
			leafasaur: {
				key: 'leafasaur',
				name: 'Leafasaur',
				cost: 45,
				hp: 80,
				damage: 12,
				speed: 0.92,
				range: 28,
				emoji: '🌿',
				fill: '#86efac'
			},
			watertoad: {
				key: 'watertoad',
				name: 'Watertoad',
				cost: 40,
				hp: 66,
				damage: 10,
				speed: 1.05,
				range: 34,
				emoji: '💧',
				fill: '#93c5fd'
			},
			shadowzap: {
				key: 'shadowzap',
				name: 'Shadow Zap',
				cost: 58,
				hp: 54,
				damage: 18,
				speed: 1.45,
				range: 30,
				emoji: '⚡',
				fill: '#ddd6fe'
			}
		};

		const enemyUnitDefs = {
			steveguy: {
				key: 'steveguy',
				name: 'Block Steve',
				cost: 28,
				hp: 56,
				damage: 8,
				speed: 1.0,
				range: 24,
				emoji: '🧍',
				fill: '#c7d2fe'
			},
			pickaxeman: {
				key: 'pickaxeman',
				name: 'Pickaxe Man',
				cost: 40,
				hp: 76,
				damage: 12,
				speed: 0.82,
				range: 28,
				emoji: '⛏️',
				fill: '#fde68a'
			},
			swordfighter: {
				key: 'swordfighter',
				name: 'Sword Fighter',
				cost: 46,
				hp: 68,
				damage: 15,
				speed: 1.10,
				range: 26,
				emoji: '🗡️',
				fill: '#fecaca'
			},
			bowman: {
				key: 'bowman',
				name: 'Block Bowman',
				cost: 52,
				hp: 50,
				damage: 17,
				speed: 1.02,
				range: 38,
				emoji: '🏹',
				fill: '#bfdbfe'
			}
		};

		const state = {
			running: false,
			gameOver: false,
			lastTime: 0,
			playerEnergy: 55,
			enemyEnergy: 55,
			playerEnergyMax: 100,
			enemyEnergyMax: 100,
			playerBaseHp: 340,
			enemyBaseHp: 340,
			units: [],
			enemySpawnTimer: 0,
			winner: '-',
			playerUsed: {
				firecub: false,
				leafasaur: false,
				watertoad: false,
				shadowzap: false
			}
		};

		function clamp(value, min, max) {
			return Math.max(min, Math.min(max, value));
		}

		function setMessage(text) {
			messageEl.textContent = text;
		}

		function updateStats() {
			energyEl.textContent = Math.floor(state.playerEnergy);
			leftBaseEl.textContent = Math.max(0, Math.floor(state.playerBaseHp));
			rightBaseEl.textContent = Math.max(0, Math.floor(state.enemyBaseHp));
			winnerEl.textContent = state.winner;
		}

		function updateSpawnButtons() {
			spawnButtons.forEach(function (btn) {
				const key = btn.getAttribute('data-unit');
				const used = !!state.playerUsed[key];
				btn.disabled = used;
				btn.classList.toggle('is-used', used);

				if (playerUnitDefs[key]) {
					const def = playerUnitDefs[key];
					btn.textContent = def.emoji + ' ' + def.name + ' - ' + def.cost + ' energy' + (used ? ' - USED' : ' - ONE TIME');
				}
			});
		}

		function getPlayerDef(key) {
			return playerUnitDefs[key] || null;
		}

		function getEnemyDef(key) {
			return enemyUnitDefs[key] || null;
		}

		function createUnit(team, typeKey) {
			const def = team === 'left' ? getPlayerDef(typeKey) : getEnemyDef(typeKey);
			if (!def) {
				return null;
			}

			const startX = team === 'left' ? 105 : WIDTH - 151;

			return {
				team: team,
				typeKey: typeKey,
				name: def.name,
				x: startX,
				y: GROUND_Y,
				w: 48,
				h: 48,
				hp: def.hp,
				maxHp: def.hp,
				damage: def.damage,
				speed: def.speed,
				range: def.range,
				emoji: def.emoji,
				fill: def.fill,
				cooldown: 0
			};
		}

		function spawnPlayer(typeKey) {
			if (!state.running || state.gameOver) {
				return;
			}

			const def = getPlayerDef(typeKey);
			if (!def) {
				return;
			}

			if (state.playerUsed[typeKey]) {
				setMessage(def.name + ' can only be used one time.');
				return;
			}

			if (state.playerEnergy < def.cost) {
				setMessage('Not enough energy for ' + def.name + '.');
				return;
			}

			state.playerEnergy -= def.cost;
			state.playerUsed[typeKey] = true;
			state.units.push(createUnit('left', typeKey));
			updateStats();
			updateSpawnButtons();
			setMessage(def.name + ' joined the battle.');
		}

		function spawnEnemyAuto() {
			if (!state.running || state.gameOver) {
				return;
			}

			const options = ['steveguy', 'steveguy', 'pickaxeman', 'swordfighter', 'bowman'];
			const pick = options[Math.floor(Math.random() * options.length)];
			const def = getEnemyDef(pick);

			if (def && state.enemyEnergy >= def.cost) {
				state.enemyEnergy -= def.cost;
				state.units.push(createUnit('right', pick));
			}
		}

		function getEnemyTarget(unit) {
			let best = null;
			let bestDist = Infinity;

			for (let i = 0; i < state.units.length; i++) {
				const other = state.units[i];
				if (other === unit || other.team === unit.team || other.hp <= 0) {
					continue;
				}

				const dist = Math.abs((other.x + other.w / 2) - (unit.x + unit.w / 2));
				if (dist < bestDist) {
					bestDist = dist;
					best = other;
				}
			}

			return {
				target: best,
				distance: bestDist
			};
		}

		function updateUnits(delta) {
			for (let i = 0; i < state.units.length; i++) {
				const unit = state.units[i];
				if (unit.hp <= 0) {
					continue;
				}

				if (unit.cooldown > 0) {
					unit.cooldown -= delta;
				}

				const info = getEnemyTarget(unit);
				const target = info.target;

				if (target) {
					if (info.distance <= unit.range + 24) {
						if (unit.cooldown <= 0) {
							target.hp -= unit.damage;
							unit.cooldown = 28;
						}
					} else {
						if (unit.team === 'left') {
							unit.x += unit.speed;
						} else {
							unit.x -= unit.speed;
						}
					}
				} else {
					if (unit.team === 'left') {
						const distToBase = (WIDTH - 94) - (unit.x + unit.w / 2);
						if (distToBase <= unit.range + 28) {
							if (unit.cooldown <= 0) {
								state.enemyBaseHp -= unit.damage;
								unit.cooldown = 30;
							}
						} else {
							unit.x += unit.speed;
						}
					} else {
						const distToBase = (unit.x + unit.w / 2) - 94;
						if (distToBase <= unit.range + 28) {
							if (unit.cooldown <= 0) {
								state.playerBaseHp -= unit.damage;
								unit.cooldown = 30;
							}
						} else {
							unit.x -= unit.speed;
						}
					}
				}

				unit.x = clamp(unit.x, 48, WIDTH - 96);
			}

			state.units = state.units.filter(function (unit) {
				return unit.hp > 0;
			});
		}

		function update(delta) {
			state.playerEnergy = Math.min(state.playerEnergyMax, state.playerEnergy + 0.22 * delta);
			state.enemyEnergy = Math.min(state.enemyEnergyMax, state.enemyEnergy + 0.24 * delta);

			state.enemySpawnTimer += delta;
			if (state.enemySpawnTimer >= 85) {
				state.enemySpawnTimer = 0;
				spawnEnemyAuto();
			}

			updateUnits(delta);

			if (state.playerBaseHp <= 0) {
				state.playerBaseHp = 0;
				state.running = false;
				state.gameOver = true;
				state.winner = 'Minecraft Team';
				setMessage('Minecraft Team wins.');
			} else if (state.enemyBaseHp <= 0) {
				state.enemyBaseHp = 0;
				state.running = false;
				state.gameOver = true;
				state.winner = 'Pokémon Team';
				setMessage('Pokémon Team wins.');
			}

			updateStats();
		}

		function drawBackground() {
			ctx.clearRect(0, 0, WIDTH, HEIGHT);

			ctx.fillStyle = '#93c5fd';
			ctx.fillRect(0, 0, WIDTH, 88);

			ctx.fillStyle = '#86efac';
			ctx.fillRect(0, 320, WIDTH, 140);

			ctx.fillStyle = '#64748b';
			ctx.fillRect(0, 304, WIDTH, 16);

			for (let i = 0; i < WIDTH; i += 64) {
				ctx.fillStyle = i % 128 === 0 ? 'rgba(255,255,255,0.12)' : 'rgba(0,0,0,0.05)';
				ctx.fillRect(i, 320, 32, 140);
			}
		}

		function drawBase(x, hp, label, colors) {
			ctx.save();

			ctx.fillStyle = colors.main;
			ctx.fillRect(x, 180, 82, 140);
			ctx.fillStyle = colors.top;
			ctx.fillRect(x + 10, 156, 62, 24);

			ctx.fillStyle = '#ffffff';
			ctx.font = 'bold 15px Arial';
			ctx.textAlign = 'center';
			ctx.fillText(label, x + 41, 248);

			ctx.fillStyle = '#ffffff';
			ctx.fillRect(x + 12, 330, 58, 10);
			ctx.fillStyle = '#22c55e';
			ctx.fillRect(x + 12, 330, Math.max(0, 58 * (hp / 340)), 10);

			ctx.restore();
		}

		function drawUnit(unit) {
			ctx.save();

			ctx.fillStyle = unit.fill;
			ctx.fillRect(unit.x, unit.y, unit.w, unit.h);
			ctx.strokeStyle = '#1f2937';
			ctx.lineWidth = 2;
			ctx.strokeRect(unit.x, unit.y, unit.w, unit.h);

			ctx.font = '24px Arial';
			ctx.textAlign = 'center';
			ctx.textBaseline = 'middle';
			ctx.fillText(unit.emoji, unit.x + unit.w / 2, unit.y + unit.h / 2 + 2);

			ctx.fillStyle = '#ffffff';
			ctx.fillRect(unit.x, unit.y - 10, unit.w, 5);
			ctx.fillStyle = '#22c55e';
			ctx.fillRect(unit.x, unit.y - 10, unit.w * (unit.hp / unit.maxHp), 5);

			ctx.restore();
		}

		function drawOverlay() {
			if (state.running) {
				return;
			}

			ctx.save();
			ctx.fillStyle = 'rgba(15, 23, 42, 0.14)';
			ctx.fillRect(0, 0, WIDTH, HEIGHT);

			ctx.fillStyle = '#0f172a';
			ctx.textAlign = 'center';

			if (state.gameOver) {
				ctx.font = 'bold 34px Arial';
				ctx.fillText(state.winner + ' Wins', WIDTH / 2, HEIGHT / 2 - 12);
				ctx.font = 'bold 18px Arial';
				ctx.fillText('Press Restart to play again.', WIDTH / 2, HEIGHT / 2 + 22);
			} else {
				ctx.font = 'bold 34px Arial';
				ctx.fillText('Pokémon Team vs Minecraft Team', WIDTH / 2, HEIGHT / 2 - 12);
				ctx.font = 'bold 18px Arial';
				ctx.fillText('Start, then summon each Pokémon one time.', WIDTH / 2, HEIGHT / 2 + 22);
			}

			ctx.restore();
		}

		function draw() {
			drawBackground();

			drawBase(44, state.playerBaseHp, 'POKÉMON', {
				main: '#2563eb',
				top: '#60a5fa'
			});

			drawBase(WIDTH - 126, state.enemyBaseHp, 'MINECRAFT', {
				main: '#92400e',
				top: '#d97706'
			});

			for (let i = 0; i < state.units.length; i++) {
				drawUnit(state.units[i]);
			}

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

		function resetGame() {
			state.running = false;
			state.gameOver = false;
			state.lastTime = 0;
			state.playerEnergy = 55;
			state.enemyEnergy = 55;
			state.playerBaseHp = 340;
			state.enemyBaseHp = 340;
			state.units = [];
			state.enemySpawnTimer = 0;
			state.winner = '-';
			state.playerUsed = {
				firecub: false,
				leafasaur: false,
				watertoad: false,
				shadowzap: false
			};
			updateStats();
			updateSpawnButtons();
			setMessage('Press Start. Then each Pokémon can be used one time.');
			draw();
		}

		startButton.addEventListener('click', function () {
			if (state.running) {
				return;
			}

			if (state.gameOver) {
				resetGame();
			}

			state.running = true;
			state.lastTime = performance.now();
			setMessage('Battle started. Use each Pokémon carefully.');
			requestAnimationFrame(loop);
		});

		restartButton.addEventListener('click', function () {
			resetGame();
		});

		spawnButtons.forEach(function (btn) {
			btn.addEventListener('click', function () {
				spawnPlayer(btn.getAttribute('data-unit'));
			});
		});

		resetGame();
	});
});
JS;

if (!function_exists('zo_monster_vs_block_world_render')) {
	function zo_monster_vs_block_world_render($post_id = 0, $game = array()) {
		$game_id = 'zo-monster-vs-block-world-' . wp_rand(1000, 999999);

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--monster-vs-block-world" id="<?php echo esc_attr($game_id); ?>">
			<div class="zo-mvb-wrap">
				<h2 class="zo-mvb-title">Pokémon Team vs Minecraft Team</h2>
				<p class="zo-mvb-subtitle">Left side uses one-time Pokémon summons. Right side sends Minecraft people.</p>

				<div class="zo-mvb-topbar">
					<div class="zo-mvb-stats">
						<div class="zo-mvb-stat">Energy: <span class="zo-mvb-energy">55</span></div>
						<div class="zo-mvb-stat">Pokémon Base: <span class="zo-mvb-left-base">340</span></div>
						<div class="zo-mvb-stat">Minecraft Base: <span class="zo-mvb-right-base">340</span></div>
						<div class="zo-mvb-stat">Winner: <span class="zo-mvb-winner">-</span></div>
					</div>

					<div class="zo-mvb-controls">
						<button type="button" class="zo-mvb-btn zo-mvb-btn--primary zo-mvb-start">Start</button>
						<button type="button" class="zo-mvb-btn zo-mvb-btn--danger zo-mvb-restart">Restart</button>
					</div>
				</div>

				<div class="zo-mvb-layout">
					<div class="zo-mvb-board-wrap">
						<canvas class="zo-mvb-canvas" width="920" height="460" aria-label="Pokémon vs Minecraft battle"></canvas>
						<div class="zo-mvb-message">Press Start. Then each Pokémon can be used one time.</div>
					</div>

					<div class="zo-mvb-side">
						<h3>Pokémon Team</h3>

						<div class="zo-mvb-unit-grid">
							<button type="button" class="zo-mvb-unit-btn" data-unit="firecub">🔥 Fire Cub - 28 energy - ONE TIME</button>
							<button type="button" class="zo-mvb-unit-btn" data-unit="leafasaur">🌿 Leafasaur - 45 energy - ONE TIME</button>
							<button type="button" class="zo-mvb-unit-btn" data-unit="watertoad">💧 Watertoad - 40 energy - ONE TIME</button>
							<button type="button" class="zo-mvb-unit-btn" data-unit="shadowzap">⚡ Shadow Zap - 58 energy - ONE TIME</button>
						</div>

						<h3>Minecraft Team</h3>
						<ul>
							<li>🧍 Block Steve</li>
							<li>⛏️ Pickaxe Man</li>
							<li>🗡️ Sword Fighter</li>
							<li>🏹 Block Bowman</li>
						</ul>

						<h3>How It Works</h3>
						<ul>
							<li>Start the match.</li>
							<li>Energy fills over time.</li>
							<li>Each Pokémon can only be summoned one time.</li>
							<li>Minecraft people keep coming from the right side.</li>
							<li>Destroy the other base first.</li>
						</ul>

						<div class="zo-mvb-note">
							This is still a fan-style custom game. It does not include official sprites or copied game assets.
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'monster-vs-block-world',
	'name'            => 'Pokémon Team vs Minecraft Team',
	'author'          => 'Arslan',
	'description'     => 'Pokémon on one side with one-time summons and Minecraft people on the other side.',
	'render_callback' => 'zo_monster_vs_block_world_render',
	'inline_style'    => $inline_style,
	'inline_script'   => $inline_script,
);