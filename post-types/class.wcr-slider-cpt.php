<?php

if (!class_exists('Wcr_Slide_Post_Type')) {
    class Wcr_Slide_Post_Type
    {
        function __construct()
        {
            add_action('init', array($this, 'create_post_type'));
            add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
            add_action('save_post', array($this, 'save_post'), 10, 2);
            add_filter('manage_wcr-slider_posts_columns', array($this,'wcr_slider_cpt_columns'));
            add_action('manage_wcr-slider_posts_custom_column', array($this,'wcr_slider_custom_columns'),10,2);

        }
        public function create_post_type()
        {
            $options = array(
                'label' => 'Slider',
                'description' => 'Sliders',
                'labels' => array('name' => 'Sliders', 'singular_name' => 'Slider'),
                'public' => true,
                'supports' => array('title', 'editor', 'thumbnail'),
                'hierachical' => false,
                'show_ui' => true,
                'show_in_menu' => false,
                'menu_postion' => 5,
                'show_in_admin_bar' => true,
                'show_in_nav_menu' => true,
                'can_export' => true,
                'has_archive' => false,
                'exclude_from_search' => false,
                'publicly_queryable' => true,
                'show_in_rest' => true,
                'menu_icon' => 'dashicons-images-alt2'
            );
            register_post_type('wcr-slider', $options);
        }

        public function wcr_slider_cpt_columns($columns){
            $columns['wcr-slider_link_text']= esc_html('Link Text', 'wcr-slider');
            $columns['wcr-slider_link_url']= esc_html('Link URL', 'wcr-slider');
            return $columns;

        }
        public function wcr_slider_custom_columns($column, $post_id){
            switch ($column) {
                case 'wcr-slider_link_text':
                    
                    echo get_post_meta($post_id, 'wcr-slider_link_text', true);
                    break;
                case 'wcr-slider_link_url':
                    echo get_post_meta($post_id, 'wcr-slider_link_url', true);
                   break;
            }
        }
        public function add_meta_boxes()
        {
            add_meta_box(
                'wcr_slider_meta_box',
                'Link Options',
                array($this, 'add_inner_meta_boxes'),
                'wcr-slider',
                'normal',
                'high'
            );
        }
        public function add_inner_meta_boxes($post)
        {
            require_once(WCR_SLIDER_PATH . 'views/wcr-slider-meta-box.php');

        }
        public function save_post($post_id)
        {
            if (
                isset($_POST['wcr-slider-nonce']) &&
                !wp_verify_nonce($_POST['wcr-slider-nonce'], 'wcr-slider-nonce') &&
                defined('DOING_AUTOSAVE') && DOING_AUTOSAVE
            ) {
                return;
            }
            if (isset($_POST['post_type']) && $_POST['post_type'] == 'wcr-slider') {
                if (!current_user_can('edit_page', $post_id) && !current_user_can('edit_post', $post_id)) {
                    return;
                }
            }
            if (isset($_POST['action']) && $_POST['action'] == 'editpost') {
                $old_link_text = get_post_meta($post_id, 'wcr-slider_link_text', true);
                $new_link_text = $_POST['wcr-slider_link_text'];
                $old_link_url = get_post_meta($post_id, 'wcr-slider_link_url', true);
                $new_link_url = $_POST['wcr-slider_link_url'];
                if (empty($new_link_text)) {
                    update_post_meta($post_id, 'wcr-slider_link_text', esc_html__('add some text', 'wcr-slider'));
                } else {
                    update_post_meta($post_id, 'wcr-slider_link_text', sanitize_text_field($new_link_text), $old_link_text);
                }
                if (empty($new_link_url)) {
                    update_post_meta($post_id, 'wcr-slider_link_url', '#');
                } else {
                    update_post_meta($post_id, 'wcr-slider_link_url', esc_url_raw($new_link_url), $old_link_url);
                }

            }
        }
    }
}