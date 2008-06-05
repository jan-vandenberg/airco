<?php
/*
A.I.R.C.O
logout module
@author #urk team
*/

unset($_SESSION['userdata']);
header("Location: index.php");
