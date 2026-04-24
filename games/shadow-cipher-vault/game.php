<?php
if (!defined('ABSPATH')) {
	exit;
}

$css = <<<CSS
.zo-game-root--shadow-cipher-vault {
	max-width: 900px;
	margin: 0 auto;
	padding: 18px;
	border: 1px solid rgba(15, 23, 42, 0.12);
	border-radius: 16px;
	background: #ffffff;
	box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
	font-family: Arial, sans-serif;
}
.zo-game-root--shadow-cipher-vault .zo-mini-title {
	margin: 0 0 10px;
	font-size: 28px;
	line-height: 1.2;
}
.zo-game-root--shadow-cipher-vault .zo-mini-desc {
	margin: 0 0 12px;
	color: #4b5563;
}
.zo-game-root--shadow-cipher-vault .zo-mini-status {
	margin: 0 0 14px;
	color: #0f172a;
	font-weight: 700;
	min-height: 22px;
}
.zo-game-root--shadow-cipher-vault .zo-mini-score {
	margin: 0 0 16px;
	color: #0f172a;
}
.zo-game-root--shadow-cipher-vault .zo-mini-btn {
	border: 0;
	border-radius: 10px;
	padding: 10px 16px;
	background: #2563eb;
	color: #ffffff;
	font-weight: 700;
	cursor: pointer;
}
CSS;

$js = <<<JS
document.addEventListener("DOMContentLoaded", function () {
	const game = document.querySelector('.zo-game-root--shadow-cipher-vault');
	if (!game) {
		return;
	}

	const button = game.querySelector('.zo-mini-btn');
	const status = game.querySelector('.zo-mini-status');
	const pointsEl = game.querySelector('.zo-mini-points');

	if (!button || !status || !pointsEl) {
		return;
	}

	let points = 0;
	let streak = 0;

	button.addEventListener('click', function () {
		points += 5;
		streak += 1;
		pointsEl.textContent = points;

		if (streak >= 5) {
			status.textContent = 'Great run! Keep the pattern going.';
		} else {
			status.textContent = 'Action logged. Try for a longer chain.';
		}
	});
});
JS;

if (!function_exists('zo_game_shadow_cipher_vault')) {
	function zo_game_shadow_cipher_vault($post_id = 0, $module = array()) {
		$instance_id = 'zo-mini-shadow-cipher-vault-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--shadow-cipher-vault" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-mini-title">Shadow Cipher Vault</h2>
			<p class="zo-mini-desc">Use shadow ciphers to crack layered security in total darkness.</p>
			<p class="zo-mini-status" aria-live="polite">Press action to begin the challenge.</p>
			<p class="zo-mini-score">Points: <strong class="zo-mini-points">0</strong></p>
			<button type="button" class="zo-mini-btn">Make a Move</button>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug' => 'shadow-cipher-vault',
	'name' => 'Shadow Cipher Vault',
	'author' => 'asker',
	'description' => 'Use shadow ciphers to crack layered security in total darkness.',
	'render_callback' => 'zo_game_shadow_cipher_vault',
	'inline_style' => $css,
	'inline_script' => $js,
);
?>


