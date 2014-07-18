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
	<?php wp_head(); ?>
</head>

<body>
		<!--MainWrapper-->
		<div class="main-wrap-login"> 
      
				<!--Content Wrapper-->
				<div class="content-wrapper-login"> 
					