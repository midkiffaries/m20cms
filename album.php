<?php // Generate photo album from directory location

ini_set('max_input_time', '120');
ini_set('max_execution_time', '30');

error_reporting(0);
//error_reporting(E_ALL ^ E_NOTICE);
//ini_set('display_errors', 'On');

// Includes
require_once('back20/include/directories.inc.php');
require_once('back20/include/functions.inc.php');
require_once('back20/include/template.class.php');

// Define the class and get the HTML template
$page = new HtmlTemplate();

// HTML template
$page->getTemplate('template/album.tpl.inc');

// Header information
$page->setParameter('SITE_TITLE', 'Photo Album');
$page->setParameter('PAGE_TITLE', makeTitle(cleanVarUrl($_GET['g'])));
$page->setParameter('COPYRIGHT', date('Y'));
$page->setParameter('DOMAIN', $currentUrl);

if ($_GET['g'] == 'gallery') {
	$gUrl = $galleryUrl;
	$gDir = $galleryDir;
} else {
	$gUrl = $galleryUrl . cleanVarUrl($_GET['g']) . '/';
	$gDir = $galleryDir . cleanVarUrl($_GET['g']) . '/';
}

$rowCount = 0;

if ($handle = opendir($gDir)) {
	$displayTable .= "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"3\">";
	$displayTable .= "<tr>";
	while (false !== ($file = readdir($handle))) {
		$rowBreak = ($rowCount % 4) ? 1 : 2;
	
		if ($file != '.' && $file != '..' && file_Image(file_Ext($file))) {
			if ($rowBreak == 2) $displayTable .= "</tr><tr>";
			
			$displayTable .= "<td><a href=\"" . $gUrl . $file . "\"><img src=\"thumbnail.php?t=" . $gUrl . $file . "\" alt=\"\" /><br /><strong>" . file_StripExt($file) . "</strong><br />" . file_Date($gDir . $file) . "<br />" . imageSize($gDir . $file) . " pixels</a></td>";
			$rowCount++;
		}
	}
	$displayTable .= "</tr>";
	$displayTable .= "</table>";
	closedir($handle);
}

$page->setParameter('PAGE_CONTENT', $displayTable);

$page->createPage();

?>