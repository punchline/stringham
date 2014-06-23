<?php

$wp_include = "../wp-load.php";
$i = 0;
while (!file_exists($wp_include) && $i++ < 10) {
  $wp_include = "../$wp_include";
}

// let's load WordPress
require($wp_include);

if ( !is_user_logged_in() || !current_user_can('edit_posts') ) 
	wp_die(__('You are not allowed to be here','grassblade'));

	
	$grassblade_tincan_endpoint = get_option( 'grassblade_tincan_endpoint');
	$grassblade_tincan_user = get_option( 'grassblade_tincan_user');
	$grassblade_tincan_password = get_option( 'grassblade_tincan_password');
	$grassblade_tincan_width = get_option( 'grassblade_tincan_width');
	$grassblade_tincan_height = get_option( 'grassblade_tincan_height');
	$grassblade_tincan_version = get_option( 'grassblade_tincan_version');
	$grassblade_tincan_width = empty($grassblade_tincan_width)? "940px":intVal($grassblade_tincan_width)."px";
	$grassblade_tincan_height = empty($grassblade_tincan_height)? "640px":intVal($grassblade_tincan_height)."px";	
	$grassblade_tincan_guest = get_option( 'grassblade_tincan_guest');	
	
	$global_setting_url = get_bloginfo('wpurl').'/wp-admin/options-general.php?page=grassblade-lrs-settings';
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>GrassBlade - xAPI Shortcode Generator</title>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-content/plugins/grassblade/js/grassblade_popup.min.js"></script>
<link href="<?php echo get_option('siteurl') ?>/wp-content/plugins/grassblade/css/grassblade_popup.css" rel="stylesheet" type="text/css">

<div id="grassbladepopup">


<select id="form_type" onChange="select_form()">
	<option value="0">Select what you want to do</option>
	<option value="add_content">I want to add a TinCan/xAPI Content on this page.</option>	
</select>
<br><br>
<form id="add_content" style="display:none;">
<table style="width: 100%;">
	<tr><td colspan="2"><b>Add a TinCan/xAPI Content on this Page</b></td></tr>
	<tr><td width="250">Content Url (Required):</td><td><input type="text" id="content_url" name="content_url" style="width:100%"></td></tr>
	<tr><td>Activity Id:</td><td><input type="text" id="content_activity_id" name="content_activity_id" style="width:100%"><br><small>Needs to be a unique URI identifying your content.</small></td><br>
	</tr>	
	<tr><td colspan="2"><a href="#" onclick="return showHideOptional('optional_content_parameters')">Show/Hide Optional Parameters</a></td></tr>
	<tr><td colspan="2">
		<table id="optional_content_parameters" style="display:none; margin-left: 20px;">
			<tr><td colspan="2"><b>Optional Parameters</b></td></tr>
			<tr><td>Width:</td><td><input type="text" id="content_width" name="content_width"><br><small>Global: <?php echo  $grassblade_tincan_width ?></small></td></tr>
			<tr><td>Height:</td><td><input type="text" id="content_height" name="content_height"><br><small>Global: <?php echo  $grassblade_tincan_height ?></small></td></tr>
			<tr><td>Endpoint:</td><td><input type="text" id="content_endpoint" name="content_endpoint"><br><small>Global: <?php echo  $grassblade_tincan_endpoint ?></small></td></tr>
			<tr><td>User:</td><td><input type="text" id="content_user" name="content_user"><br><small>Global: <?php echo  $grassblade_tincan_user ?></small></td></tr>
			<tr><td>Pass:</td><td><input type="text" id="content_pass" name="content_pass"><br><small>Global: <?php echo  $grassblade_tincan_password ?></small></td></tr>
			<tr><td>Version:</td>
				<td><select name="grassblade_tincan_version" id="content_version" style="min-width:30%">
					<option value="">Use Global</option>
					<option value="1.0">1.0</option>
					<option value="0.95">0.95</option>
					<option value="0.90">0.90</option>
					<option value="none">Not xAPI</option>
				</select>
				<br>
				<small>Global: <?php echo  $grassblade_tincan_version ?></small></td></tr>
			<tr>
				
			<tr><td>Where to launch this content?</td><td>
				<select name="grassblade_tincan_target" id="content_target" style="min-width:30%">
					<option value="">In Page (Default)</option>
					<option value="_blank">Link to open in New Window</option>
					<option value="lightbox">Link to open in Popup Lightbox</option>
				</select>
				</td><br>
			</tr>	
			<tr><td>Link text if opening in new window or lightbox?</td><td>
				<input type="text" id="content_text" name="content_text"><br><small>Default: "Launch"</small>
				</td><br>
			</tr>			
			<tr><td>Disable Guest access for this content?</td><td>
				<select name="grassblade_tincan_guest" id="content_guest" style="min-width:30%">
					<option value="">Use Global</option>
					<option value="1">Guests can access</option>
					<option value="0">Require Login</option>
				</select>
				<br>
				<small>Global: <?php ($grassblade_tincan_guest)? _e('Guests can access','grassblade'): _e('Require Login','grassblade'); ?></small>
				</td>
			</tr>			
		</table>
		</td>
	</tr>
	<tr><td></td><td> </td></tr>
	<tr>
		<td><input type="button" value="Insert Code" class="button" onclick="add_grassblade_shortcode()"></td><td></td>
	</tr>
</table>
</form>
<br>
<?php
if(empty($grassblade_tincan_endpoint) || empty($grassblade_tincan_user) || empty($grassblade_tincan_password)) 
{
echo '<div class="warning">'. _e('Warning! Global LRS settings is not complete. ','grassblade').'<a target="_blank" href='.$global_setting_url.'>'. _e('Click here to update', 'grassblade'). '</a> </div>';
}
else
echo '<div class="info"><a target="_blank" href='.$global_setting_url.'>'. _e(' Click here ', 'grassblade'). '</a> '. _e('to change your global settings.','grassblade').'</div>';
?>
<input type="button" value="Close Me" class="button" onclick="closepopup();"> 

</div>