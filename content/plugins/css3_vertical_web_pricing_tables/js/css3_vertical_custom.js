jQuery(document).ready(function(){
	jQuery(".vt .vt-content select").change(function(){
		console.log(jQuery(this).siblings(".vt-button").attr("href"));
		jQuery(this).siblings(".vt-button").attr("href", jQuery(this).val());
	});
});