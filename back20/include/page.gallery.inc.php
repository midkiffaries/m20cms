<?php

// Check for cross-site scripting
if (strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) > 7 || !strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'])) die();

// Table name
$Table = 'Gallery';

// Create table header
$displayTable = createHeader('Title', 'Catagories', 'Type', 'Date');

// Final text clean-up specific to content
$formItem1 = strip_tags($formItem1); // title
$formItem2 = strtolower(strip_tags($formItem2)); // catagory
$formItem3 = getUsernameCookie(inputToDB($_COOKIE[COOKIE_USER])); // author (Users id)
//$formItem4 = cleanGET($formItem4); // content 
$formItem5 = strip_tags($formItem5); // file name
//$formItem6 = $formItem6; // none
//$formItem7 = $formItem7; // none
//$formItem8 = $formItem8; // none

// Check if all fields are not empty and are legit
if ($_POST['itemFunction'] == 3 || regExpression($formItem1, 0) && regExpression($formItem2, 0)) {

	// Select database Function
	switch ($_POST['itemFunction']) {
		case 1:
			// Update existing table entry
			$query = @mysql_query("UPDATE $Table SET title='$formItem1', catagories='$formItem2', content='$textBox', filename='$formItem5' WHERE id='$formItem0'");						
			break;
		case 2:
			// Create new table entry
			$query = @mysql_query("INSERT INTO $Table (title, catagories, author, content, filename, date) VALUES ('$formItem1', '$formItem2', '$formItem3', '$textBox', '$formItem5', '$UnixDate')");
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
		$result = @mysql_query("SELECT * FROM $Table WHERE title LIKE '%$queryWord%' OR catagories LIKE '%$queryWord%' OR content LIKE '%$queryWord%' ORDER BY $listOrder ASC LIMIT $tableIndex,$tableLimit");
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
		
		// Check if value exists
		if (!$formItem0) $formItem0 = $row['id'];
		if (!$formItem1) $formItem1 = $row['title'];
		if (!$formItem2) $formItem2 = $row['catagories'];
		if (!$formItem3) $formItem3 = $row['author'];
		if (!$formItem5) $formItem5 = $row['filename'];
		if (!$formItem7) $formItem7 = $row['date'];
		if (!$textBox) $textBox = $row['content'];

		// Make the output text presentable
		$formItem1 = stripslashes($formItem1);
		$textBox = stripslashes($textBox);	
		
		// Check to make sure nothing was left blank
		if ($formItem1 && $formItem2 && $formItem3) {
			// Update table with current data
			$displayTable .= createRow($rowColor, $formItem0, $formItem1, $formItem2, file_Catagory(file_Ext($row['filename'])), convertDate($formItem7));
		} else {
			// Display error message
			if ($_POST['itemFunction'] > 0) $errorReport .= "<li>All the fields must be completed in order to proceed.</li>";
		}
	} else {
		// Display the table with entries from the database
		$displayTable .= createRow($rowColor, $row['id'], $row['title'], $row['catagories'], file_Catagory(file_Ext($row['filename'])), convertDate($row['date']));
	}
	// Alternate row color
	$rowCount++;
}

?>