<?php
	require_once('../app/models/ImageModel.php');
	require_once('../app/models/ProjectModel.php');
	class ImageController extends Zend_Controller_Action
	{
		public function init()
		{
			$this->user_session = new Zend_Session_Namespace('user');
			$this->image_model = new ImageModel();
			$this->project_model = new ProjectModel();
		}
		
		public function uploadAction()
		{
			$project_id = $this->_request->getParam('id');
			 
            $adapter = new Zend_File_Transfer_Adapter_Http();

            foreach($adapter->getFileInfo() as $key => $file) {
            	//Get extension
	            $path = split("[/\\.]", $file['name']);
				$ext = end($path);

				try {
					$adapter->addValidator('Extension', false, array('extension' => 'jpg,gif,png', 'case' => true));
					//Should probably use the array method below to enable overwriting
					$new_name = md5(rand()) .'-' . $project_id . '.' . $ext;

					//Add rename filter
					$adapter->addFilter('Rename', UPLOAD_PATH . $new_name);
				} catch(Zend_File_Transfer_Exception $e) {
					die($e->getMessage());
				}
				
	            try {
	            	//Store
	            	if ($adapter->receive($file['name'])) {
			        	$this->image_model->addOne($project_id, $new_name, $key);
			        }
	            } catch (Zend_File_Transfer_Exception $e) {
	            	die($e->getMessage());
	            }
            }
            header("Location: /admin/edit/id/{$project_id}");
		}
		
		public function deleteAction()
		{
			$image_id = $this->_request->getParam('id');
			$project_id = $this->_request->getParam('project');
			
			$file_name = $this->image_model->getOne($image_id);
			//Delete record
			$this->image_model->deleteOne($image_id, $project_id);
			//Delete file
			unlink(UPLOAD_PATH . $file_name);
			
			header("Location: /admin/edit/id/{$project_id}");
			
		}
		
	}
	
?>