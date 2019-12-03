<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
              	<div class="card-header">
                	<h3 class="card-title">Chat</h3>
              	</div>
              	<div class="card-body">
	             	<div class="table-responsive">
	              		<table width='100%' class="table" id="chatTable">
	              			<thead>
	              				<tr>
		              				<th>ID</th>
		              				<th>Product</th>
									  <th>Customer</th>
									  <th> Chat Di Mulai Pada </th>
									  <th> Detail </th>
		              				<!-- <th width="23%">Action</th> -->
		              			</tr>
							  </thead>
							  <tbody>
								  <?php foreach($chat as $data){ ?>
									<tr>
										<td><?=$data->chatId;?>
										<?php
											$prod = explode("-",$data->roomId);
										?>

										<?php
											$dataItem = $this->db->query("SELECT * FROM products where productId ='".$prod[2]."' ")->row();
										?>

										<td><?=$dataItem->productId;?> - <?=$dataItem->productErpCode;?></td>
										<td><?=$data->userFullname;?></td>
										<td><?=$data->createdDate;?></td>
										<td><a href="<?=base_url();?>Chat/detail/<?=$data->roomId;?>"> Detail </a></td>
									</tr>

								 <?php } ?>
								  

							  </tbody>
		              		
	              		</table>
	            	</div>
	        	</div>
          	</div>
         </div>
      </div>
   </div>
</div>