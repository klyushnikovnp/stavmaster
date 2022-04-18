(function ($) {
	
	//@implement top-menu for bootstrap 4
	$("ul.nav>li>a").removeClass("nav-item");
	$("ul.nav>li>a.is-active").parent().addClass('active');
	$("ul.nav>li>a.is-active").removeClass('is-active');
	
	//@dropdown menu
	$("ul.dropdown-menu").parent("li").addClass("dropdown");
	$("li.dropdown>a").addClass("dropdown-toggle");
	$("li.dropdown>a").removeClass("nav-item");
	$("li.dropdown>a").attr("href", "#");
	$("li.dropdown>a").attr("id", "navbarDropdownMenuLink");
	$("li.dropdown>a").attr("role", "button");
	$("li.dropdown>a").attr("data-toggle", "dropdown");
	$("ul.dropdown-menu>li").addClass("dropdown-item");
	$("ul.dropdown-menu>li").removeClass("nav-item");
	
	//@fancybox
	$("img.fancybox").parent().attr("data-fancybox", "gallery");
	
	$(window).scroll(function(){
		if ($(window).scrollTop() > 145){
			$('.branding').addClass('position-fixed fx');
		} else {
			$('.branding').removeClass('position-fixed fx');
		}
	});	
	
	//@mobile menu	
	$(".link-services").attr("href", "#");	
	$('.link-services').click(function(){ 
		$('.double-mobile').slideToggle(300);      
		$('.topMenu').removeClass("d-flex");
		$('.topMenu').css("display", "none");
		return false;
	}); 
	$('.close-double-mobile').click(function(){ 
		$('.double-mobile').slideToggle(300);      
		$('.topMenu').slideToggle(300);      
		return false;
	}); 	

	/*Стрелка вверх*/
	$(window).scroll(function(){
		if ($(this).scrollTop() > 100) {
			$('.scrollup').fadeIn();
		} else {
			$('.scrollup').fadeOut();
		}
	});
	 
	$('.scrollup').click(function(){
		$("html, body").animate({ scrollTop: 0 }, 600);
		return false;
	});		
 
})(jQuery);