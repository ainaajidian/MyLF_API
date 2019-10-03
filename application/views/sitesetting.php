
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="row">
               <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 mx-auto toppad" >
                  <div class="panel panel-info">
                     <div class="panel-heading">
                        <h3 class="panel-title">Site Configuration</h3>
                     </div>
                     <div class="panel-body">
                        <form action="<?=base_url();?>Sitesetting/save_setting" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

                        <div class="row">
                           <div class=" col-md-9 col-lg-9 ">
                              <table class="table table-user-information">
                                 <tbody>
                                    <tr>
                                       <td>Site Name</td>
                                       <td><input type="text" class="form-control" value="<?=$sitesetting->value;?>" name="sitename"></td>
                                    </tr>

                                    <tr>
                                       <td>Sidebar Logo</td>
                                       <td><input type="file" name="sidebarlogo"></td>
                                    </tr>

                                    <tr>
                                       <td>Site Favicon</td>
                                       <td><input type="file" name="Favicon"></td>
                                    </tr>
                                 
                                 </tbody>
                              </table>
                              <button class="btn btn-success float-right">Update Site Setting</a>
                           </div>
                        </div>
                     </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>