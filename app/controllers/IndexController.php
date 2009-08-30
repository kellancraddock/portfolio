<?php
	class IndexController extends Zend_Controller_Action
	{
		public function init() {
			//$this->session_alert = new Zend_Session_Namespace('');
			//$this->Model = new Model();
			$this->view->nav_home = 'active';
		}
		
		public function indexAction()
		{

		}
		
	}
	
?>