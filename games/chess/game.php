<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 900px;
	margin: 0 auto;
	text-align: center;
	font-family: Arial, sans-serif;
}

.zo-game-root--turkish-satranc .zo-ts-card {
	background: #ffffff;
	border: 3px solid #222;
	border-radius: 18px;
	padding: 20px;
	box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}

.zo-game-root--turkish-satranc .zo-ts-title {
	font-size: 28px;
	font-weight: 700;
	margin: 0 0 10px;
	color: #222;
}

.zo-game-root--turkish-satranc .zo-ts-subtitle {
	font-size: 16px;
	line-height: 1.5;
	margin: 0 0 16px;
	color: #444;
}

.zo-game-root--turkish-satranc .zo-ts-status {
	min-height: 28px;
	font-size: 18px;
	font-weight: 700;
	margin: 12px 0 16px;
	color: #0b5;
}

.zo-game-root--turkish-satranc .zo-ts-stats {
	display: flex;
	justify-content: center;
	gap: 12px;
	flex-wrap: wrap;
	margin-bottom: 16px;
}

.zo-game-root--turkish-satranc .zo-ts-stat {
	background: #f4f4f4;
	border: 2px solid #ddd;
	border-radius: 999px;
	padding: 8px 14px;
	font-size: 14px;
	font-weight: 700;
	color: #333;
}

.zo-game-root--turkish-satranc .zo-ts-board-wrap {
	display: flex;
	justify-content: center;
	margin: 0 auto 16px;
}

.zo-game-root--turkish-satranc .zo-ts-board {
	display: grid;
	grid-template-columns: repeat(8, 1fr);
	width: 100%;
	max-width: 640px;
	aspect-ratio: 1 / 1;
	border: 4px solid #222;
	border-radius: 12px;
	overflow: hidden;
}

.zo-game-root--turkish-satranc .zo-ts-square {
	position: relative;
	display: flex;
	align-items: center;
	justify-content: center;
	border: 0;
	padding: 0;
	margin: 0;
	font-size: 38px;
	font-weight: 700;
	cursor: pointer;
	user-select: none;
}

.zo-game-root--turkish-satranc .zo-ts-square--light {
	background: #f0d9b5;
}

.zo-game-root--turkish-satranc .zo-ts-square--dark {
	background: #b58863;
}

.zo-game-root--turkish-satranc .zo-ts-square.is-selected {
	box-shadow: inset 0 0 0 5px rgba(33, 150, 243, 0.9);
}

.zo-game-root--turkish-satranc .zo-ts-square.is-move {
	box-shadow: inset 0 0 0 5px rgba(76, 175, 80, 0.85);
}

.zo-game-root--turkish-satranc .zo-ts-square.is-capture {
	box-shadow: inset 0 0 0 5px rgba(244, 67, 54, 0.9);
}

.zo-game-root--turkish-satranc .zo-ts-square.is-check {
	box-shadow: inset 0 0 0 5px rgba(255, 193, 7, 0.95);
}

.zo-game-root--turkish-satranc .zo-ts-piece {
	line-height: 1;
	filter: drop-shadow(0 1px 1px rgba(0, 0, 0, 0.25));
}

.zo-game-root--turkish-satranc .zo-ts-actions {
	display: flex;
	justify-content: center;
	gap: 10px;
	flex-wrap: wrap;
	margin-top: 8px;
}

.zo-game-root--turkish-satranc .zo-ts-btn {
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

.zo-game-root--turkish-satranc .zo-ts-btn:hover,
.zo-game-root--turkish-satranc .zo-ts-btn:focus {
	background: #000;
	outline: none;
}

.zo-game-root--turkish-satranc .zo-ts-help {
	margin-top: 14px;
	font-size: 14px;
	color: #555;
	line-height: 1.55;
	text-align: left;
	max-width: 700px;
	margin-left: auto;
	margin-right: auto;
}

.zo-game-root--turkish-satranc .zo-ts-help strong {
	color: #222;
}

@media (max-width: 640px) {
	.zo-game-root--turkish-satranc .zo-ts-square {
		font-size: 30px;
	}
}

@media (max-width: 420px) {
	.zo-game-root--turkish-satranc .zo-ts-square {
		font-size: 24px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--turkish-satranc');

	games.forEach(function (game) {
		const boardEl = game.querySelector('.zo-ts-board');
		const statusEl = game.querySelector('.zo-ts-status');
		const turnEl = game.querySelector('.zo-ts-turn-value');
		const whiteEl = game.querySelector('.zo-ts-white-value');
		const blackEl = game.querySelector('.zo-ts-black-value');
		const resetBtn = game.querySelector('.zo-ts-reset');
		const flipBtn = game.querySelector('.zo-ts-flip');

		const files = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];
		const pieceIcons = {
			wk: '♔', wq: '♕', wr: '♖', wb: '♗', wn: '♘', wp: '♙',
			bk: '♚', bq: '♛', br: '♜', bb: '♝', bn: '♞', bp: '♟'
		};

		let state = null;
		let squareButtons = [];
		let flipped = false;

		function createInitialBoard() {
			return [
				['br', 'bn', 'bb', 'bq', 'bk', 'bb', 'bn', 'br'],
				['bp', 'bp', 'bp', 'bp', 'bp', 'bp', 'bp', 'bp'],
				[null, null, null, null, null, null, null, null],
				[null, null, null, null, null, null, null, null],
				[null, null, null, null, null, null, null, null],
				[null, null, null, null, null, null, null, null],
				['wp', 'wp', 'wp', 'wp', 'wp', 'wp', 'wp', 'wp'],
				['wr', 'wn', 'wb', 'wq', 'wk', 'wb', 'wn', 'wr']
			];
		}

		function createState() {
			return {
				board: createInitialBoard(),
				currentPlayer: 'w',
				selected: null,
				legalMoves: [],
				winner: null,
				status: 'White to move.',
				lastMove: null
			};
		}

		function inBounds(r, c) {
			return r >= 0 && r < 8 && c >= 0 && c < 8;
		}

		function cloneBoard(board) {
			return board.map(function (row) {
				return row.slice();
			});
		}

		function getPiece(board, r, c) {
			return inBounds(r, c) ? board[r][c] : null;
		}

		function getColor(piece) {
			return piece ? piece.charAt(0) : null;
		}

		function getType(piece) {
			return piece ? piece.charAt(1) : null;
		}

		function coordToName(r, c) {
			return files[c] + String(8 - r);
		}

		function squareMatches(move, r, c) {
			return move.to.r === r && move.to.c === c;
		}

		function makeMoveOnBoard(board, move) {
			const newBoard = cloneBoard(board);
			const piece = newBoard[move.from.r][move.from.c];
			newBoard[move.from.r][move.from.c] = null;
			newBoard[move.to.r][move.to.c] = piece;

			if (move.promotion) {
				newBoard[move.to.r][move.to.c] = piece.charAt(0) + move.promotion;
			}

			return newBoard;
		}

		function findKing(board, color) {
			for (let r = 0; r < 8; r++) {
				for (let c = 0; c < 8; c++) {
					if (board[r][c] === color + 'k') {
						return { r: r, c: c };
					}
				}
			}
			return null;
		}

		function isSquareAttacked(board, targetR, targetC, attackerColor) {
			for (let r = 0; r < 8; r++) {
				for (let c = 0; c < 8; c++) {
					const piece = board[r][c];
					if (!piece || getColor(piece) !== attackerColor) {
						continue;
					}
					const pseudoMoves = getPseudoMoves(board, r, c, true);
					for (let i = 0; i < pseudoMoves.length; i++) {
						if (pseudoMoves[i].to.r === targetR && pseudoMoves[i].to.c === targetC) {
							return true;
						}
					}
				}
			}
			return false;
		}

		function isInCheck(board, color) {
			const kingPos = findKing(board, color);
			if (!kingPos) {
				return true;
			}
			const enemy = color === 'w' ? 'b' : 'w';
			return isSquareAttacked(board, kingPos.r, kingPos.c, enemy);
		}

		function addSlidingMoves(board, r, c, color, directions, moves) {
			directions.forEach(function (dir) {
				let nr = r + dir[0];
				let nc = c + dir[1];

				while (inBounds(nr, nc)) {
					const target = board[nr][nc];
					if (!target) {
						moves.push({
							from: { r: r, c: c },
							to: { r: nr, c: nc },
							capture: false
						});
					} else {
						if (getColor(target) !== color) {
							moves.push({
								from: { r: r, c: c },
								to: { r: nr, c: nc },
								capture: true
							});
						}
						break;
					}
					nr += dir[0];
					nc += dir[1];
				}
			});
		}

		function getPseudoMoves(board, r, c, attackOnly) {
			const piece = board[r][c];
			if (!piece) {
				return [];
			}

			const color = getColor(piece);
			const type = getType(piece);
			const moves = [];

			if (type === 'p') {
				const dir = color === 'w' ? -1 : 1;
				const startRow = color === 'w' ? 6 : 1;
				const promotionRow = color === 'w' ? 0 : 7;

				if (!attackOnly) {
					const oneStepR = r + dir;
					if (inBounds(oneStepR, c) && !board[oneStepR][c]) {
						moves.push({
							from: { r: r, c: c },
							to: { r: oneStepR, c: c },
							capture: false,
							promotion: oneStepR === promotionRow ? 'q' : null
						});

						const twoStepR = r + dir + dir;
						if (r === startRow && inBounds(twoStepR, c) && !board[twoStepR][c]) {
							moves.push({
								from: { r: r, c: c },
								to: { r: twoStepR, c: c },
								capture: false
							});
						}
					}
				}

				[-1, 1].forEach(function (dc) {
					const nr = r + dir;
					const nc = c + dc;
					if (!inBounds(nr, nc)) {
						return;
					}

					if (attackOnly) {
						moves.push({
							from: { r: r, c: c },
							to: { r: nr, c: nc },
							capture: false
						});
						return;
					}

					const target = board[nr][nc];
					if (target && getColor(target) !== color) {
						moves.push({
							from: { r: r, c: c },
							to: { r: nr, c: nc },
							capture: true,
							promotion: nr === promotionRow ? 'q' : null
						});
					}
				});

				return moves;
			}

			if (type === 'r') {
				addSlidingMoves(board, r, c, color, [[1,0],[-1,0],[0,1],[0,-1]], moves);
				return moves;
			}

			if (type === 'b') {
				addSlidingMoves(board, r, c, color, [[1,1],[1,-1],[-1,1],[-1,-1]], moves);
				return moves;
			}

			if (type === 'q') {
				addSlidingMoves(board, r, c, color, [[1,0],[-1,0],[0,1],[0,-1],[1,1],[1,-1],[-1,1],[-1,-1]], moves);
				return moves;
			}

			if (type === 'n') {
				const jumps = [[-2,-1],[-2,1],[-1,-2],[-1,2],[1,-2],[1,2],[2,-1],[2,1]];
				jumps.forEach(function (jump) {
					const nr = r + jump[0];
					const nc = c + jump[1];
					if (!inBounds(nr, nc)) {
						return;
					}
					const target = board[nr][nc];
					if (!target || getColor(target) !== color) {
						moves.push({
							from: { r: r, c: c },
							to: { r: nr, c: nc },
							capture: !!target
						});
					}
				});
				return moves;
			}

			if (type === 'k') {
				for (let dr = -1; dr <= 1; dr++) {
					for (let dc = -1; dc <= 1; dc++) {
						if (dr === 0 && dc === 0) {
							continue;
						}
						const nr = r + dr;
						const nc = c + dc;
						if (!inBounds(nr, nc)) {
							continue;
						}
						const target = board[nr][nc];
						if (!target || getColor(target) !== color) {
							moves.push({
								from: { r: r, c: c },
								to: { r: nr, c: nc },
								capture: !!target
							});
						}
					}
				}
				return moves;
			}

			return moves;
		}

		function getLegalMovesForPiece(board, r, c, color) {
			const pseudoMoves = getPseudoMoves(board, r, c, false);
			return pseudoMoves.filter(function (move) {
				const newBoard = makeMoveOnBoard(board, move);
				return !isInCheck(newBoard, color);
			});
		}

		function getAllLegalMoves(board, color) {
			let result = [];
			for (let r = 0; r < 8; r++) {
				for (let c = 0; c < 8; c++) {
					const piece = board[r][c];
					if (piece && getColor(piece) === color) {
						result = result.concat(getLegalMovesForPiece(board, r, c, color));
					}
				}
			}
			return result;
		}

		function countPieces(board, color) {
			let total = 0;
			for (let r = 0; r < 8; r++) {
				for (let c = 0; c < 8; c++) {
					if (board[r][c] && getColor(board[r][c]) === color) {
						total += 1;
					}
				}
			}
			return total;
		}

		function getDisplayedCoords(index) {
			const row = Math.floor(index / 8);
			const col = index % 8;
			if (flipped) {
				return { r: 7 - row, c: 7 - col };
			}
			return { r: row, c: col };
		}

		function buildBoard() {
			boardEl.innerHTML = '';
			squareButtons = [];

			for (let i = 0; i < 64; i++) {
				const coords = getDisplayedCoords(i);
				const square = document.createElement('button');
				square.type = 'button';
				square.className = 'zo-ts-square ' + (((coords.r + coords.c) % 2 === 0) ? 'zo-ts-square--light' : 'zo-ts-square--dark');
				square.dataset.r = String(coords.r);
				square.dataset.c = String(coords.c);
				square.setAttribute('aria-label', coordToName(coords.r, coords.c));

				square.addEventListener('click', function () {
					handleSquareClick(coords.r, coords.c);
				});

				boardEl.appendChild(square);
				squareButtons.push(square);
			}
		}

		function renderBoard() {
			squareButtons.forEach(function (square, index) {
				const coords = getDisplayedCoords(index);
				const r = coords.r;
				const c = coords.c;
				const piece = state.board[r][c];
				const squareMoves = state.legalMoves.filter(function (move) {
					return squareMatches(move, r, c);
				});

				square.innerHTML = '';
				square.classList.remove('is-selected', 'is-move', 'is-capture', 'is-check');

				if (state.selected && state.selected.r === r && state.selected.c === c) {
					square.classList.add('is-selected');
				}

				if (squareMoves.length) {
					const isCapture = squareMoves.some(function (move) { return move.capture; });
					square.classList.add(isCapture ? 'is-capture' : 'is-move');
				}

				const wk = findKing(state.board, 'w');
				const bk = findKing(state.board, 'b');
				if (wk && isInCheck(state.board, 'w') && wk.r === r && wk.c === c) {
					square.classList.add('is-check');
				}
				if (bk && isInCheck(state.board, 'b') && bk.r === r && bk.c === c) {
					square.classList.add('is-check');
				}

				if (piece) {
					const span = document.createElement('span');
					span.className = 'zo-ts-piece';
					span.textContent = pieceIcons[piece];
					square.appendChild(span);
				}
			});

			turnEl.textContent = state.currentPlayer === 'w' ? 'White' : 'Black';
			whiteEl.textContent = String(countPieces(state.board, 'w'));
			blackEl.textContent = String(countPieces(state.board, 'b'));
			statusEl.textContent = state.status;
		}

		function updateGameStateAfterMove(move) {
			state.board = makeMoveOnBoard(state.board, move);
			state.lastMove = move;
			state.selected = null;
			state.legalMoves = [];

			const nextPlayer = state.currentPlayer === 'w' ? 'b' : 'w';
			const enemyMoves = getAllLegalMoves(state.board, nextPlayer);
			const enemyInCheck = isInCheck(state.board, nextPlayer);

			if (enemyMoves.length === 0) {
				state.winner = state.currentPlayer;
				if (enemyInCheck) {
					state.status = (state.currentPlayer === 'w' ? 'White' : 'Black') + ' wins by checkmate.';
				} else {
					state.status = 'Stalemate.';
				}
				return;
			}

			state.currentPlayer = nextPlayer;
			if (enemyInCheck) {
				state.status = (state.currentPlayer === 'w' ? 'White' : 'Black') + ' is in check.';
			} else {
				state.status = (state.currentPlayer === 'w' ? 'White' : 'Black') + ' to move.';
			}
		}

		function handleSquareClick(r, c) {
			if (state.winner) {
				return;
			}

			const piece = getPiece(state.board, r, c);

			if (state.selected) {
				const chosenMove = state.legalMoves.find(function (move) {
					return move.to.r === r && move.to.c === c;
				});

				if (chosenMove) {
					updateGameStateAfterMove(chosenMove);
					renderBoard();
					return;
				}
			}

			if (piece && getColor(piece) === state.currentPlayer) {
				state.selected = { r: r, c: c };
				state.legalMoves = getLegalMovesForPiece(state.board, r, c, state.currentPlayer);

				if (state.legalMoves.length) {
					state.status = coordToName(r, c) + ' selected.';
				} else {
					state.status = 'That piece has no legal move.';
				}
				renderBoard();
				return;
			}

			state.selected = null;
			state.legalMoves = [];
			renderBoard();
		}

		function resetGame() {
			state = createState();
			buildBoard();
			renderBoard();
		}

		resetBtn.addEventListener('click', function () {
			resetGame();
		});

		flipBtn.addEventListener('click', function () {
			flipped = !flipped;
			buildBoard();
			renderBoard();
		});

		resetGame();
	});
});
JS;

if (!function_exists('zo_game_turkish_satranc_render')) {
	function zo_game_turkish_satranc_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-turkish-satranc-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--turkish-satranc" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-ts-card">
				<h2 class="zo-ts-title">Türkçe Satranç</h2>
				<p class="zo-ts-subtitle">A simple two-player chess game in the browser. Select a piece, then tap a highlighted square to move. Check and checkmate are supported. Pawns promote to queen automatically.</p>

				<div class="zo-ts-stats">
					<div class="zo-ts-stat">Turn: <span class="zo-ts-turn-value">White</span></div>
					<div class="zo-ts-stat">White Pieces: <span class="zo-ts-white-value">16</span></div>
					<div class="zo-ts-stat">Black Pieces: <span class="zo-ts-black-value">16</span></div>
				</div>

				<div class="zo-ts-status" aria-live="polite">White to move.</div>

				<div class="zo-ts-board-wrap">
					<div class="zo-ts-board"></div>
				</div>

				<div class="zo-ts-actions">
					<button type="button" class="zo-ts-btn zo-ts-reset">Restart</button>
					<button type="button" class="zo-ts-btn zo-ts-flip">Flip Board</button>
				</div>

				<div class="zo-ts-help">
					<strong>Rules in this version:</strong> Standard piece movement, captures, check, checkmate, and automatic queen promotion are included. Castling, en passant, draw by repetition, and draw by the fifty-move rule are not included in this simple version.
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'turkish-satranc',
	'name'            => 'Türkçe Satranç',
	'author'          => 'Arslan',
	'description'     => 'A simple browser-based chess game for two players.',
	'render_callback' => 'zo_game_turkish_satranc_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);