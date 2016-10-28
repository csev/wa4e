<?php
// Note - cannot have any output before setcookie
if ( ! isset($_COOKIE['zap']) ) {
    setcookie('zap', '42', time()+3600);
}
?>
<pre>
<?php print_r($_COOKIE); ?>
</pre>
<p><a href="cookie.php">Click Me!</a> or press Refresh</p>
