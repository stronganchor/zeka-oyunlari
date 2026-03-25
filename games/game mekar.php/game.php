<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root--arslanin-oyunlari-launcher {
	max-width: 960px;
	margin: 0 auto;
	padding: 16px;
	box-sizing: border-box;
	font-family: inherit;
}

.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-card {
	background: #ffffff;
	border: 1px solid #d9dee7;
	border-radius: 18px;
	padding: 18px;
	box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
}

.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-title {
	margin: 0 0 8px;
	font-size: 28px;
	line-height: 1.2;
	text-align: center;
	color: #1d2733;
}

.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-subtitle {
	margin: 0 0 18px;
	font-size: 15px;
	line-height: 1.5;
	text-align: center;
	color: #5c6875;
}

.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-layout {
	display: grid;
	grid-template-columns: 1fr;
	gap: 16px;
}

.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-panel {
	background: #f8fafc;
	border: 1px solid #e4e9f0;
	border-radius: 16px;
	padding: 16px;
}

.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-label {
	display: block;
	margin: 0 0 8px;
	font-weight: 700;
	font-size: 15px;
	color: #1d2733;
}

.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-input {
	width: 100%;
	min-height: 110px;
	padding: 14px;
	border: 1px solid #cfd7e3;
	border-radius: 14px;
	box-sizing: border-box;
	font: inherit;
	font-size: 16px;
	line-height: 1.45;
	resize: vertical;
	background: #ffffff;
	color: #1d2733;
}

.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-input:focus {
	outline: none;
	border-color: #4f46e5;
	box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
}

.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-chip-row {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
	margin-top: 12px;
}

.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-chip {
	border: 1px solid #d4dbe6;
	background: #ffffff;
	border-radius: 999px;
	padding: 8px 12px;
	font: inherit;
	font-size: 14px;
	cursor: pointer;
	color: #334155;
	transition: transform 0.15s ease, border-color 0.15s ease, background 0.15s ease;
}

.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-chip:hover,
.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-chip:focus {
	outline: none;
	transform: translateY(-1px);
	border-color: #94a3b8;
	background: #f8fafc;
}

.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-actions {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	margin-top: 16px;
}

.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-btn {
	border: 0;
	border-radius: 14px;
	padding: 12px 18px;
	font: inherit;
	font-weight: 700;
	font-size: 15px;
	cursor: pointer;
	transition: transform 0.15s ease, opacity 0.15s ease;
}

.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-btn:hover,
.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-btn:focus {
	outline: none;
	transform: translateY(-1px);
}

.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-btn--primary {
	background: #2563eb;
	color: #ffffff;
}

.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-btn--secondary {
	background: #e2e8f0;
	color: #1e293b;
}

.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-status {
	margin-top: 14px;
	min-height: 24px;
	font-size: 15px;
	font-weight: 600;
	color: #334155;
}

.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-status.is-good {
	color: #166534;
}

.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-status.is-bad {
	color: #b91c1c;
}

.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-result {
	display: none;
	margin-top: 14px;
	background: #ffffff;
	border: 1px solid #dbe4ee;
	border-radius: 14px;
	padding: 14px;
}

.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-result.is-visible {
	display: block;
}

.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-result-title {
	margin: 0 0 6px;
	font-size: 22px;
	font-weight: 800;
	color: #0f172a;
}

.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-result-desc {
	margin: 0 0 12px;
	font-size: 15px;
	line-height: 1.5;
	color: #475569;
}

.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-list {
	margin: 0;
	padding-left: 18px;
	color: #475569;
	font-size: 14px;
	line-height: 1.5;
}

.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-frame-wrap {
	display: none;
	margin-top: 16px;
	border: 1px solid #dbe4ee;
	border-radius: 16px;
	overflow: hidden;
	background: #ffffff;
}

.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-frame-wrap.is-visible {
	display: block;
}

.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-frame {
	display: block;
	width: 100%;
	height: 72vh;
	min-height: 520px;
	border: 0;
	background: #ffffff;
}

.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-help {
	margin-top: 10px;
	font-size: 13px;
	line-height: 1.45;
	color: #64748b;
}

@media (max-width: 640px) {
	.zo-game-root--arslanin-oyunlari-launcher {
		padding: 10px;
	}

	.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-card,
	.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-panel {
		padding: 14px;
	}

	.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-title {
		font-size: 24px;
	}

	.zo-game-root--arslanin-oyunlari-launcher .zo-ayo-frame {
		height: 68vh;
		min-height: 420px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--arslanin-oyunlari-launcher');

	games.forEach(function (game) {
		const catalog = [
			{
				name: 'Chess',
				url: '/oyun/chess/',
				description: 'A strategy board game with AI difficulty levels.',
				keywords: ['chess', 'satranç', 'board', 'strategy', 'ai', 'robot', 'pieces', 'king', 'queen']
			},
			{
				name: 'Breakout',
				url: '/oyun/breakout/',
				description: 'Bounce the ball and break blocks across multiple levels.',
				keywords: ['breakout', 'ball', 'blocks', 'brick', 'arcade', 'paddle', 'fast', 'level', 'levels']
			},
			{
				name: 'Word Ladder',
				url: '/oyun/word-ladder/',
				description: 'Change one letter at a time to reach a new word.',
				keywords: ['word', 'words', 'spelling', 'letters', 'vocabulary', 'kelime', 'harf', 'ladder']
			},
			{
				name: 'Category Blitz',
				url: '/oyun/category-blitz/',
				description: 'Think fast and sort ideas into the right categories.',
				keywords: ['category', 'categories', 'quiz', 'thinking', 'brain', 'fast', 'match', 'sort']
			}
		];

		const input = game.querySelector('.zo-ayo-input');
		const findButton = game.querySelector('.zo-ayo-find');
		const clearButton = game.querySelector('.zo-ayo-clear');
		const status = game.querySelector('.zo-ayo-status');
		const result = game.querySelector('.zo-ayo-result');
		const resultTitle = game.querySelector('.zo-ayo-result-title');
		const resultDesc = game.querySelector('.zo-ayo-result-desc');
		const resultList = game.querySelector('.zo-ayo-list');
		const openButton = game.querySelector('.zo-ayo-open');
		const frameWrap = game.querySelector('.zo-ayo-frame-wrap');
		const frame = game.querySelector('.zo-ayo-frame');
		const chips = game.querySelectorAll('.zo-ayo-chip');

		function normalize(text) {
			return String(text || '').toLowerCase().replace(/[^a-z0-9ğüşöçıİ\s-]/gi, ' ').replace(/\s+/g, ' ').trim();
		}

		function resetStatus() {
			status.textContent = '';
			status.classList.remove('is-good');
			status.classList.remove('is-bad');
		}

		function setStatus(message, type) {
			status.textContent = message;
			status.classList.remove('is-good');
			status.classList.remove('is-bad');

			if (type === 'good') {
				status.classList.add('is-good');
			} else if (type === 'bad') {
				status.classList.add('is-bad');
			}
		}

		function hideResult() {
			result.classList.remove('is-visible');
			frameWrap.classList.remove('is-visible');
			frame.removeAttribute('src');
		}

		function scoreGame(prompt, item) {
			const text = normalize(prompt);
			if (!text) {
				return 0;
			}

			let score = 0;
			const words = text.split(' ');

			item.keywords.forEach(function (keyword) {
				const key = normalize(keyword);

				if (!key) {
					return;
				}

				if (text === key) {
					score += 120;
				}

				if (text.indexOf(key) !== -1) {
					score += 30;
				}

				if (key.indexOf(text) !== -1 && text.length >= 3) {
					score += 8;
				}

				words.forEach(function (word) {
					if (word.length < 2) {
						return;
					}
					if (key === word) {
						score += 20;
					} else if (key.indexOf(word) !== -1) {
						score += 6;
					}
				});
			});

			return score;
		}

		function getTopMatches(prompt) {
			return catalog
				.map(function (item) {
					return {
						item: item,
						score: scoreGame(prompt, item)
					};
				})
				.sort(function (a, b) {
					return b.score - a.score;
				});
		}

		function renderSuggestions(matches) {
			resultList.innerHTML = '';

			matches.slice(0, 3).forEach(function (entry) {
				const li = document.createElement('li');
				li.textContent = entry.item.name + ' - ' + entry.item.description;
				resultList.appendChild(li);
			});
		}

		function chooseGame() {
			const prompt = input.value.trim();

			hideResult();
			resetStatus();

			if (!prompt) {
				setStatus('Type what kind of game you want first.', 'bad');
				return;
			}

			const matches = getTopMatches(prompt);
			const best = matches[0];

			if (!best || best.score <= 0) {
				setStatus('No good match yet. Try words like chess, blocks, word, or category.', 'bad');
				return;
			}

			resultTitle.textContent = best.item.name;
			resultDesc.textContent = best.item.description;
			renderSuggestions(matches);
			result.classList.add('is-visible');

			openButton.setAttribute('data-url', best.item.url);
			openButton.setAttribute('data-name', best.item.name);

			setStatus('Best match found. Press "Open Selected Game".', 'good');
		}

		findButton.addEventListener('click', function () {
			chooseGame();
		});

		clearButton.addEventListener('click', function () {
			input.value = '';
			hideResult();
			resetStatus();
			input.focus();
		});

		openButton.addEventListener('click', function () {
			const url = openButton.getAttribute('data-url');
			const name = openButton.getAttribute('data-name') || 'game';

			if (!url) {
				setStatus('Pick a game first.', 'bad');
				return;
			}

			frame.setAttribute('src', url);
			frame.setAttribute('title', name);
			frameWrap.classList.add('is-visible');
			setStatus(name + ' is now open below.', 'good');
		});

		input.addEventListener('keydown', function (event) {
			if ((event.ctrlKey || event.metaKey) && event.key === 'Enter') {
				event.preventDefault();
				chooseGame();
			}
		});

		chips.forEach(function (chip) {
			chip.addEventListener('click', function () {
				const prompt = chip.getAttribute('data-prompt') || '';
				input.value = prompt;
				input.focus();
				chooseGame();
			});
		});
	});
});
JS;

if (!function_exists('zo_game_arslanin_oyunlari_launcher_render')) {
	function zo_game_arslanin_oyunlari_launcher_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-arslanin-oyunlari-launcher-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--arslanin-oyunlari-launcher" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-ayo-card">
				<h2 class="zo-ayo-title">Arslan'ın Oyunları</h2>
				<p class="zo-ayo-subtitle">Type what kind of game you want. This launcher will pick the closest match and open it below.</p>

				<div class="zo-ayo-layout">
					<div class="zo-ayo-panel">
						<label class="zo-ayo-label" for="<?php echo esc_attr($instance_id . '-prompt'); ?>">What game do you want?</label>
						<textarea class="zo-ayo-input" id="<?php echo esc_attr($instance_id . '-prompt'); ?>" placeholder="Examples: chess game with AI, a block breaking game, a word game, a fast category game"></textarea>

						<div class="zo-ayo-chip-row">
							<button type="button" class="zo-ayo-chip" data-prompt="chess game with AI">Chess</button>
							<button type="button" class="zo-ayo-chip" data-prompt="a block breaking arcade game">Breakout</button>
							<button type="button" class="zo-ayo-chip" data-prompt="a word game with letters">Word Game</button>
							<button type="button" class="zo-ayo-chip" data-prompt="a fast category quiz">Category Game</button>
						</div>

						<div class="zo-ayo-actions">
							<button type="button" class="zo-ayo-btn zo-ayo-btn--primary zo-ayo-find">Find Game</button>
							<button type="button" class="zo-ayo-btn zo-ayo-btn--secondary zo-ayo-clear">Clear</button>
						</div>

						<div class="zo-ayo-status" aria-live="polite"></div>

						<div class="zo-ayo-result">
							<h3 class="zo-ayo-result-title"></h3>
							<p class="zo-ayo-result-desc"></p>
							<ul class="zo-ayo-list"></ul>

							<div class="zo-ayo-actions">
								<button type="button" class="zo-ayo-btn zo-ayo-btn--primary zo-ayo-open">Open Selected Game</button>
							</div>
						</div>

						<p class="zo-ayo-help">Press Ctrl + Enter after typing to find a game faster.</p>
					</div>

					<div class="zo-ayo-frame-wrap">
						<iframe class="zo-ayo-frame" loading="lazy" allowfullscreen></iframe>
					</div>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'arslanin-oyunlari-launcher',
	'name'            => 'Arslanin Oyunlari Launcher',
	'author'          => 'Arslan',
	'description'     => 'Lets players type what kind of game they want and opens the closest matching game.',
	'render_callback' => 'zo_game_arslanin_oyunlari_launcher_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);