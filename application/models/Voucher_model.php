<?php
class Voucher_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Usersession');
    }

    function generateAll()
    {
        return $this->db->query("SELECT voucherId, voucherCode, voucherName, discountType, discountVal, voucherFlag
                                 FROM voucher
                                 ORDER BY voucherCode + 0 ASC")->result();
    }

    function getMaxId(){
        $data = $this->db->query("SELECT voucherId FROM voucher ORDER BY voucherId DESC LIMIT 1")->row();
        return ++$data->voucherId;
    }

    function saveVoucher($data)
    {
        $this->db->insert('voucher', $data);
    }

    function updateVal($data)
    {
        $sql = "UPDATE voucher 
                SET discountVal=?
                WHERE voucherId=?";
        $hsl = $this->db->query($sql, $data);
        return $hsl;
    }

    function status($data,$kondisi)
    {
        $this->db->where($kondisi);
        $this->db->update('voucher', $data);
    }

    function deleteForever($voucherId)
    { $this->db->query("DELETE FROM voucher WHERE voucherId = '".$voucherId."' "); }

}