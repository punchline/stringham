<?php
/*
Plugin Name: Learning Record Store (LRS)
Description: Integrated learning record store that allows you to store and report on Tin-Can statements.
Author: Version 1.0 | <a href="http://www.learndash.com">LearnDash</a>
*/

function mt_add_pages() {
    
   
   
    add_menu_page('Learning Record Store', 'Record Store', 5, __FILE__, 'mt_toplevel_page');
}

function mt_toplevel_page() {
    echo '
    <div class="wrap">
      <h2>Learning Record Store</h2>
      <iframe src="http://waxlrs.com" width="1240" height="660"></iframe>
    </div>
    ';
}

add_action('admin_menu', 'mt_add_pages');

?>
