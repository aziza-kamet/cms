<?php
    function setStatus(){
        global $_SESSION, $online;
        if(isset($_SESSION['user'])){
            $online = true;
        } else {
            $online = false;
        }
    }

    function setPage(){
        global $_SESSION, $online, $page;
        
        if($online){
            
            if(isset($_GET['page'])){
                if($_GET['page'] == "logout"){
                    $page = "logout";
                } else {
                    $page = setCorrectPage($_SESSION['user']->type);
                }
            } else {
                $page = setCorrectPage($_SESSION['user']->type);
            }
            
        } else {    
            if(isset($_GET["page"])){
        
        		if($_GET["page"] == "home"){
    	            $page = "home";
        		} else if($_GET["page"] == "login"){
        		    $page = "login";
        		} else if($_GET["page"] == "registration"){
        		    $page = "registration";
        		} else {
        		    $page = "error404"; 
        		}
        	}
        }
    }
    
    function authorize($login, $pwd){
        global $page, $connection, $_SESSION;
        $query = $connection->query("SELECT * FROM users WHERE login = \"$login\" AND password = \"$pwd\" ");
        if($row = $query->fetch_object()){
            $active = $row->active;
            if($active==1){
                $_SESSION['user'] = $row;
        	    return (object) array("page" => setCorrectPage($row->type));   
            }else if($active==2){
                return (object) array("error"=>"blocked");
            }else{
                return (object) array("error"=>"no_such_user");
            }
        }
        
        return (object) array("error" => "incorrect_login_pwd");  
    }
    
    
    function logIn($login, $pwd){
        if(empty($login) || empty($pwd)){
            header("Location:?page=login&err=empty_fields");
        } else {
            $result = authorize($login, $pwd);
            if(isset($result->error)){
                header("Location:?page=login&err=$result->error");
            } else {
                header("Location:?page=$result->page");
            }
        }
    }
    
    function setCorrectPage($type){
        if($type == "sales manager"){
			return "sales";			
		} else if($type == "tech support manager"){
			return "tech_support";			
		} else if($type == "quality manager"){
			return "quality";			
		} else if($type == "calls manager"){
			return "calls";			
		} else if($type == "admin"){
			return "admin";			
		} else {
		    return "error404";
		}
    }

    function signUp($companyName, $login, $pwd, $re_pwd){
        global $connection, $_SESSION;
        if(empty($companyName) || empty($login) || empty($pwd) || empty($re_pwd)){
            return (object) array("error" => "empty_fields");
        } else {
            $companyName = $connection->real_escape_string($companyName);
            $login = $connection->real_escape_string($login);
            
            if($pwd == $re_pwd){
                $check_text = "SELECT u.login, c.name
                                FROM users u
                                LEFT OUTER JOIN companies c ON u.company_id = c.company_id
                                WHERE (u.login = \"$login\" OR c.name = \"$companyName\") 
                                AND u.active = 1 AND c.active = 1";
                $check_query = $connection->query($check_text);
                
                if($check_query->fetch_object()){
                    return (object) array("error" => "already_exists");
                } else{
                    $query = "INSERT INTO companies (name) VALUES (\"$companyName\")";
                    $sql = $connection->query($query);
                    $companyId = $connection->insert_id;
                    $adminQuery = "INSERT INTO users (company_id, login, password, type) VALUES ($companyId, \"$login\", \"$pwd\", \"admin\")";
                    $adminSql = $connection->query($adminQuery);
                    $userId = $connection->insert_id;
                    $_SESSION['user'] = $connection->query("SELECT * FROM users WHERE user_id = $userId")->fetch_object();
                    return (object) array("page" => "admin");
                }
            }
            
            return (object) array("error" => "pwd_mismatch");
        }
    }

    function logout(){
        global $_SESSION;
        unset($_SESSION['user']);
        header("Location:?page=home");
    }
    
    function addCommodity($categoryId, $name, $price){
        global $connection;
        $name = $connection->real_escape_string($name);
        $price = $connection->real_escape_string($price);
        $query = "INSERT INTO commodities (category_id, name, price) VALUES (\"$categoryId\", \"$name\",\"$price\") ";
        $sql = $connection->query($query);
    }
    
    function addCategory($companyId,$name){
        global $connection;
        $name = $connection->real_escape_string($name);
        //$companyId = $_SESSION['user']->company_id;
        $query = "INSERT INTO categories (company_id, name) VALUES (\"$companyId\",\"$name\")";
        $sql = $connection->query($query);
    }
    
    function addManager($companyId,$login, $password, $repassword, $type){
        if($password==$repassword){
            global $connection;
            $login = $connection->real_escape_string($login);
            $password = $connection->real_escape_string($password);
            $type = $connection->real_escape_string($type);
            $query = "INSERT INTO users (company_id,login, password, type) VALUES (\"$companyId\", \"$login\",\"$password\",\"$type\")";
            $sql = $connection->query($query);
        }
    }
    
    function editManager($managerId, $login, $password, $repassword, $type){
        if($password==$repassword){
            global $connection;
            $login = $connection->real_escape_string($login);
            $password = $connection->real_escape_string($password);
            $query = "UPDATE users
                      SET login = \"$login\", password = \"$password\", type = \"$type\"
                      WHERE user_id = \"$managerId\" ";
            $sql = $connection->query($query);
        }
    }
    
    function deleteManager($managerId){
        global $connection;
        $query = "UPDATE users
                  SET active = 0
                  WHERE user_id = \"$managerId\" ";
        $sql = $connection->query($query);
    }
    
    function editCategory($categoryId, $name){
        global $connection;
        $name = $connection->real_escape_string($name);
        $query = "UPDATE categories
                  SET name = \"$name\"
                  WHERE category_id = \"$categoryId\" ";
        $sql = $connection->query($query);
    }
    
    function deleteCategory($categoryId){
        global $connection;
        $query = "UPDATE categories
                  SET active = 0
                  WHERE category_id = \"$categoryId\" ";
        $sql = $connection->query($query);
    }
    
    function editCommodity($commodityId,$name, $price,$categoryId){
        global $connection;
        $name = $connection->real_escape_string($name);
        $price = $connection->real_escape_string($price);
        $query = "UPDATE commodities 
                  SET category_id=\"$categoryId\",name = \"$name\", price = \"$price\"
                  WHERE commodity_id = \"$commodityId\"";
        $sql = $connection->query($query);
    }
    
    function deleteCommodity($commodityId){
        global $connection;
        $query = "UPDATE commodities
                  SET active = 0
                  WHERE commodity_id = \"$commodityId\"";
        $sql = $connection->query($query);
    }
    
    function blockManager($managerId){
        global $connection;
        $query = "UPDATE users
                  SET active = 2
                  WHERE user_id = \"$managerId\"
        ";
        $sql = $connection->query($query);
    }
    
    function unblockManager($managerId){
        global $connection;
        $query = "UPDATE users
                  SET active = 1
                  WHERE user_id = \"$managerId\"
        ";
        $sql = $connection->query($query);
    }
    
    function addSales($clientId, $commodityName, $price, $quantity, $address){
        global $connection;
        echo "OK";
        $managerId = $_SESSION['user']->user_id;
        $commodityId = $connection->real_escape_string($commodityName);
        $price = $connection->real_escape_string($price);
        $address = $connection->real_escape_string($address);
        echo "BAD";
        $query = "INSERT INTO sales (manager_id,client_id,commodity_id,price,quantity, address) 
                  VALUES (\"$managerId\",\"$clientId\",\"$commodityId\",\"$price\",\"$quantity\",\"$address\")";
        $sql = $connection->query($query);
    }
    
    function addTechSupportNotes($clientId, $commodityId, $reason,$result){
        global $connection;
        $reason = $connection->real_escape_string($reason);
        $result = $connection->real_escape_string($result);
        $managerId = $_SESSION['user']->user_id;
        $query = "INSERT INTO tech_support_notes (client_id, manager_id, commodity_id, reason, result) VALUES (\"$clientId\",\"$managerId\",\"$commodityId\",\"$reason\",\"$result\") ";
        $sql = $connection->query($query);
    }
    
    function addQualityNotes($clientId,$reason,$commodityId){
        global $connection;
        $reason = $connection->real_escape_string($reason);
        $managerId = $_SESSION['user']->user_id;
        $query = "INSERT INTO quality_notes (client_id, manager_id, reason, commodity_id) VALUES (\"$clientId\",\"$managerId\",\"$reason\",\"$commodityId\") ";
        $sql = $connection->query($query);
    }

    function getCategories($compId){
        global $connection; 
        $query = "SELECT * FROM categories WHERE company_id = $compId AND active=1";
        $sql = $connection->query($query);
        $rows = array();
        
        while($row = $sql->fetch_object()){
            $rows[$row->category_id] = $row->name;    
        }
        
        return $rows;
    }
    
    function getCommodities($companyId){
        global $connection;
        $query = "SELECT *, cats.name AS cats_name, c.name AS comm_name FROM commodities c LEFT OUTER JOIN categories cats ON c.category_id = cats.category_id WHERE cats.company_id = $companyId AND c.active = 1";
        $sql = $connection->query($query);
        $commodities = array();
        while($row = $sql->fetch_object()){
           $commodities[$row->commodity_id] = array("name"=>$row->comm_name, "price"=>$row->price,"category"=>$row->cats_name);
        }
        return $commodities;
    }
    
    function getClients($companyId){
        global $connection;
        $query = "SELECT * FROM clients WHERE company_id = $companyId";
        $sql = $connection->query($query);
        $clients = array();
        while($row = $sql->fetch_object()){
           $clients[$row->client_id] = array("name"=>$row->name);
        }
        return $clients;
    }
    
    function getAllCategories($companyId){
        global $connection;
        $query = "SELECT *, name AS cat_name FROM categories WHERE company_id = $companyId AND active = 1";
        $sql = $connection->query($query);
        $categories = array();
        while($row = $sql->fetch_object()){
            $categories[$row->category_id] = array("name"=>$row->cat_name);
        }
        return $categories;
    }
    
    function getManagers($companyId){
        global $connection;
        $query = "SELECT *,login AS m_login, password AS m_password, type AS m_type, active AS m_active FROM users WHERE company_id = $companyId AND type!='admin' AND active=1 OR active=2";
        $sql = $connection->query($query);
        $companies = array();
        while($row = $sql->fetch_object()){
            $companies[$row->user_id] = array("login"=>$row->m_login, "password"=>$row->m_password, "type"=>$row->m_type,"active"=>$row->m_active);
        }
        return $companies;
    }
    
    function getClientHistory($companyId){
        global $connection;
        $query = "SELECT s.sale_id AS sale_id, c.name AS c_name, c.surname AS c_surname,
                    comm.name AS comm_name, s.date AS sale_date
                    FROM clients c
                    JOIN sales s ON c.client_id = s.client_id  
                    JOIN commodities comm ON s.commodity_id = comm.commodity_id  
                    WHERE company_id = $companyId
                    ORDER BY c.name";
        $sql = $connection->query($query);
        $clientsHistory = array();
        while($row = $sql->fetch_object()){
            $clientsHistory[$row->sale_id] = array("name"=>$row->c_name, "surname"=>$row->c_surname, "comm_name"=>$row->comm_name, "date"=>$row->sale_date);
        }
        return $clientsHistory;
    }
    
    function getSales($companyId){
        global $connection;
        $query = "SELECT * FROM sales";
        $sql = $connection->query($query);
        $sales = array();
        while($row = $sql->fetch_object()){
           $sales[$row->sale_id] = array("commodity_id"=>$row->commodity_id);
        }
        return $sales;
    }
    
    function add_return($sale_id,$reason){
        global $connection;
        $user_id = $_SESSION['user']->user_id;
        $select = "SELECT commodity_id FROM sales WHERE sale_id=$sale_id";
        $sql = $connection->query($select);
        while($row=$sql->fetch_object()){
            $commodity_id=$row->commodity_id;
        }
        $query = "INSERT INTO return_notes (sale_id,manager_id,commodity_id,reason) VALUES(\"$sale_id\",\"$user_id\",\"$commodity_id\",\"$reason\")";
        $sql2 = $connection->query($query);
    }
    
    function reportAboutSales($companyId){
        global $connection;
        $query = "SELECT * , u.login AS m_login, SUM( s.quantity ) AS m_quantity
                  FROM users u
                  INNER JOIN sales s ON u.user_id = s.manager_id
                  WHERE u.company_id = $companyId
                  AND u.type =  'sales manager'
                  GROUP BY u.user_id";
        $sql = $connection->query($query);
        $reportSales = array();
        while($row = $sql->fetch_object()){
            $reportSales[$row->user_id] = array("login"=>$row->m_login, "quantity"=>$row->m_quantity);
        }
        return $reportSales;
    }
    
    function reportAboutQuality($companyId){
        global $connection;
        $query = "SELECT SUM(q.commodity_id) AS commodity_sum, c.name AS commodity_name 
                  FROM quality_notes q 
                  LEFT OUTER JOIN commodities c ON q.commodity_id = c.commodity_id 
                  LEFT OUTER JOIN categories cat ON c.category_id = cat.category_id 
                  WHERE cat.company_id = $companyId
                  GROUP BY c.commodity_id";
        $sql = $connection->query($query);
        $reportQuality = array();
        while($row = $sql->fetch_object()){
          
            $reportQuality[$row->commodity_sum] = array("name"=>$row->commodity_name, "sum_commodity"=>$row->commodity_sum);
        }
    
        return $reportQuality;
    }
    
    function numberOfSales($companyId){
        global $connection;
        $day = (new DateTime())->format('Y-m-d');
        $month = (new DateTime())->format('Y-m');
        $query = "SELECT 
                    COUNT( CASE WHEN s.date LIKE  '$day%' THEN 1 END ) AS count_day, 
                    COUNT( CASE WHEN s.date LIKE  '$month%' THEN 1 END ) AS count_month, 
					COUNT( CASE WHEN YEARWEEK(s.date, 1) = YEARWEEK(CURDATE(), 1) THEN 1 END) AS count_week,
                    COUNT( * ) AS count_total
                    FROM sales s
                    LEFT OUTER JOIN users u ON s.manager_id = u.user_id
                    WHERE u.company_id = $companyId";
        $sql = $connection->query($query);
        if($row = $sql->fetch_object()){
            return array("count_day" => $row->count_day, "count_week" => $row->count_week, "count_month" => $row->count_month, "count_total" => $row->count_total,);
        }
        
    }
    
    function numberOfSalesByComm($companyId, $commodityId){
        global $connection;
        $day = (new DateTime())->format('Y-m-d');
        $month = (new DateTime())->format('Y-m');
        $query = "SELECT 
                    COUNT( CASE WHEN s.date LIKE  '$day%' THEN 1 END ) AS count_day, 
                    COUNT( CASE WHEN s.date LIKE  '$month%' THEN 1 END ) AS count_month, 
					COUNT( CASE WHEN YEARWEEK(s.date, 1) = YEARWEEK(CURDATE(), 1) THEN 1 END) AS count_week,
                    COUNT( * ) AS count_total
                    FROM sales s
                    LEFT OUTER JOIN users u ON s.manager_id = u.user_id
                    WHERE u.company_id = $companyId AND s.commodity_id = $commodityId";
        $sql = $connection->query($query);
        if($row = $sql->fetch_object()){
            return array("count_day" => $row->count_day, "count_week" => $row->count_week, "count_month" => $row->count_month, "count_total" => $row->count_total,);
        }
    }
    
    function numberOfRefunds($companyId){
        global $connection;
        $day = (new DateTime())->format('Y-m-d');
        $month = (new DateTime())->format('Y-m');
        $query = "SELECT 
                    COUNT( CASE WHEN r.return_date LIKE  '$day%' THEN 1 END ) AS count_day, 
                    COUNT( CASE WHEN r.return_date LIKE  '$month%' THEN 1 END ) AS count_month, 
					COUNT( CASE WHEN YEARWEEK(r.return_date, 1) = YEARWEEK(CURDATE(), 1) THEN 1 END) AS count_week,
                    COUNT( * ) AS count_total
                    FROM return_notes r
                    LEFT OUTER JOIN users u ON r.manager_id = u.user_id
                    WHERE u.company_id = $companyId";                   
        $sql = $connection->query($query);
        if($row = $sql->fetch_object()){
            return array("count_day" => $row->count_day, "count_week" => $row->count_week, "count_month" => $row->count_month, "count_total" => $row->count_total,);
        }
    }
    
    function numberOfRefundsByComm($companyId, $commodityId){
        global $connection;
        $day = (new DateTime())->format('Y-m-d');
        $month = (new DateTime())->format('Y-m');
        $query = "SELECT 
                    COUNT( CASE WHEN r.return_date LIKE  '$day%' THEN 1 END ) AS count_day, 
                    COUNT( CASE WHEN r.return_date LIKE  '$month%' THEN 1 END ) AS count_month, 
					COUNT( CASE WHEN YEARWEEK(r.return_date, 1) = YEARWEEK(CURDATE(), 1) THEN 1 END) AS count_week,
                    COUNT( * ) AS count_total
                    FROM return_notes r
                    LEFT OUTER JOIN users u ON r.manager_id = u.user_id
                    WHERE u.company_id = $companyId AND r.commodity_id = $commodityId";                   
        $sql = $connection->query($query);
        if($row = $sql->fetch_object()){
            return array("count_day" => $row->count_day, "count_week" => $row->count_week, "count_month" => $row->count_month, "count_total" => $row->count_total,);
        }
    }

    function getSaleByComm($companyId, $commodityId){
        global $connection;
        $query = "SELECT *, cl.name AS client_name, cl.surname AS client_surname, comm.name AS comm_name 
                    FROM sales s 
                    LEFT OUTER JOIN users u ON s.manager_id = u.user_id
                    LEFT OUTER JOIN clients cl ON s.client_id = cl.client_id
                    LEFT OUTER JOIN commodities comm ON s.commodity_id = comm.commodity_id
                    WHERE u.company_id = $companyId AND s.commodity_id = $commodityId";                  
        $sql = $connection->query($query);
        $sales = array();
        while($row = $sql->fetch_object()){
            $sales[$row->sale_id] = array("manager" => $row->login, "client" => $row->client_name." ".$row->client_surname,
                                "quantity" => $row->quantity, "date" => $row->date);
        }
        return $sales;
    }
    
    function getRefundByComm($companyId, $commodityId){
        global $connection;
        $query = "SELECT c.name AS client_name, c.surname AS client_surname, u.login AS manager,
                    r.return_date,  s.quantity, r.return_id   
                    FROM return_notes r
                    LEFT OUTER JOIN sales s ON r.sale_id = s.sale_id
                    LEFT OUTER JOIN users u ON s.manager_id = u.user_id
                    LEFT OUTER JOIN clients c ON s.client_id = c.client_id
                    WHERE u.company_id = $companyId AND s.commodity_id = $commodityId";
        $sql = $connection->query($query);
        $refunds = array();
        while($row = $sql->fetch_object()){
            $refunds[$row->return_id] = array("client" => $row->client_name." ".$row->client_surname, 
                                        "quantity" => $row->quantity, "date" => $row->return_date, "manager" => $row->manager); 
        }
        return $refunds;
    }
   
    function getClientsData($companyId){
        global $connection;
        $query = "SELECT c.client_id AS client, c.name AS client_name, c.surname AS client_surname, 
                	COUNT(s.sale_id) AS purchases, COUNT(r.return_id) AS refunds, SUM(s.price) AS total 
                	FROM clients c
                	LEFT OUTER JOIN sales s ON c.client_id = s.client_id
                	LEFT OUTER JOIN return_notes r ON s.sale_id = r.sale_id
                	WHERE c.company_id = $companyId
                	GROUP BY client_name, client_surname";
        $sql = $connection->query($query);
        $data = array();
        while($row = $sql->fetch_object()){
            $data[$row->client] = array("client" => $row->client_name." ".$row->client_surname, "purchases" => $row->purchases, 
                                        "refunds" => $row->refunds, "total" => $row->total);
        }
        return $data;
    }


    function getCallTechClient($clientId){
        global $connection;
        $query = "SELECT t.reason AS reason, t.result AS result, c.name AS commodity_name, u.login AS manager_id
                  FROM tech_support_notes t
                  LEFT OUTER JOIN commodities c ON t.commodity_id = c.commodity_id
                  LEFT OUTER JOIN users u ON t.manager_id = u.user_id
                  WHERE t.client_id = $clientId ";
        echo $query;
        $sql = $connection->query($query);
        $clients = array();
        while($row = $sql->fetch_object()){
            $clients[$row->client_id] = array("commodity_name"=>$row->commodity_name, "login"=>$row->manager_id, "reason"=>$row->reason, "result"=>result);
        }
        return $clients;
    }
    
    function getCallTechCommodity($commodityId){
        global $connection;
        $query = "SELECT t.reason AS reason, t.result AS result, c.name AS client_name, u.login AS manager_id
                  FROM tech_support_notes t
                  LEFT OUTER JOIN clients c ON t.client_id = c.client_id
                  LEFT OUTER JOIN users u ON t.manager_id = u.user_id
                  WHERE t.commodity_id = $commodityId ";
        $sql = $connection->query($query);
        $commodities = array();
        while($row = $sql->fetch_object()){
            $commodities[$row->commodity_id] = array("client_name"=>$row->client_name, "login"=>$row->manager_id, "reason"=>$row->reason, "result"=>result);
        }
        return $commodities;
    }
    function addFirstCallTo($name,$surname,$phone,$commodity_id,$result){
        global $connection;
        $result = $connection->real_escape_string($result);
        $user_id = $_SESSION['user']->user_id;
        $company_id = $_SESSION['user']->company_id;
        $query1 = "INSERT INTO clients (company_id, name, surname, phone_number) VALUES (\"$company_id\",\"$name\",\"$surname\",\"$phone\") ";
        $sql1 = $connection->query($query1);
        $client_id = $connection->insert_id;
        echo $client_id;
        $query2 = "INSERT INTO calls_to_clients (manager_id,client_id,commodity_id,result) VALUES (\"$user_id\",\"$client_id\",\"$commodity_id\",\"$result\")";
        $sql = $connection->query($query2);
    }
    function addSecondCallTo($client_id,$commodity_id,$result){
        global $connection;
        $result = $connection->real_escape_string($result);
        $user_id = $_SESSION['user']->user_id;
        $query = "INSERT INTO calls_to_clients (manager_id,client_id,commodity_id,result) VALUES (\"$user_id\",\"$client_id\",\"$commodity_id\",\"$result\")";
        $sql = $connection->query($query);
    }
    function addFirstCallFrom($name,$surname,$phone,$reason,$result){
        global $connection;
        $reason = $connection->real_escape_string($reason);
        $result = $connection->real_escape_string($result);
        $user_id = $_SESSION['user']->user_id;
        $company_id = $_SESSION['user']->company_id;
        $query1 = "INSERT INTO clients (company_id, name, surname, phone_number) VALUES (\"$company_id\",\"$name\",\"$surname\",\"$phone\") ";
        $sql1 = $connection->query($query1);
        $client_id = $connection->insert_id;
        $query2 = "INSERT INTO calls_to_managers (client_id,manager_id,reason,result) VALUES (\"$client_id\",\"$user_id\",\"$reason\",\"$result\")";
        $sql = $connection->query($query2);
    }
    function addSecondCallFrom($client_id,$reason,$result){
        global $connection;
        $reason = $connection->real_escape_string($reason);
        $result = $connection->real_escape_string($result);
        $user_id = $_SESSION['user']->user_id;
        $query = "INSERT INTO calls_to_managers (client_id,manager_id,reason,result) VALUES (\"$client_id\",\"$user_id\",\"$reason\",\"$result\")";
        $sql = $connection->query($query);
    }
    
    function add_tech_support_notes($client_id,$reason,$result,$commodity_id){
        global $connection;
        $reason = $connection->real_escape_string($reason);
        $result = $connection->real_escape_string($result);
        $managerId = $_SESSION['user']->user_id;
        $query = "INSERT INTO tech_support_notes (client_id, manager_id, commodity_id, reason, result) VALUES (\"$client_id\",\"$managerId\",\"$commodity_id\",\"$reason\",\"$result\") ";
        $sql = $connection->query($query);
    }
    function call_rejected($client_id,$manager_id,$reason){
        global $connection;
        $reason = $connection->real_escape_string($reason);
        $user_id = $_SESSION['user']->user_id;
        $query = "INSERT INTO calls (client_id,manager_id,switched_manager_id,rejected,rejection_reason) VALUES (\"$client_id\",\"$user_id\",\"$manager_id\",1,\"$reason\")";
        $sql = $connection->query($query);
    }
    function call_not_rejected($client_id,$manager_id){
        echo "v func";
        global $connection;
        $user_id = $_SESSION['user']->user_id;
        $query = "INSERT INTO calls (client_id,manager_id,switched_manager_id,rejected) VALUES (\"$client_id\",\"$user_id\",\"$manager_id\",0)";
        $sql = $connection->query($query);
    }
    
    function getSalesReport($companyId){
        global $connection;
        $query = "SELECT *, cl.name AS client_name, cl.surname AS client_surname, comm.name AS comm_name 
                    FROM sales s 
                    LEFT OUTER JOIN users u ON s.manager_id = u.user_id
                    LEFT OUTER JOIN clients cl ON s.client_id = cl.client_id
                    LEFT OUTER JOIN commodities comm ON s.commodity_id = comm.commodity_id
                    WHERE u.company_id = $companyId";
        $sql = $connection->query($query);
        $sales = array();
        while($row = $sql->fetch_object()){
            $sales[$row->sale_id] = array("manager" => $row->login, "client" => $row->client_name." ".$row->client_surname, "commodity" => $row->comm_name, 
                    "price" => $row->price, "quantity" => $row->quantity, "date" => $row->date, "address" => $row->address);
        }
        return $sales;
    }
    
    function getTechSuppReport($companyId){
        global $connection;
        $query = "SELECT *, cl.name AS client_name, cl.surname AS client_surname, comm.name AS comm_name
                    FROM tech_support_notes t
                    LEFT OUTER JOIN users u ON t.manager_id = u.user_id 
                    LEFT OUTER JOIN clients cl ON t.client_id = cl.client_id
                    LEFT OUTER JOIN commodities comm ON t.commodity_id = comm.commodity_id
                    WHERE u.company_id = $companyId";
        $sql = $connection->query($query);
        $techs = array();
        while($row = $sql->fetch_object()){
            $techs[$row->tech_support_note_id] = array("manager" => $row->login, "client" => $row->client_name." ".$row->client_surname, "commodity" => $row->comm_name,
            "reason" => $row->reason, "result" => $row->result);
        }
        return $techs;
    }
    
    function getQualityReport($companyId){
        global $connection;
        $query = "SELECT *, cl.name AS client_name, cl.surname AS client_surname, comm.name AS comm_name
                    FROM quality_notes q
                    LEFT OUTER JOIN users u ON q.manager_id = u.user_id 
                    LEFT OUTER JOIN clients cl ON q.client_id = cl.client_id
                    LEFT OUTER JOIN commodities comm ON q.commodity_id = comm.commodity_id
                    WHERE u.company_id = $companyId";
        $sql = $connection->query($query);
        $qualities = array();
        while($row = $sql->fetch_object()){
            $qualities[$row->quality_note_id] = array("manager" => $row->login, "client" => $row->client_name." ".$row->client_surname, "commodity" => $row->comm_name,
            "reason" => $row->reason);
        }
        return $qualities;
    }
    
    function getCallsReport($companyId){
        global $connection;
        $query = "SELECT *, cl.name AS client_name, cl.surname AS client_surname, m.login AS manager, sm.login AS switch_manager
                    FROM calls c
                    LEFT OUTER JOIN users m ON c.manager_id = m.user_id 
                    LEFT OUTER JOIN users sm ON c.switched_manager_id = sm.user_id 
                    LEFT OUTER JOIN clients cl ON c.client_id = cl.client_id
                    WHERE m.company_id = $companyId";
        $sql = $connection->query($query);
        $calls = array();
        while($row = $sql->fetch_object()){
            $calls[$row->call_id] = array("manager" => $row->manager, "client" => $row->client_name." ".$row->client_surname, "switched" => $row->switch_manager,
            "rejected" => $row->rejected, "reason" => $row->rejection_reason);
        }
        return $calls;
    }
    
    
    function getCategoriesForMenu(){
        global $connection;
        $query = "SELECT category_id, name FROM categories WHERE active = 1";
        $sql = $connection->query($query);
        $categoryNames = array();
        while($row = $sql->fetch_object()){
            $categoryNames[$row->category_id] = $row->name;    
        }
        return $categoryNames;
    }
    
    function getCommoditiesOnCategories($categoryId){
        global $connection;
        $query = "SELECT com.name AS com_name, com.price AS com_price,com.commodity_id AS commId 
                  FROM commodities com 
                  LEFT OUTER JOIN categories cat 
                  ON com.category_id = cat.category_id
                  WHERE com.category_id = $categoryId ";
        $sql = $connection->query($query);
        $commodities = array();
        while($row=$sql->fetch_object()){
            $commodities[$row->commId] = array('name'=>$row->com_name, 'price'=>$row->com_price);
        }
        return $commodities;
    }
    
    function getAllCommodities(){
        global $connection;
        $query = "SELECT name, price, commodity_id FROM commodities WHERE active=1";
        $sql = $connection->query($query);
        $allCommodities = array();
        while($row=$sql->fetch_object()){
            $allCommodities[$row->commodity_id] = array('name'=>$row->name, 'price'=>$row->price);
        }
        return $allCommodities;
    }
    
?>