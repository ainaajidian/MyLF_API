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
        return $this->db->query("SELECT a.cartId, a.userId, b.productName, c.image1, d.ccName, a.sizeId, a.storeId, e.responseDescription
                                FROM cart a
                                LEFT JOIN products b ON a.productId = b.productId
                                LEFT JOIN product_colors c ON a.productColorId = c.productColorId
                                LEFT JOIN combination_color d ON c.combination_color = d.ccId
                                LEFT JOIN response e ON a.midtransStatusCode = e.responseCode")->result();
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

    function updateResi($dataupdate,$kondisi)
    {
        $this->db->where($kondisi);
        $this->db->update('cart', $dataupdate);
    }

}