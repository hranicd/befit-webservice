<?php
require_once ('dbclass.php');
require_once ('funkcije.php');
if(isset($_POST['username'])&&isset($_POST['password'])) { //dal su poslani username i pass
    $username = htmlentities($_POST['username']);
    $password = htmlentities($_POST['password']);
    $encPass = md5($password);
    $response = array();
    if (empty($username) || empty($password)) {     //dal su upisani neki podaci
        $response["status"] = "error";
        $response["description"] = "Nisu upisani potrebni podaci!";
        echo json_encode($response);
        return;
    }
    if (authorizeUser($username, $encPass) == true) {   //provjera kombinacije usernamea i passworda
        $response["status"] = "success";
        $response["description"] = "Logged in!";
        echo json_encode($response);
        return;
    }
    else {
        if (userNameExistance($username) == 1||emailExistance($username)==1) {  //provjera postojanja korisnika
            $response["status"] = "error";
            $response["description"] = "Password is incorrect!";
            echo json_encode($response);
            return;
        }
        else {
            $response["status"] = "error";
            $response["description"] = "Username doesn't exist!";
            echo json_encode($response);
            return;
        }
    }
}else{
    $response["status"] = "error";
    $response["description"] = "Incorrect or no data provided!";
    echo json_encode($response);
    return;
}