<div class="quick_menu">
</div>
<?php if (isset($pagination)): ?>
<div style="width:450px; margin:0 auto 60px auto">
<?php echo $pagination; ?>
</div>
<?php endif; ?>
<table border="0" class="data-table">
	<th class="subsection-title" colspan="11">Tasks</th>
	<tr>
		<th>Task Name</th>
		<th>Vaccine Name</th>
		<th>Initiate Date</th>
		<th>Expected End Date</th>
		<th>Actual End Date</th>
		<th>Initiator Name</th>
		<th>Valid</th>
		<th>Action</th>
	</tr>
 <?php 
 foreach($tasks as $task){?>
 <tr>
 	<td>
 		<?php
 			$task_id = $task->task_id;
			$task_name = Tasks::get_task_name($task_id);
			echo ($task_name[0]["name"]) ;
 		?>
 		
 	</td>
 	<td>
 		<?php
 			
 			$vacc_id = $task->vaccine_id;
			$vacc_name = Vaccines::get_Name($vacc_id);
			echo($vacc_name["Name"]) ;
 		?>
 		
 	</td>
 <td>
 <?php echo $task->Initiate_date;?>
 </td> 
   <td>
 <?php echo $task->expected_end_date;?>
 </td>
    <td>
 <?php echo $task->end_date;?>
 </td>
  <td>
 <?php echo $task->Initiator_name;?>
 </td>
 <td>
 <?php if($task->valid == 0){echo "No";}else{echo "Yes";};?>
 </td>
 <td>
  <a href="<?php echo base_url()."task_management/edit_task/".$task->id;?>" class = "link">Edit </a>
  </td>
 </tr>
 
 <?php 
 }
 ?>
	
</table> 
<?php if (isset($pagination)): ?>
<div style="width:450px; margin:0 auto 60px auto">
<?php echo $pagination; ?>
</div>
<?php endif; ?>