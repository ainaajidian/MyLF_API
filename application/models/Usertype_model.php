<?php
class Usertype_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Usersession');
    }

    function generateAll(){
    	return $this->db->query("SELECT * FROM usertypes")->result();
    }

     function getSingle($param){
        return $this->db->query("SELECT * FROM usertypes where type_id = '".$param."' ")->row();
    }


    function check_type_exist($where){
       	$this->db->select('*');
		$this->db->from('usertypes');
        $this->db->where($where);
		$query = $this->db->get(); 
        $totaldata = $query->num_rows();
        if($totaldata > 0){
            return false;
        } return true;
    }

    function check_type_update($id,$desc){
        $query = $this->db->query("SELECT * FROM usertypes where type_description = '".$desc."' and type_id <> '".$id."'  ");
        $totaldata = $query->num_rows();
        if($totaldata > 0){
            return false;
        }  return true;
    }

     function getMaxId(){
        $data = $this->db->query("SELECT MAX(type_id) type_id from usertypes  ")->row();
        return ++$data->type_id;
    }

    function saveusertype($data){
        $this->db->insert('usertypes', $data);
    }

      function updateusertype($data,$kondisi){
        $this->db->where($kondisi);
        $this->db->update('usertypes', $data);
    }

    function deleteuser($type_id){
        $this->db->query("DELETE FROM usertypes where type_id = '".$type_id."' ");
    }

    function generateUsermodule($type_id){
         return $this->db->query("SELECT module_type,b.access_id,c.module_name 
                                  from usertypes a inner join modules_access b on 
                                  a.type_id = b.usertype inner join modules c on b.module_id = c.module_id
                                  where b.usertype = '".$type_id."' order by module_type asc
                                  ")->result();
    }
    function saveAccess($data){
        $this->db->insert('modules_access', $data);
    }

     function getMaxAccessId(){
        $data = $this->db->query("SELECT MAX(access_id) access_id from modules_access  ")->row();
        return ++$data->access_id;
    }
    function revokeAccess($id){
        $this->db->query("DELETE FROM modules_access where access_id = '".$id."' ");
    }
}