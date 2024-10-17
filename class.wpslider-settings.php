<?php

if( ! class_exists( 'WPSlider_Settings' ) ){
    class WPSlider_Settings{

        public static $options;

        public function __construct(){
            self::$options = get_option( 'wpslider_options' ); 
            add_action( 'admin_init', array( $this, 'admin_init' ) );
        }

        public function admin_init(){
            
            register_setting( 'wpslider_group', 'wpslider_options', array( $this, 'validate_register_setting') );

            add_settings_section(
                'wpslider_main_section',
                esc_html__('How does it work?', 'wpslider'),
                null,
                'wpslider_page1'
            );

            add_settings_section(
                'wpslider_second_section',
                esc_html__('Other Plugin Options ', 'wpslider'),
                null,
                'wpslider_page2'
            );

            add_settings_field(
                'wpslider_shortcode',
                esc_html__('Shortcode', 'wpslider'),
                array( $this, 'wpslider_shortcode_callback' ),
                'wpslider_page1',
                'wpslider_main_section',
            ); 

            // add_settings_field(
            //     'wpslider_title',
            //     esc_html__('Slider Title', 'wpslider'),
            //     array( $this, 'wpslider_title_callback' ),
            //     'wpslider_page2',
            //     'wpslider_second_section'
            // );

            add_settings_field(
                'wpslider_display_bullets',
                esc_html__('Display Bullets', 'wpslider'),
                array( $this, 'wpslider_display_bullets_callback' ),
                'wpslider_page2',
                'wpslider_second_section'
            );

            add_settings_field(
                'wpslider_slider_style',
                esc_html__('Slider Style', 'wpslider'),
                array( $this, 'wpslider_slider_style_callback' ),
                'wpslider_page2',
                'wpslider_second_section'
            );

        }

        public function wpslider_shortcode_callback(){
            ?>
                <span><?php esc_html_e("Use this shortcode [wpslider] to display the slider in post/page/widget" ,'wpslider')?></span>
            <?php
        }
        /**
         *  public function wpslider_title_callback(){
            ?>
                <input
                 type="text"
                 name="wpslider_options[wpslider_title]"
                 id="wpslider_title"
                 value="<?php echo isset( self::$options['wpslider_title'] ) ? esc_attr( self::$options['wpslider_title'] ) : ''; ?>"
                >
            <?php
        }
         */
       

        public function wpslider_display_bullets_callback(){
            ?>
                <input
                type="checkbox"
                name="wpslider_options[wpslider_display_bullets]"
                id="wpslider_display_bullets"
                value= "1"
                <?php
                    if( isset( self::$options[ 'wpslider_display_bullets' ]) ){
                        checked( 1, self::$options['wpslider_display_bullets'], true );
                    }
                ?>
                >
                <label for="wpslider_display_bullets"><?php esc_html_e('Whether to display bullets or not', 'wpslider');?></label>
            <?php
        }

        public function wpslider_slider_style_callback(){
            ?>
                <select name="wpslider_options[wpslider_slider_style]" id="wpslider_slider_style">
                    <option
                     value="style-1"
                     <?php echo isset( self::$options['wpslider_slider_style'] ) ? selected( "style-1", self::$options['wpslider_slider_style'], true ) : '';?>
                     >
                     <?php esc_html_e('Style 1', 'wpslider'); ?>
                    </option>
                    <option
                     value="style-2"
                     <?php echo isset( self::$options['wpslider_slider_style'] ) ? selected( "style-2", self::$options['wpslider_slider_style'], true) : '';?>
                     ><?php esc_html_e('Style 2', 'wpslider'); ?>
                    </option>
                </select>
            <?php
        }

        public function validate_register_setting( $input ){
            $new_input = array();
            foreach( $input as $key => $value ){
                // $new_input[$key] = sanitize_text_field( $value );
                switch($key){

                    // case'wpslider_title':
                    //     if( empty( $value)){
                    //         add_settings_error('wpslider_options', 'wpslider_message', esc_html__('The title field cannot be empty', 'wpslider'), 'warning');
                    //         $value = esc_html__('Please type some Text', 'wpslider');
                    //     }
                    //     $new_input[$key] = sanitize_text_field( $value );
                    //     break;
    
                    default:
                        $new_input[$key] = sanitize_text_field( $value );
                        break;
                }
            }
            
            return $new_input;
        }

    }
}
