<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--echo-mirror-citadel {
	--emc-bg: linear-gradient(180deg, #fdf7ed 0%, #fff2d8 100%);
	--emc-ink: #2b2112;
	--emc-accent: #9a3412;
	--emc-gold: #f59e0b;
	--emc-beam: #fb7185;
	max-width: 960px;
	margin: 0 auto;
	padding: 20px;
	border: 2px solid rgba(146, 64, 14, 0.25);
	border-radius: 24px;
	background: var(--emc-bg);
	box-sizing: border-box;
	font-family: Georgia, "Times New Roman", serif;
	color: var(--emc-ink);
}

.zo-game-root--echo-mirror-citadel .zo-emc-title {
	margin: 0 0 8px;
	font-size: 34px;
	text-align: center;
	color: #7c2d12;
}

.zo-game-root--echo-mirror-citadel .zo-emc-desc {
	margin: 0 0 18px;
	text-align: center;
	line-height: 1.55;
	color: #5b4630;
}

.zo-game-root--echo-mirror-citadel .zo-emc-top {
	display: grid;
	grid-template-columns: repeat(3, minmax(0, 1fr));
	gap: 12px;
	margin-bottom: 16px;
}

.zo-game-root--echo-mirror-citadel .zo-emc-stat {
	padding: 12px;
	border-radius: 16px;
	background: rgba(255, 255, 255, 0.72);
	border: 1px solid rgba(146, 64, 14, 0.15);
	text-align: center;
}

.zo-game-root--echo-mirror-citadel .zo-emc-stat-label {
	display: block;
	margin-bottom: 4px;
	font-size: 12px;
	letter-spacing: 0.08em;
	text-transform: uppercase;
	color: #9a3412;
}

.zo-game-root--echo-mirror-citadel .zo-emc-stat-value {
	display: block;
	font-size: 24px;
	font-weight: 700;
}

.zo-game-root--echo-mirror-citadel .zo-emc-board-wrap {
	padding: 16px;
	border-radius: 20px;
	background:
		radial-gradient(circle at top, rgba(255, 255, 255, 0.8), transparent 55%),
		linear-gradient(180deg, #3b1f12 0%, #2a180f 100%);
}

.zo-game-root--echo-mirror-citadel .zo-emc-board {
	display: grid;
	grid-template-columns: repeat(5, minmax(0, 1fr));
	gap: 8px;
}

.zo-game-root--echo-mirror-citadel .zo-emc-cell {
	position: relative;
	aspect-ratio: 1;
	border-radius: 16px;
	border: 1px solid rgba(255, 255, 255, 0.12);
	background: rgba(255, 248, 220, 0.08);
	box-sizing: border-box;
	display: flex;
	align-items: center;
	justify-content: center;
	color: #fef3c7;
	font-size: 32px;
	font-weight: 700;
}

.zo-game-root--echo-mirror-citadel button.zo-emc-cell {
	cursor: pointer;
}

.zo-game-root--echo-mirror-citadel .zo-emc-cell.is-beam {
	box-shadow: inset 0 0 0 999px rgba(251, 113, 133, 0.18);
}

.zo-game-root--echo-mirror-citadel .zo-emc-cell.is-spirit::after {
	content: "";
	position: absolute;
	inset: 30%;
	border-radius: 999px;
	background: rgba(250, 204, 21, 0.75);
}

.zo-game-root--echo-mirror-citadel .zo-emc-cell.is-spirit.is-lit::after {
	background: #fde68a;
	box-shadow: 0 0 22px rgba(253, 230, 138, 0.95);
}

.zo-game-root--echo-mirror-citadel .zo-emc-cell.is-throne {
	border-color: rgba(245, 158, 11, 0.55);
}

.zo-game-root--echo-mirror-citadel .zo-emc-cell.is-throne::before {
	content: "";
	position: absolute;
	left: 24%;
	right: 24%;
	bottom: 22%;
	height: 18%;
	border-radius: 6px 6px 12px 12px;
	background: rgba(245, 158, 11, 0.9);
}

.zo-game-root--echo-mirror-citadel .zo-emc-cell.is-throne::after {
	content: "";
	position: absolute;
	left: 34%;
	right: 34%;
	top: 22%;
	bottom: 34%;
	border-radius: 10px 10px 0 0;
	background: rgba(245, 158, 11, 0.9);
}

.zo-game-root--echo-mirror-citadel .zo-emc-cell.is-source::before {
	content: "";
	position: absolute;
	left: -9px;
	top: 50%;
	width: 18px;
	height: 6px;
	margin-top: -3px;
	border-radius: 999px;
	background: rgba(244, 114, 182, 0.95);
}

.zo-game-root--echo-mirror-citadel .zo-emc-mirror-mark {
	position: relative;
	z-index: 2;
}

.zo-game-root--echo-mirror-citadel .zo-emc-controls {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 10px;
	margin-top: 14px;
}

.zo-game-root--echo-mirror-citadel .zo-emc-button {
	border: 0;
	border-radius: 14px;
	padding: 12px 14px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
}

.zo-game-root--echo-mirror-citadel .zo-emc-button--reset {
	background: #fff7ed;
	color: #9a3412;
}

.zo-game-root--echo-mirror-citadel .zo-emc-button--shuffle {
	background: #9a3412;
	color: #ffffff;
}

.zo-game-root--echo-mirror-citadel .zo-emc-status {
	min-height: 24px;
	margin-top: 14px;
	font-weight: 700;
	text-align: center;
	color: #7c2d12;
}

.zo-game-root--echo-mirror-citadel .zo-emc-help {
	margin-top: 8px;
	text-align: center;
	line-height: 1.5;
	color: #6b4f33;
}

@media (max-width: 720px) {
	.zo-game-root--echo-mirror-citadel {
		padding: 14px;
	}

	.zo-game-root--echo-mirror-citadel .zo-emc-title {
		font-size: 28px;
	}

	.zo-game-root--echo-mirror-citadel .zo-emc-top {
		grid-template-columns: 1fr;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const roots = document.querySelectorAll('.zo-game-root--echo-mirror-citadel');

	function reflect(mirrorType, dx, dy) {
		if (mirrorType === 0) {
			if (dx === 1) {
				return { dx: 0, dy: -1 };
			}
			if (dx === -1) {
				return { dx: 0, dy: 1 };
			}
			if (dy === 1) {
				return { dx: -1, dy: 0 };
			}
			return { dx: 1, dy: 0 };
		}

		if (dx === 1) {
			return { dx: 0, dy: 1 };
		}
		if (dx === -1) {
			return { dx: 0, dy: -1 };
		}
		if (dy === 1) {
			return { dx: 1, dy: 0 };
		}
		return { dx: -1, dy: 0 };
	}

	roots.forEach(function (root) {
		const board = root.querySelector('.zo-emc-board');
		const spiritsEl = root.querySelector('.zo-emc-spirits');
		const throneEl = root.querySelector('.zo-emc-throne');
		const statusEl = root.querySelector('.zo-emc-status');
		const resetButton = root.querySelector('.zo-emc-button--reset');
		const shuffleButton = root.querySelector('.zo-emc-button--shuffle');

		const size = 5;
		const source = '0,2';
		const throne = '3,2';
		const spirits = ['1,1', '3,1', '2,3'];
		const mirrorSeeds = {
			'1,0': 0,
			'3,0': 1,
			'1,2': 0,
			'3,4': 0,
			'2,4': 1,
			'4,4': 0
		};

		let mirrors = {};

		function cloneMirrorSeeds() {
			mirrors = {};
			Object.keys(mirrorSeeds).forEach(function (key) {
				mirrors[key] = mirrorSeeds[key];
			});
		}

		function traceBeam() {
			let x = -1;
			let y = 2;
			let dx = 1;
			let dy = 0;
			let steps = 0;
			let reachedThrone = false;

			const pathSet = {};
			const visitSet = {};

			while (steps < 40) {
				x += dx;
				y += dy;

				if (x < 0 || x >= size || y < 0 || y >= size) {
					break;
				}

				const key = x + ',' + y;
				const visitKey = key + '|' + dx + ',' + dy;

				if (visitSet[visitKey]) {
					break;
				}

				visitSet[visitKey] = true;
				pathSet[key] = true;

				if (key === throne) {
					reachedThrone = true;
				}

				if (Object.prototype.hasOwnProperty.call(mirrors, key)) {
					const next = reflect(mirrors[key], dx, dy);
					dx = next.dx;
					dy = next.dy;
				}

				steps += 1;
			}

			let lit = 0;
			spirits.forEach(function (key) {
				if (pathSet[key]) {
					lit += 1;
				}
			});

			return {
				pathSet: pathSet,
				lit: lit,
				reachedThrone: reachedThrone
			};
		}

		function setStatus(text) {
			statusEl.textContent = text;
		}

		function render() {
			const result = traceBeam();
			board.innerHTML = '';

			for (let y = 0; y < size; y += 1) {
				for (let x = 0; x < size; x += 1) {
					const key = x + ',' + y;
					const isMirror = Object.prototype.hasOwnProperty.call(mirrors, key);
					const cell = document.createElement(isMirror ? 'button' : 'div');
					cell.className = 'zo-emc-cell';

					if (result.pathSet[key]) {
						cell.classList.add('is-beam');
					}
					if (key === source) {
						cell.classList.add('is-source');
					}
					if (key === throne) {
						cell.classList.add('is-throne');
					}
					if (spirits.indexOf(key) !== -1) {
						cell.classList.add('is-spirit');
						if (result.pathSet[key]) {
							cell.classList.add('is-lit');
						}
					}

					if (isMirror) {
						cell.type = 'button';
						cell.setAttribute('aria-label', 'Rotate mirror');
						cell.addEventListener('click', function () {
							mirrors[key] = mirrors[key] === 0 ? 1 : 0;
							render();
						});

						const mark = document.createElement('span');
						mark.className = 'zo-emc-mirror-mark';
						mark.textContent = mirrors[key] === 0 ? '/' : '\\';
						cell.appendChild(mark);
					}

					board.appendChild(cell);
				}
			}

			spiritsEl.textContent = String(result.lit) + ' / ' + String(spirits.length);
			throneEl.textContent = result.reachedThrone ? 'Open' : 'Closed';

			if (result.reachedThrone && result.lit === spirits.length) {
				setStatus('The beam reaches the throne and every spirit is free.');
			} else if (result.lit === spirits.length) {
				setStatus('All spirits are lit. Route the final echo into the throne.');
			} else {
				setStatus('Rotate the mirrors so the beam touches every spirit before the throne.');
			}
		}

		resetButton.addEventListener('click', function () {
			cloneMirrorSeeds();
			render();
		});

		shuffleButton.addEventListener('click', function () {
			Object.keys(mirrors).forEach(function (key) {
				mirrors[key] = Math.random() < 0.5 ? 0 : 1;
			});
			render();
		});

		cloneMirrorSeeds();
		render();
	});
});
JS;

if (!function_exists('zo_game_echo_mirror_citadel_render')) {
	function zo_game_echo_mirror_citadel_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-echo-mirror-citadel-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--echo-mirror-citadel" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-emc-title">Echo Mirror Citadel</h2>
			<p class="zo-emc-desc">Rotate ancient sound mirrors to guide one bright echo through the castle, wake the trapped spirits, and unlock the throne room.</p>

			<div class="zo-emc-top">
				<div class="zo-emc-stat">
					<span class="zo-emc-stat-label">Spirits Lit</span>
					<span class="zo-emc-stat-value zo-emc-spirits">0 / 3</span>
				</div>
				<div class="zo-emc-stat">
					<span class="zo-emc-stat-label">Throne Gate</span>
					<span class="zo-emc-stat-value zo-emc-throne">Closed</span>
				</div>
				<div class="zo-emc-stat">
					<span class="zo-emc-stat-label">Echo Rule</span>
					<span class="zo-emc-stat-value">Touch All</span>
				</div>
			</div>

			<div class="zo-emc-board-wrap">
				<div class="zo-emc-board"></div>
			</div>

			<div class="zo-emc-controls">
				<button type="button" class="zo-emc-button zo-emc-button--reset">Reset Layout</button>
				<button type="button" class="zo-emc-button zo-emc-button--shuffle">Shuffle Mirrors</button>
			</div>

			<div class="zo-emc-status" aria-live="polite"></div>
			<div class="zo-emc-help">The echo enters from the left middle tile. Click any mirror tile to rotate between <strong>/</strong> and <strong>\</strong>.</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug' => 'echo-mirror-citadel',
	'name' => 'Echo Mirror Citadel',
	'author' => 'asker',
	'description' => 'A castle puzzle game where you rotate sound mirrors to guide lost spirits back to the throne room.',
	'render_callback' => 'zo_game_echo_mirror_citadel_render',
	'inline_style' => $css,
	'inline_script' => $js,
);
