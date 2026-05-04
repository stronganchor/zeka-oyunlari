<?php
if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root--mirror-axiom {
	min-height: calc(100vh - 110px);
	padding: 24px;
	background: #0d1b1e;
	color: #f6f1df;
	font-family: Arial, Helvetica, sans-serif;
}
.zo-game-root--mirror-axiom * {
	box-sizing: border-box;
}
.zo-ma {
	max-width: 980px;
	margin: 0 auto;
	display: grid;
	gap: 16px;
}
.zo-ma__head {
	display: grid;
	grid-template-columns: minmax(0, 1fr) auto;
	gap: 16px;
	align-items: end;
	border-bottom: 1px solid rgba(246, 241, 223, 0.18);
	padding-bottom: 16px;
}
.zo-ma__kicker {
	margin: 0 0 6px;
	color: #54d6bd;
	font-size: 12px;
	font-weight: 800;
	letter-spacing: 0;
	text-transform: uppercase;
}
.zo-ma__title {
	margin: 0;
	font-size: clamp(34px, 6vw, 60px);
	line-height: 0.98;
}
.zo-ma__credit {
	padding: 12px;
	border: 1px solid rgba(84, 214, 189, 0.36);
	background: rgba(84, 214, 189, 0.1);
	color: #dffbf6;
	min-width: 230px;
}
.zo-ma__layout {
	display: grid;
	grid-template-columns: minmax(300px, 1fr) minmax(280px, 360px);
	gap: 16px;
}
.zo-ma__panel {
	border: 1px solid rgba(246, 241, 223, 0.16);
	background: rgba(246, 241, 223, 0.06);
	padding: 16px;
}
.zo-ma__message {
	min-height: 48px;
	margin: 0;
	padding: 12px;
	background: rgba(84, 214, 189, 0.12);
	border: 1px solid rgba(84, 214, 189, 0.22);
	line-height: 1.45;
}
.zo-ma__board {
	display: grid;
	grid-template-columns: repeat(5, minmax(42px, 1fr));
	gap: 8px;
	margin-top: 14px;
}
.zo-ma__cell {
	aspect-ratio: 1;
	border: 1px solid rgba(246, 241, 223, 0.18);
	background: #142a2f;
	color: #f6f1df;
	font-size: clamp(18px, 4vw, 30px);
	font-weight: 900;
	cursor: pointer;
}
.zo-ma__cell:hover,
.zo-ma__cell:focus {
	outline: none;
	border-color: #f0c36a;
}
.zo-ma__cell.is-on {
	background: #f0c36a;
	color: #0d1b1e;
}
.zo-ma__cell.is-core {
	box-shadow: inset 0 0 0 3px #54d6bd;
}
.zo-ma__stats {
	display: grid;
	grid-template-columns: repeat(2, 1fr);
	gap: 10px;
}
.zo-ma__stat {
	padding: 12px;
	background: rgba(0, 0, 0, 0.18);
}
.zo-ma__label {
	display: block;
	color: #9fb9b2;
	font-size: 12px;
	font-weight: 800;
	text-transform: uppercase;
}
.zo-ma__value {
	display: block;
	margin-top: 8px;
	font-size: 28px;
	font-weight: 900;
}
.zo-ma__btns {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	margin-top: 14px;
}
.zo-ma__btn {
	border: 0;
	background: #f6f1df;
	color: #0d1b1e;
	font-weight: 900;
	padding: 11px 14px;
	cursor: pointer;
	min-height: 42px;
}
.zo-ma__btn:hover,
.zo-ma__btn:focus {
	background: #54d6bd;
	outline: none;
}
.zo-ma__hint {
	margin: 14px 0 0;
	color: #cddbd7;
	line-height: 1.45;
}
@media (max-width: 820px) {
	.zo-ma__head,
	.zo-ma__layout {
		grid-template-columns: 1fr;
	}
}
@media (max-width: 640px) {
	.zo-game-root--mirror-axiom {
		min-height: calc(100vh - 84px);
		padding: 16px;
	}
}
CSS;

$js = <<<'JS'
(function () {
	const SIZE = 5;
	const TARGET = [
		'10101',
		'01110',
		'11011',
		'01110',
		'10101'
	];

	function key(x, y) {
		return x + ',' + y;
	}

	function init(root) {
		if (!root || root.dataset.mirrorAxiomReady === '1') {
			return;
		}

		const board = root.querySelector('[data-ma-board]');
		const movesEl = root.querySelector('[data-ma-moves]');
		const matchesEl = root.querySelector('[data-ma-matches]');
		const message = root.querySelector('[data-ma-message]');
		const resetButton = root.querySelector('[data-ma-reset]');
		const revealButton = root.querySelector('[data-ma-reveal]');

		if (!board || !movesEl || !matchesEl || !message || !resetButton || !revealButton) {
			return;
		}

		root.dataset.mirrorAxiomReady = '1';

		const state = {
			on: new Set(['2,2']),
			moves: 0,
			revealed: false
		};

		function targetHas(x, y) {
			return TARGET[y].charAt(x) === '1';
		}

		function reflectedPoints(x, y) {
			return [
				[x, y],
				[SIZE - 1 - x, y],
				[x, SIZE - 1 - y],
				[SIZE - 1 - x, SIZE - 1 - y]
			].map(function (point) {
				return key(point[0], point[1]);
			}).filter(function (item, index, list) {
				return list.indexOf(item) === index;
			});
		}

		function toggleSet(cellKey) {
			if (state.on.has(cellKey)) {
				state.on.delete(cellKey);
			} else {
				state.on.add(cellKey);
			}
		}

		function countMatches() {
			let matches = 0;
			for (let y = 0; y < SIZE; y += 1) {
				for (let x = 0; x < SIZE; x += 1) {
					if (state.on.has(key(x, y)) === targetHas(x, y)) {
						matches += 1;
					}
				}
			}
			return matches;
		}

		function render() {
			board.innerHTML = '';
			for (let y = 0; y < SIZE; y += 1) {
				for (let x = 0; x < SIZE; x += 1) {
					const button = document.createElement('button');
					button.type = 'button';
					button.className = 'zo-ma__cell';
					button.textContent = state.revealed && targetHas(x, y) ? '◆' : '•';
					button.dataset.x = String(x);
					button.dataset.y = String(y);
					button.classList.toggle('is-on', state.on.has(key(x, y)));
					button.classList.toggle('is-core', x === 2 || y === 2);
					button.addEventListener('click', function () {
						reflectedPoints(x, y).forEach(toggleSet);
						state.moves += 1;
						update();
					});
					board.appendChild(button);
				}
			}
			updateStats();
		}

		function updateStats() {
			const matches = countMatches();
			movesEl.textContent = String(state.moves);
			matchesEl.textContent = String(matches) + '/25';

			if (matches === 25) {
				message.textContent = 'Solved. Every click was mirrored across both axes.';
			} else if (state.moves === 0) {
				message.textContent = 'Each cell toggles itself and its horizontal/vertical mirror partners.';
			} else {
				message.textContent = 'Matched cells: ' + matches + '. Find the symmetry that creates the target.';
			}
		}

		function update() {
			render();
		}

		resetButton.addEventListener('click', function () {
			state.on = new Set(['2,2']);
			state.moves = 0;
			state.revealed = false;
			render();
		});

		revealButton.addEventListener('click', function () {
			state.revealed = !state.revealed;
			render();
		});

		render();
	}

	document.addEventListener('DOMContentLoaded', function () {
		document.querySelectorAll('.zo-game-root--mirror-axiom').forEach(init);
	});
}());
JS;

if (!function_exists('zo_game_mirror_axiom')) {
	function zo_game_mirror_axiom($post_id = 0, $module = array()) {
		$instance_id = 'zo-ma-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--mirror-axiom" id="<?php echo esc_attr($instance_id); ?>">
			<section class="zo-ma" aria-label="Mirror Axiom game">
				<header class="zo-ma__head">
					<div>
						<p class="zo-ma__kicker">Symmetry logic</p>
						<h2 class="zo-ma__title">Mirror Axiom</h2>
					</div>
					<div class="zo-ma__credit">
						<strong>Idea asker:</strong> Asker<br>
						<strong>Game author:</strong> Asker + Codex
					</div>
				</header>
				<div class="zo-ma__layout">
					<div class="zo-ma__panel">
						<p class="zo-ma__message" data-ma-message aria-live="polite"></p>
						<div class="zo-ma__board" data-ma-board></div>
						<div class="zo-ma__btns">
							<button type="button" class="zo-ma__btn" data-ma-reset>Reset</button>
							<button type="button" class="zo-ma__btn" data-ma-reveal>Target Ghost</button>
						</div>
					</div>
					<aside class="zo-ma__panel">
						<div class="zo-ma__stats">
							<div class="zo-ma__stat">
								<span class="zo-ma__label">Moves</span>
								<span class="zo-ma__value" data-ma-moves>0</span>
							</div>
							<div class="zo-ma__stat">
								<span class="zo-ma__label">Match</span>
								<span class="zo-ma__value" data-ma-matches>0/25</span>
							</div>
						</div>
						<p class="zo-ma__hint">Hard mode: solve without the target ghost. Every move changes up to four cells, so wrong symmetry spreads fast.</p>
					</aside>
				</div>
			</section>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug' => 'mirror-axiom',
	'name' => 'Mirror Axiom',
	'author' => 'Asker',
	'description' => 'A hard symmetry puzzle where every click reflects across both axes.',
	'render_callback' => 'zo_game_mirror_axiom',
	'inline_style' => $css,
	'inline_script' => $js,
);
?>
