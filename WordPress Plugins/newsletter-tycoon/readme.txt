=== Newsletter Tycoon ===

Contributors: Ciprian Popescu
Tags: newsletter, subscription, subscribe, tycoon, send, email
License: GPLv3
Requires at least: 3.3
Tested up to: 3.5.1
Stable tag: 1.5.2

== Description ==

This plugin allows users to subscribe and receive a newsletter containing the blog latest posts. The newsletter subscription system features a double opt-in system, with email confirmation. Administrators can also activate subscribers.

== Installation ==

Upload and activate the plugin.

== Changelog ==

= 1.5.3 =
* Fixed 5 warnings for WordPress 3.6

= 1.5.2 =
* Added subscription form shortcode with mandatory parameters
* Added mail sender name
* Changed subscription form button label to an option, instead of a widget field (also hardcoded and unfinished get_option code)
* Optimized a .js file calling AJAX routines
* Fixed unlocalized strings
* Fixed misspelled version number
* Fixed a number input field
* Removed deprecated email validation check
* Gmail won't accept CSS styles so don't bother with it

= 1.5.1 =
* Restricted direct access to plugin files
* Removed shortcodes from content
* Removed caption shortcode from content

= 1.5 =
* Changed a nl2br into wpautop for better WordPress compatibility
* Added compressed WordPress core styles for image alignment and caption rendering
* Added license declaration and license.txt (GPL v3)
* Tested the plugin with latest 3.5.1-beta1 and 3.6-alpha

= 1.4.1.2 =
* Added configurable button label (subscription form)
* Added PDF documentation (instead of HTML)

= 1.4.1.1 =
* Changed author field to display name (instead of user login)

= 1.4.1 =
* Added option to send any of the available post types (such as pages or custom post types)
* Fixed author field not appearing
* Fixed a WordPress 3.5 deprecated function

= 1.4 =
* Added images to full posts (not excerpts)
* Added translated strings (not 100%) (en_US and en_GB)
* Confirmed WordPress 3.5-beta compatibility
* Lots of speed improvements (PHP, CSS and HTML5)

= 1.3.7 =
* Fixed more path bugs
* Rearchitectured plugin installation and database structure
* Removed the deprecated 'Preview' function
* Added pagination to subscribers list
* Added CSV import/export function
* Various performance updates

= 1.3.6 =
* Fixed a path bug

= 1.3.5 =
* All tags are now HTML5 valid
* Removed a deprecated get_author_name() function
* Added a more consistent newsletter template (with explanations)
* Fixed general plugin details (textdomain, author, plugin settings, path)
* Fixed the dreaded "You do not have sufficient permissions to access this page." error

= 1.3.4 =
* Removed hardcoded plugin path

= 1.3.3 =
* Added editor fields for newsletter template
* Added a clearing div before the widget text
* Removed 'small' attribute for widget text

= 1.3.2 =
* Fixed WordPress error reporting issue
* Several speed improvements

= 1.3.1 =
* Updated author links
* Fixed WordPress 3.2 compatibility
* Optimized the preview window and the underlying Javascript
* Removed author ads

= 1.0a =
* First release (updated)
