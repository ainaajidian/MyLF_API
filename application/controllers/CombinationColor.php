<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CombinationColor extends MY_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('CombinationColor_model');
         $this->load->model('Usersession');
         $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
    	$this->output->set_header("Pragma: no-cache");
    }

    function index()
    {
		$data['csrf'] = array(
	        'name' => $this->security->get_csrf_token_name(),
	        'hash' => $this->security->get_csrf_hash()
			);
		$data['includecss'] = '<link rel="stylesheet" href="'.base_url().'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.css">
							<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">';
		$data['includejs'] 	= '<script src="'.base_url().'node_modules/admin-lte/plugins/datatables/jquery.dataTables.js"></script>
						   <script src="'.base_url().'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.js"></script>
						    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
						  ';
		$data['customjs'] 				= "combinationcolor/customjs";
		$data['view'] 					= "combinationcolor/index";
		$data['combination_module']		= $this->CombinationColor_model->generateAll();
		$this->go_to($data);   
	}

	//Get Color
	function getColor()
	{
		$data['data'] = $this->CombinationColor_model->generateAll();
		echo json_encode($data);
	}

	//Deactive Data
	function deactivate($ccId)
    {
        $data = array("ccFlag" => 0);
        $kondisi = array("ccId" => $ccId);
        $this->CombinationColor_model->updateCC($data,$kondisi);
    }

    //Restore Data
	function restore($ccId){
		$data = array("ccFlag" => 1);
		$kondisi = array("ccId" => $ccId);
		$this->CombinationColor_model->updateCC($data,$kondisi);
	}

	//Delete data
	function deleteForever($ccId)
	{ $this->CombinationColor_model->deleteForever($ccId); }

	//Save Data
	function saveColor()
    {
		$ccName 		= $this->input->post("ccName");
		$ccPriName	 	= $this->input->post("ccPriName");
		$ccPriHex 		= $this->input->post("ccPriHex");
		$ccSecName 		= $this->input->post("ccSecName");
		$ccSecHex 		= $this->input->post("ccSecHex");
		$ccFlag			= $this->input->post("ccFlag");
		$ccId 			= $this->input->post("ccId");

		$datasave = array(  "ccName" 	=> $ccName,
							"ccPriName" => $ccPriName,
							"ccPriHex" 	=> $ccPriHex,
							"ccPriHex" 	=> $ccPriHex,
							"ccSecName"	=> $ccSecName,
							"ccSecHex"	=> $ccSecHex,
							"ccFlag"	=> 1,
							"ccId"   	=> $this->CombinationColor_model->getMaxId() );
        
        $this->CombinationColor_model->saveColor($datasave,$ccId);

    	die("<script>
			alert('Add Combination Color Success');
			window.location.href='".base_url()."CombinationColor';
			</script>");
    }

    //Update Data
	function updateColor()
    {
		$ccName 		= $this->input->post("ccName");
		$ccPriName	 	= $this->input->post("ccPriName");
		$ccPriName 		= $this->input->post("ccPriName");
		$ccPriHex		= $this->input->post("ccPriHex");
		$ccSecName 		= $this->input->post("ccSecName");
		$ccSecHex 		= $this->input->post("ccSecHex");
		$ccId 			= $this->input->post("ccId");

		$data = array("ccName" 	=> $ccName,
					"ccPriName" => $ccPriName,
					"ccPriName" => $ccPriName,
					"ccPriHex" 	=> $ccPriHex,
					"ccSecName"	=> $ccSecName,
					"ccSecHex"	=> $ccSecHex);

		$kondisi	= array("ccId"		=> $ccId );
        
        $this->CombinationColor_model->updateCC($data,$kondisi);

    	die("<script>
			alert('Update Combination Color Success');
			window.location.href='".base_url()."CombinationColor';
			</script>");
    }
	
    //Delete Data
	function delete($userid){
		$this->User_model->deleteuser($userid);
	}

}