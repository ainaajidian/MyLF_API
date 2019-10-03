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
		              				<td>Product Flag</td>
		              				<td>
		              					<?php if($product->isHot == "1"){ echo "Hot Products";} ?>
										<?php if($product->isHot == "2"){ echo "New Products";} ?>
		              				</td>
		              			</tr>
		              		
		              		
		              		</thead>
		             		              		
	              		</table>
	              		</form>
	            	</div>
	        	</div>

	        



	        	<div class="row">
	        		<div class="card-body col-md">
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
	              					 		<img height="100" width="100" src="<?=base_url();?>assets/app_assets/product_image/<?=$key->image1;?>">
	              					 	<?php } ?>
	              					 	 </td> 
	              					 	 <td> 
	              					 	<?php if($key->image2 != "") { ?> 
	              					 		<img height="100" width="100" src="<?=base_url();?>assets/app_assets/product_image/<?=$key->image2;?>">
	              					 	<?php } ?>
	              					 	 </td> 
	              					 	 <td> 
	              					 	<?php if($key->image3 != "") { ?> 
	              					 		<img height="100" width="100" src="<?=base_url();?>assets/app_assets/product_image/<?=$key->image3;?>">
	              					 	<?php } ?>
	              					 	 </td> 

	              					 <td> Delete </td> 

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
