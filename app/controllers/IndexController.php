<?php
	require_once("../app/models/ImageModel.php");
	require_once("../app/models/ProjectModel.php");
	class IndexController extends Zend_Controller_Action
	{
		public function init() {
			$this->image_model = new ImageModel();
			$this->project_model = new ProjectModel();
			$this->view->nav_home = 'active';
			$this->is_ajax = $this->getRequest()->isXmlHttpRequest();
		}
		
		public function indexAction()
		{	
			$active_projects = $this->project_model->getActive();
			$project_id = $active_projects[array_rand($active_projects)]['id'];
			
			$this->project = $this->project_model->getOne($project_id);
			$this->project['image'] = $this->image_model->getPrimary($project_id);
			
			$this->view->project = $this->project;
		}
		
		public function imagesAction()
		{
			if (!$this->is_ajax) {
				header("Location: /");
			}
			$ignore = $_POST['id'];
			$active_projects = $this->project_model->getActive();
			
			$images = array();
			foreach ($active_projects as $project) {
				if ($project['id'] != $ignore) {
				$images[] = $this->image_model->getPrimary($project['id']);
				}
			}
			
			$this->_helper->json($images);
			
		}
		
		public function infoAction()
		{
			if (!$this->is_ajax) {
				header("Location: /");
			}
			$this->project = $this->project_model->getOne($_POST['id']);
			$this->_helper->json($this->project);
		}
		
		
		
	}
	
?>