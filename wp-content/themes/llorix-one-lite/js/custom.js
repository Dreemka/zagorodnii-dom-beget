var $jq = jQuery.noConflict();

jQuery(document).ready(function($){
	$jq(".about-thumbs a").fancybox();

	$jq(".about-thumb-wrap").click(function(e){
		e.preventDefault();
		var num = $(this).data("num");
		var big = $(this).find("a").attr("href");
		var medium = $(this).find("a").data("medium");
		$(".about-big a img").attr("src",medium);
		$(".about-big a").attr("href",big);
		$(".about-big a").data("num",num);
	})

	$jq(".about-big a").click(function(e){
		e.preventDefault();
		var num = $(this).data("num");
		var x = $(".about-thumb-wrap[data-num='"+num+"']").not(".slick-cloned").find("a");
		x.trigger("click");
	})
})

jQuery(window).on('load',function(){




	$jq(".about-thumbs").slick({
		arrows:true,
		variableWidth: true,
		//centerMode: true,
		 lazyLoad: 'ondemand',
	});  
	setInterval(function(){
		//$jq('.about-thumbs').slick('refresh');
	},500);
})