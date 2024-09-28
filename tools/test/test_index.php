<h1>Test index</h1>
<button onclick="
document.getElementById('myframe').contentWindow.postMessage(
	{'command': 'getdomsize'}, 'https://djtutorial.dj4e.com/polls4/');"
>getdomsize</button>
<button onclick="
document.getElementById('myframe').contentWindow.postMessage(
{'command': 'clicklink','tag': 'a', 'text':'Answer to the Ultimate Question'}, 'https://djtutorial.dj4e.com/polls4/');"
>clicklink</button>

<br/>
<iframe src="https://djtutorial.dj4e.com/polls4/" id="myframe">
</iframe>


<script>
window.addEventListener(
  "message",
  (event) => {
    console.log('in parent', event);
  },
  false,
);

</script>
