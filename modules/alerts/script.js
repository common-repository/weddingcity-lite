(function($) {

  'use strict';

  	/**
  	 *  @link http://jsfiddle.net/juanmendez/vCBev/
  	 */

	toastr.options = {
	  "debug": false,
	  "positionClass": "toast-bottom-right",
	  "onclick": null,
	  "fadeIn": 300,
	  "fadeOut": 100,
	  "timeOut": 5000,
	  "extendedTimeOut": 1000
	}

	function weddingcity_alert_message( data ){

		if( data !== null && data !== '' ){

			if( data.notice == '0' ){

				toastr.error( data.message );
			}

			if( data.notice == '1' ){
				
				toastr.success( data.message );
			}

			if( data.notice == '2' ){
				
				toastr.info( data.message );
			}

			if( data.notice == '3' ){
				
				toastr.warning( data.message );
			}
		}
	}

})(jQuery);