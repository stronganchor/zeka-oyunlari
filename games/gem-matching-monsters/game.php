<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'gem-matching-monsters',
	'name' => 'Gem Matching Monsters',
	'description' => 'Collect matching gems before monsters bump you.',
	'goal' => 'Collect matching gems and dodge monster bumps to finish the puzzle.',
	'hero' => 'Match',
	'item' => 'Gem',
	'hazard' => 'Monster',
	'heroColor' => '#f9a8d4',
	'itemColor' => '#67e8f9',
	'hazardColor' => '#a855f7',
	'accent' => '#67e8f9',
	'bgA' => '#3b0764',
	'bgB' => '#155e75',
	'target' => 200,
	'difficulty' => 2,
	'speed' => 8,
));
