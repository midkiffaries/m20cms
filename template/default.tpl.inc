<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>{SITE_TITLE}</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="description" content="Blogs, galleries, and more." />
<meta name="copyright" content="(c) {COPYRIGHT} MarchTwenty.com" />
<meta name="authors" content="Ted Balmer @ marchtwenty.com" />
<meta name="robots" content="index, follow" />
<style type="text/css" media="screen,projection,tv,print">@import "{DOMAIN}/template/style.css";</style>
<style type="text/css" media="print">@import "{DOMAIN}/template/print.css";</style>
<script type="text/javascript" src="{DOMAIN}/include/default.js"></script>
<link type="image/x-icon" rel="shortcut icon" href="{DOMAIN}/favicon.ico" />
<link type="application/rss+xml" rel="alternate" href="{DOMAIN}/blog.rss" title="Blog" />
<link type="application/rss+xml" rel="alternate" href="{DOMAIN}/calendar.rss" title="Calendar" />
</head>

<body onload="pageLoad()">

<div id="Page">
	<div id="Top"{NIGHT}>
		<div id="TimeOfDay"{NIGHT}>
			<div id="SiteTitle" onclick="location.href='{DOMAIN}/'"><a href="{DOMAIN}/">{SITE_TITLE}</a></div>
			<div id="SearchBox"><form name="search" method="post" action="{DOMAIN}/Search.{EXT}"><input type="text" id="Search" name="q" size="9" maxlength="120" value="Search" onfocus="if(this.value=='Search') this.value=''" onblur="if(this.value=='') this.value='Search'" /></form></div>
			<div id="RSS"><a href="calendar.rss"><img src="template/layout/cal_sm.png" alt="Calendar RSS Feed" /></a> <a href="blog.rss"><img src="template/layout/rss_sm.png" alt="Blog RSS Feed" /></a></div>			
			<!--div id="AdjustFont">Text size: <span class="Large" onclick="cFontSize(120)">A</span> <span class="Small" onclick="cFontSize(90)">A</span> | <span onclick="printWin()">Print</span></div-->
		</div>
	</div>
	
	<div id="Body">
		<!--div id="PageTitle">{PAGE_TITLE}</div-->
		<div id="Right">
			<div id="Nav">
				<a href="{DOMAIN}/Blogs.{EXT}"><span id="Blog">&nbsp;</span> Blog</a>
				<a href="{DOMAIN}/Gallery.{EXT}"><span id="Gallery">&nbsp;</span> Gallery</a>
				<a href="{DOMAIN}/About.{EXT}"><span id="About">&nbsp;</span> About</a>
				<a href="{DOMAIN}/Contact.{EXT}"><span id="Contact">&nbsp;</span> Contact</a>
			</div>
			<div id="Sites">
				<a href="http://mistletoe.marchtwenty.com/" target="_blank"><img src="template/layout/mistletoe.png" alt="Mistletoe's Night" /></a>
				<a href="http://remlab.sourceforge.net/" target="_blank"><img src="template/layout/remlab.png" alt="REMLAB Web Mech Designer" /></a>
				<a href="http://picasaweb.google.com/Ted.Balmer" target="_blank"><img src="template/layout/picasa.png" alt="Picasa Photo Album" /></a>
				<a href="http://www.vimeo.com/marchtwenty" target="_blank"><img src="template/layout/vimeo.png" alt="Vimeo Web Videos" /></a>
				<a href="http://www.google.com/ig/directory?q=ted+balmer&type=themes&dpos=themes" target="_blank"><img src="template/layout/igoogle.png" alt="iGoogle Themes" /></a>				
				<a href="http://www.cafepress.com/marchtwenty" target="_blank"><img src="template/layout/cafepress.png" alt="Cafepress Store" /></a>
			</div>
			{TAG_CLOUD}
		</div>
		
		<div id="Left">
			<div id="Content">
{PAGE_CONTENT}
			</div>
		</div>
	</div>

	<div id="Bottom">
		<div id="Footer">&copy; <acronym title="{COPYRIGHT}">{COPYRIGHT_ROMAN}</acronym> {SITE_TITLE}</div>
	</div>
</div>

</body>
</html>