<?php

session_start();

$hosturl= "http://localhost:8888/si572/php-services";
$hosturl = "http://www.dr-chuck.com/si572/assn/php-services";

if ( isset($_POST['logout']) ) unset($_SESSION['login']);
if ( isset($_POST['login']) ) {
    $_SESSION['login'] = $_POST['login'];
    $_SESSION['pw'] = $_POST['pw'];
}

require_once("db.php");
require_once("service_util.php");

if (isset($_SESSION['login'])) {
   echo("Hello ".$_SESSION['login']."\n");
    echo('<form method="post">
        <input type="submit" name="logout" value="logout">
        <a href="rps.php">Refresh</a>
        </form>');
} else {
    echo('<form method="post">
        Account: <input type="text" name="login"> <br/>
        PW: <input type="text" name="pw"> <br/>
        <input type="submit">
        </form>');
    return;
}


echo('<form method="post">
    Choose Opponent: <input type="text" name="against"> <br/>
    Play (RPS=123): <input type="text" name="play"> <br/>
    <input type="submit" name="compete" value="Compete">
    </form><br/>');

echo('<form method="post">
    Your Play (RPS=123): <input type="text" name="play"> <br/>
    <input type="submit" name="new" value="Play">
    </form><br/>');

if ( isset($_POST['against']) && isset($_POST['play']) && isset($_POST['compete']) ) {
    $url = "$hosturl/rps_server.php?login=".urlencode($_SESSION['login'])
        ."&pw=".urlencode($_SESSION['pw']).
        '&against='.urlencode($_POST['against']).'&play='.urlencode($_POST['play']);
} else if ( isset($_POST['new']) && isset($_POST['play']) ) {
    $url = "$hosturl/rps_server.php?login=".urlencode($_SESSION['login'])
        ."&pw=".urlencode($_SESSION['pw']).'&play='.urlencode($_POST['play']);
} else {
    $url = "$hosturl/rps_server.php?login=".
        urlencode($_SESSION['login'])."&pw=".urlencode($_SESSION['pw']);
}

echo($url);
$games = file_get_contents($url);
echo("<br/>\n");
echo($games);

?>
