<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 680px;
	margin: 0 auto;
	font-family: inherit;
}

.zo-game-root.zo-game-root--sound-rule-rush {
	background: linear-gradient(180deg, #f7fbff 0%, #ffffff 100%);
	border: 2px solid #d9e8f6;
	border-radius: 22px;
	padding: 16px;
	box-shadow: 0 12px 28px rgba(0, 0, 0, 0.06);
}

.zo-game-root--sound-rule-rush .srr-title {
	margin: 0 0 8px;
	font-size: 28px;
	line-height: 1.2;
	text-align: center;
	color: #17344d;
}

.zo-game-root--sound-rule-rush .srr-subtitle {
	margin: 0 0 14px;
	font-size: 15px;
	line-height: 1.5;
	text-align: center;
	color: #60778d;
}

.zo-game-root--sound-rule-rush .srr-panel {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 8px;
	margin-bottom: 12px;
}

.zo-game-root--sound-rule-rush .srr-stat {
	background: #ffffff;
	border: 2px solid #dbe8f3;
	border-radius: 14px;
	padding: 10px 8px;
	text-align: center;
}

.zo-game-root--sound-rule-rush .srr-stat-label {
	display: block;
	font-size: 12px;
	color: #6a8095;
	margin-bottom: 4px;
}

.zo-game-root--sound-rule-rush .srr-stat-value {
	display: block;
	font-size: 22px;
	font-weight: 700;
	color: #16324d;
}

.zo-game-root--sound-rule-rush .srr-controls {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
	justify-content: center;
	margin-bottom: 12px;
}

.zo-game-root--sound-rule-rush .srr-btn {
	appearance: none;
	border: 0;
	border-radius: 12px;
	padding: 10px 14px;
	font-size: 14px;
	font-weight: 700;
	cursor: pointer;
	background: #1976d2;
	color: #ffffff;
	transition: transform 0.08s ease, opacity 0.12s ease;
}

.zo-game-root--sound-rule-rush .srr-btn:hover,
.zo-game-root--sound-rule-rush .srr-btn:focus {
	opacity: 0.92;
}

.zo-game-root--sound-rule-rush .srr-btn:active {
	transform: scale(0.98);
}

.zo-game-root--sound-rule-rush .srr-btn--secondary {
	background: #546e7a;
}

.zo-game-root--sound-rule-rush .srr-btn--mode {
	background: #00897b;
}

.zo-game-root--sound-rule-rush .srr-btn--mode.is-active {
	box-shadow: inset 0 0 0 3px rgba(255, 255, 255, 0.65);
}

.zo-game-root--sound-rule-rush .srr-status {
	min-height: 24px;
	margin: 0 0 12px;
	font-size: 15px;
	font-weight: 700;
	text-align: center;
	color: #17344d;
}

.zo-game-root--sound-rule-rush .srr-stage {
	background: linear-gradient(180deg, #eef7ff 0%, #f9fcff 100%);
	border: 2px solid #dbe8f3;
	border-radius: 18px;
	padding: 14px;
}

.zo-game-root--sound-rule-rush .srr-rule-banner {
	display: flex;
	align-items: center;
	justify-content: center;
	min-height: 64px;
	margin-bottom: 12px;
	padding: 10px 12px;
	background: #ffffff;
	border: 2px solid #dbe8f3;
	border-radius: 16px;
	text-align: center;
}

.zo-game-root--sound-rule-rush .srr-rule-text {
	font-size: 18px;
	font-weight: 800;
	line-height: 1.35;
	color: #0f3050;
}

.zo-game-root--sound-rule-rush .srr-play-area {
	display: grid;
	grid-template-columns: 1.1fr 1fr;
	gap: 12px;
	align-items: start;
}

.zo-game-root--sound-rule-rush .srr-prompt-box,
.zo-game-root--sound-rule-rush .srr-answer-box {
	background: #ffffff;
	border: 2px solid #dbe8f3;
	border-radius: 18px;
	padding: 14px;
}

.zo-game-root--sound-rule-rush .srr-box-title {
	margin: 0 0 10px;
	font-size: 15px;
	font-weight: 700;
	color: #17344d;
	text-align: center;
}

.zo-game-root--sound-rule-rush .srr-sound-card {
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	min-height: 220px;
	border-radius: 18px;
	background: linear-gradient(180deg, #f9fcff 0%, #edf6ff 100%);
	border: 3px solid #d8e7f5;
	text-align: center;
	padding: 16px;
}

.zo-game-root--sound-rule-rush .srr-icon {
	font-size: 72px;
	line-height: 1;
	margin-bottom: 10px;
	user-select: none;
}

.zo-game-root--sound-rule-rush .srr-sound-label {
	font-size: 20px;
	font-weight: 800;
	color: #16324d;
	margin-bottom: 6px;
}

.zo-game-root--sound-rule-rush .srr-sound-hint {
	font-size: 14px;
	color: #60778d;
}

.zo-game-root--sound-rule-rush .srr-answer-grid {
	display: grid;
	grid-template-columns: 1fr;
	gap: 10px;
}

.zo-game-root--sound-rule-rush .srr-answer-btn {
	appearance: none;
	border: 0;
	border-radius: 16px;
	padding: 14px 12px;
	font-size: 18px;
	font-weight: 800;
	cursor: pointer;
	color: #ffffff;
	text-align: center;
	min-height: 72px;
	transition: transform 0.08s ease, opacity 0.12s ease, box-shadow 0.12s ease;
	box-shadow: 0 8px 18px rgba(0, 0, 0, 0.10);
}

.zo-game-root--sound-rule-rush .srr-answer-btn:hover,
.zo-game-root--sound-rule-rush .srr-answer-btn:focus {
	opacity: 0.94;
}

.zo-game-root--sound-rule-rush .srr-answer-btn:active {
	transform: scale(0.98);
}

.zo-game-root--sound-rule-rush .srr-answer-btn[data-key="animal"] {
	background: #ef5350;
}

.zo-game-root--sound-rule-rush .srr-answer-btn[data-key="machine"] {
	background: #42a5f5;
}

.zo-game-root--sound-rule-rush .srr-answer-btn[data-key="music"] {
	background: #ab47bc;
}

.zo-game-root--sound-rule-rush .srr-answer-btn[data-key="nature"] {
	background: #66bb6a;
}

.zo-game-root--sound-rule-rush .srr-answer-sub {
	display: block;
	font-size: 12px;
	font-weight: 700;
	opacity: 0.9;
	margin-top: 4px;
}

.zo-game-root--sound-rule-rush .srr-feedback {
	min-height: 22px;
	margin-top: 10px;
	font-size: 14px;
	font-weight: 700;
	color: #60778d;
	text-align: center;
}

.zo-game-root--sound-rule-rush .srr-help {
	margin-top: 12px;
	font-size: 12px;
	line-height: 1.5;
	color: #60778d;
	text-align: center;
}

.zo-game-root--sound-rule-rush .srr-flash-good {
	animation: srr-good 0.28s ease;
}

.zo-game-root--sound-rule-rush .srr-flash-bad {
	animation: srr-bad 0.28s ease;
}

@keyframes srr-good {
	0% { box-shadow: 0 0 0 rgba(76, 175, 80, 0); }
	50% { box-shadow: 0 0 0 8px rgba(76, 175, 80, 0.18); }
	100% { box-shadow: 0 0 0 rgba(76, 175, 80, 0); }
}

@keyframes srr-bad {
	0% { box-shadow: 0 0 0 rgba(239, 83, 80, 0); }
	50% { box-shadow: 0 0 0 8px rgba(239, 83, 80, 0.18); }
	100% { box-shadow: 0 0 0 rgba(239, 83, 80, 0); }
}

@media (max-width: 640px) {
	.zo-game-root--sound-rule-rush .srr-panel {
		grid-template-columns: repeat(2, minmax(0, 1fr));
	}

	.zo-game-root--sound-rule-rush .srr-play-area {
		grid-template-columns: 1fr;
	}

	.zo-game-root--sound-rule-rush .srr-sound-card {
		min-height: 180px;
	}

	.zo-game-root--sound-rule-rush .srr-icon {
		font-size: 60px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--sound-rule-rush');

	games.forEach(function (game) {
		const scoreEl = game.querySelector('.srr-score');
		const timeEl = game.querySelector('.srr-time');
		const streakEl = game.querySelector('.srr-streak');
		const bestEl = game.querySelector('.srr-best');
		const statusEl = game.querySelector('.srr-status');
		const feedbackEl = game.querySelector('.srr-feedback');
		const ruleTextEl = game.querySelector('.srr-rule-text');
		const iconEl = game.querySelector('.srr-icon');
		const soundLabelEl = game.querySelector('.srr-sound-label');
		const soundHintEl = game.querySelector('.srr-sound-hint');
		const promptBoxEl = game.querySelector('.srr-prompt-box');
		const startBtn = game.querySelector('.srr-start');
		const resetBtn = game.querySelector('.srr-reset');
		const modeButtons = game.querySelectorAll('.srr-btn--mode');
		const answerButtons = game.querySelectorAll('.srr-answer-btn');

		const categories = [
			{ key: 'animal', label: 'Animal', icon: '🐶', hint: 'Living creature sounds' },
			{ key: 'machine', label: 'Machine', icon: '🚗', hint: 'Engines and machines' },
			{ key: 'music', label: 'Music', icon: '🎵', hint: 'Songs and instruments' },
			{ key: 'nature', label: 'Nature', icon: '🌧️', hint: 'Weather and outdoor sounds' }
		];

		const prompts = [
			{ id: 'dog', label: 'Bark Bark', icon: '🐕', category: 'animal' },
			{ id: 'cat', label: 'Meow', icon: '🐈', category: 'animal' },
			{ id: 'bird', label: 'Tweet Tweet', icon: '🐦', category: 'animal' },
			{ id: 'cow', label: 'Moo', icon: '🐄', category: 'animal' },
			{ id: 'car', label: 'Vroom', icon: '🚗', category: 'machine' },
			{ id: 'train', label: 'Choo Choo', icon: '🚂', category: 'machine' },
			{ id: 'alarm', label: 'Beep Beep', icon: '⏰', category: 'machine' },
			{ id: 'drill', label: 'Brrrr', icon: '🛠️', category: 'machine' },
			{ id: 'drum', label: 'Boom Boom', icon: '🥁', category: 'music' },
			{ id: 'guitar', label: 'Strum', icon: '🎸', category: 'music' },
			{ id: 'piano', label: 'Plink Plink', icon: '🎹', category: 'music' },
			{ id: 'microphone', label: 'La La', icon: '🎤', category: 'music' },
			{ id: 'rain', label: 'Pitter Patter', icon: '🌧️', category: 'nature' },
			{ id: 'wind', label: 'Whooosh', icon: '🌬️', category: 'nature' },
			{ id: 'thunder', label: 'Boom Crack', icon: '⛈️', category: 'nature' },
			{ id: 'river', label: 'Splash Splash', icon: '🏞️', category: 'nature' }
		];

		const rules = [
			{
				key: 'same',
				text: 'Tap the SAME sound family',
				solve: function (prompt, previousPrompt) {
					return prompt.category;
				}
			},
			{
				key: 'different',
				text: 'Tap a DIFFERENT sound family',
				solve: function (prompt, previousPrompt) {
					return firstDifferentCategory(prompt.category);
				}
			},
			{
				key: 'previous',
				text: 'Tap the SAME family as the PREVIOUS sound',
				solve: function (prompt, previousPrompt) {
					if (!previousPrompt) {
						return prompt.category;
					}
					return previousPrompt.category;
				}
			},
			{
				key: 'nonprevious',
				text: 'Tap a DIFFERENT family than the PREVIOUS sound',
				solve: function (prompt, previousPrompt) {
					if (!previousPrompt) {
						return firstDifferentCategory(prompt.category);
					}
					return firstDifferentCategory(previousPrompt.category);
				}
			}
		];

		const state = {
			running: false,
			mode: 'easy',
			score: 0,
			timeLeft: 0,
			streak: 0,
			best: 0,
			currentPrompt: null,
			previousPrompt: null,
			currentRule: null,
			lastRuleKey: '',
			roundLocked: true,
			timerId: 0
		};

		function modeConfig() {
			if (state.mode === 'hard') {
				return {
					duration: 30,
					rules: ['same', 'different', 'previous', 'nonprevious'],
					points: 2
				};
			}

			if (state.mode === 'medium') {
				return {
					duration: 35,
					rules: ['same', 'different', 'previous'],
					points: 1
				};
			}

			return {
				duration: 40,
				rules: ['same', 'different'],
				points: 1
			};
		}

		function randomItem(arr) {
			return arr[Math.floor(Math.random() * arr.length)];
		}

		function firstDifferentCategory(categoryKey) {
			for (let i = 0; i < categories.length; i++) {
				if (categories[i].key !== categoryKey) {
					return categories[i].key;
				}
			}
			return categories[0].key;
		}

		function getRuleByKey(key) {
			for (let i = 0; i < rules.length; i++) {
				if (rules[i].key === key) {
					return rules[i];
				}
			}
			return rules[0];
		}

		function categoryLabel(key) {
			for (let i = 0; i < categories.length; i++) {
				if (categories[i].key === key) {
					return categories[i].label;
				}
			}
			return '';
		}

		function updateStats() {
			scoreEl.textContent = String(state.score);
			timeEl.textContent = String(state.timeLeft);
			streakEl.textContent = String(state.streak);
			bestEl.textContent = String(state.best);
		}

		function setStatus(message) {
			statusEl.textContent = message;
		}

		function setFeedback(message) {
			feedbackEl.textContent = message;
		}

		function updateModeButtons() {
			modeButtons.forEach(function (btn) {
				btn.classList.toggle('is-active', btn.getAttribute('data-mode') === state.mode);
			});
		}

		function pulseBox(isGood) {
			promptBoxEl.classList.remove('srr-flash-good', 'srr-flash-bad');
			void promptBoxEl.offsetWidth;
			promptBoxEl.classList.add(isGood ? 'srr-flash-good' : 'srr-flash-bad');
		}

		function nextRule() {
			const cfg = modeConfig();
			let nextKey = randomItem(cfg.rules);

			if (cfg.rules.length > 1 && nextKey === state.lastRuleKey) {
				const filtered = cfg.rules.filter(function (item) {
					return item !== state.lastRuleKey;
				});
				nextKey = randomItem(filtered);
			}

			state.lastRuleKey = nextKey;
			state.currentRule = getRuleByKey(nextKey);
			ruleTextEl.textContent = state.currentRule.text;
		}

		function nextPrompt() {
			let next = randomItem(prompts);

			if (state.currentPrompt && prompts.length > 1) {
				let guard = 0;
				while (next.id === state.currentPrompt.id && guard < 10) {
					next = randomItem(prompts);
					guard += 1;
				}
			}

			state.previousPrompt = state.currentPrompt;
			state.currentPrompt = next;
			iconEl.textContent = next.icon;
			soundLabelEl.textContent = next.label;
			soundHintEl.textContent = 'Listen in your head. What family does it belong to?';
		}

		function nextRound() {
			state.roundLocked = false;
			nextPrompt();
			nextRule();

			if (state.currentRule.key === 'previous' && !state.previousPrompt) {
				ruleTextEl.textContent = 'First round: Tap the SAME sound family';
			}

			if (state.currentRule.key === 'nonprevious' && !state.previousPrompt) {
				ruleTextEl.textContent = 'First round: Tap a DIFFERENT sound family';
			}

			setFeedback('');
		}

		function finishGame() {
			state.running = false;
			state.roundLocked = true;
			clearInterval(state.timerId);
			state.timerId = 0;
			startBtn.disabled = false;
			setStatus('Game over. Final score: ' + state.score);
			setFeedback('Press Start Game to play again.');
		}

		function startGame() {
			const cfg = modeConfig();
			state.running = true;
			state.score = 0;
			state.timeLeft = cfg.duration;
			state.streak = 0;
			state.currentPrompt = null;
			state.previousPrompt = null;
			state.currentRule = null;
			state.lastRuleKey = '';
			state.roundLocked = false;
			updateStats();
			startBtn.disabled = true;
			setStatus('Read the rule. Then tap the correct sound family.');
			setFeedback('');
			nextRound();

			clearInterval(state.timerId);
			state.timerId = setInterval(function () {
				if (!state.running) {
					return;
				}

				state.timeLeft -= 1;
				updateStats();

				if (state.timeLeft <= 0) {
					finishGame();
				}
			}, 1000);
		}

		function resetGame() {
			state.running = false;
			state.score = 0;
			state.timeLeft = modeConfig().duration;
			state.streak = 0;
			state.currentPrompt = null;
			state.previousPrompt = null;
			state.currentRule = null;
			state.lastRuleKey = '';
			state.roundLocked = true;
			clearInterval(state.timerId);
			state.timerId = 0;
			startBtn.disabled = false;
			ruleTextEl.textContent = 'Press Start Game';
			iconEl.textContent = '🔊';
			soundLabelEl.textContent = 'Sound Rule Rush';
			soundHintEl.textContent = 'Sort each sound into the right family.';
			setStatus('Press Start Game to begin.');
			setFeedback('Easy: same or different family. Medium: adds previous family. Hard: adds different from previous.');
			updateStats();
		}

		function solveCurrentAnswer() {
			if (!state.currentRule || !state.currentPrompt) {
				return '';
			}
			return state.currentRule.solve(state.currentPrompt, state.previousPrompt);
		}

		function handleAnswer(value) {
			if (!state.running || state.roundLocked || !state.currentPrompt || !state.currentRule) {
				return;
			}

			state.roundLocked = true;

			const correctValue = solveCurrentAnswer();
			const correct = value === correctValue;
			const cfg = modeConfig();

			if (correct) {
				state.score += cfg.points + Math.min(state.streak, 4);
				state.streak += 1;

				if (state.score > state.best) {
					state.best = state.score;
				}

				setStatus('Correct');
				setFeedback('Nice. ' + categoryLabel(correctValue) + ' was right.');
				pulseBox(true);
			} else {
				state.streak = 0;
				setStatus('Wrong');
				setFeedback('Correct answer was ' + categoryLabel(correctValue) + '.');
				pulseBox(false);
			}

			updateStats();

			setTimeout(function () {
				if (state.running) {
					nextRound();
				}
			}, 320);
		}

		answerButtons.forEach(function (btn) {
			btn.addEventListener('click', function () {
				handleAnswer(btn.getAttribute('data-key'));
			});
		});

		modeButtons.forEach(function (btn) {
			btn.addEventListener('click', function () {
				state.mode = btn.getAttribute('data-mode') || 'easy';
				updateModeButtons();
				if (!state.running) {
					resetGame();
				}
			});
		});

		startBtn.addEventListener('click', function () {
			startGame();
		});

		resetBtn.addEventListener('click', function () {
			resetGame();
		});

		game.addEventListener('keydown', function (event) {
			if (!state.running) {
				return;
			}

			const key = event.key.toLowerCase();

			if (key === '1') {
				event.preventDefault();
				handleAnswer('animal');
			} else if (key === '2') {
				event.preventDefault();
				handleAnswer('machine');
			} else if (key === '3') {
				event.preventDefault();
				handleAnswer('music');
			} else if (key === '4') {
				event.preventDefault();
				handleAnswer('nature');
			}
		});

		updateModeButtons();
		resetGame();
	});
});
JS;

if (!function_exists('zo_game_sound_rule_rush_render')) {
	function zo_game_sound_rule_rush_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-sound-rule-rush-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--sound-rule-rush" id="<?php echo esc_attr($instance_id); ?>" tabindex="0">
			<h2 class="srr-title">Sound Rule Rush</h2>
			<p class="srr-subtitle">Think fast. A sound appears, the rule changes, and you must tap the correct sound family before time runs out.</p>

			<div class="srr-panel">
				<div class="srr-stat">
					<span class="srr-stat-label">Score</span>
					<span class="srr-stat-value srr-score">0</span>
				</div>
				<div class="srr-stat">
					<span class="srr-stat-label">Time</span>
					<span class="srr-stat-value srr-time">40</span>
				</div>
				<div class="srr-stat">
					<span class="srr-stat-label">Streak</span>
					<span class="srr-stat-value srr-streak">0</span>
				</div>
				<div class="srr-stat">
					<span class="srr-stat-label">Best</span>
					<span class="srr-stat-value srr-best">0</span>
				</div>
			</div>

			<div class="srr-controls">
				<button type="button" class="srr-btn srr-btn--mode" data-mode="easy">Easy</button>
				<button type="button" class="srr-btn srr-btn--mode" data-mode="medium">Medium</button>
				<button type="button" class="srr-btn srr-btn--mode" data-mode="hard">Hard</button>
			</div>

			<div class="srr-controls">
				<button type="button" class="srr-btn srr-start">Start Game</button>
				<button type="button" class="srr-btn srr-btn--secondary srr-reset">Reset</button>
			</div>

			<p class="srr-status">Press Start Game to begin.</p>

			<div class="srr-stage">
				<div class="srr-rule-banner">
					<div class="srr-rule-text">Press Start Game</div>
				</div>

				<div class="srr-play-area">
					<div class="srr-prompt-box">
						<h3 class="srr-box-title">Current Sound</h3>
						<div class="srr-sound-card">
							<div class="srr-icon">🔊</div>
							<div class="srr-sound-label">Sound Rule Rush</div>
							<div class="srr-sound-hint">Sort each sound into the right family.</div>
						</div>
						<div class="srr-feedback">Easy: same or different family. Medium: adds previous family. Hard: adds different from previous.</div>
					</div>

					<div class="srr-answer-box">
						<h3 class="srr-box-title">Choose the Family</h3>
						<div class="srr-answer-grid">
							<button type="button" class="srr-answer-btn" data-key="animal">
								Animal
								<span class="srr-answer-sub">1 key</span>
							</button>
							<button type="button" class="srr-answer-btn" data-key="machine">
								Machine
								<span class="srr-answer-sub">2 key</span>
							</button>
							<button type="button" class="srr-answer-btn" data-key="music">
								Music
								<span class="srr-answer-sub">3 key</span>
							</button>
							<button type="button" class="srr-answer-btn" data-key="nature">
								Nature
								<span class="srr-answer-sub">4 key</span>
							</button>
						</div>
					</div>
				</div>

				<p class="srr-help">Keyboard also works. Use keys 1, 2, 3, 4 to answer.</p>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'sound-rule-rush',
	'name'            => 'Sound Rule Rush',
	'author'          => 'Asker',
	'description'     => 'A fast reflex and thinking game where players sort sounds into the correct family as the rules change.',
	'render_callback' => 'zo_game_sound_rule_rush_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);