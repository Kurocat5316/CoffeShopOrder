<?php
session_start();

$itemId = $_POST["id"];
$restaurant = $_SESSION["role"];

include 'db_conn.php';

$query = "INSERT INTO itemList(itemId, restaurant) VALUES ('$itemId','$restaurant')";
if($mysqli->query($query))
        echo "Change Successful! ";
    else
        echo "False!";
?>