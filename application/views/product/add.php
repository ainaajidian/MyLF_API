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
		              				<td>Product Name</td><td colspan="2"><input class="form-control" type="text" name="productName" id="productName" placeholder="Product Name"></td>
		              			</tr>

		              			<tr>
		              				<td>Product Code (ERP)</td><td><input class="form-control" type="text" name="productErpCode" id="erpCode" placeholder="ERP Code"></td> 
		              				<td><button type="button" class="btn btn-danger" id="findItem"> Check Item </button> </td>
		              			</tr>

		              			<tr>
		              				<td>UOM Code</td><td colspan="2"><input readonly class="form-control" type="text" name="uomCode" id="uomCode" placeholder="uomCode"></td> 
		              			</tr>


		              				<tr>
		              				<td>Product Category</td>
		              				<td colspan="2">
		              					<select class="form-control" id="productCategory"  name="productCategory">
		              					<option value="" disabled selected>Product Category</option>
		              					<?php foreach ($categories as $key) { ?>
		              						<option value="<?=$key->categoryId;?>"><?=$key->categoryName;?></option>
		              				<?php 	}	?>
		              				</select>

		              				</td>
		              			</tr>

		              			<tr>
		              				<td>Product Child Category</td>
		              				<td colspan="2">
			              				<select class="form-control" id="childproductCategory"  name="childproductCategory">
			              					
			              				</select>
		              				</td>
		              			</tr>

		              			<tr>
		              				<td>Product Price</td><td colspan="2"><input readonly class="form-control" type="number" id="productPrice" name="productPrice" placeholder="Product Price"></td>
		              			</tr>

		              			<tr id="trSize">
									  <td>Product Size</td>
									  <td colspan="2">
										  <select id="productSize" name="productSize" class="select2 form-control">
												  <option> -- Pilih Ukuran </option>
												  <?php
												  for($x=0;$x<count($sizes);$x++){
													echo "<option value='".$sizes[$x]['SizeID']."'> ".$sizes[$x]['Keterangan']." </option>";

												  }
												?>
										  </select>
									  </td>
		              			</tr>

		              			<tr>
		              				<td>Product Flag</td>
		              				<td colspan="2">
		              					<select required class="form-control" name="productFlag">
		              						<option value="" disabled selected>Product Flag</option>
		              						<option value="0"> Normal Product </option>
		              						<option value="1"> Hot Product </option>
		              						<option value="2"> New Product </option>
		              					</select>
		              				</td>
		              			</tr>
		              			<tr>
		              				<td colspan="3" align="right"><button id="submitBtn" class="btn btn-info" type="submit"> Next Step </button></td>
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
