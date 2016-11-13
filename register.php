<?php
require_once ('dbclass.php');
require_once ('funkcije.php');
if(isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['email'])) {
    $username = htmlentities($_POST['username']);
    $password = htmlentities($_POST['password']);
    $email = htmlentities($_POST['email']);
    $encPass = md5($password);
    $response = array();
    if (empty($username) || empty($password) || empty($email)||!(preg_match("/[A-Za-z0-9._%+-]{2,}@[A-Za-z0-9.-]{2,}\.[A-Za-z]{2,}/", $email))) {
        $response["status"] = "error";
        $response["description"] = "Nisu upisani pravilni podaci!";
        echo json_encode($response);
        return;
    }
    $userNameExist = userNameExistance($username);
    $emailExist = emailExistance($email);
    if ($userNameExist==1||$emailExist==1) {
        $response["status"] = "error";
        if($userNameExist){
            $response["description"] = "Korisnicko ime je već zauzeto!";
        }
        else{
            $response["description"] = "Email je već zauzet!";
        }
        echo json_encode($response);
        return;
    }
    else {
        $r = registerUser($username, $email, $encPass);
        if ($r) {
            $response["status"] = "success";
            $response["description"] = "Korisnik registriran!";
            echo json_encode($response);
            return;
        }
        else {
            $response["status"] = "error";
            $response["description"] = "Doslo je do greske prilikom registracije!";
            echo json_encode($response);
            return;
        }
    }
}
else{
    $response["status"] = "error";
    $response["description"] = "Nisu upisani potrebni podaci!";
    echo json_encode($response);
    return;
}