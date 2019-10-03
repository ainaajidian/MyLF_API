<?php
class Profil_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Usersession');
    }

    function getMaxId(){
        $data = $this->db->query("SELECT MAX(BiodataId) BiodataId from biodata  ")->row();
        return ++$data->BiodataId;
    }

    function update($where,$data){
        
        $this->db->trans_start();


    if(!$this->checkExist()){
          $this->db->query("UPDATE biodata a  inner join users b on a.login_id = b.userid set email ='". $data['email'] ."' , 
                                                    placeofbirth = '". $data['placeofbirth'] ."', 
                                                    dateofbirth = '". $data['dateofbirth'] ."', 
                                                    TelpNo = '". $data['TelpNo'] ."', 
                                                    gender ='". $data['gender'] ."', 
                                                    address ='". $data['address'] ."', 
                                                    fullname ='". $data['fullname'] ."' 
                                                    where email = '".$data['email']."'
                                                ");
        }else{
             $this->db->query(" INSERT INTO biodata (BiodataId,placeofbirth,dateofbirth,TelpNo,gender,address,fullname,login_id)    
                                values ( '".$this->Profil_model->getMaxId()."',
                                '". $data['placeofbirth'] ."','". $data['dateofbirth'] ."', '". $data['TelpNo'] ."', 
                                '". $data['gender'] ."', '". $data['address'] ."', '". $data['fullname'] ."','".$this->Usersession->getLoginid()."'
                                )

                ");
        }

       

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
             $this->db->trans_rollback();
             return false;
        }
       
        $this->session->set_userdata(json_decode(json_encode( $this->generateUserdata()), True));

    }

    function generateUserdata(){
        $data = $this->db->query("SELECT a.*,b.email,username,c.type_description 
                                    from Biodata a inner join users b on a.login_id = b.userid  
                                    inner join usertypes c on b.usertype = c.type_id where login_id = '".$this->Usersession->getLoginid()."' ")->row();
        return $data;
    }

    function checkExist(){
        $query = $this->db->query("SELECT * 
                                    from Biodata where login_id = '".$this->Usersession->getLoginid()."' 
                                    ");
        if($query->num_rows() > 0 ){
            return false;
        }
        return true;
    }


}