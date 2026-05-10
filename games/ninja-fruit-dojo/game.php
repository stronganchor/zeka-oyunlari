<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'fruit-target-dojo',
	'name' => 'Fruit Target Dojo',
	'description' => 'Dash through the dojo collecting fruit targets.',
	'goal' => 'Collect fruit tokens and dodge bamboo traps.',
	'hero' => 'Runner',
	'item' => 'Fruit',
	'hazard' => 'Trap',
	'heroColor' => '#111827',
	'itemColor' => '#f43f5e',
	'hazardColor' => '#84cc16',
	'accent' => '#f43f5e',
	'bgA' => '#14532d',
	'bgB' => '#78350f',
	'target' => 220,
	'difficulty' => 2,
	'speed' => 18,
));
