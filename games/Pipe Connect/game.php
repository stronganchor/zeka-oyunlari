<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--pipe-connect {
	max-width: 860px;
	margin: 0 auto;
	padding: 20px;
	border: 2px solid #d9e2ec;
	border-radius: 18px;
	background: #ffffff;
	box-sizing: border-box;
	font-family: Arial, sans-serif;
}

.zo-game-root--pipe-connect .zo-pc-title {
	margin: 0 0 10px;
	font-size: 30px;
	line-height: 1.2;
	text-align: center;
	color: #1f2937;
}

.zo-game-root--pipe-connect .zo-pc-desc {
	margin: 0 0 18px;
	font-size: 15px;
	line-height: 1.5;
	text-align: center;
	color: #4b5563;
}

.zo-game-root--pipe-connect .zo-pc-top {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 10px;
	margin-bottom: 16px;
}

.zo-game-root--pipe-connect .zo-pc-stat {
	border: 2px solid #d7e0ea;
	border-radius: 14px;
	padding: 12px;
	background: #f4f7fb;
	text-align: center;
}

.zo-game-root--pipe-connect .zo-pc-stat-label {
	display: block;
	font-size: 13px;
	font-weight: 700;
	color: #51606f;
	margin-bottom: 4px;
}

.zo-game-root--pipe-connect .zo-pc-stat-value {
	display: block;
	font-size: 24px;
	font-weight: 700;
	line-height: 1.1;
	color: #111827;
}

.zo-game-root--pipe-connect .zo-pc-main {
	display: grid;
	grid-template-columns: 1fr 290px;
	gap: 16px;
	align-items: start;
}

.zo-game-root--pipe-connect .zo-pc-board-wrap,
.zo-game-root--pipe-connect .zo-pc-side {
	border: 2px solid #dbe4ee;
	border-radius: 16px;
	padding: 16px;
	background: #fbfdff;
	box-sizing: border-box;
}

.zo-game-root--pipe-connect .zo-pc-board {
	display: grid;
	grid-template-columns: repeat(5, minmax(0, 1fr));
	gap: 8px;
	max-width: 520px;
	margin: 0 auto;
}

.zo-game-root--pipe-connect .zo-pc-tile {
	position: relative;
	aspect-ratio: 1 / 1;
	border: 2px solid #d1d9e6;
	border-radius: 14px;
	background: #eef4fb;
	cursor: pointer;
	box-sizing: border-box;
	transition: transform 0.12s ease, background-color 0.12s ease, border-color 0.12s ease;
}

.zo-game-root--pipe-connect .zo-pc-tile:hover,
.zo-game-root--pipe-connect .zo-pc-tile:focus {
	transform: scale(1.02);
	outline: none;
}

.zo-game-root--pipe-connect .zo-pc-tile.is-source {
	background: #dcfce7;
	border-color: #22c55e;
}

.zo-game-root--pipe-connect .zo-pc-tile.is-goal {
	background: #fef3c7;
	border-color: #f59e0b;
}

.zo-game-root--pipe-connect .zo-pc-tile.is-powered {
	background: #dbeafe;
	border-color: #3b82f6;
}

.zo-game-root--pipe-connect .zo-pc-tile.is-source.is-powered {
	background: #bbf7d0;
}

.zo-game-root--pipe-connect .zo-pc-tile.is-goal.is-powered {
	background: #fde68a;
}

.zo-game-root--pipe-connect .zo-pc-path {
	position: absolute;
	background: #64748b;
	border-radius: 999px;
	transition: background-color 0.12s ease;
}

.zo-game-root--pipe-connect .zo-pc-tile.is-powered .zo-pc-path,
.zo-game-root--pipe-connect .zo-pc-tile.is-source .zo-pc-path,
.zo-game-root--pipe-connect .zo-pc-tile.is-goal.is-powered .zo-pc-path {
	background: #2563eb;
}

.zo-game-root--pipe-connect .zo-pc-path--up {
	top: 6%;
	left: 42%;
	width: 16%;
	height: 44%;
}

.zo-game-root--pipe-connect .zo-pc-path--right {
	top: 42%;
	right: 6%;
	width: 44%;
	height: 16%;
}

.zo-game-root--pipe-connect .zo-pc-path--down {
	bottom: 6%;
	left: 42%;
	width: 16%;
	height: 44%;
}

.zo-game-root--pipe-connect .zo-pc-path--left {
	top: 42%;
	left: 6%;
	width: 44%;
	height: 16%;
}

.zo-game-root--pipe-connect .zo-pc-center {
	position: absolute;
	top: 38%;
	left: 38%;
	width: 24%;
	height: 24%;
	border-radius: 999px;
	background: #64748b;
	transition: background-color 0.12s ease;
}

.zo-game-root--pipe-connect .zo-pc-tile.is-powered .zo-pc-center,
.zo-game-root--pipe-connect .zo-pc-tile.is-source .zo-pc-center,
.zo-game-root--pipe-connect .zo-pc-tile.is-goal.is-powered .zo-pc-center {
	background: #2563eb;
}

.zo-game-root--pipe-connect .zo-pc-side-title {
	margin: 0 0 12px;
	font-size: 21px;
	line-height: 1.2;
	color: #1f2937;
	text-align: center;
}

.zo-game-root--pipe-connect .zo-pc-instructions {
	margin: 0 0 14px;
	font-size: 15px;
	line-height: 1.5;
	color: #4b5563;
	text-align: center;
}

.zo-game-root--pipe-connect .zo-pc-status {
	min-height: 24px;
	margin-bottom: 14px;
	text-align: center;
	font-size: 15px;
	font-weight: 700;
	color: #374151;
}

.zo-game-root--pipe-connect .zo-pc-status.is-good {
	color: #15803d;
}

.zo-game-root--pipe-connect .zo-pc-status.is-bad {
	color: #dc2626;
}

.zo-game-root--pipe-connect .zo-pc-status.is-info {
	color: #2563eb;
}

.zo-game-root--pipe-connect .zo-pc-button {
	border: 0;
	border-radius: 12px;
	padding: 12px 14px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	box-sizing: border-box;
	width: 100%;
}

.zo-game-root--pipe-connect .zo-pc-button + .zo-pc-button {
	margin-top: 10px;
}

.zo-game-root--pipe-connect .zo-pc-button--new {
	background: #10b981;
	color: #ffffff;
}

.zo-game-root--pipe-connect .zo-pc-button--restart {
	background: #e5e7eb;
	color: #111827;
}

.zo-game-root--pipe-connect .zo-pc-legend {
	display: grid;
	grid-template-columns: 1fr;
	gap: 8px;
	margin-top: 14px;
}

.zo-game-root--pipe-connect .zo-pc-legend-item {
	display: flex;
	align-items: center;
	gap: 10px;
	font-size: 14px;
	color: #374151;
}

.zo-game-root--pipe-connect .zo-pc-legend-box {
	width: 22px;
	height: 22px;
	border-radius: 8px;
	border: 2px solid #d1d9e6;
	box-sizing: border-box;
}

.zo-game-root--pipe-connect .zo-pc-legend-box--source {
	background: #dcfce7;
	border-color: #22c55e;
}

.zo-game-root--pipe-connect .zo-pc-legend-box--goal {
	background: #fef3c7;
	border-color: #f59e0b;
}

.zo-game-root--pipe-connect .zo-pc-legend-box--pipe {
	background: #eef4fb;
	border-color: #d1d9e6;
}

.zo-game-root--pipe-connect .zo-pc-legend-box--powered {
	background: #dbeafe;
	border-color: #3b82f6;
}

@media (max-width: 760px) {
	.zo-game-root.zo-game-root--pipe-connect {
		padding: 16px;
	}

	.zo-game-root--pipe-connect .zo-pc-title {
		font-size: 25px;
	}

	.zo-game-root--pipe-connect .zo-pc-top,
	.zo-game-root--pipe-connect .zo-pc-main {
		grid-template-columns: 1fr;
	}

	.zo-game-root--pipe-connect .zo-pc-board {
		gap: 6px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--pipe-connect');

	games.forEach(function (game) {
		const boardEl = game.querySelector('.zo-pc-board');
		const statusEl = game.querySelector('.zo-pc-status');
		const movesEl = game.querySelector('.zo-pc-moves');
		const winsEl = game.querySelector('.zo-pc-wins');
		const poweredEl = game.querySelector('.zo-pc-powered');
		const levelEl = game.querySelector('.zo-pc-level');
		const newButton = game.querySelector('.zo-pc-button--new');
		const restartButton = game.querySelector('.zo-pc-button--restart');

		const size = 5;
		const OPPOSITE = {
			up: 'down',
			right: 'left',
			down: 'up',
			left: 'right'
		};
		const DELTAS = {
			up: { row: -1, col: 0 },
			right: { row: 0, col: 1 },
			down: { row: 1, col: 0 },
			left: { row: 0, col: -1 }
		};

		let board = [];
		let initialRotations = [];
		let moves = 0;
		let wins = 0;
		let level = 1;
		let solved = false;

		function setStatus(text, type) {
			statusEl.textContent = text;
			statusEl.className = 'zo-pc-status';
			if (type) {
				statusEl.classList.add(type);
			}
		}

		function randomInt(max) {
			return Math.floor(Math.random() * max);
		}

		function shuffle(array) {
			const copy = array.slice();
			for (let i = copy.length - 1; i > 0; i--) {
				const j = Math.floor(Math.random() * (i + 1));
				const temp = copy[i];
				copy[i] = copy[j];
				copy[j] = temp;
			}
			return copy;
		}

		function inBounds(row, col) {
			return row >= 0 && row < size && col >= 0 && col < size;
		}

		function rotateConnections(connections, times) {
			const order = ['up', 'right', 'down', 'left'];
			let result = connections.slice();

			for (let i = 0; i < times; i++) {
				result = result.map(function (dir) {
					const index = order.indexOf(dir);
					return order[(index + 1) % 4];
				});
			}

			return result;
		}

		function normalizeConnections(connections) {
			const order = ['up', 'right', 'down', 'left'];
			return connections.slice().sort(function (a, b) {
				return order.indexOf(a) - order.indexOf(b);
			});
		}

		function cloneBoard(sourceBoard) {
			return sourceBoard.map(function (row) {
				return row.map(function (cell) {
					return {
						type: cell.type,
						connections: cell.connections.slice(),
						baseConnections: cell.baseConnections.slice(),
						powered: false
					};
				});
			});
		}

		function buildSolvedBoard() {
			const solvedBoard = [];
			for (let row = 0; row < size; row++) {
				const line = [];
				for (let col = 0; col < size; col++) {
					line.push({
						type: 'empty',
						connections: [],
						baseConnections: [],
						powered: false
					});
				}
				solvedBoard.push(line);
			}

			const path = [{ row: 0, col: 0 }];
			let current = { row: 0, col: 0 };
			const goal = { row: size - 1, col: size - 1 };
			const seen = new Set(['0-0']);

			while (!(current.row === goal.row && current.col === goal.col)) {
				const possible = [];

				Object.keys(DELTAS).forEach(function (dir) {
					const nextRow = current.row + DELTAS[dir].row;
					const nextCol = current.col + DELTAS[dir].col;
					const key = nextRow + '-' + nextCol;

					if (!inBounds(nextRow, nextCol)) {
						return;
					}

					if (seen.has(key)) {
						return;
					}

					const distanceNow = Math.abs(goal.row - current.row) + Math.abs(goal.col - current.col);
					const distanceNext = Math.abs(goal.row - nextRow) + Math.abs(goal.col - nextCol);

					possible.push({
						dir: dir,
						row: nextRow,
						col: nextCol,
						better: distanceNext < distanceNow
					});
				});

				let nextStep = null;
				const betterMoves = possible.filter(function (item) {
					return item.better;
				});

				if (betterMoves.length && Math.random() < 0.75) {
					nextStep = betterMoves[randomInt(betterMoves.length)];
				} else if (possible.length) {
					nextStep = possible[randomInt(possible.length)];
				}

				if (!nextStep) {
					break;
				}

				current = { row: nextStep.row, col: nextStep.col };
				path.push(current);
				seen.add(current.row + '-' + current.col);
			}

			for (let i = 0; i < path.length; i++) {
				const cell = path[i];
				const connections = [];

				if (i > 0) {
					const prev = path[i - 1];
					if (prev.row === cell.row - 1 && prev.col === cell.col) {
						connections.push('up');
					}
					if (prev.row === cell.row + 1 && prev.col === cell.col) {
						connections.push('down');
					}
					if (prev.row === cell.row && prev.col === cell.col - 1) {
						connections.push('left');
					}
					if (prev.row === cell.row && prev.col === cell.col + 1) {
						connections.push('right');
					}
				}

				if (i < path.length - 1) {
					const next = path[i + 1];
					if (next.row === cell.row - 1 && next.col === cell.col) {
						connections.push('up');
					}
					if (next.row === cell.row + 1 && next.col === cell.col) {
						connections.push('down');
					}
					if (next.row === cell.row && next.col === cell.col - 1) {
						connections.push('left');
					}
					if (next.row === cell.row && next.col === cell.col + 1) {
						connections.push('right');
					}
				}

				solvedBoard[cell.row][cell.col] = {
					type: 'pipe',
					connections: normalizeConnections(connections),
					baseConnections: normalizeConnections(connections),
					powered: false
				};
			}

			solvedBoard[0][0].type = 'source';
			solvedBoard[goal.row][goal.col].type = 'goal';

			const extraCount = 4 + Math.min(level, 6);
			let added = 0;
			let tries = 0;

			while (added < extraCount && tries < 300) {
				const row = randomInt(size);
				const col = randomInt(size);
				tries += 1;

				if (solvedBoard[row][col].type !== 'empty') {
					continue;
				}

				const dirs = shuffle(['up', 'right', 'down', 'left']);
				const count = Math.random() < 0.7 ? 2 : 3;
				const chosen = dirs.slice(0, count).filter(function (dir) {
					const nextRow = row + DELTAS[dir].row;
					const nextCol = col + DELTAS[dir].col;
					return inBounds(nextRow, nextCol);
				});

				if (chosen.length < 2) {
					continue;
				}

				solvedBoard[row][col] = {
					type: 'pipe',
					connections: normalizeConnections(chosen),
					baseConnections: normalizeConnections(chosen),
					powered: false
				};
				added += 1;
			}

			return solvedBoard;
		}

		function scrambleBoard(solvedBoard) {
			const newBoard = cloneBoard(solvedBoard);
			initialRotations = [];

			for (let row = 0; row < size; row++) {
				const rotationRow = [];
				for (let col = 0; col < size; col++) {
					const cell = newBoard[row][col];
					let rotation = 0;

					if (cell.type !== 'empty') {
						rotation = randomInt(4);

						if (rotation === 0 && cell.type === 'pipe' && cell.connections.length > 0) {
							rotation = 1;
						}

						cell.connections = normalizeConnections(rotateConnections(cell.baseConnections, rotation));
					}

					rotationRow.push(rotation);
				}
				initialRotations.push(rotationRow);
			}

			return newBoard;
		}

		function cellHasConnection(cell, dir) {
			return cell.connections.indexOf(dir) !== -1;
		}

		function computePowered() {
			for (let row = 0; row < size; row++) {
				for (let col = 0; col < size; col++) {
					board[row][col].powered = false;
				}
			}

			const queue = [{ row: 0, col: 0 }];
			board[0][0].powered = true;

			while (queue.length) {
				const current = queue.shift();
				const cell = board[current.row][current.col];

				cell.connections.forEach(function (dir) {
					const nextRow = current.row + DELTAS[dir].row;
					const nextCol = current.col + DELTAS[dir].col;

					if (!inBounds(nextRow, nextCol)) {
						return;
					}

					const neighbor = board[nextRow][nextCol];

					if (!cellHasConnection(neighbor, OPPOSITE[dir])) {
						return;
					}

					if (!neighbor.powered) {
						neighbor.powered = true;
						queue.push({ row: nextRow, col: nextCol });
					}
				});
			}
		}

		function isSolved() {
			const goalCell = board[size - 1][size - 1];
			return goalCell.powered;
		}

		function updateStats() {
			let poweredCount = 0;

			for (let row = 0; row < size; row++) {
				for (let col = 0; col < size; col++) {
					if (board[row][col].powered) {
						poweredCount += 1;
					}
				}
			}

			movesEl.textContent = String(moves);
			winsEl.textContent = String(wins);
			poweredEl.textContent = String(poweredCount);
			levelEl.textContent = String(level);
		}

		function renderTile(cell, row, col) {
			const tile = document.createElement('button');
			tile.type = 'button';
			tile.className = 'zo-pc-tile';
			tile.setAttribute('data-row', String(row));
			tile.setAttribute('data-col', String(col));
			tile.setAttribute('aria-label', 'Pipe tile');

			if (cell.type === 'source') {
				tile.classList.add('is-source');
			}

			if (cell.type === 'goal') {
				tile.classList.add('is-goal');
			}

			if (cell.powered) {
				tile.classList.add('is-powered');
			}

			if (cell.connections.length) {
				cell.connections.forEach(function (dir) {
					const path = document.createElement('span');
					path.className = 'zo-pc-path zo-pc-path--' + dir;
					tile.appendChild(path);
				});

				const center = document.createElement('span');
				center.className = 'zo-pc-center';
				tile.appendChild(center);
			}

			tile.addEventListener('click', function () {
				rotateTile(row, col);
			});

			return tile;
		}

		function renderBoard() {
			boardEl.innerHTML = '';

			for (let row = 0; row < size; row++) {
				for (let col = 0; col < size; col++) {
					boardEl.appendChild(renderTile(board[row][col], row, col));
				}
			}
		}

		function refreshBoardState() {
			computePowered();
			updateStats();
			renderBoard();

			if (isSolved()) {
				solved = true;
				wins += 1;
				updateStats();
				setStatus('Kazandın. Su hedefe ulaştı.', 'is-good');
			} else if (!solved) {
				setStatus('Boruları çevir ve yolu tamamla.', 'is-info');
			}
		}

		function rotateTile(row, col) {
			if (solved) {
				setStatus('Yeni bölüm başlat veya aynı bölümü yeniden kur.', 'is-info');
				return;
			}

			const cell = board[row][col];

			if (!cell.connections.length) {
				return;
			}

			cell.connections = normalizeConnections(rotateConnections(cell.connections, 1));
			moves += 1;
			refreshBoardState();
		}

		function resetLevel() {
			const solvedBoard = buildSolvedBoard();
			board = scrambleBoard(solvedBoard);
			moves = 0;
			solved = false;
			refreshBoardState();
		}

		function newLevel() {
			moves = 0;
			solved = false;
			resetLevel();
		}

		newButton.addEventListener('click', function () {
			level += 1;
			newLevel();
		});

		restartButton.addEventListener('click', function () {
			resetLevel();
		});

		newLevel();
	});
});
JS;

if (!function_exists('zo_game_pipe_connect_render')) {
	function zo_game_pipe_connect_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-pipe-connect-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--pipe-connect" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-pc-title">Pipe Connect</h2>
			<p class="zo-pc-desc">Boruları çevir. Kaynaktan hedefe tam bağlantı kur. Mavi akış yıldız kutuya ulaşınca kazanırsın.</p>

			<div class="zo-pc-top">
				<div class="zo-pc-stat">
					<span class="zo-pc-stat-label">Hamle</span>
					<span class="zo-pc-stat-value zo-pc-moves">0</span>
				</div>
				<div class="zo-pc-stat">
					<span class="zo-pc-stat-label">Kazanç</span>
					<span class="zo-pc-stat-value zo-pc-wins">0</span>
				</div>
				<div class="zo-pc-stat">
					<span class="zo-pc-stat-label">Açık Parça</span>
					<span class="zo-pc-stat-value zo-pc-powered">0</span>
				</div>
				<div class="zo-pc-stat">
					<span class="zo-pc-stat-label">Bölüm</span>
					<span class="zo-pc-stat-value zo-pc-level">1</span>
				</div>
			</div>

			<div class="zo-pc-main">
				<div class="zo-pc-board-wrap">
					<div class="zo-pc-board" aria-live="polite"></div>
				</div>

				<div class="zo-pc-side">
					<h3 class="zo-pc-side-title">Nasıl Oynanır</h3>
					<p class="zo-pc-instructions">Her kareye tıklayarak boruyu döndür. Yeşil kaynak kutusundan sarı hedef kutusuna kesintisiz yol yap.</p>

					<div class="zo-pc-status" aria-live="polite">Boruları çevir ve yolu tamamla.</div>

					<button type="button" class="zo-pc-button zo-pc-button--new">Yeni Bölüm</button>
					<button type="button" class="zo-pc-button zo-pc-button--restart">Bu Bölümü Karıştır</button>

					<div class="zo-pc-legend">
						<div class="zo-pc-legend-item">
							<span class="zo-pc-legend-box zo-pc-legend-box--source"></span>
							<span>Kaynak</span>
						</div>
						<div class="zo-pc-legend-item">
							<span class="zo-pc-legend-box zo-pc-legend-box--goal"></span>
							<span>Hedef</span>
						</div>
						<div class="zo-pc-legend-item">
							<span class="zo-pc-legend-box zo-pc-legend-box--pipe"></span>
							<span>Boru</span>
						</div>
						<div class="zo-pc-legend-item">
							<span class="zo-pc-legend-box zo-pc-legend-box--powered"></span>
							<span>Bağlı Akış</span>
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
	'slug'            => 'pipe-connect',
	'name'            => 'Pipe Connect',
	'author'          => 'Asker',
	'description'     => 'Kaynak ve hedef arasında boruları çevirerek bağlantı kurulan basit bir bulmaca oyunu.',
	'render_callback' => 'zo_game_pipe_connect_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);