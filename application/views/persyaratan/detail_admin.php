
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
         
                <div class="card">
              <div class="card-header">
                <h3 class="card-title">Detail Persyaratan</h3>
                <br>
                <a href="<?=base_url();?>Persyaratan/"><button>Kembali</button></a>
              </div>
              	<div class="card-body">
	              <div class="table-responsive">
	                  <table class="table">
                        <tr><td>Kabupaten</td><td><?=$info->namakabupaten;?></td></tr>
                         <tr><td>Kecamatan</td><td><?=$info->kecamatan;?></td></tr>
                          <tr><td>Desa</td><td><?=$info->desa;?></td></tr>
                           <tr><td>Kegiatan</td><td><?=$info->kegiatan;?></td></tr>
                            <tr><td>Pagu</td><td><?=$info->pagu;?></td></tr>
                             <tr><td>Tahun</td><td><?=$info->tahun;?></td></tr>
                     </table>
                      <br>
                      <h3 class="card-title">Dokumen Persyaratan Administratif Proposal</h3>
                      <br>
	             </div>
               <table>
      <tr><td><b>1. Dokumen yang dipersiapkan pada Tingkat Kabupaten</td></tr>        
      <tr><td>1.1 SK Bupati tentang Persiapan Lokasi (Desa) Penerima Bantuan</td>
        <td>
            <?php if($info->SKBupDesa != ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->SKBupDesa;?>"> Lihat Dokumen </a>
            <?php } ?>
        </td>
      </tr>
      <tr><td>1.2 SK Bupati tentang penetapan SKPD penanggung jawab kegiatan</td>
        <td>
            <?php if($info->SKBupSKPD != ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->SKBupSKPD;?>"> Lihat Dokumen </a>
            <?php } ?>
          
        </td>
      </tr>
      <tr><td>1.3 Surat Pernyataan Bupati untuk menerima Hibah (Data Penerima Hibah)</td>
        <td>
            <?php if($info->DataPenerimaHibah != ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->DataPenerimaHibah;?>"> Lihat Dokumen </a>
            <?php } ?>
          
        </td>
      </tr>
      <tr><td>1.4 Surat Pernyataan Bupati Tidak Menganggarkan Kegiatan pada APBD maupun APBD-P</td>
        <td>
          
            <?php if($info->PernyataanTidakAPBD != ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->PernyataanTidakAPBD;?>"> Lihat Dokumen </a>
            <?php } ?>
          
        </td>
      </tr>
      <tr><td>1.5 Surat Pengantar Proposal yang ditujukan Kepada Menteri Desa PDTT Cq Dirjen PDT UP Direktur PSDLH</td>
        <td>
            <?php if($info->PengantarProposalPDTT != ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->PengantarProposalPDTT;?>"> Lihat Dokumen </a>
            <?php } ?>
        </td>
      </tr>
      <td><b>2. Dokumen yang dipersiapkan pada Tingkat OPD</td>
     <tr> <td>2.1 SK Pembentukan TIM :</td><tr>
      <tr><td>a. Tim Persiapan ( Minimal terdiri atas Ketua, Sekretaris, dan 1 anggota)</td>
        <td>
            <?php if($info->SKPemTimPersiapan != ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->SKPemTimPersiapan;?>"> Lihat Dokumen </a>
            <?php } ?>
        </td>
      </tr>
      <tr><td>b. Tim Pengawas ( Minimal terdiri atas Ketua, Sekretaris, dan 1 anggota)</td>
        <td>
          
            <?php if($info->SKPemTimPengawas != ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->SKPemTimPengawas;?>"> Lihat Dokumen </a>
            <?php } ?>
         
        </td>
      </tr>
      <tr><td>c. Tim Pengendali ( Minimal terdiri atas Ketua, Sekretaris, dan 1 anggota)</td>
        <td>
          
            <?php if($info->SKPemTimPengendali != ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->SKPemTimPengendali;?>"> Lihat Dokumen </a>
            <?php } ?>
         
        </td>
      </tr>
      <tr><td><b>3. Dokumen yang dipersiapkan pada Tingkat Desa</td></tr> 
      <tr><td>3.1 SK/Pengukuhan Kelompok Masyarakat Penerima Bantuan</td>
        <td>
          
            <?php if($info->SKKelMasPenBantuan != ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->SKKelMasPenBantuan;?>"> Lihat Dokumen </a>
            <?php } ?>
          
        </td>
      </tr>
      <tr><td>3.2 Surat Pernyataan Lahan Tidak Bermasalah (bila bermasalah makan harus dibuatkan berita acara(BA) serah terima/pengalihan lahan ke desa) bermaterai</td>
        <td>
          
            <?php if($info->SuratPernyataanTidakBermasalah != ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->SuratPernyataanTidakBermasalah;?>"> Lihat Dokumen </a>
            <?php } ?>
          
        </td>
      </tr>
      <tr><td>3.3 Surat Himbauan melibatkan BUMDes dalam pengelolaan bantuan</td>
        <td>
         
            <?php if($info->HimbauanBUMDes != ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->HimbauanBUMDes;?>"> Lihat Dokumen </a>
            <?php } ?>
         
        </td>
      </tr>
      <tr><td>3.3 Surat Pernyataan Kesediaan Melibatkan Masyarakat Desa</td>
        <td>
          
            <?php if($info->MelibatkanMasyarakatDesa!= ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->MelibatkanMasyarakatDesa;?>"> Lihat Dokumen </a>
            <?php } ?>
          
        </td>
      </tr>
      <tr><td><b>4. Dokumen yang dipersiapkan pada Tingkat Kelompok Masyarakat</td></tr>
      <tr><td>4.1 Penetapan Nama Kelompok Penerima</td>
        <td>
          
            
            <?php if($info->NamaKelPenerima!= ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->NamaKelPenerima;?>"> Lihat Dokumen </a>
            <?php } ?>
          
        </td>
      </tr>
      <tr><td>4.2 Struktur Organisasi Kelompok Peserta AD/ART Kelompok</td>
        <td>
          
            <?php if($info->StrukturOrganisasi!= ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->StrukturOrganisasi;?>"> Lihat Dokumen </a>
            <?php } ?>
          
        </td>
      </tr>
      <tr><td>4.3 Mencantumkan Alamat Jelas Sekretariat Kelompok berserta Nomor Telepon yang dapat dihubungi</td>
        <td>
          
            <?php if($info->AlamatJelas!= ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->AlamatJelas;?>"> Lihat Dokumen </a>
            <?php } ?>
          
        </td>
      </tr>
      <tr><td>4.4 Melampirkan photocopy KTP anggota Kelompok</td>
        <td>
          
            <?php if($info->FotoCopyKTP!= ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->FotoCopyKTP;?>"> Lihat Dokumen </a>
            <?php } ?>
          
        </td>
      </tr>
      <tr><td>4.5 Rekening a/n Kelompok Masyarakat</td>
        <td>
          
            <?php if($info->RekeningKelompokMasyarakat!= ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->RekeningKelompokMasyarakat;?>"> Lihat Dokumen </a>
            <?php } ?>
          
        </td>
      </tr>
      <tr><td>4.6 Stempel/Cap Kelompok Masyarakat</td>
        <td>
          
            <?php if($info->StempelKelompokMasyarakat!= ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->StempelKelompokMasyarakat;?>"> Lihat Dokumen </a>
            <?php } ?>
          
        </td>
      </tr>
      <tr><td>4.7 Surat Pernyataan Kesediaan Menyelesaikan Laporan Pertanggungjawaban</td>
        <td>
          
            <?php if($info->LaporanPertanggungjawaban!= ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->LaporanPertanggungjawaban;?>"> Lihat Dokumen </a>
            <?php } ?>
         
        </td>
      </tr>
      <tr><td>4.8 Surat Pernyataan Kesediaan Bertanggungjawab melaksanakan dan menyelesaikan swakelola</td>
        <td>
          
            <?php if($info->MenyelesaikanSwakelola!= ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->MenyelesaikanSwakelola;?>"> Lihat Dokumen </a>
            <?php } ?>
        
        </td>
      </tr>
      <tr><td>4.9 Surat Pernyataan Pertanggungjawaban Mutlak (SPTJM) Bermaterai</td>
        <td>
          
            <?php if($info->SPTJM!= ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->SPTJM;?>"> Lihat Dokumen </a>
            <?php } ?>
        
        </td>
      </tr>
      <tr> <td>4.10 Ketua Kelompok Masyarakat Membentuk :</td><tr>
      <tr><td>a. Tim Persiapan ( Minimal terdiri atas Ketua, Sekretaris, dan 1 anggota)</td>
        <td>
         
            <?php if($info->TimPersiapanKelompokMas!= ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->TimPersiapanKelompokMas;?>"> Lihat Dokumen </a>
            <?php } ?>
          
        </td>
        </tr>
      <tr><td>b. Tim Pengawas ( Minimal terdiri atas Ketua, Sekretaris, dan 1 anggota)</td>>
        <td>
          
            <?php if($info->TimPengawasKelompokMas != ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->TimPengawasKelompokMas;?>"> Lihat Dokumen </a>
            <?php } ?>
          
        </td>
      </tr>
      <tr><td>c. Tim Pengendali ( Minimal terdiri atas Ketua, Sekretaris, dan 1 anggota)</td>
        <td>
          
            <?php if($info->TimPegendaliKelompokMas != ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->TimPegendaliKelompokMas;?>"> Lihat Dokumen </a>
            <?php } ?>
          
        </td>
      </tr>
      <tr> <td>4.11 Proposal (setelah halaman sampul melampirkan Surat Pengantar Bupati (poin 1.5) yang meliputi) :</td><tr>
      <tr><td>1. Latar belakang dan profil Daerah Lokasi Kabupaten dan Desa Penerima Bantuan</td>
        <td>
          
            <?php if($info->LatarBelakangKabDes!= ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->LatarBelakangKabDes;?>"> Lihat Dokumen </a>
            <?php } ?>
          
        </td></tr>
      <tr><td>2. Kerangka Acuan Kegiatan yang Meliputi :</td></tr>
      <tr><td> &nbsp &nbsp &nbsp &nbsp a. Dasar Hukum </td>
        <td>
          
            <?php if($info->DasarHukum!= ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->DasarHukum;?>"> Lihat Dokumen </a>
            <?php } ?>
          
        </td>
        </tr>
        <tr><td> &nbsp &nbsp &nbsp &nbsp b. Tujuan Kegiatan </td>
        <td>
          
            <?php if($info->Tujuan!= ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->Tujuan;?>"> Lihat Dokumen </a>
            <?php } ?>
         
        </td></tr>
        <tr><td> &nbsp &nbsp &nbsp &nbsp c. Penerima Manfaat </td>
        <td>
          
            <?php if($info->PenerimaManfaat!= ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->PenerimaManfaat;?>"> Lihat Dokumen </a>
            <?php } ?>
          
        </td></tr>
        <tr><td> &nbsp &nbsp &nbsp &nbsp d. Lokasi Pelaksanaan Kegiatan disertai titik koordinat dan Peta Desa </td>
        <td>
          
            <?php if($info->LokasiKoordinatPeta!= ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->LokasiKoordinatPeta;?>"> Lihat Dokumen </a>
            <?php } ?>
          
        </td></tr>
        <tr><td> &nbsp &nbsp &nbsp &nbsp e. Rincian Pelaksanaan/Strategi Pelaksanaan Kegiatan </td>
        <td>
          
            <?php if($info->StrategiPelaksanaan!= ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->StrategiPelaksanaan;?>"> Lihat Dokumen </a>
            <?php } ?>
         
        </td></tr>
        <tr><td> &nbsp &nbsp &nbsp &nbsp f. Rencana Jadwal Pelaksanaan </td>
        <td>
         
            <?php if($info->JadwalPelaksanaan!= ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->JadwalPelaksanaan;?>"> Lihat Dokumen </a>
            <?php } ?>
          
        </td></tr>
        <tr><td> &nbsp &nbsp &nbsp &nbsp g. Rincian Anggaran Biaya (RAB) <b>TANPA ADANYA BIAYA JASA KONSULASI DAN PAJAK </td>
        <td>
          
            <?php if($info->RAB!= ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->RAB;?>"> Lihat Dokumen </a>
            <?php } ?>
          
        </td>
        </tr>
        <tr><td> &nbsp &nbsp &nbsp &nbsp h. Gambar Teknis / Detail Engineering Design (DED) <b> TANPA ADANYA BIAYA JASA KOSULTASI DAN PAJAK </td>        <td>
         
            <?php if($info->DED!= ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->DED;?>"> Lihat Dokumen </a>
            <?php } ?>
          
        </td></tr>

        <tr><td> &nbsp &nbsp &nbsp &nbsp i. Analisa Biaya dan Harga (Berkas hardcopy dan menyerahkan softfile excell) </td>
        <td>
         
            <?php if($info->AnalisaBiaya!= ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->AnalisaBiaya;?>"> Lihat Dokumen </a>
            <?php } ?>
          
        </td></tr>
        <tr><td> &nbsp &nbsp &nbsp &nbsp j. Melampirkan dokumentasi foto lokasi pembangunan (0% perkerjaan konstruksi,sesuai titik pekerjaan konstriksi dan item menu pekerjaan)</td>
        <td>
          
            <?php if($info->DokFotoLokasi!= ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->DokFotoLokasi;?>"> Lihat Dokumen </a>
            <?php } ?>
         
        </td></tr>
        <tr><td> &nbsp &nbsp &nbsp &nbsp k. Melampirkan Standar Biaya Umum Daerah (SBUD) yang disahkan oleh Bupati </td>
        <td>
          
            <?php if($info->SBUD!= ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->SBUD;?>"> Lihat Dokumen </a>
            <?php } ?>
          
        </td></tr>
        <tr><td> &nbsp &nbsp &nbsp &nbsp l. Melampirkan Spesifikasi Teknis Pembangunan Konstruksi dari dinas terkait </td>
        <td>
          
            <?php if($info->SpesifikasiTeknis!= ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->SpesifikasiTeknis;?>"> Lihat Dokumen </a>
            <?php } ?>
          
        </td></tr>
        <tr><td><b>5. Persyaratan Pencarian Dana Bantuan Swakelola</td>
        <td>
          
            <?php if($info->PencarianDanaSwakelola != ""){ ?> 
            <a class="btn btn-success btn-sm" href="<?=base_url();?>assets/filepdf/<?=$info->PencarianDanaSwakelola;?>"> Lihat Dokumen </a>
            <?php } ?>
        
        </td>
      </table>
	         </div>
          		</div>

         </div>
      </div>
   </div>
</div>

