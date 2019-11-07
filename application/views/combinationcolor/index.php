<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
              	<div class="card-header">
                	<h3 class="card-title">Combination Color Table</h3>
              	</div>
              	<div class="card-body">
	             	<div class="table-responsive">
	              		<table width='100%' class="table" id="CombinationColor">
	              			<thead>
	              				<tr>
		              				<th>Id</th>
		              				<th>Color Name</th>
		              				<th>Primary Name</th>
		              				<th>Primary Hex</th>
		              				<th>Secondary Name</th>
		              				<th>Secondary Hex</th>
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
        <h5 class="modal-title" id="exampleModalLabel">Add Combination Color</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>          
    <form enctype="multipart/form-data" id="ccForm" action="<?=base_url();?>CombinationColor/saveColor" method = "POST" >
	        <div class="modal-body">
	          
	               <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
	                
	                <div class="input-group mb-3">
	                    <input autocomplete="off"  required name="ccName" type="text"  class="form-control" placeholder="Color Name">
	                </div>   

	                <div class="input-group mb-3">
	                    <input autocomplete="off"  required name="ccPriName" type="text" class="form-control" placeholder="Color Primary Name">
	                </div>   

	                <div class="input-group mb-3">
	                    <input autocomplete="off"  required name="ccPriHex" type="text" class="form-control" placeholder="Color Primary Hex Code">
	                </div> 

	                <div class="input-group mb-3">
	                    <input autocomplete="off"  required name="ccSecName" type="text" class="form-control" placeholder="Color Secondary Name">
	                </div>   

	                <div class="input-group mb-3">
	                    <input autocomplete="off"  required name="ccSecHex" type="text" class="form-control" placeholder="Color Secondary Hex Code">
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
      <form enctype="multipart/form-data" id="editccForm" action="<?=base_url();?>CombinationColor/updateColor" method = "POST" >
	      <div class="modal-body">
	          
	               <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
	               <input type="hidden" name="ccId" id="editccId" />

	               <div class="input-group mb-3">
	                    <input autocomplete="off"  required id="editccName" name="ccName" type="text"  class="form-control" placeholder="Color Name">
	                </div>   

	                <div class="input-group mb-3">
	                    <input autocomplete="off"  required id="editccPriName" name="ccPriName" type="text" class="form-control" placeholder="Color Primary Name">
	                </div>   

	                <div class="input-group mb-3">
	                    <input autocomplete="off"  required id="editccPriHex" name="ccPriHex" type="text" class="form-control" placeholder="Color Primary Hex Code">
	                </div> 

	                <div class="input-group mb-3">
	                    <input autocomplete="off"  required id="editccSecName" name="ccSecName" type="text" class="form-control" placeholder="Color Secondary Name">
	                </div>   

	                <div class="input-group mb-3">
	                    <input autocomplete="off"  required id="editccSecHex" name="ccSecHex" type="text" class="form-control" placeholder="Color Secondary Hex Code">
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