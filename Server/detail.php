<?php

session_start();
include 'db_conn.php';

$id = $_SESSION["user"];
$name = $_POST["name"];
$address = $_POST["address"];
$city = $_POST["city"];
$address = $_POST["address"];
$postcode = $_POST["postcode"];
$phone = $_POST["phone"];

$query = "UPDATE usersDetail SET name = '$name', address = '$address', city = '$city', address='$address', postcode = '$postcode', phone = '$phone' WHERE userId = '$id'";

$_SESSION["name"] = $name;

if($mysqli->query($query))
    echo "Change Successful!";
else
    echo "Change False!";

?>