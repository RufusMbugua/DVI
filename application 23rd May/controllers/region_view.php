<?php
class Region_View extends CI_Controller
{
	function index()
	{
		$year = date('Y');
		$data['title'] = "System Dashboard";
		$data['vaccines'] = Vaccines::getAll_Minified();
		$data['styles'] = array("jquery-ui.css", "tab.css");
		$data['scripts'] = array("FusionCharts/FusionCharts.js","jquery-ui.js", "advanced_tabs.js");
		$data['link'] = "region_view";
		$data['dashboard_active'] = 0;
		$data['content_view'] = "general_dashboard_view";
		$this -> load -> view('template_regional_dashboard', $data);
	}
	function mombasa_dashboard()
	{
		
		$data['link'] = "region_view";
		$year = date('Y');
		$data['province_id'] = 1;
		$data['title'] = "System Dashboard :: Mombasa";
		$data['vaccines'] = Vaccines::getAll_Minified();
		$data['styles'] = array("jquery-ui.css", "tab.css");
		$data['scripts'] = array("FusionCharts/FusionCharts.js","jquery-ui.js", "advanced_tabs.js");
		$data['content_view'] = "general_specific";
		$data['quick_link'] = "mombasa";
		$data['dashboard_active'] = 1;
		$data['text']="Regional Dashboard :: Mombasa";
		$this -> load -> view('template_regional_dashboard', $data);
	}
	function nakuru_dashboard()
	{
		$data['link'] = "region_view";
		$year = date('Y');
		$data['province_id'] = 2;
		$data['title'] = "System Dashboard :: Nakuru";
		$data['vaccines'] = Vaccines::getAll_Minified();
		$data['styles'] = array("jquery-ui.css", "tab.css");
		$data['scripts'] = array("FusionCharts/FusionCharts.js","jquery-ui.js", "advanced_tabs.js");
		$data['content_view'] = "general_specific";
		$data['quick_link'] = "nakuru";
		$data['dashboard_active'] = 1;
		$data['text']="Regional Dashboard :: Nakuru";
		$this -> load -> view('template_regional_dashboard', $data);
	}
	
	function eldoret_dashboard()
	{
		$data['link'] = "region_view";
		$year = date('Y');
		$data['province_id'] = 3;
		$data['title'] = "System Dashboard :: Eldoret";
		$data['vaccines'] = Vaccines::getAll_Minified();
		$data['styles'] = array("jquery-ui.css", "tab.css");
		$data['scripts'] = array("FusionCharts/FusionCharts.js","jquery-ui.js", "advanced_tabs.js");
		$data['content_view'] = "general_specific";
		$data['quick_link'] = "eldoret";
		$data['dashboard_active'] = 1;
		$data['text']="Regional Dashboard :: Eldoret";
		$this -> load -> view('template_regional_dashboard', $data);
	}
	
	function kakamega_dashboard()
	{
		$data['link'] = "region_view";
		$year = date('Y');
		$data['province_id'] = 4;
		$data['title'] = "System Dashboard :: Kakamega";
		$data['vaccines'] = Vaccines::getAll_Minified();
		$data['styles'] = array("jquery-ui.css", "tab.css");
		$data['scripts'] = array("FusionCharts/FusionCharts.js","jquery-ui.js", "advanced_tabs.js");
		$data['content_view'] = "general_specific";
		$data['quick_link'] = "kakamega";
		$data['dashboard_active'] = 1;
		$data['text']="Regional Dashboard :: Kakamega";
		$this -> load -> view('template_regional_dashboard', $data);
	}
	
	function kisumu_dashboard()
	{
		$data['link'] = "region_view";
		$year = date('Y');
		$data['province_id'] = 5;
		$data['title'] = "System Dashboard :: Kisumu";
		$data['vaccines'] = Vaccines::getAll_Minified();
		$data['styles'] = array("jquery-ui.css", "tab.css");
		$data['scripts'] = array("FusionCharts/FusionCharts.js","jquery-ui.js", "advanced_tabs.js");
		$data['content_view'] = "general_specific";
		$data['quick_link'] = "kisumu";
		$data['dashboard_active'] = 1;
		$data['text']="Regional Dashboard :: Kisumu";
		$this -> load -> view('template_regional_dashboard', $data);
	}
	
	function garissa_dashboard()
	{
		$data['link'] = "region_view";
		$year = date('Y');
		$data['province_id'] = 6;
		$data['title'] = "System Dashboard :: Garissa";
		$data['vaccines'] = Vaccines::getAll_Minified();
		$data['styles'] = array("jquery-ui.css", "tab.css");
		$data['scripts'] = array("FusionCharts/FusionCharts.js","jquery-ui.js", "advanced_tabs.js");
		$data['content_view'] = "general_specific";
		$data['quick_link'] = "garissa";
		$data['dashboard_active'] = 1;
		$data['text']="Regional Dashboard :: Garissa";
		$this -> load -> view('template_regional_dashboard', $data);
	}
	
	function meru_dashboard()
	{
		$data['link'] = "region_view";
		$year = date('Y');
		$data['province_id'] = 7;
		$data['title'] = "System Dashboard :: Meru";
		$data['vaccines'] = Vaccines::getAll_Minified();
		$data['styles'] = array("jquery-ui.css", "tab.css");
		$data['scripts'] = array("FusionCharts/FusionCharts.js","jquery-ui.js", "advanced_tabs.js");
		$data['content_view'] = "general_specific";
		$data['quick_link'] = "meru";
		$data['dashboard_active'] = 1;
		$data['text']="Regional Dashboard :: Meru";
		$this -> load -> view('template_regional_dashboard', $data);
	}
	
	function nyeri_dashboard()
	{
		$data['link'] = "region_view";
		$year = date('Y');
		$data['province_id'] = 8;
		$data['title'] = "System Dashboard :: Nyeri";
		$data['vaccines'] = Vaccines::getAll_Minified();
		$data['styles'] = array("jquery-ui.css", "tab.css");
		$data['scripts'] = array("FusionCharts/FusionCharts.js","jquery-ui.js", "advanced_tabs.js");
		$data['content_view'] = "general_specific";
		$data['quick_link'] = "nyeri";
		$data['dashboard_active'] = 1;
		$data['text']="Regional Dashboard :: Nyeri";
		$this -> load -> view('template_regional_dashboard', $data);
	}
	
	
}
