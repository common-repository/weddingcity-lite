<?php

/**
 *  WeddingCity Email Builder
 */

if( ! class_exists( 'WeddingCity_Vendor_Profile' ) ){

    /**
     *  WeddingCity Emails
     */
    class WeddingCity_Vendor_Profile extends WeddingCity_Form_Fields{

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

            add_action( 'weddingcity_vendor_profile', array( $this, 'weddingcity_vendor_profile_markup' ) );

            add_action( 'wp_enqueue_scripts', array( $this, 'weddingcity_vendor_profile_script' ) );

            add_action( 'wp_ajax_weddingcity_vendor_profile_action',  array( $this, 'weddingcity_vendor_profile_action' ) );

            add_action( 'wp_ajax_nopriv_weddingcity_vendor_profile_action', array( $this, 'weddingcity_vendor_profile_action' ) );

            add_action( 'wp_ajax_weddingcity_vendor_user_password_change',  array( $this, 'weddingcity_vendor_user_password_change' ) );

            add_action( 'wp_ajax_nopriv_weddingcity_vendor_user_password_change', array( $this, 'weddingcity_vendor_user_password_change' ) );

            add_action( 'wp_ajax_weddingcity_vendor_social_profile_action',  array( $this, 'weddingcity_vendor_social_profile_action' ) );

            add_action( 'wp_ajax_nopriv_weddingcity_vendor_social_profile_action', array( $this, 'weddingcity_vendor_social_profile_action' ) );

            add_action( 'weddingcity_sidebar_vendor_information', array( $this, 'weddingcity_sidebar_vendor_information_markup' ) );
        }

        public static function weddingcity_vendor_profile_script(){

            if( isset( $_GET['dashboard'] ) && !empty( $_GET['dashboard'] ) && $_GET['dashboard'] == 'vendor-profile' ){

                wp_enqueue_style( 'weddingcity-vendor-profile', plugin_dir_url( __FILE__ ).'vendor-profile-style.css', array(), WEDDINGCITY_PLUGIN_VERSION, 'all' );

                wp_enqueue_script( 'weddingcity-vendor-profile', plugin_dir_url( __FILE__ ).'vendor-profile-script.js', array('jquery', 'google-map' ), WEDDINGCITY_PLUGIN_VERSION, true );
            }
        }

        public static function weddingcity_vendor_user_password_change(){

              $old_pwd        =   esc_html( $_POST['old_pwd'] );

              $new_pwd        =   esc_html( $_POST['new_pwd'] );

              $confirm_pwd    =   esc_html( $_POST['confirm_pwd'] );

              if( $new_pwd == '' || $confirm_pwd == '' ){

                    die( json_encode( array(

                      'redirect'  =>  false,

                      'notice'    => esc_html( '2', 'weddingcity' ),

                      'message'   =>  WeddingCity_Alert:: danger(

                                          esc_html__( 'The new password is blank', 'weddingcity' )
                                      )
                    ) ) );
              }
               
              if( $new_pwd != $confirm_pwd ){

                die( json_encode( array( 

                    'redirect'  =>  false,

                    'notice'    => esc_html( '0', 'weddingcity' ),

                    'message'   =>  WeddingCity_Alert:: danger(

                                        esc_html__( 'New Password and confirm password does not match.', 'weddingcity' )
                                    )
                  ) ) );
              }            
              
              $user = get_user_by( 'id', WeddingCity_User:: author_id() );

              if ( $user && wp_check_password( $old_pwd, $user->data->user_pass, $user->ID) ){

                    wp_set_password( $new_pwd, $user->ID );

                    $user_name  = get_userdata( $user->ID )->user_login;

                    $user_email = get_userdata( $user->ID )->user_email;

                    if( class_exists( 'WeddingCity_Email' ) ){

                          WeddingCity_Email:: change_password(

                              array(

                                  'username'      =>  sanitize_user( $user_name ),
                                  'password'      =>  esc_html( $new_pwd ),
                                  'email_id'      =>  sanitize_email( $user_email ),
                              )
                          );
                    }

                    wp_logout();

                    die( json_encode( array(

                      'redirect'  =>    true,

                      'notice'    => esc_html( '1', 'weddingcity' ),

                      'message'   =>    WeddingCity_Alert:: success(

                                            esc_html__( 'Password Updated. Please login again.', 'weddingcity' ) 
                                        )

                    ) ) );

              }else{

                    die( json_encode( array(

                      'redirect'  =>    false,

                      'notice'    => esc_html( '0', 'weddingcity' ),

                      'message'   =>    WeddingCity_Alert:: danger(

                                            esc_html__( 'Old Password is not correct.', 'weddingcity' ) 
                                        )
                    ) ) );
              }
        }

        public static function weddingcity_vendor_social_profile_action(){

              check_ajax_referer( 'social_media_update', 'security' );

              if(  null !== WeddingCity_User:: post_id() ){

                  global $post, $wp_query;

                  $post_id = absint( WeddingCity_User:: post_id() );

                  foreach( $_POST as $key => $value  ){

                    update_post_meta( $post_id,  esc_html( $key ),  $_POST[ $key ]  );
                  }

                  die( json_encode( array( 

                    'message' =>  WeddingCity_Alert:: success(

                                      esc_html__( 'Social Media Updated Successfully', 'weddingcity' ) 
                                  )
                  ) ) );

              }else{

                  die( json_encode( array( 

                    'message' =>    WeddingCity_Alert:: danger(

                                        esc_html__( 'Social Media Updated Error... Please login again then update your profile.', 'weddingcity' ) 
                                    )
                  ) ) );
              }
        }

        public static function weddingcity_vendor_profile_action(){

              check_ajax_referer( 'profile_update', 'security' );

              if(  null !== WeddingCity_User:: post_id()  ){

                  $post_id = absint( WeddingCity_User:: post_id() );

                  wp_update_post( array(

                        'ID'           => absint( $post_id ),
                        'post_content' => wp_filter_post_kses( $_POST[ 'post_content' ] ),
                  ) );

                  foreach( $_POST as $key => $value  ){

                    update_post_meta( $post_id,  esc_html( $key ),  $_POST[ $key ]  );
                  }

                  die( json_encode( array( 

                    'message' =>  WeddingCity_Alert:: success(

                                      esc_html__( 'Profile Updated Successfully', 'weddingcity' ) 
                                  )
                  ) ) );

              }else{

                  die( json_encode( array( 

                    'message' =>    WeddingCity_Alert:: danger(

                                        esc_html__( 'Profile Updated Error... Please login again then update your profile.', 'weddingcity' ) 
                                    )
                  ) ) );
              }
        }

        /**
         * [page_title description]
         * @return [ Page Title ]
         */
        public static function page_title(){

            return esc_html__( 'My Profile', 'weddingcity' );
        }

        public static function page_description(){

            return esc_html__( 'Change your profile image and information edit and save.', 'weddingcity' );
        }

        public static function weddingcity_vendor_profile_page_title(){

            WeddingCity_Dashboard:: dashboard_page_header(

                    // 1
                    self:: page_title(),

                    // 2
                    self:: page_description()
            );
        }

        public static function weddingcity_vendor_profile_markup(){

            self:: weddingcity_vendor_profile_page_title();

            if( WeddingCity_Loader:: array_condition( self:: get_list_of_tabs() ) ){

                parent:: display_tab_with_content( self:: get_list_of_tabs() );
            }
        }


        public static function get_list_of_tabs(){

            $_list      =   array();

            $_list[]    =   array(

                'class'     =>  __CLASS__,
                'function'  => 'weddingcity_profile_update_markup',

                'display'   =>  true,

                'tab_name'  =>  esc_html__( 'Profile', 'weddingcity' ),
                'active'    =>  true,

                'form_id'   => 'weddingcity_vendor_profile_update',


                'btn_id'    =>  'profile_update_btn',
                'btn_name'  =>  esc_html__( 'Update Profile', 'weddingcity' ),
                'nonce'     =>  'profile_update',  
            );

            $_list[]    =   array(

                'class'     =>  __CLASS__,
                'function'  => 'weddingcity_vendor_password_change_markup',
                    
                'tab_name'  =>  esc_html__( 'Password Change', 'weddingcity' ),
                'active'    =>  false,
                'display'   =>  true,

                'form_id'   => 'vendor_user_password_change',

                'btn_id'    =>  'vendor_user_password_change_btn',
                'btn_name'  =>  esc_html__('Change Password','weddingcity'),
                'nonce'     =>  'change_password_security',
            );

            $_list[]    =   array(

                'class'     =>  __CLASS__,
                'function'  => 'weddingcity_vendor_social_markup',
                    
                'tab_name'  =>  esc_html__( 'Social Media', 'weddingcity' ),
                'active'    =>  false,
                'display'   =>  true,

                'form_id'   => 'weddingcity_vendor_social_notification',

                'btn_id'    =>  'vendor_social_media_submit',
                'btn_name'  =>  esc_html__('Update Social Profile','weddingcity'),
                'nonce'     =>  'social_media_update',
            );

            // $_list[]    =   array(

            //     'class'     =>  __CLASS__,
            //     'function'  => 'weddingcity_email_notification_markup',
                    
            //     'tab_name'  =>  esc_html__( 'Email Notifications', 'weddingcity' ),
            //     'active'    =>  false,
            //     'display'   =>  true,

            //     'form_id'   => 'weddingcity_vendor_email_notification',

            //     'btn_id'    =>  '',
            //     'btn_name'  =>  '',
            //     'nonce'     =>  '',
            // );

            // $_list[]    =   array(

            //     'class'     =>  __CLASS__,
            //     'function'  => 'weddingcity_delete_account_markup',
                    
            //     'tab_name'  =>  esc_html__( 'Delete Account', 'weddingcity' ),
            //     'active'    =>  false,
            //     'display'   =>  true,

            //     'form_id'   => 'weddingcity_vendor_delete_account',

            //     'btn_id'    =>  '',
            //     'btn_name'  =>  '',
            //     'nonce'     =>  '',
            // );

            return $_list;
        }

        /*
         *.  Tab Content
         *
         */
        public static function weddingcity_profile_update_markup(){

            /**
             *  Profile Upload
             */
            parent:: weddingcity_single_image_upload( array(

                    'object'        => esc_attr( 'Profile_Upload_Object' ),

                    'image_id'      => WeddingCity_Vendor_Meta:: profile_user_image_id(),

                    'image_src'     => WeddingCity_Vendor_Meta:: profile_user_image(),

                    'btn_lable'     => esc_html__( 'Upload Profile Image', 'weddingcity' ),

                    'border_top'    => false,
            ) );

            /**  User name  */
            parent:: weddingcity_dashboard_section_text( array(

                  'lable'             =>  esc_attr__( 'Name', 'weddingcity' ),

                  'placeholder'       =>  esc_attr__( 'Name', 'weddingcity' ),

                  'name'              =>  WeddingCity_Vendor_Meta:: profile_first_name_meta_name(),

                  'value'             =>  WeddingCity_Vendor_Meta:: profile_first_name(),
            ) );


            /**  Email  */
            parent:: weddingcity_dashboard_section_email( array(

                  'lable'             =>  esc_attr__( 'Email', 'weddingcity' ),

                  'placeholder'       =>  esc_attr__( 'johndea@example.com', 'weddingcity' ),

                  'name'              =>  WeddingCity_Vendor_Meta:: profile_user_email_meta_name(),

                  'value'             =>  WeddingCity_Vendor_Meta:: profile_user_email(),
            ) );

            /**  User Contact Number  */
            parent:: weddingcity_dashboard_section_text( array(

                  'lable'             =>  esc_attr__( 'Contact Number', 'weddingcity' ),

                  'placeholder'       =>  esc_attr__( 'e.g. 123 456 7890', 'weddingcity' ),

                  'name'              =>  WeddingCity_Vendor_Meta:: profile_user_contact_meta_name(),

                  'value'             =>  WeddingCity_Vendor_Meta:: profile_user_contact(),
            ) );

            /**  User Address  */
            parent:: weddingcity_dashboard_section_text( array(

                  'lable'             =>  esc_attr__( 'Address', 'weddingcity' ),

                  'placeholder'       =>  esc_attr__( 'Street Address.', 'weddingcity' ),

                  'name'              =>  WeddingCity_Vendor_Meta:: profile_user_address_meta_name(),

                  'value'             =>  WeddingCity_Vendor_Meta:: profile_user_address(),
            ) );
        }

        public static function weddingcity_vendor_password_change_markup(){

            // old - password
            parent:: weddingcity_dashboard_section_password_field( array(

                  'lable'             =>  esc_attr__( 'Old Password', 'weddingcity' ),

                  'placeholder'       =>  esc_attr__( 'Old Password', 'weddingcity' ),

                  'name'              =>  esc_attr( 'old_pwd' ),

                  'border_top'        =>  false
            ) );

            // new password
            parent:: weddingcity_dashboard_section_password_field( array(

                  'lable'             =>  esc_attr__( 'New Password', 'weddingcity' ),

                  'placeholder'       =>  esc_attr__( 'New Password', 'weddingcity' ),

                  'name'              =>  esc_attr( 'new_pwd' ),
            ) );

            // confirm password
            parent:: weddingcity_dashboard_section_password_field( array(

                  'lable'             =>  esc_attr__( 'Confirm Password', 'weddingcity' ),

                  'placeholder'       =>  esc_attr__( 'Confirm Password', 'weddingcity' ),

                  'name'              =>  esc_attr( 'confirm_pwd' ),
            ) );
        }

        public static function weddingcity_vendor_social_markup(){

            /**  Facebook  */
            parent:: weddingcity_dashboard_section_website( array(

                  'lable'             =>  esc_attr__( 'Facebook', 'weddingcity' ),

                  'placeholder'       =>  esc_attr__( 'Facebook', 'weddingcity' ),

                  'name'              =>  WeddingCity_Vendor_Meta:: social_media_facebook_meta_name(),

                  'value'             =>  WeddingCity_Vendor_Meta:: social_media_facebook(),

                  'border_top'        =>  false,

                  'require'           =>  false,
            ) );

            /**  Twitter  */
            parent:: weddingcity_dashboard_section_website( array(

                  'lable'             =>  esc_attr__( 'Twitter', 'weddingcity' ),

                  'placeholder'       =>  esc_attr__( 'Twitter', 'weddingcity' ),

                  'name'              =>  WeddingCity_Vendor_Meta:: social_media_twitter_meta_name(),

                  'value'             =>  WeddingCity_Vendor_Meta:: social_media_twitter(),

                  'require'           =>  false,
            ) );

            /**  Instagram  */
            parent:: weddingcity_dashboard_section_website( array(

                  'lable'             =>  esc_attr__( 'Instagram', 'weddingcity' ),

                  'placeholder'       =>  esc_attr__( 'Instagram', 'weddingcity' ),

                  'name'              =>  WeddingCity_Vendor_Meta:: social_media_instagram_meta_name(),

                  'value'             =>  WeddingCity_Vendor_Meta:: social_media_instagram(),

                  'require'           =>  false,
            ) );

            /**  Youtube  */
            parent:: weddingcity_dashboard_section_website( array(

                  'lable'             =>  esc_attr__( 'Youtube', 'weddingcity' ),

                  'placeholder'       =>  esc_attr__( 'Youtube', 'weddingcity' ),

                  'name'              =>  WeddingCity_Vendor_Meta:: social_media_youtube_meta_name(),

                  'value'             =>  WeddingCity_Vendor_Meta:: social_media_youtube(),

                  'require'           =>  false,
            ) );
        }

        public static function weddingcity_email_notification_markup(){

            parent:: section_card_body_start();

                ?><div class="col-12"><?php esc_html_e( 'Changes your Email Notifications', 'weddingcity' ); ?></div><?php

            parent:: section_card_body_end();
        }

        public static function weddingcity_delete_account_markup(){

            parent:: section_card_body_start();

                ?><div class="col-12"><?php esc_html_e( 'Delete Account', 'weddingcity' ); ?></div><?php

            parent:: section_card_body_end();
        }

        public static function get_vendor_post_id(){

            return absint(  WeddingCity_Listing_Meta:: listing_vendor( get_the_ID() ) );
        }

        public static function weddingcity_sidebar_vendor_information_markup(){

              $_vendor_id           =   absint( self:: get_vendor_post_id() );

              if( empty( $_vendor_id ) && ! isset( $_vendor_id )  ){

                  return;
              }

              $user_website       =   get_post_meta( $_vendor_id, WeddingCity_Vendor_Meta:: profile_user_website_meta_name()    , true );
              $user_phone         =   get_post_meta( $_vendor_id, WeddingCity_Vendor_Meta:: profile_user_contact_meta_name()    , true );
              $image_id           =   get_post_meta( $_vendor_id, WeddingCity_Vendor_Meta:: profile_user_image_id_meta_name()   , true );
              $user_image         =   get_post_meta( $_vendor_id, WeddingCity_Vendor_Meta:: profile_user_image_meta_name()      , true );
              $user_address       =   get_post_meta( $_vendor_id, WeddingCity_Vendor_Meta:: profile_user_address_meta_name()    , true );
              $business_name      =   get_post_meta( $_vendor_id, WeddingCity_Vendor_Meta:: profile_business_name_meta_name()   , true );

              print '<div class="vendor-owner-profile mb30 card border card-shadow-none">';

                  printf('    <div class="vendor-owner-profile-head">

                                  <div class="venue-admin-img mb-3">
                                      <img src="%1$s" class="rounded-circle" alt="%2$s" />
                                  </div>                                

                                  <h4 class="vendor-owner-name mb0"><a href="%3$s">%2$s</a></h4>

                              </div>',

                              // 1
                              ( ! empty( $user_image ) )

                              ?   esc_url( $user_image )

                              :   WeddingCity_User_Meta:: default_avtar(),

                              // 2
                              esc_html( $business_name ),

                              // 3
                              esc_url( get_the_permalink( $_vendor_id ) )
                  );

                  if( $user_address != '' || $user_phone != '' || $user_website != '' ){

                      print '<div class="vendor-owner-profile-content"><ul class="list-group list-group-flush">';

                              if( $user_address != '' ){

                                  printf( '<li class="list-group-item"><span class="mr-2"><i class="fas fa-fw fa-map-marker-alt"></i></span> %1$s</li>',

                                          // 1
                                          esc_html( $user_address )
                                  );
                              }

                              if( $user_phone != '' ){

                                  printf( '<li class="list-group-item"><span class="mr-2"><i class="fas fa-fw fa-phone"></i></span> %1$s</li>',

                                          // 1
                                          esc_attr( $user_phone )
                                  );
                              }

                              if( $user_website != '' ){

                                  printf( '<li class="list-group-item text-default"><a href="%1$s" title="%1$s" target="_blank"><span class="mr-2"><i class="fas fa-fw fa-envelope"></i></span> %1$s</a></li>',

                                          // 1
                                          esc_url( $user_website )
                                  );
                              }

                      print '</ul></div>';
                  }

              print '</div><!-- Vendor Details -->';
        }
    }

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    WeddingCity_Vendor_Profile::get_instance();
    
}