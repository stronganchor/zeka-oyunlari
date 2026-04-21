<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--word-balloon-pop {
	max-width: 560px;
	margin: 0 auto;
	padding: 14px;
	border: 2px solid #d8e2ec;
	border-radius: 14px;
	background: #f8fbff;
	font-family: Arial, sans-serif;
	box-sizing: border-box;
}

.zo-wb-title {
	text-align: center;
	margin: 0 0 10px;
}

.zo-wb-target {
	text-align: center;
	font-weight: 700;
	font-size: 18px;
	min-height: 30px;
}

.zo-wb-balloon-area {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 10px;
	margin-top: 12px;
}

.zo-wb-balloon {
	aspect-ratio: 1;
	border: 0;
	border-radius: 10px;
	background: #bae6fd;
	font-size: 20px;
	font-weight: 700;
	cursor: pointer;
}

.zo-wb-hud {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 8px;
	margin-top: 10px;
}

.zo-wb-stat,
.zo-wb-start,
.zo-wb-reset {
	padding: 10px;
	border-radius: 10px;
}

.zo-wb-stat {
	background: #eef2ff;
	text-align: center;
}

.zo-wb-start,
.zo-wb-reset {
	border: 0;
	background: #2563eb;
	color: #fff;
	font-weight: 700;
	cursor: pointer;
}

.zo-wb-status {
	min-height: 24px;
	text-align: center;
	font-weight: 700;
	margin-top: 10px;
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root');

	games.forEach(function (game) {
		if (!game.classList.contains('zo-game-root--word-balloon-pop')) {
			return;
		}

		const targetEl = game.querySelector('.zo-wb-target');
		const status = game.querySelector('.zo-wb-status');
		const area = game.querySelector('.zo-wb-balloon-area');
		const scoreEl = game.querySelector('.zo-wb-score');
		const livesEl = game.querySelector('.zo-wb-lives');
		const timeEl = game.querySelector('.zo-wb-time');
		const startBtn = game.querySelector('.zo-wb-start');
		const resetBtn = game.querySelector('.zo-wb-reset');

		let score = 0;
		let lives = 3;
		let timeLeft = 30;
		let target = 0;
		let running = false;
		let question = '';
		let spawnTimer = null;
		let timer = null;

		function updateHud() {
			scoreEl.textContent = String(score);
			livesEl.textContent = String(lives);
			timeEl.textContent = String(timeLeft) + 's';
		}

		function randomQuestion() {
			const a = Math.floor(Math.random() * 8) + 2;
			const b = Math.floor(Math.random() * 8) + 2;
			target = a + b;
			question = String(a) + ' + ' + String(b);
			targetEl.textContent = 'Find: ' + question + ' = ' + target;
		}

		function clearArea() {
			while (area.firstChild) {
				area.removeChild(area.firstChild);
			}
		}

		function spawnRound() {
			if (!running) {
				return;
			}
			clearArea();
			randomQuestion();
			const values = {};
			values[target] = true;
			while (Object.keys(values).length < 9) {
				const extra = Math.floor(Math.random() * 20);
				if (!values[extra]) {
					values[extra] = true;
				}
			}
			const list = Object.keys(values).map(function (item) {
				return Number(item);
			});
			for (let i = 0; i < 9; i++) {
				const idx = Math.floor(Math.random() * list.length);
				const value = list[idx];
				list.splice(idx, 1);
				const btn = document.createElement('button');
				btn.type = 'button';
				btn.className = 'zo-wb-balloon';
				btn.textContent = String(value);
				btn.addEventListener('click', function () {
					if (!running) {
						return;
					}
					if (value === target) {
						score += 1;
						status.textContent = 'Correct balloon!';
						updateHud();
						spawnRound();
					} else {
						lives -= 1;
						status.textContent = 'Wrong balloon.';
						updateHud();
						if (lives <= 0) {
							endGame();
						}
					}
				});
				area.appendChild(btn);
			}
		}

		function endGame() {
			running = false;
			if (spawnTimer) {
				clearInterval(spawnTimer);
				spawnTimer = null;
			}
			if (timer) {
				clearInterval(timer);
				timer = null;
			}
			status.textContent = 'Game over. Press Start.';
			clearArea();
		}

		function startGame() {
			score = 0;
			lives = 3;
			timeLeft = 30;
			running = true;
			updateHud();
			status.textContent = 'Pop the correct balloons.';
			spawnRound();
			spawnTimer = setInterval(function () {
				spawnRound();
			}, 3000);
			timer = setInterval(function () {
				timeLeft -= 1;
				updateHud();
				if (timeLeft <= 0) {
					endGame();
					status.textContent = 'Time is up. Score: ' + score;
				}
			}, 1000);
		}

		startBtn.addEventListener('click', function () {
			startGame();
		});

		resetBtn.addEventListener('click', function () {
			score = 0;
			lives = 3;
			timeLeft = 30;
			updateHud();
			running = false;
			targetEl.textContent = 'Press Start to begin.';
			status.textContent = 'Press Start.';
			clearArea();
			endGame();
		});

		updateHud();
		targetEl.textContent = 'Press Start to begin.';
		status.textContent = 'Press Start.';
	});
});
JS;

if (!function_exists('zo_game_word_balloon_pop_render')) {
	function zo_game_word_balloon_pop_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-word-balloon-pop-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--word-balloon-pop" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-wb-title">Word Balloon Pop</h2>
			<div class="zo-wb-target">Press Start to begin.</div>
			<div class="zo-wb-balloon-area"></div>
			<div class="zo-wb-hud">
				<div class="zo-wb-stat">Score <span class="zo-wb-score">0</span></div>
				<div class="zo-wb-stat">Lives <span class="zo-wb-lives">3</span></div>
				<div class="zo-wb-stat">Time <span class="zo-wb-time">30s</span></div>
				<button type="button" class="zo-wb-start">Start</button>
				<button type="button" class="zo-wb-reset">Reset</button>
			</div>
			<div class="zo-wb-status">Press Start.</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'word-balloon-pop',
	'name'            => 'Word Balloon Pop',
	'author'          => 'Asker',
	'description'     => 'Find and pop the balloon with the correct answer before time runs out.',
	'render_callback' => 'zo_game_word_balloon_pop_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
