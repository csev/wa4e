<?php
use \Tsugi\Core\LTIX;

if ( ! defined('COOKIE_SESSION') ) define('COOKIE_SESSION', true);

require_once "tsugi/config.php";

// Do this early to allow sanity-db.php to check in more detail after
// Headers has been sent
$PDOX = false;
try {
    define('PDO_WILL_CATCH', true);
    $PDOX = LTIX::getConnection();
    $LAUNCH = LTIX::session_start();
} catch(PDOException $ex){
    $PDOX = false;  // sanity-db-will re-check this below
}

if ( $PDOX !== false ) LTIX::loginSecureCookie();

$OUTPUT->header();
?>
<style>
body {
    font-family: var(--font-family);
    font-size: 1.2rem;
    line-height: 1.93rem;
    color: var(--text);
    background-color: var(--background-color);
}
</style>

