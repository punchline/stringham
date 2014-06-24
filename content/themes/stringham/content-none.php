<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Stringham
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="page-header">
		<?php _e( 'Nothing Found', 'stringham' ); ?>
	</div><!-- .entry-header -->

	<!-- Widget Row Start grid -->
	<div class="row" id="powerwidgets">
	  <div class="col-md-12 bootstrap-grid"> 
		<?php if ( is_search() ) : ?>

			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'stringham' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'stringham' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	  </div>
	  <!-- /Inner Row Col-md-12 --> 
	</div><!-- .entry-content -->
</article><!-- #post-## -->
