<?php

	// Register Quiz Questions, Attempts and Associated Taxonomy
	
	add_action('init', 'pnch_register_quizzes');
	function pnch_register_quizzes()
	{
	
		// Register Quiz Category Taxonomy for use in the Quiz Question CPT
		$cat_labels = array(
			'name'				=>	'Quiz Categories',
			'singular_name'		=>	'Quiz Category'
		);
		register_taxonomy('quiz_category', 'stringham_quiz_question', array('labels' => $cat_labels, 'hierarchical' => true ) );
		
		
		// Register Quiz Question CPT for use in quizzes
		$args = array(
			'labels' 			 => array(
										'name' => 'Pop Quiz Questions',
										'singular_name' => 'Pop Quiz Question'
									),
			'public' 			 => true,
			'show_in_nav_menus'	 => false,
			'show_in_admin_bar'  => false,
			'taxonomies' 		 => array('quiz_category'),
			'supports' 			 => array('title')
		);
		register_post_type('stringham_question', $args);
		
		// Register Quiz Attempt CPT for use in quizzes
		$args = array(
			'labels' 			 => array(
										'name' => 'Pop Quiz Attempts',
										'singular_name' => 'Pop Quiz Attempt'
									),
			'public' 			 => true,
			'show_in_nav_menus'	 => false,
			'show_in_admin_bar'  => false,
			'supports' 			 => array('title', 'custom-fields')
		);
		register_post_type('stringham_attempt', $args);
	}
	
	
	// Add the Meta Box
	function add_question_meta_box() {
	    add_meta_box(
	        'question_details', // $id
	        'Question Details', // $title 
	        'pnch_question_meta_box', // $callback
	        'stringham_question', // $page
	        'normal', // $context
	        'high'); // $priority
	}
	add_action('add_meta_boxes', 'add_question_meta_box');
	
	// Field Array
	$question_meta_fields = array(
    	array(
	        'label'=> 'Answer #1 (Correct)',
	        'desc'  => 'The correct answer to the question.',
	        'id'    => 'a1',
	        'type'  => 'text'
	    ),
	    array(
	        'label'=> 'Answer #2',
	        'desc'  => 'An incorrect answer to the question.',
	        'id'    => 'a2',
	        'type'  => 'text'
	    ),
	    array(
	        'label'=> 'Answer #3',
	        'desc'  => 'An incorrect answer to the question.',
	        'id'    => 'a3',
	        'type'  => 'text'
	    ),
	    array(
	        'label'=> 'Answer #4',
	        'desc'  => 'An incorrect answer to the question.',
	        'id'    => 'a4',
	        'type'  => 'text'
	    )
	);
	
	// The Callback
	function pnch_question_meta_box() {
		global $question_meta_fields, $post;
		// Use nonce for verification
		echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
	     
	    // Begin the field table and loop
	    echo '<table class="form-table">';
	    foreach ($question_meta_fields as $field) {
	        // get value of this field if it exists for this post
	        $meta = get_post_meta($post->ID, $field['id'], true);
	        // begin a table row with
	        echo '<tr>
	                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
	                <td>';
	                switch($field['type']) {
	                    // text
						case 'text':
						    echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
						        <br /><span class="description">'.$field['desc'].'</span>';
						break;
						// textarea
						case 'textarea':
						    echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
						        <br /><span class="description">'.$field['desc'].'</span>';
						break;
						// checkbox
						case 'checkbox':
						    echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
						        <label for="'.$field['id'].'">'.$field['desc'].'</label>';
						break;
						// select
						case 'select':
						    echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
						    foreach ($field['options'] as $option) {
						        echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
						    }
						    echo '</select><br /><span class="description">'.$field['desc'].'</span>';
						break;

	                } //end switch
	        echo '</td></tr>';
	    } // end foreach
	    echo '</table>'; // end table
	}
	
	// Save the Data
	function save_custom_meta($post_id) {
	    global $question_meta_fields;
	     
	    // verify nonce
	    if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__))) 
	        return $post_id;
	    // check autosave
	    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
	        return $post_id;
	    // check permissions
	    if ('page' == $_POST['post_type']) {
	        if (!current_user_can('edit_page', $post_id))
	            return $post_id;
	        } elseif (!current_user_can('edit_post', $post_id)) {
	            return $post_id;
	    }
	     
	    // loop through fields and save the data
	    foreach ($question_meta_fields as $field) {
	        $old = get_post_meta($post_id, $field['id'], true);
	        $new = $_POST[$field['id']];
	        if ($new && $new != $old) {
	            update_post_meta($post_id, $field['id'], $new);
	        } elseif ('' == $new && $old) {
	            delete_post_meta($post_id, $field['id'], $old);
	        }
	    } // end foreach
	}
	add_action('save_post', 'save_custom_meta');