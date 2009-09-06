<?php
	Class ContributionModel extends Zend_Db_Table_Abstract
	{
		public $table = "contributions";
	
		function addOne($project_id, $contribution)
		{
			//Connect to database
			$db = $this->getDefaultAdapter();
		
			//Set arguments to Zend insert associative array
			$insertArgs = array(
				'project_id'        => $project_id[0],
				'contribution'  => $contribution[0]
				);
		
			//Insert into table 
			return $db->insert($this->table, $insertArgs);
		}
		
		function getOne($project_id)
		{
			//Connect to database
			$db = $this->getDefaultAdapter();
			
			//Set arguments to select statement
			$select = "SELECT contribution FROM $this->table WHERE project_id = '{$project_id}'";
		
			//Select from table
			return $db->fetchAll($select);

		}
		
		function deleteAll($project_id)
		{
			//Connect to database
			$db = $this->getDefaultAdapter();
		
			//Set arguments to select statement
			$delete = "project_id = '{$project_id}'";
		
			//Delete from table
			return $db->delete($this->table, $delete);
		}
	}
?>