<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Members extends MY_Controller
{

	function index()
	{
		$data['includecss'] = '<link rel="stylesheet" href="' . base_url() . 'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.css">
							<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">';
		$data['includejs'] 	= '<script src="' . base_url() . 'node_modules/admin-lte/plugins/datatables/jquery.dataTables.js"></script>
						   <script src="' . base_url() . 'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.js"></script>
						    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
						  ';
		$data['view'] 			= "members/index";
		$data['customjs'] 		= "members/customjs";
		$this->go_to($data);
	}

	function datamember()
	{
		$data['data'] 		= $this->db->query("SELECT * FROM members ORDER BY UserRegisterDate desc")->result();
		echo json_encode($data);
	}

	function datatransaksi($userId)
	{
		$data['data'] 		= $this->db->query("SELECT * FROM TransactionMember where userId = '" . $userId . "' ")->result();
		echo json_encode($data);
	}

	function detail($userId)
	{
		$data['includecss'] = '<link rel="stylesheet" href="' . base_url() . 'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.css">
							<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">';
		$data['includejs'] 	= '<script src="' . base_url() . 'node_modules/admin-lte/plugins/datatables/jquery.dataTables.js"></script>
						   <script src="' . base_url() . 'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.js"></script>
						    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
						  ';

		$data['info'] 		= $this->db->query("SELECT * from members where userId = '" . $userId . "' ")->row();
		$data['transaksi'] 	= $this->db->query("SELECT * from TransactionMember where userId = '" . $userId . "' ")->row();

		$data['view'] 			= "members/detail";
		$data['customjs'] 		= "members/customjs";
		$this->go_to($data);
	}
}
