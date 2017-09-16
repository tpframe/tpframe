/* 
	project : Xinye Official Website
	author : Jason Kim
	date : 17-3,2014
	===========================================================
*/
$(function(){
	// Home : da-slider
	if($("#da-slider").length){
		$('#da-slider').cslider({
			bgincrement:0,
			autoplay:true,
			interval: 6000
		});
	}
	
	// Home : case showbox
	if($("#home-showbox").length){
		$('#home-showbox li').hover(function(){
			var _this = $(this); 
			trigger = setTimeout(function(){
				_this.children(".showbox").fadeIn();
			},200);
		},function(){
			clearTimeout(trigger);
			$(this).children(".showbox").fadeOut();
		});
	}
	
	// blog-detail zoom
	if($("#zoom-con").length){
		$('#zoom-con').hover(function(){
			$(this).find(".zoom").fadeIn();
		},function(){
			$(this).find(".zoom").fadeOut();
		});
	}
	
	// contact-overlay
	if($("#contact-overlay").length){
		$("#btn-send").overlay({
			mask: '#767676',
			top:'20%',
			onLoad: function () {
                setTimeout(function() { 
					$("#btn-send").overlay().close();
				}, 2000);
            }
		});
	}
	
	// mobile-menu
	if($("#menu").length){
		$('#menu').slicknav({
			prependTo:'.header',
			duration: 300,
			closeOnClick:'true'
		});
	}
	
	// Check the initial Poistion of the Sticky Header
	// mobile-menu
	if($("#header-white").length){
		var stickyHeaderTop = $('#header-white').offset().top;
		
		$(window).scroll(function(){
				if( $(window).scrollTop() > stickyHeaderTop ) {
						$('#header-white').removeClass('header-white');
				} else {
						$('#header-white').addClass('header-white');
				}
		});
	}
});