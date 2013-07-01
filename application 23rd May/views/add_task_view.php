<script type="text/javascript">
	$(document).ready(function() {
		$("#start_date").datepicker();
		$("#end_date").datepicker();
		$("#receive_date").datepicker();
		$("#add_details").validationEngine();

	});

</script>



<?php
if (isset($task,$vaccine)) 
{
 $task;
 $vaccine;
}else
	{
	
	}	
$attributes = array('enctype' => 'multipart/form-data', 'id' => 'add_details');
echo form_open('task_management/save', $attributes);

echo validation_errors('
<p class="error">', '</p>
');

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
				
			</select></td>
	
			
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
				
			</select></td>
	
			
		</tr>
		<tr>
			<td><span class="mandatory">*</span>Initiator name</td>
			<td>
			<input type="text" name="name" id="name" class="validate[required]" />
			</td>
		</tr>
		<tr>
			<td><span class="mandatory">*</span>Initiate Date</td>
			<td>
			<input type="text" name="start_date" id="start_date"   class="validate[required]"/>
			</td>
		</tr>
		
		
		<tr>
			<td><span class="mandatory">*</span>Receive Date</td>
			<td>
			<input type="text" name="receive_date" id="receive_date"  class="validate[required]" />
			</td>
		</tr>
		
		<tr>
			<td><span class="mandatory">*</span>End Date</td>
			<td>
			<input type="text" name="end_date" id="end_date"   class="validate[required]" />
			</td>
		</tr>
		<tr>
			<td align="center" colspan=2>
			<input name="submit" type="submit" class="button" value="Save Recipient">
			<input	name="reset" type="reset" class="button" value="Clear Fields">
			</td>
		</tr>
	</tbody>
</table>
<?php echo form_close();?>
