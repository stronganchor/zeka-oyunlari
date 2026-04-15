<?php

if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('zo_game_sudoku_render')) {
	function zo_game_sudoku_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-sudoku-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--sudoku" id="<?php echo esc_attr($instance_id); ?>" data-game="sudoku">
			<div class="zo-sudoku">
				<div class="zo-sudoku__hero">
					<div>
						<p class="zo-sudoku__eyebrow">Asker's Puzzle</p>
						<h3 class="zo-sudoku__title">Sudoku</h3>
						<p class="zo-sudoku__intro">
							Fill the 9x9 board so every row, every column, and every 3x3 box contains the numbers 1-9 exactly once.
						</p>
					</div>

					<div class="zo-sudoku__stats">
						<div class="zo-sudoku__stat">
							<span class="zo-sudoku__stat-label">Filled</span>
							<strong class="zo-sudoku__stat-value" data-role="filled">0 / 81</strong>
						</div>
						<div class="zo-sudoku__stat">
							<span class="zo-sudoku__stat-label">Mistakes</span>
							<strong class="zo-sudoku__stat-value" data-role="mistakes">0</strong>
						</div>
						<div class="zo-sudoku__stat">
							<span class="zo-sudoku__stat-label">Time</span>
							<strong class="zo-sudoku__stat-value" data-role="timer">00:00</strong>
						</div>
						<div class="zo-sudoku__stat">
							<span class="zo-sudoku__stat-label">Best Time</span>
							<strong class="zo-sudoku__stat-value" data-role="best-time">--:--</strong>
						</div>
					</div>
				</div>

				<div class="zo-sudoku__toolbar">
					<label class="zo-sudoku__difficulty-label">
						<span>Difficulty</span>
						<select class="zo-sudoku__difficulty" data-role="difficulty">
							<option value="easy">Easy</option>
							<option value="medium">Medium</option>
							<option value="hard">Hard</option>
						</select>
					</label>

					<div class="zo-sudoku__actions">
						<button type="button" class="zo-sudoku__button zo-sudoku__button--primary" data-action="new">New Puzzle</button>
						<button type="button" class="zo-sudoku__button" data-action="notes" aria-pressed="false">Notes: Off</button>
						<button type="button" class="zo-sudoku__button" data-action="reset">Reset</button>
						<button type="button" class="zo-sudoku__button" data-action="check">Check</button>
						<button type="button" class="zo-sudoku__button" data-action="hint">Hint</button>
						<button type="button" class="zo-sudoku__button" data-action="undo">Undo</button>
					</div>
				</div>

				<div class="zo-sudoku__layout">
					<div class="zo-sudoku__board-panel">
						<div class="zo-sudoku__board" data-role="board" aria-label="Sudoku board"></div>

						<div class="zo-sudoku__keypad" data-role="keypad" aria-label="Sudoku number pad">
							<button type="button" class="zo-sudoku__key" data-value="1">1</button>
							<button type="button" class="zo-sudoku__key" data-value="2">2</button>
							<button type="button" class="zo-sudoku__key" data-value="3">3</button>
							<button type="button" class="zo-sudoku__key" data-value="4">4</button>
							<button type="button" class="zo-sudoku__key" data-value="5">5</button>
							<button type="button" class="zo-sudoku__key" data-value="6">6</button>
							<button type="button" class="zo-sudoku__key" data-value="7">7</button>
							<button type="button" class="zo-sudoku__key" data-value="8">8</button>
							<button type="button" class="zo-sudoku__key" data-value="9">9</button>
							<button type="button" class="zo-sudoku__key zo-sudoku__key--wide" data-value="0">Erase</button>
						</div>
					</div>

					<div class="zo-sudoku__side">
						<div class="zo-sudoku__card">
							<h4 class="zo-sudoku__card-title">Rules</h4>
							<ul class="zo-sudoku__rules">
								<li>Each row must contain 1-9 once.</li>
								<li>Each column must contain 1-9 once.</li>
								<li>Each 3x3 box must contain 1-9 once.</li>
								<li>Blue numbers are fixed clues and cannot be changed.</li>
							</ul>
						</div>

						<div class="zo-sudoku__card">
							<h4 class="zo-sudoku__card-title">How To Play</h4>
							<p class="zo-sudoku__card-copy">
								Click a blank square, then type on your keyboard or use the number pad. Turn notes on to write small candidate numbers before choosing the final answer.
							</p>
						</div>

						<div class="zo-sudoku__status" data-role="status" aria-live="polite">
							Choose a square and start solving.
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
	'slug'            => 'sudoku',
	'name'            => 'Sudoku',
	'author'          => 'Asker',
	'description'     => 'A classic 9x9 Sudoku puzzle with easy, medium, and hard boards.',
	'render_callback' => 'zo_game_sudoku_render',
);
