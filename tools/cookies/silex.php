<?php
require_once "../config.php";

use \Tsugi\Core\LTIX;
use \Tsugi\UI\Lessons;

$launch = LTIX::requireData();
// if ( count($_POST) > 0 ) { var_dump($launch); die(); }
$app = new \Tsugi\Silex\Application($launch);
$app['debug'] = true;

$app->get('/', 'AppBundle\\Cookies::get')->bind('main'); 

$app->post('/', 'AppBundle\\Cookies::post');

$app->run();
