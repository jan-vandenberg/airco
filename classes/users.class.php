<?php
/*
A.I.R.C.O
users class
@author #urk team
*/

class users extends forms
{
	private $salt = 'Moomoo Poopoo';
	private $data = array();
	
	public function __construct($texts, $config)
	{		
		if(isset($_POST['data'])) {
			$this->data = $_POST['data'];
		}
		$this->texts = $texts;
		$this->config = $config;
	}
	
	public function register()
	{
		$error = false;
		
		if(count($this->data) > 0) {
			if(!empty($this->data['password1']) and !empty($this->data['password2'])) {
				if($this->data['password1'] != $this->data['password2']) {
					$this->addMessage('error', $this->texts['pwdCheck']);
					$error = true;	
				}
			} else {
				$this->addMessage('error', $this->texts['pwdEmpty']);
				$error = true;
			}
			
			if(empty($this->data['username'])) {
				$this->addMessage('error', $this->texts['usrEmpty']);
				$error = true;
			}
			
			if(empty($this->data['mail'])) {
				$this->addMessage('error', $this->texts['mailEmpty']);
				$error = true;
			}
			
			if(!$this->checkUsername($this->data['username'])) {
				$this->addMessage('error', $this->texts['usrExists']);
				$error = true;
			}
			
			if(!$error) {
				$password = md5($this->salt . $this->data['password1']);
				mysql_query('insert into users (id, username , password, mail)
							 values (NULL, \''.$this->data['username'].'\', \''.$password.'\', \''.$this->data['mail'].'\')') or die(mysql_error());
				
				return true;
			}
		}
		
		return false;
	}
	
	public function login($username, $password, $encrypted = false)
	{
		if(!$encrypted) {
			$password = md5($this->salt . $password); 
		}
		
		$query = mysql_query("select * from users where username = '{$username}' and password = '{$password}'");
		
		if(mysql_num_rows($query) > 0) {
			$result = mysql_fetch_assoc($query);
			$_SESSION['userdata'] = $result;
			if($this->data['cookie'] == "on")
			{
				setcookie ("aircookie_usr",$_SESSION['userdata']['username'],time()+2592000,"/",$config['hostname'],0);
				setcookie ("aircookie_pwd",$_SESSION['userdata']['password'],time()+2592000,"/",$config['hostname'],0);
			}
			return true;
		}
		
		$this->addMessage('error', $this->texts['wrongData']);
		return false;
	}
	
	public function validate()
	{
		if(array_key_exists('login', $this->data)) {
			if(isset($this->data['username']) and isset($this->data['password'])) {
				return $this->login($this->data['username'], $this->data['password']);
			}
		} elseif(is_array($_SESSION['userdata'])) {
			if(isset($_SESSION['userdata']['username']) and isset($_SESSION['userdata']['password'])) {
				return $this->login($_SESSION['userdata']['username'], $_SESSION['userdata']['password'], true);
			}
		} elseif(is_array($_COOKIE)) {
			if(isset($_COOKIE['aircookie_usr']) and isset($_COOKIE['aircookie_pwd'])) {
				return $this->login($_COOKIE['aircookie_usr'], $_COOKIE['aircookie_pwd'], true);
			}
		}
		
		return false;
	}
	
	public function form_login()
	{
		$form = $this->render_messages('error');
		$form .= '
		<div class="form">
			<form method="post">
				<input type="hidden" name="data[login]" value="1" />
				<input type="text" name="data[username]" value="'.$this->texts['username'].'" onfocus="this.value=\'\'" /><br />
				<input type="password" name="data[password]" value="'.$this->texts['password'].'" onfocus="this.value=\'\'" /><br />
				<input class="button" type="submit" name="submit" value="inloggen" /><br />
		</div>
				<input class="cookie" type="checkbox" name="data[cookie]" value="on" /> '.$this->texts['rememberMe'].'
			</form>
		';
		
		return $form;
	}
	
	public function form_register()
	{
		$form = $this->render_messages('error');
		$form .= '
		<div class="form">
			<form method="post">
				username<br /><input type="text" name="data[username]" value="'.$this->getValue("username").'" /><br />
				password1<br /><input type="password" name="data[password1]" /><br />
				password2<br /><input type="password" name="data[password2]" /><br />
				e-mail<br /><input type="text" name="data[mail]" /><br />
				<input class="button" type="submit" name="submit" value="'.$this->texts['register'].'" />
			</form>
		</div>
		';
		
		return $form;		
	}
	
	private function checkUsername($username)
	{
		$query = mysql_query('select id from users where username = \''.$username.'\'');
		if(mysql_num_rows($query) > 0) {
			return false;
		}
		
		return true;
	}
}
