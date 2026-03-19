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
  - `style.css` (optional but recommended)
  - `script.js` (optional but recommended)

- The plugin will automatically:
  - load `game.php`
  - register and enqueue CSS/JS if present
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

You MUST output EXACTLY 3 FILES:

1. `game.php`
2. `style.css`
3. `script.js`

Use this exact format:

### game.php
```php
// full file here
````

### style.css

```css
/* full file here */
```

### script.js

```javascript
// full file here
```

DO NOT add explanations.
DO NOT add extra files.
DO NOT omit any file.

---

## game.php REQUIREMENTS

* Must return an array
* Must define a UNIQUE function name
* Must use output buffering
* Must not echo directly outside buffer
* Must include an `author` field with the game creator name used by `[zeka_oyunlari_grid author="..."]`

Template:

```php
<?php

if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('zo_game_{UNIQUE_NAME}_render')) {
	function zo_game_{UNIQUE_NAME}_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-{game-slug}-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--{game-slug}" id="<?php echo esc_attr($instance_id); ?>">
			<!-- GAME HTML HERE -->
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => '{game-slug}',
	'name'            => '{Game Name}',
	'author'          => '{Author Name}',
	'description'     => '{Short description}',
	'render_callback' => 'zo_game_{UNIQUE_NAME}_render',
);
```

---

## CSS RULES

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

* Must support multiple instances on one page
* Use `document.querySelectorAll('.zo-game-root')`
* Loop through each instance
* Do NOT use global variables
* Do NOT assume only one game exists

Pattern:

```javascript
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root');

	games.forEach(function (game) {
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

## IMPORTANT IMPLEMENTATION RULES

* The HTML in `game.php` should use classes specific to the game where practical
* The JavaScript should select elements relative to each `game` instance, not from `document`
* The JavaScript should not break if the same game appears twice on the same page
* Avoid inline JavaScript
* Avoid inline CSS
* Do not use `<script>` tags or `<style>` tags inside `game.php`
* Do not rely on WordPress AJAX, REST API, fetch calls, local storage, or cookies unless explicitly requested
* Keep the game self-contained

---

## EXAMPLE REQUEST

Create a memory matching card game for kids.

---

## FINAL REMINDER

Return ONLY:

* `game.php`
* `style.css`
* `script.js`

Nothing else.
No explanation.
No extra commentary.
No markdown outside the required 3-file format.
