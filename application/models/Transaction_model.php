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
    	return $this->db->query("SELECT UserId, TransactionId, CONCAT('Rp ', FORMAT(Total, 0)) AS Total, TransactionDate, OutletLocation,
                                CONCAT('Rp ', FORMAT(PointUsage, 0)) AS PointUsage,  CONCAT('Rp ', FORMAT(RewardPoint, 0)) AS RewardPoint,
                                CONCAT('Rp ', FORMAT(TotalPayment, 0)) AS TotalPayment, CONCAT('Rp ', FORMAT(TotalPoint, 0)) AS TotalPoint
                                FROM TransactionMember ORDER BY TransactionDate DESC")->result();
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