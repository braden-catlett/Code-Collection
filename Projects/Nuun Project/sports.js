var timer;
var counter;
window.onfocus = goshow;
window.onblur = stopshow;
$("document").ready(function(){
    timer = 0;
    counter = 0;
    goshow();
});

function goshow(){
    timer = setInterval(function(){
        startshow();
    },4000);
}
function stopshow(){
	window.clearInterval(timer);
}
function startshow(){
    switch(counter){
        case 0:
            $("#img5").fadeOut(250);
            $("#img1").delay(250).fadeIn(250);
            break;
        case 1:
            $("#img1").fadeOut(250);
            $("#img2").delay(250).fadeIn(250);
            break;
        case 2:
            $("#img2").fadeOut(250);;
            $("#img3").delay(250).fadeIn(250);
            break;
        case 3:
            $("#img3").fadeOut(250);
            $("#img4").delay(250).fadeIn(250);
            break;
		case 4:
			$("#img4").fadeOut(250);
            $("#img5").delay(250).fadeIn(250);
            break;
    }
    counter++;
    if(counter > 4){
        counter = 0;
    }
}