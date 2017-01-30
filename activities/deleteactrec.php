<?php
require_once('../inc/dbclass.php');
require_once('../inc/funkcije.php');
if(isset($_POST['recid'])&&isset($_POST['userid'])) {
    $recID = htmlentities($_POST['recid']);
    $userID = htmlentities($_POST['userid']);
    $response = array();
    if (empty($recID)) {
        $response["status"] = "error";
        $response["description"] = "Incorrect data provided!";
        echo json_encode($response);
        return;
    }
    $r = deleteActDiaryRecord($recID,$userID);
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