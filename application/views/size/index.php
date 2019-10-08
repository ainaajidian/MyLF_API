<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
              	<div class="card-header">
                	<h3 class="card-title">Size Table</h3>
              	</div>
              	<div class="card-body">
	             	<div class="table-responsive">
	              		<table width='100%' class="table" id="SizeTable">
	              			<thead>
	              				<tr>
		              				<th width="15">ID Size</th>
		              				<th width="20%">Tipe Product</th>
		              				<th width="45%">Descripton Size</th>
		              				<th width="20%">Action</th>
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
        <h5 class="modal-title" id="exampleModalLabel">Add Size</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>          
      <form enctype="multipart/form-data" id="sizeForm" action="<?=base_url();?>Size/saveSize" method = "POST" >
	      <div class="modal-body">
	          
           	<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
            
            <div class="input-group mb-3">
            	<select class="form-control" id="TipeProduct" name="TipeProduct">
        			<option value="" disabled selected>Select Product Type</option>
        			<?php foreach ($parent_module as $key) 
        			{ echo "<option value='".$key->categoryId."'> ".$key->categoryId." - ".$key->categoryName." </option>"; } ?>
            	</select>
            </div>  

            <div id="Panjang" class="input-group mb-3">
                <input autocomplete="off"  id="Panjang" name="Panjang" type="text" class="form-control" placeholder="Panjang">
            </div>

            <div id="Lebar" class="input-group mb-3">
                <input autocomplete="off"  id="Lebar"  name="Lebar" type="text" class="form-control" placeholder="Lebar">
            </div>   

            <div id="Tinggi" class="input-group mb-3">
                <input autocomplete="off"  id="Tinggi" name="Tinggi" type="text" class="form-control" placeholder="Tinggi">
            </div>   

            <div id="Ukuran" class="input-group mb-3">
                <input autocomplete="off"  id="Ukuran" name="Ukuran" type="text" class="form-control" placeholder="Ukuran">
            </div>   

            <div id="Berat" class="input-group mb-3">
                <input autocomplete="off"  id="Berat" name="Berat" type="text" class="form-control" placeholder="Berat">
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
        <h5 class="modal-title" id="exampleModalLabel">Edit Product Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>          
      <form enctype="multipart/form-data" id="editsizeForm" action="<?=base_url();?>Size/updateSize" method = "POST" >
	      <div class="modal-body">
	          
	               <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
	               <input type="hidden" name="SizeID" id="editSizeID" />

	               <div  class="input-group mb-3">
	                	<select class="form-control" id="editTipeProduct" name="TipeProduct">
	                		<option value="" disabled selected>Select Product Type</option>
                      <?php foreach ($parent_module as $key) 
                      { echo "<option value='".$key->categoryId."'> ".$key->categoryId." - ".$key->categoryName." </option>"; } ?>
                    </select>
	                </div>

	                <div class="input-group mb-3">
	                    <input autocomplete="off" id="editPanjang" required name="Panjang" type="text"  class="form-control" placeholder="Panjang">
	                </div>   

	                <div class="input-group mb-3">
	                    <input autocomplete="off" id="editLebar" required name="Lebar" type="text"  class="form-control" placeholder="Lebar">
	                </div>   

	                <div class="input-group mb-3">
	                    <input autocomplete="off" id="editTinggi" required name="Tinggi" type="text"  class="form-control" placeholder="Tinggi">
	                </div>   

	                <div class="input-group mb-3">
	                    <input autocomplete="off" id="editUkuran" required name="Ukuran" type="text"  class="form-control" placeholder="Ukuran">
	                </div>   

	                <div class="input-group mb-3">
	                    <input autocomplete="off" id="editBerat" required name="Berat" type="text"  class="form-control" placeholder="Berat">
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
