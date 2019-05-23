<!DOCTYPE HTML>
<html lang="sk">
<head>
    <meta content="text/html; charset=UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/loginstyle.css">
    <link rel="stylesheet" href="css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:700,600' rel='stylesheet' type='text/css'>
</head>


<?php

require 'config.php';


$login = $pass = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $login = test_input($_POST["aisid"]);
    $pass = test_input($_POST["password"]);


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

    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    if (isset($_POST['checkboxik'])){
        header('Location: admin.php?login='.$login.'&hashed_password='.$hashed_password); // redirect to index.php
        exit;
    }

    $overenie_hesla = mysqli_query($conn, "SELECT Heslo FROM Login WHERE id = '$login'");


    /* TODO: fixniteto prosim*/
    // if ($overenie_hesla==$hashed_password)

    $in = " INSERT INTO Login (ID,Heslo, Datum) VALUES ('$login','$hashed_password','$datum')  ON DUPLICATE KEY UPDATE ID = '$login';";
    $result = mysqli_query($conn, "SELECT * FROM Webtech2 WHERE id = $login");


    echo "<div class='topnav''>";
    echo "<a class='active'>User : $login</a>";
    echo "</div>";

    echo "<h2>Web Technologies 2</h2>";
    echo "<table class='blueTable'>";
    echo "<th>Credit</th>";
    echo "<th>Project</th>";
    echo "<th>Test</th>";
    echo "<th>Questionnaire</th>";
    echo "<th>Bonus</th>";
    echo "<th>Sum total</th>";
    echo "<th>Mark</th>";

    echo "</tr>";

    while ($row = mysqli_fetch_array($result)) {

        echo "<td>" . $row['Zapocet'] . "</td>";
        echo "<td>" . $row['Projekt'] . "</td>";
        echo "<td>" . $row['Test'] . "</td>";
        echo "<td>" . $row['Dotaznik'] . "</td>";
        echo "<td>" . $row['Bonus'] . "</td>";
        echo "<td>" . $row['Sucet'] . "</td>";
        echo "<td>" . $row['Znamka'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";


    if ($conn->query($in) === TRUE) {

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }


} else {
    echo "";
}
$conn->close();
?>

