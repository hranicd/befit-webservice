<?php
require_once ('dbclass.php');
require_once ('funkcije.php');
if(isset($_POST['username'])&&isset($_POST['password'])) {
    $username = htmlentities($_POST['username']);
    $password = htmlentities($_POST['password']);
    $encPass = md5($password);
    $response = array();
    if (empty($username) || empty($password)) {
        $response["status"] = "error";
        $response["description"] = "Nisu upisani potrebni podaci!";
        echo json_encode($response);
        return;
    }
    if (authorizeUser($username, $encPass) == true) {
        $response["status"] = "success";
        $response["description"] = "Uspješna prijava";
        echo json_encode($response);
        return;
    }
    else {
        if (userNameExistance($username) == 1||emailExistance($username)==1) {
            $response["status"] = "error";
            $response["description"] = "Pogrešna lozinka!";
            echo json_encode($response);
            return;
        }
        else {
            $response["status"] = "error";
            $response["description"] = "Ne postoji korisnik!";
            echo json_encode($response);
            return;
        }
    }
}else{
    $response["status"] = "error";
    $response["description"] = "Nisu upisani potrebni podaci!";
    echo json_encode($response);
    return;
}