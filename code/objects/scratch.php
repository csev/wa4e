<?php

$player = new stdClass();

$player->name = "Chuck";
$player->score = 0;

$player->score++;

print_r($player);

class Player {
    public $name = "Sally";
    public $score = 0;
}

$p2 = new Player();
$p2->score++;

print_r($p2);
