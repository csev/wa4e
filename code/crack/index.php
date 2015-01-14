<!DOCTYPE html>
<head><title>Charles Severance MD5 Cracker</title></head>
<body>
<h1>MD5 cracker</h1>
<p>This application takes an MD5 hash
of a two-character lower case string and 
attempts to hash all two-character combinations
to determine the original two characters.</p>
<pre>
Debug Output:
<?php
$goodtext = "Not found";
if ( isset($_GET['md5']) ) {
    $time_pre = microtime(true);
    $md5 = $_GET['md5'];

    $txt = "abcdefghijklmnopqrstuvwxyz";
    $found = false;
    $show = 14;
    for($i=0; $i<strlen($txt); $i++ ) {
        $ch1 = $txt[$i];
        for($j=0; $j<strlen($txt); $j++ ) {
            $ch2 = $txt[$j];

            $try = $ch1.$ch2;
            $check = hash('md5', $try);
            if ( $check == $md5 ) {
                $goodtext = $try;
                break;
            }
            if ( $show > 0 ) {
                print "$check $try\n";
                $show = $show - 1;
            }
        }
    }
    $time_post = microtime(true);
    print "Ellapsed time: ";
    print $time_post-$time_pre;
    print "\n";
}
?>
</pre>
<p>Original Text: <?= htmlentities($goodtext); ?></p>
<form>
<input type="text" name="md5" size="40" />
<input type="submit" value="Crack MD5"/>
</form>
<p><a href="index.php">Reset</a></p>
<p><a href="md5.php">MD5 Encoder</a></p>
<p><a href="makepin.php">MD5 Four Digit PIN Maker</a> (for assignment)</p>
</body>
</html>

