<?php
require_once('../inc/dbclass.php');
require_once('../inc/funkcije.php');
if(isset($_POST['userid'])&&isset($_POST['actid'])&&isset($_POST['time'])&&isset($_POST['duration'])) {
    $userID = htmlentities($_POST['userid']);
    $actID = htmlentities($_POST['actid']);
    $timea = htmlentities($_POST['time']);
    $duration = htmlentities($_POST['duration']);
    $response = array();
    if (empty($userID) || empty($actID) || empty($timea) || empty($duration)) {
        $response["status"] = "error";
        $response["description"] = "Incorrect data provided!";
        echo json_encode($response);
        return;
    }
    $r = addActDiaryRecord($actID,$timea,$duration,$userID);
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