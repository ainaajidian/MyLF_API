<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }
    
    function sendConfirmationEmail($id)
    {
        $config['protocol']    = 'smtp';
        $config['smtp_host']   = '103.9.124.162'; //'103.9.124.162'; 
        $config['smtp_port']   = '587';
        $config['smtp_user']   = 'no-reply@rpgroup.co.id';
        $config['smtp_pass']   = 'N4ughty!';
        $config['smtp_crypto'] = 'tls';
        $config['charset']     = 'utf-8';
        $config['mailtype']    = 'html';
        $config['wordwrap']    = TRUE;
        
        $data['url'] = base_url() . "Api/aktivasi/" . $id;
        $body        = $this->load->view("confirmation_email", $data, TRUE);
        
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->initialize($config);
        $this->email->subject('Active your account at Member LF');
        
        $datauser = $this->db->query("SELECT userEmail from members where userId = '" . $id . "' ")->row();
        
        $this->email->from('no-reply@rpgroup.co.id', 'Auto Email');
        $this->email->to($datauser->userEmail);
        
        $this->email->message($body);
        $this->email->send();
    }
    
    function aktivasi($id)
    {
        $this->db->query("UPDATE members set userActive = 1, userActiveDate =  now() where userId = '" . $id . "' ");
        $this->load->view("email_active_success", TRUE);
    }
    
    function sendNewPassword()
    {
        $email = $this->input->post("email");
        
        $config['protocol']    = 'smtp';
        $config['smtp_host']   = '103.9.124.162'; //'103.9.124.162'; 
        $config['smtp_port']   = '587';
        $config['smtp_user']   = 'no-reply@rpgroup.co.id';
        $config['smtp_pass']   = 'N4ughty!';
        $config['smtp_crypto'] = 'tls';
        $config['charset']     = 'utf-8';
        $config['mailtype']    = 'html';
        $config['wordwrap']    = TRUE;
        
        $data['password'] = "123456";
        $body             = $this->load->view("reset_password", $data, TRUE);
        
        $this->db->query("update members set userPassword = '" . MD5(123456) . "' where userEmail = '" . $email . "'  ");
        
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->initialize($config);
        $this->email->subject('Password Reset Member LF');
        
        $this->email->from('no-reply@rpgroup.co.id', 'Auto Email');
        $this->email->to($email);
        
        $this->email->message($body);
        $this->email->send();
        $data['msg'] = "We send you new password. Please check your email";
        echo json_encode($data);
    }

    function changePassword(){
    	$userId 		= $this->input->post("userId");
    	$newPassword 	= $this->input->post("newPassword");

    	$this->db->query("UPDATE members set userPassword = '".MD5($newPassword)."' where userId = '".$userId."'");
    	echo json_encode($this->input->post());
    }
    
    
    function register()
    {
        $email    = $this->input->post("email");
        $password = $this->input->post("password");
        $fullname = $this->input->post("fullname");
        $dob      = $this->input->post("dob");
        $gender   = $this->input->post("gender");
        $deviceId = $this->input->post("deviceId");

        $registerDate = date("Y-m-d");
        
        $cekEmail = $this->db->query("SELECT * FROM members where userEmail = '" . $email . "' ")->num_rows();
        if ($cekEmail > 0) {
            $data['err']     = 1;
            $data['message'] = "Email already registered !!!";
        } else {
            $id = $this->generateUserid();
            $this->db->query("INSERT INTO members (userGender,userId,userEmail,userPassword,userFullname,userBirthDate,userActive,userRegisterDate,userDeviceId) 
                    values ('" . $gender . "','" . $id . "','" . $email . "','" . md5($password) . "','" . $fullname . "','" . $dob . "',0,'".$registerDate."','" . $deviceId . "') ");
            $data['err']     = 0;
            $data['message'] = "Register success. We sent an email to you";
            $this->sendConfirmationEmail($id);
        }
        echo json_encode($data);
    }

    function generateUserid()
    {
        $maxMemberId = $this->db->query("SELECT MAX(userID) userId FROM members ORDER BY userID DESC LIMIT 0, 1");
        if ($maxMemberId->row()->userId != "") {
            $nextMemberId = ++$maxMemberId->row()->userId;
        } else {
            $nextMemberId = "M-" . date("ymdhis");
        }
        return $nextMemberId;
    }
    
    function login()
    {
        $email    = $this->input->post("email");
        $password = $this->input->post("password");
        $cekEmail = $this->db->query("SELECT * FROM members where userEmail = '" . $email . "' and userPassword = '" . md5($password) . "'");
        if ($cekEmail->num_rows() > 0) {
            if ($cekEmail->row()->userActive == 0) {
                $data['err']      = 2;
                $data['message']  = "Your account is not active";
                $data['userInfo'] = $cekEmail->row();
            } else {
                $data['err']      = 0;
                $data['message']  = "Login successful";
                $data['userInfo'] = $cekEmail->row();
            }
        } else {
            $data['err']     = 1;
            $data['message'] = "Wrong email or password";
        }
        echo json_encode($data);
    }
    function updateProfile()
    {
        $email    = $this->input->post("email");
        $fullname = $this->input->post("fullname");
        $dob      = $this->input->post("dob");
        $mobile   = $this->input->post("mobile");
        $addres   = $this->input->post("addres");
        $gender   = $this->input->post("gender");
        
        
        $this->db->query("UPDATE members set userGender='" . $gender . "',userFullname = '" . $fullname . "',userBirthDate ='" . $dob . "',userMobilePhone = '" . $mobile . "',userAddress='" . $addres . "' where userEmail = '" . $email . "'");
        $data['err']      = 0;
        $cekEmail         = $this->db->query("SELECT * FROM members where userEmail = '" . $email . "'");
        $data['userInfo'] = $cekEmail->row();
        echo json_encode($data);
        
    }
    
    function profileImage($userId)
    {
        $config['upload_path']   = './assets/profileImage/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|';
        $this->load->library('upload', $config);
        
        if (!$this->upload->do_upload('userfile')) {
            $error         = array(
                'error' => $this->upload->display_errors()
            );
            $return['err'] = 1;
        } else {
            $dataProfil = $this->db->query("SELECT * FROM members where userId = '" . $userId . "'")->row();
            if (($dataProfil->userProfilImage != null) or ($dataProfil->userProfilImage != "")) {
                unlink('./assets/profileImage/' . $dataProfil->userProfilImage);
            }
            $datas = $this->upload->data();
            $this->db->query("UPDATE members set userProfilImage='" . $datas['file_name'] . "' where userId = '" . $userId . "'");
            $return['err']  = 0;
            $return['data'] = $datas['file_name'];
        }
        echo json_encode($return);
    }
    
    function getCategories()
    {
        $data = $this->db->query("SELECT categoryId,categoryName,categoryImage,categoryDescription from product_categories where (parentCategoryId = '' or parentCategoryId is null)  order by categoryName asc")->result();
        echo json_encode($data);
    }

    function getChildCategory($parentCategoryId){
        $data = $this->db->query("SELECT 'All' as categoryId,'All' as categoryName,'All' as categoryImage,'All' as categoryDescription
            UNION ALL SELECT categoryId,categoryName,categoryImage,categoryDescription from product_categories where parentCategoryId = '".$parentCategoryId."' order by categoryName asc")->result();
        echo json_encode($data);
    }   
    
    function getProducts($categoryId = "", $limit = 0, $offset = 0, $type = "", $userId = "")
    {
        if ($type == "0") {
            $data = $this->db->query("SELECT a.productId,productName,isNew,isHot,productImage,a.categoryId,productPrice,
                                        productDescription,IF(b.UserId IS NULL, 0,1) as isLiked,pc.*,childCategoryId from products a
                                        LEFT JOIN  wishlist b on (a.productId = b.productId) and (a.categoryId = b.categoryId)
                                        and b.userId = '" . $userId . "'
                                        INNER JOIN (
                                                select min(productColorId) productColorId,combination_color,image1,image2,image3,productId from product_colors
                                                group by productId
                                            ) pc on a.productId = pc.productId
                                        where a.categoryId = '" . $categoryId . "' and a.productFlag = '1'
                                      
                                        ORDER BY a.productId asc LIMIT $limit , $offset ");
        }
        if ($type == "1") {
            $data = $this->db->query("SELECT a.productId,productName,isNew,isHot,productImage,a.categoryId,productPrice,
                                        productDescription,IF(b.UserId IS NULL, 0,1) as isLiked,pc.*,childCategoryId from products a
                                        LEFT JOIN  wishlist b on (a.productId = b.productId) and (a.categoryId = b.categoryId)
                                        and b.userId = '" . $userId . "'
                                        INNER JOIN (
                                            select min(productColorId) productColorId,combination_color,image1,image2,image3,productId from product_colors
                                            group by productId
                                        ) pc on a.productId = pc.productId
                                        where a.categoryId = '" . $categoryId . "' and a.productFlag = '1'
                                        ORDER BY a.productId asc LIMIT $limit , $offset ");
        }
        if ($type == "2") {
            $data = $this->db->query("SELECT a.productId,productName,isNew,isHot,productImage,a.categoryId,productPrice,
                                        productDescription,IF(b.UserId IS NULL, 0,1) as isLiked,pc.*,childCategoryId from products a
                                        LEFT JOIN  wishlist b on (a.productId = b.productId) and (a.categoryId = b.categoryId)
                                        and b.userId = '" . $userId . "'
                                                                                INNER JOIN (
                                            select min(productColorId) productColorId,combination_color,image1,image2,image3,productId from product_colors
                                            group by productId
                                        ) pc on a.productId = pc.productId
                                        where a.categoryId = '" . $categoryId . "' and a.productFlag = '1'
                                        ORDER BY a.productId desc LIMIT $limit , $offset ");
        } else {
            $data = $this->db->query("SELECT a.productId,productName,isNew,isHot,productImage,a.categoryId,productPrice,
                                        productDescription,IF(b.UserId IS NULL, 0,1) as isLiked,pc.*,childCategoryId from products a
                                        LEFT JOIN  wishlist b on (a.productId = b.productId) and (a.categoryId = b.categoryId)
                                        and b.userId = '" . $userId . "'
                                        INNER JOIN (
                                            select min(productColorId) productColorId,combination_color,image1,image2,image3,productId from product_colors
                                            group by productId
                                        ) pc on a.productId = pc.productId
                                        where a.categoryId = '" . $categoryId . "' and a.productFlag = '1'
                                        LIMIT $limit , $offset ");
        }
        
        
        $return = $data->result();
        echo json_encode($return);
    }
    
    
    function getHotProducts()
    {
        $userId = $this->input->post("userId");
        
        $data   = $this->db->query("SELECT a.productId,productName,isNew,isHot,productImage,a.categoryId,productPrice,
                                        productDescription,IF(b.UserId IS NULL, 0,1) as isLiked,pc.* from products a
                                        LEFT JOIN  wishlist b on (a.productId = b.productId) and (a.categoryId = b.categoryId)
                                        and b.userId = '" . $userId . "'
                                        INNER JOIN (
                                            select min(productColorId) productColorId,combination_color,image1,image2,image3,productId from product_colors
                                            group by productId
                                        ) pc on a.productId = pc.productId
                                         where isHot = 1");
        $return = $data->result();
        echo json_encode($return);
    }
    
    function getNewProducts()
    {
        $userId = $this->input->post("userId");
        $data   = $this->db->query("SELECT a.productId,productName,isNew,isHot,productImage,a.categoryId,productPrice,
                                        productDescription,IF(b.UserId IS NULL, 0,1) as isLiked,pc.* from products a
                                        LEFT JOIN  wishlist b on (a.productId = b.productId) and (a.categoryId = b.categoryId)
                                        and b.userId = '" . $userId . "' 
                                        INNER JOIN (
                                            select min(productColorId) productColorId,combination_color,image1,image2,image3,productId from product_colors
                                            group by productId
                                        ) pc on a.productId = pc.productId
                                        where isNew = 1");
        $return = $data->result();
        echo json_encode($return);
    }
    
    function getProduct($productId)
    {
        $data   = $this->db->query("SELECT productId,productName,isNew,isHot,productImage,categoryId,productPrice,productDescription from products where productId = '" . $productId . "' ");
        $return = $data->result();
        echo json_encode($return);
    }
    
    function getProductsSearch()
    {
        $productName          = $this->input->post("productName");
        $productCategory      = $this->input->post("productCategory");
        $productStartingPrice = $this->input->post("productStartingPrice");
        $productEndPrice      = $this->input->post("productEnd");
        $userId               = $this->input->post("userId");
        if ($productCategory != "AllCategories") {
            if ($productStartingPrice == "") {
                $data = $this->db->query("SELECT a.productId,productName,isNew,isHot,productImage,a.categoryId,productPrice,
                                        productDescription,IF(b.UserId IS NULL, 0,1) as isLiked,pc.*,childCategoryId from products a
                                        LEFT JOIN  wishlist b on (a.productId = b.productId) and (a.categoryId = b.categoryId)
                                        and b.userId = '" . $userId . "'
                                        INNER JOIN (
                                                select min(productColorId) productColorId,combination_color,image1,image2,image3,productId from product_colors
                                                group by productId
                                            ) pc on a.productId = pc.productId
                                        where  a.categoryId = '" . $productCategory . "'  and productName like '%" . $productName . "%' ");
            } else {
                if ($productEndPrice == "") {
                    $data = $this->db->query("SELECT a.productId,productName,isNew,isHot,productImage,a.categoryId,productPrice,
                                        productDescription,IF(b.UserId IS NULL, 0,1) as isLiked,pc.*,childCategoryId from products a
                                        LEFT JOIN  wishlist b on (a.productId = b.productId) and (a.categoryId = b.categoryId)
                                        and b.userId = '" . $userId . "'
                                        INNER JOIN (
                                                select min(productColorId) productColorId,combination_color,image1,image2,image3,productId from product_colors
                                                group by productId
                                            ) pc on a.productId = pc.productId
                                        where a.categoryId = '" . $productCategory . "'  and productName like '%" . $productName . "%' and productPrice >= '" . $productStartingPrice . "'");
                } else {
                    $data = $this->db->query("SELECT a.productId,productName,isNew,isHot,productImage,a.categoryId,productPrice,
                                        productDescription,IF(b.UserId IS NULL, 0,1) as isLiked,pc.*,childCategoryId from products a
                                        LEFT JOIN  wishlist b on (a.productId = b.productId) and (a.categoryId = b.categoryId)
                                        and b.userId = '" . $userId . "'
                                        INNER JOIN (
                                                select min(productColorId) productColorId,combination_color,image1,image2,image3,productId from product_colors
                                                group by productId
                                            ) pc on a.productId = pc.productId
                                        where a.categoryId = '" . $productCategory . "'  and productName like '%" . $productName . "%' and productPrice >= '" . $productStartingPrice . "' and productPrice <= '" . $productEndPrice . "'");
                }
            }
            
        } else {
            if ($productStartingPrice == "") {
                $data = $this->db->query("SELECT a.productId,productName,isNew,isHot,productImage,a.categoryId,productPrice,
                                        productDescription,IF(b.UserId IS NULL, 0,1) as isLiked,pc.*,childCategoryId from products a
                                        LEFT JOIN  wishlist b on (a.productId = b.productId) and (a.categoryId = b.categoryId)
                                        and b.userId = '" . $userId . "'
                                        INNER JOIN (
                                                select min(productColorId) productColorId,combination_color,image1,image2,image3,productId from product_colors
                                                group by productId
                                            ) pc on a.productId = pc.productId
                                        where  productName like '%" . $productName . "%'");
            } else {
                if ($productEndPrice == "") {
                    $data = $this->db->query("SELECT a.productId,productName,isNew,isHot,productImage,a.categoryId,productPrice,
                                        productDescription,IF(b.UserId IS NULL, 0,1) as isLiked,pc.*,childCategoryId from products a
                                        LEFT JOIN  wishlist b on (a.productId = b.productId) and (a.categoryId = b.categoryId)
                                        and b.userId = '" . $userId . "'
                                        INNER JOIN (
                                                select max(productColorId) productColorId,combination_color,image1,image2,image3,productId from product_colors
                                                group by productId
                                            ) pc on a.productId = pc.productId
                                        where  productName like '%" . $productName . "%' and productPrice >= '" . $productStartingPrice . "'");
                } else {
                    $data = $this->db->query("SELECT a.productId,productName,isNew,isHot,productImage,a.categoryId,productPrice,
                                        productDescription,IF(b.UserId IS NULL, 0,1) as isLiked,pc.*,childCategoryId from products a
                                        LEFT JOIN  wishlist b on (a.productId = b.productId) and (a.categoryId = b.categoryId)
                                        and b.userId = '" . $userId . "'
                                        INNER JOIN (
                                                select min(productColorId) productColorId,combination_color,image1,image2,image3,productId from product_colors
                                                group by productId
                                            ) pc on a.productId = pc.productId
                                        where  productName like '%" . $productName . "%' and productPrice >= '" . $productStartingPrice . "' and productPrice <= '" . $productEndPrice . "'");
                }
            }
        }
        
        $return = $data->result();
        echo json_encode($return);
    }
    
    function getStores($longitude = "", $Latitude = "")
    {
        $data   = $this->db->query("SELECT *,storeMall as storeName from store");
        $return = $data->result();
        echo json_encode($return);
    }
    function getUserPoints()
    {
        $userId   = $this->input->post("userId");
        $cekEmail = $this->db->query("select b.userId,b.userFullname,IFNULL(TotalPoint,0) as TotalPoint 
                from TransactionMember a RIGHT JOIN members b on a.UserId = b.userId 
                where b.UserId = '" . $userId . "' order by TransactionDate desc limit 1");
        
        
        echo json_encode($cekEmail->row());
    }
    
    function getUserImage()
    {
        $userId   = $this->input->post("userId");
        $cekEmail = $this->db->query("select * from members where UserId = '" . $userId . "'");
        
        if ($cekEmail) {
            $data['userInfo'] = $cekEmail->row();
            $data['err']      = 1;
        } else {
            $data['err'] = 0;
        }
        
        echo json_encode($data);
    }
    
    function updateDeviceId()
    {
        $userDeviceId = $this->input->post("userDeviceId");
        $userId       = $this->input->post("userId");
        $this->db->query("UPDATE members set userDeviceId = '" . $userDeviceId . "' where userId = '" . $userId . "'  ");
    }
    
    function sendNotification()
    {
            $msg = array
            (
                'body' => "Nomor userId member di ubah, harap logout ya , biar tidak error",
                'tag' => "185",
                'title' => 'LF Member',
                'icon' => 'myicon',
                'sound' => 'mySound',
                'priority' => 'high',
                'show_in_foreground' => True,
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            );
            
            $fields = array
            (
                'to' => 'cLxg-77-13U:APA91bH92Y_OBRpKB8qyOBcCqDpmtY9O6U0LVoJXUTXUcLY0dWFwgKOr-gFDQhHnWDINzLQh0h5ctL3RKNxz6KvOWdckRmbDz9ElPCjIs9VQ51Bp2IkoRsAY4puKp76mUC_q2S-PT6Vi',
                'notification' => $msg
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
            
    }
    
    function countNotification()
    {
        $userId = $this->input->post("userId");
        $data   = $this->db->query("
        SELECT * FROM (
        SELECT a.notificationId,
        notificationTitle,
        notificationBody,
        notificationDate,
        notificationImage ,
        IF(b.UserId IS NULL, 0,1) AS notificationFlag
        FROM notification a 
        LEFT JOIN notification_read b ON a.notificationId = b.notificationId AND b.userId = '".$userId."' ) 
        a WHERE notificationFlag = 0 and notificationId not in (
                    select notificationId from notification_delete where UserId = '".$userId."'
                )")->num_rows();
        echo json_encode($data);
    }
    
    function getNotification($limit = 0, $offset = 0)
    {
        $userId = $this->input->post("userId");
        $data   = $this->db->query("SELECT a.notificationId,
                        notificationTitle,
                        notificationBody,
                        notificationDate,
                        notificationImage ,
                        IF(b.UserId IS NULL, 0,1) as notificationFlag
                        FROM notification a 
                        left join notification_read b on a.notificationId = b.notificationId and b.userId = '".$userId."'
                            where a.notificationId not in (
                        select notificationId from notification_delete where UserId = 'M-00710'
                    )
                
                         order by notificationDate desc limit $limit,$offset ")->result();
        echo json_encode($data);
    }
    
    function updateNotification()
    {
        $notificationId = $this->input->post("notificationId");
        $userId         = $this->input->post("userId");

        $data = $this->db->query("SELECT * FROM notification_read where  notificationId = '" . $notificationId . "' and userId = '".$userId."'");

        if($data->num_rows() < 1){
            $this->db->query("INSERT INTO notification_read (notificationId,userId,readDate) values ('".$notificationId."','".$userId."',NOW()) ");         
        }
    }
    
    function removeNotification()
    {
        $notificationId = $this->input->post("notificationId");
        $userId         = $this->input->post("userId");
        $data = $this->db->query("SELECT * FROM notification_delete where  notificationId = '" . $notificationId . "' and userId = '".$userId."'");
        if($data->num_rows() < 1){
            $this->db->query("INSERT INTO notification_delete (notificationId,userId,deleteDate) values ('".$notificationId."','".$userId."',NOW()) ");         
        }

    }
    
    function insertWishlist()
    {
        $userId     = $this->input->post("userId");
        $productId  = $this->input->post("productId");
        $categoryId = $this->input->post("categoryId");
        $this->db->query("DELETE from wishlist where productId ='".$productId."' and categoryId = '".$categoryId."' and userId = '".$userId."'  ");
        $this->db->query("INSERT INTO wishlist (productId,categoryId,createdDate,userId) values ('" . $productId . "','" . $categoryId . "',NOW(),'" . $userId . "') ");
    }
    
    function deleteWishlist()
    {
        $userId     = $this->input->post("userId");
        $productId  = $this->input->post("productId");
        $categoryId = $this->input->post("categoryId");
        $this->db->query("DELETE from wishlist where userId = '" . $userId . "' and productId = '" . $productId . "' and categoryId = '" . $categoryId . "'");
    }
    
    function getProductColors()
    {
        $productId = $this->input->post("productId");
        $data      = $this->db->query("SELECT * FROM product_colors a inner join combination_color cc on a.combination_color = cc.ccId where productId = '" . $productId . "' order by productColorId ")->result();
        echo json_encode($data);
    }

      function getWishlisted()
    {
        $userId = $this->input->post("userId");
        $data   = $this->db->query("SELECT a.productId,productName,isNew,isHot,productImage,a.categoryId,productPrice,
                                        productDescription,IF(b.UserId IS NULL, 0,1) as isLiked,pc.* from products a
                                        INNER JOIN  wishlist b on (a.productId = b.productId) and (a.categoryId = b.categoryId)
                                        and b.userId = '" . $userId . "' 
                                        INNER JOIN (
                                            select min(productColorId) productColorId,combination_color,image1,image2,image3,productId from product_colors
                                            group by productId
                                        ) pc on a.productId = pc.productId");
        $return = $data->result();
        echo json_encode($return);
    }

    function feedback(){
    	$feedbackContent = $this->input->post("feedbackContent");
    	$userId = $this->input->post("userId");

    	$this->db->query("INSERT into feedback (userId,feedbackDate,feedbackContent) values ('".$userId."',NOW(),'".$feedbackContent."')  ");
    }

    function getPromotion(){
        $data = $this->db->query("SELECT * From promotion")->result();
        echo json_encode($data);
    }

    function getLastTransaction(){
        $userId = $this->input->post("userId");
        $data      = $this->db->query("select TransactionDate,UserId,storeMall,IFNULL(PointUsage,0) as PointUsage,IFNULL(RewardPoint,0) as RewardPoint,IFNULL(TotalPoint,0) as TotalPoint from TransactionMember a 
inner join store b on a.OutletLocation = b.storeName
where UserId = '".$userId."' order by TransactionDate desc limit 5
")->result();
        echo json_encode($data);
    }
    
function getProvince(){
	header('Access-Control-Allow-Origin: *');
    	header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    	header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

    	$curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "key: 5882027194d829e46c2cdd55f8875dde"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          return "cURL Error #:" . $err;
        } else {
          return $response;
        }
}
function getCity(){
        header('Access-Control-Allow-Origin: *');
    	header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    	header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.rajaongkir.com/starter/city",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
            "key: 5882027194d829e46c2cdd55f8875dde"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    return "cURL Error #:" . $err;
} else {
    return $response;
}
}
function calculatePrice($from, $to ,$cour){
header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "origin=$from&weight=1000&destination=$to&courier=$cour",
  CURLOPT_HTTPHEADER => array(
    "content-type: application/x-www-form-urlencoded",
            "key: 5882027194d829e46c2cdd55f8875dde"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  return "cURL Error #:" . $err;
} else {
  return $response;
}    
}


function message(){
    $userId = $this->input->post("userId");
    $userId = "M-00710";
    $data = $this->db->query("SELECT * FROM message where userId = '".$userId."' ")->result();
    echo htmlspecialchars(json_encode($data));
}

 
    function countMessage()
    {
        $userId = $this->input->post("userId");
        $data   = $this->db->query("
       SELECT *
        FROM message where 
				readFlag = 0 and deleteFlag = 0 and userId = '".$userId."' 
				")->num_rows();
        echo json_encode($data);
    }

    function getMessage($limit = 0, $offset = 0)
    {
        $userId = $this->input->post("userId");
        $data   = $this->db->query(" SELECT *
        FROM message where userId = '".$userId."' and deleteFlag <> 1 order by messageId desc limit $limit,$offset ")->result();
    echo json_encode($data);
    }
    
    function removeMessage(){
        $userId     = $this->input->post("userId");
        $messageId  = $this->input->post("messageId");
        $this->db->query("UPDATE message set deleteFlag = 1 where userId = '".$userId."' and messageId = '".$messageId."' ");
    }

    function readMessage(){
        $userId     = $this->input->post("userId");
        $messageId  = $this->input->post("messageId");
        $this->db->query("UPDATE message set readFlag = 1 where userId = '".$userId."' and messageId = '".$messageId."' ");
    }

    function phpversion(){
        echo 'Current PHP version: ' . phpversion();
    }
   function getItemInfo(){
        $productId = $this->input->post("productId");
        $queryresult = $this->db->query("select productID,a.SizeID,SizeDescription,TipeProduct  from TransactionItemSalesStock a inner join size b on a.SizeID = b.SizeID 
                                            where productID = '".$productId."' group by productID,a.SizeID,SizeDescription,TipeProduct ")->result();
         foreach ($queryresult as $key) {
           $info = explode(";", $key->SizeDescription);
           if($key->TipeProduct == "C_00001"){
                $data[] = array ( 
                    "SizeID"            => $key->SizeID,  
                    "SizeDescription" => " Panjang : ".$info[0]. " Lebar : ". $info[1]. " Tinggi : " .$info[2]. " Berat :" .$info[3],
                    "TipeProduct" => $key->TipeProduct,
                    "productId" => $key->productID
                                    );
           }else if($key->TipeProduct == "C_00007"){
                $data[] = array ( 
                    "SizeID" => $key->SizeID,  
                    "SizeDescription" => " Panjang : ".$info[0]. " Lebar : ". $info[1]. " Tinggi : " .$info[2]. " Berat :" .$info[3] . " Ukuran :" .$info[4],
                    "TipeProduct" => $key->TipeProduct,
                    "productId" => $key->productID,
                );
           }else if($key->TipeProduct == "C_00003"){
                $data[] = array ( 
                    "SizeID" => $key->SizeID,  
                    "SizeDescription" => " Panjang : ".$info[0]. " Lebar : ". $info[1]. " Tinggi : " .$info[2]. " Berat :" .$info[3] . " Ukuran :" .$info[4],
                    "TipeProduct" => $key->TipeProduct,
                    "productId" => $key->productID,
                );
           }
        }
          echo json_encode($data);
    }

    function getItemInfo2(){
        $productId = $this->input->post("productId");
        $productColorId =  $this->input->post("productColorId");

       // $productId = "p_00018";
       // $productColorId = "PC00000000010";

        $data = [];
        $queryresult = $this->db->query("select b.SizeID,a.productId,pc.productColorId,ccName,SizeDescription,ProductSizeId,TipeProduct,productName,categoryName  
                                            from products a 
                                            inner join product_colors pc on a.productId = pc.productId 
                                            inner join combination_color cc on combination_color = ccId 
                                            inner join ProductSize ps on  ps.productId = a.productId and pc.productColorId = ps.productColorId
                                            inner join size b on ps.SizeID = b.SizeID 
                                            inner join product_categories cat on cat.categoryId = a.categoryId
                                            where a.productId = '".$productId."' and pc.productColorId = '".$productColorId."'  
                                            group by a.productId,b.SizeID,SizeDescription,TipeProduct,ccName,productName,categoryName ")->result();
         foreach ($queryresult as $key) {
           $info = explode(";", $key->SizeDescription);
           if($key->TipeProduct == "C_00001"){
                $data[] = array ( 
                    "SizeID"            => $key->SizeID,  
                    "SizeDescription" => $info[0]. " x " . $info[1]. " x " .$info[2],
                    "productWeight"    => $info[3],
                    "TipeProduct" => $key->TipeProduct,
                    "productId" => $key->productId,
                    "productColorId" => $key->productColorId,
                    "colorName" => $key->ccName,
                    "productName" => $key->productName,
                    "categoryName" => $key->categoryName
                                    );
           }else if($key->TipeProduct == "C_00007"){
                $data[] = array ( 
                    "SizeID" => $key->SizeID,  
                    "SizeDescription" => $info[0]. " x " . $info[1]. " x " .$info[2]. " Size :" .$info[4],
                    "productWeight"    => $info[3],
                    "TipeProduct" => $key->TipeProduct,
                    "productId" => $key->productId,
                    "productColorId" => $key->productColorId,
                    "colorName" => $key->ccName,
                    "productName" => $key->productName,
                    "categoryName" => $key->categoryName

                );
           }else if($key->TipeProduct == "C_00003"){
                $data[] = array ( 
                    "SizeID" => $key->SizeID,  
                    "SizeDescription" => $info[0]. " x " . $info[1]. " x " .$info[2]. " Size :" .$info[4],
                    "productWeight"    => $info[3],
                    "TipeProduct" => $key->TipeProduct,
                    "productId" => $key->productId,
                    "productColorId" => $key->productColorId,
                    "colorName" => $key->ccName,
                    "productName" => $key->productName,
                    "categoryName" => $key->categoryName
                );
           }
        }
          echo json_encode($data);
    }

    function insertToCart(){
        $userId = $this->input->post("userId");
        $productId = $this->input->post("productId");
        $productColorId = $this->input->post("productColorId");
        $sizeId = $this->input->post("sizeId");
        $qty = 1;
        $maxId = $this->getMaxCartId($userId);

        $data = array(
            "cartId" => $maxId,
            "userId" => $userId,
            "productId" => $productId,
            "productColorId"=>$productColorId,
            "sizeId" => $sizeId,
            "qty" => $qty,
            "storeId" => "",
            "createdDate" => date("Y-m-d H:i:s"),
            "cartFlag" => 0
        );
        $run = $this->db->insert("cart",$data);


    }

    function getMaxCartId($userId){
        $data = $this->db->query("SELECT MAX(cartId) cartId FROM cart where userId = '".$userId."' and MONTH(createdDate) = MONTH(NOW()) and YEAR(createdDate) = YEAR(NOW()) ")->row();
        if(++$data->cartId == "1"){
			$maxId = "CART-".$userId."-".date('m').date('y')."000001";
		}else{
            $maxId = $data->cartId;
            $maxId = $maxId++;
		}
        return $maxId;
    }

    function countCart(){
        $userId = $this->input->post("userId");
        $queryresult = $this->db->query("SELECT * FROM cart where userId = '".$userId."'");
        echo json_encode($queryresult->num_rows());
    }

    function getCart(){
        $userId = $this->input->post("userId");
        $userId = "M-00710";
        $data = [];
        $queryresult = $this->db->query("select cartId,a.productColorId,a.productID,a.SizeID,SizeDescription,TipeProduct,ccName,productName,categoryName,sum(a.qty) as quantity,image1,p.productPrice as price
                                            from cart a 
                                                inner join size b on a.SizeID = b.SizeID 
                                                inner join product_colors pc on a.productId = pc.productId and a.productColorID = pc.productColorID
                                                inner join combination_color cc on pc.combination_color = ccId
                                                inner join products p on p.productId = a.productId
                                                inner join product_categories cat on p.categoryId = cat.categoryId
                                            where a.userId = '".$userId."' 
                                            group by a.productID,a.SizeID,SizeDescription,TipeProduct,ccName,productName,categoryName,image1,p.productPrice ")->result();
            foreach ($queryresult as $key) {
                $info = explode(";", $key->SizeDescription);
                if($key->TipeProduct == "C_00001"){
                        $data[] = array ( 
                            "SizeID"            => $key->SizeID,  
                            "SizeDescription" => $info[0]. " x " . $info[1]. " x " .$info[2],
                            "productWeight"    => $info[3],
                            "TipeProduct" => $key->TipeProduct,
                            "productId" => $key->productID,
                            "productColorId" => $key->productColorId,
                            "colorName" => $key->ccName,
                            "productName" => $key->productName,
                            "categoryName" => $key->categoryName,
                            "quantity" => $key->quantity,
                            "image" => $key->image1,
                            "cartId" => $key->cartId,
                            "price"=> $key->price,
                                            );
                }else if($key->TipeProduct == "C_00007"){
                        $data[] = array ( 
                            "SizeID" => $key->SizeID,  
                            "SizeDescription" => $info[0]. " x " . $info[1]. " x " .$info[2]. " Size :" .$info[4],
                            "productWeight"    => $info[3],
                            "TipeProduct" => $key->TipeProduct,
                            "productId" => $key->productID,
                            "productColorId" => $key->productColorId,
                            "colorName" => $key->ccName,
                            "productName" => $key->productName,
                            "categoryName" => $key->categoryName,
                            "quantity" => $key->quantity,
                            "image" => $key->image1,
                            "cartId" => $key->cartId,
                            "price"=> $key->price,

        
                        );
                }else if($key->TipeProduct == "C_00003"){
                        $data[] = array ( 
                            "SizeID" => $key->SizeID,  
                            "SizeDescription" => $info[0]. " x " .$info[1]. " x " .$info[2]. " Size :" .$info[4],
                            "productWeight"    => $info[3],
                            "TipeProduct" => $key->TipeProduct,
                            "productId" => $key->productID,
                            "productColorId" => $key->productColorId,
                            "colorName" => $key->ccName,
                            "productName" => $key->productName,
                            "categoryName" => $key->categoryName,
                            "quantity" => $key->quantity,
                            "image" => $key->image1,
                            "cartId" => $key->cartId,
                            "price"=> $key->price,
                        );
                }
                }
            echo json_encode($data);
    }
//getCity
    function syncProvince(){
        $data = $this->getProvince();
        $convert = json_decode($data,true);
        $this->db->query("DELETE FROM province");
        foreach ($convert['rajaongkir']['results'] as $key) {
            $this->db->query("INSERT INTO province (provinceID,provinceName) values ('".$key['province_id']."', '".$key['province']."')");
        }
    }

    function syncCity(){
        $data = $this->getCity();
        $convert = json_decode($data,true);
        $this->db->query("DELETE FROM city");
        foreach ($convert['rajaongkir']['results'] as $key) {
           // echo "INSERT INTO city (cityID,provinceID,cityName) values ('".$key['city_id']."','".$key['province_id']."', '".$key['city_name']."')";
            $this->db->query("INSERT INTO city (cityID,provinceID,cityName) values ('".$key['city_id']."','".$key['province_id']."', '".$key['city_name']."')");
        }
    }

    function deleteCart(){
        $cartId = $this->input->post("cartId");
        $this->db->query("DELETE FROM cart where cartId = '".$cartId."' ");
    }

}