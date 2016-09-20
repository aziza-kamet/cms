<form action="?act=add_tech_support_notes" method="POST">
<div class="container-fluid">
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<div class="panel panel-default" id="main_body">
				<div class="panel-body">
					<div class="form-horizontal">
						<h3>Call reason:</h3>
						<div class="form-group">
							<label class="col-sm-2 control-label">
	                        Client:
	                        </label>
							<div class="col-sm-7">
						        <select class="form-control" name="client_id">
						            <?php
						                $clients = getClients($_SESSION['user']->company_id);
						                foreach ($clients as $idRow => $row) {
						                  echo  "<option value=$idRow>".$row['name']."</option>";
						                }
						            ?>
						        </select>
						    </div> 
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
	                        Problem:
	                        </label>
	                        <div class="col-sm-7">
	                            <textarea class="form-control" rows="3" name="problem"></textarea>
	                        </div> 
						</div>
						<div class="form-group">
								<label class="col-sm-2 control-label">
		                           Solution:
		                         </label>
		                         <div class="col-sm-7">
		                            <textarea class="form-control" rows="3" name="solution"></textarea>
		                          </div> 
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
	                           Product Name:
	                         </label>
	                         <div class="col-sm-7">
					            <select class="form-control" name="commodity_id">
					            <?php
					                $cats = getCommodities($_SESSION['user']->company_id);
					                foreach ($cats as $idRow => $row) {
					                  echo  "<option value=$idRow>".$row['name']."</option>";
					                }
					            ?>
					            </select>
					        </div>
						</div>
						<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
                              		<button type="submit" class="btn btn-default">Submit</button>
                            	</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-1"></div>
	</div>
	<?php require "return_tech_support.php"; ?>
</div>
</form>