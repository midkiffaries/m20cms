<?php

// Check for cross-site scripting
if (strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) > 7 || !strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'])) die();

// Table name
$Table = 'Users';

// Create table header
$displayTable = createHeader('Name', 'User Name', 'E-mail', 'Date');

// Final text clean-up specific to content
$formItem1 = strip_tags($formItem1); // firstname
$formItem2 = strip_tags($formItem2); // lastname
$formItem3 = strip_tags($formItem3); // username
$formItem4 = strip_tags($formItem4); // e-mail
$formItem5 = strip_tags($formItem5); // password 1
$formItem6 = strip_tags($formItem6); // password 2
$formItem7 = strip_tags($formItem7); // avatar
//$formItem8 = $formItem8; // none

// Password confirm check
if ($formItem5 != $formItem6 && regExpression($formItem5, 3)) {
	// Error, passwords don't match
	$errorReport .= "<li><strong>Confirm Password</strong> does not match or is not valid.</li>";
	$password = FALSE;
} else {
	// Encrypt password
	$password = md5($formItem5);
}

// Check if User Name is already taken by another user
$queryUser = @mysql_query("SELECT id, username FROM $Table WHERE username='$formItem3'");
$userRow = mysql_fetch_array($queryUser, MYSQL_ASSOC);
if (mysql_num_rows($queryUser) > 0 && $userRow['id'] != $formItem0) {
	// Error, username already taken
	$errorReport .= "<li>The <strong>User Name</strong> that you selected has already been taken.</li>";
	$userName = FALSE;
} else {
	$userName = TRUE;
}

// Check if all fields are not empty and are legit
if ($_POST['itemFunction'] == 3 || $userName && $password && regExpression($formItem1, 1) && regExpression($formItem2, 1) && regExpression($formItem3, 2) && regExpression($formItem4, 4)) {

	// Select database Function
	switch ($_POST['itemFunction']) {
		case 1:
			// Update existing table entry
			if ($formItem5 == $blankPassword) {
				$query = @mysql_query("UPDATE $Table SET firstname='$formItem1', lastname='$formItem2', username='$formItem3', email='$formItem4', avatar='$formItem7' WHERE id='$formItem0'");
			} else {
				$query = @mysql_query("UPDATE $Table SET firstname='$formItem1', lastname='$formItem2', username='$formItem3', email='$formItem4', password='$password', avatar='$formItem7' WHERE id='$formItem0'");
			}
			break;
		case 2:
			// Create new table entry
			$query = @mysql_query("INSERT INTO $Table (firstname, lastname, username, email, password, avatar, created) VALUES ('$formItem1', '$formItem2', '$formItem3', '$formItem4', '$password', '$formItem7', '$UnixDate')");
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
		$result = @mysql_query("SELECT * FROM $Table WHERE firstname LIKE '%$queryWord%' OR lastname LIKE '%$queryWord%' OR username LIKE '%$queryWord%' OR email LIKE '%$queryWord%' ORDER BY $listOrder ASC LIMIT $tableIndex,$tableLimit");
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
		if (!$formItem1) $formItem1 = $row['firstname'];
		if (!$formItem2) $formItem2 = $row['lastname'];
		if (!$formItem3) $formItem3 = $row['username'];
		if (!$formItem4) $formItem4 = $row['email'];
		if (!$formItem5) $formItem5 = $blankPassword;
		if (!$formItem6) $formItem6 = $blankPassword;
		if (!$formItem7) $formItem7 = $row['avatar'];
		//if (!$formItem5) $formItem5 = $row['password'];
		//if (!$formItem6) $formItem6 = $row['password'];
		
		// Make the output text presentable
		$formItem1 = stripslashes($formItem1);
		$formItem2 = stripslashes($formItem2);		
		
		// Check to make sure nothing was left blank
		if ($formItem1 && $formItem2 && $formItem3 && $formItem4 && $formItem5) {
			// Update table with current user data
			$displayTable .= createRow($rowColor, $formItem0, $formItem1 . " " . $formItem2, $formItem3, "<a href=\"mailto:" . $formItem4 . "\" class=\"email\">" . $formItem4 . "</a>", convertDate($row['date']));
		} else {
			// Display error message
			if ($_POST['itemFunction'] > 0) $errorReport .= "<li>All the fields must be completed in order to proceed.</li>";
		}
	} else {
		// Display the table with entries from the database
		$displayTable .= createRow($rowColor, $row['id'], $row['firstname'] . " " . $row['lastname'], $row['username'], "<a href=\"mailto:" . $row['email'] . "\" class=\"email\">" . $row['email'] . "</a>", convertDate($row['date']));
	}
	// Alternate row color
	$rowCount++;
}

?>