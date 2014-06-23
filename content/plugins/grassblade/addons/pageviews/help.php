<script>
/*function getOffset( el ) {
    var _x = 0;
    var _y = 0;
    while( el && !isNaN( el.offsetLeft ) && !isNaN( el.offsetTop ) ) {
        _x += el.offsetLeft - el.scrollLeft;
        _y += el.offsetTop - el.scrollTop;
        el = el.offsetParent;
    }
    return { top: _y, left: _x };
}*/
function showHideOptional(id) {
	var table = document.getElementById(id);
	var display_status = table.style.display;

	
	if(display_status == "none")
	{
		table.style.display = "block";
		//window.scrollTo(getOffset(table).left,getOffset(table).top);
	}
	else
		table.style.display = "none";
		
	//return false;
}
</script>

<style>
.infoblocks {
	background: greenyellow;
	border: 1px solid black;
	display: block;
	padding: 10px 20px;
}

</style>
<h2 name="pageviews_tracking"><?php _e('PageViews Tracking','grassblade'); ?></h2>

<a href="#pageviews_tracking" onclick="return showHideOptional('grassblade_pv_whatis');"><h3><img src="<?php echo get_bloginfo('wpurl')."/wp-content/plugins/grassblade/img/button.png"; ?>"/><span style="margin-left:10px;"><?php _e('What is PageViews tracking?','grassblade'); ?></span></h3></a>
<div id="grassblade_pv_whatis"  class="infoblocks"  style="display:none;">
<p>
<?php _e('PageViews tracking feature sends page view details to the LRS. Every time someone visits a page that is being tracked by PageViews, an xAPI statement is sent to the LRS.','grassblade') ?>
</p>
</div>

<a href="#pageviews_tracking" onclick="return showHideOptional('grassblade_pv_ver');"><h3><img src="<?php echo get_bloginfo('wpurl')."/wp-content/plugins/grassblade/img/button.png"; ?>"/><span style="margin-left:10px;"><?php _e('Which TinCan(xAPI) Version is used to send statement sent for PageViews?','grassblade'); ?></span></h3></a>
<div id="grassblade_pv_ver"  class="infoblocks"  style="display:none;">
<p>
<?php _e('Currently PageViews Tracking information is sent in the latest TinCan(xAPI) Version. i.e. 0.95<br>Please look for GrassBlade Updates if a newer xAPI version is released.','grassblade'); ?>
</p>
</div>


<a href="#pageviews_tracking" onclick="return showHideOptional('grassblade_pv_use');"><h3><img src="<?php echo get_bloginfo('wpurl')."/wp-content/plugins/grassblade/img/button.png"; ?>"/><span style="margin-left:10px;"><?php _e('How does GrassBlade decide which Pages/Posts to track?','grassblade'); ?></span></h3></a>
<div id="grassblade_pv_use"  class="infoblocks"  style="display:none;">
<p>
<?php _e('Based on the settings on PageViews Settings page, you can choose to track all Pages and Posts. Or, choose to track posts in specific categories or specific tags.','grassblade'); ?>
</p>
</div>
