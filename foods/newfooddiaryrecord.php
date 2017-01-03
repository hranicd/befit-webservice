<?php
require_once('../inc/dbclass.php');
require_once('../inc/funkcije.php');
if(isset($_POST['userid'])&&isset($_POST['foodid'])&&isset($_POST['time'])&&isset($_POST['quantity'])) {
    $userID = htmlentities($_POST['userid']);
    $foodID = htmlentities($_POST['foodid']);
    $time = htmlentities($_POST['time']);
    $qnt = htmlentities($_POST['quantity']);
    $response = array();
    if (empty($name) || empty($cal) || empty($protein) || empty($carbs) || empty($fat) || empty($servSize) || empty($desc)) {
        $response["status"] = "error";
        $response["description"] = "Incorrect data provided!";
        echo json_encode($response);
        return;
    }
    $r = addFoodDiaryRecord($userID, $foodID, $time, $qnt);
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