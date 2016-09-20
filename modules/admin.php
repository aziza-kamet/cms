<?php
  $page="admin";
  $table="addCommodities";
  if(isset($_GET['table'])){
    if($_GET['table']=="addCommodities"){
      $table="addCommodities";
    }else if($_GET['table']=="addCategory"){
      $table="addCategory";
    }else if($_GET['table']=="editManager"){
      $table="editManager";
    }else if($_GET['table']=="clientHistory"){
      $table="clientHistory";
    }else if($_GET['table']=="salesReport"){
      $table="salesReport";
    }else if($_GET['table']=="managHistory"){
      $table="managHistory";
    }else if($_GET['table']=="salesReportM"){
      $table="salesReportM";
    }else if($_GET['table']=="callReport"){
      $table="callReport";
    }else if($_GET['table']=="qualityReport"){
      $table="qualityReport";
    }
  }
 
?>
  <div class="container-fluid">
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-10">
        <div class="panel panel-default" id="main_body">
          <div class="panel-body">
            <div class="row">
              <div class="col-md-3">
                <div class="list-group">
                  <a href="?page=admin&table=addCommodities" class="list-group-item <?php echo ($table == 'addCommodities'?'active':'');?>">Commodities</a>
                  <a href="?page=admin&table=addCategory" class="list-group-item <?php echo ($table == 'addCategory'?'active':'');?>">Categories</a>
                  <a href="?page=admin&table=editManager" class="list-group-item <?php echo ($table == 'editManager'?'active':'');?>">Managers</a>
                  <a href="?page=admin&table=clientHistory" class="list-group-item <?php echo ($table == 'clientHistory'?'active':'');?>">Client history</a>
                  <a href="?page=admin&table=salesReport" class="list-group-item <?php echo ($table == 'salesReport'?'active':'');?>">Report about sales and refunds(commodity)</a>
                  <a href="?page=admin&table=managHistory" class="list-group-item <?php echo ($table == 'managHistory'?'active':'');?>">Management history</a>
                  <a href="?page=admin&table=salesReportM" class="list-group-item <?php echo ($table == 'salesReportM'?'active':'');?>">Report about sales(managers)</a>
                  <a href="?page=admin&table=callReport" class="list-group-item <?php echo ($table == 'callReport'?'active':'');?>">Report about calls tech support</a>
                  <a href="?page=admin&table=qualityReport" class="list-group-item <?php echo ($table == 'qualityReport'?'active':'');?>">Report about quality</a>
                </div>
              </div>
            <div class="col-md-9">
            <?php
              
              require "$table.php";
            ?>
            </div>
            </div>
            </div>
          </div>
        </div> 
		  </div>
		<div class="col-md-1"></div>
	</div>
	</div>
	