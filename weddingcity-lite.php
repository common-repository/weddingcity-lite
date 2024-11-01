<?php
/**
 * @wordpress-plugin
 * -----------------
 * Plugin Name:     WeddingCity Lite - Wedding Directory and Listing
 * Plugin URI:      https://wordpress.org/plugins/weddingcity-lite
 * Description:     WeddingCity Lite free WordPress plugin is a complete solution for creating a website wedding directory and wedding marketplace website. You can create a fully-responsive and beautiful wedding directoy website with this plugin without writing a single line of code. The plugin features an attractive and engaging layout that helps you keep your visitors engaged on the website. This plugin is lightweight, optimized for speed and helps your website load in fast and provides your visitors with the excellent user experience.
 * Version:         1.0.4
 * Author:          wp-organic
 * Author URI:      http://www.wporganic.com
 * Text Domain:     weddingcity-lite
 * Domain Path:     /languages
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 */

if (!defined('ABSPATH')) {exit;} /* Exit if accessed directly. */

error_reporting(E_ALL ^ E_NOTICE); // Set custom error reporting level

if (!defined('WEDDINGCITY_PLUGIN_URL')) {

    define('WEDDINGCITY_PLUGIN_URL', plugin_dir_url(__FILE__));}

if (!defined('WEDDINGCITY_PLUGIN_DIR')) {

    define('WEDDINGCITY_PLUGIN_DIR', plugin_dir_path(__FILE__));}

if (!defined('WEDDINGCITY_PLUGIN_IMAGE')) {

    define('WEDDINGCITY_PLUGIN_IMAGE', WEDDINGCITY_PLUGIN_URL . '/assets/images/');}

if (!defined('WEDDINGCITY_PLUGIN_CSS')) {

    define('WEDDINGCITY_PLUGIN_CSS', WEDDINGCITY_PLUGIN_URL . '/assets/css/');}

if (!defined('WEDDINGCITY_PLUGIN_LIBRARY')) {

    define('WEDDINGCITY_PLUGIN_LIBRARY', WEDDINGCITY_PLUGIN_URL . '/assets/library/');}

if (!defined('WEDDINGCITY_PLUGIN_JS')) {

    define('WEDDINGCITY_PLUGIN_JS', WEDDINGCITY_PLUGIN_URL . '/assets/js/');}

if (!defined('WEDDINGCITY_MINIFY')) {

    define('WEDDINGCITY_MINIFY', '.min');}

if (!defined('WEDDINGCITY_PLUGIN_DEV_ON')) {

    define('WEDDINGCITY_PLUGIN_DEV_ON', '1');}

if (!defined('WEDDINGCITY_PREFIX')) {

    define('WEDDINGCITY_PREFIX', esc_html('weddingcity'));}

if (!defined('WEDDINGCITY_FEEDBACK')) {

    define('WEDDINGCITY_FEEDBACK', esc_url('forms.gle/XMabh4Lzt8HFMADk8'));}

if (!defined('WEDDINGCITY_PLUGIN_VERSION')) {

    define('WEDDINGCITY_PLUGIN_VERSION', '1.0.4');}

if (!defined('WEDDINGCITY_BUY_NOW_BTN_ON')) {

    define('WEDDINGCITY_BUY_NOW_BTN_ON', '0');}

/**
 * WeddingCity - Plugin
 *
 * @package weddingcity
 * @since 1.0.0
 */

if (!class_exists('WeddingCity_Loader')) {

    /**
     * Customizer Initialization
     *
     * @since 1.0.0
     */

    class WeddingCity_Loader {

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

        public static function weddingcity_image_size(){

            add_image_size( 'weddingcity_user_100x100', absint('100'), absint('100'), true );

            add_image_size( 'weddingcity_user_40x40',   absint('40'),  absint('40'),  true );

            add_image_size( 'weddingcity_vendor_gallery_800x450', absint('800'), absint('450'), true );

            add_image_size( 'weddingcity_vendor_gallery_360x210', absint('360'), absint('210'), true );

            add_image_size( 'weddingcity_blog_360x260', absint('358'), absint('364'), true );

            /**
             *  Vendor Categories Image Crop 260 x 320
             */
            add_image_size( 'weddingcity_blog_260x320', absint('260'), absint('320'), true );
        }

        /**
         *  Constructor
         */
        public function __construct() {

            /**
             *  Required files
             */

            self::load_required_files();

            add_action('init', array($this, 'weddingcity_plugin_initialize'));

            add_action('admin_menu', array($this, 'weddingcity_stop_access_profile'));

            add_filter('body_class', array($this, 'weddingcity_plugin_body_classes'));

            add_action( 'after_setup_theme', array( $this, 'weddingcity_image_size' ) );
        }

        public static function weddingcity_remove_menus() {

            /**
             *  @link http://www.wprecipes.com/how-to-remove-menus-in-wordpress-dashboard/
             */

            global $menu;

            $restricted = array(

                __('Dashboard'),
                __('Posts'),
                __('Media'),
                __('Links'),
                __('Pages'),
                __('Appearance'),
                __('Tools'),
                __('Users'),
                __('Settings'),
                __('Comments'),
                __('Plugins'),
            );

            end($menu);

            while (prev($menu)) {

                $value = explode(' ', $menu[key($menu)][0]);

                if (in_array($value[0] != NULL ? $value[0] : "", $restricted)) {

                    unset($menu[key($menu)]);
                }
            }
        }

        public static function weddingcity_plugin_initialize() {

            /**
             *  Register Text Domain.
             */
            load_plugin_textdomain('weddingcity', false, dirname(plugin_basename(__FILE__)) . '/languages');

            /**
             *  Adminbar hide when couple or vendor is login.
             */
            if (is_user_logged_in() && class_exists('WeddingCity_User_Meta')) {

                if (WeddingCity_User::is_vendor() || WeddingCity_User::is_couple()) {

                    add_filter('show_admin_bar', '__return_false');
                }
            }
        }

        public static function weddingcity_plugin_body_classes($classes) {

            $classes[] = sprintf('weddingcity-plugin-version-%1$s', WEDDINGCITY_PLUGIN_VERSION);

            $classes[] = sanitize_html_class('weddingcity-nice-select');

            return $classes;
        }

        /**
         * [weddingcity_stop_access_profile description]
         *
         *  @permition : This function provided user role like : upload image on front side.
         *
         *  @link : https://stackoverflow.com/questions/38640533/wordpress-subscriber-role-user-cannot-upload-images-from-frontend
         *
         *  @link : https://developer.wordpress.org/reference/classes/wp_role/remove_cap/
         *
         *  @link : https://wordpress.stackexchange.com/questions/29000/disallow-user-from-editing-their-own-profile-information#answers-header
         *
         */
        public static function weddingcity_stop_access_profile() {

            if (current_user_can('subscriber')) {

                if (defined('IS_PROFILE_PAGE') && IS_PROFILE_PAGE === true) {

                    if (is_user_logged_in() && WeddingCity_User_Meta::is_vendor()) {

                        die(wp_redirect(WeddingCity_Vendor_Menu::profile_page()));
                    }

                    if (is_user_logged_in() && WeddingCity_User_Meta::is_couple()) {

                        die(wp_redirect(WeddingCity_Couple_Menu::profile_page()));
                    }
                }

                remove_menu_page('profile.php');

                remove_submenu_page('users.php', 'profile.php');

                if (current_user_can('subscriber')) {

                    add_filter('show_admin_bar', '__return_false');
                }
            }
        }

        public static function array_condition($args) {

            if (is_array($args) && count($args) >= absint('1') && !empty($args) && $args !== null) {

                return true;
            } else {

                return false;
            }
        }

        public static function weddingcity_admin_bar_render() {

            global $wp_admin_bar;

            /**
             *  Remove Edit Profile in Backend
             */
            if (current_user_can('subscriber')) {

                $wp_admin_bar->remove_menu('edit-profile', 'user-actions');
            }
        }

        public static function addSecretKey($query) {
            $query['secret'] = 'foo';
            return $query;
        }

        /**
         *  Required Files
         */
        public static function load_required_files() {

            /**
             *  WeddingCity Script & Styles
             */
            require_once WEDDINGCITY_PLUGIN_DIR . 'assets/weddingcity-scripts.php';

            /**
             *  Basic Functions
             */
            require_once WEDDINGCITY_PLUGIN_DIR . 'basic-functions/index.php';

            /**
             *  WeddingCity Core Class
             */
            foreach (glob(WEDDINGCITY_PLUGIN_DIR . 'core-class/*.php') as $_weddingcity_core_class_file) {

                require_once $_weddingcity_core_class_file;
            }

            /**
             *  WeddingCity Core
             */
            foreach (glob(WEDDINGCITY_PLUGIN_DIR . 'core/*/*.php') as $_weddingcity_core_files) {

                require_once $_weddingcity_core_files;
            }

            /**
             *  WeddingCity Parent Class Included.
             */
            foreach (glob(WEDDINGCITY_PLUGIN_DIR . 'parent-class/*.php') as $_weddingcity_core_files) {

                require_once $_weddingcity_core_files;
            }

            /**
             *  WeddingCity Modules
             */
            foreach (glob(WEDDINGCITY_PLUGIN_DIR . 'modules/*/*.php') as $_weddingcity_modules_files) {

                require_once $_weddingcity_modules_files;
            }

            /**
             *  WeddingCity Templates
             */
            foreach (glob(WEDDINGCITY_PLUGIN_DIR . 'templates/*/*.php') as $_weddingcity_template) {

                require_once $_weddingcity_template;
            }
        }
    }
}

/**
 *  Kicking this off by calling 'get_instance()' method
 */
WeddingCity_Loader::get_instance();

?>