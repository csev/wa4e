<?php
use \Tsugi\Core\LTIX;

require_once "tsugi/config.php";
$LAUNCH = LTIX::session_start();

$OUTPUT->header();
include("nav.php");
?>
<div id="container">
<iframe	
height="4600" width="100%" frameborder="0" marginwidth="0"
marginheight="0" scrolling="auto"
src="install.php">
</iframe>
</div>
<?php $OUTPUT->footer();
