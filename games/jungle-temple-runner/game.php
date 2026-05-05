<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'jungle-temple-runner',
	'name' => 'Jungle Temple Runner',
	'description' => 'Sprint through a jungle temple collecting relics.',
	'goal' => 'Collect ancient relics and dodge rolling temple stones.',
	'hero' => 'Runner',
	'item' => 'Relic',
	'hazard' => 'Stone',
	'heroColor' => '#bef264',
	'itemColor' => '#facc15',
	'hazardColor' => '#78716c',
	'accent' => '#bef264',
	'bgA' => '#14532d',
	'bgB' => '#713f12',
	'target' => 210,
	'difficulty' => 3,
	'speed' => 14,
));
