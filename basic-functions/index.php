<?php

if( ! function_exists( 'weddingcity_return_post_data' ) ){

	function weddingcity_return_post_data( $data ){

		global $wp_query, $post;

		$data = !empty( $data ) ? $data : 'post';
		$args_post = $args_id = $args = array();
		$services_args = array( 'post_type' => $data, 'posts_per_page' => -1, 'post_status'=> 'publish', 'post__not_in' => get_option("sticky_posts") );
		$services_loop = new WP_Query( $services_args );
		while ( $services_loop->have_posts() ) : $services_loop->the_post();

			if( get_the_title() != '' ) {

				$args_post[] = get_the_title();
				$args_id[] = get_the_ID();
			}

		endwhile;
		wp_reset_postdata();

		if( count( $args_post) == count( $args_id ) && is_array($args_post) && is_array($args_id) && !empty($args_post) && !empty($args_id)  ){
			return $args = array_combine( $args_id, $args_post);
		}else {
			return $args = array();
		}

		return false;
	}
}

if (!function_exists('weddingcity_theme_logo')) {

    function weddingcity_theme_logo($args = '') {?>
    	<h3 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name');?></a></h3>
    <?php }
}

if( ! function_exists( 'weddingcity_theme_option_post_list' ) ){

	function weddingcity_theme_option_post_list( $data ){

		global $wp_query, $post;

		$_get_data 		=   array();
		$_get_data[] 	=   array(

            'value'		=> 	'',
            'label' 	=> 	'',
            'src'	 	=> 	'',
        );

		$data = !empty( $data ) ? $data : 'post';

		$args_post = $args_id = $args = array();

		$services_args = array( 'post_type' => $data, 'posts_per_page' => -1 );

		$services_loop = new WP_Query( $services_args );
		
		while ( $services_loop->have_posts() ) : $services_loop->the_post();

			if( get_the_title() != '' ) {

					$_get_data[] 	=   array(

		                'value'		=> 	get_the_ID(),
		                'label' 	=> 	get_the_title(),
		                'src'	 	=> 	'',
		            );
			}

		endwhile;
		wp_reset_postdata();

		return $_get_data;
	}
}


if( ! function_exists( 'weddingcity_print' ) ){

	function weddingcity_print( $args ){

		print '<pre>';

			print_r( $args );

		print '</pre>';
	}
}


/** 
 *  @return Days, Month, Week, Year with argument.
 */

if( ! function_exists( 'weddingcity_time_period' ) ){

		function weddingcity_time_period( $string, $start, $end ){

			$arr = array();

			for( $i = absint( $start ); $i<=absint( $end ); $i++ ){

				$arr[  sprintf( '+%1$s %2$s', $i, $string ) ] =  sprintf( '%1$s %2$s', $i, $string );
			}

			return $arr;
		}
}

/** 
 *  @return Array: Days, Month, Week, Year with argument.
 */

if( ! function_exists( 'weddingcity_time_period_theme_option' ) ){

		function weddingcity_time_period_theme_option( $a, $b, $c ){

			$current_code = weddingcity_time_period( $a, $b, $c );

			$return_array = array();

			foreach ( $current_code as $key) {

		        $return_array[] = array(

		            'value'       => sprintf( '+%1$s', $key ),
		            'label'       => sprintf( '+%1$s', $key ),
		            'src'         => ''
		        );
			}

			return $return_array;
		}	
}

if( ! function_exists( 'weddingcity_redux_time_period_theme_option' ) ){

		function weddingcity_redux_time_period_theme_option( $a, $b, $c ){

			$current_code = weddingcity_time_period( $a, $b, $c );

			$return_array = array();

			foreach ( $current_code as $key) {

		        $return_array[] = sprintf( '+%1$s', $key );
			}

			return $return_array;
		}	
}

/**
 *  @return Paypal Currency Code
 */

if( ! function_exists( 'weddingcity_paypal_currency' ) ){

		function weddingcity_paypal_currency(){

			$current_code = weddingcity_paypal_currency_code();

			$return_array = array();

			foreach ( $current_code as $key) {

		        $return_array[] = array(

		            'value'       => $key,
		            'label'       => esc_html( $key ),
		            'src'         => ''
		        );
			}

			return $return_array;
		}	
}

if( ! function_exists( 'weddingcity_create_OT_array' ) ){

	function weddingcity_create_OT_array( $array ){

		$return = array();

		if( ! is_array( $array ) ) return $return;

		if( is_array( $array ) && count( $array ) >= absint('1') ){

		  	foreach( $array as $key => $value ){

		  		$return[] = array(
	              'value'       => $key,
	              'label'       => esc_html( $value ),
	              'src'         => ''
	            );
		  	}
		}

		return $return;
	}
}


if( ! function_exists( 'weddingcity_get_page_id' ) ){

	function weddingcity_get_page_id( $title ){

		if( empty( $title ) )
			return;

	    $page_check 	= 	get_page_by_title( $title );

	    if( isset( $page_check->ID ) ){

	    	return absint( $page_check->ID );
	    }
	}
}

/** 
 *  @return Paypal Currecty Code
 */

if( ! function_exists( 'weddingcity_paypal_currency_code' ) ){
		
		function weddingcity_paypal_currency_code(){

			return array(

			    'USD', 'EUR', 'AUD', 'BRL', 'CAD', 'CHF', 'CZK', 'DKK', 'HKD', 'HUF', 
			    'IDR', 'ILS', 'INR', 'JPY', 'KOR', 'KSH', 'MYR', 'MXN', 'NGN', 'NOK', 
			    'NZD', 'PHP', 'PLN', 'GBP', 'SGD', 'SEK', 'TWD', 'THB', 'TRY', 'VND',  'ZAR'
			);	

		}
}


if( ! function_exists( 'weddingcity_redux_paypal_payment_currency' ) ){

	function weddingcity_redux_paypal_payment_currency(){

		$_currency 	=	array();

		foreach( weddingcity_paypal_currency_code() as $key => $value ){

			$_currency[]	= 	esc_attr( $value );
		}

		return $_currency;
	}
}


/**
 *  @credit - https://wordpress.stackexchange.com/questions/163555/how-to-target-specific-wp-nav-menu-in-function
 */
if(!function_exists('weddingcity_front_end_dropdown') ){

	add_filter('wp_nav_menu_items','weddingcity_front_end_dropdown', 10, 2);  

    function weddingcity_front_end_dropdown($items, $args) {

    	if( $args->theme_location == 'primary-menu' ){

	        if( WeddingCity_User:: is_vendor() ){

	            $items .= sprintf( '<li class="frontend_dropdown_menu">%1$s</li>', WeddingCity_Vendor_Menu:: dashboard_menu( 'top' ) );
	        }

	        if( WeddingCity_User:: is_couple() ){

	            $items .= sprintf( '<li class="frontend_dropdown_menu">%1$s</li>', WeddingCity_Couple_Menu:: dashboard_menu( 'top' ) );
	        }
    	}

        return $items;
    }
}


/**
 *  WeddingCity Icons
 */
if( ! function_exists( 'weddingcity_icons_set' ) ){

	function weddingcity_icons_set(){

		return array(

				/**
				 *  Flaticon
				 */
				'flaticon-001-gift-1' => 'gift',
				'flaticon-002-dove' => 'dove',
				'flaticon-003-cupcake' => 'cupcake',
				'flaticon-004-love-1' => 'love',
				'flaticon-005-gramophone' => 'gramophone',
				'flaticon-006-video-camera' => 'video-camera',
				'flaticon-007-ring' => 'ring',
				'flaticon-008-wedding-dress' => 'wedding-dress',
				'flaticon-009-calendar-1' => 'calendar',
				'flaticon-010-gender-symbol' => 'gender-symbol',
				'flaticon-011-wedding-car' => 'wedding-car',
				'flaticon-012-bell' => 'bell',
				'flaticon-013-money' => 'money',
				'flaticon-014-lock' => 'lock',
				'flaticon-015-love-key' => 'love-key',
				'flaticon-016-gift' => 'gift',
				'flaticon-017-wedding-ring' => 'wedding-ring',
				'flaticon-018-wedding-1' => 'wedding-1',
				'flaticon-019-wedding-location' => 'wedding-location',
				'flaticon-020-home' => 'home',
				'flaticon-021-wedding-invitation-2' => 'wedding-invitation',
				'flaticon-022-church' => 'church',
				'flaticon-023-wedding-invitation-1' => 'wedding-invitation',
				'flaticon-024-wine-1' => 'wine',
				'flaticon-025-wedding-cake' => 'wedding-cake',
				'flaticon-026-wine' => 'wine',
				'flaticon-027-calendar' => 'calendar',
				'flaticon-028-candle' => 'candle',
				'flaticon-029-bible' => 'bible',
				'flaticon-030-dish' => 'dish',
				'flaticon-031-speech-bubble' => 'speech-bubble',
				'flaticon-032-shopping-bag' => 'shopping-bag',
				'flaticon-033-bouquet' => 'bouquet',
				'flaticon-034-rings' => 'rings',
				'flaticon-035-balloons' => 'balloons',
				'flaticon-036-flower' => 'flower',
				'flaticon-037-lips' => 'lips',
				'flaticon-038-camera' => 'camera',
				'flaticon-039-double-bed' => 'double-bed',
				'flaticon-040-necklace' => 'necklace',
				'flaticon-041-ticket' => 'ticket',
				'flaticon-042-wedding-suit' => 'wedding-suit',
				'flaticon-043-pastor' => 'pastor',
				'flaticon-044-groom' => 'groom',
				'flaticon-045-bride' => 'bride',
				'flaticon-046-wedding' => 'wedding',
				'flaticon-047-wedding-invitation' => 'wedding-invitation',
				'flaticon-048-just-married' => 'just-married',
				'flaticon-049-love' => 'love',
				'flaticon-050-wedding-couple' => 'wedding-couple',


				/**
				 *  Fontello
				 */
				'icon-051-love-birds' => 'icon-051-love-birds',
				'icon-051-love-letter' => 'icon-051-love-letter',
				'icon-051-microphone' => 'icon-051-microphone',
				'icon-051-necklace' => 'icon-051-necklace',
				'icon-051-padlock' => 'icon-051-padlock',
				'icon-051-photo-camera' => 'icon-051-photo-camera',
				'icon-051-rainbow' => 'icon-051-rainbow',
				'icon-051-restaurant' => 'icon-051-restaurant',
				'icon-051-romantic-music' => 'icon-051-romantic-music',
				'icon-051-rose' => 'icon-051-rose',
				'icon-051-shoe' => 'icon-051-shoe',
				'icon-051-suit' => 'icon-051-suit',
				'icon-051-video-camera' => 'icon-051-video-camera',
				'icon-051-wedding-arch' => 'icon-051-wedding-arch',
				'icon-051-wedding-cake' => 'icon-051-wedding-cake',
				'icon-051-wedding-cake-1' => 'icon-051-wedding-cake-1',
				'icon-051-wedding-day' => 'icon-051-wedding-day',
				'icon-051-wedding-dress' => 'icon-051-wedding-dress',
				'icon-051-wedding-invitation' => 'icon-051-wedding-invitation',
				'icon-051-wedding-rings' => 'icon-051-wedding-rings',
				'icon-051-balloons' => 'icon-051-balloons',
				'icon-051-bed' => 'icon-051-bed',
				'icon-051-bell' => 'icon-051-bell',
				'icon-051-bible' => 'icon-051-bible',
				'icon-051-bouquet' => 'icon-051-bouquet',
				'icon-051-bow-tie' => 'icon-051-bow-tie',
				'icon-051-bride' => 'icon-051-bride',
				'icon-051-candelabra' => 'icon-051-candelabra',
				'icon-051-car' => 'icon-051-car',
				'icon-051-champagne' => 'icon-051-champagne',
				'icon-051-cheers' => 'icon-051-cheers',
				'icon-051-church' => 'icon-051-church',
				'icon-051-cocktail' => 'icon-051-cocktail',
				'icon-051-cupcake' => 'icon-051-cupcake',
				'icon-051-cupid' => 'icon-051-cupid',
				'icon-051-cupid-1' => 'icon-051-cupid-1',
				'icon-051-diamond' => 'icon-051-diamond',
				'icon-051-dinner' => 'icon-051-dinner',
				'icon-051-engagement-ring' => 'icon-051-engagement-ring',
				'icon-051-engagement-ring-1' => 'icon-051-engagement-ring-1',
				'icon-051-fireworks' => 'icon-051-fireworks',
				'icon-051-garlands' => 'icon-051-garlands',
				'icon-051-genders' => 'icon-051-genders',
				'icon-051-gift' => 'icon-051-gift',
				'icon-051-groom' => 'icon-051-groom',
				'icon-051-hearts' => 'icon-051-hearts',
				'icon-051-high-heels' => 'icon-051-high-heels',
				'icon-051-key' => 'icon-051-key',
				'icon-051-kiss' => 'icon-051-kiss',
				'icon-051-lipstick' => 'icon-051-lipstick',
				'icon-034-balloons' => 'icon-034-balloons',
				'icon-035-rose' => 'icon-035-rose',
				'icon-036-cupcake' => 'icon-036-cupcake',
				'icon-037-microphone' => 'icon-037-microphone',
				'icon-038-bouquet' => 'icon-038-bouquet',
				'icon-039-diamond' => 'icon-039-diamond',
				'icon-040-bride' => 'icon-040-bride',
				'icon-041-gift' => 'icon-041-gift',
				'icon-042-rings' => 'icon-042-rings',
				'icon-043-toast' => 'icon-043-toast',
				'icon-044-birds' => 'icon-044-birds',
				'icon-045-ring' => 'icon-045-ring',
				'icon-046-crown' => 'icon-046-crown',
				'icon-047-camera' => 'icon-047-camera',
				'icon-048-love' => 'icon-048-love',
				'icon-049-music' => 'icon-049-music',
				'icon-050-high-heels' => 'icon-050-high-heels',
				'icon-001-plate' => 'icon-001-plate',
				'icon-002-genders' => 'icon-002-genders',
				'icon-003-waiter' => 'icon-003-waiter',
				'icon-004-chat' => 'icon-004-chat',
				'icon-005-smartphone' => 'icon-005-smartphone',
				'icon-006-video-camera-1' => 'icon-006-video-camera-1',
				'icon-007-video-camera' => 'icon-007-video-camera',
				'icon-008-suitcase' => 'icon-008-suitcase',
				'icon-009-candle' => 'icon-009-candle',
				'icon-010-potion' => 'icon-010-potion',
				'icon-011-wine-1' => 'icon-011-wine-1',
				'icon-012-bow-1' => 'icon-012-bow-1',
				'icon-013-calendar' => 'icon-013-calendar',
				'icon-014-padlock' => 'icon-014-padlock',
				'icon-015-bible' => 'icon-015-bible',
				'icon-016-bow' => 'icon-016-bow',
				'icon-017-location' => 'icon-017-location',
				'icon-018-invitation-1' => 'icon-018-invitation-1',
				'icon-019-bell' => 'icon-019-bell',
				'icon-020-toast-1' => 'icon-020-toast-1',
				'icon-021-love-1' => 'icon-021-love-1',
				'icon-022-hand-bag' => 'icon-022-hand-bag',
				'icon-023-dress' => 'icon-023-dress',
				'icon-024-invitation' => 'icon-024-invitation',
				'icon-025-groom' => 'icon-025-groom',
				'icon-026-letter' => 'icon-026-letter',
				'icon-027-shopping-bag' => 'icon-027-shopping-bag',
				'icon-028-cake' => 'icon-028-cake',
				'icon-029-wine' => 'icon-029-wine',
				'icon-030-church' => 'icon-030-church',
				'icon-031-key' => 'icon-031-key',
				'icon-032-cupid' => 'icon-032-cupid',
				'icon-033-suit' => 'icon-033-suit',
				'icon-calendar' => 'icon-calendar',
				'icon-calendar-1' => 'icon-calendar-1',
				'icon-calendar-2' => 'icon-calendar-2',
				'icon-calendar-3' => 'icon-calendar-3',
				'icon-calendar-4' => 'icon-calendar-4',
				'icon-calendar-5' => 'icon-calendar-5',
				'icon-calendar-6' => 'icon-calendar-6',
				'icon-calendar-7' => 'icon-calendar-7',
				'icon-checked' => 'icon-checked',
				'icon-checked-1' => 'icon-checked-1',
				'icon-clock' => 'icon-clock',
				'icon-clock-1' => 'icon-clock-1',
				'icon-close' => 'icon-close',
				'icon-cloud' => 'icon-cloud',
				'icon-cloud-computing' => 'icon-cloud-computing',
				'icon-cloud-computing-1' => 'icon-cloud-computing-1',
				'icon-cloud-computing-2' => 'icon-cloud-computing-2',
				'icon-cloud-computing-3' => 'icon-cloud-computing-3',
				'icon-cloud-computing-4' => 'icon-cloud-computing-4',
				'icon-cloud-computing-5' => 'icon-cloud-computing-5',
				'icon-command' => 'icon-command',
				'icon-compact-disc' => 'icon-compact-disc',
				'icon-compact-disc-1' => 'icon-compact-disc-1',
				'icon-compact-disc-2' => 'icon-compact-disc-2',
				'icon-compass' => 'icon-compass',
				'icon-compose' => 'icon-compose',
				'icon-controls' => 'icon-controls',
				'icon-controls-1' => 'icon-controls-1',
				'icon-controls-2' => 'icon-controls-2',
				'icon-controls-3' => 'icon-controls-3',
				'icon-controls-4' => 'icon-controls-4',
				'icon-controls-5' => 'icon-controls-5',
				'icon-controls-6' => 'icon-controls-6',
				'icon-controls-7' => 'icon-controls-7',
				'icon-controls-8' => 'icon-controls-8',
				'icon-controls-9' => 'icon-controls-9',
				'icon-database' => 'icon-database',
				'icon-database-1' => 'icon-database-1',
				'icon-database-2' => 'icon-database-2',
				'icon-database-3' => 'icon-database-3',
				'icon-diamond' => 'icon-diamond',
				'icon-diploma' => 'icon-diploma',
				'icon-dislike' => 'icon-dislike',
				'icon-dislike-1' => 'icon-dislike-1',
				'icon-divide' => 'icon-divide',
				'icon-divide-1' => 'icon-divide-1',
				'icon-division' => 'icon-division',
				'icon-document' => 'icon-document',
				'icon-download' => 'icon-download',
				'icon-edit' => 'icon-edit',
				'icon-edit-1' => 'icon-edit-1',
				'icon-eject' => 'icon-eject',
				'icon-eject-1' => 'icon-eject-1',
				'icon-equal' => 'icon-equal',
				'icon-equal-1' => 'icon-equal-1',
				'icon-equal-2' => 'icon-equal-2',
				'icon-error' => 'icon-error',
				'icon-exit' => 'icon-exit',
				'icon-exit-1' => 'icon-exit-1',
				'icon-exit-2' => 'icon-exit-2',
				'icon-eyeglasses' => 'icon-eyeglasses',
				'icon-fast-forward' => 'icon-fast-forward',
				'icon-fast-forward-1' => 'icon-fast-forward-1',
				'icon-fax' => 'icon-fax',
				'icon-file' => 'icon-file',
				'icon-file-1' => 'icon-file-1',
				'icon-file-2' => 'icon-file-2',
				'icon-film' => 'icon-film',
				'icon-fingerprint' => 'icon-fingerprint',
				'icon-flag' => 'icon-flag',
				'icon-flag-1' => 'icon-flag-1',
				'icon-flag-2' => 'icon-flag-2',
				'icon-flag-3' => 'icon-flag-3',
				'icon-flag-4' => 'icon-flag-4',
				'icon-focus' => 'icon-focus',
				'icon-folder' => 'icon-folder',
				'icon-folder-1' => 'icon-folder-1',
				'icon-folder-2' => 'icon-folder-2',
				'icon-folder-3' => 'icon-folder-3',
				'icon-folder-4' => 'icon-folder-4',
				'icon-folder-5' => 'icon-folder-5',
				'icon-folder-6' => 'icon-folder-6',
				'icon-folder-7' => 'icon-folder-7',
				'icon-folder-8' => 'icon-folder-8',
				'icon-folder-9' => 'icon-folder-9',
				'icon-folder-10' => 'icon-folder-10',
				'icon-folder-11' => 'icon-folder-11',
				'icon-folder-12' => 'icon-folder-12',
				'icon-folder-13' => 'icon-folder-13',
				'icon-folder-14' => 'icon-folder-14',
				'icon-folder-15' => 'icon-folder-15',
				'icon-folder-16' => 'icon-folder-16',
				'icon-folder-17' => 'icon-folder-17',
				'icon-folder-18' => 'icon-folder-18',
				'icon-folder-19' => 'icon-folder-19',
				'icon-forbidden' => 'icon-forbidden',
				'icon-funnel' => 'icon-funnel',
				'icon-garbage' => 'icon-garbage',
				'icon-garbage-1' => 'icon-garbage-1',
				'icon-garbage-2' => 'icon-garbage-2',
				'icon-gift' => 'icon-gift',
				'icon-help' => 'icon-help',
				'icon-hide' => 'icon-hide',
				'icon-hold' => 'icon-hold',
				'icon-home' => 'icon-home',
				'icon-home-1' => 'icon-home-1',
				'icon-home-2' => 'icon-home-2',
				'icon-hourglass' => 'icon-hourglass',
				'icon-hourglass-1' => 'icon-hourglass-1',
				'icon-hourglass-2' => 'icon-hourglass-2',
				'icon-hourglass-3' => 'icon-hourglass-3',
				'icon-house' => 'icon-house',
				'icon-id-card' => 'icon-id-card',
				'icon-id-card-1' => 'icon-id-card-1',
				'icon-id-card-2' => 'icon-id-card-2',
				'icon-id-card-3' => 'icon-id-card-3',
				'icon-id-card-4' => 'icon-id-card-4',
				'icon-id-card-5' => 'icon-id-card-5',
				'icon-idea' => 'icon-idea',
				'icon-incoming' => 'icon-incoming',
				'icon-infinity' => 'icon-infinity',
				'icon-info' => 'icon-info',
				'icon-internet' => 'icon-internet',
				'icon-key' => 'icon-key',
				'icon-lamp' => 'icon-lamp',
				'icon-layers' => 'icon-layers',
				'icon-layers-1' => 'icon-layers-1',
				'icon-like' => 'icon-like',
				'icon-like-1' => 'icon-like-1',
				'icon-like-2' => 'icon-like-2',
				'icon-link' => 'icon-link',
				'icon-list' => 'icon-list',
				'icon-list-1' => 'icon-list-1',
				'icon-lock' => 'icon-lock',
				'icon-lock-1' => 'icon-lock-1',
				'icon-locked' => 'icon-locked',
				'icon-locked-1' => 'icon-locked-1',
				'icon-locked-2' => 'icon-locked-2',
				'icon-locked-3' => 'icon-locked-3',
				'icon-locked-4' => 'icon-locked-4',
				'icon-locked-5' => 'icon-locked-5',
				'icon-locked-6' => 'icon-locked-6',
				'icon-login' => 'icon-login',
				'icon-magic-wand' => 'icon-magic-wand',
				'icon-magnet' => 'icon-magnet',
				'icon-magnet-1' => 'icon-magnet-1',
				'icon-magnet-2' => 'icon-magnet-2',
				'icon-map' => 'icon-map',
				'icon-map-1' => 'icon-map-1',
				'icon-map-2' => 'icon-map-2',
				'icon-map-location' => 'icon-map-location',
				'icon-megaphone' => 'icon-megaphone',
				'icon-megaphone-1' => 'icon-megaphone-1',
				'icon-menu' => 'icon-menu',
				'icon-menu-1' => 'icon-menu-1',
				'icon-menu-2' => 'icon-menu-2',
				'icon-menu-3' => 'icon-menu-3',
				'icon-menu-4' => 'icon-menu-4',
				'icon-microphone' => 'icon-microphone',
				'icon-microphone-1' => 'icon-microphone-1',
				'icon-minus' => 'icon-minus',
				'icon-minus-1' => 'icon-minus-1',
				'icon-more' => 'icon-more',
				'icon-more-1' => 'icon-more-1',
				'icon-more-2' => 'icon-more-2',
				'icon-multiply' => 'icon-multiply',
				'icon-multiply-1' => 'icon-multiply-1',
				'icon-music-player' => 'icon-music-player',
				'icon-music-player-1' => 'icon-music-player-1',
				'icon-music-player-2' => 'icon-music-player-2',
				'icon-music-player-3' => 'icon-music-player-3',
				'icon-mute' => 'icon-mute',
				'icon-muted' => 'icon-muted',
				'icon-navigation' => 'icon-navigation',
				'icon-navigation-1' => 'icon-navigation-1',
				'icon-network' => 'icon-network',
				'icon-newspaper' => 'icon-newspaper',
				'icon-next' => 'icon-next',
				'icon-note' => 'icon-note',
				'icon-notebook' => 'icon-notebook',
				'icon-notebook-1' => 'icon-notebook-1',
				'icon-notebook-2' => 'icon-notebook-2',
				'icon-notebook-3' => 'icon-notebook-3',
				'icon-notebook-4' => 'icon-notebook-4',
				'icon-notebook-5' => 'icon-notebook-5',
				'icon-notepad' => 'icon-notepad',
				'icon-notepad-1' => 'icon-notepad-1',
				'icon-notepad-2' => 'icon-notepad-2',
				'icon-notification' => 'icon-notification',
				'icon-paper-plane' => 'icon-paper-plane',
				'icon-paper-plane-1' => 'icon-paper-plane-1',
				'icon-pause' => 'icon-pause',
				'icon-pause-1' => 'icon-pause-1',
				'icon-percent' => 'icon-percent',
				'icon-percent-1' => 'icon-percent-1',
				'icon-perspective' => 'icon-perspective',
				'icon-photo-camera' => 'icon-photo-camera',
				'icon-photo-camera-1' => 'icon-photo-camera-1',
				'icon-photos' => 'icon-photos',
				'icon-picture' => 'icon-picture',
				'icon-picture-1' => 'icon-picture-1',
				'icon-picture-2' => 'icon-picture-2',
				'icon-pin' => 'icon-pin',
				'icon-placeholder' => 'icon-placeholder',
				'icon-placeholder-1' => 'icon-placeholder-1',
				'icon-placeholder-2' => 'icon-placeholder-2',
				'icon-placeholder-3' => 'icon-placeholder-3',
				'icon-placeholders' => 'icon-placeholders',
				'icon-play-button' => 'icon-play-button',
				'icon-play-button-1' => 'icon-play-button-1',
				'icon-plus' => 'icon-plus',
				'icon-power' => 'icon-power',
				'icon-previous' => 'icon-previous',
				'icon-price-tag' => 'icon-price-tag',
				'icon-print' => 'icon-print',
				'icon-push-pin' => 'icon-push-pin',
				'icon-radar' => 'icon-radar',
				'icon-reading' => 'icon-reading',
				'icon-record' => 'icon-record',
				'icon-repeat' => 'icon-repeat',
				'icon-repeat-1' => 'icon-repeat-1',
				'icon-restart' => 'icon-restart',
				'icon-resume' => 'icon-resume',
				'icon-rewind' => 'icon-rewind',
				'icon-rewind-1' => 'icon-rewind-1',
				'icon-route' => 'icon-route',
				'icon-save' => 'icon-save',
				'icon-search' => 'icon-search',
				'icon-search-1' => 'icon-search-1',
				'icon-send' => 'icon-send',
				'icon-server' => 'icon-server',
				'icon-server-1' => 'icon-server-1',
				'icon-server-2' => 'icon-server-2',
				'icon-server-3' => 'icon-server-3',
				'icon-settings' => 'icon-settings',
				'icon-settings-1' => 'icon-settings-1',
				'icon-settings-2' => 'icon-settings-2',
				'icon-settings-3' => 'icon-settings-3',
				'icon-settings-4' => 'icon-settings-4',
				'icon-settings-5' => 'icon-settings-5',
				'icon-settings-6' => 'icon-settings-6',
				'icon-settings-7' => 'icon-settings-7',
				'icon-settings-8' => 'icon-settings-8',
				'icon-settings-9' => 'icon-settings-9',
				'icon-share' => 'icon-share',
				'icon-share-1' => 'icon-share-1',
				'icon-share-2' => 'icon-share-2',
				'icon-shuffle' => 'icon-shuffle',
				'icon-shuffle-1' => 'icon-shuffle-1',
				'icon-shutdown' => 'icon-shutdown',
				'icon-sign' => 'icon-sign',
				'icon-sign-1' => 'icon-sign-1',
				'icon-skip' => 'icon-skip',
				'icon-smartphone' => 'icon-smartphone',
				'icon-smartphone-1' => 'icon-smartphone-1',
				'icon-smartphone-2' => 'icon-smartphone-2',
				'icon-smartphone-3' => 'icon-smartphone-3',
				'icon-smartphone-4' => 'icon-smartphone-4',
				'icon-smartphone-5' => 'icon-smartphone-5',
				'icon-smartphone-6' => 'icon-smartphone-6',
				'icon-smartphone-7' => 'icon-smartphone-7',
				'icon-smartphone-8' => 'icon-smartphone-8',
				'icon-smartphone-9' => 'icon-smartphone-9',
				'icon-smartphone-10' => 'icon-smartphone-10',
				'icon-smartphone-11' => 'icon-smartphone-11',
				'icon-speaker' => 'icon-speaker',
				'icon-speaker-1' => 'icon-speaker-1',
				'icon-speaker-2' => 'icon-speaker-2',
				'icon-speaker-3' => 'icon-speaker-3',
				'icon-speaker-4' => 'icon-speaker-4',
				'icon-speaker-5' => 'icon-speaker-5',
				'icon-speaker-6' => 'icon-speaker-6',
				'icon-speaker-7' => 'icon-speaker-7',
				'icon-speaker-8' => 'icon-speaker-8',
				'icon-spotlight' => 'icon-spotlight',
				'icon-star' => 'icon-star',
				'icon-star-1' => 'icon-star-1',
				'icon-stop' => 'icon-stop',
				'icon-stop-1' => 'icon-stop-1',
				'icon-stopwatch' => 'icon-stopwatch',
				'icon-stopwatch-1' => 'icon-stopwatch-1',
				'icon-stopwatch-2' => 'icon-stopwatch-2',
				'icon-stopwatch-3' => 'icon-stopwatch-3',
				'icon-stopwatch-4' => 'icon-stopwatch-4',
				'icon-street' => 'icon-street',
				'icon-street-1' => 'icon-street-1',
				'icon-substract' => 'icon-substract',
				'icon-substract-1' => 'icon-substract-1',
				'icon-success' => 'icon-success',
				'icon-switch' => 'icon-switch',
				'icon-switch-1' => 'icon-switch-1',
				'icon-switch-2' => 'icon-switch-2',
				'icon-switch-3' => 'icon-switch-3',
				'icon-switch-4' => 'icon-switch-4',
				'icon-switch-5' => 'icon-switch-5',
				'icon-switch-6' => 'icon-switch-6',
				'icon-switch-7' => 'icon-switch-7',
				'icon-tabs' => 'icon-tabs',
				'icon-tabs-1' => 'icon-tabs-1',
				'icon-target' => 'icon-target',
				'icon-television' => 'icon-television',
				'icon-television-1' => 'icon-television-1',
				'icon-time' => 'icon-time',
				'icon-trash' => 'icon-trash',
				'icon-umbrella' => 'icon-umbrella',
				'icon-unlink' => 'icon-unlink',
				'icon-unlocked' => 'icon-unlocked',
				'icon-unlocked-1' => 'icon-unlocked-1',
				'icon-unlocked-2' => 'icon-unlocked-2',
				'icon-upload' => 'icon-upload',
				'icon-user' => 'icon-user',
				'icon-user-1' => 'icon-user-1',
				'icon-user-2' => 'icon-user-2',
				'icon-user-3' => 'icon-user-3',
				'icon-user-4' => 'icon-user-4',
				'icon-user-5' => 'icon-user-5',
				'icon-user-6' => 'icon-user-6',
				'icon-user-7' => 'icon-user-7',
				'icon-users' => 'icon-users',
				'icon-users-1' => 'icon-users-1',
				'icon-video-camera' => 'icon-video-camera',
				'icon-video-camera-1' => 'icon-video-camera-1',
				'icon-video-player' => 'icon-video-player',
				'icon-video-player-1' => 'icon-video-player-1',
				'icon-video-player-2' => 'icon-video-player-2',
				'icon-view' => 'icon-view',
				'icon-view-1' => 'icon-view-1',
				'icon-view-2' => 'icon-view-2',
				'icon-volume-control' => 'icon-volume-control',
				'icon-volume-control-1' => 'icon-volume-control-1',
				'icon-warning' => 'icon-warning',
				'icon-wifi' => 'icon-wifi',
				'icon-wifi-1' => 'icon-wifi-1',
				'icon-windows' => 'icon-windows',
				'icon-windows-1' => 'icon-windows-1',
				'icon-windows-2' => 'icon-windows-2',
				'icon-windows-3' => 'icon-windows-3',
				'icon-windows-4' => 'icon-windows-4',
				'icon-wireless-internet' => 'icon-wireless-internet',
				'icon-worldwide' => 'icon-worldwide',
				'icon-worldwide-1' => 'icon-worldwide-1',
				'icon-zoom-in' => 'icon-zoom-in',
				'icon-zoom-out' => 'icon-zoom-out',
				'icon-add' => 'icon-add',
				'icon-add-1' => 'icon-add-1',
				'icon-add-2' => 'icon-add-2',
				'icon-add-3' => 'icon-add-3',
				'icon-agenda' => 'icon-agenda',
				'icon-alarm' => 'icon-alarm',
				'icon-alarm-1' => 'icon-alarm-1',
				'icon-alarm-clock' => 'icon-alarm-clock',
				'icon-alarm-clock-1' => 'icon-alarm-clock-1',
				'icon-albums' => 'icon-albums',
				'icon-app' => 'icon-app',
				'icon-archive' => 'icon-archive',
				'icon-archive-1' => 'icon-archive-1',
				'icon-archive-2' => 'icon-archive-2',
				'icon-archive-3' => 'icon-archive-3',
				'icon-attachment' => 'icon-attachment',
				'icon-back' => 'icon-back',
				'icon-battery' => 'icon-battery',
				'icon-battery-1' => 'icon-battery-1',
				'icon-battery-2' => 'icon-battery-2',
				'icon-battery-3' => 'icon-battery-3',
				'icon-battery-4' => 'icon-battery-4',
				'icon-battery-5' => 'icon-battery-5',
				'icon-battery-6' => 'icon-battery-6',
				'icon-battery-7' => 'icon-battery-7',
				'icon-battery-8' => 'icon-battery-8',
				'icon-battery-9' => 'icon-battery-9',
				'icon-binoculars' => 'icon-binoculars',
				'icon-blueprint' => 'icon-blueprint',
				'icon-bluetooth' => 'icon-bluetooth',
				'icon-bluetooth-1' => 'icon-bluetooth-1',
				'icon-bookmark' => 'icon-bookmark',
				'icon-bookmark-1' => 'icon-bookmark-1',
				'icon-briefcase' => 'icon-briefcase',
				'icon-broken-link' => 'icon-broken-link',
				'icon-calculator' => 'icon-calculator',
				'icon-calculator-1' => 'icon-calculator-1',
		);
	}
}
