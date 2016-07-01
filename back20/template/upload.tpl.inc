<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>{SITE_TITLE}</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="copyright" content="(c) {COPYRIGHT} March Twenty Productions" />
<meta name="authors" content="Ted Balmer @ marchtwenty.com" />
<meta name="robots" content="noindex, nofollow" />
<style type="text/css" media="screen,projection,handheld">@import "{DOMAIN}/template/style.css";</style>
<link type="image/x-icon" rel="shortcut icon" href="{DOMAIN}/favicon.ico" />
<script type="text/javascript">
<!--
function uThrobber() {
	document.getElementById('uResponse').innerHTML = '<img src="{DOMAIN}/template/graphics/upload.gif" /> Uploading... Please wait.';
}
//-->
</script>
</head>

<body>

<div id="Page">
	<div id="Header">
		<div id="Logo"></div>
		<h1>{SITE_TITLE}</h1>
		<dl>
			<dd><a href="javascript:Logout();">Logout</a></dd>
			<dd><a href="{DOMAIN}/tools.cms">Tools</a></dd>
			<dd><a href="{DOMAIN}/">Home</a></dd>	
		</dl>
	</div>
	
	<div id="PageTitle" style="margin-top:30px">{PAGE_TITLE}</div>

	<div id="Content">
		<p>Upload a file from your computer. <em>Max file size is 10 MB.</em></p>
		<form name="form" enctype="multipart/form-data" action="upload.php" method="post">
			<div id="UploadBox">
				<p>Select a file <input type="file" name="uploadedfile" value="" size="42" maxlength="255" /></p>
				<p class="Buttons"><input type="submit" value=" Upload File " onclick="uThrobber()" /> &nbsp; <input type="button" value=" Cancel " onclick="window.location='files.cms'" /> <span id="uResponse"></span></p>
			</div>
			<input type="hidden" name="MAX_FILE_SIZE" value="10500000" />
			<input type="hidden" name="process" value="1" />
		</form>
		<p class="red center">{RESPONSE}</p>
	</div>

	<div id="Footer">Copyright &copy; {COPYRIGHT} <a href="http://www.marchtwenty.com/services/">March Twenty Productions</a>. All rights reserved.</div>
	<div id="Version">Version: {VERSION}</div>
</div>

</body>
</html>