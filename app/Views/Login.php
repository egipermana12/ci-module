<?=$this->extend('layout')?>
<?=$this->section('content')?>
<div class="col-md-6 d-flex flex-column align-items-center justify-content-center bg-primary">
    Tagline
</div>
<div class="row col-md-6 d-flex flex-column align-items-center justify-content-center text-light">
    <div class="card-container" <?=@$style?>>
        <div class="text-center card-header transparent-header mb-2 text-black">
            <div class="logo">
                <img src="<?php echo $config->baseURL . 'images/' . $settingAplikasi['logo_login']?>">
            </div>
            <?= $login; ?>
        </div>
        <?php
            // print_r($currentModule);
        if (!empty($message)) {?>
            <div class="alert alert-danger">
                <?=$message?>
            </div>
        <?php }
            //echo password_hash('admin', PASSWORD_DEFAULT);
        ?>
        <form method="post" action="">
            <?= csrf_field(); ?>
            <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1">
                  <i class="fa fa-user"></i>
              </span>
              <input type="text" name="username" value="<?=@$_POST['username']?>" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
          </div>

          <div class="input-group mb-3 show_hide">
              <span class="input-group-text" id="basic-addon1">
                  <i class="fa fa-lock"></i>
              </span>
              <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1">
              <span class="input-group-text password__toggle" id="icon">
                  <i class="fa fa-eye-slash" id="toggle_password"></i>
              </span>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" value="1" id="rememberme">
            <label class="form-check-label text-secondary-emphasis" for="rememberme" style="font-weight:normal">Remember me</label>
        </div>

        <div class="mt-3 mb-2">
         <button type="submit" class="form-control btn <?=$settingAplikasi['btn_login']?>">Submit</button>
     </div>
 </form>

 <div class="mt-4 bg-light text-secondary-emphasis text-center py-3">
    <p>Lupa password? <a class="link-danger fw-semibold" href="<?=$config->baseURL?>recovery">Request reset password</a></p>
    <?php if($settingRegistrasi['enable'] == 'Y') { ?>
        <p>Belum punya akun? <a class="link-danger fw-semibold" href="<?=$config->baseURL?>recovery">Daftar Akun</a></p>
    <?php } ?>
    <p>Tidak menerima link aktivasi? <a class="link-danger fw-semibold" href="<?=$config->baseURL?>recovery">Kirim ulang</a></p>
</div>
</div>
</div>
<?=$this->endSection()?>
