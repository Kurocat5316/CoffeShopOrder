<?php
session_start();

$itemId = $_POST["id"];
$restaurant = $_SESSION["role"];

include 'db_conn.php';

$query = "DELETE from itemList Where itemId = $itemId and restaurant = $restaurant  ";
if($mysqli->query($query))
        echo "Change Successful! ";
    else
        echo "False!";
?>