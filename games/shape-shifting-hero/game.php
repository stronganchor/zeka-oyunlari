<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'shape-shifting-hero',
	'name' => 'Shape-Shifting Hero',
	'description' => 'Collect shape cores and dodge mismatch traps.',
	'goal' => 'Collect shape cores and avoid glitch traps while changing forms.',
	'hero' => 'Hero',
	'item' => 'Core',
	'hazard' => 'Trap',
	'heroColor' => '#c084fc',
	'itemColor' => '#34d399',
	'hazardColor' => '#fb7185',
	'accent' => '#34d399',
	'bgA' => '#581c87',
	'bgB' => '#064e3b',
	'target' => 200,
	'difficulty' => 2,
	'speed' => 10,
));
