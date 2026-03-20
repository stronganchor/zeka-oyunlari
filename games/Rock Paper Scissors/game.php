<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--rock-paper-scissors {
	max-width: 620px;
	margin: 0 auto;
	padding: 20px;
	border: 2px solid #d9e2ec;
	border-radius: 18px;
	background: #ffffff;
	box-sizing: border-box;
	font-family: Arial, sans-serif;
	text-align: center;
}

.zo-game-root--rock-paper-scissors .zo-rps-title {
	margin: 0 0 10px;
	font-size: 30px;
	line-height: 1.2;
	color: #1f2937;
}

.zo-game-root--rock-paper-scissors .zo-rps-desc {
	margin: 0 0 18px;
	font-size: 15px;
	line-height: 1.5;
	color: #4b5563;
}

.zo-game-root--rock-paper-scissors .zo-rps-buttons {
	display: grid;
	grid-template-columns: repeat(3, minmax(0, 1fr));
	gap: 10px;
	margin-bottom: 16px;
}

.zo-game-root--rock-paper-scissors .zo-rps-button,
.zo-game-root--rock-paper-scissors .zo-rps-reset {
	border: 0;
	border-radius: 14px;
	padding: 14px 12px;
	font-size: 18px;
	font-weight: 700;
	cursor: pointer;
	box-sizing: border-box;
}

.zo-game-root--rock-paper-scissors .zo-rps-button {
	background: #2997aa;
	color: #ffffff;
}

.zo-game-root--rock-paper-scissors .zo-rps-button:hover,
.zo-game-root--rock-paper-scissors .zo-rps-button:focus,
.zo-game-root--rock-paper-scissors .zo-rps-reset:hover,
.zo-game-root--rock-paper-scissors .zo-rps-reset:focus {
	opacity: 0.92;
	outline: none;
}

.zo-game-root--rock-paper-scissors .zo-rps-stats {
	display: grid;
	grid-template-columns: repeat(3, minmax(0, 1fr));
	gap: 10px;
	margin-bottom: 16px;
}

.zo-game-root--rock-paper-scissors .zo-rps-stat {
	border: 2px solid #d7e0ea;
	border-radius: 14px;
	padding: 12px;
	background: #f4f7fb;
}

.zo-game-root--rock-paper-scissors .zo-rps-stat-label {
	display: block;
	font-size: 13px;
	font-weight: 700;
	color: #51606f;
	margin-bottom: 4px;
}

.zo-game-root--rock-paper-scissors .zo-rps-stat-value {
	display: block;
	font-size: 24px;
	font-weight: 700;
	line-height: 1.1;
	color: #111827;
}

.zo-game-root--rock-paper-scissors .zo-rps-result {
	border: 2px dashed #c8d4e0;
	border-radius: 14px;
	padding: 16px;
	background: #f8fbff;
	margin-bottom: 14px;
	min-height: 108px;
}

.zo-game-root--rock-paper-scissors .zo-rps-line {
	margin: 0 0 8px;
	font-size: 18px;
	color: #1f2937;
}

.zo-game-root--rock-paper-scissors .zo-rps-line:last-child {
	margin-bottom: 0;
}

.zo-game-root--rock-paper-scissors .zo-rps-outcome {
	font-size: 24px;
	font-weight: 700;
	color: #1d4ed8;
}

.zo-game-root--rock-paper-scissors .zo-rps-reset {
	background: #e5e7eb;
	color: #111827;
	width: 100%;
}

@media (max-width: 640px) {
	.zo-game-root.zo-game-root--rock-paper-scissors {
		padding: 16px;
	}

	.zo-game-root--rock-paper-scissors .zo-rps-title {
		font-size: 25px;
	}

	.zo-game-root--rock-paper-scissors .zo-rps-buttons,
	.zo-game-root--rock-paper-scissors .zo-rps-stats {
		grid-template-columns: 1fr;
	}

	.zo-game-root--rock-paper-scissors .zo-rps-button,
	.zo-game-root--rock-paper-scissors .zo-rps-reset {
		font-size: 17px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--rock-paper-scissors');

	games.forEach(function (game) {
		const buttons = game.querySelectorAll('.zo-rps-button');
		const resetButton = game.querySelector('.zo-rps-reset');
		const playerChoiceEl = game.querySelector('.zo-rps-player-choice');
		const computerChoiceEl = game.querySelector('.zo-rps-computer-choice');
		const outcomeEl = game.querySelector('.zo-rps-outcome');
		const winsEl = game.querySelector('.zo-rps-wins');
		const lossesEl = game.querySelector('.zo-rps-losses');
		const tiesEl = game.querySelector('.zo-rps-ties');

		const choices = ['rock', 'paper', 'scissors'];
		let wins = 0;
		let losses = 0;
		let ties = 0;

		function prettyChoice(choice) {
			return choice.charAt(0).toUpperCase() + choice.slice(1);
		}

		function updateStats() {
			winsEl.textContent = String(wins);
			lossesEl.textContent = String(losses);
			tiesEl.textContent = String(ties);
		}

		function decideWinner(userChoice, computerChoice) {
			if (userChoice === computerChoice) {
				return 'tie';
			}

			if (
				(userChoice === 'rock' && computerChoice === 'scissors') ||
				(userChoice === 'scissors' && computerChoice === 'paper') ||
				(userChoice === 'paper' && computerChoice === 'rock')
			) {
				return 'win';
			}

			return 'lose';
		}

		function playRound(userChoice) {
			const computerChoice = choices[Math.floor(Math.random() * choices.length)];
			const result = decideWinner(userChoice, computerChoice);

			playerChoiceEl.textContent = prettyChoice(userChoice);
			computerChoiceEl.textContent = prettyChoice(computerChoice);

			if (result === 'tie') {
				ties += 1;
				outcomeEl.textContent = "It's a tie!";
			} else if (result === 'win') {
				wins += 1;
				outcomeEl.textContent = 'You win!';
			} else {
				losses += 1;
				outcomeEl.textContent = 'You lose!';
			}

			updateStats();
		}

		function resetGame() {
			wins = 0;
			losses = 0;
			ties = 0;
			playerChoiceEl.textContent = '-';
			computerChoiceEl.textContent = '-';
			outcomeEl.textContent = 'Make your move.';
			updateStats();
		}

		buttons.forEach(function (button) {
			button.addEventListener('click', function () {
				playRound(button.getAttribute('data-choice'));
			});
		});

		resetButton.addEventListener('click', resetGame);

		resetGame();
	});
});
JS;

if (!function_exists('zo_game_rock_paper_scissors_render')) {
	function zo_game_rock_paper_scissors_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-rock-paper-scissors-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--rock-paper-scissors" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-rps-title">Rock Paper Scissors</h2>
			<p class="zo-rps-desc">Choose Rock, Paper, or Scissors. Beat the computer to win.</p>

			<div class="zo-rps-buttons">
				<button type="button" class="zo-rps-button" data-choice="rock">Rock</button>
				<button type="button" class="zo-rps-button" data-choice="paper">Paper</button>
				<button type="button" class="zo-rps-button" data-choice="scissors">Scissors</button>
			</div>

			<div class="zo-rps-stats">
				<div class="zo-rps-stat">
					<span class="zo-rps-stat-label">Wins</span>
					<span class="zo-rps-stat-value zo-rps-wins">0</span>
				</div>
				<div class="zo-rps-stat">
					<span class="zo-rps-stat-label">Losses</span>
					<span class="zo-rps-stat-value zo-rps-losses">0</span>
				</div>
				<div class="zo-rps-stat">
					<span class="zo-rps-stat-label">Ties</span>
					<span class="zo-rps-stat-value zo-rps-ties">0</span>
				</div>
			</div>

			<div class="zo-rps-result" aria-live="polite">
				<p class="zo-rps-line">You chose: <strong class="zo-rps-player-choice">-</strong></p>
				<p class="zo-rps-line">Computer chose: <strong class="zo-rps-computer-choice">-</strong></p>
				<p class="zo-rps-line zo-rps-outcome">Make your move.</p>
			</div>

			<button type="button" class="zo-rps-reset">Restart</button>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'rock-paper-scissors',
	'name'            => 'Rock Paper Scissors',
	'author'          => 'Asker',
	'description'     => 'A simple rock paper scissors game for kids with score tracking and restart.',
	'render_callback' => 'zo_game_rock_paper_scissors_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);