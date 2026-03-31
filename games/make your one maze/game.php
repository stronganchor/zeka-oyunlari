<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root--puzzle-creator-mode {
	max-width: 720px;
	margin: 0 auto;
	padding: 20px;
	background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
	border-radius: 18px;
	color: #ffffff;
	box-sizing: border-box;
	font-family: inherit;
}

.zo-game-root--puzzle-creator-mode * {
	box-sizing: border-box;
}

.zo-game-root--puzzle-creator-mode h2 {
	margin: 0 0 8px;
	font-size: 26px;
}

.zo-game-root--puzzle-creator-mode p {
	margin: 0 0 12px;
	color: #cbd5e1;
	font-size: 14px;
}

.zo-game-root--puzzle-creator-mode .zo-pcm-panel {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	margin-bottom: 14px;
}

.zo-game-root--puzzle-creator-mode .zo-pcm-btn {
	border: none;
	border-radius: 999px;
	padding: 10px 16px;
	font-weight: 700;
	cursor: pointer;
	background: #38bdf8;
	color: #0f172a;
	font-size: 14px;
}

.zo-game-root--puzzle-creator-mode .zo-pcm-btn-secondary {
	background: #e5e7eb;
	color: #111827;
}

.zo-game-root--puzzle-creator-mode .zo-pcm-status {
	min-height: 24px;
	margin-bottom: 10px;
	font-weight: 600;
	color: #facc15;
}

.zo-game-root--puzzle-creator-mode .zo-pcm-grid {
	display: grid;
	grid-template-columns: repeat(8, 1fr);
	gap: 4px;
	margin-bottom: 14px;
}

.zo-game-root--puzzle-creator-mode .zo-pcm-cell {
	width: 100%;
	aspect-ratio: 1 / 1;
	border-radius: 8px;
	background: #334155;
	cursor: pointer;
	border: 2px solid transparent;
}

.zo-game-root--puzzle-creator-mode .zo-pcm-cell.active {
	background: #22c55e;
}

.zo-game-root--puzzle-creator-mode .zo-pcm-cell.start {
	background: #3b82f6;
}

.zo-game-root--puzzle-creator-mode .zo-pcm-cell.goal {
	background: #ef4444;
}

.zo-game-root--puzzle-creator-mode .zo-pcm-legend {
	display: flex;
	flex-wrap: wrap;
	gap: 12px;
	font-size: 13px;
	color: #e2e8f0;
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--puzzle-creator-mode');

	games.forEach(function (game) {

		const grid = game.querySelector('.zo-pcm-grid');
		const modeWallBtn = game.querySelector('.zo-pcm-mode-wall');
		const modeStartBtn = game.querySelector('.zo-pcm-mode-start');
		const modeGoalBtn = game.querySelector('.zo-pcm-mode-goal');
		const testBtn = game.querySelector('.zo-pcm-test');
		const clearBtn = game.querySelector('.zo-pcm-clear');
		const statusEl = game.querySelector('.zo-pcm-status');

		if (!grid) return;

		const size = 8;
		let mode = 'wall';
		let start = null;
		let goal = null;

		const cells = [];

		function setMode(newMode) {
			mode = newMode;
			statusEl.textContent = 'Mode: ' + newMode.toUpperCase();
		}

		function clearGrid() {
			cells.forEach(function (cell) {
				cell.className = 'zo-pcm-cell';
			});
			start = null;
			goal = null;
			statusEl.textContent = 'Grid cleared.';
		}

		function getIndex(row, col) {
			return row * size + col;
		}

		function getNeighbors(index) {
			const row = Math.floor(index / size);
			const col = index % size;
			const neighbors = [];

			if (row > 0) neighbors.push(getIndex(row - 1, col));
			if (row < size - 1) neighbors.push(getIndex(row + 1, col));
			if (col > 0) neighbors.push(getIndex(row, col - 1));
			if (col < size - 1) neighbors.push(getIndex(row, col + 1));

			return neighbors;
		}

		function testPath() {
			if (start === null || goal === null) {
				statusEl.textContent = 'You must set a start and a goal.';
				return;
			}

			const visited = new Set();
			const queue = [start];

			while (queue.length > 0) {
				const current = queue.shift();
				if (current === goal) {
					statusEl.textContent = 'Path exists. Puzzle is solvable.';
					return;
				}

				visited.add(current);

				getNeighbors(current).forEach(function (n) {
					if (!visited.has(n) && !cells[n].classList.contains('active')) {
						queue.push(n);
						visited.add(n);
					}
				});
			}

			statusEl.textContent = 'No path found. Puzzle is blocked.';
		}

		for (let i = 0; i < size * size; i++) {
			const cell = document.createElement('div');
			cell.className = 'zo-pcm-cell';

			cell.addEventListener('click', function () {

				if (mode === 'wall') {
					if (cell.classList.contains('start') || cell.classList.contains('goal')) return;
					cell.classList.toggle('active');
				}

				if (mode === 'start') {
					if (start !== null) cells[start].classList.remove('start');
					start = i;
					cell.classList.remove('active');
					cell.classList.remove('goal');
					cell.classList.add('start');
				}

				if (mode === 'goal') {
					if (goal !== null) cells[goal].classList.remove('goal');
					goal = i;
					cell.classList.remove('active');
					cell.classList.remove('start');
					cell.classList.add('goal');
				}
			});

			grid.appendChild(cell);
			cells.push(cell);
		}

		modeWallBtn.addEventListener('click', function () { setMode('wall'); });
		modeStartBtn.addEventListener('click', function () { setMode('start'); });
		modeGoalBtn.addEventListener('click', function () { setMode('goal'); });
		testBtn.addEventListener('click', function () { testPath(); });
		clearBtn.addEventListener('click', function () { clearGrid(); });

		setMode('wall');
	});
});
JS;

if (!function_exists('zo_game_puzzle_creator_mode_render')) {
	function zo_game_puzzle_creator_mode_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-puzzle-creator-mode-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--puzzle-creator-mode" id="<?php echo esc_attr($instance_id); ?>">
			<h2>Puzzle Creator Mode</h2>
			<p>Design your own maze. Add walls, choose a start and goal, then test if it can be solved.</p>

			<div class="zo-pcm-panel">
				<button type="button" class="zo-pcm-btn zo-pcm-mode-wall">Wall Mode</button>
				<button type="button" class="zo-pcm-btn zo-pcm-mode-start">Start Mode</button>
				<button type="button" class="zo-pcm-btn zo-pcm-mode-goal">Goal Mode</button>
				<button type="button" class="zo-pcm-btn zo-pcm-test">Test Path</button>
				<button type="button" class="zo-pcm-btn zo-pcm-btn-secondary zo-pcm-clear">Clear</button>
			</div>

			<div class="zo-pcm-status"></div>

			<div class="zo-pcm-grid"></div>

			<div class="zo-pcm-legend">
				<div>Green = Wall</div>
				<div>Blue = Start</div>
				<div>Red = Goal</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'puzzle-creator-mode',
	'name'            => 'Puzzle Creator Mode',
	'author'          => 'Asker',
	'description'     => 'Create and test your own maze puzzles.',
	'render_callback' => 'zo_game_puzzle_creator_mode_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);