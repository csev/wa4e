<?php include("top.php");?>
<?php include("nav.php");?>
<div id="iframe-dialog" title="Read Only Dialog" style="display: none;">
   <iframe name="iframe-frame" style="height:600px" id="iframe-frame" 
    src="<?= $OUTPUT->getSpinnerUrl() ?>"></iframe>
</div>
        <h2>Free / Open Educational Resources (OER)</h2>
        <p>
            You are welcome to use/reuse/remix/retain these materials in your own courses.
            Nearly all the material in this web site is Copyright Creative Commons Attribution.
        </p>
        <ul>
            <li>
                <a href="lectures/" target="_blank">Lecture Slides and Handouts</a>
            </li>
            <li>
                <a href="code/" target="_blank">Sample Code</a>
            </li>
            <li>
                <a href="https://www.youtube.com/playlist?list=PLlRFEj9H3Oj7FHbnXWviqQt0sKEK_hdKX" target="_blank">
                YouTube Channel</a>
            </li>
            <li>
                <a href="http://textbooks.opensuny.org/the-missing-link-an-introduction-to-web-development-and-programming/" target="_blank">Free Textbook</a>
            </li>
<li>
  <a href="tsugi/cc/select" title="Download course material" target="iframe-frame"
  onclick="showModalIframe(this.title, 'iframe-dialog', 'iframe-frame', _TSUGI.spinnerUrl, true);" >
  Download course material
  </a> as an IMS Common Cartridge®, to import into an LMS like Sakai, Moodle, Canvas,
Desire2Learn, Blackboard, or similar.
</li>
            <li>
                Free cloud hosted autograder software for non-commercial use. (Login and "Use This Service")
            </li>
            <li>
                All the course content and sotware is available on 
                <a href="https://github.com/csev/wa4e" target="_blank">
                Github</a> - you could literally make a copy of this site and host it as your own.
                Also you could make a copy of the site and translate everything into another language.
            </li>
        </ul>
        <p>
        If you are interested in translating the book or other online materials into another 
        language, please contact me so we can coordinate out sctivities.
        </p>


<?php include("foot.php"); ?>

