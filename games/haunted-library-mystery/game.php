<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'haunted-library-mystery',
	'name' => 'Haunted Library Mystery',
	'description' => 'Find glowing clues in a spooky library.',
	'goal' => 'Collect clue pages and avoid floating curses to solve the library mystery.',
	'hero' => 'Scout',
	'item' => 'Clue',
	'hazard' => 'Curse',
	'heroColor' => '#e9d5ff',
	'itemColor' => '#fef08a',
	'hazardColor' => '#7c3aed',
	'accent' => '#fef08a',
	'bgA' => '#1e1b4b',
	'bgB' => '#3b0764',
	'target' => 180,
	'difficulty' => 2,
	'speed' => 3,
));
