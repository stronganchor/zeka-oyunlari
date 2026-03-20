<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--grid-path-puzzle {
	max-width: 860px;
	margin: 0 auto;
	padding: 20px;
	border: 2px solid #d9e2ec;
	border-radius: 18px;
	background: #ffffff;
	box-sizing: border-box;
	font-family: Arial, sans-serif;
}

.zo-game-root--grid-path-puzzle .zo-gpp-title {
	margin: 0 0 10px;
	font-size: 30px;
	line-height: 1.2;
	text-align: center;
	color: #1f2937;
}

.zo-game-root--grid-path-puzzle .zo-gpp-desc {
	margin: 0 0 18px;
	font-size: 15px;
	line-height: 1.5;
	text-align: center;
	color: #4b5563;
}

.zo-game-root--grid-path-puzzle .zo-gpp-top {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 10px;
	margin-bottom: 16px;
}

.zo-game-root--grid-path-puzzle .zo-gpp-stat {
	border: 2px solid #d7e0ea;
	border-radius: 14px;
	padding: 12px;
	background: #f4f7fb;
	text-align: center;
}

.zo-game-root--grid-path-puzzle .zo-gpp-stat-label {
	display: block;
	font-size: 13px;
	font-weight: 700;
	color: #51606f;
	margin-bottom: 4px;
}

.zo-game-root--grid-path-puzzle .zo-gpp-stat-value {
	display: block;
	font-size: 24px;
	font-weight: 700;
	line-height: 1.1;
	color: #111827;
}

.zo-game-root--grid-path-puzzle .zo-gpp-main {
	display: grid;
	grid-template-columns: 1fr 300px;
	gap: 16px;
	align-items: start;
}

.zo-game-root--grid-path-puzzle .zo-gpp-board-wrap,
.zo-game-root--grid-path-puzzle .zo-gpp-side {
	border: 2px solid #dbe4ee;
	border-radius: 16px;
	padding: 16px;
	background: #fbfdff;
	box-sizing: border-box;
}

.zo-game-root--grid-path-puzzle .zo-gpp-board {
	display: grid;
	grid-template-columns: repeat(6, minmax(0, 1fr));
	gap: 8px;
	margin: 0 auto;
	max-width: 520px;
}

.zo-game-root--grid-path-puzzle .zo-gpp-cell {
	aspect-ratio: 1 / 1;
	border-radius: 12px;
	border: 2px solid #d1d9e6;
	background: #eef4fb;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 22px;
	font-weight: 700;
	color: #1f2937;
	user-select: none;
	box-sizing: border-box;
}

.zo-game-root--grid-path-puzzle .zo-gpp-cell--wall {
	background: #475569;
	border-color: #334155;
	color: #ffffff;
}

.zo-game-root--grid-path-puzzle .zo-gpp-cell--start {
	background: #dcfce7;
	border-color: #22c55e;
	color: #166534;
}

.zo-game-root--grid-path-puzzle .zo-gpp-cell--goal {
	background: #fef3c7;
	border-color: #f59e0b;
	color: #92400e;
}

.zo-game-root--grid-path-puzzle .zo-gpp-cell--player {
	background: #dbeafe;
	border-color: #3b82f6;
	color: #1d4ed8;
}

.zo-game-root--grid-path-puzzle .zo-gpp-cell--trail {
	background: #ede9fe;
	border-color: #8b5cf6;
	color: #6d28d9;
}

.zo-game-root--grid-path-puzzle .zo-gpp-side-title {
	margin: 0 0 12px;
	font-size: 21px;
	line-height: 1.2;
	color: #1f2937;
	text-align: center;
}

.zo-game-root--grid-path-puzzle .zo-gpp-instructions {
	margin: 0 0 14px;
	font-size: 15px;
	line-height: 1.5;
	color: #4b5563;
	text-align: center;
}

.zo-game-root--grid-path-puzzle .zo-gpp-controls {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 8px;
	max-width: 220px;
	margin: 0 auto 14px;
}

.zo-game-root--grid-path-puzzle .zo-gpp-controls .zo-gpp-button--up {
	grid-column: 2 / 3;
}

.zo-game-root--grid-path-puzzle .zo-gpp-controls .zo-gpp-button--left {
	grid-column: 1 / 2;
}

.zo-game-root--grid-path-puzzle .zo-gpp-controls .zo-gpp-button--down {
	grid-column: 2 / 3;
}

.zo-game-root--grid-path-puzzle .zo-gpp-controls .zo-gpp-button--right {
	grid-column: 3 / 4;
}

.zo-game-root--grid-path-puzzle .zo-gpp-button {
	border: 0;
	border-radius: 12px;
	padding: 12px 10px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	box-sizing: border-box;
}

.zo-game-root--grid-path-puzzle .zo-gpp-button--move {
	background: #2997aa;
	color: #ffffff;
	min-height: 48px;
}

.zo-game-root--grid-path-puzzle .zo-gpp-button--new {
	background: #10b981;
	color: #ffffff;
	width: 100%;
	margin-bottom: 10px;
}

.zo-game-root--grid-path-puzzle .zo-gpp-button--restart {
	background: #e5e7eb;
	color: #111827;
	width: 100%;
}

.zo-game-root--grid-path-puzzle .zo-gpp-status {
	min-height: 24px;
	margin-bottom: 14px;
	text-align: center;
	font-size: 15px;
	font-weight: 700;
	color: #374151;
}

.zo-game-root--grid-path-puzzle .zo-gpp-status.is-good {
	color: #15803d;
}

.zo-game-root--grid-path-puzzle .zo-gpp-status.is-bad {
	color: #dc2626;
}

.zo-game-root--grid-path-puzzle .zo-gpp-status.is-info {
	color: #2563eb;
}

.zo-game-root--grid-path-puzzle .zo-gpp-legend {
	display: grid;
	grid-template-columns: 1fr;
	gap: 8px;
	margin-top: 14px;
}

.zo-game-root--grid-path-puzzle .zo-gpp-legend-item {
	display: flex;
	align-items: center;
	gap: 10px;
	font-size: 14px;
	color: #374151;
}

.zo-game-root--grid-path-puzzle .zo-gpp-legend-box {
	width: 22px;
	height: 22px;
	border-radius: 8px;
	border: 2px solid #d1d9e6;
	box-sizing: border-box;
}

.zo-game-root--grid-path-puzzle .zo-gpp-legend-box--start {
	background: #dcfce7;
	border-color: #22c55e;
}

.zo-game-root--grid-path-puzzle .zo-gpp-legend-box--goal {
	background: #fef3c7;
	border-color: #f59e0b;
}

.zo-game-root--grid-path-puzzle .zo-gpp-legend-box--wall {
	background: #475569;
	border-color: #334155;
}

.zo-game-root--grid-path-puzzle .zo-gpp-legend-box--trail {
	background: #ede9fe;
	border-color: #8b5cf6;
}

@media (max-width: 760px) {
	.zo-game-root.zo-game-root--grid-path-puzzle {
		padding: 16px;
	}

	.zo-game-root--grid-path-puzzle .zo-gpp-title {
		font-size: 25px;
	}

	.zo-game-root--grid-path-puzzle .zo-gpp-top,
	.zo-game-root--grid-path-puzzle .zo-gpp-main {
		grid-template-columns: 1fr;
	}

	.zo-game-root--grid-path-puzzle .zo-gpp-board {
		gap: 6px;
	}

	.zo-game-root--grid-path-puzzle .zo-gpp-cell {
		font-size: 18px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--grid-path-puzzle');

	games.forEach(function (game) {
		const boardEl = game.querySelector('.zo-gpp-board');
		const statusEl = game.querySelector('.zo-gpp-status');
		const movesEl = game.querySelector('.zo-gpp-moves');
		const winsEl = game.querySelector('.zo-gpp-wins');
		const bestEl = game.querySelector('.zo-gpp-best');
		const levelEl = game.querySelector('.zo-gpp-level');

		const upButton = game.querySelector('.zo-gpp-button--up');
		const downButton = game.querySelector('.zo-gpp-button--down');
		const leftButton = game.querySelector('.zo-gpp-button--left');
		const rightButton = game.querySelector('.zo-gpp-button--right');
		const newButton = game.querySelector('.zo-gpp-button--new');
		const restartButton = game.querySelector('.zo-gpp-button--restart');

		const size = 6;
		const totalWalls = 8;

		let board = [];
		let player = { row: 0, col: 0 };
		let start = { row: 0, col: 0 };
		let goal = { row: size - 1, col: size - 1 };
		let trail = [];
		let moves = 0;
		let wins = 0;
		let best = 0;
		let level = 1;
		let roundOver = false;

		function setStatus(text, type) {
			statusEl.textContent = text;
			statusEl.className = 'zo-gpp-status';
			if (type) {
				statusEl.classList.add(type);
			}
		}

		function cellKey(row, col) {
			return row + '-' + col;
		}

		function isSameCell(a, b) {
			return a.row === b.row && a.col === b.col;
		}

		function randomInt(max) {
			return Math.floor(Math.random() * max);
		}

		function createEmptyBoard() {
			const rows = [];
			for (let row = 0; row < size; row++) {
				const cols = [];
				for (let col = 0; col < size; col++) {
					cols.push(0);
				}
				rows.push(cols);
			}
			return rows;
		}

		function inBounds(row, col) {
			return row >= 0 && row < size && col >= 0 && col < size;
		}

		function hasPath(testBoard, startCell, goalCell) {
			const queue = [{ row: startCell.row, col: startCell.col }];
			const seen = new Set([cellKey(startCell.row, startCell.col)]);
			const dirs = [
				{ row: -1, col: 0 },
				{ row: 1, col: 0 },
				{ row: 0, col: -1 },
				{ row: 0, col: 1 }
			];

			while (queue.length) {
				const current = queue.shift();

				if (current.row === goalCell.row && current.col === goalCell.col) {
					return true;
				}

				dirs.forEach(function (dir) {
					const nextRow = current.row + dir.row;
					const nextCol = current.col + dir.col;
					const key = cellKey(nextRow, nextCol);

					if (!inBounds(nextRow, nextCol)) {
						return;
					}

					if (testBoard[nextRow][nextCol] === 1) {
						return;
					}

					if (seen.has(key)) {
						return;
					}

					seen.add(key);
					queue.push({ row: nextRow, col: nextCol });
				});
			}

			return false;
		}

		function buildBoard() {
			let built = false;

			while (!built) {
				board = createEmptyBoard();
				start = { row: 0, col: 0 };
				goal = { row: size - 1, col: size - 1 };
				let wallsPlaced = 0;
				let tries = 0;

				while (wallsPlaced < totalWalls && tries < 300) {
					const row = randomInt(size);
					const col = randomInt(size);
					tries += 1;

					if ((row === start.row && col === start.col) || (row === goal.row && col === goal.col)) {
						continue;
					}

					if (board[row][col] === 1) {
						continue;
					}

					board[row][col] = 1;

					if (hasPath(board, start, goal)) {
						wallsPlaced += 1;
					} else {
						board[row][col] = 0;
					}
				}

				if (hasPath(board, start, goal)) {
					built = true;
				}
			}
		}

		function renderBoard() {
			boardEl.innerHTML = '';
			const trailSet = new Set(trail.map(function (item) {
				return cellKey(item.row, item.col);
			}));

			for (let row = 0; row < size; row++) {
				for (let col = 0; col < size; col++) {
					const cell = document.createElement('div');
					cell.className = 'zo-gpp-cell';
					cell.textContent = '';

					if (board[row][col] === 1) {
						cell.classList.add('zo-gpp-cell--wall');
						cell.textContent = '■';
					} else if (player.row === row && player.col === col) {
						cell.classList.add('zo-gpp-cell--player');
						cell.textContent = '●';
					} else if (goal.row === row && goal.col === col) {
						cell.classList.add('zo-gpp-cell--goal');
						cell.textContent = '★';
					} else if (start.row === row && start.col === col) {
						cell.classList.add('zo-gpp-cell--start');
						cell.textContent = 'S';
					} else if (trailSet.has(cellKey(row, col))) {
						cell.classList.add('zo-gpp-cell--trail');
						cell.textContent = '·';
					}

					boardEl.appendChild(cell);
				}
			}
		}

		function updateStats() {
			movesEl.textContent = String(moves);
			winsEl.textContent = String(wins);
			bestEl.textContent = best > 0 ? String(best) : '-';
			levelEl.textContent = String(level);
		}

		function finishRound() {
			roundOver = true;
			wins += 1;

			if (best === 0 || moves < best) {
				best = moves;
			}

			level += 1;
			updateStats();
			renderBoard();
			setStatus('Kazandın. Hedefe ulaştın.', 'is-good');
		}

		function tryMove(deltaRow, deltaCol) {
			if (roundOver) {
				setStatus('Yeni bölüm başlat veya aynı bölümü yeniden dene.', 'is-info');
				return;
			}

			const nextRow = player.row + deltaRow;
			const nextCol = player.col + deltaCol;

			if (!inBounds(nextRow, nextCol)) {
				setStatus('Tahta dışına çıkamazsın.', 'is-bad');
				return;
			}

			if (board[nextRow][nextCol] === 1) {
				setStatus('Duvara çarptın.', 'is-bad');
				return;
			}

			if (!(player.row === start.row && player.col === start.col)) {
				trail.push({ row: player.row, col: player.col });
			}

			player.row = nextRow;
			player.col = nextCol;
			moves += 1;
			updateStats();
			renderBoard();

			if (isSameCell(player, goal)) {
				finishRound();
			} else {
				setStatus('Devam et. Yıldıza ulaş.', 'is-info');
			}
		}

		function resetRound() {
			player = { row: start.row, col: start.col };
			trail = [];
			moves = 0;
			roundOver = false;
			updateStats();
			renderBoard();
			setStatus('Başlangıç noktasından hedefe ulaş.', 'is-info');
		}

		function newRound() {
			buildBoard();
			resetRound();
		}

		upButton.addEventListener('click', function () {
			tryMove(-1, 0);
		});

		downButton.addEventListener('click', function () {
			tryMove(1, 0);
		});

		leftButton.addEventListener('click', function () {
			tryMove(0, -1);
		});

		rightButton.addEventListener('click', function () {
			tryMove(0, 1);
		});

		newButton.addEventListener('click', function () {
			newRound();
		});

		restartButton.addEventListener('click', function () {
			resetRound();
		});

		game.addEventListener('keydown', function (event) {
			if (event.key === 'ArrowUp') {
				event.preventDefault();
				tryMove(-1, 0);
			} else if (event.key === 'ArrowDown') {
				event.preventDefault();
				tryMove(1, 0);
			} else if (event.key === 'ArrowLeft') {
				event.preventDefault();
				tryMove(0, -1);
			} else if (event.key === 'ArrowRight') {
				event.preventDefault();
				tryMove(0, 1);
			}
		});

		game.setAttribute('tabindex', '0');
		newRound();
	});
});
JS;

if (!function_exists('zo_game_grid_path_puzzle_render')) {
	function zo_game_grid_path_puzzle_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-grid-path-puzzle-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--grid-path-puzzle" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-gpp-title">Grid Path Puzzle</h2>
			<p class="zo-gpp-desc">Başlangıçtan yıldıza ulaş. Duvarlara çarpma. Ok tuşlarıyla veya düğmelerle ilerle.</p>

			<div class="zo-gpp-top">
				<div class="zo-gpp-stat">
					<span class="zo-gpp-stat-label">Hamle</span>
					<span class="zo-gpp-stat-value zo-gpp-moves">0</span>
				</div>
				<div class="zo-gpp-stat">
					<span class="zo-gpp-stat-label">Kazanç</span>
					<span class="zo-gpp-stat-value zo-gpp-wins">0</span>
				</div>
				<div class="zo-gpp-stat">
					<span class="zo-gpp-stat-label">En İyi</span>
					<span class="zo-gpp-stat-value zo-gpp-best">-</span>
				</div>
				<div class="zo-gpp-stat">
					<span class="zo-gpp-stat-label">Bölüm</span>
					<span class="zo-gpp-stat-value zo-gpp-level">1</span>
				</div>
			</div>

			<div class="zo-gpp-main">
				<div class="zo-gpp-board-wrap">
					<div class="zo-gpp-board" aria-live="polite"></div>
				</div>

				<div class="zo-gpp-side">
					<h3 class="zo-gpp-side-title">Kontroller</h3>
					<p class="zo-gpp-instructions">Mavi noktayı hareket ettir. Yeşil kare başlangıç, yıldız hedef, koyu kareler duvar.</p>

					<div class="zo-gpp-status" aria-live="polite">Başlangıç noktasından hedefe ulaş.</div>

					<div class="zo-gpp-controls">
						<button type="button" class="zo-gpp-button zo-gpp-button--move zo-gpp-button--up">Yukarı</button>
						<button type="button" class="zo-gpp-button zo-gpp-button--move zo-gpp-button--left">Sol</button>
						<button type="button" class="zo-gpp-button zo-gpp-button--move zo-gpp-button--down">Aşağı</button>
						<button type="button" class="zo-gpp-button zo-gpp-button--move zo-gpp-button--right">Sağ</button>
					</div>

					<button type="button" class="zo-gpp-button zo-gpp-button--new">Yeni Bölüm</button>
					<button type="button" class="zo-gpp-button zo-gpp-button--restart">Bu Bölümü Sıfırla</button>

					<div class="zo-gpp-legend">
						<div class="zo-gpp-legend-item">
							<span class="zo-gpp-legend-box zo-gpp-legend-box--start"></span>
							<span>Başlangıç</span>
						</div>
						<div class="zo-gpp-legend-item">
							<span class="zo-gpp-legend-box zo-gpp-legend-box--goal"></span>
							<span>Hedef</span>
						</div>
						<div class="zo-gpp-legend-item">
							<span class="zo-gpp-legend-box zo-gpp-legend-box--wall"></span>
							<span>Duvar</span>
						</div>
						<div class="zo-gpp-legend-item">
							<span class="zo-gpp-legend-box zo-gpp-legend-box--trail"></span>
							<span>Geçilen yol</span>
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
	'slug'            => 'grid-path-puzzle',
	'name'            => 'Grid Path Puzzle',
	'author'          => 'Asker',
	'description'     => 'Başlangıçtan hedefe gidilen, duvarlardan kaçınılan basit bir yol bulma oyunu.',
	'render_callback' => 'zo_game_grid_path_puzzle_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);