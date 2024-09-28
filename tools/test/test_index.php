<h1>JavaScript Autograder</h1>

<script>
var baseurl = "https://djtutorial.dj4e.com/polls4/";
// var baseurl = "http://localhost:8000/polls4";
</script>

Url to test:
<input type="text" name="baseurl" style="width:60%;" value="https://djtutorial.dj4e.com/polls4/"
onchange="newUrl(this.value);return false;"
/></br>

<button onclick="doNextStep();" id="nextstep">Next Step</button>
<span id="stepinfo">
Placeholder
</span>

<br/>
<center>
<script>
document.write('<iframe style="width:95%; height=800px;" id="myframe"');
document.write('src="'+baseurl+'">');
document.write('</iframe>');
</script>
</center>


<script>
var currenturl = baseurl;

var currentStep = -1;
var json = `
	{
    "steps" : [
        {"command": "switchurl", "text": "/owner" },
        {"command": "searchfor", "text": "Hello"},
        {"command": "searchforwarn", "text": "A12345"},
        {"command": "switchurl", "text": "/"},
        {"command": "searchfor", "text": "Answer to the Ultimate Question"},
        {"command": "clicklink", "tag": "a", "text":"Answer to the Ultimate Question"},
        {"command": "searchfor", "text": "Vote"},
        {"command": "searchfor", "text": "42"},
        {"command": "clickradio", "text": "42"},
        {"command": "clicksubmit", "text": "Vote"},
        {"command": "searchfor", "text": "Vote again?"}
    ]
}`;
var obj = JSON.parse(json);
var steps = obj.steps;

window.addEventListener(
  "message",
  (event) => {
    const step = steps[currentStep];
    console.log('in parent', event, step);
    // Processing here...
    moveToNextStep();
  },
  false,
);

function newUrl(newurl) {
	console.log("Switching to new url", newurl);
	baseurl = newurl;
	currenturl = baseurl;
        document.getElementById('myframe').src = currenturl;
	currentStep = -1;
        moveToNextStep();
}

function moveToNextStep() {

    if ( currentStep >= (steps.length-1) ) {
        document.getElementById('stepinfo').textContent = 'Test complete';
        document.getElementById('nextstep').disabled = true;
        return;
    }

    currentStep++;
    document.getElementById('stepinfo').textContent = (currentStep+1)+'/'+steps.length+' '+JSON.stringify(steps[currentStep]);

}

moveToNextStep();

function doNextStep() {

    if ( currentStep >= (steps.length-1) ) {
        document.getElementById('stepinfo').textContent = 'Test complete';
        document.getElementById('nextstep').disabled = true;
        return;
    }
        document.getElementById('nextstep').disabled = false;
        const step = steps[currentStep];
        console.log(step);
        if ( step.command == 'switchurl' ) {
                currenturl = (baseurl + step.text).replace('/\/\//','/');
                console.log('Switching to', currenturl);
                document.getElementById('myframe').src = currenturl;
                moveToNextStep();
                return;
        }
	console.log('Sending...', step, currenturl);
	document.getElementById('myframe').contentWindow.postMessage(step, currenturl);
	console.log('sent...');
}
</script>
