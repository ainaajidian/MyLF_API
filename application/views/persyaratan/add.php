<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
         
                <div class="card">
              <div class="card-header">
                <h3 class="card-title">Add Matriks</h3>
                <br>
                <a href="<?=base_url();?>Persyaratan/index"><button>Kembali</button></a>
              </div>
              	<div class="card-body">
	              <div class="table-responsive">
	           <div class="col-md-6">
                   <form enctype="multipart/form-data" id="moduleForm" action="<?=base_url();?>Matriks/saveHeader" method = "POST" >

                      <div class="form-group">
                          <label>Kabupaten</label>
                            <select required id="kabupaten" name="kabupaten" class="form-control">
                                <?php foreach ($kabupaten as $prov) { ?>
                                  <option value="<?=$prov->KODE_WILAYAH;?>"><?=$prov->NAMA;?></option>
                                <?php }?>
                            </select>                
                      </div>  

                      <div class="form-group">
                          <label>Kecamatan</label>
                            <select required id="kecamatan" name="kecamatan" class="form-control">
                                <option value=""> --PILIH Kecamatan-- </option>
                                <?php foreach ($kecamatan as $prov) { ?>
                                  <option value="<?=$prov->KODE_WILAYAH;?>"><?=$prov->NAMA;?></option>
                                <?php }?>
                            </select>                
                      </div> 
                      <div class="form-group">
                          <label>Desa</label>
                            <select required id="desa" name="desa" class="form-control">
                                <option value=""> --PILIH Desa-- </option>
                             
                            </select>                
                      </div>  
                          <div class="form-group">
                          <label>Jenis Bantuan</label>
                            <select required id="bantuan" name="bantuan" class="form-control">
                                <option value=""> --PILIH Jenis Bantuan-- </option>
                                <?php foreach ($bantuan as $key) {
                                 echo "<option value='".$key->BantuanID."'>".$key->NamaBantuan."</option>";
                                }

                                ?>
                             
                            </select>                
                      </div>  
                       <button type="submit"  class="btn btn-primary">Simpan</button>
                </form>
</div>

	             </div>
	         </div>
          		</div>

         </div>
      </div>
   </div>
</div>


