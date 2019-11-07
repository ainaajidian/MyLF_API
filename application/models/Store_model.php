<?php
class Store_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Usersession');
    }

    function generateAll()
    {
        return $this->db->query("SELECT a.storeId, a.storeName, a.storeMall, a.storeAddress, a.storeDetail, 
                                 a.storeLongitude, a.storeLatitude, b.provinceName, c.cityName, a.storeFlag 
                                 FROM store a
                                 LEFT JOIN province b ON a.storeProvinceId = b.provinceID
                                 LEFT JOIN city c ON a.storeCityId = c.cityID
                                 ORDER BY storeId + 0 ASC")->result();
    }

    function getStoredetail($categoryId)
    { return $this->db->query("SELECT storeId FROM store where storeId = '".$storeId."' ")->row(); }

    function check_save_categories($ccName)
    {
        $query = $this->db->query("SELECT * FROM combination_color WHERE ccName = '".$ccName."'");
        if($query->num_rows() > 0 )
            { return false; }
        return true;
    }

     function getMaxId(){
        $data = $this->db->query("SELECT storeId FROM store ORDER BY storeId DESC LIMIT 1")->row();
        return ++$data->storeId;
    }

    function saveStore($data)
    {
        $this->db->insert('store', $data);
    }

    function updateStore($data,$kondisi)
    {
        $this->db->where($kondisi);
        $this->db->update('store', $data);
    }

    function updateColor($data,$kondisi)
    {
        $query = "UPDATE combination_color 
                  SET ccName=?, ccPriName=?,
                    ccPriHex=?, ccSecName=?, ccSecHex
                  WHERE ccId=?";
        $hasil = $this->db->query($query, $data);

        return $hasil;
    }

    function deleteForever($storeId)
        { $this->db->query("DELETE FROM store WHERE storeId = '".$storeId."' "); }

}