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
require_once('configSamo.php');


// Set Language variable
if (isset($_GET['lang']) && !empty($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];

    if (isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']) {
        echo "<script type='text/javascript'> location.reload(); </script>";
    }
}

// Include Language file
if (isset($_SESSION['lang'])) {
    include "lang_" . $_SESSION['lang'] . ".php";
} else {
    include "lang_en.php";
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$login = $_SESSION['ID'];
?>
<script>
    function changeLang() {
        document.getElementById('form_lang').submit();
    }
</script>
<!-- Language -->

<form method='get' action='' id='form_lang' >
    <select class="uloha2 jazyk" name='lang' onchange='changeLang();' >
        <option value='en' <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'en'){ echo "selected"; } ?> >English</option>
        <option value='sk' <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'sk'){ echo "selected"; } ?> >Slovak</option>
    </select>
</form>
<div class='topnav'>
<a class='active'><?=_PRIHLUZI?> <?php echo $login;?></a>
<a href='uloha1_logout.php' class=btn; role='button' ><?=_ODHLAS?></a>
</div>
<?php


$result = mysqli_query($conn, "SELECT * FROM MNK WHERE id = '$login';");
$vsetkydb = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA= '$dbname' ";
$row_count = mysqli_num_rows(mysqli_query($conn, $vsetkydb));
//echo $row_count;
$resultdatabaz = mysqli_query($conn, $vsetkydb);
$tables = array();

while ($row4 = mysqli_fetch_assoc($resultdatabaz)) {
    array_push($tables, $row4['TABLE_NAME']);
}

for ($o = 0; $o < sizeof($tables); $o++) {
    $result2 = mysqli_query($conn, "SELECT * FROM $tables[$o] WHERE id = '$login';");
    $column_count = mysqli_num_rows(mysqli_query($conn, "describe  $tables[$o]"));


    if ($result2->num_rows > 0) {

        echo "<h2>$tables[$o]</h2>";
        echo "<table class='blueTable'>";

        $query10 = "SELECT COLUMN_NAME  FROM INFORMATION_SCHEMA.COLUMNS WHERE  TABLE_NAME = '$tables[$o]';";
        $hlavicka = mysqli_query($conn, $query10);


        while ($row3 = mysqli_fetch_array($hlavicka)) {
            for ($l = 0; $l < $column_count; $l++) {

                if ($row3[$l] != null) {
                    echo "<th>" . $row3[$l] . "</th>";
                }
            }
        }
        echo "</tr>";
        while ($row4 = mysqli_fetch_array($result2)) {

            for ($f = 0; $f < $column_count; $f++) {

                echo "<td>" . $row4[$f] . "</td>";
            }
        }
        echo "</tr>";
        echo "<table>";
    }
}


$conn->close();
?>

