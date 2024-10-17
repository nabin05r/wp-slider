<!-- <h3><?php echo ( ! empty($content) ) ? esc_html($content) : esc_html( WPSlider_Settings::$options['wpslider_title'] ) ;?></h3> -->
<div class="wpslider alignfull <?php echo (isset( WPSlider_Settings::$options['wpslider_slider_style'] )) ? esc_attr( WPSlider_Settings::$options['wpslider_slider_style']) : 'style-1' ?>">
<?php
    $args = array(
        'post_type' => 'wpslider',
        'post_status' => 'publish',
        'post__in' => $id,
        'orderby' => $orderby  
    );
    $query = new WP_Query($args);
?>

<div class="your-class">
<?php if($query -> have_posts()){
    while($query->have_posts()){
        $query->the_post();
        $link_text = get_post_meta(get_the_ID(), 'wpslider_link_text', true);
        $link_url = get_post_meta(get_the_ID(), 'wpslider_link_url', true);
   ?>

  
  
    <div class="wps-container">
        <figure>
        
         <?php
         if(has_post_thumbnail()){
            the_post_thumbnail( 'full', array( 'class' => 'image-fluid' ) ); 
         }else{
            ?>
             <img src="<?php echo WPSLIDER_URL . '/assets/img/default.jpg'; ?>" alt="Placeholder" class="image-fluid wp-post-image">
            <?php
         }
            
          ?>
        </figure>
   
        <div class="slider-details-container">
            <div class="wrapper">
                <div class="slider-title">
                    <h2><?php the_title(); ?></h2>
                </div>
                <div class="slider-description">
                    <div class="subtitle"><?php the_content(); ?></div>
                    <a href="<?php echo isset($link_url) ? esc_url( $link_url) : ''; ?>" class="link"><?php echo isset($link_text) ? esc_html($link_text) : ''; ?></a>
                </div>
            </div>
        </div>
    </div>
  
  <?php 
    }
    wp_reset_postdata();
}
?>
</div> 
</div>
