(() => {
	'use strict';

	function boot() {
		document.querySelectorAll('.zo-game-root--blocky-bear-adventure').forEach((root) => {
			if (root.dataset.ready) return;
			root.dataset.ready = '1';

			const text = JSON.parse(root.dataset.labels);
			const canvas = root.querySelector('canvas');
			const ctx = canvas.getContext('2d');
			if (!ctx) return;
			const overlay = root.querySelector('.zo-bear-overlay');
			const overlayTitle = root.querySelector('.zo-bear-overlay-title');
			const overlayDetail = root.querySelector('.zo-bear-overlay-detail');
			const status = root.querySelector('.zo-bear-status');
			const startButton = root.querySelector('.zo-bear-start');
			const pauseButton = root.querySelector('.zo-bear-pause');
			const heartsEl = root.querySelector('.zo-bear-hearts');
			const coinsEl = root.querySelector('.zo-bear-coins');
			const W = 960, H = 600, WORLD_WIDTH = 3300, GROUND = 520;
			const BEAR_W = 42, BEAR_H = 64;
			const STEP = 1 / 60;
			const platforms = [
				[0, GROUND, 740, 100], [850, GROUND, 760, 100],
				[1740, GROUND, 710, 100], [2600, GROUND, 700, 100],
				[260, 410, 160, 24], [520, 320, 150, 24],
				[990, 410, 180, 24], [1280, 330, 160, 24],
				[1820, 410, 180, 24], [2100, 320, 170, 24],
				[2700, 410, 170, 24], [2940, 340, 160, 24]
			];
			const coinPositions = [
				[300, 375], [380, 375], [560, 285], [630, 285],
				[780, 400], [1030, 375], [1120, 375],
				[1320, 295], [1400, 295], [1665, 400],
				[1860, 375], [1950, 375], [2140, 285], [2220, 285],
				[2520, 390], [2740, 375], [2820, 375],
				[2980, 305], [3060, 305]
			];
			const enemyPositions = [
				[460, 430, 680], [1220, 1180, 1520],
				[2270, 2040, 2390], [2870, 2740, 3100]
			];
			let game = freshGame();
			let active = false;
			let paused = false;
			let lastFrame = 0;
			let accumulator = 0;
			let frameId = 0;
			const held = new Set();
			const pointerHeld = new Set();

			function freshGame() {
				return {
					x: 65, y: 440, vx: 0, vy: 0, grounded: false,
					jumpRequest: false, hearts: 3, invincible: 0,
					score: 0, state: 'playing', tick: 0, camera: 0,
					coins: coinPositions.map(([x, y]) => ({x, y, taken: false})),
					enemies: enemyPositions.map(([x, lo, hi]) => ({
						x, y: GROUND - 40, lo, hi, speed: 1.7, alive: true
					}))
				};
			}

			function overlaps(ax, ay, aw, ah, bx, by, bw, bh) {
				return ax < bx + bw && ax + aw > bx && ay < by + bh && ay + ah > by;
			}

			function updateHud() {
				heartsEl.textContent = '♥ '.repeat(game.hearts).trim() || '♡';
				heartsEl.setAttribute('aria-label', String(game.hearts));
				coinsEl.textContent = `${game.score} / ${game.coins.length}`;
			}

			function showOverlay(title, detail) {
				overlayTitle.textContent = title;
				overlayDetail.textContent = detail;
				overlay.hidden = false;
			}

			function finish(outcome) {
				game.state = outcome;
				active = false;
				pauseButton.disabled = true;
				startButton.textContent = text.again;
				status.textContent = text[outcome];
				showOverlay(text[outcome], `${text.coins}: ${game.score} / ${game.coins.length}`);
				updateHud();
			}

			function hurt(fell) {
				if (game.invincible > 0 && !fell) return;
				game.hearts--;
				if (game.hearts <= 0) {
					finish('lost');
					return;
				}
				game.invincible = 100;
				if (fell) {
					const ground = platforms.filter((p) => p[1] === GROUND && p[0] <= game.x).pop() || platforms[0];
					game.x = ground[0] + 25;
					game.y = GROUND - 80;
					game.vx = 0;
					game.vy = 0;
				} else {
					game.vy = -8;
				}
				updateHud();
			}

			function update() {
				if (game.state !== 'playing') return;
				game.tick++;
				game.invincible = Math.max(0, game.invincible - 1);
				const left = held.has('left') || pointerHeld.has('left');
				const right = held.has('right') || pointerHeld.has('right');
				game.vx = (Number(right) - Number(left)) * 5;
				if (game.jumpRequest && game.grounded) {
					game.vy = -14;
					game.grounded = false;
				}
				game.jumpRequest = false;

				let nextX = Math.max(0, Math.min(WORLD_WIDTH - BEAR_W, game.x + game.vx));
				for (const [px, py, pw, ph] of platforms) {
					if (!overlaps(nextX, game.y, BEAR_W, BEAR_H, px, py, pw, ph)) continue;
					if (game.vx > 0) nextX = Math.min(nextX, px - BEAR_W);
					else if (game.vx < 0) nextX = Math.max(nextX, px + pw);
				}
				game.x = nextX;
				const oldBottom = game.y + BEAR_H;
				const oldTop = game.y;
				game.vy = Math.min(game.vy + .65, 16);
				let nextY = game.y + game.vy;
				game.grounded = false;
				for (const [px, py, pw, ph] of platforms) {
					if (!overlaps(game.x, nextY, BEAR_W, BEAR_H, px, py, pw, ph)) continue;
					if (game.vy > 0 && oldBottom <= py) {
						nextY = py - BEAR_H;
						game.vy = 0;
						game.grounded = true;
					} else if (game.vy < 0 && oldTop >= py + ph) {
						nextY = py + ph;
						game.vy = 0;
					}
				}
				game.y = nextY;
				if (game.y > H + 100) {
					hurt(true);
					if (game.state !== 'playing') return;
				}

				for (const coin of game.coins) {
					if (!coin.taken && overlaps(game.x, game.y, BEAR_W, BEAR_H,
						coin.x - 11, coin.y - 11, 22, 22)) {
						coin.taken = true;
						game.score++;
					}
				}
				for (const enemy of game.enemies) {
					if (!enemy.alive) continue;
					enemy.x += enemy.speed;
					if (enemy.x < enemy.lo || enemy.x > enemy.hi) enemy.speed *= -1;
					if (overlaps(game.x, game.y, BEAR_W, BEAR_H, enemy.x, enemy.y, 42, 40)) {
						if (game.vy > 0 && oldBottom <= enemy.y + 10) {
							enemy.alive = false;
							game.vy = -10;
						} else {
							hurt(false);
						}
					}
				}
				if (game.x > 3190 && game.state === 'playing') finish('won');
				game.camera = Math.max(0, Math.min(WORLD_WIDTH - W, game.x - W * .36));
				updateHud();
			}

			function rect(x, y, w, h, color, stroke) {
				ctx.fillStyle = color;
				ctx.fillRect(x, y, w, h);
				if (stroke) {
					ctx.strokeStyle = stroke;
					ctx.lineWidth = 2;
					ctx.strokeRect(x, y, w, h);
				}
			}

			function worldRect(x, y, w, h, color, stroke) {
				rect(x - game.camera, y, w, h, color, stroke);
			}

			function ellipse(x, y, rx, ry, color, stroke, lineWidth) {
				ctx.beginPath();
				ctx.ellipse(x, y, rx, ry, 0, 0, Math.PI * 2);
				ctx.fillStyle = color;
				ctx.fill();
				if (stroke) {
					ctx.strokeStyle = stroke;
					ctx.lineWidth = lineWidth || 2;
					ctx.stroke();
				}
			}

			function bear() {
				if (game.invincible > 0 && game.tick % 8 < 4) return;
				const x = game.x, y = game.y;
				worldRect(x + 3, y, 11, 14, '#794214');
				worldRect(x + 29, y, 11, 14, '#794214');
				worldRect(x, y + 9, 42, 31, '#b96b24', '#653813');
				worldRect(x + 8, y + 22, 26, 15, '#ffe1a0');
				worldRect(x + 10, y + 15, 5, 7, '#251c18');
				worldRect(x + 28, y + 15, 5, 7, '#251c18');
				worldRect(x + 18, y + 25, 8, 5, '#251c18');
				worldRect(x + 5, y + 40, 32, 20, '#93501c');
				worldRect(x + 13, y + 41, 17, 16, '#f8d18a');
				worldRect(x + 5, y + 58, 12, 6, '#633813');
				worldRect(x + 27, y + 58, 12, 6, '#633813');
			}

			function paint() {
				rect(0, 0, W, H, '#69c9f2');
				for (let x = -100; x < WORLD_WIDTH; x += 360) {
					const sx = x - game.camera * .3;
					if (sx > W + 530 || sx < -530) continue;
					ellipse(sx + 265, 527.5, 265, 172.5, '#82cf69');
				}
				for (let x = 100; x < WORLD_WIDTH; x += 460) {
					const sx = x - game.camera * .5;
					if (sx > W + 110 || sx < -110) continue;
					rect(sx, 90, 110, 30, '#fff');
					rect(sx + 22, 70, 58, 50, '#fff');
				}
				for (const [x, y, w, h] of platforms) {
					if (x + w < game.camera || x > game.camera + W) continue;
					worldRect(x, y, w, h, '#a86b35');
					worldRect(x, y, w, 12, '#50b732');
					for (let tx = x + 18; tx < x + w; tx += 48) worldRect(tx, y + 18, 18, 6, '#bc8246');
				}
				for (const coin of game.coins) {
					if (coin.taken || coin.x < game.camera - 20 || coin.x > game.camera + W + 20) continue;
					const sy = coin.y + Math.sin(game.tick * .08 + coin.x) * 3;
					ellipse(coin.x - game.camera, sy, 10, 10, '#ffd52f', '#d68d0d', 3);
				}
				for (const enemy of game.enemies) {
					if (!enemy.alive || enemy.x < game.camera - 50 || enemy.x > game.camera + W + 50) continue;
					const x = enemy.x, y = enemy.y;
					worldRect(x + 5, y - 12, 8, 15, '#ee418e');
					worldRect(x + 29, y - 12, 8, 15, '#ee418e');
					worldRect(x, y, 42, 40, '#e92b7f', '#ad1d60');
					worldRect(x + 7, y + 10, 9, 10, '#fff');
					worldRect(x + 26, y + 10, 9, 10, '#fff');
					worldRect(x + 11, y + 13, 4, 6, '#241b29');
					worldRect(x + 27, y + 13, 4, 6, '#241b29');
				}
			worldRect(3210, 350, 7, 170, '#fff5d8');
			worldRect(3217, 350, 65, 40, '#ffb526');
			bear();
		}

		function loop(now) {
			if (!root.isConnected || !active) return;
			const elapsed = Math.min(Math.max(0, (now - lastFrame) / 1000), .1);
			lastFrame = now;
			if (!paused) {
				accumulator += elapsed;
				while (accumulator >= STEP && active) {
					update();
					accumulator -= STEP;
				}
			}
			paint();
			if (active) frameId = requestAnimationFrame(loop);
		}

		function start() {
			cancelAnimationFrame(frameId);
			game = freshGame();
			held.clear();
			pointerHeld.clear();
			active = true;
			paused = false;
			accumulator = 0;
			lastFrame = performance.now();
			startButton.textContent = text.again;
			pauseButton.disabled = false;
			pauseButton.textContent = text.pause;
			overlay.hidden = true;
			status.textContent = text.instructions;
			updateHud();
			canvas.focus({preventScroll: true});
			frameId = requestAnimationFrame(loop);
		}

		function togglePause() {
			if (!active) return;
			paused = !paused;
			held.clear();
			pointerHeld.clear();
			pauseButton.textContent = paused ? text.resume : text.pause;
			status.textContent = paused ? text.paused : text.instructions;
			if (paused) showOverlay(text.paused, text.resume);
			else overlay.hidden = true;
		}

		function jump() {
			if (active && !paused) game.jumpRequest = true;
		}

		root.querySelectorAll('[data-action]').forEach((button) => {
			const action = button.dataset.action;
			button.addEventListener('pointerdown', (event) => {
				event.preventDefault();
				if (action === 'jump') jump();
				else if (active && !paused) pointerHeld.add(action);
				if (button.setPointerCapture) button.setPointerCapture(event.pointerId);
			});
			const release = () => pointerHeld.delete(action);
			button.addEventListener('pointerup', release);
			button.addEventListener('pointercancel', release);
			button.addEventListener('lostpointercapture', release);
			button.addEventListener('click', (event) => {
				if (event.detail !== 0 || !active || paused) return;
				if (action === 'jump') jump();
				else {
					pointerHeld.add(action);
					update();
					pointerHeld.delete(action);
					paint();
				}
			});
		});
		startButton.addEventListener('click', start);
		pauseButton.addEventListener('click', togglePause);
		root.addEventListener('keydown', (event) => {
			const key = event.key.toLowerCase();
			if (key === 'r') {
				event.preventDefault();
				start();
				return;
			}
			if (key === 'p' && active) {
				event.preventDefault();
				if (!event.repeat) togglePause();
				return;
			}
			const action = (key === 'a' || key === 'arrowleft') ? 'left' :
				(key === 'd' || key === 'arrowright') ? 'right' :
				(key === 'w' || key === 'arrowup' || key === ' ' || key === 'spacebar') ? 'jump' : '';
			if (!action || !active) return;
			event.preventDefault();
			if (action === 'jump' && !held.has('jump')) jump();
			held.add(action);
		});
		root.addEventListener('keyup', (event) => {
			const key = event.key.toLowerCase();
			if (key === 'a' || key === 'arrowleft') held.delete('left');
			if (key === 'd' || key === 'arrowright') held.delete('right');
			if (key === 'w' || key === 'arrowup' || key === ' ' || key === 'spacebar') held.delete('jump');
		});
		canvas.addEventListener('pointerdown', () => {
			canvas.focus({preventScroll: true});
			jump();
		});
		window.addEventListener('blur', () => { held.clear(); pointerHeld.clear(); });
		document.addEventListener('visibilitychange', () => {
			if (document.hidden && active && !paused) togglePause();
		});

		updateHud();
		paint();
		});
	}

	if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot);
	else boot();
})();
