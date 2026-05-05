<?php

if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('zo_arslan_arcade_game_module')) {
	function zo_arslan_arcade_game_module($config) {
		$slug = sanitize_title(isset($config['slug']) ? $config['slug'] : '');
		$name = isset($config['name']) ? (string) $config['name'] : $slug;

		return array(
			'slug'            => $slug,
			'name'            => $name,
			'author'          => 'Arslan',
			'description'     => isset($config['description']) ? (string) $config['description'] : 'A fast mini arcade challenge by Arslan.',
			'render_callback' => 'zo_arslan_arcade_render',
			'inline_style'    => zo_arslan_arcade_style(),
			'inline_script'   => zo_arslan_arcade_script(),
			'arslan_config'   => $config,
		);
	}
}

if (!function_exists('zo_arslan_arcade_style')) {
	function zo_arslan_arcade_style() {
		return <<<'CSS'
.zo-game-root--arslan-arcade {
	min-height: calc(100vh - 110px);
	display: grid;
	grid-template-rows: auto 1fr auto;
	gap: 12px;
	padding: 14px;
	box-sizing: border-box;
	background: linear-gradient(135deg, var(--zo-aa-bg-a), var(--zo-aa-bg-b));
	color: #f8fafc;
	font-family: Arial, sans-serif;
	overflow: hidden;
}

.zo-game-root--arslan-arcade * {
	box-sizing: border-box;
}

.zo-aa-top {
	display: grid;
	grid-template-columns: 1fr auto;
	gap: 12px;
	align-items: center;
}

.zo-aa-title {
	margin: 0;
	font-size: clamp(24px, 4vw, 42px);
	line-height: 1.05;
}

.zo-aa-goal {
	margin: 6px 0 0;
	max-width: 780px;
	font-size: 15px;
	line-height: 1.35;
	color: rgba(248, 250, 252, 0.84);
}

.zo-aa-panel {
	display: flex;
	flex-wrap: wrap;
	justify-content: flex-end;
	gap: 8px;
}

.zo-aa-stat,
.zo-aa-button {
	min-width: 82px;
	padding: 9px 11px;
	border: 1px solid rgba(255, 255, 255, 0.22);
	border-radius: 8px;
	background: rgba(15, 23, 42, 0.52);
	color: #fff;
	font-weight: 700;
	text-align: center;
}

.zo-aa-stat span {
	display: block;
	margin-top: 2px;
	font-size: 20px;
}

.zo-aa-button {
	cursor: pointer;
	background: var(--zo-aa-accent);
	color: #07111f;
}

.zo-aa-stage {
	position: relative;
	min-height: 440px;
	border: 2px solid rgba(255, 255, 255, 0.22);
	border-radius: 8px;
	overflow: hidden;
	background:
		radial-gradient(circle at 20% 18%, rgba(255, 255, 255, 0.12), transparent 24%),
		linear-gradient(0deg, rgba(15, 23, 42, 0.4), rgba(15, 23, 42, 0.08));
	touch-action: none;
}

.zo-aa-canvas {
	display: block;
	width: 100%;
	height: 100%;
	min-height: 440px;
}

.zo-aa-overlay {
	position: absolute;
	inset: 0;
	display: grid;
	place-items: center;
	padding: 18px;
	background: rgba(2, 6, 23, 0.5);
}

.zo-aa-card {
	width: min(520px, 100%);
	border: 1px solid rgba(255, 255, 255, 0.24);
	border-radius: 8px;
	padding: 18px;
	background: rgba(15, 23, 42, 0.82);
	text-align: center;
}

.zo-aa-card strong {
	display: block;
	margin-bottom: 8px;
	font-size: 24px;
}

.zo-aa-card p {
	margin: 0;
	color: rgba(248, 250, 252, 0.82);
	line-height: 1.45;
}

.zo-aa-bottom {
	display: grid;
	grid-template-columns: 1fr auto;
	gap: 12px;
	align-items: center;
	color: rgba(248, 250, 252, 0.84);
}

.zo-aa-keys {
	display: flex;
	gap: 6px;
	justify-content: flex-end;
}

.zo-aa-key {
	min-width: 34px;
	height: 30px;
	display: grid;
	place-items: center;
	border: 1px solid rgba(255, 255, 255, 0.2);
	border-radius: 6px;
	background: rgba(15, 23, 42, 0.56);
	font-weight: 700;
}

@media (max-width: 760px) {
	.zo-game-root--arslan-arcade {
		min-height: calc(100vh - 84px);
		padding: 10px;
	}

	.zo-aa-top,
	.zo-aa-bottom {
		grid-template-columns: 1fr;
	}

	.zo-aa-panel,
	.zo-aa-keys {
		justify-content: flex-start;
	}

	.zo-aa-stage,
	.zo-aa-canvas {
		min-height: 390px;
	}
}
CSS;
	}
}

if (!function_exists('zo_arslan_arcade_script')) {
	function zo_arslan_arcade_script() {
		return <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	document.querySelectorAll('.zo-game-root--arslan-arcade').forEach(function (root) {
		if (root.dataset.ready === '1') {
			return;
		}
		root.dataset.ready = '1';

		const config = JSON.parse(root.querySelector('.zo-aa-config').textContent);
		const canvas = root.querySelector('.zo-aa-canvas');
		const ctx = canvas.getContext('2d');
		const scoreEl = root.querySelector('.zo-aa-score');
		const livesEl = root.querySelector('.zo-aa-lives');
		const timeEl = root.querySelector('.zo-aa-time');
		const overlay = root.querySelector('.zo-aa-overlay');
		const overlayTitle = root.querySelector('.zo-aa-overlay-title');
		const overlayText = root.querySelector('.zo-aa-overlay-text');
		const startButton = root.querySelector('.zo-aa-start');

		const state = {
			width: 960,
			height: 560,
			score: 0,
			lives: 3,
			time: 60,
			running: false,
			last: 0,
			spawnTimer: 0,
			hazardTimer: 0,
			items: [],
			hazards: [],
			keys: {},
			pointer: null,
			player: { x: 120, y: 280, r: 17, vx: 0, vy: 0 }
		};

		function resize() {
			const rect = canvas.getBoundingClientRect();
			const dpr = Math.max(1, Math.min(2, window.devicePixelRatio || 1));
			canvas.width = Math.max(320, Math.floor(rect.width * dpr));
			canvas.height = Math.max(320, Math.floor(rect.height * dpr));
			state.width = canvas.width / dpr;
			state.height = canvas.height / dpr;
			ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
		}

		function rand(min, max) {
			return min + Math.random() * (max - min);
		}

		function dist(a, b) {
			const dx = a.x - b.x;
			const dy = a.y - b.y;
			return Math.sqrt(dx * dx + dy * dy);
		}

		function spawnItem() {
			state.items.push({
				x: rand(36, state.width - 36),
				y: rand(44, state.height - 44),
				r: rand(10, 15),
				spin: rand(0, Math.PI * 2),
				label: config.item
			});
		}

		function spawnHazard() {
			const side = Math.floor(rand(0, 4));
			const h = {
				x: side === 0 ? -20 : side === 1 ? state.width + 20 : rand(0, state.width),
				y: side === 2 ? -20 : side === 3 ? state.height + 20 : rand(0, state.height),
				r: rand(14, 22),
				vx: rand(-80, 80),
				vy: rand(-80, 80),
				label: config.hazard
			};
			const dx = state.player.x - h.x;
			const dy = state.player.y - h.y;
			const length = Math.max(1, Math.sqrt(dx * dx + dy * dy));
			const speed = rand(55, 115) + Number(config.speed || 0);
			h.vx = dx / length * speed;
			h.vy = dy / length * speed;
			state.hazards.push(h);
		}

		function startGame() {
			state.score = 0;
			state.lives = 3;
			state.time = 60;
			state.running = true;
			state.last = performance.now();
			state.spawnTimer = 0;
			state.hazardTimer = 0;
			state.items = [];
			state.hazards = [];
			state.player.x = 90;
			state.player.y = state.height / 2;
			overlay.hidden = true;
			for (let i = 0; i < 7; i++) {
				spawnItem();
			}
			for (let i = 0; i < 4; i++) {
				spawnHazard();
			}
			updateHud();
			requestAnimationFrame(tick);
		}

		function updateHud() {
			scoreEl.textContent = String(state.score);
			livesEl.textContent = String(state.lives);
			timeEl.textContent = String(Math.max(0, Math.ceil(state.time)));
		}

		function finish(won) {
			state.running = false;
			overlay.hidden = false;
			overlayTitle.textContent = won ? 'Mission complete!' : 'Try again!';
			overlayText.textContent = won
				? 'You mastered ' + config.name + ' with ' + state.score + ' points.'
				: 'You reached ' + state.score + ' points. Press Start and go again.';
		}

		function input(dt) {
			let ax = 0;
			let ay = 0;
			if (state.keys.ArrowLeft || state.keys.KeyA) ax -= 1;
			if (state.keys.ArrowRight || state.keys.KeyD) ax += 1;
			if (state.keys.ArrowUp || state.keys.KeyW) ay -= 1;
			if (state.keys.ArrowDown || state.keys.KeyS) ay += 1;
			if (state.pointer) {
				const dx = state.pointer.x - state.player.x;
				const dy = state.pointer.y - state.player.y;
				const length = Math.max(1, Math.sqrt(dx * dx + dy * dy));
				ax += dx / length;
				ay += dy / length;
			}
			const length = Math.max(1, Math.sqrt(ax * ax + ay * ay));
			const speed = 235 + Number(config.speed || 0);
			state.player.vx = ax / length * speed;
			state.player.vy = ay / length * speed;
			state.player.x = Math.max(state.player.r, Math.min(state.width - state.player.r, state.player.x + state.player.vx * dt));
			state.player.y = Math.max(state.player.r, Math.min(state.height - state.player.r, state.player.y + state.player.vy * dt));
		}

		function update(dt) {
			state.time -= dt;
			state.spawnTimer -= dt;
			state.hazardTimer -= dt;
			if (state.spawnTimer <= 0 && state.items.length < 10) {
				state.spawnTimer = 0.75;
				spawnItem();
			}
			if (state.hazardTimer <= 0 && state.hazards.length < 5 + Number(config.difficulty || 0)) {
				state.hazardTimer = 1.4;
				spawnHazard();
			}
			state.hazards.forEach(function (h) {
				h.x += h.vx * dt;
				h.y += h.vy * dt;
			});
			state.hazards = state.hazards.filter(function (h) {
				return h.x > -90 && h.x < state.width + 90 && h.y > -90 && h.y < state.height + 90;
			});
			for (let i = state.items.length - 1; i >= 0; i--) {
				if (dist(state.player, state.items[i]) < state.player.r + state.items[i].r) {
					state.items.splice(i, 1);
					state.score += 10;
				}
			}
			for (let i = state.hazards.length - 1; i >= 0; i--) {
				if (dist(state.player, state.hazards[i]) < state.player.r + state.hazards[i].r) {
					state.hazards.splice(i, 1);
					state.lives -= 1;
				}
			}
			if (state.score >= Number(config.target || 180)) {
				finish(true);
			} else if (state.lives <= 0 || state.time <= 0) {
				finish(false);
			}
			updateHud();
		}

		function drawBadge(x, y, radius, fill, stroke, label) {
			ctx.save();
			ctx.translate(x, y);
			ctx.fillStyle = fill;
			ctx.strokeStyle = stroke;
			ctx.lineWidth = 3;
			ctx.beginPath();
			ctx.arc(0, 0, radius, 0, Math.PI * 2);
			ctx.fill();
			ctx.stroke();
			ctx.fillStyle = '#03111f';
			ctx.font = '700 ' + Math.max(10, Math.floor(radius * 0.76)) + 'px Arial';
			ctx.textAlign = 'center';
			ctx.textBaseline = 'middle';
			ctx.fillText(String(label).slice(0, 2).toUpperCase(), 0, 1);
			ctx.restore();
		}

		function drawGrid() {
			ctx.strokeStyle = 'rgba(255,255,255,0.08)';
			ctx.lineWidth = 1;
			const gap = 48;
			for (let x = 0; x < state.width; x += gap) {
				ctx.beginPath();
				ctx.moveTo(x, 0);
				ctx.lineTo(x, state.height);
				ctx.stroke();
			}
			for (let y = 0; y < state.height; y += gap) {
				ctx.beginPath();
				ctx.moveTo(0, y);
				ctx.lineTo(state.width, y);
				ctx.stroke();
			}
		}

		function draw() {
			ctx.clearRect(0, 0, state.width, state.height);
			drawGrid();
			ctx.fillStyle = 'rgba(255,255,255,0.07)';
			for (let i = 0; i < 12; i++) {
				const x = (i * 137 + performance.now() * 0.015) % state.width;
				const y = (i * 83) % state.height;
				ctx.fillRect(x, y, 46, 3);
			}
			state.items.forEach(function (item) {
				item.spin += 0.03;
				drawBadge(item.x, item.y, item.r, config.itemColor, '#ffffff', item.label);
			});
			state.hazards.forEach(function (h) {
				drawBadge(h.x, h.y, h.r, config.hazardColor, '#111827', h.label);
			});
			drawBadge(state.player.x, state.player.y, state.player.r + 4, config.heroColor, '#ffffff', config.hero);
		}

		function tick(now) {
			if (!state.running) {
				draw();
				return;
			}
			const dt = Math.min(0.033, (now - state.last) / 1000 || 0);
			state.last = now;
			input(dt);
			update(dt);
			draw();
			if (state.running) {
				requestAnimationFrame(tick);
			}
		}

		window.addEventListener('resize', function () {
			resize();
			draw();
		});
		window.addEventListener('keydown', function (event) {
			state.keys[event.code] = true;
			if (['ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'Space'].indexOf(event.code) !== -1) {
				event.preventDefault();
			}
		});
		window.addEventListener('keyup', function (event) {
			state.keys[event.code] = false;
		});
		canvas.addEventListener('pointerdown', function (event) {
			const rect = canvas.getBoundingClientRect();
			state.pointer = { x: event.clientX - rect.left, y: event.clientY - rect.top };
			canvas.setPointerCapture(event.pointerId);
		});
		canvas.addEventListener('pointermove', function (event) {
			if (!state.pointer) {
				return;
			}
			const rect = canvas.getBoundingClientRect();
			state.pointer.x = event.clientX - rect.left;
			state.pointer.y = event.clientY - rect.top;
		});
		canvas.addEventListener('pointerup', function () {
			state.pointer = null;
		});
		startButton.addEventListener('click', startGame);
		resize();
		draw();
	});
});
JS;
	}
}

if (!function_exists('zo_arslan_arcade_render')) {
	function zo_arslan_arcade_render($post_id = 0, $module = array()) {
		$config = isset($module['arslan_config']) && is_array($module['arslan_config']) ? $module['arslan_config'] : array();
		$name = isset($config['name']) ? (string) $config['name'] : 'Arslan Arcade';
		$goal = isset($config['goal']) ? (string) $config['goal'] : 'Collect the good objects and avoid the danger.';
		$accent = isset($config['accent']) ? (string) $config['accent'] : '#38bdf8';
		$bg_a = isset($config['bgA']) ? (string) $config['bgA'] : '#0f172a';
		$bg_b = isset($config['bgB']) ? (string) $config['bgB'] : '#164e63';
		$instance_id = 'zo-arslan-arcade-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div
			class="zo-game-root zo-game-root--arslan-arcade"
			id="<?php echo esc_attr($instance_id); ?>"
			style="<?php echo esc_attr('--zo-aa-accent:' . $accent . ';--zo-aa-bg-a:' . $bg_a . ';--zo-aa-bg-b:' . $bg_b . ';'); ?>"
		>
			<script type="application/json" class="zo-aa-config"><?php echo wp_json_encode($config); ?></script>
			<div class="zo-aa-top">
				<div>
					<h2 class="zo-aa-title"><?php echo esc_html($name); ?></h2>
					<p class="zo-aa-goal"><?php echo esc_html($goal); ?></p>
				</div>
				<div class="zo-aa-panel" aria-label="Game stats">
					<div class="zo-aa-stat">Score <span class="zo-aa-score">0</span></div>
					<div class="zo-aa-stat">Lives <span class="zo-aa-lives">3</span></div>
					<div class="zo-aa-stat">Time <span class="zo-aa-time">60</span></div>
					<button type="button" class="zo-aa-button zo-aa-start">Start</button>
				</div>
			</div>
			<div class="zo-aa-stage">
				<canvas class="zo-aa-canvas" aria-label="<?php echo esc_attr($name); ?> game area"></canvas>
				<div class="zo-aa-overlay">
					<div class="zo-aa-card">
						<strong class="zo-aa-overlay-title"><?php echo esc_html($name); ?></strong>
						<p class="zo-aa-overlay-text"><?php echo esc_html($goal); ?> Press Start, then move with arrows, WASD, or touch.</p>
					</div>
				</div>
			</div>
			<div class="zo-aa-bottom">
				<div>Collect the bright targets. Dodge the moving hazards. Reach the score goal before time runs out.</div>
				<div class="zo-aa-keys" aria-label="Controls">
					<span class="zo-aa-key">W</span>
					<span class="zo-aa-key">A</span>
					<span class="zo-aa-key">S</span>
					<span class="zo-aa-key">D</span>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}
