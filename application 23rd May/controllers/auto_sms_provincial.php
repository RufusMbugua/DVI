<?php
ob_start();

class auto_sms_provincial extends MY_Controller 
{
	public function index() 
	{
		//ini_set("max_execution_time", "500000");
		$user_groups = Emails::getStateprovincial();
		
		foreach ($user_groups as $user_group) 
		{
			$provincial = $user_group["provincial"];
			//this is a variable that stores the part of the array user_group
			
			$district_or_region = $provincial;
			//if provincial is selected
			if ($provincial > 0) 
			{
				//loads the regions model and calls the specified function i.e get regionName
				$region = Regions::getRegionName($district_or_region);
				$region_name = urlencode($region);
				 
				//mktime($hour, $minute, $second, $month, $day, $year, $is_dst)
				//Get Unix timestamp for a date
				$today = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
				$from = $today;

			}
			
			//$provincial is the id of the region
			$this -> get_sms_level($region_name, $from, $district_or_region);

		}

	}//end of index function

	//determines which type of sms to send then gets numbers
	public function get_sms_level($region_name, $from, $district_or_region) 
	{
		//determines which type of sms to send
		$smslevel = Emails::getStateprovincial2();

		foreach ($smslevel as $levels) 
		{
			$one = $levels['stockout'];

			if ($one == 1) 
			{
				$this -> getBalances($from, $district_or_region, $region_name);
	
			}
		
		}//Moved this bracket to include the if statement

	}//end of function get_sms_level

	//gets the 2 necessary variables to pass to consumption function
	public function getBalances($from, $district_or_region, $region_name) #
	{
		$this -> load -> database();
		$start_date = "";
		$number = "";
		@$end_date = date('m/d/y');
		$closing_balance = 0;
		//calls the following function from the vaccines model.
		//the function c=selects data from the vaccines table then stores them in an array
		//the array is stored in the $vaccines variable
		$vaccines = Vaccines::getAll_Minified();

		//gets consumption as per every vaccine
		@$message = "";
		
		foreach ($vaccines as $vaccine) 
		{
			//$district_or_region is the regions id number
			$region_object = Regions::getRegion($district_or_region);
			$name = urlencode($vaccine['Name']);
			$store = urlencode($region_object -> name);
			$closing_balance = Disbursements::getRegionalPeriodBalance($district_or_region, $vaccine -> id, strtotime($end_date));
			$closing_balance_formatted = number_format($closing_balance);

			if ($closing_balance_formatted == 0) 
			{
				//	echo @$message.= "VACCINES+STOCK+OUTS++AT++%0A+*+DVI+-+SMT*";
				$this -> get_phones($name,$district_or_region,$store);

			}

		}

	}

	public function get_phones($name,$district_or_region,$store) 
	{
		$smslevel = Emails::getnumber_provincial($district_or_region);
		foreach ($smslevel as $levels) 
		{
			//gets phone number of the record
			$phones = $levels['number'];
			$this -> Send_Message($phones,$name,$store);

		}
	}
	
	public function Send_Message($phones,$name,$store)
	{
		@$message.= "VACCINES+STOCK+OUTS+%0A+$name+AT+%0A+$store+%0A+*+DVI+-+SMT*";
		$z = file_get_contents("http://192.168.6.19:13000/cgi-bin/sendsms?username=clinton&password=ch41sms&to=$phones&text=$message");
		
	ob_flush();
	}

}
