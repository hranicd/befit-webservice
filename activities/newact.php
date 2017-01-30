<?php
require_once('../inc/dbclass.php');
require_once('../inc/funkcije.php');
if(isset($_POST['name'])&&isset($_POST['calh'])) {
    $name = htmlentities($_POST['name']);
    $calh = htmlentities($_POST['calh']);
    $response = array();
    if (empty($name) || empty($calh)) {
        $response["status"] = "error";
        $response["description"] = "Incorrect data provided!";
        echo json_encode($response);
        return;
    }
    $r = addNewAct($name, $calh);
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