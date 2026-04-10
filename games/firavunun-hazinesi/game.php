<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 640px;
	margin: 0 auto;
	padding: 16px;
	text-align: center;
	font-family: Arial, sans-serif;
	box-sizing: border-box;
}

.zo-game-root * {
	box-sizing: border-box;
}

.zo-pharaoh-wrap {
	background: #fff7e8;
	border: 2px solid #d6b36a;
	border-radius: 18px;
	padding: 18px;
	box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
}

.zo-pharaoh-title {
	margin: 0 0 8px;
	font-size: 28px;
	line-height: 1.2;
}

.zo-pharaoh-text {
	margin: 0 0 14px;
	font-size: 16px;
	line-height: 1.5;
}

.zo-pharaoh-topbar {
	display: flex;
	justify-content: center;
	flex-wrap: wrap;
	gap: 10px;
	margin-bottom: 14px;
}

.zo-pharaoh-pill {
	background: #ffffff;
	border: 1px solid #d6b36a;
	border-radius: 999px;
	padding: 8px 12px;
	font-size: 14px;
	font-weight: bold;
}

.zo-pharaoh-board {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 10px;
	margin: 18px 0 14px;
}

.zo-pharaoh-tile {
	appearance: none;
	border: 2px solid #c79b44;
	border-radius: 14px;
	background: #c79b44;
	color: transparent;
	font-size: 34px;
	font-weight: bold;
	min-height: 78px;
	cursor: pointer;
	transition: transform 0.15s ease, background 0.15s ease, border-color 0.15s ease;
	padding: 0;
}

.zo-pharaoh-tile:hover,
.zo-pharaoh-tile:focus {
	transform: translateY(-2px);
}

.zo-pharaoh-tile.is-flipped,
.zo-pharaoh-tile.is-matched {
	background: #fffdf8;
	color: #222;
}

.zo-pharaoh-tile.is-matched {
	border-color: #6aa84f;
	background: #eef9e9;
	cursor: default;
}

.zo-pharaoh-controls {
	display: flex;
	justify-content: center;
	flex-wrap: wrap;
	gap: 10px;
	margin-bottom: 10px;
}

.zo-pharaoh-btn {
	appearance: none;
	border: 0;
	border-radius: 12px;
	padding: 12px 16px;
	font-size: 16px;
	font-weight: bold;
	cursor: pointer;
	background: #c98d2b;
	color: #fff;
	min-width: 120px;
}

.zo-pharaoh-btn:hover,
.zo-pharaoh-btn:focus {
	opacity: 0.92;
}

.zo-pharaoh-status {
	min-height: 24px;
	font-size: 15px;
	font-weight: bold;
	margin-top: 8px;
}

.zo-pharaoh-help {
	margin-top: 10px;
	font-size: 14px;
	line-height: 1.5;
}

@media (max-width: 560px) {
	.zo-pharaoh-board {
		grid-template-columns: repeat(4, minmax(0, 1fr));
		gap: 8px;
	}

	.zo-pharaoh-tile {
		min-height: 64px;
		font-size: 28px;
	}

	.zo-pharaoh-title {
		font-size: 24px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--firavunun-hazinesi');

	games.forEach(function (game) {
		const board = game.querySelector('.zo-pharaoh-board');
		const statusEl = game.querySelector('.zo-pharaoh-status');
		const movesEl = game.querySelector('.zo-pharaoh-moves');
		const pairsEl = game.querySelector('.zo-pharaoh-pairs');
		const bestEl = game.querySelector('.zo-pharaoh-best');
		const restartBtn = game.querySelector('.zo-pharaoh-restart');

		const symbols = ['🔺', '🐫', '👑', '🐍', '☀️', '📜', '🪙', '🪬'];
		let cards = [];
		let firstCard = null;
		let secondCard = null;
		let lockBoard = false;
		let moves = 0;
		let matchedPairs = 0;
		let best = null;

		function shuffle(array) {
			for (let i = array.length - 1; i > 0; i--) {
				const j = Math.floor(Math.random() * (i + 1));
				const temp = array[i];
				array[i] = array[j];
				array[j] = temp;
			}
			return array;
		}

		function updateStats() {
			movesEl.textContent = 'Hamle: ' + moves;
			pairsEl.textContent = 'Eşleşme: ' + matchedPairs + '/8';
			bestEl.textContent = 'En iyi: ' + (best === null ? '-' : best);
		}

		function setStatus(text) {
			statusEl.textContent = text;
		}

		function resetTurn() {
			firstCard = null;
			secondCard = null;
			lockBoard = false;
		}

		function checkWin() {
			if (matchedPairs === 8) {
				if (best === null || moves < best) {
					best = moves;
				}
				updateStats();
				setStatus('Kazandın. Firavunun hazinesini buldun.');
			}
		}

		function flipBack() {
			lockBoard = true;

			window.setTimeout(function () {
				if (firstCard) {
					firstCard.classList.remove('is-flipped');
					firstCard.textContent = '';
				}
				if (secondCard) {
					secondCard.classList.remove('is-flipped');
					secondCard.textContent = '';
				}
				resetTurn();
				setStatus('Tekrar dene.');
			}, 700);
		}

		function handleMatch() {
			firstCard.classList.add('is-matched');
			secondCard.classList.add('is-matched');
			firstCard.disabled = true;
			secondCard.disabled = true;
			matchedPairs += 1;
			resetTurn();
			updateStats();
			setStatus('Güzel. Bir eş buldun.');
			checkWin();
		}

		function onTileClick(tile) {
			if (lockBoard || tile.classList.contains('is-flipped') || tile.classList.contains('is-matched')) {
				return;
			}

			tile.classList.add('is-flipped');
			tile.textContent = tile.getAttribute('data-symbol');

			if (!firstCard) {
				firstCard = tile;
				setStatus('Şimdi ikinci kartı seç.');
				return;
			}

			secondCard = tile;
			moves += 1;
			updateStats();

			if (firstCard.getAttribute('data-symbol') === secondCard.getAttribute('data-symbol')) {
				handleMatch();
			} else {
				flipBack();
			}
		}

		function buildBoard() {
			const deck = shuffle(symbols.concat(symbols).slice());
			board.innerHTML = '';
			cards = [];

			deck.forEach(function (symbol, index) {
				const tile = document.createElement('button');
				tile.type = 'button';
				tile.className = 'zo-pharaoh-tile';
				tile.setAttribute('data-symbol', symbol);
				tile.setAttribute('aria-label', 'Kart ' + (index + 1));
				tile.textContent = '';
				tile.addEventListener('click', function () {
					onTileClick(tile);
				});
				board.appendChild(tile);
				cards.push(tile);
			});
		}

		function restartGame() {
			firstCard = null;
			secondCard = null;
			lockBoard = false;
			moves = 0;
			matchedPairs = 0;
			buildBoard();
			updateStats();
			setStatus('İki aynı hazineyi bul.');
		}

		restartBtn.addEventListener('click', restartGame);

		restartGame();
	});
});
JS;

if (!function_exists('zo_game_firavunun_hazinesi_render')) {
	function zo_game_firavunun_hazinesi_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-firavunun-hazinesi-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--firavunun-hazinesi" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-pharaoh-wrap">
				<h3 class="zo-pharaoh-title">Firavunun Hazinesi</h3>
				<p class="zo-pharaoh-text">Kartları aç. Aynı Mısır hazinelerini eşleştir. Hepsini bulunca kazanırsın.</p>

				<div class="zo-pharaoh-topbar">
					<div class="zo-pharaoh-pill zo-pharaoh-moves">Hamle: 0</div>
					<div class="zo-pharaoh-pill zo-pharaoh-pairs">Eşleşme: 0/8</div>
					<div class="zo-pharaoh-pill zo-pharaoh-best">En iyi: -</div>
				</div>

				<div class="zo-pharaoh-board" aria-label="Hazine kartları"></div>

				<div class="zo-pharaoh-controls">
					<button type="button" class="zo-pharaoh-btn zo-pharaoh-restart">Tekrar Oyna</button>
				</div>

				<div class="zo-pharaoh-status">İki aynı hazineyi bul.</div>
				<div class="zo-pharaoh-help">Amaç bütün kart çiftlerini en az hamlede bulmak.</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'firavunun-hazinesi',
	'name'            => 'Firavunun Hazinesi',
	'author'          => 'Arslan',
	'description'     => 'Mısır temalı hafıza eşleştirme oyunu.',
	'render_callback' => 'zo_game_firavunun_hazinesi_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);