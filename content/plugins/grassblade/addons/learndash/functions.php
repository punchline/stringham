<?php
define('GBL_LEARNDASH_PLUGIN_FILE', 'sfwd-lms/sfwd_lms.php');
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if(is_plugin_active(GBL_LEARNDASH_PLUGIN_FILE))
{
	add_action('admin_menu', 'grassblade_learndash_menu', 1);
}

function grassblade_learndash_menu() {
	add_submenu_page("edit.php?post_type=sfwd-courses", "TinCan Settings", "TinCan Settings",'manage_options','admin.php?page=grassblade-lrs-settings', 'grassblade_menu_page');
	add_submenu_page("edit.php?post_type=sfwd-courses", "PageViews Settings", "PageViews Settings",'manage_options','admin.php?page=pageviews-settings', 'grassblade_pageviews_menupage');
	
	global $submenu;
    $submenu['edit.php?post_type=sfwd-courses'][500] = array( 'One Click Upload', 'manage_options' , 'edit.php?post_type=gb_xapi_content' );
}

function grassblade_learndash_trackable_taxonomies($taxonomies) {
	if(!in_array('courses',$taxonomies))
	$taxonomies[] = 'courses';
	
	return $taxonomies;
}
add_filter('grassblade_trackable_taxonomies', 'grassblade_learndash_trackable_taxonomies',1,1);

function grassblade_learndash_lesson_completed($data) {
	grassblade_debug('grassblade_learndash_lesson_completed');
	//grassblade_debug($data);
	$grassblade_tincan_endpoint = get_option( 'grassblade_tincan_endpoint' );
	$grassblade_tincan_user = get_option('grassblade_tincan_user');
	$grassblade_tincan_password = get_option('grassblade_tincan_password');
	$grassblade_tincan_track_guest = get_option('grassblade_tincan_track_guest');
	$xapi = new NSS_XAPI($grassblade_tincan_endpoint, $grassblade_tincan_user, $grassblade_tincan_password);
	$actor = grassblade_getactor($grassblade_tincan_track_guest);

	if(empty($actor))
	{
		grassblade_debug("No Actor. Shutting Down.");
		return;
	}
	$course = $data['course'];
	$lesson = $data['lesson'];
	$progress = $data['progress'];
	
	$course_title = $course->post_title;
	$course_url = get_permalink($course->ID);
	$lesson_title = $lesson->post_title;
	$lesson_url = get_permalink($lesson->ID);
	
	if(!empty($course->ID) &&!empty($data['progress'][$course->ID]['completed']) && $data['progress'][$course->ID]['completed'] == 1) {
		//Course Attempted
		$xapi->set_verb('attempted');
		$xapi->set_actor_by_object($actor);	
		$xapi->set_parent($course_url, $course_title, $course_title, 'http://adlnet.gov/expapi/activities/course','Activity');
		$xapi->set_grouping($course_url, $course_title, $course_title, 'http://adlnet.gov/expapi/activities/course','Activity');
		$xapi->set_object($course_url, $course_title, $course_title, 'http://adlnet.gov/expapi/activities/course','Activity');
		$statement = $xapi->build_statement();
		//grassblade_debug($statement);
		$xapi->new_statement();
			
	}
	
	//Lesson Attempted
	$xapi->set_verb('attempted');
	$xapi->set_actor_by_object($actor);	
	$xapi->set_parent($course_url, $course_title, $course_title, 'http://adlnet.gov/expapi/activities/course','Activity');
	$xapi->set_grouping($course_url, $course_title, $course_title, 'http://adlnet.gov/expapi/activities/course','Activity');
	$xapi->set_object($lesson_url, $lesson_title, $lesson_title, 'http://adlnet.gov/expapi/activities/lesson','Activity');
	$statement = $xapi->build_statement();
	//grassblade_debug($statement);
	$xapi->new_statement();
	
	//Lesson Completed
	$xapi->set_verb('completed');
	$xapi->set_actor_by_object($actor);	
	$xapi->set_parent($course_url, $course_title, $course_title, 'http://adlnet.gov/expapi/activities/course','Activity');
	$xapi->set_grouping($course_url, $course_title, $course_title, 'http://adlnet.gov/expapi/activities/course','Activity');
	$xapi->set_object($lesson_url, $lesson_title, $lesson_title, 'http://adlnet.gov/expapi/activities/lesson','Activity');
	$result = array(
				'completion' => true
				);	
	$xapi->set_result_by_object($result);

	$statement = $xapi->build_statement();
	//grassblade_debug($statement);
	$xapi->new_statement();
	
	foreach($xapi->statements as $statement)
	{
		$ret = $xapi->SendStatements(array($statement));
	}	
}
function grassblade_learndash_course_completed($data) {
	grassblade_debug('grassblade_learndash_course_completed');
	//grassblade_debug($data);
	
	$grassblade_tincan_endpoint = get_option( 'grassblade_tincan_endpoint' );
	$grassblade_tincan_user = get_option('grassblade_tincan_user');
	$grassblade_tincan_password = get_option('grassblade_tincan_password');
	$grassblade_tincan_track_guest = get_option('grassblade_tincan_track_guest');
	$xapi = new NSS_XAPI($grassblade_tincan_endpoint, $grassblade_tincan_user, $grassblade_tincan_password);
	$actor = grassblade_getactor($grassblade_tincan_track_guest);

	if(empty($actor))
	{
		grassblade_debug("No Actor. Shutting Down.");
		return;
	}
	$course = $data['course'];
	$progress = $data['progress'];
	$course_title = $course->post_title;
	$course_url = get_permalink($course->ID);	
	//Lesson Completed
	$xapi->set_verb('completed');
	$xapi->set_actor_by_object($actor);	
	$xapi->set_parent($course_url, $course_title, $course_title, 'http://adlnet.gov/expapi/activities/course','Activity');
	$xapi->set_grouping($course_url, $course_title, $course_title, 'http://adlnet.gov/expapi/activities/course','Activity');
	$xapi->set_object($course_url, $course_title, $course_title, 'http://adlnet.gov/expapi/activities/course','Activity');
	$result = array(
				'completion' => true
				);	
	$xapi->set_result_by_object($result);	
	$statement = $xapi->build_statement();
	grassblade_debug($statement);
	$xapi->new_statement();	
	foreach($xapi->statements as $statement)
	{
		$ret = $xapi->SendStatements(array($statement));
	}		
}
function grassblade_learndash_quiz_completed($data) {
	//define('GB_DEBUG', true);
	grassblade_debug('grassblade_learndash_quiz_completed');
	grassblade_debug($data);
	$grassblade_tincan_endpoint = get_option( 'grassblade_tincan_endpoint' );
	$grassblade_tincan_user = get_option('grassblade_tincan_user');
	$grassblade_tincan_password = get_option('grassblade_tincan_password');
	$grassblade_tincan_track_guest = get_option('grassblade_tincan_track_guest');
	$xapi = new NSS_XAPI($grassblade_tincan_endpoint, $grassblade_tincan_user, $grassblade_tincan_password);
	$actor = grassblade_getactor($grassblade_tincan_track_guest);

	if(empty($actor))
	{
		grassblade_debug("No Actor. Shutting Down.");
		return;
	}
	$course = $data['course'];
	$quiz = $data['quiz'];
	$pass = !empty($data['pass'])? true:false;
	$score = $data['score']*1;
	
	$course_title = $course->post_title;
	$course_url = get_permalink($course->ID);
	$quiz_title = $quiz->post_title;
	$quiz_url = get_permalink($quiz->ID);
	

	//Quiz Attempted
	$xapi->set_verb('attempted');
	$xapi->set_actor_by_object($actor);	
	$xapi->set_parent($course_url, $course_title, $course_title, 'http://adlnet.gov/expapi/activities/course','Activity');
	$xapi->set_grouping($course_url, $course_title, $course_title, 'http://adlnet.gov/expapi/activities/course','Activity');
	$xapi->set_object($quiz_url, $quiz_title, $quiz_title, 'http://adlnet.gov/expapi/activities/assessment','Activity');
	$statement = $xapi->build_statement();
	grassblade_debug($statement);
	$xapi->new_statement();
	
	//Quiz Completed
	$xapi->set_verb('completed');
	$xapi->set_actor_by_object($actor);	
	$xapi->set_parent($course_url, $course_title, $course_title, 'http://adlnet.gov/expapi/activities/course','Activity');
	$xapi->set_grouping($course_url, $course_title, $course_title, 'http://adlnet.gov/expapi/activities/course','Activity');
	$xapi->set_object($quiz_url, $quiz_title, $quiz_title, 'http://adlnet.gov/expapi/activities/assessment','Activity');
	$result = array(
				'completion' => true,
				'success' => $pass,
				'score' => array('raw' => $score)
				);	
	$xapi->set_result_by_object($result);

	$statement = $xapi->build_statement();
	grassblade_debug($statement);
	$xapi->new_statement();
	
	foreach($xapi->statements as $statement)
	{
		$ret = $xapi->SendStatements(array($statement));
		grassblade_debug($ret);
	}	
}
add_action('learndash_lesson_completed', 'grassblade_learndash_lesson_completed', 1, 1);
add_action('learndash_course_completed', 'grassblade_learndash_course_completed', 1, 1);
add_action('learndash_quiz_completed', 'grassblade_learndash_quiz_completed', 1, 1);



function grassblade_learndash_process_mark_complete($return, $post, $user) {
	if(empty($post->ID) || empty($user->ID))
		return false;
	$user_id = $user->ID;
	$content_id = get_post_meta($post->ID, "show_xapi_content", true);

	if(empty($content_id))
		return true;

	$xapi_content = get_post_meta($content_id, "xapi_content", true);

	if(empty($xapi_content["completion_tracking"]))
		return true;

	$completed = get_user_meta($user->ID, "completed_".$content_id);

	if(empty($completed))
		return false;
	
	if($post->post_type == "sfwd-quiz") {
		if(!learndash_is_quiz_notcomplete(null, array($post->ID => 1 )))
			return false;

		foreach ($completed as $statement) {
			$statement = json_decode($statement);
			$result = @$statement->result;
			
			$usermeta = get_user_meta( $user->ID, '_sfwd-quizzes', true );
			$usermeta = maybe_unserialize( $usermeta );
			if ( !is_array( $usermeta ) ) $usermeta = Array();
			
			foreach($usermeta as $quiz_data) {
				if(!empty($quiz_data["statement_id"]) && $quiz_data["statement_id"] == @$statement->id)
					continue;
			}

			$score = !empty($statement->result->score->raw)? $statement->result->score->raw:(!empty($statement->result->score->scaled)? $statement->result->score->scaled*100:0);
			$percentage = !empty($statement->result->score->scaled)? $statement->result->score->scaled*100:((!empty($statement->result->score->max) && isset($statement->result->score->raw))? $statement->result->score->raw*100/($statement->result->score->max - @$statement->result->score->min):100);
			$percentage = round($percentage, 2);

			$quiz_id = $post->ID;
			$timespent = isset($statement->result->duration)? grassblade_duration_to_seconds($statement->result->duration):null;
			$count = 1;
			
			$quiz = get_post_meta($quiz_id, '_sfwd-quiz', true);
			$passingpercentage = intVal($quiz['sfwd-quiz_passingpercentage']);
			$pass = ($percentage >= $passingpercentage)? 1:0;
			$quiz = get_post($quiz_id);
			$quizdata = array( "statement_id" => @$statement->id, "quiz" => $quiz_id, "quiz_title" => $quiz->post_title, "score" => $score, "count" => $count, "pass" => $pass, "rank" => '-', "time" => time(), 'percentage' => $percentage, 'timespent' => $timespent);
			$usermeta[] = $quizdata;

			$quizdata['quiz'] = $quiz;
			$courseid = learndash_get_course_id($quiz_id);
			$quizdata['course'] = get_post($courseid);		

			update_user_meta( $user_id, '_sfwd-quizzes', $usermeta );
			do_action("learndash_quiz_completed", $quizdata); //Hook for completed quiz

		}
		return true;
	}
	return true;
}
add_filter("learndash_process_mark_complete", "grassblade_learndash_process_mark_complete", 1, 3);


function grassblade_learndash_slickquiz_loadresources($return, $post) {
	$content_id = get_post_meta($post->ID, "show_xapi_content", true);

	if(empty($content_id))
		return $return;
	else
		return false;
}

add_filter("leandash_slickquiz_loadresources", "grassblade_learndash_slickquiz_loadresources", 1, 2);

function grassblade_learndash_quiz_content_access($return, $post) {
	if(!is_null($return) || $post->post_type != "sfwd-quiz")
		return $return;

	$content_id = get_post_meta($post->ID, "show_xapi_content", true);

	if(!empty($content_id)) {
		if(learndash_is_quiz_notcomplete(null, array($post->ID => 1 )))
		return learndash_mark_complete($post); 
		else
		return learndash_get_certificate_link($post->ID);
	}
	return $return;
}

add_filter("learndash_content_access", "grassblade_learndash_quiz_content_access", 10, 2);

	function grassblade_duration_to_seconds($timeval) {
		if(empty($timeval)) return 0;
		
		$timeval = str_replace("PT", "", $timeval);
		$timeval = str_replace("H", "h ", $timeval);
		$timeval = str_replace("M", "m ", $timeval);
		$timeval = str_replace("S", "s ", $timeval);

		$time_sections = explode(" ", $timeval);
		$h = $m = $s = 0;
		foreach($time_sections as $k => $v) {
			$value = trim($v);
			
			if(strpos($value, "h"))
			$h = intVal($value);
			else if(strpos($value, "m"))
			$m = intVal($value);
			else if(strpos($value, "s"))
			$s = intVal($value);
		}
		$time = $h * 60 * 60 + $m * 60 + $s;
		
		if($time == 0)
		$time = (int) $timeval;
		
		return $time;
	}

