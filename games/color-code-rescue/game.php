<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--color-code-rescue {
	max-width: 560px;
	margin: 0 auto;
	padding: 14px;
	box-sizing: border-box;
	border: 2px solid #d8e2ec;
	border-radius: 14px;
	background: #fbfbff;
	font-family: Arial, sans-serif;
}

.zo-cc-title {
	text-align: center;
	margin: 0 0 10px;
}

.zo-cc-board {
	display: flex;
	gap: 10px;
	flex-wrap: wrap;
	justify-content: center;
	margin: 14px 0;
}

.zo-cc-btn {
	border: 0;
	border-radius: 50%;
	width: 76px;
	height: 76px;
	color: #fff;
	font-size: 16px;
	font-weight: 700;
	cursor: pointer;
}

.zo-cc-btn.is-active {
	box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.28);
	transform: scale(0.96);
}

.zo-cc-btn:disabled {
	opacity: 0.65;
}

.zo-cc-controls {
	display: grid;
	grid-template-columns: 1fr 1fr 1fr;
	gap: 8px;
	text-align: center;
}

.zo-cc-stat,
.zo-cc-start {
	border-radius: 10px;
	padding: 10px;
}

.zo-cc-start {
	border: 0;
	background: #2563eb;
	color: #fff;
	font-weight: 700;
	cursor: pointer;
}

.zo-cc-status {
	min-height: 24px;
	text-align: center;
	font-weight: 700;
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root');

	games.forEach(function (game) {
		if (!game.classList.contains('zo-game-root--color-code-rescue')) {
			return;
		}

		const startButton = game.querySelector('.zo-cc-start');
		const status = game.querySelector('.zo-cc-status');
		const scoreEl = game.querySelector('.zo-cc-score');
		const levelEl = game.querySelector('.zo-cc-level');
		const livesEl = game.querySelector('.zo-cc-lives');
		const buttons = game.querySelectorAll('.zo-cc-btn');
		const colorList = [
			['red', '#ef4444'],
			['blue', '#3b82f6'],
			['green', '#22c55e'],
			['yellow', '#f59e0b'],
		];

		colorList.forEach(function (entry) {
			const [id, color] = entry;
			const btn = game.querySelector('.zo-cc-btn[data-color="' + id + '"]');
			if (btn) {
				btn.style.background = color;
			}
		});

		let level = 1;
		let score = 0;
		let lives = 3;
		let sequence = [];
		let step = 0;
		let inputOpen = false;
		let isShowing = false;

		function newRound() {
			sequence = [];
			step = 0;
			inputOpen = false;
			isShowing = true;
			buttons.forEach(function (btn) {
				btn.disabled = true;
			});
			for (let i = 0; i < 3 + Math.min(4, level); i++) {
				sequence.push(Math.floor(Math.random() * colorList.length));
			}
			status.textContent = 'Watch the sequence.';
			sequence.forEach(function (idx, order) {
				setTimeout(function () {
					const btn = buttons[idx];
					btn.classList.add('is-active');
					setTimeout(function () {
						btn.classList.remove('is-active');
					}, 320);
				}, order * 720);
			});
			setTimeout(function () {
				isShowing = false;
				inputOpen = true;
				status.textContent = 'Now repeat.';
				buttons.forEach(function (btn) {
					btn.disabled = false;
				});
			}, sequence.length * 720 + 250);
		}

		function resetGame() {
			level = 1;
			score = 0;
			lives = 3;
			scoreEl.textContent = '0';
			levelEl.textContent = '1';
			livesEl.textContent = '3';
			status.textContent = 'Press Start.';
			buttons.forEach(function (btn) {
				btn.disabled = false;
			});
			newRound();
		}

		function failGame(reason) {
			lives -= 1;
			livesEl.textContent = String(Math.max(0, lives));
			if (lives <= 0) {
				inputOpen = false;
				isShowing = false;
				buttons.forEach(function (btn) {
					btn.disabled = true;
				});
				status.textContent = reason + ' Game over. Press Start.';
			} else {
				status.textContent = reason + ' Try this round again.';
				inputOpen = false;
				buttons.forEach(function (btn) {
					btn.disabled = true;
				});
				setTimeout(newRound, 550);
			}
		}

		buttons.forEach(function (btn, index) {
			btn.addEventListener('click', function () {
				if (isShowing || !inputOpen) {
					return;
				}
				if (index !== sequence[step]) {
					failGame('Wrong color.');
					return;
				}
				step += 1;
				if (step >= sequence.length) {
					score += 1;
					level += 1;
					scoreEl.textContent = String(score);
					levelEl.textContent = String(level);
					status.textContent = 'Correct! Next level.';
					inputOpen = false;
					buttons.forEach(function (b) {
						b.disabled = true;
					});
					setTimeout(newRound, 650);
				}
			});
		});

		startButton.addEventListener('click', function () {
			resetGame();
		});

		status.textContent = 'Press Start.';
		scoreEl.textContent = '0';
		levelEl.textContent = '1';
		livesEl.textContent = '3';
	});
});
JS;

if (!function_exists('zo_game_color_code_rescue_render')) {
	function zo_game_color_code_rescue_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-color-code-rescue-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--color-code-rescue" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-cc-title">Color Code Rescue</h2>
			<div class="zo-cc-controls">
				<div class="zo-cc-stat">Score: <span class="zo-cc-score">0</span></div>
				<div class="zo-cc-stat">Level: <span class="zo-cc-level">1</span></div>
				<div class="zo-cc-stat">Lives: <span class="zo-cc-lives">3</span></div>
				<button type="button" class="zo-cc-start">Start</button>
			</div>
			<div class="zo-cc-board">
				<button type="button" class="zo-cc-btn" data-color="red" aria-label="Red"></button>
				<button type="button" class="zo-cc-btn" data-color="blue" aria-label="Blue"></button>
				<button type="button" class="zo-cc-btn" data-color="green" aria-label="Green"></button>
				<button type="button" class="zo-cc-btn" data-color="yellow" aria-label="Yellow"></button>
			</div>
			<div class="zo-cc-status">Press Start.</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'color-code-rescue',
	'name'            => 'Color Code Rescue',
	'author'          => 'Asker',
	'description'     => 'Watch a color sequence and repeat it to save the code.',
	'render_callback' => 'zo_game_color_code_rescue_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
