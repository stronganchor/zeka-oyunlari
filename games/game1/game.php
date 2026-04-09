<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 640px;
	margin: 0 auto;
	font-family: inherit;
}

.zo-game-root.zo-game-root--rule-switch-rush {
	background: linear-gradient(180deg, #f7fbff 0%, #ffffff 100%);
	border: 2px solid #d8e8f6;
	border-radius: 22px;
	padding: 16px;
	box-shadow: 0 12px 28px rgba(0, 0, 0, 0.06);
}

.zo-game-root--rule-switch-rush .rsr-title {
	margin: 0 0 8px;
	font-size: 28px;
	line-height: 1.2;
	text-align: center;
	color: #18344d;
}

.zo-game-root--rule-switch-rush .rsr-subtitle {
	margin: 0 0 14px;
	font-size: 15px;
	line-height: 1.5;
	text-align: center;
	color: #5b7086;
}

.zo-game-root--rule-switch-rush .rsr-panel {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 8px;
	margin-bottom: 12px;
}

.zo-game-root--rule-switch-rush .rsr-stat {
	background: #ffffff;
	border: 2px solid #dbe8f3;
	border-radius: 14px;
	padding: 10px 8px;
	text-align: center;
}

.zo-game-root--rule-switch-rush .rsr-stat-label {
	display: block;
	font-size: 12px;
	color: #688096;
	margin-bottom: 4px;
}

.zo-game-root--rule-switch-rush .rsr-stat-value {
	display: block;
	font-size: 22px;
	font-weight: 700;
	color: #16334f;
}

.zo-game-root--rule-switch-rush .rsr-controls {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
	justify-content: center;
	margin-bottom: 12px;
}

.zo-game-root--rule-switch-rush .rsr-btn {
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

.zo-game-root--rule-switch-rush .rsr-btn:hover,
.zo-game-root--rule-switch-rush .rsr-btn:focus {
	opacity: 0.92;
}

.zo-game-root--rule-switch-rush .rsr-btn:active {
	transform: scale(0.98);
}

.zo-game-root--rule-switch-rush .rsr-btn--secondary {
	background: #546e7a;
}

.zo-game-root--rule-switch-rush .rsr-btn--mode {
	background: #00897b;
}

.zo-game-root--rule-switch-rush .rsr-btn--mode.is-active {
	box-shadow: inset 0 0 0 3px rgba(255, 255, 255, 0.65);
}

.zo-game-root--rule-switch-rush .rsr-status {
	min-height: 24px;
	margin: 0 0 12px;
	font-size: 15px;
	font-weight: 700;
	text-align: center;
	color: #18344d;
}

.zo-game-root--rule-switch-rush .rsr-stage {
	background: linear-gradient(180deg, #eef7ff 0%, #f9fcff 100%);
	border: 2px solid #dbe8f3;
	border-radius: 18px;
	padding: 14px;
}

.zo-game-root--rule-switch-rush .rsr-rule-banner {
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

.zo-game-root--rule-switch-rush .rsr-rule-text {
	font-size: 18px;
	font-weight: 800;
	line-height: 1.35;
	color: #0f3050;
}

.zo-game-root--rule-switch-rush .rsr-play-area {
	display: grid;
	grid-template-columns: 1fr;
	gap: 12px;
}

.zo-game-root--rule-switch-rush .rsr-prompt-box {
	background: #ffffff;
	border: 2px solid #dbe8f3;
	border-radius: 18px;
	padding: 16px;
	text-align: center;
}

.zo-game-root--rule-switch-rush .rsr-prompt-label {
	margin: 0 0 10px;
	font-size: 14px;
	font-weight: 700;
	color: #60788f;
}

.zo-game-root--rule-switch-rush .rsr-prompt {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	width: 180px;
	height: 180px;
	border-radius: 24px;
	background: linear-gradient(180deg, #f9fcff 0%, #edf6ff 100%);
	border: 3px solid #d7e7f5;
	box-shadow: inset 0 0 0 8px rgba(255, 255, 255, 0.85);
}

.zo-game-root--rule-switch-rush .rsr-symbol {
	font-size: 86px;
	line-height: 1;
	font-weight: 700;
	user-select: none;
}

.zo-game-root--rule-switch-rush .rsr-answer-grid {
	display: grid;
	grid-template-columns: repeat(2, minmax(0, 1fr));
	gap: 10px;
}

.zo-game-root--rule-switch-rush .rsr-answer-btn {
	appearance: none;
	border: 0;
	border-radius: 16px;
	padding: 16px 10px;
	font-size: 28px;
	font-weight: 800;
	cursor: pointer;
	color: #ffffff;
	min-height: 84px;
	transition: transform 0.08s ease, opacity 0.12s ease, box-shadow 0.12s ease;
	box-shadow: 0 8px 18px rgba(0, 0, 0, 0.10);
}

.zo-game-root--rule-switch-rush .rsr-answer-btn:hover,
.zo-game-root--rule-switch-rush .rsr-answer-btn:focus {
	opacity: 0.94;
}

.zo-game-root--rule-switch-rush .rsr-answer-btn:active {
	transform: scale(0.98);
}

.zo-game-root--rule-switch-rush .rsr-answer-btn[data-value="up"] {
	background: #ef5350;
}

.zo-game-root--rule-switch-rush .rsr-answer-btn[data-value="right"] {
	background: #42a5f5;
}

.zo-game-root--rule-switch-rush .rsr-answer-btn[data-value="left"] {
	background: #ab47bc;
}

.zo-game-root--rule-switch-rush .rsr-answer-btn[data-value="down"] {
	background: #66bb6a;
}

.zo-game-root--rule-switch-rush .rsr-feedback {
	min-height: 22px;
	margin-top: 10px;
	font-size: 14px;
	font-weight: 700;
	color: #60788f;
	text-align: center;
}

.zo-game-root--rule-switch-rush .rsr-help {
	margin-top: 12px;
	font-size: 12px;
	line-height: 1.5;
	color: #60788f;
	text-align: center;
}

.zo-game-root--rule-switch-rush .rsr-flash-good {
	animation: rsr-good 0.28s ease;
}

.zo-game-root--rule-switch-rush .rsr-flash-bad {
	animation: rsr-bad 0.28s ease;
}

@keyframes rsr-good {
	0% { box-shadow: 0 0 0 rgba(76, 175, 80, 0); }
	50% { box-shadow: 0 0 0 8px rgba(76, 175, 80, 0.18); }
	100% { box-shadow: 0 0 0 rgba(76, 175, 80, 0); }
}

@keyframes rsr-bad {
	0% { box-shadow: 0 0 0 rgba(239, 83, 80, 0); }
	50% { box-shadow: 0 0 0 8px rgba(239, 83, 80, 0.18); }
	100% { box-shadow: 0 0 0 rgba(239, 83, 80, 0); }
}

@media (max-width: 640px) {
	.zo-game-root--rule-switch-rush .rsr-panel {
		grid-template-columns: repeat(2, minmax(0, 1fr));
	}

	.zo-game-root--rule-switch-rush .rsr-prompt {
		width: 150px;
		height: 150px;
	}

	.zo-game-root--rule-switch-rush .rsr-symbol {
		font-size: 72px;
	}

	.zo-game-root--rule-switch-rush .rsr-answer-btn {
		min-height: 74px;
		font-size: 24px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--rule-switch-rush');

	games.forEach(function (game) {
		const scoreEl = game.querySelector('.rsr-score');
		const timeEl = game.querySelector('.rsr-time');
		const streakEl = game.querySelector('.rsr-streak');
		const bestEl = game.querySelector('.rsr-best');
		const statusEl = game.querySelector('.rsr-status');
		const feedbackEl = game.querySelector('.rsr-feedback');
		const ruleTextEl = game.querySelector('.rsr-rule-text');
		const symbolEl = game.querySelector('.rsr-symbol');
		const promptBoxEl = game.querySelector('.rsr-prompt-box');
		const startBtn = game.querySelector('.rsr-start');
		const resetBtn = game.querySelector('.rsr-reset');
		const modeButtons = game.querySelectorAll('.rsr-btn--mode');
		const answerButtons = game.querySelectorAll('.rsr-answer-btn');

		const prompts = [
			{ value: 'up', symbol: '↑' },
			{ value: 'right', symbol: '→' },
			{ value: 'down', symbol: '↓' },
			{ value: 'left', symbol: '←' }
		];

		const rules = [
			{
				key: 'same',
				text: 'Tap the SAME direction',
				solve: function (prompt) {
					return prompt.value;
				}
			},
			{
				key: 'opposite',
				text: 'Tap the OPPOSITE direction',
				solve: function (prompt) {
					if (prompt.value === 'up') { return 'down'; }
					if (prompt.value === 'down') { return 'up'; }
					if (prompt.value === 'left') { return 'right'; }
					return 'left';
				}
			},
			{
				key: 'clockwise',
				text: 'Tap one step CLOCKWISE',
				solve: function (prompt) {
					if (prompt.value === 'up') { return 'right'; }
					if (prompt.value === 'right') { return 'down'; }
					if (prompt.value === 'down') { return 'left'; }
					return 'up';
				}
			},
			{
				key: 'counter',
				text: 'Tap one step COUNTERCLOCKWISE',
				solve: function (prompt) {
					if (prompt.value === 'up') { return 'left'; }
					if (prompt.value === 'left') { return 'down'; }
					if (prompt.value === 'down') { return 'right'; }
					return 'up';
				}
			}
		];

		const state = {
			running: false,
			mode: 'easy',
			score: 0,
			timeLeft: 30,
			streak: 0,
			best: 0,
			currentPrompt: null,
			currentRule: null,
			roundLocked: false,
			lastRuleKey: '',
			timerId: 0
		};

		function modeConfig() {
			if (state.mode === 'hard') {
				return {
					duration: 30,
					rules: ['same', 'opposite', 'clockwise', 'counter'],
					points: 2
				};
			}

			if (state.mode === 'medium') {
				return {
					duration: 35,
					rules: ['same', 'opposite', 'clockwise'],
					points: 1
				};
			}

			return {
				duration: 40,
				rules: ['same', 'opposite'],
				points: 1
			};
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

		function getRuleByKey(key) {
			for (let i = 0; i < rules.length; i++) {
				if (rules[i].key === key) {
					return rules[i];
				}
			}
			return rules[0];
		}

		function randomItem(arr) {
			return arr[Math.floor(Math.random() * arr.length)];
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
			state.currentPrompt = randomItem(prompts);
			symbolEl.textContent = state.currentPrompt.symbol;
		}

		function pulseBox(isGood) {
			promptBoxEl.classList.remove('rsr-flash-good', 'rsr-flash-bad');
			void promptBoxEl.offsetWidth;
			promptBoxEl.classList.add(isGood ? 'rsr-flash-good' : 'rsr-flash-bad');
		}

		function nextRound() {
			state.roundLocked = false;
			nextRule();
			nextPrompt();
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
			state.roundLocked = false;
			state.lastRuleKey = '';
			updateStats();
			startBtn.disabled = true;
			setStatus('Watch the rule. Then tap the correct arrow.');
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
			state.currentRule = null;
			state.roundLocked = true;
			state.lastRuleKey = '';
			clearInterval(state.timerId);
			state.timerId = 0;
			startBtn.disabled = false;
			ruleTextEl.textContent = 'Press Start Game';
			symbolEl.textContent = '⬤';
			setStatus('Press Start Game to begin.');
			setFeedback('Easy: same or opposite. Medium: adds clockwise. Hard: adds counterclockwise too.');
			updateStats();
		}

		function handleAnswer(value) {
			if (!state.running || state.roundLocked || !state.currentPrompt || !state.currentRule) {
				return;
			}

			state.roundLocked = true;

			const correctValue = state.currentRule.solve(state.currentPrompt);
			const correct = value === correctValue;
			const cfg = modeConfig();

			if (correct) {
				state.score += cfg.points + Math.min(state.streak, 4);
				state.streak += 1;
				if (state.score > state.best) {
					state.best = state.score;
				}
				setStatus('Correct');
				setFeedback('Nice. Combo bonus is now ' + state.streak + '.');
				pulseBox(true);
			} else {
				state.streak = 0;
				setStatus('Wrong');
				setFeedback('Correct answer was ' + correctValue.toUpperCase() + '.');
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
				handleAnswer(btn.getAttribute('data-value'));
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

			if (event.key === 'ArrowUp') {
				event.preventDefault();
				handleAnswer('up');
			} else if (event.key === 'ArrowRight') {
				event.preventDefault();
				handleAnswer('right');
			} else if (event.key === 'ArrowDown') {
				event.preventDefault();
				handleAnswer('down');
			} else if (event.key === 'ArrowLeft') {
				event.preventDefault();
				handleAnswer('left');
			}
		});

		updateModeButtons();
		resetGame();
	});
});
JS;

if (!function_exists('zo_game_rule_switch_rush_render')) {
	function zo_game_rule_switch_rush_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-rule-switch-rush-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--rule-switch-rush" id="<?php echo esc_attr($instance_id); ?>" tabindex="0">
			<h2 class="rsr-title">Rule Switch Rush</h2>
			<p class="rsr-subtitle">Think fast. The rule keeps changing. Watch the big arrow, read the rule, and tap the correct answer before time runs out.</p>

			<div class="rsr-panel">
				<div class="rsr-stat">
					<span class="rsr-stat-label">Score</span>
					<span class="rsr-stat-value rsr-score">0</span>
				</div>
				<div class="rsr-stat">
					<span class="rsr-stat-label">Time</span>
					<span class="rsr-stat-value rsr-time">40</span>
				</div>
				<div class="rsr-stat">
					<span class="rsr-stat-label">Streak</span>
					<span class="rsr-stat-value rsr-streak">0</span>
				</div>
				<div class="rsr-stat">
					<span class="rsr-stat-label">Best</span>
					<span class="rsr-stat-value rsr-best">0</span>
				</div>
			</div>

			<div class="rsr-controls">
				<button type="button" class="rsr-btn rsr-btn--mode" data-mode="easy">Easy</button>
				<button type="button" class="rsr-btn rsr-btn--mode" data-mode="medium">Medium</button>
				<button type="button" class="rsr-btn rsr-btn--mode" data-mode="hard">Hard</button>
			</div>

			<div class="rsr-controls">
				<button type="button" class="rsr-btn rsr-start">Start Game</button>
				<button type="button" class="rsr-btn rsr-btn--secondary rsr-reset">Reset</button>
			</div>

			<p class="rsr-status">Press Start Game to begin.</p>

			<div class="rsr-stage">
				<div class="rsr-rule-banner">
					<div class="rsr-rule-text">Press Start Game</div>
				</div>

				<div class="rsr-play-area">
					<div class="rsr-prompt-box">
						<p class="rsr-prompt-label">Prompt</p>
						<div class="rsr-prompt">
							<span class="rsr-symbol">⬤</span>
						</div>
						<div class="rsr-feedback">Easy: same or opposite. Medium: adds clockwise. Hard: adds counterclockwise too.</div>
					</div>

					<div class="rsr-answer-grid">
						<button type="button" class="rsr-answer-btn" data-value="up" aria-label="Up">↑</button>
						<button type="button" class="rsr-answer-btn" data-value="right" aria-label="Right">→</button>
						<button type="button" class="rsr-answer-btn" data-value="left" aria-label="Left">←</button>
						<button type="button" class="rsr-answer-btn" data-value="down" aria-label="Down">↓</button>
					</div>
				</div>

				<p class="rsr-help">Keyboard also works. Use the arrow keys to answer.</p>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'rule-switch-rush',
	'name'            => 'Rule Switch Rush',
	'author'          => 'Asker',
	'description'     => 'A fast reflex and thinking game where the rule changes and players must choose the correct direction.',
	'render_callback' => 'zo_game_rule_switch_rush_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);