<?php

/**
 *  WeddingCity Listing Meta
 */

if (!class_exists('WeddingCity_Listing_Meta')) {

    /**
     *  WeddingCity Listing Meta
     */
    class WeddingCity_Listing_Meta extends WeddingCity_User {

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

            if (!isset(self::$instance)) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        public function __construct() {
        }

        public static function listing_amenities() {

            $_venue_amenities = array();

            if (weddingcity_option('venue_amenities') != '' && is_array(weddingcity_option('venue_amenities'))) {

                $j = absint('0');

                foreach (weddingcity_option('venue_amenities') as $key) {

                    $_venue_amenities[$j] = array(
                        'value' => esc_html(sanitize_title($key['name'])),
                        'label' => esc_html($key['name']),
                        'src' => '',

                    );
                    $j++;
                }
            }

            return $_venue_amenities;
        }

        /**
         *  Vendor Category Taxonomy Name Here
         */
        public static function listing_category_taxonomy() {

            return sanitize_key('vendors'); // vendors
        }

        /**
         *  Vendor Location Taxonomy Name Here
         */
        public static function listing_location_taxonomy() {

            return sanitize_key('location'); // location
        }

        /**
         *  Listing Category
         */
        public static function listing_category_meta_name() {

            return sanitize_key('listing_category'); // listing_category
        }

        public static function listing_category($_post_id = '0') {

            return parent::get_post_data(absint($_post_id), self::listing_category_meta_name());
        }

        /**
         * [seat_capacity_meta_name description]
         * @return [ Seat Capacity ]
         */
        public static function seat_capacity_meta_name() {

            return sanitize_key('seat_capacity'); // seat capacity
        }

        public static function seat_capacity($_post_id = '0') {

            return parent::get_post_data(absint($_post_id), self::seat_capacity_meta_name());
        }

        public static function listing_request_meta_name() {

            return sanitize_key('listing_request'); // seat capacity
        }

        public static function listing_request($_post_id = '0') {

            return parent::get_post_data(absint($_post_id), self::listing_request_meta_name());
        }

        /**
         *  Featured Listing.
         */
        public static function featured_listing_meta_name() {

            return sanitize_key('featured_listing'); // featured_listing
        }

        public static function featured_listing($_post_id = '0') {

            return parent::get_post_data(absint($_post_id), self::featured_listing_meta_name());
        }

        /**
         *  Listing Price Meta Data
         */
        public static function listing_price_meta_name() {

            return sanitize_key('venue_price'); // listing_price
        }

        public static function listing_price($_post_id = '0') {

            return parent::get_post_data(absint($_post_id), self::listing_price_meta_name());
        }

        /**
         *  Listing Address Meta Data
         */
        public static function listing_address_meta_name() {

            return sanitize_key('venue_address'); // listing_address
        }

        public static function listing_address($_post_id = '0') {

            return parent::get_post_data(absint($_post_id), self::listing_address_meta_name());
        }

        /**
         *  Listing Country Meta Data
         */
        public static function listing_country_meta_name() {

            return sanitize_key('venue_country'); // listing_country
        }

        public static function listing_country($_post_id = '0') {

            return parent::get_post_data(absint($_post_id), self::listing_country_meta_name());
        }

        /**
         *  Listing State Meta Data
         */
        public static function listing_state_meta_name() {

            return sanitize_key('venue_state'); // listing_state
        }

        public static function listing_state($_post_id = '0') {

            return parent::get_post_data(absint($_post_id), self::listing_state_meta_name());
        }

        /**
         *  Listing City Meta Data
         */
        public static function listing_city_meta_name() {

            return sanitize_key('venue_city'); // listing_city
        }

        public static function listing_city($_post_id = '0') {

            return parent::get_post_data(absint($_post_id), self::listing_city_meta_name());
        }

        /**
         *  Listing Map Latitude Meta Data
         */
        public static function listing_latitude_meta_name() {

            return sanitize_key('venue_latitude'); // listing_latitude
        }

        public static function listing_latitude($_post_id = '0') {

            return parent::get_post_data(absint($_post_id), self::listing_latitude_meta_name());
        }

        /**
         *  Listing Map longitude Meta Data
         */
        public static function listing_longitude_meta_name() {

            return sanitize_key('venue_longitude'); // listing_longitude
        }

        public static function listing_longitude($_post_id = '0') {

            return parent::get_post_data(absint($_post_id), self::listing_longitude_meta_name());
        }

        /**
         *  Listing Map Address Meta Data
         */
        public static function listing_map_address_meta_name() {

            return sanitize_key('venue_map_address'); // listing_map_address
        }

        public static function listing_map_address($_post_id = '0') {

            return parent::get_post_data(absint($_post_id), self::listing_map_address_meta_name());
        }

        /**
         *  Listing Video Meta Data
         */
        public static function listing_video_meta_name() {

            return sanitize_key('venue_video'); // listing_video
        }

        public static function listing_video($_post_id = '0') {

            return parent::get_post_data(absint($_post_id), self::listing_video_meta_name());
        }

        /**
         *  Listing Gallery Meta Data
         */
        public static function listing_gallery_meta_name() {

            return sanitize_key('vendor_gallery'); // listing_gallery
        }

        public static function listing_gallery($_post_id = '0') {

            return parent::get_post_data(absint($_post_id), self::listing_gallery_meta_name());
        }

        /**
         *  Listing Featured Image ID Meta Data
         */
        public static function listing_featured_id_meta_name() {

            return sanitize_key('vendor_featured_id'); // listing_featured_image_id
        }

        public static function listing_featured_image_id($_post_id = '0') {

            return parent::get_post_data(absint($_post_id), self::listing_featured_id_meta_name());
        }

        /**
         *  Listing Featured Image Meta Data
         */
        public static function listing_featured_image_meta_name() {

            return sanitize_key('vendor_featured_image'); // listing_featured_image_link
        }

        public static function listing_featured_image_link($_post_id = '0') {

            return parent::get_post_data(absint($_post_id), self::listing_featured_image_meta_name());
        }

        /**
         *  Listing Category
         */
        public static function listing_venue_amenities_meta_name() {

            return sanitize_key('venue_amenities');
        }

        public static function listing_venue_amenities($_post_id = '0') {

            return parent::get_post_data(absint($_post_id), self::listing_venue_amenities_meta_name());
        }

        /**
         *  Listing Reviews
         */
        public static function listing_reviews_meta_name() {

            return sanitize_key('listing_reviews');
        }

        public static function listing_reviews($_post_id = '0') {

            return parent::get_post_data(absint($_post_id), self::listing_reviews_meta_name());
        }

        /**
         *  Requests
         */

        public static function request_name_meta_name() {

            return sanitize_key('request_name'); // listing post - user id
        }

        public static function request_name($_post_id = '0') {

            return parent::get_post_data(absint($_post_id), self::request_name_meta_name());
        }

        public static function request_email_meta_name() {

            return sanitize_key('request_email'); // listing post - user id
        }

        public static function request_email($_post_id = '0') {

            return parent::get_post_data(absint($_post_id), self::request_email_meta_name());
        }

        public static function request_phone_meta_name() {

            return sanitize_key('request_phone'); // listing post - user id
        }

        public static function request_phone($_post_id = '0') {

            return parent::get_post_data(absint($_post_id), self::request_phone_meta_name());
        }

        public static function weddingdate_meta_name() {

            return sanitize_key('weddingdate'); // listing post - user id
        }

        public static function weddingdate($_post_id = '0') {

            return parent::get_post_data(absint($_post_id), self::weddingdate_meta_name());
        }

        public static function request_comment_meta_name() {

            return sanitize_key('request_comment'); // listing post - user id
        }

        public static function request_comment($_post_id = '0') {

            return parent::get_post_data(absint($_post_id), self::request_comment_meta_name());
        }

        /**
         *  Listing Vendor Post ID
         */
        public static function listing_vendor_meta_name() {

            return sanitize_key('listing_vendor'); // listing post - user id
        }

        public static function listing_vendor($_post_id = '0') {

            return parent::get_post_data(absint($_post_id), self::listing_vendor_meta_name());
        }

        public static function is_featured_listing_meta_name() {

            return sanitize_key('is_featured_listing'); // listing post - user id
        }

        public static function is_featured_listing($_post_id = '0') {

            return parent::get_post_data(absint($_post_id), self::is_featured_listing_meta_name());
        }
    }

    /**
     *  Kicking this off by calling 'get_instance()' method
     */
    WeddingCity_Listing_Meta::get_instance();
}