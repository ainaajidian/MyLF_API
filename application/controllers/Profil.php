<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profil extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Usersession');
		$this->load->model('Profil_model');
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");
	}

	public function index()
	{
		$data['csrf'] = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['view'] = "profil/index";
		$this->go_to($data);
	}

	function update()
	{
		$username 		= $this->Usersession->getUsername();
		$email 			= $this->security->xss_clean($this->input->post("email"));
		$fullname 		= $this->security->xss_clean($this->input->post("fullname"));
		$placeofbirth 	= $this->security->xss_clean($this->input->post("placeofbirth"));
		$dateofbirth 	= $this->security->xss_clean($this->input->post("dateofbirth"));
		$phone 			= $this->security->xss_clean($this->input->post("phone"));
		$address 		= $this->security->xss_clean($this->input->post("address"));
		$gender 		= $this->security->xss_clean($this->input->post("gender"));


		$data = array(
			"email" => $email,
			"placeofbirth" => $placeofbirth,
			"dateofbirth" => $dateofbirth,
			"TelpNo" => $phone,
			"gender" => $gender,
			"address" => $address,
			"fullname" => $fullname
		);

		$goUpdate 		=	$this->Profil_model->update(array("username" => $username), $data);
		if ($goUpdate) {
			$this->session->set_userdata(json_decode(json_encode($_POST), True));
		}
	}
}