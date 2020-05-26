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
    
        $mysqli->close();
?>

    <div class="background"></div>
    <div id="menu"></div>

    <label class="btn create" onclick = "Create()" style="position:absolute; right: 5%; margin-top: 5%; z-index: 10;">Create</label>

    <div style="position:relative; left: 5%; padding-top: 3%;">

        <h1>Lazenbys</h1>
        <h2>Cafe</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Prize</th>
                <th>Type</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <?php 
            
            $id = 0;
            
                foreach($items as $item){
                    if($item->type === '0'){
                        echo "<tr id = \"$id\">
                                <td>$item->name</td>
                                <td>$item->price</td>
                                <td>Cafe</td>
                                <td><label class=\"btn edit\" id=\"edit\" onClick = \"Edit(this)\">Edit</label></td>
                                <td><label class=\"btn delete\" id=\"edit\" onClick = \"Delete(this)\">Delete</label></td>
                            </tr>";
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
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <?php 
            foreach($items as $item){
                if($item->type === '1'){
                    echo "<tr id = \"$id\">
                            <td>$item->name</td>
                            <td>$item->price</td>
                            <td>Snack</td>
                            <td><label class=\"btn edit\" id=\"edit\" onClick = \"Edit(this)\">Edit</label></td>
                            <td><label class=\"btn delete\" id=\"edit\" onClick = \"Delete(this)\">Delete</label></td>
                        </tr>";
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
    var imgFlag = false;
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
    console.log(itemList);

    function Create(){
        $("#managePage").show();
        $("#title").html("Create");
    }


    function Edit(item){
        $("#managePage").show();
        $("#DeletePage").hide();
        $("#title").html("Edit");
        currentId = item.closest('tr').id;

        $(".name").val(itemList[currentId].name);
        $(".price").val(itemList[currentId].price);
        $("#type select").val(itemList[currentId].type);
        
        var adr = 'img/Total/';
        adr += itemList[currentId].name + ".jpg";
        $('#previewing').attr('src',adr);
    }

    function Save(){
    	if ($("#title").text() == "Edit")
            Edition();
        else
            Creation(); 
    }
    
    function Creation(){
        var name = $(".name").val();
        var price = $(".price").val();
        var number = $(".number").val();
        var type = $(".type").val();
        if(name === '' || price === '' || number === '' || !imgFlag)
            alert("Please input vailable value in each text box");
        else{
        	fileDetail = document.getElementById('file');
        
        	var form_data = new FormData();
        	form_data.append("file", fileDetail.files[0]);
        	
        	form_data.append('name',name);
        	form_data.append('price',price);
        	form_data.append('type',type);
        	
            $.ajax({ url: 'Server/createItem.php',
                data: form_data,
                type: 'post',
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData:false,        // To send DOMDocument or non processed data file it is set to false
                success: function(data) {
                        alert(data);
                        window.location = "Management.php";
                    }
                });
            
        }
    }
    
    function Edition(){
        var oldName = itemList[currentId].name;
        var name = $(".name").val();
        var price = $(".price").val();
        var type = $(".type").val();
        var fun;
        if($("#file").get(0).files.length == 0)
            fun = 0;
        else
            fun = 1;
        
        
        fileDetail = document.getElementById('file');
        
        var form_data = new FormData();
        	
        form_data.append("file", fileDetail.files[0]);
        
        form_data.append('id', itemList[currentId].id);
        form_data.append('oldName',oldName);
        form_data.append('name',name);
        form_data.append('price',price);
        form_data.append('type',type);
        form_data.append('fun',fun);
        	
            $.ajax({ url: 'Server/updateItem.php',
                data: form_data,
                type: 'post',
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData:false,        // To send DOMDocument or non processed data file it is set to false
                success: function(data) {
                        alert(data);
                        window.location = "Management.php";
                    }
                });
            
        
    }

    function Delete(item){
        $("#DeletePage").show();
        $("#title").html("Are your sure delete the item from menu?");
        currentId = item.closest('tr').id;
        $("#name").html("Item Name: " + itemList[currentId].name);
        $("#price").html("Price: " + itemList[currentId].price);
        if(itemList[currentId].type == 0)
            $("#type").html("Type: Cafe");
        else
        $("#type").html("Type: Snack"); 
    }
    
    function Confirm(){
        var id = itemList[currentId].id;
        var name = itemList[currentId].name;
        console.log(id + name);
        $.ajax({ url: 'Server/deleteItem.php',
                data: {'id': id, 'name': name},
                type: 'post',
                success: function(data) {
                        console.log(data);
                        alert(data);
                        window.location = "Management.php";
                    }
                });
    }

    function Cancel(){
        $(".name").val("");
        $(".price").val("");
        $("#managePage").hide();
        $("#DeletePage").hide();
        var file = $("#file");
        file.replaceWith(file.val('').clone(true));
        $('#previewing').attr('src','img/NoImgTip.png');
    }
    
    $("#startTime").on('change', function(){
        var time = $("#startTime option:selected").text();
        var restaurant = <?php echo $_SESSION['role']; ?>;
        
        $.ajax({ url: 'Server/timeSetting.php',
                data: {'action': 'open', 'restaurant': restaurant, 'time': time},
                type: 'post',
                success: function(data) {
                        //console.log(data);
                        window.location = "Management.php";
                    
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
                        window.location = "Management.php";
                    
                    }
                });
    })
    
    

        
    $("#file").change(function() {
        $("#message").html("");
        var file = this.files[0];
         var imagefile = file.type;
          var match= ["image/jpeg","image/png","image/jpg"];
          if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
        {
            $('#previewing').attr('src','img/NoImgTip.png');
             $("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
              imgFlag = false;
           }
          else
          {
            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(this.files[0]);
            imgFlag = true;
          }
       });
        
        
        
  function imageIsLoaded(e) {
         $("#file").css("color","green");
         $('#image_preview').css("display", "block");
          $('#previewing').attr('src', e.target.result);
          $('#previewing').attr('width', '250px');
          $('#previewing').attr('height', '230px');
       };
</script>

</html>

    