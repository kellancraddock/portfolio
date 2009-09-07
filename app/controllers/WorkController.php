<?php
	require_once("../app/models/ImageModel.php");
	require_once("../app/models/ProjectModel.php");
	require_once("../app/models/ContributionModel.php");
	class WorkController extends Zend_Controller_Action
	{
		public function init() {
			//$this->session_alert = new Zend_Session_Namespace('');
			//$this->Model = new Model();
			$this->view->nav_work = 'active';
		}

		public function indexAction()
		{
			header("Location: /work/project");
		}
		
		public function projectAction()
		{
			$image_model = new ImageModel();
			$project_model = new ProjectModel();
			$contribution_model = new ContributionModel();
			
			$active_projects = $project_model->getActive();
			
			//Build thumbs array from active projects
			$thumbs = array();
			foreach ($active_projects as $project) {
				$thumbs[] = $image_model->getPrimary($project['id']);
			}
			
			$this->view->thumbs = $thumbs;
			
			$project_id = $this->_request->getParam('id');
			$view_id = $this->_request->getParam('view');
			
			if (!$project_id) {
				$thumbs = reset($thumbs);
				$project_id = $thumbs['project_id'];
			}
			
			$this->project = $project_model->getOne($project_id);
			$this->project['contributions'] = $contribution_model->getOne($project_id);
			$this->project['images'] = $image_model->getAll($project_id);
			//If the view is set, loop through the images and find the file_name that matches
			if (isset($view_id)) {
				foreach ($this->project['images'] as $image) {
					if ($image['id'] == $view_id) {
						$this->project['view'] = $image['file_name'];
					}
				}
			} else {
			//Else just assume the first file_name
				$this->project['view'] = $this->project['images']['image1']['file_name'];
			}
			
			$this->view->project = $this->project;
		}
		
	}
?>