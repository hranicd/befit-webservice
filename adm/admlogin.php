<?php
session_start();
if (isset($_SESSION['loggedIn'])){
    if($_SESSION['loggedIn']==true) {
        header("Location: ../index.php");
        exit();
    }
}
$greske = array();
if($_SERVER['REQUEST_METHOD']=="POST"){
    if(isset($_POST['username'])&&isset($_POST['pass'])){
        require_once ('../inc/dbclass.php');
        $db = new dbclass();
        $userName = $_POST['username'];
        $pass = md5($_POST['pass']);
        $sql = "select * from adm where user='$userName' and pass='$pass'";
        $rez = $db->selectData($sql);
        if($rez->num_rows == 1){
            $_SESSION['loggedIn'] = true;
            $_SESSION['time'] = time();
            header("Location: ../foods/foodlist.php");
        }else{
                $greske[] = "Korisničko ime i lozinka se ne podudaraju";
        }
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Darko">
    <title>Login</title>
    <link href="http://s3.amazonaws.com/codecademy-content/courses/ltp2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<div style="width: 70%; margin: auto;">
    <form class="form-horizontal" name="loginForm" method="POST">
        <fieldset>
            <!-- Form Name -->
            <legend>Login</legend>
            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="korisnickoIme"></label>
                <div class="col-md-4">
                    <input id="username" name="username" type="text" placeholder="Username" class="form-control input-md" required="">
                </div>
            </div>
            <!-- Password input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="lozinka"></label>
                <div class="col-md-4">
                    <input id="pass" name="pass" type="password" placeholder="Pass" class="form-control input-md" required="">
                    <span class="help-block"><?php foreach ($greske as $z) echo $z; ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="login"></label>
                <div class="col-md-4">
                    <input type="submit" id="login" value="Login" name="login" class="btn btn-primary">
                </div>
            </div>
        </fieldset>
    </form>
</div>
</body>
</html>