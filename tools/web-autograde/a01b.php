<?php
use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\Net;
require_once $CFG->dirroot."/core/blob/blob_util.php";
error_reporting(0); 
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
    $data = uploadFileToString($fdes, false);
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
// First validate using
// https://github.com/validator/validator/wiki/Service:-Input:-POST-body
$validator = 'https://validator.w3.org/nu/?out=json&parser=html5';
echo("Calling the validator $validator ... \n");
$return = Net::doBody($validator, "POST", $data, 'Content-type: text/html; charset=utf-8');
$json = json_decode($return);
$val_error=false;
foreach($json->messages as $item)
{
    if($item->type == "error")
    {
        echo "Found error";
        // echo("Validator Output:\n");
        // echo(htmlentities(jsonIndent($return)));
        $val_error=true;
        break;
    }
}
if ($val_error){
  echo "Your code did not validate.  Please return to the W3 validator at validator.w3.org to check your code.";
  exit;
}
else{
    echo "Your code validated!<br/>";
    $dom = new DOMDocument;
    @$dom->loadHTML($data);
    print("Checking for specific components.<br/>");
    $possgrade+=2; //html + lang
    try {
      $nodes = $dom->getElementsByTagName('html');
      if ($nodes->length==1){
        print("Found html tag! <br/>");
        $grade+=1;
        print("...is English language specified?");
        foreach ($nodes as $p) //go to each section 1 by 1 
        {
            if ($p->getAttribute('lang')==="en"){
                print("...Found it!!<br>");
                 $grade+=1;
            }
            else{
                print("***Didn't find it!!<br>");
            }
        }
     }
     else
        print("***Did NOT find html tag!<br>");
    }catch(Exception $ex){
        error_log("***Did not find html tag!<br>");
    }
    echo ($grade .' out of ' . $possgrade .'<br/><br/>');
    $possgrade+=3; //head + meta + title
    try {
      $nodes = $dom->getElementsByTagName('head');
      if ($nodes->length==1){
        print("Found head tag!\n");
        $grade+=1;
        print("...looking for meta charset...");
        try {
            $nodes = $dom->getElementsByTagName('meta');
            foreach ($nodes as $p) //go to each section 1 by 1 
            {
                if ($p->getAttribute('charset')!=null){
                    print("...Found it!!<br>");
                    $grade+=1;
                }
                else{
                    print("\n***Didn't find it!!<br>");
                }
            }   
        } catch(Exception $ex){
            error_log("***Did not find meta tag!<br>");
        }
        print("...looking for title...");
        try {
            $nodes = $dom->getElementsByTagName('title');
            if ($nodes->length==1){
                print("...Found it!!<br>");
                $grade+=1;
            }
            else{
                print("\n***Didn't find it!!<br>");
            }
        }catch(Exception $ex){
            error_log("***Did not find title tag!<br>");
        }
      }
    }catch(Exception $ex){
        error_log("***Did not find head tag!<br>");
    }
  
    echo ($grade .' out of ' . $possgrade .'<br/><br/>');
    $possgrade+=1; //body tag
    try {
     $nodes = $dom->getElementsByTagName('body');
     if ($nodes->length==1){
        print("Found body tag!<br>");
        $grade+=1;
        }
      else
         print("***Did NOT find body tag or found more than one!<br>");
    }catch(Exception $ex){
        error_log("***Did not find body tag!");
    }
    echo ($grade .' out of ' . $possgrade .'<br/><br/>');
    $possgrade+=1; //header tag
try {
    $nodes = $dom->getElementsByTagName('header');
    if ($nodes->length==1){
        print("Found header tag!<br>");
        $grade+=1;
    }
    else{
         print("***Did NOT find header tag or found more than one!<br>");
     }
}catch(Exception $ex){
    error_log("***Did not find header tag!");
}
 echo ($grade .' out of ' . $possgrade .'<br/><br/>');
    $possgrade+=1; //h1 tag
try {
    $nodes = $dom->getElementsByTagName('h1');
    if ($nodes->length==1){
        foreach ($nodes as $node) {
            $h1 = $node;
        }
        if (trim(strtolower($h1->nodeValue) == 'colleen van lent')) {
            print(htmlentities('<h1> tag text not changed from example page. <br>') .'<br>');
        }
        else {
            print(htmlentities('<h1> tag formatted properly') . '<br>');
            $grade += 1; 
        }
    }
    else{
         print("...***Did NOT find h1 tag or found more than one!\n" .'<br>');
     }
}catch(Exception $ex){
    error_log("***Did not find h1 tag!");
}
    echo ($grade .' out of ' . $possgrade .'<br/><br/>');
    $possgrade+=1; //h2 tags
try {
    $nodes = $dom->getElementsByTagName('h2');
    if ($nodes->length === 3) {
        print(htmlentities('Found three <h2> tags') .'<br>');
        $grade += 1; 
    }
    else {
        print(htmlentities('***Found more or less than three <h2> tags') .'<br>');
    }
}
catch(Exception $ex) {
    error_log(htmlentities('***Did not find any <h2> tags'));
}
    echo ($grade .' out of ' . $possgrade .'<br/><br/>');
    $possgrade+=1; //h2 nav
try {
    $nodes = $dom->getElementsByTagName('nav');
    if ($nodes->length==1){
        print("Found nav tag!<br>");
        $grade+=1;
    }
    else{
         print("...***Did NOT find nav tag or found more than one!\n <br>");
     }
}catch(Exception $ex){
    error_log("***Did not find nav tag!");
}
    echo ($grade .' out of ' . $possgrade .'<br/><br/>');
    $possgrade+=1; //h2 sections
try {
    $nodes = $dom->getElementsByTagName('section');
    if ($nodes->length==3){
        print("Found three section tags!<br>");
        $grade+=1;
    }
    else
         print("***Did NOT find three sections tags\n <br>");
}catch(Exception $ex){
    error_log("***Did not find 3 section tags!");
}
echo ($grade .' out of ' . $possgrade .'<br/><br/>');
print("Searching for four links in the nav...<br>");
$possgrade+=1; //h2 links
try {
    $nav = $dom->getElementsByTagName('nav');
    $nav_links_all = array();
    foreach ($nav as $navlinks) {
        $navlinks = $navlinks->childNodes;
        $count=0;
        foreach ($navlinks as $link) {
            $nav_links_all[] = $link;
            if ($link->tagName === "a") {
                $count+=1;
                print("Found ". $count . '....');
            }
        }
        if ($count==4){
            print("Found them all!<br>");
            if (trim(strtolower($nav_links_all[6]->nodeValue)) !== 'four') {
                print(htmlentities("\n Fourth <a> tag's text was changed") .'<br>');
                $grade += 1; 
                echo($grade . " out of ". $possgrade);
            }
            else {
                print(htmlentities('***Fourth <a> tag text was not changed') .'<br>');
            }
        }
        else
            print("\n****Did not find four links in the nav section <br>");
        }
} catch(Exception $ex) {
    print("***Did not find links in the navigation");
    $navlinks = "";
}
    echo ($grade .' out of ' . $possgrade .'<br/><br/>');
    $possgrade+=1; //ul tag + li tags
try {
    $nodes = $dom->getElementsByTagName('ul');
    $list_items = array();
    if ($nodes->length == 1) {
        foreach ($nodes as $node) {
            $items = $node->childNodes;
            $count = 0;
            foreach ($items as $item) {
                $list_items[] = $item;
                if ($item->tagName === 'li') {
                    $count += 1;
                }
            }
        }
        if ($count == 4) {
            print('Found four list items<br>');
            $lcount = 0;
            foreach ($list_items as $item) {
                if (trim(strtolower($item->nodeValue)) == 'apples' || trim(strtolower($item->nodeValue)) == 'pizza' ||
                    trim(strtolower($item->nodeValue)) == 'crab' || trim(strtolower($item->nodeValue)) == 'chocolate cake') {
                    $lcount += 1;
                }
            }
            if ($lcount) {
                print('***' . $lcount . ' list ' . ($lcount == 1 ? 'item is' : 'items are') . ' the same as the example page<br>');
            }
            else {
                print('All list items formatted properly<br>');
                $grade += 1; 
            }
        }
        else {
            print("\n ***Found less or more than four list items<br>");
        }
    }
    else {
        print(htmlentities("\n ***Found more than one <ul> tag") .'<br>');
    }
} catch(Exception $ex) {
    error_log(htmlentities('***Did not find a <ul> tag') .'<br>');
}
    echo ($grade .' out of ' . $possgrade .'<br/><br/>');
    $possgrade+=1; //progress tags
try {
    $nodes = $dom->getElementsByTagName('progress');
    if ($nodes->length == 3) {
        print("Found three progress tags" . '<br>');
        $progress = array();
        foreach($nodes as $node) {
            $progress[] = $node;
        }
        $p = $progress[2]->parentNode;
        $p = explode('(', $p->nodeValue);
        if (substr($p[1], 0, 3) == '67%') {
            print(htmlentities("\n ***Value of third <progress> tag not changed") .'<br>');
        }
        else {
            print(htmlentities('<progress> tags formatted properly') .'<br>');
            $grade += 1; 
        }
    }
} catch(Exception $ex) {
    error_log(htmlentities('***Did not find <progress> tags'));
}
 echo ($grade .' out of ' . $possgrade .'<br/><br/>');
    $possgrade+=1; //details + summary tag
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
            print(htmlentities("\n ***Missing <summary> tag") .'<br>');
        }
        if ($details[1]->tagName !== 'p') {
            print(htmlentities("\n ***Missing <p> tag in <details>") .'<br>');
        }
        elseif (trim(strtolower($details[1]->nodeValue)) == 'i grew up in ashtabula ohio. i lived near
            lake erie and i really miss the sunsets over the water.') {
            print(htmlentities('***Content of <p> tag in <details> was not changed') .'<br>');
        }
        else {
            print(htmlentities('<details> tag properly formatted.') .'<br>');
            $grade += 1; 
        }
    }
    else {
        print(htmlentities('***Did not find <details> tag or found more than one') .'<br>');
    }
} catch(Exception $ex) {
    error_log(htmlentities('Did not find <details> tag.'));
}
 echo ($grade .' out of ' . $possgrade .'<br/><br/>');
    $possgrade+=3; //footer, link tags
try {
    $nodes = $dom->getElementsByTagName('footer');
    if ($nodes->length==1){
        print("Found footer tag!\n" . '<br>');
        $grade += 1; 
        $footer = array();
        foreach ($nodes as $node) {
            $items = $node->childNodes;
            foreach ($items as $item) {
                $footer[] = $item;
            }
        }
        if ($footer[0]->tagName == 'p') {
            $footer_p = array();
            $children = $footer[0]->childNodes;
            foreach ($children as $child) {
                $footer_p[] = $child;
            }
            if ($footer_p[1]->tagName == 'img') {
                print(htmlentities('Found <img> tag in footer <p> tag') .'<br>');
                if ($footer_p[1]->getAttribute('src') !== 'http://www.intro-webdesign.com/images/newlogo.png') {
                    print(htmlentities('***<img> tag  has incorrect src attribute') .'<br>');
                }
                elseif (!$footer_p[1]->getAttribute('alt')) {
                    print(htmlentities('<img> tag is missing alt attribute') .'<br>');
                }
                else {
                    print(htmlentities('<img> tag properly formatted') .'<br>');
                    $grade += 1; 
                }
            }
            else {
                print(htmlentities('***<img> tag is not first element within <p> tag of footer') .'<br>');
            }
            if ($footer_p[2]->wholeText) {
                $text = explode('by ', $footer_p[2]->wholeText);
                $text = explode(' ', $text[1]);
                if (strtolower($text[1]) == 'name') {
                    print('***Name in footer not changed from example page' .'<br>');
                }
            }
            else {
                print(htmlentities('<p> tag text missing from footer'));
            }
            if ($footer_p[3]->tagName == 'a') {
                print(htmlentities('Found <a> tag in footer <p> tag') .'<br>');
                if ($footer_p[3]->getAttribute('href') !== 'http://www.intro-webdesign.com') {
                    print(htmlentities('***Wrong href attribute for <a> tag in the <p> tag of the footer') .'<br>');
                }
                else {
                    print(htmlentities('<a> tag in <p> tag of footer properly formatted') .'<br>');
                    $grade += 1; 
                }
            }
            else {
                print(htmlentities('***No <a> tag found in <p> tag of footer') .'<br>');
            }
        }
        else {
            print(htmlentities('Missing <p> tag from footer') .'<br>');
        }
    }
    else
         print("***Did NOT find footer tag or found more than one!\n" .'<br>');
} catch(Exception $ex){
    error_log("***Did not find footer tag!");
}
echo ($grade .' out of ' . $possgrade .'<br/><br/>');
echo ("\n\nYour score is  " . $grade/$possgrade . "\n\n");
}
    $gradetosend = $grade/$possgrade;
    $scorestr = "Your answer is correct, score saved.";
   
    if ( $oldgrade > $gradetosend ) {
        $scorestr = "New score of $gradetosend is < than previous grade of $oldgrade, previous grade kept";
        $gradetosend = $oldgrade;
    }
    // Use LTIX to send the grade back to the LMS.
    $debug_log = array();
    $retval = LTIX::gradeSend($gradetosend, false, $debug_log);
    $_SESSION['debug_log'] = $debug_log;
    if ( $retval === true ) {
        $_SESSION['success'] = $scorestr;
    } else if ( is_string($retval) ) {
        $_SESSION['error'] = "Grade not sent: ".$retval;
    } else {
        echo("<pre>\n");
        var_dump($retval);
        echo("</pre>\n");
        die();
    }
exit;
    // Redirect to ourself
    header('Location: '.addSession('index.php'));
    return;