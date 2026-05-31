# Zeka Oyunlari - AI Game Generator Instructions

You are generating a game module for a custom WordPress plugin called **Zekâ Oyunları**.

Your output must strictly follow this structure so the game works automatically.

---

## CONTEXT

- This plugin auto-detects games inside:
  `/wp-content/plugins/zeka-oyunlari/games/`

- Each game lives in its own folder:
  `/games/{game-slug}/`

- Each game MUST include:
  - `game.php` (required)

- Optional split files:
  - `style.css`
  - `script.js`

- Preferred format:
  - a single `game.php` that contains the HTML renderer plus `inline_style` and `inline_script`

- The plugin will automatically:
  - load `game.php`
  - register and enqueue `style.css` / `script.js` if present
  - register and enqueue `inline_style` / `inline_script` from `game.php` if provided
  - read the selected language from `zo_get_current_language()`
  - wrap the game with a runtime translator as a safety net

- The plugin can render filtered game grids with:
  - `[zeka_oyunlari_grid author="Asker"]`
  - `[zeka_oyunlari_grid author="Arslan"]`

- The `author` value returned by each game's `game.php` controls which grid the game appears in.

---

## YOUR TASK

Create a simple, fun browser-based game for kids.

Constraints:

- No external libraries. No React. No CDN. No frameworks.
- Use only:
  - HTML
  - CSS
  - Vanilla JavaScript
- Must run entirely in the browser
- No server calls
- No AJAX
- No APIs
- Keep it simple and responsive
- Must work well on desktop and mobile
- Must not require scrolling inside a clipped game area to see important controls

Examples:

- click speed game
- memory matching game
- number guessing
- simple puzzle
- reaction timer
- matching game
- sorting game
- tiny strategy game

---

## OUTPUT FORMAT (STRICT)

Default: output EXACTLY 1 FILE:

1. `game.php`

Only if the user explicitly asks for split files, output EXACTLY 3 FILES:

1. `game.php`
2. `style.css`
3. `script.js`

Preferred format for copy-paste is the single-file version below.

Use this exact format for the default single-file version:

### game.php

```php
// full file here
```

DO NOT add explanations.
DO NOT add extra files.
DO NOT omit the required file(s).

---

## game.php REQUIREMENTS

* Must return an array
* Must define a UNIQUE function name
* Must use output buffering
* Must not echo directly outside buffer
* Must include an `author` field with the game creator name used by `[zeka_oyunlari_grid author="..."]`
* Single-file games should put CSS in `inline_style` and JavaScript in `inline_script`
* Must support the plugin language setting from `zo_get_current_language()`
* Turkish must be the default fallback language
* Must provide all visible player text in:
  - Turkish (`tr`)
  - English (`en`)
  - German (`de`)
  - French (`fr`)
  - Mexican Spanish (`es-mx`)
  - Spain Spanish (`es-es`)
* Must pass the selected language to JavaScript with a `data-lang` attribute
* Must pass the complete labels object to JavaScript with `data-labels`
* Must not hardcode English-only or Turkish-only UI text inside HTML, JavaScript, canvas drawing, alerts, attributes, or status messages
* If the gameplay depends on one language only, mention that clearly in the returned `description`

Template:

```php
<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--{game-slug} {
	max-width: 520px;
	margin: 0 auto;
	padding: 16px;
	box-sizing: border-box;
	text-align: center;
}

.zo-game-root--{game-slug} * {
	box-sizing: border-box;
}

.zo-game-root--{game-slug} .zo-{game-slug}-actions {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap: 10px;
}

@media (max-width: 520px) {
	.zo-game-root.zo-game-root--{game-slug} {
		padding: 12px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--{game-slug}');

	games.forEach(function (game) {
		const lang = game.getAttribute('data-lang') || 'tr';
		const labels = JSON.parse(game.getAttribute('data-labels') || '{}');
		const text = labels[lang] || labels.tr || labels.en || {};

		const scoreEl = game.querySelector('.zo-{game-slug}-score');
		const statusEl = game.querySelector('.zo-{game-slug}-status');
		const startButton = game.querySelector('.zo-{game-slug}-start');
		const restartButton = game.querySelector('.zo-{game-slug}-restart');

		let score = 0;

		function setStatus(message) {
			statusEl.textContent = message;
		}

		function updateScore(nextScore) {
			score = nextScore;
			scoreEl.textContent = String(score);
		}

		startButton.addEventListener('click', function () {
			updateScore(score + 1);
			setStatus(text.correct);
		});

		restartButton.addEventListener('click', function () {
			updateScore(0);
			setStatus(text.statusReady);
		});

		setStatus(text.statusReady);
	});
});
JS;

if (!function_exists('zo_game_{UNIQUE_NAME}_render')) {
	function zo_game_{UNIQUE_NAME}_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-{game-slug}-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));
		$lang = function_exists('zo_get_current_language') ? zo_get_current_language() : 'tr';
		$labels = array(
			'tr' => array(
				'title' => '{Turkish Game Name}',
				'instructions' => '{Turkish instructions}',
				'score' => 'Puan',
				'start' => 'Baslat',
				'restart' => 'Yeniden baslat',
				'correct' => 'Dogru!',
				'wrong' => 'Yanlis.',
				'gameOver' => 'Oyun bitti.',
				'youWin' => 'Kazandin!',
				'statusReady' => 'Baslamak icin Baslat dugmesine bas.',
			),
			'en' => array(
				'title' => '{English Game Name}',
				'instructions' => '{English instructions}',
				'score' => 'Score',
				'start' => 'Start',
				'restart' => 'Restart',
				'correct' => 'Correct!',
				'wrong' => 'Wrong.',
				'gameOver' => 'Game over.',
				'youWin' => 'You win!',
				'statusReady' => 'Press Start to begin.',
			),
			'de' => array(
				'title' => '{German Game Name}',
				'instructions' => '{German instructions}',
				'score' => 'Punkte',
				'start' => 'Starten',
				'restart' => 'Neu starten',
				'correct' => 'Richtig!',
				'wrong' => 'Falsch.',
				'gameOver' => 'Spiel vorbei.',
				'youWin' => 'Du gewinnst!',
				'statusReady' => 'Druecke Starten, um zu beginnen.',
			),
			'fr' => array(
				'title' => '{French Game Name}',
				'instructions' => '{French instructions}',
				'score' => 'Score',
				'start' => 'Demarrer',
				'restart' => 'Redemarrer',
				'correct' => 'Correct !',
				'wrong' => 'Incorrect.',
				'gameOver' => 'Partie terminee.',
				'youWin' => 'Tu as gagne !',
				'statusReady' => 'Appuie sur Demarrer pour commencer.',
			),
			'es-mx' => array(
				'title' => '{Mexican Spanish Game Name}',
				'instructions' => '{Mexican Spanish instructions}',
				'score' => 'Puntuacion',
				'start' => 'Empezar',
				'restart' => 'Reiniciar',
				'correct' => 'Correcto!',
				'wrong' => 'Incorrecto.',
				'gameOver' => 'Fin del juego.',
				'youWin' => 'Ganaste!',
				'statusReady' => 'Pulsa Empezar para comenzar.',
			),
			'es-es' => array(
				'title' => '{Spain Spanish Game Name}',
				'instructions' => '{Spain Spanish instructions}',
				'score' => 'Puntuacion',
				'start' => 'Empezar',
				'restart' => 'Reiniciar',
				'correct' => 'Correcto!',
				'wrong' => 'Incorrecto.',
				'gameOver' => 'Fin del juego.',
				'youWin' => 'Has ganado!',
				'statusReady' => 'Pulsa Empezar para comenzar.',
			),
		);
		$text = isset($labels[$lang]) ? $labels[$lang] : $labels['tr'];

		ob_start();
		?>
		<div
			class="zo-game-root zo-game-root--{game-slug}"
			id="<?php echo esc_attr($instance_id); ?>"
			data-lang="<?php echo esc_attr($lang); ?>"
			data-labels="<?php echo esc_attr(wp_json_encode($labels)); ?>"
		>
			<h2><?php echo esc_html($text['title']); ?></h2>
			<p><?php echo esc_html($text['instructions']); ?></p>
			<div><?php echo esc_html($text['score']); ?>: <span class="zo-{game-slug}-score">0</span></div>
			<div class="zo-{game-slug}-actions">
				<button type="button" class="zo-{game-slug}-start"><?php echo esc_html($text['start']); ?></button>
				<button type="button" class="zo-{game-slug}-restart"><?php echo esc_html($text['restart']); ?></button>
			</div>
			<div class="zo-{game-slug}-status" aria-live="polite"><?php echo esc_html($text['statusReady']); ?></div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => '{game-slug}',
	'name'            => 'TR: {Turkish Game Name} | EN: {English Game Name} | DE: {German Game Name} | FR: {French Game Name} | ES-MX: {Mexican Spanish Game Name} | ES-ES: {Spain Spanish Game Name}',
	'author'          => '{Author Name}',
	'description'     => 'TR: {Turkish description} | EN: {English description} | DE: {German description} | FR: {French description} | ES-MX: {Mexican Spanish description} | ES-ES: {Spain Spanish description}',
	'render_callback' => 'zo_game_{UNIQUE_NAME}_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
```

---

## CSS RULES

* In single-file games, put CSS in the `inline_style` string
* In split-file games, put CSS in `style.css`
* Scope everything under `.zo-game-root` and the game-specific root class
* Do NOT style global elements like `body`, `html`, `button`, or `canvas` without the game root prefix
* Keep styles isolated
* Use `box-sizing: border-box`
* Make the whole game fit in normal page flow
* Do not use fixed heights that clip the game on mobile
* Do not hide overflow on the game root unless the game truly needs it
* Buttons and text must wrap cleanly on small screens
* Controls must remain visible and usable on mobile

Example:

```css
.zo-game-root.zo-game-root--memory-match {
	max-width: 520px;
	margin: 0 auto;
	padding: 16px;
	text-align: center;
}
```

---

## JS RULES

* In single-file games, put JavaScript in the `inline_script` string
* In split-file games, put JavaScript in `script.js`
* Must support multiple instances on one page
* Use `document.querySelectorAll('.zo-game-root--{game-slug}')`
* Loop through each instance
* Do NOT use global variables
* Do NOT assume only one game exists
* Read selected language from `game.getAttribute('data-lang')`
* Read translated strings from `data-labels`
* Do not write hardcoded player-facing strings like `Score`, `Start`, `Game Over`, `Correct`, or `Wrong`
* Store dynamic messages in the labels object, for example `text.gameOver`, `text.correct`, `text.wrong`, `text.nextRound`
* Every new word or phrase added for the game must be added to the labels/content object in all six languages at the same time
* This includes item names, level names, button text, status text, score labels, quiz answers, card words, enemy names, shop names, canvas text, and generated round messages
* Do not use `alert`, `confirm`, or `prompt` unless their text is translated in all six languages
* If drawing text on canvas, every drawn string must come from `text`
* If setting `aria-label`, `title`, `placeholder`, `alt`, or `data-*` text, use translated values

Pattern:

```javascript
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--{game-slug}');

	games.forEach(function (game) {
		const lang = game.getAttribute('data-lang') || 'tr';
		const labels = JSON.parse(game.getAttribute('data-labels') || '{}');
		const text = labels[lang] || labels.tr || labels.en || {};

		// game-specific logic here
	});
});
```

---

## NAMING RULES

* slug: lowercase, hyphen-separated
  Example: `memory-match`
* function name must match slug in underscore style
  Example slug: `memory-match`
  Example function: `zo_game_memory_match_render`
* author: human-readable creator name
  Example: `Asker` or `Arslan`
* Do not reuse an existing slug or function name

---

## GAME DESIGN RULES

* Clear instructions visible to player
* Immediate feedback like score, win/lose message, timer, or status text
* Restart button or replay ability
* Clean readable UI
* Keep the HTML structure simple
* Make controls large enough for touch
* Avoid tiny text, crowded grids, or controls that overlap on mobile
* The game should be playable without needing the browser zoomed out

---

## LANGUAGE RULES

* Every game must work with:
  - `?zo_lang=tr`
  - `?zo_lang=en`
  - `?zo_lang=de`
  - `?zo_lang=fr`
  - `?zo_lang=es-mx`
  - `?zo_lang=es-es`
* Turkish is the default fallback language
* All labels, buttons, instructions, status messages, win/lose text, alerts, canvas text, and aria labels must have all six language versions
* Whenever the game introduces a new word, phrase, object name, prompt, answer, option, or message, it must be added for `tr`, `en`, `de`, `fr`, `es-mx`, and `es-es`
* Do not create a word list, quiz list, card list, shop list, enemy list, level list, or challenge list in only one language
* Do not rely on the plugin runtime translator for new game text; the game itself must provide complete translations
* For game names and descriptions, return the multilingual format:
  `TR: ... | EN: ... | DE: ... | FR: ... | ES-MX: ... | ES-ES: ...`
* If the game uses words, quiz questions, riddles, spelling, countries, or culture-specific content, provide separate content lists for all six languages
* Do not use Turkish word lists in English, German, French, or Spanish modes
* Do not use English word lists in Turkish, German, French, or Spanish modes
* Keep Mexican Spanish and Spain Spanish separate when wording naturally differs
* If a game cannot reasonably support all six languages, make the reason obvious in the description so the plugin owner can block it for unsupported languages
* Prefer text keys such as `score`, `start`, `restart`, `correct`, `wrong`, `gameOver`, `youWin`, `timeUp`, `nextRound`, and `instructions`

---

## IMPORTANT IMPLEMENTATION RULES

* The HTML in `game.php` should use classes specific to the game where practical
* The JavaScript should select elements relative to each `game` instance, not from `document`
* The JavaScript should not break if the same game appears twice on the same page
* Avoid inline JavaScript
* Avoid inline CSS
* Do not use `<script>` tags or `<style>` tags inside the rendered HTML
* Use `inline_style` and `inline_script` in `game.php` for single-file games
* Do not rely on WordPress AJAX, REST API, fetch calls, local storage, or cookies unless explicitly requested
* Keep the game self-contained
* Return clean metadata so the game list search, filter, sorting, and language switcher can work correctly

---

## RESPONSIVE LAYOUT RULES

* The game root should use normal document flow
* Do not use `position: fixed` for the main game board
* Do not set the game root to `height: 100vh` if controls can fall below the viewport
* Prefer `max-width`, `padding`, `gap`, `flex-wrap`, responsive grids, and `aspect-ratio`
* Use `max-height` only when the content can still be reached
* Avoid `overflow: hidden` on containers that hold controls, status text, or game boards
* On mobile, grids should shrink or wrap instead of forcing horizontal scroll

---

## EXAMPLE REQUEST

Create a memory matching card game for kids.

---

## FINAL REMINDER

Return ONLY:

* `game.php` by default
* or `game.php`, `style.css`, `script.js` only if the user explicitly asks for split files

Nothing else.
No explanation.
No extra commentary.
No markdown outside the required file format.
