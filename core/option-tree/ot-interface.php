<?php

/**
 *  WeddingCity Add Listing Form
 */

if (!class_exists('WeddingCity_Theme_Options_Interface') && class_exists('OT_Loader')) {

    /**
     *  WeddingCity Emails
     */
    class WeddingCity_Theme_Options_Interface {

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
             *  Option Tree Default Pages Show False, Such as Documentation, Drag and Drop Section & Setting Page
             */
            add_filter('ot_show_pages', '__return_false');

            /**
             *  Opiton Tree New Layout Filter
             */
            add_filter('ot_show_new_layout', '__return_false');

            /**
             *  Option Tree Textarea Filter
             */
            add_filter('ot_override_forced_textarea_simple', '__return_true');

            /**
             *  Option Tree Included Font Family List
             */
            add_filter('ot_google_fonts_api_key', function () {return 'AIzaSyANMeyvv5WTJrbMuIMP4FZ_rbUaUt16Sfw';});

            /**
             *  Option Tree Version
             */
            add_filter('ot_header_version_text', function () {return esc_html('WeddingCity');}, absint('10'), absint('2'));

            /**
             *  Option Page Title
             */
            add_filter('ot_theme_options_page_title', array($this, 'weddingcity_filter_page_title'), absint('10'), absint('2'));

            /**
             *  Option Page Menu Title
             */
            add_filter('ot_theme_options_menu_title', array($this, 'weddingcity_filter_page_title'), absint('10'), absint('2'));

            /**
             *  Option Tree Upload Media Popup Button Text
             */
            add_filter('ot_upload_text', array($this, 'weddingcity_filter_upload_text'), absint('10'), absint('2'));

            /**
             *  Option Tree Header List
             */
            add_filter('ot_header_list', array($this, 'weddingcity_ot_header_list'));

            /**
             *  Option Tree Page Header Style
             */
            add_action('admin_head', array($this, 'weddingcity_ot_custom_option_style'));

            /**
             *  Opiton Tree add Font family list
             */
            add_filter('ot_recognized_font_families', array($this, 'weddingcity_filter_ot_recognized_font_families'), absint('10'), absint('2'));

            /**
             *  Option Tree Store Value Print in Front Side
             */
            add_action('wp_enqueue_scripts', array($this, 'weddingcity_option_tree_stylesheet_print'), absint('9999999'));

            /**
             *  Heading Tag H1 to H5 Filter
             *
             *  @link  https://github.com/valendesigns/option-tree/issues/214#issuecomment-150739756
             *
             */
            add_filter('ot_recognized_typography_fields', array($this, 'weddingcity_headings_typography_fields'), absint('10'), absint('2'));

            add_filter('ot_recognized_typography_fields', array($this, 'weddingcity_body_typography_fields'), absint('10'), absint('2'));

            add_filter('ot_recognized_typography_fields', array($this, 'weddingcity_heading_typography_fields'), absint('10'), absint('2'));

            add_filter('ot_recognized_link_color_fields', array($this, 'weddingcity_primary_button_group'), absint('10'), absint('2'));

            add_filter('ot_recognized_link_color_fields', array($this, 'weddingcity_primary_button_hover_group'), absint('10'), absint('2'));

            add_filter('ot_recognized_link_color_fields', array($this, 'weddingcity_default_button_group'), absint('10'), absint('2'));

            add_filter('ot_recognized_link_color_fields', array($this, 'weddingcity_default_button_hover_group'), absint('10'), absint('2'));

            add_filter('ot_recognized_link_color_fields', array($this, 'weddingcity_body_style_group'), absint('10'), absint('2'));
        }

        public static function weddingcity_primary_button_group($fields, $field_id) {
            if (preg_match('/\bprimary_button\b/i', $field_id)) {

                $fields = array(

                    'bg' => _x('Background Color', 'color picker', 'option-tree'),
                    'text' => _x('Text Color', 'color picker', 'option-tree'),
                    'border' => _x('Outline Color', 'color picker', 'option-tree'),
                );
            }
            return $fields;
        }

        public static function weddingcity_primary_button_hover_group($fields, $field_id) {
            if (preg_match('/\bprimary_button_hover\b/i', $field_id)) {

                $fields = array(

                    'bg' => _x('Background Color', 'color picker', 'option-tree'),
                    'text' => _x('Text Color', 'color picker', 'option-tree'),
                    'border' => _x('Outline Color', 'color picker', 'option-tree'),
                );
            }
            return $fields;
        }

        public static function weddingcity_default_button_group($fields, $field_id) {
            if (preg_match('/\bdefault_button\b/i', $field_id)) {

                $fields = array(

                    'bg' => _x('Background Color', 'color picker', 'option-tree'),
                    'text' => _x('Text Color', 'color picker', 'option-tree'),
                    'border' => _x('Outline Color', 'color picker', 'option-tree'),
                );
            }
            return $fields;
        }

        public static function weddingcity_default_button_hover_group($fields, $field_id) {
            if (preg_match('/\bdefault_button_hover\b/i', $field_id)) {

                $fields = array(

                    'bg' => _x('Background Color', 'color picker', 'option-tree'),
                    'text' => _x('Text Color', 'color picker', 'option-tree'),
                    'border' => _x('Outline Color', 'color picker', 'option-tree'),
                );
            }
            return $fields;
        }

        public static function weddingcity_body_style_group($fields, $field_id) {
            if (preg_match('/\bbody_style\b/i', $field_id)) {

                $fields = array(

                    'bg' => _x('Background Color', 'color picker', 'option-tree'),
                    'text' => _x('Text Color', 'color picker', 'option-tree'),
                );
            }
            return $fields;
        }

        public static function weddingcity_heading_typography_fields($fields, $field_id) {
            if (preg_match('/\bweddingcity_heading_typography\b/i', $field_id)) {
                $fields = array(
                    'font-family',
                    'font-weight',
                    'text-transform',
                );
            }
            return $fields;
        }

        public static function weddingcity_body_typography_fields($fields, $field_id) {
            if (preg_match('/\bbody_typography\b/i', $field_id)) {
                $fields = array(
                    'font-family',
                    'font-size',
                    'font-weight',
                    'line-height',
                );
            }
            return $fields;
        }

        public static function weddingcity_headings_typography_fields($fields, $field_id) {

            if (preg_match('/\bheading_h([1-6]{1})\b/i', $field_id)) {

                $fields = array(
                    'font-size',
                    'line-height',
                );
            }
            return $fields;
        }

        public static function weddingcity_filter_page_title() {

            return wp_kses(__('WeddingCity Options', 'weddingcity'), array('a' => array('href' => array(), 'title' => array())));
        }

        public static function weddingcity_filter_upload_text() {

            return wp_kses(__('Send to WeddingCity', 'weddingcity'), array('a' => array('href' => array(), 'title' => array())));
        }

        public static function weddingcity_ot_header_list() {

            printf('<li class="theme_link right"><a href="%2$s" target="_blank">%1$s</a></li>
                     <li class="theme_link right"><a href="%4$s" target="_blank">%3$s</a></li>
                     <li class="theme_link right"><a href="%6$s" target="_blank">%5$s</a></li>
                     <li class="theme_link right"><a href="%10$s" target="_blank" id="feedback">%9$s</a></li>
                     <li class="theme_link right"><a href="%8$s" target="_blank" id="rate_us">%7$s</a></li>',

                // 1
                esc_html__('Live Documentation', 'weddingcity'),

                // 2
                esc_url('weddingcity.wporganic.com/documentation/'),

                // 3
                esc_html__('Recommended Hosting', 'weddingcity'),

                // 4
                esc_url('www.siteground.com/recommended?referrer_id=7401201'),

                // 5
                esc_html__('Support', 'weddingcity'),

                // 6
                esc_url('themeforest.net/user/weddingcity?ref=weddingcity#contact'),

                // 7
                esc_html('Rate Product!'),

                // 8
                esc_url("themeforest.net/item/weddingcity-directory-listing-wordpress-theme/23442375"),

                // 9
                esc_html('Feedback'),

                // 10
                esc_url(WEDDINGCITY_FEEDBACK)
            );
        }

        public static function weddingcity_ot_custom_option_style() {

            $style = '';

            $style .= '#option-tree-header li a { color: #ffffff; }';

            $style .= '.hide-color-picker {display: block !important;}';

            $style .= '.weddingcity-notice{ padding-bottom: 10px; background: #ffffff; }';

            $style .= '.wp-picker-container input[type=text].wp-color-picker{ width: auto; }';

            $style .= '#option-tree-header li.theme_link { line-height: 31px; }';

            $style .= '#option-tree-header li.theme_link a{ margin-right: 15px; }';

            $style .= '#option-tree-header .theme_link.right { float: right; }';

            $style .= '#option-tree-header li a{ cursor: pointer; color: #ffffff; }#option-tree-header li a:hover{ color: yellow;  cursor: pointer; }';

            $style .= '#option-tree-header li a#rate_us{color: #333333;background: yellow;border-radius: 2px;padding: 2px 6px; cursor: pointer; }';

            print '<style>' . $style . '</style>';
        }

        public static function weddingcity_filter_ot_recognized_font_families($array, $field_id) {

            $array['helveticaneue'] = "'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif";

            ot_fetch_google_fonts(true, false);

            $ot_google_fonts = wp_list_pluck(get_theme_mod('ot_google_fonts', array()), 'family');

            $array = array_merge($array, $ot_google_fonts);

            if (ot_get_option('typekit_id')) {

                $typekit_fonts = trim(ot_get_option('typekit_fonts'), ' ');
                $typekit_fonts = explode(',', $typekit_fonts);
                $array = array_merge($array, $typekit_fonts);
            }

            foreach ($array as $font => $value) {
                $thb_font_array[$value] = $value;
            }

            return $thb_font_array;
        }

        public static function weddingcity_option_tree_value($class, $property, $value) {

            if (weddingcity_option($value) != '' && $class != '') {

                return sprintf('%1$s{ %2$s:%3$s; }',

                    // 1
                    $class,

                    // 2
                    $property,

                    // 3
                    weddingcity_option($value)
                );
            }

            return;
        }

        public static function weddingcity_option_tree_link_value($class, $color, $key) {

            if ($key == '' or $class == '' or $color == '') {
                return;
            }

            $_get_result = '';

            if (weddingcity_option($key)) {

                if (isset(weddingcity_option($key)['link'])) {
                    $_get_result .= sprintf('%1$s{ %2$s: %3$s; }', $class, $color, weddingcity_option($key)['link']);
                }
                if (isset(weddingcity_option($key)['hover'])) {
                    $_get_result .= sprintf('%1$s:hover{ %2$s: %3$s; }', $class, $color, weddingcity_option($key)['hover']);
                }
                if (isset(weddingcity_option($key)['active'])) {
                    $_get_result .= sprintf('%1$s:active{ %2$s: %3$s; }', $class, $color, weddingcity_option($key)['active']);
                }
                if (isset(weddingcity_option($key)['visited'])) {
                    $_get_result .= sprintf('%1$s:visited{ %2$s: %3$s; }', $class, $color, weddingcity_option($key)['visited']);
                }
                if (isset(weddingcity_option($key)['focus'])) {
                    $_get_result .= sprintf('%1$s:focus{ %2$s: %3$s; }', $class, $color, weddingcity_option($key)['focus']);
                }
                if (isset(weddingcity_option($key)['bg'])) {
                    $_get_result .= sprintf('%1$s{ background: %3$s; }', $class, $color, weddingcity_option($key)['bg']);
                }
                if (isset(weddingcity_option($key)['text'])) {
                    $_get_result .= sprintf('%1$s{ color: %3$s; }', $class, $color, weddingcity_option($key)['text']);
                }
                if (isset(weddingcity_option($key)['border'])) {
                    $_get_result .= sprintf('%1$s{ border-color: %3$s; }', $class, $color, weddingcity_option($key)['border']);
                }

                return $_get_result;
            }
        }

        public static function weddingcity_option_tree_typography_value($args) {

            $style = '';

            if (weddingcity_option($args) != '' && is_array(weddingcity_option($args))) {

                foreach (weddingcity_option($args) as $key => $value) {

                    if ($key === 'background-image' && $value != '') {

                        $style .= sprintf('%1$s:url(%2$s);', $key, $value);

                    } elseif ($key === 'font-color' && $value != '') {

                        $style .= sprintf('%1$s:%2$s;', esc_html('color'), $value);

                    } else {

                        if ($value != '') {

                            $style .= sprintf('%1$s:%2$s;', $key, $value);
                        }

                    }
                }
            }

            return $style;
        }

        public static function weddingcity_option_tree_stylesheet_print() {

            $style = '';

            $_data = apply_filters('wc_theme_options', array());

            /**
             *  Get Data
             */
            if (WeddingCity_Loader::array_condition($_data)) {

                $_color_customize = $_link_customize = $_typography_customize = array();

                foreach ($_data as $index => $index_value) {

                    foreach ($index_value as $key => $value) {

                        if (isset($value['type'])) {

                            if ($value['type'] == 'colorpicker-opacity') {

                                $_color_customize[] = $value;

                            } elseif ($value['type'] == 'link-color') {

                                $_link_customize[] = $value;

                            } elseif ($value['type'] == 'typography') {

                                $_typography_customize[] = $value;
                            }
                        }
                    }
                }

                /**
                 *  Color Setting.
                 */
                if (WeddingCity_Loader::array_condition($_color_customize)) {

                    foreach ($_color_customize as $index => $index_value) {

                        if (isset($index_value['object']['class'])) {

                            $style .= self::weddingcity_option_tree_value(

                                esc_attr($index_value['object']['class']),

                                esc_attr($index_value['object']['property']),

                                esc_attr($index_value['id'])
                            );
                        }
                    }
                }

                /**
                 *  Link Color Setting.
                 */
                if (WeddingCity_Loader::array_condition($_link_customize)) {

                    foreach ($_link_customize as $index => $index_value) {

                        $style .= self::weddingcity_option_tree_link_value(

                            esc_attr($index_value['object']['class']),

                            esc_attr($index_value['object']['property']),

                            esc_attr($index_value['id'])
                        );
                    }
                }

                /**
                 *  Typography Setting
                 */
                if (WeddingCity_Loader::array_condition($_typography_customize)) {

                    foreach ($_typography_customize as $index => $index_value) {

                        $style .=

                        sprintf('%1$s{ %2$s }',

                            // 1. Tag
                            esc_attr($index_value['object']['tag']),

                            // 2. values
                            self::weddingcity_option_tree_typography_value(esc_attr($index_value['id']))
                        );
                    }
                }
            }

            /**
             *  Custom Divider.
             */
            if (weddingcity_option('weddingcity_divider') != '') {

                $style .= sprintf('.divider-pattern { background: url(%1$s) no-repeat center; }', weddingcity_option('weddingcity_divider'));
            }

            /**
             *  Custom CSS
             */
            if (weddingcity_option('weddingcity_custom_css') != '') {

                $style .= preg_replace('/\s+/', ' ', weddingcity_option('weddingcity_custom_css'));
            }

            $target_css = 'weddingcity-parent-style';

            if (is_child_theme()) {

                $target_css = 'weddingcity-child-style';

            }

            wp_enqueue_style($target_css, get_template_directory_uri() . 'assets/css/theme-style.css');

            wp_add_inline_style($target_css, preg_replace('/\s+/', ' ', $style));
        }
    }

    /**
     *  Kicking this off by calling 'get_instance()' method
     */
    WeddingCity_Theme_Options_Interface::get_instance();
}

?>