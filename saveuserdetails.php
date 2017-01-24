<?php
/**
 * Created by PhpStorm.
 * User: Darko
 * Date: 12.12.2016.
 * Time: 22:49
 */
require_once('inc/dbclass.php');
require_once('inc/funkcije.php');
if(isset($_POST['userid'])&&isset($_POST['programid'])&&isset($_POST['fullname'])&&isset($_POST['gender'])&&isset($_POST['dob'])&&isset($_POST['country'])&&isset($_POST['height'])&&isset($_POST['weight'])&&isset($_POST['goalweight'])) {
    $userID = htmlentities($_POST['userid']);
    $programID = htmlentities($_POST['programid']);
    $fullName = htmlentities($_POST['fullname']);
    $gender = htmlentities($_POST['gender']);
    $dob = htmlentities($_POST['dob']);
    $country = htmlentities($_POST['country']);
    $height = htmlentities($_POST['height']);
    $weight = htmlentities($_POST['weight']);
    $goalWeight = htmlentities($_POST['goalweight']);
    $response = array();
    if (empty($userID)) {
        $response["status"] = "error";
        $response["description"] = "Incorrect or no data provided!";
        echo json_encode($response);
        return;
    }
    $status = saveUserDetails($userID, $fullName, $gender, $dob, $country, $weight, $height, $programID, $goalWeight);
    if($status==true){
        $response["status"] = "success";
        $response["description"] = "Data saved!";
        echo json_encode($response);
        return;
    }else{
        $response["status"] = "error";
        $response["description"] = "Some problems with saving!";
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