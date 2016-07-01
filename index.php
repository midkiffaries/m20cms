<?php // Base site

ini_set('max_input_time', '60');
ini_set('max_execution_time', '30');

error_reporting(0);
//error_reporting(E_ALL ^ E_NOTICE);
//ini_set('display_errors', 'On');

// Includes
require_once('back20/include/directories.inc.php');
require_once('back20/include/connect.inc.php');
require_once('back20/include/functions.inc.php');
require_once('back20/include/template.class.php');

// Set default HTML template
$template = 'template/default.tpl.inc';

// Clean user url get
$webPage = strip_tags(inputToDB($_GET['p']));
$Entry = intval(strip_tags(inputToDB($_GET['e'])));
$bPage = intval(strip_tags(inputToDB($_GET['o'])));
 
// Clean Contact Us post
$mailName = strip_tags(inputToDB($_POST['mailName']));
$mailEmail = strip_tags(inputToDB($_POST['mailEmail']));
$mailMsg = strip_tags(inputToDB($_POST['mailMsg']));

// Set the full blog page list index
if (!$bPage) {
	$bPage = 0;
	$hideNewer = " style=\"display:none\"";
}
$Limit = $bPage * 10;
$Older = $bPage + 1;
$Newer = $bPage - 1;

$rowCount = 0;
$Columns = 3;

// Today's Date
$Now = date('Y-m-d');

// Set p to default and check for errors
if (!$webPage) $webPage = 'Home';

// Display the current web page
switch ($webPage) {
	// Single blog entry
	case 'Search':
		// Clean query input
		if ($_GET['q']) {
			$searchQuery = strip_tags(inputToDB($_GET['q']));
		} else {
			$searchQuery = strip_tags(inputToDB($_POST['q']));
		}
	
		// Break apart query
		if ($searchQuery) {
			$query = explode(" ", $searchQuery);
		} else {
			$query = explode(" ", "search");
		}
		$PageContent .= "<form name=\"form\" method=\"post\" action=\"Search." . EXTENSION . "\">Keywords <input type=\"text\" name=\"q\" size=\"35\" maxlength=\"100\" value=\"\" class=\"tBorder\" /><input type=\"submit\" value=\"Search\" /> &nbsp;&nbsp;<small>You can also <a href=\"http://www.google.com/search?q=site:" . $_SERVER['HTTP_HOST'] . "+" . inputToDB($_POST['q']) . "\" class=\"link\">search this site with Google</a>.</small></form>";
		$PageContent .= "<p>Results from the query for <strong>" . $searchQuery . "</strong>.</p>";
		
		// Search results from blogs
		foreach ($query as $queryWord) {
			$resultPage = @mysql_query("SELECT * FROM Blogs WHERE title LIKE '%$queryWord%' OR catagories LIKE '%$queryWord%' OR content LIKE '%$queryWord%' OR created LIKE '%$queryWord%' ORDER BY id DESC LIMIT 0,25");
		}
		$PageContent .= "<h1>Blog Entries</h1>";
		while ($row = mysql_fetch_array($resultPage, MYSQL_ASSOC)) {
			$PageContent .= "<div class=\"searchResult\">";
			$PageContent .= "<a href=\"" . $currentUrl . "/" . $row['id'] . ".blog" . "\">" . stripslashes($row['title']) . "</a> <span>" . convertDate($row['created']) . " by " . getFullName($row['author']) . "</span>";
			$PageContent .= "<div>" . textTrim(strip_tags(stripWikiText(stripslashes($row['content']))), 400) . "</div>";
			$PageContent .= "</div>\n";
		}
		
		// Search results from web pages
		foreach ($query as $queryWord) {
			$resultPage = @mysql_query("SELECT * FROM Pages WHERE catagories LIKE '%$queryWord%' OR content LIKE '%$queryWord%' ORDER BY id ASC LIMIT 0,25");
		}
		$PageContent .= "<h1>Pages</h1>";
		while ($row = mysql_fetch_array($resultPage, MYSQL_ASSOC)) {
			$PageContent .= "<div class=\"searchResult\">";
			$PageContent .= "<a href=\"" . $row['title'] . "." . EXTENSION . "\">" . stripslashes($row['title']) . "</a>";
			$PageContent .= "<div>" . textTrim(strip_tags(stripWikiText(stripslashes($row['content']))), 400) . "</div>";
			$PageContent .= "</div>";
		}
		// Search results from calendar
		foreach ($query as $queryWord) {
			$resultPage = @mysql_query("SELECT * FROM Calendar WHERE what LIKE '%$queryWord%' OR catagories LIKE '%$queryWord%' OR content LIKE '%$queryWord%' ORDER BY id DESC LIMIT 0,25");
		}
		$PageContent .= "<h1>Calendar Events</h1>";
		while ($row = mysql_fetch_array($resultPage, MYSQL_ASSOC)) {
			$PageContent .= "<div class=\"searchResult\">";
			$PageContent .= "<a href=\"" . $currentUrl . "/" . $row['id'] . ".event" . "\">" . stripslashes($row['what']) . "</a> <span>" . convertDate($row['whenFrom']) . " to " . convertDate($row['whenTo']) . "</span>";
			$PageContent .= "<div>" . textTrim(strip_tags(stripWikiText(stripslashes($row['content']))), 400) . "</div>";
			$PageContent .= "</div>\n";
		}
		break;
		
	// View the video gallery items
	case 'Animations':
		$resultPage = @mysql_query("SELECT content FROM Pages WHERE title='Gallery'");
		$row = mysql_fetch_array($resultPage, MYSQL_ASSOC);
		$PageContent .= makeHTML(stripslashes($row['content']));
		$resultPage = @mysql_query("SELECT content FROM Pages WHERE title='Animations'");
		$row = mysql_fetch_array($resultPage, MYSQL_ASSOC);
		$PageContent .= makeHTML(stripslashes($row['content']));
		$resultPage = @mysql_query("SELECT * FROM Gallery WHERE catagories LIKE '%animation%' ORDER BY id DESC");
		while ($row = mysql_fetch_array($resultPage, MYSQL_ASSOC)) {
			$PageContent .= "<div class=\"Video\"><a href=\"" . $row['filename'] . "\" class=\"link\">" . stripslashes($row['title']) . "</a></div>";
			$PageContent .= makeHTML(stripslashes($row['content']));
			$PageContent .= "<div class=\"gTags\">Filed under &nbsp;" . separateCatagories($row['catagories']) . "</div>\n";
		}
		break;
	// View the still images gallery
	case 'Renderings':
		$resultPage = @mysql_query("SELECT content FROM Pages WHERE title='Gallery'");
		$row = mysql_fetch_array($resultPage, MYSQL_ASSOC);
		$PageContent .= makeHTML(stripslashes($row['content']));
		$resultPage = @mysql_query("SELECT content FROM Pages WHERE title='Renderings'");
		$row = mysql_fetch_array($resultPage, MYSQL_ASSOC);
		$PageContent .= makeHTML(stripslashes($row['content']));
		$PageContent .= displayAlbum($galleryDir . 'renderings/', $galleryUrl . 'renderings/', 4);
		break;
	// View the Websites gallery
	case 'Websites':
		$resultPage = @mysql_query("SELECT content FROM Pages WHERE title='Gallery'");
		$row = mysql_fetch_array($resultPage, MYSQL_ASSOC);
		$PageContent .= makeHTML(stripslashes($row['content']));
		$resultPage = @mysql_query("SELECT content FROM Pages WHERE title='Websites'");
		$row = mysql_fetch_array($resultPage, MYSQL_ASSOC);
		$PageContent .= makeHTML(stripslashes($row['content']));
		//$PageContent .= displayAlbum($galleryDir . 'websites/', $galleryUrl . 'websites/', 4);
		$resultPage = @mysql_query("SELECT * FROM Gallery WHERE catagories LIKE '%website%' ORDER BY title ASC");
		$PageContent .= "<table cellspacing=\"3\" class=\"Gallery\">";
		$PageContent .= "<tr>";
		while ($row = mysql_fetch_array($resultPage, MYSQL_ASSOC)) {
			if ((($rowCount % $Columns) ? 1 : 2) == 2) $PageContent .= "</tr><tr>";
			$PageContent .= "<td><a href=\"" . $mediaUrl . $row['filename'] . "\"><img src=\"thumbnail.php?t=" . $mediaUrl . $row['filename'] . "\" alt=\"View image\" /><br /><strong>" . $row['title'] . "</strong></a>" . makeHTML($row['content']) . "</td>";
			$rowCount++;
		}
		$PageContent .= "</tr>";
		$PageContent .= "</table>";
		break;
	// View the Design gallery
	case 'Design':
		$resultPage = @mysql_query("SELECT content FROM Pages WHERE title='Gallery'");
		$row = mysql_fetch_array($resultPage, MYSQL_ASSOC);
		$PageContent .= makeHTML(stripslashes($row['content']));
		$resultPage = @mysql_query("SELECT content FROM Pages WHERE title='Websites'");
		$row = mysql_fetch_array($resultPage, MYSQL_ASSOC);
		$PageContent .= makeHTML(stripslashes($row['content']));
		//$PageContent .= displayAlbum($galleryDir . 'websites/', $galleryUrl . 'websites/', 4);
		$resultPage = @mysql_query("SELECT * FROM Gallery WHERE catagories LIKE '%design%' ORDER BY title ASC");
		$PageContent .= "<table cellspacing=\"3\" class=\"Gallery\">";
		$PageContent .= "<tr>";
		while ($row = mysql_fetch_array($resultPage, MYSQL_ASSOC)) {
			if ((($rowCount % $Columns) ? 1 : 2) == 2) $PageContent .= "</tr><tr>";
			$PageContent .= "<td><a href=\"" . $mediaUrl . $row['filename'] . "\"><img src=\"thumbnail.php?t=" . $mediaUrl . $row['filename'] . "\" alt=\"View image\" /><br /><strong>" . $row['title'] . "</strong></a>" . makeHTML($row['content']) . "</td>";
			$rowCount++;
		}
		$PageContent .= "</tr>";
		$PageContent .= "</table>";
		break;
	// Display all blogs
	case 'Blogs':
		$TagCloud = "<div id=\"TagCloud\"><div id=\"CloudTitle\">Tags</div><div id=\"CloudWords\">" . generateTagCloud() . "</div></div>";
		$resultPage = @mysql_query("SELECT * FROM Blogs ORDER BY id DESC LIMIT $Limit,10");
		while ($row = mysql_fetch_array($resultPage, MYSQL_ASSOC)) {
			$boxColor = NULL;
			if (date("N", strtotime($row['created'])) > 5) $boxColor = ' dateWeekend';
			if (date("Ymj", strtotime($row['created'])) == date("Ymj", strtotime($CurrentDate))) $boxColor = ' date1';
			if (date("Ymj", strtotime($row['created'])) == (date("Ymj", strtotime($CurrentDate)) - 1)) $boxColor = ' date2';
			if (date("Ymj", strtotime($row['created'])) == (date("Ymj", strtotime($CurrentDate)) - 2)) $boxColor = ' date3';
			$PageContent .= "<div class=\"Blog\">";
			$PageContent .= "<div class=\"Head\"><div class=\"boxDate" . $boxColor . "\" title=\"" . fullDate($row['created']) . "\">" . stackDate($row['created']) . "</div><div class=\"boxTitle\"><a href=\"" . $currentUrl . "/" . $row['id'] . ".blog\">" . stripslashes($row['title']) . "</a></div></div>\n";
			$PageContent .= "<div class=\"BlogContent\">" . makeHTML(stripslashes($row['content'])) . "</div>";
			$PageContent .= "<div class=\"Author\">~ <a href=\"" . validateEmail(getEmail($row['author'])) . "\" class=\"mail\">" . getFullName($row['author']) . "</a> at " . convertTimeOnly($row['created']) . "</div>\n";
			$PageContent .= "</div>\n";	
		}
		$PageContent .= "<div id=\"BlogNav\"><a href=\"?o=$Older\" class=\"Older\">Older Blogs</a> &nbsp; <a href=\"?o=$Newer\" class=\"Newer\"$hideNewer>Newer Blogs</a></div>";
		//$PageContent .= "<form name=\"blogMonth\" method=\"post\" action=\"Search." . EXTENSION . "\"><select name=\"q\">" . blogMonth() . "</select> <input type=\"submit\" value=\"Go\" /></form>";
		break;
	// Single blog entry
	case 'Blog':
		$resultPage = @mysql_query("SELECT * FROM Blogs WHERE id='$Entry'");
		$row = mysql_fetch_array($resultPage, MYSQL_ASSOC);
		$boxColor = NULL;
		$bIndex = countTableRows($row['id'], 'Blogs');
		if (date("N", strtotime($row['created'])) > 5) $boxColor = ' dateWeekend';
		if (date("Ymj", strtotime($row['created'])) == date("Ymj", strtotime($CurrentDate))) $boxColor = ' date1';
		if (date("Ymj", strtotime($row['created'])) == (date("Ymj", strtotime($CurrentDate)) - 1)) $boxColor = ' date2';
		if (date("Ymj", strtotime($row['created'])) == (date("Ymj", strtotime($CurrentDate)) - 2)) $boxColor = ' date3';
		$PageContent .= "<div class=\"Blog\">";
		$PageContent .= "<div class=\"Head\"><div class=\"boxDate" . $boxColor . "\" title=\"" . fullDate($row['created']) . "\">" . stackDate($row['created']) . "</div><div class=\"boxTitle\">" . stripslashes($row['title']) . "</div></div>\n";
		$PageContent .= "<div class=\"BlogContent\">" . makeHTML(stripslashes($row['content'])) . "</div>";
		$PageContent .= "<div class=\"Author\">~ <a href=\"" . validateEmail(getEmail($row['author'])) . "\" class=\"mail\">" . getFullName($row['author']) . "</a> at " . convertTimeOnly($row['created']) . "</div>\n";
		$PageContent .= "<div class=\"Catagories\"><div class=\"tags\">Filed under &nbsp;" . separateCatagories($row['catagories']) . "</div><div>Add to &nbsp;" . displaySocialBookmarks($currentUrl . "/" . $row['id'] . ".blog", $row['title']) . "</div></div>\n";
		$PageContent .= "</div>\n";
		$PageContent .= "<div id=\"BlogNav\"><a href=\"" . ($bIndex - 1) . ".blog\" class=\"Older\">Previous Blog</a> &nbsp; <a href=\"" . ($bIndex + 1) . ".blog\" class=\"Newer\">Next Blog</a></div>";
		break;

	// Display the full calendar
	case 'Calendar':
		if ($Entry) {
			$resultPage = @mysql_query("SELECT * FROM Calendar WHERE catagories LIKE '%$Entry%' AND whenFrom > '$Now' ORDER BY whenFrom ASC LIMIT 0,20");
		} else {
			$resultPage = @mysql_query("SELECT * FROM Calendar WHERE whenFrom > '$Now' ORDER BY whenFrom ASC LIMIT 0,20");
		}
		while ($row = mysql_fetch_array($resultPage, MYSQL_ASSOC)) {
			$PageContent .= "<div class=\"Entry\">";
			$PageContent .= "<div><a href=\"" . $row['id'] . ".event\">" . stripslashes($row['what']) . "</a>";
			if ($row['whenFrom'] == $row['whenTo']) { 
				$PageContent .= "<span>" . convertDateOnly($row['whenFrom']) . "</span></div>\n";
			} else {
				$PageContent .= "<span>" . convertDate($row['whenFrom']) . " &nbsp;<strong>to</strong>&nbsp; " . convertDate($row['whenTo']) . "</span></div>\n";			
			}
			$PageContent .= makeHTML(stripslashes($row['content']));
			$PageContent .= "</div>\n";
		}
		break;		
	// Single calendar event
	case 'Event':
		$resultPage = @mysql_query("SELECT * FROM Calendar WHERE id='$Entry'");
		$row = mysql_fetch_array($resultPage, MYSQL_ASSOC); 
		$PageContent .= "<div><strong>" . stripslashes($row['what']) . "</strong></div>\n";
		if ($row['whenFrom'] == $row['whenTo']) {
			$PageContent .= "<div><strong>When:</strong> " . convertDateOnly($row['whenFrom']) . " <em>(all day)</em></div>\n";				
		} else {
			$PageContent .= "<div><strong>When:</strong> " . convertDate($row['whenFrom']) . " to " . convertDate($row['whenTo']) . "</div>\n";
		}
		$PageContent .= "<div><strong>Where:</strong> " . stripslashes($row['location']) . "</div>";
		$PageContent .= "<div class=\"BlogContent\">" . makeHTML(stripslashes($row['content'])) . "</div>\n";
		$PageContent .= "<div class=\"Catagories\">Filed under: ";
		$PageContent .= separateCatagories($row['catagories']);
		$PageContent .= "</div>\n";
		break;

	// Display all polls
	case 'Polls':
		$resultPage = @mysql_query("SELECT * FROM Polls ORDER BY id ASC");
		while ($row = mysql_fetch_array($resultPage, MYSQL_ASSOC)) {
			$PageContent .= "<div id=\"Question\">" . $row['question'] ."</div>\n";
			$p = 0;
			$Answers = explode("||", $row['answers']);
			$Results = explode("||", $row['results']);
			foreach ($Answers as $answerValue) {
				$PageContent .= "<div><strong>" . $Results[$p] . "</strong> &gt; " . $answerValue . "</div>\n";
				$p++;
			}
			$PageContent .= "<div>Created by: " . getName($row['author']) . " on " . convertDate($row['date']) . "</div>";
		}
		break;
		
	// Display the Contact Us page
	case 'Contact':
		$resultPage = @mysql_query("SELECT content FROM Pages WHERE title='Contact'");
		$row = mysql_fetch_array($resultPage, MYSQL_ASSOC);
		$PageContent .= makeHTML(stripslashes($row['content']));
		$PageContent .= "<noscript>JavaScript must be enabled to use this form.</noscript>";
		$PageContent .= "<form name=\"form\">\n";
		$PageContent .= "<table width=\"96%\">\n";
		$PageContent .= "<tr><th width=\"90\">Name:</th><td><input type=\"text\" name=\"mailName\" value=\"\" size=\"50\" maxlength=\"55\" class=\"tBorder\" /></td></tr>\n";
		$PageContent .= "<tr><th>Email:</th><td><input type=\"text\" name=\"mailEmail\" value=\"\" size=\"50\" maxlength=\"55\" class=\"tBorder\" /></td></tr>\n";
		$PageContent .= "</table>\n";
		$PageContent .= "<textarea name=\"mailMsg\" rows=\"10\" cols=\"42\" class=\"tBorder\"></textarea>\n";
		$PageContent .= "<div><strong style=\"margin-right:12px\">Spam check:</strong> 2 + 3 = <input type=\"text\" name=\"mailCheck\" value=\"\" size=\"2\" maxlength=\"2\" class=\"tBorder\" /> <input type=\"button\" value=\"  Send Message  \" onclick=\"contactSubmit()\" style=\"margin-left:180px\" /><div>\n";
		$PageContent .= "<div id=\"ContactError\">One or more fields were not completed.</div>";
		$PageContent .= "</form>\n";
		break;
		
	// Display the results of the Contact Us form
	case 'SendMail':
		if ($mailName && $mailEmail && $mailMsg && $_POST['mailCheck'] == 5) {
			sendEmail($mailName, $mailEmail, $mailMsg);
			$PageContent .= "<p>Thank you. I will try and get back to you as soon as I can.</p>";
			$PageContent .= "<p><a href=\"" . $currentUrl . "\" class=\"Back\">Return to the home page</a></p>";
		} else {
			header('contact.' . EXTENSION);
		}
		break;
		
	// Display an Error
	case 'Error':
		$PageContent .= "<p>The page you are looking for does not exist.</p>";
		$PageContent .= "<div id=\"BlogNav\"><a href=\"javascript:history.go(-1)\" class=\"Older\">Please return to the previous page</a></div>";
		break;
		
	// Display a specific page from the DB
	default:
		$resultPage = @mysql_query("SELECT * FROM Pages WHERE title='$webPage'");
		$row = mysql_fetch_array($resultPage, MYSQL_ASSOC);
		if ($row['title']) {
			$PageContent .= makeHTML(stripslashes($row['content']));
		} else {
			$PageContent .= "<p>The page you are looking for does not exist.</p>";
			$PageContent .= "<div id=\"BlogNav\"><a href=\"javascript:history.go(-1)\" class=\"Older\">Please return to the previous page</a></div>";
		}
		break;
}

// Display the side-by-side panels on the homepage
//if ($webPage == 'Home') {
	// Display a few of the most recent blog entries
	$resultBlogs = @mysql_query("SELECT * FROM Blogs ORDER BY id ASC LIMIT 0,6");
	while ($row = mysql_fetch_array($resultBlogs, MYSQL_ASSOC)) {
		//$Blogs .= "<div class=\"E\"><a href=\"" . $currentUrl . "/" . $row['id'] . ".blog\">" . $row['title'] . "<span>&nbsp;&nbsp;" . convertDate($row['date']) . "</span></a></div>\n";
		$Blogs .= "<div class=\"E\"><div class=\"boxDate\">" . stackDate($row['date']) . "</div><div class=\"boxTitle\"><a href=\"" . $currentUrl . "/" . $row['id'] . ".blog\">" . stripslashes($row['title']) . "</a></div></div>\n";
	}
	
	// Display the most recent calendar headlines
	$resultEvents = @mysql_query("SELECT * FROM Calendar WHERE whenFrom > '$Now' ORDER BY id ASC LIMIT 0,6");
	while ($row = mysql_fetch_array($resultEvents, MYSQL_ASSOC)) {
		if ($row['whenFrom'] == $row['whenTo']) {
			//$EventsDate = convertDateOnly($row['whenFrom']);
		} else {
			//$EventsDate = convertDate($row['whenFrom']);
			$EventsDate = " <small>at " . convertTimeOnly($row['whenFrom']) . "</small>";	
		}
		//$Events .= "<div><a href=\"" . $currentUrl . "/" . $row['id'] . ".event\">" . $row['what'] . "<span>&nbsp;&nbsp;" . $EventsDate . "</span></a></div>\n";
		$Events .= "<div class=\"E\"><div class=\"boxDate\">" . stackDate($row['whenFrom']) . "</div><div class=\"boxTitle\"><a href=\"" . $currentUrl . "/" . $row['id'] . ".event\">" . stripslashes($row['what']) . $EventsDate . "</a></div></div>\n";
	}

	// Display the most recently created poll
	$resultPolls = @mysql_query("SELECT * FROM Polls ORDER BY id ASC LIMIT 0,1");
	while ($row = mysql_fetch_array($resultPolls, MYSQL_ASSOC)) {
		$Polls .= "<h2>" . $row['question'] ."</h2>\n";
		$p = 0;
		$Answers = explode("||", $row['answers']);
		foreach ($Answers as $answerValue) {
			$Polls .= "<div><input type=\"radio\" name=\"poll\" id=\"p" . $p . "\" value=\"" . $p . "\" /> <label for=\"p" . $p . "\">" . $answerValue . "</label></div>\n";
			$p++;
		}
		$Polls .= "<input type=\"hidden\" name=\"pollID\" value=\"" . $row['id'] ."\" />\n";
	}
//}

// Define the class and get the HTML template
$page = new HtmlTemplate();

// HTML template
$page->getTemplate($template);

// Settings for the page
$page->setParameter('SITE_TITLE', SITE_TITLE_LONG);
$page->setParameter('PAGE_TITLE', makeTitle($webPage));
//$page->setParameter('CHANGE_IMAGE', '1');
$page->setParameter('COPYRIGHT', date('Y'));
$page->setParameter('COPYRIGHT_ROMAN', numberToRoman(date('Y')));
$page->setParameter('EXT', EXTENSION);
$page->setParameter('DOMAIN', $currentUrl);
$page->setParameter('PAGE_CONTENT', $PageContent);
$page->setParameter('NIGHT', dayOrNight());
$page->setParameter('TAG_CLOUD', $TagCloud);
//$page->setParameter('DISPLAY_EVENTS', $Events);
//$page->setParameter('DISPLAY_BLOGS', $Blogs);
//$page->setParameter('DISPLAY_POLLS', $Polls);

// Dispay the page
$page->createPage();
	
?>