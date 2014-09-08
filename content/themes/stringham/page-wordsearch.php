<?php
/*
Template Name: Wordsearch
*/

/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Stringham
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/Word-Search-Title.png" id="wordsearch-title" />
				
					<!-- Widget Row Start grid -->
					<div class="row" id="powerwidgets">
					  <div class="col-md-12 bootstrap-grid"> 
						<?php 
							the_content(); 
							
							$category = $_GET['category'];
							if($category == '') $category = 'general-1';
							echo do_shortcode('[wordsearch_game category="'.$category.'" count="20"][/wordsearch_game]');	
						?>
						
					  </div>
					  <!-- /Inner Row Col-md-12 --> 
					</div><!-- .entry-content -->
					
					<footer class="entry-footer">
						<?php edit_post_link( __( 'Edit', 'stringham' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-footer -->
				</article><!-- #post-## -->

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->


	<style>
		.main-wrap>.content-wrapper{
			background: #3f9bb5; /* Old browsers */
			background: -moz-linear-gradient(left, #3f9bb5 0%, #6ebedc 50%, #3f9bb5 100%); /* FF3.6+ */
			background: -webkit-gradient(linear, left top, right top, color-stop(0%,#3f9bb5), color-stop(50%,#6ebedc), color-stop(100%,#3f9bb5)); /* Chrome,Safari4+ */
			background: -webkit-linear-gradient(left, #3f9bb5 0%,#6ebedc 50%,#3f9bb5 100%); /* Chrome10+,Safari5.1+ */
			background: -o-linear-gradient(left, #3f9bb5 0%,#6ebedc 50%,#3f9bb5 100%); /* Opera 11.10+ */
			background: -ms-linear-gradient(left, #3f9bb5 0%,#6ebedc 50%,#3f9bb5 100%); /* IE10+ */
			background: linear-gradient(to right, #3f9bb5 0%,#6ebedc 50%,#3f9bb5 100%); /* W3C */
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3f9bb5', endColorstr='#3f9bb5',GradientType=1 ); /* IE6-9 */
		}
	</style>
<?php get_footer(); ?>
