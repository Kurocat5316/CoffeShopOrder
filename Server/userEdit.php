<?php
    include "db_conn.php";

    $user = $_POST["user"];
    $position = $_POST["position"];

    
    $query = "UPDATE users SET position = '$position' WHERE username = '$user'";
    if($mysqli->query($query))
        echo "Change Successful!";
    else
        echo "False!";

    $mysqli->close();
    
?>