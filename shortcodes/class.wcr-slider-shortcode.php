<?php

if (!class_exists('Wcr_Slider_Shortcode')) {
    class Wcr_Slider_Shortcode
    {
        function __construct()
        {
            add_shortcode('wcr_slider', array($this, 'add_shortcode'));
        }

        public function add_shortcode($atts = array(), $content = null, $tag = '')
        {
            $atts = array_change_key_case((array) $atts, CASE_LOWER);

            $param_default = array('id' => '', 'orderby' => 'date');
            extract(shortcode_atts($param_default, $atts, $tag));

            if (!empty($id)) {
                $id = array_map('absint', explode(',', $id));
            }
            ob_start();
            require(WCR_SLIDER_PATH . '/views/wcr-slider-shortcode.php');
            wp_enqueue_script('wcr-slider-main');
            wp_enqueue_script('wcr-slider-options');
            wp_enqueue_style('css');
            return ob_get_clean();
        }

    }
}