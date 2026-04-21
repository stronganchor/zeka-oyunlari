<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--mini-maze-builder {
	max-width: 560px;
	margin: 0 auto;
	padding: 14px;
	border: 2px solid #d8e2ec;
	border-radius: 14px;
	background: #fbfdff;
	font-family: Arial, sans-serif;
	box-sizing: border-box;
}

.zo-mb-title {
	text-align: center;
	margin: 0 0 10px;
}

.zo-mb-grid {
	display: grid;
	grid-template-columns: repeat(5, 1fr);
	gap: 6px;
	margin-top: 10px;
}

.zo-mb-cell {
	aspect-ratio: 1;
	border: 2px solid #cbd5e1;
	border-radius: 10px;
	background: #f8fafc;
	cursor: pointer;
}

.zo-mb-cell[data-type="start"],
.zo-mb-cell[data-type="goal"] {
	background: #22c55e;
	color: #fff;
	font-weight: 700;
}

.zo-mb-cell[data-type="wall"] {
	background: #0f172a;
}

.zo-mb-cell[data-type="user-wall"] {
	background: #93c5fd;
}

.zo-mb-controls {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 8px;
	margin-top: 10px;
}

.zo-mb-btn,
.zo-mb-stat {
	border-radius: 10px;
	padding: 10px;
}

.zo-mb-btn {
	border: 0;
	background: #2563eb;
	color: #fff;
	font-weight: 700;
	cursor: pointer;
}

.zo-mb-stat {
	background: #eef2ff;
	text-align: center;
}

.zo-mb-status {
	min-height: 24px;
	text-align: center;
	font-weight: 700;
	margin-top: 10px;
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root');

	games.forEach(function (game) {
		if (!game.classList.contains('zo-game-root--mini-maze-builder')) {
			return;
		}

		const grid = game.querySelector('.zo-mb-grid');
		const checkBtn = game.querySelector('.zo-mb-check');
		const clearBtn = game.querySelector('.zo-mb-clear');
		const newBtn = game.querySelector('.zo-mb-new');
		const scoreEl = game.querySelector('.zo-mb-score');
		const status = game.querySelector('.zo-mb-status');

		const size = 5;
		const total = size * size;
		const startIndex = 0;
		const goalIndex = total - 1;
		const cells = [];
		let lockedWalls = new Set();
		let userWalls = new Set();
		let score = 0;

		for (let i = 0; i < total; i++) {
			const cell = document.createElement('button');
			cell.type = 'button';
			cell.className = 'zo-mb-cell';
			cell.dataset.index = String(i);
			cell.setAttribute('aria-label', 'Maze cell');
			cell.addEventListener('click', function () {
				toggleWall(i);
			});
			cells.push(cell);
			grid.appendChild(cell);
		}

		function paintCell(index, type) {
			cells[index].removeAttribute('data-type');
			if (type) {
				cells[index].setAttribute('data-type', type);
			}
		}

		function clearCells() {
			cells.forEach(function (cell) {
				paintCell(Number(cell.dataset.index), '');
			});
			paintCell(startIndex, 'start');
			paintCell(goalIndex, 'goal');
		}

		function randomInt(max) {
			return Math.floor(Math.random() * max);
		}

		function isPathClear(blocked) {
			const queue = [startIndex];
			const visited = {};
			visited[startIndex] = true;
			while (queue.length) {
				const idx = queue.shift();
				if (idx === goalIndex) {
					return true;
				}
				const r = Math.floor(idx / size);
				const c = idx % size;
				const neighbors = [
					{ r: r - 1, c: c },
					{ r: r + 1, c: c },
					{ r: r, c: c - 1 },
					{ r: r, c: c + 1 },
				];
				for (let i = 0; i < neighbors.length; i++) {
					const nr = neighbors[i].r;
					const nc = neighbors[i].c;
					if (nr < 0 || nc < 0 || nr >= size || nc >= size) {
						continue;
					}
					const next = nr * size + nc;
					if (blocked[next]) {
						continue;
					}
					if (!visited[next]) {
						visited[next] = true;
						queue.push(next);
					}
				}
			}
			return false;
		}

		function applyWalls() {
			clearCells();
			for (let i = 0; i < total; i++) {
				if (i === startIndex || i === goalIndex) {
					continue;
				}
				if (lockedWalls[i]) {
					paintCell(i, 'wall');
				} else if (userWalls[i]) {
					paintCell(i, 'user-wall');
				}
			}
		}

		function randomLocked() {
			let locked = {};
			const wanted = 4;
			while (Object.keys(locked).length < wanted) {
				const candidate = randomInt(total);
				if (candidate === startIndex || candidate === goalIndex) {
					continue;
				}
				locked[candidate] = true;
			}
			return locked;
		}

		function createPuzzle() {
			let locked;
			let ok = false;
			let attempts = 0;
			while (!ok && attempts < 15) {
				attempts += 1;
				locked = randomLocked();
				ok = isPathClear(locked);
			}
			lockedWalls = locked;
			userWalls = {};
			applyWalls();
			status.textContent = 'Place walls, then check the path.';
		}

		function toggleWall(index) {
			if (index === startIndex || index === goalIndex || lockedWalls[index]) {
				return;
			}
			if (userWalls[index]) {
				delete userWalls[index];
			} else {
				userWalls[index] = true;
			}
			applyWalls();
		}

		function blockedFromState() {
			const blocked = {};
			for (let i = 0; i < total; i++) {
				if (lockedWalls[i] || userWalls[i]) {
					blocked[i] = true;
				}
			}
			return blocked;
		}

		checkBtn.addEventListener('click', function () {
			const blocked = blockedFromState();
			if (isPathClear(blocked)) {
				score += 1;
				scoreEl.textContent = String(score);
				status.textContent = 'Path exists! Great builder.';
			} else {
				status.textContent = 'No path. Move or remove some walls.';
			}
		});

		clearBtn.addEventListener('click', function () {
			userWalls = {};
			applyWalls();
			status.textContent = 'Board cleared.';
		});

		newBtn.addEventListener('click', function () {
			createPuzzle();
		});

		createPuzzle();
		scoreEl.textContent = String(score);
	});
});
JS;

if (!function_exists('zo_game_mini_maze_builder_render')) {
	function zo_game_mini_maze_builder_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-mini-maze-builder-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--mini-maze-builder" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-mb-title">Mini Maze Builder</h2>
			<div class="zo-mb-grid"></div>
			<div class="zo-mb-controls">
				<button type="button" class="zo-mb-btn zo-mb-check">Check Path</button>
				<button type="button" class="zo-mb-btn zo-mb-clear">Clear Walls</button>
				<button type="button" class="zo-mb-btn zo-mb-new">New Maze</button>
				<div class="zo-mb-stat">Score <span class="zo-mb-score">0</span></div>
			</div>
			<div class="zo-mb-status">Press New Maze for a challenge.</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'mini-maze-builder',
	'name'            => 'Mini Maze Builder',
	'author'          => 'Asker',
	'description'     => 'Build walls and keep one valid path from start to finish.',
	'render_callback' => 'zo_game_mini_maze_builder_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
