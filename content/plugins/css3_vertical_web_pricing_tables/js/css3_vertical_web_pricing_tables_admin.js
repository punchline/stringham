jQuery(document).ready(function($){
	$("#css3_vertical_table_settings")[0].reset();
	$("#editShortcodeId").change(function(){
		if($(this).val()!="-1")
		{
			var id = $("#editShortcodeId :selected").html();
			$("#shortcodeId").val(id).trigger("paste");
			$("#ajax_loader").css("display", "inline");
			$.ajax({
					url: ajaxurl,
					type: 'post',
					dataType: 'json',
					data: 'action=css3_vertical_table_get_settings&id='+id,
					success: function(json){
						$("#rows").val(json.rows).trigger("change");
						$.each(json, function(key, val){
							if(key=="featuresCount")
							{
								$("[name='featuresCount[]']").each(function(index){
									$(this).val(val[index]).trigger("change");
								});
							}
						});
						$.each(json, function(key, val){
							if(key!="rows" && key!="featuresCount")
							{
								if(key=="texts")
								{
									$("[name='texts[]']").each(function(index){
										$(this).val(val[index]);
									});
								}
								else if(key=="paddingsTop")
								{
									$("[name='paddingsTop[]']").each(function(index){
										$(this).val(val[index]);
									});
								}
								else if(key=="paddingsBottom")
								{
									$("[name='paddingsBottom[]']").each(function(index){
										$(this).val(val[index]);
									});
								}
								else if(key=="arrowSizes")
								{
									$("[name='arrowSizes[]']").each(function(index){
										$(this).val(val[index]);
									});
								}
								else
									$("#" + key).val(val);
							}
						});
						$("#kind").trigger("change");
						$("#preview").trigger("click");
						$("#ajax_loader").css("display", "none");
						$("#deleteButton").css("display", "inline");
					}
			});
		}
		else
		{
			$("#css3_vertical_table_settings")[0].reset();
			$("#deleteButton").css("display", "none");
			$("#rows").trigger("change");
			$("[name='featuresCount[]']").trigger("change");
		}
	});
	$("#deleteButton").click(function(){
		var id = $("#editShortcodeId").val();
		$("#deleteButton").css("display", "none");
		$("#ajax_loader").css("display", "inline");
		$.ajax({
					url: ajaxurl,
					type: 'post',
					dataType: 'json',
					data: 'action=css3_vertical_table_delete&id='+id,
					success: function(data){
						if(parseInt(data)==1)
						{
							$("#editShortcodeId [value='" + id + "']").remove();
							$("#css3_vertical_table_settings")[0].reset();
							$("#rows").trigger("change");
							$("#preview").trigger("click");
							$("#ajax_loader").css("display", "none");
						}
					}
		});
	});
	$("#preview").click(function(){
		var data = $("#css3_vertical_table_settings").serializeArray();
		data.push({name: "action", value: "css3_vertical_table_preview"});
		$.ajax({
					url: ajaxurl,
					type: 'post',
					data: data,
					success: function(data){
						$("#previewContainer").html(data);
					}
		});
	});
	$("#rows").bind("keyup change paste", function(event){
		var previousRows = $("#featuresBox").children("li").length;
		var rows = parseInt($(this).val());
		$("#rows_slider").slider("option", "value", rows);
		var html = "";
		var i;
		if(rows>0 && rows<100)
		{
			i=0;
			for(i=rows; i<previousRows; i++)
				$("#featuresBox #css3_vertical_table_feature_row"+(i+1)).remove();
			if(rows>previousRows)
			{
				var rowHtml = "";
				rowHtml += "<li id='css3_vertical_table_feature_rowNR' class='css3_vertical_table_feature'>";
				rowHtml += "	<label class='css3_vertical_table_feature_title'>Row NR config</label>";
				rowHtml += "	<table class='form-table'>";
				rowHtml += "	<tbody>";
				rowHtml += "		<tr valign='top'>";
				rowHtml += "			<th scope='row'>";
				rowHtml += "				<label>Row NR header</label>";
				rowHtml += "			</th>";
				rowHtml += "			<td>";
				rowHtml += "				<input type='text' class='regular-text' value='' name='texts[]'>";
				rowHtml += "			</td>";
				rowHtml += "		</tr>";
				rowHtml += "		<tr valign='top'>";
				rowHtml += "			<th scope='row'>";
				rowHtml += "				<label>Row NR header padding top (px)</label>";
				rowHtml += "			</th>";
				rowHtml += "			<td>";
				rowHtml += "				<input type='text' class='regular-text' value='' name='paddingsTop[]'>";
				rowHtml += "				<span class='description'>Default value: 10px</span>";
				rowHtml += "			</td>";
				rowHtml += "		</tr>";
				rowHtml += "		<tr valign='top'>";
				rowHtml += "			<th scope='row'>";
				rowHtml += "				<label>Row NR header padding bottom (px)</label>";
				rowHtml += "			</th>";
				rowHtml += "			<td>";
				rowHtml += "				<input type='text' class='regular-text' value='' name='paddingsBottom[]'>";
				rowHtml += "				<span class='description'>Default value: 15px</span>";
				rowHtml += "			</td>";
				rowHtml += "		</tr>";
				rowHtml += "		<tr valign='top'>";
				rowHtml += "			<th scope='row'>";
				rowHtml += "				<label>Row NR arrow size (px)</label>";
				rowHtml += "			</th>";
				rowHtml += "			<td>";
				rowHtml += "				<input type='text' class='regular-text' value='' name='arrowSizes[]'>";
				rowHtml += "				<span class='description'>Default value: 48px</span>";
				rowHtml += "			</td>";
				rowHtml += "		</tr>";
				rowHtml += "		<tr valign='top'>";
				rowHtml += "			<th scope='row'>";
				rowHtml += "				<label>Number of row NR features:</label>";
				rowHtml += "			</th>";
				rowHtml += "			<td>";
				rowHtml += "				<input type='text' class='regular-text css3_vertical_table_slider_input' value='6' name='featuresCount[]' maxlength='2'>";
				rowHtml += "				<div class='css3_vertical_table_slider'></div>";
				rowHtml += "			</td>";
				rowHtml += "		</tr>";
				rowHtml += "	</tbody>";
				rowHtml += "	</table>";
				rowHtml += "	<ul class='css3_vertical_table_features_fields'>";
				for(var j=0; j<6; j++)
				{
					rowHtml += "<li class='css3_vertical_table_features_field" + (j+1) + "'>";
					rowHtml += "	<input type='text' class='regular-text' value='' name='texts[]'>";
					rowHtml += "</li>";
				}
				rowHtml += "	</ul>";
				rowHtml += "	<table class='form-table'>";
				rowHtml += "	<tbody>";
				rowHtml += "		<tr valign='top'>";
				rowHtml += "			<th scope='row'>";
				rowHtml += "				<label>Row NR button</label>";
				rowHtml += "			</th>";
				rowHtml += "			<td>";
				rowHtml += "				<input type='text' class='regular-text' value='' name='texts[]'>";
				rowHtml += "			</td>";
				rowHtml += "		</tr>";
				rowHtml += "	</tbody>";
				rowHtml += "	</table>";
				rowHtml += "</li>";
			}
			for(i=previousRows; i<rows; i++)
				$("#featuresBox").append($(rowHtml.replace(/NR/gi, (i+1))));
			$(".css3_vertical_table_slider").slider({
				value: 6,
				max: 30,
				slide: function(event, ui){
					$(this).prev().val(ui.value).trigger("change");
				}
			});
		}
	});
	$("[name='featuresCount[]']").live("keyup change paste", function(event){
		var featuresFieldsContainer = $(this).parent().parent().parent().parent().next();
		var previousFeatures = featuresFieldsContainer.children("li").length;
		var features = parseInt($(this).val());
		$(this).next().slider("option", "value", features);
		var html = "";
		var i;
		if(features>=0 && features<100)
		{
			i=0;
			for(i=features; i<previousFeatures; i++)
				featuresFieldsContainer.children(".css3_vertical_table_features_field"+(i+1)).remove();
			if(features>previousFeatures)
			{
				var featureHtml = "";
				featureHtml += "<li class='css3_vertical_table_features_fieldNR'>"
				featureHtml += "	<input type='text' class='regular-text' value='' name='texts[]'>";
				featureHtml += "</li>";
			}
			for(i=previousFeatures; i<features; i++)
				featuresFieldsContainer.append($(featureHtml.replace(/NR/gi, (i+1))));
		}
	});
	
	$("#css3_vertical_table_settings").one("submit", submitConfigForm);
	function submitConfigForm(event)
	{
		event.preventDefault();
		if($("#shortcodeId").val()!="")
			$(this).submit();
		else
		{
			$("#shortcodeId").addClass("css3_vertical_table_input_error");
			var offset = $("#shortcodeId").offset();
			$(document).scrollTop(offset.top-10);
			$("#css3_vertical_table_settings").one("submit", submitConfigForm);
		}
		
	}
	$("#shortcodeId").bind("keyup paste", function(){
		if($(this).val()!="")
			$(this).removeClass("css3_vertical_table_input_error");
	});
	//sliders
	$("#rows_slider").slider({
		value: 4,
		max: 30,
		slide: function(event, ui){
			$(this).prev().val(ui.value).trigger("change");
		}
	});
	$(".css3_vertical_table_slider").slider({
		value: 6,
		max: 30,
		slide: function(event, ui){
			$(this).prev().val(ui.value).trigger("change");
		}
	});
});
