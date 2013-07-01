<?php 

class Tasks extends Doctrine_Record {

	public function setTableDefinition() {
		$this -> hasColumn('name', 'varchar', 50);
		$this -> hasColumn('valid', 'int', 11);
		
	}

	public function setUp() {
		$this -> setTableName('tasks');
	}

	//assists to dosplay data from db to view
	public static function get_task_name($id)
	 {
		$query = Doctrine_Query::create() -> select("name") -> from("tasks") -> where("valid = '1' and ID='$id' ") -> orderBy("ID asc");
		$task = $query -> execute(array(),DOCTRINE::HYDRATE_ARRAY);
		return $task;
	}
	 
	 public static function getThemAll() {
		$query = Doctrine_Query::create() -> select("name") -> from("tasks") ->  where ("valid = '1'")->orderBy("ID asc");
		$names = $query -> execute(array(),DOCTRINE::HYDRATE_ARRAY);
		return $names;
	}
	 
	 
	 
	 
	 
	 
	 
}


?>