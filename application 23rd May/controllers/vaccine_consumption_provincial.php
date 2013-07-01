<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class vaccine_consumption_provincial extends MY_Controller {
	//[level-calculate-number-send]
	public function index() {
		ini_set("max_execution_time", "500000");

		$user_groups = Emails::getStateprovincial();
		
	
		foreach ($user_groups as $user_group) {

			$provincial = $user_group["provincial"];
		 $district_or_region = $provincial;
			//if provincial is selected
			if ($district_or_region > 0) 
			{
				
				$region = Regions::getRegionName($district_or_region);
			 $region_name = urlencode($region);
				$today = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
				$from = $today;


				$this -> getBalances($region_name, $from, $district_or_region);
			}
		}
	
			}//end of index function
			
			//gets the 2 necessary variables to pass to consumption function
	public function getBalances($region_name, $from, $district_or_region) {



		$this -> load -> database();
		$start_date = "";
		$data_buffer = "";
		$end_date="";
		@$start_date == date('m/d/y', strtotime('-30 days'));
		@$end_date = date('m/d/y');

		$population = 0;
		
		$closing_balance = 0;
		$sql_consumption = "";

		$vaccines = Vaccines::getAll_Minified();

		//gets consumption as per every vaccine
		foreach ($vaccines as $vaccine) {
			
			$population = Regional_Populations::getRegionalPopulation($district_or_region, date('Y'));
			
			$closing_balance = Disbursements::getRegionalPeriodBalance($district_or_region, $vaccine -> id, strtotime($end_date));
			$owner = "R" . $district_or_region;
			$sql_consumption = "select (SELECT date_format(max(str_to_date(Date_Issued,'%m/%d/%Y')),'%d-%b-%Y')  FROM `disbursements` where Owner = '" . $owner . "' and str_to_date(Date_Issued,'%m/%d/%Y') between str_to_date('" . $start_date . "','%m/%d/%Y') and str_to_date('" . $end_date . "','%m/%d/%Y') and Vaccine_Id = '" . $vaccine -> id . "' and total_stock_balance>0)as last_stock_count,(SELECT sum(Quantity)FROM `disbursements` where Issued_By_Region = '" . $district_or_region . "' and Owner = '" . $owner . "' and str_to_date(Date_Issued,'%m/%d/%Y') between str_to_date('" . $start_date . "','%m/%d/%Y') and
str_to_date('" . $end_date . "','%m/%d/%Y') and Vaccine_Id = '" . $vaccine -> id . "')as total_issued,(SELECT sum(Quantity) FROM `disbursements` where Issued_To_Region = '" . $district_or_region . "' and Owner = '" . $owner . "' and str_to_date(Date_Issued,'%m/%d/%Y') between str_to_date('" . $start_date . "','%m/%d/%Y') and
str_to_date('" . $end_date . "','%m/%d/%Y') and Vaccine_Id = '" . $vaccine -> id . "')as total_received";

			$query = $this -> db -> query($sql_consumption);
			$vaccine_data = $query -> row();

			$monthly_requirement = ceil(($vaccine -> Doses_Required * $population * $vaccine -> Wastage_Factor) / 12);
			$space1 = urldecode("++++");
			$space2 = urldecode("++");
			$newline = urldecode("%0A");
			$brace=urldecode('(');
				$brace2=urldecode(')');
 $messsage = urlencode($data_buffer .= $newline . $vaccine -> Name . $space2 . number_format($closing_balance + 0) . $space1 .$brace. number_format(($closing_balance / $monthly_requirement), 1).'MOS'.$brace2);

			
			
			
		}
	
$this -> get_phone_number($messsage,$region_name,$district_or_region);
		}
	
		


	//determines which type of sms to send then gets numbers
	public function get_phone_number($messsage,$region_name,$district_or_region){


		$numer = Emails::getphone_provincial($district_or_region);

		foreach($numer as $numers) 
	{			
				//gets phone number of the record
	$phones=$numers['number'];
	
			$this -> Send_Balanaces($phones,$messsage,$region_name);
			
		//}//end of foreach $smslevel

	}//end of function send_sms_level

	}

	public function Send_Balanaces($phones,$messsage,$region_name) 
	{
		$title = "VACCINES+STOCK+BALANCES+(IN+DOSES+-+MOS+AT+$region_name)++";
		$footer = "+%0A+*+DVI+-+SMT*";
	//	echo $e = urldecode($title.$messsage.$footer.$phones).'</br>';
		$z = file_get_contents("http://192.168.6.19:13000/cgi-bin/sendsms?username=clinton&password=ch41sms&to=$phones&text=$title.$messsage.$footer");
		
		
	}

}
