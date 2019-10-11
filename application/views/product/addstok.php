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
                	<h3 class="card-title">Input Stok Untuk Produk :</h3>
              	</div>
              	<div class="card-body">
	             	<div class="table-responsive">
	             		<form method="POST" action="<?=base_url();?>Product/saveheader/">
	              		<table width='100%' class="table" >
	              			<thead>
	              				<tr>
		              				<td>Product Name</td><td><?=$infoProduct->productName;?></td>
		              			</tr>
		              				<tr>
		              				<td>Product Price</td><td><?=$infoProduct->productPrice;?></td>
		              			</tr>
		              			<tr>
		              				<td>Product Description</td><td width="50%"><?=$infoProduct->productDescription;?></td>
		              			</tr>
		              			<tr>
		              				<td>Product Erp Code</td><td width="50%"><?=$infoProduct->productErpCode;?></td>
		              			</tr>
		              			<tr>
		              				<td>Product UOM</td><td width="50%"><?=$infoProduct->UOMCode;?></td>
		              			</tr>
		              			<tr>
		              				<td>Product Flag</td>
		              				<td>
		              					<?php if($infoProduct->isHot == "1"){ echo "Hot Products";}
		              					else if($infoProduct->isHot == "2"){ echo "New Products";}
		              					 else { echo "-";} ?>
		              				</td>
		              			</tr>
		              		</thead>          		
	              		</table>
	              		</form>
	            	</div>
	        	</div>
	        	<div class="row">
	        		<div class="card-body col-md-5"> 
	        			<img height="100" width="100" id="imageexample1" src="">
	        			<img height="100" width="100" id="imageexample2" src="">
	        			<img height="100" width="100" id="imageexample3" src="">
	        		</div>
	        	</div>
	        	<div class="row">
				<div class="card-body col-md-5">
	        		
	        	</div>

	        	<div class="card-body col-md-5">
	        		<form action="<?=base_url();?>Product/savestok/<?=$infoProduct->productId;?>/<?=$infoProduct->categoryId;?>" method="POST" class="form-horizontal">
	        			<table class="table">
	        					<tr>
		              				<td>Store ID</td>
		              				<td colspan="2">
		              					<input readonly required class="form-control" type="text" name="storeId" id="storeId">
		              				</td>
		              			</tr>	
	        					<tr>
		              				<td>Product Color</td>
		              				<td colspan="2">
		              				<select required class="form-control" id="productColorId"  name="productColorId">
		              					<option value="" disabled selected> -- Product Color -- </option>
		              					<?php foreach ($infoColor as $key) { ?>
		              						<option value="<?=$key->productColorId;?>"><?=$key->ccName;?></option>
		              						<?php 	}	?>
		              				</select>

		              				</td>
		              			</tr>		             
		              			<tr>
		              				<td>Product Size</td>
		              				<td colspan="2">
		              				<select required class="form-control" id="sizes"  name="sizes">
		              					<option value="" disabled selected> -- Product Size -- </option>
		              					<?php foreach ($sizes as $key) { ?>
		              						<option value="<?=$key->ProductSizeId;?>"><?=$key->SizeDescription;?></option>
		              						<?php 	}	?>
		              				</select>
		              				</td>
		              			</tr>
		              			<tr>
		              				<td>Stok</td>
		              				<td colspan="2">
		              					<input required type="number" class="form-control" name="stok">
		              				</td>
		              			</tr>
		              			<tr>
		              				<td colspan="3"> <button type="submit" class="btn btn-info"> Simpan </button></td>
		              				
		              			</tr>
	        		</table>
	        	</form>
	        	</div>

</div>
	    


         </div>
      </div>
   </div>
</div>
</div>

