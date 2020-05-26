<?php
session_start();

include "db_conn.php";

$user = $_POST["user"];
$items = $_POST["items"];
$total = $_POST["total"];

$query = "select account from usersDetail where userId = '$user'";
$result = $mysqli->query($query);

while($row = $result->fetch_assoc())
    $account = $row["account"];

$account -= $total;
$query = "update usersDetail set account = '$account' where userId = '$user'";
$mysqli->query($query);

$flag1 = false;
$flag2 = false;
$flag3 = false;

$receipt1;
$receipt2;
$receipt3;

$query1 = "insert into receiptDetail (`itemId`, `number`, `receptId`, `takeTime`, `comment`) values";
$query2 = "insert into receiptDetail (`itemId`, `number`, `receptId`, `takeTime`, `comment`) values";
$query3 = "insert into receiptDetail (`itemId`, `number`, `receptId`, `takeTime`, `comment`) values";

$dt = date("Y/m/d");

foreach($items as $item){
    if($item[restaurant] === "1"){
        if(!$flag1){
            $flag1 = !$flag1;
            $temp = "INSERT INTO `receipt` (`restaurant`, `userId`, `date`) VALUES ('1','$user','$dt')";
            $mysqli->query($temp);
            $temp = "select id from receipt where restaurant = '1' && userId = '$user' ORDER BY id DESC LIMIT 1";
            $result = $mysqli->query($temp);
            while($row = $result->fetch_assoc())
                $receipt1 = $row["id"];
        }
        $query1 .= "('$item[id]', '$item[number]', '$receipt1', '$item[collectTime]', '$item[comment]'), ";
    }
    
    if($item[restaurant] === "2"){
        if(!$flag2){
            $flag2 = !$flag2;
            $temp = "INSERT INTO `receipt` (`restaurant`, `userId`, `date`) VALUES ('2','$user','$dt')";
            $mysqli->query($temp);
            $temp = "select id from receipt where restaurant = '2' && userId = '$user' ORDER BY id DESC LIMIT 1";
            $result = $mysqli->query($temp);
            while($row = $result->fetch_assoc())
                $receipt2 = $row["id"];
        }
        $query2 .= "('$item[id]', '$item[number]', '$receipt2', '$item[collectTime]', '$item[comment]'), ";
    }
    
    if($item[restaurant] === "3"){
        if(!$flag3){
            $flag3 = !$flag3;
            $temp = "INSERT INTO `receipt` (`restaurant`, `userId`, `date`) VALUES ('3','$user','$dt')";
            $mysqli->query($temp);
            $temp = "select id from receipt where restaurant = '3' && userId = '$user' ORDER BY id DESC LIMIT 1";
            $result = $mysqli->query($temp);
            while($row = $result->fetch_assoc())
                $receipt3 = $row["id"];
        }
        $query3 .= "('$item[id]', '$item[number]', '$receipt3', '$item[collectTime]', '$item[comment]'), ";
    }
}

$query1=rtrim($query1,", ");
$query2=rtrim($query2,", ");
$query3=rtrim($query3,", ");

if($flag1){
    $mysqli->query($query1);
}
if($flag2){
    $mysqli->query($query2);
}
if($flag3){
    $mysqli->query($query3);
}

$mysqli->close();

$_SESSION["account"] = $account;
?>