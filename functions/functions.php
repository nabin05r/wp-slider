<?php

if( !function_exists( 'inject_script ')){
    function inject_script(){
        $wpslider_bullets =  isset( WPSlider_Settings::$options['wpslider_display_bullets']) && WPSlider_Settings::$options['wpslider_display_bullets'] == 1 ? true : false;
        $wpslider_autoplay =  isset( WPSlider_Settings::$options['wpslider_display_autoplay']) && WPSlider_Settings::$options['wpslider_display_autoplay'] == 1 ? true : false;                
        wp_enqueue_script( 'wpslider-main-wpslider.js', WPSLIDER_URL . 'vendor/wpslider/wpslider.js', array('jquery'), WPSLIDER_VERSION, true  );
        wp_localize_script(
            'wpslider-main-wpslider.js',
                'wpslider_object_inject',
                array(
                    'dots' => $wpslider_bullets,
                    'autoplay' => $wpslider_autoplay
                ));
    }
}