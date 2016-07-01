<?php // iCal Calendar generator

ini_set('max_input_time', '60');
ini_set('max_execution_time', '30');

error_reporting(0);
//error_reporting(E_ALL ^ E_NOTICE);
//ini_set('display_errors', 'On');

// File type
header("Content-type: text/calendar");

// Includes
require_once('back20/include/directories.inc.php');
require_once('back20/include/connect.inc.php');
require_once('back20/include/functions.inc.php');
require_once('back20/include/template.class.php');

// Clean input
$Feed = inputToDB($_GET['r']);

// Define the class and get the HTML template
$page = new HtmlTemplate();

// HTML template
$page->getTemplate('template/ical.tpl.ics');

// RSS header information
$page->setParameter('TITLE', SITE_TITLE);
$page->setParameter('DESCRIPTION', 'Blogs, calendars, everything about me');

// Select RSS source
switch ($Feed) {
	default: // Create anything-from-catagory RSS
		// Page title
		$page->setParameter('TITLE', SITE_TITLE . ' ' . ucfirst($Feed));
	
		// Get data from the Calendar table
		$Now = date('Y-m-d');
		$result = @mysql_query("SELECT * FROM Calendar WHERE whenFrom > '$Now' AND catagories LIKE '%$Feed%' ORDER BY id ASC LIMIT 0,15");
	
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$CalItems .= "BEGIN:VEVENT";		
			$CalItems .= "DTSTART:" . iCalDate($row['whenFrom']);
			$CalItems .= "DTEND:" . iCalDate($row['whenTo']);
			$CalItems .= "LOCATION:" . $row['location'];
			$CalItems .= "SUMMARY:" . $row['what'];
			$CalItems .= "END:VEVENT";
		}
		break;
}

$page->setParameter('CALENDAR_EVENTS', $CalItems);

$page->createPage();
?>