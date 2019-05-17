
   
    var content = document.getElementById('content');
    var socket = new WebSocket('ws://localhost:5500');
    var canvas = document.getElementById('canvas');
  
function doCanvas(){
     ctx.fillRect(0, 0, canvas.width, canvas.height);
 ctx.fillStyle = '#fff'
}
    
   
 socket.onmessage = function (message) {
        var data = JSON.parse(JSON.parse(message.data).utf8Data);
       // console.log(data);
         ctx.beginPath();
         ctx.lineWidth = 10
           ctx.moveTo(data.x,data.y);
        ctx.lineTo(data.x,data.y);
        ctx.strokeStyle=data.color;
        ctx.lineJoin = ctx.lineCap = 'round';
        ctx.stroke()
        };

     socket.onerror = function (error) {
        console.log('WebSocket error: ' + error);
    };

//Canvas
var canvas = document.getElementById('canvas');
var ctx = canvas.getContext('2d');
//Variables
var canvasx = $(canvas).offset().left;
var canvasy = $(canvas).offset().top;
var last_mousex = last_mousey = 0;
var mousex = mousey = 0;
var mousedown = false;
var tooltype = 'draw';
var counter;
//Mousedown
$(canvas).on('mousedown', function(e) {
    last_mousex =  parseInt(e.clientX-canvasx);
    last_mousey = mousey = parseInt(e.clientY-canvasy);
    mousedown = true;

});

//Mouseup
$(canvas).on('mouseup', function(e) {
    mousedown = false;
});

//Mousemove
$(canvas).on('mousemove', function(e) {
    mousex = parseInt(e.clientX-canvasx);
    mousey = parseInt(e.clientY-canvasy);
    if(mousedown) {
        ctx.beginPath();
        if(tooltype=='draw') {
            ctx.globalCompositeOperation = 'source-over';
            ctx.strokeStyle = 'red';
            color=ctx.strokeStyle;
            ctx.lineWidth = 10;
             var points = {"x": mousex, "y": mousey, "color": color};
             console.log("suradnica x :"+mousex);
            console.log("suradnica y :"+mousey);
             socket.send(JSON.stringify(points));
        } else if (tooltype=='erase') {
             ctx.globalCompositeOperation = 'source-over';
            ctx.strokeStyle = 'blue';
            color=ctx.strokeStyle;
            ctx.lineWidth = 10;
             var points = {"x": mousex, "y": mousey, "color": color};
             console.log("suradnica x :"+mousex);
            console.log("suradnica y :"+mousey);
             socket.send(JSON.stringify(points));
           /* ctx.globalCompositeOperation = 'destination-out';
            ctx.lineWidth = 10;*/
        }else{
            ctx.strokeStyle = 'white';
        }
    
   
       
        ctx.moveTo(last_mousex,last_mousey);
        ctx.lineTo(mousex,mousey);
        ctx.lineJoin = ctx.lineCap = 'round';
        ctx.stroke();
       
    }
    last_mousex = mousex;
    last_mousey = mousey;
   

    //Output
    
      // $('#output').html('current: '+mousex+', '+mousey+'<br/>last: '+last_mousex+', '+last_mousey+'<br/>mousedown: '+mousedown);
});

function downloadCanvas(link, canvasId, filename) {
    link.href = document.getElementById(canvasId).toDataURL();
    link.download = filename;
}

/** 
 * The event handler for the link's onclick event. We give THIS as a
 * parameter (=the link element), ID of the canvas and a filename.
*/
document.getElementById('download').addEventListener('click', function() {
    downloadCanvas(this, 'canvas', 'test.png');
}, false);
//Use draw|erase
use_tool = function(tool) {
    tooltype = tool; //update
}


