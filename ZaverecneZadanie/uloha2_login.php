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
    $webtechselect = mysqli_query($conn, "SELECT * FROM Webtech2 WHERE id = $login");
    $sumaselekt = mysqli_query($conn, "SELECT  SUM(Zapocet + Projekt + Test + Dotaznik + Bonus) FROM  Webtech2 GROUP  BY ID WHERE id = '$login'");

    echo $sumaselekt;

    echo "<div class='topnav''>";
    echo "<a class='active'>Prihlásený použivateľ : $login</a>";
    echo "</div>";

    echo "<h2>Webové technológie 2</h2>";
    echo "<table class='blueTable'>";
    echo "<th>Zapocet</th>";
    echo "<th>Projekt</th>";
    echo "<th>Test</th>";
    echo "<th>Dotazník</th>";
    echo "<th>Bonus</th>";
    echo "<th>Súčet</th>";
    echo "<th>Známka</th>";

    echo "</tr>";

    while ($row = mysqli_fetch_array($webtechselect)) {

        echo "<td>" . $row['Zapocet'] . "</td>";
        echo "<td>" . $row['Projekt'] . "</td>";
        echo "<td>" . $row['Test'] . "</td>";
        echo "<td>" . $row['Dotaznik'] . "</td>";
        echo "<td>" . $row['Bonus'] . "</td>";
        echo "<td>" . $sumaselekt . "</td>";
        echo "<td>" . $row['Znamka'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";


    $tvorbawebappselect = mysqli_query($conn, "SELECT * FROM TvorbaWebAplikacii WHERE id = $login");

    //dalsia tabulka ineho predmetu
    echo "<h2>Tvorba web aplikácií</h2>";
    echo "<table class='blueTable'>";
    echo "<th>Zapocet</th>";
    echo "<th>Projekt</th>";
    echo "<th>Test</th>";
    echo "<th>Dotazník</th>";
    echo "<th>Bonus</th>";
    echo "<th>Súčet</th>";
    echo "<th>Známka</th>";

    echo "</tr>";


    while ($row = mysqli_fetch_array($tvorbawebappselect)) {

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


