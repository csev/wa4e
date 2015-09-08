<?

require_once("db.php");

function print_status($play_me, $play_them) {
  if ( $play_me == $play_them) {
    echo("Tie\n");
    return;
  }
  if ($play_me == 2 && $play_them == 1 ||
      $play_me == 3 && $play_them == 2 ||
      $play_me == 1 && $play_them == 3 ) {
     echo("You Won!\n");
  } else {
      echo("You Lost :(\n");
}
}

echo("<pre>\n");

echo("Welcome to RPS=123\n\n");

if ( isset($_GET['against']) && isset($_GET['play']) && isset($_GET['login']) ) {

    $login = mysql_real_escape_string($_GET['login']);
    $against = mysql_real_escape_string($_GET['against']);
    $play = mysql_real_escape_string($_GET['play']);    
    $sql = "SELECT play, opponent FROM rps_game WHERE login='$against'";
    // echo($sql."\n");
    $result = mysql_query($sql);
    $row = FALSE;
    if ( $result !== FALSE) $row = mysql_fetch_row($result);
    // print_r($row);
    $play2 = $row[0];
    $play1 = intval($play);
    $good = FALSE;
    if ( isset($row[1]) ) {
        $good = $login == $row[1];
        echo("This game was already played\n");
    } else {
        $good = TRUE;
        $sql = "UPDATE rps_game SET play2='$play',opponent='$login' WHERE login='$against'";
        // echo($sql."\n");
        $result = mysql_query($sql);
    }
    if ( $good ) {
        echo("Your play=$play1 their play=$play2\n");
        print_status($play1, $play2);
    } else {
        echo("This is not your game\n");
    }
}

if ( isset($_GET['login']) && isset($_GET['pw']) && isset($_GET['play']) ) {
    $login = mysql_real_escape_string($_GET['login']);
    $pw = mysql_real_escape_string($_GET['pw']);
    $play = mysql_real_escape_string($_GET['play']);
    $sql = "DELETE from rps_game WHERE login='$login' AND pw='$pw'";
    // echo($sql."\n");
    mysql_query($sql);
    $sql = "INSERT INTO rps_game (login,pw,play) 
            VALUES ('$login', '$pw', $play)";
    // echo($sql."\n");
    mysql_query($sql);
}

if ( isset($_GET['login']) && isset($_GET['pw']) ) {
    $login = mysql_real_escape_string($_GET['login']);
    $pw = mysql_real_escape_string($_GET['pw']);
    $sql = "SELECT play,play2,opponent from rps_game WHERE login='$login' AND pw='$pw'";
    // echo($sql."\n");
    $result = mysql_query($sql);
    $row = FALSE;
    if ( $result !== FALSE) $row = mysql_fetch_row($result);
    // print_r($row);
    if ( $row !== FALSE ) {
        echo("Your play=".$row[0]." ");
        if ( isset($row[1]) ) {
           echo($row[2]." played=".$row[1]."\n");
            $play = $row[0];
            $play2 = $row[1];
            print_status($play, $play2);
        } else {
            echo("You are waiting for someone to play you\n");
        }
    }
}

$sql = "SELECT login FROM rps_game WHERE play2 IS NULL";
// echo($sql."\n");
$result = mysql_query($sql);
$row = FALSE;
echo("\n================\nPlayers ready to play:\n");
if ( $result !== FALSE) 
while ($row = mysql_fetch_array($result) ) {
   echo($row[0]."\n");
}

?> 