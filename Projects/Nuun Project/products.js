$(document).ready(function(){
	//orange section
	$("#orange").mouseenter(function(){
		$("#orangepanel").animate({height:"30px"},500);
		$(".Obuy").fadeIn(500);
	});
	$("#orangepanel").mouseleave(function(){
		$("#orangepanel").animate({height:"0px"},500);
		$(".Obuy").fadeOut(500);
	});
	//cola section
	$("#cola").mouseenter(function(){
		$("#colapanel").animate({height:"30px"},500);
		$(".Cbuy").fadeIn(500);
	});
	$("#colapanel").mouseleave(function(){
		$("#colapanel").animate({height:"0px"},500);
		$(".Cbuy").fadeOut(500);
	});
	//citrus secion
	$("#citrus").mouseenter(function(){
		$("#citruspanel").animate({height:"30px"},500);
		$(".Ctbuy").fadeIn(500);
	});
	$("#citruspanel").mouseleave(function(){
		$("#citruspanel").animate({height:"0px"},500);
		$(".Ctbuy").fadeOut(500);
	});
	//lemon-lime section
	$("#lemon").mouseenter(function(){
		$("#lemonpanel").animate({height:"30px"},500);
		$(".Lbuy").fadeIn(500);
	});
	$("#lemonpanel").mouseleave(function(){
		$("#lemonpanel").animate({height:"0px"},500);
		$(".Lbuy").fadeOut(500);
	});
	//banana section
	$("#banana").mouseenter(function(){
		$("#bananapanel").animate({height:"30px"},500);
		$(".Bbuy").fadeIn(500);
	});
	$("#bananapanel").mouseleave(function(){
		$("#bananapanel").animate({height:"0px"},500);
		$(".Bbuy").fadeOut(500);
	});
	//berry section
	$("#berry").mouseenter(function(){
		$("#berrypanel").animate({height:"30px"},500);
		$(".BEbuy").fadeIn(500);
	});
	$("#berrypanel").mouseleave(function(){
		$("#berrypanel").animate({height:"0px"},500);
		$(".BEbuy").fadeOut(500);
	});
});