<?php
/*
A.I.R.C.O
quotes module
@author #urk team
*/

include 'classes/quotes.class.php';
$do = $_REQUEST['do'];
$quote = new quotes();

switch($do)
{
	case 'add':
	$crumbs = "<a href=\"index.php\">home</a> &raquo; <a href=\"index.php?mod=quotes\">quotes</a> &raquo; toevoegen";
	if(!$quote->quote())
	{
    	    $content = $quote->form_quote();
	}
	break;
	
	default:
	$quotes = $quote->getQuotes();
	$count = 0;
	$extraButtons = "<a href=\"index.php?mod=quotes&do=add\" title=\"toevoegen\"><img src=\"images/add.png\" width=\"30\" height=\"30\" alt=\"links\" /></a>";
	if (!empty($quotes))
	{
		foreach ($quotes AS $key=>$val)
		{
			$count++;
			$postedBy = $quote->getPoster($val['userid']);
			$quoteDate = strftime("%A %d %B %Y",$val['date']);
			$content .= "
				<div class=\"quote\">
					<p class=\"postedBy\">
						posted by {$postedBy}
					</p>
					<form name=\"rating{$count}\" method=\"post\">
						<select name=\"score\" onchange=\"rating{$count}.submit()\">
							<option style=\"font-weight: bold;\">rate it</option>
							<option value=\"1\">1</option>
							<option value=\"2\">2</option>
							<option value=\"3\">3</option>
							<option value=\"4\">4</option>
							<option value=\"5\">5</option>
						</select>
					</form>
					<p><b>$quoteDate</b></p>
					<p class=\"quote\">{$val['quote']}</p>
					<div>
						<img src=\"images/star-on.png\" width=\"25\" height=\"25\" alt=\"star\" />
						<img src=\"images/star-on.png\" width=\"25\" height=\"25\" alt=\"star\" />
						<img src=\"images/star-half.png\" width=\"25\" height=\"25\" alt=\"star\" />
						<img src=\"images/star-off.png\" width=\"25\" height=\"25\" alt=\"star\" />
						<img src=\"images/star-off.png\" width=\"25\" height=\"25\" alt=\"star\" />
					</div>
				</div>
			";
		}
	}
	else
	{
		$content = "<p class=\"text\">nog gien quotes<br />klik op et warreldbolletjen om er iene toe te voegen</p>";
	}
}
?>
