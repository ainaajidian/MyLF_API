<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Usertype extends MY_Controller 
{
	public $loginmodel;
	public $_username;
	public $_password;

  	function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('Usertype_model');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }



    function index()
    {
    	$data['includecss'] = '<link rel="stylesheet" href="'.base_url().'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.css">
    						<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">';

		$data['includejs'] 	= '<script src="'.base_url().'node_modules/admin-lte/plugins/datatables/jquery.dataTables.js"></script>
						   <script src="'.base_url().'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.js"></script>
						    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script> ';

		$data['customjs'] 		= "usertypes/customjs";

    		$data['csrf'] = array('name' => $this->security->get_csrf_token_name(),
    							  'hash' => $this->security->get_csrf_hash());

		$data['view'] = "usertypes/index";	

		$this->go_to($data);
    }

    function getType()
    {
		$data['data'] 	=	$this->Usertype_model->generateAll();
    	echo json_encode($data);
    }

    function saveUsertype()
    {
		$usertype_desc 		= $this->input->post("usertype_desc");
		$cek_usertype_name	= $this->Usertype_model->check_type_exist(array("type_description" => $usertype_desc));
		$id = $this->Usertype_model->getMaxId();

		if($cek_usertype_name)
		{
			$datasave = array("type_description" 	=> $usertype_desc,
							  "type_id" => $id,
							  "flag" => 1
							 );

			$this->Usertype_model->saveusertype($datasave);

			die("<script>
				alert('Save success');
				window.location.href='".base_url()."Usertype';
				</script>");
		}

		else
			{
				die("<script>
					alert('".$usertype_desc." already in use');
					window.location.href='".base_url()."Usertype';
					</script>");
			}

    }



    function set_deactive($type_id)
    {
    	$data = array("flag" => 0);
		$kondisi = array("type_id" => $type_id);
		$this->Usertype_model->updateusertype($data,$kondisi);
    }



    function set_active($type_id)
    {
    	$data = array("flag" => 1);
		$kondisi = array("type_id" => $type_id);
		$this->Usertype_model->updateusertype($data,$kondisi);
    }



    function deleteForever($type_id)
    { $this->Usertype_model->deleteuser($type_id); }



    function manageModule($type_id)
    {
    	$data['includecss'] = '<link rel="stylesheet" href="'.base_url().'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.css">
							<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
							<link rel="stylesheet" href="https://editor.datatables.net/extensions/Editor/css/editor.dataTables.min.css"> ';

		$data['includejs'] 	= '<script src="'.base_url().'node_modules/admin-lte/plugins/datatables/jquery.dataTables.js"></script>
						   <script src="'.base_url().'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.js"></script>
						    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script> ';



		$data['module']	= $this->db->query("SELECT a.* from modules a 
											where module_id not in 
											(select module_id from modules_access where usertype = '".$type_id."' ) ")->result();

		$data['usertype_info'] = $this->Usertype_model->getSingle($type_id);

		$data['customjs'] 		= "usertypes/customjs";

		$data['csrf'] = array('name' => $this->security->get_csrf_token_name(),
							  'hash' => $this->security->get_csrf_hash());

		$data['view'] = "usertypes/manageModule";	
		$data['list'] = $this->Usertype_model->generateUsermodule($type_id);
		$this->go_to($data);
    }

    function updateUsertype()
    {
    	$id = $this->input->post("usertype_id");
    	$usertype_desc = $this->input->post("usertype_desc");
   		$data = array("type_description" => $usertype_desc);
		$kondisi = array("type_id" => $id);

		if($this->Usertype_model->check_type_update($id,$usertype_desc))
		{
			$this->Usertype_model->updateusertype($data,$kondisi);

			die("<script>
			alert('Update Success');
			window.location.href='".base_url()."Usertype';
			</script>");
		}
		else
		{
			die("<script>
				alert('".$usertype_desc." Already In Use');
				window.location.href='".base_url()."Usertype';
				</script>");
		}

    }



    function saveAccess()
    {
    	$type_id 		= $this->input->post("type_id");
    	$module_id 		= $this->input->post("module_id");

    	$datasave = array("access_id" 	=> $this->Usertype_model->getMaxAccessId(),
    					  "module_id" => $module_id,
    					  "usertype" =>$type_id);

    	$this->Usertype_model->saveAccess($datasave);

		die("<script>
		alert('Adding Access Success');
		window.location.href='".base_url()."Usertype';
		</script>");
    }



    function revokeAccess($id)
    {
		$this->Usertype_model->revokeAccess($id);

		die("<script>
			alert('Revoke Access Success');
			window.location.href='".base_url()."Usertype';
			</script>");
    }
}