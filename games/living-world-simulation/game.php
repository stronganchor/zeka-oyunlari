<?php

if (!defined('ABSPATH')) {
	exit;
}

$inline_style = <<<'CSS'
.zo-game-root--living-world * {
	box-sizing: border-box;
}

.zo-game-root--living-world {
	--zo-lw-ink: #152033;
	--zo-lw-muted: #56657f;
	--zo-lw-panel: rgba(255, 255, 255, 0.82);
	--zo-lw-line: rgba(21, 32, 51, 0.12);
	--zo-lw-glow: rgba(58, 126, 232, 0.18);
	max-width: 1180px;
	margin: 0 auto;
	padding: 18px;
	font-family: "Trebuchet MS", "Segoe UI", sans-serif;
	color: var(--zo-lw-ink);
}

.zo-game-root--living-world .zo-lw-shell {
	background:
		radial-gradient(circle at top left, rgba(255, 210, 122, 0.4), transparent 28%),
		radial-gradient(circle at top right, rgba(74, 163, 255, 0.25), transparent 24%),
		linear-gradient(180deg, #eff7ff 0%, #dff2e6 52%, #f5e7cb 100%);
	border: 1px solid rgba(255, 255, 255, 0.6);
	border-radius: 28px;
	padding: 18px;
	box-shadow: 0 24px 70px rgba(21, 32, 51, 0.12);
}

.zo-game-root--living-world .zo-lw-hero {
	display: grid;
	grid-template-columns: 1.5fr 1fr;
	gap: 16px;
	align-items: start;
	margin-bottom: 16px;
}

.zo-game-root--living-world .zo-lw-title {
	margin: 0 0 8px;
	font-size: 34px;
	line-height: 1.05;
}

.zo-game-root--living-world .zo-lw-subtitle {
	margin: 0;
	font-size: 15px;
	line-height: 1.6;
	color: var(--zo-lw-muted);
}

.zo-game-root--living-world .zo-lw-badges {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	justify-content: flex-end;
}

.zo-game-root--living-world .zo-lw-badge {
	min-width: 110px;
	padding: 12px 14px;
	border-radius: 16px;
	background: var(--zo-lw-panel);
	border: 1px solid var(--zo-lw-line);
	box-shadow: 0 12px 30px rgba(21, 32, 51, 0.06);
}

.zo-game-root--living-world .zo-lw-badge-label {
	display: block;
	font-size: 11px;
	font-weight: 700;
	letter-spacing: 0.08em;
	text-transform: uppercase;
	color: var(--zo-lw-muted);
}

.zo-game-root--living-world .zo-lw-badge-value {
	display: block;
	margin-top: 6px;
	font-size: 22px;
	font-weight: 800;
}

.zo-game-root--living-world .zo-lw-layout {
	display: grid;
	grid-template-columns: minmax(0, 1.45fr) minmax(280px, 0.75fr);
	gap: 16px;
}

.zo-game-root--living-world .zo-lw-stage,
.zo-game-root--living-world .zo-lw-panel {
	background: var(--zo-lw-panel);
	border: 1px solid var(--zo-lw-line);
	border-radius: 22px;
	box-shadow: 0 12px 28px rgba(21, 32, 51, 0.06);
}

.zo-game-root--living-world .zo-lw-stage {
	padding: 14px;
}

.zo-game-root--living-world .zo-lw-canvas {
	display: block;
	width: 100%;
	height: auto;
	border-radius: 18px;
	border: 1px solid rgba(21, 32, 51, 0.08);
	background: linear-gradient(180deg, #abd7ff 0%, #d7f2d3 58%, #f3dbb2 100%);
	touch-action: manipulation;
}

.zo-game-root--living-world .zo-lw-toolbar {
	display: flex;
	flex-wrap: wrap;
	align-items: center;
	justify-content: space-between;
	gap: 10px;
	margin-top: 12px;
}

.zo-game-root--living-world .zo-lw-controls,
.zo-game-root--living-world .zo-lw-toggles {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
}

.zo-game-root--living-world .zo-lw-btn,
.zo-game-root--living-world .zo-lw-select {
	border-radius: 14px;
	border: 1px solid rgba(21, 32, 51, 0.14);
	font: inherit;
	font-size: 14px;
}

.zo-game-root--living-world .zo-lw-btn {
	padding: 10px 14px;
	font-weight: 700;
	cursor: pointer;
	background: #ffffff;
	color: var(--zo-lw-ink);
}

.zo-game-root--living-world .zo-lw-btn--primary {
	background: #2f6fdf;
	border-color: #2f6fdf;
	color: #ffffff;
}

.zo-game-root--living-world .zo-lw-select {
	padding: 10px 12px;
	background: #ffffff;
	color: var(--zo-lw-ink);
}

.zo-game-root--living-world .zo-lw-toggle {
	display: inline-flex;
	align-items: center;
	gap: 8px;
	padding: 9px 12px;
	border-radius: 14px;
	background: rgba(255, 255, 255, 0.72);
	border: 1px solid rgba(21, 32, 51, 0.1);
	font-size: 13px;
	font-weight: 700;
	color: var(--zo-lw-muted);
}

.zo-game-root--living-world .zo-lw-toggle input {
	margin: 0;
}

.zo-game-root--living-world .zo-lw-panel {
	padding: 16px;
}

.zo-game-root--living-world .zo-lw-panel-title {
	margin: 0 0 10px;
	font-size: 19px;
}

.zo-game-root--living-world .zo-lw-help,
.zo-game-root--living-world .zo-lw-event {
	font-size: 14px;
	line-height: 1.6;
	color: var(--zo-lw-muted);
}

.zo-game-root--living-world .zo-lw-help {
	margin: 0 0 14px;
}

.zo-game-root--living-world .zo-lw-grid {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 10px;
	margin-bottom: 14px;
}

.zo-game-root--living-world .zo-lw-card {
	padding: 12px;
	border-radius: 16px;
	background: rgba(248, 251, 255, 0.8);
	border: 1px solid rgba(21, 32, 51, 0.08);
}

.zo-game-root--living-world .zo-lw-card-label {
	display: block;
	font-size: 11px;
	font-weight: 700;
	letter-spacing: 0.06em;
	text-transform: uppercase;
	color: var(--zo-lw-muted);
}

.zo-game-root--living-world .zo-lw-card-value {
	display: block;
	margin-top: 6px;
	font-size: 20px;
	font-weight: 800;
}

.zo-game-root--living-world .zo-lw-legend,
.zo-game-root--living-world .zo-lw-list {
	display: grid;
	gap: 10px;
	margin-top: 12px;
}

.zo-game-root--living-world .zo-lw-row {
	display: flex;
	align-items: center;
	justify-content: space-between;
	gap: 10px;
	font-size: 13px;
	color: var(--zo-lw-muted);
}

.zo-game-root--living-world .zo-lw-row strong {
	color: var(--zo-lw-ink);
}

.zo-game-root--living-world .zo-lw-dot {
	display: inline-block;
	width: 12px;
	height: 12px;
	margin-right: 8px;
	border-radius: 999px;
	vertical-align: middle;
	box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.7);
}

.zo-game-root--living-world .zo-lw-event {
	min-height: 70px;
	margin: 0;
	padding: 12px;
	border-radius: 16px;
	background: rgba(47, 111, 223, 0.08);
	border: 1px solid rgba(47, 111, 223, 0.16);
}

.zo-game-root--living-world .zo-lw-footer {
	margin-top: 12px;
	font-size: 12px;
	color: var(--zo-lw-muted);
}

@media (max-width: 980px) {
	.zo-game-root--living-world .zo-lw-hero,
	.zo-game-root--living-world .zo-lw-layout {
		grid-template-columns: 1fr;
	}

	.zo-game-root--living-world .zo-lw-badges {
		justify-content: flex-start;
	}
}

@media (max-width: 640px) {
	.zo-game-root--living-world {
		padding: 10px;
	}

	.zo-game-root--living-world .zo-lw-shell {
		padding: 12px;
		border-radius: 22px;
	}

	.zo-game-root--living-world .zo-lw-title {
		font-size: 28px;
	}

	.zo-game-root--living-world .zo-lw-grid {
		grid-template-columns: 1fr;
	}
}
CSS;

$inline_script = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const roots = document.querySelectorAll('.zo-game-root--living-world');

	roots.forEach(function (root) {
		if (root.dataset.zoLivingWorldReady === '1') {
			return;
		}

		root.dataset.zoLivingWorldReady = '1';

		const canvas = root.querySelector('.zo-lw-canvas');
		const ctx = canvas ? canvas.getContext('2d') : null;
		const timeEl = root.querySelector('[data-lw-time]');
		const populationEl = root.querySelector('[data-lw-population]');
		const moodEl = root.querySelector('[data-lw-mood]');
		const stateCountEl = root.querySelector('[data-lw-state-count]');
		const weatherEl = root.querySelector('[data-lw-weather]');
		const eventEl = root.querySelector('[data-lw-event]');
		const simSpeedEl = root.querySelector('[data-lw-speed]');
		const pausedEl = root.querySelector('[data-lw-paused]');
		const playPauseButton = root.querySelector('[data-lw-toggle-run]');
		const regenButton = root.querySelector('[data-lw-regenerate]');
		const speedSelect = root.querySelector('[data-lw-speed-select]');
		const labelsToggle = root.querySelector('[data-lw-toggle-labels]');
		const pathsToggle = root.querySelector('[data-lw-toggle-paths]');
		const feedList = root.querySelector('[data-lw-feed]');

		if (!canvas || !ctx || !timeEl || !populationEl || !moodEl || !stateCountEl || !weatherEl || !eventEl || !simSpeedEl || !pausedEl || !playPauseButton || !regenButton || !speedSelect || !labelsToggle || !pathsToggle || !feedList) {
			return;
		}

		const WORLD = {
			width: 960,
			height: 640,
			cell: 32,
			npcCount: 64
		};
		const GRID_COLS = WORLD.width / WORLD.cell;
		const GRID_ROWS = WORLD.height / WORLD.cell;
		const BUILDING_TYPES = [
			{ key: 'home', label: 'Homes', color: '#f2c27b' },
			{ key: 'farm', label: 'Farms', color: '#6fbc61' },
			{ key: 'shop', label: 'Shops', color: '#7ba8f6' },
			{ key: 'plaza', label: 'Plazas', color: '#c48eed' },
			{ key: 'kitchen', label: 'Kitchen', color: '#ef8f78' }
		];
		const STATE_COLORS = {
			sleeping: '#2f5aa8',
			working: '#2f9f5f',
			eating: '#e48a2d',
			wandering: '#8c61dc',
			chatting: '#f0537d'
		};
		const WEATHER_TYPES = ['Sunny', 'Windy', 'Cloudy', 'Rainy'];

		let animationFrame = 0;
		let lastTimestamp = 0;
		let state = null;

		function clamp(value, min, max) {
			return Math.max(min, Math.min(max, value));
		}

		function randomInt(min, max) {
			return min + Math.floor(Math.random() * (max - min + 1));
		}

		function randomChoice(list) {
			return list[Math.floor(Math.random() * list.length)];
		}

		function chance(value) {
			return Math.random() < value;
		}

		function hashNoise(x, y, seed) {
			const waveA = Math.sin((x * 0.41) + (seed * 0.13));
			const waveB = Math.cos((y * 0.37) - (seed * 0.19));
			const waveC = Math.sin(((x + y) * 0.17) + (seed * 0.07));
			return (waveA + waveB + waveC + 3) / 6;
		}

		function buildingColor(key) {
			const item = BUILDING_TYPES.find(function (type) {
				return type.key === key;
			});

			return item ? item.color : '#cccccc';
		}

		function stateLabel(key) {
			if (key === 'sleeping') {
				return 'Sleeping';
			}
			if (key === 'working') {
				return 'Working';
			}
			if (key === 'eating') {
				return 'Eating';
			}
			if (key === 'chatting') {
				return 'Chatting';
			}
			return 'Wandering';
		}

		function formatClock(hours) {
			const h = Math.floor(hours) % 24;
			const minutes = Math.floor((hours - Math.floor(hours)) * 60);
			const paddedMinutes = minutes < 10 ? '0' + minutes : String(minutes);
			return h + ':' + paddedMinutes;
		}

		function dayPeriod(hours) {
			if (hours < 6) {
				return 'Night';
			}
			if (hours < 12) {
				return 'Morning';
			}
			if (hours < 18) {
				return 'Afternoon';
			}
			return 'Evening';
		}

		function isRoadCell(cell) {
			return cell.kind === 'road' || cell.kind === 'plaza';
		}

		function cellCenter(cell) {
			return {
				x: (cell.col * WORLD.cell) + (WORLD.cell / 2),
				y: (cell.row * WORLD.cell) + (WORLD.cell / 2)
			};
		}

		function neighbors(col, row) {
			return [
				{ col: col + 1, row: row },
				{ col: col - 1, row: row },
				{ col: col, row: row + 1 },
				{ col: col, row: row - 1 }
			].filter(function (item) {
				return item.col >= 0 && item.col < GRID_COLS && item.row >= 0 && item.row < GRID_ROWS;
			});
		}

		function pathfind(start, target, grid) {
			if (!start || !target) {
				return [];
			}

			const startKey = start.col + ',' + start.row;
			const targetKey = target.col + ',' + target.row;
			const queue = [start];
			const seen = new Set([startKey]);
			const parents = {};

			while (queue.length > 0) {
				const current = queue.shift();
				const currentKey = current.col + ',' + current.row;

				if (currentKey === targetKey) {
					break;
				}

				neighbors(current.col, current.row).forEach(function (next) {
					const nextCell = grid[next.row][next.col];
					const nextKey = next.col + ',' + next.row;

					if (!isRoadCell(nextCell) || seen.has(nextKey)) {
						return;
					}

					seen.add(nextKey);
					parents[nextKey] = currentKey;
					queue.push(next);
				});
			}

			if (!seen.has(targetKey)) {
				return [];
			}

			const path = [];
			let currentKey = targetKey;

			while (currentKey && currentKey !== startKey) {
				const parts = currentKey.split(',');
				path.push({ col: parseInt(parts[0], 10), row: parseInt(parts[1], 10) });
				currentKey = parents[currentKey];
			}

			path.reverse();
			return path;
		}

		function createWorld() {
			const seed = randomInt(1000, 999999);
			const grid = [];
			const buildings = [];
			const roadCols = [5, 10, 15, 21, 26];
			const roadRows = [4, 9, 14];
			const stats = {
				home: 0,
				farm: 0,
				shop: 0,
				plaza: 0,
				kitchen: 0
			};

			for (let row = 0; row < GRID_ROWS; row += 1) {
				const rowCells = [];

				for (let col = 0; col < GRID_COLS; col += 1) {
					const noise = hashNoise(col, row, seed);
					let terrain = 'grass';

					if (noise < 0.22) {
						terrain = 'water';
					} else if (noise < 0.33) {
						terrain = 'sand';
					}

					rowCells.push({
						col: col,
						row: row,
						terrain: terrain,
						kind: 'terrain',
						buildingType: ''
					});
				}

				grid.push(rowCells);
			}

			roadCols.forEach(function (col) {
				for (let row = 0; row < GRID_ROWS; row += 1) {
					grid[row][col].terrain = 'road';
					grid[row][col].kind = 'road';
				}
			});

			roadRows.forEach(function (row) {
				for (let col = 0; col < GRID_COLS; col += 1) {
					grid[row][col].terrain = 'road';
					grid[row][col].kind = 'road';
				}
			});

			const plotPlan = [
				{ col: 3, row: 2, w: 2, h: 2, type: 'home' },
				{ col: 7, row: 1, w: 2, h: 2, type: 'home' },
				{ col: 12, row: 1, w: 2, h: 2, type: 'shop' },
				{ col: 17, row: 1, w: 3, h: 2, type: 'farm' },
				{ col: 23, row: 1, w: 2, h: 2, type: 'home' },
				{ col: 27, row: 1, w: 2, h: 2, type: 'shop' },
				{ col: 2, row: 6, w: 2, h: 2, type: 'home' },
				{ col: 7, row: 6, w: 2, h: 2, type: 'farm' },
				{ col: 12, row: 6, w: 3, h: 2, type: 'plaza' },
				{ col: 17, row: 6, w: 2, h: 2, type: 'shop' },
				{ col: 23, row: 6, w: 2, h: 2, type: 'kitchen' },
				{ col: 27, row: 6, w: 2, h: 2, type: 'home' },
				{ col: 2, row: 11, w: 2, h: 2, type: 'farm' },
				{ col: 7, row: 11, w: 2, h: 2, type: 'home' },
				{ col: 12, row: 11, w: 2, h: 2, type: 'home' },
				{ col: 17, row: 11, w: 3, h: 2, type: 'shop' },
				{ col: 23, row: 11, w: 2, h: 2, type: 'farm' },
				{ col: 27, row: 11, w: 2, h: 2, type: 'home' },
				{ col: 2, row: 16, w: 2, h: 2, type: 'home' },
				{ col: 7, row: 16, w: 2, h: 2, type: 'shop' },
				{ col: 12, row: 16, w: 2, h: 2, type: 'farm' },
				{ col: 17, row: 16, w: 2, h: 2, type: 'home' },
				{ col: 23, row: 16, w: 2, h: 2, type: 'plaza' },
				{ col: 27, row: 16, w: 2, h: 2, type: 'home' }
			];

			plotPlan.forEach(function (plot, index) {
				const anchor = {
					col: plot.col + Math.floor(plot.w / 2),
					row: plot.row + plot.h
				};

				for (let row = plot.row; row < plot.row + plot.h; row += 1) {
					for (let col = plot.col; col < plot.col + plot.w; col += 1) {
						if (row >= 0 && row < GRID_ROWS && col >= 0 && col < GRID_COLS) {
							grid[row][col].terrain = plot.type;
							grid[row][col].kind = 'building';
							grid[row][col].buildingType = plot.type;
						}
					}
				}

				if (anchor.row < GRID_ROWS) {
					grid[anchor.row][anchor.col].terrain = plot.type === 'plaza' ? 'plaza' : 'road';
					grid[anchor.row][anchor.col].kind = plot.type === 'plaza' ? 'plaza' : 'road';
				}

				buildings.push({
					id: 'building-' + index,
					type: plot.type,
					col: plot.col,
					row: plot.row,
					width: plot.w,
					height: plot.h,
					door: anchor
				});
				stats[plot.type] += 1;
			});

			return {
				seed: seed,
				grid: grid,
				buildings: buildings,
				stats: stats
			};
		}

		function buildingPool(world, type) {
			return world.buildings.filter(function (building) {
				return building.type === type;
			});
		}

		function createNpc(index, world) {
			const homes = buildingPool(world, 'home');
			const jobs = world.buildings.filter(function (building) {
				return building.type === 'farm' || building.type === 'shop' || building.type === 'kitchen';
			});
			const social = world.buildings.filter(function (building) {
				return building.type === 'plaza' || building.type === 'shop' || building.type === 'kitchen';
			});
			const home = homes[index % homes.length];
			const job = jobs[(index * 3) % jobs.length];
			const meal = social[(index * 5) % social.length];
			const housePoint = cellCenter(world.grid[home.door.row][home.door.col]);

			return {
				id: index,
				name: 'NPC ' + (index + 1),
				home: home,
				job: job,
				meal: meal,
				state: 'sleeping',
				mood: 72 + randomInt(-8, 8),
				hunger: randomInt(10, 30),
				energy: randomInt(62, 86),
				social: randomInt(45, 75),
				x: housePoint.x + randomInt(-6, 6),
				y: housePoint.y + randomInt(-6, 6),
				path: [],
				target: null,
				speed: 18 + Math.random() * 10,
				taskTimer: 0,
				chatTargetId: -1
			};
		}

		function logEvent(text) {
			state.feed.unshift(text);
			state.feed = state.feed.slice(0, 5);
		}

		function goToBuilding(npc, building) {
			const start = {
				col: clamp(Math.floor(npc.x / WORLD.cell), 0, GRID_COLS - 1),
				row: clamp(Math.floor(npc.y / WORLD.cell), 0, GRID_ROWS - 1)
			};
			const path = pathfind(start, building.door, state.world.grid);

			npc.path = path;
			npc.target = building;
		}

		function pickRandomDestination() {
			return randomChoice(state.world.buildings);
		}

		function setNpcState(npc, nextState) {
			if (npc.state !== nextState) {
				npc.state = nextState;
				npc.taskTimer = 2 + Math.random() * 4;
			}
		}

		function updateNeeds(npc, deltaHours) {
			npc.hunger = clamp(npc.hunger + (deltaHours * (npc.state === 'working' ? 8 : 5)), 0, 100);
			npc.social = clamp(npc.social - (deltaHours * (npc.state === 'chatting' ? -6 : 2)), 0, 100);

			if (npc.state === 'sleeping') {
				npc.energy = clamp(npc.energy + (deltaHours * 18), 0, 100);
			} else if (npc.state === 'working') {
				npc.energy = clamp(npc.energy - (deltaHours * 9), 0, 100);
			} else {
				npc.energy = clamp(npc.energy - (deltaHours * 5), 0, 100);
			}

			npc.mood = clamp(55 + ((100 - npc.hunger) * 0.2) + (npc.energy * 0.15) + (npc.social * 0.12), 0, 100);
		}

		function decideNextState(npc) {
			const hour = state.hour;

			if (hour >= 22 || hour < 6 || npc.energy < 22) {
				setNpcState(npc, 'sleeping');
				goToBuilding(npc, npc.home);
				return;
			}

			if ((hour >= 12 && hour < 14) || npc.hunger > 72) {
				setNpcState(npc, 'eating');
				goToBuilding(npc, npc.meal);
				return;
			}

			if (hour >= 8 && hour < 17) {
				setNpcState(npc, 'working');
				goToBuilding(npc, npc.job);
				return;
			}

			if (npc.social < 28) {
				setNpcState(npc, 'chatting');
				goToBuilding(npc, randomChoice(buildingPool(state.world, 'plaza')));
				return;
			}

			setNpcState(npc, 'wandering');
			goToBuilding(npc, pickRandomDestination());
		}

		function updateMovement(npc, deltaSeconds) {
			if (!npc.path || npc.path.length === 0) {
				return;
			}

			const next = npc.path[0];
			const cell = state.world.grid[next.row][next.col];
			const point = cellCenter(cell);
			const dx = point.x - npc.x;
			const dy = point.y - npc.y;
			const distance = Math.sqrt((dx * dx) + (dy * dy));
			const step = npc.speed * deltaSeconds * (state.speed * 0.9);

			if (distance <= step || distance < 2) {
				npc.x = point.x;
				npc.y = point.y;
				npc.path.shift();
			} else if (distance > 0) {
				npc.x += (dx / distance) * step;
				npc.y += (dy / distance) * step;
			}
		}

		function updateBehavior(npc, deltaHours) {
			updateNeeds(npc, deltaHours);

			if (!npc.path || npc.path.length === 0) {
				npc.taskTimer -= deltaHours * 8;
			}

			if (!npc.path || npc.path.length === 0) {
				if (npc.state === 'sleeping') {
					npc.energy = clamp(npc.energy + (deltaHours * 12), 0, 100);
					if (state.hour >= 6 && state.hour < 8 && npc.energy > 70) {
						decideNextState(npc);
					}
					return;
				}

				if (npc.state === 'eating') {
					npc.hunger = clamp(npc.hunger - (deltaHours * 28), 0, 100);
					if (npc.taskTimer <= 0) {
						decideNextState(npc);
					}
					return;
				}

				if (npc.state === 'working') {
					npc.mood = clamp(npc.mood + (deltaHours * (state.weather === 'Sunny' ? 2 : -2)), 0, 100);
					if (npc.taskTimer <= 0 && chance(0.015 * state.speed)) {
						decideNextState(npc);
					}
					return;
				}

				if (npc.state === 'chatting') {
					npc.social = clamp(npc.social + (deltaHours * 24), 0, 100);
					npc.mood = clamp(npc.mood + (deltaHours * 10), 0, 100);
					if (npc.taskTimer <= 0) {
						decideNextState(npc);
					}
					return;
				}

				if (npc.taskTimer <= 0 || chance(0.02 * state.speed)) {
					decideNextState(npc);
				}
			}
		}

		function averageMood() {
			if (!state.npcs.length) {
				return 0;
			}

			const total = state.npcs.reduce(function (sum, npc) {
				return sum + npc.mood;
			}, 0);

			return Math.round(total / state.npcs.length);
		}

		function countState(key) {
			return state.npcs.filter(function (npc) {
				return npc.state === key;
			}).length;
		}

		function maybeTriggerTownEvent(previousHour) {
			const currentHour = Math.floor(state.hour);

			if (Math.floor(previousHour) === currentHour) {
				return;
			}

			if (currentHour === 6) {
				logEvent('Sunrise wakes the town. Doorways fill as people leave their homes.');
			} else if (currentHour === 12) {
				logEvent('Lunch hour begins. Workers drift toward kitchens and plazas.');
			} else if (currentHour === 18) {
				logEvent('Shops slow down and wandering groups begin to form.');
			} else if (currentHour === 22) {
				logEvent('Lanterns dim. The town gets quiet as sleep schedules take over.');
			}

			if (chance(0.18)) {
				state.weather = randomChoice(WEATHER_TYPES);
				logEvent('Weather changed to ' + state.weather + '. NPC mood shifts slightly.');
				state.npcs.forEach(function (npc) {
					if (state.weather === 'Rainy') {
						npc.mood = clamp(npc.mood - 2, 0, 100);
					} else if (state.weather === 'Sunny') {
						npc.mood = clamp(npc.mood + 2, 0, 100);
					}
				});
			}
		}

		function populateFeed() {
			feedList.innerHTML = '';
			state.feed.forEach(function (entry) {
				const row = document.createElement('div');
				row.className = 'zo-lw-row';

				const source = document.createElement('strong');
				source.textContent = 'Town';

				const text = document.createElement('span');
				text.textContent = entry;

				row.appendChild(source);
				row.appendChild(text);
				feedList.appendChild(row);
			});
		}

		function updateHud() {
			const mood = averageMood();
			const activeKey = ['sleeping', 'working', 'eating', 'wandering', 'chatting'].sort(function (a, b) {
				return countState(b) - countState(a);
			})[0];

			timeEl.textContent = formatClock(state.hour) + ' ' + dayPeriod(state.hour);
			populationEl.textContent = String(state.npcs.length);
			moodEl.textContent = String(mood);
			stateCountEl.textContent = stateLabel(activeKey);
			weatherEl.textContent = state.weather;
			simSpeedEl.textContent = state.speed.toFixed(1) + 'x';
			pausedEl.textContent = state.paused ? 'Paused' : 'Running';
			playPauseButton.textContent = state.paused ? 'Resume' : 'Pause';
			eventEl.textContent = state.feed[0] || 'The town is calm. Watch patterns appear as routines overlap.';
			populateFeed();
		}

		function terrainColor(cell) {
			if (cell.kind === 'road') {
				return '#cdbd93';
			}
			if (cell.kind === 'plaza') {
				return '#d9c7e8';
			}
			if (cell.kind === 'building') {
				return buildingColor(cell.buildingType);
			}
			if (cell.terrain === 'water') {
				return '#79b8f2';
			}
			if (cell.terrain === 'sand') {
				return '#e8d3a6';
			}
			return '#9cd38d';
		}

		function drawWorld() {
			ctx.clearRect(0, 0, WORLD.width, WORLD.height);

			for (let row = 0; row < GRID_ROWS; row += 1) {
				for (let col = 0; col < GRID_COLS; col += 1) {
					const cell = state.world.grid[row][col];
					ctx.fillStyle = terrainColor(cell);
					ctx.fillRect(col * WORLD.cell, row * WORLD.cell, WORLD.cell, WORLD.cell);
					ctx.strokeStyle = 'rgba(21, 32, 51, 0.05)';
					ctx.strokeRect(col * WORLD.cell, row * WORLD.cell, WORLD.cell, WORLD.cell);
				}
			}

			state.world.buildings.forEach(function (building) {
				ctx.fillStyle = 'rgba(21, 32, 51, 0.08)';
				ctx.fillRect(
					(building.col * WORLD.cell) + 6,
					(building.row * WORLD.cell) + 6,
					(building.width * WORLD.cell) - 12,
					(building.height * WORLD.cell) - 12
				);

				if (labelsToggle.checked) {
					ctx.fillStyle = '#152033';
					ctx.font = 'bold 12px Trebuchet MS';
					ctx.fillText(
						building.type.charAt(0).toUpperCase() + building.type.slice(1),
						(building.col * WORLD.cell) + 8,
						(building.row * WORLD.cell) + 18
					);
				}
			});

			if (pathsToggle.checked) {
				state.npcs.slice(0, 14).forEach(function (npc) {
					if (!npc.path || npc.path.length === 0) {
						return;
					}

					ctx.beginPath();
					ctx.moveTo(npc.x, npc.y);
					npc.path.forEach(function (step) {
						const point = cellCenter(state.world.grid[step.row][step.col]);
						ctx.lineTo(point.x, point.y);
					});
					ctx.strokeStyle = 'rgba(47, 111, 223, 0.18)';
					ctx.lineWidth = 2;
					ctx.stroke();
				});
			}

			state.npcs.forEach(function (npc) {
				ctx.beginPath();
				ctx.arc(npc.x, npc.y, 6, 0, Math.PI * 2);
				ctx.fillStyle = STATE_COLORS[npc.state] || '#333333';
				ctx.fill();

				if (labelsToggle.checked && npc.id < 10) {
					ctx.fillStyle = '#152033';
					ctx.font = '11px Trebuchet MS';
					ctx.fillText(stateLabel(npc.state), npc.x + 8, npc.y - 8);
				}
			});

			const timeTint = Math.abs(12 - state.hour) / 12;
			ctx.fillStyle = 'rgba(16, 34, 66, ' + (timeTint * 0.26).toFixed(3) + ')';
			ctx.fillRect(0, 0, WORLD.width, WORLD.height);
		}

		function stepSimulation(deltaSeconds) {
			const deltaHours = deltaSeconds * 0.9 * state.speed;
			const previousHour = state.hour;

			state.hour += deltaHours;
			if (state.hour >= 24) {
				state.hour -= 24;
				state.day += 1;
				logEvent('Day ' + state.day + ' begins. The simulation keeps evolving.');
			}

			maybeTriggerTownEvent(previousHour);

			state.npcs.forEach(function (npc) {
				updateMovement(npc, deltaSeconds);
				updateBehavior(npc, deltaHours);
			});

			updateHud();
		}

		function render(timestamp) {
			if (!lastTimestamp) {
				lastTimestamp = timestamp;
			}

			const deltaSeconds = Math.min(0.04, (timestamp - lastTimestamp) / 1000);
			lastTimestamp = timestamp;

			if (!state.paused) {
				stepSimulation(deltaSeconds);
			}

			drawWorld();
			animationFrame = window.requestAnimationFrame(render);
		}

		function initializeTown() {
			const world = createWorld();
			const npcs = [];

			for (let i = 0; i < WORLD.npcCount; i += 1) {
				npcs.push(createNpc(i, world));
			}

			state = {
				world: world,
				npcs: npcs,
				hour: 5.5,
				day: 1,
				weather: 'Sunny',
				speed: parseFloat(speedSelect.value || '1'),
				paused: false,
				feed: [
					'A new town was generated with roads, jobs, and homes.',
					'NPC routines are now running: sleep, work, eat, chat, wander.'
				]
			};

			state.npcs.forEach(function (npc) {
				decideNextState(npc);
			});

			updateHud();
			drawWorld();
		}

		playPauseButton.addEventListener('click', function () {
			state.paused = !state.paused;
			updateHud();
		});

		regenButton.addEventListener('click', function () {
			initializeTown();
		});

		speedSelect.addEventListener('change', function () {
			state.speed = parseFloat(speedSelect.value || '1');
			updateHud();
		});

		initializeTown();
		animationFrame = window.requestAnimationFrame(render);
	});
});
JS;

if (!function_exists('zo_game_living_world_simulation_render')) {
	function zo_game_living_world_simulation_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-living-world-simulation-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--living-world" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-lw-shell">
				<div class="zo-lw-hero">
					<div>
						<h2 class="zo-lw-title">Living World Simulation</h2>
						<p class="zo-lw-subtitle">Watch a procedurally generated town run itself. Sixty-four villagers decide when to sleep, work, eat, socialize, and wander while weather and time-of-day keep nudging the whole system.</p>
					</div>
					<div class="zo-lw-badges">
						<div class="zo-lw-badge">
							<span class="zo-lw-badge-label">Clock</span>
							<span class="zo-lw-badge-value" data-lw-time>5:30 Morning</span>
						</div>
						<div class="zo-lw-badge">
							<span class="zo-lw-badge-label">Population</span>
							<span class="zo-lw-badge-value" data-lw-population>64</span>
						</div>
						<div class="zo-lw-badge">
							<span class="zo-lw-badge-label">Town Mood</span>
							<span class="zo-lw-badge-value" data-lw-mood>72</span>
						</div>
					</div>
				</div>

				<div class="zo-lw-layout">
					<div class="zo-lw-stage">
						<canvas class="zo-lw-canvas" width="960" height="640" aria-label="Living town simulation"></canvas>
						<div class="zo-lw-toolbar">
							<div class="zo-lw-controls">
								<button type="button" class="zo-lw-btn zo-lw-btn--primary" data-lw-toggle-run>Pause</button>
								<button type="button" class="zo-lw-btn" data-lw-regenerate>Generate New Town</button>
								<select class="zo-lw-select" data-lw-speed-select aria-label="Simulation speed">
									<option value="0.6">Slow</option>
									<option value="1" selected>Normal</option>
									<option value="1.6">Fast</option>
									<option value="2.4">Very Fast</option>
								</select>
							</div>
							<div class="zo-lw-toggles">
								<label class="zo-lw-toggle"><input type="checkbox" data-lw-toggle-labels checked> Labels</label>
								<label class="zo-lw-toggle"><input type="checkbox" data-lw-toggle-paths> Paths</label>
							</div>
						</div>
						<p class="zo-lw-footer">State colors: blue sleep, green work, orange eat, purple wander, pink chat.</p>
					</div>

					<div class="zo-lw-panel">
						<h3 class="zo-lw-panel-title">Town Overlay</h3>
						<p class="zo-lw-help">This is a toy agent-based simulation. No hero to control: the fun is watching routines overlap and seeing crowd behavior emerge from simple rules.</p>

						<div class="zo-lw-grid">
							<div class="zo-lw-card">
								<span class="zo-lw-card-label">Most Common State</span>
								<span class="zo-lw-card-value" data-lw-state-count>Sleeping</span>
							</div>
							<div class="zo-lw-card">
								<span class="zo-lw-card-label">Weather</span>
								<span class="zo-lw-card-value" data-lw-weather>Sunny</span>
							</div>
							<div class="zo-lw-card">
								<span class="zo-lw-card-label">Simulation Speed</span>
								<span class="zo-lw-card-value" data-lw-speed>1.0x</span>
							</div>
							<div class="zo-lw-card">
								<span class="zo-lw-card-label">Status</span>
								<span class="zo-lw-card-value" data-lw-paused>Running</span>
							</div>
						</div>

						<div class="zo-lw-legend">
							<div class="zo-lw-row"><span><span class="zo-lw-dot" style="background:#f2c27b;"></span>Homes</span><strong>Sleep starts here</strong></div>
							<div class="zo-lw-row"><span><span class="zo-lw-dot" style="background:#6fbc61;"></span>Farms</span><strong>Work site</strong></div>
							<div class="zo-lw-row"><span><span class="zo-lw-dot" style="background:#7ba8f6;"></span>Shops</span><strong>Work and socialize</strong></div>
							<div class="zo-lw-row"><span><span class="zo-lw-dot" style="background:#ef8f78;"></span>Kitchen</span><strong>Meal target</strong></div>
							<div class="zo-lw-row"><span><span class="zo-lw-dot" style="background:#c48eed;"></span>Plazas</span><strong>Social hub</strong></div>
						</div>

						<h3 class="zo-lw-panel-title">Latest Event</h3>
						<p class="zo-lw-event" data-lw-event>The town is calm. Watch patterns appear as routines overlap.</p>

						<h3 class="zo-lw-panel-title">Activity Feed</h3>
						<div class="zo-lw-list" data-lw-feed></div>
					</div>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'living-world-simulation',
	'name'            => 'Living World Simulation',
	'author'          => 'Arslan',
	'description'     => 'Watch dozens of autonomous villagers live inside a procedurally generated town.',
	'render_callback' => 'zo_game_living_world_simulation_render',
	'inline_style'    => $inline_style,
	'inline_script'   => $inline_script,
);
