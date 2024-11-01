<?php

/**
 *  WeddingCity Vendor Meta
 */

if( ! class_exists( 'WeddingCity_Vendor_Meta' ) and class_exists( 'WeddingCity_User' ) ){

    /**
     *  WeddingCity Vendor Default Meta
     */
    class WeddingCity_Vendor_Meta extends WeddingCity_User{

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

        public function __construct() {}

        /**
         * 
         *  Vendor Post Meta
         * 
         */
        public static function profile_user_id_meta_name(){

            return sanitize_key( 'user_id' ); // user_id
        }

        public static function profile_user_id(){

            return parent:: get_data( self:: profile_user_id_meta_name() );
        }

        public static function profile_user_type_meta_name(){

            return sanitize_key( 'user_type' ); // user_type
        }

        public static function profile_user_type(){

            return parent:: get_data( self:: profile_user_type_meta_name() );
        }

        public static function profile_vendor_type_meta_name(){

            return sanitize_key( 'vendor_type' ); // vendor_type
        }

        public static function profile_vendor_type(){

            return parent:: get_data( self:: profile_vendor_type_meta_name() );
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

        public static function profile_user_website_meta_name(){

            return sanitize_key( 'user_website' ); // user_website
        }

        public static function profile_user_website(){

            return parent:: get_data( self:: profile_user_website_meta_name() );
        }

        public static function profile_business_name_meta_name(){

            return sanitize_key( 'business_name' ); // business_name
        }

        public static function profile_business_name(){

            return parent:: get_data( self:: profile_business_name_meta_name() );
        }

        /**
         *  Country, state, city
         */
        public static function profile_business_country_meta_name(){

            return sanitize_key( 'business_country' ); // business_country
        }

        public static function profile_business_country(){

            return parent:: get_data( self:: profile_business_country_meta_name() );
        }

        public static function profile_business_state_meta_name(){

            return sanitize_key( 'business_state' ); // business_state
        }

        public static function profile_business_state(){

            return parent:: get_data( self:: profile_business_state_meta_name() );
        }

        public static function profile_business_city_meta_name(){

            return sanitize_key( 'business_city' ); // business_city
        }

        public static function profile_business_city(){

            return parent:: get_data( self:: profile_business_city_meta_name() );
        }

        public static function vendor_bussiness_latitude_meta_name(){

            return sanitize_key( 'bussiness_latitude' ); // business_name
        }

        public static function vendor_bussiness_latitude(){

            return parent:: get_data( self:: vendor_bussiness_latitude_meta_name() );
        }

        public static function vendor_bussiness_longitude_meta_name(){

            return sanitize_key( 'bussiness_longitude' ); // business_name
        }

        public static function vendor_bussiness_longitude(){

            return parent:: get_data( self:: vendor_bussiness_longitude_meta_name() );
        }


        /**
         *  Business profile
         */

        public static function business_profile_user_banner_image_meta_name(){

            return sanitize_key( 'business_profile_banner' ); // business_name
        }

        public static function business_profile_user_banner_image(){

            return parent:: get_data( self:: business_profile_user_banner_image_meta_name() );
        }

        public static function business_profile_user_banner_id_meta_name(){

            return sanitize_key( 'business_profile_banner_id' ); // business_name
        }

        public static function business_profile_user_banner_id(){

            return parent:: get_data( self:: business_profile_user_banner_id_meta_name() );
        }


        public static function business_gallery_meta_name(){

            return sanitize_key( 'business_gallery' ); // business_name
        }

        public static function business_gallery(){

            return parent:: get_data( self:: business_gallery_meta_name() );
        }


        public static function business_video_meta_name(){

            return sanitize_key( 'business_video' ); // business_name
        }

        public static function business_video(){

            return parent:: get_data( self:: business_video_meta_name() );
        }

        public static function business_video_bg_image_meta_name(){

            return sanitize_key( 'business_video_bg_image' ); // business_name
        }

        public static function business_video_bg_image(){

            return parent:: get_data( self:: business_video_bg_image_meta_name() );
        }

        public static function business_video_bg_image_id_meta_name(){

            return sanitize_key( 'business_video_bg_image_id' ); // business_name
        }

        public static function business_video_bg_image_id(){

            return parent:: get_data( self:: business_video_bg_image_id_meta_name() );
        }

        public static function business_profile_brand_image_meta_name(){

            return sanitize_key( 'business_profile_brand' ); // business_name
        }

        public static function business_profile_brand_image(){

            return parent:: get_data( self:: business_profile_brand_image_meta_name() );
        }

        public static function business_profile_brand_id_meta_name(){

            return sanitize_key( 'business_profile_brand_id' ); // business_name
        }

        public static function business_profile_brand_id(){

            return parent:: get_data( self:: business_profile_brand_id_meta_name() );
        }


        /**
         *  Profile Data
         */
        
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

            $_image_src =  parent:: get_data( self:: profile_user_image_meta_name() );

            if( ! empty( $_image_src ) ){

                return esc_url( $_image_src );

            }else{

                return esc_url( WEDDINGCITY_PLUGIN_IMAGE . 'user.png' );
            }
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

        public static function profile_post_content_meta_name(){

            return sanitize_key( 'post_content' ); // post_content
        }

        public static function profile_post_content(){

            return esc_textarea( wp_specialchars_decode( 

                    parent:: get_data( self:: profile_post_content_meta_name() ) 
            ) );
        }

        /**
         *  Venue Request
         */

        public static function request_quote_meta_name(){

            return sanitize_key( 'request_quote' ); // request_quote
        }

        public static function request_quote(){

            return parent:: get_data( self:: request_quote_meta_name() );
        }

        public static function vendor_plan_name_meta_name(){

            return sanitize_key( 'vendor_plan_name' ); // vendor_plan_name
        }

        public static function vendor_plan_name(){

            return parent:: get_data( self:: vendor_plan_name_meta_name() );
        }

        public static function vendor_can_listing_meta_name(){

            return sanitize_key( 'vendor_can_listing' ); // vendor_can_listing
        }

        public static function vendor_can_listing(){

            return parent:: get_data( self:: vendor_can_listing_meta_name() );
        } 

        public static function total_listing_meta_name(){

            return sanitize_key( 'total_listing' ); // total_listing
        }

        public static function total_listing(){

            return parent:: get_data( self:: total_listing_meta_name() );
        }

        public static function payment_amount_meta_name(){

            return sanitize_key( 'payment_amount' ); // payment_amount
        }

        public static function payment_amount(){

            return parent:: get_data( self:: payment_amount_meta_name() );
        } 

        public static function vendor_payment_date_meta_name(){

            return sanitize_key( 'vendor_payment_date' ); // vendor_payment_date
        }

        public static function vendor_payment_date(){

            return parent:: get_data( self:: vendor_payment_date_meta_name() );
        } 

        public static function payment_expire_date_meta_name(){

            return sanitize_key( 'payment_expire_date' ); // payment_expire_date
        }

        public static function payment_expire_date(){

            return parent:: get_data( self:: payment_expire_date_meta_name() );
        }

        public static function reviews_meta_name(){

            return sanitize_key( 'reviews' ); // reviews
        }

        public static function reviews(){

            return parent:: get_data( self:: reviews_meta_name() );
        }

        public static function capacity_featured_listing_meta_name(){

            return sanitize_key( 'capacity_featured_listing' ); // capacity_featured_listing
        }

        public static function capacity_featured_listing(){

            return parent:: get_data( self:: capacity_featured_listing_meta_name() );
        }

        public static function number_of_featured_listing_meta_name(){

            return sanitize_key( 'number_of_featured_listing' ); // number_of_featured_listing
        }

        public static function number_of_featured_listing(){

            return parent:: get_data( self:: number_of_featured_listing_meta_name() );
        }



        /**
         *  Social Media - Vendor
         */
        public static function social_media_facebook_meta_name(){

          return sanitize_key( "facebook" );
        }

        public static function social_media_facebook(){


            return parent:: get_data( self:: social_media_facebook_meta_name() );
        }

        public static function social_media_twitter_meta_name(){

          return sanitize_key( "twitter" );
        }

        public static function social_media_twitter(){

          return parent:: get_data( self:: social_media_twitter_meta_name() );
        }

        public static function social_media_instagram_meta_name(){

          return sanitize_key( "instagram" );
        }

        public static function social_media_instagram(){

          return parent:: get_data( self:: social_media_instagram_meta_name() );
        }

        public static function social_media_youtube_meta_name(){

          return sanitize_key( "youtube" );
        }

        public static function social_media_youtube(){

          return parent:: get_data( self:: social_media_youtube_meta_name() );
        }

        public static function social_media_pinterest_meta_name(){

          return sanitize_key( "pinterest" );
        }

        public static function social_media_pinterest(){

          return parent:: get_data( self:: social_media_pinterest_meta_name() );
        }

        public static function social_media_linkedin_meta_name(){

          return sanitize_key( "linkedin" );
        }

        public static function social_media_linkedin(){

          return parent:: get_data( self:: social_media_linkedin_meta_name() );
        }

        public static function social_media_google_plus_meta_name(){

          return sanitize_key( "google_plus" );
        }

        public static function social_media_google_plus(){

          return parent:: get_data( self:: social_media_google_plus_meta_name() );
        }

        public static function social_media_rss_meta_name(){

          return sanitize_key( "rss" );
        }

        public static function social_media_rss(){

          return parent:: get_data( self:: social_media_rss_meta_name() );
        }

        public static function social_media_tumblr_meta_name(){

          return sanitize_key( "tumblr" );
        }

        public static function social_media_tumblr(){

          return parent:: get_data( self:: social_media_tumblr_meta_name() );
        }

        public static function social_media_vimeo_meta_name(){

          return sanitize_key( "vimeo" );
        }

        public static function social_media_vimeo(){

          return parent:: get_data( self:: social_media_vimeo_meta_name() );
        }

        public static function social_media_behance_meta_name(){

          return sanitize_key( "behance" );
        }

        public static function social_media_behance(){

          return parent:: get_data( self:: social_media_behance_meta_name() );
        }

        public static function social_media_dribbble_meta_name(){

          return sanitize_key( "dribbble" );
        }

        public static function social_media_dribbble(){

          return parent:: get_data( self:: social_media_dribbble_meta_name() );
        }

        public static function social_media_flickr_meta_name(){

          return sanitize_key( "flickr" );
        }

        public static function social_media_flickr(){

          return parent:: get_data( self:: social_media_flickr_meta_name() );
        }

        public static function social_media_git_meta_name(){

          return sanitize_key( "git" );
        }

        public static function social_media_git(){

          return parent:: get_data( self:: social_media_git_meta_name() );
        }

        public static function social_media_skype_meta_name(){

          return sanitize_key( "skype" );
        }

        public static function social_media_skype(){

          return parent:: get_data( self:: social_media_skype_meta_name() );
        }

        public static function social_media_weibo_meta_name(){

          return sanitize_key( "weibo" );
        }

        public static function social_media_weibo(){

          return parent:: get_data( self:: social_media_weibo_meta_name() );
        }

        public static function social_media_foursquare_meta_name(){

          return sanitize_key( "foursquare" );
        }

        public static function social_media_foursquare(){

          return parent:: get_data( self:: social_media_foursquare_meta_name() );
        }

        public static function social_media_soundcloud_meta_name(){

          return sanitize_key( "soundcloud" );
        }

        public static function social_media_soundcloud(){

          return parent:: get_data( self:: social_media_soundcloud_meta_name() );
        }
    }

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    WeddingCity_Vendor_Meta::get_instance();
}

