<?php
/** Read-only, server-rendered guides for Asker's games. */
if (!defined('ABSPATH')) {
	exit;
}

function zo_game_guide_text($key, $language = '') {
	$language = $language !== '' ? $language : zo_get_current_language();
	$language = strpos($language, 'es-') === 0 ? 'es' : $language;
	$text = array(
		'tr' => array('link'=>'Açıklama ve Nasıl Oynanır', 'title'=>'%s: Nasıl Oynanır, Kurallar ve Kazanımlar', 'about'=>'Oyun hakkında', 'steps'=>'Nasıl oynanır?', 'rules'=>'Kurallar', 'benefits'=>'Hangi becerileri çalıştırır?', 'play'=>'Oyuna Git', 'back'=>'Asker’in Oyunlarına Dön', 'summary'=>'Oyun rehberi', 'missing'=>'Oyun rehberi bulunamadı.', 'unavailable'=>'Bu oyun şu anda kullanılamıyor. Oynanış yeniden açılana kadar bir oyun başlatılamaz.', 'practice'=>'Bu etkinlik alıştırma fırsatı sunar; belirli bir öğrenme sonucu garanti etmez.', 'languages'=>'Dil'),
		'en' => array('link'=>'Description & How to Play', 'title'=>'%s: How to Play, Rules & Learning Benefits', 'about'=>'About this game', 'steps'=>'How to play', 'rules'=>'Rules', 'benefits'=>'Skills to practice', 'play'=>'Go to Game', 'back'=>'Back to Asker’s Games', 'summary'=>'Game guide', 'missing'=>'Game guide not found.', 'unavailable'=>'This game is currently unavailable. A game cannot be started until play is restored.', 'practice'=>'This activity offers practice; it does not guarantee a particular learning outcome.', 'languages'=>'Language'),
		'de' => array('link'=>'Beschreibung und Spielanleitung', 'title'=>'%s: Anleitung, Regeln und Lernmöglichkeiten', 'about'=>'Über das Spiel', 'steps'=>'So wird gespielt', 'rules'=>'Regeln', 'benefits'=>'Diese Fähigkeiten werden geübt', 'play'=>'Zum Spiel', 'back'=>'Zurück zu Askers Spielen', 'summary'=>'Spielanleitung', 'missing'=>'Spielanleitung nicht gefunden.', 'unavailable'=>'Dieses Spiel ist derzeit nicht verfügbar. Es kann erst nach der Freigabe wieder gespielt werden.', 'practice'=>'Diese Aktivität bietet Übung, garantiert aber keinen bestimmten Lernerfolg.', 'languages'=>'Sprache'),
		'fr' => array('link'=>'Description et règles du jeu', 'title'=>'%s : instructions, règles et apprentissages', 'about'=>'À propos du jeu', 'steps'=>'Comment jouer', 'rules'=>'Règles', 'benefits'=>'Compétences à exercer', 'play'=>'Accéder au jeu', 'back'=>'Retour aux jeux d’Asker', 'summary'=>'Guide du jeu', 'missing'=>'Guide du jeu introuvable.', 'unavailable'=>'Ce jeu est actuellement indisponible. Il sera possible de jouer après sa réouverture.', 'practice'=>'Cette activité permet de s’exercer sans garantir un résultat d’apprentissage particulier.', 'languages'=>'Langue'),
		'es' => array('link'=>'Descripción y cómo jugar', 'title'=>'%s: instrucciones, reglas y aprendizaje', 'about'=>'Acerca del juego', 'steps'=>'Cómo jugar', 'rules'=>'Reglas', 'benefits'=>'Habilidades que puedes practicar', 'play'=>'Ir al juego', 'back'=>'Volver a los juegos de Asker', 'summary'=>'Guía del juego', 'missing'=>'No se encontró la guía del juego.', 'unavailable'=>'Este juego no está disponible actualmente. Podrás jugar cuando vuelva a estar habilitado.', 'practice'=>'Esta actividad permite practicar, sin garantizar un resultado de aprendizaje específico.', 'languages'=>'Idioma'),
	);
	return $text[$language][$key] ?? $text['en'][$key] ?? '';
}

function zo_get_game_guide($module, $language = '') {
	if (!is_array($module) || zo_get_game_owner_for_module($module) !== 'asker' || empty($module['slug'])) {
		return null;
	}
	$language = $language !== '' ? $language : zo_get_current_language();
	if (!zo_is_game_available_for_language($module['slug'], $language)) {
		return null;
	}
	static $content = null;
	if ($content === null) {
		$content = require __DIR__ . '/game-guide-content.php';
	}
	$key = in_array($module['slug'], $content['clock_slugs'], true) ? '_clock' : $module['slug'];
	$locale = strpos($language, 'es-') === 0 ? 'es' : $language;
	if (!isset($content['games'][$key][$locale])) {
		return null;
	}
	$row = $content['games'][$key][$locale];
	return array('steps'=>explode(' | ', $row[0]), 'rules'=>explode(' | ', $row[1]), 'benefits'=>$row[2]);
}

function zo_get_game_description_url($slug, $language = '') {
	$language = $language !== '' ? $language : zo_get_current_language();
	$module = zo_get_game_module($slug);
	if (!zo_get_game_guide($module, $language)) {
		return '';
	}
	// Stable public URLs: no expiring nonce, referrer or rewrite-rule flush needed.
	return add_query_arg(array('zo_game_description'=>$module['slug'], 'zo_lang'=>$language), home_url('/'));
}

function zo_get_requested_description_module() {
	if (!isset($_GET['zo_game_description']) || !is_string($_GET['zo_game_description'])) {
		return null;
	}
	$slug = wp_unslash($_GET['zo_game_description']);
	if ($slug === '' || $slug !== sanitize_title($slug)) {
		return null;
	}
	$module = zo_get_game_module($slug);
	return zo_get_game_guide($module) ? $module : null;
}

function zo_game_description_canonical_redirect($redirect_url) {
	return isset($_GET['zo_game_description']) ? false : $redirect_url;
}

function zo_render_game_description_link($module, $language = '') {
	$language = $language !== '' ? $language : zo_get_current_language();
	$url = zo_get_game_description_url($module['slug'] ?? '', $language);
	if ($url === '') {
		return '';
	}
	$meta = zo_get_localized_game_display_metadata($module, $language);
	$label = zo_game_guide_text('link', $language);
	return '<a class="zo-game-guide-link" data-zo-game-description-link href="' . esc_url($url) . '" aria-label="' . esc_attr($meta['name'] . ': ' . $label) . '">' . esc_html($label) . '</a>';
}

function zo_render_game_guide($module, $language = '', $compact = false) {
	$language = $language !== '' ? $language : zo_get_current_language();
	$guide = zo_get_game_guide($module, $language);
	if (!$guide) {
		return '';
	}
	$html = '<section class="zo-game-guide' . ($compact ? ' zo-game-guide--compact' : '') . '" lang="' . esc_attr($language) . '">';
	$html .= '<h2>' . esc_html(zo_game_guide_text($compact ? 'summary' : 'steps', $language)) . '</h2>';
	if (isset($module['available']) && $module['available'] === false) {
		$html .= '<p>' . esc_html(zo_game_guide_text('unavailable', $language)) . '</p>';
	} else {
		foreach (array('steps', 'rules') as $field) {
			if ($compact || $field !== 'steps') {
				$html .= '<h3>' . esc_html(zo_game_guide_text($field, $language)) . '</h3>';
			}
			$items = $compact ? array_slice($guide[$field], 0, 1) : $guide[$field];
			$tag = $field === 'steps' ? 'ol' : 'ul';
			$html .= '<' . $tag . '>';
			foreach ($items as $item) {
				$html .= '<li>' . esc_html($item) . '</li>';
			}
			$html .= '</' . $tag . '>';
		}
		$html .= '<h3>' . esc_html(zo_game_guide_text('benefits', $language)) . '</h3><p>' . esc_html($guide['benefits']) . '</p>';
	}
	if ($compact) {
		$html .= zo_render_game_description_link($module, $language);
	}
	return $html . '</section>';
}
