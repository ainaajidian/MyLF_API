<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.css"/>

  <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.js"></script>
</head>

<body class="hold-transition sidebar-mini">
<!-- Main content -->
  <section class="content">
      <div class="col-md-12">
        <div class="card card-outline card-info">
          <!-- /.card-header --> 
          <div class="card-body pad">
            <form method="POST" action="<?=base_url();?>Message/saveMessage" enctype='multipart/form-data' >
              
              <div class="input-group mb-3">
                <select class="form-control" id="userId" name="userId">
                <option value="" disabled selected>Select Member</option>
                <?php foreach ($member_module as $key) 
                { echo "<option value='".$key->userDeviceId.";".$key->userId."'> ".$key->userId." - ".$key->userFullname."  </option>"; } ?>
                </select>
              </div>

              <div class="input-group mb-3">
                <input autocomplete="off" required name="messageTitle" type="text" class="form-control" placeholder="Message Title ">
              </div> 

              <div class="mb-12">
                <textarea name="messageContent"></textarea>
              </div>

              <br>

              <div id="module_image_label" class="input-group mb-3">
                  <input id="messageImage"  name="messageImage" type="file" class="form-control" placeholder="Image message">
              </div>
              <div class="mb-12">
                <input class="btn btn-primary" type="Submit" name="submit" value="Submit"> 
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- /.col -->
  </section>
  <!-- /.content -->

<script>
  CKEDITOR.replace('messageContent');
</script>

<script>
  $('#userId').select2({
        trigger : 'change',
        width:'100%',
        placeholder: 'Select Member'
    });
</script>

</body>
</html>