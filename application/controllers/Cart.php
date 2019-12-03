
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart extends MY_Controller
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

        $data['customjs']             = "cart/customjs";
        $data['view']                 = "cart/index";
        $this->go_to($data);
    }

    //Get Data
    public function getCart()
    {
        $data['data'] = $this->Cart_model->generateAll();
        echo json_encode($data);
    }

    function detail($cartId)
    {
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['includecss'] = '<link rel="stylesheet" href="' . base_url() . 'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.css">
                            <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">';
        $data['includejs']  = '<script src="' . base_url() . 'node_modules/admin-lte/plugins/datatables/jquery.dataTables.js"></script>
                               <script src="' . base_url() . 'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap4.js"></script>
                               <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
                          ';
        $data['view']                   = "cart/detail";
        $data['customjs']               = "cart/customjs";

        $data['cart'] = $this->db->query("SELECT addressRemark,a.cartId, a.userId, a.productId, b.productName, c.image1, d.ccName, 
                                         g.SizeDescription, CONCAT('Rp ', FORMAT(a.productPrice, 0)) AS productPrice,
                                         CONCAT('Rp ', FORMAT(productPriceAfterPromo, 0)) AS productPriceAfterPromo,
                                         CONCAT('Rp ', FORMAT(disc, 0)) AS disc,
                                         CONCAT('Rp ', FORMAT(grandTotal, 0)) AS grandTotal,
                                         a.midtransPaymentType, a.va_bank, a.va_numbers,
                                         f.storeMall, e.responseDescription, a.deliveryResiNo, a.createdDate,
                                         CONCAT('Rp ', FORMAT(deliveryPrice, 0)) AS deliveryPrice, b.productErpCode,
                                         a.customerReceiveStatus, a.salesOrderTransactionNo, a.midtransStatusCode,
                                         a.deliveryCourId,a.deliveryService,deliveryETD
                                         FROM cart a 
                                         LEFT JOIN products b ON a.productId = b.productId 
                                         LEFT JOIN product_colors c ON a.productColorId = c.productColorId 
                                         LEFT JOIN combination_color d ON c.combination_color = d.ccId 
                                         LEFT JOIN response e ON a.midtransStatusCode = e.responseCode 
                                         LEFT JOIN store f ON a.storeId = f.storeName
                                         LEFT JOIN size g ON g.sizeId = a.SizeID
                                         INNER JOIN delivery_address da on a.deliveryAddressId = da.deliveryAddressId
                                         WHERE cartId = '".$cartId."'")->row();



        $this->go_to($data);
    }

    function saveResi()
    {
        $cartId                  = $this->input->post("cartId");
        $deliveryResiNo          = $this->input->post("deliveryResiNo");
        $salesOrderTransactionNo = $this->input->post("salesOrderTransactionNo");
         
    
        $dataupdate = array("deliveryResiNo"             => $deliveryResiNo ,
                            "salesOrderTransactionNo"    => $salesOrderTransactionNo );
        $kondisi    = array("cartId"                     => $cartId);

        $this->Cart_model->updateResi($dataupdate, $kondisi);

        die("<script>
                alert('Input Data Success');
                window.location.href='" . base_url() . "Cart/detail/" . $cartId . "';
                </script>");
    }

	function getDeliveryStatus($cartId)
    {
            
        $dataCart = $this->db->query("SELECT deliveryResiNo from cart where cartId = '".$cartId."' ")->row();
            
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://pro.rajaongkir.com/api/waybill",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",                               
        CURLOPT_POSTFIELDS => "waybill=".$dataCart->deliveryResiNo."&courier=jnt",
        CURLOPT_HTTPHEADER => array(
                                        "content-type: application/x-www-form-urlencoded",
                                        "key:5882027194d829e46c2cdd55f8875dde"
                                    ),
        ));

        $response = curl_exec($curl);
        $err        = curl_error($curl);
        $response = json_decode($response,true);

        if(isset($response['rajaongkir']['result'])){
            $data = $response['rajaongkir']['result']['manifest'];
        }else{
              $data = array(
                    "manifest_code" => "",
                    "manifest_description" => "",
                    "manifest_date" => "",
                    "manifest_time" => "",
                    "city_name" => ""
            );
        }
        echo json_encode(array("data" => $data));
        curl_close($curl);
        print_r($err);
    }

    function saveMessage($userId, $cartId)
    {
        $datasave = array(
                "userId"                => $userId,
                // "deviceId"              => $userId[0],
                "messageContent"        => "",
                "messageTitle"          => "Konfirmasi Barang Di Terima",
                "messageType"           => "Delivery",
                "cartId"                => $cartId,
                "messageId"             => $this->Cart_model->getMaxId()
            );

            $this->Message_model->saveMessage($datasave);
    }

    function sendReminder($cartId)
    {
        $datauser = $this->db->query("SELECT a.userEmail, a.userId, a.userFullname, b.productId, c.image1, b.cartId
                                      FROM members a
                                      INNER JOIN cart b ON a.userId = b.userId
                                      INNER JOIN product_colors c ON b.productId = c.productId
                                      WHERE cartId = '" . $cartId . "' ")->row();
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
        $mail->Subject = 'Konfirmasi Produk Telah Di Terima';
        $data['url'] = base_url() . "Cart/confirmation/" . $cartId;
        $data['cart']  = $datauser;
        // $body        = $this->load->view("confirmation_product", $data, TRUE);
        // $mail->Body = $body;
        // if (!$mail->send()) {
        //     echo 'Message could not be sent.';
        //     echo 'Mailer Error: ' . $mail->ErrorInfo;
        // } else {
        //     echo 'Message has been sent';
        //     $this->saveMessage($datauser->userId, $cartId);
            
        //     die("<script>
        //         alert('Send Reminder Success');
        //         window.location.href='" . base_url() . "Cart/detail/" . $cartId . "';
        //         </script>");
        // }
        $this->load->view("confirmation_product", $data);
    }

    function viewReminder($cartId)
    {
        $datauser = $this->db->query("SELECT a.userEmail, a.userId, a.userFullname, b.productId, c.image1
                                      FROM members a
                                      INNER JOIN cart b ON a.userId = b.userId
                                      INNER JOIN product_colors c ON b.productId = c.productId
                                      WHERE cartId = '" . $cartId . "' ")->row();
        
        $data['url'] = base_url() . "Cart/confirmation/" . $cartId;
        $data['cart']  = $datauser;
        $this->load->view("confirmation_product", $data);   
    }

    function confirmation($cartId)
    {
        $time = $this->db->query("SELECT NOW() AS time")->row();
    
        $getDate = date('Y-m-d', strtotime($time->time));

        $data = array(
                        "customerReceiveStatus"        => "1",
                        "customerReceiveDate"          => $getDate
                     );

        $kondisi    = array("cartId"       => $cartId);

        $this->Cart_model->updateDelivery($data, $kondisi);

        $this->load->view("thanks_message", $data);   
    }
}
