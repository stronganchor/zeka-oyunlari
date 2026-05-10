<?php
if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root--the-46th-rule {
	min-height: calc(100vh - 110px);
	background: #101820;
	color: #f5efe1;
	font-family: Arial, Helvetica, sans-serif;
	overflow: hidden;
	position: relative;
}
.zo-game-root--the-46th-rule * {
	box-sizing: border-box;
}
.zo-rule46 {
	min-height: calc(100vh - 110px);
	display: grid;
	grid-template-columns: minmax(280px, 380px) minmax(0, 1fr);
	background:
		linear-gradient(90deg, rgba(16, 24, 32, 0.96), rgba(16, 24, 32, 0.76)),
		repeating-linear-gradient(45deg, rgba(235, 188, 90, 0.12) 0 1px, transparent 1px 18px),
		#101820;
}
.zo-rule46__side {
	padding: 28px;
	border-right: 1px solid rgba(245, 239, 225, 0.12);
	background: rgba(8, 13, 18, 0.68);
}
.zo-rule46__kicker {
	margin: 0 0 8px;
	color: #e5bd62;
	font-size: 12px;
	font-weight: 800;
	letter-spacing: 0;
	text-transform: uppercase;
}
.zo-rule46__title {
	margin: 0;
	font-size: clamp(34px, 5vw, 58px);
	line-height: 0.95;
	letter-spacing: 0;
}
.zo-rule46__desc {
	margin: 16px 0 20px;
	color: #cbd5d0;
	line-height: 1.55;
}
.zo-rule46__credit {
	display: grid;
	gap: 6px;
	padding: 14px;
	border: 1px solid rgba(229, 189, 98, 0.42);
	background: rgba(229, 189, 98, 0.1);
	color: #f8e7b5;
}
.zo-rule46__credit strong {
	color: #ffffff;
}
.zo-rule46__rules {
	margin: 22px 0 0;
	padding: 0;
	list-style: none;
	display: grid;
	gap: 10px;
	color: #d6dedb;
	font-size: 14px;
}
.zo-rule46__rules li {
	padding-left: 18px;
	position: relative;
}
.zo-rule46__rules li::before {
	content: "";
	position: absolute;
	left: 0;
	top: 8px;
	width: 7px;
	height: 7px;
	background: #28c7a8;
}
.zo-rule46__stage {
	padding: 28px;
	display: grid;
	grid-template-rows: auto auto minmax(0, 1fr);
	gap: 18px;
}
.zo-rule46__top {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 12px;
}
.zo-rule46__stat {
	border: 1px solid rgba(245, 239, 225, 0.14);
	background: rgba(245, 239, 225, 0.06);
	padding: 12px;
	min-height: 74px;
}
.zo-rule46__label {
	display: block;
	color: #9fb1aa;
	font-size: 12px;
	font-weight: 800;
	text-transform: uppercase;
}
.zo-rule46__value {
	display: block;
	margin-top: 8px;
	font-size: 24px;
	font-weight: 900;
	color: #ffffff;
}
.zo-rule46__workspace {
	display: grid;
	grid-template-columns: minmax(300px, 520px) minmax(280px, 1fr);
	gap: 18px;
	min-height: 0;
}
.zo-rule46__panel {
	border: 1px solid rgba(245, 239, 225, 0.14);
	background: rgba(245, 239, 225, 0.06);
	padding: 18px;
}
.zo-rule46__panel-title {
	margin: 0 0 12px;
	font-size: 18px;
}
.zo-rule46__grid {
	display: grid;
	grid-template-columns: repeat(6, 1fr);
	gap: 8px;
}
.zo-rule46__tile {
	aspect-ratio: 1;
	border: 1px solid rgba(245, 239, 225, 0.16);
	background: #18252f;
	color: #f5efe1;
	font-size: clamp(17px, 3vw, 28px);
	font-weight: 900;
	cursor: pointer;
	transition: transform 0.14s ease, background 0.14s ease, border-color 0.14s ease;
}
.zo-rule46__tile:hover,
.zo-rule46__tile:focus {
	border-color: #e5bd62;
	transform: translateY(-1px);
	outline: none;
}
.zo-rule46__tile.is-picked {
	background: #e5bd62;
	color: #101820;
}
.zo-rule46__tile.is-good {
	background: #28c7a8;
	color: #06110f;
}
.zo-rule46__tile.is-bad {
	background: #d94f4f;
	color: #ffffff;
}
.zo-rule46__sequence {
	min-height: 54px;
	display: flex;
	align-items: center;
	flex-wrap: wrap;
	gap: 8px;
	padding: 10px;
	border: 1px solid rgba(245, 239, 225, 0.14);
	background: rgba(0, 0, 0, 0.16);
}
.zo-rule46__chip {
	min-width: 34px;
	height: 34px;
	display: inline-grid;
	place-items: center;
	background: #f5efe1;
	color: #101820;
	font-weight: 900;
}
.zo-rule46__actions {
	margin-top: 12px;
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
}
.zo-rule46__btn {
	border: 1px solid rgba(245, 239, 225, 0.2);
	background: #f5efe1;
	color: #101820;
	font-weight: 900;
	padding: 11px 14px;
	cursor: pointer;
	min-height: 42px;
}
.zo-rule46__btn:hover,
.zo-rule46__btn:focus {
	background: #e5bd62;
	outline: none;
}
.zo-rule46__btn--quiet {
	background: transparent;
	color: #f5efe1;
}
.zo-rule46__btn--danger {
	background: #d94f4f;
	color: #ffffff;
}
.zo-rule46__log {
	height: 260px;
	overflow: auto;
	display: grid;
	gap: 8px;
	align-content: start;
	padding-right: 4px;
}
.zo-rule46__entry {
	display: grid;
	grid-template-columns: 1fr auto;
	gap: 8px;
	align-items: center;
	padding: 10px;
	background: rgba(0, 0, 0, 0.18);
	border-left: 4px solid #9fb1aa;
}
.zo-rule46__entry.is-pass {
	border-left-color: #28c7a8;
}
.zo-rule46__entry.is-fail {
	border-left-color: #d94f4f;
}
.zo-rule46__entry code {
	color: #ffffff;
	font-weight: 900;
}
.zo-rule46__verdict {
	font-weight: 900;
}
.zo-rule46__message {
	min-height: 48px;
	margin: 0;
	padding: 12px;
	background: rgba(40, 199, 168, 0.12);
	border: 1px solid rgba(40, 199, 168, 0.28);
	color: #dcfff8;
	line-height: 1.45;
}
.zo-rule46__hypothesis {
	display: grid;
	gap: 10px;
}
.zo-rule46__hypothesis textarea {
	width: 100%;
	min-height: 92px;
	resize: vertical;
	border: 1px solid rgba(245, 239, 225, 0.2);
	background: rgba(0, 0, 0, 0.22);
	color: #ffffff;
	padding: 12px;
	font: inherit;
}
.zo-rule46__proof {
	display: none;
	margin-top: 12px;
	padding: 12px;
	background: rgba(229, 189, 98, 0.12);
	border: 1px solid rgba(229, 189, 98, 0.26);
	color: #ffe8ac;
	line-height: 1.45;
}
.zo-rule46__proof.is-visible {
	display: block;
}
@media (max-width: 980px) {
	.zo-rule46,
	.zo-rule46__workspace {
		grid-template-columns: 1fr;
	}
	.zo-rule46__side {
		border-right: 0;
		border-bottom: 1px solid rgba(245, 239, 225, 0.12);
	}
}
@media (max-width: 640px) {
	.zo-game-root--the-46th-rule,
	.zo-rule46 {
		min-height: calc(100vh - 84px);
	}
	.zo-rule46__side,
	.zo-rule46__stage {
		padding: 18px;
	}
	.zo-rule46__top {
		grid-template-columns: repeat(2, minmax(0, 1fr));
	}
	.zo-rule46__grid {
		grid-template-columns: repeat(4, 1fr);
	}
}
CSS;

$js = <<<'JS'
(function () {
	const TOKENS = ['A', 'B', 'C', 'D', 'E', 'F', '1', '2', '3', '4', '5', '6'];
	const SECRET = {
		minLength: 4,
		maxLength: 6,
		requiredLetters: ['A', 'C', 'E'],
		requiredNumbers: ['2', '4'],
		forbidden: 'B'
	};

	function init(root) {
		if (!root || root.dataset.rule46Ready === '1') {
			return;
		}

		const grid = root.querySelector('[data-rule46-grid]');
		const sequenceEl = root.querySelector('[data-rule46-sequence]');
		const logEl = root.querySelector('[data-rule46-log]');
		const messageEl = root.querySelector('[data-rule46-message]');
		const attemptsEl = root.querySelector('[data-rule46-attempts]');
		const passedEl = root.querySelector('[data-rule46-passed]');
		const proofEl = root.querySelector('[data-rule46-proof]');
		const textarea = root.querySelector('[data-rule46-hypothesis]');
		const testButton = root.querySelector('[data-rule46-test]');
		const clearButton = root.querySelector('[data-rule46-clear]');
		const proofButton = root.querySelector('[data-rule46-check]');
		const resetButton = root.querySelector('[data-rule46-reset]');

		if (!grid || !sequenceEl || !logEl || !messageEl || !attemptsEl || !passedEl || !proofEl || !textarea) {
			return;
		}

		root.dataset.rule46Ready = '1';

		const state = {
			sequence: [],
			attempts: 0,
			passed: 0,
			solved: false
		};

		function isLetter(token) {
			return /^[A-F]$/.test(token);
		}

		function isNumber(token) {
			return /^[1-6]$/.test(token);
		}

		function evaluate(sequence) {
			const letters = sequence.filter(isLetter);
			const numbers = sequence.filter(isNumber);
			const unique = new Set(sequence);
			const errors = [];

			if (sequence.length < SECRET.minLength || sequence.length > SECRET.maxLength) {
				errors.push('length');
			}
			if (sequence.includes(SECRET.forbidden)) {
				errors.push('forbidden');
			}
			if (!SECRET.requiredLetters.every(function (token) { return sequence.includes(token); })) {
				errors.push('letters');
			}
			if (!SECRET.requiredNumbers.every(function (token) { return sequence.includes(token); })) {
				errors.push('numbers');
			}
			if (unique.size !== sequence.length) {
				errors.push('repeat');
			}
			if (!sequence.every(function (token, index) {
				if (index === 0) {
					return true;
				}
				return isLetter(token) !== isLetter(sequence[index - 1]);
			})) {
				errors.push('alternation');
			}
			if (letters.length !== numbers.length) {
				errors.push('balance');
			}

			return errors;
		}

		function clueFor(errors) {
			if (errors.length === 0) {
				return 'Accepted. This key obeys the hidden rule.';
			}

			const clues = {
				length: 'The lock listens only to medium-length keys.',
				forbidden: 'One symbol is cursed and never belongs.',
				letters: 'The alphabet side is missing a required shape.',
				numbers: 'The numeric side is missing a required step.',
				repeat: 'The machine refuses echoes.',
				alternation: 'Two neighbors are too similar.',
				balance: 'The key is not balanced between signs and counts.'
			};

			return clues[errors[0]];
		}

		function renderSequence() {
			sequenceEl.innerHTML = '';

			if (state.sequence.length === 0) {
				const empty = document.createElement('span');
				empty.textContent = 'Choose 4 to 6 tokens';
				empty.style.color = '#9fb1aa';
				sequenceEl.appendChild(empty);
			} else {
				state.sequence.forEach(function (token) {
					const chip = document.createElement('span');
					chip.className = 'zo-rule46__chip';
					chip.textContent = token;
					sequenceEl.appendChild(chip);
				});
			}

			grid.querySelectorAll('.zo-rule46__tile').forEach(function (button) {
				button.classList.toggle('is-picked', state.sequence.includes(button.dataset.token));
			});
		}

		function renderStats() {
			attemptsEl.textContent = String(state.attempts);
			passedEl.textContent = String(state.passed);
		}

		function setMessage(text) {
			messageEl.textContent = text;
		}

		function addLog(sequence, passed, clue) {
			const entry = document.createElement('div');
			entry.className = 'zo-rule46__entry ' + (passed ? 'is-pass' : 'is-fail');

			const code = document.createElement('code');
			code.textContent = sequence.join(' ');
			const verdict = document.createElement('span');
			verdict.className = 'zo-rule46__verdict';
			verdict.textContent = passed ? 'PASS' : 'FAIL';
			const text = document.createElement('span');
			text.textContent = clue;

			entry.appendChild(code);
			entry.appendChild(verdict);
			entry.appendChild(text);
			logEl.prepend(entry);
		}

		function testSequence() {
			if (state.sequence.length === 0) {
				setMessage('Pick a token sequence before testing.');
				return;
			}

			const errors = evaluate(state.sequence);
			const passed = errors.length === 0;
			const clue = clueFor(errors);

			state.attempts += 1;
			state.passed += passed ? 1 : 0;
			addLog(state.sequence, passed, clue);
			renderStats();
			setMessage(clue);

			if (passed && state.passed >= 2) {
				setMessage('You have found working keys. Now write the rule, then prove it.');
			}
		}

		function clearSequence() {
			state.sequence = [];
			renderSequence();
			setMessage('Sequence cleared. Try to isolate one rule at a time.');
		}

		function checkHypothesis() {
			const answer = textarea.value.toLowerCase();
			const hits = [
				'a',
				'c',
				'e',
				'2',
				'4',
				'no b',
				'alternate',
				'equal',
				'no repeat'
			].filter(function (word) {
				return answer.includes(word);
			}).length;

			if (hits >= 7) {
				state.solved = true;
				proofEl.classList.add('is-visible');
				proofEl.textContent = 'Proof accepted: use A 2 C 4 E 6 or A 4 C 2 E 6. The hidden rule is: 4-6 unique tokens, no B, exactly the letters A/C/E, includes 2 and 4, alternates letter/number, and keeps letters and numbers balanced.';
				setMessage('The 46th Rule is open. Excellent deduction.');
			} else {
				proofEl.classList.add('is-visible');
				proofEl.textContent = 'Not enough proof yet. Mention the required letters, required numbers, the forbidden symbol, alternation, balance, and no repeats.';
				setMessage('Close, but the lock wants a sharper explanation.');
			}
		}

		function resetGame() {
			state.sequence = [];
			state.attempts = 0;
			state.passed = 0;
			state.solved = false;
			logEl.innerHTML = '';
			textarea.value = '';
			proofEl.classList.remove('is-visible');
			proofEl.textContent = '';
			renderStats();
			renderSequence();
			setMessage('The lock is reset. Build keys, watch pass/fail clues, then prove the rule.');
		}

		TOKENS.forEach(function (token) {
			const button = document.createElement('button');
			button.type = 'button';
			button.className = 'zo-rule46__tile';
			button.dataset.token = token;
			button.textContent = token;
			button.addEventListener('click', function () {
				if (state.sequence.includes(token)) {
					state.sequence = state.sequence.filter(function (item) { return item !== token; });
				} else if (state.sequence.length < SECRET.maxLength) {
					state.sequence.push(token);
				} else {
					setMessage('The lock accepts at most six tokens.');
				}
				renderSequence();
			});
			grid.appendChild(button);
		});

		testButton.addEventListener('click', testSequence);
		clearButton.addEventListener('click', clearSequence);
		proofButton.addEventListener('click', checkHypothesis);
		resetButton.addEventListener('click', resetGame);

		renderStats();
		renderSequence();
		setMessage('Start by testing small changes. The hard part is proving why a key passes.');
	}

	document.addEventListener('DOMContentLoaded', function () {
		document.querySelectorAll('.zo-game-root--the-46th-rule').forEach(init);
	});
}());
JS;

if (!function_exists('zo_game_the_46th_rule')) {
	function zo_game_the_46th_rule($post_id = 0, $module = array()) {
		$instance_id = 'zo-rule46-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--the-46th-rule" id="<?php echo esc_attr($instance_id); ?>">
			<section class="zo-rule46" aria-label="The 46th Rule puzzle game">
				<aside class="zo-rule46__side">
					<p class="zo-rule46__kicker">Very hard deduction game</p>
					<h2 class="zo-rule46__title">The 46th Rule</h2>
					<p class="zo-rule46__desc">Build symbol keys, test them against the lock, and infer the hidden law from pass/fail clues. The final answer is not a guess: it must explain the machine.</p>
					<div class="zo-rule46__credit">
						<span><strong>Idea asker:</strong> Asker</span>
						<span><strong>Game author:</strong> Asker + Codex</span>
						<span><strong>Design note:</strong> Test patterns, compare outcomes, and prove the hidden rule.</span>
					</div>
					<ul class="zo-rule46__rules" aria-label="Game goals">
						<li>Test sequences of 4 to 6 symbols.</li>
						<li>Use clues to discover every hidden condition.</li>
						<li>Write the rule in your own words to unlock proof mode.</li>
					</ul>
				</aside>
				<div class="zo-rule46__stage">
					<div class="zo-rule46__top" aria-label="Stats">
						<div class="zo-rule46__stat">
							<span class="zo-rule46__label">Attempts</span>
							<span class="zo-rule46__value" data-rule46-attempts>0</span>
						</div>
						<div class="zo-rule46__stat">
							<span class="zo-rule46__label">Passed</span>
							<span class="zo-rule46__value" data-rule46-passed>0</span>
						</div>
						<div class="zo-rule46__stat">
							<span class="zo-rule46__label">Difficulty</span>
							<span class="zo-rule46__value">46</span>
						</div>
						<div class="zo-rule46__stat">
							<span class="zo-rule46__label">Mode</span>
							<span class="zo-rule46__value">Proof</span>
						</div>
					</div>
					<p class="zo-rule46__message" data-rule46-message aria-live="polite"></p>
					<div class="zo-rule46__workspace">
						<div class="zo-rule46__panel">
							<h3 class="zo-rule46__panel-title">Key Builder</h3>
							<div class="zo-rule46__sequence" data-rule46-sequence aria-label="Current sequence"></div>
							<div class="zo-rule46__actions">
								<button type="button" class="zo-rule46__btn" data-rule46-test>Test Key</button>
								<button type="button" class="zo-rule46__btn zo-rule46__btn--quiet" data-rule46-clear>Clear</button>
								<button type="button" class="zo-rule46__btn zo-rule46__btn--danger" data-rule46-reset>Reset</button>
							</div>
							<h3 class="zo-rule46__panel-title" style="margin-top:18px;">Symbols</h3>
							<div class="zo-rule46__grid" data-rule46-grid aria-label="Available symbols"></div>
						</div>
						<div class="zo-rule46__panel">
							<h3 class="zo-rule46__panel-title">Experiment Log</h3>
							<div class="zo-rule46__log" data-rule46-log aria-live="polite"></div>
						</div>
						<div class="zo-rule46__panel zo-rule46__hypothesis">
							<h3 class="zo-rule46__panel-title">Prove The Rule</h3>
							<textarea data-rule46-hypothesis placeholder="Example: The key must..."></textarea>
							<button type="button" class="zo-rule46__btn" data-rule46-check>Submit Proof</button>
							<div class="zo-rule46__proof" data-rule46-proof></div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug' => 'the-46th-rule',
	'name' => 'The 46th Rule',
	'author' => 'Asker',
	'description' => 'A very hard hidden-rule deduction game where the player tests symbol keys and proves the logic.',
	'render_callback' => 'zo_game_the_46th_rule',
	'inline_style' => $css,
	'inline_script' => $js,
);
?>
