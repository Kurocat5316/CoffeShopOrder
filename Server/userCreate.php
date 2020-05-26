<?php

$user = $_POST['user'];
$position = $_POST['position'];
$pwd = "123456";
$hash = crypt($pwd, 100);

include "db_conn.php";

$query = "select * from users where username = '$user'";
$result = $mysqli->query($query);
if($result->num_rows <= 0){

$query = "INSERT INTO users (`username`, `password`, `position`) VALUES ('$user','$hash','$position')";
    if($mysqli->query($query))
        echo "Insert Successful! The initial password is 123456";
    else
        echo "False!";

    $mysqli->close();
    }
    else{
    	echo "The user name already exist!";
    }

?>