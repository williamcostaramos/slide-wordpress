<h3><?php echo !empty($content)? $content : Wcr_Slide_settings::$options['wcr_slider_title'];  ?></h3>
<div class="wcr-slider flexslider">
    <ul class="slides">
        <?php 
            $filter = array(
                'post_type'=>'wcr-slider',
                'post_status' => 'publish',
                'post__in' => $id,
            'orderby' => $orderby);

            $query = new WP_Query($filter);
            if($query->have_posts()):
                while($query->have_posts()):
                    $query->the_post();

                    $button_text = get_post_meta(get_the_ID(),'wcr-slider_link_text',true);
                    $button_url = get_post_meta(get_the_ID(),'wcr-slider_link_url',true);
                
        ?>
        <li>
            <?php  the_post_thumbnail('full', array('class'=>'img-fluid'));?>
            <div class="wcrs-container">
                <div class="wrapper">
                    <div class="slider-title">
                        <h2><?php the_title()?></h2>
                        
                    </div>
                    <div class="slider-description">
                        <div class="subtitle"><?php the_content();?></div>
                        <a href="<?php echo esc_attr($button_url);?>" class="link"><?php echo esc_html($button_text); ?></a>
                    </div>
                </div>
            </div>
        </li>
        <?php endwhile;
        wp_reset_postdata();
        endif;?>
    </ul>
</div>