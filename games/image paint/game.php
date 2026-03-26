<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 1100px;
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

.zo-game-root--mini-paint .mini-paint__text-input {
	min-width: 180px;
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
}

.zo-game-root--mini-paint .mini-paint__canvas {
	background: #ffffff;
	border: 1px solid #cfd5e3;
	border-radius: 12px;
	touch-action: none;
	max-width: 100%;
	height: auto;
	display: block;
	cursor: crosshair;
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
}

@media (max-width: 700px) {
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
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--mini-paint');

	games.forEach(function (game) {
		const canvas = game.querySelector('.mini-paint__canvas');
		const ctx = canvas ? canvas.getContext('2d') : null;

		if (!canvas || !ctx) {
			return;
		}

		const toolButtons = game.querySelectorAll('[data-tool]');
		const colorInput = game.querySelector('.mini-paint__color');
		const sizeInput = game.querySelector('.mini-paint__range');
		const sizeValue = game.querySelector('.mini-paint__value');
		const shapeSelect = game.querySelector('.mini-paint__select');
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
		const maxHistory = 40;

		function setStatus(text) {
			if (status) {
				status.textContent = text;
			}
		}

		function initializeCanvas() {
			canvas.width = 900;
			canvas.height = 560;
			canvas.style.width = '100%';
			canvas.style.maxWidth = '900px';
			canvas.style.height = 'auto';
			ctx.lineCap = 'round';
			ctx.lineJoin = 'round';
			ctx.fillStyle = '#ffffff';
			ctx.fillRect(0, 0, canvas.width, canvas.height);
			setStatus('Ready to draw');
			saveHistoryState();
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

		function drawPreviewShape(x, y) {
			if (!snapshotBeforeShape) {
				return;
			}

			ctx.putImageData(snapshotBeforeShape, 0, 0);
			applyStrokeStyle();

			const width = x - startX;
			const height = y - startY;
			const size = Math.max(Math.abs(width), Math.abs(height));
			const dirX = width < 0 ? -1 : 1;
			const dirY = height < 0 ? -1 : 1;

			if (currentShape === 'rectangle') {
				if (fillShapes) {
					ctx.fillRect(startX, startY, width, height);
				} else {
					ctx.strokeRect(startX, startY, width, height);
				}
			} else if (currentShape === 'square') {
				const sqW = size * dirX;
				const sqH = size * dirY;
				if (fillShapes) {
					ctx.fillRect(startX, startY, sqW, sqH);
				} else {
					ctx.strokeRect(startX, startY, sqW, sqH);
				}
			} else if (currentShape === 'circle') {
				const radius = Math.sqrt((width * width) + (height * height));
				ctx.beginPath();
				ctx.arc(startX, startY, radius, 0, Math.PI * 2);
				if (fillShapes) {
					ctx.fill();
				} else {
					ctx.stroke();
				}
			}
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
			const stampSize = Math.max(currentSize * 3, 16);

			if (currentShape === 'rectangle') {
				if (fillShapes) {
					ctx.fillRect(x - stampSize / 2, y - stampSize / 2, stampSize, stampSize * 0.7);
				} else {
					ctx.strokeRect(x - stampSize / 2, y - stampSize / 2, stampSize, stampSize * 0.7);
				}
			} else if (currentShape === 'square') {
				if (fillShapes) {
					ctx.fillRect(x - stampSize / 2, y - stampSize / 2, stampSize, stampSize);
				} else {
					ctx.strokeRect(x - stampSize / 2, y - stampSize / 2, stampSize, stampSize);
				}
			} else {
				ctx.beginPath();
				ctx.arc(x, y, stampSize / 2, 0, Math.PI * 2);
				if (fillShapes) {
					ctx.fill();
				} else {
					ctx.stroke();
				}
			}
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

		function setTool(tool) {
			currentTool = tool;
			toolButtons.forEach(function (button) {
				button.classList.toggle('is-active', button.getAttribute('data-tool') === tool);
			});
			setStatus('Tool: ' + tool);
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
			} else if (currentTool === 'shape') {
				snapshotBeforeShape = ctx.getImageData(0, 0, canvas.width, canvas.height);
			} else if (currentTool === 'fill') {
				floodFill(pos.x, pos.y, currentColor);
				isDrawing = false;
				saveHistoryState();
				setStatus('Filled area');
			} else if (currentTool === 'stamp') {
				stampShape(pos.x, pos.y);
				isDrawing = false;
				saveHistoryState();
				setStatus('Stamped shape');
			} else if (currentTool === 'text') {
				placeText(pos.x, pos.y);
				isDrawing = false;
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
			} else if (currentTool === 'eraser') {
				ctx.save();
				ctx.globalCompositeOperation = hasTransparentBackground ? 'destination-out' : 'source-over';
				if (!hasTransparentBackground) {
					ctx.strokeStyle = '#ffffff';
				} else {
					ctx.strokeStyle = 'rgba(0,0,0,1)';
				}
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
			} else if (currentTool === 'shape') {
				drawPreviewShape(pos.x, pos.y);
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
			}

			if (currentTool === 'brush' || currentTool === 'eraser' || currentTool === 'shape') {
				saveHistoryState();
			}

			isDrawing = false;
		}

		function clearCanvas() {
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

			if (transparent) {
				setStatus('Transparent background selected');
			} else {
				const temp = document.createElement('canvas');
				temp.width = canvas.width;
				temp.height = canvas.height;
				const tempCtx = temp.getContext('2d');
				tempCtx.drawImage(canvas, 0, 0);
				ctx.fillStyle = '#ffffff';
				ctx.fillRect(0, 0, canvas.width, canvas.height);
				ctx.drawImage(temp, 0, 0);
				setStatus('White background selected');
			}

			saveHistoryState();
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
				fillToggle.textContent = fillShapes ? 'Filled shapes: On' : 'Filled shapes: Off';
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

		canvas.addEventListener('mousedown', startDrawing);
		canvas.addEventListener('mousemove', moveDrawing);
		window.addEventListener('mouseup', endDrawing);

		canvas.addEventListener('touchstart', startDrawing, { passive: false });
		canvas.addEventListener('touchmove', moveDrawing, { passive: false });
		window.addEventListener('touchend', endDrawing, { passive: false });

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
						Draw like a simple Paint app. Use brush, eraser, fill bucket, shapes, and text.
						You can upload a picture, draw on top of it, add text, then save as PNG or JPG.
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
					</div>

					<div class="mini-paint__group">
						<span class="mini-paint__label">Color</span>
						<input type="color" class="mini-paint__color" value="#000000" aria-label="Pick color">
					</div>

					<div class="mini-paint__group">
						<span class="mini-paint__label">Brush Size</span>
						<input type="range" class="mini-paint__range" min="1" max="60" value="8" aria-label="Brush size">
						<span class="mini-paint__value">8px</span>
					</div>

					<div class="mini-paint__group">
						<span class="mini-paint__label">Shape</span>
						<select class="mini-paint__select" aria-label="Shape picker">
							<option value="rectangle">Rectangle</option>
							<option value="square">Square</option>
							<option value="circle">Circle</option>
						</select>
						<button type="button" class="mini-paint__button" data-fill-toggle>Filled shapes: Off</button>
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
						<span class="mini-paint__label">Background</span>
						<button type="button" class="mini-paint__button" data-bg="white">White</button>
						<button type="button" class="mini-paint__button" data-bg="transparent">Transparent</button>
					</div>

					<div class="mini-paint__group">
						<span class="mini-paint__label">Image</span>
						<input type="file" class="mini-paint__file" accept="image/png,image/jpeg,image/webp" aria-label="Upload image">
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
					<canvas class="mini-paint__canvas" width="900" height="560" aria-label="Drawing canvas"></canvas>
				</div>

				<div class="mini-paint__status" aria-live="polite">Ready to draw</div>

				<div class="mini-paint__footer">
					Simple paint program with drawing, erasing, shape tools, text, upload, undo, redo, and save.
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
	'description'     => 'A simple Paint-style image editor with drawing, shapes, text, upload, and PNG/JPG saving.',
	'render_callback' => 'zo_game_mini_paint_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);