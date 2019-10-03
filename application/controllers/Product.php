<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {

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
		$data['view'] 					= "product/index";
		$data['customjs'] 				= "product/customjs";

		$this->go_to($data);   
	}


	function getProduct(){
		$data['data']		= $this->db->query("SELECT a.*, b.categoryName FROM products a inner join product_categories b on a.categoryId = b.categoryId")->result();
		echo json_encode($data);

	}


	function add()
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
		$data['view'] 					= "product/add";
		$data['customjs'] 				= "product/customjs";
		$data['categories']				= $this->db->query("SELECT * FROM product_categories where (parentCategoryID = '' or parentCategoryID is null) order by categoryName asc")->result();
		$data['child_categories']				= $this->db->query("SELECT * FROM product_categories where (parentCategoryID <> '' or parentCategoryID is not null) order by categoryName asc")->result();

		$this->go_to($data);   
	}

	function saveheader(){
		$productId 	 		= $this->getMaxId();
		$productName 		= $this->input->post("productName");
		$productPrice 		= $this->input->post("productPrice");
		$productDescription = $this->input->post("productDescription");
		$productCategory 	= $this->input->post("productCategory");
		$productFlag 		= $this->input->post("productFlag");
		$childproductCategory = $this->input->post("childproductCategory");

		if($productFlag == "1"){
			$this->db->query("INSERT into products 
				(productId,productName,isNew,isHot,categoryId,productFlag,productPrice,productDescription,childCategoryId)
				values
				('".$productId."','".$productName."',0,1,'".$productCategory."',0,'".$productPrice."','".$productDescription."','".$childproductCategory."')
				 ");
		}else if($productFlag == "2"){
				$this->db->query("INSERT into products 
						(productId,productName,isNew,isHot,categoryId,productFlag,productPrice,productDescription,childCategoryId)
						values
						('".$productId."','".$productName."',1,0,'".$productCategory."',0,'".$productPrice."','".$productDescription."','".$childproductCategory."')
						 ");
		}else{
				$this->db->query("INSERT into products 
						(productId,productName,isNew,isHot,categoryId,productFlag,productPrice,productDescription,childCategoryId)
						values
						('".$productId."','".$productName."',0,0,'".$productCategory."',0,'".$productPrice."','".$productDescription."','".$childproductCategory."')
						 ");
		}
		die("<script>
				alert('Proses Simpan Berhasil');
				window.location.href='".base_url()."Product/detail/".$productId."';
				</script>");

	}


	function detail($productId){
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
		$data['view'] 					= "product/detail";
		$data['customjs'] 				= "product/customjs";
		$data['colors']					= $this->db->query("SELECT * FROM combination_color order by ccName asc")->result();
		$data['product']				= $this->db->query("SELECT a.*, b.categoryName FROM products a inner join product_categories b on a.categoryId = b.categoryId where productId = '".$productId."'")->row();
		$data['product_colors']			= $this->db->query("SELECT a.*,b.ccName FROM product_colors a inner join combination_color b on a.combination_color = b.ccId where productId = '".$productId."'")->result();

		$this->go_to($data);  
	}



	 function getMaxId()
    {
        $data = $this->db->query("SELECT MAX(productId) productId FROM products")->row();
        return ++$data->productId;
    }


    function addcolor($productId){
		$data['csrf'] = array(
	        'name' => $this->security->get_csrf_token_name(),
	        'hash' => $this->security->get_csrf_hash()
			);
		$data['includecss'] 			= '<link rel="stylesheet" href="'.base_url().'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.css">
											<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">';
		$data['includejs'] 				= '<script src="'.base_url().'node_modules/admin-lte/plugins/datatables/jquery.dataTables.js"></script>
									   		<script src="'.base_url().'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.js"></script>
									    	<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
									  		';
		$data['view'] 					= "product/addcolor";
		$data['customjs'] 				= "product/customjs";
		$data['colors']					= $this->db->query("SELECT * FROM combination_color order by ccName asc")->result();
		$data['productId']				= $productId;
		$this->go_to($data);  
    }

    function savecolor($productId){
		$totalgambar = 0;
		$fileName1 = "";
		$fileName2 = "";
		$fileName3 = "";

		$color = $this->input->post("color");

		$config['upload_path']          = './assets/app_assets/product_image/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg|';
		$config['encrypt_name'] 		= TRUE;
		$config['quality']       		= 50;
		$config['maintain_ratio'] 		= TRUE;
		$this->load->library('upload', $config);

		if ($this->upload->do_upload('userfile1'))
		{
			$totalgambar = $totalgambar + 1;
   			$fileName1 	= $this->upload->data('file_name');
		}
		
		if ($this->upload->do_upload('userfile2'))
		{
			$totalgambar = $totalgambar + 1;
			$fileName2 	= $this->upload->data('file_name');
		}
		
		if ($this->upload->do_upload('userfile3'))
		{
			$totalgambar = $totalgambar + 1;
			$fileName3 	= $this->upload->data('file_name');
		}
  
  		if($totalgambar == 0){
  			die("<script>
				alert('Setidaknya pilih satu gambar !!!');
				window.location.href='".base_url()."Product/addcolor/".$productId."';
				</script>");
  		}

  		$this->db->query("INSERT INTO product_colors (productColorId,productId,combination_color,image1,image2,image3) 
  			values ('".$this->getProductColorId()."','".$productId."','".$color."','".$fileName1."','".$fileName2."','".$fileName3."') ");
  		die("<script>
				alert('Proses Simpan Berhasil');
				window.location.href='".base_url()."Product/detail/".$productId."';
				</script>");
    }


    function getProductColorId()
    {
        $data = $this->db->query("SELECT MAX(productColorId) productColorId FROM product_colors")->row();
        if($data->productColorId == ""){
        	return "PC00000000001";
        }else{
        	 return ++$data->productColorId;
    	}
	}
       
}