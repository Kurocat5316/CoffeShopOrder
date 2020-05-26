<?php
	session_start();

    include "db_conn.php";

    $name = $_POST["name"];
    $price = $_POST["price"];
    $type = $_POST["type"];
    $role = $_SESSION["role"];
    
    $query = "select * from items where name = '$name'";
$result = $mysqli->query($query);
if($result->num_rows <= 0){
    
    $query = "INSERT INTO items (`name`, `price`, `type`) VALUES ('$name', '$price', '$type')";
    if($mysqli->query($query))
        echo "Change Successful! ";
    else
        echo "False!";

    $mysqli->close();

    $target_dir = "../img/Total/";
    	
	$target_file = $target_dir . "$name.jpg";
    echo $target_file;
	$uploadOk = 1;

// Check if file already exists
	if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
	}

// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
	        echo " The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
	    } else {
  	      echo "Sorry, there was an error uploading your file.";
 	   }
	}
	
	}else{
		echo "Change faile, The item name already exist!";
	}
	
    
?>