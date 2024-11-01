<?php

/**
 *  WeddingCity Dashboard Menu
 */
if( ! class_exists( 'WeddingCity_Couple_Menu' ) ) {

	/**
	 *  Couple Dashboard Menu
	 */
	class WeddingCity_Couple_Menu extends WeddingCity_User{

        /**
         * Member Variable
         *
         * @var instance
         */
        private static $instance;

        /**
         *  Initiator
         */
        public static function get_instance() {
          
            if ( ! isset( self::$instance ) ) {
              self::$instance = new self;
            }
            return self::$instance;
        }

        public function __construct() {

        	self:: weddingcity_default_menu_list();
        }

		public static function weddingcity_default_menu_list(){

			/**
			 *  Display Couple Dashbaord
			 */
			
            add_filter( 'weddingcity_couple_dashboard_menu',

                function ( $args ){

                    return array_merge( $args, array(

                            'dashboard'          	=> array(

								  	'menu_show'   	=>  true,

							      	'menu_name' 	=>  esc_html__( 'Dashboard', 'weddingcity' ),

							      	'menu_icon' 	=>  'fas fa-compass',

							      	'menu_active' 	=>  ( $_REQUEST['dashboard'] == 'couple-dashboard' ) ? 'active' : '',

								  	'menu_link' 	=>  esc_url( 

									  						add_query_arg( array( 

									  							'dashboard' => esc_html( 'couple-dashboard' ) 

									  						), WeddingCity_Template:: couple_dashboard_template() ) 
								  					),
                            ),
                    )  );
                },

                absint( '5' )
            );

            /**
             *  Display Couple Profile Tab
             */
            
            add_filter( 'weddingcity_couple_dashboard_menu',

                function ( $args ){

                    return array_merge( $args, array(

                            'profile'          		=> array(

							      	'menu_show'   	=> true,

							      	'menu_name' 	=> esc_html__( 'My Profile', 'weddingcity' ),

							      	'menu_icon' 	=> 'fas fa-user-circle',

							      	'menu_active' 	=> ( $_REQUEST['dashboard'] == 'couple-profile' ) ? 'active' : '',

								  	'menu_link' 	=>  esc_url( 

									  						add_query_arg( array( 

									  							'dashboard' => esc_html( 'couple-profile' ) 

									  						), WeddingCity_Template:: couple_dashboard_template() ) 
								  					),
                            ),
                    )  );
                },

                absint( '40' )
            );

            /**
             *  Display Logout Tab
             */
            
            add_filter( 'weddingcity_couple_dashboard_menu',

                function ( $args ){

                    return array_merge( $args, array(

                            'logout'          		=> array(

							      	'menu_show'   	=> true,

							      	'menu_name' 	=> esc_html__( 'Logout', 'weddingcity' ),

							      	'menu_icon' 	=> 'fas fa-sign-out-alt',

							      	'menu_active' 	=> ( $_REQUEST['dashboard'] == 'logout' ) ? 'active' : '',

							      	'menu_link' 	=> wp_logout_url( home_url() ),
                            ),
                    )  );
                },

                absint( '50' )
            );
		}

		public static function dashboard_menu( $args ){

			$vendor_menu 			= 	'';

			$current_link   		=   WeddingCity_Template:: couple_dashboard_template();

			$menu_args 				=   apply_filters( 'weddingcity_couple_dashboard_menu', array() );

			$first_name           	= 	parent:: get_data( 'user_name' ); // first_name

			$profile_attached_url 	= 	WeddingCity_User_Meta:: image_exists(

											parent:: get_data( 'user_image' )
										);

			if( $args == 'side' && WeddingCity_Loader:: array_condition( $menu_args ) ){

				foreach( $menu_args as $key => $value){

					if( $value['menu_show'] === true ){

					    $vendor_menu .= 

					    sprintf( '<li class="%4$s"><a href="%1$s"><span class="dash-nav-icon"><i class="%2$s"></i></span>%3$s</a></li>',

					    	// 1
							esc_url( $value['menu_link'] ),

							// 2
						   	$value['menu_icon'],

						   	// 3
						   	esc_html( $value['menu_name'] ),

						   	// 4
						    esc_html( $value['menu_active'] )
						);
					}
				}

				return

			    sprintf('<div class="dashboard-sidebar offcanvas-collapse">
					        <div class="vendor-user-profile">
					            <div class="vendor-profile-img">
					                <img class="author-uploaded-image-src rounded-circle" src="%1$s" alt="%6$s"/>
					            </div>
					            <h3 class="vendor-profile-name">%2$s</h3>
					            <a href="%3$s" class="edit-link">%4$s</a>
					        </div>
					        <div class="dashboard-nav">
					            <ul class="list-unstyled">
					            	%5$s
					            </ul>
					        </div>
					    </div>',

					    // 1
					    esc_url( $profile_attached_url ),

					    // 2
						esc_html( $first_name ),

						// 3
						esc_url( self:: profile_page() ),

						// 4
						esc_html__( 'edit profile', 'weddingcity' ),

						// 5
						$vendor_menu,

						// 6
						esc_html( get_option('blogname') )
				);

			}else{

				if( WeddingCity_Loader:: array_condition( $menu_args ) ){

					foreach( $menu_args as $key => $value){

						if( $value['menu_show'] === true ){

						    $vendor_menu .=

						    sprintf( '<a class="dropdown-item" href="%1$s">%2$s</a>',

						    	// 1
						       	esc_url( $value['menu_link'] ),

						       	// 2
						        esc_html( $value['menu_name'] )
						    );
						}
					}
				}

				return

		        sprintf('<div class="user-vendor"><div class="dropdown">
		                  	<a class="dropdown-toggle" id="dropdownMenuButton" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		                 		<span class="user-icon">  
		                 			<img src="%1$s" alt="%4$s" class="rounded-circle author-uploaded-image-src" />
		                 		</span>
		                 		<span class="user-vendor-name">%2$s</span> 
		              		</a>
			                <div class="dashboard-dropdown-menu dropdown-menu" aria-labelledby="dropdownMenuButton">
			                      %3$s
			                </div>
		              	</div></div>',

		              	// 1
		          		esc_url( $profile_attached_url ),

		          		// 2
				        esc_html( $first_name ),

				        // 3
		          		$vendor_menu,

		          		// 4
		          		get_option( 'blogname' )
			    );

			} // else
		}

		public static function page_link( $args ){

			$_couple_dashboard_menu = apply_filters( 'weddingcity_couple_dashboard_menu', array() );

			if( WeddingCity_Loader:: array_condition( $_couple_dashboard_menu ) ){

				foreach( $_couple_dashboard_menu as $key => $value ){

					if( $key == $args ){

						return $value['menu_link'];
					}
				}
			}
		}

		public static function dashboard(){

			return self:: page_link( esc_html( 'dashboard' ) );
		}

		public static function wishlist_page(){

			return self:: page_link( esc_html( 'wishlist' ) );
		}

		public static function profile_page(){

			return self:: page_link( esc_html( 'profile' ) );
		}

		public static function logout_page(){

			return self:: page_link( esc_html( 'logout' ) );
		}

		public static function todo_page(){

			return self:: page_link( esc_html( 'checklist' ) );
		}

		public static function budget_page(){

			return self:: page_link( esc_html( 'budget_calculator' ) );
		}

		public static function guest_list_page(){

			return self:: page_link( esc_html( 'guest_list' ) );
		}

		public static function add_new_guest_page(){

			return self:: page_link( esc_html( 'add_new_guest' ) );
		}

		public static function update_guest_page(){

			return self:: page_link( esc_html( 'update_guest' ) );
		}		

		public static function seating_table_page(){

			return self:: page_link( absint( '5' ) );
		}

		public static function rsvp_page(){

			return self:: page_link( esc_html( 'rsvp' ) );
		}

		public static function real_wedding_page(){

			return self:: page_link( absint( '7' ) );
		}


	} // class ending

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    WeddingCity_Couple_Menu::get_instance();

} // class_exists ending