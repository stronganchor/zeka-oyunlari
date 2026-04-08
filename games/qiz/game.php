<?php

if (!defined('ABSPATH')) {
	exit;
}

$inline_style = <<<'CSS'
.zo-game-root--ulke-100-soru *{box-sizing:border-box}
.zo-game-root--ulke-100-soru{max-width:1100px;margin:0 auto;padding:16px;font-family:Arial,sans-serif;color:#1f2937}
.zo-game-root--ulke-100-soru .zo-u100-wrap{background:#fff;border:1px solid #dbe3ea;border-radius:22px;padding:18px;box-shadow:0 10px 30px rgba(0,0,0,.08)}
.zo-game-root--ulke-100-soru .zo-u100-title{margin:0 0 8px;text-align:center;font-size:32px;line-height:1.2;color:#0f172a}
.zo-game-root--ulke-100-soru .zo-u100-subtitle{margin:0 0 18px;text-align:center;font-size:15px;line-height:1.5;color:#475569}
.zo-game-root--ulke-100-soru .zo-u100-topbar{display:flex;flex-wrap:wrap;gap:12px;justify-content:space-between;align-items:center;margin-bottom:16px}
.zo-game-root--ulke-100-soru .zo-u100-stats{display:flex;flex-wrap:wrap;gap:10px}
.zo-game-root--ulke-100-soru .zo-u100-stat{background:#f3f6fa;border:1px solid #dbe3ea;border-radius:12px;padding:10px 14px;font-size:14px;font-weight:700}
.zo-game-root--ulke-100-soru .zo-u100-layout{display:grid;grid-template-columns:1fr 300px;gap:16px}
.zo-game-root--ulke-100-soru .zo-u100-main,
.zo-game-root--ulke-100-soru .zo-u100-side{background:#f8fafc;border:1px solid #dbe3ea;border-radius:18px;padding:14px}
.zo-game-root--ulke-100-soru .zo-u100-side h3{margin:0 0 10px;font-size:18px;color:#0f172a}
.zo-game-root--ulke-100-soru .zo-u100-side p,
.zo-game-root--ulke-100-soru .zo-u100-side li{font-size:14px;line-height:1.5;color:#475569}
.zo-game-root--ulke-100-soru .zo-u100-side ul{margin:0 0 14px;padding-left:18px}
.zo-game-root--ulke-100-soru .zo-u100-input-row{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:14px}
.zo-game-root--ulke-100-soru .zo-u100-input{flex:1 1 280px;padding:12px 14px;border:1px solid #cfd8e3;border-radius:12px;font:inherit;font-size:16px;background:#fff}
.zo-game-root--ulke-100-soru .zo-u100-btn{padding:12px 16px;border-radius:12px;border:1px solid #cfd8e3;background:#fff;color:#1f2937;font:inherit;font-size:15px;font-weight:700;cursor:pointer}
.zo-game-root--ulke-100-soru .zo-u100-btn--primary{background:#2563eb;border-color:#2563eb;color:#fff}
.zo-game-root--ulke-100-soru .zo-u100-btn--danger{background:#ef4444;border-color:#ef4444;color:#fff}
.zo-game-root--ulke-100-soru .zo-u100-country-line{font-size:15px;font-weight:700;color:#334155;margin-bottom:12px}
.zo-game-root--ulke-100-soru .zo-u100-progress{height:16px;background:#e2e8f0;border:1px solid #cbd5e1;border-radius:999px;overflow:hidden;margin-bottom:16px}
.zo-game-root--ulke-100-soru .zo-u100-progress-fill{height:100%;width:0%;background:linear-gradient(90deg,#22c55e 0%,#3b82f6 100%)}
.zo-game-root--ulke-100-soru .zo-u100-question{background:#fff;border:1px solid #dbe3ea;border-radius:16px;padding:16px;margin-bottom:14px}
.zo-game-root--ulke-100-soru .zo-u100-question-number{font-size:13px;font-weight:700;color:#64748b;margin-bottom:8px}
.zo-game-root--ulke-100-soru .zo-u100-question-text{font-size:22px;line-height:1.35;font-weight:800;color:#0f172a}
.zo-game-root--ulke-100-soru .zo-u100-answers{display:grid;grid-template-columns:1fr;gap:10px}
.zo-game-root--ulke-100-soru .zo-u100-answer{padding:14px;border:1px solid #cfd8e3;border-radius:14px;background:#fff;font:inherit;font-size:16px;font-weight:700;cursor:pointer;text-align:left}
.zo-game-root--ulke-100-soru .zo-u100-answer:hover,
.zo-game-root--ulke-100-soru .zo-u100-answer:focus{outline:none;background:#eff6ff;border-color:#93c5fd}
.zo-game-root--ulke-100-soru .zo-u100-message{margin-top:14px;padding:12px 14px;border-radius:12px;background:#eff6ff;border:1px solid #bfdbfe;font-size:14px;font-weight:700;color:#1d4ed8;min-height:46px}
.zo-game-root--ulke-100-soru .zo-u100-finish{display:none;background:#fff;border:1px solid #dbe3ea;border-radius:16px;padding:16px}
.zo-game-root--ulke-100-soru .zo-u100-finish.is-visible{display:block}
.zo-game-root--ulke-100-soru .zo-u100-finish-title{margin:0 0 10px;font-size:28px;color:#0f172a}
.zo-game-root--ulke-100-soru .zo-u100-finish-text{font-size:16px;line-height:1.5;color:#475569}
@media (max-width:900px){
.zo-game-root--ulke-100-soru .zo-u100-layout{grid-template-columns:1fr}
}
@media (max-width:640px){
.zo-game-root--ulke-100-soru{padding:10px}
.zo-game-root--ulke-100-soru .zo-u100-wrap{padding:12px}
.zo-game-root--ulke-100-soru .zo-u100-title{font-size:26px}
.zo-game-root--ulke-100-soru .zo-u100-question-text{font-size:19px}
}
CSS;

$inline_script = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const roots = document.querySelectorAll('.zo-game-root--ulke-100-soru');

	roots.forEach(function (root) {
		const input = root.querySelector('.zo-u100-input');
		const startBtn = root.querySelector('.zo-u100-start');
		const resetBtn = root.querySelector('.zo-u100-reset');
		const coinEl = root.querySelector('.zo-u100-coins');
		const rightEl = root.querySelector('.zo-u100-right');
		const wrongEl = root.querySelector('.zo-u100-wrong');
		const numEl = root.querySelector('.zo-u100-num');
		const countryLine = root.querySelector('.zo-u100-country-line');
		const progressFill = root.querySelector('.zo-u100-progress-fill');
		const questionNumber = root.querySelector('.zo-u100-question-number');
		const questionText = root.querySelector('.zo-u100-question-text');
		const answersWrap = root.querySelector('.zo-u100-answers');
		const messageEl = root.querySelector('.zo-u100-message');
		const finishWrap = root.querySelector('.zo-u100-finish');
		const finishText = root.querySelector('.zo-u100-finish-text');

		const countries = {
			turkey: {
				name: 'Turkey',
				display: 'Türkiye',
				aliases: ['turkey', 'türkiye', 'turkiye'],
				capital: 'Ankara',
				continent: 'Asia',
				currency: 'Turkish lira',
				language: 'Turkish',
				flag: 'red',
				famousFood: 'baklava',
				landmark: 'Hagia Sophia',
				city: 'Istanbul',
				nationalAnimal: 'gray wolf',
				sea: 'Black Sea'
			},
			usa: {
				name: 'United States',
				display: 'Amerika Birleşik Devletleri',
				aliases: ['usa', 'united states', 'america', 'amerika', 'abd'],
				capital: 'Washington, D.C.',
				continent: 'North America',
				currency: 'US dollar',
				language: 'English',
				flag: 'red, white, and blue',
				famousFood: 'burger',
				landmark: 'Statue of Liberty',
				city: 'New York',
				nationalAnimal: 'bald eagle',
				sea: 'Atlantic Ocean'
			},
			germany: {
				name: 'Germany',
				display: 'Almanya',
				aliases: ['germany', 'almanya', 'deutschland'],
				capital: 'Berlin',
				continent: 'Europe',
				currency: 'euro',
				language: 'German',
				flag: 'black, red, and gold',
				famousFood: 'pretzel',
				landmark: 'Brandenburg Gate',
				city: 'Munich',
				nationalAnimal: 'eagle',
				sea: 'North Sea'
			},
			france: {
				name: 'France',
				display: 'Fransa',
				aliases: ['france', 'fransa'],
				capital: 'Paris',
				continent: 'Europe',
				currency: 'euro',
				language: 'French',
				flag: 'blue, white, and red',
				famousFood: 'croissant',
				landmark: 'Eiffel Tower',
				city: 'Lyon',
				nationalAnimal: 'rooster',
				sea: 'Atlantic Ocean'
			},
			japan: {
				name: 'Japan',
				display: 'Japonya',
				aliases: ['japan', 'japonya', 'nippon'],
				capital: 'Tokyo',
				continent: 'Asia',
				currency: 'yen',
				language: 'Japanese',
				flag: 'white with a red circle',
				famousFood: 'sushi',
				landmark: 'Mount Fuji',
				city: 'Osaka',
				nationalAnimal: 'green pheasant',
				sea: 'Pacific Ocean'
			},
			brazil: {
				name: 'Brazil',
				display: 'Brezilya',
				aliases: ['brazil', 'brezilya', 'brasil'],
				capital: 'Brasilia',
				continent: 'South America',
				currency: 'real',
				language: 'Portuguese',
				flag: 'green, yellow, and blue',
				famousFood: 'feijoada',
				landmark: 'Christ the Redeemer',
				city: 'Rio de Janeiro',
				nationalAnimal: 'jaguar',
				sea: 'Atlantic Ocean'
			},
			italy: {
				name: 'Italy',
				display: 'İtalya',
				aliases: ['italy', 'italya', 'italia'],
				capital: 'Rome',
				continent: 'Europe',
				currency: 'euro',
				language: 'Italian',
				flag: 'green, white, and red',
				famousFood: 'pizza',
				landmark: 'Colosseum',
				city: 'Milan',
				nationalAnimal: 'Italian wolf',
				sea: 'Mediterranean Sea'
			},
			spain: {
				name: 'Spain',
				display: 'İspanya',
				aliases: ['spain', 'ispanya', 'i̇spanya', 'españa', 'espana'],
				capital: 'Madrid',
				continent: 'Europe',
				currency: 'euro',
				language: 'Spanish',
				flag: 'red and yellow',
				famousFood: 'paella',
				landmark: 'Sagrada Familia',
				city: 'Barcelona',
				nationalAnimal: 'bull',
				sea: 'Mediterranean Sea'
			},
			uk: {
				name: 'United Kingdom',
				display: 'İngiltere / Birleşik Krallık',
				aliases: ['uk', 'united kingdom', 'britain', 'england', 'ingiltere', 'birleşik krallık', 'birlesik krallik'],
				capital: 'London',
				continent: 'Europe',
				currency: 'pound sterling',
				language: 'English',
				flag: 'Union Jack',
				famousFood: 'fish and chips',
				landmark: 'Big Ben',
				city: 'Manchester',
				nationalAnimal: 'lion',
				sea: 'North Sea'
			},
			russia: {
				name: 'Russia',
				display: 'Rusya',
				aliases: ['russia', 'rusya', 'rossiya'],
				capital: 'Moscow',
				continent: 'Europe and Asia',
				currency: 'ruble',
				language: 'Russian',
				flag: 'white, blue, and red',
				famousFood: 'borscht',
				landmark: 'Saint Basil’s Cathedral',
				city: 'Saint Petersburg',
				nationalAnimal: 'brown bear',
				sea: 'Arctic Ocean'
			}
		};

		const state = {
			activeCountry: null,
			questions: [],
			index: 0,
			coins: 0,
			right: 0,
			wrong: 0,
			running: false
		};

		function setMessage(text) {
			messageEl.textContent = text;
		}

		function updateStats() {
			coinEl.textContent = String(state.coins);
			rightEl.textContent = String(state.right);
			wrongEl.textContent = String(state.wrong);
			numEl.textContent = state.running ? (state.index + 1) + '/100' : '0/100';
			progressFill.style.width = state.running ? (((state.index) / 100) * 100) + '%' : '0%';
		}

		function normalize(text) {
			return String(text || '')
				.toLowerCase()
				.replace(/ı/g, 'i')
				.replace(/ğ/g, 'g')
				.replace(/ü/g, 'u')
				.replace(/ş/g, 's')
				.replace(/ö/g, 'o')
				.replace(/ç/g, 'c')
				.trim();
		}

		function findCountryByInput(text) {
			const n = normalize(text);
			const keys = Object.keys(countries);
			for (let i = 0; i < keys.length; i++) {
				const c = countries[keys[i]];
				for (let j = 0; j < c.aliases.length; j++) {
					if (normalize(c.aliases[j]) === n) {
						return c;
					}
				}
			}
			return null;
		}

		function shuffle(arr) {
			const a = arr.slice();
			for (let i = a.length - 1; i > 0; i--) {
				const j = Math.floor(Math.random() * (i + 1));
				const t = a[i];
				a[i] = a[j];
				a[j] = t;
			}
			return a;
		}

		function otherCountries(currentName) {
			return Object.values(countries).filter(function (c) {
				return c.name !== currentName;
			});
		}

		function pickOtherValues(currentCountry, key, count) {
			const vals = [];
			const pool = shuffle(otherCountries(currentCountry.name));
			for (let i = 0; i < pool.length && vals.length < count; i++) {
				const v = pool[i][key];
				if (v !== currentCountry[key] && vals.indexOf(v) === -1) {
					vals.push(v);
				}
			}
			return vals;
		}

		function makeQuestion(text, correct, wrongs) {
			const options = shuffle([correct].concat(wrongs.slice(0, 3)));
			return {
				text: text,
				correct: correct,
				options: options
			};
		}

		function buildCountryQuestionPool(country) {
			const pool = [];

			pool.push(makeQuestion(country.display + ' ülkesinin başkenti hangisidir?', country.capital, pickOtherValues(country, 'capital', 3)));
			pool.push(makeQuestion('What is the capital of ' + country.name + '?', country.capital, pickOtherValues(country, 'capital', 3)));

			pool.push(makeQuestion(country.display + ' hangi kıtadadır?', country.continent, pickOtherValues(country, 'continent', 3)));
			pool.push(makeQuestion(country.name + ' is in which continent?', country.continent, pickOtherValues(country, 'continent', 3)));

			pool.push(makeQuestion(country.display + ' para birimi nedir?', country.currency, pickOtherValues(country, 'currency', 3)));
			pool.push(makeQuestion('What is the currency of ' + country.name + '?', country.currency, pickOtherValues(country, 'currency', 3)));

			pool.push(makeQuestion(country.display + ' ülkesinde en yaygın dil hangisidir?', country.language, pickOtherValues(country, 'language', 3)));
			pool.push(makeQuestion('What language is mainly spoken in ' + country.name + '?', country.language, pickOtherValues(country, 'language', 3)));

			pool.push(makeQuestion(country.display + ' bayrağı en çok hangi renklerle bilinir?', country.flag, pickOtherValues(country, 'flag', 3)));
			pool.push(makeQuestion('Which landmark is strongly linked with ' + country.name + '?', country.landmark, pickOtherValues(country, 'landmark', 3)));

			pool.push(makeQuestion(country.display + ' ile en çok ilişkilendirilen yemek hangisidir?', country.famousFood, pickOtherValues(country, 'famousFood', 3)));
			pool.push(makeQuestion('Which food is strongly linked with ' + country.name + '?', country.famousFood, pickOtherValues(country, 'famousFood', 3)));

			pool.push(makeQuestion(country.display + ' ile bağlantılı ünlü yapı hangisidir?', country.landmark, pickOtherValues(country, 'landmark', 3)));
			pool.push(makeQuestion(country.name + ' is associated with which famous place?', country.landmark, pickOtherValues(country, 'landmark', 3)));

			pool.push(makeQuestion(country.display + ' içinde bulunan ünlü şehirlerden biri hangisidir?', country.city, pickOtherValues(country, 'city', 3)));
			pool.push(makeQuestion('Which city belongs to ' + country.name + '?', country.city, pickOtherValues(country, 'city', 3)));

			pool.push(makeQuestion(country.display + ' ile ilişkilendirilen hayvan hangisidir?', country.nationalAnimal, pickOtherValues(country, 'nationalAnimal', 3)));
			pool.push(makeQuestion('Which animal is linked with ' + country.name + '?', country.nationalAnimal, pickOtherValues(country, 'nationalAnimal', 3)));

			pool.push(makeQuestion(country.display + ' ile bağlantılı deniz veya okyanus hangisidir?', country.sea, pickOtherValues(country, 'sea', 3)));
			pool.push(makeQuestion('Which sea or ocean is connected with ' + country.name + '?', country.sea, pickOtherValues(country, 'sea', 3)));

			const allCountries = Object.values(countries);

			pool.push(makeQuestion('Which country has the capital ' + country.capital + '?', country.name, shuffle(allCountries.filter(c => c.name !== country.name).map(c => c.name)).slice(0,3)));
			pool.push(makeQuestion(country.capital + ' hangi ülkenin başkentidir?', country.display, shuffle(allCountries.filter(c => c.name !== country.name).map(c => c.display)).slice(0,3)));

			pool.push(makeQuestion('Which country uses ' + country.currency + '?', country.name, shuffle(allCountries.filter(c => c.name !== country.name).map(c => c.name)).slice(0,3)));
			pool.push(makeQuestion(country.currency + ' hangi ülkenin para birimidir?', country.display, shuffle(allCountries.filter(c => c.name !== country.name).map(c => c.display)).slice(0,3)));

			pool.push(makeQuestion('Which country is linked with ' + country.landmark + '?', country.name, shuffle(allCountries.filter(c => c.name !== country.name).map(c => c.name)).slice(0,3)));
			pool.push(makeQuestion(country.landmark + ' hangi ülkeyle ilişkilidir?', country.display, shuffle(allCountries.filter(c => c.name !== country.name).map(c => c.display)).slice(0,3)));

			pool.push(makeQuestion('Which country is linked with ' + country.famousFood + '?', country.name, shuffle(allCountries.filter(c => c.name !== country.name).map(c => c.name)).slice(0,3)));
			pool.push(makeQuestion(country.famousFood + ' hangi ülkeyle daha çok ilişkilidir?', country.display, shuffle(allCountries.filter(c => c.name !== country.name).map(c => c.display)).slice(0,3)));

			pool.push(makeQuestion('Which country mainly speaks ' + country.language + '?', country.name, shuffle(allCountries.filter(c => c.name !== country.name).map(c => c.name)).slice(0,3)));
			pool.push(makeQuestion(country.language + ' dili en çok hangi ülkede konuşulur?', country.display, shuffle(allCountries.filter(c => c.name !== country.name).map(c => c.display)).slice(0,3)));

			pool.push(makeQuestion('Which country is connected with ' + country.city + '?', country.name, shuffle(allCountries.filter(c => c.name !== country.name).map(c => c.name)).slice(0,3)));
			pool.push(makeQuestion(country.city + ' hangi ülkededir?', country.display, shuffle(allCountries.filter(c => c.name !== country.name).map(c => c.display)).slice(0,3)));

			return pool;
		}

		function build100Questions(country) {
			const basePool = buildCountryQuestionPool(country);
			const out = [];
			let rounds = 0;

			while (out.length < 100 && rounds < 20) {
				const shuffled = shuffle(basePool);
				for (let i = 0; i < shuffled.length && out.length < 100; i++) {
					out.push({
						text: shuffled[i].text,
						correct: shuffled[i].correct,
						options: shuffled[i].options.slice()
					});
				}
				rounds++;
			}

			return out.slice(0, 100);
		}

		function showQuestion() {
			const q = state.questions[state.index];
			if (!q) {
				finishGame();
				return;
			}

			questionNumber.textContent = 'Soru ' + (state.index + 1) + ' / 100';
			questionText.textContent = q.text;
			answersWrap.innerHTML = '';

			q.options.forEach(function (opt) {
				const btn = document.createElement('button');
				btn.type = 'button';
				btn.className = 'zo-u100-answer';
				btn.textContent = opt;
				btn.addEventListener('click', function () {
					answerQuestion(opt);
				});
				answersWrap.appendChild(btn);
			});

			updateStats();
		}

		function answerQuestion(answer) {
			const q = state.questions[state.index];
			if (!q) {
				return;
			}

			if (answer === q.correct) {
				state.coins += 10;
				state.right += 1;
				setMessage('Doğru. +10 coin');
			} else {
				state.coins = Math.max(0, state.coins - 5);
				state.wrong += 1;
				setMessage('Yanlış. Doğru cevap: ' + q.correct + '. -5 coin');
			}

			state.index += 1;

			if (state.index >= 100) {
				finishGame();
			} else {
				showQuestion();
			}
		}

		function finishGame() {
			state.running = false;
			progressFill.style.width = '100%';
			finishWrap.classList.add('is-visible');
			finishText.textContent = 'Bitti. Toplam coin: ' + state.coins + '. Doğru: ' + state.right + '. Yanlış: ' + state.wrong + '.';
			setMessage('Quiz tamamlandı.');
			updateStats();
		}

		function resetGame() {
			state.activeCountry = null;
			state.questions = [];
			state.index = 0;
			state.coins = 0;
			state.right = 0;
			state.wrong = 0;
			state.running = false;
			countryLine.textContent = 'Ülke: -';
			questionNumber.textContent = 'Soru 0 / 100';
			questionText.textContent = 'Bir ülke adı yaz ve başlat.';
			answersWrap.innerHTML = '';
			finishWrap.classList.remove('is-visible');
			updateStats();
			setMessage('Ülke adını Türkçe veya İngilizce yaz.');
		}

		function startGame() {
			const country = findCountryByInput(input.value);
			if (!country) {
				setMessage('Bu sürümde bu ülke tanımlı değil. Desteklenen ülkeler sağ tarafta.');
				return;
			}

			state.activeCountry = country;
			state.questions = build100Questions(country);
			state.index = 0;
			state.coins = 0;
			state.right = 0;
			state.wrong = 0;
			state.running = true;

			countryLine.textContent = 'Ülke: ' + country.display + ' / ' + country.name;
			finishWrap.classList.remove('is-visible');
			setMessage(country.display + ' için 100 soru hazırlandı.');
			showQuestion();
		}

		startBtn.addEventListener('click', function () {
			startGame();
		});

		resetBtn.addEventListener('click', function () {
			resetGame();
		});

		input.addEventListener('keydown', function (e) {
			if (e.key === 'Enter') {
				e.preventDefault();
				startGame();
			}
		});

		resetGame();
	});
});
JS;

if (!function_exists('zo_ulke_100_soru_render')) {
	function zo_ulke_100_soru_render($post_id = 0, $game = array()) {
		$game_id = 'zo-ulke-100-soru-' . wp_rand(1000, 999999);

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--ulke-100-soru" id="<?php echo esc_attr($game_id); ?>">
			<div class="zo-u100-wrap">
				<h2 class="zo-u100-title">Ülke 100 Soru</h2>
				<p class="zo-u100-subtitle">Ülke adını Türkçe veya İngilizce yaz. O ülke hakkında 100 soru açılsın. Doğru yapınca coin kazan, yanlışta coin kaybet.</p>

				<div class="zo-u100-topbar">
					<div class="zo-u100-stats">
						<div class="zo-u100-stat">Coin: <span class="zo-u100-coins">0</span></div>
						<div class="zo-u100-stat">Doğru: <span class="zo-u100-right">0</span></div>
						<div class="zo-u100-stat">Yanlış: <span class="zo-u100-wrong">0</span></div>
						<div class="zo-u100-stat">İlerleme: <span class="zo-u100-num">0/100</span></div>
					</div>
				</div>

				<div class="zo-u100-layout">
					<div class="zo-u100-main">
						<div class="zo-u100-input-row">
							<input type="text" class="zo-u100-input" placeholder="Örnek: Türkiye, Turkey, Almanya, Germany, Japonya, Japan">
							<button type="button" class="zo-u100-btn zo-u100-btn--primary zo-u100-start">Başlat</button>
							<button type="button" class="zo-u100-btn zo-u100-btn--danger zo-u100-reset">Sıfırla</button>
						</div>

						<div class="zo-u100-country-line">Ülke: -</div>

						<div class="zo-u100-progress">
							<div class="zo-u100-progress-fill"></div>
						</div>

						<div class="zo-u100-question">
							<div class="zo-u100-question-number">Soru 0 / 100</div>
							<div class="zo-u100-question-text">Bir ülke adı yaz ve başlat.</div>
						</div>

						<div class="zo-u100-answers"></div>

						<div class="zo-u100-finish">
							<h3 class="zo-u100-finish-title">Quiz Bitti</h3>
							<div class="zo-u100-finish-text"></div>
						</div>

						<div class="zo-u100-message">Ülke adını Türkçe veya İngilizce yaz.</div>
					</div>

					<div class="zo-u100-side">
						<h3>Nasıl Oynanır</h3>
						<ul>
							<li>Ülke adını yaz.</li>
							<li>Türkçe veya İngilizce olabilir.</li>
							<li>100 soru açılır.</li>
							<li>Doğru cevap: +10 coin</li>
							<li>Yanlış cevap: -5 coin</li>
						</ul>

						<h3>Desteklenen Ülkeler</h3>
						<ul>
							<li>Türkiye / Turkey</li>
							<li>Amerika / USA / United States</li>
							<li>Almanya / Germany</li>
							<li>Fransa / France</li>
							<li>Japonya / Japan</li>
							<li>Brezilya / Brazil</li>
							<li>İtalya / Italy</li>
							<li>İspanya / Spain</li>
							<li>İngiltere / UK / United Kingdom</li>
							<li>Rusya / Russia</li>
						</ul>

						<p>İstersen sonraki sürümde buna daha fazla ülke ekleyebilirim.</p>
					</div>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'ulke-100-soru',
	'name'            => 'Ülke 100 Soru',
	'author'          => 'Arslan',
	'description'     => 'Ülke adını yazınca o ülke hakkında 100 soru açan coinli quiz oyunu.',
	'render_callback' => 'zo_ulke_100_soru_render',
	'inline_style'    => $inline_style,
	'inline_script'   => $inline_script,
);