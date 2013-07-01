<script type="text/javascript">
	$(document).ready(function() {
		$("#start_date").datepicker();
		$("#end_date").datepicker();
		$("#receive_date").datepicker();
		$("#add_details").validationEngine();

	});

</script>
<?php
if (isset($tasks)) 
{
	//get the task name to display in the table
	$task_id = $tasks->task_id;
	$task_name = Tasks::get_task_name($task_id);
	$name = $task_name[0]["name"];
	
	//get the vaccine name
	$vacc_id = $tasks->vaccine_id;
	$vacc_name = Vaccines::get_Name($vacc_id);
	$vaccine = $vacc_name["Name"];
	//get the Initiator name
	$initiator = $tasks->Initiator_name;
	
	//get the dates from the database
	$actual_end = $tasks->end_date;
	$expected_end = $tasks->expected_end_date;
	$start_date = $tasks->Initiate_date;
	
} 
else 
{
	$name = "";
	$vaccine = "";
	$actual_end = "";
	$expected_end = "";
	$start_date = "";
	$initiator ="";

}

	
		
	$attributes = array('enctype' => 'multipart/form-data', 'id' => 'add_details');
	echo form_open('task_management/save', $attributes);
	echo validation_errors('<p class="error">', '</p>');

?>

<table border="0" class="data-table">
	<tr>
		<th class="subsection-title" colspan="2">Input Parameters</th>
	</tr>
	<tbody>
		<tr>
			<td><span class="mandatory">*</span>Task name</td>
			<td>
				<select id="combo1" name="combo1">
					<option value="chose">Choose One</option>
						<?php
							$task = Tasks::getThemAll();
							foreach ($task as $tasks)
							{
								echo '<option  value="'. $tasks['id'].'">'. $tasks['name'].'</option>';
								
							}		
						?>
				</select>
			</td>
		</tr>
		<tr>
			<td><span class="mandatory">*</span>Vaccine</td>
			<td>
				<select id="combo2" name="combo2">
					<option value="chose">Choose One</option>
						<?php
							$vaccine= Vaccines::getThemAll();
							foreach ($vaccine as $vaccines)
							{
								echo '<option  value="'. $vaccines['id'].'">'. $vaccines['Name'].'</option>';
							
						 	}		
						?>
					
				</select>
			</td>
		</tr>
		<tr>
			<td><span class="mandatory">*</span>Initiator name</td>
			<td>
			<input type="text" name="name" id="name" class="validate[required]" />
			</td>
		</tr>
		<tr>
			<td><span class="mandatory">*</span>Start Date</td>
			<td>
			<input type="text" name="start_date" id="start_date"   class="validate[required]"/>
			</td>
		</tr>
		<script>
			$(document).ready(function(){
				$("#start_date").change(function(){
					 var date1=new Date($("#start_date").attr('value'));
					// date1=(date1.getMonth()+1) + '/' + date1.getDate() + '/' + date1.getFullYear();
					 date1.setDate(date1.getDate() + 7); 
					 var date2=(date1.getMonth()+1) + '/' + date1.getDate() + '/' + date1.getFullYear();
					 $("#expected_end_date").attr('value',date2);
					 			      
				});
			});
			
		</script>
		 
		<tr>
			<td>Expected End Date</td>
			<td>
			<input type="text" name="expected_end_date" id="expected_end_date"   />
			</td>
		</tr>
	
		<tr>
			<td><span class="mandatory">*</span>Actual End Date</td>
			<td>
			<input type="text" name="end_date" id="end_date"   class="validate[required]" />
			</td>
		</tr>
		<tr>
			<td align="center" colspan=2>
			<input name="submit" type="submit" class="button" value="Save Task">
			<input	name="reset" type="reset" class="button" value="Clear Fields">
			</td>
		</tr>
	</tbody>
</table>
<?php echo form_close();?>
