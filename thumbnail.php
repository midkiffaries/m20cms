<?php // Generate JPEG thumbnail image

ini_set('max_input_time', '60');
ini_set('max_execution_time', '30');

error_reporting(0);
//error_reporting(E_ALL ^ E_NOTICE);
//ini_set('display_errors', 'On');

// Generate JPEG thumbnail image
header("Content-type: image/jpeg");

require_once('back20/include/functions.inc.php');

// Thumbnail size
if (intval($_GET['w']) && intval($_GET['h'])) {
	$w = intval(removeSpaces($_GET['w']));
	$h = intval(removeSpaces($_GET['h']));
} else {
	$w = 133;
	$h = 99;
}

// Check if its an image or to generate a shadow
if ($_GET['t'] == 'S') {
	print imagedestroy(resizeImage('template/graphics/shadowbox.jpg', $w, $h));
} else {
	print imagedestroy(resizeImage(cleanVarUrl(removeSpaces($_GET['t'])), $w, $h));
}

?>