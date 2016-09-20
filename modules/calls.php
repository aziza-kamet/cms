<form action="?act=addCallsManager" method="POST">  
  <div class="container-fluid">
  <div class="row">
  	<div class="col-md-1"></div>
  	<div class="col-md-10">
        <div class="panel panel-default" id="main_body">
          <div class="panel-body">
            <div class="row">
              <div class="form-horizontal">
              <!--Client ID-->
                <div class="form-group">
                  <label class="col-sm-2 control-label">
                    Client Name:
                  </label>
                  <div class="col-sm-7">
                    <select class="form-control" name="client_id">
                        <?php
                            $clients = getClients($_SESSION['user']->company_id);
                            foreach ($clients as $idRow => $row) {
                              echo  "<option value=$idRow>".$row['name']."</option>";
                            }
                        ?>
                    </select>
                  </div>
                </div>
                 <!--Manager type-->
                <div class="form-group">
                  <label class="col-sm-2 control-label">
                    Manager name:
                  </label>
                  <div class="col-sm-7">
                    <select class="form-control" name="manager_id">
                    <?php 
                      $companies = getManagers($_SESSION['user']->company_id);
                      foreach($companies as $idRow=>$row){
                        echo "<option value=$idRow>".$row['login']."</option>";
                      }
                    ?>
                    </select>
                </div>
    
                <!--CheckBox-->
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="rejected" id="checkB" onclick="clickB()">
                          Rejected
                        </input>
                      </label>
                    </div>
                  </div>
                </div>
                   <!--Reason-->
                <div class="form-group" id="textDisabled">
                  <label class="col-sm-2 control-label">
                    Reason:
                  </label>
                  <div class="col-sm-7">
                    <textarea class="form-control" rows="3" name="reason"></textarea>
                  </div>
                </div>
                  <!--button-->
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-default">Add</button>
                    </div>
                  </div>
              </div>
          </div>
        </div> 
  	</div>
  	<div class="col-md-1"></div>
  </div>
</form>

<script>
  $("#textDisabled").hide();
  function clickB(){
   x = $("#checkB").prop('checked');
    if(x){
        $("#textDisabled").show();      
    }else{
        $("#textDisabled").hide(); 
    }
  }
</script>