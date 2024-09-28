window.addEventListener(
  "message",
  (event) => {
    console.log('in frame event', event);
    if ( event.data.command == 'getdomsize' ) {
        console.log(document.documentElement.clientWidth, document.documentElement.clientHeight);
        event.source.postMessage({'width': document.documentElement.clientWidth, 'height': document.documentElement.clientHeight});
    }
    const element = document.getElementById("myh1");
    const rect = element.getBoundingClientRect();
    console.log(rect);
  },
  false,
);

