<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'crystal-cave-miner',
	'name' => 'Crystal Cave Miner',
	'description' => 'Mine glowing crystals in a dangerous cave.',
	'goal' => 'Collect crystals and dodge cave-in rocks before the lantern dims.',
	'hero' => 'Miner',
	'item' => 'Gem',
	'hazard' => 'Rock',
	'heroColor' => '#fef3c7',
	'itemColor' => '#67e8f9',
	'hazardColor' => '#57534e',
	'accent' => '#67e8f9',
	'bgA' => '#1f2937',
	'bgB' => '#155e75',
	'target' => 200,
	'difficulty' => 2,
	'speed' => 2,
));
