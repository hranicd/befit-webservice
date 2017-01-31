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
                <li><a href="../foods/foodlist.php">Foods</a></li>
                <li class="active"><a href="#">Activities</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="../adm/admlogout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <div class="jumbotron">
        <h3>List of activities</h3>
        <p></p>
        <div id="lactyss" class="table-responsive"></div>
        <hr>
        <div><button id="btnCreate" name="btnCreate" class="btn btn-success" onclick="addactys()">Add new</button></div>
        <div id="addNewActivity" style="display: none">
            <div>
                <input id="actysName" name="name" type="text" placeholder="Name" > <br>
                <input id="cal" name="cal" type="number" placeholder="Calories per hour" > <br>
            </div>
            <div><button id="btnAdd" name="btnAdd" class="btn btn-success" onclick="saveactys()" style="display: none">Save data</button></div>
            <div><button id="btnUpdate" name="btnUpdate" class="btn btn-success" onclick="updateActivity()" style="display: none">Save data</button></div>
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
            url: "getactivities.php"
        }).done(function (data) {
            var lr = $("#lactyss");
            var ll;
            if (data.length == 2) ll = "There is no data to show!";
            else {
                ll = '<table class="table"><thead><tr><td>Name</td><td>Calories per Hour</td><td></td><td></td></tr></thead><tbody>';
                var recs = JSON.parse(data);
                var farray = recs.description;
                for (var f in farray){
                    ll+='<tr><td>'+farray[f].name+'</td><td>'+farray[f].calPerHour+'</td>';
                    ll += '<td style="text-align: right"><button id="btnEdit" name="btnEdit" class="btn btn-primary" onclick="editactys('+farray[f].id+',\''+farray[f].name+'\','+farray[f].calPerHour+')">Edit</button></td><td><button id="btnDelete" name="btnDelete" class="btn btn-danger" onclick="deleteactys('+farray[f].id+')">Delete</button></td>';
                    ll +='</tr>';
                }
                ll += "</tbody></table>";
            }
            lr.html(ll);
        });
    }
    var edf = 0;
    function editactys(id, name, cph){
        $('#addNewActivity').css({"display":"block"});
        $('#btnUpdate').css({"display":"block"});
        $('#btnCreate').css({"display":"none"});
        $('#actysName').val(name);
        $('#cal').val(cph);
        edf=id;
    }
    function updateActivity(){
        var foodName = $('#actysName').val();
        var cal = $('#cal').val();
        $.ajax({
            type:"POST",
            url:"updateactivity.php",
            data:{
                actid: edf,
                name: foodName,
                cal: cal
            }
        }).done(function (data) {
            console.log(data);
            $('#actysName').val("");
            $('#cal').val("");
            $('#addNewActivity').css({"display":"none"});
            $('#btnUpdate').css({"display":"none"});
            $('#btnCreate').css({"display":"block"});
            edf=0;
            showlist();
        });
    }
    function deleteactys(id){
        $.ajax({
            type:"POST",
            url:"deleteact.php",
            data:{
                actid: id
            }
        }).done(function (data) {
            console.log(data);
            var res = JSON.parse(data);
            if(res.status=="error"){
                alert("This activity is used in diary records and cannot be deleted!");
            }
            else{
                showlist();
            }
        });
    }
    function addactys(){
        $('#addNewActivity').css({"display":"block"});
        $('#btnAdd').css({"display":"block"});
        $('#btnCreate').css({"display":"none"});
    }
    function saveactys() {
        var actysName = $('#actysName').val();
        var cal = $('#cal').val();

        $.ajax({
            type:"POST",
            url:"newact.php",
            data:{
                name: actysName,
                calh: cal
            }
        }).done(function (data) {
            console.log(data);
            $('#actysName').val("");
            $('#cal').val("");
            $('#addNewActivity').css({"display":"none"});
            $('#btnAdd').css({"display":"none"});
            $('#btnCreate').css({"display":"block"});
            showlist();
        });


    }
</script>
</body>
</html>