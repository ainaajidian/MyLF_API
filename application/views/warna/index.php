<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
         
                <div class="card">
              <div class="card-header">
                <h3 class="card-title">Master Warna</h3>
              </div>
              	<div class="card-body">
	              <div class="table-responsive">
	              <table class="table" id="example1">

	              		<thead>
	              			<tr>
	              				<th>Hex</th>
	              				<th>Nama Warna</th>
	              				<th>Preview</th>
	              				<th> Aksi</th>
	              				
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
        <h5 class="modal-title" id="exampleModalLabel">Master Warna</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>          
      <form enctype="multipart/form-data" id="moduleForm" action="<?=base_url();?>Warna/saveWarna" method = "POST" >
	      <div class="modal-body">
	               <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
	                
	                <div class="input-group mb-3">
	                    <input autocomplete="off"  required name="kode_warna" type="text" id="module_name" class="form-control my-colorpicker1" placeholder="Kode Warna">
	                </div>   
	                  <div class="input-group mb-3">
	                    <input autocomplete="off"  required name="nama_warna" type="text" id="module_name" class="form-control" placeholder="Nama Warna">
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
        <h5 class="modal-title" id="exampleModalLabel">Edit Warna</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>          
      <form enctype="multipart/form-data" id="editWarnaForm" action="<?=base_url();?>Warna/editWarna" method = "POST" >

	      <div class="modal-body">
	          
	               <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
	                <div class="input-group mb-3">
	                    <input autocomplete="off" readonly required name="kode_warna" type="text" id="edit_id_warna" class="form-control" placeholder="Kode Warna">
	                </div>   
	                  <div class="input-group mb-3">
	                    <input autocomplete="off"  required name="nama_warna" type="text" id="edit_nama_warna" class="form-control" placeholder="Nama Warna">
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


