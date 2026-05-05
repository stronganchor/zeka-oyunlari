<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'magic-paint-battle',
	'name' => 'Magic Paint Battle',
	'description' => 'Collect magic paint drops and win the color duel.',
	'goal' => 'Collect paint drops to power your brush and dodge ink blasts.',
	'hero' => 'Brush',
	'item' => 'Paint',
	'hazard' => 'Ink',
	'heroColor' => '#2dd4bf',
	'itemColor' => '#f472b6',
	'hazardColor' => '#111827',
	'accent' => '#f472b6',
	'bgA' => '#164e63',
	'bgB' => '#7e22ce',
	'target' => 210,
	'difficulty' => 2,
	'speed' => 10,
));
