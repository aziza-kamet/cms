<?php

    $connection = new mysqli("127.0.0.1", "wormhole23", "", "internet_shop");
    
    if($connection->connect_errno) {
        echo "Database connection error";
    }

?>