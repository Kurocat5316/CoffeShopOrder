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
<div class = "background"></div>
<div id = "menu"></div>
    <div class="formPosition">
        <form>
            <h3>Change Password</h3>
            New PassWord:
            <input type="password" id="npwd"><br><br>
            Retype New PassWord:
            <input type="password" id="pwdCheck"><br><br>
            <br>
            <div id="tip"></div>
            <br>
            <label class="btn register">Submit</label>
            <br><br>
            <p>Password must own 8 - 6 charactors <br> At least a low case letter, uppercase letter, a number and a charactors</p>
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
        $("#pwd").addClass("active");
        $("#depoit").removeClass("active");
        $("#perInfor").removeClass("active");
        $("#register").remove("active");
        $("#login").removeClass("active");
    });

    $(".register").click(function () {
        var account = <?php session_start(); echo "'". $_SESSION["user"] . "'"; ?>;
        var pwd = $("#npwd").val();
        var pwdCheck = $("#pwdCheck").val();
        console.log(pwd);
        console.log(pwdCheck);

        if (account.length == 0) {
            $("#tip").html("Empty Account");
            return;
        }

        if (pwd.length < 8) {
            $("#tip").html("The password too short");
            return;
        }

        if (pwd.length > 16) {
            $("#tip").html("The password too long");
            return;
        }

        if (pwd.length == 0) {
            $("#tip").html("Empty Passowrd");
            return;
        }

        if (pwd != pwdCheck) {
            $("#tip").html("Different Password");
            return;
        }

        var ex = /[^a-z,A-Z,0-9,~!#$]/
        var lowCase = /[a-z]/;
        var upperCase = /[A-Z]/;
        var num = /[0-9]/
        var spe = /[~!#$]/

        if (ex.test(pwd)) {
            $("#tip").html("Password contain illegal charactors");
            return;
        }

        if (!lowCase.test(pwd)) {
            $("#tip").html("Password should contain at least a lowcase charactor");
            return;
        } else
            if (!upperCase.test(pwd)) {
                $("#tip").html("Password should contain at least a uppercase charactor");
                return;
            } else
                if (!num.test(pwd)) {
                    $("#tip").html("Password should contain at least a number");
                    return;
                } else
                    if (!spe.test(pwd)) {
                        $("#tip").html("Password should contain at least a special charactor (~!#$)");
                        return;
                    } else {
                        
                        $.ajax({ url: 'Server/pwd.php',
                                     data: {'account': account, 'pwd': pwd },
                                     type: 'post',
                                     success: function(flag) {
                                                  if(flag === '1'){
                                                      alert("Change successful!");
                                                      window.location = "index.php";
                                                  }
                                                    else
                                                        alert("Change false!");
                                              }
                            });
                        
                        
                    }
    })
</script>