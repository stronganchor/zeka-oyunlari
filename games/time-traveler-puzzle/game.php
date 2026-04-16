<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 600px;
	margin: 0 auto;
	padding: 20px;
	text-align: center;
	font-family: Arial, sans-serif;
}

.zo-game-root--time-traveler-puzzle h2 {
	color: #333;
	margin-bottom: 10px;
}

.zo-game-root--time-traveler-puzzle .instructions {
	background: #f0f0f0;
	padding: 10px;
	border-radius: 5px;
	margin-bottom: 15px;
	font-size: 14px;
}

.zo-game-root--time-traveler-puzzle .time-period {
	display: flex;
	gap: 10px;
	justify-content: center;
	margin-bottom: 15px;
}

.zo-game-root--time-traveler-puzzle .time-period button {
	padding: 10px 20px;
	font-size: 14px;
	border: 2px solid #ccc;
	background: white;
	border-radius: 5px;
	cursor: pointer;
	transition: all 0.3s;
}

.zo-game-root--time-traveler-puzzle .time-period button.active {
	background: #4CAF50;
	color: white;
	border-color: #4CAF50;
}

.zo-game-root--time-traveler-puzzle .puzzle-grid {
	display: grid;
	grid-template-columns: repeat(3, 80px);
	gap: 10px;
	justify-content: center;
	margin: 20px auto;
}

.zo-game-root--time-traveler-puzzle .puzzle-cell {
	width: 80px;
	height: 80px;
	font-size: 24px;
	border: 2px solid #999;
	background: white;
	cursor: pointer;
	border-radius: 5px;
	transition: all 0.2s;
}

.zo-game-root--time-traveler-puzzle .puzzle-cell:hover {
	transform: scale(1.05);
	background: #f9f9f9;
}

.zo-game-root--time-traveler-puzzle .puzzle-cell.correct {
	background: #4CAF50;
	color: white;
	border-color: #45a049;
}

.zo-game-root--time-traveler-puzzle .puzzle-cell.wrong {
	background: #f44336;
	color: white;
	border-color: #da190b;
}

.zo-game-root--time-traveler-puzzle .score {
	font-size: 18px;
	margin: 15px 0;
	color: #333;
}

.zo-game-root--time-traveler-puzzle button.restart {
	padding: 10px 20px;
	font-size: 16px;
	background: #2196F3;
	color: white;
	border: none;
	border-radius: 5px;
	cursor: pointer;
	transition: background 0.3s;
}

.zo-game-root--time-traveler-puzzle button.restart:hover {
	background: #0b7dda;
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--time-traveler-puzzle');

	games.forEach(function (game) {
		const pastBtn = game.querySelector('.past-btn');
		const futureBtn = game.querySelector('.future-btn');
		const grid = game.querySelector('.puzzle-grid');
		const scoreDisplay = game.querySelector('.score');
		const restartBtn = game.querySelector('.restart');

		let currentMode = 'past';
		let score = 0;
		let completed = 0;

		const puzzles = {
			past: [
				{ symbol: '🌍', answer: '1' },
				{ symbol: '⚔️', answer: '2' },
				{ symbol: '🏛️', answer: '3' }
			],
			future: [
				{ symbol: '🚀', answer: '1' },
				{ symbol: '🤖', answer: '2' },
				{ symbol: '💫', answer: '3' }
			]
		};

		function switchMode(mode) {
			currentMode = mode;
			if (mode === 'past') {
				pastBtn.classList.add('active');
				futureBtn.classList.remove('active');
			} else {
				futureBtn.classList.add('active');
				pastBtn.classList.remove('active');
			}
			renderPuzzle();
		}

		function renderPuzzle() {
			grid.innerHTML = '';
			const puzzle = puzzles[currentMode];
			puzzle.forEach((item, idx) => {
				const cell = document.createElement('div');
				cell.className = 'puzzle-cell';
				cell.textContent = item.symbol;
				cell.dataset.index = idx;
				if (idx < completed) {
					cell.classList.add('correct');
				}
				cell.addEventListener('click', function () {
					checkAnswer(idx, item.answer);
				});
				grid.appendChild(cell);
			});
		}

		function checkAnswer(idx, answer) {
			if (idx === completed) {
				const cell = grid.querySelector(`[data-index="${idx}"]`);
				cell.classList.add('correct');
				completed++;
				score += 10;
				updateScore();

				if (completed === 3) {
					setTimeout(() => {
						if (currentMode === 'past') {
							switchMode('future');
							completed = 0;
						} else {
							alert('🎉 You solved all puzzles! Total Score: ' + score);
						}
					}, 500);
				}
			}
		}

		function updateScore() {
			scoreDisplay.textContent = 'Score: ' + score;
		}

		function restart() {
			currentMode = 'past';
			score = 0;
			completed = 0;
			switchMode('past');
			updateScore();
		}

		pastBtn.addEventListener('click', () => switchMode('past'));
		futureBtn.addEventListener('click', () => switchMode('future'));
		restartBtn.addEventListener('click', restart);

		renderPuzzle();
		updateScore();
	});
});
JS;

if (!function_exists('zo_game_time_traveler_puzzle_render')) {
	function zo_game_time_traveler_puzzle_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-time-traveler-puzzle-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--time-traveler-puzzle" id="<?php echo esc_attr($instance_id); ?>">
			<h2>⏰ Time Traveler Puzzle</h2>
			<div class="instructions">Solve puzzles in Past mode, then Future mode to win!</div>
			
			<div class="time-period">
				<button class="past-btn active">🌍 Past</button>
				<button class="future-btn">🚀 Future</button>
			</div>

			<div class="puzzle-grid"></div>
			
			<div class="score">Score: 0</div>
			<button class="restart">Restart Game</button>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'time-traveler-puzzle',
	'name'            => 'Time Traveler Puzzle',
	'author'          => 'Asker',
	'description'     => 'Solve logic puzzles by switching between past and future versions of the level.',
	'render_callback' => 'zo_game_time_traveler_puzzle_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
