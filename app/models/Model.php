<?php
	Class Model extends Zend_Db_Table_Abstract
	{
		private $table = "";
		
		function getOne($arguments)
		{
			//Connect to database
			$db = $this->getDefaultAdapter();
			
			//Set arguments to select statement
			$select = "SELECT * FROM $this->table WHERE id = '{$arguments[0]}'";
		
			//Select from table
			return $db->fetchAssoc($select);
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
		
		function addOne($arguments)
		{
			//Connect to database
			$db = $this->getDefaultAdapter();
		
			//Set arguments to Zend insert associative array
			$insertArgs = array(
				'first_name'        => $arguments[0],
				'last_name'         => $arguments[1],
				);
		
			//Insert into table
			return $db->insert($this->table, $insertArgs);
		}
		
		function updateOne($arguments)
		{
			//Connect to database
			$db = $this->getDefaultAdapter();
		
			//Set arguments to Zend insert associative array
			$insertArgs = array(
				'first_name'        => $arguments[1],
				'last_name'         => $arguments[2],
				);
				
			$where[] = "id = '{$arguments[0]}'";
			
			//Update
			return $db->update($this->table, $insertArgs, $where);
		}
		
		function deleteOne($arguments)
		{
			//Connect to database
			$db = $this->getDefaultAdapter();
		
			//Set arguments to select statement
			$delete = "id = '{$arguments[0]}'";
		
			//Delete from table
			return $db->delete($this->table, $delete);
		}
	}
?>