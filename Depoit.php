<?php
session_start();
if(empty( $_SESSION["role"]))
   header("Location: Login.php");
if($_SESSION["role"] != '44')
    if($_SESSION["role"] != '4')
        if($_SESSION["role"] != '11')
            if($_SESSION["role"] != '22')
                if($_SESSION["role"] != '33')
                    header("Location: index.php");
?>

<!DOCTYPE html>
<html>
<header>
	<link rel="stylesheet" type="text/css" href="default.css">
</header>
<body>
<div class = "background"></div>
<div id = "menu"></div>
    <div class="formPosition">
        <form>
            <h3>Account</h3>
            Account: <?php echo $_SESSION["account"]; ?><br>
            Recharge: <input type="number" id="money"><br><br>

            <div class="btn recharge">Recharge</div>
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
        $("#orderList").remove("active");
        $("#pwd").remove("active");
        $("#depoit").addClass("active");
        $("#perInfor").removeClass("active");
        $("#register").remove("active");
        $("#login").removeClass("active");
    });
    
    $(".recharge").click(function () {
        var money = $("#money").val();
        console.log(money);
        
        $.ajax({ url: 'Server/Depoit.php',
                data: {'recharge': money },
                type: 'post',
                success: function(data) {
                            alert(data);
                            window.location = "index.php";
                         }
            });
    })
</script>