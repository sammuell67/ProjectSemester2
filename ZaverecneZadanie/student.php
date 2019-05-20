<!DOCTYPE HTML>
<html lang="sk">
<head>
    <meta content="text/html; charset=UTF-8">
    <title>Študent</title>
    <link rel="stylesheet" href="css/loginstyle.css">
    <link rel="stylesheet" href="css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:700,600' rel='stylesheet' type='text/css'>
</head>


<?php
session_start();
require_once ('config.php');

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$login=$_SESSION['ID'];

$result = mysqli_query($conn, "SELECT * FROM MNK WHERE id = '$login';");
$vsetkydb = mysqli_query($conn, "SELECT * FROM SYSOBJECTS WHERE  xtype = 'U';");
echo $vsetkydb;


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

$qty = 0;
while ($row = mysqli_fetch_array($result)) {

    $qty = $row['Zapocet'] + $row['Projekt'] + $row['Test'] + $row['Dotaznik'] + $row['Bonus'];
    if ($qty < 56) {
        $znamka = "FX";
    }
    if ($qty >= 56 && $qty < 65) {
        $znamka = "E";
    }
    if ($qty >= 65 && $qty < 74) {
        $znamka = "D";
    }
    if ($qty >= 74 && $qty < 83) {
        $znamka = "C";
    }
    if ($qty >= 83 && $qty < 91) {
        $znamka = "B";
    }
    if ($qty >= 91) {
        $znamka = "A";
    }
    echo "<td>" . $row['Zapocet'] . "</td>";
    echo "<td>" . $row['Projekt'] . "</td>";
    echo "<td>" . $row['Test'] . "</td>";
    echo "<td>" . $row['Dotaznik'] . "</td>";
    echo "<td>" . $row['Bonus'] . "</td>";
    echo "<td>" . $qty . "</td>";
    echo "<td>" . $znamka . "</td>";
    echo "</tr>";
    $sql = mysqli_query($conn,"UPDATE Webtech2 SET Sucet = '$qty', Znamka = '$znamka' WHERE id = '$login';");

}

echo "</table>";



$conn->close();
?>

