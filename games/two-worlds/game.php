<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 600px;
	margin: 0 auto;
	text-align: center;
	font-family: Arial, sans-serif;
}

.two-worlds-grid {
	display: grid;
	grid-template-columns: repeat(5, 50px);
	grid-template-rows: repeat(5, 50px);
	gap: 2px;
	margin: 20px auto;
	justify-content: center;
}

.two-worlds-cell {
	width: 50px;
	height: 50px;
	border: 1px solid #000;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 20px;
}

.two-worlds-wall-a {
	background-color: #f00;
}

.two-worlds-wall-b {
	background-color: #00f;
}

.two-worlds-player {
	background-color: #0f0;
	color: white;
}

.two-worlds-goal {
	background-color: #ff0;
}

.two-worlds-controls {
	margin: 20px;
}

.two-worlds-controls button {
	margin: 5px;
	padding: 10px;
	font-size: 16px;
}

.two-worlds-instructions {
	margin-bottom: 20px;
}

.two-worlds-status {
	font-size: 18px;
	margin: 10px;
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--two-worlds');

	games.forEach(function (game) {
		let world = 'a';
		let playerPos = { x: 0, y: 0 };
		const gridSize = 5;
		const goalPos = { x: 4, y: 4 };

		const grid = game.querySelector('.two-worlds-grid');
		const status = game.querySelector('.two-worlds-status');
		const switchBtn = game.querySelector('.switch-world');
		const restartBtn = game.querySelector('.restart');

		// Walls: true if wall in that world
		const wallsA = [
			[false, false, false, false, false],
			[true, false, false, false, false],
			[false, false, true, false, false],
			[false, false, false, false, true],
			[false, false, false, false, false]
		];
		const wallsB = [
			[false, true, false, false, false],
			[false, false, false, false, false],
			[false, false, false, true, false],
			[false, true, false, false, false],
			[false, false, false, false, false]
		];

		function renderGrid() {
			grid.innerHTML = '';
			for (let y = 0; y < gridSize; y++) {
				for (let x = 0; x < gridSize; x++) {
					const cell = document.createElement('div');
					cell.classList.add('two-worlds-cell');
					if (x === playerPos.x && y === playerPos.y) {
						cell.classList.add('two-worlds-player');
						cell.textContent = 'P';
					} else if (x === goalPos.x && y === goalPos.y) {
						cell.classList.add('two-worlds-goal');
						cell.textContent = 'G';
					} else {
						const isWallA = wallsA[y][x];
						const isWallB = wallsB[y][x];
						if (world === 'a' && isWallA) {
							cell.classList.add('two-worlds-wall-a');
							cell.textContent = 'A';
						} else if (world === 'b' && isWallB) {
							cell.classList.add('two-worlds-wall-b');
							cell.textContent = 'B';
						}
					}
					grid.appendChild(cell);
				}
			}
			status.textContent = `World: ${world.toUpperCase()}`;
		}

		function movePlayer(dx, dy) {
			const newX = playerPos.x + dx;
			const newY = playerPos.y + dy;
			if (newX >= 0 && newX < gridSize && newY >= 0 && newY < gridSize) {
				const isWall = (world === 'a' ? wallsA[newY][newX] : wallsB[newY][newX]);
				if (!isWall) {
					playerPos.x = newX;
					playerPos.y = newY;
					renderGrid();
					checkWin();
				}
			}
		}

		function switchWorld() {
			world = world === 'a' ? 'b' : 'a';
			renderGrid();
		}

		function checkWin() {
			if (playerPos.x === goalPos.x && playerPos.y === goalPos.y) {
				status.textContent = 'You Win!';
				switchBtn.disabled = true;
			}
		}

		function restart() {
			playerPos = { x: 0, y: 0 };
			world = 'a';
			switchBtn.disabled = false;
			renderGrid();
		}

		// Event listeners
		game.querySelector('.move-up').addEventListener('click', () => movePlayer(0, -1));
		game.querySelector('.move-down').addEventListener('click', () => movePlayer(0, 1));
		game.querySelector('.move-left').addEventListener('click', () => movePlayer(-1, 0));
		game.querySelector('.move-right').addEventListener('click', () => movePlayer(1, 0));
		switchBtn.addEventListener('click', switchWorld);
		restartBtn.addEventListener('click', restart);

		// Initial render
		renderGrid();
	});
});
JS;

if (!function_exists('zo_game_two_worlds_render')) {
	function zo_game_two_worlds_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-two-worlds-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--two-worlds" id="<?php echo esc_attr($instance_id); ?>">
			<h2>Two Worlds</h2>
			<div class="two-worlds-instructions">
				<p>Move the player (P) to the goal (G) by switching between worlds A and B. Red walls are in world A, blue walls are in world B.</p>
			</div>
			<div class="two-worlds-status"></div>
			<div class="two-worlds-grid"></div>
			<div class="two-worlds-controls">
				<button class="move-up">Up</button><br>
				<button class="move-left">Left</button>
				<button class="move-right">Right</button><br>
				<button class="move-down">Down</button><br>
				<button class="switch-world">Switch World</button>
				<button class="restart">Restart</button>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'two-worlds',
	'name'            => 'Two Worlds',
	'author'          => 'arslan',
	'description'     => 'Switch between dimensions to solve puzzles.',
	'render_callback' => 'zo_game_two_worlds_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
