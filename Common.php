
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
<link rel="stylesheet" type="text/css" href="default.css">
</head>



<?php 
    session_start();
?>

<div class="navbar">
    <a href="index.php" id = "index">Home</a>
    <?php

        

    echo "<a href=\"Lazenbys.php\" id = \"lazenbys\">Lazenbys</a>";
    echo "<a href=\"Ref.php\" id = \"ref\">The Ref</a>";
    echo "<a href=\"TradeTable.php\" id = \"trade\">The Trade Table</a>";
    

    
    

    if(!empty( $_SESSION["role"])){
        echo "<a style=\"float: right\"  id=\"login\" href='Common.php?destroy=true'>Logout</a>";
        if($_SESSION["role"] === "4" || $_SESSION["role"] === "44" || $_SESSION["role"] === "11" || $_SESSION["role"] === "22" || $_SESSION["role"] === "33")
            echo "<a style=\"float: right\"  id=\"depoit\" href='Depoit.php'>Depoit</a>";
        echo "<a style=\"float: right\"  id=\"perInfor\" href='Detail.php'>Detail</a>";
        echo "<a style=\"float: right\"  id=\"pwd\" href='Pwd.php'>Change Password</a>";
        echo "<a style=\"float: right\"  id=\"login\">" . $_SESSION["name"];
        if($_SESSION["role"] === "4" || $_SESSION["role"] === "44" || $_SESSION["role"] === "11" || $_SESSION["role"] === "22" || $_SESSION["role"] === "33")
            echo " " . "Account: " . $_SESSION["account"];
        echo "</a>";

        if($_SESSION["role"] === "1" || $_SESSION["role"] === "2" || $_SESSION["role"] === "3"){
         echo "<a href=\"ItemList.php\" id=\"ItemList\">Items List</a>";
            echo "<a href=\"OrderList.php\" id=\"orderList\">Order List</a>";
        }
        
        if($_SESSION["role"] === "11" || $_SESSION["role"] === "22" || $_SESSION["role"] === "33")
            echo "<a href=\"OrderList.php\" id=\"orderList\">Order List</a>";
        
        
        if($_SESSION["role"] === "9"){
            echo "<a href=\"Management.php\" id=\"management\">Management</a>";
            echo "<a href=\"Workers.php\" id=\"staff\">Workers Management</a>";
        }
       }
    
    

   if(empty( $_SESSION["role"])){
        echo "<a style=\"float: right\" href=\"Register.php\" id=\"register\">Register</a>";
        echo "<a style=\"float: right\" href=\"Login.php\" id=\"login\">Login</a>";
   }
    

        function destroy() {
            
            session_destroy();
            echo "<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js\"></script><script>sessionStorage.removeItem('orderItems'); console.log('logout'); window.location = 'index.php';</script>";
            //header('Location: index.php');
        }
        
        if (isset($_GET['destroy'])) {
            destroy();
        }
    ?>
</div>

