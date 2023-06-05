<?php

/*
 * Plugin Name: WCR Slider
 * Plugin URI: https://www.wordpress.org/wcr-slider
 * Description: Slide Show 
 * Version: 1.0
 * Author: William Ramos
 * Author URI: https://williamramos.com.br
 * License: GPL v2 later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wcr-slider
 * Domain Path: /languages
 */
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Wcr_Slider')) {
    class Wcr_Slider
    {
        function __construct()
        {
            $this->define_constants();
            
            require_once(WCR_SLIDER_PATH . '/post-types/class.wcr-slider-cpt.php');
            require_once(WCR_SLIDER_PATH . 'class.wcr-slider-setting.php');
            require_once(WCR_SLIDER_PATH . '/shortcodes/class.wcr-slider-shortcode.php');

            add_action('admin_menu', array($this, 'add_menu'));
            $wcr_slider_post_type = new Wcr_Slide_Post_Type();
            $wcr_slider_settings = new Wcr_Slide_settings();
            $wcr_slider_shortcode = new Wcr_Slider_Shortcode();
            add_action('wp_enqueue_scripts', array($this, 'register_scripts'),999);

        }

        public function define_constants()
        {
            define('WCR_SLIDER_PATH', plugin_dir_path(__FILE__));
            define('WCR_SLIDER_URL', plugin_dir_url(__FILE__));
            define('WCR_SLIDER_VERSION', '1.0.0');
        }
        public function add_menu()
        {
            add_menu_page(
                'WCR Slider Options',
                'WCR Slider',
                'manage_options',
                'wcr_slider_admin',
                array($this, 'wcr_slider_settings_page'),
                'dashicons-images-alt2'
            );

            add_submenu_page(
                'wcr_slider_admin',
                'Manage Slides',
                'Manage Slides',
                'manage_options',
                'edit.php?post_type=wcr-slider',
                null,
                null
            );
            add_submenu_page(
                'wcr_slider_admin',
                'Add New Slide',
                'Add New Slide',
                'manage_options',
                'post-new.php?post_type=wcr-slider',
                null,
                null
            );
        }
        public function wcr_slider_settings_page()
        {
            if(!current_user_can('manage_options')){
                return;
            }
            if(isset($_GET['settings-updated'])){
                add_settings_error('wcr_slider_options','wcr_slider_messager', 'Settings Saved', 'success');
            }
            settings_errors('wcr_slider_options');
            require(WCR_SLIDER_PATH . 'views/settings-page.php');
        }
        public static function activate()
        {
            update_option('rewite_rules', '');
        }
        public static function deactivate()
        {
            flush_rewrite_rules();
            unregister_post_type('wcr-slider');
        }
        public static function uninstall()
        {
        }
        public function register_scripts(){
            wp_register_script( 'wcr-slider-main', WCR_SLIDER_URL .'vendor/flexslider/jquery.flexslider-min.js',array('jquery'),WCR_SLIDER_VERSION, true );
            wp_register_script( 'wcr-slider-options', WCR_SLIDER_URL .'vendor/flexslider/flexslider.js',array('wcr-slider-main'), WCR_SLIDER_VERSION,true );
            wp_register_style(  'css', WCR_SLIDER_URL .'vendor/flexslider/flexslider.css');
            wp_register_style(  'frontend', WCR_SLIDER_URL .'assets/css/frontend.css');
        }
    }
}


if (class_exists('Wcr_slider')) {
    register_activation_hook(__FILE__, array('Wcr_Slider', 'activate'));
    register_deactivation_hook(__FILE__, array('Wcr_Slider', 'deactivate'));
    register_uninstall_hook(__FILE__, array('Wcr_Slider', 'deactivate'));
    $wcr_slider = new Wcr_Slider();
}