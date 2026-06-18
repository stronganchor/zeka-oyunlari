<?php

if (!defined('ABSPATH')) {
	exit;
}

require_once dirname(__DIR__) . '/_shared/place-clock.php';

return zo_create_place_clock_game_module(array(
	'slug' => 'istanbul-clock',
	'name' => array(
		'tr' => 'Istanbul Saati',
		'en' => 'Istanbul Clock',
		'de' => 'Istanbul-Uhr',
	),
	'description' => array(
		'tr' => 'Istanbul saatini saniyelerle gosteren basit tarayici saati.',
		'en' => 'A simple browser clock showing Istanbul time with seconds.',
		'de' => 'Eine einfache Browser-Uhr mit der Zeit in Istanbul.',
	),
	'timezone' => 'Europe/Istanbul',
	'labels' => array(
		'tr' => array('title' => 'Istanbul Saati', 'zone' => 'Istanbul Saati', 'format' => '12/24 Saat', 'refresh' => 'Yenile', 'locale' => 'tr-TR'),
		'en' => array('title' => 'Istanbul Clock', 'zone' => 'Istanbul Time', 'format' => '12/24 Format', 'refresh' => 'Refresh', 'locale' => 'en-US'),
		'de' => array('title' => 'Istanbul-Uhr', 'zone' => 'Istanbul-Zeit', 'format' => '12/24 Format', 'refresh' => 'Aktualisieren', 'locale' => 'de-DE'),
	),
));
