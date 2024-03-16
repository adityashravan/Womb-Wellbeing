<?php
error_reporting(0);
session_start();
unset($_SESSION['isLoggedIn']);
unset($_SESSION['LoggedInUid']);
unset($_SESSION['LoggedInUsr']);
unset($_SESSION['LoggedInUtp']);
session_destroy();
header("location:login.php");

?>
