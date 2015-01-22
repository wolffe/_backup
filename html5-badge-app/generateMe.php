<?php
// THE GATHERING v0.99
putenv('GDFONTPATH=' . realpath('.'));

$idnumber = trim(html_entity_decode($_GET['idnumber']));
$didnumber = trim(html_entity_decode($_GET['didnumber']));
$idtype = trim(html_entity_decode($_GET['idtype']));

// FUNCTIONS
function fitImageToSize($filename, $width_new, $height_new) {
	$src_x  = 0; $src_y  = 0;

	// Get dimensions of original image
	list($width_old, $height_old) = getimagesize($filename);

	// Resize & crop image based on smallest ratio
	if(($width_old/$height_old) < ($width_new/$height_new)) {
		// Determine Resize ratio on width
		$ratio = $width_new/$width_old;
		// Detemine cropping dimensions for height
		$crop = $height_old - ($height_new/$ratio);
		$height_old = $height_old - $crop;
		$src_y = floor($crop/2);
	} else {
		// Detemine Resize ratio on height
		$ratio = $height_new/$height_old;
		// Detemine cropping dimensions for width
		$crop = $width_old - ($width_new/$ratio);
		$width_old = $width_old - $crop;
		$src_x = floor($crop/2);
	}

	$image_old = imagecreatefromjpeg($filename);
	$image_new = imagecreatetruecolor($width_new, $height_new);
	imagecopyresampled($image_new, $image_old, 0, 0, $src_x, $src_y, $width_new, $height_new, $width_old, $height_old);
	return $image_new;
}
function hex_to_rgb($hex) {
	if(substr($hex,0,1) == '#') // remove '#'
		$hex = substr($hex,1);
	if(strlen($hex) == 3) { // expand short form ('fff') color to long form ('ffffff')
		$hex = substr($hex,0,1) . substr($hex,0,1) . substr($hex,1,1) . substr($hex,1,1) . substr($hex,2,1) . substr($hex,2,1);
	}
	// convert from hexidecimal number systems
	$rgb['red'] 	= hexdec(substr($hex,0,2));
	$rgb['green'] 	= hexdec(substr($hex,2,2));
	$rgb['blue'] 	= hexdec(substr($hex,4,2));
	return $rgb;
}

//
$text_small = 'Row 1 Lorem Ipsum' . "\n" . 'Row 2 Dolor' . "\n";
$itemimage = fitImageToSize('avatar.jpg', 624, 500);

$image = imagecreatefrompng('idtemplate.png');
$font_color 	= '#FFFFFF';
$font_rgb 		= hex_to_rgb($font_color);
$font_color 	= ImageColorAllocate($image, $font_rgb['red'], $font_rgb['green'], $font_rgb['blue']);

imagecopymerge($image, $itemimage, 8, 100, 0, 0, 624, 500, 100);

imagettftext($image, 36, 0, 8, 690, $font_color, 'QlassikBold_TB.ttf', 'Badge Title');
imagettftext($image, 32, 0, 8, (690 + 64), $font_color, 'QlassikBold_TB.ttf', 'Badge Subtitle');
imagettftext($image, 18, 0, 8, (780 + 32), $font_color, 'Qlassik_TB.ttf', $text_small);
imagettftext($image, 24, 0, 488,  (780 + 155), $font_color, 'Qlassik_TB.ttf', 'Badge Corner');

header('Content-type: image/png');
imagepng($image, ''.$idtype.$idnumber.'.png');
ImageDestroy($image);
exit;
?>
