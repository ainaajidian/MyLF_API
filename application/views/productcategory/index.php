<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
              	<div class="card-header">
                	<h3 class="card-title">Product Category Table</h3>
              	</div>
              	<div class="card-body">
	             	<div class="table-responsive">
	              		<table width='100%' class="table" id="ProductCategory">
	              			<thead>
	              				<tr>
		              				<th width="15%">ID Kategori</th>
		              				<th width="17%">Nama Kategori</th>
		              				<th width="15%">Gambar</th>
		              				<th width="30%">Deskripsi</th>
		              				<th width="23%">Aksi</th>
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
        <h5 class="modal-title" id="exampleModalLabel">Add Product Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>          
      <form enctype="multipart/form-data" id="categoryForm" action="<?=base_url();?>ProductCategory/saveCategory" method = "POST" >
	      <div class="modal-body">
	          
	               <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
	                
	                <div class="input-group mb-3">
	                    <input autocomplete="off"  required name="categoryName" type="text"  class="form-control" placeholder="Category Name">
	                </div>   

	                <div class="input-group mb-3">
	                    <input autocomplete="off"  required name="categoryDescription" type="text" class="form-control" placeholder="Category Description">
	                </div> 

	                <div class="input-group mb-3">
	                	<select class="form-control" id="parentCategoryId" name="parentCategoryId">
	            			<option value="" disabled selected>Select Parent Category</option>
	            			<option value="">Parent</option>
	            			<?php foreach ($parent_module as $key) 
	            			{ echo "<option value='".$key->categoryId."'> ".$key->categoryName." </option>"; } ?>
	                	</select>
	                </div>

	                <div  id="module_image_label" class="input-group mb-3">
	                    <input id="categoryImage"  name="categoryImage" type="file" class="form-control" placeholder="Category Image">
	                </div>

	                <div  id="module_image_label">
	                	 <input name="categoryCreatedDate" type="date hidden" class="form-control" placeholder="Category Created Date" value="<?php echo date('Y-m-d'); ?>" hidden="true">
	                </div>

	                <div  id="module_image_label">
	                	 <input name="categoryModifiedDate" type="date hidden" class="form-control" placeholder="Category Modified Date" value="<?php echo date('Y-m-d'); ?>" hidden="true">
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
      <form enctype="multipart/form-data" id="editcategoryForm" action="<?=base_url();?>ProductCategory/updateCategory" method = "POST" >
	      <div class="modal-body">
	          
	               <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
	               <input type="hidden" name="categoryId" id="editcategoryId" />

	                <div class="input-group mb-3">
	                    <input autocomplete="off" id="editcategoryName" required name="categoryName" type="text"  class="form-control" placeholder="Category Name">
	                </div>   

	                <div class="input-group mb-3">
	                    <input autocomplete="off" id="editcategoryDescription" required name="categoryDescription" type="text" class="form-control" placeholder="Category Description">
	                </div>

	                <div  class="input-group mb-3">
	                	<select class="form-control" id="editparentCategoryId" name="parentCategoryId">
	                	
	                		<option value=''>Parent</option>
                			<?php foreach ($parent_module AS $key) 
                			{ echo "<option value='".$key->categoryId."'> ".$key->categoryName." </option>"; } ?>
	                			}
	                	?>
	                	</select>
	                </div>

	                <div  id="module_image_label" class="input-group mb-3">
	                    <input id="editcategoryImage"  name="editcategoryImage" type="file" class="form-control" placeholder="Category Image">
	                </div>    

	                <div  id="module_image_label" class="input-group mb-3">
	                	 <input id="editcategoryModified"  name="categoryModifiedDate" type="date hidden" class="form-control" placeholder="Category Modified Date" value="<?php echo date('Y-m-d'); ?>" hidden="true">
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
