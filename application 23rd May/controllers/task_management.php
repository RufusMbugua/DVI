<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class task_Management extends MY_Controller 
{
	function __construct() 
	{
		parent::__construct();
		$this -> load -> helper(array('form', 'url'));

	}

	public function index() 
	{
		$this -> view_gantt_interface();
		//$this->static_header();
		
	}

	public function add_new() 
	{
	
		$data['title'] = "Add New task";
		$data['module_view'] = "add_task_view";
		//$this->load->view("add_task_view");
		$this -> base_params2($data);
	}
	
	public function save()
	 {
	 	$ship = Shipments::get_shipment();
		$ship = new Shipments();
		$ship -> vaccine_id = $this -> input -> post("combo2");
		$ship -> task_id = $this -> input -> post("combo1");
		$test_initiate_date=strtotime($this -> input -> post("start_date"));
		$ship -> Initiate_date = date('Y-m-d',$test_initiate_date);
		$test_start_date=strtotime($this -> input -> post("receive_date"));
		$ship -> receive_date = date('Y-m-d',$test_start_date);
		$test_end_date=strtotime($this -> input -> post("end_date"));
		$ship -> end_date = date('Y-m-d',$test_end_date);
		$ship -> Initiator_name = $this -> input -> post("name");
		$ship -> save();
 		$this->index() ;
	}	
		
	public function task_Management()
	
	 {
	 	$data['task'] = Tasks::getThemAll();		
		$data['vaccine'] = Vaccines::getThemAll();	
		$data['content_view'] = "add_task_view";
		$data['title'] = "New task";
		$this -> base_params($data);
		
		//$this->load->view("add_task_view");
	 }

	public function view_gantt_interface() 
	{	

        $data['title'] = "Task Management";			
		$data['quick_link'] = "Task";
		$this -> base_params($data);
		
	//$this->load->view("test_gantt");
	}
	
	private function base_params($data) 
	{
		$data['link'] = "task_management";
		$data['content_view'] = "gant_menu_view";
		$data['report'] = "task_gantt";
		$data['scripts'] = array("jquery-ui.js", "tab.js");
		$data['styles'] = array("jquery-ui.css", "tab.css");
		$this -> load -> view('template', $data);
				
	}

	private function base_params2($data) 
	{
		$data['content_view'] = "add_task_view";
		$data['scripts'] = array("jquery-ui.js", "tab.js");
		$data['styles'] = array("jquery-ui.css", "tab.css");
		$this -> load -> view('template', $data);
				
	}

}
