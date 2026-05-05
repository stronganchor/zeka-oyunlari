<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'castle-trap-designer',
	'name' => 'Castle Trap Designer',
	'description' => 'Collect gears to finish clever castle traps.',
	'goal' => 'Collect gear parts and avoid runaway boulders in the castle workshop.',
	'hero' => 'Maker',
	'item' => 'Gear',
	'hazard' => 'Rock',
	'heroColor' => '#e2e8f0',
	'itemColor' => '#f59e0b',
	'hazardColor' => '#78716c',
	'accent' => '#f59e0b',
	'bgA' => '#292524',
	'bgB' => '#57534e',
	'target' => 200,
	'difficulty' => 2,
	'speed' => 4,
));
