<?php
	session_start();
    include "db_conn.php";

    $id = $_POST["id"];
    $oldName = $_POST["oldName"];
    $name = $_POST["name"];
    $price = $_POST["$price"];
    $type = $_POST["type"];
    $fun = $_POST["fun"];
    
    $query = "select * from items where name = '$name'";
	$result = $mysqli->query($query);
	if($result->num_rows <= 0){
        $query = "UPDATE items SET name = '$name', number='$price', type = '$type' WHERE id = $id";
        if($mysqli->query($query))
            echo "Change Successful!";
        else
            echo "$query";  

        $mysqli->close();

        $target_dir = "../img/Total/";

        $oldN = $target_dir . "$oldName.jpg";
        $newN = $target_dir . "$name.jpg";

        if($fun === '0')
            rename($oldN, $newN);
        else{
            unlink($oldN);


            // Check if $uploadOk is set to 0 by an error

            if (move_uploaded_file($_FILES["file"]["tmp_name"], $newN)) {
                   echo "";
            } else {
                 echo " Sorry, there was an error uploading your file.";
            }

        }
    
    }else{
    	echo "Sorry, The item name already exist!";
    }
?>