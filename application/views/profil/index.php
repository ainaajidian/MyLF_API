
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="row">
               <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 mx-auto toppad" >
                  <div class="panel panel-info">
                     <div class="panel-heading">
                        <h3 class="panel-title"><?=$fullname;?></h3>
                     </div>
                     <div class="panel-body">
<!--                         <div class="row">
                           <div class="image-upload col-md-3 col-lg-3" style="margin-bottom: 10px" align="center"> 
                                <label for="file-input">
                                  <img width="150" height="150" alt="User Pic" src="<?=$pict;?>" class="img-circle img-responsive"> 
                                </label>                         
                                    <input id="file-input" type="file"/>
                            </div> -->

                           <div class=" col-md-9 col-lg-9 ">
                              <table class="table table-user-information">
                                 <tbody>
                                    <tr>
                                       <td>Username</td>
                                       <td><?=$username;?></td>
                                    </tr>
                                    <tr>
                                       <td>Email</td>
                                       <td><?=$email;?></td>
                                    </tr>
                                    <tr>
                                       <td>Date of Birth</td>
                                       <td><?=$dob;?></td>
                                    </tr>
                                    <tr>
                                       <td>Gender</td>
                                       <td><?=$gender;?></td>
                                    </tr>
                                    <tr>
                                       <td>Home Address</td>
                                       <td><?=$address;?></td>
                                    </tr>
                                    <tr>
                                       <td>Phone Number</td>
                                       <td><?=$telp;?>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                              <a href="#"  data-toggle="modal" data-target="#exampleModal" class="btn btn-success float-right">Edit Biodata</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Profil</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          
          <form id="profilForm" action="#" >
               <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                
                <div class="input-group mb-3">
                    <input autocomplete="off"  value="<?=$email;?>" required name="email" type="email" id="email" class="form-control" placeholder="Email">
                </div>   

                <div class="input-group mb-3">
                    <input autocomplete="off"  value="<?=$fullname;?>" required name="fullname" type="text" id="fullname" class="form-control" placeholder="Fullname">
                </div>   

                  <div class="input-group mb-3">
                    <input autocomplete="off" value="<?=$pob;?>"  required name="placeofbirth" type="text" id="placeofbirth" class="form-control" placeholder="Place Of Birth">
                </div>   

                <div class="input-group mb-3">
                    <input autocomplete="off"  value="<?=$dob;?>" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask required name="dateofbirth" type="text" id="dateofbirth" class="form-control" placeholder="Date Of Birth">
                </div>   

                <div class="input-group mb-3">
                    <input autocomplete="off"  value="<?=$telp;?>" required name="phone" type="text" id="phone" class="form-control" placeholder="Phone Number">
                </div>   

                <div class="input-group mb-3">
                    <textarea required name="address" type="text" id="address" class="form-control" placeholder="address"><?=$address;?></textarea>
                </div>  

                <div class="input-group mb-3">
                  <div class="form-check-inline">
                      <label class="form-check-label">
                        <input type="radio" value="1" <?php if($_SESSION['gender'] == 1) { echo "checked";}?> class="form-check-input" name="gender">Male
                      </label>
                    </div>
                    <div class="form-check-inline">
                      <label class="form-check-label">
                        <input type="radio" value="2" <?php if($_SESSION['gender'] == 2) { echo "checked";}?> class="form-check-input" name="gender">Female
                      </label>
                    </div>
                </div>   

          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="updateProfil" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>