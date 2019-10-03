<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
         
                <div class="card">
              <div class="card-header">
                <h3 class="card-title">Master Matriks</h3>
                <br>
                <?php if($tipeuser=="TP004"){?>
                <a href="<?=base_url();?>Matriks/add"><button>Tambah</button></a>
                <?php } ?>
              </div>
              	<div class="card-body">
	              <div class="table-responsive">
	              <table class="table" id="example1">
	              		<thead>
	              			<tr>
	              				<th>No</th>
	              				<th>Kabupaten</th>
	              				<th> Kecamatan </th>
                        <th> Desa </th>
                        <th> Jenis Bantuan </th>
                        <th> Status </th>
                        <th> Aksi</th>
	              			</tr>
	              		</thead>
                    <tbody>
                      <?php $x=0; foreach ($list as $key ) { $x++; ?>
                      <tr>
                          <td><?=$x;?></td>
                          <td><?=$key->namakabupaten;?></td>
                          <td><?=$key->namakecamatan;?></td>
                          <td><?=$key->namadesa;?></td>
                          <td><?=$key->NamaBantuan;?></td>
                          <td>

                           <?php if($key->status != 1){
                            echo "<p class='alert-danger'> &nbsp; </p>";
                           } else{
                               echo "<p class='alert-success'> &nbsp; </p>";
                           }?>


                          </td>
                          <td><a href="<?=base_url();?>Matriks/detail/<?=$key->idkabupaten;?>/<?=$key->idkecamatan;?>/<?=$key->iddesa;?>/"> Detail </a></td>
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