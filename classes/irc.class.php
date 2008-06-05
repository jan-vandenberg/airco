<?php
/*
A.I.R.C.O
irc class
@author #urk team
*/

class irc
{
	public $socket;
	
	function __construct($server, $port)
	{
		$this->socket = fsockopen($server, $port);
	}
	
	function login($password, $name, $nick)
	{
		$this->send('PASS', $password);
		$this->send('USER', $nick.' moo '.$nick.' :'.$name);
		$this->send('NICK', $nick);
	}
	
	function run()
	{
		$data = fgets($this->socket, 128);
		flush();
		
		$ex = explode(' ', $data);
		if($ex[0] == 'PING') {
			$this->send('PONG', $ex[1]);
		}
		
		usleep(10000);
	}
	
	function send($cmd, $msg = null)
	{
		if($msg == null) {
			fwrite($this->socket, $cmd ."\r\n");
			//echo '[IRC] '. $cmd . "\n";
		} else {
			fwrite($this->socket, $cmd .' '. $msg ."\r\n");
			//echo '[IRC] '. $cmd .' '. $msg . "\n";
		}
	}
}
