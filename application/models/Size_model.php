<?php
class Size_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Usersession');
    }

    function generateAll()
    { return $this->db->query( "SELECT a.SizeID, a.SizeDescription, a.TipeProduct, a.SizeFlag, b.categoryName
                                FROM size a
                                LEFT JOIN product_categories b ON a.TipeProduct = b.categoryId")->result(); }

    function generateParent()
    {
        $data = $this->db->query("SELECT * FROM product_categories WHERE parentCategoryId = '' OR parentCategoryId IS NULL")->result();
        return $data;
    }

    function getMaxId()
    {
        $data = $this->db->query("SELECT MAX(SizeID) SizeID FROM size")->row();
        return ++$data->SizeID;
    }

    function status($datasave)
    {
        $sql = "UPDATE size SET SizeDescription = ?, TipeProduct = ?, SizeFlag = ? WHERE SizeID = ?";
        $hsl = $this->db->query($sql, $datasave);
        return $hsl;
    }

    function deleteForever($SizeID)
    { $this->db->query("DELETE FROM size WHERE SizeID = '".$SizeID."' "); }

    function saveSize($data)
    { $this->db->insert('size', $data); }

    function getCategorydetail($categoryId)
      { return $this->db->query("SELECT categoryId FROM product_categories WHERE categoryId = '".$categoryId."' ")->row(); }

    

    function updateCategoryImg($data)
    {
        $sql = "UPDATE product_categories 
                SET categoryName=?, categoryDescription=?,
                    categoryModifiedDate=?, parentCategoryId=?,
                    categoryImage=?
                WHERE categoryId=?";
        $hsl = $this->db->query($sql, $data);
        return $hsl;
    }

    function updateCategoryNoImg($data)
    {
        $sql = "UPDATE product_categories 
                SET categoryName=?,
                    categoryDescription=?,
                    parentCategoryId=?,
                    categoryModifiedDate=?
                    WHERE categoryId=?";
        $hsl = $this->db->query($sql, $data);
        return $hsl;
    }
}