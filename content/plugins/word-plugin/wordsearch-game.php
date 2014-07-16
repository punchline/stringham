<?php
/*
 * Plugin Name: Wordsearch Game
 * Plugin URI: http://codecanyon.net/user/sney2002/portfolio
 * Description: Allows users to create wordsearch posters.
 * Version: 1.0
 * Author: Jhonatan Salguero Villa
 * Author URI: http://www.novatoz.com/
 * 
 */

define('WORDSEARCH_GAME_PATH', dirname(__FILE__));

load_plugin_textdomain( 'wordsearch_game', false, basename( dirname( __FILE__ ) ) . '/languages' );
//register_activation_hook(__FILE__, 'wordsearch_game_mark_as_activation');
require_once WORDSEARCH_GAME_PATH . '/include/functions.php';
require_once WORDSEARCH_GAME_PATH . '/include/settings.php';
require_once WORDSEARCH_GAME_PATH . '/include/shortcode.php';
