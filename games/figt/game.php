<?php

if (!defined('ABSPATH')) {
	exit;
}

$inline_style = <<<'CSS'
.zo-game-root--block-vs-monsters * {
	box-sizing: border-box;
}

.zo-game-root--block-vs-monsters {
	max-width: 1100px;
	margin: 0 auto;
	padding: 16px;
	font-family: Arial, sans-serif;
	color: #1f2937;
}

.zo-game-root--block-vs-monsters .zo-bvm-wrap {
	background: #ffffff;
	border: 1px solid #dbe3ea;
	border-radius: 22px;
	padding: 18px;
	box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

.zo-game-root--block-vs-monsters .zo-bvm-title {
	margin: 0 0 8px;
	text-align: center;
	font-size: 30px;
	line-height: 1.2;
}

.zo-game-root--block-vs-monsters .zo-bvm-subtitle {
	margin: 0 0 18px;
	text-align: center;
	font-size: 15px;
	color: #4b5563;
}

.zo-game-root--block-vs-monsters .zo-bvm-topbar {
	display: flex;
	flex-wrap: wrap;
	gap: 12px;
	justify-content: space-between;
	align-items: center;
	margin-bottom: 16px;
}

.zo-game-root--block-vs-monsters .zo-bvm-stats {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
}

.zo-game-root--block-vs-monsters .zo-bvm-stat {
	background: #f3f6fa;
	border: 1px solid #dbe3ea;
	border-radius: 12px;
	padding: 10px 14px;
	font-size: 14px;
	font-weight: 700;
}

.zo-game-root--block-vs-monsters .zo-bvm-controls {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	align-items: center;
}

.zo-game-root--block-vs-monsters .zo-bvm-btn {
	padding: 10px 16px;
	border-radius: 12px;
	border: 1px solid #cfd8e3;
	background: #ffffff;
	color: #1f2937;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
}

.zo-game-root--block-vs-monsters .zo-bvm-btn--primary {
	background: #2563eb;
	border-color: #2563eb;
	color: #ffffff;
}

.zo-game-root--block-vs-monsters .zo-bvm-btn--danger {
	background: #ef4444;
	border-color: #ef4444;
	color: #ffffff;
}

.zo-game-root--block-vs-monsters .zo-bvm-layout {
	display: grid;
	grid-template-columns: 1fr 290px;
	gap: 16px;
}

.zo-game-root--block-vs-monsters .zo-bvm-board-wrap {
	background: #f8fafc;
	border: 1px solid #dbe3ea;
	border-radius: 18px;
	padding: 12px;
}

.zo-game-root--block-vs-monsters .zo-bvm-canvas {
	display: block;
	width: 100%;
	height: auto;
	background: linear-gradient(180deg, #dbeafe 0%, #ecfccb 100%);
	border: 1px solid #cfd8e3;
	border-radius: 14px;
}

.zo-game-root--block-vs-monsters .zo-bvm-side {
	background: #f8fafc;
	border: 1px solid #dbe3ea;
	border-radius: 18px;
	padding: 14px;
}

.zo-game-root--block-vs-monsters .zo-bvm-side h3 {
	margin: 0 0 10px;
	font-size: 18px;
}

.zo-game-root--block-vs-monsters .zo-bvm-side p,
.zo-game-root--block-vs-monsters .zo-bvm-side li {
	font-size: 14px;
	line-height: 1.5;
	color: #4b5563;
}

.zo-game-root--block-vs-monsters .zo-bvm-side ul {
	margin: 0 0 14px;
	padding-left: 18px;
}

.zo-game-root--block-vs-monsters .zo-bvm-spawn-grid {
	display: grid;
	grid-template-columns: 1fr;
	gap: 10px;
	margin-top: 12px;
}

.zo-game-root--block-vs-monsters .zo-bvm-spawn-btn {
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

.zo-game-root--block-vs-monsters .zo-bvm-message {
	margin-top: 12px;
	padding: 12px 14px;
	border-radius: 12px;
	background: #eff6ff;
	border: 1px solid #bfdbfe;
	font-size: 14px;
	font-weight: 700;
	color: #1d4ed8;
	min-height: 46px;
}

@media (max-width: 900px) {
	.zo-game-root--block-vs-monsters .zo-bvm-layout {
		grid-template-columns: 1fr;
	}
}

@media (max-width: 640px) {
	.zo-game-root--block-vs-monsters {
		padding: 10px;
	}

	.zo-game-root--block-vs-monsters .zo-bvm-wrap {
		padding: 12px;
	}

	.zo-game-root--block-vs-monsters .zo-bvm-title {
		font-size: 24px;
	}
}
CSS;

$inline_script = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const roots = document.querySelectorAll('.zo-game-root--block-vs-monsters');

	roots.forEach(function (root) {
		const canvas = root.querySelector('.zo-bvm-canvas');
		if (!canvas) {
			return;
		}

		const ctx = canvas.getContext('2d');
		const startButton = root.querySelector('.zo-bvm-start');
		const restartButton = root.querySelector('.zo-bvm-restart');
		const energyEl = root.querySelector('.zo-bvm-energy');
		const leftBaseEl = root.querySelector('.zo-bvm-left-base');
		const rightBaseEl = root.querySelector('.zo-bvm-right-base');
		const winnerEl = root.querySelector('.zo-bvm-winner');
		const messageEl = root.querySelector('.zo-bvm-message');
		const spawnButtons = root.querySelectorAll('.zo-bvm-spawn-btn');

		const WIDTH = 860;
		const HEIGHT = 420;
		const GROUND_Y = 300;

		const unitDefs = {
			spark: {
				key: 'spark',
				name: 'Spark Beast',
				cost: 25,
				hp: 40,
				damage: 7,
				speed: 1.2,
				range: 24,
				emoji: '⚡',
				fill: '#fde68a',
				text: '#78350f'
			},
			leaf: {
				key: 'leaf',
				name: 'Leaf Beast',
				cost: 40,
				hp: 70,
				damage: 11,
				speed: 0.9,
				range: 26,
				emoji: '🍃',
				fill: '#bbf7d0',
				text: '#166534'
			},
			cube: {
				key: 'cube',
				name: 'Cube Fighter',
				cost: 30,
				hp: 55,
				damage: 8,
				speed: 1.0,
				range: 24,
				emoji: '🧱',
				fill: '#fecaca',
				text: '#991b1b'
			},
			golem: {
				key: 'golem',
				name: 'Block Golem',
				cost: 50,
				hp: 95,
				damage: 14,
				speed: 0.7,
				range: 28,
				emoji: '⛏️',
				fill: '#ddd6fe',
				text: '#5b21b6'
			}
		};

		const state = {
			running: false,
			gameOver: false,
			lastTime: 0,
			playerEnergy: 40,
			enemyEnergy: 40,
			playerEnergyMax: 100,
			enemyEnergyMax: 100,
			playerBaseHp: 300,
			enemyBaseHp: 300,
			units: [],
			enemySpawnTimer: 0,
			winner: '-'
		};

		function setMessage(text) {
			messageEl.textContent = text;
		}

		function clamp(value, min, max) {
			return Math.max(min, Math.min(max, value));
		}

		function resetGame() {
			state.running = false;
			state.gameOver = false;
			state.lastTime = 0;
			state.playerEnergy = 40;
			state.enemyEnergy = 40;
			state.playerBaseHp = 300;
			state.enemyBaseHp = 300;
			state.units = [];
			state.enemySpawnTimer = 0;
			state.winner = '-';
			updateStats();
			setMessage('Başlat ve sol takım için savaşçı çıkar.');
			draw();
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

			const startX = team === 'left' ? 90 : WIDTH - 130;

			return {
				team: team,
				typeKey: typeKey,
				name: def.name,
				x: startX,
				y: GROUND_Y,
				w: 44,
				h: 44,
				hp: def.hp,
				maxHp: def.hp,
				damage: def.damage,
				speed: def.speed,
				range: def.range,
				emoji: def.emoji,
				fill: def.fill,
				text: def.text,
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
				setMessage('Enerji yetmiyor: ' + def.name);
				return;
			}

			state.playerEnergy -= def.cost;
			state.units.push(createUnit('left', typeKey));
			setMessage(def.name + ' gönderildi.');
			updateStats();
		}

		function spawnEnemyAuto() {
			if (!state.running || state.gameOver) {
				return;
			}

			const options = ['cube', 'cube', 'spark', 'golem', 'leaf'];
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
					if (info.distance <= unit.range + 22) {
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
						const distToBase = (WIDTH - 90) - (unit.x + unit.w / 2);
						if (distToBase <= unit.range + 30) {
							if (unit.cooldown <= 0) {
								state.enemyBaseHp -= unit.damage;
								unit.cooldown = 30;
							}
						} else {
							unit.x += unit.speed;
						}
					} else {
						const distToBase = (unit.x + unit.w / 2) - 90;
						if (distToBase <= unit.range + 30) {
							if (unit.cooldown <= 0) {
								state.playerBaseHp -= unit.damage;
								unit.cooldown = 30;
							}
						} else {
							unit.x -= unit.speed;
						}
					}
				}

				unit.x = clamp(unit.x, 40, WIDTH - 84);
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
				state.winner = 'Block Team';
				setMessage('Block Team kazandı.');
			} else if (state.enemyBaseHp <= 0) {
				state.enemyBaseHp = 0;
				state.running = false;
				state.gameOver = true;
				state.winner = 'Pocket Team';
				setMessage('Pocket Team kazandı.');
			}

			updateStats();
		}

		function drawBase(x, hp, label, colors) {
			ctx.save();
			ctx.fillStyle = colors.main;
			ctx.fillRect(x, 170, 70, 130);

			ctx.fillStyle = colors.top;
			ctx.fillRect(x + 8, 150, 54, 24);

			ctx.fillStyle = '#111827';
			ctx.font = 'bold 16px Arial';
			ctx.textAlign = 'center';
			ctx.fillText(label, x + 35, 140);

			ctx.fillStyle = '#ffffff';
			ctx.fillRect(x + 6, 312, 58, 10);
			ctx.fillStyle = '#22c55e';
			ctx.fillRect(x + 6, 312, Math.max(0, 58 * (hp / 300)), 10);
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

		function drawBackground() {
			ctx.clearRect(0, 0, WIDTH, HEIGHT);

			ctx.fillStyle = '#93c5fd';
			ctx.fillRect(0, 0, WIDTH, 80);

			ctx.fillStyle = '#86efac';
			ctx.fillRect(0, 300, WIDTH, 120);

			ctx.fillStyle = '#64748b';
			ctx.fillRect(0, 285, WIDTH, 15);

			for (let i = 0; i < WIDTH; i += 60) {
				ctx.fillStyle = i % 120 === 0 ? 'rgba(255,255,255,0.12)' : 'rgba(0,0,0,0.04)';
				ctx.fillRect(i, 300, 30, 120);
			}
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
				ctx.fillText('Tekrar başlat ve yeniden savaş.', WIDTH / 2, HEIGHT / 2 + 22);
			} else {
				ctx.font = 'bold 34px Arial';
				ctx.fillText('Pocket Team vs Block Team', WIDTH / 2, HEIGHT / 2 - 12);
				ctx.font = 'bold 18px Arial';
				ctx.fillText('Başlat ve bir savaşçı gönder.', WIDTH / 2, HEIGHT / 2 + 22);
			}

			ctx.restore();
		}

		function draw() {
			drawBackground();

			drawBase(40, state.playerBaseHp, 'Pocket', {
				main: '#2563eb',
				top: '#60a5fa'
			});

			drawBase(WIDTH - 110, state.enemyBaseHp, 'Block', {
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
			setMessage('Savaş başladı. Sol takım için savaşçı çıkar.');
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

if (!function_exists('zo_block_vs_monsters_render')) {
	function zo_block_vs_monsters_render($post_id = 0, $game = array()) {
		$game_id = 'zo-block-vs-monsters-' . wp_rand(1000, 999999);

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--block-vs-monsters" id="<?php echo esc_attr($game_id); ?>">
			<div class="zo-bvm-wrap">
				<h2 class="zo-bvm-title">Pocket Team vs Block Team</h2>
				<p class="zo-bvm-subtitle">Sol taraf canavar takım. Sağ taraf blok takım. Savaşçılar otomatik dövüşür.</p>

				<div class="zo-bvm-topbar">
					<div class="zo-bvm-stats">
						<div class="zo-bvm-stat">Enerji: <span class="zo-bvm-energy">40</span></div>
						<div class="zo-bvm-stat">Sol Kale: <span class="zo-bvm-left-base">300</span></div>
						<div class="zo-bvm-stat">Sağ Kale: <span class="zo-bvm-right-base">300</span></div>
						<div class="zo-bvm-stat">Kazanan: <span class="zo-bvm-winner">-</span></div>
					</div>

					<div class="zo-bvm-controls">
						<button type="button" class="zo-bvm-btn zo-bvm-btn--primary zo-bvm-start">Başlat</button>
						<button type="button" class="zo-bvm-btn zo-bvm-btn--danger zo-bvm-restart">Sıfırla</button>
					</div>
				</div>

				<div class="zo-bvm-layout">
					<div class="zo-bvm-board-wrap">
						<canvas class="zo-bvm-canvas" width="860" height="420" aria-label="Block vs Monsters savaş alanı"></canvas>
						<div class="zo-bvm-message">Başlat ve sol takım için savaşçı çıkar.</div>
					</div>

					<div class="zo-bvm-side">
						<h3>Birlik Çıkar</h3>

						<div class="zo-bvm-spawn-grid">
							<button type="button" class="zo-bvm-spawn-btn" data-unit="spark">⚡ Spark Beast - 25 enerji</button>
							<button type="button" class="zo-bvm-spawn-btn" data-unit="leaf">🍃 Leaf Beast - 40 enerji</button>
							<button type="button" class="zo-bvm-spawn-btn" data-unit="cube">🧱 Cube Fighter - 30 enerji</button>
							<button type="button" class="zo-bvm-spawn-btn" data-unit="golem">⛏️ Block Golem - 50 enerji</button>
						</div>

						<h3 style="margin-top:16px;">Nasıl Oynanır</h3>
						<ul>
							<li>Başlat düğmesine bas.</li>
							<li>Enerji biriktikçe savaşçı çıkar.</li>
							<li>Birlikler otomatik yürür ve saldırır.</li>
							<li>Karşı kaleyi önce yıkan kazanır.</li>
						</ul>

						<p>İstersen sonraki sürümde bunu gerçek kart sistemi, özel saldırılar ve daha iyi animasyonlarla büyütebilirim.</p>
					</div>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'block-vs-monsters',
	'name'            => 'Block vs Monsters',
	'author'          => 'Arslan',
	'description'     => 'Canavar takım ile blok takımın savaştığı çizgi savaş oyunu.',
	'render_callback' => 'zo_block_vs_monsters_render',
	'inline_style'    => $inline_style,
	'inline_script'   => $inline_script,
);