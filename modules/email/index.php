<?php

/**
 *  WeddingCity Email Builder
 */

if( ! class_exists( 'WeddingCity_Email' ) ){

    /**
     *  WeddingCity Emails
     */
    class WeddingCity_Email{

        /**
         * Member Variable
         *
         * @var instance
         */
        private static $instance;

        /**
         *  New Linke
         */
        public $new_line  =  "<br/>";

        /**
         *  Email Message
         */
        public $mail_message    =  '';

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

        }

        public static function weddingcity_email_notification_error(){

            die( json_encode( array( 

                'message'=> esc_html__( 'Your Email Notification Could Not Successfully Connect. Please contact administrator.', 'weddingcity' )

            ) ) );
        }

        public static function vendor_registration( $args = array() ){

              /**
               *  Data Exists or not ?
               */
              
              if( ! is_array( $args ) && $args != '' ){  

                  self:: weddingcity_email_notification_error();
              }

              $_arguments = array(

                    'subject'             =>    weddingcity_option( 'email_vendor_registration_subject' ),

                    'header_content'      =>    self:: ot_email_content_replace_with_value(

                                                        $_formate_values =  array(

                                                              // 1
                                                              'username'            => sanitize_user( $args['username'] )
                                                        ),

                                                        $_email_formate = weddingcity_option( 'email_vendor_registration_header_content' )
                                                ),

                    'footer_content'      =>    weddingcity_option( 'email_vendor_registration_footer_content' ),

                    'email_content'       =>    sprintf('   Username: <span>%1$s</span> <br>

                                                            Email ID: <span style="font-weight: 600; color: #2abc2d !important;">%2$s</span> <br>

                                                            Password : <span>%3$s</span>',

                                                            // 1
                                                            sanitize_user( $args['username'] ),

                                                            // 2
                                                            sanitize_email( $args['email_id'] ),

                                                            // 3
                                                            esc_html( $args['password'] )
                                                )                    
              );

              self:: send_email(

                    // 1 - user email id
                    sanitize_email( $args['email_id'] ),

                    // 2 - subject
                    $_arguments[ 'subject' ],

                    // 3 - mail message
                    self:: get_contents( $_arguments )
              );
        }

        /**
         * [couple_registration description]
         * @param  array  $args [pass array]
         * @return email for  
         * 
         */
        public static function couple_registration( $args = array() ){

              /**
               *  Data Exists or not ?
               */
              
              if( ! is_array( $args ) && $args != '' ){  

                  self:: weddingcity_email_notification_error();
              }
              
              $_arguments = array(

                    'subject'             =>    weddingcity_option( 'email_couple_registration_subject' ),

                    'header_content'      =>    self:: ot_email_content_replace_with_value(

                                                        $_formate_values =  array(

                                                              // 1
                                                              'username'            => sanitize_user( $args['username'] )
                                                        ),

                                                        $_email_formate = weddingcity_option( 'email_couple_registration_header_content' )
                                                ),

                    'footer_content'      =>    weddingcity_option( 'email_couple_registration_footer_content' ),

                    'email_content'       =>    sprintf('   Username: <span>%1$s</span> <br>

                                                            Email ID: <span style="font-weight: 600; color: #2abc2d !important;">%2$s</span> <br>

                                                            Password : <span>%3$s</span>',

                                                            // 1
                                                            sanitize_user( $args['username'] ),

                                                            // 2
                                                            sanitize_email( $args['email_id'] ),

                                                            // 3
                                                            esc_html( $args['password'] )
                                                )                    
              );

              self:: send_email(

                    // 1 - user email id
                    sanitize_email( $args['email_id'] ),

                    // 2 - subject
                    $_arguments[ 'subject' ],

                    // 3 - mail message
                    self:: get_contents( $_arguments )
              );
        }

        /**
         * [forgot_password description]
         * @param  array  $args [pass array]
         * @return email for username, password, email
         */
        public static function forgot_password( $args = array() ){

              /**
               *  Data Exists or not ?
               */
              
              if( ! is_array( $args ) && $args != '' ){  

                  self:: weddingcity_email_notification_error();
              }

              $_arguments = array(

                    'subject'             =>    weddingcity_option( 'email_forgot_password_subject' ),

                    'header_content'      =>    weddingcity_option( 'email_forgot_password_header_content' ),

                    'footer_content'      =>    weddingcity_option( 'email_forgot_password_footer_content' ),

                    'email_content'       =>    sprintf('   Username: <span>%1$s</span> <br>

                                                            Email ID: <span style="font-weight: 600; color: #2abc2d !important;">%2$s</span> <br>

                                                            Password : <span>%3$s</span>',

                                                            // 1
                                                            sanitize_user( $args['username'] ),

                                                            // 2
                                                            sanitize_email( $args['email_id'] ),

                                                            // 3
                                                            esc_html( $args['password'] )
                                                )                    
              );

              self:: send_email(

                    // 1 - user email id
                    sanitize_email( $args['email_id'] ),

                    // 2 - subject
                    $_arguments[ 'subject' ],

                    // 3 - mail message
                    self:: get_contents( $_arguments )
              );
        }

        /**
         * [change_password description]
         * @param  array  $args [pass array]
         * @return email for username, password, email
         */
        public static function change_password( $args = array() ){

              /**
               *  Data Exists or not ?
               */
              
              if( ! is_array( $args ) && $args != '' ){  

                  self:: weddingcity_email_notification_error();
              }

              $_arguments = array(

                    'subject'             =>    weddingcity_option( 'email_change_password_subject' ),

                    'header_content'      =>    weddingcity_option( 'email_change_password_header_content' ),

                    'footer_content'      =>    weddingcity_option( 'email_change_password_footer_content' ),

                    'email_content'       =>    sprintf('   Username: <span>%1$s</span> <br>

                                                            Email ID: <span style="font-weight: 600; color: #2abc2d !important;">%2$s</span> <br>

                                                            Password : <span>%3$s</span>',

                                                            // 1
                                                            sanitize_user( $args['username'] ),

                                                            // 2
                                                            sanitize_email( $args['email_id'] ),

                                                            // 3
                                                            esc_html( $args['password'] )
                                                )                    
              );

              self:: send_email(

                    // 1 - user email id
                    sanitize_email( $args['email_id'] ),

                    // 2 - subject
                    $_arguments[ 'subject' ],

                    // 3 - mail message
                    self:: get_contents( $_arguments )
              );
        }



        public static function ot_email_content_replace_with_value( $variables, $_email_formate = '' ){

              $template = $_email_formate;

              foreach( $variables as $key => $value){

                  if( isset( $key ) ){

                      $template = str_replace('{{'.$key.'}}', preg_replace('/\s+/', ' ', $value ), $template);
                  }
              }

              return $template;
        }

        public static function buying_listing_successfully( $args = array() ){

              /**
               *  Data Exists or not ?
               */
              
              if( ! is_array( $args ) && $args != '' ){  

                  self:: weddingcity_email_notification_error();
              }

              $_arguments = array(

                    'subject'             =>    self:: ot_email_content_replace_with_value(

                                                        $_formate_values =  array(

                                                              // 1
                                                              'plan_name'           => esc_html( strtolower( $args[ 'plan_name' ] ) ),
                                                        ),

                                                        $_email_formate = weddingcity_option( 'email_listing_payment_received_subject' )
                                                ),

                    'header_content'      =>    self:: ot_email_content_replace_with_value(

                                                        $_formate_values =  array(

                                                              // 1
                                                              'plan_name'           => esc_html( strtolower( $args[ 'plan_name' ] ) ),
                                                        ),

                                                        $_email_formate = weddingcity_option( 'email_listing_payment_received_header_content' )
                                                ),

                    'footer_content'      =>    weddingcity_option( 'email_listing_payment_received_footer_content' ),

                    'email_content'       =>    self:: ot_email_content_replace_with_value(

                                                        $_formate_values =  array(

                                                              // 1
                                                              'username'            => sanitize_user( $args['username'] ),

                                                              // 2
                                                              'plan_name'           => esc_html( strtolower( $args[ 'plan_name' ] ) ),

                                                              // 3
                                                              'listing_capacity'    => absint( $args[ 'listing_capacity' ] ),

                                                              // 4
                                                              'listing_amount'      => esc_attr( $args[ 'listing_price' ] ),

                                                              // 5
                                                              'featured_listing'    => absint( $args[ 'featured_listing' ] ),

                                                              // 6
                                                              'invoice_number'      => esc_attr( $args[ 'invoice_number' ] ),
                                                        ),

                                                        $_email_formate = weddingcity_option( 'email_listing_payment_received_body_content' )
                                                )
              );

              self:: send_email(

                    // 1 - user email id
                    sanitize_email( $args['email_id'] ),

                    // 2 - subject
                    $_arguments[ 'subject' ],

                    // 3 - mail message
                    self:: get_contents( $_arguments )
              );
        }

        public static function guest_invitation( $args = array() ){

              /**
               *  Data Exists or not ?
               */
              
              if( ! is_array( $args ) && $args != '' ){  

                  self:: weddingcity_email_notification_error();
              }

              $_arguments = array(

                    'subject'             =>    self:: ot_email_content_replace_with_value(

                                                        $_formate_values =  array(

                                                              // 1
                                                              'bride'           => esc_html( strtolower( $args[ 'bride' ] ) ),

                                                              // 2
                                                              'groom'           => esc_html( strtolower( $args[ 'groom' ] ) ),
                                                        ),

                                                        $_email_formate = weddingcity_option( 'email_rsvp_subject' )
                                                ),

                    'header_content'      =>    weddingcity_option( 'email_rsvp_header_content' ),

                    'footer_content'      =>    weddingcity_option( 'email_rsvp_footer_content' ),

                    'email_content'       =>    sprintf('<a href="%1$s">%2$s</a>.',

                                                            // 1
                                                            esc_url( $args[ 'link' ] ),

                                                            // 2
                                                            esc_html__( 'Your invitation link.', 'weddingcity' )
                                                )
              );

              self:: send_email(

                    // 1 - user email id
                    sanitize_email( $args['email_id'] ),

                    // 2 - subject
                    $_arguments[ 'subject' ],

                    // 3 - mail message
                    self:: get_contents( $_arguments )
              );
        }

        /**
         * [email_header description]
         * @return [type] [description]
         */
        public static function email_header(){

            // To send HTML mail, the Content-type header must be set
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';

            // Additional headers
            $headers[] = 'From: noreply <noreply@'. $_SERVER['HTTP_HOST'] .'>';
            $headers[] = 'Reply-To: noreply@'. $_SERVER['HTTP_HOST'];
            $headers[] = 'Cc: '. get_option('admin_email') ;
            $headers[] = 'X-Mailer: PHP/' . phpversion();

            return implode("\r\n", $headers);
        }

        /**
         * [send_email description]
         * @param  [type] $mail_to      [description]
         * @param  [type] $mail_subject [description]
         * @param  [type] $mail_message [description]
         * @return [type]               [description]
         */
        public static function send_email( $mail_to, $mail_subject, $mail_message ){

            @wp_mail(

                $mail_to,

                str_replace( '<br/>', "\r\n\r\n", $mail_subject ),

                str_replace( '<br/>', "\r\n\r\n", $mail_message ),

                self:: email_header()
            );
        }

        /**
         *  Theme option Default Content.
         * @return [type] [description]
         */
        public static function email_default_options(){

            return  array(

                          'footer_copyright_content'  => weddingcity_option( 'email_footer_content' ),

                          'logo'                      => esc_url( weddingcity_option( 'email_logo' ) ),

                          'email_thank_you'           => weddingcity_option( 'email_thank_you' ),
                    );
        }

        public static function get_contents( $variables, $templateName = 'template-one.html' ) {

            $template = file_get_contents( plugin_dir_path( __FILE__ ) . '/templates/' . $templateName );

            if( WeddingCity_Loader:: array_condition( $variables ) ){

                  foreach( array_merge( $variables, self:: email_default_options() ) as $key => $value){

                      if( isset( $key ) ){

                          $template = str_replace('{{'.$key.'}}', preg_replace('/\s+/', ' ', $value ), $template);
                      }
                  }
            }

            return $template;
        }



        /**
         * [claim listing description]
         * @param  array  $args [pass array]
         * @return email for  
         * 
         */
        public static function claim_listing( $args = array() ){

              /**
               *  Data Exists or not ?
               */
              
              if( ! is_array( $args ) && $args != '' ){  

                  self:: weddingcity_email_notification_error();
              }
              
              $_arguments = array(

                    'subject'             =>    self:: ot_email_content_replace_with_value(

                                                        $_formate_values =  array(

                                                              // 1
                                                              'username'            => sanitize_user( $args['username'] ),

                                                              // 2
                                                              'listing'             => esc_html( $args[ 'listing' ] ) 
                                                        ),

                                                        $_email_formate = weddingcity_option( 'claim_listing_subject' )
                                                ),

                    'header_content'      =>    weddingcity_option( 'claim_listing_header_content' ),

                    'footer_content'      =>    weddingcity_option( 'claim_listing_footer_content' ),

                    'email_content'       =>    sprintf('   Username: <span>%1$s</span> <br>

                                                            Email ID: <span style="font-weight: 600; color: #2abc2d !important;">%2$s</span> <br>

                                                            Contact Number : <span>%3$s</span> <br>

                                                            Message : <span>%4$s</span>',

                                                            // 1
                                                            sanitize_user( $args['username'] ),

                                                            // 2
                                                            sanitize_email( $args['email_id'] ),

                                                            // 3
                                                            esc_attr( $args['contact'] ),

                                                            // 4
                                                            esc_html( $args['message'] )
                                                )                    
              );

              self:: send_email(

                    // 1 - user email id
                    sanitize_email( $args['email_id'] ),

                    // 2 - subject
                    $_arguments[ 'subject' ],

                    // 3 - mail message
                    self:: get_contents( $_arguments )
              );
        }

    }

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    WeddingCity_Email::get_instance();
}