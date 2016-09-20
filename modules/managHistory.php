<div class="btn-group">
    <select class="form-control" id="manager_type">
      <option value="sales">Sales</option>
      <option value="tech_support">Tech support</option>
      <option value="quality">Quality</option>
      <option value="calls">Calls</option>
    </select>
  </div>
  <table class="table table-bordered">
    
  </table>
  
  <script>
  
    var comp_id = <?php echo $_SESSION['user']->company_id;?>;
    $(document).ready(function(){
      getSales(comp_id);
    });
    
    $("#manager_type").change(function(){
      var type = $(this).val();
      if(type == "sales")
        getSales(comp_id);
      else if(type == "tech_support")
        getTech(comp_id);
      else if(type == "quality")
        getQuality(comp_id); 
      else if(type == "calls")
        getCall(comp_id); 
        
    });
  
    function getSales(company_id){
      jQuery.ajax({
        url: "ajax.php",
        data: "req=getSalesReport&comp_id="+company_id,
        type: "GET",
        success: function(data){
          $("table").html(data);
        }
        
      });
    }
    
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
    
    function getQuality(company_id){
      jQuery.ajax({
        url: "ajax.php",
        data: "req=getQualityReport&comp_id="+company_id,
        type: "GET",
        success: function(data){
          $("table").html(data);
        }
      });
    }
    
    function getCall(company_id){
      jQuery.ajax({
        url: "ajax.php",
        data: "req=getCallReport&comp_id="+company_id,
        type: "GET",
        success: function(data){
          $("table").html(data);
        }
      });
    }
    
  </script>