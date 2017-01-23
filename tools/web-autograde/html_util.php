<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\Net;
use \Tsugi\Blob\BlobUtil;

/* Return:
 * (1) False - no data
 * (2) A string - it is an error
 * (3) True - things are good and the html is in the session
 */
function checkHTMLPost() {
    if ( ! isset($_FILES['html_01']) ) return false;

    $fdes = $_FILES['html_01'];
    $filename = isset($fdes['name']) ? basename($fdes['name']) : false;
     // Check to see if they left off a file
    if( $fdes['error'] == 4) {
        return 'Missing file, make sure to select all files before pressing submit';
    }

    $data = BlobUtil::uploadFileToString($fdes, false);
    if ( $data === false ) {
        return 'Could not retrieve file data';
    }

    if ( count($data) > 250000 ) {
        return 'Please upload a file less than 250K';
    }

    $dom = new \DOMDocument;
    $retval = @$dom->loadHTML($data);
    if ( $retval !== true ) {
        
        echo("<pre>\n");
        echo("Unable to parse your HTML\n");
        echo(htmlentities($data));
        echo("\n");
        die();
    }
    
    // Put the data into session to allow us to process this in the GET request
    $_SESSION['html_data'] = $data;
    return true;
}

function validateHTML($data) {
    global $CFG;
    $val_error=false;
    if ( $CFG->OFFLINE ) {
        echo("Skipped validator because we are offline\n");
    } else {
        $validator = 'https://validator.w3.org/nu/?out=json&parser=html5';
        echo("Sending ".strlen($data)." characters to the validator.\n$validator ...\n");
        $return = Net::doBody($validator, "POST", $data,
            "Content-type: text/html; charset=utf-8\nUser-Agent: Autograder_www.wa4e.com");

        // echo(htmlentities(LTI::jsonIndent($return)));
        $json = json_decode($return);
        if ( !isset($json->messages) || ! is_array($json->messages) ) {
            echo "<span>Did not get a correct response from the validator</span>\n";
            echo "URL: ".htmlentities($validator)."\n";
            echo "Data length: ".strlen($return)."\n";
            echo("Validator Output:\n");
            echo(htmlentities(LTI::jsonIndent($return)));
            unset($_SESSION['html_data']);
            return false;
        }

        foreach($json->messages as $item)
        {
            if($item->type == "error")
            {
                // echo("Validator Output:\n");
                // echo(htmlentities(LTI::jsonIndent($return)));
                unset($_SESSION['html_data']);
                return false;
            }
        }
    }
    return true;
}
