<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--city-grid-revival {
	--cgr-ink: #10223a;
	--cgr-soft: #42526b;
	max-width: 1000px;
	margin: 0 auto;
	padding: 20px;
	border-radius: 24px;
	border: 2px solid rgba(37, 99, 235, 0.16);
	background:
		radial-gradient(circle at top right, rgba(56, 189, 248, 0.18), transparent 24%),
		linear-gradient(180deg, #eff6ff 0%, #dbeafe 100%);
	box-sizing: border-box;
	font-family: "Trebuchet MS", Verdana, sans-serif;
	color: var(--cgr-ink);
}

.zo-game-root--city-grid-revival .zo-cgr-title {
	margin: 0 0 8px;
	font-size: 34px;
	text-align: center;
	color: #1d4ed8;
}

.zo-game-root--city-grid-revival .zo-cgr-desc {
	margin: 0 0 18px;
	text-align: center;
	line-height: 1.55;
	color: var(--cgr-soft);
}

.zo-game-root--city-grid-revival .zo-cgr-top {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 10px;
	margin-bottom: 14px;
}

.zo-game-root--city-grid-revival .zo-cgr-stat,
.zo-game-root--city-grid-revival .zo-cgr-panel {
	padding: 12px;
	border-radius: 16px;
	background: rgba(255, 255, 255, 0.74);
	border: 1px solid rgba(37, 99, 235, 0.12);
}

.zo-game-root--city-grid-revival .zo-cgr-stat-label {
	display: block;
	margin-bottom: 4px;
	font-size: 12px;
	text-transform: uppercase;
	letter-spacing: 0.08em;
	color: #2563eb;
}

.zo-game-root--city-grid-revival .zo-cgr-stat-value {
	display: block;
	font-size: 24px;
	font-weight: 700;
}

.zo-game-root--city-grid-revival .zo-cgr-main {
	display: grid;
	grid-template-columns: 1fr 0.95fr;
	gap: 14px;
}

.zo-game-root--city-grid-revival .zo-cgr-board {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 8px;
}

.zo-game-root--city-grid-revival .zo-cgr-tile {
	position: relative;
	aspect-ratio: 1;
	border-radius: 14px;
	border: 1px solid rgba(37, 99, 235, 0.12);
	background: #f8fbff;
	cursor: pointer;
}

.zo-game-root--city-grid-revival .zo-cgr-tile.is-locked {
	cursor: default;
	background: #eff6ff;
}

.zo-game-root--city-grid-revival .zo-cgr-tile.is-connected {
	box-shadow: inset 0 0 0 999px rgba(59, 130, 246, 0.08);
}

.zo-game-root--city-grid-revival .zo-cgr-core {
	position: absolute;
	left: 50%;
	top: 50%;
	width: 18px;
	height: 18px;
	margin-left: -9px;
	margin-top: -9px;
	border-radius: 8px;
	background: #93c5fd;
}

.zo-game-root--city-grid-revival .zo-cgr-seg {
	position: absolute;
	background: #60a5fa;
}

.zo-game-root--city-grid-revival .zo-cgr-seg--up,
.zo-game-root--city-grid-revival .zo-cgr-seg--down {
	left: 50%;
	width: 10px;
	margin-left: -5px;
}

.zo-game-root--city-grid-revival .zo-cgr-seg--left,
.zo-game-root--city-grid-revival .zo-cgr-seg--right {
	top: 50%;
	height: 10px;
	margin-top: -5px;
}

.zo-game-root--city-grid-revival .zo-cgr-seg--up {
	top: 0;
	height: 50%;
}

.zo-game-root--city-grid-revival .zo-cgr-seg--right {
	right: 0;
	width: 50%;
}

.zo-game-root--city-grid-revival .zo-cgr-seg--down {
	bottom: 0;
	height: 50%;
}

.zo-game-root--city-grid-revival .zo-cgr-seg--left {
	left: 0;
	width: 50%;
}

.zo-game-root--city-grid-revival .zo-cgr-label {
	position: absolute;
	inset: auto 0 8px;
	text-align: center;
	font-size: 11px;
	font-weight: 700;
	color: #1d4ed8;
}

.zo-game-root--city-grid-revival .zo-cgr-subtitle {
	margin: 0 0 10px;
	font-size: 18px;
	color: #1d4ed8;
}

.zo-game-root--city-grid-revival .zo-cgr-controls {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 10px;
	margin-top: 10px;
}

.zo-game-root--city-grid-revival .zo-cgr-button {
	border: 0;
	border-radius: 14px;
	padding: 12px 14px;
	font-size: 14px;
	font-weight: 700;
	cursor: pointer;
}

.zo-game-root--city-grid-revival .zo-cgr-button--next {
	background: #1d4ed8;
	color: #ffffff;
}

.zo-game-root--city-grid-revival .zo-cgr-button--reset {
	background: #ffffff;
	color: #1d4ed8;
	border: 1px solid rgba(37, 99, 235, 0.16);
}

.zo-game-root--city-grid-revival .zo-cgr-status,
.zo-game-root--city-grid-revival .zo-cgr-help {
	line-height: 1.55;
	color: var(--cgr-soft);
}

@media (max-width: 860px) {
	.zo-game-root--city-grid-revival {
		padding: 14px;
	}

	.zo-game-root--city-grid-revival .zo-cgr-top {
		grid-template-columns: 1fr 1fr;
	}

	.zo-game-root--city-grid-revival .zo-cgr-main {
		grid-template-columns: 1fr;
	}

	.zo-game-root--city-grid-revival .zo-cgr-controls {
		grid-template-columns: 1fr;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const roots = document.querySelectorAll('.zo-game-root--city-grid-revival');

	roots.forEach(function (root) {
		const boardEl = root.querySelector('.zo-cgr-board');
		const serviceEl = root.querySelector('.zo-cgr-service');
		const roundEl = root.querySelector('.zo-cgr-round');
		const connectedEl = root.querySelector('.zo-cgr-connected');
		const statusEl = root.querySelector('.zo-cgr-status');
		const nextButton = root.querySelector('.zo-cgr-button--next');
		const resetButton = root.querySelector('.zo-cgr-button--reset');

		const levels = [
			{
				service: 'Power',
				grid: [
					[{ type: 'source', rot: 0, locked: true, label: 'P' }, { type: 'tee', rot: 2 }, { type: 'tee', rot: 2 }, { type: 'district', rot: 0, locked: true, label: 'D1' }],
					[{ type: 'corner', rot: 1 }, { type: 'straight', rot: 0 }, { type: 'straight', rot: 0 }, { type: 'corner', rot: 2 }],
					[{ type: 'straight', rot: 0 }, { type: 'corner', rot: 0 }, { type: 'cross', rot: 0 }, { type: 'district', rot: 0, locked: true, label: 'D2' }],
					[{ type: 'corner', rot: 0 }, { type: 'tee', rot: 1 }, { type: 'district', rot: 1, locked: true, label: 'D3' }, { type: 'corner', rot: 3 }]
				]
			},
			{
				service: 'Water',
				grid: [
					[{ type: 'source', rot: 0, locked: true, label: 'W' }, { type: 'tee', rot: 2 }, { type: 'tee', rot: 2 }, { type: 'district', rot: 0, locked: true, label: 'D1' }],
					[{ type: 'corner', rot: 2 }, { type: 'straight', rot: 0 }, { type: 'straight', rot: 0 }, { type: 'corner', rot: 1 }],
					[{ type: 'corner', rot: 3 }, { type: 'corner', rot: 0 }, { type: 'cross', rot: 0 }, { type: 'district', rot: 0, locked: true, label: 'D2' }],
					[{ type: 'straight', rot: 1 }, { type: 'tee', rot: 3 }, { type: 'district', rot: 1, locked: true, label: 'D3' }, { type: 'corner', rot: 0 }]
				]
			},
			{
				service: 'Transit',
				grid: [
					[{ type: 'source', rot: 0, locked: true, label: 'T' }, { type: 'tee', rot: 2 }, { type: 'tee', rot: 2 }, { type: 'district', rot: 0, locked: true, label: 'D1' }],
					[{ type: 'tee', rot: 0 }, { type: 'straight', rot: 0 }, { type: 'straight', rot: 0 }, { type: 'corner', rot: 2 }],
					[{ type: 'corner', rot: 1 }, { type: 'corner', rot: 0 }, { type: 'cross', rot: 0 }, { type: 'district', rot: 0, locked: true, label: 'D2' }],
					[{ type: 'corner', rot: 0 }, { type: 'tee', rot: 1 }, { type: 'district', rot: 1, locked: true, label: 'D3' }, { type: 'straight', rot: 1 }]
				]
			}
		];

		let levelIndex = 0;
		let grid = [];
		let solved = false;

		function rotateSide(side, amount) {
			return (side + amount) % 4;
		}

		function getOpenings(type, rot) {
			let openings = [];

			if (type === 'straight') {
				openings = [0, 2];
			} else if (type === 'corner') {
				openings = [0, 1];
			} else if (type === 'tee') {
				openings = [0, 1, 3];
			} else if (type === 'cross') {
				openings = [0, 1, 2, 3];
			} else if (type === 'source') {
				openings = [1];
			} else if (type === 'district') {
				openings = [3];
			}

			return openings.map(function (side) {
				return rotateSide(side, rot);
			});
		}

		function sidesConnect(aOpenings, bOpenings, side) {
			const opposite = (side + 2) % 4;
			return aOpenings.indexOf(side) !== -1 && bOpenings.indexOf(opposite) !== -1;
		}

		function cloneLevel(level) {
			return level.grid.map(function (row) {
				return row.map(function (tile) {
					return {
						type: tile.type,
						rot: tile.rot,
						baseRot: tile.rot,
						locked: !!tile.locked,
						label: tile.label || ''
					};
				});
			});
		}

		function scrambleGrid() {
			grid.forEach(function (row) {
				row.forEach(function (tile) {
					if (!tile.locked) {
						tile.rot = (tile.baseRot + 1 + Math.floor(Math.random() * 3)) % 4;
					}
				});
			});
		}

		function connectedMap() {
			const queue = [{ x: 0, y: 0 }];
			const seen = {};
			const start = grid[0][0];
			if (start.type !== 'source') {
				return seen;
			}

			seen['0,0'] = true;

			while (queue.length > 0) {
				const current = queue.shift();
				const tile = grid[current.y][current.x];
				const openings = getOpenings(tile.type, tile.rot);

				openings.forEach(function (side) {
					let nextX = current.x;
					let nextY = current.y;
					if (side === 0) {
						nextY -= 1;
					} else if (side === 1) {
						nextX += 1;
					} else if (side === 2) {
						nextY += 1;
					} else if (side === 3) {
						nextX -= 1;
					}

					if (nextX < 0 || nextX > 3 || nextY < 0 || nextY > 3) {
						return;
					}

					const neighbor = grid[nextY][nextX];
					const neighborOpenings = getOpenings(neighbor.type, neighbor.rot);
					const key = nextX + ',' + nextY;

					if (!sidesConnect(openings, neighborOpenings, side) || seen[key]) {
						return;
					}

					seen[key] = true;
					queue.push({ x: nextX, y: nextY });
				});
			}

			return seen;
		}

		function countConnectedDistricts(map) {
			let count = 0;
			grid.forEach(function (row, y) {
				row.forEach(function (tile, x) {
					if (tile.type === 'district' && map[x + ',' + y]) {
						count += 1;
					}
				});
			});
			return count;
		}

		function drawTile(tile, connected) {
			const button = document.createElement(tile.locked ? 'div' : 'button');
			button.className = 'zo-cgr-tile';
			if (tile.locked) {
				button.classList.add('is-locked');
			}
			if (connected) {
				button.classList.add('is-connected');
			}
			if (!tile.locked) {
				button.type = 'button';
			}

			const core = document.createElement('span');
			core.className = 'zo-cgr-core';
			button.appendChild(core);

			getOpenings(tile.type, tile.rot).forEach(function (side) {
				const seg = document.createElement('span');
				seg.className = 'zo-cgr-seg zo-cgr-seg--' + (side === 0 ? 'up' : side === 1 ? 'right' : side === 2 ? 'down' : 'left');
				button.appendChild(seg);
			});

			if (tile.label) {
				const label = document.createElement('span');
				label.className = 'zo-cgr-label';
				label.textContent = tile.label;
				button.appendChild(label);
			}

			return button;
		}

		function render() {
			const map = connectedMap();
			const connected = countConnectedDistricts(map);
			boardEl.innerHTML = '';

			grid.forEach(function (row, y) {
				row.forEach(function (tile, x) {
					const key = x + ',' + y;
					const el = drawTile(tile, !!map[key]);

					if (!tile.locked) {
						el.addEventListener('click', function () {
							if (solved) {
								return;
							}
							tile.rot = (tile.rot + 1) % 4;
							render();
						});
					}

					boardEl.appendChild(el);
				});
			});

			serviceEl.textContent = levels[levelIndex].service;
			roundEl.textContent = String(levelIndex + 1) + ' / ' + String(levels.length);
			connectedEl.textContent = String(connected) + ' / 3';

			if (connected === 3) {
				if (levelIndex === levels.length - 1) {
					statusEl.textContent = 'All three services are restored. The city lights up again.';
				} else {
					statusEl.textContent = levels[levelIndex].service + ' is restored. Continue to the next service.';
				}
				solved = true;
			} else {
				statusEl.textContent = 'Rotate the junctions until all three districts connect to the ' + levels[levelIndex].service.toLowerCase() + ' network.';
				solved = false;
			}

			nextButton.disabled = !solved || levelIndex === levels.length - 1;
		}

		function loadLevel(index) {
			levelIndex = index;
			grid = cloneLevel(levels[index]);
			scrambleGrid();
			solved = false;
			render();
		}

		nextButton.addEventListener('click', function () {
			if (!solved) {
				return;
			}
			if (levelIndex < levels.length - 1) {
				loadLevel(levelIndex + 1);
			}
		});

		resetButton.addEventListener('click', function () {
			loadLevel(levelIndex);
		});

		loadLevel(0);
	});
});
JS;

if (!function_exists('zo_game_city_grid_revival_render')) {
	function zo_game_city_grid_revival_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-city-grid-revival-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--city-grid-revival" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-cgr-title">City Grid Revival</h2>
			<p class="zo-cgr-desc">Restore one service at a time by rotating junctions until the network reaches every district. Power, water, and transport each need their own clean logic solution.</p>

			<div class="zo-cgr-top">
				<div class="zo-cgr-stat">
					<span class="zo-cgr-stat-label">Service</span>
					<span class="zo-cgr-stat-value zo-cgr-service">Power</span>
				</div>
				<div class="zo-cgr-stat">
					<span class="zo-cgr-stat-label">Round</span>
					<span class="zo-cgr-stat-value zo-cgr-round">1 / 3</span>
				</div>
				<div class="zo-cgr-stat">
					<span class="zo-cgr-stat-label">Districts Connected</span>
					<span class="zo-cgr-stat-value zo-cgr-connected">0 / 3</span>
				</div>
				<div class="zo-cgr-stat">
					<span class="zo-cgr-stat-label">Goal</span>
					<span class="zo-cgr-stat-value">All Online</span>
				</div>
			</div>

			<div class="zo-cgr-main">
				<div class="zo-cgr-panel">
					<h3 class="zo-cgr-subtitle">Grid</h3>
					<div class="zo-cgr-board"></div>
				</div>

				<div class="zo-cgr-panel">
					<h3 class="zo-cgr-subtitle">City Operations</h3>
					<p class="zo-cgr-status" aria-live="polite"></p>
					<div class="zo-cgr-controls">
						<button type="button" class="zo-cgr-button zo-cgr-button--next">Next Service</button>
						<button type="button" class="zo-cgr-button zo-cgr-button--reset">Reset Grid</button>
					</div>
					<p class="zo-cgr-help">Source tiles begin at the top-left corner. District tiles are locked, but every other tile rotates when clicked.</p>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug' => 'city-grid-revival',
	'name' => 'City Grid Revival',
	'author' => 'asker',
	'description' => 'A city logic puzzle where you reconnect power, water, and transport to bring broken neighborhoods back online.',
	'render_callback' => 'zo_game_city_grid_revival_render',
	'inline_style' => $css,
	'inline_script' => $js,
);
