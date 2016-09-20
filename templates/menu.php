        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <div class="navbar-header">
              <a class="navbar-brand" href="#">E-shop</a>
            </div>
            <ul class="nav navbar-nav">
              <li class="active"><a href="?page=home">Home</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              
              <?php
                if($online){
              ?>
              <li><a href="?page=logout"><span class=" "></span>Log out</a></li>
              <?php
                } else{
              ?> 
                <li><a href="?page=registration"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                <li><a href="?page=login"><span class="glyphicon glyphicon-log-in"></span> Log in</a></li>
              <?php
              }
            ?>
            </ul>
          </div>
        </nav>
