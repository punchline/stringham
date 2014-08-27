<?php
/**
 * @package GrassBlade 
 * @version 1.3.1.1
 */
/*
Plugin Name: GrassBlade - xAPI Companion
Plugin URI: http://www.nextsoftwaresolutions.com
Description: GrassBlade - xAPI Companion is a support tool for Experience API (xAPI) or Tin Can API. You can upload and launch Tin Can content published using Articulate, iSpring, DominKnow, Lectora and more. Can send tracking statements to the LRS on Page View. And, show statements in its Statement Viewer, and much more. 
Author: Next Software Solutions Pvt Ltd
Version: 1.3.1.1
Author URI: https://www.nextsoftwaresolutions.com
*/
define("GRASSBLADE_ADDON_DIR", dirname(__FILE__)."/addons");
include(GRASSBLADE_ADDON_DIR."/grassblade_addons.php");
require_once(GRASSBLADE_ADDON_DIR."/nss_xapi.class.php");
require_once(GRASSBLADE_ADDON_DIR."/nss_xapi_verbs.class.php");
$GrassBladeAddons = new GrassBladeAddons();
$GrassBladeAddons->IncludeFunctionFiles();
define('GRASSBLADE_ICON15', get_bloginfo('wpurl')."/wp-content/plugins/grassblade/img/button-15.png");
//define('GB_DEBUG', true);

function grassblade($attr) {
	 $grassblade_settings = grassblade_settings();
		
	 $shortcode_atts = shortcode_atts ( array(
	 		'id' => 0,
			'version' => '1.0',
			'extra' => '',
			'target' => 'iframe',
			'width' => $grassblade_settings["width"],
			'height' => $grassblade_settings["height"],
			'endpoint' => '',
			'auth' => '',
			'user' => '',
			'pass' => '',
			'src' => '',
			'video'	=> '',
			'activity_name' => '',
			'text' => 'Launch',
			'guest' => false,
			'activity_id' => '',
			'registration' => ''
			), $attr);

	$shortcode_atts = apply_filters("grassblade_shortcode_atts", $shortcode_atts, $attr);

	extract($shortcode_atts);

	if(!empty($id)) {
		$xapi_content = new grassblade_xapi_content();
		$params = $xapi_content->get_shortcode($id, true);
		$shortcode_params = shortcode_atts ($params, $attr);
		if(empty($shortcode_params["title"])) {
			$xapi_content_post = get_post($id);
			$shortcode_params["title"] = @$xapi_content_post->post_title;
		}
		unset($shortcode_params["id"]);
		return grassblade($shortcode_params);
	}
		
    	// Read in existing option value from database
	if(empty($endpoint))
    	$endpoint = $grassblade_settings["endpoint"];

	if(empty($user))
    	$user = $grassblade_settings["user"];

	if(empty($pass))
    	$pass = $grassblade_settings["password"];
	
	if($guest === false)
	$grassblade_tincan_track_guest = $grassblade_settings["track_guest"];
	else
	$grassblade_tincan_track_guest = $guest;
	
	$actor = grassblade_getactor($grassblade_tincan_track_guest, $version);
	
	if(empty($actor))
	return  __( 'Please login.', 'grassblade' );
	
	$actor = rawurlencode(json_encode($actor));
	
	
	if(!empty($auth))
	$auth = rawurlencode($auth);
	else
	$auth = rawurlencode("Basic ".base64_encode($user.":".$pass));

	$endpoint = rawurlencode($endpoint);
	
	if(!empty($activity_id))
	$activity = 'activity_id='.rawurlencode($activity_id);
	else
	$activity = '';
		
	if(empty($registration))
	$registration = "36fc1ee0-2849-4bb9-b697-71cd4cad1b6e";//.grassblade_gen_uuid();
	else if($registration == "auto")
	$registration = grassblade_gen_uuid();
	else if($registration != 0)
	$registration = $registration;
	
	//$content_endpoint = "content_endpoint=".rawurlencode(dirname($src).'/');
	//$content_token = "content_token=".grassblade_gen_uuid();
	
	if($version == "none")
	{
		//Don't change SRC. Supporting Non xAPI Content.
	}
	else if(strpos($src,"?") !== false)
		$src = $src."&actor=".$actor."&auth=".$auth."&endpoint=".$endpoint."&registration=".$registration."&".$activity;//."&".$content_endpoint."&".$content_token;
	else
		$src = $src."?actor=".$actor."&auth=".$auth."&endpoint=".$endpoint."&registration=".$registration."&".$activity;//."&".$content_endpoint."&".$content_token;
	
	if($target == 'iframe')
	$return = "<iframe class='grassblade_iframe' frameBorder='0' src='$src' width='$width' height='$height'></iframe>";
	else if($target == '_blank')
	$return = "<a class='grassblade_launch_link' href='$src' target='_blank'>$text</a>";
	else if($target == '_self')
	$return = "<a class='grassblade_launch_link' href='$src' target='_self'>$text</a>";
	else if($target == 'lightbox')
	{
		$return = grassblade_lightbox($src, $text,$width, $height);
	}
	else //if($target == 'url')
	$return = $src;

	$params = array(
			"src" 	=> $src,
			"actor" => $actor,
			"auth"	=> $auth,
			"activity_id"	=> $activity_id,
			"registration"	=> $registration
		);
	return apply_filters("grassblade_shortcode_return", $return, $params, $shortcode_atts, $attr);
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
function grassblade_getactor($guest = false, $version = "1.0", $user = null)
{
	if(!empty($user->ID))
		$current_user = $user;
	else
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

function grassblade_settings() {
	global $grassblade_xapi_companion;
	return $grassblade_xapi_companion->get_params();
}
class grassblade_xapi_companion {
	public $debug = false;
	function __construct() {
	}
	function run() {
		add_action('admin_menu', array($this, 'admin_menu'), 0);
	}
	function define_fields() {
		if(!empty($this->fields))
			return $this->fields;
		// define the product metadata fields used by this plugin
		$versions = array(
					'0.95' => '0.95',
					'0.9' => '0.9',
					'1.0' => '1.0',
					'none' => 'Not XAPI'
				);

		$domain = grassblade_getdomain();
		$this->fields = array(
			array( 'id' => "lrs_settings", 'label' => __("LRS Settings", "grassblade"), "type" => "html", "subtype" => "field_group_start"),
			array( 'id' => 'endpoint', 'label' => __( 'Endpoint URL', 'grassblade' ), 'placeholder' => '', 'type' => 'text', 'values'=> '', 'never_hide' => true , 'help' => __( 'provided by your LRS, check FAQ below for details', 'grassblade')),
			array( 'id' => 'user', 'label' => __( 'API User', 'grassblade' ), 'placeholder' => '', 'type' => 'text', 'values'=> '', 'never_hide' => true ,'help' => __( 'provided by your LRS, check FAQ below for details', 'grassblade')),
			array( 'id' => 'password', 'label' => __( 'API Password', 'grassblade' ),  'placeholder' => '', 'type' => 'text', 'values'=> '', 'never_hide' => true ,'help' => __( 'provided by your LRS, check FAQ below for details', 'grassblade')),
			array( 'id' => "lrs_settings_end", "type" => "html", "subtype" => "field_group_end"),
			array( 'id' => "content_settings", 'label' => __("Content Settings", "grassblade"), "type" => "html", "subtype" => "field_group_start"),
			array( 'id' => 'width', 'label' => __( 'Width', 'grassblade' ),  'placeholder' => '', 'type' => 'text', 'values'=> '', 'never_hide' => true ,'help' => __('Default width of iframe/lightbox in which content is launched', 'grassblade')),
			array( 'id' => 'height', 'label' => __( 'Height', 'grassblade' ), 'placeholder' => '', 'type' => 'text', 'values'=> '', 'never_hide' => true ,'help' => __('Default height of iframe/lightbox in which content is launched', 'grassblade')),
			array( 'id' => 'version', 'label' => __( 'Version', 'grassblade' ),   'placeholder' => '', 'type' => 'select', 'values'=> $versions, 'never_hide' => true ,'help' => __( 'Default xAPI (Tin Can) version of content. Generally depends on your Authoring Tool.', 'grassblade')),
			array( 'id' => 'track_guest', 'label' => __( 'Track Guest Users', 'grassblade' ),  'placeholder' => '', 'type' => 'checkbox', 'values'=> '', 'never_hide' => true ,'help' => sprintf(__(' Check  to track guest users (Tracked as <b>{"name":"Guest XXX.XXX.XXX.XXX", "actor":{"mbox": "mailto:guest-XXX.XXX.XXX.XXX@%s"}</b>) where <i>XXX.XXX.XXX.XXX</i> is users IP. Not Logged In users will be able to access content, and their page views will also be tracked', 'grassblade'), $domain)),
			array( 'id' => "content_settings_end", "type" => "html", "subtype" => "field_group_end"),
			array( 'id' => "upload_settings", 'label' => __("Upload Settings", "grassblade"), "type" => "html", "subtype" => "field_group_start"),
			array( 'id' => 'dropbox_app_key', 'label' => __( 'Dropbox APP Key', 'grassblade' ),  'placeholder' => '', 'type' => 'text', 'values'=> '', 'never_hide' => true ,'help' => __( 'Required only if you want to upload xAPI Content from Dropbox, Work well with large file.', 'grassblade'). " (<a href='http://www.nextsoftwaresolutions.com/direct-upload-of-tin-can-api-content-from-dropbox-to-wordpress-using-grassblade-xapi-companion/'  target='_blank'>".__('Get your Dropbox App Key, takes less than minutes','grassblade')."</a>)" ),
			array( 'id' => "upload_settings_end", "type" => "html", "subtype" => "field_group_end"),
		);
		$this->fields = apply_filters("grassblade_settings_fields", $this->fields);
	}
	function form() {
			global $post;
			$data = $this->get_params();
			
			$this->define_fields();
		?>
			<div id="grassblade_xapi_settings_form"><table width="100%">
			<?php
				foreach ($this->fields as $field) {
					if($field["type"] == "html" && @$field["subtype"] == "field_group_start") {
						echo "<tr><td colspan='2'  class='grassblade_field_group'>";
						echo "<div class='grassblade_field_group_label'><div class='dashicons dashicons-arrow-down-alt2'></div><span>".$field["label"]."</span></div>";
						echo "<div class='grassblade_field_group_fields' ><table width='100%'>";
						continue;
					}
					if($field["type"] == "html" && @$field["subtype"] == "field_group_end") {
						echo "</table></div></td></tr>";
						continue;
					}

					$value = isset($data[$field['id']])? $data[$field['id']]:'';
					echo '<tr id="field-'.$field['id'].'"><td width="20%" valign="top"><label for="'.$field['id'].'">'.$field['label'].'</label></td><td width="100%">';
					switch ($field['type']) {
						case 'html' :
							echo $field["html"];
						break;
						case 'text' :
							echo '<input  style="width:80%" type="text"  id="'.$field['id'].'" name="'.$field['id'].'" value="'.$value.'" placeholder="'.$field['placeholder'].'"/>';
						break;
						case 'file' :
							echo '<input  style="width:80%" type="file"  id="'.$field['id'].'" name="'.$field['id'].'" value="'.$value.'" placeholder="'.$field['placeholder'].'"/>';
						break;
						case 'number' :
							echo '<input  style="width:80%" type="number" id="'.$field['id'].'" name="'.$field['id'].'" value="'.$value.'" placeholder="'.$field['placeholder'].'"/>';
						break;
						case 'textarea' :
							echo '<textarea   style="width:80%"  id="'.$field['id'].'" name="'.$field['id'].'" placeholder="'.$field['placeholder'].'">'.$value.'</textarea>';
						break;
						case 'checkbox' :
							$checked = !empty($value) ? ' checked=checked' : '';
							echo '<input type="checkbox" id="'.$field['id'].'" name="'.$field['id'].'" value="1"'.$checked.'>';
						break;
						case 'select' :
							echo '<select id="'.$field['id'].'" name="'.$field['id'].'">';
							foreach ($field['values'] as $k => $v) :
								$selected = ($value == $k && $value != '') ? ' selected="selected"' : '';
								echo '<option value="'.$k.'"'.$selected.'>'.$v.'</option>';
							endforeach;
							echo '</select>';
						break;
						case 'select-multiple':
						
							echo '<select id="'.$field['id'].'" name="'.$field['id'].'[]" multiple="multiple">';

							foreach ($field['values'] as $k => $v) :
								if(!is_array($value)) $value = (array) $value;
								$selected = (in_array($k, $value)) ? ' selected="selected"' : '';
								echo '<option value="'.$k.'"'.$selected.'>'.$v.'</option>';
							endforeach;
							echo '</select>';

					}
					if(!empty($field['help'])) {
						echo '<br><small>'.$field['help'].'</small><br><br>';
						echo '</td></tr>';
					}
				}
				?>
				</table>
				<br>
			</div>
		<?php
	
	}
	function set_params($id = null, $value = null) {
		if(!empty($id) && !is_null($value)) {
			update_option("grassblade_tincan_".$id, $value);
			return;
		}
		if( !isset($_POST[ "update_GrassBladeSettings" ]) )
			return;
    	
    	$grassblade_settings_old = $this->get_params();

		$this->define_fields();
		foreach ($this->fields as $field) {
			if($field["type"] == "html") 
				continue;
			switch ($field["id"]) {
				case 'track_guest':
					$value = (isset($_POST[$field["id"]]) && !empty($_POST[$field["id"]]))? 1:0;
					break;
				case 'width':
				case 'height':
        			$value = intVal(@$_POST[$field["id"]]).(strpos(@$_POST[$field["id"]], "%")? "%":"px");

				default:
					$value = trim(@$_POST[$field["id"]]);
					break;
			}
			update_option("grassblade_tincan_".$field["id"], $value);
		}
    	$grassblade_settings_new = $this->get_params();
    	do_action("grassblade_settings_update", $grassblade_settings_old, $grassblade_settings_new);
	}
	function get_params($id = null) {
		if(!empty($id)) {
			return $this->maybe_migrate_field($id, get_option("grassblade_tincan_".$id));
		}

		$this->define_fields();
		$data = array();
		foreach ($this->fields as $key => $field) {
			if($field["type"] == "html") 
				continue;
			$data[$field["id"]] = $this->maybe_migrate_field($field["id"], get_option("grassblade_tincan_".$field["id"]));

			if($field["id"] == "width") {
				$data[$field["id"]] = empty($data[$field["id"]])? "940px":intVal($data[$field["id"]]).(strpos($data[$field["id"]], "%")? "%":"px");
			}
			else if($field["id"] == "height") {
				$data[$field["id"]] = empty($data[$field["id"]])? "640px":intVal($data[$field["id"]]).(strpos($data[$field["id"]], "%")? "%":"px");
			}
		}
		return $data;
	}
	function maybe_migrate_field($field, $data) {
		if(!empty($data))
			return $data;

		if($field == "dropbox_app_key") {
			$dropbox_app_key = get_option("grassblade_dropbox_app_key");
			if(!empty($dropbox_app_key)) {
				update_option("grassblade_tincan_dropbox_app_key", $dropbox_app_key);
			//	delete_option("grassblade_dropbox_app_key");
			}
			return $dropbox_app_key;
		}
	}
	function admin_menu() {
	    add_menu_page("GrassBlade", "GrassBlade", "manage_options", "grassblade-lrs-settings", null, GRASSBLADE_ICON15, null);
	    add_submenu_page("grassblade-lrs-settings", __("GrassBlade Settings", "grassblade"), __("GrassBlade Settings", "grassblade"),'manage_options','grassblade-lrs-settings', array($this, 'menu_page') );
	}
function menu_page() {
    //must check that the user has the required capability 
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.','grassblade') );
    }

    if( isset($_POST[ "update_GrassBladeSettings" ]) ) {
    	$this->set_params();
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

<div id="grassblade_settings_form">
	<?php
	   echo $this->form();
	?>
	<input type="submit" class="button-primary" name="update_GrassBladeSettings" value="<?php _e('Update Settings', 'grassblade') ?>" />
	<?php _e('Don\'t have an LRS? ','grassblade') ?> <a href='http://www.nextsoftwaresolutions.com/learning-record-store' target="_blank"><?php _e(' Find an LRS','grassblade'); ?></a>
</div>
</form>
<br><br>
<?php include(dirname(__FILE__)."/help.php"); ?>
</div>
<?php
}

}
global $grassblade_xapi_companion;
$grassblade_xapi_companion = new grassblade_xapi_companion();
$grassblade_xapi_companion->run();

function grassblade_connect() {
	$grassblade_settings = grassblade_settings();	
	global $xapi, $xapi_verbs;
	$xapi = new NSS_XAPI($grassblade_settings["endpoint"], $grassblade_settings["user"], $grassblade_settings["password"]);
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
	
	$nss_plugin_updater_plugin_remote_path = 'http://license.nextsoftwaresolutions.com/';
	$nss_plugin_updater_plugin_slug = plugin_basename(__FILE__);

	new nss_plugin_updater ($nss_plugin_updater_plugin_remote_path, $nss_plugin_updater_plugin_slug);
}
	
/*** WYSIWYG Button ***/
/*add_action('init', 'add_grassblade_button');  
function add_grassblade_button() {
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )  
   {  
     add_filter('mce_external_plugins', 'add_grassblade_plugin');  
     add_filter('mce_buttons', 'register_grassblade_button');  
   } 
}*/

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

/*function register_grassblade_button($buttons) {
   array_push($buttons, "grassblade");  
   return $buttons;
}*/

/*function add_grassblade_plugin($plugin_array) {  
   $plugin_array['grassblade'] = get_bloginfo('wpurl').'/wp-content/plugins/grassblade/js/grassblade_button.min.js';  
   return $plugin_array;  
} */ 
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
function grassblade_sanitize_filename($file) {
	return preg_replace('/[^A-Za-z0-9\-\_]/', '', $file);
}
add_action( 'add_meta_boxes', 'grassblade_add_to_content_box');
add_filter( 'the_content', 'grassblade_add_to_content_post', 1, 10);
add_action( 'save_post', 'grassblade_add_to_content_save');
add_action( 'admin_notices', 'grassblade_admin_notice_handler');
// Display any errors
function grassblade_admin_notice_handler() {

	$errors = get_option('grassblade_admin_errors');

	if($errors) {
		echo '<div class="error"><p>' . $errors . '</p></div>';
		 update_option('grassblade_admin_errors', false);
	}   

}
function grassblade_admin_notice($message, $type = "error") {
	update_option('grassblade_admin_errors', $message);	
}
/*** WYSIWYG Button ***/
