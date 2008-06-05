<?php
/*
A.I.R.C.O
chat module
@author #urk team
*/

if(isset($_POST['msg']) or isset($externalMsg)) {

if(!isset($ircConfig)) {
	include 'includes/config.inc.php';
}

set_time_limit(0);

if(isset($_POST['msg'])) {
	$msg = $_POST['msg'];
}

if(isset($externalMsg)) {
	$msg = $externalMsg;
}

/* IRC */
require 'classes/irc.class.php';
$irc = new irc($ircConfig['server'], $ircConfig['port']);
$irc->login($ircConfig['password'], $ircConfig['name'], $ircConfig['nickname']);
$count = 0;

do {
	
	if($count == 15) {
		foreach($ircConfig['channels'] as $channel) {
			$irc->send("PRIVMSG", $channel.' :'.$msg);
		}
		$irc->send("NICK", "dwa");
		break;
	}
	$irc->run();
	$count++;
	
} while (true);
}

$bodyLoad = " onload=\"document.form.msg.focus();\"";
$content = "
	<div class=\"form\">
		<form method=\"post\" name=\"form\">
			<input type=\"text\" name=\"msg\" />
			<input class=\"button\" type=\"submit\" value=\"blaat\" />
		</form>
	</div>
";
?>

