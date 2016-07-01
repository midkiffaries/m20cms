<?php

// Check for cross-site scripting
if (strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) > 7 || !strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'])) die();

// Create table header
$displayTable = createHeader('File', 'Type', 'Size', 'Date');

// Final text clean-up specific to content
$formItem1 = strip_tags($formItem1); // filename
$formItem2 = strip_tags($formItem2); // permissions
//$formItem3 = strip_tags($formItem3); // none
//$formItem4 = strip_tags($formItem4); // none
//$formItem5 = strip_tags($formItem5); // none
//$formItem6 = strip_tags($formItem6); // none
//$formItem7 = strip_tags($formItem7); // none
//$formItem8 = $formItem8; // none
//if ($listOrder == 1) $listOrder = ''; // file type

$mediaDir = str_replace('/include', '', $mediaDir);

// Delete selected file
if ($_POST['itemFunction'] == 3) {
	file_Delete($mediaDir . '/' . $formItem1);
}

// Display table from directory content
if ($handle = opendir($mediaDir)) {
	while (false !== ($file = readdir($handle))) {
		//if ($listOrder == 0)
		if ($file != '.' && $file != '..' && file_Catagory(file_Ext($file)) == $listOrder || $file != '.' && $file != '..' && $listOrder == 'all') {
			$rowColor = ($rowCount % 2) ? 1 : 2;
			$displayTable .= "<tr class=\"pS" . $rowColor . "\">";	
			$displayTable .= "<td align=\"center\"><input type=\"button\" value=\"View\" onclick=\"openWindow('" . str_replace('/include', '', $mediaUrl) . $file . "')\" /></td>";
			$displayTable .= "<td>" . cleanOutput($file) . "</td>";
			$displayTable .= "<td>" . cleanOutput(file_Type(file_Ext($file))) . "</td>";
			$displayTable .= "<td>" . cleanOutput(file_Size(filesize($mediaDir . $file))) . "</td>";
			$displayTable .= "<td>" . cleanOutput(file_Date($mediaDir . $file)) . "</td>";
			$displayTable .= "<td align=\"center\"><input type=\"button\" value=\"X\" title=\"Delete\" onclick=\"deleteEntry('" .$file . "')\" class=\"Del\" /></td>";
			$displayTable .= "</tr>";
			$rowCount++;
		}
	}
	closedir($handle);
}

?>