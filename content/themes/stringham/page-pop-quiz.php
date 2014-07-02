<?php
/*
Template Name: Pop Quiz
*/

/**
 * The template for displaying random quiz questions.
 *
 * @package Stringham
 */

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
										$category = 'general-1';
										
										$questions = get_posts(array(
											'posts_per_page' => 20,
											'post_type'	=> 'stringham_question',
											'quiz_category' => $category,
											'orderby' => 'rand'
										));
										
										foreach($questions as $question ){
											echo '<h3 class="question-title">';
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
											echo '<br/><br/>';
										}
									?>
									<br/><br/>
									<input type="hidden" name="action" value="grade_quiz" />
									<input type="hidden" name="quiz_category" value="<?php echo $category; ?>" />
									
									
									<div id="submit-error" class="callout callout-danger">
										<h4>You must answer every question before submitting your answers</h4>
										<p>You've got one or more questions above that you didn't even try to answer. Come on!</p>
					                </div>	
									<button type="submit" class="btn btn-success btn-large">Submit Answers</button>
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
								jQuery('#submit-error').fadeOut();
			            // bind 'myForm' and provide a simple callback function 
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
			        }); 
			    </script> 
                  
                  
			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>