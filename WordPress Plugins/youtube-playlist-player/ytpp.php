<?php
/*
Plugin Name: Youtube Playlist Player (Berry Edition)
Plugin URI: http://getbutterfly.com/wordpress-plugins/youtube-playlist-player/
Description: Display a Youtube player with jQuery/HTML5 playlist on any post or page using a simple shortcode.
Version: 4.4.3
Author: Ciprian Popescu
Author URI: http://getbutterfly.com/
License: GPL3

Youtube Playlist Player
Copyright (C) 2013, 2014 Ciprian Popescu (getbutterfly@gmail.com)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.If not, see <http://www.gnu.org/licenses/>.



// CHANGELOG

= 4.4.3 =
* MERGED style-berry.css into main style.css
* MERGED jCarousel code into ytpp-main.js
* UPDATED jCarousel to 0.3.1 (from 0.3.0)
* COMPRESSED style-min.css

= 4.4.2 =
* FIXED iframe missing name
* FIXED deprecated way of getting video title
* COMBINED video title extraction
* UPDATED FontAwesome icons
* UPDATED deprecated way of saving options

= 4.4 =
* FIXED PHP warning
* REMOVED "Now Playing" widget as it was redundant
* CLEANED UP JS file

= 4.3 =
* REMOVED SWFObject script
* REMOVED old player/playlist JS code
* REMOVED old readme.txt file
* CLEANED UP player/playlist code
* FIXED version number
* FIXED inclusion of color picker

*/

define('YTPP_PLUGIN_VERSION', '4.4.3');

register_activation_hook(__FILE__, 'ytpp_install');

function ytpp_install() {
    add_option('ytpp_channel', 'getbutterfly');
    add_option('ytpp_width', 0);
    add_option('ytpp_height', 360);
    add_option('ytpp_flavour', '#CCCCCC');
    add_option('ytpp_flavour_text', '#000000');

    delete_option('ytpp_berry_include');
}

add_action('admin_menu','ytplaylist');

function ytplaylist() {
    add_options_page('Youtube Player', 'Youtube Player', 'manage_options', 'ytpp_options', 'ytpp_options');
}

function ytpp_options() {
	if(isset($_POST['ytpp_submit'])) {
		update_option('ytpp_channel', $_POST['ytpp_channel']);
		update_option('ytpp_width', $_POST['ytpp_width']);
		update_option('ytpp_height', $_POST['ytpp_height']);
		update_option('ytpp_flavour', $_POST['ytpp_flavour']);
		update_option('ytpp_flavour_text', $_POST['ytpp_flavour_text']);

		echo '<div id="message" class="updated fade"><p>Options updated successfully!</p></div>';
	}
    ?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"></div>
		<h2>YouTube Playlist Player (<b>Berry</b> Edition)</h2>
		<div id="poststuff" class="ui-sortable meta-box-sortables">
			<div class="postbox">
				<h3>About Youtube Playlist Player <small>(<a href="http://getbutterfly.com/" rel="external">official web site</a>)</small></h3>
				<div class="inside">
					<p><small>
                        You are using <b>Youtube Playlist Player</b> plugin version <strong><?php echo YTPP_PLUGIN_VERSION; ?></strong>.<br>
                        Dependencies: <a href="http://fontawesome.io/" rel="external">Font Awesome</a> 4.1.0, <a href="http://fancyapps.com/fancybox/" rel="external">Fancybox</a> 2.1.5, <a href="http://sorgalla.com/jcarousel/" rel="external">jCarousel</a> 0.3.1.<br>
                        The plugin requires <code>file_get_contents()</code> function in order to grab Youtube video title and duration.
                    </small></p>

					<form method="post">
                        <h2>General Options</h2>
                        <p>
                            <input type="text" name="ytpp_channel" id="ytpp_channel" value="<?php echo get_option('ytpp_channel'); ?>" placeholder="Channel (or username)"> <label for="ytpp_channel">Channel (or username)</label>
                            <br><small>This field is optional and is required for the <b>[yt_channel]</b> shortcode only</small>
                        </p>
						<p>
                            <input type="number" name="ytpp_width" id="ytpp_width" value="<?php echo get_option('ytpp_width'); ?>" min="0" max="1920"> <label for="ytpp_width">Player width (px)</label>
                            <br><small>Use 0 for full width (responsive) version</small>
                        </p>
						<p><input type="number" name="ytpp_height" id="ytpp_height" value="<?php echo get_option('ytpp_height'); ?>" min="0" max="1920"> <label for="ytpp_height">Player height (px)</label></p>

						<p>
							<label for="ytpp_flavour"><b>Youtube Playlist Player</b> flavour</label>
							<br><input type="text" name="ytpp_flavour" class="ytpp_colorPicker" data-default-color="#cccccc" value="<?php echo get_option('ytpp_flavour'); ?>">
							<br><small>This is the colour of the main video container</small>
						</p>
						<p>
							<label for="ytpp_flavour_text"><b>Youtube Playlist Player</b> text colour</label>
							<br><input type="text" name="ytpp_flavour_text" class="ytpp_colorPicker" data-default-color="#000000" value="<?php echo get_option('ytpp_flavour_text'); ?>">
							<br><small>This is the colour of the text inside the main video container</small>
						</p>

						<p>
							<input name="ytpp_submit" type="submit" class="button-primary" value="Save Changes">
						</p>
                    </form>

                    <h2>Available Shortcode Samples</h2>
                    <p>
                        This shortcode displays the main player and a horizontal playlist:<br>
                        <code>[yt_playlist mainid="eyn0JjLlACg" vdid="eyn0JjLlACg,BxQSEvHdyjQ,B1-wfjq2SmY,SjR6qlLUU1c,k5sMACFpnt0" novd="5"]</code>
                        <br><small>Use the <b>mainid</b> parameter for the main video, <b>vdid</b> for the playlist and <b>novd</b> for the total number of videos. The <b>novd</b> value should match the total number of IDs in the <b>vdid</b> parameter.</small>
                    </p>
                    <p>
                        This shortcode displays an infinite carousel with Fancybox videos:<br>
                        <code>[yt_carousel]eyn0JjLlACg,BxQSEvHdyjQ,B1-wfjq2SmY,SjR6qlLUU1c,k5sMACFpnt0[/yt_carousel]</code>
                        <br><small>The carousel stretches to 100% width, fitting into content areas, sidebars, header or footer.</small>
                    </p>
                    <p>
                        This shortcode displays latest videos from a channel (or username):<br>
                        <code>[yt_channel]</code>
                        <br><small>The player and accordion playlist stretches to 100% width, carousel stretches to 100% width, fitting into content areas, sidebars, header or footer.</small>
                    </p>
				</div>
			</div>
		</div>
	</div>
    <?php
}

function ytpp_enqueue_color_picker() {
    wp_enqueue_script('wp-color-picker');
	wp_enqueue_script('ytpp_colorPicker', plugins_url('js/ytpp-functions.js', __FILE__), array('wp-color-picker'), '1.1', true);
    wp_enqueue_style('wp-color-picker');
}

/* add actions */
add_action('wp_head', 'ytpp_pss');
add_action('admin_enqueue_scripts', 'ytpp_enqueue_color_picker');

/* add shortcodes */
add_shortcode('yt_carousel', 'ytpp_carousel');
add_shortcode('yt_channel', 'ytpp_channel');
add_shortcode('yt_playlist', 'playershow');

function ytpp_pss() {
    wp_enqueue_style('main-css', plugins_url('style-min.css', __FILE__));
    wp_enqueue_style('fa', '//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css');

    wp_enqueue_script('fancybox', plugins_url('fancybox/jquery.fancybox.pack.js', __FILE__), array('jquery'), '', false);
    wp_enqueue_script('ycarousel', plugins_url('js/ytpp-main.js', __FILE__), array('jquery'), '', false);
}

function ytpp_carousel($atts, $content = null) {
    extract(shortcode_atts(array(), $atts));
    if($content) {
        $videos = explode(',', $content);
        $out = '<div class="ycarousel ytpp-berry"><div class="ycarousel-container"><ul>';
        foreach($videos as $video) {
            $video = trim($video);
            $thumb = 'http://img.youtube.com/vi/' . $video . '/hqdefault.jpg';

            $title = ytpp_get_title($video);

            $url = 'http://www.youtube.com/embed/' . $video . '?autoplay=1';
            $out .= sprintf('<li><a class="various fancybox.iframe" href="%s"><img src="%s" width="180" height="135" alt=""><span class="play"></span><span class="title">%s</span></a></li>', $url, $thumb, $title);
        }
        $out .= '</ul></div><a class="ycarousel-prev" href="javascript:void(0);"></a><a class="ycarousel-next" href="javascript:void(0);"></a></div>';
        return $out;
    }
}



function ytpp_get_youtube_id($vurl) {
	parse_str(parse_url($vurl, PHP_URL_QUERY), $myarr);
	return $myarr['v'];
}
function ytpp_channel() {
	$yt_name = get_option('ytpp_channel');
    $ytpp_flavour = get_option('ytpp_flavour');
    $ytpp_flavour_text = get_option('ytpp_flavour_text');

	$url = 'http://gdata.youtube.com/feeds/api/videos?max-results=3&alt=json&orderby=published&format=5&author=' . $yt_name . '';

	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
	$data = curl_exec($ch);
	curl_close($ch);

    $search = json_decode($data, $assoc = true);

	$vidarray = array();
	$i = 0;
	?>
	<script>
	function loadVideo(vid,clicked) {
        jQuery('#vgal_bigvid').html('<iframe width="100%" height="<?php echo get_option('ytpp_height'); ?>" src="http://www.youtube.com/embed/' + vid + '" frameborder="0" allowfullscreen></iframe>');
    }
	</script>

    <?php
    $ryt = '<div class="accordion ytpp-berry" id="vgal_youtube">';
        foreach($search['feed']['entry'] as $video) {
            $video_url 		= $video['link'][0]['href'];
            $video_thumb 	= $video['media$group']['media$thumbnail'][0]['url'];
            $video_id 		= ytpp_get_youtube_id($video_url);
            $video_time 	= number_format($video['media$group']['media$content'][0]['duration']/60, 2, ':', ':');

            if($i == 0) {
                $fvideo = '<div id="vgal_bigvid"><iframe width="100%" height="' . get_option('ytpp_height') . '" src="http://www.youtube.com/embed/' . $video_id . '" frameborder="0" allowfullscreen></iframe></div>';
            }
            $ryt .= '<h2 id="vgal_youtube_video_' . $i . '" class="vgal_youtube_video"><img src="' . $video_thumb . '" width="100"> ' . $video['title']['$t'] . '</h2>';
            $ryt .= '<div id="vgal_youtube_video_' . $i . '" class="vgal_youtube_video">';
                $ryt .= '<img src="' . $video_thumb . '" alt="">';
                $ryt .= '<a href="javascript: void(0);" onclick="loadVideo(\'' . $video_id . '\',' . $i . ');">' . $video['title']['$t'] . '</a><br><small>' . $video_time . '</small>';
            $ryt .= '</div>';
            $ryt .= '<div class="ytpp-clear"></div>';
            $i++;
        }
    $ryt .= '</div>';

    $lyt = '<div id="vgal_wrapper">';
    $lyt .= $fvideo;
    $lyt .= $ryt;
    $lyt .= '<div style="clear: both;">&nbsp;</div>';
    $lyt .= '</div>';

    return $lyt;
}

function ytpp_get_title($vid) {
    $videoTitle = file_get_contents("http://gdata.youtube.com/feeds/api/videos/${vid}?v=2&fields=title");

    preg_match("/<title>(.+?)<\/title>/is", $videoTitle, $titleOfVideo);
    return $titleOfVideo[1];
}

function playershow($atts) {
    extract(shortcode_atts(array(
        'id' => '',
        'mainid' => '',
        'vdid' => '',
        'novd' => ''
    ), $atts));

    $ytpp_width = get_option('ytpp_width');
    $ytpp_height = get_option('ytpp_height');

    $pl = '
    <script>
    jQuery(window).bind("load", function() {
        jQuery("#ytpp-title' . $id . '").html("' . addslashes(ytpp_get_title($mainid)) . '");

        jQuery("#ytplayer_div2' . $id . ' a").click(function() {
            jQuery("#ytpp-title' . $id . '").html(jQuery(this).attr("rel"));
            jQuery("#ytplayer_div2' . $id . ' a").removeClass("active");
            jQuery(this).addClass("active");
        })
        jQuery("#ytplayer_div2' . $id . ' a").mouseover(function(){
            jQuery("#ytpp-title' . $id . '").html(jQuery(this).attr("rel"));
        })
    });
    </script>';

    if($novd > 1) {
        $l3 = '<div class="ytpdiv" id="ytplayer_div2' . $id . '">';
            $video_pieces = explode(',', $vdid);
            foreach($video_pieces as $video_element) {
                $l3 .= '<a href="http://www.youtube.com/embed/' . $video_element . '?enablejsapi=1&amp;rel=0&amp;fs=1&amp;hd=1&amp;version=3&amp;cc_load_policy=0&amp;color=white&amp;iv_load_policy=3&amp;modestbranding=1&amp;showinfo=0&amp;theme=light&amp;autohide=1&amp;html5=1&amp;autoplay=1" rel="' . htmlentities(ytpp_get_title($video_element)) . '" target="ytpl-frame' . $id . '"><img src="http://img.youtube.com/vi/' . $video_element . '/hqdefault.jpg"></a>';
            }
        $l3 .= '</div>';
    }

    if(get_option('ytpp_width') != 0)
        $ytpp_width = get_option('ytpp_width');
    else
        $ytpp_width = '100%';
    $ytpp_height = get_option('ytpp_height');
    $ytpp_flavour = get_option('ytpp_flavour');
    $ytpp_flavour_text = get_option('ytpp_flavour_text');

    return '
    <div class="main_box ytpp ytpp-berry" style="background-color: ' . $ytpp_flavour . '; color: ' . $ytpp_flavour_text . '; width: ' . $ytpp_width . 'px;">
        <iframe id="ytpl-frame' . $id . '" name="ytpl-frame' . $id . '" type="text/html" rel="' . $mainid . '" width="' . $ytpp_width . '" height="' . $ytpp_height . '" src="http://www.youtube.com/embed/' . $mainid . '?enablejsapi=1&rel=0&fs=1&hd=1&version=3&cc_load_policy=0&color=white&iv_load_policy=3&modestbranding=1&showinfo=0&theme=light&autohide=1&html5=1&autoplay=0&origin=' . home_url() . '" frameborder="0"></iframe>
        ' . $pl . '
        <div class="ytpp-playlist-container">' . $l3 . '</div>
        <div class="ytpp-title" id="ytpp-title' . $id . '"></div>
    </div>
    ';
}
?>
