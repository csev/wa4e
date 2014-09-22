<?php
  // Note - cannot have any output before this
  session_start();
  if ( ! isset($_SESSION['value']) ) {
     echo("<p>Session is empty</p>\n");
     $_SESSION['value'] = 0;
  } else if ( $_SESSION['value'] < 3 ) {
    $_SESSION['value'] = $_SESSION['value'] + 1;
     echo("<p>Added one...</p>\n");
  } else {
    session_destroy();
    session_start();
    echo("<p>Session Restarted</p>\n");
  }
?>
<p><a href="sessfun.php">Click Me!</a></p>
<p>Our Session ID is: <?php echo(session_id()); ?></p>
<pre>
<?php print_r($_SESSION); ?>
</pre>