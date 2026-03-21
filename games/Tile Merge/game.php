<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 520px;
	margin: 0 auto;
	text-align: center;
	font-family: Arial, sans-serif;
}

.zo-game-root--tile-merge .zo-tm-card {
	background: #ffffff;
	border: 3px solid #222;
	border-radius: 18px;
	padding: 20px;
	box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}

.zo-game-root--tile-merge .zo-tm-title {
	font-size: 28px;
	font-weight: 700;
	margin: 0 0 10px;
	color: #222;
}

.zo-game-root--tile-merge .zo-tm-subtitle {
	font-size: 16px;
	line-height: 1.5;
	margin: 0 0 16px;
	color: #444;
}

.zo-game-root--tile-merge .zo-tm-status {
	min-height: 28px;
	font-size: 18px;
	font-weight: 700;
	margin: 12px 0 16px;
	color: #0b5;
}

.zo-game-root--tile-merge .zo-tm-stats {
	display: flex;
	justify-content: center;
	gap: 12px;
	flex-wrap: wrap;
	margin-bottom: 16px;
}

.zo-game-root--tile-merge .zo-tm-stat {
	background: #f4f4f4;
	border: 2px solid #ddd;
	border-radius: 999px;
	padding: 8px 14px;
	font-size: 14px;
	font-weight: 700;
	color: #333;
}

.zo-game-root--tile-merge .zo-tm-board {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 8px;
	background: #d7c7a8;
	border: 3px solid #222;
	border-radius: 16px;
	padding: 8px;
	margin-bottom: 16px;
}

.zo-game-root--tile-merge .zo-tm-cell {
	aspect-ratio: 1 / 1;
	border-radius: 12px;
	background: rgba(255, 255, 255, 0.28);
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 28px;
	font-weight: 700;
	color: #222;
	user-select: none;
}

.zo-game-root--tile-merge .zo-tm-cell[data-value="0"] {
	color: transparent;
}

.zo-game-root--tile-merge .zo-tm-cell[data-value="2"] {
	background: #eee4da;
}

.zo-game-root--tile-merge .zo-tm-cell[data-value="4"] {
	background: #ede0c8;
}

.zo-game-root--tile-merge .zo-tm-cell[data-value="8"] {
	background: #f2b179;
	color: #fff;
}

.zo-game-root--tile-merge .zo-tm-cell[data-value="16"] {
	background: #f59563;
	color: #fff;
}

.zo-game-root--tile-merge .zo-tm-cell[data-value="32"] {
	background: #f67c5f;
	color: #fff;
}

.zo-game-root--tile-merge .zo-tm-cell[data-value="64"] {
	background: #f65e3b;
	color: #fff;
}

.zo-game-root--tile-merge .zo-tm-cell[data-value="128"] {
	background: #edcf72;
	color: #fff;
	font-size: 24px;
}

.zo-game-root--tile-merge .zo-tm-cell[data-value="256"] {
	background: #edcc61;
	color: #fff;
	font-size: 24px;
}

.zo-game-root--tile-merge .zo-tm-cell[data-value="512"] {
	background: #edc850;
	color: #fff;
	font-size: 24px;
}

.zo-game-root--tile-merge .zo-tm-cell[data-value="1024"] {
	background: #edc53f;
	color: #fff;
	font-size: 20px;
}

.zo-game-root--tile-merge .zo-tm-cell[data-value="2048"] {
	background: #edc22e;
	color: #fff;
	font-size: 20px;
}

.zo-game-root--tile-merge .zo-tm-actions {
	display: flex;
	justify-content: center;
	gap: 10px;
	flex-wrap: wrap;
	margin-bottom: 12px;
}

.zo-game-root--tile-merge .zo-tm-btn {
	appearance: none;
	border: 2px solid #222;
	background: #222;
	color: #fff;
	border-radius: 999px;
	padding: 10px 16px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
}

.zo-game-root--tile-merge .zo-tm-btn:hover,
.zo-game-root--tile-merge .zo-tm-btn:focus {
	background: #000;
	outline: none;
}

.zo-game-root--tile-merge .zo-tm-help {
	margin-top: 14px;
	font-size: 14px;
	color: #555;
	line-height: 1.5;
}

@media (max-width: 420px) {
	.zo-game-root--tile-merge .zo-tm-cell {
		font-size: 22px;
	}

	.zo-game-root--tile-merge .zo-tm-cell[data-value="1024"],
	.zo-game-root--tile-merge .zo-tm-cell[data-value="2048"] {
		font-size: 18px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--tile-merge');

	games.forEach(function (game) {
		const boardEl = game.querySelector('.zo-tm-board');
		const statusEl = game.querySelector('.zo-tm-status');
		const scoreEl = game.querySelector('.zo-tm-score-value');
		const bestEl = game.querySelector('.zo-tm-best-value');
		const movesEl = game.querySelector('.zo-tm-moves-value');
		const restartBtn = game.querySelector('.zo-tm-restart');

		let board = [];
		let score = 0;
		let moves = 0;
		let bestTile = 0;
		let gameOver = false;
		let won = false;

		function createEmptyBoard() {
			return [
				[0, 0, 0, 0],
				[0, 0, 0, 0],
				[0, 0, 0, 0],
				[0, 0, 0, 0]
			];
		}

		function getEmptyCells() {
			const empty = [];
			for (let r = 0; r < 4; r++) {
				for (let c = 0; c < 4; c++) {
					if (board[r][c] === 0) {
						empty.push({ r: r, c: c });
					}
				}
			}
			return empty;
		}

		function addRandomTile() {
			const empty = getEmptyCells();
			if (!empty.length) {
				return;
			}
			const spot = empty[Math.floor(Math.random() * empty.length)];
			board[spot.r][spot.c] = Math.random() < 0.9 ? 2 : 4;
		}

		function updateBestTile() {
			let highest = 0;
			for (let r = 0; r < 4; r++) {
				for (let c = 0; c < 4; c++) {
					if (board[r][c] > highest) {
						highest = board[r][c];
					}
				}
			}
			bestTile = highest;
		}

		function renderBoard() {
			boardEl.innerHTML = '';
			for (let r = 0; r < 4; r++) {
				for (let c = 0; c < 4; c++) {
					const cell = document.createElement('div');
					cell.className = 'zo-tm-cell';
					cell.dataset.value = String(board[r][c]);
					cell.textContent = board[r][c] === 0 ? '' : String(board[r][c]);
					boardEl.appendChild(cell);
				}
			}
			scoreEl.textContent = String(score);
			bestEl.textContent = String(bestTile);
			movesEl.textContent = String(moves);
		}

		function setStatus(text) {
			statusEl.textContent = text;
		}

		function slideAndMergeLine(line) {
			const filtered = line.filter(function (value) {
				return value !== 0;
			});

			let points = 0;
			for (let i = 0; i < filtered.length - 1; i++) {
				if (filtered[i] === filtered[i + 1]) {
					filtered[i] *= 2;
					points += filtered[i];
					filtered[i + 1] = 0;
					i++;
				}
			}

			const merged = filtered.filter(function (value) {
				return value !== 0;
			});

			while (merged.length < 4) {
				merged.push(0);
			}

			return {
				line: merged,
				points: points
			};
		}

		function boardsEqual(a, b) {
			for (let r = 0; r < 4; r++) {
				for (let c = 0; c < 4; c++) {
					if (a[r][c] !== b[r][c]) {
						return false;
					}
				}
			}
			return true;
		}

		function cloneBoard(source) {
			return source.map(function (row) {
				return row.slice();
			});
		}

		function moveLeft() {
			const oldBoard = cloneBoard(board);
			let gained = 0;

			for (let r = 0; r < 4; r++) {
				const result = slideAndMergeLine(board[r]);
				board[r] = result.line;
				gained += result.points;
			}

			return {
				changed: !boardsEqual(oldBoard, board),
				points: gained
			};
		}

		function moveRight() {
			const oldBoard = cloneBoard(board);
			let gained = 0;

			for (let r = 0; r < 4; r++) {
				const reversed = board[r].slice().reverse();
				const result = slideAndMergeLine(reversed);
				board[r] = result.line.reverse();
				gained += result.points;
			}

			return {
				changed: !boardsEqual(oldBoard, board),
				points: gained
			};
		}

		function moveUp() {
			const oldBoard = cloneBoard(board);
			let gained = 0;

			for (let c = 0; c < 4; c++) {
				const col = [board[0][c], board[1][c], board[2][c], board[3][c]];
				const result = slideAndMergeLine(col);
				board[0][c] = result.line[0];
				board[1][c] = result.line[1];
				board[2][c] = result.line[2];
				board[3][c] = result.line[3];
				gained += result.points;
			}

			return {
				changed: !boardsEqual(oldBoard, board),
				points: gained
			};
		}

		function moveDown() {
			const oldBoard = cloneBoard(board);
			let gained = 0;

			for (let c = 0; c < 4; c++) {
				const col = [board[3][c], board[2][c], board[1][c], board[0][c]];
				const result = slideAndMergeLine(col);
				board[3][c] = result.line[0];
				board[2][c] = result.line[1];
				board[1][c] = result.line[2];
				board[0][c] = result.line[3];
				gained += result.points;
			}

			return {
				changed: !boardsEqual(oldBoard, board),
				points: gained
			};
		}

		function hasMovesLeft() {
			if (getEmptyCells().length) {
				return true;
			}

			for (let r = 0; r < 4; r++) {
				for (let c = 0; c < 4; c++) {
					const value = board[r][c];
					if (r < 3 && board[r + 1][c] === value) {
						return true;
					}
					if (c < 3 && board[r][c + 1] === value) {
						return true;
					}
				}
			}

			return false;
		}

		function afterMove(result) {
			if (!result.changed || gameOver) {
				return;
			}

			score += result.points;
			moves += 1;
			addRandomTile();
			updateBestTile();

			if (!won && bestTile >= 128) {
				won = true;
				setStatus('Great job. You made 128.');
			} else if (!hasMovesLeft()) {
				gameOver = true;
				setStatus('Game over. No more moves.');
			} else {
				setStatus('Keep merging tiles.');
			}

			renderBoard();
		}

		function handleMove(direction) {
			if (gameOver) {
				return;
			}

			if (direction === 'left') {
				afterMove(moveLeft());
			} else if (direction === 'right') {
				afterMove(moveRight());
			} else if (direction === 'up') {
				afterMove(moveUp());
			} else if (direction === 'down') {
				afterMove(moveDown());
			}
		}

		function startGame() {
			board = createEmptyBoard();
			score = 0;
			moves = 0;
			bestTile = 0;
			gameOver = false;
			won = false;
			addRandomTile();
			addRandomTile();
			updateBestTile();
			renderBoard();
			setStatus('Use arrow keys or swipe buttons to merge tiles.');
		}

		restartBtn.addEventListener('click', function () {
			startGame();
		});

		game.querySelector('.zo-tm-up').addEventListener('click', function () {
			handleMove('up');
		});

		game.querySelector('.zo-tm-left').addEventListener('click', function () {
			handleMove('left');
		});

		game.querySelector('.zo-tm-down').addEventListener('click', function () {
			handleMove('down');
		});

		game.querySelector('.zo-tm-right').addEventListener('click', function () {
			handleMove('right');
		});

		game.setAttribute('tabindex', '0');
		game.addEventListener('keydown', function (event) {
			if (event.key === 'ArrowUp') {
				event.preventDefault();
				handleMove('up');
			} else if (event.key === 'ArrowDown') {
				event.preventDefault();
				handleMove('down');
			} else if (event.key === 'ArrowLeft') {
				event.preventDefault();
				handleMove('left');
			} else if (event.key === 'ArrowRight') {
				event.preventDefault();
				handleMove('right');
			}
		});

		let touchStartX = 0;
		let touchStartY = 0;

		boardEl.addEventListener('touchstart', function (event) {
			const touch = event.changedTouches[0];
			touchStartX = touch.clientX;
			touchStartY = touch.clientY;
		}, { passive: true });

		boardEl.addEventListener('touchend', function (event) {
			const touch = event.changedTouches[0];
			const dx = touch.clientX - touchStartX;
			const dy = touch.clientY - touchStartY;
			const absX = Math.abs(dx);
			const absY = Math.abs(dy);

			if (Math.max(absX, absY) < 20) {
				return;
			}

			if (absX > absY) {
				handleMove(dx > 0 ? 'right' : 'left');
			} else {
				handleMove(dy > 0 ? 'down' : 'up');
			}
		}, { passive: true });

		startGame();
	});
});
JS;

if (!function_exists('zo_game_tile_merge_render')) {
	function zo_game_tile_merge_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-tile-merge-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--tile-merge" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-tm-card">
				<h2 class="zo-tm-title">Tile Merge</h2>
				<p class="zo-tm-subtitle">Slide matching number tiles together to merge them into bigger numbers. Reach 128 to win this kid-friendly version.</p>

				<div class="zo-tm-stats">
					<div class="zo-tm-stat">Score: <span class="zo-tm-score-value">0</span></div>
					<div class="zo-tm-stat">Best Tile: <span class="zo-tm-best-value">0</span></div>
					<div class="zo-tm-stat">Moves: <span class="zo-tm-moves-value">0</span></div>
				</div>

				<div class="zo-tm-status" aria-live="polite">Use arrow keys or swipe buttons to merge tiles.</div>

				<div class="zo-tm-board"></div>

				<div class="zo-tm-actions">
					<button type="button" class="zo-tm-btn zo-tm-up">Up</button>
				</div>
				<div class="zo-tm-actions">
					<button type="button" class="zo-tm-btn zo-tm-left">Left</button>
					<button type="button" class="zo-tm-btn zo-tm-down">Down</button>
					<button type="button" class="zo-tm-btn zo-tm-right">Right</button>
				</div>
				<div class="zo-tm-actions">
					<button type="button" class="zo-tm-btn zo-tm-restart">Restart</button>
				</div>

				<div class="zo-tm-help">You can play with arrow keys on desktop or swipe / tap the buttons on mobile.</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'tile-merge',
	'name'            => 'Tile Merge',
	'author'          => 'Arslan',
	'description'     => 'A simple number merging puzzle game for kids.',
	'render_callback' => 'zo_game_tile_merge_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);