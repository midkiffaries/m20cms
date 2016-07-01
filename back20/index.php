<?php

ini_set('max_input_time', '60');
ini_set('max_execution_time', '30');
ini_set('memory_limit', '8M');
ini_set('output_buffering', '4096');

error_reporting(0);
//error_reporting(E_ALL ^ E_NOTICE);
//ini_set('display_errors', 'On');

// Includes
require_once('include/directories.inc.php');
require_once('include/connect.inc.php');
require_once('include/functions.inc.php');
require_once('include/template.class.php');

// Define the different HTML templates
define('LOGIN_PAGE', 'template/login.tpl.inc');
define('MAIN_PAGE', 'template/default.tpl.inc');

// Set default HTML template
$template = LOGIN_PAGE;

// Check for logout and delete cookies
if ($_GET['p'] == 'logout') {
	setcookie(COOKIE_USER, '', time()-20000);
	setcookie(COOKIE_DATE, '', time()-20000);
	header("Location: " . $siteUrl);
}

// Check for login and if cookies are set
if (isset($_COOKIE[COOKIE_USER]) && isset($_COOKIE[COOKIE_DATE])) {
	// If cookies are set and display main page
	if (matchToDB($_COOKIE[COOKIE_USER], $_COOKIE[COOKIE_DATE])) {
		$template = MAIN_PAGE;
	}
} else {
	// If user input it set
	if (isset($_POST['username']) && isset($_POST['password'])) {
		$username = inputToDB($_POST['username']);
		$password = md5(inputToDB($_POST['password']));
		
		// if username and password are not NULL
		if ($username || $password) { 
			// Open users table
			$result = @mysql_query("SELECT username, password, created FROM Users WHERE username='$username' AND password='$password'");
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			
			// if username and password match, create cookies and login
			if ($username == $row['username'] && $password == $row['password']) {
				setcookie(COOKIE_USER, $row['username'], time()+10800);
				setcookie(COOKIE_DATE, $row['created'], time()+10800);
				$template = MAIN_PAGE;
			}
		}
	} 
}

// Log failed login attempts in a database
if ($template == LOGIN_PAGE && $_POST['username'] && $_POST['password']) {
	$userIP = inputToDB($_SERVER['REMOTE_ADDR']);
	$userBrowser = inputToDB($_SERVER['HTTP_USER_AGENT']);
	$userError = 'u:' . inputToDB($_POST['username']) . ' p:' . inputToDB($_POST['password']);
	$query = @mysql_query("INSERT INTO Logging (ipaddress, browser, error_type) VALUES ('$userIP', '$userBrowser', '$userError')");	
}

// Set p to default and check for errors
if (!$_GET['p']) $_GET['p'] = 'home';
if (!file_exists('content/' . inputToDB($_GET['p']) . '.pg.php')) $_GET['p'] = 'page_not_found';

// Check if page needs Ajax running
if ($_GET['p'] == 'home' || $_GET['p'] == 'system') {
	$onloadJS = "";
} else {
	$onloadJS = " onload=\"loadJS()\"";
}

// Define the class and get the HTML template
$page = new HtmlTemplate();

// HTML template
$page->getTemplate($template);

// Display the 'Users' page depending on user rights
if (userRights($_COOKIE[COOKIE_USER], $_COOKIE[COOKIE_DATE]) == 1) {
	$page->setParameter('PAGE_CONTENT', @file_get_contents('content/' . inputToDB($_GET['p']) . '.pg.php'));
} else {
	if ($_GET['p'] == 'users') {
		$page->setParameter('PAGE_CONTENT', '<p>You do not have the right privilages to view this page.</p>');
	} else {
		$page->setParameter('PAGE_CONTENT', @file_get_contents('content/' . inputToDB($_GET['p']) . '.pg.php'));	
	}
}

// Settings for the page
$page->setParameter('SITE_TITLE', 'm20 Content Management System');
$page->setParameter('VERSION', CMS_VERSION);
$page->setParameter('PAGE_TITLE', makeTitle(inputToDB($_GET['p'])));
$page->setParameter('PAGE_NAME', inputToDB($_GET['p']));
$page->setParameter('COPYRIGHT', date('Y'));
//$page->setParameter('DOMAIN', $currentUrl . dirname($_SERVER['PHP_SELF']));
$page->setParameter('DOMAIN', $currentUrl);
$page->setParameter('ONLOAD_JS', $onloadJS);
$page->setParameter('LAST_LOGIN', $_COOKIE['lastlogin']);
$page->setParameter('LIST_USERS', listCalendarUsers());
$page->setParameter('LIST_BLOGS', listBlogTitles());

// Dispay the page
$page->createPage();
	
?>