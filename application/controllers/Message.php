<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends MY_Controller 
{

	function __construct()
    {
        parent::__construct();
        $this->load->model('Message_model');
        $this->load->model('Usersession');
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform,
								   max-age=0, post-check=0, pre-check=0");
    	$this->output->set_header("Pragma: no-cache");
    	$this->load->library('upload');
    }	

	public function index()
	{
		$data['csrf'] = array
		(
	        'name' => $this->security->get_csrf_token_name(),
	        'hash' => $this->security->get_csrf_hash()
		);
		
		$data['includecss'] = '<link rel="stylesheet"
							   href="'.base_url().'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.css">
							   <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">';
		$data['includejs'] 	= '<script src="'.base_url().'node_modules/admin-lte/plugins/datatables/jquery.dataTables.js"></script>
							   <script src="'.base_url().'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.js"></script>
							    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
							  ';
		
		$data['view'] 			     = "message/index";
        $data['member_module']       = $this->Message_model->generateMember();

		$this->go_to($data);
	}

	public function getMessage()
	{
		$data['data'] = $this->Message_model->generateAll();
		echo json_encode($data);
	}

    function saveMessage()
    {
        $userId             = $this->input->post("userId");
		$messageContent 	= $this->input->post("messageContent");
        $messageId          = $this->input->post("messageId");
        $messageTitle          = $this->input->post("messageTitle");
		
		$nmfile = "Message-".date('Y-m-d')."-"; //nama file saya beri nama langsung dan diikuti fungsi time
        $config['upload_path']   = './assets/app_assets/message/'; //path folder
        $config['allowed_types'] = 'jpg|png|jpeg'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '2048000000'; //maksimum besar file 2M
        $config['max_width']  = '1288'; //lebar maksimum 1288 px
        $config['max_height']  = '1000'; //tinggi maksimu 1000 px
        $config['file_name'] = $nmfile; //nama yang terupload nantinya

        $userId     = explode(";",$userId);
      
        $this->upload->initialize($config);
        $this->load->library('upload',$config);
        if(!empty($_FILES['messageImage']['name']))
        {
            if ($this->upload->do_upload('messageImage'))
            {       
                    $pic = $this->upload->data();
                    $picture = $pic['file_name'];
                	$datasave = array(  "userId"                => $userId[1],
                                        "deviceId"              => $userId[0],
                                        "messageContent" 		=> $messageContent,
										"messageImage" 		    => $picture,
                                        "messageTitle"          => $messageTitle,
                                        "messageId"             => $this->Message_model->getMaxId() );

                	$this->Message_model->saveMessage($datasave,$messageContent);

                    // $msg = array
                    // (
                    //     'body' => strip_tags($messageContent),
                    //     'tag' => "185",
                    //     'title' => 'Message',
                    //     'icon' => 'myicon',
                    //     'sound' => 'mySound',
                    //     'priority' => 'high',
                    //     'show_in_foreground' => True,
                    //     'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                    // );

                    // $fields = array
                    // ( 'to' => $userId[0],
                    //   'notification' => $msg );
            
                    // $headers =  array 
                    //             ( 'Authorization: key=AAAA_-YqD9g:APA91bGyZ9cpvp9T8FqKk98QBZRKBNeS-frvtIIEzDisZFDs0JQ1fYMtzoPTEov-47-SussGmhmHxZHCxShA7hZTgaac6fkgVBi9eOfKPSssIktJZqYoglFmc4pKjGsNpHThxq9gsAFe',
                    //             'Content-Type: application/json' );
                    
                    // $ch = curl_init();
                    // curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                    // curl_setopt($ch, CURLOPT_POST, true);
                    // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                    // $result = curl_exec($ch);
                    // print_r($result);
                    // curl_close($ch);
                    
                    die("<script>
                        alert('Add Message Success');
                        window.location.href='".base_url()."Message';
                        </script>");
            } 
            else 
            {
                die('<script>
					alert("'.$this->upload->display_errors().'");
					window.location.href="'.base_url().'Message";
					</script>');
            }
            
        }
        else
        {

            $datasave = array(  
                            "userId"                => $userId[1],
                            "deviceId"              => $userId[0],
                            "messageContent"        => strip_tags($messageContent),
                            "messageTitle"          => $messageTitle,
                            "messageId"             => $this->Message_model->getMaxId() );
            
            $this->Message_model->saveMessage($datasave,$messageContent);

            // $msg = array
            // (
            //     'body' => $messageContent,
            //     'tag' => "185",
            //     'title' => 'Message',
            //     'icon' => 'myicon',
            //     'sound' => 'mySound',
            //     'priority' => 'high',
            //     'show_in_foreground' => True,
            //     'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            // );
            
            // $fields = array
            //         ( 'to' => $userId[0],
            //           'notification' => $msg );
            
            // $headers =  array 
            //             ( 'Authorization: key=AAAA_-YqD9g:APA91bGyZ9cpvp9T8FqKk98QBZRKBNeS-frvtIIEzDisZFDs0JQ1fYMtzoPTEov-47-SussGmhmHxZHCxShA7hZTgaac6fkgVBi9eOfKPSssIktJZqYoglFmc4pKjGsNpHThxq9gsAFe',
            //             'Content-Type: application/json' );
            
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            // curl_setopt($ch, CURLOPT_POST, true);
            // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            // $result = curl_exec($ch);
            // print_r($result);
            // curl_close($ch);
            
            die("<script>
                alert('Add Message Success');
                window.location.href='".base_url()."Message';
                </script>");
        }
    }

	function delete($categoryId)
	{ $this->Message_model->deleteCategories($categoryId); }

}