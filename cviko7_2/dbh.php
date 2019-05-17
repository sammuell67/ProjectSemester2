<?php

require('config.php');
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if(!$conn){
	die("Connection failed: ".mysqli_connect_error());
}

?>
