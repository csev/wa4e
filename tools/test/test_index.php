<h1>Test index</h1>
<button onclick="document.getElementById('myframe').contentWindow.postMessage({'command': 'getdomsize'});">Button</button>
<br/>
<iframe src="test_tool.php" id="myframe">
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
