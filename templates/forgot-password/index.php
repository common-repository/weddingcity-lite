<?php

if( ! class_exists( 'WeddingCity_Forgot_Password' ) ){

    class WeddingCity_Forgot_Password{

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

            add_action( 'weddingcity_forgot_password',  array( $this, 'weddingcity_forgot_password_markup' ) );

            add_action( 'wp_enqueue_scripts', array( $this, 'weddingcity_forgot_password_script' ) );

            add_action( 'weddingcity_forgot_password_top', array( $this, 'weddingcity_forgot_password_top_markup' ) );

            add_action( 'weddingcity_forgot_password_bottom', array( $this, 'weddingcity_forgot_password_bottom_markup' ) );

            add_action( 'weddingcity_forgot_password_content', array( $this, 'weddingcity_forgot_password_content_markup' ) );

            add_action( 'weddingcity_forgot_password_top_content', array( $this, 'weddingcity_forgot_password_top_content' ) );

            add_action( 'weddingcity_forgot_password_form_content', array( $this, 'weddingcity_forgot_password_form_content' ) );
            
            add_action( 'weddingcity_forgot_password_bottom_content', array( $this, 'weddingcity_forgot_password_bottom_content' ) );

            add_action( 'wp_ajax_weddingcity_forgot_password',  array( $this, 'weddingcity_forgot_password_script_code' ) );

            add_action( 'wp_ajax_nopriv_weddingcity_forgot_password', array( $this, 'weddingcity_forgot_password_script_code' ) );
        }

        /**
         * [weddingcity_forgot_password_script_code description]
         * 
         * @return [type] [description]
         *
         * @link https://wordpress.stackexchange.com/questions/142322/password-recovery-key-is-invalid-on-custom-reset
         * 
         * @link http://www.kvcodes.com/2016/10/wordpress-custom-forgot-password-page/
         *
         * @link http://www.tutorialstag.com/wordpress-custom-password-reset-page-template.html
         *
         * @link https://code.tutsplus.com/tutorials/build-a-custom-wordpress-user-flow-part-3-password-reset--cms-23811
         *
         * @link https://wordpress.stackexchange.com/questions/60318/sending-the-reset-password-link-programatically
         *
         * @link https://developer.wordpress.org/reference/functions/get_user_by/  $user->caps 
         *
         */
        public static function weddingcity_forgot_password_script_code(){

            global $wpdb;

            check_ajax_referer( 'weddingcity-forgot-password', 'security' );

            if ( $_POST['email'] == '' ){      
                die( esc_html_e('Email field is empty.','weddingcity') );
            }

            $note = '';

            $error = false;

            $final = '';

            $securityCheck = esc_html( $_POST['security'] );

            $user_email = sanitize_email($_POST['email']);


            if( isset( $securityCheck ) && !empty( $securityCheck ) ){

                if ( email_exists( $user_email ) != false && !empty($user_email) && is_email($user_email) ) {

                      $random_password    =   wp_generate_password( 

                                                  $length = absint('12'), 

                                                  $include_standard_special_chars= false 
                                              );
                      
                      $userData = get_user_by( 'email', $user_email );

                      $userID = $userData->ID;

                      $user_name = get_userdata( $userID )->user_login;

                      wp_set_password( $random_password, $userID );

                      if( class_exists( 'WeddingCity_Email' ) ){

                            WeddingCity_Email:: forgot_password(

                                array(

                                    'username'      =>  esc_html( $user_name ),
                                    'password'      =>  $random_password,
                                    'email_id'      =>  sanitize_email( $user_email ),
                                )
                            );
                      }
                      
                      $note   =   WeddingCity_Alert:: success(

                                        esc_html__( 'Your password has been reset successfully! Your new password has been sent to your primary email address.','weddingcity')
                                  );

                }else{

                    $error  =   true;
                    $note   =   WeddingCity_Alert:: danger(

                                      esc_html__('Email does not exists in users list.','weddingcity')
                                );
                }

            } else{

                    $error  =   true;
                    $note   =   WeddingCity_Alert:: danger(

                                      esc_html__(' Security code not found.','weddingcity')
                                );
            }

            if ( $error == true ){

                  $final =  json_encode( 

                                array( 'register' => false, 'message'=> $note, 'notice' => '0' ) 
                            );
            }else {

                  $final =  json_encode( 
                                
                                array( 'register' => true,  'message' => $note, 'notice' => '1' ) 
                            );
            }

            die( $final );
        }

        /**
         * [weddingcity_forgot_password description]
         * @return [login] [login form action]
         */
        public static function weddingcity_forgot_password_markup(){

              do_action( 'weddingcity_forgot_password_top' );

              do_action( 'weddingcity_forgot_password_content' );

              do_action( 'weddingcity_forgot_password_bottom' );
        }

        /**
         * [weddingcity_forgot_password_top description]
         * @return [top body] [form top body]
         */
        public static function weddingcity_forgot_password_top_markup(){

          ?>  <div class="offset-xl-3 col-xl-6 offset-lg-3 col-lg-6 col-md-12 col-sm-12 col-12">
                  <div class="mb30 card">
                      <div class="card-body">
          <?php

        }

        /**
         * [weddingcity_forgot_password_bottom description]
         * @return [bottom body] [form bottom body]
         */
        public static function weddingcity_forgot_password_bottom_markup(){

            ?>        </div>
                    </div>
                 </div>
            <?php

        }

        /**
         * [weddingcity_forgot_password_script description]
         * @return [scripts] [ Is Vendor Registration Page then script is working ]
         */
        public static function weddingcity_forgot_password_script(){

            if( is_page_template( 'user-template/forgot-password.php' ) ){

                wp_enqueue_style( 'weddingcity-forgot-password', plugin_dir_url( __FILE__ ).'style.css', array(), WEDDINGCITY_PLUGIN_VERSION, 'all' );

                wp_enqueue_script( 'weddingcity-forgot-password', plugin_dir_url( __FILE__ ).'script.js', array('jquery'), WEDDINGCITY_PLUGIN_VERSION, true );
            }
        }

        /**
         * [weddingcity_forgot_password_content description]
         * @return [content body] [body content]
         */
        public static function weddingcity_forgot_password_content_markup(){

              do_action( 'weddingcity_forgot_password_top_content' );

              do_action( 'weddingcity_forgot_password_form_content' );

              do_action( 'weddingcity_forgot_password_bottom_content' );
        }

        /**
         * [weddingcity_forgot_password_top_content description]
         * @return [forgot form top content]
         */
        public static function weddingcity_forgot_password_top_content(){

            ?>
                <h1><?php esc_html_e( 'Lost Password', 'weddingcity' ); ?></h1>
                <p><?php esc_html_e( 'Follow these simple steps to reset your account:', 'weddingcity' ); ?></p>
                <ul class="list-unstyled mb30">
                    <li><?php esc_html_e( '1. Enter your email address', 'weddingcity' ); ?></li>
                    <li><?php esc_html_e( '2. Wait for your recovery details to be sent.', 'weddingcity' ); ?></li>
                    <li><?php esc_html_e( '3. Follow as given instructions in your mail account.', 'weddingcity' ); ?></li>
                </ul>

            <?php
        }

        /**
         * [weddingcity_forgot_password_form_content description]
         * @return [forgot form form content]
         */
        public static function weddingcity_forgot_password_form_content(){

            ?>
              <div class="forgot-form">
                  <form id="weddingcity_forgot_password" method="post">

                      
                      <div class="form-group">
                          <label class="control-label" for="email"><?php esc_html_e( 'Email', 'weddingcity' ); ?></label>
                          <input required id="email" name="email" class="form-control" placeholder="<?php esc_html_e('Email Address','weddingcity');?>" type="email">
                      </div>

                      <button type="submit" id="forgot_psw" name="forgot_psw" class="btn btn-default btn-block">
                          <?php esc_html_e('Get New Password','weddingcity'); ?>
                      </button>

                      <?php wp_nonce_field( 'weddingcity-forgot-password', 'weddingcity-forgot-password'); ?>

                  </form>
              </div>

          <?php
        }

        public static function forgot_password_link() {

          return

              printf( '<p class="mt-2"><small>%1$s<a href="%3$s" class="wizard-form-small-text"> %2$s</a></small></p>',

                  // 1
                      esc_html__( 'Forgot Your Password ?', 'weddingcity'),

                      // 2
                      esc_html__( 'Click here', 'weddingcity' ),

                      // 3
                      WeddingCity_Template:: forgot_password_template()
              );
        }

        /**
         * [weddingcity_forgot_password_bottom_content description]
         * @return [forgot form bottoom content]
         */
        public static function weddingcity_forgot_password_bottom_content(){

          ?>  <div class="mt30">

                  <?php

                      $_couple_login_template   =   WeddingCity_Template:: couple_login_template();
                      $_vendor_login_template   =   WeddingCity_Template:: vendor_login_template();

                  ?>

                  <a href="<?php print esc_url( $_couple_login_template ) ?>" class="btn-primary-link mr-3"><?php esc_html_e( 'Couple Login', 'weddingcity' ) ?></a> 
                  <a href="<?php print esc_url( $_vendor_login_template ) ?>" class="btn-primary-link"><?php esc_html_e( 'Vendor Login', 'weddingcity' ) ?></a>

              </div>
          <?php
        }

    }

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    WeddingCity_Forgot_Password::get_instance();
}
