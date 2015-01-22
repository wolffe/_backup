<?php
/*
 * TinTin Image Resizer
 * Version: 1.1
 * Author: Ciprian Popescu
 *
 * November 10, 2011 (First release)
 *
 * Parameters need to be passed in through the URL's query string:
 * i			absolute path of local image starting with "/" (e.g. /images/toast.jpg)
 * w			maximum width of final image in pixels (e.g. 700)
 * h			maximum height of final image in pixels (e.g. 700)
 * q			(optional, 0-100, default: 90) quality of output image
 * nocache		(optional) does not read image from the cache
 *
 * Example
 *
 * Resizing a JPEG:
 * <img src="tintin.php?i=/images/image.jpg&amp;w=100&amp;h=100&amp;q=100" alt="">
 *
 * Copyright (c) 2012, 2013 Ciprian Popescu
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * and associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies
 * or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT
 * LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

if(!isset($_GET['i'])) {
	header('HTTP/1.1 400 Bad Request');
	echo 'Error: no image was specified';
	exit();
}

//define('MEMORY_TO_ALLOCATE',	'100M');
define('DEFAULT_QUALITY',	90);
define('CURRENT_DIR',		dirname(__FILE__));
define('CACHE_DIR',			CURRENT_DIR . '/tinbin/');
define('DOCUMENT_ROOT',		$_SERVER['DOCUMENT_ROOT']);

// Images must be local files, so for convenience we strip the domain if it's there
$image = preg_replace('/^(s?f|ht)tps?:\/\/[^\/]+/i', '', (string) $_GET['i']);

// For security, directories cannot contain ':', images cannot contain '..' or '<', and images must start with '/'
if($image{0} != '/' || strpos(dirname($image), ':') || preg_match('/(\.\.|<|>)/', $image)) {
	header('HTTP/1.1 400 Bad Request');
	echo 'Error: malformed image path. Image paths must begin with \'/\'';
	exit();
}

// If the image doesn't exist, or we haven't been told what it is, there's nothing that we can do
if(!$image) {
	header('HTTP/1.1 400 Bad Request');
	echo 'Error: no image was specified';
	exit();
}

// Strip the possible trailing slash off the document root
$docRoot = preg_replace('/\/$/', '', DOCUMENT_ROOT);

if(!file_exists($docRoot.$image)) {
	header('HTTP/1.1 404 Not Found');
	echo 'Error: image does not exist: '.$docRoot.$image;
	exit();
}

// Get the size and MIME type of the requested image
$size = getimagesize($docRoot.$image);
$mime = $size['mime'];

// Make sure that the requested file is actually an image
if(substr($mime, 0, 6) != 'image/') {
	header('HTTP/1.1 400 Bad Request');
	echo 'Error: requested file is not an accepted type: ' . $docRoot . $image;
	exit();
}

$width		= $size[0];
$height		= $size[1];

$maxWidth	= (isset($_GET['w'])) ? (int) $_GET['w'] : 0;
$maxHeight	= (isset($_GET['h'])) ? (int) $_GET['h'] : 0;

// If either a max width or max height are not specified, we default to something
// large so the unspecified dimension isn't a constraint on our resized image.
// If neither are specified, we aren't going to be resizing at all.
if(!$maxWidth && $maxHeight)
	$maxWidth	= 99999999999999;
elseif($maxWidth && !$maxHeight)
	$maxHeight	= 99999999999999;
elseif(!$maxWidth && !$maxHeight) {
	$maxWidth	= $width;
	$maxHeight	= $height;
}

// If we don't have a max width or max height, OR the image is smaller than both
// we do not want to resize it, so we simply output the original image and exit
if((!$maxWidth && !$maxHeight) || ($maxWidth >= $width && $maxHeight >= $height)) {
	$data = file_get_contents($docRoot . '/' . $image);

	/* // if file_get_contents is disabled use cURL
	$ch = curl_init();
	$timeout = 5; // set to zero for no timeout
	curl_setopt ($ch, CURLOPT_URL, $docRoot.'/'.$image);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$file_contents = curl_exec($ch);
	curl_close($ch);
	$data = $file_contents;
	*/

	$lastModifiedString	= gmdate('D, d M Y H:i:s', filemtime($docRoot . '/' . $image)) . ' GMT';
	$etag				= md5($data);
	
	doConditionalGet($etag, $lastModifiedString);
	
	header("Content-type: $mime");
	header('Content-Length: ' . strlen($data));
	echo $data;
	exit();
}

// Ratio cropping
$offsetX	= 0;
$offsetY	= 0;

$ratioComputed		= $width / $height;
$cropRatioComputed	= (float) $maxWidth / (float) $maxHeight;

if($ratioComputed < $cropRatioComputed) { // Image is too tall so we will crop the top and bottom
	$origHeight	= $height;
	$height		= $width / $cropRatioComputed;
	$offsetY	= ($origHeight - $height) / 2;
}
else if($ratioComputed > $cropRatioComputed) { // Image is too wide so we will crop off the left and right sides
	$origWidth	= $width;
	$width		= $height * $cropRatioComputed;
	$offsetX	= ($origWidth - $width) / 2;
}

// Setting up the ratios needed for resizing. We will compare these below to determine how to
// resize the image (based on height or based on width)
$xRatio		= $maxWidth / $width;
$yRatio		= $maxHeight / $height;

if($xRatio * $height < $maxHeight) { // Resize the image based on width
	$tnHeight	= ceil($xRatio * $height);
	$tnWidth	= $maxWidth;
}
else {// Resize the image based on height
	$tnWidth	= ceil($yRatio * $width);
 	$tnHeight	= $maxHeight;
}

// Determine the quality of the output image
$quality = (isset($_GET['q'])) ? (int) $_GET['q'] : DEFAULT_QUALITY;

// Before we actually do any crazy resizing of the image, we want to make sure that we
// haven't already done this one at these dimensions. To the cache!
// Note, cache must be world-readable

// We store our cached image filenames as a hash of the dimensions and the original filename
$resizedImageSource = $tnWidth . 'x' . $tnHeight . 'x' . $quality;
$resizedImageSource .= '-' . $image;
$resizedImage = md5($resizedImageSource);
$resized = CACHE_DIR . $resizedImage;

// Check the modified times of the cached file and the original file.
// If the original file is older than the cached file, then we simply serve up the cached file
if(!isset($_GET['nocache']) && file_exists($resized)) {
	$imageModified	= filemtime($docRoot . $image);
	$thumbModified	= filemtime($resized);

	if($imageModified < $thumbModified) {
		$data = file_get_contents($resized);

		/* // if file_get_contents is disabled use cURL
		$ch = curl_init();
		$timeout = 5; // set to zero for no timeout
		curl_setopt ($ch, CURLOPT_URL, $resized);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$file_contents = curl_exec($ch);
		curl_close($ch);
		$data = $file_contents;
		*/

		$lastModifiedString	= gmdate('D, d M Y H:i:s', $thumbModified) . ' GMT';
		$etag = md5($data);
		
		doConditionalGet($etag, $lastModifiedString);
		
		header("Content-type: $mime");
		header('Content-Length: ' . strlen($data));
		echo $data;
		exit();
	}
}

// We don't want to run out of memory
//ini_set('memory_limit', MEMORY_TO_ALLOCATE);

// Set up a blank canvas for our resized image (destination)
$dst = imagecreatetruecolor($tnWidth, $tnHeight);

// Set up the appropriate image handling functions based on the original image's mime type
switch($size['mime']) {
	case 'image/gif':
		// We will be converting GIFs to PNGs to avoid transparency issues when resizing GIFs
		// This is maybe not the ideal solution, but IE6 can suck it
		$creationFunction	= 'ImageCreateFromGif';
		$outputFunction		= 'ImagePng';
		$mime				= 'image/png'; // We need to convert GIFs to PNGs
		$doSharpen			= FALSE;
		$quality			= round(10 - ($quality / 10)); // We are converting the GIF to a PNG and PNG needs a compression level of 0 (no compression) through 9
	break;
	
	case 'image/x-png':
	case 'image/png':
		$creationFunction	= 'ImageCreateFromPng';
		$outputFunction		= 'ImagePng';
		$doSharpen			= FALSE;
		$quality			= round(10 - ($quality / 10)); // PNG needs a compression level of 0 (no compression) through 9
	break;
	
	default:
		$creationFunction	= 'ImageCreateFromJpeg';
		$outputFunction	 	= 'ImageJpeg';
		$doSharpen			= TRUE;
	break;
}

// Read in the original image
$src = $creationFunction($docRoot.$image);

if(in_array($size['mime'], array('image/gif', 'image/png'))) {
	imagealphablending($dst, false);
	imagesavealpha($dst, true);
}

// Resample the original image into the resized canvas we set up earlier
imagecopyresampled($dst, $src, 0, 0, $offsetX, $offsetY, $tnWidth, $tnHeight, $width, $height);

if($doSharpen) {
	// Sharpen the image based on two things:
	//	(1) the difference between the original size and the final size
	//	(2) the final size
	$sharpness	= findSharp($width, $tnWidth);

	$sharpenMatrix	= array(
		array(-1, -2, -1),
		array(-2, $sharpness + 12, -2),
		array(-1, -2, -1)
	);
	$divisor		= $sharpness;
	$offset			= 0;
	imageconvolution($dst, $sharpenMatrix, $divisor, $offset);
}

// Make sure the cache exists. If it doesn't, then create it
if (!file_exists(CACHE_DIR))
	mkdir(CACHE_DIR, 0755);

// Make sure we can read and write the cache directory
if(!is_readable(CACHE_DIR)) {
	header('HTTP/1.1 500 Internal Server Error');
	echo 'Error: the cache directory is not readable';
	exit();
}
else if(!is_writable(CACHE_DIR)) {
	header('HTTP/1.1 500 Internal Server Error');
	echo 'Error: the cache directory is not writable';
	exit();
}

// Write the resized image to the cache
$outputFunction($dst, $resized, $quality);

// Put the data of the resized image into a variable
ob_start();
$outputFunction($dst, null, $quality);
$data = ob_get_contents();
ob_end_clean();

// Clean up the memory
imagedestroy($src);
imagedestroy($dst);

// See if the browser already has the image
$lastModifiedString	= gmdate('D, d M Y H:i:s', filemtime($resized)) . ' GMT';
$etag				= md5($data);

doConditionalGet($etag, $lastModifiedString);

// Send the image to the browser with some delicious headers
header("Content-type: $mime");
header('Content-Length: ' . strlen($data));
echo $data;

function findSharp($orig, $final) {
	$final	= $final * (750.0 / $orig);
	$a		= 52;
	$b		= -0.27810650887573124;
	$c		= .00047337278106508946;

	$result = $a + $b * $final + $c * $final * $final;
	return max(round($result), 0);
}

// This is the only rule that depends completely on the server setup.
// An ETag uniquely identifies a file, and is used to verify if the file
// in the browser's cache matches the file on the server.
//
// The problem is that they are generated using attributes specific
// to the server (inodes - http://en.wikipedia.org/wiki/Inode) they're
// being served from. This implies that when, for example, you’re using
// multiple servers behind a load balancer, you may one time be accessing
// the files from server 1, another time the files from server 2.
// And since the ETags don't match, you'll be downloading the file again!
//
// Solution: If you're using multiple servers, disable ETags.
// For Apache users: add this line to your httpd.conf: FileETag none
function doConditionalGet($etag, $lastModified) {
	header("Last-Modified: $lastModified");
	header("ETag: \"{$etag}\"");

	$if_none_match = isset($_SERVER['HTTP_IF_NONE_MATCH']) ?
		stripslashes($_SERVER['HTTP_IF_NONE_MATCH']) : 
		false;

	$if_modified_since = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ?
		stripslashes($_SERVER['HTTP_IF_MODIFIED_SINCE']) :
		false;

	if(!$if_modified_since && !$if_none_match)
		return;

	if($if_none_match && $if_none_match != $etag && $if_none_match != '"' . $etag . '"')
		return; // etag is there but doesn't match

	if($if_modified_since && $if_modified_since != $lastModified)
		return; // if-modified-since is there but doesn't match

	// Nothing has changed since their last request - serve a 304 and exit
	header('HTTP/1.1 304 Not Modified');
	exit();
}
?>
