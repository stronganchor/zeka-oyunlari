<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--sound-pattern-builder {
	max-width: 560px;
	margin: 0 auto;
	padding: 14px;
	border: 2px solid #d8e2ec;
	border-radius: 14px;
	background: #f8fbff;
	font-family: Arial, sans-serif;
	box-sizing: border-box;
}

.zo-spb-title {
	text-align: center;
	margin: 0 0 10px;
}

.zo-spb-instruction {
	min-height: 38px;
	text-align: center;
	font-weight: 700;
}

.zo-spb-buttons {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 8px;
	margin-top: 10px;
}

.zo-spb-animal {
	border: 0;
	border-radius: 10px;
	padding: 12px;
	font-weight: 700;
	color: #fff;
	cursor: pointer;
}

.zo-spb-controls {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 8px;
	margin-top: 10px;
}

.zo-spb-btn {
	border: 0;
	border-radius: 10px;
	padding: 10px;
	font-weight: 700;
	background: #2563eb;
	color: #fff;
}

.zo-spb-hud {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 8px;
	margin-top: 8px;
}

.zo-spb-stat {
	background: #eef2ff;
	border-radius: 10px;
	padding: 10px;
	text-align: center;
}

.zo-spb-status {
	min-height: 24px;
	text-align: center;
	font-weight: 700;
	margin-top: 8px;
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root');

	games.forEach(function (game) {
		if (!game.classList.contains('zo-game-root--sound-pattern-builder')) {
			return;
		}

		const status = game.querySelector('.zo-spb-status');
		const instruction = game.querySelector('.zo-spb-instruction');
		const scoreEl = game.querySelector('.zo-spb-score');
		const livesEl = game.querySelector('.zo-spb-lives');
		const roundEl = game.querySelector('.zo-spb-round');
		const startBtn = game.querySelector('.zo-spb-start');
		const replayBtn = game.querySelector('.zo-spb-replay');
		const resetBtn = game.querySelector('.zo-spb-reset');
		const animalButtons = game.querySelectorAll('.zo-spb-animal[data-index]');

		const tones = [220, 330, 440, 523];
		const colors = ['#ef4444', '#22c55e', '#3b82f6', '#f59e0b'];
		const labels = ['Bear', 'Cat', 'Bird', 'Bee'];

		let audioContext = null;
		let score = 0;
		let lives = 3;
		let level = 1;
		let pattern = [];
		let playerStep = 0;
		let listening = false;
		let showing = false;

		function applyLook() {
			animalButtons.forEach(function (button) {
				const index = Number(button.dataset.index);
				button.style.background = colors[index];
				button.textContent = labels[index];
			});
		}

		function playTone(index, done) {
			if (!audioContext) {
				audioContext = new (window.AudioContext || window.webkitAudioContext)();
			}
			if (audioContext.state === 'suspended') {
				audioContext.resume();
			}
			const osc = audioContext.createOscillator();
			const gain = audioContext.createGain();
			osc.frequency.value = tones[index];
			gain.gain.value = 0.001;
			osc.connect(gain);
			gain.connect(audioContext.destination);
			osc.start();
			const now = audioContext.currentTime;
			gain.gain.exponentialRampToValueAtTime(0.25, now + 0.01);
			gain.gain.exponentialRampToValueAtTime(0.001, now + 0.25);
			osc.stop(now + 0.3);
			setTimeout(done, 300);
		}

		function setButtonsEnabled(enabled) {
			animalButtons.forEach(function (button) {
				button.disabled = !enabled;
			});
		}

		function updateHud() {
			scoreEl.textContent = String(score);
			livesEl.textContent = String(lives);
			roundEl.textContent = String(level);
		}

		function clearState() {
			listening = false;
			showing = false;
			playerStep = 0;
			setButtonsEnabled(false);
		}

		function newRound() {
			pattern = [];
			for (let i = 0; i < 2 + level; i++) {
				pattern.push(Math.floor(Math.random() * tones.length));
			}
			clearState();
			instruction.textContent = 'Listen carefully.';
			showPattern();
		}

		function showPattern() {
			showing = true;
			pattern.forEach(function (idx, order) {
				setTimeout(function () {
					const button = animalButtons[idx];
					button.classList.add('is-play');
					playTone(idx, function () {});
					setTimeout(function () {
						button.classList.remove('is-play');
					}, 220);
				}, order * 650);
			});
			setTimeout(function () {
				showing = false;
				listening = true;
				setButtonsEnabled(true);
				instruction.textContent = 'Repeat the pattern.';
			}, pattern.length * 650 + 250);
		}

		function startOver() {
			score = 0;
			lives = 3;
			level = 1;
			updateHud();
			newRound();
		}

		function wrongAnswer() {
			lives -= 1;
			updateHud();
			status.textContent = 'Wrong note.';
			if (lives <= 0) {
				status.textContent = 'No lives. Press Start.';
				clearState();
				return;
			}
			listening = false;
			setButtonsEnabled(false);
			setTimeout(function () {
				newRound();
			}, 900);
		}

		animalButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				if (!listening) {
					return;
				}
				const index = Number(button.dataset.index);
				playTone(index, function () {});
				if (index !== pattern[playerStep]) {
					wrongAnswer();
					return;
				}
				playerStep += 1;
				if (playerStep === pattern.length) {
					listening = false;
					setButtonsEnabled(false);
					score += 1;
					level += 1;
					updateHud();
					status.textContent = 'Great! Next round.';
					setTimeout(function () {
						newRound();
					}, 700);
				}
			});
		});

		replayBtn.addEventListener('click', function () {
			if (pattern.length && !showing) {
				clearState();
				showPattern();
			}
		});

		resetBtn.addEventListener('click', function () {
			level = 1;
			score = 0;
			lives = 3;
			updateHud();
			clearState();
			instruction.textContent = 'Press Start.';
		});

		startBtn.addEventListener('click', function () {
			startOver();
			status.textContent = 'Round started.';
		});

		applyLook();
		setButtonsEnabled(false);
		updateHud();
		instruction.textContent = 'Press Start.';
	});
});
JS;

if (!function_exists('zo_game_sound_pattern_builder_render')) {
	function zo_game_sound_pattern_builder_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-sound-pattern-builder-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--sound-pattern-builder" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-spb-title">Sound Pattern Builder</h2>
			<p class="zo-spb-instruction">Press Start.</p>
			<div class="zo-spb-buttons">
				<button type="button" class="zo-spb-animal" data-index="0"></button>
				<button type="button" class="zo-spb-animal" data-index="1"></button>
				<button type="button" class="zo-spb-animal" data-index="2"></button>
				<button type="button" class="zo-spb-animal" data-index="3"></button>
			</div>
			<div class="zo-spb-controls">
				<button type="button" class="zo-spb-btn zo-spb-start">Start</button>
				<button type="button" class="zo-spb-btn zo-spb-replay">Replay</button>
				<button type="button" class="zo-spb-btn zo-spb-reset">Reset</button>
			</div>
			<div class="zo-spb-hud">
				<div class="zo-spb-stat">Score <span class="zo-spb-score">0</span></div>
				<div class="zo-spb-stat">Lives <span class="zo-spb-lives">3</span></div>
				<div class="zo-spb-stat">Round <span class="zo-spb-round">1</span></div>
			</div>
			<div class="zo-spb-status">Press Start.</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'sound-pattern-builder',
	'name'            => 'Sound Pattern Builder',
	'author'          => 'Asker',
	'description'     => 'Listen to a sound pattern and repeat it by tapping animals.',
	'render_callback' => 'zo_game_sound_pattern_builder_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
