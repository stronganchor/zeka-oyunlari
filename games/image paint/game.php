<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 1180px;
	margin: 0 auto;
	font-family: Arial, sans-serif;
}

.zo-game-root--mini-paint .mini-paint {
	background: #ffffff;
	border: 1px solid #d7d7d7;
	border-radius: 16px;
	padding: 14px;
	box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
}

.zo-game-root--mini-paint .mini-paint__top {
	display: flex;
	flex-direction: column;
	gap: 12px;
	margin-bottom: 14px;
}

.zo-game-root--mini-paint .mini-paint__title {
	font-size: 24px;
	font-weight: 700;
	text-align: center;
	margin: 0;
}

.zo-game-root--mini-paint .mini-paint__help {
	text-align: center;
	font-size: 14px;
	color: #444;
	line-height: 1.5;
}

.zo-game-root--mini-paint .mini-paint__toolbar {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	align-items: center;
	justify-content: center;
	background: #f6f7fb;
	border: 1px solid #e3e6ef;
	border-radius: 14px;
	padding: 12px;
}

.zo-game-root--mini-paint .mini-paint__group {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
	align-items: center;
	justify-content: center;
	padding: 6px 8px;
	background: #ffffff;
	border: 1px solid #e5e5e5;
	border-radius: 12px;
}

.zo-game-root--mini-paint .mini-paint__label {
	font-size: 13px;
	font-weight: 700;
	color: #333;
}

.zo-game-root--mini-paint .mini-paint__button,
.zo-game-root--mini-paint .mini-paint__select,
.zo-game-root--mini-paint .mini-paint__range,
.zo-game-root--mini-paint .mini-paint__file,
.zo-game-root--mini-paint .mini-paint__color,
.zo-game-root--mini-paint .mini-paint__text-input {
	border-radius: 10px;
}

.zo-game-root--mini-paint .mini-paint__button,
.zo-game-root--mini-paint .mini-paint__select,
.zo-game-root--mini-paint .mini-paint__text-input {
	border: 1px solid #cfd5e3;
	background: #ffffff;
	color: #222;
	padding: 10px 12px;
	font-size: 14px;
}

.zo-game-root--mini-paint .mini-paint__button,
.zo-game-root--mini-paint .mini-paint__select {
	cursor: pointer;
	transition: background 0.15s ease, transform 0.15s ease;
}

.zo-game-root--mini-paint .mini-paint__button:hover,
.zo-game-root--mini-paint .mini-paint__select:hover {
	background: #f1f5ff;
}

.zo-game-root--mini-paint .mini-paint__button.is-active {
	background: #dce9ff;
	border-color: #8fb4ff;
	font-weight: 700;
}

.zo-game-root--mini-paint .mini-paint__button:active {
	transform: translateY(1px);
}

.zo-game-root--mini-paint .mini-paint__color {
	width: 44px;
	height: 44px;
	padding: 0;
	border: 1px solid #cfd5e3;
	background: #fff;
	cursor: pointer;
}

.zo-game-root--mini-paint .mini-paint__range {
	cursor: pointer;
}

.zo-game-root--mini-paint .mini-paint__value {
	min-width: 42px;
	text-align: center;
	font-size: 13px;
	font-weight: 700;
	color: #333;
}

.zo-game-root--mini-paint .mini-paint__text-input {
	min-width: 180px;
}

.zo-game-root--mini-paint .mini-paint__canvas-wrap {
	display: flex;
	justify-content: center;
	align-items: center;
	background:
		linear-gradient(45deg, #f3f3f3 25%, transparent 25%),
		linear-gradient(-45deg, #f3f3f3 25%, transparent 25%),
		linear-gradient(45deg, transparent 75%, #f3f3f3 75%),
		linear-gradient(-45deg, transparent 75%, #f3f3f3 75%);
	background-size: 20px 20px;
	background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
	border: 1px solid #d9deea;
	border-radius: 16px;
	padding: 12px;
	overflow: auto;
	position: relative;
}

.zo-game-root--mini-paint .mini-paint__canvas-stack {
	position: relative;
	width: 900px;
	height: 560px;
	max-width: 100%;
	flex: 0 0 auto;
}

.zo-game-root--mini-paint .mini-paint__canvas,
.zo-game-root--mini-paint .mini-paint__overlay {
	position: absolute;
	top: 0;
	left: 0;
	width: 900px;
	height: 560px;
	max-width: 100%;
	display: block;
	border-radius: 12px;
}

.zo-game-root--mini-paint .mini-paint__canvas {
	background: #ffffff;
	border: 1px solid #cfd5e3;
	touch-action: none;
	cursor: crosshair;
	z-index: 1;
}

.zo-game-root--mini-paint .mini-paint__overlay {
	pointer-events: none;
	z-index: 2;
}

.zo-game-root--mini-paint .mini-paint__status {
	margin-top: 12px;
	text-align: center;
	font-size: 14px;
	font-weight: 700;
	color: #333;
	min-height: 20px;
}

.zo-game-root--mini-paint .mini-paint__footer {
	margin-top: 12px;
	text-align: center;
	font-size: 12px;
	color: #666;
	line-height: 1.5;
}

@media (max-width: 980px) {
	.zo-game-root--mini-paint .mini-paint__canvas-stack,
	.zo-game-root--mini-paint .mini-paint__canvas,
	.zo-game-root--mini-paint .mini-paint__overlay {
		width: 800px;
		height: 500px;
	}
}

@media (max-width: 860px) {
	.zo-game-root--mini-paint .mini-paint__canvas-stack,
	.zo-game-root--mini-paint .mini-paint__canvas,
	.zo-game-root--mini-paint .mini-paint__overlay {
		width: 680px;
		height: 424px;
	}
}

@media (max-width: 720px) {
	.zo-game-root--mini-paint .mini-paint {
		padding: 10px;
	}

	.zo-game-root--mini-paint .mini-paint__title {
		font-size: 20px;
	}

	.zo-game-root--mini-paint .mini-paint__toolbar {
		padding: 10px;
		gap: 8px;
	}

	.zo-game-root--mini-paint .mini-paint__group {
		width: 100%;
		justify-content: center;
	}

	.zo-game-root--mini-paint .mini-paint__text-input {
		min-width: 100%;
	}

	.zo-game-root--mini-paint .mini-paint__canvas-stack,
	.zo-game-root--mini-paint .mini-paint__canvas,
	.zo-game-root--mini-paint .mini-paint__overlay {
		width: 520px;
		height: 325px;
	}
}

@media (max-width: 560px) {
	.zo-game-root--mini-paint .mini-paint__canvas-stack,
	.zo-game-root--mini-paint .mini-paint__canvas,
	.zo-game-root--mini-paint .mini-paint__overlay {
		width: 360px;
		height: 225px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--mini-paint');

	games.forEach(function (game) {
		const canvas = game.querySelector('.mini-paint__canvas');
		const overlay = game.querySelector('.mini-paint__overlay');
		const ctx = canvas ? canvas.getContext('2d') : null;
		const overlayCtx = overlay ? overlay.getContext('2d') : null;

		if (!canvas || !overlay || !ctx || !overlayCtx) {
			return;
		}

		const toolButtons = game.querySelectorAll('[data-tool]');
		const colorInput = game.querySelector('.mini-paint__color');
		const sizeInput = game.querySelector('.mini-paint__brush-size');
		const sizeValue = game.querySelector('.mini-paint__brush-size-value');
		const shapeSelect = game.querySelector('.mini-paint__shape-select');
		const fillToggle = game.querySelector('[data-fill-toggle]');
		const clearButton = game.querySelector('[data-action="clear"]');
		const undoButton = game.querySelector('[data-action="undo"]');
		const redoButton = game.querySelector('[data-action="redo"]');
		const savePngButton = game.querySelector('[data-action="save-png"]');
		const saveJpgButton = game.querySelector('[data-action="save-jpg"]');
		const uploadInput = game.querySelector('.mini-paint__file');
		const bgWhiteButton = game.querySelector('[data-bg="white"]');
		const bgTransparentButton = game.querySelector('[data-bg="transparent"]');
		const textInput = game.querySelector('.mini-paint__text-input');
		const textSizeInput = game.querySelector('.mini-paint__text-size');
		const textSizeValue = game.querySelector('.mini-paint__text-size-value');
		const fontSelect = game.querySelector('.mini-paint__font-select');
		const boldToggle = game.querySelector('[data-text-style="bold"]');
		const italicToggle = game.querySelector('[data-text-style="italic"]');
		const stickerSelect = game.querySelector('.mini-paint__sticker-select');
		const emojiSelect = game.querySelector('.mini-paint__emoji-select');
		const frameSelect = game.querySelector('.mini-paint__frame-select');
		const applyFrameButton = game.querySelector('[data-action="apply-frame"]');
		const flipHButton = game.querySelector('[data-action="flip-h"]');
		const flipVButton = game.querySelector('[data-action="flip-v"]');
		const rotateLeftButton = game.querySelector('[data-action="rotate-left"]');
		const rotateRightButton = game.querySelector('[data-action="rotate-right"]');
		const status = game.querySelector('.mini-paint__status');

		let currentTool = 'brush';
		let currentColor = colorInput ? colorInput.value : '#000000';
		let currentSize = sizeInput ? parseInt(sizeInput.value, 10) : 8;
		let currentShape = shapeSelect ? shapeSelect.value : 'rectangle';
		let fillShapes = false;
		let isDrawing = false;
		let startX = 0;
		let startY = 0;
		let lastX = 0;
		let lastY = 0;
		let hasTransparentBackground = false;
		let snapshotBeforeShape = null;
		let history = [];
		let historyIndex = -1;
		let textSize = textSizeInput ? parseInt(textSizeInput.value, 10) : 32;
		let textFont = fontSelect ? fontSelect.value : 'Arial';
		let textBold = false;
		let textItalic = false;
		let selection = null;
		let selectionImage = null;
		let selectionDragOffsetX = 0;
		let selectionDragOffsetY = 0;
		let movingSelection = false;
		let isMakingSelection = false;
		const maxHistory = 50;

		function setStatus(text) {
			if (status) {
				status.textContent = text;
			}
		}

		function initializeCanvas() {
			canvas.width = 900;
			canvas.height = 560;
			overlay.width = 900;
			overlay.height = 560;
			ctx.lineCap = 'round';
			ctx.lineJoin = 'round';
			ctx.fillStyle = '#ffffff';
			ctx.fillRect(0, 0, canvas.width, canvas.height);
			clearOverlay();
			saveHistoryState();
			setStatus('Ready to draw');
		}

		function clearOverlay() {
			overlayCtx.clearRect(0, 0, overlay.width, overlay.height);
		}

		function drawSelectionOverlay() {
			clearOverlay();

			if (!selection) {
				return;
			}

			overlayCtx.save();
			overlayCtx.setLineDash([8, 4]);
			overlayCtx.lineWidth = 2;
			overlayCtx.strokeStyle = '#1f70ff';
			overlayCtx.strokeRect(selection.x, selection.y, selection.width, selection.height);
			overlayCtx.restore();
		}

		function normalizeRect(x1, y1, x2, y2) {
			return {
				x: Math.min(x1, x2),
				y: Math.min(y1, y2),
				width: Math.abs(x2 - x1),
				height: Math.abs(y2 - y1)
			};
		}

		function saveHistoryState() {
			try {
				const data = canvas.toDataURL('image/png');
				if (historyIndex >= 0 && history[historyIndex] === data) {
					return;
				}
				history = history.slice(0, historyIndex + 1);
				history.push(data);
				if (history.length > maxHistory) {
					history.shift();
				}
				historyIndex = history.length - 1;
			} catch (err) {
				setStatus('Could not save drawing state');
			}
		}

		function restoreHistory(index) {
			if (index < 0 || index >= history.length) {
				return;
			}
			const img = new Image();
			img.onload = function () {
				ctx.clearRect(0, 0, canvas.width, canvas.height);
				if (!hasTransparentBackground) {
					ctx.fillStyle = '#ffffff';
					ctx.fillRect(0, 0, canvas.width, canvas.height);
				}
				ctx.drawImage(img, 0, 0);
				selection = null;
				selectionImage = null;
				clearOverlay();
			};
			img.src = history[index];
		}

		function undo() {
			if (historyIndex > 0) {
				historyIndex -= 1;
				restoreHistory(historyIndex);
				setStatus('Undo');
			}
		}

		function redo() {
			if (historyIndex < history.length - 1) {
				historyIndex += 1;
				restoreHistory(historyIndex);
				setStatus('Redo');
			}
		}

		function getPointerPos(event) {
			const rect = canvas.getBoundingClientRect();
			const touch = event.touches && event.touches[0] ? event.touches[0] : null;
			const clientX = touch ? touch.clientX : event.clientX;
			const clientY = touch ? touch.clientY : event.clientY;
			const scaleX = canvas.width / rect.width;
			const scaleY = canvas.height / rect.height;

			return {
				x: (clientX - rect.left) * scaleX,
				y: (clientY - rect.top) * scaleY
			};
		}

		function pointInSelection(x, y) {
			if (!selection) {
				return false;
			}
			return x >= selection.x &&
				x <= selection.x + selection.width &&
				y >= selection.y &&
				y <= selection.y + selection.height;
		}

		function applyStrokeStyle() {
			ctx.strokeStyle = currentColor;
			ctx.fillStyle = currentColor;
			ctx.lineWidth = currentSize;
		}

		function drawLine(x1, y1, x2, y2) {
			applyStrokeStyle();
			ctx.beginPath();
			ctx.moveTo(x1, y1);
			ctx.lineTo(x2, y2);
			ctx.stroke();
		}

		function drawTriangle(x, y, width, height, fill) {
			ctx.beginPath();
			ctx.moveTo(x + width / 2, y);
			ctx.lineTo(x + width, y + height);
			ctx.lineTo(x, y + height);
			ctx.closePath();
			if (fill) {
				ctx.fill();
			} else {
				ctx.stroke();
			}
		}

		function drawStar(cx, cy, outerRadius, innerRadius, fill) {
			let rot = Math.PI / 2 * 3;
			const spikes = 5;
			const step = Math.PI / spikes;

			ctx.beginPath();
			ctx.moveTo(cx, cy - outerRadius);

			for (let i = 0; i < spikes; i++) {
				ctx.lineTo(cx + Math.cos(rot) * outerRadius, cy + Math.sin(rot) * outerRadius);
				rot += step;

				ctx.lineTo(cx + Math.cos(rot) * innerRadius, cy + Math.sin(rot) * innerRadius);
				rot += step;
			}

			ctx.closePath();
			if (fill) {
				ctx.fill();
			} else {
				ctx.stroke();
			}
		}

		function drawHeart(x, y, width, height, fill) {
			const topCurveHeight = height * 0.3;
			ctx.beginPath();
			ctx.moveTo(x + width / 2, y + height);
			ctx.bezierCurveTo(
				x + width / 2, y + height - topCurveHeight,
				x, y + height - topCurveHeight,
				x, y + topCurveHeight
			);
			ctx.bezierCurveTo(
				x, y,
				x + width / 4, y,
				x + width / 2, y + topCurveHeight
			);
			ctx.bezierCurveTo(
				x + width * 0.75, y,
				x + width, y,
				x + width, y + topCurveHeight
			);
			ctx.bezierCurveTo(
				x + width, y + height - topCurveHeight,
				x + width / 2, y + height - topCurveHeight,
				x + width / 2, y + height
			);
			ctx.closePath();
			if (fill) {
				ctx.fill();
			} else {
				ctx.stroke();
			}
		}

		function drawShapeByType(shape, x, y, width, height, fill) {
			const absWidth = width;
			const absHeight = height;

			if (shape === 'rectangle') {
				if (fill) {
					ctx.fillRect(x, y, absWidth, absHeight);
				} else {
					ctx.strokeRect(x, y, absWidth, absHeight);
				}
			} else if (shape === 'square') {
				const size = Math.min(absWidth, absHeight);
				if (fill) {
					ctx.fillRect(x, y, size, size);
				} else {
					ctx.strokeRect(x, y, size, size);
				}
			} else if (shape === 'circle') {
				ctx.beginPath();
				ctx.ellipse(x + absWidth / 2, y + absHeight / 2, absWidth / 2, absHeight / 2, 0, 0, Math.PI * 2);
				if (fill) {
					ctx.fill();
				} else {
					ctx.stroke();
				}
			} else if (shape === 'triangle') {
				drawTriangle(x, y, absWidth, absHeight, fill);
			} else if (shape === 'star') {
				const radius = Math.min(absWidth, absHeight) / 2;
				drawStar(x + absWidth / 2, y + absHeight / 2, radius, radius * 0.45, fill);
			} else if (shape === 'heart') {
				drawHeart(x, y, absWidth, absHeight, fill);
			}
		}

		function drawPreviewShape(x, y) {
			if (!snapshotBeforeShape) {
				return;
			}

			ctx.putImageData(snapshotBeforeShape, 0, 0);
			applyStrokeStyle();

			const rect = normalizeRect(startX, startY, x, y);
			drawShapeByType(currentShape, rect.x, rect.y, rect.width, rect.height, fillShapes);
		}

		function floodFill(startXFill, startYFill, fillColorHex) {
			const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
			const data = imageData.data;
			const width = canvas.width;
			const height = canvas.height;
			const stack = [[Math.floor(startXFill), Math.floor(startYFill)]];
			const startPos = (Math.floor(startYFill) * width + Math.floor(startXFill)) * 4;

			const startR = data[startPos];
			const startG = data[startPos + 1];
			const startB = data[startPos + 2];
			const startA = data[startPos + 3];

			const fillR = parseInt(fillColorHex.slice(1, 3), 16);
			const fillG = parseInt(fillColorHex.slice(3, 5), 16);
			const fillB = parseInt(fillColorHex.slice(5, 7), 16);
			const fillA = 255;

			if (startR === fillR && startG === fillG && startB === fillB && startA === fillA) {
				return;
			}

			function matchesStart(index) {
				return data[index] === startR &&
					data[index + 1] === startG &&
					data[index + 2] === startB &&
					data[index + 3] === startA;
			}

			while (stack.length) {
				const point = stack.pop();
				const px = point[0];
				const py = point[1];

				if (px < 0 || px >= width || py < 0 || py >= height) {
					continue;
				}

				const index = (py * width + px) * 4;

				if (!matchesStart(index)) {
					continue;
				}

				data[index] = fillR;
				data[index + 1] = fillG;
				data[index + 2] = fillB;
				data[index + 3] = fillA;

				stack.push([px + 1, py]);
				stack.push([px - 1, py]);
				stack.push([px, py + 1]);
				stack.push([px, py - 1]);
			}

			ctx.putImageData(imageData, 0, 0);
		}

		function stampShape(x, y) {
			applyStrokeStyle();
			const size = Math.max(currentSize * 4, 24);
			drawShapeByType(currentShape, x - size / 2, y - size / 2, size, size, fillShapes);
		}

		function getTextFontString() {
			const parts = [];
			if (textItalic) {
				parts.push('italic');
			}
			if (textBold) {
				parts.push('bold');
			}
			parts.push(textSize + 'px');
			parts.push(textFont);
			return parts.join(' ');
		}

		function placeText(x, y) {
			const text = textInput ? textInput.value.trim() : '';
			if (!text) {
				setStatus('Type some text first');
				return;
			}

			ctx.save();
			ctx.fillStyle = currentColor;
			ctx.font = getTextFontString();
			ctx.textBaseline = 'top';

			const lines = text.split(/\r?\n/);
			const lineHeight = Math.round(textSize * 1.25);

			lines.forEach(function (line, index) {
				ctx.fillText(line, x, y + (index * lineHeight));
			});

			ctx.restore();
			saveHistoryState();
			setStatus('Text added');
		}

		function drawSticker(type, x, y) {
			const size = Math.max(currentSize * 5, 40);

			ctx.save();
			ctx.translate(x, y);
			ctx.lineWidth = 3;
			ctx.strokeStyle = currentColor;
			ctx.fillStyle = currentColor;

			if (type === 'star') {
				drawStar(0, 0, size / 2, size / 4, true);
			} else if (type === 'heart') {
				drawHeart(-size / 2, -size / 2, size, size, true);
			} else if (type === 'flower') {
				for (let i = 0; i < 6; i++) {
					const angle = (Math.PI * 2 / 6) * i;
					ctx.beginPath();
					ctx.arc(Math.cos(angle) * size * 0.22, Math.sin(angle) * size * 0.22, size * 0.16, 0, Math.PI * 2);
					ctx.fill();
				}
				ctx.beginPath();
				ctx.fillStyle = '#ffd54f';
				ctx.arc(0, 0, size * 0.14, 0, Math.PI * 2);
				ctx.fill();
			} else if (type === 'crown') {
				ctx.beginPath();
				ctx.moveTo(-size / 2, size / 4);
				ctx.lineTo(-size / 3, -size / 4);
				ctx.lineTo(-size / 8, size / 8);
				ctx.lineTo(0, -size / 3);
				ctx.lineTo(size / 8, size / 8);
				ctx.lineTo(size / 3, -size / 4);
				ctx.lineTo(size / 2, size / 4);
				ctx.closePath();
				ctx.fill();
			} else if (type === 'lightning') {
				ctx.beginPath();
				ctx.moveTo(-size * 0.1, -size / 2);
				ctx.lineTo(size * 0.15, -size * 0.1);
				ctx.lineTo(0, -size * 0.1);
				ctx.lineTo(size * 0.1, size / 2);
				ctx.lineTo(-size * 0.15, size * 0.05);
				ctx.lineTo(0, size * 0.05);
				ctx.closePath();
				ctx.fill();
			}

			ctx.restore();
			saveHistoryState();
			setStatus('Sticker added');
		}

		function placeEmoji(x, y) {
			const emoji = emojiSelect ? emojiSelect.value : '😀';
			ctx.save();
			ctx.font = textSize + 'px Arial';
			ctx.textBaseline = 'top';
			ctx.fillText(emoji, x, y);
			ctx.restore();
			saveHistoryState();
			setStatus('Emoji added');
		}

		function applyFrame() {
			const frameType = frameSelect ? frameSelect.value : 'none';
			if (frameType === 'none') {
				setStatus('Choose a frame first');
				return;
			}

			ctx.save();

			if (frameType === 'simple') {
				ctx.lineWidth = 12;
				ctx.strokeStyle = currentColor;
				ctx.strokeRect(6, 6, canvas.width - 12, canvas.height - 12);
			} else if (frameType === 'double') {
				ctx.lineWidth = 10;
				ctx.strokeStyle = currentColor;
				ctx.strokeRect(8, 8, canvas.width - 16, canvas.height - 16);
				ctx.lineWidth = 4;
				ctx.strokeRect(28, 28, canvas.width - 56, canvas.height - 56);
			} else if (frameType === 'dashed') {
				ctx.lineWidth = 8;
				ctx.strokeStyle = currentColor;
				ctx.setLineDash([18, 10]);
				ctx.strokeRect(10, 10, canvas.width - 20, canvas.height - 20);
			} else if (frameType === 'photo') {
				ctx.fillStyle = '#ffffff';
				ctx.fillRect(0, 0, canvas.width, 30);
				ctx.fillRect(0, canvas.height - 30, canvas.width, 30);
				ctx.fillRect(0, 0, 30, canvas.height);
				ctx.fillRect(canvas.width - 30, 0, 30, canvas.height);

				ctx.lineWidth = 2;
				ctx.strokeStyle = '#cccccc';
				ctx.strokeRect(15, 15, canvas.width - 30, canvas.height - 30);
			}

			ctx.restore();
			saveHistoryState();
			setStatus('Frame applied');
		}

		function commitSelectionMove() {
			if (!selection || !selectionImage) {
				return;
			}

			if (!hasTransparentBackground) {
				ctx.fillStyle = '#ffffff';
				ctx.fillRect(selection.x, selection.y, selection.width, selection.height);
			} else {
				ctx.clearRect(selection.x, selection.y, selection.width, selection.height);
			}

			ctx.drawImage(selectionImage, selection.x, selection.y, selection.width, selection.height);
			saveHistoryState();
			drawSelectionOverlay();
		}

		function setTool(tool) {
			currentTool = tool;
			toolButtons.forEach(function (button) {
				button.classList.toggle('is-active', button.getAttribute('data-tool') === tool);
			});
			setStatus('Tool: ' + tool);
		}

		function flipCanvas(horizontal) {
			const temp = document.createElement('canvas');
			temp.width = canvas.width;
			temp.height = canvas.height;
			const tctx = temp.getContext('2d');
			tctx.drawImage(canvas, 0, 0);

			ctx.save();
			ctx.clearRect(0, 0, canvas.width, canvas.height);

			if (!hasTransparentBackground) {
				ctx.fillStyle = '#ffffff';
				ctx.fillRect(0, 0, canvas.width, canvas.height);
			}

			if (horizontal) {
				ctx.translate(canvas.width, 0);
				ctx.scale(-1, 1);
			} else {
				ctx.translate(0, canvas.height);
				ctx.scale(1, -1);
			}

			ctx.drawImage(temp, 0, 0);
			ctx.restore();
			saveHistoryState();
			setStatus(horizontal ? 'Flipped horizontally' : 'Flipped vertically');
		}

		function rotateCanvas(clockwise) {
			const temp = document.createElement('canvas');
			temp.width = canvas.width;
			temp.height = canvas.height;
			const tctx = temp.getContext('2d');
			tctx.drawImage(canvas, 0, 0);

			const rotated = document.createElement('canvas');
			rotated.width = canvas.height;
			rotated.height = canvas.width;
			const rctx = rotated.getContext('2d');

			rctx.save();
			if (clockwise) {
				rctx.translate(rotated.width, 0);
				rctx.rotate(Math.PI / 2);
			} else {
				rctx.translate(0, rotated.height);
				rctx.rotate(-Math.PI / 2);
			}
			rctx.drawImage(temp, 0, 0);
			rctx.restore();

			ctx.save();
			ctx.clearRect(0, 0, canvas.width, canvas.height);
			if (!hasTransparentBackground) {
				ctx.fillStyle = '#ffffff';
				ctx.fillRect(0, 0, canvas.width, canvas.height);
			}

			const scale = Math.min(canvas.width / rotated.width, canvas.height / rotated.height);
			const drawWidth = rotated.width * scale;
			const drawHeight = rotated.height * scale;
			const drawX = (canvas.width - drawWidth) / 2;
			const drawY = (canvas.height - drawHeight) / 2;

			ctx.drawImage(rotated, drawX, drawY, drawWidth, drawHeight);
			ctx.restore();
			saveHistoryState();
			setStatus(clockwise ? 'Rotated right' : 'Rotated left');
		}

		function clearCanvas() {
			selection = null;
			selectionImage = null;
			clearOverlay();

			if (hasTransparentBackground) {
				ctx.clearRect(0, 0, canvas.width, canvas.height);
			} else {
				ctx.fillStyle = '#ffffff';
				ctx.fillRect(0, 0, canvas.width, canvas.height);
			}
			saveHistoryState();
			setStatus('Canvas cleared');
		}

		function saveImage(type) {
			const mime = type === 'jpg' ? 'image/jpeg' : 'image/png';
			const extension = type === 'jpg' ? 'jpg' : 'png';
			const tempCanvas = document.createElement('canvas');
			tempCanvas.width = canvas.width;
			tempCanvas.height = canvas.height;
			const tempCtx = tempCanvas.getContext('2d');

			if (mime === 'image/jpeg') {
				tempCtx.fillStyle = '#ffffff';
				tempCtx.fillRect(0, 0, tempCanvas.width, tempCanvas.height);
			}

			tempCtx.drawImage(canvas, 0, 0);

			const link = document.createElement('a');
			link.href = tempCanvas.toDataURL(mime, 0.92);
			link.download = 'mini-paint-' + Date.now() + '.' + extension;
			document.body.appendChild(link);
			link.click();
			document.body.removeChild(link);
			setStatus('Saved as ' + extension.toUpperCase());
		}

		function handleUpload(event) {
			const file = event.target.files && event.target.files[0] ? event.target.files[0] : null;
			if (!file) {
				return;
			}

			const reader = new FileReader();
			reader.onload = function (loadEvent) {
				const img = new Image();
				img.onload = function () {
					if (!hasTransparentBackground) {
						ctx.fillStyle = '#ffffff';
						ctx.fillRect(0, 0, canvas.width, canvas.height);
					} else {
						ctx.clearRect(0, 0, canvas.width, canvas.height);
					}

					const canvasRatio = canvas.width / canvas.height;
					const imgRatio = img.width / img.height;
					let drawWidth;
					let drawHeight;
					let drawX;
					let drawY;

					if (imgRatio > canvasRatio) {
						drawWidth = canvas.width;
						drawHeight = canvas.width / imgRatio;
						drawX = 0;
						drawY = (canvas.height - drawHeight) / 2;
					} else {
						drawHeight = canvas.height;
						drawWidth = canvas.height * imgRatio;
						drawX = (canvas.width - drawWidth) / 2;
						drawY = 0;
					}

					ctx.drawImage(img, drawX, drawY, drawWidth, drawHeight);
					saveHistoryState();
					setStatus('Image loaded');
				};
				img.src = loadEvent.target.result;
			};
			reader.readAsDataURL(file);
			event.target.value = '';
		}

		function setCanvasBackground(transparent) {
			hasTransparentBackground = !!transparent;

			if (!transparent) {
				const temp = document.createElement('canvas');
				temp.width = canvas.width;
				temp.height = canvas.height;
				const tempCtx = temp.getContext('2d');
				tempCtx.drawImage(canvas, 0, 0);
				ctx.fillStyle = '#ffffff';
				ctx.fillRect(0, 0, canvas.width, canvas.height);
				ctx.drawImage(temp, 0, 0);
			}

			saveHistoryState();
			setStatus(transparent ? 'Transparent background selected' : 'White background selected');
		}

		function startDrawing(event) {
			event.preventDefault();
			const pos = getPointerPos(event);
			startX = pos.x;
			startY = pos.y;
			lastX = pos.x;
			lastY = pos.y;
			isDrawing = true;

			if (currentTool === 'brush' || currentTool === 'eraser') {
				ctx.beginPath();
				ctx.moveTo(lastX, lastY);
				return;
			}

			if (currentTool === 'shape') {
				snapshotBeforeShape = ctx.getImageData(0, 0, canvas.width, canvas.height);
				return;
			}

			if (currentTool === 'fill') {
				floodFill(pos.x, pos.y, currentColor);
				isDrawing = false;
				saveHistoryState();
				setStatus('Filled area');
				return;
			}

			if (currentTool === 'stamp') {
				stampShape(pos.x, pos.y);
				isDrawing = false;
				saveHistoryState();
				setStatus('Stamped shape');
				return;
			}

			if (currentTool === 'text') {
				placeText(pos.x, pos.y);
				isDrawing = false;
				return;
			}

			if (currentTool === 'sticker') {
				drawSticker(stickerSelect ? stickerSelect.value : 'star', pos.x, pos.y);
				isDrawing = false;
				return;
			}

			if (currentTool === 'emoji') {
				placeEmoji(pos.x, pos.y);
				isDrawing = false;
				return;
			}

			if (currentTool === 'select') {
				if (selection && pointInSelection(pos.x, pos.y) && selectionImage) {
					movingSelection = true;
					selectionDragOffsetX = pos.x - selection.x;
					selectionDragOffsetY = pos.y - selection.y;
					return;
				}

				selection = null;
				selectionImage = null;
				isMakingSelection = true;
				drawSelectionOverlay();
				return;
			}

			if (currentTool === 'crop') {
				selection = null;
				selectionImage = null;
				isMakingSelection = true;
				drawSelectionOverlay();
			}
		}

		function moveDrawing(event) {
			if (!isDrawing) {
				return;
			}

			event.preventDefault();
			const pos = getPointerPos(event);

			if (currentTool === 'brush') {
				applyStrokeStyle();
				drawLine(lastX, lastY, pos.x, pos.y);
				lastX = pos.x;
				lastY = pos.y;
				return;
			}

			if (currentTool === 'eraser') {
				ctx.save();
				ctx.globalCompositeOperation = hasTransparentBackground ? 'destination-out' : 'source-over';
				ctx.strokeStyle = hasTransparentBackground ? 'rgba(0,0,0,1)' : '#ffffff';
				ctx.lineWidth = currentSize;
				ctx.lineCap = 'round';
				ctx.lineJoin = 'round';
				ctx.beginPath();
				ctx.moveTo(lastX, lastY);
				ctx.lineTo(pos.x, pos.y);
				ctx.stroke();
				ctx.restore();
				lastX = pos.x;
				lastY = pos.y;
				return;
			}

			if (currentTool === 'shape') {
				drawPreviewShape(pos.x, pos.y);
				return;
			}

			if ((currentTool === 'select' || currentTool === 'crop') && isMakingSelection) {
				selection = normalizeRect(startX, startY, pos.x, pos.y);
				drawSelectionOverlay();
				return;
			}

			if (currentTool === 'select' && movingSelection && selection) {
				selection.x = Math.max(0, Math.min(canvas.width - selection.width, pos.x - selectionDragOffsetX));
				selection.y = Math.max(0, Math.min(canvas.height - selection.height, pos.y - selectionDragOffsetY));
				drawSelectionOverlay();
			}
		}

		function endDrawing(event) {
			if (!isDrawing) {
				return;
			}

			if (event) {
				event.preventDefault();
			}

			if (currentTool === 'shape') {
				const pos = event ? getPointerPos(event) : { x: lastX, y: lastY };
				drawPreviewShape(pos.x, pos.y);
				snapshotBeforeShape = null;
				saveHistoryState();
			}

			if (currentTool === 'brush' || currentTool === 'eraser') {
				saveHistoryState();
			}

			if (currentTool === 'select') {
				if (isMakingSelection && selection && selection.width > 1 && selection.height > 1) {
					const temp = document.createElement('canvas');
					temp.width = selection.width;
					temp.height = selection.height;
					const tctx = temp.getContext('2d');
					tctx.drawImage(
						canvas,
						selection.x, selection.y, selection.width, selection.height,
						0, 0, selection.width, selection.height
					);
					selectionImage = temp;
					drawSelectionOverlay();
					setStatus('Selection ready. Drag it to move.');
				} else if (movingSelection) {
					commitSelectionMove();
					setStatus('Selection moved');
				}
				isMakingSelection = false;
				movingSelection = false;
			}

			if (currentTool === 'crop') {
				if (isMakingSelection && selection && selection.width > 1 && selection.height > 1) {
					const cropped = document.createElement('canvas');
					cropped.width = selection.width;
					cropped.height = selection.height;
					const cctx = cropped.getContext('2d');
					cctx.drawImage(
						canvas,
						selection.x, selection.y, selection.width, selection.height,
						0, 0, selection.width, selection.height
					);

					ctx.clearRect(0, 0, canvas.width, canvas.height);
					if (!hasTransparentBackground) {
						ctx.fillStyle = '#ffffff';
						ctx.fillRect(0, 0, canvas.width, canvas.height);
					}

					const scale = Math.min(canvas.width / cropped.width, canvas.height / cropped.height);
					const drawWidth = cropped.width * scale;
					const drawHeight = cropped.height * scale;
					const drawX = (canvas.width - drawWidth) / 2;
					const drawY = (canvas.height - drawHeight) / 2;

					ctx.drawImage(cropped, drawX, drawY, drawWidth, drawHeight);
					saveHistoryState();
					setStatus('Image cropped');
				}
				selection = null;
				selectionImage = null;
				isMakingSelection = false;
				clearOverlay();
			}

			isDrawing = false;
		}

		toolButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				setTool(button.getAttribute('data-tool'));
			});
		});

		if (colorInput) {
			colorInput.addEventListener('input', function () {
				currentColor = colorInput.value;
				setStatus('Color changed');
			});
		}

		if (sizeInput) {
			sizeInput.addEventListener('input', function () {
				currentSize = parseInt(sizeInput.value, 10);
				if (sizeValue) {
					sizeValue.textContent = currentSize + 'px';
				}
			});
		}

		if (shapeSelect) {
			shapeSelect.addEventListener('change', function () {
				currentShape = shapeSelect.value;
				setStatus('Shape: ' + currentShape);
			});
		}

		if (fillToggle) {
			fillToggle.addEventListener('click', function () {
				fillShapes = !fillShapes;
				fillToggle.classList.toggle('is-active', fillShapes);
				fillToggle.textContent = fillShapes ? 'Filled: On' : 'Filled: Off';
				setStatus(fillShapes ? 'Filled shapes on' : 'Filled shapes off');
			});
		}

		if (textSizeInput) {
			textSizeInput.addEventListener('input', function () {
				textSize = parseInt(textSizeInput.value, 10);
				if (textSizeValue) {
					textSizeValue.textContent = textSize + 'px';
				}
			});
		}

		if (fontSelect) {
			fontSelect.addEventListener('change', function () {
				textFont = fontSelect.value;
				setStatus('Font changed');
			});
		}

		if (boldToggle) {
			boldToggle.addEventListener('click', function () {
				textBold = !textBold;
				boldToggle.classList.toggle('is-active', textBold);
				setStatus(textBold ? 'Bold on' : 'Bold off');
			});
		}

		if (italicToggle) {
			italicToggle.addEventListener('click', function () {
				textItalic = !textItalic;
				italicToggle.classList.toggle('is-active', textItalic);
				setStatus(textItalic ? 'Italic on' : 'Italic off');
			});
		}

		if (clearButton) {
			clearButton.addEventListener('click', clearCanvas);
		}

		if (undoButton) {
			undoButton.addEventListener('click', undo);
		}

		if (redoButton) {
			redoButton.addEventListener('click', redo);
		}

		if (savePngButton) {
			savePngButton.addEventListener('click', function () {
				saveImage('png');
			});
		}

		if (saveJpgButton) {
			saveJpgButton.addEventListener('click', function () {
				saveImage('jpg');
			});
		}

		if (uploadInput) {
			uploadInput.addEventListener('change', handleUpload);
		}

		if (bgWhiteButton) {
			bgWhiteButton.addEventListener('click', function () {
				setCanvasBackground(false);
			});
		}

		if (bgTransparentButton) {
			bgTransparentButton.addEventListener('click', function () {
				setCanvasBackground(true);
			});
		}

		if (applyFrameButton) {
			applyFrameButton.addEventListener('click', applyFrame);
		}

		if (flipHButton) {
			flipHButton.addEventListener('click', function () {
				flipCanvas(true);
			});
		}

		if (flipVButton) {
			flipVButton.addEventListener('click', function () {
				flipCanvas(false);
			});
		}

		if (rotateLeftButton) {
			rotateLeftButton.addEventListener('click', function () {
				rotateCanvas(false);
			});
		}

		if (rotateRightButton) {
			rotateRightButton.addEventListener('click', function () {
				rotateCanvas(true);
			});
		}

		canvas.addEventListener('mousedown', startDrawing);
		canvas.addEventListener('mousemove', moveDrawing);
		window.addEventListener('mouseup', endDrawing);

		canvas.addEventListener('touchstart', startDrawing, { passive: false });
		canvas.addEventListener('touchmove', moveDrawing, { passive: false });
		window.addEventListener('touchend', endDrawing, { passive: false });

		game.addEventListener('keydown', function (event) {
			const key = event.key.toLowerCase();

			if ((event.ctrlKey || event.metaKey) && key === 'z') {
				event.preventDefault();
				if (event.shiftKey) {
					redo();
				} else {
					undo();
				}
				return;
			}

			if ((event.ctrlKey || event.metaKey) && key === 'y') {
				event.preventDefault();
				redo();
				return;
			}

			if ((event.ctrlKey || event.metaKey) && key === 's') {
				event.preventDefault();
				saveImage('png');
				return;
			}

			if (key === 'b') {
				setTool('brush');
			} else if (key === 'e') {
				setTool('eraser');
			} else if (key === 'f') {
				setTool('fill');
			} else if (key === 't') {
				setTool('text');
			} else if (key === 'm') {
				setTool('select');
			} else if (key === 'c') {
				setTool('crop');
			} else if (key === 's' && !event.ctrlKey && !event.metaKey) {
				setTool('shape');
			} else if (key === 'k') {
				setTool('sticker');
			} else if (key === 'j') {
				setTool('emoji');
			} else if (key === 'delete' && selection) {
				if (!hasTransparentBackground) {
					ctx.fillStyle = '#ffffff';
					ctx.fillRect(selection.x, selection.y, selection.width, selection.height);
				} else {
					ctx.clearRect(selection.x, selection.y, selection.width, selection.height);
				}
				saveHistoryState();
				selection = null;
				selectionImage = null;
				clearOverlay();
				setStatus('Selection deleted');
			}
		});

		game.setAttribute('tabindex', '0');

		initializeCanvas();
		setTool('brush');

		if (sizeValue) {
			sizeValue.textContent = currentSize + 'px';
		}

		if (textSizeValue) {
			textSizeValue.textContent = textSize + 'px';
		}
	});
});
JS;

if (!function_exists('zo_game_mini_paint_render')) {
	function zo_game_mini_paint_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-mini-paint-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--mini-paint" id="<?php echo esc_attr($instance_id); ?>">
			<div class="mini-paint">
				<div class="mini-paint__top">
					<h2 class="mini-paint__title">Mini Paint Studio</h2>
					<div class="mini-paint__help">
						Paint style editor with drawing, text, stickers, emoji, selection, crop, flip, rotate, and frames.
					</div>
				</div>

				<div class="mini-paint__toolbar">
					<div class="mini-paint__group">
						<span class="mini-paint__label">Tools</span>
						<button type="button" class="mini-paint__button is-active" data-tool="brush">Brush</button>
						<button type="button" class="mini-paint__button" data-tool="eraser">Eraser</button>
						<button type="button" class="mini-paint__button" data-tool="fill">Fill</button>
						<button type="button" class="mini-paint__button" data-tool="shape">Shape Drag</button>
						<button type="button" class="mini-paint__button" data-tool="stamp">Shape Stamp</button>
						<button type="button" class="mini-paint__button" data-tool="text">Text</button>
						<button type="button" class="mini-paint__button" data-tool="select">Select</button>
						<button type="button" class="mini-paint__button" data-tool="crop">Crop</button>
						<button type="button" class="mini-paint__button" data-tool="sticker">Sticker</button>
						<button type="button" class="mini-paint__button" data-tool="emoji">Emoji</button>
					</div>

					<div class="mini-paint__group">
						<span class="mini-paint__label">Color</span>
						<input type="color" class="mini-paint__color" value="#000000" aria-label="Pick color">
					</div>

					<div class="mini-paint__group">
						<span class="mini-paint__label">Brush</span>
						<input type="range" class="mini-paint__range mini-paint__brush-size" min="1" max="60" value="8" aria-label="Brush size">
						<span class="mini-paint__value mini-paint__brush-size-value">8px</span>
					</div>

					<div class="mini-paint__group">
						<span class="mini-paint__label">Shape</span>
						<select class="mini-paint__select mini-paint__shape-select" aria-label="Shape picker">
							<option value="rectangle">Rectangle</option>
							<option value="square">Square</option>
							<option value="circle">Circle</option>
							<option value="triangle">Triangle</option>
							<option value="star">Star</option>
							<option value="heart">Heart</option>
						</select>
						<button type="button" class="mini-paint__button" data-fill-toggle>Filled: Off</button>
					</div>

					<div class="mini-paint__group">
						<span class="mini-paint__label">Text</span>
						<input type="text" class="mini-paint__text-input" placeholder="Type text here" aria-label="Text input">
						<input type="range" class="mini-paint__range mini-paint__text-size" min="8" max="120" value="32" aria-label="Text size">
						<span class="mini-paint__value mini-paint__text-size-value">32px</span>
						<select class="mini-paint__select mini-paint__font-select" aria-label="Font picker">
							<option value="Arial">Arial</option>
							<option value="Verdana">Verdana</option>
							<option value="Tahoma">Tahoma</option>
							<option value="'Trebuchet MS'">Trebuchet</option>
							<option value="'Times New Roman'">Times New Roman</option>
							<option value="Georgia">Georgia</option>
							<option value="'Courier New'">Courier New</option>
						</select>
						<button type="button" class="mini-paint__button" data-text-style="bold">Bold</button>
						<button type="button" class="mini-paint__button" data-text-style="italic">Italic</button>
					</div>

					<div class="mini-paint__group">
						<span class="mini-paint__label">Sticker</span>
						<select class="mini-paint__select mini-paint__sticker-select" aria-label="Sticker picker">
							<option value="star">Star</option>
							<option value="heart">Heart</option>
							<option value="flower">Flower</option>
							<option value="crown">Crown</option>
							<option value="lightning">Lightning</option>
						</select>
					</div>

					<div class="mini-paint__group">
						<span class="mini-paint__label">Emoji</span>
						<select class="mini-paint__select mini-paint__emoji-select" aria-label="Emoji picker">
							<option value="😀">😀</option>
							<option value="😎">😎</option>
							<option value="🔥">🔥</option>
							<option value="⭐">⭐</option>
							<option value="❤️">❤️</option>
							<option value="🎉">🎉</option>
							<option value="🚀">🚀</option>
							<option value="👑">👑</option>
						</select>
					</div>

					<div class="mini-paint__group">
						<span class="mini-paint__label">Frame</span>
						<select class="mini-paint__select mini-paint__frame-select" aria-label="Frame picker">
							<option value="none">Choose</option>
							<option value="simple">Simple</option>
							<option value="double">Double</option>
							<option value="dashed">Dashed</option>
							<option value="photo">Photo</option>
						</select>
						<button type="button" class="mini-paint__button" data-action="apply-frame">Apply Frame</button>
					</div>

					<div class="mini-paint__group">
						<span class="mini-paint__label">Image</span>
						<input type="file" class="mini-paint__file" accept="image/png,image/jpeg,image/webp" aria-label="Upload image">
					</div>

					<div class="mini-paint__group">
						<span class="mini-paint__label">Background</span>
						<button type="button" class="mini-paint__button" data-bg="white">White</button>
						<button type="button" class="mini-paint__button" data-bg="transparent">Transparent</button>
					</div>

					<div class="mini-paint__group">
						<span class="mini-paint__label">Transform</span>
						<button type="button" class="mini-paint__button" data-action="flip-h">Flip H</button>
						<button type="button" class="mini-paint__button" data-action="flip-v">Flip V</button>
						<button type="button" class="mini-paint__button" data-action="rotate-left">Rotate Left</button>
						<button type="button" class="mini-paint__button" data-action="rotate-right">Rotate Right</button>
					</div>

					<div class="mini-paint__group">
						<span class="mini-paint__label">Actions</span>
						<button type="button" class="mini-paint__button" data-action="undo">Undo</button>
						<button type="button" class="mini-paint__button" data-action="redo">Redo</button>
						<button type="button" class="mini-paint__button" data-action="clear">Clear</button>
						<button type="button" class="mini-paint__button" data-action="save-png">Save PNG</button>
						<button type="button" class="mini-paint__button" data-action="save-jpg">Save JPG</button>
					</div>
				</div>

				<div class="mini-paint__canvas-wrap">
					<div class="mini-paint__canvas-stack">
						<canvas class="mini-paint__canvas" width="900" height="560" aria-label="Drawing canvas"></canvas>
						<canvas class="mini-paint__overlay" width="900" height="560" aria-hidden="true"></canvas>
					</div>
				</div>

				<div class="mini-paint__status" aria-live="polite">Ready to draw</div>

				<div class="mini-paint__footer">
					Shortcuts: B brush, E eraser, F fill, S shape, T text, M select, C crop, K sticker, J emoji, Ctrl+Z undo, Ctrl+Y redo, Ctrl+S save PNG, Delete removes selection.
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'mini-paint',
	'name'            => 'Mini Paint Studio',
	'author'          => 'Asker',
	'description'     => 'A simple Paint-style image editor with shapes, text, selection, crop, stickers, emoji, frames, flip, rotate, and keyboard shortcuts.',
	'render_callback' => 'zo_game_mini_paint_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);