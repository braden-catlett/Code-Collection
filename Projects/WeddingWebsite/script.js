var timer = 0;
var counter = 0;
var images = new Array("Slideshow1.jpg","Slideshow2.jpg","Slideshow3.jpg","Slideshow4.jpg","Slideshow5.jpg");
var dragging = false;
window.onfocus = goshow;
window.onblur = stopshow;
$("document").ready(function(){
	var target = $('#SlideshowDiv');
	var diffX = 0;
	var diffY = 0;
	target.mousedown( function(e){
		dragging = true;
		diffY = (e.pageY - ExtractNumber(target.position().top));
		diffX = (e.pageX - ExtractNumber(target.position().left));
	});
	$(document).mouseup( function(){
		dragging = false;
	});
	$(document).mousemove(function(e){
		if(dragging){
			var X = e.pageX - diffX;
			var Y = e.pageY - diffY;
			target.css('left', X);
			target.css('top', Y);
		}
	});
    goshow();
});
function ExtractNumber(value)
{
    var n = parseInt(value);
	
    return n == null || isNaN(n) ? 0 : n;
}
function goshow(){
    timer = setInterval(function(){
        startshow();
    },2500);
}
function stopshow(){
	window.clearInterval(timer);
}
function startshow(){
	$("#SlideshowDiv").css("background-image", "url(" + images[counter] + ")");
    counter++;
    if(counter > 4){
        counter = 0;
    }
}