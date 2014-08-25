<?php
/**
 * Plugin Name: LMS Quiz Import
 * Description: imports pop quiz questions on activation.
 * Version: 0.1
 * Author: Brandon Warner
 */
 
ini_set('auto_detect_line_endings', true);

function pnch_quiz_import_activate() {
	// Activation code here...
	$path = plugin_dir_path( __FILE__ );
	
    $logfile = fopen($path."log.txt", "w");
    
    $files = scandir($path.'/quizzes/');
	foreach($files as $file) {
	  	//do your work here
	  	if($file =='.' || $file == '..') continue;
	  	
	  	// get category of questions
	  	$cat_name = str_replace('.csv','',$file);
	  	
	  	$tax = 'quiz_category';
	  	$term = 0;
	  	if(!term_exists($cat_name, $tax))
	  	{
		  	$term_info = wp_insert_term( $cat_name, $tax);
		  	$term = $term_info['term_id'];
	  	}
	  	else{
		  	$term_info = term_exists( $cat_name, $tax);
		  	$term = $term_info['term_id'];
	  	}
		
	  	// open file and read each question line by line
	  	
	  	/*
		while(! feof($questions))
		{
			$question = fgetcsv($questions);
			$q = $question[0];
			
			if($q == 'QUESTION') continue;	
			
			
			$id = create_quiz_question($question, $term);
			fwrite($logfile, "$id ");
			$i++;
		}
	  	*/
	  	
	  	$row = 1;
		if (($handle = fopen($path.'/quizzes/'.$file, "r")) !== FALSE) {
		    while (($question = fgetcsv($handle, 1000, ",")) !== FALSE) {
		    
			    $q = $question[0];
				
				if($q == 'QUESTION') continue;	
				
				
				$id = create_quiz_question($question, $term);
				fwrite($logfile, "$id ");
				$i++;

		    }
		    
		    fclose($handle);
		}
		
	}
	
	fclose($logfile);
}
register_activation_hook( __FILE__, 'pnch_quiz_import_activate' );

function create_quiz_question($question, $term_id){
	// 0 - Question
	// 1 - correct
	// 2 - incorrect 1
	// 3 - incorrect 2
	// 4 - incorrect 3
	// 5 - explanation
	
	// post_type = stringham_question
	
	// Create post object
	$my_post = array(
	  'post_title'    => $question[0],
	  'post_content'  => $question[5],
	  'post_type'	  => 'stringham_question',
	  'post_status'   => 'publish',
	  'post_author'   => get_current_user_id(),
	  'quiz_category' => array($term_id)
	);
	
	// Insert the post into the database
	$post = wp_insert_post( $my_post );
	
	update_post_meta($post, 'a1', $question[1]);
	update_post_meta($post, 'a2', $question[2]);
	update_post_meta($post, 'a3', $question[3]);
	update_post_meta($post, 'a4', $question[4]);
	update_post_meta($post, 'correct', 'a1');
	
	wp_set_object_terms( $post, array(intval($term_id)), 'quiz_category' );
	
	return $post;
}