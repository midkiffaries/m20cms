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
<!--script type="text/javascript" src="{DOMAIN}/js/openwysiwyg/scripts/wysiwyg.js"></script>
<script type="text/javascript" src="{DOMAIN}/js/openwysiwyg/scripts/wysiwyg-settings.js"></script-->
<script type="text/javascript" src="{DOMAIN}/js/calendarpopup.js"></script>
<script type="text/javascript">document.write(getCalendarStyles());</script>
<script type="text/javascript" src="{DOMAIN}/js/m20system.js"></script>
</head>

<body{ONLOAD_JS}>

<div id="Page">
	<div id="Header">
		<div id="Logo"></div>
		<h1>{SITE_TITLE}</h1>
		<dl>
			<dd><a href="javascript:Logout();">Logout</a></dd>
			<!--dd><a href="{DOMAIN}/system.cms">System</a></dd-->
			<dd><a href="{DOMAIN}/tools.cms">Tools</a></dd>
			<dd><a href="{DOMAIN}/">Home</a></dd>	
		</dl>
	</div>

	<div id="Nav">
		<dl>
			<dd><a href="{DOMAIN}/blog.cms">Blog</a></dd>
			<dd><a href="{DOMAIN}/calendar.cms">Calendar</a></dd>
			<dd><a href="{DOMAIN}/comments.cms">Comments</a></dd>			
			<dd><a href="{DOMAIN}/files.cms">Files</a></dd>
			<dd><a href="{DOMAIN}/gallery.cms">Gallery</a></dd>
			<dd><a href="{DOMAIN}/page.cms">Pages</a></dd>
			<dd><a href="{DOMAIN}/poll.cms">Polls</a></dd>
			<!--dd><a href="{DOMAIN}/navigation.cms">Navigation</a></dd-->
			<dd><a href="{DOMAIN}/users.cms">Users</a></dd>
			<!--dd><a href="{DOMAIN}/visitors.cms">Visitors</a></dd-->
		</dl>
	</div>

	<div id="PageTitle">{PAGE_TITLE}</div>

	<div id="Content">
<form name="form" method="post" action="/">
{PAGE_CONTENT}

<input type="hidden" name="item0" value="0" />
<input type="hidden" name="Page" value="{PAGE_NAME}" />
<input type="hidden" name="itemFunction" value="0" />
<input type="hidden" name="tableIndex" value="0" />
<input type="hidden" name="numRows" value="0" />
<input type="hidden" name="monthOffset" value="0" />
</form>
	</div>

	<div id="Footer">&copy; {COPYRIGHT} <a href="http://www.marchtwenty.com/services/">MarchTwenty.com</a></div>
	<div id="Version">Version: {VERSION}</div>
</div>

<div id="Processing"></div>

</body>
</html>