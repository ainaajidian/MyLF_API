  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=base_url();?>" class="brand-link">
      <img src="<?=base_url();?>assets/icon/<?=$sidebar->value;?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light"> <?=$sitesetting->value;?> </span>
    </a>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">

        <div class="info">
          <a href="#" class="d-block"><?=$fullname;?> <br> <?=$usertypedesc;?> <?=$loginid;?> </a> 
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         
      <?php foreach ($menu as $key) 
      { ?>
        <li class="nav-item">
          <a href="<?=base_url();?><?=$key->module_path;?>" class="nav-link">
            <i class="nav-icon <?=$key->module_icon;?>"></i>
              <p> <?=$key->module_name;?> </p>
          </a>
        </li>
      <?php } ?>

         
         <li class="nav-header"> </li>
            <li class="nav-item">
              <a href="<?=base_url();?>Loginform/goToportal" class="nav-link">
                <i class="nav-icon fas fa-undo-alt"></i>
                <p>
                  Back to menu category
                </p>
              </a>
            </li>

   

            <li class="nav-item">
              <a href="<?=base_url();?>welcome/logout" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>
                  Logout
                </p>
              </a>
            </li>

        </ul>
      </nav>
    </div>
  </aside>