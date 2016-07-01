<?php // Ajax Processor

error_reporting(0);
//error_reporting(E_ALL ^ E_NOTICE);
//ini_set('display_errors', 'On');

// Includes
require_once('directories.inc.php');
require_once('connect.inc.php');
require_once('functions.inc.php');

// Check for cross-site scripting
if (strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) > 7 || !strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'])) die();

// Check for login cookies
if (!isset($_COOKIE[COOKIE_USER]) && !isset($_COOKIE[COOKIE_DATE])) die();

// Default number of table rows to display at a time
$tableLimit = 20;

// Clean the incoming data
$formItem0 = inputToDB(intval($_POST['id'])); // row ID
$formItem1 = inputToDB($_POST['item1']); // user input
$formItem2 = inputToDB($_POST['item2']); // user input
$formItem3 = inputToDB($_POST['item3']); // user input
$formItem4 = inputToDB($_POST['item4']); // user input
$formItem5 = inputToDB($_POST['item5']); // user input
$formItem6 = inputToDB($_POST['item6']); // user input
$formItem7 = inputToDB($_POST['item7']); // user input
$formItem8 = inputToDB($_POST['item8']); // user input
$textBox = stripJavaScript(inputToDB($_POST['textBox'])); // user input from textbox
$monthOffset = addslashes(intval($_POST['monthOffset'])); // Calendar month offset
$listOrder = inputToDB($_POST['listOrder']); // sort by
$Filter = inputToDB($_POST['Filter']); // filter results
$tableIndex = addslashes(intval($_POST['tableIndex'])); // table position

// Select the corresponding page
switch (trim($_POST['p'])) {
	case 'users':
		// Users
		include('page.users.inc.php');
		break;
	case 'blog':
		// Blog
		include('page.blog.inc.php');
		break;
	case 'calendar':
		// Calendar
		include('page.calendar.inc.php');
		break;
	case 'comments':
		// Comments
		include('page.comments.inc.php');
		break;
	case 'files':
		// Files
		include('page.files.inc.php');
		break;
	case 'gallery':
		// Gallery
		include('page.gallery.inc.php');
		break;
	case 'page':
		// Page
		include('page.page.inc.php');
		break;
	case 'poll':
		// Page
		include('page.polls.inc.php');
		break;
	default:
		echo "Error";
		break;
}

// Output back to the page
define('SPLIT', '|||');

// return the number of rows in the table
if ($_POST['p'] == 'files') {
	if ($rowCount == NULL) $rowCount = 0; 
	echo $rowCount;
} else {
	echo countRows($Table);
}

echo SPLIT . $displayTable . "</table>"; // create the table
echo SPLIT . $errorReport; // display any errors
echo SPLIT . $formItem0; // row ID
echo SPLIT . $formItem1; // return user input
echo SPLIT . $formItem2; // return user input
echo SPLIT . $formItem3; // return user input
echo SPLIT . $formItem4; // return user input
echo SPLIT . $formItem5; // return user input
echo SPLIT . $formItem6; // return user input
echo SPLIT . $formItem7; // return user input
echo SPLIT . $formItem8; // return user input
echo SPLIT . $textBox; // return user input

mysql_close();
?>