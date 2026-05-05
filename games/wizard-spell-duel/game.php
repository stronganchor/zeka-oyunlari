<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'wizard-spell-duel',
	'name' => 'Wizard Spell Duel',
	'description' => 'Collect spell sparks to win a wizard duel.',
	'goal' => 'Gather spell sparks and dodge rival magic blasts.',
	'hero' => 'Mage',
	'item' => 'Spark',
	'hazard' => 'Spell',
	'heroColor' => '#c4b5fd',
	'itemColor' => '#fef08a',
	'hazardColor' => '#fb7185',
	'accent' => '#c4b5fd',
	'bgA' => '#4c1d95',
	'bgB' => '#0f172a',
	'target' => 200,
	'difficulty' => 2,
	'speed' => 8,
));
