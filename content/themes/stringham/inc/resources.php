<?php 
	
	// Register Resource Post Type and Associated Taxonomy
	add_action('init', 'pnch_register_resources');
	function pnch_register_resources()
	{
		$cat_labels = array(
			'name'				=>	'Resource Categories',
			'singular_name'		=>	'Resource Category'
		);
		register_taxonomy('resource_category', 'stringham_resource', array('labels' => $cat_labels, 'hierarchical' => true ) );
	
		$labels = array(
			'name'				=>	'Resources',
			'singular_name'		=>	'Resource'
		);
		$args = array(
			'labels' 			 => $labels,
			'public' 			 => true,
			'show_in_nav_menus'	 => false,
			'show_in_admin_bar'  => false,
			'taxonomies'		 => array('resource_category'),
			'supports' 			 => array('title', 'custom-fields', 'excerpt')
		
		);
		register_post_type('stringham_resource', $args);
	}
	
	// Add Custom Meta Field on Resource Category Taxonomy to handle subtitles
