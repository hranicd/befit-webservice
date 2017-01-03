<?php
/**
 * Created by PhpStorm.
 * User: Darko
 * Date: 11.12.2016.
 * Time: 19:12
 */
require_once('../inc/dbclass.php');
require_once('../inc/funkcije.php');
if(isset($_POST['userid'])) {
    $userID = htmlentities($_POST['userid']);
    $response = array();
    if (empty($userID)) {
        $response["status"] = "error";
        $response["description"] = "No data available!";
        echo json_encode($response);
        return;
    }
    $records = getUserFoods($userID);
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