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
if(isset($_POST['foodid'])) {
    $foodID = htmlentities($_POST['foodid']);
    $response = array();
    if (empty($foodID)) {
        $response["status"] = "error";
        $response["description"] = "Incorrect data provided!";
        echo json_encode($response);
        return;
    }
    $r = deleteFood($foodID);
    if ($r) {
        $response["status"] = "success";
        $response["description"] = "Data saved!";
        echo json_encode($response);
        return;
    }
    else {  //nije uspjelo
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