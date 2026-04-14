document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--sudoku');

	const puzzleBank = {
		easy: [
			{
				puzzle: '530070000600195000098000060800060003400803001700020006060000280000419005000080079',
				solution: '534678912672195348198342567859761423426853791713924856961537284287419635345286179'
			},
			{
				puzzle: '200080300060070084030500209000105408000000000402706000301007040720040060004010003',
				solution: '245981376169273584837564219976125438513498627482736951391657842728349165654812793'
			},
			{
				puzzle: '000260701680070090190004500820100040004602900050003028009300074040050036703018000',
				solution: '435269781682571493197834562826195347374682915951743628519326874248957136763418259'
			}
		],
		medium: [
			{
				puzzle: '000000907000420180000705026100904000050000040000507009920108000034059000507000000',
				solution: '462831957795426183381795426173984265659312748248567319926178534834259671517643892'
			},
			{
				puzzle: '300000000005009000200504000020000700160000058704310600000890100000067080000005437',
				solution: '397681524645279813218534976823956741169742358754318692472893165531467289986125437'
			},
			{
				puzzle: '000900002050123400030000160908000000070000090000000205091000050007439020400007000',
				solution: '814976532659123478732854169948265317275341896163798245391682754587439621426517983'
			}
		],
		hard: [
			{
				puzzle: '005300000800000020070010500400005300010070006003200080060500009004000030000009700',
				solution: '145327698839654127672918543496185372218473956753296481367542819984761235521839764'
			},
			{
				puzzle: '000000000000003085001020000000507000004000100090000000500000073002010000000040009',
				solution: '987654321246173985351928746128537694634892157795461832519286473472319568863745219'
			},
			{
				puzzle: '900050001040003005001900700100500004004090100700001030500200003070300060800040009',
				solution: '987654321246173985351928746128537694634892157795461832519286473472319568863745219'
			}
		]
	};

	function getBoxIndex(row, col) {
		return Math.floor(row / 3) * 3 + Math.floor(col / 3);
	}

	function toCells(value) {
		return value.split('');
	}

	function formatTime(totalSeconds) {
		const mins = String(Math.floor(totalSeconds / 60)).padStart(2, '0');
		const secs = String(totalSeconds % 60).padStart(2, '0');
		return mins + ':' + secs;
	}

	function pickPuzzle(level, usedIndexes) {
		const list = puzzleBank[level] || puzzleBank.easy;
		const available = list.map(function (_, index) {
			return index;
		}).filter(function (index) {
			return !usedIndexes.includes(index);
		});
		const choices = available.length ? available : list.map(function (_, index) {
			return index;
		});
		const choice = choices[Math.floor(Math.random() * choices.length)];
		return { index: choice, data: list[choice] };
	}

	function setStatus(statusEl, message, type) {
		statusEl.textContent = message;
		statusEl.classList.remove('is-success', 'is-warning');

		if (type === 'success') {
			statusEl.classList.add('is-success');
		} else if (type === 'warning') {
			statusEl.classList.add('is-warning');
		}
	}

	function collectConflicts(board) {
		const conflicts = new Set();

		function scan(group) {
			const seen = {};

			group.forEach(function (index) {
				const value = board[index];
				if (!value || value === '0') {
					return;
				}
				if (!seen[value]) {
					seen[value] = [];
				}
				seen[value].push(index);
			});

			Object.keys(seen).forEach(function (value) {
				if (seen[value].length > 1) {
					seen[value].forEach(function (index) {
						conflicts.add(index);
					});
				}
			});
		}

		for (let row = 0; row < 9; row += 1) {
			scan(Array.from({ length: 9 }, function (_, col) {
				return row * 9 + col;
			}));
		}

		for (let col = 0; col < 9; col += 1) {
			scan(Array.from({ length: 9 }, function (_, row) {
				return row * 9 + col;
			}));
		}

		for (let boxRow = 0; boxRow < 3; boxRow += 1) {
			for (let boxCol = 0; boxCol < 3; boxCol += 1) {
				const group = [];
				for (let row = 0; row < 3; row += 1) {
					for (let col = 0; col < 3; col += 1) {
						group.push((boxRow * 3 + row) * 9 + (boxCol * 3 + col));
					}
				}
				scan(group);
			}
		}

		return conflicts;
	}

	games.forEach(function (game) {
		const boardEl = game.querySelector('[data-role="board"]');
		const keypadEl = game.querySelector('[data-role="keypad"]');
		const difficultyEl = game.querySelector('[data-role="difficulty"]');
		const filledEl = game.querySelector('[data-role="filled"]');
		const mistakesEl = game.querySelector('[data-role="mistakes"]');
		const timerEl = game.querySelector('[data-role="timer"]');
		const statusEl = game.querySelector('[data-role="status"]');
		const newBtn = game.querySelector('[data-action="new"]');
		const resetBtn = game.querySelector('[data-action="reset"]');
		const checkBtn = game.querySelector('[data-action="check"]');
		const hintBtn = game.querySelector('[data-action="hint"]');

		let board = [];
		let startBoard = [];
		let solution = [];
		let selectedIndex = -1;
		let mistakes = 0;
		let seconds = 0;
		let timerId = null;
		let solved = false;
		const usedByLevel = {
			easy: [],
			medium: [],
			hard: []
		};

		function startTimer() {
			window.clearInterval(timerId);
			timerId = window.setInterval(function () {
				seconds += 1;
				timerEl.textContent = formatTime(seconds);
			}, 1000);
		}

		function updateStats() {
			const filled = board.filter(function (value) {
				return value !== '0';
			}).length;
			filledEl.textContent = filled + ' / 81';
			mistakesEl.textContent = String(mistakes);
		}

		function renderSelection() {
			const selectedRow = selectedIndex >= 0 ? Math.floor(selectedIndex / 9) : -1;
			const selectedCol = selectedIndex >= 0 ? selectedIndex % 9 : -1;
			const selectedBox = selectedIndex >= 0 ? getBoxIndex(selectedRow, selectedCol) : -1;
			const conflicts = collectConflicts(board);

			Array.from(boardEl.children).forEach(function (cell, index) {
				const row = Math.floor(index / 9);
				const col = index % 9;
				const value = board[index] === '0' ? '' : board[index];

				cell.textContent = value;
				cell.classList.toggle('is-selected', index === selectedIndex);
				cell.classList.toggle(
					'is-related',
					selectedIndex >= 0 && index !== selectedIndex && (row === selectedRow || col === selectedCol || getBoxIndex(row, col) === selectedBox)
				);
				cell.classList.toggle('is-conflict', conflicts.has(index));
				cell.classList.remove('is-wrong');
			});
		}

		function markWrongCells() {
			let wrongCount = 0;

			Array.from(boardEl.children).forEach(function (cell, index) {
				const value = board[index];
				const wrong = value !== '0' && value !== solution[index];
				cell.classList.toggle('is-wrong', wrong);
				if (wrong) {
					wrongCount += 1;
				}
			});

			return wrongCount;
		}

		function checkWin() {
			const done = board.every(function (value, index) {
				return value === solution[index];
			});

			if (!done || solved) {
				return;
			}

			solved = true;
			window.clearInterval(timerId);
			setStatus(statusEl, 'Puzzle solved. Every row, column, and box is correct.', 'success');
		}

		function applyValue(rawValue) {
			if (selectedIndex < 0 || solved) {
				return;
			}

			const cell = boardEl.children[selectedIndex];
			if (!cell || cell.dataset.given === '1') {
				return;
			}

			const value = String(rawValue);
			if (!/^[0-9]$/.test(value)) {
				return;
			}

			board[selectedIndex] = value === '0' ? '0' : value;
			renderSelection();
			updateStats();

			if (value === '0') {
				setStatus(statusEl, 'Square cleared.', '');
			} else {
				setStatus(statusEl, 'Placed ' + value + '. Keep each row, column, and 3x3 box unique.', '');
			}

			checkWin();
		}

		function buildBoard() {
			boardEl.innerHTML = '';

			for (let index = 0; index < 81; index += 1) {
				const row = Math.floor(index / 9);
				const col = index % 9;
				const button = document.createElement('button');
				button.type = 'button';
				button.className = 'zo-sudoku__cell';
				button.dataset.index = String(index);
				button.dataset.row = String(row);
				button.dataset.col = String(col);
				button.dataset.given = startBoard[index] === '0' ? '0' : '1';

				if (startBoard[index] !== '0') {
					button.classList.add('is-given');
					button.textContent = startBoard[index];
				}

				button.addEventListener('click', function () {
					selectedIndex = index;
					renderSelection();
				});

				boardEl.appendChild(button);
			}

			renderSelection();
		}

		function loadPuzzle() {
			const level = difficultyEl.value;
			const selection = pickPuzzle(level, usedByLevel[level]);
			usedByLevel[level].push(selection.index);
			if (usedByLevel[level].length > (puzzleBank[level] || []).length) {
				usedByLevel[level].shift();
			}

			startBoard = toCells(selection.data.puzzle);
			solution = toCells(selection.data.solution);
			board = startBoard.slice();
			selectedIndex = -1;
			mistakes = 0;
			seconds = 0;
			solved = false;
			timerEl.textContent = '00:00';
			setStatus(statusEl, 'New ' + level + ' puzzle ready. Choose an empty square to begin.', '');
			buildBoard();
			updateStats();
			startTimer();
		}

		function resetPuzzle() {
			board = startBoard.slice();
			selectedIndex = -1;
			solved = false;
			renderSelection();
			updateStats();
			setStatus(statusEl, 'Puzzle reset to the starting clues.', '');
		}

		keypadEl.addEventListener('click', function (event) {
			const key = event.target.closest('[data-value]');
			if (!key) {
				return;
			}
			applyValue(key.dataset.value || '0');
		});

		game.addEventListener('keydown', function (event) {
			if (selectedIndex < 0) {
				return;
			}

			if (/^[1-9]$/.test(event.key)) {
				event.preventDefault();
				applyValue(event.key);
				return;
			}

			if (event.key === 'Backspace' || event.key === 'Delete' || event.key === '0') {
				event.preventDefault();
				applyValue('0');
				return;
			}

			if (event.key === 'ArrowUp' && selectedIndex >= 9) {
				event.preventDefault();
				selectedIndex -= 9;
				renderSelection();
			} else if (event.key === 'ArrowDown' && selectedIndex <= 71) {
				event.preventDefault();
				selectedIndex += 9;
				renderSelection();
			} else if (event.key === 'ArrowLeft' && selectedIndex % 9 !== 0) {
				event.preventDefault();
				selectedIndex -= 1;
				renderSelection();
			} else if (event.key === 'ArrowRight' && selectedIndex % 9 !== 8) {
				event.preventDefault();
				selectedIndex += 1;
				renderSelection();
			}
		});

		newBtn.addEventListener('click', loadPuzzle);
		resetBtn.addEventListener('click', resetPuzzle);
		checkBtn.addEventListener('click', function () {
			if (solved) {
				setStatus(statusEl, 'This puzzle is already solved.', 'success');
				return;
			}

			renderSelection();
			const wrongCount = markWrongCells();

			if (wrongCount > 0) {
				mistakes += wrongCount;
				updateStats();
				setStatus(statusEl, wrongCount + ' square(s) do not match the solution yet.', 'warning');
				return;
			}

			if (board.includes('0')) {
				setStatus(statusEl, 'So far so good. The remaining empty squares are still waiting.', '');
				return;
			}

			checkWin();
		});

		hintBtn.addEventListener('click', function () {
			if (solved) {
				setStatus(statusEl, 'You already solved it.', 'success');
				return;
			}

			let target = selectedIndex;
			if (target < 0 || startBoard[target] !== '0') {
				target = board.findIndex(function (value, index) {
					return value === '0' && startBoard[index] === '0';
				});
			}

			if (target < 0) {
				setStatus(statusEl, 'There are no empty squares left for a hint.', '');
				return;
			}

			board[target] = solution[target];
			selectedIndex = target;
			renderSelection();
			updateStats();
			setStatus(statusEl, 'Hint used: square filled with the correct number.', '');
			checkWin();
		});

		difficultyEl.addEventListener('change', loadPuzzle);

		if (!game.hasAttribute('tabindex')) {
			game.setAttribute('tabindex', '0');
		}

		loadPuzzle();
	});
});
