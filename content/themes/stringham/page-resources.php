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
						<!--Panel-->
						<div class="panel panel-info">
							<div class="panel-heading">
								<div class="panel-title pull-left">Finance Links <small>Specific Details</small></div>
								<div class="pull-right">
									<a href="#" data-toggle="modal" data-target="#panel-question" class="btn-question"><i class="fa fa-question-circle"></i></a> <a href="#" class="btn-minmax"><i class="fa fa-chevron-circle-up"></i></a> <a href="#" class="btn-close"><i class="fa fa-times-circle"></i></a>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="panel-body resource-body">
								<div class="dd nestable4" id="nestable4">
									<ol class="dd-list">
										<li class="dd-item task-item" data-id="13"><button data-action="collapse" type="button">Collapse</button><button data-action="expand" type="button" style="display: none;">Expand</button>
											<div class="dd-handle task-handle"></div>
											<div class="task-content header">My Favorite Links</div>
											<ol class="dd-list important">
												<li class="dd-item task-item" data-id="16">
													<div class="dd-handle task-handle"></div>
													<div class="task-content">
														<h4><span class="task">Law Link Title</span></h4>
														<p class="desc">Short description explaining the link</p>
														<small><a href="#" title="law-link">http://www.importantlink.com</a></small>
													</div>
												</li>
												<li class="dd-item task-item" data-id="17">
													<div class="dd-handle task-handle"></div>
													<div class="task-content">
														<h4><span class="task">Law Link Title</span></h4>
														<p class="desc">Short description explaining the link</p>
														<small><a href="#" title="law-link">http://www.importantlink.com</a></small>
													</div>
												</li>
												<li class="dd-item task-item" data-id="18">
													<div class="dd-handle task-handle"></div>
													<div class="task-content">
														<h4><span class="task">Law Link Title</span></h4>
														<p class="desc">Short description explaining the link</p>
														<small><a href="#" title="law-link">http://www.importantlink.com</a></small>
													</div>
												</li>
											</ol>
										</li>
										<li class="dd-item task-item" data-id="14"><button data-action="collapse" type="button">Collapse</button><button data-action="expand" type="button" style="display: none;">Expand</button>
											<div class="dd-handle task-handle"></div>
											<div class="task-content header">Links For Next Year</div>
											<ol class="dd-list new">
												<li class="dd-item task-item" data-id="16">
													<div class="dd-handle task-handle"></div>
													<div class="task-content">
														<h4><span class="task">Law Link Title</span></h4>
														<p class="desc">Short description explaining the link</p>
														<small><a href="#" title="law-link">http://www.importantlink.com</a></small>
													</div>
												</li>
												<li class="dd-item task-item" data-id="17">
													<div class="dd-handle task-handle"></div>
													<div class="task-content">
														<h4><span class="task">Law Link Title</span></h4>
														<p class="desc">Short description explaining the link</p>
														<small><a href="#" title="law-link">http://www.importantlink.com</a></small>
													</div>
												</li>
												<li class="dd-item task-item" data-id="18">
													<div class="dd-handle task-handle"></div>
													<div class="task-content">
														<h4><span class="task">Law Link Title</span></h4>
														<p class="desc">Short description explaining the link</p>
														<small><a href="#" title="law-link">http://www.importantlink.com</a></small>
													</div>
												</li>
											</ol>
										</li>
										<li class="dd-item task-item" data-id="15"><button data-action="collapse" type="button">Collapse</button><button data-action="expand" type="button" style="display: none;">Expand</button>
											<div class="dd-handle task-handle"></div>
											<div class="task-content header">Other Subcategory For Personal Use</div>
											<ol class="dd-list completed">
												<li class="dd-item task-item" data-id="16">
													<div class="dd-handle task-handle"></div>
													<div class="task-content">
														<h4><span class="task">Law Link Title</span></h4>
														<p class="desc">Short description explaining the link</p>
														<small><a href="#" title="law-link">http://www.importantlink.com</a></small>
													</div>
												</li>
												<li class="dd-item task-item" data-id="17">
													<div class="dd-handle task-handle"></div>
													<div class="task-content">
														<h4><span class="task">Law Link Title</span></h4>
														<p class="desc">Short description explaining the link</p>
														<small><a href="#" title="law-link">http://www.importantlink.com</a></small>
													</div>
												</li>
											</ol>
										</li>
									</ol>
								</div><!--/nestable-->
							</div>
						</div><!--/Panel-->
					</div><!--/col-md-6-->
					
					<div class="col-md-6">
					<!--Panel-->
						<div class="panel panel-warning">
							<div class="panel-heading">
								<div class="panel-title pull-left">Law Links <small>Subtitle of some kind</small></div>
								<div class="pull-right">
									<a href="#" data-toggle="modal" data-target="#panel-question" class="btn-question"><i class="fa fa-question-circle"></i></a> <a href="#" class="btn-minmax"><i class="fa fa-chevron-circle-up"></i></a> <a href="#" class="btn-close"><i class="fa fa-times-circle"></i></a>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="panel-body resource-body">
								<div class="dd nestable4" id="nestable5">
									<ol class="dd-list">
										<li class="dd-item task-item" data-id="14"><button data-action="collapse" type="button">Collapse</button><button data-action="expand" type="button" style="display: none;">Expand</button>
											<div class="dd-handle task-handle"></div>
											<div class="task-content header">Federal Law</div>
											<ol class="dd-list new">
												<li class="dd-item task-item" data-id="16">
													<div class="dd-handle task-handle"></div>
													<div class="task-content">
														<h4><span class="task">Law Link Title</span></h4>
														<p class="desc">Short description explaining the link</p>
														<small><a href="#" title="law-link">http://www.importantlink.com</a></small>
													</div>
												</li>
												<li class="dd-item task-item" data-id="17">
													<div class="dd-handle task-handle"></div>
													<div class="task-content">
														<h4><span class="task">Law Link Title</span></h4>
														<p class="desc">Short description explaining the link</p>
														<small><a href="#" title="law-link">http://www.importantlink.com</a></small>
													</div>
												</li>
												<li class="dd-item task-item" data-id="18">
													<div class="dd-handle task-handle"></div>
													<div class="task-content">
														<h4><span class="task">Law Link Title</span></h4>
														<p class="desc">Short description explaining the link</p>
														<small><a href="#" title="law-link">http://www.importantlink.com</a></small>
													</div>
												</li>
											</ol>
										</li>
										<li class="dd-item task-item" data-id="15"><button data-action="collapse" type="button">Collapse</button><button data-action="expand" type="button" style="display: none;">Expand</button>
											<div class="dd-handle task-handle"></div>
											<div class="task-content header">Federal Law</div>
											<ol class="dd-list completed">
												<li class="dd-item task-item" data-id="16">
													<div class="dd-handle task-handle"></div>
													<div class="task-content">
														<h4><span class="task">Law Link Title</span></h4>
														<p class="desc">Short description explaining the link</p>
														<small><a href="#" title="law-link">http://www.importantlink.com</a></small>
													</div>
												</li>
												<li class="dd-item task-item" data-id="17">
													<div class="dd-handle task-handle"></div>
													<div class="task-content">
														<h4><span class="task">Law Link Title</span></h4>
														<p class="desc">Short description explaining the link</p>
														<small><a href="#" title="law-link">http://www.importantlink.com</a></small>
													</div>
												</li><li class="dd-item task-item" data-id="17">
													<div class="dd-handle task-handle"></div>
													<div class="task-content">
														<h4><span class="task">Law Link Title</span></h4>
														<p class="desc">Short description explaining the link</p>
														<small><a href="#" title="law-link">http://www.importantlink.com</a></small>
													</div>
												</li>
											</ol>
										</li>
									</ol>
								</div><!--/nestable-->
							</div>
						</div><!--/Panel-->
					</div><!--/col-md-6-->
					
				</div><!--/row-->
                    
            <?php get_content();?>
                    
			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>


