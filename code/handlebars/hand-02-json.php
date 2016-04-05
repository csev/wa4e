<?php
  sleep(2);
  header('Content-Type: application/json; charset=utf-8');
  $stuff = array('title' => 'Mathematics', 'body' => 'guess > 42');
  echo(json_encode($stuff));
