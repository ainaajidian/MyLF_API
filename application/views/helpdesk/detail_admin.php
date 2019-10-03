<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
         
                <div class="card">
              <div class="card-header">
                <h3 class="card-title"></h3>
                <br>
                <a href="<?=base_url();?>Helpdesk/index"><button>Kembali</button></a>
              </div>
              	<div class="card-body">
	              <div class="table-responsive">
	           
                <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <!-- DIRECT CHAT PRIMARY -->
            <div class="card card-primary card-outline direct-chat direct-chat-primary">
              <div class="card-header">

              </div>
              <div class="card-body">
                <div class="direct-chat-messages">

                  <?php
                  foreach ($list as $key) {
                      if($user == $key->penanya) { ?>
                      <div class="direct-chat-msg right">
                          <span class="direct-chat-name float-right"><?php if($user == $key->penanya) { echo "Saya"; }else{echo "User";}?></span>
                          <span class="direct-chat-timestamp float-left"><?=$key->createddate;?></span>
                        <div class="direct-chat-text">
                        <?=$key->konten;?>
                        </div>
                      </div>

                      <?php }else{ ?>

                     <div class="direct-chat-msg">
                        <span class="direct-chat-name float-left"><?php if($user == $key->penanya) { echo "Saya";}else{echo "User";}?></span>
                        <span class="direct-chat-timestamp float-right"><?=$key->createddate;?></span>
                      <div class="direct-chat-text">
                        <?=$key->konten;?>
                      </div>
                    </div>

                      <?php } ?>


                   <?php   
                      }
                  ?>

          

                  <!-- /.direct-chat-msg -->
                </div>
                <!--/.direct-chat-messages-->

                <?php 
                    $last = $this->uri->total_segments();
                    $record_num = $this->uri->segment($last);
                ?>

           <form method="POST" action="<?=base_url();?>Helpdesk/savebalasan/<?=$record_num;?>">
              <!-- /.card-body -->
              <div class="card-footer">
                <form action="#" method="post">
                  <div class="input-group">
                    <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                    <span class="input-group-append">
                      <button type="submit" class="btn btn-primary">Kirim</button>
                    </span>
                  </div>
                </form>
              </div>
            </form>
              <!-- /.card-footer-->
            </div>
            <!--/.direct-chat -->
          </div>
              
                </div>

	             </div>
	         </div>
          		</div>

         </div>
      </div>
   </div>
</div>


