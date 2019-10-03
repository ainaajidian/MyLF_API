<div class="form-actions no-margin-bottom" style="padding-left: 15px">
  <a href="http://memberlf.rpgroup.co.id/Product"><button class="btn btn-default"><i class="fa fa-arrow-left"></i> Kembali ke List</button></a>
</div>

<br>

<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
              	<div class="card-header">
                	<h3 class="card-title">Add Product</h3>
              	</div>
              	<div class="card-body">
	             	<div class="table-responsive">
	             		<form method="POST" action="<?=base_url();?>Product/saveheader/">
	              		<table width='100%' class="table" >
	              			<thead>
	              				<tr>
		              				<td>Product Name</td><td><input class="form-control" type="text" name="productName" placeholder="Product Name"></td>
		              			</tr>
		              				<tr>
		              				<td>Product Category</td>
		              				<td>
		              					<select class="form-control"  name="productCategory">
		              					<option value="" disabled selected>Product Category</option>
		              					<?php foreach ($categories as $key) { ?>
		              						<option value="<?=$key->categoryId;?>"><?=$key->categoryName;?></option>
		              				<?php 	}	?>
		              				</select>

		              				</td>
		              			</tr>

		              			<tr>
		              				<td>Product Child Category</td>
		              				<td>
		              					<select class="form-control"  name="childproductCategory">
										<option value="" disabled selected>Product Child Category</option>
		              					<?php foreach ($child_categories as $key) 
		              					{ ?>
		              						<option value="<?=$key->categoryId;?>"><?=$key->categoryName;?></option>
		              					<?php } ?>
		              				</select>

		              				</td>
		              			</tr>

		              			<tr>
		              				<td>Product Price</td><td><input class="form-control" type="number" name="productPrice" placeholder="Product Price"></td>
		              			</tr>
		              			<tr>
		              				<td>Product Description</td><td><textarea class="form-control" type="number" name="productDescription" placeholder="Product Description"></textarea></td>
		              			</tr>
		              			<tr>
		              				<td>Product Flag</td>
		              				<td>
		              					<select class="form-control" name="productFlag">
		              						<option value="" disabled selected>Product Flag</option>
		              						<option value="0"> Normal Product </option>
		              						<option value="1"> Hot Product </option>
		              						<option value="2"> New Product </option>
		              					</select>
		              				</td>
		              			</tr>
		              			<tr>
		              				<td colspan="2" align="right"><button class="btn btn-info" type="submit"> Next Step </button></td>
		              			</tr>
		              		
		              		</thead>
		             		              		
	              		</table>
	              		</form>
	            	</div>
	        	</div>
          	</div>
         </div>
      </div>
   </div>
</div>
