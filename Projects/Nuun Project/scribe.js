$(document).ready(function(){
    $("#bodycontent").fadeOut(1);
    $("#contentplane").animate({height:"50px", top:"49%", width:"50px", left:"49%"},1);
    $("#contentplane").fadeIn(1000);
    $("#contentplane").animate({height:"100%", top:"13%", left:"0%", width:"100%"},1500);
    $("#contentplane").fadeOut(1000);
    $("#bodycontent").delay(1900).fadeIn(1000);
    $("#contentplane").animate({height:"50px", top:"49%", width:"50px", left:"49%"},1);
	$("#home").mouseenter(function(){
		$("#home").animate({top:"-10px"},500);
	});
	$("#home").mouseleave(function(){
		$("#home").animate({top:"0px"},500);
	});
	
	$("#products").mouseenter(function(){
		$("#products").animate({top:"-10px"},500);
	});
	$("#products").mouseleave(function(){
		$("#products").animate({top:"0px"},500);
	});
	
	$("#sports").mouseenter(function(){
		$("#sports").animate({top:"-10px"},500);
	});
	$("#sports").mouseleave(function(){
		$("#sports").animate({top:"0px"},500);
	});
	
	$("#aboutnuun").mouseenter(function(){
		$("#aboutnuun").animate({top:"-10px"},500);
	});
	$("#aboutnuun").mouseleave(function(){
		$("#aboutnuun").animate({top:"0px"},500);
	});
});