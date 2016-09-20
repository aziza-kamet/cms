
<table id='goods_table' class="table table-bordered table-hover">
    <thead>
        <th class="first">#</th>
        <th>Name</th>
        <th>Price</th>
        <th>Category</th>
    </thead>
    <tbody>
    <?php 
      $comm = getCommodities($_SESSION['user']->company_id);
      foreach ($comm as $idRow=>$row){
        echo "<tr id='row$idRow' onclick='rowSelected($idRow)'>";
        echo "<td class='first'>$idRow</td>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['price']."</td>";
        echo "<td>".$row['category']."</td>";
        echo "</tr>";
      }
    ?>
    </tbody>
</table>

	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCommodity">add
                  	</button>
	<button id="editButton" type="button" class="btn btn-primary" data-toggle="modal" data-target="#editCommodity" disabled>edit
                  	</button>
  
  <button type="button" class="btn btn-danger" id="deleteButton">Delete
                  	</button>

<div class="modal fade" id="addCommodity" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form action="?act=add_commodity" method="POST" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Commodity</h4>
      </div>
      <div class="modal-body">
         
             <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                  <input type="text" id="addName" class="form-control" name="name">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Price</label>
                <div class="col-sm-10">
                  <input type="text" id="addPrice" class="form-control" name="price">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Category</label>
                <div class="col-sm-10">
                  <select class="form-control" id="addCategory" name="categoryId">
                    <?php
                    
                        $cats = getCategories($_SESSION['user']->company_id);
                        foreach ($cats as $key => $val) {
                          echo  "<option value='$key'>$val</option>";
                        }
                    ?>
                  </select>
                </div>
              </div>
              
      </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" <?php echo "onclick='addComm(".$_SESSION['user']->company_id.")'";?>>Add</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="editCommodity" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form action="?act=edit_commodity" method="POST" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Commodity</h4>
      </div>
      <div class="modal-body">
         
             <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                  <input type="text" id="editName" class="form-control" name="name">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Price</label>
                <div class="col-sm-10">
                  <input type="text" id="editPrice" class="form-control" name="price">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Category</label>
                <div class="col-sm-10">
                  <select class="form-control" id="editCategory" name="categoryId">
                    <?php
                    
                        $cats = getCategories($_SESSION['user']->company_id);
                        foreach ($cats as $key => $val) {
                          echo  "<option value='$key'>$val</option>";
                        }
                    ?>
                  </select>
                </div>
              </div>
              
      </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="editComm()" >Edit</button>
      </div>
    </div>
  </div>
</div>

<script>
  var rowId = -1;
  function rowSelected(id){
    rowId = id;
    if(rowId != -1){
      $('#goods_table tr').css('background', '');
      $("#editButton").prop("disabled", false);
      $("#row"+rowId).hover(function(){
      $("#row"+rowId).css("background", "#FFFAFA");
      },
      function(){
        $("#row"+rowId).css("background", "#DCDCDC");
      });
      jQuery.ajax({
        url: "ajax.php",
        data: "req=getCommodity&id="+rowId,
        type: "GET",
        success: function(data){
          var result = jQuery.parseJSON(data);
          $("#editName").val(result['name']);
          $("#editPrice").val(result['price']);
          $("#editCategory").val(result['category']);
        },
        error: function(data, smth, error){
          alert(data.responseText + "\n" + smth + "\n" + error);
        }
      });
    }
  }
  
  function editComm(){
    var data = {};
    data["id"] = rowId;
    data["name"] = $("#editName").val();
    data["price"] = $("#editPrice").val();
    data["category"] = $("#editCategory :selected").val();
    
    jQuery.ajax({
      url: "ajax.php",
      data: "act=editComm&arr=" + JSON.stringify(data),
      type: "POST",
      success: function(data){
        var result = jQuery.parseJSON(data);
        $("#row" + rowId + " td:nth-child(2)").html(result["name"]);
        $("#row" + rowId + " td:nth-child(3)").html(result["price"]);
        $("#row" + rowId + " td:nth-child(4)").html(result["category"]);
        $("#editCommodity").modal("hide");
      },
      error: function(xh, text, error){
        alert(error);
      }
    });
  }
  
  function addComm(company_id){
    var data = {};
    data['company_id'] = company_id;
    data['name'] = $("#addName").val();
    data['price'] = $("#addPrice").val();
    data['category'] = $("#addCategory").val();
    
    jQuery.ajax({
      url: "ajax.php",
      data: "act=addComm&arr=" + JSON.stringify(data),
      type: "POST",
      success: function(data){
        $("tbody").html(data);
        $("#addCommodity").modal("hide");
      }
    });
  }
  
  var compId = <?php echo $_SESSION['user']->company_id; ?>;
  $("#deleteButton").click(function(){
    deleteComm(rowId,compId);
  });
  
  function deleteComm(commodityId,companyId){
    jQuery.ajax({
      url: "ajax.php",
      data: "act=deleteComm&commId=" + commodityId+"&compId="+companyId,
      type: "POST",
      success: function(data){
        $("tbody").html(data);
      }
    });
  }
  
</script>
