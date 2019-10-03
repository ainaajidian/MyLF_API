<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Module extends MY_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('Module_model');
        $this->load->model('Usersession');
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
								<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">';
		$data['includejs'] 	= '<script src="'.base_url().'node_modules/admin-lte/plugins/datatables/jquery.dataTables.js"></script>
							   <script src="'.base_url().'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.js"></script>
							    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>';
		$data['customjs'] 		= "module/customjs";
		$data['view'] 			= "module/index";
		$data['parent_module']	= $this->Module_model->generateParent();
		
		$this->go_to($data);
	}

	public function getModule()
	{
		$data['data'] = $this->Module_model->generateAll();
		echo json_encode($data);
	}

	function saveModule()
	{
		$module_type 	= $this->input->post("module_type");
		$module_name 	= $this->input->post("module_name");
		$module_path 	= $this->input->post("module_path");

		if(!$this->Module_model->check_save_module($module_name))
		{
				die("<script>
				alert('Module Name already exists');
				window.location.href='".base_url()."Module';
				</script>");
		}

		if($module_type == "2")
		{
			$module_parent 	= $this->input->post("module_parent");
			if($module_parent == "")
			{
				die("<script>
				alert('You need to choose module parent for this type');
				window.location.href='".base_url()."Module';
				</script>");
			}

			$module_icon = $this->input->post("module_icon");
			$datasave = array( 	"module_name" 	=> $module_name , 
	        					"module_path" 	=> $module_path, 
	        					"module_icon" 	=> $module_icon, 
	        					"module_type" 	=> $module_type,
	        					"module_parent" => $module_parent
	        				 );
			$this->Module_model->saveModule($datasave);
		}


		if($module_type == "1"){
				$config['upload_path']          = './assets/icon/';
                $config['allowed_types']        = 'png';
                $config['max_size']             = 100;
                $config['max_width']            = 32;
                $config['max_height']           = 32;
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('userfile'))
                {
					die('<script>
					alert("'.$this->upload->display_errors().'");
					window.location.href="'.base_url().'Module";
					</script>');
                }
                else
                {
                	$uploaddata = $this->upload->data();
                	$file_name  = $uploaddata['file_name'];
                	$datasave = array( "module_name" => $module_name , 
                						"module_path" => $module_path, 
                						"module_icon" => $file_name, 
                						"module_type" => $module_type,
                						"module_parent" => ""
                						 );
                	$this->Module_model->saveModule($datasave);
                }
		}

		die("<script>
			alert('Save Module success');
			window.location.href='".base_url()."Module';
			</script>");

	}

	function delete($id)
	{ $this->Module_model->deletemodule($id); }

	function deleteForever($id)
	{ $this->Module_model->deleteForever($id); }


    function updatemodule($id)
    {
    	$module_type 	= $this->input->post("module_type");
		$module_name 	= $this->input->post("module_name");
		$module_path 	= $this->input->post("module_path");

    	if($module_type == "2")
    	{
			$module_parent 	= $this->input->post("module_parent");
			if($module_parent == "")
			{
				die("<script>
				alert('You need to choose module parent for this type');
				window.location.href='".base_url()."Module';
				</script>");
			}

			$module_icon = $this->input->post("module_icon");
			$datasave = array( 		"module_name" 	=> $module_name , 
	        						"module_path" 	=> $module_path, 
	        						"module_icon" 	=> $module_icon, 
	        						"module_type" 	=> $module_type,
	        						"module_parent" => $module_parent );
			$this->Module_model->updatemodule($datasave,$id);

			die("<script>
				alert('Update Module Success');
				window.location.href='".base_url()."Module';
				</script>");
		}
		
		else if($module_type == "1")
		{
			$module_detail = $this->Module_model->getModuledetail($id);
			$config['upload_path']          = './assets/icon/';
            $config['allowed_types']        = 'png';
            $config['max_size']             = 100;
            $config['max_width']            = 32;
            $config['max_height']           = 32;
            $this->load->library('upload', $config);

			if($module_detail->module_type == "1")
			{
				if(!file_exists($_FILES['userfile']['tmp_name']) || !is_uploaded_file($_FILES['userfile']['tmp_name'])) 
				{
				   	$datasave = array( "module_name" => $module_name , 
                					   "module_path" => $module_path, 
                					   "module_type" => $module_type,
                					   "module_parent" => ""
                					 );
                	$this->Module_model->updateModule($datasave,$id);
				
					die("<script>
						alert('Update Module Success');
						window.location.href='".base_url()."Module';
						</script>");

				}

	                if ( $this->upload->do_upload('userfile'))
	              	{
	                	$uploaddata = $this->upload->data();
	                	$file_name  = $uploaddata['file_name'];
	                	$datasave = array( "module_name" => $module_name , 
	                						"module_path" => $module_path, 
	                						"module_icon" => $file_name, 
	                						"module_type" => $module_type,
	                						"module_parent" => ""
	                						 );
	                	$this->Module_model->updateModule($datasave,$id);
	                }
	                else
	                {
	                	die('<script>
						alert("'.$this->upload->display_errors().'");
						window.location.href="'.base_url().'Module";
						</script>');
	                }
				}

				else if($module_detail->module_type == "2")
				{
				   if ( $this->upload->do_upload('userfile'))
	              	{
	                	$uploaddata = $this->upload->data();
	                	$file_name  = $uploaddata['file_name'];
	                	$datasave = array( "module_name" => $module_name , 
	                						"module_path" => $module_path, 
	                						"module_icon" => $file_name, 
	                						"module_type" => $module_type,
	                						"module_parent" => ""
            						 		);
	                	$this->Module_model->updateModule($datasave,$id);
	                	die("<script>
						alert('Update Module Success');
						window.location.href='".base_url()."Module';
						</script>");
	                }
	                else
	                {
	                	die('<script>
						alert("'.$this->upload->display_errors().'");
						window.location.href="'.base_url().'Module";
						</script>');
	                }
				}
			}
	    }
}
