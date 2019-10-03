<?php
class Sitesetting_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    
    function save_setting($data,$where){
    	$this->db->where($where);
        $this->db->update('sitesetting', $data);
    }

}