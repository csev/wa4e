<?php

require_once("fields.php");

$data = file_get_contents("../crud_generic/peer.json");
$json = json_decode($data);

$json->title = $title_plural . " CRUD Database";
$json->assignment = $specification;
$json->solution = $reference_implementation;

header('Content-Type: application/json');
echo json_encode($json, JSON_PRETTY_PRINT);
