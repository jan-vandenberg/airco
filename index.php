<?php
/*
A.I.R.C.O
index
@author #urk team
*/

session_start();
setlocale(LC_ALL, 'nl_NL.utf8');

//settings
include 'classes/settings.class.php';
$settings = new settings();
$config = $settings->getConf();
$texts = $settings->getTexts();

//other includes
include 'classes/forms.class.php';
include 'classes/users.class.php';
include 'classes/sql.class.php';

//db connection
$db = new sql($lang['sql']);
$db->connectDB(
	$config['db']['host'],
	$config['db']['name'],
	$config['db']['user'],
	$config['db']['pass']
);

//vars
$user = new users($texts['users'], $config['global']);
$mod = $_REQUEST['mod'];

//module switch
switch($mod)
{
	case 'logs':
	$headerText = "logs";
	$crumbs = "<a href=\"index.php\">home</a> &raquo; logs";
	if(!$user->validate())
	{
		$content = "<p class=\"text\">{$texts['users']['login']}</p>";
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
	$crumbs = "<a href=\"index.php\">home</a> &raquo; {$texts['users']['register']}";
	if(!$user->validate())
	{
		$content = "<p class=\"text\">{$texts['users']['login']}</p>";
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
		$content = "<p class=\"text\">{$texts['users']['login']}</p>";
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
		$content = "<p class=\"text\">{$texts['users']['login']}</p>";
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
		$content = "<p class=\"text\">{$texts['users']['login']}</p>";
	}
	else
	{
		include("modules/quotes.mod.php");
	}
	break;
	
	default:
	$headerText = "AIRCO, so cool it hurts";
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
include ("templates/{$config['global']['template']}/{$config['global']['template']}.tmp.php");
?>

