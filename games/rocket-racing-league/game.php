<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'rocket-racing-league',
	'name' => 'Rocket Racing League',
	'description' => 'Race a rocket through space gates.',
	'goal' => 'Collect speed gates and dodge rival rockets in the racing league.',
	'hero' => 'Rocket',
	'item' => 'Gate',
	'hazard' => 'Rival',
	'heroColor' => '#f97316',
	'itemColor' => '#38bdf8',
	'hazardColor' => '#ef4444',
	'accent' => '#38bdf8',
	'bgA' => '#020617',
	'bgB' => '#7c2d12',
	'target' => 230,
	'difficulty' => 3,
	'speed' => 22,
));
