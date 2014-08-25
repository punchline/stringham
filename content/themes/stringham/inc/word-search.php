<?php
add_action('init', 'pnch_register_wordsearch');
function pnch_register_wordsearch(){

	$args = array(
		'labels' 			 => array(
									'name' => 'Vocabulary Words',
									'singular_name' => 'Vocabulary Word'
								),
		'public' 			 => true,
		'show_in_nav_menus'	 => false,
		'show_in_admin_bar'  => false,
		'has_archive'		 => false,
		'taxonomies' 		 => array('quiz_category'),
		'supports' 			 => array('title', 'editor'),
		'rewrite'			 => array('slug'=>'vocabulary_word')
	);
	register_post_type('vocabulary_word', $args);
}