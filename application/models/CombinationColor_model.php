<?php
class CombinationColor_model extends CI_Model 
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Usersession');
    }

    function generateAll()
    {
        return $this->db->query("SELECT * FROM combination_color ORDER BY ccId ASC")->result();
    }

    function getCategorydetail($categoryId)
    { return $this->db->query("SELECT ccId FROM combination_color where ccId = '".$ccId."' ")->row(); }

    function check_save_categories($ccName)
    {
        $query = $this->db->query("SELECT * FROM combination_color WHERE ccName = '".$ccName."'");
        if($query->num_rows() > 0 )
            { return false; }
        return true;
    }

     function getMaxId(){
        $data = $this->db->query("SELECT MAX(ccId) ccId FROM combination_color  ")->row();
        return ++$data->ccId;
    }

    function getCCdetail($ccId)
    { return $this->db->query("SELECT ccId FROM combination_color WHERE ccId = '".$ccId."' ")->row(); }

    function saveColor($data)
    { $this->db->insert('combination_color', $data); }

    function updateCC($data,$kondisi)
    {
        $this->db->where($kondisi);
        $this->db->update('combination_color', $data);
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

    function deleteForever($ccId)
    { $this->db->query("DELETE FROM combination_color WHERE ccId = '".$ccId."' "); }

}