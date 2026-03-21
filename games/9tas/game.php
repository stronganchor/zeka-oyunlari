<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 760px;
	margin: 0 auto;
	text-align: center;
	font-family: Arial, sans-serif;
}

.zo-game-root--dokuz-tas .zo-dt-card {
	background: #ffffff;
	border: 3px solid #222;
	border-radius: 18px;
	padding: 20px;
	box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}

.zo-game-root--dokuz-tas .zo-dt-title {
	font-size: 28px;
	font-weight: 700;
	margin: 0 0 10px;
	color: #222;
}

.zo-game-root--dokuz-tas .zo-dt-subtitle {
	font-size: 16px;
	line-height: 1.5;
	margin: 0 0 16px;
	color: #444;
}

.zo-game-root--dokuz-tas .zo-dt-status {
	min-height: 28px;
	font-size: 18px;
	font-weight: 700;
	margin: 12px 0 16px;
	color: #0b5;
}

.zo-game-root--dokuz-tas .zo-dt-stats {
	display: flex;
	justify-content: center;
	gap: 12px;
	flex-wrap: wrap;
	margin-bottom: 16px;
}

.zo-game-root--dokuz-tas .zo-dt-stat {
	background: #f4f4f4;
	border: 2px solid #ddd;
	border-radius: 999px;
	padding: 8px 14px;
	font-size: 14px;
	font-weight: 700;
	color: #333;
}

.zo-game-root--dokuz-tas .zo-dt-board-wrap {
	display: flex;
	justify-content: center;
	margin-bottom: 16px;
}

.zo-game-root--dokuz-tas .zo-dt-board {
	width: 100%;
	max-width: 520px;
	aspect-ratio: 1 / 1;
	position: relative;
	margin: 0 auto;
	background: #f8f5ef;
	border: 3px solid #222;
	border-radius: 12px;
}

.zo-game-root--dokuz-tas .zo-dt-line {
	position: absolute;
	background: #222;
	border-radius: 999px;
	transform-origin: center center;
	z-index: 1;
	pointer-events: none;
}

.zo-game-root--dokuz-tas .zo-dt-point {
	position: absolute;
	width: 38px;
	height: 38px;
	border: 3px solid #222;
	border-radius: 999px;
	background: #fff;
	transform: translate(-50%, -50%);
	cursor: pointer;
	padding: 0;
	transition: transform 0.12s ease, box-shadow 0.12s ease, background 0.12s ease;
	z-index: 3;
	display: block;
}

.zo-game-root--dokuz-tas .zo-dt-point::before {
	content: '';
	position: absolute;
	left: 50%;
	top: 50%;
	width: 10px;
	height: 10px;
	background: #999;
	border-radius: 999px;
	transform: translate(-50%, -50%);
}

.zo-game-root--dokuz-tas .zo-dt-point:hover,
.zo-game-root--dokuz-tas .zo-dt-point:focus {
	transform: translate(-50%, -50%) scale(1.06);
	outline: none;
	box-shadow: 0 0 0 4px rgba(0, 0, 0, 0.08);
}

.zo-game-root--dokuz-tas .zo-dt-point.is-selectable {
	box-shadow: 0 0 0 5px rgba(76, 175, 80, 0.28);
	background: #f2fff2;
}

.zo-game-root--dokuz-tas .zo-dt-point.is-selected {
	box-shadow: 0 0 0 6px rgba(33, 150, 243, 0.28);
}

.zo-game-root--dokuz-tas .zo-dt-point.is-removable {
	box-shadow: 0 0 0 6px rgba(244, 67, 54, 0.28);
}

.zo-game-root--dokuz-tas .zo-dt-point.has-piece::before {
	display: none;
}

.zo-game-root--dokuz-tas .zo-dt-piece {
	position: absolute;
	inset: 3px;
	border-radius: 999px;
	z-index: 2;
}

.zo-game-root--dokuz-tas .zo-dt-piece--w {
	background: linear-gradient(180deg, #fafafa 0%, #cfcfcf 100%);
	border: 2px solid #555;
}

.zo-game-root--dokuz-tas .zo-dt-piece--b {
	background: linear-gradient(180deg, #555 0%, #111 100%);
	border: 2px solid #000;
}

.zo-game-root--dokuz-tas .zo-dt-actions {
	display: flex;
	justify-content: center;
	gap: 10px;
	flex-wrap: wrap;
	margin-top: 8px;
}

.zo-game-root--dokuz-tas .zo-dt-btn {
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

.zo-game-root--dokuz-tas .zo-dt-btn:hover,
.zo-game-root--dokuz-tas .zo-dt-btn:focus {
	background: #000;
	outline: none;
}

.zo-game-root--dokuz-tas .zo-dt-help {
	margin-top: 14px;
	font-size: 14px;
	color: #555;
	line-height: 1.55;
	text-align: left;
	max-width: 620px;
	margin-left: auto;
	margin-right: auto;
}

.zo-game-root--dokuz-tas .zo-dt-help strong {
	color: #222;
}

@media (max-width: 520px) {
	.zo-game-root--dokuz-tas .zo-dt-point {
		width: 32px;
		height: 32px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--dokuz-tas');

	const positions = [
		{x: 10, y: 10},
		{x: 50, y: 10},
		{x: 90, y: 10},
		{x: 22, y: 22},
		{x: 50, y: 22},
		{x: 78, y: 22},
		{x: 34, y: 34},
		{x: 50, y: 34},
		{x: 66, y: 34},
		{x: 10, y: 50},
		{x: 22, y: 50},
		{x: 34, y: 50},
		{x: 66, y: 50},
		{x: 78, y: 50},
		{x: 90, y: 50},
		{x: 34, y: 66},
		{x: 50, y: 66},
		{x: 66, y: 66},
		{x: 22, y: 78},
		{x: 50, y: 78},
		{x: 78, y: 78},
		{x: 10, y: 90},
		{x: 50, y: 90},
		{x: 90, y: 90}
	];

	const lines = [
		[0,1],[1,2],[0,9],[2,14],[9,21],[14,23],[21,22],[22,23],
		[3,4],[4,5],[3,10],[5,13],[10,18],[13,20],[18,19],[19,20],
		[6,7],[7,8],[6,11],[8,12],[11,15],[12,17],[15,16],[16,17],
		[1,4],[4,7],[7,16],[16,19],[9,10],[10,11],[12,13],[13,14]
	];

	const neighbors = {
		0:[1,9], 1:[0,2,4], 2:[1,14],
		3:[4,10], 4:[1,3,5,7], 5:[4,13],
		6:[7,11], 7:[4,6,8,16], 8:[7,12],
		9:[0,10,21], 10:[3,9,11,18], 11:[6,10,15],
		12:[8,13,17], 13:[5,12,14,20], 14:[2,13,23],
		15:[11,16], 16:[7,15,17,19], 17:[12,16],
		18:[10,19], 19:[16,18,20,22], 20:[13,19],
		21:[9,22], 22:[19,21,23], 23:[14,22]
	};

	const mills = [
		[0,1,2],[3,4,5],[6,7,8],[9,10,11],[12,13,14],[15,16,17],[18,19,20],[21,22,23],
		[0,9,21],[3,10,18],[6,11,15],[1,4,7],[16,19,22],[8,12,17],[5,13,20],[2,14,23]
	];

	function otherPlayer(player) {
		return player === 'W' ? 'B' : 'W';
	}

	function createLine(board, a, b) {
		const p1 = positions[a];
		const p2 = positions[b];
		const dx = p2.x - p1.x;
		const dy = p2.y - p1.y;
		const length = Math.sqrt(dx * dx + dy * dy);
		const angle = Math.atan2(dy, dx) * 180 / Math.PI;
		const line = document.createElement('div');
		line.className = 'zo-dt-line';
		line.style.left = p1.x + '%';
		line.style.top = p1.y + '%';
		line.style.width = length + '%';
		line.style.height = '4px';
		line.style.transform = 'translateY(-50%) rotate(' + angle + 'deg)';
		board.appendChild(line);
	}

	function getMillsForIndex(index) {
		return mills.filter(function (mill) {
			return mill.indexOf(index) !== -1;
		});
	}

	function isPartOfMill(state, index, player) {
		return getMillsForIndex(index).some(function (mill) {
			return mill.every(function (pos) {
				return state.board[pos] === player;
			});
		});
	}

	function formedMillAfterPlay(state, index, player) {
		return getMillsForIndex(index).some(function (mill) {
			return mill.every(function (pos) {
				return state.board[pos] === player;
			});
		});
	}

	function getRemovablePieces(state, enemy) {
		const allEnemy = [];
		const enemyNotInMill = [];

		state.board.forEach(function (value, index) {
			if (value === enemy) {
				allEnemy.push(index);
				if (!isPartOfMill(state, index, enemy)) {
					enemyNotInMill.push(index);
				}
			}
		});

		return enemyNotInMill.length ? enemyNotInMill : allEnemy;
	}

	function countPieces(state, player) {
		let count = 0;
		state.board.forEach(function (value) {
			if (value === player) {
				count += 1;
			}
		});
		return count;
	}

	function hasAnyMove(state, player) {
		const pieceCount = countPieces(state, player);

		for (let i = 0; i < state.board.length; i++) {
			if (state.board[i] !== player) {
				continue;
			}

			if (pieceCount <= 3) {
				for (let j = 0; j < state.board.length; j++) {
					if (state.board[j] === null) {
						return true;
					}
				}
			} else {
				for (let k = 0; k < neighbors[i].length; k++) {
					if (state.board[neighbors[i][k]] === null) {
						return true;
					}
				}
			}
		}

		return false;
	}

	function checkWinner(state) {
		const whiteCount = countPieces(state, 'W');
		const blackCount = countPieces(state, 'B');

		if (state.toPlace.W === 0 && whiteCount < 3) {
			return 'B';
		}

		if (state.toPlace.B === 0 && blackCount < 3) {
			return 'W';
		}

		if (state.phase === 'moving') {
			if (!hasAnyMove(state, 'W')) {
				return 'B';
			}

			if (!hasAnyMove(state, 'B')) {
				return 'W';
			}
		}

		return null;
	}

	function getAllowedTargets(state, fromIndex) {
		const pieceCount = countPieces(state, state.currentPlayer);
		const canFly = pieceCount <= 3;
		const targets = [];

		for (let i = 0; i < state.board.length; i++) {
			if (state.board[i] !== null) {
				continue;
			}

			if (canFly || neighbors[fromIndex].indexOf(i) !== -1) {
				targets.push(i);
			}
		}

		return targets;
	}

	games.forEach(function (game) {
		const boardEl = game.querySelector('.zo-dt-board');
		const statusEl = game.querySelector('.zo-dt-status');
		const turnEl = game.querySelector('.zo-dt-turn-value');
		const whiteEl = game.querySelector('.zo-dt-white-value');
		const blackEl = game.querySelector('.zo-dt-black-value');
		const resetBtn = game.querySelector('.zo-dt-reset');
		const hintBtn = game.querySelector('.zo-dt-hint');

		const state = {
			board: new Array(24).fill(null),
			currentPlayer: 'W',
			toPlace: {W: 9, B: 9},
			phase: 'placing',
			selected: null,
			mustRemove: false,
			winner: null,
			hint: 'Place a stone on any visible spot.'
		};

		lines.forEach(function (pair) {
			createLine(boardEl, pair[0], pair[1]);
		});

		const pointButtons = positions.map(function (pos, index) {
			const button = document.createElement('button');
			button.type = 'button';
			button.className = 'zo-dt-point';
			button.style.left = pos.x + '%';
			button.style.top = pos.y + '%';
			button.setAttribute('aria-label', 'Point ' + (index + 1));
			button.dataset.index = String(index);

			button.addEventListener('click', function () {
				handlePointClick(index);
			});

			boardEl.appendChild(button);
			return button;
		});

		function updateStatus(text) {
			statusEl.textContent = text;
		}

		function updateStats() {
			turnEl.textContent = state.currentPlayer === 'W' ? 'White' : 'Black';
			whiteEl.textContent = String(countPieces(state, 'W')) + ' on board, ' + String(state.toPlace.W) + ' left';
			blackEl.textContent = String(countPieces(state, 'B')) + ' on board, ' + String(state.toPlace.B) + ' left';
		}

		function refreshBoard() {
			const removable = state.mustRemove ? getRemovablePieces(state, otherPlayer(state.currentPlayer)) : [];
			const allowedTargets = state.phase === 'moving' && state.selected !== null && !state.mustRemove
				? getAllowedTargets(state, state.selected)
				: [];

			pointButtons.forEach(function (button, index) {
				button.innerHTML = '';
				button.classList.remove('is-selectable', 'is-selected', 'is-removable', 'has-piece');

				const piece = state.board[index];
				if (piece) {
					button.classList.add('has-piece');
					const pieceEl = document.createElement('span');
					pieceEl.className = 'zo-dt-piece zo-dt-piece--' + piece.toLowerCase();
					button.appendChild(pieceEl);
				}

				if (state.winner) {
					return;
				}

				if (state.mustRemove) {
					if (removable.indexOf(index) !== -1) {
						button.classList.add('is-removable');
					}
					return;
				}

				if (state.phase === 'placing') {
					if (state.board[index] === null) {
						button.classList.add('is-selectable');
					}
					return;
				}

				if (state.selected === index) {
					button.classList.add('is-selected');
					return;
				}

				if (state.selected === null) {
					if (state.board[index] === state.currentPlayer) {
						button.classList.add('is-selectable');
					}
					return;
				}

				if (allowedTargets.indexOf(index) !== -1) {
					button.classList.add('is-selectable');
				}
			});

			updateStats();
		}

		function setHintMessage() {
			if (state.winner) {
				state.hint = (state.winner === 'W' ? 'White' : 'Black') + ' wins.';
				return;
			}

			if (state.mustRemove) {
				state.hint = 'You made a mill. Remove one enemy stone.';
				return;
			}

			if (state.phase === 'placing') {
				state.hint = 'Place a stone on any visible spot.';
				return;
			}

			if (state.selected === null) {
				const pieceCount = countPieces(state, state.currentPlayer);
				if (pieceCount <= 3) {
					state.hint = 'Select one of your stones, then move it to any empty spot.';
				} else {
					state.hint = 'Select one of your stones, then move it to a connected empty spot.';
				}
			} else {
				const pieceCount = countPieces(state, state.currentPlayer);
				if (pieceCount <= 3) {
					state.hint = 'Now choose any empty spot.';
				} else {
					state.hint = 'Now choose a connected empty spot.';
				}
			}
		}

		function switchTurn() {
			state.selected = null;
			state.currentPlayer = otherPlayer(state.currentPlayer);

			if (state.toPlace.W === 0 && state.toPlace.B === 0) {
				state.phase = 'moving';
			}

			state.winner = checkWinner(state);
			setHintMessage();
			refreshBoard();

			if (state.winner) {
				updateStatus((state.winner === 'W' ? 'White' : 'Black') + ' wins.');
			} else {
				updateStatus((state.currentPlayer === 'W' ? 'White' : 'Black') + '\'s turn.');
			}
		}

		function afterMoveOrPlace(indexJustPlayed) {
			if (formedMillAfterPlay(state, indexJustPlayed, state.currentPlayer)) {
				state.mustRemove = true;
				setHintMessage();
				refreshBoard();
				updateStatus((state.currentPlayer === 'W' ? 'White' : 'Black') + ' made a mill. Remove one enemy stone.');
				return;
			}

			switchTurn();
		}

		function handleRemove(index) {
			const enemy = otherPlayer(state.currentPlayer);
			const removable = getRemovablePieces(state, enemy);

			if (removable.indexOf(index) === -1) {
				updateStatus('Choose a removable enemy stone.');
				return;
			}

			state.board[index] = null;
			state.mustRemove = false;
			state.winner = checkWinner(state);

			if (state.winner) {
				setHintMessage();
				refreshBoard();
				updateStatus((state.winner === 'W' ? 'White' : 'Black') + ' wins.');
				return;
			}

			switchTurn();
		}

		function handlePlacing(index) {
			if (state.board[index] !== null) {
				updateStatus('Pick an empty spot.');
				return;
			}

			state.board[index] = state.currentPlayer;
			state.toPlace[state.currentPlayer] -= 1;
			state.selected = null;
			afterMoveOrPlace(index);
		}

		function handleMoving(index) {
			if (state.selected === null) {
				if (state.board[index] !== state.currentPlayer) {
					updateStatus('Select one of your own stones.');
					return;
				}

				state.selected = index;
				setHintMessage();
				refreshBoard();
				updateStatus('Stone selected. Choose where to move.');
				return;
			}

			if (index === state.selected) {
				state.selected = null;
				setHintMessage();
				refreshBoard();
				updateStatus('Selection cleared.');
				return;
			}

			if (state.board[index] === state.currentPlayer) {
				state.selected = index;
				setHintMessage();
				refreshBoard();
				updateStatus('Stone selected. Choose where to move.');
				return;
			}

			if (state.board[index] !== null) {
				updateStatus('That spot is not empty.');
				return;
			}

			const allowedTargets = getAllowedTargets(state, state.selected);
			if (allowedTargets.indexOf(index) === -1) {
				updateStatus('Move to a connected spot.');
				return;
			}

			state.board[index] = state.currentPlayer;
			state.board[state.selected] = null;
			state.selected = null;
			afterMoveOrPlace(index);
		}

		function handlePointClick(index) {
			if (state.winner) {
				return;
			}

			if (state.mustRemove) {
				handleRemove(index);
				return;
			}

			if (state.phase === 'placing') {
				handlePlacing(index);
				return;
			}

			handleMoving(index);
		}

		function resetGame() {
			state.board = new Array(24).fill(null);
			state.currentPlayer = 'W';
			state.toPlace = {W: 9, B: 9};
			state.phase = 'placing';
			state.selected = null;
			state.mustRemove = false;
			state.winner = null;
			setHintMessage();
			refreshBoard();
			updateStatus('White starts. Place a stone on a visible spot.');
		}

		resetBtn.addEventListener('click', function () {
			resetGame();
		});

		hintBtn.addEventListener('click', function () {
			setHintMessage();
			updateStatus(state.hint);
		});

		resetGame();
	});
});
JS;

if (!function_exists('zo_game_dokuz_tas_render')) {
	function zo_game_dokuz_tas_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-dokuz-tas-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--dokuz-tas" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-dt-card">
				<h2 class="zo-dt-title">Dokuz Taş</h2>
				<p class="zo-dt-subtitle">Turkish Nine Men's Morris. First place all 9 stones each. Make a line of 3 to remove one enemy stone. Reduce your opponent to 2 stones or block all moves to win.</p>

				<div class="zo-dt-stats">
					<div class="zo-dt-stat">Turn: <span class="zo-dt-turn-value">White</span></div>
					<div class="zo-dt-stat">White: <span class="zo-dt-white-value">0 on board, 9 left</span></div>
					<div class="zo-dt-stat">Black: <span class="zo-dt-black-value">0 on board, 9 left</span></div>
				</div>

				<div class="zo-dt-status" aria-live="polite">White starts. Place a stone on a visible spot.</div>

				<div class="zo-dt-board-wrap">
					<div class="zo-dt-board"></div>
				</div>

				<div class="zo-dt-actions">
					<button type="button" class="zo-dt-btn zo-dt-reset">Restart</button>
					<button type="button" class="zo-dt-btn zo-dt-hint">Show Hint</button>
				</div>

				<div class="zo-dt-help">
					<strong>How to play:</strong> During the first phase, players take turns placing stones on empty spots. When all stones are placed, players move one stone per turn. If a player has only 3 stones left, that player may jump to any empty spot. Making a row of 3 stones lets you remove one enemy stone. Stones inside a mill cannot be removed unless all enemy stones are in mills.
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'dokuz-tas',
	'name'            => 'Dokuz Taş',
	'author'          => 'Arslan',
	'description'     => 'A browser-based Turkish Nine Men\'s Morris game for two players.',
	'render_callback' => 'zo_game_dokuz_tas_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);