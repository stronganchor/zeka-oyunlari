<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 760px;
	margin: 0 auto;
	text-align: center;
}

.zo-game-root--simple-farming {
	font-family: Arial, sans-serif;
	background: #f2f6ea;
	color: #1f2a1f;
	border-radius: 18px;
	padding: 16px;
	box-sizing: border-box;
	border: 2px solid #d4e3c7;
}

.zo-game-root--simple-farming * {
	box-sizing: border-box;
}

.zo-game-root--simple-farming .sf-title {
	font-size: 30px;
	font-weight: 700;
	margin-bottom: 8px;
	color: #2d5e2d;
}

.zo-game-root--simple-farming .sf-instructions {
	font-size: 15px;
	line-height: 1.5;
	color: #405240;
	margin-bottom: 14px;
}

.zo-game-root--simple-farming .sf-hud {
	display: grid;
	grid-template-columns: repeat(2, minmax(0, 1fr));
	gap: 10px;
	margin-bottom: 14px;
}

.zo-game-root--simple-farming .sf-stat {
	background: #ffffff;
	border: 1px solid #d8e2d0;
	border-radius: 14px;
	padding: 10px 12px;
	font-size: 15px;
	font-weight: 700;
}

.zo-game-root--simple-farming .sf-board-wrap {
	display: flex;
	justify-content: center;
	margin-bottom: 14px;
}

.zo-game-root--simple-farming .sf-board {
	display: grid;
	grid-template-columns: repeat(14, minmax(0, 1fr));
	gap: 2px;
	width: 100%;
	max-width: 672px;
	aspect-ratio: 14 / 9;
	background: #b9cfae;
	border: 3px solid #93ad83;
	border-radius: 16px;
	padding: 6px;
	touch-action: manipulation;
	user-select: none;
}

.zo-game-root--simple-farming .sf-tile {
	position: relative;
	border-radius: 6px;
	border: 1px solid rgba(255,255,255,0.35);
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 18px;
	font-weight: 700;
	aspect-ratio: 1 / 1;
	cursor: pointer;
}

.zo-game-root--simple-farming .sf-tile--grass {
	background: #78b96e;
}

.zo-game-root--simple-farming .sf-tile--soil {
	background: #967350;
}

.zo-game-root--simple-farming .sf-tile--wet {
	background: #6e5a46;
}

.zo-game-root--simple-farming .sf-plant {
	width: 42%;
	height: 42%;
	background: #3c8c3c;
	border-radius: 6px;
}

.zo-game-root--simple-farming .sf-ready {
	width: 52%;
	height: 52%;
	background: #f0be3c;
	border-radius: 8px;
	border: 2px solid #8a5f12;
}

.zo-game-root--simple-farming .sf-player {
	position: absolute;
	inset: 12%;
	background: #283cc8;
	border-radius: 10px;
	border: 2px solid rgba(255,255,255,0.6);
	pointer-events: none;
}

.zo-game-root--simple-farming .sf-sell-box {
	position: absolute;
	inset: 8%;
	background: #a0a0a0;
	border-radius: 10px;
	border: 2px solid #6c6c6c;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 11px;
	color: #222;
}

.zo-game-root--simple-farming .sf-toolbar {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 10px;
	margin-bottom: 14px;
}

.zo-game-root--simple-farming .sf-tool {
	appearance: none;
	border: 1px solid #8fa2d9;
	background: #edf2ff;
	color: #26335d;
	border-radius: 12px;
	padding: 12px 10px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
}

.zo-game-root--simple-farming .sf-tool:hover,
.zo-game-root--simple-farming .sf-tool:focus {
	background: #dfe8ff;
	outline: none;
}

.zo-game-root--simple-farming .sf-tool.is-active {
	background: #2c4f9e;
	color: #fff;
	border-color: #2c4f9e;
}

.zo-game-root--simple-farming .sf-actions {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap: 10px;
	margin-bottom: 12px;
}

.zo-game-root--simple-farming .sf-btn {
	appearance: none;
	border: 1px solid #5578d8;
	background: #2c4f9e;
	color: #fff;
	border-radius: 12px;
	padding: 12px 18px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	min-width: 130px;
}

.zo-game-root--simple-farming .sf-btn:hover,
.zo-game-root--simple-farming .sf-btn:focus {
	background: #3a63c2;
	outline: none;
}

.zo-game-root--simple-farming .sf-message {
	background: #fff;
	border: 1px solid #d8e2d0;
	border-radius: 14px;
	padding: 12px;
	font-size: 14px;
	line-height: 1.5;
	color: #4a5d4a;
	margin-bottom: 12px;
	min-height: 48px;
	text-align: left;
}

.zo-game-root--simple-farming .sf-controls {
	font-size: 14px;
	color: #4a5d4a;
	line-height: 1.5;
}

@media (max-width: 640px) {
	.zo-game-root--simple-farming .sf-title {
		font-size: 26px;
	}

	.zo-game-root--simple-farming .sf-hud,
	.zo-game-root--simple-farming .sf-toolbar {
		grid-template-columns: repeat(2, minmax(0, 1fr));
	}

	.zo-game-root--simple-farming .sf-btn {
		width: 100%;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--simple-farming');

	games.forEach(function (game) {
		const GRID_W = 14;
		const GRID_H = 9;
		const WET_TIME = 4;
		const GROW_TIME = 9;
		const SEED_PRICE = 2;
		const SELL_PRICE = 6;

		const GRASS_T = 0;
		const SOIL_T = 1;
		const PLANTED_T = 2;
		const READY_T = 3;

		const boardEl = game.querySelector('[data-role="board"]');
		const seedsEl = game.querySelector('[data-role="seeds"]');
		const cropsEl = game.querySelector('[data-role="crops"]');
		const moneyEl = game.querySelector('[data-role="money"]');
		const toolEl = game.querySelector('[data-role="tool"]');
		const messageEl = game.querySelector('[data-role="message"]');
		const actionBtn = game.querySelector('[data-role="action"]');
		const sellBtn = game.querySelector('[data-role="sell"]');
		const restartBtn = game.querySelector('[data-role="restart"]');
		const toolButtons = game.querySelectorAll('[data-tool]');

		const state = {
			grid: [],
			playerX: 2,
			playerY: 4,
			tool: 1,
			seeds: 10,
			crops: 0,
			money: 20,
			msg: 'Use tools 1-4. Plant -> Water -> Harvest -> Sell (E).',
			lastTime: 0,
			running: true
		};

		function makeGrid() {
			const grid = [];
			for (let y = 0; y < GRID_H; y++) {
				const row = [];
				for (let x = 0; x < GRID_W; x++) {
					row.push({
						state: GRASS_T,
						wet: 0,
						grow: 0
					});
				}
				grid.push(row);
			}
			return grid;
		}

		function resetGame() {
			state.grid = makeGrid();
			state.playerX = 2;
			state.playerY = 4;
			state.tool = 1;
			state.seeds = 10;
			state.crops = 0;
			state.money = 20;
			state.msg = 'Use tools 1-4. Plant -> Water -> Harvest -> Sell (E).';
			state.lastTime = 0;
			render();
		}

		function clamp(v, lo, hi) {
			return Math.max(lo, Math.min(hi, v));
		}

		function currentTile() {
			return state.grid[state.playerY][state.playerX];
		}

		function isSellBox(x, y) {
			return x >= GRID_W - 2 && y <= 1;
		}

		function toolName(tool) {
			if (tool === 1) return 'Hoe';
			if (tool === 2) return 'Plant';
			if (tool === 3) return 'Water';
			return 'Harvest';
		}

		function updateHud() {
			seedsEl.textContent = String(state.seeds);
			cropsEl.textContent = String(state.crops);
			moneyEl.textContent = String(state.money);
			toolEl.textContent = toolName(state.tool);
			messageEl.textContent = state.msg;

			toolButtons.forEach(function (btn) {
				const val = Number(btn.getAttribute('data-tool'));
				btn.classList.toggle('is-active', val === state.tool);
			});
		}

		function actOnTile() {
			const tile = currentTile();
			const st = tile.state;

			if (state.tool === 1) {
				if (st === GRASS_T) {
					tile.state = SOIL_T;
					tile.wet = 0;
					tile.grow = 0;
					state.msg = 'Hoed: grass -> soil.';
				} else {
					state.msg = 'Hoe only works on grass.';
				}
			} else if (state.tool === 2) {
				if (st === SOIL_T && state.seeds > 0) {
					tile.state = PLANTED_T;
					state.seeds -= 1;
					tile.grow = 0;
					state.msg = 'Planted seed. Now water it.';
				} else if (st !== SOIL_T) {
					state.msg = 'Plant only works on empty soil.';
				} else {
					state.msg = 'No seeds. Sell crops to buy more seeds.';
				}
			} else if (state.tool === 3) {
				if (st === SOIL_T || st === PLANTED_T || st === READY_T) {
					tile.wet = WET_TIME;
					if (st === PLANTED_T && tile.grow <= 0) {
						tile.grow = GROW_TIME;
						state.msg = 'Watered: crop started growing.';
					} else {
						state.msg = 'Watered.';
					}
				} else {
					state.msg = 'Water works on soil, not on grass.';
				}
			} else if (state.tool === 4) {
				if (st === READY_T) {
					tile.state = SOIL_T;
					tile.wet = 0;
					tile.grow = 0;
					state.crops += 1;
					state.msg = 'Harvested. Take crops to the box and press Sell.';
				} else {
					state.msg = 'Nothing ready to harvest.';
				}
			}

			render();
		}

		function sellIfOnBox() {
			if (!isSellBox(state.playerX, state.playerY)) {
				state.msg = 'Stand on the gray box at the top-right to sell.';
				render();
				return;
			}

			if (state.crops <= 0) {
				state.msg = 'No crops to sell.';
				render();
				return;
			}

			const earned = state.crops * SELL_PRICE;
			state.money += earned;
			const sold = state.crops;
			state.crops = 0;

			const buy = Math.floor(state.money / SEED_PRICE);
			if (buy > 0) {
				state.seeds += buy;
				state.money -= buy * SEED_PRICE;
				state.msg = 'Sold ' + sold + ' crops for ' + earned + ' coins. Bought ' + buy + ' seeds.';
			} else {
				state.msg = 'Sold ' + sold + ' crops for ' + earned + ' coins.';
			}

			render();
		}

		function movePlayer(dx, dy) {
			state.playerX = clamp(state.playerX + dx, 0, GRID_W - 1);
			state.playerY = clamp(state.playerY + dy, 0, GRID_H - 1);
			render();
		}

		function update(dt) {
			for (let y = 0; y < GRID_H; y++) {
				for (let x = 0; x < GRID_W; x++) {
					const tile = state.grid[y][x];

					if (tile.wet > 0) {
						tile.wet = Math.max(0, tile.wet - dt);
					}

					if (tile.state === PLANTED_T && tile.grow > 0) {
						tile.grow = Math.max(0, tile.grow - dt);
						if (tile.grow <= 0) {
							tile.state = READY_T;
						}
					}
				}
			}
		}

		function renderBoard() {
			boardEl.innerHTML = '';

			for (let y = 0; y < GRID_H; y++) {
				for (let x = 0; x < GRID_W; x++) {
					const tile = state.grid[y][x];
					const cell = document.createElement('button');
					cell.type = 'button';
					cell.className = 'sf-tile';

					let wet = tile.wet > 0;
					if (tile.state === GRASS_T) {
						cell.classList.add('sf-tile--grass');
					} else if (wet) {
						cell.classList.add('sf-tile--wet');
					} else {
						cell.classList.add('sf-tile--soil');
					}

					if (tile.state === PLANTED_T) {
						const plant = document.createElement('div');
						plant.className = 'sf-plant';
						cell.appendChild(plant);
					} else if (tile.state === READY_T) {
						const ready = document.createElement('div');
						ready.className = 'sf-ready';
						cell.appendChild(ready);
					}

					if (isSellBox(x, y)) {
						const box = document.createElement('div');
						box.className = 'sf-sell-box';
						box.textContent = 'SELL';
						cell.appendChild(box);
					}

					if (state.playerX === x && state.playerY === y) {
						const player = document.createElement('div');
						player.className = 'sf-player';
						cell.appendChild(player);
					}

					(function (cx, cy) {
						cell.addEventListener('click', function () {
							state.playerX = cx;
							state.playerY = cy;
							render();
							game.focus();
						});
					})(x, y);

					boardEl.appendChild(cell);
				}
			}
		}

		function render() {
			updateHud();
			renderBoard();
		}

		function loop(timestamp) {
			if (!state.running) {
				return;
			}

			if (!state.lastTime) {
				state.lastTime = timestamp;
			}

			const dt = (timestamp - state.lastTime) / 1000;
			state.lastTime = timestamp;

			update(dt);
			renderBoard();
			window.requestAnimationFrame(loop);
		}

		game.addEventListener('keydown', function (e) {
			if (e.key === 'ArrowLeft' || e.key === 'a' || e.key === 'A') {
				movePlayer(-1, 0);
				e.preventDefault();
			} else if (e.key === 'ArrowRight' || e.key === 'd' || e.key === 'D') {
				movePlayer(1, 0);
				e.preventDefault();
			} else if (e.key === 'ArrowUp' || e.key === 'w' || e.key === 'W') {
				movePlayer(0, -1);
				e.preventDefault();
			} else if (e.key === 'ArrowDown' || e.key === 's' || e.key === 'S') {
				movePlayer(0, 1);
				e.preventDefault();
			} else if (e.key === '1') {
				state.tool = 1;
				state.msg = 'Tool: Hoe (1). Press Space or Act.';
				render();
				e.preventDefault();
			} else if (e.key === '2') {
				state.tool = 2;
				state.msg = 'Tool: Plant (2). Press Space or Act.';
				render();
				e.preventDefault();
			} else if (e.key === '3') {
				state.tool = 3;
				state.msg = 'Tool: Water (3). Press Space or Act.';
				render();
				e.preventDefault();
			} else if (e.key === '4') {
				state.tool = 4;
				state.msg = 'Tool: Harvest (4). Press Space or Act.';
				render();
				e.preventDefault();
			} else if (e.key === ' ' || e.key === 'Spacebar') {
				actOnTile();
				e.preventDefault();
			} else if (e.key === 'e' || e.key === 'E') {
				sellIfOnBox();
				e.preventDefault();
			}
		});

		toolButtons.forEach(function (btn) {
			btn.addEventListener('click', function () {
				state.tool = Number(btn.getAttribute('data-tool'));
				state.msg = 'Tool: ' + toolName(state.tool) + '.';
				render();
				game.focus();
			});
		});

		actionBtn.addEventListener('click', function () {
			actOnTile();
			game.focus();
		});

		sellBtn.addEventListener('click', function () {
			sellIfOnBox();
			game.focus();
		});

		restartBtn.addEventListener('click', function () {
			resetGame();
			game.focus();
		});

		resetGame();
		window.requestAnimationFrame(loop);
	});
});
JS;

if (!function_exists('zo_game_simple_farming_render')) {
	function zo_game_simple_farming_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-simple-farming-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--simple-farming" id="<?php echo esc_attr($instance_id); ?>" tabindex="0">
			<div class="sf-title">Simple Farming Game</div>
			<div class="sf-instructions">Move with arrow keys or WASD. Use 1 Hoe, 2 Plant, 3 Water, 4 Harvest. Press Space to use the tool. Stand on the gray box at the top-right and press E to sell.</div>

			<div class="sf-hud">
				<div class="sf-stat">Tool: <span data-role="tool">Hoe</span></div>
				<div class="sf-stat">Seeds: <span data-role="seeds">10</span></div>
				<div class="sf-stat">Crops: <span data-role="crops">0</span></div>
				<div class="sf-stat">Money: <span data-role="money">20</span></div>
			</div>

			<div class="sf-toolbar">
				<button type="button" class="sf-tool is-active" data-tool="1">1 Hoe</button>
				<button type="button" class="sf-tool" data-tool="2">2 Plant</button>
				<button type="button" class="sf-tool" data-tool="3">3 Water</button>
				<button type="button" class="sf-tool" data-tool="4">4 Harvest</button>
			</div>

			<div class="sf-board-wrap">
				<div class="sf-board" data-role="board"></div>
			</div>

			<div class="sf-actions">
				<button type="button" class="sf-btn" data-role="action">Act</button>
				<button type="button" class="sf-btn" data-role="sell">Sell</button>
				<button type="button" class="sf-btn" data-role="restart">Restart</button>
			</div>

			<div class="sf-message" data-role="message">Use tools 1-4. Plant - Water - Harvest - Sell (E).</div>

			<div class="sf-controls">Click a tile to move there. Crops become ready after watering and waiting. Selling automatically buys as many seeds as possible.</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'simple-farming',
	'name'            => 'Simple Farming Game',
	'author'          => 'Arslan',
	'description'     => 'A browser farming game with hoe, plant, water, harvest, and sell actions.',
	'render_callback' => 'zo_game_simple_farming_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);