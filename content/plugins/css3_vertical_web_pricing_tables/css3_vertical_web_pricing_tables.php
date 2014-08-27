<?php
/*
Plugin Name: CSS3 Vertical Web Pricing Tables
Plugin URI: http://www.screenr.com/C3us
Description: CSS3 Vertical Web Pricing Tables plugin.
Author: QuanticaLabs
Author URI: http://codecanyon.net/user/QuanticaLabs/portfolio?ref=QuanticaLabs
Version: 1.6
*/

//admin
if(is_admin())
{
	function css3_vertical_table_admin_init()
	{
		wp_register_script('css3_vertical_table_admin', plugins_url('js/css3_vertical_web_pricing_tables_admin.js', __FILE__), array(), "1.0");
		//wp_register_script('css3_vertical_table_jquery-ui-custom', plugins_url('js/jquery-ui-1.7.3.custom.min.js', __FILE__));
		wp_register_script('jquery-ui-slider', plugins_url('js/jquery.ui.slider.js', __FILE__), array('jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-mouse'));
		wp_register_style('css3_vertical_table_style_admin', plugins_url('admin/style.css', __FILE__));
		wp_register_style('css3_vertical_table_jquery-ui-custom', plugins_url('admin/jquery-ui-1.7.3.custom.css', __FILE__));
		wp_register_style('css3_vertical_table_font_sans_narrow', 'http://fonts.googleapis.com/css?family=PT+Sans+Narrow');
		wp_register_style('css3_vertical_table_font_sans_condensed', 'http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300');
		wp_register_style('css3_table_style', plugins_url('style/css3_table_style.css', __FILE__));
		/*wp_register_style('css3_vertical_table_main', plugins_url('style/main.css', __FILE__));
		wp_register_style('css3_vertical_table_style1', plugins_url('style/style1.css', __FILE__));
		wp_register_style('css3_vertical_table_style2', plugins_url('style/style2.css', __FILE__));
		wp_register_style('css3_vertical_table_style3', plugins_url('style/style3.css', __FILE__));
		wp_register_style('css3_vertical_table_style4', plugins_url('style/style4.css', __FILE__));
		wp_register_style('css3_vertical_table_style5', plugins_url('style/style5.css', __FILE__));
		wp_register_style('css3_vertical_table_style6', plugins_url('style/style6.css', __FILE__));
		wp_register_style('css3_vertical_table_style7', plugins_url('style/style7.css', __FILE__));
		wp_register_style('css3_vertical_table_style8', plugins_url('style/style8.css', __FILE__));
		wp_register_style('css3_vertical_table_style9', plugins_url('style/style9.css', __FILE__));
		wp_register_style('css3_vertical_table_style10', plugins_url('style/style10.css', __FILE__));*/
	}
	add_action('admin_init', 'css3_vertical_table_admin_init');

	function css3_vertical_table_admin_print_scripts()
	{
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-widget');
		wp_enqueue_script('jquery-ui-mouse');
		wp_enqueue_script('jquery-ui-slider');
		//wp_enqueue_script('css3_vertical_table_jquery-ui-custom');
		wp_enqueue_script('css3_vertical_table_admin');
		//pass data to javascript
		$data = array(
			'imgUrl' =>  plugins_url('img/', __FILE__)
		);
		wp_localize_script('css3_vertical_table_admin', 'config', $data );
		wp_enqueue_style('css3_vertical_table_font_sans_narrow');
		wp_enqueue_style('css3_vertical_table_font_sans_condensed');
		wp_enqueue_style('css3_vertical_table_style_admin');
		wp_enqueue_style('css3_vertical_table_jquery-ui-custom');
		wp_enqueue_style('css3_table_style');
		/*wp_print_styles(array(
			'css3_vertical_table_font_sans_narrow',
			'css3_vertical_table_font_sans_condensed',
			'css3_vertical_table_style_admin',
			'css3_vertical_table_jquery-ui-custom',
			'css3_vertical_table_main',
			'css3_vertical_table_style1',
			'css3_vertical_table_style2',
			'css3_vertical_table_style3',
			'css3_vertical_table_style4',
			'css3_vertical_table_style5',
			'css3_vertical_table_style6',
			'css3_vertical_table_style7',
			'css3_vertical_table_style8',
			'css3_vertical_table_style9',
			'css3_vertical_table_style10'
		));*/
	}
	
	function css3_vertical_table_admin_menu()
	{	
		$page = add_options_page('CSS3 Vertical Web Pricing Tables', 'CSS3 Vertical Web Pricing Tables', 'administrator', 'css3_vertical_table_admin', 'css3_vertical_table_admin_page');
		add_action('admin_print_scripts-' . $page, 'css3_vertical_table_admin_print_scripts');
	}
	add_action('admin_menu', 'css3_vertical_table_admin_menu');
	
	function css3_vertical_table_stripslashes_deep($value)
	{
		$value = is_array($value) ?
					array_map('stripslashes_deep', $value) :
					stripslashes($value);

		return $value;
	}
	function css3_vertical_table_ajax_get_settings()
	{
		echo json_encode(css3_vertical_table_stripslashes_deep(get_option('css3_vertical_table_shortcode_settings_' . $_POST["id"])));
		exit();
	}
	add_action('wp_ajax_css3_vertical_table_get_settings', 'css3_vertical_table_ajax_get_settings');
	
	function css3_vertical_table_ajax_delete()
	{
		echo delete_option($_POST["id"]);
		exit();
	}
	add_action('wp_ajax_css3_vertical_table_delete', 'css3_vertical_table_ajax_delete');
	
	function css3_vertical_table_ajax_preview()
	{
		$texts = "";
		for($i=0; $i<count($_POST["texts"]); $i++)
		{
			$texts .= str_replace("]", "&#93;", str_replace("[", "&#91;", str_replace("'", "\"", $_POST["texts"][$i])));
			if($i+1<count($_POST["texts"]));
				$texts .= "|";
		}
		$featuresCount = "";
		for($i=0; $i<count($_POST["featuresCount"]); $i++)
		{
			$featuresCount .= $_POST["featuresCount"][$i];
			if($i+1<count($_POST["featuresCount"]));
				$featuresCount .= "|";
		}
		$paddingsTop = "";
		for($i=0; $i<count($_POST["paddingsTop"]); $i++)
		{
			$paddingsTop .= $_POST["paddingsTop"][$i];
			if($i+1<count($_POST["paddingsTop"]));
				$paddingsTop .= "|";
		}
		$paddingsBottom = "";
		for($i=0; $i<count($_POST["paddingsBottom"]); $i++)
		{
			$paddingsBottom .= $_POST["paddingsBottom"][$i];
			if($i+1<count($_POST["paddingsBottom"]));
				$paddingsBottom .= "|";
		}
		$arrowSizes = "";
		for($i=0; $i<count($_POST["arrowSizes"]); $i++)
		{
			$arrowSizes .= $_POST["arrowSizes"][$i];
			if($i+1<count($_POST["arrowSizes"]));
				$arrowSizes .= "|";
		}
		echo do_shortcode("[css3_vertical_table_print style='" . $_POST["style"] . "' header='" . $_POST["header"] . "' featuresheader='" . $_POST["featuresHeader"] . "' rows='" . (int)$_POST["rows"] . "' texts='" . $texts . "' featurescount='" . $featuresCount . "' paddingstop='" . $paddingsTop . "' paddingsbottom='" . $paddingsBottom . "' arrowsizes='" . $arrowSizes . "' tablewidth='" . (int)$_POST["tableWidth"] . "']");
		exit();
	}
	add_action('wp_ajax_css3_vertical_table_preview', 'css3_vertical_table_ajax_preview');
	
	function css3_vertical_table_admin_page()
	{
		$error = "";
		if($_POST["action"]=="save")
		{
			if($_POST["shortcodeId"]!="")
			{
				$css3_vertical_table_options = array(
					'style' => $_POST['style'],
					'rows' => $_POST['rows'],
					'header' => $_POST['header'],
					'featuresHeader' => $_POST['featuresHeader'],
					'texts' => $_POST['texts'],
					'paddingsTop' => $_POST['paddingsTop'],
					'paddingsBottom' => $_POST['paddingsBottom'],
					'arrowSizes' => $_POST['arrowSizes'],
					'featuresCount' => $_POST["featuresCount"],
					'tableWidth' => $_POST["tableWidth"]
				);
				//add if not exist or update if exist
				$updated = true;
				if(!get_option('css3_vertical_table_shortcode_settings_' . $_POST["shortcodeId"]))
					$updated = false;
				/*echo "<pre>";
				var_export($css3_vertical_table_options);
				echo "</pre>";*/
				update_option('css3_vertical_table_shortcode_settings_' . $_POST["shortcodeId"], $css3_vertical_table_options);
				$message .= "Settings saved!" . ($updated ? " (overwritten)" : "");
				$message .= "<br />Please use <pre>[css3_vertical_table id='" . $_POST["shortcodeId"] . "']</pre> shortcode to put css3 vertical table on your page.";
			}
			else
			{
				$error .= "Please fill 'Shortcode id' field!";
			}
		}
		$allOptions = get_alloptions();
		$css3VerticalTableAllShortcodeIds = array();
		foreach($allOptions as $key => $value)
		{
			if(substr($key, 0, 38)=="css3_vertical_table_shortcode_settings")
				$css3VerticalTableAllShortcodeIds[] = $key;
		}
		//sort shortcode ids
		sort($css3VerticalTableAllShortcodeIds);
		?>
		<div class="wrap">
			<div class="icon32" id="icon-options-general"><br></div>
			<h2>CSS3 Vertical Web Pricing Tables settings</h2>
		</div>
		<?php
		if($error!="" || $message!="")
		{
		?>
		<div class="<?php echo ($message!="" ? "updated" : "error"); ?> settings-error"> 
			<p>
				<strong style="line-height: 150%;">
					<?php echo ($message!="" ? $message : $error); ?>
				</strong>
			</p>
		</div>
		<?php
		}
		?>
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="css3_vertical_table_settings">
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row">
							<label for="editShortcodeId">Choose shortcode id</label>
						</th>
						<td>
							<select name="editShortcodeId" id="editShortcodeId">
								<option value="-1">choose...</option>
								<?php
									for($i=0; $i<count($css3VerticalTableAllShortcodeIds); $i++)
										echo "<option value='$css3VerticalTableAllShortcodeIds[$i]'>" . substr($css3VerticalTableAllShortcodeIds[$i], 39) . "</option>";
								?>
							</select>
							<img style="display: none; cursor: pointer;" id="deleteButton" src="<?php echo WP_PLUGIN_URL; ?>/css3_vertical_web_pricing_tables/img/delete.png" alt="del" title="Delete this pricing table" />
							<span id="ajax_loader" style="display: none;"><img style="margin-bottom: -3px;" src="<?php echo WP_PLUGIN_URL; ?>/css3_vertical_web_pricing_tables/img/ajax-loader.gif" /></span>
							<span class="description">Choose the shortcode id for editing</span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="shortcodeId">Or type new shortcode id *</label>
						</th>
						<td>
							<input type="text" class="regular-text" value="" id="shortcodeId" name="shortcodeId">
							<span class="description">Unique identifier for css3_vertical_table shortcode. Don't use special characters.</span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="style">Style</label>
						</th>
						<td>
							<select name="style" id="style">
								<option value="green">Green</option>
								<option value="red">Red</option>
								<option value="blue">Blue</option>
								<option value="orange">Orange</option>
								<option value="violet">Violet</option>
								<option value="coffee">Coffee</option>
								<option value="rainbow">Rainbow</option>
								<option value="gray">Gray</option>
								<option value="silver">Silver</option>
								<option value="black">Black</option>
							</select>
							<span class="description">One of 10 available table styles.</span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="header">Header</label>
						</th>
						<td>
							<input type="text" class="regular-text" value="Reseller plans" id="header" name="header">
							<span class="description">Header title text.</span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="featuresHeader">Features header</label>
						</th>
						<td>
							<input type="text" class="regular-text" value="Features" id="featuresHeader" name="featuresHeader">
							<span class="description">Features header title text.</span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="rows">Rows</label>
						</th>
						<td>
							<input type="text" class="regular-text css3_vertical_table_slider_input" value="4" id="rows" name="rows" maxlength="2">
							<div id="rows_slider"></div>
							<span class="description">Number of table rows.</span>
						</td>
					</tr>
				</tbody>
			</table>
			<ul id="featuresBox" class="css3_vertical_table_features vt_clearfix">
				<li id="css3_vertical_table_feature_row1" class="css3_vertical_table_feature">
					<label class="css3_vertical_table_feature_title">Row 1 config</label>
					<table class="form-table">
					<tbody>
						<tr valign="top">
							<th scope="row">
								<label>Row 1 header</label>
							</th>
							<td>
								<input type="text" class="regular-text" value="&lt;h1&gt;Starter&lt;/h1&gt;&lt;h3&gt;$5.95&lt;/h3&gt;&lt;span&gt;/&nbsp;mo.&lt;/span&gt;" name="texts[]">
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label>Row 1 header padding top (px)</label>
							</th>
							<td>
								<input type="text" class="regular-text" value="" name="paddingsTop[]">
								<span class="description">Default value: 10px</span>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label>Row 1 header padding bottom (px)</label>
							</th>
							<td>
								<input type="text" class="regular-text" value="" name="paddingsBottom[]">
								<span class="description">Default value: 15px</span>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label>Row 1 arrow size (px)</label>
							</th>
							<td>
								<input type="text" class="regular-text" value="" name="arrowSizes[]">
								<span class="description">Default value: 48px</span>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label>Number of row 1 features:</label>
							</th>
							<td>
								<input type="text" class="regular-text css3_vertical_table_slider_input" value="6" name="featuresCount[]" maxlength="2">
								<div class="css3_vertical_table_slider"></div>
							</td>
						</tr>
					</tbody>
					</table>
					<ul class="css3_vertical_table_features_fields">
						<li class="css3_vertical_table_features_field1">
							<input type="text" class="regular-text" value="&lt;strong&gt;10GB&lt;/strong&gt; Storage" name="texts[]">
						</li>
						<li class="css3_vertical_table_features_field2">
							<input type="text" class="regular-text" value="&lt;strong&gt;5&lt;/strong&gt; Style Templates" name="texts[]">
						</li>
						<li class="css3_vertical_table_features_field3">
							<input type="text" class="regular-text" value="&lt;strong&gt;50GB&lt;/strong&gt; Bandwidth" name="texts[]">
						</li>
						<li class="css3_vertical_table_features_field4">
							<input type="text" class="regular-text" value="&lt;strong&gt;5&lt;/strong&gt; Email Accounts" name="texts[]">
						</li>
						<li class="css3_vertical_table_features_field5">
							<input type="text" class="regular-text" value="&lt;strong&gt;1&lt;/strong&gt; MySQL Database" name="texts[]">
						</li>
						<li class="css3_vertical_table_features_field6">
							<input type="text" class="regular-text" value="&lt;strong&gt;Free&lt;/strong&gt; Domain" name="texts[]">
						</li>
					</ul>
					<table class="form-table">
					<tbody>
						<tr valign="top">
							<th scope="row">
								<label>Row 1 button</label>
							</th>
							<td>
								<input type="text" class="regular-text" value="&lt;a href='#' class='vt-button'&gt;Buy now&lt;/a&gt;" name="texts[]">
							</td>
						</tr>
					</tbody>
					</table>
				</li>
				<li id="css3_vertical_table_feature_row2" class="css3_vertical_table_feature">
					<label class="css3_vertical_table_feature_title">Row 2 config</label>
					<table class="form-table">
					<tbody>
						<tr valign="top">
							<th scope="row">
								<label>Row 2 header</label>
							</th>
							<td>
								<input type="text" class="regular-text" value="&lt;h1&gt;Business&lt;/h1&gt;&lt;h3&gt;$19.95&lt;/h3&gt;&lt;span&gt;/&nbsp;mo.&lt;/span&gt;" name="texts[]">
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label>Row 2 header padding top (px)</label>
							</th>
							<td>
								<input type="text" class="regular-text" value="" name="paddingsTop[]">
								<span class="description">Default value: 10px</span>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label>Row 2 header padding bottom (px)</label>
							</th>
							<td>
								<input type="text" class="regular-text" value="" name="paddingsBottom[]">
								<span class="description">Default value: 15px</span>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label>Row 2 arrow size (px)</label>
							</th>
							<td>
								<input type="text" class="regular-text" value="" name="arrowSizes[]">
								<span class="description">Default value: 48px</span>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label>Number of row 2 features:</label>
							</th>
							<td>
								<input type="text" class="regular-text css3_vertical_table_slider_input" value="6" name="featuresCount[]" maxlength="2">
								<div class="css3_vertical_table_slider"></div>
							</td>
						</tr>
					</tbody>
					</table>
					<ul class="css3_vertical_table_features_fields">
						<li class="css3_vertical_table_features_field1">
							<input type="text" class="regular-text" value="&lt;strong&gt;50GB&lt;/strong&gt; Storage" name="texts[]">
						</li>
						<li class="css3_vertical_table_features_field2">
							<input type="text" class="regular-text" value="&lt;strong&gt;10&lt;/strong&gt; Style Templates" name="texts[]">
						</li>
						<li class="css3_vertical_table_features_field3">
							<input type="text" class="regular-text" value="&lt;strong&gt;250GB&lt;/strong&gt; Bandwidth" name="texts[]">
						</li>
						<li class="css3_vertical_table_features_field4">
							<input type="text" class="regular-text" value="&lt;strong&gt;10&lt;/strong&gt; Email Accounts" name="texts[]">
						</li>
						<li class="css3_vertical_table_features_field5">
							<input type="text" class="regular-text" value="&lt;strong&gt;5&lt;/strong&gt; MySQL Databases" name="texts[]">
						</li>
						<li class="css3_vertical_table_features_field6">
							<input type="text" class="regular-text" value="&lt;strong&gt;Free&lt;/strong&gt; Domain" name="texts[]">
						</li>
					</ul>
					<table class="form-table">
					<tbody>
						<tr valign="top">
							<th scope="row">
								<label>Row 2 button</label>
							</th>
							<td>
								<input type="text" class="regular-text" value="&lt;a href='#' class='vt-button'&gt;Buy now&lt;/a&gt;" name="texts[]">
							</td>
						</tr>
					</tbody>
					</table>
				</li>
				<li id="css3_vertical_table_feature_row3" class="css3_vertical_table_feature">
					<label class="css3_vertical_table_feature_title">Row 3 config</label>
					<table class="form-table">
					<tbody>
						<tr valign="top">
							<th scope="row">
								<label>Row 3 header</label>
							</th>
							<td>
								<input type="text" class="regular-text" value="&lt;h1&gt;Professional&lt;/h1&gt;&lt;h3&gt;$39.95&lt;/h3&gt;&lt;span&gt;/&nbsp;mo.&lt;/span&gt;" name="texts[]">
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label>Row 3 header padding top (px)</label>
							</th>
							<td>
								<input type="text" class="regular-text" value="" name="paddingsTop[]">
								<span class="description">Default value: 10px</span>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label>Row 3 header padding bottom (px)</label>
							</th>
							<td>
								<input type="text" class="regular-text" value="" name="paddingsBottom[]">
								<span class="description">Default value: 15px</span>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label>Row 3 arrow size (px)</label>
							</th>
							<td>
								<input type="text" class="regular-text" value="" name="arrowSizes[]">
								<span class="description">Default value: 48px</span>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label>Number of row 3 features:</label>
							</th>
							<td>
								<input type="text" class="regular-text css3_vertical_table_slider_input" value="6" name="featuresCount[]" maxlength="2">
								<div class="css3_vertical_table_slider"></div>
							</td>
						</tr>
					</tbody>
					</table>
					<ul class="css3_vertical_table_features_fields">
						<li class="css3_vertical_table_features_field1">
							<input type="text" class="regular-text" value="&lt;strong&gt;100GB&lt;/strong&gt; Storage" name="texts[]">
						</li>
						<li class="css3_vertical_table_features_field2">
							<input type="text" class="regular-text" value="&lt;strong&gt;25&lt;/strong&gt; Style Templates" name="texts[]">
						</li>
						<li class="css3_vertical_table_features_field3">
							<input type="text" class="regular-text" value="&lt;strong&gt;500GB&lt;/strong&gt; Bandwidth" name="texts[]">
						</li>
						<li class="css3_vertical_table_features_field4">
							<input type="text" class="regular-text" value="&lt;strong&gt;20&lt;/strong&gt; Email Accounts" name="texts[]">
						</li>
						<li class="css3_vertical_table_features_field5">
							<input type="text" class="regular-text" value="&lt;strong&gt;10&lt;/strong&gt; MySQL Databases" name="texts[]">
						</li>
						<li class="css3_vertical_table_features_field6">
							<input type="text" class="regular-text" value="&lt;strong&gt;Free&lt;/strong&gt; Domain" name="texts[]">
						</li>
					</ul>
					<table class="form-table">
					<tbody>
						<tr valign="top">
							<th scope="row">
								<label>Row 3 button</label>
							</th>
							<td>
								<input type="text" class="regular-text" value="&lt;a href='#' class='vt-button'&gt;Buy now&lt;/a&gt;" name="texts[]">
							</td>
						</tr>
					</tbody>
					</table>
				</li>
				<li id="css3_vertical_table_feature_row4" class="css3_vertical_table_feature">
					<label class="css3_vertical_table_feature_title">Row 4 config</label>
					<table class="form-table">
					<tbody>
						<tr valign="top">
							<th scope="row">
								<label>Row 4 header</label>
							</th>
							<td>
								<input type="text" class="regular-text" value="&lt;h1&gt;Premium&lt;/h1&gt;&lt;h3&gt;$59.95&lt;/h3&gt;&lt;span&gt;/&nbsp;mo.&lt;/span&gt;" name="texts[]">
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label>Row 4 header padding top (px)</label>
							</th>
							<td>
								<input type="text" class="regular-text" value="" name="paddingsTop[]">
								<span class="description">Default value: 10px</span>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label>Row 4 header padding bottom (px)</label>
							</th>
							<td>
								<input type="text" class="regular-text" value="" name="paddingsBottom[]">
								<span class="description">Default value: 15px</span>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label>Row 4 arrow size (px)</label>
							</th>
							<td>
								<input type="text" class="regular-text" value="" name="arrowSizes[]">
								<span class="description">Default value: 48px</span>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label>Number of row 4 features:</label>
							</th>
							<td>
								<input type="text" class="regular-text css3_vertical_table_slider_input" value="6" name="featuresCount[]" maxlength="2">
								<div class="css3_vertical_table_slider"></div>
							</td>
						</tr>
					</tbody>
					</table>
					<ul class="css3_vertical_table_features_fields">
						<li class="css3_vertical_table_features_field1">
							<input type="text" class="regular-text" value="&lt;strong&gt;500GB&lt;/strong&gt; Storage" name="texts[]">
						</li>
						<li class="css3_vertical_table_features_field2">
							<input type="text" class="regular-text" value="&lt;strong&gt;20&lt;/strong&gt; Style Templates" name="texts[]">
						</li>
						<li class="css3_vertical_table_features_field3">
							<input type="text" class="regular-text" value="&lt;strong&gt;1TB&lt;/strong&gt; Bandwidth" name="texts[]">
						</li>
						<li class="css3_vertical_table_features_field4">
							<input type="text" class="regular-text" value="&lt;strong&gt;50&lt;/strong&gt; Email Accounts" name="texts[]">
						</li>
						<li class="css3_vertical_table_features_field5">
							<input type="text" class="regular-text" value="&lt;strong&gt;20&lt;/strong&gt; MySQL Databases" name="texts[]">
						</li>
						<li class="css3_vertical_table_features_field6">
							<input type="text" class="regular-text" value="&lt;strong&gt;Free&lt;/strong&gt; Domain" name="texts[]">
						</li>
					</ul>
					<table class="form-table">
					<tbody>
						<tr valign="top">
							<th scope="row">
								<label>Row 4 button</label>
							</th>
							<td>
								<input type="text" class="regular-text" value="&lt;a href='#' class='vt-button'&gt;Buy now&lt;/a&gt;" name="texts[]">
							</td>
						</tr>
					</tbody>
					</table>
				</li>
			</ul>
			<table class="form-table" style="margin-top: 20px;">
			<tbody>
				<tr valign="top">
					<th scope="row">
						<label for="tableWidth">Custom table width (in px)</label>
					</th>
					<td>
						<input type="text" class="regular-text" value="" name="tableWidth" id="tableWidth">
						<span class="description">Default value: 770px</span>
					</td>
				</tr>
			</tbody>
			</table>
			<p>
				<input type="button" id="preview" value="Preview" class="button-primary" name="Preview">
				<input type="submit" value="Save Options" class="button-primary" name="Submit">
			</p>
			<div id="previewContainer">
			<?php
			echo do_shortcode("[css3_vertical_table_print]");
			?>
			</div>
			<p>
				<input type="hidden" name="action" value="save" />
				<input type="submit" value="Save Options" class="button-primary" name="Submit">
			</p>
		</form>
		<?php
	}
}

//activate plugin
function css3_vertical_table_activate()
{
	$style1 = array ('style' => 'green','rows' => '4','header' => 'Reseller plans','featuresHeader' => 'Features','texts' => array (0 => '<h1>Starter</h1><h3>$5.95</h3><span>/ mo.</span>',1 => '<strong>10GB</strong> Storage',2 => '<strong>5</strong> Style Templates',3 => '<strong>50GB</strong> Bandwidth',4 => '<strong>5</strong> Email Accounts',5 => '<strong>1</strong> MySQL Database',6 => '<strong>Free</strong> Domain',7 => '<a href="#" class="vt-button">Buy now</a>',8 => '<h1>Business</h1><h3>$19.95</h3><span>/ mo.</span>',9 => '<strong>50GB</strong> Storage',10 => '<strong>10</strong> Style Templates',11 => '<strong>250GB</strong> Bandwidth',12 => '<strong>10</strong> Email Accounts',13 => '<strong>5</strong> MySQL Databases',14 => '<strong>Free</strong> Domain',15 => '<a href="#" class="vt-button">Buy now</a>',16 => '<h1>Professional</h1><h3>$39.95</h3><span>/ mo.</span>',17 => '<strong>100GB</strong> Storage',18 => '<strong>25</strong> Style Templates',19 => '<strong>500GB</strong> Bandwidth',20 => '<strong>20</strong> Email Accounts',21 => '<strong>10</strong> MySQL Databases',22 => '<strong>Free</strong> Domain',23 => '<a href="#" class="vt-button">Buy now</a>',24 => '<h1>Premium</h1><h3>$59.95</h3><span>/ mo.</span>',25 => '<strong>500GB</strong> Storage',26 => '<strong>20</strong> Style Templates',27 => '<strong>1TB</strong> Bandwidth',28 => '<strong>50</strong> Email Accounts',29 => '<strong>20</strong> MySQL Databases',30 => '<strong>Free</strong> Domain',31 => '<a href="#" class="vt-button">Buy now</a>',),'paddingsTop' => array (0 => '',1 => '',2 => '',3 => '',),'paddingsBottom' => array (0 => '',1 => '',2 => '',3 => '',),'arrowSizes' => array (0 => '',1 => '',2 => '',3 => '',),'featuresCount' => array (0 => '6',1 => '6',2 => '6',3 => '6',),'tableWidth' => '');
	update_option("css3_vertical_table_shortcode_settings_style_1", $style1);
	$style2 = array('style' => 'red','rows' => '6','header' => 'Reseller plans','featuresHeader' => 'Features','texts' => array (  0 => '<h1>Starter</h1><h3>$5.95</h3><span>/&nbsp;mo.</span>',  1 => '<strong>10GB</strong> Storage',  2 => '<strong>5</strong> Style Templates',  3 => '<strong>50GB</strong> Bandwidth',  4 => '<strong>5</strong> Email Accounts',  5 => '<strong>1</strong> MySQL Database',  6 => '<strong>Free</strong> Domain',  7 => '<a href="#" class="vt-button">Buy now</a>',  8 => '<h1>Business</h1><h3>$19.95</h3><span>/&nbsp;mo.</span>',  9 => '<strong>50GB</strong> Storage',  10 => '<strong>10</strong> Style Templates',  11 => '<strong>250GB</strong> Bandwidth',  12 => '<strong>10</strong> Email Accounts',  13 => '<strong>5</strong> MySQL Databases',  14 => '<strong>Free</strong> Domain',  15 => '<a href="#" class="vt-button">Buy now</a>',  16 => '<h1>Professional</h1><h3>$39.95</h3><span>/&nbsp;mo.</span>',  17 => '<strong>100GB</strong> Storage',  18 => '<strong>25</strong> Style Templates',  19 => '<strong>500GB</strong> Bandwidth',  20 => '<a href="#" class="vt-button">Buy now</a>',  21 => '<h1>Premium</h1><h3>$59.95</h3><span>/&nbsp;mo.</span>',  22 => '<strong>500GB</strong> Storage',  23 => '<strong>20</strong> Style Templates',  24 => '<strong>1TB</strong> Bandwidth',  25 => '<strong>50</strong> Email Accounts',  26 => '<strong>20</strong> MySQL Databases',  27 => '<strong>Free</strong> Domain',  28 => '<a href="#" class="vt-button">Buy now</a>',  29 => '<h1>Extra</h1><h3>$79.95</h3><span>/ mo.</span>',  30 => '<strong>500GB</strong> Storage',  31 => '<strong>20</strong> Style Templates',  32 => '<strong>1TB</strong> Bandwidth',  33 => '<strong>50</strong> Email Accounts',  34 => '<strong>20</strong> MySQL Databases',  35 => '<strong>Free</strong> Domain',  36 => '<a href="#" class="vt-button">Buy now</a>',  37 => '<h1>Ultimate</h1><h3>$100</h3><span>/ mo.</span>',  38 => '<strong>500GB</strong> Storage',  39 => '<strong>20</strong> Style Templates',  40 => '<strong>1TB</strong> Bandwidth',  41 => '<strong>50</strong> Email Accounts',  42 => '<strong>20</strong> MySQL Databases',  43 => '<strong>Free</strong> Domain',  44 => '<strong>$100</strong> For advertising',  45 => '<strong>Full</strong> Support',  46 => '<strong>99,9%</strong> Uptime',  47 => '<a href="#" class="vt-button">Buy now</a>',),'paddingsTop' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',),'paddingsBottom' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',),'arrowSizes' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',),'featuresCount' => array (  0 => '6',  1 => '6',  2 => '3',  3 => '6',  4 => '6',  5 => '9',),'tableWidth' => '910');
	update_option("css3_vertical_table_shortcode_settings_style_2", $style2);
	$style3 = array ('style' => 'blue','rows' => '2','header' => 'Reseller plans','featuresHeader' => 'Features','texts' => array (0 => '<h1>Starter</h1><h3>$5.95</h3><span>/ mo.</span>',1 => '<strong>10GB</strong> Storage',2 => '<strong>5</strong> Style Templates',3 => '<strong>50GB</strong> Bandwidth',4 => '<strong>5</strong> Email Accounts',5 => '<strong>1</strong> MySQL Database',6 => '<strong>Free</strong> Domain',7 => '<strong>100$</strong> For advertising',8 => '<strong>Full</strong> Support',9 => '<strong>99,9%</strong> Uptime',10 => '<strong>10</strong> Subdomains',11 => '<strong>Autoresponder</strong> Script',12 => '<strong>PhpMyAdmin</strong> Installed',13 => '<a href="#" class="vt-button" style="margin-top: 38px;">Buy now</a>',14 => '<h1>Business</h1><h3>$19.95</h3><span>/ mo.</span>',15 => '<strong>50GB</strong> Storage',16 => '<strong>10</strong> Style Templates',17 => '<strong>250GB</strong> Bandwidth',18 => '<strong>10</strong> Email Accounts',19 => '<strong>5</strong> MySQL Databases',20 => '<strong>Free</strong> Domain',21 => '<a href="#" class="vt-button">Buy now</a>',),'paddingsTop' => array (0 => '40',1 => '',),'paddingsBottom' => array (0 => '50',1 => '',),'arrowSizes' => array (0 => '80',1 => '',),'featuresCount' => array (0 => '12',1 => '6',),'tableWidth' => '');
	update_option("css3_vertical_table_shortcode_settings_style_3", $style3);
	$style4 = array ('style' => 'orange','rows' => '3','header' => 'Reseller plans','featuresHeader' => 'Features','texts' => array (0 => '<h1>Starter</h1><h3>$5.95</h3><span>/ mo.</span>',1 => '<strong>10GB</strong> Storage',2 => '<strong>5</strong> Style Templates',3 => '<strong>50GB</strong> Bandwidth',4 => '<strong>5</strong> Email Accounts',5 => '<strong>1</strong> MySQL Database',6 => '<strong>Free</strong> Domain',7 => '<strong>100$</strong> For advertising',8 => '<strong>Full</strong> Support',9 => '<strong>99,9%</strong> Uptime',10 => '<strong>10</strong> Subdomains',11 => '<strong>Autoresponder</strong> Script',12 => '<strong>PhpMyAdmin</strong> Installed',13 => '<a href="#" class="vt-button" style="margin-top: 20px;">Buy now</a>',14 => '<h1>Business</h1><h3>$19.95</h3><span>/ mo.</span>',15 => '<strong>50GB</strong> Storage',16 => '<strong>10</strong> Style Templates',17 => '<strong>250GB</strong> Bandwidth',18 => '<strong>10</strong> Email Accounts',19 => '<strong>5</strong> MySQL Databases',20 => '<strong>Free</strong> Domain',21 => '<strong>10</strong> Subdomains',22 => '<strong>Autoresponder</strong> Script',23 => '<strong>PhpMyAdmin</strong> Installed',24 => '<a href="#" class="vt-button">Buy now</a>',25 => '<h1>Professional</h1><h3>$39.95</h3><span>/ mo.</span>',26 => '<strong>100GB</strong> Storage',27 => '<strong>25</strong> Style Templates',28 => '<strong>500GB</strong> Bandwidth',29 => '<strong>20</strong> Email Accounts',30 => '<strong>10</strong> MySQL Databases',31 => '<strong>Free</strong> Domain',32 => '<strong>10</strong> Subdomains',33 => '<strong>Autoresponder</strong> Script',34 => '<strong>PhpMyAdmin</strong> Installed',35 => '<a href="#" class="vt-button">Buy now</a>',),'paddingsTop' => array (0 => '20',1 => '',2 => '',),'paddingsBottom' => array (0 => '25',1 => '',2 => '',),'arrowSizes' => array (0 => '58',1 => '',2 => '',),'featuresCount' => array (0 => '12',1 => '9',2 => '9',),'tableWidth' => '930');
	update_option("css3_vertical_table_shortcode_settings_style_4", $style4);
	$style5 = array ('style' => 'violet','rows' => '4','header' => 'Reseller plans','featuresHeader' => 'Features','texts' => array (0 => '<h1>Starter</h1><h3>$5.95</h3><span>/ mo.</span>',1 => '<strong>10GB</strong> Storage',2 => '<strong>5</strong> Style Templates',3 => '<strong>50GB</strong> Bandwidth',4 => '<strong>5</strong> Email Accounts',5 => '<strong>1</strong> MySQL Database',6 => '<strong>Free</strong> Domain',7 => '<a href="#" class="vt-button" style="margin-top: 38px;">Buy now</a>',8 => '<h1>Business</h1><h3>$19.95</h3><span>/ mo.</span>',9 => '<strong>50GB</strong> Storage',10 => '<strong>10</strong> Style Templates',11 => '<strong>250GB</strong> Bandwidth',12 => '<strong>10</strong> Email Accounts',13 => '<strong>5</strong> MySQL Databases',14 => '<strong>Free</strong> Domain',15 => '<a href="#" class="vt-button" style="margin-top: 38px;">Buy now</a>',16 => '<h1>Professional</h1><h3>$39.95</h3><span>/ mo.</span>',17 => '<strong>100GB</strong> Storage',18 => '<strong>25</strong> Style Templates',19 => '<strong>500GB</strong> Bandwidth',20 => '<strong>20</strong> Email Accounts',21 => '<strong>10</strong> MySQL Databases',22 => '<strong>Free</strong> Domain',23 => '<a href="#" class="vt-button">Buy now</a>',24 => '<h1>Premium</h1><h3>$59.95</h3><span>/ mo.</span>',25 => '<strong>500GB</strong> Storage',26 => '<strong>20</strong> Style Templates',27 => '<strong>1TB</strong> Bandwidth',28 => '<strong>50</strong> Email Accounts',29 => '<strong>20</strong> MySQL Databases',30 => '<strong>Free</strong> Domain',31 => '<a href="#" class="vt-button" style="margin-top: 38px;">Buy now</a>',),'paddingsTop' => array (0 => '40',1 => '40',2 => '40',3 => '40',),'paddingsBottom' => array (0 => '45',1 => '45',2 => '45',3 => '45',),'arrowSizes' => array (0 => '78',1 => '78',2 => '78',3 => '78',),'featuresCount' => array (0 => '6',1 => '6',2 => '6',3 => '6',),'tableWidth' => '650');
	update_option("css3_vertical_table_shortcode_settings_style_5", $style5);
	$style6 = array ('style' => 'coffee','rows' => '4','header' => 'Reseller plans','featuresHeader' => 'Features','texts' => array (0 => '<h1>Starter</h1><h3>$5.95</h3><span>/ mo.</span>',1 => '<strong>10GB</strong> Storage',2 => '<strong>5</strong> Style Templates',3 => '<strong>50GB</strong> Bandwidth',4 => '<strong>5</strong> Email Accounts',5 => '<strong>1</strong> MySQL Database',6 => '<strong>Free</strong> Domain',7 => '<a href="#" class="vt-button">Buy now</a>',8 => '<h1>Business</h1><h3>$19.95</h3><span>/ mo.</span>',9 => '<strong>50GB</strong> Storage',10 => '<strong>10</strong> Style Templates',11 => '<strong>250GB</strong> Bandwidth',12 => '<strong>10</strong> Email Accounts',13 => '<strong>5</strong> MySQL Databases',14 => '<strong>Free</strong> Domain',15 => '<a href="#" class="vt-button">Buy now</a>',16 => '<h1>Professional</h1><h3>$39.95</h3><span>/ mo.</span>',17 => '<strong>100GB</strong> Storage',18 => '<strong>25</strong> Style Templates',19 => '<strong>500GB</strong> Bandwidth',20 => '<strong>20</strong> Email Accounts',21 => '<strong>10</strong> MySQL Databases',22 => '<strong>Free</strong> Domain',23 => '<a href="#" class="vt-button">Buy now</a>',24 => '<h1>Premium</h1><h3>$59.95</h3><span>/ mo.</span>',25 => '<strong>500GB</strong> Storage',26 => '<strong>20</strong> Style Templates',27 => '<strong>1TB</strong> Bandwidth',28 => '<strong>50</strong> Email Accounts',29 => '<strong>20</strong> MySQL Databases',30 => '<strong>Free</strong> Domain',31 => '<a href="#" class="vt-button">Buy now</a>',),'paddingsTop' => array (0 => '',1 => '',2 => '',3 => '',),'paddingsBottom' => array (0 => '',1 => '',2 => '',3 => '',),'arrowSizes' => array (0 => '',1 => '',2 => '',3 => '',),'featuresCount' => array (0 => '6',1 => '6',2 => '6',3 => '6',),'tableWidth' => '');
	update_option("css3_vertical_table_shortcode_settings_style_6", $style6);
	$style7 = array ('style' => 'rainbow','rows' => '6','header' => 'Reseller plans','featuresHeader' => 'Features','texts' => array (0 => '<h1>Starter</h1><h3>$5.95</h3><span>/ mo.</span>',1 => '<strong>10GB</strong> Storage',2 => '<strong>5</strong> Style Templates',3 => '<strong>50GB</strong> Bandwidth',4 => '<strong>5</strong> Email Accounts',5 => '<strong>1</strong> MySQL Database',6 => '<strong>Free</strong> Domain',7 => '<a href="#" class="vt-button">Buy now</a>',8 => '<h1>Business</h1><h3>$19.95</h3><span>/ mo.</span>',9 => '<strong>50GB</strong> Storage',10 => '<strong>10</strong> Style Templates',11 => '<strong>250GB</strong> Bandwidth',12 => '<strong>10</strong> Email Accounts',13 => '<strong>5</strong> MySQL Databases',14 => '<strong>Free</strong> Domain',15 => '<a href="#" class="vt-button">Buy now</a>',16 => '<h1>Professional</h1><h3>$39.95</h3><span>/ mo.</span>',17 => '<strong>100GB</strong> Storage',18 => '<strong>25</strong> Style Templates',19 => '<strong>500GB</strong> Bandwidth',20 => '<strong>20</strong> Email Accounts',21 => '<strong>10</strong> MySQL Databases',22 => '<strong>Free</strong> Domain',23 => '<a href="#" class="vt-button">Buy now</a>',24 => '<h1>Premium</h1><h3>$59.95</h3><span>/ mo.</span>',25 => '<strong>500GB</strong> Storage',26 => '<strong>20</strong> Style Templates',27 => '<strong>1TB</strong> Bandwidth',28 => '<strong>50</strong> Email Accounts',29 => '<strong>20</strong> MySQL Databases',30 => '<strong>Free</strong> Domain',31 => '<a href="#" class="vt-button">Buy now</a>',32 => '<h1>Ultimate</h1><h3>$99.99</h3><span>/ mo.</span>',33 => '<strong>500GB</strong> Storage',34 => '<strong>20</strong> Style Templates',35 => '<strong>1TB</strong> Bandwidth',36 => '<strong>50</strong> Email Accounts',37 => '<strong>20</strong> MySQL Databases',38 => '<strong>Free</strong> Domain',39 => '<a href="#" class="vt-button">Buy now</a>',40 => '<h1>Full</h1><h3>$199.95</h3><span>/ mo.</span>',41 => '<strong>500GB</strong> Storage',42 => '<strong>20</strong> Style Templates',43 => '<strong>1TB</strong> Bandwidth',44 => '<strong>50</strong> Email Accounts',45 => '<strong>20</strong> MySQL Databases',46 => '<strong>Free</strong> Domain',47 => '<a href="#" class="vt-button">Buy now</a>',),'paddingsTop' => array (0 => '',1 => '',2 => '',3 => '',4 => '',5 => '',),'paddingsBottom' => array (0 => '',1 => '',2 => '',3 => '',4 => '',5 => '',),'arrowSizes' => array (0 => '',1 => '',2 => '',3 => '',4 => '',5 => '',),'featuresCount' => array (0 => '6',1 => '6',2 => '6',3 => '6',4 => '6',5 => '6',),'tableWidth' => '');
	update_option("css3_vertical_table_shortcode_settings_style_7", $style7);
	$style8 = array ('style' => 'gray','rows' => '4','header' => 'Reseller plans','featuresHeader' => 'Features','texts' => array (0 => '<h1>Starter</h1><h3>$5.95</h3><span>/ mo.</span>',1 => '<strong>10GB</strong> Storage',2 => '<strong>5</strong> Style Templates',3 => '<strong>50GB</strong> Bandwidth',4 => '<strong>5</strong> Email Accounts',5 => '<strong>1</strong> MySQL Database',6 => '<strong>Free</strong> Domain',7 => '<a href="#" class="vt-button">Buy now</a>',8 => '<h1>Business</h1><h3>$19.95</h3><span>/ mo.</span>',9 => '<strong>50GB</strong> Storage',10 => '<strong>10</strong> Style Templates',11 => '<strong>250GB</strong> Bandwidth',12 => '<strong>10</strong> Email Accounts',13 => '<strong>5</strong> MySQL Databases',14 => '<strong>Free</strong> Domain',15 => '<a href="#" class="vt-button">Buy now</a>',16 => '<h1>Professional</h1><h3>$39.95</h3><span>/ mo.</span>',17 => '<strong>100GB</strong> Storage',18 => '<strong>25</strong> Style Templates',19 => '<strong>500GB</strong> Bandwidth',20 => '<strong>20</strong> Email Accounts',21 => '<strong>10</strong> MySQL Databases',22 => '<strong>Free</strong> Domain',23 => '<a href="#" class="vt-button">Buy now</a>',24 => '<h1>Premium</h1><h3>$59.95</h3><span>/ mo.</span>',25 => '<strong>500GB</strong> Storage',26 => '<strong>20</strong> Style Templates',27 => '<strong>1TB</strong> Bandwidth',28 => '<strong>50</strong> Email Accounts',29 => '<strong>20</strong> MySQL Databases',30 => '<strong>Free</strong> Domain',31 => '<a href="#" class="vt-button">Buy now</a>',),'paddingsTop' => array (0 => '',1 => '',2 => '',3 => '',),'paddingsBottom' => array (0 => '',1 => '',2 => '',3 => '',),'arrowSizes' => array (0 => '',1 => '',2 => '',3 => '',),'featuresCount' => array (0 => '6',1 => '6',2 => '6',3 => '6',),'tableWidth' => '');
	update_option("css3_vertical_table_shortcode_settings_style_8", $style8);
	$style9 = array ('style' => 'silver','rows' => '4','header' => 'Reseller plans','featuresHeader' => 'Features','texts' => array (0 => '<h1>Starter</h1><h3>$5.95</h3><span>/ mo.</span>',1 => '<strong>10GB</strong> Storage',2 => '<strong>5</strong> Style Templates',3 => '<strong>50GB</strong> Bandwidth',4 => '<strong>5</strong> Email Accounts',5 => '<strong>1</strong> MySQL Database',6 => '<strong>Free</strong> Domain',7 => '<a href="#" class="vt-button">Buy now</a>',8 => '<h1>Business</h1><h3>$19.95</h3><span>/ mo.</span>',9 => '<strong>50GB</strong> Storage',10 => '<strong>10</strong> Style Templates',11 => '<strong>250GB</strong> Bandwidth',12 => '<strong>10</strong> Email Accounts',13 => '<strong>5</strong> MySQL Databases',14 => '<strong>Free</strong> Domain',15 => '<a href="#" class="vt-button">Buy now</a>',16 => '<h1>Professional</h1><h3>$39.95</h3><span>/ mo.</span>',17 => '<strong>100GB</strong> Storage',18 => '<strong>25</strong> Style Templates',19 => '<strong>500GB</strong> Bandwidth',20 => '<strong>20</strong> Email Accounts',21 => '<strong>10</strong> MySQL Databases',22 => '<strong>Free</strong> Domain',23 => '<a href="#" class="vt-button">Buy now</a>',24 => '<h1>Premium</h1><h3>$59.95</h3><span>/ mo.</span>',25 => '<strong>500GB</strong> Storage',26 => '<strong>20</strong> Style Templates',27 => '<strong>1TB</strong> Bandwidth',28 => '<strong>50</strong> Email Accounts',29 => '<strong>20</strong> MySQL Databases',30 => '<strong>Free</strong> Domain',31 => '<a href="#" class="vt-button">Buy now</a>',),'paddingsTop' => array (0 => '',1 => '',2 => '',3 => '',),'paddingsBottom' => array (0 => '',1 => '',2 => '',3 => '',),'arrowSizes' => array (0 => '',1 => '',2 => '',3 => '',),'featuresCount' => array (0 => '6',1 => '6',2 => '6',3 => '6',),'tableWidth' => '');
	update_option("css3_vertical_table_shortcode_settings_style_9", $style9);
	$style10 = array ('style' => 'black','rows' => '4','header' => 'Reseller plans','featuresHeader' => 'Features','texts' => array (0 => '<h1>Starter</h1><h3>$5.95</h3><span>/ mo.</span>',1 => '<strong>10GB</strong> Storage',2 => '<strong>5</strong> Style Templates',3 => '<strong>50GB</strong> Bandwidth',4 => '<strong>5</strong> Email Accounts',5 => '<strong>1</strong> MySQL Database',6 => '<strong>Free</strong> Domain',7 => '<a href="#" class="vt-button">Buy now</a>',8 => '<h1>Business</h1><h3>$19.95</h3><span>/ mo.</span>',9 => '<strong>50GB</strong> Storage',10 => '<strong>10</strong> Style Templates',11 => '<strong>250GB</strong> Bandwidth',12 => '<strong>10</strong> Email Accounts',13 => '<strong>5</strong> MySQL Databases',14 => '<strong>Free</strong> Domain',15 => '<a href="#" class="vt-button">Buy now</a>',16 => '<h1>Professional</h1><h3>$39.95</h3><span>/ mo.</span>',17 => '<strong>100GB</strong> Storage',18 => '<strong>25</strong> Style Templates',19 => '<strong>500GB</strong> Bandwidth',20 => '<strong>20</strong> Email Accounts',21 => '<strong>10</strong> MySQL Databases',22 => '<strong>Free</strong> Domain',23 => '<a href="#" class="vt-button">Buy now</a>',24 => '<h1>Premium</h1><h3>$59.95</h3><span>/ mo.</span>',25 => '<strong>500GB</strong> Storage',26 => '<strong>20</strong> Style Templates',27 => '<strong>1TB</strong> Bandwidth',28 => '<strong>50</strong> Email Accounts',29 => '<strong>20</strong> MySQL Databases',30 => '<strong>Free</strong> Domain',31 => '<a href="#" class="vt-button">Buy now</a>',),'paddingsTop' => array (0 => '',1 => '',2 => '',3 => '',),'paddingsBottom' => array (0 => '',1 => '',2 => '',3 => '',),'arrowSizes' => array (0 => '',1 => '',2 => '',3 => '',),'featuresCount' => array (0 => '6',1 => '6',2 => '6',3 => '6',),'tableWidth' => '');
	update_option("css3_vertical_table_shortcode_settings_style_10", $style10);
}
register_activation_hook( __FILE__, 'css3_vertical_table_activate');

function css3_vertical_table_enqueue_scripts()
{
	wp_enqueue_style('css3_vertical_table_font_sans_narrow', 'http://fonts.googleapis.com/css?family=PT+Sans+Narrow');
	wp_enqueue_style('css3_vertical_table_font_sans_condensed', 'http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300');
	wp_enqueue_style('css3_table_style', plugins_url('style/css3_table_style.css', __FILE__));
	/*wp_register_style('css3_vertical_table_main', plugins_url('style/main.css', __FILE__));
	wp_register_style('css3_vertical_table_style1', plugins_url('style/style1.css', __FILE__));
	wp_register_style('css3_vertical_table_style2', plugins_url('style/style2.css', __FILE__));
	wp_register_style('css3_vertical_table_style3', plugins_url('style/style3.css', __FILE__));
	wp_register_style('css3_vertical_table_style4', plugins_url('style/style4.css', __FILE__));
	wp_register_style('css3_vertical_table_style5', plugins_url('style/style5.css', __FILE__));
	wp_register_style('css3_vertical_table_style6', plugins_url('style/style6.css', __FILE__));
	wp_register_style('css3_vertical_table_style7', plugins_url('style/style7.css', __FILE__));
	wp_register_style('css3_vertical_table_style8', plugins_url('style/style8.css', __FILE__));
	wp_register_style('css3_vertical_table_style9', plugins_url('style/style9.css', __FILE__));
	wp_register_style('css3_vertical_table_style10', plugins_url('style/style10.css', __FILE__));
	wp_print_styles(array(
			'css3_vertical_table_font_sans_narrow',
			'css3_vertical_table_font_sans_condensed',
			'css3_vertical_table_style_admin',
			'css3_vertical_table_jquery-ui-custom',
			'css3_vertical_table_main',
			'css3_vertical_table_style1',
			'css3_vertical_table_style2',
			'css3_vertical_table_style3',
			'css3_vertical_table_style4',
			'css3_vertical_table_style5',
			'css3_vertical_table_style6',
			'css3_vertical_table_style7',
			'css3_vertical_table_style8',
			'css3_vertical_table_style9',
			'css3_vertical_table_style10'
		));*/
}
add_action('wp_enqueue_scripts', 'css3_vertical_table_enqueue_scripts');

function css3_vertical_table_shortcode($atts)
{
	extract(shortcode_atts(array(
		'id' => ''
	), $atts));
	if($id!="")
	{
		if($shortcode_settings = get_option('css3_vertical_table_shortcode_settings_' . $id))
		{
			$texts = "";
			for($i=0; $i<count($shortcode_settings["texts"]); $i++)
			{
				$texts .= str_replace("]", "&#93;", str_replace("[", "&#91;", str_replace("'", "\"", $shortcode_settings["texts"][$i])));
				if($i+1<count($shortcode_settings["texts"]));
					$texts .= "|";
			}
			$featuresCount = "";
			for($i=0; $i<count($shortcode_settings["featuresCount"]); $i++)
			{
				$featuresCount .= $shortcode_settings["featuresCount"][$i];
				if($i+1<count($shortcode_settings["featuresCount"]));
					$featuresCount .= "|";
			}
			$paddingsTop = "";
			for($i=0; $i<count($shortcode_settings["paddingsTop"]); $i++)
			{
				$paddingsTop .= $shortcode_settings["paddingsTop"][$i];
				if($i+1<count($shortcode_settings["paddingsTop"]));
					$paddingsTop .= "|";
			}
			$paddingsBottom = "";
			for($i=0; $i<count($shortcode_settings["paddingsBottom"]); $i++)
			{
				$paddingsBottom .= $shortcode_settings["paddingsBottom"][$i];
				if($i+1<count($shortcode_settings["paddingsBottom"]));
					$paddingsBottom .= "|";
			}
			$arrowSizes = "";
			for($i=0; $i<count($shortcode_settings["arrowSizes"]); $i++)
			{
				$arrowSizes .= $shortcode_settings["arrowSizes"][$i];
				if($i+1<count($shortcode_settings["arrowSizes"]));
					$arrowSizes .= "|";
			}
			$output = do_shortcode("[css3_vertical_table_print style='" . $shortcode_settings["style"] . "' header='" . $shortcode_settings["header"] . "' featuresheader='" . $shortcode_settings["featuresHeader"] . "' rows='" . $shortcode_settings["rows"] . "' texts='" . $texts . "' featurescount='" . $featuresCount . "' paddingstop='" . $paddingsTop . "' paddingsbottom='" . $paddingsBottom . "' arrowsizes='" . $arrowSizes . "' tablewidth='" . $shortcode_settings["tableWidth"] . "']");
		}
		else
			$output = "Shortcode with given id not found!";
	}
	else
		$output = "Parameter id not specified!";
	return $output;
}
add_shortcode('css3_vertical_table', 'css3_vertical_table_shortcode');

function css3_vertical_table_print_shortcode($atts)
{
	extract(shortcode_atts(array(
		'style' => 'green',
		'rows' => '4',
		'header' => 'Reseller plans',
		'featuresheader' => 'Features',
		'texts' => '<h1>Starter</h1><h3>$5.95</h3><span>/&nbsp;mo.</span>|<strong>10GB</strong> Storage|<strong>5</strong> Style Templates|<strong>50GB</strong> Bandwidth|<strong>5</strong> Email Accounts|<strong>1</strong> MySQL Database|<strong>Free</strong> Domain|<a href="#" class="vt-button">Buy now</a>|<h1>Business</h1><h3>$19.95</h3><span>/&nbsp;mo.</span>|<strong>50GB</strong> Storage|<strong>10</strong> Style Templates|<strong>250GB</strong> Bandwidth|<strong>10</strong> Email Accounts|<strong>5</strong> MySQL Databases|<strong>Free</strong> Domain|<a href="#" class="vt-button">Buy now</a>|<h1>Professional</h1><h3>$39.95</h3><span>/&nbsp;mo.</span>|<strong>100GB</strong> Storage|<strong>25</strong> Style Templates|<strong>500GB</strong> Bandwidth|<strong>20</strong> Email Accounts|<strong>10</strong> MySQL Databases|<strong>Free</strong> Domain|<a href="#" class="vt-button">Buy now</a>|<h1>Premium</h1><h3>$59.95</h3><span>/&nbsp;mo.</span>|<strong>500GB</strong> Storage|<strong>20</strong> Style Templates|<strong>1TB</strong> Bandwidth|<strong>50</strong> Email Accounts|<strong>20</strong> MySQL Databases|<strong>Free</strong> Domain|<a href="#" class="vt-button">Buy now</a>',
		'paddingstop' => '|||',
		'paddingsbottom' => '|||',
		'arrowsizes' => '|||',
		'featurescount' => '6|6|6|6',
		'tablewidth' => ''
	), $atts));
	$texts = explode("|", $texts);
	$featuresCount = explode("|", $featurescount);
	$paddingsTop = explode("|", $paddingstop);
	$paddingsBottom = explode("|", $paddingsbottom);
	$arrowSizes = explode("|", $arrowsizes);
	$output .= '<ul class="vt vt-skin-' . $style . ' vt_clearfix"' . ((int)$tablewidth>0 ? ' style="width: ' . (int)$tablewidth . 'px;"' : '') . '>';
	$output .= '	<li class="vt-line-header">';
	$output .= '		<div class="vt-header">';
	$output .= '			<h3>' . $header . '</h3>';
	$output .= '		</div>';
	$output .= '		<div class="vt-content"' . ((int)$tablewidth>0 ? ' style="width: ' . ((int)$tablewidth-290) . 'px;"' : '') . '>';
	$output .= '			<h3>' . $featuresheader . '</h3>';
	$output .= '		</div>';
	$output .= '	</li>';
	$featuresCountSum = 0;
	for($i=0; $i<$rows; $i++)
	{
		$output .= '<li class="vt-line vt-line-' . ($i%4+1) . '">';
		$output .= '	<div class="vt-header"' . ($paddingsTop[$i]!="" || $paddingsBottom[$i]!="" ? ' style="' . ($paddingsTop[$i]!="" ? 'padding-top: ' . (int)$paddingsTop[$i] . 'px !important;' : '') .  ($paddingsBottom[$i]!="" ? 'padding-bottom: ' . (int)$paddingsBottom[$i] . 'px !important;' : '') . '"':'') . '>';
		$output .=			$texts[$i+$i+$featuresCountSum];
		$output .= '	</div>';
		$output .= '	<div class="vt-header-arrow"' . ($arrowSizes[$i]!="" ? ' style="border-top: ' . (int)$arrowSizes[$i] . 'px solid transparent; border-bottom: ' . (int)$arrowSizes[$i] . 'px solid transparent;"':'') . '></div>';
		$output .= '	<div class="vt-content">';
		if($featuresCount[$i]>0)
		{
			$output .= '<ul class="vt-features"' . ((int)$tablewidth>0 ? ' style="width: ' . ((int)$tablewidth-430) . 'px;"' : '') . '>';
			for($j=0; $j<$featuresCount[$i]; $j++)
			{
				$output .= '<li class="vt-feature">';
				$output .=		$texts[$i+$i+$featuresCountSum+$j+1];
				$output .= '</li>';
			}
			$output .= '</ul>';
		}
		$output .= $texts[$i+$i+$featuresCountSum+$featuresCount[$i]+1];
		$output .= '	</div>';
		$output .= '</li>';
		$featuresCountSum += $featuresCount[$i];
	}
	$output .= "</ul>";
	return $output;
}
add_shortcode('css3_vertical_table_print', 'css3_vertical_table_print_shortcode');
?>