<?php // Database and Config

// -- Connect to MySQL DB -- //

// localhost Linux Box
define('DB_USER', 'root');
define('DB_PASSWORD', 'password');
define('DB_HOST', 'localhost');
define('DB_NAME', 'm20_galleries');

// Display debug error
$dbc = @mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) OR die("Could not connect to MySQL: " . mysql_error());
mysql_select_db(DB_NAME) OR die("Could not select the database: " . mysql_error());

// Display friendy error
//$dbc = @mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) OR die("There was a problem connecting to the database. Please check back later.");
//mysql_select_db(DB_NAME) OR die("<b>MarchTwenty.com:</b> There was a problem connecting to the database. Please check back later.");

// Site Settings
define('SITE_TITLE_LONG', 'MarchTwenty.com');
define('SITE_TITLE', 'MarchTwenty');
define('CMS_VERSION', '2.0.0');
define('EXTENSION', 'm20'); // Note: change value in htaccess file
define('PSPLIT', '||');

// Cookie names
define('COOKIE_USER', 'm20320AUsername');
define('COOKIE_DATE', 'm20320AUserdate');

// Time Settings
date_default_timezone_set("America/Chicago");
$ClockOffset = date('I') - 6;
$CurrentTime = date('g:i a');
$CurrentDate = date('l, F jS, Y');
$UnixDate = date('Y-m-d H:i:s');
$Sunrise = date_sunrise(time(), SUNFUNCS_RET_STRING, 43.04, -87.91, 90, $ClockOffset);
$Sunset = date_sunset(time(), SUNFUNCS_RET_STRING, 43.04, -87.91, 90, $ClockOffset);

// Default blank password
$blankPassword = "aq54c321zx";

?>
