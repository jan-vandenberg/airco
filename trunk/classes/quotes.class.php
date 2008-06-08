<?php
/*
A.I.R.C.O
quotes class
@author #urk team
*/

class quotes extends forms
{
	private $data = array();
	private $messages = array();
	
	public function __construct($texts)
	{		
		if(isset($_POST['data']))
		{
			$this->data = $_POST['data'];
		}
		$this->texts = $texts;
	}
	
	public function quote()
	{
		$error = false;
		
		if(count($this->data) > 0)
		{
			if(empty($this->data['quote'])) {
				$this->addMessage('error', $this->texts['empty']);
				$error = true;
			}
			
			if(!$error)
			{
				$date = mktime(0, 0, 0, $this->data['month'], $this->data['day'], $this->data['year']);
				mysql_query('insert into quotes (id, userid , date, dateAdded, quote)
							 values (NULL, \''.$_SESSION['userdata']['id'].'\', \''.$date.'\', '.time().', \''.$this->data['quote'].'\')') or die(mysql_error());
				
				$externalMsg = $this->texts['new'] . $_SESSION['userdata']['username'] .'';
				include 'modules/chat.mod.php';

				return true;
			}
		}
		
		return false;
	}
	
	public function form_quote()
	{
		$dateSelect = $this->dateInput();
		$form = $this->render_messages('error');
		$form .= '
		<div class="form" style="width: 320px;">
			<form method="post">
                                <select name="data[day]">
				'.$dateSelect["d"].'
                                </select>
                                <select name="data[month]">
				'.$dateSelect["m"].'
                                </select>
                                <select name="data[year]">
				'.$dateSelect["y"].'
                                </select><br />
				<textarea name="data[quote]">'.$this->getValue("quote").'</textarea>
				<input class="button" style="width:302px;" type="submit" name="submit" value="'.$this->texts['gen']['add'].'" />
			</form>
		</div>
		';
		
		return $form;		
	}
	
	private function dateInput()
	{
		$now = time();
		$thisDay = strftime("%d", $now);
		$thisMonth = strftime("%m", $now);
		$thisYear = strftime("%Y", $now);

		for($d=1; $d<=31; $d++)
		{
			$days = sprintf("%02s", $d);
			if ($days == $thisDay)
			{
				$selected = " SELECTED";
			}
			else
			{
				$selected = "";
			}
			$daysSelect .= "<option value=\"{$d}\"{$selected}>{$days}</option>";
		}

		for($m=1; $m<=12; $m++)
		{
			$months = sprintf("%02s", $m);
			if ($months == $thisMonth)
			{
				$selected = " SELECTED";
			}
			else
			{
				$selected = "";
			}
			$monthsSelect .= "<option value=\"{$m}\"{$selected}>{$months}</option>";
		}

		for($y=($thisYear-5); $y<=$thisYear; $y++)
		{
			$years = sprintf("%02s", $y);
			if ($years == $thisYear)
			{
				$selected = " SELECTED";
			}
			else
			{
				$selected = "";
			}
			$yearsSelect .= "<option value=\"{$y}\"{$selected}>{$years}</option>";
		}

		$dateSelect = array("d"=>$daysSelect, "m"=>$monthsSelect, "y"=>$yearsSelect);
		return $dateSelect;
	}
	
	public function getQuotes()
	{
		$count = 0;
		$start = 0;
		$limit = $start.",100";
		if(!isset ($order))
		{
			$order = "date";
		}
		
		$query = mysql_query("SELECT id, date, userid, quote, rating, votes from quotes ORDER BY {$order} LIMIT {$limit}");
		while ($result = mysql_fetch_assoc($query))
		{
			$count++;
			$quotes[$count]['id'] = $result['id'];
			$quotes[$count]['date'] = $result['date'];
			$quoteText = htmlspecialchars($result['quote']);
			$quotes[$count]['quote'] = nl2br($quoteText);
			$quotes[$count]['userid'] = $result['userid'];
			$quotes[$count]['rating'] = round(($result['rating']/5)*100);
			$quotes[$count]['votes'] = $result['votes'];
		}
		return $quotes;
	}
	
	public function getPoster($id)
	{
		$query = mysql_query("SELECT username from users WHERE id = '{$id}'");
		while ($result = mysql_fetch_assoc($query))
		{
			$postedBy = $result['username'];
		}
		return $postedBy;
	}
	
	public function checkRating($id)
	{
		$query = mysql_query("SELECT quoteID from quoteRating WHERE quoteID = '{$id}' AND userID = '{$_SESSION['userdata']['id']}'");	
		$result = mysql_fetch_assoc($query);
		if(count($result['quoteID']) < 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function form_rating($id, $count)
	{
		$form = "
			<form name=\"rating{$count}\" method=\"post\">
				<input type=\"hidden\" name=\"data[quoteid]\" value=\"{$id}\" />
				<select name=\"data[score]\" onchange=\"rating{$count}.submit()\">
					<option style=\"font-weight: bold;\">rate it</option>
					<option value=\"1\">1</option>
					<option value=\"2\">2</option>
					<option value=\"3\">3</option>
					<option value=\"4\">4</option>
					<option value=\"5\">5</option>
				</select>
			</form>
		";		
		return $form;		
	}
	
	public function rate()
	{
		if(count($this->data) > 0)
		{
			mysql_query('insert into quoteRating (quoteID, userID , rating)
						 values (\''.$this->data['quoteid'].'\',\''.$_SESSION['userdata']['id'].'\', \''.$this->data['score'].'\')') or die(mysql_error());
			
			$newRating = $this->getRating($this->data['quoteid']);
			mysql_query('update quotes set rating=\''.$newRating['rating'].'\', votes=\''.$newRating['count'].'\' where id=\''.$this->data['quoteid'].'\'');
			
			return true;
		}
		return false;
	}
	
	private function getRating($id)
	{
		$query = mysql_query("SELECT rating from quoteRating WHERE quoteID = '{$id}'");
		$score = 0;
		$count = 0;
		$rating = 0.0;
		$ratingData = "";

		while ($result = mysql_fetch_assoc($query))
		{
			$count++;
			$score = $score + $result['rating'];
		}
		if ($score > 0)
		{
			$rating = $score/$count;
			$rating = round($rating, 2);
			$rating = str_replace(",",".",$rating);
		}
		$ratingData['rating'] = $rating;
		$ratingData['count'] = $count;
		return $ratingData;
	}
}
?>
