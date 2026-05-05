<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'balloon-tower-climb',
	'name' => 'Balloon Tower Climb',
	'description' => 'Float up a tower collecting lift balloons.',
	'goal' => 'Collect lift balloons and dodge sharp tower spikes.',
	'hero' => 'Balloon',
	'item' => 'Lift',
	'hazard' => 'Spike',
	'heroColor' => '#fb7185',
	'itemColor' => '#fef08a',
	'hazardColor' => '#334155',
	'accent' => '#fb7185',
	'bgA' => '#0ea5e9',
	'bgB' => '#7c3aed',
	'target' => 190,
	'difficulty' => 2,
	'speed' => 8,
));
