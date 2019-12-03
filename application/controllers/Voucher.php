<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Voucher extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Voucher_model');
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
		$data['customjs'] 				= "voucher/customjs";
		$data['view'] 					= "voucher/index";
		$this->go_to($data);
	}

	//Get Color
	function getVoucher()
	{
		$data['data'] = $this->Voucher_model->generateAll();
		echo json_encode($data);
	}

	//Deactive Data
    function deactivate($voucherId)
    {
        $data = array("voucherFlag" => 0);
        $kondisi = array("voucherId" => $voucherId);
        $this->Voucher_model->status($data, $kondisi);
    }

    //Restore Data
    function restore($voucherId)
    {
        $data = array("voucherFlag" => 1);
        $kondisi = array("voucherId" => $voucherId);
        $this->Voucher_model->status($data, $kondisi);
    }

    //Delete data
    function deleteForever($voucherId)
    {
        $this->Voucher_model->deleteForever($voucherId);
    }

	//Save Data
	function saveVoucher()
	{
		$kode = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 10);

		$voucherId			= $this->input->post("voucherId");
		$voucherCode 		= $this->input->post("voucherCode");
		$voucherName 		= $this->input->post("voucherName");
		$discountType	 	= $this->input->post("discountType");
		$besarNominal 		= $this->input->post("besarNominal");
		$besarPersen 		= $this->input->post("besarPersen");

		if ($discountType == 'Nominal') 
		{
			$datasave = array(
							"voucherCode" 			=> $kode,
							"voucherName" 			=> $voucherName,
							"discountType"	 		=> $discountType,
							"discountVal" 			=> $besarNominal,
							"voucherFlag"			=> 1,
							"voucherId"				=> $this->Voucher_model->getMaxId()
						 );

			$this->Voucher_model->saveVoucher($datasave, $voucherId);

			die("<script>
				alert('Add Voucher Success');
				window.location.href='" . base_url() . "Voucher';
				</script>");
		}
		else
		{
			$datasave = array(
							"voucherCode" 			=> $kode,
							"voucherName" 			=> $voucherName,
							"discountType"	 		=> $discountType,
							"discountVal" 			=> $besarPersen,
							"voucherFlag"			=> 1,
							"voucherId"				=> $this->Voucher_model->getMaxId()
						 );

			$this->Voucher_model->saveVoucher($datasave, $voucherId);

			die("<script>
				alert('Add Voucher Success');
				window.location.href='" . base_url() . "Voucher';
				</script>");	
		}
		
	}

	//Update Data
	function updateVoucher()
	{
		
		$discountType	 	= $this->input->post("discountType");
		$besarNominal 		= $this->input->post("besarNominal");
		$besarPersen 		= $this->input->post("besarPersen");
		$voucherId 			= $this->input->post("voucherId");

		if ($discountType == 'Nominal') 
		{
			$dataupdate = array("discountVal" 	=> $besarNominal,
				                "voucherId"     => $voucherId);

            $this->Voucher_model->updateVal($dataupdate, $voucherId);

            die("<script>
				alert('Update Voucher Success');
				window.location.href='" . base_url() . "Voucher';
				</script>");	
        }
		else if ($discountType == 'Percent')
		{
			$dataupdate = array("discountVal" 	=> $besarPersen,
				                "voucherId"     => $voucherId, $voucherId);

            $this->Voucher_model->updateVal($dataupdate, $voucherId);

			die("<script>
				alert('Update Voucher Success');
				window.location.href='" . base_url() . "Voucher';
				</script>");	
		}
	}
}
