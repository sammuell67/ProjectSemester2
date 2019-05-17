

<!DOCTYPE HTML>
<html lang="sk">
<head>
    <meta content="text/html; charset=UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/loginstyle.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:700,600' rel='stylesheet' type='text/css'>
</head>
<?php

require 'config.php';


$login = $pass = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $login = test_input($_POST["aisid"]);
    $pass = test_input($_POST["password"]);

    echo $login;
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$acces = false;


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$datum = date("Y-m-d H:i:s");;

if (($pass AND $login) != "") {


    echo '<h5>Prihlásený uživateľ: </h5>' . $login;

    $in = " INSERT INTO Login (ID, Datum) VALUES ('$login','$datum')  ON DUPLICATE KEY UPDATE ID = $login;";

    if ($conn->query($in) === TRUE) {

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }


} else {
    echo "Nevyplnene udaje";
}
$conn->close();
?>