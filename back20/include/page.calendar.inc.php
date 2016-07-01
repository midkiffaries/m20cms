<?php

// Check for cross-site scripting
if (strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) > 7 || !strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'])) die();

// Table name
$Table = 'Calendar';

// Final text clean-up specific to content
$formItem1 = strip_tags($formItem1); // what
$formItem2 = strip_tags($formItem2); // where
$formItem3 = strtolower(strip_tags($formItem3)); // when (from)
//$textBox = cleanGET($textBox); // content
$formItem5 = strtolower(strip_tags($formItem5)); // when (to)
$formItem6 = strtolower(strip_tags($formItem6)); // catagories
$formItem7 = strip_tags($formItem7); // repeat
$formItem8 = strip_tags($formItem8); // Hide from public
$author = getUsernameCookie(inputToDB($_COOKIE[COOKIE_USER]));

if ($formItem5 == NULL) $formItem5 = $formItem3;

// Change date to a DB friendly format
$formItem3 = date('Y-m-d H:i', strtotime($formItem3));
$formItem5 = date('Y-m-d H:i', strtotime($formItem5));

// Check if all fields are not empty and are legit
if ($_POST['itemFunction'] == 3 || regExpression($formItem1, 0) && regExpression($formItem2, 0) && regExpression($formItem3, 0) && regExpression($textBox, 0) && regExpression($formItem6, 0)) {

	// Select database Function
	switch ($_POST['itemFunction']) {
		case 1:
			// Update existing table entry
			$query = @mysql_query("UPDATE $Table SET what='$formItem1', location='$formItem2', whenFrom='$formItem3', content='$textBox', whenTo='$formItem5', catagories='$formItem6', ongoing='$formItem7', public='$formItem8' WHERE id='$formItem0'");						
			break;
		case 2:
			// Create new table entry
			$query = @mysql_query("INSERT INTO $Table (what, location, whenFrom, content, whenTo, catagories, ongoing, public, author) VALUES ('$formItem1', '$formItem2', '$formItem3', '$textBox', '$formItem5', '$formItem6', '$formItem7', '$formItem8', '$author')");
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


// Display calendar
$displayTable = createFullCalendar($monthOffset, $Filter, $listOrder);

// Check if the Filter box contains text
//if ($Filter) {
	// Filter the table results
//	$Filter = explode(" ", $Filter);
//	foreach ($Filter as $queryWord) {
//		$result = @mysql_query("SELECT * FROM $Table WHERE what LIKE '%$queryWord%' OR where LIKE '%$queryWord%' OR content LIKE '%$queryWord%' ORDER BY $listOrder ASC LIMIT $tableIndex,$tableLimit");
//	}
//} else {
	// Display the table in full (default)
	$result = @mysql_query("SELECT * FROM $Table");
//}

// Display all the data from the selected table
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

	// Display selected item
	if ($_POST['id'] == $row['id'] && !$errorNoUpdate) {
		
		// Check if value exists
		if (!$formItem0) $formItem0 = $row['id'];
		if (!$formItem1) $formItem1 = $row['what'];
		if (!$formItem2) $formItem2 = $row['location'];
		if (!$formItem3) $formItem3 = $row['whenFrom'];
		if (!$textBox) $textBox = $row['content'];
		if (!$formItem5) $formItem5 = $row['whenTo'];
		if (!$formItem6) $formItem6 = $row['catagories'];
		if (!$formItem7) $formItem7 = $row['ongoing'];
		if (!$formItem8) $formItem8 = $row['public'];
		
		// Make the output text presentable
		$formItem1 = stripslashes($formItem1);
		$textBox = stripslashes($textBox);
		
		// Change date to a readable format
		$formItem3 = date('Y-m-d g:ia', strtotime($row['whenFrom']));
		$formItem5 = date('Y-m-d g:ia', strtotime($row['whenTo']));		
		
		// Check to make sure nothing was left blank
		if ($formItem1 && $formItem2 && $formItem3 && $textBox && $formItem5 && $formItem6) {
			// Update table with current data
			//$displayTable .= getTime($formItem7), $formItem1;
		} else {
			// Display error message
			if ($_POST['itemFunction'] > 0) $errorReport .= "<li>All the fields must be completed in order to proceed.</li>";
		}
	} else {
		// Display the table with entries from the database
		//$displayTable .= getTime($row['date']), $row['what'];
	}
}

?>