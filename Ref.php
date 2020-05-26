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
include 'db_conn.php';
    
    class item{
        public $id,
        $name,
        $price,
        $type,
        $restaurant;

        function __construct($id, $name, $price, $type, $restaurant){
            $this->id = $id;
            $this->name = $name;
            $this->price = $price;
            $this->type = $type;
            $this->restaurant = $restaurant;
        }
    }
    
    $items = array();
    $openTime;
    $closeTime;
    
    include 'db_conn.php';
    
    $sql = "SELECT itemList.id, name, price, type FROM items, itemList WHERE restaurant = '2' AND items.id = itemList.itemId order by type";
    $result = $mysqli->query($sql);


    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc())
            array_push($items, new item($row["id"], $row["name"], $row["price"], $row["type"], '2'));
    
    }
    
    $sql = "SELECT openTime, closeTime FROM restaurant WHERE id = '2'";
    $result = $mysqli->query($sql);
    while($row = $result->fetch_assoc()){
        $openTime = $row["openTime"];
        $closeTime = $row["closeTime"];
    }
            
    $mysqli->close();



$id = 0;

echo "<div class = \"background\"></div>";
echo "<div id = \"menu\"></div>";

    echo "<div id=\"total\">";
        echo "<div style=\"padding-top: 3%;\">";
            echo "<h1 style=\"padding-left: 3%;\">Cafe Catalogues</h1>";
            foreach($items as $item){
                if($item->type === '0'){
                    echo "<div class=\"relative\" id=\"" . $id . "\" onmouseover=\"ShowDetail(this)\" onmouseout=\"HideDetail(this)\" onclick=\"OrderPage(this)\"><img src=\"img/Total/" . $item->name . ".jpg\"></div>";
                    $id++;
                }
            }
        echo "</div>";

        echo "<div style=\"position:relative;  top: 5px\">";
            echo "<h1 style=\"padding-left: 3%\">Snack</h1>";


            foreach($items as $item){
                if($item->type === '1'){
                    echo "<div class=\"relative\" id=\"" . $id . "\" onmouseover=\"ShowDetail(this)\" onmouseout=\"HideDetail(this)\" onclick=\"OrderPage(this)\"><img src=\"img/Total/" . $item->name . ".jpg\"></div>";
                    $id++;
                }
            }

        echo "</div>";
    echo "</div>";


        echo "<div hidden id=\"OrderList\">
            <br><h1>Shopping Cart</h1><br><br>
                <div id=\"order\"></div><br><br>
                <label class=\"btn\" onClick = \"Pay()\" style=\"margin: 10px;\">Payment</label><br><br>
            </div>

            <div id=\"orderPage\" hidden style=\"background-color:white; position:fixed; top: 30%; left: 30%; text-align: center; width: 30%\">
                <form>
                    <h3 id=\"title\"></h3>
                    <p id=\"price\"></p>
                    <br>
                    Number:<input type=\"number\" id=\"cup\" onkeyup=\"this.value = this.value.replace(/[^0-9]/, '')\"><br><br>
                    <br>
                    Collect Time : ";
                    $openSelectTime = strtotime($openTime) + 30 * 60;
                    $closeSelectTime = strtotime($closeTime) - 60 * 60;
                    echo "<select id =\"collectTime\">";
                    for($i = $openSelectTime; $i <= $closeSelectTime; $i += 15* 60){
                        echo "<option>". date('H:i:s',$i) ."</option>";
                    }
                    echo"</select> <br><br> ";
                    echo "Comment: <br><textarea rows=\"4\" cols=\"50\" name=\"comment\" id = \"comment\"></textarea> <br><br>";
    
                    echo "<laebl class=\"btn\" id=\"confirm\">Submit</laebl>
                    <laebl class=\"btn\" id=\"cancel\">Cancel</laebl>
                    <br><br>
                </form>
            </div>

        <div id=\"time\">Open Time : $openTime ~ $closeTime</div>";
?>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    var itemList = <?php echo json_encode($items); ?>;

    var currentId;
    var orderList = [];
    var total = 0;
    if(sessionStorage.orderItems != undefined){
        
        orderList = JSON.parse(sessionStorage.orderItems);
        console.log(sessionStorage.orderItems);
        $("#OrderList").show();
        var str = "";
        for (var i = 0; i < orderList.length; i++) {
            str += "<div class = '" + i +"'>Item: " + orderList[i].name + "  Price/each: " + orderList[i].price + "  Number: " + orderList[i].number + "  Collect Time: " + orderList[i].collectTime + "  Comment: " + orderList[i].comment + "  <button class = '" + i + "' onClick = 'Remove(this)'>Remove</button></div><br>";
            total += orderList[i].price * orderList[i].number<?php if($_SESSION["role"] === '44') echo "*0.9";?>;
        }
        str += "<div>Total: $" + total + "</div><br>"
        $("#order").html(str);
    }
    
    $(document).ready(function(){
        $('#menu').load("Common.php", function() {
            $("#index").removeClass("active");
            $("#lazenbys").removeClass("active");
            $("#ref").addClass("active");
            $("#trade").removeClass("active");
            $("#management").removeClass("active");
            $("#orderList").removeClass("active");
            $("#pwd").remove("active");
            $("#depoit").removeClass("active");
            $("#perInfor").removeClass("active");
            $("#register").removeClass("active");
            $("#login").removeClass("active");
        });
    });

    $("#cancel").click(function () {
        $("#orderPage").hide();
        $("#total").prop('disabled', false);
        $("#cup").val("");
        $("#comment").val("");
    })

    $("#confirm").click(function () {
        $("#orderPage").hide();
        $("#total").prop('disabled', false);

        

        if ($("#cup").val() > 0) {
            var price = $("#cup").val() * itemList[currentId].price;
            if(price<?php if($_SESSION["role"] === '44') echo "*0.9";?> + total > <?php if(!empty( $_SESSION["account"])) echo $_SESSION["account"]; else echo 0; ?>){
               alert("Sorry, The total price will out of your budget.");
                $("#cup").val("");
                return;
            }
            $("#OrderList").show();
        
            time = $("#collectTime option:selected").text();
            comment = $("#comment").val();
            console.log(time + comment);

            orderList.push({id: itemList[currentId].id, name: itemList[currentId].name, price: itemList[currentId].price, number: $("#cup").val(), restaurant: itemList[currentId].restaurant, collectTime: time, comment: comment});
            total += orderList[orderList.length - 1].price * orderList[orderList.length - 1].number <?php if($_SESSION["role"] === '44') echo "*0.9";?>;
            
            sessionStorage.orderItems = JSON.stringify(orderList);
            var str = "";
            itemList[currentId][2] -= $("#cup").val();
            for (var i = 0; i < orderList.length; i++) {
                 str += "<div>Item: " + orderList[i].name + "  Price/each: " + orderList[i].price + "  Number: " + orderList[i].number + "   Collect Time: " + orderList[i].collectTime + "   Comment: " + orderList[i].comment + " <button class = '" + i + "' onClick = 'Remove(this)'>Remove</button></div><br>"
            }
            str += "<div>Total: $" + total + "</div><br>"
            $("#order").html(str);
        }
        $("#cup").val("");
        $("#comment").val("");
    })

    function ShowDetail(img) {
        $("#" + img.id).children().css("filter", "blur(3px)");
        $("#" + img.id).append('<div id="detail">' +
            '<div>' + itemList[img.id].name + '</div>' +
            '<div>Price: $' + itemList[img.id].price + '</div>');
    }

    function HideDetail(img) {
        $("#" + img.id).children().css("filter", "blur(0px)");
        $("#" + img.id).children("#detail").remove();
    }

    function OrderPage(img) {
                <?php 
            if(empty( $_SESSION["role"])){
                echo "alert('You should login at first'); window.location = 'Login.php';";
            }else{
                if($_SESSION["role"] === '4' || $_SESSION["role"] === '44' || $_SESSION["role"] === "11" || $_SESSION["role"] === "22" || $_SESSION["role"] === "33"){
                    echo "$(\"#orderPage\").show();
                            $(\"#title\").html(itemList[img.id].name);
                            $(\"#price\").html(\"Price: $\" + itemList[img.id].price);
                            currentId = img.id;";
                }
            }
        ?>
    }
    
    function Remove(item){
        $("#order").html("");
        var itemId = item.className;
        orderList.splice(itemId,1);
        console.log(orderList);
        sessionStorage.orderItems = JSON.stringify(orderList);
        
        if(orderList.length <= 0){
            total = 0;
            $("#OrderList").hide();
        }
        else{
            
            total -= orderList[i].price * orderList.number <?php if($_SESSION["role"] === '44') echo "*0.9";?>;
            str = "";
            for (var i = 0; i < orderList.length; i++) {
                str += "<div class = '" + i +"'>Item: " + orderList[i].name + "  Price/each: " + orderList[i].price + "  Number: " + orderList[i].number + "  Collect Time: " + orderList[i].collectTime + "  Comment: " + orderList[i].comment + "  <button class = '" + i + "' onClick = 'Remove(this)'>Remove</button></div><br>";
                total += orderList[i].price * orderList[i].number;
            }
            
            str += "<div>Total: $" + total<?php if($_SESSION["role"] === '44') echo "*0.9";?> + "</div><br>"
            $("#order").html(str);
        }
        
    }
    
    function Pay(){
            $.ajax({ url: 'Server/purchase.php',
                    data: {'user': "<?php echo $_SESSION["user"]; ?>", 'items': orderList, 'total': total},
                    type: 'post',
                    success: function() {
                        sessionStorage.removeItem("orderItems");
                        window.location = "index.php";

                        }
                    });
    }


</script>
</html>
