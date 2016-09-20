 <?php
  $sales = numberOfSales($_SESSION['user']->company_id);
  $refunds = numberOfRefunds($_SESSION['user']->company_id);
 ?>
 <div class="col-sm-12" style="margin:10px 10px 10px -12px;">
  <select id="commsSelect" class="form-control">
    <?php
        $cats = getCommodities($_SESSION['user']->company_id);
        echo "<option value='total'>Total</option>";
        foreach ($cats as $idRow => $row) {
          echo  "<option value=$idRow>".$row['name']."</option>";
        }
    ?>
  </select>
  </div>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>day</th>
        <th>week</th>
        <th>month</th>
        <th>total</th>
      </tr>
    </thead>
      <tr id="salesRow">
        <td>Number of sales:</td>
        <td><?php echo $sales['count_day'];?></td>
        <td><?php echo $sales['count_week'];?></td>
        <td><?php echo $sales['count_month'];?></td>
        <td><?php echo $sales['count_total'];?></td>
      </tr>
      <tr id="refundsRow">
        <td>Number of refunds:</td>
        <td><?php echo $refunds['count_day'];?></td>
        <td><?php echo $refunds['count_week'];?></td>
        <td><?php echo $refunds['count_month'];?></td>
        <td><?php echo $refunds['count_total'];?></td>
      </tr>
    </tbody>
  </table>
<div class="col-sm-12" style="margin:10px 10px 10px -12px;">
  <select id="fullCommsSelect" class="form-control">
    <?php
        $cats = getCommodities($_SESSION['user']->company_id);
        echo "<option value='select'>Select commodity</option>";
        foreach ($cats as $idRow => $row) {
          echo  "<option value=$idRow>".$row['name']."</option>";
        }
    ?>
  </select>
  </div>
  <table class="table table-bordered">
    <h4>Sales</h4>
    <thead>
      <tr>
        <th>Client</th>
        <th>Quantity</th>
        <th>Date</th>
        <th>Manager</th>
      </tr>
    </thead>
    <tbody id="fullSalesTable">
      <tr>
        <td>--</td>
        <td>--</td>
        <td>--</td>
        <td>--</td>
      </tr>
    </tbody>
    </table>
    <table class="table table-bordered">
    <h4>Refunds</h4>
    <thead>
      <tr>
        <th>Client</th>
        <th>Quantity</th>
        <th>Date</th>
        <th>Manager</th>
      </tr>
    </thead>
    <tbody id="fullRefundsTable">
      <tr>
        <td>--</td>
        <td>--</td>
        <td>--</td>
        <td>--</td>
      </tr>
    </tbody>
  </table>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Client</th>
        <th>Number of purchases</th>
        <th>Number of refunds</th>
        <th>Total amount</th>
      </tr>
    </thead>
    <tbody id="clientsTable">
    </tbody>
  </table>
  
  <script>
    var comp_id = <?php echo $_SESSION['user']->company_id;?>;
    $(document).ready(function(){
      getClientsData(comp_id);
    });
    
    $("#commsSelect").change(function(){
      var comm_id = $(this).val();
      if(comm_id == "total"){
        getSales();
        getRefunds();
      } else {
        getSalesByComm(comm_id);
        getRefundsByComm(comm_id);
      }
    });
    
    $("#fullCommsSelect").change(function(){
      var comm_id = $(this).val();
      if(comm_id == "select"){
        fillEmptyTable();
      } else {
        getFullSalesByComm(comm_id);
        getFullRefundsComm(comm_id)
      }
    });
    
    function getSales(){
      jQuery.ajax({
        url: "ajax.php",
        data: "req=getSales&comp_id="+comp_id,
        type: "GET",
        success: function(data){
          var result = jQuery.parseJSON(data);
          $("#salesRow td:nth-child(2)").html(result["count_day"]);
          $("#salesRow td:nth-child(3)").html(result["count_week"]);
          $("#salesRow td:nth-child(4)").html(result["count_month"]);
          $("#salesRow td:nth-child(5)").html(result["count_total"]);
        },
        error: function(xh, text, error){
          alert(error);
        }
      });
    }
    
    function getSalesByComm(comm_id){
      jQuery.ajax({
        url: "ajax.php",
        data: "req=getSalesByComm&comm_id="+comm_id+"&comp_id="+comp_id,
        type: "GET",
        success: function(data){
          var result = jQuery.parseJSON(data);
          $("#salesRow td:nth-child(2)").html(result["count_day"]);
          $("#salesRow td:nth-child(3)").html(result["count_week"]);
          $("#salesRow td:nth-child(4)").html(result["count_month"]);
          $("#salesRow td:nth-child(5)").html(result["count_total"]);
        },
        error: function(xh, text, error){
          alert(error);
        }
      });
    }
    
    function getRefunds(){
      jQuery.ajax({
        url: "ajax.php",
        data: "req=getRefunds&comp_id="+comp_id,
        type: "GET",
        success: function(data){
          var result = jQuery.parseJSON(data);
          $("#refundsRow td:nth-child(2)").html(result["count_day"]);
          $("#refundsRow td:nth-child(3)").html(result["count_week"]);
          $("#refundsRow td:nth-child(4)").html(result["count_month"]);
          $("#refundsRow td:nth-child(5)").html(result["count_total"]);
        },
        error: function(xh, text, error){
          alert(error);
        }
      });
    }
    
    function getRefundsByComm(comm_id){
      jQuery.ajax({
        url: "ajax.php",
        data: "req=getRefundsByComm&comm_id="+comm_id+"&comp_id="+comp_id,
        type: "GET",
        success: function(data){
          var result = jQuery.parseJSON(data);
          $("#refundsRow td:nth-child(2)").html(result["count_day"]);
          $("#refundsRow td:nth-child(3)").html(result["count_week"]);
          $("#refundsRow td:nth-child(4)").html(result["count_month"]);
          $("#refundsRow td:nth-child(5)").html(result["count_total"]);
        },
        error: function(xh, text, error){
          alert(error);
        }
      });
    }
    
    function getFullSalesByComm(comm_id){
      jQuery.ajax({
        url: "ajax.php",
        data: "req=getFullSalesComm&comm_id="+comm_id+"&comp_id="+comp_id,
        type: "GET",
        success: function(data){
          $("#fullSalesTable").html(data);
        },
        error: function(xh, text, error){
          alert(error);
        }
      });  
    }
    
    function getFullRefundsComm(comm_id){
      jQuery.ajax({
        url: "ajax.php",
        data: "req=getFullRefundsComm&comm_id="+comm_id+"&comp_id="+comp_id,
        type: "GET",
        success: function(data){
          $("#fullRefundsTable").html(data);
        },
        error: function(xh, text, error){
          alert(error);
        }
      }); 
    }
    
    function fillEmptyTable(){
      var table = "<tr>" +
            "<td>--</td>" +
            "<td>--</td>" +
            "<td>--</td>" +
            "<td>--</td>" +
          "</tr>";
      $("#fullSalesTable").html(table);
      $("#fullRefundsTable").html(table);
    }
    
    function getClientsData(comp_id){
      jQuery.ajax({
        url: "ajax.php",
        data: "req=getClientsData&comp_id="+comp_id,
        type: "GET",
        success: function(data){
          $("#clientsTable").html(data);
        },
        error: function(xh, text, error){
          alert(error);
        }
      });
    }
    
  </script>