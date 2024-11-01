<?php

/**
 *  WeddingCity Dashboard Menu
 */
if( ! class_exists( 'WeddingCity_Vendor_Menu' ) ) {

	class WeddingCity_Vendor_Menu extends WeddingCity_User{

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

            add_filter( 'weddingcity_vendor_dashboard_menu',

                function ( $args ){

                    return array_merge( $args, array(

                            'listings'          => array(

                                'menu_show'     =>  true,

                                'menu_name'     =>  esc_html__( 'My Listed Item', 'weddingcity' ),

                                'menu_icon'     =>  'fas fa-list-alt',

                                'menu_active'   =>  (   $_REQUEST['dashboard'] == 'vendor-listing'
                                                    ||  $_REQUEST['dashboard'] == 'add-listing'
                                                    ||  $_REQUEST['dashboard'] == 'update-listing' )

                                                    ? esc_html( 'active' ) : '',

                                'menu_link'     =>  esc_url( 

                                                        add_query_arg( array(

                                                            'dashboard' => esc_html( 'vendor-listing' )

                                                        ), WeddingCity_Template:: vendor_dashboard_template() )
                                                    ),
                            ),
                    )  );
                },

                absint( '10' )
            );

			/**
			 *  Display Couple Dashbaord
			 */
			
            add_filter( 'weddingcity_vendor_dashboard_menu',

                function ( $args ){

                    return array_merge( $args, array(

                            'dashboard'          	=> array(

								  	'menu_show'   	=>  true,

							      	'menu_name' 	=>  esc_html__( 'Dashboard', 'weddingcity' ),

							      	'menu_icon' 	=>  'fas fa-compass',

							      	'menu_active' 	=>  ( $_REQUEST['dashboard'] == 'vendor-dashboard' ) ? 'active' : '',

								  	'menu_link' 	=>  esc_url( 

									  						add_query_arg( array( 

									  							'dashboard' => esc_html( 'vendor-dashboard' ) 

									  						), WeddingCity_Template:: vendor_dashboard_template() ) 
								  					),
                            ),
                    )  );
                },

                absint( '5' )
            );

            /**
             *  Display Couple Profile Tab
             */
            
            add_filter( 'weddingcity_vendor_dashboard_menu',

                function ( $args ){

                    return array_merge( $args, array(

                            'profile'          		=> array(

							      	'menu_show'   	=> true,

							      	'menu_name' 	=> esc_html__( 'My Profile', 'weddingcity' ),

							      	'menu_icon' 	=> 'fas fa-user-circle',

							      	'menu_active' 	=> ( $_REQUEST['dashboard'] == 'vendor-profile' ) ? 'active' : '',

								  	'menu_link' 	=>  esc_url( 

									  						add_query_arg( array( 

									  							'dashboard' => esc_html( 'vendor-profile' ) 

									  						), WeddingCity_Template:: vendor_dashboard_template() ) 
								  					),
                            ),
                    )  );
                },

                absint( '50' )
            );

            /**
             *  Display Logout Tab
             */
            
            add_filter( 'weddingcity_vendor_dashboard_menu',

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

                absint( '60' )
            );


            add_filter( 'weddingcity_vendor_dashboard_summary',

                function ( $args ){

                    return array_merge( $args, array(

                            array(

                                // 1
                                'title'     =>  esc_html__( 'Total Listed Item', 'weddingcity' ),

                                // 2
                                'counter'   =>  absint( self:: number_of_pending_publihs_post_counter() ),

                                // 3
                                'btn_link'  => esc_url( WeddingCity_Vendor_Menu:: vendor_listing_link() ),

                                // 4
                                'btn_text'  => esc_html__( 'View All', 'weddingcity' )
                            )
                    )  );
                },

                absint( '5' )
            );
		}

        public static function number_of_pending_publihs_post_counter(){ 

            $args = array(

                    'post_type'         => 'listing',

                    'post_status'       =>  array( 'publish', 'pending' ),

                    'posts_per_page'    =>  -1,

                    'orderby'           => 'menu_order ID',

                    'order'             => 'post_date',

                    'author'            => WeddingCity_User::author_id()
            );

            $item = new WP_Query( $args );

            return absint( $item->found_posts);
        }

		public static function dashboard_menu( $args ){

			$vendor_menu 			= 	'';

			$current_link   		=   WeddingCity_Template:: vendor_dashboard_template();

			$menu_args 				=   apply_filters( 'weddingcity_vendor_dashboard_menu', array() );

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

			$_vendor_dashboard_menu = apply_filters( 'weddingcity_vendor_dashboard_menu', array() );

			if( WeddingCity_Loader:: array_condition( $_vendor_dashboard_menu ) ){

				foreach( $_vendor_dashboard_menu as $key => $value ){

					if( $key == $args ){

						return $value['menu_link'];
					}
				}
			}
		}

		public static function dashboard(){

			return self:: page_link( esc_html( 'dashboard' ) );
		}

		public static function vendor_listing_link(){

			return self:: page_link( esc_html( 'listings' ) );
		}

		public static function listing_pricing(){

			return self:: page_link( esc_html( 'pricing' ) );
		}

		public static function profile_page(){

			return self:: page_link( esc_html( 'profile' ) );
		}

		public static function new_listing(){

			return self:: page_link( esc_html( 'add_new_listing' ) );
		}

		public static function update_listing(){

			return self:: page_link( esc_html( 'update_listing' ) );
		}

		public static function vendor_invoice(){

			return self:: page_link( esc_html( 'invoice' ) );
		}

		public static function invoice_details(){

			return self:: page_link( esc_html( 'invoice_details' ) );
		}

		public static function request_quote_link(){

			return self:: page_link( esc_html( 'request_quote' ) );
		}

		public static function reviews_page_link(){

			return self:: page_link( esc_html( 'reviews' ) );
		}

	} // class ending

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    WeddingCity_Vendor_Menu::get_instance();

} // class_exists ending