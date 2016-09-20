<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
      <?php
      if(isset($_GET['err'])){
        if($_GET['err'] == "pwd_mismatch"){
          $errorMsg = "Password mismatch";
        } else if($_GET['err'] == "empty_fields"){
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
          <form class="form-horizontal" action="?act=reg" method="POST">
            <div class="form-group">
              <label for="companyName" class="col-sm-4 control-label">Company Name:</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="companyName" placeholder="Company Name" name="company_name">
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label" >Login:</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="login" placeholder="Login" name="login">
              </div>
            </div>
    <div class="form-group">
      <label for="inputPassword3" class="col-sm-4 control-label">Password:</label>
          <div class="col-sm-8">
            <input type="password" class="form-control" id="pwd" placeholder="Password" name="pwd">
          </div>
      </div>
    <div class="form-group">
      <label for="rePassword3" class="col-sm-4 control-label">Password confirm:</label>
      <div class="col-sm-8">
        <input type="password" class="form-control" id="rePwd" placeholder="Password confirm" name="re_pwd">
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" class="btn btn-default">Sign up</button>
      </div>
    </div>
    
  </form>
    </div>
    <div class="col-sm-3"></div>
</div>
