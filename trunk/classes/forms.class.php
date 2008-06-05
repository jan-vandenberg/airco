<?php
/*
A.I.R.C.O
sql class
@author #urk team
*/

class forms
{
	private $messages = array();
	private $data = array();
	
	public function render_messages($type = null)
	{
		$messages = null;
		
		foreach($this->getMessages($type) as $message) {
			if(is_array($message)) {
				foreach($message as $msgtype => $msg) {
				$messages .= '<div class="'.$msgtype.'">'.$msg.'</div>';	
				}
			} else {
				$messages .= '<div class="'.$type.'">'.$message.'</div>';
			}
		}
		
		return $messages;
	}
	
	public function getMessages($type = null)
	{
		if($type != null and array_key_exists($type, $this->messages)) {
			return $this->messages[$type];
		}
		
		return $this->messages;
	}
	
	public function addMessage($type, $message)
	{
		$this->messages[$type][] = $message;
	}
	
	public function getValue($name)
	{
		if(array_key_exists($name, $this->data)) {
			return $this->data[$name];
		}
		
		return false;
	}
}
?>
