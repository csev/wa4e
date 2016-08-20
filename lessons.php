<?php
use \Tsugi\Util\LTI;
use \Tsugi\Core\LTIX;

require_once "top.php";
?>
<style>
    .card {
        border: 1px solid black;
        margin: 5px;
        padding: 5px;
        min-height: 8em;
    }
#loader {
      position: fixed;
      left: 0px;
      top: 0px;
      width: 100%;
      height: 100%;
      background-color: white;
      margin: 0;
      z-index: 100;
}
</style>
<?php
require_once "nav.php";
$anchor = isset($_GET['anchor']) ? $_GET['anchor'] : null;
$index = isset($_GET['index']) ? $_GET['index'] : null;
$waterfall = false;

if ( isset($_GET['lti_errormsg']) ) {
    $_SESSION['error'] = $_GET['lti_errormsg'];
}

echo('<div id="container">'."\n");

$OUTPUT->flashMessages();
if ( isset($_GET['detail']) ) {
    echo("\n<!--\n");
    echo(str_replace("-->","--:>",$_GET['detail']));
    echo("\n-->\n");
}

$json_str = file_get_contents('lessons.json');
$lessons = json_decode($json_str);

if ( $lessons === null ) {
    echo("<pre>\n");
    echo("Problem parsing lessons.json: ");
    echo(json_last_error_msg());
    echo("\n");
    echo($json_str);
    die();
}

// Filter modules based on login
if ( !isset($_SESSION['id']) ) {
    $filtered_modules = array();
    $filtered = false;
    foreach($lessons->modules as $module) {
	    if ( isset($module->login) && $module->login ) {
            $filtered = true;
            continue;
        }
        $filtered_modules[] = $module;
    }
    if ( $filtered ) $lessons->modules = $filtered_modules;
}

if ( $anchor !== null || $index !== null ) {

    $count = 0;
    $module = false;
    $position = false;
    foreach($lessons->modules as $mod) {
	if ( isset($mod->login) && $mod->login && !isset($_SESSION['id']) ) continue;
        $count++;
        if ( $anchor !== null && isset($mod->anchor) && $anchor != $mod->anchor ) continue;
        if ( $index !== null && $index != $count ) continue;
        if ( $anchor == null && isset($module->anchor) ) $anchor = $module->anchor;
        $module = $mod;
        $position = $count;
    }
    if ( $module != null ) {
        echo('<div style="float:right; padding-left: 5px; vertical-align: text-top;"><ul class="pager">'."\n");
        $disabled = ($position == 1) ? ' disabled' : '';
        if ( $position == 1 ) {
            echo('<li class="previous disabled"><a href="#" onclick="return false;">&larr; Previous</a></li>'."\n");
        } else {
            $prev = 'index='.($position-1);
            if ( isset($lessons->modules[$position-2]->anchor) ) {
                $prev = 'anchor='.$lessons->modules[$position-2]->anchor;
            }
            echo('<li class="previous"><a href="lessons.php?'.$prev.'">&larr; Previous</a></li>'."\n");
        }
        echo('<li><a href="lessons.php">All ('.$position.' / '.count($lessons->modules).')</a></li>');
        if ( $position >= count($lessons->modules) ) {
            echo('<li class="next disabled"><a href="#" onclick="return false;">&rarr; Next</a></li>'."\n");
        } else {
            $next = 'index='.($position+1);
            if ( isset($lessons->modules[$position]->anchor) ) {
                $next = 'anchor='.$lessons->modules[$position]->anchor;
            }
            echo('<li class="next"><a href="lessons.php?'.$next.'">&rarr; Next</a></li>'."\n");
        }
        echo("</ul></div>\n");
        echo('<h1>'.$module->title."</h1>\n");
        if ( isset($module->description) ) {
            echo('<p>'.$module->description."</p>\n");
        }

        echo("<ul>\n");
        if ( isset($module->slides) ) {
            echo('<li><a href="'.$module->slides.'" target="_blank">Slides</a></li>'."\n");
        }
        if ( isset($module->chapters) ) {
            echo('<li>Chapters: '.$module->chapters.'</a></li>'."\n");
        }
        if ( isset($module->assignment) ) {
            echo('<li><a href="'.$module->assignment.'" target="_blank">Assignment Specification</a></li>'."\n");
        }
        if ( isset($module->solution) ) {
            echo('<li><a href="'.$module->solution.'" target="_blank">Assignment Solution</a></li>'."\n");
        }
        if ( isset($module->videos) ) {
            if ( is_array($module->videos) ) {
                echo("<li>Videos:<ul>\n");
                foreach($module->videos as $video ) {
                    echo('<li><a href="https://www.youtube.com/watch?v='.
                        $video->youtube.'" target="_blank">'.
                        $video->title."</a></li>\n");
                }
                echo("</ul></li>\n");
            } else {
                echo('<li>Video: <a href="https://www.youtube.com/watch?v='.
                    $module->videos->youtube.'" target="_blank">'.
                    $module->videos->title."</a></li>\n");
            }
        }
        if ( isset($module->references) ) {
            if ( is_array($module->references) ) {
                echo("<li>References:<ul>\n");
                foreach($module->references as $reference ) {
                    echo('<li><a href="'.$reference->href.'" target="_blank">'.
                        $reference->title."</a></li>\n");
                }
                echo("</ul></li>\n");
            } else {
                echo('<li>Reference: <a href="'.
                    $module->references->href.'" target="_blank">'.
                    $module->references->title."</a></li>\n");
            }
        }

        if ( isset($module->lti) && isset($_SESSION['secret']) ) {
            $ltis = $module->lti;
            if ( ! is_array($ltis) ) {
                $ltis = array($ltis);
            }

            if ( count($ltis) > 1 ) echo("<li>Tools:<ul> <!-- start of ltis -->\n");
            foreach($ltis as $lti ) {
                $key = isset($_SESSION['oauth_consumer_key']) ? $_SESSION['oauth_consumer_key'] : false;
                $secret = isset($_SESSION['secret']) ? $_SESSION['secret'] : false;

                $resource_link_id = 'resource:';
                if ( $anchor != null ) $resource_link_id .= $anchor . ':';
                if ( $index != null ) $resource_link_id .= $index . ':';
                $resource_link_id .= md5($CFG->context_title);
                $resource_link_title = isset($lti->title) ? $lti->title : $module->title;
                $parms = array(
                    'lti_message_type' => 'basic-lti-launch-request',
                    'resource_link_id' => $resource_link_id,
                    'resource_link_title' => $resource_link_title,
                    'tool_consumer_info_product_family_code' => 'tsugi',
                    'tool_consumer_info_version' => '1.1',
                    'context_id' => 'course:'.md5($CFG->context_title),
                    'context_label' => $CFG->context_title,
                    'context_title' => $CFG->context_title,
                    'user_id' => 'google:'.md5($_SESSION['email']),
                    'user_image' => $_SESSION['avatar'],
                    'lis_person_name_full' => $_SESSION['displayname'],
                    'lis_person_contact_email_primary' => $_SESSION['email'],
                    'roles' => 'Learner'
                );

                if ( isset($lti->custom) ) {
                    foreach($lti->custom as $custom) {
                        if ( isset($custom->value) ) {
                            $parms['custom_'.$custom->key] = $custom->value;
                        }
                        if ( isset($custom->json) ) {
                            $parms['custom_'.$custom->key] = json_encode($custom->json);
                        }
                    }
                }

                $return_url = $CFG->getCurrentUrl();
                if ( $anchor ) $return_url .= '?anchor='.urlencode($anchor);
                elseif ( $index ) $return_url .= '?index='.urlencode($index);
                $parms['launch_presentation_return_url'] = $return_url;

                if ( isset($_SESSION['tsugi_top_nav']) ) {
                    $parms['ext_tsugi_top_nav'] = $_SESSION['tsugi_top_nav'];
                }

                $form_id = "tsugi_form_id_".bin2Hex(openssl_random_pseudo_bytes(4));
                $parms['ext_lti_form_id'] = $form_id;

                $endpoint = $CFG->apphome . '/' . $lti->launch;
                $parms = LTI::signParameters($parms, $endpoint, "POST", $key, $secret,
                    "Finish Launch", $CFG->product_instance_guid, $CFG->servicename);

                $content = LTI::postLaunchHTML($parms, $endpoint, false /*debug */, '_pause');
                $title = isset($lti->title) ? $lti->title : "Autograder";
                echo('<li><a href="#" onclick="document.'.$form_id.'.submit();return false">'.htmlentities($title).'</a></li>'."\n");
                echo("<!-- Start of content -->\n");
                print($content);
                echo("<!-- End of content -->\n");
            }

            if ( count($ltis) > 1 ) echo("</li></ul><!-- end of ltis -->\n");
        }
    }
    if ( !isset($module->discuss) ) $module->discuss = true;
    if ( !isset($module->anchor) ) $module->anchor = $position;
    if ( isset($CFG->disqushost) && isset($_SESSION['id']) && $module->discuss ) {
?>
<hr/>
<div id="disqus_thread" style="margin-top: 30px;"></div>
<script>

/**
 *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
 *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables */
var disqus_config = function () {
    this.page.url = '<?= $CFG->disqushost ?>';  // Replace PAGE_URL with your page's canonical URL variable
    this.page.identifier = '<?= $module->anchor ?>'; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
};
(function() { // DON'T EDIT BELOW THIS LINE
    var d = document, s = d.createElement('script');
    s.src = '//php-intro.disqus.com/embed.js';
    s.setAttribute('data-timestamp', +new Date());
    (d.head || d.body).appendChild(s);
})();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                                    
<?php
    }

} else {
    echo('<h1>'.$lessons->title."</h1>\n");
    echo('<p>'.$lessons->description."</p>\n");
    echo('<div id="box">'."\n");
    $waterfall = true;
    $count = 0;
    foreach($lessons->modules as $module) {
	if ( isset($module->login) && $module->login && !isset($_SESSION['id']) ) continue;
        $count++;
        echo('<div class="card">'."\n");
        if ( isset($module->anchor) ) {
            $href = 'lessons.php?anchor='.htmlentities($module->anchor);
        } else {
            $href = 'lessons.php?index='.$count;
        }
        if ( isset($module->icon) ) {
            echo('<i class="fa '.$module->icon.' fa-2x" aria-hidden="true" style="float: left; padding-right: 5px;"></i>');
        }
        echo('<a href="'.$href.'">'."\n");
        echo('<p>'.$count.': '.$module->title."</p>\n");
        if ( isset($module->description) ) {
            $desc = $module->description;
            if ( strlen($desc) > 100 ) $desc = substr($desc, 0, 100) . " ...";
            echo('<p>'.$desc."</p>\n");
        }
        echo("</a></div>\n");
   }
   echo('</div> <!-- box -->'."\n");
} // End of the anchor || index
?>
</div> <!-- container -->
<?php
$OUTPUT->footerStart();
// https://github.com/LinZap/jquery.waterfall
if ( $waterfall ) {
?>
<script type="text/javascript" src="<?= $CFG->staticroot ?>/js/waterfall-light.js"></script>
<script>
$(function(){
    $('#box').waterfall({refresh: 0})
});
</script>
<?php
}
$OUTPUT->footerend();

