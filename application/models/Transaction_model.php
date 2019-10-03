<?php
class Transaction_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Usersession');
    }

    function generateAll()
    {
    	return $this->db->query("SELECT * FROM TransactionMember ORDER BY TransactionDate DESC")->result();
    }

    function generateStore()
    {
        $data = $this->db->query("SELECT * FROM store WHERE storeFlag = '1' ORDER BY StoreName ASC")->result();
        return $data;
    }

    function generateMember()
    {
        $data = $this->db->query("SELECT * FROM members WHERE userActive = '1' AND userDeviceId IS NOT NULL ORDER BY userId ASC")->result();
        return $data;
    }
    
    function saveTransaction($data)
    {
        $this->db->insert('TransactionMember', $data);
    }

}