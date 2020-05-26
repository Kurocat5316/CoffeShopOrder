<!DOCTYPE html>
<html>



<head>
<link rel="stylesheet" type="text/css" href="default.css">


</head>
<body>



<div class = "background"></div>
<div id = "menu"></div>
    <div>
        <div><h1 style="position:absolute; left: 50%; top: 30%; z-index: -1;">Order System</h1></div>
        <div><img src="img\Home\img1.png" height="200" width="150" style="position:absolute; left: 45%; top: 45%; z-index: -1;"></div>
        <div><img src="img\Home\img2.jpg" height="200" width="150" style="position:absolute; left: 55%; top: 45%; z-index: -1;"></div>
        <div><img src="img\Home\img3.jpg" height="200" width="150" style="position:absolute; left: 40%; top: 60%; z-index: -1;"></div>
        <div><img src="img\Home\img4.jpg" height="200" width="150" style="position:absolute; left: 50%; top: 60%; z-index: -1;"></div>
        <div><img src="img\Home\img5.jpg" height="200" width="150" style="position:absolute; left: 60%; top: 60%; z-index: -1;"></div>
    </div>


</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $('#menu').load("Common.php", function () {
        $("#index").addClass("active");
        $("#lazenbys").removeClass("active");
        $("#ref").removeClass("active");
        $("#trade").removeClass("active");
        $("#management").removeClass("active");
        $("#orderList").removeClass("active");
        $("#pwd").remove("active");
        $("#depoit").removeClass("active");
        $("#perInfor").removeClass("active");
        $("#register").removeClass("active");
        $("#login").removeClass("active");
    });
</script>
</html>