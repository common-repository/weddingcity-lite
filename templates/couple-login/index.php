<?php

if( ! class_exists( 'WeddingCity_Couple_Login' ) ){

    class WeddingCity_Couple_Login{

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

            add_action( 'weddingcity_couple_login',  array( $this, 'weddingcity_couple_login' ) );

            add_action( 'weddingcity_couple_login_top', array( $this, 'weddingcity_couple_login_top' ) );

            add_action( 'weddingcity_couple_login_bottom', array( $this, 'weddingcity_couple_login_bottom' ) );

            add_action( 'weddingcity_couple_login_content', array( $this, 'weddingcity_couple_login_content' ) );

            add_action( 'weddingcity_couple_login_content_tab', array( $this, 'weddingcity_couple_login_content_tab' ) );

            add_action( 'weddingcity_couple_login_content_tab_content', array( $this, 'weddingcity_couple_login_content_tab_content' ) );

            add_action( 'wp_enqueue_scripts', array( $this, 'weddingcity_couple_login_script' ) );

            add_action( 'wp_ajax_weddingcity_couple_register',  array( $this, 'weddingcity_couple_register' ) );

            add_action( 'wp_ajax_nopriv_weddingcity_couple_register', array( $this, 'weddingcity_couple_register' ) );

            add_action( 'wp_ajax_weddingcity_couple_login_module',  array( $this, 'weddingcity_couple_login_module' ) );

            add_action( 'wp_ajax_nopriv_weddingcity_couple_login_module', array( $this, 'weddingcity_couple_login_module' ) );
        }

        /**
         *  [weddingcity_couple_login_module description]
         *  
         *  @return [login] [vendor login function]
         *  
         *  @link https://developer.wordpress.org/reference/functions/wp_signon/ 
         *  @link https://developer.wordpress.org/reference/functions/is_wp_error/
         *  @link http://natko.com/wordpress-ajax-login-without-a-plugin-the-right-way/
         * 
         */
        public static function weddingcity_couple_login_module(){

            check_ajax_referer( 'weddingcity-login', 'security' );

            $info                     = array();

            $info['user_login']       = esc_html( $_POST['WeddingCity_Username'] );

            $info['user_password']    = esc_html( $_POST['WeddingCity_password'] );

            $info['remember']         = true;

            $user_signon              = wp_signon( $info, false );

            $user_assign_post_id      = WeddingCity_User::author_info( $user_signon->data->ID, 'user_access_post_id' );

            $user_type                = WeddingCity_User::user_type( $user_assign_post_id );


            if( $user_type == esc_html( 'vendor') && $_POST['user_type'] == esc_html( 'vendor_login' ) ){

                  $redirect_link = WeddingCity_Vendor_Menu:: dashboard();

            }elseif( $user_type == esc_html( 'couple' ) && $_POST['user_type'] == esc_html( 'couple_login' )  ){

                  $redirect_link = WeddingCity_Couple_Menu:: dashboard();

            }elseif( $user_type == esc_html( 'vendor' ) && $_POST['user_type'] == esc_html( 'couple_login' ) ){

                wp_logout();

                die( json_encode( array(

                  'redirect'        =>  false,

                  'dashbaord'       =>  WeddingCity_Template:: vendor_login_template(),

                  'notice'          => '2',

                  'message'         =>  WeddingCity_Alert:: warning(

                                              sprintf( 'Hello %1$s, Please login through your vendor login page.',

                                                  // 1
                                                  $user_signon->data->user_login
                                              )
                                        )
                ) ) );

            }elseif( $user_type == esc_html( 'couple' ) && $_POST['user_type'] == esc_html( 'vendor_login' )  ){

                wp_logout();

                die( json_encode( array(

                  'redirect'        =>  false,

                  'notice'          => '2',

                  'dashbaord'       =>  WeddingCity_Template:: couple_login_template(),

                  'message'         =>  WeddingCity_Alert:: warning(

                                              sprintf( 'Hello %1$s, Please login through your couple login page.',

                                                $user_signon->data->user_login
                                              )
                                        )
                ) ) );
            }


            if ( is_wp_error( $user_signon ) ){  // login error condition

                  die( json_encode( array( 

                    'redirect'        =>  false,

                    'dashbaord'       =>  home_url( '/' ),

                    'notice'          => '0',

                    'message'         =>  WeddingCity_Alert:: danger(

                                                esc_html__( 'Wrong username or password.','weddingcity') 
                                          )

                  ) ) );

            } else {

                  die( json_encode( array( 

                    'redirect'        =>  true,

                    'dashbaord'       =>  $redirect_link,

                    'notice'          => '1',

                    'message'         =>  WeddingCity_Alert:: success(

                                                esc_html__('Login successful, redirecting...','weddingcity') 
                                          )
                  ) ) );
            }
        }

        /**
         * [weddingcity_couple_register description]
         * 
         * @return [registration] [vendor registration]
         */
        public static function weddingcity_couple_register(){

            global $post, $wp_query;

            check_ajax_referer( 'couple_security', 'security' );
            
            $user_name        =   sanitize_user( $_POST['couple_username'] );

            $user_email       =   sanitize_email( $_POST['couple_email'] );

            $weddingdate      =   $_POST['couple_wedding_date'];
            
            $error = false;

            $note = '';

            $user_id = username_exists( $user_name );

            if ( ! $user_id && email_exists( $user_email ) == false && ( $user_email != '' )  && ( $user_name != '' ) && is_email( $user_email ) ) {

              $random_password      =   wp_generate_password( 

                                            $length = absint('12'),

                                            $include_standard_special_chars = false
                                        );


              $user_id              =   wp_create_user( $user_name, $random_password, $user_email );

              $_couple_post         =   array(
                
                            'post_author'       =>  absint( '1' ),
                            'post_name'         =>  esc_html( $user_name ),
                            'post_title'        =>  esc_html( $user_name ),
                            'post_status'       =>  esc_html( 'publish' ),
                            'post_type'         =>  esc_html( 'couple' ),
                            'post_content'      =>  sprintf( '%1$s %2$s',

                                                        esc_html__( 'Welcome ', 'weddingcity' ),
                                                        esc_html( $user_name )
                                                    ),
              );

              $_real_wedding_post   = array(
                
                            'post_author'       =>  absint( '1' ),
                            'post_name'         =>  esc_html( $user_name ),
                            'post_title'        =>  esc_html( $user_name ),
                            'post_status'       =>  esc_html( 'pending' ),
                            'post_type'         =>  esc_html( 'real-wedding' ),
                            'post_content'      =>  sprintf( '%1$s %2$s',

                                                        esc_html__( 'Welcome ', 'weddingcity' ),
                                                        esc_html( $user_name )
                                                    ),
              );

              $_couple_post_id            =  wp_insert_post( $_couple_post );

              $_real_wedding_post_id      =  wp_insert_post( $_real_wedding_post );


              update_user_meta( $user_id, 'user_access_post_id',  absint( $_couple_post_id ) );

              $_couple_post_meta_array    = array(

                      'user_id'                     =>  absint( $user_id ), 
                      'user_name'                   =>  esc_html( $user_name ), 
                      'user_type'                   =>  esc_html( 'couple' ), 
                      'first_name'                  =>  esc_html( 'User #'. $user_id ), 
                      'user_email'                  =>  esc_html( $user_email ),
                      'user_image'                  =>  WeddingCity_User_Meta:: default_avtar(),
                      'wedding_date'                =>  $weddingdate,
                      'realwedding_post_id'         =>  absint( $_real_wedding_post_id )
              );

              foreach( $_couple_post_meta_array as $key => $value ){

                update_post_meta( $_couple_post_id,  $key,  $value );
              }


              /** Real Wedding **/

              $_real_wedding_post_meta_array  =  array(

                    'wedding_date'              =>  date( $weddingdate ),
                    'realwedding_couple_id'     =>  absint( $_couple_post_id )
              );

              foreach( $_real_wedding_post_meta_array as $key => $value ){

                update_post_meta( $_real_wedding_post_id,  $key,  $value );
              }

              if( class_exists( 'WeddingCity_Email' ) ){

                    WeddingCity_Email:: couple_registration(

                        array(

                            'username'      =>  $user_name,
                            'password'      =>  $random_password,
                            'email_id'      =>  $user_email,
                        )
                    );
              }    

                  $note = 

                  WeddingCity_Alert:: success(

                      esc_html__('Please check your inbox or spam/junk and get your password','weddingcity') 
                  );

            }elseif( email_exists( $user_email ) == true ){

              $error = true;

              $note = 

              WeddingCity_Alert:: danger(

                  esc_html__('This Email already exists','weddingcity') 
              );

            }elseif( empty( $user_email ) ){

              $error = true;

              $note = 

              WeddingCity_Alert:: danger(

                  esc_html__('Email field is empty','weddingcity') 
              );

            }elseif( ! is_email( $user_email ) ){

              $error = true;

              $note = 

              WeddingCity_Alert:: danger(

                  esc_html__('Please provide correct email.','weddingcity') 
              );

            }elseif( username_exists( $user_name ) == true ){

              $error = true;

              $note = 

              WeddingCity_Alert:: danger(

                  esc_html__('This Username already exists','weddingcity')
              );              

            }elseif( empty( $user_name ) ){
              
              $error = true;

              $note = 

              WeddingCity_Alert:: danger(

                  esc_html__('Username field is empty.','weddingcity')
              );

            }

            if ( $error == true ){

                  $final =  

                  json_encode( array( 

                        'register' => false,

                        'notice'  => '0',

                        'message'=> $note 
                  ) );

            } else {

                  $final = 

                  json_encode( array( 

                        'register' => true,

                        'notice'  => '1',

                        'message' => $note 
                  ) );
            }

            die( $final );
        }

        /**
         * [weddingcity_couple_login_script description]
         * @return [scripts] [ Is Vendor Registration Page then script is working ]
         */
        public static function weddingcity_couple_login_script(){

            if( current_user_can('subscriber') ) {

              if( !( WeddingCity_User:: is_vendor() || WeddingCity_User:: is_couple() ) ){

                  wp_enqueue_style( 'weddingcity-couple-login', plugin_dir_url( __FILE__ ).'style.css', array( 'date-picker' ), WEDDINGCITY_PLUGIN_VERSION, 'all' );

                  wp_enqueue_script( 'weddingcity-couple-login', plugin_dir_url( __FILE__ ).'script.js', array('jquery', 'jquery-ui-datepicker' ), WEDDINGCITY_PLUGIN_VERSION, true );
              }
            }

            if( is_page_template( 'user-template/couple-login-register.php' ) ){

                wp_enqueue_style( 'weddingcity-couple-login', plugin_dir_url( __FILE__ ).'style.css', array( 'date-picker' ), WEDDINGCITY_PLUGIN_VERSION, 'all' );

                wp_enqueue_script( 'weddingcity-couple-login', plugin_dir_url( __FILE__ ).'script.js', array('jquery', 'jquery-ui-datepicker' ), WEDDINGCITY_PLUGIN_VERSION, true );
            }
        }

        /**
         * [weddingcity_couple_login_top description]
         * @return [top body] [form top body]
         */
        public static function weddingcity_couple_login_top(){

          ?>

            <div class="container couple-form">
                <div class="row">
                    <div class="offset-xl-3 col-xl-6 offset-lg-3 col-lg-6 col-md-12 col-sm-12 col-12  ">
                      <div class="couple-head"><?php weddingcity_theme_logo( $args = 'couple_registration_logo' ); ?></div>
                      <div class="st-tab couple-registration-login">
          <?php

        }

        /**
         * [weddingcity_couple_login_bottom description]
         * @return [bottom body] [form bottom body]
         */
        public static function weddingcity_couple_login_bottom(){

            ?>          </div>
                      </div>
                    </div>
                 </div>
            <?php

        }

        /**
         * [weddingcity_couple_login_content description]
         * @return [content body] [body content]
         */
        public static function weddingcity_couple_login_content(){

            do_action( 'weddingcity_couple_login_content_tab' );

            do_action( 'weddingcity_couple_login_content_tab_content' );

        }

        /**
         * [weddingcity_couple_login description]
         * @return [login] [login form action]
         */
        public static function weddingcity_couple_login(){

              do_action( 'weddingcity_couple_login_top' );

              do_action( 'weddingcity_couple_login_content' );

              do_action( 'weddingcity_couple_login_bottom' );
        }

        /**
         * [weddingcity_couple_login_content_tab description]
         * @return [ tab link ]
         */
        public static function weddingcity_couple_login_content_tab(){

            ?>

              <ul class="nav nav-tabs nav-justified" id="Mytabs" role="tablist">
                  <li class="nav-item">
                      <a class="nav-link active" id="tab-1" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab-1" aria-selected="true"><?php esc_html_e('Register', 'weddingcity'); ?></a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" id="tab-2" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab-2" aria-selected="true"><?php esc_html_e('Login', 'weddingcity'); ?></a>
                  </li>
              </ul>

            <?php
        }

        /**
         * [weddingcity_couple_login_content_tab_content description]
         * @return [tab content]
         */
        public static function weddingcity_couple_login_content_tab_content(){

          ?>

            <div class="tab-content pinside40" id="myTabContent">

                <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab-1">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                        <div class="couple-form-title">
                            <h3 class="mb-2"><?php esc_html_e( 'Browse 33,000 vendor profile and reviews.', 'weddingcity' ); ?></h3>
                            <p><?php esc_html_e( "We don't post anything without your permission.", 'weddingcity' ); ?></p>
                        </div>

                        <!-- Vendor Registration Form -->
                        <form id="couple_signup" method="post" autocomplete="off">
                            
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                    <div class="form-group">
                                        <label class="control-label sr-only" for="couple_username"></label>
                                        <input id="couple_username" type="text" name="couple_username" 
                                        placeholder="<?php esc_attr_e('User Name','weddingcity'); ?>" class="form-control" required="">
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                    <div class="form-group service-form-group">
                                        <label class="control-label sr-only" for="couple_email"></label>
                                        <input id="couple_email" type="email" name="couple_email" placeholder="<?php esc_attr_e('Email','weddingcity'); ?>" class="form-control" required="">
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                    <div class="form-group service-form-group">
                                        <label class="control-label sr-only" for="weddingdate"></label>
                                        <input id="weddingdate" type="text" name="weddingdate" placeholder="<?php esc_attr_e('Wedding Date','weddingcity'); ?>" class="form-control wedding_date" required="">
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                    <button type="submit" name="vendor_register_btn" class="btn btn-default"><?php esc_html_e( 'Sign up', 'weddingcity' ); ?></button>
                                    <?php wp_nonce_field( 'couple_security', 'couple_security' ); ?>
                                </div>
                            </div>
                        </form>
                        <?php

                          WeddingCity_Forgot_Password:: forgot_password_link();

                        ?>

                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                <div class="social-login-block">
                                  <?php
                                    if( class_exists( 'NextendSocialLogin' ) ){
                                        NextendSocialLogin:: addLinkAndUnlinkButtons();
                                    }
                                  ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab-2">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                        <div class="couple-form-title">
                            <h3 class="mb-2"><?php esc_html_e( 'Welcome Back Couple', 'weddingcity' ); ?></h3>
                            <p><?php esc_html_e( 'Login your account and manage your Wishlist, Todo, Budget, RSVP, Guest List, etc..', 'weddingcity' ); ?></p>
                        </div>

                        <!-- Couple SignIn Data -->
                        <form id="couple_login" method="post">
                            
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                    <div class="form-group">
                                        <label class="control-label sr-only" for="WeddingCity_Username"></label>
                                        <input id="WeddingCity_Username" type="text" name="WeddingCity_Username" 
                                        placeholder="<?php esc_attr_e('Username or Email Address','weddingcity'); ?>" class="form-control" required="">
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                    <div class="form-group service-form-group">
                                        <label class="control-label sr-only" for="WeddingCity_password"></label>
                                        <input id="WeddingCity_password" type="password" name="WeddingCity_password" placeholder="<?php esc_attr_e('Password','weddingcity'); ?>" class="form-control" required="">
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                    <input type="submit" name="couple_login_btn" class="btn btn-default" value="<?php esc_html_e('Login','weddingcity'); ?>">
                                    <?php wp_nonce_field( 'weddingcity-login', 'weddingcity-login' ); ?>
                                </div>
                            </div>
                        </form>
                        <?php

                              WeddingCity_Forgot_Password:: forgot_password_link();
                        ?>

                      <div class="row">
                          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                              <div class="social-login-block">
                                <?php
                                  if( class_exists( 'NextendSocialLogin' ) ){
                                      NextendSocialLogin:: addLinkAndUnlinkButtons();
                                  }
                                ?>
                              </div>
                          </div>
                      </div>

                    </div>
                </div>

            </div>

          <?php

        }

    }

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    WeddingCity_Couple_Login::get_instance();
}
