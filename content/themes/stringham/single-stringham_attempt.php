<?php
/**
 * The Template for displaying all single posts for stringham_attempts.
 *
 * @package Stringham
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>
		
			<?php
				
				$category = wp_get_object_terms($post->ID, 'quiz_category');
				$cat_name = $category[0]->name;
				$answers = get_post_meta($post->ID, 'answers', true);
				$score = get_post_meta($post->ID, 'score', true);
				
				if($score > 85)
				{
					$callout = "success";
					$scoreText = "Look at you, you're just a Know-It-All!";
				}	
				elseif( $score < 85 && $score > 75)
				{
					$callout = "warning";
					$scoreText = "You aren't quite ready, but you are getting closer!";
				}	
				elseif($score < 75)
				{
					$callout = "danger";
					$scoreText = "At least you know what to study";
					
				}		
			?>
		
		
				<div class="row">
					<div class="col-md-12">
						
						<div class="panel panel-cold">
							<div class="panel-heading">
								<div class="panel-title pull-left">Your <?php echo $cat_name;?> Quiz Results</div>
								<div class="pull-right"> 
									<a href="#" data-toggle="modal" data-target="#panel-question" class="btn-question"></a> 
									<a href="#" class="btn-minmax">
										<i class="fa fa-chevron-circle-up"></i>
									</a>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="panel-body badge-body">
								<div class="callout callout-<?php echo $callout; ?>">
									<h4>You scored <?php echo $score ;?>% on the <?php echo $cat_name;?> Quiz.</h4>
									<p><?php echo $scoreText; ?></p>
								</div>
					
							
								<div class="row">
									<div class="col-md-12">
										<?php 
											foreach($answers as $question_id => $answer) : 
											$question = get_post($question_id);
										?>
										
											<h3><?php echo $question->post_title; ?></h3>
											<?php
												$correct_answer = get_post_meta($question_id, 'correct', true);
												if($correct_answer == $answer){
													//answered correctly
													echo '<h4 class="text-dark-blue">'.get_post_meta($question_id, $answer, true).'</h4>';													
												}
												else
												{
													echo '<h4 class="text-pink">'.get_post_meta($question_id, $answer, true).'</h4>';
													echo '<div class="callout callout-info">
										                  	<h4>'.get_post_meta($question_id, $correct_answer, true).'</h4>
										                  	<p>'.$question->post_content.'</p>
										                  </div>';
												}
												
											?>
										<?php endforeach; ?>
									</div>
								</div><!-- Answers will go here -->
							</div>
						</div>
					</div>
				</div><!-- /.row -->




		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>




<!--


<form action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">	
									<?php
										
										$questions = get_posts(array(
											'posts_per_page' => 20,
											'post_type'	=> 'stringham_question',
											'quiz_category' => 'math',
											'orderby' => 'rand'
										));
										
										foreach($questions as $question ){
											echo '<h3>';
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
											
										}
									?>
									<br/><br/>
									<input type="hidden" name="action" value="grade_quiz" />
									<button type="submit" class="btn btn-success btn-large">Submit Answers</button>
								</form>


-->