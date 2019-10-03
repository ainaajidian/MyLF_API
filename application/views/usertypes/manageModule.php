<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
         
                <div class="card">
              <div class="card-header">
                <h3 class="card-title"> <a href="<?=base_url();?>Usertype/"> <i class="fas fa-arrow-left"></i>   </a>  <span style="margin-left: 5px;">Manage Module for <?=$usertype_info->type_description;?></span> </h3>
              </div>
              	<div class="card-body">
	                 <table class="table" id="example2">
                    <thead>
                      <tr>
                        <th>Module Name</th>
                        <th>Module Type</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($list as $key) {

                        if($key->module_type == 1){
                            $a = "Portal";
                        }else{
                            $a = "Sidebar";
                        }

                       echo "<tr>
                                <td>".$key->module_name."</td> 
                                  <td>".$a."</td> 
                                <td> <a class='btn btn-danger deleteAccess' href='".base_url()."Usertype/revokeAccess/".$key->access_id."'> Revoke Access </a></td>
                            </tr>";
                      }
                     ?>
                    </tbody>

                </table>

	             </div>
          		</div>

         </div>
      </div>
   </div>
</div>


<div class="modal fade" id="addModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow:hidden;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Usertype</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>          
      <form enctype="multipart/form-data" id="moduleForm" action="<?=base_url();?>Usertype/saveAccess" method = "POST" >

        <div class="modal-body">                 
                <input type="hidden" name="type_id" value="<?=$usertype_info->type_id;?>" />
                 <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
              
                   <div class="input-group mb-3">
                      <select required  name="module_id" class="form-control">
                        <option value=""> Select Module </option>
                        <?php foreach ($module as $key) { ?>
                           <option value="<?=$key->module_id;?>"><?=$key->module_name;?></option>
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
