<?php
	require_once("../app/models/ImageModel.php");
	require_once("../app/models/ProjectModel.php");
	class IndexController extends Zend_Controller_Action
	{
		public function init() {
			//$this->session_alert = new Zend_Session_Namespace('');
			//$this->Model = new Model();
			$this->view->nav_home = 'active';
		}
		
		public function indexAction()
		{
			$image_model = new ImageModel();
			$project_model = new ProjectModel();
			
			$project_id = $this->_request->getParam('id');
			//If the project id isnt set, get a random one
			if (!$project_id) {
				$active_projects = $project_model->getActive();
				$project_id = $active_projects[array_rand($active_projects)]['id'];
			}
			
			$this->project = $project_model->getOne($project_id);
			$this->project['image'] = $image_model->getPrimary($project_id);

			$this->view->project = $this->project;
		}
		
	}
	
?>