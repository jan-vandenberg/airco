<?php
/*
A.I.R.C.O
sql class
@author #urk team
*/

class sql
{
	public function connectDB($host, $db, $user, $pass)
	{
		mysql_connect($host, $user, $pass) or die ($lang_sql['connection']."<br />". mysql_error());
		mysql_select_db($db) or die ($lang_sql['dbselect']."<br />". mysql_error());
	}
}

?>
