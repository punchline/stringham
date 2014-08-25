<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Stringham
 */
 
 //if( !is_user_logged_in() ) wp_redirect( home_url('login') );
 
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<!--Smooth Scroll-->
	<div class="smooth-overflow">
		<!--Navigation-->
		<nav class="main-header clearfix" role="navigation"> <a class="navbar-brand" href="<?php echo home_url(); ?>"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/logo.png"/></a>			
			<!--Navigation Itself-->
			<div class="navbar-content"> 
		        <!--Fullscreen Trigger-->
		        <button type="button" class="btn btn-default hidden-xs pull-right" id="toggle-fullscreen"> <i class=" entypo-popup"></i> </button>
        	</div>
        </nav>
        <!--/Navigation--> 
    
		<!--MainWrapper-->
		<div class="main-wrap"> 
      
				<!--Content Wrapper-->
				<div class="content-wrapper main-content-toggle-left"> 
					