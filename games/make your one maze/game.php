<?php

if (!defined('ABSPATH')) {
	exit;
}

/*
|--------------------------------------------------------------------------
| AJAX HANDLERS
|--------------------------------------------------------------------------
*/

add_action('wp_ajax_zo_pca_save_shared', 'zo_pca_save_shared');
add_action('wp_ajax_nopriv_zo_pca_save_shared', 'zo_pca_save_shared');

add_action('wp_ajax_zo_pca_get_shared', 'zo_pca_get_shared');
add_action('wp_ajax_nopriv_zo_pca_get_shared', 'zo_pca_get_shared');

add_action('wp_ajax_zo_pca_delete_shared', 'zo_pca_delete_shared');
add_action('wp_ajax_nopriv_zo_pca_delete_shared', 'zo_pca_delete_shared');

function zo_pca_save_shared() {
	check_ajax_referer('zo_pca_nonce', 'nonce');

	$name = sanitize_text_field($_POST['name'] ?? '');
	$code = sanitize_text_field($_POST['code'] ?? '');
	$password = sanitize_text_field($_POST['password'] ?? '');

	if ($password !== 'asker1905123') {
		wp_send_json_error('Wrong admin password');
	}

	if (!$name || !$code) {
		wp_send_json_error('Missing data');
	}

	$list = get_option('zo_pca_shared_puzzles', array());
	$list[] = array(
		'name' => $name,
		'code' => $code
	);

	update_option('zo_pca_shared_puzzles', $list);
	wp_send_json_success($list);
}

function zo_pca_get_shared() {
	$list = get_option('zo_pca_shared_puzzles', array());
	wp_send_json_success($list);
}

function zo_pca_delete_shared() {
	check_ajax_referer('zo_pca_nonce', 'nonce');

	$password = sanitize_text_field($_POST['password'] ?? '');
	$index = intval($_POST['index'] ?? -1);

	if ($password !== 'asker1905123') {
		wp_send_json_error('Wrong admin password');
	}

	$list = get_option('zo_pca_shared_puzzles', array());

	if (isset($list[$index])) {
		array_splice($list, $index, 1);
		update_option('zo_pca_shared_puzzles', $list);
	}

	wp_send_json_success($list);
}

/*
|--------------------------------------------------------------------------
| STYLES
|--------------------------------------------------------------------------
*/

$css = <<<'CSS'
.zo-game-root--puzzle-creator-admin {
	max-width: 800px;
	margin: 0 auto;
	padding: 20px;
	background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
	border-radius: 18px;
	color: #ffffff;
	font-family: inherit;
}

.zo-pca-grid {
	display: grid;
	grid-template-columns: repeat(8, 1fr);
	gap: 4px;
	margin-bottom: 12px;
}

.zo-pca-cell {
	aspect-ratio: 1/1;
	background: #334155;
	border-radius: 8px;
	cursor: pointer;
}

.zo-pca-cell.wall { background: #22c55e; }
.zo-pca-cell.start { background: #3b82f6; }
.zo-pca-cell.goal { background: #ef4444; }
.zo-pca-cell.player { outline: 3px solid #facc15; }

.zo-pca-btn {
	border: none;
	border-radius: 999px;
	padding: 8px 14px;
	font-weight: 700;
	cursor: pointer;
	background: #38bdf8;
	color: #0f172a;
	font-size: 13px;
	margin: 4px;
}

.zo-pca-status {
	min-height: 24px;
	margin-bottom: 10px;
	font-weight: 600;
	color: #facc15;
}

.zo-pca-shared button {
	margin: 4px;
}
CSS;

/*
|--------------------------------------------------------------------------
| SCRIPT
|--------------------------------------------------------------------------
*/

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {

	const games = document.querySelectorAll('.zo-game-root--puzzle-creator-admin');

	games.forEach(function (game) {

		const ajaxUrl = window.location.origin + '/wp-admin/admin-ajax.php';
		const nonce = game.dataset.nonce;

		const grid = game.querySelector('.zo-pca-grid');
		const statusEl = game.querySelector('.zo-pca-status');
		const sharedBox = game.querySelector('.zo-pca-shared');

		const size = 8;
		let mode = 'wall';
		let start = null;
		let goal = null;
		let player = null;
		const cells = [];

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

		function loadPuzzle(code) {
			const data = atob(code);
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
			mode = 'play';
			statusEl.textContent = 'Play mode. Use arrow keys.';
		}

		function updatePlayer() {
			cells.forEach(c => c.classList.remove('player'));
			if (player !== null) cells[player].classList.add('player');
		}

		function move(dx, dy) {
			if (mode !== 'play') return;
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
				mode = 'wall';
			}
		}

		document.addEventListener('keydown', function (e) {
			if (!game.contains(document.activeElement)) return;
			if (e.key === 'ArrowUp') move(0,-1);
			if (e.key === 'ArrowDown') move(0,1);
			if (e.key === 'ArrowLeft') move(-1,0);
			if (e.key === 'ArrowRight') move(1,0);
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

		game.querySelector('.zo-pca-save').onclick = function () {
			const name = prompt('Puzzle name:');
			if (!name) return;
			const password = prompt('Enter admin password:');
			if (!password) return;

			fetch(ajaxUrl, {
				method: 'POST',
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
				body: new URLSearchParams({
					action: 'zo_pca_save_shared',
					name: name,
					code: encodePuzzle(),
					password: password,
					nonce: nonce
				})
			})
			.then(res => res.json())
			.then(data => {
				if (data.success) {
					statusEl.textContent = 'Saved to system.';
					renderShared(data.data);
				} else {
					statusEl.textContent = data.data;
				}
			});
		};

		function renderShared(list) {
			sharedBox.innerHTML = '';
			list.forEach(function (item, index) {
				const wrapper = document.createElement('div');

				const playBtn = document.createElement('button');
				playBtn.className = 'zo-pca-btn';
				playBtn.textContent = item.name;
				playBtn.onclick = function () {
					loadPuzzle(item.code);
				};

				const deleteBtn = document.createElement('button');
				deleteBtn.className = 'zo-pca-btn';
				deleteBtn.textContent = 'Delete';
				deleteBtn.onclick = function () {
					const password = prompt('Enter admin password:');
					if (!password) return;

					fetch(ajaxUrl, {
						method: 'POST',
						headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
						body: new URLSearchParams({
							action: 'zo_pca_delete_shared',
							index: index,
							password: password,
							nonce: nonce
						})
					})
					.then(res => res.json())
					.then(data => {
						if (data.success) {
							renderShared(data.data);
						}
					});
				};

				wrapper.appendChild(playBtn);
				wrapper.appendChild(deleteBtn);
				sharedBox.appendChild(wrapper);
			});
		}

		function loadShared() {
			fetch(ajaxUrl + '?action=zo_pca_get_shared')
				.then(res => res.json())
				.then(data => {
					if (data.success) {
						renderShared(data.data);
					}
				});
		}

		loadShared();
	});
});
JS;

/*
|--------------------------------------------------------------------------
| RENDER
|--------------------------------------------------------------------------
*/

if (!function_exists('zo_game_puzzle_creator_pro_render')) {
	function zo_game_puzzle_creator_pro_render($post_id = 0, $module = array()) {

		$instance_id = 'zo-puzzle-creator-pro-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));
		$nonce = wp_create_nonce('zo_pca_nonce');

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--puzzle-creator-admin"
		     id="<?php echo esc_attr($instance_id); ?>"
		     data-nonce="<?php echo esc_attr($nonce); ?>"
		     tabindex="0">

			<h2>Puzzle Creator Pro</h2>

			<div>
				<button class="zo-pca-btn zo-pca-mode-wall">Wall</button>
				<button class="zo-pca-btn zo-pca-mode-start">Start</button>
				<button class="zo-pca-btn zo-pca-mode-goal">Goal</button>
				<button class="zo-pca-btn zo-pca-save">Save to System</button>
			</div>

			<div class="zo-pca-status"></div>
			<div class="zo-pca-grid"></div>

			<h3>Shared Puzzles</h3>
			<div class="zo-pca-shared"></div>

		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'puzzle-creator-pro',
	'name'            => 'Puzzle Creator Pro',
	'author'          => 'Asker',
	'description'     => 'Create puzzles and share them system-wide with admin password.',
	'render_callback' => 'zo_game_puzzle_creator_pro_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);