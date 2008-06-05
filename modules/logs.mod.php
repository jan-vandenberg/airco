<?php
/*
A.I.R.C.O
log archive module
@author #urk team
*/

$do = $_REQUEST['do'];

switch($do)
{
	case 'view':
	$log = $_REQUEST['log'];
	$crumb = substr($log, -10);
	$crumbs = "<a href=\"index.php\">home</a> &raquo; <a href=\"index.php?mod=logs\">logs</a> &raquo; {$crumb}";
	if (isset($_REQUEST['links'])) { $links = $_REQUEST['links']; } else { $links = "off"; }
	$logContent = file_get_contents($log);
	if ($links=="off")
	{
		$linkToggle = "on";
		$content = htmlspecialchars($logContent);
		$content = nl2br($content);
	}
	if ($links=="on")
	{
		$crumbs = "<a href=\"index.php\">home</a> &raquo; <a href=\"index.php?mod=logs\">logs</a> &raquo; links";
		$linkToggle = "off";
		preg_match_all("#(http|https|ftp)://[^\s]+#ui",$logContent,$matches);
		foreach($matches[0] as $key=>$val)
		{
			$content .= "<a href=\"{$val}\">{$val}</a><br />";
		}
		if(empty($content))
		{
			$content = "No links fool!.";
		}
	}
	$content = "<p class=\"log\">{$content}</p>";
	$extraButtons = "<a href=\"index.php?mod=logs&do=view&log={$log}&links={$linkToggle}\"><img src=\"images/links.png\" width=\"30\" height=\"30\" alt=\"links\" /></a>";
	break;

	default:
	for ($i=1;$i<=12;$i++)
	{
        	$logs = "";
	        $month = sprintf("%02s", $i);
        	$title = strftime("%B", mktime(0,0,0,$i+1,0,0));
	        foreach (glob("logfiles/urk.log.*-$month-2008") as $link)
        	{
                	$name = substr($link, -10);
	                $logs .= "<a href=\"index.php?mod=logs&do=view&log={$link}\">{$name}</a><br />";
        	}
	        if (!empty($logs))
        	{
                	$content .= "
	                        <div class=\"logBlock\">
        	                        <p class=\"logMonth\">{$title}</p>
                	                <p>{$logs}</p>  
                        	</div>
	                ";
        	}
	}
}


?>

