<?php
/**
 * Plugin Name: Zekâ Oyunları
 * Plugin URI: https://github.com/stronganchor/zeka-oyunlari
 * Description: Simple modular game framework for zekâ.com so kids can publish WordPress-based games and share them with friends.
 * Version: 1.4.86.asker.arslan
 * Update URI: https://github.com/stronganchor/zeka-oyunlari
 * Author: Anadolu Tasarım
 * Author URI: https://github.com/stronganchor/zeka-oyunlari
 * Text Domain: zeka-oyunlari
 * Requires at least: 6.0
 * Requires PHP: 7.4
 */

if (!defined('ABSPATH')) {
	exit;
}

define('ZO_PLUGIN_VERSION', '1.4.73.asker.arslan');
define('ZO_PLUGIN_FILE', __FILE__);
define('ZO_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('ZO_PLUGIN_URL', plugin_dir_url(__FILE__));

function zo_get_shortcode_logo_html($context = '') {
	$context = sanitize_html_class((string) $context);
	$class   = 'zo-shortcode-logo';

	if ($context !== '') {
		$class .= ' zo-shortcode-logo--' . $context;
	}

	return '<a class="' . esc_attr($class) . '" href="' . esc_url(home_url('/')) . '" aria-label="' . esc_attr__('zekâ.com', 'zeka-oyunlari') . '">'
		. '<img src="' . esc_url(ZO_PLUGIN_URL . 'zeka-logo.png') . '" alt="' . esc_attr__('zekâ.com', 'zeka-oyunlari') . '" loading="lazy" decoding="async">'
		. '</a>';
}

function zo_get_shortcode_logo_css() {
	return '
.zo-shortcode-frame,
.zo-game-shell {
	position: relative;
}

.zo-shortcode-logo {
	position: absolute;
	top: 12px;
	right: 12px;
	z-index: 30;
	display: inline-flex;
	align-items: center;
	justify-content: center;
	width: clamp(62px, 7vw, 96px);
	aspect-ratio: 1;
	border-radius: 0;
	background: transparent;
	box-shadow: none;
	line-height: 0;
	text-decoration: none;
}

.zo-shortcode-logo img {
	display: block;
	width: 94%;
	height: 94%;
	object-fit: contain;
}

.zo-shortcode-logo:hover,
.zo-shortcode-logo:focus {
	background: transparent;
	box-shadow: none;
	outline: none;
}

.zo-games-grid__toolbar,
.zo-asker-about__language,
.zo-site-about__language {
	padding-right: 92px;
}

@media (max-width: 640px) {
	.zo-shortcode-logo {
		top: 8px;
		right: 8px;
		width: 58px;
		border-radius: 0;
	}

	.zo-games-grid__toolbar,
	.zo-asker-about__language,
	.zo-site-about__language {
		padding-right: 62px;
	}
}
';
}

function zo_get_update_branch() {
	$branch = 'main';

	if (defined('ZEKA_OYUNLARI_UPDATE_BRANCH') && is_string(ZEKA_OYUNLARI_UPDATE_BRANCH)) {
		$override = trim(ZEKA_OYUNLARI_UPDATE_BRANCH);
		if ($override !== '') {
			$branch = $override;
		}
	}

	return (string) apply_filters('zeka_oyunlari_update_branch', $branch);
}

function zo_bootstrap_update_checker() {
	$checker_file = ZO_PLUGIN_DIR . 'plugin-update-checker/plugin-update-checker.php';
	if (!file_exists($checker_file)) {
		return;
	}

	require_once $checker_file;

	if (!class_exists('\YahnisElsts\PluginUpdateChecker\v5\PucFactory')) {
		return;
	}

	$repo_url = (string) apply_filters(
		'zeka_oyunlari_update_repository',
		'https://github.com/stronganchor/zeka-oyunlari'
	);
	$slug = dirname(plugin_basename(__FILE__));

	$update_checker = \YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
		$repo_url,
		__FILE__,
		$slug
	);

	$update_checker->setBranch(zo_get_update_branch());

	foreach (array('ZEKA_OYUNLARI_GITHUB_TOKEN', 'STRONGANCHOR_GITHUB_TOKEN', 'ANCHOR_GITHUB_TOKEN') as $constant_name) {
		if (!defined($constant_name) || !is_string(constant($constant_name))) {
			continue;
		}

		$token = trim((string) constant($constant_name));
		if ($token !== '') {
			$update_checker->setAuthentication($token);
			break;
		}
	}
}

zo_bootstrap_update_checker();

register_activation_hook(__FILE__, 'zo_plugin_activate');
register_deactivation_hook(__FILE__, 'zo_plugin_deactivate');

function zo_plugin_activate() {
	zo_register_game_post_type();
	zo_sync_game_module_posts();
	flush_rewrite_rules();
}

function zo_plugin_deactivate() {
	flush_rewrite_rules();
}

function zo_load_game_module_file($file) {
	static $loaded_modules = array();

	$file = (string) $file;

	if ($file === '') {
		return null;
	}

	if (array_key_exists($file, $loaded_modules)) {
		return $loaded_modules[$file];
	}

	ob_start();
	$module = null;

	try {
		$module = require $file;
	} catch (Throwable $throwable) {
		ob_end_clean();
		error_log(
			sprintf(
				'[Zeka Oyunlari] Skipping broken game module "%1$s": %2$s in %3$s on line %4$d',
				basename(dirname($file)),
				$throwable->getMessage(),
				$throwable->getFile(),
				(int) $throwable->getLine()
			)
		);

		$loaded_modules[$file] = null;

		return null;
	}

	$extra_output = ob_get_clean();

	if (!is_array($module)) {
		if ($extra_output !== '') {
			error_log(
				sprintf(
					'[Zeka Oyunlari] Ignoring unexpected output while loading game module "%1$s"',
					basename(dirname($file))
				)
			);
		}

		$loaded_modules[$file] = null;

		return null;
	}

	if ($extra_output !== '') {
		error_log(
			sprintf(
				'[Zeka Oyunlari] Discarded output while loading game module "%1$s"',
				basename(dirname($file))
			)
		);
	}

	$loaded_modules[$file] = $module;

	return $loaded_modules[$file];
}

function zo_get_asker_multilingual_game_metadata($slug) {
	$items = array(
		'adam-asmaca' => array(
			'name' => 'TR: Adam Asmaca | EN: Hangman | DE: Galgenmännchen',
			'description' => 'TR: Çocuklar için ipuçlu, puan takipli ve tekrar oynanabilir bir Adam Asmaca oyunu. EN: A replayable Hangman game for kids with hints and score tracking. DE: Ein wiederholbares Galgenmännchen-Spiel für Kinder mit Hinweisen und Punktestand.',
		),
		'adana-clock' => array(
			'name' => 'TR: Adana Saati | EN: Adana Clock | DE: Adana-Uhr',
			'description' => 'TR: Adana saatini saniyelerle gösteren basit bir tarayıcı saati. EN: A simple browser clock showing the current time in Adana with seconds. DE: Eine einfache Browser-Uhr, die die aktuelle Uhrzeit in Adana mit Sekunden zeigt.',
		),
		'ai-companion-trainer' => array(
			'name' => 'TR: Yapay Zeka Yardımcı Eğitmeni | EN: AI Companion Trainer | DE: KI-Begleiter-Trainer',
			'description' => 'TR: Robot yardımcının ne zaman yazması, sorması, doğrulaması veya insandan yardım alması gerektiğini seçerek eğit. EN: Train a robot helper by choosing when it should draft, ask, verify, or get human help. DE: Trainiere einen Roboterhelfer, indem du entscheidest, wann er schreiben, fragen, prüfen oder menschliche Hilfe holen soll.',
		),
		'angle-match' => array(
			'name' => 'TR: Açı Eşleştirme | EN: Angle Match | DE: Winkel-Match',
			'description' => 'TR: Hedef açıyı yakalamak için göstergeyi çevirilen basit bir açı oyunu. EN: A simple angle game where players rotate a pointer to match the target angle. DE: Ein einfaches Winkelspiel, bei dem Spieler einen Zeiger auf den Zielwinkel drehen.',
		),
		'berlin-clock' => array(
			'name' => 'TR: Berlin Saati | EN: Berlin Clock | DE: Berlin-Uhr',
			'description' => 'TR: Berlin, Almanya saatini saniyelerle gösteren basit bir tarayıcı saati. EN: A simple browser clock showing Berlin, Germany time with seconds. DE: Eine einfache Browser-Uhr, die die Berliner Zeit in Deutschland mit Sekunden zeigt.',
		),
		'binary-puzzle' => array(
			'name' => 'TR: İkili Bulmaca | EN: Binary Puzzle | DE: Binärrätsel',
			'description' => 'TR: Satır ve sütun kurallarına göre 0 ve 1 ile ızgarayı doldur. EN: Fill the grid with 0 and 1 using binary puzzle row and column rules. DE: Fülle das Raster nach Zeilen- und Spaltenregeln mit 0 und 1.',
		),
		'breakout-levels' => array(
			'name' => 'TR: Blok Kırma Seviyeleri | EN: Breakout Levels | DE: Breakout-Level',
			'description' => 'TR: 10 seviyeli blok kırma oyunu; her seviyede daha fazla blok vardır ve 15 can ile oynanır. EN: A 10-level breakout game with more blocks on each level and 15 lives to play. DE: Ein Breakout-Spiel mit 10 Leveln, mehr Blöcken pro Level und 15 Leben.',
		),
		'bug-sort-station' => array(
			'name' => 'TR: Böcek Sıralama İstasyonu | EN: Bug Sort Station | DE: Käfer-Sortierstation',
			'description' => 'TR: Kaçmadan önce gelen böcekleri doğru istasyona yönlendirerek sınıflandır. EN: Classify arriving bugs by using the correct station before they escape. DE: Sortiere ankommende Käfer an der richtigen Station, bevor sie entkommen.',
		),
		'car-lane-switch' => array(
			'name' => 'TR: Araba Şerit Değiştirme | EN: Car Lane Switch | DE: Auto-Spurwechsel',
			'description' => 'TR: 5 şeritli, yüksek kamera açılı, ok tuşları, duraklatma ve gerçek turbo düğmesi olan yavaş tempolu sürüş oyunu. EN: A slower lane-switching driving game with 5 lanes, a higher camera view, arrow keys, pause controls, and a real turbo-use button. DE: Ein ruhigeres Spurwechsel-Fahrspiel mit 5 Spuren, höherer Kamera, Pfeiltasten, Pause und echtem Turbo-Knopf.',
		),
		'chess-ai' => array(
			'name' => 'TR: Yapay Zekaya Karşı Satranç | EN: Chess vs AI | DE: Schach gegen KI',
			'description' => 'TR: Çok kolaydan çok zora kadar bilgisayar rakiplere karşı satranç oyna. EN: Play chess against computer opponents from very easy to very hard. DE: Spiele Schach gegen Computergegner von sehr leicht bis sehr schwer.',
		),
		'color-code-rescue' => array(
			'name' => 'TR: Renk Kodu Kurtarma | EN: Color Code Rescue | DE: Farbcode-Rettung',
			'description' => 'TR: Renk sırasını izle ve kodu kurtarmak için aynı sırayı tekrar et. EN: Watch a color sequence and repeat it to save the code. DE: Merke dir eine Farbfolge und wiederhole sie, um den Code zu retten.',
		),
		'cryptogram-decoder' => array(
			'name' => 'TR: Şifreli Yazı Çözücü | EN: Cryptogram Decoder | DE: Kryptogramm-Entschlüssler',
			'description' => 'TR: Harf değiştirme ipuçlarını kullanarak gizli cümleyi çöz. EN: Decode a secret phrase using letter substitution and solve the cryptogram. DE: Entschlüssle einen geheimen Satz mit Buchstabentausch und löse das Kryptogramm.',
		),
		'dama-ai' => array(
			'name' => 'TR: Yapay Zekaya Karşı Dama | EN: Dama vs AI | DE: Dama gegen KI',
			'description' => 'TR: Beyaz taşlarla basit bir yapay zekaya karşı oynanan çocuk dostu Dama oyunu. EN: A kid-friendly Dama board game where you play white against a simple AI. DE: Ein kinderfreundliches Dama-Brettspiel, in dem du mit Weiß gegen eine einfache KI spielst.',
		),
		'echo-cartographer' => array(
			'name' => 'TR: Yankı Haritacısı | EN: Echo Cartographer | DE: Echo-Kartograf',
			'description' => 'TR: Her taramanın harabeleri gösterdiği ama ses avcısı düşmanları çektiği sonar-gizlilik labirenti. EN: A sonar-stealth maze where each scan reveals the ruins but attracts sound-hunting enemies. DE: Ein Sonar-Schleichlabyrinth, in dem jeder Scan Ruinen zeigt, aber geräuschjagende Gegner anlockt.',
		),
		'grid-path-puzzle' => array(
			'name' => 'TR: Izgara Yol Bulmaca | EN: Grid Path Puzzle | DE: Raster-Weg-Rätsel',
			'description' => 'TR: Başlangıçtan hedefe giderken duvarlardan kaçılan basit bir yol bulma oyunu. EN: A simple path-finding game where players move from start to goal while avoiding walls. DE: Ein einfaches Wegfindespiel, bei dem Spieler vom Start zum Ziel gehen und Wände vermeiden.',
		),
		'hizli-tikla' => array(
			'name' => 'TR: Hızlı Tıkla | EN: Fast Click | DE: Schnell Klicken',
			'description' => 'TR: 10 saniye içinde olabildiğince çok tıklamaya çalışılan basit bir oyun. EN: A simple game where players try to click as many times as possible in 10 seconds. DE: Ein einfaches Spiel, bei dem Spieler in 10 Sekunden so oft wie möglich klicken.',
		),
		'kelime-karistirma' => array(
			'name' => 'TR: Kelime Karıştırma | EN: Word Scramble | DE: Wortsalat',
			'description' => 'TR: Çocuklar için Türkçe kelime tahmin etme oyunu; karışık harfleri çöz, ipucu kullan ve puan topla. EN: A Turkish word guessing game for kids; solve scrambled letters, use hints, and collect points. DE: Ein türkisches Wortratespiel für Kinder; löse durcheinandergewürfelte Buchstaben, nutze Hinweise und sammle Punkte.',
		),
		'kids-calculator' => array(
			'name' => 'TR: Çocuklar İçin Basit Hesap Makinesi | EN: Simple Calculator for Kids | DE: Einfacher Rechner für Kinder',
			'description' => 'TR: Toplama, çıkarma, çarpma, bölme, üs alma ve karekök içeren çocuklar için basit hesap oyunu. EN: A simple calculator game for kids with add, subtract, multiply, divide, power, and square root. DE: Ein einfaches Rechenspiel für Kinder mit Addition, Subtraktion, Multiplikation, Division, Potenzen und Quadratwurzel.',
		),
		'lantern-hunt' => array(
			'name' => 'TR: Fener Avı | EN: Lantern Hunt | DE: Laternenjagd',
			'description' => 'TR: Satır ve sütun ipuçlarıyla hücreleri aç ve tüm fener çiftlerini eşleştir. EN: Reveal one cell at a time by row or column hints and match all lantern pairs. DE: Decke mithilfe von Zeilen- oder Spaltenhinweisen Zellen auf und finde alle Laternenpaare.',
		),
		'london-clock' => array(
			'name' => 'TR: Londra Saati | EN: London Clock | DE: London-Uhr',
			'description' => 'TR: Londra saatini saniyelerle gösteren basit bir tarayıcı saati. EN: A simple browser clock showing London time with seconds. DE: Eine einfache Browser-Uhr, die die Londoner Zeit mit Sekunden zeigt.',
		),
		'memory-match-animals' => array(
			'name' => 'TR: Hayvan Hafıza Eşleştirme | EN: Memory Match Animals | DE: Tier-Memory',
			'description' => 'TR: Hayvan çiftleri, deneme sayısı, zamanlayıcı ve yeniden başlatma içeren çocuklar için hafıza kartı oyunu. EN: A memory matching card game for kids with animal pairs, attempts, timer, and restart. DE: Ein Memory-Kartenspiel für Kinder mit Tierpaaren, Versuchen, Timer und Neustart.',
		),
		'micro-garden' => array(
			'name' => 'TR: Mikro Bahçe | EN: Micro Garden | DE: Mikro-Garten',
			'description' => 'TR: Bitkiyi büyütmek için Su, Güneş ve Kompost adımlarını doğru sırayla uygula. EN: Read the sequence and apply Water, Sun, Compost in the right order to grow the plant. DE: Lies die Reihenfolge und nutze Wasser, Sonne und Kompost in der richtigen Ordnung, um die Pflanze wachsen zu lassen.',
		),
		'mini-manager' => array(
			'name' => 'TR: Mini Menajer | EN: Mini Manager | DE: Mini-Manager',
			'description' => 'TR: Sezonlar, transferler, lig tablosu, taktikler, kadro yönetimi, finans ve anlatım içeren büyük futbol menajerliği oyunu. EN: A bigger soccer manager game with seasons, transfers, league table, tactics, squad management, finances, and commentary. DE: Ein größeres Fußballmanager-Spiel mit Saisons, Transfers, Tabelle, Taktik, Kaderverwaltung, Finanzen und Kommentar.',
		),
		'mini-maze-builder' => array(
			'name' => 'TR: Mini Labirent Kurucu | EN: Mini Maze Builder | DE: Mini-Labyrinth-Bauer',
			'description' => 'TR: Duvarlar inşa et ve başlangıçtan bitişe en az bir geçerli yol bırak. EN: Build walls and keep one valid path from start to finish. DE: Baue Wände und lasse mindestens einen gültigen Weg vom Start bis zum Ziel frei.',
		),
		'mini-paint' => array(
			'name' => 'TR: Mini Boyama Stüdyosu | EN: Mini Paint Studio | DE: Mini-Malstudio',
			'description' => 'TR: Şekiller, yazı, seçim, kırpma, çıkartmalar, emoji, çerçeveler, çevirme, döndürme ve klavye kısayolları olan basit bir çizim editörü. EN: A simple Paint-style image editor with shapes, text, selection, crop, stickers, emoji, frames, flip, rotate, and keyboard shortcuts. DE: Ein einfacher Bildeditor im Paint-Stil mit Formen, Text, Auswahl, Zuschneiden, Stickern, Emoji, Rahmen, Spiegeln, Drehen und Tastenkürzeln.',
		),
		'misir-hazine' => array(
			'name' => 'TR: Mısır Hazine Oyunu | EN: Egypt Treasure Game | DE: Ägypten-Schatzspiel',
			'description' => 'TR: Piramitte gizli hazineyi bulmaya çalışılan Mısır temalı oyun. EN: An Egypt-themed game where players try to find the hidden treasure inside the pyramid. DE: Ein Ägypten-Spiel, in dem Spieler den versteckten Schatz in der Pyramide finden.',
		),
		'mirror-axiom' => array(
			'name' => 'TR: Ayna Aksiyomu | EN: Mirror Axiom | DE: Spiegel-Axiom',
			'description' => 'TR: Her tıklamanın iki eksende de yansıdığı zor bir simetri bulmacası. EN: A hard symmetry puzzle where every click reflects across both axes. DE: Ein schweres Symmetrie-Rätsel, bei dem jeder Klick über beide Achsen gespiegelt wird.',
		),
		'mirror-maze' => array(
			'name' => 'TR: Ayna Labirenti | EN: Mirror Maze | DE: Spiegel-Labyrinth',
			'description' => 'TR: Aynaları çevirerek lazer ışığını hedefe yönlendirdiğin bulmaca oyunu. EN: A puzzle game where players rotate mirrors to guide a laser beam to the target. DE: Ein Rätselspiel, in dem Spieler Spiegel drehen, um einen Laserstrahl zum Ziel zu führen.',
		),
		'munich-clock' => array(
			'name' => 'TR: Münih Saati | EN: Munich Clock | DE: München-Uhr',
			'description' => 'TR: Münih, Almanya saatini saniyelerle gösteren basit bir tarayıcı saati. EN: A simple browser clock showing Munich, Germany time with seconds. DE: Eine einfache Browser-Uhr, die die Münchner Zeit in Deutschland mit Sekunden zeigt.',
		),
		'orbit-match' => array(
			'name' => 'TR: Yörünge Eşleştirme | EN: Orbit Match | DE: Orbit-Match',
			'description' => 'TR: Her yörünge sembolünü hedef desene uyacak şekilde döndür. EN: Rotate each orbit symbol to align with the target pattern. DE: Drehe jedes Orbit-Symbol, bis es zum Zielmuster passt.',
		),
		'nova-crafter-challenge' => array(
			'name' => 'TR: Nova Üretici Mücadelesi | EN: Nova Crafter Challenge | DE: Nova-Bauer-Herausforderung',
			'description' => 'TR: Değişen parçaları üret ve mücadelede puanını yükselt. EN: Craft shifting parts and build your score through the challenge. DE: Baue wechselnde Teile und erhöhe deine Punktzahl in der Herausforderung.',
		),
		'nova-pilot-drift' => array(
			'name' => 'TR: Nova Pilot Drift | EN: Nova Pilot Drift | DE: Nova-Pilot-Drift',
			'description' => 'TR: Kontrollerin yavaşça kayarken sürüklenen asteroitlerin arasından pilotluk yap. EN: Pilot through drifting asteroids while your controls subtly desync. DE: Steuere durch driftende Asteroiden, während deine Steuerung leicht aus dem Takt gerät.',
		),
		'nova-signal-shift' => array(
			'name' => 'TR: Nova Sinyal Kaydırma | EN: Nova Signal Shift | DE: Nova-Signalwechsel',
			'description' => 'TR: Değişen Nova sinyallerini doğru sıraya getir. EN: Shift changing Nova signals into the right order. DE: Bringe wechselnde Nova-Signale in die richtige Reihenfolge.',
		),
		'orbit-architect-recall' => array(
			'name' => 'TR: Yörünge Mimarı Hafıza | EN: Orbit Architect Recall | DE: Orbit-Architekt-Erinnerung',
			'description' => 'TR: Yörünge planlarını hatırla ve mimari deseni yeniden kur. EN: Recall orbit plans and rebuild the architecture pattern. DE: Merke dir Orbit-Pläne und baue das Architekturmuster wieder auf.',
		),
		'orbit-builder-recall' => array(
			'name' => 'TR: Yörünge Kurucu Hafıza | EN: Orbit Builder Recall | DE: Orbit-Bauer-Erinnerung',
			'description' => 'TR: Yörünge parçalarının sırasını hatırla ve sistemi yeniden kur. EN: Recall the order of orbit parts and rebuild the system. DE: Merke dir die Reihenfolge der Orbit-Teile und baue das System wieder auf.',
		),
		'orbit-decoder-memory' => array(
			'name' => 'TR: Yörünge Kod Çözücü Hafıza | EN: Orbit Decoder Memory | DE: Orbit-Decoder-Memory',
			'description' => 'TR: Yörünge kodlarını hafızanda tut ve doğru diziyi çöz. EN: Memorize orbit codes and decode the correct sequence. DE: Merke dir Orbit-Codes und entschlüssele die richtige Folge.',
		),
		'orbit-runner-sprint' => array(
			'name' => 'TR: Yörünge Koşucusu Sprint | EN: Orbit Runner Sprint | DE: Orbit-Läufer-Sprint',
			'description' => 'TR: Yörünge engellerinin arasından hızlıca koş ve hedefe ulaş. EN: Sprint through orbit obstacles and reach the target. DE: Sprinte durch Orbit-Hindernisse und erreiche das Ziel.',
		),
		'orbit-signal-rescue' => array(
			'name' => 'TR: Yörünge Sinyal Kurtarma | EN: Orbit Signal Rescue | DE: Orbit-Signalrettung',
			'description' => 'TR: Yörünge sinyallerini yeniden yönlendir ve işaret pilotlarını kurtar. EN: Reroute orbit signals and rescue beacon pilots mid-flight. DE: Leite Orbit-Signale um und rette Leuchtfeuer-Piloten im Flug.',
		),
		'paris-clock' => array(
			'name' => 'TR: Paris Saati | EN: Paris Clock | DE: Paris-Uhr',
			'description' => 'TR: Paris saatini saniyelerle gösteren basit bir tarayıcı saati. EN: A simple browser clock showing Paris time with seconds. DE: Eine einfache Browser-Uhr, die die Pariser Zeit mit Sekunden zeigt.',
		),
		'pipe-connect' => array(
			'name' => 'TR: Boru Bağlantısı | EN: Pipe Connect | DE: Rohrverbindung',
			'description' => 'TR: Kaynak ve hedef arasında boruları çevirerek bağlantı kurulan basit bir bulmaca oyunu. EN: A simple puzzle game where players rotate pipes to connect the source and the target. DE: Ein einfaches Rätselspiel, in dem Spieler Rohre drehen, um Quelle und Ziel zu verbinden.',
		),
		'puzzle-creator-pro' => array(
			'name' => 'TR: Bulmaca Oluşturucu Pro | EN: Puzzle Creator Pro | DE: Puzzle-Ersteller Pro',
			'description' => 'TR: Editör hesabıyla bulmacalar oluştur ve sistem genelinde paylaş. EN: Create puzzles and share them system-wide from an editor account. DE: Erstelle mit einem Editor-Konto Rätsel und teile sie im ganzen System.',
		),
		'rain-collector' => array(
			'name' => 'TR: Yağmur Toplayıcı | EN: Rain Collector | DE: Regen-Sammler',
			'description' => 'TR: Geçerli hedefle eşleşen düşen harfleri topla. EN: Collect falling letters that match the current target. DE: Sammle fallende Buchstaben, die zum aktuellen Ziel passen.',
		),
		'robot-designer' => array(
			'name' => 'TR: Robot Tasarımcısı | EN: Robot Designer | DE: Roboter-Designer',
			'description' => 'TR: Bir robot tasarla ve özelliklerini farklı görevlere uygun hale getir. EN: Build a robot and match its stats to different missions. DE: Baue einen Roboter und passe seine Werte an verschiedene Missionen an.',
		),
		'rock-paper-scissors' => array(
			'name' => 'TR: Taş Kağıt Makas | EN: Rock Paper Scissors | DE: Schere Stein Papier',
			'description' => 'TR: Puan takibi ve yeniden başlatma içeren çocuklar için basit Taş Kağıt Makas oyunu. EN: A simple rock paper scissors game for kids with score tracking and restart. DE: Ein einfaches Schere-Stein-Papier-Spiel für Kinder mit Punktestand und Neustart.',
		),
		'roster-1000' => array(
			'name' => 'TR: 1000 Karakter Arenası | EN: Roster 1000 | DE: Roster 1000',
			'description' => 'TR: 1000 satın alınabilir karakter, her seviyede zorlaşan yapay zeka, dalga başına daha çok düşman ve her galibiyette 50 coin içeren sonsuz arena oyunu. EN: An endless arena game with 1000 buyable characters, harder AI every level, more enemies per wave, and 50 coins for every win. DE: Ein endloses Arenaspiel mit 1000 kaufbaren Figuren, schwererer KI pro Level, mehr Gegnern pro Welle und 50 Münzen für jeden Sieg.',
		),
		'rule-guess-puzzle' => array(
			'name' => 'TR: Kural Tahmin Bulmacası | EN: Rule Guess Puzzle | DE: Regel-Rätsel',
			'description' => 'TR: Sayıları deneyip geri bildirimi izleyerek gizli kuralı keşfettiğin bir bulmaca oyunu. EN: A hidden-rule puzzle game where players test numbers and discover the secret rule by observing feedback. DE: Ein Rätselspiel mit versteckter Regel, bei dem Spieler Zahlen testen und durch Rückmeldungen die geheime Regel entdecken.',
		),
		'rule-switch-rush' => array(
			'name' => 'TR: Kural Değiştirme Yarışı | EN: Rule Switch Rush | DE: Regelwechsel-Rennen',
			'description' => 'TR: Kural değişirken oyuncuların doğru yönü seçmesi gereken hızlı refleks ve düşünme oyunu. EN: A fast reflex and thinking game where the rule changes and players must choose the correct direction. DE: Ein schnelles Reaktions- und Denkspiel, bei dem sich die Regel ändert und Spieler die richtige Richtung wählen.',
		),
		'shadow-path' => array(
			'name' => 'TR: Gölge Yolu | EN: Shadow Path | DE: Schattenpfad',
			'description' => 'TR: Gizli yolu izle ve hücreleri doğru sırayla tekrar et. EN: Watch a hidden path and repeat the cells in order. DE: Merke dir einen versteckten Pfad und wiederhole die Felder in der richtigen Reihenfolge.',
		),
		'shop-builder' => array(
			'name' => 'TR: Dükkan Kurucu | EN: Shop Builder | DE: Laden-Bauer',
			'description' => 'TR: Satış yaparak para kazanılan ve yükseltmelerle büyüyen basit bir dükkan kurma oyunu. EN: A simple shop-building game where players earn money by selling items and grow with upgrades. DE: Ein einfaches Laden-Aufbauspiel, in dem Spieler durch Verkäufe Geld verdienen und mit Upgrades wachsen.',
		),
		'silent-simon-says' => array(
			'name' => 'TR: Sessiz Simon Diyor | EN: Silent Simon Says | DE: Stilles Simon Sagt',
			'description' => 'TR: Her komutta yalnızca zıt hareketi takip et. EN: Follow only the opposite action for each command. DE: Folge bei jedem Befehl nur der gegenteiligen Aktion.',
		),
		'soccer-match-ai' => array(
			'name' => 'TR: Yapay Zeka Futbol Maçı | EN: Soccer Match AI | DE: KI-Fußballspiel',
			'description' => 'TR: Tüm oyuncuların yapay zeka olduğu, kornerlerin çalıştığı ve doğrudan kaleye şut atabildiğin 5 dakikalık futbol maçı. EN: A 5-minute soccer match where all players are AI, blue corner kicks work, and you can shoot directly at goal. DE: Ein 5-minütiges Fußballspiel, in dem alle Spieler KI sind, blaue Ecken funktionieren und du direkt aufs Tor schießen kannst.',
		),
		'sound-pattern-builder' => array(
			'name' => 'TR: Ses Deseni Kurucu | EN: Sound Pattern Builder | DE: Klangmuster-Bauer',
			'description' => 'TR: Bir ses desenini dinle ve hayvanlara dokunarak aynı sırayı tekrar et. EN: Listen to a sound pattern and repeat it by tapping animals. DE: Höre ein Klangmuster und wiederhole es, indem du Tiere antippst.',
		),
		'sound-rule-rush' => array(
			'name' => 'TR: Ses Kuralı Yarışı | EN: Sound Rule Rush | DE: Klangregel-Rennen',
			'description' => 'TR: Kurallar değişirken sesleri doğru aileye ayırdığın hızlı refleks ve düşünme oyunu. EN: A fast reflex and thinking game where players sort sounds into the correct family as the rules change. DE: Ein schnelles Reaktions- und Denkspiel, bei dem Spieler Klänge bei wechselnden Regeln der richtigen Familie zuordnen.',
		),
		'sudoku' => array(
			'name' => 'TR: Sudoku | EN: Sudoku | DE: Sudoku',
			'description' => 'TR: Kolay, orta ve zor tahtaları olan klasik 9x9 Sudoku bulmacası. EN: A classic 9x9 Sudoku puzzle with easy, medium, and hard boards. DE: Ein klassisches 9x9-Sudoku mit leichten, mittleren und schweren Brettern.',
		),
		'territory-capture' => array(
			'name' => 'TR: Bölge Ele Geçirme | EN: Territory Capture | DE: Gebiet Erobern',
			'description' => 'TR: Izgarada en çok bölgeyi kontrol etmek için yapay zekayla yarıştığın sıra tabanlı strateji oyunu. EN: A turn-based strategy game where you compete with AI to control the most territory on a grid. DE: Ein rundenbasiertes Strategiespiel, in dem du gegen KI um die meisten Gebiete auf einem Raster kämpfst.',
		),
		'territory-fill' => array(
			'name' => 'TR: Bölge Doldurma | EN: Territory Fill | DE: Gebiet Füllen',
			'description' => 'TR: Hamleler bitmeden en geniş alanı almak için oynanan ızgara kontrol oyunu. EN: A grid control game where players claim the most area before moves run out. DE: Ein Raster-Kontrollspiel, bei dem Spieler vor Ablauf der Züge die größte Fläche sichern.',
		),
		'the-46th-rule' => array(
			'name' => 'TR: 46. Kural | EN: The 46th Rule | DE: Die 46. Regel',
			'description' => 'TR: Oyuncunun sembol anahtarlarını test edip mantığı kanıtladığı çok zor gizli kural çıkarım oyunu. EN: A very hard hidden-rule deduction game where the player tests symbol keys and proves the logic. DE: Ein sehr schweres Deduktionsspiel mit versteckter Regel, in dem der Spieler Symbolschlüssel testet und die Logik beweist.',
		),
		'time-loop-runner' => array(
			'name' => 'TR: Zaman Döngüsü Koşucusu | EN: Time Loop Runner | DE: Zeitschleifen-Läufer',
			'description' => 'TR: 5 adımlık diziyi izle ve çarpmadan aynı hareketleri tekrar et. EN: Watch a 5 step sequence and replay the moves without crashing. DE: Merke dir eine Folge aus 5 Schritten und wiederhole die Bewegungen ohne Zusammenstoß.',
		),
		'time-traveler-puzzle' => array(
			'name' => 'TR: Zaman Yolcusu Bulmacası | EN: Time Traveler Puzzle | DE: Zeitreise-Rätsel',
			'description' => 'TR: Bölümün geçmiş ve gelecek sürümleri arasında geçiş yaparak mantık bulmacalarını çöz. EN: Solve logic puzzles by switching between past and future versions of the level. DE: Löse Logikrätsel, indem du zwischen Vergangenheits- und Zukunftsversionen des Levels wechselst.',
		),
		'tr-search-launcher' => array(
			'name' => 'TR: Türkçe Arama Başlatıcı | EN: TR Search Launcher | DE: Türkischer Suchstarter',
			'description' => 'TR: Ürün aramalarını birden fazla sitede hızlıca açmak için tarayıcı tabanlı Türkçe alışveriş arama başlatıcısı. EN: A browser-based Turkish shopping search launcher for quickly opening product searches across multiple sites. DE: Ein browserbasierter türkischer Einkaufs-Suchstarter, um Produktsuchen schnell auf mehreren Seiten zu öffnen.',
		),
		'wisconsin-clock' => array(
			'name' => 'TR: Wisconsin Saati | EN: Wisconsin Clock | DE: Wisconsin-Uhr',
			'description' => 'TR: Wisconsin saatini saniyelerle gösteren basit bir tarayıcı saati. EN: A simple browser clock showing Wisconsin time with seconds. DE: Eine einfache Browser-Uhr, die die Wisconsin-Zeit mit Sekunden zeigt.',
		),
		'word-balloon-pop' => array(
			'name' => 'TR: Kelime Balonu Patlat | EN: Word Balloon Pop | DE: Wortballon-Platzen',
			'description' => 'TR: Süre dolmadan doğru cevabı taşıyan balonu bul ve patlat. EN: Find and pop the balloon with the correct answer before time runs out. DE: Finde und platze den Ballon mit der richtigen Antwort, bevor die Zeit abläuft.',
		),
		'puzzle-crafter-drift' => array(
			'name' => 'TR: Bulmaca Ustası Drift | EN: Puzzle Crafter Drift | DE: Puzzle-Bauer Drift',
			'description' => 'TR: Değişen bulmaca parçaları oluştur ve puanını büyütmeye devam et. EN: Craft shifting puzzle tiles and keep your score growing. DE: Erstelle wechselnde Puzzle-Kacheln und lasse deine Punktzahl weiter wachsen.',
		),
		'puzzle-signal-vault' => array(
			'name' => 'TR: Bulmaca Sinyal Kasası | EN: Puzzle Signal Vault | DE: Puzzle-Signal-Tresor',
			'description' => 'TR: Renk değiştiren sinyalleri çözerek kasa kapılarını sırayla aç. EN: Decode color-shift signals to open vault doors in sequence. DE: Entschlüssle farbwechselnde Signale, um Tresortüren der Reihe nach zu öffnen.',
		),
		'balloon-tower-climb' => array(
			'name' => 'TR: Balon Kulesine Tırmanış | EN: Balloon Tower Climb | DE: Ballonturm-Aufstieg',
			'description' => 'TR: Yükselme balonlarını toplayarak kulede yukarı çık. EN: Float up a tower collecting lift balloons. DE: Schwebe einen Turm hinauf und sammle Aufstiegsballons.',
		),
		'castle-siege-commander' => array(
			'name' => 'TR: Kale Kuşatması Komutanı | EN: Castle Siege Commander | DE: Burgenbelagerungs-Kommandant',
			'description' => 'TR: Kale kuşatması sırasında komuta bayraklarını topla. EN: Collect command flags during a castle siege. DE: Sammle Kommandoflaggen während einer Burgenbelagerung.',
		),
		'candy-factory-chaos' => array(
			'name' => 'TR: Şeker Fabrikası Karmaşası | EN: Candy Factory Chaos | DE: Süßigkeitenfabrik-Chaos',
			'description' => 'TR: Karışık bir fabrikada şeker partilerini topla. EN: Collect candy batches in a chaotic factory. DE: Sammle Süßigkeitenladungen in einer chaotischen Fabrik.',
		),
		'castle-trap-designer' => array(
			'name' => 'TR: Kale Tuzak Tasarımcısı | EN: Castle Trap Designer | DE: Burgfallen-Designer',
			'description' => 'TR: Akıllı kale tuzaklarını tamamlamak için dişlileri topla. EN: Collect gears to finish clever castle traps. DE: Sammle Zahnräder, um clevere Burgfallen fertigzustellen.',
		),
		'giant-bug-survival' => array(
			'name' => 'TR: Dev Böcek Hayatta Kalma | EN: Giant Bug Survival | DE: Rieseninsekt-Überleben',
			'description' => 'TR: Her şeyin devasa olduğu bir bahçede hayatta kal. EN: Survive in a backyard where everything is huge. DE: Überlebe in einem Garten, in dem alles riesig ist.',
		),
		'haunted-library-mystery' => array(
			'name' => 'TR: Perili Kütüphane Gizemi | EN: Haunted Library Mystery | DE: Geheimnis der Spukbibliothek',
			'description' => 'TR: Perili bir kütüphanede parlayan ipuçlarını bul. EN: Find glowing clues in a spooky library. DE: Finde leuchtende Hinweise in einer unheimlichen Bibliothek.',
		),
		'ice-mountain-snowboard' => array(
			'name' => 'TR: Buz Dağı Snowboard | EN: Ice Mountain Snowboard | DE: Eisberg-Snowboard',
			'description' => 'TR: Bayrakları toplayarak buzlu dağdan snowboard ile kay. EN: Snowboard down an icy mountain collecting flags. DE: Fahre mit dem Snowboard einen eisigen Berg hinab und sammle Flaggen.',
		),
		'invisible-platform-challenge' => array(
			'name' => 'TR: Görünmez Platform Mücadelesi | EN: Invisible Platform Challenge | DE: Unsichtbare-Plattform-Herausforderung',
			'description' => 'TR: Parıltı işaretlerini toplayarak gizli platformları bul. EN: Find hidden platforms by collecting shimmer marks. DE: Finde versteckte Plattformen, indem du Schimmerzeichen sammelst.',
		),
		'laser-mirror-puzzle' => array(
			'name' => 'TR: Lazer Ayna Bulmacası | EN: Laser Mirror Puzzle | DE: Laser-Spiegel-Rätsel',
			'description' => 'TR: Ayna parçalarını topla ve lazer ışınlarından kaç. EN: Collect mirror chips and avoid laser beams. DE: Sammle Spiegelteile und weiche Laserstrahlen aus.',
		),
		'arslan-country-quiz' => array(
			'name' => 'TR: Ülke 100 Soru | EN: Country Quiz Coins | DE: Länderquiz-Münzen',
			'description' => 'TR: Bir ülke adı yaz ve coin kazanmak ya da kaybetmek için 100 quiz sorusu cevapla. EN: Write a country name and answer 100 quiz questions to win or lose coins. DE: Schreibe einen Ländernamen und beantworte 100 Quizfragen, um Münzen zu gewinnen oder zu verlieren.',
		),
	);

	return isset($items[$slug]) ? $items[$slug] : null;
}

function zo_get_fallback_multilingual_game_metadata($module) {
	$name = !empty($module['name']) && is_string($module['name']) ? trim($module['name']) : '';
	$description = !empty($module['description']) && is_string($module['description']) ? trim(wp_strip_all_tags($module['description'])) : '';

	if ($name === '') {
		return null;
	}

	$metadata = array(
		'name' => sprintf('TR: %1$s oyunu | EN: %1$s | DE: %1$s Spiel', $name),
	);

	if ($description !== '') {
		$metadata['description'] = sprintf(
			'TR: %1$s, tarayıcıda oynanan bir oyundur. EN: %2$s DE: %1$s ist ein Browserspiel.',
			$name,
			$description
		);
	}

	return $metadata;
}

function zo_get_metadata_language_label($lang) {
	$labels = array(
		'tr' => 'TR:',
		'en' => 'EN:',
		'de' => 'DE:',
		'fr' => 'FR:',
		'es-mx' => 'ES-MX:',
		'es-es' => 'ES-ES:',
	);

	return isset($labels[$lang]) ? $labels[$lang] : strtoupper((string) $lang) . ':';
}

function zo_text_has_localized_part($text, $lang) {
	$text = is_string($text) ? $text : '';
	$lang = is_string($lang) ? strtolower($lang) : '';

	if ($text === '' || $lang === '') {
		return false;
	}

	return stripos($text, zo_get_metadata_language_label($lang)) !== false;
}

function zo_append_missing_localized_parts($text, $fallback, $languages) {
	$text = is_string($text) ? trim($text) : '';
	$fallback = is_string($fallback) ? trim($fallback) : '';

	if ($text === '' || $fallback === '') {
		return $text;
	}

	foreach ($languages as $lang => $label) {
		if (zo_text_has_localized_part($text, $lang) || !zo_text_has_localized_part($fallback, $lang)) {
			continue;
		}

		$value = zo_get_localized_text($fallback, $lang);
		if ($value !== '') {
			$text .= ' | ' . zo_get_metadata_language_label($lang) . ' ' . $value;
		}
	}

	return $text;
}

function zo_get_fallback_game_title_for_language($title, $lang) {
	$title = trim(wp_strip_all_tags((string) $title));
	$lang = is_string($lang) ? strtolower($lang) : 'en';

	if ($title === '') {
		return '';
	}

	$exact = array(
		'Hangman' => array(
			'fr' => 'Le pendu',
			'es-mx' => 'Ahorcado',
			'es-es' => 'Ahorcado',
		),
		'Angle Match' => array(
			'tr' => 'Açı Eşleştir',
			'en' => 'Angle Match',
			'de' => 'Winkel Zuordnen',
			'fr' => 'Associer les angles',
			'es-mx' => 'Relacionar ángulos',
			'es-es' => 'Relacionar ángulos',
		),
		'AI Companion Trainer' => array(
			'fr' => 'Entraîneur de compagnon IA',
			'es-mx' => 'Entrenador de compañero IA',
			'es-es' => 'Entrenador de compañero IA',
		),
		'Binary Puzzle' => array(
			'fr' => 'Puzzle binaire',
			'es-mx' => 'Rompecabezas binario',
			'es-es' => 'Puzle binario',
		),
		'Breakout Levels' => array(
			'fr' => 'Niveaux de casse-briques',
			'es-mx' => 'Niveles de rompebloques',
			'es-es' => 'Niveles de rompebloques',
		),
		'Bug Sort Station' => array(
			'fr' => 'Station de tri des insectes',
			'es-mx' => 'Estación para ordenar insectos',
			'es-es' => 'Estación de clasificación de insectos',
		),
		'Car Lane Switch' => array(
			'fr' => 'Changement de voie en voiture',
			'es-mx' => 'Cambio de carril',
			'es-es' => 'Cambio de carril',
		),
		'Chess vs AI' => array(
			'fr' => 'Échecs contre IA',
			'es-mx' => 'Ajedrez contra IA',
			'es-es' => 'Ajedrez contra IA',
		),
		'Color Code Rescue' => array(
			'fr' => 'Sauvetage du code couleur',
			'es-mx' => 'Rescate del código de color',
			'es-es' => 'Rescate del código de color',
		),
		'Cryptogram Decoder' => array(
			'fr' => 'Décodeur de cryptogrammes',
			'es-mx' => 'Decodificador de criptogramas',
			'es-es' => 'Decodificador de criptogramas',
		),
		'Dama vs AI' => array(
			'fr' => 'Dama contre IA',
			'es-mx' => 'Dama contra IA',
			'es-es' => 'Dama contra IA',
		),
		'Echo Cartographer' => array(
			'fr' => 'Cartographe d’échos',
			'es-mx' => 'Cartógrafo de ecos',
			'es-es' => 'Cartógrafo de ecos',
		),
		'Grid Path Puzzle' => array(
			'fr' => 'Puzzle de chemin sur grille',
			'es-mx' => 'Rompecabezas de camino en cuadrícula',
			'es-es' => 'Puzle de camino en cuadrícula',
		),
		'Fast Click' => array(
			'fr' => 'Clic rapide',
			'es-mx' => 'Clic rápido',
			'es-es' => 'Clic rápido',
		),
		'Word Scramble' => array(
			'fr' => 'Mots mélangés',
			'es-mx' => 'Palabras revueltas',
			'es-es' => 'Palabras mezcladas',
		),
		'Simple Calculator for Kids' => array(
			'fr' => 'Calculatrice simple pour enfants',
			'es-mx' => 'Calculadora simple para niños',
			'es-es' => 'Calculadora sencilla para niños',
		),
		'Lantern Hunt' => array(
			'fr' => 'Chasse aux lanternes',
			'es-mx' => 'Caza de linternas',
			'es-es' => 'Caza de faroles',
		),
		'Memory Match Animals' => array(
			'fr' => 'Mémoire animaux',
			'es-mx' => 'Memoria de animales',
			'es-es' => 'Memoria de animales',
		),
		'Micro Garden' => array(
			'fr' => 'Micro jardin',
			'es-mx' => 'Micro jardín',
			'es-es' => 'Microjardín',
		),
		'Mini Manager' => array(
			'fr' => 'Mini manager',
			'es-mx' => 'Mini mánager',
			'es-es' => 'Mini mánager',
		),
		'Mini Maze Builder' => array(
			'fr' => 'Mini constructeur de labyrinthe',
			'es-mx' => 'Mini constructor de laberintos',
			'es-es' => 'Mini constructor de laberintos',
		),
		'Mini Paint Studio' => array(
			'fr' => 'Mini studio de dessin',
			'es-mx' => 'Mini estudio de dibujo',
			'es-es' => 'Mini estudio de pintura',
		),
		'Egypt Treasure Game' => array(
			'fr' => 'Jeu du trésor d’Égypte',
			'es-mx' => 'Juego del tesoro de Egipto',
			'es-es' => 'Juego del tesoro de Egipto',
		),
		'Mirror Axiom' => array(
			'fr' => 'Axiome du miroir',
			'es-mx' => 'Axioma del espejo',
			'es-es' => 'Axioma del espejo',
		),
		'Mirror Maze' => array(
			'fr' => 'Labyrinthe de miroirs',
			'es-mx' => 'Laberinto de espejos',
			'es-es' => 'Laberinto de espejos',
		),
		'Orbit Match' => array(
			'fr' => 'Associer les orbites',
			'es-mx' => 'Relacionar órbitas',
			'es-es' => 'Relacionar órbitas',
		),
		'Nova Crafter Challenge' => array(
			'fr' => 'Défi du créateur Nova',
			'es-mx' => 'Desafío del creador Nova',
			'es-es' => 'Desafío del creador Nova',
		),
		'Nova Pilot Drift' => array(
			'fr' => 'Dérive du pilote Nova',
			'es-mx' => 'Deriva del piloto Nova',
			'es-es' => 'Deriva del piloto Nova',
		),
		'Nova Signal Shift' => array(
			'fr' => 'Décalage du signal Nova',
			'es-mx' => 'Cambio de señal Nova',
			'es-es' => 'Cambio de señal Nova',
		),
		'Orbit Architect Recall' => array(
			'fr' => 'Mémoire de l’architecte orbital',
			'es-mx' => 'Memoria del arquitecto orbital',
			'es-es' => 'Memoria del arquitecto orbital',
		),
		'Orbit Builder Recall' => array(
			'fr' => 'Mémoire du constructeur orbital',
			'es-mx' => 'Memoria del constructor orbital',
			'es-es' => 'Memoria del constructor orbital',
		),
		'Orbit Decoder Memory' => array(
			'fr' => 'Mémoire du décodeur orbital',
			'es-mx' => 'Memoria del decodificador orbital',
			'es-es' => 'Memoria del decodificador orbital',
		),
		'Orbit Runner Sprint' => array(
			'fr' => 'Sprint du coureur orbital',
			'es-mx' => 'Sprint del corredor orbital',
			'es-es' => 'Sprint del corredor orbital',
		),
		'Orbit Signal Rescue' => array(
			'fr' => 'Sauvetage du signal orbital',
			'es-mx' => 'Rescate de señal orbital',
			'es-es' => 'Rescate de señal orbital',
		),
		'Pipe Connect' => array(
			'fr' => 'Connexion de tuyaux',
			'es-mx' => 'Conectar tuberías',
			'es-es' => 'Conectar tuberías',
		),
		'Puzzle Creator Pro' => array(
			'fr' => 'Créateur de puzzles Pro',
			'es-mx' => 'Creador de rompecabezas Pro',
			'es-es' => 'Creador de puzles Pro',
		),
		'Rain Collector' => array(
			'fr' => 'Collecteur de pluie',
			'es-mx' => 'Recolector de lluvia',
			'es-es' => 'Recolector de lluvia',
		),
		'Robot Designer' => array(
			'fr' => 'Concepteur de robots',
			'es-mx' => 'Diseñador de robots',
			'es-es' => 'Diseñador de robots',
		),
		'Rock Paper Scissors' => array(
			'fr' => 'Pierre feuille ciseaux',
			'es-mx' => 'Piedra papel tijeras',
			'es-es' => 'Piedra papel tijeras',
		),
		'Roster 1000' => array(
			'fr' => 'Roster 1000',
			'es-mx' => 'Roster 1000',
			'es-es' => 'Roster 1000',
		),
		'Rule Guess Puzzle' => array(
			'fr' => 'Puzzle de règle cachée',
			'es-mx' => 'Rompecabezas de regla oculta',
			'es-es' => 'Puzle de regla oculta',
		),
		'Rule Switch Rush' => array(
			'fr' => 'Course aux règles changeantes',
			'es-mx' => 'Carrera de reglas cambiantes',
			'es-es' => 'Carrera de reglas cambiantes',
		),
		'Shadow Path' => array(
			'fr' => 'Chemin d’ombre',
			'es-mx' => 'Camino de sombra',
			'es-es' => 'Camino de sombra',
		),
		'Shop Builder' => array(
			'fr' => 'Constructeur de boutique',
			'es-mx' => 'Constructor de tienda',
			'es-es' => 'Constructor de tienda',
		),
		'Silent Simon Says' => array(
			'fr' => 'Simon dit silencieux',
			'es-mx' => 'Simón dice silencioso',
			'es-es' => 'Simón dice silencioso',
		),
		'Soccer Match AI' => array(
			'fr' => 'Match de football IA',
			'es-mx' => 'Partido de futbol IA',
			'es-es' => 'Partido de fútbol IA',
		),
		'Sound Pattern Builder' => array(
			'fr' => 'Constructeur de motifs sonores',
			'es-mx' => 'Constructor de patrones de sonido',
			'es-es' => 'Constructor de patrones de sonido',
		),
		'Sound Rule Rush' => array(
			'fr' => 'Course aux règles sonores',
			'es-mx' => 'Carrera de reglas sonoras',
			'es-es' => 'Carrera de reglas sonoras',
		),
		'Sudoku' => array(
			'fr' => 'Sudoku',
			'es-mx' => 'Sudoku',
			'es-es' => 'Sudoku',
		),
		'Territory Capture' => array(
			'fr' => 'Capture de territoire',
			'es-mx' => 'Captura de territorio',
			'es-es' => 'Captura de territorio',
		),
		'Territory Fill' => array(
			'fr' => 'Remplissage de territoire',
			'es-mx' => 'Rellenar territorio',
			'es-es' => 'Rellenar territorio',
		),
		'The 46th Rule' => array(
			'fr' => 'La 46e règle',
			'es-mx' => 'La regla 46',
			'es-es' => 'La regla 46',
		),
		'Time Loop Runner' => array(
			'fr' => 'Coureur de boucle temporelle',
			'es-mx' => 'Corredor del bucle temporal',
			'es-es' => 'Corredor del bucle temporal',
		),
		'Time Traveler Puzzle' => array(
			'fr' => 'Puzzle du voyageur temporel',
			'es-mx' => 'Rompecabezas del viajero del tiempo',
			'es-es' => 'Puzle del viajero del tiempo',
		),
		'TR Search Launcher' => array(
			'fr' => 'Lanceur de recherche turque',
			'es-mx' => 'Lanzador de búsqueda turca',
			'es-es' => 'Lanzador de búsqueda turca',
		),
		'Word Balloon Pop' => array(
			'fr' => 'Éclate les ballons de mots',
			'es-mx' => 'Revienta globos de palabras',
			'es-es' => 'Revienta globos de palabras',
		),
		'Puzzle Crafter Drift' => array(
			'fr' => 'Dérive du créateur de puzzles',
			'es-mx' => 'Deriva del creador de rompecabezas',
			'es-es' => 'Deriva del creador de puzles',
		),
		'Puzzle Signal Vault' => array(
			'fr' => 'Coffre des signaux puzzle',
			'es-mx' => 'Bóveda de señales del rompecabezas',
			'es-es' => 'Cámara de señales del puzle',
		),
		'Balloon Tower Climb' => array(
			'fr' => 'Ascension de la tour de ballons',
			'es-mx' => 'Subida a la torre de globos',
			'es-es' => 'Subida a la torre de globos',
		),
		'Castle Siege Commander' => array(
			'fr' => 'Commandant du siège du château',
			'es-mx' => 'Comandante del asedio al castillo',
			'es-es' => 'Comandante del asedio al castillo',
		),
		'Candy Factory Chaos' => array(
			'fr' => 'Chaos à l’usine de bonbons',
			'es-mx' => 'Caos en la fábrica de dulces',
			'es-es' => 'Caos en la fábrica de caramelos',
		),
		'Castle Trap Designer' => array(
			'fr' => 'Concepteur de pièges de château',
			'es-mx' => 'Diseñador de trampas del castillo',
			'es-es' => 'Diseñador de trampas del castillo',
		),
		'Giant Bug Survival' => array(
			'fr' => 'Survie aux insectes géants',
			'es-mx' => 'Supervivencia con insectos gigantes',
			'es-es' => 'Supervivencia con insectos gigantes',
		),
		'Haunted Library Mystery' => array(
			'fr' => 'Mystère de la bibliothèque hantée',
			'es-mx' => 'Misterio de la biblioteca embrujada',
			'es-es' => 'Misterio de la biblioteca encantada',
		),
		'Ice Mountain Snowboard' => array(
			'fr' => 'Snowboard sur montagne glacée',
			'es-mx' => 'Snowboard en la montaña helada',
			'es-es' => 'Snowboard en la montaña helada',
		),
		'Invisible Platform Challenge' => array(
			'fr' => 'Défi des plateformes invisibles',
			'es-mx' => 'Desafío de plataformas invisibles',
			'es-es' => 'Desafío de plataformas invisibles',
		),
		'Laser Mirror Puzzle' => array(
			'fr' => 'Puzzle de miroirs laser',
			'es-mx' => 'Rompecabezas de espejos láser',
			'es-es' => 'Puzle de espejos láser',
		),
		'Country Quiz Coins' => array(
			'fr' => 'Quiz des pays et pièces',
			'es-mx' => 'Quiz de países y monedas',
			'es-es' => 'Quiz de países y monedas',
		),
	);

	if (isset($exact[$title][$lang])) {
		return $exact[$title][$lang];
	}

	if (preg_match('/^(.+?)\s+Clock$/i', $title, $matches)) {
		$place = trim($matches[1]);
		$place_names = array(
			'fr' => array(
				'Athens' => 'Athènes',
				'Beijing' => 'Pékin',
				'Cairo' => 'Le Caire',
				'Cape Town' => 'Le Cap',
				'Copenhagen' => 'Copenhague',
				'London' => 'Londres',
				'Mexico City' => 'Mexico',
				'Munich' => 'Munich',
				'New York' => 'New York',
				'Rome' => 'Rome',
				'Sao Paulo' => 'São Paulo',
				'Seoul' => 'Séoul',
				'Stockholm' => 'Stockholm',
				'Vienna' => 'Vienne',
				'Zurich' => 'Zurich',
			),
			'es-mx' => array(
				'Athens' => 'Atenas',
				'Beijing' => 'Pekín',
				'Cairo' => 'El Cairo',
				'Cape Town' => 'Ciudad del Cabo',
				'Copenhagen' => 'Copenhague',
				'London' => 'Londres',
				'Mexico City' => 'Ciudad de México',
				'Munich' => 'Múnich',
				'New York' => 'Nueva York',
				'Rome' => 'Roma',
				'Sao Paulo' => 'São Paulo',
				'Seoul' => 'Seúl',
				'Stockholm' => 'Estocolmo',
				'Vienna' => 'Viena',
				'Zurich' => 'Zúrich',
			),
			'es-es' => array(
				'Athens' => 'Atenas',
				'Beijing' => 'Pekín',
				'Cairo' => 'El Cairo',
				'Cape Town' => 'Ciudad del Cabo',
				'Copenhagen' => 'Copenhague',
				'London' => 'Londres',
				'Mexico City' => 'Ciudad de México',
				'Munich' => 'Múnich',
				'New York' => 'Nueva York',
				'Rome' => 'Roma',
				'Sao Paulo' => 'São Paulo',
				'Seoul' => 'Seúl',
				'Stockholm' => 'Estocolmo',
				'Vienna' => 'Viena',
				'Zurich' => 'Zúrich',
			),
		);
		$localized_place = isset($place_names[$lang][$place]) ? $place_names[$lang][$place] : $place;
		$french_place = preg_match('/^[aeiouh]/iu', $localized_place) ? "d'" . $localized_place : 'de ' . $localized_place;
		$clock_titles = array(
			'tr' => $place . ' Saati',
			'en' => $place . ' Clock',
			'de' => $place . '-Uhr',
			'fr' => 'Horloge ' . $french_place,
			'es-mx' => 'Reloj de ' . $localized_place,
			'es-es' => 'Reloj de ' . $localized_place,
		);

		return isset($clock_titles[$lang]) ? $clock_titles[$lang] : $title;
	}

	$phrase_translations = array(
		'fr' => array(
			'Memory' => 'Mémoire',
			'Puzzle' => 'Puzzle',
			'Game' => 'Jeu',
			'Challenge' => 'Défi',
			'Builder' => 'Constructeur',
			'Runner' => 'Coureur',
			'Rescue' => 'Sauvetage',
			'Signal' => 'Signal',
			'Shadow' => 'Ombre',
			'Orbit' => 'Orbite',
			'Robot' => 'Robot',
			'Color' => 'Couleur',
			'Code' => 'Code',
			'Word' => 'Mot',
			'Tower' => 'Tour',
			'Castle' => 'Château',
			'Maze' => 'Labyrinthe',
			'Laser' => 'Laser',
			'Mirror' => 'Miroir',
			'Match' => 'Associer',
			'Architect' => 'Architecte',
			'Adventure' => 'Aventure',
			'Battle' => 'Bataille',
			'Base' => 'Base',
			'Circuit' => 'Circuit',
			'City' => 'Ville',
			'Collector' => 'Collecteur',
			'Courier' => 'Messager',
			'Crafter' => 'Créateur',
			'Crystal' => 'Cristal',
			'Decoder' => 'Décodeur',
			'Defense' => 'Défense',
			'Drift' => 'Dérive',
			'Echo' => 'Écho',
			'Escape' => 'Évasion',
			'Fruit' => 'Fruit',
			'Grid' => 'Grille',
			'Guardian' => 'Gardien',
			'Hunt' => 'Chasse',
			'Jungle' => 'Jungle',
			'Monster' => 'Monstre',
			'Neon' => 'Néon',
			'Pilot' => 'Pilote',
			'Pixel' => 'Pixel',
			'Pulse' => 'Pulsation',
			'Quantum' => 'Quantique',
			'Quest' => 'Quête',
			'Racing' => 'Course',
			'Recall' => 'Mémoire',
			'Relay' => 'Relais',
			'Revival' => 'Retour',
			'Rocket' => 'Fusée',
			'Silent' => 'Silencieux',
			'Soccer' => 'Football',
			'Space' => 'Espace',
			'Speed' => 'Vitesse',
			'Sprint' => 'Sprint',
			'Target' => 'Cible',
			'Treasure' => 'Trésor',
			'Turbo' => 'Turbo',
			'Vault' => 'Coffre',
			'World' => 'Monde',
		),
		'es-mx' => array(
			'Memory' => 'Memoria',
			'Puzzle' => 'Rompecabezas',
			'Game' => 'Juego',
			'Challenge' => 'Desafío',
			'Builder' => 'Constructor',
			'Runner' => 'Corredor',
			'Rescue' => 'Rescate',
			'Signal' => 'Señal',
			'Shadow' => 'Sombra',
			'Orbit' => 'Órbita',
			'Robot' => 'Robot',
			'Color' => 'Color',
			'Code' => 'Código',
			'Word' => 'Palabra',
			'Tower' => 'Torre',
			'Castle' => 'Castillo',
			'Maze' => 'Laberinto',
			'Laser' => 'Láser',
			'Mirror' => 'Espejo',
			'Match' => 'Relacionar',
			'Architect' => 'Arquitecto',
			'Adventure' => 'Aventura',
			'Battle' => 'Batalla',
			'Base' => 'Base',
			'Circuit' => 'Circuito',
			'City' => 'Ciudad',
			'Collector' => 'Recolector',
			'Courier' => 'Mensajero',
			'Crafter' => 'Creador',
			'Crystal' => 'Cristal',
			'Decoder' => 'Decodificador',
			'Defense' => 'Defensa',
			'Drift' => 'Deriva',
			'Echo' => 'Eco',
			'Escape' => 'Escape',
			'Fruit' => 'Fruta',
			'Grid' => 'Cuadrícula',
			'Guardian' => 'Guardián',
			'Hunt' => 'Caza',
			'Jungle' => 'Jungla',
			'Monster' => 'Monstruo',
			'Neon' => 'Neón',
			'Pilot' => 'Piloto',
			'Pixel' => 'Pixel',
			'Pulse' => 'Pulso',
			'Quantum' => 'Cuántico',
			'Quest' => 'Misión',
			'Racing' => 'Carreras',
			'Recall' => 'Memoria',
			'Relay' => 'Relevo',
			'Revival' => 'Renacer',
			'Rocket' => 'Cohete',
			'Silent' => 'Silencioso',
			'Soccer' => 'Futbol',
			'Space' => 'Espacio',
			'Speed' => 'Velocidad',
			'Sprint' => 'Sprint',
			'Target' => 'Objetivo',
			'Treasure' => 'Tesoro',
			'Turbo' => 'Turbo',
			'Vault' => 'Bóveda',
			'World' => 'Mundo',
		),
		'es-es' => array(
			'Memory' => 'Memoria',
			'Puzzle' => 'Puzle',
			'Game' => 'Juego',
			'Challenge' => 'Desafío',
			'Builder' => 'Constructor',
			'Runner' => 'Corredor',
			'Rescue' => 'Rescate',
			'Signal' => 'Señal',
			'Shadow' => 'Sombra',
			'Orbit' => 'Órbita',
			'Robot' => 'Robot',
			'Color' => 'Color',
			'Code' => 'Código',
			'Word' => 'Palabra',
			'Tower' => 'Torre',
			'Castle' => 'Castillo',
			'Maze' => 'Laberinto',
			'Laser' => 'Láser',
			'Mirror' => 'Espejo',
			'Match' => 'Relacionar',
			'Architect' => 'Arquitecto',
			'Adventure' => 'Aventura',
			'Battle' => 'Batalla',
			'Base' => 'Base',
			'Circuit' => 'Circuito',
			'City' => 'Ciudad',
			'Collector' => 'Recolector',
			'Courier' => 'Mensajero',
			'Crafter' => 'Creador',
			'Crystal' => 'Cristal',
			'Decoder' => 'Decodificador',
			'Defense' => 'Defensa',
			'Drift' => 'Deriva',
			'Echo' => 'Eco',
			'Escape' => 'Escape',
			'Fruit' => 'Fruta',
			'Grid' => 'Cuadrícula',
			'Guardian' => 'Guardián',
			'Hunt' => 'Caza',
			'Jungle' => 'Jungla',
			'Monster' => 'Monstruo',
			'Neon' => 'Neón',
			'Pilot' => 'Piloto',
			'Pixel' => 'Pixel',
			'Pulse' => 'Pulso',
			'Quantum' => 'Cuántico',
			'Quest' => 'Misión',
			'Racing' => 'Carreras',
			'Recall' => 'Memoria',
			'Relay' => 'Relevo',
			'Revival' => 'Renacer',
			'Rocket' => 'Cohete',
			'Silent' => 'Silencioso',
			'Soccer' => 'Fútbol',
			'Space' => 'Espacio',
			'Speed' => 'Velocidad',
			'Sprint' => 'Sprint',
			'Target' => 'Objetivo',
			'Treasure' => 'Tesoro',
			'Turbo' => 'Turbo',
			'Vault' => 'Cámara',
			'World' => 'Mundo',
		),
	);

	if (isset($phrase_translations[$lang])) {
		return strtr($title, $phrase_translations[$lang]);
	}

	return $title;
}

function zo_get_fallback_game_title_metadata($title) {
	$parts = array();

	foreach (zo_get_language_options() as $lang => $label) {
		$value = zo_get_fallback_game_title_for_language($title, $lang);
		if ($value !== '') {
			$parts[] = zo_get_metadata_language_label($lang) . ' ' . $value;
		}
	}

	return implode(' | ', $parts);
}

function zo_get_smart_fallback_game_metadata($module) {
	$name = !empty($module['name']) && is_string($module['name']) ? trim($module['name']) : '';
	$slug = !empty($module['slug']) ? sanitize_title($module['slug']) : sanitize_title($name);
	$description = !empty($module['description']) && is_string($module['description']) ? trim(wp_strip_all_tags($module['description'])) : '';

	if ($name === '') {
		return null;
	}

	$has_localized_name = preg_match('/(?:^|\|)\s*(TR|EN|DE|FR|ES-MX|ES-ES):/i', $name) === 1;
	$clean_name = $has_localized_name ? zo_cleanup_generated_game_title(zo_get_localized_text($name, 'en')) : zo_cleanup_generated_game_title($name);
	$category = zo_get_game_category($slug, $clean_name, $description);
	$templates = zo_get_fallback_description_templates($category);
	$name_fallback = zo_get_fallback_game_title_metadata($clean_name);
	$name_value = $has_localized_name ? $name : $name_fallback;
	$name_value = zo_append_missing_localized_parts($name_value, $name_fallback, zo_get_language_options());
	$localized_names = array();

	foreach (zo_get_language_options() as $lang => $label) {
		$localized_names[$lang] = zo_get_fallback_game_title_for_language($clean_name, $lang);
	}

	return array(
		'name' => $name_value,
		'description' => sprintf(
			'TR: %1$s EN: %2$s DE: %3$s FR: %4$s ES-MX: %5$s ES-ES: %6$s',
			sprintf($templates['tr'], $localized_names['tr']),
			sprintf($templates['en'], $localized_names['en']),
			sprintf($templates['de'], $localized_names['de']),
			sprintf($templates['fr'], $localized_names['fr']),
			sprintf($templates['es-mx'], $localized_names['es-mx']),
			sprintf($templates['es-es'], $localized_names['es-es'])
		),
	);
}

function zo_cleanup_generated_game_title($title) {
	$title = trim(wp_strip_all_tags((string) $title));
	$title = preg_replace('/\s+/', ' ', $title);

	if (!is_string($title) || $title === '') {
		return '';
	}

	$title = preg_replace('/^\s*(TR|EN|DE|FR|ES-MX|ES-ES):\s*/i', '', $title);
	$title = preg_replace('/\s+(oyunu|game|spiel)\s*$/iu', '', $title);
	$title = str_replace(array('_', '-'), ' ', $title);
	$title = preg_replace('/\s+/', ' ', $title);

	if (function_exists('mb_convert_case')) {
		return mb_convert_case(trim($title), MB_CASE_TITLE, 'UTF-8');
	}

	return ucwords(strtolower(trim($title)));
}

function zo_get_game_category_options() {
	return array(
		'all' => array(
			'tr' => 'Tüm oyunlar',
			'en' => 'All games',
			'es-mx' => 'Todos los juegos',
			'es-es' => 'Todos los juegos',
			'de' => 'Alle Spiele',
			'fr' => 'Tous les jeux',
		),
		'puzzle' => array(
			'tr' => 'Bulmaca',
			'en' => 'Puzzle',
			'es-mx' => 'Rompecabezas',
			'es-es' => 'Puzles',
			'de' => 'Rätsel',
			'fr' => 'Puzzle',
		),
		'memory' => array(
			'tr' => 'Hafıza',
			'en' => 'Memory',
			'es-mx' => 'Memoria',
			'es-es' => 'Memoria',
			'de' => 'Gedächtnis',
			'fr' => 'Mémoire',
		),
		'math' => array(
			'tr' => 'Matematik',
			'en' => 'Math',
			'es-mx' => 'Matemáticas',
			'es-es' => 'Matemáticas',
			'de' => 'Mathe',
			'fr' => 'Maths',
		),
		'action' => array(
			'tr' => 'Aksiyon',
			'en' => 'Action',
			'es-mx' => 'Acción',
			'es-es' => 'Acción',
			'de' => 'Action',
			'fr' => 'Action',
		),
		'sports' => array(
			'tr' => 'Spor',
			'en' => 'Sports',
			'es-mx' => 'Deportes',
			'es-es' => 'Deportes',
			'de' => 'Sport',
			'fr' => 'Sport',
		),
		'creative' => array(
			'tr' => 'Yaratıcı',
			'en' => 'Creative',
			'es-mx' => 'Creativo',
			'es-es' => 'Creativo',
			'de' => 'Kreativ',
			'fr' => 'Créatif',
		),
		'tool' => array(
			'tr' => 'Araçlar',
			'en' => 'Tools',
			'es-mx' => 'Herramientas',
			'es-es' => 'Herramientas',
			'de' => 'Werkzeuge',
			'fr' => 'Outils',
		),
	);
}

function zo_get_game_category_label($category, $lang = '') {
	$lang = array_key_exists($lang, zo_get_language_options()) ? $lang : zo_get_current_language();
	$options = zo_get_game_category_options();
	$category = isset($options[$category]) ? $category : 'all';

	return $options[$category][$lang] ?? $options[$category]['en'];
}

function zo_get_game_category($slug, $title = '', $description = '') {
	$text = strtolower((string) $slug . ' ' . (string) $title . ' ' . (string) $description);

	if (preg_match('/clock|time|calculator|search|launcher|paint|designer|builder|studio|draw|drawing|boyama|arama|saat|hesap/', $text)) {
		return 'tool';
	}

	if (preg_match('/math|number|binary|calculator|angle|quiz|soru|country|ulke|line/', $text)) {
		return 'math';
	}

	if (preg_match('/memory|recall|simon|sequence|hafiza|remember|match/', $text)) {
		return 'memory';
	}

	if (preg_match('/soccer|football|penalty|race|racing|sled|snowboard|golf|sports|futbol|kosu/', $text)) {
		return 'sports';
	}

	if (preg_match('/runner|battle|shoot|shooter|defense|army|fight|survival|escape|rescue|dodg|ninja|dragon|heist|lava|arena|rocket/', $text)) {
		return 'action';
	}

	if (preg_match('/paint|design|designer|builder|factory|garden|shop|city|farm|creative|robot/', $text)) {
		return 'creative';
	}

	return 'puzzle';
}

function zo_get_fallback_description_templates($category) {
	$templates = array(
		'puzzle' => array(
			'tr' => '%s, dikkatli düşünerek adım adım çözdüğün bir zeka bulmacasıdır.',
			'en' => '%s is a thinking puzzle where you solve the challenge step by step.',
			'es-mx' => '%s es un rompecabezas para pensar y resolver el reto paso a paso.',
			'es-es' => '%s es un puzle de lógica para resolver el reto paso a paso.',
			'de' => '%s ist ein Denkspiel, bei dem du die Aufgabe Schritt für Schritt löst.',
			'fr' => '%s est un jeu de réflexion où tu résous le défi étape par étape.',
		),
		'memory' => array(
			'tr' => '%s, sırayı hatırlayıp doğru hamleleri yapmanı isteyen bir hafıza oyunudur.',
			'en' => '%s is a memory game where you remember the pattern and make the right moves.',
			'es-mx' => '%s es un juego de memoria donde recuerdas el patrón y haces los movimientos correctos.',
			'es-es' => '%s es un juego de memoria en el que recuerdas el patrón y haces los movimientos correctos.',
			'de' => '%s ist ein Memory-Spiel, bei dem du Muster merkst und richtig reagierst.',
			'fr' => '%s est un jeu de mémoire où tu retiens le motif et fais les bons choix.',
		),
		'math' => array(
			'tr' => '%s, sayılar ve mantıkla pratik yapmanı sağlayan eğitici bir oyundur.',
			'en' => '%s is an educational game for practicing numbers and logic.',
			'es-mx' => '%s es un juego educativo para practicar números y lógica.',
			'es-es' => '%s es un juego educativo para practicar números y lógica.',
			'de' => '%s ist ein Lernspiel zum Üben von Zahlen und Logik.',
			'fr' => '%s est un jeu éducatif pour s’entraîner avec les nombres et la logique.',
		),
		'action' => array(
			'tr' => '%s, hızlı tepki verip hedefe ulaşmaya çalıştığın hareketli bir oyundur.',
			'en' => '%s is an action game where quick reactions help you reach the goal.',
			'es-mx' => '%s es un juego de acción donde tus reflejos te ayudan a llegar a la meta.',
			'es-es' => '%s es un juego de acción en el que tus reflejos te ayudan a llegar al objetivo.',
			'de' => '%s ist ein Actionspiel, bei dem schnelle Reaktionen zum Ziel führen.',
			'fr' => '%s est un jeu d’action où tes réflexes t’aident à atteindre l’objectif.',
		),
		'sports' => array(
			'tr' => '%s, zamanlama ve stratejiyle oynanan spor temalı bir oyundur.',
			'en' => '%s is a sports game built around timing and strategy.',
			'es-mx' => '%s es un juego de deportes basado en ritmo y estrategia.',
			'es-es' => '%s es un juego deportivo basado en ritmo y estrategia.',
			'de' => '%s ist ein Sportspiel mit Timing und Strategie.',
			'fr' => '%s est un jeu de sport basé sur le timing et la stratégie.',
		),
		'creative' => array(
			'tr' => '%s, bir şeyler kurup deneyerek ilerlediğin yaratıcı bir oyundur.',
			'en' => '%s is a creative game where you build, test, and improve your idea.',
			'es-mx' => '%s es un juego creativo donde construyes, pruebas y mejoras tu idea.',
			'es-es' => '%s es un juego creativo en el que construyes, pruebas y mejoras tu idea.',
			'de' => '%s ist ein kreatives Spiel, in dem du baust, testest und verbesserst.',
			'fr' => '%s est un jeu créatif où tu construis, testes et améliores ton idée.',
		),
		'tool' => array(
			'tr' => '%s, tarayıcıda kullanabileceğin basit ve eğitici bir araçtır.',
			'en' => '%s is a simple educational tool you can use in the browser.',
			'es-mx' => '%s es una herramienta educativa sencilla que puedes usar en el navegador.',
			'es-es' => '%s es una herramienta educativa sencilla que puedes usar en el navegador.',
			'de' => '%s ist ein einfaches Lernwerkzeug für den Browser.',
			'fr' => '%s est un outil éducatif simple à utiliser dans le navigateur.',
		),
	);

	return isset($templates[$category]) ? $templates[$category] : $templates['puzzle'];
}

function zo_get_language_options() {
	return array(
		'tr' => 'TR',
		'en' => 'EN',
		'de' => 'DE',
		'fr' => 'FR',
		'es-mx' => 'MX',
		'es-es' => 'ES',
	);
}

function zo_get_current_language() {
	$lang = '';

	if (isset($_GET['zo_lang'])) {
		$lang = sanitize_key(wp_unslash($_GET['zo_lang']));
	}

	return array_key_exists($lang, zo_get_language_options()) ? $lang : 'tr';
}

function zo_get_interface_text($key, $lang = '') {
	$lang = array_key_exists($lang, zo_get_language_options()) ? $lang : zo_get_current_language();
	$text = array(
		'home' => array(
			'tr' => 'Ana Sayfaya Dön',
			'en' => 'Go to the home page',
			'es-mx' => 'Ir a la página de inicio',
			'es-es' => 'Ir a la página de inicio',
			'fr' => 'Retour à l’accueil',
			'de' => 'Zur Startseite',
		),
		'intro' => array(
			'tr' => 'Çocuklar, ilkokul öğrencileri ve yaşlılar için ücretsiz online eğitici zeka oyunları, mantık oyunları ve hafıza oyunları oynayın.',
			'en' => 'Play free online educational brain games, logic games, and memory games for kids, primary school students, and older people.',
			'es-mx' => 'Juega gratis en línea juegos educativos de ingenio, lógica y memoria para niños, estudiantes de primaria y personas mayores.',
			'es-es' => 'Juega gratis en línea a juegos educativos de ingenio, lógica y memoria para niños, alumnos de primaria y personas mayores.',
			'fr' => 'Jouez gratuitement en ligne à des jeux éducatifs de réflexion, de logique et de mémoire pour les enfants, les élèves du primaire et les personnes âgées.',
			'de' => 'Spielen Sie kostenlose online Lern-Denkspiele, Logikspiele und Gedächtnisspiele für Kinder, Grundschüler und ältere Menschen.',
		),
		'open_game' => array(
			'tr' => 'Oyunu Aç',
			'en' => 'Open Game',
			'es-mx' => 'Abrir juego',
			'es-es' => 'Abrir juego',
			'fr' => 'Ouvrir le jeu',
			'de' => 'Spiel Öffnen',
		),
		'language_label' => array(
			'tr' => 'Dil',
			'en' => 'Language',
			'es-mx' => 'Idioma',
			'es-es' => 'Idioma',
			'fr' => 'Langue',
			'de' => 'Sprache',
		),
		'search_label' => array(
			'tr' => 'Oyun ara',
			'en' => 'Search games',
			'es-mx' => 'Buscar juegos',
			'es-es' => 'Buscar juegos',
			'fr' => 'Rechercher un jeu',
			'de' => 'Spiele suchen',
		),
		'search_placeholder' => array(
			'tr' => 'Oyun adı yaz',
			'en' => 'Type a game name',
			'es-mx' => 'Escribe el nombre de un juego',
			'es-es' => 'Escribe el nombre de un juego',
			'fr' => 'Écris le nom d’un jeu',
			'de' => 'Spielname eingeben',
		),
		'category_label' => array(
			'tr' => 'Kategori',
			'en' => 'Category',
			'es-mx' => 'Categoría',
			'es-es' => 'Categoría',
			'fr' => 'Catégorie',
			'de' => 'Kategorie',
		),
		'sort_label' => array(
			'tr' => 'Sırala',
			'en' => 'Sort',
			'es-mx' => 'Ordenar',
			'es-es' => 'Ordenar',
			'fr' => 'Trier',
			'de' => 'Sortieren',
		),
		'sort_title' => array(
			'tr' => 'Ada göre',
			'en' => 'By name',
			'es-mx' => 'Por nombre',
			'es-es' => 'Por nombre',
			'fr' => 'Par nom',
			'de' => 'Nach Name',
		),
		'sort_newest' => array(
			'tr' => 'En yeni',
			'en' => 'Newest',
			'es-mx' => 'Más recientes',
			'es-es' => 'Más recientes',
			'fr' => 'Les plus récents',
			'de' => 'Neueste zuerst',
		),
		'sort_category' => array(
			'tr' => 'Kategoriye göre',
			'en' => 'By category',
			'es-mx' => 'Por categoría',
			'es-es' => 'Por categoría',
			'fr' => 'Par catégorie',
			'de' => 'Nach Kategorie',
		),
		'filter_submit' => array(
			'tr' => 'Filtrele',
			'en' => 'Filter',
			'es-mx' => 'Filtrar',
			'es-es' => 'Filtrar',
			'fr' => 'Filtrer',
			'de' => 'Filtern',
		),
		'filter_reset' => array(
			'tr' => 'Temizle',
			'en' => 'Clear',
			'es-mx' => 'Limpiar',
			'es-es' => 'Borrar',
			'fr' => 'Réinitialiser',
			'de' => 'Zurücksetzen',
		),
		'results_count' => array(
			'tr' => '%d oyun gösteriliyor',
			'en' => 'Showing %d games',
			'es-mx' => 'Mostrando %d juegos',
			'es-es' => 'Mostrando %d juegos',
			'fr' => '%d jeux affichés',
			'de' => '%d Spiele werden angezeigt',
		),
		'play_suffix' => array(
			'tr' => 'oyna',
			'en' => 'play',
			'es-mx' => 'jugar',
			'es-es' => 'jugar',
			'fr' => 'jouer',
			'de' => 'spielen',
		),
		'language_unavailable' => array(
			'tr' => 'Bu oyun seçili dilde kullanılamıyor.',
			'en' => 'This game is not available in the selected language.',
			'es-mx' => 'Este juego no está disponible en el idioma seleccionado.',
			'es-es' => 'Este juego no está disponible en el idioma seleccionado.',
			'fr' => 'Ce jeu n’est pas disponible dans la langue sélectionnée.',
			'de' => 'Dieses Spiel ist in der ausgewählten Sprache nicht verfügbar.',
		),
	);

	$text['asker_about'] = array(
		'tr' => 'Askerin Oyunları Hakkında',
		'en' => 'About Asker’s Games',
		'fr' => 'À propos des jeux d’Asker',
		'de' => 'Über Askers Spiele',
	);
	$text['asker_games_link'] = array(
		'tr' => 'Askerin oyunlarına git',
		'en' => 'Go to Asker’s Games',
		'fr' => 'Aller aux jeux d’Asker',
		'de' => 'Zu Askers Spielen gehen',
	);
	$text['asker_games_title'] = array(
		'tr' => 'Askerin Oyunları',
		'en' => 'Asker’s Games',
		'fr' => 'Jeux d’Asker',
		'de' => 'Askers Spiele',
	);
	$text['arslan_games_title'] = array(
		'tr' => 'Arslanın Oyunları',
		'en' => 'Arslan’s Games',
		'fr' => 'Jeux d’Arslan',
		'de' => 'Arslans Spiele',
	);

	if (isset($text['asker_about'])) {
		$text['asker_about']['es-mx'] = 'Acerca de los juegos de Asker';
		$text['asker_about']['es-es'] = 'Acerca de los juegos de Asker';
	}

	if (isset($text['asker_games_link'])) {
		$text['asker_games_link']['es-mx'] = 'Ir a los juegos de Asker';
		$text['asker_games_link']['es-es'] = 'Ir a los juegos de Asker';
	}

	if (isset($text['asker_games_title'])) {
		$text['asker_games_title']['es-mx'] = 'Juegos de Asker';
		$text['asker_games_title']['es-es'] = 'Juegos de Asker';
	}

	if (isset($text['arslan_games_title'])) {
		$text['arslan_games_title']['es-mx'] = 'Juegos de Arslan';
		$text['arslan_games_title']['es-es'] = 'Juegos de Arslan';
	}

	return isset($text[$key][$lang]) ? $text[$key][$lang] : '';
}

function zo_get_game_language_availability($slug) {
	$restricted = array(
		'adam-asmaca' => array('tr'),
		'ai-companion-trainer' => array('en'),
		'falling-letters-catch' => array('tr'),
		'firavunun-hazinesi' => array('tr'),
		'kelime-karistirma' => array('tr'),
		'kutsal-bocek-labirenti' => array('tr'),
		'ogretmenden-kac' => array('tr'),
		'simit-run' => array('tr'),
		'speed-sort' => array('tr'),
		'tr-search-launcher' => array('tr'),
		'turkish-word-builder' => array('tr'),
		'ulke-100-soru' => array('tr'),
	);

	$slug = sanitize_title($slug);

	return isset($restricted[$slug]) ? $restricted[$slug] : array_keys(zo_get_language_options());
}

function zo_is_game_available_for_language($slug, $lang = '') {
	$lang = array_key_exists($lang, zo_get_language_options()) ? $lang : zo_get_current_language();

	return in_array($lang, zo_get_game_language_availability($slug), true);
}

function zo_get_runtime_translation_exact_map($lang) {
	$lang = array_key_exists($lang, zo_get_language_options()) ? $lang : zo_get_current_language();

	$translations = array(
		'tr' => array(
			'Start' => 'Başlat',
			'Play' => 'Oyna',
			'Play Again' => 'Tekrar Oyna',
			'Restart' => 'Yeniden Başlat',
			'Restart Game' => 'Oyunu Yeniden Başlat',
			'Restart Round' => 'Turu Yeniden Başlat',
			'Next' => 'Sonraki',
			'Next Round' => 'Sonraki Tur',
			'Next Question' => 'Sonraki Soru',
			'Next Level' => 'Sonraki Seviye',
			'Next Stage' => 'Sonraki Aşama',
			'Pause' => 'Duraklat',
			'Paused' => 'Duraklatıldı',
			'Resume' => 'Devam Et',
			'Refresh' => 'Yenile',
			'12/24 Format' => '12/24 Saat',
			'Paris Time' => 'Paris Saati',
			'Paris Clock' => 'Paris Saati',
			'Submit' => 'Gönder',
			'Hint' => 'İpucu',
			'Show Hint' => 'İpucu Göster',
			'Score' => 'Puan',
			'Points' => 'Puan',
			'Final Score' => 'Son Puan',
			'Best' => 'En İyi',
			'Level' => 'Seviye',
			'Round' => 'Tur',
			'Stage' => 'Aşama',
			'Time' => 'Süre',
			'Lives' => 'Can',
			'Health' => 'Sağlık',
			'Coins' => 'Coin',
			'Gold' => 'Altın',
			'Goal' => 'Hedef',
			'Question' => 'Soru',
			'Correct' => 'Doğru',
			'Wrong' => 'Yanlış',
			'Game Over' => 'Oyun Bitti',
			'GAME OVER' => 'OYUN BİTTİ',
			'You Win' => 'Kazandın',
			'You Win!' => 'Kazandın!',
			'You lost' => 'Kaybettin',
			'You Lost' => 'Kaybettin',
			'How to Play' => 'Nasıl Oynanır',
			'Rules' => 'Kurallar',
			'Move List' => 'Hamle Listesi',
			'Round History' => 'Tur Geçmişi',
			'Make a Move' => 'Hamle Yap',
			'Press Start.' => 'Başlat düğmesine bas.',
			'Press Start to begin.' => 'Başlamak için Başlat düğmesine bas.',
			'Press action to begin the challenge.' => 'Mücadeleye başlamak için hamle yap.',
			'Correct.' => 'Doğru.',
			'Wrong.' => 'Yanlış.',
			'Correct!' => 'Doğru!',
			'Wrong!' => 'Yanlış!',
			'Try again.' => 'Tekrar dene.',
			'Time is up.' => 'Süre doldu.',
			'Time finished.' => 'Süre bitti.',
			'ready' => 'hazır',
			'done' => 'bitti',
			'left' => 'kaldı',
		),
		'en' => array(
			'Başlat' => 'Start',
			'Oyna' => 'Play',
			'Tekrar Oyna' => 'Play Again',
			'Yeniden Başlat' => 'Restart',
			'Oyunu Yeniden Başlat' => 'Restart Game',
			'Turu Yeniden Başlat' => 'Restart Round',
			'Sonraki' => 'Next',
			'Sonraki Tur' => 'Next Round',
			'Sonraki Soru' => 'Next Question',
			'Sonraki Seviye' => 'Next Level',
			'Sonraki Aşama' => 'Next Stage',
			'Duraklat' => 'Pause',
			'Devam Et' => 'Resume',
			'Yenile' => 'Refresh',
			'12/24 Saat' => '12/24 Format',
			'Saati' => 'Clock',
			'Saat' => 'Time',
			'Paris Saati' => 'Paris Time',
			'Gönder' => 'Submit',
			'İpucu' => 'Hint',
			'İpucu Göster' => 'Show Hint',
			'Puan' => 'Score',
			'Son Puan' => 'Final Score',
			'En İyi' => 'Best',
			'Seviye' => 'Level',
			'Tur' => 'Round',
			'Aşama' => 'Stage',
			'Süre' => 'Time',
			'Can' => 'Lives',
			'Sağlık' => 'Health',
			'Altın' => 'Gold',
			'Hedef' => 'Goal',
			'Soru' => 'Question',
			'Doğru' => 'Correct',
			'Yanlış' => 'Wrong',
			'Oyun Bitti' => 'Game Over',
			'OYUN BİTTİ' => 'GAME OVER',
			'Kazandın' => 'You Win',
			'Kazandın!' => 'You Win!',
			'Kaybettin' => 'You Lost',
			'Nasıl Oynanır' => 'How to Play',
			'Kurallar' => 'Rules',
			'Hamle Listesi' => 'Move List',
			'Tur Geçmişi' => 'Round History',
			'Hamle Yap' => 'Make a Move',
			'Başlat düğmesine bas.' => 'Press Start.',
			'Başlamak için Başlat düğmesine bas.' => 'Press Start to begin.',
			'Doğru.' => 'Correct.',
			'Yanlış.' => 'Wrong.',
			'Doğru!' => 'Correct!',
			'Yanlış!' => 'Wrong!',
			'Tekrar dene.' => 'Try again.',
			'Süre doldu.' => 'Time is up.',
			'Süre bitti.' => 'Time finished.',
		),
		'de' => array(
			'Start' => 'Starten',
			'Play' => 'Spielen',
			'Play Again' => 'Noch einmal spielen',
			'Restart' => 'Neu starten',
			'Restart Game' => 'Spiel neu starten',
			'Restart Round' => 'Runde neu starten',
			'Next' => 'Weiter',
			'Next Round' => 'Nächste Runde',
			'Next Question' => 'Nächste Frage',
			'Next Level' => 'Nächstes Level',
			'Next Stage' => 'Nächste Stufe',
			'Pause' => 'Pause',
			'Paused' => 'Pausiert',
			'Resume' => 'Fortsetzen',
			'Refresh' => 'Aktualisieren',
			'12/24 Saat' => '12/24 Format',
			'Saati' => 'Uhr',
			'Saat' => 'Uhrzeit',
			'12/24 Format' => '12/24 Format',
			'Paris Time' => 'Pariser Zeit',
			'Paris Clock' => 'Paris-Uhr',
			'Submit' => 'Senden',
			'Hint' => 'Hinweis',
			'Show Hint' => 'Hinweis zeigen',
			'Score' => 'Punkte',
			'Points' => 'Punkte',
			'Final Score' => 'Endpunkte',
			'Best' => 'Bestwert',
			'Level' => 'Level',
			'Round' => 'Runde',
			'Stage' => 'Stufe',
			'Time' => 'Zeit',
			'Lives' => 'Leben',
			'Health' => 'Gesundheit',
			'Coins' => 'Münzen',
			'Gold' => 'Gold',
			'Goal' => 'Ziel',
			'Question' => 'Frage',
			'Correct' => 'Richtig',
			'Wrong' => 'Falsch',
			'Game Over' => 'Spiel vorbei',
			'GAME OVER' => 'SPIEL VORBEI',
			'You Win' => 'Du gewinnst',
			'You Win!' => 'Du gewinnst!',
			'You lost' => 'Du hast verloren',
			'You Lost' => 'Du hast verloren',
			'How to Play' => 'Spielanleitung',
			'Rules' => 'Regeln',
			'Move List' => 'Zugliste',
			'Round History' => 'Rundenverlauf',
			'Make a Move' => 'Zug machen',
			'Press Start.' => 'Drücke Starten.',
			'Press Start to begin.' => 'Drücke Starten, um zu beginnen.',
			'Press action to begin the challenge.' => 'Drücke die Aktion, um die Herausforderung zu starten.',
			'Correct.' => 'Richtig.',
			'Wrong.' => 'Falsch.',
			'Correct!' => 'Richtig!',
			'Wrong!' => 'Falsch!',
			'Try again.' => 'Versuche es noch einmal.',
			'Time is up.' => 'Die Zeit ist abgelaufen.',
			'Time finished.' => 'Die Zeit ist vorbei.',
			'Başlat' => 'Starten',
			'Oyna' => 'Spielen',
			'Tekrar Oyna' => 'Noch einmal spielen',
			'Yeniden Başlat' => 'Neu starten',
			'Oyunu Yeniden Başlat' => 'Spiel neu starten',
			'Sonraki' => 'Weiter',
			'Duraklat' => 'Pause',
			'Devam Et' => 'Fortsetzen',
			'Yenile' => 'Aktualisieren',
			'Gönder' => 'Senden',
			'İpucu' => 'Hinweis',
			'Puan' => 'Punkte',
			'Seviye' => 'Level',
			'Tur' => 'Runde',
			'Süre' => 'Zeit',
			'Can' => 'Leben',
			'Sağlık' => 'Gesundheit',
			'Hedef' => 'Ziel',
			'Soru' => 'Frage',
			'Doğru' => 'Richtig',
			'Yanlış' => 'Falsch',
			'Oyun Bitti' => 'Spiel vorbei',
			'Kazandın' => 'Du gewinnst',
			'Kaybettin' => 'Du hast verloren',
			'Nasıl Oynanır' => 'Spielanleitung',
			'Kurallar' => 'Regeln',
			'Hamle Yap' => 'Zug machen',
			'Başlat düğmesine bas.' => 'Drücke Starten.',
			'Başlamak için Başlat düğmesine bas.' => 'Drücke Starten, um zu beginnen.',
		),
		'fr' => array(
			'Start' => 'Démarrer',
			'Play' => 'Jouer',
			'Play Again' => 'Rejouer',
			'Restart' => 'Redémarrer',
			'Restart Game' => 'Redémarrer le jeu',
			'Next' => 'Suivant',
			'Next Round' => 'Manche suivante',
			'Next Question' => 'Question suivante',
			'Next Level' => 'Niveau suivant',
			'Pause' => 'Pause',
			'Resume' => 'Reprendre',
			'Refresh' => 'Actualiser',
			'12/24 Saat' => 'Format 12/24',
			'Saati' => 'Horloge',
			'Saat' => 'Heure',
			'Submit' => 'Envoyer',
			'Hint' => 'Indice',
			'Show Hint' => 'Afficher l’indice',
			'Score' => 'Score',
			'Points' => 'Points',
			'Final Score' => 'Score final',
			'Best' => 'Meilleur',
			'Level' => 'Niveau',
			'Round' => 'Manche',
			'Stage' => 'Étape',
			'Time' => 'Temps',
			'Lives' => 'Vies',
			'Health' => 'Santé',
			'Coins' => 'Pièces',
			'Gold' => 'Or',
			'Goal' => 'Objectif',
			'Question' => 'Question',
			'Correct' => 'Correct',
			'Wrong' => 'Incorrect',
			'Game Over' => 'Partie terminée',
			'GAME OVER' => 'PARTIE TERMINÉE',
			'You Win' => 'Tu as gagné',
			'You Win!' => 'Tu as gagné !',
			'You lost' => 'Tu as perdu',
			'You Lost' => 'Tu as perdu',
			'How to Play' => 'Comment jouer',
			'Rules' => 'Règles',
			'Move List' => 'Liste des coups',
			'Round History' => 'Historique des manches',
			'Make a Move' => 'Jouer un coup',
			'Press Start.' => 'Appuie sur Démarrer.',
			'Press Start to begin.' => 'Appuie sur Démarrer pour commencer.',
			'Press action to begin the challenge.' => 'Appuie sur action pour commencer le défi.',
			'Correct.' => 'Correct.',
			'Wrong.' => 'Incorrect.',
			'Correct!' => 'Correct !',
			'Wrong!' => 'Incorrect !',
			'Try again.' => 'Réessaie.',
			'Time is up.' => 'Le temps est écoulé.',
			'Time finished.' => 'Le temps est terminé.',
			'BaÅŸlat' => 'Démarrer',
			'Oyna' => 'Jouer',
			'Tekrar Oyna' => 'Rejouer',
			'Yeniden BaÅŸlat' => 'Redémarrer',
			'Sonraki' => 'Suivant',
			'Duraklat' => 'Pause',
			'Devam Et' => 'Reprendre',
			'Yenile' => 'Actualiser',
			'Puan' => 'Score',
			'Seviye' => 'Niveau',
			'Tur' => 'Manche',
			'SÃ¼re' => 'Temps',
			'Can' => 'Vies',
			'Hedef' => 'Objectif',
			'Soru' => 'Question',
			'DoÄŸru' => 'Correct',
			'YanlÄ±ÅŸ' => 'Incorrect',
			'Oyun Bitti' => 'Partie terminée',
		),
	);

	$spanish_exact = array(
		'Start' => 'Empezar',
		'Play' => 'Jugar',
		'Play Again' => 'Jugar de nuevo',
		'Restart' => 'Reiniciar',
		'Restart Game' => 'Reiniciar juego',
		'Next' => 'Siguiente',
		'Next Round' => 'Siguiente ronda',
		'Next Question' => 'Siguiente pregunta',
		'Next Level' => 'Siguiente nivel',
		'Pause' => 'Pausa',
		'Resume' => 'Continuar',
		'Refresh' => 'Actualizar',
		'12/24 Saat' => 'Formato 12/24',
		'Saati' => 'Reloj',
		'Saat' => 'Hora',
		'Submit' => 'Enviar',
		'Hint' => 'Pista',
		'Show Hint' => 'Mostrar pista',
		'Score' => 'Puntuación',
		'Points' => 'Puntos',
		'Final Score' => 'Puntuación final',
		'Best' => 'Mejor',
		'Level' => 'Nivel',
		'Round' => 'Ronda',
		'Stage' => 'Etapa',
		'Time' => 'Tiempo',
		'Lives' => 'Vidas',
		'Health' => 'Salud',
		'Coins' => 'Monedas',
		'Gold' => 'Oro',
		'Goal' => 'Objetivo',
		'Question' => 'Pregunta',
		'Correct' => 'Correcto',
		'Wrong' => 'Incorrecto',
		'Game Over' => 'Fin del juego',
		'GAME OVER' => 'FIN DEL JUEGO',
		'You Win' => 'Ganaste',
		'You Win!' => '¡Ganaste!',
		'You lost' => 'Perdiste',
		'You Lost' => 'Perdiste',
		'How to Play' => 'Cómo jugar',
		'Rules' => 'Reglas',
		'Move List' => 'Lista de movimientos',
		'Round History' => 'Historial de rondas',
		'Make a Move' => 'Haz un movimiento',
		'Press Start.' => 'Pulsa Empezar.',
		'Press Start to begin.' => 'Pulsa Empezar para comenzar.',
		'Press action to begin the challenge.' => 'Pulsa acción para comenzar el reto.',
		'Correct.' => 'Correcto.',
		'Wrong.' => 'Incorrecto.',
		'Correct!' => '¡Correcto!',
		'Wrong!' => '¡Incorrecto!',
		'Try again.' => 'Inténtalo de nuevo.',
		'Time is up.' => 'Se acabó el tiempo.',
		'Time finished.' => 'El tiempo terminó.',
		'Oyna' => 'Jugar',
		'Tekrar Oyna' => 'Jugar de nuevo',
		'Sonraki' => 'Siguiente',
		'Duraklat' => 'Pausa',
		'Devam Et' => 'Continuar',
		'Yenile' => 'Actualizar',
		'Puan' => 'Puntuación',
		'Seviye' => 'Nivel',
		'Tur' => 'Ronda',
		'Can' => 'Vidas',
		'Hedef' => 'Objetivo',
		'Soru' => 'Pregunta',
		'Oyun Bitti' => 'Fin del juego',
	);

	$translations['es-mx'] = $spanish_exact;
	$translations['es-es'] = $spanish_exact;

	$common_exact = array(
		'tr' => array(
			'Reset' => 'Sıfırla',
			'Flip Board' => 'Tahtayı Çevir',
			'Force AI Move' => 'Yapay Zekaya Hamle Yaptır',
			'White' => 'Beyaz',
			'Black' => 'Siyah',
			'Robot Accuracy' => 'Robot Doğruluğu',
			'Trust' => 'Güven',
			'Corrections' => 'Düzeltmeler',
			'Robot guess' => 'Robot tahmini',
			'Loading scenario...' => 'Senaryo yükleniyor...',
			'Start Stage' => 'Aşamayı Başlat',
			'Borrow 5s' => '5 sn Ödünç Al',
			'Debt' => 'Borç',
			'Hardness' => 'Zorluk',
		),
		'en' => array(
			'Başla' => 'Start',
			'Sıfırla' => 'Reset',
			'Skor' => 'Score',
			'En iyi' => 'Best',
			'Süre bitti' => 'Time is up',
			'Kapılar' => 'Doors',
			'Kapı' => 'Door',
			'Sayı seçenekleri' => 'Number choices',
			'Kaza yaptın.' => 'You crashed.',
			'Çarpma.' => 'Do not crash.',
			'Sağ ve sol ile şerit değiştir.' => 'Switch lanes with left and right.',
		),
		'de' => array(
			'Reset' => 'Zurücksetzen',
			'Flip Board' => 'Brett drehen',
			'Force AI Move' => 'KI-Zug erzwingen',
			'White' => 'Weiß',
			'Black' => 'Schwarz',
			'Robot Accuracy' => 'Robotergenauigkeit',
			'Trust' => 'Vertrauen',
			'Corrections' => 'Korrekturen',
			'Robot guess' => 'Robotertipp',
			'Loading scenario...' => 'Szenario wird geladen...',
			'Start Stage' => 'Stufe starten',
			'Borrow 5s' => '5 s leihen',
			'Debt' => 'Schuld',
			'Hardness' => 'Härte',
			'Başla' => 'Starten',
			'Sıfırla' => 'Zurücksetzen',
			'Skor' => 'Punkte',
			'En iyi' => 'Bestwert',
			'Süre bitti' => 'Zeit abgelaufen',
			'Kapılar' => 'Türen',
			'Kapı' => 'Tür',
			'Sayı seçenekleri' => 'Zahlenauswahl',
			'Kaza yaptın.' => 'Du bist verunglückt.',
			'Çarpma.' => 'Nicht zusammenstoßen.',
			'Sağ ve sol ile şerit değiştir.' => 'Wechsle mit links und rechts die Spur.',
		),
		'fr' => array(
			'Reset' => 'Réinitialiser',
			'Flip Board' => 'Retourner le plateau',
			'Force AI Move' => 'Forcer le coup de l’IA',
			'White' => 'Blanc',
			'Black' => 'Noir',
			'Robot Accuracy' => 'Précision du robot',
			'Trust' => 'Confiance',
			'Corrections' => 'Corrections',
			'Robot guess' => 'Choix du robot',
			'Loading scenario...' => 'Chargement du scénario...',
			'Start Stage' => 'Démarrer l’étape',
			'Borrow 5s' => 'Emprunter 5 s',
			'Debt' => 'Dette',
			'Hardness' => 'Difficulté',
			'Başla' => 'Démarrer',
			'Sıfırla' => 'Réinitialiser',
			'Skor' => 'Score',
			'En iyi' => 'Meilleur',
			'Süre bitti' => 'Le temps est écoulé',
			'Kapılar' => 'Portes',
			'Kapı' => 'Porte',
			'Sayı seçenekleri' => 'Choix de nombres',
			'Kaza yaptın.' => 'Tu as eu un accident.',
			'Çarpma.' => 'Évite la collision.',
			'Sağ ve sol ile şerit değiştir.' => 'Change de voie avec gauche et droite.',
		),
		'es-mx' => array(
			'Reset' => 'Reiniciar',
			'Flip Board' => 'Girar tablero',
			'Force AI Move' => 'Forzar movimiento de IA',
			'White' => 'Blanco',
			'Black' => 'Negro',
			'Robot Accuracy' => 'Precisión del robot',
			'Trust' => 'Confianza',
			'Corrections' => 'Correcciones',
			'Robot guess' => 'Predicción del robot',
			'Loading scenario...' => 'Cargando escenario...',
			'Start Stage' => 'Empezar etapa',
			'Borrow 5s' => 'Pedir 5 s',
			'Debt' => 'Deuda',
			'Hardness' => 'Dificultad',
			'Başla' => 'Empezar',
			'Sıfırla' => 'Reiniciar',
			'Skor' => 'Puntuación',
			'En iyi' => 'Mejor',
			'Süre bitti' => 'Se acabó el tiempo',
			'Kapılar' => 'Puertas',
			'Kapı' => 'Puerta',
			'Sayı seçenekleri' => 'Opciones de número',
			'Kaza yaptın.' => 'Chocaste.',
			'Çarpma.' => 'No choques.',
			'Sağ ve sol ile şerit değiştir.' => 'Cambia de carril con izquierda y derecha.',
		),
		'es-es' => array(
			'Reset' => 'Reiniciar',
			'Flip Board' => 'Girar tablero',
			'Force AI Move' => 'Forzar movimiento de IA',
			'White' => 'Blanco',
			'Black' => 'Negro',
			'Robot Accuracy' => 'Precisión del robot',
			'Trust' => 'Confianza',
			'Corrections' => 'Correcciones',
			'Robot guess' => 'Predicción del robot',
			'Loading scenario...' => 'Cargando escenario...',
			'Start Stage' => 'Empezar etapa',
			'Borrow 5s' => 'Pedir 5 s',
			'Debt' => 'Deuda',
			'Hardness' => 'Dificultad',
			'Başla' => 'Empezar',
			'Sıfırla' => 'Reiniciar',
			'Skor' => 'Puntuación',
			'En iyi' => 'Mejor',
			'Süre bitti' => 'Se acabó el tiempo',
			'Kapılar' => 'Puertas',
			'Kapı' => 'Puerta',
			'Sayı seçenekleri' => 'Opciones de número',
			'Kaza yaptın.' => 'Has chocado.',
			'Çarpma.' => 'No choques.',
			'Sağ ve sol ile şerit değiştir.' => 'Cambia de carril con izquierda y derecha.',
		),
	);

	$shared_game_exact = array(
		'tr' => array(
			'New Puzzle' => 'Yeni Bulmaca',
			'Check Grid' => 'Izgarayı Kontrol Et',
			'Clear Moves' => 'Hamleleri Temizle',
			'Calculate' => 'Hesapla',
			'Launch' => 'Fırlat',
			'Left' => 'Sol',
			'Right' => 'Sağ',
			'Up' => 'Yukarı',
			'Down' => 'Aşağı',
			'Move up' => 'Yukarı hareket et',
			'Move left' => 'Sola hareket et',
			'Move down' => 'Aşağı hareket et',
			'Move right' => 'Sağa hareket et',
			'Controls' => 'Kontroller',
			'Actions' => 'Eylemler',
			'Towers' => 'Kuleler',
			'Pick Arrow' => 'Ok Kulesi Seç',
			'Pick Cannon' => 'Top Kulesi Seç',
			'Pick Frost' => 'Buz Kulesi Seç',
			'Fruit Bin' => 'Meyve Kutusu',
			'Trash Bin' => 'Çöp Kutusu',
			'Compost Bin' => 'Kompost Kutusu',
			'Water Tank' => 'Su Tankı',
			'New Game' => 'Yeni Oyun',
			'Buy' => 'Satın Al',
			'Next Day' => 'Sonraki Gün',
			'Manager Info' => 'Yönetici Bilgisi',
			'Shop Upgrades' => 'Dükkan Yükseltmeleri',
			'Learning Signals' => 'Öğrenme Sinyalleri',
			'Coach Traits' => 'Koç Özellikleri',
			'Training Log' => 'Eğitim Günlüğü',
			'Restart Training' => 'Eğitimi Yeniden Başlat',
			'Select an operation.' => 'Bir işlem seç.',
			'Please enter a valid first number.' => 'Lütfen geçerli bir ilk sayı gir.',
			'Please enter a valid second number.' => 'Lütfen geçerli bir ikinci sayı gir.',
			'Cannot divide by zero.' => 'Sıfıra bölünemez.',
			'Cannot take the square root of a negative number.' => 'Negatif sayının karekökü alınamaz.',
			'No answers yet.' => 'Henüz cevap yok.',
			'Game finished' => 'Oyun bitti',
			'Finished' => 'Bitti',
			'Perfect Balance' => 'Mükemmel Denge',
			'Correct bin.' => 'Doğru kutu.',
			'Classify the bug.' => 'Böceği sınıflandır.',
			'Classify the bugs before time runs out.' => 'Süre bitmeden böcekleri sınıflandır.',
			'You lost all lives. Press Start.' => 'Tüm canları kaybettin. Başlat’a bas.',
			'Press Start.' => 'Başlat’a bas.',
			'Press Start to begin.' => 'Başlamak için Başlat’a bas.',
			'Life lost. Launch again.' => 'Can kaybettin. Tekrar fırlat.',
			'Game over. Press R or Restart.' => 'Oyun bitti. R’ye ya da Yeniden Başlat’a bas.',
			'Break every brick.' => 'Tüm blokları kır.',
			'You beat all 1000 levels!' => '1000 seviyenin hepsini geçtin!',
			'Great run! Keep the pattern going.' => 'Harika gidiş! Deseni sürdür.',
			'Action logged. Try for a longer chain.' => 'Hamle kaydedildi. Daha uzun zincir dene.',
			'Correct balloon!' => 'Doğru balon!',
			'Wrong balloon.' => 'Yanlış balon.',
			'Pop the correct balloons.' => 'Doğru balonları patlat.',
		),
		'de' => array(
			'New Puzzle' => 'Neues Rätsel',
			'Check Grid' => 'Raster prüfen',
			'Clear Moves' => 'Züge löschen',
			'Calculate' => 'Berechnen',
			'Launch' => 'Starten',
			'Left' => 'Links',
			'Right' => 'Rechts',
			'Up' => 'Hoch',
			'Down' => 'Runter',
			'Move up' => 'Nach oben bewegen',
			'Move left' => 'Nach links bewegen',
			'Move down' => 'Nach unten bewegen',
			'Move right' => 'Nach rechts bewegen',
			'Controls' => 'Steuerung',
			'Actions' => 'Aktionen',
			'Towers' => 'Türme',
			'Pick Arrow' => 'Pfeil wählen',
			'Pick Cannon' => 'Kanone wählen',
			'Pick Frost' => 'Frost wählen',
			'Fruit Bin' => 'Obstbehälter',
			'Trash Bin' => 'Müllbehälter',
			'Compost Bin' => 'Kompostbehälter',
			'Water Tank' => 'Wassertank',
			'New Game' => 'Neues Spiel',
			'Buy' => 'Kaufen',
			'Next Day' => 'Nächster Tag',
			'Manager Info' => 'Manager-Info',
			'Shop Upgrades' => 'Laden-Upgrades',
			'Learning Signals' => 'Lernsignale',
			'Coach Traits' => 'Coach-Eigenschaften',
			'Training Log' => 'Trainingsprotokoll',
			'Restart Training' => 'Training neu starten',
			'Select an operation.' => 'Wähle eine Rechenart.',
			'Please enter a valid first number.' => 'Bitte gib eine gültige erste Zahl ein.',
			'Please enter a valid second number.' => 'Bitte gib eine gültige zweite Zahl ein.',
			'Cannot divide by zero.' => 'Durch null kann nicht geteilt werden.',
			'Cannot take the square root of a negative number.' => 'Die Quadratwurzel einer negativen Zahl ist nicht möglich.',
			'No answers yet.' => 'Noch keine Antworten.',
			'Game finished' => 'Spiel beendet',
			'Finished' => 'Beendet',
			'Perfect Balance' => 'Perfektes Gleichgewicht',
			'Correct bin.' => 'Richtiger Behälter.',
			'Classify the bug.' => 'Sortiere das Insekt.',
			'Classify the bugs before time runs out.' => 'Sortiere die Insekten, bevor die Zeit abläuft.',
			'You lost all lives. Press Start.' => 'Du hast alle Leben verloren. Drücke Starten.',
			'Press Start.' => 'Drücke Starten.',
			'Press Start to begin.' => 'Drücke Starten, um zu beginnen.',
			'Life lost. Launch again.' => 'Leben verloren. Starte erneut.',
			'Game over. Press R or Restart.' => 'Spiel vorbei. Drücke R oder Neustart.',
			'Break every brick.' => 'Zerbrich jeden Stein.',
			'You beat all 1000 levels!' => 'Du hast alle 1000 Level geschafft!',
			'Great run! Keep the pattern going.' => 'Starker Lauf! Halte das Muster am Laufen.',
			'Action logged. Try for a longer chain.' => 'Aktion gespeichert. Versuche eine längere Kette.',
			'Correct balloon!' => 'Richtiger Ballon!',
			'Wrong balloon.' => 'Falscher Ballon.',
			'Pop the correct balloons.' => 'Lass die richtigen Ballons platzen.',
		),
		'fr' => array(
			'New Puzzle' => 'Nouveau puzzle',
			'Check Grid' => 'Vérifier la grille',
			'Clear Moves' => 'Effacer les coups',
			'Calculate' => 'Calculer',
			'Launch' => 'Lancer',
			'Left' => 'Gauche',
			'Right' => 'Droite',
			'Up' => 'Haut',
			'Down' => 'Bas',
			'Move up' => 'Aller vers le haut',
			'Move left' => 'Aller à gauche',
			'Move down' => 'Aller vers le bas',
			'Move right' => 'Aller à droite',
			'Controls' => 'Commandes',
			'Actions' => 'Actions',
			'Towers' => 'Tours',
			'Pick Arrow' => 'Choisir flèche',
			'Pick Cannon' => 'Choisir canon',
			'Pick Frost' => 'Choisir gel',
			'Fruit Bin' => 'Bac à fruits',
			'Trash Bin' => 'Poubelle',
			'Compost Bin' => 'Bac à compost',
			'Water Tank' => 'Réservoir d’eau',
			'New Game' => 'Nouvelle partie',
			'Buy' => 'Acheter',
			'Next Day' => 'Jour suivant',
			'Manager Info' => 'Infos du manager',
			'Shop Upgrades' => 'Améliorations de boutique',
			'Learning Signals' => 'Signaux d’apprentissage',
			'Coach Traits' => 'Traits du coach',
			'Training Log' => 'Journal d’entraînement',
			'Restart Training' => 'Redémarrer l’entraînement',
			'Select an operation.' => 'Choisis une opération.',
			'Please enter a valid first number.' => 'Entre un premier nombre valide.',
			'Please enter a valid second number.' => 'Entre un deuxième nombre valide.',
			'Cannot divide by zero.' => 'Impossible de diviser par zéro.',
			'Cannot take the square root of a negative number.' => 'Impossible de prendre la racine carrée d’un nombre négatif.',
			'No answers yet.' => 'Aucune réponse pour l’instant.',
			'Game finished' => 'Partie terminée',
			'Finished' => 'Terminé',
			'Perfect Balance' => 'Équilibre parfait',
			'Correct bin.' => 'Bon bac.',
			'Classify the bug.' => 'Classe l’insecte.',
			'Classify the bugs before time runs out.' => 'Classe les insectes avant la fin du temps.',
			'You lost all lives. Press Start.' => 'Tu as perdu toutes tes vies. Appuie sur Démarrer.',
			'Press Start.' => 'Appuie sur Démarrer.',
			'Press Start to begin.' => 'Appuie sur Démarrer pour commencer.',
			'Life lost. Launch again.' => 'Vie perdue. Relance.',
			'Game over. Press R or Restart.' => 'Partie terminée. Appuie sur R ou Redémarrer.',
			'Break every brick.' => 'Casse toutes les briques.',
			'You beat all 1000 levels!' => 'Tu as terminé les 1000 niveaux !',
			'Great run! Keep the pattern going.' => 'Belle série ! Continue le motif.',
			'Action logged. Try for a longer chain.' => 'Action enregistrée. Essaie une chaîne plus longue.',
			'Correct balloon!' => 'Bon ballon !',
			'Wrong balloon.' => 'Mauvais ballon.',
			'Pop the correct balloons.' => 'Éclate les bons ballons.',
		),
		'es-mx' => array(
			'New Puzzle' => 'Nuevo rompecabezas',
			'Check Grid' => 'Revisar cuadrícula',
			'Clear Moves' => 'Borrar movimientos',
			'Calculate' => 'Calcular',
			'Launch' => 'Lanzar',
			'Left' => 'Izquierda',
			'Right' => 'Derecha',
			'Up' => 'Arriba',
			'Down' => 'Abajo',
			'Move up' => 'Mover arriba',
			'Move left' => 'Mover a la izquierda',
			'Move down' => 'Mover abajo',
			'Move right' => 'Mover a la derecha',
			'Controls' => 'Controles',
			'Actions' => 'Acciones',
			'Towers' => 'Torres',
			'Pick Arrow' => 'Elegir flecha',
			'Pick Cannon' => 'Elegir cañón',
			'Pick Frost' => 'Elegir hielo',
			'Fruit Bin' => 'Contenedor de fruta',
			'Trash Bin' => 'Contenedor de basura',
			'Compost Bin' => 'Contenedor de composta',
			'Water Tank' => 'Tanque de agua',
			'New Game' => 'Nuevo juego',
			'Buy' => 'Comprar',
			'Next Day' => 'Siguiente día',
			'Manager Info' => 'Información del mánager',
			'Shop Upgrades' => 'Mejoras de tienda',
			'Learning Signals' => 'Señales de aprendizaje',
			'Coach Traits' => 'Rasgos del entrenador',
			'Training Log' => 'Registro de entrenamiento',
			'Restart Training' => 'Reiniciar entrenamiento',
			'Select an operation.' => 'Elige una operación.',
			'Please enter a valid first number.' => 'Escribe un primer número válido.',
			'Please enter a valid second number.' => 'Escribe un segundo número válido.',
			'Cannot divide by zero.' => 'No se puede dividir entre cero.',
			'Cannot take the square root of a negative number.' => 'No se puede sacar raíz cuadrada de un número negativo.',
			'No answers yet.' => 'Todavía no hay respuestas.',
			'Game finished' => 'Juego terminado',
			'Finished' => 'Terminado',
			'Perfect Balance' => 'Equilibrio perfecto',
			'Correct bin.' => 'Contenedor correcto.',
			'Classify the bug.' => 'Clasifica el insecto.',
			'Classify the bugs before time runs out.' => 'Clasifica los insectos antes de que se acabe el tiempo.',
			'You lost all lives. Press Start.' => 'Perdiste todas las vidas. Pulsa Empezar.',
			'Press Start.' => 'Pulsa Empezar.',
			'Press Start to begin.' => 'Pulsa Empezar para comenzar.',
			'Life lost. Launch again.' => 'Vida perdida. Lanza de nuevo.',
			'Game over. Press R or Restart.' => 'Fin del juego. Pulsa R o Reiniciar.',
			'Break every brick.' => 'Rompe todos los bloques.',
			'You beat all 1000 levels!' => '¡Superaste los 1000 niveles!',
			'Great run! Keep the pattern going.' => '¡Buena racha! Mantén el patrón.',
			'Action logged. Try for a longer chain.' => 'Acción registrada. Intenta una cadena más larga.',
			'Correct balloon!' => '¡Globo correcto!',
			'Wrong balloon.' => 'Globo incorrecto.',
			'Pop the correct balloons.' => 'Revienta los globos correctos.',
		),
		'es-es' => array(
			'New Puzzle' => 'Nuevo puzle',
			'Check Grid' => 'Comprobar cuadrícula',
			'Clear Moves' => 'Borrar movimientos',
			'Calculate' => 'Calcular',
			'Launch' => 'Lanzar',
			'Left' => 'Izquierda',
			'Right' => 'Derecha',
			'Up' => 'Arriba',
			'Down' => 'Abajo',
			'Move up' => 'Mover arriba',
			'Move left' => 'Mover a la izquierda',
			'Move down' => 'Mover abajo',
			'Move right' => 'Mover a la derecha',
			'Controls' => 'Controles',
			'Actions' => 'Acciones',
			'Towers' => 'Torres',
			'Pick Arrow' => 'Elegir flecha',
			'Pick Cannon' => 'Elegir cañón',
			'Pick Frost' => 'Elegir hielo',
			'Fruit Bin' => 'Contenedor de fruta',
			'Trash Bin' => 'Contenedor de basura',
			'Compost Bin' => 'Contenedor de compost',
			'Water Tank' => 'Tanque de agua',
			'New Game' => 'Nuevo juego',
			'Buy' => 'Comprar',
			'Next Day' => 'Día siguiente',
			'Manager Info' => 'Información del mánager',
			'Shop Upgrades' => 'Mejoras de tienda',
			'Learning Signals' => 'Señales de aprendizaje',
			'Coach Traits' => 'Rasgos del entrenador',
			'Training Log' => 'Registro de entrenamiento',
			'Restart Training' => 'Reiniciar entrenamiento',
			'Select an operation.' => 'Elige una operación.',
			'Please enter a valid first number.' => 'Introduce un primer número válido.',
			'Please enter a valid second number.' => 'Introduce un segundo número válido.',
			'Cannot divide by zero.' => 'No se puede dividir entre cero.',
			'Cannot take the square root of a negative number.' => 'No se puede sacar la raíz cuadrada de un número negativo.',
			'No answers yet.' => 'Todavía no hay respuestas.',
			'Game finished' => 'Juego terminado',
			'Finished' => 'Terminado',
			'Perfect Balance' => 'Equilibrio perfecto',
			'Correct bin.' => 'Contenedor correcto.',
			'Classify the bug.' => 'Clasifica el insecto.',
			'Classify the bugs before time runs out.' => 'Clasifica los insectos antes de que se acabe el tiempo.',
			'You lost all lives. Press Start.' => 'Has perdido todas las vidas. Pulsa Empezar.',
			'Press Start.' => 'Pulsa Empezar.',
			'Press Start to begin.' => 'Pulsa Empezar para empezar.',
			'Life lost. Launch again.' => 'Vida perdida. Lanza de nuevo.',
			'Game over. Press R or Restart.' => 'Fin del juego. Pulsa R o Reiniciar.',
			'Break every brick.' => 'Rompe todos los bloques.',
			'You beat all 1000 levels!' => '¡Has superado los 1000 niveles!',
			'Great run! Keep the pattern going.' => '¡Buena racha! Mantén el patrón.',
			'Action logged. Try for a longer chain.' => 'Acción registrada. Intenta una cadena más larga.',
			'Correct balloon!' => '¡Globo correcto!',
			'Wrong balloon.' => 'Globo incorrecto.',
			'Pop the correct balloons.' => 'Revienta los globos correctos.',
		),
	);

	foreach ($shared_game_exact as $shared_lang => $shared_items) {
		if (isset($translations[$shared_lang])) {
			$translations[$shared_lang] = array_merge($translations[$shared_lang], $shared_items);
		}
	}

	$panel_control_exact = array(
		'tr' => array(
			'How It Works' => 'Nasıl Çalışır',
			'What Towers Do' => 'Kuleler Ne Yapar',
			'Send Units' => 'Birim Gönder',
			'Enemy Units' => 'Düşman Birimleri',
			'Battle Log' => 'Savaş Günlüğü',
			'Rescue Grid' => 'Kurtarma Izgarası',
			'Reset Sector' => 'Bölümü Sıfırla',
			'Next Sector' => 'Sonraki Bölüm',
			'Reveal Treasure' => 'Hazineyi Göster',
			'TREASURE' => 'HAZİNE',
			'TRAP' => 'TUZAK',
			'Chest' => 'Sandık',
			'Past' => 'Geçmiş',
			'Future' => 'Gelecek',
			'Your Ladder' => 'Merdivenin',
			'Undo' => 'Geri Al',
			'Change 1st' => '1.yi Değiştir',
			'Change 2nd' => '2.yi Değiştir',
			'Change 3rd' => '3.yü Değiştir',
			'More Enemies' => 'Daha Fazla Düşman',
			'Work For Money' => 'Para İçin Çalış',
			'Toggle Top Path' => 'Üst Yolu Aç/Kapat',
			'Toggle Bottom Path' => 'Alt Yolu Aç/Kapat',
			'Basic' => 'Temel',
			'Sniper' => 'Keskin Nişancı',
			'Freeze' => 'Dondur',
			'Poison' => 'Zehir',
			'Bank' => 'Banka',
			'Attack' => 'Saldır',
			'Shield' => 'Kalkan',
			'Hack' => 'Hackle',
			'Appeal' => 'İtiraz Et',
		),
		'de' => array(
			'How It Works' => 'So funktioniert es',
			'What Towers Do' => 'Was Türme tun',
			'Send Units' => 'Einheiten senden',
			'Enemy Units' => 'Gegnerische Einheiten',
			'Battle Log' => 'Kampfprotokoll',
			'Rescue Grid' => 'Rettungsraster',
			'Reset Sector' => 'Sektor zurücksetzen',
			'Next Sector' => 'Nächster Sektor',
			'Reveal Treasure' => 'Schatz zeigen',
			'TREASURE' => 'SCHATZ',
			'TRAP' => 'FALLE',
			'Chest' => 'Truhe',
			'Past' => 'Vergangenheit',
			'Future' => 'Zukunft',
			'Your Ladder' => 'Deine Leiter',
			'Undo' => 'Rückgängig',
			'Change 1st' => '1. ändern',
			'Change 2nd' => '2. ändern',
			'Change 3rd' => '3. ändern',
			'More Enemies' => 'Mehr Gegner',
			'Work For Money' => 'Für Geld arbeiten',
			'Toggle Top Path' => 'Oberen Weg umschalten',
			'Toggle Bottom Path' => 'Unteren Weg umschalten',
			'Basic' => 'Basis',
			'Sniper' => 'Scharfschütze',
			'Freeze' => 'Frost',
			'Poison' => 'Gift',
			'Bank' => 'Bank',
			'Attack' => 'Angriff',
			'Shield' => 'Schild',
			'Hack' => 'Hack',
			'Appeal' => 'Appell',
		),
		'fr' => array(
			'How It Works' => 'Comment ça marche',
			'What Towers Do' => 'Ce que font les tours',
			'Send Units' => 'Envoyer des unités',
			'Enemy Units' => 'Unités ennemies',
			'Battle Log' => 'Journal de combat',
			'Rescue Grid' => 'Grille de sauvetage',
			'Reset Sector' => 'Réinitialiser le secteur',
			'Next Sector' => 'Secteur suivant',
			'Reveal Treasure' => 'Révéler le trésor',
			'TREASURE' => 'TRÉSOR',
			'TRAP' => 'PIÈGE',
			'Chest' => 'Coffre',
			'Past' => 'Passé',
			'Future' => 'Futur',
			'Your Ladder' => 'Ton échelle',
			'Undo' => 'Annuler',
			'Change 1st' => 'Changer le 1er',
			'Change 2nd' => 'Changer le 2e',
			'Change 3rd' => 'Changer le 3e',
			'More Enemies' => 'Plus d’ennemis',
			'Work For Money' => 'Travailler pour de l’argent',
			'Toggle Top Path' => 'Basculer le chemin du haut',
			'Toggle Bottom Path' => 'Basculer le chemin du bas',
			'Basic' => 'Basique',
			'Sniper' => 'Sniper',
			'Freeze' => 'Gel',
			'Poison' => 'Poison',
			'Bank' => 'Banque',
			'Attack' => 'Attaque',
			'Shield' => 'Bouclier',
			'Hack' => 'Pirater',
			'Appeal' => 'Appel',
		),
		'es-mx' => array(
			'How It Works' => 'Cómo funciona',
			'What Towers Do' => 'Qué hacen las torres',
			'Send Units' => 'Enviar unidades',
			'Enemy Units' => 'Unidades enemigas',
			'Battle Log' => 'Registro de batalla',
			'Rescue Grid' => 'Cuadrícula de rescate',
			'Reset Sector' => 'Reiniciar sector',
			'Next Sector' => 'Siguiente sector',
			'Reveal Treasure' => 'Revelar tesoro',
			'TREASURE' => 'TESORO',
			'TRAP' => 'TRAMPA',
			'Chest' => 'Cofre',
			'Past' => 'Pasado',
			'Future' => 'Futuro',
			'Your Ladder' => 'Tu escalera',
			'Undo' => 'Deshacer',
			'Change 1st' => 'Cambiar 1.º',
			'Change 2nd' => 'Cambiar 2.º',
			'Change 3rd' => 'Cambiar 3.º',
			'More Enemies' => 'Más enemigos',
			'Work For Money' => 'Trabajar por dinero',
			'Toggle Top Path' => 'Alternar camino superior',
			'Toggle Bottom Path' => 'Alternar camino inferior',
			'Basic' => 'Básico',
			'Sniper' => 'Francotirador',
			'Freeze' => 'Congelar',
			'Poison' => 'Veneno',
			'Bank' => 'Banco',
			'Attack' => 'Atacar',
			'Shield' => 'Escudo',
			'Hack' => 'Hackear',
			'Appeal' => 'Apelar',
		),
		'es-es' => array(
			'How It Works' => 'Cómo funciona',
			'What Towers Do' => 'Qué hacen las torres',
			'Send Units' => 'Enviar unidades',
			'Enemy Units' => 'Unidades enemigas',
			'Battle Log' => 'Registro de batalla',
			'Rescue Grid' => 'Cuadrícula de rescate',
			'Reset Sector' => 'Reiniciar sector',
			'Next Sector' => 'Siguiente sector',
			'Reveal Treasure' => 'Revelar tesoro',
			'TREASURE' => 'TESORO',
			'TRAP' => 'TRAMPA',
			'Chest' => 'Cofre',
			'Past' => 'Pasado',
			'Future' => 'Futuro',
			'Your Ladder' => 'Tu escalera',
			'Undo' => 'Deshacer',
			'Change 1st' => 'Cambiar 1.º',
			'Change 2nd' => 'Cambiar 2.º',
			'Change 3rd' => 'Cambiar 3.º',
			'More Enemies' => 'Más enemigos',
			'Work For Money' => 'Trabajar por dinero',
			'Toggle Top Path' => 'Alternar camino superior',
			'Toggle Bottom Path' => 'Alternar camino inferior',
			'Basic' => 'Básico',
			'Sniper' => 'Francotirador',
			'Freeze' => 'Congelar',
			'Poison' => 'Veneno',
			'Bank' => 'Banco',
			'Attack' => 'Atacar',
			'Shield' => 'Escudo',
			'Hack' => 'Hackear',
			'Appeal' => 'Apelar',
		),
	);

	foreach ($panel_control_exact as $panel_lang => $panel_items) {
		if (isset($translations[$panel_lang])) {
			$translations[$panel_lang] = array_merge($translations[$panel_lang], $panel_items);
		}
	}

	$extra_runtime_exact = array(
		'tr' => array(
			'Your robot helper is waiting for its first lesson.' => 'Robot yardımcın ilk dersini bekliyor.',
			'Choose the best move for this round.' => 'Bu tur için en iyi hamleyi seç.',
			'Nice coaching.' => 'Güzel koçluk.',
			'That choice teaches a risky habit.' => 'Bu seçim riskli bir alışkanlık öğretir.',
			'Training finished. Review the summary and restart for a new run.' => 'Eğitim bitti. Özeti incele ve yeni deneme için yeniden başlat.',
			'Decode the message by replacing each cipher letter with the correct plain letter.' => 'Her şifreli harfi doğru normal harfle değiştirerek mesajı çöz.',
			'Write your decoded phrase first.' => 'Önce çözdüğün cümleyi yaz.',
			'Correct! You cracked the cryptogram. Great job!' => 'Doğru! Şifreyi çözdün. Harika iş!',
			'Not quite yet. Check your letters and try again.' => 'Henüz değil. Harflerini kontrol et ve tekrar dene.',
			'Here is the decoded phrase.' => 'Çözülmüş cümle burada.',
			'Watch the sequence.' => 'Sırayı izle.',
			'Now repeat.' => 'Şimdi tekrar et.',
			'Correct! Next level.' => 'Doğru! Sonraki seviye.',
			'Box' => 'Kutu',
			'Duck found' => 'Ördek bulundu',
			'No duck' => 'Ördek yok',
			'Switch World' => 'Dünya Değiştir',
			'Check' => 'Kontrol Et',
			'Replay' => 'Tekrar Göster',
			'Advertise $20' => 'Reklam Ver $20',
			'Reset Scores' => 'Puanları Sıfırla',
			'Reset Unlocks' => 'Açılanları Sıfırla',
			'Close' => 'Kapat',
			'Sound Off' => 'Ses Kapalı',
			'Parent Menu' => 'Ebeveyn Menüsü',
			'Start Match' => 'Maçı Başlat',
			'Press Start Match' => 'Maçı Başlat’a bas',
			'Speed' => 'Hız',
			'Smartness' => 'Zeka',
			'Shooting' => 'Şut',
			'Passing' => 'Pas',
			'Defense' => 'Savunma',
			'Stopped' => 'Durdu',
		),
		'de' => array(
			'Your robot helper is waiting for its first lesson.' => 'Dein Roboterhelfer wartet auf seine erste Lektion.',
			'Choose the best move for this round.' => 'Wähle den besten Zug für diese Runde.',
			'Nice coaching.' => 'Gutes Coaching.',
			'That choice teaches a risky habit.' => 'Diese Wahl lehrt eine riskante Gewohnheit.',
			'Training finished. Review the summary and restart for a new run.' => 'Training beendet. Sieh dir die Zusammenfassung an und starte neu.',
			'Decode the message by replacing each cipher letter with the correct plain letter.' => 'Entschlüssle die Nachricht, indem du jeden Geheimtext-Buchstaben ersetzt.',
			'Write your decoded phrase first.' => 'Schreibe zuerst deinen entschlüsselten Satz.',
			'Correct! You cracked the cryptogram. Great job!' => 'Richtig! Du hast das Kryptogramm geknackt. Gut gemacht!',
			'Not quite yet. Check your letters and try again.' => 'Noch nicht ganz. Prüfe deine Buchstaben und versuche es erneut.',
			'Here is the decoded phrase.' => 'Hier ist der entschlüsselte Satz.',
			'Watch the sequence.' => 'Merke dir die Reihenfolge.',
			'Now repeat.' => 'Jetzt wiederholen.',
			'Correct! Next level.' => 'Richtig! Nächstes Level.',
			'Box' => 'Kiste',
			'Duck found' => 'Ente gefunden',
			'No duck' => 'Keine Ente',
			'Switch World' => 'Welt wechseln',
			'Check' => 'Prüfen',
			'Replay' => 'Wiederholen',
			'Advertise $20' => 'Werben $20',
			'Reset Scores' => 'Punkte zurücksetzen',
			'Reset Unlocks' => 'Freischaltungen zurücksetzen',
			'Close' => 'Schließen',
			'Sound Off' => 'Ton aus',
			'Parent Menu' => 'Elternmenü',
			'Start Match' => 'Spiel starten',
			'Press Start Match' => 'Drücke Spiel starten',
			'Speed' => 'Tempo',
			'Smartness' => 'Klugheit',
			'Shooting' => 'Schuss',
			'Passing' => 'Passspiel',
			'Defense' => 'Abwehr',
			'Stopped' => 'Gestoppt',
		),
		'fr' => array(
			'Your robot helper is waiting for its first lesson.' => 'Ton assistant robot attend sa première leçon.',
			'Choose the best move for this round.' => 'Choisis le meilleur coup pour cette manche.',
			'Nice coaching.' => 'Bon coaching.',
			'That choice teaches a risky habit.' => 'Ce choix enseigne une habitude risquée.',
			'Training finished. Review the summary and restart for a new run.' => 'Entraînement terminé. Regarde le résumé puis recommence.',
			'Decode the message by replacing each cipher letter with the correct plain letter.' => 'Décode le message en remplaçant chaque lettre chiffrée par la bonne lettre.',
			'Write your decoded phrase first.' => 'Écris d’abord ta phrase décodée.',
			'Correct! You cracked the cryptogram. Great job!' => 'Correct ! Tu as résolu le cryptogramme. Bravo !',
			'Not quite yet. Check your letters and try again.' => 'Pas encore. Vérifie tes lettres et réessaie.',
			'Here is the decoded phrase.' => 'Voici la phrase décodée.',
			'Watch the sequence.' => 'Observe la séquence.',
			'Now repeat.' => 'Maintenant répète.',
			'Correct! Next level.' => 'Correct ! Niveau suivant.',
			'Box' => 'Boîte',
			'Duck found' => 'Canard trouvé',
			'No duck' => 'Pas de canard',
			'Switch World' => 'Changer de monde',
			'Check' => 'Vérifier',
			'Replay' => 'Rejouer',
			'Advertise $20' => 'Publicité $20',
			'Reset Scores' => 'Réinitialiser les scores',
			'Reset Unlocks' => 'Réinitialiser les déblocages',
			'Close' => 'Fermer',
			'Sound Off' => 'Son coupé',
			'Parent Menu' => 'Menu parent',
			'Start Match' => 'Démarrer le match',
			'Press Start Match' => 'Appuie sur Démarrer le match',
			'Speed' => 'Vitesse',
			'Smartness' => 'Intelligence',
			'Shooting' => 'Tir',
			'Passing' => 'Passe',
			'Defense' => 'Défense',
			'Stopped' => 'Arrêté',
		),
		'es-mx' => array(
			'Your robot helper is waiting for its first lesson.' => 'Tu robot ayudante espera su primera lección.',
			'Choose the best move for this round.' => 'Elige el mejor movimiento para esta ronda.',
			'Nice coaching.' => 'Buen entrenamiento.',
			'That choice teaches a risky habit.' => 'Esa elección enseña un hábito riesgoso.',
			'Training finished. Review the summary and restart for a new run.' => 'Entrenamiento terminado. Revisa el resumen y reinicia.',
			'Decode the message by replacing each cipher letter with the correct plain letter.' => 'Decodifica el mensaje reemplazando cada letra cifrada por la correcta.',
			'Write your decoded phrase first.' => 'Primero escribe tu frase decodificada.',
			'Correct! You cracked the cryptogram. Great job!' => '¡Correcto! Resolviste el criptograma. ¡Buen trabajo!',
			'Not quite yet. Check your letters and try again.' => 'Todavía no. Revisa tus letras e intenta otra vez.',
			'Here is the decoded phrase.' => 'Aquí está la frase decodificada.',
			'Watch the sequence.' => 'Observa la secuencia.',
			'Now repeat.' => 'Ahora repite.',
			'Correct! Next level.' => '¡Correcto! Siguiente nivel.',
			'Box' => 'Caja',
			'Duck found' => 'Pato encontrado',
			'No duck' => 'Sin pato',
			'Switch World' => 'Cambiar mundo',
			'Check' => 'Revisar',
			'Replay' => 'Repetir',
			'Advertise $20' => 'Anunciar $20',
			'Reset Scores' => 'Reiniciar puntuaciones',
			'Reset Unlocks' => 'Reiniciar desbloqueos',
			'Close' => 'Cerrar',
			'Sound Off' => 'Sonido apagado',
			'Parent Menu' => 'Menú de padres',
			'Start Match' => 'Empezar partido',
			'Press Start Match' => 'Pulsa Empezar partido',
			'Speed' => 'Velocidad',
			'Smartness' => 'Inteligencia',
			'Shooting' => 'Tiro',
			'Passing' => 'Pase',
			'Defense' => 'Defensa',
			'Stopped' => 'Detenido',
		),
		'es-es' => array(
			'Your robot helper is waiting for its first lesson.' => 'Tu robot ayudante espera su primera lección.',
			'Choose the best move for this round.' => 'Elige el mejor movimiento para esta ronda.',
			'Nice coaching.' => 'Buen entrenamiento.',
			'That choice teaches a risky habit.' => 'Esa elección enseña un hábito arriesgado.',
			'Training finished. Review the summary and restart for a new run.' => 'Entrenamiento terminado. Revisa el resumen y reinicia.',
			'Decode the message by replacing each cipher letter with the correct plain letter.' => 'Decodifica el mensaje sustituyendo cada letra cifrada por la correcta.',
			'Write your decoded phrase first.' => 'Primero escribe tu frase decodificada.',
			'Correct! You cracked the cryptogram. Great job!' => '¡Correcto! Has resuelto el criptograma. ¡Buen trabajo!',
			'Not quite yet. Check your letters and try again.' => 'Todavía no. Revisa tus letras e inténtalo otra vez.',
			'Here is the decoded phrase.' => 'Aquí está la frase decodificada.',
			'Watch the sequence.' => 'Observa la secuencia.',
			'Now repeat.' => 'Ahora repite.',
			'Correct! Next level.' => '¡Correcto! Siguiente nivel.',
			'Box' => 'Caja',
			'Duck found' => 'Pato encontrado',
			'No duck' => 'Sin pato',
			'Switch World' => 'Cambiar mundo',
			'Check' => 'Comprobar',
			'Replay' => 'Repetir',
			'Advertise $20' => 'Anunciar $20',
			'Reset Scores' => 'Reiniciar puntuaciones',
			'Reset Unlocks' => 'Reiniciar desbloqueos',
			'Close' => 'Cerrar',
			'Sound Off' => 'Sonido apagado',
			'Parent Menu' => 'Menú parental',
			'Start Match' => 'Empezar partido',
			'Press Start Match' => 'Pulsa Empezar partido',
			'Speed' => 'Velocidad',
			'Smartness' => 'Inteligencia',
			'Shooting' => 'Tiro',
			'Passing' => 'Pase',
			'Defense' => 'Defensa',
			'Stopped' => 'Detenido',
		),
	);

	foreach ($extra_runtime_exact as $extra_lang => $extra_items) {
		if (isset($translations[$extra_lang])) {
			$translations[$extra_lang] = array_merge($translations[$extra_lang], $extra_items);
		}
	}

	$remaining_status_exact = array(
		'tr' => array(
			'You might beat the AI this time.' => 'Bu sefer yapay zekayı yenebilirsin.',
			'Round 1. The AI looks beatable.' => 'Tur 1. Yapay zeka yenilebilir görünüyor.',
			'Defeat is complete.' => 'Yenilgi tamamlandı.',
			'It feels worse now.' => 'Artık daha kötü hissettiriyor.',
			'The joke is the setup. The first rounds make it look possible. Then the AI learns too fast and the result becomes fixed.' => 'Şaka kurulumda. İlk turlar mümkün gibi gösterir. Sonra yapay zeka çok hızlı öğrenir ve sonuç sabitlenir.',
			'You found the hidden stars.' => 'Gizli yıldızları buldun.',
			'You win.' => 'Kazandın.',
			'Try again and catch more stars.' => 'Tekrar dene ve daha fazla yıldız yakala.',
			'Nice catch.' => 'Güzel yakalama.',
			'Too slow. Watch for the next one.' => 'Çok yavaş. Sonrakini bekle.',
			'Private game. Embed directly where you want it.' => 'Özel oyun. İstediğin yere doğrudan yerleştir.',
			'Rule check: looking good so far.' => 'Kural kontrolü: Şimdilik iyi görünüyor.',
			'Rule check: 1 row or column rule is currently broken.' => 'Kural kontrolü: Şu anda 1 satır veya sütun kuralı bozuk.',
			'Build the combo!' => 'Komboyu kur!',
			'Combo Complete! You Win!' => 'Kombo tamam! Kazandın!',
			'Wrong combo! Try again.' => 'Yanlış kombo! Tekrar dene.',
		),
		'de' => array(
			'You might beat the AI this time.' => 'Diesmal könntest du die KI schlagen.',
			'Round 1. The AI looks beatable.' => 'Runde 1. Die KI wirkt schlagbar.',
			'Defeat is complete.' => 'Die Niederlage ist vollständig.',
			'It feels worse now.' => 'Jetzt fühlt es sich schlimmer an.',
			'The joke is the setup. The first rounds make it look possible. Then the AI learns too fast and the result becomes fixed.' => 'Der Witz liegt im Aufbau. Die ersten Runden wirken möglich. Dann lernt die KI zu schnell und das Ergebnis steht fest.',
			'You found the hidden stars.' => 'Du hast die versteckten Sterne gefunden.',
			'You win.' => 'Du gewinnst.',
			'Try again and catch more stars.' => 'Versuche es erneut und fange mehr Sterne.',
			'Nice catch.' => 'Gut gefangen.',
			'Too slow. Watch for the next one.' => 'Zu langsam. Achte auf den nächsten.',
			'Private game. Embed directly where you want it.' => 'Privates Spiel. Direkt dort einbetten, wo du es möchtest.',
			'Rule check: looking good so far.' => 'Regelprüfung: bisher sieht es gut aus.',
			'Rule check: 1 row or column rule is currently broken.' => 'Regelprüfung: 1 Zeilen- oder Spaltenregel ist gerade verletzt.',
			'Build the combo!' => 'Baue die Kombo!',
			'Combo Complete! You Win!' => 'Kombo komplett! Du gewinnst!',
			'Wrong combo! Try again.' => 'Falsche Kombo! Versuche es erneut.',
		),
		'fr' => array(
			'You might beat the AI this time.' => 'Tu pourrais battre l’IA cette fois.',
			'Round 1. The AI looks beatable.' => 'Manche 1. L’IA semble battable.',
			'Defeat is complete.' => 'La défaite est complète.',
			'It feels worse now.' => 'Ça semble pire maintenant.',
			'The joke is the setup. The first rounds make it look possible. Then the AI learns too fast and the result becomes fixed.' => 'La blague vient du piège. Les premières manches semblent possibles. Puis l’IA apprend trop vite et le résultat devient fixe.',
			'You found the hidden stars.' => 'Tu as trouvé les étoiles cachées.',
			'You win.' => 'Tu gagnes.',
			'Try again and catch more stars.' => 'Réessaie et attrape plus d’étoiles.',
			'Nice catch.' => 'Belle prise.',
			'Too slow. Watch for the next one.' => 'Trop lent. Surveille la suivante.',
			'Private game. Embed directly where you want it.' => 'Jeu privé. Intègre-le directement où tu veux.',
			'Rule check: looking good so far.' => 'Vérification des règles : tout va bien pour l’instant.',
			'Rule check: 1 row or column rule is currently broken.' => 'Vérification des règles : 1 règle de ligne ou colonne est cassée.',
			'Build the combo!' => 'Construis le combo !',
			'Combo Complete! You Win!' => 'Combo terminé ! Tu gagnes !',
			'Wrong combo! Try again.' => 'Mauvais combo ! Réessaie.',
		),
		'es-mx' => array(
			'You might beat the AI this time.' => 'Tal vez esta vez le ganes a la IA.',
			'Round 1. The AI looks beatable.' => 'Ronda 1. La IA parece vencible.',
			'Defeat is complete.' => 'La derrota está completa.',
			'It feels worse now.' => 'Ahora se siente peor.',
			'The joke is the setup. The first rounds make it look possible. Then the AI learns too fast and the result becomes fixed.' => 'La broma está en la preparación. Las primeras rondas parecen posibles. Luego la IA aprende demasiado rápido y el resultado queda fijo.',
			'You found the hidden stars.' => 'Encontraste las estrellas ocultas.',
			'You win.' => 'Ganaste.',
			'Try again and catch more stars.' => 'Intenta de nuevo y atrapa más estrellas.',
			'Nice catch.' => 'Buena atrapada.',
			'Too slow. Watch for the next one.' => 'Muy lento. Mira la siguiente.',
			'Private game. Embed directly where you want it.' => 'Juego privado. Insértalo directamente donde quieras.',
			'Rule check: looking good so far.' => 'Revisión de reglas: todo va bien hasta ahora.',
			'Rule check: 1 row or column rule is currently broken.' => 'Revisión de reglas: hay 1 regla de fila o columna rota.',
			'Build the combo!' => '¡Arma el combo!',
			'Combo Complete! You Win!' => '¡Combo completo! ¡Ganaste!',
			'Wrong combo! Try again.' => '¡Combo incorrecto! Intenta de nuevo.',
		),
		'es-es' => array(
			'You might beat the AI this time.' => 'Quizá esta vez ganes a la IA.',
			'Round 1. The AI looks beatable.' => 'Ronda 1. La IA parece vencible.',
			'Defeat is complete.' => 'La derrota está completa.',
			'It feels worse now.' => 'Ahora se siente peor.',
			'The joke is the setup. The first rounds make it look possible. Then the AI learns too fast and the result becomes fixed.' => 'La broma está en la preparación. Las primeras rondas parecen posibles. Luego la IA aprende demasiado rápido y el resultado queda fijo.',
			'You found the hidden stars.' => 'Has encontrado las estrellas ocultas.',
			'You win.' => 'Has ganado.',
			'Try again and catch more stars.' => 'Inténtalo de nuevo y atrapa más estrellas.',
			'Nice catch.' => 'Buena captura.',
			'Too slow. Watch for the next one.' => 'Demasiado lento. Mira la siguiente.',
			'Private game. Embed directly where you want it.' => 'Juego privado. Insértalo directamente donde quieras.',
			'Rule check: looking good so far.' => 'Comprobación de reglas: todo va bien por ahora.',
			'Rule check: 1 row or column rule is currently broken.' => 'Comprobación de reglas: hay 1 regla de fila o columna rota.',
			'Build the combo!' => '¡Construye el combo!',
			'Combo Complete! You Win!' => '¡Combo completo! ¡Has ganado!',
			'Wrong combo! Try again.' => '¡Combo incorrecto! Inténtalo de nuevo.',
		),
	);

	foreach ($remaining_status_exact as $status_lang => $status_items) {
		if (isset($translations[$status_lang])) {
			$translations[$status_lang] = array_merge($translations[$status_lang], $status_items);
		}
	}

	$agent_runtime_exact = array(
		'tr' => array(
			'AI is thinking...' => 'Yapay zeka düşünüyor...',
			'Black AI is thinking...' => 'Siyah yapay zeka düşünüyor...',
			'You must capture an opponent piece.' => 'Rakip taşını almalısın.',
			'Capture is required. Choose an orange move.' => 'Taş alma zorunlu. Turuncu bir hamle seç.',
			'Keep capturing with the same piece.' => 'Aynı taşla almaya devam et.',
			'Select one of your white pieces.' => 'Beyaz taşlarından birini seç.',
			'Your turn. Select a white piece.' => 'Sıra sende. Beyaz bir taş seç.',
			'Pick the number that makes the scale balance.' => 'Teraziyi dengeleyecek sayıyı seç.',
			'Correct. The equation is balanced.' => 'Doğru. Denklem dengelendi.',
			'Answer this round first.' => 'Önce bu turu cevapla.',
			'Fill the empty squares with 0 or 1.' => 'Boş kareleri 0 veya 1 ile doldur.',
			'The grid is not full yet. Fill every square first.' => 'Izgara henüz dolu değil. Önce her kareyi doldur.',
			'Almost there. One or more row or column rules are broken.' => 'Neredeyse. Bir veya daha fazla satır ya da sütun kuralı bozuk.',
			'Choose a cell to expand or attack.' => 'Genişlemek veya saldırmak için bir hücre seç.',
			'Use Reinforce' => 'Takviye Kullan',
			'Reinforce available' => 'Takviye hazır',
			'Reinforce used' => 'Takviye kullanıldı',
			'AI wins! Try a different strategy.' => 'Yapay zeka kazandı! Farklı bir strateji dene.',
			'You win! Great territory control.' => 'Kazandın! Harika bölge kontrolü.',
			'Run Over' => 'Deneme Bitti',
			'Restart or buy a stronger fighter from the roster.' => 'Yeniden başlat veya listeden daha güçlü bir savaşçı satın al.',
		),
		'de' => array(
			'AI is thinking...' => 'Die KI denkt nach...',
			'Black AI is thinking...' => 'Die schwarze KI denkt nach...',
			'You must capture an opponent piece.' => 'Du musst eine gegnerische Figur schlagen.',
			'Capture is required. Choose an orange move.' => 'Schlagen ist Pflicht. Wähle einen orangefarbenen Zug.',
			'Keep capturing with the same piece.' => 'Schlage weiter mit derselben Figur.',
			'Select one of your white pieces.' => 'Wähle eine deiner weißen Figuren.',
			'Your turn. Select a white piece.' => 'Du bist dran. Wähle eine weiße Figur.',
			'Pick the number that makes the scale balance.' => 'Wähle die Zahl, die die Waage ausgleicht.',
			'Correct. The equation is balanced.' => 'Richtig. Die Gleichung ist ausgeglichen.',
			'Answer this round first.' => 'Beantworte zuerst diese Runde.',
			'Fill the empty squares with 0 or 1.' => 'Fülle die leeren Felder mit 0 oder 1.',
			'The grid is not full yet. Fill every square first.' => 'Das Raster ist noch nicht voll. Fülle zuerst jedes Feld.',
			'Almost there. One or more row or column rules are broken.' => 'Fast geschafft. Eine oder mehrere Zeilen- oder Spaltenregeln sind verletzt.',
			'Choose a cell to expand or attack.' => 'Wähle eine Zelle zum Erweitern oder Angreifen.',
			'Use Reinforce' => 'Verstärkung nutzen',
			'Reinforce available' => 'Verstärkung verfügbar',
			'Reinforce used' => 'Verstärkung genutzt',
			'AI wins! Try a different strategy.' => 'Die KI gewinnt! Versuche eine andere Strategie.',
			'You win! Great territory control.' => 'Du gewinnst! Starke Gebietskontrolle.',
			'Run Over' => 'Lauf beendet',
			'Restart or buy a stronger fighter from the roster.' => 'Starte neu oder kaufe einen stärkeren Kämpfer aus der Liste.',
		),
		'fr' => array(
			'AI is thinking...' => 'L’IA réfléchit...',
			'Black AI is thinking...' => 'L’IA noire réfléchit...',
			'You must capture an opponent piece.' => 'Tu dois capturer une pièce adverse.',
			'Capture is required. Choose an orange move.' => 'Capture obligatoire. Choisis un coup orange.',
			'Keep capturing with the same piece.' => 'Continue à capturer avec la même pièce.',
			'Select one of your white pieces.' => 'Sélectionne une de tes pièces blanches.',
			'Your turn. Select a white piece.' => 'À toi. Sélectionne une pièce blanche.',
			'Pick the number that makes the scale balance.' => 'Choisis le nombre qui équilibre la balance.',
			'Correct. The equation is balanced.' => 'Correct. L’équation est équilibrée.',
			'Answer this round first.' => 'Réponds d’abord à cette manche.',
			'Fill the empty squares with 0 or 1.' => 'Remplis les cases vides avec 0 ou 1.',
			'The grid is not full yet. Fill every square first.' => 'La grille n’est pas encore pleine. Remplis toutes les cases.',
			'Almost there. One or more row or column rules are broken.' => 'Presque. Une ou plusieurs règles de ligne ou colonne sont cassées.',
			'Choose a cell to expand or attack.' => 'Choisis une case pour t’étendre ou attaquer.',
			'Use Reinforce' => 'Utiliser renfort',
			'Reinforce available' => 'Renfort disponible',
			'Reinforce used' => 'Renfort utilisé',
			'AI wins! Try a different strategy.' => 'L’IA gagne ! Essaie une autre stratégie.',
			'You win! Great territory control.' => 'Tu gagnes ! Excellent contrôle du territoire.',
			'Run Over' => 'Partie terminée',
			'Restart or buy a stronger fighter from the roster.' => 'Redémarre ou achète un combattant plus fort dans la liste.',
		),
		'es-mx' => array(
			'AI is thinking...' => 'La IA está pensando...',
			'Black AI is thinking...' => 'La IA negra está pensando...',
			'You must capture an opponent piece.' => 'Debes capturar una pieza rival.',
			'Capture is required. Choose an orange move.' => 'Debes capturar. Elige un movimiento naranja.',
			'Keep capturing with the same piece.' => 'Sigue capturando con la misma pieza.',
			'Select one of your white pieces.' => 'Selecciona una de tus piezas blancas.',
			'Your turn. Select a white piece.' => 'Tu turno. Selecciona una pieza blanca.',
			'Pick the number that makes the scale balance.' => 'Elige el número que equilibra la balanza.',
			'Correct. The equation is balanced.' => 'Correcto. La ecuación está equilibrada.',
			'Answer this round first.' => 'Primero responde esta ronda.',
			'Fill the empty squares with 0 or 1.' => 'Llena los cuadros vacíos con 0 o 1.',
			'The grid is not full yet. Fill every square first.' => 'La cuadrícula aún no está llena. Llena cada cuadro primero.',
			'Almost there. One or more row or column rules are broken.' => 'Casi. Una o más reglas de fila o columna están rotas.',
			'Choose a cell to expand or attack.' => 'Elige una celda para expandirte o atacar.',
			'Use Reinforce' => 'Usar refuerzo',
			'Reinforce available' => 'Refuerzo disponible',
			'Reinforce used' => 'Refuerzo usado',
			'AI wins! Try a different strategy.' => '¡La IA gana! Prueba otra estrategia.',
			'You win! Great territory control.' => '¡Ganaste! Gran control del territorio.',
			'Run Over' => 'Partida terminada',
			'Restart or buy a stronger fighter from the roster.' => 'Reinicia o compra un luchador más fuerte de la lista.',
		),
		'es-es' => array(
			'AI is thinking...' => 'La IA está pensando...',
			'Black AI is thinking...' => 'La IA negra está pensando...',
			'You must capture an opponent piece.' => 'Debes capturar una pieza rival.',
			'Capture is required. Choose an orange move.' => 'Debes capturar. Elige un movimiento naranja.',
			'Keep capturing with the same piece.' => 'Sigue capturando con la misma pieza.',
			'Select one of your white pieces.' => 'Selecciona una de tus piezas blancas.',
			'Your turn. Select a white piece.' => 'Tu turno. Selecciona una pieza blanca.',
			'Pick the number that makes the scale balance.' => 'Elige el número que equilibra la balanza.',
			'Correct. The equation is balanced.' => 'Correcto. La ecuación está equilibrada.',
			'Answer this round first.' => 'Primero responde a esta ronda.',
			'Fill the empty squares with 0 or 1.' => 'Rellena las casillas vacías con 0 o 1.',
			'The grid is not full yet. Fill every square first.' => 'La cuadrícula aún no está llena. Rellena cada casilla primero.',
			'Almost there. One or more row or column rules are broken.' => 'Casi. Una o más reglas de fila o columna están rotas.',
			'Choose a cell to expand or attack.' => 'Elige una celda para expandirte o atacar.',
			'Use Reinforce' => 'Usar refuerzo',
			'Reinforce available' => 'Refuerzo disponible',
			'Reinforce used' => 'Refuerzo usado',
			'AI wins! Try a different strategy.' => '¡La IA gana! Prueba otra estrategia.',
			'You win! Great territory control.' => '¡Has ganado! Gran control del territorio.',
			'Run Over' => 'Partida terminada',
			'Restart or buy a stronger fighter from the roster.' => 'Reinicia o compra un luchador más fuerte de la lista.',
		),
	);

	$scan_runtime_exact = array(
		'fr' => array(
			'Great run! Keep the pattern going.' => 'Belle série ! Continue le motif.',
			'Action logged. Try for a longer chain.' => 'Action enregistrée. Essaie une chaîne plus longue.',
			'Select an operation.' => 'Sélectionne une opération.',
			'Please enter a valid first number.' => 'Saisis un premier nombre valide.',
			'Please enter a valid second number.' => 'Saisis un deuxième nombre valide.',
			'Cannot divide by zero.' => 'Impossible de diviser par zéro.',
			'Cannot take the square root of a negative number.' => 'Impossible de calculer la racine carrée d’un nombre négatif.',
			'Level 1 ready. Press Space or Launch.' => 'Niveau 1 prêt. Appuie sur Espace ou Lancer.',
			'You beat all 1000 levels!' => 'Tu as terminé les 1000 niveaux !',
			'Break every brick.' => 'Casse toutes les briques.',
			'Paused. Press P to continue.' => 'En pause. Appuie sur P pour continuer.',
			'Game resumed.' => 'Partie reprise.',
			'Game over. Press R or Restart.' => 'Partie terminée. Appuie sur R ou Redémarrer.',
			'Life lost. Launch again.' => 'Vie perdue. Relance la balle.',
			'You claimed a new border cell.' => 'Tu as pris une nouvelle case frontière.',
			'Attack success! You captured enemy territory.' => 'Attaque réussie ! Tu as capturé un territoire ennemi.',
			'Attack failed. The enemy held strong.' => 'Attaque échouée. L’ennemi a résisté.',
			'AI captured territory this turn.' => 'L’IA a capturé un territoire ce tour-ci.',
			'AI attack failed. Your border remains intact.' => 'L’attaque de l’IA a échoué. Ta frontière reste intacte.',
			'AI used reinforce and claimed a neutral border cell.' => 'L’IA a utilisé un renfort et pris une case frontière neutre.',
			'Your turn' => 'À toi',
			'AI turn' => 'Tour de l’IA',
			'No player moves left. AI continues.' => 'Il ne reste aucun coup joueur. L’IA continue.',
			'AI cannot move. Your turn.' => 'L’IA ne peut pas bouger. À toi.',
			"It's a tie! A balanced battle." => 'Égalité ! Combat équilibré.',
			'No neutral border cell available to reinforce.' => 'Aucune case frontière neutre disponible pour le renfort.',
			'Reinforce used! You claimed a border space.' => 'Renfort utilisé ! Tu as pris une case frontière.',
			'Your robot helper is waiting for its first lesson.' => 'Ton robot assistant attend sa première leçon.',
			'Choose the best move for this round.' => 'Choisis le meilleur coup pour cette manche.',
			'Training finished. Review the summary and restart for a new run.' => 'Entraînement terminé. Consulte le résumé et redémarre pour une nouvelle partie.',
		),
		'es-mx' => array(
			'Great run! Keep the pattern going.' => '¡Gran racha! Sigue con el patrón.',
			'Action logged. Try for a longer chain.' => 'Acción registrada. Intenta una cadena más larga.',
			'Select an operation.' => 'Elige una operación.',
			'Please enter a valid first number.' => 'Ingresa un primer número válido.',
			'Please enter a valid second number.' => 'Ingresa un segundo número válido.',
			'Cannot divide by zero.' => 'No se puede dividir entre cero.',
			'Cannot take the square root of a negative number.' => 'No se puede calcular la raíz cuadrada de un número negativo.',
			'Level 1 ready. Press Space or Launch.' => 'Nivel 1 listo. Pulsa Espacio o Lanzar.',
			'You beat all 1000 levels!' => '¡Completaste los 1000 niveles!',
			'Break every brick.' => 'Rompe todos los ladrillos.',
			'Paused. Press P to continue.' => 'Pausado. Pulsa P para continuar.',
			'Game resumed.' => 'Partida reanudada.',
			'Game over. Press R or Restart.' => 'Fin del juego. Pulsa R o Reiniciar.',
			'Life lost. Launch again.' => 'Vida perdida. Lanza de nuevo.',
			'You claimed a new border cell.' => 'Reclamaste una nueva celda de frontera.',
			'Attack success! You captured enemy territory.' => '¡Ataque exitoso! Capturaste territorio enemigo.',
			'Attack failed. The enemy held strong.' => 'El ataque falló. El enemigo resistió.',
			'AI captured territory this turn.' => 'La IA capturó territorio este turno.',
			'AI attack failed. Your border remains intact.' => 'El ataque de la IA falló. Tu frontera sigue intacta.',
			'AI used reinforce and claimed a neutral border cell.' => 'La IA usó refuerzo y reclamó una celda neutral de frontera.',
			'Your turn' => 'Tu turno',
			'AI turn' => 'Turno de la IA',
			'No player moves left. AI continues.' => 'No quedan movimientos del jugador. La IA continúa.',
			'AI cannot move. Your turn.' => 'La IA no puede moverse. Tu turno.',
			"It's a tie! A balanced battle." => '¡Empate! Una batalla equilibrada.',
			'No neutral border cell available to reinforce.' => 'No hay celda neutral de frontera disponible para reforzar.',
			'Reinforce used! You claimed a border space.' => '¡Refuerzo usado! Reclamaste un espacio de frontera.',
			'Your robot helper is waiting for its first lesson.' => 'Tu robot ayudante espera su primera lección.',
			'Choose the best move for this round.' => 'Elige el mejor movimiento para esta ronda.',
			'Training finished. Review the summary and restart for a new run.' => 'Entrenamiento terminado. Revisa el resumen y reinicia para una nueva partida.',
		),
		'es-es' => array(
			'Great run! Keep the pattern going.' => '¡Gran racha! Sigue con el patrón.',
			'Action logged. Try for a longer chain.' => 'Acción registrada. Intenta una cadena más larga.',
			'Select an operation.' => 'Selecciona una operación.',
			'Please enter a valid first number.' => 'Introduce un primer número válido.',
			'Please enter a valid second number.' => 'Introduce un segundo número válido.',
			'Cannot divide by zero.' => 'No se puede dividir por cero.',
			'Cannot take the square root of a negative number.' => 'No se puede calcular la raíz cuadrada de un número negativo.',
			'Level 1 ready. Press Space or Launch.' => 'Nivel 1 listo. Pulsa Espacio o Lanzar.',
			'You beat all 1000 levels!' => '¡Completaste los 1000 niveles!',
			'Break every brick.' => 'Rompe todos los ladrillos.',
			'Paused. Press P to continue.' => 'Pausado. Pulsa P para continuar.',
			'Game resumed.' => 'Partida reanudada.',
			'Game over. Press R or Restart.' => 'Fin del juego. Pulsa R o Reiniciar.',
			'Life lost. Launch again.' => 'Vida perdida. Lanza de nuevo.',
			'You claimed a new border cell.' => 'Has reclamado una nueva celda de frontera.',
			'Attack success! You captured enemy territory.' => '¡Ataque exitoso! Has capturado territorio enemigo.',
			'Attack failed. The enemy held strong.' => 'El ataque ha fallado. El enemigo ha resistido.',
			'AI captured territory this turn.' => 'La IA ha capturado territorio este turno.',
			'AI attack failed. Your border remains intact.' => 'El ataque de la IA ha fallado. Tu frontera sigue intacta.',
			'AI used reinforce and claimed a neutral border cell.' => 'La IA ha usado refuerzo y ha reclamado una celda neutral de frontera.',
			'Your turn' => 'Tu turno',
			'AI turn' => 'Turno de la IA',
			'No player moves left. AI continues.' => 'No quedan movimientos del jugador. La IA continúa.',
			'AI cannot move. Your turn.' => 'La IA no puede moverse. Tu turno.',
			"It's a tie! A balanced battle." => '¡Empate! Una batalla equilibrada.',
			'No neutral border cell available to reinforce.' => 'No hay celda neutral de frontera disponible para reforzar.',
			'Reinforce used! You claimed a border space.' => '¡Refuerzo usado! Has reclamado un espacio de frontera.',
			'Your robot helper is waiting for its first lesson.' => 'Tu robot ayudante espera su primera lección.',
			'Choose the best move for this round.' => 'Elige el mejor movimiento para esta ronda.',
			'Training finished. Review the summary and restart for a new run.' => 'Entrenamiento terminado. Revisa el resumen y reinicia para una nueva partida.',
		),
	);

	foreach ($scan_runtime_exact as $scan_lang => $scan_items) {
		if (isset($translations[$scan_lang])) {
			$translations[$scan_lang] = array_merge($translations[$scan_lang], $scan_items);
		}
	}

	$sitewide_runtime_exact = array(
		'en' => array(
			'Arabalı' => 'Car Game',
			'Başlamak için düğmeye bas' => 'Press the button to start',
			'Skor: ' => 'Score: ',
			'Su: ' => 'Water: ',
			'Seviye: ' => 'Level: ',
			'En iyi su: ' => 'Best water: ',
			'Çöl oyun alanı' => 'Desert game area',
			'Kazandın. Sonraki seviyeye geç.' => 'You won. Go to the next level.',
			'Tekrar Başla' => 'Restart',
			'Sonraki Seviye' => 'Next Level',
			'Kapılar' => 'Doors',
			'Can: ' => 'Lives: ',
			'En iyi: ' => 'Best: ',
			'Oyun bitti. Tekrar oyna.' => 'Game over. Play again.',
			'Doğru kapıyı seç.' => 'Choose the correct door.',
			'Doğru kapı. Hazineyi buldun.' => 'Correct door. You found the treasure.',
			'Yanlış kapı. Tuzak vardı.' => 'Wrong door. There was a trap.',
			'Mısır tapınağında sekiz kapı var. Sadece birinde hazine var. Doğru kapıyı seç ve ilerle.' => 'There are eight doors in the Egyptian temple. Only one has treasure. Choose the correct door and move forward.',
			'Her turda sadece bir kapı güvenlidir. Yanlış seçimde can kaybedersin.' => 'Only one door is safe each round. A wrong choice costs a life.',
			'White' => 'White',
			'Black' => 'Black',
			'Choose a removable enemy stone.' => 'Choose a removable enemy stone.',
			'Select one of your stones, then move it to any empty spot.' => 'Select one of your stones, then move it to any empty spot.',
			'Select one of your stones, then move it to a connected empty spot.' => 'Select one of your stones, then move it to a connected empty spot.',
			'Select one of your own stones.' => 'Select one of your own stones.',
			'Stone selected. Choose where to move.' => 'Stone selected. Choose where to move.',
			'Selection cleared.' => 'Selection cleared.',
			'Correct code. The locked box opens.' => 'Correct code. The locked box opens.',
			'Wrong code.' => 'Wrong code.',
			'Start with the desk or the painting.' => 'Start with the desk or the painting.',
			'Unlock Box' => 'Unlock Box',
			'Restart Training' => 'Restart Training',
			'Dinozorlu' => 'Dinosaur Game',
			'Balon Patlatmalı' => 'Balloon Pop',
			'Hayvan Kurtarmalı' => 'Animal Rescue',
			'Ahır' => 'Barn',
			'Kurtarılan: ' => 'Rescued: ',
			'Penaltı Kralı' => 'Penalty King',
			'Başlat ve şut çek' => 'Start and shoot',
			'Yakalandın' => 'Caught',
			'Öğretmenden Kaç' => 'Escape the Teacher',
			'SINIF' => 'CLASS',
			'TAHTA' => 'BOARD',
			'Kaçma Oyunu' => 'Escape Game',
			'Meyve Topla' => 'Fruit Collector',
			'Tekrar başlat ve yeniden savaş.' => 'Restart and battle again.',
			'Başlat ve bir savaşçı gönder.' => 'Start and send a fighter.',
			'Başlat düğmesine bas' => 'Press the Start button',
			'Tekrar başlamak için Baştan Başla düğmesine bas' => 'Press Restart to start again',
			'Classify the bug.' => 'Classify the bug.',
			'Classify the bugs before time runs out.' => 'Classify the bugs before time runs out.',
			'Correct bin.' => 'Correct bin.',
			'You lost all lives. Press Start.' => 'You lost all lives. Press Start.',
			'Watch the sequence.' => 'Watch the sequence.',
			'Now repeat.' => 'Now repeat.',
			'Correct! Next level.' => 'Correct! Next level.',
			'Try this round again.' => 'Try this round again.',
			'Round ' => 'Round ',
			'Game finished' => 'Game finished',
			'Perfect Balance' => 'Perfect Balance',
			'Finished' => 'Finished',
			'All three services are restored. The city lights up again.' => 'All three services are restored. The city lights up again.',
			'Watch for the next one.' => 'Watch for the next one.',
			'Nice catch.' => 'Nice catch.',
			'Too slow. Watch for the next one.' => 'Too slow. Watch for the next one.',
			'You found the hidden stars.' => 'You found the hidden stars.',
			'Try again and catch more stars.' => 'Try again and catch more stars.',
			'Private game. Embed directly where you want it.' => 'Private game. Embed directly where you want it.',
			'You found all the treasure. You win.' => 'You found all the treasure. You win.',
			'You hit a trap. Game over.' => 'You hit a trap. Game over.',
			'TREASURE' => 'TREASURE',
			'TRAP' => 'TRAP',
			'Ready' => 'Ready',
			'Locked' => 'Locked',
			'Mission complete!' => 'Mission complete!',
			'Try again!' => 'Try again!',
		),
		'de' => array(
			'Arabalı' => 'Autospiel',
			'Başlamak için düğmeye bas' => 'Drücke den Knopf zum Starten',
			'Skor: ' => 'Punkte: ',
			'Su: ' => 'Wasser: ',
			'Seviye: ' => 'Level: ',
			'En iyi su: ' => 'Bestes Wasser: ',
			'Çöl oyun alanı' => 'Wüsten-Spielfeld',
			'Kazandın. Sonraki seviyeye geç.' => 'Du hast gewonnen. Weiter zum nächsten Level.',
			'Tekrar Başla' => 'Neu starten',
			'Sonraki Seviye' => 'Nächstes Level',
			'Kapılar' => 'Türen',
			'Can: ' => 'Leben: ',
			'En iyi: ' => 'Bestwert: ',
			'Oyun bitti. Tekrar oyna.' => 'Spiel vorbei. Spiele erneut.',
			'Doğru kapıyı seç.' => 'Wähle die richtige Tür.',
			'Doğru kapı. Hazineyi buldun.' => 'Richtige Tür. Du hast den Schatz gefunden.',
			'Yanlış kapı. Tuzak vardı.' => 'Falsche Tür. Dort war eine Falle.',
			'Mısır tapınağında sekiz kapı var. Sadece birinde hazine var. Doğru kapıyı seç ve ilerle.' => 'Im ägyptischen Tempel gibt es acht Türen. Nur hinter einer liegt ein Schatz. Wähle die richtige Tür und gehe weiter.',
			'Her turda sadece bir kapı güvenlidir. Yanlış seçimde can kaybedersin.' => 'In jeder Runde ist nur eine Tür sicher. Bei einer falschen Wahl verlierst du ein Leben.',
			'White' => 'Weiß',
			'Black' => 'Schwarz',
			'Choose a removable enemy stone.' => 'Wähle einen entfernbaren gegnerischen Stein.',
			'Select one of your stones, then move it to any empty spot.' => 'Wähle einen deiner Steine und bewege ihn auf ein leeres Feld.',
			'Select one of your stones, then move it to a connected empty spot.' => 'Wähle einen deiner Steine und bewege ihn auf ein verbundenes leeres Feld.',
			'Select one of your own stones.' => 'Wähle einen deiner eigenen Steine.',
			'Stone selected. Choose where to move.' => 'Stein ausgewählt. Wähle das Zielfeld.',
			'Selection cleared.' => 'Auswahl aufgehoben.',
			'Correct code. The locked box opens.' => 'Richtiger Code. Die verschlossene Kiste öffnet sich.',
			'Wrong code.' => 'Falscher Code.',
			'Start with the desk or the painting.' => 'Beginne mit dem Schreibtisch oder dem Gemälde.',
			'Unlock Box' => 'Kiste öffnen',
			'Restart Training' => 'Training neu starten',
			'Dinozorlu' => 'Dinosaurierspiel',
			'Balon Patlatmalı' => 'Ballons platzen',
			'Hayvan Kurtarmalı' => 'Tierrettung',
			'Ahır' => 'Scheune',
			'Kurtarılan: ' => 'Gerettet: ',
			'Penaltı Kralı' => 'Elfmeterkönig',
			'Başlat ve şut çek' => 'Starte und schieße',
			'Yakalandın' => 'Gefangen',
			'Öğretmenden Kaç' => 'Flieh vor dem Lehrer',
			'SINIF' => 'KLASSE',
			'TAHTA' => 'TAFEL',
			'Kaçma Oyunu' => 'Fluchtspiel',
			'Meyve Topla' => 'Obst sammeln',
			'Tekrar başlat ve yeniden savaş.' => 'Starte neu und kämpfe wieder.',
			'Başlat ve bir savaşçı gönder.' => 'Starte und sende einen Kämpfer.',
			'Başlat düğmesine bas' => 'Drücke die Starttaste',
			'Tekrar başlamak için Baştan Başla düğmesine bas' => 'Drücke Neustart, um erneut zu beginnen',
			'Classify the bug.' => 'Ordne den Käfer zu.',
			'Classify the bugs before time runs out.' => 'Ordne die Käfer zu, bevor die Zeit abläuft.',
			'Correct bin.' => 'Richtiger Behälter.',
			'You lost all lives. Press Start.' => 'Du hast alle Leben verloren. Drücke Start.',
			'Watch the sequence.' => 'Merke dir die Reihenfolge.',
			'Now repeat.' => 'Jetzt wiederholen.',
			'Correct! Next level.' => 'Richtig! Nächstes Level.',
			'Try this round again.' => 'Versuche diese Runde noch einmal.',
			'Round ' => 'Runde ',
			'Game finished' => 'Spiel beendet',
			'Perfect Balance' => 'Perfektes Gleichgewicht',
			'Finished' => 'Fertig',
			'All three services are restored. The city lights up again.' => 'Alle drei Dienste sind wiederhergestellt. Die Stadt leuchtet wieder.',
			'Watch for the next one.' => 'Achte auf den nächsten.',
			'Nice catch.' => 'Gut gefangen.',
			'Too slow. Watch for the next one.' => 'Zu langsam. Achte auf den nächsten.',
			'You found the hidden stars.' => 'Du hast die versteckten Sterne gefunden.',
			'Try again and catch more stars.' => 'Versuche es erneut und fange mehr Sterne.',
			'Private game. Embed directly where you want it.' => 'Privates Spiel. Direkt dort einbetten, wo du es haben möchtest.',
			'You found all the treasure. You win.' => 'Du hast den ganzen Schatz gefunden. Du gewinnst.',
			'You hit a trap. Game over.' => 'Du bist in eine Falle geraten. Spiel vorbei.',
			'TREASURE' => 'SCHATZ',
			'TRAP' => 'FALLE',
			'Ready' => 'Bereit',
			'Locked' => 'Verschlossen',
			'Mission complete!' => 'Mission abgeschlossen!',
			'Try again!' => 'Versuche es noch einmal!',
		),
		'fr' => array(
			'Arabalı' => 'Jeu de voiture',
			'Başlamak için düğmeye bas' => 'Appuie sur le bouton pour commencer',
			'Skor: ' => 'Score : ',
			'Su: ' => 'Eau : ',
			'Seviye: ' => 'Niveau : ',
			'En iyi su: ' => 'Meilleure eau : ',
			'Çöl oyun alanı' => 'Zone de jeu du désert',
			'Kazandın. Sonraki seviyeye geç.' => 'Tu as gagné. Passe au niveau suivant.',
			'Tekrar Başla' => 'Recommencer',
			'Sonraki Seviye' => 'Niveau suivant',
			'Kapılar' => 'Portes',
			'Can: ' => 'Vies : ',
			'En iyi: ' => 'Meilleur : ',
			'Oyun bitti. Tekrar oyna.' => 'Partie terminée. Rejoue.',
			'Doğru kapıyı seç.' => 'Choisis la bonne porte.',
			'Doğru kapı. Hazineyi buldun.' => 'Bonne porte. Tu as trouvé le trésor.',
			'Yanlış kapı. Tuzak vardı.' => 'Mauvaise porte. Il y avait un piège.',
			'Mısır tapınağında sekiz kapı var. Sadece birinde hazine var. Doğru kapıyı seç ve ilerle.' => 'Dans le temple égyptien, il y a huit portes. Une seule cache un trésor. Choisis la bonne porte et avance.',
			'Her turda sadece bir kapı güvenlidir. Yanlış seçimde can kaybedersin.' => 'À chaque manche, une seule porte est sûre. Un mauvais choix te fait perdre une vie.',
			'White' => 'Blanc',
			'Black' => 'Noir',
			'Choose a removable enemy stone.' => 'Choisis une pierre ennemie à retirer.',
			'Select one of your stones, then move it to any empty spot.' => 'Choisis une de tes pierres, puis déplace-la vers une case vide.',
			'Select one of your stones, then move it to a connected empty spot.' => 'Choisis une de tes pierres, puis déplace-la vers une case vide reliée.',
			'Select one of your own stones.' => 'Choisis une de tes propres pierres.',
			'Stone selected. Choose where to move.' => 'Pierre sélectionnée. Choisis où la déplacer.',
			'Selection cleared.' => 'Sélection annulée.',
			'Correct code. The locked box opens.' => 'Code correct. La boîte verrouillée s’ouvre.',
			'Wrong code.' => 'Code incorrect.',
			'Start with the desk or the painting.' => 'Commence par le bureau ou le tableau.',
			'Unlock Box' => 'Déverrouiller la boîte',
			'Restart Training' => 'Redémarrer l’entraînement',
			'Dinozorlu' => 'Jeu de dinosaure',
			'Balon Patlatmalı' => 'Éclate-ballons',
			'Hayvan Kurtarmalı' => 'Sauvetage d’animaux',
			'Ahır' => 'Grange',
			'Kurtarılan: ' => 'Sauvés : ',
			'Penaltı Kralı' => 'Roi des penalties',
			'Başlat ve şut çek' => 'Démarre et tire',
			'Yakalandın' => 'Attrapé',
			'Öğretmenden Kaç' => 'Échappe au professeur',
			'SINIF' => 'CLASSE',
			'TAHTA' => 'TABLEAU',
			'Kaçma Oyunu' => 'Jeu d’évasion',
			'Meyve Topla' => 'Ramasse les fruits',
			'Tekrar başlat ve yeniden savaş.' => 'Redémarre et combats à nouveau.',
			'Başlat ve bir savaşçı gönder.' => 'Démarre et envoie un combattant.',
			'Başlat düğmesine bas' => 'Appuie sur le bouton Démarrer',
			'Tekrar başlamak için Baştan Başla düğmesine bas' => 'Appuie sur Redémarrer pour recommencer',
			'Classify the bug.' => 'Classe l’insecte.',
			'Classify the bugs before time runs out.' => 'Classe les insectes avant la fin du temps.',
			'Correct bin.' => 'Bon bac.',
			'You lost all lives. Press Start.' => 'Tu as perdu toutes tes vies. Appuie sur Démarrer.',
			'Watch the sequence.' => 'Observe la séquence.',
			'Now repeat.' => 'Maintenant, répète.',
			'Correct! Next level.' => 'Correct ! Niveau suivant.',
			'Try this round again.' => 'Réessaie cette manche.',
			'Round ' => 'Manche ',
			'Game finished' => 'Partie terminée',
			'Perfect Balance' => 'Équilibre parfait',
			'Finished' => 'Terminé',
			'All three services are restored. The city lights up again.' => 'Les trois services sont rétablis. La ville s’illumine à nouveau.',
			'Watch for the next one.' => 'Surveille le suivant.',
			'Nice catch.' => 'Belle prise.',
			'Too slow. Watch for the next one.' => 'Trop lent. Surveille le suivant.',
			'You found the hidden stars.' => 'Tu as trouvé les étoiles cachées.',
			'Try again and catch more stars.' => 'Réessaie et attrape plus d’étoiles.',
			'Private game. Embed directly where you want it.' => 'Jeu privé. Intègre-le directement où tu veux.',
			'You found all the treasure. You win.' => 'Tu as trouvé tout le trésor. Tu gagnes.',
			'You hit a trap. Game over.' => 'Tu as touché un piège. Partie terminée.',
			'TREASURE' => 'TRÉSOR',
			'TRAP' => 'PIÈGE',
			'Ready' => 'Prêt',
			'Locked' => 'Verrouillé',
			'Mission complete!' => 'Mission accomplie !',
			'Try again!' => 'Réessaie !',
		),
		'es-mx' => array(
			'Arabalı' => 'Juego de autos',
			'Başlamak için düğmeye bas' => 'Presiona el botón para empezar',
			'Skor: ' => 'Puntuación: ',
			'Su: ' => 'Agua: ',
			'Seviye: ' => 'Nivel: ',
			'En iyi su: ' => 'Mejor agua: ',
			'Çöl oyun alanı' => 'Área de juego del desierto',
			'Kazandın. Sonraki seviyeye geç.' => 'Ganaste. Pasa al siguiente nivel.',
			'Tekrar Başla' => 'Reiniciar',
			'Sonraki Seviye' => 'Siguiente nivel',
			'Kapılar' => 'Puertas',
			'Can: ' => 'Vidas: ',
			'En iyi: ' => 'Mejor: ',
			'Oyun bitti. Tekrar oyna.' => 'Fin del juego. Juega de nuevo.',
			'Doğru kapıyı seç.' => 'Elige la puerta correcta.',
			'Doğru kapı. Hazineyi buldun.' => 'Puerta correcta. Encontraste el tesoro.',
			'Yanlış kapı. Tuzak vardı.' => 'Puerta equivocada. Había una trampa.',
			'Mısır tapınağında sekiz kapı var. Sadece birinde hazine var. Doğru kapıyı seç ve ilerle.' => 'En el templo egipcio hay ocho puertas. Solo una tiene tesoro. Elige la puerta correcta y avanza.',
			'Her turda sadece bir kapı güvenlidir. Yanlış seçimde can kaybedersin.' => 'En cada ronda solo una puerta es segura. Si eliges mal, pierdes una vida.',
			'White' => 'Blanco',
			'Black' => 'Negro',
			'Choose a removable enemy stone.' => 'Elige una ficha enemiga que puedas quitar.',
			'Select one of your stones, then move it to any empty spot.' => 'Selecciona una de tus fichas y muévela a un espacio vacío.',
			'Select one of your stones, then move it to a connected empty spot.' => 'Selecciona una de tus fichas y muévela a un espacio vacío conectado.',
			'Select one of your own stones.' => 'Selecciona una de tus propias fichas.',
			'Stone selected. Choose where to move.' => 'Ficha seleccionada. Elige dónde moverla.',
			'Selection cleared.' => 'Selección borrada.',
			'Correct code. The locked box opens.' => 'Código correcto. La caja cerrada se abre.',
			'Wrong code.' => 'Código incorrecto.',
			'Start with the desk or the painting.' => 'Empieza con el escritorio o la pintura.',
			'Unlock Box' => 'Abrir caja',
			'Restart Training' => 'Reiniciar entrenamiento',
			'Dinozorlu' => 'Juego de dinosaurios',
			'Balon Patlatmalı' => 'Revienta globos',
			'Hayvan Kurtarmalı' => 'Rescate de animales',
			'Ahır' => 'Granero',
			'Kurtarılan: ' => 'Rescatados: ',
			'Penaltı Kralı' => 'Rey de penales',
			'Başlat ve şut çek' => 'Empieza y tira',
			'Yakalandın' => 'Te atraparon',
			'Öğretmenden Kaç' => 'Escapa del maestro',
			'SINIF' => 'SALÓN',
			'TAHTA' => 'PIZARRÓN',
			'Kaçma Oyunu' => 'Juego de escape',
			'Meyve Topla' => 'Recoge frutas',
			'Tekrar başlat ve yeniden savaş.' => 'Reinicia y lucha otra vez.',
			'Başlat ve bir savaşçı gönder.' => 'Empieza y envía un luchador.',
			'Başlat düğmesine bas' => 'Presiona el botón Empezar',
			'Tekrar başlamak için Baştan Başla düğmesine bas' => 'Presiona Reiniciar para empezar de nuevo',
			'Classify the bug.' => 'Clasifica el insecto.',
			'Classify the bugs before time runs out.' => 'Clasifica los insectos antes de que se acabe el tiempo.',
			'Correct bin.' => 'Contenedor correcto.',
			'You lost all lives. Press Start.' => 'Perdiste todas las vidas. Presiona Empezar.',
			'Watch the sequence.' => 'Observa la secuencia.',
			'Now repeat.' => 'Ahora repite.',
			'Correct! Next level.' => '¡Correcto! Siguiente nivel.',
			'Try this round again.' => 'Intenta esta ronda otra vez.',
			'Round ' => 'Ronda ',
			'Game finished' => 'Juego terminado',
			'Perfect Balance' => 'Equilibrio perfecto',
			'Finished' => 'Terminado',
			'All three services are restored. The city lights up again.' => 'Los tres servicios están restaurados. La ciudad se ilumina otra vez.',
			'Watch for the next one.' => 'Estate atento al siguiente.',
			'Nice catch.' => 'Buena atrapada.',
			'Too slow. Watch for the next one.' => 'Muy lento. Estate atento al siguiente.',
			'You found the hidden stars.' => 'Encontraste las estrellas ocultas.',
			'Try again and catch more stars.' => 'Inténtalo de nuevo y atrapa más estrellas.',
			'Private game. Embed directly where you want it.' => 'Juego privado. Insértalo directamente donde quieras.',
			'You found all the treasure. You win.' => 'Encontraste todo el tesoro. Ganaste.',
			'You hit a trap. Game over.' => 'Caíste en una trampa. Fin del juego.',
			'TREASURE' => 'TESORO',
			'TRAP' => 'TRAMPA',
			'Ready' => 'Listo',
			'Locked' => 'Bloqueado',
			'Mission complete!' => '¡Misión completa!',
			'Try again!' => '¡Inténtalo de nuevo!',
		),
		'es-es' => array(
			'Arabalı' => 'Juego de coches',
			'Başlamak için düğmeye bas' => 'Pulsa el botón para empezar',
			'Skor: ' => 'Puntuación: ',
			'Su: ' => 'Agua: ',
			'Seviye: ' => 'Nivel: ',
			'En iyi su: ' => 'Mejor agua: ',
			'Çöl oyun alanı' => 'Zona de juego del desierto',
			'Kazandın. Sonraki seviyeye geç.' => 'Has ganado. Pasa al siguiente nivel.',
			'Tekrar Başla' => 'Reiniciar',
			'Sonraki Seviye' => 'Siguiente nivel',
			'Kapılar' => 'Puertas',
			'Can: ' => 'Vidas: ',
			'En iyi: ' => 'Mejor: ',
			'Oyun bitti. Tekrar oyna.' => 'Fin del juego. Juega otra vez.',
			'Doğru kapıyı seç.' => 'Elige la puerta correcta.',
			'Doğru kapı. Hazineyi buldun.' => 'Puerta correcta. Has encontrado el tesoro.',
			'Yanlış kapı. Tuzak vardı.' => 'Puerta equivocada. Había una trampa.',
			'Mısır tapınağında sekiz kapı var. Sadece birinde hazine var. Doğru kapıyı seç ve ilerle.' => 'En el templo egipcio hay ocho puertas. Solo una tiene tesoro. Elige la puerta correcta y avanza.',
			'Her turda sadece bir kapı güvenlidir. Yanlış seçimde can kaybedersin.' => 'En cada ronda solo una puerta es segura. Si eliges mal, pierdes una vida.',
			'White' => 'Blanco',
			'Black' => 'Negro',
			'Choose a removable enemy stone.' => 'Elige una ficha enemiga que puedas quitar.',
			'Select one of your stones, then move it to any empty spot.' => 'Selecciona una de tus fichas y muévela a un espacio vacío.',
			'Select one of your stones, then move it to a connected empty spot.' => 'Selecciona una de tus fichas y muévela a un espacio vacío conectado.',
			'Select one of your own stones.' => 'Selecciona una de tus propias fichas.',
			'Stone selected. Choose where to move.' => 'Ficha seleccionada. Elige dónde moverla.',
			'Selection cleared.' => 'Selección borrada.',
			'Correct code. The locked box opens.' => 'Código correcto. La caja cerrada se abre.',
			'Wrong code.' => 'Código incorrecto.',
			'Start with the desk or the painting.' => 'Empieza por el escritorio o el cuadro.',
			'Unlock Box' => 'Abrir caja',
			'Restart Training' => 'Reiniciar entrenamiento',
			'Dinozorlu' => 'Juego de dinosaurios',
			'Balon Patlatmalı' => 'Revienta globos',
			'Hayvan Kurtarmalı' => 'Rescate de animales',
			'Ahır' => 'Granero',
			'Kurtarılan: ' => 'Rescatados: ',
			'Penaltı Kralı' => 'Rey de penaltis',
			'Başlat ve şut çek' => 'Empieza y dispara',
			'Yakalandın' => 'Te han atrapado',
			'Öğretmenden Kaç' => 'Escapa del profesor',
			'SINIF' => 'CLASE',
			'TAHTA' => 'PIZARRA',
			'Kaçma Oyunu' => 'Juego de escape',
			'Meyve Topla' => 'Recoge frutas',
			'Tekrar başlat ve yeniden savaş.' => 'Reinicia y lucha otra vez.',
			'Başlat ve bir savaşçı gönder.' => 'Empieza y envía un luchador.',
			'Başlat düğmesine bas' => 'Pulsa el botón Empezar',
			'Tekrar başlamak için Baştan Başla düğmesine bas' => 'Pulsa Reiniciar para empezar de nuevo',
			'Classify the bug.' => 'Clasifica el insecto.',
			'Classify the bugs before time runs out.' => 'Clasifica los insectos antes de que se acabe el tiempo.',
			'Correct bin.' => 'Contenedor correcto.',
			'You lost all lives. Press Start.' => 'Has perdido todas las vidas. Pulsa Empezar.',
			'Watch the sequence.' => 'Observa la secuencia.',
			'Now repeat.' => 'Ahora repite.',
			'Correct! Next level.' => '¡Correcto! Siguiente nivel.',
			'Try this round again.' => 'Intenta esta ronda otra vez.',
			'Round ' => 'Ronda ',
			'Game finished' => 'Juego terminado',
			'Perfect Balance' => 'Equilibrio perfecto',
			'Finished' => 'Terminado',
			'All three services are restored. The city lights up again.' => 'Los tres servicios están restaurados. La ciudad vuelve a iluminarse.',
			'Watch for the next one.' => 'Estate atento al siguiente.',
			'Nice catch.' => 'Buena captura.',
			'Too slow. Watch for the next one.' => 'Demasiado lento. Estate atento al siguiente.',
			'You found the hidden stars.' => 'Has encontrado las estrellas ocultas.',
			'Try again and catch more stars.' => 'Inténtalo de nuevo y atrapa más estrellas.',
			'Private game. Embed directly where you want it.' => 'Juego privado. Insértalo directamente donde quieras.',
			'You found all the treasure. You win.' => 'Has encontrado todo el tesoro. Has ganado.',
			'You hit a trap. Game over.' => 'Has caído en una trampa. Fin del juego.',
			'TREASURE' => 'TESORO',
			'TRAP' => 'TRAMPA',
			'Ready' => 'Listo',
			'Locked' => 'Bloqueado',
			'Mission complete!' => '¡Misión completa!',
			'Try again!' => '¡Inténtalo de nuevo!',
		),
	);

	foreach ($sitewide_runtime_exact as $sitewide_lang => $sitewide_items) {
		if (isset($translations[$sitewide_lang])) {
			$translations[$sitewide_lang] = array_merge($translations[$sitewide_lang], $sitewide_items);
		}
	}

	$sitewide_runtime_exact_late = array(
		'tr' => array(
			'Base Defense' => 'Üs Savunması',
			'Victory' => 'Zafer',
			'Defeat' => 'Yenilgi',
			'Press Restart to play again.' => 'Tekrar oynamak için Yeniden Başlat düğmesine bas.',
			'Place towers, then press Start.' => 'Kuleleri yerleştir, sonra Başlat düğmesine bas.',
			'Watch the sequence.' => 'Sırayı izle.',
			'Now repeat.' => 'Şimdi tekrar et.',
			'Game over. Press Start.' => 'Oyun bitti. Başlat düğmesine bas.',
			'Correct! Next level.' => 'Doğru! Sonraki seviye.',
			'Try this round again.' => 'Bu turu tekrar dene.',
			'All three services are restored. The city lights up again.' => 'Üç hizmet de onarıldı. Şehir yeniden ışıldıyor.',
			'is restored. Continue to the next service.' => 'onarıldı. Sonraki hizmete devam et.',
			'Rotate the junctions until all three districts connect to the' => 'Üç bölge de bağlanana kadar kavşakları döndür:',
			'network.' => 'ağı.',
			'Use sound only when you need it. Reach the green exit.' => 'Sesi yalnızca gerektiğinde kullan. Yeşil çıkışa ulaş.',
			'Caught in the dark. Try shorter routes and fewer pulses.' => 'Karanlıkta yakalandın. Daha kısa yollar ve daha az yankı dene.',
			'A wall catches the echo. Pick another path.' => 'Duvar yankıyı yakaladı. Başka bir yol seç.',
			'Soft step. Listen for the exit shape.' => 'Sessiz adım. Çıkışın şeklini dinle.',
			'Echo pulse sent. The hunter heard it too.' => 'Yankı gönderildi. Avcı da duydu.',
			'Bomb hit. Be careful.' => 'Bombaya çarptın. Dikkatli ol.',
			'Nice slice.' => 'Güzel kestin.',
			'You missed a fruit.' => 'Bir meyveyi kaçırdın.',
			'Slice the fruit. Avoid bombs.' => 'Meyveyi kes. Bombalardan kaç.',
			'Open matching pairs. Use few hints.' => 'Eşleşen çiftleri aç. Az ipucu kullan.',
			'Great! Board solved.' => 'Harika! Tahta çözüldü.',
			'Hint used.' => 'İpucu kullanıldı.',
			'Place walls, then check the path.' => 'Duvarları yerleştir, sonra yolu kontrol et.',
			'Path exists! Great builder.' => 'Yol var! Harika kurucu.',
			'No path. Move or remove some walls.' => 'Yol yok. Bazı duvarları taşı veya kaldır.',
			'Board cleared.' => 'Tahta temizlendi.',
			'Wrong order.' => 'Yanlış sıra.',
			'Game over.' => 'Oyun bitti.',
			'Great job! Plant grew.' => 'Harika! Bitki büyüdü.',
			'Sequence cleared.' => 'Sıra temizlendi.',
			'Choose parts wisely.' => 'Parçaları dikkatli seç.',
			'Mission success. Robot performed well.' => 'Görev başarılı. Robot iyi çalıştı.',
			'Mission failed. Adjust your design.' => 'Görev başarısız. Tasarımını düzelt.',
			'Find the different color' => 'Farklı rengi bul',
			'Watch the glowing path.' => 'Parlayan yolu izle.',
			'Repeat the path in order.' => 'Yolu sırayla tekrar et.',
			'Path jumped. Retry.' => 'Yol atladı. Tekrar dene.',
			'Great job! Press start for next round.' => 'Harika! Sonraki tur için Başlat düğmesine bas.',
			'Wrong order. Press start to try again.' => 'Yanlış sıra. Tekrar denemek için Başlat düğmesine bas.',
			'Press start to begin.' => 'Başlamak için Başlat düğmesine bas.',
			'Out of catches. Press Start.' => 'Yakalama hakkın bitti. Başlat düğmesine bas.',
			'Collect the target letter.' => 'Hedef harfi topla.',
			'Time over. Score: ' => 'Süre bitti. Puan: ',
			'Wrong note.' => 'Yanlış nota.',
			'No lives. Press Start.' => 'Can kalmadı. Başlat düğmesine bas.',
			'Great! Next round.' => 'Harika! Sonraki tur.',
			'Round started.' => 'Tur başladı.',
			'Your turn! Click a cell to claim it.' => 'Sıra sende! Almak için bir hücreye tıkla.',
			'Your turn!' => 'Sıra sende!',
			'AI Wins! Better luck next time!' => 'Yapay zeka kazandı! Bir dahaki sefere.',
			"It's a Tie!" => 'Berabere!',
			'Watch the loop sequence.' => 'Döngü sırasını izle.',
			'Repeat it now.' => 'Şimdi tekrar et.',
			'Add all 5 moves.' => '5 hamlenin hepsini ekle.',
			'Great loop! You reached the goal.' => 'Harika döngü! Hedefe ulaştın.',
			'Wrong path.' => 'Yanlış yol.',
			'Correct balloon!' => 'Doğru balon!',
			'Wrong balloon.' => 'Yanlış balon.',
			'Pop the correct balloons.' => 'Doğru balonları patlat.',
			'World: ' => 'Dünya: ',
			'Build the word' => 'Kelimeyi kur',
			'Wrong order!' => 'Yanlış sıra!',
			'Blue Base' => 'Mavi Üs',
			'Red Base' => 'Kırmızı Üs',
			'Wit Bases' => 'Zeka Üsleri',
			'Monster Team vs Block World' => 'Canavar Takımı Blok Dünyasına Karşı',
			'Start, then send units from the left side.' => 'Başlat, sonra sol taraftan birlik gönder.',
			'Press restart to play again.' => 'Tekrar oynamak için yeniden başlat.',
			'CASTLE ENTRANCE' => 'KALE GİRİŞİ',
			'SANCTUARY' => 'SIĞINAK',
			'Enter 4-digit code' => '4 haneli kod gir',
			'Type your decoded phrase here' => 'Çözdüğün ifadeyi buraya yaz',
			'Type your answer here' => 'Cevabını buraya yaz',
		),
		'de' => array(
			'Base Defense' => 'Basisverteidigung',
			'Victory' => 'Sieg',
			'Defeat' => 'Niederlage',
			'Place towers, then press Start.' => 'Platziere Türme und drücke dann Start.',
			'is restored. Continue to the next service.' => 'ist wiederhergestellt. Weiter zum nächsten Dienst.',
			'Rotate the junctions until all three districts connect to the' => 'Drehe die Kreuzungen, bis alle drei Bezirke verbunden sind mit dem',
			'network.' => 'Netzwerk.',
			'Use sound only when you need it. Reach the green exit.' => 'Nutze Schall nur, wenn du ihn brauchst. Erreiche den grünen Ausgang.',
			'Caught in the dark. Try shorter routes and fewer pulses.' => 'Im Dunkeln erwischt. Versuche kürzere Wege und weniger Impulse.',
			'A wall catches the echo. Pick another path.' => 'Eine Wand fängt das Echo. Wähle einen anderen Weg.',
			'Soft step. Listen for the exit shape.' => 'Leiser Schritt. Höre auf die Form des Ausgangs.',
			'Echo pulse sent. The hunter heard it too.' => 'Echoimpuls gesendet. Der Jäger hat ihn auch gehört.',
			'Bomb hit. Be careful.' => 'Bombe getroffen. Sei vorsichtig.',
			'Nice slice.' => 'Guter Schnitt.',
			'You missed a fruit.' => 'Du hast ein Obst verpasst.',
			'Slice the fruit. Avoid bombs.' => 'Schneide das Obst. Weiche Bomben aus.',
			'Open matching pairs. Use few hints.' => 'Öffne passende Paare. Nutze wenige Hinweise.',
			'Great! Board solved.' => 'Super! Brett gelöst.',
			'Hint used.' => 'Hinweis genutzt.',
			'Place walls, then check the path.' => 'Setze Wände und prüfe dann den Weg.',
			'Path exists! Great builder.' => 'Es gibt einen Weg! Starker Bau.',
			'No path. Move or remove some walls.' => 'Kein Weg. Verschiebe oder entferne einige Wände.',
			'Board cleared.' => 'Brett geleert.',
			'Wrong order.' => 'Falsche Reihenfolge.',
			'Great job! Plant grew.' => 'Gut gemacht! Die Pflanze ist gewachsen.',
			'Sequence cleared.' => 'Sequenz gelöscht.',
			'Choose parts wisely.' => 'Wähle Teile klug aus.',
			'Mission success. Robot performed well.' => 'Mission erfolgreich. Der Roboter war gut.',
			'Mission failed. Adjust your design.' => 'Mission fehlgeschlagen. Passe dein Design an.',
			'Find the different color' => 'Finde die andere Farbe',
			'Watch the glowing path.' => 'Merke dir den leuchtenden Weg.',
			'Repeat the path in order.' => 'Wiederhole den Weg in Reihenfolge.',
			'Path jumped. Retry.' => 'Der Weg ist gesprungen. Erneut versuchen.',
			'Great job! Press start for next round.' => 'Gut gemacht! Drücke Start für die nächste Runde.',
			'Wrong order. Press start to try again.' => 'Falsche Reihenfolge. Drücke Start, um es erneut zu versuchen.',
			'Press start to begin.' => 'Drücke Start, um zu beginnen.',
			'Out of catches. Press Start.' => 'Keine Fänge mehr. Drücke Start.',
			'Collect the target letter.' => 'Sammle den Zielbuchstaben.',
			'Time over. Score: ' => 'Zeit vorbei. Punkte: ',
			'Wrong note.' => 'Falsche Note.',
			'Great! Next round.' => 'Super! Nächste Runde.',
			'Round started.' => 'Runde gestartet.',
			'Your turn! Click a cell to claim it.' => 'Du bist dran! Klicke eine Zelle an, um sie zu beanspruchen.',
			'Your turn!' => 'Du bist dran!',
			'AI Wins! Better luck next time!' => 'KI gewinnt! Nächstes Mal mehr Glück!',
			"It's a Tie!" => 'Unentschieden!',
			'Watch the loop sequence.' => 'Merke dir die Schleifensequenz.',
			'Repeat it now.' => 'Wiederhole sie jetzt.',
			'Add all 5 moves.' => 'Füge alle 5 Züge hinzu.',
			'Great loop! You reached the goal.' => 'Starke Schleife! Du hast das Ziel erreicht.',
			'Wrong path.' => 'Falscher Weg.',
			'Correct balloon!' => 'Richtiger Ballon!',
			'Wrong balloon.' => 'Falscher Ballon.',
			'Pop the correct balloons.' => 'Lass die richtigen Ballons platzen.',
			'World: ' => 'Welt: ',
			'Build the word' => 'Baue das Wort',
			'Wrong order!' => 'Falsche Reihenfolge!',
			'Blue Base' => 'Blaue Basis',
			'Red Base' => 'Rote Basis',
			'Wit Bases' => 'Denkbasen',
			'Monster Team vs Block World' => 'Monsterteam gegen Blockwelt',
			'Start, then send units from the left side.' => 'Starte und sende dann Einheiten von links.',
			'Press restart to play again.' => 'Drücke Neustart, um wieder zu spielen.',
			'CASTLE ENTRANCE' => 'BURGEINGANG',
			'SANCTUARY' => 'ZUFLUCHT',
			'Enter 4-digit code' => '4-stelligen Code eingeben',
			'Type your decoded phrase here' => 'Gib hier den entschlüsselten Satz ein',
			'Type your answer here' => 'Gib hier deine Antwort ein',
		),
		'fr' => array(
			'Base Defense' => 'Défense de base',
			'Victory' => 'Victoire',
			'Defeat' => 'Défaite',
			'Place towers, then press Start.' => 'Place des tours, puis appuie sur Démarrer.',
			'is restored. Continue to the next service.' => 'est rétabli. Continue avec le service suivant.',
			'Rotate the junctions until all three districts connect to the' => 'Tourne les jonctions jusqu’à ce que les trois quartiers se connectent au',
			'network.' => 'réseau.',
			'Use sound only when you need it. Reach the green exit.' => 'Utilise le son seulement quand tu en as besoin. Atteins la sortie verte.',
			'Caught in the dark. Try shorter routes and fewer pulses.' => 'Pris dans le noir. Essaie des trajets plus courts et moins d’impulsions.',
			'A wall catches the echo. Pick another path.' => 'Un mur capte l’écho. Choisis un autre chemin.',
			'Soft step. Listen for the exit shape.' => 'Pas discret. Écoute la forme de la sortie.',
			'Echo pulse sent. The hunter heard it too.' => 'Impulsion d’écho envoyée. Le chasseur l’a aussi entendue.',
			'Bomb hit. Be careful.' => 'Bombe touchée. Fais attention.',
			'Nice slice.' => 'Belle coupe.',
			'You missed a fruit.' => 'Tu as raté un fruit.',
			'Slice the fruit. Avoid bombs.' => 'Coupe les fruits. Évite les bombes.',
			'Open matching pairs. Use few hints.' => 'Ouvre les paires correspondantes. Utilise peu d’indices.',
			'Great! Board solved.' => 'Super ! Plateau résolu.',
			'Hint used.' => 'Indice utilisé.',
			'Place walls, then check the path.' => 'Place des murs, puis vérifie le chemin.',
			'Path exists! Great builder.' => 'Un chemin existe ! Très bon bâtisseur.',
			'No path. Move or remove some walls.' => 'Aucun chemin. Déplace ou retire des murs.',
			'Board cleared.' => 'Plateau effacé.',
			'Wrong order.' => 'Mauvais ordre.',
			'Great job! Plant grew.' => 'Bravo ! La plante a poussé.',
			'Sequence cleared.' => 'Séquence effacée.',
			'Choose parts wisely.' => 'Choisis les pièces avec soin.',
			'Mission success. Robot performed well.' => 'Mission réussie. Le robot a bien fonctionné.',
			'Mission failed. Adjust your design.' => 'Mission échouée. Ajuste ton design.',
			'Find the different color' => 'Trouve la couleur différente',
			'Watch the glowing path.' => 'Observe le chemin lumineux.',
			'Repeat the path in order.' => 'Répète le chemin dans l’ordre.',
			'Path jumped. Retry.' => 'Le chemin a sauté. Réessaie.',
			'Great job! Press start for next round.' => 'Bravo ! Appuie sur Démarrer pour la manche suivante.',
			'Wrong order. Press start to try again.' => 'Mauvais ordre. Appuie sur Démarrer pour réessayer.',
			'Press start to begin.' => 'Appuie sur Démarrer pour commencer.',
			'Out of catches. Press Start.' => 'Plus de prises. Appuie sur Démarrer.',
			'Collect the target letter.' => 'Ramasse la lettre cible.',
			'Time over. Score: ' => 'Temps écoulé. Score : ',
			'Wrong note.' => 'Mauvaise note.',
			'Great! Next round.' => 'Super ! Manche suivante.',
			'Round started.' => 'Manche commencée.',
			'Your turn! Click a cell to claim it.' => 'À toi ! Clique sur une case pour la prendre.',
			'Your turn!' => 'À toi !',
			'AI Wins! Better luck next time!' => 'L’IA gagne ! Tu feras mieux la prochaine fois !',
			"It's a Tie!" => 'Égalité !',
			'Watch the loop sequence.' => 'Observe la séquence de boucle.',
			'Repeat it now.' => 'Répète-la maintenant.',
			'Add all 5 moves.' => 'Ajoute les 5 mouvements.',
			'Great loop! You reached the goal.' => 'Belle boucle ! Tu as atteint l’objectif.',
			'Wrong path.' => 'Mauvais chemin.',
			'Correct balloon!' => 'Bon ballon !',
			'Wrong balloon.' => 'Mauvais ballon.',
			'Pop the correct balloons.' => 'Éclate les bons ballons.',
			'World: ' => 'Monde : ',
			'Build the word' => 'Construis le mot',
			'Wrong order!' => 'Mauvais ordre !',
			'Blue Base' => 'Base bleue',
			'Red Base' => 'Base rouge',
			'Wit Bases' => 'Bases de réflexion',
			'Monster Team vs Block World' => 'Équipe monstre contre monde de blocs',
			'Start, then send units from the left side.' => 'Démarre, puis envoie des unités depuis la gauche.',
			'Press restart to play again.' => 'Appuie sur redémarrer pour rejouer.',
			'CASTLE ENTRANCE' => 'ENTRÉE DU CHÂTEAU',
			'SANCTUARY' => 'SANCTUAIRE',
			'Enter 4-digit code' => 'Entre un code à 4 chiffres',
			'Type your decoded phrase here' => 'Tape ici ta phrase décodée',
			'Type your answer here' => 'Tape ta réponse ici',
		),
		'es-mx' => array(
			'Base Defense' => 'Defensa de base',
			'Victory' => 'Victoria',
			'Defeat' => 'Derrota',
			'Place towers, then press Start.' => 'Coloca torres y luego presiona Empezar.',
			'is restored. Continue to the next service.' => 'está restaurado. Continúa con el siguiente servicio.',
			'Rotate the junctions until all three districts connect to the' => 'Gira los cruces hasta que los tres distritos se conecten a la',
			'network.' => 'red.',
			'Use sound only when you need it. Reach the green exit.' => 'Usa el sonido solo cuando lo necesites. Llega a la salida verde.',
			'Caught in the dark. Try shorter routes and fewer pulses.' => 'Atrapado en la oscuridad. Prueba rutas más cortas y menos pulsos.',
			'A wall catches the echo. Pick another path.' => 'Una pared atrapa el eco. Elige otro camino.',
			'Soft step. Listen for the exit shape.' => 'Paso suave. Escucha la forma de la salida.',
			'Echo pulse sent. The hunter heard it too.' => 'Pulso de eco enviado. El cazador también lo oyó.',
			'Bomb hit. Be careful.' => 'Tocaste una bomba. Ten cuidado.',
			'Nice slice.' => 'Buen corte.',
			'You missed a fruit.' => 'Se te escapó una fruta.',
			'Slice the fruit. Avoid bombs.' => 'Corta la fruta. Evita las bombas.',
			'Open matching pairs. Use few hints.' => 'Abre pares iguales. Usa pocas pistas.',
			'Great! Board solved.' => '¡Genial! Tablero resuelto.',
			'Hint used.' => 'Pista usada.',
			'Place walls, then check the path.' => 'Coloca paredes y luego revisa el camino.',
			'Path exists! Great builder.' => '¡Hay camino! Gran constructor.',
			'No path. Move or remove some walls.' => 'No hay camino. Mueve o quita algunas paredes.',
			'Board cleared.' => 'Tablero limpio.',
			'Wrong order.' => 'Orden incorrecto.',
			'Great job! Plant grew.' => '¡Muy bien! La planta creció.',
			'Sequence cleared.' => 'Secuencia borrada.',
			'Choose parts wisely.' => 'Elige las piezas con cuidado.',
			'Mission success. Robot performed well.' => 'Misión exitosa. El robot funcionó bien.',
			'Mission failed. Adjust your design.' => 'Misión fallida. Ajusta tu diseño.',
			'Find the different color' => 'Encuentra el color diferente',
			'Watch the glowing path.' => 'Observa el camino brillante.',
			'Repeat the path in order.' => 'Repite el camino en orden.',
			'Path jumped. Retry.' => 'El camino saltó. Reintenta.',
			'Great job! Press start for next round.' => '¡Muy bien! Presiona Empezar para la siguiente ronda.',
			'Wrong order. Press start to try again.' => 'Orden incorrecto. Presiona Empezar para intentarlo de nuevo.',
			'Press start to begin.' => 'Presiona Empezar para comenzar.',
			'Out of catches. Press Start.' => 'Sin atrapadas. Presiona Empezar.',
			'Collect the target letter.' => 'Recoge la letra objetivo.',
			'Time over. Score: ' => 'Tiempo terminado. Puntuación: ',
			'Wrong note.' => 'Nota incorrecta.',
			'Great! Next round.' => '¡Genial! Siguiente ronda.',
			'Round started.' => 'Ronda iniciada.',
			'Your turn! Click a cell to claim it.' => '¡Tu turno! Haz clic en una celda para reclamarla.',
			'Your turn!' => '¡Tu turno!',
			'AI Wins! Better luck next time!' => '¡La IA gana! Más suerte la próxima vez.',
			"It's a Tie!" => '¡Empate!',
			'Watch the loop sequence.' => 'Observa la secuencia del bucle.',
			'Repeat it now.' => 'Repítela ahora.',
			'Add all 5 moves.' => 'Agrega los 5 movimientos.',
			'Great loop! You reached the goal.' => '¡Gran bucle! Llegaste a la meta.',
			'Wrong path.' => 'Camino incorrecto.',
			'Correct balloon!' => '¡Globo correcto!',
			'Wrong balloon.' => 'Globo incorrecto.',
			'Pop the correct balloons.' => 'Revienta los globos correctos.',
			'World: ' => 'Mundo: ',
			'Build the word' => 'Forma la palabra',
			'Wrong order!' => '¡Orden incorrecto!',
			'Blue Base' => 'Base azul',
			'Red Base' => 'Base roja',
			'Wit Bases' => 'Bases de ingenio',
			'Monster Team vs Block World' => 'Equipo monstruo contra mundo de bloques',
			'Start, then send units from the left side.' => 'Empieza y luego envía unidades desde la izquierda.',
			'Press restart to play again.' => 'Presiona reiniciar para jugar de nuevo.',
			'CASTLE ENTRANCE' => 'ENTRADA DEL CASTILLO',
			'SANCTUARY' => 'SANTUARIO',
			'Enter 4-digit code' => 'Ingresa un código de 4 dígitos',
			'Type your decoded phrase here' => 'Escribe aquí tu frase decodificada',
			'Type your answer here' => 'Escribe tu respuesta aquí',
		),
		'es-es' => array(
			'Base Defense' => 'Defensa de base',
			'Victory' => 'Victoria',
			'Defeat' => 'Derrota',
			'Place towers, then press Start.' => 'Coloca torres y luego pulsa Empezar.',
			'is restored. Continue to the next service.' => 'está restaurado. Continúa con el siguiente servicio.',
			'Rotate the junctions until all three districts connect to the' => 'Gira los cruces hasta que los tres distritos se conecten a la',
			'network.' => 'red.',
			'Use sound only when you need it. Reach the green exit.' => 'Usa el sonido solo cuando lo necesites. Llega a la salida verde.',
			'Caught in the dark. Try shorter routes and fewer pulses.' => 'Atrapado en la oscuridad. Prueba rutas más cortas y menos pulsos.',
			'A wall catches the echo. Pick another path.' => 'Una pared atrapa el eco. Elige otro camino.',
			'Soft step. Listen for the exit shape.' => 'Paso suave. Escucha la forma de la salida.',
			'Echo pulse sent. The hunter heard it too.' => 'Pulso de eco enviado. El cazador también lo ha oído.',
			'Bomb hit. Be careful.' => 'Has tocado una bomba. Ten cuidado.',
			'Nice slice.' => 'Buen corte.',
			'You missed a fruit.' => 'Has fallado una fruta.',
			'Slice the fruit. Avoid bombs.' => 'Corta la fruta. Evita las bombas.',
			'Open matching pairs. Use few hints.' => 'Abre parejas iguales. Usa pocas pistas.',
			'Great! Board solved.' => '¡Genial! Tablero resuelto.',
			'Hint used.' => 'Pista usada.',
			'Place walls, then check the path.' => 'Coloca paredes y luego comprueba el camino.',
			'Path exists! Great builder.' => '¡Hay camino! Gran constructor.',
			'No path. Move or remove some walls.' => 'No hay camino. Mueve o quita algunas paredes.',
			'Board cleared.' => 'Tablero despejado.',
			'Wrong order.' => 'Orden incorrecto.',
			'Great job! Plant grew.' => '¡Muy bien! La planta ha crecido.',
			'Sequence cleared.' => 'Secuencia borrada.',
			'Choose parts wisely.' => 'Elige las piezas con cuidado.',
			'Mission success. Robot performed well.' => 'Misión completada. El robot funcionó bien.',
			'Mission failed. Adjust your design.' => 'Misión fallida. Ajusta tu diseño.',
			'Find the different color' => 'Encuentra el color diferente',
			'Watch the glowing path.' => 'Observa el camino brillante.',
			'Repeat the path in order.' => 'Repite el camino en orden.',
			'Path jumped. Retry.' => 'El camino ha saltado. Reintenta.',
			'Great job! Press start for next round.' => '¡Muy bien! Pulsa Empezar para la siguiente ronda.',
			'Wrong order. Press start to try again.' => 'Orden incorrecto. Pulsa Empezar para intentarlo de nuevo.',
			'Press start to begin.' => 'Pulsa Empezar para comenzar.',
			'Out of catches. Press Start.' => 'Sin capturas. Pulsa Empezar.',
			'Collect the target letter.' => 'Recoge la letra objetivo.',
			'Time over. Score: ' => 'Tiempo terminado. Puntuación: ',
			'Wrong note.' => 'Nota incorrecta.',
			'Great! Next round.' => '¡Genial! Siguiente ronda.',
			'Round started.' => 'Ronda iniciada.',
			'Your turn! Click a cell to claim it.' => '¡Tu turno! Haz clic en una celda para reclamarla.',
			'Your turn!' => '¡Tu turno!',
			'AI Wins! Better luck next time!' => '¡La IA gana! Más suerte la próxima vez.',
			"It's a Tie!" => '¡Empate!',
			'Watch the loop sequence.' => 'Observa la secuencia del bucle.',
			'Repeat it now.' => 'Repítela ahora.',
			'Add all 5 moves.' => 'Añade los 5 movimientos.',
			'Great loop! You reached the goal.' => '¡Gran bucle! Has llegado a la meta.',
			'Wrong path.' => 'Camino incorrecto.',
			'Correct balloon!' => '¡Globo correcto!',
			'Wrong balloon.' => 'Globo incorrecto.',
			'Pop the correct balloons.' => 'Revienta los globos correctos.',
			'World: ' => 'Mundo: ',
			'Build the word' => 'Forma la palabra',
			'Wrong order!' => '¡Orden incorrecto!',
			'Blue Base' => 'Base azul',
			'Red Base' => 'Base roja',
			'Wit Bases' => 'Bases de ingenio',
			'Monster Team vs Block World' => 'Equipo monstruo contra mundo de bloques',
			'Start, then send units from the left side.' => 'Empieza y luego envía unidades desde la izquierda.',
			'Press restart to play again.' => 'Pulsa reiniciar para jugar de nuevo.',
			'CASTLE ENTRANCE' => 'ENTRADA DEL CASTILLO',
			'SANCTUARY' => 'SANTUARIO',
			'Enter 4-digit code' => 'Introduce un código de 4 dígitos',
			'Type your decoded phrase here' => 'Escribe aquí tu frase decodificada',
			'Type your answer here' => 'Escribe tu respuesta aquí',
		),
	);

	foreach ($sitewide_runtime_exact_late as $late_lang => $late_items) {
		if (isset($translations[$late_lang])) {
			$translations[$late_lang] = array_merge($translations[$late_lang], $late_items);
		}
	}

	$sitewide_runtime_exact_more = array(
		'tr' => array(
			'This shared puzzle is blocked because its data is invalid.' => 'Paylaşılan bulmaca verisi geçersiz olduğu için engellendi.',
			'Play mode. Use arrow keys.' => 'Oyun modu. Ok tuşlarını kullan.',
			'Puzzle solved.' => 'Bulmaca çözüldü.',
			'Saved to system.' => 'Sisteme kaydedildi.',
			'Could not save puzzle.' => 'Bulmaca kaydedilemedi.',
			'Could not reach the puzzle save service.' => 'Bulmaca kaydetme servisine ulaşılamadı.',
			'Could not load shared puzzles.' => 'Paylaşılan bulmacalar yüklenemedi.',
			'Match the target in 5 moves.' => 'Hedefi 5 hamlede eşleştir.',
			'Aligned! Nice!' => 'Hizalandı! Güzel!',
			'Not aligned. Try again.' => 'Hizalanmadı. Tekrar dene.',
			'Hazır. Nil üzerinde hazineleri topla.' => 'Ready. Collect treasures on the Nile.',
			'Altınları yakala. Timsahlardan kaç.' => 'Altınları yakala. Timsahlardan kaç.',
			'Oyun bitti. Tekrar başla.' => 'Oyun bitti. Tekrar başla.',
			'Hazine yakaladın.' => 'Hazine yakaladın.',
			'Timsaha çarptın.' => 'Timsaha çarptın.',
			'Bir hazineyi kaçırdın.' => 'Bir hazineyi kaçırdın.',
			'Pocket Team vs Block Team' => 'Cep Takımı Blok Takımına Karşı',
			'Wins' => 'Kazandı',
			'Every 5 seconds the game sends 1 enemy. More Enemies sends 2.' => 'Her 5 saniyede oyun 1 düşman gönderir. Daha Fazla Düşman 2 gönderir.',
			'No moves yet.' => 'Henüz hamle yok.',
			'Turn: ' => 'Sıra: ',
			'You: ' => 'Sen: ',
			'Correct!' => 'Doğru!',
			'Wrong!' => 'Yanlış!',
			'Perfect Balance' => 'Mükemmel Denge',
			'Finished' => 'Bitti',
			'Game finished' => 'Oyun bitti',
			'No country selected yet' => 'Henüz ülke seçilmedi',
			'Write a country name in Turkish or English, then press Start Quiz.' => 'Türkçe veya İngilizce bir ülke adı yaz, sonra Testi Başlat düğmesine bas.',
			'Question 0 / 100' => 'Soru 0 / 100',
			'Type text here' => 'Metni buraya yaz',
			'Pick color' => 'Renk seç',
			'Brush size' => 'Fırça boyutu',
			'Shape picker' => 'Şekil seçici',
			'Text input' => 'Metin girişi',
			'Text size' => 'Metin boyutu',
			'Font picker' => 'Yazı tipi seçici',
			'Sticker picker' => 'Çıkartma seçici',
			'Emoji picker' => 'Emoji seçici',
			'Frame picker' => 'Çerçeve seçici',
			'Upload image' => 'Görsel yükle',
			'Drawing canvas' => 'Çizim tuvali',
		),
		'de' => array(
			'This shared puzzle is blocked because its data is invalid.' => 'Dieses geteilte Rätsel ist gesperrt, weil seine Daten ungültig sind.',
			'Play mode. Use arrow keys.' => 'Spielmodus. Nutze die Pfeiltasten.',
			'Puzzle solved.' => 'Rätsel gelöst.',
			'Saved to system.' => 'Im System gespeichert.',
			'Could not save puzzle.' => 'Rätsel konnte nicht gespeichert werden.',
			'Could not reach the puzzle save service.' => 'Rätsel-Speicherdienst nicht erreichbar.',
			'Could not load shared puzzles.' => 'Geteilte Rätsel konnten nicht geladen werden.',
			'Match the target in 5 moves.' => 'Triff das Ziel in 5 Zügen.',
			'Aligned! Nice!' => 'Ausgerichtet! Schön!',
			'Not aligned. Try again.' => 'Nicht ausgerichtet. Versuch es erneut.',
			'Hazır. Nil üzerinde hazineleri topla.' => 'Bereit. Sammle Schätze auf dem Nil.',
			'Altınları yakala. Timsahlardan kaç.' => 'Fange Gold. Weiche Krokodilen aus.',
			'Oyun bitti. Tekrar başla.' => 'Spiel vorbei. Starte erneut.',
			'Hazine yakaladın.' => 'Du hast einen Schatz gefangen.',
			'Timsaha çarptın.' => 'Du bist gegen ein Krokodil gestoßen.',
			'Bir hazineyi kaçırdın.' => 'Du hast einen Schatz verpasst.',
			'Pocket Team vs Block Team' => 'Taschenteam gegen Blockteam',
			'Wins' => 'gewinnt',
			'Every 5 seconds the game sends 1 enemy. More Enemies sends 2.' => 'Alle 5 Sekunden sendet das Spiel 1 Gegner. Mehr Gegner sendet 2.',
			'No moves yet.' => 'Noch keine Züge.',
			'Turn: ' => 'Zug: ',
			'You: ' => 'Du: ',
			'Question 0 / 100' => 'Frage 0 / 100',
			'No country selected yet' => 'Noch kein Land ausgewählt',
			'Write a country name in Turkish or English, then press Start Quiz.' => 'Schreibe einen Ländernamen auf Türkisch oder Englisch und drücke dann Quiz starten.',
			'Type text here' => 'Text hier eingeben',
			'Pick color' => 'Farbe wählen',
			'Brush size' => 'Pinselgröße',
			'Shape picker' => 'Formauswahl',
			'Text input' => 'Texteingabe',
			'Text size' => 'Textgröße',
			'Font picker' => 'Schriftauswahl',
			'Sticker picker' => 'Sticker-Auswahl',
			'Emoji picker' => 'Emoji-Auswahl',
			'Frame picker' => 'Rahmenauswahl',
			'Upload image' => 'Bild hochladen',
			'Drawing canvas' => 'Zeichenfläche',
		),
		'fr' => array(
			'This shared puzzle is blocked because its data is invalid.' => 'Ce puzzle partagé est bloqué car ses données sont invalides.',
			'Play mode. Use arrow keys.' => 'Mode jeu. Utilise les touches fléchées.',
			'Puzzle solved.' => 'Puzzle résolu.',
			'Saved to system.' => 'Enregistré dans le système.',
			'Could not save puzzle.' => 'Impossible d’enregistrer le puzzle.',
			'Could not reach the puzzle save service.' => 'Impossible de joindre le service d’enregistrement.',
			'Could not load shared puzzles.' => 'Impossible de charger les puzzles partagés.',
			'Match the target in 5 moves.' => 'Aligne la cible en 5 coups.',
			'Aligned! Nice!' => 'Aligné ! Bien joué !',
			'Not aligned. Try again.' => 'Pas aligné. Réessaie.',
			'Hazır. Nil üzerinde hazineleri topla.' => 'Prêt. Ramasse les trésors sur le Nil.',
			'Altınları yakala. Timsahlardan kaç.' => 'Attrape l’or. Évite les crocodiles.',
			'Oyun bitti. Tekrar başla.' => 'Partie terminée. Recommence.',
			'Hazine yakaladın.' => 'Tu as attrapé un trésor.',
			'Timsaha çarptın.' => 'Tu as percuté un crocodile.',
			'Bir hazineyi kaçırdın.' => 'Tu as raté un trésor.',
			'Pocket Team vs Block Team' => 'Équipe Pocket contre équipe Block',
			'Wins' => 'gagne',
			'Every 5 seconds the game sends 1 enemy. More Enemies sends 2.' => 'Toutes les 5 secondes, le jeu envoie 1 ennemi. Plus d’ennemis en envoie 2.',
			'No moves yet.' => 'Aucun coup pour l’instant.',
			'Turn: ' => 'Tour : ',
			'You: ' => 'Toi : ',
			'Question 0 / 100' => 'Question 0 / 100',
			'No country selected yet' => 'Aucun pays sélectionné',
			'Write a country name in Turkish or English, then press Start Quiz.' => 'Écris un nom de pays en turc ou en anglais, puis lance le quiz.',
			'Type text here' => 'Tape le texte ici',
			'Pick color' => 'Choisir une couleur',
			'Brush size' => 'Taille du pinceau',
			'Shape picker' => 'Choix de forme',
			'Text input' => 'Saisie de texte',
			'Text size' => 'Taille du texte',
			'Font picker' => 'Choix de police',
			'Sticker picker' => 'Choix d’autocollant',
			'Emoji picker' => 'Choix d’emoji',
			'Frame picker' => 'Choix de cadre',
			'Upload image' => 'Importer une image',
			'Drawing canvas' => 'Zone de dessin',
		),
		'es-mx' => array(
			'This shared puzzle is blocked because its data is invalid.' => 'Este rompecabezas compartido está bloqueado porque sus datos no son válidos.',
			'Play mode. Use arrow keys.' => 'Modo juego. Usa las flechas.',
			'Puzzle solved.' => 'Rompecabezas resuelto.',
			'Saved to system.' => 'Guardado en el sistema.',
			'Could not save puzzle.' => 'No se pudo guardar el rompecabezas.',
			'Could not reach the puzzle save service.' => 'No se pudo contactar el servicio de guardado.',
			'Could not load shared puzzles.' => 'No se pudieron cargar los rompecabezas compartidos.',
			'Match the target in 5 moves.' => 'Alinea el objetivo en 5 movimientos.',
			'Aligned! Nice!' => '¡Alineado! ¡Bien!',
			'Not aligned. Try again.' => 'No está alineado. Intenta de nuevo.',
			'Hazır. Nil üzerinde hazineleri topla.' => 'Listo. Recoge tesoros en el Nilo.',
			'Altınları yakala. Timsahlardan kaç.' => 'Atrapa oro. Evita cocodrilos.',
			'Oyun bitti. Tekrar başla.' => 'Fin del juego. Empieza de nuevo.',
			'Hazine yakaladın.' => 'Atrapaste un tesoro.',
			'Timsaha çarptın.' => 'Chocaste con un cocodrilo.',
			'Bir hazineyi kaçırdın.' => 'Se te escapó un tesoro.',
			'Pocket Team vs Block Team' => 'Equipo Pocket contra equipo Block',
			'Wins' => 'gana',
			'Every 5 seconds the game sends 1 enemy. More Enemies sends 2.' => 'Cada 5 segundos el juego envía 1 enemigo. Más enemigos envía 2.',
			'No moves yet.' => 'Aún no hay movimientos.',
			'Turn: ' => 'Turno: ',
			'You: ' => 'Tú: ',
			'Question 0 / 100' => 'Pregunta 0 / 100',
			'No country selected yet' => 'Aún no hay país seleccionado',
			'Write a country name in Turkish or English, then press Start Quiz.' => 'Escribe un país en turco o inglés y luego presiona Empezar quiz.',
			'Type text here' => 'Escribe texto aquí',
			'Pick color' => 'Elegir color',
			'Brush size' => 'Tamaño del pincel',
			'Shape picker' => 'Selector de forma',
			'Text input' => 'Entrada de texto',
			'Text size' => 'Tamaño del texto',
			'Font picker' => 'Selector de fuente',
			'Sticker picker' => 'Selector de sticker',
			'Emoji picker' => 'Selector de emoji',
			'Frame picker' => 'Selector de marco',
			'Upload image' => 'Subir imagen',
			'Drawing canvas' => 'Lienzo de dibujo',
		),
		'es-es' => array(
			'This shared puzzle is blocked because its data is invalid.' => 'Este puzle compartido está bloqueado porque sus datos no son válidos.',
			'Play mode. Use arrow keys.' => 'Modo juego. Usa las flechas.',
			'Puzzle solved.' => 'Puzle resuelto.',
			'Saved to system.' => 'Guardado en el sistema.',
			'Could not save puzzle.' => 'No se pudo guardar el puzle.',
			'Could not reach the puzzle save service.' => 'No se pudo contactar con el servicio de guardado.',
			'Could not load shared puzzles.' => 'No se pudieron cargar los puzles compartidos.',
			'Match the target in 5 moves.' => 'Alinea el objetivo en 5 movimientos.',
			'Aligned! Nice!' => '¡Alineado! ¡Bien!',
			'Not aligned. Try again.' => 'No está alineado. Inténtalo de nuevo.',
			'Hazır. Nil üzerinde hazineleri topla.' => 'Listo. Recoge tesoros en el Nilo.',
			'Altınları yakala. Timsahlardan kaç.' => 'Atrapa oro. Evita cocodrilos.',
			'Oyun bitti. Tekrar başla.' => 'Fin del juego. Empieza de nuevo.',
			'Hazine yakaladın.' => 'Has atrapado un tesoro.',
			'Timsaha çarptın.' => 'Has chocado con un cocodrilo.',
			'Bir hazineyi kaçırdın.' => 'Se te ha escapado un tesoro.',
			'Pocket Team vs Block Team' => 'Equipo Pocket contra equipo Block',
			'Wins' => 'gana',
			'Every 5 seconds the game sends 1 enemy. More Enemies sends 2.' => 'Cada 5 segundos el juego envía 1 enemigo. Más enemigos envía 2.',
			'No moves yet.' => 'Aún no hay movimientos.',
			'Turn: ' => 'Turno: ',
			'You: ' => 'Tú: ',
			'Question 0 / 100' => 'Pregunta 0 / 100',
			'No country selected yet' => 'Aún no hay país seleccionado',
			'Write a country name in Turkish or English, then press Start Quiz.' => 'Escribe un país en turco o inglés y luego pulsa Empezar quiz.',
			'Type text here' => 'Escribe texto aquí',
			'Pick color' => 'Elegir color',
			'Brush size' => 'Tamaño del pincel',
			'Shape picker' => 'Selector de forma',
			'Text input' => 'Entrada de texto',
			'Text size' => 'Tamaño del texto',
			'Font picker' => 'Selector de fuente',
			'Sticker picker' => 'Selector de pegatina',
			'Emoji picker' => 'Selector de emoji',
			'Frame picker' => 'Selector de marco',
			'Upload image' => 'Subir imagen',
			'Drawing canvas' => 'Lienzo de dibujo',
		),
	);

	foreach ($sitewide_runtime_exact_more as $more_lang => $more_items) {
		if (isset($translations[$more_lang])) {
			$translations[$more_lang] = array_merge($translations[$more_lang], $more_items);
		}
	}

	$sitewide_runtime_exact_agent_a_c = array(
		'tr' => array(
			'White to move.' => 'Sıra beyazda.',
			'wins by checkmate.' => 'mat ile kazandı.',
			'Stalemate.' => 'Pat.',
			'is in check.' => 'şah altında.',
			'to move.' => 'hamle yapacak.',
			'That piece has no legal move.' => 'Bu taşın yasal hamlesi yok.',
			'AI could not find a move.' => 'Yapay zeka hamle bulamadı.',
			'selected.' => 'seçildi.',
			'Pick a piece to move.' => 'Hamle yapmak için bir taş seç.',
			'Choose where to move.' => 'Nereye gideceğini seç.',
			'Pick one of your pieces.' => 'Kendi taşlarından birini seç.',
			'Move undone.' => 'Hamle geri alındı.',
			'Checkmate. You win.' => 'Mat. Sen kazandın.',
			'Checkmate. AI wins.' => 'Mat. Yapay zeka kazandı.',
			'Stalemate. Draw game.' => 'Pat. Berabere.',
			'Draw by 50-move rule.' => '50 hamle kuralıyla beraberlik.',
			'Your king is in check.' => 'Şahın tehdit altında.',
			'AI king is in check.' => 'Yapay zekanın şahı tehdit altında.',
			'No answers yet.' => 'Henüz cevap yok.',
			'Type an answer first.' => 'Önce bir cevap yaz.',
			'That does not start with' => 'Bu şununla başlamıyor:',
			'Game over. Final score:' => 'Oyun bitti. Son puan:',
			'out of' => '/',
			'Decode the message by replacing each cipher letter with the correct plain letter.' => 'Her şifreli harfi doğru açık harfle değiştirerek mesajı çöz.',
			'Correct! You cracked the cryptogram. Great job!' => 'Doğru! Kriptogramı çözdün. Harika iş!',
			'You solved it. Great binary brain work!' => 'Çözdün. Harika ikili mantık!',
			'Rule check: looking good so far.' => 'Kural kontrolü: şu ana kadar iyi.',
			'Target Combo: ' => 'Hedef Kombo: ',
		),
		'de' => array(
			'White to move.' => 'Weiß ist am Zug.',
			'wins by checkmate.' => 'gewinnt durch Schachmatt.',
			'Stalemate.' => 'Patt.',
			'is in check.' => 'steht im Schach.',
			'to move.' => 'ist am Zug.',
			'That piece has no legal move.' => 'Diese Figur hat keinen legalen Zug.',
			'AI could not find a move.' => 'Die KI konnte keinen Zug finden.',
			'selected.' => 'ausgewählt.',
			'Pick a piece to move.' => 'Wähle eine Figur zum Ziehen.',
			'Choose where to move.' => 'Wähle das Zielfeld.',
			'Pick one of your pieces.' => 'Wähle eine deiner Figuren.',
			'Move undone.' => 'Zug rückgängig gemacht.',
			'Checkmate. You win.' => 'Schachmatt. Du gewinnst.',
			'Checkmate. AI wins.' => 'Schachmatt. Die KI gewinnt.',
			'Stalemate. Draw game.' => 'Patt. Remis.',
			'Draw by 50-move rule.' => 'Remis durch 50-Züge-Regel.',
			'Your king is in check.' => 'Dein König steht im Schach.',
			'AI king is in check.' => 'Der KI-König steht im Schach.',
			'No answers yet.' => 'Noch keine Antworten.',
			'Type an answer first.' => 'Gib zuerst eine Antwort ein.',
			'That does not start with' => 'Das beginnt nicht mit',
			'Game over. Final score:' => 'Spiel vorbei. Endstand:',
			'out of' => 'von',
			'Decode the message by replacing each cipher letter with the correct plain letter.' => 'Entschlüssele die Nachricht, indem du jeden Geheimtext-Buchstaben ersetzt.',
			'Correct! You cracked the cryptogram. Great job!' => 'Richtig! Du hast das Kryptogramm geknackt. Gut gemacht!',
			'You solved it. Great binary brain work!' => 'Gelöst. Starke Binärleistung!',
			'Rule check: looking good so far.' => 'Regelprüfung: bisher sieht alles gut aus.',
			'Target Combo: ' => 'Zielkombination: ',
		),
		'fr' => array(
			'White to move.' => 'Aux blancs de jouer.',
			'wins by checkmate.' => 'gagne par échec et mat.',
			'Stalemate.' => 'Pat.',
			'is in check.' => 'est en échec.',
			'to move.' => 'doit jouer.',
			'That piece has no legal move.' => 'Cette pièce n’a aucun coup légal.',
			'AI could not find a move.' => 'L’IA n’a trouvé aucun coup.',
			'selected.' => 'sélectionné.',
			'Pick a piece to move.' => 'Choisis une pièce à déplacer.',
			'Choose where to move.' => 'Choisis où jouer.',
			'Pick one of your pieces.' => 'Choisis une de tes pièces.',
			'Move undone.' => 'Coup annulé.',
			'Checkmate. You win.' => 'Échec et mat. Tu gagnes.',
			'Checkmate. AI wins.' => 'Échec et mat. L’IA gagne.',
			'Stalemate. Draw game.' => 'Pat. Match nul.',
			'Draw by 50-move rule.' => 'Nulle par la règle des 50 coups.',
			'Your king is in check.' => 'Ton roi est en échec.',
			'AI king is in check.' => 'Le roi de l’IA est en échec.',
			'No answers yet.' => 'Aucune réponse pour l’instant.',
			'Type an answer first.' => 'Écris d’abord une réponse.',
			'That does not start with' => 'Cela ne commence pas par',
			'Game over. Final score:' => 'Partie terminée. Score final :',
			'out of' => 'sur',
			'Decode the message by replacing each cipher letter with the correct plain letter.' => 'Décode le message en remplaçant chaque lettre chiffrée par la bonne lettre.',
			'Correct! You cracked the cryptogram. Great job!' => 'Correct ! Tu as percé le cryptogramme. Bravo !',
			'You solved it. Great binary brain work!' => 'Résolu. Beau travail binaire !',
			'Rule check: looking good so far.' => 'Vérification des règles : tout va bien pour l’instant.',
			'Target Combo: ' => 'Combo cible : ',
		),
		'es-mx' => array(
			'White to move.' => 'Juegan blancas.',
			'wins by checkmate.' => 'gana por jaque mate.',
			'Stalemate.' => 'Tablas por ahogado.',
			'is in check.' => 'está en jaque.',
			'to move.' => 'juega.',
			'That piece has no legal move.' => 'Esa pieza no tiene movimientos legales.',
			'AI could not find a move.' => 'La IA no pudo encontrar una jugada.',
			'selected.' => 'seleccionada.',
			'Pick a piece to move.' => 'Elige una pieza para mover.',
			'Choose where to move.' => 'Elige a dónde mover.',
			'Pick one of your pieces.' => 'Elige una de tus piezas.',
			'Move undone.' => 'Jugada deshecha.',
			'Checkmate. You win.' => 'Jaque mate. Ganaste.',
			'Checkmate. AI wins.' => 'Jaque mate. Gana la IA.',
			'Stalemate. Draw game.' => 'Ahogado. Empate.',
			'Draw by 50-move rule.' => 'Empate por regla de 50 jugadas.',
			'Your king is in check.' => 'Tu rey está en jaque.',
			'AI king is in check.' => 'El rey de la IA está en jaque.',
			'No answers yet.' => 'Aún no hay respuestas.',
			'Type an answer first.' => 'Escribe una respuesta primero.',
			'That does not start with' => 'Eso no empieza con',
			'Game over. Final score:' => 'Fin del juego. Puntuación final:',
			'out of' => 'de',
			'Decode the message by replacing each cipher letter with the correct plain letter.' => 'Decodifica el mensaje reemplazando cada letra cifrada por la correcta.',
			'Correct! You cracked the cryptogram. Great job!' => '¡Correcto! Descifraste el criptograma. ¡Buen trabajo!',
			'You solved it. Great binary brain work!' => 'Lo resolviste. ¡Gran trabajo binario!',
			'Rule check: looking good so far.' => 'Revisión de reglas: todo va bien hasta ahora.',
			'Target Combo: ' => 'Combo objetivo: ',
		),
		'es-es' => array(
			'White to move.' => 'Juegan blancas.',
			'wins by checkmate.' => 'gana por jaque mate.',
			'Stalemate.' => 'Tablas por ahogado.',
			'is in check.' => 'está en jaque.',
			'to move.' => 'juega.',
			'That piece has no legal move.' => 'Esa pieza no tiene movimientos legales.',
			'AI could not find a move.' => 'La IA no pudo encontrar una jugada.',
			'selected.' => 'seleccionada.',
			'Pick a piece to move.' => 'Elige una pieza para mover.',
			'Choose where to move.' => 'Elige adónde mover.',
			'Pick one of your pieces.' => 'Elige una de tus piezas.',
			'Move undone.' => 'Jugada deshecha.',
			'Checkmate. You win.' => 'Jaque mate. Has ganado.',
			'Checkmate. AI wins.' => 'Jaque mate. Gana la IA.',
			'Stalemate. Draw game.' => 'Ahogado. Tablas.',
			'Draw by 50-move rule.' => 'Tablas por la regla de los 50 movimientos.',
			'Your king is in check.' => 'Tu rey está en jaque.',
			'AI king is in check.' => 'El rey de la IA está en jaque.',
			'No answers yet.' => 'Todavía no hay respuestas.',
			'Type an answer first.' => 'Escribe primero una respuesta.',
			'That does not start with' => 'Eso no empieza por',
			'Game over. Final score:' => 'Fin de la partida. Puntuación final:',
			'out of' => 'de',
			'Decode the message by replacing each cipher letter with the correct plain letter.' => 'Descifra el mensaje sustituyendo cada letra cifrada por la letra correcta.',
			'Correct! You cracked the cryptogram. Great job!' => '¡Correcto! Has descifrado el criptograma. ¡Buen trabajo!',
			'You solved it. Great binary brain work!' => 'Lo has resuelto. ¡Gran trabajo binario!',
			'Rule check: looking good so far.' => 'Comprobación de reglas: todo va bien por ahora.',
			'Target Combo: ' => 'Combo objetivo: ',
		),
	);

	foreach ($sitewide_runtime_exact_agent_a_c as $agent_ac_lang => $agent_ac_items) {
		if (isset($translations[$agent_ac_lang])) {
			$translations[$agent_ac_lang] = array_merge($translations[$agent_ac_lang], $agent_ac_items);
		}
	}

	$sitewide_runtime_exact_agent_more = array(
		'tr' => array(
			'Ready to draw' => 'Cizmeye hazir',
			'Could not save drawing state' => 'Cizim durumu kaydedilemedi',
			'Type some text first' => 'Once biraz metin yaz',
			'Text added' => 'Metin eklendi',
			'Sticker added' => 'Cikartma eklendi',
			'Emoji added' => 'Emoji eklendi',
			'Choose a frame first' => 'Once bir cerceve sec',
			'Frame applied' => 'Cerceve uygulandi',
			'Canvas cleared' => 'Tuval temizlendi',
			'Image loaded' => 'Gorsel yuklendi',
			'Selection ready. Drag it to move.' => 'Secim hazir. Tasimak icin surukle.',
			'Switch filters. Different inks reveal different clues.' => 'Filtreleri degistir. Farkli murekkepler farkli ipuclari gosterir.',
			'Nothing useful yet.' => 'Henuz ise yarar bir sey yok.',
			'Case solved. The clues only made sense under the right light.' => 'Dava cozuldu. Ipuclari ancak dogru isikta anlam kazandi.',
			'Invent a language. Combine syllables and test whether your word has the right power.' => 'Bir dil icat et. Heceleri birlestir ve kelimenin dogru guce sahip olup olmadigini dene.',
			'The word worked. The next puzzle needs a richer phrase.' => 'Kelime ise yaradi. Siradaki bulmaca daha zengin bir ifade istiyor.',
			'Build a 10-second loop. Ore becomes gears, gears become crates, and better placement boosts output.' => '10 saniyelik bir dongu kur. Cevher disliye, disli sandiga donusur; iyi yerlesim uretimi artirir.',
			'Factory optimized. Your loop now prints value every cycle.' => 'Fabrika optimize edildi. Dongun artik her tur deger uretiyor.',
			'The AI team wins.' => 'Yapay zeka takimi kazandi.',
			'Your team wins.' => 'Takimin kazandi.',
			'Battle start. Pick an action.' => 'Savas basladi. Bir eylem sec.',
			'You win the match.' => 'Maci kazandin.',
			'You lose the match.' => 'Maci kaybettin.',
			'The match ends in a draw.' => 'Mac berabere bitti.',
			'New season started.' => 'Yeni sezon basladi.',
			'Computer Wins' => 'Bilgisayar kazandi',
			'Tie Game' => 'Berabere',
			'Great job. You found a match.' => 'Harika is. Bir eslesme buldun.',
			'Not a match. Try again.' => 'Eslesmedi. Tekrar dene.',
			'Find all the matching animal pairs.' => 'Tum eslesen hayvan ciftlerini bul.',
			'Build the sequence.' => 'Diziyi olustur.',
			'Expand across the body. Mutation helps you survive immune attacks.' => 'Vucuda yayil. Mutasyon bagisiklik saldirilarindan sag cikmana yardim eder.',
			'Solved. Every click was mirrored across both axes.' => 'Cozuldu. Her tiklama iki eksende de yansitildi.',
			'You always lose.' => 'Her zaman kaybedersin.',
			'The town is calm. Watch patterns appear as routines overlap.' => 'Kasaba sakin. Rutinler cakistikca desenlerin olusmasini izle.',
			'Paused' => 'Duraklatildi',
			'Running' => 'Calisiyor',
			'Match the blue pointer to the red pointer. Then press Check Angle.' => 'Mavi ibreyi kirmizi ibreyle eslestir. Sonra Aciyi Kontrol Et dugmesine bas.',
			'Ready?' => 'Hazir misin?',
			'Press Space to start. Use Arrow keys or A and D to move.' => 'Baslamak icin Bosluk tusuna bas. Hareket etmek icin ok tuslarini veya A ve D tuslarini kullan.',
			'Press Space, Enter, or Restart to play again.' => 'Yeniden oynamak icin Bosluk, Enter veya Yeniden Baslat tusuna bas.',
			'Use the jump buttons to move along the number line.' => 'Sayi dogrusunda ilerlemek icin ziplama dugmelerini kullan.',
			'That jump goes off the number line.' => 'Bu ziplama sayi dogrusunun disina cikiyor.',
			'Nice. You landed on the target. Press Check.' => 'Guzel. Hedefe indin. Kontrol Et dugmesine bas.',
			'You are below the target.' => 'Hedefin altindasin.',
			'You are above the target.' => 'Hedefin ustundesin.',
			'It\'s a tie!' => 'Berabere!',
			'You win!' => 'Kazandin!',
			'You lose!' => 'Kaybettin!',
			'Make your move.' => 'Hamleni yap.',
			'No heals left.' => 'Iyilestirme kalmadi.',
			'You won. Enemy rocket was defeated.' => 'Kazandin. Dusman roketi yenildi.',
			'You lost. Your rocket was defeated.' => 'Kaybettin. Roketin yenildi.',
			'Time is up. Press restart and beat your score.' => 'Sure doldu. Yeniden baslat ve skorunu gec.',
			'The garden bloomed. New plant unlocked.' => 'Bahce cicek acti. Yeni bitki acildi.',
			'Match found. Keep growing the garden.' => 'Eslesme bulundu. Bahceyi buyutmeye devam et.',
			'Not a pair yet.' => 'Henuz bir cift degil.',
			'Blocked. Find another path.' => 'Engellendi. Baska bir yol bul.',
			'Remember the order, then tap it back' => 'Sirayi hatirla, sonra ayni sirayla dokun',
			'You are out of lives. Press Start.' => 'Canin kalmadi. Baslat dugmesine bas.',
			'Pick the OPPOSITE.' => 'TERSINI sec.',
			'Listen carefully.' => 'Dikkatli dinle.',
			'Repeat the pattern.' => 'Deseni tekrarla.',
			'Click around the room to search for clues.' => 'Ipuclari aramak icin odanin cevresine tikla.',
			'No items yet.' => 'Henuz esya yok.',
			'The door is still locked.' => 'Kapi hala kilitli.',
			'Press Start Game to begin.' => 'Baslamak icin Oyunu Baslat dugmesine bas.',
			'Type what kind of game you want first.' => 'Once ne tur oyun istedigini yaz.',
			'No good match yet. Try words like chess, blocks, word, or category.' => 'Henuz iyi bir eslesme yok. Satranc, blok, kelime veya kategori gibi kelimeler dene.',
			'Best match found. Press "Open Selected Game".' => 'En iyi eslesme bulundu. "Secili Oyunu Ac" dugmesine bas.',
			'Reach the door on the right...' => 'Sagdaki kapiya ulas...',
			'Caught by a ceiling crawler. Restart the room.' => 'Tavan gezgini yakaladi. Odayi yeniden baslat.',
			'Out of moves. Gravity is powerful, but expensive.' => 'Hamle kalmadi. Yer cekimi guclu ama pahali.',
			'You already tried that letter.' => 'Bu harfi zaten denedin.',
			'Enter one letter.' => 'Bir harf gir.',
			'Bu sayfada hangi oyun calissin?' => 'Bu sayfada hangi oyun calissin?',
			'Bir oyun secin' => 'Bir oyun secin',
			'Bu oyun hangi listeye eklensin?' => 'Bu oyun hangi listeye eklensin?',
			'Arslan ya da Asker oyun listesi buna gore filtrelenir.' => 'Arslan ya da Asker oyun listesi buna gore filtrelenir.',
			'Oyun bulunamadi.' => 'Oyun bulunamadi.',
			'Bu oyun henuz goruntulenemiyor.' => 'Bu oyun henuz goruntulenemiyor.',
			'Henuz oyun bulunamadi.' => 'Henuz oyun bulunamadi.',
			'Filtreye uyan oyun bulunamadi.' => 'Filtreye uyan oyun bulunamadi.',
			'Game stats' => 'Oyun istatistikleri',
			'game area' => 'oyun alani',
			'Game area' => 'Oyun alani',
			'Game controls' => 'Oyun kontrolleri',
			'Ready.' => 'Hazir.',
			'RUN' => 'KOS',
			'Point' => 'Nokta',
			'AI difficulty' => 'Yapay zeka zorlugu',
			'Easy AI' => 'Kolay yapay zeka',
			'Medium AI' => 'Orta yapay zeka',
			'Hard AI' => 'Zor yapay zeka',
			'Game speed' => 'Oyun hizi',
			'Speed x1' => 'Hiz x1',
			'Speed x1.5' => 'Hiz x1.5',
			'Speed x2' => 'Hiz x2',
			'Select Operation' => 'Islem sec',
			'Enter First Number' => 'Ilk sayiyi gir',
			'Enter Second Number' => 'Ikinci sayiyi gir',
			'Operation' => 'Islem',
			'Square Root' => 'Karekok',
			'Result' => 'Sonuc',
			'Start Quiz' => 'Testi baslat',
			'Type a country name to begin.' => 'Baslamak icin bir ulke adi yaz.',
		),
		'de' => array(
			'Ready to draw' => 'Bereit zum Zeichnen',
			'Could not save drawing state' => 'Zeichenstatus konnte nicht gespeichert werden',
			'Type some text first' => 'Gib zuerst Text ein',
			'Text added' => 'Text hinzugefugt',
			'Sticker added' => 'Sticker hinzugefugt',
			'Emoji added' => 'Emoji hinzugefugt',
			'Choose a frame first' => 'Wahle zuerst einen Rahmen',
			'Frame applied' => 'Rahmen angewendet',
			'Canvas cleared' => 'Leinwand geleert',
			'Image loaded' => 'Bild geladen',
			'Selection ready. Drag it to move.' => 'Auswahl bereit. Zum Verschieben ziehen.',
			'Switch filters. Different inks reveal different clues.' => 'Wechsle die Filter. Verschiedene Tinten zeigen verschiedene Hinweise.',
			'Nothing useful yet.' => 'Noch nichts Nutzliches.',
			'Case solved. The clues only made sense under the right light.' => 'Fall gelost. Die Hinweise ergaben nur im richtigen Licht Sinn.',
			'Invent a language. Combine syllables and test whether your word has the right power.' => 'Erfinde eine Sprache. Kombiniere Silben und teste, ob dein Wort die richtige Kraft hat.',
			'The word worked. The next puzzle needs a richer phrase.' => 'Das Wort hat funktioniert. Das nachste Ratsel braucht eine reichere Phrase.',
			'Build a 10-second loop. Ore becomes gears, gears become crates, and better placement boosts output.' => 'Baue eine 10-Sekunden-Schleife. Erz wird zu Zahnradern, Zahnrader zu Kisten, bessere Platzierung steigert den Ertrag.',
			'Factory optimized. Your loop now prints value every cycle.' => 'Fabrik optimiert. Deine Schleife erzeugt nun in jedem Zyklus Wert.',
			'The AI team wins.' => 'Das KI-Team gewinnt.',
			'Your team wins.' => 'Dein Team gewinnt.',
			'Battle start. Pick an action.' => 'Kampf beginnt. Wahle eine Aktion.',
			'You win the match.' => 'Du gewinnst das Spiel.',
			'You lose the match.' => 'Du verlierst das Spiel.',
			'The match ends in a draw.' => 'Das Spiel endet unentschieden.',
			'New season started.' => 'Neue Saison gestartet.',
			'Computer Wins' => 'Computer gewinnt',
			'Tie Game' => 'Unentschieden',
			'Great job. You found a match.' => 'Gut gemacht. Du hast ein Paar gefunden.',
			'Not a match. Try again.' => 'Kein Paar. Versuch es noch einmal.',
			'Find all the matching animal pairs.' => 'Finde alle passenden Tierpaare.',
			'Build the sequence.' => 'Baue die Reihenfolge.',
			'Expand across the body. Mutation helps you survive immune attacks.' => 'Breite dich im Korper aus. Mutation hilft dir, Immunangriffe zu uberleben.',
			'Solved. Every click was mirrored across both axes.' => 'Gelost. Jeder Klick wurde uber beide Achsen gespiegelt.',
			'You always lose.' => 'Du verlierst immer.',
			'The town is calm. Watch patterns appear as routines overlap.' => 'Die Stadt ist ruhig. Beobachte, wie Muster entstehen, wenn Routinen sich uberlappen.',
			'Paused' => 'Pausiert',
			'Running' => 'Lauft',
			'Match the blue pointer to the red pointer. Then press Check Angle.' => 'Passe den blauen Zeiger an den roten Zeiger an. Drucken dann Winkel prufen.',
			'Ready?' => 'Bereit?',
			'Press Space to start. Use Arrow keys or A and D to move.' => 'Drucke Leertaste zum Starten. Nutze Pfeiltasten oder A und D zum Bewegen.',
			'Press Space, Enter, or Restart to play again.' => 'Drucke Leertaste, Eingabe oder Neustart, um erneut zu spielen.',
			'Use the jump buttons to move along the number line.' => 'Nutze die Sprungknopfe, um dich auf dem Zahlenstrahl zu bewegen.',
			'That jump goes off the number line.' => 'Dieser Sprung geht vom Zahlenstrahl herunter.',
			'Nice. You landed on the target. Press Check.' => 'Gut. Du bist auf dem Ziel gelandet. Drucke Prufen.',
			'You are below the target.' => 'Du bist unter dem Ziel.',
			'You are above the target.' => 'Du bist uber dem Ziel.',
			'It\'s a tie!' => 'Unentschieden!',
			'You win!' => 'Du gewinnst!',
			'You lose!' => 'Du verlierst!',
			'Make your move.' => 'Mach deinen Zug.',
			'No heals left.' => 'Keine Heilungen ubrig.',
			'You won. Enemy rocket was defeated.' => 'Du hast gewonnen. Die feindliche Rakete wurde besiegt.',
			'You lost. Your rocket was defeated.' => 'Du hast verloren. Deine Rakete wurde besiegt.',
			'Time is up. Press restart and beat your score.' => 'Die Zeit ist um. Starte neu und schlage deine Punktzahl.',
			'The garden bloomed. New plant unlocked.' => 'Der Garten bluht. Neue Pflanze freigeschaltet.',
			'Match found. Keep growing the garden.' => 'Paar gefunden. Lass den Garten weiter wachsen.',
			'Not a pair yet.' => 'Noch kein Paar.',
			'Blocked. Find another path.' => 'Blockiert. Finde einen anderen Weg.',
			'Remember the order, then tap it back' => 'Merke dir die Reihenfolge und tippe sie dann nach',
			'You are out of lives. Press Start.' => 'Du hast keine Leben mehr. Drucke Start.',
			'Pick the OPPOSITE.' => 'Wahle das GEGENTEIL.',
			'Listen carefully.' => 'Hore gut zu.',
			'Repeat the pattern.' => 'Wiederhole das Muster.',
			'Click around the room to search for clues.' => 'Klicke im Raum herum, um Hinweise zu suchen.',
			'No items yet.' => 'Noch keine Gegenstande.',
			'The door is still locked.' => 'Die Tur ist noch verschlossen.',
			'Press Start Game to begin.' => 'Drucke Spiel starten, um zu beginnen.',
			'Type what kind of game you want first.' => 'Gib zuerst ein, welche Art Spiel du willst.',
			'No good match yet. Try words like chess, blocks, word, or category.' => 'Noch kein guter Treffer. Versuche Worter wie Schach, Blocke, Wort oder Kategorie.',
			'Best match found. Press "Open Selected Game".' => 'Bester Treffer gefunden. Drucke "Ausgewahltes Spiel offnen".',
			'Reach the door on the right...' => 'Erreiche die Tur rechts...',
			'Caught by a ceiling crawler. Restart the room.' => 'Von einem Deckenkrabbler erwischt. Starte den Raum neu.',
			'Out of moves. Gravity is powerful, but expensive.' => 'Keine Zuge mehr. Schwerkraft ist machtig, aber teuer.',
			'You already tried that letter.' => 'Diesen Buchstaben hast du schon versucht.',
			'Enter one letter.' => 'Gib einen Buchstaben ein.',
			'Bu sayfada hangi oyun calissin?' => 'Welches Spiel soll auf dieser Seite laufen?',
			'Bir oyun secin' => 'Spiel auswahlen',
			'Bu oyun hangi listeye eklensin?' => 'Zu welcher Liste soll dieses Spiel hinzugefugt werden?',
			'Arslan ya da Asker oyun listesi buna gore filtrelenir.' => 'Die Arslan- oder Asker-Spieleliste wird danach gefiltert.',
			'Oyun bulunamadi.' => 'Spiel nicht gefunden.',
			'Bu oyun henuz goruntulenemiyor.' => 'Dieses Spiel kann noch nicht angezeigt werden.',
			'Henuz oyun bulunamadi.' => 'Noch keine Spiele gefunden.',
			'Filtreye uyan oyun bulunamadi.' => 'Kein Spiel passt zum Filter.',
			'Game stats' => 'Spielstatistiken',
			'game area' => 'Spielbereich',
			'Game area' => 'Spielbereich',
			'Game controls' => 'Spielsteuerung',
			'Ready.' => 'Bereit.',
			'RUN' => 'LAUFEN',
			'Point' => 'Punkt',
			'AI difficulty' => 'KI-Schwierigkeit',
			'Easy AI' => 'Einfache KI',
			'Medium AI' => 'Mittlere KI',
			'Hard AI' => 'Schwere KI',
			'Game speed' => 'Spielgeschwindigkeit',
			'Speed x1' => 'Geschwindigkeit x1',
			'Speed x1.5' => 'Geschwindigkeit x1,5',
			'Speed x2' => 'Geschwindigkeit x2',
			'Select Operation' => 'Rechenart auswahlen',
			'Enter First Number' => 'Erste Zahl eingeben',
			'Enter Second Number' => 'Zweite Zahl eingeben',
			'Operation' => 'Rechenart',
			'Square Root' => 'Quadratwurzel',
			'Result' => 'Ergebnis',
			'Start Quiz' => 'Quiz starten',
			'Type a country name to begin.' => 'Gib einen Landernamen ein, um zu beginnen.',
		),
		'fr' => array(
			'Ready to draw' => 'Pret a dessiner',
			'Could not save drawing state' => 'Impossible d enregistrer l etat du dessin',
			'Type some text first' => 'Saisis d abord du texte',
			'Text added' => 'Texte ajoute',
			'Sticker added' => 'Autocollant ajoute',
			'Emoji added' => 'Emoji ajoute',
			'Choose a frame first' => 'Choisis d abord un cadre',
			'Frame applied' => 'Cadre applique',
			'Canvas cleared' => 'Toile effacee',
			'Image loaded' => 'Image chargee',
			'Selection ready. Drag it to move.' => 'Selection prete. Fais-la glisser pour la deplacer.',
			'Switch filters. Different inks reveal different clues.' => 'Change de filtre. Des encres differentes revelent des indices differents.',
			'Nothing useful yet.' => 'Rien d utile pour l instant.',
			'Case solved. The clues only made sense under the right light.' => 'Affaire resolue. Les indices n avaient de sens qu a la bonne lumiere.',
			'Invent a language. Combine syllables and test whether your word has the right power.' => 'Invente une langue. Combine les syllabes et teste si ton mot a le bon pouvoir.',
			'The word worked. The next puzzle needs a richer phrase.' => 'Le mot a fonctionne. La prochaine enigme demande une phrase plus riche.',
			'Build a 10-second loop. Ore becomes gears, gears become crates, and better placement boosts output.' => 'Construis une boucle de 10 secondes. Le minerai devient engrenages, les engrenages deviennent caisses, et un bon placement augmente la production.',
			'Factory optimized. Your loop now prints value every cycle.' => 'Usine optimisee. Ta boucle produit maintenant de la valeur a chaque cycle.',
			'The AI team wins.' => 'L equipe IA gagne.',
			'Your team wins.' => 'Ton equipe gagne.',
			'Battle start. Pick an action.' => 'Le combat commence. Choisis une action.',
			'You win the match.' => 'Tu gagnes le match.',
			'You lose the match.' => 'Tu perds le match.',
			'The match ends in a draw.' => 'Le match se termine par un nul.',
			'New season started.' => 'Nouvelle saison lancee.',
			'Computer Wins' => 'L ordinateur gagne',
			'Tie Game' => 'Egalite',
			'Great job. You found a match.' => 'Bien joue. Tu as trouve une paire.',
			'Not a match. Try again.' => 'Pas une paire. Reessaie.',
			'Find all the matching animal pairs.' => 'Trouve toutes les paires d animaux.',
			'Build the sequence.' => 'Recree la sequence.',
			'Expand across the body. Mutation helps you survive immune attacks.' => 'Etends-toi dans le corps. La mutation t aide a survivre aux attaques immunitaires.',
			'Solved. Every click was mirrored across both axes.' => 'Resolu. Chaque clic a ete reflete sur les deux axes.',
			'You always lose.' => 'Tu perds toujours.',
			'The town is calm. Watch patterns appear as routines overlap.' => 'La ville est calme. Observe les motifs apparaitre quand les routines se croisent.',
			'Paused' => 'En pause',
			'Running' => 'En cours',
			'Match the blue pointer to the red pointer. Then press Check Angle.' => 'Aligne le pointeur bleu sur le pointeur rouge. Puis appuie sur Verifier l angle.',
			'Ready?' => 'Pret ?',
			'Press Space to start. Use Arrow keys or A and D to move.' => 'Appuie sur Espace pour commencer. Utilise les fleches ou A et D pour bouger.',
			'Press Space, Enter, or Restart to play again.' => 'Appuie sur Espace, Entree ou Redemarrer pour rejouer.',
			'Use the jump buttons to move along the number line.' => 'Utilise les boutons de saut pour avancer sur la ligne numerique.',
			'That jump goes off the number line.' => 'Ce saut sort de la ligne numerique.',
			'Nice. You landed on the target. Press Check.' => 'Bien. Tu as atteint la cible. Appuie sur Verifier.',
			'You are below the target.' => 'Tu es sous la cible.',
			'You are above the target.' => 'Tu es au-dessus de la cible.',
			'It\'s a tie!' => 'Egalite !',
			'You win!' => 'Tu gagnes !',
			'You lose!' => 'Tu perds !',
			'Make your move.' => 'Joue ton coup.',
			'No heals left.' => 'Plus de soins.',
			'You won. Enemy rocket was defeated.' => 'Tu as gagne. La fusee ennemie est vaincue.',
			'You lost. Your rocket was defeated.' => 'Tu as perdu. Ta fusee est vaincue.',
			'Time is up. Press restart and beat your score.' => 'Le temps est ecoule. Redemarre et bats ton score.',
			'The garden bloomed. New plant unlocked.' => 'Le jardin a fleuri. Nouvelle plante debloquee.',
			'Match found. Keep growing the garden.' => 'Paire trouvee. Continue a faire pousser le jardin.',
			'Not a pair yet.' => 'Ce n est pas encore une paire.',
			'Blocked. Find another path.' => 'Bloque. Trouve un autre chemin.',
			'Remember the order, then tap it back' => 'Memorise l ordre, puis retape-le',
			'You are out of lives. Press Start.' => 'Tu n as plus de vies. Appuie sur Demarrer.',
			'Pick the OPPOSITE.' => 'Choisis l OPPOSE.',
			'Listen carefully.' => 'Ecoute attentivement.',
			'Repeat the pattern.' => 'Repete le motif.',
			'Click around the room to search for clues.' => 'Clique dans la piece pour chercher des indices.',
			'No items yet.' => 'Aucun objet pour le moment.',
			'The door is still locked.' => 'La porte est encore verrouillee.',
			'Press Start Game to begin.' => 'Appuie sur Demarrer le jeu pour commencer.',
			'Type what kind of game you want first.' => 'Ecris d abord le type de jeu que tu veux.',
			'No good match yet. Try words like chess, blocks, word, or category.' => 'Pas encore de bon resultat. Essaie des mots comme echecs, blocs, mot ou categorie.',
			'Best match found. Press "Open Selected Game".' => 'Meilleur resultat trouve. Appuie sur "Ouvrir le jeu selectionne".',
			'Reach the door on the right...' => 'Atteins la porte a droite...',
			'Caught by a ceiling crawler. Restart the room.' => 'Attrape par une creature au plafond. Redemarre la piece.',
			'Out of moves. Gravity is powerful, but expensive.' => 'Plus de coups. La gravite est puissante, mais couteuse.',
			'You already tried that letter.' => 'Tu as deja essaye cette lettre.',
			'Enter one letter.' => 'Entre une lettre.',
			'Bu sayfada hangi oyun calissin?' => 'Quel jeu doit etre lance sur cette page ?',
			'Bir oyun secin' => 'Choisir un jeu',
			'Bu oyun hangi listeye eklensin?' => 'A quelle liste ajouter ce jeu ?',
			'Arslan ya da Asker oyun listesi buna gore filtrelenir.' => 'La liste de jeux Arslan ou Asker est filtree selon ce choix.',
			'Oyun bulunamadi.' => 'Jeu introuvable.',
			'Bu oyun henuz goruntulenemiyor.' => 'Ce jeu ne peut pas encore etre affiche.',
			'Henuz oyun bulunamadi.' => 'Aucun jeu trouve pour le moment.',
			'Filtreye uyan oyun bulunamadi.' => 'Aucun jeu ne correspond au filtre.',
			'Game stats' => 'Statistiques du jeu',
			'game area' => 'zone de jeu',
			'Game area' => 'Zone de jeu',
			'Game controls' => 'Commandes du jeu',
			'Ready.' => 'Pret.',
			'RUN' => 'COURIR',
			'Point' => 'Point',
			'AI difficulty' => 'Difficulte de l IA',
			'Easy AI' => 'IA facile',
			'Medium AI' => 'IA moyenne',
			'Hard AI' => 'IA difficile',
			'Game speed' => 'Vitesse du jeu',
			'Speed x1' => 'Vitesse x1',
			'Speed x1.5' => 'Vitesse x1,5',
			'Speed x2' => 'Vitesse x2',
			'Select Operation' => 'Choisir une operation',
			'Enter First Number' => 'Saisir le premier nombre',
			'Enter Second Number' => 'Saisir le deuxieme nombre',
			'Operation' => 'Operation',
			'Square Root' => 'Racine carree',
			'Result' => 'Resultat',
			'Start Quiz' => 'Demarrer le quiz',
			'Type a country name to begin.' => 'Saisis un nom de pays pour commencer.',
		),
		'es-mx' => array(
			'Ready to draw' => 'Listo para dibujar',
			'Could not save drawing state' => 'No se pudo guardar el estado del dibujo',
			'Type some text first' => 'Escribe texto primero',
			'Text added' => 'Texto agregado',
			'Sticker added' => 'Sticker agregado',
			'Emoji added' => 'Emoji agregado',
			'Choose a frame first' => 'Elige un marco primero',
			'Frame applied' => 'Marco aplicado',
			'Canvas cleared' => 'Lienzo borrado',
			'Image loaded' => 'Imagen cargada',
			'Selection ready. Drag it to move.' => 'Seleccion lista. Arrastrala para moverla.',
			'Switch filters. Different inks reveal different clues.' => 'Cambia los filtros. Distintas tintas revelan distintas pistas.',
			'Nothing useful yet.' => 'Nada util todavia.',
			'Case solved. The clues only made sense under the right light.' => 'Caso resuelto. Las pistas solo tenian sentido con la luz correcta.',
			'Invent a language. Combine syllables and test whether your word has the right power.' => 'Inventa un idioma. Combina silabas y prueba si tu palabra tiene el poder correcto.',
			'The word worked. The next puzzle needs a richer phrase.' => 'La palabra funciono. El siguiente reto necesita una frase mas completa.',
			'Build a 10-second loop. Ore becomes gears, gears become crates, and better placement boosts output.' => 'Crea un ciclo de 10 segundos. El mineral se vuelve engranes, los engranes cajas, y una mejor colocacion aumenta la produccion.',
			'Factory optimized. Your loop now prints value every cycle.' => 'Fabrica optimizada. Tu ciclo ahora produce valor en cada vuelta.',
			'The AI team wins.' => 'Gana el equipo de IA.',
			'Your team wins.' => 'Tu equipo gana.',
			'Battle start. Pick an action.' => 'Inicia la batalla. Elige una accion.',
			'You win the match.' => 'Ganaste el partido.',
			'You lose the match.' => 'Perdiste el partido.',
			'The match ends in a draw.' => 'El partido termina en empate.',
			'New season started.' => 'Nueva temporada iniciada.',
			'Computer Wins' => 'Gana la computadora',
			'Tie Game' => 'Empate',
			'Great job. You found a match.' => 'Muy bien. Encontraste un par.',
			'Not a match. Try again.' => 'No coincide. Intenta otra vez.',
			'Find all the matching animal pairs.' => 'Encuentra todos los pares de animales.',
			'Build the sequence.' => 'Arma la secuencia.',
			'Expand across the body. Mutation helps you survive immune attacks.' => 'Expandete por el cuerpo. La mutacion te ayuda a sobrevivir ataques inmunes.',
			'Solved. Every click was mirrored across both axes.' => 'Resuelto. Cada clic se reflejo en ambos ejes.',
			'You always lose.' => 'Siempre pierdes.',
			'The town is calm. Watch patterns appear as routines overlap.' => 'El pueblo esta tranquilo. Observa como aparecen patrones cuando las rutinas se cruzan.',
			'Paused' => 'Pausado',
			'Running' => 'En marcha',
			'Match the blue pointer to the red pointer. Then press Check Angle.' => 'Alinea el puntero azul con el rojo. Luego presiona Revisar angulo.',
			'Ready?' => 'Listo?',
			'Press Space to start. Use Arrow keys or A and D to move.' => 'Presiona Espacio para empezar. Usa las flechas o A y D para moverte.',
			'Press Space, Enter, or Restart to play again.' => 'Presiona Espacio, Enter o Reiniciar para jugar otra vez.',
			'Use the jump buttons to move along the number line.' => 'Usa los botones de salto para moverte por la recta numerica.',
			'That jump goes off the number line.' => 'Ese salto se sale de la recta numerica.',
			'Nice. You landed on the target. Press Check.' => 'Bien. Caite en el objetivo. Presiona Revisar.',
			'You are below the target.' => 'Estas debajo del objetivo.',
			'You are above the target.' => 'Estas arriba del objetivo.',
			'It\'s a tie!' => 'Empate!',
			'You win!' => 'Ganaste!',
			'You lose!' => 'Perdiste!',
			'Make your move.' => 'Haz tu jugada.',
			'No heals left.' => 'No quedan curaciones.',
			'You won. Enemy rocket was defeated.' => 'Ganaste. El cohete enemigo fue derrotado.',
			'You lost. Your rocket was defeated.' => 'Perdiste. Tu cohete fue derrotado.',
			'Time is up. Press restart and beat your score.' => 'Se acabo el tiempo. Reinicia y supera tu puntuacion.',
			'The garden bloomed. New plant unlocked.' => 'El jardin florecio. Nueva planta desbloqueada.',
			'Match found. Keep growing the garden.' => 'Par encontrado. Sigue haciendo crecer el jardin.',
			'Not a pair yet.' => 'Todavia no es un par.',
			'Blocked. Find another path.' => 'Bloqueado. Busca otro camino.',
			'Remember the order, then tap it back' => 'Recuerda el orden y luego tocalo igual',
			'You are out of lives. Press Start.' => 'Te quedaste sin vidas. Presiona Iniciar.',
			'Pick the OPPOSITE.' => 'Elige lo OPUESTO.',
			'Listen carefully.' => 'Escucha con atencion.',
			'Repeat the pattern.' => 'Repite el patron.',
			'Click around the room to search for clues.' => 'Haz clic por la habitacion para buscar pistas.',
			'No items yet.' => 'Aun no hay objetos.',
			'The door is still locked.' => 'La puerta sigue cerrada.',
			'Press Start Game to begin.' => 'Presiona Iniciar juego para empezar.',
			'Type what kind of game you want first.' => 'Primero escribe que tipo de juego quieres.',
			'No good match yet. Try words like chess, blocks, word, or category.' => 'Aun no hay una buena coincidencia. Prueba palabras como ajedrez, bloques, palabra o categoria.',
			'Best match found. Press "Open Selected Game".' => 'Mejor coincidencia encontrada. Presiona "Abrir juego seleccionado".',
			'Reach the door on the right...' => 'Llega a la puerta de la derecha...',
			'Caught by a ceiling crawler. Restart the room.' => 'Te atrapo un rastreador del techo. Reinicia la sala.',
			'Out of moves. Gravity is powerful, but expensive.' => 'Sin movimientos. La gravedad es poderosa, pero cara.',
			'You already tried that letter.' => 'Ya probaste esa letra.',
			'Enter one letter.' => 'Ingresa una letra.',
			'Bu sayfada hangi oyun calissin?' => 'Que juego debe ejecutarse en esta pagina?',
			'Bir oyun secin' => 'Selecciona un juego',
			'Bu oyun hangi listeye eklensin?' => 'A que lista se debe agregar este juego?',
			'Arslan ya da Asker oyun listesi buna gore filtrelenir.' => 'La lista de juegos de Arslan o Asker se filtra segun esto.',
			'Oyun bulunamadi.' => 'No se encontro el juego.',
			'Bu oyun henuz goruntulenemiyor.' => 'Este juego aun no se puede mostrar.',
			'Henuz oyun bulunamadi.' => 'Todavia no se encontraron juegos.',
			'Filtreye uyan oyun bulunamadi.' => 'No se encontro ningun juego que coincida con el filtro.',
			'Game stats' => 'Estadisticas del juego',
			'game area' => 'area de juego',
			'Game area' => 'Area de juego',
			'Game controls' => 'Controles del juego',
			'Ready.' => 'Listo.',
			'RUN' => 'CORRER',
			'Point' => 'Punto',
			'AI difficulty' => 'Dificultad de la IA',
			'Easy AI' => 'IA facil',
			'Medium AI' => 'IA media',
			'Hard AI' => 'IA dificil',
			'Game speed' => 'Velocidad del juego',
			'Speed x1' => 'Velocidad x1',
			'Speed x1.5' => 'Velocidad x1.5',
			'Speed x2' => 'Velocidad x2',
			'Select Operation' => 'Selecciona una operacion',
			'Enter First Number' => 'Ingresa el primer numero',
			'Enter Second Number' => 'Ingresa el segundo numero',
			'Operation' => 'Operacion',
			'Square Root' => 'Raiz cuadrada',
			'Result' => 'Resultado',
			'Start Quiz' => 'Iniciar cuestionario',
			'Type a country name to begin.' => 'Escribe el nombre de un pais para empezar.',
		),
	);

	$sitewide_runtime_exact_agent_more['es-es'] = array_merge($sitewide_runtime_exact_agent_more['es-mx'], array(
		'Text added' => 'Texto anadido',
		'Sticker added' => 'Pegatina anadida',
		'Build a 10-second loop. Ore becomes gears, gears become crates, and better placement boosts output.' => 'Crea un ciclo de 10 segundos. El mineral se convierte en engranajes, los engranajes en cajas, y una mejor colocacion aumenta la produccion.',
		'Factory optimized. Your loop now prints value every cycle.' => 'Fabrica optimizada. Tu ciclo ahora produce valor en cada ciclo.',
		'You win the match.' => 'Has ganado el partido.',
		'You lose the match.' => 'Has perdido el partido.',
		'The match ends in a draw.' => 'El partido acaba en empate.',
		'Computer Wins' => 'Gana el ordenador',
		'Great job. You found a match.' => 'Muy bien. Has encontrado una pareja.',
		'Find all the matching animal pairs.' => 'Encuentra todas las parejas de animales.',
		'Build the sequence.' => 'Construye la secuencia.',
		'Nice. You landed on the target. Press Check.' => 'Bien. Has caido en el objetivo. Pulsa Comprobar.',
		'Type a country name to begin.' => 'Escribe el nombre de un pais para empezar.',
	));

	foreach ($sitewide_runtime_exact_agent_more as $agent_more_lang => $agent_more_items) {
		if (isset($translations[$agent_more_lang])) {
			$translations[$agent_more_lang] = array_merge($translations[$agent_more_lang], $agent_more_items);
		}
	}

	$sitewide_runtime_exact_agent_final = array(
		'tr' => array(
			'Pick the right answer before the computer gets ahead.' => 'Bilgisayar one gecmeden dogru cevabi sec.',
			'Correct. You win this round.' => 'Dogru. Bu turu kazandin.',
			'Wrong. The computer wins this round.' => 'Yanlis. Bu turu bilgisayar kazandi.',
			'Hidden card' => 'Kapali kart',
			'Attempts' => 'Deneme',
			'Problem' => 'Soru',
			'You can build before pressing Start, or during battle if you have enough gold.' => 'Baslata basmadan once veya savas sirasinda yeterli altinin varsa insa edebilirsin.',
			'Press Start. Then choose a monster unit.' => 'Baslata bas. Sonra bir canavar birimi sec.',
			'Start the match.' => 'Maci baslat.',
			'Move with WASD or Arrow keys. Click or tap inside the board to shoot. Press Restart any time.' => 'WASD veya ok tuslariyla hareket et. Ates etmek icin alana tikla veya dokun. Istedigin zaman Yeniden Baslata bas.',
			'Bu Mısır işareti neyi gösteriyor?' => 'Bu Misir isareti neyi gosteriyor?',
			'Doğru cevap.' => 'Dogru cevap.',
			'Yanlış cevap.' => 'Yanlis cevap.',
			'Doğru anlamı seç.' => 'Dogru anlami sec.',
			'Cevap seçenekleri' => 'Cevap secenekleri',
		),
		'de' => array(
			'Pick the right answer before the computer gets ahead.' => 'Wahle die richtige Antwort, bevor der Computer voraus ist.',
			'Correct. You win this round.' => 'Richtig. Du gewinnst diese Runde.',
			'Wrong. The computer wins this round.' => 'Falsch. Der Computer gewinnt diese Runde.',
			'Hidden card' => 'Verdeckte Karte',
			'Attempts' => 'Versuche',
			'Problem' => 'Aufgabe',
			'You can build before pressing Start, or during battle if you have enough gold.' => 'Du kannst vor dem Start bauen oder im Kampf, wenn du genug Gold hast.',
			'Press Start. Then choose a monster unit.' => 'Drucke Start. Wahle dann eine Monstereinheit.',
			'Start the match.' => 'Starte das Spiel.',
			'Move with WASD or Arrow keys. Click or tap inside the board to shoot. Press Restart any time.' => 'Bewege dich mit WASD oder den Pfeiltasten. Klicke oder tippe ins Feld, um zu schiessen. Du kannst jederzeit neu starten.',
			'Bu Mısır işareti neyi gösteriyor?' => 'Was bedeutet dieses agyptische Zeichen?',
			'Doğru cevap.' => 'Richtige Antwort.',
			'Yanlış cevap.' => 'Falsche Antwort.',
			'Doğru anlamı seç.' => 'Wahle die richtige Bedeutung.',
			'Cevap seçenekleri' => 'Antwortoptionen',
		),
		'fr' => array(
			'Pick the right answer before the computer gets ahead.' => 'Choisis la bonne reponse avant que l ordinateur prenne l avance.',
			'Correct. You win this round.' => 'Correct. Tu gagnes cette manche.',
			'Wrong. The computer wins this round.' => 'Faux. L ordinateur gagne cette manche.',
			'Hidden card' => 'Carte cachee',
			'Attempts' => 'Essais',
			'Problem' => 'Probleme',
			'You can build before pressing Start, or during battle if you have enough gold.' => 'Tu peux construire avant de demarrer ou pendant le combat si tu as assez d or.',
			'Press Start. Then choose a monster unit.' => 'Appuie sur Demarrer. Choisis ensuite une unite monstre.',
			'Start the match.' => 'Lance le match.',
			'Move with WASD or Arrow keys. Click or tap inside the board to shoot. Press Restart any time.' => 'Deplace-toi avec WASD ou les fleches. Clique ou touche le plateau pour tirer. Tu peux redemarrer a tout moment.',
			'Bu Mısır işareti neyi gösteriyor?' => 'Que signifie ce signe egyptien ?',
			'Doğru cevap.' => 'Bonne reponse.',
			'Yanlış cevap.' => 'Mauvaise reponse.',
			'Doğru anlamı seç.' => 'Choisis le bon sens.',
			'Cevap seçenekleri' => 'Choix de reponse',
		),
		'es-mx' => array(
			'Pick the right answer before the computer gets ahead.' => 'Elige la respuesta correcta antes de que la computadora se adelante.',
			'Correct. You win this round.' => 'Correcto. Ganaste esta ronda.',
			'Wrong. The computer wins this round.' => 'Incorrecto. La computadora gana esta ronda.',
			'Hidden card' => 'Carta oculta',
			'Attempts' => 'Intentos',
			'Problem' => 'Problema',
			'You can build before pressing Start, or during battle if you have enough gold.' => 'Puedes construir antes de empezar o durante la batalla si tienes suficiente oro.',
			'Press Start. Then choose a monster unit.' => 'Presiona Empezar. Luego elige una unidad monstruo.',
			'Start the match.' => 'Empieza la partida.',
			'Move with WASD or Arrow keys. Click or tap inside the board to shoot. Press Restart any time.' => 'Muevete con WASD o las flechas. Haz clic o toca el tablero para disparar. Puedes reiniciar cuando quieras.',
			'Bu Mısır işareti neyi gösteriyor?' => 'Que significa este signo egipcio?',
			'Doğru cevap.' => 'Respuesta correcta.',
			'Yanlış cevap.' => 'Respuesta incorrecta.',
			'Doğru anlamı seç.' => 'Elige el significado correcto.',
			'Cevap seçenekleri' => 'Opciones de respuesta',
		),
	);
	$sitewide_runtime_exact_agent_final['es-es'] = array_merge($sitewide_runtime_exact_agent_final['es-mx'], array(
		'Pick the right answer before the computer gets ahead.' => 'Elige la respuesta correcta antes de que el ordenador se adelante.',
		'Correct. You win this round.' => 'Correcto. Has ganado esta ronda.',
		'Wrong. The computer wins this round.' => 'Incorrecto. El ordenador gana esta ronda.',
		'Press Start. Then choose a monster unit.' => 'Pulsa Empezar. Luego elige una unidad monstruo.',
	));

	foreach ($sitewide_runtime_exact_agent_final as $agent_final_lang => $agent_final_items) {
		if (isset($translations[$agent_final_lang])) {
			$translations[$agent_final_lang] = array_merge($translations[$agent_final_lang], $agent_final_items);
		}
	}

	$sitewide_runtime_exact_followup = array(
		'tr' => array(
			'Notes: On' => 'Notlar: Acik',
			'Notes: Off' => 'Notlar: Kapali',
			'Corner' => 'Korner',
			'Decision' => 'Karar',
			'Live' => 'Canli',
			'Smart' => 'Akilli',
			'Corners' => 'Kornerler',
			'Medicine Question' => 'Saglik sorusu',
			'Ask a Clarifying Question' => 'Aciklayici soru sor',
			'Ask One Question' => 'Bir soru sor',
			'Choose the correct country name.' => 'Dogru ulke adini sec.',
			'Doğru ülke adını seç.' => 'Dogru ulke adini sec.',
			'Find numbers that are perfect squares.' => 'Tam kare olan sayilari bul.',
			'Prime numbers are greater than 1 and divisible only by 1 and themselves. For example, 7 is prime because no number other than 1 and 7 divides it evenly.' => 'Asal sayilar 1den buyuktur ve yalnizca 1e ve kendisine bolunur. Ornegin 7 asaldir, cunku 1 ve 7 disinda hicbir sayi onu tam bolmez.',
			'Target Shooting' => 'Hedef vurma',
			'Tower Defense Paths' => 'Kule savunma yollari',
			'Zombie Garden Defense' => 'Zombi bahce savunmasi',
			'Dragon Egg Defense' => 'Ejderha yumurtasi savunmasi',
		),
		'de' => array(
			'Notes: On' => 'Notizen: An',
			'Notes: Off' => 'Notizen: Aus',
			'Corner' => 'Ecke',
			'Decision' => 'Entscheidung',
			'Live' => 'Live',
			'Smart' => 'Klug',
			'Corners' => 'Ecken',
			'Medicine Question' => 'Medizinfrage',
			'Ask a Clarifying Question' => 'Klarende Frage stellen',
			'Ask One Question' => 'Eine Frage stellen',
			'Choose the correct country name.' => 'Wahle den richtigen Landernamen.',
			'Doğru ülke adını seç.' => 'Wahle den richtigen Landernamen.',
			'Find numbers that are perfect squares.' => 'Finde Zahlen, die Quadratzahlen sind.',
			'Prime numbers are greater than 1 and divisible only by 1 and themselves. For example, 7 is prime because no number other than 1 and 7 divides it evenly.' => 'Primzahlen sind grosser als 1 und nur durch 1 und sich selbst teilbar. Zum Beispiel ist 7 prim, weil keine Zahl ausser 1 und 7 sie glatt teilt.',
			'Target Shooting' => 'Zielschiessen',
			'Tower Defense Paths' => 'Tower-Defense-Wege',
			'Zombie Garden Defense' => 'Zombie-Gartenverteidigung',
			'Dragon Egg Defense' => 'Drachenei-Verteidigung',
		),
		'fr' => array(
			'Notes: On' => 'Notes : activees',
			'Notes: Off' => 'Notes : desactivees',
			'Corner' => 'Corner',
			'Decision' => 'Decision',
			'Live' => 'En direct',
			'Smart' => 'Intelligent',
			'Corners' => 'Corners',
			'Medicine Question' => 'Question de sante',
			'Ask a Clarifying Question' => 'Poser une question de clarification',
			'Ask One Question' => 'Poser une question',
			'Choose the correct country name.' => 'Choisis le bon nom de pays.',
			'Doğru ülke adını seç.' => 'Choisis le bon nom de pays.',
			'Find numbers that are perfect squares.' => 'Trouve les nombres qui sont des carres parfaits.',
			'Prime numbers are greater than 1 and divisible only by 1 and themselves. For example, 7 is prime because no number other than 1 and 7 divides it evenly.' => 'Les nombres premiers sont superieurs a 1 et divisibles seulement par 1 et par eux-memes. Par exemple, 7 est premier car aucun nombre sauf 1 et 7 ne le divise exactement.',
			'Target Shooting' => 'Tir sur cible',
			'Tower Defense Paths' => 'Chemins de defense de tours',
			'Zombie Garden Defense' => 'Defense du jardin zombie',
			'Dragon Egg Defense' => 'Defense de l oeuf de dragon',
		),
		'es-mx' => array(
			'Notes: On' => 'Notas: activadas',
			'Notes: Off' => 'Notas: desactivadas',
			'Corner' => 'Tiro de esquina',
			'Decision' => 'Decision',
			'Live' => 'En vivo',
			'Smart' => 'Inteligente',
			'Corners' => 'Tiros de esquina',
			'Medicine Question' => 'Pregunta de medicina',
			'Ask a Clarifying Question' => 'Haz una pregunta aclaratoria',
			'Ask One Question' => 'Haz una pregunta',
			'Choose the correct country name.' => 'Elige el nombre correcto del pais.',
			'Doğru ülke adını seç.' => 'Elige el nombre correcto del pais.',
			'Find numbers that are perfect squares.' => 'Encuentra numeros que sean cuadrados perfectos.',
			'Prime numbers are greater than 1 and divisible only by 1 and themselves. For example, 7 is prime because no number other than 1 and 7 divides it evenly.' => 'Los numeros primos son mayores que 1 y solo se dividen entre 1 y ellos mismos. Por ejemplo, 7 es primo porque ningun numero excepto 1 y 7 lo divide exactamente.',
			'Target Shooting' => 'Tiro al blanco',
			'Tower Defense Paths' => 'Caminos de defensa de torres',
			'Zombie Garden Defense' => 'Defensa del jardin zombie',
			'Dragon Egg Defense' => 'Defensa del huevo de dragon',
		),
	);
	$sitewide_runtime_exact_followup['es-es'] = array_merge($sitewide_runtime_exact_followup['es-mx'], array(
		'Corner' => 'Saque de esquina',
		'Corners' => 'Saques de esquina',
		'Medicine Question' => 'Pregunta de medicina',
	));

	foreach ($sitewide_runtime_exact_followup as $followup_lang => $followup_items) {
		if (isset($translations[$followup_lang])) {
			$translations[$followup_lang] = array_merge($translations[$followup_lang], $followup_items);
		}
	}

	$sitewide_runtime_exact_followup_two = array(
		'tr' => array(
			'Your robot helper is waiting for its first lesson.' => 'Robot yardimcin ilk dersini bekliyor.',
			'Choose the best move for this round.' => 'Bu tur icin en iyi hamleyi sec.',
			'Training finished. Review the summary and restart for a new run.' => 'Egitim bitti. Ozeti incele ve yeni tur icin yeniden baslat.',
			'Press Start. Place towers on the gray pads.' => 'Baslata bas. Kuleleri gri alanlara yerlestir.',
			'That build spot is already used.' => 'Bu insa noktasi zaten kullaniliyor.',
			'Defend your base and destroy theirs.' => 'Ussunu savun ve dusman ussunu yok et.',
			'Level 1 ready. Press Space or Launch.' => 'Seviye 1 hazir. Bosluk veya Baslat tusuna bas.',
			'You beat all 1000 levels!' => '1000 seviyenin hepsini gectin!',
			'Break every brick.' => 'Tum tuglalari kir.',
			'Game over. Press R or Restart.' => 'Oyun bitti. R veya Yeniden Baslat tusuna bas.',
			'Life lost. Launch again.' => 'Can gitti. Tekrar baslat.',
			'Keep going. Follow the binary rules and fill the full grid.' => 'Devam et. Ikili kurallari izle ve tum tabloyu doldur.',
			'Fill the empty squares with 0 or 1.' => 'Bos kareleri 0 veya 1 ile doldur.',
			'The grid is not full yet. Fill every square first.' => 'Tablo henuz dolu degil. Once tum kareleri doldur.',
			'Almost there. One or more row or column rules are broken.' => 'Neredeyse oldu. Bir veya daha fazla satir ya da sutun kurali bozuldu.',
			'The rules look okay, but a few squares are still wrong. Try again.' => 'Kurallar iyi gorunuyor ama birkac kare hala yanlis. Tekrar dene.',
			'Player moves cleared. Try the puzzle again.' => 'Oyuncu hamleleri temizlendi. Bulmacayi tekrar dene.',
			'Pick the number that makes the scale balance.' => 'Teraziyi dengeleyecek sayiyi sec.',
			'Correct. The equation is balanced.' => 'Dogru. Denklem dengede.',
			'Answer this round first.' => 'Once bu turu cevapla.',
			'Classify the bug.' => 'Bocegi siniflandir.',
			'Classify the bugs before time runs out.' => 'Sure bitmeden bocekleri siniflandir.',
			'Correct bin.' => 'Dogru kutu.',
			'Select an operation.' => 'Bir islem sec.',
			'Please enter a valid first number.' => 'Gecerli bir ilk sayi gir.',
			'Please enter a valid second number.' => 'Gecerli bir ikinci sayi gir.',
			'Cannot divide by zero.' => 'Sifira bolunemez.',
			'Cannot take the square root of a negative number.' => 'Negatif sayinin karekoku alinamaz.',
			'Build the combo!' => 'Komboyu kur!',
			'Combo Complete! You Win!' => 'Kombo tamam! Kazandin!',
			'Wrong combo! Try again.' => 'Yanlis kombo! Tekrar dene.',
			'Watch the sequence.' => 'Diziyi izle.',
			'Now repeat.' => 'Simdi tekrarla.',
			'Write your decoded phrase first.' => 'Once cozulmus ifadeni yaz.',
			'Not quite yet. Check your letters and try again.' => 'Henuz degil. Harflerini kontrol et ve tekrar dene.',
			'Here is the decoded phrase.' => 'Cozulmus ifade burada.',
			'Match the target color.' => 'Hedef rengi eslestir.',
			'Wrong color. Try again.' => 'Yanlis renk. Tekrar dene.',
		),
		'de' => array(
			'Your robot helper is waiting for its first lesson.' => 'Dein Roboterhelfer wartet auf seine erste Lektion.',
			'Choose the best move for this round.' => 'Wahle den besten Zug fur diese Runde.',
			'Training finished. Review the summary and restart for a new run.' => 'Training beendet. Sieh dir die Zusammenfassung an und starte neu.',
			'Press Start. Place towers on the gray pads.' => 'Drucke Start. Platziere Turme auf den grauen Feldern.',
			'That build spot is already used.' => 'Dieser Bauplatz ist bereits belegt.',
			'Defend your base and destroy theirs.' => 'Verteidige deine Basis und zerstor ihre.',
			'Level 1 ready. Press Space or Launch.' => 'Level 1 bereit. Drucke Leertaste oder Starten.',
			'You beat all 1000 levels!' => 'Du hast alle 1000 Level geschafft!',
			'Break every brick.' => 'Zerbrich jeden Stein.',
			'Game over. Press R or Restart.' => 'Spiel vorbei. Drucke R oder Neustart.',
			'Life lost. Launch again.' => 'Leben verloren. Starte erneut.',
			'Keep going. Follow the binary rules and fill the full grid.' => 'Mach weiter. Folge den Binaregeln und fulle das ganze Feld.',
			'Fill the empty squares with 0 or 1.' => 'Fulle die leeren Felder mit 0 oder 1.',
			'The grid is not full yet. Fill every square first.' => 'Das Feld ist noch nicht voll. Fulle zuerst jedes Quadrat.',
			'Almost there. One or more row or column rules are broken.' => 'Fast geschafft. Eine oder mehrere Zeilen- oder Spaltenregeln sind verletzt.',
			'The rules look okay, but a few squares are still wrong. Try again.' => 'Die Regeln sehen gut aus, aber einige Felder sind noch falsch. Versuch es erneut.',
			'Player moves cleared. Try the puzzle again.' => 'Spielerzuege geloscht. Versuch das Ratsel erneut.',
			'Pick the number that makes the scale balance.' => 'Wahle die Zahl, die die Waage ausgleicht.',
			'Correct. The equation is balanced.' => 'Richtig. Die Gleichung ist ausgeglichen.',
			'Answer this round first.' => 'Beantworte zuerst diese Runde.',
			'Classify the bug.' => 'Sortiere den Kafer ein.',
			'Classify the bugs before time runs out.' => 'Sortiere die Kafer, bevor die Zeit ablaeuft.',
			'Correct bin.' => 'Richtiger Behalter.',
			'Select an operation.' => 'Wahle eine Rechenart.',
			'Please enter a valid first number.' => 'Gib eine gultige erste Zahl ein.',
			'Please enter a valid second number.' => 'Gib eine gultige zweite Zahl ein.',
			'Cannot divide by zero.' => 'Division durch null ist nicht moglich.',
			'Cannot take the square root of a negative number.' => 'Aus einer negativen Zahl kann keine Quadratwurzel gezogen werden.',
			'Build the combo!' => 'Baue die Kombo!',
			'Combo Complete! You Win!' => 'Kombo komplett! Du gewinnst!',
			'Wrong combo! Try again.' => 'Falsche Kombo! Versuch es erneut.',
			'Watch the sequence.' => 'Beobachte die Reihenfolge.',
			'Now repeat.' => 'Jetzt wiederholen.',
			'Write your decoded phrase first.' => 'Schreibe zuerst deine entschlusselte Phrase.',
			'Not quite yet. Check your letters and try again.' => 'Noch nicht ganz. Prufe deine Buchstaben und versuche es erneut.',
			'Here is the decoded phrase.' => 'Hier ist die entschlusselte Phrase.',
			'Match the target color.' => 'Triff die Zielfarbe.',
			'Wrong color. Try again.' => 'Falsche Farbe. Versuch es erneut.',
		),
		'fr' => array(
			'Your robot helper is waiting for its first lesson.' => 'Ton assistant robot attend sa premiere lecon.',
			'Choose the best move for this round.' => 'Choisis le meilleur coup pour cette manche.',
			'Training finished. Review the summary and restart for a new run.' => 'Entrainement termine. Relis le resume puis redemarre.',
			'Press Start. Place towers on the gray pads.' => 'Appuie sur Demarrer. Place les tours sur les cases grises.',
			'That build spot is already used.' => 'Cet emplacement est deja utilise.',
			'Defend your base and destroy theirs.' => 'Defends ta base et detruis la leur.',
			'Level 1 ready. Press Space or Launch.' => 'Niveau 1 pret. Appuie sur Espace ou Lancer.',
			'You beat all 1000 levels!' => 'Tu as termine les 1000 niveaux !',
			'Break every brick.' => 'Casse toutes les briques.',
			'Game over. Press R or Restart.' => 'Partie terminee. Appuie sur R ou Redemarrer.',
			'Life lost. Launch again.' => 'Vie perdue. Relance.',
			'Keep going. Follow the binary rules and fill the full grid.' => 'Continue. Suis les regles binaires et remplis toute la grille.',
			'Fill the empty squares with 0 or 1.' => 'Remplis les cases vides avec 0 ou 1.',
			'The grid is not full yet. Fill every square first.' => 'La grille n est pas encore pleine. Remplis d abord chaque case.',
			'Almost there. One or more row or column rules are broken.' => 'Presque. Une ou plusieurs regles de ligne ou de colonne sont cassees.',
			'The rules look okay, but a few squares are still wrong. Try again.' => 'Les regles semblent bonnes, mais quelques cases sont encore fausses. Reessaie.',
			'Player moves cleared. Try the puzzle again.' => 'Coups du joueur effaces. Reessaie le puzzle.',
			'Pick the number that makes the scale balance.' => 'Choisis le nombre qui equilibre la balance.',
			'Correct. The equation is balanced.' => 'Correct. L equation est equilibree.',
			'Answer this round first.' => 'Reponds d abord a cette manche.',
			'Classify the bug.' => 'Classe l insecte.',
			'Classify the bugs before time runs out.' => 'Classe les insectes avant la fin du temps.',
			'Correct bin.' => 'Bonne boite.',
			'Select an operation.' => 'Choisis une operation.',
			'Please enter a valid first number.' => 'Saisis un premier nombre valide.',
			'Please enter a valid second number.' => 'Saisis un deuxieme nombre valide.',
			'Cannot divide by zero.' => 'Impossible de diviser par zero.',
			'Cannot take the square root of a negative number.' => 'Impossible de prendre la racine carree d un nombre negatif.',
			'Build the combo!' => 'Construis le combo !',
			'Combo Complete! You Win!' => 'Combo termine ! Tu gagnes !',
			'Wrong combo! Try again.' => 'Mauvais combo ! Reessaie.',
			'Watch the sequence.' => 'Regarde la sequence.',
			'Now repeat.' => 'Repete maintenant.',
			'Write your decoded phrase first.' => 'Ecris d abord ta phrase decodee.',
			'Not quite yet. Check your letters and try again.' => 'Pas encore. Verifie tes lettres et reessaie.',
			'Here is the decoded phrase.' => 'Voici la phrase decodee.',
			'Match the target color.' => 'Associe la couleur cible.',
			'Wrong color. Try again.' => 'Mauvaise couleur. Reessaie.',
		),
		'es-mx' => array(
			'Your robot helper is waiting for its first lesson.' => 'Tu robot ayudante espera su primera leccion.',
			'Choose the best move for this round.' => 'Elige la mejor jugada para esta ronda.',
			'Training finished. Review the summary and restart for a new run.' => 'Entrenamiento terminado. Revisa el resumen y reinicia para una nueva partida.',
			'Press Start. Place towers on the gray pads.' => 'Presiona Iniciar. Coloca torres en los cuadros grises.',
			'That build spot is already used.' => 'Ese lugar de construccion ya esta usado.',
			'Defend your base and destroy theirs.' => 'Defiende tu base y destruye la suya.',
			'Level 1 ready. Press Space or Launch.' => 'Nivel 1 listo. Presiona Espacio o Lanzar.',
			'You beat all 1000 levels!' => 'Superaste los 1000 niveles!',
			'Break every brick.' => 'Rompe todos los ladrillos.',
			'Game over. Press R or Restart.' => 'Fin del juego. Presiona R o Reiniciar.',
			'Life lost. Launch again.' => 'Vida perdida. Lanza otra vez.',
			'Keep going. Follow the binary rules and fill the full grid.' => 'Sigue. Respeta las reglas binarias y llena toda la cuadricula.',
			'Fill the empty squares with 0 or 1.' => 'Llena los cuadros vacios con 0 o 1.',
			'The grid is not full yet. Fill every square first.' => 'La cuadricula aun no esta llena. Llena primero cada cuadro.',
			'Almost there. One or more row or column rules are broken.' => 'Casi. Una o mas reglas de fila o columna estan rotas.',
			'The rules look okay, but a few squares are still wrong. Try again.' => 'Las reglas parecen bien, pero algunos cuadros siguen mal. Intenta otra vez.',
			'Player moves cleared. Try the puzzle again.' => 'Movimientos borrados. Intenta el rompecabezas otra vez.',
			'Pick the number that makes the scale balance.' => 'Elige el numero que equilibra la balanza.',
			'Correct. The equation is balanced.' => 'Correcto. La ecuacion esta equilibrada.',
			'Answer this round first.' => 'Primero responde esta ronda.',
			'Classify the bug.' => 'Clasifica el insecto.',
			'Classify the bugs before time runs out.' => 'Clasifica los insectos antes de que se acabe el tiempo.',
			'Correct bin.' => 'Contenedor correcto.',
			'Select an operation.' => 'Selecciona una operacion.',
			'Please enter a valid first number.' => 'Ingresa un primer numero valido.',
			'Please enter a valid second number.' => 'Ingresa un segundo numero valido.',
			'Cannot divide by zero.' => 'No se puede dividir entre cero.',
			'Cannot take the square root of a negative number.' => 'No se puede sacar la raiz cuadrada de un numero negativo.',
			'Build the combo!' => 'Arma el combo!',
			'Combo Complete! You Win!' => 'Combo completo! Ganaste!',
			'Wrong combo! Try again.' => 'Combo incorrecto! Intenta otra vez.',
			'Watch the sequence.' => 'Mira la secuencia.',
			'Now repeat.' => 'Ahora repite.',
			'Write your decoded phrase first.' => 'Primero escribe tu frase descifrada.',
			'Not quite yet. Check your letters and try again.' => 'Todavia no. Revisa tus letras e intenta otra vez.',
			'Here is the decoded phrase.' => 'Aqui esta la frase descifrada.',
			'Match the target color.' => 'Iguala el color objetivo.',
			'Wrong color. Try again.' => 'Color incorrecto. Intenta otra vez.',
		),
	);
	$sitewide_runtime_exact_followup_two['es-es'] = array_merge($sitewide_runtime_exact_followup_two['es-mx'], array(
		'Press Start. Place towers on the gray pads.' => 'Pulsa Iniciar. Coloca torres en las casillas grises.',
		'Life lost. Launch again.' => 'Vida perdida. Lanza de nuevo.',
		'Correct bin.' => 'Contenedor correcto.',
		'Please enter a valid first number.' => 'Introduce un primer numero valido.',
		'Please enter a valid second number.' => 'Introduce un segundo numero valido.',
	));

	foreach ($sitewide_runtime_exact_followup_two as $followup_two_lang => $followup_two_items) {
		if (isset($translations[$followup_two_lang])) {
			$translations[$followup_two_lang] = array_merge($translations[$followup_two_lang], $followup_two_items);
		}
	}

	foreach ($agent_runtime_exact as $agent_lang => $agent_items) {
		if (isset($translations[$agent_lang])) {
			$translations[$agent_lang] = array_merge($translations[$agent_lang], $agent_items);
		}
	}

	if (isset($translations[$lang], $common_exact[$lang])) {
		$translations[$lang] = array_merge($translations[$lang], $common_exact[$lang]);
	}

	return isset($translations[$lang]) ? $translations[$lang] : array();
}

function zo_get_runtime_translation_replacements($lang) {
	$lang = array_key_exists($lang, zo_get_language_options()) ? $lang : zo_get_current_language();

	$phrases = array(
		'tr' => array(
			array('Score', 'Puan'),
			array('Final Score', 'Son Puan'),
			array('Level', 'Seviye'),
			array('Round', 'Tur'),
			array('Time', 'Süre'),
			array('Lives', 'Can'),
			array('Health', 'Sağlık'),
			array('Coins', 'Coin'),
			array('Question', 'Soru'),
			array('Correct', 'Doğru'),
			array('Wrong', 'Yanlış'),
			array('Game Over', 'Oyun Bitti'),
			array('Press Start', 'Başlat düğmesine bas'),
			array('Press Restart', 'Yeniden Başlat düğmesine bas'),
			array('Press R', 'R tuşuna bas'),
			array('Press Space', 'Boşluk tuşuna bas'),
			array('Press SPACE', 'BOŞLUK tuşuna bas'),
			array('Start Quiz', 'Teste Başla'),
			array('Next Question', 'Sonraki Soru'),
			array('Play Again', 'Tekrar Oyna'),
			array('Try again', 'Tekrar dene'),
			array('You found', 'Buldun'),
			array('You win', 'Kazandın'),
			array('You Win', 'Kazandın'),
			array('You lost', 'Kaybettin'),
			array('Collect', 'Topla'),
			array('Avoid', 'Kaçın'),
			array('Move', 'Hareket'),
			array('Restart', 'Yeniden Başlat'),
			array('Start', 'Başlat'),
			array('Pause', 'Duraklat'),
			array('Resume', 'Devam Et'),
		),
		'en' => array(
			array('12/24 Saat', '12/24 Format'),
			array('Saati', 'Clock'),
			array('Saat', 'Time'),
			array('Puan', 'Score'),
			array('Son Puan', 'Final Score'),
			array('Seviye', 'Level'),
			array('Tur', 'Round'),
			array('Süre', 'Time'),
			array('Can', 'Lives'),
			array('Sağlık', 'Health'),
			array('Soru', 'Question'),
			array('Doğru', 'Correct'),
			array('Yanlış', 'Wrong'),
			array('Oyun Bitti', 'Game Over'),
			array('Başlat düğmesine bas', 'Press Start'),
			array('Yeniden Başlat düğmesine bas', 'Press Restart'),
			array('Tekrar dene', 'Try again'),
			array('Kazandın', 'You Win'),
			array('Kaybettin', 'You Lost'),
			array('Topla', 'Collect'),
			array('Kaçın', 'Avoid'),
			array('Hareket', 'Move'),
			array('Yeniden Başlat', 'Restart'),
			array('Başlat', 'Start'),
			array('Duraklat', 'Pause'),
			array('Devam Et', 'Resume'),
		),
		'de' => array(
			array('12/24 Saat', '12/24 Format'),
			array('Saati', 'Uhr'),
			array('Saat', 'Uhrzeit'),
			array('Final Score', 'Endpunkte'),
			array('Score', 'Punkte'),
			array('Level', 'Level'),
			array('Round', 'Runde'),
			array('Time', 'Zeit'),
			array('Lives', 'Leben'),
			array('Health', 'Gesundheit'),
			array('Coins', 'Münzen'),
			array('Question', 'Frage'),
			array('Correct', 'Richtig'),
			array('Wrong', 'Falsch'),
			array('Game Over', 'Spiel vorbei'),
			array('Press Start', 'Drücke Starten'),
			array('Press Restart', 'Drücke Neu starten'),
			array('Press R', 'Drücke R'),
			array('Press Space', 'Drücke die Leertaste'),
			array('Press SPACE', 'DRÜCKE DIE LEERTASTE'),
			array('Start Quiz', 'Quiz starten'),
			array('Next Question', 'Nächste Frage'),
			array('Play Again', 'Noch einmal spielen'),
			array('Try again', 'Versuche es noch einmal'),
			array('You found', 'Du hast gefunden'),
			array('You win', 'Du gewinnst'),
			array('You Win', 'Du gewinnst'),
			array('You lost', 'Du hast verloren'),
			array('Collect', 'Sammle'),
			array('Avoid', 'Weiche aus'),
			array('Move', 'Bewege dich'),
			array('Restart', 'Neu starten'),
			array('Start', 'Starten'),
			array('Pause', 'Pause'),
			array('Resume', 'Fortsetzen'),
			array('Puan', 'Punkte'),
			array('Seviye', 'Level'),
			array('Tur', 'Runde'),
			array('Süre', 'Zeit'),
			array('Can', 'Leben'),
			array('Soru', 'Frage'),
			array('Doğru', 'Richtig'),
			array('Yanlış', 'Falsch'),
			array('Oyun Bitti', 'Spiel vorbei'),
			array('Başlat', 'Starten'),
			array('Yeniden Başlat', 'Neu starten'),
		),
		'fr' => array(
			array('12/24 Saat', 'Format 12/24'),
			array('Saati', 'Horloge'),
			array('Saat', 'Heure'),
			array('Final Score', 'Score final'),
			array('Score', 'Score'),
			array('Level', 'Niveau'),
			array('Round', 'Manche'),
			array('Time', 'Temps'),
			array('Lives', 'Vies'),
			array('Health', 'Santé'),
			array('Coins', 'Pièces'),
			array('Question', 'Question'),
			array('Correct', 'Correct'),
			array('Wrong', 'Incorrect'),
			array('Game Over', 'Partie terminée'),
			array('Press Start', 'Appuie sur Démarrer'),
			array('Press Restart', 'Appuie sur Redémarrer'),
			array('Press R', 'Appuie sur R'),
			array('Press Space', 'Appuie sur Espace'),
			array('Start Quiz', 'Commencer le quiz'),
			array('Next Question', 'Question suivante'),
			array('Play Again', 'Rejouer'),
			array('Try again', 'Réessaie'),
			array('You found', 'Tu as trouvé'),
			array('You win', 'Tu as gagné'),
			array('You Win', 'Tu as gagné'),
			array('You lost', 'Tu as perdu'),
			array('Collect', 'Ramasse'),
			array('Avoid', 'Évite'),
			array('Move', 'Déplacement'),
			array('Restart', 'Redémarrer'),
			array('Start', 'Démarrer'),
			array('Pause', 'Pause'),
			array('Resume', 'Reprendre'),
			array('Puan', 'Score'),
			array('Seviye', 'Niveau'),
			array('Tur', 'Manche'),
			array('Can', 'Vies'),
			array('Hedef', 'Objectif'),
			array('Soru', 'Question'),
			array('Oyun Bitti', 'Partie terminée'),
		),
	);

	$spanish_phrases = array(
		array('12/24 Saat', 'Formato 12/24'),
		array('Saati', 'Reloj'),
		array('Saat', 'Hora'),
		array('Final Score', 'Puntuación final'),
		array('Score', 'Puntuación'),
		array('Level', 'Nivel'),
		array('Round', 'Ronda'),
		array('Time', 'Tiempo'),
		array('Lives', 'Vidas'),
		array('Health', 'Salud'),
		array('Coins', 'Monedas'),
		array('Question', 'Pregunta'),
		array('Correct', 'Correcto'),
		array('Wrong', 'Incorrecto'),
		array('Game Over', 'Fin del juego'),
		array('Press Start', 'Pulsa Empezar'),
		array('Press Restart', 'Pulsa Reiniciar'),
		array('Press R', 'Pulsa R'),
		array('Press Space', 'Pulsa Espacio'),
		array('Start Quiz', 'Empezar quiz'),
		array('Next Question', 'Siguiente pregunta'),
		array('Play Again', 'Jugar de nuevo'),
		array('Try again', 'Inténtalo de nuevo'),
		array('You found', 'Encontraste'),
		array('You win', 'Ganaste'),
		array('You Win', 'Ganaste'),
		array('You lost', 'Perdiste'),
		array('Collect', 'Recoge'),
		array('Avoid', 'Evita'),
		array('Move', 'Movimiento'),
		array('Restart', 'Reiniciar'),
		array('Start', 'Empezar'),
		array('Pause', 'Pausa'),
		array('Resume', 'Continuar'),
		array('Puan', 'Puntuación'),
		array('Seviye', 'Nivel'),
		array('Tur', 'Ronda'),
		array('Can', 'Vidas'),
		array('Hedef', 'Objetivo'),
		array('Soru', 'Pregunta'),
		array('Oyun Bitti', 'Fin del juego'),
	);

	$phrases['es-mx'] = $spanish_phrases;
	$phrases['es-es'] = $spanish_phrases;

	$common_replacements = array(
		'en' => array(
			array('Question ', 'Question '),
			array('Round ', 'Round '),
			array(' of ', ' of '),
			array('Day:', 'Day:'),
			array('Money:', 'Money:'),
			array('Customers:', 'Customers:'),
			array('Happiness:', 'Happiness:'),
			array('Workers:', 'Workers:'),
			array('Product Level:', 'Product Level:'),
			array('Upgrades:', 'Upgrades:'),
			array('Find:', 'Find:'),
			array('Chest ', 'Chest '),
			array('Sector ', 'Sector '),
			array('Level ', 'Level '),
			array('Box ', 'Box '),
			array('Time finished. Score:', 'Time finished. Score:'),
			array('Time is up. Score:', 'Time is up. Score:'),
			array('Final alignment:', 'Final alignment:'),
			array('Corrections made:', 'Corrections made:'),
			array('Catch ', 'Catch '),
			array(' stars before time runs out.', ' stars before time runs out.'),
			array('Target Combo:', 'Target Combo:'),
			array('Turn:', 'Turn:'),
			array('Black AI', 'Black AI'),
			array('Rule check: ', 'Rule check: '),
			array(' row or column rules are currently broken.', ' row or column rules are currently broken.'),
			array('Başlamak için Başla butonuna bas', 'Press Start to begin'),
			array('Süre bitti', 'Time is up'),
			array('En iyi:', 'Best:'),
			array('Skor:', 'Score:'),
			array('Süre:', 'Time:'),
			array('Tur:', 'Round:'),
			array('Can:', 'Lives:'),
			array('Seviye:', 'Level:'),
			array('Kapılar', 'Doors'),
			array('Kapı', 'Door'),
			array('Başla', 'Start'),
			array('Sıfırla', 'Reset'),
			array('on board', 'on board'),
			array('left', 'left'),
			array('ready', 'ready'),
			array('done', 'done'),
		),
		'de' => array(
			array('Question ', 'Frage '),
			array('Round ', 'Runde '),
			array(' of ', ' von '),
			array('Day:', 'Tag:'),
			array('Money:', 'Geld:'),
			array('Customers:', 'Kunden:'),
			array('Happiness:', 'Zufriedenheit:'),
			array('Workers:', 'Mitarbeiter:'),
			array('Product Level:', 'Produktlevel:'),
			array('Upgrades:', 'Upgrades:'),
			array('Find:', 'Finde:'),
			array('Chest ', 'Truhe '),
			array('Sector ', 'Sektor '),
			array('Level ', 'Level '),
			array('Box ', 'Kiste '),
			array('Time finished. Score:', 'Zeit vorbei. Punkte:'),
			array('Time is up. Score:', 'Zeit abgelaufen. Punkte:'),
			array('Final alignment:', 'Endausrichtung:'),
			array('Corrections made:', 'Korrekturen:'),
			array('Catch ', 'Fange '),
			array(' stars before time runs out.', ' Sterne, bevor die Zeit abläuft.'),
			array('Target Combo:', 'Ziel-Kombo:'),
			array('Turn:', 'Zug:'),
			array('Black AI', 'Schwarze KI'),
			array('Rule check: ', 'Regelprüfung: '),
			array(' row or column rules are currently broken.', ' Zeilen- oder Spaltenregeln sind gerade verletzt.'),
			array('Başlamak için Başla butonuna bas', 'Drücke Starten, um zu beginnen'),
			array('Süre bitti', 'Zeit abgelaufen'),
			array('En iyi:', 'Bestwert:'),
			array('Skor:', 'Punkte:'),
			array('Süre:', 'Zeit:'),
			array('Tur:', 'Runde:'),
			array('Can:', 'Leben:'),
			array('Seviye:', 'Level:'),
			array('Kapılar', 'Türen'),
			array('Kapı', 'Tür'),
			array('Başla', 'Starten'),
			array('Sıfırla', 'Zurücksetzen'),
			array('on board', 'auf dem Brett'),
			array('left', 'übrig'),
			array('ready', 'bereit'),
			array('done', 'fertig'),
		),
		'fr' => array(
			array('Question ', 'Question '),
			array('Round ', 'Manche '),
			array(' of ', ' sur '),
			array('Day:', 'Jour :'),
			array('Money:', 'Argent :'),
			array('Customers:', 'Clients :'),
			array('Happiness:', 'Bonheur :'),
			array('Workers:', 'Employés :'),
			array('Product Level:', 'Niveau du produit :'),
			array('Upgrades:', 'Améliorations :'),
			array('Find:', 'Trouve :'),
			array('Chest ', 'Coffre '),
			array('Sector ', 'Secteur '),
			array('Level ', 'Niveau '),
			array('Box ', 'Boîte '),
			array('Time finished. Score:', 'Temps terminé. Score :'),
			array('Time is up. Score:', 'Temps écoulé. Score :'),
			array('Final alignment:', 'Alignement final :'),
			array('Corrections made:', 'Corrections faites :'),
			array('Catch ', 'Attrape '),
			array(' stars before time runs out.', ' étoiles avant la fin du temps.'),
			array('Target Combo:', 'Combo cible :'),
			array('Turn:', 'Tour :'),
			array('Black AI', 'IA noire'),
			array('Rule check: ', 'Vérification des règles : '),
			array(' row or column rules are currently broken.', ' règles de ligne ou colonne sont cassées.'),
			array('Başlamak için Başla butonuna bas', 'Appuie sur Démarrer pour commencer'),
			array('Süre bitti', 'Le temps est écoulé'),
			array('En iyi:', 'Meilleur :'),
			array('Skor:', 'Score :'),
			array('Süre:', 'Temps :'),
			array('Tur:', 'Manche :'),
			array('Can:', 'Vies :'),
			array('Seviye:', 'Niveau :'),
			array('Kapılar', 'Portes'),
			array('Kapı', 'Porte'),
			array('Başla', 'Démarrer'),
			array('Sıfırla', 'Réinitialiser'),
			array('on board', 'sur le plateau'),
			array('left', 'restants'),
			array('ready', 'prêt'),
			array('done', 'terminé'),
		),
		'es-mx' => array(
			array('Question ', 'Pregunta '),
			array('Round ', 'Ronda '),
			array(' of ', ' de '),
			array('Day:', 'Día:'),
			array('Money:', 'Dinero:'),
			array('Customers:', 'Clientes:'),
			array('Happiness:', 'Felicidad:'),
			array('Workers:', 'Trabajadores:'),
			array('Product Level:', 'Nivel del producto:'),
			array('Upgrades:', 'Mejoras:'),
			array('Find:', 'Encuentra:'),
			array('Chest ', 'Cofre '),
			array('Sector ', 'Sector '),
			array('Level ', 'Nivel '),
			array('Box ', 'Caja '),
			array('Time finished. Score:', 'Tiempo terminado. Puntuación:'),
			array('Time is up. Score:', 'Se acabó el tiempo. Puntuación:'),
			array('Final alignment:', 'Alineación final:'),
			array('Corrections made:', 'Correcciones hechas:'),
			array('Catch ', 'Atrapa '),
			array(' stars before time runs out.', ' estrellas antes de que se acabe el tiempo.'),
			array('Target Combo:', 'Combo objetivo:'),
			array('Turn:', 'Turno:'),
			array('Black AI', 'IA negra'),
			array('Rule check: ', 'Revisión de reglas: '),
			array(' row or column rules are currently broken.', ' reglas de fila o columna están rotas.'),
			array('Başlamak için Başla butonuna bas', 'Pulsa Empezar para comenzar'),
			array('Süre bitti', 'Se acabó el tiempo'),
			array('En iyi:', 'Mejor:'),
			array('Skor:', 'Puntuación:'),
			array('Süre:', 'Tiempo:'),
			array('Tur:', 'Ronda:'),
			array('Can:', 'Vidas:'),
			array('Seviye:', 'Nivel:'),
			array('Kapılar', 'Puertas'),
			array('Kapı', 'Puerta'),
			array('Başla', 'Empezar'),
			array('Sıfırla', 'Reiniciar'),
			array('on board', 'en el tablero'),
			array('left', 'restantes'),
			array('ready', 'listo'),
			array('done', 'hecho'),
		),
		'es-es' => array(
			array('Question ', 'Pregunta '),
			array('Round ', 'Ronda '),
			array(' of ', ' de '),
			array('Day:', 'Día:'),
			array('Money:', 'Dinero:'),
			array('Customers:', 'Clientes:'),
			array('Happiness:', 'Felicidad:'),
			array('Workers:', 'Trabajadores:'),
			array('Product Level:', 'Nivel del producto:'),
			array('Upgrades:', 'Mejoras:'),
			array('Find:', 'Encuentra:'),
			array('Chest ', 'Cofre '),
			array('Sector ', 'Sector '),
			array('Level ', 'Nivel '),
			array('Box ', 'Caja '),
			array('Time finished. Score:', 'Tiempo terminado. Puntuación:'),
			array('Time is up. Score:', 'Se acabó el tiempo. Puntuación:'),
			array('Final alignment:', 'Alineación final:'),
			array('Corrections made:', 'Correcciones hechas:'),
			array('Catch ', 'Atrapa '),
			array(' stars before time runs out.', ' estrellas antes de que se acabe el tiempo.'),
			array('Target Combo:', 'Combo objetivo:'),
			array('Turn:', 'Turno:'),
			array('Black AI', 'IA negra'),
			array('Rule check: ', 'Comprobación de reglas: '),
			array(' row or column rules are currently broken.', ' reglas de fila o columna están rotas.'),
			array('Başlamak için Başla butonuna bas', 'Pulsa Empezar para comenzar'),
			array('Süre bitti', 'Se acabó el tiempo'),
			array('En iyi:', 'Mejor:'),
			array('Skor:', 'Puntuación:'),
			array('Süre:', 'Tiempo:'),
			array('Tur:', 'Ronda:'),
			array('Can:', 'Vidas:'),
			array('Seviye:', 'Nivel:'),
			array('Kapılar', 'Puertas'),
			array('Kapı', 'Puerta'),
			array('Başla', 'Empezar'),
			array('Sıfırla', 'Reiniciar'),
			array('on board', 'en el tablero'),
			array('left', 'restantes'),
			array('ready', 'listo'),
			array('done', 'hecho'),
		),
	);

	$scan_replacements = array(
		'fr' => array(
			array(' ready. Launch the ball.', ' prêt. Lance la balle.'),
			array('You: ', 'Toi : '),
			array(' | AI: ', ' | IA : '),
			array('Nice coaching. ', 'Bel entraînement. '),
			array('That choice teaches a risky habit. ', 'Ce choix apprend une habitude risquée. '),
			array('The big lesson: your robot copies both your good habits and your mistakes.', 'La grande leçon : ton robot copie tes bonnes habitudes et tes erreurs.'),
			array('Dükkan Seviyesi ', 'Niveau de boutique '),
			array('Yeterli paran yok.', 'Tu n’as pas assez d’argent.'),
			array(' alındı.', ' acheté.'),
			array(' satın alındı.', ' acheté.'),
			array('Satış yaptın. +', 'Vente réussie. +'),
			array(' para.', ' argent.'),
			array('Hızlı kampanya yaptın. +', 'Campagne rapide lancée. +'),
			array('Kampanya kazancı: +', 'Gain de campagne : +'),
			array('Dükkan yeniden kuruldu.', 'La boutique a été reconstruite.'),
			array('Hazır. Satış yaparak para kazan.', 'Prêt. Fais des ventes pour gagner de l’argent.'),
			array('Su:', 'Eau :'),
			array('En iyi su:', 'Meilleure eau :'),
			array('Can:', 'Vies :'),
			array('Skor:', 'Score :'),
			array('Öğretmenden kaç. Kitap topla.', 'Échappe au professeur. Ramasse les livres.'),
			array('Yakalandın. Skorun:', 'Attrapé. Ton score :'),
		),
		'es-mx' => array(
			array(' ready. Launch the ball.', ' listo. Lanza la bola.'),
			array('You: ', 'Tú: '),
			array(' | AI: ', ' | IA: '),
			array('Nice coaching. ', 'Buen entrenamiento. '),
			array('That choice teaches a risky habit. ', 'Esa elección enseña un hábito riesgoso. '),
			array('The big lesson: your robot copies both your good habits and your mistakes.', 'La gran lección: tu robot copia tus buenos hábitos y también tus errores.'),
			array('Dükkan Seviyesi ', 'Nivel de tienda '),
			array('Yeterli paran yok.', 'No tienes suficiente dinero.'),
			array(' alındı.', ' comprado.'),
			array(' satın alındı.', ' comprado.'),
			array('Satış yaptın. +', 'Hiciste una venta. +'),
			array(' para.', ' dinero.'),
			array('Hızlı kampanya yaptın. +', 'Hiciste una campaña rápida. +'),
			array('Kampanya kazancı: +', 'Ganancia de campaña: +'),
			array('Dükkan yeniden kuruldu.', 'La tienda se reconstruyó.'),
			array('Hazır. Satış yaparak para kazan.', 'Listo. Gana dinero haciendo ventas.'),
			array('Su:', 'Agua:'),
			array('En iyi su:', 'Mejor agua:'),
			array('Can:', 'Vidas:'),
			array('Skor:', 'Puntuación:'),
			array('Öğretmenden kaç. Kitap topla.', 'Escapa del maestro. Recoge libros.'),
			array('Yakalandın. Skorun:', 'Te atraparon. Tu puntuación:'),
		),
		'es-es' => array(
			array(' ready. Launch the ball.', ' listo. Lanza la bola.'),
			array('You: ', 'Tú: '),
			array(' | AI: ', ' | IA: '),
			array('Nice coaching. ', 'Buen entrenamiento. '),
			array('That choice teaches a risky habit. ', 'Esa elección enseña un hábito arriesgado. '),
			array('The big lesson: your robot copies both your good habits and your mistakes.', 'La gran lección: tu robot copia tus buenos hábitos y también tus errores.'),
			array('Dükkan Seviyesi ', 'Nivel de tienda '),
			array('Yeterli paran yok.', 'No tienes suficiente dinero.'),
			array(' alındı.', ' comprado.'),
			array(' satın alındı.', ' comprado.'),
			array('Satış yaptın. +', 'Has hecho una venta. +'),
			array(' para.', ' dinero.'),
			array('Hızlı kampanya yaptın. +', 'Has hecho una campaña rápida. +'),
			array('Kampanya kazancı: +', 'Ganancia de campaña: +'),
			array('Dükkan yeniden kuruldu.', 'La tienda se ha reconstruido.'),
			array('Hazır. Satış yaparak para kazan.', 'Listo. Gana dinero haciendo ventas.'),
			array('Su:', 'Agua:'),
			array('En iyi su:', 'Mejor agua:'),
			array('Can:', 'Vidas:'),
			array('Skor:', 'Puntuación:'),
			array('Öğretmenden kaç. Kitap topla.', 'Escapa del profesor. Recoge libros.'),
			array('Yakalandın. Skorun:', 'Te han atrapado. Tu puntuación:'),
		),
	);

	foreach ($scan_replacements as $scan_lang => $scan_items) {
		if (isset($common_replacements[$scan_lang])) {
			$common_replacements[$scan_lang] = array_merge($scan_items, $common_replacements[$scan_lang]);
		}
	}

	$agent_replacements_more = array(
		'tr' => array(
			array('You mastered ', 'Ustalastin: '),
			array('You reached ', 'Ulastigin skor: '),
			array(' with ', ' ile '),
			array(' points.', ' puan.'),
			array('points. Press Start and go again.', 'puan. Baslat dugmesine bas ve yeniden dene.'),
			array('one duck is hiding under 1 of these 5 boxes. Find 30 ducks to finish the game.', 'bir ordek bu 5 kutudan birinin altinda saklaniyor. Oyunu bitirmek icin 30 ordek bul.'),
			array('You found all 30 ducks and earned', '30 ordegin hepsini buldun ve kazandin:'),
			array('coins. Press Play Again for a new run.', 'coin. Yeni oyun icin Tekrar Oyna dugmesine bas.'),
			array('The duck was under box', 'Ordek su kutunun altindaydi:'),
			array('No coins this round. Try the next one.', 'Bu tur coin yok. Sonrakini dene.'),
			array('You escaped in', 'Kactin. Adim:'),
			array('steps with', 've ses darbesi:'),
			array('sound pulses.', 'ses darbesi.'),
			array('Great job. You spelled', 'Harika. Yazdigin kelime:'),
			array('You ran out of lives. Final score:', 'Canin kalmadi. Son skor:'),
			array('Wrong letter. You needed', 'Yanlis harf. Gereken:'),
			array('Catch these letters in order:', 'Bu harfleri sirayla yakala:'),
			array('Game Over - Score:', 'Oyun bitti - Skor:'),
			array('Game Over — Score:', 'Oyun bitti - Skor:'),
			array('Wrong. Opposite was', 'Yanlis. Tersi suydu:'),
			array('You won. Word:', 'Kazandin. Kelime:'),
			array('Game over. Word:', 'Oyun bitti. Kelime:'),
			array('Final score: You', 'Son skor: Sen'),
			array('Computer', 'Bilgisayar'),
		),
		'de' => array(
			array('You mastered ', 'Gemeistert: '),
			array('You reached ', 'Erreichte Punktzahl: '),
			array(' with ', ' mit '),
			array(' points.', ' Punkte.'),
			array('points. Press Start and go again.', 'Punkte. Drucke Start und versuche es erneut.'),
			array('one duck is hiding under 1 of these 5 boxes. Find 30 ducks to finish the game.', 'eine Ente versteckt sich unter einer dieser 5 Kisten. Finde 30 Enten, um das Spiel zu beenden.'),
			array('You found all 30 ducks and earned', 'Du hast alle 30 Enten gefunden und verdient:'),
			array('coins. Press Play Again for a new run.', 'Munzen. Drucke Erneut spielen fur einen neuen Lauf.'),
			array('The duck was under box', 'Die Ente war unter Kiste'),
			array('No coins this round. Try the next one.', 'Keine Munzen in dieser Runde. Versuch die nachste.'),
			array('You escaped in', 'Du bist entkommen in'),
			array('steps with', 'Schritten mit'),
			array('sound pulses.', 'Schallimpulsen.'),
			array('Great job. You spelled', 'Gut gemacht. Du hast geschrieben:'),
			array('You ran out of lives. Final score:', 'Keine Leben mehr. Endstand:'),
			array('Wrong letter. You needed', 'Falscher Buchstabe. Du brauchtest'),
			array('Catch these letters in order:', 'Fange diese Buchstaben der Reihe nach:'),
			array('Game Over - Score:', 'Spiel vorbei - Punktzahl:'),
			array('Game Over — Score:', 'Spiel vorbei - Punktzahl:'),
			array('Wrong. Opposite was', 'Falsch. Das Gegenteil war'),
			array('You won. Word:', 'Gewonnen. Wort:'),
			array('Game over. Word:', 'Spiel vorbei. Wort:'),
			array('Final score: You', 'Endstand: Du'),
			array('Computer', 'Computer'),
		),
		'fr' => array(
			array('You mastered ', 'Tu as maitrise : '),
			array('You reached ', 'Score atteint : '),
			array(' with ', ' avec '),
			array(' points.', ' points.'),
			array('points. Press Start and go again.', 'points. Appuie sur Demarrer et recommence.'),
			array('one duck is hiding under 1 of these 5 boxes. Find 30 ducks to finish the game.', 'un canard se cache sous l une de ces 5 boites. Trouve 30 canards pour finir le jeu.'),
			array('You found all 30 ducks and earned', 'Tu as trouve les 30 canards et gagne'),
			array('coins. Press Play Again for a new run.', 'pieces. Appuie sur Rejouer pour une nouvelle partie.'),
			array('The duck was under box', 'Le canard etait sous la boite'),
			array('No coins this round. Try the next one.', 'Aucune piece cette manche. Essaie la suivante.'),
			array('You escaped in', 'Tu t es echappe en'),
			array('steps with', 'pas avec'),
			array('sound pulses.', 'impulsions sonores.'),
			array('Great job. You spelled', 'Bien joue. Tu as epele'),
			array('You ran out of lives. Final score:', 'Tu n as plus de vies. Score final :'),
			array('Wrong letter. You needed', 'Mauvaise lettre. Il fallait'),
			array('Catch these letters in order:', 'Attrape ces lettres dans l ordre :'),
			array('Game Over - Score:', 'Partie terminee - Score :'),
			array('Game Over — Score:', 'Partie terminee - Score :'),
			array('Wrong. Opposite was', 'Faux. L oppose etait'),
			array('You won. Word:', 'Tu as gagne. Mot :'),
			array('Game over. Word:', 'Partie terminee. Mot :'),
			array('Final score: You', 'Score final : Toi'),
			array('Computer', 'Ordinateur'),
		),
		'es-mx' => array(
			array('You mastered ', 'Dominaste: '),
			array('You reached ', 'Alcanzaste '),
			array(' with ', ' con '),
			array(' points.', ' puntos.'),
			array('points. Press Start and go again.', 'puntos. Presiona Iniciar y vuelve a intentarlo.'),
			array('one duck is hiding under 1 of these 5 boxes. Find 30 ducks to finish the game.', 'un pato se esconde debajo de una de estas 5 cajas. Encuentra 30 patos para terminar el juego.'),
			array('You found all 30 ducks and earned', 'Encontraste los 30 patos y ganaste'),
			array('coins. Press Play Again for a new run.', 'monedas. Presiona Jugar de nuevo para una nueva partida.'),
			array('The duck was under box', 'El pato estaba debajo de la caja'),
			array('No coins this round. Try the next one.', 'No hay monedas en esta ronda. Intenta la siguiente.'),
			array('You escaped in', 'Escapaste en'),
			array('steps with', 'pasos con'),
			array('sound pulses.', 'pulsos de sonido.'),
			array('Great job. You spelled', 'Muy bien. Deletreaste'),
			array('You ran out of lives. Final score:', 'Te quedaste sin vidas. Puntuacion final:'),
			array('Wrong letter. You needed', 'Letra incorrecta. Necesitabas'),
			array('Catch these letters in order:', 'Atrapa estas letras en orden:'),
			array('Game Over - Score:', 'Fin del juego - Puntuacion:'),
			array('Game Over — Score:', 'Fin del juego - Puntuacion:'),
			array('Wrong. Opposite was', 'Incorrecto. Lo opuesto era'),
			array('You won. Word:', 'Ganaste. Palabra:'),
			array('Game over. Word:', 'Fin del juego. Palabra:'),
			array('Final score: You', 'Puntuacion final: Tu'),
			array('Computer', 'Computadora'),
		),
	);
	$agent_replacements_more['es-es'] = array_merge($agent_replacements_more['es-mx'], array(
		array('Computer', 'Ordenador'),
	));

	$agent_replacements_followup = array(
		'tr' => array(
			array('Digit sum = ', 'Rakam toplami = '),
			array('is a perfect square.', 'tam karedir.'),
			array('is not a perfect square.', 'tam kare degildir.'),
			array('is prime.', 'asaldir.'),
			array('is not prime.', 'asal degildir.'),
			array('Incorrect. Digit sum = ', 'Yanlis. Rakam toplami = '),
			array('Incorrect. ', 'Yanlis. '),
			array('Which country has the capital ', 'Hangi ulkenin baskenti '),
			array('What is the capital of ', 'Baskenti hangi sehir: '),
			array(' is in which continent?', ' hangi kitadadir?'),
			array('What is the currency of ', 'Para birimi nedir: '),
			array('Which country uses ', 'Hangi ulke sunu kullanir: '),
			array('What language is mainly spoken in ', 'Hangi dil yaygin konusulur: '),
			array('Which country is linked with the ', 'Hangi ulke su dille iliskilidir: '),
			array(' language?', ' dili?'),
		),
		'de' => array(
			array('Digit sum = ', 'Quersumme = '),
			array('is a perfect square.', 'ist eine Quadratzahl.'),
			array('is not a perfect square.', 'ist keine Quadratzahl.'),
			array('is prime.', 'ist eine Primzahl.'),
			array('is not prime.', 'ist keine Primzahl.'),
			array('Incorrect. Digit sum = ', 'Falsch. Quersumme = '),
			array('Incorrect. ', 'Falsch. '),
			array('Which country has the capital ', 'Welches Land hat die Hauptstadt '),
			array('What is the capital of ', 'Was ist die Hauptstadt von '),
			array(' is in which continent?', ' liegt auf welchem Kontinent?'),
			array('What is the currency of ', 'Was ist die Wahrung von '),
			array('Which country uses ', 'Welches Land verwendet '),
			array('What language is mainly spoken in ', 'Welche Sprache wird hauptsachlich gesprochen in '),
			array('Which country is linked with the ', 'Welches Land ist mit der Sprache '),
			array(' language?', ' verbunden?'),
		),
		'fr' => array(
			array('Digit sum = ', 'Somme des chiffres = '),
			array('is a perfect square.', 'est un carre parfait.'),
			array('is not a perfect square.', 'n est pas un carre parfait.'),
			array('is prime.', 'est premier.'),
			array('is not prime.', 'n est pas premier.'),
			array('Incorrect. Digit sum = ', 'Incorrect. Somme des chiffres = '),
			array('Incorrect. ', 'Incorrect. '),
			array('Which country has the capital ', 'Quel pays a pour capitale '),
			array('What is the capital of ', 'Quelle est la capitale de '),
			array(' is in which continent?', ' est sur quel continent ?'),
			array('What is the currency of ', 'Quelle est la monnaie de '),
			array('Which country uses ', 'Quel pays utilise '),
			array('What language is mainly spoken in ', 'Quelle langue est principalement parlee en '),
			array('Which country is linked with the ', 'Quel pays est lie a la langue '),
			array(' language?', ' ?'),
		),
		'es-mx' => array(
			array('Digit sum = ', 'Suma de digitos = '),
			array('is a perfect square.', 'es un cuadrado perfecto.'),
			array('is not a perfect square.', 'no es un cuadrado perfecto.'),
			array('is prime.', 'es primo.'),
			array('is not prime.', 'no es primo.'),
			array('Incorrect. Digit sum = ', 'Incorrecto. Suma de digitos = '),
			array('Incorrect. ', 'Incorrecto. '),
			array('Which country has the capital ', 'Que pais tiene la capital '),
			array('What is the capital of ', 'Cual es la capital de '),
			array(' is in which continent?', ' esta en que continente?'),
			array('What is the currency of ', 'Cual es la moneda de '),
			array('Which country uses ', 'Que pais usa '),
			array('What language is mainly spoken in ', 'Que idioma se habla principalmente en '),
			array('Which country is linked with the ', 'Que pais esta relacionado con el idioma '),
			array(' language?', '?'),
		),
	);
	$agent_replacements_followup['es-es'] = array_merge($agent_replacements_followup['es-mx'], array(
		array('Which country has the capital ', 'Que pais tiene como capital '),
		array('Which country uses ', 'Que pais utiliza '),
	));

	foreach ($agent_replacements_followup as $followup_rep_lang => $followup_rep_items) {
		if (isset($common_replacements[$followup_rep_lang])) {
			$common_replacements[$followup_rep_lang] = array_merge($followup_rep_items, $common_replacements[$followup_rep_lang]);
		}
	}

	foreach ($agent_replacements_more as $agent_rep_lang => $agent_rep_items) {
		if (isset($common_replacements[$agent_rep_lang])) {
			$common_replacements[$agent_rep_lang] = array_merge($agent_rep_items, $common_replacements[$agent_rep_lang]);
		}
	}

	if (isset($phrases[$lang], $common_replacements[$lang])) {
		$phrases[$lang] = array_merge($common_replacements[$lang], $phrases[$lang]);
	}

	return isset($phrases[$lang]) ? $phrases[$lang] : array();
}

function zo_wrap_game_runtime_translator($html, $module, $lang) {
	$lang = array_key_exists($lang, zo_get_language_options()) ? $lang : zo_get_current_language();
	$slug = !empty($module['slug']) ? sanitize_html_class($module['slug']) : 'game';
	$id   = 'zo-game-shell-' . $slug . '-' . wp_rand(1000, 999999);

	$exact = zo_get_runtime_translation_exact_map($lang);
	$meta  = zo_get_game_display_metadata($module);
	$title = isset($meta['name']) ? zo_get_localized_text($meta['name'], $lang) : '';

	if ($title !== '') {
		if (!empty($module['name'])) {
			$exact[(string) $module['name']] = $title;
		}

		if (preg_match_all('/(?:^|\|)\s*(TR|EN|DE|FR|ES-MX|ES-ES):\s*([^|]+)/u', isset($meta['name']) ? $meta['name'] : '', $matches)) {
			foreach ($matches[2] as $name_part) {
				$name_part = trim($name_part);
				if ($name_part !== '') {
					$exact[$name_part] = $title;
				}
			}
		}
	}

	$payload = array(
		'lang' => $lang,
		'locale' => array(
			'tr' => 'tr-TR',
			'en' => 'en-US',
			'de' => 'de-DE',
			'fr' => 'fr-FR',
			'es-mx' => 'es-MX',
			'es-es' => 'es-ES',
		),
		'exact' => $exact,
		'replacements' => zo_get_runtime_translation_replacements($lang),
	);

	$script = '<script>(function(){'
		. 'const root=document.getElementById(' . wp_json_encode($id) . ');'
		. 'if(!root){return;}'
		. 'const payload=' . wp_json_encode($payload) . ';'
		. 'const exact=payload.exact||{};'
		. 'const reps=payload.replacements||[];'
		. 'const locale=(payload.locale&&payload.locale[payload.lang])||"";'
		. 'const skip={SCRIPT:1,STYLE:1,NOSCRIPT:1,TEXTAREA:1,CODE:1,PRE:1};'
		. 'const attrNames=["aria-label","aria-description","aria-valuetext","alt","title","placeholder","label","data-label","data-title","data-message","data-prompt","data-name","data-zone-label"];'
		. 'const attrSelector=attrNames.map(function(name){return "["+name+"]";}).concat(["[data-locale]","button","input","option"]).join(",");'
		. 'function applyCase(from,to){return from===from.toUpperCase()?to.toUpperCase():to;}'
		. 'function tx(value){if(typeof value!=="string"){return value;}const m=value.match(/^(\\s*)([\\s\\S]*?)(\\s*)$/);const lead=m?m[1]:"";let text=m?m[2]:value;const trail=m?m[3]:"";if(!text.trim()){return value;}const trimmed=text.trim();if(Object.prototype.hasOwnProperty.call(exact,trimmed)){return lead+exact[trimmed]+trail;}reps.forEach(function(pair){const from=pair[0];const to=pair[1];if(!from||!to){return;}text=text.split(from).join(applyCase(from,to));});return lead+text+trail;}'
		. 'root.__zoTranslate=tx;window.__zoGameI18nTranslateCanvas=function(canvas,value){if(typeof value!=="string"||!canvas||canvas.hasAttribute("data-zo-no-canvas-translate")){return value;}const shell=canvas.closest&&canvas.closest(".zo-game-shell");const fn=shell&&shell.__zoTranslate;return fn?fn(value):value;};'
		. 'if(window.CanvasRenderingContext2D&&!CanvasRenderingContext2D.prototype.__zoI18nPatched){["fillText","strokeText"].forEach(function(method){const original=CanvasRenderingContext2D.prototype[method];CanvasRenderingContext2D.prototype[method]=function(text){if(typeof text==="string"&&window.__zoGameI18nTranslateCanvas){arguments[0]=window.__zoGameI18nTranslateCanvas(this.canvas,text);}return original.apply(this,arguments);};});CanvasRenderingContext2D.prototype.__zoI18nPatched=true;}'
		. 'function nodeText(node){if(!node||!node.nodeValue){return;}const next=tx(node.nodeValue);if(next!==node.nodeValue){node.nodeValue=next;}}'
		. 'function attrs(el){attrNames.forEach(function(name){if(!el.hasAttribute||!el.hasAttribute(name)){return;}const next=tx(el.getAttribute(name));if(next!==el.getAttribute(name)){el.setAttribute(name,next);}});if(locale&&el.hasAttribute&&el.hasAttribute("data-locale")){el.setAttribute("data-locale",locale);}if(el.matches&&el.matches("input[type=button],input[type=submit],input[type=reset]")&&el.hasAttribute("value")){const next=tx(el.getAttribute("value"));if(next!==el.getAttribute("value")){el.setAttribute("value",next);el.value=next;}}if(el.matches&&el.matches("option")&&el.hasAttribute("label")){const next=tx(el.getAttribute("label"));if(next!==el.getAttribute("label")){el.setAttribute("label",next);}}}'
		. 'function walk(start){if(!start){return;}if(start.nodeType===3){nodeText(start);return;}if(start.nodeType!==1||skip[start.nodeName]){return;}attrs(start);const walker=document.createTreeWalker(start,NodeFilter.SHOW_TEXT,{acceptNode:function(n){return n.parentElement&&skip[n.parentElement.nodeName]?NodeFilter.FILTER_REJECT:NodeFilter.FILTER_ACCEPT;}});let n;while((n=walker.nextNode())){nodeText(n);}start.querySelectorAll&&start.querySelectorAll(attrSelector).forEach(attrs);}'
		. 'walk(root);'
		. 'setTimeout(function(){walk(root);},0);setTimeout(function(){walk(root);},250);window.addEventListener&&window.addEventListener("load",function(){walk(root);});'
		. 'let busy=false;const observer=new MutationObserver(function(items){if(busy){return;}busy=true;items.forEach(function(item){if(item.type==="characterData"){nodeText(item.target);}else{item.addedNodes.forEach(walk);if(item.type==="attributes"){attrs(item.target);}}});busy=false;});'
		. 'observer.observe(root,{childList:true,subtree:true,characterData:true,attributes:true,attributeFilter:attrNames.concat(["value","data-locale"])});'
		. '})();</script>';

	return '<div id="' . esc_attr($id) . '" class="zo-game-shell zo-game-shell--' . esc_attr($slug) . '" data-zo-game-lang="' . esc_attr($lang) . '">' . zo_get_shortcode_logo_html('game') . $html . '</div>' . $script;
}

function zo_get_localized_text($text, $lang = '') {
	$text = is_string($text) ? trim($text) : '';
	$lang = array_key_exists($lang, zo_get_language_options()) ? $lang : zo_get_current_language();

	if ($text === '') {
		return '';
	}

	$labels = array('tr' => 'TR:', 'en' => 'EN:', 'de' => 'DE:', 'fr' => 'FR:', 'es-mx' => 'ES-MX:', 'es-es' => 'ES-ES:');
	$matches = array();

	foreach ($labels as $key => $label) {
		$position = stripos($text, $label);

		if ($position !== false) {
			$matches[] = array(
				'lang'     => $key,
				'position' => $position,
				'length'   => strlen($label),
			);
		}
	}

	if (empty($matches)) {
		return $text;
	}

	usort(
		$matches,
		function ($a, $b) {
			return $a['position'] <=> $b['position'];
		}
	);

	$parts = array();
	$count = count($matches);

	for ($index = 0; $index < $count; $index++) {
		$start = $matches[$index]['position'] + $matches[$index]['length'];
		$end   = $index + 1 < $count ? $matches[$index + 1]['position'] : strlen($text);
		$value = substr($text, $start, $end - $start);
		$value = trim($value);
		$value = trim($value, " \t\n\r\0\x0B|");

		if ($value !== '') {
			$parts[$matches[$index]['lang']] = $value;
		}
	}

	$result = isset($parts[$lang]) ? $parts[$lang] : (isset($parts['en']) ? $parts['en'] : reset($parts));

	if (is_string($result) && $result !== $text && preg_match('/(?:^|\|)\s*(TR|EN|DE|FR|ES-MX|ES-ES):/i', $result)) {
		return zo_get_localized_text($result, $lang);
	}

	return $result;
}

function zo_fill_missing_metadata_languages($metadata, $module) {
	if (!is_array($metadata)) {
		return $metadata;
	}

	$fallback = zo_get_smart_fallback_game_metadata($module);
	if (!is_array($fallback)) {
		return $metadata;
	}

	foreach (array('name', 'description') as $field) {
		if (empty($metadata[$field]) || empty($fallback[$field]) || !is_string($metadata[$field]) || !is_string($fallback[$field])) {
			continue;
		}

		$metadata[$field] = zo_append_missing_localized_parts($metadata[$field], $fallback[$field], zo_get_language_options());
	}

	return $metadata;
}

function zo_get_asker_display_game_metadata($module) {
	if (empty($module['slug'])) {
		return null;
	}

	$metadata = zo_get_asker_multilingual_game_metadata(sanitize_title($module['slug']));
	if (!is_array($metadata)) {
		$metadata = zo_get_smart_fallback_game_metadata($module);
	}

	return is_array($metadata) ? zo_fill_missing_metadata_languages($metadata, $module) : null;
}

function zo_get_game_display_metadata($module) {
	if (empty($module['slug'])) {
		return zo_get_smart_fallback_game_metadata($module);
	}

	$metadata = zo_get_asker_multilingual_game_metadata(sanitize_title($module['slug']));
	if (!is_array($metadata)) {
		$metadata = zo_get_smart_fallback_game_metadata($module);
	}

	return is_array($metadata) ? zo_fill_missing_metadata_languages($metadata, $module) : null;
}

function zo_get_localized_game_display_metadata($module, $lang = '') {
	$lang = array_key_exists($lang, zo_get_language_options()) ? $lang : zo_get_current_language();
	$metadata = zo_get_game_display_metadata($module);
	$name = !empty($module['name']) && is_string($module['name']) ? $module['name'] : '';
	$description = !empty($module['description']) && is_string($module['description']) ? $module['description'] : '';
	$category_name = $name;
	$category_description = $description;

	if (is_array($metadata)) {
		if (!empty($metadata['name'])) {
			$category_name = zo_get_localized_text($metadata['name'], 'en');
		}

		if (!empty($metadata['description'])) {
			$category_description = zo_get_localized_text($metadata['description'], 'en');
		}

		if (!empty($metadata['name'])) {
			$name = zo_get_localized_text($metadata['name'], $lang);
		}

		if (!empty($metadata['description'])) {
			$description = zo_get_localized_text($metadata['description'], $lang);
		}
	}

	$slug = !empty($module['slug']) ? sanitize_title($module['slug']) : '';
	$category_key = zo_get_game_category($slug, $category_name, $category_description);
	$category_options = zo_get_game_category_options();
	$category_label = isset($category_options[$category_key][$lang]) ? $category_options[$category_key][$lang] : $category_key;

	return array(
		'name' => $name,
		'description' => $description,
		'category_key' => $category_key,
		'category_label' => $category_label,
	);
}

function zo_apply_asker_multilingual_game_metadata($module) {
	if (empty($module['slug']) || empty($module['author']) || !is_string($module['author'])) {
		return $module;
	}

	if (strcasecmp(trim($module['author']), 'Asker') !== 0) {
		return $module;
	}

	$metadata = zo_get_asker_display_game_metadata($module);
	if (!is_array($metadata)) {
		return $module;
	}

	if (!empty($metadata['name'])) {
		$module['name'] = $metadata['name'];
	}

	if (!empty($metadata['description'])) {
		$module['description'] = $metadata['description'];
	}

	return $module;
}

function zo_load_game_modules() {
	static $modules = null;

	if ($modules !== null) {
		return $modules;
	}

	if ((defined('REST_REQUEST') && REST_REQUEST) ||
		(defined('DOING_CRON') && DOING_CRON) ||
		(defined('WP_CLI') && WP_CLI)
	) {
		$modules = array();
		return $modules;
	}

	$modules = array();
	$files   = glob(ZO_PLUGIN_DIR . 'games/*/game.php');

	if (empty($files)) {
		return $modules;
	}

	sort($files);

	foreach ($files as $file) {
		$module = zo_load_game_module_file($file);

		if (!$module) {
			continue;
		}

		if (empty($module['slug']) || empty($module['name'])) {
			continue;
		}

		$slug          = sanitize_title($module['slug']);
		$folder        = basename(dirname($file));
		$author        = '';
		$inline_style  = '';
		$inline_script = '';

		if (!empty($module['author']) && is_string($module['author'])) {
			$author = trim(wp_strip_all_tags($module['author']));
		}

		if (!empty($module['inline_style']) && is_string($module['inline_style'])) {
			$inline_style = trim($module['inline_style']);
		}

		if (!empty($module['inline_script']) && is_string($module['inline_script'])) {
			$inline_script = trim($module['inline_script']);
		}

		$module['slug']          = $slug;
		$module['folder']        = $folder;
		$module['dir']           = trailingslashit(ZO_PLUGIN_DIR . 'games/' . $folder);
		$module['url']           = trailingslashit(ZO_PLUGIN_URL . 'games/' . $folder);
		$module['author']        = $author;
		$module['author_key']    = $author !== '' ? sanitize_title($author) : '';
		$module['inline_style']  = $inline_style;
		$module['inline_script'] = $inline_script;
		$module                  = zo_apply_asker_multilingual_game_metadata($module);

		$modules[$slug] = $module;
	}

	ksort($modules);

	return $modules;
}

function zo_get_game_modules() {
	return zo_load_game_modules();
}

function zo_get_game_module($slug) {
	$slug    = sanitize_title($slug);
	$modules = zo_get_game_modules();

	return isset($modules[$slug]) ? $modules[$slug] : null;
}

function zo_get_game_style_url($module) {
	if (!is_array($module) || empty($module['dir']) || empty($module['url'])) {
		return '';
	}

	$style_file = trailingslashit($module['dir']) . 'style.css';

	return file_exists($style_file) ? trailingslashit($module['url']) . 'style.css' : '';
}

function zo_get_game_script_url($module) {
	if (!is_array($module) || empty($module['dir']) || empty($module['url'])) {
		return '';
	}

	$script_file = trailingslashit($module['dir']) . 'script.js';

	return file_exists($script_file) ? trailingslashit($module['url']) . 'script.js' : '';
}

function zo_game_module_has_generated_image_marker($module) {
	return is_array($module)
		&& !empty($module['dir'])
		&& file_exists(trailingslashit($module['dir']) . '.featured-image.generated');
}

function zo_get_game_module_featured_image_path($module, $include_generated = false) {
	if (!is_array($module) || empty($module['dir']) || empty($module['url'])) {
		return '';
	}

	foreach (array('featured_image', 'thumbnail', 'image') as $key) {
		if (empty($module[$key]) || !is_string($module[$key])) {
			continue;
		}

		$value = trim($module[$key]);
		if ($value === '') {
			continue;
		}

		if (preg_match('#^https?://#i', $value)) {
			continue;
		}

		$value = ltrim($value, '/\\');
		if (file_exists(trailingslashit($module['dir']) . $value)) {
			return trailingslashit($module['dir']) . $value;
		}
	}

	if (!$include_generated && zo_game_module_has_generated_image_marker($module)) {
		return '';
	}

	foreach (array('featured-image.webp', 'featured-image.png', 'featured-image.jpg', 'featured-image.jpeg', 'featured-image.svg') as $filename) {
		if (file_exists(trailingslashit($module['dir']) . $filename)) {
			return trailingslashit($module['dir']) . $filename;
		}
	}

	return '';
}

function zo_get_game_module_featured_image_url($module) {
	if (!is_array($module) || empty($module['dir']) || empty($module['url'])) {
		return '';
	}

	foreach (array('featured_image', 'thumbnail', 'image') as $key) {
		if (empty($module[$key]) || !is_string($module[$key])) {
			continue;
		}

		$value = trim($module[$key]);
		if ($value !== '' && preg_match('#^https?://#i', $value)) {
			return esc_url_raw($value);
		}
	}

	$image_path = zo_get_game_module_featured_image_path($module);
	if ($image_path === '') {
		return '';
	}

	$dir = trailingslashit(str_replace('\\', '/', $module['dir']));
	$url = trailingslashit($module['url']);
	$path = str_replace('\\', '/', $image_path);

	if (strpos($path, $dir) !== 0) {
		return '';
	}

	return $url . ltrim(substr($path, strlen($dir)), '/');
}

function zo_set_game_post_thumbnail_from_module($post_id, $module) {
	$post_id = (int) $post_id;

	if ($post_id <= 0 || !is_array($module) || has_post_thumbnail($post_id)) {
		return;
	}

	$image_path = zo_get_game_module_featured_image_path($module);
	if ($image_path === '') {
		return;
	}

	$extension = strtolower((string) pathinfo($image_path, PATHINFO_EXTENSION));
	if (!in_array($extension, array('jpg', 'jpeg', 'png', 'webp'), true)) {
		return;
	}

	$mtime = filemtime($image_path);
	if ($mtime === false) {
		return;
	}

	$source_key = md5($image_path . '|' . $mtime);
	if ((string) get_post_meta($post_id, '_zo_game_featured_image_source', true) === $source_key) {
		return;
	}

	$contents = @file_get_contents($image_path);
	if (!is_string($contents) || $contents === '') {
		return;
	}

	$slug     = !empty($module['slug']) ? sanitize_title($module['slug']) : 'game';
	$filename = sanitize_file_name($slug . '-featured-image.' . $extension);
	$upload   = wp_upload_bits($filename, null, $contents);

	if (!empty($upload['error']) || empty($upload['file'])) {
		return;
	}

	$filetype = wp_check_filetype($upload['file'], null);
	if (empty($filetype['type'])) {
		return;
	}

	$title = !empty($module['name']) && is_string($module['name']) ? $module['name'] : $slug;
	$attachment_id = wp_insert_attachment(
		array(
			'post_mime_type' => $filetype['type'],
			'post_title'     => sanitize_text_field($title . ' featured image'),
			'post_content'   => '',
			'post_status'    => 'inherit',
		),
		$upload['file'],
		$post_id
	);

	if (is_wp_error($attachment_id) || $attachment_id <= 0) {
		return;
	}

	require_once ABSPATH . 'wp-admin/includes/image.php';

	$metadata = wp_generate_attachment_metadata($attachment_id, $upload['file']);
	if (is_array($metadata)) {
		wp_update_attachment_metadata($attachment_id, $metadata);
	}

	if (set_post_thumbnail($post_id, $attachment_id)) {
		update_post_meta($post_id, '_zo_game_featured_image_source', $source_key);
	}
}

function zo_remove_generated_folder_image_when_post_has_thumbnail($post_id, $module) {
	$post_id = (int) $post_id;

	if ($post_id <= 0 || !is_array($module) || !has_post_thumbnail($post_id)) {
		return;
	}

	if ((string) get_post_meta($post_id, '_zo_game_featured_image_source', true) !== '') {
		return;
	}

	$image_path = zo_get_game_module_featured_image_path($module, true);
	if ($image_path === '' || basename($image_path) !== 'featured-image.png') {
		return;
	}

	$marker_path = trailingslashit($module['dir']) . '.featured-image.generated';
	if (!file_exists($marker_path)) {
		return;
	}

	@unlink($image_path);
	@unlink($marker_path);
}

function zo_remove_generated_placeholder_post_thumbnail($post_id, $module) {
	$post_id = (int) $post_id;

	if ($post_id <= 0 || !is_array($module) || !has_post_thumbnail($post_id)) {
		return;
	}

	if (!zo_game_module_has_generated_image_marker($module)) {
		return;
	}

	if ((string) get_post_meta($post_id, '_zo_game_featured_image_source', true) === '') {
		return;
	}

	delete_post_thumbnail($post_id);
	delete_post_meta($post_id, '_zo_game_featured_image_source');
}

function zo_get_game_thumbnail_initials($title, $slug) {
	$title = trim(wp_strip_all_tags((string) $title));
	$parts = preg_split('/\s+/', $title);
	$text  = '';

	if (is_array($parts)) {
		foreach ($parts as $part) {
			$part = trim($part);
			if ($part === '') {
				continue;
			}

			$text .= function_exists('mb_substr') ? mb_substr($part, 0, 1) : substr($part, 0, 1);
			if (strlen($text) >= 2) {
				break;
			}
		}
	}

	if ($text === '') {
		$text = strtoupper(substr(sanitize_title($slug), 0, 2));
	}

	return strtoupper($text);
}

function zo_get_game_thumbnail_theme($slug, $title) {
	$text   = strtolower((string) $slug . ' ' . (string) $title);
	$themes = array(
		array('from' => '#0f766e', 'to' => '#22c55e', 'accent' => '#ccfbf1', 'label' => 'Puzzle'),
		array('from' => '#1d4ed8', 'to' => '#38bdf8', 'accent' => '#dbeafe', 'label' => 'Arcade'),
		array('from' => '#7c3aed', 'to' => '#f472b6', 'accent' => '#f5d0fe', 'label' => 'Quest'),
		array('from' => '#b45309', 'to' => '#facc15', 'accent' => '#fef3c7', 'label' => 'Challenge'),
		array('from' => '#be123c', 'to' => '#fb7185', 'accent' => '#ffe4e6', 'label' => 'Action'),
		array('from' => '#334155', 'to' => '#14b8a6', 'accent' => '#e2e8f0', 'label' => 'Logic'),
	);

	if (preg_match('/chess|dama|sudoku|puzzle|maze|memory|word|number|binary|logic|rule/', $text)) {
		return $themes[5];
	}

	if (preg_match('/race|runner|car|soccer|shoot|battle|defense|army|fight|ninja/', $text)) {
		return $themes[4];
	}

	if (preg_match('/treasure|temple|pirate|dragon|magic|mystery|quest|hazine|misir|anubis/', $text)) {
		return $themes[2];
	}

	if (preg_match('/clock|time|calculator|builder|sort|designer|paint/', $text)) {
		return $themes[0];
	}

	$index = abs((int) crc32((string) $slug)) % count($themes);

	return $themes[$index];
}

function zo_render_game_thumbnail($post, $module, $url, $title) {
	if ($url === '') {
		return;
	}

	if ($post instanceof WP_Post && has_post_thumbnail($post)) {
		echo '<a class="zo-games-grid__thumb" href="' . esc_url($url) . '">';
		echo get_the_post_thumbnail($post, 'large');
		echo '</a>';
		return;
	}

	$image_url = zo_get_game_module_featured_image_url($module);
	if ($image_url !== '') {
		echo '<a class="zo-games-grid__thumb" href="' . esc_url($url) . '">';
		echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($title) . '" loading="lazy">';
		echo '</a>';
		return;
	}
}

function zo_get_game_slug_for_post($post_id) {
	return sanitize_title((string) get_post_meta($post_id, '_zo_game_slug', true));
}

function zo_get_game_owner_options() {
	return array(
		'arslan' => 'Arslan',
		'asker'  => 'Asker',
	);
}

function zo_normalize_game_owner($owner) {
	$owner = sanitize_title((string) $owner);

	return array_key_exists($owner, zo_get_game_owner_options()) ? $owner : '';
}

function zo_get_game_owner_for_post($post_id) {
	return zo_normalize_game_owner(get_post_meta($post_id, '_zo_game_owner', true));
}

function zo_get_game_owner_label($owner) {
	$options = zo_get_game_owner_options();
	$owner   = zo_normalize_game_owner($owner);

	return $owner !== '' ? $options[$owner] : '';
}

function zo_get_game_owner_for_module($module) {
	if (!is_array($module) || empty($module['author_key'])) {
		return '';
	}

	return zo_normalize_game_owner($module['author_key']);
}

function zo_get_owner_games_url($owner, $lang = '') {
	$owner = zo_normalize_game_owner($owner);
	$lang  = array_key_exists($lang, zo_get_language_options()) ? $lang : zo_get_current_language();
	$path  = $owner === 'asker' ? '/askerin-oyunlari/' : '/arslanin-oyunlari/';

	return add_query_arg('zo_lang', $lang, home_url($path));
}

function zo_get_owner_about_url($owner, $lang = '') {
	$owner = zo_normalize_game_owner($owner);
	$lang  = array_key_exists($lang, zo_get_language_options()) ? $lang : zo_get_current_language();

	if ($owner !== 'asker') {
		return '';
	}

	foreach (array('about-askerin-oyunlari', 'askerin-oyunlari-hakkinda', 'asker-hakkinda') as $path) {
		$page = get_page_by_path($path);

		if ($page instanceof WP_Post) {
			$url = get_permalink($page);
			return is_string($url) && $url !== '' ? add_query_arg('zo_lang', $lang, $url) : '';
		}
	}

	return add_query_arg('zo_lang', $lang, home_url('/about-askerin-oyunlari/'));
}

function zo_resolve_game_slug_for_post($post_id) {
	$slug = zo_get_game_slug_for_post($post_id);

	if ($slug !== '') {
		return $slug;
	}

	$post = get_post($post_id);
	if (!$post instanceof WP_Post) {
		return '';
	}

	$fallback_slug = sanitize_title((string) $post->post_name);
	if ($fallback_slug === '') {
		return '';
	}

	return zo_get_game_module($fallback_slug) ? $fallback_slug : '';
}

function zo_verify_nonce($nonce_name, $nonce_action) {
	if (empty($_REQUEST[$nonce_name]) || !is_string($_REQUEST[$nonce_name])) {
		return false;
	}

	return wp_verify_nonce(wp_unslash($_REQUEST[$nonce_name]), $nonce_action) !== false;
}

function zo_get_nonce($nonce_action) {
	return wp_create_nonce($nonce_action);
}

function zo_get_current_request_url() {
	if (empty($_SERVER['REQUEST_URI']) || !is_string($_SERVER['REQUEST_URI'])) {
		return '';
	}

	$url = home_url(wp_unslash($_SERVER['REQUEST_URI']));

	return is_string($url) ? esc_url_raw($url) : '';
}

function zo_get_requested_game_slug() {
	if (is_singular('zeka_oyunu')) {
		$post_id = get_queried_object_id();
		$slug    = zo_resolve_game_slug_for_post($post_id);

		return $slug !== '' ? $slug : '';
	}

	if (empty($_GET['zo_game_module']) || !is_string($_GET['zo_game_module'])) {
		return '';
	}

	if (!empty($_GET['zo_nonce']) && is_string($_GET['zo_nonce']) && !zo_verify_nonce('zo_nonce', 'zo_game_module')) {
		return '';
	}

	$slug = sanitize_title(wp_unslash($_GET['zo_game_module']));

	return $slug !== '' && zo_get_game_module($slug) ? $slug : '';
}

function zo_get_game_module_fallback_url($slug) {
	$slug = sanitize_title($slug);

	if ($slug === '' || !zo_get_game_module($slug)) {
		return '';
	}

	$base_url = get_post_type_archive_link('zeka_oyunu');

	if (!is_string($base_url) || $base_url === '') {
		$base_url = home_url('/');
	}

	$url = add_query_arg('zo_game_module', $slug, $base_url);
	$url = add_query_arg('zo_nonce', zo_get_nonce('zo_game_module'), $url);
	$url = add_query_arg('zo_lang', zo_get_current_language(), $url);

	$back_url = zo_get_current_request_url();
	if ($back_url !== '') {
		$url = add_query_arg('zo_back', $back_url, $url);
	}

	return $url;
}

function zo_get_game_launch_url($post) {
	$url = get_permalink($post);

	if (!is_string($url) || $url === '') {
		return '';
	}

	$back_url = zo_get_current_request_url();
	if ($back_url !== '') {
		$url = add_query_arg('zo_back', $back_url, $url);
	}

	$url = add_query_arg('zo_lang', zo_get_current_language(), $url);

	return $url;
}

function zo_get_game_back_url($post_id = 0) {
	$current_url = $post_id ? get_permalink($post_id) : '';

	if (!empty($_GET['zo_back']) && is_string($_GET['zo_back'])) {
		if (!empty($_GET['zo_nonce']) && is_string($_GET['zo_nonce']) && !zo_verify_nonce('zo_nonce', 'zo_game_module')) {
			// Nonce validation failed, skip the zo_back parameter
		} else {
			$candidate = wp_unslash($_GET['zo_back']);
			$candidate = wp_validate_redirect($candidate, '');

			if ($candidate !== '' && $candidate !== $current_url) {
				return $candidate;
			}
		}
	}

	$referer = wp_get_referer();
	if (is_string($referer) && $referer !== '' && $referer !== $current_url) {
		return $referer;
	}

	$archive = get_post_type_archive_link('zeka_oyunu');
	if (is_string($archive) && $archive !== '') {
		return $archive;
	}

	return home_url('/');
}

function zo_get_default_game_post_excerpt($module) {
	$metadata = zo_get_game_display_metadata($module);

	if (!empty($metadata['description']) && is_string($metadata['description'])) {
		return trim($metadata['description']);
	}

	if (!empty($module['description']) && is_string($module['description'])) {
		return trim($module['description']);
	}

	return '';
}

function zo_sync_game_module_posts() {
	static $done = false;

	if ($done || wp_installing() || !post_type_exists('zeka_oyunu')) {
		return;
	}

	if (function_exists('wp_doing_ajax') && wp_doing_ajax()) {
		zo_get_game_modules();
		return;
	}

	$done = true;

	$modules = zo_get_game_modules();
	if (empty($modules)) {
		return;
	}

	$posts = get_posts(
		array(
			'post_type'           => 'zeka_oyunu',
			'post_status'         => array('publish', 'draft', 'pending', 'future', 'private'),
			'posts_per_page'      => -1,
			'orderby'             => 'date',
			'order'               => 'DESC',
			'suppress_filters'    => true,
			'no_found_rows'       => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);

	$posts_by_slug = array();

	foreach ($posts as $post) {
		$slug = zo_get_game_slug_for_post($post->ID);

		if ($slug === '') {
			$fallback_slug = sanitize_title($post->post_name);
			if ($fallback_slug !== '' && isset($modules[$fallback_slug])) {
				$slug = $fallback_slug;
				update_post_meta($post->ID, '_zo_game_slug', $slug);
			}
		}

		if ($slug === '' || !isset($modules[$slug]) || isset($posts_by_slug[$slug])) {
			continue;
		}

		$posts_by_slug[$slug] = $post;
	}

	foreach ($modules as $slug => $module) {
		$display_metadata = zo_get_game_display_metadata($module);
		$post_title    = !empty($display_metadata['name']) && is_string($display_metadata['name']) ? $display_metadata['name'] : $module['name'];
		$excerpt       = zo_get_default_game_post_excerpt($module);
		$existing_post = $posts_by_slug[$slug] ?? null;

		if ($existing_post instanceof WP_Post) {
			if ((string) get_post_meta($existing_post->ID, '_zo_game_autogenerated', true) === '1') {
				$update = array('ID' => $existing_post->ID);

				if ($existing_post->post_title !== $post_title) {
					$update['post_title'] = $post_title;
				}

				if ($existing_post->post_excerpt !== $excerpt) {
					$update['post_excerpt'] = $excerpt;
				}

				if ($existing_post->post_name !== $slug) {
					$update['post_name'] = $slug;
				}

				if (count($update) > 1) {
					wp_update_post(wp_slash($update));
				}
			}

			if (zo_get_game_slug_for_post($existing_post->ID) !== $slug) {
				update_post_meta($existing_post->ID, '_zo_game_slug', $slug);
			}

			if (zo_get_game_owner_for_post($existing_post->ID) === '') {
				$owner = zo_get_game_owner_for_module($module);

				if ($owner !== '') {
					update_post_meta($existing_post->ID, '_zo_game_owner', $owner);
				}
			}

			zo_remove_generated_placeholder_post_thumbnail($existing_post->ID, $module);
			zo_remove_generated_folder_image_when_post_has_thumbnail($existing_post->ID, $module);
			zo_set_game_post_thumbnail_from_module($existing_post->ID, $module);

			continue;
		}

		$post_id = wp_insert_post(
			wp_slash(
				array(
					'post_type'    => 'zeka_oyunu',
					'post_status'  => 'publish',
					'post_title'   => $post_title,
					'post_name'    => $slug,
					'post_excerpt' => $excerpt,
					'post_content' => '',
				)
			),
			true
		);

		if (is_wp_error($post_id) || $post_id <= 0) {
			continue;
		}

		update_post_meta($post_id, '_zo_game_slug', $slug);
		update_post_meta($post_id, '_zo_game_autogenerated', '1');

		$owner = zo_get_game_owner_for_module($module);
		if ($owner !== '') {
			update_post_meta($post_id, '_zo_game_owner', $owner);
		}

		zo_set_game_post_thumbnail_from_module($post_id, $module);
	}
}

function zo_register_game_post_type() {
	$labels = array(
		'name'               => 'Zekâ Oyunları',
		'singular_name'      => 'Zekâ Oyunu',
		'menu_name'          => 'Zekâ Oyunları',
		'name_admin_bar'     => 'Zekâ Oyunu',
		'add_new'            => 'Yeni Ekle',
		'add_new_item'       => 'Yeni Oyun Ekle',
		'edit_item'          => 'Oyunu Düzenle',
		'new_item'           => 'Yeni Oyun',
		'view_item'          => 'Oyunu Görüntüle',
		'all_items'          => 'Tüm Oyunlar',
		'search_items'       => 'Oyun Ara',
		'not_found'          => 'Oyun bulunamadı.',
		'not_found_in_trash' => 'Çöpte oyun bulunamadı.',
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'show_in_rest'       => true,
		'menu_icon'          => 'dashicons-games',
		'has_archive'        => true,
		'rewrite'            => array('slug' => 'oyunlar'),
		'supports'           => array('title', 'editor', 'excerpt', 'thumbnail'),
		'publicly_queryable' => true,
		'show_in_menu'       => true,
	);

	register_post_type('zeka_oyunu', $args);
}
add_action('init', 'zo_register_game_post_type');
add_action('init', 'zo_sync_game_module_posts', 20);

function zo_add_game_meta_box() {
	add_meta_box(
		'zo_game_module_box',
		'Oyun Modülü',
		'zo_render_game_meta_box',
		'zeka_oyunu',
		'side',
		'high'
	);

	add_meta_box(
		'zo_game_owner_box',
		'Oyun Sahibi',
		'zo_render_game_owner_meta_box',
		'zeka_oyunu',
		'side',
		'high'
	);
}
add_action('add_meta_boxes', 'zo_add_game_meta_box');

function zo_render_game_meta_box($post) {
	wp_nonce_field('zo_save_game_module', 'zo_game_module_nonce');
	wp_nonce_field('zo_save_game_meta', 'zo_meta_save_nonce');

	$selected = zo_get_game_slug_for_post($post->ID);
	$modules  = zo_get_game_modules();

	echo '<p><label for="zo_game_slug"><strong>Bu sayfada hangi oyun çalışsın?</strong></label></p>';

	if (empty($modules)) {
		echo '<p>Henüz hiç oyun modülü bulunamadı. <code>/games/</code> içine bir oyun klasörü ekleyin.</p>';
		return;
	}

	echo '<select name="zo_game_slug" id="zo_game_slug" style="width:100%;">';
	echo '<option value="">Bir oyun seçin</option>';

	foreach ($modules as $module) {
		printf(
			'<option value="%1$s" %2$s>%3$s</option>',
			esc_attr($module['slug']),
			selected($selected, $module['slug'], false),
			esc_html($module['name'])
		);
	}

	echo '</select>';

	if ($selected) {
		$module = zo_get_game_module($selected);

		if ($module && !empty($module['description'])) {
			echo '<p style="margin-top:10px;">' . esc_html($module['description']) . '</p>';
		}
	}

	echo '<p style="margin-top:10px;">You can also embed a game anywhere with:<br><code>[zeka_oyunu slug="hizli-tikla"]</code></p>';
}

function zo_render_game_owner_meta_box($post) {
	wp_nonce_field('zo_save_game_owner', 'zo_game_owner_nonce');

	$selected = zo_get_game_owner_for_post($post->ID);
	$slug     = zo_get_game_slug_for_post($post->ID);
	$module   = $slug !== '' ? zo_get_game_module($slug) : null;

	if ($selected === '' && $module) {
		$selected = zo_get_game_owner_for_module($module);
	}

	if ($selected === '') {
		$selected = 'arslan';
	}

	echo '<p><strong>Bu oyun hangi listeye eklensin?</strong></p>';

	foreach (zo_get_game_owner_options() as $value => $label) {
		printf(
			'<p><label><input type="radio" name="zo_game_owner" value="%1$s" %2$s> %3$s</label></p>',
			esc_attr($value),
			checked($selected, $value, false),
			esc_html($label)
		);
	}

	echo '<p style="margin-top:10px;color:#646970;">Arslan ya da Asker oyun listesi buna gore filtrelenir.</p>';
}

function zo_save_game_meta($post_id) {
	if (
		(!isset($_POST['zo_game_module_nonce']) || !wp_verify_nonce($_POST['zo_game_module_nonce'], 'zo_save_game_module')) &&
		(!isset($_POST['zo_game_owner_nonce']) || !wp_verify_nonce($_POST['zo_game_owner_nonce'], 'zo_save_game_owner'))
	) {
		return;
	}

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	if (isset($_POST['zo_game_module_nonce']) && wp_verify_nonce($_POST['zo_game_module_nonce'], 'zo_save_game_module')) {
		if (!isset($_POST['zo_meta_save_nonce']) || !wp_verify_nonce($_POST['zo_meta_save_nonce'], 'zo_save_game_meta')) {
			return;
		}

		$slug = isset($_POST['zo_game_slug']) ? sanitize_title(wp_unslash($_POST['zo_game_slug'])) : '';

		if ($slug && zo_get_game_module($slug)) {
			update_post_meta($post_id, '_zo_game_slug', $slug);
		} else {
			delete_post_meta($post_id, '_zo_game_slug');
		}
	}

	if (isset($_POST['zo_game_owner_nonce']) && wp_verify_nonce($_POST['zo_game_owner_nonce'], 'zo_save_game_owner')) {
		$owner = isset($_POST['zo_game_owner']) ? zo_normalize_game_owner(wp_unslash($_POST['zo_game_owner'])) : '';

		if ($owner !== '') {
			update_post_meta($post_id, '_zo_game_owner', $owner);
		} else {
			delete_post_meta($post_id, '_zo_game_owner');
		}
	}
}
add_action('save_post_zeka_oyunu', 'zo_save_game_meta');

function zo_get_style_handle($slug) {
	return 'zo-game-style-' . sanitize_title($slug);
}

function zo_get_script_handle($slug) {
	return 'zo-game-script-' . sanitize_title($slug);
}

function zo_get_input_blocker_style_handle() {
	return 'zo-game-input-blockers-style';
}

function zo_get_input_blocker_script_handle() {
	return 'zo-game-input-blockers';
}

function zo_get_input_blocker_css() {
	return zo_get_shortcode_logo_css() . '
.zo-game-shell,
.zo-game-root {
	-webkit-tap-highlight-color: transparent;
	-webkit-touch-callout: none;
	overscroll-behavior: auto;
	touch-action: pan-y pinch-zoom;
	user-select: none;
	-webkit-user-drag: none;
	user-drag: none;
}

.zo-game-shell img,
.zo-game-shell canvas,
.zo-game-shell svg,
.zo-game-root img,
.zo-game-root canvas,
.zo-game-root svg {
	-webkit-user-drag: none;
	user-drag: none;
}

.zo-game-shell input,
.zo-game-shell textarea,
.zo-game-shell select,
.zo-game-shell [contenteditable="true"],
.zo-game-root input,
.zo-game-root textarea,
.zo-game-root select,
.zo-game-root [contenteditable="true"] {
	touch-action: manipulation;
	user-select: text;
}

@media (max-width: 768px) {
	html,
	body {
		overscroll-behavior-y: auto;
		-webkit-overflow-scrolling: touch;
	}

	.zo-shortcode-frame,
	.zo-game-shell,
	.zo-game-root {
		max-width: 100%;
		overflow-x: auto !important;
		overflow-y: visible !important;
		-webkit-overflow-scrolling: touch;
		overscroll-behavior-y: auto !important;
		touch-action: pan-y pinch-zoom !important;
	}

	.zo-game-shell button,
	.zo-game-shell a,
	.zo-game-shell input,
	.zo-game-shell textarea,
	.zo-game-shell select,
	.zo-game-root button,
	.zo-game-root a,
	.zo-game-root input,
	.zo-game-root textarea,
	.zo-game-root select {
		touch-action: manipulation;
	}

	.zo-game-shell canvas,
	.zo-game-root canvas,
	.zo-game-shell svg,
	.zo-game-root svg,
	.zo-game-shell [role="application"],
	.zo-game-root [role="application"],
	.zo-game-shell [data-zo-game-board],
	.zo-game-root [data-zo-game-board] {
		touch-action: pan-y pinch-zoom !important;
	}
}
';
}

function zo_get_input_blocker_js() {
	return <<<'JS'
(function () {
	if (window.__zoGameInputBlockersReady) {
		return;
	}

	window.__zoGameInputBlockersReady = true;

	var blockedKeys = {
		ArrowUp: true,
		ArrowDown: true,
		ArrowLeft: true,
		ArrowRight: true,
		Space: true,
		PageUp: true,
		PageDown: true,
		Home: true,
		End: true,
		Backspace: true,
		Delete: true,
		Enter: true,
		Escape: true,
		Esc: true,
		Spacebar: true,
		Insert: true,
		w: true,
		a: true,
		s: true,
		d: true,
		q: true,
		e: true,
		r: true,
		f: true,
		z: true,
		x: true,
		c: true,
		v: true,
		i: true,
		j: true,
		k: true,
		l: true,
		p: true,
		W: true,
		A: true,
		S: true,
		D: true,
		Q: true,
		E: true,
		R: true,
		F: true,
		Z: true,
		X: true,
		C: true,
		V: true,
		I: true,
		J: true,
		K: true,
		L: true,
		P: true
	};
	var blockedCodes = {
		ArrowUp: true,
		ArrowDown: true,
		ArrowLeft: true,
		ArrowRight: true,
		Space: true,
		PageUp: true,
		PageDown: true,
		Home: true,
		End: true,
		Backspace: true,
		Delete: true,
		Enter: true,
		Escape: true,
		Insert: true,
		ShiftLeft: true,
		ShiftRight: true,
		KeyW: true,
		KeyA: true,
		KeyS: true,
		KeyD: true,
		KeyQ: true,
		KeyE: true,
		KeyR: true,
		KeyF: true,
		KeyZ: true,
		KeyX: true,
		KeyC: true,
		KeyV: true,
		KeyI: true,
		KeyJ: true,
		KeyK: true,
		KeyL: true,
		KeyP: true,
		Numpad8: true,
		Numpad4: true,
		Numpad2: true,
		Numpad6: true,
		NumpadEnter: true,
		NumpadAdd: true,
		NumpadSubtract: true,
		NumpadMultiply: true,
		NumpadDivide: true,
		Digit0: true,
		Digit1: true,
		Digit2: true,
		Digit3: true,
		Digit4: true,
		Digit5: true,
		Digit6: true,
		Digit7: true,
		Digit8: true,
		Digit9: true
	};
	var lastActiveGame = null;

	function getGameRoot(element) {
		if (!element || element === document || element === window) {
			return null;
		}

		if (element.closest) {
			return element.closest('.zo-game-shell, .zo-game-root');
		}

		return null;
	}

	function isEditable(element) {
		if (!element || !element.closest) {
			return false;
		}

		return !!element.closest('input, textarea, select, [contenteditable="true"], [contenteditable=""]');
	}

	function isInteractive(element) {
		if (!element || !element.closest) {
			return false;
		}

		return !!element.closest('button, a, input, textarea, select, label, summary, [role="button"], [contenteditable="true"], [contenteditable=""]');
	}

	function isSafeTarget(element) {
		return isEditable(element) || isInteractive(element);
	}

	function findSingleGameRoot() {
		var games = document.querySelectorAll('.zo-game-shell, .zo-game-root');
		return games.length === 1 ? games[0] : null;
	}

	function normalizeKey(event) {
		if (event.code === 'Space' || event.key === ' ') {
			return 'Space';
		}

		return event.key || event.code || '';
	}

	function ensureFocusable(game) {
		if (game && !game.hasAttribute('tabindex')) {
			game.setAttribute('tabindex', '0');
		}
	}

	function rememberGameFromEvent(event) {
		var game = getGameRoot(event.target);

		if (!game) {
			return null;
		}

		lastActiveGame = game;
		ensureFocusable(game);
		return game;
	}

	function handlePointerDown(event) {
		var game = rememberGameFromEvent(event);

		if (!game) {
			lastActiveGame = null;
			return;
		}

		if (!isInteractive(event.target) && game.focus) {
			game.focus({ preventScroll: true });
		}
	}

	function handleKeyBlock(event) {
		if (event.defaultPrevented || event.altKey || event.ctrlKey || event.metaKey) {
			return;
		}

		var key = normalizeKey(event);
		if (!blockedKeys[key] && !blockedCodes[event.code]) {
			return;
		}

		if (isSafeTarget(event.target)) {
			return;
		}

		var game = getGameRoot(event.target) || getGameRoot(document.activeElement) || lastActiveGame || findSingleGameRoot();
		if (!game) {
			return;
		}

		event.preventDefault();
	}

	function handleGameOnlyDefault(event) {
		if (getGameRoot(event.target) && !isSafeTarget(event.target)) {
			event.preventDefault();
		}
	}

	document.addEventListener('pointerdown', handlePointerDown, true);
	document.addEventListener('pointerover', rememberGameFromEvent, true);
	document.addEventListener('keydown', handleKeyBlock, true);
	document.addEventListener('keyup', handleKeyBlock, true);
	document.addEventListener('keypress', handleKeyBlock, true);
	document.addEventListener('dragstart', handleGameOnlyDefault, true);
	document.addEventListener('selectstart', handleGameOnlyDefault, true);
	document.addEventListener('contextmenu', handleGameOnlyDefault, true);
	document.addEventListener('auxclick', handleGameOnlyDefault, true);
	document.addEventListener('dblclick', handleGameOnlyDefault, true);
	document.addEventListener('gesturestart', handleGameOnlyDefault, true);
	document.addEventListener('gesturechange', handleGameOnlyDefault, true);
	document.addEventListener('gestureend', handleGameOnlyDefault, true);

	document.querySelectorAll('.zo-game-shell, .zo-game-root').forEach(ensureFocusable);
})();
JS;
}

function zo_register_input_blocker_assets() {
	wp_register_style(
		zo_get_input_blocker_style_handle(),
		false,
		array(),
		ZO_PLUGIN_VERSION
	);
	wp_add_inline_style(zo_get_input_blocker_style_handle(), zo_get_input_blocker_css());

	wp_register_script(
		zo_get_input_blocker_script_handle(),
		false,
		array(),
		ZO_PLUGIN_VERSION,
		true
	);
	wp_add_inline_script(zo_get_input_blocker_script_handle(), zo_get_input_blocker_js());
}
add_action('wp_enqueue_scripts', 'zo_register_input_blocker_assets', 4);

function zo_enqueue_input_blocker_assets() {
	if (wp_style_is(zo_get_input_blocker_style_handle(), 'registered')) {
		wp_enqueue_style(zo_get_input_blocker_style_handle());
	}

	if (wp_script_is(zo_get_input_blocker_script_handle(), 'registered')) {
		wp_enqueue_script(zo_get_input_blocker_script_handle());
	}
}

function zo_register_game_assets() {
	$modules = zo_get_game_modules();

	foreach ($modules as $module) {
		$style_file    = $module['dir'] . 'style.css';
		$script_file   = $module['dir'] . 'script.js';
		$style_handle  = zo_get_style_handle($module['slug']);
		$script_handle = zo_get_script_handle($module['slug']);

		if (file_exists($style_file)) {
			wp_register_style(
				$style_handle,
				$module['url'] . 'style.css',
				array(),
				(string) filemtime($style_file)
			);
		} elseif ($module['inline_style'] !== '') {
			wp_register_style(
				$style_handle,
				false,
				array(),
				md5($module['inline_style'])
			);
		}

		if (file_exists($script_file)) {
			wp_register_script(
				$script_handle,
				$module['url'] . 'script.js',
				array(),
				(string) filemtime($script_file),
				true
			);
		} elseif ($module['inline_script'] !== '') {
			wp_register_script(
				$script_handle,
				false,
				array(),
				md5($module['inline_script']),
				true
			);
		}
	}
}
add_action('wp_enqueue_scripts', 'zo_register_game_assets', 5);

function zo_enqueue_game_assets_by_slug($slug) {
	$slug = sanitize_title($slug);
	$module = zo_get_game_module($slug);
	static $inline_style_added = array();
	static $inline_script_added = array();

	if (!$slug || !$module) {
		return;
	}

	zo_enqueue_input_blocker_assets();

	$style_handle  = zo_get_style_handle($slug);
	$script_handle = zo_get_script_handle($slug);

	if (wp_style_is($style_handle, 'registered')) {
		if ($module['inline_style'] !== '' && empty($inline_style_added[$style_handle])) {
			wp_add_inline_style($style_handle, $module['inline_style']);
			$inline_style_added[$style_handle] = true;
		}

		wp_enqueue_style($style_handle);
	}

	if (wp_script_is($script_handle, 'registered')) {
		if ($module['inline_script'] !== '' && empty($inline_script_added[$script_handle])) {
			wp_add_inline_script($script_handle, $module['inline_script']);
			$inline_script_added[$script_handle] = true;
		}

		wp_enqueue_script($script_handle);
	}
}

function zo_extract_shortcode_game_slugs($content) {
	$slugs = array();

	if (!is_string($content) || $content === '') {
		return $slugs;
	}

	if (preg_match_all('/\[zeka_oyunu\b[^\]]*slug=(["\'])([^"\']+)\1[^\]]*\]/i', $content, $matches)) {
		if (!empty($matches[2])) {
			foreach ($matches[2] as $slug) {
				$slug = sanitize_title($slug);

				if ($slug) {
					$slugs[] = $slug;
				}
			}
		}
	}

	return array_values(array_unique($slugs));
}

function zo_maybe_enqueue_current_game_assets() {
	if (is_admin()) {
		return;
	}

	$requested_slug = zo_get_requested_game_slug();

	if ($requested_slug !== '') {
		wp_enqueue_script('jquery');
		zo_enqueue_game_assets_by_slug($requested_slug);
	}

	if (is_singular()) {
		$post = get_queried_object();

		if ($post instanceof WP_Post) {
			$shortcode_slugs = zo_extract_shortcode_game_slugs($post->post_content);

			foreach ($shortcode_slugs as $slug) {
				zo_enqueue_game_assets_by_slug($slug);
			}
		}
	}
}
add_action('wp_enqueue_scripts', 'zo_maybe_enqueue_current_game_assets', 20);

function zo_render_game($slug, $post_id = 0) {
	$language = zo_get_current_language();

	if (!zo_is_game_available_for_language($slug, $language)) {
		return '';
	}

	$module = zo_get_game_module($slug);

	if (!$module) {
		return '<div class="zo-game-shell"><p>Oyun bulunamadı.</p></div>';
	}

	zo_enqueue_game_assets_by_slug($slug);

	$html = '';

	if (!empty($module['render_callback']) && is_callable($module['render_callback'])) {
		$localized_module = $module;
		$localized_metadata = zo_get_localized_game_display_metadata($module, $language);

		if (!empty($localized_metadata['name'])) {
			$localized_module['name'] = $localized_metadata['name'];
		}

		if (!empty($localized_metadata['description'])) {
			$localized_module['description'] = $localized_metadata['description'];
		}

		$result = call_user_func($localized_module['render_callback'], (int) $post_id, $localized_module);

		if (is_string($result)) {
			$html = $result;
		}
	}

	if (trim($html) === '') {
		$html = '<p>Bu oyun henüz görüntülenemiyor.</p>';
	}

	return zo_wrap_game_runtime_translator($html, $module, $language);
}

function zo_get_game_posts_by_slug() {
	$posts_by_slug = array();
	$query         = new WP_Query(
		array(
			'post_type'              => 'zeka_oyunu',
			'post_status'            => 'publish',
			'posts_per_page'         => -1,
			'orderby'                => 'date',
			'order'                  => 'DESC',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);

	if (!$query->have_posts()) {
		return $posts_by_slug;
	}

	while ($query->have_posts()) {
		$query->the_post();

		$post_id = get_the_ID();
		$slug    = zo_resolve_game_slug_for_post($post_id);

		if ($slug === '' || isset($posts_by_slug[$slug])) {
			continue;
		}

		$posts_by_slug[$slug] = get_post($post_id);
	}

	wp_reset_postdata();

	return $posts_by_slug;
}

function zo_enqueue_grid_styles() {
	static $done = false;

	if ($done) {
		return;
	}

	$handle = 'zo-shared-styles';
	$css    = zo_get_shortcode_logo_css() . '
.zo-games-grid-wrap {
	width: min(100%, 1120px);
	margin: 0 auto;
}
.zo-games-grid__toolbar {
	display: flex;
	flex-wrap: wrap;
	gap: 12px;
	justify-content: flex-start;
	align-items: center;
	margin: 0 0 20px;
}
.zo-games-grid__filters {
	display: grid;
	width: 100%;
	grid-template-columns: minmax(180px, 1fr) minmax(150px, 210px) minmax(150px, 210px) auto auto;
	gap: 10px;
	align-items: end;
	margin: 0 0 18px;
}
.zo-games-grid__field {
	display: flex;
	flex-direction: column;
	gap: 6px;
	min-width: 0;
}
.zo-games-grid__field label {
	color: #374151;
	font-size: 0.86rem;
	font-weight: 700;
}
.zo-games-grid__field input,
.zo-games-grid__field select {
	width: 100%;
	min-height: 42px;
	border: 1px solid #cbd5e1;
	border-radius: 10px;
	background: #fff;
	color: #111827;
	font: inherit;
	padding: 0 12px;
}
.zo-games-grid__filter-button,
.zo-games-grid__reset {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	min-height: 42px;
	padding: 0 16px;
	border-radius: 10px;
	border: 1px solid #0f766e;
	background: #0f766e;
	color: #fff;
	font-weight: 700;
	text-decoration: none;
	cursor: pointer;
}
.zo-games-grid__reset {
	border-color: #cbd5e1;
	background: #fff;
	color: #374151;
}
.zo-games-grid__filter-button:hover,
.zo-games-grid__filter-button:focus {
	background: #115e59;
	color: #fff;
	text-decoration: none;
}
.zo-games-grid__reset:hover,
.zo-games-grid__reset:focus {
	border-color: #94a3b8;
	color: #111827;
	text-decoration: none;
}
.zo-games-grid__count {
	margin: -4px 0 16px;
	color: #4b5563;
	font-weight: 700;
}
.zo-games-grid__language {
	display: inline-flex;
	align-items: center;
	gap: 8px;
}
.zo-games-grid__language-label {
	color: #374151;
	font-weight: 700;
}
.zo-games-grid__language-option {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	min-height: 36px;
	min-width: 44px;
	padding: 0 12px;
	border-radius: 999px;
	border: 1px solid #cbd5e1;
	background: #ffffff;
	color: #1f2937;
	font-weight: 700;
	text-decoration: none;
}
.zo-games-grid__language-option.is-active {
	border-color: #1d4ed8;
	background: #1d4ed8;
	color: #ffffff;
}
.zo-games-grid__language-option:hover,
.zo-games-grid__language-option:focus {
	border-color: #1e40af;
	text-decoration: none;
}
.zo-games-grid__intro {
	margin: 0 0 20px;
	color: #374151;
	font-size: 1.05rem;
	line-height: 1.6;
}
.zo-games-grid__intro strong {
	color: #111827;
	font-weight: 700;
}
.zo-games-grid__home {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	max-width: 100%;
	min-height: 42px;
	padding: 0 16px;
	border-radius: 999px;
	background: #1d4ed8;
	color: #fff;
	font-weight: 600;
	line-height: 1.25;
	text-decoration: none;
	text-align: center;
}
.zo-games-grid__home:hover,
.zo-games-grid__home:focus {
	background: #1e40af;
	color: #fff;
	text-decoration: none;
}
.zo-games-grid {
	display: grid;
	width: min(100%, 1120px);
	margin: 0 auto;
	grid-template-columns: repeat(auto-fit, minmax(min(100%, 280px), 320px));
	justify-content: center;
	gap: 24px;
}
.zo-games-grid__card {
	position: relative;
	display: flex;
	flex-direction: column;
	height: 100%;
	border: 1px solid rgba(0, 0, 0, 0.08);
	border-radius: 18px;
	overflow: hidden;
	background: #fff;
	box-shadow: 0 12px 30px rgba(0, 0, 0, 0.06);
}
.zo-games-grid__thumb {
	display: block;
	position: relative;
	aspect-ratio: 16 / 10;
	background: #f3f4f6;
	color: #ffffff;
	text-decoration: none;
	overflow: hidden;
}
.zo-games-grid__thumb img {
	display: block;
	width: 100%;
	height: 100%;
	object-fit: cover;
}
.zo-games-grid__thumb-fallback {
	position: relative;
	display: grid;
	width: 100%;
	height: 100%;
	min-height: 100%;
	place-items: center;
	isolation: isolate;
	background:
		radial-gradient(circle at 18% 20%, rgba(255, 255, 255, 0.32), transparent 24%),
		linear-gradient(135deg, var(--zo-thumb-from), var(--zo-thumb-to));
}
.zo-games-grid__thumb-pattern {
	position: absolute;
	inset: 0;
	z-index: -1;
	opacity: 0.28;
	background-image:
		linear-gradient(45deg, rgba(255, 255, 255, 0.36) 25%, transparent 25%),
		linear-gradient(-45deg, rgba(255, 255, 255, 0.24) 25%, transparent 25%);
	background-position: 0 0, 20px 20px;
	background-size: 40px 40px;
}
.zo-games-grid__thumb-label {
	position: absolute;
	top: 14px;
	left: 14px;
	padding: 6px 10px;
	border: 1px solid rgba(255, 255, 255, 0.28);
	border-radius: 999px;
	background: rgba(15, 23, 42, 0.22);
	color: var(--zo-thumb-accent);
	font-size: 0.78rem;
	font-weight: 800;
	line-height: 1;
	text-transform: uppercase;
}
.zo-games-grid__thumb-initials {
	display: inline-grid;
	width: 86px;
	height: 86px;
	place-items: center;
	border: 2px solid rgba(255, 255, 255, 0.34);
	border-radius: 22px;
	background: rgba(255, 255, 255, 0.18);
	box-shadow: 0 18px 40px rgba(15, 23, 42, 0.18);
	color: #ffffff;
	font-size: 2.15rem;
	font-weight: 900;
	line-height: 1;
	text-shadow: 0 2px 18px rgba(15, 23, 42, 0.28);
}
.zo-games-grid__body {
	display: flex;
	flex: 1 1 auto;
	flex-direction: column;
	gap: 10px;
	padding: 18px;
}
.zo-games-grid__author {
	margin: 0;
	font-size: 0.85rem;
	font-weight: 600;
	letter-spacing: 0.04em;
	text-transform: uppercase;
	color: #b45309;
}
.zo-games-grid__title {
	margin: 0;
	font-size: 1.15rem;
	line-height: 1.3;
}
.zo-games-grid__title a {
	color: inherit;
	text-decoration: none;
}
.zo-games-grid__title a:hover,
.zo-games-grid__title a:focus {
	text-decoration: underline;
}
.zo-games-grid__excerpt {
	margin: 0;
	color: #374151;
}
.zo-games-grid__module {
	font-size: 0.9rem;
	color: #6b7280;
}
.zo-games-grid__actions {
	margin-top: auto;
	padding-top: 6px;
}
.zo-games-grid__button {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	min-height: 42px;
	padding: 0 16px;
	border-radius: 999px;
	background: #0f766e;
	color: #fff;
	font-weight: 600;
	text-decoration: none;
}
.zo-games-grid__button:hover,
.zo-games-grid__button:focus {
	background: #115e59;
	color: #fff;
	text-decoration: none;
}
.zo-games-grid__empty {
	margin: 0;
	padding: 16px 18px;
	border-radius: 14px;
	background: #f9fafb;
	color: #374151;
}
.zo-games-grid__footer {
	display: flex;
	justify-content: center;
	margin: 28px 0 0;
}
.zo-games-grid__about {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	min-height: 46px;
	max-width: 100%;
	padding: 0 18px;
	border-radius: 999px;
	background: #1d4ed8;
	color: #fff;
	font-weight: 700;
	line-height: 1.25;
	text-align: center;
	text-decoration: none;
}
.zo-games-grid__about:hover,
.zo-games-grid__about:focus {
	background: #1e40af;
	color: #fff;
	text-decoration: none;
}
.zo-games-grid:empty {
	display: none;
}
@media (max-width: 820px) {
	.zo-games-grid__filters {
		grid-template-columns: 1fr;
	}
}
';

	if (!wp_style_is($handle, 'registered')) {
		wp_register_style($handle, false, array(), ZO_PLUGIN_VERSION);
	}

	wp_enqueue_style($handle);
	wp_enqueue_script('jquery');
	wp_add_inline_style($handle, $css);

	$done = true;
}

function zo_enqueue_asker_about_styles() {
	static $done = false;

	if ($done) {
		return;
	}

	$handle = 'zo-shared-styles';
	$css = zo_get_shortcode_logo_css() . '
.zo-asker-about,
.zo-site-about {
	scroll-margin-top: 96px;
	width: min(100%, 880px);
	margin: 0 auto;
	color: #1f2937;
	font-family: Arial, sans-serif;
	font-size: 1.08rem;
	line-height: 1.7;
}
.zo-asker-about-list,
.zo-site-about-list {
	display: grid;
	gap: 34px;
	width: min(100%, 920px);
	margin: 0 auto;
}
.zo-asker-about__language,
.zo-site-about__language {
	position: sticky;
	top: 0;
	z-index: 10;
	display: flex;
	flex-wrap: wrap;
	align-items: center;
	gap: 8px;
	width: min(100%, 920px);
	margin: 0 auto 24px;
	padding: 10px 0;
	background: #fff;
}
.zo-asker-about__language-label,
.zo-site-about__language-label {
	color: #374151;
	font-weight: 700;
}
.zo-asker-about__language-option,
.zo-site-about__language-option {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	min-height: 36px;
	min-width: 44px;
	padding: 0 12px;
	border: 1px solid #cbd5e1;
	border-radius: 999px;
	background: #fff;
	color: #1f2937;
	font-weight: 700;
	text-decoration: none;
}
.zo-asker-about__language-option.is-active,
.zo-site-about__language-option.is-active {
	border-color: #1d4ed8;
	background: #1d4ed8;
	color: #fff;
}
.zo-asker-about__language-option:hover,
.zo-asker-about__language-option:focus,
.zo-site-about__language-option:hover,
.zo-site-about__language-option:focus {
	border-color: #1e40af;
	text-decoration: none;
}
.zo-asker-about-list .zo-asker-about,
.zo-site-about-list .zo-site-about {
	padding-bottom: 30px;
	border-bottom: 1px solid #e5e7eb;
}
.zo-asker-about-list .zo-asker-about:last-child,
.zo-site-about-list .zo-site-about:last-child {
	border-bottom: 0;
	padding-bottom: 0;
}
.zo-asker-about__lang,
.zo-site-about__lang {
	margin: 0 0 8px;
	color: #0f766e;
	font-size: 0.88rem;
	font-weight: 800;
	letter-spacing: 0.08em;
	text-transform: uppercase;
}
.zo-asker-about h2,
.zo-site-about h2 {
	margin: 0 0 14px;
	color: #111827;
	font-size: clamp(30px, 5vw, 48px);
	line-height: 1.1;
}
.zo-asker-about p,
.zo-site-about p {
	margin: 0 0 16px;
}
.zo-asker-about__intro,
.zo-site-about__intro {
	color: #374151;
	font-size: 1.18rem;
	font-weight: 700;
}
.zo-asker-about__button,
.zo-site-about__button {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	min-height: 44px;
	padding: 0 18px;
	border-radius: 999px;
	background: #0f766e;
	color: #fff;
	font-weight: 700;
	text-decoration: none;
}
.zo-asker-about__button:hover,
.zo-asker-about__button:focus,
.zo-site-about__button:hover,
.zo-site-about__button:focus {
	background: #115e59;
	color: #fff;
	text-decoration: none;
}
.zo-asker-about__actions,
.zo-site-about__actions {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	justify-content: center;
	margin-top: 8px;
}
';

	if (!wp_style_is($handle, 'registered')) {
		wp_register_style($handle, false, array(), ZO_PLUGIN_VERSION);
	}

	wp_enqueue_style($handle);
	wp_add_inline_style($handle, $css);

	$done = true;
}

function zo_game_shortcode($atts = array()) {
	$atts = shortcode_atts(
		array(
			'slug' => '',
		),
		$atts,
		'zeka_oyunu'
	);

	$slug = sanitize_title($atts['slug']);

	if (!$slug) {
		return '';
	}

	return zo_render_game($slug);
}
add_shortcode('zeka_oyunu', 'zo_game_shortcode');

function zo_get_asker_about_content($lang = '') {
	$content = array(
		'tr' => array(
			'title' => 'Askerin Oyunları Hakkında',
			'intro' => 'Askerin Oyunları, Asker tarafından yapay zeka yardımıyla yapılmış tarayıcı oyunlarından oluşur.',
			'body' => 'Asker fikirlerini oyuna dönüştürmek için yapay zekadan yardım alır; oyunlar da zeka, hafıza, dikkat, refleks ve problem çözme becerilerini çalıştırır. Bazı oyunlar bulmaca gibidir, bazıları hızlı tepki ister, bazıları da hatırlama ve sıralama becerilerini geliştirir.',
			'note' => 'Oyunlar ücretsizdir ve bilgisayar, tablet veya telefon tarayıcısında oynanabilir. Yeni oyunlar eklendikçe liste büyümeye devam eder.',
		),
		'en' => array(
			'title' => 'About Asker’s Games',
			'intro' => 'Asker’s Games were made by Asker with help from AI.',
			'body' => 'Asker uses AI to turn his ideas into browser games that practice thinking, memory, attention, reflexes, and problem solving. Some games feel like puzzles, some need quick reactions, and others train memory and sequencing.',
			'note' => 'The games are free and can be played in a browser on a computer, tablet, or phone. The list will keep growing as new games are added.',
		),
		'de' => array(
			'title' => 'Über Askers Spiele',
			'intro' => 'Askers Spiele wurden von Asker mit Hilfe von KI gemacht.',
			'body' => 'Asker nutzt KI, um seine Ideen in Browserspiele zu verwandeln, die Denken, Gedächtnis, Aufmerksamkeit, Reflexe und Problemlösung üben. Manche Spiele sind Rätsel, manche brauchen schnelle Reaktionen, andere trainieren Gedächtnis und Reihenfolgen.',
			'note' => 'Die Spiele sind kostenlos und können im Browser auf Computer, Tablet oder Handy gespielt werden. Die Liste wächst weiter, wenn neue Spiele dazukommen.',
		),
		'fr' => array(
			'title' => 'À propos des jeux d’Asker',
			'intro' => 'Les jeux d’Asker ont été créés par Asker avec l’aide de l’IA.',
			'body' => 'Asker utilise l’IA pour transformer ses idées en jeux de navigateur qui entraînent la réflexion, la mémoire, l’attention, les réflexes et la résolution de problèmes. Certains jeux ressemblent à des puzzles, certains demandent des réflexes rapides, et d’autres entraînent la mémoire et les suites logiques.',
			'note' => 'Les jeux sont gratuits et peuvent être joués dans un navigateur sur ordinateur, tablette ou téléphone. La liste continuera de grandir quand de nouveaux jeux seront ajoutés.',
		),
	);

	$content['es-mx'] = array(
		'title' => 'Acerca de los juegos de Asker',
		'intro' => 'Los juegos de Asker fueron creados por Asker con ayuda de IA.',
		'body' => 'Asker usa IA para convertir sus ideas en juegos de navegador que practican pensamiento, memoria, atención, reflejos y resolución de problemas. Algunos juegos son como rompecabezas, otros necesitan reacciones rápidas y otros entrenan memoria y secuencias.',
		'note' => 'Los juegos son gratis y se pueden jugar en el navegador desde una computadora, tableta o teléfono. La lista seguirá creciendo cuando se agreguen nuevos juegos.',
	);
	$content['es-es'] = array(
		'title' => 'Acerca de los juegos de Asker',
		'intro' => 'Los juegos de Asker fueron creados por Asker con ayuda de IA.',
		'body' => 'Asker usa IA para convertir sus ideas en juegos de navegador que practican pensamiento, memoria, atención, reflejos y resolución de problemas. Algunos juegos son como puzles, otros necesitan reacciones rápidas y otros entrenan memoria y secuencias.',
		'note' => 'Los juegos son gratuitos y se pueden jugar en el navegador desde un ordenador, una tableta o un teléfono. La lista seguirá creciendo cuando se añadan nuevos juegos.',
	);

	$content['es-mx'] = array(
		'title' => 'Acerca de zekâ.com',
		'intro' => 'zekâ.com es un sitio gratis de juegos de navegador para niños, estudiantes y jugadores curiosos de todas las edades.',
		'body' => 'El sitio incluye juegos de lógica, memoria, atención, reflejos, matemáticas, rompecabezas, deportes y creatividad. Los juegos abren rápido, funcionan en el navegador y ayudan a pensar mientras juegas.',
		'note' => 'El sitio crece con ideas de jóvenes creadores como Asker y Arslan. Algunos juegos se hacen con ayuda de IA y luego se comparten en el sitio.',
	);
	$content['es-es'] = array(
		'title' => 'Acerca de zekâ.com',
		'intro' => 'zekâ.com es un sitio gratuito de juegos de navegador para niños, estudiantes y jugadores curiosos de todas las edades.',
		'body' => 'El sitio incluye juegos de lógica, memoria, atención, reflejos, matemáticas, puzles, deportes y creatividad. Los juegos se abren rápido, funcionan en el navegador y ayudan a pensar mientras juegas.',
		'note' => 'El sitio crece con ideas de jóvenes creadores como Asker y Arslan. Algunos juegos se hacen con ayuda de IA y luego se comparten en el sitio.',
	);

	$content['es-mx'] = array(
		'title' => 'Acerca de los juegos de Asker',
		'intro' => 'Los juegos de Asker fueron creados por Asker con ayuda de IA.',
		'body' => 'Asker usa IA para convertir sus ideas en juegos de navegador que practican pensamiento, memoria, atención, reflejos y resolución de problemas. Algunos juegos son como rompecabezas, otros necesitan reacciones rápidas y otros entrenan memoria y secuencias.',
		'note' => 'Los juegos son gratis y se pueden jugar en el navegador desde una computadora, tableta o teléfono. La lista seguirá creciendo cuando se agreguen nuevos juegos.',
	);
	$content['es-es'] = array(
		'title' => 'Acerca de los juegos de Asker',
		'intro' => 'Los juegos de Asker fueron creados por Asker con ayuda de IA.',
		'body' => 'Asker usa IA para convertir sus ideas en juegos de navegador que practican pensamiento, memoria, atención, reflejos y resolución de problemas. Algunos juegos son como puzles, otros necesitan reacciones rápidas y otros entrenan memoria y secuencias.',
		'note' => 'Los juegos son gratuitos y se pueden jugar en el navegador desde un ordenador, una tableta o un teléfono. La lista seguirá creciendo cuando se añadan nuevos juegos.',
	);

	$content['es-mx'] = array(
		'title' => 'Acerca de zekâ.com',
		'intro' => 'zekâ.com es un sitio gratis de juegos de navegador para niños, estudiantes y jugadores curiosos de todas las edades.',
		'body' => 'El sitio incluye juegos de lógica, memoria, atención, reflejos, matemáticas, rompecabezas, deportes y creatividad. Los juegos abren rápido, funcionan en el navegador y ayudan a pensar mientras juegas.',
		'note' => 'El sitio crece con ideas de jóvenes creadores como Asker y Arslan. Algunos juegos se hacen con ayuda de IA y luego se comparten en el sitio.',
	);
	$content['es-es'] = array(
		'title' => 'Acerca de zekâ.com',
		'intro' => 'zekâ.com es un sitio gratuito de juegos de navegador para niños, estudiantes y jugadores curiosos de todas las edades.',
		'body' => 'El sitio incluye juegos de lógica, memoria, atención, reflejos, matemáticas, puzles, deportes y creatividad. Los juegos se abren rápido, funcionan en el navegador y ayudan a pensar mientras juegas.',
		'note' => 'El sitio crece con ideas de jóvenes creadores como Asker y Arslan. Algunos juegos se hacen con ayuda de IA y luego se comparten en el sitio.',
	);

	if ($lang === 'all') {
		return $content;
	}

	$lang = array_key_exists($lang, zo_get_language_options()) ? $lang : zo_get_current_language();

	return $content[$lang] ?? $content['tr'];
}

function zo_asker_about_shortcode($atts = array()) {
	$atts = shortcode_atts(
		array(
			'lang' => '',
		),
		$atts,
		'asker_oyunlari_hakkinda'
	);

	$lang = sanitize_key((string) $atts['lang']);
	$show_all = $lang === '' || $lang === 'all';
	$current_lang = $show_all ? zo_get_current_language() : $lang;
	$languages = $show_all ? array_keys(zo_get_language_options()) : array($lang);
	$all_content = zo_get_asker_about_content('all');
	$all_content['es-mx'] = array(
		'title' => 'Acerca de los juegos de Asker',
		'intro' => 'Los juegos de Asker fueron creados por Asker con ayuda de IA.',
		'body' => 'Asker usa IA para convertir sus ideas en juegos de navegador que practican pensamiento, memoria, atención, reflejos y resolución de problemas. Algunos juegos son como rompecabezas, otros necesitan reacciones rápidas y otros entrenan memoria y secuencias.',
		'note' => 'Los juegos son gratis y se pueden jugar en el navegador desde una computadora, tableta o teléfono. La lista seguirá creciendo cuando se agreguen nuevos juegos.',
	);
	$all_content['es-es'] = array(
		'title' => 'Acerca de los juegos de Asker',
		'intro' => 'Los juegos de Asker fueron creados por Asker con ayuda de IA.',
		'body' => 'Asker usa IA para convertir sus ideas en juegos de navegador que practican pensamiento, memoria, atención, reflejos y resolución de problemas. Algunos juegos son como puzles, otros necesitan reacciones rápidas y otros entrenan memoria y secuencias.',
		'note' => 'Los juegos son gratuitos y se pueden jugar en el navegador desde un ordenador, una tableta o un teléfono. La lista seguirá creciendo cuando se añadan nuevos juegos.',
	);

	zo_enqueue_asker_about_styles();

	ob_start();

	echo '<div class="zo-shortcode-frame zo-shortcode-frame--asker-about">';
	echo zo_get_shortcode_logo_html('asker-about');

	echo '<nav class="zo-asker-about__language" aria-label="' . esc_attr(zo_get_interface_text('language_label', $current_lang)) . '">';
	echo '<span class="zo-asker-about__language-label">' . esc_html(zo_get_interface_text('language_label', $current_lang)) . '</span>';

	foreach (zo_get_language_options() as $code => $label) {
		$class = 'zo-asker-about__language-option';
		$url = '#zo-asker-about-' . $code;
		echo '<a class="' . esc_attr($class) . '" href="' . esc_url($url) . '">' . esc_html($label) . '</a>';
	}

	echo '</nav>';

	echo '<div class="zo-asker-about-list">';
	foreach ($languages as $code) {
		if (!array_key_exists($code, zo_get_language_options()) || empty($all_content[$code])) {
			continue;
		}

		$content = $all_content[$code];
		$games_url = zo_get_owner_games_url('asker', $code);
		$home_url = add_query_arg('zo_lang', $code, home_url('/'));

		echo '<section class="zo-asker-about" id="zo-asker-about-' . esc_attr($code) . '" lang="' . esc_attr($code) . '">';
		echo '<p class="zo-asker-about__lang">' . esc_html(zo_get_language_options()[$code]) . '</p>';
		echo '<h2>' . esc_html($content['title']) . '</h2>';
		echo '<p class="zo-asker-about__intro">' . esc_html($content['intro']) . '</p>';
		echo '<p>' . esc_html($content['body']) . '</p>';
		echo '<p>' . esc_html($content['note']) . '</p>';
		echo '<div class="zo-asker-about__actions">';
		if ($games_url !== '') {
			echo '<a class="zo-asker-about__button" href="' . esc_url($games_url) . '">' . esc_html(zo_get_interface_text('asker_games_link', $code)) . '</a>';
		}
		echo '<a class="zo-asker-about__button" href="' . esc_url($home_url) . '">' . esc_html(zo_get_interface_text('home', $code)) . '</a>';
		echo '</div>';
		echo '</section>';
	}
	echo '</div>';
	echo '</div>';

	return ob_get_clean();
}
add_shortcode('asker_oyunlari_hakkinda', 'zo_asker_about_shortcode');

function zo_get_site_about_content($lang = '') {
	$content = array(
		'tr' => array(
			'title' => 'zekâ.com Hakkında',
			'intro' => 'zekâ.com; çocuklar, öğrenciler ve her yaştan meraklı insan için ücretsiz tarayıcı oyunları bulunan bir zeka oyunları sitesidir.',
			'body' => 'Sitede mantık, hafıza, dikkat, refleks, matematik, bulmaca, spor ve yaratıcı oyunlar bulunur. Oyunlar kısa sürede açılır, tarayıcıda oynanır ve farklı yaşlardaki kullanıcıların eğlenirken düşünmesine yardımcı olmayı amaçlar.',
			'note' => 'Oyunlar Asker ve Arslan gibi genç üreticilerin fikirleriyle büyür. Bazı oyunlar yapay zeka yardımıyla hazırlanır, sonra sitede paylaşılır.',
		),
		'en' => array(
			'title' => 'About zekâ.com',
			'intro' => 'zekâ.com is a free browser-game site for kids, students, and curious players of all ages.',
			'body' => 'The site includes logic, memory, attention, reflex, math, puzzle, sports, and creative games. The games open quickly, run in the browser, and are meant to help people think while they play.',
			'note' => 'The site grows with ideas from young makers like Asker and Arslan. Some games are made with help from AI and then shared on the site.',
		),
		'de' => array(
			'title' => 'Über zekâ.com',
			'intro' => 'zekâ.com ist eine kostenlose Browserspiel-Seite für Kinder, Schüler und neugierige Spieler jeden Alters.',
			'body' => 'Die Seite enthält Logik-, Gedächtnis-, Aufmerksamkeits-, Reaktions-, Mathe-, Rätsel-, Sport- und Kreativspiele. Die Spiele starten schnell, laufen im Browser und sollen beim Spielen zum Denken anregen.',
			'note' => 'Die Seite wächst durch Ideen von jungen Machern wie Asker und Arslan. Einige Spiele werden mit Hilfe von KI erstellt und dann auf der Seite geteilt.',
		),
		'fr' => array(
			'title' => 'À propos de zekâ.com',
			'intro' => 'zekâ.com est un site gratuit de jeux de navigateur pour les enfants, les élèves et les joueurs curieux de tout âge.',
			'body' => 'Le site propose des jeux de logique, de mémoire, d’attention, de réflexes, de maths, de puzzle, de sport et de créativité. Les jeux se lancent vite, fonctionnent dans le navigateur et aident à réfléchir en jouant.',
			'note' => 'Le site grandit grâce aux idées de jeunes créateurs comme Asker et Arslan. Certains jeux sont créés avec l’aide de l’IA puis partagés sur le site.',
		),
	);

	if ($lang === 'all') {
		return $content;
	}

	$lang = array_key_exists($lang, zo_get_language_options()) ? $lang : zo_get_current_language();

	return $content[$lang] ?? $content['tr'];
}

function zo_site_about_shortcode($atts = array()) {
	$atts = shortcode_atts(
		array(
			'lang' => '',
		),
		$atts,
		'zeka_hakkinda'
	);

	$lang = sanitize_key((string) $atts['lang']);
	$show_all = $lang === '' || $lang === 'all';
	$current_lang = $show_all ? zo_get_current_language() : $lang;
	$languages = $show_all ? array_keys(zo_get_language_options()) : array($lang);
	$all_content = zo_get_site_about_content('all');
	$all_content['es-mx'] = array(
		'title' => 'Acerca de zekâ.com',
		'intro' => 'zekâ.com es un sitio gratis de juegos de navegador para niños, estudiantes y jugadores curiosos de todas las edades.',
		'body' => 'El sitio incluye juegos de lógica, memoria, atención, reflejos, matemáticas, rompecabezas, deportes y creatividad. Los juegos abren rápido, funcionan en el navegador y ayudan a pensar mientras juegas.',
		'note' => 'El sitio crece con ideas de jóvenes creadores como Asker y Arslan. Algunos juegos se hacen con ayuda de IA y luego se comparten en el sitio.',
	);
	$all_content['es-es'] = array(
		'title' => 'Acerca de zekâ.com',
		'intro' => 'zekâ.com es un sitio gratuito de juegos de navegador para niños, estudiantes y jugadores curiosos de todas las edades.',
		'body' => 'El sitio incluye juegos de lógica, memoria, atención, reflejos, matemáticas, puzles, deportes y creatividad. Los juegos se abren rápido, funcionan en el navegador y ayudan a pensar mientras juegas.',
		'note' => 'El sitio crece con ideas de jóvenes creadores como Asker y Arslan. Algunos juegos se hacen con ayuda de IA y luego se comparten en el sitio.',
	);

	zo_enqueue_asker_about_styles();

	ob_start();

	echo '<div class="zo-shortcode-frame zo-shortcode-frame--site-about">';
	echo zo_get_shortcode_logo_html('site-about');

	echo '<nav class="zo-site-about__language" aria-label="' . esc_attr(zo_get_interface_text('language_label', $current_lang)) . '">';
	echo '<span class="zo-site-about__language-label">' . esc_html(zo_get_interface_text('language_label', $current_lang)) . '</span>';

	foreach (zo_get_language_options() as $code => $label) {
		echo '<a class="zo-site-about__language-option" href="' . esc_url('#zo-site-about-' . $code) . '">' . esc_html($label) . '</a>';
	}

	echo '</nav>';
	echo '<div class="zo-site-about-list">';

	foreach ($languages as $code) {
		if (!array_key_exists($code, zo_get_language_options()) || empty($all_content[$code])) {
			continue;
		}

		$content = $all_content[$code];
		$asker_url = zo_get_owner_games_url('asker', $code);
		$arslan_url = zo_get_owner_games_url('arslan', $code);
		$home_url = add_query_arg('zo_lang', $code, home_url('/'));

		echo '<section class="zo-site-about" id="zo-site-about-' . esc_attr($code) . '" lang="' . esc_attr($code) . '">';
		echo '<p class="zo-site-about__lang">' . esc_html(zo_get_language_options()[$code]) . '</p>';
		echo '<h2>' . esc_html($content['title']) . '</h2>';
		echo '<p class="zo-site-about__intro">' . esc_html($content['intro']) . '</p>';
		echo '<p>' . esc_html($content['body']) . '</p>';
		echo '<p>' . esc_html($content['note']) . '</p>';
		echo '<div class="zo-site-about__actions">';
		echo '<a class="zo-site-about__button" href="' . esc_url($asker_url) . '">' . esc_html(zo_get_interface_text('asker_games_title', $code)) . '</a>';
		echo '<a class="zo-site-about__button" href="' . esc_url($arslan_url) . '">' . esc_html(zo_get_interface_text('arslan_games_title', $code)) . '</a>';
		echo '<a class="zo-site-about__button" href="' . esc_url($home_url) . '">' . esc_html(zo_get_interface_text('home', $code)) . '</a>';
		echo '</div>';
		echo '</section>';
	}

	echo '</div>';
	echo '</div>';

	return ob_get_clean();
}
add_shortcode('zeka_hakkinda', 'zo_site_about_shortcode');
add_shortcode('zeka_com_hakkinda', 'zo_site_about_shortcode');

function zo_games_grid_shortcode($atts = array()) {
	$atts = shortcode_atts(
		array(
			'author' => '',
			'limit'  => '-1',
		),
		$atts,
		'zeka_oyunlari_grid'
	);

	$author_filter    = sanitize_title($atts['author']);
	$limit            = (int) $atts['limit'];
	$modules          = zo_get_game_modules();
	$language         = zo_get_current_language();
	$show_home_button = false;
	$search_query     = isset($_GET['zo_game_search']) && is_string($_GET['zo_game_search']) ? sanitize_text_field(wp_unslash($_GET['zo_game_search'])) : '';
	$category_filter  = isset($_GET['zo_game_category']) && is_string($_GET['zo_game_category']) ? sanitize_key(wp_unslash($_GET['zo_game_category'])) : 'all';
	$sort             = isset($_GET['zo_game_sort']) && is_string($_GET['zo_game_sort']) ? sanitize_key(wp_unslash($_GET['zo_game_sort'])) : 'title';
	$category_options = zo_get_game_category_options();
	$sort_options     = array('title', 'newest', 'category');

	if ($limit === 0) {
		return '';
	}

	if (!isset($category_options[$category_filter])) {
		$category_filter = 'all';
	}

	if (!in_array($sort, $sort_options, true)) {
		$sort = 'title';
	}

	if (empty($modules)) {
		return '<p class="zo-games-grid__empty">Henüz oyun bulunamadı.</p>';
	}

	zo_enqueue_grid_styles();

	$posts_by_slug = zo_get_game_posts_by_slug();
	$home_url      = home_url('/');

	if (!is_front_page() && !is_home() && is_string($home_url) && $home_url !== '') {
		$show_home_button = true;
	}

	ob_start();
	$has_results = false;
	$shown       = 0;

	echo '<div class="zo-games-grid-wrap zo-shortcode-frame zo-shortcode-frame--games-grid">';
	echo zo_get_shortcode_logo_html('games-grid');

	echo '<div class="zo-games-grid__toolbar">';

	if ($show_home_button) {
		echo '<a class="zo-games-grid__home" href="' . esc_url(add_query_arg('zo_lang', $language, $home_url)) . '">' . esc_html(zo_get_interface_text('home', $language)) . '</a>';
	}

	echo '<div class="zo-games-grid__language" aria-label="' . esc_attr(zo_get_interface_text('language_label', $language)) . '">';
	echo '<span class="zo-games-grid__language-label">' . esc_html(zo_get_interface_text('language_label', $language)) . '</span>';

	foreach (zo_get_language_options() as $code => $label) {
		$class = 'zo-games-grid__language-option' . ($code === $language ? ' is-active' : '');
		echo '<a class="' . esc_attr($class) . '" href="' . esc_url(add_query_arg('zo_lang', $code)) . '">' . esc_html($label) . '</a>';
	}

	echo '</div>';
	echo '</div>';

	$filter_action = remove_query_arg(array('zo_game_search', 'zo_game_category', 'zo_game_sort', 'zo_lang', 'paged'));
	echo '<form class="zo-games-grid__filters" method="get" action="' . esc_url($filter_action) . '">';
	echo '<input type="hidden" name="zo_lang" value="' . esc_attr($language) . '">';
	echo '<div class="zo-games-grid__field">';
	echo '<label for="zo-game-search">' . esc_html(zo_get_interface_text('search_label', $language)) . '</label>';
	echo '<input id="zo-game-search" type="search" name="zo_game_search" value="' . esc_attr($search_query) . '" placeholder="' . esc_attr(zo_get_interface_text('search_placeholder', $language)) . '">';
	echo '</div>';
	echo '<div class="zo-games-grid__field">';
	echo '<label for="zo-game-category">' . esc_html(zo_get_interface_text('category_label', $language)) . '</label>';
	echo '<select id="zo-game-category" name="zo_game_category">';
	foreach ($category_options as $category_key => $labels) {
		echo '<option value="' . esc_attr($category_key) . '"' . selected($category_filter, $category_key, false) . '>' . esc_html(zo_get_game_category_label($category_key, $language)) . '</option>';
	}
	echo '</select>';
	echo '</div>';
	echo '<div class="zo-games-grid__field">';
	echo '<label for="zo-game-sort">' . esc_html(zo_get_interface_text('sort_label', $language)) . '</label>';
	echo '<select id="zo-game-sort" name="zo_game_sort">';
	echo '<option value="title"' . selected($sort, 'title', false) . '>' . esc_html(zo_get_interface_text('sort_title', $language)) . '</option>';
	echo '<option value="newest"' . selected($sort, 'newest', false) . '>' . esc_html(zo_get_interface_text('sort_newest', $language)) . '</option>';
	echo '<option value="category"' . selected($sort, 'category', false) . '>' . esc_html(zo_get_interface_text('sort_category', $language)) . '</option>';
	echo '</select>';
	echo '</div>';
	echo '<button class="zo-games-grid__filter-button" type="submit">' . esc_html(zo_get_interface_text('filter_submit', $language)) . '</button>';
	echo '<a class="zo-games-grid__reset" href="' . esc_url(add_query_arg('zo_lang', $language, remove_query_arg(array('zo_game_search', 'zo_game_category', 'zo_game_sort', 'zo_lang', 'paged')))) . '">' . esc_html(zo_get_interface_text('filter_reset', $language)) . '</a>';
	echo '</form>';

	echo '<p class="zo-games-grid__intro">' . esc_html(zo_get_interface_text('intro', $language)) . '</p>';

	$game_items = array();

	foreach ($modules as $slug => $module) {
		if (!zo_is_game_available_for_language($slug, $language)) {
			continue;
		}

		$post         = $posts_by_slug[$slug] ?? null;
		$owner        = $post instanceof WP_Post ? zo_get_game_owner_for_post($post->ID) : '';
		$module_owner = zo_get_game_owner_for_module($module);

		if ($owner === '') {
			$owner = $module_owner;
		}

		if ($author_filter !== '' && $owner !== $author_filter) {
			continue;
		}

		$metadata = zo_get_game_display_metadata($module);
		$title    = !empty($metadata['name']) ? $metadata['name'] : ($post instanceof WP_Post ? get_the_title($post) : $module['name']);
		$excerpt  = !empty($metadata['description']) ? $metadata['description'] : ($post instanceof WP_Post ? get_the_excerpt($post) : '');
		$url      = $post instanceof WP_Post ? zo_get_game_launch_url($post) : zo_get_game_module_fallback_url($slug);
		$author   = zo_get_game_owner_label($owner);

		$title   = zo_get_localized_text($title, $language);
		$excerpt = zo_get_localized_text($excerpt, $language);
		$category = zo_get_game_category($slug, $title, $excerpt);

		if ($url !== '') {
			$url = add_query_arg('zo_lang', $language, $url);
		}

		if ($excerpt === '' && !empty($module['description']) && is_string($module['description'])) {
			$excerpt = zo_get_localized_text($module['description'], $language);
		}

		if ($category_filter !== 'all' && $category !== $category_filter) {
			continue;
		}

		if ($search_query !== '') {
			$haystack = strtolower($title . ' ' . $excerpt . ' ' . $slug . ' ' . $author . ' ' . zo_get_game_category_label($category, $language));
			$needle = strtolower($search_query);

			if (strpos($haystack, $needle) === false) {
				continue;
			}
		}

		$game_items[] = array(
			'slug' => $slug,
			'module' => $module,
			'post' => $post,
			'owner' => $owner,
			'author' => $author,
			'title' => $title,
			'excerpt' => $excerpt,
			'url' => $url,
			'category' => $category,
			'timestamp' => $post instanceof WP_Post ? strtotime((string) $post->post_date_gmt) : 0,
		);
	}

	usort(
		$game_items,
		function ($a, $b) use ($sort, $language) {
			if ($sort === 'newest') {
				$time_compare = (int) $b['timestamp'] <=> (int) $a['timestamp'];
				if ($time_compare !== 0) {
					return $time_compare;
				}
			}

			if ($sort === 'category') {
				$category_compare = strcmp(
					zo_get_game_category_label($a['category'], $language),
					zo_get_game_category_label($b['category'], $language)
				);

				if ($category_compare !== 0) {
					return $category_compare;
				}
			}

			return strcasecmp($a['title'], $b['title']);
		}
	);

	if ($limit > 0) {
		$game_items = array_slice($game_items, 0, $limit);
	}

	$shown = count($game_items);
	$has_results = $shown > 0;

	echo '<p class="zo-games-grid__count">' . esc_html(sprintf(zo_get_interface_text('results_count', $language), $shown)) . '</p>';
	echo '<div class="zo-games-grid">';

	foreach ($game_items as $item) {
		$slug = $item['slug'];
		$module = $item['module'];
		$post = $item['post'];
		$author = $item['author'];
		$title = $item['title'];
		$excerpt = $item['excerpt'];
		$url = $item['url'];

		echo '<article class="zo-games-grid__card">';

		zo_render_game_thumbnail($post, $module, $url, $title);

		echo '<div class="zo-games-grid__body">';

		if ($author === '' && !empty($module['author']) && is_string($module['author'])) {
			$author = $module['author'];
		}

		if ($author !== '') {
			echo '<p class="zo-games-grid__author">' . esc_html($author) . '</p>';
		}

		if ($url !== '') {
			echo '<h3 class="zo-games-grid__title"><a href="' . esc_url($url) . '">' . esc_html($title) . '</a></h3>';
		} else {
			echo '<h3 class="zo-games-grid__title">' . esc_html($title) . '</h3>';
		}

		if ($excerpt !== '') {
			echo '<p class="zo-games-grid__excerpt">' . esc_html($excerpt) . '</p>';
		}

		if ($url !== '') {
			echo '<div class="zo-games-grid__actions"><a class="zo-games-grid__button" href="' . esc_url($url) . '">' . esc_html(zo_get_interface_text('open_game', $language)) . '</a></div>';
		}

		echo '</div>';
		echo '</article>';
	}

	echo '</div>';

	if (!$has_results) {
		echo '<p class="zo-games-grid__empty">Filtreye uyan oyun bulunamadı.</p>';
	}

	if ($author_filter === 'asker') {
		$about_url = zo_get_owner_about_url('asker', $language);

		if ($about_url !== '') {
			echo '<div class="zo-games-grid__footer">';
			echo '<a class="zo-games-grid__about" href="' . esc_url($about_url) . '">' . esc_html(zo_get_interface_text('asker_about', $language)) . '</a>';
			echo '</div>';
		}
	}

	echo '</div>';

	return ob_get_clean();
}
add_shortcode('zeka_oyunlari_grid', 'zo_games_grid_shortcode');

function zo_locate_game_template($template) {
	$slug = zo_get_requested_game_slug();

	if ($slug === '') {
		return $template;
	}

	$custom_template = ZO_PLUGIN_DIR . 'templates/single-zeka-oyunu.php';

	return file_exists($custom_template) ? $custom_template : $template;
}
add_filter('template_include', 'zo_locate_game_template', 99);

function zo_append_game_to_content($content) {
	if (!is_singular('zeka_oyunu') || !in_the_loop() || !is_main_query()) {
		return $content;
	}

	$post_id = get_the_ID();
	$slug    = zo_get_game_slug_for_post($post_id);

	if (!$slug) {
		return $content;
	}

	return $content . "\n\n" . zo_render_game($slug, $post_id);
}
add_filter('the_content', 'zo_append_game_to_content');
