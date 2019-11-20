
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Cart_model');
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

        $data['cart'] = $this->db->query("SELECT a.cartId, a.userId, b.productName, c.image1, d.ccName, 
                                        a.sizeId, f.storeMall, e.responseDescription, a.deliveryResiNo, 
                                        a.customerReceiveStatus, a.salesOrderTransactionNo
                                        FROM cart a 
                                        LEFT JOIN products b ON a.productId = b.productId 
                                        LEFT JOIN product_colors c ON a.productColorId = c.productColorId 
                                        LEFT JOIN combination_color d ON c.combination_color = d.ccId 
                                        LEFT JOIN response e ON a.midtransStatusCode = e.responseCode 
                                        LEFT JOIN store f ON a.storeId = f.storeName
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

	function getDeliveryStatus()
    {
	    $curl = curl_init();
    	curl_setopt_array($curl, array(
    	CURLOPT_URL => "https://pro.rajaongkir.com/api/waybill",
    	CURLOPT_RETURNTRANSFER => true,
    	CURLOPT_ENCODING => "",
    	CURLOPT_MAXREDIRS => 10,
   	 	CURLOPT_TIMEOUT => 30,
    	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    	CURLOPT_CUSTOMREQUEST => "POST",
    	CURLOPT_POSTFIELDS => "waybill=JP0943665840&courier=jnt",
    	CURLOPT_HTTPHEADER => array(
                                		"content-type: application/x-www-form-urlencoded",
                                		"key:5882027194d829e46c2cdd55f8875dde"
                            		),
    	));

        $response = curl_exec($curl);
        $err 		= curl_error($curl);
	    $response = json_decode($response,true);
        $data = $response['rajaongkir']['result']['manifest'];
	    echo json_encode(array("data" => $data));
        curl_close($curl);
	}

}