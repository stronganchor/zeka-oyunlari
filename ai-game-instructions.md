# Zekâ Oyunları – AI Game Generator Instructions

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
- The plugin can also render a filtered game grid with:
  - `[zeka_oyunlari_grid author="Asker"]`
  - This filter reads the `author` value returned by each game's `game.php`

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
- Should work well on desktop and mobile

Examples:
- click speed game
- memory matching game
- number guessing
- simple puzzle
- reaction timer
- etc.

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
* Must provide all visible player text in Turkish, English, and German
* Must pass the selected language to JavaScript with a `data-lang` attribute
* Must not hardcode English-only or Turkish-only UI text inside HTML or JavaScript
* If the gameplay depends on one language only, mention that clearly in the returned `description`

Template:

```php
<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 500px;
	margin: 0 auto;
	text-align: center;
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--{game-slug}');

	games.forEach(function (game) {
		const lang = game.getAttribute('data-lang') || 'tr';
		const labels = JSON.parse(game.getAttribute('data-labels') || '{}');
		const text = labels[lang] || labels.tr || labels.en || {};

		// game-specific logic here
		// Use text.start, text.score, text.restart, etc. instead of hardcoded UI strings.
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
				'start' => 'Başlat',
				'restart' => 'Yeniden Başlat',
				'statusReady' => 'Başlamak için Başlat düğmesine bas.',
			),
			'en' => array(
				'title' => '{English Game Name}',
				'instructions' => '{English instructions}',
				'score' => 'Score',
				'start' => 'Start',
				'restart' => 'Restart',
				'statusReady' => 'Press Start to begin.',
			),
			'de' => array(
				'title' => '{German Game Name}',
				'instructions' => '{German instructions}',
				'score' => 'Punkte',
				'start' => 'Starten',
				'restart' => 'Neu starten',
				'statusReady' => 'Drücke Starten, um zu beginnen.',
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
			<button type="button" class="zo-{game-slug}-start"><?php echo esc_html($text['start']); ?></button>
			<button type="button" class="zo-{game-slug}-restart"><?php echo esc_html($text['restart']); ?></button>
			<div class="zo-{game-slug}-status" aria-live="polite"><?php echo esc_html($text['statusReady']); ?></div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => '{game-slug}',
	'name'            => 'TR: {Turkish Game Name} | EN: {English Game Name} | DE: {German Game Name}',
	'author'          => '{Author Name}',
	'description'     => 'TR: {Turkish description} | EN: {English description} | DE: {German description}',
	'render_callback' => 'zo_game_{UNIQUE_NAME}_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
```

---

## CSS RULES

* In single-file games, put CSS in the `inline_style` string
* In split-file games, put CSS in `style.css`
* Scope everything under `.zo-game-root`
* Do NOT style global elements like `body`
* Keep styles isolated

Example:

```css
.zo-game-root {
	max-width: 500px;
	margin: 0 auto;
	text-align: center;
}
```

---

## JS RULES

* In single-file games, put JavaScript in the `inline_script` string
* In split-file games, put JavaScript in `script.js`
* Must support multiple instances on one page
* Use `document.querySelectorAll('.zo-game-root')`
* Loop through each instance
* Do NOT use global variables
* Do NOT assume only one game exists
* Read selected language from `game.getAttribute('data-lang')`
* Read translated strings from `data-labels`
* Do not write hardcoded player-facing strings like `Score`, `Start`, `Game Over`, or `Correct`
* Store dynamic messages in the labels object, for example `text.gameOver`, `text.correct`, `text.wrong`, `text.nextRound`

Pattern:

```javascript
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root');

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
  Example: `Asker`

---

## GAME DESIGN RULES

* Clear instructions visible to player
* Immediate feedback like score, win/lose message, timer, or status text
* Restart button or replay ability
* Clean readable UI
* Keep the HTML structure simple

---

## LANGUAGE RULES

* Every game must work with `?zo_lang=tr`, `?zo_lang=en`, and `?zo_lang=de`
* Turkish is the default fallback language
* All labels, buttons, instructions, status messages, win/lose text, alerts, canvas text, and aria labels must have TR, EN, and DE versions
* For game names and descriptions, return the multilingual format:
  `TR: ... | EN: ... | DE: ...`
* If the game uses words, quiz questions, riddles, spelling, countries, or culture-specific content, provide separate content lists for TR, EN, and DE
* Do not use Turkish word lists in English or German mode
* Do not use English word lists in Turkish or German mode
* If a game cannot reasonably support all three languages, make the reason obvious in the description so the plugin owner can block it for unsupported languages
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
No markdown outside the required 3-file format.
