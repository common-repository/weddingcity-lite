<?php

/**
 *  WeddingCity Email Builder
 */

if( ! class_exists( 'WeddingCity_Couple_Meta' ) ){

    /**
     *  WeddingCity Emails
     */
    class WeddingCity_Couple_Meta extends WeddingCity_User{

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

        }

        /**
         *  Post content..
         */
        public static function profile_post_content_meta_name(){

            return sanitize_key( 'post_content' ); // post_content
        }

        public static function profile_post_content( $_post_id = '' ){

            return esc_textarea( wp_specialchars_decode( 

                    parent:: get_data( self:: profile_post_content_meta_name() ) 
            ) );
        }

        /**
         *  Couple Media
         */
        public static function couple_bride_image_meta_name(){

            return sanitize_key( 'bride_image' ); // user_image
        }

        public static function bride_image(){

            return parent:: get_data( self:: couple_bride_image_meta_name() );
        }

        public static function couple_bride_image_id_meta_name(){

            return sanitize_key( 'bride_image_id' ); // user_image
        }

        public static function bride_image_id(){

            return parent:: get_data( self:: couple_bride_image_id_meta_name() );
        }

        public static function couple_groom_image_meta_name(){

            return sanitize_key( 'groom_image' ); // user_image
        }

        public static function groom_image(){

            return parent:: get_data( self:: couple_groom_image_meta_name() );
        }

        public static function couple_groom_image_id_meta_name(){

            return sanitize_key( 'groom_image_id' ); // user_image
        }

        public static function groom_image_id(){

            return parent:: get_data( self:: couple_groom_image_id_meta_name() );
        }


        /**
         *  Profile update meta
         */
        
        public static function profile_user_id_meta_name(){

            return sanitize_key( 'user_id' ); // user_id
        }

        public static function profile_user_id(){

            return parent:: get_data( self:: profile_profile_user_id_meta_name() );
        }

        public static function profile_user_type_meta_name(){

            return sanitize_key( 'user_type' ); // user_type
        }

        public static function profile_user_type(){

            return parent:: get_data( self:: profile_profile_user_type_meta_name() );
        }

        public static function profile_wedding_date_meta_name(){

            return sanitize_key( 'wedding_date' ); // wedding_date
        }

        public static function profile_wedding_date(){

            return parent:: get_data( self:: profile_wedding_date_meta_name() );
        }

        public static function profile_user_name_meta_name(){

            return sanitize_key( 'user_name' ); // user_name
        }

        public static function profile_user_name(){

            return parent:: get_data( self:: profile_user_name_meta_name() );
        }

        public static function profile_user_email_meta_name(){

            return sanitize_key( 'user_email' ); // user_email
        }

        public static function profile_user_email(){

            return parent:: get_data( self:: profile_user_email_meta_name() );
        }

        public static function profile_first_name_meta_name(){

            return sanitize_key( 'first_name' ); // first_name
        }

        public static function profile_first_name(){

            return parent:: get_data( self:: profile_first_name_meta_name() );
        }

        public static function profile_last_name_meta_name(){

            return sanitize_key( 'last_name' ); // last_name
        }

        public static function profile_last_name(){

            return parent:: get_data( self:: profile_last_name_meta_name() );
        }

        public static function profile_user_image_meta_name(){

            return sanitize_key( 'user_image' ); // user_image
        }

        public static function profile_user_image(){

            return parent:: get_data( self:: profile_user_image_meta_name() );
        }

        public static function profile_user_image_id_meta_name(){

            return sanitize_key( 'user_image_id' ); // user_image_id
        }

        public static function profile_user_image_id(){

            return parent:: get_data( self:: profile_user_image_id_meta_name() );
        }

        public static function profile_user_contact_meta_name(){

            return sanitize_key( 'user_contact' ); // user_contact
        }

        public static function profile_user_contact(){

            return parent:: get_data( self:: profile_user_contact_meta_name() );
        }

        public static function profile_user_address_meta_name(){

            return sanitize_key( 'user_address' ); // user_address
        }

        public static function profile_user_address(){

            return parent:: get_data( self:: profile_user_address_meta_name() );
        }

        /**
         *  Real wedding
         */

        public static function realwedding_post_id_meta_name(){

            return sanitize_key( 'realwedding_post_id' ); // realwedding_post_id
        }

        public static function realwedding_post_id(){

            return parent:: get_data( self:: realwedding_post_id_meta_name() );
        }

        /**
         *  Social Media - Vendor
         */
        public static function social_media_facebook_meta_name(){

          return sanitize_key( "facebook" );
        }

        public static function social_media_facebook( $_post_id = '' ){

          return parent:: get_data( self:: social_media_facebook_meta_name() );
        }

        public static function social_media_twitter_meta_name(){

          return sanitize_key( "twitter" );
        }

        public static function social_media_twitter( $_post_id = '' ){

          return parent:: get_data( self:: social_media_twitter_meta_name() );
        }

        public static function social_media_instagram_meta_name(){

          return sanitize_key( "instagram" );
        }

        public static function social_media_instagram( $_post_id = '' ){

          return parent:: get_data( self:: social_media_instagram_meta_name() );
        }

        public static function social_media_youtube_meta_name(){

          return sanitize_key( "youtube" );
        }

        public static function social_media_youtube( $_post_id = '' ){

          return parent:: get_data( self:: social_media_youtube_meta_name() );
        }

        public static function social_media_pinterest_meta_name(){

          return sanitize_key( "pinterest" );
        }

        public static function social_media_pinterest( $_post_id = '' ){

          return parent:: get_data( self:: social_media_pinterest_meta_name() );
        }

        public static function social_media_linkedin_meta_name(){

          return sanitize_key( "linkedin" );
        }

        public static function social_media_linkedin( $_post_id = '' ){

          return parent:: get_data( self:: social_media_linkedin_meta_name() );
        }

        public static function social_media_google_plus_meta_name(){

          return sanitize_key( "google_plus" );
        }

        public static function social_media_google_plus( $_post_id = '' ){

          return parent:: get_data( self:: social_media_google_plus_meta_name() );
        }

        public static function social_media_rss_meta_name(){

          return sanitize_key( "rss" );
        }

        public static function social_media_rss( $_post_id = '' ){

          return parent:: get_data( self:: social_media_rss_meta_name() );
        }

        public static function social_media_tumblr_meta_name(){

          return sanitize_key( "tumblr" );
        }

        public static function social_media_tumblr( $_post_id = '' ){

          return parent:: get_data( self:: social_media_tumblr_meta_name() );
        }

        public static function social_media_vimeo_meta_name(){

          return sanitize_key( "vimeo" );
        }

        public static function social_media_vimeo( $_post_id = '' ){

          return parent:: get_data( self:: social_media_vimeo_meta_name() );
        }

        public static function social_media_behance_meta_name(){

          return sanitize_key( "behance" );
        }

        public static function social_media_behance( $_post_id = '' ){

          return parent:: get_data( self:: social_media_behance_meta_name() );
        }

        public static function social_media_dribbble_meta_name(){

          return sanitize_key( "dribbble" );
        }

        public static function social_media_dribbble( $_post_id = '' ){

          return parent:: get_data( self:: social_media_dribbble_meta_name() );
        }

        public static function social_media_flickr_meta_name(){

          return sanitize_key( "flickr" );
        }

        public static function social_media_flickr( $_post_id = '' ){

          return parent:: get_data( self:: social_media_flickr_meta_name() );
        }

        public static function social_media_git_meta_name(){

          return sanitize_key( "git" );
        }

        public static function social_media_git( $_post_id = '' ){

          return parent:: get_data( self:: social_media_git_meta_name() );
        }

        public static function social_media_skype_meta_name(){

          return sanitize_key( "skype" );
        }

        public static function social_media_skype( $_post_id = '' ){

          return parent:: get_data( self:: social_media_skype_meta_name() );
        }

        public static function social_media_weibo_meta_name(){

          return sanitize_key( "weibo" );
        }

        public static function social_media_weibo( $_post_id = '' ){

          return parent:: get_data( self:: social_media_weibo_meta_name() );
        }

        public static function social_media_foursquare_meta_name(){

          return sanitize_key( "foursquare" );
        }

        public static function social_media_foursquare( $_post_id = '' ){

          return parent:: get_data( self:: social_media_foursquare_meta_name() );
        }

        public static function social_media_soundcloud_meta_name(){

          return sanitize_key( "soundcloud" );
        }

        public static function social_media_soundcloud( $_post_id = '' ){

          return parent:: get_data( self:: social_media_soundcloud_meta_name() );
        }


        /**
         *   Couple Profile.
         */
        public static function couple_profile_country_meta_name(){

            return sanitize_key( 'country' ); // country
        }

        public static function couple_profile_country(){

            return parent:: get_data( self:: couple_profile_country_meta_name() );
        }

        public static function couple_profile_state_meta_name(){

            return sanitize_key( 'state' ); // state
        }

        public static function couple_profile_state(){

            return parent:: get_data( self:: couple_profile_state_meta_name() );
        }

        public static function couple_profile_city_meta_name(){

            return sanitize_key( 'city' ); // city
        }

        public static function couple_profile_city(){

            return parent:: get_data( self:: couple_profile_city_meta_name() );
        }
    }

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    WeddingCity_Couple_Meta::get_instance();
}

