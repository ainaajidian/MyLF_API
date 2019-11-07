<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Loginform extends Ci_Controller
{

	public $loginmodel;
	public $_username;
	public $_password;

	function __construct()
	{
		parent::__construct();
		$this->load->model('Usersession');
		$this->load->model('Login_model');

		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");
	}

	public function index()
	{
		if ($this->Usersession->getUsername()) {
			redirect("Loginform/goToportal", "refresh");
		}

		$data['csrf'] = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['sitesetting'] = $this->db->query("SELECT * FROM sitesetting where sitesettingid = 'SET001' ")->row();

		$this->load->view('loginform', $data);
	}

	function proses()
	{
		$username = $this->security->xss_clean($this->input->post("username"));
		$password = $this->security->xss_clean($this->input->post("password"));

		$checkresult = $this->Login_model->checkAccount($username, $password);

		if (!$checkresult) {
			$this->session->set_flashdata('message', 'Username or Password is incorrect');
			redirect("Loginform/index", "refresh");
		} else {
			$this->_username = $username;
			$this->_password = $password;
			$this->generateSession($checkresult);
		}
	}

	function generateSession($logindata)
	{
		$this->session->set_userdata(json_decode(json_encode($logindata), True));
		redirect("Loginform/goToportal", "refresh");
	}

	function goToportal()
	{
		if (!$this->Usersession->getUsername()) {
			$this->session->set_flashdata('message', 'You need to login first');
			redirect("Loginform", "refresh");
		}

		$this->session->unset_userdata('parent_module');
		$data['module'] = $this->Login_model->populateModule();
		$this->load->view("afterlogin", $data);
	}

	function mainpage($module_id)
	{
		$this->session->set_userdata('parent_module', "");
		$this->session->set_userdata('parent_module', $module_id);
		redirect("welcome", "refresh");
	}

	function unsetmenu()
	{ unset($_SESSION['menu']); }
}
