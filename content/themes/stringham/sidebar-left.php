<?php
/**
 * The Sidebar containing the main menu area.
 *
 * @package Stringham
 */
?>

<!--Main Menu-->
<div class="responsive-admin-menu">
	<div class="responsive-menu"><img src="<?php echo get_template_directory_uri();?>/images/white-logo.png"/ >
		<div class="menuicon"><i class="fa fa-angle-down"></i></div>
	</div>
	
	<ul id="menu">
		<li>
			<a href="<?php echo home_url(); ?>" title="Dashboard" data-id="dash-sub"><i class="entypo-briefcase"></i><span> Dashboard</span></a>
		</li>
		<li>
			<a href="<?php echo home_url('inbox'); ?>" title="Inbox"><i class="entypo-inbox"></i><span> Inbox <span class="badge">32</span></span></a>
		</li>
		<li>
			<a href="<?php echo home_url('courses'); ?>" title="Courses"><i class="entypo-keyboard"></i><span> My Courses</span></a>
		</li>
		<li>
			<a href="<?php echo home_url(); ?>" class="submenu" data-id="tables-sub" title="My Profile"><i class="entypo-user"></i><span> My Profile</span></a> 
			<!-- My Profile Sub-Menu -->
			<ul id="tables-sub" class="accordion">
				<li>
					<a href="<?php echo home_url('profile'); ?>" title="Profile"><i class="entypo-user"></i><span> Profile</span></a>
				</li>
				<li>
					<a href="<?php echo home_url('profile/#achievements'); ?>" title="Achievements"><i class="entypo-trophy"></i><span> Achievements</span></a>
				</li>
				<li>
					<a href="<?php echo home_url('profile/#account'); ?>" title="Account"><i class="entypo-list"></i><span> My Account</span></a>
				</li>
				<li>
					<a href="<?php echo home_url('profile/#progress'); ?>" title="Progress"><i class="entypo-rocket"></i><span> My Progress</span></a>
				</li>
				<li>
					<a href="<?php echo home_url('profile/#points'); ?>" title="Points"><i class="entypo-star"></i><span> My Points</span></a>
				</li>
			</ul>
		</li>
		<li>
			<a href="<?php echo home_url('online-resources'); ?>" title="Online Resources"><i class="fa fa-th"></i><span> Online Resources</span></a> 
		</li>
		<li>
			 <a href="<?php echo home_url(); ?>" title="Purchase"><i class="entypo-basket"></i><span> Purchase</span></a> 
		</li>
		<li> 
			<a href="<?php echo home_url('games'); ?>" title="Games"><i class="fa fa-gamepad"></i><span> Stringham Games</span></a> 
		</li>
	</ul>
</div>
<!--/MainMenu-->