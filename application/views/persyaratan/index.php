<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
         
                <div class="card">
                  <div class="card-header">
                    <?php if($tipeuser == "TP004"){ ?>
                    <a href="<?=base_url();?>Persyaratan/addheader" class="btn btn-info"> Tambah </a>
                    <?php } ?>
                  </div>
              	<div class="card-body">
	              <div class="table-responsive">
	              <table class="table" id="example1">
	              		<thead>
	              			<tr>
	              				<th>No</th>
	              				<th>Kabupaten</th>
                        <th>Kecamatan</th>
                        <th>Desa</th>
                        <th>Pagu</th>
                        <th>Tahun</th>
                        <th> Status</th>
                        <th> Aksi</th>
	              			</tr>
	              			</tr>
	              		</thead>
                    <tbody>
                      <?php $x=0; foreach ($list as $key ) { $x++; ?>
                      <tr>
                          <td><?=$x;?></td>
                          <td><?=$key->namakabupaten;?></td>
                          <td><?=$key->kecamatan;?></td>
                          <td><?=$key->desa;?></td>
                          <td><?=$key->pagu;?></td>
                          <td><?=$key->tahun;?></td>
                          <td>
                          
                           <?php if($key->status != 1){
                            echo "<p class='alert-danger'> &nbsp; </p>";
                           } else{
                               echo "<p class='alert-success'> &nbsp; </p>";
                           }?>
                          </td>
                          <td><a href="<?=base_url();?>Persyaratan/detail/<?=$key->id;?>/"> Detail </a></td>
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