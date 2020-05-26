<?php
session_start();

include 'db_conn.php';

$recharge = $_POST["recharge"];
$_SESSION["account"] = $_SESSION["account"] + $recharge;

$query = "UPDATE usersDetail SET account = '" . $_SESSION["account"] . "' WHERE userId = '" . $_SESSION["user"] . "'";

    if($mysqli->query($query))
        echo "Your Recharge Successful!";
    else
        echo "$query";

$mysqli->close();
?>