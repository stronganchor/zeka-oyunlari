document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--dama-ai');

	games.forEach(function (game) {
		const BOARD_SIZE = 8;
		const WHITE = 1;
		const BLACK = 2;

		const boardEl = game.querySelector('[data-role="board"]');
		const turnEl = game.querySelector('[data-role="turn"]');
		const statusEl = game.querySelector('[data-role="status"]');
		const restartBtn = game.querySelector('[data-action="restart"]');

		let board = [];
		let currentPlayer = WHITE;
		let selected = null;
		let highlightedMoves = [];
		let aiTimeout = null;
		let gameOver = false;
		let aiChainSource = null;

		function createEmptyBoard() {
			return Array.from({ length: BOARD_SIZE }, function () {
				return Array.from({ length: BOARD_SIZE }, function () {
					return null;
				});
			});
		}

		function setupBoard() {
			board = createEmptyBoard();

			for (let r = 1; r <= 2; r++) {
				for (let c = 0; c < BOARD_SIZE; c++) {
					board[r][c] = { player: WHITE, king: false };
				}
			}

			for (let r = 5; r <= 6; r++) {
				for (let c = 0; c < BOARD_SIZE; c++) {
					board[r][c] = { player: BLACK, king: false };
				}
			}
		}

		function inBounds(r, c) {
			return r >= 0 && r < BOARD_SIZE && c >= 0 && c < BOARD_SIZE;
		}

		function getMoves(r, c) {
			const moves = [];
			const piece = board[r][c];

			if (!piece) {
				return moves;
			}

			const player = piece.player;
			const king = piece.king;
			const dirs = [
				[1, 0],
				[-1, 0],
				[0, 1],
				[0, -1]
			];

			if (!king) {
				dirs.forEach(function (dir) {
					const dr = dir[0];
					const dc = dir[1];

					if (dr === -1 && player === WHITE) {
						return;
					}
					if (dr === 1 && player === BLACK) {
						return;
					}

					const nr = r + dr;
					const nc = c + dc;

					if (inBounds(nr, nc) && board[nr][nc] === null) {
						moves.push({
							to: [nr, nc],
							capture: null
						});
					}

					const cr = r + dr;
					const cc = c + dc;
					const lr = r + (2 * dr);
					const lc = c + (2 * dc);

					if (
						inBounds(lr, lc) &&
						inBounds(cr, cc) &&
						board[cr][cc] &&
						board[cr][cc].player !== player &&
						board[lr][lc] === null
					) {
						moves.push({
							to: [lr, lc],
							capture: [cr, cc]
						});
					}
				});
			} else {
				dirs.forEach(function (dir) {
					const dr = dir[0];
					const dc = dir[1];
					let jumped = false;
					let captured = null;
					let nr = r + dr;
					let nc = c + dc;

					while (inBounds(nr, nc)) {
						const target = board[nr][nc];

						if (target === null) {
							if (!jumped) {
								moves.push({
									to: [nr, nc],
									capture: null
								});
							} else if (captured) {
								moves.push({
									to: [nr, nc],
									capture: [captured[0], captured[1]]
								});
							}
						} else {
							if (target.player === player || jumped) {
								break;
							}
							jumped = true;
							captured = [nr, nc];
						}

						nr += dr;
						nc += dc;
					}
				});
			}

			return moves;
		}

		function mustCapture(player) {
			for (let r = 0; r < BOARD_SIZE; r++) {
				for (let c = 0; c < BOARD_SIZE; c++) {
					const piece = board[r][c];
					if (piece && piece.player === player) {
						const hasCapture = getMoves(r, c).some(function (move) {
							return move.capture !== null;
						});
						if (hasCapture) {
							return true;
						}
					}
				}
			}
			return false;
		}

		function setTurnText() {
			turnEl.textContent = 'Turn: ' + (currentPlayer === WHITE ? 'White' : 'Black AI');
		}

		function setStatus(text) {
			statusEl.textContent = text;
		}

		function countPieces(player) {
			let count = 0;
			for (let r = 0; r < BOARD_SIZE; r++) {
				for (let c = 0; c < BOARD_SIZE; c++) {
					if (board[r][c] && board[r][c].player === player) {
						count++;
					}
				}
			}
			return count;
		}

		function hasAnyMove(player) {
			for (let r = 0; r < BOARD_SIZE; r++) {
				for (let c = 0; c < BOARD_SIZE; c++) {
					if (board[r][c] && board[r][c].player === player) {
						if (getMoves(r, c).length > 0) {
							return true;
						}
					}
				}
			}
			return false;
		}

		function finishGame(message) {
			gameOver = true;
			selected = null;
			highlightedMoves = [];
			aiChainSource = null;
			if (aiTimeout) {
				clearTimeout(aiTimeout);
				aiTimeout = null;
			}
			setStatus(message);
			renderBoard();
		}

		function checkWin() {
			const whiteCount = countPieces(WHITE);
			const blackCount = countPieces(BLACK);

			if (whiteCount === 0) {
				finishGame('Game Over. You lose.');
				return true;
			}

			if (blackCount === 0) {
				finishGame('Game Over. You win.');
				return true;
			}

			if (!hasAnyMove(WHITE)) {
				finishGame('Game Over. You lose. White has no moves.');
				return true;
			}

			if (!hasAnyMove(BLACK)) {
				finishGame('Game Over. You win. Black has no moves.');
				return true;
			}

			return false;
		}

		function switchPlayer() {
			currentPlayer = currentPlayer === WHITE ? BLACK : WHITE;
			setTurnText();
		}

		function clearSelection() {
			selected = null;
			highlightedMoves = [];
		}

		function moveKey(row, col) {
			return row + '-' + col;
		}

		function renderBoard() {
			boardEl.innerHTML = '';

			const moveLookup = new Map();
			highlightedMoves.forEach(function (move) {
				moveLookup.set(moveKey(move.to[0], move.to[1]), move);
			});

			for (let r = 0; r < BOARD_SIZE; r++) {
				for (let c = 0; c < BOARD_SIZE; c++) {
					const cell = document.createElement('button');
					cell.type = 'button';
					cell.className = 'zo-dama-ai__cell ' + (((r + c) % 2 === 0) ? 'zo-dama-ai__cell--light' : 'zo-dama-ai__cell--dark');
					cell.setAttribute('data-row', String(r));
					cell.setAttribute('data-col', String(c));
					cell.setAttribute('aria-label', 'Row ' + (r + 1) + ', Column ' + (c + 1));

					if (selected && selected[0] === r && selected[1] === c) {
						cell.classList.add('zo-dama-ai__cell--selected');
					}

					const move = moveLookup.get(moveKey(r, c));
					if (move) {
						cell.classList.add('zo-dama-ai__cell--move');
						if (move.capture) {
							cell.classList.add('zo-dama-ai__cell--capture');
						}
					}

					const piece = board[r][c];
					if (piece) {
						const pieceEl = document.createElement('div');
						pieceEl.className = 'zo-dama-ai__piece ' + (piece.player === WHITE ? 'zo-dama-ai__piece--white' : 'zo-dama-ai__piece--black');
						if (piece.king) {
							pieceEl.textContent = 'K';
						}
						cell.appendChild(pieceEl);
					}

					boardEl.appendChild(cell);
				}
			}
		}

		function selectPiece(row, col) {
			const piece = board[row][col];

			if (!piece || piece.player !== currentPlayer || currentPlayer !== WHITE || gameOver) {
				return;
			}

			const moves = getMoves(row, col);
			const forcedCapture = mustCapture(currentPlayer);

			if (forcedCapture) {
				const captureMoves = moves.filter(function (move) {
					return move.capture !== null;
				});

				if (captureMoves.length === 0) {
					setStatus('You must capture an opponent piece.');
					return;
				}

				selected = [row, col];
				highlightedMoves = captureMoves;
				setStatus('Capture is required. Choose an orange move.');
			} else {
				selected = [row, col];
				highlightedMoves = moves;
				setStatus(moves.length ? 'Choose a highlighted square.' : 'That piece has no moves.');
			}

			renderBoard();
		}

		function applyMove(fromRow, fromCol, move) {
			const toRow = move.to[0];
			const toCol = move.to[1];
			const piece = board[fromRow][fromCol];

			board[toRow][toCol] = piece;
			board[fromRow][fromCol] = null;

			let didCapture = false;

			if (move.capture) {
				const capRow = move.capture[0];
				const capCol = move.capture[1];
				board[capRow][capCol] = null;
				didCapture = true;
			}

			if (piece.player === WHITE && toRow === BOARD_SIZE - 1) {
				piece.king = true;
			}
			if (piece.player === BLACK && toRow === 0) {
				piece.king = true;
			}

			return {
				toRow: toRow,
				toCol: toCol,
				didCapture: didCapture
			};
		}

		function processHumanClick(row, col) {
			if (currentPlayer !== WHITE || gameOver) {
				return;
			}

			const clickedPiece = board[row][col];

			if (!selected) {
				selectPiece(row, col);
				return;
			}

			const selectedRow = selected[0];
			const selectedCol = selected[1];
			const chosenMove = highlightedMoves.find(function (move) {
				return move.to[0] === row && move.to[1] === col;
			});

			if (chosenMove) {
				const result = applyMove(selectedRow, selectedCol, chosenMove);

				if (result.didCapture) {
					const nextCaptures = getMoves(result.toRow, result.toCol).filter(function (move) {
						return move.capture !== null;
					});

					if (nextCaptures.length > 0) {
						selected = [result.toRow, result.toCol];
						highlightedMoves = nextCaptures;
						setStatus('Keep capturing with the same piece.');
						renderBoard();
						return;
					}
				}

				clearSelection();
				renderBoard();

				if (checkWin()) {
					return;
				}

				switchPlayer();
				setStatus('Black AI is thinking...');
				renderBoard();

				aiTimeout = window.setTimeout(function () {
					aiMove();
				}, 600);

				return;
			}

			if (clickedPiece && clickedPiece.player === WHITE) {
				selectPiece(row, col);
				return;
			}

			clearSelection();
			setStatus('Select one of your white pieces.');
			renderBoard();
		}

		function aiMove() {
			if (gameOver || currentPlayer !== BLACK) {
				return;
			}

			let sourceSquares = [];

			if (aiChainSource) {
				sourceSquares = [aiChainSource];
			} else {
				for (let r = 0; r < BOARD_SIZE; r++) {
					for (let c = 0; c < BOARD_SIZE; c++) {
						if (board[r][c] && board[r][c].player === BLACK) {
							sourceSquares.push([r, c]);
						}
					}
				}
			}

			const captureRequired = mustCapture(BLACK);
			const possibleMoves = [];

			sourceSquares.forEach(function (src) {
				const r = src[0];
				const c = src[1];
				const moves = getMoves(r, c);

				moves.forEach(function (move) {
					if (!captureRequired || move.capture) {
						possibleMoves.push({
							from: [r, c],
							move: move
						});
					}
				});
			});

			if (possibleMoves.length === 0) {
				finishGame('Game Over. You win. Black has no moves.');
				return;
			}

			const choice = possibleMoves[Math.floor(Math.random() * possibleMoves.length)];
			const fromRow = choice.from[0];
			const fromCol = choice.from[1];
			const result = applyMove(fromRow, fromCol, choice.move);

			renderBoard();

			if (checkWin()) {
				return;
			}

			if (result.didCapture) {
				const nextCaptures = getMoves(result.toRow, result.toCol).filter(function (move) {
					return move.capture !== null;
				});

				if (nextCaptures.length > 0) {
					aiChainSource = [result.toRow, result.toCol];
					setStatus('Black AI keeps capturing...');
					aiTimeout = window.setTimeout(function () {
						aiMove();
					}, 500);
					return;
				}
			}

			aiChainSource = null;
			switchPlayer();
			setStatus('Your turn. Select a white piece.');
			renderBoard();
		}

		function restartGame() {
			if (aiTimeout) {
				clearTimeout(aiTimeout);
				aiTimeout = null;
			}

			currentPlayer = WHITE;
			selected = null;
			highlightedMoves = [];
			gameOver = false;
			aiChainSource = null;
			setupBoard();
			setTurnText();
			setStatus('Select a white piece to begin.');
			renderBoard();
		}

		boardEl.addEventListener('click', function (event) {
			const cell = event.target.closest('.zo-dama-ai__cell');
			if (!cell || !boardEl.contains(cell)) {
				return;
			}

			const row = parseInt(cell.getAttribute('data-row'), 10);
			const col = parseInt(cell.getAttribute('data-col'), 10);

			if (Number.isNaN(row) || Number.isNaN(col)) {
				return;
			}

			processHumanClick(row, col);
		});

		restartBtn.addEventListener('click', function () {
			restartGame();
		});

		restartGame();
	});
});