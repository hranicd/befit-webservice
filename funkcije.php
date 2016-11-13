<?php
require_once ('dbclass.php');
function userNameExistance($user){ //dal je zauzeto username ili email
	$db = new dbclass();
	$existUN = 0;
	$result = $db->selectData("select username from users where username='$user'");
	if ($result != null && (mysqli_num_rows($result) == 1)) {
		$row = $result->fetch_array(MYSQLI_ASSOC);
		if (!empty($row)) {
			$existUN = 1;
		}
	}
	return $existUN;
}
function emailExistance($user){ //dal je zauzeto username ili email
    $db = new dbclass();
    $existM = 0;
    $result = $db->selectData("select username from users where email='$user'");
    if ($result != null && (mysqli_num_rows($result) == 1)) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if (!empty($row)) {
            $existM = 1;
        }
    }
    return $existM;
}
function authorizeUser($user, $password){ //provjera dal username i pass odgovaraju
    $db = new dbclass();
    $userOK = false;
    $sql = "select * from users where (username='$user' or email='$user') and password='$password'";
    $result = $db->selectData($sql);
    if ($result != null && (mysqli_num_rows($result) == 1)) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if (!empty($row)) {
            $userOK = true;
        }
    }
    return $userOK;
}
function userDetails($username, $password){ //dohvaćanje svih detalja korisnika
	$db = new dbclass();
	$user = array();
	$sql = "select * from users where username='$username' and password='$password'";
	$result = $db->selectData($sql);
	if ($result != null && (mysqli_num_rows($result) >= 1)) {
		$row = $result->fetch_array(MYSQLI_ASSOC);
		if (!empty($row)) {
			$user = $row;
		}
	}
    return $user;
}
function registerUser($username, $email, $password) //upis korisnika u bazu
{
	$db = new dbclass();
	$sql = "insert into users values(NULL,'$email', '$username', '$password')";
	$s = $db->updateData($sql);
	return $s;
}