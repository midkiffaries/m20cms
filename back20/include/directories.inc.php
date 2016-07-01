<?php

// -- Directories and URLs -- //
define('CMS_NAME', 'back20');

// Linux Box location
//$Directory = '/home/ted/Web/m20backend2/';
// Powweb location
//$Directory = '/home/users/web/b954/pow.tedbalmer/htdocs/';

// Default Unix directories
$currentDir = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . dirname($_SERVER['PHP_SELF']);
//$rootDir = rtrim(rtrim($currentDir, '/include'), CMS_NAME);
$mediaDir = str_replace(CMS_NAME, '', $currentDir) . 'media/';
$galleryDir = str_replace(CMS_NAME, '', $currentDir) . '/gallery/';

// Default HTTP directories
$siteUrl = 'http://' . $_SERVER['HTTP_HOST'];
//$currentUrl = $siteUrl;
$currentUrl = rtrim($siteUrl . dirname($_SERVER['PHP_SELF']), '/');
//$baseUrl = rtrim(rtrim($currentUrl, '/include'), CMS_NAME);
$mediaUrl = str_replace(CMS_NAME, '', $currentUrl) . '/media/';
$galleryUrl = $currentUrl . '/gallery/';

?>