<?php
if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root--echo-location {
	max-width: 960px;
	margin: 0 auto;
	padding: 18px;
	border: 1px solid rgba(13, 148, 136, 0.24);
	border-radius: 16px;
	background: #07111f;
	color: #e5f7ff;
	box-sizing: border-box;
	font-family: Arial, sans-serif;
}
.zo-game-root--echo-location .el-head {
	display: grid;
	grid-template-columns: 1fr auto;
	gap: 14px;
	align-items: start;
	margin-bottom: 14px;
}
.zo-game-root--echo-location .el-title {
	margin: 0 0 6px;
	font-size: 30px;
	line-height: 1.1;
	color: #ffffff;
}
.zo-game-root--echo-location .el-copy {
	margin: 0;
	color: #a7d8e8;
	line-height: 1.5;
}
.zo-game-root--echo-location .el-panel {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
	justify-content: flex-end;
}
.zo-game-root--echo-location .el-stat,
.zo-game-root--echo-location .el-btn {
	min-height: 40px;
	border-radius: 10px;
	padding: 8px 12px;
	box-sizing: border-box;
	font-weight: 700;
}
.zo-game-root--echo-location .el-stat {
	background: rgba(15, 23, 42, 0.82);
	border: 1px solid rgba(125, 211, 252, 0.2);
	color: #d8f3ff;
}
.zo-game-root--echo-location .el-btn {
	border: 0;
	background: #0d9488;
	color: #ffffff;
	cursor: pointer;
}
.zo-game-root--echo-location .el-btn:hover,
.zo-game-root--echo-location .el-btn:focus {
	background: #0f766e;
	outline: none;
}
.zo-game-root--echo-location .el-status {
	margin: 0 0 12px;
	min-height: 24px;
	color: #facc15;
	font-weight: 700;
}
.zo-game-root--echo-location .el-board {
	display: grid;
	grid-template-columns: repeat(11, minmax(0, 1fr));
	gap: 4px;
	width: min(100%, 650px);
	margin: 0 auto 14px;
	touch-action: manipulation;
}
.zo-game-root--echo-location .el-cell {
	aspect-ratio: 1;
	border: 1px solid rgba(148, 163, 184, 0.08);
	border-radius: 7px;
	background: #020617;
	box-sizing: border-box;
	position: relative;
	overflow: hidden;
}
.zo-game-root--echo-location .el-cell.is-seen {
	background: #102a3a;
	border-color: rgba(125, 211, 252, 0.35);
}
.zo-game-root--echo-location .el-cell.is-wall.is-seen {
	background: #274052;
	border-color: rgba(226, 232, 240, 0.24);
}
.zo-game-root--echo-location .el-cell.is-exit.is-seen {
	background: #14532d;
	border-color: #86efac;
}
.zo-game-root--echo-location .el-cell.is-player::after,
.zo-game-root--echo-location .el-cell.is-hunter.is-seen::after,
.zo-game-root--echo-location .el-cell.is-exit.is-seen::after {
	content: "";
	position: absolute;
	inset: 20%;
	border-radius: 999px;
}
.zo-game-root--echo-location .el-cell.is-player::after {
	background: #22d3ee;
	box-shadow: 0 0 18px #22d3ee;
}
.zo-game-root--echo-location .el-cell.is-hunter.is-seen::after {
	background: #fb7185;
	box-shadow: 0 0 18px #fb7185;
}
.zo-game-root--echo-location .el-cell.is-exit.is-seen::after {
	border-radius: 4px;
	background: #86efac;
	box-shadow: 0 0 16px #86efac;
}
.zo-game-root--echo-location .el-controls {
	display: grid;
	grid-template-columns: repeat(3, 54px);
	gap: 8px;
	justify-content: center;
	margin-top: 10px;
}
.zo-game-root--echo-location .el-move {
	min-height: 48px;
	border: 0;
	border-radius: 12px;
	background: #1e293b;
	color: #ffffff;
	font-size: 20px;
	font-weight: 700;
	cursor: pointer;
}
.zo-game-root--echo-location .el-move:hover,
.zo-game-root--echo-location .el-move:focus {
	background: #334155;
	outline: none;
}
.zo-game-root--echo-location .el-move[data-dir="up"] {
	grid-column: 2;
}
.zo-game-root--echo-location .el-move[data-dir="left"] {
	grid-column: 1;
}
.zo-game-root--echo-location .el-move[data-dir="pulse"] {
	grid-column: 2;
	background: #0d9488;
}
.zo-game-root--echo-location .el-move[data-dir="right"] {
	grid-column: 3;
}
.zo-game-root--echo-location .el-move[data-dir="down"] {
	grid-column: 2;
}
@media (max-width: 680px) {
	.zo-game-root--echo-location {
		padding: 14px;
	}
	.zo-game-root--echo-location .el-head {
		grid-template-columns: 1fr;
	}
	.zo-game-root--echo-location .el-panel {
		justify-content: flex-start;
	}
	.zo-game-root--echo-location .el-title {
		font-size: 25px;
	}
	.zo-game-root--echo-location .el-board {
		gap: 3px;
	}
	.zo-game-root--echo-location .el-cell {
		border-radius: 5px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener("DOMContentLoaded", function () {
	const root = document.querySelector(".zo-game-root--echo-location");
	if (!root) {
		return;
	}

	const boardEl = root.querySelector(".el-board");
	const statusEl = root.querySelector(".el-status");
	const stepsEl = root.querySelector("[data-el-steps]");
	const noiseEl = root.querySelector("[data-el-noise]");
	const resetBtn = root.querySelector("[data-el-reset]");
	const size = 11;
	const map = [
		"###########",
		"#P..#.....#",
		"#.#.#.###.#",
		"#.#...#...#",
		"#.#####.#.#",
		"#.....#.#.#",
		"###.#.#.#.#",
		"#...#...#.#",
		"#.#####.#E#",
		"#.........#",
		"###########"
	];
	const dirs = {
		up: { x: 0, y: -1 },
		down: { x: 0, y: 1 },
		left: { x: -1, y: 0 },
		right: { x: 1, y: 0 }
	};
	let cells = [];
	let player;
	let hunter;
	let exit;
	let seen;
	let steps;
	let noise;
	let over;

	function key(x, y) {
		return x + "," + y;
	}

	function isWall(x, y) {
		return y < 0 || y >= size || x < 0 || x >= size || map[y][x] === "#";
	}

	function reveal(radius) {
		for (let y = 0; y < size; y += 1) {
			for (let x = 0; x < size; x += 1) {
				const dist = Math.abs(player.x - x) + Math.abs(player.y - y);
				if (dist <= radius) {
					seen.add(key(x, y));
				}
			}
		}
	}

	function reset() {
		cells = [];
		seen = new Set();
		steps = 0;
		noise = 0;
		over = false;
		boardEl.innerHTML = "";

		for (let y = 0; y < size; y += 1) {
			for (let x = 0; x < size; x += 1) {
				const tile = map[y][x];
				if (tile === "P") {
					player = { x, y };
				}
				if (tile === "E") {
					exit = { x, y };
				}
				const cell = document.createElement("div");
				cell.className = "el-cell";
				cell.setAttribute("aria-hidden", "true");
				boardEl.appendChild(cell);
				cells.push(cell);
			}
		}
		hunter = { x: 9, y: 1 };
		reveal(2);
		statusEl.textContent = "Use sound only when you need it. Reach the green exit.";
		render();
	}

	function render() {
		cells.forEach(function (cell, index) {
			const x = index % size;
			const y = Math.floor(index / size);
			const tileKey = key(x, y);
			cell.className = "el-cell";
			if (seen.has(tileKey)) {
				cell.classList.add("is-seen");
			}
			if (map[y][x] === "#") {
				cell.classList.add("is-wall");
			}
			if (exit.x === x && exit.y === y) {
				cell.classList.add("is-exit");
			}
			if (player.x === x && player.y === y) {
				cell.classList.add("is-player", "is-seen");
			}
			if (hunter.x === x && hunter.y === y) {
				cell.classList.add("is-hunter");
			}
		});
		stepsEl.textContent = String(steps);
		noiseEl.textContent = String(noise);
	}

	function hunterOptions() {
		return Object.keys(dirs).map(function (dir) {
			const next = { x: hunter.x + dirs[dir].x, y: hunter.y + dirs[dir].y };
			return isWall(next.x, next.y) ? null : next;
		}).filter(Boolean);
	}

	function moveHunter() {
		const options = hunterOptions();
		if (!options.length) {
			return;
		}
		options.sort(function (a, b) {
			const da = Math.abs(player.x - a.x) + Math.abs(player.y - a.y);
			const db = Math.abs(player.x - b.x) + Math.abs(player.y - b.y);
			return da - db;
		});
		hunter = options[0];
	}

	function checkEnd() {
		if (player.x === hunter.x && player.y === hunter.y) {
			over = true;
			seen.add(key(hunter.x, hunter.y));
			statusEl.textContent = "Caught in the dark. Try shorter routes and fewer pulses.";
			render();
			return true;
		}
		if (player.x === exit.x && player.y === exit.y) {
			over = true;
			statusEl.textContent = "You escaped in " + steps + " steps with " + noise + " sound pulses.";
			render();
			return true;
		}
		return false;
	}

	function move(dir) {
		if (over || !dirs[dir]) {
			return;
		}
		const next = { x: player.x + dirs[dir].x, y: player.y + dirs[dir].y };
		if (isWall(next.x, next.y)) {
			statusEl.textContent = "A wall catches the echo. Pick another path.";
			reveal(1);
			render();
			return;
		}
		player = next;
		steps += 1;
		reveal(1);
		if (steps % 3 === 0 || noise > 2) {
			moveHunter();
		}
		if (!checkEnd()) {
			statusEl.textContent = "Soft step. Listen for the exit shape.";
			render();
		}
	}

	function pulse() {
		if (over) {
			return;
		}
		noise += 1;
		reveal(4);
		moveHunter();
		statusEl.textContent = "Echo pulse sent. The hunter heard it too.";
		checkEnd();
		render();
	}

	root.addEventListener("click", function (event) {
		const button = event.target.closest("[data-dir]");
		if (!button) {
			return;
		}
		const dir = button.getAttribute("data-dir");
		if (dir === "pulse") {
			pulse();
		} else {
			move(dir);
		}
	});

	document.addEventListener("keydown", function (event) {
		if (!root.isConnected) {
			return;
		}
		const tag = event.target && event.target.tagName ? event.target.tagName.toLowerCase() : "";
		if (tag === "input" || tag === "textarea" || tag === "select") {
			return;
		}
		const keys = {
			ArrowUp: "up",
			w: "up",
			W: "up",
			ArrowDown: "down",
			s: "down",
			S: "down",
			ArrowLeft: "left",
			a: "left",
			A: "left",
			ArrowRight: "right",
			d: "right",
			D: "right"
		};
		if (event.key === " " || event.key === "e" || event.key === "E") {
			event.preventDefault();
			pulse();
			return;
		}
		if (keys[event.key]) {
			event.preventDefault();
			move(keys[event.key]);
		}
	});

	resetBtn.addEventListener("click", reset);
	reset();
});
JS;

if (!function_exists('zo_game_echo_location_render')) {
	function zo_game_echo_location_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-echo-location-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--echo-location" id="<?php echo esc_attr($instance_id); ?>">
			<div class="el-head">
				<div>
					<h2 class="el-title">Echo-Location</h2>
					<p class="el-copy">Move through the dark maze. Send an echo to reveal more cells, but every pulse helps the hunter find you.</p>
				</div>
				<div class="el-panel">
					<div class="el-stat">Steps: <span data-el-steps>0</span></div>
					<div class="el-stat">Noise: <span data-el-noise>0</span></div>
					<button type="button" class="el-btn" data-el-reset>Restart</button>
				</div>
			</div>
			<p class="el-status" aria-live="polite"></p>
			<div class="el-board" role="img" aria-label="Dark echo maze"></div>
			<div class="el-controls" aria-label="Movement controls">
				<button type="button" class="el-move" data-dir="up" aria-label="Move up">↑</button>
				<button type="button" class="el-move" data-dir="left" aria-label="Move left">←</button>
				<button type="button" class="el-move" data-dir="pulse" aria-label="Send echo">●</button>
				<button type="button" class="el-move" data-dir="right" aria-label="Move right">→</button>
				<button type="button" class="el-move" data-dir="down" aria-label="Move down">↓</button>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug' => 'echo-location',
	'name' => 'Echo-Location',
	'author' => 'Arslan',
	'description' => 'Explore a dark maze by sending sound pulses, then escape before the hunter follows the noise.',
	'render_callback' => 'zo_game_echo_location_render',
	'inline_style' => $css,
	'inline_script' => $js,
);
