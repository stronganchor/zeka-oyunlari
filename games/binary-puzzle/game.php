<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--binary-puzzle {
	max-width: 760px;
	margin: 0 auto;
	padding: 20px;
	border-radius: 24px;
	background:
		radial-gradient(circle at top right, rgba(255, 255, 255, 0.82), transparent 28%),
		linear-gradient(180deg, #f7fbff 0%, #dcefff 100%);
	border: 2px solid #b9d4ef;
	box-sizing: border-box;
	font-family: "Trebuchet MS", "Segoe UI", sans-serif;
	color: #17324d;
	box-shadow: 0 18px 36px rgba(55, 98, 146, 0.14);
}

.zo-game-root--binary-puzzle .zo-bp-card {
	background: rgba(255, 255, 255, 0.88);
	border: 1px solid rgba(84, 127, 175, 0.2);
	border-radius: 20px;
	padding: 18px;
}

.zo-game-root--binary-puzzle .zo-bp-title {
	margin: 0 0 8px;
	font-size: 34px;
	line-height: 1;
	text-align: center;
}

.zo-game-root--binary-puzzle .zo-bp-subtitle {
	margin: 0 auto 16px;
	max-width: 620px;
	font-size: 15px;
	line-height: 1.6;
	text-align: center;
	color: #47627b;
}

.zo-game-root--binary-puzzle .zo-bp-stats {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 10px;
	margin-bottom: 16px;
}

.zo-game-root--binary-puzzle .zo-bp-stat {
	padding: 12px;
	border-radius: 16px;
	background: #f3f8fe;
	border: 1px solid #d5e4f4;
	text-align: center;
}

.zo-game-root--binary-puzzle .zo-bp-stat-label {
	display: block;
	margin-bottom: 4px;
	font-size: 12px;
	font-weight: 800;
	letter-spacing: 0.06em;
	text-transform: uppercase;
	color: #62809b;
}

.zo-game-root--binary-puzzle .zo-bp-stat-value {
	display: block;
	font-size: 24px;
	font-weight: 800;
	line-height: 1;
}

.zo-game-root--binary-puzzle .zo-bp-board-wrap {
	display: flex;
	justify-content: center;
	margin-bottom: 14px;
}

.zo-game-root--binary-puzzle .zo-bp-board {
	display: grid;
	gap: 6px;
}

.zo-game-root--binary-puzzle .zo-bp-cell {
	width: 64px;
	height: 64px;
	border: 2px solid #c2d8ef;
	border-radius: 16px;
	background: #ffffff;
	color: #17324d;
	font-size: 28px;
	font-weight: 900;
	cursor: pointer;
	transition: transform 0.12s ease, border-color 0.12s ease, background 0.12s ease;
}

.zo-game-root--binary-puzzle .zo-bp-cell:hover,
.zo-game-root--binary-puzzle .zo-bp-cell:focus-visible {
	transform: translateY(-1px);
	border-color: #689dd1;
	outline: none;
}

.zo-game-root--binary-puzzle .zo-bp-cell.is-given {
	background: linear-gradient(180deg, #1f5d96 0%, #184876 100%);
	border-color: #184876;
	color: #ffffff;
	cursor: default;
}

.zo-game-root--binary-puzzle .zo-bp-cell.is-player {
	background: linear-gradient(180deg, #ffffff 0%, #edf6ff 100%);
}

.zo-game-root--binary-puzzle .zo-bp-cell.is-bad {
	border-color: #d35454;
	background: #fff0f0;
	color: #a12f2f;
}

.zo-game-root--binary-puzzle .zo-bp-rules {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 10px;
	margin-bottom: 14px;
}

.zo-game-root--binary-puzzle .zo-bp-rule {
	padding: 12px;
	border-radius: 16px;
	background: #f7fbff;
	border: 1px solid #d5e4f4;
	font-size: 14px;
	line-height: 1.45;
	color: #47627b;
}

.zo-game-root--binary-puzzle .zo-bp-actions {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	justify-content: center;
	margin-bottom: 12px;
}

.zo-game-root--binary-puzzle .zo-bp-btn {
	border: 0;
	border-radius: 999px;
	padding: 12px 18px;
	font-size: 14px;
	font-weight: 800;
	cursor: pointer;
}

.zo-game-root--binary-puzzle .zo-bp-btn--new {
	background: #1f7a5a;
	color: #fff;
}

.zo-game-root--binary-puzzle .zo-bp-btn--check {
	background: #e8a531;
	color: #17324d;
}

.zo-game-root--binary-puzzle .zo-bp-btn--clear {
	background: #dde7f2;
	color: #17324d;
}

.zo-game-root--binary-puzzle .zo-bp-status {
	min-height: 24px;
	text-align: center;
	font-size: 15px;
	font-weight: 800;
	color: #47627b;
}

.zo-game-root--binary-puzzle .zo-bp-status.is-good {
	color: #1f7a5a;
}

.zo-game-root--binary-puzzle .zo-bp-status.is-warn {
	color: #b0581c;
}

.zo-game-root--binary-puzzle .zo-bp-helper {
	margin-top: 10px;
	text-align: center;
	font-size: 14px;
	font-weight: 700;
	color: #62809b;
}

@media (max-width: 640px) {
	.zo-game-root.zo-game-root--binary-puzzle {
		padding: 14px;
	}

	.zo-game-root--binary-puzzle .zo-bp-title {
		font-size: 28px;
	}

	.zo-game-root--binary-puzzle .zo-bp-stats,
	.zo-game-root--binary-puzzle .zo-bp-rules {
		grid-template-columns: 1fr 1fr;
	}

	.zo-game-root--binary-puzzle .zo-bp-cell {
		width: 48px;
		height: 48px;
		font-size: 22px;
		border-radius: 12px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--binary-puzzle');

	games.forEach(function (game) {
		const size = 6;
		const boardEl = game.querySelector('.zo-bp-board');
		const statusEl = game.querySelector('.zo-bp-status');
		const helperEl = game.querySelector('.zo-bp-helper');
		const mistakesEl = game.querySelector('.zo-bp-mistakes');
		const filledEl = game.querySelector('.zo-bp-filled');
		const winsEl = game.querySelector('.zo-bp-wins');
		const levelEl = game.querySelector('.zo-bp-level');
		const newBtn = game.querySelector('.zo-bp-new');
		const checkBtn = game.querySelector('.zo-bp-check');
		const clearBtn = game.querySelector('.zo-bp-clear');

		const solutions = [
			[
				[0,0,1,1,0,1],
				[1,1,0,0,1,0],
				[0,1,0,1,1,0],
				[1,0,1,0,0,1],
				[0,1,1,0,1,0],
				[1,0,0,1,0,1]
			],
			[
				[0,0,1,0,1,1],
				[1,1,0,1,0,0],
				[0,1,1,0,0,1],
				[1,0,0,1,1,0],
				[0,1,0,1,1,0],
				[1,0,1,0,0,1]
			],
			[
				[0,1,0,1,0,1],
				[1,0,1,0,1,0],
				[0,0,1,1,0,1],
				[1,1,0,0,1,0],
				[0,1,1,0,1,0],
				[1,0,0,1,0,1]
			]
		];

		const puzzleMasks = [
			[
				[1,0,0,1,0,1],
				[0,1,0,0,1,0],
				[0,0,1,0,0,0],
				[1,0,0,0,0,1],
				[0,0,1,0,1,0],
				[1,0,0,1,0,0]
			],
			[
				[1,0,1,0,0,1],
				[0,1,0,1,0,0],
				[0,0,1,0,0,1],
				[1,0,0,1,1,0],
				[0,1,0,0,1,0],
				[1,0,0,1,0,1]
			],
			[
				[0,1,0,1,0,0],
				[1,0,0,0,1,0],
				[0,0,1,0,0,1],
				[1,1,0,0,1,0],
				[0,0,1,0,1,0],
				[0,0,0,1,0,1]
			]
		];

		const state = {
			level: 1,
			wins: 0,
			mistakes: 0,
			solution: [],
			mask: [],
			board: []
		};

		function cloneGrid(grid) {
			return grid.map(function (row) {
				return row.slice();
			});
		}

		function createPuzzle(index) {
			state.solution = cloneGrid(solutions[index]);
			state.mask = cloneGrid(puzzleMasks[index]);
			state.board = cloneGrid(solutions[index]).map(function (row, rowIndex) {
				return row.map(function (value, colIndex) {
					return state.mask[rowIndex][colIndex] ? value : null;
				});
			});
		}

		function getCellClass(row, col) {
			let className = 'zo-bp-cell';

			if (state.mask[row][col]) {
				className += ' is-given';
			} else if (state.board[row][col] !== null) {
				className += ' is-player';
			}

			return className;
		}

		function countFilled() {
			let total = 0;

			state.board.forEach(function (row) {
				row.forEach(function (value) {
					if (value !== null) {
						total += 1;
					}
				});
			});

			return total;
		}

		function hasThreeInRow(values) {
			for (let i = 0; i <= values.length - 3; i++) {
				if (values[i] === null || values[i + 1] === null || values[i + 2] === null) {
					continue;
				}

				if (values[i] === values[i + 1] && values[i + 1] === values[i + 2]) {
					return true;
				}
			}

			return false;
		}

		function hasTooMany(values) {
			const zeros = values.filter(function (value) { return value === 0; }).length;
			const ones = values.filter(function (value) { return value === 1; }).length;

			return zeros > values.length / 2 || ones > values.length / 2;
		}

		function hasDuplicateFinishedLines(lines) {
			const finished = lines.filter(function (line) {
				return line.indexOf(null) === -1;
			}).map(function (line) {
				return line.join('');
			});

			return new Set(finished).size !== finished.length;
		}

		function getColumns() {
			const columns = [];

			for (let col = 0; col < size; col++) {
				const line = [];
				for (let row = 0; row < size; row++) {
					line.push(state.board[row][col]);
				}
				columns.push(line);
			}

			return columns;
		}

		function getRuleProblems() {
			const rows = state.board;
			const columns = getColumns();
			let problems = 0;

			rows.forEach(function (row) {
				if (hasThreeInRow(row) || hasTooMany(row)) {
					problems += 1;
				}
			});

			columns.forEach(function (column) {
				if (hasThreeInRow(column) || hasTooMany(column)) {
					problems += 1;
				}
			});

			if (hasDuplicateFinishedLines(rows)) {
				problems += 1;
			}

			if (hasDuplicateFinishedLines(columns)) {
				problems += 1;
			}

			return problems;
		}

		function updateStats() {
			filledEl.textContent = countFilled() + '/' + (size * size);
			mistakesEl.textContent = state.mistakes;
			winsEl.textContent = state.wins;
			levelEl.textContent = state.level;
		}

		function setStatus(message, type) {
			statusEl.className = 'zo-bp-status';
			if (type) {
				statusEl.classList.add(type);
			}
			statusEl.textContent = message;
		}

		function updateHelper() {
			const problems = getRuleProblems();

			if (problems === 0) {
				helperEl.textContent = 'Rule check: looking good so far.';
			} else if (problems === 1) {
				helperEl.textContent = 'Rule check: 1 row or column rule is currently broken.';
			} else {
				helperEl.textContent = 'Rule check: ' + problems + ' row or column rules are currently broken.';
			}
		}

		function renderBoard() {
			boardEl.innerHTML = '';
			boardEl.style.gridTemplateColumns = 'repeat(' + size + ', 1fr)';

			for (let row = 0; row < size; row++) {
				for (let col = 0; col < size; col++) {
					const button = document.createElement('button');
					button.type = 'button';
					button.className = getCellClass(row, col);
					button.textContent = state.board[row][col] === null ? '' : state.board[row][col];

					if (state.mask[row][col]) {
						button.disabled = true;
					} else {
						button.addEventListener('click', function () {
							const current = state.board[row][col];
							if (current === null) {
								state.board[row][col] = 0;
							} else if (current === 0) {
								state.board[row][col] = 1;
							} else {
								state.board[row][col] = null;
							}

							renderBoard();
							updateStats();
							updateHelper();
							setStatus('Keep going. Follow the binary rules and fill the full grid.', '');
						});
					}

					boardEl.appendChild(button);
				}
			}
		}

		function startLevel() {
			const puzzleIndex = (state.level - 1) % solutions.length;
			createPuzzle(puzzleIndex);
			renderBoard();
			updateStats();
			updateHelper();
			setStatus('Fill the empty squares with 0 or 1.', '');
		}

		checkBtn.addEventListener('click', function () {
			const filled = countFilled();
			const problems = getRuleProblems();

			if (filled < size * size) {
				state.mistakes += 1;
				updateStats();
				setStatus('The grid is not full yet. Fill every square first.', 'is-warn');
				return;
			}

			if (problems > 0) {
				state.mistakes += 1;
				updateStats();
				setStatus('Almost there. One or more row or column rules are broken.', 'is-warn');
				return;
			}

			let solved = true;
			for (let row = 0; row < size; row++) {
				for (let col = 0; col < size; col++) {
					if (state.board[row][col] !== state.solution[row][col]) {
						solved = false;
					}
				}
			}

			if (solved) {
				state.wins += 1;
				state.level += 1;
				updateStats();
				setStatus('You solved it. Great binary brain work!', 'is-good');

				window.setTimeout(function () {
					startLevel();
				}, 900);
			} else {
				state.mistakes += 1;
				updateStats();
				setStatus('The rules look okay, but a few squares are still wrong. Try again.', 'is-warn');
			}
		});

		clearBtn.addEventListener('click', function () {
			for (let row = 0; row < size; row++) {
				for (let col = 0; col < size; col++) {
					if (!state.mask[row][col]) {
						state.board[row][col] = null;
					}
				}
			}

			renderBoard();
			updateStats();
			updateHelper();
			setStatus('Player moves cleared. Try the puzzle again.', '');
		});

		newBtn.addEventListener('click', function () {
			state.level += 1;
			startLevel();
		});

		startLevel();
	});
});
JS;

if (!function_exists('zo_game_binary_puzzle_render')) {
	function zo_game_binary_puzzle_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-binary-puzzle-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--binary-puzzle" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-bp-card">
				<h2 class="zo-bp-title">Binary Puzzle</h2>
				<p class="zo-bp-subtitle">Fill the grid with <strong>0</strong> and <strong>1</strong>. No three same numbers in a row. Each row and column must have the same number of 0s and 1s. Full rows and columns cannot repeat.</p>

				<div class="zo-bp-stats">
					<div class="zo-bp-stat">
						<span class="zo-bp-stat-label">Level</span>
						<span class="zo-bp-stat-value zo-bp-level">1</span>
					</div>
					<div class="zo-bp-stat">
						<span class="zo-bp-stat-label">Filled</span>
						<span class="zo-bp-stat-value zo-bp-filled">0/36</span>
					</div>
					<div class="zo-bp-stat">
						<span class="zo-bp-stat-label">Failed Checks</span>
						<span class="zo-bp-stat-value zo-bp-mistakes">0</span>
					</div>
					<div class="zo-bp-stat">
						<span class="zo-bp-stat-label">Wins</span>
						<span class="zo-bp-stat-value zo-bp-wins">0</span>
					</div>
				</div>

				<div class="zo-bp-board-wrap">
					<div class="zo-bp-board"></div>
				</div>

				<div class="zo-bp-rules">
					<div class="zo-bp-rule">Rule 1: No row or column can have <strong>000</strong> or <strong>111</strong>.</div>
					<div class="zo-bp-rule">Rule 2: Each full row and column must have <strong>three 0s</strong> and <strong>three 1s</strong>, and no two full lines can match.</div>
				</div>

				<div class="zo-bp-actions">
					<button class="zo-bp-btn zo-bp-btn--new zo-bp-new" type="button">New Puzzle</button>
					<button class="zo-bp-btn zo-bp-btn--check zo-bp-check" type="button">Check Grid</button>
					<button class="zo-bp-btn zo-bp-btn--clear zo-bp-clear" type="button">Clear Moves</button>
				</div>

				<div class="zo-bp-status">Fill the empty squares with 0 or 1.</div>
				<div class="zo-bp-helper">Rule check: looking good so far.</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'binary-puzzle',
	'name'            => 'Binary Puzzle',
	'author'          => 'Asker',
	'description'     => 'Fill the grid with 0 and 1 using binary puzzle row and column rules.',
	'render_callback' => 'zo_game_binary_puzzle_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
