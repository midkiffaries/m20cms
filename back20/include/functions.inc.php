<?php // Functions

// -- Common Functions -- //

// Make the file size display cleanly
function file_Size($size) {
	if (!$size) return 'N/A';
	$filesizename = array(' Bytes', ' KB', ' MB', ' GB', ' TB', ' PB', ' EB', ' ZB', ' YB');
	return round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[$i];
}

// Get the date created for a file
function file_Date($filename) {
	if (file_exists($filename)) return date("M j, Y \\a\\t g:i a", filemtime($filename));
}

// Delete selected file
function file_Delete($filename) {
	$file = fopen($filename, 'w') or die("Unable to delete " . $filename);
	return unlink($filename);
}

// Get file extension
function file_Ext($filename) {
	return end(explode('.', strtolower($filename)));
}

// Remove the file extension
function file_StripExt($filename) {
	return reset(explode('.', $filename));
}

// Remove multiple periods allowing only one for the extension
function stripDecimals($filename) {
	return preg_replace('/\\.(?![^.]*$)/', '_', $filename);
}

// Get file type (description) from the extension
function file_Type($extension) {
	$type = array(
		// Documents
		'doc'  => 'Word document',
		'xls'  => 'Excel spreadsheet',
		'pub'  => 'Publisher document',
		'ppt'  => 'PowerPoint presentation',
		'pdf'  => 'Adobe Acrobat',
		'wpd'  => 'WordPerfect document',
		'wps'  => 'Works document',
		'wri'  => 'Write document',
		'txt'  => 'Plain text document',
		'rtf'  => 'Rich text document',
		'htm'  => 'HTML document',
		'html' => 'HTML document',
		'odt'  => 'OpenDocument text',
		'odp'  => 'OpenDocument presentation',
		'ods'  => 'OpenDocument spreadsheet',
		'eml'  => 'E-mail document',
		'pages'=> 'Pages document',
		'key'  => 'Keynote presentation',
		'numbers'=> 'Numbers spreadsheet',	
		// Pictures
		'jpg'  => 'JPEG image',
		'jpeg' => 'JPEG image',
		'jp2'  => 'JPEG 2000 image',
		'j2c'  => 'JPEG 2000 image',
		'hdp'  => 'HD Photo',
		'png'  => 'PNG image',
		'gif'  => 'GIF image',
		'bmp'  => 'BMP image',
		'wbmp' => 'BMP image',
		'tif'  => 'TIFF image',
		'tiff' => 'TIFF image',
		'psd'  => 'PhotoShop image',
		'ai'   => 'Illustrator graphic',
		'wmf'  => 'Windows Meta file',
		'svg'  => 'Scale-Vector graphic',
		'xcf'  => 'Gimp image',
		'odg'  => 'OpenDocument graphic',
		// Audio
		'mp3'  => 'MP3 audio',
		'mp2'  => 'MP2 audio',
		'wma'  => 'Windows Media audio',
		'aac'  => 'AAC audio',
		'm4a'  => 'AAC audio',
		'ogg'  => 'OGG Vorbis audio',
		'wav'  => 'WAV audio',
		'aiff' => 'AIFF audio',
		'aif'  => 'AIFF audio',
		'au'   => 'Apple audio',
		'snd'  => 'Sound audio',
		'ra'   => 'Real audio',
		'flac' => 'FLAC lossless audio',
		// Video
		'mpg'  => 'MPEG movie',
		'mpeg' => 'MPEG movie',
		'mp2'  => 'MPEG-2 movie',
		'mp4'  => 'MPEG-4 movie',
		'avi'  => 'AVI movie',
		'mov'  => 'QuickTime movie',
		'wmv'  => 'Windows Media video',
		'asf'  => 'ASF movie',
		'ram'  => 'Real movie',
		'swf'  => 'Flash video',
		'vob'  => 'DVD video',
		// Other
		'zip'    => 'Compressed file',
		'rar'    => 'Compressed file',
		'arc'    => 'Compressed file',
		'ace'    => 'Compressed file',
		'cab'    => 'Compressed file',
		'gz'     => 'Compressed file',
		'7z'     => 'Compressed file',
		'sit'    => 'Compressed file',
		'hqx'    => 'Compressed file',
		'bin'    => 'Compressed file',
		'blend'  => 'Blender 3D model',
		'torrent'=> 'Torrent',
		'dwg'    => 'AutoCAD drawing'
	);
	
	if ($type[$extension] == '') { 
		return $extension . ' file';
	} else {		
		return $type[$extension];
	}
}

// Disallow uploading certain file types
function file_Disallow($extension) {
	$disallow = array('htm','html','shtml','shtm','sml','xhtml','xhtm','class','cms','c','cpp','j','jpp','vb','vba','wrl','xml','css','php','php2','php3','php4','php5','php6','phtml','pwml','inc','ini','dll','asp','aspx','ascx','jsp','cfm','cfc','pl','bat','vbs','js','java','jar','sql','reg','cgi','exe','com','app','asis','htaccess','htpasswd','htc','ico','conf','config','fon','ttf');
	
	if (in_array($extension, $disallow)) {
		return FALSE;
	} else {
		return TRUE;
	}
}

// Place files in specific directories based on the file extension
function file_Catagory($extension) {
	$arrDocs = array('doc','xls','pub','ppt','pdf','wpd','wps','wri','txt','rtf','htm','html','odt','odp','ods','pages','key','numbers','eml');
	$arrPics = array('jpg','jpeg','jp2','j2c','hdp','png','gif','bmp','wbmp','tif','tiff','psd','ai','wmf','svg','xcf','odg');
	$arrAudio = array('mp3','mp2','wma','aac','m4a','ogg','wav','aiff','au','snd','aif','ra','flac');
	$arrVideo = array('mpg','mpeg','mp4','avi','mov','asf','ram','wmv','swf','vob');
	
	if (in_array($extension, $arrDocs)) return 'document';
	if (in_array($extension, $arrPics)) return 'picture';
	if (in_array($extension, $arrAudio)) return 'music';
	if (in_array($extension, $arrVideo)) return 'video';
	return 'misc';
}

// Display only files with these extensions
function file_Image($extension) {
	$imageExt = array('jpg','jpeg','jp2','j2c','hdp','png','gif','wbmp','bmp','tif','tiff','tga','svg','pdf');
	
	if (in_array($extension, $imageExt)) {
		return TRUE;
	} else {
		return FALSE;
	}
}

// Access only trusted local files
function trustedFile($file) {
	if (!eregi("^([a-z]+)://", $file) && fileowner($file) == getmyuid()) {
		return TRUE;
	} else {
		return FALSE;
	}
}

// Checks if it is after sunset or before sunrise
function dayOrNight() {
	//if (date('G:i') > $Sunrise && date('G:i') < $Sunset) {
	if (date('G') > 6 && date('G') < 19) {
		return '';
	} else {
		return ' class="Night"';
	}
}

// Converts a number into roman numerals
function numberToRoman($variable) {
	$n = intval($variable);
	$lookup = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
	foreach ($lookup as $roman => $value) {
		$matches = intval($n / $value);
		$result .= str_repeat($roman, $matches);
		$n = $n % $value;
	}
	return $result;
}

// Change specific text to common ASCII symbols
function charChange($phrase) {
	$old = array("(c)", "(tm)", "(r)", "<<", ">>", "(heart)", "(diamond)", "(club)", "(spade)", "(*}", "^1", "^2", "^3", "(c$)", "1/4", "1/2", "3/4", "0/00", "(oo)", "^o", "(cross)", "(dcross)", "(!=)", "(.)", "--", "<=", "=>");
	$new = array("&copy;", "&trade;", "&reg;", "&laquo;", "&raquo;", "&hearts;", "&diams;", "&clubs;", "&spades;", "&bull;", "&sup1;", "&sup2;", "&sup3;", "&cent;", "&frac14;", "&frac12;", "&frac34;", "&permil;", "&infin;", "&deg;", "&dagger;", "&Dagger;", "&ne;", "&middot;", "&hyphen;", "&larr;", "&rarr;");
	return str_replace($old, $new, $phrase);
}

// Changes the user typed quotes to ASCII HTML
function quoteChange($phrase) {
	$old = array("\"", "'");
	$new = array("&quot;", "&apos;");
	return str_replace($old, $new, $phrase);
}

// Replace ; with , for combining items into one
function makeOneItem($phrase) {
	$old = array(";");
	$new = array(",");
	return str_replace($old, $new, $phrase);
}

// Replaces under-scores with spaces and sets the first letter of every word to uppercase
function makeTitle($variable) {
	return ucwords(quoteChange(str_replace('_', ' ', $variable)));
}

// Replace the spaces in a filename with %20
function removeSpaces($variable) {
	return str_replace(' ', '%20', $variable);
}

// Replace the spaces in a url with underscores
function removeUrlSpaces($phrase) {
	$old = array(" ", "%20");
	$new = array("_", "_");
	return str_replace($old, $new, $phrase);
}

// Changes the url character substitution back to the original value
function cleanGET($phrase) {
	$old = array("%23", "%26", "%3D", "%3F", "%3C", "%3E");
	$new = array("#", "&", "=", "?", "<", ">");
	return str_replace($old, $new, $phrase);
}

// Make the content readable to the user
function cleanOutput($variable) {
	return stripslashes($variable);
}

// Cleans the user entered comments
function cleanComment($variable) {
	return nl2br(quoteChange(trim(strip_tags($variable))));
}

// Cleans variable urls entries
function cleanVarUrl($variable) {
	$old = array("/../");
	$new = array(".");
	return str_replace($old, $new, stripslashes(trim(strip_tags($variable))));
}

// Replace '||' or '|||' with '|' to prevent potential problems
function replaceSeperators($variable) {
	$old = array("||", "|||");
	$new = array("|", "|");
	return str_replace($old, $new, $variable);
}

// Strips all JavaScript DOM elements
function stripJavaScript($variable) {
	$old = array('/onfocus=/is', '/onblur=/is', '/onselect=/is', '/onchange=/is', '/onclick=/is', '/ondblclick=/is', '/onmousedown=/is', '/onmouseup=/is', '/onmouseover=/is', '/onmousemove=/is', '/onmouseout=/is', '/onkeypress=/is', '/onkeydown=/is', '/onkeyup=/is', '/onload=/is', '/onunload=/is', '/javascript:/is');
	$new = array('title=', 'title=', 'title=', 'title=', 'title=', 'title=', 'title=', 'title=', 'title=', 'title=', 'title=', 'title=', 'title=', 'title=', 'title=', 'title=', 'http:');
	return preg_replace($old, $new, $variable);
}

// Check if content exists
function inputToDB($variable) {
	if (isset($variable)) {
		return escapeData(replaceSeperators($variable));
	} else {
		return FALSE;
	}
}

// Clean content and sanitize it
function escapeData($variable) {
	if (get_magic_quotes_gpc()) return addslashes(trim($variable));
	if (!is_numeric($variable)) return mysql_real_escape_string(trim(cleanGET($variable)));
}

// Secures a potential e-mail address to prevent spamming
function injectionCheck($variable) {
	if(eregi("to:", $variable) || eregi("cc:", $variable)) {
		return TRUE;
	} else {
		return FALSE;
	}
}

// Check data input masking
function regExpression($variable, $function) {
	// Get mask type
	$format = array(
		0 => "^([[:alnum:]]|-| |`|.)+$", // No change
		1 => "^([[:alpha:]]|-| |`|.)+$", // Normal (numberless) text
		2 => "^[[:alnum:]]{6,25}$", // Alphanumeric text (min=6, max=25)
		3 => "^[[:alnum:]]{8,45}$", // Password (min=8, max=45)
		4 => "^[[:alnum:]]|_|\.|-)+@([[:alnum:]]|\.|-)+(\.)([a-z]{2,4})$", // E-mail
		5 => "^[0-9]+$" // Integer
	);

	if (eregi($format[$function], $variable)) {
		return TRUE;
	} else {
		return FALSE;
	}
}

// Match login attempt against DB values
function matchToDB($Username, $Created) {
	$result = @mysql_query("SELECT username, email FROM Users WHERE username='$username'");
	$row = mysql_fetch_array($result, MYSQL_NUM);
	if ($username == $row['username'] && $userId == $row['email']) {
		return TRUE;	
	} else {
		return FALSE;
	}
}

// Trims a long block of text down to a certain number ($length) of characters
function textTrim($sentence, $length) {
	if (strlen(html_entity_decode($sentence)) < $length) {
		return stripslashes($sentence);
	} else {
		return stripslashes(htmlentities(substr(html_entity_decode($sentence), 0, $length - 1) . '...'));
	}
}

// Return the title of a blog based on ID
function blogTitle($id) {
	$result = @mysql_query("SELECT title FROM Blogs WHERE id='$id'");
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	return $row['title'];
}

// Return the user rights from Users table
function userRights($username, $created) {
	$result = @mysql_query("SELECT rights FROM Users WHERE username='$username' AND created='$created'");
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	return $row['rights'];
}

// Return the number of rows from a given table
function countRows($Table) {
	$count = @mysql_query("SELECT id FROM $Table");
	return @mysql_num_rows($count);
}

// Keep the table ID valid
function countTableRows($id, $Table) {
	$result = @mysql_query("SELECT * FROM $Table");
	if ($id <= 1) {
		return 2;
	} else if ($id >= mysql_num_rows($result)) {
		return mysql_num_rows($result) - 1;
	} else {
		return $id;
	}
}

// Get the dimensions of an image
function imageSize($filename) {
	list($w, $h) = getimagesize($filename);
	return $w . " x " . $h;
}

// Create a jpg thumbnail of an image
function resizeImage($filename, $newWidth, $newHeight) {
	if (file_Image(file_Ext($filename))) {
		list($w, $h) = getimagesize($filename);
	
		// Scale image by percent
		//$percent = 0.05;
		//$newWidth = $w * $percent;
		//$newHeight = $h * $percent;
		
		// Scale image down porportionally
		/*
		if($w > $h && $newHeight < $h){
			$newHeight = $h / ($w / $newWidth);
		} else if ($w < $h && $newWidth < $w) {
			$newWidth = $w / ($h / $newHeight);   
		} else {
			$newWidth = $w;
			$newHeight = $h;
		}
		*/
		$thumb = @imagecreatetruecolor($newWidth, $newHeight) or die("Not an image");
		
		switch (file_Ext($filename)) {
			case 'png': // PNG image
				$source = @imagecreatefrompng($filename);
				break;
			case 'gif': // GIF image
				$source = @imagecreatefromgif($filename);
				break;
			case 'wbmp': // WBMP image
				$source = @imagecreatefromwbmp($filename);
				break;
			case 'jpg' OR 'jpeg' OR 'jp2': // JPEG image
				$source = @imagecreatefromjpeg($filename);
				break;
			default: // Everything else
				$im = @imagecreate($newWidth, $newHeight);
				$bg = imagecolorallocate($im, 200, 200, 200);
				$textcolor = imagecolorallocate($im, 0, 0, 200);
				imagestring($im, 5, 0, 0, "No thumbnail", $textcolor);
				return imagejpeg($im, NULL, 70);
				break;
		}
		
		// Resample image - slow
		//@imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $w, $h);
		
		// Do not resample image - fast
		@imagecopyresized($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $w, $h);
		return imagejpeg($thumb, NULL, 70);
	}
}

// Display the content of a directory 
function listDirectory($dir) {
	return scandir($dir);
}

// Generates the table header
function createHeader($cell1, $cell2, $cell3, $cell4) {
	$displayRow = "<table id=\"List\" width=\"100%\" cellspacing=\"1\" cellpadding=\"2\"><tr>";
	$displayRow .= "<th width=\"55\"></th>";
	$displayRow .= "<th>" . $cell1 . "</th>";
	$displayRow .= "<th>" . $cell2 . "</th>";
	$displayRow .= "<th>" . $cell3 . "</th>";
	$displayRow .= "<th>" . $cell4 . "</th>";
	$displayRow .= "<th width=\"28\"></th>";
	$displayRow .= "</tr>";
	return $displayRow;
}

// Generates the table row when displaying all content from database
function createRow($rowColor, $id, $cell1, $cell2, $cell3, $cell4) {
	$displayRow = "<tr class=\"pS" . $rowColor . "\">";	
	$displayRow .= "<td align=\"center\"><input type=\"button\" value=\" Edit \" onclick=\"editEntry(" . $id . ")\" /></td>";
	$displayRow .= "<td>" . cleanOutput($cell1) . "</td>";
	$displayRow .= "<td>" . cleanOutput($cell2) . "</td>";
	$displayRow .= "<td>" . cleanOutput($cell3) . "</td>";
	$displayRow .= "<td>" . cleanOutput($cell4) . "</td>";
	$displayRow .= "<td align=\"center\"><input type=\"button\" value=\"X\" title=\"Delete\" onclick=\"deleteEntry(" . $id . ")\" class=\"Del\" /></td>";
	$displayRow .= "</tr>";
	return $displayRow;
}

// Make MySQL date iCal friendly
function iCalDate($date) {
	return date("Ymd\\THis\\Z", strtotime($date));
}

// Convert MySQL date and time and stack the values vertically
function stackDate($date) {
	return date("M\\<\\s\\p\\a\\n\\>j\\<\\/\\s\\p\\a\\n\\>Y", strtotime($date));
}

// Display full date
function fullDate($date) {
	return date("l, F jS, Y \\a\\t g:i a", strtotime($date));
}

// Convert MySQL date and time to a more friendy format
function convertDate($date) {
	return date("M j, Y \\a\\t g:i a", strtotime($date));
}

// Get the date from the table entry
function convertDateOnly($date) {
	return date("M j, Y", strtotime($date));
}

// Get the time from the table entry
function convertTimeOnly($date) {
	return date("g:i a", strtotime($date));
}

// Create a navigation button
function generateNav($url, $title) {
	return "\t\t\t<dd><a href=\"" . $url . "\">" . $title . "</a></dd>\n";
}

function lookUpSite($variable, $site) {
	switch ($site) {
		case 1:
			// IP Address
			return "http://ip-lookup.net/?ip=" . $variable;
		case 2:
			// Google Maps
			return "http://www.google.com/maps?q=" . $variable;
		case 3:
			// Wikipedia
			return "http://en.wikipedia.org/wiki/" . $variable;
		case 4:
			// Bible Gateway
			return "http://www.biblegateway.com/passage/?book_id=" . $variable;
		default:
			// Google Search
			return "http://www.google.com/search?q=" . $variable;
	}
}

// Create a list blog titles
function listBlogTitles() {
	$result = @mysql_query("SELECT id, title FROM Blogs ORDER BY date ASC");
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$listTitles .= "<option value=\"" . $row['id'] . "\">" . $row['title'] . "</option>";
	}
	return $listTitles;
}

// Create a list of users and ids for the calendar
function listCalendarUsers() {
	$result = @mysql_query("SELECT id, firstname, lastname FROM Users ORDER BY lastname ASC");
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$listUsers .= "<option value=\"" . $row['id'] . "\">" . $row['firstname'] . " " . $row['lastname'] . "</option>";
	}
	return $listUsers;
}

// Create the full calendar
function createFullCalendar($offset, $Filter, $listOrder) {
	$now = getdate(time());
	$date = getdate(mktime(0,0,0, $now['mon'] + $offset, 1, $now['year']));
	$dayTotal = cal_days_in_month(0, $date['mon'], $date['year']);
	$currentMonth = date('F', strtotime($offset . ' month'));
	$currentMonthNum = date('m', strtotime($offset . ' month'));
	$currentYear = date('Y', strtotime($offset . ' month'));
	$lastMonth = date('F', strtotime($offset - 1 . ' month'));
	$nextMonth = date('F', strtotime($offset + 1 . ' month'));
	
	// Print the calendar header with the month name.
	$displayCalendar = '<table id="calendar" cellspacing="1" cellpadding="1"><tr><th class="calLastMonth"><a href="javascript:changeMonth(-1);">&lt; ' . $lastMonth . '</a></th><th colspan="5" class="calMonth">' . $currentMonth . ' ' . $currentYear . '</th><th class="calNextMonth"><a href="javascript:changeMonth(1);">' . $nextMonth . ' &gt;</a></th></tr>';
	$displayCalendar .= '<tr><th class="weekend">Sunday</th><th>Monday</th><th>Tuesday</th><th>Wednesday</th><th>Thursday</th><th>Friday</th><th class="weekend">Saturday</th></tr>';
	for ($i = 0; $i < 6; $i++) {
		$displayCalendar .= '<tr>';
		for ($j = 1; $j <= 7; $j++) {
			$dayNum = $j + $i*7 - $date['wday'];
			// Print a cell with the day number in it.  If it is today, highlight it.
			$displayCalendar .= '<td';
			if ($dayNum > 0 && $dayNum <= $dayTotal) {
				if ($dayNum < 10) {
					$currentDay = '0' . $dayNum;
				} else {
					$currentDay = $dayNum;
				}
				$displayCalendar .= ($dayNum == $now['mday'] && date('F') == date('F', strtotime($offset . ' month'))) ? ' class="Today">' : '>';
				$displayCalendar .= '<span><a href="javascript:createEvent(\'' . $currentYear . '-' . $currentMonthNum . '-' . $currentDay . '\');">' . $dayNum . ' <span>new event</span></a></span>';
				$Now = date('Y-m-d', strtotime($date['year'] . "-" . $date['mon'] . "-" . $dayNum));
				
				if ($listOrder > 0) {
					$result = @mysql_query("SELECT id, what, whenFrom, whenTo, ongoing FROM Calendar WHERE (author='$listOrder' AND whenFrom LIKE '%$Now%') OR (author='$listOrder' AND whenTo > '$Now' AND whenFrom < '$Now') OR (author='$listOrder' AND whenTo LIKE '%$Now%') ORDER BY whenFrom ASC");
				} else {
					/*
					// Ongoing events
					switch ($ongoing) {
						case 2: // Weekly
							$week = $Now + 7;
							$result = @mysql_query("SELECT id, what, whenFrom, whenTo, ongoing FROM Calendar WHERE whenFrom LIKE '%$Now%' OR whenTo = '$week' AND whenFrom = '$Now' OR whenTo LIKE '%$Now%' ORDER BY whenFrom ASC");
							break;
						default: // none
							// Display the table in full (default)
							$result = @mysql_query("SELECT id, what, whenFrom, whenTo, ongoing FROM Calendar WHERE whenFrom LIKE '%$Now%' OR whenTo > '$Now' AND whenFrom < '$Now' OR whenTo LIKE '%$Now%' ORDER BY whenFrom ASC");
							break;
					}
					*/
					// Display the table in full (default)
					$result = @mysql_query("SELECT id, what, whenFrom, whenTo, ongoing FROM Calendar WHERE whenFrom LIKE '%$Now%' OR whenTo > '$Now' AND whenFrom < '$Now' OR whenTo LIKE '%$Now%' ORDER BY whenFrom ASC");
				}

				while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
					// Print calendar entry
					if (abbrTime($row['whenFrom']) == '12a' && abbrTime($row['whenTo']) == '12a') {
						// All Day Event
						$displayCalendar .= "<a href=\"javascript:editEntry(" . $row['id'] . ");\" title=\"" . $row['what'] . " (all day)\" style=\"font-style:italic\">" . textTrim($row['what'], 20) . "</a>";				
					} else if (abbrTime($row['whenFrom']) == abbrTime($row['whenTo'])) {
						// End time is the same as the start time
						$displayCalendar .= "<a href=\"javascript:editEntry(" . $row['id'] . ");\" title=\"" . abbrTime($row['whenFrom']) . " " . $row['what'] . "\">" . abbrTime($row['whenFrom']) . " " . textTrim($row['what'], 20) . "</a>";
					} else {
						// End time is different than the start time
						$displayCalendar .= "<a href=\"javascript:editEntry(" . $row['id'] . ");\" title=\"" . abbrTime($row['whenFrom']) . "-" . abbrTime($row['whenTo']) . " " . $row['what'] . "\">" . abbrTime($row['whenFrom']) . " " . textTrim($row['what'], 18) . "</a>";
					}
				}
			} else {
				// Print a blank cell if no date falls on that day, but the row is unfinished.
				$displayCalendar .= '>';
			}
			$displayCalendar .= '</td>';
		}
		$displayCalendar .= '</tr>';
		if ($dayNum >= $dayTotal && $i != 6) break;
	}
	$displayCalendar .= '</table>';
	
	return $displayCalendar;
}

// Abbreviate Time
function abbrTime($time) {
	$old = array(':00', ' ', 'pm', 'am', 'PM', 'AM', 'p.m.', 'a.m.', 'P.M.', 'A.M.');
	$new = array('', '', 'p', 'a', 'p', 'a', 'p', 'a', 'p', 'a');
	return str_replace($old, $new, date('g:ia', strtotime($time)));
}

// Get the current user ID from the set cookie
function getUsernameCookie($username) {
	$result = @mysql_query("SELECT id FROM Users WHERE username='$username'");
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	return $row['id'];
}

// Get the current username from the ID
function getUsernameId($id) {
	$result = @mysql_query("SELECT username FROM Users WHERE id='$id'");
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	return $row['username'];
}

// Get a user's first name from a table ID
function getName($id) {
	$result = @mysql_query("SELECT firstname FROM Users WHERE id='$id'");
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	return $row['firstname'];
}

// Get a user's full name from a table ID
function getFullName($id) {
	$result = @mysql_query("SELECT firstname, lastname FROM Users WHERE id='$id'");
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	return $row['firstname'] . ' ' . $row['lastname'];
}

// Get a user's E-mail address from a table ID
function getEmail($id) {
	$result = @mysql_query("SELECT email FROM Users WHERE id='$id'");
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	return $row['email'];
}

// Validate email address
function validateEmail($email) {
	if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) {
		return "mailto:" . $email;
	} else {
		return $email;
	}
}

// Separate the words from a string
function separateCatagories($Catagories) {
	include('directories.inc.php');
	$Cats = explode(",", $Catagories);
	foreach ($Cats as $Cat) {
		if (!$Cat) break;		
		$Content .= "<a href=\"" . $currentUrl . "/Search." . EXTENSION . "?q=" . $Cat . "\">" . $Cat . "</a> ";
	}
	return $Content;
}

// Check if webcam is live
function webcamUpdate($filename) {
	if (file_exists($filename) && filesize($filename) < 100000) {
		if ((date("YmdHi", filemtime($filename)) + 10) < date("YmdHi")) {
			return "OFFLINE";
		} else {
			return "LIVE";
		}
	} else {
		return "OFFLINE";
	}
}

// Add HTML tags to WikiText 
function makeHTML($string) {
	do {
		// Blank Spaces
		$string = preg_replace("/  /i", "&nbsp; ", $string, -1, $count);
		// Tab (indent)
		$string = preg_replace("/(^|\n)\ \ */i", '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $string, -1, $count);
		// Horizontal Line
		$string = preg_replace("/(^|\n)----*/", "<hr />", $string, -1, $count);
		// Bullet List
		$string = preg_replace("/\* (.*?)(\n|\r)/i", "<li>$1</li>", $string, -1, $count);
		$string = preg_replace("/(\n|\r)(\n|\r)<li>/i", "<ul><li>", $string, -1, $count);
		$string = preg_replace("/<\/li>(\n|\r)/i", "</li></ul>", $string, -1, $count);
		// Number List
		//$string = preg_replace("/\# (.*?)(^|\n)/i", "<li>$1</li>", $string, -1, $count);
		//$string = preg_replace("/\n\n<li>/i", "\n<ol><li>", $string, -1, $count);
		//$string = preg_replace("/<\/li>\n/i", "</li></ol>\n", $string, -1, $count);
		// Plural
		$string = preg_replace("/'s /is", "&rsquo;s ", $string, -1, $count);
		// Contraction
		$string = preg_replace("/n't /is", "n&rsquo;t ", $string, -1, $count);
		// Contraction
		$string = preg_replace("/i've /is", "I&rsquo;ve ", $string, -1, $count);
		// Exponent
		$string = preg_replace("/\^\^(.*)\^\^/i", "<small><sup>$1</sup></small>", $string, -1, $count);
		// Bold and Italic
		$string = preg_replace("/'''''(.*?)'''''/i", "<strong><em>$1</em></strong>", $string, -1, $count);
		// Bold
		$string = preg_replace("/'''(.*?)'''/i", "<strong>$1</strong>", $string, -1, $count);
		// Italic
		$string = preg_replace("/''(.*?)''/i", "<em>$1</em>", $string, -1, $count);
		// Special
		$string = preg_replace("/__(.*?)__/i", "<span>$1</span>", $string, -1, $count);
		// Fancy Quote
		//$string = preg_replace("/\"\"(.*?)\"\"/i", "&ldquo;$1&rdquo;", $string, -1, $count);
		// Header 4
		$string = preg_replace("/====(.*?)====/i", '<span class="h4">$1</span>', $string, -1, $count);
		// Header 3
		$string = preg_replace("/===(.*?)===/i", '<span class="h3">$1</span>', $string, -1, $count);
		// Header 2
		$string = preg_replace("/==(.*?)==/i", '<span class="h2">$1</span>', $string, -1, $count);
		// Image
		$string = preg_replace('/\[(.*?.(jpg|jpeg|png|gif|bmp))\]/i', '<img src="$1" alt="" />', $string, -1, $count);
		$string = preg_replace('/\[(.*?.(jpg|jpeg|png|gif|bmp))\ (.*?(center|left|right|none))\ (.*?)\]/i', '<span class="S $3"><img src="$1" alt="$5" /></span>', $string, -1, $count);
		//$string = preg_replace('/\[(.*?.jpg|jpeg|png|gif|bmp)\ (.*?)\]/i', '<img src="$1" alt="$2" />', $string, -1, $count);
		// Emoticons
		$string = preg_replace('/\::(.*?(smile|wink|biggrin|blah|confused|ermm|sad|tongue|mad|ninja|rambo))\::/i', '<img src="template/emoticons/$1.png" class="Emoticon" alt="$1" />', $string, -1, $count);		
		// Link to a PDF file
		$string = preg_replace('/\[(.*?.pdf)\ (.*?)\]/i', '<a href="$1" class="pdf">$2</a>', $string, -1, $count);
		// External Link
		$string = preg_replace('/\[(http:.*?)\ (.*?)\]/i', '<a href="$1" class="link">$2</a>', $string, -1, $count);
		$string = preg_replace('/\[(ftp:.*?)\ (.*?)\]/i', '<a href="$1" class="link">$2</a>', $string, -1, $count);
		$string = preg_replace('/\[(www.*?)\ (.*?)\]/i', '<a href="http://$1" class="link">$2</a>', $string, -1, $count);
		$string = preg_replace('/\[(mailto:.*?)\ (.*?)\]/i', '<a href="mailto:$1" class="mail">$2</a>', $string, -1, $count);
		// Url with no title
		$string = preg_replace('/\[((http:|ftp:|www).*?)\]/i', '<a href="$1" class="link">$1</a>', $string, -1, $count);
		// Internal Link
		$string = preg_replace('/\[(.*?)\ (.*?)\]/i', '<a href="$1">$2</a>', $string, -1, $count);
		// Make image gallery
		//$string = preg_replace('/\[(album:.*?)\]/i', displayAlbum("/home/ted/Webs/m20backend2/gallery/$1/","/home/ted/Webs/m20backend2/gallery/$1/",4), $string, 1, $count);
		// Returns
		$string = preg_replace("/(\r\n)+|(\n|\r)+/", "<br /><br />", $string, -1, $count);
	} while ($count);
	//return nl2br($string);
	return $string;
}

// Strips out the WikiText tags
function stripWikiText($string) {
	do {
		// Blank Spaces
		$string = preg_replace("/  /i", ' ', $string, -1, $count);
		// Tab (indent)
		$string = preg_replace("/\t/i", ' ', $string, -1, $count);
		// Horizontal Line
		$string = preg_replace("/(^|\n)----*/", ' ', $string, -1, $count);
		// Bullet List
		$string = preg_replace("/\*(.*)\r/i", '$1', $string, -1, $count);
		// Number List
		$string = preg_replace("/#(.*)\r/i", '$1', $string, -1, $count);
		// Bold and Italic
		$string = preg_replace("/'''''(.*?)'''''/i", '$1', $string, -1, $count);
		// Bold
		$string = preg_replace("/'''(.*?)'''/i", '$1', $string, -1, $count);
		// Italic
		$string = preg_replace("/''(.*?)''/i", '$1', $string, -1, $count);
		// Header 3
		$string = preg_replace("/====(.*?)====/i", '$1', $string, -1, $count);
		// Header 3
		$string = preg_replace("/===(.*?)===/i", '$1', $string, -1, $count);
		// Header 2
		$string = preg_replace("/==(.*?)==/i", '$1', $string, -1, $count);
		// Exponent
		$string = preg_replace("/\^\^(.*)\^\^/i", '$1', $string, -1, $count);
		// External Link
		$string = preg_replace('/\[(.*?)\ (.*?)\]/i', '$2', $string, -1, $count);
		// Image
		$string = preg_replace('/\[(.*?)\]/i', '', $string, -1, $count);
		// Image
		$string = preg_replace('/\[(.*?)\ (.*?)\ (.*?)\]/i', '$3', $string, -1, $count);
		// Emoticons
		$string = preg_replace('/\::(.*?)\::/i', '', $string, -1, $count);		
		// Paragraph
		//$string = preg_replace("/(.*?)\n/is", '$1', $string, -1, $count);
		// Blank Paragraph
		//$string = preg_replace("/<p><\/p>/is", ' ', $string, -1, $count);
	} while ($count);
	return $string;
}

// Add descriptive icons to links
function iconLinks($string) {
	do {
		// PDF file
		$string = preg_replace('/(.*?.pdf\")/i', '$1.pdf" class="pdf"', $string, -1, $count);
	} while ($count);
	return $string;
}

// Send an email
function sendEmail($senderName, $senderEmail, $senderMessage) {
	// Settings
	$mailEmail = "tbalmer@marchtwenty.com";
	$mailSubject = "[" . $_SERVER['HTTP_HOST'] . "] Message from " . $senderName;
	
	// Header
	$mailHeader .= "From: webmaster@" . $_SERVER['HTTP_HOST'] . "\r\n";
	$mailHeader .= "Reply-To: " . $senderEmail . "\r\n";
	$mailHeader .= "MIME-Version: 1.0\r\n";
	//$mailHeader .= "X-Mailer: PHP/" . phpversion();
	
	// Message
	//$mailMsg .= "-- Message from a visitor to " . $_SERVER['HTTP_HOST'] . " --\n\n";
	$mailMsg .= $senderMessage . "\n\n";
	$mailMsg .= " ~ " . $senderName . " at " . $senderEmail . " on " . date('Y-m-d H:i:s') . "\n\n\n";
	$mailMsg .= "Web Browser: " . $_SERVER['HTTP_USER_AGENT'] . "\n";
	$mailMsg .= "IP Address:  " . $_SERVER['R	EMOTE_ADDR'] . "\n";	
	// Send email
	mail($mailEmail, $mailSubject, $mailMsg, $mailHeader);
	
	return "Message successfully sent.";
}

// Displays social bookmarks and their icons
function displaySocialBookmarks($TableID, $Title) {
	$Bookmarks = array(
		array(
			'title'=> 'Delicious',
			'url'  => 'http://del.icio.us/post?url=%1&title=%2',
			'icon' => 'delicious.png'
		),
		array(
			'title'=> 'Digg',
			'url'  => 'http://digg.com/submit?url=%1&title=%2',
			'icon' => 'digg.png'
		),
		array(
			'title'=> 'Facebook',
			'url'  => 'http://www.facebook.com/sharer.php?u=%1&t=%2',
			'icon' => 'facebook.png'
		),
		array(
			'title'=> 'Google',
			'url'  => 'http://www.google.com/bookmarks/mark?op=add&bkmk=%1&title=%2',
			'icon' => 'google.png'
		),
		array(
			'title'=> 'Live',
			'url'  => 'http://favorites.live.com/quickadd.aspx?marklet=1&mkt=en-us&url=%1&title=%2',
			'icon' => 'live.png'
		),
		array(
			'title'=> 'Magnolia',
			'url'  => 'http://ma.gnolia.com/bookmarklet/add?url=%1&title=%2',
			'icon' => 'magnolia.png'
		),
		array(
			'title'=> 'Mixx',
			'url'  => 'http://www.mixx.com/submit/story/?page_url=%1&title=%2',
			'icon' => 'mixx.png'
		),
		array(
			'title'=> 'Simpy',
			'url'  => 'http://www.simpy.com/simpy/LinkAdd.do?href=%1&title=%2',
			'icon' => 'simpy.png'
		),
		array(
			'title'=> 'Sphere',
			'url'  => 'http://www.sphere.com/search?q=%1',
			'icon' => 'sphere.png'
		),
		array(
			'title'=> 'StumbleUpon',
			'url'  => 'http://www.stumbleupon.com/submit?url=%1&title=%2',
			'icon' => 'stumble.png'
		),
		array(
			'title'=> 'Yahoo',
			'url'  => 'http://myweb2.search.yahoo.com/myresults/bookmarklet?u=%1&t=%2',
			'icon' => 'yahoo.png'
		)
	);
	
	for ($i = 0; $i < count($Bookmarks); $i++) {
		$Content .= "<a href=\"" . setupBookmark($Bookmarks[$i]['url'], $TableID, $Title) . "\"><img src=\"template/social/" . $Bookmarks[$i]['icon'] . "\" alt=\"" . $Bookmarks[$i]['title'] . "\" /></a>";
	}
	return $Content;
}

// Adds the proper values to the bookmark url
function setupBookmark($Url, $TableID, $Title) {
	$old = array('%1', '%2');
	$new = array($TableID, $Title);
	return str_replace($old, $new, $Url);
}

// Generates a gallery of thumbnails from the contents of a specific folder
function displayAlbum($gDir, $gUrl, $Columns) {
	$rowCount = 0;
	if (is_dir($gDir)) {
		if ($handle = opendir($gDir)) {
			$Content .= "<table cellspacing=\"3\" class=\"Gallery\">";
			$Content .= "<tr>";
			while (false !== ($file = readdir($handle))) {
				$rowBreak = ($rowCount % $Columns) ? 1 : 2;
				if ($file != '.' && $file != '..' && file_Image(file_Ext($file))) {
					if ($rowBreak == 2) $Content .= "</tr><tr>";
					$Content .= "<td><a href=\"" . $gUrl . $file . "\"><img src=\"thumbnail.php?t=" . $gUrl . $file . "\" alt=\"View image\" /><br /><strong>" . file_StripExt($file) . "</strong><br />" . /* file_Date($gDir . $file) . "<br />" . */ imageSize($gDir . $file) . " pixels</a></td>";
					$rowCount++;
				}
			}
			$Content .= "</tr>";
			$Content .= "</table>";
			closedir($handle);
		}
	}
	return $Content;
}

// Create tag cloud
function generateTagCloud() {
	include('directories.inc.php');
	$result = @mysql_query("SELECT catagories FROM Blogs ORDER BY id ASC");
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$Cats = explode(",", $row['catagories']);
		foreach ($Cats as $Cat) {
			if ($Cat) $Catagories[] = $Cat;
		}
	}
	$Catagories = array_unique($Catagories);
	sort($Catagories);
	for ($i = 0; $i < count($Catagories); $i++) {
		if ($Catagories[$i]) $Content .= " <a href=\"" . $currentUrl . "/Search." . EXTENSION . "?q=" . $Catagories[$i] . "\">" . $Catagories[$i] . "</a>";
	}
	return $Content;
}

// Get the Month from all the blog enties
function blogMonth() {
	$arrDate = array();
	$i = 0;
	$result = @mysql_query("SELECT * FROM Blogs ORDER BY id DESC");
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$Content .= "<option value=\"" . $row['id'] . ".blog\">" . date('y-m-d', strtotime($row['created'])) . " " . $row['title'] . "</option>";
	}
	return $Content;

/*
	$arrDate = array();
	$result = @mysql_query("SELECT created FROM Blogs ORDER BY id DESC");
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$arrDate[] = date('M Y', strtotime($row['created']));
	}
	$arrDate = array_unique($arrDate);
	$i = 0;
	while (count($arrDate) > $i) {		
		$Content .= "<option value=\"" . $i . "\">" . $arrDate[$i] . "</option>";
		$i++;
	}
	return $Content;
*/
}

/*
// Create a PNG image with variable text
function generateImage($string) {
	$im = imagecreatefrompng("images/button1.png");
	$orange = imagecolorallocate($im, 220, 210, 60);
	$px = (imagesx($im) - 7.5 * strlen($string)) / 2;
	imagestring($im, 3, $px, 9, $string, $orange);
	imagepng($im);
	imagedestroy($im);
}
*/

?>