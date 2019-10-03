<?php
class Module_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Usersession');
    }


    function generateAll()
    {
    	$data = $this->db->query("SELECT a.*,b.module_name AS parent_name, b.module_id AS parent_id
    		 					  FROM modules a 
    		 					  LEFT JOIN modules b ON a.module_parent = b.module_id 
    		 					  ORDER BY module_name ASC ")->result();
    	return $data;
    }

    function generateParent()
    {
        $data = $this->db->query("SELECT * FROM modules WHERE module_parent = '' OR module_parent IS NULL ")->result();
        return $data;
    }

    function check_save_module($module_name){
        $query = $this->db->query("SELECT * FROM modules WHERE module_name = '".$module_name."'");
        if($query->num_rows() > 0 ){
            return false;
        }
        return true;
    }

    function saveModule($data)
    {

        $maxId = $this->getMaxId();
        $this->db->query("INSERT INTO modules (module_id,
                                        module_name,
                                        module_parent,
                                        module_path,
                                        module_flag,
                                        module_type,
                                        module_icon) 
                                    values 
                                        ('".$maxId."',
                                        '".$data['module_name']."',
                                        '".$data['module_parent']."',
                                        '".$data['module_path']."',
                                        '1',
                                        '".$data['module_type']."',
                                        '".$data['module_icon']."')

         ");

    }

    function getMaxId(){
        $data = $this->db->query("SELECT MAX(module_id) module_id from modules  ")->row();
        return ++$data->module_id;
    }

    function deletemodule($id){
        $infoModule = $this->getModuledetail($id);
        if($infoModule->module_flag == "1"){
            $this->db->query("UPDATE modules set module_flag = 0  where module_id = '".$id."' ");
        }else{
            $this->db->query("UPDATE modules set module_flag = 1  where module_id = '".$id."' ");

        }

    }

    function getModuledetail($id){
        return $this->db->query("SELECT * FROM modules where module_id = '".$id."' ")->row();
    }

    function deleteForever($id){
        $this->db->query("DELETE FROM modules where module_id = '".$id."' ");
        $this->db->query("DELETE FROM modules_access where module_id = '".$id."' ");
    }

    function updatemodule($data,$id){
        $this->db->where('module_id', $id);
        $this->db->update('modules', $data);
    }

}