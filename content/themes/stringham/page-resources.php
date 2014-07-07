<?php
/*
Template Name: Resources
*/

/**
 * The template for displaying the online resources list to logged in users.
 *
 * This is the template that displays the dynamic online resources page.
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
					<div class="col-md-6">
					<?php
						// retrieve top level 'resource_category' taxonomy terms
						$args = array('parent'=>0);
						$resource_categories = get_terms( 'resource_category', $args );
						$cat_total = count($resource_categories);
						
						foreach( $resource_categories as $rCount => $rc ):
							if( $rCount >= ($cat_total/2) ) echo '</div><!-- /.col-md-6 --><div class="col-md-6">';	// put half of the category sections in the left, half in the right
					?>
								<!--Panel-->
								<div class="panel panel-info">
									<div class="panel-heading">
										<div class="panel-title pull-left"><?php echo $rc->name; ?> <small>Specific Details</small></div>
										<div class="pull-right">
											<a href="#" data-toggle="modal" data-target="#panel-question" class="btn-question">
												<i class="fa fa-question-circle"></i></a> <a href="#" class="btn-minmax"><i class="fa fa-chevron-circle-up"></i>
											</a> 
											<a href="#" class="btn-close">
												<i class="fa fa-times-circle"></i>
											</a>
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="panel-body resource-body">
										<div class="dd nestable4" id="nestable4">
											<ol class="dd-list">
												<?php
													// loop through subcategories of current top level category
													$args = array('parent'=>$rc->term_id);
													$subcats = get_terms( 'resource_category', $args );
													foreach($subcats as $sCount => $sc):
												?>
												<li class="dd-item task-item" data-id="15">
													<div class="dd-handle task-handle"></div>
													<div class="task-content header"><?php echo $sc->name; ?></div>
													<ol class="dd-list completed">
														<?php
															// get all resource CPTs in subcategory, and display each one
															$resources = get_posts( array(
																'posts_per_page' => -1,
																'post_type' => 'stringham_resource',
																'resource_category' => $sc->name
															) );
															foreach($resources as $resource):
																$url = get_post_meta($resource->ID, 'url', true);
														?>
														<li class="dd-item task-item" data-id="16">
															<div class="dd-handle task-handle"></div>
															<div class="task-content">
																<h4><a href="<?php echo $url; ?>" target="_blank"><span class="task"><?php echo $resource->post_title; ?></span></a></h4>
																<p class="desc"><?php echo $resource->post_excerpt; ?></p>
																<small><a href="#" title="law-link"><?php echo $url; ?></a></small>
															</div>
														</li>
														<?php endforeach; ?>
													</ol>
												</li>
												<?php endforeach; ?>
											</ol>
										</div><!--/nestable-->
									</div>
								</div><!--/Panel-->
					<?php
						endforeach;
					?>
				</div><!-- /.row -->
                    
            <?php the_content();?>
                    
			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>


