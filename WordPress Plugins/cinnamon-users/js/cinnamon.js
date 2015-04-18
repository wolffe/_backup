jQuery(document).ready(function($) { 
    // profile specific functions
	(function($) {
		$('.tab ul.tabs').addClass('active').find('> li:eq(0)').addClass('current');
        $('.tab ul.tabs li a').click(function (g) { 
            var tab = $(this).closest('.tab'), 
                index = $(this).closest('li').index();

            tab.find('ul.tabs > li').removeClass('current');
            $(this).closest('li').addClass('current');

            tab.find('.tab_content').find('div.tabs_item').not('div.tabs_item:eq(' + index + ')').slideUp();
            tab.find('.tab_content').find('div.tabs_item:eq(' + index + ')').slideDown();

            g.preventDefault();
        });
    })(jQuery);

    // portfolio specific functions
    jQuery("#cinnamon-feature").hide();
    jQuery("#cinnamon-index").hide();
    jQuery(".cinnamon-grid-blank a").click(function(e) {
        e.preventDefault();
        var image = jQuery(this).attr("rel");
        jQuery("#cinnamon-feature").html('<img src="' + image + '" alt="">');
        jQuery("#cinnamon-feature").show();
        jQuery("#cinnamon-index").fadeIn();
    });
    jQuery("#cinnamon-index a").click(function(e) {
        e.preventDefault();
        jQuery("#cinnamon-feature").hide();
        jQuery("#cinnamon-index").hide();
    });
    jQuery(".c-index").click(function() {
        jQuery("#cinnamon-feature").hide();
        jQuery("#cinnamon-index").hide();
    });

    jQuery('#tab li:first').addClass('active');
    jQuery('.tab_icerik').hide();
    jQuery('.tab_icerik:first').show();
    jQuery('#tab li').click(function(e) {
        var index = jQuery(this).index();
        jQuery('#tab li').removeClass('active');
        jQuery(this).addClass('active');
        jQuery('.tab_icerik').hide();
        jQuery('.tab_icerik:eq(' + index + ')').show();
        return false
    });

    jQuery("#cinnamon_sort").change(function(){ this.form.submit(); });
});
