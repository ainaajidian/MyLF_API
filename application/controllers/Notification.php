<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notification extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Notification_model');
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

        $data['customjs']              = "notification/customjs";
        $data['view']                  = "notification/index";

        $this->go_to($data);
    }

    public function getNotification()
    {
        $data['data'] = $this->Notification_model->generateAll();
        echo json_encode($data);
    }

    //Save data
    function saveNotification()
    {
        $notificationTitle      = $this->input->post("notificationTitle");
        $notificationBody       = $this->input->post("notificationBody");
        $notificationDate       = $this->input->post("notificationDate");
        $notificationFlag       = $this->input->post("notificationFlag");
        $toNotification         = $this->input->post("toNotification");
        $notificationId         = $this->input->post("notificationId");

        $config['upload_path']    = './assets/app_assets/'; //path folder
        $config['allowed_types']  = 'jpg|png|jpeg'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size']       = '2048000000'; //maksimum besar file 2M
        $config['max_width']      = ''; //lebar maksimum 1288 px
        $config['max_height']     = ''; //tinggi maksimu 1000 px
        $this->upload->initialize($config);
        $this->load->library('upload', $config);
        $notificationMaxId = $this->Notification_model->getMaxId();
        if (!empty($_FILES['notificationImage']['name'])) {
            if ($this->upload->do_upload('notificationImage')) {
                $pic = $this->upload->data();
                $picture = $pic['file_name'];
                $datasave = array(
                    "notificationTitle"     => $notificationTitle,
                    "notificationBody"      => $notificationBody,
                    "notificationDate"      => $notificationDate,
                    "notificationImage"     => $picture,
                    "notificationFlag"      => 1,
                    "notificationId"        => $notificationMaxId
                );

                $this->Notification_model->saveNotification($datasave, $notificationId);

                $msg = array(
                    'body' => $notificationBody,
                    'tag' => "185",
                    'title' => $notificationTitle,
                    'icon' => 'myicon',
                    'sound' => 'mySound',
                    'priority' => 'high',
                    'show_in_foreground' => True,
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                );

                $fields = array(
                    'to' => $toNotification,
                    'notification' => $msg,
                    "data" => array( 
                        'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                        'show_in_foreground' => True,
                        'priority' => 'high',
                        'openScreen' => true,
                        'screenToOpen' => 'NotificationDetailPage',
                        'param' => $this->getNotificationDetail($notificationMaxId)
                        )

                );

                $headers = array(
                    'Authorization: key=AAAA_-YqD9g:APA91bGyZ9cpvp9T8FqKk98QBZRKBNeS-frvtIIEzDisZFDs0JQ1fYMtzoPTEov-47-SussGmhmHxZHCxShA7hZTgaac6fkgVBi9eOfKPSssIktJZqYoglFmc4pKjGsNpHThxq9gsAFe',
                    'Content-Type: application/json'
                );

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                $result = curl_exec($ch);
                print_r($result);
                curl_close($ch);

                // die("<script>
                //         alert('Add Notification Success');
                //         window.location.href='" . base_url() . "Notification';
                //         </script>");
            } else {
                // die('<script>
                //     alert("' . $this->upload->display_errors() . '");
                //     window.location.href="' . base_url() . 'Notification";
                //     </script>');
            }
        } else {
            $datasave = array(
                "notificationTitle"     => $notificationTitle,
                "notificationBody"      => $notificationBody,
                "notificationDate"      => $notificationDate,
                "notificationFlag"      => 1,
                "notificationId"        => $notificationMaxId
            );

            $this->Notification_model->saveNotification($datasave, $notificationId);

            $msg = array(
                'body' => $notificationBody,
                'tag' => "185",
                'title' => $notificationTitle,
                'icon' => 'myicon',
                'sound' => 'mySound',
                'priority' => 'high',
                'show_in_foreground' => True,
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            );

            $fields = array(
                'to' => $toNotification,
                'notification' => $msg,
                "data" => array( 
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                    'show_in_foreground' => True,
                    'priority' => 'high',
                    'openScreen' => true,
                    'screenToOpen' => 'NotificationDetailPage',
                    'param' => $this->getNotificationDetail($notificationMaxId)
                    )
            );

            $headers =  array(
                'Authorization: key=AAAA_-YqD9g:APA91bGyZ9cpvp9T8FqKk98QBZRKBNeS-frvtIIEzDisZFDs0JQ1fYMtzoPTEov-47-SussGmhmHxZHCxShA7hZTgaac6fkgVBi9eOfKPSssIktJZqYoglFmc4pKjGsNpHThxq9gsAFe',
                'Content-Type: application/json'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            print_r($result);
            curl_close($ch);

            // die("<script>
            //     alert('Add Notification Success');
            //     window.location.href='" . base_url() . "Notification';
            //     </script>");
        }
    }

    function  getNotificationDetail($id){
        $data = $this->db->query("SELECT * FROM notification where notificationId = '".$id."' ")->row();
       // echo json_encode($data);
     return ($data);
    }

    //Edit Data
    function updateCategory()
    {
        $categoryName             = $this->input->post("categoryName");
        $categoryDescription    = $this->input->post("categoryDescription");
        $parentCategoryId       = $this->input->post("parentCategoryId");
        $categoryModifiedDate     = $this->input->post("categoryModifiedDate");
        $parentCategoryId       = $this->input->post("parentCategoryId");
        $categoryId             = $this->input->post("categoryId");

        $config['upload_path']   = './assets/app_assets/notification/'; //path folder
        $config['allowed_types'] = 'jpg|png|jpeg'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '2048000000'; //maksimum besar file 2M
        $config['max_width']  = ''; //lebar maksimum 1288 px
        $config['max_height']  = ''; //tinggi maksimu 1000 px

        $this->upload->initialize($config);
        $this->load->library('upload', $config);
        if (!empty($_FILES['editcategoryImage']['name'])) {
            if ($this->upload->do_upload('editcategoryImage')) {
                $pic = $this->upload->data();
                $picture = $pic['file_name'];
                $dataupdate = array(
                    "categoryName"          => $categoryName,
                    "categoryDescription"   => $categoryDescription,
                    "categoryModifiedDate"  => $categoryModifiedDate,
                    "parentCategoryId"      => $parentCategoryId,
                    "categoryImage"         => $picture,
                    "parentCategoryId"      => $parentCategoryId,
                    "categoryId"            => $categoryId
                );

                $this->Notification_model->updateCategoryImg($dataupdate, $categoryId);

                die("<script>
						alert('Update Product Category Success');
						window.location.href='" . base_url() . "Notification';
						</script>");
            } else {
                die('<script>
					alert("' . $this->upload->display_errors() . '");
					window.location.href="' . base_url() . 'Notification";
					</script>');
            }
        } else {
            $dataupdate = array(
                "categoryName" => $categoryName,
                "categoryDescription" => $categoryDescription,
                "parentCategoryId"      => $parentCategoryId,
                "categoryModifiedDate" => $categoryModifiedDate,
                "categoryId" => $categoryId
            );

            $this->Notification_model->updateCategoryNoImg($dataupdate, $categoryId);

            die("<script>
                alert('Update Product Category Success');
                window.location.href='" . base_url() . "Notification';
                </script>");
        }
    }
}
