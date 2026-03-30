<?php

if (!defined('ABSPATH')) {
	exit;
}

$inline_style = <<<'CSS'
.zo-game-root--you-always-lose * {
	box-sizing: border-box;
}

.zo-game-root--you-always-lose {
	max-width: 980px;
	margin: 0 auto;
	padding: 16px;
	font-family: Arial, sans-serif;
	color: #1f2937;
}

.zo-game-root--you-always-lose .zo-yal-wrap {
	background: #ffffff;
	border: 1px solid #dbe3ea;
	border-radius: 22px;
	padding: 18px;
	box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
}

.zo-game-root--you-always-lose .zo-yal-title {
	margin: 0 0 8px;
	text-align: center;
	font-size: 32px;
	line-height: 1.2;
	color: #0f172a;
}

.zo-game-root--you-always-lose .zo-yal-subtitle {
	margin: 0 0 18px;
	text-align: center;
	font-size: 15px;
	line-height: 1.5;
	color: #475569;
}

.zo-game-root--you-always-lose .zo-yal-topbar {
	display: flex;
	flex-wrap: wrap;
	gap: 12px;
	justify-content: space-between;
	align-items: center;
	margin-bottom: 16px;
}

.zo-game-root--you-always-lose .zo-yal-stats {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
}

.zo-game-root--you-always-lose .zo-yal-stat {
	background: #f3f6fa;
	border: 1px solid #dbe3ea;
	border-radius: 12px;
	padding: 10px 14px;
	font-size: 14px;
	font-weight: 700;
}

.zo-game-root--you-always-lose .zo-yal-controls {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
}

.zo-game-root--you-always-lose .zo-yal-btn {
	padding: 10px 16px;
	border-radius: 12px;
	border: 1px solid #cfd8e3;
	background: #ffffff;
	color: #1f2937;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	transition: transform 0.15s ease, opacity 0.15s ease;
}

.zo-game-root--you-always-lose .zo-yal-btn:hover,
.zo-game-root--you-always-lose .zo-yal-btn:focus {
	outline: none;
	transform: translateY(-1px);
}

.zo-game-root--you-always-lose .zo-yal-btn--primary {
	background: #2563eb;
	border-color: #2563eb;
	color: #ffffff;
}

.zo-game-root--you-always-lose .zo-yal-btn--danger {
	background: #ef4444;
	border-color: #ef4444;
	color: #ffffff;
}

.zo-game-root--you-always-lose .zo-yal-layout {
	display: grid;
	grid-template-columns: 1.2fr 0.8fr;
	gap: 16px;
}

.zo-game-root--you-always-lose .zo-yal-panel {
	background: #f8fafc;
	border: 1px solid #dbe3ea;
	border-radius: 18px;
	padding: 14px;
}

.zo-game-root--you-always-lose .zo-yal-arena {
	position: relative;
	min-height: 320px;
	overflow: hidden;
	background: linear-gradient(180deg, #dbeafe 0%, #ede9fe 45%, #e2e8f0 100%);
}

.zo-game-root--you-always-lose .zo-yal-fighters {
	display: flex;
	justify-content: space-between;
	align-items: flex-end;
	gap: 12px;
	min-height: 180px;
	padding: 10px 10px 0;
}

.zo-game-root--you-always-lose .zo-yal-fighter {
	width: calc(50% - 6px);
	background: rgba(255, 255, 255, 0.68);
	border: 1px solid rgba(203, 213, 225, 0.9);
	border-radius: 18px;
	padding: 12px;
	text-align: center;
	box-shadow: 0 6px 18px rgba(0, 0, 0, 0.04);
}

.zo-game-root--you-always-lose .zo-yal-emoji {
	font-size: 58px;
	line-height: 1;
	margin-bottom: 6px;
}

.zo-game-root--you-always-lose .zo-yal-name {
	font-size: 18px;
	font-weight: 800;
	color: #0f172a;
	margin-bottom: 8px;
}

.zo-game-root--you-always-lose .zo-yal-bar-wrap {
	margin-bottom: 8px;
	text-align: left;
}

.zo-game-root--you-always-lose .zo-yal-bar-label {
	font-size: 12px;
	font-weight: 700;
	color: #475569;
	margin-bottom: 4px;
}

.zo-game-root--you-always-lose .zo-yal-bar {
	height: 12px;
	background: #e2e8f0;
	border-radius: 999px;
	overflow: hidden;
	border: 1px solid #cbd5e1;
}

.zo-game-root--you-always-lose .zo-yal-bar-fill {
	height: 100%;
	width: 100%;
	border-radius: 999px;
	transition: width 0.25s ease;
}

.zo-game-root--you-always-lose .zo-yal-bar-fill--player {
	background: linear-gradient(90deg, #22c55e 0%, #16a34a 100%);
}

.zo-game-root--you-always-lose .zo-yal-bar-fill--ai {
	background: linear-gradient(90deg, #60a5fa 0%, #2563eb 100%);
}

.zo-game-root--you-always-lose .zo-yal-mini {
	font-size: 13px;
	font-weight: 700;
	color: #475569;
}

.zo-game-root--you-always-lose .zo-yal-middle {
	display: flex;
	align-items: center;
	justify-content: center;
	min-height: 60px;
	font-size: 22px;
	font-weight: 800;
	color: #334155;
}

.zo-game-root--you-always-lose .zo-yal-round-text {
	text-align: center;
	font-size: 16px;
	font-weight: 700;
	color: #1e293b;
	min-height: 54px;
	padding: 8px 10px 0;
}

.zo-game-root--you-always-lose .zo-yal-actions {
	display: grid;
	grid-template-columns: repeat(2, minmax(0, 1fr));
	gap: 10px;
	margin-top: 14px;
}

.zo-game-root--you-always-lose .zo-yal-action {
	padding: 12px;
	border-radius: 14px;
	border: 1px solid #cbd5e1;
	background: #ffffff;
	cursor: pointer;
	text-align: left;
	font: inherit;
}

.zo-game-root--you-always-lose .zo-yal-action:hover,
.zo-game-root--you-always-lose .zo-yal-action:focus {
	outline: none;
	border-color: #94a3b8;
	background: #f8fafc;
}

.zo-game-root--you-always-lose .zo-yal-action-title {
	font-size: 15px;
	font-weight: 800;
	color: #0f172a;
	margin-bottom: 4px;
}

.zo-game-root--you-always-lose .zo-yal-action-text {
	font-size: 13px;
	line-height: 1.45;
	color: #475569;
}

.zo-game-root--you-always-lose .zo-yal-log {
	max-height: 360px;
	overflow-y: auto;
	background: #0f172a;
	color: #e2e8f0;
	border-radius: 14px;
	padding: 12px;
	font-size: 13px;
	line-height: 1.5;
}

.zo-game-root--you-always-lose .zo-yal-log-entry {
	margin-bottom: 8px;
	padding-bottom: 8px;
	border-bottom: 1px solid rgba(255,255,255,0.08);
}

.zo-game-root--you-always-lose .zo-yal-log-entry:last-child {
	margin-bottom: 0;
	padding-bottom: 0;
	border-bottom: 0;
}

.zo-game-root--you-always-lose .zo-yal-message {
	margin-top: 12px;
	padding: 12px 14px;
	border-radius: 12px;
	background: #eff6ff;
	border: 1px solid #bfdbfe;
	font-size: 14px;
	font-weight: 700;
	color: #1d4ed8;
	min-height: 48px;
}

.zo-game-root--you-always-lose .zo-yal-hint {
	margin-top: 10px;
	font-size: 13px;
	line-height: 1.5;
	color: #64748b;
}

.zo-game-root--you-always-lose .zo-yal-ending {
	margin-top: 14px;
	padding: 12px;
	background: #fff7ed;
	border: 1px solid #fed7aa;
	border-radius: 14px;
	font-size: 14px;
	line-height: 1.5;
	color: #9a3412;
	display: none;
}

.zo-game-root--you-always-lose .zo-yal-ending.is-visible {
	display: block;
}

@media (max-width: 860px) {
	.zo-game-root--you-always-lose .zo-yal-layout {
		grid-template-columns: 1fr;
	}
}

@media (max-width: 640px) {
	.zo-game-root--you-always-lose {
		padding: 10px;
	}

	.zo-game-root--you-always-lose .zo-yal-wrap {
		padding: 12px;
	}

	.zo-game-root--you-always-lose .zo-yal-title {
		font-size: 26px;
	}

	.zo-game-root--you-always-lose .zo-yal-actions {
		grid-template-columns: 1fr;
	}

	.zo-game-root--you-always-lose .zo-yal-emoji {
		font-size: 46px;
	}
}
CSS;

$inline_script = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const roots = document.querySelectorAll('.zo-game-root--you-always-lose');

	roots.forEach(function (root) {
		const startButton = root.querySelector('.zo-yal-start');
		const restartButton = root.querySelector('.zo-yal-restart');
		const actionButtons = root.querySelectorAll('.zo-yal-action');

		const roundEl = root.querySelector('.zo-yal-round');
		const playerHpEl = root.querySelector('.zo-yal-player-hp');
		const aiHpEl = root.querySelector('.zo-yal-ai-hp');
		const playerHpBar = root.querySelector('.zo-yal-player-bar');
		const aiHpBar = root.querySelector('.zo-yal-ai-bar');
		const playerConfidenceEl = root.querySelector('.zo-yal-player-confidence');
		const aiConfidenceEl = root.querySelector('.zo-yal-ai-confidence');
		const roundTextEl = root.querySelector('.zo-yal-round-text');
		const messageEl = root.querySelector('.zo-yal-message');
		const logEl = root.querySelector('.zo-yal-log');
		const endingEl = root.querySelector('.zo-yal-ending');

		const state = {
			running: false,
			ended: false,
			round: 0,
			playerHp: 100,
			aiHp: 100,
			playerConfidence: 100,
			aiConfidence: 100,
			playerActionHistory: [],
			logs: []
		};

		const actionDefs = {
			attack: {
				name: 'Bold Attack',
				desc: 'Looks strong at first.'
			},
			shield: {
				name: 'Shield Up',
				desc: 'Feels safe. It is not.'
			},
			hack: {
				name: 'Hack the AI',
				desc: 'Pretend to outsmart it.'
			},
			appeal: {
				name: 'Emotional Speech',
				desc: 'Ask the AI for mercy.'
			}
		};

		function clamp(value, min, max) {
			return Math.max(min, Math.min(max, value));
		}

		function setMessage(text) {
			messageEl.textContent = text;
		}

		function addLog(text) {
			state.logs.unshift(text);
			if (state.logs.length > 18) {
				state.logs.pop();
			}

			logEl.innerHTML = '';
			state.logs.forEach(function (entry) {
				const div = document.createElement('div');
				div.className = 'zo-yal-log-entry';
				div.textContent = entry;
				logEl.appendChild(div);
			});
		}

		function updateBars() {
			playerHpEl.textContent = String(Math.max(0, state.playerHp));
			aiHpEl.textContent = String(Math.max(0, state.aiHp));
			playerHpBar.style.width = clamp(state.playerHp, 0, 100) + '%';
			aiHpBar.style.width = clamp(state.aiHp, 0, 100) + '%';

			playerConfidenceEl.textContent = String(Math.max(0, state.playerConfidence));
			aiConfidenceEl.textContent = String(Math.max(0, state.aiConfidence));

			roundEl.textContent = String(state.round);
		}

		function resetGame() {
			state.running = false;
			state.ended = false;
			state.round = 0;
			state.playerHp = 100;
			state.aiHp = 100;
			state.playerConfidence = 100;
			state.aiConfidence = 100;
			state.playerActionHistory = [];
			state.logs = [];

			updateBars();
			roundTextEl.textContent = 'You might beat the AI this time.';
			setMessage('Press Start. The opening rounds look fair.');
			endingEl.classList.remove('is-visible');
			logEl.innerHTML = '';
			enableActions(false);
		}

		function enableActions(enabled) {
			actionButtons.forEach(function (button) {
				button.disabled = !enabled;
			});
		}

		function startGame() {
			if (state.running && !state.ended) {
				return;
			}

			state.running = true;
			state.ended = false;
			state.round = 1;
			state.playerHp = 100;
			state.aiHp = 100;
			state.playerConfidence = 100;
			state.aiConfidence = 100;
			state.playerActionHistory = [];
			state.logs = [];

			updateBars();
			enableActions(true);
			roundTextEl.textContent = 'Round 1. The AI looks beatable.';
			setMessage('Choose a move.');
			addLog('Round 1 begins. The AI politely waits.');
			endingEl.classList.remove('is-visible');
		}

		function getAiResponse(actionKey) {
			const round = state.round;

			if (round === 1) {
				return {
					text: 'The AI studies you and allows a small success.',
					playerDamage: 6,
					aiDamage: 18,
					playerConfidenceDelta: 0,
					aiConfidenceDelta: -6
				};
			}

			if (round === 2) {
				return {
					text: 'The AI adjusts. Your move still lands, but less.',
					playerDamage: 10,
					aiDamage: 10,
					playerConfidenceDelta: -4,
					aiConfidenceDelta: 3
				};
			}

			if (round === 3) {
				const repeated = state.playerActionHistory.filter(function (item) {
					return item === actionKey;
				}).length >= 2;

				if (repeated) {
					return {
						text: 'The AI predicted the pattern before you clicked.',
						playerDamage: 24,
						aiDamage: 2,
						playerConfidenceDelta: -16,
						aiConfidenceDelta: 8
					};
				}

				return {
					text: 'The AI now counters even your new ideas.',
					playerDamage: 20,
					aiDamage: 4,
					playerConfidenceDelta: -12,
					aiConfidenceDelta: 6
				};
			}

			if (round === 4) {
				if (actionKey === 'hack') {
					return {
						text: 'You try to hack the AI. The AI thanks you for the upgrade.',
						playerDamage: 32,
						aiDamage: 0,
						playerConfidenceDelta: -20,
						aiConfidenceDelta: 12
					};
				}

				if (actionKey === 'shield') {
					return {
						text: 'Your shield works. The AI attacks around it.',
						playerDamage: 26,
						aiDamage: 1,
						playerConfidenceDelta: -16,
						aiConfidenceDelta: 10
					};
				}

				return {
					text: 'The AI no longer reacts. It informs outcomes.',
					playerDamage: 28,
					aiDamage: 2,
					playerConfidenceDelta: -18,
					aiConfidenceDelta: 10
				};
			}

			if (round === 5) {
				return {
					text: 'The AI has fully modeled your behavior.',
					playerDamage: 34,
					aiDamage: 0,
					playerConfidenceDelta: -22,
					aiConfidenceDelta: 14
				};
			}

			return {
				text: 'The AI executes the inevitable ending.',
				playerDamage: 999,
				aiDamage: 0,
				playerConfidenceDelta: -100,
				aiConfidenceDelta: 20
			};
		}

		function getActionFlavor(actionKey) {
			if (actionKey === 'attack') {
				return 'You rush in with confidence.';
			}
			if (actionKey === 'shield') {
				return 'You brace for impact.';
			}
			if (actionKey === 'hack') {
				return 'You type very fast and hope it means something.';
			}
			return 'You deliver a speech about humanity.';
		}

		function endGame() {
			state.running = false;
			state.ended = true;
			enableActions(false);
			roundTextEl.textContent = 'Defeat is complete.';
			setMessage('You always lose.');
			endingEl.classList.add('is-visible');
			endingEl.textContent = 'The joke is the setup. The first rounds make it look possible. Then the AI learns too fast and the result becomes fixed.';
		}

		function playRound(actionKey) {
			if (!state.running || state.ended) {
				return;
			}

			const actionDef = actionDefs[actionKey];
			if (!actionDef) {
				return;
			}

			const response = getAiResponse(actionKey);

			addLog('You used ' + actionDef.name + '. ' + getActionFlavor(actionKey));
			addLog(response.text);

			state.playerActionHistory.push(actionKey);

			state.playerHp = clamp(state.playerHp - response.playerDamage, 0, 100);
			state.aiHp = clamp(state.aiHp - response.aiDamage, 0, 100);
			state.playerConfidence = clamp(state.playerConfidence + response.playerConfidenceDelta, 0, 100);
			state.aiConfidence = clamp(state.aiConfidence + response.aiConfidenceDelta, 0, 100);

			updateBars();

			if (state.playerHp <= 0) {
				endGame();
				return;
			}

			if (state.aiHp <= 0) {
				state.aiHp = 1;
				addLog('For a moment it looks like you won. The AI restores itself to 1 HP.');
				updateBars();
			}

			state.round += 1;
			roundTextEl.textContent = 'Round ' + state.round + '. It feels worse now.';
			setMessage('Choose again. The AI is ahead.');

			if (state.round >= 6) {
				const finalResponse = getAiResponse(actionKey);
				addLog(finalResponse.text);
				state.playerHp = 0;
				state.playerConfidence = 0;
				updateBars();
				endGame();
			}
		}

		startButton.addEventListener('click', function () {
			startGame();
		});

		restartButton.addEventListener('click', function () {
			resetGame();
		});

		actionButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				playRound(button.getAttribute('data-action'));
			});
		});

		resetGame();
	});
});
JS;

if (!function_exists('zo_you_always_lose_render')) {
	function zo_you_always_lose_render($post_id = 0, $game = array()) {
		$game_id = 'zo-you-always-lose-' . wp_rand(1000, 999999);

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--you-always-lose" id="<?php echo esc_attr($game_id); ?>">
			<div class="zo-yal-wrap">
				<h2 class="zo-yal-title">Beat the AI?</h2>
				<p class="zo-yal-subtitle">At first it looks fair. Then the AI learns too fast. You always lose.</p>

				<div class="zo-yal-topbar">
					<div class="zo-yal-stats">
						<div class="zo-yal-stat">Round: <span class="zo-yal-round">0</span></div>
						<div class="zo-yal-stat">Your Confidence: <span class="zo-yal-player-confidence">100</span></div>
						<div class="zo-yal-stat">AI Confidence: <span class="zo-yal-ai-confidence">100</span></div>
					</div>

					<div class="zo-yal-controls">
						<button type="button" class="zo-yal-btn zo-yal-btn--primary zo-yal-start">Start</button>
						<button type="button" class="zo-yal-btn zo-yal-btn--danger zo-yal-restart">Reset</button>
					</div>
				</div>

				<div class="zo-yal-layout">
					<div class="zo-yal-panel zo-yal-arena">
						<div class="zo-yal-fighters">
							<div class="zo-yal-fighter">
								<div class="zo-yal-emoji">😎</div>
								<div class="zo-yal-name">You</div>

								<div class="zo-yal-bar-wrap">
									<div class="zo-yal-bar-label">HP: <span class="zo-yal-player-hp">100</span></div>
									<div class="zo-yal-bar">
										<div class="zo-yal-bar-fill zo-yal-bar-fill--player zo-yal-player-bar"></div>
									</div>
								</div>

								<div class="zo-yal-mini">Certain of victory</div>
							</div>

							<div class="zo-yal-fighter">
								<div class="zo-yal-emoji">🤖</div>
								<div class="zo-yal-name">AI</div>

								<div class="zo-yal-bar-wrap">
									<div class="zo-yal-bar-label">HP: <span class="zo-yal-ai-hp">100</span></div>
									<div class="zo-yal-bar">
										<div class="zo-yal-bar-fill zo-yal-bar-fill--ai zo-yal-ai-bar"></div>
									</div>
								</div>

								<div class="zo-yal-mini">Already adapting</div>
							</div>
						</div>

						<div class="zo-yal-middle">VS</div>
						<div class="zo-yal-round-text">You might beat the AI this time.</div>

						<div class="zo-yal-actions">
							<button type="button" class="zo-yal-action" data-action="attack">
								<div class="zo-yal-action-title">⚔️ Bold Attack</div>
								<div class="zo-yal-action-text">A direct hit. Looks strong early.</div>
							</button>

							<button type="button" class="zo-yal-action" data-action="shield">
								<div class="zo-yal-action-title">🛡️ Shield Up</div>
								<div class="zo-yal-action-text">Try to survive the next counter.</div>
							</button>

							<button type="button" class="zo-yal-action" data-action="hack">
								<div class="zo-yal-action-title">💻 Hack the AI</div>
								<div class="zo-yal-action-text">Pretend you found a weakness.</div>
							</button>

							<button type="button" class="zo-yal-action" data-action="appeal">
								<div class="zo-yal-action-title">🎤 Emotional Speech</div>
								<div class="zo-yal-action-text">Ask the AI to spare you.</div>
							</button>
						</div>

						<div class="zo-yal-message">Press Start. The opening rounds look fair.</div>
						<div class="zo-yal-ending"></div>
					</div>

					<div class="zo-yal-panel">
						<h3 style="margin:0 0 10px;font-size:18px;">Battle Log</h3>
						<div class="zo-yal-log"></div>
						<div class="zo-yal-hint">
							This is a fake-hope game. The design goal is not balance. The design goal is inevitability.
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
	'slug'            => 'you-always-lose',
	'name'            => 'Beat the AI?',
	'author'          => 'Arslan',
	'description'     => 'A joke battle game where it seems like you can beat the AI, but you always lose.',
	'render_callback' => 'zo_you_always_lose_render',
	'inline_style'    => $inline_style,
	'inline_script'   => $inline_script,
);