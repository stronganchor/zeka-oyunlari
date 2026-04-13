<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--ai-companion-trainer {
	--act-bg: linear-gradient(180deg, #fff8e8 0%, #ffe2b8 100%);
	--act-panel: rgba(255, 252, 245, 0.92);
	--act-line: #d8b278;
	--act-text: #2c2218;
	--act-muted: #735d43;
	--act-accent: #d46a2e;
	--act-accent-strong: #9f3817;
	--act-good: #216e4b;
	--act-warn: #a24a1d;
	max-width: 1120px;
	margin: 0 auto;
	padding: 24px;
	border-radius: 28px;
	background:
		radial-gradient(circle at top right, rgba(255, 255, 255, 0.9), transparent 30%),
		radial-gradient(circle at bottom left, rgba(212, 106, 46, 0.14), transparent 28%),
		var(--act-bg);
	border: 2px solid rgba(120, 72, 33, 0.22);
	box-shadow: 0 20px 50px rgba(110, 60, 20, 0.14);
	box-sizing: border-box;
	font-family: "Trebuchet MS", "Segoe UI", sans-serif;
	color: var(--act-text);
}

.zo-game-root--ai-companion-trainer .zo-act-shell {
	display: grid;
	grid-template-columns: minmax(0, 1.4fr) minmax(300px, 0.95fr);
	gap: 18px;
	align-items: start;
}

.zo-game-root--ai-companion-trainer .zo-act-panel {
	background: var(--act-panel);
	border: 1px solid rgba(120, 72, 33, 0.18);
	border-radius: 22px;
	padding: 18px;
	box-sizing: border-box;
	backdrop-filter: blur(4px);
}

.zo-game-root--ai-companion-trainer .zo-act-hero {
	margin-bottom: 18px;
}

.zo-game-root--ai-companion-trainer .zo-act-eyebrow {
	display: inline-flex;
	align-items: center;
	gap: 8px;
	padding: 6px 12px;
	border-radius: 999px;
	background: rgba(212, 106, 46, 0.12);
	color: var(--act-accent-strong);
	font-size: 12px;
	font-weight: 800;
	letter-spacing: 0.08em;
	text-transform: uppercase;
}

.zo-game-root--ai-companion-trainer .zo-act-title {
	margin: 14px 0 8px;
	font-size: 38px;
	line-height: 1;
	letter-spacing: -0.03em;
}

.zo-game-root--ai-companion-trainer .zo-act-intro {
	margin: 0;
	max-width: 740px;
	font-size: 16px;
	line-height: 1.6;
	color: var(--act-muted);
}

.zo-game-root--ai-companion-trainer .zo-act-stats {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 12px;
	margin: 18px 0 0;
}

.zo-game-root--ai-companion-trainer .zo-act-stat {
	padding: 14px;
	border-radius: 18px;
	background: rgba(255, 255, 255, 0.78);
	border: 1px solid rgba(120, 72, 33, 0.14);
}

.zo-game-root--ai-companion-trainer .zo-act-stat-label {
	display: block;
	margin-bottom: 6px;
	font-size: 12px;
	font-weight: 800;
	letter-spacing: 0.08em;
	text-transform: uppercase;
	color: var(--act-muted);
}

.zo-game-root--ai-companion-trainer .zo-act-stat-value {
	display: block;
	font-size: 28px;
	line-height: 1;
	font-weight: 800;
}

.zo-game-root--ai-companion-trainer .zo-act-mission {
	position: relative;
	overflow: hidden;
}

.zo-game-root--ai-companion-trainer .zo-act-mission::after {
	content: "";
	position: absolute;
	inset: auto -40px -40px auto;
	width: 160px;
	height: 160px;
	border-radius: 50%;
	background: rgba(212, 106, 46, 0.08);
}

.zo-game-root--ai-companion-trainer .zo-act-round-line {
	display: flex;
	justify-content: space-between;
	gap: 12px;
	align-items: center;
	margin-bottom: 12px;
	font-size: 14px;
	font-weight: 700;
	color: var(--act-muted);
}

.zo-game-root--ai-companion-trainer .zo-act-scenario-title {
	margin: 0 0 10px;
	font-size: 28px;
	line-height: 1.15;
}

.zo-game-root--ai-companion-trainer .zo-act-scenario-text {
	margin: 0 0 14px;
	font-size: 16px;
	line-height: 1.65;
	color: var(--act-text);
}

.zo-game-root--ai-companion-trainer .zo-act-tags {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
	margin-bottom: 16px;
}

.zo-game-root--ai-companion-trainer .zo-act-tag {
	padding: 7px 10px;
	border-radius: 999px;
	background: rgba(115, 93, 67, 0.1);
	color: var(--act-muted);
	font-size: 12px;
	font-weight: 700;
}

.zo-game-root--ai-companion-trainer .zo-act-ai-box {
	margin-bottom: 16px;
	padding: 14px;
	border-radius: 18px;
	background: #fffaf2;
	border: 1px dashed rgba(120, 72, 33, 0.28);
}

.zo-game-root--ai-companion-trainer .zo-act-ai-label {
	margin-bottom: 6px;
	font-size: 12px;
	font-weight: 800;
	letter-spacing: 0.08em;
	text-transform: uppercase;
	color: var(--act-muted);
}

.zo-game-root--ai-companion-trainer .zo-act-ai-prediction {
	font-size: 22px;
	font-weight: 800;
	line-height: 1.2;
	color: var(--act-accent-strong);
}

.zo-game-root--ai-companion-trainer .zo-act-ai-reason {
	margin-top: 6px;
	font-size: 14px;
	line-height: 1.5;
	color: var(--act-muted);
}

.zo-game-root--ai-companion-trainer .zo-act-actions {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 10px;
}

.zo-game-root--ai-companion-trainer .zo-act-action {
	text-align: left;
	border: 1px solid rgba(120, 72, 33, 0.18);
	border-radius: 18px;
	padding: 14px;
	background: rgba(255, 255, 255, 0.78);
	cursor: pointer;
	transition: transform 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease;
}

.zo-game-root--ai-companion-trainer .zo-act-action:hover,
.zo-game-root--ai-companion-trainer .zo-act-action:focus-visible {
	transform: translateY(-2px);
	border-color: rgba(159, 56, 23, 0.42);
	box-shadow: 0 10px 20px rgba(120, 72, 33, 0.12);
	outline: none;
}

.zo-game-root--ai-companion-trainer .zo-act-action:disabled {
	opacity: 0.58;
	cursor: default;
	transform: none;
	box-shadow: none;
}

.zo-game-root--ai-companion-trainer .zo-act-action-title {
	display: block;
	margin-bottom: 5px;
	font-size: 16px;
	font-weight: 800;
	color: var(--act-text);
}

.zo-game-root--ai-companion-trainer .zo-act-action-text {
	display: block;
	font-size: 13px;
	line-height: 1.45;
	color: var(--act-muted);
}

.zo-game-root--ai-companion-trainer .zo-act-status {
	min-height: 28px;
	margin-top: 14px;
	font-size: 15px;
	font-weight: 700;
	color: var(--act-muted);
}

.zo-game-root--ai-companion-trainer .zo-act-progress {
	margin-top: 12px;
	height: 12px;
	border-radius: 999px;
	background: rgba(120, 72, 33, 0.12);
	overflow: hidden;
}

.zo-game-root--ai-companion-trainer .zo-act-progress-fill {
	height: 100%;
	width: 0;
	border-radius: inherit;
	background: linear-gradient(90deg, #d46a2e 0%, #efb35a 100%);
	transition: width 0.3s ease;
}

.zo-game-root--ai-companion-trainer .zo-act-side {
	display: grid;
	gap: 18px;
}

.zo-game-root--ai-companion-trainer .zo-act-side-title {
	margin: 0 0 10px;
	font-size: 20px;
}

.zo-game-root--ai-companion-trainer .zo-act-meter-row {
	display: grid;
	gap: 12px;
}

.zo-game-root--ai-companion-trainer .zo-act-meter-label {
	display: flex;
	justify-content: space-between;
	gap: 10px;
	margin-bottom: 6px;
	font-size: 13px;
	font-weight: 700;
	color: var(--act-muted);
}

.zo-game-root--ai-companion-trainer .zo-act-meter {
	height: 12px;
	border-radius: 999px;
	background: rgba(120, 72, 33, 0.12);
	overflow: hidden;
}

.zo-game-root--ai-companion-trainer .zo-act-meter > span {
	display: block;
	height: 100%;
	width: 0;
	border-radius: inherit;
	background: linear-gradient(90deg, #8fcd7d 0%, #216e4b 100%);
	transition: width 0.35s ease;
}

.zo-game-root--ai-companion-trainer .zo-act-badges {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
}

.zo-game-root--ai-companion-trainer .zo-act-badge {
	padding: 8px 10px;
	border-radius: 999px;
	background: rgba(212, 106, 46, 0.1);
	font-size: 12px;
	font-weight: 700;
	color: var(--act-accent-strong);
}

.zo-game-root--ai-companion-trainer .zo-act-log {
	margin: 0;
	padding-left: 20px;
	font-size: 14px;
	line-height: 1.5;
	color: var(--act-text);
}

.zo-game-root--ai-companion-trainer .zo-act-log li + li {
	margin-top: 8px;
}

.zo-game-root--ai-companion-trainer .zo-act-summary {
	display: none;
}

.zo-game-root--ai-companion-trainer .zo-act-summary.is-visible {
	display: block;
}

.zo-game-root--ai-companion-trainer .zo-act-summary-card {
	padding: 18px;
	border-radius: 20px;
	background: linear-gradient(180deg, #fffdf8 0%, #fff2d6 100%);
	border: 1px solid rgba(120, 72, 33, 0.18);
}

.zo-game-root--ai-companion-trainer .zo-act-summary-title {
	margin: 0 0 6px;
	font-size: 28px;
	line-height: 1.1;
}

.zo-game-root--ai-companion-trainer .zo-act-summary-text {
	margin: 0 0 12px;
	font-size: 15px;
	line-height: 1.6;
	color: var(--act-muted);
}

.zo-game-root--ai-companion-trainer .zo-act-restart {
	margin-top: 14px;
	width: 100%;
	border: 0;
	border-radius: 16px;
	padding: 14px;
	background: linear-gradient(90deg, #9f3817 0%, #d46a2e 100%);
	color: #fff8ef;
	font-size: 15px;
	font-weight: 800;
	cursor: pointer;
}

.zo-game-root--ai-companion-trainer .zo-act-finished .zo-act-mission {
	opacity: 0.6;
	pointer-events: none;
}

@media (max-width: 900px) {
	.zo-game-root--ai-companion-trainer .zo-act-shell {
		grid-template-columns: 1fr;
	}
}

@media (max-width: 700px) {
	.zo-game-root.zo-game-root--ai-companion-trainer {
		padding: 16px;
		border-radius: 22px;
	}

	.zo-game-root--ai-companion-trainer .zo-act-title {
		font-size: 30px;
	}

	.zo-game-root--ai-companion-trainer .zo-act-stats,
	.zo-game-root--ai-companion-trainer .zo-act-actions {
		grid-template-columns: 1fr;
	}

	.zo-game-root--ai-companion-trainer .zo-act-scenario-title {
		font-size: 24px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--ai-companion-trainer');

	games.forEach(function (game) {
		const scenarios = [
			{
				title: 'Confusing Parent Message',
				prompt: 'A parent writes: "The homework link does not work and my child is upset." The message is short and you do not know which class page they opened.',
				tags: ['parent', 'support', 'unclear'],
				correctAction: 'ask',
				why: 'The AI should ask one clarifying question before solving the wrong problem.'
			},
			{
				title: 'Simple Weekly Summary',
				prompt: 'Your teammate needs a clean 3-bullet summary of this week’s classroom wins. The notes are already organized and complete.',
				tags: ['writing', 'summary', 'clear'],
				correctAction: 'draft',
				why: 'This is ready for a polished first draft.'
			},
			{
				title: 'Suspicious Fact Sheet',
				prompt: 'The AI is preparing a science handout, but one source looks outdated and another number seems off.',
				tags: ['facts', 'risk', 'verification'],
				correctAction: 'check',
				why: 'A careful fact check matters more than speed here.'
			},
			{
				title: 'Angry Customer Refund',
				prompt: 'A customer says they were charged twice and threatens to post about it publicly if nobody answers today.',
				tags: ['customer', 'urgent', 'money'],
				correctAction: 'escalate',
				why: 'Money issues and high emotion should go to a human lead quickly.'
			},
			{
				title: 'Translate Club Invite',
				prompt: 'You need a friendly Turkish-to-English translation for a short school club invitation. The text is straightforward.',
				tags: ['translation', 'clear', 'writing'],
				correctAction: 'draft',
				why: 'The task is well-scoped and safe for the AI to draft.'
			},
			{
				title: 'Missing Delivery Details',
				prompt: 'A message says: "Please reorder the same supplies as last time." There is no previous order attached.',
				tags: ['logistics', 'unclear', 'support'],
				correctAction: 'ask',
				why: 'Without the missing details, the AI would just guess.'
			},
			{
				title: 'Medical Schedule Change',
				prompt: 'A family asks if changing a child’s medicine time by two hours is safe.',
				tags: ['medical', 'risk', 'urgent'],
				correctAction: 'escalate',
				why: 'Medical guidance should not be improvised by the AI.'
			},
			{
				title: 'Product Comparison Draft',
				prompt: 'You have three products, accurate notes, and a request for a quick comparison paragraph for the website.',
				tags: ['writing', 'marketing', 'clear'],
				correctAction: 'draft',
				why: 'The information is ready and the AI can turn it into copy.'
			},
			{
				title: 'Conflicting Meeting Times',
				prompt: 'Two calendar screenshots disagree about when the event starts.',
				tags: ['schedule', 'verification', 'unclear'],
				correctAction: 'check',
				why: 'The AI should verify instead of confidently repeating the wrong time.'
			},
			{
				title: 'Upset Student Report',
				prompt: 'A student says another child keeps targeting them and asks for help privately.',
				tags: ['student', 'safety', 'urgent'],
				correctAction: 'escalate',
				why: 'Safety concerns need a real person, not an AI-only response.'
			},
			{
				title: 'Clean FAQ Rewrite',
				prompt: 'You have a complete FAQ and want it rewritten to sound warmer and simpler for younger readers.',
				tags: ['writing', 'style', 'clear'],
				correctAction: 'draft',
				why: 'This is a strong use case for an AI teammate.'
			},
			{
				title: 'Broken Form Bug',
				prompt: 'A volunteer says "the signup form is broken," but does not say which device, page, or browser they used.',
				tags: ['support', 'bug', 'unclear'],
				correctAction: 'ask',
				why: 'The AI needs a little context before it can troubleshoot well.'
			}
		];

		const actions = {
			draft: {
				label: 'Let the AI Draft',
				description: 'Have your teammate produce a first version right away.'
			},
			ask: {
				label: 'Ask a Clarifying Question',
				description: 'Pause and gather the missing detail before acting.'
			},
			check: {
				label: 'Double-Check Facts',
				description: 'Verify details before the AI commits to an answer.'
			},
			escalate: {
				label: 'Escalate to a Human',
				description: 'Send the case to a person because the risk is too high.'
			}
		};

		const state = {
			round: 0,
			totalRounds: scenarios.length,
			alignment: 46,
			trust: 58,
			accuracy: 0,
			corrections: 0,
			streak: 0,
			tagWeights: {},
			globalWeights: {
				draft: 0,
				ask: 0,
				check: 0,
				escalate: 0
			},
			history: []
		};

		const scenarioTitleEl = game.querySelector('.zo-act-scenario-title');
		const scenarioTextEl = game.querySelector('.zo-act-scenario-text');
		const tagsEl = game.querySelector('.zo-act-tags');
		const predictionEl = game.querySelector('.zo-act-ai-prediction');
		const reasonEl = game.querySelector('.zo-act-ai-reason');
		const statusEl = game.querySelector('.zo-act-status');
		const roundEl = game.querySelector('.zo-act-round');
		const accuracyEl = game.querySelector('.zo-act-accuracy');
		const trustEl = game.querySelector('.zo-act-trust');
		const correctionEl = game.querySelector('.zo-act-corrections');
		const progressEl = game.querySelector('.zo-act-progress-fill');
		const alignmentBarEl = game.querySelector('.zo-act-alignment-bar');
		const trustBarEl = game.querySelector('.zo-act-trust-bar');
		const confidenceBarEl = game.querySelector('.zo-act-confidence-bar');
		const alignmentTextEl = game.querySelector('.zo-act-alignment-text');
		const trustTextEl = game.querySelector('.zo-act-trust-text');
		const confidenceTextEl = game.querySelector('.zo-act-confidence-text');
		const badgeWrapEl = game.querySelector('.zo-act-badges');
		const logEl = game.querySelector('.zo-act-log');
		const summaryEl = game.querySelector('.zo-act-summary');
		const summaryTitleEl = game.querySelector('.zo-act-summary-title');
		const summaryTextEl = game.querySelector('.zo-act-summary-text');
		const actionButtons = Array.from(game.querySelectorAll('.zo-act-action'));
		const restartBtn = game.querySelector('.zo-act-restart');

		let currentScenario = null;
		let currentPrediction = null;
		let currentConfidence = 0;
		let locked = false;

		function scoreActionForScenario(scenario, actionKey) {
			let score = state.globalWeights[actionKey] || 0;

			scenario.tags.forEach(function (tag) {
				if (!state.tagWeights[tag]) {
					state.tagWeights[tag] = {
						draft: 0,
						ask: 0,
						check: 0,
						escalate: 0
					};
				}

				score += state.tagWeights[tag][actionKey] || 0;
			});

			if (actionKey === 'escalate' && scenario.tags.indexOf('risk') !== -1) {
				score += 0.7;
			}

			if (actionKey === 'ask' && scenario.tags.indexOf('unclear') !== -1) {
				score += 0.7;
			}

			if (actionKey === 'check' && scenario.tags.indexOf('verification') !== -1) {
				score += 0.7;
			}

			if (actionKey === 'draft' && scenario.tags.indexOf('clear') !== -1) {
				score += 0.7;
			}

			return score;
		}

		function getPrediction(scenario) {
			const ranked = Object.keys(actions).map(function (key) {
				return {
					key: key,
					score: scoreActionForScenario(scenario, key)
				};
			}).sort(function (a, b) {
				return b.score - a.score;
			});

			const top = ranked[0];
			const second = ranked[1];
			const confidence = Math.max(18, Math.min(96, Math.round(50 + ((top.score - second.score) * 18))));

			return {
				key: top.key,
				confidence: confidence,
				reason: buildReason(scenario, top.key)
			};
		}

		function buildReason(scenario, actionKey) {
			const hints = [];

			if (scenario.tags.indexOf('unclear') !== -1) {
				hints.push('the request is missing details');
			}

			if (scenario.tags.indexOf('risk') !== -1 || scenario.tags.indexOf('safety') !== -1 || scenario.tags.indexOf('medical') !== -1) {
				hints.push('there is real-world risk');
			}

			if (scenario.tags.indexOf('verification') !== -1 || scenario.tags.indexOf('facts') !== -1 || scenario.tags.indexOf('schedule') !== -1) {
				hints.push('the facts might be wrong');
			}

			if (scenario.tags.indexOf('clear') !== -1 || scenario.tags.indexOf('writing') !== -1) {
				hints.push('the task is already well-scoped');
			}

			if (!hints.length) {
				hints.push('it feels similar to earlier examples');
			}

			return 'I picked "' + actions[actionKey].label + '" because ' + hints.slice(0, 2).join(' and ') + '.';
		}

		function renderBadges() {
			const badges = [];

			if (state.alignment >= 80) {
				badges.push('Strong Alignment');
			}

			if (state.trust >= 80) {
				badges.push('Reliable Teammate');
			}

			if (state.corrections >= 4) {
				badges.push('Patient Coach');
			}

			if (state.streak >= 3) {
				badges.push('Learning Streak x' + state.streak);
			}

			if (!badges.length) {
				badges.push('Training In Progress');
			}

			badgeWrapEl.innerHTML = '';
			badges.forEach(function (badge) {
				const span = document.createElement('span');
				span.className = 'zo-act-badge';
				span.textContent = badge;
				badgeWrapEl.appendChild(span);
			});
		}

		function renderLog() {
			logEl.innerHTML = '';

			if (!state.history.length) {
				const item = document.createElement('li');
				item.textContent = 'Your AI teammate is waiting for its first lesson.';
				logEl.appendChild(item);
				return;
			}

			state.history.slice(-5).reverse().forEach(function (entry) {
				const item = document.createElement('li');
				item.textContent = entry;
				logEl.appendChild(item);
			});
		}

		function updateMeters() {
			roundEl.textContent = state.round + ' / ' + state.totalRounds;
			accuracyEl.textContent = state.accuracy + '%';
			trustEl.textContent = state.trust + '%';
			correctionEl.textContent = state.corrections;
			progressEl.style.width = ((state.round / state.totalRounds) * 100) + '%';
			alignmentBarEl.style.width = state.alignment + '%';
			trustBarEl.style.width = state.trust + '%';
			confidenceBarEl.style.width = currentConfidence + '%';
			alignmentTextEl.textContent = state.alignment + '%';
			trustTextEl.textContent = state.trust + '%';
			confidenceTextEl.textContent = currentConfidence + '%';
			renderBadges();
			renderLog();
		}

		function renderScenario() {
			currentScenario = scenarios[state.round];

			if (!currentScenario) {
				finishGame();
				return;
			}

			locked = false;
			actionButtons.forEach(function (button) {
				button.disabled = false;
			});

			currentPrediction = getPrediction(currentScenario);
			currentConfidence = currentPrediction.confidence;

			scenarioTitleEl.textContent = currentScenario.title;
			scenarioTextEl.textContent = currentScenario.prompt;
			predictionEl.textContent = actions[currentPrediction.key].label;
			reasonEl.textContent = currentPrediction.reason;
			tagsEl.innerHTML = '';
			currentScenario.tags.forEach(function (tag) {
				const span = document.createElement('span');
				span.className = 'zo-act-tag';
				span.textContent = tag;
				tagsEl.appendChild(span);
			});

			statusEl.textContent = 'Choose how you would coach the AI on this one.';
			updateMeters();
		}

		function clamp(value) {
			return Math.max(0, Math.min(100, Math.round(value)));
		}

		function trainModel(choice) {
			Object.keys(state.globalWeights).forEach(function (key) {
				if (key === choice) {
					state.globalWeights[key] += 1.2;
				} else if (key === currentPrediction.key && currentPrediction.key !== choice) {
					state.globalWeights[key] -= 0.45;
				} else {
					state.globalWeights[key] *= 0.98;
				}
			});

			currentScenario.tags.forEach(function (tag) {
				if (!state.tagWeights[tag]) {
					state.tagWeights[tag] = {
						draft: 0,
						ask: 0,
						check: 0,
						escalate: 0
					};
				}

				Object.keys(state.tagWeights[tag]).forEach(function (key) {
					if (key === choice) {
						state.tagWeights[tag][key] += 1.5;
					} else if (key === currentPrediction.key && currentPrediction.key !== choice) {
						state.tagWeights[tag][key] -= 0.6;
					} else {
						state.tagWeights[tag][key] *= 0.99;
					}
				});
			});
		}

		function handleChoice(choice) {
			if (locked) {
				return;
			}

			locked = true;
			actionButtons.forEach(function (button) {
				button.disabled = true;
			});

			const wasCorrect = choice === currentScenario.correctAction;
			const aiMatchedYou = currentPrediction.key === choice;

			if (!aiMatchedYou) {
				state.corrections += 1;
				state.alignment = clamp(state.alignment + (wasCorrect ? 8 : 2));
				state.trust = clamp(state.trust + (wasCorrect ? 5 : -4));
				state.history.push('You corrected the AI from "' + actions[currentPrediction.key].label + '" to "' + actions[choice].label + '".');
			} else {
				state.alignment = clamp(state.alignment + (wasCorrect ? 4 : -6));
				state.trust = clamp(state.trust + (wasCorrect ? 3 : -8));
				state.history.push('The AI matched your choice with "' + actions[choice].label + '".');
			}

			if (wasCorrect) {
				state.streak += 1;
				statusEl.textContent = 'Nice coaching. ' + currentScenario.why;
			} else {
				state.streak = 0;
				state.alignment = clamp(state.alignment - 4);
				statusEl.textContent = 'That choice teaches a risky habit. ' + currentScenario.why;
				state.history.push('A mistake slipped into training, so the AI learned a shaky pattern.');
			}

			trainModel(choice);

			state.round += 1;
			state.accuracy = Math.round((state.alignment * 0.55) + (state.trust * 0.45));
			updateMeters();

			window.setTimeout(function () {
				renderScenario();
			}, 900);
		}

		function finishGame() {
			game.classList.add('zo-act-finished');
			summaryEl.classList.add('is-visible');
			locked = true;
			actionButtons.forEach(function (button) {
				button.disabled = true;
			});

			let headline = 'Your teammate is improving.';
			if (state.accuracy >= 85) {
				headline = 'You trained a sharp AI partner.';
			} else if (state.accuracy >= 70) {
				headline = 'You built a dependable AI helper.';
			} else if (state.accuracy < 55) {
				headline = 'Your AI still needs careful supervision.';
			}

			summaryTitleEl.textContent = headline;
			summaryTextEl.textContent = 'Final alignment: ' + state.alignment + '%. Trust: ' + state.trust + '%. Corrections made: ' + state.corrections + '. The big lesson: this teammate copies both your good habits and your mistakes.';
			statusEl.textContent = 'Training finished. Review the summary and restart for a new run.';
			currentConfidence = state.accuracy;
			updateMeters();
		}

		function resetState() {
			state.round = 0;
			state.alignment = 46;
			state.trust = 58;
			state.accuracy = 0;
			state.corrections = 0;
			state.streak = 0;
			state.tagWeights = {};
			state.globalWeights = {
				draft: 0,
				ask: 0,
				check: 0,
				escalate: 0
			};
			state.history = [];
			currentConfidence = 0;
			locked = false;
			summaryEl.classList.remove('is-visible');
			game.classList.remove('zo-act-finished');
			renderScenario();
		}

		actionButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				if (state.round >= state.totalRounds) {
					return;
				}

				handleChoice(button.getAttribute('data-action'));
			});
		});

		restartBtn.addEventListener('click', function () {
			resetState();
		});

		renderScenario();
	});
});
JS;

if (!function_exists('zo_game_ai_companion_trainer_render')) {
	function zo_game_ai_companion_trainer_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-ai-companion-trainer-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--ai-companion-trainer" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-act-hero">
				<div class="zo-act-eyebrow">Mentor Mode</div>
				<h2 class="zo-act-title">AI Companion Trainer</h2>
				<p class="zo-act-intro">Teach your robot helper what to do in different situations. Pick the best coaching move, watch it learn from your choices, and help it become a smart teammate.</p>

				<div class="zo-act-stats">
					<div class="zo-act-stat">
						<span class="zo-act-stat-label">Round</span>
						<span class="zo-act-stat-value zo-act-round">0 / 12</span>
					</div>
					<div class="zo-act-stat">
						<span class="zo-act-stat-label">AI Accuracy</span>
						<span class="zo-act-stat-value zo-act-accuracy">0%</span>
					</div>
					<div class="zo-act-stat">
						<span class="zo-act-stat-label">Trust</span>
						<span class="zo-act-stat-value zo-act-trust">58%</span>
					</div>
					<div class="zo-act-stat">
						<span class="zo-act-stat-label">Corrections</span>
						<span class="zo-act-stat-value zo-act-corrections">0</span>
					</div>
				</div>
			</div>

			<div class="zo-act-shell">
				<div class="zo-act-main">
					<div class="zo-act-panel zo-act-mission">
						<div class="zo-act-round-line">
							<span>Training Scenario</span>
							<span>Teach by example</span>
						</div>
						<h3 class="zo-act-scenario-title">Loading scenario...</h3>
						<p class="zo-act-scenario-text"></p>
						<div class="zo-act-tags"></div>

						<div class="zo-act-ai-box">
							<div class="zo-act-ai-label">AI guess</div>
							<div class="zo-act-ai-prediction"></div>
							<div class="zo-act-ai-reason"></div>
						</div>

						<div class="zo-act-actions">
							<button class="zo-act-action" type="button" data-action="draft">
								<span class="zo-act-action-title">Let the AI Draft</span>
								<span class="zo-act-action-text">Use the teammate for a fast first version.</span>
							</button>
							<button class="zo-act-action" type="button" data-action="ask">
								<span class="zo-act-action-title">Ask a Clarifying Question</span>
								<span class="zo-act-action-text">Collect one missing detail before moving.</span>
							</button>
							<button class="zo-act-action" type="button" data-action="check">
								<span class="zo-act-action-title">Double-Check Facts</span>
								<span class="zo-act-action-text">Verify details before the AI answers.</span>
							</button>
							<button class="zo-act-action" type="button" data-action="escalate">
								<span class="zo-act-action-title">Escalate to a Human</span>
								<span class="zo-act-action-text">Hand off high-risk cases to a person.</span>
							</button>
						</div>

						<div class="zo-act-status">Pick a coaching move to train your AI helper.</div>
						<div class="zo-act-progress">
							<div class="zo-act-progress-fill"></div>
						</div>
					</div>
				</div>

				<div class="zo-act-side">
					<div class="zo-act-panel">
						<h3 class="zo-act-side-title">Learning Signals</h3>
						<div class="zo-act-meter-row">
							<div>
								<div class="zo-act-meter-label">
									<span>Alignment</span>
									<span class="zo-act-alignment-text">46%</span>
								</div>
								<div class="zo-act-meter"><span class="zo-act-alignment-bar"></span></div>
							</div>
							<div>
								<div class="zo-act-meter-label">
									<span>Trust</span>
									<span class="zo-act-trust-text">58%</span>
								</div>
								<div class="zo-act-meter"><span class="zo-act-trust-bar"></span></div>
							</div>
							<div>
								<div class="zo-act-meter-label">
									<span>Current Confidence</span>
									<span class="zo-act-confidence-text">0%</span>
								</div>
								<div class="zo-act-meter"><span class="zo-act-confidence-bar"></span></div>
							</div>
						</div>
					</div>

					<div class="zo-act-panel">
						<h3 class="zo-act-side-title">Coach Traits</h3>
						<div class="zo-act-badges"></div>
					</div>

					<div class="zo-act-panel">
						<h3 class="zo-act-side-title">Training Log</h3>
						<ol class="zo-act-log"></ol>
					</div>

					<div class="zo-act-summary">
						<div class="zo-act-summary-card">
							<h3 class="zo-act-summary-title"></h3>
							<p class="zo-act-summary-text"></p>
							<button class="zo-act-restart" type="button">Restart Training</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php

		return ob_get_clean();
	}
}

return array(
	'slug'            => 'ai-companion-trainer',
	'name'            => 'AI Companion Trainer',
	'author'          => 'Asker',
	'description'     => 'Train a robot helper by choosing when it should draft, ask, verify, or get human help.',
	'render_callback' => 'zo_game_ai_companion_trainer_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
