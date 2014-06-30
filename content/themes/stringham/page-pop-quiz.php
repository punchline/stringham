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
					<?php
						
						$questions = get_posts(array(
							'posts_per_page' => 1,
							'post_type'	=> 'stringham_question',
							'quiz_category' => 'math',
							'orderby' => 'rand'
						));
						
						foreach($questions as $question ){
							echo $question->post_title. '<br/>';
							
							$answers = array();
							for ($i = 1; $i < 5; $i++){
								$value = get_post_meta($question->ID, 'a'.$i, true);
								$answers[] = array('value'=>$value, 'correct'=>($i == 1));
							}
							
							shuffle($answers);
							
							echo '<ol>';
								foreach($answers as $answer){
									$correct = ($answer['correct']) ? 'correct': 'false';
									echo "<li class='$correct'>{$answer['value']}</li>";
								}
							echo '</ol>';
							
						}
					?>
				</div><!-- /.row -->
                    
            <?php the_content();?>
                    
			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>


