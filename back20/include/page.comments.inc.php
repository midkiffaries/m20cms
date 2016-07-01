<?php

// Check for cross-site scripting
if (strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) > 7 || !strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'])) die();

// Table name
$Table = 'Comments';

// Create table header
$displayTable = createHeader('Title', 'Name', 'E-mail', 'Date');

// Final text clean-up specific to content
$formItem1 = strip_tags($formItem1); // title
$formItem2 = strip_tags($formItem2); // visitor's name
$formItem3 = strtolower(strip_tags($formItem3)); // E-mail
//$textBox = cleanGET($textBox); // comment
$formItem5 = strip_tags($formItem5); // IP Address
//$formItem6 = $formItem6; // none
//$formItem7 = $formItem7; // none
//$formItem8 = $formItem8; // none

// Check if all fields are not empty and are legit
if ($_POST['itemFunction'] == 3 || regExpression($formItem2, 0) && regExpression($formItem3, 0) && regExpression($textBox, 0)) {

	// Select database Function
	switch ($_POST['itemFunction']) {
		case 1:
			// Update existing table entry
			$query = @mysql_query("UPDATE $Table SET name='$formItem2', email='$formItem3', comment='$textBox\n' WHERE id='$formItem0'");
			break;
		case 2:
			// Create new table entry
			//$query = @mysql_query("INSERT INTO $Table (title, name, email, comment, ipaddress, created) VALUES ('$formItem1', '$formItem2', '$formItem3', '$formItem4\n', '$formItem5', '$UnixDate')");
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

// List only the comments from a specific blog
if ($listOrder) {
	$result = @mysql_query("SELECT * FROM $Table WHERE blog_id='$listOrder' ORDER BY id ASC LIMIT $tableIndex,$tableLimit");
} else {
	$result = @mysql_query("SELECT * FROM $Table ORDER BY id ASC LIMIT $tableIndex,$tableLimit");
}

// Display all the data from the selected table
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

	// Alternate row color
	$rowColor = ($rowCount % 2) ? 1 : 2;

	// Display selected item
	if ($_POST['id'] == $row['id'] && !$errorNoUpdate) {
		
		// Check if value exists
		if (!$formItem0) $formItem0 = $row['id'];
		if (!$formItem1) $formItem1 = blogTitle($row['blog_id']);
		if (!$formItem2) $formItem2 = $row['name'];
		if (!$formItem3) $formItem3 = $row['email'];
		if (!$formItem5) $formItem5 = $row['ipaddress'];
		if (!$formItem7) $formItem7 = $row['date'];
		if (!$textBox) $textBox = $row['comment'];
		
		// Make the output text presentable
		$formItem1 = stripslashes($formItem1);
		$textBox = stripslashes($textBox);
		
		// Check to make sure nothing was left blank
		if ($formItem2 && $formItem3 && $textBox) {
			// Update table with current data
			$displayTable .= createRow($rowColor, $formItem0, $formItem1, $formItem2, "<a href=\"mailto:" . $formItem3 . "\" class=\"email\">" . $formItem3 . "</a>", convertDate($formItem7));
		} else {
			// Display error message
			if ($_POST['itemFunction'] > 0) $errorReport .= "<li>All the fields must be completed in order to proceed.</li>";
		}
	} else {
		// Display the table with entries from the database
		$displayTable .= createRow($rowColor, $row['id'], blogTitle($row['blog_id']), $row['name'], "<a href=\"mailto:" . $row['email'] . "\" class=\"email\">" . $row['email'] . "</a>", convertDate($row['date']));
	}
	// Alternate row color
	$rowCount++;
}

?>