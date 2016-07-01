<?php // Generate poll

// Includes
require_once('back20/include/directories.inc.php');
require_once('back20/include/connect.inc.php');
require_once('back20/include/functions.inc.php');

$poll = inputToDB($_GET['p']);
//$poll = 2;

$result = @mysql_query("SELECT * FROM Polls WHERE id='$poll'");

echo "<form name=\"form\" action=\"poll.php\" method=\"post\">";

while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	echo "<h3>" . $row['question'] . "</h3>";
	$Answers = explode(PSPLIT, stripslashes($row['answers']));
	for ($i = 0; $i < 7; $i++) {
		if ($Answers[$i]) {
			echo "<p><input type=\"radio\" name=\"poll\" id=\"p" . $i . "\" value=\"" . $i . "\" /><label for=\"p" . $i . "\">" . $Answers[$i] . "</label><p>";
		}
	}
	//echo "<p>Created by: " . $row['author'] . " on " . $row['date'] . "</p>";
}

echo "<p><input type=\"submit\" value=\"Vote\" /></p>";
echo "</form>";
 
?>
<style type="text/css">
<!--
body {
	font-size: 100%;
	font-family: verdana;
}
div#Poll span {
	height: 16px;
	font-size: 80%;
	color: #FFFFFF;
	background: #6CB6D9 url(poll-bar.png) repeat-x 0 0;
	border: 1px solid #227399;
	overflow: show;
}
-->
</style>
<h3>Bar Test</h3>
<div id="Poll">
	<div><span style="padding-right:150px"></span> 200 <small>votes</small></div>
	<div><span style="padding-right:10px"></span> 10 <small>votes</small></div>
</div>