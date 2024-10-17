<?php
/**
 * Plugin Name: WPSlider
 * Plugin URI: https://nabinmagar.com
 * Description: Simple, Elegant, Beautiful way to show the slider in your website.
 * Version: 1.0.0
 * Requires at least: 6.1
 * Php Version: 7.2
 * Author: Nabin Gharti Magar
 * Author URI: https://nabinmagar.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * Text Domain: wpslider
 * Domain Path: /languages
 */

/*
WPSlider is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

WPSlider is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with WPSlider. If not, see {URI to Plugin License}.
*/

 if( ! defined( 'ABSPATH' )){
    exit;
 }

 if( !class_exists( 'WPSlider' ) ){

    class WPSlider{

        function __construct(){
            $this->define_constants();

            $this->load_texdomain();

            require_once( WPSLIDER_PATH . 'functions/functions.php');

            add_action( 'admin_menu', array( $this, 'add_menu') );
            
            require_once( WPSLIDER_PATH . '/post-types/class.wp-slider-cpt.php' );
            $wpslider_cpt = new WPSlider_Post_Type();

            require_once( WPSLIDER_PATH . 'class.wpslider-settings.php' );
            $wpslider_settings = new WPSlider_Settings();

            require_once( WPSLIDER_PATH . '/shortcodes/class.wpslider-shortcode.php');
            $wpslider_shortcode = new WPSlider_Shortcode();

            add_action( 'wp_enqueue_scripts', array($this, 'register_scripts') );

            add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );
        }
        
        public function define_constants(){
            define( 'WPSLIDER_PATH', plugin_dir_path( __FILE__ ) );
            define( 'WPSLIDER_URL', plugin_dir_url( __FILE__ ) );
            define( 'WPSLIDER_VERSION', '1.0.0' );
        }

        public static function activate(){
            update_option('rewrite_rules', '');
        }

        public static function deactivate(){
            flush_rewrite_rules();
            unregister_post_type( 'wpslider' );
        }

        public static function uninstall(){
            delete_option('wpslider-options');
            $posts = get_posts(
                array(
                    'post _type'=> 'wpslider',
                    'number_posts' => -1,
                    'post_status' => 'any'
                )
            );
            foreach($posts as $post){
                wp_delete_post($post->ID, true);
            }
        }

        public function load_texdomain(){
            load_plugin_textdomain('wpslider', false, dirname(plugin_basename(__FILE__)) . '/languages' );
        }

        public function add_menu(){
            add_menu_page(
                'WPSlider Options',
                esc_html__('WPSlider', 'wpslider'),
                'manage_options',
                'wpslider_admin',
                array( $this, 'wpslider_settings_page' ),
                'dashicons-images-alt2',
                
            );

            add_submenu_page(
                'wpslider_admin',
                esc_html__('Managae Slide', 'wpslider'),
                'Manage Slide',
                'manage_options',
                'edit.php?post_type=wpslider',
            );

            add_submenu_page(
                'wpslider_admin',
                esc_html__('Add New Slide', 'wpslider'),
                'Add New Slide',
                'manage_options',
                'post-new.php?post_type=wpslider',
            );
        }

        public function wpslider_settings_page(){
            if( ! current_user_can('manage_options') ){
                return; 
            }
            if( isset( $_GET['settings-updated'] ) ){
                add_settings_error('wpslider_options', 'wpslider_message', esc_html__('Saved Successfully', 'wpslider'), 'success' );
            }
            settings_errors( 'wpslider_options' );
            require( WPSLIDER_PATH . 'views/settings-page.php' );
        }

        public function register_scripts(){
            wp_register_script( 'wpslider-slick.min.js', WPSLIDER_URL . 'vendor/wpslider/slick.min.js', array('jquery'), WPSLIDER_VERSION, true  );
            wp_register_script( 'wpslider-slick.js', WPSLIDER_URL . 'vendor/wpslider/slick.js', array('jquery'), WPSLIDER_VERSION, true  );
            
            wp_register_style( 'wpslider-slick-theme.css', WPSLIDER_URL . 'vendor/wpslider/slick-theme.css', array(), WPSLIDER_VERSION, 'all');
            wp_register_style( 'wpslider-slick.css', WPSLIDER_URL . 'vendor/wpslider/slick.css', array(), WPSLIDER_VERSION, 'all');
            wp_register_style( 'wpslider-custom.css', WPSLIDER_URL . 'assets/css/wpslider-custom.css', array(), WPSLIDER_VERSION, 'all');
        }

        public function register_admin_scripts(){
            global $typenow;
            if( $typenow == 'wpslider'){
                wp_enqueue_style( 'wpslider-admin.css', WPSLIDER_URL . 'assets/css/admin.css', array(), WPSLIDER_VERSION, 'all');
            }
        }

    }

 }

 if( class_exists( 'WPSlider' ) ){
    register_activation_hook( __FILE__, array( 'WPSLIDER', 'activate'));
    register_deactivation_hook( __FILE__, array( 'WPSLIDER', 'deactivate'));
    register_uninstall_hook( __FILE__, array( 'WPSLIDER', 'uninstall'));
    $wpslider = new WPSlider();
   
 }
