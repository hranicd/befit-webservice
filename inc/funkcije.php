<?php
require_once('dbclass.php');
//<editor-fold desc="user login and registration">
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
function getUserID($username, $password){
	$db = new dbclass();
	$userID = 0;
	$sql = "select user_id from users where username='$username' and password='$password'";
	$result = $db->selectData($sql);
	if ($result != null && (mysqli_num_rows($result) >= 1)) {
		$row = $result->fetch_array(MYSQLI_ASSOC);
		if (!empty($row)) {
			$userID=$row['user_id'];
		}
	}
    return $userID;
}
function registerUser($username, $email, $password) //upis korisnika u bazu
{
	$db = new dbclass();
	$sql = "insert into users values(NULL,'$email', '$username', '$password')";
	$s = $db->updateData($sql);
	return $s;
}
function getUserNumberID($userID){
    $db = new dbclass();
    $sql = "select userNumberID, timeStart from userIdentity where userStringID='$userID'";
    $result = $db->selectData($sql);
    if($result!=null && (mysqli_num_rows($result)==1)){

    }
}
//</editor-fold>
//<editor-fold desc="user details">
function saveUserDetails($userID, $fullName, $gender, $dob, $country, $weigth, $heigth, $programID, $goalWeight){
    $db = new dbclass();
    $db2 = new dbclass();
    $status = false;
    $result=$db->selectData("select recordID from userDetails where userID='$userID'");
    if($result!=null && (mysqli_num_rows($result)==1)){
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if (!empty($row)) {
            $recordID = $row['recordID'];
            //updejt postojećeg zapisa
            $status = $db->updateData("UPDATE userDetails SET programID='$programID', name='$fullName', gender='$gender', birthDate='$dob', country='$country', height='$heigth', weight='$weigth', goal='$goalWeight' WHERE recordID='$recordID'");
        }
    }else{
       $status = $db->updateData("INSERT INTO userDetails values(NULL, '$userID', '$programID', '$fullName', '$gender', '$dob', '$country', '$heigth', '$weigth', '$goalWeight')");
    }
    return $status;
}
function getUserDetails($userID){
    $db = new dbclass();
    $userData = array();
    $result = $db->selectData("select * from userDetails where userID='$userID'");
    if ($result != null && (mysqli_num_rows($result) == 1)) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if (!empty($row)) {
            $userData = $row;
        }
        else return null;
    }else return null;
    return $userData;
}
//</editor-fold>
//<editor-fold desc="foods">
function getAllFoods(){
    $db = new dbclass();
    $foods = array();
    $result = $db->selectData("select * from foods");
    if ($result != null && (mysqli_num_rows($result) > 0)) {
        while ($f = mysqli_fetch_assoc($result)){
            $foods[]=$f;
        }
    }else return null;
    return $foods;
}
function addNewFood($name, $cal, $protein, $carbs, $fat, $servSize, $desc){
    $db = new dbclass();
    $sql = "INSERT INTO foods VALUES (NULL, '$name', '$cal', '$protein', '$carbs', '$fat', '$servSize', '$desc');";
    $s = $db->updateData($sql);
    return $s;
}
function deleteFood($foodID){
    $db = new dbclass();
    $sql = "DELETE FROM foods where id='$foodID'";
    $s = $db->updateData($sql);
    return $s;
}
function addFoodDiaryRecord($userID, $foodID, $time, $qnt){
    $db = new dbclass();
    $sql = "INSERT INTO foodsDiary VALUES (NULL, '$userID', '$foodID', '$time', '$qnt');";
    $s = $db->updateData($sql);
    return $s;
}
function deleteFoodDiaryRecord($recordID){
    $db = new dbclass();
    $sql = "DELETE FROM foodsDiary WHERE recordID='$recordID';";
    $s = $db->updateData($sql);
    return $s;
}
function getUserFoods($userID){
    $db = new dbclass();
    $records = array();
    $result = $db->selectData("select fd.recordID as recordID, fd.time as time, fd.quantity, f.name as foodName, f.calories as cal  from foodsDiary fd, foods f where fd.userID='$userID' and fd.foodID=f.id");
    if ($result != null && (mysqli_num_rows($result) > 0)) {
        while ($f = mysqli_fetch_assoc($result)){
            $records[]=$f;
        }
    }else return null;
    return $records;
}
function getTimedFoodRecs($userID,$days){
    $vrijeme = time()-$days*24*60*60;
    $vs = date("Y-m-d",$vrijeme);
    $db = new dbclass();
    $records = array();
    $result = $db->selectData("select fd.recordID as recordID, fd.time as time, fd.quantity, f.name as foodName, f.calories as cal  from foodsDiary fd, foods f where fd.userID='$userID' and fd.foodID=f.id and fd.time>'$vs'");
    if ($result != null && (mysqli_num_rows($result) > 0)) {
        while ($f = mysqli_fetch_assoc($result)){
            $records[]=$f;
        }
    }else return null;
    return $records;
}
//</editor-fold>
//<editor-fold desc="activities">
function getAllActivities(){
    $db = new dbclass();
    $acts = array();
    $result = $db->selectData("select * from activities");
    if ($result != null && (mysqli_num_rows($result) > 0)) {
        while ($s = mysqli_fetch_assoc($result)){
            $acts[]=$s;
        }
    }else return null;
    return $acts;
}
function addNewAct($name, $clh){
    $db = new dbclass();
    $sql = "INSERT INTO activities VALUES (NULL, '$name', '$clh');";
    $s = $db->updateData($sql);
    return $s;
}
function deleteActivity($actID){
    $db = new dbclass();
    $sql = "DELETE FROM activities where id='$actID'";
    $s = $db->updateData($sql);
    return $s;
}
function addActDiaryRecord($actID, $timea, $dur, $userID){
    $db = new dbclass();
    $sql = "INSERT INTO foodsDiary VALUES (NULL, '$actID', '$timea', '$dur', '$userID');";
    $s = $db->updateData($sql);
    return $s;
}
function deleteActDiaryRecord($recID){
    $db = new dbclass();
    $sql = "DELETE FROM activityDiary WHERE recordID='$recID';";
    $s = $db->updateData($sql);
    return $s;
}
function getUserActivities($userID){
    $db = new dbclass();
    $records = array();
    $result = $db->selectData("select ac.recordID as recordID, ac.time as time, ac.duration as duration, a.name as actName, a.calPerHour as cal from activityDiary ac, activities a where ac.userID='$userID' and ac.activityID=a.id");
    if ($result != null && (mysqli_num_rows($result) > 0)) {
        while ($f = mysqli_fetch_assoc($result)){
            $records[]=$f;
        }
    }else return null;
    return $records;
}
function getTimedActRecords($userID,$days){
    $vrijeme = time()-$days*24*60*60;
    $vs = date("Y-m-d",$vrijeme);
    $db = new dbclass();
    $records = array();
    $result = $db->selectData("select ac.recordID as recordID, ac.time as time, ac.duration as duration, a.name as actName, a.calPerHour as cal from activityDiary ac, activities a where ac.userID='$userID' and ac.activityID=a.id and ac.time>'$vs'");
    if ($result != null && (mysqli_num_rows($result) > 0)) {
        while ($f = mysqli_fetch_assoc($result)){
            $records[]=$f;
        }
    }else return null;
    return $records;
}
//</editor-fold>
