<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Helpdesk extends MY_Controller {
  	function __construct()

    {

        parent::__construct();
        $this->load->model('Usersession');
        $this->load->helper(array('form', 'url'));
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
    	$this->output->set_header("Pragma: no-cache");
    }
	public function index()
	{
		$data['csrf'] = array(
	        'name' => $this->security->get_csrf_token_name(),
	        'hash' => $this->security->get_csrf_hash()
		);
		$data['includecss'] = '<link rel="stylesheet" href="'.base_url().'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.css">
								<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
								<link rel="stylesheet" href="'.base_url().'node_modules/admin-lte/plugins/colorpicker/bootstrap-colorpicker.min.css">
								';
		$data['includejs'] 	= '<script src="'.base_url().'node_modules/admin-lte/plugins/datatables/jquery.dataTables.js"></script>
							   <script src="'.base_url().'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.js"></script>
							    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
							    <script src="'.base_url().'node_modules/admin-lte/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
							  ';
		$data['customjs'] 		= "helpdesk/customjs";
		$data['view'] 			= "helpdesk/index";
		if($this->Usersession->getUsertype() == "TP004"){
			$data['list']			= $this->db->query("SELECT * FROM helpdesk where penanya = '".$this->Usersession->getLoginid()."'  and parentid IS NULL order by createddate desc")->result();
		}else{
			$data['list']			= $this->db->query("SELECT * FROM helpdesk where parentid IS NULL order by createddate desc")->result();
		}
		$this->go_to($data);
	}

	public function add()
	{
		$data['csrf'] = array(
	        'name' => $this->security->get_csrf_token_name(),
	        'hash' => $this->security->get_csrf_hash()
		);
		$data['includecss'] = '<link rel="stylesheet" href="'.base_url().'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.css">
								<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
								<link rel="stylesheet" href="'.base_url().'node_modules/admin-lte/plugins/colorpicker/bootstrap-colorpicker.min.css">
								';
		$data['includejs'] 	= '<script src="'.base_url().'node_modules/admin-lte/plugins/datatables/jquery.dataTables.js"></script>
							   <script src="'.base_url().'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.js"></script>
							    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
							    <script src="'.base_url().'node_modules/admin-lte/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
							  ';
		$data['customjs'] 		= "helpdesk/customjs";
		$data['view'] 			= "helpdesk/add";

		$this->go_to($data);
	}
	function saveHeader(){
		$subjek 		= $this->input->post("subjek");
		$pertanyaan 	= $this->input->post("pertanyaan");
		$this->db->query("INSERT INTO helpdesk (subjek,penanya,konten,createddate,status) values ('".$subjek."','".$this->Usersession->getLoginid()."','".$pertanyaan."',NOW(),0)");
		$data 			= $this->db->query("SELECT * from helpdesk where penanya = '".$this->Usersession->getLoginid()."' order by Qid desc LIMIT 1 ")->row();
		die("<script>
				alert('Mengalihkan');
				window.location.href='".base_url()."Helpdesk/detail/".$data->QId."';
				</script>");

	}

	function detail($id){
	$data['csrf'] = array(
	        'name' => $this->security->get_csrf_token_name(),
	        'hash' => $this->security->get_csrf_hash()
		);
		$data['includecss'] = '<link rel="stylesheet" href="'.base_url().'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.css">
								<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
								<link rel="stylesheet" href="'.base_url().'node_modules/admin-lte/plugins/colorpicker/bootstrap-colorpicker.min.css">
								';
		$data['includejs'] 	= '<script src="'.base_url().'node_modules/admin-lte/plugins/datatables/jquery.dataTables.js"></script>
							   <script src="'.base_url().'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.js"></script>
							    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
							    <script src="'.base_url().'node_modules/admin-lte/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
							  ';
		$data['list']			= $this->db->query("SELECT * FROM helpdesk where (QId = '".$id."' or parentid = '".$id."') order by createddate asc")->result();
		$data['customjs'] 		= "helpdesk/customjs";
		$data['view'] 			= "helpdesk/detail";
		$data['user']			= $this->Usersession->getLoginid();

		if($this->Usersession->getUsertype() == "TP004"){
					$data['view'] 			= "helpdesk/detail";		
				}else{
					$data['view'] 			= "helpdesk/detail_admin";		
				}

		$this->go_to($data);
	}
	function savebalasan($id){
		$message 	= $this->input->post("message");
		$this->db->query("INSERT INTO helpdesk (penanya,konten,createddate,status,parentid) values ('".$this->Usersession->getLoginid()."','".$message."',NOW(),0,'".$id."')");
		die("<script>
				alert('Mengalihkan');
				window.location.href='".base_url()."Helpdesk/detail/".$id."';
				</script>");
	}



}
