<?php
  session_start();
  
  require "init/db.php";
  require "functions.php";

	$page = "home";
	$online = false;
	
	setStatus();
	setPage();
	
	if(isset($_GET['act'])){
	  
	  if($_GET['act'] == "login"){
	      if(isset($_POST['login']) && isset($_POST['pwd'])){
	          logIn($_POST['login'], $_POST['pwd']);
	      } else {
	        header("Location:?page=login&err=404");
	      }
	  } else if($_GET['act'] == "logout"){
	      logout();
	  } else if($_GET['act'] == "reg"){
	      if(isset($_POST['company_name']) && isset($_POST['login']) && isset($_POST['pwd']) && isset($_POST['re_pwd'])){
	        $result = signUp($_POST['company_name'], $_POST['login'], $_POST['pwd'], $_POST['re_pwd']);
	        if(isset($result->error)){
	          header("Location:?page=registration&err=$result->error");
	        } else {
	          logIn($_POST['login'], $_POST['pwd']);
	        }
	      } else{
	        header("Location:page=reg&err=404");
	      }
	  } else if($_GET['act']=='add_category'){
	        if(isset($_POST['name'])){
	            addCategory($_POST['name']);
	        }
	  } else if($_GET['act']=='add_commodity'){
	      if(isset($_POST['categoryId']) && isset($_POST['name']) && isset($_POST['price'])){
	          addCommidity($_POST['categoryId'], $_POST['name'], $_POST['price']);
	      }
	  } /*else if($_GET['act']=='add_manager'){
	      if(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['repassword']) && isset($_POST['type'])){
	         addManager($_POST['login'],$_POST['password'],$_POST['repassword'], $_POST['type']);
	      }
	  } */else if($_GET['act']=='edit_category'){
	      if(isset($_POST['category_id']) && isset($_POST['name'] )){
	          editCategory($_POST['category_id'], $_POST['name']);
	      }
	  } else if($_GET['act']=='edit_manager'){
	      if(isset($_POST['manager_id']) && isset($_POST['login']) && isset($_POST['password']) && isset($_POST['repassword']) && isset($_POST['type'])){
	          editManager($_POST['manager_id'], $_POST['login'], $_POST['password'], $_POST['repassword'], $_POST['type']);
	      }
	  } else if($_GET['act']=='edit_commodity'){
	       if(isset($_POST['commodity_id']) && isset($_POST['name']) && isset($_POST['price']) && isset($_POST['categoryId'])){
	         editCommodity($_POST['commodity_id'],$_POST['name'], $_POST['price'], $_POST['categoryId']);    
	       }
	  } else if($_GET['act']=='delete_manager'){
	      if(isset($_POST['manager_id'])){
	          deleteManager($_POST['manager_id']);
	      }
	  } else if($_GET['act']=='delete_category'){
	      if(isset($_POST['category_id'])){
	          deleteCategory($_POST['category_id']);
	      }
	  } else if($_GET['act']=='delete_commodity'){
	      if(isset($_POST['commodity_id'])){
	          deleteCommodity($_POST['commodity_id']);
	      }
	  } else if($_GET['act']=='block_manager'){
	      if(isset($_POST['manager_id'])){
	          blockManager($_POST['manager_id']);
	      }
	  } else if($_GET['act']=='unblock_manager'){
	      if(isset($_POST['manager_id'])){
	          unblockManager($_POST['manager_id']);
	      }
	  } else if($_GET['act']=='add_sales'){
	      if(isset($_POST['client_id']) && isset($_POST['commodity_id']) && isset($_POST['price']) && isset($_POST['quantity']) && isset($_POST['address'])){
	          addSales($_POST['client_id'],$_POST['commodity_id'],$_POST['price'],$_POST['quantity'],$_POST['address']);
	      }
	  } else if($_GET['act']=='add_quality_notes'){
	      if(isset($_POST['client_id']) && isset($_POST['reason']) && isset($_POST['commodity_id'])){
	          addQualityNotes($_POST['client_id'], $_POST['reason'], $_POST['commodity_id']);
	      }
	  }else if($_GET['act']=='add_tech_support_notes'){
	  	if(isset($_POST['client_id']) && isset($_POST['problem']) && isset($_POST['solution']) && isset($_POST['commodity_id'])){
	  		add_tech_support_notes($_POST['client_id'],$_POST['problem'],$_POST['solution'],$_POST['commodity_id']);
	  		header("LOcation:?page=tech_support");
	  	}
	  } else if($_GET['act']=='addCallTo'){
		  if(isset($_POST['client_id']) && $_POST['client_id']=='noName'){
	  		if(isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['phone']) && isset($_POST['commodity_id']) && isset($_POST['result'])){
	  			addFirstCallTo($_POST['name'], $_POST['surname'], $_POST['phone'], $_POST['commodity_id'], $_POST['result']);
	  			header("Location:?page=sales&table=callsTo");
	  		}
		  }else if(isset($_POST['client_id']) && $_POST['client_id']!='noName'){
		  	if(isset($_POST['client_id']) && isset($_POST['commodity_id']) && isset($_POST['result'])){
	  			addSecondCallTo($_POST['client_id'], $_POST['commodity_id'], $_POST['result']);
	  			header("Location:?page=sales&table=callsTo");
	  		}
		  }else{
		  	echo "error";
		  }
	  }else if($_GET['act']=='addCallFrom'){
	  	 if(isset($_POST['client_id']) && $_POST['client_id']=='noName'){
	  		if(isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['phone']) && isset($_POST['reason']) && isset($_POST['result'])){
	  			addFirstCallFrom($_POST['name'],$_POST['surname'],$_POST['phone'],$_POST['reason'],$_POST['result']);
	  			header("Location:?page=sales&table=callsFrom");
	  		}
		  }else if(isset($_POST['client_id']) && $_POST['client_id']!='noName'){
		  	if(isset($_POST['client_id']) && isset($_POST['reason']) && isset($_POST['result'])){
	  			addSecondCallFrom($_POST['client_id'],$_POST['reason'],$_POST['result']);
	  			header("Location:?page=sales&table=callsFrom");
	  		}
		  }else{
		  	echo "Error";
		  }
	  }else if($_GET['act']=='addCallsManager'){
	  	if(isset($_POST['rejected'])){
	  		if(isset($_POST['client_id']) && isset($_POST['manager_id']) && isset($_POST['reason'])){
	  			call_rejected($_POST['client_id'],$_POST['manager_id'],$_POST['reason']);
	  			header("Location:?page=calls");
	  		}
	  	}else{
	  		if(isset($_POST['client_id']) && isset($_POST['manager_id'])){
	  			call_not_rejected($_POST['client_id'],$_POST['manager_id']);
	  			header("Location:?page=calls");
	  		}
	  	}
	  }else if($_GET['act']=='add_return'){
	  	if(isset($_POST['sale_id']) && isset($_POST['reason'])){
	  		add_return($_POST['sale_id'],$_POST['reason']);
	  		header("Location:?page=tech_support");
	  	}
	  }
	  
	  
	}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
      <title>E-shop</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <!-- Latest compiled and minified JavaScript -->
      <script src="http://code.jquery.com/jquery-1.11.3.js "></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>
    <body>

	      <?php
	      	require "templates/menu.php";
	      ?>
	      
	       <?php
	      	require "modules/$page.php";
	      ?>
    </body>
</html>

