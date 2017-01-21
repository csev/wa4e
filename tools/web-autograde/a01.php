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

// First validate using
// https://github.com/validator/validator/wiki/Service:-Input:-POST-body

$validator = 'https://validator.w3.org/nu/?out=json&parser=html5';
echo("<h2>Calling the validator $validator ... </h2>\n");
$return = Net::doBody($validator, "POST", $data, 
    'Content-type: text/html; charset=utf-8
User-Agent: Autograder_www.wa4e.com');
// X-User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.101 Safari/537.36');


echo(htmlentities(LTI::jsonIndent($return)));
$json = json_decode($return);
$val_error=false;
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


if ($val_error){
  echo "Your code did not validate.  Please return to the W3 validator at validator.w3.org to check your code.";
  exit;
}
else{
    echo "<h3>Your code validated!</h3><br/>";
    $dom = new DOMDocument;
    @$dom->loadHTML($data);

    print("<h2>Checking for specific components.</h2><br/>");
    print("<h3>Checking for html tag...</h3>");
    $possgrade+=1; //html + lang
    try {
      $nodes = $dom->getElementsByTagName('html');
      if ($nodes->length==1){
        print("<span class='correct'>Found it! </span><br/>");
        $grade+=1; 
        echo ($grade .' out of ' . $possgrade .'<br/><br/>');
        print("<h3>Checking that English language is specified...</h3>");
        $possgrade+=1;
        foreach ($nodes as $p) //go to each section 1 by 1 
        {
            if ($p->getAttribute('lang')==="en"){
                print("<span class='correct'>Found it! </span><br/>");
                $grade+=1;
            }
            else{
                print("<span>***Didn't find it!!</span><br>");
            }
        }
     }
     else
        print("<span>***Did NOT find html tag!</span><br>");
    }catch(Exception $ex){
        print("<span>***Did not find html tag!</span><br>");
        error_log("***Did not find html tag!<br>");
    }

    echo ($grade .' out of ' . $possgrade .'<br/><br/>');
    
    print("<h3>Checking for head tag...</h3>\n");
    $possgrade+=1;

    try {
      $nodes = $dom->getElementsByTagName('head');
      if ($nodes->length==1){
        print("<span class='correct'>Found it! </span><br/>");

        $grade+=1;
        echo ($grade .' out of ' . $possgrade .'<br/><br/>');
        print("<h3>Checking for meta tag...</h3>\n");
        $possgrade+=1;

        try {
            $nodes = $dom->getElementsByTagName('meta');
            foreach ($nodes as $p) //go to each section 1 by 1 
            {
                if ($p->getAttribute('charset')!=null){
                    print("<span class='correct'>Found it! </span><br/>");
                    $grade+=1;
                }
                else{
                    print("\n<span>***Didn't find it!!</span><br>");
                }
            }   
        } catch(Exception $ex){
            print("<span>***Did not find meta tag!</span>" . '<br>');
            error_log("***Did not find meta tag!" . '<br>');
        }
        echo ($grade .' out of ' . $possgrade .'<br/><br/>');

        print("<h3>Checking for title tag...</h3>\n");
        $possgrade+=1;
        try {
            $nodes = $dom->getElementsByTagName('title');
            if ($nodes->length==1){
                print("<span class='correct'>Found it! </span><br/>");
                $grade+=1;
            }
            else{
                print("\n<span>***Found more than one!!</span><br>");
            }
        }catch(Exception $ex){
            print("<span>***Did not find title tag!</span><br>");
            error_log("***Did not find title tag!<br>");
        }
      }
    }catch(Exception $ex){
        print("<span>***Did not find head tag!</span><br>");
        error_log("***Did not find head tag!<br>");
    }
  
    echo ($grade .' out of ' . $possgrade .'<br/><br/>');
    $possgrade+=1; //body tag

    print("<h3>Checking for body tag...</h3>\n");

    try {

     $nodes = $dom->getElementsByTagName('body');
     if ($nodes->length==1){
        print("<span class='correct'>Found body tag!</span><br>");
        $grade+=1;
        }
      else
         print("***<span>Did NOT find body tag or found more than one!</span><br>");
    }catch(Exception $ex){
        print("<span>***Did not find body tag!</span>");
        error_log("***Did not find body tag!");
    }

    echo ($grade .' out of ' . $possgrade .'<br/><br/>');
    $possgrade+=1; //header tag
    print("<h3>Checking for header tag...</h3>\n");

try {
    $nodes = $dom->getElementsByTagName('header');
    if ($nodes->length==1){
        print("<span class='correct'>Found header tag!</span><br>");
        $grade+=1;
    }
    else{
         print("<span>***Did NOT find header tag or found more than one!</span><br>");
     }
}catch(Exception $ex){
    print("<span>***Did not find header tag!</span>");
    error_log("***Did not find header tag!");
}

 echo ($grade .' out of ' . $possgrade .'<br/><br/>');
    $possgrade+=1; //h1 tag
        print("<h3>Checking for h1 tag...</h3>\n");

try {
    $nodes = $dom->getElementsByTagName('h1');
    if ($nodes->length==1){
        foreach ($nodes as $node) {
            $h1 = $node;
        }
        if (trim(strtolower($h1->nodeValue) == 'colleen van lent')) {
            print("<span>".htmlentities('<h1> tag text not changed from example page. <br>'."</span>"));
        }
        else {
            print("<span class='correct'>".htmlentities("<h1> tag formatted properly")."</span>" . '<br>');
            $grade += 1; 
        }
    }
    else{
         print("...<span>Did NOT find h1 tag or found more than one!</span>\n" . '<br>');
     }
}catch(Exception $ex){
    print("<span>***Did not find h1 tag!</span>");
    error_log("***Did not find h1 tag!");
}

    echo ($grade .' out of ' . $possgrade .'<br/><br/>');
    $possgrade+=1; //h2 tags
    print("<h3>Checking for three h2 tags...</h3>\n");

try {
    $nodes = $dom->getElementsByTagName('h2');
    if ($nodes->length === 3) {
        print("<span class='correct'>".htmlentities("Found three <h2> tags") . '</span><br>');
        $grade += 1; 
    }
    else {
        print("<span>".(htmlentities('***Found more or less than three <h2> tags')) . '</span><br>');
    }
}
catch(Exception $ex) {
    print("<span>".htmlentities('***Did not find any <h2> tags')."</span><br/>");
    error_log(htmlentities('***Did not find any <h2> tags'));
}

    echo ($grade .' out of ' . $possgrade .'<br/><br/>');
    $possgrade+=1; //h2 nav
    print("<h3>Checking for nav tag...</h3>\n");
try {
    $nodes = $dom->getElementsByTagName('nav');
    if ($nodes->length==1){
        print("<span class='correct'>Found nav tag!</span><br>");
        $grade+=1;
    }
    else{
         print("<span>...***Found more than one nav tag!\n" . '</span><br>');
     }
}catch(Exception $ex){
    print("<span>***Did not find nav tag!</span>");
    error_log("***Did not find nav tag!");
}

    echo ($grade .' out of ' . $possgrade .'<br/><br/>');
    $possgrade+=1; //h2 sections
    print("<h3>Checking for section tags...</h3>\n");
try {
    $nodes = $dom->getElementsByTagName('section');
    if ($nodes->length==3){
        print("<span class='correct'>Found three section tags!</span><br>");
        $grade+=1;
    }
    else
         print("<span>***Did NOT find three sections tags</span>\n" . '<br>');
}catch(Exception $ex){
    print("<span>***Did not find 3 section tags!</span>");
}

echo ($grade .' out of ' . $possgrade .'<br/><br/>');
print("<h3>Searching for four links in the nav...</h3>" . '<br>');
$possgrade+=1; 

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
            print("<span class='correct'>Found all four links!</span><br/>");
            $grade+=1;
            echo ($grade .' out of ' . $possgrade .'<br/><br/>');


            $possgrade+=1;
            if (trim(strtolower($nav_links_all[6]->nodeValue)) !== 'four') {
                print("<span class='correct'>".htmlentities("\n Fourth <a> tag's text was changed") . '</span><br>');
                $grade += 1; 
            }
            else {
                print("<span>".htmlentities('***Fourth <a> tag text was not changed') . '</span><br>');
            }
        }
        else
            print("\n<span>****Did not find four links in the nav section" . '</span><br>');
        }
} catch(Exception $ex) {
    print("***Did not find links in the navigation");
    $navlinks = "";
}
    echo ($grade .' out of ' . $possgrade .'<br/><br/>');
    $possgrade+=1; //ul tag + li tags
print("<h3>Checking for four list items...</h3>\n");
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
            print("<span class='correct'>Found four list items!</span><br>");
            $lcount = 0;
            foreach ($list_items as $item) {
                // echo '<p>' . $item->nodeValue . '</p>';
                if (trim(strtolower($item->nodeValue)) == 'apples' || trim(strtolower($item->nodeValue)) == 'pizza' ||
                    trim(strtolower($item->nodeValue)) == 'crab' || trim(strtolower($item->nodeValue)) == 'chocolate cake') {
                    $lcount += 1;
                }
            }
            if ($lcount) {
                print('<span>***' . $lcount . ' list ' . ($lcount == 1 ? 'item is' : 'items are') . ' the same as the example page </span><br>');
            }
            else {
                print('All list items formatted properly' . '<br>');
                $grade += 1; 
            }
        }
        else {
            print("\n <span>***Found less or more than four list items" . '</span><br>');
        }
    }
    else {
        print("<span>".htmlentities("\n ***Found more than one <ul> tag") . '<.span><br>');
    }
} catch(Exception $ex) {
    error_log(htmlentities('***Did not find a <ul> tag') . '<br>');
}

    echo ($grade .' out of ' . $possgrade .'<br/><br/>');
    $possgrade+=1; //progress tags
    print("<h3>Checking for progress tags...</h3>\n");
try {
    $nodes = $dom->getElementsByTagName('progress');
    if ($nodes->length == 3) {
        print("<span class='correct'>Found three progress tags!</span><br>");
        $progress = array();
        foreach($nodes as $node) {
            $progress[] = $node;
        }
        $p = $progress[2]->parentNode;
        $p = explode('(', $p->nodeValue);
        if (substr($p[1], 3) == '67%') {
            print("<span>".htmlentities("\n ***Value of third <progress> tag not changed") . '</span><br>');
        }
        else {
            print(htmlentities('<progress> tags formatted properly') . '<br>');
            $grade += 1; 
        }
    }
} catch(Exception $ex) {
    print("<span>".htmlentities('***Did not find <progress> tags')."</span>");

    error_log(htmlentities('***Did not find <progress> tags'));
}

 echo ($grade .' out of ' . $possgrade .'<br/><br/>');
    $possgrade+=1; //details + summary tag

        print("<h3>Checking for details tag...</h3>\n");

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
            print("<span>".htmlentities("\n ***Missing <summary> tag") . '</span><br>');
        }
        if ($details[1]->tagName !== 'p') {
            print("<span>".htmlentities("\n ***Missing <p> tag in <details>") . '</span><br>');
        }
        elseif (trim(strtolower($details[1]->nodeValue)) == 'i grew up in ashtabula ohio. i lived near
            lake erie and i really miss the sunsets over the water.') {
            print("<span>".htmlentities('***Content of <p> tag in <details> was not changed') . '</span><br>');
        }
        else {
            print("<span class='correct'>".htmlentities('<details> tag properly formatted.') . '</span><br>');
            $grade += 1; 
        }
    }
    else {
        print("<span>".htmlentities('***Did not find <details> tag or found more than one') . '</span><br>');
    }
} catch(Exception $ex) {
    print(htmlentities('<span>Did not find <details> tag.</span>'));
    error_log(htmlentities('Did not find <details> tag.'));
}

 echo ($grade .' out of ' . $possgrade .'<br/><br/>');
    $possgrade+=1; //footer, link tags
        print("<h3>Checking for footer tag...</h3>\n");

try {
    $nodes = $dom->getElementsByTagName('footer');
    if ($nodes->length==1){
        print("<span class='correct'>Found footer tag!</span><br>");
        $grade += 1; 
        echo ($grade .' out of ' . $possgrade .'<br/><br/>');

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
                print("<h3>Checking for img tag in paragraph tag in the footer...</h3>\n");

            if ($footer_p[1]->tagName == 'img') {
                print("<span class='correct'>".htmlentities("Found <img> tag in footer <p> tag") . '</span><br>');
                if ($footer_p[1]->getAttribute('src') !== 'http://www.intro-webdesign.com/images/newlogo.png') {
                    print("<span>".htmlentities('***<img> tag  has incorrect src attribute') . '</span><br>');
                }
                elseif (!$footer_p[1]->getAttribute('alt')) {
                    print("<span>".htmlentities('<img> tag is missing alt attribute') . '</span><br>');
                }
                else {
                    print(htmlentities('<img> tag properly formatted') . '<br>');
                    $grade += 1; 
                }
            }
            else {
                print("<span>".htmlentities('***<img> tag is not first element within <p> tag of footer') . '</span><br>');
            }
            echo ($grade .' out of ' . $possgrade .'<br/><br/>');

            $possgrade+=1;
            print("<h3>Checking for a tag the footer...</h3>\n");
            if ($footer_p[2]->wholeText) {
                $text = explode('by ', $footer_p[2]->wholeText);
                $text = explode(' ', $text[1]);
                if (strtolower($text[1]) == 'name') {
                    print('***Name in footer not changed from example page' . '</span><br>');
                }
            }
            else {
                print("<span>".htmlentities('<p> tag text missing from footer')."</span>");
            }
            if ($footer_p[3]->tagName == 'a') {
                print(htmlentities('Found <a> tag in footer <p> tag') . '<br>');
                if ($footer_p[3]->getAttribute('href') !== 'http://www.intro-webdesign.com' && $footer_p[3]->getAttribute('href') !== 'http://www.intro-webdesign.com/' ) {
                    print("<span>".htmlentities('<span>***Wrong href attribute for <a> tag in the <p> tag of the footer') . '</span><br>');
                }
                else {
                    print(htmlentities('<a> tag in <p> tag of footer properly formatted') . '<br>');
                    $grade += 1; 
                }
            }
            else {
                print(htmlentities('<span>***No <a> tag found in <p> tag of footer') . '</span><br>');
            }
        }
        else {
            print(htmlentities('<span>Missing <p> tag from footer') . '</span><br>');
        }
    }
    else
         print("<span>***Did NOT find footer tag or found more than one!\n" . '</span><br>');
} catch(Exception $ex){
    print("<span>***Did not find footer tag!</span>");
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
    
    if ( $retval === true ) {
        echo($scorestr."<br/>\n");
    } else if ( is_string($retval) ) {
        echo("Grade not sent: ".$retval."<br/>\n");
    } else {
        echo("<pre>\n");
        var_dump($retval);
        echo("</pre>\n");
    }


