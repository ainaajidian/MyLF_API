<div class="form-actions no-margin-bottom" style="padding-left: 15px">
  <a href="<?=base_url();?>Members"><button class="btn btn-default"><i class="fa fa-arrow-left"></i> Kembali ke List</button></a>
</div>

<br>
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
              	<div class="card-header">
                	<h3 class="card-title">Data Member</h3>
              	</div>
              	<div class="card-body">

              		<table class="table">
              			 <tr>
              			 	<td> UserId </td>
              			 	<td> <?=$info->userId;?></td>
              			 </tr>
              			 <tr>
              			 	<td> Nama </td>
              			 	<td> <?=$info->userFullname;?></td>
              			 </tr>
              			 <tr>
              			 	<td> Email </td>
              			 	<td> <?=$info->userEmail;?></td>
              			 </tr>
              			 <tr>
              			 	<td> Telp </td>
              			 	<td> <?=$info->userMobilephone;?></td>
              			 </tr>
                     <tr>
                      <td> ... </td>
                      <td> <img width="250" height="250" src="<?=base_url();?>assets/profileImage/<?=$info->userProfilImage;?>"> </td>
                     </tr>
              			
              		</table>
              		<br>
              		<br>
              		<br>

	             	<div class="table-responsive">
	              		<table width='100%' class="table" id="transaksi">
	              			<thead>
	              				<tr>
		              				<th>Lokasi Outlet</th>
		              				<th>Tanggal</th>
		              				<th>Penggunaan Point</th>
		              				<th>Reward Point</th>
		              				<th>Total Pembayaran</th>
		              				<th>Total Point</th>
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
