<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends MY_Controller
{

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
		$data['includecss'] = '<link rel="stylesheet" href="' . base_url() . 'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.css">
							<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">';
		$data['includejs'] 	= '<script src="' . base_url() . 'node_modules/admin-lte/plugins/datatables/jquery.dataTables.js"></script>
						   <script src="' . base_url() . 'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.js"></script>
						    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
						  ';
		$data['view'] 					= "product/index";
		$data['customjs'] 				= "product/customjs";

		$this->go_to($data);
	}


	function getProduct()
	{
		$data['data']	= $this->db->query("SELECT a.productId,a.productErpCode, a.productName, b.categoryName, 
											CONCAT('Rp ', FORMAT(productPrice, 0)) AS productPrice,
											a.isHot, a.isNew, a.productFlag
											FROM products a 
											INNER JOIN product_categories b ON a.categoryId = b.categoryId")->result();
		echo json_encode($data);
	}

	function getChildCategory($parentCategoryID)
	{
		$data	= $this->db->query("SELECT * FROM product_categories 
										WHERE parentCategoryID ='" . $parentCategoryID . "' 
										ORDER BY categoryName ASC")->result();
		echo json_encode($data);
	}


	function add()
	{
		$data['csrf'] = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);
		$data['includecss'] = '<link rel="stylesheet" href="' . base_url() . 'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.css">
							<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">';
		$data['includejs'] 	= '<script src="' . base_url() . 'node_modules/admin-lte/plugins/datatables/jquery.dataTables.js"></script>
						   <script src="' . base_url() . 'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.js"></script>
						    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
						  ';
		$data['view'] 					= "product/add";
		$data['customjs'] 				= "product/customjs";
		$data['categories']				= $this->db->query("SELECT * FROM product_categories where (parentCategoryID = '' or parentCategoryID is null) order by categoryName asc")->result();
		$data['child_categories']		= $this->db->query("SELECT * FROM product_categories where (parentCategoryID <> '' or parentCategoryID is not null) order by categoryName asc")->result();
		$data['sizes'] 					= $this->db->query("SELECT * FROM size where TipeProduct = 'C_00001' ")->result();

		foreach ($data['sizes'] as $key) {
			$info = explode(";", $key->SizeDescription);
			$sizes[] = array( "SizeID" => $key->SizeID, "Keterangan" =>  " Ukuran " .$info[0]. " Berat ".$info[1]. " KG");
		}

		$data['sizes'] = $sizes;
		$this->go_to($data);
	}

	function saveheader()
	{
		$productId 	 			= $this->getMaxId();
		$productName 			= $this->input->post("productName");
		$productPrice 			= $this->input->post("productPrice");
		$productCategory 		= $this->input->post("productCategory");
		$productFlag 			= $this->input->post("productFlag");
		$childproductCategory 	= $this->input->post("childproductCategory");
		$productErpCode 		= $this->input->post("productErpCode");
		$uomCode 				= $this->input->post("uomCode");
		$productSize			= ($this->input->post("productSize") != null) ? $this->input->post("productSize") : "-" ;

		if ($productFlag == "1") {
			$this->db->query("INSERT INTO products 
				(productId,productName,isNew,isHot,categoryId,productFlag,productPrice,productDescription,childCategoryId,productErpCode,UOMCode)
				VALUES
				('" . $productId . "','" . $productName . "',0,1,'" . $productCategory . "',0,'" . $productPrice . "','" . $productSize . "','" . $childproductCategory . "','" . $productErpCode . "','" . $uomCode . "')
				 ");
		} else if ($productFlag == "2") {
			$this->db->query("INSERT INTO products 
						(productId,productName,isNew,isHot,categoryId,productFlag,productPrice,productDescription,childCategoryId,productErpCode,UOMCode)
						VALUES
						('" . $productId . "','" . $productName . "',1,0,'" . $productCategory . "',0,'" . $productPrice . "','" . $productSize . "','" . $childproductCategory . "','" . $productErpCode . "','" . $uomCode . "')
						 ");
		} else {
			$this->db->query("INSERT INTO products 
						(productId,productName,isNew,isHot,categoryId,productFlag,productPrice,productDescription,childCategoryId,productErpCode,UOMCode)

						VALUES
						('" . $productId . "','" . $productName . "',0,0,'" . $productCategory . "',0,'" . $productPrice . "','" . $productSize . "','" . $childproductCategory . "','" . $productErpCode . "','" . $uomCode . "')
						 ");
		}
		die("<script>
				alert('Proses Simpan Berhasil');
				window.location.href='" . base_url() . "Product/detail/" . $productId . "';
				</script>");
	}

	function active($productId)
	{
		$this->db->query("UPDATE products SET productFlag = 1 WHERE productId = '".$productId."' ");
		die("<script>
			alert('Active Product Success');
			window.location.href='" . base_url() . "Product';
			</script>");
	}

	function deactive($productId)
	{
		$this->db->query("UPDATE products SET productFlag = 0 WHERE productId = '".$productId."' ");
		die("<script>
			alert('Deactive Product Success');
			window.location.href='" . base_url() . "Product';
			</script>");
	}

	function deleteProduct($productId)
	{
		$this->db->query("DELETE products WHERE productId = '".$productId."' ");
		die("<script>
			alert('Deactive Product Success');
			window.location.href='" . base_url() . "Product';
			</script>");
	}

	function detail($productId)
	{
		$data['csrf'] = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);
		$data['includecss'] = '<link rel="stylesheet" href="' . base_url() . 'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.css">
							<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">';
		$data['includejs'] 	= '<script src="' . base_url() . 'node_modules/admin-lte/plugins/datatables/jquery.dataTables.js"></script>
						   	   <script src="' . base_url() . 'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.js"></script>
						       <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
						  ';
		$data['view'] 					= "product/detail";
		$data['customjs'] 				= "product/customjs";
		$data['colors']					= $this->db->query("SELECT * FROM combination_color ORDER BY ccName ASC")->result();
		$data['product']				= $this->db->query("SELECT a.*, b.categoryName FROM products a
															INNER JOIN product_categories b ON a.categoryId = b.categoryId 
															WHERE productId = '" . $productId . "'")->row();
		$data['product_colors']			= $this->db->query("SELECT DISTINCT a.*,b.ccName FROM product_colors a 
															INNER JOIN combination_color b on a.combination_color = b.ccId
															WHERE productId = '" . $productId . "'")->result();
		$data['ukuran']					= $this->db->query("SELECT * FROM ProductSize where ProductId = '" . $productId . "'")->result();
		$categoryId 					= $data['product']->categoryId;
		$data['sizes']					= $this->db->query("SELECT * FROM size where TipeProduct = '" . $categoryId . "' ")->result();
		$data['ProductSizes']			= $this->db->query("SELECT ccName,SizeDescription,ProductSizeId,IFNULL(c.StockQty,0) StockQty   
														from products a 
														inner join product_colors pc on a.productId = pc.productId 
														inner join combination_color cc on combination_color = ccId 
														inner join ProductSize ps on  ps.productId = a.productId and pc.productColorId = ps.productColorId
														inner join size b on ps.SizeID = b.SizeID 
														left join TransactionItemSalesStock c on b.SizeID = c.SizeID 
														and a.productID = c.productID 
														and pc.productColorId = c.ProductColorID
														and storeID ='".$this->Usersession->getUsername()."'
														WHERE a.productId = '" . $productId . "'
														group by ccName,SizeDescription,ProductSizeId  ")->result();
		$this->go_to($data);
	}

	function getOutlet(){
		$curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://eproc.rpgroup.co.id/mylfapi/userOutlet/".$this->Usersession->getUsername(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_SSL_VERIFYPEER=>FALSE,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
            ),
		));
		$response = curl_exec($curl);
        $err = curl_error($curl);

        // print_r($response);die();

		curl_close($curl);
		$response = json_decode($response,true);
		return $response['OutletCode'];

	}

	function deleteColor($productId, $productColorId)
	{
		$image = $this->db->query("SELECT image1, image2, image3 FROM product_colors 
											WHERE productId = '" . $productId . "'
											AND productColorId = '" . $productColorId . "'")->result();

		$delete = $this->db->query("DELETE FROM product_colors 
					 				WHERE productId = '" . $productId . "' 
					 				AND productColorId = '" . $productColorId . "'");

		foreach ($image as $dataimage) 
		{
			if ($dataimage->image1 != '') 
				{ unlink('./assets/app_assets/product_image/' . $dataimage->image1); }
			else
				{ }

			if ($dataimage->image2 != '') 
				{ unlink('./assets/app_assets/product_image/' . $dataimage->image2); }
			else
				{ }

			if ($dataimage->image3 != '') 
				{ unlink('./assets/app_assets/product_image/' . $dataimage->image3); }
			else
				{ }
		}

		die("<script>
		alert('Proses Hapus Berhasil');
		window.location.href='" . base_url() . "Product/detail/" . $productId . "';
		</script>");
	}

	function getMaxId()
    {
		$data = $this->db->query("SELECT MAX(productId) productId FROM products")->row();
		if ($data->productId == "") {
			return "P00000000001";
		} else {
			return ++$data->productId;
		}
        return ++$data->productId;
    }

	function addcolor($productId)
	{
		$data['csrf'] = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);
		$data['includecss'] 			= '<link rel="stylesheet" href="' . base_url() . 'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.css">
											<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">';
		$data['includejs'] 				= '<script src="' . base_url() . 'node_modules/admin-lte/plugins/datatables/jquery.dataTables.js"></script>
									   		<script src="' . base_url() . 'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.js"></script>
									    	<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
									  		';
		$data['view'] 					= "product/addcolor";
		$data['customjs'] 				= "product/customjs";
		$data['colors']					= $this->db->query("SELECT * FROM combination_color ORDER BY ccName ASC")->result();
		$data['productId']				= $productId;
		$this->go_to($data);
	}

	function savecolor($productId)
	{
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

		if ($this->upload->do_upload('userfile1')) {
			$totalgambar = $totalgambar + 1;
			$fileName1 	= $this->upload->data('file_name');
		}

		if ($this->upload->do_upload('userfile2')) {
			$totalgambar = $totalgambar + 1;
			$fileName2 	= $this->upload->data('file_name');
		}

		if ($this->upload->do_upload('userfile3')) {
			$totalgambar = $totalgambar + 1;
			$fileName3 	= $this->upload->data('file_name');
		}

		if ($totalgambar == 0) {
			die("<script>
				alert('Setidaknya pilih satu gambar !!!');
				window.location.href='" . base_url() . "Product/addcolor/" . $productId . "';
				</script>");
		}
		$colorId = $this->getProductColorId();
		$this->db->query("INSERT INTO product_colors (productColorId,productId,combination_color,image1,image2,image3) 
							VALUES ('" .$colorId  . "','" . $productId . "','" . $color . "','" . $fileName1 . "','" . $fileName2 . "','" . $fileName3 . "') ");
		$dataProduct = $this->db->query("SELECT * from products where productId = '".$productId."'")->row();
		if(($dataProduct->categoryId == "C_00001") || ($dataProduct->categoryId == "C_00003") ){
			if ($this->getProductSizeId() == "1") {
				$maxId = "PSZE000000001";
			} else {
				$maxId = $this->getProductSizeId();
			}
			$this->db->query("INSERT INTO ProductSize (ProductSizeId,productId,SizeID,productColorID) 
			values ('".$maxId."','".$dataProduct->productId."', '".$dataProduct->productDescription."','".$colorId."' )  ");

		}else if($dataProduct->categoryId == "C_00007"){
			$ShoeSizes = $this->db->query("SELECT * FROM size where TipeProduct = 'C_00007' ")->result();
			$dataProduct = $this->db->query("SELECT * from products where productId = '".$productId."'")->row();
			foreach ($ShoeSizes as $shoesize) {
				if ($this->getProductSizeId() == "1") {
					$maxId = "PSZE000000001";
				} else {
					$maxId = $this->getProductSizeId();
				}
				$this->db->query("INSERT INTO ProductSize (ProductSizeId,productId,SizeID,productColorID) 
				values ('".$maxId."','".$dataProduct->productId."', '".$shoesize->SizeID."','".$colorId."' )  ");
			}
		}

		die("<script>
				alert('Proses Simpan Berhasil');
				window.location.href='" . base_url() . "Product/detail/" . $productId . "';
				</script>");
	}

	function getProductColorId()
	{
		$data = $this->db->query("SELECT MAX(productColorId) productColorId FROM product_colors")->row();
		if ($data->productColorId == "") {
			return "PC00000000001";
		} else {
			return ++$data->productColorId;
		}
	}

	function addstok($productId, $categoryId)
	{
		$data['infoProduct'] 	= $this->db->query("SELECT * from products where productId = '" . $productId . "'")->row();
		$data['infoCategory'] 	= $this->db->query("SELECT * from product_categories where categoryId = '" . $categoryId . "'")->row();
		$data['infoColor'] 		= $this->db->query("SELECT * from product_colors a inner join combination_color cc on a.combination_color = cc.ccId where productId = '" . $productId . "'")->result();
		$data['sizes']			= $this->db->query("SELECT * FROM size a inner join ProductSize b on a.SizeID = b.SizeID where productId = '" . $productId . "' ")->result();



		$data['view'] 					= "product/addstok";
		$data['customjs'] 				= "product/customjs";
		$data['productId']				= $productId;
		$this->go_to($data);
	}

	function savestok($productId, $categoryId)
	{
		$storeId 		= $this->input->post("storeId");
		$productColorId = $this->input->post("productColorId");
		if($categoryId != "C_00001"){
			$sizes 			= $this->input->post("sizes");
		}else{
			$dataProduct = $this->db->query("SELECT * FROM products where productId = '".$productId."' ")->row();
			$sizes = $dataProduct->productDescription;
		}

		$maxId 			= "";
		$stok 			= $this->input->post("stok");

		if ($storeId == "") {
			echo "Harap ulang Proses";
			die();
		}

		if ($this->getStokId() == "1") {
			$maxId = "STOK00000000000001";
		} else {
			$maxId = $this->getStokId();
		}

		$this->db->query("INSERT INTO TransactionItemSalesStock 
			(SalesStockId,storeID,productID,CategoryID,productColorId,StockQTY,SizeID,CreatedBy,CreatedDate) values 
			('" . $maxId . "','" . $storeId . "','" . $productId . "','" . $categoryId . "','" . $productColorId . "','" . $stok . "','" . $sizes . "','" . $this->Usersession->getUsername() . "',NOW())");
	}

	function getStokId()
	{
		$data = $this->db->query("SELECT MAX(SalesStockId) SalesStockId FROM TransactionItemSalesStock")->row();
		return ++$data->SalesStockId;
	}

	function getImage($productColorId)
	{
		$data = $this->db->query("SELECT * FROM product_colors where productColorId = '" . $productColorId . "'")->row();
		echo json_encode($data);
	}

	function insertDummystock()
	{
		$dataoutlet = $this->db->query("SELECT * FROM store");
		$totaldataoutlet = $dataoutlet->num_rows();
		foreach ($dataoutlet->result() as $key) {
			if ($this->getStokId() == "1") {
				$maxId = "STOK00000000000001";
			} else {
				$maxId = $this->getStokId();
			}
			$this->db->query("INSERT INTO TransactionItemSalesStock 
			(SalesStockId,storeID,productID,CategoryID,productColorId,StockQTY,SizeID,CreatedBy,CreatedDate) values 
			('" . $maxId . "','" . $key->storeName . "','p_00025','C_00001','PC00000000027','" . rand(1, 5) . "','SZ0000003','" . $this->Usersession->getUsername() . "',NOW())");
		}
	}

	function saveSize($productId)
	{
		if ($this->getProductSizeId() == "1") {
			$maxId = "PSZE000000001";
		} else {
			$maxId = $this->getProductSizeId();
		}
		$SizeID 		= $this->input->post("SizeID");
		$productColor 	= $this->input->post("productColor");
		$this->db->query("INSERT INTO ProductSize (ProductSizeId,ProductId,SizeID,productColorId) values ('" . $maxId . "','" . $productId . "','" . $SizeID . "','" . $productColor . "')");
		die("<script>
		alert('Proses Simpan Berhasil');
		window.location.href='" . base_url() . "Product/detail/" . $productId . "';
		</script>");
	}

	function deleteSize($productId, $ProductSizeId)
	{
		$this->db->query("DELETE from ProductSize where ProductSizeId = '" . $ProductSizeId . "'");
		die("<script>
		alert('Proses Hapus Berhasil');
		window.location.href='" . base_url() . "Product/detail/" . $productId . "';
		</script>");
	}

	function getProductSizeId()
	{
		$data = $this->db->query("SELECT MAX(ProductSizeId) ProductSizeId FROM ProductSize")->row();
		return ++$data->ProductSizeId;
	}

	function saveDefaultImage($image, $productId)
	{
		$this->db->query("UPDATE products set productImage = '" . $image . "' where productId = '" . $productId . "'  ");
	}
	function saveQtyTest()
	{
		$ProductSizeId = $this->input->post("productsizeid");
		$qty = $this->input->post("qty");
		$storeId = $this->input->post("storeId");
		for($x=0;$x<count($ProductSizeId);$x++){
			$dataProductSize = $this->db->query("SELECT * FROM ProductSize where ProductSizeId = '".$ProductSizeId[$x]."'")->row();
			$stock = $this->db->query("SELECT * FROM TransactionItemSalesStock 
									where productID = '".$dataProductSize->productId."' 
									and SizeID = '".$dataProductSize->SizeID."' 
									and ProductColorID = '".$dataProductSize->productColorId."'
									and storeID = '".$storeId."' 
									");

			if($stock->num_rows() > 0){
				$this->db->query("UPDATE TransactionItemSalesStock set StockQty = '".$qty[$x]."' 
								where productID = '".$dataProductSize->productId."' 
								and SizeID = '".$dataProductSize->SizeID."' 
								and ProductColorID = '".$dataProductSize->productColorId."'  
								and storeID = '".$storeId."' 
								");
			} 
			else 
			{
				if ($this->getStokId() == "1") {
					$maxId = "STOK00000000000001";
				} else {
					$maxId = $this->getStokId();
				}

				$dataInsert = array(
						"SalesStockId" => $maxId,
						"storeID" => $storeId,
						"productID" =>$dataProductSize->productId,
						"ProductColorID" => $dataProductSize->productColorId,
						"StockQty" => $qty[$x],
						"SizeID" => $dataProductSize->SizeID,
						"CreatedBy" =>$this->Usersession->getUsername()
					);
				$this->db->insert("TransactionItemSalesStock",$dataInsert);
				
			}
		}
		die("<script>
		alert('Add Stock Success');
		window.location.href='" . base_url() . "Product/detail/" . $dataProductSize->productId . "';
		</script>");
	}
}
