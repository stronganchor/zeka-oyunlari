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
	grid-template-columns: 1fr 320px;
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

		const WIDTH = 900;
		const HEIGHT = 440;
		const GROUND_Y = 310;

		const unitDefs = {
			sparkfox: {
				key: 'sparkfox',
				name: 'Spark Fox',
				cost: 25,
				hp: 42,
				damage: 7,
				speed: 1.25,
				range: 24,
				emoji: '🦊',
				fill: '#fde68a'
			},
			leafdino: {
				key: 'leafdino',
				name: 'Leaf Dino',
				cost: 40,
				hp: 74,
				damage: 11,
				speed: 0.9,
				range: 26,
				emoji: '🦖',
				fill: '#bbf7d0'
			},
			shadowbat: {
				key: 'shadowbat',
				name: 'Shadow Bat',
				cost: 55,
				hp: 52,
				damage: 16,
				speed: 1.45,
				range: 28,
				emoji: '🦇',
				fill: '#ddd6fe'
			},
			blockkid: {
				key: 'blockkid',
				name: 'Block Kid',
				cost: 28,
				hp: 54,
				damage: 8,
				speed: 1.0,
				range: 24,
				emoji: '🧱',
				fill: '#fecaca'
			},
			miner: {
				key: 'miner',
				name: 'Miner',
				cost: 42,
				hp: 82,
				damage: 12,
				speed: 0.78,
				range: 28,
				emoji: '⛏️',
				fill: '#fed7aa'
			},
			blastcube: {
				key: 'blastcube',
				name: 'Boom Cube',
				cost: 58,
				hp: 44,
				damage: 26,
				speed: 1.18,
				range: 20,
				emoji: '💥',
				fill: '#86efac'
			}
		};

		const state = {
			running: false,
			gameOver: false,
			lastTime: 0,
			playerEnergy: 45,
			enemyEnergy: 45,
			playerEnergyMax: 100,
			enemyEnergyMax: 100,
			playerBaseHp: 320,
			enemyBaseHp: 320,
			units: [],
			enemySpawnTimer: 0,
			winner: '-'
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

		function createUnit(team, typeKey) {
			const def = unitDefs[typeKey];
			if (!def) {
				return null;
			}

			const startX = team === 'left' ? 105 : WIDTH - 149;

			return {
				team: team,
				typeKey: typeKey,
				name: def.name,
				x: startX,
				y: GROUND_Y,
				w: 46,
				h: 46,
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

			const def = unitDefs[typeKey];
			if (!def) {
				return;
			}

			if (state.playerEnergy < def.cost) {
				setMessage('Not enough energy for ' + def.name + '.');
				return;
			}

			state.playerEnergy -= def.cost;
			state.units.push(createUnit('left', typeKey));
			setMessage(def.name + ' sent to battle.');
			updateStats();
		}

		function spawnEnemyAuto() {
			if (!state.running || state.gameOver) {
				return;
			}

			const options = ['blockkid', 'blockkid', 'miner', 'blastcube'];
			const pick = options[Math.floor(Math.random() * options.length)];
			const def = unitDefs[pick];

			if (state.enemyEnergy >= def.cost) {
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
						const distToBase = (WIDTH - 92) - (unit.x + unit.w / 2);
						if (distToBase <= unit.range + 28) {
							if (unit.cooldown <= 0) {
								state.enemyBaseHp -= unit.damage;
								unit.cooldown = 30;
							}
						} else {
							unit.x += unit.speed;
						}
					} else {
						const distToBase = (unit.x + unit.w / 2) - 92;
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

				unit.x = clamp(unit.x, 48, WIDTH - 94);
			}

			state.units = state.units.filter(function (unit) {
				return unit.hp > 0;
			});
		}

		function update(delta) {
			state.playerEnergy = Math.min(state.playerEnergyMax, state.playerEnergy + 0.24 * delta);
			state.enemyEnergy = Math.min(state.enemyEnergyMax, state.enemyEnergy + 0.26 * delta);

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
				state.winner = 'Block World';
				setMessage('Block World wins.');
			} else if (state.enemyBaseHp <= 0) {
				state.enemyBaseHp = 0;
				state.running = false;
				state.gameOver = true;
				state.winner = 'Monster Team';
				setMessage('Monster Team wins.');
			}

			updateStats();
		}

		function drawBackground() {
			ctx.clearRect(0, 0, WIDTH, HEIGHT);

			ctx.fillStyle = '#93c5fd';
			ctx.fillRect(0, 0, WIDTH, 86);

			ctx.fillStyle = '#86efac';
			ctx.fillRect(0, 310, WIDTH, 130);

			ctx.fillStyle = '#64748b';
			ctx.fillRect(0, 294, WIDTH, 16);

			for (let i = 0; i < WIDTH; i += 64) {
				ctx.fillStyle = i % 128 === 0 ? 'rgba(255,255,255,0.12)' : 'rgba(0,0,0,0.05)';
				ctx.fillRect(i, 310, 32, 130);
			}
		}

		function drawBase(x, hp, label, colors) {
			ctx.save();

			ctx.fillStyle = colors.main;
			ctx.fillRect(x, 176, 78, 134);
			ctx.fillStyle = colors.top;
			ctx.fillRect(x + 10, 154, 58, 22);

			ctx.fillStyle = '#ffffff';
			ctx.font = 'bold 15px Arial';
			ctx.textAlign = 'center';
			ctx.fillText(label, x + 39, 246);

			ctx.fillStyle = '#ffffff';
			ctx.fillRect(x + 10, 320, 58, 10);
			ctx.fillStyle = '#22c55e';
			ctx.fillRect(x + 10, 320, Math.max(0, 58 * (hp / 320)), 10);

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
				ctx.fillText('Press restart to play again.', WIDTH / 2, HEIGHT / 2 + 22);
			} else {
				ctx.font = 'bold 34px Arial';
				ctx.fillText('Monster Team vs Block World', WIDTH / 2, HEIGHT / 2 - 12);
				ctx.font = 'bold 18px Arial';
				ctx.fillText('Start, then send units from the left side.', WIDTH / 2, HEIGHT / 2 + 22);
			}

			ctx.restore();
		}

		function draw() {
			drawBackground();

			drawBase(42, state.playerBaseHp, 'MONSTER', {
				main: '#2563eb',
				top: '#60a5fa'
			});

			drawBase(WIDTH - 120, state.enemyBaseHp, 'BLOCK', {
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

		startButton.addEventListener('click', function () {
			if (state.running) {
				return;
			}

			if (state.gameOver) {
				resetGame();
			}

			state.running = true;
			state.lastTime = performance.now();
			setMessage('Battle started. Send your monster team.');
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

		function resetGame() {
			state.running = false;
			state.gameOver = false;
			state.lastTime = 0;
			state.playerEnergy = 45;
			state.enemyEnergy = 45;
			state.playerBaseHp = 320;
			state.enemyBaseHp = 320;
			state.units = [];
			state.enemySpawnTimer = 0;
			state.winner = '-';
			updateStats();
			setMessage('Press Start. Then choose a monster unit.');
			draw();
		}

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
				<h2 class="zo-mvb-title">Monster Team vs Block World</h2>
				<p class="zo-mvb-subtitle">Left side sends creature fighters. Right side sends blocky defenders in a simple base battle.</p>

				<div class="zo-mvb-topbar">
					<div class="zo-mvb-stats">
						<div class="zo-mvb-stat">Energy: <span class="zo-mvb-energy">45</span></div>
						<div class="zo-mvb-stat">Monster Base: <span class="zo-mvb-left-base">320</span></div>
						<div class="zo-mvb-stat">Block Base: <span class="zo-mvb-right-base">320</span></div>
						<div class="zo-mvb-stat">Winner: <span class="zo-mvb-winner">-</span></div>
					</div>

					<div class="zo-mvb-controls">
						<button type="button" class="zo-mvb-btn zo-mvb-btn--primary zo-mvb-start">Start</button>
						<button type="button" class="zo-mvb-btn zo-mvb-btn--danger zo-mvb-restart">Restart</button>
					</div>
				</div>

				<div class="zo-mvb-layout">
					<div class="zo-mvb-board-wrap">
						<canvas class="zo-mvb-canvas" width="900" height="440" aria-label="Monster vs block world battle"></canvas>
						<div class="zo-mvb-message">Press Start. Then choose a monster unit.</div>
					</div>

					<div class="zo-mvb-side">
						<h3>Send Units</h3>

						<div class="zo-mvb-unit-grid">
							<button type="button" class="zo-mvb-unit-btn" data-unit="sparkfox">🦊 Spark Fox - 25 energy</button>
							<button type="button" class="zo-mvb-unit-btn" data-unit="leafdino">🦖 Leaf Dino - 40 energy</button>
							<button type="button" class="zo-mvb-unit-btn" data-unit="shadowbat">🦇 Shadow Bat - 55 energy</button>
						</div>

						<h3>Enemy Units</h3>
						<ul>
							<li>🧱 Block Kid</li>
							<li>⛏️ Miner</li>
							<li>💥 Boom Cube</li>
						</ul>

						<h3>How It Works</h3>
						<ul>
							<li>Start the match.</li>
							<li>Energy fills over time.</li>
							<li>Your units walk and attack automatically.</li>
							<li>Destroy the enemy base first.</li>
						</ul>
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
	'name'            => 'Monster Team vs Block World',
	'author'          => 'Arslan',
	'description'     => 'A creature team versus blocky defender base battle.',
	'render_callback' => 'zo_monster_vs_block_world_render',
	'inline_style'    => $inline_style,
	'inline_script'   => $inline_script,
);
