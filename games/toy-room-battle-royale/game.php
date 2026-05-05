<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'toy-room-battle-royale',
	'name' => 'Toy Room Battle Royale',
	'description' => 'Collect toy stars in a fast bedroom arena.',
	'goal' => 'Collect toy stars and dodge bouncing block attacks.',
	'hero' => 'Toy',
	'item' => 'Star',
	'hazard' => 'Block',
	'heroColor' => '#60a5fa',
	'itemColor' => '#fef08a',
	'hazardColor' => '#f87171',
	'accent' => '#fef08a',
	'bgA' => '#1d4ed8',
	'bgB' => '#be123c',
	'target' => 210,
	'difficulty' => 3,
	'speed' => 12,
));
