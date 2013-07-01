<style type="text/css">
.chart_section{
border-top:2px solid #969696;
padding:10px;
width:650px;
margin:0 auto 0 auto;
}
#dashboard_menu{ 
font-size:14px;
width:90%;
margin:0 auto;
border-bottom: 1px solid #DDD;
overflow:hidden;
}

</style>
<div class="section_title"><?php echo $title;?></div>

<div id="dashboard_menu">
<a href="<?php echo site_url()."task_Management/add_new"?>" class="quick_menu_link">Add new task</a> 

</div>
<?php 
$this->load->view($report);
?>
