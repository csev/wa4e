<?php

define('COOKIE_SESSION', true);
require_once "tsugi/config.php";

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use \Tsugi\Core\LTIX;

$launch = LTIX::session_start();
$app = new \Tsugi\Silex\Application($launch);
$app['tsugi']->output->buffer = false;
$app['debug'] = true;

$app->error(function (NotFoundHttpException $e, Request $request, $code) use ($app) {
    global $CFG, $LAUNCH, $OUTPUT, $USER, $CONTEXT, $LINK, $RESULT;

    include("top.php");
    include("nav.php");
    echo("<h2>Page not found.</h2>\n");
    include("foot.php");
    return "";

});


$app->get('/materials', function () {
    global $CFG, $OUTPUT, $USER, $CONTEXT, $LINK, $RESULT;
    require_once('materials.php');
    return "";
});

$app->get('/book', function () {
    global $CFG, $OUTPUT, $USER, $CONTEXT, $LINK, $RESULT;
    require_once('book.php');
    return "";
});

$app->get('/install', function () {
    global $CFG, $OUTPUT, $USER, $CONTEXT, $LINK, $RESULT;
    require_once('install.php');
    return "";
});

$app->run();
