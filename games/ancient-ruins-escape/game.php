<?php

if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('zo_game_ancient_ruins_escape_render')) {
	function zo_game_ancient_ruins_escape_render($post_id = 0, $module = array()) {
		$lang = function_exists('zo_get_current_language') ? zo_get_current_language() : 'tr';
		$labels = array(
			'tr' => array(
				'title' => 'Antik Harabelerden Kaçış',
				'instructions' => 'Sol ve sağ oklarla şerit değiştir. Dikenlerden zıpla, kirişlerin altından kay ve devrilmiş sütunlardan kaç. Telefonda düğmeleri veya kaydırma hareketlerini kullan.',
				'play' => 'Oyna', 'again' => 'Yeniden oyna', 'pause' => 'Duraklat', 'resume' => 'Devam et',
				'left' => 'Sol', 'right' => 'Sağ', 'jump' => 'Zıpla', 'slide' => 'Kay',
				'distance' => 'Mesafe', 'time' => 'Süre', 'best' => 'En iyi', 'ready' => 'Harabelere girmeye hazır mısın?',
				'paused' => 'Oyun duraklatıldı', 'over' => 'Harabeler seni yakaladı!',
				'spikes' => 'Dikenlerin üzerinden zıpla!', 'beam' => 'Kirişlerin altından kay!',
				'pillar' => 'Devrilmiş sütunlardan kaç!', 'board' => 'Antik Harabelerden Kaçış oyun alanı',
			),
			'en' => array(
				'title' => 'Ancient Ruins Escape',
				'instructions' => 'Use left and right arrows to change lanes. Jump over spikes, slide under beams, and dodge fallen pillars. On a phone, use the buttons or swipe.',
				'play' => 'Play', 'again' => 'Play again', 'pause' => 'Pause', 'resume' => 'Resume',
				'left' => 'Left', 'right' => 'Right', 'jump' => 'Jump', 'slide' => 'Slide',
				'distance' => 'Distance', 'time' => 'Time', 'best' => 'Best', 'ready' => 'Ready to enter the ruins?',
				'paused' => 'Game paused', 'over' => 'The ruins got you!',
				'spikes' => 'Jump over the spikes!', 'beam' => 'Slide under the beams!',
				'pillar' => 'Dodge the fallen pillars!', 'board' => 'Ancient Ruins Escape game area',
			),
			'de' => array(
				'title' => 'Flucht aus antiken Ruinen',
				'instructions' => 'Wechsle mit den Pfeiltasten die Spur. Springe über Stacheln, rutsche unter Balken durch und weiche Säulen aus. Auf dem Handy kannst du die Tasten oder Wischgesten nutzen.',
				'play' => 'Spielen', 'again' => 'Erneut spielen', 'pause' => 'Pause', 'resume' => 'Weiter',
				'left' => 'Links', 'right' => 'Rechts', 'jump' => 'Springen', 'slide' => 'Rutschen',
				'distance' => 'Strecke', 'time' => 'Zeit', 'best' => 'Rekord', 'ready' => 'Bereit für die Ruinen?',
				'paused' => 'Spiel pausiert', 'over' => 'Die Ruinen haben dich erwischt!',
				'spikes' => 'Spring über die Stacheln!', 'beam' => 'Rutsch unter den Balken!',
				'pillar' => 'Weiche den Säulen aus!', 'board' => 'Spielfeld Flucht aus antiken Ruinen',
			),
			'fr' => array(
				'title' => 'Évasion des ruines antiques',
				'instructions' => 'Change de voie avec les flèches. Saute par-dessus les piques, glisse sous les poutres et évite les colonnes. Sur téléphone, utilise les boutons ou glisse le doigt.',
				'play' => 'Jouer', 'again' => 'Rejouer', 'pause' => 'Pause', 'resume' => 'Continuer',
				'left' => 'Gauche', 'right' => 'Droite', 'jump' => 'Sauter', 'slide' => 'Glisser',
				'distance' => 'Distance', 'time' => 'Temps', 'best' => 'Record', 'ready' => 'Prêt à entrer dans les ruines ?',
				'paused' => 'Jeu en pause', 'over' => 'Les ruines t’ont eu !',
				'spikes' => 'Saute par-dessus les piques !', 'beam' => 'Glisse sous les poutres !',
				'pillar' => 'Évite les colonnes !', 'board' => 'Zone de jeu Évasion des ruines antiques',
			),
			'es-mx' => array(
				'title' => 'Escape de las Ruinas Antiguas',
				'instructions' => 'Cambia de carril con las flechas. Salta los picos, deslízate bajo las vigas y esquiva las columnas. En el celular, usa los botones o desliza el dedo.',
				'play' => 'Jugar', 'again' => 'Volver a jugar', 'pause' => 'Pausa', 'resume' => 'Continuar',
				'left' => 'Izquierda', 'right' => 'Derecha', 'jump' => 'Saltar', 'slide' => 'Deslizar',
				'distance' => 'Distancia', 'time' => 'Tiempo', 'best' => 'Récord', 'ready' => '¿Listo para entrar a las ruinas?',
				'paused' => 'Juego en pausa', 'over' => '¡Las ruinas te atraparon!',
				'spikes' => '¡Salta los picos!', 'beam' => '¡Deslízate bajo las vigas!',
				'pillar' => '¡Esquiva las columnas!', 'board' => 'Área de juego Escape de las Ruinas Antiguas',
			),
			'es-es' => array(
				'title' => 'Huida de las Ruinas Antiguas',
				'instructions' => 'Cambia de carril con las flechas. Salta los pinchos, deslízate bajo las vigas y esquiva las columnas. En el móvil, usa los botones o desliza el dedo.',
				'play' => 'Jugar', 'again' => 'Volver a jugar', 'pause' => 'Pausa', 'resume' => 'Continuar',
				'left' => 'Izquierda', 'right' => 'Derecha', 'jump' => 'Saltar', 'slide' => 'Deslizar',
				'distance' => 'Distancia', 'time' => 'Tiempo', 'best' => 'Récord', 'ready' => '¿Listo para entrar en las ruinas?',
				'paused' => 'Juego en pausa', 'over' => '¡Las ruinas te han atrapado!',
				'spikes' => '¡Salta los pinchos!', 'beam' => '¡Deslízate bajo las vigas!',
				'pillar' => '¡Esquiva las columnas!', 'board' => 'Zona de juego Huida de las Ruinas Antiguas',
			),
		);
		$text = isset($labels[$lang]) ? $labels[$lang] : $labels['tr'];

		ob_start();
		?>
		<section class="zo-game-root zo-game-root--ancient-ruins-escape" data-labels="<?php echo esc_attr(wp_json_encode($text)); ?>" tabindex="-1">
			<h2><?php echo esc_html($text['title']); ?></h2>
			<p class="zo-ruins-instructions"><?php echo esc_html($text['instructions']); ?></p>
			<div class="zo-ruins-hud">
				<div><span><?php echo esc_html($text['distance']); ?></span><strong class="zo-ruins-distance">0 m</strong></div>
				<div><span><?php echo esc_html($text['time']); ?></span><strong class="zo-ruins-time">0.0 s</strong></div>
				<div><span><?php echo esc_html($text['best']); ?></span><strong class="zo-ruins-best">0 m</strong></div>
			</div>
			<div class="zo-ruins-stage">
				<canvas width="900" height="650" tabindex="0" aria-label="<?php echo esc_attr($text['board']); ?>"></canvas>
				<div class="zo-ruins-overlay"><strong class="zo-ruins-overlay-title"><?php echo esc_html($text['title']); ?></strong><span class="zo-ruins-overlay-detail"><?php echo esc_html($text['ready']); ?></span></div>
			</div>
			<div class="zo-ruins-controls">
				<button type="button" class="zo-ruins-move" data-action="left" aria-label="<?php echo esc_attr($text['left']); ?>">← <span><?php echo esc_html($text['left']); ?></span></button>
				<button type="button" class="zo-ruins-move" data-action="jump" aria-label="<?php echo esc_attr($text['jump']); ?>">↑ <span><?php echo esc_html($text['jump']); ?></span></button>
				<button type="button" class="zo-ruins-move" data-action="slide" aria-label="<?php echo esc_attr($text['slide']); ?>">↓ <span><?php echo esc_html($text['slide']); ?></span></button>
				<button type="button" class="zo-ruins-move" data-action="right" aria-label="<?php echo esc_attr($text['right']); ?>">→ <span><?php echo esc_html($text['right']); ?></span></button>
			</div>
			<div class="zo-ruins-actions">
				<button type="button" class="zo-ruins-start"><?php echo esc_html($text['play']); ?></button>
				<button type="button" class="zo-ruins-pause" disabled><?php echo esc_html($text['pause']); ?></button>
			</div>
			<p class="zo-ruins-status" role="status" aria-live="polite"><?php echo esc_html($text['ready']); ?></p>
		</section>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug' => 'ancient-ruins-escape',
	'name' => 'TR: Antik Harabelerden Kaçış | EN: Ancient Ruins Escape | DE: Flucht aus antiken Ruinen | FR: Évasion des ruines antiques | ES-MX: Escape de las Ruinas Antiguas | ES-ES: Huida de las Ruinas Antiguas',
	'author' => 'Arslan',
	'description' => 'TR: Üç şeritli antik yolda koş. Dikenlerden zıpla, kirişlerin altından kay ve sütunlardan kaç. | EN: Run along three ancient lanes. Jump over spikes, slide under beams, and dodge fallen pillars. | DE: Lauf durch drei antike Spuren. Spring über Stacheln, rutsch unter Balken und weiche Säulen aus. | FR: Cours sur trois voies antiques. Saute les piques, glisse sous les poutres et évite les colonnes. | ES-MX: Corre por tres carriles antiguos. Salta los picos, deslízate bajo las vigas y esquiva las columnas. | ES-ES: Corre por tres carriles antiguos. Salta los pinchos, deslízate bajo las vigas y esquiva las columnas.',
	'render_callback' => 'zo_game_ancient_ruins_escape_render',
);
