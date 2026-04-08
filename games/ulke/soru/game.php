<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 860px;
	margin: 0 auto;
	padding: 16px;
	box-sizing: border-box;
	font-family: Arial, sans-serif;
	text-align: center;
}

.zo-game-root * {
	box-sizing: border-box;
}

.zo-game-root--country-quiz .zo-country-quiz-card {
	background: #f8fafc;
	border: 2px solid #d9e2ec;
	border-radius: 18px;
	padding: 18px;
	box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}

.zo-game-root--country-quiz .zo-country-quiz-title {
	margin: 0 0 8px;
	font-size: 28px;
	line-height: 1.2;
}

.zo-game-root--country-quiz .zo-country-quiz-help {
	margin: 0 0 16px;
	font-size: 16px;
	line-height: 1.5;
	color: #333;
}

.zo-game-root--country-quiz .zo-country-quiz-setup {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap: 10px;
	margin-bottom: 16px;
}

.zo-game-root--country-quiz .zo-country-quiz-input {
	width: 100%;
	max-width: 320px;
	padding: 12px 14px;
	border: 2px solid #ccd6e0;
	border-radius: 12px;
	font-size: 16px;
}

.zo-game-root--country-quiz .zo-country-quiz-btn {
	border: none;
	border-radius: 12px;
	padding: 12px 18px;
	font-size: 16px;
	font-weight: bold;
	cursor: pointer;
	color: #fff;
	background: #2563eb;
}

.zo-game-root--country-quiz .zo-country-quiz-btn:disabled {
	opacity: 0.6;
	cursor: default;
}

.zo-game-root--country-quiz .zo-country-quiz-btn--restart {
	background: #222;
}

.zo-game-root--country-quiz .zo-country-quiz-btn--next {
	background: #16a34a;
}

.zo-game-root--country-quiz .zo-country-quiz-topbar {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 10px;
	margin-bottom: 16px;
}

.zo-game-root--country-quiz .zo-country-quiz-stat {
	background: #fff;
	border: 2px solid #dde5ee;
	border-radius: 12px;
	padding: 10px;
	font-size: 15px;
	font-weight: bold;
}

.zo-game-root--country-quiz .zo-country-quiz-panel {
	background: #fff;
	border: 2px solid #dde5ee;
	border-radius: 16px;
	padding: 18px;
	margin-bottom: 14px;
}

.zo-game-root--country-quiz .zo-country-quiz-country {
	font-size: 20px;
	font-weight: bold;
	margin-bottom: 8px;
	color: #1d4ed8;
}

.zo-game-root--country-quiz .zo-country-quiz-question-count {
	font-size: 14px;
	font-weight: bold;
	margin-bottom: 10px;
	color: #555;
}

.zo-game-root--country-quiz .zo-country-quiz-question {
	font-size: 22px;
	font-weight: bold;
	line-height: 1.4;
	margin-bottom: 16px;
	color: #111827;
}

.zo-game-root--country-quiz .zo-country-quiz-options {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 10px;
}

.zo-game-root--country-quiz .zo-country-quiz-option {
	border: 2px solid #cfd8e3;
	border-radius: 14px;
	padding: 14px;
	background: #f8fafc;
	font-size: 16px;
	font-weight: bold;
	cursor: pointer;
	transition: transform 0.08s ease, border-color 0.08s ease;
}

.zo-game-root--country-quiz .zo-country-quiz-option:hover {
	transform: translateY(-1px);
	border-color: #94a3b8;
}

.zo-game-root--country-quiz .zo-country-quiz-option.is-correct {
	background: #dcfce7;
	border-color: #16a34a;
}

.zo-game-root--country-quiz .zo-country-quiz-option.is-wrong {
	background: #fee2e2;
	border-color: #dc2626;
}

.zo-game-root--country-quiz .zo-country-quiz-message {
	min-height: 52px;
	padding: 12px;
	background: #fff;
	border: 2px solid #dde5ee;
	border-radius: 14px;
	font-size: 16px;
	font-weight: bold;
	line-height: 1.4;
	color: #222;
	margin-bottom: 12px;
}

.zo-game-root--country-quiz .zo-country-quiz-bottom {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap: 10px;
}

.zo-game-root--country-quiz .zo-country-quiz-empty {
	padding: 18px;
	background: #fff;
	border: 2px dashed #cfd8e3;
	border-radius: 16px;
	color: #475569;
	font-weight: bold;
}

@media (max-width: 700px) {
	.zo-game-root--country-quiz .zo-country-quiz-topbar {
		grid-template-columns: 1fr 1fr;
	}

	.zo-game-root--country-quiz .zo-country-quiz-options {
		grid-template-columns: 1fr;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--country-quiz');

	games.forEach(function (game) {
		const countryInput = game.querySelector('.zo-country-quiz-input');
		const startBtn = game.querySelector('.zo-country-quiz-btn--start');
		const restartBtn = game.querySelector('.zo-country-quiz-btn--restart');
		const nextBtn = game.querySelector('.zo-country-quiz-btn--next');

		const coinEl = game.querySelector('.zo-country-quiz-coins');
		const qNumEl = game.querySelector('.zo-country-quiz-qnum');
		const correctEl = game.querySelector('.zo-country-quiz-correct');
		const wrongEl = game.querySelector('.zo-country-quiz-wrong');

		const panel = game.querySelector('.zo-country-quiz-panel');
		const countryEl = game.querySelector('.zo-country-quiz-country');
		const questionCountEl = game.querySelector('.zo-country-quiz-question-count');
		const questionEl = game.querySelector('.zo-country-quiz-question');
		const optionsEl = game.querySelector('.zo-country-quiz-options');
		const messageEl = game.querySelector('.zo-country-quiz-message');

		let coins = 0;
		let correctCount = 0;
		let wrongCount = 0;
		let questionIndex = 0;
		let currentCountry = '';
		let currentCountryData = null;
		let currentQuestions = [];
		let answered = false;

		const countryAliases = {
			'turkiye': 'turkey',
			'türkiye': 'turkey',
			'turkije': 'turkey',
			'turkey': 'turkey',
			'almanya': 'germany',
			'germany': 'germany',
			'fransa': 'france',
			'france': 'france',
			'ispanya': 'spain',
			'spanya': 'spain',
			'spain': 'spain',
			'italya': 'italy',
			'italy': 'italy',
			'japonya': 'japan',
			'japan': 'japan',
			'cin': 'china',
			'çin': 'china',
			'china': 'china',
			'abd': 'usa',
			'amerika': 'usa',
			'america': 'usa',
			'usa': 'usa',
			'america birlesik devletleri': 'usa',
			'amerika birlesik devletleri': 'usa',
			'america birleşik devletleri': 'usa',
			'amerika birleşik devletleri': 'usa',
			'brezilya': 'brazil',
			'brazil': 'brazil',
			'ingiltere': 'uk',
			'birlesik krallik': 'uk',
			'birleşik krallık': 'uk',
			'united kingdom': 'uk',
			'uk': 'uk',
			'rusya': 'russia',
			'russia': 'russia',
			'misir': 'egypt',
			'mısır': 'egypt',
			'egypt': 'egypt'
		};

		const countryData = {
			turkey: {
				display: 'Türkiye / Turkey',
				facts: {
					capital: 'Ankara',
					continent: 'Asia',
					flag: 'Red and white',
					language: 'Turkish',
					currency: 'Lira',
					famousFood: 'Kebab',
					landmark: 'Hagia Sophia',
					animal: 'Gray wolf',
					sea: 'Black Sea',
					neighbor: 'Greece',
					color: 'Red',
					sport: 'Football'
				}
			},
			germany: {
				display: 'Almanya / Germany',
				facts: {
					capital: 'Berlin',
					continent: 'Europe',
					flag: 'Black red yellow',
					language: 'German',
					currency: 'Euro',
					famousFood: 'Sausage',
					landmark: 'Brandenburg Gate',
					animal: 'Eagle',
					sea: 'North Sea',
					neighbor: 'France',
					color: 'Black',
					sport: 'Football'
				}
			},
			france: {
				display: 'Fransa / France',
				facts: {
					capital: 'Paris',
					continent: 'Europe',
					flag: 'Blue white red',
					language: 'French',
					currency: 'Euro',
					famousFood: 'Croissant',
					landmark: 'Eiffel Tower',
					animal: 'Rooster',
					sea: 'Mediterranean Sea',
					neighbor: 'Spain',
					color: 'Blue',
					sport: 'Football'
				}
			},
			spain: {
				display: 'İspanya / Spain',
				facts: {
					capital: 'Madrid',
					continent: 'Europe',
					flag: 'Red yellow red',
					language: 'Spanish',
					currency: 'Euro',
					famousFood: 'Paella',
					landmark: 'Sagrada Familia',
					animal: 'Bull',
					sea: 'Mediterranean Sea',
					neighbor: 'France',
					color: 'Yellow',
					sport: 'Football'
				}
			},
			italy: {
				display: 'İtalya / Italy',
				facts: {
					capital: 'Rome',
					continent: 'Europe',
					flag: 'Green white red',
					language: 'Italian',
					currency: 'Euro',
					famousFood: 'Pizza',
					landmark: 'Colosseum',
					animal: 'Wolf',
					sea: 'Mediterranean Sea',
					neighbor: 'France',
					color: 'Green',
					sport: 'Football'
				}
			},
			japan: {
				display: 'Japonya / Japan',
				facts: {
					capital: 'Tokyo',
					continent: 'Asia',
					flag: 'White with red circle',
					language: 'Japanese',
					currency: 'Yen',
					famousFood: 'Sushi',
					landmark: 'Mount Fuji',
					animal: 'Crane',
					sea: 'Pacific Ocean',
					neighbor: 'South Korea',
					color: 'White',
					sport: 'Baseball'
				}
			},
			china: {
				display: 'Çin / China',
				facts: {
					capital: 'Beijing',
					continent: 'Asia',
					flag: 'Red with yellow stars',
					language: 'Chinese',
					currency: 'Yuan',
					famousFood: 'Noodles',
					landmark: 'Great Wall',
					animal: 'Panda',
					sea: 'Pacific Ocean',
					neighbor: 'India',
					color: 'Red',
					sport: 'Table tennis'
				}
			},
			usa: {
				display: 'ABD / USA',
				facts: {
					capital: 'Washington DC',
					continent: 'North America',
					flag: 'Stars and stripes',
					language: 'English',
					currency: 'Dollar',
					famousFood: 'Burger',
					landmark: 'Statue of Liberty',
					animal: 'Bald eagle',
					sea: 'Atlantic Ocean',
					neighbor: 'Canada',
					color: 'Blue',
					sport: 'American football'
				}
			},
			brazil: {
				display: 'Brezilya / Brazil',
				facts: {
					capital: 'Brasilia',
					continent: 'South America',
					flag: 'Green yellow blue',
					language: 'Portuguese',
					currency: 'Real',
					famousFood: 'Feijoada',
					landmark: 'Christ the Redeemer',
					animal: 'Jaguar',
					sea: 'Atlantic Ocean',
					neighbor: 'Argentina',
					color: 'Green',
					sport: 'Football'
				}
			},
			uk: {
				display: 'İngiltere / United Kingdom',
				facts: {
					capital: 'London',
					continent: 'Europe',
					flag: 'Union Jack',
					language: 'English',
					currency: 'Pound',
					famousFood: 'Fish and chips',
					landmark: 'Big Ben',
					animal: 'Lion',
					sea: 'North Sea',
					neighbor: 'Ireland',
					color: 'Blue',
					sport: 'Football'
				}
			},
			russia: {
				display: 'Rusya / Russia',
				facts: {
					capital: 'Moscow',
					continent: 'Europe and Asia',
					flag: 'White blue red',
					language: 'Russian',
					currency: 'Ruble',
					famousFood: 'Borscht',
					landmark: 'Saint Basils Cathedral',
					animal: 'Bear',
					sea: 'Arctic Ocean',
					neighbor: 'China',
					color: 'White',
					sport: 'Ice hockey'
				}
			},
			egypt: {
				display: 'Mısır / Egypt',
				facts: {
					capital: 'Cairo',
					continent: 'Africa',
					flag: 'Red white black',
					language: 'Arabic',
					currency: 'Egyptian pound',
					famousFood: 'Koshari',
					landmark: 'Pyramids of Giza',
					animal: 'Camel',
					sea: 'Red Sea',
					neighbor: 'Libya',
					color: 'Gold',
					sport: 'Football'
				}
			}
		};

		const allValues = {
			capital: ['Ankara', 'Berlin', 'Paris', 'Madrid', 'Rome', 'Tokyo', 'Beijing', 'Washington DC', 'Brasilia', 'London', 'Moscow', 'Cairo'],
			continent: ['Asia', 'Europe', 'North America', 'South America', 'Africa', 'Europe and Asia'],
			flag: ['Red and white', 'Black red yellow', 'Blue white red', 'Red yellow red', 'Green white red', 'White with red circle', 'Red with yellow stars', 'Stars and stripes', 'Green yellow blue', 'Union Jack', 'White blue red', 'Red white black'],
			language: ['Turkish', 'German', 'French', 'Spanish', 'Italian', 'Japanese', 'Chinese', 'English', 'Portuguese', 'Russian', 'Arabic'],
			currency: ['Lira', 'Euro', 'Yen', 'Yuan', 'Dollar', 'Real', 'Pound', 'Ruble', 'Egyptian pound'],
			famousFood: ['Kebab', 'Sausage', 'Croissant', 'Paella', 'Pizza', 'Sushi', 'Noodles', 'Burger', 'Feijoada', 'Fish and chips', 'Borscht', 'Koshari'],
			landmark: ['Hagia Sophia', 'Brandenburg Gate', 'Eiffel Tower', 'Sagrada Familia', 'Colosseum', 'Mount Fuji', 'Great Wall', 'Statue of Liberty', 'Christ the Redeemer', 'Big Ben', 'Saint Basils Cathedral', 'Pyramids of Giza'],
			animal: ['Gray wolf', 'Eagle', 'Rooster', 'Bull', 'Wolf', 'Crane', 'Panda', 'Bald eagle', 'Jaguar', 'Lion', 'Bear', 'Camel'],
			sea: ['Black Sea', 'North Sea', 'Mediterranean Sea', 'Pacific Ocean', 'Atlantic Ocean', 'Arctic Ocean', 'Red Sea'],
			neighbor: ['Greece', 'France', 'Spain', 'South Korea', 'India', 'Canada', 'Argentina', 'Ireland', 'China', 'Libya'],
			color: ['Red', 'Black', 'Blue', 'Yellow', 'Green', 'White', 'Gold'],
			sport: ['Football', 'Baseball', 'Table tennis', 'American football', 'Ice hockey']
		};

		const questionTemplates = [
			{ key: 'capital', text: 'What is the capital of {country}?' },
			{ key: 'continent', text: '{country} is in which continent?' },
			{ key: 'language', text: 'What language is mainly spoken in {country}?' },
			{ key: 'currency', text: 'What currency is used in {country}?' },
			{ key: 'famousFood', text: 'Which food matches {country} best in this game?' },
			{ key: 'landmark', text: 'Which landmark is in {country}?' },
			{ key: 'animal', text: 'Which animal matches {country} in this game?' },
			{ key: 'sea', text: 'Which sea or ocean matches {country}?' },
			{ key: 'neighbor', text: 'Which country is shown here as a neighbor of {country}?' },
			{ key: 'color', text: 'Which color appears in the flag of {country}?' },
			{ key: 'sport', text: 'Which sport is strongly linked with {country} in this game?' },
			{ key: 'flag', text: 'Which flag description matches {country}?' }
		];

		function shuffle(array) {
			const arr = array.slice();
			for (let i = arr.length - 1; i > 0; i--) {
				const j = Math.floor(Math.random() * (i + 1));
				const temp = arr[i];
				arr[i] = arr[j];
				arr[j] = temp;
			}
			return arr;
		}

		function normalizeCountry(value) {
			return value
				.toLowerCase()
				.trim()
				.replace(/ı/g, 'i')
				.replace(/ö/g, 'o')
				.replace(/ü/g, 'u')
				.replace(/ş/g, 's')
				.replace(/ç/g, 'c')
				.replace(/ğ/g, 'g');
		}

		function resolveCountry(value) {
			const clean = normalizeCountry(value);
			return countryAliases[clean] || null;
		}

		function updateHud() {
			coinEl.textContent = String(coins);
			qNumEl.textContent = String(questionIndex);
			correctEl.textContent = String(correctCount);
			wrongEl.textContent = String(wrongCount);
		}

		function setMessage(text) {
			messageEl.textContent = text;
		}

		function makeQuestionSet(countryKey) {
			const data = countryData[countryKey];
			const questions = [];

			for (let i = 0; i < 100; i++) {
				const template = questionTemplates[i % questionTemplates.length];
				const correctAnswer = data.facts[template.key];
				const pool = allValues[template.key].filter(function (item) {
					return item !== correctAnswer;
				});
				const wrongOptions = shuffle(pool).slice(0, 3);
				const options = shuffle([correctAnswer].concat(wrongOptions));

				questions.push({
					text: template.text.replace('{country}', data.display),
					answer: correctAnswer,
					options: options
				});
			}

			return shuffle(questions);
		}

		function renderQuestion() {
			if (!currentQuestions.length || questionIndex >= currentQuestions.length) {
				panel.innerHTML = '<div class="zo-country-quiz-empty">Quiz finished. You answered 100 questions.</div>';
				setMessage('Quiz complete. Final coins: ' + coins + '. Correct answers give +10 coins. Wrong answers give -5 coins.');
				nextBtn.disabled = true;
				return;
			}

			const q = currentQuestions[questionIndex];
			answered = false;
			nextBtn.disabled = true;

			countryEl.textContent = currentCountryData.display;
			questionCountEl.textContent = 'Question ' + (questionIndex + 1) + ' / 100';
			questionEl.textContent = q.text;
			optionsEl.innerHTML = '';

			q.options.forEach(function (optionText) {
				const btn = document.createElement('button');
				btn.type = 'button';
				btn.className = 'zo-country-quiz-option';
				btn.textContent = optionText;

				btn.addEventListener('click', function () {
					if (answered) {
						return;
					}

					answered = true;
					const optionButtons = optionsEl.querySelectorAll('.zo-country-quiz-option');

					optionButtons.forEach(function (optionBtn) {
						optionBtn.disabled = true;
						if (optionBtn.textContent === q.answer) {
							optionBtn.classList.add('is-correct');
						}
					});

					if (optionText === q.answer) {
						btn.classList.add('is-correct');
						coins += 10;
						correctCount++;
						setMessage('Correct. You win 10 coins.');
					} else {
						btn.classList.add('is-wrong');
						coins -= 5;
						wrongCount++;
						setMessage('Wrong. Correct answer: ' + q.answer + '. You lose 5 coins.');
					}

					updateHud();
					nextBtn.disabled = false;
				});
				optionsEl.appendChild(btn);
			});
		}

		function startQuiz() {
			const countryKey = resolveCountry(countryInput.value);

			if (!countryKey || !countryData[countryKey]) {
				setMessage('Country not found. Try Türkiye, Turkey, Almanya, Germany, Fransa, France, Japonya, Japan, ABD, USA and more.');
				return;
			}

			currentCountry = countryKey;
			currentCountryData = countryData[countryKey];
			currentQuestions = makeQuestionSet(countryKey);

			coins = 100;
			correctCount = 0;
			wrongCount = 0;
			questionIndex = 0;

			updateHud();
			setMessage('Quiz started for ' + currentCountryData.display + '.');
			renderQuestion();
		}

		function nextQuestion() {
			if (!answered) {
				setMessage('Pick an answer first.');
				return;
			}

			questionIndex++;
			updateHud();
			renderQuestion();
		}

		function restartQuiz() {
			coins = 0;
			correctCount = 0;
			wrongCount = 0;
			questionIndex = 0;
			currentCountry = '';
			currentCountryData = null;
			currentQuestions = [];
			answered = false;

			updateHud();
			nextBtn.disabled = true;
			countryEl.textContent = 'No country selected yet';
			questionCountEl.textContent = 'Question 0 / 100';
			questionEl.textContent = 'Write a country name in Turkish or English, then press Start Quiz.';
			optionsEl.innerHTML = '';
			setMessage('Type a country name to begin.');
		}

		startBtn.addEventListener('click', function () {
			startQuiz();
		});

		restartBtn.addEventListener('click', function () {
			restartQuiz();
		});

		nextBtn.addEventListener('click', function () {
			nextQuestion();
		});

		countryInput.addEventListener('keydown', function (event) {
			if (event.key === 'Enter') {
				event.preventDefault();
				startQuiz();
			}
		});

		restartQuiz();
	});
});
JS;

if (!function_exists('zo_game_arslan_country_quiz_render')) {
	function zo_game_arslan_country_quiz_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-arslan-country-quiz-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--country-quiz" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-country-quiz-card">
				<h2 class="zo-country-quiz-title">Country Quiz Coins</h2>
				<p class="zo-country-quiz-help">Write a country name in Turkish or English. The game opens 100 questions about that country. Correct answers give coins. Wrong answers remove coins.</p>

				<div class="zo-country-quiz-setup">
					<input type="text" class="zo-country-quiz-input" placeholder="Türkiye, Turkey, Almanya, Germany..." />
					<button type="button" class="zo-country-quiz-btn zo-country-quiz-btn--start">Start Quiz</button>
				</div>

				<div class="zo-country-quiz-topbar">
					<div class="zo-country-quiz-stat">Coins: <span class="zo-country-quiz-coins">0</span></div>
					<div class="zo-country-quiz-stat">Question: <span class="zo-country-quiz-qnum">0</span></div>
					<div class="zo-country-quiz-stat">Correct: <span class="zo-country-quiz-correct">0</span></div>
					<div class="zo-country-quiz-stat">Wrong: <span class="zo-country-quiz-wrong">0</span></div>
				</div>

				<div class="zo-country-quiz-panel">
					<div class="zo-country-quiz-country">No country selected yet</div>
					<div class="zo-country-quiz-question-count">Question 0 / 100</div>
					<div class="zo-country-quiz-question">Write a country name in Turkish or English, then press Start Quiz.</div>
					<div class="zo-country-quiz-options"></div>
				</div>

				<div class="zo-country-quiz-message">Type a country name to begin.</div>

				<div class="zo-country-quiz-bottom">
					<button type="button" class="zo-country-quiz-btn zo-country-quiz-btn--next" disabled>Next Question</button>
					<button type="button" class="zo-country-quiz-btn zo-country-quiz-btn--restart">Restart</button>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'arslan-country-quiz',
	'name'            => 'Country Quiz Coins',
	'author'          => 'Arslan',
	'description'     => 'Write a country name and answer 100 quiz questions to win or lose coins.',
	'render_callback' => 'zo_game_arslan_country_quiz_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);