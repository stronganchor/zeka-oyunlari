<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 600px;
	margin: 0 auto;
	text-align: center;
	font-family: Arial, sans-serif;
}

.game-setup {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap: 12px;
	margin: 20px 0;
}

.game-setup select,
.game-setup button {
	padding: 8px 12px;
	font-size: 14px;
	border: 1px solid #ccc;
	border-radius: 4px;
}

.game-setup button {
	background-color: #2196F3;
	color: white;
	cursor: pointer;
}

.game-setup button:hover {
	background-color: #1976d2;
}

.territory-board {
	display: grid;
	grid-template-columns: repeat(6, 1fr);
	gap: 3px;
	margin: 22px auto;
	width: min(360px, 100%);
	aspect-ratio: 1;
	transition: all 0.3s ease;
}

.territory-board.board-8 {
	grid-template-columns: repeat(8, 1fr);
	width: min(480px, 100%);
}

.territory-cell {
	width: 100%;
	height: 100%;
	border: 1px solid #444;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 13px;
	font-weight: 700;
	cursor: default;
	transition: transform 0.2s, box-shadow 0.2s, background-color 0.2s;
	animation: none;
}

.territory-cell.valid {
	cursor: pointer;
	box-shadow: inset 0 0 0 2px rgba(255, 255, 255, 0.8);
}

.territory-cell.valid:hover {
	transform: scale(1.04);
}

.territory-cell.claimed {
	animation: claimPulse 0.5s ease-out;
}

@keyframes claimPulse {
	0% { transform: scale(1); }
	50% { transform: scale(1.1); }
	100% { transform: scale(1); }
}

.territory-cell.neutral {
	background-color: #d2d2d2;
	color: #333;
}

.territory-cell.player {
	background-color: #4CAF50;
	color: white;
}

.territory-cell.ai {
	background-color: #f44336;
	color: white;
}

.game-info {
	display: grid;
	gap: 12px;
	margin: 18px 0;
	text-align: left;
}

.info-row {
	display: flex;
	justify-content: space-between;
	flex-wrap: wrap;
	gap: 10px;
}

.info-row div {
	flex: 1 1 120px;
}

.message {
	min-height: 22px;
	font-weight: 700;
}

.legend {
	display: flex;
	justify-content: center;
	flex-wrap: wrap;
	gap: 14px;
	font-size: 13px;
}

.legend span {
	display: inline-flex;
	align-items: center;
	gap: 6px;
}

.legend-dot {
	width: 12px;
	height: 12px;
	display: inline-block;
	border-radius: 50%;
}

.legend-dot.player {
	background: #4CAF50;
}

.legend-dot.ai {
	background: #f44336;
}

.legend-dot.neutral {
	background: #ccc;
}

.controls {
	display: flex;
	justify-content: center;
	flex-wrap: wrap;
	gap: 12px;
}

button {
	padding: 10px 18px;
	border: none;
	border-radius: 4px;
	font-size: 14px;
	cursor: pointer;
}

.special-btn,
.restart-btn {
	background-color: #2196F3;
	color: white;
}

.special-btn.disabled,
.special-btn:disabled,
.restart-btn:disabled {
	opacity: 0.65;
	cursor: default;
}

.special-btn:hover:not(:disabled),
.restart-btn:hover:not(:disabled) {
	background-color: #1976d2;
}

@media (max-width: 500px) {
	.info-row {
		flex-direction: column;
		align-items: stretch;
	}
	.game-setup {
		flex-direction: column;
		align-items: center;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root');

	games.forEach(function (game) {
		if (!game.classList.contains('zo-game-root--territory-capture')) {
			return;
		}

		let board = [];
		let boardSize = 6;
		let difficulty = 'medium';
		let currentPlayer = 'player';
		let gameOver = false;
		let playerSpecialUsed = false;
		let aiSpecialUsed = false;

		const boardElement = game.querySelector('.territory-board');
		const turnElement = game.querySelector('.turn-info');
		const scoreElement = game.querySelector('.score-info');
		const messageElement = game.querySelector('.message');
		const specialInfo = game.querySelector('.special-info');
		const specialBtn = game.querySelector('.special-btn');
		const restartBtn = game.querySelector('.restart-btn');
		const difficultySelect = game.querySelector('.difficulty-select');
		const sizeSelect = game.querySelector('.size-select');
		const startBtn = game.querySelector('.start-btn');

		const directions = [
			[-1, 0],
			[1, 0],
			[0, -1],
			[0, 1],
		];

		function initBoard() {
			board = [];
			for (let i = 0; i < boardSize; i++) {
				board[i] = [];
				for (let j = 0; j < boardSize; j++) {
					board[i][j] = 'neutral';
				}
			}

			// Starting positions
			const startPos = boardSize - 1;
			board[0][0] = 'player';
			board[0][1] = 'player';
			board[startPos][startPos] = 'ai';
			board[startPos][startPos - 1] = 'ai';

			currentPlayer = 'player';
			gameOver = false;
			playerSpecialUsed = false;
			aiSpecialUsed = false;
			specialBtn.classList.remove('disabled');
			specialBtn.disabled = false;
			specialBtn.textContent = 'Use Reinforce';
			messageElement.textContent = 'Choose a cell to expand or attack.';

			boardElement.className = 'territory-board' + (boardSize === 8 ? ' board-8' : '');
			boardElement.style.gridTemplateColumns = `repeat(${boardSize}, 1fr)`;

			renderBoard();
			updateInfo();
		}

		function renderBoard() {
			boardElement.innerHTML = '';
			const validMoves = getValidCells(currentPlayer);

			for (let i = 0; i < boardSize; i++) {
				for (let j = 0; j < boardSize; j++) {
					const cell = document.createElement('div');
					cell.className = 'territory-cell ' + board[i][j];
					if (!gameOver && currentPlayer === 'player' && isCellInList(validMoves, i, j)) {
						cell.classList.add('valid');
					}
					cell.dataset.row = i;
					cell.dataset.col = j;
					cell.addEventListener('click', handleCellClick);
					boardElement.appendChild(cell);
				}
			}
		}

		function isCellInList(list, row, col) {
			return list.some(function (item) {
				return item[0] === row && item[1] === col;
			});
		}

		function getValidCells(owner) {
			const valid = [];
			for (let i = 0; i < boardSize; i++) {
				for (let j = 0; j < boardSize; j++) {
					if (board[i][j] !== owner && isValidMove(i, j, owner)) {
						valid.push([i, j]);
					}
				}
			}
			return valid;
		}

		function handleCellClick(event) {
			if (gameOver || currentPlayer !== 'player') {
				return;
			}

			const row = parseInt(event.currentTarget.dataset.row, 10);
			const col = parseInt(event.currentTarget.dataset.col, 10);

			if (!isValidMove(row, col, 'player')) {
				return;
			}

			makeMove(row, col, 'player');
			checkGameOver();

			if (!gameOver) {
				currentPlayer = 'ai';
				updateInfo();
				setTimeout(aiMove, 800);
			}
		}

		function isValidMove(row, col, owner) {
			if (board[row][col] === owner) {
				return false;
			}
			for (let dir of directions) {
				const nr = row + dir[0];
				const nc = col + dir[1];
				if (nr >= 0 && nr < boardSize && nc >= 0 && nc < boardSize && board[nr][nc] === owner) {
					return true;
				}
			}
			return false;
		}

		function makeMove(row, col, actor) {
			const target = board[row][col];
			let success = false;
			let action = 'expanded';

			if (target === 'neutral') {
				board[row][col] = actor;
				success = true;
			} else {
				action = 'attacked';
				let successRate = actor === 'player' ? 0.7 : (difficulty === 'easy' ? 0.4 : difficulty === 'hard' ? 0.8 : 0.6);
				success = Math.random() < successRate;
				if (success) {
					board[row][col] = actor;
				}
			}

			// Add animation class
			setTimeout(function() {
				const cell = boardElement.querySelector(`[data-row="${row}"][data-col="${col}"]`);
				if (cell) {
					cell.classList.add('claimed');
					setTimeout(function() { cell.classList.remove('claimed'); }, 500);
				}
			}, 10);

			renderBoard();
			updateInfo();

			if (actor === 'player') {
				if (success) {
					messageElement.textContent = action === 'expanded' ? 'You claimed a new border cell.' : 'Attack success! You captured enemy territory.';
				} else {
					messageElement.textContent = 'Attack failed. The enemy held strong.';
				}
			} else {
				if (success) {
					messageElement.textContent = 'AI captured territory this turn.';
				} else {
					messageElement.textContent = 'AI attack failed. Your border remains intact.';
				}
			}
		}

		function getAllNeutralAdjacentTo(owner) {
			const cells = [];
			for (let i = 0; i < boardSize; i++) {
				for (let j = 0; j < boardSize; j++) {
					if (board[i][j] !== 'neutral') {
						continue;
					}
					if (isValidMove(i, j, owner)) {
						cells.push([i, j]);
					}
				}
			}
			return cells;
		}

		function aiMove() {
			const reinforceTargets = getAllNeutralAdjacentTo('ai');
			const reinforceChance = difficulty === 'easy' ? 0.1 : difficulty === 'hard' ? 0.4 : 0.25;
			if (!aiSpecialUsed && reinforceTargets.length > 0 && Math.random() < reinforceChance) {
				const choice = reinforceTargets[Math.floor(Math.random() * reinforceTargets.length)];
				board[choice[0]][choice[1]] = 'ai';
				aiSpecialUsed = true;
				messageElement.textContent = 'AI used reinforce and claimed a neutral border cell.';
				renderBoard();
				updateInfo();
				checkGameOver();
				if (!gameOver) {
					currentPlayer = 'player';
				}
				return;
			}

			const possibleMoves = getValidCells('ai');
			if (possibleMoves.length === 0) {
				checkGameOver();
				return;
			}

			let bestMove = possibleMoves[0];
			let bestScore = -Infinity;
			possibleMoves.forEach(function (move) {
				const row = move[0];
				const col = move[1];
				let score = board[row][col] === 'neutral' ? 1 : 2;
				score += countAdjacentOwner(row, col, 'ai') * 0.3;
				score += countAdjacentOwner(row, col, 'player') * 0.4;
				if (score > bestScore || (score === bestScore && Math.random() < 0.5)) {
					bestScore = score;
					bestMove = move;
				}
			});

			makeMove(bestMove[0], bestMove[1], 'ai');
			checkGameOver();
			if (!gameOver) {
				currentPlayer = 'player';
			}
		}

		function countAdjacentOwner(row, col, owner) {
			let count = 0;
			for (let dir of directions) {
				const nr = row + dir[0];
				const nc = col + dir[1];
				if (nr >= 0 && nr < boardSize && nc >= 0 && nc < boardSize && board[nr][nc] === owner) {
					count++;
				}
			}
			return count;
		}

		function updateInfo() {
			let playerCount = 0;
			let aiCount = 0;
			for (let i = 0; i < boardSize; i++) {
				for (let j = 0; j < boardSize; j++) {
					if (board[i][j] === 'player') {
						playerCount++;
					} else if (board[i][j] === 'ai') {
						aiCount++;
					}
				}
			}

			turnElement.textContent = gameOver ? 'Game over' : currentPlayer === 'player' ? 'Your turn' : 'AI turn';
			scoreElement.textContent = `You: ${playerCount} | AI: ${aiCount}`;
			specialInfo.textContent = playerSpecialUsed ? 'Reinforce used' : 'Reinforce available';
			specialBtn.disabled = gameOver || playerSpecialUsed;
			if (playerSpecialUsed) {
				specialBtn.classList.add('disabled');
			} else {
				specialBtn.classList.remove('disabled');
			}
		}

		function checkGameOver() {
			const playerMoves = getValidCells('player').length;
			const aiMoves = getValidCells('ai').length;
			const playerCanReinforce = !playerSpecialUsed && getAllNeutralAdjacentTo('player').length > 0;
			const aiCanReinforce = !aiSpecialUsed && getAllNeutralAdjacentTo('ai').length > 0;
			const playerCanPlay = playerMoves > 0 || playerCanReinforce;
			const aiCanPlay = aiMoves > 0 || aiCanReinforce;
			const neutralCount = board.flat().filter(function (cell) {
				return cell === 'neutral';
			}).length;

			if (!playerCanPlay && aiCanPlay && currentPlayer === 'player') {
				currentPlayer = 'ai';
				messageElement.textContent = 'No player moves left. AI continues.';
				updateInfo();
				setTimeout(aiMove, 800);
				return;
			}

			if (!aiCanPlay && playerCanPlay && currentPlayer === 'ai') {
				currentPlayer = 'player';
				messageElement.textContent = 'AI cannot move. Your turn.';
				updateInfo();
				return;
			}

			if (neutralCount === 0 || (!playerCanPlay && !aiCanPlay)) {
				gameOver = true;
				let playerCount = 0;
				let aiCount = 0;
				for (let i = 0; i < boardSize; i++) {
					for (let j = 0; j < boardSize; j++) {
						if (board[i][j] === 'player') {
							playerCount++;
						} else if (board[i][j] === 'ai') {
							aiCount++;
						}
					}
				}

				if (playerCount > aiCount) {
					messageElement.textContent = 'You win! Great territory control.';
				} else if (aiCount > playerCount) {
					messageElement.textContent = 'AI wins! Try a different strategy.';
				} else {
					messageElement.textContent = 'It\'s a tie! A balanced battle.';
				}
			}
		}

		specialBtn.addEventListener('click', function () {
			if (gameOver || currentPlayer !== 'player' || playerSpecialUsed) {
				return;
			}

			const reinforceCells = getAllNeutralAdjacentTo('player');
			if (reinforceCells.length === 0) {
				messageElement.textContent = 'No neutral border cell available to reinforce.';
				return;
			}

			const choice = reinforceCells[Math.floor(Math.random() * reinforceCells.length)];
			board[choice[0]][choice[1]] = 'player';
			playerSpecialUsed = true;
			specialBtn.classList.add('disabled');
			specialBtn.disabled = true;
			messageElement.textContent = 'Reinforce used! You claimed a border space.';
			renderBoard();
			updateInfo();
			checkGameOver();

			if (!gameOver) {
				currentPlayer = 'ai';
				updateInfo();
				setTimeout(aiMove, 800);
			}
		});

		startBtn.addEventListener('click', function () {
			difficulty = difficultySelect.value;
			boardSize = parseInt(sizeSelect.value, 10);
			initBoard();
		});

		restartBtn.addEventListener('click', function () {
			initBoard();
		});

		// Initial setup
		boardSize = parseInt(sizeSelect.value, 10);
		difficulty = difficultySelect.value;
		initBoard();
	});
});
JS;

if (!function_exists('zo_game_territory_capture_render')) {
	function zo_game_territory_capture_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-territory-capture-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--territory-capture" id="<?php echo esc_attr($instance_id); ?>">
			<h2>Territory Capture</h2>
			<div class="game-setup">
				<label>Board Size: <select class="size-select">
					<option value="6">6x6</option>
					<option value="8">8x8</option>
				</select></label>
				<label>Difficulty: <select class="difficulty-select">
					<option value="easy">Easy</option>
					<option value="medium">Medium</option>
					<option value="hard">Hard</option>
				</select></label>
				<button class="start-btn">Start New Game</button>
			</div>
			<p>Click on cells adjacent to your green territory to expand. Attack red cells to try to capture them!</p>
			<div class="game-info">
				<div class="info-row">
					<div class="turn-info">Your turn</div>
					<div class="score-info">You: 1 | AI: 1</div>
				</div>
				<div class="message">Choose a cell to expand or attack.</div>
				<div class="legend">
					<span><span class="legend-dot player"></span>You</span>
					<span><span class="legend-dot ai"></span>AI</span>
					<span><span class="legend-dot neutral"></span>Neutral</span>
				</div>
				<div class="special-info">Reinforce available</div>
			</div>
			<div class="territory-board"></div>
			<div class="controls">
				<button class="special-btn">Use Reinforce</button>
				<button class="restart-btn">Restart Game</button>
		</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'territory-capture',
	'name'            => 'Territory Capture',
	'author'          => 'Asker',
	'description'     => 'A turn-based strategy game where you compete with AI to control the most territory on a grid. Choose difficulty and board size, expand your territory, and use special reinforce actions.',
	'render_callback' => 'zo_game_territory_capture_render',
	'inline_style'    => $css,
	'inline_script'    => $js,
);
