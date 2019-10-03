
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?=base_url();?>node_modules/admin-lte/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?=base_url();?>node_modules/admin-lte/plugins/iCheck/square/blue.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><?=$sitesetting->value;?></a>
  </div>
  <!-- /.login-logo -->
    <div class="row">
            <div class="alert-danger mx-auto text-center"> <?=$this->session->flashdata('message');?> </div>
      </div>
<hr>

  <div class="card">

    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form id="loginForm" action="<?=base_url();?>loginform/proses" method="post">
        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

            <div class="usernameError"></div>
        <div class="input-group mb-3">
          <input autocomplete="off" required name="username" type="text" class="form-control" id="username" placeholder="Username">
          <div class="input-group-append">
              <span class="fa fa-user input-group-text"></span>
          </div>
        </div>
      
        <div class="passwordError"></div>
        <div class="input-group mb-3">
          <input required name="password" type="password" id="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
              <span class="fa fa-lock input-group-text"></span>
          </div>
        </div>

        <div class="row">
          <div class="col-8">
            <div class="checkbox icheck">
              <label>
                <input type="checkbox"> Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat goSubmit">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
 
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="#">I forgot my password</a>
      </p>
    
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?=base_url();?>node_modules/admin-lte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url();?>node_modules/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- iCheck -->
<script src="<?=base_url();?>node_modules/admin-lte/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass   : 'iradio_square-blue',
      increaseArea : '20%' // optional
    })

    $("#username").click(function(){
      if($(this).hasClass("alert-danger")){
          $(this).removeClass("alert-danger");
            $(".usernameError").text("");
      }
    });

     $("#password").click(function(){
      if($(this).hasClass("alert-danger")){
          $(this).removeClass("alert-danger");
            $(".passwordError").text("");
      }
    });

    $(".goSubmit").click(function(e){
        e.preventDefault();
        if(!validateUsername()){ return false; }
        if(!validatePassword()){ return false; }
        $("#loginForm").submit();

    });

  })

  function validateUsername(){
     if($.trim($('#username').val()) == ''){
        $('#username').addClass("alert-danger");
        $(".usernameError").text("Please provide your username");
        return false;
     }
     return true;

  }

  function validatePassword(){
    if($.trim($('#password').val()) == ''){
        $('#password').addClass("alert-danger");
        $(".passwordError").text("Please provide your password");
        return false;
     }
     return true;

  }


</script>
</body>
</html>
