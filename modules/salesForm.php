<form action="?act=add_sales" method="POST">  
    <div class="form-group">
      <label class="control-label col-sm-2" >Client name:</label>
      <div class="col-sm-10">
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
      <label class="control-label col-sm-2" for="email" >Commodity name:</label>
        <div class="col-sm-10">
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
      <label class="control-label col-sm-2">Price:</label>
      <div class="col-sm-10"> 
        <input name="price" class="form-control">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" >Quantity:</label>
      <div class="col-sm-10"> 
        <input name="quantity" class="form-control">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" >Address:</label>
      <div class="col-sm-10"> 
        <input name="address" class="form-control">
      </div>
    </div>
    <div class="form-group"> 
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default" >Submit</button>
      </div>
    </div>
</form> 