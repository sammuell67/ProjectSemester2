<meta charset="utf-8"/>
<?php

session_start();

session_unset();

session_destroy();

unset($_SESSION['token']);
$_SESSION['message'] = "Bol si uspesne odhlaseny.";
header("location: index.php");

?>
