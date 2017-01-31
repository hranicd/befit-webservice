<?php
session_start();
if (!(isset($_SESSION['loggedIn']))){
    exit();
}else{
    if(time() - $_SESSION['time']>1800) {
        session_destroy();
        exit();
    }
}
$_SESSION['time'] = time();
require_once('../inc/dbclass.php');
require_once('../inc/funkcije.php');
if(isset($_POST['actid'])&&isset($_POST['name'])&&isset($_POST['cal'])) {
    $actID=htmlentities($_POST['actid']);
    $name = htmlentities($_POST['name']);
    $cal = htmlentities($_POST['cal']);
    $response = array();
    if (empty($actID)||empty($name) || empty($cal)) {
        $response["status"] = "error";
        $response["description"] = "Incorrect data provided!";
        echo json_encode($response);
        return;
    }
    $r = updateActivity($actID,$name,$cal);
    if ($r) {
        $response["status"] = "success";
        $response["description"] = "Data saved!";
        echo json_encode($response);
        return;
    }
    else {  //nije uspjelo upisivanje u bazu
        $response["status"] = "error";
        $response["description"] = "There was a problem during saving process! Try again, please!";
        echo json_encode($response);
        return;
    }
}
else{
    $response["status"] = "error";
    $response["description"] = "Incorrect or no data provided!";
    echo json_encode($response);
    return;
}