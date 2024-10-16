<?php
if( ! class_exists( 'WPSlider_Shortcode' ) ){

    class WPSlider_Shorcode{
        
        public function __construct(){
            add_shortcode('wpslider', array( $this, 'add_shortcode') );
        }

        public function add_shortcode( $attr = array(), $content = null, $tag = '' ){
            $attr = array_change_key_case( ( array ) $attr, CASE_LOWER );
            extract( shortcode_atts( 
                array(
                    'id' => '',
                    'orderby' => 'date'
                ),
                $attr,
                $tag
            ));

            if( ! empty( $id ) ){
                $id = array_map( 'absint', explode( ',', $id) );
            }

            ob_start();
            require( WPSLIDER_PATH . 'views/wpslider-shortcode.php');
            wp_enqueue_script( 'wpslider-slick.min.js' );
            wp_enqueue_script( 'wpslider-slick.js' );
            // wp_enqueue_script( 'wpslider-main-wpslider.js' );
            wp_enqueue_style( 'wpslider-slick-theme.css' );
            wp_enqueue_style( 'wpslider-slick.css' );
            wp_enqueue_style( 'wpslider-custom.css' );
            inject_script();
            return ob_get_clean();
        }

    }

}