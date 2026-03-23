<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 800px;
	margin: 0 auto;
	text-align: center;
	font-family: Arial, sans-serif;
}

.zo-game-root--tower-defense-lite .td-card {
	background: #ffffff;
	border: 2px solid #d9e2ec;
	border-radius: 18px;
	padding: 20px;
}

.zo-game-root--tower-defense-lite .td-grid {
	display: grid;
	grid-template-columns: repeat(8, 1fr);
	gap: 6px;
	margin: 16px 0;
}

.zo-game-root--tower-defense-lite .td-cell {
	width: 100%;
	padding-top: 100%;
	position: relative;
	background: #d1fae5;
	border-radius: 6px;
	cursor: pointer;
}

.zo-game-root--tower-defense-lite .td-cell-inner {
	position: absolute;
	inset: 0;
	display: flex;
	align-items: center;
	justify-content: center;
	font-weight: bold;
}

.zo-game-root--tower-defense-lite .td-path {
	background: #b45309;
}

.zo-game-root--tower-defense-lite .td-tower {
	background: #2563eb;
	color: #fff;
}

.zo-game-root--tower-defense-lite .td-enemy {
	background: #ef4444;
	color: #fff;
}

.zo-game-root--tower-defense-lite .td-ui {
	margin-top: 10px;
}

.zo-game-root--tower-defense-lite button {
	padding: 10px 14px;
	margin: 6px;
	border-radius: 8px;
	border: none;
	font-weight: bold;
	cursor: pointer;
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--tower-defense-lite');

	games.forEach(function (game) {

		const gridEl = game.querySelector('.td-grid');
		const statusEl = game.querySelector('.td-status');
		const moneyEl = game.querySelector('.td-money');
		const livesEl = game.querySelector('.td-lives');

		let size = 8;
		let money = 100;
		let lives = 10;
		let grid = [];
		let towers = [];
		let enemies = [];

		function initGrid() {
			grid = [];
			gridEl.innerHTML = '';

			for (let y = 0; y < size; y++) {
				for (let x = 0; x < size; x++) {

					let type = 'grass';
					if (x === 0 || x === 1) type = 'path';
					if (y === 3 || y === 4) type = 'path';

					const cell = document.createElement('div');
					cell.className = 'td-cell td-' + type;
					cell.dataset.x = x;
					cell.dataset.y = y;

					const inner = document.createElement('div');
					inner.className = 'td-cell-inner';
					cell.appendChild(inner);

					cell.addEventListener('click', function () {
						if (type === 'grass' && money >= 20) {
							type = 'tower';
							cell.className = 'td-cell td-tower';
							inner.textContent = 'T';
							towers.push({x,y});
							money -= 20;
							updateUI();
						}
					});

					grid.push({x,y,type,el:cell});
					gridEl.appendChild(cell);
				}
			}
		}

		function spawnEnemy() {
			enemies.push({x:0,y:3, hp:3});
		}

		function updateEnemies() {
			enemies.forEach(function(e){
				e.x++;

				if (e.x >= size) {
					lives--;
					e.dead = true;
				}
			});
		}

		function towerAttack() {
			towers.forEach(function(t){
				enemies.forEach(function(e){
					if (!e.dead && Math.abs(e.x - t.x) <= 1 && Math.abs(e.y - t.y) <= 1) {
						e.hp--;
						if (e.hp <= 0) {
							e.dead = true;
							money += 10;
						}
					}
				});
			});
		}

		function render() {
			grid.forEach(c=>{
				const inner = c.el.firstChild;
				if (c.type === 'path') inner.textContent = '';
				if (c.type === 'tower') inner.textContent = 'T';
			});

			enemies.forEach(e=>{
				if (!e.dead) {
					const cell = grid.find(c=>c.x===e.x && c.y===e.y);
					if (cell) {
						cell.el.firstChild.textContent = 'E';
					}
				}
			});
		}

		function cleanup() {
			enemies = enemies.filter(e=>!e.dead);
		}

		function updateUI() {
			moneyEl.textContent = money;
			livesEl.textContent = lives;
		}

		function loop() {
			if (lives <= 0) {
				statusEl.textContent = 'Game Over';
				return;
			}

			spawnEnemy();
			towerAttack();
			updateEnemies();
			cleanup();
			render();
			updateUI();

			setTimeout(loop, 1000);
		}

		initGrid();
		updateUI();
		loop();
	});
});
JS;

if (!function_exists('zo_game_tower_defense_lite_render')) {
	function zo_game_tower_defense_lite_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-tower-defense-lite-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--tower-defense-lite" id="<?php echo esc_attr($instance_id); ?>">
			<div class="td-card">
				<h2>Tower Defense Mini</h2>
				<p>Click grass to place towers. Stop enemies reaching the end.</p>

				<div class="td-grid"></div>

				<div class="td-ui">
					<div>Money: <span class="td-money">0</span></div>
					<div>Lives: <span class="td-lives">0</span></div>
					<div class="td-status"></div>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'tower-defense-lite',
	'name'            => 'Tower Defense Mini',
	'author'          => 'Arslan',
	'description'     => 'Simple tower defense game inspired by your Python version :contentReference[oaicite:0]{index=0}',
	'render_callback' => 'zo_game_tower_defense_lite_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);