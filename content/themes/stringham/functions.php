<?php
/**
 * Stringham functions and definitions
 *
 * @package Stringham
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'stringham_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function stringham_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Stringham, use a find and replace
	 * to change 'stringham' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'stringham', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'stringham' ),
	) );
	
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link'
	) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'stringham_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // stringham_setup
add_action( 'after_setup_theme', 'stringham_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function stringham_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'stringham' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'stringham_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function stringham_scripts() {
	wp_enqueue_style( 'stringham-style', get_stylesheet_uri() );
	
	/* Bootstrap Javascript Files */
	wp_register_script( 'bootstrap-js', get_stylesheet_directory_uri() . '/js/vendors/bootstrap/bootstrap.min.js', array(), '3.1.1', TRUE );
	wp_register_script( 'bootstrap-modal', get_stylesheet_directory_uri() . '/js/vendors/animation/animation.js', array('bootstrap-js'), '3.1.1', TRUE );
	wp_register_script( 'bootstrap-dropdown', get_stylesheet_directory_uri() . '/js/vendors/bootstrap-hover-dropdown/bootstrap-hover-dropdown.js', array('bootstrap.js'), '', TRUE );
	wp_register_script( 'bootstrap-progress-bar', get_stylesheet_directory_uri() . '/js/vendors/bootstrap-progress-bar/bootstrap-progress-bar.js', array('bootstrap.js'), '', TRUE );
	
	
	/* End Bootstrap Javascript */
	
	// Chart.JS		- html5 charts and graphs
	// http://chartjs.org/
	wp_register_script( 'chart-js', get_stylesheet_directory_uri() . '/js/vendors/chartjs/chart.min.js', array(), '2013', TRUE );
	
	
	//CLASSIE.JS
	//https://github.com/desandro/classie
	wp_register_script( 'classie-js', get_stylesheet_directory_uri() . '/js/vendors/classie/classie.js', array(), '1.0.1', TRUE );
	
	/* Datatables Javascript Files  */
	// http://datatables.net/
	// https://github.com/DataTables/ColVis
	wp_register_script( 'colvis', get_stylesheet_directory_uri() . '/js/vendors/datatables/colvis.extra.js', array(), '1.1.2', TRUE );
	wp_register_script( 'data-tables', get_stylesheet_directory_uri() . '/js/vendors/datatables/dataTables.colVis.js', array(), '1.1.0', TRUE );
	wp_register_script( 'data-tables-bootstrap', get_stylesheet_directory_uri() . '/js/vendors/datatables/jquery.dataTables-bootstrap.js', array(''), '', TRUE );
	wp_register_script( 'data-tables-min', get_stylesheet_directory_uri() . '/js/vendors/datatables/jquery.dataTables.min.js', array(''), '1.9.4', TRUE );
	/* End Datatable Files */
	
	//Easing.JS
	// http://gsgd.co.uk/sandbox/jquery/easing/
	wp_register_script( 'easing-js', get_stylesheet_directory_uri() . '/js/vendors/easing/jquery.easing.1.3.min.js', array(''), '1.3', TRUE );
	
	//EasyPie.JS
	// https://github.com/rendro/easy-pie-chart
	wp_register_script( 'easy-pie-js', get_stylesheet_directory_uri() . '/js/vendors/easypie/jquery.easypiechart.min.js', array(''), '2.1.5', TRUE );
	
	//FitVids.JS
	// https://github.com/davatron5000/FitVids.js
	wp_register_script( 'fit-vids-js', get_stylesheet_directory_uri() . '/js/vendors/fitvids/jquery.fitvids.js', array(''), '1.1', TRUE );
	
	
	/* FlotChart JavaScript Files */
	// https://github.com/flot/flot/blob/master/API.md
	// http://www.flotcharts.org/
	wp_register_script( 'flot-tooltip-js', get_stylesheet_directory_uri() . '/js/vendors/flotchart/jquery.flot-tooltip.js', array(''), '0.4.4', TRUE );
	wp_register_script( 'flot-axis-labels-js', get_stylesheet_directory_uri() . '/js/vendors/flotchart/jquery.flot.axislabels.js', array(''), '2010', TRUE );
	wp_register_script( 'flot-categories-js', get_stylesheet_directory_uri() . '/js/vendors/flotchart/jquery.flot.categories.min.js', array(''), '2013', TRUE );
	wp_register_script( 'flot-min-js', get_stylesheet_directory_uri() . '/js/vendors/flotchart/jquery.flot.min.js', array(''), '0.8.1', TRUE );
	wp_register_script( 'flot-pie-js', get_stylesheet_directory_uri() . '/js/vendors/flotchart/jquery.flot.pie.min.js', array(''), '', TRUE );
	wp_register_script( 'flot-resize-js', get_stylesheet_directory_uri() . '/js/vendors/flotchart/jquery.flot.resize.min.js', array(''), '1.1', TRUE );
	wp_register_script( 'flot-selection-js', get_stylesheet_directory_uri() . '/js/vendors/flotchart/jquery.flot.selection.min.js', array(''), '2013', TRUE );
	wp_register_script( 'flot-stack-js', get_stylesheet_directory_uri() . '/js/vendors/flotchart/jquery.flot.stack.min.js', array(''), '2013', TRUE );
	wp_register_script( 'flot-time-js', get_stylesheet_directory_uri() . '/js/vendors/flotchart/jquery.flot.time.min.js', array(''), '2013', TRUE );
	
	/* End FlotChart JavaScript Files */
	
	/* Forms JavaScript Files */
	// http://digitalbush.com/projects/masked-input-plugin/
	wp_register_script( 'masked-input-js', get_stylesheet_directory_uri() . '/js/vendors/forms/jquery.maskedinput.min.js', array(''), '1.3.1', TRUE );
	// https://github.com/jzaefferer/jquery-validation
	// http://jqueryvalidation.org/
	wp_register_script( 'validate-js', get_stylesheet_directory_uri() . '/js/vendors/forms/jquery.validate.min.js', array(''), '1.11.0', TRUE );
	
	/* End Form Javascript Files */
	
	/* Full Calendar JavaScript Files */
	// http://arshaw.com/fullcalendar/
	wp_register_script( 'full-calendar-js', get_stylesheet_directory_uri() . '/js/vendors/fullcalendar/fullcalendar.min.js', array(''), '2.0.1', TRUE );
	wp_register_script( 'gcal-js', get_stylesheet_directory_uri() . '/js/vendors/fullcalendar/gcal.js', array(''), '1.6.4', TRUE );
	
	/* End Full Calendar JavaScript Files */
	
	// FullScreen.JS
	// https://github.com/sindresorhus/screenfull.js
	wp_register_script( 'fullscreen-js', get_stylesheet_directory_uri() . '/js/vendors/fullscreen/screenfull.min.js', array(''), '1.1.1', TRUE );
	
	// Horisontal.JS
	// http://tympanus.net/codrops/2013/05/17/horizontal-slide-out-menu/
	wp_register_script( 'horisontal-js', get_stylesheet_directory_uri() . '/js/vendors/horisontal/cbpHorizontalSlideOutMenu.js', array('jQuery'), '1.0.0', TRUE );
	
	// IonRangeSlider.JS
	// https://github.com/IonDen/ion.rangeSlider
	// http://ionden.com/a/plugins/ion.rangeSlider/en.html
	wp_register_script( 'range-slider-js', get_stylesheet_directory_uri() . '/js/vendors/ionrangeslider/ion.rangeSlider.min.js', array('jQuery'), '1.9.1', TRUE );
	
	// jQuerySteps.JS
	// https://github.com/rstaib/jquery-steps/wiki
	wp_register_script( 'jquery-steps-js', get_stylesheet_directory_uri() . '/js/vendors/jquery-steps/jquery.steps.min.js', array(''), '1.0.4', TRUE );
	
	// JustGauge.JS
	// http://justgage.com/
	wp_register_script( 'just-gauge-js', get_stylesheet_directory_uri() . '/js/vendors/just-gauge/justgage.1.0.1.min.js', array(''), '1.0.1', TRUE );
	
	// Knob.JS
	// https://github.com/aterrien/jQuery-Knob
	wp_register_script( 'knob-js', get_stylesheet_directory_uri() . '/js/vendors/knob/jquery.knob.js', array(''), '1.2.8', TRUE );
	
	// Modernizr.JS
	// http://modernizr.com/docs/
	wp_register_script( 'modernizr-js', get_stylesheet_directory_uri() . '/js/vendors/modernizr/modernizr.custom.js', array(''), '2.6.2', TRUE );
	
	// Morris.JS
	// https://github.com/morrisjs/morris.js/
	wp_register_script( 'morris-min-js', get_stylesheet_directory_uri() . '/js/vendors/morris/morris.min.js', array(''), '0.5.1', TRUE );
	
	// Nestable-Lists.JS
	// https://github.com/dbushell/Nestable
	wp_register_script( 'nestable-lists-js', get_stylesheet_directory_uri() . '/js/vendors/nestable-lists/jquery.nestable.js', array(''), '2012', TRUE );
	
	/* PowerWidgets JavaScript Files */
	wp_register_script( 'powerwidgets-js', get_stylesheet_directory_uri() . '/js/vendors/powerwidgets/powerwidgets.js', array(''), '2014', TRUE );
	wp_register_script( 'powerwidgets-min-js', get_stylesheet_directory_uri() . '/js/vendors/powerwidgets/powerwidgets.min.js', array(''), '2014', TRUE );
	
	/* End PowerWidgets JavaScript Files */
	
	// Raphael.JS
	// http://raphaeljs.com/reference.html
	wp_register_script( 'raphael-js', get_stylesheet_directory_uri() . '/js/vendors/raphael/raphael-min.js', array(''), '2.1.2', TRUE );
	
	// SparkLine.JS
	// http://omnipotent.net/jquery.sparkline/#s-docs
	wp_register_script( 'sparkline-js', get_stylesheet_directory_uri() . '/js/vendors/sparkline/jquery.sparkline.min.js', array(''), '2.1.2', TRUE );
	
	// Summernote.JS
	// https://github.com/HackerWins/summernote
	wp_register_script( 'summernote-js', get_stylesheet_directory_uri() . '/js/vendors/summernote/summernote.min.js', array(''), '', TRUE );
	
	// TouchPunch.JS
	// https://github.com/furf/jquery-ui-touch-punch/
	wp_register_script( 'touch-punch-js', get_stylesheet_directory_uri() . '/js/vendors/touch-punch/jquery.ui.touch-punch.min.js', array(''), '', TRUE );
	
	/* X-Editable JavaScript Files */
	wp_register_script( 'address-js', get_stylesheet_directory_uri() . '/js/vendors/x-editable/address.js', array(''), '', TRUE );
	wp_register_script( 'boostrap-editable-js', get_stylesheet_directory_uri() . '/js/vendors/x-editable/bootstrap-editable.min.js', array(''), '1.5.1', TRUE );
	wp_register_script( 'demo-mock-js', get_stylesheet_directory_uri() . '/js/vendors/x-editable/demo-mock.js', array(''), '', TRUE );
	wp_register_script( 'demo-js', get_stylesheet_directory_uri() . '/js/vendors/x-editable/demo.js', array(''), '', TRUE );
	wp_register_script( 'mockjax-js', get_stylesheet_directory_uri() . '/js/vendors/x-editable/jquery.mockjax.js', array(''), '1.5.0', TRUE );
	wp_register_script( 'moment-js', get_stylesheet_directory_uri() . '/js/vendors/x-editable/moment.min.js', array(''), '2.0.0', TRUE );
	wp_register_script( 'select2-js', get_stylesheet_directory_uri() . '/js/vendors/x-editable/select2.js', array(''), '3.4.4', TRUE );
	wp_register_script( 'typehead-js', get_stylesheet_directory_uri() . '/js/vendors/x-editable/typeahead.js', array(''), '0.9.3', TRUE );
	wp_register_script( 'typehead-js-js', get_stylesheet_directory_uri() . '/js/vendors/x-editable/typeaheadjs.js', array(''), '1.5.0', TRUE );
	/* End X-Editable JavaScript Files */
	
	

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'stringham_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
