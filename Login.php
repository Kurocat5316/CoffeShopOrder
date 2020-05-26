<?php
    // Start the session
    session_start();
?>

<!DOCTYPE html>
<html>
<header>
	<link rel="stylesheet" type="text/css" href="default.css">
</header>
<body>

<?php
        function Login($role, $user, $account, $name) {
            $_SESSION["role"] = $role;
            $_SESSION["user"] = $user;
            $_SESSION["name"] = $name;
            $_SESSION["account"] = $account;
        }
        
        if (isset($_POST['user'])) {
            Login($_POST['role'], $_POST['user'], $_POST['account'], $_POST['name']);
        }
    ?>


<div class = "background"></div>
<div id = "menu"></div>
    <div class="formPosition">
        <form >
            <h3>Login</h3>
            Account:
            <input type="text" class="account">
            <br>
            Password:
            <input type="password" class="pwd">
            <br><br>
            <?php 
                echo "<div class=\"btn login\">Submit</div>"
            ?>
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
        $("#pwd").remove("active");
        $("#depoit").removeClass("active");
        $("#perInfor").removeClass("active");
        $("#register").removeClass("active");
        $("#login").addClass("active");
    });
    
    $(".login").click(function () {
        var account = $(".account").val();
        var pwd = $(".pwd").val();
        
        $.ajax({ url: 'Server/databaseAccess.php',
                data: { 'action': 'login', 'account': account, 'pwd': pwd },
                type: 'post',
                success: function(position) {
                             console.log(position);
                            if(position === '5')
                                alert("User not exist");
                            else
                                if(position === '6')
                                    alert("Incorrect password!");
                                else{
                                    var res = position.split(" ");
                                    console.log(res[0] + " " + res[1] + " " + res[2]);
                                    $.ajax({ url: 'Login.php',
                                     data: { 'role': res[0], 'user': account, 'account': res[1], 'name': res[2]},
                                     type: 'post',
                                     success: function() {
                                         alert("Successful!");
                                         window.location = "index.php";
                                     }      
                                    });
                                }
                            }
                });
    })
    
</script>

</html>
