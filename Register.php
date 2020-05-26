<!DOCTYPE html>
<html>
<header>
	<link rel="stylesheet" type="text/css" href="default.css">
</header>
<body>
<div class = "background"></div>
<div id = "menu"></div>
    <div class="formPosition2">
        <form>
            <h3 style="text-align: center">Register</h3>
                <label id = 'in'>Account: </label><br><input type="text" id="account" name='right'><br>
                <label id = 'in'>Password: </label><br><input type="password" id="pwd" name='right'><br>
                <label id = 'in'>Password Confirm: </label><br><input type="password" id="pwdCheck" name='right'><br>
                <label id = 'in'>Address: </label><br><input type="text" id = "address" name='right'><br>
                <label id = 'in'>City: </label><br><input type = "text" id = "city" name='right'><br>
                <label id = 'in'>State: </label><br><input type = "text" id = "state" name='right'><br>
                <label id = 'in'>Postcode: </label><br><input type = "number" id = "postcode" name='right'><br>
                <label id = 'in'>Phone: </label><br><input type = "number" id = "phone" name='right'><br><br>
            <div id="tip"></div>
            <select id = "role" style="margin-left:40%">
                <option value="1" selected>Normal user</option>
                <option value="2">Student</option>
            </select>
            <br><br>
            
            <label class="btn register" style="margin-left:45%">Submit</label>
            <br><br>
            <p style="text-align: center">Password must own 8 - 6 charactors <br> At least a low case letter, uppercase letter, a number and a charactors</p>
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
        $("#register").addClass("active");
        $("#login").removeClass("active");
    });

    $(".register").click(function () {
        var account = $("#account").val();
        var pwd = $("#pwd").val();
        var pwdCheck = $("#pwdCheck").val();
        var address = $("#address").val();
        var city = $("#city").val();
        var state = $("#state").val();
        var postcode = $("#postcode").val();
        var phone = $("#phone").val();
        var role = $("#role").val();
        console.log(role);

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
                        
                        $.ajax({ url: 'Server/databaseAccess.php',
                                     data: { 'action': 'register', 'account': account, 'pwd': pwd, 'address': address, 'city': city, 'state': state, 'postcode': postcode, 'phone':phone, 'role':role},
                                     type: 'post',
                                     success: function(flag) {
                                                console.log(flag);
                                                  if(flag != '3'){
                                                      	alert("Register successful!");
                                                      


                                    					$.ajax({ url: 'Login.php',
                                     					data: { 'role': flag, 'user': account, 'account': 0, 'name': account},
                                     					type: 'post',
                                     					success: function() {
                                    					     window.location = "index.php";
                                   							  }      
                                   				 		});
                                                      }
                                                    else
                                                    	if(flag === '3')
                                                    		alert("The Account Name already exist.");
                                                    	else
                                                        	alert("Register false!");
                                              }
                            });
                        
                        
                    }
    })
</script>

</html>
