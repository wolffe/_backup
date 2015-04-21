=== Cinnamon Boards ===
Contributors: Ciprian Popescu
Tags: forum, community, message, topic, thread, category, board
License: GPLv2
Requires at least: 4.0
Tested up to: 4.1.1
Stable tag: 3.3

== Description ==

Cinnamon Boards is a WordPress forum plugin with a light footprint, responsive structure and user accessibility. The forum uses custom post types and all information is structured as a forum (categories, forums and topics). It can easily be integrated into any theme without losing any of its functionality.

== Installation ==

1. Upload the 'cinnamon-board' folder to your '/wp-content/plugins/' directory
2. Activate the plugin via the Plugins menu in WordPress
4. A new Cinnamon Boards menu will appear in WordPress with options and general help

== Changelog ==

= 3.3 =
* FIX: Fixed custom post type generation routine
* FIX: Removed comment filtering as post type doesn't allow comments anyway
* FEATURE: Added private forums, accessible for registered members only

= 3.2 =
* FIX: Fixed WordPress UI item (added switchable option)
* FIX: Fixed media upload role taking over all content types

= 3.1.1 =
* IMPROVEMENT: Improved avatar column appearance
* IMPROVEMENT: Used date format as defined by WordPress

= 3.1 =
* FIX: Fixed children count for forums
* FIX: Removed hardcoded font size
* FIX: Added box-sizing for all forum elements
* FIX: Fixed user post count
* FIX: Fixed category/forum ordering
* FIX: Hidden screen reader text for frontend editor
* IMPROVEMENT: Moved core features to main plugin file
* IMPROVEMENT: Added configurable slug
* IMPROVEMENT: Lots of tiny fixes
* IMPROVEMENT: Removed deprecated custom meta value for forum position and implemented menu_order (will now work with menu ordering plugins)
* IMPROVEMENT: Added file upload capability

= 3.0.2 =
* FIX: Removed "x" showing in top left corner
* FIX: Fixed plugin version
* FIX: Added Pure option to plugin activation
* FIX: Added normalize.css option to plugin activation

= 3.0.1 =
* FEATURE: Added category count
* FEATURE: Added forum count
* FEATURE: Added thread count
* IMPROVEMENT: Removed image columns and replaced them with FontAwesome icons
* IMPROVEMENT: Added Pure CSS library (optional)
* IMPROVEMENT: Added normalize.css library (optional)
* IMPROVEMENT: Added wp_editor() to textareas
* FIX: Removed hardcoded colours
* UPDATE: Updated FontAwesome to 4.2.0

= 3.0-beta2 =
* FEATURE: Added colour picker for background and accent colour
* IMPROVEMENT: Improved CSS styles and rearranged some elements

= 3.0-beta =
* First public release
