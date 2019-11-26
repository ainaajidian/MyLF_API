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
											<td id="cartId"><?=$cart->cartId;?></td>
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
										<tr>
											<th>Nomor Struk</th>
											<td>
												<input type="hidden" name="cartId" value="<?=$cart->cartId;?>">
												<input type="text" maxlength="32" name="salesOrderTransactionNo" value="<?=$cart->salesOrderTransactionNo;?>">
												<button class="btn btn-warning"> Input Struk </button>
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

					<div class="col-md-12" style="padding-top: 10px; padding-bottom: 50px;"> 
        			<div class="row">
						<div class="col-md-4">
							<form method="POST" action="<?=base_url().'Cart/saveResi';?>">
								<table class="table table-bordered" style="width:100%; height:700px;">
									<thead>
										<tr>
											<th>Product Name</th>
											<td><?=$cart->productName;?> ( <?=$cart->productId;?> )</td>
										</tr>
										<tr>
											<th>Image Product</th>
											<td> <img data-value="<?=$cart->image1;?>" data-id="<?=$cart->image1;?>" style="height: 100px; width: 100px;" src="<?=base_url();?>assets/app_assets/product_image/<?=$cart->image1;?>"> </td> 	
										</tr>
										<tr>
											<th>Product Color</th>
											<td><?=$cart->ccName;?></td>
										</tr>
										<tr>
											<th>Product Size</th>
											<td><?=$cart->SizeDescription?></td>
										</tr>									
									</thead>
								</table>
							</form>
						</div>
						
						<div class="col-md-4 direct-chat-messages">
							<table class="table table-bordered" style="padding-right:5px; width:100%; height:700px;" >
								<thead>
									<tr>
										<th>Harga</th>
										<td><?=$cart->productPrice;?></td>
									</tr>
									<tr>
										<th>Diskon</th>
										<td><?=$cart->disc;?></td>
									</tr>
									<tr>	
										<th>Setelah Diskon</th>
										<td><?=$cart->productPriceAfterPromo;?></td>
									</tr>
									<tr>
										<th>Harga Ongkir</th>
										<td><?=$cart->deliveryPrice?></td>
									</tr>
									<tr>
										<th>Total Belanja</th>
										<td><?=$cart->grandTotal;?></td>
									</tr>
								</thead>
							</table>
						</div>

						<div class="col-md-4 direct-chat-messages">
							<table class="table table-bordered" style="padding-right:5px; width:100%; height:400px;">
								<thead>
									<tr>
										<th>Tipe Pembayaran</th>
										<td><?php
												if ($cart->midtransPaymentType == 'bank_transfer' && $cart->midtransStatusCode == 202) 
													{ echo "$cart->va_bank " . "- Ditolak"; }
												elseif ($cart->midtransPaymentType == 'bank_transfer' && $cart->midtransStatusCode != 202)
													{ echo "$cart->va_bank"; }
												elseif ($cart->midtransPaymentType == 'credit_card')
													{ echo "Kartu Kredit"; }
												else
													{ echo "$cart->midtransPaymentType"; }
										?></td>
									</tr>
									<tr>
										<th>No VA</th>
										<td><?php
												if ($cart->midtransPaymentType == 'bank_transfer' && $cart->midtransStatusCode == 202)
													{ echo "$cart->va_numbers " . "- Ditolak"; }
												elseif ($cart->midtransPaymentType == 'bank_transfer' && $cart->midtransStatusCode != 202)
													{ echo "$cart->va_numbers"; }
												else
													{ echo "-"; }
										?></td>
									</tr>	
									<tr>
										<th>Nomor Resi</th>
										<td><?php
												if ($cart->midtransStatusCode == 202) 
													{ echo "Pesanan Di tolak"; }
												else
													{ echo "$cart->deliveryResiNo"; } ?>
										</td>
									</tr>
									<tr>
										<th>Status Penerimaan</th>
										<td><?php
												if ($cart->midtransStatusCode == 202) 
												{ echo "Pesanan Di tolak"; }
												elseif ($cart->customerReceiveStatus == 1)
												{ echo "Barang sudah di terima"; }
												else
												{ ?>  <button class="btn btn-warning"><a href="<?=base_url();?>cart/sendReminder/<?=$cart->cartId?>"> Reminder</a> </button><?php }
											?></td>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				
					<table class="table table-bordered col-md-12" style="max-width: 100%">
						<thead>
							<tr>
								
								
							</tr>
						</thead>
						
					</table>
				</div> 
          	</div>
         </div>
      </div>
   </div>
</div>

