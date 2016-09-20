

<div class="container-fluid">
  <div class="row">
    <div class="col-md-3">
       <div class="list-group" >
        <a class="list-group-item" onclick="getAllCommodities()">All</a>
        <?php
          $allCategories = getCategoriesForMenu();
          foreach($allCategories as $idRow=>$row){
           echo "<a onclick='getCommoditiesOnCategories($idRow)' class='list-group-item'>".$row."</a>";
          }
        ?>
    </div>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-7">
      <table class="table">
          <thead>
          <tr>
            <th>#</th>
            <th>name</th>
            <th>price</th>
          </tr>
        </thead>
         <tbody>
          
          
        </tbody>
      </table>
    </div>
    <div class="col-md-1"></div>
  </div>
</div>

<script>
  $(document).ready(function(){
      getAllCommodities();
    });
  function getAllCommodities(){
    jQuery.ajax({
      url: "ajax.php",
      data: "act=allCommOnCat",
      type: "POST",
      success: function(data){
          $('tbody').html(data);
      },
      error: function(xh, text, error){
        alert(error);
      }
    });
  }  
  function getCommoditiesOnCategories(category_id){
    
    
    jQuery.ajax({
      url: "ajax.php",
      data: "act=commOnCat&arr=" + category_id,
      type: "POST",
      success: function(data){
          $('tbody').html(data);
      },
      error: function(xh, text, error){
        alert(error);
      }
    });
  }
</script>