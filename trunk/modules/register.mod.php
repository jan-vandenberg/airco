<?php
/*
A.I.R.C.O
user registration module
@author #urk team
*/

if(!$user->register())
{
	$content = $user->form_register();	
}
?>
