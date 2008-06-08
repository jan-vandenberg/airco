<?php
/*
A.I.R.C.O
irc class
@author #urk team
*/

class irc
{
	public $socket;
	
	function __construct($config)
	{
		$this->socket = fsockopen($config['server'], $config['port']);
		$this->config = $config;
	}
	
	function login()
	{
		$this->send('PASS', $this->config['password']);
		$this->send('USER', $this->config['nick'].' moo '.$this->config['nick'].' :'.$this->config['name']);
		$this->send('NICK', $this->config['nick']);
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
