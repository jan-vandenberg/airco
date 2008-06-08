<?php
/*
A.I.R.C.O
sql class
@author #urk team
*/

class sql
{
	public function __construct($texts)
	{		
		$this->texts = $texts;
	}
	
	public function connectDB($host, $db, $user, $pass)
	{
		mysql_connect($host, $user, $pass) or die ($this->texts['connection']."<br />". mysql_error());
		mysql_select_db($db) or die ($this->texts['dbselect']."<br />". mysql_error());
	}
}

?>
