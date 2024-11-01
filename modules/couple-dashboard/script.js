(function($) {

  	'use strict';

  	if( $( '#couple-wedding-timer' ).length ){

  		var couple_wedding_date = $( '#couple-wedding-timer' ).attr( 'data-wedding-date' );

  		CountDownTimer( couple_wedding_date, 'couple-wedding-timer' );
  	}

	function CountDownTimer(dt, id){

	    var end = new Date(dt);
	    
	    var _second = 1000;
	    var _minute = _second * 60;
	    var _hour = _minute * 60;
	    var _day = _hour * 24;
	    var timer;
	    
	    function showRemaining() {
	        var now = new Date();
	        var distance = end - now;
	        if (distance < 0) {
	            
	            clearInterval(timer);
	            document.getElementById(id).innerHTML = '<h4 class="pt-3">'+WeddingCity_Translation_Strings.happy_wedding_msg+'</h4>';
	            
	            return;
	        }
	        var days = Math.floor(distance / _day);
	        var hours = Math.floor((distance % _day) / _hour);
	        var minutes = Math.floor((distance % _hour) / _minute);
	        var seconds = Math.floor((distance % _minute) / _second);
	        
	        
	        if (String(hours).length < 2){
	            hours = 0 + String(hours);
	        }
	        if (String(minutes).length < 2){
	            minutes = 0 + String(minutes);
	        }
	        if (String(seconds).length < 2){
	            seconds = 0 + String(seconds);
	        }
	        
			var datestr =

		    '<li>'
		        +'<span class="days">'+days+'</span>'
		        +'<p class="under-t">'+ WeddingCity_Translation_Strings.wedding_days +'</p>'
		    +'</li>'
		    +'<li>'
		        +'<span class="hours">'+hours+'</span>'
		        +'<p class="under-t">'+ WeddingCity_Translation_Strings.wedding_hours +'</p>'
		    +'</li>'
		    +'<li>'
		        +'<span class="minutes">'+minutes+'</span>'
		        +'<p class="under-t">'+ WeddingCity_Translation_Strings.wedding_min +'</p>'
		    +'</li>'
		    +'<li>'
		        +'<span class="seconds">'+seconds+'</span>'
		        +'<p class="under-t">'+ WeddingCity_Translation_Strings.wedding_sec +'</p>'
		    +'</li>';

	        document.getElementById(id).innerHTML = '<ul>'+ datestr + '</ul>';
	    }
	    
	    timer = setInterval(showRemaining, 1000);
	}

})(jQuery);