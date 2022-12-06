
<div id="main">
    <div id="content">
      <div class="box">
        <div class="head">
        </div>
        <div>
        <form method="post" action="<?=URL.'/home/login'?>" class="w-50 m-auto">
        <?=isset($data['error']) ? '<div class="alert alert-danger mx-auto" role="alert">'.$data['error'].'</div>' : ''?>
        <?=isset($data['message']) ? '<div class="alert alert-success mx-auto" role="alert">'.$data['message'].'</div>' : ''?>
        <div class="text-center"><h5 class="mb-3 text-light">Login</h5></div>
        <div class="mb-2">
          <label for="email" class="form-label text-light">Email</label>
  <input type="email" class="form-control" id="email" name="email" required>
</div>
<div class="mb-3">
  <label for="password" class="form-label text-light">Password</label>
  <input type="password" class="form-control" id="password" name="password" required>
</div>
<button type="submit" class="btn btn-primary mb-3 w-25">Login</button>
          </form>
        </div>
        <div class="cl">&nbsp;</div>
      </div>
    </div>
    <div class="cl">&nbsp;</div>
  </div>
