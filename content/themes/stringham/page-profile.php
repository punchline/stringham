<?php
/*
Template Name: Profile
*/

/**
 * The template for displaying the profile to logged in users.
 *
 * This is the template that displays the dynamic profile page.
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
			
			
			
			<div class="user-profile">
                  <div class="main-info">
                    <div class="user-img"><img src="http://placehold.it/150x150" alt="User Picture" /></div>
                    <h1><?php echo "$user->nickname $user->last_name";?></h1>
                    <p>Real Estate Genius</p>
                    <span>Points: <?php echo get_user_meta( $user->ID, '_badgeos_points', true );?></span></div>
                  <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                      <div class="item item1 active"> </div>
                    </div>
                    </div>
                    
                    
                  <div class="user-profile-info">
                  	<div class="tabs-white">
                  	
						<!-- Nav tabs -->
						<ul class="nav nav-tabs">
						  <li class="active"><a href="#profile" data-toggle="tab">Profile</a></li>
						  <li><a href="#achievements" data-toggle="tab">Achievements</a></li>
						  <li><a href="#account" data-toggle="tab">My Account</a></li>
						  <li><a href="#progress" data-toggle="tab">My Progress</a></li>
						  <li><a href="#points" data-toggle="tab">My Points</a></li>						  
						</ul>
						
						<!-- Tab panes -->
						<div class="tab-content">
						  <div class="tab-pane active" id="profile">
							<div class="profile-header">Profile</div>
							<?php the_content();?>
							
							<div class="callout callout-danger">
			                  <h4><?php echo get_user_name($user->ID); ?>, you have to do something important!</h4>
			                  <p>Taking quizzes will help you get prepared to take your state exams. The more quizzes you take the better equipped you will be to pass the exam on your first try.</p>
			                </div>
							<table class="table">
								<tr>
									<td><strong>Name:</strong></td>
									<td><?php echo $user->first_name.' '.$user->last_name;?></td>
									<td><strong>Nickname:</strong></td>
									<td>"<?php echo $user->nickname; ?>"</td>
								</tr>
								<tr>
									<td><strong>Student ID:</strong></td>
									<td><?php echo get_user_meta($user->ID,'student_id',true); ?></td>
									<td><strong>Business:</strong></td>
									<td><?php echo get_user_meta($user->ID,'business_name',true); ?></td>
								</tr>
								<tr>
									<td><strong>License #:</strong></td>
									<td><?php echo get_user_meta($user->ID,'license',true); ?></td>
									<td><strong>Phone:</strong></td>
									<td><?php echo get_user_meta($user->ID,'phone',true); ?></td>
								</tr>
								<tr>
									<td><strong>Start Date:</strong></td>
									<td><?php echo date( 'M d, Y', strtotime($user->user_registered) ); ?></td>
									<td><strong>Email:</strong></td>
									<td><?php echo $user->user_email; ?></td>
								</tr>
								<tr>
									<td><strong>Status:</strong></td>
									<td><?php echo ucwords( get_user_meta($user->ID,'student_status',true) ); ?></td>
									<td><strong>Address:</strong></td>
									<td><?php echo ucwords( get_user_meta($user->ID,'address',true) ); ?><br/>
									<?php echo ucwords( get_user_meta($user->ID,'city',true) ); ?>, <?php echo ucwords( get_user_meta($user->ID,'state',true) ); ?> <?php echo ucwords( get_user_meta($user->ID,'postal_code',true) ); ?></td>
									
								</tr>
							</table>
							<div class="bottomProfileBtns"><button type="button" id="updateProfile" class="btn btn-primary btn-lg btn-block">Update Your Profile</button></div> 
						  </div>
						  
						  
						  
						  
						<div class="tab-pane" id="achievements">
					  
					  	<div class="profile-header myProfile-heading"> My Current Level<small>Click on the badges to learn more</small>
                        	<div class="btn-group btn-group-xs pull-right">
                        		<button class="btn btn-default">Show other levels</button>
                        	</div>
                        </div>
                        
                        <div class="row">
	                            <div class="col-md-12">
		                            <div class="panel panel-warning">
			                            <div class="panel-heading">
										<div class="panel-title pull-left">Congratulations! You have unlocked the Rainman Level</div>
										<div class="clearfix"></div>
										</div>			                            
		                            </div>
	                            </div><!--/Panel-->
                            </div><!--/row-->
                                                    
                        <div class="profile-header myProfile-heading"> My Unlocked Badges<small>Click on the badges to learn more</small><div class="btn-group btn-group-xs pull-right">
                        		<button class="btn btn-default" id="achievements_list_load_more" style="margin: 0 !important;">Show More</button>
                        	</div></div>
                        
                        <div class="row unlockedBadges">
                        <?php //echo do_shortcode('[badgeos_achievements_list type=badge limit=4]');?>
                      <!--  <?php
	                        $args = array(
								'post_type' => badgeos_get_achievement_types_slugs(),
								'suppress_filters' => false,
								'achievement_relationship' => 'any',
							);
							$badges = badgeos_get_achievements( $args );
							
							foreach($badges as $badge){
								//echo badgeos_render_achievement( $badge->ID) .'<br/>';
								
								echo '<div class="badgeos-item-image col-md-1">';
									echo '<a href="http://localhost:8888/lms/achievement/night-owl/">';
										echo badgeos_get_achievement_post_thumbnail($badge->ID); 
										//'<img width="100" height="100" src="http://localhost:8888/lms/content/uploads/2014/06/736fc1a668feffd4d43d2744ec770dc2-100x100.png" class="badgeos-item-thumbnail wp-post-image" alt="736fc1a668feffd4d43d2744ec770dc2">';
										echo $badge->post_title;
										echo '</a>';
								echo '</div>';
							}
	                        
                        ?>this works....but the badges are a little bit weird, so it needs some work. --> 
                        
                        
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
								</div>
						

                            </div><!--/row unlockedBadges-->
                        
                        <div class="profile-header myProfile-heading"> My Achievements<small>Click on the badges to learn more</small>
                        	<div class="btn-group btn-group-xs pull-right">
                        		<button class="btn btn-default">Show All</button>
                        	</div>
                        </div>
                        	  
                        <div class="row unlockedAchievements">

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
	                            
                            </div><!--/row unlockedAchievements-->
                        
                       <div class="profile-header myProfile-heading"> Locked Badges<small>Click on the badges to learn more</small></div>
                       
                       <div class="row lockedBadges">
	                           <div class="col-md-2">
		                           <img src="http://dummyimage.com/100x100/000/000" />
	                           </div>
	                           <div class="col-md-2">
		                           <img src="http://dummyimage.com/100x100/000/000" />
	                           </div>
	                           <div class="col-md-2">
		                           <img src="http://dummyimage.com/100x100/000/000" />
	                           </div>
	                           <div class="col-md-2">
		                           <img src="http://dummyimage.com/100x100/000/000" />
	                           </div>
	                           <div class="col-md-2">
		                           <img src="http://dummyimage.com/100x100/000/000" />
	                           </div>
	                           <div class="col-md-2">
		                           <img src="http://dummyimage.com/100x100/000/000" />
	                           </div>
                           </div><!--/row lockedBadges-->
                                                  
                                                  
						<div class="profile-header myProfile-heading"> Locked Achievements<small>Click on the badges to learn more</small>
							<div class="btn-group btn-group-xs pull-right">
								<button class="btn btn-default">Show All</button>
							</div>
						</div>
                       
                       <div class="lockedAchievements">
                           <div class="row">
	                           <div class="col-md-2">
		                           <img src="http://dummyimage.com/100x100/000/000" />
	                           </div>
	                           <div class="col-md-2">
		                           <img src="http://dummyimage.com/100x100/000/000" />
	                           </div>
	                           <div class="col-md-2">
		                           <img src="http://dummyimage.com/100x100/000/000" />
	                           </div>
	                           <div class="col-md-2">
		                           <img src="http://dummyimage.com/100x100/000/000" />
	                           </div>
	                           <div class="col-md-2">
		                           <img src="http://dummyimage.com/100x100/000/000" />
	                           </div>
	                           <div class="col-md-2">
		                           <img src="http://dummyimage.com/100x100/000/000" />
	                           </div>
                           </div><!--/row-->
                           <div class="row">
	                           <div class="col-md-2">
		                           <img src="http://dummyimage.com/100x100/000/000" />
	                           </div>
	                           <div class="col-md-2">
		                           <img src="http://dummyimage.com/100x100/000/000" />
	                           </div>
	                           <div class="col-md-2">
		                           <img src="http://dummyimage.com/100x100/000/000" />
	                           </div>
	                           <div class="col-md-2">
		                           <img src="http://dummyimage.com/100x100/000/000" />
	                           </div>
	                           <div class="col-md-2">
		                           <img src="http://dummyimage.com/100x100/000/000" />
	                           </div>
	                           <div class="col-md-2">
		                           <img src="http://dummyimage.com/100x100/000/000" />
	                           </div>
                           </div><!--/row-->
                       </div><!--/lockedAchievements-->
                                                  
					  </div><!--/achievements-->
						  
						<div class="tab-pane" id="account">
							<div class="profile-header"> Recent Orders
								<div class="btn-group btn-group-xs pull-right">
									<button class="btn btn-default">Show all</button>
								</div>
							</div>

							<div class="row recentOrder">
											
								<div class="col-md-4 singleOrder">
									<div class="tiny-user-block clearfix">
										<div class="user-img"> <img src="http://placehold.it/150x150" alt="User"/> </div>
										<h3>Lorem ipsum</h3>
										<ul>
											<li>Order Date: <strong>06/14/2014</strong></li>
											<li>Order Complete: <strong>Open</strong></li>
										</ul>
										<button class="btn btn-sm btn-success">View Order</button>
									</div>
								</div><!--/singleOrder-->
								
								<div class="col-md-4 singleOrder">
									<div class="tiny-user-block clearfix">
										<div class="user-img"> <img src="http://placehold.it/150x150" alt="User"/> </div>
										<h3>Lorem ipsum</h3>
										<ul>
											<li>Order Date: <strong>02/10/2014</strong></li>
											<li>Order Complete: <strong>02/16/2014</strong></li>
										</ul>
										<button class="btn btn-sm btn-success">View Order</button>
									</div>
								</div><!--/singleOrder-->
								
								<div class="col-md-4 singleOrder">
									<div class="tiny-user-block clearfix">
										<div class="user-img"> <img src="http://placehold.it/150x150" alt="User"/> </div>
										<h3>Lorem ipsum</h3>
										<ul>
											<li>Order Date: <strong>10/04/2013</strong></li>
											<li>Order Complete: <strong>Canceled</strong></li>
										</ul>
										<button class="btn btn-sm btn-success">View Order</button>
									</div>
								</div><!--/singleOrder-->
								
								
							</div><!--/row recentOrder-->
							
							<div class="profile-header"> Payment Information</div>
							
							<div class="paymentInfo">
								<table class="table">
									<tr>
		                              <td><strong>Name:</strong></td>
		                              <td><?php echo $user->first_name.' '.$user->last_name; ?></td>
		                              <td><strong>Business:</strong></td>
		                              <td><?php echo get_user_meta($user->ID, 'business_name', true); ?></td>
		                            </tr>
		                            <tr>
		                              <td><strong>Student ID:</strong></td>
		                              <td><?php echo get_user_meta($user->ID, 'student_id', true); ?></td>
		                              <td><strong>Phone:</strong></td>
		                              <td><?php echo get_user_meta($user->ID, 'phone', true); ?></td>
		                            </tr>
		                            <tr>
		                              <td><strong>Credit Card #:</strong></td>
		                              <td>XXXXXXX 8960</td>
		                              <td><strong>Email:</strong></td>
		                              <td><?php echo $user->user_email; ?></td>
		                            </tr>
		                            <tr>
		                              <td><strong>Billing Address:</strong></td>
		                              <td><?php echo ucwords( get_user_meta($user->ID,'address',true) ); ?><br/>
									<?php echo ucwords( get_user_meta($user->ID,'city',true) ); ?>, <?php echo ucwords( get_user_meta($user->ID,'state',true) ); ?> <?php echo ucwords( get_user_meta($user->ID,'postal_code',true) ); ?></td>
		                              <td><strong>Address:</strong></td>
		                              <td><?php echo ucwords( get_user_meta($user->ID,'address',true) ); ?><br/>
									<?php echo ucwords( get_user_meta($user->ID,'city',true) ); ?>, <?php echo ucwords( get_user_meta($user->ID,'state',true) ); ?> <?php echo ucwords( get_user_meta($user->ID,'postal_code',true) ); ?></td>
		                            </tr>
								</table>
								
							</div><!--/paymentInfo-->
						
							<div class="bottomProfileBtns"><button type="button" id="accountBtn" class="btn btn-primary btn-lg btn-block">View Your Courses</button></div> 
						</div><!--/account-->
						  
						<div class="tab-pane" id="progress">
						
							<div class="profile-header"> Course Progress</div>
							
							<div class="powerwidget" id="flotchart-widget-5" data-widget-editbutton="false">
								<div class="inner-spacer">
									<div class="flotchart-container">
										<div id="placeholder2" class="flotchart-placeholder"></div>
									</div>
								</div>
							</div>

							<div class="profile-header"> Optimum Finish Time</div>
							
							<div class="powerwidget" id="flotchart-widget-3" data-widget-editbutton="false">
								<div class="inner-spacer">
									<div class="flotchart-block">
										<div class="flotchart-container">
											<div id="placeholder" class="flotchart-placeholder"></div>
										</div>
									</div>
								</div>
							</div>
						  
						  
						</div><!--/progress-->
						  
						  
						  
						  
						  <div class="tab-pane" id="points">My Points</div>
						</div>
                      
                      <?php the_content(); ?>
                  	</div>
                  </div>
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

