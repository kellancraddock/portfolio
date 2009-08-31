<?php
	Class ContributionsModel extends Zend_Db_Table_Abstract
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
		
		function deleteAll($arguments)
		{
			//Connect to database
			$db = $this->getDefaultAdapter();
		
			//Set arguments to select statement
			$delete = "project_id = '{$arguments[0]}'";
		
			//Delete from table
			return $db->delete($this->table, $delete);
		}
	}
?>