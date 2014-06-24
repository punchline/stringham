<?php
/**
 * The Sidebar containing the main menu area.
 *
 * @package Stringham
 */
?>

<!--Main Menu-->
<div class="responsive-admin-menu">
	<div class="responsive-menu">ORB
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
			<a href="<?php echo home_url(); ?>" title="Courses"><i class="entypo-keyboard"></i><span> My Courses</span></a>
		</li>
		<li>
			<a href="<?php echo home_url(); ?>" class="submenu" data-id="tables-sub" title="My Profile"><i class="entypo-user"></i><span> My Profile</span></a> 
			<!-- My Profile Sub-Menu -->
			<ul id="tables-sub" class="accordion">
				<li>
					<a href="<?php echo home_url(); ?>" title="Profile"><i class="entypo-user"></i><span> Profile</span></a>
				</li>
				<li>
					<a href="<?php echo home_url(); ?>" title="Achievements"><i class="entypo-trophy"></i><span> Achievements</span></a>
				</li>
				<li>
					<a href="<?php echo home_url(); ?>" title="Account"><i class="entypo-list"></i><span> My Account</span></a>
				</li>
				<li>
					<a href="<?php echo home_url(); ?>" title="Progress"><i class="entypo-rocket"></i><span> My Progress</span></a>
				</li>
				<li>
					<a href="<?php echo home_url(); ?>" title="Points"><i class="entypo-star"></i><span> My Points</span></a>
				</li>
			</ul>
		</li>
		<li>
			<a href="<?php echo home_url(); ?>" title="Online Resources"><i class="fa fa-th"></i><span> Online Resources</span></a> 
		</li>
		<li>
			 <a href="<?php echo home_url(); ?>" title="Purchase"><i class="entypo-basket"></i><span> Pruchase</span></a> 
		</li>
		<li> 
			<a href="<?php echo home_url(); ?>" title="Games"><i class="entypo-paper-plane"></i><span> Stringham Games</span></a> 
		</li>
	</ul>
</div>
<!--/MainMenu-->