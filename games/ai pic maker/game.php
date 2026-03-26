<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root--ai-studio-pro {
	max-width: 1200px;
	margin: 0 auto;
	font-family: Arial, sans-serif;
	color: #e8eefc;
}

.zo-game-root--ai-studio-pro * {
	box-sizing: border-box;
}

.zo-asp-shell {
	background: linear-gradient(180deg, #0b1220 0%, #11192d 100%);
	border-radius: 22px;
	overflow: hidden;
	border: 1px solid rgba(255,255,255,0.10);
	box-shadow: 0 20px 55px rgba(0,0,0,0.30);
}

.zo-asp-topbar {
	padding: 18px 20px;
	background: linear-gradient(135deg, #2563eb 0%, #0891b2 45%, #10b981 100%);
	color: #ffffff;
}

.zo-asp-title {
	margin: 0;
	font-size: 28px;
	font-weight: 700;
	line-height: 1.1;
}

.zo-asp-subtitle {
	margin: 8px 0 0;
	font-size: 14px;
	line-height: 1.45;
	max-width: 960px;
}

.zo-asp-layout {
	display: grid;
	grid-template-columns: 390px 1fr;
	min-height: 760px;
}

.zo-asp-sidebar {
	padding: 16px;
	border-right: 1px solid rgba(255,255,255,0.08);
	background: rgba(255,255,255,0.02);
}

.zo-asp-main {
	padding: 16px;
}

.zo-asp-card {
	background: rgba(255,255,255,0.05);
	border: 1px solid rgba(255,255,255,0.10);
	border-radius: 18px;
	padding: 14px;
	margin-bottom: 14px;
}

.zo-asp-card:last-child {
	margin-bottom: 0;
}

.zo-asp-card-title {
	margin: 0 0 10px;
	font-size: 18px;
	font-weight: 700;
	color: #ffffff;
}

.zo-asp-label {
	display: block;
	margin: 0 0 6px;
	font-size: 12px;
	font-weight: 700;
	letter-spacing: 0.03em;
	text-transform: uppercase;
	color: #bfdbfe;
}

.zo-asp-input,
.zo-asp-select,
.zo-asp-textarea,
.zo-asp-file {
	width: 100%;
	padding: 11px 12px;
	border-radius: 12px;
	border: 1px solid rgba(255,255,255,0.14);
	background: rgba(255,255,255,0.08);
	color: #ffffff;
	font-size: 14px;
}

.zo-asp-select option {
	color: #111827;
}

.zo-asp-input::placeholder,
.zo-asp-textarea::placeholder {
	color: #c7d2e6;
}

.zo-asp-textarea {
	min-height: 96px;
	resize: vertical;
	line-height: 1.45;
}

.zo-asp-stack {
	display: grid;
	gap: 10px;
}

.zo-asp-row {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 10px;
}

.zo-asp-row-3 {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 10px;
}

.zo-asp-btn {
	border: 0;
	border-radius: 12px;
	padding: 12px 12px;
	font-size: 14px;
	font-weight: 700;
	color: #ffffff;
	cursor: pointer;
	transition: transform 0.08s ease, opacity 0.2s ease;
}

.zo-asp-btn:hover {
	opacity: 0.94;
}

.zo-asp-btn:active {
	transform: scale(0.98);
}

.zo-asp-btn--blue { background: linear-gradient(135deg, #2563eb, #1d4ed8); }
.zo-asp-btn--green { background: linear-gradient(135deg, #10b981, #059669); }
.zo-asp-btn--purple { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.zo-asp-btn--orange { background: linear-gradient(135deg, #f97316, #ea580c); }
.zo-asp-btn--pink { background: linear-gradient(135deg, #ec4899, #db2777); }
.zo-asp-btn--gray { background: linear-gradient(135deg, #475569, #334155); }
.zo-asp-btn--red { background: linear-gradient(135deg, #ef4444, #dc2626); }

.zo-asp-chat-log {
	height: 220px;
	overflow-y: auto;
	padding: 10px;
	border-radius: 14px;
	background: rgba(7, 12, 22, 0.72);
	border: 1px solid rgba(255,255,255,0.08);
}

.zo-asp-msg {
	display: flex;
	margin-bottom: 10px;
}

.zo-asp-msg--user {
	justify-content: flex-end;
}

.zo-asp-msg--bot {
	justify-content: flex-start;
}

.zo-asp-bubble {
	max-width: 88%;
	padding: 10px 12px;
	border-radius: 14px;
	font-size: 14px;
	line-height: 1.45;
	word-break: break-word;
}

.zo-asp-msg--user .zo-asp-bubble {
	background: linear-gradient(135deg, #2563eb, #1d4ed8);
	color: #ffffff;
	border-bottom-right-radius: 5px;
}

.zo-asp-msg--bot .zo-asp-bubble {
	background: rgba(255,255,255,0.10);
	color: #edf4ff;
	border: 1px solid rgba(255,255,255,0.10);
	border-bottom-left-radius: 5px;
}

.zo-asp-toggle-row {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
}

.zo-asp-toggle {
	display: inline-flex;
	align-items: center;
	gap: 8px;
	padding: 10px 12px;
	border-radius: 12px;
	background: rgba(255,255,255,0.06);
	border: 1px solid rgba(255,255,255,0.10);
	font-size: 13px;
	font-weight: 700;
	color: #ffffff;
}

.zo-asp-toggle input {
	margin: 0;
}

.zo-asp-note {
	font-size: 12px;
	line-height: 1.5;
	color: #d2dbee;
}

.zo-asp-coins {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 10px;
}

.zo-asp-stat {
	padding: 12px;
	border-radius: 14px;
	background: rgba(255,255,255,0.06);
	border: 1px solid rgba(255,255,255,0.10);
	text-align: center;
}

.zo-asp-stat-num {
	font-size: 24px;
	font-weight: 700;
	color: #ffffff;
}

.zo-asp-stat-label {
	margin-top: 4px;
	font-size: 12px;
	color: #cdd8ee;
}

.zo-asp-main-grid {
	display: grid;
	grid-template-columns: minmax(0, 1.16fr) minmax(0, 0.84fr);
	gap: 14px;
}

.zo-asp-preview-wrap {
	min-height: 640px;
	padding: 12px;
	border-radius: 18px;
	background:
		radial-gradient(circle at 18% 18%, rgba(59,130,246,0.18), transparent 28%),
		radial-gradient(circle at 82% 20%, rgba(236,72,153,0.12), transparent 30%),
		radial-gradient(circle at 50% 82%, rgba(16,185,129,0.10), transparent 34%),
		linear-gradient(180deg, rgba(255,255,255,0.04), rgba(255,255,255,0.02));
	border: 1px solid rgba(255,255,255,0.10);
	display: flex;
	align-items: center;
	justify-content: center;
}

.zo-asp-canvas {
	display: block;
	width: 100%;
	max-width: 100%;
	height: auto;
	border-radius: 16px;
	background: #0f172a;
	box-shadow: 0 14px 36px rgba(0,0,0,0.35);
}

.zo-asp-image {
	display: block;
	width: 100%;
	max-width: 100%;
	height: auto;
	border-radius: 16px;
	background: #0f172a;
	box-shadow: 0 14px 36px rgba(0,0,0,0.35);
}

.zo-asp-hidden {
	display: none !important;
}

.zo-asp-status {
	min-height: 18px;
	font-size: 13px;
	font-weight: 700;
	color: #86efac;
}

.zo-asp-status--warn {
	color: #fbbf24;
}

.zo-asp-status--bad {
	color: #f87171;
}

.zo-asp-chip-wrap {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
}

.zo-asp-chip {
	border: 1px solid rgba(147,197,253,0.30);
	background: rgba(59,130,246,0.12);
	color: #dbeafe;
	border-radius: 999px;
	padding: 8px 10px;
	font-size: 12px;
	font-weight: 700;
	cursor: pointer;
}

.zo-asp-share-box {
	padding: 10px;
	border-radius: 12px;
	background: rgba(255,255,255,0.06);
	border: 1px solid rgba(255,255,255,0.10);
	word-break: break-all;
	font-size: 12px;
	line-height: 1.45;
	color: #dce8ff;
	min-height: 44px;
}

.zo-asp-list {
	margin: 0;
	padding-left: 18px;
	font-size: 13px;
	line-height: 1.55;
	color: #dce6f8;
}

.zo-asp-list li + li {
	margin-top: 6px;
}

@media (max-width: 980px) {
	.zo-asp-layout {
		grid-template-columns: 1fr;
	}

	.zo-asp-sidebar {
		border-right: 0;
		border-bottom: 1px solid rgba(255,255,255,0.08);
	}

	.zo-asp-main-grid {
		grid-template-columns: 1fr;
	}

	.zo-asp-preview-wrap {
		min-height: 460px;
	}
}

@media (max-width: 640px) {
	.zo-asp-row,
	.zo-asp-row-3,
	.zo-asp-coins {
		grid-template-columns: 1fr;
	}

	.zo-asp-title {
		font-size: 24px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--ai-studio-pro');

	function clamp(num, min, max) {
		return Math.min(max, Math.max(min, num));
	}

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

	function safeJsonParse(str) {
		try {
			return JSON.parse(str);
		} catch (e) {
			return null;
		}
	}

	function drawGlow(ctx, x, y, radius, rgbaBase, alpha) {
		const g = ctx.createRadialGradient(x, y, 0, x, y, radius);
		g.addColorStop(0, 'rgba(' + rgbaBase + ',' + alpha + ')');
		g.addColorStop(1, 'rgba(' + rgbaBase + ',0)');
		ctx.fillStyle = g;
		ctx.beginPath();
		ctx.arc(x, y, radius, 0, Math.PI * 2);
		ctx.fill();
	}

	function setStatus(el, text, type) {
		el.textContent = text || '';
		el.classList.remove('zo-asp-status--warn', 'zo-asp-status--bad');
		if (type === 'warn') {
			el.classList.add('zo-asp-status--warn');
		}
		if (type === 'bad') {
			el.classList.add('zo-asp-status--bad');
		}
	}

	function containsAny(text, words) {
		for (let i = 0; i < words.length; i++) {
			if (text.indexOf(words[i]) !== -1) {
				return true;
			}
		}
		return false;
	}

	function replaceAllWord(text, find, replace) {
		const pattern = new RegExp('\\b' + find.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + '\\b', 'gi');
		return text.replace(pattern, replace);
	}

	function translatePromptToEnglish(prompt) {
		let out = ' ' + prompt.toLowerCase() + ' ';
		const map = [
			['gerçekçi', 'realistic'],
			['gercekci', 'realistic'],
			['portre', 'portrait'],
			['robot', 'robot'],
			['mavi', 'blue'],
			['göz', 'eyes'],
			['goz', 'eyes'],
			['ışıklı', 'glowing'],
			['isikli', 'glowing'],
			['parlayan', 'glowing'],
			['sinematik', 'cinematic'],
			['gökyüzü', 'sky'],
			['gokyuzu', 'sky'],
			['arka plan', 'background'],
			['fon', 'background'],
			['kedi', 'cat'],
			['köpek', 'dog'],
			['kopek', 'dog'],
			['çocuk', 'kid'],
			['cocuk', 'kid'],
			['erkek çocuk', 'boy'],
			['kız', 'girl'],
			['kiz', 'girl'],
			['sıcak', 'warm'],
			['sicak', 'warm'],
			['turuncu', 'orange'],
			['mor', 'purple'],
			['yeşil', 'green'],
			['yesil', 'green'],
			['kırmızı', 'red'],
			['kirmizi', 'red'],
			['keskin', 'sharp'],
			['detaylı', 'detailed'],
			['detayli', 'detailed'],
			['neon', 'neon'],
			['fotoğraf', 'photo'],
			['fotograf', 'photo'],
			['resim', 'image'],
			['uzay', 'space'],
			['kahraman', 'hero'],
			['şehir', 'city'],
			['sehir', 'city'],
			['sokak', 'street'],
			['bulutlu', 'cloudy'],
			['güneşli', 'sunny'],
			['gunesli', 'sunny'],
			['altın', 'golden'],
			['altin', 'golden']
		];

		for (let i = 0; i < map.length; i++) {
			out = replaceAllWord(out, map[i][0], map[i][1]);
		}

		out = out.replace(/\s+/g, ' ').trim();
		return out;
	}

	function isKidSafe(prompt) {
		const bad = [
			'blood','gore','violent','violence','kill','killing','murder','gun','rifle','weapon','knife','suicide','dead body',
			'nude','naked','sex','sexual','porn','fetish','nsfw','erotic','drugs','cocaine','meth','alcohol','beer','vodka',
			'kan','vahşet','vahset','öldür','oldur','ölüm','olum','silah','tabanca','tüfek','tufek','bıçak','bicak',
			'çıplak','ciplak','seks','uyuşturucu','uyusturucu','alkol','bira','şarap','sarap','sigara'
		];
		return !containsAny(prompt.toLowerCase(), bad);
	}

	function guessPalette(prompt) {
		const t = prompt.toLowerCase();
		if (containsAny(t, ['red', 'kırmızı', 'kirmizi'])) {
			return '#ef4444';
		}
		if (containsAny(t, ['green', 'yeşil', 'yesil'])) {
			return '#22c55e';
		}
		if (containsAny(t, ['purple', 'mor'])) {
			return '#8b5cf6';
		}
		if (containsAny(t, ['orange', 'warm', 'golden', 'turuncu', 'altın', 'altin'])) {
			return '#fb923c';
		}
		return '#3b82f6';
	}

	function guessSubject(prompt) {
		const t = prompt.toLowerCase();
		if (containsAny(t, ['cat', 'kedi'])) return 'cat';
		if (containsAny(t, ['dog', 'köpek', 'kopek'])) return 'dog';
		if (containsAny(t, ['boy', 'kid', 'child', 'çocuk', 'cocuk'])) return 'boy';
		if (containsAny(t, ['girl', 'kız', 'kiz'])) return 'girl';
		return 'robot';
	}

	function guessStyle(prompt, styleSelectValue) {
		if (styleSelectValue !== 'auto') {
			return styleSelectValue;
		}
		const t = prompt.toLowerCase();
		if (containsAny(t, ['cyberpunk', 'neon'])) return 'cyberpunk';
		if (containsAny(t, ['warm', 'golden', 'sunset', 'turuncu', 'altın', 'altin'])) return 'warm';
		if (containsAny(t, ['portrait', 'photo', 'realistic', 'gerçek', 'gercek'])) return 'portrait';
		return 'cinematic';
	}

	function setCanvasSize(canvas, size) {
		if (size === 'landscape') {
			canvas.width = 1280;
			canvas.height = 720;
			return;
		}
		if (size === 'portrait') {
			canvas.width = 720;
			canvas.height = 1280;
			return;
		}
		canvas.width = 1024;
		canvas.height = 1024;
	}

	function renderLocalArt(canvas, englishPrompt, style, detail, glow) {
		const ctx = canvas.getContext('2d');
		const w = canvas.width;
		const h = canvas.height;
		const palette = guessPalette(englishPrompt);
		const subject = guessSubject(englishPrompt);

		const bg = ctx.createLinearGradient(0, 0, 0, h);
		if (style === 'cyberpunk') {
			bg.addColorStop(0, '#081226');
			bg.addColorStop(0.50, '#1e1b4b');
			bg.addColorStop(1, '#130816');
		} else if (style === 'warm') {
			bg.addColorStop(0, '#2c436a');
			bg.addColorStop(0.55, '#8f592d');
			bg.addColorStop(1, '#1a1213');
		} else if (style === 'portrait') {
			bg.addColorStop(0, '#6fa2d9');
			bg.addColorStop(0.58, '#a6c4ea');
			bg.addColorStop(1, '#d7e5f6');
		} else {
			bg.addColorStop(0, '#071224');
			bg.addColorStop(0.55, '#18305f');
			bg.addColorStop(1, '#121d33');
		}

		ctx.clearRect(0, 0, w, h);
		ctx.fillStyle = bg;
		ctx.fillRect(0, 0, w, h);

		for (let i = 0; i < 42; i++) {
			const x = Math.random() * w;
			const y = Math.random() * h * 0.82;
			const r = 1 + Math.random() * 3;
			ctx.fillStyle = 'rgba(255,255,255,' + (0.05 + Math.random() * 0.16).toFixed(3) + ')';
			ctx.beginPath();
			ctx.arc(x, y, r, 0, Math.PI * 2);
			ctx.fill();
		}

		drawGlow(ctx, w * 0.52, h * 0.28, 180 + glow * 2, '255,255,255', 0.12);
		drawGlow(ctx, w * 0.52, h * 0.28, 200 + glow * 2, '59,130,246', 0.12);

		if (subject === 'robot') {
			ctx.save();
			ctx.translate(w * 0.53, h * 0.58);

			const metal = ctx.createLinearGradient(-140, -180, 140, 220);
			metal.addColorStop(0, '#eef4fa');
			metal.addColorStop(0.35, '#aab7c5');
			metal.addColorStop(0.65, '#6d7987');
			metal.addColorStop(1, '#d8dfe7');

			ctx.fillStyle = metal;
			ctx.strokeStyle = 'rgba(15,23,42,0.76)';
			ctx.lineWidth = 3;

			ctx.beginPath();
			ctx.moveTo(-94, -170);
			ctx.quadraticCurveTo(0, -236, 94, -170);
			ctx.quadraticCurveTo(125, -128, 118, -70);
			ctx.quadraticCurveTo(112, 0, 88, 56);
			ctx.quadraticCurveTo(40, 116, 0, 136);
			ctx.quadraticCurveTo(-40, 116, -88, 56);
			ctx.quadraticCurveTo(-112, 0, -118, -70);
			ctx.quadraticCurveTo(-125, -128, -94, -170);
			ctx.closePath();
			ctx.fill();
			ctx.stroke();

			ctx.beginPath();
			ctx.moveTo(-150, 184);
			ctx.quadraticCurveTo(-132, 72, -84, 32);
			ctx.lineTo(84, 32);
			ctx.quadraticCurveTo(132, 72, 150, 184);
			ctx.quadraticCurveTo(90, 242, 0, 252);
			ctx.quadraticCurveTo(-90, 242, -150, 184);
			ctx.closePath();
			ctx.fill();
			ctx.stroke();

			ctx.strokeStyle = 'rgba(15,23,42,0.35)';
			for (let x = -72; x <= 72; x += 36) {
				ctx.beginPath();
				ctx.moveTo(x, -150);
				ctx.lineTo(x * 0.5, 120);
				ctx.stroke();
			}

			drawGlow(ctx, -48, -8, 64 + glow, '56,189,248', 0.24);
			drawGlow(ctx, 48, -8, 64 + glow, '56,189,248', 0.24);

			ctx.fillStyle = '#a5f3fc';
			ctx.beginPath();
			ctx.ellipse(-48, -8, 34 + detail * 0.18, 13 + detail * 0.08, -0.22, 0, Math.PI * 2);
			ctx.fill();

			ctx.beginPath();
			ctx.ellipse(48, -8, 34 + detail * 0.18, 13 + detail * 0.08, 0.22, 0, Math.PI * 2);
			ctx.fill();

			ctx.strokeStyle = 'rgba(15,23,42,0.76)';
			ctx.lineWidth = 4;
			ctx.beginPath();
			ctx.moveTo(-20, 38);
			ctx.quadraticCurveTo(0, 46, 20, 38);
			ctx.stroke();

			ctx.restore();
		} else {
			ctx.save();
			ctx.translate(w * 0.5, h * 0.56);
			ctx.fillStyle = palette;

			if (subject === 'cat') {
				ctx.beginPath();
				ctx.arc(0, -120, 84, 0, Math.PI * 2);
				ctx.fill();
				ctx.beginPath();
				ctx.moveTo(-52, -172);
				ctx.lineTo(-18, -238);
				ctx.lineTo(8, -176);
				ctx.closePath();
				ctx.fill();
				ctx.beginPath();
				ctx.moveTo(52, -172);
				ctx.lineTo(18, -238);
				ctx.lineTo(-8, -176);
				ctx.closePath();
				ctx.fill();
				ctx.beginPath();
				ctx.ellipse(0, 52, 124, 148, 0, 0, Math.PI * 2);
				ctx.fill();
			} else if (subject === 'dog') {
				ctx.beginPath();
				ctx.arc(0, -120, 84, 0, Math.PI * 2);
				ctx.fill();
				ctx.beginPath();
				ctx.ellipse(-62, -152, 32, 72, -0.4, 0, Math.PI * 2);
				ctx.fill();
				ctx.beginPath();
				ctx.ellipse(62, -152, 32, 72, 0.4, 0, Math.PI * 2);
				ctx.fill();
				ctx.beginPath();
				ctx.ellipse(0, 62, 132, 140, 0, 0, Math.PI * 2);
				ctx.fill();
			} else {
				ctx.fillRect(-84, -144, 168, 320);
				ctx.beginPath();
				ctx.arc(0, -220, 90, 0, Math.PI * 2);
				ctx.fill();
			}

			drawGlow(ctx, 0, -120, 180 + glow * 1.2, '255,255,255', 0.12);
			ctx.restore();
		}

		ctx.save();
		ctx.shadowColor = 'rgba(0,0,0,0.45)';
		ctx.shadowBlur = 16;
		ctx.fillStyle = 'rgba(255,255,255,0.96)';
		ctx.font = '700 34px Arial';
		ctx.textAlign = 'center';

		const words = englishPrompt.split(/\s+/);
		const lines = [];
		let line = '';
		for (let i = 0; i < words.length; i++) {
			const test = (line ? line + ' ' : '') + words[i];
			if (test.length > 25 && line) {
				lines.push(line);
				line = words[i];
			} else {
				line = test;
			}
		}
		if (line) {
			lines.push(line);
		}

		const shown = lines.slice(0, 2);
		const startY = h - 62 - ((shown.length - 1) * 18);
		for (let j = 0; j < shown.length; j++) {
			ctx.fillText(shown[j], w / 2, startY + (j * 40));
		}
		ctx.restore();
	}

	function dataUriToBlob(dataURI) {
		const parts = dataURI.split(',');
		const mime = parts[0].match(/:(.*?);/)[1];
		const bin = atob(parts[1]);
		const arr = new Uint8Array(bin.length);
		for (let i = 0; i < bin.length; i++) {
			arr[i] = bin.charCodeAt(i);
		}
		return new Blob([arr], { type: mime });
	}

	function saveDataUrl(dataUrl, fileName) {
		const a = document.createElement('a');
		a.href = dataUrl;
		a.download = fileName;
		document.body.appendChild(a);
		a.click();
		document.body.removeChild(a);
	}

	games.forEach(function (game, gameIndex) {
		const chatLog = game.querySelector('.zo-asp-chat-log');
		const chatInput = game.querySelector('.zo-asp-chat-input');
		const chatLang = game.querySelector('.zo-asp-chat-lang');
		const promptInput = game.querySelector('.zo-asp-prompt');
		const styleSelect = game.querySelector('.zo-asp-style');
		const sizeSelect = game.querySelector('.zo-asp-size');
		const detailRange = game.querySelector('.zo-asp-detail');
		const glowRange = game.querySelector('.zo-asp-glow');
		const fileInput = game.querySelector('.zo-asp-file');
		const kidSafeToggle = game.querySelector('.zo-asp-kidsafe');
		const autoTranslateToggle = game.querySelector('.zo-asp-autotranslate');
		const apiModeToggle = game.querySelector('.zo-asp-apimode');
		const apiFields = game.querySelector('.zo-asp-api-fields');
		const apiUrlInput = game.querySelector('.zo-asp-api-url');
		const apiKeyInput = game.querySelector('.zo-asp-api-key');
		const apiModelInput = game.querySelector('.zo-asp-api-model');
		const canvas = game.querySelector('.zo-asp-canvas');
		const canvasWrap = game.querySelector('.zo-asp-canvas-wrap');
		const apiImage = game.querySelector('.zo-asp-image');
		const apiImageWrap = game.querySelector('.zo-asp-api-image-wrap');
		const statusEl = game.querySelector('.zo-asp-status');
		const translatedEl = game.querySelector('.zo-asp-translated');
		const shareBox = game.querySelector('.zo-asp-share-box');
		const shareOpenBtn = game.querySelector('.zo-asp-open-share');
		const shareMakeBtn = game.querySelector('.zo-asp-make-share');
		const btnSendChat = game.querySelector('.zo-asp-send-chat');
		const btnRender = game.querySelector('.zo-asp-render');
		const btnReset = game.querySelector('.zo-asp-reset');
		const btnSavePng = game.querySelector('.zo-asp-save-png');
		const btnSaveJpg = game.querySelector('.zo-asp-save-jpg');
		const btnUseUpload = game.querySelector('.zo-asp-use-upload');
		const btnApiDemo = game.querySelector('.zo-asp-api-demo');
		const chips = game.querySelectorAll('.zo-asp-chip');

		const coinsEl = game.querySelector('.zo-asp-coins-now');
		const rendersEl = game.querySelector('.zo-asp-renders-now');
		const savesEl = game.querySelector('.zo-asp-saves-now');

		let coins = 120;
		let renders = 0;
		let saves = 0;
		let uploadedDataUrl = '';
		let currentImageDataUrl = '';
		let shareId = 'zo-ai-share-' + gameIndex;

		function updateStats() {
			coinsEl.textContent = String(coins);
			rendersEl.textContent = String(renders);
			savesEl.textContent = String(saves);
		}

		function addCoins(amount) {
			coins = clamp(coins + amount, 0, 9999);
			updateStats();
		}

		function spendCoins(amount) {
			if (coins < amount) {
				return false;
			}
			coins -= amount;
			updateStats();
			return true;
		}

		function addMessage(text, type) {
			const row = document.createElement('div');
			row.className = 'zo-asp-msg zo-asp-msg--' + type;

			const bubble = document.createElement('div');
			bubble.className = 'zo-asp-bubble';
			bubble.innerHTML = escapeHtml(text).replace(/\n/g, '<br>');

			row.appendChild(bubble);
			chatLog.appendChild(row);
			chatLog.scrollTop = chatLog.scrollHeight;
		}

		function getPromptData() {
			const raw = promptInput.value.trim();
			const translated = autoTranslateToggle.checked ? translatePromptToEnglish(raw) : raw;
			const style = guessStyle(translated, styleSelect.value);
			return {
				raw: raw,
				english: translated,
				style: style
			};
		}

		function showTranslation(text) {
			translatedEl.textContent = text ? ('English prompt: ' + text) : '';
		}

		function resetPreviewMode() {
			canvasWrap.classList.remove('zo-asp-hidden');
			apiImageWrap.classList.add('zo-asp-hidden');
			apiImage.src = '';
		}

		function showApiImage(src) {
			apiImage.src = src;
			apiImageWrap.classList.remove('zo-asp-hidden');
			canvasWrap.classList.add('zo-asp-hidden');
			currentImageDataUrl = src;
		}

		function showCanvasImage() {
			apiImage.src = '';
			apiImageWrap.classList.add('zo-asp-hidden');
			canvasWrap.classList.remove('zo-asp-hidden');
			currentImageDataUrl = canvas.toDataURL('image/png');
		}

		function getShareState() {
			return {
				prompt: promptInput.value,
				style: styleSelect.value,
				size: sizeSelect.value,
				detail: detailRange.value,
				glow: glowRange.value,
				kidsafe: kidSafeToggle.checked ? 1 : 0,
				translate: autoTranslateToggle.checked ? 1 : 0,
				api: apiModeToggle.checked ? 1 : 0,
				coins: coins
			};
		}

		function makeShareLink() {
			const state = getShareState();
			const encoded = encodeURIComponent(JSON.stringify(state));
			const url = window.location.origin + window.location.pathname + '#zoai=' + encoded;
			shareBox.textContent = url;
			return url;
		}

		function loadShareStateFromHash() {
			const hash = window.location.hash || '';
			if (hash.indexOf('#zoai=') !== 0) {
				return false;
			}
			const raw = decodeURIComponent(hash.replace('#zoai=', ''));
			const data = safeJsonParse(raw);
			if (!data) {
				return false;
			}

			if (typeof data.prompt === 'string') promptInput.value = data.prompt;
			if (typeof data.style === 'string') styleSelect.value = data.style;
			if (typeof data.size === 'string') sizeSelect.value = data.size;
			if (typeof data.detail !== 'undefined') detailRange.value = data.detail;
			if (typeof data.glow !== 'undefined') glowRange.value = data.glow;
			kidSafeToggle.checked = String(data.kidsafe) === '1';
			autoTranslateToggle.checked = String(data.translate) === '1';
			apiModeToggle.checked = String(data.api) === '1';
			coins = parseInt(data.coins, 10) || coins;
			updateApiVisibility();
			updateStats();
			return true;
		}

		function updateApiVisibility() {
			if (apiModeToggle.checked) {
				apiFields.classList.remove('zo-asp-hidden');
			} else {
				apiFields.classList.add('zo-asp-hidden');
			}
		}

		function saveCurrentAsPng() {
			if (!currentImageDataUrl) {
				setStatus(statusEl, 'Nothing to save yet.', 'warn');
				return;
			}
			saveDataUrl(currentImageDataUrl, 'ai-image.png');
			saves += 1;
			updateStats();
			setStatus(statusEl, 'Saved PNG.');
		}

		function saveCurrentAsJpg() {
			if (!currentImageDataUrl) {
				setStatus(statusEl, 'Nothing to save yet.', 'warn');
				return;
			}

			const img = new Image();
			img.onload = function () {
				const c = document.createElement('canvas');
				c.width = img.width;
				c.height = img.height;
				const x = c.getContext('2d');
				x.fillStyle = '#0f172a';
				x.fillRect(0, 0, c.width, c.height);
				x.drawImage(img, 0, 0);
				saveDataUrl(c.toDataURL('image/jpeg', 0.92), 'ai-image.jpg');
				saves += 1;
				updateStats();
				setStatus(statusEl, 'Saved JPG.');
			};
			img.src = currentImageDataUrl;
		}

		function localRenderFlow() {
			const data = getPromptData();

			if (!data.raw) {
				setStatus(statusEl, 'Type a prompt first.', 'warn');
				return;
			}

			if (kidSafeToggle.checked && !isKidSafe(data.raw)) {
				setStatus(statusEl, 'Kid-safe mode blocked that prompt.', 'bad');
				return;
			}

			if (!spendCoins(10)) {
				setStatus(statusEl, 'Not enough coins for local render.', 'bad');
				return;
			}

			showTranslation(data.english);
			setCanvasSize(canvas, sizeSelect.value);
			renderLocalArt(
				canvas,
				data.english,
				data.style,
				parseInt(detailRange.value, 10) || 70,
				parseInt(glowRange.value, 10) || 65
			);
			showCanvasImage();
			renders += 1;
			addCoins(2);
			updateStats();
			setStatus(statusEl, 'Local render complete. Cost 10. Reward +2.');
		}

		async function apiRenderFlow() {
			const data = getPromptData();
			const endpoint = apiUrlInput.value.trim();
			const key = apiKeyInput.value.trim();
			const model = apiModelInput.value.trim() || 'gpt-image-1';

			if (!data.raw) {
				setStatus(statusEl, 'Type a prompt first.', 'warn');
				return;
			}

			if (kidSafeToggle.checked && !isKidSafe(data.raw)) {
				setStatus(statusEl, 'Kid-safe mode blocked that prompt.', 'bad');
				return;
			}

			if (!endpoint) {
				setStatus(statusEl, 'Add an API endpoint URL first.', 'bad');
				return;
			}

			if (!spendCoins(25)) {
				setStatus(statusEl, 'Not enough coins for API render.', 'bad');
				return;
			}

			showTranslation(data.english);
			setStatus(statusEl, 'Calling image API...');

			const payload = {
				model: model,
				prompt: data.english,
				size: sizeSelect.value === 'landscape' ? '1536x1024' : (sizeSelect.value === 'portrait' ? '1024x1536' : '1024x1024')
			};

			if (uploadedDataUrl) {
				payload.image_base64 = uploadedDataUrl.split(',')[1];
			}

			try {
				const headers = {
					'Content-Type': 'application/json'
				};

				if (key) {
					headers.Authorization = 'Bearer ' + key;
				}

				const response = await fetch(endpoint, {
					method: 'POST',
					headers: headers,
					body: JSON.stringify(payload)
				});

				if (!response.ok) {
					throw new Error('HTTP ' + response.status);
				}

				const json = await response.json();
				let imageSrc = '';

				if (json.data && json.data[0] && json.data[0].b64_json) {
					imageSrc = 'data:image/png;base64,' + json.data[0].b64_json;
				} else if (json.data && json.data[0] && json.data[0].url) {
					imageSrc = json.data[0].url;
				} else if (json.image_url) {
					imageSrc = json.image_url;
				} else if (json.b64_json) {
					imageSrc = 'data:image/png;base64,' + json.b64_json;
				}

				if (!imageSrc) {
					throw new Error('No image found in API response');
				}

				showApiImage(imageSrc);
				renders += 1;
				addCoins(5);
				updateStats();
				setStatus(statusEl, 'API render complete. Cost 25. Reward +5.');
			} catch (err) {
				addCoins(25);
				updateStats();
				setStatus(statusEl, 'API render failed: ' + err.message, 'bad');
			}
		}

		function renderNow() {
			if (apiModeToggle.checked) {
				apiRenderFlow();
			} else {
				localRenderFlow();
			}
		}

		function handleChat() {
			const text = chatInput.value.trim();
			const lang = chatLang.value;

			if (!text) {
				setStatus(statusEl, lang === 'tr' ? 'Önce mesaj yaz.' : 'Type a chat message first.', 'warn');
				return;
			}

			addMessage(text, 'user');

			let reply = '';
			const low = text.toLowerCase();

			if (containsAny(low, ['hello', 'hi', 'merhaba', 'selam'])) {
				reply = lang === 'tr'
					? 'Merhaba. Türkçe-İngilizce prompt çeviririm, kid-safe kontrolü yaparım, coin sistemi var, share link yaparım.'
					: 'Hello. I can translate Turkish-English prompts, do kid-safe checks, track coins, and make share links.';
			} else if (containsAny(low, ['coin', 'coins', 'kredi', 'para'])) {
				reply = lang === 'tr'
					? 'Local render 10 coin. API render 25 coin. Sohbet ve başarılı render coin kazandırır.'
					: 'Local render costs 10 coins. API render costs 25 coins. Chatting and successful renders earn coins.';
			} else if (containsAny(low, ['save', 'png', 'jpg', 'kaydet'])) {
				reply = lang === 'tr'
					? 'Önce render yap. Sonra Save PNG veya Save JPG ile indir.'
					: 'Render first. Then use Save PNG or Save JPG.';
			} else if (containsAny(low, ['share', 'multiplayer', 'paylaş', 'paylas'])) {
				reply = lang === 'tr'
					? 'Make Share Link düğmesi ayarlarını URL içine koyar. Başkası linki açınca aynı prompt ve ayarlar yüklenir.'
					: 'Make Share Link puts the prompt and settings into the URL. When someone opens it, the same setup loads.';
			} else if (containsAny(low, ['api', 'real ai', 'gerçek yapay zekâ', 'gercek yapay zeka'])) {
				reply = lang === 'tr'
					? 'API mode açıkken bir image API endpoint gir. Bu sürüm OpenAI-style JSON yanıtlarını bekler.'
					: 'In API mode, enter an image API endpoint. This version expects OpenAI-style JSON responses.';
			} else {
				reply = lang === 'tr'
					? 'Şunu dene: "mavi gözlü gerçekçi robot portresi, sinematik gökyüzü".'
					: 'Try this: "realistic robot portrait, blue glowing eyes, cinematic sky".';
			}

			window.setTimeout(function () {
				addMessage(reply, 'bot');
				addCoins(1);
			}, 160);

			chatInput.value = '';
		}

		function handleUpload() {
			if (!fileInput.files || !fileInput.files[0]) {
				setStatus(statusEl, 'Choose an image file first.', 'warn');
				return;
			}

			const file = fileInput.files[0];
			if (!file.type.match(/^image\//)) {
				setStatus(statusEl, 'That file is not an image.', 'bad');
				return;
			}

			const reader = new FileReader();
			reader.onload = function (e) {
				uploadedDataUrl = e.target.result;
				setStatus(statusEl, 'Uploaded image ready.');
			};
			reader.readAsDataURL(file);
		}

		function resetAll() {
			coins = 120;
			renders = 0;
			saves = 0;
			uploadedDataUrl = '';
			currentImageDataUrl = '';
			promptInput.value = '';
			styleSelect.value = 'auto';
			sizeSelect.value = 'square';
			detailRange.value = '72';
			glowRange.value = '66';
			kidSafeToggle.checked = true;
			autoTranslateToggle.checked = true;
			apiModeToggle.checked = false;
			apiUrlInput.value = '';
			apiKeyInput.value = '';
			apiModelInput.value = 'gpt-image-1';
			fileInput.value = '';
			translatedEl.textContent = '';
			shareBox.textContent = '';
			chatLog.innerHTML = '';
			updateApiVisibility();
			updateStats();
			resetPreviewMode();
			setCanvasSize(canvas, 'square');
			renderLocalArt(canvas, 'realistic robot portrait with blue glowing eyes', 'portrait', 72, 66);
			showCanvasImage();
			setStatus(statusEl, 'Reset complete.');
			addMessage('Hello. Build a safe prompt, render it, and share the setup with friends.', 'bot');
		}

		btnSendChat.addEventListener('click', handleChat);
		chatInput.addEventListener('keydown', function (e) {
			if (e.key === 'Enter') {
				e.preventDefault();
				handleChat();
			}
		});

		btnUseUpload.addEventListener('click', handleUpload);
		btnRender.addEventListener('click', renderNow);
		btnReset.addEventListener('click', resetAll);
		btnSavePng.addEventListener('click', saveCurrentAsPng);
		btnSaveJpg.addEventListener('click', saveCurrentAsJpg);

		apiModeToggle.addEventListener('change', updateApiVisibility);

		shareMakeBtn.addEventListener('click', function () {
			const link = makeShareLink();
			if (navigator.clipboard && navigator.clipboard.writeText) {
				navigator.clipboard.writeText(link).then(function () {
					setStatus(statusEl, 'Share link copied.');
				}).catch(function () {
					setStatus(statusEl, 'Share link created.');
				});
			} else {
				setStatus(statusEl, 'Share link created.');
			}
		});

		shareOpenBtn.addEventListener('click', function () {
			const url = shareBox.textContent.trim();
			if (!url) {
				setStatus(statusEl, 'Create a share link first.', 'warn');
				return;
			}
			window.open(url, '_blank');
		});

		btnApiDemo.addEventListener('click', function () {
			promptInput.value = 'mavi gözlü gerçekçi robot portresi, sinematik gökyüzü';
			styleSelect.value = 'portrait';
			sizeSelect.value = 'square';
			apiModeToggle.checked = true;
			updateApiVisibility();
			setStatus(statusEl, 'API demo settings loaded. Add your endpoint and key.');
		});

		chips.forEach(function (chip) {
			chip.addEventListener('click', function () {
				promptInput.value = chip.getAttribute('data-prompt') || '';
				promptInput.focus();
			});
		});

		if (loadShareStateFromHash()) {
			setStatus(statusEl, 'Share setup loaded from URL.');
		}

		resetAll();
	});
});
JS;

if (!function_exists('zo_game_ai_studio_pro_render')) {
	function zo_game_ai_studio_pro_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-ai-studio-pro-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--ai-studio-pro" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-asp-shell">
				<div class="zo-asp-topbar">
					<h2 class="zo-asp-title">Mini AI Studio Pro</h2>
					<p class="zo-asp-subtitle">English + Türkçe chatbot, optional real AI image API mode, automatic Turkish-English prompt translation, coins system, kid-safe mode, and multiplayer-style share links.</p>
				</div>

				<div class="zo-asp-layout">
					<div class="zo-asp-sidebar">
						<div class="zo-asp-card">
							<h3 class="zo-asp-card-title">Chat</h3>
							<div class="zo-asp-chat-log"></div>

							<div class="zo-asp-stack" style="margin-top:10px;">
								<div>
									<label class="zo-asp-label">Chat language</label>
									<select class="zo-asp-select zo-asp-chat-lang">
										<option value="en">English</option>
										<option value="tr">Türkçe</option>
									</select>
								</div>

								<div>
									<label class="zo-asp-label">Message</label>
									<input type="text" class="zo-asp-input zo-asp-chat-input" placeholder="Ask about prompts, coins, sharing, or API mode" />
								</div>

								<div class="zo-asp-row">
									<button type="button" class="zo-asp-btn zo-asp-btn--blue zo-asp-send-chat">Send Chat</button>
									<button type="button" class="zo-asp-btn zo-asp-btn--gray zo-asp-reset">Reset</button>
								</div>
							</div>
						</div>

						<div class="zo-asp-card">
							<h3 class="zo-asp-card-title">Prompt + Mode</h3>

							<div class="zo-asp-stack">
								<div>
									<label class="zo-asp-label">Prompt</label>
									<textarea class="zo-asp-textarea zo-asp-prompt" placeholder="Example: mavi gözlü gerçekçi robot portresi, sinematik gökyüzü"></textarea>
								</div>

								<div class="zo-asp-toggle-row">
									<label class="zo-asp-toggle">
										<input type="checkbox" class="zo-asp-kidsafe" checked />
										Kid-safe mode
									</label>
									<label class="zo-asp-toggle">
										<input type="checkbox" class="zo-asp-autotranslate" checked />
										TR → EN auto translate
									</label>
									<label class="zo-asp-toggle">
										<input type="checkbox" class="zo-asp-apimode" />
										Real AI API mode
									</label>
								</div>

								<div class="zo-asp-note zo-asp-translated"></div>

								<div class="zo-asp-row">
									<div>
										<label class="zo-asp-label">Style</label>
										<select class="zo-asp-select zo-asp-style">
											<option value="auto">Auto</option>
											<option value="portrait">Portrait</option>
											<option value="cinematic">Cinematic</option>
											<option value="cyberpunk">Cyberpunk</option>
											<option value="warm">Warm</option>
										</select>
									</div>

									<div>
										<label class="zo-asp-label">Canvas size</label>
										<select class="zo-asp-select zo-asp-size">
											<option value="square">Square 1024x1024</option>
											<option value="landscape">Landscape 1280x720</option>
											<option value="portrait">Portrait 720x1280</option>
										</select>
									</div>
								</div>

								<div class="zo-asp-row">
									<div>
										<label class="zo-asp-label">Detail</label>
										<input type="range" min="0" max="100" value="72" class="zo-asp-input zo-asp-detail" />
									</div>
									<div>
										<label class="zo-asp-label">Glow</label>
										<input type="range" min="0" max="100" value="66" class="zo-asp-input zo-asp-glow" />
									</div>
								</div>

								<div>
									<label class="zo-asp-label">Optional uploaded image for API edit mode</label>
									<input type="file" accept="image/*" class="zo-asp-file zo-asp-file" />
								</div>

								<div class="zo-asp-row">
									<button type="button" class="zo-asp-btn zo-asp-btn--green zo-asp-use-upload">Use Uploaded</button>
									<button type="button" class="zo-asp-btn zo-asp-btn--purple zo-asp-api-demo">Load API Demo</button>
								</div>

								<div class="zo-asp-card zo-asp-api-fields zo-asp-hidden" style="margin:0;">
									<div class="zo-asp-stack">
										<div>
											<label class="zo-asp-label">API endpoint URL</label>
											<input type="text" class="zo-asp-input zo-asp-api-url" placeholder="https://your-endpoint.example.com/v1/images/generations" />
										</div>

										<div>
											<label class="zo-asp-label">API key</label>
											<input type="password" class="zo-asp-input zo-asp-api-key" placeholder="Bearer token key" />
										</div>

										<div>
											<label class="zo-asp-label">Model</label>
											<input type="text" class="zo-asp-input zo-asp-api-model" value="gpt-image-1" />
										</div>

										<div class="zo-asp-note">Expects an OpenAI-style image JSON response with <code>data[0].b64_json</code> or <code>data[0].url</code>.</div>
									</div>
								</div>

								<div class="zo-asp-row-3">
									<button type="button" class="zo-asp-btn zo-asp-btn--blue zo-asp-render">Render</button>
									<button type="button" class="zo-asp-btn zo-asp-btn--pink zo-asp-save-png">Save PNG</button>
									<button type="button" class="zo-asp-btn zo-asp-btn--purple zo-asp-save-jpg">Save JPG</button>
								</div>
							</div>
						</div>

						<div class="zo-asp-card">
							<h3 class="zo-asp-card-title">Coins</h3>
							<div class="zo-asp-coins">
								<div class="zo-asp-stat">
									<div class="zo-asp-stat-num zo-asp-coins-now">120</div>
									<div class="zo-asp-stat-label">Coins</div>
								</div>
								<div class="zo-asp-stat">
									<div class="zo-asp-stat-num zo-asp-renders-now">0</div>
									<div class="zo-asp-stat-label">Renders</div>
								</div>
								<div class="zo-asp-stat">
									<div class="zo-asp-stat-num zo-asp-saves-now">0</div>
									<div class="zo-asp-stat-label">Downloads</div>
								</div>
							</div>
							<div class="zo-asp-note" style="margin-top:10px;">Local render costs 10. API render costs 25. Chat earns +1. Local success gives +2. API success gives +5.</div>
						</div>

						<div class="zo-asp-card">
							<h3 class="zo-asp-card-title">Quick prompts</h3>
							<div class="zo-asp-chip-wrap">
								<button type="button" class="zo-asp-chip" data-prompt="mavi gözlü gerçekçi robot portresi, sinematik gökyüzü">robot portresi</button>
								<button type="button" class="zo-asp-chip" data-prompt="realistic robot portrait with blue glowing eyes">robot portrait</button>
								<button type="button" class="zo-asp-chip" data-prompt="warm golden cat portrait, soft sky">golden cat</button>
								<button type="button" class="zo-asp-chip" data-prompt="cyberpunk dog portrait with neon glow">cyber dog</button>
								<button type="button" class="zo-asp-chip" data-prompt="gerçekçi uzay kahramanı portresi, mor neon ışık">space hero</button>
								<button type="button" class="zo-asp-chip" data-prompt="photo portrait, sharp details, dramatic light">photo portrait</button>
							</div>
						</div>
					</div>

					<div class="zo-asp-main">
						<div class="zo-asp-main-grid">
							<div class="zo-asp-card">
								<h3 class="zo-asp-card-title">Preview</h3>
								<div class="zo-asp-preview-wrap">
									<div class="zo-asp-canvas-wrap" style="width:100%;">
										<canvas class="zo-asp-canvas" width="1024" height="1024"></canvas>
									</div>
									<div class="zo-asp-api-image-wrap zo-asp-hidden" style="width:100%;">
										<img class="zo-asp-image" alt="Generated AI image preview" />
									</div>
								</div>
								<div class="zo-asp-status" style="margin-top:12px;"></div>
							</div>

							<div class="zo-asp-stack">
								<div class="zo-asp-card">
									<h3 class="zo-asp-card-title">Multiplayer / Share page</h3>
									<div class="zo-asp-note">This is a shareable setup system. It puts prompt and settings into the URL so another player can open the same build page and continue from there.</div>
									<div class="zo-asp-row" style="margin-top:10px;">
										<button type="button" class="zo-asp-btn zo-asp-btn--green zo-asp-make-share">Make Share Link</button>
										<button type="button" class="zo-asp-btn zo-asp-btn--orange zo-asp-open-share">Open Share Page</button>
									</div>
									<div class="zo-asp-share-box" style="margin-top:10px;"></div>
								</div>

								<div class="zo-asp-card">
									<h3 class="zo-asp-card-title">How it works</h3>
									<ul class="zo-asp-list">
										<li>Kid-safe mode blocks unsafe prompt words.</li>
										<li>Auto translate converts many Turkish prompt words into English for stronger API prompts.</li>
										<li>Real AI API mode works only if you add your own endpoint and key.</li>
										<li>If API mode is off, the game uses local browser art mode.</li>
										<li>Share links pass prompt and settings through the URL for a multiplayer-style handoff.</li>
									</ul>
								</div>

								<div class="zo-asp-card">
									<h3 class="zo-asp-card-title">Good next tests</h3>
									<ul class="zo-asp-list">
										<li>Try the Turkish prompt first with auto translate on.</li>
										<li>Toggle kid-safe mode and verify blocked words are refused.</li>
										<li>Test square, landscape, and portrait outputs.</li>
										<li>Generate a share link and open it in another tab.</li>
										<li>Add a compatible image API endpoint to switch from local art to real AI images.</li>
									</ul>
								</div>
							</div>
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
	'slug'            => 'ai-studio-pro',
	'name'            => 'Mini AI Studio Pro',
	'author'          => 'Asker',
	'description'     => 'Bilingual AI image studio with optional real API mode, auto translation, coins, kid-safe mode, and share links.',
	'render_callback' => 'zo_game_ai_studio_pro_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);