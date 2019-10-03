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
	           <div class="col-md-6">
                   <form enctype="multipart/form-data" id="moduleForm" action="<?=base_url();?>Helpdesk/saveHeader" method = "POST" >

                      <div class="form-group">
                          <label>Subjek</label>
                           <input type="text" class="form-control" name="subjek">          
                      </div>  

                      <div class="form-group">
                          <label>Pertanyaan</label>
                          <textarea class="form-control" name="pertanyaan"></textarea>         
                      </div>  

                
                         
                       <button type="submit"  class="btn btn-primary">Kirim Pertanyaan</button>
                </form>
</div>

	             </div>
	         </div>
          		</div>

         </div>
      </div>
   </div>
</div>


