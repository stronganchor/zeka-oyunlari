<?php

if (!defined('ABSPATH')) {
	exit;
}

/*
|--------------------------------------------------------------------------
| AJAX HANDLERS
|--------------------------------------------------------------------------
*/

add_action('wp_ajax_zo_ll_save_set', 'zo_ll_save_set');
add_action('wp_ajax_nopriv_zo_ll_save_set', 'zo_ll_save_set');

add_action('wp_ajax_zo_ll_get_sets', 'zo_ll_get_sets');
add_action('wp_ajax_nopriv_zo_ll_get_sets', 'zo_ll_get_sets');

add_action('wp_ajax_zo_ll_delete_set', 'zo_ll_delete_set');
add_action('wp_ajax_nopriv_zo_ll_delete_set', 'zo_ll_delete_set');

function zo_ll_save_set() {
	check_ajax_referer('zo_ll_nonce', 'nonce');

	$password = sanitize_text_field($_POST['password'] ?? '');
	if ($password !== 'asker1905123') {
		wp_send_json_error('Wrong admin password');
	}

	$title = sanitize_text_field($_POST['title'] ?? '');
	$data  = wp_kses_post($_POST['data'] ?? '');

	if (!$title || !$data) {
		wp_send_json_error('Missing data');
	}

	$list = get_option('zo_ll_shared_sets', array());
	$list[] = array(
		'title' => $title,
		'data'  => $data,
	);

	update_option('zo_ll_shared_sets', $list);
	wp_send_json_success($list);
}

function zo_ll_get_sets() {
	$list = get_option('zo_ll_shared_sets', array());
	wp_send_json_success($list);
}

function zo_ll_delete_set() {
	check_ajax_referer('zo_ll_nonce', 'nonce');

	$password = sanitize_text_field($_POST['password'] ?? '');
	if ($password !== 'asker1905123') {
		wp_send_json_error('Wrong admin password');
	}

	$index = intval($_POST['index'] ?? -1);
	$list  = get_option('zo_ll_shared_sets', array());

	if (isset($list[$index])) {
		array_splice($list, $index, 1);
		update_option('zo_ll_shared_sets', $list);
	}

	wp_send_json_success($list);
}

/*
|--------------------------------------------------------------------------
| STYLES
|--------------------------------------------------------------------------
*/

$css = <<<'CSS'
.zo-game-root--language-learner {
	max-width: 760px;
	margin: 0 auto;
	padding: 20px;
	background: linear-gradient(180deg,#0f172a 0%,#1e293b 100%);
	border-radius: 18px;
	color: #fff;
	font-family: inherit;
}

.zo-ll-input,
.zo-ll-textarea {
	width: 100%;
	margin-bottom: 8px;
	padding: 8px;
	border-radius: 8px;
	border: none;
	font-size: 14px;
}

.zo-ll-btn {
	border: none;
	border-radius: 999px;
	padding: 8px 14px;
	font-weight: 700;
	cursor: pointer;
	background: #38bdf8;
	color: #0f172a;
	font-size: 13px;
	margin: 4px 4px 8px 0;
}

.zo-ll-status {
	min-height: 24px;
	margin-bottom: 10px;
	font-weight: 600;
	color: #facc15;
}

.zo-ll-card {
	background: rgba(255,255,255,0.08);
	padding: 10px;
	border-radius: 10px;
	margin-bottom: 8px;
}
CSS;

/*
|--------------------------------------------------------------------------
| SCRIPT
|--------------------------------------------------------------------------
*/

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {

	const games = document.querySelectorAll('.zo-game-root--language-learner');

	games.forEach(function (game) {

		const ajaxUrl = window.location.origin + '/wp-admin/admin-ajax.php';
		const nonce   = game.dataset.nonce;

		const titleInput = game.querySelector('.zo-ll-title');
		const dataInput  = game.querySelector('.zo-ll-data');
		const statusEl   = game.querySelector('.zo-ll-status');
		const listBox    = game.querySelector('.zo-ll-list');

		function renderList(list) {
			listBox.innerHTML = '';
			list.forEach(function (item, index) {

				const card = document.createElement('div');
				card.className = 'zo-ll-card';

				const h = document.createElement('strong');
				h.textContent = item.title;

				const p = document.createElement('div');
				p.innerHTML = item.data;

				const delBtn = document.createElement('button');
				delBtn.className = 'zo-ll-btn';
				delBtn.textContent = 'Delete';
				delBtn.onclick = function () {
					const pass = prompt('Admin password:');
					if (!pass) return;

					fetch(ajaxUrl, {
						method: 'POST',
						headers: {'Content-Type':'application/x-www-form-urlencoded'},
						body: new URLSearchParams({
							action:'zo_ll_delete_set',
							index:index,
							password:pass,
							nonce:nonce
						})
					})
					.then(r=>r.json())
					.then(d=>{
						if(d.success) renderList(d.data);
					});
				};

				card.appendChild(h);
				card.appendChild(p);
				card.appendChild(delBtn);
				listBox.appendChild(card);
			});
		}

		function loadSets() {
			fetch(ajaxUrl + '?action=zo_ll_get_sets')
				.then(r=>r.json())
				.then(d=>{
					if(d.success) renderList(d.data);
				});
		}

		game.querySelector('.zo-ll-save').onclick = function () {
			const title = titleInput.value.trim();
			const data  = dataInput.value.trim();
			const pass  = prompt('Admin password:');
			if (!title || !data || !pass) return;

			fetch(ajaxUrl,{
				method:'POST',
				headers:{'Content-Type':'application/x-www-form-urlencoded'},
				body:new URLSearchParams({
					action:'zo_ll_save_set',
					title:title,
					data:data,
					password:pass,
					nonce:nonce
				})
			})
			.then(r=>r.json())
			.then(d=>{
				if(d.success){
					statusEl.textContent='Saved to system.';
					renderList(d.data);
					titleInput.value='';
					dataInput.value='';
				}else{
					statusEl.textContent=d.data;
				}
			});
		};

		loadSets();
	});
});
JS;

/*
|--------------------------------------------------------------------------
| RENDER
|--------------------------------------------------------------------------
*/

if (!function_exists('zo_game_language_learner_render')) {
	function zo_game_language_learner_render($post_id = 0, $module = array()) {

		$instance_id = 'zo-language-learner-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));
		$nonce = wp_create_nonce('zo_ll_nonce');

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--language-learner"
		     id="<?php echo esc_attr($instance_id); ?>"
		     data-nonce="<?php echo esc_attr($nonce); ?>">

			<h2>Language Learner Tools</h2>

			<input type="text" class="zo-ll-input zo-ll-title" placeholder="Set title">
			<textarea class="zo-ll-textarea zo-ll-data" rows="4" placeholder="Enter vocabulary or sentences"></textarea>

			<button class="zo-ll-btn zo-ll-save">Save to System</button>

			<div class="zo-ll-status"></div>

			<h3>Shared Sets</h3>
			<div class="zo-ll-list"></div>

		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'language-learning-platform',
	'name'            => 'Language Learning Platform',
	'author'          => 'Asker',
	'description'     => 'Admin can save language sets system-wide with password protection.',
	'render_callback' => 'zo_game_language_learner_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);