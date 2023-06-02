<?php
$link_text = get_post_meta($post->ID, 'wcr-slider_link_text', true);
$link_url = get_post_meta($post->ID, 'wcr-slider_link_url', true);
?>
<table class="form-table" >
    <input type="hidden" name="wcr-slider-nonce" value="<?php echo wp_create_nonce("wcr-slider-nonce");?>">
    <tr>
        <th>
            <label for="wcr-slider_link_text">Link Text</label>
        </th>
    </tr>
    <td>
        <input type="text"  name="wcr-slider_link_text" id="wcr-slider_link_text" 
        value="<?php echo ( isset( $link_text ) ) ? esc_html( $link_text  ) : ''; ?>"
        style="width:70%; padding:10px; border: 1px solid #ddd; border-radius:10px;">
    </td>
    <tr>
        <th>
            <label for="wcr-slider_link_text">Link URL</label>
        </th>
    </tr>
    <td >
        <input type="text" name="wcr-slider_link_url" id="wcr-slider_link_url" 
        value="<?php echo ( isset( $link_url ) ) ? esc_url( $link_url ) : ''; ?>"
        style="width:70%; padding:10px; border: 1px solid #ddd; border-radius:10px;">
    </td>
</table>
