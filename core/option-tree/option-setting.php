<?php

/**
 *  WeddingCity Add Listing Form
 */

if (!class_exists('WeddingCity_Theme_Options') && class_exists('OT_Loader')) {

    /**
     *  WeddingCity Emails
     */
    class WeddingCity_Theme_Options {

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
            add_action('init', array($this, 'weddingcity_create_theme_option'));

            /**
             *  General Setting for WeddingCity!
             */

            // add_filter('wc_theme_options', array($this, 'weddingcity_general_setting'), absint('10'));

            /**
             *  Typography Setting for WeddingCity!
             */

            add_filter('wc_theme_options', array($this, 'weddingcity_typography_setting'), absint('20'));

            /**
             *  Style Setting for WeddingCity!
             */

            add_filter('wc_theme_options', array($this, 'weddingcity_style_setting'), absint('30'));

            /**
             *  Header Setting for WeddingCity!
             */

            add_filter('wc_theme_options', array($this, 'weddingcity_header_setting'), absint('40'));

            /**
             *  Listing Setting for WeddingCity!
             */

            add_filter('wc_theme_options', array($this, 'weddingcity_listing_setting'), absint('50'));

            /**
             *  Vendor Setting for WeddingCity!
             */

            add_filter('wc_theme_options', array($this, 'weddingcity_vendor_setting'), absint('60'));

            /**
             *  Couple Setting for WeddingCity!
             */

            add_filter('wc_theme_options', array($this, 'weddingcity_couple_setting'), absint('70'));

            /**
             *  Payment Setting for WeddingCity!
             */

            add_filter('wc_theme_options', array($this, 'weddingcity_payment_gateway_setting'), absint('80'));

            /**
             *  Map Setting for WeddingCity!
             */

            add_filter('wc_theme_options', array($this, 'weddingcity_map_setting'), absint('90'));

            /**
             *  Email Setting for WeddingCity!
             */

            add_filter('wc_theme_options', array($this, 'weddingcity_email_setting'), absint('100'));

            /**
             *  404 Error Page Setting for WeddingCity!
             */

            add_filter('wc_theme_options', array($this, 'weddingcity_error_page_setting'), absint('110'));

            /**
             *  Footer Setting for WeddingCity!
             */

            add_filter('wc_theme_options', array($this, 'weddingcity_footer_setting'), absint('120'));

            /**
             *  Custom Code Setting for WeddingCity!
             */

            add_filter('wc_theme_options', array($this, 'weddingcity_custom_code_setting'), absint('130'));

            /**
             *  WeddingCity Information Section.
             */

            // add_filter('wc_theme_options', array($this, 'weddingcity_weddingcity_info_setting'), absint('100'));
        }

        /**
         *  This code is used for filter option
         */
        public static function example_default_parameter($args) {

            $new_args = array(

                'sections' => array(

                ),

                'settings' => array(

                ),
            );

            return array_merge_recursive($args, $new_args);
        }

        /**
         *  This code is used for filter option
         */
        public static function weddingcity_listing_setting($args) {

            $new_args = array(

                'sections' => array(

                    array(
                        'id' => esc_attr(__FUNCTION__),
                        'title' => esc_attr__('Listing Settings', 'weddingcity'),
                    ),
                ),

                'settings' => array(

                    /**
                     *  General Setting
                     */
                    array(
                        'id' => esc_attr('listing_general_settign'),
                        'label' => esc_attr__('General Setting', 'weddingcity'),
                        'type' => 'tab',
                        'section' => esc_attr(__FUNCTION__),
                    ),

                    array(
                        'id' => esc_attr('_currencty_possition_'),
                        'label' => esc_html__('Currency Possition', 'weddingcity'),
                        'desc' => '',
                        'std' => 'left',
                        'type' => 'select',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                        'choices' => array(

                            array(

                                'value' => esc_html('left'),
                                'label' => esc_html__('Left', 'weddingcity'),
                                'src' => '',
                            ),
                            array(

                                'value' => esc_html('right'),
                                'label' => esc_html__('Right', 'weddingcity'),
                                'src' => '',
                            ),
                        ),
                    ),

                    array(
                        'id' => esc_attr('listing_currency_sign'),
                        'label' => esc_attr__('Listing Currency Sign', 'weddingcity'),
                        'desc' => esc_html__('Please insert your listing currency sign', 'weddingcity'),
                        'std' => esc_html__('$', 'weddingcity'),
                        'type' => 'text',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),

                    array(
                        'id' => esc_attr('share_listing_tab'),
                        'label' => esc_attr__('Share Listing', 'weddingcity'),
                        'type' => 'tab',
                        'section' => esc_attr(__FUNCTION__),
                    ),

                    array(
                        'id' => esc_attr('share_listing'),
                        'label' => esc_attr__('Share Listing ?', 'weddingcity'),
                        'desc' => esc_html__('If you want to share listing ?', 'weddingcity'),
                        'std' => (WEDDINGCITY_PLUGIN_DEV_ON) ? 'on' : 'off',
                        'type' => 'on-off',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('listing_share'),
                        'label' => esc_html__('Share Listing', 'weddingcity'),
                        'desc' => esc_html__('Which social media you want share listing ? please checked checkbox.', 'weddingcity'),
                        'std' => array('Facebook', 'Twitter', 'Google', 'LinkedIn', 'Pinterest'),
                        'type' => 'checkbox',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => 'share_listing:is(on)',
                        'operator' => 'and',
                        'choices' => array(

                            array(
                                'value' => esc_html__('Facebook', 'weddingcity'),
                                'label' => esc_html__('Facebook', 'weddingcity'),
                                'src' => '',
                            ),
                            array(
                                'value' => esc_html__('Twitter', 'weddingcity'),
                                'label' => esc_html__('Twitter', 'weddingcity'),
                                'src' => '',
                            ),
                            array(
                                'value' => esc_html__('Google', 'weddingcity'),
                                'label' => esc_html__('Google+', 'weddingcity'),
                                'src' => '',
                            ),
                            array(
                                'value' => esc_html__('LinkedIn', 'weddingcity'),
                                'label' => esc_html__('LinkedIn', 'weddingcity'),
                                'src' => '',
                            ),
                            array(
                                'value' => esc_html__('Pinterest', 'weddingcity'),
                                'label' => esc_html__('Pinterest', 'weddingcity'),
                                'src' => '',
                            ),
                            array(
                                'value' => esc_html__('Digg', 'weddingcity'),
                                'label' => esc_html__('Digg', 'weddingcity'),
                                'src' => '',
                            ),
                            array(
                                'value' => esc_html__('Reddit', 'weddingcity'),
                                'label' => esc_html__('Reddit', 'weddingcity'),
                                'src' => '',
                            ),
                            array(
                                'value' => esc_html__('StumbleUpon', 'weddingcity'),
                                'label' => esc_html__('StumbleUpon', 'weddingcity'),
                                'src' => '',
                            ),
                            array(
                                'value' => esc_html__('Tumblr', 'weddingcity'),
                                'label' => esc_html__('Tumblr', 'weddingcity'),
                                'src' => '',
                            ),
                            array(
                                'value' => esc_html__('VK', 'weddingcity'),
                                'label' => esc_html__('VK', 'weddingcity'),
                                'src' => '',
                            ),

                        ),
                    ),

                ),
            );

            return array_merge_recursive($args, $new_args);
        }

        public static function weddingcity_weddingcity_info_setting($args) {

            $new_args = array(

                'sections' => array(

                    array(
                        'id' => esc_attr('feedback'),
                        'title' => esc_attr__('Feedback', 'weddingcity'),
                    ),
                ),

                'settings' => array(

                    array(
                        'id' => esc_attr('weddingcity_layouts_overview_text'),
                        'label' => __('WeddingCity - Directory & Listing WordPress Theme', 'weddingcity'),
                        'type' => 'weddingcity-overview',
                        'section' => esc_attr('feedback'),
                    ),
                ),
            );

            return array_merge_recursive($args, $new_args);
        }

        public static function weddingcity_custom_code_setting($args) {

            $new_args = array(

                'sections' => array(

                    array(
                        'id' => esc_attr(__FUNCTION__),
                        'title' => esc_attr__('Custom Code', 'weddingcity'),
                    ),
                ),

                'settings' => array(

                    array(
                        'id' => esc_attr('weddingcity_custom_css'),
                        'label' => __('CSS', 'weddingcity'),
                        'desc' => esc_html__('', 'weddingcity'),
                        'std' => '/* Add your custom css goes here */',
                        'type' => 'css',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '20',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),

                    array(
                        'id' => esc_attr('weddingcity_custom_script'),
                        'label' => __('JavaScript', 'weddingcity'),
                        'desc' => esc_html__('', 'weddingcity'),
                        'std' => '/* Add your js goes here */',
                        'type' => 'javascript',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '20',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                ),
            );

            return array_merge_recursive($args, $new_args);
        }

        public static function weddingcity_pro_version_tab($section) {

            return

            array(
                'id' => esc_attr($section . '_overview'),
                'label' => esc_attr__('PRO VERSION', 'weddingcity'),
                'type' => 'tab',
                'section' => esc_attr($section),
            );
        }

        public static function weddingcity_pro_version_overview($section) {

            return

            array(
                'id' => $section . 'buy_weddingcity_pro',
                'label' => __('Buy WeddingCity Pro', 'option-tree-theme'),
                'desc' => sprintf(esc_html__('<a href="%1$s" target="_blank">%2$s</a>', 'weddingcity'),

                    // 1
                    esc_url('https://themeforest.net/item/weddingcity-directory-listing-wordpress-theme/23442375?utm_source=themeoption&utm_medium=tobuylink&utm_campaign=buy_link_via_themeoption'),

                    // 2
                    esc_html__('WeddingCity')
                ),
                'std' => '',
                'type' => 'textblock-titled',
                'section' => $section,
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'min_max_step' => '',
                'class' => '',
                'condition' => '',
                'operator' => 'and',
            );
        }

        public static function weddingcity_vendor_setting($args) {

            $new_args = array(

                'sections' => array(

                    array(
                        'id' => esc_attr(__FUNCTION__),
                        'title' => esc_attr__('Vendor Setting', 'weddingcity'),
                    ),
                ),

                'settings' => array(

                    /**
                     *  New Vendor Register
                     */
                    array(
                        'id' => esc_attr('listing_new_vendor_register'),
                        'label' => esc_attr__('New Vendor Register', 'weddingcity'),
                        'type' => 'tab',
                        'section' => esc_attr(__FUNCTION__),
                    ),
                    array(
                        'id' => esc_attr('register_vendor_expired_date'),
                        'label' => esc_html__('New Register Vendor Listing Time Period', 'weddingcity'),
                        'desc' => sprintf(
                            esc_html__('New Registe Vendor has listing time period in %1$s.', 'weddingcity'),
                            get_option('blogname')
                        ),
                        'std' => '+2 Month',
                        'type' => 'select',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                        'choices' => (function_exists('weddingcity_time_period_theme_option'))
                        ? weddingcity_time_period_theme_option('Month', '0', '12')
                        : array(),
                    ),
                    array(
                        'id' => esc_attr('register_vendor_can_listing'),
                        'label' => esc_html__('New Register Vendor Can Listing', 'weddingcity'),
                        'desc' => sprintf(
                            esc_html__('New Registe Vendor can add listing in %1$s.', 'weddingcity'),
                            get_option('blogname')
                        ),
                        'std' => absint('3'),
                        'type' => 'text',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),

                    self::weddingcity_pro_version_tab(__FUNCTION__),
                    self::weddingcity_pro_version_overview(__FUNCTION__),
                ),
            );

            return array_merge_recursive($args, $new_args);
        }

        public static function weddingcity_couple_setting($args) {

            $new_args = array(

                'sections' => array(

                    array(
                        'id' => esc_attr(__FUNCTION__),
                        'title' => esc_attr__('Couple Setting', 'weddingcity'),
                    ),
                ),

                'settings' => array(

                    self::weddingcity_pro_version_tab(__FUNCTION__),
                    self::weddingcity_pro_version_overview(__FUNCTION__),
                ),
            );

            return array_merge_recursive($args, $new_args);
        }

        public static function weddingcity_payment_gateway_setting($args) {

            $new_args = array(

                'sections' => array(

                    array(
                        'id' => esc_attr(__FUNCTION__),
                        'title' => esc_attr__('Payment Transaction', 'weddingcity'),
                    ),
                ),

                'settings' => array(

                    self::weddingcity_pro_version_tab(__FUNCTION__),
                    self::weddingcity_pro_version_overview(__FUNCTION__),
                ),
            );

            return array_merge_recursive($args, $new_args);
        }

        public static function weddingcity_error_page_setting($args) {

            $new_args = array(

                'sections' => array(

                    array(
                        'id' => esc_attr(__FUNCTION__),
                        'title' => esc_attr__('404 Error Page', 'weddingcity'),
                    ),
                ),

                'settings' => array(

                    array(
                        'id' => esc_attr('404_erro_image'),
                        'label' => esc_attr__('Upload Your 404 Image', 'weddingcity'),
                        'desc' => esc_html__('Upload your custom 404 error image here', 'weddingcity'),
                        'std' => (defined('WEDDINGCITY_THEME_DIR')) ? esc_url(WEDDINGCITY_THEME_DIR . 'images/error-img.png') : '',
                        'type' => 'upload',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),

                    array(
                        'id' => esc_attr('404_title'),
                        'label' => esc_attr__('404 Error Page Title', 'weddingcity'),
                        'desc' => esc_html__('404 Error Page Heading Content', 'weddingcity'),
                        'std' => esc_html__('404', 'weddingcity'),
                        'type' => 'text',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('404_sub_title'),
                        'label' => esc_attr__('404 Error Page Sub Title', 'weddingcity'),
                        'desc' => esc_html__('404 Error Page Sub Heading Content', 'weddingcity'),
                        'std' => esc_html__('Oops! Looks like the page is gone.', 'weddingcity'),
                        'type' => 'text',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('404_error_description'),
                        'label' => esc_attr__('404 Error Page Description', 'weddingcity'),
                        'desc' => esc_html__('', 'weddingcity'),
                        'std' => esc_html__('The link is broken or the page has been moved. Try these pages instead:', 'weddingcity'),
                        'type' => 'text',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('404_listing_page'),
                        'label' => esc_html__('Add Your Page Button Link in 404 Error Page', 'weddingcity'),
                        'desc' => esc_html__('', 'weddingcity'),
                        'std' => array(
                            array('title' => 'Venues', 'name' => 'Venues', 'link' => home_url('/')),
                            array('title' => 'Vendors', 'name' => 'Vendors', 'link' => home_url('/')),
                            array('title' => 'About us', 'name' => 'About us', 'link' => home_url('/')),
                            array('title' => 'Contact us', 'name' => 'Contact us', 'link' => home_url('/')),
                            array('title' => 'Real Weddings', 'name' => 'Real Weddings', 'link' => home_url('/')),
                        ),
                        'type' => 'list-item',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'or',
                        'choices' => array(
                            array(
                                'value' => 'name',
                                'label' => esc_html__('Name', 'weddingcity'),
                                'src' => '',
                            ),
                            array(
                                'value' => 'link',
                                'label' => esc_html__('link', 'weddingcity'),
                                'src' => '',
                            ),
                        ),
                        'settings' => array(
                            array(
                                'id' => esc_attr('name'),
                                'label' => esc_html__('name', 'weddingcity'),
                                'desc' => esc_html__('Enter the name of the social website.', 'weddingcity'),
                                'std' => '',
                                'type' => 'text',
                                'rows' => '',
                                'post_type' => '',
                                'taxonomy' => '',
                                'min_max_step' => '',
                                'class' => '',
                                'condition' => '',
                                'operator' => 'and',
                            ),
                            array(
                                'id' => esc_attr('link'),
                                'label' => esc_html__('Enter Your Page Link', 'weddingcity'),
                                'desc' => esc_html__('Enter Your Page Link that can be display on 404 Error Page.', 'weddingcity'),
                                'std' => '',
                                'type' => 'text',
                                'rows' => '',
                                'post_type' => '',
                                'taxonomy' => '',
                                'min_max_step' => '',
                                'class' => '',
                                'condition' => '',
                                'operator' => 'and',
                            ),
                        ),
                    ),
                ),
            );

            return array_merge_recursive($args, $new_args);
        }

        public static function weddingcity_map_setting($args) {

            $new_args = array(

                'sections' => array(

                    array(
                        'id' => esc_attr(__FUNCTION__),
                        'title' => esc_attr__('Map Setting', 'weddingcity'),
                    ),
                ),

                'settings' => array(

                    array(
                        'id' => esc_attr('google_map_setting_tab'),
                        'label' => esc_attr__('Google Map', 'weddingcity'),
                        'type' => 'tab',
                        'section' => esc_attr(__FUNCTION__),
                    ),
                    array(
                        'id' => esc_attr('google_map_api_key_here'),
                        'label' => esc_attr__('Google Map API key here', 'weddingcity'),
                        'desc' => sprintf('Please Add Google Map Api key here so that website front side Google Map is Display visible with proper.
                                                  <a href="%1$s">%2$s</a>',
                            esc_url('https://developers.google.com/maps/documentation/javascript/get-api-key'),
                            esc_html__('How can i get Google Map API Key', 'weddingcity')
                        ),
                        'std' => (WEDDINGCITY_PLUGIN_DEV_ON) ? 'AIzaSyCvZiQwPXkkIeXfAn-Cki9RZBj69mg-95M' : '__MAP_API_KEY_HERE__',
                        'type' => 'text',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('weddingcity_latitude'),
                        'label' => esc_attr__('Latitude', 'weddingcity'),
                        'desc' => esc_html__('Insert Default Latitide for WeddingCity!', 'weddingcity'),
                        'std' => esc_html__('23.019469943904543', 'weddingcity'),
                        'type' => 'text',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('weddingcity_longitude'),
                        'label' => esc_attr__('Longitude', 'weddingcity'),
                        'desc' => esc_html__('Insert Default Longitude for WeddingCity!', 'weddingcity'),
                        'std' => esc_html__('72.5730813242451', 'weddingcity'),
                        'type' => 'text',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('google_map_icon'),
                        'label' => esc_attr__('Google Map icon', 'weddingcity'),
                        'desc' => esc_html__('Upload your custom google map icon here', 'weddingcity'),
                        'std' => (defined('WEDDINGCITY_THEME_DIR')) ? esc_url(WEDDINGCITY_THEME_DIR . 'images/map-pin.png') : '',
                        'type' => 'upload',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('google_map_cluster'),
                        'label' => esc_attr__('Google Map Cluster', 'weddingcity'),
                        'desc' => esc_html__('Upload your custom google map cluster here', 'weddingcity'),
                        'std' => (defined('WEDDINGCITY_THEME_DIR')) ? esc_url(WEDDINGCITY_THEME_DIR . 'images/m1.png') : '',
                        'type' => 'upload',
                        'section' => esc_attr(__FUNCTION__),
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

            return array_merge_recursive($args, $new_args);
        }

        public static function weddingcity_email_setting($args) {

            $new_args = array(

                'sections' => array(

                    array(
                        'id' => esc_attr(__FUNCTION__),
                        'title' => esc_attr__('Email Settings', 'weddingcity'),
                    ),
                ),

                'settings' => array(

                    array(
                        'id' => esc_attr('email_general_setting'),
                        'label' => esc_attr__('General Setting', 'weddingcity'),
                        'type' => 'tab',
                        'section' => esc_attr(__FUNCTION__),
                    ),
                    array(
                        'id' => esc_attr('email_logo'),
                        'label' => esc_attr__('Email Logo', 'weddingcity'),
                        'desc' => esc_html__('Sending Email Logo.', 'weddingcity'),
                        'std' => plugin_dir_url(__FILE__) . '/images/email/weddingcity-email.png',
                        'type' => 'upload',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('email_footer_content'),
                        'label' => esc_attr__('Email Footer Content', 'weddingcity'),
                        'desc' => esc_html__('', 'weddingcity'),
                        'std' => sprintf('If you have any problems, please contact me at <a style="color: #ff775a; display: inline-block; margin-bottom: 20px;" href="mailto:%1$s">%1$s</a>',
                            get_option('admin_email')
                        ),
                        'type' => 'textarea',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('email_thank_you'),
                        'label' => esc_attr__('Change Thank you Content.', 'weddingcity'),
                        'desc' => esc_html__('', 'weddingcity'),
                        'std' => esc_html__('Thank you', 'weddingcity'),
                        'type' => 'text',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),

                    array(
                        'id' => esc_attr('email_setting_vendor_register'),
                        'label' => esc_attr__('Vendor Registration', 'weddingcity'),
                        'type' => 'tab',
                        'section' => esc_attr(__FUNCTION__),
                    ),
                    array(
                        'id' => esc_attr('email_vendor_registration_subject'),
                        'label' => esc_attr__('Vendor Registration Email Subject Content.', 'weddingcity'),
                        'desc' => esc_html__('', 'weddingcity'),
                        'std' => sprintf(

                            // 1
                            esc_html__('Welcome to %1$s!', 'weddingcity'),

                            // 2
                            get_option('blogname')
                        ),

                        'type' => 'text',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('email_vendor_registration_header_content'),
                        'label' => esc_attr__('Vendor Registration Header Content', 'weddingcity'),
                        'desc' => esc_html__('Sending Email Header Content.', 'weddingcity'),
                        'std' => sprintf('Hello {{username}},<br>

                                                              Welcome to %1$s. Your account has been created. You can login now using the below credentials.',

                            // 1
                            get_option('blogname')
                        ),
                        'type' => 'textarea',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('email_vendor_registration_footer_content'),
                        'label' => esc_attr__('Vendor Registration Email Footer Content.', 'weddingcity'),
                        'desc' => esc_html__('', 'weddingcity'),
                        'std' => '',

                        'type' => 'textarea',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '8',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),

                    array(
                        'id' => esc_attr('email_setting_couple_register'),
                        'label' => esc_attr__('Couple Registration', 'weddingcity'),
                        'type' => 'tab',
                        'section' => esc_attr(__FUNCTION__),
                    ),
                    array(
                        'id' => esc_attr('email_couple_registration_subject'),
                        'label' => esc_attr__('Couple Registration Email Subject Content.', 'weddingcity'),
                        'desc' => esc_html__('', 'weddingcity'),
                        'std' => sprintf(

                            // 1
                            esc_html__('Welcome to %1$s!', 'weddingcity'),

                            // 2
                            get_option('blogname')
                        ),

                        'type' => 'text',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('email_couple_registration_header_content'),
                        'label' => esc_attr__('Couple Registration Header Content', 'weddingcity'),
                        'desc' => esc_html__('Sending Email Header Content.', 'weddingcity'),
                        'std' => sprintf('Hello {{username}},<br>

                                                              Welcome to %1$s. Your account has been created. You can login now using the below credentials.',

                            // 1
                            get_option('blogname')
                        ),
                        'type' => 'textarea',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('email_couple_registration_footer_content'),
                        'label' => esc_attr__('Couple Registration Email Footer Content.', 'weddingcity'),
                        'desc' => esc_html__('', 'weddingcity'),
                        'std' => '',

                        'type' => 'textarea',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '8',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),

                    array(
                        'id' => esc_attr('email_setting_forgot_password'),
                        'label' => esc_attr__('Forgot Password', 'weddingcity'),
                        'type' => 'tab',
                        'section' => esc_attr(__FUNCTION__),
                    ),
                    array(
                        'id' => esc_attr('email_forgot_password_subject'),
                        'label' => esc_attr__('Forgot Password Email Subject', 'weddingcity'),
                        'desc' => esc_html__('', 'weddingcity'),
                        'std' => sprintf(

                            // 1
                            esc_html__('Your New Password for %1$s!', 'weddingcity'),

                            // 2
                            get_option('blogname')
                        ),

                        'type' => 'text',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('email_forgot_password_header_content'),
                        'label' => esc_attr__('Forgot Password Header Content', 'weddingcity'),
                        'desc' => esc_html__('Sending Email Header Content.', 'weddingcity'),
                        'std' => sprintf(

                            // 1
                            esc_html__('You told us you forgot your password. if you really, please find the below new created password credentials:', 'weddingcity'),

                            // 2
                            get_option('blogname')
                        ),
                        'type' => 'textarea',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '8',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('email_forgot_password_footer_content'),
                        'label' => esc_attr__('Forgot Password Email Bottom Content.', 'weddingcity'),
                        'desc' => esc_html__('', 'weddingcity'),
                        'std' => '',

                        'type' => 'textarea',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '8',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),

                    array(
                        'id' => esc_attr('email_setting_change_password'),
                        'label' => esc_attr__('Change Password', 'weddingcity'),
                        'type' => 'tab',
                        'section' => esc_attr(__FUNCTION__),
                    ),
                    array(
                        'id' => esc_attr('email_change_password_subject'),
                        'label' => esc_attr__('Change Password Email Subject', 'weddingcity'),
                        'desc' => esc_html__('', 'weddingcity'),
                        'std' => sprintf(

                            // 1
                            esc_html__('Successfully Password Reset.', 'weddingcity'),

                            // 2
                            get_option('blogname')
                        ),

                        'type' => 'text',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('email_change_password_header_content'),
                        'label' => esc_attr__('Change Password Header Content', 'weddingcity'),
                        'desc' => esc_html__('Sending Email Header Content.', 'weddingcity'),
                        'std' => sprintf(

                            // 1
                            esc_html__('Your password successfully change. You have just reset your password from your dashboard.', 'weddingcity'),

                            // 2
                            get_option('blogname')
                        ),
                        'type' => 'textarea',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('email_change_password_footer_content'),
                        'label' => esc_attr__('Change Password Email Bottom Content Here.', 'weddingcity'),
                        'desc' => esc_html__('', 'weddingcity'),
                        'std' => '',

                        'type' => 'textarea',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '8',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),

                ),
            );

            return array_merge_recursive($args, $new_args);
        }

        public static function weddingcity_footer_setting($args) {

            $new_args = array(

                'sections' => array(

                    array(
                        'id' => esc_attr(__FUNCTION__),
                        'title' => esc_attr__('Footer', 'weddingcity'),
                    ),
                ),

                'settings' => array(

                    array(
                        'id' => esc_attr('footers_setting'),
                        'label' => esc_attr__('Footer Content', 'weddingcity'),
                        'type' => 'tab',
                        'section' => esc_attr(__FUNCTION__),
                    ),

                    array(
                        'id' => esc_attr('footer_copyright_text'),
                        'label' => esc_attr__('Footer Copyright Text', 'weddingcity'),
                        'desc' => esc_html__('Enter the text to display in footer copyright area for left side.', 'weddingcity'),
                        'std' => sprintf('<p>Copyright &copy; %2$s <a href="%1$s">WeddingCity</a>. All Rights Reserved.</p>',
                            home_url('/'), date('Y'), esc_html('&#xA9;')
                        ),
                        'type' => 'textarea',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('tiny_footer_tab'),
                        'label' => esc_attr__('Tiny Footer Customization', 'weddingcity'),
                        'type' => 'tab',
                        'section' => esc_attr(__FUNCTION__),
                    ),
                    array(
                        'id' => esc_attr('tiny_footer_background'),
                        'label' => esc_attr__('Tiny Footer Background', 'weddingcity'),
                        'desc' => '',
                        'std' => '',
                        'type' => 'colorpicker-opacity',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                        'object' => array(

                            'class' => '#colophon',
                            'property' => 'background',
                        ),
                    ),
                    array(
                        'id' => esc_attr('tiny_footer_text_color'),
                        'label' => esc_attr__('Tiny Footer Text Color', 'weddingcity'),
                        'desc' => esc_html__('Please provide tiny footer text color.', 'weddingcity'),
                        'std' => '',
                        'type' => 'colorpicker-opacity',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                        'object' => array(

                            'class' => '#colophon p',
                            'property' => 'color',
                        ),
                    ),

                ),
            );

            return array_merge_recursive($args, $new_args);
        }

        public static function weddingcity_style_setting($args) {

            $new_args = array(

                'sections' => array(

                    array(
                        'id' => esc_attr(__FUNCTION__),
                        'title' => esc_attr__('Theme Style', 'weddingcity'),
                    ),
                ),

                'settings' => array(

                    array(
                        'id' => esc_attr('body_content_style'),
                        'label' => esc_attr__('Body & Content', 'weddingcity'),
                        'type' => 'tab',
                        'section' => esc_attr(__FUNCTION__),
                    ),
                    array(
                        'id' => esc_attr('body_style'),
                        'label' => esc_attr__('Body Styles', 'weddingcity'),
                        'desc' => '',
                        'std' => '',
                        'type' => 'link-color',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                        'object' => array(

                            'class' => 'body',
                            'property' => 'background',
                        ),
                    ),
                    array(
                        'id' => esc_attr('heading_h1'),
                        'label' => esc_attr__('Heading H1', 'weddingcity'),
                        'desc' => '',
                        'std' => '',
                        'type' => 'typography',
                        'object' => array('tag' => 'h1'),
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('heading_h2'),
                        'label' => esc_attr__('Heading H2', 'weddingcity'),
                        'desc' => '',
                        'std' => '',
                        'type' => 'typography',
                        'object' => array('tag' => 'h2'),
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => esc_attr('heading_h3'),
                        'label' => esc_attr__('Heading H3', 'weddingcity'),
                        'desc' => '',
                        'std' => '',
                        'type' => 'typography',
                        'object' => array('tag' => 'h3'),
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => esc_attr('heading_h4'),
                        'label' => esc_attr__('Heading H4', 'weddingcity'),
                        'desc' => '',
                        'std' => '',
                        'type' => 'typography',
                        'object' => array('tag' => 'h4'),
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => esc_attr('heading_h5'),
                        'label' => esc_attr__('Heading H5', 'weddingcity'),
                        'desc' => '',
                        'std' => '',
                        'type' => 'typography',
                        'object' => array('tag' => 'h5'),
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => esc_attr('heading_h6'),
                        'label' => esc_attr__('Heading H6', 'weddingcity'),
                        'desc' => '',
                        'std' => '',
                        'type' => 'typography',
                        'object' => array('tag' => 'h6'),
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => 'paragraph_p',
                        'label' => 'Paragraph P',
                        'desc' => '',
                        'std' => '',
                        'type' => 'colorpicker-opacity',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                        'object' => array(

                            'class' => 'p',
                            'property' => 'color',
                        ),
                    ),

                    array(
                        'id' => esc_attr('buttons_style'),
                        'label' => esc_attr__('Buttons', 'weddingcity'),
                        'type' => 'tab',
                        'section' => esc_attr(__FUNCTION__),
                    ),

                    array(
                        'id' => esc_attr('primary_button'),
                        'label' => esc_html__('Primary Button Normal', 'weddingcity'),
                        'desc' => '',
                        'std' => '',
                        'type' => 'link-color',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                        'object' => array(

                            'class' => '.btn-primary',
                            'property' => 'color',
                        ),
                    ),
                    array(
                        'id' => esc_attr('primary_button_hover'),
                        'label' => esc_html__('Primary Button Hover', 'weddingcity'),
                        'desc' => '',
                        'std' => '',
                        'type' => 'link-color',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                        'object' => array(

                            'class' => '.btn-primary:hover',
                            'property' => 'color',
                        ),
                    ),

                    array(
                        'id' => esc_attr('default_button'),
                        'label' => esc_html__('Default Button Normal', 'weddingcity'),
                        'desc' => '',
                        'std' => '',
                        'type' => 'link-color',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                        'object' => array(

                            'class' => '.btn-default',
                            'property' => 'color',
                        ),
                    ),
                    array(
                        'id' => esc_attr('default_button_hover'),
                        'label' => esc_html__('Default Button Hover', 'weddingcity'),
                        'desc' => '',
                        'std' => '',
                        'type' => 'link-color',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                        'object' => array(

                            'class' => '.btn-default:hover',
                            'property' => 'color',
                        ),
                    ),

                    array(
                        'id' => esc_attr('accents_style'),
                        'label' => esc_attr__('Accents', 'weddingcity'),
                        'type' => 'tab',
                        'section' => esc_attr(__FUNCTION__),
                    ),
                    array(
                        'id' => esc_attr('assets_customization'),
                        'label' => esc_html__('Accent Link Color', 'weddingcity'),
                        'desc' => '',
                        'std' => '',
                        'type' => 'link-color',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                        'object' => array(

                            'class' => 'a',
                            'property' => 'color',
                        ),
                    ),

                ),
            );

            return array_merge_recursive($args, $new_args);
        }

        public static function _get_margin_options() {

            $i = array();

            $i[] = array(

                'value' => '',
                'label' => esc_html__('Margin Bottom', 'weddingcity'),
                'src' => '',
            );

            foreach (range(absint('10'), absint('40'), absint('10')) as $number) {

                $i[] =

                array(
                    'value' => sprintf('%1$spx', $number),
                    'label' => sprintf('%1$spx', $number),
                    'src' => '',
                );
            }

            return $i;
        }

        public static function weddingcity_typography_setting($args) {

            $new_args = array(

                'sections' => array(

                    array(
                        'id' => esc_attr(__FUNCTION__),
                        'title' => esc_attr__('Typography', 'weddingcity'),
                    ),
                ),

                'settings' => array(

                    /** Tab Section **/
                    array(
                        'id' => esc_attr('body_typography_tab'),
                        'label' => esc_attr__('Body Typography', 'weddingcity'),
                        'type' => 'tab',
                        'section' => esc_attr(__FUNCTION__),
                    ),

                    array(
                        'id' => esc_attr('body_typography'),
                        'label' => esc_attr__('Body Typography', 'weddingcity'),
                        'desc' => '',
                        'std' => '',
                        'type' => 'typography',
                        'object' => array('tag' => 'body'),
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('weddingcity_heading_typography'),
                        'label' => esc_attr__('Heading Typography', 'weddingcity'),
                        'desc' => '',
                        'std' => '',
                        'type' => 'typography',
                        'object' => array('tag' => 'h1,h2,h3,h4,h5,h6'),
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('heading_p'),
                        'label' => esc_attr__('Paragraph Text', 'weddingcity'),
                        'desc' => '',
                        'std' => '20px',
                        'type' => 'select',
                        'object' => array('tag' => 'p'),
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                        'choices' => self::_get_margin_options(),
                    ),

                    /** Tab Section **/
                    array(
                        'id' => esc_attr('heading_font_tab'),
                        'label' => esc_attr__('Heading Typography', 'weddingcity'),
                        'type' => 'tab',
                        'section' => esc_attr(__FUNCTION__),
                    ),

                    array(
                        'id' => esc_attr('heading_h1'),
                        'label' => esc_attr__('Heading H1', 'weddingcity'),
                        'desc' => '',
                        'std' => '',
                        'type' => 'typography',
                        'object' => array('tag' => 'h1'),
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('heading_h2'),
                        'label' => esc_attr__('Heading H2', 'weddingcity'),
                        'desc' => '',
                        'std' => '',
                        'type' => 'typography',
                        'object' => array('tag' => 'h2'),
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => esc_attr('heading_h3'),
                        'label' => esc_attr__('Heading H3', 'weddingcity'),
                        'desc' => '',
                        'std' => '',
                        'type' => 'typography',
                        'object' => array('tag' => 'h3'),
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => esc_attr('heading_h4'),
                        'label' => esc_attr__('Heading H4', 'weddingcity'),
                        'desc' => '',
                        'std' => '',
                        'type' => 'typography',
                        'object' => array('tag' => 'h4'),
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => esc_attr('heading_h5'),
                        'label' => esc_attr__('Heading H5', 'weddingcity'),
                        'desc' => '',
                        'std' => '',
                        'type' => 'typography',
                        'object' => array('tag' => 'h5'),
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),
                    array(
                        'id' => esc_attr('heading_h6'),
                        'label' => esc_attr__('Heading H6', 'weddingcity'),
                        'desc' => '',
                        'std' => '',
                        'type' => 'typography',
                        'object' => array('tag' => 'h6'),
                        'section' => esc_attr(__FUNCTION__),
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

            return array_merge_recursive($args, $new_args);
        }

        public static function weddingcity_general_setting($args) {

            $new_args = array(

                'sections' => array(

                    array(

                        'id' => esc_attr(__FUNCTION__),
                        'title' => esc_attr__('General Setting', 'weddingcity'),
                    ),
                ),

                'settings' => array(

                    /** Tab Section **/
                    array(
                        'id' => esc_attr('top_header_general_setting'),
                        'label' => esc_attr__('General Setting', 'weddingcity'),
                        'type' => 'tab',
                        'section' => esc_attr(__FUNCTION__),
                    ),

                    array(
                        'id' => esc_attr('plain_text_logo'),
                        'label' => esc_attr__('Website Logo Enable ?', 'weddingcity'),
                        'desc' => esc_html__('Check this box to enable a plain text logo rather than an image logo. Will use your site title.', 'weddingcity'),
                        'std' => 'off',
                        'type' => 'on-off',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('custom_favicon_upload'),
                        'label' => esc_attr__('Website Favicon', 'weddingcity'),
                        'desc' => esc_html__('Upload a 16px x 16px Png/Gif image that will represent your website\'s favicon. Use X-Icon Editor to easily create a favicon.', 'weddingcity'),
                        'std' => (defined('WEDDINGCITY_THEME_DIR')) ? esc_url(WEDDINGCITY_THEME_DIR . 'images/favicon-32x32.png') : '',
                        'type' => 'upload',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('header_logo_1'),
                        'label' => esc_attr__('White Logo Upload Here', 'weddingcity'),
                        'desc' => esc_html__('Transaction Header logo upload here', 'weddingcity'),
                        'std' => (defined('WEDDINGCITY_THEME_DIR')) ? esc_url(WEDDINGCITY_THEME_DIR . 'images/weddingcity-white.svg') : '',
                        'type' => 'upload',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => 'plain_text_logo:is(on)',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('header_logo_2'),
                        'label' => esc_attr__('Dark Logo Upload Here', 'weddingcity'),
                        'desc' => esc_html__('White Header logo upload here', 'weddingcity'),
                        'std' => (defined('WEDDINGCITY_THEME_DIR')) ? esc_url(WEDDINGCITY_THEME_DIR . 'images/weddingcity-dark.svg') : '',
                        'type' => 'upload',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => 'plain_text_logo:is(on)',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('vendor_registration_logo'),
                        'label' => esc_attr__('Vendor Registration Logo', 'weddingcity'),
                        'desc' => esc_html__('Upload your vendor registration logo here.', 'weddingcity'),
                        'std' => (defined('WEDDINGCITY_THEME_DIR')) ? esc_url(WEDDINGCITY_THEME_DIR . 'images/weddingcity-dark.svg') : '',
                        'type' => 'upload',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => 'plain_text_logo:is(on)',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('couple_registration_logo'),
                        'label' => esc_attr__('Couple Registration Logo', 'weddingcity'),
                        'desc' => esc_html__('Upload your couple registration logo here.', 'weddingcity'),
                        'std' => (defined('WEDDINGCITY_THEME_DIR')) ? esc_url(WEDDINGCITY_THEME_DIR . 'images/weddingcity-dark.svg') : '',
                        'type' => 'upload',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => 'plain_text_logo:is(on)',
                        'operator' => 'and',
                    ),
                    array(
                        'id' => esc_attr('weddingcity_divider'),
                        'label' => esc_attr__('Upload Custom Divider', 'weddingcity'),
                        'desc' => esc_html__('WeddingCity Page Section Divider Upload Here.', 'weddingcity'),
                        'std' => (defined('WEDDINGCITY_THEME_DIR')) ? esc_url(WEDDINGCITY_THEME_DIR . 'images/divider-pattern.svg') : '',
                        'type' => 'upload',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                    ),

                    array(
                        'id' => esc_attr('search_filter'),
                        'label' => esc_attr__('Search Filter', 'weddingcity'),
                        'type' => 'tab',
                        'section' => esc_attr(__FUNCTION__),
                    ),

                    array(
                        'id' => esc_attr('search_form_background_color'),
                        'label' => esc_attr__('Search form Background Color', 'weddingcity'),
                        'desc' => '',
                        'std' => '',
                        'type' => 'colorpicker-opacity',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                        'object' => array(

                            'class' => '.search-form',
                            'property' => 'background',

                            'media' => array(

                                '480' => array(

                                    'class' => '.search-form, .search-area',
                                ),
                            ),
                        ),
                    ),
                ),
            );

            return array_merge_recursive($args, $new_args);
        }

        public static function weddingcity_header_setting($args) {

            $new_args = array(

                'sections' => array(

                    array(

                        'id' => esc_attr(__FUNCTION__),
                        'title' => esc_attr__('Header Setting', 'weddingcity'),
                    ),
                ),

                'settings' => array(

                    array(
                        'id' => esc_attr('weddingcity_header_button'),
                        'label' => esc_attr__('General Setting', 'weddingcity'),
                        'type' => 'tab',
                        'section' => esc_attr(__FUNCTION__),
                    ),

                    array(
                        'id' => esc_attr('header_button_show_hide'),
                        'label' => esc_attr__('Header Button Show / Hide ?', 'weddingcity'),
                        'desc' => esc_html__('couple and vendor can login and register button show on header ? Remember this fields display when user can not login. if user is login then button is not display.', 'weddingcity'),
                        'std' => 'on',
                        'type' => 'on-off',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => '',
                    ),

                    array(
                        'id' => esc_attr('headers_transprant'),
                        'label' => esc_attr__('Transparent Headers', 'weddingcity'),
                        'type' => 'tab',
                        'section' => esc_attr(__FUNCTION__),
                    ),

                    array(
                        'id' => esc_attr('header_v1_style'),
                        'label' => esc_attr__('Transparent Sticky Header Background Color', 'weddingcity'),
                        'desc' => '',
                        'std' => '',
                        'type' => 'colorpicker-opacity',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                        'object' => array(

                            'class' => '.header-fullwidth-transparent',
                            'property' => 'background',

                            'media' => array(

                                '480' => array(

                                    'class' => '.header-fullwidth-transparent',
                                ),
                            ),
                        ),
                    ),
                    array(
                        'id' => esc_attr('header_v1_menubar_bg'),
                        'label' => esc_attr__('Transparent Sticy Header Dropdown Menu background', 'weddingcity'),
                        'desc' => '',
                        'std' => '',
                        'type' => 'colorpicker-opacity',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'and',
                        'object' => array(

                            'class' => '.header-fullwidth-transparent #navigation ul ul li a',
                            'property' => 'background',
                        ),
                    ),

                    array(
                        'id' => esc_attr('header_version_one_menu_text_color'),
                        'label' => esc_attr__('Transparent Sticy Header Dropdown Menu Text Color', 'weddingcity'),
                        'desc' => '',
                        'std' => '',
                        'type' => 'colorpicker-opacity',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'or',
                        'object' => array(

                            'class' => '.header.header-fullwidth-transparent #navigation>ul>li>a, .header.header-fullwidth-transparent #navigation ul ul li a',
                            'property' => 'color',
                        ),
                    ),
                    array(
                        'id' => esc_attr('header_version_one_menu_text_hover_color'),
                        'label' => esc_attr__('Transparent Sticy Header Dropdown Menu Text Hover Color', 'weddingcity'),
                        'desc' => '',
                        'std' => '',
                        'type' => 'colorpicker-opacity',
                        'section' => esc_attr(__FUNCTION__),
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'or',
                        'object' => array(

                            'class' => '.header.header-fullwidth-transparent #navigation ul ul li a:hover',
                            'property' => 'color',
                        ),
                    ),
                ),
            );

            return array_merge_recursive($args, $new_args);
        }

        /**
         *
         *  WeddingCity All Option Retrive in Option Tree Function
         *
         */
        public static function weddingcity_create_theme_option() {

            if (!function_exists('ot_settings_id') || !is_admin()) {

                return false;
            }

            $saved_settings = get_option(ot_settings_id(), array());

            $custom_settings = apply_filters('wc_theme_options', array());

            /* allow settings to be filtered before saving */
            $custom_settings = apply_filters(ot_settings_id() . '_args', $custom_settings);

            /* settings are not the same update the DB */
            if ($saved_settings !== $custom_settings) {
                update_option(ot_settings_id(), $custom_settings);
            }

            /* Lets OptionTree know the UI Builder is being overridden */
            global $ot_has_weddingcity_theme_options;
            $ot_has_weddingcity_theme_options = true;
        }
    }

    /**
     *  Kicking this off by calling 'get_instance()' method
     */
    WeddingCity_Theme_Options::get_instance();
}

?>