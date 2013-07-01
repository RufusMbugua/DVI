 <div id="chartdiv" align="center" style="height: 600px" >FusionGadgets</div>
   <script type="text/javascript">
	var myChart = new FusionCharts("<?php echo base_url()."Scripts/FusionWidgets/Gantt.swf"?>", "myChartId", "100%", "100%", "0", "0");
	myChart.setDataURL("<?php echo base_url()."task_management/gantt_vaccine/".$gantt_data?>");
	myChart.render("chartdiv");
   </script>