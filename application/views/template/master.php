<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?=$sitesetting->value;?></title>
  <link rel="shortcut icon" type="image/png" href="<?=base_url();?>assets/icon/<?=$favicon->value;?>">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">



  <link rel="stylesheet" href="<?=base_url();?>node_modules/admin-lte/dist/css/adminlte.min.css">
    <?php
      if(isset($includecss))
        { echo $includecss; }
    ?>

    <!-- <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script> -->

  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style type="text/css">
.image-upload > input
{
    display: none;
}

.image-upload img
{
    cursor: pointer;

}

</style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
    </ul>
<?php // $this->load->view("template/notification");?>
  </nav>
<?php $this->load->view("template/sidebar");?>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    
   <?php $this->load->view($view,true);?>
  </div>

  <footer class="main-footer">
    <!-- <div class="float-right d-none d-sm-inline">
      Anything you want
    </div> -->
    <strong>Copyright &copy; 2014-2018 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>


<script src="<?=base_url();?>node_modules/admin-lte/plugins/jquery/jquery.min.js"></script>
<script src="<?=base_url();?>node_modules/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?=base_url();?>node_modules/admin-lte/dist/js/adminlte.min.js"></script>
<script src="<?=base_url();?>node_modules/admin-lte/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?=base_url();?>node_modules/admin-lte/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?=base_url();?>node_modules/admin-lte/plugins/input-mask/jquery.inputmask.extensions.js"></script>


<?php
  if(isset($includejs)){
    echo $includejs;
  }
?>



<script type="text/javascript">
  
$(document).ready(function(){
    $('#dateofbirth').inputmask('yyyy/mm/dd', { 'placeholder': 'yyyy/mm/dd' })

    $("#updateProfil").click(function(){
        var str = $( "#profilForm" ).serialize();  
          $.ajax({
            type: "POST",
            url: "<?=base_url();?>profil/update",
            data: str,
            success: function(data) {
              console.log(data);
              location.reload();
            },
            error: function(e) {
              console.log();
                if(!alert('Whoops something wrong, please try again...')){window.location.reload();}

            }
        });
     });

});



</script>
<?php
  if(isset($customjs))
    { $this->load->view($customjs); }
?>



</body>
</html>
