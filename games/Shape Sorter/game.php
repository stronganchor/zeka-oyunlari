<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 820px;
	margin: 0 auto;
	font-family: Arial, sans-serif;
}

.zo-game-root * {
	box-sizing: border-box;
}

.zo-game-root--shape-sorter .ss-card {
	background: #ffffff;
	border: 2px solid #d9e2ec;
	border-radius: 20px;
	padding: 20px;
	box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
}

.zo-game-root--shape-sorter .ss-title {
	margin: 0 0 10px;
	font-size: 28px;
	line-height: 1.2;
	text-align: center;
	color: #1f2933;
}

.zo-game-root--shape-sorter .ss-instructions {
	margin: 0 0 16px;
	font-size: 15px;
	line-height: 1.5;
	text-align: center;
	color: #52606d;
}

.zo-game-root--shape-sorter .ss-topbar {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 10px;
	margin-bottom: 18px;
}

.zo-game-root--shape-sorter .ss-stat {
	background: #f0f4f8;
	border-radius: 12px;
	padding: 12px 10px;
	text-align: center;
}

.zo-game-root--shape-sorter .ss-stat-label {
	display: block;
	font-size: 12px;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: 0.04em;
	color: #7b8794;
	margin-bottom: 4px;
}

.zo-game-root--shape-sorter .ss-stat-value {
	display: block;
	font-size: 22px;
	font-weight: 700;
	color: #102a43;
}

.zo-game-root--shape-sorter .ss-status {
	min-height: 28px;
	margin-bottom: 16px;
	text-align: center;
	font-size: 16px;
	font-weight: 700;
	color: #102a43;
}

.zo-game-root--shape-sorter .ss-status.is-good {
	color: #0b6e4f;
}

.zo-game-root--shape-sorter .ss-status.is-bad {
	color: #c81e1e;
}

.zo-game-root--shape-sorter .ss-layout {
	display: grid;
	grid-template-columns: 1.05fr 1fr;
	gap: 18px;
	align-items: start;
}

.zo-game-root--shape-sorter .ss-shape-panel,
.zo-game-root--shape-sorter .ss-bin-panel {
	background: #f8fbff;
	border: 2px solid #d9e2ec;
	border-radius: 18px;
	padding: 16px;
}

.zo-game-root--shape-sorter .ss-panel-title {
	margin: 0 0 12px;
	font-size: 18px;
	font-weight: 700;
	text-align: center;
	color: #102a43;
}

.zo-game-root--shape-sorter .ss-shape-grid {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 12px;
}

.zo-game-root--shape-sorter .ss-shape-btn {
	display: flex;
	align-items: center;
	justify-content: center;
	min-height: 110px;
	padding: 10px;
	border: 2px solid #bcccdc;
	border-radius: 16px;
	background: #ffffff;
	cursor: pointer;
	transition: transform 0.15s ease, border-color 0.15s ease, opacity 0.15s ease;
}

.zo-game-root--shape-sorter .ss-shape-btn:hover,
.zo-game-root--shape-sorter .ss-shape-btn:focus {
	transform: translateY(-1px);
	border-color: #2563eb;
}

.zo-game-root--shape-sorter .ss-shape-btn.is-selected {
	border-color: #7c3aed;
	box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.12);
}

.zo-game-root--shape-sorter .ss-shape-btn.is-sorted {
	opacity: 0.4;
	cursor: default;
	transform: none;
}

.zo-game-root--shape-sorter .ss-bins {
	display: grid;
	grid-template-columns: 1fr;
	gap: 12px;
}

.zo-game-root--shape-sorter .ss-bin {
	border: 2px dashed #9fb3c8;
	border-radius: 16px;
	padding: 14px;
	background: #ffffff;
	cursor: pointer;
	transition: transform 0.15s ease, border-color 0.15s ease, background 0.15s ease;
}

.zo-game-root--shape-sorter .ss-bin:hover,
.zo-game-root--shape-sorter .ss-bin:focus {
	transform: translateY(-1px);
	border-color: #2563eb;
}

.zo-game-root--shape-sorter .ss-bin.is-correct {
	background: #ecfdf3;
	border-color: #0b6e4f;
}

.zo-game-root--shape-sorter .ss-bin.is-wrong {
	background: #fff1f2;
	border-color: #c81e1e;
}

.zo-game-root--shape-sorter .ss-bin-title {
	display: block;
	font-size: 18px;
	font-weight: 700;
	text-align: center;
	color: #102a43;
	margin-bottom: 8px;
}

.zo-game-root--shape-sorter .ss-bin-count {
	display: block;
	font-size: 14px;
	text-align: center;
	color: #52606d;
}

.zo-game-root--shape-sorter .ss-actions {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap: 10px;
	margin-top: 18px;
}

.zo-game-root--shape-sorter .ss-btn {
	border: 0;
	border-radius: 12px;
	padding: 12px 18px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	transition: transform 0.15s ease, opacity 0.15s ease;
}

.zo-game-root--shape-sorter .ss-btn:hover,
.zo-game-root--shape-sorter .ss-btn:focus {
	transform: translateY(-1px);
}

.zo-game-root--shape-sorter .ss-btn--clear {
	background: #f59e0b;
	color: #ffffff;
}

.zo-game-root--shape-sorter .ss-btn--restart {
	background: #7c3aed;
	color: #ffffff;
}

.zo-game-root--shape-sorter .ss-progress {
	margin-top: 14px;
	text-align: center;
	font-size: 14px;
	color: #52606d;
}

.zo-game-root--shape-sorter .ss-shape {
	position: relative;
	display: inline-block;
}

.zo-game-root--shape-sorter .ss-shape--circle {
	width: 62px;
	height: 62px;
	border-radius: 50%;
	background: #ef4444;
}

.zo-game-root--shape-sorter .ss-shape--square {
	width: 62px;
	height: 62px;
	background: #2563eb;
	border-radius: 8px;
}

.zo-game-root--shape-sorter .ss-shape--triangle {
	width: 0;
	height: 0;
	border-left: 34px solid transparent;
	border-right: 34px solid transparent;
	border-bottom: 62px solid #22c55e;
}

.zo-game-root--shape-sorter .ss-shape--diamond {
	width: 50px;
	height: 50px;
	background: #f59e0b;
	transform: rotate(45deg);
	border-radius: 8px;
}

.zo-game-root--shape-sorter .ss-shape--oval {
	width: 74px;
	height: 48px;
	background: #ec4899;
	border-radius: 50%;
}

.zo-game-root--shape-sorter .ss-shape--rectangle {
	width: 78px;
	height: 48px;
	background: #14b8a6;
	border-radius: 8px;
}

@media (max-width: 700px) {
	.zo-game-root--shape-sorter .ss-topbar {
		grid-template-columns: 1fr;
	}

	.zo-game-root--shape-sorter .ss-layout {
		grid-template-columns: 1fr;
	}

	.zo-game-root--shape-sorter .ss-shape-grid {
		grid-template-columns: repeat(2, 1fr);
	}

	.zo-game-root--shape-sorter .ss-title {
		font-size: 24px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--shape-sorter');

	games.forEach(function (game) {
		const shapeGrid = game.querySelector('.ss-shape-grid');
		const binsWrap = game.querySelector('.ss-bins');
		const statusEl = game.querySelector('.ss-status');
		const scoreEl = game.querySelector('.ss-score');
		const sortedEl = game.querySelector('.ss-sorted');
		const mistakesEl = game.querySelector('.ss-mistakes');
		const progressEl = game.querySelector('.ss-progress');
		const clearBtn = game.querySelector('.ss-btn--clear');
		const restartBtn = game.querySelector('.ss-btn--restart');

		const shapes = [
			{ id: 1, type: 'circle', label: 'Circle' },
			{ id: 2, type: 'square', label: 'Square' },
			{ id: 3, type: 'triangle', label: 'Triangle' },
			{ id: 4, type: 'diamond', label: 'Diamond' },
			{ id: 5, type: 'oval', label: 'Oval' },
			{ id: 6, type: 'rectangle', label: 'Rectangle' },
			{ id: 7, type: 'circle', label: 'Circle' },
			{ id: 8, type: 'square', label: 'Square' },
			{ id: 9, type: 'triangle', label: 'Triangle' },
			{ id: 10, type: 'diamond', label: 'Diamond' },
			{ id: 11, type: 'oval', label: 'Oval' },
			{ id: 12, type: 'rectangle', label: 'Rectangle' }
		];

		const bins = [
			{ type: 'circle', label: 'Circle' },
			{ type: 'square', label: 'Square' },
			{ type: 'triangle', label: 'Triangle' },
			{ type: 'diamond', label: 'Diamond' },
			{ type: 'oval', label: 'Oval' },
			{ type: 'rectangle', label: 'Rectangle' }
		];

		let score = 0;
		let sortedCount = 0;
		let mistakes = 0;
		let selectedShapeId = null;
		let currentShapes = [];

		function shuffleArray(array) {
			const copy = array.slice();
			for (let i = copy.length - 1; i > 0; i--) {
				const j = Math.floor(Math.random() * (i + 1));
				const temp = copy[i];
				copy[i] = copy[j];
				copy[j] = temp;
			}
			return copy;
		}

		function setStatus(message, type) {
			statusEl.textContent = message;
			statusEl.classList.remove('is-good', 'is-bad');

			if (type === 'good') {
				statusEl.classList.add('is-good');
			} else if (type === 'bad') {
				statusEl.classList.add('is-bad');
			}
		}

		function updateStats() {
			scoreEl.textContent = String(score);
			sortedEl.textContent = String(sortedCount);
			mistakesEl.textContent = String(mistakes);
			progressEl.textContent = 'Sorted ' + sortedCount + ' of ' + currentShapes.length + ' shapes';
		}

		function clearBinHighlights() {
			const allBins = binsWrap.querySelectorAll('.ss-bin');
			allBins.forEach(function (bin) {
				bin.classList.remove('is-correct', 'is-wrong');
			});
		}

		function renderShapes() {
			shapeGrid.innerHTML = '';

			currentShapes.forEach(function (shape) {
				const btn = document.createElement('button');
				btn.type = 'button';
				btn.className = 'ss-shape-btn';
				btn.setAttribute('data-shape-id', String(shape.id));
				btn.setAttribute('aria-label', shape.label);

				if (shape.sorted) {
					btn.classList.add('is-sorted');
					btn.disabled = true;
				}

				if (selectedShapeId === shape.id) {
					btn.classList.add('is-selected');
				}

				const visual = document.createElement('span');
				visual.className = 'ss-shape ss-shape--' + shape.type;
				btn.appendChild(visual);

				btn.addEventListener('click', function () {
					if (shape.sorted) {
						return;
					}
					selectedShapeId = shape.id;
					clearBinHighlights();
					renderShapes();
					setStatus('Now tap the matching bin.', '');
				});

				shapeGrid.appendChild(btn);
			});
		}

		function renderBins() {
			binsWrap.innerHTML = '';

			bins.forEach(function (binData) {
				const bin = document.createElement('button');
				bin.type = 'button';
				bin.className = 'ss-bin';
				bin.setAttribute('data-bin-type', binData.type);

				const title = document.createElement('span');
				title.className = 'ss-bin-title';
				title.textContent = binData.label;

				const count = document.createElement('span');
				count.className = 'ss-bin-count';

				const totalInBin = currentShapes.filter(function (shape) {
					return shape.type === binData.type && shape.sorted;
				}).length;

				count.textContent = totalInBin + ' sorted';

				bin.appendChild(title);
				bin.appendChild(count);

				bin.addEventListener('click', function () {
					handleBinClick(binData.type, bin);
				});

				binsWrap.appendChild(bin);
			});
		}

		function handleBinClick(binType, binEl) {
			clearBinHighlights();

			if (selectedShapeId === null) {
				setStatus('Pick a shape first.', 'bad');
				binEl.classList.add('is-wrong');
				return;
			}

			const selectedShape = currentShapes.find(function (shape) {
				return shape.id === selectedShapeId;
			});

			if (!selectedShape || selectedShape.sorted) {
				selectedShapeId = null;
				renderShapes();
				setStatus('Pick another shape.', 'bad');
				return;
			}

			if (selectedShape.type === binType) {
				selectedShape.sorted = true;
				score += 1;
				sortedCount += 1;
				selectedShapeId = null;
				binEl.classList.add('is-correct');
				renderShapes();
				renderBins();
				updateStats();

				if (sortedCount === currentShapes.length) {
					setStatus('You sorted them all. Great job.', 'good');
				} else {
					setStatus('Correct. Pick the next shape.', 'good');
				}
			} else {
				mistakes += 1;
				score = Math.max(0, score - 1);
				binEl.classList.add('is-wrong');
				updateStats();
				setStatus('Wrong bin. Try again.', 'bad');
			}
		}

		function clearSelection() {
			selectedShapeId = null;
			clearBinHighlights();
			renderShapes();
			setStatus('Selection cleared. Pick a shape.', '');
		}

		function restartGame() {
			score = 0;
			sortedCount = 0;
			mistakes = 0;
			selectedShapeId = null;
			currentShapes = shuffleArray(shapes).map(function (shape) {
				return {
					id: shape.id,
					type: shape.type,
					label: shape.label,
					sorted: false
				};
			});

			renderShapes();
			renderBins();
			updateStats();
			setStatus('Pick a shape, then tap the matching bin.', '');
		}

		clearBtn.addEventListener('click', clearSelection);
		restartBtn.addEventListener('click', restartGame);

		restartGame();
	});
});
JS;

if (!function_exists('zo_game_shape_sorter_render')) {
	function zo_game_shape_sorter_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-shape-sorter-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--shape-sorter" id="<?php echo esc_attr($instance_id); ?>">
			<div class="ss-card">
				<h2 class="ss-title">Shape Sorter</h2>
				<p class="ss-instructions">Tap a shape on the left. Then tap the matching shape bin on the right. Sort all the shapes into the correct bins.</p>

				<div class="ss-topbar">
					<div class="ss-stat">
						<span class="ss-stat-label">Score</span>
						<span class="ss-stat-value ss-score">0</span>
					</div>
					<div class="ss-stat">
						<span class="ss-stat-label">Sorted</span>
						<span class="ss-stat-value ss-sorted">0</span>
					</div>
					<div class="ss-stat">
						<span class="ss-stat-label">Mistakes</span>
						<span class="ss-stat-value ss-mistakes">0</span>
					</div>
				</div>

				<div class="ss-status" aria-live="polite">Pick a shape, then tap the matching bin.</div>

				<div class="ss-layout">
					<div class="ss-shape-panel">
						<h3 class="ss-panel-title">Shapes</h3>
						<div class="ss-shape-grid"></div>
					</div>

					<div class="ss-bin-panel">
						<h3 class="ss-panel-title">Bins</h3>
						<div class="ss-bins"></div>
					</div>
				</div>

				<div class="ss-actions">
					<button type="button" class="ss-btn ss-btn--clear">Clear Selection</button>
					<button type="button" class="ss-btn ss-btn--restart">Restart</button>
				</div>

				<div class="ss-progress">Sorted 0 of 12 shapes</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'shape-sorter',
	'name'            => 'Shape Sorter',
	'author'          => 'Arslan',
	'description'     => 'Sort the shapes into the correct bins by matching each shape type.',
	'render_callback' => 'zo_game_shape_sorter_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);