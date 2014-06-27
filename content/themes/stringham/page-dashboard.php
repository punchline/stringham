<?php
/*
Template Name: Dashboard
*/

/**
 * The template for displaying the dashboard to logged in users.
 *
 * This is the template that displays the dynamic dashboard homepage.
 *
 * @package Stringham
 */

get_header(); 

$user = wp_get_current_user();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<!-- Widget Row Start grid -->
					<div class="row" id="powerwidgets">
					  <div class="col-md-12 bootstrap-grid"> 
						<div class="callout callout-info">
		                  <h4><?php echo get_user_name($user->ID); ?> you now have 2 new quizzes available</h4>
		                  <p>Taking quizzes will help you get prepared to take your state exams. The more quizzes you take the better equipped you will be to pass the exam on your first try.</p>
		                </div>
		                 
						<div class="user-profile">
							<div class="main-info">
							<div class="user-img"><img src="http://placehold.it/150x150" alt="User Picture" /></div>
								<h1><?php echo get_user_name($user->ID); ?></h1>
								<p>Real Estate Genius</p>
								<span>Points: <?php echo get_user_meta($user->ID, '_badgeos_points', true); ?></span> 
							</div>
							<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
								<div class="carousel-inner">
									<div class="item item1 active"></div>
								</div>
							</div>
						</div>

						<div class="row" style="margin-top: 20px;">
							<div class="col-md-6"> 
								<!--Panel-->
								<div class="panel panel-primary">
									<div class="panel-heading">
										<div class="panel-title pull-left">Your Recent Badges<small>Click for more info</small></div>
										<div class="pull-right"> <a href="#" data-toggle="modal" data-target="#panel-question" class="btn-question"><i class="fa fa-question-circle"></i></a> <a href="#" class="btn-minmax"><i class="fa fa-chevron-circle-up"></i></a> <a href="#" class="btn-close"><i class="fa fa-times-circle"></i></a> 
										</div>
										<div class="clearfix"></div>
										</div>
										<div class="panel-body badge-body">
											<div class="col-md-3">
												<img src="http://dummyimage.com/150x150/000/000"/>
											</div>
											<div class="col-md-3">
												<img src="http://dummyimage.com/150x150/000/000"/>
											</div>
											<div class="col-md-3">
												<img src="http://dummyimage.com/150x150/000/000"/>
											</div>
											<div class="col-md-3">
												<img src="http://dummyimage.com/150x150/000/000"/>
											</div>
									</div>
								</div>
								<!--/Panel--> 
							</div> <!--/col-md-6-->
							
							
							<div class="col-md-6"> 
								<!--Panel-->
								<div class="panel panel-primary">
									<div class="panel-heading">
										<div class="panel-title pull-left">Your Recent Achievements<small>Click for more info</small></div>
										<div class="pull-right"> <a href="#" data-toggle="modal" data-target="#panel-question" class="btn-question"><i class="fa fa-question-circle"></i></a> <a href="#" class="btn-minmax"><i class="fa fa-chevron-circle-up"></i></a> <a href="#" class="btn-close"><i class="fa fa-times-circle"></i></a>
										 </div>
										<div class="clearfix"></div>
									</div>
									<div class="panel-body badge-body">
										<div class="col-md-3">
											<img src="http://dummyimage.com/150x150/000/000"/>
										</div>
										<div class="col-md-3">
											<img src="http://dummyimage.com/150x150/000/000"/>
										</div>
										<div class="col-md-3">
											<img src="http://dummyimage.com/150x150/000/000"/>
										</div>
										<div class="col-md-3">
											<img src="http://dummyimage.com/150x150/000/000"/>
										</div>
									</div>
								</div>
								<!--/Panel--> 
							</div><!--/col-md-6-->
						</div><!--/row-->
						
						<div class="row">
							<div class="col-md-4">
								<!--Panel-->
								<div class="panel panel-cold">
									<div class="panel-heading">
										<div class="panel-title pull-left">Continue Your Current Class</div>
										<div class="pull-right">
											<a href="#" data-toggle="modal" data-target="#panel-question" class="btn-question"><i class="fa fa-question-circle"></i></a> <a href="#" class="btn-minmax"><i class="fa fa-chevron-circle-up"></i></a> <a href="#" class="btn-close"><i class="fa fa-times-circle"></i></a>
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="panel-body dash-class-body">
										<img src="http://dummyimage.com/345x345/000/000""/> <!--video place holder-->
									</div>
									<div class="btn-group btn-group-justified">
										<button type="button" class="btn btn-success" style="width:100%;">See All Classes</button>
									</div>
								</div><!--/Panel-->
							</div><!--/col-md-4-->
							
							<div class="col-md-4">
								<!--Panel-->
								<div class="panel panel-cold">
									<div class="panel-heading">
										<div class="panel-title pull-left">Suggested Next Class</div>
										<div class="pull-right">
											<a href="#" data-toggle="modal" data-target="#panel-question" class="btn-question"><i class="fa fa-question-circle"></i></a> <a href="#" class="btn-minmax"><i class="fa fa-chevron-circle-up"></i></a> <a href="#" class="btn-close"><i class="fa fa-times-circle"></i></a>
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="panel-body dash-class-body">
										<img src="http://dummyimage.com/345x345/000/000"/> <!--video place holder-->
									</div>
									<div class="btn-group btn-group-justified">
										<button type="button" class="btn btn-success" style="width:100%;">See All Classes</button>
									</div>
								</div><!--/Panel-->
							</div><!--/col-md-4-->
							
							<div class="col-md-4">
								<!--Panel-->
								<div class="panel panel-cold">
									<div class="panel-heading">
										<div class="panel-title pull-left">Suggested Next Class</div>
										<div class="pull-right">
											<a href="#" data-toggle="modal" data-target="#panel-question" class="btn-question"><i class="fa fa-question-circle"></i></a> <a href="#" class="btn-minmax"><i class="fa fa-chevron-circle-up"></i></a> <a href="#" class="btn-close"><i class="fa fa-times-circle"></i></a>
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="panel-body dash-class-body">
										<img src="http://dummyimage.com/345x345/000/000"/> <!--video place holder-->
									</div>
									<div class="btn-group btn-group-justified">
										<button type="button" class="btn btn-success" style="width:100%;">See All Classes</button>
									</div>
								</div><!--/Panel-->
							</div><!--/col-md-4-->
							
						</div><!--/row-->		                		            
		                
		                <div class="row">
			                <div class="col-md-12">
				                <!--Panel-->
				             <div class="panel panel-warning">
					                <div class="panel-heading">
						                <div class="panel-title pull-left">Optimum Finish <small>9 weeks or 12 weeks</small></div>
						                <div class="pull-right">
							                <a href="#" data-toggle="modal" data-target="#panel-question" class="btn-question"><i class="fa fa-question-circle"></i></a> <a href="#" class="btn-minmax"><i class="fa fa-chevron-circle-up"></i></a> <a href="#" class="btn-close"><i class="fa fa-times-circle"></i></a>
						                </div>
						                <div class="clearfix"></div>
					                </div>
					                <div class="panel-body">
						            	<div class="powerwidget" id="flotchart-widget-3" data-widget-editbutton="false">
							              <div class="inner-spacer">
							                <div class="flotchart-block">
							                  <div class="flotchart-container">
							                    <div id="placeholder" class="flotchart-placeholder"></div>
							                  </div>
							                </div>
							              </div>
							            </div>
					                </div>
				                </div><!--/Panel-->
			                </div><!--/col-md-12-->
		               </div><!--/row-->
		                
		                
		               <div class="row">
			                <div class="col-md-12">
				                <!--Panel-->
				             <div class="panel panel-success">
					                <div class="panel-heading">
						                <div class="panel-title pull-left">Course Progress</div>
						                <div class="pull-right">
							                <a href="#" data-toggle="modal" data-target="#panel-question" class="btn-question"><i class="fa fa-question-circle"></i></a> <a href="#" class="btn-minmax"><i class="fa fa-chevron-circle-up"></i></a> <a href="#" class="btn-close"><i class="fa fa-times-circle"></i></a>
						                </div>
						                <div class="clearfix"></div>
					                </div>
					                <div class="panel-body">
						            	<div class="powerwidget" id="flotchart-widget-5" data-widget-editbutton="false">
							              <div class="inner-spacer">
							                <div class="flotchart-container">
							                  <div id="placeholder2" class="flotchart-placeholder"></div>
							                </div>
							              </div>
							            </div>
							            <!-- /New widget --> 
					                </div>
				                </div><!--/Panel-->
			                </div><!--/col-md-12-->
		               </div><!--/row-->
		               
		               <div class="row">
			               <div class="col-md-6">
			                   <!--Panel-->
				               <div class="panel panel-cold">
					               <div class="panel-heading">
						               <div class="panel-title pull-left">Games</div>
						               <div class="pull-right">
							               <a href="#" data-toggle="modal" data-target="#panel-question" class="btn-question"><i class="fa fa-question-circle"></i></a> <a href="#" class="btn-minmax"><i class="fa fa-chevron-circle-up"></i></a> <a href="#" class="btn-close"><i class="fa fa-times-circle"></i></a>
						               </div>
						               <div class="clearfix"></div>
					               </div>
					               <div class="panel-body">
						               <div class="col-md-4 game-image">
							               <img src="http://dummyimage.com/100x100/000/000" /><br/>
							               <span class="game-title">Real Estate Crossword</span><br/>
							               <span class="game-rating"></span><br/>
							               <span class="game-points">Points: 750</span>
						               </div>
						               <div class="col-md-4 game-image">
							               <img src="http://dummyimage.com/100x100/000/000" /><br/>
							               <span class="game-title">Law Trivia</span><br/>
							               <span class="game-rating"></span><br/>
							               <span class="game-points">Points: 150,000,000</span>
						               </div>
						               <div class="col-md-4 game-image">
						               	<img src="http://dummyimage.com/100x100/000/000" /><br/>
						               	<span class="game-title">7 Words Appraisal</span><br/>
						               	<span class="game-rating"></span><br/>
						               	<span class="game-points">Points: 85,450</span>
						               </div>
					               </div>
				               </div><!--/Panel-->
			               </div><!--/col-md-6-->
			               
			               <div class="col-md-6">
			                   <!--Panel-->
				               <div class="panel panel-cold">
					               <div class="panel-heading">
						               <div class="panel-title pull-left">Download Our Study Aid App</div>
						               <div class="pull-right">
							               <a href="#" data-toggle="modal" data-target="#panel-question" class="btn-question"><i class="fa fa-question-circle"></i></a> <a href="#" class="btn-minmax"><i class="fa fa-chevron-circle-up"></i></a> <a href="#" class="btn-close"><i class="fa fa-times-circle"></i></a>
						               </div>
						               <div class="clearfix"></div>
					               </div>
					               <div class="panel-body">
						               <img src="http://dummyimage.com/575x212/000/000" style="width:100%;" />
					               </div>
				               </div><!--/Panel-->
			               </div><!--/col-md-6-->
			               
			               
		               </div><!--/row-->
		               
						
						<?php the_content(); ?>
						
						
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
