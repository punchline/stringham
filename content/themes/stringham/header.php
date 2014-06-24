<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Stringham
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/vendors/modernizr/modernizr.custom.js"></script>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<!--Smooth Scroll-->
	<div class="smooth-overflow">
		<!--Navigation-->
		<nav class="main-header clearfix" role="navigation"> <a class="navbar-brand" href="<?php echo home_url(); ?>"><span class="text-blue">ORB</span></a> 
      
			<!--Search-->
			<div class="site-search">
				<form action="<?php echo home_url(); ?>" id="inline-search" method="get">
					<i class="fa fa-search"></i>
					<input type="search" name="s" placeholder="Search">
				</form>
			</div>
			
			<!--Navigation Itself-->
      
			<div class="navbar-content"> 
        
		        <!--Sidebar Toggler--> 
		        <a href="#" class="btn btn-default left-toggler"><i class="fa fa-bars"></i></a> 
		        <!--Right Userbar Toggler--> 
		        <a href="#" class="btn btn-user right-toggler pull-right"><i class="entypo-vcard"></i> <span class="logged-as hidden-xs">Logged as</span><span class="logged-as-name hidden-xs">Anton Durant</span></a> 
		        <!--Fullscreen Trigger-->
		        <button type="button" class="btn btn-default hidden-xs pull-right" id="toggle-fullscreen"> <i class=" entypo-popup"></i> </button>
        
				<!--Settings Dropdown-->
				<div class="btn-group pull-right">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> <i class="entypo-cog"></i></button>
					<div id="settings-dropdown" class="dropdown-menu keep_open orb-form">
						<div class="dropdown-header">Settings <span class="badge pull-right">6</span></div>
						<div class="dropdown-container">
							<div class="nano">
								<div class="nano-content">
									<ul class="settings-dropdown">
										<li>
											<label class="toggle">
											<input type="checkbox" name="checkbox-toggle" checked>
											<i></i>Prevent Midnblow</label>
										</li>
										<li>
											<label class="toggle">
											<input type="checkbox" name="checkbox-toggle" checked>
											<i></i>Sleep All nights</label>
										</li>
										<li>
											<label class="toggle">
											<input type="checkbox" name="checkbox-toggle" checked>
											<i></i>Drink more Coffee</label>
										</li>
										<li>
											<label class="toggle">
											<input type="checkbox" name="checkbox-toggle" checked>
											<i></i>Auto feed cat</label>
											</li>
										<li>
											<label class="toggle">
											<input type="checkbox" name="checkbox-toggle" checked>
											<i></i>Dummy Checkbox</label>
										</li>
										<li>
											<label class="toggle">
											<input type="checkbox" name="checkbox-toggle" checked>
											<i></i>Read More Books</label>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="dropdown-footer"> <a class="btn btn-dark" href="#">Save</a> </div>
					</div>
				</div>
        
		        <!--Lock Screen--> 
		        <a href="#" data-toggle="modal" class="btn btn-default hidden-xs pull-right lockme"> <i class="entypo-lock"></i> </a> 
        
		        <!--Notifications Dropdown-->
        
				<div class="btn-group">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> <i class="entypo-megaphone"></i><span class="new"></span></button>
					<div id="notification-dropdown" class="dropdown-menu">
						<div class="dropdown-header">
							Notifications <span class="badge pull-right">8</span>
						</div>
						<div class="dropdown-container">
							<div class="nano">
								<div class="nano-content">
									<ul class="notification-dropdown">
										<li class="bg-warning">
											<a href="#"> 
												<span class="notification-icon"><i class="fa fa-bolt"></i></span>
												<h4>Server Down</h4>
												<p>Server #435 was shut down (Power loss)</p>
												<span class="label label-default"><i class="entypo-clock"></i> 59 mins ago</span> 
											</a> 
										</li>
										<li class="bg-info">
											<a href="#"> 
												<span class="notification-icon"><i class="fa fa-bolt"></i></span>
												<h4>Too Many Connections</h4>
												<p>Too many connections to Database Server</p>
												<span class="label label-default"><i class="entypo-clock"></i> 2 hours ago</span> 
											</a> 
										</li>
										<li class="bg-danger">
											<a href="#"> 
												<span class="notification-icon"><i class="fa fa-android"></i></span>
												<h4>Sausage Stolen</h4>
												<p>Someone stole your hot sausage</p>
												<span class="label label-default"><i class="entypo-clock"></i> 3 hours ago</span> 
											</a> 
										</li>
										<li class="bg-success">
											<a href="#"> 
												<span class="notification-icon"><i class="fa fa-bolt"></i></span>
												<h4>Defragmentation Completed</h4>
												<p>Disc Defragmentation Completed on Server</p>
												<span class="label label-default"><i class="entypo-clock"></i> 3 hours ago</span> 
											</a> 
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="dropdown-footer">
							<a class="btn btn-dark" href="#">See All</a>
						</div>
					</div>
				</div>
        
				<!--Inbox Dropdown-->
				<div class="btn-group">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="entypo-mail"></i><span class="new"></span></button>
					<div id="inbox-dropdown" class="dropdown-menu inbox">
						<div class="dropdown-header">
							Inbox <span class="badge pull-right">32</span>
						</div>
						<div class="dropdown-container">
							<div class="nano">
								<div class="nano-content">
									<ul class="inbox-dropdown">
										<li><a href="#"> <span class="user-image"><img src="http://placehold.it/150x150" alt="Gluck Dorris" /></span>
										<h4>Why don't u answer calls?</h4>
										<p>Listen, dude, time is off. I'll find you soon! Sounds good?...</p>
										<span class="label label-default"><i class="entypo-clock"></i> 59 mins ago</span> <span class="delete"><i class="entypo-back"></i></span> </a> </li>
										<li><a href="#"> <span class="user-image"><img src="http://placehold.it/150x150" alt="Gluck Dorris" /></span>
										<h4>Rawrr, rawrrr...</h4>
										<p>Listen, dude, time is off. I'll find you soon! Sounds good?...</p>
										<span class="label label-default"><i class="entypo-clock"></i> 2 hours ago</span> <span class="delete"><i class="entypo-back"></i></span> </a> </li>
										<li><a href="#"> <span class="user-image"><img src="http://placehold.it/150x150" alt="Gluck Dorris" /></span>
										<h4>Why so serious?</h4>
										<p>Listen, dude, time is off. I'll find you soon! Sounds good?...</p>
										<span class="label label-default"><i class="entypo-clock"></i> 3 hours ago</span> <span class="delete"><i class="entypo-back"></i></span> </a> </li>
									</ul>
								</div>
							</div>
						</div>
						<div class="dropdown-footer"><a class="btn btn-dark" href="admin-inbox.html">Save All</a></div>
					</div>
				</div>
        	</div>
        </nav>
        <!--/Navigation--> 
    
		<!--MainWrapper-->
		<div class="main-wrap"> 
		
			<?php get_sidebar('right'); ?>
      
			<?php get_sidebar('left'); ?>
      
				<!--Content Wrapper-->
				<div class="content-wrapper"> 
					<!--Horisontal Dropdown-->
					<nav class="cbp-hsmenu-wrapper" id="cbp-hsmenu-wrapper">
						<div class="cbp-hsinner">
							<ul class="cbp-hsmenu">
								<li> <a href="#"><span class="icon-bar"></span></a>
									<ul class="cbp-hssubmenu">
										<li>
											<a href="#">
												<div class="sparkle-dropdown">
													<span class="inlinebar">10,8,8,7,8,9,7,8,10,9,7,5</span>
													<p class="sparkle-name">project income</p>
													<p class="sparkle-amount">$23989 <i class="fa fa-chevron-circle-up"></i></p>
												</div>
											</a>
										</li>
										<li>
											<a href="#">
												<div class="sparkle-dropdown">
													<span class="linechart">5,6,7,9,9,5,3,2,9,4,6,7</span>
													<p class="sparkle-name">site traffic</p>
													<p class="sparkle-amount">122541 <i class="fa fa-chevron-circle-down"></i></p>
												</div>
											</a>
										</li>
										<li>
											<a href="#">
												<div class="sparkle-dropdown">
													<span class="simpleline">9,6,7,9,3,5,7,2,1,8,6,7</span>
													<p class="sparkle-name">Processes</p>
													<p class="sparkle-amount">890 <i class="fa fa-plus-circle"></i></p>
												</div>
											</a>
										</li>
										<li>
											<a href="#">
												<div class="sparkle-dropdown">
													<span class="inlinebar">10,8,8,7,8,9,7,8,10,9,7,5</span>
													<p class="sparkle-name">orders</p>
													<p class="sparkle-amount">$23989 <i class="fa fa-chevron-circle-up"></i></p>
												</div>
											</a>
										</li>
										<li>
											<a href="#">
												<div class="sparkle-dropdown">
													<span class="piechart">1,2,3</span>
													<p class="sparkle-name">active/new</p>
													<p class="sparkle-amount">500/200 <i class="fa fa-chevron-circle-up"></i></p>
												</div>
											</a>
										</li>
										<li>
											<a href="#">
												<div class="sparkle-dropdown">
													<span class="stackedbar">3:6,2:8,8:4,5:8,3:6,9:4,8:1,5:7,4:8,9:5,3:5</span>
													<p class="sparkle-name">fault/success</p>
													<p class="sparkle-amount">$23989 <i class="fa fa-chevron-circle-up"></i></p>
												</div>
											</a>
										</li>
									</ul>
								</li>
							</ul>
						</div>
					</nav>