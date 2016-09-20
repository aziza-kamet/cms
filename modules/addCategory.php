
  <table id ='goods_table' class="table table-bordered table-hover" style= "overflow: scroll; 
        overflow-x:hidden;">
    <thead>
      <tr>
        <th>#</th>
        <th>Categories</th>
      </tr>
    </thead>
    <tbody>
      
    <?php 
      $allCategories = getAllCategories($_SESSION['user']->company_id);
      foreach ($allCategories as $idRow=>$row){
        echo "<tr  id='row$idRow' onclick='rowSelected($idRow)'>";
        echo "<td>$idRow</td>";
        echo "<td>".$row['name']."</td>";
        echo "</tr>";
      }
    ?>
    </tbody>
  </table>

	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCategory">add
                  	</button>
  
  <button id="editButton" type="button" class="btn btn-primary" data-toggle="modal" data-target="#editCategory" disabled>edit
                  	</button>              	
    <button type="button" class="btn btn-danger" id="deleteButton">Delete
                  	</button>

<div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
         <form action="?act=add_category" method="POST" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Category</h4>
      </div>
      <div class="modal-body">
         
             <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Categories</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="name" id="addName">
                </div>
              </div>
      </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" <?php echo "onclick='addCat(".$_SESSION['user']->company_id.")'";?>>Add</button>
      </div>
         
    </div>
  </div>
</div>

<div class="modal fade" id="editCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
         <form action="?act=edit_category" method="POST" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Category</h4>
      </div>
      <div class="modal-body">
         
             <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Categories</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="name" id="editName">
                </div>
              </div>
      </div>
       </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick = "editCat()">Edit</button>
      </div>
    </div>
  </div>
</div>


<script>
  function addCat(company_id){
    var data = {};
    data['company_id'] = company_id;
    data['name'] = $("#addName").val();
    
    jQuery.ajax({
      url: "ajax.php",
      data: "act=addCat&arr=" + JSON.stringify(data),
      type: "POST",
      success: function(data){
        $("tbody").html(data);
        $("#addCategory").modal("hide");
      }
    });
  }
  
  function editCat(){
    var data = {};
    data["id"] = rowId;
    data["name"] = $("#editName").val();
    
    jQuery.ajax({
      url: "ajax.php",
      data: "act=editCat&arr=" + JSON.stringify(data),
      type: "POST",
      success: function(data){
        var result = jQuery.parseJSON(data);
        $("#row" + rowId + " td:nth-child(2)").html(result["name"]);
        $("#editCategory").modal("hide");
      },
      error: function(xh, text, error){
        alert(error);
      }
    });
  }
  
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
    }
  }
  
  var compId = <?php echo $_SESSION['user']->company_id; ?>;
  $("#deleteButton").click(function(){
    deleteCat(rowId,compId);
  });
  
  function deleteCat(categoryId,companyId){
    jQuery.ajax({
      url: "ajax.php",
      data: "act=deleteCat&catId=" + categoryId+"&compId="+companyId,
      type: "POST",
      success: function(data){
        $("tbody").html(data);
      }
    });
  }
  
</script>