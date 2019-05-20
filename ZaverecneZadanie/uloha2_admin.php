<!DOCTYPE HTML>
<html lang="sk">
<head>
    <meta content="text/html; charset=UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/loginstyle.css">
    <link rel="stylesheet" href="css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:700,600' rel='stylesheet' type='text/css'>
</head>

<body>
<form action="uloha2_index.php.php" method="post" class="form-style-7">
    <h2>Nahratie výsledkov:</h2>

    Školský rok:
    <input type="text" name="skolskyrok" required>
    <br>
    Názov predmetu:
    <input type="text" name="nazovpredmetu" required>
    <br>
    Nahratie súboru s výsledkami:
    <input type="file" accept=".csv"/>
    <br>
    Oddeľovač
    <select name=oddelovac>
        <option value=";"> ;</option>
        <option value=","> ,</option>
    </select><br>
    <input type="submit" value=Potvrď>
</form>
</body>
</html>

<?php

require 'config.php';



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
$datum = date("Y-m-d H:i:s");

$login = $_GET["login"];
$hashed_password =  $_GET["hashed_password"];

//    $overenie_hesla = mysqli_query($conn, "SELECT Heslo FROM LoginAdmin WHERE id = '$login'");


/* TODO: fixniteto prosim*/
// if ($overenie_hesla==$hashed_password)


$in = " INSERT INTO LoginAdmin (ID,Heslo, Datum) VALUES ('$login','$hashed_password','$datum')  ON DUPLICATE KEY UPDATE ID = '$login';";

//$result = mysqli_query($conn, "SELECT * FROM Webtech2 WHERE id = $login");

if ($conn->query($in) === TRUE) {

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}



$conn->close();
?>
