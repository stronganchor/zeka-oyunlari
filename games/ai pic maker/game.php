<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root--ai-chat-kids {
	max-width: 760px;
	margin: 0 auto;
	padding: 16px;
	font-family: Arial, sans-serif;
	color: #1f2937;
}

.zo-game-root--ai-chat-kids * {
	box-sizing: border-box;
}

.zo-ai-shell {
	background: #ffffff;
	border: 3px solid #1f2937;
	border-radius: 18px;
	overflow: hidden;
	box-shadow: 0 10px 24px rgba(0, 0, 0, 0.08);
}

.zo-ai-topbar {
	background: linear-gradient(135deg, #60a5fa, #34d399);
	color: #ffffff;
	padding: 14px 16px;
}

.zo-ai-title {
	margin: 0;
	font-size: 24px;
	font-weight: 700;
}

.zo-ai-subtitle {
	margin: 6px 0 0;
	font-size: 14px;
	line-height: 1.5;
}

.zo-ai-main {
	display: grid;
	grid-template-columns: 1.1fr 0.9fr;
	gap: 16px;
	padding: 16px;
	background: #f8fafc;
}

.zo-ai-panel,
.zo-ai-image-panel {
	background: #ffffff;
	border: 2px solid #d1d5db;
	border-radius: 16px;
	padding: 14px;
}

.zo-ai-section-title {
	margin: 0 0 10px;
	font-size: 18px;
	font-weight: 700;
}

.zo-ai-chat {
	height: 360px;
	overflow-y: auto;
	background: #eef6ff;
	border: 2px solid #bfdbfe;
	border-radius: 14px;
	padding: 12px;
}

.zo-ai-msg {
	margin-bottom: 10px;
	display: flex;
}

.zo-ai-msg--user {
	justify-content: flex-end;
}

.zo-ai-msg--bot {
	justify-content: flex-start;
}

.zo-ai-bubble {
	max-width: 85%;
	padding: 10px 12px;
	border-radius: 14px;
	line-height: 1.45;
	font-size: 14px;
	word-break: break-word;
}

.zo-ai-msg--user .zo-ai-bubble {
	background: #2563eb;
	color: #ffffff;
	border-bottom-right-radius: 4px;
}

.zo-ai-msg--bot .zo-ai-bubble {
	background: #ffffff;
	color: #111827;
	border: 2px solid #cbd5e1;
	border-bottom-left-radius: 4px;
}

.zo-ai-controls {
	margin-top: 12px;
	display: grid;
	gap: 10px;
}

.zo-ai-row {
	display: flex;
	gap: 8px;
	flex-wrap: wrap;
}

.zo-ai-input,
.zo-ai-select {
	width: 100%;
	padding: 12px;
	border: 2px solid #cbd5e1;
	border-radius: 12px;
	font-size: 14px;
	background: #ffffff;
	color: #111827;
}

.zo-ai-input:focus,
.zo-ai-select:focus {
	outline: none;
	border-color: #60a5fa;
}

.zo-ai-btn {
	border: 0;
	border-radius: 12px;
	padding: 11px 14px;
	font-size: 14px;
	font-weight: 700;
	cursor: pointer;
	transition: transform 0.08s ease, opacity 0.2s ease;
}

.zo-ai-btn:hover {
	opacity: 0.95;
}

.zo-ai-btn:active {
	transform: scale(0.98);
}

.zo-ai-btn--primary {
	background: #2563eb;
	color: #ffffff;
	flex: 1;
}

.zo-ai-btn--secondary {
	background: #10b981;
	color: #ffffff;
	flex: 1;
}

.zo-ai-btn--ghost {
	background: #e5e7eb;
	color: #111827;
}

.zo-ai-mini-buttons {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
}

.zo-ai-chip {
	background: #dbeafe;
	color: #1d4ed8;
	border: 2px solid #93c5fd;
	padding: 8px 10px;
	border-radius: 999px;
	font-size: 12px;
	font-weight: 700;
	cursor: pointer;
}

.zo-ai-status {
	margin-top: 8px;
	font-size: 13px;
	font-weight: 700;
	color: #0f766e;
	min-height: 18px;
}

.zo-ai-image-wrap {
	border: 2px dashed #94a3b8;
	border-radius: 16px;
	background: #f8fafc;
	min-height: 360px;
	display: flex;
	align-items: center;
	justify-content: center;
	padding: 12px;
	overflow: hidden;
}

.zo-ai-image-output {
	width: 100%;
}

.zo-ai-image-output svg {
	width: 100%;
	height: auto;
	display: block;
	border-radius: 14px;
	background: #ffffff;
}

.zo-ai-help {
	margin-top: 12px;
	background: #fef3c7;
	border: 2px solid #fcd34d;
	border-radius: 14px;
	padding: 12px;
	font-size: 13px;
	line-height: 1.5;
}

.zo-ai-scoreboard {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 8px;
	margin-top: 12px;
}

.zo-ai-stat {
	background: #eff6ff;
	border: 2px solid #bfdbfe;
	border-radius: 12px;
	padding: 10px;
	text-align: center;
}

.zo-ai-stat-num {
	font-size: 22px;
	font-weight: 700;
	color: #1d4ed8;
}

.zo-ai-stat-label {
	font-size: 12px;
	color: #475569;
	margin-top: 4px;
}

@media (max-width: 760px) {
	.zo-ai-main {
		grid-template-columns: 1fr;
	}

	.zo-ai-chat,
	.zo-ai-image-wrap {
		min-height: 300px;
		height: auto;
	}

	.zo-ai-scoreboard {
		grid-template-columns: 1fr;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--ai-chat-kids');

	function escapeHtml(str) {
		return String(str).replace(/[&<>"']/g, function (m) {
			return {
				'&': '&amp;',
				'<': '&lt;',
				'>': '&gt;',
				'"': '&quot;',
				"'": '&#39;'
			}[m];
		});
	}

	function pick(arr) {
		return arr[Math.floor(Math.random() * arr.length)];
	}

	function containsAny(text, arr) {
		return arr.some(function (item) {
			return text.indexOf(item) !== -1;
		});
	}

	function getBotReply(message, lang) {
		const text = message.toLowerCase().trim();

		const en = {
			hello: [
				'Hello. I know English and Turkish. Ask me something or generate a picture.',
				'Hi. I can chat in English and Türkçe. You can also ask for a picture.'
			],
			howareyou: [
				'I am a browser game bot. I am ready.',
				'I am ready to chat and draw simple pictures.'
			],
			name: [
				'My name is Mini AI.',
				'I am Mini AI, your picture chatbot.'
			],
			colors: [
				'Some easy colors are red, blue, green, yellow, black, and white.',
				'I know many colors. Try: red house, blue car, green tree.'
			],
			animals: [
				'Animals in English: cat, dog, bird, fish, horse.',
				'In Turkish: kedi, köpek, kuş, balık, at.'
			],
			thanks: [
				'You are welcome.',
				'Glad to help.'
			],
			fallback: [
				'I understood some of that. Try a simple request like "draw a cat" or "Türkçe konuş".',
				'Try short prompts. Example: "red house", "happy sun", "mavi araba".'
			]
		};

		const tr = {
			hello: [
				'Merhaba. İngilizce ve Türkçe biliyorum. Bana soru sorabilir ya da resim yaptırabilirsin.',
				'Selam. İngilizce ve Türkçe konuşabilirim. İstersen resim de oluştururum.'
			],
			howareyou: [
				'Ben tarayıcı içinde çalışan bir oyun botuyum. Hazırım.',
				'Konuşmaya ve basit resimler çizmeye hazırım.'
			],
			name: [
				'Benim adım Mini AI.',
				'Ben resim yapan sohbet botu Mini AI\'yım.'
			],
			colors: [
				'Kolay renkler: kırmızı, mavi, yeşil, sarı, siyah ve beyaz.',
				'Bir renk söyle. Mesela: kırmızı ev, mavi araba, yeşil ağaç.'
			],
			animals: [
				'Hayvanlar: kedi, köpek, kuş, balık, at.',
				'İngilizce karşılıkları da biliyorum: cat, dog, bird, fish, horse.'
			],
			thanks: [
				'Rica ederim.',
				'Yardımcı olmaya hazırım.'
			],
			fallback: [
				'Bir kısmını anladım. "kedi çiz" ya da "draw a house" gibi kısa isteklere daha iyi cevap veririm.',
				'Kısa yazmayı dene. Mesela: "mavi araba", "güneş çiz", "draw a tree".'
			]
		};

		const dict = lang === 'tr' ? tr : en;

		if (containsAny(text, ['merhaba', 'selam', 'hello', 'hi', 'hey'])) {
			return pick(dict.hello);
		}
		if (containsAny(text, ['nasılsın', 'nasilsin', 'how are you'])) {
			return pick(dict.howareyou);
		}
		if (containsAny(text, ['adın ne', 'adin ne', 'what is your name', 'your name'])) {
			return pick(dict.name);
		}
		if (containsAny(text, ['renk', 'colors', 'colour', 'color'])) {
			return pick(dict.colors);
		}
		if (containsAny(text, ['hayvan', 'animal', 'animals'])) {
			return pick(dict.animals);
		}
		if (containsAny(text, ['teşekkür', 'tesekkur', 'thanks', 'thank you'])) {
			return pick(dict.thanks);
		}

		if (lang === 'tr') {
			if (containsAny(text, ['english', 'ingilizce'])) {
				return 'İngilizce de biliyorum. Mesela "cat = kedi", "house = ev", "sun = güneş" diyebilirim.';
			}
			if (containsAny(text, ['türkçe', 'turkce', 'turkish'])) {
				return 'Türkçe biliyorum. Basit sorular sorabilir veya resim isteyebilirsin.';
			}
		} else {
			if (containsAny(text, ['turkish', 'türkçe', 'turkce'])) {
				return 'I know some Turkish too. Example: cat = kedi, house = ev, sun = güneş.';
			}
			if (containsAny(text, ['english', 'ingilizce'])) {
				return 'Yes. I can chat in English.';
			}
		}

		return pick(dict.fallback);
	}

	function getColorFromPrompt(text) {
		const map = [
			{ keys: ['red', 'kırmızı', 'kirmizi'], value: '#ef4444' },
			{ keys: ['blue', 'mavi'], value: '#3b82f6' },
			{ keys: ['green', 'yeşil', 'yesil'], value: '#22c55e' },
			{ keys: ['yellow', 'sarı', 'sari'], value: '#facc15' },
			{ keys: ['purple', 'mor'], value: '#a855f7' },
			{ keys: ['orange', 'turuncu'], value: '#fb923c' },
			{ keys: ['pink', 'pembe'], value: '#f472b6' },
			{ keys: ['black', 'siyah'], value: '#111827' },
			{ keys: ['white', 'beyaz'], value: '#f8fafc' }
		];

		for (let i = 0; i < map.length; i++) {
			if (containsAny(text, map[i].keys)) {
				return map[i].value;
			}
		}

		return '#60a5fa';
	}

	function getSceneType(text) {
		if (containsAny(text, ['cat', 'kedi'])) {
			return 'cat';
		}
		if (containsAny(text, ['dog', 'köpek', 'kopek'])) {
			return 'dog';
		}
		if (containsAny(text, ['house', 'ev'])) {
			return 'house';
		}
		if (containsAny(text, ['car', 'araba'])) {
			return 'car';
		}
		if (containsAny(text, ['tree', 'ağaç', 'agac'])) {
			return 'tree';
		}
		if (containsAny(text, ['sun', 'güneş', 'gunes'])) {
			return 'sun';
		}
		if (containsAny(text, ['robot'])) {
			return 'robot';
		}
		if (containsAny(text, ['flower', 'çiçek', 'cicek'])) {
			return 'flower';
		}
		if (containsAny(text, ['fish', 'balık', 'balik'])) {
			return 'fish';
		}
		return 'mixed';
	}

	function buildSvg(promptText) {
		const text = promptText.toLowerCase();
		const mainColor = getColorFromPrompt(text);
		const scene = getSceneType(text);

		const bgTop = '#dbeafe';
		const bgBottom = '#fef9c3';
		let body = '';

		if (scene === 'cat') {
			body = ''
				+ '<circle cx="250" cy="120" r="55" fill="' + mainColor + '" />'
				+ '<polygon points="210,80 225,35 245,78" fill="' + mainColor + '" />'
				+ '<polygon points="255,78 275,35 290,80" fill="' + mainColor + '" />'
				+ '<circle cx="230" cy="115" r="6" fill="#111827" />'
				+ '<circle cx="270" cy="115" r="6" fill="#111827" />'
				+ '<polygon points="250,130 240,142 260,142" fill="#fca5a5" />'
				+ '<line x1="205" y1="133" x2="165" y2="126" stroke="#111827" stroke-width="4" />'
				+ '<line x1="205" y1="143" x2="165" y2="143" stroke="#111827" stroke-width="4" />'
				+ '<line x1="295" y1="133" x2="335" y2="126" stroke="#111827" stroke-width="4" />'
				+ '<line x1="295" y1="143" x2="335" y2="143" stroke="#111827" stroke-width="4" />'
				+ '<ellipse cx="250" cy="245" rx="82" ry="95" fill="' + mainColor + '" />'
				+ '<circle cx="188" cy="307" r="22" fill="' + mainColor + '" />'
				+ '<circle cx="312" cy="307" r="22" fill="' + mainColor + '" />'
				+ '<path d="M322 238 Q380 210 360 150" stroke="' + mainColor + '" stroke-width="18" fill="none" stroke-linecap="round" />';
		} else if (scene === 'dog') {
			body = ''
				+ '<circle cx="250" cy="120" r="54" fill="' + mainColor + '" />'
				+ '<ellipse cx="205" cy="98" rx="24" ry="42" fill="' + mainColor + '" transform="rotate(-25 205 98)" />'
				+ '<ellipse cx="295" cy="98" rx="24" ry="42" fill="' + mainColor + '" transform="rotate(25 295 98)" />'
				+ '<circle cx="230" cy="115" r="6" fill="#111827" />'
				+ '<circle cx="270" cy="115" r="6" fill="#111827" />'
				+ '<ellipse cx="250" cy="140" rx="16" ry="12" fill="#111827" />'
				+ '<path d="M235 153 Q250 170 265 153" stroke="#111827" stroke-width="4" fill="none" stroke-linecap="round" />'
				+ '<ellipse cx="250" cy="250" rx="92" ry="85" fill="' + mainColor + '" />'
				+ '<circle cx="185" cy="308" r="22" fill="' + mainColor + '" />'
				+ '<circle cx="315" cy="308" r="22" fill="' + mainColor + '" />'
				+ '<path d="M336 246 Q392 220 372 176" stroke="' + mainColor + '" stroke-width="18" fill="none" stroke-linecap="round" />';
		} else if (scene === 'house') {
			body = ''
				+ '<rect x="150" y="145" width="200" height="150" rx="8" fill="' + mainColor + '" />'
				+ '<polygon points="130,155 250,60 370,155" fill="#b45309" />'
				+ '<rect x="227" y="215" width="46" height="80" fill="#78350f" />'
				+ '<rect x="175" y="180" width="38" height="38" fill="#ffffff" />'
				+ '<rect x="287" y="180" width="38" height="38" fill="#ffffff" />'
				+ '<rect x="110" y="295" width="280" height="20" fill="#84cc16" />'
				+ '<circle cx="405" cy="78" r="34" fill="#facc15" />';
		} else if (scene === 'car') {
			body = ''
				+ '<rect x="120" y="195" width="260" height="72" rx="20" fill="' + mainColor + '" />'
				+ '<path d="M170 195 L225 145 H308 Q332 145 345 195 Z" fill="' + mainColor + '" />'
				+ '<rect x="232" y="155" width="66" height="34" rx="8" fill="#dbeafe" />'
				+ '<circle cx="180" cy="275" r="34" fill="#111827" />'
				+ '<circle cx="320" cy="275" r="34" fill="#111827" />'
				+ '<circle cx="180" cy="275" r="16" fill="#cbd5e1" />'
				+ '<circle cx="320" cy="275" r="16" fill="#cbd5e1" />'
				+ '<rect x="92" y="267" width="316" height="10" fill="#94a3b8" />';
		} else if (scene === 'tree') {
			body = ''
				+ '<rect x="225" y="190" width="50" height="120" rx="8" fill="#92400e" />'
				+ '<circle cx="250" cy="120" r="68" fill="' + mainColor + '" />'
				+ '<circle cx="195" cy="145" r="52" fill="' + mainColor + '" opacity="0.95" />'
				+ '<circle cx="305" cy="145" r="52" fill="' + mainColor + '" opacity="0.95" />'
				+ '<rect x="80" y="310" width="340" height="18" fill="#65a30d" />';
		} else if (scene === 'sun') {
			body = ''
				+ '<circle cx="250" cy="155" r="64" fill="' + mainColor + '" />'
				+ '<g stroke="' + mainColor + '" stroke-width="10" stroke-linecap="round">'
				+ '<line x1="250" y1="42" x2="250" y2="10" />'
				+ '<line x1="250" y1="300" x2="250" y2="332" />'
				+ '<line x1="137" y1="155" x2="105" y2="155" />'
				+ '<line x1="395" y1="155" x2="363" y2="155" />'
				+ '<line x1="170" y1="75" x2="146" y2="51" />'
				+ '<line x1="330" y1="235" x2="354" y2="259" />'
				+ '<line x1="170" y1="235" x2="146" y2="259" />'
				+ '<line x1="330" y1="75" x2="354" y2="51" />'
				+ '</g>'
				+ '<circle cx="225" cy="145" r="6" fill="#111827" />'
				+ '<circle cx="275" cy="145" r="6" fill="#111827" />'
				+ '<path d="M220 180 Q250 205 280 180" stroke="#111827" stroke-width="5" fill="none" stroke-linecap="round" />';
		} else if (scene === 'robot') {
			body = ''
				+ '<rect x="180" y="70" width="140" height="110" rx="18" fill="' + mainColor + '" />'
				+ '<rect x="195" y="190" width="110" height="95" rx="16" fill="' + mainColor + '" />'
				+ '<circle cx="220" cy="118" r="11" fill="#111827" />'
				+ '<circle cx="280" cy="118" r="11" fill="#111827" />'
				+ '<rect x="218" y="142" width="64" height="12" rx="6" fill="#111827" />'
				+ '<line x1="250" y1="70" x2="250" y2="38" stroke="#111827" stroke-width="8" />'
				+ '<circle cx="250" cy="28" r="12" fill="#f43f5e" />'
				+ '<line x1="195" y1="220" x2="145" y2="195" stroke="' + mainColor + '" stroke-width="16" stroke-linecap="round" />'
				+ '<line x1="305" y1="220" x2="355" y2="195" stroke="' + mainColor + '" stroke-width="16" stroke-linecap="round" />'
				+ '<line x1="220" y1="285" x2="200" y2="330" stroke="' + mainColor + '" stroke-width="16" stroke-linecap="round" />'
				+ '<line x1="280" y1="285" x2="300" y2="330" stroke="' + mainColor + '" stroke-width="16" stroke-linecap="round" />';
		} else if (scene === 'flower') {
			body = ''
				+ '<rect x="243" y="145" width="14" height="150" fill="#16a34a" />'
				+ '<ellipse cx="250" cy="120" rx="28" ry="58" fill="' + mainColor + '" transform="rotate(0 250 120)" />'
				+ '<ellipse cx="250" cy="120" rx="28" ry="58" fill="' + mainColor + '" transform="rotate(45 250 120)" />'
				+ '<ellipse cx="250" cy="120" rx="28" ry="58" fill="' + mainColor + '" transform="rotate(90 250 120)" />'
				+ '<ellipse cx="250" cy="120" rx="28" ry="58" fill="' + mainColor + '" transform="rotate(135 250 120)" />'
				+ '<circle cx="250" cy="120" r="28" fill="#facc15" />'
				+ '<ellipse cx="220" cy="220" rx="18" ry="34" fill="#22c55e" transform="rotate(-35 220 220)" />'
				+ '<ellipse cx="280" cy="235" rx="18" ry="34" fill="#22c55e" transform="rotate(35 280 235)" />'
				+ '<rect x="80" y="310" width="340" height="18" fill="#65a30d" />';
		} else if (scene === 'fish') {
			body = ''
				+ '<ellipse cx="235" cy="180" rx="95" ry="55" fill="' + mainColor + '" />'
				+ '<polygon points="320,180 395,130 395,230" fill="' + mainColor + '" />'
				+ '<circle cx="195" cy="167" r="7" fill="#111827" />'
				+ '<path d="M150 180 Q175 195 150 210" stroke="#111827" stroke-width="4" fill="none" stroke-linecap="round" />'
				+ '<path d="M240 124 Q270 92 298 124" fill="' + mainColor + '" />'
				+ '<circle cx="98" cy="75" r="14" fill="#bfdbfe" />'
				+ '<circle cx="128" cy="115" r="10" fill="#bfdbfe" />'
				+ '<circle cx="112" cy="150" r="8" fill="#bfdbfe" />';
		} else {
			body = ''
				+ '<circle cx="110" cy="78" r="36" fill="#facc15" />'
				+ '<rect x="130" y="250" width="240" height="60" rx="14" fill="' + mainColor + '" />'
				+ '<polygon points="150,250 210,200 285,200 350,250" fill="#fb7185" />'
				+ '<rect x="242" y="278" width="30" height="32" fill="#78350f" />'
				+ '<circle cx="420" cy="122" r="28" fill="#22c55e" />'
				+ '<rect x="414" y="148" width="12" height="74" fill="#92400e" />'
				+ '<circle cx="80" cy="275" r="24" fill="#a855f7" />'
				+ '<rect x="74" y="299" width="12" height="32" fill="#16a34a" />';
		}

		return ''
			+ '<svg viewBox="0 0 500 340" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="' + escapeHtml(promptText) + '">'
			+ '<defs>'
			+ '<linearGradient id="skyGrad" x1="0" y1="0" x2="0" y2="1">'
			+ '<stop offset="0%" stop-color="' + bgTop + '" />'
			+ '<stop offset="100%" stop-color="' + bgBottom + '" />'
			+ '</linearGradient>'
			+ '</defs>'
			+ '<rect x="0" y="0" width="500" height="340" fill="url(#skyGrad)" />'
			+ body
			+ '</svg>';
	}

	games.forEach(function (game) {
		const chat = game.querySelector('.zo-ai-chat');
		const input = game.querySelector('.zo-ai-input');
		const langSelect = game.querySelector('.zo-ai-select');
		const sendBtn = game.querySelector('.zo-ai-send');
		const drawBtn = game.querySelector('.zo-ai-draw');
		const clearBtn = game.querySelector('.zo-ai-clear');
		const imageOutput = game.querySelector('.zo-ai-image-output');
		const status = game.querySelector('.zo-ai-status');
		const msgCountEl = game.querySelector('.zo-ai-msg-count');
		const picCountEl = game.querySelector('.zo-ai-pic-count');
		const scoreEl = game.querySelector('.zo-ai-score');
		const chips = game.querySelectorAll('.zo-ai-chip');

		let msgCount = 0;
		let picCount = 0;
		let score = 0;

		function updateStats() {
			msgCountEl.textContent = String(msgCount);
			picCountEl.textContent = String(picCount);
			scoreEl.textContent = String(score);
		}

		function scrollChat() {
			chat.scrollTop = chat.scrollHeight;
		}

		function addMessage(text, type) {
			const row = document.createElement('div');
			row.className = 'zo-ai-msg zo-ai-msg--' + type;

			const bubble = document.createElement('div');
			bubble.className = 'zo-ai-bubble';
			bubble.innerHTML = escapeHtml(text).replace(/\n/g, '<br>');

			row.appendChild(bubble);
			chat.appendChild(row);
			scrollChat();

			msgCount += 1;
			if (type === 'bot') {
				score += 1;
			}
			updateStats();
		}

		function sendChat() {
			const text = input.value.trim();
			const lang = langSelect.value;

			if (!text) {
				status.textContent = lang === 'tr' ? 'Önce bir şey yaz.' : 'Type something first.';
				return;
			}

			addMessage(text, 'user');
			const reply = getBotReply(text, lang);

			window.setTimeout(function () {
				addMessage(reply, 'bot');
				status.textContent = lang === 'tr' ? 'Cevap verildi.' : 'Replied.';
			}, 220);

			input.value = '';
			input.focus();
		}

		function drawPicture() {
			const text = input.value.trim();
			const lang = langSelect.value;

			if (!text) {
				status.textContent = lang === 'tr' ? 'Resim için kısa bir istek yaz.' : 'Type a short picture prompt.';
				return;
			}

			imageOutput.innerHTML = buildSvg(text);
			addMessage((lang === 'tr' ? 'Resim isteği: ' : 'Picture prompt: ') + text, 'user');

			window.setTimeout(function () {
				addMessage(
					lang === 'tr'
						? 'Basit resim hazır. Başka bir renk ya da nesne ile tekrar deneyebilirsin.'
						: 'Simple picture ready. Try another color or object.',
					'bot'
				);
				status.textContent = lang === 'tr' ? 'Resim oluşturuldu.' : 'Picture generated.';
			}, 220);

			picCount += 1;
			score += 2;
			updateStats();
			input.value = '';
			input.focus();
		}

		function clearAll() {
			const lang = langSelect.value;

			chat.innerHTML = '';
			imageOutput.innerHTML = '';
			msgCount = 0;
			picCount = 0;
			score = 0;
			updateStats();
			status.textContent = lang === 'tr' ? 'Temizlendi.' : 'Cleared.';

			addMessage(
				lang === 'tr'
					? 'Merhaba. Ben İngilizce ve Türkçe bilen mini bir sohbet ve resim botuyum.'
					: 'Hello. I am a mini chatbot that knows English and Turkish.',
				'bot'
			);
		}

		sendBtn.addEventListener('click', sendChat);
		drawBtn.addEventListener('click', drawPicture);
		clearBtn.addEventListener('click', clearAll);

		input.addEventListener('keydown', function (e) {
			if (e.key === 'Enter') {
				e.preventDefault();
				if (e.shiftKey) {
					drawPicture();
				} else {
					sendChat();
				}
			}
		});

		chips.forEach(function (chip) {
			chip.addEventListener('click', function () {
				input.value = chip.getAttribute('data-prompt') || '';
				input.focus();
			});
		});

		addMessage('Hello. I am a mini chatbot that knows English and Turkish.', 'bot');
		imageOutput.innerHTML = buildSvg('blue robot');
		updateStats();
	});
});
JS;

if (!function_exists('zo_game_ai_chat_kids_render')) {
	function zo_game_ai_chat_kids_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-ai-chat-kids-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--ai-chat-kids" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-ai-shell">
				<div class="zo-ai-topbar">
					<h2 class="zo-ai-title">Mini AI Chat & Picture Bot</h2>
					<p class="zo-ai-subtitle">Chat in English or Türkçe. Type a message, or type a simple picture idea like “blue cat” or “kırmızı ev”.</p>
				</div>

				<div class="zo-ai-main">
					<div class="zo-ai-panel">
						<h3 class="zo-ai-section-title">Chat</h3>

						<div class="zo-ai-chat" aria-live="polite"></div>

						<div class="zo-ai-controls">
							<select class="zo-ai-select" aria-label="Language">
								<option value="en">English</option>
								<option value="tr">Türkçe</option>
							</select>

							<input type="text" class="zo-ai-input" placeholder="Type a message or picture prompt..." />

							<div class="zo-ai-row">
								<button type="button" class="zo-ai-btn zo-ai-btn--primary zo-ai-send">Send Chat</button>
								<button type="button" class="zo-ai-btn zo-ai-btn--secondary zo-ai-draw">Generate Pic</button>
							</div>

							<div class="zo-ai-row">
								<button type="button" class="zo-ai-btn zo-ai-btn--ghost zo-ai-clear">Restart</button>
							</div>

							<div class="zo-ai-mini-buttons">
								<button type="button" class="zo-ai-chip" data-prompt="blue robot">blue robot</button>
								<button type="button" class="zo-ai-chip" data-prompt="kırmızı ev">kırmızı ev</button>
								<button type="button" class="zo-ai-chip" data-prompt="green tree">green tree</button>
								<button type="button" class="zo-ai-chip" data-prompt="mavi araba">mavi araba</button>
								<button type="button" class="zo-ai-chip" data-prompt="cat">cat</button>
								<button type="button" class="zo-ai-chip" data-prompt="çiçek">çiçek</button>
							</div>

							<div class="zo-ai-status"></div>
						</div>

						<div class="zo-ai-scoreboard">
							<div class="zo-ai-stat">
								<div class="zo-ai-stat-num zo-ai-msg-count">0</div>
								<div class="zo-ai-stat-label">Messages</div>
							</div>
							<div class="zo-ai-stat">
								<div class="zo-ai-stat-num zo-ai-pic-count">0</div>
								<div class="zo-ai-stat-label">Pictures</div>
							</div>
							<div class="zo-ai-stat">
								<div class="zo-ai-stat-num zo-ai-score">0</div>
								<div class="zo-ai-stat-label">AI Score</div>
							</div>
						</div>
					</div>

					<div class="zo-ai-image-panel">
						<h3 class="zo-ai-section-title">Picture Output</h3>
						<div class="zo-ai-image-wrap">
							<div class="zo-ai-image-output"></div>
						</div>

						<div class="zo-ai-help">
							Try easy prompts:<br>
							<strong>English:</strong> blue cat, red house, robot, flower, yellow sun<br>
							<strong>Türkçe:</strong> mavi araba, kırmızı ev, kedi, çiçek, sarı güneş
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'ai-chat-kids',
	'name'            => 'Mini AI Chat & Picture Bot',
	'author'          => 'Asker',
	'description'     => 'A kid-friendly bilingual chatbot game with simple browser-made pictures.',
	'render_callback' => 'zo_game_ai_chat_kids_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);