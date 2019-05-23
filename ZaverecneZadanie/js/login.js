

//Fade in dashboard box
$(document).ready(function(){
    $('.box').hide().fadeIn(1000);
});

//Stop click event
$('a').click(function(event){
    event.preventDefault();
});