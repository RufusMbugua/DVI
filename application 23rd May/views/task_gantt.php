 <script language="JavaScript" src=<?php echo base_url()."FusionWidgets/FusionCharts.js"?> </script> 
  <script type="text/javascript">
	
   </script>

 <?php include_once 'FusionWidgets/FusionCharts.php';?>

<?php $email = Shipments::get_task_id();



		$string= '';

		$string.= "<chart manageResize='2'dateFormat='dd/mm/yyyy' outputDateFormat='ddds mns yy' ganttWidthPercent='65' canvasBorderColor='999999' canvasBorderThickness='0' gridBorderColor='4567aa' gridBorderAlpha='20' ganttPaneDuration='3' ganttPaneDurationUnit='m' >
<categories  bgColor='009999'>";

		$start = Shipments::get_Initial();
		foreach ($start as $starts) {
			$strt = $starts['date1'];  
			 $start1= date('d/m/Y', strtotime($strt));
			$startz = $starts['date2'];
			 $start2= date('d/m/Y', strtotime($startz));
			$string.= "<category start='" . $start1 . "' end='" . $start2 . "'  label='Shipment of Vaccine Received'  fontColor='ffffff' fontSize='16' />
</categories>";

			$string.= "
<categories  bgColor='4567aa' fontColor='ff0000'>

<category start='$start1' end='$start2' label='Months'  alpha='' font='Verdana' fontColor='ffffff' fontSize='16' />
</categories>";
		}

		$string.= "<categories  bgColor='ffffff' fontColor='1288dd' fontSize='10' isBold='1' align='center'>";

		//first and last dates
		$start = Shipments::get_min_month_year();
		foreach ($start as $starts) {
			$minmonth = $starts['date1'];
			$minyear = $starts['date2'];
			$maxmonth = $starts['date3'];
			$maxyear = $starts['date4'];

		}

		for ($i = $minyear; $i <= $maxyear; $i++) {
			for ($j = $minmonth; $j <= $maxmonth; $j++) {
				//forming the date
			 $start = $i . '/' . '0' . $j . '/' . '1';
				 $startz =$start ;
				//getting last day of the month
				 $today = date("Y-m-d", strtotime("+1month -1 second", strtotime(date("Y-m-1", strtotime($start)))));
				 $end = date('d/m/Y', strtotime($today));;

				//populating names of the month;
				$monthname = date("F", mktime(0, 0, 0, $j, 1, 2000));
 
				
		  $start2= date('d/m/Y', strtotime( $startz));
				
				$string.= "<category start='$start2' end='$end' label='$monthname'/>

";

			}
		}

		$string.= "</categories>";

		$string.= "<processes headerText='Task' fontColor='000000' fontSize='11' isAnimated='1' bgColor='4567aa'  headerVAlign='bottom' headerAlign='left' headerbgColor='4567aa' headerFontColor='ffffff' headerFontSize='12'  align='left' isBold='1' bgAlpha='25'>";
		$task_id = Shipments::get_task_name();
		foreach ($task_id as $task_ids) {
			$id = $task_ids['task_id'];
			$id2 = $task_ids['id'];
			$task = tasks::get_task_name($id);
			foreach ($task as $tasks) {
				$name = $tasks['name'];

				$string.= "<process label='$name' id='$id2'/>";

			}

		}
		$string.= "</process>";

		$string.= "<dataTable showProcessName='1' nameAlign='left' fontColor='000000' fontSize='10' vAlign='right' align='center' headerVAlign='bottom' headerAlign='left' headerbgColor='4567aa' headerFontColor='ffffff' headerFontSize='12' > <dataColumn bgColor='eeeeee' headerText='Expected' >";
		$all_dates = Shipments::get_them_dates();

		foreach ($all_dates as $dates) {
			$initialx = $dates['Initiate_date'];
		 $initial=date('d/m/Y', strtotime($initialx));;
			$string.= "<text label='$initial'/>";

		}
		$string.= "</dataColumn>";

		$string.= "<dataColumn bgColor='eeeeee' headerText='Start'>";

		$all_dates = Shipments::get_them_dates();

		foreach ($all_dates as $dates) {
			$initialx = $dates['receive_date'];
 $initial=date('d/m/Y', strtotime($initialx));;
			$string.= "<text label='$initial'/>";

		}

		$string.= "</dataColumn>";

		$string.= "<dataColumn bgColor='eeeeee' headerText='Finish'>";
		$all_dates = Shipments::get_them_dates();

		foreach ($all_dates as $dates) {
			
			$initialx = $dates['end_date'];
			 $initial=date('d/m/Y', strtotime($initialx));;

			$string.= "<text label='$initial'/>";

		}

		$string.= "</dataColumn>";
		$string.= "</dataTable>";

		

		$range = Shipments::get_range();
		foreach ($range as $ranges) {
			 $minmonth = $ranges['date1'];
			$max = $ranges['date3'];
		}

		$task_id = Shipments::get_them_dates();
		//$count = 0;
        $string.="<tasks>";
		///for ($i = $minmonth; $i <= $max; $i++)
		foreach  ($task_id as $task_id)
		 {
			//@$id = $task_id[$count]['id'];
			@$id = $task_id['id'];
			@$initialx = $task_id['Initiate_date'];
	 	    @$initial2=date('d/m/Y', strtotime($initialx));;
			@$startx = $task_id['receive_date'];
			@$start=date('d/m/Y', strtotime($startx));;
			@$endx = $task_id['end_date'];
			@$end=date('d/m/Y', strtotime($endx));;
			$string.= "<task label='Planned' processId='$id' start='$initial2' end='$end' id='$id-1' color='4567aa' height='32%' topPadding='12%'/>";
			$string.= "<task label='Actual' processId='$id' start='$start' end='$end' id='$id' color='EEEEEE' alpha='100'  topPadding='56%' height='32%' />";
	
			
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
	

 echo renderChart("".base_url()."FusionWidgets/Charts/Gantt.swf","", rawurlencode($string),"myChartId", 700, 450, false, false);
 ?>
 
      <script language="JavaScript" src=<?php echo base_url()."FusionWidgets/FusionCharts.js"?> </script> 
  <script type="text/javascript">
	
   </script>

 

<?php $email = Shipments::get_task_id();



		$string= '';

		$string.= "<chart manageResize='2'dateFormat='dd/mm/yyyy' outputDateFormat='ddds mns yy' ganttWidthPercent='65' canvasBorderColor='999999' canvasBorderThickness='0' gridBorderColor='4567aa' gridBorderAlpha='20' ganttPaneDuration='3' ganttPaneDurationUnit='m' >
<categories  bgColor='009999'>";

		$start = Shipments::get_Initial();
		foreach ($start as $starts) {
			$strt = $starts['date1'];  
			 $start1= date('d/m/Y', strtotime($strt));
			$startz = $starts['date2'];
			 $start2= date('d/m/Y', strtotime($startz));
			$string.= "<category start='" . $start1 . "' end='" . $start2 . "'  label='Shipment of Vaccine Received'  fontColor='ffffff' fontSize='16' />
</categories>";

			$string.= "
<categories  bgColor='4567aa' fontColor='ff0000'>

<category start='$start1' end='$start2' label='Months'  alpha='' font='Verdana' fontColor='ffffff' fontSize='16' />
</categories>";
		}

		$string.= "<categories  bgColor='ffffff' fontColor='1288dd' fontSize='10' isBold='1' align='center'>";

		//first and last dates
		$start = Shipments::get_min_month_year();
		foreach ($start as $starts) {
			$minmonth = $starts['date1'];
			$minyear = $starts['date2'];
			$maxmonth = $starts['date3'];
			$maxyear = $starts['date4'];

		}

		for ($i = $minyear; $i <= $maxyear; $i++) {
			for ($j = $minmonth; $j <= $maxmonth; $j++) {
				//forming the date
			 $start = $i . '/' . '0' . $j . '/' . '1';
				 $startz =$start ;
				//getting last day of the month
				 $today = date("Y-m-d", strtotime("+1month -1 second", strtotime(date("Y-m-1", strtotime($start)))));
				 $end = date('d/m/Y', strtotime($today));;

				//populating names of the month;
				$monthname = date("F", mktime(0, 0, 0, $j, 1, 2000));
 
				
		  $start2= date('d/m/Y', strtotime( $startz));
				
				$string.= "<category start='$start2' end='$end' label='$monthname'/>

";

			}
		}

		$string.= "</categories>";

		$string.= "<processes headerText='Task' fontColor='000000' fontSize='11' isAnimated='1' bgColor='4567aa'  headerVAlign='bottom' headerAlign='left' headerbgColor='4567aa' headerFontColor='ffffff' headerFontSize='12'  align='left' isBold='1' bgAlpha='25'>";
		$task_id = Shipments::get_task_name();
		foreach ($task_id as $task_ids) {
			$id = $task_ids['task_id'];
			$id2 = $task_ids['id'];
			$task = tasks::get_task_name($id);
			foreach ($task as $tasks) {
				$name = $tasks['name'];

				$string.= "<process label='$name' id='$id2'/>";

			}

		}
		$string.= "</process>";

		$string.= "<dataTable showProcessName='1' nameAlign='left' fontColor='000000' fontSize='10' vAlign='right' align='center' headerVAlign='bottom' headerAlign='left' headerbgColor='4567aa' headerFontColor='ffffff' headerFontSize='12' > <dataColumn bgColor='eeeeee' headerText='Expected' >";
		$all_dates = Shipments::get_them_dates();

		foreach ($all_dates as $dates) {
			$initialx = $dates['Initiate_date'];
		 $initial=date('d/m/Y', strtotime($initialx));;
			$string.= "<text label='$initial'/>";

		}
		$string.= "</dataColumn>";

		$string.= "<dataColumn bgColor='eeeeee' headerText='Start'>";

		$all_dates = Shipments::get_them_dates();

		foreach ($all_dates as $dates) {
			$initialx = $dates['receive_date'];
 $initial=date('d/m/Y', strtotime($initialx));;
			$string.= "<text label='$initial'/>";

		}

		$string.= "</dataColumn>";

		$string.= "<dataColumn bgColor='eeeeee' headerText='Finish'>";
		$all_dates = Shipments::get_them_dates();

		foreach ($all_dates as $dates) {
			
			$initialx = $dates['end_date'];
			 $initial=date('d/m/Y', strtotime($initialx));;

			$string.= "<text label='$initial'/>";

		}

		$string.= "</dataColumn>";
		$string.= "</dataTable>";

		

		$range = Shipments::get_range();
		foreach ($range as $ranges) {
			 $minmonth = $ranges['date1'];
			$max = $ranges['date3'];
		}

		$task_id = Shipments::get_them_dates();
		//$count = 0;
        $string.="<tasks>";
		///for ($i = $minmonth; $i <= $max; $i++)
		foreach  ($task_id as $task_id)
		 {
			//@$id = $task_id[$count]['id'];
			@$id = $task_id['id'];
			@$initialx = $task_id['Initiate_date'];
	 	    @$initial2=date('d/m/Y', strtotime($initialx));;
			@$startx = $task_id['receive_date'];
			@$start=date('d/m/Y', strtotime($startx));;
			@$endx = $task_id['end_date'];
			@$end=date('d/m/Y', strtotime($endx));;
			$string.= "<task label='Planned' processId='$id' start='$initial2' end='$end' id='$id-1' color='4567aa' height='32%' topPadding='12%'/>";
			$string.= "<task label='Actual' processId='$id' start='$start' end='$end' id='$id' color='EEEEEE' alpha='100'  topPadding='56%' height='32%' />";
	
			
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
	

