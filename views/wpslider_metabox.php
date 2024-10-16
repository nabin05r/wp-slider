<?php
    $link_text = get_post_meta($post->ID, 'wpslider_link_text', true);
    $link_url = get_post_meta($post->ID, 'wpslider_link_url', true);
?>

<table class="form-table wpslider-metabox">
    <input type="hidden" name="wpslider_nonce" value="<?php echo wp_create_nonce(  'wpslider_nonce' ); ?>">
    <tr>
        <th>
            <label for="wpslider_link_text"><?php esc_html_e('Link Text', 'wpslider') ?></label>
        </th>
        <td>
            <input
                type="text",
                name="wpslider_link_text",
                id="wpslider_link_text",
                class="regular-text link-text",
                value="<?php echo isset( $link_text ) ? esc_attr( $link_text ) : esc_html_e( 'Add Text' ); ?>",
                required
             >
        </td>
    </tr>

    <tr>
        <th>
            <label for="wpslider_link_url"><?php esc_html_e('Link URL', 'wpslider');?></label>
        </th>
        <td>
            <input
                type="url",
                name="wpslider_link_url",
                id="wpslider_link_url",
                class="regular-text link-url",
                value="<?php echo isset( $link_url ) ? esc_url( $link_url ) : '#' ; ?>",
                required
             >
        </td>
    </tr>
</table>