 <div id="chartdiv" align="center" style="height: 900px">FusionGadgets</div>
   <script type="text/javascript">
	var myChart = new FusionCharts("<?php echo base_url()."Scripts/FusionWidgets/Gantt.swf"?>", "myChartId", "100%", "100%", "0", "0");
	myChart.setDataURL("<?php echo base_url()."task_management/gantt_chart"?>");
	myChart.render("chartdiv");
   </script>

 
	

