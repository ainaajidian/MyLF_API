
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Chat extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Cart_model');
        $this->load->model('Message_model');
        $this->load->model('Usersession');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform,
								   max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        $this->load->library('upload');
        $this->load->library("MyPHPMailer");
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
        
        $data['chat']                   = $this->db->query("SELECT * FROM chatHeader a inner join members b on b.userId = a.user1")->result();
                              
        $data['customjs']               = "chat/customjs";
        $data['view']                   = "chat/index";
        $this->go_to($data);
   }

    public function detail($roomId)
    {
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );

        $data['includecss'] = '<link rel="stylesheet"
							   href="' . base_url() . 'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.css">
							   <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">';
        $data['includejs']     = ' <script src="https://www.gstatic.com/firebasejs/7.5.0/firebase-app.js"></script>
                                <script src="https://www.gstatic.com/firebasejs/7.5.0/firebase-firestore.js"></script>
                              ';
        $data['roomId'] = $roomId;
        $data['customjs']             = "chat/custom_detail_js";
        $data['view']             = "chat/detail";
        $this->go_to($data);
   }

   function loadChat($roomId){
        $data = $this->db->query("SELECT * FROM chatDetail a left join members b on a.from = b.userId where roomId = '".$roomId."' order by a.createdDate asc ")->result();
        echo json_encode($data);
   }

   function saveChat(){
        $roomId         = $this->input->post("roomId");
        $from           = $this->input->post("from");
        $messageContent = $this->input->post("messageContent");
        $chatDetailId = $from.date("Y-m-d H:i:s");

        $this->db->query("INSERT INTO chatDetail 
        (chatDetailId,roomId,`from`,messageContent,createdDate) 
        values 
        ('".$chatDetailId."','".$roomId."','".$from."','".$messageContent."',NOW()) ");

   }

}