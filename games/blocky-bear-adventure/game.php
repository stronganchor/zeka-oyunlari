<?php

if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('zo_game_blocky_bear_adventure_render')) {
	function zo_game_blocky_bear_adventure_render($post_id = 0, $module = array()) {
		$lang = function_exists('zo_get_current_language') ? zo_get_current_language() : 'tr';
		$labels = array(
			'tr' => array(
				'title' => 'Blok Ayı Macerası',
				'instructions' => '1000 seviye var; her seviyede boşluklar genişler ve düşmanlar hızlanır. Ayıyı yönlendir, zıpla ve bayrağa ulaş.',
				'play' => 'Oyna', 'again' => 'Yeniden oyna', 'next' => 'Sonraki seviye', 'pause' => 'Duraklat', 'resume' => 'Devam et',
				'left' => 'Sol', 'right' => 'Sağ', 'jump' => 'Zıpla', 'hearts' => 'Kalpler', 'coins' => 'Paralar',
				'level' => 'Seviye', 'unlocked' => 'Açılan', 'go' => 'Git', 'levelLocked' => 'Açılmış bir seviye seç.',
				'ready' => 'Macera seni bekliyor!', 'paused' => 'Oyun duraklatıldı', 'won' => 'Başardın!',
				'lost' => 'Tekrar dene!', 'board' => 'Blok Ayı Macerası oyun alanı',
			),
			'en' => array(
				'title' => 'Blocky Bear Adventure',
				'instructions' => 'Play 1,000 levels. Each level widens the gaps and speeds up enemies. Guide the bear, jump, and reach the flag.',
				'play' => 'Play', 'again' => 'Play again', 'next' => 'Next level', 'pause' => 'Pause', 'resume' => 'Resume',
				'left' => 'Left', 'right' => 'Right', 'jump' => 'Jump', 'hearts' => 'Hearts', 'coins' => 'Coins',
				'level' => 'Level', 'unlocked' => 'Unlocked', 'go' => 'Go', 'levelLocked' => 'Choose an unlocked level.',
				'ready' => 'Adventure awaits!', 'paused' => 'Game paused', 'won' => 'You made it!',
				'lost' => 'Try again!', 'board' => 'Blocky Bear Adventure game area',
			),
			'de' => array(
				'title' => 'Blockbär-Abenteuer',
				'instructions' => 'Spiele 1000 Level. Mit jedem Level werden die Lücken breiter und die Gegner schneller. Führe den Bären zur Flagge.',
				'play' => 'Spielen', 'again' => 'Erneut spielen', 'next' => 'Nächstes Level', 'pause' => 'Pause', 'resume' => 'Weiter',
				'left' => 'Links', 'right' => 'Rechts', 'jump' => 'Springen', 'hearts' => 'Herzen', 'coins' => 'Münzen',
				'level' => 'Level', 'unlocked' => 'Freigeschaltet', 'go' => 'Los', 'levelLocked' => 'Wähle ein freigeschaltetes Level.',
				'ready' => 'Das Abenteuer wartet!', 'paused' => 'Spiel pausiert', 'won' => 'Geschafft!',
				'lost' => 'Versuch es noch mal!', 'board' => 'Spielfeld Blockbär-Abenteuer',
			),
			'fr' => array(
				'title' => 'Aventure de l’ours cubique',
				'instructions' => 'Joue à 1000 niveaux. À chaque niveau, les fossés s’élargissent et les ennemis accélèrent. Guide l’ours jusqu’au drapeau.',
				'play' => 'Jouer', 'again' => 'Rejouer', 'next' => 'Niveau suivant', 'pause' => 'Pause', 'resume' => 'Continuer',
				'left' => 'Gauche', 'right' => 'Droite', 'jump' => 'Sauter', 'hearts' => 'Cœurs', 'coins' => 'Pièces',
				'level' => 'Niveau', 'unlocked' => 'Débloqué', 'go' => 'Aller', 'levelLocked' => 'Choisis un niveau débloqué.',
				'ready' => 'L’aventure t’attend !', 'paused' => 'Jeu en pause', 'won' => 'Tu as réussi !',
				'lost' => 'Réessaie !', 'board' => 'Zone de jeu Aventure de l’ours cubique',
			),
			'es-mx' => array(
				'title' => 'Aventura del Oso de Bloques',
				'instructions' => 'Juega 1000 niveles. En cada nivel los huecos crecen y los enemigos se aceleran. Guía al oso hasta la bandera.',
				'play' => 'Jugar', 'again' => 'Volver a jugar', 'next' => 'Siguiente nivel', 'pause' => 'Pausa', 'resume' => 'Continuar',
				'left' => 'Izquierda', 'right' => 'Derecha', 'jump' => 'Saltar', 'hearts' => 'Corazones', 'coins' => 'Monedas',
				'level' => 'Nivel', 'unlocked' => 'Desbloqueado', 'go' => 'Ir', 'levelLocked' => 'Elige un nivel desbloqueado.',
				'ready' => '¡Te espera una aventura!', 'paused' => 'Juego en pausa', 'won' => '¡Lo lograste!',
				'lost' => '¡Inténtalo de nuevo!', 'board' => 'Área de juego Aventura del Oso de Bloques',
			),
			'es-es' => array(
				'title' => 'Aventura del Oso de Bloques',
				'instructions' => 'Juega 1000 niveles. En cada nivel los huecos crecen y los enemigos se aceleran. Guía al oso hasta la bandera.',
				'play' => 'Jugar', 'again' => 'Volver a jugar', 'next' => 'Siguiente nivel', 'pause' => 'Pausa', 'resume' => 'Continuar',
				'left' => 'Izquierda', 'right' => 'Derecha', 'jump' => 'Saltar', 'hearts' => 'Corazones', 'coins' => 'Monedas',
				'level' => 'Nivel', 'unlocked' => 'Desbloqueado', 'go' => 'Ir', 'levelLocked' => 'Elige un nivel desbloqueado.',
				'ready' => '¡Te espera una aventura!', 'paused' => 'Juego en pausa', 'won' => '¡Lo has conseguido!',
				'lost' => '¡Inténtalo de nuevo!', 'board' => 'Zona de juego Aventura del Oso de Bloques',
			),
		);
		$text = isset($labels[$lang]) ? $labels[$lang] : $labels['tr'];

		ob_start();
		?>
		<section class="zo-game-root zo-game-root--blocky-bear-adventure" data-labels="<?php echo esc_attr(wp_json_encode($text)); ?>" tabindex="-1">
			<h2><?php echo esc_html($text['title']); ?></h2>
			<p class="zo-bear-instructions"><?php echo esc_html($text['instructions']); ?></p>
			<div class="zo-bear-hud">
				<div><span><?php echo esc_html($text['hearts']); ?></span><strong class="zo-bear-hearts" aria-label="3">♥ ♥ ♥</strong></div>
				<div><span><?php echo esc_html($text['coins']); ?></span><strong class="zo-bear-coins">0 / 23</strong></div>
				<div><span><?php echo esc_html($text['level']); ?></span><strong class="zo-bear-level">1 / 1000</strong></div>
				<div><span><?php echo esc_html($text['unlocked']); ?></span><strong class="zo-bear-unlocked">1 / 1000</strong></div>
			</div>
			<div class="zo-bear-stage">
				<canvas width="960" height="600" tabindex="0" aria-label="<?php echo esc_attr($text['board']); ?>"></canvas>
				<div class="zo-bear-overlay"><strong class="zo-bear-overlay-title"><?php echo esc_html($text['title']); ?></strong><span class="zo-bear-overlay-detail"><?php echo esc_html($text['ready']); ?></span></div>
			</div>
			<div class="zo-bear-controls">
				<button type="button" class="zo-bear-control" data-action="left" aria-label="<?php echo esc_attr($text['left']); ?>">← <span><?php echo esc_html($text['left']); ?></span></button>
				<button type="button" class="zo-bear-control" data-action="right" aria-label="<?php echo esc_attr($text['right']); ?>">→ <span><?php echo esc_html($text['right']); ?></span></button>
				<button type="button" class="zo-bear-control zo-bear-jump" data-action="jump" aria-label="<?php echo esc_attr($text['jump']); ?>">↑ <span><?php echo esc_html($text['jump']); ?></span></button>
			</div>
			<div class="zo-bear-actions">
				<button type="button" class="zo-bear-start"><?php echo esc_html($text['play']); ?></button>
				<button type="button" class="zo-bear-pause" disabled><?php echo esc_html($text['pause']); ?></button>
			</div>
			<div class="zo-bear-level-picker">
				<label><?php echo esc_html($text['level']); ?> <input class="zo-bear-level-input" type="number" min="1" max="1" value="1" inputmode="numeric"></label>
				<button type="button" class="zo-bear-level-go"><?php echo esc_html($text['go']); ?></button>
			</div>
			<p class="zo-bear-status" role="status" aria-live="polite"><?php echo esc_html($text['ready']); ?></p>
		</section>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug' => 'blocky-bear-adventure',
	'name' => 'TR: Blok Ayı Macerası | EN: Blocky Bear Adventure | DE: Blockbär-Abenteuer | FR: Aventure de l’ours cubique | ES-MX: Aventura del Oso de Bloques | ES-ES: Aventura del Oso de Bloques',
	'author' => 'Arslan',
	'description' => 'TR: Ayıyı platformlardan geçir, paraları topla, düşmanları aş ve bayrağa ulaş. | EN: Guide the bear across platforms, collect coins, dodge enemies, and reach the flag. | DE: Führe den Bären über Plattformen, sammle Münzen, weiche Gegnern aus und erreiche die Flagge. | FR: Guide l’ours sur les plateformes, ramasse les pièces, évite les ennemis et atteins le drapeau. | ES-MX: Guía al oso por las plataformas, junta monedas, esquiva enemigos y llega a la bandera. | ES-ES: Guía al oso por las plataformas, recoge monedas, esquiva enemigos y llega a la bandera.',
	'render_callback' => 'zo_game_blocky_bear_adventure_render',
);
