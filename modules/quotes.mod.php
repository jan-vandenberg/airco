<?php
/*
A.I.R.C.O
quotes module
@author #urk team
*/

include 'classes/quotes.class.php';
$quote = new quotes($texts['quotes'], $config['irc']);
$do = $_REQUEST['do'];
$texts = $texts['quotes'];

switch($do)
{
	case 'add':
		$crumbs = "<a href=\"index.php\">home</a> &raquo; <a href=\"index.php?mod=quotes\">quotes</a> &raquo; {$texts['gen']['add']}";
	if(!$quote->quote())
	{
    	    $content = $quote->form_quote();
	}
	break;
	
	default:
	$quotes = $quote->getQuotes();
	$count = 0;
	$extraButtons = "<a href=\"index.php?mod=quotes&do=add\" title=\"{$texts['gen']['add']}\"><img src=\"images/add.png\" width=\"30\" height=\"30\" alt=\"links\" /></a>";
	if (!empty($quotes))
	{
		$quote->rate();
		foreach ($quotes AS $key=>$val)
		{
			$count++;
			$postedBy = $quote->getPoster($val['userid']);
			$quoteDate = strftime("%A %d %B %Y",$val['date']);
			if($quote->checkRating($val['id']))
			{
				$rateForm = $quote->form_rating($val['id'], $count);
			}
			else
			{
				$rateForm = false;
			}
			$content .= "
				<div class=\"quote\">
					<p class=\"postedBy\">
					{$texts['postedby']} {$postedBy}, {$val['votes']} {$texts['votes']}
					</p>
					{$rateForm}
					<p><b>$quoteDate</b></p>
					<p class=\"quote\">{$val['quote']}</p>
					<div><div style=\"width: {$val['rating']}%\"></div></div>
				</div>
			";
		}
	}
	else
	{
		$content = "<p class=\"text\">{$texts['noquotes']}</p>";
	}
}
?>
