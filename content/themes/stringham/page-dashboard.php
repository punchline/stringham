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

	
$badgeos = get_user_meta( $user->ID, '_badgeos_achievements' );
$badgeos = array_reverse($badgeos[0][1]);


$levels = array_values(array_filter($badgeos, function($obj){
	return ($obj->post_type == 'level');
}));

$badges = array_values(array_filter($badgeos, function($obj){
	return ($obj->post_type == 'badge');
}));

$achievements = array_values(array_filter($badgeos, function($obj){
	return ($obj->post_type == 'achievement');
}));
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
										
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12"><div class="callout callout-info">
				                  <h4><?php echo get_user_name($user->ID); ?> you now have 2 new quizzes available</h4>
				                  <p>Taking quizzes will help you get prepared to take your state exams. The more quizzes you take the better equipped you will be to pass the exam on your first try.</p>
				                </div></div>
							</div>
						
						
							<div class="row"><div class="col-md-6 col-sm-12 small-margin">
							
								<div class="col-md-6 col-sm-6 profile-blue">
									<div class="items-inner profile-item clearfix">
										<a class="items-image user-img" href="#"><img class="img-circle" src="<?php echo get_stylesheet_directory_uri(); ?>/images/gallery/2-big.jpg"></a>
										<h3 class="items-title"><?php echo $user->first_name;?></h3>
										<h5><?php echo $user->last_name;?></h5>
										<div class="official-title hidden-sm">Real Estate Genius</div>
										<div class="items-details hidden-sm">Enrolled since <?php echo date( 'm-d-Y', strtotime($user->user_registered)); ?></div>
				                    </div>
								</div>
								
								<div class="col-md-6 col-sm-6 profile-white tiny-margin">
									<div class="row">
										<div class="col-md-6 col-sm-4 col-xs-4">
											<i class="fa fa-level-up fa-3x"></i><br/>
											<h6>Student Level</h6>
											<?php
												if(!empty($levels)){
													$level_id = $levels[0]->ID;
													$level = get_post($level_id);
													$level = str_replace('Level ','', $level->post_title);
												}
												else{
													$level = '1';
												}
											?>
											
											<span><strong><?php echo $level; ?></strong></span>
										</div>
										<div class="col-md-6 col-sm-4 col-xs-4">
											<i class="fa fa-bullseye fa-3x"></i><br/>
											<h6>Points</h6>
											<span><strong><?php echo get_user_meta($user->ID,'_badgeos_points', true);?></strong></span>
										</div>
										<div class="col-md-6 col-sm-4 col-xs-4 hidden-lg hidden-md">
											<i class="fa fa-book fa-3x"></i><br/>
											<h6>Lessons Completed</h6>
											<span><strong>14</strong></span>
										</div>

									</div>
									<div class="row">
										<div class="col-md-6 col-sm-4 col-xs-4 hidden-sm hidden-xs">
											<i class="fa fa-book fa-3x"></i><br/>
											<h6>Lessons Completed</h6>
											<span><strong>14</strong></span>
										</div>
										<div class="col-md-6 col-sm-4 col-xs-4">
											<i class="fa fa-graduation-cap fa-3x"></i><br/>
											<h6>Quizzes Completed</h6>
											<span><strong>5</strong></span>
										</div>
										<div class="col-md-6 col-sm-4 col-xs-4 hidden-lg hidden-md">
											<i class="fa fa-star fa-3x"></i><br/>
											<h6>Badges</h6>
											<span><strong><?php echo count($badges); ?></strong></span>
										</div>
										<div class="col-md-6 col-sm-4 col-xs-4 hidden-lg hidden-md" style="padding-left: 4px;">
											<i class="fa fa-trophy fa-3x little-left"></i><br/>
											<h6>Acheivement</h6>
											<span class="little-left"><strong><?php echo count($achievements); ?></strong></span>
										</div>
										
										
									</div>
									<div class="row hidden-sm hidden-xs">
										<div class="col-md-6 col-sm-4">
											<i class="fa fa-star fa-3x"></i><br/>
											<h6>Badges</h6>
											<span><strong><?php echo count($badges); ?></strong></span>
										</div>
										<div class="col-md-6 col-sm-4">
											<i class="fa fa-trophy fa-3x"></i><br/>
											<h6>Acheivement</h6>
											<span><strong><?php echo count($achievements); ?></strong></span>
										</div>
									</div>
								
								</div>
								
								
							</div><!--/col-md-6-->
								
									
						
								
								
							
							<div class="col-md-6 col-sm-12 hidden-xs">
								<!--Panel-->
								<div class="panel panel-danger">
									<div class="panel-heading">
										<div class="panel-title pull-left">Your Recent Badges<small class="hidden-md hidden-sm">Click for more info</small></div>
										<div class="pull-right">  <a href="#" class="btn-minmax hidden-sm hidden-xs"><i class="fa fa-chevron-circle-up"></i></a>
										</div>
										<div class="clearfix"></div>
										</div>
										<div class="panel-body badge-body">
											<div class="row">
												<?php													
													$badge_imgs = array();
													for($i = 0; $i<4; $i++){
														$badge = $badges[$i];
														$post_thumbnail_id = get_post_thumbnail_id( $badge->ID ); 
														$img = wp_get_attachment_image_src( $post_thumbnail_id );
														if($img[0] == '') continue;
														$badge_imgs[] = $img[0];
													}
													
													$i = 1;
													foreach( $badge_imgs as $badge ){
														$classes = 'col-lg-3 col-md-4 col-sm-4';
														if($i == count($badge_imgs)) $classes .= ' hide-l';
														
														if($badge == ''){
															echo "<div class='$classes'></div>";	
															continue;
														}
														echo "<div class='$classes'><img src='$badge' /></div>";
														$i++;
													}
												?>
											</div>
									</div>
								</div>
								<!--/Panel--> 
								
								<!--Panel-->
								<div class="panel panel-danger">
									<div class="panel-heading">
										<div class="panel-title pull-left">Your Recent Achievements<small class="hidden-md hidden-sm">Click for more info</small></div>
										<div class="pull-right">  <a href="#" class="btn-minmax hidden-sm hidden-xs"><i class="fa fa-chevron-circle-up"></i></a>
										 </div>
										<div class="clearfix"></div>
									</div>
									<div class="panel-body badge-body">
										<div class="row">
											<?php	
																									
												$achievement_imgs = array();
												for($i = 0; $i<4; $i++){
													$achievement = $achievements[$i];
													$post_thumbnail_id = get_post_thumbnail_id( $achievement->ID ); 
													$img = wp_get_attachment_image_src( $post_thumbnail_id );
													if($img[0] == '') continue;
													$achievement_imgs[] = $img[0];
												}
												
												
												$i = 1;
												foreach( $achievement_imgs as $achievement ){
													$classes = 'col-lg-3 col-md-4 col-sm-4';
													if($i == count($achievement_imgs)) $classes .= ' hide-l';
													
													if($achievement == ''){
														echo "<div class='$classes'></div>";	
														continue;
													}
													echo "<div class='$classes'><img src='$achievement' /></div>";
													$i++;
												}
											?>
										</div>
									</div>
								</div>
								<!--/Panel--> 

								
								
							</div></div>
							
						
					
						
						<div class="row">
							<div class="col-md-4 col-sm-6 hidden-xs continue-class">
								<!--Panel-->
								<div class="panel panel-cold">
									<div class="panel-heading">
										<div class="panel-title pull-left">Continue <span class="hidden-sm hidden-xs">Your Current</span> Class</div>
										<div class="pull-right">
											 <a href="#" class="btn-minmax hidden-sm hidden-xs"><i class="fa fa-chevron-circle-up"></i></a> 
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="panel-body dash-class-body">
										<a href="<?php echo home_url('courses/demo-course');?>"><img src="<?php echo get_stylesheet_directory_uri();?>/images/video-image-1.png"/></a> <!--video place holder-->
									</div>
								</div><!--/Panel-->
							</div><!--/col-md-4-->
							
							<div class="col-md-4 hide-l hidden-xs">
								<!--Panel-->
								<div class="panel panel-cold">
									<div class="panel-heading">
										<div class="panel-title pull-left">Next Class</div>
										<div class="pull-right">
											 <a href="#" class="btn-minmax hidden-sm hidden-xs"><i class="fa fa-chevron-circle-up"></i></a> 
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="panel-body dash-class-body">
										<a href="<?php echo home_url('courses/sales-agent-course');?>"><img src="<?php echo get_stylesheet_directory_uri();?>/images/video-image-2.png"/></a> <!--video place holder-->
									</div>
								</div><!--/Panel-->
							</div><!--/col-md-4-->
							
							<div class="col-md-4 col-sm-6 col-xs-12 quiz-panel">
								<!--Panel-->
								<div class="panel panel-cold">
									<div class="panel-heading">
										<div class="panel-title pull-left">Take A Pop Quiz</div>
										<div class="pull-right">
											 <a href="#" class="btn-minmax hidden-sm hidden-xs"><i class="fa fa-chevron-circle-up"></i></a> 
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="panel-body dash-class-body quiz-scroll">
										<table class="table table-striped table-hover margin-0px airtable">
					                      <thead>
					                        <tr>
					                          <th colspan="2">Category</th>
					                          <th colspan="2">&nbsp;</th>
					                        </tr>
					                      </thead>
					                      <tbody>
					                        <tr>
					                          <td><span class="num">1</span></td>
					                          <td><h4><a href="<?php echo home_url('pop-quiz/?category=general-1')?>">General Quiz</a></h4></td>
					                          <td><a href="<?php echo home_url('pop-quiz/?category=general-1')?>"><button class="btn-group btn-group-xs btn-warning hidden-sm hidden-xs">Start</button></a></td>
					                        </tr>
					                        <tr>
					                          <td><span class="num">2</span></td>
					                          <td><h4><a href="<?php echo home_url('pop-quiz/?category=federal-laws')?>">Federal Laws</a></h4></td>
					                          <td><a href="<?php echo home_url('pop-quiz/?category=federal-laws')?>"><button class="btn-group btn-group-xs btn-warning hidden-sm hidden-xs">Start</button></a></td>
					                        </tr>
					                        <tr>
					                          <td><span class="num">3</span></td>
					                          <td><h4><a href="<?php echo home_url('pop-quiz/?category=contract-laws')?>">Contract Laws</a></h4></td>
					                          <td><a href="<?php echo home_url('pop-quiz/?category=contract-laws')?>"><button class="btn-group btn-group-xs btn-warning hidden-sm hidden-xs">Start</button></a></td>
					                        </tr>
					                        <tr>
					                          <td><span class="num">4</span></td>
					                          <td><h4><a href="<?php echo home_url('pop-quiz/?category=law-of-agency')?>">Law Of Agency</a></h4></td>
					                          <td><a href="<?php echo home_url('pop-quiz/?category=law-of-agency')?>"><button class="btn-group btn-group-xs btn-warning hidden-sm hidden-xs">Start</button></a></td>
					                        </tr>
					                        <tr>
					                          <td><span class="num">5</span></td>
					                          <td><h4><a href="<?php echo home_url('pop-quiz/?category=utah-law')?>">Utah Law</a></h4></td>
					                          <td><a href="<?php echo home_url('pop-quiz/?category=utah-law')?>"><button class="btn-group btn-group-xs btn-warning hidden-sm hidden-xs">Start</button></a></td>
					                        </tr>
					                        <tr>
					                          <td><span class="num">6</span></td>
					                          <td><h4><a href="<?php echo home_url('pop-quiz/?category=property-management')?>">Property Management</a></h4></td>
					                          <td><a href="<?php echo home_url('pop-quiz/?category=property-management')?>"><button class="btn-group btn-group-xs btn-warning hidden-sm hidden-xs">Start</button></a></td>
					                        </tr>
					                        <tr>
					                          <td><span class="num">7</span></td>
					                          <td><h4><a href="<?php echo home_url('pop-quiz/?category=real-estate-finacne')?>">Real Estate Finance</a></h4></td>
					                          <td><a href="<?php echo home_url('pop-quiz/?category=real-estate-finacne')?>"><button class="btn-group btn-group-xs btn-warning hidden-sm hidden-xs">Start</button></a></td>
					                        </tr>
					                        <tr>
					                          <td><span class="num">8</span></td>
					                          <td><h4><a href="<?php echo home_url('pop-quiz/?category=settlement')?>">Settlement</a></h4></td>
					                          <td><a href="<?php echo home_url('pop-quiz/?category=settlement')?>"><button class="btn-group btn-group-xs btn-warning hidden-sm hidden-xs">Start</button></a></td>
					                        </tr>
					                        <tr>
					                          <td><span class="num">9</span></td>
					                          <td><h4><a href="<?php echo home_url('pop-quiz/?category=valuation-appraisal')?>">Valuation & Appraisal</a></h4></td>
					                          <td><a href="<?php echo home_url('pop-quiz/?category=valuation-appraisal')?>"><button class="btn-group btn-group-xs btn-warning hidden-sm hidden-xs">Start</button></a></td>
					                        </tr>
					                        <tr>
					                          <td><span class="num">10</span></td>
					                          <td><h4><a href="<?php echo home_url('pop-quiz/?category=math')?>">Math</a></h4></td>
					                          <td><a href="<?php echo home_url('pop-quiz/?category=math')?>"><button class="btn-group btn-group-xs btn-warning hidden-sm hidden-xs">Start</button></a></td>
					                        </tr>
					                        <tr>
					                          <td><span class="num">11</span></td>
					                          <td><h4><a href="<?php echo home_url('pop-quiz/')?>">Random</a></h4></td>
					                          <td><a href="<?php echo home_url('pop-quiz/')?>"><button class="btn-group btn-group-xs btn-warning hidden-sm hidden-xs">Start</button></a></td>
					                        </tr>
					                      </tbody>
					                      <tfoot>
					                        <tr>
					                          <th colspan="2">Category</th>
					                          <th colspan="2">&nbsp;</th>
					                        </tr>
					                      </tfoot>
					                    </table>

									</div>
								</div><!--/Panel-->
							</div><!--/col-md-4-->
							
						</div><!--/row-->		                		            
						
						
						<div class="row">
			               <div class="col-md-6 col-sm-12 col-xs-12">
			                   <!--Panel-->
				               <div class="panel panel-danger">
					               <div class="panel-heading">
						               <div class="panel-title pull-left">Games</div>
						               <div class="pull-right">
							                <a href="#" class="btn-minmax hidden-sm hidden-xs"><i class="fa fa-chevron-circle-up"></i></a> 
						               </div>
						               <div class="clearfix"></div>
					               </div>
					               <div class="panel-body">
						               <div class="col-md-4 col-sm-4 col-xs-4 game-image">
							               <a href="<?php echo home_url('games/word-search')?>"><img src="<?php echo get_template_directory_uri();?>/images/word-search.png" /><br/></a>
						               </div>
						               <div class="col-md-4 col-sm-4 col-xs-4 game-image">
							               <a href="<?php echo home_url('games/lie-detector')?>"><img src="<?php echo get_template_directory_uri();?>/images/lie-detector-preview.png" /><br/></a>
						               </div>
						               <div class="col-md-4 col-sm-4 col-xs-4 game-image">
						               	<a href="#"><img src="<?php echo get_template_directory_uri();?>/images/coming-soon.png" /><br/></a>
						               </div>
					               </div>
				               </div><!--/Panel-->
			               </div><!--/col-md-6-->
			               
			               <div class="col-md-6 col-sm-12 col-xs-12">
			                   <!--Panel-->
				               <div class="panel panel-danger">
					               <div class="panel-heading">
						               <div class="panel-title pull-left">Download Our Study Aid App</div>
						               <div class="pull-right">
							                <a href="#" class="btn-minmax hidden-sm hidden-xs"><i class="fa fa-chevron-circle-up"></i></a> 
						               </div>
						               <div class="clearfix"></div>
					               </div>
					               <div class="panel-body">
						               <a href="https://itunes.apple.com/us/app/real-estate-know-it-all/id740270293?mt=8" target="_blank"><img src="<?php echo get_template_directory_uri();?>/images/know-it-all.png" style="width:100%;" /></a>
					               </div>
				               </div><!--/Panel-->
			               </div><!--/col-md-6-->
			               
			               
		               </div><!--/row-->
						
						
						
		                
		                <div class="row hidden-xs">
			                <div class="col-md-12">
				                <!--Panel-->
				             <div class="panel panel-warning">
					                <div class="panel-heading">
						                <div class="panel-title pull-left">Optimum Finish <small>9 - 12 weeks</small></div>
						                <div class="pull-right">
							                 <a href="#" class="btn-minmax hidden-sm hidden-xs"><i class="fa fa-chevron-circle-up"></i></a> 
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
		               
		               <script>
			           	jQuery(document).ready(function(){
							//Example #1 - Chart With Graph Controls
							var courseData = [];
							
							courseCap = 10;
							var i;
							for (i = 1; i <= 6; i += 1) {
								courseData.push([i, (courseCap)]);
								courseCap += parseInt(Math.random() * 30);	
							}
							
							var optimum = {
								data: [[1,0], [9,120], [12,120], [1,0]],
								label: 'Optimum Completion Range',
								lines: {
									show: true,
									lineWidth: 0,
									fill: true
								}
							};
							var course = {
								data: courseData,
								label: 'Current Progress',
								lines: {
									show: true,
									lineWidth: 3
								}
							};
							
							if (jQuery("#placeholder").length) {
								jQuery.plot("#placeholder", [optimum, course], {
									colors: ["#BCD25E", "#E4705D"],
						
									grid: {
										hoverable: true,
										clickable: false,
										borderWidth: 0,
										backgroundColor: "transparent"
									},
						
									yaxis: {
										font: {
											color: '#555',
											family: 'Open Sans, sans-serif',
											size: 11
										},
										tickColor: "transparent"
									},
									xaxis: {
										font: {
											color: '#555',
											family: 'Open Sans, sans-serif',
											size: 11
										},
										tickColor: "rgba(0,0,0,0.1)"
									},
									legend: {
									    show: true,
									    position: "se"
									}
								});
							}
						});
		               </script>
		                
		               <div class="row hidden-xs">
			                <div class="col-md-12">
				                <!--Panel-->
				             <div class="panel panel-success">
					                <div class="panel-heading">
						                <div class="panel-title pull-left">Course Progress</div>
						                <div class="pull-right">
							                 <a href="#" class="btn-minmax hidden-sm hidden-xs"><i class="fa fa-chevron-circle-up"></i></a> 
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
