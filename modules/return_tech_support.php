<form action="?act=add_return" method="POST">
<div class="container-fluid">
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<div class="panel panel-default" id="main_body">
				<div class="panel-body">
					<div class="form-horizontal">
					    <h3>To return:</h3>
						<div class="form-group">
							<label class="col-sm-2 control-label">
	                        Sale ID:
	                        </label>
							<div class="col-sm-7">
						        <select class="form-control" name="sale_id">
						            <?php
						                $sales = getSales($_SESSION['user']->company_id);
						                foreach ($sales as $idRow => $row) {
						                  echo  "<option value=$idRow>".$idRow."</option>";
						                }
						            ?>
						        </select>
						    </div> 
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
	                        Reason:
	                        </label>
	                        <div class="col-sm-7">
	                            <textarea class="form-control" rows="3" name="reason"></textarea>
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
</div>
</form>