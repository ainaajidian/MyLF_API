
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
         
                <div class="card">
              <div class="card-header">
                <h3 class="card-title">DETAIL Matriks</h3>
                <br>
                <a href="<?=base_url();?>Matriks/"><button>Kembali</button></a>
              </div>
              	<div class="card-body">
	              <div class="table-responsive">
	                   <table class="table">
                        <tr><td>Kabupaten</td><td><?=$info->namakabupaten;?></td></tr>
                        <tr><td>Kecamatan</td> <td><?=$info->namakecamatan;?></td></tr>
                        <tr><td>Desa</td><td><?=$info->namadesa;?></td></tr>
                        <tr><td>Bantuan</td><td><?=$info->NamaBantuan;?></td></tr>
                        <tr><td>Status</td><td>
                           
                        <?php if($info->status != 1){
                              echo "<p class='alert-danger col-md-1'> &nbsp; </p>";
                           } else{
                               echo "<p class='alert-success col-md-1'> &nbsp; </p>";
                           }?>

                         </td></tr>
                     </table>
                      <br>
                      <h3 class="card-title">Dokumen</h3>
                      <br>
<table class="table">
      <tr><td>Rab</td>
        <td>
    
            <?php if($info->RAB != ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->RAB;?>"> Lihat Dokumen </a>
            <?php } ?>
    
        </td>

      </tr>
      
      <tr><td>Analisa Harga Satuan</td>  
        <td>
  
            <?php if($info->AnalisaHargaSatuan != ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->AnalisaHargaSatuan;?>"> Lihat Dokumen </a>
            <?php } ?>
    
        </td>
      </tr>
      <tr>
        <td>Harga Satuan Kab. (ttd bupati)</td>
        <td>
        
            <?php if($info->HargaSatuan != ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->HargaSatuan;?>"> Lihat Dokumen </a>
            <?php } ?>
         
        </td>
      </tr>
      <tr><td>Desain Gambar</td>
          <td>
        
            <?php if($info->GambarDesign != ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->GambarDesign;?>"> Lihat Dokumen </a>
            <?php } ?>
         
        </td>
      </tr>
      <tr><td>Spek Tek</td>
    <td>
           
            <?php if($info->SpekTek != ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->SpekTek;?>"> Lihat Dokumen </a>
            <?php } ?>
    
        </td>

      </tr>
      <tr><td>Surat Usulan</td>
            <td>
          
            <?php if($info->SuratUsulan != ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->SuratUsulan;?>"> Lihat Dokumen </a>
            <?php } ?>
    
        </td>
      </tr>
      <tr><td>Surat Lokasi Tak Bermasalah</td>
 <td>
        
            <?php if($info->SuratLokasi != ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->SuratLokasi;?>"> Lihat Dokumen </a>
            <?php } ?>
      
        </td>
      </tr>
      <tr><td>Surat Data Calon Penerima Hibah</td>
 <td>
          
            <?php if($info->SuratData != ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->SuratData;?>"> Lihat Dokumen </a>
            <?php } ?>
          
        </td>

      </tr>
      <tr><td>Surat Pernyataan Keadilan Penerima Hibah</td>
           <td>
          
            <?php if($info->SuratPernyataan != ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->SuratPernyataan;?>"> Lihat Dokumen </a>
            <?php } ?>
          
        </td>

      </tr>
      <tr><td>Titik Kordinat</td>

    <td>
       
            <?php if($info->TitikKordinat != ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->TitikKordinat;?>"> Lihat Dokumen </a>
            <?php } ?>
        
        </td>

      </tr>
      <tr><td>SK Lokasi</td>

    <td>
          
            <?php if($info->SKLokasi != ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->SKLokasi;?>"> Lihat Dokumen </a>
            <?php } ?>
         
        </td>

      </tr>
      <tr><td>SK TIM  Pengendali</td>

    <td>
         
            <?php if($info->SKTim != ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->SKTim;?>"> Lihat Dokumen </a>
            <?php } ?>
         
        </td>


      </tr>

</table>
	             </div>
	         </div>
          		</div>

         </div>
      </div>
   </div>
</div>