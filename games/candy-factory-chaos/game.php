<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'candy-factory-chaos',
	'name' => 'Candy Factory Chaos',
	'description' => 'Collect candy batches in a chaotic factory.',
	'goal' => 'Collect candy batches and dodge broken conveyor parts.',
	'hero' => 'Chef',
	'item' => 'Candy',
	'hazard' => 'Gear',
	'heroColor' => '#f9a8d4',
	'itemColor' => '#fef08a',
	'hazardColor' => '#64748b',
	'accent' => '#f9a8d4',
	'bgA' => '#be123c',
	'bgB' => '#7c3aed',
	'target' => 220,
	'difficulty' => 2,
	'speed' => 10,
));
