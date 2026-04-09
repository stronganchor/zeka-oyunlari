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
			turkey:{name:'Turkey',display:'Türkiye',aliases:['turkey','türkiye','turkiye'],capital:'Ankara',continent:'Asia',currency:'Turkish lira',language:'Turkish'},
			usa:{name:'United States',display:'Amerika Birleşik Devletleri',aliases:['usa','united states','america','amerika','abd'],capital:'Washington, D.C.',continent:'North America',currency:'US dollar',language:'English'},
			germany:{name:'Germany',display:'Almanya',aliases:['germany','almanya','deutschland'],capital:'Berlin',continent:'Europe',currency:'euro',language:'German'},
			france:{name:'France',display:'Fransa',aliases:['france','fransa'],capital:'Paris',continent:'Europe',currency:'euro',language:'French'},
			japan:{name:'Japan',display:'Japonya',aliases:['japan','japonya','nippon'],capital:'Tokyo',continent:'Asia',currency:'yen',language:'Japanese'},
			brazil:{name:'Brazil',display:'Brezilya',aliases:['brazil','brezilya','brasil'],capital:'Brasilia',continent:'South America',currency:'real',language:'Portuguese'},
			italy:{name:'Italy',display:'İtalya',aliases:['italy','italya','italia'],capital:'Rome',continent:'Europe',currency:'euro',language:'Italian'},
			spain:{name:'Spain',display:'İspanya',aliases:['spain','ispanya','i̇spanya','espana','españa'],capital:'Madrid',continent:'Europe',currency:'euro',language:'Spanish'},
			uk:{name:'United Kingdom',display:'İngiltere / Birleşik Krallık',aliases:['uk','united kingdom','britain','england','ingiltere','birleşik krallık','birlesik krallik'],capital:'London',continent:'Europe',currency:'pound sterling',language:'English'},
			russia:{name:'Russia',display:'Rusya',aliases:['russia','rusya','rossiya'],capital:'Moscow',continent:'Europe and Asia',currency:'ruble',language:'Russian'},

			algeria:{name:'Algeria',display:'Cezayir',aliases:['algeria','cezayir'],capital:'Algiers',continent:'Africa',currency:'Algerian dinar',language:'Arabic'},
			angola:{name:'Angola',display:'Angola',aliases:['angola'],capital:'Luanda',continent:'Africa',currency:'kwanza',language:'Portuguese'},
			benin:{name:'Benin',display:'Benin',aliases:['benin'],capital:'Porto-Novo',continent:'Africa',currency:'West African CFA franc',language:'French'},
			botswana:{name:'Botswana',display:'Botsvana',aliases:['botswana','botsvana'],capital:'Gaborone',continent:'Africa',currency:'pula',language:'English'},
			burkinafaso:{name:'Burkina Faso',display:'Burkina Faso',aliases:['burkina faso'],capital:'Ouagadougou',continent:'Africa',currency:'West African CFA franc',language:'French'},
			burundi:{name:'Burundi',display:'Burundi',aliases:['burundi'],capital:'Gitega',continent:'Africa',currency:'Burundian franc',language:'Kirundi'},
			caboverde:{name:'Cabo Verde',display:'Cape Verde / Cabo Verde',aliases:['cabo verde','cape verde'],capital:'Praia',continent:'Africa',currency:'Cape Verdean escudo',language:'Portuguese'},
			cameroon:{name:'Cameroon',display:'Kamerun',aliases:['cameroon','kamerun'],capital:'Yaounde',continent:'Africa',currency:'Central African CFA franc',language:'French'},
			car:{name:'Central African Republic',display:'Orta Afrika Cumhuriyeti',aliases:['central african republic','orta afrika cumhuriyeti'],capital:'Bangui',continent:'Africa',currency:'Central African CFA franc',language:'French'},
			chad:{name:'Chad',display:'Çad',aliases:['chad','çad','cad'],capital:"N'Djamena",continent:'Africa',currency:'Central African CFA franc',language:'French'},
			comoros:{name:'Comoros',display:'Komorlar',aliases:['comoros','komorlar'],capital:'Moroni',continent:'Africa',currency:'Comorian franc',language:'Arabic'},
			drcongo:{name:'Democratic Republic of the Congo',display:'Kongo Demokratik Cumhuriyeti',aliases:['democratic republic of the congo','dr congo','congo kinshasa','kongo demokratik cumhuriyeti'],capital:'Kinshasa',continent:'Africa',currency:'Congolese franc',language:'French'},
			congorep:{name:'Republic of the Congo',display:'Kongo Cumhuriyeti',aliases:['republic of the congo','congo brazzaville','kongo cumhuriyeti'],capital:'Brazzaville',continent:'Africa',currency:'Central African CFA franc',language:'French'},
			djibouti:{name:'Djibouti',display:'Cibuti',aliases:['djibouti','cibuti'],capital:'Djibouti',continent:'Africa',currency:'Djiboutian franc',language:'Arabic'},
			egypt:{name:'Egypt',display:'Mısır',aliases:['egypt','misir','mısır'],capital:'Cairo',continent:'Africa',currency:'Egyptian pound',language:'Arabic'},
			equatorialguinea:{name:'Equatorial Guinea',display:'Ekvator Ginesi',aliases:['equatorial guinea','ekvator ginesi'],capital:'Malabo',continent:'Africa',currency:'Central African CFA franc',language:'Spanish'},
			eritrea:{name:'Eritrea',display:'Eritre',aliases:['eritrea','eritre'],capital:'Asmara',continent:'Africa',currency:'nakfa',language:'Tigrinya'},
			eswatini:{name:'Eswatini',display:'Esvatini',aliases:['eswatini','swaziland','esvatini'],capital:'Mbabane',continent:'Africa',currency:'lilangeni',language:'Swazi'},
			ethiopia:{name:'Ethiopia',display:'Etiyopya',aliases:['ethiopia','etiyopya'],capital:'Addis Ababa',continent:'Africa',currency:'birr',language:'Amharic'},
			gabon:{name:'Gabon',display:'Gabon',aliases:['gabon'],capital:'Libreville',continent:'Africa',currency:'Central African CFA franc',language:'French'},
			gambia:{name:'Gambia',display:'Gambiya',aliases:['gambia','gambiya'],capital:'Banjul',continent:'Africa',currency:'dalasi',language:'English'},
			ghana:{name:'Ghana',display:'Gana',aliases:['ghana','gana'],capital:'Accra',continent:'Africa',currency:'cedi',language:'English'},
			guinea:{name:'Guinea',display:'Gine',aliases:['guinea','gine'],capital:'Conakry',continent:'Africa',currency:'Guinean franc',language:'French'},
			guineabissau:{name:'Guinea-Bissau',display:'Gine-Bissau',aliases:['guinea-bissau','gine-bissau'],capital:'Bissau',continent:'Africa',currency:'West African CFA franc',language:'Portuguese'},
			ivorycoast:{name:'Ivory Coast',display:'Fildişi Sahili',aliases:['ivory coast',"cote d'ivoire",'côte d’ivoire','fildişi sahili','fildisi sahili'],capital:'Yamoussoukro',continent:'Africa',currency:'West African CFA franc',language:'French'},
			kenya:{name:'Kenya',display:'Kenya',aliases:['kenya'],capital:'Nairobi',continent:'Africa',currency:'Kenyan shilling',language:'Swahili'},
			lesotho:{name:'Lesotho',display:'Lesotho',aliases:['lesotho'],capital:'Maseru',continent:'Africa',currency:'loti',language:'English'},
			liberia:{name:'Liberia',display:'Liberya',aliases:['liberia','liberya'],capital:'Monrovia',continent:'Africa',currency:'Liberian dollar',language:'English'},
			libya:{name:'Libya',display:'Libya',aliases:['libya'],capital:'Tripoli',continent:'Africa',currency:'Libyan dinar',language:'Arabic'},
			madagascar:{name:'Madagascar',display:'Madagaskar',aliases:['madagascar','madagaskar'],capital:'Antananarivo',continent:'Africa',currency:'ariary',language:'Malagasy'},
			malawi:{name:'Malawi',display:'Malavi',aliases:['malawi','malavi'],capital:'Lilongwe',continent:'Africa',currency:'kwacha',language:'English'},
			mali:{name:'Mali',display:'Mali',aliases:['mali'],capital:'Bamako',continent:'Africa',currency:'West African CFA franc',language:'French'},
			mauritania:{name:'Mauritania',display:'Moritanya',aliases:['mauritania','moritanya'],capital:'Nouakchott',continent:'Africa',currency:'ouguiya',language:'Arabic'},
			mauritius:{name:'Mauritius',display:'Mauritius',aliases:['mauritius'],capital:'Port Louis',continent:'Africa',currency:'Mauritian rupee',language:'English'},
			morocco:{name:'Morocco',display:'Fas',aliases:['morocco','fas'],capital:'Rabat',continent:'Africa',currency:'Moroccan dirham',language:'Arabic'},
			mozambique:{name:'Mozambique',display:'Mozambik',aliases:['mozambique','mozambik'],capital:'Maputo',continent:'Africa',currency:'metical',language:'Portuguese'},
			namibia:{name:'Namibia',display:'Namibya',aliases:['namibia','namibya'],capital:'Windhoek',continent:'Africa',currency:'Namibian dollar',language:'English'},
			niger:{name:'Niger',display:'Nijer',aliases:['niger','nijer'],capital:'Niamey',continent:'Africa',currency:'West African CFA franc',language:'French'},
			nigeria:{name:'Nigeria',display:'Nijerya',aliases:['nigeria','nijerya'],capital:'Abuja',continent:'Africa',currency:'naira',language:'English'},
			rwanda:{name:'Rwanda',display:'Ruanda',aliases:['rwanda','ruanda'],capital:'Kigali',continent:'Africa',currency:'Rwandan franc',language:'Kinyarwanda'},
			saotome:{name:'Sao Tome and Principe',display:'Sao Tome ve Principe',aliases:['sao tome and principe','são tomé and príncipe','sao tome ve principe'],capital:'Sao Tome',continent:'Africa',currency:'dobra',language:'Portuguese'},
			senegal:{name:'Senegal',display:'Senegal',aliases:['senegal'],capital:'Dakar',continent:'Africa',currency:'West African CFA franc',language:'French'},
			seychelles:{name:'Seychelles',display:'Seyşeller',aliases:['seychelles','seyseller','seyşeller'],capital:'Victoria',continent:'Africa',currency:'Seychellois rupee',language:'English'},
			sierraleone:{name:'Sierra Leone',display:'Sierra Leone',aliases:['sierra leone'],capital:'Freetown',continent:'Africa',currency:'leone',language:'English'},
			somalia:{name:'Somalia',display:'Somali',aliases:['somalia','somali'],capital:'Mogadishu',continent:'Africa',currency:'Somali shilling',language:'Somali'},
			southafrica:{name:'South Africa',display:'Güney Afrika',aliases:['south africa','guney afrika','güney afrika'],capital:'Pretoria',continent:'Africa',currency:'rand',language:'English'},
			southsudan:{name:'South Sudan',display:'Güney Sudan',aliases:['south sudan','guney sudan','güney sudan'],capital:'Juba',continent:'Africa',currency:'South Sudanese pound',language:'English'},
			sudan:{name:'Sudan',display:'Sudan',aliases:['sudan'],capital:'Khartoum',continent:'Africa',currency:'Sudanese pound',language:'Arabic'},
			tanzania:{name:'Tanzania',display:'Tanzanya',aliases:['tanzania','tanzanya'],capital:'Dodoma',continent:'Africa',currency:'Tanzanian shilling',language:'Swahili'},
			togo:{name:'Togo',display:'Togo',aliases:['togo'],capital:'Lome',continent:'Africa',currency:'West African CFA franc',language:'French'},
			tunisia:{name:'Tunisia',display:'Tunus',aliases:['tunisia','tunus'],capital:'Tunis',continent:'Africa',currency:'Tunisian dinar',language:'Arabic'},
			uganda:{name:'Uganda',display:'Uganda',aliases:['uganda'],capital:'Kampala',continent:'Africa',currency:'Ugandan shilling',language:'English'},
			zambia:{name:'Zambia',display:'Zambiya',aliases:['zambia','zambiya'],capital:'Lusaka',continent:'Africa',currency:'Zambian kwacha',language:'English'},
			zimbabwe:{name:'Zimbabwe',display:'Zimbabve',aliases:['zimbabwe','zimbabve'],capital:'Harare',continent:'Africa',currency:'Zimbabwe Gold',language:'English'}
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

		function unique(arr) {
			return arr.filter(function (v, i) {
				return arr.indexOf(v) === i;
			});
		}

		function findCountryByInput(text) {
			const n = normalize(text);
			const all = Object.values(countries);
			for (let i = 0; i < all.length; i++) {
				const c = all[i];
				for (let j = 0; j < c.aliases.length; j++) {
					if (normalize(c.aliases[j]) === n) {
						return c;
					}
				}
			}
			return null;
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
				if (v && v !== currentCountry[key] && vals.indexOf(v) === -1) {
					vals.push(v);
				}
			}
			return vals;
		}

		function pickOtherCountryNames(currentCountry, count, useDisplay) {
			const out = [];
			const pool = shuffle(otherCountries(currentCountry.name));
			for (let i = 0; i < pool.length && out.length < count; i++) {
				out.push(useDisplay ? pool[i].display : pool[i].name);
			}
			return out;
		}

		function makeQuestion(text, correct, wrongs) {
			const options = shuffle(unique([correct].concat(wrongs)).slice(0, 4));
			return {
				text: text,
				correct: correct,
				options: options
			};
		}

		function buildCountryQuestionPool(country) {
			const pool = [];

			if (country.capital) {
				pool.push(makeQuestion(country.display + ' ülkesinin başkenti hangisidir?', country.capital, pickOtherValues(country, 'capital', 3)));
				pool.push(makeQuestion('What is the capital of ' + country.name + '?', country.capital, pickOtherValues(country, 'capital', 3)));
				pool.push(makeQuestion(country.capital + ' hangi ülkenin başkentidir?', country.display, pickOtherCountryNames(country, 3, true)));
				pool.push(makeQuestion('Which country has the capital ' + country.capital + '?', country.name, pickOtherCountryNames(country, 3, false)));
			}

			if (country.continent) {
				pool.push(makeQuestion(country.display + ' hangi kıtadadır?', country.continent, pickOtherValues(country, 'continent', 3)));
				pool.push(makeQuestion(country.name + ' is in which continent?', country.continent, pickOtherValues(country, 'continent', 3)));
			}

			if (country.currency) {
				pool.push(makeQuestion(country.display + ' para birimi nedir?', country.currency, pickOtherValues(country, 'currency', 3)));
				pool.push(makeQuestion('What is the currency of ' + country.name + '?', country.currency, pickOtherValues(country, 'currency', 3)));
				pool.push(makeQuestion(country.currency + ' hangi ülkenin para birimidir?', country.display, pickOtherCountryNames(country, 3, true)));
				pool.push(makeQuestion('Which country uses ' + country.currency + '?', country.name, pickOtherCountryNames(country, 3, false)));
			}

			if (country.language) {
				pool.push(makeQuestion(country.display + ' ülkesinde yaygın dil hangisidir?', country.language, pickOtherValues(country, 'language', 3)));
				pool.push(makeQuestion('What language is mainly spoken in ' + country.name + '?', country.language, pickOtherValues(country, 'language', 3)));
				pool.push(makeQuestion(country.language + ' dili hangi ülkeyle ilişkilidir?', country.display, pickOtherCountryNames(country, 3, true)));
				pool.push(makeQuestion('Which country is linked with the ' + country.language + ' language?', country.name, pickOtherCountryNames(country, 3, false)));
			}

			pool.push(makeQuestion(country.display + ' hangi kıtaya daha çok aittir?', country.continent || 'Africa', ['Europe', 'Asia', 'South America']));
			pool.push(makeQuestion('Choose the correct country name.', country.name, pickOtherCountryNames(country, 3, false)));
			pool.push(makeQuestion('Doğru ülke adını seç.', country.display, pickOtherCountryNames(country, 3, true)));

			return pool;
		}

		function build100Questions(country) {
			const basePool = buildCountryQuestionPool(country);
			const out = [];
			let rounds = 0;

			while (out.length < 100 && rounds < 40) {
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
				setMessage('Bu ülke tanımlı değil. Şimdi Afrika ülkeleri de eklendi.');
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
							<input type="text" class="zo-u100-input" placeholder="Örnek: Türkiye, Turkey, Cezayir, Algeria, Kenya, Fas, Morocco">
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

						<h3>Şimdi Eklenenler</h3>
						<ul>
							<li>Tüm Afrika ülkeleri eklendi.</li>
							<li>Örnekler: Cezayir, Fas, Tunus, Libya, Mısır, Kenya, Nijerya, Güney Afrika, Tanzanya, Uganda, Senegal, Sudan.</li>
						</ul>

						<p>Sonraki sürümde Asya ve Avrupa ülkelerini daha da genişletebilirim.</p>
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
	'description'     => 'Ülke adını yazınca o ülke hakkında 100 soru açan coinli quiz oyunu. Afrika ülkeleri eklendi.',
	'render_callback' => 'zo_ulke_100_soru_render',
	'inline_style'    => $inline_style,
	'inline_script'   => $inline_script,
);