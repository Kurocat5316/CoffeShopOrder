<?php
    include "db_conn.php";

    $user = $_POST["user"];

    
    $query = "Delete from users WHERE username = '$user'";
    $mysqli->query($query);

    $mysqli->close();
    
?>