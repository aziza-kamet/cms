<form meta="POST">
  <table id = 'goods_table' class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>#</th>
        <th>login</th>
        <th>password</th>
        <th>type</th>
        <th>active</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        $companies = getManagers($_SESSION['user']->company_id);
        foreach($companies as $idRow=>$row){
          echo "<tr  id='row$idRow' onclick='rowSelected($idRow)'>";
          echo "<td>$idRow</td>";
          echo "<td>".$row['login']."</td>";
          echo "<td>".$row['password']."</td>";
          echo "<td>".$row['type']."</td>";
          echo "<td>".$row['active']."</td>";
          echo "</tr>";
        }
      ?>
    </tbody>
  </table>
</form>

	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addManager">add</button>
	<button id="editButton" type="button" class="btn btn-primary" data-toggle="modal" data-target="#editManager" disabled>edit</button>
  <button type="button" class="btn btn-danger" id="deleteButton">delete</button>
   <button type="button" class="btn btn-primary" id="blockButton">block</button>
<div class="modal fade" id="addManager" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
       <form action="?act=add_manager" method="POST" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Manager</h4>
      </div>
      <div class="modal-body">
         
             <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Login</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="login" id="addLogin">
                </div>
              </div>
               <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" name="password" id="addPassword">
                </div>
              </div>
               <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Re-password</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" name="repassword" id="addRepassword">
                </div>
              </div>
               <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Type</label>
                <div class="col-sm-10">
                 <select class="form-control" id="addType" name="type">
                   <option value="sales manager">Sales manager</option>
                   <option value="tech support manager">Tech support manager</option>
                   <option value="quality manager">Quality manager</option>
                   <option value="calls manager">Calls manager</option>
                  </select>
                </div>
              </div>
      </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" <?php echo "onclick='addManager(".$_SESSION['user']->company_id.")'";?>>Add</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editManager" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
       <form action="?act=edit_manager" method="POST" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Manager</h4>
      </div>
      <div class="modal-body">
         
             <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Login</label>
                <div class="col-sm-10">
                  <input id="editLogin" type="text" class="form-control" name="login" id="editLogin">
                </div>
              </div>
               <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" name="password" id="editPassword">
                </div>
              </div>
               <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Re-password</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" name="repassword" id="editRepassword">
                </div>
              </div>
               <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Type</label>
                <div class="col-sm-10">
                   <select class="form-control" id="editType" name="type">
                   <option value="sales manager">Sales manager</option>
                   <option value="tech support manager">Tech support manager</option>
                   <option value="quality manager">Quality manager</option>
                   <option value="calls manager">Calls manager</option>
                  </select>
                </div>
              </div>
      </div>
       </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="editManager()">Edit</button>
      </div>
    </div>
  </div>
</div>

<script>
  var rowId = -1;
  function rowSelected(id){
    rowId = id;
    if(rowId!=-1){
      $('#goods_table tr').css('background', '');
      $("#editButton").prop("disabled", false);
      $("#row"+rowId).hover(function(){
      $("#row"+rowId).css("background", "#FFFAFA");
      },
      function(){
        $("#row"+rowId).css("background", "#DCDCDC");
      });
      
      changeBlockButton();
      
      jQuery.ajax({
        url: "ajax.php",
        data: "req=getManagers&id="+rowId,
        type: "GET",
        success: function(data){
          var result = jQuery.parseJSON(data);
          $("#editLogin").val(result['login']);
          $("#editPwd").val(result['password']);
          $("#editRePwd").val(result['repassword']);
          $("#editType").val(result['type']);
        },
        error: function(data, smth, error){
          alert(data.responseText + "\n" + smth + "\n" + error);
        }
      });
    }
  }
  
  function addManager(company_id){
    var data = {};
    data['company_id'] = company_id;
    data['login'] = $("#addLogin").val();
    data['password'] = $("#addPassword").val();
    data['repassword'] = $("#addRepassword").val();
    data['type'] = $("#addType").val();
    data['active'] = 1;
    
    jQuery.ajax({
      url: "ajax.php",
      data: "act=addMan&arr=" + JSON.stringify(data),
      type: "POST",
      success: function(data){
        $("tbody").html(data);
        $("#addManager").modal("hide");
      }
    });
  }
  
  function editManager(){
    var data = {};
    data["id"] = rowId;
    data['login'] = $("#editLogin").val();
    data['password'] = $("#editPassword").val();
    data['repassword'] = $("#editRepassword").val();
    data['type'] = $("#editType").val();
    
    jQuery.ajax({
      url: "ajax.php",
      data: "act=editMan&arr=" + JSON.stringify(data),
      type: "POST",
      success: function(data){
        var result = jQuery.parseJSON(data);
        $("#row" + rowId + " td:nth-child(2)").html(result["login"]);
        $("#row" + rowId + " td:nth-child(3)").html(result["password"]);
        $("#row" + rowId + " td:nth-child(4)").html(result["type"]);
        $("#editManager").modal("hide");
      },
      error: function(xh, text, error){
        alert(error);
      }
    });
  }
  
  var compId = <?php echo $_SESSION['user']->company_id; ?>;
  $("#deleteButton").click(function(){
    deleteMan(rowId,compId);
  });
  
  function deleteMan(manId,companyId){
    jQuery.ajax({
      url: "ajax.php",
      data: "act=deleteMan&manId=" + manId+"&compId="+companyId,
      type: "POST",
      success: function(data){
        $("tbody").html(data);
      }
    });
  }
  $("#blockButton").click(function(){
    if($("#blockButton").html() == "block"){
      blockMan(rowId,compId);
    }else{
      unblockMan(rowId, compId);
    }
  });
  
  function blockMan(manId, companyId){
    jQuery.ajax({
      url: "ajax.php",
      data: "act=blockMan&manId=" + manId+"&compId="+companyId,
      type: "POST",
      success: function(data){
        $("tbody").html(data);
      }
    });
  }
  
  function unblockMan(manId, companyId){
    jQuery.ajax({
      url: "ajax.php",
      data: "act=unblockMan&manId=" + manId+"&compId="+companyId,
      type: "POST",
      success: function(data){
        $("tbody").html(data);
      }
    });
  }
  
  function changeBlockButton(){
    var active =  $("#row" + rowId + " td:nth-child(5)").html();
    if(active==1){
      $("#blockButton").html("block");
    }else{
      $("#blockButton").html("unblock");
    }
  }
  
</script>