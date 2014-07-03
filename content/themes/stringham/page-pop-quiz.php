<?php
/*
Template Name: Pop Quiz
*/

/**
 * The template for displaying random quiz questions.
 *
 * @package Stringham
 */


opcache_reset();

get_header(); 

$user = wp_get_current_user();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="panel-title pull-left">Quiz Title Here</div>
								<div class="pull-right"> 
									<a href="#" data-toggle="modal" data-target="#panel-question" class="btn-question"></a> 
									<a href="#" class="btn-minmax">
										<i class="fa fa-chevron-circle-up"></i>
									</a>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="panel-body badge-body">
								<form id="quiz_questions" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">	
									<?php
										$quiz = get_posts(array(
											'posts_per_page' => 1,
											'post_type' => 'stringham_attempt',
											'post_status' => 'draft',
											'author' => $user->ID 
										));
										
										if(!empty($quiz))
										{
											$quiz = $quiz[0];
											// user has drafted a quiz before	
											$questions = get_post_meta($quiz->ID, 'answers', true);
											
											foreach($questions as $q){
												
												$question = get_post($q['q']);
												
												echo '<div>';
													echo '<h3 class="question-title" id="question-'.$question->ID.'">';
														echo $question->post_title;
													echo '</h3>';$answers = array();
													
													for ($i = 1; $i < 5; $i++){
														$value = get_post_meta($question->ID, 'a'.$i, true);
														$answers[] = array('value'=>$value, 'id'=>'a'.$i);
													}
													
													shuffle($answers);
													
													foreach($answers as $answer){
														echo "<input type='radio' name='q-{$question->ID}' value='{$answer['id']}' ".checked($answer['id'], $q['a'],false)."> {$answer['value']}<br/>";
														
													}
												echo '</div><br/><br/>';
												
											}
										}
										else
										{
											// user has no saved quizes, generate a new one
										

											$category = 'general-1';
											
											$questions = get_posts(array(
												'posts_per_page' => 20,
												'post_type'	=> 'stringham_question',
												'quiz_category' => $category,
												'orderby' => 'rand'
											));
											
											foreach($questions as $question ){
												echo '<div>';
												echo '<h3 class="question-title" id="question-'.$question->ID.'">';
												echo $question->post_title;
												echo '</h3>';
												
												$answers = array();
												for ($i = 1; $i < 5; $i++){
													$value = get_post_meta($question->ID, 'a'.$i, true);
													$answers[] = array('value'=>$value, 'id'=>'a'.$i);
												}
												
												shuffle($answers);
												
												foreach($answers as $answer){
													echo "<input type='radio' name='q-{$question->ID}' value='{$answer['id']}'> {$answer['value']}<br/>";
													
												}
												echo '</div><br/><br/>';
											}
										}
									?>
									<br/><br/>
									<input type="hidden" name="action" value="grade_quiz" />
									<input type="hidden" name="post_id" value="" />
									<input type="hidden" name="quiz_category" value="<?php echo $category; ?>" />
									
									
									<div id="submit-error" class="callout callout-danger">
										<h4>You must answer every question before submitting your answers</h4>
										<p>You've got one or more questions above that you didn't even try to answer. Come on!</p>
					                </div>	
									<button type="submit" class="btn btn-success btn-large">Submit Answers</button>
									<span id="draft" class="btn btn-warning btn-large">Save Answers and Quit</span>
								</form>					
							</div>
						</div>
					</div>
				</div><!-- /.row -->
                    
            <?php the_content();?>
                  
	          <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
	          <script src="http://malsup.github.com/jquery.form.js"></script> 
	
			    <script> 
			        // wait for the DOM to be loaded 
			        jQuery(document).ready(function() { 
						jQuery('#submit-error').hide();
			            
			            // bind 'quiz_questions' and provide a simple callback function 
			            jQuery('#quiz_questions').ajaxForm({
				            dataType: 'json',
				            beforeSubmit: function(formData, jqForm, options){
								jQuery('#submit-error').fadeOut();
					            
					            var questions = jQuery(".question-title");
								if(jQuery("#quiz_questions input:radio:checked").length !== questions.length) {
								    // Not All Checked
								    jQuery('#submit-error').fadeIn();
								    return false;
								}
					            
				            },
				            success: function(r){
					            if(r.success)
					            {
						            window.location = r.data;
						            console.log(r);
					            }
					            else
					            {
						            console.error(r);
					            }
					            
				            },
				            error: function(r){
					            console.error(r);
				            },
				            
				            
			            }); 
			            
			            jQuery('#draft').on('click', function(){
				            
				            var answers = [],
				            	post_id = jQuery('input[name="post_id"]').val();
				            
				            jQuery(".question-title").each(function(){
						    	var q = jQuery(this),
						    		id = q.attr('id').replace('question-',''),
						    		ans = q.siblings('input:radio:checked').val();
						    		if(ans == undefined) ans = "";
						    		answers.push({'q':id, 'a':ans});
						    });
						    console.log(answers);
						    
				            jQuery.post('<?php echo admin_url('admin-ajax.php'); ?>', {action: 'draft_quiz', post_id: post_id, answers: answers, quiz_category: '<?php echo $category; ?>'}, function(r){
					            console.log(r);
					            jQuery('input[name="post_id"]').val(r.data);
					            window.location = '<?php echo home_url(); ?>';
				            });
				            
			            });
			        }); 
			    </script> 
                  
                  
			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>