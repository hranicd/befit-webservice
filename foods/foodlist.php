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
                <li><a href="../activities/activitylist.php">Activities</a></li>
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
        <div><button id="btnCreate" name="btnCreate" class="btn btn-success" onclick="addFood()">Add new</button></div>
        <div id="addNewFood" style="display: none">
            <div>
                <input id="foodName" name="name" type="text" placeholder="Name" > <br>
                <input id="cal" name="cal" type="number" placeholder="Calories" > <br>
                <input id="protein" name="protein" type="number" placeholder="Proteins" > <br>
                <input id="carbs" name="carbs" type="number" placeholder="Carbs" > <br>
                <input id="fat" name="fat" type="number" placeholder="Fat" > <br>
                <input id="serv" name="serv" type="text" placeholder="Serving size" > <br>
                <input id="desc" name="desc" type="text" placeholder="Description" > <br>
            </div>
            <div><button id="btnAdd" name="btnAdd" class="btn btn-success" onclick="saveFood()" style="display: none">Save data</button></div>
            <div><button id="btnUpdate" name="btnUpdate" class="btn btn-success" onclick="updateFood()" style="display: none">Save data</button></div>
        </div>

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
                    var farray = recs.description;
                    for (var f in farray){
                        ll+='<tr><td>'+farray[f].name+'</td><td>'+farray[f].calories+'</td><td>'+farray[f].protein+'</td><td>'+farray[f].carbs+'</td><td>'+farray[f].fat+'</td><td>'+farray[f].servSize+'</td><td>'+farray[f].description+'</td>';
                        ll += '<td style="text-align: right"><button id="btnEdit" name="btnEdit" class="btn btn-primary" onclick="editfood('+farray[f].id+',\''+farray[f].name+'\','+farray[f].calories+','+farray[f].protein+','+farray[f].carbs+','+farray[f].fat+','+farray[f].servSize+',\''+farray[f].description+'\')">Edit</button></td><td><button id="btnDelete" name="btnDelete" class="btn btn-danger" onclick="deleteFood('+farray[f].id+')">Delete</button></td>';
                        ll +='</tr>';
                    }
                ll += "</tbody></table>";
            }
            lr.html(ll);
        });
    }
    var edf=0;
    function editfood(id,name,cals,prots,carb,fats,ss,des){
        alert("Currently not possible...");
        $('#addNewFood').css({"display":"block"});
        $('#btnUpdate').css({"display":"block"});
        $('#btnCreate').css({"display":"none"});
        $('#foodName').val(name);
        $('#cal').val(cals);
        $('#protein').val(prots);
        $('#carbs').val(carb);
        $('#fat').val(fats);
        $('#serv').val(ss);
        $('#desc').val(des);
        edf=id;
    }
    function updateFood(){
        var foodName = $('#foodName').val();
        var cal = $('#cal').val();
        var protein = $('#protein').val();
        var carbs = $('#carbs').val();
        var fat = $('#fat').val();
        var serv = $('#serv').val();
        var desc = $('#desc').val();
        var fid = edf;
        $.ajax({
            type:"POST",
            url:"updatefood.php",
            data:{
                foodid: fid,
                name: foodName,
                cal: cal,
                protein:protein,
                carbs:carbs,
                fat:fat,
                serv:serv,
                desc:desc
            }
        }).done(function (data) {
            console.log(data);
            $('#foodName').val("");
            $('#cal').val("");
            $('#protein').val("");
            $('#carbs').val("");
            $('#fat').val("");
            $('#serv').val("");
            $('#desc').val("");
            $('#addNewFood').css({"display":"none"});
            $('#btnUpdate').css({"display":"none"});
            $('#btnCreate').css({"display":"block"});
            edf=0;
            showlist();
        });
    }
    function deleteFood(id){
        $.ajax({
            type:"POST",
            url:"deletefood.php",
            data:{
                foodid: id
            }
        }).done(function (data) {
            console.log(data);
            var res = JSON.parse(data);
            if(res.status=="error"){
                alert("This food is used in records and cannot be deleted!");
            }
            else{
                showlist();
            }
        });
    }
    function addFood(){
        $('#addNewFood').css({"display":"block"});
        $('#btnAdd').css({"display":"block"});
        $('#btnCreate').css({"display":"none"});
    }
    function saveFood() {
        var foodName = $('#foodName').val();
        var cal = $('#cal').val();
        var protein = $('#protein').val();
        var carbs = $('#carbs').val();
        var fat = $('#fat').val();
        var serv = $('#serv').val();
        var desc = $('#desc').val();

        $.ajax({
            type:"POST",
            url:"newfood.php",
            data:{
                name: foodName,
                cal: cal,
                protein:protein,
                carbs:carbs,
                fat:fat,
                serv:serv,
                desc:desc
            }
        }).done(function (data) {
            console.log(data);
            $('#foodName').val("");
            $('#cal').val("");
            $('#protein').val("");
            $('#carbs').val("");
            $('#fat').val("");
            $('#serv').val("");
            $('#desc').val("");
            $('#addNewFood').css({"display":"none"});
            $('#btnAdd').css({"display":"none"});
            $('#btnCreate').css({"display":"block"});
            showlist();
        });


    }
</script>
</body>
</html>