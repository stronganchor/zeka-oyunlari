<?php

if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('zo_arslan_learning_game_css')) {
	function zo_arslan_learning_game_css() {
		return <<<'CSS'
.zo-game-root.zo-game-root--arslan-learning-game {
	width: 100%;
	max-width: 1080px;
	margin: 0 auto;
	padding: 18px;
	box-sizing: border-box;
	color: #14313a;
	font-family: Arial, sans-serif;
}

.zo-game-root--arslan-learning-game .alg-shell {
	min-height: calc(100vh - 146px);
	display: grid;
	grid-template-rows: auto auto 1fr auto;
	gap: 14px;
	padding: 18px;
	border: 2px solid #cfd8dc;
	border-radius: 8px;
	background: #f8fbfc;
	box-shadow: 0 18px 40px rgba(15, 23, 42, 0.16);
	box-sizing: border-box;
}

.zo-game-root--arslan-learning-game .alg-top {
	display: grid;
	grid-template-columns: 1fr auto;
	gap: 14px;
	align-items: start;
}

.zo-game-root--arslan-learning-game .alg-title {
	margin: 0 0 6px;
	font-size: 32px;
	line-height: 1.1;
	color: #102a43;
}

.zo-game-root--arslan-learning-game .alg-desc {
	margin: 0;
	max-width: 720px;
	font-size: 16px;
	line-height: 1.45;
	color: #48636f;
}

.zo-game-root--arslan-learning-game .alg-reset {
	border: 0;
	border-radius: 8px;
	padding: 12px 16px;
	background: #e44d26;
	color: #fff;
	font-weight: 800;
	cursor: pointer;
}

.zo-game-root--arslan-learning-game .alg-stats {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 10px;
}

.zo-game-root--arslan-learning-game .alg-stat {
	min-height: 64px;
	padding: 10px 12px;
	border: 2px solid #d8e0e5;
	border-radius: 8px;
	background: #fff;
	box-sizing: border-box;
}

.zo-game-root--arslan-learning-game .alg-label {
	display: block;
	margin-bottom: 4px;
	font-size: 12px;
	font-weight: 800;
	text-transform: uppercase;
	color: #607580;
}

.zo-game-root--arslan-learning-game .alg-value {
	display: block;
	font-size: 24px;
	font-weight: 900;
	line-height: 1;
	color: #102a43;
}

.zo-game-root--arslan-learning-game .alg-stage {
	position: relative;
	min-height: 430px;
	overflow: hidden;
	border: 2px solid #c9d5db;
	border-radius: 8px;
	background: linear-gradient(180deg, #fefefe 0%, #e9f6f7 100%);
}

.zo-game-root--arslan-learning-game .alg-scene {
	position: absolute;
	inset: 0;
	pointer-events: none;
	background:
		linear-gradient(90deg, rgba(20, 49, 58, 0.04) 1px, transparent 1px),
		linear-gradient(180deg, rgba(20, 49, 58, 0.04) 1px, transparent 1px);
	background-size: 36px 36px;
}

.zo-game-root--arslan-learning-game .alg-board {
	position: relative;
	z-index: 1;
	min-height: 430px;
	padding: 18px;
	box-sizing: border-box;
}

.zo-game-root--arslan-learning-game .alg-actions {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
	gap: 10px;
}

.zo-game-root--arslan-learning-game button.alg-choice,
.zo-game-root--arslan-learning-game button.alg-card,
.zo-game-root--arslan-learning-game button.alg-tile {
	border: 2px solid #b7c8d0;
	border-radius: 8px;
	background: #fff;
	color: #17353f;
	font-weight: 800;
	cursor: pointer;
	box-sizing: border-box;
	transition: transform 0.12s ease, border-color 0.12s ease, background-color 0.12s ease;
}

.zo-game-root--arslan-learning-game button:hover,
.zo-game-root--arslan-learning-game button:focus {
	outline: none;
	transform: translateY(-1px);
	border-color: #238c9e;
}

.zo-game-root--arslan-learning-game .alg-choice {
	min-height: 62px;
	padding: 12px;
	font-size: 17px;
}

.zo-game-root--arslan-learning-game .alg-status {
	min-height: 28px;
	padding: 10px 12px;
	border-radius: 8px;
	background: #12333d;
	color: #fff;
	font-size: 16px;
	font-weight: 800;
	line-height: 1.35;
}

.zo-game-root--arslan-learning-game .is-good {
	background: #dff7ea !important;
	border-color: #30a66a !important;
	color: #13562f !important;
}

.zo-game-root--arslan-learning-game .is-bad {
	background: #ffe1dc !important;
	border-color: #df5a45 !important;
	color: #8d2415 !important;
}

.zo-game-root--arslan-learning-game .alg-grid {
	display: grid;
	gap: 10px;
}

.zo-game-root--arslan-learning-game .alg-memory {
	grid-template-columns: repeat(4, minmax(0, 1fr));
}

.zo-game-root--arslan-learning-game .alg-card {
	min-height: 86px;
	padding: 10px;
	font-size: 15px;
}

.zo-game-root--arslan-learning-game .alg-card.is-hidden {
	background: #2d6f7e;
	color: #fff;
	font-size: 30px;
}

.zo-game-root--arslan-learning-game .alg-runner {
	display: grid;
	grid-template-columns: 90px 1fr;
	gap: 14px;
	align-items: stretch;
	height: 100%;
	min-height: 390px;
}

.zo-game-root--arslan-learning-game .alg-runner-player {
	align-self: end;
	height: 74px;
	border-radius: 8px;
	background: #ffd166;
	border: 3px solid #a66321;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 34px;
	font-weight: 900;
}

.zo-game-root--arslan-learning-game .alg-runner-track {
	position: relative;
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 12px;
	align-items: end;
}

.zo-game-root--arslan-learning-game .alg-gate {
	min-height: 210px;
	display: flex;
	align-items: center;
	justify-content: center;
	padding: 12px;
	border: 3px solid #9fb4bf;
	border-radius: 8px;
	background: #fff;
	font-size: 25px;
	font-weight: 900;
	text-align: center;
}

.zo-game-root--arslan-learning-game .alg-furnace,
.zo-game-root--arslan-learning-game .alg-lab,
.zo-game-root--arslan-learning-game .alg-story {
	display: grid;
	gap: 16px;
	align-content: start;
}

.zo-game-root--arslan-learning-game .alg-prompt {
	padding: 16px;
	border: 2px solid #cfdae0;
	border-radius: 8px;
	background: #fff;
	font-size: 24px;
	font-weight: 900;
	text-align: center;
	color: #17353f;
}

.zo-game-root--arslan-learning-game .alg-slots {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
	justify-content: center;
}

.zo-game-root--arslan-learning-game .alg-slot {
	min-width: 54px;
	min-height: 54px;
	padding: 10px;
	border: 2px dashed #9fb4bf;
	border-radius: 8px;
	background: #fff;
	text-align: center;
	font-size: 24px;
	font-weight: 900;
	box-sizing: border-box;
}

.zo-game-root--arslan-learning-game .alg-maze {
	display: grid;
	gap: 4px;
	width: min(100%, 440px);
	margin: 0 auto;
}

.zo-game-root--arslan-learning-game .alg-cell {
	aspect-ratio: 1;
	display: flex;
	align-items: center;
	justify-content: center;
	border-radius: 6px;
	background: #fff;
	border: 1px solid #d2dde2;
	font-weight: 900;
}

.zo-game-root--arslan-learning-game .alg-wall {
	background: #14313a;
}

.zo-game-root--arslan-learning-game .alg-player {
	background: #ffd166;
}

.zo-game-root--arslan-learning-game .alg-goal {
	background: #a7f3d0;
}

.zo-game-root--arslan-learning-game .alg-sort {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
	gap: 12px;
}

.zo-game-root--arslan-learning-game .alg-bin {
	min-height: 96px;
	padding: 12px;
	border: 3px solid #aebfc7;
	border-radius: 8px;
	background: #fff;
	text-align: center;
	font-size: 18px;
	font-weight: 900;
}

.zo-game-root--arslan-learning-game .alg-map {
	display: grid;
	grid-template-columns: repeat(3, minmax(0, 1fr));
	gap: 12px;
}

.zo-game-root--arslan-learning-game .alg-map-cell {
	min-height: 110px;
	display: flex;
	align-items: center;
	justify-content: center;
	padding: 10px;
	border: 2px solid #b7c8d0;
	border-radius: 8px;
	background: #fff;
	font-size: 16px;
	font-weight: 900;
	text-align: center;
}

.zo-game-root--arslan-learning-game .alg-code-grid {
	display: grid;
	grid-template-columns: repeat(6, minmax(0, 1fr));
	gap: 6px;
	width: min(100%, 520px);
	margin: 0 auto;
}

.zo-game-root--arslan-learning-game .alg-code-grid .alg-cell {
	min-height: 58px;
}

.zo-game-root--arslan-learning-game .alg-sequence {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	justify-content: center;
}

.zo-game-root--arslan-learning-game .alg-seq-item {
	width: 70px;
	height: 70px;
	display: flex;
	align-items: center;
	justify-content: center;
	border: 2px solid #b7c8d0;
	border-radius: 8px;
	background: #fff;
	font-size: 28px;
	font-weight: 900;
}

.zo-game-root--arslan-learning-game .alg-clock {
	width: 230px;
	height: 230px;
	margin: 8px auto 12px;
	border: 8px solid #17353f;
	border-radius: 50%;
	position: relative;
	background: #fff;
}

.zo-game-root--arslan-learning-game .alg-hand {
	position: absolute;
	left: 50%;
	bottom: 50%;
	width: 6px;
	border-radius: 999px;
	background: #e44d26;
	transform-origin: bottom center;
}

.zo-game-root--arslan-learning-game .alg-hour {
	height: 64px;
	background: #17353f;
}

.zo-game-root--arslan-learning-game .alg-minute {
	height: 88px;
}

@media (max-width: 720px) {
	.zo-game-root.zo-game-root--arslan-learning-game {
		padding: 10px;
	}

	.zo-game-root--arslan-learning-game .alg-shell {
		min-height: calc(100vh - 104px);
		padding: 12px;
	}

	.zo-game-root--arslan-learning-game .alg-top,
	.zo-game-root--arslan-learning-game .alg-stats {
		grid-template-columns: 1fr;
	}

	.zo-game-root--arslan-learning-game .alg-title {
		font-size: 25px;
	}

	.zo-game-root--arslan-learning-game .alg-stage,
	.zo-game-root--arslan-learning-game .alg-board {
		min-height: 390px;
	}

	.zo-game-root--arslan-learning-game .alg-memory {
		grid-template-columns: repeat(3, minmax(0, 1fr));
	}

	.zo-game-root--arslan-learning-game .alg-card {
		min-height: 74px;
	}

	.zo-game-root--arslan-learning-game .alg-runner {
		grid-template-columns: 1fr;
	}

	.zo-game-root--arslan-learning-game .alg-runner-track,
	.zo-game-root--arslan-learning-game .alg-map {
		grid-template-columns: 1fr;
	}
}
CSS;
	}
}

if (!function_exists('zo_arslan_learning_game_js')) {
	function zo_arslan_learning_game_js() {
		return <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	document.querySelectorAll('.zo-game-root--arslan-learning-game').forEach(function (game) {
		if (game.dataset.algReady === '1') {
			return;
		}
		game.dataset.algReady = '1';

		const config = JSON.parse(game.querySelector('.alg-config').textContent);
		const board = game.querySelector('.alg-board');
		const actions = game.querySelector('.alg-actions');
		const status = game.querySelector('.alg-status');
		const scoreNode = game.querySelector('[data-stat="score"]');
		const levelNode = game.querySelector('[data-stat="level"]');
		const timerNode = game.querySelector('[data-stat="timer"]');
		const progressNode = game.querySelector('[data-stat="progress"]');
		const reset = game.querySelector('.alg-reset');
		let state = {};
		let timer = null;

		function shuffle(list) {
			const copy = list.slice();
			for (let i = copy.length - 1; i > 0; i--) {
				const j = Math.floor(Math.random() * (i + 1));
				[copy[i], copy[j]] = [copy[j], copy[i]];
			}
			return copy;
		}

		function choice(list) {
			return list[Math.floor(Math.random() * list.length)];
		}

		function setStatus(text) {
			status.textContent = text;
		}

		function updateStats() {
			scoreNode.textContent = state.score;
			levelNode.textContent = state.level;
			timerNode.textContent = state.time;
			progressNode.textContent = state.done + '/' + state.goal;
		}

		function clear() {
			window.clearInterval(timer);
			timer = null;
			board.innerHTML = '<div class="alg-scene"></div>';
			actions.innerHTML = '';
		}

		function startClock() {
			timer = window.setInterval(function () {
				state.time -= 1;
				updateStats();
				if (state.time <= 0) {
					window.clearInterval(timer);
					timer = null;
					actions.querySelectorAll('button').forEach(function (button) {
						button.disabled = true;
					});
					setStatus('Time is up. Press restart and beat your score.');
				}
			}, 1000);
		}

		function newBase() {
			state = {
				score: 0,
				level: 1,
				time: config.time || 75,
				done: 0,
				goal: config.goal || 8,
				current: null,
				selected: []
			};
			clear();
			updateStats();
			setStatus(config.ready || 'Pick the best answer.');
			startClock();
		}

		function score(ok, message) {
			if (state.time <= 0) {
				return;
			}
			if (ok) {
				state.score += 10 + state.level;
				state.done += 1;
				if (state.done % 3 === 0) {
					state.level += 1;
				}
				setStatus(message || choice(['Nice one.', 'Good move.', 'That worked.']));
				if (state.done >= state.goal) {
					window.clearInterval(timer);
					timer = null;
					setStatus(config.win || 'You won. Restart for a faster run.');
				} else {
					window.setTimeout(nextRound, 350);
				}
			} else {
				state.score = Math.max(0, state.score - 4);
				setStatus(message || 'Try a different answer.');
			}
			updateStats();
		}

		function button(text, value, className) {
			const el = document.createElement('button');
			el.type = 'button';
			el.className = className || 'alg-choice';
			el.textContent = text;
			el.dataset.value = value == null ? text : value;
			return el;
		}

		function prompt(text) {
			const el = document.createElement('div');
			el.className = 'alg-prompt';
			el.textContent = text;
			board.appendChild(el);
			return el;
		}

		function multiRound() {
			board.innerHTML = '<div class="alg-scene"></div>';
			actions.innerHTML = '';
			const item = choice(config.rounds);
			state.current = item;
			prompt(item.prompt);
			shuffle(item.choices).forEach(function (answer) {
				const el = button(answer);
				el.addEventListener('click', function () {
					const ok = answer === item.answer;
					el.classList.add(ok ? 'is-good' : 'is-bad');
					score(ok, ok ? item.good : item.bad);
				});
				actions.appendChild(el);
			});
		}

		function memoryRound() {
			board.innerHTML = '<div class="alg-scene"></div>';
			actions.innerHTML = '';
			const grid = document.createElement('div');
			grid.className = 'alg-grid alg-memory';
			board.appendChild(grid);
			const items = shuffle(config.pairs.concat(config.pairs));
			let open = [];
			let matched = 0;
			items.forEach(function (text, index) {
				const card = button('?', text, 'alg-card is-hidden');
				card.dataset.index = index;
				card.addEventListener('click', function () {
					if (card.classList.contains('is-matched') || open.indexOf(card) !== -1 || open.length === 2) {
						return;
					}
					card.textContent = text;
					card.classList.remove('is-hidden');
					open.push(card);
					if (open.length === 2) {
						if (open[0].dataset.value === open[1].dataset.value) {
							open.forEach(function (c) {
								c.classList.add('is-matched', 'is-good');
							});
							open = [];
							matched += 1;
							state.score += 8;
							if (matched === config.pairs.length) {
								state.done += 1;
								state.level += 1;
								updateStats();
								setStatus('The garden bloomed. New plant unlocked.');
								if (state.done >= state.goal) {
									window.clearInterval(timer);
									setStatus(config.win);
								} else {
									window.setTimeout(memoryRound, 700);
								}
							} else {
								setStatus('Match found. Keep growing the garden.');
							}
						} else {
							setStatus('Not a pair yet.');
							window.setTimeout(function () {
								open.forEach(function (c) {
									c.textContent = '?';
									c.classList.add('is-hidden');
								});
								open = [];
							}, 650);
						}
						updateStats();
					}
				});
				grid.appendChild(card);
			});
		}

		function runnerRound() {
			board.innerHTML = '<div class="alg-scene"></div>';
			actions.innerHTML = '';
			const a = Math.floor(Math.random() * (7 + state.level)) + 2;
			const b = Math.floor(Math.random() * 8) + 1;
			const answer = a + b;
			const answers = shuffle([answer, answer + choice([-3, -2, 2, 3]), answer + choice([-5, 4, 5])]);
			const wrap = document.createElement('div');
			wrap.className = 'alg-runner';
			wrap.innerHTML = '<div class="alg-runner-player">RUN</div><div class="alg-runner-track"></div>';
			board.appendChild(wrap);
			wrap.querySelector('.alg-runner-track').append.apply(wrap.querySelector('.alg-runner-track'), answers.map(function (n) {
				const gate = document.createElement('div');
				gate.className = 'alg-gate';
				gate.textContent = n;
				return gate;
			}));
			prompt('Run through the gate for ' + a + ' + ' + b);
			answers.forEach(function (n) {
				const el = button(String(n));
				el.addEventListener('click', function () {
					score(n === answer, n === answer ? 'Clean jump through the math gate.' : 'That gate was a wall.');
				});
				actions.appendChild(el);
			});
		}

		function wordRound() {
			board.innerHTML = '<div class="alg-scene"></div>';
			actions.innerHTML = '';
			const item = choice(config.words);
			state.current = item.word;
			prompt(item.hint);
			const slots = document.createElement('div');
			slots.className = 'alg-slots';
			board.appendChild(slots);
			let built = '';
			item.word.split('').forEach(function () {
				const slot = document.createElement('span');
				slot.className = 'alg-slot';
				slot.textContent = '_';
				slots.appendChild(slot);
			});
			shuffle(item.word.split('').concat(item.extra.split(''))).forEach(function (letter) {
				const el = button(letter);
				el.addEventListener('click', function () {
					if (built.length >= item.word.length) {
						return;
					}
					built += letter;
					slots.children[built.length - 1].textContent = letter;
					el.disabled = true;
					if (built.length === item.word.length) {
						score(built === item.word, built === item.word ? 'Word forged perfectly.' : 'The furnace cooled. Try that word again.');
					}
				});
				actions.appendChild(el);
			});
		}

		function mazeRound() {
			board.innerHTML = '<div class="alg-scene"></div>';
			actions.innerHTML = '';
			const map = config.mazes[state.done % config.mazes.length].map(function (row) {
				return row.split('');
			});
			let player = { r: 0, c: 0 };
			map.forEach(function (row, r) {
				row.forEach(function (cell, c) {
					if (cell === 'P') {
						player = { r: r, c: c };
					}
				});
			});
			const grid = document.createElement('div');
			grid.className = 'alg-maze';
			grid.style.gridTemplateColumns = 'repeat(' + map[0].length + ', 1fr)';
			board.appendChild(grid);
			function draw() {
				grid.innerHTML = '';
				map.forEach(function (row, r) {
					row.forEach(function (cell, c) {
						const el = document.createElement('div');
						el.className = 'alg-cell';
						if (cell === '#') el.classList.add('alg-wall');
						if (r === player.r && c === player.c) {
							el.classList.add('alg-player');
							el.textContent = config.player || 'M';
						} else if (cell === 'G') {
							el.classList.add('alg-goal');
							el.textContent = config.goalIcon || 'G';
						}
						grid.appendChild(el);
					});
				});
			}
			function move(dr, dc) {
				const nr = player.r + dr;
				const nc = player.c + dc;
				if (!map[nr] || map[nr][nc] === '#' || map[nr][nc] == null) {
					setStatus('Blocked. Find another path.');
					return;
				}
				player = { r: nr, c: nc };
				draw();
				if (map[nr][nc] === 'G') {
					score(true, config.good || 'Goal reached.');
				}
			}
			draw();
			[
				['Up', -1, 0], ['Left', 0, -1], ['Right', 0, 1], ['Down', 1, 0]
			].forEach(function (item) {
				const el = button(item[0]);
				el.addEventListener('click', function () { move(item[1], item[2]); });
				actions.appendChild(el);
			});
		}

		function sortRound() {
			board.innerHTML = '<div class="alg-scene"></div>';
			actions.innerHTML = '';
			const item = choice(config.items);
			prompt(item.name);
			const wrap = document.createElement('div');
			wrap.className = 'alg-sort';
			board.appendChild(wrap);
			config.bins.forEach(function (bin) {
				const el = document.createElement('div');
				el.className = 'alg-bin';
				el.textContent = bin;
				wrap.appendChild(el);
			});
			config.bins.forEach(function (bin) {
				const el = button(bin);
				el.addEventListener('click', function () {
					score(bin === item.bin, bin === item.bin ? config.good : config.bad);
				});
				actions.appendChild(el);
			});
		}

		function patternRound() {
			board.innerHTML = '<div class="alg-scene"></div>';
			actions.innerHTML = '';
			const item = choice(config.patterns);
			const seq = document.createElement('div');
			seq.className = 'alg-sequence';
			item.show.forEach(function (part) {
				const el = document.createElement('div');
				el.className = 'alg-seq-item';
				el.textContent = part;
				seq.appendChild(el);
			});
			const missing = document.createElement('div');
			missing.className = 'alg-seq-item';
			missing.textContent = '?';
			seq.appendChild(missing);
			board.appendChild(seq);
			prompt(item.prompt);
			shuffle(item.choices).forEach(function (answer) {
				const el = button(answer);
				el.addEventListener('click', function () {
					missing.textContent = answer;
					score(answer === item.answer, answer === item.answer ? config.good : config.bad);
				});
				actions.appendChild(el);
			});
		}

		function clockRound() {
			board.innerHTML = '<div class="alg-scene"></div>';
			actions.innerHTML = '';
			const item = choice(config.times);
			const clock = document.createElement('div');
			clock.className = 'alg-clock';
			clock.innerHTML = '<div class="alg-hand alg-hour"></div><div class="alg-hand alg-minute"></div>';
			board.appendChild(clock);
			prompt('Set the clock to ' + item.label);
			shuffle(config.times).slice(0, 4).concat([item]).filter(function (value, index, list) {
				return list.findIndex(function (other) { return other.label === value.label; }) === index;
			}).slice(0, 4).forEach(function (time) {
				const el = button(time.label);
				el.addEventListener('click', function () {
					clock.querySelector('.alg-hour').style.transform = 'translateX(-50%) rotate(' + ((time.hour % 12) * 30 + time.minute / 2) + 'deg)';
					clock.querySelector('.alg-minute').style.transform = 'translateX(-50%) rotate(' + (time.minute * 6) + 'deg)';
					score(time.label === item.label, time.label === item.label ? 'The clock tower opened.' : 'Those hands point to another time.');
				});
				actions.appendChild(el);
			});
		}

		function codeRound() {
			board.innerHTML = '<div class="alg-scene"></div>';
			actions.innerHTML = '';
			const plan = choice(config.programs);
			const grid = document.createElement('div');
			grid.className = 'alg-code-grid';
			board.appendChild(grid);
			for (let i = 0; i < 30; i++) {
				const cell = document.createElement('div');
				cell.className = 'alg-cell';
				if (i === plan.start) {
					cell.classList.add('alg-player');
					cell.textContent = 'R';
				}
				if (i === plan.goal) {
					cell.classList.add('alg-goal');
					cell.textContent = 'G';
				}
				grid.appendChild(cell);
			}
			prompt('Choose the command program that reaches the goal.');
			shuffle(config.programs).slice(0, 3).concat([plan]).filter(function (value, index, list) {
				return list.findIndex(function (other) { return other.label === value.label; }) === index;
			}).slice(0, 4).forEach(function (program) {
				const el = button(program.label);
				el.addEventListener('click', function () {
					score(program.label === plan.label, program.label === plan.label ? config.good : config.bad);
				});
				actions.appendChild(el);
			});
		}

		function storyRound() {
			board.innerHTML = '<div class="alg-scene"></div>';
			actions.innerHTML = '';
			const story = choice(config.stories);
			const words = {};
			prompt(story.template.replace(/\{[^}]+\}/g, '_____'));
			Object.keys(story.options).forEach(function (key) {
				const row = document.createElement('div');
				row.className = 'alg-slots';
				story.options[key].forEach(function (word) {
					const el = button(word);
					el.addEventListener('click', function () {
						words[key] = word;
						row.querySelectorAll('button').forEach(function (b) { b.classList.remove('is-good'); });
						el.classList.add('is-good');
						if (Object.keys(words).length === Object.keys(story.options).length) {
							const text = story.template.replace(/\{([^}]+)\}/g, function (_, name) { return words[name]; });
							board.querySelector('.alg-prompt').textContent = text;
							score(true, 'Story spun. Make another silly one.');
						}
					});
					row.appendChild(el);
				});
				board.appendChild(row);
			});
		}

		function nextRound() {
			if (state.done >= state.goal || state.time <= 0) {
				return;
			}
			const type = config.type;
			if (type === 'memory') memoryRound();
			else if (type === 'runner') runnerRound();
			else if (type === 'word') wordRound();
			else if (type === 'maze') mazeRound();
			else if (type === 'sort') sortRound();
			else if (type === 'pattern') patternRound();
			else if (type === 'clock') clockRound();
			else if (type === 'code') codeRound();
			else if (type === 'story') storyRound();
			else multiRound();
		}

		function restart() {
			newBase();
			nextRound();
		}

		reset.addEventListener('click', restart);
		restart();
	});
});
JS;
	}
}

if (!function_exists('zo_arslan_learning_game_render')) {
	function zo_arslan_learning_game_render($post_id = 0, $module = array()) {
		$slug = !empty($module['slug']) ? sanitize_title($module['slug']) : 'arslan-learning-game';
		$name = !empty($module['name']) ? (string) $module['name'] : 'Arslan Learning Game';
		$description = !empty($module['description']) ? (string) $module['description'] : 'Play, learn, and score points.';
		$config = !empty($module['game_config']) && is_array($module['game_config']) ? $module['game_config'] : array();
		$instance_id = 'zo-' . $slug . '-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--arslan-learning-game zo-game-root--<?php echo esc_attr($slug); ?>" id="<?php echo esc_attr($instance_id); ?>">
			<script type="application/json" class="alg-config"><?php echo wp_json_encode($config); ?></script>
			<div class="alg-shell">
				<header class="alg-top">
					<div>
						<h1 class="alg-title"><?php echo esc_html($name); ?></h1>
						<p class="alg-desc"><?php echo esc_html($description); ?></p>
					</div>
					<button class="alg-reset" type="button">Restart</button>
				</header>
				<section class="alg-stats" aria-label="Game stats">
					<div class="alg-stat"><span class="alg-label">Score</span><span class="alg-value" data-stat="score">0</span></div>
					<div class="alg-stat"><span class="alg-label">Level</span><span class="alg-value" data-stat="level">1</span></div>
					<div class="alg-stat"><span class="alg-label">Time</span><span class="alg-value" data-stat="timer">0</span></div>
					<div class="alg-stat"><span class="alg-label">Goal</span><span class="alg-value" data-stat="progress">0/0</span></div>
				</section>
				<section class="alg-stage" aria-label="Game area">
					<div class="alg-board"></div>
				</section>
				<section class="alg-actions" aria-label="Game controls"></section>
				<div class="alg-status" role="status" aria-live="polite">Ready.</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

if (!function_exists('zo_arslan_learning_game_module')) {
	function zo_arslan_learning_game_module($slug, $name, $description, $config) {
		return array(
			'slug'            => $slug,
			'name'            => $name,
			'author'          => 'Arslan',
			'description'     => $description,
			'render_callback' => 'zo_arslan_learning_game_render',
			'inline_style'    => zo_arslan_learning_game_css(),
			'inline_script'   => zo_arslan_learning_game_js(),
			'game_config'     => $config,
		);
	}
}
