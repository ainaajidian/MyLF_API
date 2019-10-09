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
                	<h3 class="card-title">Store Table</h3>
              	</div>
              	<div class="card-body">
	             	<div class="table-responsive">
	              		<table width='100%' class="table" id="Store">
	              			<thead>
	              				<tr>
		              				<th>Id</th>
		              				<th>Name</th>
		              				<th>Mall</th>
		              				<th>Address</th>
		              				<th>Detail</th>
		              				<th>Longitude</th>
		              				<th>Lotitude</th>
		              				<th>Action</th>
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
        <h5 class="modal-title" id="exampleModalLabel">Add Store</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>          
      <form enctype="multipart/form-data" id="storeForm" action="<?=base_url();?>Store/saveStore" method = "POST" >
	      <div class="modal-body">
	          
	               <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
	                
	                <div class="input-group mb-3">
	                    <input autocomplete="off"  required name="storeName" type="text"  class="form-control" placeholder="Store Name">
	                </div>   

	                <div class="input-group mb-3">
	                    <input autocomplete="off"  required name="storeMall" type="text" class="form-control" placeholder="Store Mall">
	                </div>   

	                <div class="input-group mb-3">
	                    <input autocomplete="off"  required name="storeAddress" type="text" class="form-control" placeholder="Store Address">
	                </div> 

	                <div class="input-group mb-3">
	                    <input autocomplete="off"  required name="storeDetail" type="text" class="form-control" placeholder="Store Detail">
	                </div>   

	                <div class="input-group mb-3">
	                    <input autocomplete="off"  required name="storeLongitude" type="text" class="form-control" placeholder="Store Longitude">
	                </div>

	                <div class="input-group mb-3">
	                    <input autocomplete="off"  required name="storeLatitude" type="text" class="form-control" placeholder="Store Latitude">
	                </div>  

					<div class="input-group mb-3">
						<select id="province" name="province" class="form-control">
							<option value="" disabled selected>Select Province</option>
							<?php
								foreach ($provinces as $province)
								{ ?> <option value="<?=$province->provinceID;?>"> <?=$province->provinceName;?></option> <?php }
							?>
						</select>
	                </div>  

					<div class="input-group mb-3">
						<select id="city" name="city" class="form-control">
							<option value="" disabled selected>Select City</option>
							<?php
								foreach ($cities as $city) 
								{ ?> <option value="<?=$city->cityID;?>"> <?=$city->cityName;?></option> <?php }
							?>
						</select>
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

<div class="modal fade" id="editModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow:hidden;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Combination Color</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>          
      <form enctype="multipart/form-data" id="editstoreForm" action="<?=base_url();?>Store/updateStore" method = "POST" >
	      <div class="modal-body">
	          
	               <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
	               <input type="hidden" name="storeId" id="editstoreId" />

	               <div class="input-group mb-3">
	                    <input autocomplete="off"  required id="editstoreName" name="storeName" type="text"  class="form-control" placeholder="Store Name">
	                </div>   

	                <div class="input-group mb-3">
	                    <input autocomplete="off"  required id="editstoreMall" name="storeMall" type="text" class="form-control" placeholder="Store Mall">
	                </div>   

	                <div class="input-group mb-3">
	                    <input autocomplete="off"  required id="editstoreAddress" name="storeAddress" type="text" class="form-control" placeholder="Store Address">
	                </div> 

	                <div class="input-group mb-3">
	                    <input autocomplete="off"  required id="editstoreDetail" name="storeDetail" type="text" class="form-control" placeholder="Store Detail">
	                </div>   

	                <div class="input-group mb-3">
	                    <input autocomplete="off"  required id="editstoreLongitude" name="storeLongitude" type="text" class="form-control" placeholder="Store Longitude">
	                </div>

	                <div class="input-group mb-3">
	                    <input autocomplete="off"  required id="editstoreLatitude" name="storeLatitude" type="text" class="form-control" placeholder="Store Latitude">
	                </div>

					<div class="input-group mb-3">
						<select id="province" name="province" class="form-control">
							<option value="" disabled selected>Select Province</option>
							<?php
								foreach ($provinces as $province) 
								{ ?> <option value="<?=$province->provinceID;?>"> <?=$province->provinceName;?></option> <?php }
							?>
						</select>
	                </div>  

					<div class="input-group mb-3">
						<select id="city" name="city" class="form-control">
							<option value="" disabled selected>Select City</option>
							<?php
								foreach ($cities as $city) 
								{ ?> <option value="<?=$city->cityID;?>"> <?=$city->cityName;?></option> <?php }
							?>
						</select>
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
  $('#province').select2({
        trigger : 'change',
        width:'100%',
        placeholder: 'Select Province'
    });
</script>

<script>
  $('#city').select2({
        trigger : 'change',
        width:'100%',
        placeholder: 'Select City'
    });
</script>

</body>
</html>