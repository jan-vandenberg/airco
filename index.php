<?php
/*
A.I.R.C.O
index
@author #urk team
adsfsdfdsf
*/

session_start();
setlocale(LC_ALL, 'nl_NL.utf8');

//includes
include 'includes/config.inc.php';
include ("includes/{$language}.lang.php");
include 'classes/forms.class.php';
include 'classes/users.class.php';
include 'classes/sql.class.php';

//db connection
$db = new sql();
$db->connectDB($dbHost, $dbName, $dbUser, $dbPass);

//vars
$user = new users();
$mod = $_REQUEST['mod'];

//module switch
switch($mod)
{
	case 'logs':
	$headerText = "logs";
	$crumbs = "<a href=\"index.php\">home</a> &raquo; logs";
	if(!$user->validate())
	{
		$content = "<p class=\"text\">Log in fool!</p>";
	}
	else
	{
		include("modules/logs.mod.php");
	}
	break;
	
	case 'logout':
	include("modules/logout.mod.php");
	break;
	
	case 'register':
	$headerText = "registreren";
	$crumbs = "<a href=\"index.php\">home</a> &raquo; registreren";
	if(!$user->validate())
	{
		$content = "<p class=\"text\">Log in fool!</p>";
	}
	else
	{
		include("modules/register.mod.php");
	}
	break;
	
	case 'pics':
	$headerText = "poidh";
	$crumbs = "<a href=\"index.php\">home</a> &raquo; poidh";
	if(!$user->validate())
	{
		$content = "<p class=\"text\">Log in fool!</p>";
	}
	else
	{
		include("modules/pics.mod.php");
	}
	break;
	
	case 'chat':
	$headerText = "chat";
	$crumbs = "<a href=\"index.php\">home</a> &raquo; poidh";
	if(!$user->validate())
	{
		$content = "<p class=\"text\">Log in fool!</p>";
	}
	else
	{
		include("modules/chat.mod.php");
	}
	break;

	case 'quotes':
	$headerText = "quotes";
	$crumbs = "<a href=\"index.php\">home</a> &raquo; quotes";
	if(!$user->validate())
	{
		$content = "<p class=\"text\">Log in fool!</p>";
	}
	else
	{
		include("modules/quotes.mod.php");
	}
	break;
	
	default:
	$headerText = "AIRCO, it really whips the lama's ass";
	if(!$user->validate())
	{
		$content = $user->form_login();
	}
	else
	{
		include("modules/overview.mod.php");
	}
	
}

//include template
include ("templates/{$template}/grey.tmp.php");
?>

