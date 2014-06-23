	function grassblade_show_lightbox(id, src, width, height) {
		if(document.getElementById("grassblade_lightbox") == null)
			jQuery("body").append("<div id='grassblade_lightbox'></div>");
		
		
			html = "<div class='grassblade_lightbox_overlay'  onClick='return grassblade_hide_lightbox();'></div><div id='" + id + "' class='grassblade_lightbox'  style='width:" + width + "; height:" + height + ";'>" + 
						"<div class='grassblade_close'><a href='#' onClick='return grassblade_hide_lightbox();'>X</a></div>" +
						"<iframe class='grassblade_lightbox_iframe' frameBorder='0' src='" + src + "'></iframe>" +
					"</div>";
				
			jQuery("#grassblade_lightbox").html(html);
			jQuery("#grassblade_lightbox").show();
			
	}
	function grassblade_hide_lightbox() {
		jQuery("#grassblade_lightbox").hide();
		jQuery("#grassblade_lightbox").html('');
		return false;
	}
	function show_xapi_content_meta_box_change() {
		var show_xapi_content = jQuery("#show_xapi_content");
		if(show_xapi_content.length == 0)
			return;

		edit_link = jQuery('#grassblade_add_to_content_edit_link'); 
		if(show_xapi_content.val() > 0) 
			edit_link.show(); 
		else 
			edit_link.hide();
			
		jQuery("#completion_tracking_enabled").hide();
		jQuery("#completion_tracking_disabled").hide();		

		if(jQuery("#show_xapi_content option:selected").attr("completion-tracking") == "1") {
			jQuery("#completion_tracking_enabled").show();
		}
		else if(jQuery("#show_xapi_content option:selected").attr("completion-tracking") == "")
		{
			jQuery("#completion_tracking_disabled").show();			
		}
	}
	jQuery(window).load(function() {
		if(jQuery("#show_xapi_content").length > 0) {
			jQuery("#show_xapi_content").change(function() {
				show_xapi_content_meta_box_change();
			});
			show_xapi_content_meta_box_change();
		}
	});