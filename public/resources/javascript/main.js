$.noConflict();

jQuery(document).ready(function($) {

	"use strict";

	 // Menu Active
    var urll = (window.location.href).split("manager/")[1];
  	urll = urll.split(".html")[0].split('/');
      $('#test').text(urll); 
    if(urll[0] == "manage"){
      	$('#manage').addClass('active'); 
    }else if(urll[0] == "first_trial"){
      	$('#first').addClass('active'); 
	}else if(urll[0] == "final_trial"){
      	$('#final').addClass('active'); 
	}else if(urll[0] == "credential_search"){
      	$('#fixedsearch').addClass('active'); 
	}else if(urll[0] == "people_appoint_search"){
      	$('#mansearch').addClass('active'); 
	}else if(urll[0] == "car_appoint_search"){
      	$('#carsearch').addClass('active'); 
	}else if(urll[0] == "god_hand" ){
        if(urll[1] == "peopleappoint"){
      		$('#manmanage').addClass('active'); 
        }else if(urll[1] == "carappoint"){
      		$('#carmanage').addClass('active'); 
        }else{
      		$('#fixedmanage').addClass('active'); 
    	} 
	}else if(urll[0] == "plugin_content"){
      	$('#esm1').addClass('active'); 
	}
	// Menu Trigger
	$('#menuToggle').on('click', function(event) {
		var windowWidth = $(window).width();   		 
		if (windowWidth<1010) { 
			$('body').removeClass('open'); 
			if (windowWidth<760){ 
				$('#left-panel').slideToggle(); 
			} else {
				$('#left-panel').toggleClass('open-menu');  
			} 
		} else {
			$('body').toggleClass('open');
			$('#left-panel').removeClass('open-menu');  
		} 
			 
	}); 

	 
	$(".menu-item-has-children.dropdown").each(function() {
		$(this).on('click', function() {
			var $temp_text = $(this).children('.dropdown-toggle').html();
			$(this).children('.sub-menu').prepend('<li class="subtitle">' + $temp_text + '</li>'); 
		});
	});


	// Load Resize 
	$(window).on("load resize", function(event) { 
		var windowWidth = $(window).width();  		 
		if (windowWidth<1010) {
			$('body').addClass('small-device'); 
		} else {
			$('body').removeClass('small-device');  
		} 
		
	});
  
 
});