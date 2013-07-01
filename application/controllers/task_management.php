<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class task_Management extends MY_Controller 
{
	function __construct() 
	{
		parent::__construct();
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> library('pagination');
 	}

	public function index() 
	{
		$this -> view_gantt_interface();
		
		
	}

	public function add_new() 
	{
		$data['title'] = "Add New task";
		$data['module_view'] = "add_task_view";
		$this -> base_params2($data);
	}
	
	public function save()
	{
		$ship = Shipments::get_shipment();
		$ship = new Shipments();
		
		//picks values eneterd in the add_task_view
		//picks the vaccines_id and the task_id and populates the task and vaccine name drop down
		$ship -> vaccine_id = $this -> input -> post("combo2");
		$ship -> task_id = $this -> input -> post("combo1");
		
		//formatting the dates from the date picker
		//Initiate Date
		$test_initiate_date = strtotime($this -> input -> post("start_date"));
		$ship -> Initiate_date = date('Y-m-d',$test_initiate_date);
		//Receive Date
		$test_start_date = strtotime($this -> input -> post("start_date"));
		$test_start_date = strtotime("+7 day", $test_start_date);
		$ship -> expected_end_date = date('Y-m-d',$test_start_date);
		//End Date
		$test_end_date=strtotime($this -> input -> post("end_date"));
		$ship -> end_date = date('Y-m-d',$test_end_date);
		//Initiator Name
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
		
	}

	public function view_gantt_interface() 
	{	

        $data['title'] = "Task Management";			
		$data['quick_link'] = "all_tasks";
		$this -> base_params($data);
		
	}
	
	private function base_params($data) 
	{
		$data['link'] = "task_management";
		$data['content_view'] = "gant_menu_view";
		$data['report'] = "task_gantt";
		$data['scripts'] = array("jquery-ui.js", "tab.js", "FusionWidgets/FusionCharts.js");
		$data['styles'] = array("jquery-ui.css", "tab.css");
		$this -> load -> view('template', $data);
		
	}
	
	
	public function gantt_chart()
	{
		$string= "<chart manageResize='1'dateFormat='dd/mm/yyyy' outputDateFormat='ddds mns yy' ganttWidthPercent='40' canvasBorderColor='999999' canvasBorderThickness='0' gridBorderColor='4567aa' gridBorderAlpha='20' ganttPaneDuration='3' ganttPaneDurationUnit='m' ><categories  bgColor='009999'>";
				
		//gets the Initial date and end date from the table Shipments
		//stores them in the form of an array in the start variable
		//used to make the chart's date timeline
		$start = Shipments::get_Initial();
		//foreach statement cycles through the array $start
		foreach ($start as $starts)
		{
			//all the initial dates are stored in the array $strt
			$strt = $starts['date1'];  
			//formats the initial dates in a proper format
			$start1 = date('d/m/Y', strtotime($strt));
			//stores the end date in a second variable and formats them accordingly
			$startz = $starts['date2'];
			$start2 = date('d/m/Y', strtotime($startz));
			
			$string.= "<category start='" . $start1 . "' end='" . $start2 . "'  label='Shipment of Vaccine Received'  fontColor='ffffff' fontSize='16' />
			
			</categories>";
			$string.= "<categories  bgColor='4567aa' fontColor='ff0000'><category start='$start1' end='$start2' label='Months'  alpha='' font='Verdana' fontColor='ffffff' fontSize='16' /></categories>";
			
		}
		$string.= "<categories  bgColor='ffffff' fontColor='1288dd' fontSize='10' isBold='1' align='center'>";
	
		//gets the first and last year and month in the shipments table
		//stores them in the start var.
		$start = Shipments::get_min_month_year();
		foreach ($start as $starts) 
		{
			$minmonth = $starts['date1'];
			$minyear = $starts['date2'];
			$maxmonth = $starts['date3'];
			$maxyear = $starts['date4'];
			
		}
	
		for ($i = $minyear; $i <= $maxyear; $i++) 
		{
			for ($j = $minmonth; $j <= $maxmonth; $j++) 
			{
				//forming the date
				$start = $i . '/' . '0' . $j . '/' . '1';
				$startz =$start ;
				
				//getting last day of the month
				$today = date("Y-m-d", strtotime("+1month -1 second", strtotime(date("Y-m-1", strtotime($start)))));
				$end = date('d/m/Y', strtotime($today));
				
				//populating names of the month;
				$monthname = date("F", mktime(0, 0, 0, $j, 1, 2000));
				$start2= date('d/m/Y', strtotime( $startz));
				
				$string.= "<category start='$start2' end='$end' label='$monthname'/>";
				
			}
		}
		
		$string.= "</categories>";
		$string.= "<processes headerText='Task' fontColor='000000' fontSize='11' isAnimated='1' bgColor='4567aa'  headerVAlign='bottom' headerAlign='left' headerbgColor='4567aa' headerFontColor='ffffff' headerFontSize='12'  align='left' isBold='1' bgAlpha='25'>";
		$task_id = Shipments::get_task_name();
	
		foreach ($task_id as $task_ids) 
		{
			$id = $task_ids['task_id'];
			$id2 = $task_ids['id'];
			$id3 = $task_ids['vaccine_id'];
			$task = tasks::get_task_name($id);
			$vacc_name = Vaccines::get_Name($id3);
			$vacc = $vacc_name["Name"];
			
			foreach ($task as $tasks) 
			{
				$name = $tasks['name'];
				$part = $name." for ".$vacc;
				$string.= "<process label='$part' id='$id2'/>";
				
			}
		
		}
	
		$string.= "</process>";
		$string.= "<dataTable showProcessName='1' nameAlign='left' fontColor='000000' fontSize='10' vAlign='right' align='center' headerVAlign='bottom' headerAlign='left' headerbgColor='4567aa' headerFontColor='ffffff' headerFontSize='12' >";
		//<dataColumn bgColor='eeeeee' headerText='Collins' >";
		
		$all_dates = Shipments::get_them_dates();
	
		$string.= "<dataColumn bgColor='eeeeee' headerText='Start'>";
		$all_dates = Shipments::get_them_dates();
		
		foreach ($all_dates as $dates) 
		{
			$initialx = $dates['expected_end_date'];
			$initial=date('d/m/Y', strtotime($initialx));
			$string.= "<text label='$initial'/>";
			
		}
	
		$string.= "</dataColumn>";
		$string.= "<dataColumn bgColor='eeeeee' headerText='Finish'>";
		
		$all_dates = Shipments::get_them_dates();
		
		foreach ($all_dates as $dates) 
		{
			$initialx = $dates['end_date'];
			$initial=date('d/m/Y', strtotime($initialx));
			$string.= "<text label='$initial'/>";
			
		}
	
		$string.= "</dataColumn>";
		$string.= "</dataTable>";
		
		$range = Shipments::get_range();
		foreach ($range as $ranges) 
		{
			$minmonth = $ranges['date1'];
			$max = $ranges['date3'];
			
		}
	
		$task_id = Shipments::get_them_dates();
		$string.="<tasks>";
		
		foreach  ($task_id as $task_id)
		{
			//stores the id of the task 
			@$id = $task_id['id'];
			//stores the date the task was initiated by a user
			@$initialx = $task_id['Initiate_date'];
		 	@$initial2 = date('d/m/Y', strtotime($initialx));
			
			//stores the expected end date for a particular task
			//default duration is currently 7 days
			@$endx = $task_id['expected_end_date'];
			@$end = date('d/m/Y', strtotime($endx));
			
			//stores the actual end date of a task
			@$actual = $task_id['end_date'];
			@$actual_end = date('d/m/y', strtotime($actual));
			
			//if function to change the color of the bar
			
			if($actual_end <= $end)
			{
				$color_bar = 'EEEEEE';
				$text_bar = 'Actual: On Schedule';
			}
			else {
				$color_bar = 'ED0909';
				$text_bar = 'Actual: Overdue';
			}
			
			$string.= "<task label='Planned' processId='$id' start='$initial2' end='$end' id='$id-1' color='4567aa' height='22%' topPadding='12%'/>";
			$string.= "<task label='".$text_bar."' processId='$id' start='$initial2' end='$actual_end' id='$id' color='".$color_bar."' alpha='100'  topPadding='40%' height='22%' />";
		
		}
		
		$string.="</tasks>";
		$string.="	
			<legend>
			        <item label='Planned' color='4567aa' />
			        <item label='Actual' color='999999' />
			        
			</legend>
			";
			
			$string.="	
				<styles>
				        <definition>
				                <style type='Font' name='legendFont' size='12' />
				        </definition>
				        <application>
				                <apply toObject='LEGEND' styles='legendFont' />
				        </application>
				</styles>";
		
		$string.="</chart>";
		echo $string;
	}

	function gantt_vaccine($gantt_data)
	{
		$string.= "<chart manageResize='1'dateFormat='dd/mm/yyyy' outputDateFormat='ddds mns yy' ganttWidthPercent='40' canvasBorderColor='999999' canvasBorderThickness='0' gridBorderColor='4567aa' gridBorderAlpha='20' ganttPaneDuration='3' ganttPaneDurationUnit='m' ><categories  bgColor='009999'>";
				
		//gets the Initial date and end date from the table Shipments
		//stores them in the form of an array in the start variable
		//used to make the chart's date timeline
		$start = Vaccine_Shipments::get_Initial($gantt_data);
		//foreach statement cycles through the array $start
		foreach ($start as $starts)
		{
			//all the initial dates are stored in the array $strt
			$strt = $starts['date1'];  
			//formats the initial dates in a proper format
			$start1 = date('d/m/Y', strtotime($strt));
			//stores the end date in a second variable and formats them accordingly
			$startz = $starts['date2'];
			$start2 = date('d/m/Y', strtotime($startz));
			
			$string.= "<category start='" . $start1 . "' end='" . $start2 . "'  label='Shipment of Vaccine Received'  fontColor='ffffff' fontSize='16' />
			
			</categories>";
			$string.= "<categories  bgColor='4567aa' fontColor='ff0000'><category start='$start1' end='$start2' label='Months'  alpha='' font='Verdana' fontColor='ffffff' fontSize='16' /></categories>";
			
		}
		$string.= "<categories  bgColor='ffffff' fontColor='1288dd' fontSize='10' isBold='1' align='center'>";
	
		//gets the first and last year and month in the shipments table
		//stores them in the start var.
		$start = Vaccine_Shipments::get_min_month_year($gantt_data);
		foreach ($start as $starts) 
		{
			$minmonth = $starts['date1'];
			$minyear = $starts['date2'];
			$maxmonth = $starts['date3'];
			$maxyear = $starts['date4'];
			
		}
	
		for ($i = $minyear; $i <= $maxyear; $i++) 
		{
			for ($j = $minmonth; $j <= $maxmonth; $j++) 
			{
				//forming the date
				$start = $i . '/' . '0' . $j . '/' . '1';
				$startz =$start ;
				
				//getting last day of the month
				$today = date("Y-m-d", strtotime("+1month -1 second", strtotime(date("Y-m-1", strtotime($start)))));
				$end = date('d/m/Y', strtotime($today));
				
				//populating names of the month;
				$monthname = date("F", mktime(0, 0, 0, $j, 1, 2000));
				$start2= date('d/m/Y', strtotime( $startz));
				
				$string.= "<category start='$start2' end='$end' label='$monthname'/>";
				
			}
		}
		
		$string.= "</categories>";
		$string.= "<processes headerText='Task' fontColor='000000' fontSize='11' isAnimated='1' bgColor='4567aa'  headerVAlign='bottom' headerAlign='left' headerbgColor='4567aa' headerFontColor='ffffff' headerFontSize='12'  align='left' isBold='1' bgAlpha='25'>";
		
		$task_id = Vaccine_Shipments::get_task_name($gantt_data);
	
		foreach ($task_id as $task_ids) 
		{
			$id = $task_ids['task_id'];
			$id2 = $task_ids['id'];
			$task = tasks::get_task_name($id);
			
			
			foreach ($task as $tasks) 
			{
				$name = $tasks['name'];
				$name_vaccine = $name." for ".$vacc;
				$string.= "<process label='$name' id='$id2'/>";
				
			}
		
		}
	
		$string.= "</process>";
		$string.= "<dataTable showProcessName='1' nameAlign='left' fontColor='000000' fontSize='10' vAlign='right' align='center' headerVAlign='bottom' headerAlign='left' headerbgColor='4567aa' headerFontColor='ffffff' headerFontSize='12' >";
		
		
		$all_dates = Vaccine_Shipments::get_them_dates($gantt_data);
	
		$string.= "<dataColumn bgColor='eeeeee' headerText='Start'>";
		$all_dates = Vaccine_Shipments::get_them_dates($gantt_data);
		
		foreach ($all_dates as $dates) 
		{
			$initialx = $dates['expected_end_date'];
			$initial=date('d/m/Y', strtotime($initialx));
			$string.= "<text label='$initial'/>";
			
		}
	
		$string.= "</dataColumn>";
		$string.= "<dataColumn bgColor='eeeeee' headerText='Finish'>";
		
		$all_dates = Vaccine_Shipments::get_them_dates($gantt_data);
		
		foreach ($all_dates as $dates) 
		{
			$initialx = $dates['end_date'];
			$initial=date('d/m/Y', strtotime($initialx));
			$string.= "<text label='$initial'/>";
			
		}
	
		$string.= "</dataColumn>";
		$string.= "</dataTable>";
		
		$range = Vaccine_Shipments::get_range($gantt_data);
		foreach ($range as $ranges) 
		{
			$minmonth = $ranges['date1'];
			$max = $ranges['date3'];
			
		}
	
		$task_id = Vaccine_Shipments::get_them_dates($gantt_data);
		$string.="<tasks>";
		
		foreach  ($task_id as $task_id)
		{
			//stores the id of the task 
			@$id = $task_id['id'];
			//stores the date the task was initiated by a user
			@$initialx = $task_id['Initiate_date'];
		 	@$initial2 = date('d/m/Y', strtotime($initialx));
			
			//stores the expected end date for a particular task
			//default duration is currently 7 days
			@$endx = $task_id['expected_end_date'];
			@$end = date('d/m/Y', strtotime($endx));
			
			//stores the actual end date of a task
			@$actual = $task_id['end_date'];
			@$actual_end = date('d/m/y', strtotime($actual));
			
			//if function to change the color of the bar
			
			if($actual_end <= $end)
			{
				$color_bar = 'EEEEEE';
				$text_bar = 'Actual: On Schedule';
			}
			else {
				$color_bar = 'ED0909';
				$text_bar = 'Actual: Overdue';
			}
			
			$string.= "<task label='Planned' processId='$id' start='$initial2' end='$end' id='$id-1' color='4567aa' height='22%' topPadding='12%'/>";
			$string.= "<task label='".$text_bar."' processId='$id' start='$initial2' end='$actual_end' id='$id' color='".$color_bar."' alpha='100'  topPadding='40%' height='22%' />";
		
		}
		
		$string.="</tasks>";
		$string.="	
			<legend>
			        <item label='Planned' color='4567aa' />
			        <item label='Actual' color='999999' />
			        
			</legend>
			";
			
			$string.="	
				<styles>
				        <definition>
				                <style type='Font' name='legendFont' size='12' />
				        </definition>
				        <application>
				                <apply toObject='LEGEND' styles='legendFont' />
				        </application>
				</styles>";
		
		$string.="</chart>";
		echo $string;
	}

	private function base_params2($data)
	{
		$data['content_view'] = "add_task_view";
		$data['scripts'] = array("jquery-ui.js", "tab.js");
		$data['styles'] = array("jquery-ui.css", "tab.css");
		$this -> load -> view('template', $data);
			
		
	}
	function vaccine($id)
	{
		$data['gantt_data'] = $id;
		$vacc_name = Vaccines::get_Name($id);
		$vacc = $vacc_name["Name"];
		$data['link'] = "task_management";
		$data['content_view'] = "gant_menu_view";
		$data['title'] = "Task Management for ".$vacc;
		$data['report'] = "task_gantt_vaccine";
		$data['scripts'] = array("jquery-ui.js", "tab.js", "FusionWidgets/FusionCharts.js");
		$data['styles'] = array("jquery-ui.css", "tab.css");
		$this -> load -> view('template', $data);
			
	}
	public function view_task($offset = 0)
	{
		//current number of items to display on the page
		$items_per_page = 15;
		//gets the total number of tasks from the shipments table
		$number_of_tasks = Shipments::getTotalNumber();
		$tasks = Shipments::get_tasks($offset, $items_per_page);
		//$task_id = $tasks->task_id;
		
		if ($number_of_tasks > $items_per_page) 
		{
			$config['base_url'] = base_url() . "task_management/view_task/";
			$config['total_rows'] = $number_of_tasks;
			$config['per_page'] = $items_per_page;
			$config['uri_segment'] = 3;
			$config['num_links'] = 5;
			$this -> pagination -> initialize($config);
			$data['pagination'] = $this -> pagination -> create_links();
		}

		$data['tasks'] = $tasks;
		$data['title'] = "Task Management::View All Tasks";
		$data['module_view'] = "edit_task_view";
		$data['scripts'] = array("jquery-ui.js", "tab.js");
		$data['styles'] = array("jquery-ui.css", "tab.css");
		$data['content_view'] = "task_view";
		$data['quick_link'] = "edit_task";
		//$data['link'] = "system_administration";
		$this -> load -> view('template', $data);
		
	}
	
	public function edit_task($id)
	{
		$tasks = Shipments::get_all($id);
		$data['tasks'] = $tasks;
		$data['title'] = "Task Management::Edit Task";
		$data['module_view'] = "add_user_view";
		$data['groups'] = User_Groups::getAllGroups();
		$data['districts'] = Districts::getAllDistricts();
		$data['regions'] = Regions::getAllRegions();
		$this -> base_params($data);
		echo $id;
	}

}
