<?php
session_start();
if (!(isset($_SESSION['loggedIn']))){
    header("Location: ../index.php");
    exit();
}else{
    if(time() - $_SESSION['time']>1800) {
        session_destroy();
        header("Location: ../index.php");
        exit();
    }
}
$_SESSION['time'] = time();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Darko">
    <title>Home page</title>
    <link href="http://s3.amazonaws.com/codecademy-content/courses/ltp2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="../js/bootstrap.js"></script>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">BeFit</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Foods</a></li>
                <li><a href="#">Activities</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="../adm/admlogout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <div class="jumbotron">
        <h3>Food list</h3>
        <p></p>
        <div id="lfoods" class="table-responsive"></div>
        <hr>
        <div><button id="btnKreiraj" name="btnKreiraj" class="btn btn-success" onclick="addFood()">Add new</button></div>
    </div>
</div>

<script>
    $(document).on("ready", function () {
        showlist();
    });
    function showlist() {
        $.ajax({
            type: "POST",
            url: "getfoods.php"
        }).done(function (data) {
            var lr = $("#lfoods");
            var ll;
            if (data.length == 2) ll = "There is no data to show!";
            else {
                ll = '<table class="table"><thead><tr><td>Name</td><td>Calories</td><td>Proteins</td><td>Carbs</td><td>Fat</td><td>Serving siza</td><td>Description</td><td></td><td></td></tr></thead><tbody>';
                var recs = JSON.parse(data);
                console.log(recs);
                    var farray = recs.description;
                    for (var f in farray){
                        ll+='<tr><td>'+farray[f].name+'</td><td>'+farray[f].calories+'</td><td>'+farray[f].protein+'</td><td>'+farray[f].carbs+'</td><td>'+farray[f].fat+'</td><td>'+farray[f].servSize+'</td><td>'+farray[f].description+'</td>';
                        ll += '<td style="text-align: right"><button id="btnEdit" name="btnEdit" class="btn btn-primary" onclick="editfood('+farray[f].id+')">Edit</button></td><td><button id="btnDelete" name="btnDelete" class="btn btn-danger" onclick="deleteFood('+farray[f].id+')">Delete</button></td>';
                        ll +='</tr>';
                    }
                ll += "</tbody></table>";
            }
            lr.html(ll);
        });
    }
    function editfood(id){
        alert("Currently not possible...");
    }
    function deleteFood(id){
        alert("Currently not possible...");
    }
    function addFood(){
        alert("Currently not possible...");
    }
</script>
</body>
</html>