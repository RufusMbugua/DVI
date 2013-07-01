<?php
ob_start();


class auto_sms extends MY_Controller {
	var $flaged = "";

	public function index() {
		//current date timestamp
		ini_set("max_execution_time", "500000");

		//checks the national state of that user in the db
		$user_groups = Emails::getState();

		foreach ($user_groups as $user_group) {
			$national = $user_group["national"];

			//if national is selected

			if ($national == '1') {

				//GET national_id from emails table

				$today = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
				$from = $today;

			}
		}

		$this -> Calculate_Disbursements($from);
	}//end of index function

	//calculates the disbusrments of all vaccines
	public function Calculate_Disbursements($from) {

		$drugs = Vaccines::getThemAll();

		foreach ($drugs as $drug) 
		{
			//gets vaccine ID AND NAME
			$ID = $drug['id'];

			//Calcutaes stockouts
			$stockouts = Disbursements::getNationalPeriodBalance($ID, $from);
			$math = $stockouts;

			$this -> flag_out($math, $ID);
		}
		
		
		

	}//end of function	Calculate_Disbursements

	public function flag_out($math, $ID) {

		$vnames = Vaccines::getVaccineName($ID);

		foreach ($vnames as $vname) 
		{
			$flaged = urlencode($vname['Name']);

			@$message .= "VACCINES+STOCK+OUTS+%0A+$flaged";
			//determines which type of sms to send

		}

		$smslevel = Emails::getSmslevel();

		foreach ($smslevel as $levels) 
		{
			$phones = $levels['number'];
			$this -> send_sms($phones, $message, $math);

		}

	}

	//this sends the sms to all recepients regarding the stocked out vaccine *_*
	public function send_sms($phones, $message, $stockouts) {
		if ($stockouts == 0) {
			// @$message.="+AT+NATIONAL+STORE+%0A+*+DVI+-+SMT*";
			
			
			@$message .= "+AT+%0A+NATIONAL+STORE+%0A+*+DVI+-+SMT*";
			//echo $X = $message . $phones;
			$x= file_get_contents("http://192.168.6.19:13000/cgi-bin/sendsms?username=clinton&password=ch41sms&to=$phones&text=$message");

			ob_flush();
		}

	}

}
