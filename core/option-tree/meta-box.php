<?php

/**
 *  WeddingCity Add Listing Form
 */

if (!class_exists('WeddingCity_Metabox') && class_exists('OT_Loader')) {

    /**
     *  WeddingCity Emails
     */
    class WeddingCity_Metabox {

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

            /**
             *  WeddingCity All Option To Create Theme Option Page.
             */
            add_action('admin_init', array($this, 'weddingcity_create_metabox'));

            /**
             *  General Setting for WeddingCity!
             */

            add_filter('wc_theme_meta', array($this, 'weddingcity_general_setting'), absint('5'));

            /**
             *  Post Setting for WeddingCity!
             */

            add_filter('wc_theme_meta', array($this, 'weddingcity_post_setting'), absint('10'));

            /**
             *  Couple Post Setting for WeddingCity!
             */

            add_filter('wc_theme_meta', array($this, 'weddingcity_couple_profile_setting'), absint('10'));

            /**
             *  Vendor Post Setting for WeddingCity!
             */

            add_filter('wc_theme_meta', array($this, 'weddingcity_vendor_profile_setting'), absint('10'));

            /**
             *  Real Wedding Post Setting for WeddingCity!
             */

            add_filter('wc_theme_meta', array($this, 'weddingcity_realwedding_setting'), absint('10'));

            /**
             *  Listing Post Setting for WeddingCity!
             */

            add_filter('wc_theme_meta', array($this, 'weddingcity_listing_setting'), absint('10'));

            add_filter('wc_theme_meta', array($this, 'weddingcity_featured_listing_setting'), absint('20'));

            add_filter('wc_theme_meta', array($this, 'weddingcity_listing_owner_setting'), absint('30'));
        }

        /**
         *  WeddingCity Create Meta Example
         */
        public static function example_arguments($args) {

            $new_args = array(

                /**
                 *
                 *  Insert your meta code here.
                 *
                 *  @options_type : https://github.com/valendesigns/option-tree-theme/blob/master/inc/theme-options.php
                 *
                 */
            );

            return array_merge($args, array($new_args));
        }

        /**
         *  WeddingCity Featured Listing
         */
        public static function weddingcity_featured_listing_setting($args) {

            $new_args = array(

                'id' => esc_attr('WeddingCity_Featured_Listing'),
                'title' => esc_html__('Listing is Featured ?', 'weddingcity'),
                'desc' => esc_attr__('', 'weddingcity'),
                'pages' => array('listing'),
                'context' => 'side',
                'priority' => 'low',
                'fields' => array(

                    array(
                        'id' => WeddingCity_Listing_Meta::is_featured_listing_meta_name(),
                        'label' => esc_html__('', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => 'off',
                        'type' => 'on-off',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                ),
            );

            return array_merge($args, array($new_args));
        }

        /**
         *  WeddingCity Featured Listing
         */
        public static function weddingcity_listing_owner_setting($args) {

            $new_args = array(

                'id' => esc_attr('WeddingCity_Vendor_ID'),
                'title' => esc_html__('Listing Vendor', 'weddingcity'),
                'desc' => esc_attr__('', 'weddingcity'),
                'pages' => array('listing'),
                'context' => 'side',
                'priority' => 'low',
                'fields' => array(

                    array(
                        'id' => WeddingCity_Listing_Meta::listing_vendor_meta_name(),
                        'label' => esc_html__('', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'select',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                        'choices' => weddingcity_theme_option_post_list('vendor'),
                    ),
                ),
            );

            return array_merge($args, array($new_args));
        }

        /**
         *  WeddingCity Create Meta Example
         */
        public static function weddingcity_listing_setting($args) {

            $new_args = array(

                'id' => 'weddingcity-listing-data',
                'title' => esc_html__('Listing Facilty', 'weddingcity'),
                'desc' => esc_attr__('', 'weddingcity'),
                'pages' => array('listing'),
                'context' => 'normal',
                'priority' => 'high',
                'fields' => array(

                    array(
                        'label' => esc_html__('Map Location', 'weddingcity'),
                        'id' => esc_attr('weddingcity_listing_map_location'),
                        'type' => 'tab',
                    ),
                    array(
                        'id' => WeddingCity_Listing_Meta::listing_latitude_meta_name(),
                        'label' => esc_attr__('Listing Google Map Latitude', 'weddingcity'),
                        'desc' => esc_attr__('Please Enter your google map latitide value.', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Listing_Meta::listing_longitude_meta_name(),
                        'label' => esc_attr__('Listing Google Map Longitude', 'weddingcity'),
                        'desc' => esc_attr__('Please Enter your google map longitude value.', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Listing_Meta::listing_map_address_meta_name(),
                        'label' => esc_attr__('Listing Google Map Address', 'weddingcity'),
                        'desc' => esc_attr__('Google Map Address for your venue', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),

                    array(
                        'label' => esc_html__('Features', 'weddingcity'),
                        'id' => esc_attr('weddingcity_listing_category_location'),
                        'type' => 'tab',
                    ),
                    array(
                        'id' => WeddingCity_Listing_Meta::listing_price_meta_name(),
                        'label' => esc_attr__('Listing Price', 'weddingcity'),
                        'desc' => esc_attr__('Please enter your Listing price', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Listing_Meta::listing_address_meta_name(),
                        'label' => esc_attr__('Listing Address', 'weddingcity'),
                        'desc' => esc_attr__('Please enter your Listing type', 'weddingcity'),
                        'std' => '',
                        'type' => 'textarea-simple',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),

                    array(
                        'id' => WeddingCity_Listing_Meta::seat_capacity_meta_name(),
                        'label' => esc_attr__('Seat Capacity', 'weddingcity'),
                        'desc' => esc_attr__('Please enter your venue seat capacity', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),

                    array(
                        'label' => esc_html__('Media & Video', 'weddingcity'),
                        'id' => esc_attr('weddingcity_listing_media'),
                        'type' => 'tab',
                    ),
                    array(
                        'id' => WeddingCity_Listing_Meta::listing_video_meta_name(),
                        'label' => esc_attr__('Listing Video', 'weddingcity'),
                        'desc' => esc_attr__('Listing Video', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Listing_Meta::listing_gallery_meta_name(),
                        'label' => esc_attr__('Upload Gallery', 'weddingcity'),
                        'desc' => esc_attr__('If you want to update post with gallery please upload your gallery images here. so on front side we present all images as gallery', 'weddingcity'),
                        'std' => '',
                        'type' => 'gallery',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Listing_Meta::listing_featured_id_meta_name(),
                        'label' => esc_attr__('Listing Featured Id', 'weddingcity'),
                        'desc' => esc_attr__('Listing Featured id', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Listing_Meta::listing_featured_image_meta_name(),
                        'label' => esc_attr__('Listing Featured Image link', 'weddingcity'),
                        'desc' => esc_attr__('Listing Featured Images link', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),

                    array(
                        'label' => esc_html__('Amenities', 'weddingcity'),
                        'id' => esc_attr('weddingcity_listing_amenities'),
                        'type' => 'tab',
                    ),
                    array(
                        'id' => WeddingCity_Listing_Meta::listing_venue_amenities_meta_name(),
                        'label' => esc_html__('Amenities', 'weddingcity'),
                        'desc' => esc_html__('Which facily you provid in your Listing please checkbox is check then we show on front side with search restult.', 'weddingcity'),
                        'std' => '',
                        'type' => 'checkbox',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                        'choices' => WeddingCity_Listing_Meta::listing_amenities(),
                    ),

                    array(
                        'label' => esc_html__('Taxonomy Info', 'weddingcity'),
                        'id' => esc_attr('weddingcity_listing_overview'),
                        'type' => 'tab',
                    ),
                    array(
                        'id' => WeddingCity_Listing_Meta::listing_category_meta_name(),
                        'label' => esc_html__('Listing Category', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'taxonomy-select',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => WeddingCity_Texonomy::listing_category_taxonomy(),
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Listing_Meta::listing_country_meta_name(),
                        'label' => esc_attr__('Listing Country', 'weddingcity'),
                        'desc' => esc_attr__('Please Enter your Listing country here.', 'weddingcity'),
                        'std' => '',
                        'type' => 'taxonomy-select',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => WeddingCity_Texonomy::listing_location_taxonomy(),
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Listing_Meta::listing_state_meta_name(),
                        'label' => esc_attr__('Listing State', 'weddingcity'),
                        'desc' => esc_attr__('Please Enter your Listing state here.', 'weddingcity'),
                        'std' => '',
                        'type' => 'taxonomy-select',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => WeddingCity_Texonomy::listing_location_taxonomy(),
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Listing_Meta::listing_city_meta_name(),
                        'label' => esc_attr__('Listing City', 'weddingcity'),
                        'desc' => esc_attr__('Please Enter your Listing city here.', 'weddingcity'),
                        'std' => '',
                        'type' => 'taxonomy-select',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => WeddingCity_Texonomy::listing_location_taxonomy(),
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                ),
            );

            return array_merge($args, array($new_args));
        }

        /**
         *  WeddingCity Create Meta Example
         */
        public static function weddingcity_realwedding_setting($args) {

            $new_args = array(

                /**
                 *
                 *  Insert your meta code here.
                 *
                 *  @options_type : https://github.com/valendesigns/option-tree-theme/blob/master/inc/theme-options.php
                 *
                 */

                'id' => esc_attr('WeddingCity_RealWedding_Couple_Post_ID'),
                'title' => esc_html__('Couple Post ID', 'weddingcity'),
                'desc' => esc_attr__('', 'weddingcity'),
                'pages' => array('real-wedding'),
                'context' => 'side',
                'priority' => 'low',
                'fields' => array(

                    array(
                        'id' => 'realwedding_couple_id',
                        'label' => esc_html__('', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'select',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                        'choices' => weddingcity_theme_option_post_list('couple'),
                    ),
                ),
            );

            return array_merge($args, array($new_args));
        }

        /**
         *  WeddingCity Create Meta Example
         */
        public static function weddingcity_vendor_profile_setting($args) {

            $_social_profile = array();

            foreach (array(

                'facebook' => esc_html__('Facebook', 'weddingcity'),
                'twitter' => esc_html__('Twitter', 'weddingcity'),
                'instagram' => esc_html__('Instagram', 'weddingcity'),
                'youtube' => esc_html__('Youtube', 'weddingcity'),
                'pinterest' => esc_html__('Pintrest', 'weddingcity'),
                'linkedin' => esc_html__('Linkedin', 'weddingcity'),
                'google+' => esc_html__('Google+', 'weddingcity'),
                'rss' => esc_html__('RSS', 'weddingcity'),
                'tumblr' => esc_html__('Tumblr', 'weddingcity'),
                'vimeo' => esc_html__('Vimeo', 'weddingcity'),
                'behance' => esc_html__('Behance', 'weddingcity'),
                'dribbble' => esc_html__('Dribbble', 'weddingcity'),
                'flickr' => esc_html__('Flickr', 'weddingcity'),
                'git' => esc_html__('Git', 'weddingcity'),
                'skype' => esc_html__('Skype', 'weddingcity'),
                'weibo' => esc_html__('Weibo', 'weddingcity'),
                'foursquare' => esc_html__('Foursquare', 'weddingcity'),
                'soundcloud' => esc_html__('Soundcloud', 'weddingcity'),

            ) as $key => $value) {

                $_social_profile[$key] =

                array(
                    'id' => $key,
                    'label' => $value,
                    'desc' => esc_attr__('', 'weddingcity'),
                    'std' => '',
                    'type' => 'text',
                    'section' => 'option_types',
                    'rows' => '',
                    'post_type' => '',
                    'taxonomy' => '',
                    'min_max_step' => '',
                    'class' => '',
                    'condition' => '',
                    'operator' => '',
                );
            }

            $new_args = array(

                'id' => esc_attr('WeddingCity_User_Information'),
                'title' => esc_html__('User Information', 'weddingcity'),
                'desc' => esc_attr__('', 'weddingcity'),
                'pages' => array('vendor'),
                'context' => 'normal',
                'priority' => 'low',
                'fields' => array(

                    array(
                        'label' => esc_html__('About Info', 'weddingcity'),
                        'id' => esc_attr('weddingcity_vendor_user_about_us'),
                        'type' => 'tab',
                    ),

                    array(
                        'id' => WeddingCity_Vendor_Meta::profile_first_name_meta_name(),
                        'label' => esc_html__('First Name', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::profile_last_name_meta_name(),
                        'label' => esc_html__('Last Name', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::profile_user_contact_meta_name(),
                        'label' => esc_html__('Contact Number', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::profile_user_address_meta_name(),
                        'label' => esc_html__('User Address', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::profile_user_email_meta_name(),
                        'label' => esc_html__('User email', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),

                    array(
                        'label' => esc_html__('Business Profile', 'weddingcity'),
                        'id' => esc_attr('weddingcity_vendor_business_profile'),
                        'type' => 'tab',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::profile_business_name_meta_name(),
                        'label' => esc_html__('What is your business name ?', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::profile_user_website_meta_name(),
                        'label' => esc_html__('Insert your business website link.', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),

                    array(
                        'label' => esc_html__('Location Info', 'weddingcity'),
                        'id' => esc_attr('weddingcity_vendor_business_location'),
                        'type' => 'tab',
                    ),

                    array(
                        'id' => WeddingCity_Vendor_Meta::vendor_bussiness_latitude_meta_name(),
                        'label' => esc_html__('Bussiness Location Latitude', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::vendor_bussiness_longitude_meta_name(),
                        'label' => esc_html__('Bussiness Location Longitude', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::profile_business_country_meta_name(),
                        'label' => esc_html__('Bussiness Country', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'taxonomy-select',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => WeddingCity_Texonomy::vendor_location_taxonomy(),
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::profile_business_state_meta_name(),
                        'label' => esc_html__('Bussiness State', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'taxonomy-select',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => WeddingCity_Texonomy::vendor_location_taxonomy(),
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::profile_business_city_meta_name(),
                        'label' => esc_html__('Bussiness City', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'taxonomy-select',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => WeddingCity_Texonomy::vendor_location_taxonomy(),
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),

                    array(
                        'label' => esc_html__('Media Info', 'weddingcity'),
                        'id' => esc_attr('weddingcity_vendor_business_media_files'),
                        'type' => 'tab',
                    ),

                    array(
                        'id' => WeddingCity_Vendor_Meta::profile_user_image_meta_name(),
                        'label' => esc_attr__('Profile Image', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => WeddingCity_User_Meta::default_avtar(),
                        'type' => 'upload',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::profile_user_image_id_meta_name(),
                        'label' => esc_attr__('Profile Image Id', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'upload',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => 'ot-upload-attachment-id',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::business_profile_brand_image_meta_name(),
                        'label' => esc_attr__('Bussiness Brand Image', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => plugin_dir_url(__FILE__) . '/images/bussiness-profile/vendor-profile-img.jpg',
                        'type' => 'upload',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::business_profile_brand_id_meta_name(),
                        'label' => esc_attr__('Bussiness Brand Image Id', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'upload',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => 'ot-upload-attachment-id',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::business_profile_user_banner_image_meta_name(),
                        'label' => esc_attr__('Bussiness Profile Header Banner Image', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => plugin_dir_url(__FILE__) . '/images/bussiness-profile/vendor-profile-banner.jpg',
                        'type' => 'upload',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::business_profile_user_banner_id_meta_name(),
                        'label' => esc_attr__('Bussiness Profile Banner Image Id', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'upload',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => 'ot-upload-attachment-id',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::business_gallery_meta_name(),
                        'label' => esc_attr__('Business Gallery', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'gallery',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::business_video_bg_image_meta_name(),
                        'label' => esc_html__('Business Video Background Image', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'upload',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::business_video_bg_image_id_meta_name(),
                        'label' => esc_html__('Business Video Background Image ID', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'upload',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => 'ot-upload-attachment-id',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::business_video_meta_name(),
                        'label' => esc_attr__('Vendor Business Video Link Here', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),

                    array(
                        'label' => esc_html__('Social Profile', 'weddingcity'),
                        'id' => esc_attr('weddingcity_vendor_social_profile'),
                        'type' => 'tab',
                    ),

                    $_social_profile['facebook'],
                    $_social_profile['twitter'],
                    $_social_profile['instagram'],
                    $_social_profile['youtube'],
                    $_social_profile['pinterest'],
                    $_social_profile['linkedin'],
                    $_social_profile['google+'],
                    $_social_profile['rss'],
                    $_social_profile['tumblr'],
                    $_social_profile['vimeo'],
                    $_social_profile['behance'],
                    $_social_profile['dribbble'],
                    $_social_profile['flickr'],
                    $_social_profile['git'],
                    $_social_profile['skype'],
                    $_social_profile['weibo'],
                    $_social_profile['foursquare'],
                    $_social_profile['soundcloud'],

                    array(
                        'label' => esc_html__('Active Plan Info', 'weddingcity'),
                        'id' => esc_attr('weddingcity_vendor_active_plan_info'),
                        'type' => 'tab',
                    ),

                    array(
                        'id' => WeddingCity_Vendor_Meta::vendor_plan_name_meta_name(),
                        'label' => esc_html__('Active Plan', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::vendor_can_listing_meta_name(),
                        'label' => esc_html__('Total Listing Capacity', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::total_listing_meta_name(),
                        'label' => esc_html__('Number of Use Listing', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::payment_amount_meta_name(),
                        'label' => esc_html__('Payment Amount', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::vendor_payment_date_meta_name(),
                        'label' => esc_html__('Payment Date', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::payment_expire_date_meta_name(),
                        'label' => esc_html__('Expired Plan Date', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'date-picker',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::capacity_featured_listing_meta_name(),
                        'label' => esc_html__('Featured Listing Capacity', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '0',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::number_of_featured_listing_meta_name(),
                        'label' => esc_html__('Number of Use Featured Listing.', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '0',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),

                    array(
                        'label' => esc_html__('Listing Response', 'weddingcity'),
                        'id' => esc_attr('weddingcity_request_quote'),
                        'type' => 'tab',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::request_quote_meta_name(),
                        'label' => esc_html__('Listing Request Quote', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::reviews_meta_name(),
                        'label' => esc_html__('Listing reviews', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),

                    array(
                        'label' => esc_html__('Development Setting', 'weddingcity'),
                        'id' => esc_attr('weddingcity_dev_part'),
                        'type' => 'tab',
                    ),

                    array(
                        'id' => WeddingCity_Vendor_Meta::profile_user_id_meta_name(),
                        'label' => esc_html__('Register ID', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::profile_user_name_meta_name(),
                        'label' => esc_html__('Username', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::profile_user_type_meta_name(),
                        'label' => esc_html__('User Category ?', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'select',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                        'choices' => array(
                            array(
                                'value' => 'vendor',
                                'label' => esc_attr__('Vendor', 'weddingcity'),
                                'src' => '',
                            ),
                            array(
                                'value' => 'couple',
                                'label' => esc_attr__('Couple', 'weddingcity'),
                                'src' => '',
                            ),
                        ),
                    ),
                    array(
                        'id' => WeddingCity_Vendor_Meta::profile_vendor_type_meta_name(),
                        'label' => esc_html__('Vendor Type', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'taxonomy-select',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => WeddingCity_Texonomy::vendor_category_taxonomy(),
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                ),
            );

            return array_merge($args, array($new_args));
        }

        /**
         *  WeddingCity Couple Post Setting
         */
        public static function weddingcity_couple_profile_setting($args) {

            $_social_profile = array();

            foreach (array(

                'facebook' => esc_html__('Facebook', 'weddingcity'),
                'twitter' => esc_html__('Twitter', 'weddingcity'),
                'instagram' => esc_html__('Instagram', 'weddingcity'),
                'youtube' => esc_html__('Youtube', 'weddingcity'),
                'pinterest' => esc_html__('Pintrest', 'weddingcity'),
                'linkedin' => esc_html__('Linkedin', 'weddingcity'),
                'google+' => esc_html__('Google+', 'weddingcity'),
                'rss' => esc_html__('RSS', 'weddingcity'),
                'tumblr' => esc_html__('Tumblr', 'weddingcity'),
                'vimeo' => esc_html__('Vimeo', 'weddingcity'),
                'behance' => esc_html__('Behance', 'weddingcity'),
                'dribbble' => esc_html__('Dribbble', 'weddingcity'),
                'flickr' => esc_html__('Flickr', 'weddingcity'),
                'git' => esc_html__('Git', 'weddingcity'),
                'skype' => esc_html__('Skype', 'weddingcity'),
                'weibo' => esc_html__('Weibo', 'weddingcity'),
                'foursquare' => esc_html__('Foursquare', 'weddingcity'),
                'soundcloud' => esc_html__('Soundcloud', 'weddingcity'),

            ) as $key => $value) {

                $_social_profile[$key] =

                array(
                    'id' => $key,
                    'label' => $value,
                    'desc' => esc_attr__('', 'weddingcity'),
                    'std' => '',
                    'type' => 'text',
                    'section' => 'option_types',
                    'rows' => '',
                    'post_type' => '',
                    'taxonomy' => '',
                    'min_max_step' => '',
                    'class' => '',
                    'condition' => '',
                    'operator' => '',
                );
            }

            $new_args = array(

                'id' => esc_attr('WeddingCity_User_Information'),
                'title' => esc_html__('Couple Information', 'weddingcity'),
                'desc' => esc_attr__('', 'weddingcity'),
                'pages' => array('couple'),
                'context' => 'normal',
                'priority' => 'low',
                'fields' => array(

                    array(
                        'label' => esc_html__('About Info', 'weddingcity'),
                        'id' => esc_attr('weddingcity_couple_about_us'),
                        'type' => 'tab',
                    ),
                    array(
                        'id' => WeddingCity_Couple_Meta::profile_first_name_meta_name(),
                        'label' => esc_html__('First Name', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Couple_Meta::profile_last_name_meta_name(),
                        'label' => esc_html__('Last Name', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Couple_Meta::profile_user_contact_meta_name(),
                        'label' => esc_html__('User Contact', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Couple_Meta::profile_user_address_meta_name(),
                        'label' => esc_html__('User Address', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Couple_Meta::profile_user_email_meta_name(),
                        'label' => esc_html__('User email', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),

                    array(
                        'label' => esc_html__('Location Info', 'weddingcity'),
                        'id' => esc_attr('weddingcity_couple_location_info'),
                        'type' => 'tab',
                    ),
                    array(
                        'id' => WeddingCity_Couple_Meta::couple_profile_country_meta_name(),
                        'label' => esc_html__('Couple Country', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'taxonomy-select',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => WeddingCity_Texonomy::couple_location_taxonomy(),
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Couple_Meta::couple_profile_state_meta_name(),
                        'label' => esc_html__('Couple State', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'taxonomy-select',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => WeddingCity_Texonomy::couple_location_taxonomy(),
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Couple_Meta::couple_profile_city_meta_name(),
                        'label' => esc_html__('Couple City', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'taxonomy-select',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => WeddingCity_Texonomy::couple_location_taxonomy(),
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),

                    array(
                        'label' => esc_html__('Profile Media', 'weddingcity'),
                        'id' => esc_attr('weddingcity_couple_media'),
                        'type' => 'tab',
                    ),
                    array(
                        'id' => WeddingCity_Couple_Meta::profile_user_image_meta_name(),
                        'label' => esc_attr__('Profile Image', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => WeddingCity_User_Meta::default_avtar(),
                        'type' => 'upload',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => WeddingCity_Couple_Meta::profile_user_image_id_meta_name(),
                        'label' => esc_attr__('Profile Image Media Id', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'upload',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => 'ot-upload-attachment-id',
                        'condition' => '',
                        'operator' => 'and',
                    ),

                    array(
                        'label' => esc_html__('Social Profile', 'weddingcity'),
                        'id' => esc_attr('weddingcity_couple_social_profile'),
                        'type' => 'tab',
                    ),

                    $_social_profile['facebook'],
                    $_social_profile['twitter'],
                    $_social_profile['instagram'],
                    $_social_profile['youtube'],
                    $_social_profile['pinterest'],
                    $_social_profile['linkedin'],
                    $_social_profile['google+'],
                    $_social_profile['rss'],
                    $_social_profile['tumblr'],
                    $_social_profile['vimeo'],
                    $_social_profile['behance'],
                    $_social_profile['dribbble'],
                    $_social_profile['flickr'],
                    $_social_profile['git'],
                    $_social_profile['skype'],
                    $_social_profile['weibo'],
                    $_social_profile['foursquare'],
                    $_social_profile['soundcloud'],

                    array(
                        'label' => esc_html__('Development Setting', 'weddingcity'),
                        'id' => esc_attr('weddingcity_couple_dev_setting'),
                        'type' => 'tab',
                    ),
                    array(
                        'id' => 'couple_dev_setting',
                        'label' => __('Core Configration.', 'weddingcity'),
                        'desc' => __('Do not any changes any fields in this section only! this is build with core configrartion for this user. if you need any help, please contact us.', 'weddingcity'),
                        'std' => '',
                        'type' => 'textblock-titled',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => WeddingCity_Couple_Meta::profile_user_id_meta_name(),
                        'label' => esc_html__('Register ID', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Couple_Meta::profile_user_name_meta_name(),
                        'label' => esc_html__('Username', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => WeddingCity_Couple_Meta::profile_user_type_meta_name(),
                        'label' => esc_html__('User Category ?', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'select',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                        'choices' => array(
                            array(
                                'value' => 'vendor',
                                'label' => esc_attr__('Vendor', 'weddingcity'),
                                'src' => '',
                            ),
                            array(
                                'value' => 'couple',
                                'label' => esc_attr__('Couple', 'weddingcity'),
                                'src' => '',
                            ),
                        ),
                    ),

                    array(
                        'id' => WeddingCity_Couple_Meta::realwedding_post_id_meta_name(),
                        'label' => esc_html__('RealWedding Access Post', 'weddingcity'),
                        'desc' => '',
                        'std' => '',
                        'type' => 'select',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                        'choices' => weddingcity_theme_option_post_list('real-wedding'),
                    ),
                ),
            );

            return array_merge($args, array($new_args));
        }

        /**
         *  WeddingCity Page & Post Metaboxes
         *  ---------------------------------
         *
         *  1. Body Customization Metabox
         *
         *  2. Header Metabox
         *
         *  3. Page Header banner Metabox
         *
         *  4. Page Structure Metabox
         *
         *  5. Footer Metabox
         *
         */
        public static function weddingcity_general_setting($args) {

            $new_args = array(

                'id' => esc_attr('WeddingCity_page_settings'),
                'title' => esc_html__('Page Settings', 'weddingcity'),
                'desc' => esc_attr__('', 'weddingcity'),
                'pages' => array('post', 'page'),
                'context' => 'normal',
                'priority' => 'high',
                'fields' => array(

                    /**
                     *  Tabs Four
                     */
                    array(
                        'label' => esc_html__('Body Customization', 'weddingcity'),
                        'id' => esc_attr('weddingcity_body_customization'),
                        'type' => 'tab',
                    ),
                    array(
                        'id' => esc_attr('page_style'),
                        'label' => esc_attr__('Page Body Customization', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => '',
                        'type' => 'background',
                        'section' => 'theme_style',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('body_textblock_overview'),
                        'label' => esc_attr__('Textblock', 'weddingcity'),
                        'desc' => sprintf('WeddingCity Page Body customization meta using this page style you can easy to chagne. Example you can upload background image, background color customization, background position, background size, background attachment, background repeat and more option avalible here. If you need to more option or Suggestion Please Fill this <a href="%1$s">Form</a>.', WEDDINGCITY_FEEDBACK),
                        'std' => '',
                        'type' => 'textblock',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    /**
                     *  Header Setting
                     */

                    array(
                        'label' => esc_html__('Header Options', 'weddingcity'),
                        'id' => esc_attr('weddingcity_header_meta_setting'),
                        'type' => 'tab',
                    ),

                    array(
                        'id' => esc_attr('page_header_on_off'),
                        'label' => esc_attr__('Page Header On/Off', 'weddingcity'),
                        'desc' => esc_html__('This setting apply page heder show or hide on only this page.', 'weddingcity'),
                        'std' => 'on',
                        'type' => 'on-off',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => esc_attr('header_style'),
                        'label' => esc_attr__('Header Style', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => 'style-1',
                        'type' => 'select',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => 'page_header_on_off:is(on)',
                        'operator' => 'and',
                        'choices' => array(
                            array(
                                'value' => 'style-1',
                                'label' => esc_attr__('Transparent Header', 'weddingcity'),
                                'src' => '',
                            ),
                            array(
                                'value' => 'style-2',
                                'label' => esc_attr__('White Background Header', 'weddingcity'),
                                'src' => '',
                            ),
                        ),
                    ),

                    array(
                        'id' => esc_attr('header_textblock_overview'),
                        'label' => esc_attr__('Textblock', 'weddingcity'),
                        'desc' => sprintf('WeddingCity Header Fields Customization meta using this page header show or hide. you can show with diffrent header layout option avalible here and more option you need in future please feedback with this form. our team improved and release the newer version of theme soon. <a href="%1$s" target="_blank">Feedback</a>', WEDDINGCITY_FEEDBACK),
                        'std' => '',
                        'type' => 'textblock',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),

                    /**
                     *  Page header banner
                     */
                    array(
                        'label' => esc_html__('Page Header Banner', 'weddingcity'),
                        'id' => esc_attr('header_banner_setting'),
                        'type' => 'tab',
                    ),
                    array(
                        'id' => esc_attr('page_banner_show_hide'),
                        'label' => esc_attr__('Page Header Banner Show / Hide Option', 'weddingcity'),
                        'desc' => esc_html__('Page Header Banner Section Show / Hide.', 'weddingcity'),
                        'std' => 'on',
                        'type' => 'on-off',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => esc_attr('page_banner'),
                        'label' => esc_attr__('Upoad Your Page Banner Here', 'weddingcity'),
                        'desc' => esc_html__('If you want to display custom page banner image so you can easy to upload your <code>1920 x 250</code> image size.', 'weddingcity'),
                        'std' => '',
                        'type' => 'upload',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => 'page_banner_show_hide:is(on)',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('breadcrumbs_show_hide'),
                        'label' => esc_attr__('Breadcrumbs Setting', 'weddingcity'),
                        'desc' => esc_html__('Breadcrumbs Show / Hide Option for this page.', 'weddingcity'),
                        'std' => 'on',
                        'type' => 'on-off',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => esc_attr('page_header_banner_textblock_overview'),
                        'label' => esc_attr__('Textblock', 'weddingcity'),
                        'desc' => sprintf('WeddingCity Page Header Banner Meta Fields Customization using this page header banner show or hide. if option is on you can upload the page header banner image. in page header banner breadcrumbs features show / hide avalible. If you need to add other features please fill this form we improved and release update soon. <a href="%1$s" target="_blank">Feedback</a>', WEDDINGCITY_FEEDBACK),
                        'std' => '',
                        'type' => 'textblock',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),

                    /**
                     *  Page Structure.
                     */

                    array(
                        'label' => esc_html__('Page Structure', 'weddingcity'),
                        'id' => esc_attr('weddingcity_page_container_setting'),
                        'type' => 'tab',
                    ),
                    array(
                        'id' => esc_attr('container_style'),
                        'label' => esc_attr__('Page Structure', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => 'container',
                        'type' => 'select',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                        'choices' => array(
                            array(
                                'value' => 'container',
                                'label' => esc_attr__('Container', 'weddingcity'),
                                'src' => plugin_dir_url(__FILE__) . '/core/option-tree/images/container/container.jpg',
                            ),
                            array(
                                'value' => 'custom_structure',
                                'label' => esc_attr__('Custom Structure', 'weddingcity'),
                                'src' => plugin_dir_url(__FILE__) . '/core/option-tree/images/container/custom-div.jpg',
                            ),
                        ),
                    ),
                    array(
                        'id' => esc_attr('sidebar_position'),
                        'label' => esc_attr__('If you want added Sidebar ?', 'weddingcity'),
                        'desc' => esc_attr__('', 'weddingcity'),
                        'std' => 'right-sidebar',
                        'type' => 'select',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => 'container_style:not(custom_structure)',
                        'operator' => 'and',
                        'choices' => array(
                            array(
                                'value' => 'no-sidebar',
                                'label' => esc_attr__('No Sidebar', 'weddingcity'),
                                'src' => plugin_dir_url(__FILE__) . '/core/option-tree/images/sidebar/no-sidebar.jpg',
                            ),
                            array(
                                'value' => 'right-sidebar',
                                'label' => esc_attr__('Right Sidebar', 'weddingcity'),
                                'src' => plugin_dir_url(__FILE__) . '/core/option-tree/images/sidebar/right-sidebar.jpg',
                            ),
                            array(
                                'value' => 'left-sidebar',
                                'label' => esc_attr__('Left Sidebar', 'weddingcity'),
                                'src' => plugin_dir_url(__FILE__) . '/core/option-tree/images/sidebar/left-sidebar.jpg',
                            ),
                        ),
                    ),
                    array(
                        'id' => esc_attr('get_sidebar'),
                        'label' => esc_attr__('Please select sidebar', 'weddingcity'),
                        'desc' => esc_html__('Select sidebar that can be display on page with selectd sidebar', 'weddingcity'),
                        'std' => 'weddingcity-widget-primary',
                        'type' => 'sidebar-select',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => 'container_style:not(custom_structure),sidebar_position:not(no-sidebar)',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('page_strucure_textblock_overview'),
                        'label' => esc_attr__('Textblock', 'weddingcity'),
                        'desc' => sprintf('WeddingCity Page Container Structure using you can choose your page layout. container or custom Structure. if you selected container you have more choise to select sidebar option with position and select sidebar widget area. please fill this form we improved and release update soon. <a href="%1$s" target="_blank">Feedback</a>', WEDDINGCITY_FEEDBACK),
                        'std' => '',
                        'type' => 'textblock',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),

                    /**
                     *  Footer Options
                     */
                    array(
                        'label' => esc_html__('Footer Options', 'weddingcity'),
                        'id' => esc_attr('weddingcity_footer_meta_setting'),
                        'type' => 'tab',
                    ),
                    array(
                        'id' => esc_attr('page_footer_on_off'),
                        'label' => esc_attr__('Page Footer On/Off', 'weddingcity'),
                        'desc' => esc_html__('This setting apply page footer show or hide on only this page.', 'weddingcity'),
                        'std' => 'on',
                        'type' => 'on-off',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => esc_attr('page_tiny_footer_on_off'),
                        'label' => esc_attr__('Page Tiny Footer On/Off', 'weddingcity'),
                        'desc' => esc_html__('This setting apply page tiny footer show or hide on only this page.', 'weddingcity'),
                        'std' => 'on',
                        'type' => 'on-off',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => esc_attr('footer_textblock_overview'),
                        'label' => esc_attr__('Textblock', 'weddingcity'),
                        'desc' => sprintf('WeddingCity - Page Footer Field Meta using you can show / hide footer and tiny footer option avalible. if you need to more option here please fill this Suggestion and Feedback Form. <a href="%1$s" target="_blank">Feedback</a>', WEDDINGCITY_FEEDBACK),
                        'std' => '',
                        'type' => 'textblock',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),

                ),
            );

            return array_merge($args, array($new_args));
        }

        /**
         *  WeddingCity Post Setting
         */
        public static function weddingcity_post_setting($args) {

            $new_args = array(

                'id' => 'post-formate-helper',
                'title' => esc_html__('Post formate helper', 'weddingcity'),
                'desc' => esc_attr__('', 'weddingcity'),
                'pages' => array('post'),
                'context' => 'normal',
                'priority' => 'high',
                'fields' => array(

                    array(
                        'id' => esc_attr('gallery_meta'),
                        'label' => esc_attr__('Gallery', 'weddingcity'),
                        'desc' => esc_attr__('If you want to update post with gallery please upload your gallery images here. so on front side we present all images as gallery', 'weddingcity'),
                        'std' => '',
                        'type' => 'gallery',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => esc_attr('video_meta'),
                        'label' => esc_attr__('Video Link Here', 'weddingcity'),
                        'desc' => esc_attr__('Please enter your video link here that can be display on front side.', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => esc_attr('audio_meta'),
                        'label' => esc_attr__('Audio Link Here', 'weddingcity'),
                        'desc' => esc_attr__('Please enter your audio link here that can be display on front side.', 'weddingcity'),
                        'std' => '',
                        'type' => 'text',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                ),
            );

            return array_merge($args, array($new_args));
        }

        /**
         *
         *  WeddingCity All Option Retrive in Option Tree Function
         *
         */
        public static function weddingcity_create_metabox() {

            $wc_meta = apply_filters('wc_theme_meta', array());

            if (WeddingCity_Loader::array_condition($wc_meta)) {

                foreach ($wc_meta as $args) {

                    if (WeddingCity_Loader::array_condition($args)) {

                        ot_register_meta_box($args);
                    }
                }
            }
        }
    }

    /**
     *  Kicking this off by calling 'get_instance()' method
     */
    WeddingCity_Metabox::get_instance();
}

?>