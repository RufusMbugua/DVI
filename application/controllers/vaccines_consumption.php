<?php
ob_start();

class vaccines_consumption extends MY_Controller {
	var $flaged = "";
	public function index() {
		ini_set("max_execution_time", "500000");

		$user_groups = Emails::getState();

	
		foreach ($user_groups as $user_group) {

		$national = $user_group["national"];
			

			//if national is selected
		if ($national == '1') 
		{
 $national;
	
		}
		}
			$this -> get_sms_level();
	}//end of index function

	//determines which type of sms to send then gets numbers
	public function get_sms_level() {

		$smslevel = Emails::getsms_national();

		foreach ($smslevel as $levels) {

			//gets phone number of the record that is to receive consumption sms
				$phones = $levels['number'];
			
				$this -> getBalances($phones);

			

		}

	}//end of function send_sms_level

	//this sends the sms to all recepients regarding the stocked out vaccine *_*

	//gets the 2 necessary variables to pass to consumption function
	public function getBalances($phones)
	 {

		$this -> load -> database();
		$start_date = "";
		$data_buffer = "";
		$number = "";
		@$start_date == date('m/d/y', strtotime('-30 days'));
		@$end_date = date('m/d/y');

		$population = 0;
		
		$closing_balance = 0;
		$sql_consumption = "";

		$vaccines = Vaccines::getAll_Minified();

		//gets consumption as per every vaccine
		foreach ($vaccines as $vaccine) 
		{

			$population = Regional_Populations::getNationalPopulation(date('Y'));
		
			$closing_balance = Disbursements::getNationalPeriodBalance($vaccine -> id, strtotime($end_date));
			$sql_consumption = "select (SELECT max(str_to_date(Date_Issued,'%m/%d/%Y'))  FROM `disbursements` where Owner = 'N0' and str_to_date(Date_Issued,'%m/%d/%Y') between str_to_date('" . $start_date . "','%m/%d/%Y') and str_to_date('" . $end_date . "','%m/%d/%Y') and Vaccine_Id = '" . $vaccine -> id . "' and total_stock_balance>0)as last_stock_count,(SELECT sum(Quantity)FROM `disbursements` where Issued_By_National = '0' and Owner = 'N0' and str_to_date(Date_Issued,'%m/%d/%Y') between str_to_date('" . $start_date . "','%m/%d/%Y') and
                    str_to_date('" . $end_date . "','%m/%d/%Y') and Vaccine_Id = '" . $vaccine -> id . "')as total_issued,(SELECT sum(Quantity) FROM `disbursements` where Issued_To_National = '0' and Owner = 'N0' and str_to_date(Date_Issued,'%m/%d/%Y') between str_to_date('" . $start_date . "','%m/%d/%Y') and
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
$this -> Send_Balanaces($phones, $messsage);
	}

	public function Send_Balanaces($phones, $messsage) {
		
		
		$title = "VACCINES+STOCK+BALANCES+(IN+DOSES+-+MOS+AT+NATIONAL+STORE+-+)++";
		$footer = "+%0A+*+DVI+-+SMT*";
		 $X = urldecode($title.$messsage.$footer.$phones) . '</br>';
		$z = file_get_contents("http://192.168.6.19:13000/cgi-bin/sendsms?username=clinton&password=ch41sms&to=$phones&text=$title.$messsage.$footer");

	
		ob_flush();
		
	}

}
