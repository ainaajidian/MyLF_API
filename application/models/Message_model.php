<?php
class Message_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Usersession');
    }

    function generateAll()
    {
        return $this->db->query("SELECT * FROM message ORDER BY messageId ASC")->result();
    }

    function getMaxId()
    {
        $data = $this->db->query("SELECT MAX(messageId) messageId FROM message ")->row();
        return ++$data->messageId;
    }

    function generateMember()
    {
        $data = $this->db->query("SELECT * FROM members 
                                  WHERE userActive = '1' AND userDeviceId IS NOT NULL 
                                  ORDER BY userId ASC")->result();
        return $data;
    }

    function saveMessage($data)
    {
        $this->db->insert('message', $data);
    }
}