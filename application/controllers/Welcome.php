<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends MY_Controller
{
	function __construct()

	{

		parent::__construct();
		$this->load->model('Usersession');
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");
	}


	function index()
	{

		$data['view'] = "testview";
		$this->go_to($data);
	}


	function logout()
	{


		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(
				session_name(),
				'',
				time() - 42000,
				$params["path"],
				$params["domain"],
				$params["secure"],
				$params["httponly"]
			);
		}
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");
		// Finally, destroy the session.
		//session_destroy();
		$_SESSION = array();

		unset($_SESSION['userid']);
		unset($_SESSION['username']);
		unset($_SESSION['Fullname']);
		unset($_SESSION['type_description']);
		unset($_SESSION['usertype']);
		unset($_SESSION['parent_module']);

		$this->session->unset_userdata('userid');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('Fullname');
		$this->session->unset_userdata('type_description');
		$this->session->unset_userdata('usertype');
		$this->session->unset_userdata('parent_module');

		$this->session->sess_destroy();

		redirect("Loginform", "refresh");
	}
}
