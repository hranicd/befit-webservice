<?php
require_once('../inc/dbclass.php');
require_once('../inc/funkcije.php');
$r = getAllActivities();
if ($r) {
    $response["status"] = "success";
    $response["description"] = $r;
    echo json_encode($response);
    return;
}
else {  //nije uspjelo upisivanje u bazu
    $response["status"] = "error";
    $response["description"] = "Problem! Try again, please!";
    echo json_encode($response);
    return;
}