<?php
session_start();

include "db_conn.php";

    $id = $_POST["id"];
    $name = $_POST["name"];
    
    $query = "DELETE FROM items WHERE id = $id";
    if($mysqli->query($query))
        echo "Delete Successful!";
    else
        echo "False!";

    $mysqli->close();

    $target_dir = "../img/Total/";

    $target_dir = $target_dir . "$name.jpg";

    unlink($target_dir);
?>