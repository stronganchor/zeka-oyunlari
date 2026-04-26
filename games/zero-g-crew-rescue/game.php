<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--zero-g-crew-rescue {
	--zgc-bg: linear-gradient(180deg, #07111f 0%, #0f172a 100%);
	--zgc-panel: rgba(15, 23, 42, 0.85);
	--zgc-ink: #dbeafe;
	--zgc-soft: #93c5fd;
	max-width: 980px;
	margin: 0 auto;
	padding: 20px;
	border-radius: 24px;
	border: 2px solid rgba(59, 130, 246, 0.22);
	background:
		radial-gradient(circle at top left, rgba(34, 211, 238, 0.18), transparent 24%),
		var(--zgc-bg);
	box-sizing: border-box;
	font-family: "Trebuchet MS", Verdana, sans-serif;
	color: var(--zgc-ink);
}

.zo-game-root--zero-g-crew-rescue .zo-zgc-title {
	margin: 0 0 8px;
	font-size: 34px;
	text-align: center;
	color: #f8fafc;
}

.zo-game-root--zero-g-crew-rescue .zo-zgc-desc {
	margin: 0 0 18px;
	text-align: center;
	line-height: 1.55;
	color: #bfdbfe;
}

.zo-game-root--zero-g-crew-rescue .zo-zgc-top {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 10px;
	margin-bottom: 14px;
}

.zo-game-root--zero-g-crew-rescue .zo-zgc-stat,
.zo-game-root--zero-g-crew-rescue .zo-zgc-panel {
	padding: 12px;
	border-radius: 16px;
	background: var(--zgc-panel);
	border: 1px solid rgba(147, 197, 253, 0.16);
}

.zo-game-root--zero-g-crew-rescue .zo-zgc-stat-label {
	display: block;
	margin-bottom: 4px;
	font-size: 12px;
	text-transform: uppercase;
	letter-spacing: 0.08em;
	color: #7dd3fc;
}

.zo-game-root--zero-g-crew-rescue .zo-zgc-stat-value {
	display: block;
	font-size: 24px;
	font-weight: 700;
}

.zo-game-root--zero-g-crew-rescue .zo-zgc-main {
	display: grid;
	grid-template-columns: 1.1fr 0.9fr;
	gap: 14px;
}

.zo-game-root--zero-g-crew-rescue .zo-zgc-board {
	display: grid;
	grid-template-columns: repeat(7, minmax(0, 1fr));
	gap: 6px;
}

.zo-game-root--zero-g-crew-rescue .zo-zgc-cell {
	position: relative;
	aspect-ratio: 1;
	border-radius: 12px;
	background: rgba(148, 163, 184, 0.08);
	border: 1px solid rgba(148, 163, 184, 0.12);
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 16px;
	font-weight: 700;
}

.zo-game-root--zero-g-crew-rescue .zo-zgc-cell.is-wall {
	background: linear-gradient(180deg, #334155 0%, #1e293b 100%);
}

.zo-game-root--zero-g-crew-rescue .zo-zgc-cell.is-exit {
	box-shadow: inset 0 0 0 2px rgba(34, 197, 94, 0.65);
}

.zo-game-root--zero-g-crew-rescue .zo-zgc-cell.is-exit::before {
	content: "AIR";
	font-size: 11px;
	color: #86efac;
}

.zo-game-root--zero-g-crew-rescue .zo-zgc-cell.is-crew::before {
	content: "C";
	position: absolute;
	width: 24px;
	height: 24px;
	line-height: 24px;
	border-radius: 999px;
	background: #38bdf8;
	color: #082f49;
	text-align: center;
}

.zo-game-root--zero-g-crew-rescue .zo-zgc-cell.is-player::after {
	content: "";
	position: absolute;
	inset: 22%;
	border-radius: 999px;
	background: #f8fafc;
	box-shadow: 0 0 22px rgba(248, 250, 252, 0.65);
}

.zo-game-root--zero-g-crew-rescue .zo-zgc-subtitle {
	margin: 0 0 10px;
	font-size: 18px;
	color: #f8fafc;
}

.zo-game-root--zero-g-crew-rescue .zo-zgc-controls {
	display: grid;
	grid-template-columns: repeat(3, minmax(0, 1fr));
	gap: 10px;
	margin-top: 12px;
}

.zo-game-root--zero-g-crew-rescue .zo-zgc-button {
	border: 0;
	border-radius: 14px;
	padding: 12px 14px;
	font-size: 14px;
	font-weight: 700;
	cursor: pointer;
	background: #1d4ed8;
	color: #ffffff;
}

.zo-game-root--zero-g-crew-rescue .zo-zgc-button--reset,
.zo-game-root--zero-g-crew-rescue .zo-zgc-button--next {
	background: #0f766e;
}

.zo-game-root--zero-g-crew-rescue .zo-zgc-button:disabled {
	opacity: 0.45;
	cursor: default;
}

.zo-game-root--zero-g-crew-rescue .zo-zgc-status {
	min-height: 44px;
	line-height: 1.55;
	color: #dbeafe;
}

.zo-game-root--zero-g-crew-rescue .zo-zgc-help {
	line-height: 1.55;
	color: #93c5fd;
}

@media (max-width: 860px) {
	.zo-game-root--zero-g-crew-rescue {
		padding: 14px;
	}

	.zo-game-root--zero-g-crew-rescue .zo-zgc-top {
		grid-template-columns: 1fr 1fr;
	}

	.zo-game-root--zero-g-crew-rescue .zo-zgc-main {
		grid-template-columns: 1fr;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const roots = document.querySelectorAll('.zo-game-root--zero-g-crew-rescue');

	roots.forEach(function (root) {
		const boardEl = root.querySelector('.zo-zgc-board');
		const sectorEl = root.querySelector('.zo-zgc-sector');
		const oxygenEl = root.querySelector('.zo-zgc-oxygen');
		const rescuedEl = root.querySelector('.zo-zgc-rescued');
		const exitEl = root.querySelector('.zo-zgc-exit');
		const statusEl = root.querySelector('.zo-zgc-status');

		const buttons = {
			up: root.querySelector('.zo-zgc-button--up'),
			left: root.querySelector('.zo-zgc-button--left'),
			right: root.querySelector('.zo-zgc-button--right'),
			down: root.querySelector('.zo-zgc-button--down'),
			reset: root.querySelector('.zo-zgc-button--reset'),
			next: root.querySelector('.zo-zgc-button--next')
		};

		const levels = [
			{
				name: 'Cargo Ring',
				oxygen: 13,
				player: { x: 0, y: 6 },
				exit: { x: 6, y: 0 },
				crew: ['1,1', '4,2', '5,5'],
				walls: ['2,0', '2,1', '2,2', '4,3', '4,4', '1,4', '2,4']
			},
			{
				name: 'Antenna Spine',
				oxygen: 12,
				player: { x: 6, y: 6 },
				exit: { x: 0, y: 0 },
				crew: ['5,1', '1,3', '3,5'],
				walls: ['4,0', '4,1', '4,2', '2,3', '2,4', '2,5', '5,4']
			},
			{
				name: 'Cryo Hall',
				oxygen: 14,
				player: { x: 0, y: 0 },
				exit: { x: 6, y: 6 },
				crew: ['1,5', '3,2', '5,0'],
				walls: ['1,1', '1,2', '5,2', '5,3', '3,4', '4,4', '5,4']
			}
		];

		let levelIndex = 0;
		let state = null;

		function keyFromPoint(point) {
			return point.x + ',' + point.y;
		}

		function loadLevel(index) {
			const level = levels[index];
			levelIndex = index;
			state = {
				name: level.name,
				oxygen: level.oxygen,
				player: { x: level.player.x, y: level.player.y },
				exit: { x: level.exit.x, y: level.exit.y },
				crew: level.crew.slice(),
				startCrewCount: level.crew.length,
				walls: level.walls.slice(),
				gameOver: false,
				waitingNext: false,
				message: 'Slide with zero gravity until the next wall stops you.'
			};
			render();
		}

		function hasWall(x, y) {
			return state.walls.indexOf(x + ',' + y) !== -1;
		}

		function rescueAt(x, y) {
			const key = x + ',' + y;
			const index = state.crew.indexOf(key);
			if (index !== -1) {
				state.crew.splice(index, 1);
				state.message = 'Crew rescued. Keep sliding toward the airlock.';
			}
		}

		function render() {
			boardEl.innerHTML = '';
			const exitKey = keyFromPoint(state.exit);
			const playerKey = keyFromPoint(state.player);

			for (let y = 0; y < 7; y += 1) {
				for (let x = 0; x < 7; x += 1) {
					const key = x + ',' + y;
					const cell = document.createElement('div');
					cell.className = 'zo-zgc-cell';

					if (hasWall(x, y)) {
						cell.classList.add('is-wall');
					}
					if (key === exitKey) {
						cell.classList.add('is-exit');
					}
					if (state.crew.indexOf(key) !== -1) {
						cell.classList.add('is-crew');
					}
					if (key === playerKey) {
						cell.classList.add('is-player');
					}

					boardEl.appendChild(cell);
				}
			}

			sectorEl.textContent = state.name;
			oxygenEl.textContent = String(state.oxygen);
			rescuedEl.textContent = String(state.startCrewCount - state.crew.length) + ' / ' + String(state.startCrewCount);
			exitEl.textContent = state.crew.length === 0 ? 'Ready' : 'Locked';
			statusEl.textContent = state.message;
			buttons.next.disabled = !state.waitingNext;

			['up', 'left', 'right', 'down'].forEach(function (key) {
				buttons[key].disabled = state.gameOver || state.waitingNext;
			});
		}

		function move(dx, dy) {
			if (state.gameOver || state.waitingNext) {
				return;
			}

			let x = state.player.x;
			let y = state.player.y;
			let moved = false;

			while (true) {
				const nextX = x + dx;
				const nextY = y + dy;

				if (nextX < 0 || nextX > 6 || nextY < 0 || nextY > 6 || hasWall(nextX, nextY)) {
					break;
				}

				x = nextX;
				y = nextY;
				moved = true;
				rescueAt(x, y);
			}

			if (!moved) {
				state.message = 'The mag boots hit a wall. Choose another direction.';
				render();
				return;
			}

			state.player = { x: x, y: y };
			state.oxygen -= 1;

			if (state.oxygen <= 0) {
				state.gameOver = true;
				state.message = 'Oxygen runs out before the rescue is complete.';
				render();
				return;
			}

			if (state.crew.length === 0 && keyFromPoint(state.player) === keyFromPoint(state.exit)) {
				if (levelIndex === levels.length - 1) {
					state.gameOver = true;
					state.message = 'All sectors clear. The whole crew reaches safety.';
				} else {
					state.waitingNext = true;
					state.message = 'Sector clear. Hit Next Sector to continue the rescue.';
				}
				render();
				return;
			}

			if (state.crew.length === 0) {
				state.message = 'All crew rescued. Now slide into the airlock.';
			} else {
				state.message = 'Course adjusted. Keep collecting the crew before the airlock run.';
			}

			render();
		}

		buttons.up.addEventListener('click', function () {
			move(0, -1);
		});
		buttons.left.addEventListener('click', function () {
			move(-1, 0);
		});
		buttons.right.addEventListener('click', function () {
			move(1, 0);
		});
		buttons.down.addEventListener('click', function () {
			move(0, 1);
		});
		buttons.reset.addEventListener('click', function () {
			loadLevel(levelIndex);
		});
		buttons.next.addEventListener('click', function () {
			if (state.waitingNext && levelIndex < levels.length - 1) {
				loadLevel(levelIndex + 1);
			}
		});

		loadLevel(0);
	});
});
JS;

if (!function_exists('zo_game_zero_g_crew_rescue_render')) {
	function zo_game_zero_g_crew_rescue_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-zero-g-crew-rescue-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--zero-g-crew-rescue" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-zgc-title">Zero-G Crew Rescue</h2>
			<p class="zo-zgc-desc">Each move sends your rescuer sliding until a wall catches them. Save the trapped crew and reach the airlock before the oxygen timer fails.</p>

			<div class="zo-zgc-top">
				<div class="zo-zgc-stat">
					<span class="zo-zgc-stat-label">Sector</span>
					<span class="zo-zgc-stat-value zo-zgc-sector">Cargo Ring</span>
				</div>
				<div class="zo-zgc-stat">
					<span class="zo-zgc-stat-label">Oxygen</span>
					<span class="zo-zgc-stat-value zo-zgc-oxygen">13</span>
				</div>
				<div class="zo-zgc-stat">
					<span class="zo-zgc-stat-label">Crew Rescued</span>
					<span class="zo-zgc-stat-value zo-zgc-rescued">0 / 3</span>
				</div>
				<div class="zo-zgc-stat">
					<span class="zo-zgc-stat-label">Airlock</span>
					<span class="zo-zgc-stat-value zo-zgc-exit">Locked</span>
				</div>
			</div>

			<div class="zo-zgc-main">
				<div class="zo-zgc-panel">
					<h3 class="zo-zgc-subtitle">Rescue Grid</h3>
					<div class="zo-zgc-board"></div>
				</div>

				<div class="zo-zgc-panel">
					<h3 class="zo-zgc-subtitle">Controls</h3>
					<p class="zo-zgc-status" aria-live="polite"></p>

					<div class="zo-zgc-controls">
						<div></div>
						<button type="button" class="zo-zgc-button zo-zgc-button--up">Up</button>
						<div></div>
						<button type="button" class="zo-zgc-button zo-zgc-button--left">Left</button>
						<button type="button" class="zo-zgc-button zo-zgc-button--down">Down</button>
						<button type="button" class="zo-zgc-button zo-zgc-button--right">Right</button>
					</div>

					<div class="zo-zgc-controls">
						<button type="button" class="zo-zgc-button zo-zgc-button--reset">Reset Sector</button>
						<button type="button" class="zo-zgc-button zo-zgc-button--next">Next Sector</button>
						<div></div>
					</div>

					<p class="zo-zgc-help">Blue crew markers must be picked up before the green airlock opens. Movement always slides until a wall or the edge stops you.</p>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug' => 'zero-g-crew-rescue',
	'name' => 'Zero-G Crew Rescue',
	'author' => 'asker',
	'description' => 'A space rescue game where every move slides in zero gravity and you must save the crew before oxygen runs out.',
	'render_callback' => 'zo_game_zero_g_crew_rescue_render',
	'inline_style' => $css,
	'inline_script' => $js,
);
