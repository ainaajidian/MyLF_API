<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Privacy extends Ci_Controller {

	function index()
    {
       $this->load->view("privacy");
    }

}