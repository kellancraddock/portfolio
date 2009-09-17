<?php
	class ContactController extends Zend_Controller_Action
	{
		public function init()
		{
			$this->view->nav_contact = 'active';
			$this->mail_session = new Zend_Session_Namespace('mail');
		}
		
		public function indexAction()
		{
			$this->view->mail_status = 	$this->mail_session->status;
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
				$this->mail_session->status = array('status' => 'fail', 'message' => $errors);	
			} else {
				$message_helper->sendMessage($postArray);
				$this->mail_session->status = array('status' => 'success', 'message' => 'Thanks for the message!', 'name' => $_POST['name']);
			}
				
			header( "Location: /contact" );
		}

	}
	
?>