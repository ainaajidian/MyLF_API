<?php
class Refund_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Usersession');
    }

    function generateAll()
    {
        return $this->db->query("SELECT refundId, cartId, tglPengajuan, nominalRefund, 
                                 approveBy, approveDate, tglRefund, bankName, rekeningNo
                                 FROM refund")->result();
    }
}
