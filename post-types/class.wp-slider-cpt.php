<?php
if( ! class_exists( 'WPSlider_Post_Type' )){

    class WPSlider_Post_Type{

        public function __construct(){
           add_action( 'init', array( $this, 'create_post_type' ) ); 
           add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
           add_action( 'save_post', array( $this, 'save_post'), 10, 2 );
           add_filter( 'manage_wpslider_posts_columns', array( $this, 'wpslider_cpt_columns' ) );
           add_action( 'manage_wpslider_posts_custom_column', array( $this, 'wpslider_custom_columns'), 10, 2 );
           add_filter( 'manage_edit-wpslider_sortable_columns', array( $this, 'wpslider_sortable_columns' ) );
        }

        public function create_post_type(){
            register_post_type( 'wpslider',
             array( 
                'label' => esc_html__('WPSlider', 'wpslider'),
                'description' => esc_html__('WPSlider', 'wpslider'),
                'labels' => array(
                    'name' => esc_html__('WPSlider', 'wpslider'),
                    'singular_name' => esc_html__('WPSlider', 'wpslider'),
                    'add_new' => esc_html__('Add New Slider', 'wpslider'),
                ),
                'public' => true,
                'supports' => array( 'title', 'editor', 'thumbnail' ),
                'hierarchical' => false,
                'show_ui' => true,
                'show_in_menu' => true,
                'menu_position' => 5,
                'show_in_admin_bar' => true,
                'show_in_nav_menus' => true,
                'can_export' => true,
                'has_archive' => false,
                'show_in_rest' => true,
                'menu_icon' => 'dashicons-images-alt2',
                // 'taxonomies' => array( 'category' )       
            ) );
           
        }

        public function wpslider_cpt_columns( $columns ){
            $columns['wpslider_link_text'] = esc_html__( 'Link Text', 'wpslider');
            $columns['wpslider_link_url'] = esc_html__( 'Link URL', 'wpslider' );
            return $columns;
        }

        public function wpslider_custom_columns( $column, $post_id){
            switch( $column ){
                case 'wpslider_link_text' :
                   echo esc_html( get_post_meta( $post_id, 'wpslider_link_text', true ) ); 
                   break;
                case 'wpslider_link_url' :
                   echo esc_url (get_post_meta( $post_id, 'wpslider_link_url', true ) );
                   break;
            }
        }

        public function wpslider_sortable_columns( $column ){
            $column['wpslider_link_text'] = esc_html__( 'wpslider_link_text', 'wpslider' );
            return $column; 
        }

        public function add_meta_boxes(){
            add_meta_box(
                'wpslider_metabox',
                __('Link Options', 'wpslider'),
                array( $this , 'add_inner_metaboxes'),
                'wpslider',
                'normal',
                'high'
            );
        }

        public function add_inner_metaboxes( $post ){
            require_once( WPSLIDER_PATH . 'views/wpslider_metabox.php' );
        }

        public function save_post( $post_id ){
            if( isset( $_POST['wpslider_nonce '] ) ){
                if( ! wp_verify_nonce( $_POST['wpslider_nonce'], 'wpslider_nonce') ){
                    return;
                }
            }

            if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE){
                return;
            }

            if( isset( $_POST['post_type'] ) && $_POST['post_type'] == 'wpslider' ){
                if( ! current_user_can( 'edit_page', $post_id) ){
                    return;
                }elseif( ! current_user_can( 'edit_post', $post_id ) ){
                    return;
                }
            }

            if( isset( $_POST['action'] ) && $_POST['action'] == 'editpost' ){
           
                $old_link_text = get_post_meta( $post_id, 'wpslider_link_text', true );
                $new_link_text = $_POST[ 'wpslider_link_text' ];
                $old_link_url = get_post_meta( $post_id, 'wpslider_link_url', true );
                $new_link_url = $_POST[ 'wpslider_link_url' ];

                if( empty( $new_link_text ) ){
                    update_post_meta($post_id, 'wpslider_link_text', __('Add some text', 'wpslider') );
                }else{
                    update_post_meta($post_id, 'wpslider_link_text', sanitize_text_field( $new_link_text, $old_link_text ) );
                }
                if( empty( $new_link_url ) ){
                    update_post_meta($post_id, 'wpslider_link_url', '#');
                }else{
                    update_post_meta($post_id, 'wpslider_link_url', sanitize_text_field( $new_link_url, $old_link_url ) );
                }
                
            }
        }

    }

}
 