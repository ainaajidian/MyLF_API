<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Privacy extends Ci_Controller
{

    function index()
    {
        $this->load->view("privacy");
    }
}
