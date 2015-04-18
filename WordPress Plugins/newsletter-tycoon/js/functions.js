jQuery(document).ready(function() {
	jQuery('#tycoon_csv_upload').click(function() {
		formfield = jQuery('#tycoon_csv_file').attr('name');
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		return false;
	});

	/*
	window.send_to_editor = function(html) {
		imgurl = jQuery('img',html).attr('src');
		jQuery('#tycoon_csv_file').val(imgurl);
		tb_remove();
	}
	*/
});
