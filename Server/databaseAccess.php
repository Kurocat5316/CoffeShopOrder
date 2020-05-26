<?php 
    
        $action = $_POST['action'];
        switch($action){
            case 'login': $result = Login($_POST['account'], $_POST['pwd']); break;
            case 'register': $result = register($_POST['account'], $_POST['pwd'], $_POST['address'], $_POST['city'], $_POST['state'], $_POST['postcode'], $_POST['phone']); break;
        }
        
        //$result = $_POST['account'];
        
        echo $result;
    
        function Register($account, $pwd, $address, $city, $state, $postcode, $phone){
            include 'db_conn.php';
            
            $query = "select * from users where username = '$account'";
            $result = $mysqli->query($query);
            
            if($result->num_rows <= 0){
            
         	   $hash = crypt($pwd, 100);
       	     $role = $_POST["role"];
            
       	     if($role === '1')
       	         $query = "INSERT INTO `users` (`username`, `password`, `position`) VALUES ('$account', '$hash', '4')";
       	     else
       	         $query = "INSERT INTO `users` (`username`, `password`, `position`) VALUES ('$account', '$hash', '44')";
       	     $mysqli->query($query);
            
       	     $query = "INSERT INTO `usersDetail` (`userId`, `name`, `account`, `address`, `city`, `state`, `postcode`, `phone`) VALUES ('$account', '$account', '', '$address', '$city', '$state', '$postcode', '$phone')";
       	     $mysqli->query($query);
            
       	     $mysqli->close();

        	    if($role === '1')
       	         echo '4';
       	     else
       	         echo '44';
            }
            else{
            	return "3";
            }
        }

        function Login($account, $pwd){
            include 'db_conn.php';
            $hash = crypt($pwd, 100);
            
            $query = "Select * From users Where username = '$account'";
            $result = $mysqli->query($query);
            
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc())
                    if($row["password"] === $hash){
                        $position = $row["position"];
                        
                        $query = "Select * From usersDetail Where userId = '$account'";
                        $result2 = $mysqli->query($query);
                        while($row2 = $result2->fetch_assoc()){
                            $money = $row2["account"];
                            $name = $row2["name"];
                        }
                        $mysqli->close();
                        echo "$position" . " " . "$money" . " " . "$name";
                    }
                    else{
                        $mysqli->close();
                        return "6";
                    }
            }else{
                $mysqli->close();
                return "5";
            }
            
        }
?>