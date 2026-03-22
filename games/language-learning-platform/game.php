<?php

if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('zo_llp_get_words_option')) {
	function zo_llp_get_words_option() {
		$default_words = array(
			array('tr' => 'elma',  'en' => 'apple',  'category' => 'food',   'sentence' => 'Kırmızı bir meyve.'),
			array('tr' => 'kitap', 'en' => 'book',   'category' => 'school', 'sentence' => 'Okumak için kullanılır.'),
			array('tr' => 'su',    'en' => 'water',  'category' => 'food',   'sentence' => 'İçilir.'),
			array('tr' => 'masa',  'en' => 'table',  'category' => 'home',   'sentence' => 'Üstünde bir şey durur.'),
			array('tr' => 'kedi',  'en' => 'cat',    'category' => 'animal', 'sentence' => 'Miyav der.'),
			array('tr' => 'köpek', 'en' => 'dog',    'category' => 'animal', 'sentence' => 'Hav hav der.'),
			array('tr' => 'okul',  'en' => 'school', 'category' => 'school', 'sentence' => 'Ders yapılan yer.'),
			array('tr' => 'kalem', 'en' => 'pen',    'category' => 'school', 'sentence' => 'Yazı yazmaya yarar.'),
			array('tr' => 'güneş', 'en' => 'sun',    'category' => 'nature', 'sentence' => 'Gökyüzünde parlar.'),
			array('tr' => 'ev',    'en' => 'house',  'category' => 'home',   'sentence' => 'İçinde yaşanır.')
		);

		$words = get_option('zo_llp_words', $default_words);

		if (!is_array($words) || empty($words)) {
			$words = $default_words;
			update_option('zo_llp_words', $words, false);
		}

		return $words;
	}
}

if (!function_exists('zo_llp_get_categories_option')) {
	function zo_llp_get_categories_option() {
		$default_categories = array('animal', 'food', 'home', 'school', 'nature');

		$categories = get_option('zo_llp_categories', $default_categories);

		if (!is_array($categories) || empty($categories)) {
			$categories = $default_categories;
			update_option('zo_llp_categories', $categories, false);
		}

		return array_values(array_unique(array_map('strval', $categories)));
	}
}

if (!function_exists('zo_llp_get_pending_option')) {
	function zo_llp_get_pending_option() {
		$pending = get_option('zo_llp_pending_requests', array());

		if (!is_array($pending)) {
			$pending = array();
			update_option('zo_llp_pending_requests', $pending, false);
		}

		return array_values($pending);
	}
}

if (!function_exists('zo_llp_normalize_text')) {
	function zo_llp_normalize_text($text) {
		$text = wp_strip_all_tags((string) $text);
		$text = trim($text);
		return $text;
	}
}

if (!function_exists('zo_llp_build_payload')) {
	function zo_llp_build_payload() {
		return array(
			'words'     => zo_llp_get_words_option(),
			'categories'=> zo_llp_get_categories_option(),
			'pending'   => current_user_can('manage_options') ? zo_llp_get_pending_option() : array(),
			'is_admin'  => current_user_can('manage_options'),
		);
	}
}

if (!function_exists('zo_llp_ajax_get_data')) {
	function zo_llp_ajax_get_data() {
		check_ajax_referer('zo_llp_nonce', 'nonce');

		wp_send_json_success(zo_llp_build_payload());
	}
}
add_action('wp_ajax_zo_llp_get_data', 'zo_llp_ajax_get_data');
add_action('wp_ajax_nopriv_zo_llp_get_data', 'zo_llp_ajax_get_data');

if (!function_exists('zo_llp_ajax_submit_request')) {
	function zo_llp_ajax_submit_request() {
		check_ajax_referer('zo_llp_nonce', 'nonce');

		$request_type = isset($_POST['request_type']) ? sanitize_key(wp_unslash($_POST['request_type'])) : '';

		$pending = zo_llp_get_pending_option();

		if ($request_type === 'word') {
			$tr       = zo_llp_normalize_text(wp_unslash($_POST['tr'] ?? ''));
			$en       = zo_llp_normalize_text(wp_unslash($_POST['en'] ?? ''));
			$category = zo_llp_normalize_text(wp_unslash($_POST['category'] ?? ''));
			$sentence = zo_llp_normalize_text(wp_unslash($_POST['sentence'] ?? ''));

			if ($tr === '' || $en === '' || $category === '') {
				wp_send_json_error(array('message' => 'Türkçe, İngilizce ve kategori gerekli.'));
			}

			$words = zo_llp_get_words_option();
			foreach ($words as $word) {
				if (
					mb_strtolower((string) ($word['tr'] ?? ''), 'UTF-8') === mb_strtolower($tr, 'UTF-8') &&
					mb_strtolower((string) ($word['en'] ?? ''), 'UTF-8') === mb_strtolower($en, 'UTF-8')
				) {
					wp_send_json_error(array('message' => 'Bu kelime zaten kayıtlı.'));
				}
			}

			$pending[] = array(
				'id'          => wp_generate_uuid4(),
				'type'        => 'word',
				'tr'          => $tr,
				'en'          => $en,
				'category'    => $category,
				'sentence'    => $sentence,
				'submitted_at'=> current_time('mysql'),
			);

			update_option('zo_llp_pending_requests', $pending, false);

			wp_send_json_success(array(
				'message' => 'Kelime isteği gönderildi. Yönetici onaylarsa eklenecek.',
			));
		}

		if ($request_type === 'category') {
			$category_name = zo_llp_normalize_text(wp_unslash($_POST['category_name'] ?? ''));

			if ($category_name === '') {
				wp_send_json_error(array('message' => 'Kategori adı gerekli.'));
			}

			$categories = zo_llp_get_categories_option();
			foreach ($categories as $cat) {
				if (mb_strtolower($cat, 'UTF-8') === mb_strtolower($category_name, 'UTF-8')) {
					wp_send_json_error(array('message' => 'Bu kategori zaten var.'));
				}
			}

			$pending[] = array(
				'id'           => wp_generate_uuid4(),
				'type'         => 'category',
				'category_name'=> $category_name,
				'submitted_at' => current_time('mysql'),
			);

			update_option('zo_llp_pending_requests', $pending, false);

			wp_send_json_success(array(
				'message' => 'Kategori isteği gönderildi. Yönetici onaylarsa eklenecek.',
			));
		}

		wp_send_json_error(array('message' => 'Geçersiz istek.'));
	}
}
add_action('wp_ajax_zo_llp_submit_request', 'zo_llp_ajax_submit_request');
add_action('wp_ajax_nopriv_zo_llp_submit_request', 'zo_llp_ajax_submit_request');

if (!function_exists('zo_llp_ajax_review_request')) {
	function zo_llp_ajax_review_request() {
		check_ajax_referer('zo_llp_nonce', 'nonce');

		if (!current_user_can('manage_options')) {
			wp_send_json_error(array('message' => 'Yetki yok.'));
		}

		$request_id = zo_llp_normalize_text(wp_unslash($_POST['request_id'] ?? ''));
		$decision   = sanitize_key(wp_unslash($_POST['decision'] ?? ''));

		if ($request_id === '' || !in_array($decision, array('approve', 'reject'), true)) {
			wp_send_json_error(array('message' => 'Geçersiz işlem.'));
		}

		$pending = zo_llp_get_pending_option();
		$target  = null;
		$rest    = array();

		foreach ($pending as $item) {
			if (($item['id'] ?? '') === $request_id) {
				$target = $item;
			} else {
				$rest[] = $item;
			}
		}

		if (!$target) {
			wp_send_json_error(array('message' => 'İstek bulunamadı.'));
		}

		if ($decision === 'approve') {
			if (($target['type'] ?? '') === 'category') {
				$categories = zo_llp_get_categories_option();
				$new_cat    = zo_llp_normalize_text($target['category_name'] ?? '');

				if ($new_cat !== '') {
					$exists = false;
					foreach ($categories as $cat) {
						if (mb_strtolower($cat, 'UTF-8') === mb_strtolower($new_cat, 'UTF-8')) {
							$exists = true;
							break;
						}
					}
					if (!$exists) {
						$categories[] = $new_cat;
						update_option('zo_llp_categories', array_values(array_unique($categories)), false);
					}
				}
			}

			if (($target['type'] ?? '') === 'word') {
				$words      = zo_llp_get_words_option();
				$categories = zo_llp_get_categories_option();

				$new_word = array(
					'tr'       => zo_llp_normalize_text($target['tr'] ?? ''),
					'en'       => zo_llp_normalize_text($target['en'] ?? ''),
					'category' => zo_llp_normalize_text($target['category'] ?? ''),
					'sentence' => zo_llp_normalize_text($target['sentence'] ?? ''),
				);

				if ($new_word['tr'] !== '' && $new_word['en'] !== '' && $new_word['category'] !== '') {
					$exists = false;
					foreach ($words as $word) {
						if (
							mb_strtolower((string) ($word['tr'] ?? ''), 'UTF-8') === mb_strtolower($new_word['tr'], 'UTF-8') &&
							mb_strtolower((string) ($word['en'] ?? ''), 'UTF-8') === mb_strtolower($new_word['en'], 'UTF-8')
						) {
							$exists = true;
							break;
						}
					}

					if (!$exists) {
						$words[] = $new_word;
						update_option('zo_llp_words', array_values($words), false);
					}

					$cat_exists = false;
					foreach ($categories as $cat) {
						if (mb_strtolower($cat, 'UTF-8') === mb_strtolower($new_word['category'], 'UTF-8')) {
							$cat_exists = true;
							break;
						}
					}
					if (!$cat_exists) {
						$categories[] = $new_word['category'];
						update_option('zo_llp_categories', array_values(array_unique($categories)), false);
					}
				}
			}
		}

		update_option('zo_llp_pending_requests', array_values($rest), false);

		wp_send_json_success(array(
			'message' => $decision === 'approve' ? 'İstek onaylandı.' : 'İstek reddedildi.',
			'data'    => zo_llp_build_payload(),
		));
	}
}
add_action('wp_ajax_zo_llp_review_request', 'zo_llp_ajax_review_request');

$css = <<<'CSS'
.zo-game-root.zo-game-root--language-learning-platform {
	max-width: 980px;
	margin: 0 auto;
	padding: 20px;
	border: 2px solid #d9e2ec;
	border-radius: 18px;
	background: #ffffff;
	box-sizing: border-box;
	font-family: Arial, sans-serif;
}
.zo-game-root--language-learning-platform .zo-llp-title {
	margin: 0 0 10px;
	font-size: 30px;
	line-height: 1.2;
	text-align: center;
	color: #1f2937;
}
.zo-game-root--language-learning-platform .zo-llp-desc {
	margin: 0 0 18px;
	font-size: 15px;
	line-height: 1.5;
	text-align: center;
	color: #4b5563;
}
.zo-game-root--language-learning-platform .zo-llp-top,
.zo-game-root--language-learning-platform .zo-llp-tabs,
.zo-game-root--language-learning-platform .zo-llp-settings,
.zo-game-root--language-learning-platform .zo-llp-actions,
.zo-game-root--language-learning-platform .zo-llp-request-grid,
.zo-game-root--language-learning-platform .zo-llp-review-actions {
	display: grid;
	gap: 10px;
}
.zo-game-root--language-learning-platform .zo-llp-top {
	grid-template-columns: repeat(4, minmax(0, 1fr));
	margin-bottom: 16px;
}
.zo-game-root--language-learning-platform .zo-llp-tabs {
	grid-template-columns: repeat(3, minmax(0, 1fr));
	margin-bottom: 16px;
}
.zo-game-root--language-learning-platform .zo-llp-settings {
	grid-template-columns: repeat(2, minmax(0, 1fr));
	margin-bottom: 14px;
}
.zo-game-root--language-learning-platform .zo-llp-actions {
	grid-template-columns: repeat(2, minmax(0, 1fr));
	margin-top: 14px;
}
.zo-game-root--language-learning-platform .zo-llp-request-grid {
	grid-template-columns: repeat(2, minmax(0, 1fr));
}
.zo-game-root--language-learning-platform .zo-llp-review-actions {
	grid-template-columns: repeat(2, minmax(0, 1fr));
	margin-top: 10px;
}
.zo-game-root--language-learning-platform .zo-llp-stat,
.zo-game-root--language-learning-platform .zo-llp-card,
.zo-game-root--language-learning-platform .zo-llp-panel-box {
	border: 2px solid #d7e0ea;
	border-radius: 14px;
	padding: 14px;
	background: #f8fbff;
	box-sizing: border-box;
}
.zo-game-root--language-learning-platform .zo-llp-stat {
	text-align: center;
	background: #f4f7fb;
}
.zo-game-root--language-learning-platform .zo-llp-stat-label {
	display: block;
	font-size: 13px;
	font-weight: 700;
	color: #51606f;
	margin-bottom: 4px;
}
.zo-game-root--language-learning-platform .zo-llp-stat-value {
	display: block;
	font-size: 24px;
	font-weight: 700;
	color: #111827;
}
.zo-game-root--language-learning-platform .zo-llp-tab,
.zo-game-root--language-learning-platform .zo-llp-button {
	border: 0;
	border-radius: 12px;
	padding: 12px 14px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	box-sizing: border-box;
}
.zo-game-root--language-learning-platform .zo-llp-tab {
	background: #eef4fb;
	color: #1f2937;
	border: 2px solid #cdd8e5;
}
.zo-game-root--language-learning-platform .zo-llp-tab.is-active {
	background: #2997aa;
	border-color: #2997aa;
	color: #fff;
}
.zo-game-root--language-learning-platform .zo-llp-button--primary { background: #2997aa; color: #fff; }
.zo-game-root--language-learning-platform .zo-llp-button--good { background: #10b981; color: #fff; }
.zo-game-root--language-learning-platform .zo-llp-button--danger { background: #dc2626; color: #fff; }
.zo-game-root--language-learning-platform .zo-llp-button--neutral { background: #e5e7eb; color: #111827; }
.zo-game-root--language-learning-platform .zo-llp-main-panel { display: none; }
.zo-game-root--language-learning-platform .zo-llp-main-panel.is-active { display: block; }
.zo-game-root--language-learning-platform .zo-llp-big {
	font-size: 34px;
	font-weight: 700;
	line-height: 1.2;
	color: #111827;
	text-align: center;
	word-break: break-word;
}
.zo-game-root--language-learning-platform .zo-llp-mid {
	margin-top: 8px;
	font-size: 18px;
	font-weight: 700;
	text-align: center;
	color: #2563eb;
}
.zo-game-root--language-learning-platform .zo-llp-mini {
	font-size: 13px;
	font-weight: 700;
	color: #51606f;
}
.zo-game-root--language-learning-platform .zo-llp-status {
	min-height: 24px;
	margin-top: 12px;
	font-size: 15px;
	font-weight: 700;
	text-align: center;
	color: #374151;
}
.zo-game-root--language-learning-platform .zo-llp-status.is-good { color: #15803d; }
.zo-game-root--language-learning-platform .zo-llp-status.is-bad { color: #dc2626; }
.zo-game-root--language-learning-platform .zo-llp-status.is-info { color: #2563eb; }
.zo-game-root--language-learning-platform .zo-llp-list {
	display: grid;
	grid-template-columns: 1fr;
	gap: 8px;
	margin-top: 12px;
}
.zo-game-root--language-learning-platform .zo-llp-list-item,
.zo-game-root--language-learning-platform .zo-llp-review-item {
	padding: 10px 12px;
	border: 2px solid #dbe4ee;
	border-radius: 12px;
	background: #fff;
	color: #1f2937;
}
.zo-game-root--language-learning-platform .zo-llp-review-item {
	background: #fff8eb;
	border-color: #f3d18d;
}
.zo-game-root--language-learning-platform .zo-llp-input,
.zo-game-root--language-learning-platform .zo-llp-select,
.zo-game-root--language-learning-platform .zo-llp-textarea {
	width: 100%;
	padding: 13px 14px;
	border: 2px solid #c8d4e0;
	border-radius: 12px;
	font-size: 16px;
	background: #fff;
	color: #111827;
	box-sizing: border-box;
}
.zo-game-root--language-learning-platform .zo-llp-textarea {
	min-height: 90px;
	resize: vertical;
	font-family: Arial, sans-serif;
}
.zo-game-root--language-learning-platform .zo-llp-review-wrap {
	margin-top: 18px;
}
.zo-game-root--language-learning-platform .zo-llp-hide {
	display: none !important;
}
@media (max-width: 820px) {
	.zo-game-root.zo-game-root--language-learning-platform {
		padding: 16px;
	}
	.zo-game-root--language-learning-platform .zo-llp-title {
		font-size: 25px;
	}
	.zo-game-root--language-learning-platform .zo-llp-top,
	.zo-game-root--language-learning-platform .zo-llp-tabs,
	.zo-game-root--language-learning-platform .zo-llp-settings,
	.zo-game-root--language-learning-platform .zo-llp-actions,
	.zo-game-root--language-learning-platform .zo-llp-request-grid,
	.zo-game-root--language-learning-platform .zo-llp-review-actions {
		grid-template-columns: 1fr;
	}
	.zo-game-root--language-learning-platform .zo-llp-big {
		font-size: 28px;
	}
}
CSS;

$ajax_url = admin_url('admin-ajax.php');
$nonce    = wp_create_nonce('zo_llp_nonce');

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--language-learning-platform');

	games.forEach(function (game) {
		const ajaxUrl = game.getAttribute('data-ajax-url');
		const nonce = game.getAttribute('data-nonce');

		const tabs = Array.prototype.slice.call(game.querySelectorAll('.zo-llp-tab'));
		const panels = Array.prototype.slice.call(game.querySelectorAll('.zo-llp-main-panel'));

		const learnedEl = game.querySelector('.zo-llp-learned');
		const scoreEl = game.querySelector('.zo-llp-score');
		const streakEl = game.querySelector('.zo-llp-streak');
		const totalEl = game.querySelector('.zo-llp-total');

		const flashWordEl = game.querySelector('.zo-llp-flash-word');
		const flashAnswerEl = game.querySelector('.zo-llp-flash-answer');
		const flashMetaEl = game.querySelector('.zo-llp-flash-meta');
		const flashStatusEl = game.querySelector('.zo-llp-status--flash');

		const quizPromptEl = game.querySelector('.zo-llp-quiz-prompt');
		const quizChoicesEl = game.querySelector('.zo-llp-list--quiz');
		const quizStatusEl = game.querySelector('.zo-llp-status--quiz');

		const listWordsEl = game.querySelector('.zo-llp-list--words');
		const listCategoriesEl = game.querySelector('.zo-llp-list--categories');

		const directionEl = game.querySelector('.zo-llp-select--direction');
		const categoryEl = game.querySelector('.zo-llp-select--category');

		const wordTrEl = game.querySelector('.zo-llp-input--word-tr');
		const wordEnEl = game.querySelector('.zo-llp-input--word-en');
		const wordCategoryEl = game.querySelector('.zo-llp-input--word-category');
		const wordSentenceEl = game.querySelector('.zo-llp-textarea--word-sentence');
		const wordRequestStatusEl = game.querySelector('.zo-llp-status--word-request');

		const categoryNameEl = game.querySelector('.zo-llp-input--category-name');
		const categoryRequestStatusEl = game.querySelector('.zo-llp-status--category-request');

		const pendingWrapEl = game.querySelector('.zo-llp-review-wrap');
		const pendingListEl = game.querySelector('.zo-llp-list--pending');
		const pendingStatusEl = game.querySelector('.zo-llp-status--pending');

		let words = [];
		let categories = [];
		let pending = [];
		let isAdmin = false;

		let direction = 'tr-en';
		let categoryFilter = 'all';
		let filteredWords = [];

		let learned = 0;
		let score = 0;
		let streak = 0;
		let flashIndex = 0;
		let flashShown = false;
		let quizCurrent = null;
		let quizAnswered = false;

		function setStatus(el, text, type) {
			el.textContent = text;
			el.className = el.className.replace(/\sis-(good|bad|info)/g, '');
			if (type) {
				el.className += ' is-' + type;
			}
		}

		function normalize(text) {
			return String(text || '').toLocaleLowerCase('tr-TR').trim();
		}

		function request(params) {
			const body = new URLSearchParams(params);
			return fetch(ajaxUrl, {
				method: 'POST',
				headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
				body: body.toString()
			}).then(function (res) {
				return res.json();
			});
		}

		function applyFilters() {
			filteredWords = words.filter(function (word) {
				if (categoryFilter === 'all') {
					return true;
				}
				return normalize(word.category) === categoryFilter;
			});

			if (!filteredWords.length) {
				filteredWords = words.slice();
			}
		}

		function updateHeader() {
			learnedEl.textContent = String(learned);
			scoreEl.textContent = String(score);
			streakEl.textContent = String(streak);
			totalEl.textContent = String(words.length);
		}

		function refreshCategorySelect() {
			const current = categoryFilter;
			categoryEl.innerHTML = '';

			const all = document.createElement('option');
			all.value = 'all';
			all.textContent = 'Tüm Kategoriler';
			categoryEl.appendChild(all);

			categories.forEach(function (cat) {
				const option = document.createElement('option');
				option.value = normalize(cat);
				option.textContent = cat;
				categoryEl.appendChild(option);
			});

			if (current !== 'all' && categoryEl.querySelector('option[value="' + current + '"]')) {
				categoryEl.value = current;
			} else {
				categoryEl.value = 'all';
				categoryFilter = 'all';
			}
		}

		function refreshWordCategorySuggestions() {
			const listId = game.id + '-categories';
			let datalist = game.querySelector('#' + CSS.escape(listId));

			if (!datalist) {
				datalist = document.createElement('datalist');
				datalist.id = listId;
				game.appendChild(datalist);
			}

			datalist.innerHTML = '';

			categories.forEach(function (cat) {
				const option = document.createElement('option');
				option.value = cat;
				datalist.appendChild(option);
			});

			wordCategoryEl.setAttribute('list', listId);
		}

		function getPrompt(word) {
			return direction === 'tr-en' ? word.tr : word.en;
		}

		function getAnswer(word) {
			return direction === 'tr-en' ? word.en : word.tr;
		}

		function renderFlashcard() {
			if (!filteredWords.length) {
				flashWordEl.textContent = '-';
				flashAnswerEl.textContent = '???';
				flashMetaEl.textContent = '-';
				return;
			}

			if (flashIndex >= filteredWords.length) {
				flashIndex = 0;
			}

			const word = filteredWords[flashIndex];
			flashShown = false;
			flashWordEl.textContent = getPrompt(word);
			flashAnswerEl.textContent = '???';
			flashMetaEl.textContent = word.category + ' • ' + (word.sentence || '');
			setStatus(flashStatusEl, 'Kart hazır.', 'info');
		}

		function renderQuiz() {
			if (!filteredWords.length) {
				quizPromptEl.textContent = '-';
				quizChoicesEl.innerHTML = '';
				return;
			}

			const current = filteredWords[Math.floor(Math.random() * filteredWords.length)];
			const correct = getAnswer(current);
			const wrongPool = words.filter(function (item) {
				return getAnswer(item) !== correct;
			}).map(function (item) {
				return getAnswer(item);
			});

			const options = [correct];
			while (wrongPool.length && options.length < 4) {
				const idx = Math.floor(Math.random() * wrongPool.length);
				options.push(wrongPool.splice(idx, 1)[0]);
			}

			options.sort(function () {
				return Math.random() - 0.5;
			});

			quizCurrent = current;
			quizAnswered = false;
			quizPromptEl.textContent = getPrompt(current);
			quizChoicesEl.innerHTML = '';
			setStatus(quizStatusEl, 'Doğru cevabı seç.', 'info');

			options.forEach(function (option) {
				const btn = document.createElement('button');
				btn.type = 'button';
				btn.className = 'zo-llp-button zo-llp-button--neutral';
				btn.textContent = option;
				btn.addEventListener('click', function () {
					if (quizAnswered) {
						return;
					}
					quizAnswered = true;

					if (option === correct) {
						score += 2;
						streak += 1;
						learned += 1;
						setStatus(quizStatusEl, 'Doğru cevap.', 'good');
					} else {
						streak = 0;
						setStatus(quizStatusEl, 'Yanlış. Doğru cevap: ' + correct, 'bad');
					}

					updateHeader();
				});
				quizChoicesEl.appendChild(btn);
			});
		}

		function renderWordsList() {
			listWordsEl.innerHTML = '';
			filteredWords.forEach(function (word) {
				const item = document.createElement('div');
				item.className = 'zo-llp-list-item';
				item.innerHTML = '<strong>' + word.tr + '</strong> → ' + word.en + '<br><span class="zo-llp-mini">' + word.category + ' • ' + (word.sentence || '') + '</span>';
				listWordsEl.appendChild(item);
			});
		}

		function renderCategoriesList() {
			listCategoriesEl.innerHTML = '';
			categories.forEach(function (cat) {
				const item = document.createElement('div');
				item.className = 'zo-llp-list-item';
				item.innerHTML = '<strong>' + cat + '</strong>';
				listCategoriesEl.appendChild(item);
			});
		}

		function renderPending() {
			if (!isAdmin) {
				pendingWrapEl.classList.add('zo-llp-hide');
				return;
			}

			pendingWrapEl.classList.remove('zo-llp-hide');
			pendingListEl.innerHTML = '';

			if (!pending.length) {
				const item = document.createElement('div');
				item.className = 'zo-llp-review-item';
				item.textContent = 'Bekleyen istek yok.';
				pendingListEl.appendChild(item);
				return;
			}

			pending.forEach(function (req) {
				const item = document.createElement('div');
				item.className = 'zo-llp-review-item';

				let html = '';
				if (req.type === 'category') {
					html = '<strong>Kategori isteği</strong><br>' +
						'<span class="zo-llp-mini">Kategori: ' + (req.category_name || '') + '</span><br>' +
						'<span class="zo-llp-mini">Tarih: ' + (req.submitted_at || '') + '</span>';
				} else {
					html = '<strong>Kelime isteği</strong><br>' +
						'<span class="zo-llp-mini">' + (req.tr || '') + ' → ' + (req.en || '') + '</span><br>' +
						'<span class="zo-llp-mini">Kategori: ' + (req.category || '') + '</span><br>' +
						'<span class="zo-llp-mini">Açıklama: ' + (req.sentence || '') + '</span><br>' +
						'<span class="zo-llp-mini">Tarih: ' + (req.submitted_at || '') + '</span>';
				}

				item.innerHTML = html;

				const actions = document.createElement('div');
				actions.className = 'zo-llp-review-actions';

				const approve = document.createElement('button');
				approve.type = 'button';
				approve.className = 'zo-llp-button zo-llp-button--good';
				approve.textContent = 'Evet, ekle';

				const reject = document.createElement('button');
				reject.type = 'button';
				reject.className = 'zo-llp-button zo-llp-button--danger';
				reject.textContent = 'Hayır, ekleme';

				approve.addEventListener('click', function () {
					reviewRequest(req.id, 'approve');
				});

				reject.addEventListener('click', function () {
					reviewRequest(req.id, 'reject');
				});

				actions.appendChild(approve);
				actions.appendChild(reject);
				item.appendChild(actions);
				pendingListEl.appendChild(item);
			});
		}

		function renderAll() {
			applyFilters();
			refreshCategorySelect();
			refreshWordCategorySuggestions();
			updateHeader();
			renderFlashcard();
			renderQuiz();
			renderWordsList();
			renderCategoriesList();
			renderPending();
		}

		function hydrate(payload) {
			words = Array.isArray(payload.words) ? payload.words : [];
			categories = Array.isArray(payload.categories) ? payload.categories : [];
			pending = Array.isArray(payload.pending) ? payload.pending : [];
			isAdmin = !!payload.is_admin;
			renderAll();
		}

		function fetchData() {
			return request({
				action: 'zo_llp_get_data',
				nonce: nonce
			}).then(function (res) {
				if (!res.success) {
					throw new Error('Load failed');
				}
				hydrate(res.data);
			});
		}

		function submitWordRequest() {
			request({
				action: 'zo_llp_submit_request',
				nonce: nonce,
				request_type: 'word',
				tr: wordTrEl.value,
				en: wordEnEl.value,
				category: wordCategoryEl.value,
				sentence: wordSentenceEl.value
			}).then(function (res) {
				if (res.success) {
					wordTrEl.value = '';
					wordEnEl.value = '';
					wordCategoryEl.value = '';
					wordSentenceEl.value = '';
					setStatus(wordRequestStatusEl, res.data.message, 'good');
					return fetchData();
				}
				setStatus(wordRequestStatusEl, res.data && res.data.message ? res.data.message : 'İstek gönderilemedi.', 'bad');
			}).catch(function () {
				setStatus(wordRequestStatusEl, 'İstek gönderilemedi.', 'bad');
			});
		}

		function submitCategoryRequest() {
			request({
				action: 'zo_llp_submit_request',
				nonce: nonce,
				request_type: 'category',
				category_name: categoryNameEl.value
			}).then(function (res) {
				if (res.success) {
					categoryNameEl.value = '';
					setStatus(categoryRequestStatusEl, res.data.message, 'good');
					return fetchData();
				}
				setStatus(categoryRequestStatusEl, res.data && res.data.message ? res.data.message : 'İstek gönderilemedi.', 'bad');
			}).catch(function () {
				setStatus(categoryRequestStatusEl, 'İstek gönderilemedi.', 'bad');
			});
		}

		function reviewRequest(requestId, decision) {
			request({
				action: 'zo_llp_review_request',
				nonce: nonce,
				request_id: requestId,
				decision: decision
			}).then(function (res) {
				if (!res.success) {
					setStatus(pendingStatusEl, res.data && res.data.message ? res.data.message : 'İşlem başarısız.', 'bad');
					return;
				}
				setStatus(pendingStatusEl, res.data.message, 'good');
				hydrate(res.data.data);
			}).catch(function () {
				setStatus(pendingStatusEl, 'İşlem başarısız.', 'bad');
			});
		}

		tabs.forEach(function (tab) {
			tab.addEventListener('click', function () {
				const mode = tab.getAttribute('data-mode');
				tabs.forEach(function (btn) {
					btn.classList.toggle('is-active', btn === tab);
				});
				panels.forEach(function (panel) {
					panel.classList.toggle('is-active', panel.getAttribute('data-mode') === mode);
				});
			});
		});

		game.querySelector('.zo-llp-button--flash-show').addEventListener('click', function () {
			if (!filteredWords.length) {
				return;
			}
			if (flashShown) {
				renderFlashcard();
				return;
			}
			const word = filteredWords[flashIndex];
			flashShown = true;
			flashAnswerEl.textContent = getAnswer(word);
			score += 1;
			learned += 1;
			streak += 1;
			updateHeader();
			setStatus(flashStatusEl, 'Çeviri gösterildi.', 'good');
		});

		game.querySelector('.zo-llp-button--flash-next').addEventListener('click', function () {
			if (!filteredWords.length) {
				return;
			}
			flashIndex += 1;
			if (flashIndex >= filteredWords.length) {
				flashIndex = 0;
			}
			renderFlashcard();
		});

		game.querySelector('.zo-llp-button--quiz-next').addEventListener('click', function () {
			renderQuiz();
		});

		game.querySelector('.zo-llp-button--apply').addEventListener('click', function () {
			direction = directionEl.value;
			categoryFilter = categoryEl.value;
			renderAll();
		});

		game.querySelector('.zo-llp-button--word-request').addEventListener('click', submitWordRequest);
		game.querySelector('.zo-llp-button--category-request').addEventListener('click', submitCategoryRequest);

		fetchData().catch(function () {
			setStatus(wordRequestStatusEl, 'Veriler yüklenemedi.', 'bad');
		});
	});
});
JS;

if (!function_exists('zo_game_language_learning_platform_render')) {
	function zo_game_language_learning_platform_render($post_id = 0, $module = array()) {
		global $ajax_url, $nonce, $css, $js;

		$instance_id = 'zo-language-learning-platform-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div
			class="zo-game-root zo-game-root--language-learning-platform"
			id="<?php echo esc_attr($instance_id); ?>"
			data-ajax-url="<?php echo esc_url($ajax_url); ?>"
			data-nonce="<?php echo esc_attr($nonce); ?>"
		>
			<h2 class="zo-llp-title">Language Learning Platform</h2>
			<p class="zo-llp-desc">Yeni kelime ve kategori istekleri WordPress içinde bekler. Yönetici isterse evet deyip ekler, isterse hayır deyip reddeder.</p>

			<div class="zo-llp-top">
				<div class="zo-llp-stat">
					<span class="zo-llp-stat-label">Öğrenilen</span>
					<span class="zo-llp-stat-value zo-llp-learned">0</span>
				</div>
				<div class="zo-llp-stat">
					<span class="zo-llp-stat-label">Puan</span>
					<span class="zo-llp-stat-value zo-llp-score">0</span>
				</div>
				<div class="zo-llp-stat">
					<span class="zo-llp-stat-label">Seri</span>
					<span class="zo-llp-stat-value zo-llp-streak">0</span>
				</div>
				<div class="zo-llp-stat">
					<span class="zo-llp-stat-label">Toplam Kelime</span>
					<span class="zo-llp-stat-value zo-llp-total">0</span>
				</div>
			</div>

			<div class="zo-llp-settings">
				<select class="zo-llp-select zo-llp-select--direction">
					<option value="tr-en">Türkçe → English</option>
					<option value="en-tr">English → Türkçe</option>
				</select>

				<select class="zo-llp-select zo-llp-select--category">
					<option value="all">Tüm Kategoriler</option>
				</select>
			</div>

			<div class="zo-llp-actions">
				<button type="button" class="zo-llp-button zo-llp-button--primary zo-llp-button--apply">Ayarları Uygula</button>
				<button type="button" class="zo-llp-button zo-llp-button--neutral zo-llp-button--quiz-next">Yeni Quiz Sorusu</button>
			</div>

			<div class="zo-llp-tabs">
				<button type="button" class="zo-llp-tab is-active" data-mode="flashcards">Flashcards</button>
				<button type="button" class="zo-llp-tab" data-mode="quiz">Quiz</button>
				<button type="button" class="zo-llp-tab" data-mode="requests">İstekler</button>
			</div>

			<div class="zo-llp-main-panel is-active" data-mode="flashcards">
				<div class="zo-llp-card">
					<div class="zo-llp-big zo-llp-flash-word">-</div>
					<div class="zo-llp-mid zo-llp-flash-answer">???</div>
					<div class="zo-llp-mini zo-llp-flash-meta">-</div>

					<div class="zo-llp-actions">
						<button type="button" class="zo-llp-button zo-llp-button--good zo-llp-button--flash-show">Çeviriyi Göster</button>
						<button type="button" class="zo-llp-button zo-llp-button--neutral zo-llp-button--flash-next">Sonraki</button>
					</div>

					<div class="zo-llp-status zo-llp-status--flash" aria-live="polite"></div>
				</div>

				<div class="zo-llp-panel-box">
					<strong>Kelimeler</strong>
					<div class="zo-llp-list zo-llp-list--words"></div>
				</div>

				<div class="zo-llp-panel-box">
					<strong>Kategoriler</strong>
					<div class="zo-llp-list zo-llp-list--categories"></div>
				</div>
			</div>

			<div class="zo-llp-main-panel" data-mode="quiz">
				<div class="zo-llp-card">
					<div class="zo-llp-big zo-llp-quiz-prompt">-</div>
					<div class="zo-llp-list zo-llp-list--quiz"></div>
					<div class="zo-llp-status zo-llp-status--quiz" aria-live="polite"></div>
				</div>
			</div>

			<div class="zo-llp-main-panel" data-mode="requests">
				<div class="zo-llp-panel-box">
					<strong>Yeni kategori isteği</strong>
					<div class="zo-llp-request-grid" style="margin-top:12px;">
						<input type="text" class="zo-llp-input zo-llp-input--category-name" placeholder="Kategori adı" />
						<button type="button" class="zo-llp-button zo-llp-button--primary zo-llp-button--category-request">Kategori isteği gönder</button>
					</div>
					<div class="zo-llp-status zo-llp-status--category-request" aria-live="polite"></div>
				</div>

				<div class="zo-llp-panel-box">
					<strong>Yeni kelime isteği</strong>
					<div class="zo-llp-request-grid" style="margin-top:12px;">
						<input type="text" class="zo-llp-input zo-llp-input--word-tr" placeholder="Türkçe kelime" />
						<input type="text" class="zo-llp-input zo-llp-input--word-en" placeholder="English word" />
						<input type="text" class="zo-llp-input zo-llp-input--word-category" placeholder="Kategori" />
						<textarea class="zo-llp-textarea zo-llp-textarea--word-sentence" placeholder="Açıklama veya örnek cümle"></textarea>
					</div>
					<div class="zo-llp-actions">
						<button type="button" class="zo-llp-button zo-llp-button--primary zo-llp-button--word-request">Kelime isteği gönder</button>
					</div>
					<div class="zo-llp-status zo-llp-status--word-request" aria-live="polite"></div>
				</div>

				<div class="zo-llp-review-wrap zo-llp-panel-box zo-llp-hide">
					<strong>Yönetici onay paneli</strong>
					<div class="zo-llp-list zo-llp-list--pending"></div>
					<div class="zo-llp-status zo-llp-status--pending" aria-live="polite"></div>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'language-learning-platform',
	'name'            => 'Language Learning Platform',
	'author'          => 'Asker',
	'description'     => 'WordPress içinde kelime ve kategori isteklerini yöneticinin evet/hayır onayıyla yöneten dil öğrenme platformu.',
	'render_callback' => 'zo_game_language_learning_platform_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);