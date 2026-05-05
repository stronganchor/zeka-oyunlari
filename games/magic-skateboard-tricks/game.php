<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'magic-skateboard-tricks',
	'name' => 'Magic Skateboard Tricks',
	'description' => 'Collect trick stars on a magical skateboard.',
	'goal' => 'Collect trick stars and dodge curb traps on the magic skate course.',
	'hero' => 'Skate',
	'item' => 'Trick',
	'hazard' => 'Curb',
	'heroColor' => '#c084fc',
	'itemColor' => '#fef08a',
	'hazardColor' => '#64748b',
	'accent' => '#c084fc',
	'bgA' => '#0f172a',
	'bgB' => '#be123c',
	'target' => 220,
	'difficulty' => 2,
	'speed' => 18,
));
