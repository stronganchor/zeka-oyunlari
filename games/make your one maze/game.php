<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root--puzzle-creator-admin {
	max-width: 760px;
	margin: 0 auto;
	padding: 20px;
	background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
	border-radius: 18px;
	color: #ffffff;
	box-sizing: border-box;
	font-family: inherit;
}

.zo-pca-grid {
	display: grid;
	grid-template-columns: repeat(8, 1fr);
	gap: 4px;
	margin-bottom: 12px;
}

.zo-pca-cell {
	aspect-ratio: 1 / 1;
	border-radius: 8px;
	background: #334155;
	cursor: pointer;
}

.zo-pca-cell.wall { background: #22c55e; }
.zo-pca-cell.start { background: #3b82f6; }
.zo-pca-cell.goal { background: #ef4444; }
.zo-pca-cell.player { outline: 3px solid #facc15; }

.zo-pca-panel,
.zo-pca-admin,
.zo-pca-approved {
	margin-bottom: 12px;
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
}

.zo-pca-btn {
	border: none;
	border-radius: 999px;
	padding: 8px 14px;
	font-weight: 700;
	cursor: pointer;
	background: #38bdf8;
	color: #0f172a;
	font-size: 13px;
}

.zo-pca-btn-secondary {
	background: #e5e7eb;
	color: #111827;
}

.zo-pca-status {
	min-height: 24px;
	font-weight: 600;
	color: #facc15;
	margin-bottom: 10px;
}

.zo-pca-approved-list {
	width: 100%;
	background: rgba(255,255,255,0.06);
	padding: 8px;
	border-radius: 10px;
	font-size: 12px;
	word-break: break-all;
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--puzzle-creator-admin');

	games.forEach(function (game) {

		const ADMIN_PASSWORD = "asker1905123";

		const grid = game.querySelector('.zo-pca-grid');
		const statusEl = game.querySelector('.zo-pca-status');
		const codeInput = game.querySelector('.zo-pca-code');
		const approvedBox = game.querySelector('.zo-pca-approved-list');

		const size = 8;
		let mode = 'wall';
		let start = null;
		let goal = null;
		let player = null;
		let isAdmin = false;
		const cells = [];

		function saveApprovedList(list) {
			localStorage.setItem('zo_pca_approved', JSON.stringify(list));
		}

		function getApprovedList() {
			return JSON.parse(localStorage.getItem('zo_pca_approved') || '[]');
		}

		function renderApproved() {
			const list = getApprovedList();
			approvedBox.textContent = list.length ? list.join('\n') : 'No approved puzzles yet.';
		}

		function encodePuzzle() {
			let data = '';
			cells.forEach(function (cell) {
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
				start = null;
				goal = null;
				data.split('').forEach(function (ch, i) {
					const cell = cells[i];
					cell.className = 'zo-pca-cell';
					if (ch === '1') cell.classList.add('wall');
					if (ch === 'S') { cell.classList.add('start'); start = i; }
					if (ch === 'G') { cell.classList.add('goal'); goal = i; }
				});
				player = start;
				updatePlayer();
				statusEl.textContent = 'Puzzle loaded. Use arrow keys to solve.';
			} catch {
				statusEl.textContent = 'Invalid code.';
			}
		}

		function updatePlayer() {
			cells.forEach(c => c.classList.remove('player'));
			if (player !== null) {
				cells[player].classList.add('player');
			}
		}

		function movePlayer(dx, dy) {
			if (player === null) return;
			const row = Math.floor(player / size);
			const col = player % size;
			const newRow = row + dy;
			const newCol = col + dx;
			if (newRow < 0 || newRow >= size || newCol < 0 || newCol >= size) return;
			const newIndex = newRow * size + newCol;
			if (cells[newIndex].classList.contains('wall')) return;
			player = newIndex;
			updatePlayer();
			if (player === goal) {
				statusEl.textContent = 'Puzzle solved.';
			}
		}

		document.addEventListener('keydown', function (e) {
			if (!game.contains(document.activeElement)) return;
			if (e.key === 'ArrowUp') movePlayer(0,-1);
			if (e.key === 'ArrowDown') movePlayer(0,1);
			if (e.key === 'ArrowLeft') movePlayer(-1,0);
			if (e.key === 'ArrowRight') movePlayer(1,0);
		});

		for (let i = 0; i < size * size; i++) {
			const cell = document.createElement('div');
			cell.className = 'zo-pca-cell';
			cell.addEventListener('click', function () {
				if (mode === 'play') return;
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

		game.querySelector('.zo-pca-mode-wall').onclick = () => mode='wall';
		game.querySelector('.zo-pca-mode-start').onclick = () => mode='start';
		game.querySelector('.zo-pca-mode-goal').onclick = () => mode='goal';
		game.querySelector('.zo-pca-mode-play').onclick = () => { mode='play'; player=start; updatePlayer(); statusEl.textContent='Play mode.'; };

		game.querySelector('.zo-pca-generate').onclick = function () {
			codeInput.value = encodePuzzle();
			statusEl.textContent = 'Code generated.';
		};

		game.querySelector('.zo-pca-load').onclick = function () {
			decodePuzzle(codeInput.value.trim());
		};

		game.querySelector('.zo-pca-send').onclick = function () {
			statusEl.textContent = 'Puzzle sent.';
		};

		game.querySelector('.zo-pca-admin-login').onclick = function () {
			const pass = prompt("Enter admin password:");
			if (pass === ADMIN_PASSWORD) {
				isAdmin = true;
				statusEl.textContent = 'Admin mode enabled.';
			} else {
				statusEl.textContent = 'Wrong password.';
			}
		};

		game.querySelector('.zo-pca-approve').onclick = function () {
			if (!isAdmin) return;
			const code = codeInput.value.trim();
			if (!code) return;
			const list = getApprovedList();
			list.push(code);
			saveApprovedList(list);
			renderApproved();
			statusEl.textContent = 'Approved.';
		};

		game.querySelector('.zo-pca-trash').onclick = function () {
			if (!isAdmin) return;
			statusEl.textContent = 'Rejected.';
		};

		renderApproved();
	});
});
JS;

if (!function_exists('zo_game_puzzle_creator_pro_render')) {
	function zo_game_puzzle_creator_pro_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-puzzle-creator-pro-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));
		ob_start();
		?>
		<div class="zo-game-root zo-game-root--puzzle-creator-admin" id="<?php echo esc_attr($instance_id); ?>" tabindex="0">
			<h2>Puzzle Creator Pro</h2>

			<div class="zo-pca-panel">
				<button class="zo-pca-btn zo-pca-mode-wall">Wall</button>
				<button class="zo-pca-btn zo-pca-mode-start">Start</button>
				<button class="zo-pca-btn zo-pca-mode-goal">Goal</button>
				<button class="zo-pca-btn zo-pca-mode-play">Play</button>
			</div>

			<div class="zo-pca-status"></div>
			<div class="zo-pca-grid"></div>

			<div class="zo-pca-panel">
				<button class="zo-pca-btn zo-pca-generate">Generate Code</button>
				<button class="zo-pca-btn zo-pca-send">Send to Admin</button>
				<input type="text" class="zo-pca-code" placeholder="Puzzle code">
				<button class="zo-pca-btn zo-pca-btn-secondary zo-pca-load">Load Code</button>
			</div>

			<div class="zo-pca-admin">
				<button class="zo-pca-btn zo-pca-admin-login">Put in Admin Sifresi</button>
				<button class="zo-pca-btn zo-pca-approve">Save to System</button>
				<button class="zo-pca-btn zo-pca-btn-secondary zo-pca-trash">Trash</button>
			</div>

			<div class="zo-pca-approved">
				<div class="zo-pca-approved-list"></div>
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
	'description'     => 'Create, send, approve, and solve puzzles.',
	'render_callback' => 'zo_game_puzzle_creator_pro_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);