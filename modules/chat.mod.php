<?php
/*
A.I.R.C.O
chat module
@author #urk team
*/

if(isset($_POST['msg']) or isset($externalMsg)) {

set_time_limit(0);

if(isset($_POST['msg'])) {
	$msg = $_POST['msg'];
}

if(isset($externalMsg)) {
	$msg = $externalMsg;
}

/* IRC */
//data from config file, doesn't load
$config['irc'] = array(
	"server"	=> "my.ircproxy.com",
	"port"		=> 1234,
	"nickname"	=> "botnick",
	"name"		=> "botname",
	"password" 	=> "1234",
	"channels"	=> array("#channel"),
);

require 'classes/irc.class.php';
$irc = new irc($config['irc']);
$irc->login();
$count = 0;

do {
	
	if($count == 15) {
		foreach($config['irc']['channels'] as $channel) {
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

