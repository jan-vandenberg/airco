<?php
/*
A.I.R.C.O
settings class
@author #urk team
*/

class settings
{
	public function getConf()
	{
		include 'includes/config.inc.php';
		$config = get_defined_vars();
		$this->language = $config['global']['language'];
		return $config;
	}
	
	public function getTexts()
	{
		include ("includes/{$this->language}.lang.php");
		$lang = get_defined_vars();
		return $lang;
	}
}
?>
