<?php
/**
 * Plugin Name: Zekâ Oyunları
 * Plugin URI: https://github.com/stronganchor/zeka-oyunlari
 * Description: Simple modular game framework for zekâ.com so kids can publish WordPress-based games and share them with friends.
 * Version: 1.4.77.asker.arslan
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

function zo_get_smart_fallback_game_metadata($module) {
	$name = !empty($module['name']) && is_string($module['name']) ? trim($module['name']) : '';
	$slug = !empty($module['slug']) ? sanitize_title($module['slug']) : sanitize_title($name);
	$description = !empty($module['description']) && is_string($module['description']) ? trim(wp_strip_all_tags($module['description'])) : '';

	if ($name === '') {
		return null;
	}

	$has_localized_name = preg_match('/(?:^|\|)\s*(TR|EN|DE):/i', $name) === 1;
	$clean_name = $has_localized_name ? zo_cleanup_generated_game_title(zo_get_localized_text($name, 'en')) : zo_cleanup_generated_game_title($name);
	$category = zo_get_game_category($slug, $clean_name, $description);
	$templates = zo_get_fallback_description_templates($category);

	return array(
		'name' => $has_localized_name ? $name : sprintf('TR: %1$s | EN: %1$s | DE: %1$s', $clean_name),
		'description' => sprintf(
			'TR: %1$s EN: %2$s DE: %3$s',
			sprintf($templates['tr'], $clean_name),
			sprintf($templates['en'], $clean_name),
			sprintf($templates['de'], $clean_name)
		),
	);
}

function zo_cleanup_generated_game_title($title) {
	$title = trim(wp_strip_all_tags((string) $title));
	$title = preg_replace('/\s+/', ' ', $title);

	if (!is_string($title) || $title === '') {
		return '';
	}

	$title = preg_replace('/^\s*(TR|EN|DE):\s*/i', '', $title);
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
			'tr' => 'Tum oyunlar',
			'en' => 'All games',
			'de' => 'Alle Spiele',
		),
		'puzzle' => array(
			'tr' => 'Bulmaca',
			'en' => 'Puzzle',
			'de' => 'Puzzle',
		),
		'memory' => array(
			'tr' => 'Hafiza',
			'en' => 'Memory',
			'de' => 'Memory',
		),
		'math' => array(
			'tr' => 'Matematik',
			'en' => 'Math',
			'de' => 'Mathe',
		),
		'action' => array(
			'tr' => 'Aksiyon',
			'en' => 'Action',
			'de' => 'Action',
		),
		'sports' => array(
			'tr' => 'Spor',
			'en' => 'Sports',
			'de' => 'Sport',
		),
		'creative' => array(
			'tr' => 'Yaratici',
			'en' => 'Creative',
			'de' => 'Kreativ',
		),
		'tool' => array(
			'tr' => 'Araclar',
			'en' => 'Tools',
			'de' => 'Werkzeuge',
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
			'tr' => '%s, dikkatli dusunerek adim adim cozdugun bir zeka bulmacasidir.',
			'en' => '%s is a thinking puzzle where you solve the challenge step by step.',
			'de' => '%s ist ein Denkspiel, bei dem du die Aufgabe Schritt fuer Schritt loest.',
		),
		'memory' => array(
			'tr' => '%s, sirayi hatirlayip dogru hamleleri yapmani isteyen bir hafiza oyunudur.',
			'en' => '%s is a memory game where you remember the pattern and make the right moves.',
			'de' => '%s ist ein Memory-Spiel, bei dem du Muster merkst und richtig reagierst.',
		),
		'math' => array(
			'tr' => '%s, sayilar ve mantikla pratik yapmani saglayan egitici bir oyundur.',
			'en' => '%s is an educational game for practicing numbers and logic.',
			'de' => '%s ist ein Lernspiel zum Ueben von Zahlen und Logik.',
		),
		'action' => array(
			'tr' => '%s, hizli tepki verip hedefe ulasmaya calistigin hareketli bir oyundur.',
			'en' => '%s is an action game where quick reactions help you reach the goal.',
			'de' => '%s ist ein Actionspiel, bei dem schnelle Reaktionen zum Ziel fuehren.',
		),
		'sports' => array(
			'tr' => '%s, zamanlama ve stratejiyle oynanan spor temali bir oyundur.',
			'en' => '%s is a sports game built around timing and strategy.',
			'de' => '%s ist ein Sportspiel mit Timing und Strategie.',
		),
		'creative' => array(
			'tr' => '%s, bir seyler kurup deneyerek ilerledigin yaratici bir oyundur.',
			'en' => '%s is a creative game where you build, test, and improve your idea.',
			'de' => '%s ist ein kreatives Spiel, in dem du baust, testest und verbesserst.',
		),
		'tool' => array(
			'tr' => '%s, tarayicida kullanabilecegin basit ve egitici bir aractir.',
			'en' => '%s is a simple educational tool you can use in the browser.',
			'de' => '%s ist ein einfaches Lernwerkzeug fuer den Browser.',
		),
	);

	return isset($templates[$category]) ? $templates[$category] : $templates['puzzle'];
}

function zo_get_language_options() {
	return array(
		'tr' => 'TR',
		'en' => 'EN',
		'de' => 'DE',
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
			'de' => 'Zur Startseite',
		),
		'intro' => array(
			'tr' => 'Çocuklar, ilkokul öğrencileri ve yaşlılar için ücretsiz online eğitici zeka oyunları, mantık oyunları ve hafıza oyunları oynayın.',
			'en' => 'Play free online educational brain games, logic games, and memory games for kids, primary school students, and older people.',
			'de' => 'Spielen Sie kostenlose online Lern-Denkspiele, Logikspiele und Gedächtnisspiele für Kinder, Grundschüler und ältere Menschen.',
		),
		'open_game' => array(
			'tr' => 'Oyunu Aç',
			'en' => 'Open Game',
			'de' => 'Spiel Öffnen',
		),
		'language_label' => array(
			'tr' => 'Dil',
			'en' => 'Language',
			'de' => 'Sprache',
		),
		'search_label' => array(
			'tr' => 'Oyun ara',
			'en' => 'Search games',
			'de' => 'Spiele suchen',
		),
		'search_placeholder' => array(
			'tr' => 'Oyun adi yaz',
			'en' => 'Type a game name',
			'de' => 'Spielname eingeben',
		),
		'category_label' => array(
			'tr' => 'Kategori',
			'en' => 'Category',
			'de' => 'Kategorie',
		),
		'sort_label' => array(
			'tr' => 'Sirala',
			'en' => 'Sort',
			'de' => 'Sortieren',
		),
		'sort_title' => array(
			'tr' => 'Ada gore',
			'en' => 'By name',
			'de' => 'Nach Name',
		),
		'sort_newest' => array(
			'tr' => 'En yeni',
			'en' => 'Newest',
			'de' => 'Neueste',
		),
		'sort_category' => array(
			'tr' => 'Kategoriye gore',
			'en' => 'By category',
			'de' => 'Nach Kategorie',
		),
		'filter_submit' => array(
			'tr' => 'Filtrele',
			'en' => 'Filter',
			'de' => 'Filtern',
		),
		'filter_reset' => array(
			'tr' => 'Temizle',
			'en' => 'Clear',
			'de' => 'Loeschen',
		),
		'results_count' => array(
			'tr' => '%d oyun gosteriliyor',
			'en' => 'Showing %d games',
			'de' => '%d Spiele werden angezeigt',
		),
		'play_suffix' => array(
			'tr' => 'oyna',
			'en' => 'play',
			'de' => 'spielen',
		),
		'language_unavailable' => array(
			'tr' => 'Bu oyun seçili dilde kullanılamıyor.',
			'en' => 'This game is not available in the selected language.',
			'de' => 'Dieses Spiel ist in der ausgewählten Sprache nicht verfügbar.',
		),
	);

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
	);

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
	);

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

		if (preg_match_all('/(?:^|\|)\s*(TR|EN|DE):\s*([^|]+)/u', isset($meta['name']) ? $meta['name'] : '', $matches)) {
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
		'exact' => $exact,
		'replacements' => zo_get_runtime_translation_replacements($lang),
	);

	$script = '<script>(function(){'
		. 'const root=document.getElementById(' . wp_json_encode($id) . ');'
		. 'if(!root){return;}'
		. 'const payload=' . wp_json_encode($payload) . ';'
		. 'const exact=payload.exact||{};'
		. 'const reps=payload.replacements||[];'
		. 'const skip={SCRIPT:1,STYLE:1,NOSCRIPT:1,TEXTAREA:1,CODE:1,PRE:1};'
		. 'function applyCase(from,to){return from===from.toUpperCase()?to.toUpperCase():to;}'
		. 'function tx(value){if(typeof value!=="string"){return value;}const m=value.match(/^(\\s*)([\\s\\S]*?)(\\s*)$/);const lead=m?m[1]:"";let text=m?m[2]:value;const trail=m?m[3]:"";if(!text.trim()){return value;}const trimmed=text.trim();if(Object.prototype.hasOwnProperty.call(exact,trimmed)){return lead+exact[trimmed]+trail;}reps.forEach(function(pair){const from=pair[0];const to=pair[1];if(!from||!to){return;}text=text.split(from).join(applyCase(from,to));});return lead+text+trail;}'
		. 'function nodeText(node){if(!node||!node.nodeValue){return;}const next=tx(node.nodeValue);if(next!==node.nodeValue){node.nodeValue=next;}}'
		. 'function attrs(el){["aria-label","title","placeholder"].forEach(function(name){if(!el.hasAttribute||!el.hasAttribute(name)){return;}const next=tx(el.getAttribute(name));if(next!==el.getAttribute(name)){el.setAttribute(name,next);}});if(el.matches&&el.matches("input[type=button],input[type=submit],input[type=reset]")&&el.hasAttribute("value")){const next=tx(el.getAttribute("value"));if(next!==el.getAttribute("value")){el.setAttribute("value",next);}}}'
		. 'function walk(start){if(!start){return;}if(start.nodeType===3){nodeText(start);return;}if(start.nodeType!==1||skip[start.nodeName]){return;}attrs(start);const walker=document.createTreeWalker(start,NodeFilter.SHOW_TEXT,{acceptNode:function(n){return n.parentElement&&skip[n.parentElement.nodeName]?NodeFilter.FILTER_REJECT:NodeFilter.FILTER_ACCEPT;}});let n;while((n=walker.nextNode())){nodeText(n);}start.querySelectorAll&&start.querySelectorAll("[aria-label],[title],[placeholder],button,input").forEach(attrs);}'
		. 'walk(root);'
		. 'let busy=false;const observer=new MutationObserver(function(items){if(busy){return;}busy=true;items.forEach(function(item){if(item.type==="characterData"){nodeText(item.target);}else{item.addedNodes.forEach(walk);if(item.type==="attributes"){attrs(item.target);}}});busy=false;});'
		. 'observer.observe(root,{childList:true,subtree:true,characterData:true,attributes:true,attributeFilter:["aria-label","title","placeholder","value"]});'
		. '})();</script>';

	return '<div id="' . esc_attr($id) . '" class="zo-game-shell zo-game-shell--' . esc_attr($slug) . '" data-zo-game-lang="' . esc_attr($lang) . '">' . $html . '</div>' . $script;
}

function zo_get_localized_text($text, $lang = '') {
	$text = is_string($text) ? trim($text) : '';
	$lang = array_key_exists($lang, zo_get_language_options()) ? $lang : zo_get_current_language();

	if ($text === '') {
		return '';
	}

	$labels = array('tr' => 'TR:', 'en' => 'EN:', 'de' => 'DE:');
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

	$result = isset($parts[$lang]) ? $parts[$lang] : reset($parts);

	if (is_string($result) && $result !== $text && preg_match('/(?:^|\|)\s*(TR|EN|DE):/i', $result)) {
		return zo_get_localized_text($result, $lang);
	}

	return $result;
}

function zo_get_asker_display_game_metadata($module) {
	if (empty($module['slug'])) {
		return null;
	}

	$metadata = zo_get_asker_multilingual_game_metadata(sanitize_title($module['slug']));
	if (!is_array($metadata)) {
		$metadata = zo_get_smart_fallback_game_metadata($module);
	}

	return is_array($metadata) ? $metadata : null;
}

function zo_get_game_display_metadata($module) {
	if (empty($module['slug'])) {
		return zo_get_smart_fallback_game_metadata($module);
	}

	$metadata = zo_get_asker_multilingual_game_metadata(sanitize_title($module['slug']));
	if (!is_array($metadata)) {
		$metadata = zo_get_smart_fallback_game_metadata($module);
	}

	return is_array($metadata) ? $metadata : null;
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
	return '
.zo-game-shell,
.zo-game-root {
	-webkit-tap-highlight-color: transparent;
	-webkit-touch-callout: none;
	overscroll-behavior: contain;
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
		$result = call_user_func($module['render_callback'], (int) $post_id, $module);

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
	$css    = '
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

	echo '<div class="zo-games-grid-wrap">';

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
