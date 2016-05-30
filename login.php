<?php include_once('inc/page_header.php'); ?>

<h2>KSU株式会社</h2>
<form class="form-horizontal" action="auth.php" method="post">
  <div class="form-group has-warning">
    <div class="col-sm-12"><input type="text" id="vs1" name="user" class="form-control" placeholder="ユーザID">
    </div>
  </div>
   <div class="form-group has-success">
    <div class="col-sm-12"><input type="password" id="vs2" name="pass" class="form-control" placeholder="パスワード">
    </div>
  </div>
  <div class="form-group has-error">
    <div class="col-sm-12"><input class="btn btn-success btn-block" type="submit" value="ログイン">
    </div>
  </div>
</form>
<?php include_once('inc/page_footer.php'); ?>
