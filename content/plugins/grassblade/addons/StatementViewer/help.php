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
<h2 name="statement_viewer"><?php _e('Statement Viewer', 'grassblade'); ?></h2>

<a href="#statement_viewer" onclick="return showHideOptional('grassblade_sv_whatis');"><h3><img src="<?php echo get_bloginfo('wpurl')."/wp-content/plugins/grassblade/img/button.png"; ?>"/><span style="margin-left:10px;"><?php _e('What is Statement Viewer?','grassblade'); ?></span></h3></a>
<div id="grassblade_sv_whatis"  class="infoblocks"  style="display:none;">
<p>
<?php _e('Statement Viewer lets you view your Tin Can Statements rigth from Wordpress. No need to login to your LRS.', 'grassblade'); ?></p>
</div>
