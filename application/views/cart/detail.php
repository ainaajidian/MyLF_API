<div class="form-actions no-margin-bottom" style="padding-left: 15px">
  <a href="<?=base_url();?>Cart"><button class="btn btn-default"><i class="fa fa-arrow-left"></i> Kembali ke List</button></a>
</div>

<br>

<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
            	<h3 style="padding-top: 10px; padding-left: 10px;"> Detail Cart <b><?=$cart->cartId?></b> </h3>
            		<div class="col-md-12" style="padding-top: 10px; padding-bottom: 50px;"> 
        			<div class="row">
						<div class="col-md-4">
							<form method="POST" action="<?=base_url().'Cart/saveResi';?>">
								<table class="table table-bordered" style="width:100%">
									<thead>
										<tr>
											<th>Cart Id</th>
											<td><?=$cart->cartId;?></td>
										</tr>
										<tr>
											<th>User Id</th>
											<td><?=$cart->userId;?></td>
										</tr>
										<tr>
											<th>Store Name</th>
											<td><?=$cart->storeMall;?></td>
										</tr>
										<tr>
											<th>Resi</th>
											<td>
												<input type="hidden" name="cartId" value="<?=$cart->cartId;?>">
												<input type="text" name="deliveryResiNo" value="<?=$cart->deliveryResiNo;?>">
												<button class="btn btn-warning"> Input Resi </button>
											</td>
										</tr>
									</thead>
								</table>
							</form>
						</div>
						
						<div class="col-md-8 direct-chat-messages">
							<table class="table table-bordered" style="padding-right:5px; width:100%;" id='Delivery'>
								<thead>
									<tr>
										<th>Manifest Code</th>
										<th>Manifest Description</th>
										<th>Manifest Date</th>
										<th>Manifest Time</th>
										<th>City Name</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
					
					</br>
				
					<table class="table table-bordered col-md-12" style="max-width: 100%">
						<thead>
							<tr>
								<th>Product Name</th>
								<th>Image Product</th>
								<th>Product Color</th>
								<th>Product Size</th>
								<th>Store Mall</th>
								<th>Nomor Resi</th>
								<th>Status Penerimaan</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?=$cart->productName;?></td>
								<td> <img data-value="<?=$cart->image1;?>" data-id="<?=$cart->image1;?>" style="height: 100px; width: 100px;" src="<?=base_url();?>assets/app_assets/product_image/<?=$cart->image1;?>"> </td> 
								<td><?=$cart->ccName;?></td>
								<td><?=$cart->sizeId?></td>
								<td><?=$cart->storeMall;?></td>
								<td><?=$cart->deliveryResiNo;?></td>
								<td><?php
										if($cart->customerReceiveStatus == 1)
										{ echo "Barang sudah di terima"; }
										else
										{ echo "Barang belum di terima"; }
									?></td>

									
							</tr>
						</tbody>
					</table>
				</div> 
          	</div>
         </div>
      </div>
   </div>
</div>

