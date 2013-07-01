<style type="text/css">
.chart_section{
border-top:2px solid #969696;
padding:10px;
width:650px;
margin:0 auto 0 auto;
}
.dashboard_menu{ 
font-size:14px;
width:90%;
margin:0 auto;
border-bottom: 1px solid #DDD;
overflow:hidden;
}
.quick_menu{ 
font-size:14px;
width:90%;
margin:5px auto; 
overflow:hidden;
}
.quick_menu a{ 
border-bottom: 1px solid #DDD;
}

</style>
<div class="section_title"><?php echo $title;?></div>

<div class="dashboard_menu">
	<a href="<?php echo site_url()."task_Management/add_new"?>" class="quick_menu_link">Add new task</a>
<?php 
$access_level = $this -> session -> userdata('user_group');
if($access_level == "1" || $access_level == "2"){?>
<a href="<?php echo site_url()."task_management/view_task";?>" class="quick_menu_link <?php if($quick_link == "edit_task"){echo "quick_menu_active";}?>">Edit Task</a> 
<?php
}
?>
<a  class="quick_menu_link <?php if($quick_link == "all_tasks") {echo "quick_menu_active";}?>" href="<?php echo site_url("task_management");?>">All Tasks</a>
 

<div id="tabs" class="htabs">
<?php

$vaccines = Vaccines::getAll_Minified();
foreach($vaccines as $vaccine){?>
	<?php?>
<a href="<?php echo base_url()."task_Management/vaccine/".$vaccine->id?>" id="vaccine_<?php echo $vaccine->id ?>" tab="#<?php echo $vaccine->id ?>" class="vaccine_name" name="<?php echo $vaccine->Name?>" style="background-color: <?php echo '#'.$vaccine->Tray_Color;?>"><?php echo $vaccine->Name?></a> 
<?php } ?>

<?php
if(isset($gantt_data)){
	?>
	<script type="text/javascript">
	$(function() {
	var _id=<?php echo $gantt_data; ?>;
	$(".vaccine_name").removeClass();
	$("#vaccine_"+_id).addClass('selected');
	}); 
	</script>
	<?php
}
?>

</div>
</div>
<?php 
$this->load->view($module_view);
?>
