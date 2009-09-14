<?php
	Class ProjectModel extends Zend_Db_Table_Abstract
	{
		private $table = "projects";
		
		function getOne($project_id)
		{
			//Connect to database
			$db = $this->getDefaultAdapter();
			
			//Set arguments to select statement
			$select = "SELECT * FROM $this->table WHERE id = '{$project_id}'";
		
			//Select from table
			return $db->fetchRow($select);
		}
		
		function getAll()
		{
			//Connect to database
			$db = $this->getDefaultAdapter();
			
			//Set arguments to select statement
			$select = "SELECT * FROM $this->table";
		
			//Select from table
			return $db->fetchAssoc($select);
		}
		
		function getActive()
		{
			//Connect to database
			$db = $this->getDefaultAdapter();
			
			//Set arguments to select statement
			$select = "SELECT * FROM $this->table WHERE is_active = '1' ORDER BY id";
		
			//Select from table
			return $db->fetchAssoc($select);
		}
		
		function addOne($arguments)
		{
			//Connect to database
			$db = $this->getDefaultAdapter();
		
			//Set arguments to Zend insert associative array
			$insertArgs = array(
				'title'        => $arguments[0],
				'description'  => $arguments[1]
				);
		
			//Insert into table 
			if ($db->insert($this->table, $insertArgs)) {
				return $db->lastInsertId();
			} else {
				return false;
			}
		}
		
		function updateOne($project_id, $update)
		{
			//Connect to database
			$db = $this->getDefaultAdapter();
			
			//Set arguments to Zend insert associative array
			$insertArgs = array(
				'title'        => $update[0],
				'description'  => $update[1],
				'is_active'    => (int) $update[2],
				);
				
			$where[] = "id = '{$project_id[0]}'";
			
			//Update
			return $db->update($this->table, $insertArgs, $where);
		}
		
		function deleteOne($project_id)
		{
			//Connect to database
			$db = $this->getDefaultAdapter();
		
			//Set arguments to select statement
			$delete = "id = '{$project_id}'";
		
			//Delete from table
			return $db->delete($this->table, $delete);
		}
	}
?>