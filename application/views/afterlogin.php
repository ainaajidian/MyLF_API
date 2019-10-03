<!doctype html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="<?=base_url();?>node_modules/admin-lte/dist/css/adminlte.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
      <title>Member LF</title>
      <style type="text/css">
         body{
         background: #393f4d
         }
         .vertical-center {
         min-height: 60%;
         min-height: 60vh;
         justify-content: center;
         display: flex;
         align-items: center;
         }
         .imgIcon{
           min-height: 100px;
           max-width: 100px;
           justify-content: center;
           display: flex;
           background-color: rgba(255, 255, 255, 0.5);
           align-items: center;
           margin: 5px 5px 5px 5px;
           cursor: pointer;
           background:#feda6a
         }
         .welcomePagetitle{
            margin-top: 15%;
            justify-content: center;
            display: flex;
            align-items: center;
            color:#feda6a
         }
         .welcomePagefooter{
           justify-content: center;
            display: flex;
            align-items: center;
            color:#feda6a
         }
      </style>
   </head>
   <body>
      <div class="container">
         <div class="welcomePagetitle"> 
             <h3> Welcome, </h3>
          </div>
         <div class="vertical-center">
            <?php 
               foreach ($module as $key) 
                { ?> <a href="<?=base_url();?>Loginform/mainPage/<?php echo $key->module_id;?>" data-toggle="tooltip" data-placement="top" title="<?=$key->module_name;?>" class="col-md-2 imgIcon">
            <img src="<?=base_url();?>assets/icon/<?=$key->module_icon;?>"></i>  </a>
            <?php
               }
               ?>
         </div>

<div class="welcomePagefooter"> 
             <small>  &copy;  2018 Boby Kurniawan. All rights reserved. </small>
          </div>

      </div>
      <script src="<?=base_url();?>node_modules/admin-lte/plugins/jquery/jquery.min.js"></script>
      <script src="<?=base_url();?>node_modules/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script type="text/javascript">
         $(function () {
         $('[data-toggle="tooltip"]').tooltip()
         })
         $(document).ready(function(){
             $(".imgIcon").mouseenter(function(){
                 $(this).addClass("bounceIn");
             }).mouseleave(function() {
                 $(this).removeClass("bounceIn");
             });
         });
         
      </script>
   </body>
</html>