<?php
	class Helper_Message extends Zend_Controller_Action_Helper_Abstract
	{
		public $messages = array();
		
		public function validate( $array )
		{
			$this->validateStr( $array['Name'], "Your Name", 5 );
			$this->validateEmail( $array['Email'] );
			$this->validateStr( $array['Message'], "Your Message", 0 );
			
			return $this->messages;
		}
		
		public function validateStr( $str, $type, $len )
		{ 
			//Check each post variable for blanks or spaces 
			$str_validator = new Zend_Validate_StringLength( $len );
			
			$str_validator->setMessage(
				$type . ', \'%value%\', is too short. It must be at least %min% ' . 'characters.',
			    Zend_Validate_StringLength::TOO_SHORT);
			
			if ( $str == $type || $str == "" || $str == " " ) {
				$error = "Please enter " . strtolower($type) . ".";
			    array_push($this->messages, $error);
			} 
			
			if (!$str_validator->isValid( $str )) {
			    foreach($str_validator->getMessages() as $error) {
				    array_push($this->messages, $error);
				}
			}
			
			return $this->messages;
		}
		
		public function validateEmail( $email )
		{ 
			//Check each post variable for blanks or spaces 
			$email_validator = new Zend_Validate_EmailAddress( );
			
			if( !$email_validator->isValid($email) ) {
				foreach($email_validator->getMessages() as $error) {
				    array_push($this->messages, $error);
				}
			}
			
			return $this->messages;
		}
		
		public function sendMessage( $array ) 
		{	
			$mail = new Zend_Mail();
			$mail->setBodyText($array['Message'])
			    ->setFrom($array['Email'], $array['Name'])
			    ->addTo('kellancraddock@gmail.com', 'Kellan Craddock')
			    ->setSubject('Email from Portfolio Site')
			    ->send();
		}
		
	}
?>