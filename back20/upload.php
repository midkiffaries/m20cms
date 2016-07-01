<?php

ini_set('max_input_time', '240');
ini_set('max_execution_time', '30');
ini_set('memory_limit', '10M');
ini_set('output_buffering', '4096');

error_reporting(0);
//error_reporting(E_ALL ^ E_NOTICE);
//ini_set('display_errors', 'On');

// Max file size
ini_set('apc.max_file_size', '10M');

// Includes
require_once('include/directories.inc.php');
require_once('include/connect.inc.php');
require_once('include/functions.inc.php');
require_once('include/template.class.php');

// Check for cross-site scripting
if (strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) > 7 || !strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'])) die();

// Check for login cookies
if (!isset($_COOKIE[COOKIE_USER]) && !isset($_COOKIE[COOKIE_DATE])) die();

// Set default HTML template
$template = 'template/upload.tpl.inc';

// Get the file name
$FileName = stripslashes(basename($_FILES['uploadedfile']['name']));

// Get file extension
$target_ext = file_Ext($FileName);
$target_catagory = file_Catagory($target_ext);

// Upload Directory
$target_path = $mediaDir . $FileName;  

// Upload File
if ($_POST['process']) {
	// Max filesize = 10 MB
	if (file_Disallow($target_ext) && $_FILES['uploadedfile']['size'] < 10500000) {
		stripDecimals(stripslashes($_FILES['uploadedfile']['tmp_name']));
		
		// Upload file
		if (move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
			chmod($target_path, 0755);
			//chown($target_path, 'root');
			$FileTitle = file_StripExt($FileName);
			$FileAuthor = getUsernameCookie($_COOKIE[COOKIE_USER]);
			$query = @mysql_query("INSERT INTO Gallery (title, author, catagories, filename, date) VALUES ('$FileTitle', '$FileAuthor', '$target_catagory,', '$FileName', '$UnixDate')");
			header("Location: files.cms");
			exit();
		} else {
			// Error
			$response = "There was an error uploading the file, please try again.";
		}
	} else {
		// Error
		$response = "There was an error uploading the file, please try again.";
	}
}

// Define the class and get the HTML template
$page = new HtmlTemplate();

// HTML template
$page->getTemplate($template);

// Settings for the page
$page->setParameter('SITE_TITLE', 'm20 Content Management System');
$page->setParameter('VERSION', CMS_VERSION);
$page->setParameter('PAGE_TITLE', 'Upload');
$page->setParameter('PAGE_NAME', $_GET['p']);
$page->setParameter('COPYRIGHT', date('Y'));
$page->setParameter('DOMAIN', $currentUrl);
//$page->setParameter('DOMAIN', $currentUrl);
$page->setParameter('RESPONSE', $response);

// Dispay the page
$page->createPage();
	
?>