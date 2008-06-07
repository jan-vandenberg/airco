<?php
/*
A.I.R.C.O
logout module
@author #urk team
*/

setcookie ("aircookie_usr","",time()-3600,"/","hekjeurk.nl",0);
setcookie ("aircookie_pwd","",time()-3600,"/","hekjeurk.nl",0);
unset($_SESSION['userdata']);
header("Location: index.php");
