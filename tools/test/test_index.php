<h1>Test index</h1>
<!--
<button onclick="
document.getElementById('myframe').contentWindow.postMessage(
	{'command': 'getdomsize'}, 'https://djtutorial.dj4e.com/polls4/');"
>getdomsize</button>

<button onclick="
document.getElementById('myframe').contentWindow.postMessage(
{'command': 'clicklink','tag': 'a', 'text':'Answer to the Ultimate Question'}, 'https://djtutorial.dj4e.com/polls4/');"
>clicklink</button>

<button onclick="
document.getElementById('myframe').contentWindow.postMessage(
{'command': 'searchtext','text': 'Ultimate'}, 'https://djtutorial.dj4e.com/polls4/');"
>searchtext</button>

<button onclick="
document.getElementById('myframe').contentWindow.postMessage(
{'command': 'searchtext','text': 'Waldo'}, 'https://djtutorial.dj4e.com/polls4/');"
>searchtext 2</button>

<button onclick="
document.getElementById('myframe').contentWindow.postMessage(
{'command': 'clickradio','text': '42'}, 'https://djtutorial.dj4e.com/polls4/');"
>clickradio</button>

<button onclick="
document.getElementById('myframe').contentWindow.postMessage(
{'command': 'clicksubmit','text': 'Vote'}, 'https://djtutorial.dj4e.com/polls4/');"
>clicksubmit</button>
-->

<button onclick="doNextStep();" id="nextstep">Next Step</button>
<span id="stepinfo">
Placeholder
</span>

<br/>
<center>
<iframe style="width:95%; height=800px;" src="https://djtutorial.dj4e.com/polls4/" id="myframe">
</iframe>
</center>


<script>
var baseurl = "https://djtutorial.dj4e.com/polls4/";
var currenturl = "https://djtutorial.dj4e.com/polls4/";

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
