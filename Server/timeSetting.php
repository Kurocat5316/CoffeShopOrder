<?php
    

    $action = $_POST["action"];
    $restaurant = $_POST["restaurant"];
    $time = $_POST["time"];
    
    switch($action){
        case "open": OpenTime($restaurant, $time); break;
        case "close": CloseTime($restaurant, $time); break;
    }

    
    
    function OpenTime($restaurant, $time){ $query = "UPDATE restaurant SET openTime = '$time' WHERE Id = '$restaurant'"; writeIn($query);}
    function CloseTime($restaurant, $time){ $query = "UPDATE restaurant SET closeTime = '$time' WHERE Id = '$restaurant'"; writeIn($query);}

    function writeIn($query){
        include "db_conn.php";
        $mysqli->query($query);
        $mysqli->close();
    }

    
    
?>