<?php 
class Vaccine_Shipments extends Doctrine_Record 
{

	public function setTableDefinition()
	 {
		$this -> hasColumn('vaccine_id', 'varchar', 11);
		$this -> hasColumn('task_id', 'int', 30);
		$this -> hasColumn('Initiate_date', 'int', 20);
		$this -> hasColumn('expected_end_date', 'int', 20);
		$this -> hasColumn('end_date', 'int', 20);
		$this -> hasColumn('Initiator_name', 'int', 30);
		$this -> hasColumn('valid', 'int', 11);
					
	}

	public function setUp() 
	{
		$this -> setTableName('shipments');
	}

	
	public static function get_shipment($id) 
	{
		//gets the shipment from the shipment table
		$query = Doctrine_Query::create() -> select("ID,vaccine_id,task_id,Initiate_date,expected_end_date,end_date,Initiator_name") -> from("shipments") -> where("valid = '1'") -> orderBy("ID");
		$ship = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $ship;
	
	}
	
	public static function get_dates($id)
	{
		$query = Doctrine_Query::create() -> select("task_id,Initiate_date,expected_end_date,end_date") -> from("shipments") -> where("valid = '1' and task_id='$id' ") -> orderBy("task_id ASC");
		$records = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $records;
	}
	
	
	public static function get_them_dates($id)
	{
		//gets the dates from the shipments table and displays them on the gantt chart
		$query = Doctrine_Query::create() -> select("Initiate_date,expected_end_date,end_date,ID") -> from("shipments") -> where("vaccine_id = '".$id."'") -> orderBy("ID ASC");		
		$records = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $records;
	}
		
	public static function get_Initial($id)
	{
		$query = Doctrine_Query::create() -> select("MIN( Initiate_date ) as date1 , MAX( end_date ) as date2" )-> from("shipments") -> where("vaccine_id = '".$id."'") -> orderBy("ID DESC");
		$records = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $records;
	}
	
	
	public static function get_task_id($id)
	{
		$query = Doctrine_Query::create() -> select("ID,task_id,vaccine_id") -> from("shipments") -> where("valid = '1'") -> orderBy("task_id desc");
		$records = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $records;
	}
	
	public static function get_min_month_year($id)
	{
		$query = Doctrine_Query::create() -> SELECT ("MONTH(MIN( Initiate_date ) ) as date1,YEAR( MIN( Initiate_date ) ) as date2 , MONTH( MAX( end_date ) ) AS date3, YEAR( MAX( end_date ) ) AS date4" )-> from("shipments")  -> where("vaccine_id = '".$id."'") ;
		$records = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $records;
	}
	
	public static function get_task_name($id)
	{
		//gets the task id from the shipments table
		//the id is used to get the task name form the gantt chart
		$query = Doctrine_Query::create() -> SELECT ("task_id,ID" )-> from("shipments")  -> where("vaccine_id = '".$id."'") ->orderby("ID");
		$records = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $records;
	}

	public static function get_range($id)
	{
		
		$query = Doctrine_Query::create() -> SELECT ("MONTH( MIN(Initiate_date ) ) as date1, MONTH(MAX( end_date ) ) AS date3," )-> from("shipments")  -> where("vaccine_id = '".$id."'") ->orderby("ID");
		$records = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $records;
	}
	public static function get_vaccine_data($id)
	{
		$query = Doctrine_Query::create() -> SELECT ("Initiate_date,expected_end_date,end_date,ID" )-> from("shipments")  -> where("vaccine_id = '".$id."'") ->orderby("ID");
		$records = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $records;
	}
	
}

?>