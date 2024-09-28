console.log('loading autograder');

var findElements = function(tag, text) {
  var elements = document.getElementsByTagName(tag);
  var found = [];
  for (var i = 0; i < elements.length; i++) {
    if (elements[i].innerHTML === text) {
      found.push(elements[i]);
    }
  }
  
  return found;
}

window.addEventListener(
  "message",
  (event) => {
    console.log('in frame event', event);
    if ( event.data.command == 'getdomsize' ) {
        console.log(document.documentElement.clientWidth, document.documentElement.clientHeight);
        const retval ={'width': document.documentElement.clientWidth, 'height': document.documentElement.clientHeight};
	console.log('returning', retval);
        event.source.postMessage(retval, event.origin);
	return;
    }
    if ( event.data.command == 'clicklink' ){
        const retval = findElements(event.data.tag, event.data.text);
	console.log('returning', retval);
	retval[0].click();
        event.source.postMessage('42', event.origin);
	return;
    }
  },
  false,
);

