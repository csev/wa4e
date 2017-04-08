<?php

namespace AppBundle;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Cookies 
{
    public function post(Request $request, Application $app)
    {
        $session = $app['session'];
        $tsugi = $app['tsugi'];

        $session->set('post_data', $_POST);
        $code = md5($tsugi->user->id+$tsugi->link->id+$tsugi->context->id);

        $error = '';
        $score = 0;
        if ( $_POST['cookie'] == $code ) {
            $score += 0.5;
        } else {
            $error = 'Incorrect cookie value';
        }
        if ( $_POST['session'] == session_id() ||
            ( isset($_COOKIE[session_name()]) &&
            $_POST['session'] == $_COOKIE[session_name()] ) ) {
            $score += 0.5;
        } else {
            if ( strlen($error) > 0 ) $error .= ' / ';
            $error .= 'Incorrect session ID value';
        }

        $app['tsugi']->result->gradeSend($score);
        if ( $score >= 1.0 ) {
            $app->tsugiFlashSuccess('Assignment completed');
        } else {
            $app->tsugiFlashError($error . ' Score=' . $score);
        }

        return $app->tsugiRedirect('main');
    }

    public function get(Request $request, Application $app)
    {
        $cookies = $request->cookies;
        $tsugi = $app['tsugi'];
        // Note - cannot have any output before setcookie
        $code = md5($tsugi->user->id+$tsugi->link->id+$tsugi->context->id);
        if ( ! $cookies->has('wa4e_secret_cookie') ) {
            setcookie('wa4e_secret_cookie', $code, time()+3600);
        }


        $context = array();
        $context['oldcookie'] = '';
        $context['oldsession'] = '';
        $session = $app['session'];
        if ( $session->has('post_data') ) {
            $oldpost = $session->get('post_data');
            $context['oldcookie'] = $oldpost['cookie'];
            $context['oldsession'] = $oldpost['session'];
            $session->remove('post_data');  // Our own little flash
        }
        $context['cookies'] = $app['tsugi']->output->safe_var_dump($cookies->all());
        $context['session_name'] = session_name();
        return $app['twig']->render('Cookies.twig', $context);
    }
}
