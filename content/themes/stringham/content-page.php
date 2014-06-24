<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Stringham
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="page-header">
		<?php the_title( '<h1>', '</h1>' ); ?>
	</div><!-- .entry-header -->

	<!-- Widget Row Start grid -->
	<div class="row" id="powerwidgets">
	  <div class="col-md-12 bootstrap-grid"> 
		<?php the_content(); ?>
	  </div>
	  <!-- /Inner Row Col-md-12 --> 
	</div><!-- .entry-content -->
	
	<footer class="entry-footer">
		<?php edit_post_link( __( 'Edit', 'stringham' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->





    
    