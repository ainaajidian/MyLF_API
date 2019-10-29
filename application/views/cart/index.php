<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.css"/>

  <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.js"></script>
</head>

<body>

  <div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
              	<div class="card-header">
                	<h3 class="card-title">Transaction Table</h3>
              	</div>
              	<div class="card-body">
	             	<div class="table-responsive">
	              		<table width='100%' class="table" id="Cart">
	              			<thead>
	              				<tr>
		              				<th>Cart Id</th>
		              				<th>User Id</th>
		              				<th>Product Name</th>
		              				<th>Product Image</th>
                          <th>Product Color</th>
		              				<th>Size Id</th>
                          <th>Store Id</th>
                          <th>Status Transaksi</th>
		              			</tr>
		              		</thead>
	              		</table>
	            	</div>
	        	</div>
          	</div>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow:hidden;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Transaction</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>          
      <form enctype="multipart/form-data" id="categoryForm" action="<?=base_url();?>Transaction/saveTransaction" method = "POST" >
	   		<div class="modal-body"> 
	   		 
	            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
	                
                <div class="input-group mb-3">
                  <select class="form-control" id="userId" name="userId">
                  <option value="" disabled selected>PILIH STORE</option>
                  <?php foreach ($member_module as $key) 
                  { echo "<option value='".$key->userDeviceId.";".$key->userId."'> ".$key->userId." - ".$key->userFullname."  </option>"; } ?>
                  </select>
                </div>  

                <div class="input-group mb-3">
                    <input autocomplete="off" style="text-transform:uppercase" required name="TransactionId" type="text"  class="form-control" placeholder="NOMOR STRUK">
                </div>

                <div class="input-group mb-3">
                    <input autocomplete="off"  required name="TransactionDate" type="date" class="form-control" placeholder="TANGGAL TRANSAKSI">
                </div> 

                <div class="input-group mb-3">
                	<select class="form-control" id="OutletLocation" name="OutletLocation">
            			<option value="" disabled selected>PILIH STORE</option>
            			<?php foreach ($store_module as $key) 
            			{ echo "<option value='".$key->storeName."'> ".$key->storeName." </option>"; } ?>
                	</select>
                </div>

                <div class="input-group mb-3">
                    <input autocomplete="off"  required name="Total" type="text" class="form-control" placeholder="TOTAL BELANJA">
                </div> 

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit"  class="btn btn-primary">Save changes</button>
	      </div>
       </form>

    </div>
  </div>
</div>

<div class="modal fade" id="confirm" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow:hidden;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>          
      	<div class="modal-body">
      		<p id="deleteConfirmationmessage"> </p>
      	</div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-success" data-dismiss="modal">Nope</button>
	        <button type="submit"  class="btn btn-danger goDelete">Sure </button>
	      </div>
    </div>
  </div>
</div>

<script>
  $('#userId').select2({
        trigger : 'change',
        width:'100%',
        placeholder: 'Select Member'
    });
</script>

<script>
  $('#OutletLocation').select2({
        trigger : 'change',
        width:'100%',
        placeholder: 'Select Outlet'
    });
</script>

</body>
</html>