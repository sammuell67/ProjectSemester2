<?php
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
?>

<!DOCTYPE HTML>
<html>
<script>
    function changeLang() {
        document.getElementById('form_lang').submit();
    }
</script>
<!-- Language -->

<form method='get' action='' id='form_lang'>
    <select class="uloha2 jazyk" name='lang' onchange='changeLang();'>
        <option value='en' <?php if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'en') {
            echo "selected";
        } ?> >English
        </option>
        <option value='sk' <?php if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'sk') {
            echo "selected";
        } ?> >Slovak
        </option>
    </select>
</form>


<div class='topnav'>
    <a href='uloha1_logout.php' role='button'><?= _ODHLAS ?></a>
</div>
<br>
<br>

<?php
session_start();



if (!$_SESSION['admin']) {
    header('location:uloha2_index.php');
}
$body = $_GET["body"];
$word = $_SESSION['word'];
$predmet = $_SESSION['predmet'];
$rok = $_SESSION['rok'];
include 'config.php';

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql2 = mysqli_query($conn, "SELECT COUNT(*) FROM ULOHA2 WHERE predmet='$predmet' AND rok_predmetu='$rok'");
while ($row = mysqli_fetch_array($sql2)) {
    //echo "Počet študentov v predmete  : " . $row[0];
    // echo nl2br ( "\n");
    $a1 = $row[0];
}

$sql3 = mysqli_query($conn, "SELECT COUNT(*) FROM ULOHA2 WHERE suhlas='suhlasim' AND predmet='$predmet' AND rok_predmetu='$rok'");
while ($row = mysqli_fetch_array($sql3)) {
    // echo "Počet súhlasiacich študentov  : " . $row[0];
    //  echo nl2br ( "\n");
    $a2 = $row[0];
}

$sql4 = mysqli_query($conn, "SELECT COUNT(*) FROM ULOHA2 WHERE suhlas='nesuhlasim' AND predmet='$predmet' AND rok_predmetu='$rok'");
while ($row = mysqli_fetch_array($sql4)) {
    // echo "Počet nesúhlasiacich študentov  : " . $row[0];
    // echo nl2br ( "\n");
    $a3 = $row[0];
}

$sql5 = mysqli_query($conn, "SELECT COUNT(*) FROM ULOHA2 WHERE suhlas='' AND predmet='$predmet' AND rok_predmetu='$rok' ");
while ($row = mysqli_fetch_array($sql5)) {
    // echo "Počet študentov bez vyjadrenia  : " . $row[0];
    // echo nl2br ( "\n");
    // echo nl2br ( "\n");
    $a4 = $row[0];
}

$sql6 = mysqli_query($conn, "SELECT * FROM ULOHA2 WHERE predmet='$predmet' AND rok_predmetu='$rok'");
$unique = [];
while ($row = mysqli_fetch_array($sql6)) {
    if (in_array($row['tim'], $unique)) {

    } else {
        array_push($unique, $row['tim']);
    }
    //echo "Počet tímov v predmete : " . $row[0];
    // echo nl2br ( "\n");
    //$a5 = $row[0];
}
$calc = 0;
foreach ($unique as $item) {
    $calc++;
}
$a5 = $calc;

$sql7 = mysqli_query($conn, "SELECT COUNT(*) FROM ULOHA2BODY WHERE predmet = '$predmet' AND rok_predmetu='$rok' AND suhlas_admin='suhlasim'");
while ($row = mysqli_fetch_array($sql7)) {
    $pocet = $row[0];
}
$sql8 = mysqli_query($conn, "SELECT COUNT(*) FROM ULOHA2BODY WHERE predmet = '$predmet' AND rok_predmetu='$rok' AND suhlas_admin='nesuhlasim'");
while ($row = mysqli_fetch_array($sql8)) {
    $pocet = $pocet + $row[0];
}
//echo "Počet uzavretých tímov v predmete : " . $pocet;
//echo nl2br ( "\n");
$a6 = $pocet;


$sql9 = mysqli_query($conn, "SELECT COUNT(*) FROM ULOHA2BODY WHERE predmet='$predmet' AND rok_predmetu='$rok' AND suhlas_admin=''");
while ($row = mysqli_fetch_array($sql9)) {
    //echo "Počet tímov v predmete, ku ktorým sa treba vyjadriť : " . $row[0];
    // echo nl2br ( "\n");
    $a7 = $row[0];
}

$teams = [];
$counter = 0;
$sql10 = mysqli_query($conn, "SELECT * FROM ULOHA2 WHERE predmet='$predmet' AND rok_predmetu='$rok' AND suhlas=''");
while ($row = mysqli_fetch_array($sql10)) {
    if (in_array($row['tim'], $teams)) {
    } else {
        array_push($teams, $row['tim']);
        $counter++;
    }

}
//echo "Počet tímov s nevyjadrenými študentami : ".$counter;
//echo nl2br ( "\n");
$a8 = $counter;

echo "<table class='blueTable'>"; ?>
<th><?= _PSVP ?></th>
<th><?= _PSS ?></th>
<th><?= _PSS1 ?></th>
<th><?= _PSBV ?></th>
<th><?= _PTVP ?></th>
<th><?= _PUTVP ?></th>
<th><?= _PTVPKKSTV ?></th>
<th><?= _PTSNS ?></th>
</tr>
<?php
echo "<td>" . $a1 . "</td>";
echo "<td>" . $a2 . "</td>";
echo "<td>" . $a3 . "</td>";
echo "<td>" . $a4 . "</td>";
echo "<td>" . $a5 . "</td>";
echo "<td>" . $a6 . "</td>";
echo "<td>" . $a7 . "</td>";
echo "<td>" . $a8 . "</td>";
echo "</tr>";
echo "</table>";

$dataPoints = array(
    array("label" => "Počet študentov v predmete", "y" => $a1),
    array("label" => "Počet súhlasiacich študentov", "y" => $a2),
    array("label" => "Počet nesúhlasiacich študentov", "y" => $a3),
    array("label" => "Počet študentov bez vyjadrenia", "y" => $a4)
);

$dataPoints2 = array(
    array("label" => "Počet tímov v predmete", "y" => $a5),
    array("label" => "Počet uzavretých tímov", "y" => $a6),
    array("label" => "Počet tímov, ku ktorým sa treba vyjadriť", "y" => $a7),
    array("label" => "Počet tímov s nevyjadrenými študentami", "y" => $a8)
)
?>

<head>
    <meta content="text/html; charset=UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/loginstyle.css">
    <link rel="stylesheet" href="css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:700,600' rel='stylesheet' type='text/css'>
    <script>
        window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                title: {
                    text: "<?= _GC1 ?>1"
                },
                subtitles: [{
                    text: ""
                }],
                data: [{
                    type: "pie",
                    yValueFormatString: "",
                    indexLabel: "{label} ({y})",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();

            var chart1 = new CanvasJS.Chart("chartContainer1", {
                animationEnabled: true,
                title: {
                    text: "<?= _GC1 ?>2"
                },
                subtitles: [{
                    text: ""
                }],
                data: [{
                    type: "pie",
                    yValueFormatString: "",
                    indexLabel: "{label} ({y})",
                    dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart1.render();
        }
    </script>
</head>
<body>
<br>
<br>
<div class="uloha2_graf">
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
</div>
<br>
<div class="uloha2_graf">
    <div id="chartContainer1" style="height: 370px; width: 100%;"></div>
</div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>
