<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--chess-ai {
	max-width: 980px;
	margin: 0 auto;
	font-family: Arial, sans-serif;
	color: #222;
}

.zo-game-root--chess-ai .zo-chess-wrap {
	display: grid;
	grid-template-columns: minmax(280px, 1fr) minmax(240px, 320px);
	gap: 20px;
	align-items: start;
}

.zo-game-root--chess-ai .zo-chess-board-wrap {
	width: 100%;
}

.zo-game-root--chess-ai .zo-chess-board {
	display: grid;
	grid-template-columns: repeat(8, 1fr);
	width: 100%;
	max-width: 640px;
	aspect-ratio: 1 / 1;
	border: 4px solid #222;
	border-radius: 14px;
	overflow: hidden;
	background: #222;
	box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
	touch-action: manipulation;
	user-select: none;
}

.zo-game-root--chess-ai .zo-chess-square {
	position: relative;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: clamp(26px, 5vw, 50px);
	cursor: pointer;
	transition: transform 0.08s ease, box-shadow 0.08s ease;
}

.zo-game-root--chess-ai .zo-chess-square:hover {
	transform: scale(0.98);
}

.zo-game-root--chess-ai .zo-chess-square--light {
	background: #f0d9b5;
}

.zo-game-root--chess-ai .zo-chess-square--dark {
	background: #b58863;
}

.zo-game-root--chess-ai .zo-chess-square.is-selected {
	box-shadow: inset 0 0 0 4px #2d6cdf;
}

.zo-game-root--chess-ai .zo-chess-square.is-last-move {
	box-shadow: inset 0 0 0 4px rgba(255, 215, 0, 0.55);
}

.zo-game-root--chess-ai .zo-chess-square.is-check {
	box-shadow: inset 0 0 0 4px rgba(220, 20, 60, 0.8);
}

.zo-game-root--chess-ai .zo-chess-square.is-legal::after {
	content: '';
	position: absolute;
	width: 22%;
	height: 22%;
	border-radius: 50%;
	background: rgba(20, 20, 20, 0.35);
}

.zo-game-root--chess-ai .zo-chess-square.is-capture::after {
	content: '';
	position: absolute;
	inset: 11%;
	border: 4px solid rgba(180, 0, 0, 0.65);
	border-radius: 50%;
}

.zo-game-root--chess-ai .zo-chess-square .zo-piece {
	line-height: 1;
	filter: drop-shadow(0 1px 1px rgba(0, 0, 0, 0.22));
}

.zo-game-root--chess-ai .zo-chess-square .zo-piece--white {
	color: #ffffff;
	text-shadow:
		0 0 1px #000,
		0 1px 0 #000,
		1px 0 0 #000,
		-1px 0 0 #000,
		0 -1px 0 #000;
}

.zo-game-root--chess-ai .zo-chess-square .zo-piece--black {
	color: #111111;
	text-shadow:
		0 1px 0 rgba(255,255,255,0.18);
}

.zo-game-root--chess-ai .zo-chess-square .zo-label {
	position: absolute;
	font-size: 10px;
	font-weight: 700;
	opacity: 0.75;
	pointer-events: none;
}

.zo-game-root--chess-ai .zo-chess-square .zo-label--file {
	right: 6px;
	bottom: 4px;
}

.zo-game-root--chess-ai .zo-chess-square .zo-label--rank {
	left: 6px;
	top: 4px;
}

.zo-game-root--chess-ai .zo-chess-panel {
	background: #fff;
	border: 1px solid #ddd;
	border-radius: 14px;
	padding: 16px;
	box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
}

.zo-game-root--chess-ai .zo-chess-title {
	margin: 0 0 8px;
	font-size: 28px;
	line-height: 1.2;
}

.zo-game-root--chess-ai .zo-chess-instructions {
	margin: 0 0 14px;
	font-size: 14px;
	line-height: 1.5;
	color: #444;
}

.zo-game-root--chess-ai .zo-chess-controls {
	display: grid;
	gap: 12px;
	margin-bottom: 14px;
}

.zo-game-root--chess-ai .zo-chess-field label {
	display: block;
	font-size: 13px;
	font-weight: 700;
	margin-bottom: 6px;
}

.zo-game-root--chess-ai .zo-chess-select,
.zo-game-root--chess-ai .zo-chess-button {
	width: 100%;
	min-height: 42px;
	border-radius: 10px;
	border: 1px solid #cfcfcf;
	font-size: 14px;
}

.zo-game-root--chess-ai .zo-chess-select {
	padding: 10px 12px;
	background: #fff;
}

.zo-game-root--chess-ai .zo-chess-button {
	padding: 10px 14px;
	background: #1f4fd1;
	color: #fff;
	font-weight: 700;
	cursor: pointer;
	border: 0;
}

.zo-game-root--chess-ai .zo-chess-button:hover {
	background: #173da5;
}

.zo-game-root--chess-ai .zo-chess-button--secondary {
	background: #444;
}

.zo-game-root--chess-ai .zo-chess-button--secondary:hover {
	background: #2c2c2c;
}

.zo-game-root--chess-ai .zo-chess-button-row {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 10px;
}

.zo-game-root--chess-ai .zo-chess-status,
.zo-game-root--chess-ai .zo-chess-turn,
.zo-game-root--chess-ai .zo-chess-ai-status {
	margin: 0 0 10px;
	padding: 10px 12px;
	border-radius: 10px;
	background: #f5f7fb;
	font-size: 14px;
	line-height: 1.4;
}

.zo-game-root--chess-ai .zo-chess-status {
	font-weight: 700;
}

.zo-game-root--chess-ai .zo-chess-moves {
	margin-top: 12px;
}

.zo-game-root--chess-ai .zo-chess-moves h3 {
	margin: 0 0 8px;
	font-size: 16px;
}

.zo-game-root--chess-ai .zo-chess-move-list {
	max-height: 280px;
	overflow-y: auto;
	border: 1px solid #e3e3e3;
	border-radius: 10px;
	background: #fafafa;
	padding: 10px;
	font-size: 13px;
	line-height: 1.5;
}

.zo-game-root--chess-ai .zo-chess-move-row {
	display: grid;
	grid-template-columns: 42px 1fr 1fr;
	gap: 8px;
	padding: 4px 0;
	border-bottom: 1px solid #ececec;
}

.zo-game-root--chess-ai .zo-chess-move-row:last-child {
	border-bottom: 0;
}

.zo-game-root--chess-ai .zo-chess-footer {
	margin-top: 12px;
	font-size: 12px;
	color: #666;
}

@media (max-width: 760px) {
	.zo-game-root--chess-ai .zo-chess-wrap {
		grid-template-columns: 1fr;
	}

	.zo-game-root--chess-ai .zo-chess-board {
		max-width: 100%;
	}

	.zo-game-root--chess-ai .zo-chess-title {
		font-size: 24px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--chess-ai');

	games.forEach(function (game) {
		const boardEl = game.querySelector('.zo-chess-board');
		const statusEl = game.querySelector('.zo-chess-status');
		const turnEl = game.querySelector('.zo-chess-turn');
		const aiStatusEl = game.querySelector('.zo-chess-ai-status');
		const difficultyEl = game.querySelector('.zo-chess-difficulty');
		const sideEl = game.querySelector('.zo-chess-side');
		const restartEl = game.querySelector('.zo-chess-restart');
		const undoEl = game.querySelector('.zo-chess-undo');
		const movesEl = game.querySelector('.zo-chess-move-list');

		const files = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];
		const pieceSymbols = {
			wp: '♙', wn: '♘', wb: '♗', wr: '♖', wq: '♕', wk: '♔',
			bp: '♟', bn: '♞', bb: '♝', br: '♜', bq: '♛', bk: '♚'
		};

		const pieceValues = {
			p: 100,
			n: 320,
			b: 330,
			r: 500,
			q: 900,
			k: 20000
		};

		const knightTable = [
			[-50,-40,-30,-30,-30,-30,-40,-50],
			[-40,-20,0,5,5,0,-20,-40],
			[-30,5,10,15,15,10,5,-30],
			[-30,0,15,20,20,15,0,-30],
			[-30,5,15,20,20,15,5,-30],
			[-30,0,10,15,15,10,0,-30],
			[-40,-20,0,0,0,0,-20,-40],
			[-50,-40,-30,-30,-30,-30,-40,-50]
		];

		const bishopTable = [
			[-20,-10,-10,-10,-10,-10,-10,-20],
			[-10,5,0,0,0,0,5,-10],
			[-10,10,10,10,10,10,10,-10],
			[-10,0,10,10,10,10,0,-10],
			[-10,5,5,10,10,5,5,-10],
			[-10,0,5,10,10,5,0,-10],
			[-10,0,0,0,0,0,0,-10],
			[-20,-10,-10,-10,-10,-10,-10,-20]
		];

		const rookTable = [
			[0,0,5,10,10,5,0,0],
			[-5,0,0,0,0,0,0,-5],
			[-5,0,0,0,0,0,0,-5],
			[-5,0,0,0,0,0,0,-5],
			[-5,0,0,0,0,0,0,-5],
			[-5,0,0,0,0,0,0,-5],
			[5,10,10,10,10,10,10,5],
			[0,0,0,0,0,0,0,0]
		];

		const queenTable = [
			[-20,-10,-10,-5,-5,-10,-10,-20],
			[-10,0,0,0,0,0,0,-10],
			[-10,0,5,5,5,5,0,-10],
			[-5,0,5,5,5,5,0,-5],
			[0,0,5,5,5,5,0,-5],
			[-10,5,5,5,5,5,0,-10],
			[-10,0,5,0,0,0,0,-10],
			[-20,-10,-10,-5,-5,-10,-20]
		];

		const kingTable = [
			[-30,-40,-40,-50,-50,-40,-40,-30],
			[-30,-40,-40,-50,-50,-40,-40,-30],
			[-30,-40,-40,-50,-50,-40,-40,-30],
			[-30,-40,-40,-50,-50,-40,-40,-30],
			[-20,-30,-30,-40,-40,-30,-30,-20],
			[-10,-20,-20,-20,-20,-20,-20,-10],
			[20,20,0,0,0,0,20,20],
			[20,30,10,0,0,10,30,20]
		];

		const pawnTable = [
			[0,0,0,0,0,0,0,0],
			[50,50,50,50,50,50,50,50],
			[10,10,20,30,30,20,10,10],
			[5,5,10,25,25,10,5,5],
			[0,0,0,20,20,0,0,0],
			[5,-5,-10,0,0,-10,-5,5],
			[5,10,10,-20,-20,10,10,5],
			[0,0,0,0,0,0,0,0]
		];

		const difficultySettings = {
			veryeasy: { depth: 1, noise: 280, blunder: 0.38, think: 180 },
			easy:     { depth: 2, noise: 150, blunder: 0.22, think: 240 },
			medium:   { depth: 2, noise: 70,  blunder: 0.10, think: 320 },
			hard:     { depth: 3, noise: 22,  blunder: 0.03, think: 420 },
			veryhard: { depth: 3, noise: 6,   blunder: 0.00, think: 520 }
		};

		let state = null;

		function initialState() {
			return {
				board: [
					['br','bn','bb','bq','bk','bb','bn','br'],
					['bp','bp','bp','bp','bp','bp','bp','bp'],
					[null,null,null,null,null,null,null,null],
					[null,null,null,null,null,null,null,null],
					[null,null,null,null,null,null,null,null],
					[null,null,null,null,null,null,null,null],
					['wp','wp','wp','wp','wp','wp','wp','wp'],
					['wr','wn','wb','wq','wk','wb','wn','wr']
				],
				turn: 'w',
				human: 'w',
				ai: 'b',
				selected: null,
				legalMoves: [],
				lastMove: null,
				status: 'Pick a piece to move.',
				thinking: false,
				gameOver: false,
				winner: null,
				moveHistory: [],
				historyStates: [],
				castling: {
					wk: true, wq: true, bk: true, bq: true
				},
				enPassant: null,
				halfmove: 0,
				fullmove: 1
			};
		}

		function cloneMove(move) {
			return {
				from: { r: move.from.r, c: move.from.c },
				to: { r: move.to.r, c: move.to.c },
				piece: move.piece,
				capture: move.capture || null,
				promotion: move.promotion || null,
				enPassant: !!move.enPassant,
				castle: move.castle || null,
				doubleStep: !!move.doubleStep
			};
		}

		function serializeHistoryState(obj) {
			return {
				board: obj.board.map(function (row) { return row.slice(); }),
				turn: obj.turn,
				castling: {
					wk: obj.castling.wk,
					wq: obj.castling.wq,
					bk: obj.castling.bk,
					bq: obj.castling.bq
				},
				enPassant: obj.enPassant ? { r: obj.enPassant.r, c: obj.enPassant.c } : null,
				halfmove: obj.halfmove,
				fullmove: obj.fullmove,
				lastMove: obj.lastMove ? cloneMove(obj.lastMove) : null,
				moveHistory: obj.moveHistory.slice(),
				gameOver: obj.gameOver,
				winner: obj.winner,
				status: obj.status
			};
		}

		function restoreHistoryState(hist) {
			return {
				board: hist.board.map(function (row) { return row.slice(); }),
				turn: hist.turn,
				castling: {
					wk: hist.castling.wk,
					wq: hist.castling.wq,
					bk: hist.castling.bk,
					bq: hist.castling.bq
				},
				enPassant: hist.enPassant ? { r: hist.enPassant.r, c: hist.enPassant.c } : null,
				halfmove: hist.halfmove,
				fullmove: hist.fullmove,
				lastMove: hist.lastMove ? cloneMove(hist.lastMove) : null,
				moveHistory: hist.moveHistory.slice(),
				gameOver: hist.gameOver,
				winner: hist.winner,
				status: hist.status,
				human: state.human,
				ai: state.ai,
				selected: null,
				legalMoves: [],
				thinking: false,
				historyStates: state.historyStates.slice(0, Math.max(0, state.historyStates.length - 1))
			};
		}

		function coordToAlg(r, c) {
			return files[c] + (8 - r);
		}

		function inBounds(r, c) {
			return r >= 0 && r < 8 && c >= 0 && c < 8;
		}

		function pieceColor(piece) {
			return piece ? piece.charAt(0) : null;
		}

		function pieceType(piece) {
			return piece ? piece.charAt(1) : null;
		}

		function opposite(color) {
			return color === 'w' ? 'b' : 'w';
		}

		function getCurrentDifficulty() {
			const val = difficultyEl.value || 'medium';
			return difficultySettings[val] || difficultySettings.medium;
		}

		function setupNewGame() {
			state = initialState();
			state.human = sideEl.value === 'black' ? 'b' : 'w';
			state.ai = opposite(state.human);
			state.status = 'Pick a piece to move.';
			render();

			if (state.turn === state.ai) {
				triggerAiMove();
			}
		}

		function render() {
			renderBoard();
			renderPanel();
			renderMoves();
		}

		function renderBoard() {
			boardEl.innerHTML = '';

			for (let visualR = 0; visualR < 8; visualR++) {
				for (let visualC = 0; visualC < 8; visualC++) {
					const actual = visualToActual(visualR, visualC);
					const r = actual.r;
					const c = actual.c;
					const square = document.createElement('button');
					square.type = 'button';
					square.className = 'zo-chess-square ' + (((r + c) % 2 === 0) ? 'zo-chess-square--light' : 'zo-chess-square--dark');
					square.dataset.r = String(r);
					square.dataset.c = String(c);
					square.setAttribute('aria-label', coordToAlg(r, c));

					const piece = state.board[r][c];
					const selected = state.selected && state.selected.r === r && state.selected.c === c;
					const legal = state.legalMoves.find(function (m) { return m.to.r === r && m.to.c === c; });
					const isLast = state.lastMove && (
						(state.lastMove.from.r === r && state.lastMove.from.c === c) ||
						(state.lastMove.to.r === r && state.lastMove.to.c === c)
					);

					if (selected) {
						square.classList.add('is-selected');
					}
					if (legal) {
						square.classList.add('is-legal');
						if (legal.capture || legal.enPassant) {
							square.classList.add('is-capture');
						}
					}
					if (isLast) {
						square.classList.add('is-last-move');
					}
					if (piece && pieceType(piece) === 'k' && isKingInCheck(state, pieceColor(piece))) {
						square.classList.add('is-check');
					}

					if (piece) {
						const pieceSpan = document.createElement('span');
						pieceSpan.className = 'zo-piece zo-piece--' + (pieceColor(piece) === 'w' ? 'white' : 'black');
						pieceSpan.textContent = pieceSymbols[piece] || '';
						square.appendChild(pieceSpan);
					}

					if (visualR === 7) {
						const fileLabel = document.createElement('span');
						fileLabel.className = 'zo-label zo-label--file';
						fileLabel.textContent = files[c];
						square.appendChild(fileLabel);
					}

					if (visualC === 0) {
						const rankLabel = document.createElement('span');
						rankLabel.className = 'zo-label zo-label--rank';
						rankLabel.textContent = String(8 - r);
						square.appendChild(rankLabel);
					}

					square.addEventListener('click', onSquareClick);
					boardEl.appendChild(square);
				}
			}
		}

		function visualToActual(visualR, visualC) {
			if (state.human === 'w') {
				return { r: visualR, c: visualC };
			}
			return { r: 7 - visualR, c: 7 - visualC };
		}

		function renderPanel() {
			const whoseTurn = state.turn === 'w' ? 'White' : 'Black';
			const yourSide = state.human === 'w' ? 'White' : 'Black';
			statusEl.textContent = state.status;
			turnEl.textContent = 'Turn: ' + whoseTurn + ' | You: ' + yourSide;
			aiStatusEl.textContent = state.gameOver
				? 'Game finished.'
				: (state.thinking ? 'AI is thinking...' : 'AI difficulty: ' + difficultyEl.options[difficultyEl.selectedIndex].text);
		}

		function renderMoves() {
			movesEl.innerHTML = '';

			if (!state.moveHistory.length) {
				movesEl.textContent = 'No moves yet.';
				return;
			}

			for (let i = 0; i < state.moveHistory.length; i += 2) {
				const row = document.createElement('div');
				row.className = 'zo-chess-move-row';

				const num = document.createElement('div');
				num.textContent = String(Math.floor(i / 2) + 1) + '.';

				const white = document.createElement('div');
				white.textContent = state.moveHistory[i] || '';

				const black = document.createElement('div');
				black.textContent = state.moveHistory[i + 1] || '';

				row.appendChild(num);
				row.appendChild(white);
				row.appendChild(black);
				movesEl.appendChild(row);
			}

			movesEl.scrollTop = movesEl.scrollHeight;
		}

		function onSquareClick(e) {
			if (state.gameOver || state.thinking || state.turn !== state.human) {
				return;
			}

			const btn = e.currentTarget;
			const r = parseInt(btn.dataset.r, 10);
			const c = parseInt(btn.dataset.c, 10);
			const piece = state.board[r][c];

			if (state.selected) {
				const chosenMove = state.legalMoves.find(function (m) {
					return m.to.r === r && m.to.c === c;
				});

				if (chosenMove) {
					makeMove(chosenMove);
					return;
				}
			}

			if (piece && pieceColor(piece) === state.human && state.turn === state.human) {
				state.selected = { r: r, c: c };
				state.legalMoves = getLegalMovesForSquare(state, r, c);
				if (!state.legalMoves.length) {
					state.status = 'That piece has no legal moves.';
				} else {
					state.status = 'Choose where to move.';
				}
			} else {
				state.selected = null;
				state.legalMoves = [];
				state.status = 'Pick one of your pieces.';
			}

			render();
		}

		function saveHistorySnapshot() {
			state.historyStates.push(serializeHistoryState(state));
		}

		function undoMove() {
			if (state.thinking || !state.historyStates.length) {
				return;
			}

			if (state.historyStates.length >= 2) {
				state = restoreHistoryState(state.historyStates[state.historyStates.length - 2]);
				state.historyStates = state.historyStates.slice(0, state.historyStates.length - 2);
			} else if (state.historyStates.length === 1) {
				state = restoreHistoryState(state.historyStates[0]);
				state.historyStates = [];
			}

			state.selected = null;
			state.legalMoves = [];
			state.status = 'Move undone.';
			render();
		}

		function makeMove(move) {
			saveHistorySnapshot();
			applyMoveToState(state, move);
			state.selected = null;
			state.legalMoves = [];
			updateGameStatusAfterMove(move);
			render();

			if (!state.gameOver && state.turn === state.ai) {
				triggerAiMove();
			}
		}

		function triggerAiMove() {
			if (state.gameOver || state.turn !== state.ai) {
				return;
			}

			state.thinking = true;
			state.status = 'AI is thinking...';
			render();

			const settings = getCurrentDifficulty();

			window.setTimeout(function () {
				const move = chooseAiMove(state, settings);

				state.thinking = false;

				if (!move) {
					finishGameFromNoMoves();
					render();
					return;
				}

				saveHistorySnapshot();
				applyMoveToState(state, move);
				state.selected = null;
				state.legalMoves = [];
				updateGameStatusAfterMove(move);
				render();
			}, settings.think);
		}

		function finishGameFromNoMoves() {
			const color = state.turn;
			if (isKingInCheck(state, color)) {
				state.gameOver = true;
				state.winner = opposite(color);
				state.status = (state.winner === state.human ? 'Checkmate. You win.' : 'Checkmate. AI wins.');
			} else {
				state.gameOver = true;
				state.winner = 'draw';
				state.status = 'Stalemate. Draw game.';
			}
		}

		function updateGameStatusAfterMove(move) {
			const nextMoves = getAllLegalMoves(state, state.turn);

			if (!nextMoves.length) {
				if (isKingInCheck(state, state.turn)) {
					state.gameOver = true;
					state.winner = opposite(state.turn);
					state.status = state.winner === state.human ? 'Checkmate. You win.' : 'Checkmate. AI wins.';
				} else {
					state.gameOver = true;
					state.winner = 'draw';
					state.status = 'Stalemate. Draw game.';
				}
				return;
			}

			if (state.halfmove >= 100) {
				state.gameOver = true;
				state.winner = 'draw';
				state.status = 'Draw by 50-move rule.';
				return;
			}

			if (isKingInCheck(state, state.turn)) {
				state.status = (state.turn === state.human ? 'Your king is in check.' : 'AI king is in check.');
			} else {
				state.status = state.turn === state.human ? 'Your turn.' : 'AI turn.';
			}
		}

		function getLegalMovesForSquare(gameState, r, c) {
			const piece = gameState.board[r][c];
			if (!piece || pieceColor(piece) !== gameState.turn) {
				return [];
			}

			return getAllLegalMoves(gameState, gameState.turn).filter(function (move) {
				return move.from.r === r && move.from.c === c;
			});
		}

		function getAllLegalMoves(gameState, color) {
			const pseudo = [];
			for (let r = 0; r < 8; r++) {
				for (let c = 0; c < 8; c++) {
					const piece = gameState.board[r][c];
					if (piece && pieceColor(piece) === color) {
						getPseudoMovesForPiece(gameState, r, c).forEach(function (m) {
							pseudo.push(m);
						});
					}
				}
			}

			return pseudo.filter(function (move) {
				const next = shallowCloneForSearch(gameState);
				applyMoveToState(next, move, true);
				return !isKingInCheck(next, color);
			});
		}

		function shallowCloneForSearch(gameState) {
			return {
				board: gameState.board.map(function (row) { return row.slice(); }),
				turn: gameState.turn,
				human: gameState.human,
				ai: gameState.ai,
				selected: null,
				legalMoves: [],
				lastMove: gameState.lastMove ? cloneMove(gameState.lastMove) : null,
				status: gameState.status,
				thinking: false,
				gameOver: gameState.gameOver,
				winner: gameState.winner,
				moveHistory: gameState.moveHistory.slice(),
				historyStates: [],
				castling: {
					wk: gameState.castling.wk,
					wq: gameState.castling.wq,
					bk: gameState.castling.bk,
					bq: gameState.castling.bq
				},
				enPassant: gameState.enPassant ? { r: gameState.enPassant.r, c: gameState.enPassant.c } : null,
				halfmove: gameState.halfmove,
				fullmove: gameState.fullmove
			};
		}

		function getPseudoMovesForPiece(gameState, r, c) {
			const piece = gameState.board[r][c];
			if (!piece) {
				return [];
			}

			const color = pieceColor(piece);
			const type = pieceType(piece);
			const moves = [];

			if (type === 'p') {
				const dir = color === 'w' ? -1 : 1;
				const startRow = color === 'w' ? 6 : 1;
				const promoRow = color === 'w' ? 0 : 7;

				const oneR = r + dir;
				if (inBounds(oneR, c) && !gameState.board[oneR][c]) {
					moves.push({
						from: { r: r, c: c },
						to: { r: oneR, c: c },
						piece: piece,
						capture: null,
						promotion: oneR === promoRow ? color + 'q' : null
					});

					const twoR = r + dir * 2;
					if (r === startRow && inBounds(twoR, c) && !gameState.board[twoR][c]) {
						moves.push({
							from: { r: r, c: c },
							to: { r: twoR, c: c },
							piece: piece,
							capture: null,
							promotion: null,
							doubleStep: true
						});
					}
				}

				[-1, 1].forEach(function (dc) {
					const tr = r + dir;
					const tc = c + dc;
					if (!inBounds(tr, tc)) {
						return;
					}

					const target = gameState.board[tr][tc];
					if (target && pieceColor(target) !== color) {
						moves.push({
							from: { r: r, c: c },
							to: { r: tr, c: tc },
							piece: piece,
							capture: target,
							promotion: tr === promoRow ? color + 'q' : null
						});
					}

					if (gameState.enPassant && gameState.enPassant.r === tr && gameState.enPassant.c === tc) {
						moves.push({
							from: { r: r, c: c },
							to: { r: tr, c: tc },
							piece: piece,
							capture: color === 'w' ? 'bp' : 'wp',
							promotion: null,
							enPassant: true
						});
					}
				});
			}

			if (type === 'n') {
				[
					[-2, -1], [-2, 1], [-1, -2], [-1, 2],
					[1, -2], [1, 2], [2, -1], [2, 1]
				].forEach(function (delta) {
					const tr = r + delta[0];
					const tc = c + delta[1];
					if (!inBounds(tr, tc)) {
						return;
					}
					const target = gameState.board[tr][tc];
					if (!target || pieceColor(target) !== color) {
						moves.push({
							from: { r: r, c: c },
							to: { r: tr, c: tc },
							piece: piece,
							capture: target || null
						});
					}
				});
			}

			if (type === 'b' || type === 'r' || type === 'q') {
				const directions = [];
				if (type === 'b' || type === 'q') {
					directions.push([-1,-1], [-1,1], [1,-1], [1,1]);
				}
				if (type === 'r' || type === 'q') {
					directions.push([-1,0], [1,0], [0,-1], [0,1]);
				}

				directions.forEach(function (dir) {
					let tr = r + dir[0];
					let tc = c + dir[1];

					while (inBounds(tr, tc)) {
						const target = gameState.board[tr][tc];
						if (!target) {
							moves.push({
								from: { r: r, c: c },
								to: { r: tr, c: tc },
								piece: piece,
								capture: null
							});
						} else {
							if (pieceColor(target) !== color) {
								moves.push({
									from: { r: r, c: c },
									to: { r: tr, c: tc },
									piece: piece,
									capture: target
								});
							}
							break;
						}
						tr += dir[0];
						tc += dir[1];
					}
				});
			}

			if (type === 'k') {
				for (let dr = -1; dr <= 1; dr++) {
					for (let dc = -1; dc <= 1; dc++) {
						if (dr === 0 && dc === 0) {
							continue;
						}
						const tr = r + dr;
						const tc = c + dc;
						if (!inBounds(tr, tc)) {
							continue;
						}
						const target = gameState.board[tr][tc];
						if (!target || pieceColor(target) !== color) {
							moves.push({
								from: { r: r, c: c },
								to: { r: tr, c: tc },
								piece: piece,
								capture: target || null
							});
						}
					}
				}

				if (!isKingInCheck(gameState, color)) {
					if (color === 'w' && r === 7 && c === 4) {
						if (gameState.castling.wk && !gameState.board[7][5] && !gameState.board[7][6]) {
							if (!isSquareAttacked(gameState, 7, 5, 'b') && !isSquareAttacked(gameState, 7, 6, 'b')) {
								moves.push({
									from: { r: 7, c: 4 },
									to: { r: 7, c: 6 },
									piece: piece,
									capture: null,
									castle: 'king'
								});
							}
						}
						if (gameState.castling.wq && !gameState.board[7][1] && !gameState.board[7][2] && !gameState.board[7][3]) {
							if (!isSquareAttacked(gameState, 7, 3, 'b') && !isSquareAttacked(gameState, 7, 2, 'b')) {
								moves.push({
									from: { r: 7, c: 4 },
									to: { r: 7, c: 2 },
									piece: piece,
									capture: null,
									castle: 'queen'
								});
							}
						}
					}

					if (color === 'b' && r === 0 && c === 4) {
						if (gameState.castling.bk && !gameState.board[0][5] && !gameState.board[0][6]) {
							if (!isSquareAttacked(gameState, 0, 5, 'w') && !isSquareAttacked(gameState, 0, 6, 'w')) {
								moves.push({
									from: { r: 0, c: 4 },
									to: { r: 0, c: 6 },
									piece: piece,
									capture: null,
									castle: 'king'
								});
							}
						}
						if (gameState.castling.bq && !gameState.board[0][1] && !gameState.board[0][2] && !gameState.board[0][3]) {
							if (!isSquareAttacked(gameState, 0, 3, 'w') && !isSquareAttacked(gameState, 0, 2, 'w')) {
								moves.push({
									from: { r: 0, c: 4 },
									to: { r: 0, c: 2 },
									piece: piece,
									capture: null,
									castle: 'queen'
								});
							}
						}
					}
				}
			}

			return moves;
		}

		function isSquareAttacked(gameState, r, c, byColor) {
			for (let rr = 0; rr < 8; rr++) {
				for (let cc = 0; cc < 8; cc++) {
					const piece = gameState.board[rr][cc];
					if (!piece || pieceColor(piece) !== byColor) {
						continue;
					}

					const type = pieceType(piece);

					if (type === 'p') {
						const dir = byColor === 'w' ? -1 : 1;
						if (rr + dir === r && (cc - 1 === c || cc + 1 === c)) {
							return true;
						}
						continue;
					}

					if (type === 'n') {
						const jumps = [
							[-2, -1], [-2, 1], [-1, -2], [-1, 2],
							[1, -2], [1, 2], [2, -1], [2, 1]
						];
						for (let i = 0; i < jumps.length; i++) {
							if (rr + jumps[i][0] === r && cc + jumps[i][1] === c) {
								return true;
							}
						}
						continue;
					}

					if (type === 'b' || type === 'r' || type === 'q') {
						const dirs = [];
						if (type === 'b' || type === 'q') {
							dirs.push([-1,-1], [-1,1], [1,-1], [1,1]);
						}
						if (type === 'r' || type === 'q') {
							dirs.push([-1,0], [1,0], [0,-1], [0,1]);
						}

						for (let i = 0; i < dirs.length; i++) {
							let tr = rr + dirs[i][0];
							let tc = cc + dirs[i][1];
							while (inBounds(tr, tc)) {
								if (tr === r && tc === c) {
									return true;
								}
								if (gameState.board[tr][tc]) {
									break;
								}
								tr += dirs[i][0];
								tc += dirs[i][1];
							}
						}
						continue;
					}

					if (type === 'k') {
						for (let dr = -1; dr <= 1; dr++) {
							for (let dc = -1; dc <= 1; dc++) {
								if (dr === 0 && dc === 0) {
									continue;
								}
								if (rr + dr === r && cc + dc === c) {
									return true;
								}
							}
						}
					}
				}
			}
			return false;
		}

		function findKing(gameState, color) {
			for (let r = 0; r < 8; r++) {
				for (let c = 0; c < 8; c++) {
					if (gameState.board[r][c] === color + 'k') {
						return { r: r, c: c };
					}
				}
			}
			return null;
		}

		function isKingInCheck(gameState, color) {
			const king = findKing(gameState, color);
			if (!king) {
				return false;
			}
			return isSquareAttacked(gameState, king.r, king.c, opposite(color));
		}

		function applyMoveToState(gameState, move, silent) {
			const board = gameState.board;
			const piece = board[move.from.r][move.from.c];
			const color = pieceColor(piece);
			const type = pieceType(piece);
			let captured = board[move.to.r][move.to.c];

			if (move.enPassant) {
				const capRow = color === 'w' ? move.to.r + 1 : move.to.r - 1;
				captured = board[capRow][move.to.c];
				board[capRow][move.to.c] = null;
			}

			board[move.to.r][move.to.c] = move.promotion || piece;
			board[move.from.r][move.from.c] = null;

			if (move.castle === 'king') {
				if (color === 'w') {
					board[7][5] = board[7][7];
					board[7][7] = null;
				} else {
					board[0][5] = board[0][7];
					board[0][7] = null;
				}
			}

			if (move.castle === 'queen') {
				if (color === 'w') {
					board[7][3] = board[7][0];
					board[7][0] = null;
				} else {
					board[0][3] = board[0][0];
					board[0][0] = null;
				}
			}

			if (piece === 'wk') {
				gameState.castling.wk = false;
				gameState.castling.wq = false;
			}
			if (piece === 'bk') {
				gameState.castling.bk = false;
				gameState.castling.bq = false;
			}
			if ((move.from.r === 7 && move.from.c === 0) || (move.to.r === 7 && move.to.c === 0)) {
				gameState.castling.wq = false;
			}
			if ((move.from.r === 7 && move.from.c === 7) || (move.to.r === 7 && move.to.c === 7)) {
				gameState.castling.wk = false;
			}
			if ((move.from.r === 0 && move.from.c === 0) || (move.to.r === 0 && move.to.c === 0)) {
				gameState.castling.bq = false;
			}
			if ((move.from.r === 0 && move.from.c === 7) || (move.to.r === 0 && move.to.c === 7)) {
				gameState.castling.bk = false;
			}

			gameState.enPassant = null;
			if (type === 'p' && move.doubleStep) {
				gameState.enPassant = {
					r: color === 'w' ? move.from.r - 1 : move.from.r + 1,
					c: move.from.c
				};
			}

			if (type === 'p' || captured) {
				gameState.halfmove = 0;
			} else {
				gameState.halfmove += 1;
			}

			if (color === 'b') {
				gameState.fullmove += 1;
			}

			gameState.lastMove = cloneMove(move);
			gameState.turn = opposite(gameState.turn);

			if (!silent) {
				gameState.moveHistory.push(moveToNotation(gameState, move, captured));
			}
		}

		function moveToNotation(gameState, move, captured) {
			const type = pieceType(move.piece);
			const dest = coordToAlg(move.to.r, move.to.c);

			if (move.castle === 'king') {
				return 'O-O';
			}
			if (move.castle === 'queen') {
				return 'O-O-O';
			}

			let text = '';
			if (type !== 'p') {
				text += type.toUpperCase();
			} else if (captured || move.enPassant) {
				text += files[move.from.c];
			}

			if (captured || move.enPassant) {
				text += 'x';
			}

			text += dest;

			if (move.promotion) {
				text += '=Q';
			}

			const nextMoves = getAllLegalMoves(gameState, gameState.turn);
			if (!nextMoves.length && isKingInCheck(gameState, gameState.turn)) {
				text += '#';
			} else if (isKingInCheck(gameState, gameState.turn)) {
				text += '+';
			}

			return text;
		}

		function chooseAiMove(gameState, settings) {
			const legalMoves = getAllLegalMoves(gameState, gameState.ai);
			if (!legalMoves.length) {
				return null;
			}

			if (Math.random() < settings.blunder) {
				return legalMoves[Math.floor(Math.random() * legalMoves.length)];
			}

			const ordered = legalMoves.slice().sort(function (a, b) {
				const av = (a.capture ? pieceValues[pieceType(a.capture)] : 0) + (a.promotion ? 800 : 0);
				const bv = (b.capture ? pieceValues[pieceType(b.capture)] : 0) + (b.promotion ? 800 : 0);
				return bv - av;
			});

			let bestScore = -Infinity;
			let bestMoves = [];

			for (let i = 0; i < ordered.length; i++) {
				const next = shallowCloneForSearch(gameState);
				applyMoveToState(next, ordered[i], true);
				const score = minimax(next, settings.depth - 1, -Infinity, Infinity, false, gameState.ai) + randomNoise(settings.noise);

				if (score > bestScore) {
					bestScore = score;
					bestMoves = [ordered[i]];
				} else if (score === bestScore) {
					bestMoves.push(ordered[i]);
				}
			}

			return bestMoves[Math.floor(Math.random() * bestMoves.length)];
		}

		function randomNoise(level) {
			if (!level) {
				return 0;
			}
			return Math.floor((Math.random() * (level * 2 + 1)) - level);
		}

		function minimax(gameState, depth, alpha, beta, maximizing, aiColor) {
			const currentColor = gameState.turn;
			const legalMoves = getAllLegalMoves(gameState, currentColor);

			if (depth <= 0 || !legalMoves.length) {
				if (!legalMoves.length) {
					if (isKingInCheck(gameState, currentColor)) {
						return currentColor === aiColor ? -999999 : 999999;
					}
					return 0;
				}
				return evaluateBoard(gameState, aiColor);
			}

			if (maximizing) {
				let maxEval = -Infinity;
				for (let i = 0; i < legalMoves.length; i++) {
					const next = shallowCloneForSearch(gameState);
					applyMoveToState(next, legalMoves[i], true);
					const evalScore = minimax(next, depth - 1, alpha, beta, false, aiColor);
					if (evalScore > maxEval) {
						maxEval = evalScore;
					}
					if (evalScore > alpha) {
						alpha = evalScore;
					}
					if (beta <= alpha) {
						break;
					}
				}
				return maxEval;
			}

			let minEval = Infinity;
			for (let i = 0; i < legalMoves.length; i++) {
				const next = shallowCloneForSearch(gameState);
				applyMoveToState(next, legalMoves[i], true);
				const evalScore = minimax(next, depth - 1, alpha, beta, true, aiColor);
				if (evalScore < minEval) {
					minEval = evalScore;
				}
				if (evalScore < beta) {
					beta = evalScore;
				}
				if (beta <= alpha) {
					break;
				}
			}
			return minEval;
		}

		function evaluateBoard(gameState, aiColor) {
			let score = 0;

			for (let r = 0; r < 8; r++) {
				for (let c = 0; c < 8; c++) {
					const piece = gameState.board[r][c];
					if (!piece) {
						continue;
					}

					const color = pieceColor(piece);
					const type = pieceType(piece);
					let val = pieceValues[type] || 0;
					val += getPieceSquareBonus(type, color, r, c);

					if (color === aiColor) {
						score += val;
					} else {
						score -= val;
					}
				}
			}

			const myMoves = getAllLegalMoves(gameState, aiColor).length;
			const oppMoves = getAllLegalMoves(gameState, opposite(aiColor)).length;
			score += (myMoves - oppMoves) * 3;

			return score;
		}

		function getPieceSquareBonus(type, color, r, c) {
			let row = color === 'w' ? r : 7 - r;

			if (type === 'p') return pawnTable[row][c];
			if (type === 'n') return knightTable[row][c];
			if (type === 'b') return bishopTable[row][c];
			if (type === 'r') return rookTable[row][c];
			if (type === 'q') return queenTable[row][c];
			if (type === 'k') return kingTable[row][c];
			return 0;
		}

		restartEl.addEventListener('click', function () {
			setupNewGame();
		});

		undoEl.addEventListener('click', function () {
			undoMove();
		});

		sideEl.addEventListener('change', function () {
			setupNewGame();
		});

		difficultyEl.addEventListener('change', function () {
			if (!state.gameOver) {
				state.status = 'Difficulty changed to ' + difficultyEl.options[difficultyEl.selectedIndex].text + '.';
				render();
			}
		});

		setupNewGame();
	});
});
JS;

if (!function_exists('zo_game_chess_ai_render')) {
	function zo_game_chess_ai_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-chess-ai-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--chess-ai" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-chess-wrap">
				<div class="zo-chess-board-wrap">
					<div class="zo-chess-board" aria-label="Chess board"></div>
				</div>

				<div class="zo-chess-panel">
					<h2 class="zo-chess-title">Chess vs AI</h2>
					<p class="zo-chess-instructions">
						Play chess against the computer. Choose your side and AI level. Tap or click a piece, then tap a highlighted square to move.
					</p>

					<div class="zo-chess-controls">
						<div class="zo-chess-field">
							<label for="<?php echo esc_attr($instance_id); ?>-difficulty">AI difficulty</label>
							<select class="zo-chess-select zo-chess-difficulty" id="<?php echo esc_attr($instance_id); ?>-difficulty">
								<option value="veryeasy">Very Easy AI</option>
								<option value="easy">Easy AI</option>
								<option value="medium" selected>Medium AI</option>
								<option value="hard">Hard AI</option>
								<option value="veryhard">Very Hard AI</option>
							</select>
						</div>

						<div class="zo-chess-field">
							<label for="<?php echo esc_attr($instance_id); ?>-side">Your side</label>
							<select class="zo-chess-select zo-chess-side" id="<?php echo esc_attr($instance_id); ?>-side">
								<option value="white" selected>White</option>
								<option value="black">Black</option>
							</select>
						</div>

						<div class="zo-chess-button-row">
							<button type="button" class="zo-chess-button zo-chess-restart">New Game</button>
							<button type="button" class="zo-chess-button zo-chess-button--secondary zo-chess-undo">Undo</button>
						</div>
					</div>

					<p class="zo-chess-status">Pick a piece to move.</p>
					<p class="zo-chess-turn">Turn: White | You: White</p>
					<p class="zo-chess-ai-status">AI difficulty: Medium AI</p>

					<div class="zo-chess-moves">
						<h3>Move List</h3>
						<div class="zo-chess-move-list">No moves yet.</div>
					</div>

					<div class="zo-chess-footer">
						Includes legal moves, check, checkmate, stalemate, castling, en passant, and queen promotion.
					</div>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'chess-ai',
	'name'            => 'Chess vs AI',
	'author'          => 'Asker',
	'description'     => 'Play chess against computer opponents from very easy to very hard.',
	'render_callback' => 'zo_game_chess_ai_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);