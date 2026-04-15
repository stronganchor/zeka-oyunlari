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

.territory-board {
	display: grid;
	grid-template-columns: repeat(6, 1fr);
	gap: 2px;
	margin: 20px auto;
	width: 300px;
	height: 300px;
}

.territory-cell {
	width: 100%;
	height: 100%;
	border: 1px solid #000;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 12px;
	cursor: pointer;
	transition: background-color 0.3s;
}

.territory-cell.neutral {
	background-color: #ccc;
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
	margin: 20px 0;
}

.restart-btn {
	padding: 10px 20px;
	background-color: #2196F3;
	color: white;
	border: none;
	cursor: pointer;
	font-size: 16px;
}

.restart-btn:hover {
	background-color: #0b7dda;
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
		let currentPlayer = 'player';
		let gameOver = false;
		const boardElement = game.querySelector('.territory-board');
		const turnElement = game.querySelector('.turn-info');
		const scoreElement = game.querySelector('.score-info');
		const messageElement = game.querySelector('.message');
		const restartBtn = game.querySelector('.restart-btn');

		function initBoard() {
			board = [];
			for (let i = 0; i < 6; i++) {
				board[i] = [];
				for (let j = 0; j < 6; j++) {
					board[i][j] = 'neutral';
				}
			}
			// Player starts at top-left
			board[0][0] = 'player';
			// AI starts at bottom-right
			board[5][5] = 'ai';
			renderBoard();
			updateInfo();
		}

		function renderBoard() {
			boardElement.innerHTML = '';
			for (let i = 0; i < 6; i++) {
				for (let j = 0; j < 6; j++) {
					const cell = document.createElement('div');
					cell.className = 'territory-cell ' + board[i][j];
					cell.dataset.row = i;
					cell.dataset.col = j;
					cell.addEventListener('click', handleCellClick);
					boardElement.appendChild(cell);
				}
			}
		}

		function handleCellClick(e) {
			if (gameOver || currentPlayer !== 'player') return;
			const row = parseInt(e.target.dataset.row);
			const col = parseInt(e.target.dataset.col);
			if (isValidMove(row, col)) {
				makeMove(row, col);
				checkGameOver();
				if (!gameOver) {
					currentPlayer = 'ai';
					setTimeout(aiMove, 1000);
				}
			}
		}

		function isValidMove(row, col) {
			if (board[row][col] === 'player') return false;
			const directions = [[-1,0],[1,0],[0,-1],[0,1]];
			for (let dir of directions) {
				const nr = row + dir[0];
				const nc = col + dir[1];
				if (nr >= 0 && nr < 6 && nc >= 0 && nc < 6 && board[nr][nc] === 'player') {
					return true;
				}
			}
			return false;
		}

		function makeMove(row, col) {
			const target = board[row][col];
			if (target === 'neutral') {
				board[row][col] = currentPlayer;
			} else if (target === 'ai' && currentPlayer === 'player') {
				// Attack: 70% chance to succeed
				if (Math.random() < 0.7) {
					board[row][col] = 'player';
				}
			} else if (target === 'player' && currentPlayer === 'ai') {
				// AI attack: 60% chance
				if (Math.random() < 0.6) {
					board[row][col] = 'ai';
				}
			}
			renderBoard();
			updateInfo();
		}

		function aiMove() {
			const possibleMoves = [];
			for (let i = 0; i < 6; i++) {
				for (let j = 0; j < 6; j++) {
					if (board[i][j] !== 'ai' && isValidMoveForAI(i, j)) {
						possibleMoves.push([i, j]);
					}
				}
			}
			if (possibleMoves.length > 0) {
				const move = possibleMoves[Math.floor(Math.random() * possibleMoves.length)];
				makeMove(move[0], move[1]);
				checkGameOver();
				if (!gameOver) {
					currentPlayer = 'player';
				}
			}
		}

		function isValidMoveForAI(row, col) {
			if (board[row][col] === 'ai') return false;
			const directions = [[-1,0],[1,0],[0,-1],[0,1]];
			for (let dir of directions) {
				const nr = row + dir[0];
				const nc = col + dir[1];
				if (nr >= 0 && nr < 6 && nc >= 0 && nc < 6 && board[nr][nc] === 'ai') {
					return true;
				}
			}
			return false;
		}

		function updateInfo() {
			let playerCount = 0;
			let aiCount = 0;
			for (let i = 0; i < 6; i++) {
				for (let j = 0; j < 6; j++) {
					if (board[i][j] === 'player') playerCount++;
					else if (board[i][j] === 'ai') aiCount++;
				}
			}
			turnElement.textContent = currentPlayer === 'player' ? 'Your turn' : 'AI turn';
			scoreElement.textContent = `You: ${playerCount} | AI: ${aiCount}`;
		}

		function checkGameOver() {
			let hasPlayerMove = false;
			let hasAIMove = false;
			for (let i = 0; i < 6; i++) {
				for (let j = 0; j < 6; j++) {
					if (board[i][j] !== 'player' && isValidMove(i, j)) {
						hasPlayerMove = true;
					}
					if (board[i][j] !== 'ai' && isValidMoveForAI(i, j)) {
						hasAIMove = true;
					}
				}
			}
			if (!hasPlayerMove || !hasAIMove) {
				gameOver = true;
				let playerCount = 0;
				let aiCount = 0;
				for (let i = 0; i < 6; i++) {
					for (let j = 0; j < 6; j++) {
						if (board[i][j] === 'player') playerCount++;
						else if (board[i][j] === 'ai') aiCount++;
					}
				}
				if (playerCount > aiCount) {
					messageElement.textContent = 'You win!';
				} else if (aiCount > playerCount) {
					messageElement.textContent = 'AI wins!';
				} else {
					messageElement.textContent = 'It\'s a tie!';
				}
			}
		}

		restartBtn.addEventListener('click', function() {
			gameOver = false;
			currentPlayer = 'player';
			initBoard();
			messageElement.textContent = '';
		});

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
			<p>Click on cells adjacent to your green territory to expand. Attack red cells to try to capture them!</p>
			<div class="game-info">
				<div class="turn-info">Your turn</div>
				<div class="score-info">You: 1 | AI: 1</div>
				<div class="message"></div>
			</div>
			<div class="territory-board"></div>
			<button class="restart-btn">Restart Game</button>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'territory-capture',
	'name'            => 'Territory Capture',
	'author'          => 'Copilot',
	'description'     => 'A turn-based strategy game where you compete with AI to control the most territory on a grid.',
	'render_callback' => 'zo_game_territory_capture_render',
	'inline_style'    => $css,
	'inline_script'    => $js,
);
