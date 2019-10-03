<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
         
                <div class="card">
              <div class="card-header">
                <h3 class="card-title">Manage Type Table</h3>
              </div>
              	<div class="card-body">
	              <table width='100%' class="table" id="example1">

	              		<thead>
	              			<tr>
	              				<th>Type</th>
	              				<th>Description</th>
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

<div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow:hidden;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Usertype</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>          
      <form enctype="multipart/form-data" id="moduleForm" action="<?=base_url();?>Usertype/saveUsertype" method = "POST" >

	      <div class="modal-body">
	          
	               <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
	                
	            
	                  <div class="input-group mb-3">
	                    <input autocomplete="off"  required name="usertype_desc" type="text" id="usertype_desc" class="form-control" placeholder="Usertype Description">
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


<div class="modal fade" id="editModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow:hidden;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Usertype</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>          
      <form enctype="multipart/form-data" id="editForm" action="<?=base_url();?>Usertype/updateUsertype" method = "POST" >
        <div class="modal-body">
                <input type="hidden" name="usertype_id"   id="usertype_id" />

                 <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                    <div class="input-group mb-3">
                      <input autocomplete="off"  required name="usertype_desc" type="text" id="usertype_desc_edit" class="form-control" placeholder="Usertype Description">
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