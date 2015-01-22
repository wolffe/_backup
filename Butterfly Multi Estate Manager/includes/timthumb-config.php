<?php
//Image fetching and caching
if(! defined('ALLOW_EXTERNAL') )			define ('ALLOW_EXTERNAL', TRUE);						// Allow image fetching from external websites. Will check against ALLOWED_SITES if ALLOW_ALL_EXTERNAL_SITES is false
if(! defined('ALLOW_ALL_EXTERNAL_SITES') ) 	define ('ALLOW_ALL_EXTERNAL_SITES', TRUE);				// Less secure. 

//Image size and defaults
if(! defined('MAX_WIDTH') ) 			define ('MAX_WIDTH', 3000);									// Maximum image width
if(! defined('MAX_HEIGHT') ) 			define ('MAX_HEIGHT', 3000);								// Maximum image height
if(! defined('DEFAULT_Q') )				define ('DEFAULT_Q', 100);									// Default image quality. Allows overrid in timthumb-config.php
if(! defined('DEFAULT_ZC') )			define ('DEFAULT_ZC', 1);									// Default zoom/crop setting. Allows overrid in timthumb-config.php
?>
