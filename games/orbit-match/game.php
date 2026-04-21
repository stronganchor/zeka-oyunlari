<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--orbit-match {
	max-width: 560px;
	margin: 0 auto;
	padding: 14px;
	border: 2px solid #d8e2ec;
	border-radius: 14px;
	background: #fbfdff;
	font-family: Arial, sans-serif;
	box-sizing: border-box;
}

.zo-om-title {
	text-align: center;
	margin: 0 0 10px;
}

.zo-om-panels {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 10px;
	margin-top: 10px;
}

.zo-om-slot {
	border: 2px solid #94a3b8;
	border-radius: 10px;
	padding: 12px;
	text-align: center;
}

.zo-om-slot-label {
	font-weight: 700;
}

.zo-om-value {
	font-size: 28px;
	font-weight: 700;
	margin: 8px 0;
}

.zo-om-controls button,
.zo-om-start,
.zo-om-check {
	border: 0;
	border-radius: 8px;
	padding: 10px;
	font-weight: 700;
	background: #2563eb;
	color: #fff;
	cursor: pointer;
}

.zo-om-target {
	background: #e0f2fe;
	border: 0;
	border-radius: 10px;
	padding: 10px;
	text-align: center;
	font-size: 18px;
}

.zo-om-hud {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 8px;
	margin-top: 10px;
}

.zo-om-stat {
	background: #eef2ff;
	border-radius: 10px;
	padding: 10px;
	text-align: center;
}

.zo-om-status {
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
		if (!game.classList.contains('zo-game-root--orbit-match')) {
			return;
		}

		const valueElements = game.querySelectorAll('.zo-om-value');
		const rotateButtons = game.querySelectorAll('.zo-om-rotate');
		const targetText = game.querySelector('.zo-om-target');
		const status = game.querySelector('.zo-om-status');
		const startBtn = game.querySelector('.zo-om-start');
		const checkBtn = game.querySelector('.zo-om-check');
		const scoreEl = game.querySelector('.zo-om-score');
		const movesEl = game.querySelector('.zo-om-moves');
		const levelEl = game.querySelector('.zo-om-level');

		const symbols = ['A', 'B', 'C', 'D', 'E'];
		let target = [];
		let current = [];
		let score = 0;
		let level = 1;

		function randomSymbol() {
			return symbols[Math.floor(Math.random() * symbols.length)];
		}

		function updateGrid() {
			valueElements.forEach(function (el, index) {
				el.textContent = current[index];
			});
		}

		function makeTarget() {
			target = [];
			for (let i = 0; i < 3; i++) {
				target.push(randomSymbol());
			}
			targetText.textContent = 'Target: ' + target.join('-');
		}

		function makeCurrent() {
			current = [];
			for (let i = 0; i < 3; i++) {
				current.push(randomSymbol());
			}
			updateGrid();
		}

		function newRound() {
			makeTarget();
			makeCurrent();
			status.textContent = 'Match the target in 5 moves.';
			updateHud();
		}

		function checkMatch() {
			let ok = true;
			let movesUsed = 0;
			for (let i = 0; i < target.length; i++) {
				if (current[i] === target[i]) {
					continue;
				}
				ok = false;
			}
			if (ok) {
				score += 1;
				level += 1;
				status.textContent = 'Aligned! Nice!';
				newRound();
			} else {
				status.textContent = 'Not aligned. Try again.';
			}
			if (!ok) {
				movesEl.textContent = String(level);
			}
		}

		function updateHud() {
			scoreEl.textContent = String(score);
			levelEl.textContent = String(level);
		}

		rotateButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				const slot = Number(button.dataset.slot);
				const currentSymbol = current[slot];
				const pos = symbols.indexOf(currentSymbol);
				const next = symbols[(pos + 1) % symbols.length];
				current[slot] = next;
				updateGrid();
			});
		});

		checkBtn.addEventListener('click', function () {
			checkMatch();
		});

		startBtn.addEventListener('click', function () {
			score = 0;
			level = 1;
			newRound();
		});

		updateHud();
		newRound();
	});
});
JS;

if (!function_exists('zo_game_orbit_match_render')) {
	function zo_game_orbit_match_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-orbit-match-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--orbit-match" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-om-title">Orbit Match</h2>
			<div class="zo-om-panels">
				<div class="zo-om-slot">
					<div class="zo-om-slot-label">Orbit 1</div>
					<div class="zo-om-value">A</div>
					<button type="button" class="zo-om-rotate" data-slot="0">Rotate</button>
				</div>
				<div class="zo-om-slot">
					<div class="zo-om-slot-label">Orbit 2</div>
					<div class="zo-om-value">B</div>
					<button type="button" class="zo-om-rotate" data-slot="1">Rotate</button>
				</div>
				<div class="zo-om-slot">
					<div class="zo-om-slot-label">Orbit 3</div>
					<div class="zo-om-value">C</div>
					<button type="button" class="zo-om-rotate" data-slot="2">Rotate</button>
				</div>
			</div>
			<div class="zo-om-controls">
				<div class="zo-om-target">Target: ---</div>
				<button type="button" class="zo-om-start">Start</button>
				<button type="button" class="zo-om-check">Check</button>
			</div>
			<div class="zo-om-hud">
				<div class="zo-om-stat">Score: <span class="zo-om-score">0</span></div>
				<div class="zo-om-stat">Level: <span class="zo-om-level">1</span></div>
				<div class="zo-om-stat">Moves Used: <span class="zo-om-moves">0</span></div>
			</div>
			<div class="zo-om-status">Press Start.</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'orbit-match',
	'name'            => 'Orbit Match',
	'author'          => 'Asker',
	'description'     => 'Rotate each orbit symbol to align with the target pattern.',
	'render_callback' => 'zo_game_orbit_match_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
