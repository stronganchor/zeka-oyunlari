<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'cloud-kingdom-jumper',
	'name' => 'Cloud Kingdom Jumper',
	'description' => 'Hop through a sky kingdom collecting cloud crowns.',
	'goal' => 'Collect cloud crowns and avoid storm bolts in the sky.',
	'hero' => 'Jump',
	'item' => 'Crown',
	'hazard' => 'Storm',
	'heroColor' => '#e0f2fe',
	'itemColor' => '#fde047',
	'hazardColor' => '#38bdf8',
	'accent' => '#fde047',
	'bgA' => '#0284c7',
	'bgB' => '#7c3aed',
	'target' => 180,
	'difficulty' => 2,
	'speed' => 12,
));
