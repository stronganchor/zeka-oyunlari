<?php

if (!defined('ABSPATH')) {
	exit;
}

$inline_style = <<<'CSS'
.zo-game-root--ogretmenden-kac * {
	box-sizing: border-box;
}

.zo-game-root--ogretmenden-kac {
	max-width: 1040px;
	margin: 0 auto;
	padding: 16px;
	font-family: Arial, sans-serif;
	color: #1f2937;
}

.zo-game-root--ogretmenden-kac .zo-ok-wrap {
	background: #ffffff;
	border: 1px solid #dbe3ea;
	border-radius: 22px;
	padding: 18px;
	box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
}

.zo-game-root--ogretmenden-kac .zo-ok-title {
	margin: 0 0 8px;
	text-align: center;
	font-size: 32px;
	line-height: 1.2;
	color: #0f172a;
}

.zo-game-root--ogretmenden-kac .zo-ok-subtitle {
	margin: 0 0 18px;
	text-align: center;
	font-size: 15px;
	line-height: 1.5;
	color: #475569;
}

.zo-game-root--ogretmenden-kac .zo-ok-topbar {
	display: flex;
	flex-wrap: wrap;
	gap: 12px;
	justify-content: space-between;
	align-items: center;
	margin-bottom: 16px;
}

.zo-game-root--ogretmenden-kac .zo-ok-stats {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
}

.zo-game-root--ogretmenden-kac .zo-ok-stat {
	background: #f3f6fa;
	border: 1px solid #dbe3ea;
	border-radius: 12px;
	padding: 10px 14px;
	font-size: 14px;
	font-weight: 700;
}

.zo-game-root--ogretmenden-kac .zo-ok-controls {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	align-items: center;
}

.zo-game-root--ogretmenden-kac .zo-ok-button,
.zo-game-root--ogretmenden-kac .zo-ok-select {
	border-radius: 12px;
	border: 1px solid #cfd8e3;
	font-size: 15px;
	font: inherit;
}

.zo-game-root--ogretmenden-kac .zo-ok-button {
	padding: 10px 16px;
	font-weight: 700;
	cursor: pointer;
	background: #2563eb;
	color: #ffffff;
	border-color: #2563eb;
}

.zo-game-root--ogretmenden-kac .zo-ok-button--secondary {
	background: #ef4444;
	border-color: #ef4444;
}

.zo-game-root--ogretmenden-kac .zo-ok-select {
	padding: 10px 12px;
	background: #ffffff;
	color: #1f2937;
}

.zo-game-root--ogretmenden-kac .zo-ok-layout {
	display: grid;
	grid-template-columns: 1fr 300px;
	gap: 16px;
}

.zo-game-root--ogretmenden-kac .zo-ok-board-wrap {
	position: relative;
	background: #f8fafc;
	border: 1px solid #dbe3ea;
	border-radius: 18px;
	padding: 12px;
}

.zo-game-root--ogretmenden-kac .zo-ok-canvas {
	display: block;
	width: 100%;
	max-width: 100%;
	height: auto;
	background: #f8fafc;
	border: 1px solid #cfd8e3;
	border-radius: 14px;
	outline: none;
	touch-action: none;
}

.zo-game-root--ogretmenden-kac .zo-ok-side {
	background: #f8fafc;
	border: 1px solid #dbe3ea;
	border-radius: 18px;
	padding: 14px;
}

.zo-game-root--ogretmenden-kac .zo-ok-side h3 {
	margin: 0 0 10px;
	font-size: 18px;
}

.zo-game-root--ogretmenden-kac .zo-ok-side p,
.zo-game-root--ogretmenden-kac .zo-ok-side li {
	font-size: 14px;
	line-height: 1.5;
	color: #4b5563;
}

.zo-game-root--ogretmenden-kac .zo-ok-side ul {
	margin: 0 0 14px;
	padding-left: 18px;
}

.zo-game-root--ogretmenden-kac .zo-ok-message {
	margin-top: 12px;
	padding: 12px 14px;
	border-radius: 12px;
	background: #eff6ff;
	border: 1px solid #bfdbfe;
	font-size: 14px;
	font-weight: 700;
	color: #1d4ed8;
	min-height: 46px;
}

.zo-game-root--ogretmenden-kac .zo-ok-touch {
	display: none;
	margin-top: 14px;
	grid-template-columns: repeat(3, 64px);
	grid-template-rows: repeat(2, 64px);
	gap: 8px;
	justify-content: center;
}

.zo-game-root--ogretmenden-kac .zo-ok-touch-btn {
	border: 1px solid #cfd8e3;
	border-radius: 14px;
	background: #ffffff;
	font-size: 24px;
	font-weight: 700;
	cursor: pointer;
	user-select: none;
}

.zo-game-root--ogretmenden-kac .zo-ok-touch-btn[data-dir="up"] {
	grid-column: 2;
	grid-row: 1;
}

.zo-game-root--ogretmenden-kac .zo-ok-touch-btn[data-dir="left"] {
	grid-column: 1;
	grid-row: 2;
}

.zo-game-root--ogretmenden-kac .zo-ok-touch-btn[data-dir="down"] {
	grid-column: 2;
	grid-row: 2;
}

.zo-game-root--ogretmenden-kac .zo-ok-touch-btn[data-dir="right"] {
	grid-column: 3;
	grid-row: 2;
}

.zo-game-root--ogretmenden-kac .zo-ok-quiz {
	position: absolute;
	inset: 24px;
	display: none;
	align-items: center;
	justify-content: center;
	background: rgba(15, 23, 42, 0.45);
	border-radius: 18px;
	z-index: 5;
}

.zo-game-root--ogretmenden-kac .zo-ok-quiz.is-visible {
	display: flex;
}

.zo-game-root--ogretmenden-kac .zo-ok-quiz-card {
	width: min(520px, 100%);
	background: #ffffff;
	border: 1px solid #dbe3ea;
	border-radius: 18px;
	padding: 18px;
	box-shadow: 0 10px 24px rgba(0, 0, 0, 0.18);
}

.zo-game-root--ogretmenden-kac .zo-ok-quiz-title {
	margin: 0 0 8px;
	font-size: 24px;
	text-align: center;
	color: #0f172a;
}

.zo-game-root--ogretmenden-kac .zo-ok-quiz-question {
	margin: 0 0 14px;
	text-align: center;
	font-size: 20px;
	font-weight: 800;
	color: #1e293b;
}

.zo-game-root--ogretmenden-kac .zo-ok-quiz-grid {
	display: grid;
	grid-template-columns: 1fr;
	gap: 10px;
}

.zo-game-root--ogretmenden-kac .zo-ok-answer-btn {
	padding: 12px 14px;
	border: 1px solid #cfd8e3;
	border-radius: 12px;
	background: #ffffff;
	font: inherit;
	font-size: 16px;
	font-weight: 700;
	cursor: pointer;
	text-align: center;
}

.zo-game-root--ogretmenden-kac .zo-ok-answer-btn:hover,
.zo-game-root--ogretmenden-kac .zo-ok-answer-btn:focus {
	outline: none;
	background: #eff6ff;
	border-color: #93c5fd;
}

.zo-game-root--ogretmenden-kac .zo-ok-status-pill {
	display: inline-block;
	margin-top: 10px;
	padding: 6px 10px;
	border-radius: 999px;
	font-size: 12px;
	font-weight: 700;
	background: #f1f5f9;
	color: #334155;
}

@media (max-width: 900px) {
	.zo-game-root--ogretmenden-kac .zo-ok-layout {
		grid-template-columns: 1fr;
	}

	.zo-game-root--ogretmenden-kac .zo-ok-touch {
		display: grid;
	}
}

@media (max-width: 640px) {
	.zo-game-root--ogretmenden-kac {
		padding: 10px;
	}

	.zo-game-root--ogretmenden-kac .zo-ok-wrap {
		padding: 12px;
	}

	.zo-game-root--ogretmenden-kac .zo-ok-title {
		font-size: 26px;
	}
}
CSS;

$inline_script = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const roots = document.querySelectorAll('.zo-game-root--ogretmenden-kac');

	roots.forEach(function (root) {
		const canvas = root.querySelector('.zo-ok-canvas');
		if (!canvas) {
			return;
		}

		const ctx = canvas.getContext('2d');
		const levelSelect = root.querySelector('.zo-ok-select');
		const startButton = root.querySelector('.zo-ok-start');
		const restartButton = root.querySelector('.zo-ok-restart');
		const scoreEl = root.querySelector('.zo-ok-score');
		const timeEl = root.querySelector('.zo-ok-time');
		const levelEl = root.querySelector('.zo-ok-level');
		const bestEl = root.querySelector('.zo-ok-best');
		const messageEl = root.querySelector('.zo-ok-message');
		const touchButtons = root.querySelectorAll('.zo-ok-touch-btn');

		const quizWrap = root.querySelector('.zo-ok-quiz');
		const quizQuestionEl = root.querySelector('.zo-ok-quiz-question');
		const answerButtons = root.querySelectorAll('.zo-ok-answer-btn');

		const WIDTH = 760;
		const HEIGHT = 500;
		const CELL = 40;
		const COLS = Math.floor(WIDTH / CELL);
		const ROWS = Math.floor(HEIGHT / CELL);

		const questions = [
			{ q: '5 + 3 = ?', correct: '8', wrong: ['7', '9'] },
			{ q: '10 - 4 = ?', correct: '6', wrong: ['5', '7'] },
			{ q: '6 + 2 = ?', correct: '8', wrong: ['9', '7'] },
			{ q: '9 - 3 = ?', correct: '6', wrong: ['7', '5'] },
			{ q: '4 + 4 = ?', correct: '8', wrong: ['6', '9'] },
			{ q: '12 - 5 = ?', correct: '7', wrong: ['6', '8'] },
			{ q: '3 x 3 = ?', correct: '9', wrong: ['6', '8'] },
			{ q: '2 x 4 = ?', correct: '8', wrong: ['6', '10'] }
		];

		const config = {
			easy: {
				label: 'Kolay',
				teacherSpeed: 1.45,
				playerSpeed: 2.55,
				deskCount: 14,
				questionEvery: 11
			},
			medium: {
				label: 'Orta',
				teacherSpeed: 1.8,
				playerSpeed: 2.55,
				deskCount: 18,
				questionEvery: 9
			},
			hard: {
				label: 'Zor',
				teacherSpeed: 2.2,
				playerSpeed: 2.6,
				deskCount: 22,
				questionEvery: 7
			}
		};

		const state = {
			running: false,
			gameOver: false,
			score: 0,
			survivalTime: 0,
			best: 0,
			lastTime: 0,
			levelKey: 'easy',
			player: null,
			teacher: null,
			keys: {
				up: false,
				down: false,
				left: false,
				right: false
			},
			desks: [],
			books: [],
			speedBoostTicks: 0,
			teacherAngryTicks: 0,
			safeTicks: 0,
			nextQuestionAt: 11,
			quizActive: false,
			currentQuestion: null
		};

		try {
			const savedBest = parseInt(localStorage.getItem('zo_ogretmenden_kac_best') || '0', 10);
			if (!isNaN(savedBest) && savedBest > 0) {
				state.best = savedBest;
			}
		} catch (e) {}

		function randInt(min, max) {
			return Math.floor(Math.random() * (max - min + 1)) + min;
		}

		function shuffleArray(arr) {
			const a = arr.slice();
			for (let i = a.length - 1; i > 0; i--) {
				const j = Math.floor(Math.random() * (i + 1));
				const t = a[i];
				a[i] = a[j];
				a[j] = t;
			}
			return a;
		}

		function clamp(value, min, max) {
			return Math.max(min, Math.min(max, value));
		}

		function gridToPixel(cellX, cellY) {
			return {
				x: cellX * CELL,
				y: cellY * CELL
			};
		}

		function updateStats() {
			scoreEl.textContent = String(state.score);
			timeEl.textContent = state.survivalTime.toFixed(1) + ' sn';
			levelEl.textContent = config[state.levelKey].label;
			bestEl.textContent = String(state.best);
		}

		function setMessage(text) {
			messageEl.textContent = text;
		}

		function isBlockedCell(cx, cy) {
			if (cx < 0 || cy < 0 || cx >= COLS || cy >= ROWS) {
				return true;
			}

			for (let i = 0; i < state.desks.length; i++) {
				if (state.desks[i].cx === cx && state.desks[i].cy === cy) {
					return true;
				}
			}

			return false;
		}

		function randomFreeCell(avoidList) {
			let tries = 0;

			while (tries < 800) {
				const cx = randInt(0, COLS - 1);
				const cy = randInt(0, ROWS - 1);

				if (isBlockedCell(cx, cy)) {
					tries++;
					continue;
				}

				let blocked = false;
				for (let i = 0; i < avoidList.length; i++) {
					if (avoidList[i].cx === cx && avoidList[i].cy === cy) {
						blocked = true;
						break;
					}
				}

				if (!blocked) {
					return {cx: cx, cy: cy};
				}

				tries++;
			}

			return {cx: 1, cy: 1};
		}

		function buildDesks() {
			state.desks = [];
			const count = config[state.levelKey].deskCount;
			let tries = 0;

			while (state.desks.length < count && tries < 2200) {
				const cx = randInt(1, COLS - 2);
				const cy = randInt(1, ROWS - 2);

				const nearStart =
					(cx <= 3 && cy <= 3) ||
					(cx >= COLS - 4 && cy >= ROWS - 4);

				if (nearStart) {
					tries++;
					continue;
				}

				let bad = false;
				for (let i = 0; i < state.desks.length; i++) {
					const d = state.desks[i];
					if (Math.abs(d.cx - cx) <= 1 && Math.abs(d.cy - cy) <= 1) {
						bad = true;
						break;
					}
				}

				if (!bad) {
					state.desks.push({cx: cx, cy: cy});
				}

				tries++;
			}
		}

		function buildBooks() {
			state.books = [];
			for (let i = 0; i < 5; i++) {
				const cell = randomFreeCell(state.desks.concat([
					{cx: state.player.cx, cy: state.player.cy},
					{cx: state.teacher.cx, cy: state.teacher.cy}
				], state.books));
				state.books.push({
					cx: cell.cx,
					cy: cell.cy
				});
			}
		}

		function createCharacters() {
			state.player = {
				cx: 1,
				cy: 1,
				x: CELL + 4,
				y: CELL + 4,
				size: CELL - 8,
				baseSpeed: config[state.levelKey].playerSpeed
			};

			state.teacher = {
				cx: COLS - 2,
				cy: ROWS - 2,
				x: (COLS - 2) * CELL + 4,
				y: (ROWS - 2) * CELL + 4,
				size: CELL - 8,
				speed: config[state.levelKey].teacherSpeed
			};
		}

		function resetGame() {
			state.levelKey = levelSelect.value in config ? levelSelect.value : 'easy';
			state.running = false;
			state.gameOver = false;
			state.score = 0;
			state.survivalTime = 0;
			state.lastTime = 0;
			state.speedBoostTicks = 0;
			state.teacherAngryTicks = 0;
			state.safeTicks = 0;
			state.quizActive = false;
			state.currentQuestion = null;
			state.nextQuestionAt = config[state.levelKey].questionEvery;

			buildDesks();
			createCharacters();
			buildBooks();

			hideQuiz();
			updateStats();
			setMessage('Başlamak için "Oyunu Başlat" düğmesine bas.');
			draw();
		}

		function startGame() {
			state.levelKey = levelSelect.value in config ? levelSelect.value : 'easy';
			state.running = true;
			state.gameOver = false;
			state.score = 0;
			state.survivalTime = 0;
			state.lastTime = performance.now();
			state.speedBoostTicks = 0;
			state.teacherAngryTicks = 0;
			state.safeTicks = 0;
			state.quizActive = false;
			state.currentQuestion = null;
			state.nextQuestionAt = config[state.levelKey].questionEvery;

			buildDesks();
			createCharacters();
			buildBooks();

			hideQuiz();
			updateStats();
			setMessage('Öğretmenden kaç. Kitap topla.');
			requestAnimationFrame(loop);
		}

		function endGame() {
			state.running = false;
			state.gameOver = true;
			hideQuiz();

			if (state.score > state.best) {
				state.best = state.score;
				try {
					localStorage.setItem('zo_ogretmenden_kac_best', String(state.best));
				} catch (e) {}
			}

			updateStats();
			setMessage('Yakalandın. Skorun: ' + state.score + '.');
			draw();
		}

		function teacherCurrentSpeed() {
			let speed = config[state.levelKey].teacherSpeed;
			if (state.teacherAngryTicks > 0) {
				speed += 1.1;
			}
			if (state.safeTicks > 0) {
				speed -= 0.75;
			}
			return Math.max(0.8, speed);
		}

		function playerCurrentSpeed() {
			let speed = state.player.baseSpeed;
			if (state.speedBoostTicks > 0) {
				speed += 0.9;
			}
			if (state.safeTicks > 0) {
				speed += 0.25;
			}
			return speed;
		}

		function moveCharacterToward(obj, targetX, targetY, speed) {
			const dx = targetX - obj.x;
			const dy = targetY - obj.y;
			const dist = Math.sqrt(dx * dx + dy * dy);

			if (dist < 0.001) {
				return;
			}

			const step = Math.min(speed, dist);
			obj.x += (dx / dist) * step;
			obj.y += (dy / dist) * step;
		}

		function movePlayer() {
			let dx = 0;
			let dy = 0;

			if (state.keys.up) dy -= 1;
			if (state.keys.down) dy += 1;
			if (state.keys.left) dx -= 1;
			if (state.keys.right) dx += 1;

			if (dx === 0 && dy === 0) {
				return;
			}

			const speed = playerCurrentSpeed();
			const length = Math.sqrt(dx * dx + dy * dy);
			const nx = dx / length;
			const ny = dy / length;

			const nextX = state.player.x + nx * speed;
			const nextY = state.player.y + ny * speed;

			const future = {
				x: nextX,
				y: nextY,
				size: state.player.size
			};

			if (!rectHitsDesk(future)) {
				state.player.x = clamp(nextX, 0, WIDTH - state.player.size);
				state.player.y = clamp(nextY, 0, HEIGHT - state.player.size);
			}
		}

		function teacherTargetStep() {
			const teacherCell = {
				cx: Math.round(state.teacher.x / CELL),
				cy: Math.round(state.teacher.y / CELL)
			};

			const playerCell = {
				cx: Math.round(state.player.x / CELL),
				cy: Math.round(state.player.y / CELL)
			};

			const options = [
				{cx: teacherCell.cx + 1, cy: teacherCell.cy},
				{cx: teacherCell.cx - 1, cy: teacherCell.cy},
				{cx: teacherCell.cx, cy: teacherCell.cy + 1},
				{cx: teacherCell.cx, cy: teacherCell.cy - 1}
			];

			let best = null;
			let bestDist = Infinity;

			for (let i = 0; i < options.length; i++) {
				const opt = options[i];
				if (isBlockedCell(opt.cx, opt.cy)) {
					continue;
				}

				const d = Math.abs(opt.cx - playerCell.cx) + Math.abs(opt.cy - playerCell.cy);
				if (d < bestDist) {
					bestDist = d;
					best = opt;
				}
			}

			if (!best) {
				return teacherCell;
			}

			return best;
		}

		function moveTeacher() {
			const step = teacherTargetStep();
			const pixel = gridToPixel(step.cx, step.cy);
			moveCharacterToward(state.teacher, pixel.x + 4, pixel.y + 4, teacherCurrentSpeed());
		}

		function rectHitsDesk(rect) {
			for (let i = 0; i < state.desks.length; i++) {
				const d = state.desks[i];
				const dx = d.cx * CELL + 4;
				const dy = d.cy * CELL + 4;
				const dw = CELL - 8;
				const dh = CELL - 8;

				const hit = !(
					rect.x + rect.size <= dx ||
					rect.x >= dx + dw ||
					rect.y + rect.size <= dy ||
					rect.y >= dy + dh
				);

				if (hit) {
					return true;
				}
			}
			return false;
		}

		function collectBooks() {
			for (let i = state.books.length - 1; i >= 0; i--) {
				const b = state.books[i];
				const bx = b.cx * CELL + (CELL / 2);
				const by = b.cy * CELL + (CELL / 2);
				const px = state.player.x + state.player.size / 2;
				const py = state.player.y + state.player.size / 2;
				const dist = Math.sqrt((bx - px) * (bx - px) + (by - py) * (by - py));

				if (dist < 22) {
					state.books.splice(i, 1);
					state.score += 10;
					state.speedBoostTicks = 220;

					const newBookCell = randomFreeCell(
						state.desks.concat(
							state.books,
							[{cx: Math.round(state.player.x / CELL), cy: Math.round(state.player.y / CELL)}],
							[{cx: Math.round(state.teacher.x / CELL), cy: Math.round(state.teacher.y / CELL)}]
						)
					);

					state.books.push({
						cx: newBookCell.cx,
						cy: newBookCell.cy
					});
				}
			}
		}

		function checkCaught() {
			if (state.safeTicks > 0) {
				return;
			}

			const px = state.player.x + state.player.size / 2;
			const py = state.player.y + state.player.size / 2;
			const tx = state.teacher.x + state.teacher.size / 2;
			const ty = state.teacher.y + state.teacher.size / 2;
			const dist = Math.sqrt((px - tx) * (px - tx) + (py - ty) * (py - ty));

			if (dist < 28) {
				endGame();
			}
		}

		function showQuiz() {
			const q = questions[randInt(0, questions.length - 1)];
			const answers = shuffleArray([q.correct].concat(q.wrong));

			state.currentQuestion = {
				question: q.q,
				correct: q.correct,
				answers: answers
			};

			quizQuestionEl.textContent = q.q;
			answerButtons.forEach(function (btn, index) {
				btn.textContent = answers[index] || '';
				btn.setAttribute('data-answer', answers[index] || '');
			});

			quizWrap.classList.add('is-visible');
			state.quizActive = true;
			state.running = false;
			setMessage('Öğretmen soru soruyor.');
		}

		function hideQuiz() {
			quizWrap.classList.remove('is-visible');
			state.quizActive = false;
			state.currentQuestion = null;
		}

		function maybeAskQuestion() {
			if (state.quizActive || state.gameOver || !state.running) {
				return;
			}

			if (state.survivalTime >= state.nextQuestionAt) {
				showQuiz();
				state.nextQuestionAt += config[state.levelKey].questionEvery;
			}
		}

		function answerQuestion(answer) {
			if (!state.quizActive || !state.currentQuestion) {
				return;
			}

			if (answer === state.currentQuestion.correct) {
				state.safeTicks = 260;
				state.teacherAngryTicks = 0;
				hideQuiz();
				state.running = true;
				state.lastTime = performance.now();
				setMessage('Doğru. Kısa süre güvendesin.');
				requestAnimationFrame(loop);
			} else {
				state.teacherAngryTicks = 360;
				state.safeTicks = 0;
				hideQuiz();
				state.running = true;
				state.lastTime = performance.now();
				setMessage('Yanlış. Öğretmen çok kızdı.');
				requestAnimationFrame(loop);
			}
		}

		function update(delta) {
			movePlayer();
			moveTeacher();
			collectBooks();
			checkCaught();

			if (!state.running) {
				return;
			}

			state.survivalTime += delta;
			state.score = state.score + Math.floor(delta * 2);

			if (state.speedBoostTicks > 0) {
				state.speedBoostTicks -= 1;
			}

			if (state.teacherAngryTicks > 0) {
				state.teacherAngryTicks -= 1;
			}

			if (state.safeTicks > 0) {
				state.safeTicks -= 1;
			}

			maybeAskQuestion();
			updateStats();
		}

		function drawGrid() {
			ctx.save();
			ctx.strokeStyle = 'rgba(100,116,139,0.18)';
			ctx.lineWidth = 1;

			for (let x = 0; x <= WIDTH; x += CELL) {
				ctx.beginPath();
				ctx.moveTo(x, 0);
				ctx.lineTo(x, HEIGHT);
				ctx.stroke();
			}

			for (let y = 0; y <= HEIGHT; y += CELL) {
				ctx.beginPath();
				ctx.moveTo(0, y);
				ctx.lineTo(WIDTH, y);
				ctx.stroke();
			}

			ctx.restore();
		}

		function drawClassroom() {
			ctx.fillStyle = '#f8fafc';
			ctx.fillRect(0, 0, WIDTH, HEIGHT);

			ctx.fillStyle = '#d1fae5';
			ctx.fillRect(20, 20, 180, 70);

			ctx.fillStyle = '#065f46';
			ctx.fillRect(WIDTH - 220, 20, 180, 70);

			ctx.fillStyle = '#111827';
			ctx.font = 'bold 20px Arial';
			ctx.fillText('SINIF', 80, 62);
			ctx.fillText('TAHTA', WIDTH - 160, 62);
		}

		function drawDesks() {
			for (let i = 0; i < state.desks.length; i++) {
				const d = state.desks[i];
				const p = gridToPixel(d.cx, d.cy);

				ctx.fillStyle = '#c08457';
				ctx.fillRect(p.x + 4, p.y + 6, CELL - 8, CELL - 12);

				ctx.strokeStyle = '#7c2d12';
				ctx.lineWidth = 2;
				ctx.strokeRect(p.x + 4, p.y + 6, CELL - 8, CELL - 12);
			}
		}

		function drawBooks() {
			for (let i = 0; i < state.books.length; i++) {
				const b = state.books[i];
				const p = gridToPixel(b.cx, b.cy);

				ctx.fillStyle = '#f59e0b';
				ctx.fillRect(p.x + 11, p.y + 11, 18, 16);

				ctx.fillStyle = '#ffffff';
				ctx.fillRect(p.x + 15, p.y + 13, 10, 2);
				ctx.fillRect(p.x + 15, p.y + 17, 10, 2);
				ctx.fillRect(p.x + 15, p.y + 21, 10, 2);
			}
		}

		function drawPlayer() {
			ctx.save();
			ctx.fillStyle = '#2563eb';
			ctx.fillRect(state.player.x, state.player.y, state.player.size, state.player.size);

			ctx.fillStyle = '#ffffff';
			ctx.fillRect(state.player.x + 8, state.player.y + 8, 5, 5);
			ctx.fillRect(state.player.x + 19, state.player.y + 8, 5, 5);

			ctx.fillStyle = '#111827';
			ctx.fillRect(state.player.x + 9, state.player.y + 20, 14, 3);

			if (state.speedBoostTicks > 0) {
				ctx.strokeStyle = '#22c55e';
				ctx.lineWidth = 3;
				ctx.strokeRect(state.player.x - 2, state.player.y - 2, state.player.size + 4, state.player.size + 4);
			}

			if (state.safeTicks > 0) {
				ctx.strokeStyle = '#06b6d4';
				ctx.lineWidth = 3;
				ctx.strokeRect(state.player.x - 5, state.player.y - 5, state.player.size + 10, state.player.size + 10);
			}
			ctx.restore();
		}

		function drawTeacher() {
			ctx.save();
			ctx.fillStyle = state.teacherAngryTicks > 0 ? '#991b1b' : '#ef4444';
			ctx.fillRect(state.teacher.x, state.teacher.y, state.teacher.size, state.teacher.size);

			ctx.fillStyle = '#ffffff';
			ctx.fillRect(state.teacher.x + 8, state.teacher.y + 8, 5, 5);
			ctx.fillRect(state.teacher.x + 19, state.teacher.y + 8, 5, 5);

			ctx.fillStyle = '#111827';
			ctx.fillRect(state.teacher.x + 7, state.teacher.y + 20, 18, 4);

			ctx.fillStyle = '#111827';
			ctx.font = 'bold 12px Arial';
			ctx.fillText('Ö', state.teacher.x + 11, state.teacher.y + 34);

			if (state.teacherAngryTicks > 0) {
				ctx.fillStyle = '#dc2626';
				ctx.font = 'bold 16px Arial';
				ctx.fillText('!', state.teacher.x + 14, state.teacher.y - 4);
			}
			ctx.restore();
		}

		function drawOverlay() {
			if (state.running) {
				return;
			}

			if (state.quizActive) {
				return;
			}

			ctx.save();
			ctx.fillStyle = 'rgba(15,23,42,0.12)';
			ctx.fillRect(0, 0, WIDTH, HEIGHT);

			ctx.fillStyle = '#0f172a';
			ctx.textAlign = 'center';

			if (state.gameOver) {
				ctx.font = 'bold 38px Arial';
				ctx.fillText('Yakalandın', WIDTH / 2, HEIGHT / 2 - 10);
				ctx.font = 'bold 20px Arial';
				ctx.fillText('Skor: ' + state.score, WIDTH / 2, HEIGHT / 2 + 24);
			} else {
				ctx.font = 'bold 34px Arial';
				ctx.fillText('Öğretmenden Kaç', WIDTH / 2, HEIGHT / 2 - 10);
				ctx.font = 'bold 18px Arial';
				ctx.fillText('Başlamak için düğmeye bas', WIDTH / 2, HEIGHT / 2 + 24);
			}

			ctx.restore();
		}

		function draw() {
			drawClassroom();
			drawGrid();
			drawDesks();
			drawBooks();
			drawTeacher();
			drawPlayer();
			drawOverlay();
		}

		function loop(timestamp) {
			if (!state.running) {
				draw();
				return;
			}

			const deltaMs = timestamp - state.lastTime;
			state.lastTime = timestamp;
			const delta = Math.min(deltaMs / 1000, 0.05);

			update(delta);
			draw();

			if (state.running) {
				requestAnimationFrame(loop);
			}
		}

		function setKeyState(code, isDown) {
			if (code === 'ArrowUp' || code === 'KeyW') state.keys.up = isDown;
			if (code === 'ArrowDown' || code === 'KeyS') state.keys.down = isDown;
			if (code === 'ArrowLeft' || code === 'KeyA') state.keys.left = isDown;
			if (code === 'ArrowRight' || code === 'KeyD') state.keys.right = isDown;
		}

		window.addEventListener('keydown', function (e) {
			if (['ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'KeyW', 'KeyA', 'KeyS', 'KeyD', 'Space'].indexOf(e.code) !== -1) {
				e.preventDefault();
			}

			if (e.code === 'Space' && !state.running && !state.quizActive) {
				startGame();
				return;
			}

			setKeyState(e.code, true);
		});

		window.addEventListener('keyup', function (e) {
			setKeyState(e.code, false);
		});

		startButton.addEventListener('click', function () {
			if (!state.quizActive) {
				startGame();
				canvas.focus();
			}
		});

		restartButton.addEventListener('click', function () {
			resetGame();
			canvas.focus();
		});

		levelSelect.addEventListener('change', function () {
			resetGame();
		});

		answerButtons.forEach(function (btn) {
			btn.addEventListener('click', function () {
				answerQuestion(btn.getAttribute('data-answer'));
			});
		});

		touchButtons.forEach(function (btn) {
			const dir = btn.getAttribute('data-dir');

			function pressStart(e) {
				e.preventDefault();
				if (dir === 'up') state.keys.up = true;
				if (dir === 'down') state.keys.down = true;
				if (dir === 'left') state.keys.left = true;
				if (dir === 'right') state.keys.right = true;
			}

			function pressEnd(e) {
				e.preventDefault();
				if (dir === 'up') state.keys.up = false;
				if (dir === 'down') state.keys.down = false;
				if (dir === 'left') state.keys.left = false;
				if (dir === 'right') state.keys.right = false;
			}

			btn.addEventListener('mousedown', pressStart);
			btn.addEventListener('mouseup', pressEnd);
			btn.addEventListener('mouseleave', pressEnd);
			btn.addEventListener('touchstart', pressStart, { passive: false });
			btn.addEventListener('touchend', pressEnd, { passive: false });
			btn.addEventListener('touchcancel', pressEnd, { passive: false });
		});

		resetGame();
	});
});
JS;

if (!function_exists('zo_ogretmenden_kac_render')) {
	function zo_ogretmenden_kac_render($post_id = 0, $game = array()) {
		$game_id = 'zo-ogretmenden-kac-' . wp_rand(1000, 999999);

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--ogretmenden-kac" id="<?php echo esc_attr($game_id); ?>">
			<div class="zo-ok-wrap">
				<h2 class="zo-ok-title">Öğretmenden Kaç</h2>
				<p class="zo-ok-subtitle">Öğretmen seni kovalıyor. Bazen soru sorar. Yanlış yaparsan daha hızlı kovalar.</p>

				<div class="zo-ok-topbar">
					<div class="zo-ok-stats">
						<div class="zo-ok-stat">Skor: <span class="zo-ok-score">0</span></div>
						<div class="zo-ok-stat">Süre: <span class="zo-ok-time">0.0 sn</span></div>
						<div class="zo-ok-stat">Seviye: <span class="zo-ok-level">Kolay</span></div>
						<div class="zo-ok-stat">En İyi: <span class="zo-ok-best">0</span></div>
					</div>

					<div class="zo-ok-controls">
						<select class="zo-ok-select" aria-label="Zorluk seç">
							<option value="easy">Kolay</option>
							<option value="medium">Orta</option>
							<option value="hard">Zor</option>
						</select>
						<button type="button" class="zo-ok-button zo-ok-start">Oyunu Başlat</button>
						<button type="button" class="zo-ok-button zo-ok-button--secondary zo-ok-restart">Sıfırla</button>
					</div>
				</div>

				<div class="zo-ok-layout">
					<div class="zo-ok-board-wrap">
						<canvas class="zo-ok-canvas" width="760" height="500" tabindex="0" aria-label="Öğretmenden kaç oyunu alanı"></canvas>

						<div class="zo-ok-quiz" aria-hidden="true">
							<div class="zo-ok-quiz-card">
								<h3 class="zo-ok-quiz-title">Öğretmen Soru Soruyor</h3>
								<div class="zo-ok-quiz-question">5 + 3 = ?</div>
								<div class="zo-ok-quiz-grid">
									<button type="button" class="zo-ok-answer-btn" data-answer="">A</button>
									<button type="button" class="zo-ok-answer-btn" data-answer="">B</button>
									<button type="button" class="zo-ok-answer-btn" data-answer="">C</button>
								</div>
								<div class="zo-ok-status-pill">Yanlış yaparsan öğretmen hızlanır.</div>
							</div>
						</div>

						<div class="zo-ok-touch">
							<button type="button" class="zo-ok-touch-btn" data-dir="up">↑</button>
							<button type="button" class="zo-ok-touch-btn" data-dir="left">←</button>
							<button type="button" class="zo-ok-touch-btn" data-dir="down">↓</button>
							<button type="button" class="zo-ok-touch-btn" data-dir="right">→</button>
						</div>

						<div class="zo-ok-message">Başlamak için "Oyunu Başlat" düğmesine bas.</div>
					</div>

					<div class="zo-ok-side">
						<h3>Nasıl Oynanır</h3>
						<ul>
							<li>Mavi öğrenci sensin.</li>
							<li>Kırmızı öğretmen seni kovalar.</li>
							<li>Ok tuşları veya W A S D ile kaç.</li>
							<li>Turuncu kitapları toplayınca puan kazanırsın.</li>
							<li>Kitap alınca kısa süre hızlanırsın.</li>
							<li>Öğretmen soru sorunca cevap ver.</li>
							<li>Yanlış cevap verirsen öğretmen bir süre daha hızlı olur.</li>
						</ul>

						<h3>Zorluklar</h3>
						<ul>
							<li><strong>Kolay:</strong> Daha yavaş takip.</li>
							<li><strong>Orta:</strong> Daha dengeli hız.</li>
							<li><strong>Zor:</strong> Daha hızlı takip ve daha sık soru.</li>
						</ul>

						<p>Boşluk tuşu ile hızlıca başlatabilirsin.</p>
					</div>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'ogretmenden-kac',
	'name'            => 'Öğretmenden Kaç',
	'author'          => 'Arslan',
	'description'     => 'Öğretmenin soru sorup yanlış cevapta daha hızlı kovaladığı kaçma oyunu.',
	'render_callback' => 'zo_ogretmenden_kac_render',
	'inline_style'    => $inline_style,
	'inline_script'   => $inline_script,
);