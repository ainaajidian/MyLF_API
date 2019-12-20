<?php
class ReportStock_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Usersession');
    }

    function generateAll()
    {
        return $this->db->query("SELECT DISTINCT a.storeID, b.productErpCode, b.productName, a.StockQty, c.SizeDescription
                                 FROM TransactionItemSalesStock a
                                 LEFT JOIN products b ON a.productID = b.productId
                                 LEFT JOIN size c ON a.SizeID = c.SizeID")->result();
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

    function getMaxId()
    {
        $data = $this->db->query("SELECT MAX(messageId) messageId FROM message ")->row();
        return ++$data->messageId;
    }

    function updateResi($data,$kondisi)
    {
        $this->db->where($kondisi);
        $this->db->update('cart', $data);
    }

    function sendMessage($data)
    {
        $this->db->insert('cart', $data);
    }

    function updateDelivery($data,$kondisi)
    {
        $this->db->where($kondisi);
        $this->db->update('cart', $data);
    }

}
