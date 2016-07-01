<?php

// Check for cross-site scripting
if (strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) > 7 || !strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'])) die();

// Table name
$Table = 'Polls';

// Create table header
$displayTable = createHeader('Question', 'Results', 'Author', 'Date');

// Final text clean-up specific to content
$formItem1 = strip_tags($formItem1); // Question
$formItem2 = strip_tags($formItem2); // Answer 1
$formItem3 = strip_tags($formItem3); // Answer 2
$formItem4 = strip_tags($formItem4); // Answer 3
$formItem5 = strip_tags($formItem5); // Answer 4
$formItem6 = strip_tags($formItem6); // Answer 5
$formItem7 = strip_tags($formItem7); // Answer 6
$formItem8 = strip_tags($formItem8); // Answer 7
$author = getUsernameCookie(inputToDB($_COOKIE[COOKIE_USER]));
$pollResults = "0||0||0||0||0||0||0";

// Put answers into one table entry
$Answers = $formItem2 . PSPLIT . $formItem3. PSPLIT . $formItem4. PSPLIT . $formItem5. PSPLIT . $formItem6. PSPLIT . $formItem7. PSPLIT . $formItem8;

// Check if all fields are not empty and are legit
if ($_POST['itemFunction'] == 3 || regExpression($formItem1, 0) && regExpression($formItem2, 0)) {

	// Select database Function
	switch ($_POST['itemFunction']) {
		case 1:
			// Update existing table entry
			$query = @mysql_query("UPDATE $Table SET question='$formItem1', answers='$Answers' WHERE id='$formItem0'");						
			break;
		case 2:
			// Create new table entry
			$query = @mysql_query("INSERT INTO $Table (question, answers, results, author, date) VALUES ('$formItem1', '$Answers', '$pollResults', '$author', '$UnixDate')");
			break;
		case 3:
			// Delete entry from table
			$query = @mysql_query("DELETE FROM $Table WHERE id='$formItem0'");
			break;
		default:
			$query = NULL;
			break;
	}
} else {
	// Error, if one or more fields are empty
	if ($_POST['itemFunction'] > 0) {
		$errorReport .= "<li>All fields must be completed in order to proceed.</li>";
		$errorNoUpdate = TRUE;
	} else {
		$errorNoUpdate = FALSE;			
	}	
}	

// Check if the Filter box contains text
if ($Filter) {
	// Filter the table results
	$Filter = explode(" ", $Filter);
	foreach ($Filter as $queryWord) {
		$result = @mysql_query("SELECT * FROM $Table WHERE question LIKE '%$queryWord%' OR answers LIKE '%$queryWord%' ORDER BY $listOrder ASC LIMIT $tableIndex,$tableLimit");
	}
} else {
	// Display the table in full (default)
	$result = @mysql_query("SELECT * FROM $Table ORDER BY $listOrder ASC LIMIT $tableIndex,$tableLimit");
}

// Display all the data from the selected table
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

	// Alternate row color
	$rowColor = ($rowCount % 2) ? 1 : 2;

	// Display selected item
	if ($_POST['id'] == $row['id'] && !$errorNoUpdate) {

		$Answers = explode(PSPLIT, stripslashes($row['answers']));
		$author = $row['author'];		
		
		// Check if value exists
		if (!$formItem0) $formItem0 = $row['id'];
		if (!$formItem1) $formItem1 = $row['question'];
		if (!$formItem2) $formItem2 = $Answers[0];
		if (!$formItem3) $formItem3 = $Answers[1];
		if (!$formItem4) $formItem4 = $Answers[2];
		if (!$formItem5) $formItem5 = $Answers[3];
		if (!$formItem6) $formItem6 = $Answers[4];
		if (!$formItem7) $formItem7 = $Answers[5];
		if (!$formItem8) $formItem8 = $Answers[6];

		// Make the output text presentable
		$formItem1 = stripslashes($formItem1);
		
		// Check to make sure nothing was left blank
		if ($formItem1 && $formItem2) {
			// Update table with current user data
			$displayTable .= createRow($rowColor, $formItem0, $formItem1, $row['results'], getUsernameId($author), convertDate($row['date']));
		} else {
			// Display error message
			if ($_POST['itemFunction'] > 0) $errorReport .= "<li>All the fields must be completed in order to proceed.</li>";
		}
	} else {
		// Display the table with entries from the database
		$displayTable .= createRow($rowColor, $row['id'], $row['question'], $row['results'], getUsernameId($row['author']), convertDate($row['date']));
	}
	// Alternate row color
	$rowCount++;
}

?>