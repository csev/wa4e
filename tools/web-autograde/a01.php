<? // do some grading
$possgrade = 0;
$grade = 0;
$titlematch = false;

$dom = new DOMDocument;
@$dom->loadHTML($data);

print("Checking title tag for correct string...\n");
$titlematch = titleCheck($dom);
if ( $titlematch ) {
    echo("Found correct text in title tag\n");
} else {
    echo("<span class=\"incorrect\">Did not find ... ".htmlentities(getTitleCheck())." ... in the title tag\n");
    echo("Document will be checked, but the grade will not be recorded...</span>\n");
}

print("Checking Document Structure.\n");
$possgrade++;
if ( tagExists($dom, 'html') ) $grade++;
progressMessage($grade,$possgrade);

$possgrade++;
if ( tagExists($dom, 'head') ) $grade++;
progressMessage($grade,$possgrade);

$possgrade++;
if ( tagExists($dom, 'body') ) $grade++;
progressMessage($grade,$possgrade);

$possgrade++;
if ( tagExists($dom, 'h1') ) $grade++;
progressMessage($grade,$possgrade);

$possgrade++;
if ( tagExists($dom, 'div') ) $grade++;
progressMessage($grade,$possgrade);

$possgrade++;
$count = getTagCount($dom, 'span');
if ( $count >= 1 ) {
    $grade++;
    goodmessage('Found at least one span tag');
} else {
    badmessage('Wanted at least one span tag, found '.$count."\n");
}
progressMessage($grade,$possgrade);

$possgrade++;
if ( tagExists($dom, 'ul') ) $grade++;
progressMessage($grade,$possgrade);

$possgrade++;
$count = getTagCount($dom, 'li');
if ( $count == 3 ) {
    $grade++;
    goodmessage('Found three li tags');
} else {
    badmessage('Wanted three li tags, found '.$count."\n");
}
progressMessage($grade,$possgrade);

$possgrade++;
$count = getTagCount($dom, 'a');
if ( $count == 3 ) {
    $grade++;
    goodmessage('Found three a tags');
} else {
    badmessage('Wanted three a (anchor) tags, found '.$count."\n");
}
progressMessage($grade,$possgrade);

