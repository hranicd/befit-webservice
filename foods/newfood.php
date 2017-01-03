<?php
require_once('../inc/dbclass.php');
require_once('../inc/funkcije.php');
if(isset($_POST['name'])&&isset($_POST['cal'])&&isset($_POST['protein'])&&isset($_POST['carbs'])&&isset($_POST['fat'])&&isset($_POST['serv'])&&isset($_POST['desc'])) {
    $name = htmlentities($_POST['name']);
    $cal = htmlentities($_POST['cal']);
    $protein = htmlentities($_POST['protein']);
    $carbs = htmlentities($_POST['carbs']);
    $fat = htmlentities($_POST['fat']);
    $servSize = htmlentities($_POST['serv']);
    $desc = htmlentities($_POST['desc']);
    $response = array();
    if (empty($name) || empty($cal) || empty($protein) || empty($carbs) || empty($fat) || empty($servSize) || empty($desc)) {
        $response["status"] = "error";
        $response["description"] = "Incorrect data provided!";
        echo json_encode($response);
        return;
    }
    $r = addNewFood($name, $cal, $protein, $carbs, $fat, $servSize, $desc);
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