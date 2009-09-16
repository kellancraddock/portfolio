<?php
	class ContactController extends Zend_Controller_Action
	{
		public function init()
		{
			$this->view->nav_contact = 'active';
		}
		
		public function indexAction()
		{
				
		}
		
		public function mailAction()
		{
			$postArray = array(
				'Name'=>$_POST['name'],
				'Email'=>$_POST['email'],
				'Message'=>$_POST['message']
			);
						
			//Mail Helper
			$message_helper = $this->_helper->Message;
			$errors = $message_helper->validate($postArray);

			if ($errors) {
				$this->view->mail_status = array('status' => 'fail', 'message' => $errors);	
			} else {
				$message_helper->sendMessage($postArray);
				$this->view->mail_status = array('status' => 'success', 'message' => 'Thanks for the message!');
			}
				
			header( "Location: /contact" );
		}

	}
	
?>