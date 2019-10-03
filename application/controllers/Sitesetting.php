<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Sitesetting extends MY_Controller {



  	function __construct()

    {

        parent::__construct();

        $this->load->model('Sitesetting_model');
 $this->load->model('Usersession');
$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
    $this->output->set_header("Pragma: no-cache");

    }





    function index(){

		$data['csrf'] = array(

	        'name' => $this->security->get_csrf_token_name(),

	        'hash' => $this->security->get_csrf_hash()

			);

		$data['view'] = "sitesetting";	

		$this->go_to($data);

    }



    function save_setting(){

    	$sitename = $this->input->post("sitename");

    	$data = array("value" => $sitename);

    	$where = array("sitesettingid" => "SET001");

        $this->Sitesetting_model->save_setting($data,$where);

        $uploadpath = "./assets/icon/";

   

        if(file_exists($_FILES['sidebarlogo']['tmp_name']) || is_uploaded_file($_FILES['sidebarlogo']['tmp_name'])) {

            $image_info = getimagesize($_FILES["sidebarlogo"]["tmp_name"]);

            $image_width = $image_info[0];

            $image_height = $image_info[1];

            if(($image_width != 128) || ($image_height!=128)){

                die("Image with & height must 128px");

            }

            if(exif_imagetype($_FILES['sidebarlogo']['tmp_name']) != IMAGETYPE_PNG){

                die("Sidebar logo must a png file");

            }

            if (!move_uploaded_file($_FILES["sidebarlogo"]["tmp_name"], $uploadpath.$_FILES["sidebarlogo"]["name"])) {

                 die("Sorry, there was an error uploading your file.");

            }

            $data = array("value" => $_FILES["sidebarlogo"]["name"]);

            $where = array("sitesettingid" => "SET002");

            $this->Sitesetting_model->save_setting($data,$where);

        }



        if(file_exists($_FILES['Favicon']['tmp_name']) || is_uploaded_file($_FILES['Favicon']['tmp_name'])) {

            $image_info = getimagesize($_FILES["Favicon"]["tmp_name"]);

            $image_width = $image_info[0];

            $image_height = $image_info[1];



            if(($image_width != 32) || ($image_height!=32)){

                die("Sidebar logo width & height must 32px");

            }

             if(exif_imagetype($_FILES['Favicon']['tmp_name']) != IMAGETYPE_PNG){

                echo 'Favicon must a png file';

            }

            if (!move_uploaded_file($_FILES["Favicon"]["tmp_name"], $uploadpath.$_FILES["Favicon"]["name"])) {

                 die("Sorry, there was an error uploading your file.");

            }



            $data   = array("value" => $_FILES["Favicon"]["name"]);

            $where  = array("sitesettingid" => "SET003");

            $this->Sitesetting_model->save_setting($data,$where);



        }



        redirect("Sitesetting","refresh");

    }



}