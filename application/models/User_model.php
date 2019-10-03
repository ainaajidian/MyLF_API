<?php
class User_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Usersession');
    }

    function generateAll(){
    	return $this->db->query("SELECT * FROM users where usertype <> 'TP001'")->result();
    }


    function check_user_exist($where){
       	$this->db->select('*');
		$this->db->from('users');
        $this->db->where($where);
		$query = $this->db->get(); 
        $totaldata = $query->num_rows();
        if($totaldata > 0){
            return false;
        } return true;
    }

     function getMaxId(){
        $data = $this->db->query("SELECT MAX(userid) userid from users  ")->row();
        return ++$data->userid;
    }

    function saveuser($data){
        $this->db->insert('users', $data);
    }

      function updateUser($data,$kondisi){
        $this->db->where($kondisi);
        $this->db->update('users', $data);
    }

 function deleteuser($userid){
        $this->db->query("DELETE FROM users where userid = '".$userid."' ");
        $this->db->query("DELETE FROM biodata where login_id = '".$userid."' ");

    }

}