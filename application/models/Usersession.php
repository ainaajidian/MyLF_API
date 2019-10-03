<?php
class Usersession extends CI_Model { 


	function __construct()
    {
        parent::__construct();
          $this->load->model('Usersession');
    
    }

    function getLoginid(){
        return  $this->session->userdata('userid');
    }

    function getUsername(){
             return  $this->session->userdata('username');
    }

    function getFullname(){
             return  $this->session->userdata('Fullname');
    }

    function getAddress(){
            return  $this->session->userdata('Address');
    }

    function getTelp(){
            return  $this->session->userdata('TelpNo');
    }

    function getProfilpict(){
       $profil = (isset($_SESSION['ProfilPict']) ? $_SESSION['ProfilPict'] : false);
       if($profil != false){
        $path = "";
       }else{
        $path = base_url()."assets/default_user_image.png";
       }
       return $path;
    }
 
    function getDateofbirth(){
        return (isset($_SESSION['dateofbirth']) ? $_SESSION['dateofbirth'] : false);
    }

    function getPlaceofbirth(){
        return (isset($_SESSION['placeofbirth']) ? $_SESSION['placeofbirth'] : false);
    }

    function getGender(){
        $gender = (isset($_SESSION['gender']) ? $_SESSION['gender'] : false);
        if($gender == 1 ) { return "male";}else{return "female";}
    }

    function getEmail(){
        return (isset($_SESSION['email']) ? $_SESSION['email'] : false);   
    }

    function getUsertype(){
        return  $this->session->userdata('usertype');
    }
    
    function getUsertypedesc(){
        return  $this->session->userdata('type_description');
    }

}