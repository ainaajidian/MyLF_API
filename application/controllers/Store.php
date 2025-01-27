<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Store extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Store_model');
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
		$data['customjs'] 				= "store/customjs";
		$data['view'] 					= "store/index";
		$data['store_module']		= $this->Store_model->generateAll();
		$data['provinces']			= $this->getProvince();
		//$data['cities']				= $this->getCity();
		$this->go_to($data);
	}

	//Get Color
	function getStore()
	{
		$data['data'] = $this->Store_model->generateAll();
		echo json_encode($data);
	}

	//Deactive Data
	function deactivate($storeId)
	{
		$data = array("storeFlag" => 0);
		$kondisi = array("storeId" => $storeId);
		$this->Store_model->updateStore($data, $kondisi);
	}

	//Restore Data
	function restore($storeId)
	{
		$data = array("storeFlag" => 1);
		$kondisi = array("storeId" => $storeId);
		$this->Store_model->updateStore($data, $kondisi);
	}

	//Delete data
	function deleteForever($storeId)
	{
		$this->Store_model->deleteForever($storeId);
	}

	//Save Data
	function saveStore()
	{
		$storeName 			= $this->input->post("storeName");
		$storeMall	 		= $this->input->post("storeMall");
		$storeAddress 		= $this->input->post("storeAddress");
		$storeDetail		= $this->input->post("storeDetail");
		$storeLongitude 	= $this->input->post("storeLongitude");
		$storeLatitude 		= $this->input->post("storeLatitude");
		$storeId 			= $this->input->post("storeId");
		$provinceId			= $this->input->post("province");
		$cityId				= $this->input->post("city");
		$subdistrictId		= $this->input->post("subdistrict");

		$datasave = array(
			"storeName" 			=> $storeName,
			"storeMall" 			=> $storeMall,
			"storeAddress"	 		=> $storeAddress,
			"storeDetail" 			=> $storeDetail,
			"storeLongitude"		=> $storeLongitude,
			"storeLatitude"			=> $storeLatitude,
			"storeFlag"				=> 1,
			"storeId"   			=> $this->Store_model->getMaxId(),
			"storeProvinceId"		=> $provinceId,
			"storeCityId"			=> $cityId,
			"storeSubdistrictId" 	=> $subdistrictId
		);

		$this->Store_model->saveStore($datasave, $storeId);

		die("<script>
			alert('Add Store Success');
			window.location.href='" . base_url() . "Store';
			</script>");
	}

	//Update Data
	function updateStore()
	{
		$storeName 			= $this->input->post("storeName");
		$storeMall	 		= $this->input->post("storeMall");
		$storeAddress 		= $this->input->post("storeAddress");
		$storeDetail		= $this->input->post("storeDetail");
		$storeLongitude 	= $this->input->post("storeLongitude");
		$storeLatitude 		= $this->input->post("storeLatitude");
		$storeId 			= $this->input->post("storeId");
		$provinceId			= $this->input->post("editProvince");
		$cityId				= $this->input->post("editCity");
		$subdistrictId		= $this->input->post("editsubdistrict");

		$data = array(
			"storeName" 		=> $storeName,
			"storeMall" 		=> $storeMall,
			"storeAddress" 		=> $storeAddress,
			"storeDetail" 		=> $storeDetail,
			"storeLongitude"	=> $storeLongitude,
			"storeLatitude"		=> $storeLatitude,
			"storeProvinceId"		=> $provinceId,
			"storeCityId"			=> $cityId,
			"storeSubdistrictId" 	=> $subdistrictId
		);

		$kondisi	= array("storeId"	=> $storeId);

		$this->Store_model->updateStore($data, $kondisi);

		die("<script>
			alert('Update Store Success');
			window.location.href='" . base_url() . "Store';
			</script>");
	}

	function getProvince()
	{
		$data = $this->db->query("SELECT * FROM province ORDER BY provinceName ASC")->result();
		return $data;
	}

	function getCity($provinceId)
	{

		$data = $this->db->query("SELECT * FROM city WHERE provinceId = '" . $provinceId . "' ORDER BY cityName ASC ")->result();
		echo json_encode($data);
	}

	function getSubdistrict($cityID = "")
	{

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://pro.rajaongkir.com/api/subdistrict?city=$cityID",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"key: 5882027194d829e46c2cdd55f8875dde"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			echo $response;
		}
	}
}
