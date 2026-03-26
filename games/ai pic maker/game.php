<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root--ai-photo-chat {
	max-width: 1120px;
	margin: 0 auto;
	font-family: Arial, sans-serif;
	color: #e5eefc;
}

.zo-game-root--ai-photo-chat * {
	box-sizing: border-box;
}

.zo-ai-photo-shell {
	background: linear-gradient(180deg, #0c1222 0%, #111a2f 100%);
	border: 1px solid rgba(255, 255, 255, 0.12);
	border-radius: 22px;
	overflow: hidden;
	box-shadow: 0 20px 60px rgba(0, 0, 0, 0.35);
}

.zo-ai-photo-topbar {
	padding: 18px 20px;
	background: linear-gradient(135deg, #1d4ed8 0%, #0ea5e9 45%, #14b8a6 100%);
	color: #ffffff;
}

.zo-ai-photo-title {
	margin: 0;
	font-size: 28px;
	font-weight: 700;
	line-height: 1.1;
}

.zo-ai-photo-subtitle {
	margin: 8px 0 0;
	font-size: 14px;
	line-height: 1.5;
	max-width: 920px;
}

.zo-ai-photo-layout {
	display: grid;
	grid-template-columns: 380px 1fr;
	gap: 0;
	min-height: 720px;
}

.zo-ai-photo-sidebar {
	padding: 18px;
	border-right: 1px solid rgba(255, 255, 255, 0.08);
	background: linear-gradient(180deg, rgba(255,255,255,0.03), rgba(255,255,255,0.01));
}

.zo-ai-photo-main {
	padding: 18px;
}

.zo-ai-card {
	background: rgba(255, 255, 255, 0.05);
	border: 1px solid rgba(255, 255, 255, 0.10);
	border-radius: 18px;
	padding: 14px;
	margin-bottom: 14px;
	backdrop-filter: blur(2px);
}

.zo-ai-card:last-child {
	margin-bottom: 0;
}

.zo-ai-card-title {
	margin: 0 0 10px;
	font-size: 18px;
	font-weight: 700;
	color: #ffffff;
}

.zo-ai-chat-log {
	height: 290px;
	overflow-y: auto;
	padding: 10px;
	border-radius: 14px;
	background: rgba(6, 10, 18, 0.62);
	border: 1px solid rgba(255, 255, 255, 0.08);
}

.zo-ai-msg {
	display: flex;
	margin: 0 0 10px;
}

.zo-ai-msg:last-child {
	margin-bottom: 0;
}

.zo-ai-msg--user {
	justify-content: flex-end;
}

.zo-ai-msg--bot {
	justify-content: flex-start;
}

.zo-ai-bubble {
	max-width: 88%;
	padding: 10px 12px;
	border-radius: 14px;
	font-size: 14px;
	line-height: 1.45;
	word-break: break-word;
}

.zo-ai-msg--user .zo-ai-bubble {
	background: linear-gradient(135deg, #2563eb, #1d4ed8);
	color: #ffffff;
	border-bottom-right-radius: 4px;
}

.zo-ai-msg--bot .zo-ai-bubble {
	background: rgba(255, 255, 255, 0.10);
	color: #eaf3ff;
	border: 1px solid rgba(255, 255, 255, 0.12);
	border-bottom-left-radius: 4px;
}

.zo-ai-stack {
	display: grid;
	gap: 10px;
}

.zo-ai-label {
	display: block;
	font-size: 12px;
	font-weight: 700;
	margin: 0 0 6px;
	color: #bfdbfe;
	letter-spacing: 0.02em;
	text-transform: uppercase;
}

.zo-ai-input,
.zo-ai-select,
.zo-ai-textarea,
.zo-ai-file {
	width: 100%;
	border: 1px solid rgba(255, 255, 255, 0.15);
	border-radius: 12px;
	background: rgba(255, 255, 255, 0.08);
	color: #ffffff;
	padding: 11px 12px;
	font-size: 14px;
}

.zo-ai-input::placeholder,
.zo-ai-textarea::placeholder {
	color: #b8c5de;
}

.zo-ai-select option {
	color: #111827;
}

.zo-ai-textarea {
	min-height: 92px;
	resize: vertical;
	line-height: 1.45;
}

.zo-ai-range-wrap {
	display: grid;
	grid-template-columns: 1fr 50px;
	gap: 10px;
	align-items: center;
}

.zo-ai-range {
	width: 100%;
}

.zo-ai-range-value {
	text-align: center;
	font-size: 13px;
	font-weight: 700;
	color: #ffffff;
	padding: 8px 0;
	border-radius: 10px;
	background: rgba(255, 255, 255, 0.07);
}

.zo-ai-row {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 10px;
}

.zo-ai-btn-row {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 10px;
}

.zo-ai-btn-row--triple {
	grid-template-columns: repeat(3, 1fr);
}

.zo-ai-btn {
	border: 0;
	border-radius: 12px;
	padding: 12px 12px;
	font-size: 14px;
	font-weight: 700;
	cursor: pointer;
	color: #ffffff;
	transition: transform 0.08s ease, opacity 0.2s ease;
}

.zo-ai-btn:hover {
	opacity: 0.95;
}

.zo-ai-btn:active {
	transform: scale(0.98);
}

.zo-ai-btn--blue {
	background: linear-gradient(135deg, #2563eb, #1d4ed8);
}

.zo-ai-btn--green {
	background: linear-gradient(135deg, #10b981, #059669);
}

.zo-ai-btn--purple {
	background: linear-gradient(135deg, #8b5cf6, #7c3aed);
}

.zo-ai-btn--orange {
	background: linear-gradient(135deg, #f97316, #ea580c);
}

.zo-ai-btn--gray {
	background: linear-gradient(135deg, #475569, #334155);
}

.zo-ai-btn--pink {
	background: linear-gradient(135deg, #ec4899, #db2777);
}

.zo-ai-chips {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
}

.zo-ai-chip {
	border: 1px solid rgba(147, 197, 253, 0.32);
	background: rgba(59, 130, 246, 0.12);
	color: #dbeafe;
	border-radius: 999px;
	padding: 8px 10px;
	font-size: 12px;
	font-weight: 700;
	cursor: pointer;
}

.zo-ai-status {
	min-height: 18px;
	font-size: 13px;
	font-weight: 700;
	color: #86efac;
}

.zo-ai-note {
	font-size: 12px;
	line-height: 1.5;
	color: #cbd5e1;
}

.zo-ai-main-grid {
	display: grid;
	grid-template-columns: minmax(0, 1.15fr) minmax(0, 0.85fr);
	gap: 14px;
	height: 100%;
}

.zo-ai-preview-card {
	display: flex;
	flex-direction: column;
}

.zo-ai-preview-wrap {
	position: relative;
	min-height: 620px;
	border-radius: 18px;
	background:
		radial-gradient(circle at 20% 20%, rgba(59, 130, 246, 0.18), transparent 30%),
		radial-gradient(circle at 80% 20%, rgba(236, 72, 153, 0.14), transparent 28%),
		radial-gradient(circle at 50% 80%, rgba(16, 185, 129, 0.10), transparent 30%),
		linear-gradient(180deg, rgba(255,255,255,0.04), rgba(255,255,255,0.02));
	border: 1px solid rgba(255, 255, 255, 0.10);
	padding: 14px;
	display: flex;
	align-items: center;
	justify-content: center;
	overflow: hidden;
}

.zo-ai-canvas {
	display: block;
	width: 100%;
	max-width: 100%;
	height: auto;
	border-radius: 16px;
	background: #0f172a;
	box-shadow: 0 10px 32px rgba(0, 0, 0, 0.35);
}

.zo-ai-export-row {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 10px;
	margin-top: 12px;
}

.zo-ai-stats {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 10px;
}

.zo-ai-stat {
	padding: 12px;
	border-radius: 14px;
	background: rgba(255, 255, 255, 0.06);
	border: 1px solid rgba(255, 255, 255, 0.10);
	text-align: center;
}

.zo-ai-stat-num {
	font-size: 24px;
	font-weight: 700;
	color: #ffffff;
}

.zo-ai-stat-label {
	margin-top: 4px;
	font-size: 12px;
	color: #cbd5e1;
}

.zo-ai-help-list {
	margin: 0;
	padding-left: 18px;
	font-size: 13px;
	line-height: 1.55;
	color: #dbe4f3;
}

.zo-ai-help-list li + li {
	margin-top: 6px;
}

@media (max-width: 980px) {
	.zo-ai-photo-layout {
		grid-template-columns: 1fr;
	}

	.zo-ai-photo-sidebar {
		border-right: 0;
		border-bottom: 1px solid rgba(255, 255, 255, 0.08);
	}

	.zo-ai-main-grid {
		grid-template-columns: 1fr;
	}

	.zo-ai-preview-wrap {
		min-height: 460px;
	}

	.zo-ai-export-row {
		grid-template-columns: 1fr 1fr;
	}
}

@media (max-width: 640px) {
	.zo-ai-row,
	.zo-ai-btn-row,
	.zo-ai-btn-row--triple,
	.zo-ai-export-row,
	.zo-ai-stats {
		grid-template-columns: 1fr;
	}

	.zo-ai-title {
		font-size: 24px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--ai-photo-chat');

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

	function clamp(num, min, max) {
		return Math.min(max, Math.max(min, num));
	}

	function pick(list) {
		return list[Math.floor(Math.random() * list.length)];
	}

	function containsAny(text, list) {
		for (let i = 0; i < list.length; i++) {
			if (text.indexOf(list[i]) !== -1) {
				return true;
			}
		}
		return false;
	}

	function saveDataUrl(dataUrl, fileName) {
		const link = document.createElement('a');
		link.href = dataUrl;
		link.download = fileName;
		document.body.appendChild(link);
		link.click();
		document.body.removeChild(link);
	}

	function createOffscreen(canvas) {
		const off = document.createElement('canvas');
		off.width = canvas.width;
		off.height = canvas.height;
		return off;
	}

	function getPromptSettings(text) {
		const t = text.toLowerCase();

		let style = 'cinematic';
		if (containsAny(t, ['anime', 'cartoon', 'illustration', 'çizgi', 'cizgi'])) {
			style = 'illustration';
		}
		if (containsAny(t, ['studio', 'portrait', 'photo', 'realistic', 'photoreal', 'gerçek', 'gercek'])) {
			style = 'portrait';
		}
		if (containsAny(t, ['cyberpunk', 'neon'])) {
			style = 'cyberpunk';
		}
		if (containsAny(t, ['warm', 'gold', 'sunset', 'orange', 'golden'])) {
			style = 'warm';
		}

		let subject = 'robot';
		if (containsAny(t, ['robot'])) {
			subject = 'robot';
		} else if (containsAny(t, ['cat', 'kedi'])) {
			subject = 'cat';
		} else if (containsAny(t, ['dog', 'köpek', 'kopek'])) {
			subject = 'dog';
		} else if (containsAny(t, ['boy', 'kid', 'child', 'çocuk', 'cocuk'])) {
			subject = 'kid';
		} else if (containsAny(t, ['girl', 'kız', 'kiz'])) {
			subject = 'girl';
		}

		let palette = 'blue';
		if (containsAny(t, ['red', 'kırmızı', 'kirmizi'])) {
			palette = 'red';
		} else if (containsAny(t, ['green', 'yeşil', 'yesil'])) {
			palette = 'green';
		} else if (containsAny(t, ['purple', 'mor'])) {
			palette = 'purple';
		} else if (containsAny(t, ['orange', 'turuncu', 'warm', 'gold', 'golden', 'sunset'])) {
			palette = 'orange';
		}

		return {
			style: style,
			subject: subject,
			palette: palette
		};
	}

	function getBotReply(message, lang) {
		const text = message.toLowerCase().trim();

		const en = {
			hello: [
				'Hello. This version can chat in English and Turkish, upload a real image, restyle it, and save PNG or JPG.',
				'Hi. For better results, upload a real photo first, then render and export it.'
			],
			save: [
				'Use Save PNG or Save JPG under the preview.',
				'Render first. Then use the export buttons to download the picture.'
			],
			real: [
				'True AI photo generation is not available in this browser-only game. Best results come from uploading a real reference image and applying styles.',
				'This game can enhance and restyle a real uploaded picture. It does not call outside AI services.'
			],
			turkish: [
				'I know Turkish too. Example: "Mavi gözlü robot, cinematic portrait".',
				'You can write prompts in Turkish. Example: "Gerçekçi robot portresi".'
			],
			english: [
				'Yes. You can write prompts in English too.',
				'English works. Example: "cinematic robot portrait with blue glow".'
			],
			fallback: [
				'Try a prompt like: realistic robot portrait, blue glowing eyes, cinematic sky.',
				'Upload an image, then use a short prompt with style words like cinematic, portrait, neon, warm, realistic.'
			]
		};

		const tr = {
			hello: [
				'Merhaba. Bu sürüm İngilizce ve Türkçe konuşur, gerçek resim yükler, stil verir ve PNG ya da JPG kaydeder.',
				'Selam. Daha iyi sonuç için önce gerçek bir fotoğraf yükle, sonra render yap ve dışa aktar.'
			],
			save: [
				'Önizlemenin altındaki Save PNG veya Save JPG düğmelerini kullan.',
				'Önce render yap. Sonra export düğmeleriyle resmi indir.'
			],
			real: [
				'Gerçek yapay zekâ fotoğraf üretimi bu tarayıcı içi oyunda yok. En iyi sonuç için gerçek bir referans resim yükleyip stil uygula.',
				'Bu oyun yüklenen gerçek resmi iyileştirip yeniden stillendirir. Dış yapay zekâ servisi çağırmaz.'
			],
			turkish: [
				'Türkçe biliyorum. Mesela: "Mavi gözlü robot, sinematik portre".',
				'Türkçe prompt yazabilirsin. Mesela: "Gerçekçi robot portresi".'
			],
			english: [
				'İngilizce de olur. Örnek: "cinematic robot portrait with blue glow".',
				'Evet. İngilizce prompt yazabilirsin.'
			],
			fallback: [
				'Şunu dene: realistic robot portrait, blue glowing eyes, cinematic sky.',
				'Bir resim yükle. Sonra cinematic, portrait, neon, warm, realistic gibi kısa stil kelimeleri kullan.'
			]
		};

		const dict = lang === 'tr' ? tr : en;

		if (containsAny(text, ['merhaba', 'selam', 'hello', 'hi', 'hey'])) {
			return pick(dict.hello);
		}
		if (containsAny(text, ['kaydet', 'save', 'png', 'jpg', 'jpeg', 'indir', 'download'])) {
			return pick(dict.save);
		}
		if (containsAny(text, ['real', 'realistic', 'gerçek', 'gercek', 'photo', 'foto'])) {
			return pick(dict.real);
		}
		if (containsAny(text, ['türkçe', 'turkce', 'turkish'])) {
			return pick(dict.turkish);
		}
		if (containsAny(text, ['english', 'ingilizce'])) {
			return pick(dict.english);
		}

		return pick(dict.fallback);
	}

	function drawBackground(ctx, w, h, settings) {
		const grad = ctx.createLinearGradient(0, 0, 0, h);
		if (settings.style === 'cyberpunk') {
			grad.addColorStop(0, '#0a1025');
			grad.addColorStop(0.45, '#1a1f4e');
			grad.addColorStop(1, '#10091a');
		} else if (settings.style === 'warm') {
			grad.addColorStop(0, '#2c436a');
			grad.addColorStop(0.52, '#965b2e');
			grad.addColorStop(1, '#140f12');
		} else if (settings.style === 'portrait') {
			grad.addColorStop(0, '#6fa0d8');
			grad.addColorStop(0.56, '#8ab3e4');
			grad.addColorStop(1, '#d9e5f6');
		} else {
			grad.addColorStop(0, '#081224');
			grad.addColorStop(0.50, '#18305f');
			grad.addColorStop(1, '#1d2742');
		}

		ctx.fillStyle = grad;
		ctx.fillRect(0, 0, w, h);

		for (let i = 0; i < 36; i++) {
			const x = Math.random() * w;
			const y = Math.random() * h * 0.8;
			const r = 1 + Math.random() * 3;
			const alpha = 0.06 + Math.random() * 0.18;
			ctx.fillStyle = 'rgba(255,255,255,' + alpha.toFixed(3) + ')';
			ctx.beginPath();
			ctx.arc(x, y, r, 0, Math.PI * 2);
			ctx.fill();
		}

		if (settings.style === 'cyberpunk' || settings.style === 'cinematic') {
			for (let j = 0; j < 8; j++) {
				const x2 = Math.random() * w;
				const y2 = Math.random() * h * 0.6;
				const ray = ctx.createLinearGradient(x2, y2, x2, h);
				ray.addColorStop(0, 'rgba(59,130,246,0.12)');
				ray.addColorStop(1, 'rgba(59,130,246,0)');
				ctx.fillStyle = ray;
				ctx.beginPath();
				ctx.moveTo(x2 - 20, y2);
				ctx.lineTo(x2 + 20, y2);
				ctx.lineTo(x2 + 140, h);
				ctx.lineTo(x2 - 140, h);
				ctx.closePath();
				ctx.fill();
			}
		}
	}

	function drawGlow(ctx, x, y, radius, color, strength) {
		const g = ctx.createRadialGradient(x, y, 0, x, y, radius);
		g.addColorStop(0, color.replace('ALPHA', String(strength)));
		g.addColorStop(1, color.replace('ALPHA', '0'));
		ctx.fillStyle = g;
		ctx.beginPath();
		ctx.arc(x, y, radius, 0, Math.PI * 2);
		ctx.fill();
	}

	function paletteColor(name) {
		if (name === 'red') {
			return '#ef4444';
		}
		if (name === 'green') {
			return '#22c55e';
		}
		if (name === 'purple') {
			return '#8b5cf6';
		}
		if (name === 'orange') {
			return '#fb923c';
		}
		return '#3b82f6';
	}

	function drawPromptArt(ctx, canvas, prompt, settings, detail, glow, contrast) {
		const w = canvas.width;
		const h = canvas.height;
		const accent = paletteColor(settings.palette);

		drawBackground(ctx, w, h, settings);

		drawGlow(ctx, w * 0.52, h * 0.35, 180 + glow * 0.7, 'rgba(255,255,255,ALPHA)', 0.12 + glow * 0.0012);
		drawGlow(ctx, w * 0.50, h * 0.34, 140 + glow * 0.9, 'rgba(59,130,246,ALPHA)', 0.15 + glow * 0.0014);

		if (settings.subject === 'robot') {
			ctx.save();
			ctx.translate(w * 0.53, h * 0.57);

			const metal = ctx.createLinearGradient(-130, -170, 130, 210);
			metal.addColorStop(0, '#e5edf5');
			metal.addColorStop(0.32, '#a3b3c6');
			metal.addColorStop(0.65, '#6b7a88');
			metal.addColorStop(1, '#d3dbe5');

			ctx.fillStyle = metal;
			ctx.strokeStyle = 'rgba(15, 23, 42, 0.75)';
			ctx.lineWidth = 3;

			ctx.beginPath();
			ctx.moveTo(-90, -165);
			ctx.quadraticCurveTo(0, -235, 90, -165);
			ctx.quadraticCurveTo(120, -125, 115, -70);
			ctx.quadraticCurveTo(110, 0, 88, 55);
			ctx.quadraticCurveTo(40, 115, 0, 135);
			ctx.quadraticCurveTo(-40, 115, -88, 55);
			ctx.quadraticCurveTo(-110, 0, -115, -70);
			ctx.quadraticCurveTo(-120, -125, -90, -165);
			ctx.closePath();
			ctx.fill();
			ctx.stroke();

			ctx.beginPath();
			ctx.moveTo(-140, 185);
			ctx.quadraticCurveTo(-126, 72, -82, 34);
			ctx.lineTo(82, 34);
			ctx.quadraticCurveTo(126, 72, 140, 185);
			ctx.quadraticCurveTo(86, 240, 0, 250);
			ctx.quadraticCurveTo(-86, 240, -140, 185);
			ctx.closePath();
			ctx.fill();
			ctx.stroke();

			ctx.strokeStyle = 'rgba(15, 23, 42, 0.36)';
			ctx.lineWidth = 2;
			for (let i = -70; i <= 70; i += 35) {
				ctx.beginPath();
				ctx.moveTo(i, -150);
				ctx.lineTo(i * 0.5, 120);
				ctx.stroke();
			}

			ctx.lineWidth = 4;
			ctx.strokeStyle = 'rgba(15,23,42,0.72)';
			ctx.beginPath();
			ctx.moveTo(-35, -10);
			ctx.lineTo(-10, -14);
			ctx.moveTo(35, -10);
			ctx.lineTo(10, -14);
			ctx.stroke();

			const eyeY = -10;
			const eyeOffset = 46;
			const eyeW = 34 + detail * 0.08;
			const eyeH = 13 + detail * 0.05;

			drawGlow(ctx, -eyeOffset, eyeY, 56 + glow * 0.35, 'rgba(56,189,248,ALPHA)', 0.22 + glow * 0.0015);
			drawGlow(ctx, eyeOffset, eyeY, 56 + glow * 0.35, 'rgba(56,189,248,ALPHA)', 0.22 + glow * 0.0015);

			ctx.fillStyle = '#a5f3fc';
			ctx.beginPath();
			ctx.ellipse(-eyeOffset, eyeY, eyeW, eyeH, -0.2, 0, Math.PI * 2);
			ctx.fill();

			ctx.beginPath();
			ctx.ellipse(eyeOffset, eyeY, eyeW, eyeH, 0.2, 0, Math.PI * 2);
			ctx.fill();

			ctx.strokeStyle = 'rgba(15,23,42,0.76)';
			ctx.lineWidth = 3;
			ctx.beginPath();
			ctx.moveTo(-18, 38);
			ctx.quadraticCurveTo(0, 46, 18, 38);
			ctx.stroke();

			ctx.strokeStyle = 'rgba(15,23,42,0.38)';
			ctx.lineWidth = 2;
			for (let n = -42; n <= 42; n += 14) {
				ctx.beginPath();
				ctx.moveTo(n, 58);
				ctx.lineTo(n * 0.9, 128);
				ctx.stroke();
			}

			ctx.restore();
		} else {
			ctx.save();
			ctx.fillStyle = accent;
			ctx.globalAlpha = 0.92;
			ctx.beginPath();
			ctx.arc(w * 0.5, h * 0.48, 160, 0, Math.PI * 2);
			ctx.fill();
			ctx.globalAlpha = 1;

			drawGlow(ctx, w * 0.5, h * 0.4, 220, 'rgba(255,255,255,ALPHA)', 0.16 + glow * 0.0012);
			ctx.restore();
		}

		const overlay = ctx.createLinearGradient(0, 0, 0, h);
		overlay.addColorStop(0, 'rgba(255,255,255,0.02)');
		overlay.addColorStop(0.62, 'rgba(255,255,255,0)');
		overlay.addColorStop(1, 'rgba(0,0,0,' + (0.24 + contrast * 0.0024).toFixed(3) + ')');
		ctx.fillStyle = overlay;
		ctx.fillRect(0, 0, w, h);

		const lines = [];
		const words = prompt.trim().split(/\s+/);
		let line = '';
		for (let i = 0; i < words.length; i++) {
			const test = (line ? line + ' ' : '') + words[i];
			if (test.length > 26 && line) {
				lines.push(line);
				line = words[i];
			} else {
				line = test;
			}
		}
		if (line) {
			lines.push(line);
		}

		const titleLines = lines.slice(0, 2);
		if (titleLines.length) {
			ctx.save();
			ctx.shadowColor = 'rgba(0,0,0,0.45)';
			ctx.shadowBlur = 16;
			ctx.fillStyle = 'rgba(255,255,255,0.95)';
			ctx.font = '700 34px Arial';
			ctx.textAlign = 'center';

			const baseY = h - 78 - ((titleLines.length - 1) * 18);
			for (let k = 0; k < titleLines.length; k++) {
				ctx.fillText(titleLines[k], w / 2, baseY + (k * 40));
			}

			ctx.restore();
		}
	}

	function applyTonePass(canvas, contrast, saturation, glow) {
		const ctx = canvas.getContext('2d');
		const img = ctx.getImageData(0, 0, canvas.width, canvas.height);
		const data = img.data;

		const c = 1 + (contrast / 100);
		const s = 1 + (saturation / 100);
		const blueBoost = 1 + glow / 350;

		for (let i = 0; i < data.length; i += 4) {
			let r = data[i];
			let g = data[i + 1];
			let b = data[i + 2];

			r = (r - 128) * c + 128;
			g = (g - 128) * c + 128;
			b = (b - 128) * c + 128;

			const gray = (r + g + b) / 3;
			r = gray + (r - gray) * s;
			g = gray + (g - gray) * s;
			b = gray + (b - gray) * s * blueBoost;

			data[i] = clamp(r, 0, 255);
			data[i + 1] = clamp(g, 0, 255);
			data[i + 2] = clamp(b, 0, 255);
		}

		ctx.putImageData(img, 0, 0);
	}

	function addVignette(ctx, w, h, amount) {
		const vignette = ctx.createRadialGradient(w / 2, h / 2, Math.min(w, h) * 0.18, w / 2, h / 2, Math.max(w, h) * 0.7);
		vignette.addColorStop(0, 'rgba(0,0,0,0)');
		vignette.addColorStop(1, 'rgba(0,0,0,' + (0.10 + amount / 180).toFixed(3) + ')');
		ctx.fillStyle = vignette;
		ctx.fillRect(0, 0, w, h);
	}

	function addLightBurst(ctx, w, h, glow) {
		const cx = w * 0.52;
		const cy = h * 0.22;
		for (let i = 0; i < 14; i++) {
			const ang = (-0.9 + (i / 13) * 1.8);
			const len = h * (0.58 + (i % 3) * 0.1);
			ctx.save();
			ctx.translate(cx, cy);
			ctx.rotate(ang);
			const g = ctx.createLinearGradient(0, 0, 0, len);
			g.addColorStop(0, 'rgba(255,255,255,' + (0.06 + glow / 2800).toFixed(3) + ')');
			g.addColorStop(1, 'rgba(255,255,255,0)');
			ctx.fillStyle = g;
			ctx.beginPath();
			ctx.moveTo(-10, 0);
			ctx.lineTo(10, 0);
			ctx.lineTo(65, len);
			ctx.lineTo(-65, len);
			ctx.closePath();
			ctx.fill();
			ctx.restore();
		}
	}

	function drawUploadedPhoto(ctx, canvas, img, prompt, settings, detail, glow, contrast, saturation) {
		const w = canvas.width;
		const h = canvas.height;

		drawBackground(ctx, w, h, settings);

		const ratio = Math.max(w / img.width, h / img.height);
		const drawW = img.width * ratio;
		const drawH = img.height * ratio;
		const dx = (w - drawW) / 2;
		const dy = (h - drawH) / 2;

		ctx.save();
		ctx.filter = 'blur(' + Math.round(8 + detail / 18) + 'px) brightness(0.55)';
		ctx.drawImage(img, dx, dy, drawW, drawH);
		ctx.restore();

		ctx.save();
		ctx.drawImage(img, dx, dy, drawW, drawH);
		ctx.restore();

		ctx.save();
		ctx.globalCompositeOperation = 'screen';
		drawGlow(ctx, w * 0.5, h * 0.28, 180 + glow, 'rgba(59,130,246,ALPHA)', 0.12 + glow / 2000);
		ctx.restore();

		applyTonePass(canvas, contrast, saturation, glow);

		ctx.save();
		if (settings.style === 'cyberpunk') {
			ctx.fillStyle = 'rgba(168,85,247,0.10)';
			ctx.fillRect(0, 0, w, h);
			ctx.globalCompositeOperation = 'screen';
			ctx.fillStyle = 'rgba(56,189,248,0.08)';
			ctx.fillRect(0, 0, w, h);
		} else if (settings.style === 'warm') {
			ctx.fillStyle = 'rgba(251,146,60,0.10)';
			ctx.fillRect(0, 0, w, h);
		} else if (settings.style === 'portrait') {
			ctx.fillStyle = 'rgba(255,255,255,0.05)';
			ctx.fillRect(0, 0, w, h);
		} else {
			ctx.fillStyle = 'rgba(59,130,246,0.07)';
			ctx.fillRect(0, 0, w, h);
		}
		ctx.restore();

		addLightBurst(ctx, w, h, glow);
		addVignette(ctx, w, h, contrast);

		const eyeHint = prompt.toLowerCase();
		if (containsAny(eyeHint, ['blue eyes', 'blue eye', 'mavi göz', 'mavi goz', 'glow eyes', 'glowing eyes'])) {
			drawGlow(ctx, w * 0.46, h * 0.34, 42 + glow * 0.25, 'rgba(56,189,248,ALPHA)', 0.18 + glow / 1800);
			drawGlow(ctx, w * 0.56, h * 0.34, 42 + glow * 0.25, 'rgba(56,189,248,ALPHA)', 0.18 + glow / 1800);
		}

		ctx.save();
		ctx.shadowColor = 'rgba(0,0,0,0.45)';
		ctx.shadowBlur = 14;
		ctx.textAlign = 'center';

		const subtitle = settings.style === 'cyberpunk' ? 'Neon Styled Render' : (settings.style === 'portrait' ? 'Photo Portrait Render' : 'Cinematic Render');
		ctx.fillStyle = 'rgba(255,255,255,0.86)';
		ctx.font = '700 16px Arial';
		ctx.fillText(subtitle, w / 2, h - 94);

		const words = prompt.trim().split(/\s+/);
		const lines = [];
		let line = '';
		for (let i = 0; i < words.length; i++) {
			const test = (line ? line + ' ' : '') + words[i];
			if (test.length > 24 && line) {
				lines.push(line);
				line = words[i];
			} else {
				line = test;
			}
		}
		if (line) {
			lines.push(line);
		}

		ctx.fillStyle = 'rgba(255,255,255,0.98)';
		ctx.font = '700 34px Arial';
		const shown = lines.slice(0, 2);
		const startY = h - 48 - ((shown.length - 1) * 18);

		for (let j = 0; j < shown.length; j++) {
			ctx.fillText(shown[j], w / 2, startY + (j * 40));
		}
		ctx.restore();
	}

	games.forEach(function (game) {
		const chatLog = game.querySelector('.zo-ai-chat-log');
		const langSelect = game.querySelector('.zo-ai-lang');
		const chatInput = game.querySelector('.zo-ai-chat-input');
		const chatSend = game.querySelector('.zo-ai-chat-send');
		const promptInput = game.querySelector('.zo-ai-prompt');
		const fileInput = game.querySelector('.zo-ai-file');
		const styleSelect = game.querySelector('.zo-ai-style');
		const sizeSelect = game.querySelector('.zo-ai-size');
		const detailRange = game.querySelector('.zo-ai-detail');
		const glowRange = game.querySelector('.zo-ai-glow');
		const contrastRange = game.querySelector('.zo-ai-contrast');
		const saturationRange = game.querySelector('.zo-ai-saturation');
		const detailValue = game.querySelector('.zo-ai-detail-value');
		const glowValue = game.querySelector('.zo-ai-glow-value');
		const contrastValue = game.querySelector('.zo-ai-contrast-value');
		const saturationValue = game.querySelector('.zo-ai-saturation-value');
		const renderBtn = game.querySelector('.zo-ai-render');
		const photoBtn = game.querySelector('.zo-ai-photo-demo');
		const artBtn = game.querySelector('.zo-ai-art-demo');
		const clearBtn = game.querySelector('.zo-ai-clear');
		const savePngBtn = game.querySelector('.zo-ai-save-png');
		const saveJpgBtn = game.querySelector('.zo-ai-save-jpg');
		const useUploadedBtn = game.querySelector('.zo-ai-use-upload');
		const chips = game.querySelectorAll('.zo-ai-chip');
		const status = game.querySelector('.zo-ai-status');
		const canvas = game.querySelector('.zo-ai-canvas');
		const ctx = canvas.getContext('2d');
		const chatsNum = game.querySelector('.zo-ai-stat-chats');
		const rendersNum = game.querySelector('.zo-ai-stat-renders');
		const savesNum = game.querySelector('.zo-ai-stat-saves');

		let uploadedImage = null;
		let uploadedName = '';
		let chatCount = 0;
		let renderCount = 0;
		let saveCount = 0;

		function updateStats() {
			chatsNum.textContent = String(chatCount);
			rendersNum.textContent = String(renderCount);
			savesNum.textContent = String(saveCount);
		}

		function setCanvasSize() {
			const size = sizeSelect.value;
			if (size === 'square') {
				canvas.width = 1024;
				canvas.height = 1024;
			} else if (size === 'landscape') {
				canvas.width = 1280;
				canvas.height = 720;
			} else {
				canvas.width = 720;
				canvas.height = 1280;
			}
		}

		function addMessage(text, type) {
			const row = document.createElement('div');
			row.className = 'zo-ai-msg zo-ai-msg--' + type;

			const bubble = document.createElement('div');
			bubble.className = 'zo-ai-bubble';
			bubble.innerHTML = escapeHtml(text).replace(/\n/g, '<br>');

			row.appendChild(bubble);
			chatLog.appendChild(row);
			chatLog.scrollTop = chatLog.scrollHeight;

			chatCount += 1;
			updateStats();
		}

		function updateRangeLabels() {
			detailValue.textContent = detailRange.value;
			glowValue.textContent = glowRange.value;
			contrastValue.textContent = contrastRange.value;
			saturationValue.textContent = saturationRange.value;
		}

		function getPrompt() {
			return promptInput.value.trim() || 'cinematic robot portrait with blue glowing eyes';
		}

		function getCurrentSettings() {
			const prompt = getPrompt();
			const base = getPromptSettings(prompt);
			const selectedStyle = styleSelect.value === 'auto' ? base.style : styleSelect.value;
			base.style = selectedStyle;
			return base;
		}

		function renderCurrent() {
			setCanvasSize();

			const prompt = getPrompt();
			const settings = getCurrentSettings();
			const detail = parseInt(detailRange.value, 10) || 50;
			const glow = parseInt(glowRange.value, 10) || 50;
			const contrast = parseInt(contrastRange.value, 10) || 50;
			const saturation = parseInt(saturationRange.value, 10) || 50;

			ctx.clearRect(0, 0, canvas.width, canvas.height);

			if (uploadedImage) {
				drawUploadedPhoto(ctx, canvas, uploadedImage, prompt, settings, detail, glow, contrast, saturation);
				status.textContent = 'Rendered from uploaded image. Save as PNG or JPG below.';
			} else {
				drawPromptArt(ctx, canvas, prompt, settings, detail, glow, contrast);
				status.textContent = 'Rendered browser art. For more realistic output, upload a real image first.';
			}

			renderCount += 1;
			updateStats();
		}

		function loadImageFromFile(file) {
			if (!file || !file.type.match(/^image\//)) {
				status.textContent = 'Please choose an image file.';
				return;
			}

			const reader = new FileReader();
			reader.onload = function (e) {
				const img = new Image();
				img.onload = function () {
					uploadedImage = img;
					uploadedName = file.name || 'image';
					status.textContent = 'Image loaded. Now click Render.';
				};
				img.src = e.target.result;
			};
			reader.readAsDataURL(file);
		}

		function renderPhotoDemo() {
			setCanvasSize();

			const off = createOffscreen(canvas);
			const octx = off.getContext('2d');
			const prompt = 'cinematic robot portrait with blue glowing eyes';
			const settings = {
				style: 'portrait',
				subject: 'robot',
				palette: 'blue'
			};

			drawPromptArt(octx, off, prompt, settings, 78, 80, 62);

			uploadedImage = new Image();
			uploadedImage.onload = function () {
				renderCurrent();
			};
			uploadedImage.src = off.toDataURL('image/png');

			status.textContent = 'Loading demo photo source...';
		}

		function renderArtDemo() {
			uploadedImage = null;
			promptInput.value = 'realistic robot portrait, blue glowing eyes, cinematic sky';
			styleSelect.value = 'portrait';
			renderCurrent();
		}

		function clearAll() {
			uploadedImage = null;
			uploadedName = '';
			fileInput.value = '';
			promptInput.value = '';
			styleSelect.value = 'auto';
			sizeSelect.value = 'square';
			detailRange.value = '70';
			glowRange.value = '65';
			contrastRange.value = '55';
			saturationRange.value = '40';
			updateRangeLabels();
			setCanvasSize();
			ctx.clearRect(0, 0, canvas.width, canvas.height);
			renderCount = 0;
			saveCount = 0;
			updateStats();
			status.textContent = 'Cleared. Upload a real image or use a demo.';
			chatLog.innerHTML = '';
			addMessage('Hello. Upload a real image, write an English or Turkish prompt, render it, then save as PNG or JPG.', 'bot');
		}

		chatSend.addEventListener('click', function () {
			const text = chatInput.value.trim();
			const lang = langSelect.value;

			if (!text) {
				status.textContent = lang === 'tr' ? 'Önce bir mesaj yaz.' : 'Type a chat message first.';
				return;
			}

			addMessage(text, 'user');
			const reply = getBotReply(text, lang);
			window.setTimeout(function () {
				addMessage(reply, 'bot');
			}, 150);

			chatInput.value = '';
		});

		chatInput.addEventListener('keydown', function (e) {
			if (e.key === 'Enter') {
				e.preventDefault();
				chatSend.click();
			}
		});

		fileInput.addEventListener('change', function () {
			if (fileInput.files && fileInput.files[0]) {
				loadImageFromFile(fileInput.files[0]);
			}
		});

		useUploadedBtn.addEventListener('click', function () {
			if (fileInput.files && fileInput.files[0]) {
				loadImageFromFile(fileInput.files[0]);
			} else {
				status.textContent = 'Choose an image file first.';
			}
		});

		renderBtn.addEventListener('click', function () {
			renderCurrent();
		});

		photoBtn.addEventListener('click', function () {
			renderPhotoDemo();
		});

		artBtn.addEventListener('click', function () {
			renderArtDemo();
		});

		clearBtn.addEventListener('click', function () {
			clearAll();
		});

		savePngBtn.addEventListener('click', function () {
			if (!canvas.width || !canvas.height) {
				status.textContent = 'Nothing to save yet.';
				return;
			}
			const fileName = (uploadedName ? uploadedName.replace(/\.[^.]+$/, '') : 'ai-image') + '.png';
			saveDataUrl(canvas.toDataURL('image/png'), fileName);
			saveCount += 1;
			updateStats();
			status.textContent = 'Saved PNG.';
		});

		saveJpgBtn.addEventListener('click', function () {
			if (!canvas.width || !canvas.height) {
				status.textContent = 'Nothing to save yet.';
				return;
			}

			const jpgCanvas = document.createElement('canvas');
			jpgCanvas.width = canvas.width;
			jpgCanvas.height = canvas.height;
			const jctx = jpgCanvas.getContext('2d');
			jctx.fillStyle = '#0f172a';
			jctx.fillRect(0, 0, jpgCanvas.width, jpgCanvas.height);
			jctx.drawImage(canvas, 0, 0);

			const fileName = (uploadedName ? uploadedName.replace(/\.[^.]+$/, '') : 'ai-image') + '.jpg';
			saveDataUrl(jpgCanvas.toDataURL('image/jpeg', 0.92), fileName);
			saveCount += 1;
			updateStats();
			status.textContent = 'Saved JPG.';
		});

		[detailRange, glowRange, contrastRange, saturationRange].forEach(function (input) {
			input.addEventListener('input', updateRangeLabels);
		});

		chips.forEach(function (chip) {
			chip.addEventListener('click', function () {
				promptInput.value = chip.getAttribute('data-prompt') || '';
				promptInput.focus();
			});
		});

		setCanvasSize();
		updateRangeLabels();
		addMessage('Hello. Upload a real image, write an English or Turkish prompt, render it, then save as PNG or JPG.', 'bot');
		renderArtDemo();
	});
});
JS;

if (!function_exists('zo_game_ai_photo_chat_render')) {
	function zo_game_ai_photo_chat_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-ai-photo-chat-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--ai-photo-chat" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-ai-photo-shell">
				<div class="zo-ai-photo-topbar">
					<h2 class="zo-ai-photo-title">Mini AI Photo Chat Studio</h2>
					<p class="zo-ai-photo-subtitle">Chat in English or Türkçe. Upload a real picture, apply browser-based cinematic styles, then save the result as PNG or JPG. This version is better for real-looking output because it can restyle an uploaded image instead of only drawing simple vector art.</p>
				</div>

				<div class="zo-ai-photo-layout">
					<div class="zo-ai-photo-sidebar">
						<div class="zo-ai-card">
							<h3 class="zo-ai-card-title">Chat</h3>
							<div class="zo-ai-chat-log"></div>

							<div class="zo-ai-stack" style="margin-top:10px;">
								<div>
									<label class="zo-ai-label">Language</label>
									<select class="zo-ai-select zo-ai-lang">
										<option value="en">English</option>
										<option value="tr">Türkçe</option>
									</select>
								</div>

								<div>
									<label class="zo-ai-label">Chat message</label>
									<input type="text" class="zo-ai-input zo-ai-chat-input" placeholder="Ask about prompts, saving, or real-looking images" />
								</div>

								<div class="zo-ai-btn-row">
									<button type="button" class="zo-ai-btn zo-ai-btn--blue zo-ai-chat-send">Send Chat</button>
									<button type="button" class="zo-ai-btn zo-ai-btn--gray zo-ai-clear">Reset</button>
								</div>
							</div>
						</div>

						<div class="zo-ai-card">
							<h3 class="zo-ai-card-title">Image Input</h3>

							<div class="zo-ai-stack">
								<div>
									<label class="zo-ai-label">Upload real image</label>
									<input type="file" accept="image/*" class="zo-ai-file" />
								</div>

								<div class="zo-ai-btn-row">
									<button type="button" class="zo-ai-btn zo-ai-btn--green zo-ai-use-upload">Use Uploaded Image</button>
									<button type="button" class="zo-ai-btn zo-ai-btn--purple zo-ai-photo-demo">Demo Photo Source</button>
								</div>

								<div>
									<label class="zo-ai-label">Prompt</label>
									<textarea class="zo-ai-textarea zo-ai-prompt" placeholder="Example: realistic robot portrait, blue glowing eyes, cinematic sky"></textarea>
								</div>

								<div class="zo-ai-row">
									<div>
										<label class="zo-ai-label">Style</label>
										<select class="zo-ai-select zo-ai-style">
											<option value="auto">Auto from prompt</option>
											<option value="portrait">Portrait</option>
											<option value="cinematic">Cinematic</option>
											<option value="cyberpunk">Cyberpunk</option>
											<option value="warm">Warm</option>
											<option value="illustration">Illustration</option>
										</select>
									</div>

									<div>
										<label class="zo-ai-label">Canvas size</label>
										<select class="zo-ai-select zo-ai-size">
											<option value="square">Square 1024x1024</option>
											<option value="landscape">Landscape 1280x720</option>
											<option value="portrait">Portrait 720x1280</option>
										</select>
									</div>
								</div>

								<div>
									<label class="zo-ai-label">Detail</label>
									<div class="zo-ai-range-wrap">
										<input type="range" min="0" max="100" value="70" class="zo-ai-range zo-ai-detail" />
										<div class="zo-ai-range-value zo-ai-detail-value">70</div>
									</div>
								</div>

								<div>
									<label class="zo-ai-label">Glow</label>
									<div class="zo-ai-range-wrap">
										<input type="range" min="0" max="100" value="65" class="zo-ai-range zo-ai-glow" />
										<div class="zo-ai-range-value zo-ai-glow-value">65</div>
									</div>
								</div>

								<div>
									<label class="zo-ai-label">Contrast</label>
									<div class="zo-ai-range-wrap">
										<input type="range" min="0" max="100" value="55" class="zo-ai-range zo-ai-contrast" />
										<div class="zo-ai-range-value zo-ai-contrast-value">55</div>
									</div>
								</div>

								<div>
									<label class="zo-ai-label">Saturation</label>
									<div class="zo-ai-range-wrap">
										<input type="range" min="0" max="100" value="40" class="zo-ai-range zo-ai-saturation" />
										<div class="zo-ai-range-value zo-ai-saturation-value">40</div>
									</div>
								</div>

								<div class="zo-ai-btn-row zo-ai-btn-row--triple">
									<button type="button" class="zo-ai-btn zo-ai-btn--blue zo-ai-render">Render</button>
									<button type="button" class="zo-ai-btn zo-ai-btn--orange zo-ai-art-demo">Art Demo</button>
									<button type="button" class="zo-ai-btn zo-ai-btn--pink zo-ai-save-png">Save PNG</button>
								</div>
							</div>
						</div>

						<div class="zo-ai-card">
							<h3 class="zo-ai-card-title">Quick Prompts</h3>
							<div class="zo-ai-chips">
								<button type="button" class="zo-ai-chip" data-prompt="realistic robot portrait, blue glowing eyes, cinematic sky">robot portrait</button>
								<button type="button" class="zo-ai-chip" data-prompt="mavi gözlü gerçekçi robot portresi, sinematik gökyüzü">robot portresi</button>
								<button type="button" class="zo-ai-chip" data-prompt="cyberpunk robot with neon blue glow">cyberpunk robot</button>
								<button type="button" class="zo-ai-chip" data-prompt="warm golden portrait with dramatic light">warm portrait</button>
								<button type="button" class="zo-ai-chip" data-prompt="gerçekçi portre, güçlü ışık, detaylı yüz">gerçekçi portre</button>
								<button type="button" class="zo-ai-chip" data-prompt="photo portrait, cinematic light, sharp details">photo portrait</button>
							</div>
						</div>
					</div>

					<div class="zo-ai-photo-main">
						<div class="zo-ai-main-grid">
							<div class="zo-ai-card zo-ai-preview-card">
								<h3 class="zo-ai-card-title">Preview</h3>

								<div class="zo-ai-preview-wrap">
									<canvas class="zo-ai-canvas" width="1024" height="1024"></canvas>
								</div>

								<div class="zo-ai-export-row">
									<button type="button" class="zo-ai-btn zo-ai-btn--pink zo-ai-save-png">Save PNG</button>
									<button type="button" class="zo-ai-btn zo-ai-btn--purple zo-ai-save-jpg">Save JPG</button>
									<button type="button" class="zo-ai-btn zo-ai-btn--green zo-ai-use-upload">Use Uploaded</button>
									<button type="button" class="zo-ai-btn zo-ai-btn--blue zo-ai-render">Render Again</button>
								</div>

								<div class="zo-ai-status" style="margin-top:12px;"></div>
							</div>

							<div class="zo-ai-stack">
								<div class="zo-ai-card">
									<h3 class="zo-ai-card-title">Stats</h3>
									<div class="zo-ai-stats">
										<div class="zo-ai-stat">
											<div class="zo-ai-stat-num zo-ai-stat-chats">0</div>
											<div class="zo-ai-stat-label">Messages</div>
										</div>
										<div class="zo-ai-stat">
											<div class="zo-ai-stat-num zo-ai-stat-renders">0</div>
											<div class="zo-ai-stat-label">Renders</div>
										</div>
										<div class="zo-ai-stat">
											<div class="zo-ai-stat-num zo-ai-stat-saves">0</div>
											<div class="zo-ai-stat-label">Downloads</div>
										</div>
									</div>
								</div>

								<div class="zo-ai-card">
									<h3 class="zo-ai-card-title">How to get better results</h3>
									<ul class="zo-ai-help-list">
										<li>For real-looking output, upload a real image first.</li>
										<li>Use prompts with words like realistic, portrait, cinematic, neon, warm, sharp, detailed.</li>
										<li>If your image is already good, use moderate contrast and glow.</li>
										<li>Use square for profile-style images and landscape for wallpapers.</li>
										<li>PNG is better for lossless quality. JPG makes a smaller file.</li>
									</ul>
								</div>

								<div class="zo-ai-card">
									<h3 class="zo-ai-card-title">Browser mode note</h3>
									<div class="zo-ai-note">
										This game runs entirely in the browser with no server calls and no outside AI services, matching the plugin rules in your uploaded instructions. It can chat in English and Turkish, restyle uploaded images, and export PNG or JPG in one file. :contentReference[oaicite:0]{index=0} :contentReference[oaicite:1]{index=1}
									</div>
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
	'slug'            => 'ai-photo-chat',
	'name'            => 'Mini AI Photo Chat Studio',
	'author'          => 'Asker',
	'description'     => 'Bilingual chat plus browser-based photo restyling with PNG and JPG export.',
	'render_callback' => 'zo_game_ai_photo_chat_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);