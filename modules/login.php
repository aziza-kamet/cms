<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
    <?php
      if(isset($_GET['err'])){
        if($_GET['err'] == "blocked"){
          $errorMsg = "This account has been blocked";
        } else if($_GET['err']=="incorrect_login_pwd"){
            $errorMsg = "Incorrect login or password";
        } else if($_GET['err']=="empty_fields"){
            $errorMsg = "Fields are empty";
        }
    ?>
    <div class="alert alert-danger">
      <?php
        echo $errorMsg;
      ?>
    </div>
    <?php
      }
    ?>
  <form class="form-horizontal" method="POST" action="?act=login">
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-2 control-label" >Login</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="inputEmail3" placeholder="Login" name="login">
      </div>
    </div>
    <div class="form-group">
      <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
      <div class="col-sm-10">
        <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="pwd">
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Sign in</button>
      </div>
    </div>
  </form>
    </div>
    <div class="col-sm-3"></div>
</div>
