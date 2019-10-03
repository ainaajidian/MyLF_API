
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
         
                <div class="card">
              <div class="card-header">
                <br>
                <a href="<?=base_url();?>Persyaratan/"><button>Kembali</button></a>
              </div>
                <div class="card-body">
                <div class="table-responsive">
                  <form action="<?=base_url();?>Persyaratan/save_1" method="POST">
                     <table class="table">
                       <tr><td>Kabupaten</td>
                        <td>
                        <select name="kabupaten" class="form-control select2"> 
                          <option value=""> --Pilih Kabupaten--</option> 
                          <?php foreach ($kabupaten as $key) { ?>
                          <option value="<?=$key->KODE_WILAYAH;?>"> <?=$key->NAMA;?> </option>
                        <?php } ?>
                        </select>
                      </td>
                    </tr>
                         <tr><td>Kecamatan</td>
                        <td>
                        <input autocomplete="off" type="text" class="form-control" name="kecamatan">
                      </td>
                    </tr>

                      </tr>
                         <tr><td>Desa</td>
                        <td>
                        <input autocomplete="off" type="text" class="form-control" name="desa">
                      </td>
                    </tr>
                    <tr><td>Kegiatan</td>
                        <td>
                        <input autocomplete="off" type="text" class="form-control" name="kegiatan">
                      </td>
                    </tr>
                       </tr>
                        <tr><td>Pagu</td>
                        <td>
                        <input autocomplete="off" type="text" class="form-control" name="pagu">
                      </td>
                    </tr>

                         <tr><td>Tahun</td>
                        <td>
                       <select name="tahun" class="form-control">
                          <option value="2019">2019</option>
                          <option value="2020">2020</option>
                          <option value="2021">2021</option>
                          <option value="2022">2022</option>
                          <option value="2023">2023</option>
                          <option value="2024">2024</option>
                          <option value="2025">2025</option>                          
                      </select>
                      </td>
                    </tr>
                       </tr>
                    
                     
                        <tr><td class="text-right" colspan="2"><button name="finddata">Simpan</button></td></tr>
                     </table>
                   </form>
            
               </div>
           </div>
              </div>

         </div>
      </div>
   </div>
</div>