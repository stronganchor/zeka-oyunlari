<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--mirror-maze {
	max-width: 940px;
	margin: 0 auto;
	padding: 20px;
	border: 2px solid #d9e2ec;
	border-radius: 18px;
	background: #ffffff;
	box-sizing: border-box;
	font-family: Arial, sans-serif;
}

.zo-game-root--mirror-maze .zo-mm-title {
	margin: 0 0 10px;
	font-size: 30px;
	line-height: 1.2;
	text-align: center;
	color: #1f2937;
}

.zo-game-root--mirror-maze .zo-mm-desc {
	margin: 0 0 18px;
	font-size: 15px;
	line-height: 1.5;
	text-align: center;
	color: #4b5563;
}

.zo-game-root--mirror-maze .zo-mm-top {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 10px;
	margin-bottom: 16px;
}

.zo-game-root--mirror-maze .zo-mm-stat {
	border: 2px solid #d7e0ea;
	border-radius: 14px;
	padding: 12px;
	background: #f4f7fb;
	text-align: center;
}

.zo-game-root--mirror-maze .zo-mm-stat-label {
	display: block;
	font-size: 13px;
	font-weight: 700;
	color: #51606f;
	margin-bottom: 4px;
}

.zo-game-root--mirror-maze .zo-mm-stat-value {
	display: block;
	font-size: 24px;
	font-weight: 700;
	line-height: 1.1;
	color: #111827;
}

.zo-game-root--mirror-maze .zo-mm-main {
	display: grid;
	grid-template-columns: minmax(0, 1fr) 300px;
	gap: 16px;
	align-items: start;
}

.zo-game-root--mirror-maze .zo-mm-board-wrap,
.zo-game-root--mirror-maze .zo-mm-side {
	border: 2px solid #dbe4ee;
	border-radius: 16px;
	padding: 16px;
	background: #fbfdff;
	box-sizing: border-box;
}

.zo-game-root--mirror-maze .zo-mm-board {
	display: grid;
	grid-template-columns: repeat(6, minmax(0, 1fr));
	gap: 8px;
	max-width: 560px;
	margin: 0 auto 16px;
}

.zo-game-root--mirror-maze .zo-mm-cell {
	position: relative;
	aspect-ratio: 1 / 1;
	border: 2px solid #cfdae6;
	border-radius: 14px;
	background: #ecf4fb;
	box-sizing: border-box;
	display: flex;
	align-items: center;
	justify-content: center;
	padding: 0;
	cursor: pointer;
	transition: transform 0.12s ease, border-color 0.12s ease, background-color 0.12s ease;
}

.zo-game-root--mirror-maze .zo-mm-cell:hover,
.zo-game-root--mirror-maze .zo-mm-cell:focus {
	transform: translateY(-1px);
	outline: none;
}

.zo-game-root--mirror-maze .zo-mm-cell.is-empty {
	cursor: default;
	background: #f7fafc;
}

.zo-game-root--mirror-maze .zo-mm-cell.is-laser {
	background: #dbeafe;
	border-color: #60a5fa;
}

.zo-game-root--mirror-maze .zo-mm-cell.is-target {
	background: #fef3c7;
	border-color: #f59e0b;
}

.zo-game-root--mirror-maze .zo-mm-cell.is-hit {
	background: #dcfce7;
	border-color: #22c55e;
}

.zo-game-root--mirror-maze .zo-mm-cell.is-blocker {
	background: #e5e7eb;
	border-color: #9ca3af;
	cursor: default;
}

.zo-game-root--mirror-maze .zo-mm-cell.is-path {
	box-shadow: inset 0 0 0 3px rgba(37, 99, 235, 0.15);
}

.zo-game-root--mirror-maze .zo-mm-cell.is-path.is-hit {
	box-shadow: inset 0 0 0 3px rgba(34, 197, 94, 0.2);
}

.zo-game-root--mirror-maze .zo-mm-icon {
	position: relative;
	z-index: 2;
	font-size: 24px;
	font-weight: 700;
	color: #1f2937;
	line-height: 1;
}

.zo-game-root--mirror-maze .zo-mm-mirror-line {
	position: absolute;
	top: 50%;
	left: 50%;
	width: 72%;
	height: 6px;
	border-radius: 999px;
	background: #7c3aed;
	transform-origin: center;
}

.zo-game-root--mirror-maze .zo-mm-mirror-line[data-kind="slash"] {
	transform: translate(-50%, -50%) rotate(-45deg);
}

.zo-game-root--mirror-maze .zo-mm-mirror-line[data-kind="backslash"] {
	transform: translate(-50%, -50%) rotate(45deg);
}

.zo-game-root--mirror-maze .zo-mm-beam {
	position: absolute;
	z-index: 1;
	border-radius: 999px;
	background: linear-gradient(90deg, #38bdf8, #2563eb);
	box-shadow: 0 0 12px rgba(37, 99, 235, 0.35);
}

.zo-game-root--mirror-maze .zo-mm-beam--horizontal {
	top: 50%;
	left: 10%;
	width: 80%;
	height: 8px;
	transform: translateY(-50%);
}

.zo-game-root--mirror-maze .zo-mm-beam--vertical {
	top: 10%;
	left: 50%;
	width: 8px;
	height: 80%;
	transform: translateX(-50%);
}

.zo-game-root--mirror-maze .zo-mm-legend {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 8px;
}

.zo-game-root--mirror-maze .zo-mm-legend-item {
	display: flex;
	align-items: center;
	justify-content: center;
	gap: 8px;
	padding: 10px 8px;
	border: 2px solid #dbe4ee;
	border-radius: 12px;
	background: #ffffff;
	font-size: 13px;
	font-weight: 700;
	color: #374151;
}

.zo-game-root--mirror-maze .zo-mm-legend-box {
	width: 20px;
	height: 20px;
	border-radius: 6px;
	border: 2px solid #cbd5e1;
	background: #ecf4fb;
	box-sizing: border-box;
}

.zo-game-root--mirror-maze .zo-mm-legend-box--laser {
	background: #dbeafe;
	border-color: #60a5fa;
}

.zo-game-root--mirror-maze .zo-mm-legend-box--target {
	background: #fef3c7;
	border-color: #f59e0b;
}

.zo-game-root--mirror-maze .zo-mm-legend-box--mirror {
	background: linear-gradient(135deg, #ecf4fb 35%, #7c3aed 35%, #7c3aed 50%, #ecf4fb 50%);
}

.zo-game-root--mirror-maze .zo-mm-legend-box--blocker {
	background: #e5e7eb;
	border-color: #9ca3af;
}

.zo-game-root--mirror-maze .zo-mm-side-title {
	margin: 0 0 12px;
	font-size: 21px;
	line-height: 1.2;
	color: #1f2937;
	text-align: center;
}

.zo-game-root--mirror-maze .zo-mm-instructions {
	margin: 0 0 14px;
	font-size: 15px;
	line-height: 1.5;
	color: #4b5563;
	text-align: center;
}

.zo-game-root--mirror-maze .zo-mm-status {
	min-height: 24px;
	margin-bottom: 14px;
	text-align: center;
	font-size: 15px;
	font-weight: 700;
	color: #374151;
}

.zo-game-root--mirror-maze .zo-mm-status.is-good {
	color: #15803d;
}

.zo-game-root--mirror-maze .zo-mm-status.is-bad {
	color: #dc2626;
}

.zo-game-root--mirror-maze .zo-mm-status.is-info {
	color: #2563eb;
}

.zo-game-root--mirror-maze .zo-mm-mirror-tray {
	display: grid;
	grid-template-columns: repeat(2, minmax(0, 1fr));
	gap: 10px;
	margin-bottom: 14px;
}

.zo-game-root--mirror-maze .zo-mm-tray-card {
	border: 2px solid #d7e0ea;
	border-radius: 14px;
	padding: 12px;
	background: #ffffff;
	text-align: center;
}

.zo-game-root--mirror-maze .zo-mm-tray-label {
	display: block;
	font-size: 13px;
	font-weight: 700;
	color: #51606f;
	margin-bottom: 6px;
}

.zo-game-root--mirror-maze .zo-mm-tray-value {
	display: block;
	font-size: 24px;
	font-weight: 700;
	color: #111827;
}

.zo-game-root--mirror-maze .zo-mm-buttons {
	display: grid;
	gap: 10px;
}

.zo-game-root--mirror-maze .zo-mm-button {
	border: 0;
	border-radius: 12px;
	padding: 12px 14px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	width: 100%;
}

.zo-game-root--mirror-maze .zo-mm-button--new {
	background: #10b981;
	color: #ffffff;
}

.zo-game-root--mirror-maze .zo-mm-button--restart {
	background: #e5e7eb;
	color: #111827;
}

.zo-game-root--mirror-maze .zo-mm-button--fire {
	background: #2563eb;
	color: #ffffff;
}

.zo-game-root--mirror-maze .zo-mm-hint {
	margin: 14px 0 0;
	font-size: 14px;
	line-height: 1.5;
	color: #4b5563;
}

@media (max-width: 760px) {
	.zo-game-root.zo-game-root--mirror-maze {
		padding: 16px;
	}

	.zo-game-root--mirror-maze .zo-mm-title {
		font-size: 25px;
	}

	.zo-game-root--mirror-maze .zo-mm-top,
	.zo-game-root--mirror-maze .zo-mm-main,
	.zo-game-root--mirror-maze .zo-mm-legend {
		grid-template-columns: 1fr;
	}

	.zo-game-root--mirror-maze .zo-mm-board {
		gap: 6px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--mirror-maze');

	games.forEach(function (game) {
		const boardEl = game.querySelector('.zo-mm-board');
		const statusEl = game.querySelector('.zo-mm-status');
		const shotsEl = game.querySelector('.zo-mm-shots');
		const winsEl = game.querySelector('.zo-mm-wins');
		const levelEl = game.querySelector('.zo-mm-level');
		const mirrorsEl = game.querySelector('.zo-mm-mirrors');
		const targetsEls = game.querySelectorAll('.zo-mm-targets');
		const fireButton = game.querySelector('.zo-mm-button--fire');
		const restartButton = game.querySelector('.zo-mm-button--restart');
		const newButton = game.querySelector('.zo-mm-button--new');

		const size = 6;
		const DELTAS = {
			up: { row: -1, col: 0 },
			right: { row: 0, col: 1 },
			down: { row: 1, col: 0 },
			left: { row: 0, col: -1 }
		};
		const REFLECT = {
			slash: {
				up: 'right',
				right: 'up',
				down: 'left',
				left: 'down'
			},
			backslash: {
				up: 'left',
				left: 'up',
				down: 'right',
				right: 'down'
			}
		};

		let board = [];
		let initialMirrors = [];
		let level = 1;
		let wins = 0;
		let shots = 0;
		let solved = false;

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

		function setStatus(text, type) {
			statusEl.textContent = text;
			statusEl.className = 'zo-mm-status';
			if (type) {
				statusEl.classList.add(type);
			}
		}

		function createCell() {
			return {
				kind: 'empty',
				mirror: '',
				beam: '',
				hit: false
			};
		}

		function createBoard() {
			const grid = [];
			for (let row = 0; row < size; row++) {
				const line = [];
				for (let col = 0; col < size; col++) {
					line.push(createCell());
				}
				grid.push(line);
			}
			return grid;
		}

		function clearBeamState() {
			for (let row = 0; row < size; row++) {
				for (let col = 0; col < size; col++) {
					board[row][col].beam = '';
					board[row][col].hit = false;
				}
			}
		}

		function cloneMirrorState() {
			return board.map(function (row) {
				return row.map(function (cell) {
					return cell.kind === 'mirror' ? cell.mirror : '';
				});
			});
		}

		function restoreMirrors(snapshot) {
			for (let row = 0; row < size; row++) {
				for (let col = 0; col < size; col++) {
					if (board[row][col].kind === 'mirror') {
						board[row][col].mirror = snapshot[row][col];
					}
				}
			}
		}

		function chooseDirection(row, col) {
			if (row === 0) {
				return 'down';
			}
			if (row === size - 1) {
				return 'up';
			}
			if (col === 0) {
				return 'right';
			}
			return 'left';
		}

		function chooseLaserPosition() {
			const side = randomInt(4);
			const offset = 1 + randomInt(size - 2);

			if (side === 0) {
				return { row: 0, col: offset };
			}
			if (side === 1) {
				return { row: offset, col: size - 1 };
			}
			if (side === 2) {
				return { row: size - 1, col: offset };
			}
			return { row: offset, col: 0 };
		}

		function traceBeam(applyState) {
			clearBeamState();

			let laserCell = null;
			for (let row = 0; row < size; row++) {
				for (let col = 0; col < size; col++) {
					if (board[row][col].kind === 'laser') {
						laserCell = { row: row, col: col };
					}
				}
			}

			if (!laserCell) {
				return false;
			}

			let direction = chooseDirection(laserCell.row, laserCell.col);
			let row = laserCell.row;
			let col = laserCell.col;
			let safety = 0;

			while (safety < 120) {
				const cell = board[row][col];
				const isVertical = direction === 'up' || direction === 'down';

				if (applyState) {
					cell.beam = isVertical ? 'vertical' : 'horizontal';
				}

				if (cell.kind === 'target') {
					if (applyState) {
						cell.hit = true;
					}
					return true;
				}

				if (cell.kind === 'mirror') {
					direction = REFLECT[cell.mirror][direction];
					if (applyState) {
						cell.beam = direction === 'up' || direction === 'down' ? 'vertical' : 'horizontal';
					}
				}

				if (cell.kind === 'blocker') {
					return false;
				}

				row += DELTAS[direction].row;
				col += DELTAS[direction].col;

				if (!inBounds(row, col)) {
					return false;
				}

				safety += 1;
			}

			return false;
		}

		function buildPuzzle() {
			let ready = false;
			let tries = 0;

			while (!ready && tries < 300) {
				tries += 1;
				board = createBoard();

				const laser = chooseLaserPosition();
				const target = chooseLaserPosition();

				if (laser.row === target.row && laser.col === target.col) {
					continue;
				}

				board[laser.row][laser.col].kind = 'laser';
				board[target.row][target.col].kind = 'target';

				let pathRow = laser.row;
				let pathCol = laser.col;
				let direction = chooseDirection(laser.row, laser.col);
				let targetPlaced = false;
				let mirrorCount = 0;
				let turnBudget = 2 + Math.min(2, Math.floor(level / 2));
				let steps = 0;
				const visited = {};
				visited[pathRow + '-' + pathCol + '-' + direction] = true;

				while (steps < 30) {
					const nextRow = pathRow + DELTAS[direction].row;
					const nextCol = pathCol + DELTAS[direction].col;

					if (!inBounds(nextRow, nextCol)) {
						break;
					}

					pathRow = nextRow;
					pathCol = nextCol;
					steps += 1;

					if (pathRow === target.row && pathCol === target.col) {
						targetPlaced = true;
						break;
					}

					const currentCell = board[pathRow][pathCol];
					if (currentCell.kind !== 'empty') {
						break;
					}

					const key = pathRow + '-' + pathCol + '-' + direction;
					if (visited[key]) {
						break;
					}
					visited[key] = true;

					const rowDistance = Math.abs(target.row - pathRow);
					const colDistance = Math.abs(target.col - pathCol);
					const movingVertical = direction === 'up' || direction === 'down';
					const wantsTurn = movingVertical ? colDistance > 0 : rowDistance > 0;
					const canTurn = turnBudget > 0;
					const shouldTurn = canTurn && wantsTurn && (Math.random() < 0.85 || steps > 8);

					if (!shouldTurn) {
						continue;
					}

					let options = [];
					if (movingVertical) {
						if (target.col < pathCol) {
							options.push({ mirror: 'slash', direction: 'left' });
						}
						if (target.col > pathCol) {
							options.push({ mirror: 'backslash', direction: 'right' });
						}
					} else {
						if (target.row < pathRow) {
							options.push({ mirror: 'backslash', direction: 'up' });
						}
						if (target.row > pathRow) {
							options.push({ mirror: 'slash', direction: 'down' });
						}
					}

					if (!options.length) {
						continue;
					}

					const pick = options[randomInt(options.length)];
					currentCell.kind = 'mirror';
					currentCell.mirror = pick.mirror;
					direction = pick.direction;
					mirrorCount += 1;
					turnBudget -= 1;
				}

				if (!targetPlaced || mirrorCount < 1) {
					continue;
				}

				const blockerGoal = 2 + Math.min(4, level);
				let blockers = 0;
				let blockerTries = 0;

				while (blockers < blockerGoal && blockerTries < 120) {
					const row = randomInt(size);
					const col = randomInt(size);
					blockerTries += 1;

					if (board[row][col].kind !== 'empty') {
						continue;
					}

					board[row][col].kind = 'blocker';
					blockers += 1;
				}

				const scrambled = shuffleMirrors();
				if (!scrambled) {
					continue;
				}

				initialMirrors = cloneMirrorState();

				ready = true;
			}

			if (!ready) {
				board = createBoard();
				board[0][1].kind = 'laser';
				board[5][4].kind = 'target';
				board[2][1].kind = 'mirror';
				board[2][1].mirror = 'backslash';
				board[2][4].kind = 'mirror';
				board[2][4].mirror = 'slash';
				board[4][4].kind = 'blocker';
				shuffleMirrors();
				initialMirrors = cloneMirrorState();
			}
		}

		function shuffleMirrors() {
			let changed = false;

			for (let row = 0; row < size; row++) {
				for (let col = 0; col < size; col++) {
					if (board[row][col].kind !== 'mirror') {
						continue;
					}

					if (Math.random() < 0.7) {
						board[row][col].mirror = board[row][col].mirror === 'slash' ? 'backslash' : 'slash';
						changed = true;
					}
				}
			}

			if (!changed) {
				for (let row = 0; row < size; row++) {
					for (let col = 0; col < size; col++) {
						if (board[row][col].kind === 'mirror') {
							board[row][col].mirror = board[row][col].mirror === 'slash' ? 'backslash' : 'slash';
							changed = true;
							break;
						}
					}

					if (changed) {
						break;
					}
				}
			}

			const solvedNow = traceBeam(false);
			return changed && !solvedNow;
		}

		function countMirrors() {
			let total = 0;
			for (let row = 0; row < size; row++) {
				for (let col = 0; col < size; col++) {
					if (board[row][col].kind === 'mirror') {
						total += 1;
					}
				}
			}
			return total;
		}

		function renderBoard() {
			boardEl.innerHTML = '';

			for (let row = 0; row < size; row++) {
				for (let col = 0; col < size; col++) {
					const cell = board[row][col];
					const button = document.createElement('button');
					button.type = 'button';
					button.className = 'zo-mm-cell';
					button.setAttribute('data-row', String(row));
					button.setAttribute('data-col', String(col));

					if (cell.kind === 'empty') {
						button.classList.add('is-empty');
						button.setAttribute('aria-label', 'Empty cell');
					}

					if (cell.kind === 'laser') {
						button.classList.add('is-laser');
						button.innerHTML = '<span class="zo-mm-icon">L</span>';
						button.setAttribute('aria-label', 'Laser source');
					}

					if (cell.kind === 'target') {
						button.classList.add('is-target');
						button.innerHTML = '<span class="zo-mm-icon">T</span>';
						button.setAttribute('aria-label', 'Target');
					}

					if (cell.kind === 'blocker') {
						button.classList.add('is-blocker');
						button.innerHTML = '<span class="zo-mm-icon">■</span>';
						button.setAttribute('aria-label', 'Blocker');
					}

					if (cell.kind === 'mirror') {
						button.innerHTML = '<span class="zo-mm-mirror-line" data-kind="' + cell.mirror + '"></span>';
						button.setAttribute('aria-label', 'Mirror');
					}

					if (cell.beam) {
						button.classList.add('is-path');
						button.insertAdjacentHTML('beforeend', '<span class="zo-mm-beam zo-mm-beam--' + cell.beam + '"></span>');
					}

					if (cell.hit) {
						button.classList.add('is-hit');
					}

					if (cell.kind !== 'mirror') {
						button.disabled = true;
					} else {
						button.addEventListener('click', function () {
							flipMirror(row, col);
						});
					}

					boardEl.appendChild(button);
				}
			}
		}

		function updateStats() {
			shotsEl.textContent = String(shots);
			winsEl.textContent = String(wins);
			levelEl.textContent = String(level);
			mirrorsEl.textContent = String(countMirrors());
			targetsEls.forEach(function (targetEl) {
				targetEl.textContent = solved ? '1/1' : '0/1';
			});
		}

		function refreshBoard(message, type) {
			renderBoard();
			updateStats();
			if (message) {
				setStatus(message, type);
			}
		}

		function flipMirror(row, col) {
			if (solved) {
				setStatus('Yeni bolum ac veya ayni bolumu yeniden kur.', 'is-info');
				return;
			}

			const cell = board[row][col];
			if (cell.kind !== 'mirror') {
				return;
			}

			cell.mirror = cell.mirror === 'slash' ? 'backslash' : 'slash';
			clearBeamState();
			refreshBoard('Aynalari cevir. Hazirsan isini gonder.', 'is-info');
		}

		function fireLaser() {
			shots += 1;
			const success = traceBeam(true);

			if (success) {
				solved = true;
				wins += 1;
				refreshBoard('Harika. Isin hedefe ulasti.', 'is-good');
				return;
			}

			refreshBoard('Isin hedefe ulasmadi. Aynalari yeniden dene.', 'is-bad');
		}

		function resetRound() {
			restoreMirrors(initialMirrors);
			shots = 0;
			solved = false;
			clearBeamState();
			refreshBoard('Aynalari cevir ve sonra Ates Et dugmesine bas.', 'is-info');
		}

		function newRound() {
			shots = 0;
			solved = false;
			buildPuzzle();
			clearBeamState();
			refreshBoard('Aynalari cevir ve sonra Ates Et dugmesine bas.', 'is-info');
		}

		fireButton.addEventListener('click', function () {
			fireLaser();
		});

		restartButton.addEventListener('click', function () {
			resetRound();
		});

		newButton.addEventListener('click', function () {
			level += 1;
			newRound();
		});

		newRound();
	});
});
JS;

if (!function_exists('zo_game_mirror_maze_render')) {
	function zo_game_mirror_maze_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-mirror-maze-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--mirror-maze" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-mm-title">Mirror Maze</h2>
			<p class="zo-mm-desc">Aynalari cevir, lazeri hedefe yonlendir ve yolu ac. Her bolumde isini sari hedef kutusuna ulastir.</p>

			<div class="zo-mm-top">
				<div class="zo-mm-stat">
					<span class="zo-mm-stat-label">Ates</span>
					<span class="zo-mm-stat-value zo-mm-shots">0</span>
				</div>
				<div class="zo-mm-stat">
					<span class="zo-mm-stat-label">Kazanc</span>
					<span class="zo-mm-stat-value zo-mm-wins">0</span>
				</div>
				<div class="zo-mm-stat">
					<span class="zo-mm-stat-label">Bolum</span>
					<span class="zo-mm-stat-value zo-mm-level">1</span>
				</div>
				<div class="zo-mm-stat">
					<span class="zo-mm-stat-label">Hedef</span>
					<span class="zo-mm-stat-value zo-mm-targets">0/1</span>
				</div>
			</div>

			<div class="zo-mm-main">
				<div class="zo-mm-board-wrap">
					<div class="zo-mm-board" aria-live="polite"></div>

					<div class="zo-mm-legend">
						<div class="zo-mm-legend-item">
							<span class="zo-mm-legend-box zo-mm-legend-box--laser"></span>
							<span>Lazer</span>
						</div>
						<div class="zo-mm-legend-item">
							<span class="zo-mm-legend-box zo-mm-legend-box--target"></span>
							<span>Hedef</span>
						</div>
						<div class="zo-mm-legend-item">
							<span class="zo-mm-legend-box zo-mm-legend-box--mirror"></span>
							<span>Ayna</span>
						</div>
						<div class="zo-mm-legend-item">
							<span class="zo-mm-legend-box zo-mm-legend-box--blocker"></span>
							<span>Blok</span>
						</div>
					</div>
				</div>

				<div class="zo-mm-side">
					<h3 class="zo-mm-side-title">Nasil Oynanir</h3>
					<p class="zo-mm-instructions">Mor aynalara tiklayarak yonlerini degistir. Hazir olunca Ates Et dugmesine bas ve mavi isin sari hedefe varsin.</p>

					<div class="zo-mm-status" aria-live="polite">Aynalari cevir ve sonra Ates Et dugmesine bas.</div>

					<div class="zo-mm-mirror-tray">
						<div class="zo-mm-tray-card">
							<span class="zo-mm-tray-label">Ayna</span>
							<span class="zo-mm-tray-value zo-mm-mirrors">0</span>
						</div>
						<div class="zo-mm-tray-card">
							<span class="zo-mm-tray-label">Hedef Vuruldu</span>
							<span class="zo-mm-tray-value zo-mm-targets">0/1</span>
						</div>
					</div>

					<div class="zo-mm-buttons">
						<button type="button" class="zo-mm-button zo-mm-button--fire">Ates Et</button>
						<button type="button" class="zo-mm-button zo-mm-button--restart">Bu Bolumu Sifirla</button>
						<button type="button" class="zo-mm-button zo-mm-button--new">Yeni Bolum</button>
					</div>

					<p class="zo-mm-hint">Ipucu: `/` ve `\` yonundeki aynalar isini farkli sekilde sektirir. Isini duvarlardan uzak tut.</p>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'mirror-maze',
	'name'            => 'Mirror Maze',
	'author'          => 'Asker',
	'description'     => 'Aynalari cevirerek lazer isigini hedefe yonlendirdigin bulmaca oyunu.',
	'render_callback' => 'zo_game_mirror_maze_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
