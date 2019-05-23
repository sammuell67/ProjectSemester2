<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 5/17/2019
 * Time: 10:37 PM
 */
$servername = "localhost";
$username = "xjadvis";
$password = "xjadvis123";
$dbname = "ZaverecneZadanie";


$conn = new PDO("mysql:host=$servername;dbname=ZaverecneZadanie;charset=utf8", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);


?>