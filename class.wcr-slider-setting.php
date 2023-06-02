<?php
if (!class_exists('Wcr_Slide_settings')) {
    class Wcr_Slide_settings
    {
        public static $options;
        function __construct(){
            self::$options = get_option('wcr_slider_options');
            add_action('admin_init',array($this, 'admin_init') );
        }
        public function admin_init(){
            register_setting('wcr_slider_options','wcr_slider_options', array( $this, 'wcr_slider_validate' ) );
            add_settings_section(
                'wcr_slider_main_section',
                'How does it work?',
                null,
                'wcr_slider_page1'
            );

          
            add_settings_field(
                'wcr_slider_shortcode',
                'Shortcode',
                array($this, 'wcr_slider_shortcode_callback'),
                'wcr_slider_page1',
                'wcr_slider_main_section'
            );

            add_settings_section(
                'wcr_slider_second_section',
                'Other Plugin Options',
                null,
                'wcr_slider_page2'
            );

            add_settings_field(
                'wcr_slider_title',
                'Slide Title',
                array($this, 'wcr_slider_title_callback'),
                'wcr_slider_page2',
                'wcr_slider_second_section'
            );
            add_settings_field(
                'wcr_slider_bullets',
                'display Bullets',
                array($this, 'wcr_slider_bullets_callback'),
                'wcr_slider_page2',
                'wcr_slider_second_section'
            );

            add_settings_field(
                'wcr_slider_style',
                'Style',
                array($this, 'wcr_slider_style_callback'),
                'wcr_slider_page2',
                'wcr_slider_second_section'
            );
        }
        public function wcr_slider_shortcode_callback(){
            echo "<span>Use the Shortcode [wcr_slider] to display the slider in any page/post/widget</span>";
        }

        public function wcr_slider_title_callback(){
            ?>
            <input 
            type="text" 
            style="padding:5px; min-width: 100px;"
            name="wcr_slider_options[wcr_slider_title]" 
            id="wcr_slider_title" 
            value="<?php echo isset(self::$options['wcr_slider_title'])? esc_html(self::$options['wcr_slider_title']): '';?>">
            <?php
        }

        public function wcr_slider_bullets_callback(){
            ?>
            <input 
            type="checkbox" 
            name="wcr_slider_options[wcr_slider_bullets]" 
            id="wcr_slider_bullets" 
            value="1"
            <?php
            if(isset(self::$options['wcr_slider_bullets'])){
                checked("1",self::$options['wcr_slider_bullets'], true);
            }
            ?>
            >
            <label for="wcr_slider_bullets">Whether to display bullets or not</label>
            <?php
        }

        public function wcr_slider_style_callback(){
            ?>
            <select name="wcr_slider_options[wcr_slider_style]" id="wcr_slider_style" style="padding:5px; min-width: 100px;">
                <option style="padding:10px; min-width: 100px;" value="style-1" <?php echo isset(self::$options['wcr_slider_style']) ? selected('style-1',self::$options['wcr_slider_style'], true) :'';?>>style-1</option>
                <option style="padding:10px; min-width: 100px;" value="style-2" <?php echo isset(self::$options['wcr_slider_style']) ? selected('style-2',self::$options['wcr_slider_style'], true) :'';?>>style-2</option>
            </select>
            <?php
        }

        public function wcr_slider_validate( $input ){
            $new_input = array();
            foreach( $input as $key => $value ){
                switch ($key){
                    case 'wcr_slider_title':
                        if( empty( $value )){
                            add_settings_error( 'wcr_slider_options', 'wcr_slider_messager', esc_html( 'The title field can not be left empty'), 'error' );
                            $value = esc_html('Please, type some text');
                        }
                        $new_input[$key] = sanitize_text_field( $value );
                    break;
                    default:
                        $new_input[$key] = sanitize_text_field( $value );
                    break;
                }
            }
            return $new_input;
        }
     
    }
}