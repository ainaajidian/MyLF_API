<?php
class Notification_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Usersession');
    }

    function generateAll()
    {
    	return $this->db->query("SELECT notificationId, notificationTitle, notificationBody, notificationImage, DATE(notificationDate) AS notificationDate FROM notification ORDER BY notificationId ASC")->result();
    }

    function check_save_categories($notificationTitle)
    {
        $query = $this->db->query("SELECT * FROM notification WHERE notificationTitle = '".$notificationTitle."'");
        if($query->num_rows() > 0 )
            { return false; }
        return true;
    }

    
    function saveNotification($data)
    {
        $this->db->insert('notification', $data);
    }

    function getDate()
    {
        $data = $this->db->query("SELECT CURRENT_DATE()")->row();
        return true;
    }

    function getMaxId()
    {
        $data = $this->db->query("SELECT MAX(notificationId) notificationId FROM notification")->row();
        return ++$data->notificationId;
    }

    function getCategorydetail($notificationId)
      { return $this->db->query("SELECT notificationId FROM notification WHERE notificationId = '".$notificationId."' ")->row(); }

    function updateCategory($data,$kondisi)
    {
        $this->db->where($kondisi);
        $this->db->update('notification', $data);
    }

    function updateCategoryImg($data)
    {
        $sql = "UPDATE notification 
                SET categoryName=?, categoryDescription=?,
                    categoryModifiedDate=?, parentCategoryId=?,
                    categoryImage=?
                WHERE categoryId=?";
        $hsl = $this->db->query($sql, $data);
        return $hsl;
    }

    function updateCategoryNoImg($data)
    {
        $sql = "UPDATE notification 
                SET categoryName=?,
                    categoryDescription=?,
                    parentCategoryId=?,
                    categoryModifiedDate=?
                    WHERE categoryId=?";
        $hsl = $this->db->query($sql, $data);
        return $hsl;
    }

    function deleteForever($categoryId)
        { $this->db->query("DELETE FROM notification WHERE categoryId = '".$categoryId."' "); }
}