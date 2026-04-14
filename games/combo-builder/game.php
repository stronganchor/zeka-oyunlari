<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 600px;
	margin: 0 auto;
	text-align: center;
	font-family: Arial, sans-serif;
}

.combo-builder-target {
	margin: 20px;
	font-size: 18px;
}

.combo-builder-buttons {
	display: flex;
	justify-content: center;
	flex-wrap: wrap;
	margin: 20px;
}

.combo-builder-button {
	width: 80px;
	height: 80px;
	margin: 10px;
	border: 2px solid #000;
	border-radius: 10px;
	background-color: #f0f0f0;
	font-size: 24px;
	cursor: pointer;
	transition: background-color 0.2s;
}

.combo-builder-button:hover {
	background-color: #ddd;
}

.combo-builder-button.active {
	background-color: #0f0;
	color: white;
}

.combo-builder-status {
	font-size: 18px;
	margin: 20px;
}

.combo-builder-controls {
	margin: 20px;
}

.combo-builder-controls button {
	padding: 10px 20px;
	font-size: 16px;
	margin: 5px;
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--combo-builder');

	games.forEach(function (game) {
		const targetDisplay = game.querySelector('.combo-builder-target');
		const buttons = game.querySelectorAll('.combo-builder-button');
		const status = game.querySelector('.combo-builder-status');
		const restartBtn = game.querySelector('.restart');

		let targetCombo = [];
		let playerCombo = [];
		let comboLength = 4;

		function generateCombo() {
			targetCombo = [];
			for (let i = 0; i < comboLength; i++) {
				targetCombo.push(Math.floor(Math.random() * buttons.length));
			}
			targetDisplay.textContent = 'Target Combo: ' + targetCombo.map(idx => buttons[idx].textContent).join(' ');
		}

		function resetGame() {
			playerCombo = [];
			status.textContent = 'Build the combo!';
			buttons.forEach(btn => btn.classList.remove('active'));
			generateCombo();
		}

		function checkCombo() {
			if (playerCombo.length === targetCombo.length) {
				const match = playerCombo.every((val, idx) => val === targetCombo[idx]);
				if (match) {
					status.textContent = 'Combo Complete! You Win!';
				} else {
					status.textContent = 'Wrong combo! Try again.';
					setTimeout(resetGame, 2000);
				}
			}
		}

		buttons.forEach((button, index) => {
			button.addEventListener('click', function() {
				if (playerCombo.length < comboLength) {
					playerCombo.push(index);
					button.classList.add('active');
					setTimeout(() => button.classList.remove('active'), 300);
					checkCombo();
				}
			});
		});

		restartBtn.addEventListener('click', resetGame);

		// Initial setup
		resetGame();
	});
});
JS;

if (!function_exists('zo_game_combo_builder_render')) {
	function zo_game_combo_builder_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-combo-builder-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--combo-builder" id="<?php echo esc_attr($instance_id); ?>">
			<h2>Combo Builder</h2>
			<div class="combo-builder-target"></div>
			<div class="combo-builder-buttons">
				<button class="combo-builder-button">A</button>
				<button class="combo-builder-button">B</button>
				<button class="combo-builder-button">C</button>
				<button class="combo-builder-button">D</button>
				<button class="combo-builder-button">E</button>
				<button class="combo-builder-button">F</button>
			</div>
			<div class="combo-builder-status"></div>
			<div class="combo-builder-controls">
				<button class="restart">Restart</button>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'combo-builder',
	'name'            => 'Combo Builder',
	'author'          => 'arslan',
	'description'     => 'Build the perfect combo by pressing buttons in the correct sequence.',
	'render_callback' => 'zo_game_combo_builder_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
