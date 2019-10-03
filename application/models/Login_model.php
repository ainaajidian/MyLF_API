<?php

class Login_model extends CI_Model {



	public $username="";
    public $password="";
    public $dataUser="";





    function __construct()

    {

        parent::__construct();

        $this->load->model('Usersession');



    }



	function checkAccount($usernameInput="",$passwordInput=""){

		$this->username = $usernameInput;

		$this->password = $passwordInput;

		if($this->dbQueries()){

			return $this->getUserdata();

		}else{

			return false;

		}

	}



	function dbQueries(){

		$this->db->trans_start();

		$query = $this->db->query("SELECT * FROM  users where username = '".$this->username."' and password = '".md5($this->password)."' and user_flag = 1 ");

		$this->db->trans_complete();



		if ($this->db->trans_status() === FALSE)

		{

			return false;

		}else{

				if($query->num_rows() > 0) {

					return true;

				}else{

					return false;

				}

		}

	}



	function getUserdata(){

	 $data = $this->db->query("SELECT a.*,b.email,username,c.type_description,b.usertype,b.userid  
                                    from biodata a right join users b on a.login_id = b.userid  
                                    inner join usertypes c on b.usertype = c.type_id where username = '".$this->username."' ")->row();

		return $data;

	}



	function populateModule(){

		$query = $this->db->query("SELECT a.* FROM modules a 
									left join modules_access b  on a.module_id = b.module_id where b.usertype = '".$this->Usersession->getUsertype()."'
									and module_type = 1 and module_flag = 1

									 ")->result();

		return $query;

	}



}