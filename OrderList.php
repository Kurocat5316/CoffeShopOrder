<?php 
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="default.css">
</head>
<body>

<?php
    class order{
        public $user, $item, $number, $collectTime;
        
        function __construct($user, $item, $number, $collectTime){
            $this->user = $user;
            $this->item = $item;
            $this->number = $number;
            $this->collectTime = $collectTime;
        }
    }
    
    $orderList = array();
    $role = $_SESSION['role'];
    $date = date("Y-m-d", time());
    include 'db_conn.php';
    
    $sql = "SELECT receipt.userId, items.name, receiptDetail.number, receiptDetail.takeTime 
            FROM receipt, receiptDetail, items 
            WHERE receipt.restaurant = '$role' AND receipt.id = receiptDetail.receptId AND receiptDetail.itemId = items.Id AND receipt.date = '$date' 
            order by receiptDetail.takeTime";
    $result = $mysqli->query($sql);


    if ($result->num_rows > 0) {
        // output data of each row
        $flag = true;
        while($row = $result->fetch_assoc()){
            array_push($orderList, new order($row["userId"], $row["name"], $row["number"], $row["takeTime"]));
        }
    
    }
            
    $mysqli->close();
    
    $id = 0;
?>
    <div class="background"></div>
    <div id="menu"></div>

    <div style="position:relative; left: 5%; padding-top: 3%;">

        <h1>Order</h1>
        <table>
            <tr>
                <th>client</th>
                <th>name</th>
                <th>number</th>
                <th>collectTime</th>
            </tr>
            
            <?php
                foreach($orderList as $order){
                    echo "<tr>
                        <th>$order->user</th>
                        <th>$order->item</th>
                        <th>$order->number</th>
                        <th>$order->collectTime</th>
                    </tr>";
                }
            
                echo "</table>"
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
    
    $(document).ready(function(){
        $('#menu').load("Common.php", function() {
            $("#index").removeClass("active");
            $("#lazenbys").remove("active");
            $("#ref").removeClass("active");
            $("#trade").removeClass("active");
            $("#management").removeClass("active");
            $("#orderList").addClass("active");
            $("#staff").removeClass("active");
            $("#pwd").remove("active");
            $("#depoit").removeClass("active");
            $("#perInfor").removeClass("active");
            $("#register").removeClass("active");
            $("#login").removeClass("active");
        });
    });
    

</script>
</html>