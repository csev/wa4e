<?php
require_once "top.php";
?>
<style>
    .card {
        border: 1px solid black;
        margin: 5px;
        padding: 5px;
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

echo('<div id="container">'."\n");

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

if ( $anchor !== null || $index !== null ) {

    $count = 0;
    $module = false;
    $position = false;
    foreach($lessons->modules as $mod) {
        $count++;
        if ( $anchor !== null && isset($mod->anchor) && $anchor != $mod->anchor ) continue;
        if ( $index !== null && $index != $count ) continue;
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
        echo('<p>'.$module->description."</p>\n");
        echo("<ul>\n");
        if ( isset($module->slides) ) {
            echo('<li><a href="'.$module->slides.'" target=="_blank">Slides</a></li>'."\n");
        }
        if ( isset($module->chapters) ) {
            echo('<li>Chapters: '.$module->chapters.'</a></li>'."\n");
        }
        if ( isset($module->assignment) ) {
            echo('<li><a href="'.$module->assignment.'" target=="_blank">Assignment Specification</a></li>'."\n");
        }
        if ( isset($module->solution) ) {
            echo('<li><a href="'.$module->solution.'" target=="_blank">Assignment Solution</a></li>'."\n");
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
    }

} else {
    echo('<h1>'.$lessons->title."</h1>\n");
    echo('<p>'.$lessons->description."</p>\n");
    echo('<div id="box">'."\n");
    $waterfall = true;
    $count = 0;
    foreach($lessons->modules as $module) {
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
        $desc = $module->description;
        if ( strlen($desc) > 100 ) $desc = substr($desc, 0, 100) . " ...";
        echo('<p>'.$desc."</p>\n");
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

