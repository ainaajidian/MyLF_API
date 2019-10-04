<?php
class Size_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Usersession');
    }

    function generateAll()
    {
    	return $this->db->query("SELECT * FROM size ORDER BY SizeID ASC")->result();
    }

    function check_save_categories($categoryName)
    {
        $query = $this->db->query("SELECT * FROM product_categories WHERE categoryName = '".$categoryName."'");
        if($query->num_rows() > 0 )
            { return false; }
        return true;
    }

    function generateParent()
    {
        $data = $this->db->query("SELECT * FROM product_categories WHERE parentCategoryId = '' OR parentCategoryId IS NULL")->result();
        return $data;
    }

    function saveCategory($data)
    {
        $this->db->insert('product_categories', $data);
    }

    function getDate()
    {
        $data = $this->db->query("SELECT CURRENT_DATE()")->row();
        return true;
    }

    function getMaxId()
    {
        $data = $this->db->query("SELECT MAX(categoryId) categoryId FROM product_categories")->row();
        return ++$data->categoryId;
    }

    function getCategorydetail($categoryId)
      { return $this->db->query("SELECT categoryId FROM product_categories WHERE categoryId = '".$categoryId."' ")->row(); }

    function updateCategory($data,$kondisi)
    {
        $this->db->where($kondisi);
        $this->db->update('product_categories', $data);
    }

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

    function deleteForever($categoryId)
        { $this->db->query("DELETE FROM product_categories WHERE categoryId = '".$categoryId."' "); }
}