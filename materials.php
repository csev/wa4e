<?php include("top.php");?>
<?php include("nav.php");?>
<div id="iframe-dialog" title="Read Only Dialog" style="display: none;">
   <iframe name="iframe-frame" style="height:600px" id="iframe-frame" 
    src="<?= $OUTPUT->getSpinnerUrl() ?>"></iframe>
</div>
        <h2>Using these resources in a Learning Management System</h2>
<p>If you have a learning management system and would like to make use of this material in your LMS,
there are a number of options.
<ul>
<li><p>
If your LMS supports
<a href="https://www.imsglobal.org/specs/lticiv1p0" target="_blank">
Learning Tools Interoperability® Content-Item Message</a> you can
login and apply for an LTI 1.x key and secret and install this web site
into your LMS as an App Store / Learning Object Repository that allows
you to author you class in your LMS while selecting tools and content
from this site one item at a time.  You will be given instructions
on how to set up the "app store" in your LMS when you receive
your key and secret.
</p></li>
<li>
<p>
<a href="tsugi/cc/select" title="Download course material" target="iframe-frame"
  onclick="showModalIframe(this.title, 'iframe-dialog', 'iframe-frame', _TSUGI.spinnerUrl, true);" >
  Download course material
  </a> as an
<a href="https://www.imsglobal.org/cc/index.html" target="_blank">
IMS Common Cartridge®</a>, to import into an LMS like Sakai, Moodle, Canvas,
Desire2Learn, Blackboard, or similar.
After loading the Cartridge, you will need an LTI key and secret if you want to provision the
LTI-based tools provided in that cartridge.
</p>
</li>
<li><p>
If you are using <a href="https://classroom.google.com" target="_blank">Google Classroom</a>,
you can automatically link the resources in this site
into your classroom in the 
<a href="<?= $CFG->apphome ?>/lessons/intro?nostyle=yes">low-style view of the lessons</a>.
</p></li>
            <li><p>
                If you have access to
<a href="https://lor.instructure.com/resources/4ec64e664fac47679b43c74d64d3d6b7" target="_blank">Canvas Commons</a>,
the course material for the first 10 chapters of this book are available in
a CC-BY license.
            </p></li>
<li><p>
If your LMS supports neither Content Item, nor Common Cartridge
you can hand-copy the links from this course material into your LMS from the
<a href="<?= $CFG->apphome ?>/lessons/intro?nostyle=yes">low-style view of the lessons</a>.
</p></li>
        </ul>
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
</ul>
            <p>
                All the course content and sotware is available on 
                <a href="https://github.com/csev/wa4e" target="_blank">
                Github</a> - you could literally make a copy of this site and host it as your own.
                Also you could make a copy of the site and translate everything into another language.
            </p>
        <p>
        If you are interested in translating the book or other online materials into another 
        language, please contact me so we can coordinate our sctivities.
        </p>


<?php include("foot.php"); ?>

