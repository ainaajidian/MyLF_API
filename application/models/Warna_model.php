<?php
class Warna_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Usersession');
    }

    function generateAll(){
    	return $this->db->query("SELECT * FROM color order by colorID asc")->result();
    }

    function countDataByID($id){
    	return $this->db->query("SELECT * FROM color where colorId = '".$id."' ")->num_rows();
    }

   function saveWarna($data){
        $this->db->insert('color', $data);
    }
    function delete($id){
    	$this->db->query("DELETE from color where colorid = '#".$id."' ");
    }


      function updateWarna($data,$kondisi){
        $this->db->where($kondisi);
        $this->db->update('color', $data);
    }

}