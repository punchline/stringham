<?php
	/*
		Available Variables:
		$course_id 		: (int) ID of the course
		$course 		: (object) Post object of the course
		$course_settings : (array) Settings specific to current course
		$course_status 	: Course Status
		$has_access 	: User has access to course or is enrolled.

		$courses_options : Options/Settings as configured on Course Options page
		$lessons_options : Options/Settings as configured on Lessons Options page
		$quizzes_options : Options/Settings as configured on Quiz Options page

		$user_id 		: (object) Current User ID
		$logged_in 		: (true/false) User is logged in
		$current_user 	: (object) Currently logged in user object
		$quizzes 		: (array) Quizzes Array
		$post 			: (object) The topic post object
		$lesson_post 	: (object) Lesson post object in which the topic exists
		$topics 		: (array) Array of Topics in the current lesson
		$all_quizzes_completed : (true/false) User has completed all quizzes on the lesson Or, there are no quizzes.
		$lesson_progression_enabled 	: (true/false)
		$show_content	: (true/false) true if lesson progression is disabled or if previous lesson and topic is completed. 
		$previous_lesson_completed 	: (true/false) true if previous lesson is completed
		$previous_topic_completed	: (true/false) true if previous topic is completed
	*/

	/* Topic Dots */
	if(!empty($topics)) {
		?>
		<div id="learndash_topic_dots-<?php echo $lesson_id; ?>" class="learndash_topic_dots type-dots">
			<strong><?php _e('Topic Progress:', 'learndash'); ?></strong>
			<?php
			foreach ($topics as $key => $topic) { 
				$completed_class = empty($topic->completed)? "topic-notcompleted":"topic-completed";
				?>
				<a class="<?php echo $completed_class; ?>" href="<?php echo get_permalink($topic->ID); ?>" title="<?php echo $topic->post_title; ?>">
					<span title="<?php echo $topic->post_title; ?>"></span>
				</a>
			<?php } ?>
		</div>
		<?php 
	}
	
	/* Back to Lesson Link */
	?>
		<div id='learndash_back_to_lesson'><a href='<?php echo get_permalink($lesson_id); ?>'>&larr; <?php _e("Back to Lesson","learndash"); ?></a></div>
	<?php					


	/* Previous Topic Incomplete Message */
	if($lesson_progression_enabled && !$previous_topic_completed)
	{
		?>
		<span id='learndash_complete_prev_topic'><?php  _e('Please go back and complete the previous topic.', 'learndash'); ?></span><br>
		<?php
	}
	else 	/* Previous Lesson Incomplete Message */
	if($lesson_progression_enabled && !$previous_lesson_completed) {
		?>
		<span id='learndash_complete_prev_lesson'><?php _e('Please go back and complete the previous lesson.', 'learndash'); ?></span><br>
		<?php 
	}
	
	if($show_content)
	{
		/* Show Topic Content */
		echo $content;

		/* Show Topic Quizzes */		
		if ( !empty( $quizzes ) ) {
			?>
			<div id='learndash_quizzes'>
				<div id="quiz_heading"><span><?php _e('Quizzes', 'learndash') ?></span><span class="right"><?php _e('Status', 'learndash') ?></span></div>
				<div id="quiz_list">
				<?php foreach($quizzes as $quiz) { ?>
					<div id="post-<?php echo $quiz["post"]->ID; ?>" class="<?php echo $quiz["sample"];?>">
						<div class="list-count"><?php echo $quiz["sno"]; ?></div>
						<h4>
							<a class="<?php echo $quiz["status"]; ?>" href="<?php echo $quiz["permalink"]?>"><?php echo $quiz["post"]->post_title; ?></a>
						</h4>
					</div>
				<?php } ?>
				</div>
			</div>
			<?php 	
		}
	
		/* Show Assignments */
		if(lesson_hasassignments($post)) {
			if(current_user_can('manage_options')) {
				?>
				<br>
				<div id="learndash_assignments_list">
					<?php echo learndash_show_assignments_list($post); ?>
				</div>
				<br><br>
				<?php
			}
			$assinment_meta = get_post_meta ($post->ID, 'sfwd_lessons-assignment', true);
			?>
			<div id='learndash_uploaded_assignments'>
				<h2><?php _e("Files you have uploaded","learndash"); ?></h2>
				<table>
					<?php
					if(!empty($assinment_meta['assignment'])){
					foreach($assinment_meta['assignment'] as $k=>$v){
						if($current_user->user_login == $v['user_name']){
							if($v['file_link'] != 'not available'){
								?>
								<tr><a href="<?php echo $v['file_link']; ?>" target="_blank"><?php echo $v['file_name']; ?></a>
									<br/>
								</tr>
								<?php 
								}
							}
						}
					}	
					?>
				</table>
			</div>
			<?php 
		}
	
		/* Show Mark Complete Button */
		if($all_quizzes_completed)
			echo "<br>".learndash_mark_complete($post);
	}
	?>
	<p id='learndash_next_prev_link'><?php echo learndash_previous_post_link(); ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo learndash_next_post_link(); ?></p>
	<?php 
	
