<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 640px;
	margin: 0 auto;
	text-align: center;
}

.zo-game-root--snake-game {
	font-family: Arial, sans-serif;
	background: #111;
	color: #fff;
	border-radius: 18px;
	padding: 16px;
}

.zo-game-root--snake-game .sg-title {
	font-size: 28px;
	margin-bottom: 10px;
}

.zo-game-root--snake-game .sg-board {
	display: grid;
	grid-template-columns: repeat(30, 1fr);
	gap: 1px;
	background: #333;
	margin: 0 auto 12px;
	aspect-ratio: 3/2;
}

.zo-game-root--snake-game .sg-cell {
	background: #000;
	width: 100%;
	height: 100%;
}

.zo-game-root--snake-game .sg-snake {
	background: #00cc00;
}

.zo-game-root--snake-game .sg-head {
	background: #007700;
}

.zo-game-root--snake-game .sg-food {
	background: red;
}

.zo-game-root--snake-game .sg-top {
	margin-bottom: 10px;
}

.zo-game-root--snake-game .sg-btn {
	padding: 10px 16px;
	border-radius: 10px;
	border: none;
	background: #2c4f9e;
	color: #fff;
	cursor: pointer;
	font-weight: bold;
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--snake-game');

	games.forEach(function (game) {
		const board = game.querySelector('[data-role="board"]');
		const scoreEl = game.querySelector('[data-role="score"]');
		const btn = game.querySelector('[data-role="restart"]');

		const WIDTH = 30;
		const HEIGHT = 20;

		let snake, direction, food, score, running, interval;

		function reset() {
			snake = [[5,5],[4,5],[3,5]];
			direction = 'RIGHT';
			score = 0;
			running = true;
			spawnFood();
			render();
			updateScore();
		}

		function spawnFood() {
			while (true) {
				const x = Math.floor(Math.random()*WIDTH);
				const y = Math.floor(Math.random()*HEIGHT);
				if (!snake.some(s => s[0]===x && s[1]===y)) {
					food = [x,y];
					return;
				}
			}
		}

		function step() {
			if (!running) return;

			let [x,y] = snake[0];

			if (direction==='UP') y--;
			if (direction==='DOWN') y++;
			if (direction==='LEFT') x--;
			if (direction==='RIGHT') x++;

			if (x<0 || x>=WIDTH || y<0 || y>=HEIGHT) {
				gameOver();
				return;
			}

			if (snake.some(s => s[0]===x && s[1]===y)) {
				gameOver();
				return;
			}

			snake.unshift([x,y]);

			if (x===food[0] && y===food[1]) {
				score++;
				spawnFood();
			} else {
				snake.pop();
			}

			updateScore();
			render();
		}

		function gameOver() {
			running = false;
			alert('Game Over. Score: '+score);
		}

		function updateScore() {
			scoreEl.textContent = score;
		}

		function render() {
			board.innerHTML = '';

			for (let y=0;y<HEIGHT;y++) {
				for (let x=0;x<WIDTH;x++) {
					const cell = document.createElement('div');
					cell.className = 'sg-cell';

					if (x===food[0] && y===food[1]) {
						cell.classList.add('sg-food');
					}

					snake.forEach((s,i)=>{
						if (s[0]===x && s[1]===y) {
							cell.classList.add(i===0?'sg-head':'sg-snake');
						}
					});

					board.appendChild(cell);
				}
			}
		}

		document.addEventListener('keydown', function(e){
			if (e.key==='ArrowUp' && direction!=='DOWN') direction='UP';
			if (e.key==='ArrowDown' && direction!=='UP') direction='DOWN';
			if (e.key==='ArrowLeft' && direction!=='RIGHT') direction='LEFT';
			if (e.key==='ArrowRight' && direction!=='LEFT') direction='RIGHT';
		});

		btn.addEventListener('click', function(){
			reset();
		});

		reset();
		interval = setInterval(step, 120);
	});
});
JS;

if (!function_exists('zo_game_snake_game_render')) {
	function zo_game_snake_game_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-snake-game-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--snake-game" id="<?php echo esc_attr($instance_id); ?>">
			<div class="sg-title">Snake Game</div>

			<div class="sg-top">
				Score: <span data-role="score">0</span>
			</div>

			<div class="sg-board" data-role="board"></div>

			<button class="sg-btn" data-role="restart">Restart</button>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'snake-game',
	'name'            => 'Snake Game',
	'author'          => 'Arslan',
	'description'     => 'Classic snake game converted from Python to browser.',
	'render_callback' => 'zo_game_snake_game_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);