<?php

error_reporting(0);
//error_reporting(E_ALL ^ E_NOTICE);
//ini_set('display_errors', 'On');

// Check for cross-site scripting
//if (strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) > 7 || !strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'])) die();

// Define
define('SPLIT', '||');

// Includes
require_once('../back20/include/directories.inc.php');
require_once('../back20/include/connect.inc.php');
require_once('../back20/include/functions.inc.php');

// Clean input
$poll = strip_tags(inputToDB($_POST['poll']));
$pollID = strip_tags(inputToDB($_POST['pollID']));


///////////
// Polls
///////////

// Add a vote to the current poll
if ($pollID) {
	$result = @mysql_query("SELECT results FROM Polls WHERE id='$pollID'");
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	
	// Break up stored results
	$Answers = explode(SPLIT, $row['results']);
	$Answers[$poll]++;

	// Assemble results
	for ($i=0; $i<7; $i++) {
		$Results .= $Answers[$i] . SPLIT;
	}
	
	// Update entry
	$query = @mysql_query("UPDATE Polls SET results='$Results' WHERE id='$pollID'");

	// Display results of poll
	$result = @mysql_query("SELECT * FROM Polls WHERE id='$poll'");
	$row = mysql_fetch_array($resultPage, MYSQL_ASSOC);
	$ReturnPoll .= "<div id=\"Question\">" . $row['question'] ."</div>\n";
	$p = 0;
	$Answers = explode("||", $row['answers']);
	$Results = explode("||", $row['results']);
	
	foreach ($Answers as $answerValue) {
		$ReturnPoll .= "<div><strong>" . $Results[$p] . "</strong> &gt; " . $answerValue . "</div>\n";
		$p++;
	}
}		

///////////////////////////////////////
// Return the data back to the client
///////////////////////////////////////

echo $ReturnPoll . SPLIT . $_POST['return1'];
?>