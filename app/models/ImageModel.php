<?php
	Class ImageModel extends Zend_Db_Table_Abstract
	{
		public $table = "images";
		
		function addOne($project_id, $new_name, $key)
		{
			//Connect to database
			$db = $this->getDefaultAdapter();
		
			//Set arguments to Zend insert associative array
			$insertArgs = array(
				'project_id'	=> $project_id,
				'file_name'     => $new_name,
				'type'         	=> $key,
				);
		
			//Insert into table
			return $db->insert($this->table, $insertArgs);
		}
		
		function addDefault($project_id)
		{
			//Connect to database
			$db = $this->getDefaultAdapter();
		
			//Set arguments to Zend insert associative array
			$insertArgs = array(
				'project_id'	=> $project_id,
				'type'         	=> 'image1',
				);
		
			//Insert into table
			return $db->insert($this->table, $insertArgs);
		}
		
		function getAll($project_id)
		{
			//Connect to database
			$db = $this->getDefaultAdapter();
			
			//Set arguments to select statement
			$select = "SELECT file_name, type, id FROM $this->table WHERE project_id = '{$project_id}'";
		
			//Select from table
			$images_array = $db->fetchAll($select);
			
			//Build array
			$return_array = array();
			foreach ($images_array as $images) {
				$return_array[$images['type']] = array('file_name' => $images['file_name'], 'id' => $images['id'], 'type' => $images['type']);
			}
			return $return_array;
		}
		
		function getThumb($project_id)
		{
			//Connect to database
			$db = $this->getDefaultAdapter();
			
			//Set arguments to select statement
			$select = "SELECT file_name, project_id FROM $this->table WHERE type = 'image1' AND project_id = '{$project_id}'";
		
			//Select from table
			return $db->fetchRow($select);
		}
		
		function deleteOne($image_id, $project_id)
		{
			//Connect to database
			$db = $this->getDefaultAdapter();
		
			//Set arguments to select statement
			$where = "id = '{$image_id}' AND project_id = '{$project_id}'";
		
			//Delete from table
			return $db->delete($this->table, $where);
		}
		
		function deleteAll($project_id)
		{
			//Connect to database
			$db = $this->getDefaultAdapter();
		
			//Set arguments to select statement
			$where = "project_id = '{$project_id}'";
		
			//Delete from table
			return $db->delete($this->table, $where);
		}
	}
?>