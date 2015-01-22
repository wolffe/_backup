/*
 * Name: gbAutocomplete
 * Author: Michael Stowe, Ciprian Popescu
 * Version 1.1
 * ---------------------
 * Sends user input via "GET" to a dynamic page with a "q" query, and then takes the
 * pipe-delimited text and returns it as a clickable dropdown list.
 * ---------------------
 * Example: 
 * <input type="text" name="example" id="example" rel="use_this_page_for_results.php">
 * <script>$('#example').autosuggest();< /script>
 * ---------------------
 * Changelog: 
 * ---------------------
 * (c) 2013, http://getbutterfly.com (jQuery update, HTML5 fix, general code cleanup)
 * (c) 2010, http://www.mikestowe.com
 */ 

autosuggest_min_length = 3; // Minimum characters before running ajax check

jQuery.fn.autosuggest = function() {
	return this.each(function(){
		var id = $(this).attr('id');
		var offset = $(this).offset();
		var left = offset.left;
		if($(this).height() == 0)
			var height = 30;
		else
			var height = $(this).height() + 5;

		if($(this).width() == 0)
			var width = 200;
		else
			var width = $(this).width() + 5;

		var top = offset.top + height;
		document.write('<div class="autosuggest" id="autosuggest_' + id + '" style="position: absolute; left: ' + left + 'px; top: ' + top + 'px; width: ' + width + 'px; display: none;"></div>');
		$(this).keyup(
			function() {
				if($('#' + id).val().length >= autosuggest_min_length) {
				$.ajax({
					url: $('#' + id).attr('rel'),
					data: {q: $('#' + id).val()},
					success: function(data) {
						if(data.length > 0) {
							var ret = '';
							var pairs = data.split('|');
							for(var i in pairs) {
								ret += '<a href="javascript: void(0);" onclick="$(\'#' + id + '\').val(\'' + pairs[i] + '\'); $(\'#autosuggest_' + id + '\').hide();">' + pairs[i] + '</a>';
							}
							$('#autosuggest_' + id).html(ret).slideDown('fast');
						} else {
							$('#autosuggest_' + id).slideUp('fast');
						}
					}
				});
			} else {
				$('#autosuggest_' + id).slideUp('fast');
			}
		});
	});
};
