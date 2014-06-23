<?php
//require_once(dirname(__FILE__)."/../nss_xapi.class.php");
//require_once(dirname(__FILE__)."/pv_xapi.class.php");
 
add_action('admin_menu', 'grassblade_grassbladelrs_menu', 1);
function grassblade_grassbladelrs_menu() {
	add_submenu_page("grassblade-lrs-settings", "GrassBlade LRS", "GrassBlade LRS",'manage_options','grassbladelrs-settings', 'grassblade_grassbladelrs_menupage');
}

function grassblade_grassbladelrs_menupage()
{
   //must check that the user has the required capability 
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }

    $grassblade_settings = grassblade_settings();
    $endpoint = $grassblade_settings["grassblade_tincan_endpoint"];
    $api_user = $grassblade_settings["grassblade_tincan_user"];
    $api_pass = $grassblade_settings["grassblade_tincan_password"];
    $sso_auth = file_get_contents_curl($endpoint."?api_user=".$api_user."&api_pass=".$api_pass);
    $sso_auth = json_decode($sso_auth);
    if(!empty($sso_auth) && !empty($sso_auth->sso_auth_token)) {
    	?>
		<div class="wrap">
    	<iframe width="100%" height="1000px" src="<?php echo $endpoint."?sso_auth_token=".$sso_auth->sso_auth_token; ?>"></iframe>
    	</div>
    	<?php
    }
    else {
	?>
		<div class=wrap>
		<h2><img style="top: 6px; position: relative;" src="<?php echo plugins_url('img/icon_30x30.png', dirname(dirname(__FILE__))); ?>"/>
		GrassBlade LRS</h2>
		<br>
		<?php echo sprintf(__("Please install %s and configure the API credentials to use this LRS Management Page"), "<a href='http://www.nextsoftwaresolutions.com/grassblade-lrs-experience-api/' target='_blank'>GrassBlade LRS</a>"); ?>
		</div>
	<?php
	}
}
