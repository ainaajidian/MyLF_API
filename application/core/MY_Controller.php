<?php
class MY_Controller extends CI_Controller
{
    function __construct()
    {
		parent::__construct();
	    $this->load->model('Usersession');

		if(!$this->Usersession->getUsername()){
                $this->session->set_flashdata('message', 'You need to login first');
             redirect("Loginform","refresh");
        }
	}

    function go_to($data)
    {
        $data['username']       = $this->Usersession->getUsername();
        $data['fullname']       = $this->Usersession->getFullname();
        $data['address']        = $this->Usersession->getAddress();
        $data['telp']           = $this->Usersession->getTelp();
        $data['pict']           = $this->Usersession->getProfilpict();
        $data['dob']            = $this->Usersession->getDateofbirth();
        $data['pob']            = $this->Usersession->getPlaceofbirth();
        $data['gender']         = $this->Usersession->getGender();
        $data['email']          = $this->Usersession->getEmail();
        $data['usertype']       = $this->Usersession->getUsertype();
        $data['usertypedesc']   = $this->Usersession->getUsertypedesc();
        $data['loginid']        = $this->Usersession->getLoginid();
        $data['sitesetting']    = $this->db->query("SELECT * FROM sitesetting where sitesettingid = 'SET001' ")->row();
        $data['menu']           = $this->populatemainmenu();
        $data['sidebar']        = $this->db->query("SELECT value  from sitesetting where sitesettingid = 'SET002' ")->row();
        $data['favicon']        = $this->db->query("SELECT value  from sitesetting where sitesettingid = 'SET003' ")->row();

        $this->load->view('template/master',$data);
    }

    function populatemainmenu(){
            $user_type      = $this->Usersession->getUsertype();
            $module_parent  = $_SESSION['parent_module'];
            $data = $this->db->query("SELECT a.* FROM modules a inner join modules_access b on a.module_id = b.module_id 
                                      where usertype = '".$user_type."' and module_parent = '".$module_parent."' and a.module_flag = 1 order by module_name asc

                ")->result();
            return $data;

    }


}