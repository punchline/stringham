<?php

class WordsearchGameCreator {

    public function __construct()
    {
        $this->errors = new WP_Error();

        $this->success_message = '';

        add_action('wp_enqueue_scripts', array($this, 'enqueue_style'));
        add_shortcode('wordsearch_game', array($this, 'insert_shortcode_content'));
    }

    public function enqueue_style()
    {
        wp_enqueue_style( 'wsgc-style', $this->get_asset_url('style/all.css') );
    }

    public function insert_shortcode_content($attrs, $content)
    {
        $this->get_shortcode_options($attrs, $content);

        if ( $this->need_registration === 'yes' && !is_user_logged_in() )
            return '<p class="wordsearch-game-creator error">' . 
                    __('Please register to play this game', 'wordsearch_game') . '</p>';

        $this->enqueue_scripts();
        $content = strip_tags($content);
        
        return "<script type='text/word' id='wordlist'>{$content}</script>".
                "<wordsearch></wordsearch>";
    }

    private function get_shortcode_options($attrs, $content) {
        extract(shortcode_atts(array(
            'width'    => '400',
            'height' => '600',
        ), $attrs));

        $this->width = $width;
        $this->height = $height;
    }

    private function enqueue_scripts()
    {
        global $is_IE;

        if ($is_IE) {
            $this->include_filereader_polyfill();
        }

        // poster generator
        wp_register_script('requirejs', $this->get_asset_url('build/vendor/require.min.js'));
        wp_enqueue_script('wsgc-main-script', $this->get_asset_url('build/app.js'), array('requirejs'));
        
        wp_localize_script( 'wsgc-main-script', 'wordsearchGameCreator', array(
            'baseUrl' => $this->get_asset_url('build'),
        ));
    }

    private function include_filereader_polyfill() {
        wp_enqueue_script('flashcanvas', $this->get_asset_url('ie/flashcanvas.js'));
    }
    
    private function get_asset_url($path)
    {
        return plugins_url($path, dirname(__FILE__));
    }
}

new WordsearchGameCreator;