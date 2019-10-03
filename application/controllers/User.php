<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
         $this->load->model('Usersession');
         $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
    	$this->output->set_header("Pragma: no-cache");
    }

    function index(){
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
		$data['customjs'] 		= "user/customjs";
		$data['view'] 			= "user/index";
		$data['user_type']		= $this->db->query("SELECT * FROM usertypes where type_id <> 'TP001'")->result();
		$this->go_to($data);    
	}

	function getUser(){
		$data['data'] = $this->User_model->generateAll();
		echo json_encode($data);
	}

	function saveuser(){
		$username 		= $this->input->post("username");
		$userpassword 	= $this->input->post("userpassword");
		$useremail	 	= $this->input->post("useremail");
		$usertype 		= $this->input->post("usertype");
		$cekusername 	= $this->User_model->check_user_exist(array("username" => $username));
		if($cekusername){
			$cekemail 	= $this->User_model->check_user_exist(array("email" => $useremail));
				if($cekemail){
					$datasave = array(
								"username" 	=> $username,
								"password" 	=> md5($userpassword),
								"usertype" 	=> $usertype,
								"email"	   	=> $useremail,
								"user_flag"	=> 1,
								"userid"   	=> $this->User_model->getMaxId()
							);
					$this->User_model->saveuser($datasave);
					die("<script>
					alert('Saving user success');
					window.location.href='".base_url()."User';
					</script>");
				}else{
					die("<script>
					alert('Email already in use');
					window.location.href='".base_url()."User';
					</script>");
				}
		}else{
			die("<script>
				alert('Username already in use');
				window.location.href='".base_url()."User';
				</script>");
		}
	}

	function updateUser(){
		$userid = $this->input->post("userid");
		$username = $this->input->post("username");
		$useremail = $this->input->post("useremail");
		$usertype = $this->input->post("usertype");

		$dataupdate = array("username" => $username , "usertype" => $usertype , "email" => $useremail);
		$kondisi	= array("userid" => $userid);

		$this->User_model->updateUser($dataupdate,$kondisi);
		die("<script>
				alert('Update user success');
				window.location.href='".base_url()."User';
				</script>");
	}

	function deactivate($userid){
		$data = array("user_flag" => 0);
		$kondisi = array("userid" => $userid);
		$this->User_model->updateUser($data,$kondisi);
	}

	function restore($userid){
		$data = array("user_flag" => 1);
		$kondisi = array("userid" => $userid);
		$this->User_model->updateUser($data,$kondisi);
	}

	function delete($userid){
		$this->User_model->deleteuser($userid);
	}

}