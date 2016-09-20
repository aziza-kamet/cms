 <form action="?act=addCallTo">
  <div class="col-sm-6">
    <select class="form-control" name="client_id" id="clients">
        <?php
            $clients = getClients($_SESSION['user']->company_id);
            echo "<option value='total'>All clients</option>";
            foreach ($clients as $idRow => $row) {
              echo  "<option value=$idRow>".$row['name']."</option>";
            }
        ?>
    </select>
  </div>
  <div class="col-sm-6">
      <select class="form-control" name="commodity_id" id="commodities">
      <?php
          $cats = getCommodities($_SESSION['user']->company_id);
          echo "<option value='total'>All commodities</option>";
          foreach ($cats as $idRow => $row) {
            echo  "<option value=$idRow>".$row['name']."</option>";
          }
      ?>
      </select>
  </div>
  <br><br>
  <table class="table table-bordered">
      
    </table>
  </form>
  
<script>
      
    var comp_id = <?php echo $_SESSION['user']->company_id;?>;  
    $(document).ready(function(){
      getTech(comp_id);
    });
    
    $("#clients").change(function(){
      var id = $(this).val();
      if(id == "total")
        getTech(comp_id);
      else
        getByClient(id);
    });
    
    $("#commodities").change(function(){
      var id = $(this).val();
      if(id == "total")
        getTech(comp_id);
      else
        getByCommodity(id);
    });
    
    function getTech(company_id){
      jQuery.ajax({
        url: "ajax.php",
        data: "req=getTechSuppReport&comp_id="+company_id,
        type: "GET",
        success: function(data){
          $("table").html(data);
        }
        
      });
    }
    
    function getByClient(client_id){
      jQuery.ajax({
        url: "ajax.php",
        data: "req=getCallTechClient&client_id="+client_id,
        type: "GET",
        success: function(data){
          $("table").html(data);
        }
        
      });
    }
    
    function getByCommodity(comm_id){
      jQuery.ajax({
        url: "ajax.php",
        data: "req=getCallTechCommodity&comm_id="+comm_id,
        type: "GET",
        success: function(data){
          $("table").html(data);
        }
        
      });
    }
    
</script>