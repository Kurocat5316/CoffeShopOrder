<?php 
    session_start();
?>

<!DOCTYPE html>
<html>
<header>
    <link rel="stylesheet" type="text/css" href="default.css">
    <style>
        input[type="file"] {
            display: none;
        }
    </style>
</header>


<?php 
    
    include 'db_conn.php';
    
    
        class item{
            public $id,
            $name,
            $price,
            $type;
    
            function __construct($id, $name, $price, $type){
                $this->id = $id;
                $this->name = $name;
                $this->price = $price;
                $this->type = $type;
            }
        }

        $query = "Select * From items order by type";
        $result = $mysqli->query($query);
        
        $items = array();
    
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc())
                array_push($items, new item($row["Id"], $row["name"], $row["price"], $row["type"]));
        }
    
    
        $sql = "SELECT openTime, closeTime FROM restaurant WHERE id = '" . $_SESSION["role"] . "'";
        $result = $mysqli->query($sql);
        while($row = $result->fetch_assoc()){
            $openTime = $row["openTime"];
            $closeTime = $row["closeTime"];
        }
    
        $mysqli->close();
    
    
    function check($id){
        include 'db_conn.php';
        $query = "Select * From itemList Where restaurant = '" . $_SESSION["role"] ."' AND itemId = $id";
        $result = $mysqli->query($query);
        if ($result->num_rows <= 0)
            return false;
        else
            return true;
    }
?>

    <div class="background"></div>
    <div id="menu"></div>

    <div style="position:relative; left: 5%; padding-top: 3%;">

        <h1>Lazenbys</h1>
        <h2>Cafe</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Prize</th>
                <th>Type</th>
                <th>Option</th>
            </tr>
            <?php 
            
            $id = 0;
            
                foreach($items as $item){
                    if($item->type === '0'){
                        echo "<tr id = \"$id\">
                                <td>$item->name</td>
                                <td>$item->price</td>
                                <td>Cafe</td>";
                                if(check($item->id))
                                    echo "<td><label class=\"btn edit\" id=\"edit\" onClick = \"Delete(this)\">Delete</label></td>";
                                else
                                    echo "<td><label class=\"btn edit\" id=\"edit\" onClick = \"Add(this)\">Add</label></td>";
                                    
                            echo "</tr>";
                        $id++;
                    }
                }
                echo "</table>";
            ?>

        <h2>Snack</h2>

        <table>
            <tr>
                <th>Name</th>
                <th>Prize</th>
                <th>Type</th>
                <th>Option</th>
            </tr>
            <?php 
            foreach($items as $item){
                if($item->type === '1'){
                    echo "<tr id = \"$id\">
                            <td>$item->name</td>
                            <td>$item->price</td>
                            <td>Snack</td>";
                            if(check($item->id))
                                    echo "<td><label class=\"btn edit\" id=\"edit\" onClick = \"Delete(this)\">Delete</label></td>";
                                else
                                    echo "<td><label class=\"btn edit\" id=\"edit\" onClick = \"Add(this)\">Add</label></td>";
                            echo "</tr>";
                    $id++;
                }
            }
            echo "</table>";
        ?>
    </div>

    <div id = "managePage" hidden style="background-color:white; position:fixed; top: 30%; left: 30%; text-align: center; width: 30%">
        
            <div id = "title">test</div>
            <div>Name: <input name = "name" type = "text" class = "name"></div><br>
            <div>Price: <input name = "price" type = "number" class = "price"></div><br>
            <div>Quantity: <input name = "quantity" type = "number" class = "number"></div><br>
        
            <div id="image_preview"><img id="previewing" src="img/NoImgTip.png" /></div>
        
        
            <div >
                <select class = "type">
                    <option value="0">Cafe</option>
                    <option value="1">Snack</option>
                </select>
            </div><br>
        
            
        
            <label class = "btn"><input type="file" id="file" style= "display: none">Upload</label><br>
            <div id = "message"></div>
        
        
        <br>
        
        
            <label class = "btn" onclick = "Save()">submit</label>
            <label class = "btn" onclick = "Cancel()">Cancel</label><br><br>
        
    </div>
            
    <?php
        echo "<div id=\"time\"> Open - Close: ";
        $startTime = strtotime('00:00:00');
        $end=strtotime('23:45:00');
        echo "<select id = \"startTime\">";
        for($i = $startTime; $i <= $end; $i += 15* 60){
            if($i === strtotime($openTime))
                echo "<option selected>". date('H:i:s',$i) ."</option>";
            else
                echo "<option>". date('H:i:s',$i) ."</option>";
        }
            
            
        echo"</select> ~ ";
        echo "<select id = \"endTime\">";
        for($i = strtotime($openTime); $i <= $end; $i += 15* 60){
            if($i === strtotime($closeTime))
                echo "<option selected>". date('H:i:s',$i) ."</option>";
            else
                echo "<option>". date('H:i:s',$i) ."</option>";
        }
            
        echo "</select></div>";
        //echo "<div id=\"time\">Open Time : $openTime ~ $closeTime</div>";
            
    ?>

    <div id = "DeletePage" hidden style="background-color:white; position:fixed; top: 30%; left: 30%; text-align: center; width: 30%">
            <div id = "title">Are you sure to delete the item?</div>
            <div id = "name"></div><br>
            <div id = "price"></div><br>
            <div id = "type"></div><br>
            <div class = "btn" onclick = "Confirm()">Yes</div>
            <div class = "btn" onclick = "Cancel()">No</div>  
    </div>


</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    var currentId = "";
    $('#menu').load("Common.php", function () {
        $("#index").removeClass("active");
        $("#lazenbys").removeClass("active");
        $("#ref").removeClass("active");
        $("#trade").removeClass("active");
        $("#management").addClass("active");
        $("#orderList").removeClass("active");
        $("#staff").removeClass("active");
        $("#pwd").remove("active");
        $("#depoit").removeClass("active");
        $("#perInfor").removeClass("active");
        $("#register").removeClass("active");
        $("#login").removeClass("active");

        $("#create").click(function(){
            console.log("test");
        });
    });

    var itemList = <?php echo json_encode($items); ?>;

    function Add(item){
        itemId = itemList[item.closest("tr").id].id;
        $.ajax({ url: 'Server/addItem.php',
                data: {'id':itemId},
                type: 'post',
                success: function() {
                        window.location = "ItemList.php";
                    
                    }
                });
    }
    
    function Delete(item){
        itemId = itemList[item.closest("tr").id].id;
        $.ajax({ url: 'Server/removeItem.php',
                data: {'id':itemId},
                type: 'post',
                success: function() {
                        window.location = "ItemList.php";
                    
                    }
                });
    }
    
    $("#startTime").on('change', function(){
        var time = $("#startTime option:selected").text();
        var restaurant = <?php echo $_SESSION['role']; ?>;
        
        $.ajax({ url: 'Server/timeSetting.php',
                data: {'action': 'open', 'restaurant': restaurant, 'time': time},
                type: 'post',
                success: function(data) {
                        //console.log(data);
                        window.location = "ItemList.php";
                    
                    }
                });
    })
    
    $("#endTime").on('change', function(){
        var time = $("#endTime option:selected").text();
        var restaurant = <?php echo $_SESSION['role']; ?>;
        
        $.ajax({ url: 'Server/timeSetting.php',
                data: {'action': 'close', 'restaurant': restaurant, 'time': time},
                type: 'post',
                success: function(data) {
                        window.location = "ItemList.php";
                    
                    }
                });
    })
    
    

        
</script>

</html>

    