<?php
/*
Template Name: Courses
*/

/**
 * The template for displaying the course list to logged in users.
 *
 * This is the template that displays the dynamic course page.
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
			
			<?php get_template_part( 'content', 'page' ); ?>
			
				<div class="row">
					<div class="col-md-12">
						<?php echo do_shortcode('[ld_course_list mycourses="true"]');?>
					</div>
					
					<!--<div class="col-md-3">
						<?php //echo do_shortcode('[learndash_course_progress course_id="5"]');?>
					</div>-->
					
				</div><!--/row-->
                    
			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>

<!--

	<div class="profile-header"> Following <span class="badge">224</span>
		<div class="btn-group btn-group-xs pull-right">
			<button class="btn btn-default">Show all</button>
		</div>
	</div>
	
	
	
	
	
	
-->

