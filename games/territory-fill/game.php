<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 500px;
	margin: 0 auto;
	padding: 20px;
	font-family: Arial, sans-serif;
}

.zo-game-root--territory-fill {
	background: #f5f5f5;
	border-radius: 8px;
	padding: 20px;
}

.tf-header {
	text-align: center;
	margin-bottom: 20px;
}

.tf-header h2 {
	margin: 0 0 10px 0;
	color: #333;
	font-size: 24px;
}

.tf-stats {
	display: flex;
	justify-content: space-around;
	margin-bottom: 20px;
	gap: 10px;
	flex-wrap: wrap;
}

.tf-stat {
	background: white;
	padding: 10px 15px;
	border-radius: 6px;
	text-align: center;
	flex: 1;
	min-width: 100px;
}

.tf-stat-label {
	font-size: 12px;
	color: #666;
	margin-bottom: 5px;
}

.tf-stat-value {
	font-size: 20px;
	font-weight: bold;
}

.tf-stat-player .tf-stat-value {
	color: #4CAF50;
}

.tf-stat-ai .tf-stat-value {
	color: #f44336;
}

.tf-stat-moves .tf-stat-value {
	color: #2196F3;
}

.tf-grid {
	display: grid;
	grid-template-columns: repeat(5, 1fr);
	gap: 8px;
	margin-bottom: 20px;
	background: white;
	padding: 15px;
	border-radius: 6px;
}

.tf-cell {
	aspect-ratio: 1;
	border: 2px solid #ddd;
	border-radius: 4px;
	cursor: pointer;
	font-weight: bold;
	display: flex;
	align-items: center;
	justify-content: center;
	transition: all 0.2s ease;
	background: #fff;
	color: #999;
	font-size: 12px;
}

.tf-cell:hover:not(.tf-claimed) {
	background: #f0f0f0;
	border-color: #bbb;
}

.tf-cell.tf-claimed {
	cursor: default;
	color: white;
	font-weight: bold;
}

.tf-cell.tf-player {
	background: #4CAF50;
	border-color: #45a049;
}

.tf-cell.tf-ai {
	background: #f44336;
	border-color: #da190b;
}

.tf-message {
	text-align: center;
	min-height: 30px;
	margin-bottom: 15px;
	font-size: 16px;
	font-weight: bold;
	padding: 10px;
}

.tf-message.tf-info {
	color: #2196F3;
}

.tf-message.tf-win {
	color: #4CAF50;
}

.tf-message.tf-lose {
	color: #f44336;
}

.tf-actions {
	display: flex;
	gap: 10px;
	justify-content: center;
	flex-wrap: wrap;
}

.tf-btn {
	padding: 10px 20px;
	border: none;
	border-radius: 4px;
	font-size: 14px;
	font-weight: bold;
	cursor: pointer;
	transition: all 0.2s ease;
}

.tf-btn-primary {
	background: #4CAF50;
	color: white;
}

.tf-btn-primary:hover {
	background: #45a049;
}

.tf-btn-primary:disabled {
	background: #ccc;
	cursor: not-allowed;
}

.tf-btn-secondary {
	background: #2196F3;
	color: white;
}

.tf-btn-secondary:hover {
	background: #0b7dda;
}

.tf-instructions {
	background: #e3f2fd;
	border-left: 4px solid #2196F3;
	padding: 12px;
	margin-bottom: 15px;
	border-radius: 4px;
	font-size: 13px;
	color: #1565c0;
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--territory-fill');

	games.forEach(function (game) {
		initTerritoryFill(game);
	});

	function initTerritoryFill(container) {
		const GRID_SIZE = 5;
		const MAX_MOVES = 15;
		const NEUTRAL = 0;
		const PLAYER = 1;
		const AI = 2;

		let grid = [];
		let playerMoves = 0;
		let gameOver = false;
		let aiThinking = false;

		const gridEl = container.querySelector('.tf-grid');
		const statsPlayer = container.querySelector('.tf-stat-player .tf-stat-value');
		const statsAI = container.querySelector('.tf-stat-ai .tf-stat-value');
		const statsMoves = container.querySelector('.tf-stat-moves .tf-stat-value');
		const messageEl = container.querySelector('.tf-message');
		const restartBtn = container.querySelector('.tf-btn-secondary');

		function initGrid() {
			grid = [];
			for (let i = 0; i < GRID_SIZE; i++) {
				grid[i] = [];
				for (let j = 0; j < GRID_SIZE; j++) {
					grid[i][j] = NEUTRAL;
				}
			}
			playerMoves = 0;
			gameOver = false;
			aiThinking = false;
			renderGrid();
			updateStats();
			messageEl.textContent = 'Your turn! Click a cell to claim it.';
			messageEl.className = 'tf-message tf-info';
			restartBtn.disabled = false;
		}

		function renderGrid() {
			gridEl.innerHTML = '';
			for (let i = 0; i < GRID_SIZE; i++) {
				for (let j = 0; j < GRID_SIZE; j++) {
					const cell = document.createElement('div');
					cell.className = 'tf-cell';
					cell.dataset.row = i;
					cell.dataset.col = j;

					if (grid[i][j] === PLAYER) {
						cell.classList.add('tf-claimed', 'tf-player');
						cell.textContent = '✓';
					} else if (grid[i][j] === AI) {
						cell.classList.add('tf-claimed', 'tf-ai');
						cell.textContent = '✕';
					}

					if (!gameOver && grid[i][j] === NEUTRAL && !aiThinking) {
						cell.addEventListener('click', function () {
							playerMove(i, j);
						});
					}

					gridEl.appendChild(cell);
				}
			}
		}

		function playerMove(row, col) {
			if (gameOver || aiThinking || grid[row][col] !== NEUTRAL) return;

			grid[row][col] = PLAYER;
			playerMoves++;
			updateStats();
			renderGrid();

			if (playerMoves >= MAX_MOVES) {
				endGame();
				return;
			}

			messageEl.textContent = 'AI is thinking...';
			messageEl.className = 'tf-message tf-info';
			aiThinking = true;

			setTimeout(function () {
				aiMove();
				aiThinking = false;

				if (playerMoves >= MAX_MOVES) {
					endGame();
				} else {
					messageEl.textContent = 'Your turn!';
					renderGrid();
				}
			}, 500);
		}

		function aiMove() {
			const emptyCell = getRandomEmptyCell();
			if (emptyCell) {
				grid[emptyCell.row][emptyCell.col] = AI;
			}
		}

		function getRandomEmptyCell() {
			const empty = [];
			for (let i = 0; i < GRID_SIZE; i++) {
				for (let j = 0; j < GRID_SIZE; j++) {
					if (grid[i][j] === NEUTRAL) {
						empty.push({ row: i, col: j });
					}
				}
			}
			if (empty.length === 0) return null;
			return empty[Math.floor(Math.random() * empty.length)];
		}

		function updateStats() {
			const playerCount = countCells(PLAYER);
			const aiCount = countCells(AI);
			statsPlayer.textContent = playerCount;
			statsAI.textContent = aiCount;
			statsMoves.textContent = (MAX_MOVES - playerMoves) + ' / ' + MAX_MOVES;
		}

		function countCells(owner) {
			let count = 0;
			for (let i = 0; i < GRID_SIZE; i++) {
				for (let j = 0; j < GRID_SIZE; j++) {
					if (grid[i][j] === owner) count++;
				}
			}
			return count;
		}

		function endGame() {
			gameOver = true;
			const playerCount = countCells(PLAYER);
			const aiCount = countCells(AI);

			if (playerCount > aiCount) {
				messageEl.textContent = '🎉 You Win! You claimed more territory!';
				messageEl.className = 'tf-message tf-win';
			} else if (aiCount > playerCount) {
				messageEl.textContent = '😢 AI Wins! Better luck next time!';
				messageEl.className = 'tf-message tf-lose';
			} else {
				messageEl.textContent = "🤝 It's a Tie!";
				messageEl.className = 'tf-message tf-info';
			}

			updateStats();
			renderGrid();
		}

		restartBtn.addEventListener('click', initGrid);

		initGrid();
	}
});
JS;

if (!function_exists('zo_game_territory_fill_render')) {
	function zo_game_territory_fill_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-territory-fill-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--territory-fill" id="<?php echo esc_attr($instance_id); ?>">
			<div class="tf-header">
				<h2>Territory Fill</h2>
			</div>

			<div class="tf-instructions">
				Click cells to claim territory. You have 15 moves to claim more cells than the AI before the game ends!
			</div>

			<div class="tf-message tf-info"></div>

			<div class="tf-stats">
				<div class="tf-stat tf-stat-player">
					<div class="tf-stat-label">Your Territory</div>
					<div class="tf-stat-value">0</div>
				</div>
				<div class="tf-stat tf-stat-ai">
					<div class="tf-stat-label">AI Territory</div>
					<div class="tf-stat-value">0</div>
				</div>
				<div class="tf-stat tf-stat-moves">
					<div class="tf-stat-label">Moves Left</div>
					<div class="tf-stat-value">0 / 15</div>
				</div>
			</div>

			<div class="tf-grid"></div>

			<div class="tf-actions">
				<button class="tf-btn tf-btn-secondary">Play Again</button>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'territory-fill',
	'name'            => 'Territory Fill',
	'author'          => 'Asker',
	'description'     => 'Grid control game. Claim the most area before moves run out.',
	'render_callback' => 'zo_game_territory_fill_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
