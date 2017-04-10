<?php
require_once "../config.php";

use \Tsugi\Core\LTIX;

$launch = LTIX::requireData();
$app = new \Tsugi\Silex\Application($launch);

$app['debug'] = true;

$app->get('/', 'AppBundle\\Cookies::get')->bind('main'); 

$app->post('/', 'AppBundle\\Cookies::post');

$app->run();
