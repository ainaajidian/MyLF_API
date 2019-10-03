<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
         
                <div class="card">
              <div class="card-header">
                <h3 class="card-title">Master Pertanyaan</h3>
                <br>
                <a href="<?=base_url();?>Helpdesk/add"> <button>Tambah</button> </a>
              </div>
              	<div class="card-body">
	              <div class="table-responsive">
	              <table class="table" id="example1">

	              		<thead>
	              			<tr>
	              				<th>No</th>
                        <th> Subjek </th>
	              				<th>Tanggal Pertanyaan</th>
	              				<th>Status Pertanyaan</th>
                        <th> Aksi</th>
	              			</tr>
	              		</thead>
                    <tbody>
                    <?php 
                    $x=0;
                    foreach ($list as $key) { $x++;?>
                      <tr>
                        <td><?=$x;?></td>
                        <td><?=$key->subjek;?></td>
                        <td><?=$key->createddate;?></td>
                        <td><?php if($key->status == 0) {echo "Open";}else{echo "Done";}?></td>
                        <td><a href="<?=base_url();?>Helpdesk/detail/<?=$key->QId;?>"> Detail </a></td>
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

