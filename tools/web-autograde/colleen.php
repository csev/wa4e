<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\Net;
use \Tsugi\Blob\BlobUtil;

$oldgrade = $RESULT->grade;
$grade = 0;
$possgrade = 0;
if ( isset($_FILES['html_01']) ) {

    $fdes = $_FILES['html_01'];
    $filename = isset($fdes['name']) ? basename($fdes['name']) : false;
     // Check to see if they left off a file
    if( $fdes['error'] == 4) {
        $_SESSION['error'] = 'Missing file, make sure to select all files before pressing submit';
        header( 'Location: '.addSession('index.php') ) ;
        return;
    }

    $data = BlobUtil::uploadFileToString($fdes, false);
    if ( $data === false ) {
        $_SESSION['error'] = 'Could not retrieve file data';
        header( 'Location: '.addSession('index.php') ) ;
        return;
    }

    if ( count($data) > 250000 ) {
        $_SESSION['error'] = 'Please upload a file less than 250K';
        header( 'Location: '.addSession('index.php') ) ;
        return;
    }
    
    // Put the data into session to allow us to process this in the GET request
    $_SESSION['html_data'] = $data;
    header( 'Location: '.addSession('index.php') ) ;
    return;
}

if ( $LINK->grade > 0 ) {
    echo('<p class="alert alert-info">Your current grade on this assignment is: '.($LINK->grade*100.0).'%</p>'."\n");
}

if ( $dueDate->message ) {
    echo('<p style="color:red;">'.$dueDate->message.'</p>'."\n");
}
?>
<p>
<form name="myform" enctype="multipart/form-data" method="post" action="<?= addSession('index.php') ?>">
Please upload your file containing the HTML.
<p><input name="html_01" type="file"></p>
<input type="submit">
</form>
</p>
<?php

if ( ! isset($_SESSION['html_data']) ) return;

$data = $_SESSION['html_data'];
unset($_SESSION['html_data']);
echo("<pre>\n");
// echo("Input HTML\n");
// echo(htmlentities($data));
// echo("\n");

$val_error=false;
if ( $CFG->OFFLINE ) {
    echo("Skipped validator because we are offline\n");
} else {
    $validator = 'https://validator.w3.org/nu/?out=json&parser=html5';
    echo("Sending ".strlen($data)." characters to the validator.\n$validator ...\n");
    $return = Net::doBody($validator, "POST", $data, 
        "Content-type: text/html; charset=utf-8\nUser-Agent: Autograder_www.wa4e.com");

    echo(htmlentities(LTI::jsonIndent($return)));
    $json = json_decode($return);
    if ( !isset($json->messages) || ! is_array($json->messages) ) {
        echo "<span>Did not get a correct response from the validator</span>\n";
        echo "URL: ".htmlentities($validator)."\n";
        echo "Data length: ".strlen($return)."\n";
        echo("Validator Output:\n");
        echo(htmlentities(LTI::jsonIndent($return)));
        return;
    }

    foreach($json->messages as $item)
    {
        if($item->type == "error")
        {
            echo "<span>Found error</span>";
            // echo("Validator Output:\n");
            // echo(htmlentities(LTI::jsonIndent($return)));
            $val_error=true;
            break;
        }
    }
}

if ($val_error){
  echo "Your code did not validate.  Please return to the W3 validator at validator.w3.org to check your code.";
  return;
}
    echo "Validation success!\n";
    $dom = new DOMDocument;
    @$dom->loadHTML($data);

    print("Checking for specific components.\n");
    print("Checking for html tag...");
    $possgrade+=1; //html + lang
    try {
      $nodes = $dom->getElementsByTagName('html');
      if ($nodes->length==1){
        print("<span class='correct'>Found it! </span>\n");
        $grade+=1; 
        echo ($grade .' out of ' . $possgrade ."\n\n");
        print("Checking that English language is specified...");
        $possgrade+=1;
        foreach ($nodes as $p) //go to each section 1 by 1 
        {
            if ($p->getAttribute('lang')==="en"){
                print("<span class='correct'>Found it! </span>\n");
                $grade+=1;
            }
            else{
            print("<span>***Didn't find it!!</span>\n");
        }
    }
 }
 else
    print("<span>***Did NOT find html tag!</span>\n");
}catch(Exception $ex){
    print("<span>***Did not find html tag!</span>\n");
    error_log("***Did not find html tag!\n");
}

echo ($grade .' out of ' . $possgrade ."\n\n");

print("Checking for head tag...\n");
$possgrade+=1;

try {
  $nodes = $dom->getElementsByTagName('head');
  if ($nodes->length==1){
    print("<span class='correct'>Found it! </span>\n");

    $grade+=1;
    echo ($grade .' out of ' . $possgrade ."\n\n");
    print("Checking for meta tag...\n");
    $possgrade+=1;

    try {
        $nodes = $dom->getElementsByTagName('meta');
        foreach ($nodes as $p) //go to each section 1 by 1 
        {
            if ($p->getAttribute('charset')!=null){
                print("<span class='correct'>Found it! </span>\n");
                $grade+=1;
            }
            else{
                print("\n<span>***Didn't find it!!</span>\n");
            }
        }   
    } catch(Exception $ex){
        print("<span>***Did not find meta tag!</span>" . "\n");
        error_log("***Did not find meta tag!" . "\n");
    }
    echo ($grade .' out of ' . $possgrade ."\n\n");

    print("Checking for title tag...\n");
    $possgrade+=1;
    try {
        $nodes = $dom->getElementsByTagName('title');
        if ($nodes->length==1){
            print("<span class='correct'>Found it! </span>\n");
            $grade+=1;
        }
        else{
            print("\n<span>***Found more than one!!</span>\n");
        }
    }catch(Exception $ex){
        print("<span>***Did not find title tag!</span>\n");
        error_log("***Did not find title tag!\n");
    }
  }
}catch(Exception $ex){
    print("<span>***Did not find head tag!</span>\n");
    error_log("***Did not find head tag!\n");
}

echo ($grade .' out of ' . $possgrade ."\n\n");
$possgrade+=1; //body tag

print("Checking for body tag...\n");

try {

 $nodes = $dom->getElementsByTagName('body');
 if ($nodes->length==1){
    print("<span class='correct'>Found body tag!</span>\n");
    $grade+=1;
    }
  else
     print("***<span>Did NOT find body tag or found more than one!</span>\n");
}catch(Exception $ex){
    print("<span>***Did not find body tag!</span>");
    error_log("***Did not find body tag!");
}

echo ($grade .' out of ' . $possgrade ."\n\n");
$possgrade+=1; //header tag
print("Checking for header tag...\n");

try {
$nodes = $dom->getElementsByTagName('header');
if ($nodes->length==1){
    print("<span class='correct'>Found header tag!</span>\n");
    $grade+=1;
}
else{
     print("<span>***Did NOT find header tag or found more than one!</span>\n");
 }
}catch(Exception $ex){
print("<span>***Did not find header tag!</span>");
error_log("***Did not find header tag!");
}

echo ($grade .' out of ' . $possgrade ."\n\n");
$possgrade+=1; //h1 tag
    print("Checking for h1 tag...\n");

try {
$nodes = $dom->getElementsByTagName('h1');
if ($nodes->length==1){
    foreach ($nodes as $node) {
        $h1 = $node;
    }
    if (trim(strtolower($h1->nodeValue) == 'colleen van lent')) {
        print("<span>".htmlentities('<h1> tag text not changed from example page. \n'."</span>"));
    }
    else {
        print("<span class='correct'>".htmlentities("<h1> tag formatted properly")."</span>" . "\n");
        $grade += 1; 
    }
}
else{
     print("...<span>Did NOT find h1 tag or found more than one!</span>\n" . "\n");
 }
}catch(Exception $ex){
print("<span>***Did not find h1 tag!</span>");
error_log("***Did not find h1 tag!");
}

echo ($grade .' out of ' . $possgrade ."\n\n");
$possgrade+=1; //h2 tags
print("Checking for three h2 tags...\n");

try {
$nodes = $dom->getElementsByTagName('h2');
if ($nodes->length === 3) {
    print("<span class='correct'>".htmlentities("Found three  tags") . "</span>\n");
    $grade += 1; 
}
else {
    print("<span>".(htmlentities('***Found more or less than three  tags')) . "</span>\n");
}
}
catch(Exception $ex) {
print("<span>".htmlentities('***Did not find any  tags')."</span>\n");
error_log(htmlentities('***Did not find any  tags'));
}

echo ($grade .' out of ' . $possgrade ."\n\n");
$possgrade+=1; //h2 nav
print("Checking for nav tag...\n");
try {
$nodes = $dom->getElementsByTagName('nav');
if ($nodes->length==1){
    print("<span class='correct'>Found nav tag!</span>\n");
    $grade+=1;
}
else{
     print("<span>...***Found more than one nav tag!\n" . "</span>\n");
 }
}catch(Exception $ex){
print("<span>***Did not find nav tag!</span>");
error_log("***Did not find nav tag!");
}

echo ($grade .' out of ' . $possgrade ."\n\n");
$possgrade+=1; //h2 sections
print("Checking for section tags...\n");
try {
$nodes = $dom->getElementsByTagName('section');
if ($nodes->length==3){
    print("<span class='correct'>Found three section tags!</span>\n");
    $grade+=1;
}
else
     print("<span>***Did NOT find three sections tags</span>\n" . "\n");
}catch(Exception $ex){
print("<span>***Did not find 3 section tags!</span>");
}

echo ($grade .' out of ' . $possgrade ."\n\n");
print("Searching for four links in the nav..." . "\n");
$possgrade+=1; 

try {
$nav = $dom->getElementsByTagName('nav');
$nav_links_all = array();
foreach ($nav as $navlinks) {
    $navlinks = $navlinks->childNodes;
    $count=0;
    foreach ($navlinks as $link) {
        $nav_links_all[] = $link;
        if ( ! isset($link->tagName) ) continue;
        if ($link->tagName === "a") {
            $count+=1;
            print("Found ". $count . '....');
        }
    }
    if ($count==4){
        print("<span class='correct'>Found all four links!</span>\n");
        $grade+=1;
        echo ($grade .' out of ' . $possgrade ."\n\n");


        $possgrade+=1;
        if (trim(strtolower($nav_links_all[6]->nodeValue)) !== 'four') {
            print("<span class='correct'>".htmlentities("\n Fourth <a> tag's text was changed") . "</span>\n");
            $grade += 1; 
        }
        else {
            print("<span>".htmlentities('***Fourth <a> tag text was not changed') . "</span>\n");
        }
    }
    else
        print("\n<span>****Did not find four links in the nav section" . "</span>\n");
    }
} catch(Exception $ex) {
    print("***Did not find links in the navigation");
    $navlinks = "";
}
echo ($grade .' out of ' . $possgrade ."\n\n");
$possgrade+=1; //ul tag + li tags
print("Checking for four list items...\n");
try {
$nodes = $dom->getElementsByTagName('ul');
$list_items = array();
if ($nodes->length == 1) {
    foreach ($nodes as $node) {
        $items = $node->childNodes;
        $count = 0;
        foreach ($items as $item) {
            $list_items[] = $item;
            if ( ! isset($link->tagName) ) continue;
            if ($item->tagName === 'li') {
                $count += 1;
            }
        }
    }
    if ($count == 4) {
        print("<span class='correct'>Found four list items!</span>\n");
        $lcount = 0;
        foreach ($list_items as $item) {
            // echo '<p>' . $item->nodeValue . '</p>';
            if (trim(strtolower($item->nodeValue)) == 'apples' || trim(strtolower($item->nodeValue)) == 'pizza' ||
                trim(strtolower($item->nodeValue)) == 'crab' || trim(strtolower($item->nodeValue)) == 'chocolate cake') {
                $lcount += 1;
            }
        }
        if ($lcount) {
            print('<span>***' . $lcount . ' list ' . ($lcount == 1 ? 'item is' : 'items are') . ' the same as the example page </span>\n');
        }
        else {
            print('All list items formatted properly' . "\n");
            $grade += 1; 
        }
    }
    else {
        print("\n <span>***Found less or more than four list items" . "</span>\n");
    }
}
else {
    print("<span>".htmlentities("\n ***Found more than one <ul> tag") . '<.span>\n');
}
} catch(Exception $ex) {
error_log(htmlentities('***Did not find a <ul> tag') . "\n");
}

echo ($grade .' out of ' . $possgrade ."\n\n");
$possgrade+=1; //progress tags
print("Checking for progress tags...\n");
try {
$nodes = $dom->getElementsByTagName('progress');
if ($nodes->length == 3) {
    print("<span class='correct'>Found three progress tags!</span>\n");
    $progress = array();
    foreach($nodes as $node) {
        $progress[] = $node;
    }
    $p = $progress[2]->parentNode;
    $p = explode('(', $p->nodeValue);
    if (substr($p[1], 3) == '67%') {
        print("<span>".htmlentities("\n ***Value of third <progress> tag not changed") . "</span>\n");
    }
    else {
        print(htmlentities('<progress> tags formatted properly') . "\n");
        $grade += 1; 
    }
}
} catch(Exception $ex) {
print("<span>".htmlentities('***Did not find <progress> tags')."</span>");

error_log(htmlentities('***Did not find <progress> tags'));
}

echo ($grade .' out of ' . $possgrade ."\n\n");
$possgrade+=1; //details + summary tag

    print("Checking for details tag...\n");

try {
$nodes = $dom->getElementsByTagName('details');
if ($nodes->length == 1) {
    $details = array();
    foreach ($nodes as $node) {
        $children = $node->childNodes;
        foreach ($children as $child) {
            $details[] = $child;
        }
    }
    if ($details[0]->tagName !== 'summary') {
        print("<span>".htmlentities("\n ***Missing <summary> tag") . "</span>\n");
    }
    if ($details[1]->tagName !== 'p') {
        print("<span>".htmlentities("\n ***Missing <p> tag in <details>") . "</span>\n");
    }
    elseif (trim(strtolower($details[1]->nodeValue)) == 'i grew up in ashtabula ohio. i lived near
        lake erie and i really miss the sunsets over the water.') {
        print("<span>".htmlentities('***Content of <p> tag in <details> was not changed') . "</span>\n");
    }
    else {
        print("<span class='correct'>".htmlentities('<details> tag properly formatted.') . "</span>\n");
        $grade += 1; 
    }
}
else {
    print("<span>".htmlentities('***Did not find <details> tag or found more than one') . "</span>\n");
}
} catch(Exception $ex) {
print(htmlentities('<span>Did not find <details> tag.</span>'));
error_log(htmlentities('Did not find <details> tag.'));
}

echo ($grade .' out of ' . $possgrade ."\n\n");
$possgrade+=1; //footer, link tags
    print("Checking for footer tag...\n");

try {
$nodes = $dom->getElementsByTagName('footer');
if ($nodes->length==1){
    print("<span class='correct'>Found footer tag!</span>\n");
    $grade += 1; 
    echo ($grade .' out of ' . $possgrade ."\n\n");

    $footer = array();
    foreach ($nodes as $node) {
        $items = $node->childNodes;
        foreach ($items as $item) {
            $footer[] = $item;
        }
    }
    $possgrade+=1;

    if ($footer[0]->tagName == 'p') {
        $footer_p = array();
        $children = $footer[0]->childNodes;
        foreach ($children as $child) {
            $footer_p[] = $child;
        }
            print("Checking for img tag in paragraph tag in the footer...\n");

        if ($footer_p[1]->tagName == 'img') {
            print("<span class='correct'>".htmlentities("Found <img> tag in footer <p> tag") . "</span>\n");
            if ($footer_p[1]->getAttribute('src') !== 'http://www.intro-webdesign.com/images/newlogo.png') {
                print("<span>".htmlentities('***<img> tag  has incorrect src attribute') . "</span>\n");
            }
            elseif (!$footer_p[1]->getAttribute('alt')) {
                print("<span>".htmlentities('<img> tag is missing alt attribute') . "</span>\n");
            }
            else {
                print(htmlentities('<img> tag properly formatted') . "\n");
                $grade += 1; 
            }
        }
        else {
            print("<span>".htmlentities('***<img> tag is not first element within <p> tag of footer') . "</span>\n");
        }
        echo ($grade .' out of ' . $possgrade ."\n\n");

        $possgrade+=1;
        print("Checking for a tag the footer...\n");
        if ($footer_p[2]->wholeText) {
            $text = explode('by ', $footer_p[2]->wholeText);
            $text = explode(' ', $text[1]);
            if (strtolower($text[1]) == 'name') {
                print('***Name in footer not changed from example page' . "</span>\n");
            }
        }
        else {
            print("<span>".htmlentities('<p> tag text missing from footer')."</span>");
        }
        if ($footer_p[3]->tagName == 'a') {
            print(htmlentities('Found <a> tag in footer <p> tag') . "\n");
            if ($footer_p[3]->getAttribute('href') !== 'http://www.intro-webdesign.com' && $footer_p[3]->getAttribute('href') !== 'http://www.intro-webdesign.com/' ) {
                print("<span>".htmlentities('<span>***Wrong href attribute for <a> tag in the <p> tag of the footer') . "</span>\n");
            }
            else {
                print(htmlentities('<a> tag in <p> tag of footer properly formatted') . "\n");
                $grade += 1; 
            }
        }
        else {
            print(htmlentities('<span>***No <a> tag found in <p> tag of footer') . "</span>\n");
        }
    }
    else {
        print(htmlentities('<span>Missing <p> tag from footer') . "</span>\n");
    }
}
else
     print("<span>***Did NOT find footer tag or found more than one!\n" . "</span>\n");
} catch(Exception $ex){
print("<span>***Did not find footer tag!</span>");
error_log("***Did not find footer tag!");
}

echo ($grade .' out of ' . $possgrade ."\n\n");
echo ("\n\nYour score is  " . $grade/$possgrade . "\n\n");


$gradetosend = $grade/$possgrade;
$scorestr = "Your answer is correct, score saved.";

if ( $oldgrade > $gradetosend ) {
    $scorestr = "New score of $gradetosend is < than previous grade of $oldgrade, previous grade kept";
    $gradetosend = $oldgrade;
}

// Use LTIX to send the grade back to the LMS.
$debug_log = array();
$retval = LTIX::gradeSend($gradetosend, false, $debug_log);

if ( $retval === true ) {
    echo($scorestr."\n\n");
    } else if ( is_string($retval) ) {
        echo("Grade not sent: ".$retval."\n\n");
    } else {
        echo("<pre>\n");
        var_dump($retval);
        echo("</pre>\n");
    }


