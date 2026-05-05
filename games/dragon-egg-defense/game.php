<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'dragon-egg-defense',
	'name' => 'Dragon Egg Defense',
	'description' => 'Protect a dragon nest by gathering shield runes.',
	'goal' => 'Gather shield runes for the dragon egg and dodge icy raiders.',
	'hero' => 'Guard',
	'item' => 'Rune',
	'hazard' => 'Raid',
	'heroColor' => '#f97316',
	'itemColor' => '#fef3c7',
	'hazardColor' => '#60a5fa',
	'accent' => '#f97316',
	'bgA' => '#7f1d1d',
	'bgB' => '#431407',
	'target' => 210,
	'difficulty' => 2,
	'speed' => 6,
));
