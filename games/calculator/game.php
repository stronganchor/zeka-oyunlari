<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--kids-calculator {
	max-width: 560px;
	margin: 0 auto;
	padding: 20px;
	border: 2px solid #d9e3f0;
	border-radius: 18px;
	background: #ffffff;
	box-sizing: border-box;
	font-family: Arial, sans-serif;
}

.zo-game-root--kids-calculator .zo-kc-title {
	margin: 0 0 10px;
	font-size: 28px;
	line-height: 1.2;
	text-align: center;
}

.zo-game-root--kids-calculator .zo-kc-desc {
	margin: 0 0 18px;
	font-size: 15px;
	line-height: 1.5;
	text-align: center;
	color: #444;
}

.zo-game-root--kids-calculator .zo-kc-grid {
	display: grid;
	grid-template-columns: 1fr;
	gap: 14px;
}

.zo-game-root--kids-calculator .zo-kc-field {
	display: flex;
	flex-direction: column;
	gap: 6px;
}

.zo-game-root--kids-calculator .zo-kc-label {
	font-size: 15px;
	font-weight: 700;
	color: #222;
}

.zo-game-root--kids-calculator .zo-kc-input,
.zo-game-root--kids-calculator .zo-kc-select,
.zo-game-root--kids-calculator .zo-kc-button {
	width: 100%;
	padding: 12px 14px;
	font-size: 18px;
	border-radius: 12px;
	box-sizing: border-box;
}

.zo-game-root--kids-calculator .zo-kc-input,
.zo-game-root--kids-calculator .zo-kc-select {
	border: 2px solid #bfcfe3;
	background: #f8fbff;
	color: #111;
}

.zo-game-root--kids-calculator .zo-kc-actions {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 10px;
}

.zo-game-root--kids-calculator .zo-kc-button {
	border: 0;
	cursor: pointer;
	font-weight: 700;
}

.zo-game-root--kids-calculator .zo-kc-button--calc {
	background: #2997aa;
	color: #fff;
}

.zo-game-root--kids-calculator .zo-kc-button--reset {
	background: #eceff3;
	color: #222;
}

.zo-game-root--kids-calculator .zo-kc-result-wrap {
	margin-top: 4px;
	padding: 14px;
	border-radius: 14px;
	background: #f5f8fc;
	border: 2px dashed #c7d4e5;
	text-align: center;
}

.zo-game-root--kids-calculator .zo-kc-result-label {
	display: block;
	font-size: 14px;
	font-weight: 700;
	color: #444;
	margin-bottom: 6px;
}

.zo-game-root--kids-calculator .zo-kc-result {
	display: block;
	font-size: 28px;
	font-weight: 700;
	color: #111;
	word-break: break-word;
	min-height: 34px;
}

.zo-game-root--kids-calculator .zo-kc-status {
	margin-top: 10px;
	text-align: center;
	font-size: 14px;
	min-height: 21px;
	color: #b42318;
}

@media (max-width: 480px) {
	.zo-game-root.zo-game-root--kids-calculator {
		padding: 16px;
	}

	.zo-game-root--kids-calculator .zo-kc-title {
		font-size: 24px;
	}

	.zo-game-root--kids-calculator .zo-kc-input,
	.zo-game-root--kids-calculator .zo-kc-select,
	.zo-game-root--kids-calculator .zo-kc-button {
		font-size: 16px;
		padding: 11px 12px;
	}

	.zo-game-root--kids-calculator .zo-kc-result {
		font-size: 24px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--kids-calculator');

	games.forEach(function (game) {
		const input1 = game.querySelector('.zo-kc-input--first');
		const input2 = game.querySelector('.zo-kc-input--second');
		const operation = game.querySelector('.zo-kc-select');
		const calcButton = game.querySelector('.zo-kc-button--calc');
		const resetButton = game.querySelector('.zo-kc-button--reset');
		const resultEl = game.querySelector('.zo-kc-result');
		const statusEl = game.querySelector('.zo-kc-status');

		function formatNumber(value) {
			if (typeof value !== 'number' || !isFinite(value)) {
				return String(value);
			}

			if (Number.isInteger(value)) {
				return String(value);
			}

			return parseFloat(value.toFixed(10)).toString();
		}

		function calculateResult() {
			const raw1 = input1.value.trim();
			const raw2 = input2.value.trim();
			const op = operation.value;

			statusEl.textContent = '';

			if (!op) {
				resultEl.textContent = '?';
				statusEl.textContent = 'Select an operation.';
				return;
			}

			const num1 = raw1 === '' ? 0 : parseFloat(raw1);
			const num2 = raw2 === '' ? 0 : parseFloat(raw2);

			if (raw1 !== '' && Number.isNaN(num1)) {
				resultEl.textContent = '?';
				statusEl.textContent = 'Please enter a valid first number.';
				return;
			}

			if (op !== 'sqrt' && raw2 !== '' && Number.isNaN(num2)) {
				resultEl.textContent = '?';
				statusEl.textContent = 'Please enter a valid second number.';
				return;
			}

			let result;

			if (op === 'add') {
				result = num1 + num2;
			} else if (op === 'subtract') {
				result = num1 - num2;
			} else if (op === 'multiply') {
				result = num1 * num2;
			} else if (op === 'divide') {
				if (num2 === 0) {
					resultEl.textContent = '?';
					statusEl.textContent = 'Cannot divide by zero.';
					return;
				}
				result = num1 / num2;
			} else if (op === 'power') {
				result = Math.pow(num1, num2);
			} else if (op === 'sqrt') {
				if (num1 < 0) {
					resultEl.textContent = '?';
					statusEl.textContent = 'Cannot take the square root of a negative number.';
					return;
				}
				result = Math.sqrt(num1);
			} else {
				resultEl.textContent = '?';
				statusEl.textContent = 'Select an operation.';
				return;
			}

			resultEl.textContent = formatNumber(result);
		}

		function resetGame() {
			input1.value = '';
			input2.value = '';
			operation.value = '';
			resultEl.textContent = '?';
			statusEl.textContent = '';
		}

		operation.addEventListener('change', function () {
			if (operation.value === 'sqrt') {
				input2.disabled = true;
				input2.value = '';
				input2.setAttribute('aria-hidden', 'true');
			} else {
				input2.disabled = false;
				input2.removeAttribute('aria-hidden');
			}
		});

		calcButton.addEventListener('click', calculateResult);
		resetButton.addEventListener('click', resetGame);

		input1.addEventListener('keydown', function (event) {
			if (event.key === 'Enter') {
				calculateResult();
			}
		});

		input2.addEventListener('keydown', function (event) {
			if (event.key === 'Enter') {
				calculateResult();
			}
		});
	});
});
JS;

if (!function_exists('zo_game_kids_calculator_render')) {
	function zo_game_kids_calculator_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-kids-calculator-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--kids-calculator" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-kc-title">Simple Calculator for Kids</h2>
			<p class="zo-kc-desc">Type numbers, choose an operation, and press Calculate. Use Square Root to work with the first number only.</p>

			<div class="zo-kc-grid">
				<div class="zo-kc-field">
					<label class="zo-kc-label" for="<?php echo esc_attr($instance_id . '-first'); ?>">Enter First Number</label>
					<input class="zo-kc-input zo-kc-input--first" id="<?php echo esc_attr($instance_id . '-first'); ?>" type="number" step="any" inputmode="decimal" />
				</div>

				<div class="zo-kc-field">
					<label class="zo-kc-label" for="<?php echo esc_attr($instance_id . '-second'); ?>">Enter Second Number</label>
					<input class="zo-kc-input zo-kc-input--second" id="<?php echo esc_attr($instance_id . '-second'); ?>" type="number" step="any" inputmode="decimal" />
				</div>

				<div class="zo-kc-field">
					<label class="zo-kc-label" for="<?php echo esc_attr($instance_id . '-operation'); ?>">Operation</label>
					<select class="zo-kc-select" id="<?php echo esc_attr($instance_id . '-operation'); ?>">
						<option value="">Select Operation</option>
						<option value="add">Add</option>
						<option value="subtract">Subtract</option>
						<option value="multiply">Multiply</option>
						<option value="divide">Divide</option>
						<option value="power">Power</option>
						<option value="sqrt">Square Root</option>
					</select>
				</div>

				<div class="zo-kc-actions">
					<button type="button" class="zo-kc-button zo-kc-button--calc">Calculate</button>
					<button type="button" class="zo-kc-button zo-kc-button--reset">Restart</button>
				</div>

				<div class="zo-kc-result-wrap">
					<span class="zo-kc-result-label">Result</span>
					<span class="zo-kc-result">?</span>
				</div>

				<div class="zo-kc-status" aria-live="polite"></div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'kids-calculator',
	'name'            => 'Simple Calculator for Kids',
	'author'          => 'Asker',
	'description'     => 'A simple calculator game for kids with add, subtract, multiply, divide, power, and square root.',
	'render_callback' => 'zo_game_kids_calculator_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);