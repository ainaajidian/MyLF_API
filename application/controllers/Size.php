<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Size extends MY_Controller 
{

	function __construct()
    {
        parent::__construct();
        $this->load->model('Size_model');
        $this->load->model('Usersession');
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform,
								   max-age=0, post-check=0, pre-check=0");
    	$this->output->set_header("Pragma: no-cache");
    	$this->load->library('upload');
    }	

	public function index()
	{
		$data['csrf'] = array
		(
	        'name' => $this->security->get_csrf_token_name(),
	        'hash' => $this->security->get_csrf_hash()
		);
		
		$data['includecss'] = '<link rel="stylesheet"
							   href="'.base_url().'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.css">
							   <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">';
		$data['includejs'] 	= '<script src="'.base_url().'node_modules/admin-lte/plugins/datatables/jquery.dataTables.js"></script>
							   <script src="'.base_url().'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.js"></script>
							    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
							  ';
		
		$data['customjs'] 		    = "size/customjs";  
		$data['view'] 			    = "size/index";
        $data['parent_module']       = $this->Size_model->generateParent();
        
		$this->go_to($data);
	}

	public function getSize()
	{
		$queryresult = $this->Size_model->generateAll();
        foreach ($queryresult as $key) 
        {
           $info = explode("; ", $key->SizeDescription);
           if($key->TipeProduct == "C_00001")
           {
                $data['data'][] = array ( 
                    "SizeID"          => $key->SizeID,  
                    "SizeDescription" => "Panjang: ".$info[0]. " - ". "Lebar: ". $info[1]. " - ". 
                                         "Tinggi: " .$info[2]. " - ". "Berat:" .$info[3],
                    "panjang"        => $info[0],
                    "lebar"         => $info[1],
                    "tinggi"        => $info[2],
                    "berat"         => $info[3],
                    "TipeProduct"     => $key->TipeProduct,
                    "SizeFlag"        => $key->SizeFlag);
           }
           elseif($key->TipeProduct == "C_00007")
           {
                $data['data'][] = array ( 
                    "SizeID"          => $key->SizeID,  
                    "SizeDescription" => "Ukuran: ".$info[0]. " - ". "Berat: ". $info[1],
                    "ukuran"        => $info[0],
                    "berat"         => $info[1],
                    "TipeProduct"     => $key->TipeProduct,
                    "SizeFlag"        => $key->SizeFlag);
           }
           //print_r($info);
        }
            echo json_encode($data);
	}

	//Deactive Data
    function deactivate($SizeID)
    {
        $data = array("SizeFlag" => 0);
        $kondisi = array("SizeID" => $SizeID);
        $this->Size_model->status($data,$kondisi);
    }

    //Restore Data
    function restore($SizeID)
    {
        $data = array("SizeFlag" => 1);
        $kondisi = array("SizeID" => $SizeID);
        $this->Size_model->status($data,$kondisi);
    }

    //Delete data
    function deleteForever($SizeID)
    { $this->Size_model->deleteForever($SizeID); }

    //Save Data
    function saveSize()
    {
        $SizeID         = $this->input->post("SizeID");
        $Panjang        = $this->input->post("Panjang");
        $Lebar          = $this->input->post("Lebar");
        $Tinggi         = $this->input->post("Tinggi");
        $Ukuran         = $this->input->post("Ukuran");
        $Berat          = $this->input->post("Berat");
        $TipeProduct    = $this->input->post("TipeProduct");

        if($TipeProduct == 'C_00001')
        {
            $datasave = array(  "SizeDescription"   => $Panjang . " CM; " . $Lebar . " CM; " .
                                                       $Tinggi . " CM; " . $Berat . " KG",
                                "TipeProduct"       => "C_00001",
                                "SizeFlag"         => 1,
                                "SizeID"            => $this->Size_model->getMaxId() );
        
            $this->Size_model->saveSize($datasave,$SizeID);

            die("<script>
                alert('Add Size Success');
                window.location.href='".base_url()."Size';
                </script>");   
        }

        elseif($TipeProduct == 'C_00007')
        {
            $datasave = array(  "SizeDescription"   => $Ukuran . "; " . $Berat . " KG",
                                "TipeProduct"       => "C_00007",
                                "SizeFlag"          => 1,
                                "SizeID"            => $this->Size_model->getMaxId() );
        
            $this->Size_model->saveSize($datasave,$SizeID);

            die("<script>
                alert('Add Size Success');
                window.location.href='".base_url()."Size';
                </script>");   
        }

        else
        {
            die("<script>
                alert('Add Size Success');
                window.location.href='".base_url()."Size';
                </script>"); 
        }
        
    }

	//Edit Data
	function updateSize($SizeID)
	{
        $SizeID         = $this->input->post("SizeID");
        $Panjang        = $this->input->post("Panjang");
        $Lebar          = $this->input->post("Lebar");
        $Tinggi         = $this->input->post("Tinggi");
        $Ukuran         = $this->input->post("Ukuran");
        $Berat          = $this->input->post("Berat");
        $TipeProduct    = $this->input->post("TipeProduct");

        if($TipeProduct == "C_00001")
        {
            $datasave = array(      "SizeDescription"   => $Panjang . "; " . $Lebar . "; " .
                                                       $Tinggi . "; " . $Berat . "",
                                    "TipeProduct" => $TipeProduct,
                                    "SizeFlag"  => 1,
                                    "SizeID" => $SizeID );
            $this->Size_model->status($datasave);

            die("<script>
                alert('Update Size Success');
                window.location.href='".base_url()."Size';
                </script>");
        }

        if($TipeProduct == "C_00007")
        {
            $datasave = array(      "SizeDescription"   => $Ukuran . "; " . $Berat . "",
                                    "TipeProduct" => $TipeProduct,
                                    "SizeFlag"  => 1,
                                    "SizeID" => $SizeID );
            $this->Size_model->status($datasave);

            die("<script>
                alert('Update Size Success');
                window.location.href='".base_url()."Size';
                </script>");
        }
    }

	function delete($categoryId)
	{ $this->Size_model->deleteCategories($categoryId); }

}