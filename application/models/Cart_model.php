<?php
class Cart_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Usersession');
    }

    function generateAll()
    {
        return $this->db->query("SELECT a.cartId, a.userId, b.productName, c.image1, d.ccName,
                                 a.sizeId, a.storeId, e.responseDescription, a.createdDate
                                 FROM cart a
                                 LEFT JOIN products b ON a.productId = b.productId
                                 LEFT JOIN product_colors c ON a.productColorId = c.productColorId
                                 LEFT JOIN combination_color d ON c.combination_color = d.ccId
                                 LEFT JOIN response e ON a.midtransStatusCode = e.responseCode
                                 ORDER BY a.createdDate ASC")->result();
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
    { $this->db->insert('cart', $data); }

    function updateDelivery($data,$kondisi)
    {
        $this->db->where($kondisi);
        $this->db->update('cart', $data);
    }

}