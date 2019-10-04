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
		
		$data['customjs'] 		     = "size/customjs";  
		$data['view'] 			     = "size/index";
        
		$this->go_to($data);
	}

	public function getSize()
	{
		$data['data'] = $this->Size_model->generateAll();
		echo json_encode($data);
	}

	//Deactive data
	function deactivate($categoryId)
    {
        $data = array("categoryFlag" => 0);
        $kondisi = array("categoryId" => $categoryId);
        $this->Size_model->updateCategory($data,$kondisi);
    }

    //Active data
    function restore($categoryId)
    {
        $data = array("categoryFlag" => 1);
        $kondisi = array("categoryId" => $categoryId);
        $this->Size_model->updateCategory($data,$kondisi);
    }

    //Delete data
	function deleteForever($categoryId)
	{ $this->Size_model->deleteForever($categoryId); }

    //Save data
    function saveCategory()
    {
        $categoryName           = $this->input->post("categoryName");
        $categoryDescription    = $this->input->post("categoryDescription");
        $categoryCreatedDate    = $this->input->post("categoryCreatedDate");
        $categoryModifiedDate   = $this->input->post("categoryModifiedDate");
        $categoryFlag           = $this->input->post("categoryFlag");
        $parentCategoryId       = $this->input->post("parentCategoryId");
        $categoryId             = $this->input->post("categoryId");

        //$nmfile = "ProCat_".date('Y-m-d'); //nama file saya beri nama langsung dan diikuti fungsi time
        $config['upload_path']   = './assets/app_assets/'; //path folder
        $config['allowed_types'] = 'jpg|png|jpeg'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '2048000000'; //maksimum besar file 2M
        $config['max_width']  = '1288'; //lebar maksimum 1288 px
        $config['max_height']  = '1000'; //tinggi maksimu 1000 px
        //$config['file_name'] = $nmfile; //nama yang terupload nantinya

        $this->upload->initialize($config);
        $this->load->library('upload',$config);
        if(!empty($_FILES['categoryImage']['name']))
        {
            if ($this->upload->do_upload('categoryImage'))
            {       
                    $pic = $this->upload->data();
                    $picture = $pic['file_name'];
                    $datasave = array(  "categoryName"          => $categoryName,
                                        "categoryImage"         => $picture,
                                        "categoryDescription"   => $categoryDescription,
                                        "categoryCreatedDate"   => $categoryCreatedDate,
                                        "categoryModifiedDate"  => $categoryModifiedDate,
                                        "categoryFlag"          => 1,
                                        "parentCategoryId"      => $parentCategoryId,
                                        "categoryId"            => $this->Size_model->getMaxId() );
                    $this->Size_model->saveCategory($datasave,$categoryId);

                    die("<script>
                        alert('Add Product Category Success');
                        window.location.href='".base_url()."Size';
                        </script>");
            } 
            else 
            {
                die('<script>
                    alert("'.$this->upload->display_errors().'");
                    window.location.href="'.base_url().'Size";
                    </script>');
            }
            
        }
        else
        {

            $datasave = array(  "categoryName"          => $categoryName,
                                "categoryImage"         => NULL,
                                "categoryDescription"   => $categoryDescription,
                                "categoryCreatedDate"   => $categoryCreatedDate,
                                "categoryModifiedDate"  => $categoryModifiedDate,
                                "categoryFlag"          => 1,
                                "parentCategoryId"      => $parentCategoryId,
                                "categoryId"            => $this->Size_model->getMaxId() );
            
            $this->Size_model->saveCategory($datasave,$categoryId);

           die("<script>
                alert('Add Product Category Success');
                window.location.href='".base_url()."Size';
                </script>");
        }
    }

	//Edit Data
	function updateCategory()
	{
		$categoryName 			= $this->input->post("categoryName");
		$categoryDescription    = $this->input->post("categoryDescription");
        $parentCategoryId       = $this->input->post("parentCategoryId");
		$categoryModifiedDate 	= $this->input->post("categoryModifiedDate");
        $parentCategoryId       = $this->input->post("parentCategoryId");
		$categoryId 			= $this->input->post("categoryId");
        
        $config['upload_path']   = './assets/app_assets/'; //path folder
        $config['allowed_types'] = 'jpg|png|jpeg'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size']      = '2048000000'; //maksimum besar file 2M
        $config['max_width']     = ''; //lebar maksimum 1288 px
        $config['max_height']    = ''; //tinggi maksimu 1000 px
        
        $this->upload->initialize($config);
        $this->load->library('upload',$config);
        if(!empty($_FILES['editcategoryImage']['name']))
        {
            if ($this->upload->do_upload('editcategoryImage'))
            {       
                    $pic = $this->upload->data();
                    $picture = $pic['file_name'];
                	$dataupdate = array("categoryName"          => $categoryName, 
                						"categoryDescription"   => $categoryDescription, 
                						"categoryModifiedDate"  => $categoryModifiedDate,
                                        "parentCategoryId"      => $parentCategoryId,
                						"categoryImage"         => $picture,
                                        "parentCategoryId"      => $parentCategoryId,
                						"categoryId"            => $categoryId );

                	$this->Size_model->updateCategoryImg($dataupdate,$categoryId);

                	die("<script>
						alert('Update Product Category Success');
						window.location.href='".base_url()."Size';
						</script>");
            } 
            else 
            {
                die('<script>
					alert("'.$this->upload->display_errors().'");
					window.location.href="'.base_url().'Size";
					</script>');
            }
            
        }
        else
        {
            $dataupdate = array("categoryName" => $categoryName, 
                                "categoryDescription" => $categoryDescription,
                                "parentCategoryId"      => $parentCategoryId,
                                "categoryModifiedDate" => $categoryModifiedDate,
                                "categoryId" => $categoryId);
            
            $this->Size_model->updateCategoryNoImg($dataupdate,$categoryId);

            die("<script>
                alert('Update Product Category Success');
                window.location.href='".base_url()."Size';
                </script>");
        }
    }

	function delete($categoryId)
	{ $this->Size_model->deleteCategories($categoryId); }

}