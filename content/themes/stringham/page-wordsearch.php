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
					<div class="page-header">
						<?php the_title( '<h1>', '</h1>' ); ?>
					</div><!-- .entry-header -->
				
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

<?php get_footer(); ?>
