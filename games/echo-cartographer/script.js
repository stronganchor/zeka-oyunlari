(function () {
	const MAPS = [
		[
			'#########',
			'#S..T..E#',
			'#.###.#.#',
			'#...H.#.#',
			'###.#.#.#',
			'#...#...#',
			'#.#.###.#',
			'#M..T...#',
			'#########'
		],
		[
			'#########',
			'#S#...#E#',
			'#.#.#.#.#',
			'#.#H#...#',
			'#...###.#',
			'###...#.#',
			'#..T#.#.#',
			'#M..#..E#',
			'#########'
		],
		[
			'#########',
			'#S...#..#',
			'###H.#E##',
			'#...#...#',
			'#.###.#.#',
			'#...T.#.#',
			'#.###.#.#',
			'#M....E.#',
			'#########'
		]
	];

	function keyFor(position) {
		return position.x + ',' + position.y;
	}

	function clonePosition(position) {
		return { x: position.x, y: position.y };
	}

	function parseMap(rows) {
		const exits = [];
		const traps = [];
		const enemies = [];
		let player = { x: 1, y: 1 };

		rows.forEach(function (row, y) {
			row.split('').forEach(function (cell, x) {
				if (cell === 'S') {
					player = { x: x, y: y };
				} else if (cell === 'E') {
					exits.push({ x: x, y: y });
				} else if (cell === 'T') {
					traps.push({ x: x, y: y });
				} else if (cell === 'M') {
					enemies.push({ x: x, y: y });
				}
			});
		});

		return {
			player: player,
			exits: exits,
			traps: traps,
			enemies: enemies
		};
	}

	function initEchoCartographer(gameRoot) {
		if (!gameRoot || gameRoot.dataset.zoEchoCartographerReady === '1') {
			return;
		}

		const game = gameRoot.querySelector('.zo-ec');

		if (!game) {
			return;
		}

		gameRoot.dataset.zoEchoCartographerReady = '1';

		const board = game.querySelector('.zo-ec__board');
		const message = game.querySelector('.zo-ec__message');
		const levelEl = game.querySelector('.zo-ec__level');
		const pulseEl = game.querySelector('.zo-ec__pulses');
		const noiseEl = game.querySelector('.zo-ec__noise');
		const revealEl = game.querySelector('.zo-ec__reveal');
		const pulseButton = game.querySelector('.zo-ec__pulse');
		const restartButton = game.querySelector('.zo-ec__restart');
		const moveButtons = game.querySelectorAll('.zo-ec__move');
		const pulseRadius = parseInt(game.dataset.pulseRadius || '4', 10);
		const revealTurns = parseInt(game.dataset.revealTurns || '2', 10);

		if (!board || !message || !levelEl || !pulseEl || !noiseEl || !revealEl || !pulseButton || !restartButton) {
			return;
		}

		const state = {
			levelIndex: 0,
			pulses: 0,
			revealedTurns: 0,
			player: { x: 1, y: 1 },
			enemies: [],
			trapKeys: new Set(),
			exitKeys: new Set(),
			visited: new Set(),
			discoveredHidden: new Set(),
			status: 'playing'
		};

		function currentMap() {
			return MAPS[state.levelIndex];
		}

		function setMessage(text, tone) {
			message.textContent = text;
			message.classList.remove('is-danger', 'is-success');

			if (tone === 'danger') {
				message.classList.add('is-danger');
			} else if (tone === 'success') {
				message.classList.add('is-success');
			}
		}

		function updateStats() {
			pulseEl.textContent = String(state.pulses);
			levelEl.textContent = String(state.levelIndex + 1);
			revealEl.textContent = state.revealedTurns > 0 ? String(state.revealedTurns) : '0';

			if (state.pulses <= 1) {
				noiseEl.textContent = 'Quiet';
			} else if (state.pulses <= 3) {
				noiseEl.textContent = 'Heard';
			} else if (state.pulses <= 5) {
				noiseEl.textContent = 'Tracked';
			} else {
				noiseEl.textContent = 'Swarming';
			}

			pulseButton.disabled = state.status !== 'playing';

			moveButtons.forEach(function (button) {
				button.disabled = state.status !== 'playing';
			});
		}

		function isInside(x, y) {
			return y >= 0 && y < currentMap().length && x >= 0 && x < currentMap()[0].length;
		}

		function rawTileAt(x, y) {
			if (!isInside(x, y)) {
				return '#';
			}

			return currentMap()[y].charAt(x);
		}

		function isWalkable(x, y) {
			const tile = rawTileAt(x, y);

			if (tile === '#') {
				return false;
			}

			if (tile === 'H' && !state.discoveredHidden.has(keyFor({ x: x, y: y }))) {
				return false;
			}

			return true;
		}

		function isVisible(x, y) {
			if (state.revealedTurns > 0) {
				return Math.abs(state.player.x - x) + Math.abs(state.player.y - y) <= pulseRadius;
			}

			return x === state.player.x && y === state.player.y;
		}

		function enemyAt(x, y) {
			return state.enemies.some(function (enemy) {
				return enemy.x === x && enemy.y === y;
			});
		}

		function remember(position) {
			state.visited.add(keyFor(position));
		}

		function revealNearby() {
			for (let y = 0; y < currentMap().length; y += 1) {
				for (let x = 0; x < currentMap()[y].length; x += 1) {
					if (Math.abs(state.player.x - x) + Math.abs(state.player.y - y) <= pulseRadius) {
						remember({ x: x, y: y });

						if (rawTileAt(x, y) === 'H') {
							state.discoveredHidden.add(keyFor({ x: x, y: y }));
						}
					}
				}
			}
		}

		function loadLevel(index) {
			const parsed = parseMap(MAPS[index]);

			state.levelIndex = index;
			state.player = clonePosition(parsed.player);
			state.enemies = parsed.enemies.map(clonePosition);
			state.trapKeys = new Set(parsed.traps.map(keyFor));
			state.exitKeys = new Set(parsed.exits.map(keyFor));
			state.visited = new Set([keyFor(parsed.player)]);
			state.discoveredHidden = new Set();
			state.revealedTurns = 0;
			state.status = 'playing';

			setMessage('The drone enters a buried sector. Move carefully or send a pulse.', '');
			render();
		}

		function restartRun() {
			state.pulses = 0;
			loadLevel(0);
			updateStats();
		}

		function findNextStep(start, target) {
			const queue = [clonePosition(start)];
			const seen = new Set([keyFor(start)]);
			const parents = {};
			const directions = [
				{ x: 1, y: 0 },
				{ x: -1, y: 0 },
				{ x: 0, y: 1 },
				{ x: 0, y: -1 }
			];

			while (queue.length > 0) {
				const current = queue.shift();

				if (current.x === target.x && current.y === target.y) {
					break;
				}

				directions.forEach(function (direction) {
					const next = {
						x: current.x + direction.x,
						y: current.y + direction.y
					};
					const nextKey = keyFor(next);

					if (!isInside(next.x, next.y) || seen.has(nextKey) || !isWalkable(next.x, next.y)) {
						return;
					}

					seen.add(nextKey);
					parents[nextKey] = current;
					queue.push(next);
				});
			}

			const targetKey = keyFor(target);

			if (!parents[targetKey]) {
				return clonePosition(start);
			}

			let cursor = target;
			let previous = parents[targetKey];

			while (previous && (previous.x !== start.x || previous.y !== start.y)) {
				cursor = previous;
				previous = parents[keyFor(previous)];
			}

			return clonePosition(cursor);
		}

		function resolveState() {
			const playerKey = keyFor(state.player);

			if (state.trapKeys.has(playerKey)) {
				state.status = 'lost';
				setMessage('A trap snaps shut under the drone. Sector failed.', 'danger');
				return true;
			}

			if (enemyAt(state.player.x, state.player.y)) {
				state.status = 'lost';
				setMessage('The hunters reached the drone before the echo faded.', 'danger');
				return true;
			}

			if (state.exitKeys.has(playerKey)) {
				if (state.levelIndex === MAPS.length - 1) {
					state.status = 'won';
					setMessage('The final lift shaft opens. You mapped the megacity and escaped.', 'success');
				} else {
					setMessage('Exit found. Descending into the next sector.', 'success');
					loadLevel(state.levelIndex + 1);
				}

				return true;
			}

			return false;
		}

		function moveEnemies(extraSteps) {
			if (state.status !== 'playing') {
				return;
			}

			for (let step = 0; step < 1 + extraSteps; step += 1) {
				state.enemies = state.enemies.map(function (enemy) {
					return findNextStep(enemy, state.player);
				});

				if (resolveState()) {
					return;
				}
			}
		}

		function render() {
			const html = [];

			for (let y = 0; y < currentMap().length; y += 1) {
				for (let x = 0; x < currentMap()[y].length; x += 1) {
					const tile = rawTileAt(x, y);
					const visible = isVisible(x, y);
					const remembered = state.visited.has(keyFor({ x: x, y: y })) || state.discoveredHidden.has(keyFor({ x: x, y: y }));
					const classes = ['zo-ec__cell'];
					let symbol = '';
					let label = 'Unknown';

					if (visible) {
						classes.push('is-visible');
					} else if (remembered) {
						classes.push('is-memory');
					} else {
						classes.push('is-dark');
					}

					if (tile === '#') {
						classes.push('is-wall');
						symbol = visible || remembered ? '█' : '';
						label = 'Wall';
					} else if (tile === 'H') {
						if (state.discoveredHidden.has(keyFor({ x: x, y: y }))) {
							classes.push('is-hidden');
							symbol = visible || remembered ? '·' : '';
							label = 'Hidden path';
						} else {
							classes.push('is-wall');
							symbol = visible ? '?' : '';
							label = 'Unknown structure';
						}
					} else {
						symbol = visible || remembered ? '·' : '';
						label = 'Floor';
					}

					if (state.exitKeys.has(keyFor({ x: x, y: y })) && (visible || remembered)) {
						classes.push('is-exit');
						symbol = 'E';
						label = 'Exit';
					}

					if (state.trapKeys.has(keyFor({ x: x, y: y })) && visible) {
						classes.push('is-trap');
						symbol = '!';
						label = 'Trap';
					}

					if (enemyAt(x, y) && visible) {
						classes.push('is-enemy');
						symbol = 'X';
						label = 'Hunter';
					}

					if (state.player.x === x && state.player.y === y) {
						classes.push('is-player');
						symbol = '◉';
						label = 'Drone';
					}

					html.push('<div class="' + classes.join(' ') + '" role="gridcell" aria-label="' + label + '">' + symbol + '</div>');
				}
			}

			board.innerHTML = html.join('');
			updateStats();
		}

		function endTurn(enemyBoost) {
			if (resolveState()) {
				render();
				return;
			}

			moveEnemies(enemyBoost);

			if (state.revealedTurns > 0) {
				state.revealedTurns -= 1;
			}

			render();
		}

		function tryMove(direction) {
			if (state.status !== 'playing') {
				return;
			}

			const next = clonePosition(state.player);

			if (direction === 'up') {
				next.y -= 1;
			} else if (direction === 'down') {
				next.y += 1;
			} else if (direction === 'left') {
				next.x -= 1;
			} else if (direction === 'right') {
				next.x += 1;
			}

			if (!isWalkable(next.x, next.y)) {
				setMessage('Blocked. Search with memory or risk a sonar pulse.', '');
				render();
				return;
			}

			state.player = next;
			remember(next);
			setMessage('The drone slides forward through the dark.', '');
			endTurn(0);
		}

		function pulse() {
			if (state.status !== 'playing') {
				return;
			}

			state.pulses += 1;
			state.revealedTurns = revealTurns + 1;
			revealNearby();
			setMessage('A sonar pulse blooms through the ruins. The hunters hear it too.', '');
			endTurn(1);
		}

		moveButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				tryMove(button.dataset.move || '');
			});
		});

		pulseButton.addEventListener('click', pulse);
		restartButton.addEventListener('click', restartRun);

		gameRoot.addEventListener('keydown', function (event) {
			if (event.key === 'ArrowUp') {
				event.preventDefault();
				tryMove('up');
			} else if (event.key === 'ArrowDown') {
				event.preventDefault();
				tryMove('down');
			} else if (event.key === 'ArrowLeft') {
				event.preventDefault();
				tryMove('left');
			} else if (event.key === 'ArrowRight') {
				event.preventDefault();
				tryMove('right');
			} else if (event.key === ' ' || event.key === 'Spacebar') {
				event.preventDefault();
				pulse();
			}
		});

		gameRoot.setAttribute('tabindex', '0');
		restartRun();
	}

	function initAllEchoCartographerGames() {
		document.querySelectorAll('.zo-game-root--echo-cartographer').forEach(function (gameRoot) {
			initEchoCartographer(gameRoot);
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initAllEchoCartographerGames);
	} else {
		initAllEchoCartographerGames();
	}
})();
