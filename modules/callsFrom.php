<form action="?act=addCallFrom" method="POST">
<div class="form-group">
    <label class="control-label col-sm-2" for="email">Search client:</label>
    <div class="col-sm-10">
        <select class="form-control" name="client_id" id="selectClients">
            <?php
            $clients = getClients($_SESSION['user']->company_id);
            echo "<option class='show' value='noName'>No name</option>";
            foreach ($clients as $idRow => $row) {
              echo  "<option class='hideThis' value=$idRow>".$row['name']."</option>";
            }
            ?>
        </select>
    </div>   
</div>
<div id="notExist">
    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Name:</label>
      <div class="col-sm-10">
        <input class="form-control" name="name">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd" >Surname:</label>
      <div class="col-sm-10"> 
        <input class="form-control" name="surname">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd" >Phone:</label>
      <div class="col-sm-10"> 
        <input class="form-control" name="phone">
      </div>
    </div>
</div>
<div class="form-group">
  <label class="control-label col-sm-2" for="pwd" >Reason:</label>
  <div class="col-sm-10"> 
    <input class="form-control" name="reason">
  </div>
</div>
<div class="form-group">
  <label class="control-label col-sm-2" for="pwd" >Result:</label>
  <div class="col-sm-10"> 
    <input class="form-control" name="result">
  </div>
</div>
<div class="form-group"> 
  <div class="col-sm-offset-2 col-sm-10">
    <button type="submit" class="btn btn-default">Submit</button>
  </div>
</div>
<script>/*
$(document).ready(function(){
    $("#hide").click(function(){
        $("#notExist").hide();
    });
    $("#show").click(function(){
        $("#notExist").show();
    });
});*/

  $('#selectClients').change(function(){ 
      var value = $(this).val();
      if(value>0){
        changeLabels();
      }else{
        changeSecondLabels();
      }
  });
  
    function changeLabels(){
      $("#notExist").hide();
    }
    
    function changeSecondLabels(){
      $("#notExist").show();
    }
</script>
</form>