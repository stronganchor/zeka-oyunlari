<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'emoji-quest-rpg',
	'name' => 'Emoji Quest RPG',
	'description' => 'Collect quest icons in a cheerful RPG world.',
	'goal' => 'Collect quest icons and dodge mischief symbols to level up.',
	'hero' => 'Hero',
	'item' => 'Quest',
	'hazard' => 'Oops',
	'heroColor' => '#fef3c7',
	'itemColor' => '#facc15',
	'hazardColor' => '#f43f5e',
	'accent' => '#facc15',
	'bgA' => '#365314',
	'bgB' => '#7c2d12',
	'target' => 190,
	'difficulty' => 2,
	'speed' => 6,
));
