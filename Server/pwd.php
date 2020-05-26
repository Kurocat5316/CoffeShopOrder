<?php
include 'db_conn.php';

$account = $_POST["account"];
$pwd = $_POST["pwd"];
$hash = crypt($pwd, 100);

$query = "UPDATE users SET password = '$hash' WHERE username = '$account'";

    if($mysqli->query($query))
        echo true;
    else
        echo false;

$mysqli->close();
?>