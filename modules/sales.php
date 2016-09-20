<?php
  $page="sales";
  $table="salesForm";
  if(isset($_GET['table'])){
    if($_GET['table']=="salesForm"){
      $table="salesForm";
    }else if($_GET['table']=="callsTo"){
      $table="callsTo";
    }else if($_GET['table']=="callsFrom"){
      $table="callsFrom";
    }
  }
   
  ?>
<div class="form-horizontal">
  <div class="col-md-1"></div>
  <div class="col-md-3">
    <div class="list-group">
      <a href="?page=sales&table=salesForm" class="list-group-item <?php echo ($table == 'salesForm'?'active':'');?>">Sales</a>
      <a href="?page=sales&table=callsTo" class="list-group-item <?php echo ($table == 'callTo'?'active':'');?>">Calls to client</a>
      <a href="?page=sales&table=callsFrom" class="list-group-item <?php echo ($table == 'callsFrom'?'active':'');?>">Calls from client</a>
    </div>
  </div>
  <div class="col-md-6">
    <?php
    require "$table.php";
    ?>
  </div>
  <div class="col-md-2"></div>
</div>