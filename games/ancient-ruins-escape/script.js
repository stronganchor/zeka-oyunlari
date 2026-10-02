(() => {
	'use strict';

	function boot() {
		document.querySelectorAll('.zo-game-root--ancient-ruins-escape').forEach((root) => {
			if (root.dataset.ready) return;
			root.dataset.ready = '1';

			const text = JSON.parse(root.dataset.labels);
			const canvas = root.querySelector('canvas');
			const ctx = canvas.getContext('2d');
			if (!ctx) return;
			const overlay = root.querySelector('.zo-ruins-overlay');
			const overlayTitle = root.querySelector('.zo-ruins-overlay-title');
			const overlayDetail = root.querySelector('.zo-ruins-overlay-detail');
			const status = root.querySelector('.zo-ruins-status');
			const startButton = root.querySelector('.zo-ruins-start');
			const pauseButton = root.querySelector('.zo-ruins-pause');
			const distanceEl = root.querySelector('.zo-ruins-distance');
			const timeEl = root.querySelector('.zo-ruins-time');
			const bestEl = root.querySelector('.zo-ruins-best');
			const W = 900, H = 650, HORIZON = 165, GROUND = 560, FAR = 95, PLAYER_Z = 5;
			const JUMP_TIME = .95, SLIDE_TIME = .85;
			const colors = {
				sand: '#be9c64', gold: '#ffd970', white: '#f5efd5', dark: '#222b2c'
			};
			let game = freshGame();
			let best = 0;
			let running = false;
			let paused = false;
			let lastFrame = 0;
			let frameId = 0;
			let touchStart = null;

			function freshGame() {
				return {lane: 0, visualLane: 0, jump: 0, slide: 0, time: 0,
					distance: 0, spawn: 1.5, traps: [], alive: true, reason: ''};
			}

			function polygon(color, points) {
				ctx.fillStyle = color;
				ctx.beginPath();
				ctx.moveTo(points[0][0], points[0][1]);
				for (let i = 1; i < points.length; i++) ctx.lineTo(points[i][0], points[i][1]);
				ctx.closePath();
				ctx.fill();
			}

			function rect(color, x, y, w, h) {
				ctx.fillStyle = color;
				ctx.fillRect(x, y, w, h);
			}

			function line(color, x1, y1, x2, y2, width) {
				ctx.strokeStyle = color;
				ctx.lineWidth = width;
				ctx.lineCap = 'round';
				ctx.beginPath();
				ctx.moveTo(x1, y1);
				ctx.lineTo(x2, y2);
				ctx.stroke();
			}

			function ellipse(color, x, y, rx, ry) {
				ctx.fillStyle = color;
				ctx.beginPath();
				ctx.ellipse(x, y, rx, ry, 0, 0, Math.PI * 2);
				ctx.fill();
			}

			function project(lane, z) {
				const depth = Math.max(0, Math.min(1, 1 - z / FAR));
				const scale = .06 + .94 * depth ** 1.5;
				return [W / 2 + lane * 210 * scale,
					HORIZON + (GROUND - HORIZON) * depth ** 1.65, scale];
			}

			function jumpHeight() {
				if (game.jump <= 0) return 0;
				return 105 * Math.sin((1 - game.jump / JUMP_TIME) * Math.PI);
			}

			function background() {
				rect('#222b2c', 0, 0, W, H);
				ellipse('#d9ae62', 700, 90, 45, 45);
				[[30, 100], [150, 65], [650, 80], [790, 115]].forEach(([x, height]) => {
					rect('#41483e', x, HORIZON - height, 100, height);
					polygon('#515341', [[x - 12, HORIZON - height],
						[x + 50, HORIZON - height - 28], [x + 112, HORIZON - height]]);
					for (let column = 0; column < 3; column++) {
						rect('#232c29', x + 15 + column * 28, HORIZON - height + 20, 13, height - 20);
					}
				});
				rect('#57523a', 0, HORIZON, W, H - HORIZON);
				polygon(colors.sand, [[W / 2 - 22, HORIZON], [W / 2 + 22, HORIZON],
					[W - 70, GROUND + 65], [70, GROUND + 65]]);
				for (const lane of [-.5, .5]) {
					const [x1, y1] = project(lane, FAR);
					const [x2, y2] = project(lane, 0);
					line('#8e7048', x1, y1, x2, y2, 3);
				}
				for (let i = 0; i < 15; i++) {
					const z = ((i * 7 - game.distance) % FAR + FAR) % FAR;
					const [lx, y] = project(-1.5, z);
					const [rx] = project(1.5, z);
					line('#95794f', lx, y, rx, y, 2);
				}
				for (let i = 0; i < 10; i++) {
					const z = ((i * 11 - game.distance) % FAR + FAR) % FAR;
					for (const side of [-1, 1]) {
						const [x, y, scale] = project(side * 1.9, z);
						const width = Math.max(4, 38 * scale);
						const height = (150 + i % 3 * 30) * scale;
						rect('#7b7c5b', x - width / 2, y - height, width, height);
						rect('#a69d71', x - width / 2, y - height, Math.max(2, width / 4), height);
						rect('#b7a978', x - width / 2 - 5 * scale, y - height,
							width + 10 * scale, 13 * scale);
						line('#45513c', x, y - height * .8,
							x + width * .3, y - height * .4, Math.max(1, 4 * scale));
					}
				}
			}

			function drawTrap(trap) {
				const [x, y, scale] = project(trap.lane, trap.z);
				const width = 125 * scale;
				if (trap.kind === 'spikes') {
					ellipse('#59422b', x, y, width / 2, 10 * scale);
					for (let i = 0; i < 5; i++) {
						const left = x - width / 2 + i * width / 5;
						polygon('#dfd6ad', [[left, y], [left + width / 10, y - 48 * scale],
							[left + width / 5, y]]);
					}
				} else if (trap.kind === 'beam') {
					for (const side of [-1, 1]) {
						rect('#5c4731', x + side * width / 2 - 7 * scale,
							y - 104 * scale, 14 * scale, 104 * scale);
					}
					rect('#8a512d', x - width / 2, y - 104 * scale, width, 48 * scale);
					rect(colors.gold, x - width / 2, y - 65 * scale, width, 7 * scale);
				} else {
					rect('#696f58', x - width / 2, y - 105 * scale, width, 105 * scale);
					rect('#a59d72', x - width / 2, y - 105 * scale, width, 17 * scale);
					line('#374235', x - width * .2, y - 90 * scale,
						x + width * .15, y - 30 * scale, Math.max(1, 5 * scale));
				}
			}

			function drawPlayer() {
				const [x, floorY] = project(game.visualLane, PLAYER_Z);
				const y = floorY - jumpHeight();
				ellipse('#50452e', x, floorY + 2, 27, 7);
				if (game.slide > 0) {
					rect('#259198', x - 31, y - 27, 52, 23);
					ellipse('#e4ae79', x + 28, y - 20, 12, 12);
					line('#2f3035', x - 28, y - 10, x - 45, y - 4, 9);
				} else {
					const stride = game.jump > 0 ? 6 : Math.sin(game.time * 15) * 10;
					for (const side of [-1, 1]) {
						line('#2d3037', x + side * 9, y - 30,
							x + side * 13, y - 5 + side * stride, 10);
					}
					rect('#259198', x - 19, y - 69, 38, 43);
					line(colors.gold, x - 16, y - 62, x + 16, y - 35, 6);
					ellipse('#e4ae79', x, y - 83, 15, 15);
					ellipse('#744e2a', x, y - 90, 24, 6.5);
				}
			}

			function paint() {
				background();
				const ordered = [...game.traps].sort((a, b) => b.z - a.z);
				ordered.forEach((trap) => { if (trap.z >= PLAYER_Z) drawTrap(trap); });
				drawPlayer();
				ordered.forEach((trap) => { if (trap.z < PLAYER_Z) drawTrap(trap); });
			}

			function updateHud() {
				distanceEl.textContent = `${Math.floor(game.distance)} m`;
				timeEl.textContent = `${game.time.toFixed(1)} s`;
				bestEl.textContent = `${best} m`;
			}

			function showOverlay(title, detail) {
				overlayTitle.textContent = title;
				overlayDetail.textContent = detail;
				overlay.hidden = false;
			}

			function endGame(reason) {
				game.alive = false;
				game.reason = reason;
				running = false;
				best = Math.max(best, Math.floor(game.distance));
				pauseButton.disabled = true;
				startButton.textContent = text.again;
				status.textContent = `${text.over} ${text[reason]}`;
				showOverlay(text.over, text[reason]);
				updateHud();
			}

			function advance(dt) {
				game.time += dt;
				const speed = Math.min(44, 19 + game.time * .23);
				game.distance += speed * dt;
				game.jump = Math.max(0, game.jump - dt);
				game.slide = Math.max(0, game.slide - dt);
				game.visualLane += (game.lane - game.visualLane) * Math.min(1, dt * 13);
				game.spawn -= dt;
				if (game.spawn <= 0) {
					const lanes = [-1, 0, 1];
					for (let i = lanes.length - 1; i > 0; i--) {
						const pick = Math.floor(Math.random() * (i + 1));
						[lanes[i], lanes[pick]] = [lanes[pick], lanes[i]];
					}
					const count = Math.random() < .333 ? 2 : 1;
					for (let i = 0; i < count; i++) {
						game.traps.push({lane: lanes[i], z: FAR,
							kind: ['spikes', 'beam', 'pillar'][Math.floor(Math.random() * 3)], checked: false});
					}
					game.spawn = 1.15 + Math.random() * .5;
				}
				for (const trap of game.traps) {
					const oldZ = trap.z;
					trap.z -= speed * dt;
					if (!trap.checked && oldZ >= PLAYER_Z && trap.z <= PLAYER_Z) {
						trap.checked = true;
						if (Math.abs(game.visualLane - trap.lane) < .58) {
							const safe = (trap.kind === 'spikes' && jumpHeight() > 48) ||
								(trap.kind === 'beam' && game.slide > 0);
							if (!safe) {
								endGame(trap.kind);
								break;
							}
						}
					}
				}
				game.traps = game.traps.filter((trap) => trap.z > -8);
				updateHud();
			}

			function loop(now) {
				if (!root.isConnected || !running) return;
				const dt = Math.min(Math.max(0, (now - lastFrame) / 1000), .04);
				lastFrame = now;
				if (!paused) advance(dt);
				paint();
				if (running) frameId = requestAnimationFrame(loop);
			}

			function start() {
				cancelAnimationFrame(frameId);
				game = freshGame();
				running = true;
				paused = false;
				startButton.textContent = text.again;
				pauseButton.disabled = false;
				pauseButton.textContent = text.pause;
				overlay.hidden = true;
				status.textContent = text.instructions;
				lastFrame = performance.now();
				updateHud();
				canvas.focus({preventScroll: true});
				frameId = requestAnimationFrame(loop);
			}

			function togglePause() {
				if (!running) return;
				paused = !paused;
				pauseButton.textContent = paused ? text.resume : text.pause;
				status.textContent = paused ? text.paused : text.instructions;
				if (paused) showOverlay(text.paused, text.resume);
				else overlay.hidden = true;
			}

			function act(action) {
				if (!running || paused) return;
				if (action === 'left') game.lane = Math.max(-1, game.lane - 1);
				else if (action === 'right') game.lane = Math.min(1, game.lane + 1);
				else if (action === 'jump' && game.jump <= 0 && game.slide <= 0) game.jump = JUMP_TIME;
				else if (action === 'slide' && game.jump <= 0 && game.slide <= 0) game.slide = SLIDE_TIME;
			}

			root.querySelectorAll('[data-action]').forEach((button) => {
				button.addEventListener('click', () => act(button.dataset.action));
			});
			startButton.addEventListener('click', start);
			pauseButton.addEventListener('click', togglePause);
			root.addEventListener('keydown', (event) => {
				const action = {
					ArrowLeft: 'left', ArrowRight: 'right', ArrowUp: 'jump', ArrowDown: 'slide'
				}[event.key];
				if (action && running) {
					event.preventDefault();
					act(action);
				} else if ((event.key === 'p' || event.key === 'P') && running) {
					event.preventDefault();
					togglePause();
				} else if ((event.key === 'r' || event.key === 'R') && event.target === canvas) {
					event.preventDefault();
					start();
				}
			});
			canvas.addEventListener('pointerdown', (event) => {
				touchStart = {x: event.clientX, y: event.clientY};
				canvas.focus({preventScroll: true});
			});
			canvas.addEventListener('pointerup', (event) => {
				if (!touchStart) return;
				const dx = event.clientX - touchStart.x;
				const dy = event.clientY - touchStart.y;
				touchStart = null;
				if (Math.max(Math.abs(dx), Math.abs(dy)) < 24) return;
				act(Math.abs(dx) > Math.abs(dy) ? (dx < 0 ? 'left' : 'right') :
					(dy < 0 ? 'jump' : 'slide'));
			});
			canvas.addEventListener('pointercancel', () => { touchStart = null; });
			document.addEventListener('visibilitychange', () => {
				if (document.hidden && running && !paused) togglePause();
			});

			updateHud();
			paint();
		});
	}

	if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot);
	else boot();
})();
