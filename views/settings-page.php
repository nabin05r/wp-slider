 <div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <?php
        $active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'main_options';
    ?>
    <h2 class="nav-tab-wrapper">
        <a href="?page=wpslider_admin&tab=main_options" class="nav-tab <?php echo $active_tab == 'main_options' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Main Options', 'wpslider'); ?></a>
        <a href="?page=wpslider_admin&tab=additional_options" class="nav-tab <?php echo $active_tab == 'additional_options' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Additional Options', 'wpslider');?></a>
    </h2>
    <form action="options.php" method="post">
        <?php
            settings_fields( 'wpslider_group' );
            if($active_tab == 'main_options'){
                do_settings_sections( 'wpslider_page1' );
            }
            if($active_tab == 'additional_options'){
                do_settings_sections( 'wpslider_page2' ); 
            }
            // do_settings_sections( 'wpslider_page3' );
            submit_button(esc_html__('Save Settings', 'wpslider'));
            
        ?>
    </form>
 </div>