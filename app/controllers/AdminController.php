<?php
	require_once("../app/models/ProjectModel.php");
	require_once("../app/models/ContributionModel.php");
	require_once("../app/models/ImageModel.php");
	class AdminController extends Zend_Controller_Action
	{
		public function init()
		{
			$this->_helper->layout->setLayout('admin');
			$this->admin_session = new Zend_Session_Namespace('admin');
		}
		
		public function indexAction()
		{
			if (isset($this->admin_session->user)) {
				header("Location: /admin/projects");
			}
		}
		
		public function loginAction()
		{
			$user_name = "root";
			$password = "root";
			if ($_POST['user_name'] == $user_name && $_POST['password'] == $password) {
				$this->admin_session->user = $user_name;
				header("Location: /admin/projects");	
			} else {
				header("Location: /");
			}
		}
		
		public function logoutAction()
		{
				
		}
		
		public function projectsAction()
		{
			if (!isset($this->admin_session->user)) {
				header("Location: /");
			}
			$project_model = new ProjectModel();
			$this->view->projects = $project_model->getAll();
		}
		
		public function newAction()
		{
			if (!isset($this->admin_session->user)) {
				header("Location: /");
			}
			$project_model = new ProjectModel();
			$contributions_model = new ContributionModel();
			$image_model = new ImageModel();
			
			$contributions = explode(", ", $_POST['contributions']);
			$project = array($_POST['title'], $_POST['description'], $_POST['url']);
			//Create project
			$project_id = $project_model->addOne($project);
			//Create default image
			$image_model->addDefault($project_id);
			
			if ($project_id && !empty($contributions)) {
				foreach ($contributions as $contribution) {
					$contributions_model->addOne(array($project_id), array($contribution));
				}
			}
			
			header("Location: /admin/projects");

		}
		
		public function deleteAction()
		{
			if (!isset($this->admin_session->user)) {
				header("Location: /");
			}
			$project_model = new ProjectModel();
			$contributions_model = new ContributionModel();
			$image_model = new ImageModel();
			$project_id = $this->_request->getParam('id');
			
			$images = $image_model->getAll($project_id);
			//Delete Project record
			$success = $project_model->deleteOne($project_id);
			
			if ($success) {
				//Delete contribution records
				$contributions_model->deleteAll($project_id);
				//Delete image records
				$image_model->deleteAll($project_id);
				//Delete files
				foreach ($images as $image) {
					unlink(UPLOAD_PATH . $image['file_name']);
				}
			}
			
			header("Location: /admin/projects");
		}
		
		public function editAction()
		{
			if (!isset($this->admin_session->user)) {
				header("Location: /");
			}
			$image_model = new ImageModel();
			$project_model = new ProjectModel();
			$contributions_model = new ContributionModel();
			
			$project_id = $this->_request->getParam('id');
			
			$this->project = $project_model->getOne($project_id);
			$this->project['description'] = stripslashes($this->project['description']);
			$this->project['images'] = $image_model->getAll($project_id);
			$contributions = '';
			foreach ($contributions_model->getOne($project_id) as $contribution) {
				$contributions .= $contribution['contribution'] . ', ';
			}
			
			$this->project['contributions'] = $contributions;
			
			$this->view->project = $this->project;
		}
		
		public function updateAction()
		{
			if (!isset($this->admin_session->user)) {
				header("Location: /");
			}
			$project_model = new ProjectModel();
			$contributions_model = new ContributionModel();
			
			$project_id = array($this->_request->getParam('id'));
			$update = array($_POST['title'], $_POST['description'], $_POST['url'], $_POST['status']);
			$contributions = explode(", ", $_POST['contributions']);
			
			$contributions_model->deleteAll($project_id[0]);
			
			if ($project_id && !empty($contributions)) {
				foreach ($contributions as $contribution) {
					$contributions_model->addOne($project_id, array($contribution));
				}
			}

			$success = $project_model->updateOne($project_id, $update);
			
			header("Location: /admin/projects");
		}
		
		
	}
?>
