<?php
require_once('../inc/dbclass.php');
require_once('../inc/funkcije.php');
if(isset($_POST['userid'])) {
    $userID = htmlentities($_POST['userid']);
    $response = array();
    if (empty($userID)) {
        $response["status"] = "error";
        $response["description"] = "Incorrect or no data provided!";
        echo json_encode($response);
        return;
    }
    $records = getUserActivities($userID);
    if($records!=null){
        $response["status"]="success";
        $response["description"]=$records;
        echo json_encode($response);
        return;
    }else{
        $response["status"] = "error";
        $response["description"] = "No data available!";
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