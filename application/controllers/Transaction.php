<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Transaction_model');
        $this->load->model('Usersession');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform,
								   max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        $this->load->library('upload');
    }

    public function index()
    {
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );

        $data['includecss'] = '<link rel="stylesheet"
							   href="' . base_url() . 'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.css">
							   <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">';
        $data['includejs']     = '<script src="' . base_url() . 'node_modules/admin-lte/plugins/datatables/jquery.dataTables.js"></script>
							   <script src="' . base_url() . 'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.js"></script>
							    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
							  ';

        $data['customjs']             = "transaction/customjs";
        $data['view']                 = "transaction/index";
        $data['store_module']       = $this->Transaction_model->generateStore();
        $data['member_module']      = $this->Transaction_model->generateMember();
        $this->go_to($data);
    }

    //Get Data
    public function getTransaction()
    {
        $data['data'] = $this->Transaction_model->generateAll();
        echo json_encode($data);
    }

    //Save Data
    function saveTransaction()
    {
        $UserId             = $this->input->post("UserId");
        $TransactionId      = $this->input->post("TransactionId");
        $TransactionDate    = $this->input->post("TransactionDate");
        $OutletLocation     = $this->input->post("OutletLocation");
        $Total              = $this->input->post("Total");

        $Point = "0.05";
        $TotalPoint = $Total * $Point;

        $datasave = array(
            "UserId"            => $UserId,
            "TransactionId"     => $TransactionId,
            "TransactionDate"   => $TransactionDate,
            "OutletLocation"    => $OutletLocation,
            "Total"             => $Total,
            "RewardPoint"       => $TotalPoint,
            "TotalPoint"        => $TotalPoint
        );

        $this->Transaction_model->saveTransaction($datasave, $UserId);

        die("<script>
            alert('Add Transaction Success');
            window.location.href='" . base_url() . "Transaction';
            </script>");
    }

    //Update Data
    function updateStore()
    {
        $UserId                 = $this->input->post("UserId");
        $TransactionId          = $this->input->post("TransactionId");
        $TransactionDate        = $this->input->post("TransactionDate");
        $OutletLocation         = $this->input->post("OutletLocation");
        $Total                  = $this->input->post("Total");

        $data = array(
            "UserId"            => $UserId,
            "TransactionId"     => $TransactionId,
            "TransactionDate"   => $TransactionDate,
            "OutletLocation"    => $OutletLocation,
            "Total"             => $Total,
            "storeLatitude"     => $storeLatitude
        );

        $kondisi = array("storeId"          => $storeId);

        $this->Store_model->updateStore($data, $kondisi);

        die("<script>
            alert('Update Store Success');
            window.location.href='" . base_url() . "Store';
            </script>");
    }
}
