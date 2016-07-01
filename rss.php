<?php // XML RSS realtime generator

ini_set('max_input_time', '60');
ini_set('max_execution_time', '30');

error_reporting(0);
//error_reporting(E_ALL ^ E_NOTICE);
//ini_set('display_errors', 'On');

// File type
header("Content-type: application/xml");

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
$page->getTemplate('template/rss.tpl.xml');

// RSS header information
$page->setParameter('TITLE', SITE_TITLE);
$page->setParameter('DESCRIPTION', 'Blogs, calendars, everything about Ted Balmer');
$page->setParameter('COPYRIGHT', '(c) 2007 Ted Balmer');
$page->setParameter('URL_LINK', 'http://www.marchtwenty.com/');
$page->setParameter('IMG_URL', 'template/layout/logo.png');
$page->setParameter('IMG_WIDTH', '112');
$page->setParameter('IMG_HEIGHT', '120');
$page->setParameter('EMAIL', 'tbalmer@marchtwenty.com');
$page->setParameter('CATAGORY', $Feed);

// Select RSS source
switch ($Feed) {
	case 'calendar': // Create calendar RSS
		// Page title
		$page->setParameter('TITLE', SITE_TITLE . '.com Events');
	
		// Get data from the Calendar table
		$Now = date('Y-m-d');
		$result = @mysql_query("SELECT * FROM Calendar WHERE whenFrom > '$Now' ORDER BY whenFrom ASC LIMIT 0,15");
	
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$RSSItems .= "<item>\n";
			$RSSItems .= "\t<title>" . htmlspecialchars($row['what']) . " on " . date('M j, Y', strtotime($row['whenFrom'])) . "</title>\n";
			$RSSItems .= "\t<description>" . stripslashes(htmlspecialchars(makeHTML($row['content']))) . "</description>\n";
			$RSSItems .= "\t<guid>" . $currentUrl . '/' . $row['id'] . ".calendar</guid>\n";
			$RSSItems .= "\t<pubDate>" . $row['date'] . "</pubDate>\n";
			$RSSItems .= "</item>\n";
		}
		break;
	case 'blog': // Create blog RSS
		// Page title
		$page->setParameter('TITLE', SITE_TITLE . '.com Blog');
		
		// Get data from the Blogs table
		$result = @mysql_query("SELECT * FROM Blogs ORDER BY id DESC LIMIT 0,10");
	
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$RSSItems .= "<item>\n";
			$RSSItems .= "\t<title>" . htmlspecialchars($row['title']) . "</title>\n";
			$RSSItems .= "\t<description>" . stripslashes(htmlspecialchars(makeHTML($row['content']))) . "</description>\n";
			$RSSItems .= "\t<author>" . getFullName($row['author']) . "</author>\n";
			$RSSItems .= "\t<catagory>" . $row['catagories'] . "</catagory>\n";
			$RSSItems .= "\t<guid>" . $currentUrl . '/' . $row['id'] . ".blog</guid>\n";
			$RSSItems .= "\t<pubDate>" . ($row['created']) . "</pubDate>\n";
			$RSSItems .= "</item>\n";
		}
		break;
	case 'podcast': // Create podcast RSS
		// Page title
		$page->setParameter('TITLE', SITE_TITLE . ' Podcast');
	
		// Get data from the Podcast table
		$Now = date('Y-m-d');
		$result = @mysql_query("SELECT * FROM Podcast ORDER BY id ASC LIMIT 0,10");
	
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$RSSItems .= "<item>\n";
			$RSSItems .= "\t<title>" . htmlspecialchars($row['title']) . "</title>\n";
			$RSSItems .= "\t<description>" . stripslashes(htmlspecialchars(makeHTML($row['content']))) . "</description>\n";
			$RSSItems .= "\t<author>" . SITE_TITLE . "</author>\n";
			$RSSItems .= "\t<pubDate>" . $row['date'] . "</pubDate>\n";
			$RSSItems .= "\t<catagory>" . $row['catagories'] . "</catagory>\n";
			$RSSItems .= "\t<guid>" . $currentUrl . '/media/' . $row['filename'] . "</guid>\n";
			$RSSItems .= "\t<itunes:author>" . SITE_TITLE . "</itunes:author>\n";
			$RSSItems .= "\t<itunes:subtitle>" . SITE_TITLE . "</itunes:subtitle>\n";
			$RSSItems .= "</item>\n";
		}
		break;
	default: // Create anything-from-catagory RSS
		// Page title
		$page->setParameter('TITLE', SITE_TITLE . ' ' . ucfirst($Feed));
	
		// Get data from the Calendar table
		$Now = date('Y-m-d');
		$result = @mysql_query("SELECT * FROM Calendar WHERE whenFrom > '$Now' AND catagories LIKE '%$Feed%' ORDER BY id ASC LIMIT 0,15");
	
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$RSSItems .= "<item>\n";
			$RSSItems .= "\t<title>" . htmlspecialchars($row['what']) . " (" . date('M j, Y \@ g:ia', strtotime($row['whenFrom'])) . ")</title>\n";
			$RSSItems .= "\t<description>" . stripslashes(htmlspecialchars(makeHTML($row['content']))) . "</description>\n";
			$RSSItems .= "\t<guid>" . $currentUrl . '/' . $row['id'] . ".event</guid>\n";
			$RSSItems .= "\t<pubDate>" . $row['date'] . "</pubDate>\n";
			$RSSItems .= "</item>\n";
		}
		break;
}

$page->setParameter('RSS_ITEMS', $RSSItems);

$page->createPage();
?>