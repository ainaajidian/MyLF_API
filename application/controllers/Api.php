<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Message_model');
        $this->load->model('User_model');
        $this->load->library("MyPHPMailer");
    }

    function sendConfirmationEmail($id)
    {
        $datauser = $this->db->query("SELECT userEmail from members where userId = '" . $id . "' ")->row();
        $mail = new PHPMailer();
        $mail->IsHTML(true);
        $mail->IsSMTP();
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->Host     = 'mail.rpgroup.co.id';
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@rpgroup.co.id';
        $mail->Password = 'N4ughty!';
        $mail->SMTPSecure = 'tls';
        $mail->Port     = 587;
        $mail->setFrom('no-reply@rpgroup.co.id');
        $mail->addAddress($datauser->userEmail);
        $mail->Subject = 'Active your account at Member LF';
        $data['url'] = base_url() . "Api/aktivasi/" . $id;
        $body        = $this->load->view("confirmation_email", $data, TRUE);
        $mail->Body = $body;
        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
    }

    function aktivasi($id)
    {
        $this->db->query("UPDATE members set userActive = 1, userActiveDate =  now() where userId = '" . $id . "' ");
        $this->load->view("email_active_success", TRUE);
    }

    function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
    
    function sendNewPassword()
    {
        $email = $this->input->post("email");
        $newPassword = $this->randomPassword();

        //cek email
        $dataEmail = $this->db->query("SELECT * FROM members where userEmail = '" . $email . "'");

        if ($dataEmail->num_rows() < 1) {
            $data['msg'] = "Email tidak terdaftar";
            echo json_encode($data);
            die();
        }

        $mail = new PHPMailer();
        $mail->IsHTML(true);
        $mail->IsSMTP();
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->Host     = 'mail.rpgroup.co.id';
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@rpgroup.co.id';
        $mail->Password = 'N4ughty!';
        $mail->SMTPSecure = 'tls';
        $mail->Port     = 587;
        $mail->setFrom('no-reply@rpgroup.co.id');
        $mail->addAddress($email);
        $mail->Subject = 'Password Reset';

        $data['password'] = $newPassword;
        $body             = $this->load->view("reset_password", $data, TRUE);

        $this->db->query("update members set userPassword = '" . MD5($newPassword) . "' where userEmail = '" . $email . "'  ");

        $mail->Body = $body;
        if (!$mail->send()) {
            $data['msg'] = "Gagal mengirimkan email, harap coba kembali";
        } else {
            $data['msg'] = "Kami mengirimkan password baru ke email anda";
        }
        echo json_encode($data);
    }

    function changePassword()
    {
        $userId         = $this->input->post("userId");
        $newPassword     = $this->input->post("newPassword");

        $this->db->query("UPDATE members set userPassword = '" . MD5($newPassword) . "' where userId = '" . $userId . "'");
        echo json_encode($this->input->post());
    }

    function unregister()
    {
        $email              = $this->input->post("email");
        $password           = $this->input->post("password");
        $fullname           = $this->input->post("fullname");
        $dob                = $this->input->post("dob");
        $gender             = $this->input->post("gender");
        $deviceId           = $this->input->post("deviceId");
        $userMobilephone    = $this->input->post("phone");

        $this->db->query("DELETE members where userEmail = '".$email."' ");
        //echo json_encode($data);
    }

    function register()
    {
        $email              = $this->input->post("email");
        $password           = $this->input->post("password");
        $fullname           = $this->input->post("fullname");
        $dob                = $this->input->post("dob");
        $gender             = $this->input->post("gender");
        $deviceId           = $this->input->post("deviceId");
        $userMobilephone    = $this->input->post("phone");

        $registerDate = date("Y-m-d");

        $cekEmail = $this->db->query("SELECT * FROM members where (userEmail = '" . $email . "' or userMobilephone='".$userMobilephone."')")->num_rows();
        if ($cekEmail > 0) {
            $data['err']     = 1;
            $data['message'] = "Email atau No Handphone sudah terdaftar";
        } else {
            $id = $this->generateUserid();
            $this->db->query("INSERT INTO members (userGender,userId,userEmail,userPassword,userFullname,userBirthDate,userActive,userRegisterDate,userDeviceId,userMobilephone) 
                    values ('" . $gender . "','" . $id . "','" . $email . "','" . md5($password) . "','" . $fullname . "','" . $dob . "',1,'" . $registerDate . "','" . $deviceId . "','".$userMobilephone."') ");
            $data['err']     = 0;
            $data['message'] = "Proses Daftar sukses, kami mengirimkan email konfirmasi";
            //$this->sendConfirmationEmail($id);
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
            $data['err']      = 0;
            $data['message']  = "Login berhasil";
            $data['userInfo'] = $cekEmail->row();
        } else {
            $data['err']     = 1;
            $data['message'] = "Email atau password salah";
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

    function getChildCategory($parentCategoryId)
    {
        $data = $this->db->query("SELECT 'All' as categoryId,'All' as categoryName,'All' as categoryImage,'All' as categoryDescription
            UNION ALL SELECT categoryId,categoryName,categoryImage,categoryDescription from product_categories where parentCategoryId = '" . $parentCategoryId . "' order by categoryName asc")->result();
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
                                         where isHot = 1 and productFlag = 1");
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
                                        where isNew = 1 and productFlag = 1");
        $return = $data->result();
        echo json_encode($return);
    }

    function getProduct($productId)
    {
        $data   = $this->db->query("SELECT productId,productName,isNew,isHot,productImage,categoryId,productPrice,productDescription from products where productId = '" . $productId . "' and productFlag = 1 ");
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
        $cekEmail = $this->db->query("select b.userId,b.userFullname,IFNULL(TotalPoint,0) as TotalPoint,b.userActive 
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
        $msg = array(
            'body' => "Nomor userId member di ubah, harap logout ya , biar tidak error",
            'tag' => "185",
            'title' => 'LF Member',
            'icon' => 'myicon',
            'sound' => 'mySound',
            'priority' => 'high',
            'show_in_foreground' => True,
            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
        );

        $fields = array(
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
        LEFT JOIN notification_read b ON a.notificationId = b.notificationId AND b.userId = '" . $userId . "' ) 
        a WHERE notificationFlag = 0 and notificationId not in (
                    select notificationId from notification_delete where UserId = '" . $userId . "'
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
                        left join notification_read b on a.notificationId = b.notificationId and b.userId = '" . $userId . "'
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

        $data = $this->db->query("SELECT * FROM notification_read where  notificationId = '" . $notificationId . "' and userId = '" . $userId . "'");

        if ($data->num_rows() < 1) {
            $this->db->query("INSERT INTO notification_read (notificationId,userId,readDate) values ('" . $notificationId . "','" . $userId . "',NOW()) ");
        }
    }

    function removeNotification()
    {
        $notificationId = $this->input->post("notificationId");
        $userId         = $this->input->post("userId");
        $data = $this->db->query("SELECT * FROM notification_delete where  notificationId = '" . $notificationId . "' and userId = '" . $userId . "'");
        if ($data->num_rows() < 1) {
            $this->db->query("INSERT INTO notification_delete (notificationId,userId,deleteDate) values ('" . $notificationId . "','" . $userId . "',NOW()) ");
        }
    }

    function insertWishlist()
    {
        $userId     = $this->input->post("userId");
        $productId  = $this->input->post("productId");
        $categoryId = $this->input->post("categoryId");
        $this->db->query("DELETE from wishlist where productId ='" . $productId . "' and categoryId = '" . $categoryId . "' and userId = '" . $userId . "'  ");
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

    function feedback()
    {
        $feedbackContent = $this->input->post("feedbackContent");
        $userId = $this->input->post("userId");

        $this->db->query("INSERT into feedback (userId,feedbackDate,feedbackContent) values ('" . $userId . "',NOW(),'" . $feedbackContent . "')  ");
    }

    function getPromotion()
    {
        $data = $this->db->query("SELECT * From promotion")->result();
        echo json_encode($data);
    }

    function getLastTransaction()
    {
        $userId = $this->input->post("userId");
        $data      = $this->db->query("select TransactionDate,UserId,storeMall,IFNULL(PointUsage,0) as PointUsage,IFNULL(RewardPoint,0) as RewardPoint,IFNULL(TotalPoint,0) as TotalPoint from TransactionMember a 
inner join store b on a.OutletLocation = b.storeName
where UserId = '" . $userId . "' order by TransactionDate desc limit 5
")->result();
        echo json_encode($data);
    }

    function message()
    {
        $userId = $this->input->post("userId");
        $userId = "M-00710";
        $data = $this->db->query("SELECT * FROM message where userId = '" . $userId . "' ")->result();
        echo htmlspecialchars(json_encode($data));
    }


    function countMessage()
    {
        $userId = $this->input->post("userId");
        $data   = $this->db->query("
       SELECT *
        FROM message where 
				readFlag = 0 and deleteFlag = 0 and userId = '" . $userId . "' 
				")->num_rows();
        echo json_encode($data);
    }

    function getMessage($limit = 0, $offset = 0)
    {
        $userId = $this->input->post("userId");
        $data   = $this->db->query(" SELECT *
        FROM message where userId = '" . $userId . "' and deleteFlag <> 1 order by messageId desc limit $limit,$offset ")->result();
        echo json_encode($data);
    }

    function removeMessage()
    {
        $userId     = $this->input->post("userId");
        $messageId  = $this->input->post("messageId");
        $this->db->query("UPDATE message set deleteFlag = 1 where userId = '" . $userId . "' and messageId = '" . $messageId . "' ");
    }

    function readMessage()
    {
        $userId     = $this->input->post("userId");
        $messageId  = $this->input->post("messageId");
        $this->db->query("UPDATE message set readFlag = 1 where userId = '" . $userId . "' and messageId = '" . $messageId . "' ");
    }

    function phpversion()
    {
        echo 'Current PHP version: ' . phpversion();
    }
    function getItemInfo()
    {
        $productId = $this->input->post("productId");
        $queryresult = $this->db->query("select productID,a.SizeID,SizeDescription,TipeProduct  from TransactionItemSalesStock a inner join size b on a.SizeID = b.SizeID 
                                            where productID = '" . $productId . "' group by productID,a.SizeID,SizeDescription,TipeProduct ")->result();
        foreach ($queryresult as $key) {
            $info = explode(";", $key->SizeDescription);
            if ($key->TipeProduct == "C_00001") {
                $data[] = array(
                    "SizeID"            => $key->SizeID,
                    "SizeDescription" => " Panjang : " . $info[0] . " Lebar : " . $info[1] . " Tinggi : " . $info[2] . " Berat :" . $info[3],
                    "TipeProduct" => $key->TipeProduct,
                    "productId" => $key->productID
                );
            } else if ($key->TipeProduct == "C_00007") {
                $data[] = array(
                    "SizeID" => $key->SizeID,
                    "SizeDescription" => " Panjang : " . $info[0] . " Lebar : " . $info[1] . " Tinggi : " . $info[2] . " Berat :" . $info[3] . " Size :" . $info[4],
                    "TipeProduct" => $key->TipeProduct,
                    "productId" => $key->productID,
                );
            } else if ($key->TipeProduct == "C_00003") {
                $data[] = array(
                    "SizeID" => $key->SizeID,
                    "SizeDescription" => " Panjang : " . $info[0] . " Lebar : " . $info[1] . " Tinggi : " . $info[2] . " Berat :" . $info[3] . " Size :" . $info[4],
                    "TipeProduct" => $key->TipeProduct,
                    "productId" => $key->productID,
                );
            }
        }
        echo json_encode($data);
    }

    function getItemInfo2()
    {
        $productId = $this->input->post("productId");
        $productColorId =  $this->input->post("productColorId");

        $data = [];
        $queryresult = $this->db->query("select b.SizeID,a.productId,pc.productColorId,ccName,SizeDescription,ProductSizeId,TipeProduct,productName,categoryName  
                                            from products a 
                                            inner join product_colors pc on a.productId = pc.productId 
                                            inner join combination_color cc on combination_color = ccId 
                                            inner join ProductSize ps on  ps.productId = a.productId and pc.productColorId = ps.productColorId
                                            inner join size b on ps.SizeID = b.SizeID 
                                            inner join product_categories cat on cat.categoryId = a.categoryId
                                            where a.productId = '" . $productId . "' and pc.productColorId = '" . $productColorId . "'  
                                            group by a.productId,b.SizeID,SizeDescription,TipeProduct,ccName,productName,categoryName 
                                            order by b.SizeDescription asc
                                            ")->result();
        foreach ($queryresult as $key) {
            $info = explode(";", $key->SizeDescription);
            if ($key->TipeProduct == "C_00001") {
                $data[] = array(
                    "SizeID"            => $key->SizeID,
                    "SizeDescription" => $info[0],
                    "productWeight"    => $info[1],
                    "TipeProduct" => $key->TipeProduct,
                    "productId" => $key->productId,
                    "productColorId" => $key->productColorId,
                    "colorName" => $key->ccName,
                    "productName" => $key->productName,
                    "categoryName" => $key->categoryName
                );
            } else if ($key->TipeProduct == "C_00007") {
                $data[] = array(
                    "SizeID" => $key->SizeID,
                    "SizeDescription" => "Size " . $info[0],
                    "productWeight"    => $info[1],
                    "TipeProduct" => $key->TipeProduct,
                    "productId" => $key->productId,
                    "productColorId" => $key->productColorId,
                    "colorName" => $key->ccName,
                    "productName" => $key->productName,
                    "categoryName" => $key->categoryName

                );
            } else if ($key->TipeProduct == "C_00003") {
                $data[] = array(
                    "SizeID" => $key->SizeID,
                    "SizeDescription" => $info[0],
                    "productWeight"    => $info[1],
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

    function insertToCart()
    {
        $userId = $this->input->post("userId");
        $productId = $this->input->post("productId");
        $productColorId = $this->input->post("productColorId");
        $sizeId = $this->input->post("sizeId");
        $qty = 1;
        $maxId = $this->getMaxCartId($userId);

        $cekData = $this->db->query("SELECT * FROM cart where userId = '" . $userId . "' and ( midtransStatusCode <> 200 or midtransStatusCode is null) and cartFlag = 0");

        if ($cekData->num_rows() > 0) {
            $rslt = array("status" => "1");
            echo json_encode($rslt);
            die();
        }
        $cekStockGlobal = $this->db->query("SELECT * FROM TransactionItemSalesStock 
                    where productID = '" . $productId . "' and sizeID = '".$sizeId."'  and ProductColorID = '" . $productColorId . "' and StockQty > 0 ")->num_rows();

        if ($cekStockGlobal < 1) {
            $rslt = array("status" => "2");
            echo json_encode($rslt);
            die();
        }

        $dataProduct = $this->db->query("SELECT productPrice FROM products where productId = '".$productId."' ")->row();
        $data = array(
            "cartId" => $maxId,
            "userId" => $userId,
            "productId" => $productId,
            "productColorId" => $productColorId,
            "sizeId" => $sizeId,
            "qty" => $qty,
            "storeId" => "",
            "createdDate" => date("Y-m-d H:i:s"),
            "cartFlag" => 0,
            "customerReceiveStatus" => 0,
            "productPrice" => $dataProduct->productPrice,
            "productPriceAfterPromo" => $dataProduct->productPrice,
            "disc" => 0,

        );
        $this->db->insert("cart", $data);

       $rslt = array("status" => "0");
       echo json_encode($rslt);
       die();
    }

    function getMaxCartId($userId)
    {
        $data = $this->db->query("SELECT MAX(cartId) cartId FROM cart where userId = '" . $userId . "' and MONTH(createdDate) = MONTH(NOW()) and YEAR(createdDate) = YEAR(NOW()) ")->row();
        if (++$data->cartId == "1") {
            $maxId = "CART-" . $userId . "-" . date('m') . date('y') . "000001";
        } else {
            $maxId = $data->cartId;
            $maxId = $maxId++;
        }
        return $maxId;
    }

    function countCart()
    {
        $userId = $this->input->post("userId");
        $queryresult = $this->db->query("SELECT * FROM cart where userId = '" . $userId . "' and cartFlag = 0 ");
        echo json_encode($queryresult->num_rows());
    }

    function getCart()
    {
        $userId = $this->input->post("userId");
        $data = [];
        $queryresult = $this->db->query("select a.cartId,a.deliveryAddressId,a.productColorId,a.productID,a.SizeID,SizeDescription,TipeProduct,ccName,productName,categoryName,sum(a.qty) as quantity,image1,p.productPrice as price
                                            from cart a 
                                                inner join size b on a.SizeID = b.SizeID 
                                                inner join product_colors pc on a.productId = pc.productId and a.productColorID = pc.productColorID
                                                inner join combination_color cc on pc.combination_color = ccId
                                                inner join products p on p.productId = a.productId
                                                inner join product_categories cat on p.categoryId = cat.categoryId
                                            where a.userId = '" . $userId . "' and (cartFlag IS NULL or cartFlag = 0) 
                                            and 
                                            (midtransStatusCode IS NULL or midtransStatusCode = '')
                                            group by a.deliveryAddressId,a.productID,a.SizeID,SizeDescription,TipeProduct,ccName,productName,categoryName,image1,p.productPrice ")->result();
        foreach ($queryresult as $key) {
            $info = explode(";", $key->SizeDescription);
            if ($key->TipeProduct == "C_00001") {
                $data[] = array(
                    "SizeID"            => $key->SizeID,
                    "SizeDescription" => $info[0],
                    "productWeight"    => $info[1],
                    "TipeProduct" => $key->TipeProduct,
                    "productId" => $key->productID,
                    "productColorId" => $key->productColorId,
                    "colorName" => $key->ccName,
                    "productName" => $key->productName,
                    "categoryName" => $key->categoryName,
                    "quantity" => $key->quantity,
                    "image" => $key->image1,
                    "cartId" => $key->cartId,
                    "price" => $key->price,
                    "deliveryAddressId" => $key->deliveryAddressId
                );
            } else if ($key->TipeProduct == "C_00007") {
                $data[] = array(
                    "SizeID" => $key->SizeID,
                    "SizeDescription" => "Size " . $info[0],
                    "productWeight"    => $info[1],
                    "TipeProduct" => $key->TipeProduct,
                    "productId" => $key->productID,
                    "productColorId" => $key->productColorId,
                    "colorName" => $key->ccName,
                    "productName" => $key->productName,
                    "categoryName" => $key->categoryName,
                    "quantity" => $key->quantity,
                    "image" => $key->image1,
                    "cartId" => $key->cartId,
                    "price" => $key->price,
                    "deliveryAddressId" => $key->deliveryAddressId


                );
            } else if ($key->TipeProduct == "C_00003") {
                $data[] = array(
                    "SizeID" => $key->SizeID,
                    "SizeDescription" => $info[0],
                    "productWeight"    => $info[1],
                    "TipeProduct" => $key->TipeProduct,
                    "productId" => $key->productID,
                    "productColorId" => $key->productColorId,
                    "colorName" => $key->ccName,
                    "productName" => $key->productName,
                    "categoryName" => $key->categoryName,
                    "quantity" => $key->quantity,
                    "image" => $key->image1,
                    "cartId" => $key->cartId,
                    "price" => $key->price
                );
            }
        }
        echo json_encode($data);
    }

    function deleteCart()
    {
        $cartId = $this->input->post("cartId");
        $dataCart = $this->db->query("SELECT * FROM cart where cartId = '".$cartId."'")->row();

        $this->db->query("UPDATE TransactionItemSalesStock set StockQty = StockQty + $dataCart->qty 
                                where storeID = '".$dataCart->storeId."'
                                 and productID = '".$dataCart->productId."' 
                                 and ProductColorID = '".$dataCart->productColorId."'
                                 and SizeID = '".$dataCart->sizeId."' 
                                ");
        //$this->db->query("DELETE FROM cart where cartId = '" . $cartId . "' ");
        if( ($dataCart->midtransOrderID != "" || $dataCart->midtransOrderID != null) && ($dataCart->midtransStatusCode != "202" || $dataCart->midtransStatusCode != 202)){
            $this->cancelTransaction($dataCart->midtransOrderID);
        }
        $this->db->query("UPDATE cart set cartFlag = 2, deletedDate = NOW(), deletedBy = '".$dataCart->userId."' where cartId = '".$cartId."'");

    }

    function getAddress($userId)
    {
        $data = $this->db->query("SELECT a.*,b.cityName,c.provinceName FROM delivery_address a 
        inner join city b on a.addressCityId = b.cityID  
        inner join province c on a.addressProvinceId = c.provinceID where userId = '" . $userId . "' ");
        echo json_encode($data->result());
    }


    function getProvince()
    {
        $data = $this->db->query("SELECT * FROM province order by provinceName asc")->result();
        echo json_encode($data);
    }

    function getCity($provinceID)
    {
        $data = $this->db->query("SELECT * FROM city where provinceID = '" . $provinceID . "' order by cityName asc")->result();
        echo json_encode($data);
    }

    function saveAddress()
    {
        $userId = $this->input->post("userId");
        $addressName = $this->input->post("addressName");
        $addressProvinceId = $this->input->post("addressProvinceId");
        $addressCityId = $this->input->post("addressCityId");
        $addressRemark = $this->input->post("addressRemark");
        $addressLongitude = $this->input->post("addressLongitude");
        $addressLatitude = $this->input->post("addressLatitude");
        $addressSubdistrictId = $this->input->post("addressSubdistrictId");

        $maxId = $this->getMaxDeliveryId();

        $dataSave = array(
            "userId" => $userId,
            "addressName" => $addressName,
            "addressProvinceId" => $addressProvinceId,
            "addressCityId" => $addressCityId,
            "addressRemark" => $addressRemark,
            "deliveryAddressId" => $maxId,
            "addressLongitude" => $addressLongitude,
            "addressLatitude" => $addressLatitude,
            "addressSubdistrictId" => $addressSubdistrictId

        );

        $this->db->insert("delivery_address", $dataSave);
    }

    function getMaxDeliveryId()
    {
        $data = $this->db->query("SELECT MAX(deliveryAddressId) deliveryAddressId FROM delivery_address")->row();
        if (++$data->deliveryAddressId == "1") {
            $maxId = "DLVRY-00000000001";
        } else {
            $maxId = $data->deliveryAddressId;
            $maxId = $maxId++;
        }
        return $maxId;
    }

    function deleteAddress()
    {
        $deliveryAddressId = $this->input->post("deliveryAddressId");
        $this->db->query("DELETE FROM delivery_address where deliveryAddressId = '" . $deliveryAddressId . "'");
    }

    function saveCartAddress($cartId = "", $deliveryAddressId = "")
    {
        $this->db->query("UPDATE cart set deliveryAddressId = '" . $deliveryAddressId . "' where cartId = '" . $cartId . "'");
    }

    function updateCartQty()
    {
        $cartId     = $this->input->post("cartId");
        $quantity   = $this->input->post("quantity");
        $this->db->query("UPDATE cart set qty = '" . $quantity . "' where cartId = '" . $cartId . "'");
    }

    function getCartTotal($userId)
    {
        $data = $this->db->query("
        select sum(total) total from (
        SELECT productPrice * qty as total from cart a inner join products b on a.productId = b.productId 
        where userId = '" . $userId . "'
        ) a
        
        ")->row();
        echo json_encode($data->total);
    }

    function getStoresCart($cartId)
    {
        $cartData = $this->db->query("SELECT * FROM cart where cartId = '" . $cartId . "'")->row();

        $data = $this->db->query("SELECT productId,productColorId,a.storeName,storeMall,storeLongitude,storeLatitude,StockQty,storeWhatsApp FROM store a 
        inner join TransactionItemSalesStock b on a.storeName = b.storeID 
                                    where productId = '" . $cartData->productId . "' 
                                    and productColorId = '" . $cartData->productColorId . "'
                                    and sizeId = '" . $cartData->sizeId . "'
                                    and StockQty > 0
                                     ")->result();
        echo json_encode($data);
    }

    function getCourier()
    {
        $data = $this->db->query("SELECT * FROM Couriers")->result();
        echo json_encode($data);
    }

    function getDeliveryPrice()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=501&originType=city&destination=574&destinationType=subdistrict&weight=1700&courier=jne",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: 5882027194d829e46c2cdd55f8875dde"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    function setCartAddress()
    {
        $cartId                 = $this->input->post("cartId");
        $deliveryAddressId      = $this->input->post("deliveryAddressId");

        $this->db->query("UPDATE cart set deliveryAddressId = '" . $deliveryAddressId . "' where cartId = '" . $cartId . "'");
    }

    function setCartStore()
    {
        $cartId                 = $this->input->post("cartId");
        $storeId                = $this->input->post("storeId");

        //Ambil store sebelumnya //

        $dataCart = $this->db->query("SELECT * FROM cart where cartId = '".$cartId."'")->row();

        $this->db->query("UPDATE TransactionItemSalesStock set StockQty = StockQty + $dataCart->qty 
                                where storeID = '".$dataCart->storeId."'
                                 and productID = '".$dataCart->productId."' 
                                 and ProductColorID = '".$dataCart->productColorId."'
                                 and SizeID = '".$dataCart->sizeId."' 
                                ");

        $this->db->query("UPDATE TransactionItemSalesStock set StockQty = StockQty - $dataCart->qty 
                                where storeID = '".$storeId."'
                                 and productID = '".$dataCart->productId."' 
                                 and ProductColorID = '".$dataCart->productColorId."'
                                 and SizeID = '".$dataCart->sizeId."' 
                                ");

        $this->db->query("UPDATE cart set storeId = '" . $storeId . "' where cartId = '" . $cartId . "'");
    }
    function calculatePrice()
    {
        $cartId                 = $this->input->post("cartId");
        $dataCart = $this->db->query("SELECT * from cart a 
                                        inner join store b on a.storeId = b.storeName
                                        inner join delivery_address c on a.deliveryAddressId = c.deliveryAddressId
                                         where cartId = '" . $cartId . "'")->row();
        $cityOrigin = $dataCart->storeSubdistrictId;
        $cityDestination = $dataCart->addressSubdistrictId;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=" . $cityOrigin . "&originType=subdistrict&destination=" . $cityDestination . "&destinationType=subdistrict&weight=1&courier=jnt:jne:tiki",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: 5882027194d829e46c2cdd55f8875dde"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        // print_r($response);die();
        curl_close($curl);
        $hasil[]= array("CourId" => "PICK UP", "CourName" => "Pick Up", "services" => "Pick Up" , "cost" => "0", "etd" => "Pick Up");
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $data = json_decode($response, true);
            for ($a = 0; $a < count($data['rajaongkir']['results']); $a++) {
                for ($x = 0; $x < count($data['rajaongkir']['results'][$a]['costs']); $x++) {
                    for ($y = 0; $y < count($data['rajaongkir']['results'][$a]['costs'][$x]['cost']); $y++) {
                        $hasil[] = array(
                            "CourId" => strtoupper($data['rajaongkir']['results'][$a]['code']),
                            "CourName" => strtoupper($data['rajaongkir']['results'][$a]['name']),
                            "services" => $data['rajaongkir']['results'][$a]['costs'][$x]['service'],
                            "cost" => "" . $data['rajaongkir']['results'][$a]['costs'][$x]['cost'][$y]['value'] . "",
                            "etd" => $data['rajaongkir']['results'][$a]['costs'][$x]['cost'][$y]['etd'] . " Day(s)"
                        );
                    }
                }
            }
            echo json_encode($hasil);
        }
    }

    function getSubdistrict($cityID = "")
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/subdistrict?city=$cityID",
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
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }


    public function setDeliveryInfo($cartId)
    {
        $deliveryCourId = $this->input->post("deliveryCourId");
        $deliveryCourName = $this->input->post("deliveryCourName");
        $deliveryService = $this->input->post("deliveryService");
        $deliveryETD = $this->input->post("deliveryETD");
        $deliveryPrice = $this->input->post("deliveryPrice");
        $pointUsage = $this->input->post("pointUsage");
        $grandTotal = $this->input->post("grandTotal");

        $dataUpdate = array(
            "deliveryCourId" => $deliveryCourId,
            "deliveryCourName" => $deliveryCourName,
            "deliveryService" => $deliveryService,
            "deliveryETD" => $deliveryETD,
            "deliveryPrice" => $deliveryPrice,
            "pointUsage" => $pointUsage,
            "grandTotal" => $grandTotal
        );

        $this->db->set($dataUpdate);
        $this->db->where('cartId', $cartId);
        $this->db->update('cart');


    }

    function payCart($cartID)
    {
        $data['cartID'] = $cartID;
        $this->load->view('checkout_snap', $data);
    }


    public function snaptoken($cartID)
    {
        // Required
        $dataCart = $this->db->query("SELECT a.*,b.productPrice,b.productName FROM cart a inner join products b on a.productId = b.productId where cartId = '" . $cartID . "' ")->row();
        $item_details[] = array(
            array(
                'id' => $dataCart->cartId,
                'price' => $dataCart->productPrice,
                'name' => $dataCart->productName,
                'quantity' => $dataCart->qty
            ),
            array(
                'id' => $dataCart->deliveryCourId,
                'price' => $dataCart->deliveryPrice,
                'name' => $dataCart->deliveryCourName,
                'quantity' => 1
            ),
        );

        $mid_orderId = rand();

        $transaction_details = array(
            'order_id' => $mid_orderId,
            'gross_amount' => $dataCart->productPrice * $dataCart->qty + $dataCart->deliveryPrice,
        );

        $this->db->query("UPDATE cart set midtransOrderID = '" . $mid_orderId . "' where cartId = '" . $cartID . "'");
        $dataCustomer = $this->db->query("SELECT * FROM members a inner join cart b on a.userId = b.userId where cartId = '" . $cartID . "' ")->row();
        // Optional
        $customer_details = array(
            'first_name'    => $dataCustomer->userFullname,
            'email'         => $dataCustomer->userEmail,
            'phone'         => $dataCustomer->userMobilephone,
        );

        $credit_card['secure'] = true;

        $time = time();
        $custom_expiry = array(
            'start_time' => date("Y-m-d H:i:s O", $time),
            'unit' => 'minute',
            'duration'  => 15
        );

        $transaction_data = array(
            'transaction_details' => $transaction_details,
            'item_details'       => $item_details,
            'customer_details'   => $customer_details,
            'credit_card'        => $credit_card,
            'expiry'             => $custom_expiry
        );
        error_log(json_encode($transaction_data));
        $snapToken = $this->midtrans->getSnapToken($transaction_data);
        error_log($snapToken);
        echo $snapToken;
    }

    public function snapfinish($cartID = "")
    {
        header("HTTP/1.1 200 OK");
        $result = json_decode($this->input->post('result_data'));
        if ($result) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $result->finish_redirect_url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->input->post('result_data'));
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($this->input->post('result_data'))
                )
            );
            $result = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($result);
        } else {
            echo "Can't get transaction result !!!";
        }
    }

    function notificationhandler()
    {
        $json_result = file_get_contents('php://input');
        $result = json_decode($json_result);
        if ($result) {
            $datauser = $this->db->query("SELECT * FROM cart where midtransOrderID = '" . $result->order_id . "' ")->row();
            header("HTTP/1.1 200 OK");
            if ($result->status_code == "200") {
                $this->db->query("UPDATE cart 
                        set midtransPaymentType = '" . $result->payment_type . "', 
                        midtransGrossAmount = '" . $result->gross_amount . "',
                        midtransTransactionTime = '" . $result->transaction_time . "',
                        midtransStatusCode = '" . $result->status_code . "',
                        cartFlag = 1,
                        midtransTransactionStatus = '" . $result->transaction_status . "'
                        where midtransOrderID = '" . $result->order_id . "' 
                          ");

        // CALCULATE POINT //

        $dataCart       = $this->db->query("SELECT * FROM cart where midtransOrderID = '".$result->order_id."' ")->row();
        $dataTransactionMember = $this->db->query("SELECT * from TransactionMember where userId = '".$dataCart->userId."'");

        if($dataTransactionMember->num_rows() < 1){
            $pointSaatIni = 0;
        }else{
            $pointSaatIni = $dataTransactionMember->row()->TotalPoint;
        }

        $kalkulasiPoin  = $dataCart->productPriceAfterPromo * 0.05;
        $totalPoint     = $pointSaatIni + $kalkulasiPoin;
        $reward = $kalkulasiPoin;

        $this->db->query("
        INSERT INTO TransactionMember (UserId,TransactionId,Total,TransactionDate,OutletLocation,PointUsage,RewardPoint,TotalPayment,TotalPoint) 
            values
            ('".$dataCart->userId."',
            '".$dataCart->cartId."',
            '".($dataCart->productPriceAfterPromo - $dataCart->pointUsage)."',
            NOW(),
            '".$dataCart->storeId."',
            '".$dataCart->pointUsage."',
            '".$reward."',
            '".($dataCart->productPriceAfterPromo - $dataCart->pointUsage)."',
            '".$totalPoint."'
            )
         ");

        $dataUpdate = array(
            "productPriceAfterPromo" => ($dataCart->productPriceAfterPromo - $dataCart->pointUsage)
        );

        $this->db->set($dataUpdate);
        $this->db->where('cartId', $dataCart->cartId);
        $this->db->update('cart');

        //END CALCULATE POINT//
            } else {
                $this->db->query("UPDATE cart 
                        set midtransPaymentType = '" . $result->payment_type . "', 
                        midtransGrossAmount = '" . $result->gross_amount . "',
                        midtransTransactionTime = '" . $result->transaction_time . "',
                        midtransStatusCode = '" . $result->status_code . "',
                        midtransTransactionStatus = '" . $result->transaction_status . "'
                        where midtransOrderID = '" . $result->order_id . "' 
                          ");
            }
            if($result->payment_type == "bank_transfer" && $result->transaction_status != "cancel" && $result->transaction_status != "expire" && $result->status_code != 200 ){
                $this->load->model('Message_model');
                $this->db->query("UPDATE cart 
                        set va_numbers = '".$result->va_numbers[0]->va_number."', va_bank = '".$result->va_numbers[0]->bank."'
                        where midtransOrderID = '" . $result->order_id . "' 
                          ");
                    $userId             =  $datauser->userId;
                    $messageContent     = "Harap lakukan transfer ke Virtual Account BCA, dengan nomor tujuan ".$result->va_numbers[0]->va_number. " , sebesar ".number_format($result->gross_amount)." . Pembayaran akan hangus dalam waktu 24 jam.";
                    $messageTitle       = "Konfirmasi Checkout : ".$datauser->cartId;
                    $datasave = array(
                        "userId"                => $userId,
                        "deviceId"              => "",
                        "messageContent"        => $messageContent,
                        "messageTitle"          => $messageTitle,
                        "messageId"             => $this->Message_model->getMaxId()
                    );
                    $this->Message_model->saveMessage($datasave, $messageContent);
            }else if($result->payment_type == "bank_transfer" && $result->transaction_status == "cancel"){
                    $userId             =  $datauser->userId;
                    $messageContent     = "Hi ka. Mau info nih, transaksi dengan nomor ".$datauser->cartId. " berhasil di batalkan.";
                    $messageTitle       = "Transaksi di batalkan : ".$datauser->cartId;
                    $datasave = array(
                        "userId"                => $userId,
                        "deviceId"              => "",
                        "messageContent"        => $messageContent,
                        "messageTitle"          => $messageTitle,
                        "messageId"             => $this->Message_model->getMaxId()
                    );
                    $this->Message_model->saveMessage($datasave, $messageContent);
            }else if($result->transaction_status == "expire"){
                $userId             =  $datauser->userId;
                $messageContent     = "Hi ka. Mau info nih, transaksi dengan nomor ".$datauser->cartId. " sudah tidak berlaku atau kadaluwarsa. Jadi jangan melakukan pembayaran yah.";
                $messageTitle       = "Transaksi di kadaluwarsa : ".$datauser->cartId;
                $datasave = array(
                    "userId"                => $userId,
                    "deviceId"              => "",
                    "messageContent"        => $messageContent,
                    "messageTitle"          => $messageTitle,
                    "messageId"             => $this->Message_model->getMaxId()
                );
                $this->Message_model->saveMessage($datasave, $messageContent);
            }else if($result->payment_type == "bank_transfer" && $result->status_code == 200){
                $userId             =  $datauser->userId;
                $messageContent     = "Hi ka. Mau info nih, transaksi dengan nomor ".$datauser->cartId. " sudah berhasil ya, kita juga sudah menerima pembayaran. Jangan beli lupa rate pembelian ya.";
                $messageTitle       = "Transaksi berhasil : ".$datauser->cartId;
                $datasave = array(
                    "userId"                => $userId,
                    "deviceId"              => "",
                    "messageContent"        => $messageContent,
                    "messageTitle"          => $messageTitle,
                    "messageId"             => $this->Message_model->getMaxId()
                );
                $this->Message_model->saveMessage($datasave, $messageContent);
            }else if($result->payment_type == "credit_card" && $result->status_code == 200){
                $userId             =  $datauser->userId;
                $messageContent     = "Hi ka. Mau info nih, transaksi dengan nomor ".$datauser->cartId. " sudah berhasil ya, kita juga sudah menerima pembayaran. Jangan beli lupa rate pembelian ya.";
                $messageTitle       = "Transaksi berhasil : ".$datauser->cartId;
                $datasave = array(
                    "userId"                => $userId,
                    "deviceId"              => "",
                    "messageContent"        => $messageContent,
                    "messageTitle"          => $messageTitle,
                    "messageId"             => $this->Message_model->getMaxId()
                );
                $this->Message_model->saveMessage($datasave, $messageContent);
            }
        } else {
            header("HTTP/1.1 400");
        }
    }


    function notificationhandlertet($orderId){
        $this->load->library('veritrans');
        $is_production = false;
        $server_key = $is_production ? 'Mid-server-Hlf-KOi-Lg8-OmqCgp1AIhLM':'SB-Mid-server-w54MzrNLatCTHYGVxOvCBDRL';
        $params = array('server_key' => $server_key, 'production' => $is_production);
        $this->veritrans->config($params);
        $result = $this->veritrans->status($orderId);
        echo json_encode($result);
    }


    function cancelTransaction($orderId){
        $this->load->library('veritrans');
        $myFetch = $this->getMidtransServerKey();
        if($myFetch['status'] == "sandbox"){
            $is_production = false;
        }else{
            $is_production = true;
        }
        $server_key = $myFetch['ServerKey'];    

        $params = array('server_key' => $server_key, 'production' => $is_production);
        $this->veritrans->config($params);
        $this->veritrans->cancel($orderId);
        $this->db->query("UPDATE cart set cartFlag = 1, deletedDate = NOW() where midtransOrderID = '".$orderId."'");
    }

    function setExpiredTransaction($orderId){
        $this->load->library('veritrans');
        $myFetch = $this->getMidtransServerKey();
        if($myFetch['status'] == "sandbox"){
            $is_production = false;
        }else{
            $is_production = true;
        }
        $server_key = $myFetch['ServerKey']; 
        $params = array('server_key' => $server_key, 'production' => $is_production);
        $this->veritrans->config($params);
        $this->veritrans->expire($orderId);
        $this->db->query("UPDATE cart set cartFlag = 1, deletedDate = NOW() where midtransOrderID = '".$orderId."'");
    }


    function finishPay()
    {
        header("HTTP/1.1 200 OK");
        $orderId = $_GET['order_id'];
        $notif = $this->midtrans->status($orderId);
        $data = array(
            "status" => "0",
            "midtrans" => $notif
        );
        echo json_encode($data);
        return $data;
    }

    function getPaymentStatus()
    {
        $cartId = $this->input->post("cartId");
        $data1 = $this->db->query("SELECT * FROM cart where cartId = '" . $cartId . "'")->row();
        if($data1->midtransPaymentType != null || $data1->midtransPaymentType != ""){
            $data = array("status" => "ok", "payment_status" => $data1->midtransStatusCode);
        }else{
            $data = array("status" => "fail", "payment_status" => 'failed');
        }


        echo json_encode($data);
    }

    function changePayment(){
        $cartId = $this->input->post("cartId");
        $this->db->query("UPDATE cart 
        set midtransPaymentType = '', 
        midtransGrossAmount = '',
        midtransTransactionTime = '',
        midtransStatusCode = '',
        midtransTransactionStatus = ''
        where cartId = '" . $cartId . "' 
          ");
    }

    function no_notificationhandler($orderId){
        $this->load->library('veritrans');
        $is_production = false;
        $server_key = $is_production ? 'Mid-server-Hlf-KOi-Lg8-OmqCgp1AIhLM':'SB-Mid-server-w54MzrNLatCTHYGVxOvCBDRL';
        $params = array('server_key' => $server_key, 'production' => $is_production);
        $this->veritrans->config($params);
        $result = $this->veritrans->status($orderId);

        if ($result->status_code == "200") {
            $this->db->query("UPDATE cart 
                    set midtransPaymentType = '" . $result->payment_type . "', 
                    midtransGrossAmount = '" . $result->gross_amount . "',
                    midtransTransactionTime = '" . $result->transaction_time . "',
                    midtransStatusCode = '" . $result->status_code . "',
                    cartFlag = 1,
                    midtransTransactionStatus = '" . $result->transaction_status . "'
                    where midtransOrderID = '" . $result->order_id . "' 
                      ");
        } else {
            $this->db->query("UPDATE cart 
                    set midtransPaymentType = '" . $result->payment_type . "', 
                    midtransGrossAmount = '" . $result->gross_amount . "',
                    midtransTransactionTime = '" . $result->transaction_time . "',
                    midtransStatusCode = '" . $result->status_code . "',
                    midtransTransactionStatus = '" . $result->transaction_status . "'
                    where midtransOrderID = '" . $result->order_id . "' 
                      ");
        }
        if($result->payment_type == "bank_transfer"){
            $this->db->query("UPDATE cart 
                    set va_numbers = '".$result->va_numbers[0]->va_number."', va_bank = '".$result->va_numbers[0]->va_number."'
                    where midtransOrderID = '" . $result->order_id . "' 
                      ");
        }

    }

    function getCartHist()
    {
        $userId = $this->input->post("userId");
        $data = [];
        $queryresult = $this->db->query("select storeMall,deliveryResiNo,customerReceiveStatus,midtransStatusCode,midtransTransactionStatus,midtransPaymentType,cartId,a.productColorId,a.productID,a.SizeID,SizeDescription,TipeProduct,ccName,productName,categoryName,sum(a.qty) as quantity,image1,p.productPrice as price,
                                            ifnull(deliveryCourName,'-') deliveryCourName,ifnull(deliveryService,'-') deliveryService,ifnull(deliveryPrice,'0') deliveryPrice,ifnull(midtransGrossAmount,'0') midtransGrossAmount, midtransStatusCode
                                            from cart a 
                                                inner join size b on a.SizeID = b.SizeID 
                                                inner join product_colors pc on a.productId = pc.productId and a.productColorID = pc.productColorID
                                                inner join combination_color cc on pc.combination_color = ccId
                                                inner join products p on p.productId = a.productId
                                                inner join product_categories cat on p.categoryId = cat.categoryId
                                                inner join store st on a.storeId = st.storeName
                                            where a.userId = '" . $userId . "' and midtransPaymentType is not null
                                            group by a.productID,a.SizeID,SizeDescription,TipeProduct,ccName,productName,categoryName,image1,p.productPrice,a.cartId 
                                            order by a.createdDate desc
                                            ")->result();
        foreach ($queryresult as $key) {
            $info = explode(";", $key->SizeDescription);
            if ($key->TipeProduct == "C_00001") {
                $data[] = array(
                    "SizeID"            => $key->SizeID,
                    "SizeDescription" => $info[0],
                    "productWeight"    => $info[1],
                    "TipeProduct" => $key->TipeProduct,
                    "productId" => $key->productID,
                    "productColorId" => $key->productColorId,
                    "colorName" => $key->ccName,
                    "productName" => $key->productName,
                    "categoryName" => $key->categoryName,
                    "quantity" => $key->quantity,
                    "image" => $key->image1,
                    "cartId" => $key->cartId,
                    "price" => $key->price,
                    "deliveryCourName" => $key->deliveryCourName,
                    "deliveryService" => $key->deliveryService,
                    "deliveryPrice" => $key->deliveryPrice,
                    "midtransStatusCode" => $key->midtransStatusCode,
                    "midtransTransactionStatus" => strtoupper($key->midtransTransactionStatus),
                    "payment_method" => strtoupper(str_replace("_", " ", $key->midtransPaymentType)),
                    "customerReceiveStatus" => $key->customerReceiveStatus,
                    "deliveryResiNo" => $key->deliveryResiNo,
                    "storeMall" => $key->storeMall,

                );
            } else if ($key->TipeProduct == "C_00007") {
                $data[] = array(
                    "SizeID" => $key->SizeID,
                    "SizeDescription" => "Size " . $info[0],
                    "productWeight"    => $info[1],
                    "TipeProduct" => $key->TipeProduct,
                    "productId" => $key->productID,
                    "productColorId" => $key->productColorId,
                    "colorName" => $key->ccName,
                    "productName" => $key->productName,
                    "categoryName" => $key->categoryName,
                    "quantity" => $key->quantity,
                    "image" => $key->image1,
                    "cartId" => $key->cartId,
                    "price" => $key->price,
                    "deliveryCourName" => $key->deliveryCourName,
                    "deliveryService" => $key->deliveryService,
                    "deliveryPrice" => $key->deliveryPrice,
                    "midtransStatusCode" => $key->midtransStatusCode,
                    "midtransTransactionStatus" => strtoupper($key->midtransTransactionStatus),
                    "payment_method" => strtoupper(str_replace("_", " ", $key->midtransPaymentType)),
                    "customerReceiveStatus" => $key->customerReceiveStatus,
                    "deliveryResiNo" => $key->deliveryResiNo,
                    "storeMall" => $key->storeMall,




                );
            } else if ($key->TipeProduct == "C_00003") {
                $data[] = array(
                    "SizeID" => $key->SizeID,

                    "SizeDescription" => $info[0],
                    "productWeight"    => $info[1],
                    "TipeProduct" => $key->TipeProduct,
                    "productId" => $key->productID,
                    "productColorId" => $key->productColorId,
                    "colorName" => $key->ccName,
                    "productName" => $key->productName,
                    "categoryName" => $key->categoryName,
                    "quantity" => $key->quantity,
                    "image" => $key->image1,
                    "cartId" => $key->cartId,
                    "price" => $key->price,
                    "deliveryCourName" => $key->deliveryCourName,
                    "deliveryService" => $key->deliveryService,
                    "deliveryPrice" => $key->deliveryPrice,
                    "midtransStatusCode" => $key->midtransStatusCode,
                    "midtransTransactionStatus" => strtoupper($key->midtransTransactionStatus),
                    "payment_method" => strtoupper(str_replace("_", " ", $key->midtransPaymentType)),
                    "customerReceiveStatus" => $key->customerReceiveStatus,
                    "deliveryResiNo" => $key->deliveryResiNo,
                    "storeMall" => $key->storeMall,
                );
            }
        }
        echo json_encode($data);
    }

    function deliveryStatus()
    {
        $data = $this->db->query("SELECT * FROM cart where cartId = '".$this->input->post('cartId')."' ")->row();
        $deliveryCourId =  $data->deliveryCourId;

        if($deliveryCourId == "J&T"){
            $deliveryCourId = "jnt";
        }



        $deliveryCourId = strtolower($deliveryCourId);

        if($data->deliveryResiNo == null || $data->deliveryResiNo == ""){
            $newArray[] = array("manifest_code" => "400",
             "manifest_description" => "400",
             "manifest_date" => "400",
             "manifest_time" => "400",
             "city_name" => "400",); 
            echo json_encode($newArray);
            return;
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/waybill",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "waybill=$data->deliveryResiNo&courier=$deliveryCourId",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key:5882027194d829e46c2cdd55f8875dde"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $data = [];
        } else {
            $response = json_decode($response, true);
            $data = $response['rajaongkir']['result']['manifest'];
        }
        echo json_encode($data);
    }
    function  saveFeedback()
    {
        $rate = $this->input->post("rate");
        $cartId = $this->input->post("cartId");
        $feedbackContent = $this->input->post("feedbackMessage");
        $this->db->query("DELETE FROM productRate where cartId = '".$cartId."'");

        $cek = $this->db->query("SELECT * FROM productRate where cartId = '" . $cartId . "' ")->num_rows();


        if ($cek < 1) {
            $save = $this->db->query("INSERT INTO productRate (cartId,feedbackDate,feedbackContent,rate) values ('" . $cartId . "',NOW(),'" . $feedbackContent . "','" . $rate . "')  ");
            if ($save) {
                $data = array("status" => 1);
            } else {
                $data = array("status" => 0);
            }
        } else {
            $data = array("status" => 0);
        }
        echo json_encode($data);
    }
    function getFeedback($cartId)
    {
        $data = $this->db->query("SELECT * FROM productRate where cartId = '" . $cartId . "' ")->row();
        echo json_encode($data);
    }
    function setCartReceive()
    {
        $cartId = $this->input->post('cartId');
        $this->db->query("UPDATE cart set customerReceiveStatus = 1, customerReceiveDate = NOW() where cartId = '" . $cartId . "' ");
    }

    function getProductRate(){
        $productId = $this->input->post("productId");
        $data = $this->db->query("SELECT rate from productRate a  inner join cart b on a.cartId = b.cartId where productId = '".$productId."'")->result();
        $val = [];
        foreach ($data as $key) {
            $val[] = $key->rate;
        }
        $totaldata = count($val);
        $totalnilai = array_sum($val);

        if($totaldata > 0){
        $hasil = $totalnilai/$totaldata;
        $hsilJson = array("nilai" => number_format((float)$hasil, 2, '.', ''));
        echo json_encode($hsilJson);
        }else{
            $hsilJson = array("nilai" => 0);

            echo json_encode($hsilJson);
        }

    }

    function checkPhone(){
        $phone = $this->input->post("phone");
        $cek = $this->db->query("SELECT * FROM members where userMobilephone = '".$phone."' ");
        if($cek->num_rows() > 0){
            $data['err']      = 0;
            $data['message']  = "Login successful";
            $data['userInfo'] = $cek->row();
        }else{
            $data['err']      = 1;
            $data['message']  = "Login Failed. please check your phone number format. both on this form and profil page (081234567xxx)";
        }
        echo json_encode($data);
    }

    function getLatestSoldProducts()
    {
        $data   = $this->db->query("SELECT sum(a.qty) quantity ,a.productId,a.productColorId,image1 as productImage,
                                    productName,a.productPrice,isNew,isHot,categoryId,productDescription,0 as isLiked,image1,image2,image3 FROM cart a 
                inner join product_colors b on a.productId = b.productId and a.productColorId = b.productColorId 
                inner join products c on a.productId = c.productId
                where cartFlag = 1 and productFlag = 1
                group by a.productId,a.productColorId,image1,image2,image3 
                order by createdDate asc LIMIT 6");
        $return = $data->result();
        echo json_encode($return);
    }

function instagramPost(){

$access_token = "2134473585.6806ed4.92ac91cef0874d398c71e0949badbbbe";
$photo_count = 10;
$json_link = "https://api.instagram.com/v1/users/self/media/recent/?";
$json_link .="access_token={$access_token}&count={$photo_count}";
$json = file_get_contents($json_link);
$obj = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', $json), true);
echo "<pre>";
print_r($obj);
echo "</pre>";
foreach ($obj['data'] as $post){
    $pic_text = $post['caption']['text'];
    $pic_link = $post['link'];
    $pic_like_count = $post['likes']['count'];
    $pic_comment_count=$post['comments']['count'];
    $pic_src=str_replace("http://", "https://", $post['images']['standard_resolution']['url']);
    $pic_created_time=date("F j, Y", $post['caption']['created_time']);
    $pic_created_time=date("F j, Y", strtotime($pic_created_time . " +1 days"));
    echo "<div class='col-md-4 item_box'>";
        echo "<a href='{$pic_link}' target='_blank'>";
          echo "<img class='img-responsive photo-thumb' src='{$pic_src}' alt='{$pic_text}'>";
        echo "</a>";
    echo "<p>";
    echo "<p>";
        echo "<div style='color:#888;'>";
            echo "<a href='{$pic_link}' target='_blank'>{$pic_created_time}</a>";
        echo "</div>";
    echo "</p>";
    echo "<p>{$pic_text}</p>";
    echo "</p>";
    echo "</div>";
}
    }

    function getProductFeedback(){
        $productId = $this->input->post("productId");
        $rateFilter = $this->input->post("rateFilter");
        if($rateFilter == "0"){
        $data = $this->db->query("SELECT a.*,b.userId,c.userFullname FROM productRate a 
                            inner join cart b on a.cartId = b.cartId 
                            inner join members c on b.userId = c.userId
                            where productId = '".$productId."' order by feedbackDate desc ")->result();
        }else{
            $data = $this->db->query("SELECT a.*,b.userId,c.userFullname FROM productRate a 
                            inner join cart b on a.cartId = b.cartId 
                            inner join members c on b.userId = c.userId
                            where productId = '".$productId."' and rate = '".$rateFilter."'  order by feedbackDate desc ")->result();
        }
        echo json_encode($data);
    }

    function getMaintenanceStatus(){
        $data =  $this->db->query("SELECT currentVal from appconfiguration where `key` = 'isMaintenance' ")->row();
        echo json_encode($data);
    }


    function getCartByID($cartId){

        $transactionId = $cartId."-".rand();

        $data = $this->db->query("SELECT '".$transactionId."' as midtransId, a.*, b.productPrice, grandtotal,c.userFullname,c.userEmail,c.userMobilephone 
                                FROM cart a inner join products b on a.productId = b.productId 
                                inner join members c on a.userId = c.userId
                                where cartId = '".$cartId."' ")->row();

        $this->db->query("UPDATE cart set midtransOrderId ='".$transactionId."' where cartId = '".$cartId."'");

        echo json_encode($data);
}

function charge(){
    $myFetch = $this->getMidtransServerKey();
    if($myFetch['status'] == "sandbox"){
        $is_production = false;
    }else{
        $is_production = true;
    }

    $server_key = $myFetch['ServerKey'];

    $api_url = $is_production ? 'https://app.midtrans.com/snap/v1/transactions' : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

    if( !strpos($_SERVER['REQUEST_URI'], '/charge') ) {
    http_response_code(404); 
    echo "wrong path, make sure it's `/charge`"; exit();
    }
    if( $_SERVER['REQUEST_METHOD'] !== 'POST'){
    http_response_code(404);
    echo "Page not found or wrong HTTP request method is used"; exit();
    }
    $request_body = file_get_contents('php://input');
    header('Content-Type: application/json');
    $charge_result = $this->chargeAPI($api_url, $server_key, $request_body);
    http_response_code($charge_result['http_code']);
    echo $charge_result['body'];
}
function chargeAPI($api_url, $server_key, $request_body){
    $ch = curl_init();
    $curl_options = array(
      CURLOPT_URL => $api_url,
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_POST => 1,
      CURLOPT_HEADER => 0,
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Basic ' . base64_encode($server_key . ':')
      ),
      CURLOPT_POSTFIELDS => $request_body
    );
    curl_setopt_array($ch, $curl_options);
    $result = array(
      'body' => curl_exec($ch),
      'http_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
    );
    return $result;
  }

  function calculatePriceBangsaw()
  {
      

    $cityOrigin = $this->input->post("cityOrigin");
    $cityDestination = $this->input->post("cityDestination");

      $curl = curl_init();
      curl_setopt_array($curl, array(
          CURLOPT_URL => "https://pro.rajaongkir.com/api/cost",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "origin=" . $cityOrigin . "&originType=subdistrict&destination=" . $cityDestination . "&destinationType=subdistrict&weight=1&courier=jnt:jne:tiki",
          CURLOPT_HTTPHEADER => array(
              "content-type: application/x-www-form-urlencoded",
              "key: 5882027194d829e46c2cdd55f8875dde"
          ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);

      // print_r($response);die();

      curl_close($curl);

      if ($err) {
          echo "cURL Error #:" . $err;
      } else {
          $data = json_decode($response, true);
          for ($a = 0; $a < count($data['rajaongkir']['results']); $a++) {
              for ($x = 0; $x < count($data['rajaongkir']['results'][$a]['costs']); $x++) {
                  for ($y = 0; $y < count($data['rajaongkir']['results'][$a]['costs'][$x]['cost']); $y++) {
                      $hasil[] = array(
                          "CourId" => strtoupper($data['rajaongkir']['results'][$a]['code']),
                          "CourName" => strtoupper($data['rajaongkir']['results'][$a]['name']),
                          "services" => $data['rajaongkir']['results'][$a]['costs'][$x]['service'],
                          "cost" => "" . $data['rajaongkir']['results'][$a]['costs'][$x]['cost'][$y]['value'] . "",
                          "etd" => $data['rajaongkir']['results'][$a]['costs'][$x]['cost'][$y]['etd'] . " Day(s)"
                      );
                  }
              }
          }
          echo json_encode($hasil);
      }
  }

  function getUserpoint($userId){
    $data = $this->db->query("SELECT IFNULL(TotalPoint,'0') as TotalPoint FROM TransactionMember where userId = '".$userId."' order by TransactionDate desc Limit 1 ");
    if($data->num_rows() > 0){
        echo json_encode(array("points" => $data->row()->TotalPoint));
    }else{
        echo json_encode(array("points" => 0));
    }
  }
  function viewReminder($cartId)
  {
      $datauser = $this->db->query("SELECT a.userEmail, a.userId, a.userFullname, b.productId, c.image1
                                    FROM members a
                                    INNER JOIN cart b ON a.userId = b.userId
                                    INNER JOIN product_colors c ON b.productId = c.productId
                                    WHERE cartId = '" . $cartId . "' ")->row();
      
      $data['url'] = base_url() . "Api/cartconfirmation/" . $cartId;
      $data['cart']  = $datauser;
      $this->load->view("confirmation_product_view", $data);   
  }

  function cartconfirmation($cartId){
    $this->load->model('Cart_model');
    $time = $this->db->query("SELECT NOW() AS time")->row();
    $getDate = date('Y-m-d', strtotime($time->time));
    $data = array(
                    "customerReceiveStatus"        => "1",
                    "customerReceiveDate"          => $getDate
                 );
    $kondisi    = array("cartId"       => $cartId);
    $this->Cart_model->updateDelivery($data, $kondisi);
    echo "Konfirmasi Berhasil, terima kasih sudah konfirmasi :)";
  }

  function getMidtransKey(){
    $data = $this->db->query("SELECT * from appconfiguration where `key` = 'midtransClientKey' and isActive = 1")->row();
    $data1 = $this->db->query("SELECT * from appconfiguration where `key` = 'midtransServerKey' and isActive = 1")->row();

    if($data->currentVal == "sandbox"){
        $url = "http://memberlf-dev.rpgroup.co.id/api/";
    }else{
        $url = "http://memberlf-dev.rpgroup.co.id/api/";
    }

    $myData = array("ClientKey" => $data-> maxVal, "ServerKey" => $data1->maxVal, "status" => $data->currentVal, "url" => $url);
    echo json_encode($myData);
  }

  function getMidtransServerKey(){
    $data = $this->db->query("SELECT * from appconfiguration where `key` = 'midtransClientKey' and isActive = 1")->row();
    $data1 = $this->db->query("SELECT * from appconfiguration where `key` = 'midtransServerKey' and isActive = 1")->row();

    if($data->currentVal == "sandbox"){
        $url = "http://memberlf-dev.rpgroup.co.id/api/";
    }else{
        $url = "http://memberlf-dev.rpgroup.co.id/api/";
    }

    $myData = array("ClientKey" => $data-> maxVal, "ServerKey" => $data1->maxVal, "status" => $data->currentVal, "url" => $url);
    return $myData;
  }

  function getSelectedAddress($deliveryAddressId=""){
    $data = $this->db->query("SELECT a.*,b.cityName,c.provinceName FROM delivery_address a 
    inner join city b on a.addressCityId = b.cityID  
    inner join province c on a.addressProvinceId = c.provinceID where deliveryAddressId = '" . $deliveryAddressId . "' ")->row(); 
    echo json_encode($data);
}

    function getMarketplace(){
        $data = $this->db->query("SELECT * FROM marketplace order by marketplaceName asc")->result();
        echo json_encode($data);
    }

}
