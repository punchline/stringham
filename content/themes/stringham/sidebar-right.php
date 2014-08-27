<?php
/**
 * The Sidebar containing the right user menu area.
 *
 * @package Stringham
 */
 
 $user = wp_get_current_user();
?>

<!--OffCanvas Menu -->
<aside class="user-menu"> 

	<!-- Tabs -->
	<div class="tabs-offcanvas">
		<div class="tab-content"> 
		
			<!--User Primary Panel-->
			<div class="tab-pane active" id="userbar-one">
				<div class="main-info">
					<div class="user-img"><img src="http://placehold.it/150x150" alt="User Picture" /></div>
					<h1><?php echo get_user_name($user->ID); ?> <small>Administrator</small></h1>
				</div>
				<div class="list-group"> <a href="#" class="list-group-item"><i class="fa fa-user"></i>Profile</a> <a href="#" class="list-group-item"><i class="fa fa-cog"></i>Settings</a> <a href="#" class="list-group-item"><i class="fa fa-flask"></i>Projects<span class="badge">2</span></a>
					<div class="empthy"></div>
					<a href="#" class="list-group-item"><i class="fa fa-refresh"></i>Updates<span class="badge">5</span></a>
					<a href="#" class="list-group-item"><i class="fa fa-comment"></i>Messages<span class="badge">12</span></a>
					<a href="#" class="list-group-item"><i class="fa fa-comments"></i> Comments<span class="badge">45</span></a>
					<a data-toggle="modal" href="<?php echo wp_logout_url(); ?>" class="list-group-item goaway"><i class="fa fa-power-off"></i> Sign Out</a>
				</div>
			</div>
			
		</div>
	</div>
	<!-- /tabs --> 

</aside>
<!-- /Offcanvas user menu--> 