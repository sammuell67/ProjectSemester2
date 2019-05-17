<meta charset="utf-8"/>
<?php

session_start();

session_unset();

session_destroy();

unset($_SESSION['token']);

header('Location: https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=https://147.175.121.210:4126/cviko1/cviko3/zadanie2/login.php');
?>