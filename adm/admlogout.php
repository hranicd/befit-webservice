<?php
session_start();
$_SESSION['time'] = time()-2000;
$_SESSION['loggedIn']=false;
session_destroy();
header("Location: ../index.php");
