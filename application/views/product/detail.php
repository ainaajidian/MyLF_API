<div class="form-actions no-margin-bottom" style="padding-left: 15px">
  <a href="<?=base_url();?>Product"><button class="btn btn-default"><i class="fa fa-arrow-left"></i> Kembali ke List</button></a>
</div>

<br>

<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
              	<div class="card-header">
                	<h3 class="card-title">Detail Product</h3>
              	</div>
              	<div class="card-body">
	             	<div class="table-responsive">
	             		<form method="POST" action="<?=base_url();?>Product/saveheader/">
	              		<table width='100%' class="table" >
	              			<thead>
	              				<tr>
		              				<td>Product Name</td><td><?=$product->productName;?></td>
		              			</tr>
		              				<tr>
		              				<td>Product Category</td>
		              				<td><?=$product->categoryName;?></td>
		              			</tr><tr>
		              				<td>Product Price</td><td><?=$product->productPrice;?></td>
		              			</tr>
		              			<tr>
		              				<td>Product Description</td><td width="50%"><?=$product->productDescription;?></td>
		              			</tr>
		              			<tr>
		              				<td>Product Erp Code</td><td width="50%"><?=$product->productErpCode;?></td>
		              			</tr>
		              			<tr>
		              				<td>Product UOM</td><td width="50%"><?=$product->UOMCode;?></td>
		              			</tr>
		              			<tr>
		              				<td>Product Flag</td>
		              				<td>
		              					<?php if($product->isHot == "1")
		              							{ echo "Hot Products";}
			              					  else if($product->isHot == "2")
			              					 	{ echo "New Products";}
		              					 	  else 
		              					 	  	{ echo "-";} ?>
		              				</td>
		              			</tr>
		              		</thead>          		
	              		</table>
	              		</form>
	            	</div>
	        	</div>

	        	<div class="row">
	        		<div class="card-body col-md">
	        			<a href="<?=base_url();?>Product/addstok/<?=$product->productId;?>/<?=$product->categoryId;?>"> 
	        				<button type="button" class="btn btn-warning">Ubah Stok</button> 
	        			</a>

						<a id="addSize" href="#"> 
	        				<button type="button" class="btn btn-warning">Tambah Ukuran</button> 
	        			</a>
						<br>

						<br>
						<div class="col-md-5">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Color</th> 
									<th>Size</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($ProductSizes as $productsize) { ?>
								<tr>
									<td><?=$productsize->ccName;?></td>
									<td><?=$productsize->SizeDescription;?></td>
									<td><a href="<?=base_url();?>Product/deleteSize/<?=$product->productId;?>/<?=$productsize->ProductSizeId;?>"> Hapus </a> </td>
								</tr>
							<?php } ?>
								
							</tbody>
						</table>
						</div>


	        			<div class="card-header"> Product Color List </div>
	        			<br>
	        			<a href="<?=base_url();?>Product/addcolor/<?=$product->productId;?>"><button href="#coloraddForm" class="btn btn-info" style="margin-bottom: 10px;margin-left: 10px">  Add New Color </button></a>


     	<div class="table-responsive">
	              		<table width='100%' class="table" >
	              			<thead>
	              				<tr>
	              						<th> No </th>
	              						<th> Color Name </th>
	              						<th> Image 1</th>
	              						<th> Image 2</th>
	              						<th> Image 3</th>
	              						<th> Action</th>
	              				</tr>

	              				<?php $x=0; foreach ($product_colors as $key) { $x++; ?>
	              				
	              				<tr> 
	              					<td> <?=$x;?> </td> 
	              					<td> <?=$key->ccName;?> </td>
	              					 <td> 
	              					 	<?php if($key->image1 != "") { ?> 
	              					 		<img class = "productImage" data-value="<?=$product->productId;?>" data-id="<?=$key->image1;?>" height="100" width="100" src="<?=base_url();?>assets/app_assets/product_image/<?=$key->image1;?>">
	              					 	<?php } ?>
	              					 	 </td> 
	              					 	 <td> 
	              					 	<?php if($key->image2 != "") { ?> 
	              					 		<img class = "productImage" data-value="<?=$product->productId;?>" data-id="<?=$key->image2;?>"  eight="100" width="100" src="<?=base_url();?>assets/app_assets/product_image/<?=$key->image2;?>">
	              					 	<?php } ?>
	              					 	 </td> 
	              					 	 <td> 
	              					 	<?php if($key->image3 != "") { ?> 
	              					 		<img class = "productImage" data-value="<?=$product->productId;?>" data-id="<?=$key->image3;?>"  height="100" width="100" src="<?=base_url();?>assets/app_assets/product_image/<?=$key->image3;?>">
	              					 	<?php } ?>
	              					 	 </td> 

	              					 <td> 
	              					 	<a href="<?=base_url();?>Product/deleteColor/<?=$product->productId;?>/<?=$key->productColorId;?>" class="btn btn-danger"> Hapus </a> </td>
	              					 </td> 
	              					</tr>	              		

	              				<?php } ?>
		              		
		              		</thead>
		             		              		
	              		</table>
	            	</div>
	        	</div>

	        </div>



         </div>
      </div>
   </div>
</div>
</div>


<div class="modal fade" id="addSizeModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow:hidden;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Size (Format size : P - L - T - Berat )</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>          
      <form enctype="multipart/form-data" id="editstoreForm" action="<?=base_url();?>Product/saveSize/<?=$product->productId;?>" method = "POST" >
	      <div class="modal-body">
	          
	               <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
	               <input type="hidden" name="storeId" id="editstoreId" />

				   <div class="input-group mb-3">
						<select name="productColor" class="form-control">
							<?php
								foreach ($product_colors as $pc) {
							?>
								<option value="<?=$pc->productColorId;?>"> <?=$pc->ccName;?></option>
							<?php
								}
							?>
						</select>
	                </div>  

					<div class="input-group mb-3">
						<select name="SizeID" class="form-control">
							<?php
								foreach ($sizes as $size) {
							?>
								<option value="<?=$size->SizeID;?>"> <?=$size->SizeDescription;?></option>
							<?php
								}
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