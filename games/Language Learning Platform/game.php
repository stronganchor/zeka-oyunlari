<?php

if (!defined('ABSPATH')) {
	exit;
}

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

.zo-game-root--language-learning-platform .zo-llp-top {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 10px;
	margin-bottom: 16px;
}

.zo-game-root--language-learning-platform .zo-llp-stat {
	border: 2px solid #d7e0ea;
	border-radius: 14px;
	padding: 12px;
	background: #f4f7fb;
	text-align: center;
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
	line-height: 1.1;
	color: #111827;
}

.zo-game-root--language-learning-platform .zo-llp-tabs {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 10px;
	margin-bottom: 16px;
}

.zo-game-root--language-learning-platform .zo-llp-tab {
	border: 2px solid #cdd8e5;
	border-radius: 12px;
	padding: 12px 10px;
	background: #eef4fb;
	color: #1f2937;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	box-sizing: border-box;
}

.zo-game-root--language-learning-platform .zo-llp-tab.is-active {
	background: #2997aa;
	border-color: #2997aa;
	color: #ffffff;
}

.zo-game-root--language-learning-platform .zo-llp-main {
	border: 2px solid #dbe4ee;
	border-radius: 16px;
	padding: 16px;
	background: #fbfdff;
	box-sizing: border-box;
}

.zo-game-root--language-learning-platform .zo-llp-panel {
	display: none;
}

.zo-game-root--language-learning-platform .zo-llp-panel.is-active {
	display: block;
}

.zo-game-root--language-learning-platform .zo-llp-card {
	border: 2px dashed #c8d4e0;
	border-radius: 16px;
	padding: 18px;
	background: #f8fbff;
	text-align: center;
	margin-bottom: 14px;
}

.zo-game-root--language-learning-platform .zo-llp-card-label {
	display: block;
	font-size: 14px;
	font-weight: 700;
	color: #51606f;
	margin-bottom: 8px;
}

.zo-game-root--language-learning-platform .zo-llp-big {
	font-size: 34px;
	font-weight: 700;
	line-height: 1.2;
	color: #111827;
	word-break: break-word;
}

.zo-game-root--language-learning-platform .zo-llp-mid {
	margin-top: 8px;
	font-size: 18px;
	font-weight: 700;
	color: #2563eb;
	word-break: break-word;
}

.zo-game-root--language-learning-platform .zo-llp-input,
.zo-game-root--language-learning-platform .zo-llp-select {
	width: 100%;
	padding: 13px 14px;
	border: 2px solid #c8d4e0;
	border-radius: 12px;
	font-size: 17px;
	background: #ffffff;
	color: #111827;
	box-sizing: border-box;
}

.zo-game-root--language-learning-platform .zo-llp-input-row,
.zo-game-root--language-learning-platform .zo-llp-choice-grid,
.zo-game-root--language-learning-platform .zo-llp-match-grid,
.zo-game-root--language-learning-platform .zo-llp-settings-grid {
	display: grid;
	gap: 10px;
}

.zo-game-root--language-learning-platform .zo-llp-input-row {
	grid-template-columns: minmax(0, 1fr) auto auto;
	margin-bottom: 14px;
}

.zo-game-root--language-learning-platform .zo-llp-choice-grid {
	grid-template-columns: repeat(2, minmax(0, 1fr));
	margin-bottom: 14px;
}

.zo-game-root--language-learning-platform .zo-llp-match-grid {
	grid-template-columns: 1fr 1fr;
	margin-bottom: 14px;
}

.zo-game-root--language-learning-platform .zo-llp-settings-grid {
	grid-template-columns: repeat(2, minmax(0, 1fr));
	margin-bottom: 14px;
}

.zo-game-root--language-learning-platform .zo-llp-button {
	border: 0;
	border-radius: 12px;
	padding: 12px 14px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	box-sizing: border-box;
}

.zo-game-root--language-learning-platform .zo-llp-button--primary {
	background: #2997aa;
	color: #ffffff;
}

.zo-game-root--language-learning-platform .zo-llp-button--good {
	background: #10b981;
	color: #ffffff;
}

.zo-game-root--language-learning-platform .zo-llp-button--hint {
	background: #8b5cf6;
	color: #ffffff;
}

.zo-game-root--language-learning-platform .zo-llp-button--neutral {
	background: #e5e7eb;
	color: #111827;
}

.zo-game-root--language-learning-platform .zo-llp-button--choice,
.zo-game-root--language-learning-platform .zo-llp-button--match {
	background: #eef4fb;
	color: #1f2937;
	border: 2px solid #cdd8e5;
}

.zo-game-root--language-learning-platform .zo-llp-button--choice.is-selected,
.zo-game-root--language-learning-platform .zo-llp-button--match.is-selected {
	background: #dbeafe;
	border-color: #3b82f6;
	color: #1d4ed8;
}

.zo-game-root--language-learning-platform .zo-llp-button--choice.is-correct,
.zo-game-root--language-learning-platform .zo-llp-button--match.is-correct {
	background: #dcfce7;
	border-color: #22c55e;
	color: #166534;
}

.zo-game-root--language-learning-platform .zo-llp-button--choice.is-wrong,
.zo-game-root--language-learning-platform .zo-llp-button--match.is-wrong {
	background: #fee2e2;
	border-color: #ef4444;
	color: #991b1b;
}

.zo-game-root--language-learning-platform .zo-llp-status {
	min-height: 24px;
	margin-bottom: 14px;
	text-align: center;
	font-size: 15px;
	font-weight: 700;
	color: #374151;
}

.zo-game-root--language-learning-platform .zo-llp-status.is-good {
	color: #15803d;
}

.zo-game-root--language-learning-platform .zo-llp-status.is-bad {
	color: #dc2626;
}

.zo-game-root--language-learning-platform .zo-llp-status.is-info {
	color: #2563eb;
}

.zo-game-root--language-learning-platform .zo-llp-status.is-warn {
	color: #d97706;
}

.zo-game-root--language-learning-platform .zo-llp-list {
	display: grid;
	grid-template-columns: 1fr;
	gap: 8px;
}

.zo-game-root--language-learning-platform .zo-llp-list-item {
	display: flex;
	align-items: center;
	justify-content: space-between;
	gap: 10px;
	padding: 10px 12px;
	border: 2px solid #dbe4ee;
	border-radius: 12px;
	background: #ffffff;
	font-size: 15px;
	color: #1f2937;
}

.zo-game-root--language-learning-platform .zo-llp-mini {
	font-size: 13px;
	font-weight: 700;
	color: #51606f;
}

.zo-game-root--language-learning-platform .zo-llp-footer {
	margin-top: 14px;
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 10px;
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
	.zo-game-root--language-learning-platform .zo-llp-choice-grid,
	.zo-game-root--language-learning-platform .zo-llp-match-grid,
	.zo-game-root--language-learning-platform .zo-llp-settings-grid,
	.zo-game-root--language-learning-platform .zo-llp-footer {
		grid-template-columns: 1fr;
	}

	.zo-game-root--language-learning-platform .zo-llp-input-row {
		grid-template-columns: 1fr;
	}

	.zo-game-root--language-learning-platform .zo-llp-big {
		font-size: 28px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--language-learning-platform');

	games.forEach(function (game) {
		const words = [
			{ tr: 'elma', en: 'apple', category: 'food', sentence: 'Kırmızı bir meyve.' },
			{ tr: 'kitap', en: 'book', category: 'school', sentence: 'Okumak için kullanılır.' },
			{ tr: 'su', en: 'water', category: 'food', sentence: 'İçilir.' },
			{ tr: 'masa', en: 'table', category: 'home', sentence: 'Üstünde bir şey durur.' },
			{ tr: 'kedi', en: 'cat', category: 'animal', sentence: 'Miyav der.' },
			{ tr: 'köpek', en: 'dog', category: 'animal', sentence: 'Hav hav der.' },
			{ tr: 'okul', en: 'school', category: 'school', sentence: 'Ders yapılan yer.' },
			{ tr: 'kalem', en: 'pen', category: 'school', sentence: 'Yazı yazmaya yarar.' },
			{ tr: 'güneş', en: 'sun', category: 'nature', sentence: 'Gökyüzünde parlar.' },
			{ tr: 'ay', en: 'moon', category: 'nature', sentence: 'Gece görünür.' },
			{ tr: 'çiçek', en: 'flower', category: 'nature', sentence: 'Bahçede büyür.' },
			{ tr: 'ev', en: 'house', category: 'home', sentence: 'İçinde yaşanır.' },
			{ tr: 'kapı', en: 'door', category: 'home', sentence: 'Açılır ve kapanır.' },
			{ tr: 'ekmek', en: 'bread', category: 'food', sentence: 'Fırından alınır.' },
			{ tr: 'süt', en: 'milk', category: 'food', sentence: 'Beyaz bir içecektir.' },
			{ tr: 'kuş', en: 'bird', category: 'animal', sentence: 'Kanatları vardır.' }
		];

		const tabs = Array.prototype.slice.call(game.querySelectorAll('.zo-llp-tab'));
		const panels = Array.prototype.slice.call(game.querySelectorAll('.zo-llp-panel'));

		const learnedEl = game.querySelector('.zo-llp-learned');
		const scoreEl = game.querySelector('.zo-llp-score');
		const streakEl = game.querySelector('.zo-llp-streak');
		const modeEl = game.querySelector('.zo-llp-mode');

		const flashWordEl = game.querySelector('.zo-llp-flash-word');
		const flashTranslationEl = game.querySelector('.zo-llp-flash-translation');
		const flashCategoryEl = game.querySelector('.zo-llp-flash-category');
		const flashNextButton = game.querySelector('.zo-llp-button--flash-next');
		const flashFlipButton = game.querySelector('.zo-llp-button--flash-flip');

		const quizPromptEl = game.querySelector('.zo-llp-quiz-prompt');
		const quizChoicesEl = game.querySelector('.zo-llp-choice-grid');
		const quizStatusEl = game.querySelector('.zo-llp-status--quiz');
		const quizNextButton = game.querySelector('.zo-llp-button--quiz-next');

		const typePromptEl = game.querySelector('.zo-llp-type-prompt');
		const typeInputEl = game.querySelector('.zo-llp-input--type');
		const typeStatusEl = game.querySelector('.zo-llp-status--type');
		const typeCheckButton = game.querySelector('.zo-llp-button--type-check');
		const typeHintButton = game.querySelector('.zo-llp-button--type-hint');
		const typeNextButton = game.querySelector('.zo-llp-button--type-next');

		const matchLeftEl = game.querySelector('.zo-llp-match-left');
		const matchRightEl = game.querySelector('.zo-llp-match-right');
		const matchStatusEl = game.querySelector('.zo-llp-status--match');
		const matchNextButton = game.querySelector('.zo-llp-button--match-next');

		const settingsDirectionEl = game.querySelector('.zo-llp-select--direction');
		const settingsCategoryEl = game.querySelector('.zo-llp-select--category');
		const wordListEl = game.querySelector('.zo-llp-list');
		const applySettingsButton = game.querySelector('.zo-llp-button--apply');
		const restartAllButton = game.querySelector('.zo-llp-button--restart-all');

		let direction = 'tr-en';
		let category = 'all';
		let learnedWords = 0;
		let score = 0;
		let streak = 0;
		let activeMode = 'flashcards';

		let filteredWords = words.slice();
		let flashIndex = 0;
		let flashFlipped = false;

		let currentQuizWord = null;
		let currentTypeWord = null;
		let currentMatchSet = [];
		let matchSelectedLeft = null;
		let matchSelectedRight = null;
		let matchPairsSolved = 0;

		function shuffle(array) {
			const copy = array.slice();
			for (let i = copy.length - 1; i > 0; i--) {
				const j = Math.floor(Math.random() * (i + 1));
				const temp = copy[i];
				copy[i] = copy[j];
				copy[j] = temp;
			}
			return copy;
		}

		function sample(array, count) {
			return shuffle(array).slice(0, count);
		}

		function normalizeText(text) {
			return text.toLocaleLowerCase('tr-TR').trim();
		}

		function getPrompt(word) {
			return direction === 'tr-en' ? word.tr : word.en;
		}

		function getAnswer(word) {
			return direction === 'tr-en' ? word.en : word.tr;
		}

		function setStatus(element, text, type) {
			element.textContent = text;
			element.className = element.className.split(' ').filter(function (item) {
				return item.indexOf('is-') !== 0;
			}).join(' ');
			if (type) {
				element.className += ' ' + type;
			}
		}

		function updateHeader() {
			learnedEl.textContent = String(learnedWords);
			scoreEl.textContent = String(score);
			streakEl.textContent = String(streak);
			modeEl.textContent = activeMode;
		}

		function applyFilters() {
			filteredWords = words.filter(function (word) {
				if (category === 'all') {
					return true;
				}
				return word.category === category;
			});

			if (!filteredWords.length) {
				filteredWords = words.slice();
			}
		}

		function renderWordList() {
			wordListEl.innerHTML = '';
			filteredWords.forEach(function (word) {
				const item = document.createElement('div');
				item.className = 'zo-llp-list-item';
				item.innerHTML = '<span><strong>' + word.tr + '</strong> → ' + word.en + '</span><span class="zo-llp-mini">' + word.category + '</span>';
				wordListEl.appendChild(item);
			});
		}

		function setActiveMode(mode) {
			activeMode = mode;
			tabs.forEach(function (tab) {
				tab.classList.toggle('is-active', tab.getAttribute('data-mode') === mode);
			});
			panels.forEach(function (panel) {
				panel.classList.toggle('is-active', panel.getAttribute('data-mode') === mode);
			});
			updateHeader();
		}

		function loadFlashcard() {
			if (!filteredWords.length) {
				return;
			}
			if (flashIndex >= filteredWords.length) {
				flashIndex = 0;
			}
			const word = filteredWords[flashIndex];
			flashFlipped = false;
			flashWordEl.textContent = getPrompt(word);
			flashTranslationEl.textContent = '???';
			flashCategoryEl.textContent = word.category;
		}

		function flipFlashcard() {
			const word = filteredWords[flashIndex];
			flashFlipped = !flashFlipped;
			flashTranslationEl.textContent = flashFlipped ? getAnswer(word) : '???';
		}

		function nextFlashcard() {
			flashIndex += 1;
			if (flashIndex >= filteredWords.length) {
				flashIndex = 0;
			}
			learnedWords += 1;
			updateHeader();
			loadFlashcard();
		}

		function loadQuiz() {
			currentQuizWord = sample(filteredWords, 1)[0];
			const correct = getAnswer(currentQuizWord);
			const wrongPool = filteredWords.filter(function (word) {
				return getAnswer(word) !== correct;
			});
			const options = shuffle([correct].concat(sample(wrongPool.map(function (word) {
				return getAnswer(word);
			}), 3)));

			quizPromptEl.textContent = getPrompt(currentQuizWord);
			quizChoicesEl.innerHTML = '';
			setStatus(quizStatusEl, 'Doğru cevabı seç.', 'is-info');

			options.forEach(function (option) {
				const button = document.createElement('button');
				button.type = 'button';
				button.className = 'zo-llp-button zo-llp-button--choice';
				button.textContent = option;

				button.addEventListener('click', function () {
					if (button.classList.contains('is-correct') || button.classList.contains('is-wrong')) {
						return;
					}

					const allButtons = quizChoicesEl.querySelectorAll('.zo-llp-button--choice');
					allButtons.forEach(function (btn) {
						btn.disabled = true;
						if (btn.textContent === correct) {
							btn.classList.add('is-correct');
						}
					});

					if (option === correct) {
						button.classList.add('is-correct');
						score += 2;
						streak += 1;
						learnedWords += 1;
						setStatus(quizStatusEl, 'Doğru cevap.', 'is-good');
					} else {
						button.classList.add('is-wrong');
						streak = 0;
						setStatus(quizStatusEl, 'Yanlış cevap.', 'is-bad');
					}

					updateHeader();
				});

				quizChoicesEl.appendChild(button);
			});
		}

		function loadTyping() {
			currentTypeWord = sample(filteredWords, 1)[0];
			typePromptEl.textContent = getPrompt(currentTypeWord);
			typeInputEl.value = '';
			typeInputEl.disabled = false;
			typeCheckButton.disabled = false;
			typeHintButton.disabled = false;
			typeNextButton.disabled = true;
			setStatus(typeStatusEl, 'Çeviriyi yaz.', 'is-info');
		}

		function checkTyping() {
			const guess = normalizeText(typeInputEl.value);
			const answer = normalizeText(getAnswer(currentTypeWord));

			if (!guess) {
				setStatus(typeStatusEl, 'Bir cevap yaz.', 'is-warn');
				return;
			}

			if (guess === answer) {
				score += 3;
				streak += 1;
				learnedWords += 1;
				typeInputEl.disabled = true;
				typeCheckButton.disabled = true;
				typeHintButton.disabled = true;
				typeNextButton.disabled = false;
				setStatus(typeStatusEl, 'Doğru yazdın: ' + getAnswer(currentTypeWord), 'is-good');
			} else {
				streak = 0;
				setStatus(typeStatusEl, 'Yanlış. Tekrar dene.', 'is-bad');
			}

			updateHeader();
		}

		function hintTyping() {
			const answer = getAnswer(currentTypeWord);
			if (!answer) {
				return;
			}
			typeInputEl.value = answer.charAt(0);
			setStatus(typeStatusEl, 'İpucu verildi. Bu tur daha az değerli.', 'is-warn');
		}

		function loadMatch() {
			currentMatchSet = sample(filteredWords, 4);
			matchSelectedLeft = null;
			matchSelectedRight = null;
			matchPairsSolved = 0;
			matchLeftEl.innerHTML = '';
			matchRightEl.innerHTML = '';
			setStatus(matchStatusEl, 'Eşleşen kelimeleri bul.', 'is-info');

			const leftWords = currentMatchSet.slice();
			const rightWords = shuffle(currentMatchSet.slice());

			leftWords.forEach(function (word, index) {
				const button = document.createElement('button');
				button.type = 'button';
				button.className = 'zo-llp-button zo-llp-button--match';
				button.textContent = direction === 'tr-en' ? word.tr : word.en;
				button.setAttribute('data-index', String(index));
				button.addEventListener('click', function () {
					if (button.disabled) {
						return;
					}
					Array.prototype.forEach.call(matchLeftEl.querySelectorAll('.zo-llp-button--match'), function (btn) {
						btn.classList.remove('is-selected');
					});
					button.classList.add('is-selected');
					matchSelectedLeft = word;
					tryMatch();
				});
				matchLeftEl.appendChild(button);
			});

			rightWords.forEach(function (word) {
				const button = document.createElement('button');
				button.type = 'button';
				button.className = 'zo-llp-button zo-llp-button--match';
				button.textContent = direction === 'tr-en' ? word.en : word.tr;
				button.addEventListener('click', function () {
					if (button.disabled) {
						return;
					}
					Array.prototype.forEach.call(matchRightEl.querySelectorAll('.zo-llp-button--match'), function (btn) {
						btn.classList.remove('is-selected');
					});
					button.classList.add('is-selected');
					matchSelectedRight = word;
					tryMatch();
				});
				matchRightEl.appendChild(button);
			});
		}

		function tryMatch() {
			if (!matchSelectedLeft || !matchSelectedRight) {
				return;
			}

			const leftButtons = Array.prototype.slice.call(matchLeftEl.querySelectorAll('.zo-llp-button--match'));
			const rightButtons = Array.prototype.slice.call(matchRightEl.querySelectorAll('.zo-llp-button--match'));

			if (matchSelectedLeft.tr === matchSelectedRight.tr && matchSelectedLeft.en === matchSelectedRight.en) {
				leftButtons.forEach(function (btn) {
					if (btn.textContent === (direction === 'tr-en' ? matchSelectedLeft.tr : matchSelectedLeft.en) && !btn.disabled) {
						btn.disabled = true;
						btn.classList.remove('is-selected');
						btn.classList.add('is-correct');
					}
				});
				rightButtons.forEach(function (btn) {
					if (btn.textContent === (direction === 'tr-en' ? matchSelectedRight.en : matchSelectedRight.tr) && !btn.disabled) {
						btn.disabled = true;
						btn.classList.remove('is-selected');
						btn.classList.add('is-correct');
					}
				});

				score += 2;
				streak += 1;
				learnedWords += 1;
				matchPairsSolved += 1;
				setStatus(matchStatusEl, 'Doğru eşleşme.', 'is-good');

				if (matchPairsSolved === currentMatchSet.length) {
					setStatus(matchStatusEl, 'Tüm eşleşmeleri tamamladın.', 'is-good');
				}
			} else {
				streak = 0;
				setStatus(matchStatusEl, 'Yanlış eşleşme.', 'is-bad');
				leftButtons.forEach(function (btn) {
					btn.classList.remove('is-selected');
				});
				rightButtons.forEach(function (btn) {
					btn.classList.remove('is-selected');
				});
			}

			matchSelectedLeft = null;
			matchSelectedRight = null;
			updateHeader();
		}

		function applySettings() {
			direction = settingsDirectionEl.value;
			category = settingsCategoryEl.value;
			applyFilters();
			renderWordList();
			flashIndex = 0;
			loadFlashcard();
			loadQuiz();
			loadTyping();
			loadMatch();
			updateHeader();
		}

		function restartAll() {
			learnedWords = 0;
			score = 0;
			streak = 0;
			flashIndex = 0;
			direction = 'tr-en';
			category = 'all';
			settingsDirectionEl.value = direction;
			settingsCategoryEl.value = category;
			applySettings();
			setActiveMode('flashcards');
		}

		tabs.forEach(function (tab) {
			tab.addEventListener('click', function () {
				setActiveMode(tab.getAttribute('data-mode'));
			});
		});

		flashFlipButton.addEventListener('click', flipFlashcard);
		flashNextButton.addEventListener('click', nextFlashcard);

		quizNextButton.addEventListener('click', loadQuiz);

		typeCheckButton.addEventListener('click', checkTyping);
		typeHintButton.addEventListener('click', hintTyping);
		typeNextButton.addEventListener('click', loadTyping);

		typeInputEl.addEventListener('keydown', function (event) {
			if (event.key === 'Enter') {
				checkTyping();
			}
		});

		matchNextButton.addEventListener('click', loadMatch);

		applySettingsButton.addEventListener('click', applySettings);
		restartAllButton.addEventListener('click', restartAll);

		restartAll();
	});
});
JS;

if (!function_exists('zo_game_language_learning_platform_render')) {
	function zo_game_language_learning_platform_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-language-learning-platform-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--language-learning-platform" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-llp-title">Language Learning Platform</h2>
			<p class="zo-llp-desc">Kelime öğren, test çöz, yazı yaz ve eşleştirme yap. Aynı oyunda mini bir dil öğrenme sistemi var.</p>

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
					<span class="zo-llp-stat-label">Mod</span>
					<span class="zo-llp-stat-value zo-llp-mode">flashcards</span>
				</div>
			</div>

			<div class="zo-llp-tabs">
				<button type="button" class="zo-llp-tab is-active" data-mode="flashcards">Flashcards</button>
				<button type="button" class="zo-llp-tab" data-mode="quiz">Quiz</button>
				<button type="button" class="zo-llp-tab" data-mode="typing">Typing</button>
				<button type="button" class="zo-llp-tab" data-mode="matching">Matching</button>
			</div>

			<div class="zo-llp-main">
				<div class="zo-llp-panel is-active" data-mode="flashcards">
					<div class="zo-llp-card">
						<span class="zo-llp-card-label">Kelime</span>
						<div class="zo-llp-big zo-llp-flash-word">-</div>
						<div class="zo-llp-mid zo-llp-flash-translation">???</div>
						<div class="zo-llp-mini zo-llp-flash-category">-</div>
					</div>

					<div class="zo-llp-footer">
						<button type="button" class="zo-llp-button zo-llp-button--hint">Çeviriyi Göster</button>
						<button type="button" class="zo-llp-button zo-llp-button--good">Sonraki Kart</button>
					</div>
				</div>

				<div class="zo-llp-panel" data-mode="quiz">
					<div class="zo-llp-card">
						<span class="zo-llp-card-label">Doğru çeviriyi seç</span>
						<div class="zo-llp-big zo-llp-quiz-prompt">-</div>
					</div>

					<div class="zo-llp-choice-grid"></div>
					<div class="zo-llp-status zo-llp-status--quiz" aria-live="polite"></div>
					<button type="button" class="zo-llp-button zo-llp-button--good">Yeni Soru</button>
				</div>

				<div class="zo-llp-panel" data-mode="typing">
					<div class="zo-llp-card">
						<span class="zo-llp-card-label">Çeviriyi yaz</span>
						<div class="zo-llp-big zo-llp-type-prompt">-</div>
					</div>

					<div class="zo-llp-input-row">
						<input type="text" class="zo-llp-input zo-llp-input--type" placeholder="Cevabını yaz" />
						<button type="button" class="zo-llp-button zo-llp-button--primary">Kontrol Et</button>
						<button type="button" class="zo-llp-button zo-llp-button--hint">İpucu</button>
					</div>

					<div class="zo-llp-status zo-llp-status--type" aria-live="polite"></div>
					<button type="button" class="zo-llp-button zo-llp-button--good">Yeni Kelime</button>
				</div>

				<div class="zo-llp-panel" data-mode="matching">
					<div class="zo-llp-card">
						<span class="zo-llp-card-label">Eşleşen kelimeleri bul</span>
						<div class="zo-llp-big">Matching</div>
					</div>

					<div class="zo-llp-match-grid">
						<div class="zo-llp-list zo-llp-match-left"></div>
						<div class="zo-llp-list zo-llp-match-right"></div>
					</div>

					<div class="zo-llp-status zo-llp-status--match" aria-live="polite"></div>
					<button type="button" class="zo-llp-button zo-llp-button--good">Yeni Eşleştirme</button>
				</div>

				<div class="zo-llp-card">
					<span class="zo-llp-card-label">Ayarlar</span>

					<div class="zo-llp-settings-grid">
						<select class="zo-llp-select zo-llp-select--direction">
							<option value="tr-en">Türkçe → English</option>
							<option value="en-tr">English → Türkçe</option>
						</select>

						<select class="zo-llp-select zo-llp-select--category">
							<option value="all">Tüm Kategoriler</option>
							<option value="animal">Animals</option>
							<option value="food">Food</option>
							<option value="home">Home</option>
							<option value="school">School</option>
							<option value="nature">Nature</option>
						</select>
					</div>

					<div class="zo-llp-footer">
						<button type="button" class="zo-llp-button zo-llp-button--primary">Ayarları Uygula</button>
						<button type="button" class="zo-llp-button zo-llp-button--neutral">Baştan Başla</button>
					</div>
				</div>

				<div class="zo-llp-card">
					<span class="zo-llp-card-label">Kelime Listesi</span>
					<div class="zo-llp-list"></div>
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
	'description'     => 'Flashcards, quiz, typing, and matching in one simple browser-based language learning platform.',
	'render_callback' => 'zo_game_language_learning_platform_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);