<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--sudoku { max-width: 1120px; margin: 0 auto; padding: 20px; box-sizing: border-box; font-family: "Trebuchet MS", "Segoe UI", sans-serif; color: #1d2a3a; }
.zo-game-root--sudoku .zo-sudoku { padding: 22px; border-radius: 28px; background: radial-gradient(circle at top left, rgba(255, 255, 255, 0.9), transparent 24%), linear-gradient(180deg, #eef7ff 0%, #d8ebff 100%); border: 1px solid #bfd7ef; box-shadow: 0 18px 40px rgba(36, 76, 120, 0.15); }
.zo-game-root--sudoku .zo-sudoku__hero { display: flex; flex-wrap: wrap; align-items: flex-start; justify-content: space-between; gap: 18px; margin-bottom: 18px; }
.zo-game-root--sudoku .zo-sudoku__eyebrow { margin: 0 0 6px; font-size: 12px; font-weight: 800; letter-spacing: 0.1em; text-transform: uppercase; color: #ab5a16; }
.zo-game-root--sudoku .zo-sudoku__title { margin: 0 0 8px; font-size: clamp(34px, 5vw, 48px); line-height: 0.95; }
.zo-game-root--sudoku .zo-sudoku__intro { max-width: 680px; margin: 0; font-size: 15px; line-height: 1.6; color: #45617d; }
.zo-game-root--sudoku .zo-sudoku__stats { display: grid; grid-template-columns: repeat(4, minmax(110px, 1fr)); gap: 12px; min-width: min(100%, 360px); }
.zo-game-root--sudoku .zo-sudoku__stat, .zo-game-root--sudoku .zo-sudoku__card, .zo-game-root--sudoku .zo-sudoku__board-panel { background: rgba(255, 255, 255, 0.82); border: 1px solid rgba(110, 148, 188, 0.22); border-radius: 20px; }
.zo-game-root--sudoku .zo-sudoku__stat { padding: 14px 16px; text-align: center; }
.zo-game-root--sudoku .zo-sudoku__stat-label { display: block; margin-bottom: 4px; font-size: 11px; font-weight: 800; letter-spacing: 0.08em; text-transform: uppercase; color: #64819d; }
.zo-game-root--sudoku .zo-sudoku__stat-value { font-size: 26px; line-height: 1; }
.zo-game-root--sudoku .zo-sudoku__toolbar { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 14px; margin-bottom: 18px; }
.zo-game-root--sudoku .zo-sudoku__difficulty-label { display: inline-flex; align-items: center; gap: 10px; font-weight: 700; color: #34516f; }
.zo-game-root--sudoku .zo-sudoku__difficulty { min-height: 42px; padding: 0 14px; border: 1px solid #b9cee3; border-radius: 999px; background: #fff; color: #1d2a3a; font: inherit; }
.zo-game-root--sudoku .zo-sudoku__actions { display: flex; flex-wrap: wrap; gap: 10px; }
.zo-game-root--sudoku .zo-sudoku__button, .zo-game-root--sudoku .zo-sudoku__key { border: 0; border-radius: 999px; background: #e4eef9; color: #1d2a3a; cursor: pointer; font: inherit; font-weight: 800; transition: transform 0.12s ease, background 0.12s ease, box-shadow 0.12s ease; }
.zo-game-root--sudoku .zo-sudoku__button { min-height: 44px; padding: 0 18px; }
.zo-game-root--sudoku .zo-sudoku__button:hover, .zo-game-root--sudoku .zo-sudoku__button:focus-visible, .zo-game-root--sudoku .zo-sudoku__key:hover, .zo-game-root--sudoku .zo-sudoku__key:focus-visible { transform: translateY(-1px); outline: none; box-shadow: 0 10px 20px rgba(49, 88, 130, 0.12); }
.zo-game-root--sudoku .zo-sudoku__button--primary { background: linear-gradient(180deg, #1f73c9 0%, #1459a0 100%); color: #fff; }
.zo-game-root--sudoku .zo-sudoku__button.is-active { background: linear-gradient(180deg, #1f7a5a 0%, #14543f 100%); color: #fff; }
.zo-game-root--sudoku .zo-sudoku__layout { display: grid; grid-template-columns: minmax(0, 1.4fr) minmax(280px, 0.8fr); gap: 18px; }
.zo-game-root--sudoku .zo-sudoku__board-panel { padding: 18px; }
.zo-game-root--sudoku .zo-sudoku__board { display: grid; grid-template-columns: repeat(9, minmax(0, 1fr)); width: min(100%, 620px); margin: 0 auto; border: 4px solid #284766; border-radius: 18px; overflow: hidden; background: #284766; }
.zo-game-root--sudoku .zo-sudoku__cell { position: relative; display: grid; place-items: center; aspect-ratio: 1 / 1; min-width: 0; border: 1px solid #acc7dc; background: #fbfdff; color: #203246; font-size: clamp(20px, 2.7vw, 30px); font-weight: 800; cursor: pointer; }
.zo-game-root--sudoku .zo-sudoku__cell.is-given { background: linear-gradient(180deg, #d8ecff 0%, #c7e2fa 100%); color: #113b63; cursor: default; }
.zo-game-root--sudoku .zo-sudoku__cell.is-noted { align-items: stretch; justify-content: stretch; padding: 4px; }
.zo-game-root--sudoku .zo-sudoku__cell.is-selected { background: #fff3c4; }
.zo-game-root--sudoku .zo-sudoku__cell.is-related { background: #edf6ff; }
.zo-game-root--sudoku .zo-sudoku__cell.is-given.is-related { background: linear-gradient(180deg, #d3e8fb 0%, #bdddf8 100%); }
.zo-game-root--sudoku .zo-sudoku__cell.is-conflict { background: #ffe0e0; color: #9a1f1f; }
.zo-game-root--sudoku .zo-sudoku__cell[data-col="2"], .zo-game-root--sudoku .zo-sudoku__cell[data-col="5"] { border-right: 3px solid #284766; }
.zo-game-root--sudoku .zo-sudoku__cell[data-row="2"], .zo-game-root--sudoku .zo-sudoku__cell[data-row="5"] { border-bottom: 3px solid #284766; }
.zo-game-root--sudoku .zo-sudoku__cell[data-col="2"][data-row="2"], .zo-game-root--sudoku .zo-sudoku__cell[data-col="5"][data-row="2"], .zo-game-root--sudoku .zo-sudoku__cell[data-col="2"][data-row="5"], .zo-game-root--sudoku .zo-sudoku__cell[data-col="5"][data-row="5"] { border-right: 3px solid #284766; border-bottom: 3px solid #284766; }
.zo-game-root--sudoku .zo-sudoku__notes { display: grid; grid-template-columns: repeat(3, 1fr); width: 100%; height: 100%; gap: 2px; align-items: center; justify-items: center; font-size: clamp(9px, 1.5vw, 12px); font-weight: 700; line-height: 1; color: #4e6882; }
.zo-game-root--sudoku .zo-sudoku__note { display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; }
.zo-game-root--sudoku .zo-sudoku__keypad { display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 10px; max-width: 600px; margin: 16px auto 0; }
.zo-game-root--sudoku .zo-sudoku__key { min-height: 48px; font-size: 18px; }
.zo-game-root--sudoku .zo-sudoku__key--wide { grid-column: span 2; }
.zo-game-root--sudoku .zo-sudoku__side { display: grid; gap: 14px; }
.zo-game-root--sudoku .zo-sudoku__card { padding: 18px; }
.zo-game-root--sudoku .zo-sudoku__card-title { margin: 0 0 10px; font-size: 18px; }
.zo-game-root--sudoku .zo-sudoku__rules { margin: 0; padding-left: 18px; color: #45617d; line-height: 1.6; }
.zo-game-root--sudoku .zo-sudoku__card-copy, .zo-game-root--sudoku .zo-sudoku__status { margin: 0; font-size: 15px; line-height: 1.6; color: #45617d; }
.zo-game-root--sudoku .zo-sudoku__status { padding: 16px 18px; border-radius: 18px; background: rgba(255, 255, 255, 0.82); border: 1px solid rgba(110, 148, 188, 0.22); font-weight: 700; }
.zo-game-root--sudoku .zo-sudoku__status.is-success { color: #166534; background: #ecfdf3; border-color: #9fd2b0; }
.zo-game-root--sudoku .zo-sudoku__status.is-warning { color: #9a3412; background: #fff7ed; border-color: #f2c59d; }
@media (max-width: 900px) { .zo-game-root--sudoku .zo-sudoku__layout { grid-template-columns: 1fr; } }
@media (max-width: 640px) { .zo-game-root.zo-game-root--sudoku { padding: 12px; } .zo-game-root--sudoku .zo-sudoku { padding: 14px; border-radius: 22px; } .zo-game-root--sudoku .zo-sudoku__stats { grid-template-columns: 1fr 1fr 1fr; min-width: 100%; } .zo-game-root--sudoku .zo-sudoku__board-panel { padding: 12px; } .zo-game-root--sudoku .zo-sudoku__keypad { gap: 8px; } }
CSS;

$js = <<<'JS'
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
			},
			{
				puzzle: '003020600900305001001806400008102900700000008006708200002609500800203009005010300',
				solution: '483921657967345821251876493548132976729564138136798245372689514814253769695417382'
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
			},
			{
				puzzle: '000158000002060800030000040027030510000000000046080790050000080004070100000325000',
				solution: '469158372712463859538297641927634518385719426146582793653941287294876135871325964'
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
				puzzle: '003502900000040000106000305900251008070408030800763001308000104000020000005104800',
				solution: '743512986589346217126987345934251768671498532852763491398675124417829653265134879'
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
		const bestTimeEl = game.querySelector('[data-role="best-time"]');
		const newBtn = game.querySelector('[data-action="new"]');
		const notesBtn = game.querySelector('[data-action="notes"]');
		const resetBtn = game.querySelector('[data-action="reset"]');
		const checkBtn = game.querySelector('[data-action="check"]');
		const hintBtn = game.querySelector('[data-action="hint"]');
		const undoBtn = game.querySelector('[data-action="undo"]');

		let board = [];
		let startBoard = [];
		let solution = [];
		let notes = [];
		let selectedIndex = -1;
		let mistakes = 0;
		let seconds = 0;
		let timerId = null;
		let solved = false;
		let noteMode = false;
		let history = [];
		let bestKey = '';
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

		function updateNotesButton() {
			notesBtn.textContent = noteMode ? 'Notes: On' : 'Notes: Off';
			notesBtn.classList.toggle('is-active', noteMode);
			notesBtn.setAttribute('aria-pressed', noteMode ? 'true' : 'false');
		}

		function renderCellContent(cell, index) {
			const value = board[index];
			const noteList = notes[index] || [];

			if (value !== '0') {
				cell.textContent = value;
				cell.classList.remove('is-noted');
				return;
			}

			if (!noteList.length) {
				cell.textContent = '';
				cell.classList.remove('is-noted');
				return;
			}

			const noteGrid = document.createElement('span');
			noteGrid.className = 'zo-sudoku__notes';

			for (let digit = 1; digit <= 9; digit += 1) {
				const note = document.createElement('span');
				note.className = 'zo-sudoku__note';
				note.textContent = noteList.includes(String(digit)) ? String(digit) : '';
				noteGrid.appendChild(note);
			}

			cell.replaceChildren(noteGrid);
			cell.classList.add('is-noted');
		}

		function renderSelection() {
			const selectedRow = selectedIndex >= 0 ? Math.floor(selectedIndex / 9) : -1;
			const selectedCol = selectedIndex >= 0 ? selectedIndex % 9 : -1;
			const selectedBox = selectedIndex >= 0 ? getBoxIndex(selectedRow, selectedCol) : -1;
			const conflicts = collectConflicts(board);

			Array.from(boardEl.children).forEach(function (cell, index) {
				const row = Math.floor(index / 9);
				const col = index % 9;

				renderCellContent(cell, index);
				cell.classList.toggle('is-selected', index === selectedIndex);
				cell.classList.toggle('is-related', selectedIndex >= 0 && index !== selectedIndex && (row === selectedRow || col === selectedCol || getBoxIndex(row, col) === selectedBox));
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

			const best = localStorage.getItem(bestKey);
			if (!best || seconds < parseInt(best, 10)) {
				localStorage.setItem(bestKey, String(seconds));
				bestTimeEl.textContent = formatTime(seconds);
			}
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

			if (noteMode) {
				if (board[selectedIndex] !== '0') {
					setStatus(statusEl, 'Clear the final number first if you want to add candidates to this square.', 'warning');
					return;
				}

				if (value === '0') {
					notes[selectedIndex] = [];
					renderSelection();
					setStatus(statusEl, 'Notes cleared from the selected square.', '');
					return;
				}

				const currentNotes = notes[selectedIndex] || [];
				if (currentNotes.includes(value)) {
					notes[selectedIndex] = currentNotes.filter(function (entry) {
						return entry !== value;
					});
					setStatus(statusEl, 'Candidate ' + value + ' removed from the selected square.', '');
				} else {
					notes[selectedIndex] = currentNotes.concat(value).sort();
					setStatus(statusEl, 'Candidate ' + value + ' added to the selected square.', '');
				}

				renderSelection();
				updateStats();
				return;
			}

			if (value !== board[selectedIndex]) {
				history.push({ index: selectedIndex, oldValue: board[selectedIndex], oldNotes: notes[selectedIndex].slice() });
			}

			board[selectedIndex] = value === '0' ? '0' : value;
			notes[selectedIndex] = [];
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

			bestKey = 'sudoku-best-' + level;
			const best = localStorage.getItem(bestKey);
			bestTimeEl.textContent = best ? formatTime(parseInt(best, 10)) : '--:--';

			startBoard = toCells(selection.data.puzzle);
			solution = toCells(selection.data.solution);
			board = startBoard.slice();
			notes = Array.from({ length: 81 }, function () { return []; });
			selectedIndex = -1;
			mistakes = 0;
			seconds = 0;
			solved = false;
			history = [];
			noteMode = false;
			timerEl.textContent = '00:00';
			setStatus(statusEl, 'New ' + level + ' puzzle ready. Choose an empty square to begin.', '');
			updateNotesButton();
			buildBoard();
			updateStats();
			startTimer();
		}

		function resetPuzzle() {
			board = startBoard.slice();
			notes = Array.from({ length: 81 }, function () { return []; });
			selectedIndex = -1;
			solved = false;
			history = [];
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
		notesBtn.addEventListener('click', function () {
			noteMode = !noteMode;
			updateNotesButton();
			setStatus(statusEl, noteMode ? 'Notes mode is on. Added numbers will appear as small candidates.' : 'Notes mode is off. Added numbers will be final answers.', '');
		});
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

			history.push({ index: target, oldValue: board[target], oldNotes: notes[target].slice() });

			board[target] = solution[target];
			notes[target] = [];
			selectedIndex = target;
			renderSelection();
			updateStats();
			setStatus(statusEl, 'Hint used: square filled with the correct number.', '');
			checkWin();
		});

		undoBtn.addEventListener('click', function () {
			if (solved) {
				setStatus(statusEl, 'Cannot undo after solving.', '');
				return;
			}

			if (history.length === 0) {
				setStatus(statusEl, 'No moves to undo.', '');
				return;
			}

			const last = history.pop();
			board[last.index] = last.oldValue;
			notes[last.index] = last.oldNotes;
			selectedIndex = last.index;
			renderSelection();
			updateStats();
			setStatus(statusEl, 'Undid the last move.', '');
		});

		if (!game.hasAttribute('tabindex')) {
			game.setAttribute('tabindex', '0');
		}

		loadPuzzle();
	});
});
JS;

if (!function_exists('zo_game_sudoku_render')) {
	function zo_game_sudoku_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-sudoku-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--sudoku" id="<?php echo esc_attr($instance_id); ?>" data-game="sudoku">
			<div class="zo-sudoku">
				<div class="zo-sudoku__hero">
					<div>
						<p class="zo-sudoku__eyebrow">Asker's Puzzle</p>
						<h3 class="zo-sudoku__title">Sudoku</h3>
						<p class="zo-sudoku__intro">
							Fill the 9x9 board so every row, every column, and every 3x3 box contains the numbers 1-9 exactly once.
						</p>
					</div>

					<div class="zo-sudoku__stats">
						<div class="zo-sudoku__stat">
							<span class="zo-sudoku__stat-label">Filled</span>
							<strong class="zo-sudoku__stat-value" data-role="filled">0 / 81</strong>
						</div>
						<div class="zo-sudoku__stat">
							<span class="zo-sudoku__stat-label">Mistakes</span>
							<strong class="zo-sudoku__stat-value" data-role="mistakes">0</strong>
						</div>
						<div class="zo-sudoku__stat">
							<span class="zo-sudoku__stat-label">Time</span>
							<strong class="zo-sudoku__stat-value" data-role="timer">00:00</strong>
						</div>
						<div class="zo-sudoku__stat">
							<span class="zo-sudoku__stat-label">Best Time</span>
							<strong class="zo-sudoku__stat-value" data-role="best-time">--:--</strong>
						</div>
					</div>
				</div>

				<div class="zo-sudoku__toolbar">
					<label class="zo-sudoku__difficulty-label">
						<span>Difficulty</span>
						<select class="zo-sudoku__difficulty" data-role="difficulty">
							<option value="easy">Easy</option>
							<option value="medium">Medium</option>
							<option value="hard">Hard</option>
						</select>
					</label>

					<div class="zo-sudoku__actions">
						<button type="button" class="zo-sudoku__button zo-sudoku__button--primary" data-action="new">New Puzzle</button>
						<button type="button" class="zo-sudoku__button" data-action="notes" aria-pressed="false">Notes: Off</button>
						<button type="button" class="zo-sudoku__button" data-action="reset">Reset</button>
						<button type="button" class="zo-sudoku__button" data-action="check">Check</button>
						<button type="button" class="zo-sudoku__button" data-action="hint">Hint</button>
						<button type="button" class="zo-sudoku__button" data-action="undo">Undo</button>
					</div>
				</div>

				<div class="zo-sudoku__layout">
					<div class="zo-sudoku__board-panel">
						<div class="zo-sudoku__board" data-role="board" aria-label="Sudoku board"></div>

						<div class="zo-sudoku__keypad" data-role="keypad" aria-label="Sudoku number pad">
							<button type="button" class="zo-sudoku__key" data-value="1">1</button>
							<button type="button" class="zo-sudoku__key" data-value="2">2</button>
							<button type="button" class="zo-sudoku__key" data-value="3">3</button>
							<button type="button" class="zo-sudoku__key" data-value="4">4</button>
							<button type="button" class="zo-sudoku__key" data-value="5">5</button>
							<button type="button" class="zo-sudoku__key" data-value="6">6</button>
							<button type="button" class="zo-sudoku__key" data-value="7">7</button>
							<button type="button" class="zo-sudoku__key" data-value="8">8</button>
							<button type="button" class="zo-sudoku__key" data-value="9">9</button>
							<button type="button" class="zo-sudoku__key zo-sudoku__key--wide" data-value="0">Erase</button>
						</div>
					</div>

					<div class="zo-sudoku__side">
						<div class="zo-sudoku__card">
							<h4 class="zo-sudoku__card-title">Rules</h4>
							<ul class="zo-sudoku__rules">
								<li>Each row must contain 1-9 once.</li>
								<li>Each column must contain 1-9 once.</li>
								<li>Each 3x3 box must contain 1-9 once.</li>
								<li>Blue numbers are fixed clues and cannot be changed.</li>
							</ul>
						</div>

						<div class="zo-sudoku__card">
							<h4 class="zo-sudoku__card-title">How To Play</h4>
							<p class="zo-sudoku__card-copy">
								Click a blank square, then type on your keyboard or use the number pad. Turn notes on to write small candidate numbers before choosing the final answer.
							</p>
						</div>

						<div class="zo-sudoku__status" data-role="status" aria-live="polite">
							Choose a square and start solving.
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php

		return ob_get_clean();
	}
}

return array(
	'slug'            => 'sudoku',
	'name'            => 'Sudoku',
	'author'          => 'Asker',
	'description'     => 'A classic 9x9 Sudoku puzzle with easy, medium, and hard boards.',
	'render_callback' => 'zo_game_sudoku_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
