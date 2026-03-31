<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root--puzzle-creator-pro {
	max-width: 760px;
	margin: 0 auto;
	padding: 20px;
	background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
	border-radius: 18px;
	color: #ffffff;
	box-sizing: border-box;
	font-family: inherit;
}

.zo-game-root--puzzle-creator-pro * {
	box-sizing: border-box;
}

.zo-game-root--puzzle-creator-pro h2 {
	margin: 0 0 8px;
	font-size: 26px;
}

.zo-game-root--puzzle-creator-pro p {
	margin: 0 0 12px;
	color: #cbd5e1;
	font-size: 14px;
}

.zo-game-root--puzzle-creator-pro .zo-pcp-panel {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
	margin-bottom: 12px;
}

.zo-game-root--puzzle-creator-pro .zo-pcp-btn {
	border: none;
	border-radius: 999px;
	padding: 8px 14px;
	font-weight: 700;
	cursor: pointer;
	background: #38bdf8;
	color: #0f172a;
	font-size: 13px;
}

.zo-game-root--puzzle-creator-pro .zo-pcp-btn-secondary {
	background: #e5e7eb;
	color: #111827;
}

.zo-game-root--puzzle-creator-pro .zo-pcp-status {
	min-height: 24px;
	margin-bottom: 10px;
	font-weight: 600;
	color: #facc15;
}

.zo-game-root--puzzle-creator-pro .zo-pcp-grid {
	display: grid;
	grid-template-columns: repeat(8, 1fr);
	gap: 4px;
	margin-bottom: 12px;
}

.zo-game-root--puzzle-creator-pro .zo-pcp-cell {
	width: 100%;
	aspect-ratio: 1 / 1;
	border-radius: 8px;
	background: #334155;
	cursor: pointer;
}

.zo-game-root--puzzle-creator-pro .zo-pcp-cell.wall { background: #22c55e; }
.zo-game-root--puzzle-creator-pro .zo-pcp-cell.start { background: #3b82f6; }
.zo-game-root--puzzle-creator-pro .zo-pcp-cell.goal { background: #ef4444; }

.zo-game-root--puzzle-creator-pro .zo-pcp-share {
	display: flex;
	gap: 6px;
	flex-wrap: wrap;
	margin-top: 10px;
}

.zo-game-root--puzzle-creator-pro input {
	padding: 6px;
	border-radius: 6px;
	border: none;
	font-size: 12px;
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--puzzle-creator-pro');

	games.forEach(function (game) {

		const grid = game.querySelector('.zo-pcp-grid');
		const statusEl = game.querySelector('.zo-pcp-status');
		const saveBtn = game.querySelector('.zo-pcp-save');
		const codeInput = game.querySelector('.zo-pcp-code');

		const size = 8;
		let mode = 'wall';
		let start = null;
		let goal = null;
		const cells = [];

		function encodePuzzle() {
			let data = '';
			cells.forEach(function (cell, i) {
				if (cell.classList.contains('start')) data += 'S';
				else if (cell.classList.contains('goal')) data += 'G';
				else if (cell.classList.contains('wall')) data += '1';
				else data += '0';
			});
			return btoa(data);
		}

		function decodePuzzle(code) {
			try {
				const data = atob(code);
				if (data.length !== size * size) return;
				data.split('').forEach(function (ch, i) {
					const cell = cells[i];
					cell.className = 'zo-pcp-cell';
					if (ch === '1') cell.classList.add('wall');
					if (ch === 'S') { cell.classList.add('start'); start = i; }
					if (ch === 'G') { cell.classList.add('goal'); goal = i; }
				});
				statusEl.textContent = 'Puzzle loaded.';
			} catch (e) {
				statusEl.textContent = 'Invalid code.';
			}
		}

		for (let i = 0; i < size * size; i++) {
			const cell = document.createElement('div');
			cell.className = 'zo-pcp-cell';

			cell.addEventListener('click', function () {
				cell.classList.remove('wall','start','goal');
				if (mode === 'wall') cell.classList.add('wall');
				if (mode === 'start') { 
					if (start !== null) cells[start].classList.remove('start');
					start = i;
					cell.classList.add('start');
				}
				if (mode === 'goal') { 
					if (goal !== null) cells[goal].classList.remove('goal');
					goal = i;
					cell.classList.add('goal');
				}
			});

			grid.appendChild(cell);
			cells.push(cell);
		}

		game.querySelector('.zo-pcp-mode-wall').onclick = () => { mode='wall'; };
		game.querySelector('.zo-pcp-mode-start').onclick = () => { mode='start'; };
		game.querySelector('.zo-pcp-mode-goal').onclick = () => { mode='goal'; };

		saveBtn.onclick = function () {
			const code = encodePuzzle();
			codeInput.value = code;
			statusEl.textContent = 'Puzzle code generated. Send this to admin.';
		};

		game.querySelector('.zo-pcp-load').onclick = function () {
			decodePuzzle(codeInput.value.trim());
		};
	});
});
JS;

if (!function_exists('zo_game_puzzle_creator_pro_render')) {
	function zo_game_puzzle_creator_pro_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-puzzle-creator-pro-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));
		ob_start();
		?>
		<div class="zo-game-root zo-game-root--puzzle-creator-pro" id="<?php echo esc_attr($instance_id); ?>">
			<h2>Puzzle Creator Pro</h2>
			<p>Create a maze. Save it as a code. Send the code to admin for approval.</p>

			<div class="zo-pcp-panel">
				<button type="button" class="zo-pcp-btn zo-pcp-mode-wall">Wall</button>
				<button type="button" class="zo-pcp-btn zo-pcp-mode-start">Start</button>
				<button type="button" class="zo-pcp-btn zo-pcp-mode-goal">Goal</button>
			</div>

			<div class="zo-pcp-status"></div>

			<div class="zo-pcp-grid"></div>

			<div class="zo-pcp-share">
				<button type="button" class="zo-pcp-btn zo-pcp-save">Generate Code</button>
				<input type="text" class="zo-pcp-code" placeholder="Puzzle code">
				<button type="button" class="zo-pcp-btn zo-pcp-btn-secondary zo-pcp-load">Load Code</button>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'puzzle-creator-pro',
	'name'            => 'Puzzle Creator Pro',
	'author'          => 'Asker',
	'description'     => 'Create, encode, and share puzzles for admin approval.',
	'render_callback' => 'zo_game_puzzle_creator_pro_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);