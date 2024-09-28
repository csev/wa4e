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

var clickRadio = function(label) {
	var inputs = document.getElementsByTagName('input');

 	for (let i = 0; i < inputs.length; i++) {
    	    if (inputs[i].type != 'radio' ) continue;
	    if ( typeof(inputs[i].id) == 'undefined' ) continue;
	    var el = document.querySelector('[for="'+inputs[i].id+'"]');
            console.log('label ',el);
            console.log('textContent', el.textContent);
            if ( el.textContent == label ) {
		console.log('Clicking', el);
		el.click();
		return true;
	     }
	}
	return false;
}

var clickSubmit = function(label) {
	var inputs = document.getElementsByTagName('input');

 	for (let i = 0; i < inputs.length; i++) {
    	    if (inputs[i].type != 'submit' ) continue;
            if ( inputs[i].value == label ) {
		console.log('Clicking', inputs[i]);
		inputs[i].click();
		return true;
	     }
	}
	return false;
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
    if ( event.data.command == 'searchfor' ){
	const retval = (document.documentElement.textContent || document.documentElement.innerText).indexOf(event.data.text) > -1
	console.log('returning', retval);
        event.source.postMessage(retval, event.origin);
	return;
    }
    if ( event.data.command == 'searchforwarn' ){
	const retval = (document.documentElement.textContent || document.documentElement.innerText).indexOf(event.data.text) > -1
	console.log('returning', retval);
        event.source.postMessage(retval, event.origin);
	return;
    }
    if ( event.data.command == 'searchfornot' ){
	const retval = ! ((document.documentElement.textContent || document.documentElement.innerText).indexOf(event.data.text) > -1);
	console.log('returning', retval);
        event.source.postMessage(retval, event.origin);
	return;
    }
    if ( event.data.command == 'clickradio' ){
	const retval = clickRadio(event.data.text);
	console.log('returning', retval);
        event.source.postMessage(retval, event.origin);
	return;
    }

    if ( event.data.command == 'clicksubmit' ){
	const retval = clickSubmit(event.data.text);
	console.log('returning', retval);
        event.source.postMessage(retval, event.origin);
	return;
    }
  },
  false,
);

