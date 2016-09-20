<?php
    session_start();
    
    require "init/db.php";
    require "functions.php";

    if(isset($_GET['req'])){
        if($_GET['req'] == "getCommodity" && isset($_GET['id'])){
            $id = $_GET['id'];
            $sql = "SELECT * FROM commodities WHERE commodity_id=$id";
            $query = $connection->query($sql);
            if($row = $query->fetch_object()){
                $json = array("name" => $row->name, "price" => $row->price, "category" => $row->category_id);
                echo json_encode($json);
            } else {
                echo "-1";
            }
            
        }else if($_GET['req']=="getManagers" && isset($_GET['id'])){
            $id = $_GET['id'];
            $sql = "SELECT * FROM users WHERE user_id=$id";
            $query = $connection->query($sql);
            if($row = $query->fetch_object()){
                $json = array('login' => $row->login, 'password'=>$row->password,'type'=>$row->type);
                echo json_encode($json);
            }else{
                echo "-1";
            }
        } else if($_GET['req'] == "getSalesReport" && isset($_GET['comp_id'])){
            $sales = getSalesReport($_GET['comp_id']);
            ?>
            <thead>
                <tr>
                    <th>Manager</th>
                    <th>Client</th>
                    <th>Commodity</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Date</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($sales as $id=>$arr) {
        ?>
        
            <tr>
                <td><?php echo $arr['manager'];?></td>
                <td><?php echo $arr['client'];?></td>
                <td><?php echo $arr['commodity'];?></td>
                <td><?php echo $arr['price'];?></td>
                <td><?php echo $arr['quantity'];?></td>
                <td><?php echo $arr['date'];?></td>
                <td><?php echo $arr['address'];?></td>
            </tr>
            
        <?php
            }
            ?>
            </tbody>
            <?php
            
        } else if($_GET['req'] == "getTechSuppReport" && isset($_GET['comp_id'])){
            $tech = getTechSuppReport($_GET['comp_id']);
            ?>
            <thead>
                <tr>
                    <th>Manager</th>
                    <th>Client</th>
                    <th>Commodity</th>
                    <th>Reason</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($tech as $id=>$arr) {
        ?>
        
            <tr>
                <td><?php echo $arr['manager'];?></td>
                <td><?php echo $arr['client'];?></td>
                <td><?php echo $arr['commodity'];?></td>
                <td><?php echo $arr['reason'];?></td>
                <td><?php echo $arr['result'];?></td>
            </tr>
            
        <?php
            }
            ?>
            </tbody>
            <?php
            
        } else if($_GET['req'] == "getQualityReport" && isset($_GET['comp_id'])){
            $quality = getQualityReport($_GET['comp_id']);
            ?>
            <thead>
                <tr>
                    <th>Manager</th>
                    <th>Client</th>
                    <th>Commodity</th>
                    <th>Reason</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($quality as $id=>$arr) {
        ?>
        
            <tr>
                <td><?php echo $arr['manager'];?></td>
                <td><?php echo $arr['client'];?></td>
                <td><?php echo $arr['commodity'];?></td>
                <td><?php echo $arr['reason'];?></td>
            </tr>
            
        <?php
            }
            ?>
            </tbody>
            <?php
            
        } else if($_GET['req'] == "getCallReport" && isset($_GET['comp_id'])){
            $call = getCallsReport($_GET['comp_id']);
            ?>
            <thead>
                <tr>
                    <th>Manager</th>
                    <th>Client</th>
                    <th>Switched manager</th>
                    <th>Is rejected?</th>
                    <th>Rejection reason</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($call as $id=>$arr) {
        ?>
        
            <tr>
                <td><?php echo $arr['manager'];?></td>
                <td><?php echo $arr['client'];?></td>
                <td><?php echo $arr['switched'];?></td>
                <td><?php echo ($arr['rejected']==1?"YES":"NO");?></td>
                <td><?php echo $arr['reason'];?></td>
            </tr>
            
        <?php
            }
            ?>
            </tbody>
            <?php
            
        } else if($_GET['req'] == "getCallTechClient" && isset($_GET['client_id'])){
            $calls = getCallTechClient($_GET['client_id']);
        ?>
            <thead>
                <tr>
                    <th>Manager</th>
                    <th>Commodity</th>
                    <th>Reason</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
        <?php
            foreach ($calls as $id=>$arr) {
        ?>
        
            <tr>
                <td><?php echo $arr['login'];?></td>
                <td><?php echo $arr['commodity_name'];?></td>
                <td><?php echo $arr['reason'];?></td>
                <td><?php echo $arr['result'];?></td>
            </tr>
            
        <?php
            }
        ?>
            </tbody>
        <?php
            
        } else if($_GET['req'] == "getCallTechCommodity" && isset($_GET['comm_id'])){
            $calls = getCallTechCommodity($_GET['comm_id']);
        ?>
            <thead>
                <tr>
                    <th>Manager</th>
                    <th>Client</th>
                    <th>Reason</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
        <?php
            foreach ($calls as $id=>$arr) {
        ?>
        
            <tr>
                <td><?php echo $arr['login'];?></td>
                <td><?php echo $arr['client_name'];?></td>
                <td><?php echo $arr['reason'];?></td>
                <td><?php echo $arr['result'];?></td>
            </tr>
            
        <?php
            }
        ?>
            </tbody>
        <?php
            
        } else if($_GET['req'] == "getSales" && isset($_GET['comp_id'])){
            
            $sales = numberOfSales($_GET['comp_id']);
            echo json_encode($sales);
            
        }  else if($_GET['req'] == "getRefunds" && isset($_GET['comp_id'])){
            
            $refunds = numberOfRefunds($_GET['comp_id']);
            echo json_encode($refunds);
            
        } else if($_GET['req'] == "getSalesByComm" && isset($_GET['comp_id']) && isset($_GET['comm_id'])){
            
            $sales = numberOfSalesByComm($_GET['comp_id'], $_GET['comm_id']);
            echo json_encode($sales);
            
        } else if($_GET['req'] == "getRefundsByComm" && isset($_GET['comp_id']) && isset($_GET['comm_id'])){
            
            $refunds = numberOfRefundsByComm($_GET['comp_id'], $_GET['comm_id']);
            echo json_encode($refunds);
            
        } else if($_GET['req'] == "getFullSalesComm" && isset($_GET['comp_id']) && isset($_GET['comm_id'])){
            
            $sales = getSaleByComm($_GET['comp_id'], $_GET['comm_id']);
            foreach ($sales as $id=>$arr) {
        ?>
        
            <tr>
                <td><?php echo $arr['client'];?></td>
                <td><?php echo $arr['quantity'];?></td>
                <td><?php echo $arr['date'];?></td>
                <td><?php echo $arr['manager'];?></td>
            </tr>
            
        <?php
            }

        } else if($_GET['req'] == "getFullRefundsComm" && isset($_GET['comp_id']) && isset($_GET['comm_id'])){
            
            $refunds = getRefundByComm($_GET['comp_id'], $_GET['comm_id']);
            foreach ($refunds as $id=>$arr) {
        ?>
        
            <tr>
                <td><?php echo $arr['client'];?></td>
                <td><?php echo $arr['quantity'];?></td>
                <td><?php echo $arr['date'];?></td>
                <td><?php echo $arr['manager'];?></td>
            </tr>
            
        <?php
            } 
        } else if($_GET['req'] == "getClientsData" && isset($_GET['comp_id'])){
                
                $clients = getClientsData($_GET['comp_id']);
                foreach ($clients as $id=>$arr) {
        ?>
            
            <tr>
                <td><?php echo $arr['client'];?></td>
                <td><?php echo $arr['purchases'];?></td>
                <td><?php echo $arr['refunds'];?></td>
                <td><?php echo $arr['total'];?></td>
            </tr>
                    
        <?php
                }
            }
    }
    
    if(isset($_POST['act'])){
        if($_POST['act'] == "editComm"){
            $commData = json_decode($_POST['arr']);
            editCommodity($commData->id, $commData->name, $commData->price, $commData->category);
            $query = "SELECT name FROM categories WHERE category_id=$commData->category";
            $sql = $connection->query($query);
            if($row = $sql->fetch_object()){
                $json = array("name" => $commData->name, "price" => $commData->price, "category" => $row->name);
                echo json_encode($json);
            }
        } else if($_POST['act'] == "addComm"){
            $commData = json_decode($_POST['arr']);
            addCommodity($commData->category, $commData->name, $commData->price);
            getCommoditiesForTable($commData->company_id);
            
        } else if($_POST['act']=="addCat"){
            $catData = json_decode($_POST['arr']);
            addCategory($catData->company_id, $catData->name);
            getCategoriesForTable($catData->company_id);
            
        } else if($_POST['act']=='editCat'){
            $catData = json_decode($_POST['arr']);
            editCategory($catData->id, $catData->name);
            $json = array("name"=>$catData->name);
            echo json_encode($json);
            
        } else if($_POST['act']=='addMan'){
            $manData = json_decode($_POST['arr']);
            addManager($manData->company_id,$manData->login,$manData->password,$manData->repassword,$manData->type);
            getManagersForTable($manData->company_id);
            
        } else if($_POST['act']=='editMan'){
            $manData = json_decode($_POST['arr']);
            editManager($manData->id,$manData->login, $manData->password,$manData->repassword, $manData->type);
            $json = array("login"=>$manData->login, "password"=>$manData->password, "type"=>$manData->type);
            echo json_encode($json);
        } else if($_POST['act']=='commOnCat'){
            $com = json_decode($_POST['arr']);
            $commodities = getCommoditiesOnCategories($com);
            echo count($commodities);
              foreach ($commodities as $idRow=>$row){
                 echo "<tr>";
                echo "<td>$idRow</td>";
              echo "<td>".$row['name']."</td>";
                echo "<td>".$row['price']."</td>";
                echo "</tr>";
              }
            
        } else if($_POST['act']=='allCommOnCat'){
            $allCommodities = getAllCommodities();
            foreach($allCommodities as $idRow=>$row){
                echo "<tr id='row$idRow'>";
                echo "<td>$idRow</td>";
                echo "<td>".$row['name']."</td>";
                echo "<td>".$row['price']."</td>";
                echo "</tr>";
            }
        } else if($_POST['act']=='deleteComm'){
           deleteCommodity($_POST['commId']);
           getCommoditiesForTable($_POST['compId']);
        } else if($_POST['act']=='deleteCat'){
            deleteCategory($_POST['catId']);
            getCategoriesForTable($_POST['compId']);
        } else if($_POST['act']=='deleteMan'){
            deleteManager($_POST['manId']);
            getManagersForTable($_POST['compId']);
        }else if($_POST['act']=='blockMan'){
            blockManager($_POST['manId']);
            getManagersForTable($_POST['compId']);
        }else if($_POST['act']=='unblockMan'){
            unblockManager($_POST['manId']);
             getManagersForTable($_POST['compId']);
        }
    }
    
    function getCommoditiesForTable($company_id){
        $comm =  getCommodities($company_id);
            foreach ($comm as $idRow=>$row){
                echo "<tr id='row$idRow' onclick='rowSelected($idRow)'>";
                echo "<td>$idRow</td>";
                echo "<td>".$row['name']."</td>";
                echo "<td>".$row['price']."</td>";
                echo "<td>".$row['category']."</td>";
                echo "</tr>";
            }
    }
    
    function getCategoriesForTable($company_id){
        $allCategories = getAllCategories($company_id);
              foreach ($allCategories as $idRow=>$row){
                echo "<tr  id=row1 onclick='rowSelected($idRow)'>";
                echo "<td>$idRow</td>";
                echo "<td>".$row['name']."</td>";
                echo "</tr>";
              }
    }
    
    function getManagersForTable($company_id){
        $allManagers = getManagers($company_id);
            foreach($allManagers as $idRow=>$row){
                echo "<tr  id=row1 onclick='rowSelected($idRow)'>";
                echo "<td>$idRow</td>";
                echo "<td>".$row['login']."</td>";
                echo "<td>".$row['password']."</td>";
                echo "<td>".$row['type']."</td>";
                echo "<td>".$row['active']."</td>";
                echo "</tr>";
            }
    }
    
    
?>