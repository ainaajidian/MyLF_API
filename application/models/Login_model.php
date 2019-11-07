<?php

class Login_model extends CI_Model 
{

	public $username="";
    public $password="";
    public $dataUser="";

    function __construct()

    {
        parent::__construct();
        $this->load->model('Usersession');
    }

	function checkAccount($usernameInput="",$passwordInput="")
	{
		$this->username = $usernameInput;
		$this->password = $passwordInput;

		if($this->dbQueries())
		{ return $this->getUserdata(); }

		else
		{ return false; }
	}

	function dbQueries()
	{

		$this->db->trans_start();

		$query  = $this->db->query("SELECT * FROM  users 
									WHERE username = '".$this->username."' 
									AND password = '".md5($this->password)."' AND user_flag = 1 ");

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{ return false; }
		else
		{
			if($query->num_rows() > 0) 
			{ return true; }

			else
			{ return false; }
		}
	}

	function getUserdata()
	{
		$data = $this->db->query("SELECT a.*, b.email, username, c.type_description, b.usertype, b.userid  
                                  FROM biodata a 
                                  RIGHT JOIN users b ON a.login_id = b.userid  
                                  INNER JOIN usertypes c ON b.usertype = c.type_id 
                                  WHERE username = '".$this->username."' ")->row();

		return $data;
	}

	function populateModule()
	{
		$query = $this->db->query("SELECT a.* FROM modules a 
								   LEFT JOIN modules_access b ON a.module_id = b.module_id 
								   WHERE b.usertype = '".$this->Usersession->getUsertype()."'
								   AND module_type = 1 AND module_flag = 1 ")->result();

		return $query;
	}
}