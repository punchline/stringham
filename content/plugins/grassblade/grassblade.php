<?php
/**
 * @package GrassBlade 
 * @version 1.1.0.1
 */
/*
Plugin Name: GrassBlade - xAPI Companion
Plugin URI: http://www.nextsoftwaresolutions.com
Description: GrassBlade - xAPI Companion is a support tool for Experience API (xAPI) or Tin Can API. You can upload and launch Tin Can content published using Articulate, iSpring, DominKnow, Lectora and more. Can send tracking statements to the LRS on Page View. And, show statements in its Statement Viewer, and much more. 
Author: Next Software Solutions Pvt Ltd
Version: 1.1.0.1
Author URI: https://www.nextsoftwaresolutions.com
*/
define("GRASSBLADE_ADDON_DIR", dirname(__FILE__)."/addons");
include(GRASSBLADE_ADDON_DIR."/grassblade_addons.php");
require_once(GRASSBLADE_ADDON_DIR."/nss_xapi.class.php");
require_once(GRASSBLADE_ADDON_DIR."/nss_xapi_verbs.class.php");
$GrassBladeAddons = new GrassBladeAddons();
define('GRASSBLADE_ICON15', get_bloginfo('wpurl')."/wp-content/plugins/grassblade/img/button-15.png");
define('GB_DEBUG', true);

function grassblade($attr) {
		$grassblade_tincan_width = get_option( 'grassblade_tincan_width');
		$grassblade_tincan_height = get_option( 'grassblade_tincan_height');
		$grassblade_tincan_width = empty($grassblade_tincan_width)? "940px":intVal($grassblade_tincan_width).(strpos($grassblade_tincan_width, "%")? "%":"px");
		$grassblade_tincan_height = empty($grassblade_tincan_height)? "640px":intVal($grassblade_tincan_height).(strpos($grassblade_tincan_height, "%")? "%":"px");
		
	 $shortcode_atts = shortcode_atts ( array(
	 		'id' => 0,
			'version' => '1.0',
			'extra' => '',
			'target' => 'iframe',
			'width' => $grassblade_tincan_width,
			'height' => $grassblade_tincan_height,
			'endpoint' => '',
			'auth' => '',
			'user' => '',
			'pass' => '',
			'src' => '',
			'text' => 'Launch',
			'guest' => false,
			'activity_id' => '',
			'registration' => ''
			), $attr);

	extract($shortcode_atts);

	if(!empty($id)) {
		$xapi_content = new grassblade_xapi_content();
		$params = $xapi_content->get_shortcode($id, true);
		$shortcode_params = shortcode_atts ($params, $attr);
		unset($shortcode_params["id"]);
		return grassblade($shortcode_params);
	}
		
    	// Read in existing option value from database
	if(empty($endpoint))
    	$endpoint = get_option( 'grassblade_tincan_endpoint' );

	if(empty($user))
    	$user = get_option('grassblade_tincan_user');

	if(empty($pass))
    	$pass = get_option('grassblade_tincan_password');
	
	if($guest === false)
	$grassblade_tincan_track_guest = get_option('grassblade_tincan_track_guest');
	else
	$grassblade_tincan_track_guest = $guest;
	
	$actor = grassblade_getactor($grassblade_tincan_track_guest, $version);
	
	if(empty($actor))
	return  __( 'Please login.', 'grassblade' );
	
	$actor = "actor=".rawurlencode(json_encode($actor));
	
	
	if(!empty($auth))
	$auth = "auth=".rawurlencode($auth);
	else
	$auth = "auth=".rawurlencode("Basic ".base64_encode($user.":".$pass));

	$endpoint = 'endpoint='.rawurlencode($endpoint);
	
	if(!empty($activity_id))
	$activity = 'activity_id='.rawurlencode($activity_id);
	
	if(empty($registration))
	$registration = "registration=36fc1ee0-2849-4bb9-b697-71cd4cad1b6e";//.grassblade_gen_uuid();
	else if($registration == "auto")
	$registration = "registration=".grassblade_gen_uuid();
	else if($registration != 0)
	$registration = "registration=".$registration;
	
	//$content_endpoint = "content_endpoint=".rawurlencode(dirname($src).'/');
	//$content_token = "content_token=".grassblade_gen_uuid();
	
	if($version == "none")
	{
		//Don't change SRC. Supporting Non xAPI Content.
	}
	else if(strpos($src,"?") !== false)
		$src = $src."&".$actor."&".$auth."&".$endpoint."&".$activity."&".$registration;//."&".$content_endpoint."&".$content_token;
	else
		$src = $src."?".$actor."&".$auth."&".$endpoint."&".$activity."&".$registration;//."&".$content_endpoint."&".$content_token;
	
	if($target == 'iframe')
	return "<iframe class='grassblade_iframe' frameBorder='0' src='$src' width='$width' height='$height'></iframe>";
	else if($target == '_blank')
	return "<a class='grassblade_launch_link' href='$src' target='_blank'>$text</a>";
	else if($target == '_self')
	return "<a class='grassblade_launch_link' href='$src' target='_self'>$text</a>";
	else if($target == 'lightbox')
	{
		return grassblade_lightbox($src, $text,$width, $height);
	}
	else //if($target == 'url')
	return $src;
}
	function grassblade_scripts() {
		wp_enqueue_script(
			'grassblade',
			plugins_url('/js/script.js', __FILE__),
			array('jquery'), null
		);
	}
	function grassblade_styles() {
		wp_enqueue_style(
			'grassblade',
			plugins_url('/css/styles.css', __FILE__),
			null, null
		);
	}
	add_action("init", "grassblade_styles");
	add_action("init", "grassblade_scripts");
	function grassblade_lightbox($src, $text, $width, $height) {
		$return = '';
		$id = 'grassblade_'.md5($src);
		$return .= "<a class='grassblade_launch_link' class='grassblade_lightbox' href='#' onClick='grassblade_show_lightbox(\"$id\", \"$src\", \"$width\", \"$height\");return false;'>$text</a>";
		return $return;
	}
	function grassblade_gen_uuid() {
		return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			// 32 bits for "time_low"
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

			// 16 bits for "time_mid"
			mt_rand( 0, 0xffff ),

			// 16 bits for "time_hi_and_version",
			// four most significant bits holds version number 4
			mt_rand( 0, 0x0fff ) | 0x4000,

			// 16 bits, 8 bits for "clk_seq_hi_res",
			// 8 bits for "clk_seq_low",
			// two most significant bits holds zero and one for variant DCE1.1
			mt_rand( 0, 0x3fff ) | 0x8000,

			// 48 bits for "node"
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
		);
	}
function grassblade_textdomain() {
 $plugin_dir = basename(dirname(__FILE__));
 load_plugin_textdomain( 'grassblade', $plugin_dir."/languages", $plugin_dir."/languages" );
}
add_action('plugins_loaded', 'grassblade_textdomain');



function grassblade_getdomain()
{
	$domain = $_SERVER["HTTP_HOST"];
	
	if(empty($domain))
	$domain = $_SERVER["SERVER_NAME"];
	
	if(filter_var($domain, FILTER_VALIDATE_IP))
	return $domain.".com";
	else
	return $domain;
}
function grassblade_getactor($guest = false, $version = "1.0")
{
	$current_user = wp_get_current_user();

	if(empty($current_user->ID))
	{
		if(empty($guest))
			return false;
		else
		{
			$guest_mailto = "mailto:guest-".$_SERVER['REMOTE_ADDR'].'@'.grassblade_getdomain();
			$guest_name = "Guest ".$_SERVER['REMOTE_ADDR'];
			if($version == "0.90")
				$actor = array('mbox' => array($guest_mailto), 'name' => array($guest_name), "objectType" =>  "Agent");
			else
				$actor = array('mbox' => $guest_mailto, 'name' => $guest_name, "objectType" =>  "Agent");			
				
			return $actor;
		}
	}
	
	if(!empty($current_user->display_name))
	$name = $current_user->display_name;
	else
	if(!empty($current_user->user_firstname) || !empty($current_user->user_firstname))
	$name = $current_user->user_firstname." ".$current_user->user_lastname;
	else
	$name = $current_user->user_login;
	
	$mbox = "mailto:".grassblade_user_email($current_user->ID);
	if($version == "0.90")
	$actor = array('mbox' => array($mbox), 'name' => array($name), "objectType" =>  "Agent");
	else
	$actor = array('mbox' => $mbox, 'name' => $name, "objectType" =>  "Agent");

	return $actor;
}
add_shortcode("grassblade", "grassblade");

function grassblade_user_email($user_id) {
	$email = get_user_meta($user_id, "grassblade_email", true);
	if(!empty($email))
		return $email;
	$user = get_user_by("id", $user_id);
	update_user_meta($user_id, "grassblade_email", $user->user_email);
	return $user->user_email;
}
function get_user_by_grassblade_email($email) {
	$users = get_users("meta_key=grassblade_email&meta_value=".$email);
	if(!empty($users[0]))
		return $users[0];

	return get_user_by("email", $email);
}
add_action('admin_menu', 'grassblade_menu', 0);
function grassblade_menu() {
    add_menu_page("GrassBlade", "GrassBlade", "manage_options", "grassblade-lrs-settings", null, GRASSBLADE_ICON15, null);
    add_submenu_page("grassblade-lrs-settings", "GrassBlade Settings", "GrassBlade Settings",'manage_options','grassblade-lrs-settings', 'grassblade_menu_page');
	
}
function grassblade_settings() {
	$grassblade_tincan_endpoint = get_option( 'grassblade_tincan_endpoint' );
    if(empty($grassblade_tincan_endpoint)) 
    $grassblade_tincan_endpoint = "";
    $grassblade_tincan_user = get_option('grassblade_tincan_user');
    $grassblade_tincan_password = get_option('grassblade_tincan_password');
    $grassblade_tincan_version = get_option('grassblade_tincan_version');
    $grassblade_tincan_track_guest = get_option('grassblade_tincan_track_guest');
    $grassblade_tincan_width = get_option('grassblade_tincan_width');
    $grassblade_tincan_height = get_option('grassblade_tincan_height');
	$grassblade_dropbox_app_key = get_option('grassblade_dropbox_app_key');
    
	$grassblade_tincan_width = empty($grassblade_tincan_width)? "940px":intVal($grassblade_tincan_width).(strpos($grassblade_tincan_width, "%")? "%":"px");
	$grassblade_tincan_height = empty($grassblade_tincan_height)? "640px":intVal($grassblade_tincan_height).(strpos($grassblade_tincan_height, "%")? "%":"px");

	return array(
			"grassblade_tincan_endpoint" => $grassblade_tincan_endpoint,
			"grassblade_tincan_user" => $grassblade_tincan_user,
			"grassblade_tincan_password" => $grassblade_tincan_password,
			"grassblade_tincan_version" => $grassblade_tincan_version,
			"grassblade_tincan_track_guest" => $grassblade_tincan_track_guest,
			"grassblade_tincan_width" => $grassblade_tincan_width,
			"grassblade_tincan_height" => $grassblade_tincan_height,
			"grassblade_dropbox_app_key" => $grassblade_dropbox_app_key
		);
}
function grassblade_menu_page() {
    //must check that the user has the required capability 
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.','grassblade') );
    }

    // Read in existing option value from database
    $grassblade_tincan_endpoint = get_option( 'grassblade_tincan_endpoint' );
    if(empty($grassblade_tincan_endpoint)) 
    $grassblade_tincan_endpoint = "";
    $grassblade_tincan_user = get_option('grassblade_tincan_user');
    $grassblade_tincan_password = get_option('grassblade_tincan_password');
    $grassblade_tincan_version = get_option('grassblade_tincan_version');
    $grassblade_tincan_track_guest = get_option('grassblade_tincan_track_guest');
    $grassblade_tincan_width = get_option('grassblade_tincan_width');
    $grassblade_tincan_height = get_option('grassblade_tincan_height');
	$grassblade_dropbox_app_key = get_option('grassblade_dropbox_app_key');
    
	$grassblade_tincan_width = empty($grassblade_tincan_width)? "940px":intVal($grassblade_tincan_width).(strpos($grassblade_tincan_width, "%")? "%":"px");
	$grassblade_tincan_height = empty($grassblade_tincan_height)? "640px":intVal($grassblade_tincan_height).(strpos($grassblade_tincan_height, "%")? "%":"px");
	
    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ "update_GrassBladeSettings" ]) ) {
        // Read their posted value
        $grassblade_tincan_endpoint = trim($_POST['grassblade_tincan_endpoint']);
        $grassblade_tincan_user = trim($_POST['grassblade_tincan_user']);
        $grassblade_tincan_password = trim($_POST['grassblade_tincan_password']);
        $grassblade_tincan_version = trim($_POST['grassblade_tincan_version']);
		$grassblade_tincan_track_guest = (isset($_POST['grassblade_tincan_track_guest']) && !empty($_POST['grassblade_tincan_track_guest']))? 1:0;
        $grassblade_tincan_width = intVal($_POST['grassblade_tincan_width']).(strpos($_POST['grassblade_tincan_width'], "%")? "%":"px");
        $grassblade_tincan_height = intVal($_POST['grassblade_tincan_height']).(strpos($_POST['grassblade_tincan_height'], "%")? "%":"px");
		$grassblade_dropbox_app_key = trim($_POST['grassblade_dropbox_app_key']);
		

        // Save the posted value in the database
        update_option( 'grassblade_tincan_endpoint', $grassblade_tincan_endpoint);
        update_option( 'grassblade_tincan_user', $grassblade_tincan_user);
        update_option( 'grassblade_tincan_password', $grassblade_tincan_password);
        update_option( 'grassblade_tincan_track_guest', $grassblade_tincan_track_guest);
        update_option( 'grassblade_tincan_width', $grassblade_tincan_width);
        update_option( 'grassblade_tincan_height', $grassblade_tincan_height);
        update_option( 'grassblade_tincan_version', $grassblade_tincan_version);
		update_option( 'grassblade_dropbox_app_key', $grassblade_dropbox_app_key);

        // Put an settings updated message on the screen

?>
<div class="updated"><p><strong><?php _e('settings saved.', 'grassblade' ); ?></strong></p></div>
<?php

    }
?>
<div class=wrap>
<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
<h2><img style="top: 6px; position: relative;" src="<?php echo plugins_url('img/icon_30x30.png', __FILE__); ?>"/>
<?php _e('GrassBlade Settings', 'grassblade'); ?></h2>
<h3><?php _e('Endpoint URL', 'grassblade'); ?> <small class="description"> <?php _e('(provided by your LRS, check FAQ below for details)', 'grassblade'); ?></small> :</h3>
<input name="grassblade_tincan_endpoint" style="min-width:30%" value="<?php echo   _e(apply_filters('format_to_edit',$grassblade_tincan_endpoint), 'grassblade') ?>" />

<h3><?php _e('User', 'grassblade'); ?> <small class="description"> <?php _e('(provided by your LRS, check FAQ below for details)', 'grassblade'); ?></small> :</h3>
<input name="grassblade_tincan_user" style="min-width:30%" value="<?php echo   _e(apply_filters('format_to_edit',$grassblade_tincan_user), 'grassblade') ?>" />
<h3><?php _e('Password', 'grassblade'); ?> <small class="description"> <?php echo _e('(provided by your LRS, check FAQ below for details)', 'grassblade'); ?></small> :</h3>
<input name="grassblade_tincan_password" style="min-width:30%" value="<?php echo   _e(apply_filters('format_to_edit',$grassblade_tincan_password), 'grassblade') ?>" />
<h3><?php _e('Version', 'grassblade'); ?> <small class="description"> <?php _e('(Default xAPI (Tin Can) version of content)', 'grassblade'); ?></small> :</h3>
<select name="grassblade_tincan_version" style="min-width:30%">
	<option value="1.0" <?php if($grassblade_tincan_version == "1.0") echo "SELECTED"; ?>>1.0</option>
	<option value="0.95" <?php if($grassblade_tincan_version == "0.95") echo "SELECTED"; ?>>0.95</option>
	<option value="0.90" <?php if($grassblade_tincan_version == "0.90") echo "SELECTED"; ?>>0.90</option>
</select>
<h3><?php _e('Track Guest Users', 'grassblade'); ?> <small class="description"> <?php _e('(Not Logged In users will be able to access content, and their page views will also be tracked)','grassblade'); ?></small> :</h3>
<input name="grassblade_tincan_track_guest" style="min-width:5px" type="checkbox" <?php if($grassblade_tincan_track_guest) echo "CHECKED";?> /><?php $domain = grassblade_getdomain();  echo sprintf(__(' Check  to track guest users (Tracked as <b>{"name":"Guest XXX.XXX.XXX.XXX", "actor":{"mbox": "mailto:guest-XXX.XXX.XXX.XXX@%s"}</b>) where <i>XXX.XXX.XXX.XXX</i> is users IP.', 'grassblade'), $domain); ?>
<h3><?php _e('Width', 'grassblade'); ?> <small class="description"><?php _e('(Default width of iframe in which content is launched)','grassblade') ?></small> :</h3>
<input name="grassblade_tincan_width" style="min-width:30%" value="<?php echo   _e(apply_filters('format_to_edit',$grassblade_tincan_width), 'grassblade') ?>" />
<h3><?php _e('Height', 'grassblade'); ?> <small class="description"><?php _e('(Default height of iframe in which content is launched)','grassblade') ?></small> :</h3>
<input name="grassblade_tincan_height" style="min-width:30%" value="<?php echo   _e(apply_filters('format_to_edit',$grassblade_tincan_height), 'grassblade') ?>" />
<h3><?php _e('Dropbox App Key', 'grassblade'); ?> <small class="description"><?php _e('(Required only if you want to upload xAPI Content from Dropbox, Work well with large file.)','grassblade');?></small> :</h3>
<input name="grassblade_dropbox_app_key" style="min-width:30%" value="<?php echo   _e(apply_filters('format_to_edit',$grassblade_dropbox_app_key), 'grassblade') ?>" /> (<?php echo "<a href='http://www.nextsoftwaresolutions.com/direct-upload-of-tin-can-api-content-from-dropbox-to-wordpress-using-grassblade-xapi-companion/'  target='_blank'>".__('Get your Dropbox App Key, takes less than minutes','grassblade')."</a>";  ?>)

<div class="submit">
<input type="submit" name="update_GrassBladeSettings" value="<?php _e('Update Settings', 'grassblade') ?>" /></div>
</form>
<?php _e('Don\'t have an LRS? ','grassblade') ?> <a href='http://www.nextsoftwaresolutions.com/learning-record-store' target="_blank"><?php _e(' Find an LRS','grassblade'); ?></a>
<br><br>
<?php include(dirname(__FILE__)."/help.php"); ?>
</div>
<?php
}

function grassblade_connect() {
	$grassblade_tincan_endpoint = get_option( 'grassblade_tincan_endpoint' );
	$grassblade_tincan_user = get_option('grassblade_tincan_user');
	$grassblade_tincan_password = get_option('grassblade_tincan_password');
	$grassblade_tincan_track_guest = get_option('grassblade_tincan_track_guest');		
	global $xapi, $xapi_verbs;
	$xapi = new NSS_XAPI($grassblade_tincan_endpoint, $grassblade_tincan_user, $grassblade_tincan_password);
	$xapi_verbs = new NSS_XAPI_Verbs();
}
grassblade_connect();


function grassblade_plugin_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=grassblade-lrs-settings">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}

function grassblade_getverb($verb) {
	global $xapi_verbs;
	return $xapi_verbs->get_verb($verb);
}
function grassblade_getobject($id, $name, $description, $type, $objectType = 'Activity') {
	global $xapi;
	return $xapi->set_object($id, $name, $description, $type, $objectType);
}
function get_statement($atts) {
	global $xapi;
	$shortcode_atts = shortcode_atts(array(
			'statementId' => '',
			'voidedStatementId' => '',
			'email' => '',
			'agent' => '',//Object
			'actor' => '',//Object
			'version' => null,
			'guest' => false,
			'verb' => '', //IRI
			'activity' => '', //IRI
			'object' => '', //Object
			'registration' => '', //UUID
			'show' => 'array',
			//'related_activities' => false,
			//'related_agents' => false,
			'since' => '', //Timestamp: Only Statements stored since the specified timestamp (exclusive) are returned.
			'until' => '', //Timestamp: Only Statements stored at or before the specified timestamp are returned.
			//'format' => 'exact', // ids, exact, canonical
			//'attachments' => false,
			//'ascending' => false,
			'context' => false,
			'authoritative' => false,
			'sparse' => false,
			'limit' => 1,
			), $atts);

	//extract($shortcode_atts);

	$show = $shortcode_atts['show'];
	unset($shortcode_atts['show']);
	
	if(empty($shortcode_atts['email'])) {
		$actor = grassblade_getactor($shortcode_atts['guest'], $shortcode_atts['version']);
	} else {
		$email = $shortcode_atts['email'];
		if( $email != "none" ) {
			$actor = array(
							"objectType" =>	"Agent",
							"mbox" => "mailto:".$email
						);
		}
	}
	if(!empty($actor))
		$shortcode_atts['actor'] = $actor;
	
	if(!empty($shortcode_atts['activity']) && isset($shortcode_atts['version']) && $shortcode_atts['version'] < "1.0") {
		$shortcode_atts['object'] = array(
			"id" => $shortcode_atts['activity'],
			"objectType" => "Activity"
			);
		unset($shortcode_atts['activity']);
	}
	unset($shortcode_atts['guest']);
	unset($shortcode_atts['version']);
	unset($shortcode_atts["email"]);	
	
	foreach($shortcode_atts as $key=>$value) {
		if($value === "")
		unset($shortcode_atts[$key]);
	}	

	$statements = $xapi->GetStatements($shortcode_atts, 1);
	if(empty($statements['statements'][0]))
		return '';
	if($shortcode_atts['limit'] > 1)
	$statements = (array) $statements['statements'];
	else
	$statements = (array) $statements['statements'][0];
	
	if($show == '')
	return (array) $statements;
	if($show == 'array')
	return "<pre>".print_r($statements, true)."</pre>";
	
	$show = explode(".", $show);
	$value = (array) $statements;
	foreach($show as $key) {
		if(!isset($value[$key]))
			return "";
		$value = (is_object($value[$key]))? (array) $value[$key]:$value[$key];
	}
	return print_r($value, true);
}
add_shortcode("get_statement", "get_statement");
// Add settings link on plugin page 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'grassblade_plugin_settings_link' );

add_action('init', 'nss_plugin_updater_activate_grassblade');

function nss_plugin_updater_activate_grassblade()
{
	if(!class_exists('nss_plugin_updater'))
	require_once ('wp_autoupdate.php');
	
	$nss_plugin_updater_plugin_remote_path = 'http://www.nextsoftwaresolutions.com/';
	$nss_plugin_updater_plugin_slug = plugin_basename(__FILE__);

	new nss_plugin_updater ($nss_plugin_updater_plugin_remote_path, $nss_plugin_updater_plugin_slug);
}
	
/*** WYSIWYG Button ***/
add_action('init', 'add_grassblade_button');  
function add_grassblade_button() {
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )  
   {  
     add_filter('mce_external_plugins', 'add_grassblade_plugin');  
     add_filter('mce_buttons', 'register_grassblade_button');  
   } 
}

function grassblade_debug($msg) {
	$original_log_errors = ini_get('log_errors');
	$original_error_log = ini_get('error_log');
	ini_set('log_errors', true);
	ini_set('error_log', dirname(__FILE__).DIRECTORY_SEPARATOR.'debug.log');
	
	global $processing_id;
	if(empty($processing_id))
	$processing_id	= time();
	
	if(isset($_GET['debug']) || defined('GB_DEBUG'))
	
	error_log("[$processing_id] ".print_r($msg, true)); //Comment This line to stop logging debug messages.
	
	ini_set('log_errors', $original_log_errors);
	ini_set('error_log', $original_error_log);		
}

function grassblade_send_statements($statements) {
	global $xapi;
	if(empty($xapi))
		return $false;
	
	return $xapi->SendStatements($statements);
}

function register_grassblade_button($buttons) {
   array_push($buttons, "grassblade");  
   return $buttons;
}

function add_grassblade_plugin($plugin_array) {  
   $plugin_array['grassblade'] = get_bloginfo('wpurl').'/wp-content/plugins/grassblade/js/grassblade_button.min.js';  
   return $plugin_array;  
}  
function grassblade_add_to_content_box() {
	$post_types = get_post_types();
	foreach ($post_types as $post_type) {
		add_meta_box( 
			'grassblade_add_to_content_box',
			__( 'xAPI Content', 'grassblade' ),
			'grassblade_add_to_content_box_content',
			$post_type,
			'side',
			'high'
		);
	}
}
function grassblade_add_to_content_save($post_id) {
	$post = get_post( $post_id);
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
	return;

	if ( !isset($_POST['grassblade_add_to_content_box_content_nonce']) || !wp_verify_nonce( $_POST['grassblade_add_to_content_box_content_nonce'], plugin_basename( __FILE__ ) ) )
	return;

	if ( 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) )
		return;
	} else {
		if ( !current_user_can( 'edit_post', $post_id ) )
		return;
	}

	if(isset($_POST['show_xapi_content']))
		update_post_meta($post_id, "show_xapi_content", $_POST['show_xapi_content']);
}
function grassblade_add_to_content_box_content() {
	global $post;
	wp_nonce_field( plugin_basename( __FILE__ ), 'grassblade_add_to_content_box_content_nonce' );

	if($post->post_type != "gb_xapi_content") {
		$xapi_contents = get_posts("post_type=gb_xapi_content&orderby=post_title&posts_per_page=-1");
		$selected_id = get_post_meta($post->ID, "show_xapi_content", true);

		?>
		<div id="grassblade_add_to_content">
		<b><?php _e("Add to Page:", "grassblade"); ?> <a href='<?php echo admin_url('post-new.php?post_type=gb_xapi_content'); ?>'><?php _e("Add New", "grassblade"); ?></a></b><br>
		<select name="show_xapi_content" id="show_xapi_content" onChange="">
			<option value="0"> -- <?php _e("Select", "grassblade"); ?> -- </option>
			<?php 
				foreach ($xapi_contents as $xapi_content) { 
					$completion_tracking = grassblade_xapi_content::is_completion_tracking_enabled($xapi_content->ID);
					$selected = ($selected_id == $xapi_content->ID)? 'selected="selected"':''; ?>
					<option value="<?php echo $xapi_content->ID; ?>" completion-tracking="<?php echo $completion_tracking; ?>" <?php echo $selected; ?>><?php echo $xapi_content->post_title; ?></option>		
			<?php } ?>
		</select>
		<a href="#" id="grassblade_add_to_content_edit_link" onClick="post_id = document.getElementById('show_xapi_content').value; if(post_id > 0) window.location = '<?php admin_url("post.php"); ?>?action=edit&message=1&post=' + post_id; return false;" style="<?php if(empty($selected_id)) echo 'display:none'; ?>"><?php _e("Edit", "grassblade"); ?></a>
		<br>
		<div>
			<a href="#" onClick="post_id = document.getElementById('show_xapi_content').value; if(post_id > 0) window.location = '<?php admin_url("post.php"); ?>?action=edit&message=1&post=' + post_id; return false;">
			<div id="completion_tracking_enabled" style="display:none;">
				<?php _e("Completion Tracking Enabled."); ?>
			</div>
			<div id="completion_tracking_disabled" style="display:none;">
				<?php _e("Completion Tracking Disabled."); ?>
			</div>
			</a>
		</div>
			<div>
				<br>
				<input name="save" type="submit" class="button button-primary button-large" value="Update">
			</div>
		</div>
		<?php 
	}
	else
	{
		$completion_tracking = grassblade_xapi_content::is_completion_tracking_enabled($post->ID);
		$xapi_contents = grassblade_get_post_with_content($post->ID);

		if(empty($xapi_contents)) {
			 _e("This xAPI Content is not added to any post/page.", "grassblade");
		}
		else 
		{
			echo "<b>".__("Added on:", "grassblade")."</b><div id='xapi_posts_list'><ul>";
			foreach($xapi_contents as $xapi_content) {
				echo "<li><a href='".get_edit_post_link($xapi_content->ID)."'>".$xapi_content->post_title."</a></li>";

			}
			echo "</ul></div>";

			if($completion_tracking) { ?>
				<div id="completion_tracking_enabled">
					<?php _e("Completion Tracking Enabled."); ?>
				</div>
			<?php } else { ?>
				<div id="completion_tracking_disabled">
					<?php _e("Completion Tracking Disabled."); ?>
				</div>
			<?php 
			}
		}
	}

}
function grassblade_get_post_with_content($content_id) {
	if(empty($content_id) || !is_numeric($content_id)) 
		return array();
	else
	{
		return get_posts("post_type=any&orderby=post_title&meta_key=show_xapi_content&posts_per_page=-1&meta_value=".$content_id);
	}
}
function grassblade_add_to_content_post($content) {
	global $post;
	$selected_id = get_post_meta($post->ID, "show_xapi_content", true);
	if(!empty($selected_id)) {
		$content .= do_shortcode('[grassblade id='.$selected_id."]");
		$completion_tracking = grassblade_xapi_content::is_completion_tracking_enabled($selected_id);
		$gb_completion_tracking_alert = apply_filters("gb_completion_tracking_alert", __("Click OK to confirm that you have completed the content above?", "grassblade"), $post->ID, $selected_id);
		if($completion_tracking && !empty($gb_completion_tracking_alert)) {
			$content .= ' <script> jQuery(function() { jQuery("form#sfwd-mark-complete").submit(function(e) { var completed_course=confirm("'.$gb_completion_tracking_alert.'"); if(completed_course == false) e.preventDefault();}); });</script> ';
		}

	}
	return $content;
}
function file_get_contents_curl($url) {
        $url = str_replace(" ", "%20", $url);
        $url = str_replace("(", "%28", $url);
        $url = str_replace(")", "%29", $url);
        $ch = curl_init();
        $timeout = 5;
        $userAgent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)";
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
}
function sanitize_filename($file) {
	return preg_replace("([^\w\s\d\-_~,;:\[\]\(\].]|[\.]{2,})", '', $file);
}
add_action( 'add_meta_boxes', 'grassblade_add_to_content_box');
add_filter( 'the_content', 'grassblade_add_to_content_post', 1, 10);
add_action( 'save_post', 'grassblade_add_to_content_save');

/*** WYSIWYG Button ***/
$GrassBladeAddons->IncludeFunctionFiles();

