<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
         
            <div class="card">
            	<div class="card-header">
                <h3 class="card-title">Module Table</h3>
              </div>
              	<div class="card-body">
	              <div class="table-responsive">
	              <table width='100%' class="table" id="example1">

	              		<thead>
	              			<tr>
	              				<th>module_name</th>
	              				<th>parent_name</th>
	              				<th>module_path</th>
	              				<th>module_icon</th>
	              				<th>Status</th>
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
        <h5 class="modal-title" id="exampleModalLabel">Module</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>          
      <form enctype="multipart/form-data" id="moduleForm" action="<?=base_url();?>Module/saveModule" method = "POST" >

	      <div class="modal-body">
	          
	               <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
	                
	                <div class="input-group mb-3">
	                    <input autocomplete="off"  required name="module_name" type="text" id="module_name" class="form-control" placeholder="Module Name">
	                </div>   

	                  <div class="input-group mb-3">
	                    <input autocomplete="off"  required name="module_path" type="text" id="module_path" class="form-control" placeholder="Module Path">
	                </div>   

	                <div class="input-group mb-3">
	                    <select required id="module_type" name="module_type" class="form-control">
	                    	<option value=""> Select module type </option>
		                    <option value="1">Portal</option>
		                    <option value="2">Sidebar Menu</option>
	                  </select>
	                </div>   

	                <div  class="input-group mb-3">
	                	<select class="form-control" id="module_parent" name="module_parent">
	            			<option value=""> Choose parent </option>
	            			<?php foreach ($parent_module as $key) 
	            			{ echo "<option value='".$key->module_id."'> ".$key->module_name." </option>"; }
	                	?>
	                	</select>
	                </div>   

	                 <div  id="module_icon_label" class="input-group mb-3">
	                    <input autocomplete="off"  id="module_icon_2"  name="module_icon" type="text" class="form-control" placeholder="Module Icon">
	                </div>   

	 				<div  id="module_image_label" class="input-group mb-3">
	                    <input  id="module_icon_1"  name="userfile" type="file" class="form-control" placeholder="Module Icon">
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
        <h5 class="modal-title" id="exampleModalLabel">Edit Module</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>          
      <form enctype="multipart/form-data" id="editmoduleForm" action="#" method = "POST" >
	      <div class="modal-body">
	        
	               <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
	                
	                <div class="input-group mb-3">
	                    <input autocomplete="off"  required name="module_name" type="text" id="edit_module_name" class="form-control" placeholder="Module Name">
	                </div>   

	                  <div class="input-group mb-3">
	                    <input autocomplete="off"  required name="module_path" type="text" id="edit_module_path" class="form-control" placeholder="Module Path">
	                </div>   

	                <div class="input-group mb-3">
	                    <select required id="edit_module_type" name="module_type" class="form-control">
	                    	<option value=""> Select module type </option>
		                    <option value="1">Portal</option>
		                    <option value="2">Sidebar Menu</option>
	                  </select>
	                </div>   

	                <div  class="input-group mb-3">
	                	<select class="form-control" id="edit_module_parent" name="module_parent">
	                			<option value=""> Choose parent </option>
	                			<?php foreach ($parent_module as $key) {
	                				echo "<option value='".$key->module_id."'> ".$key->module_name." </option>";
	                			}
	                	?>
	                	</select>
	                </div>   

	                 <div  id="module_icon_label" class="input-group mb-3">
	                    <input autocomplete="off"  id="edit_module_icon_2"  name="module_icon" type="text" class="form-control" placeholder="Module Icon">
	                </div>   

	 				<div  id="module_image_label" class="input-group mb-3">
	                    <input id="edit_module_icon_1"  name="userfile" type="file" class="form-control" placeholder="Module Icon">
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
