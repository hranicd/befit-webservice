<?php
require_once('inc/dbclass.php');
require_once ('inc/funkcije.php');
if(isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['email'])) {
    $username = htmlentities($_POST['username']);
    $password = htmlentities($_POST['password']);
    $email = htmlentities($_POST['email']);
    $encPass = md5($password);
    $response = array();
    if (empty($username) || empty($password) || empty($email)||!(preg_match("/[A-Za-z0-9._%+-]{2,}@[A-Za-z0-9.-]{2,}\.[A-Za-z]{2,}/", $email))) {   //provjera formata emaila
        $response["status"] = "error";
        $response["description"] = "Email format is not valid or empty field!";
        echo json_encode($response);
        return;
    }
    $userNameExist = userNameExistance($username);  //provjera zauzetosti username ili emaila
    $emailExist = emailExistance($email);
    if ($userNameExist==1||$emailExist==1) {
        $response["status"] = "error";
        if($userNameExist){
            $response["description"] = "Username is already taken!";
        }
        else{
            $response["description"] = "Email is already taken!";
        }
        echo json_encode($response);
        return;
    }
    else {
        $r = registerUser($username, $email, $encPass); //registriranje korisnika
        if ($r) {
            $response["status"] = "success";
            $response["description"] = "User registered successfully!";
            echo json_encode($response);
            return;
        }
        else {  //nije uspjelo upisivanje u bazu
            $response["status"] = "error";
            $response["description"] = "There was a problem during registration process! Try again, please!";
            echo json_encode($response);
            return;
        }
    }
}
else{
    $response["status"] = "error";
    $response["description"] = "Incorrect or no data provided!";
    echo json_encode($response);
    return;
}