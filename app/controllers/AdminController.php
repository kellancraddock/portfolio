<?php
	require_once("../app/models/ProjectModel.php");
	require_once("../app/models/ContributionModel.php");
	require_once("../app/models/ImageModel.php");
	class AdminController extends Zend_Controller_Action
	{
		public function init()
		{
			$this->_helper->layout->setLayout('admin');
		}
		
		public function indexAction()
		{
				
		}
		
		public function projectsAction()
		{
			$project_model = new ProjectModel();
			$this->view->projects = $project_model->getAll();
		}
		
		public function newAction()
		{
			$project_model = new ProjectModel();
			$contributions_model = new ContributionModel();
			$image_model = new ImageModel();
			
			$contributions = explode(", ", $_POST['contributions']);
			$project = array($_POST['title'], $_POST['description']);
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
			$project_model = new ProjectModel();
			$contributions_model = new ContributionModel();
			$image_model = new ImageModel();
			$project_id = $this->_request->getParam('id');
			
			$success = $project_model->deleteOne($project_id);
			
			if ($success) {
				$contributions_model->deleteAll($project_id);
				$image_model->deleteAll($project_id);
			}
			
			header("Location: /admin/projects");
		}
		
		public function editAction()
		{
			$image_model = new ImageModel();
			$project_model = new ProjectModel();
			$project_id = $this->_request->getParam('id');
			
			$this->project = $project_model->getOne($project_id);
			$this->project['images'] = $image_model->getAll($project_id);
			
			$this->view->project = $this->project;
		}
		
		public function updateAction()
		{
			$project_model = new ProjectModel();
			$project_id = array($this->_request->getParam('id'));
			$update = array($_POST['title'], $_POST['description'], $_POST['status']);

			$success = $project_model->updateOne($project_id, $update);
			
			header("Location: /admin/projects");
		}
		
		
	}
?>
