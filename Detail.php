<?php
session_start();
if(empty( $_SESSION["role"]))
   header("Location: Login.php");
?>

<!DOCTYPE html>
<html>
<header>
	<link rel="stylesheet" type="text/css" href="default.css">
</header>
<body>
    
<?php

    class user{
        public $id,
        $name,
        $address,
        $city,
        $state,
        $postcode,
        $phone;

        function __construct($id, $name, $address, $city, $state, $postcode, $phone){
            $this->id = $id;
            $this->name = $name;
            $this->address = $address;
            $this->city = $city;
            $this->postcode = $postcode;
            $this->phone = $phone;
        }
    }
    
    include 'db_conn.php';
    
    $query = "SELECT * FROM usersDetail WHERE userId = '" . $_SESSION["user"] . "'";
    $result = $mysqli->query($query);
    //echo $sql;
    
    
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()){
            $user = new user($_SESSION["user"], $row["name"], $row["address"], $row["city"], $row["state"], $row["postcode"], $row["phone"]);
        }
    }else
        echo false;
    
    $mysqli->close();
?>
    
    
    
    
<div class = "background"></div>
<div id = "menu"></div>
    <div class="formPosition2">
        <form>
            <h3 style="text-align: center">Detail</h3>
            <label id = 'in'>Name: </label><br><input type="text" id="name" name="right" value = "<?php echo $user->name;  ?>" ><br>
            <label id = 'in'>Address: </label><br><input type="text" id="address" name="right" value = "<?php echo $user->address;  ?>" ><br>
            <label id = 'in'>City: </label><br><input type="text" id="city" name="right" value = "<?php echo $user->city;  ?>" ><br>
            <label id = 'in'>State: </label><br><input type="text" id="state" name="right" value = "<?php echo $user->state;  ?>" ><br>
            <label id = 'in'>Post Code: </label><br><input type="text" id="postcode" name="right" value = "<?php echo $user->postcode;  ?>" ><br>
            <label id = 'in'>Phone: </label><br><input type="text" id="phone" name="right" value = "<?php echo $user->phone;  ?>" ><br><br><br>
            <label class="btn save" style="margin-left: 45%;">Save</label>
            <br><br>
        </form>
    </div>
</body>
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $('#menu').load("Common.php", function () {
        $("#index").removeClass("active");
        $("#lazenbys").removeClass("active");
        $("#ref").removeClass("active");
        $("#trade").removeClass("active");
        $("#trade").removeClass("active");
        $("#management").removeClass("active");
        $("#orderList").removeClass("active");
        $("#pwd").removeClass("active");
        $("#depoit").removeClass("active");
        $("#perInfor").addClass("active");
        $("#register").remove("active");
        $("#login").removeClass("active");
    });
    
    $(".save").click(function () {
        var name = $("#name").val();
        var address = $("#address").val();
        var city = $("#city").val();
        var state = $("#state").val();
        var postcode = $("#postcode").val();
        var phone = $("#phone").val();
        
        $.ajax({ url: 'Server/detail.php',
                data: {'name': name, 'address': address, 'city': city, 'state': state, 'postcode':postcode, 'phone':phone },
                type: 'post',
                success: function(data) {
                            alert(data);
                            window.location = "index.php";
                         }
            });
    })
</script>