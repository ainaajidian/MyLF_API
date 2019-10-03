<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Custom_404 extends CI_Controller 
{
 public function __construct() 
 {

    parent::__construct(); 
     $this->load->model('Usersession');
     $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
    $this->output->set_header("Pragma: no-cache");
 } 

 public function index() 
 { 
    $this->output->set_status_header('404'); 
    $this->load->view('custom_404');//loading in custom error view
 } 
} 