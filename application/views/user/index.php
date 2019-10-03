<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
         
                <div class="card">
              <div class="card-header">
                <h3 class="card-title">User Table</h3>
              </div>
              	<div class="card-body">
	              <table width='100%' class="table" id="example1">

	              		<thead>
	              			<tr>
	              				<th>User Id</th>
	              				<th>Username</th>
	              				<th>Usertype</th>
	              				<th>Status</th>
	              				<th>Email</th>
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
        <h5 class="modal-title" id="exampleModalLabel">User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>          
      <form enctype="multipart/form-data" id="userForm" action="<?=base_url();?>User/saveuser" method = "POST" >
	      <div class="modal-body">
	          
	               <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
	                
	                <div class="input-group mb-3">
	                    <input autocomplete="off"  required name="username" type="text"  class="form-control" placeholder="username">
	                </div>   

	                <div class="input-group mb-3">
	                    <input autocomplete="off"  required name="useremail" type="email" class="form-control" placeholder="Email">
	                </div>   


	                  <div class="input-group mb-3">
	                    <input autocomplete="off"  required name="userpassword" type="password"  class="form-control" placeholder="Password">
	                </div>   

	                <div class="input-group mb-3">
	                    <select required  name="usertype" class="form-control">
	                    	<option value=""> Select User type </option>
	                    	<?php foreach ($user_type as $key) { ?>
	                    		 <option value="<?=$key->type_id;?>"><?=$key->type_description;?></option>
	                    	<?php } ?>
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
        <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>          
      <form enctype="multipart/form-data" id="edituserForm" action="<?=base_url();?>User/updateUser" method = "POST" >
	      <div class="modal-body">
	          
	               <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
	               <input type="hidden" name="userid" id="editUserid" />

	                <div class="input-group mb-3">
	                    <input autocomplete="off" id="editUsername" required name="username" type="text"  class="form-control" placeholder="username">
	                </div>   

	                <div class="input-group mb-3">
	                    <input autocomplete="off" id="editUseremail" required name="useremail" type="email" class="form-control" placeholder="Email">
	                </div>   

	                <div class="input-group mb-3">
	                    <select required id="editUsertype"  name="usertype" class="form-control">
	                    	<option value=""> Select User type </option>
	                    	<?php foreach ($user_type as $key) { ?>
	                    		 <option value="<?=$key->type_id;?>"><?=$key->type_description;?></option>
	                    	<?php } ?>
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