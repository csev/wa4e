<?php

function getPageCache($url,$cachetime=300)
{
    $now = time();
    $then = $now - $cachetime;
    $murl = mysql_real_escape_string($url);
    $sql = "SELECT body FROM cache WHERE url='$murl' AND retrieved >= $then
            ORDER BY retrieved DESC";
    $result = mysql_query($sql);
    $row = FALSE;
    if ( $result !== FALSE) $row = mysql_fetch_row($result);
    if ( is_array($row) ) {
        echo("Returned ".strlen($row[0])." from cache.\n");
        return $row[0];
    } else {
        $data = file_get_contents($url);
        echo("Retrieved ".strlen($data)." characters.\n");
        $sql = "DELETE FROM cache WHERE url='$murl'";
        mysql_query($sql);
        $mdata = mysql_real_escape_string($data);
        $sql = "INSERT INTO cache (url,retrieved,body) 
                VALUES ('$murl', $now, '$mdata')";
        mysql_query($sql);
        return $data;
    }
}

?>