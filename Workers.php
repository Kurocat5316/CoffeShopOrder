<?php 
    session_start();
if(empty( $_SESSION["role"]))
   header("Location: Login.php");
if($_SESSION["role"] != '9')
   header("Location: index.php");
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="default.css">
</head>
<body>

<?php
    class user{
        public $user,
        $position;

        function __construct($user, $position){
            $this->id = $user;
            $this->position = $position;
        }
    }
    
    $users = array();
    
    include 'db_conn.php';
    
    $sql = "SELECT * FROM users WHERE position!='4' AND position!='9' order by position";
    $result = $mysqli->query($sql);


    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc())
            array_push($users, new user($row["username"], $row["position"]));
    
    }
            
    $mysqli->close();
    
    $id = 0;
?>
    <div class="background"></div>
    <div id="menu"></div>

    <label class="btn create" onclick = "Create()" style="position:absolute; right: 5%; margin-top: 5%; z-index: 10;">Create</label>

    <div style="position:relative; left: 5%; padding-top: 3%;">

        <h1>Staff</h1>
        <table>
            <tr>
                <th>Name</th>
                <th>Restaurant</th>
                <th></th>
            </tr>
            <?php 
            
                foreach($users as $user){
                        echo "<tr id = \"$id\">
                                <td>$user->id</td>";
                                if($user->position === '1'){
                                    echo "<th><select class = \"edit\">
                                              <option value=\"1\" selected>Lazenbys Manager</option>
                                              <option value=\"2\">The Ref Manager</option>
                                              <option value=\"3\">The Trade Table Manager</option>
                                              <option value=\"11\">Lazenbys Staff</option>
                                              <option value=\"22\">The Ref Staff</option>
                                              <option value=\"33\">The Trade Table Staff</option>
                                            </select></th> ";
                                }else{
                                    if($user->position === '2'){
                                        echo "<th><select class = \"edit\">
                                              <option value=\"1\">Lazenbys Manager</option>
                                              <option value=\"2\" selected>The Ref Manager</option>
                                              <option value=\"3\">The Trade Table Manager</option>
                                              <option value=\"11\">Lazenbys Staff</option>
                                              <option value=\"22\">The Ref Staff</option>
                                              <option value=\"33\">The Trade Table Staff</option>
                                            </select></th> ";
                                    }else{
                                        if($user->position === '3'){
                                        echo "<th><select class = \"edit\">
                                              <option value=\"1\" >Lazenbys Manager</option>
                                              <option value=\"2\">The Ref Manager</option>
                                              <option value=\"3\" selected>The Trade Table Manager</option>
                                              <option value=\"11\">Lazenbys Staff</option>
                                              <option value=\"22\">The Ref Staff</option>
                                              <option value=\"33\">The Trade Table Staff</option>
                                            </select></th> ";
                                        }
                                        else if($user->position === '11'){
                                            echo "<th><select class = \"edit\">
                                              <option value=\"1\" >Lazenbys Manager</option>
                                              <option value=\"2\">The Ref Manager</option>
                                              <option value=\"3\">The Trade Table Manager</option>
                                              <option value=\"11\" selected>Lazenbys Staff</option>
                                              <option value=\"22\">The Ref Staff</option>
                                              <option value=\"33\">The Trade Table Staff</option>
                                            </select></th> ";
                                        }
                                        else{
                                            if($user->position === '22'){
                                                echo "<th><select class = \"edit\">
                                                          <option value=\"1\" >Lazenbys Manager</option>
                                                          <option value=\"2\">The Ref Manager</option>
                                                          <option value=\"3\">The Trade Table Manager</option>
                                                          <option value=\"11\">Lazenbys Staff</option>
                                                          <option value=\"22\" selected>The Ref Staff</option>
                                                          <option value=\"33\">The Trade Table Staff</option>
                                                        </select></th> ";
                                            }
                                            else{
                                                echo "<th><select class = \"edit\">
                                                          <option value=\"1\" >Lazenbys Manager</option>
                                                          <option value=\"2\">The Ref Manager</option>
                                                          <option value=\"3\">The Trade Table Manager</option>
                                                          <option value=\"11\">Lazenbys Staff</option>
                                                          <option value=\"22\">The Ref Staff</option>
                                                          <option value=\"33\" selected>The Trade Table Staff</option>
                                                        </select></th> ";
                                            }
                                        }
                                    }
                                }
                                echo "<td><label class = \"btn delete\">Delete</label></td>
                            </tr>";
                        $id++;
                    }
                echo "</table>";
            ?>
    </div>

    <div id = "create" hidden style="background-color:white; position:fixed; top: 30%; left: 30%; text-align: center; width: 30%">
        
            <div id = "title">Create</div>
            <div>Account: <input name = "account" type = "text" class = "account"></div><br>
            <div>Position:  <select class = "position">
                                    <option value="1" selected>Lazenbys</option>
                                    <option value="2">The Ref</option>
                                    <option value="3">Mercedes</option>
                            </select><br>
            </div><br><br>
            <label class = "btn" onclick = "submit()">submit</label>
            <label class = "btn" onclick = "cancel()">Cancel</label>
            <br><br>
    </div>


</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    var users = <?php echo json_encode($users); ?>;
    
    $(document).ready(function(){
        $('#menu').load("Common.php", function() {
            $("#index").removeClass("active");
            $("#lazenbys").removeClass("active");
            $("#ref").removeClass("active");
            $("#trade").removeClass("active");
            $("#management").removeClass("active");
            $("#orderList").removeClass("active");
            $("#staff").addClass("active");
            $("#pwd").remove("active");
            $("#depoit").removeClass("active");
            $("#perInfor").removeClass("active");
            $("#register").removeClass("active");
            $("#login").removeClass("active");
        });
    });
    
    function Create(){
        $("#create").show();
    }
    
    function submit(){
        user = $(".account").val();
        position = $(".position").val();
        
        $.ajax({ url: 'Server/userCreate.php',
                data: {'user': user, 'position': position},
                type: 'post',
                success: function(data) {
                        alert(data);
                        window.location = "Workers.php";
                    }
                });
    }
    
    function cancel(){
        $(".account").val("");
        $(".position").val(1);
        $("#create").hide();
    }
    
    $('select.edit').on('change', function() {
        user = users[this.closest('tr').id].id;
        position = this.value;
        
        $.ajax({ url: 'Server/userEdit.php',
                data: {'user': user, 'position': position},
                type: 'post',
                success: function(data) {
                        alert(data);
                        window.location = "Workers.php";
                    }
                });
    })
    
    $(".delete").click(function(){
        user = users[this.closest('tr').id].id;
        
        $.ajax({ url: 'Server/userDelete.php',
                data: {'user': user},
                type: 'post',
                success: function() {
                        window.location = "Workers.php";
                    
                    }
                });
    });

</script>
</html>
