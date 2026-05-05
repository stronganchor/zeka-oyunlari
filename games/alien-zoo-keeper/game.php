<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'alien-zoo-keeper',
	'name' => 'Alien Zoo Keeper',
	'description' => 'Collect food pods and keep the alien zoo calm.',
	'goal' => 'Gather food pods and dodge escaped alien bubbles.',
	'hero' => 'Keeper',
	'item' => 'Food',
	'hazard' => 'Alien',
	'heroColor' => '#86efac',
	'itemColor' => '#fde047',
	'hazardColor' => '#a78bfa',
	'accent' => '#86efac',
	'bgA' => '#052e16',
	'bgB' => '#581c87',
	'target' => 190,
	'difficulty' => 2,
	'speed' => 6,
));
