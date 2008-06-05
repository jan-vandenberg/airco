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
	
	public function __construct()
	{		
		if(isset($_POST['data']))
		{
			$this->data = $_POST['data'];
		}
	}
	
	public function quote()
	{
		$error = false;
		
		if(count($this->data) > 0)
		{
			if(empty($this->data['quote'])) {
				$this->addMessage('error', 'Quote moet inevuld worren.');
				$error = true;
			}
			
			if(!$error)
			{
				$date = mktime(0, 0, 0, $this->data['month'], $this->data['day'], $this->data['year']);
				mysql_query('insert into quotes (id, userid , date, dateAdded, quote)
							 values (NULL, \''.$_SESSION['userdata']['id'].'\', \''.$date.'\', '.time().', \''.$this->data['quote'].'\')') or die(mysql_error());
				
				$externalMsg = 'er is een naaie quote eplaost duur ' . $_SESSION['userdata']['username'] .'';
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
				<input class="button" style="width:302px;" type="submit" name="submit" value="toevoegen" />
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
		$query = mysql_query("SELECT date, userid, quote from quotes ORDER BY date");
		while ($result = mysql_fetch_assoc($query))
		{
			$count++;
			$quotes[$count]['date'] = $result['date'];
			$quoteText = htmlspecialchars($result['quote']);
			$quotes[$count]['quote'] = nl2br($quoteText);
			$quotes[$count]['userid'] = $result['userid'];
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
}
?>
