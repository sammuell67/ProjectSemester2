<!DOCTYPE HTML>
<html lang="sk">
<head>
    <meta content="text/html; charset=UTF-8">
    <title>Admin</title>
    <link rel="stylesheet" href="css/loginstyle.css">
    <link rel="stylesheet" href="css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:700,600' rel='stylesheet' type='text/css'>
</head>

<body>

<?php

session_start();
require_once('configSamo.php');
$login = $_SESSION['ID'];
echo "<div class='topnav''>";
echo "<a class='active'>User : $login</a>";
echo "<a href='uloha1_logout.php' class=btn; role='button' >Log out</a> ";
echo "</div>";

?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="adminformular" method="post"
      class="form-style-7" enctype="multipart/form-data">
    <h2>Upload file:</h2>

    School year:
    <select name=skolskyrok>
        <option value="2018/19"> 2018/19</option>
        <option value="2017/18"> 2017/18</option>
        <option value="2016/17"> 2016/17</option>
        <option value="2015/16"> 2015/16</option>
        <option value="2014/15"> 2014/15</option>
    </select><br>
    The tittle of the subject:
    <input type="text" name="nazovpredmetu" required>
    <br>
    Uploading results file:
    <input type="file" name="fileToUpload" accept=".csv"/>

    <br>
    Separator:

    <input type="radio" name="gender" value=";" required="required">;
    <input type="radio" name="gender" value="," required="required">,

    <input type="submit" class="btn" value=Potvrď>
</form>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="vybertabulky" method="post"
      class="form-style-7" enctype="multipart/form-data">
    <input type="hidden" name="form" value="A">
    <h2>Show me results:</h2>

    School year:
    <select name=vyberskolskehoroku>
        <option value="2018/19"> 2018/19</option>
        <option value="2017/18"> 2017/18</option>
        <option value="2016/17"> 2016/17</option>
        <option value="2015/16"> 2015/16</option>
        <option value="2014/15"> 2014/15</option>
    </select><br>
    Uploading results file:
    <input type="text" name="vybernazvupredmetu" required>
    <br>
    <input type="submit" class="btn" name="vyberbutton" value=Confirm>

</form>

</body>
</html>

<?php


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$nazovpredmetu = $_POST["nazovpredmetu"];

$skolskyrok = $_POST["skolskyrok"];

$oddelovac = $_POST["gender"];


$nazovselekt = $nazovpredmetu;

$fileName = $_FILES['fileToUpload']["name"];

$file = fopen($fileName, "r");
chmod($file, 0777);

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $arr = array(array(), array());
    $num = 0;
    $row = 0;
    $pocetRiadkov = 0;

    while ($data = fgetcsv($file, 1000, $oddelovac)) {
        $num = count($data);
        for ($c = 0; $c < $num; $c++) {
            $a = $data[$c];
            $trimmed = trim($a, ";");
            $arr[$row][$c] = $trimmed;
        }
        $row++;
    }


    if (mysqli_query($conn, "DESCRIBE $nazovselekt")) {


        for ($i = 1; $i < $row; $i++) {
            $sql = "UPDATE $nazovselekt SET";
            for ($j = 2; $j < $num; $j++) {
                if($j!=2) {
                    $sql .= ",";
                }
                $sql .= " ";
                $sql .= $arr[0][$j];
                $sql .= "= ";
                $sql .= "'";
                $sql .= $arr[$i][$j];
                $sql .= "'";
                $sql .= " ";

            }
            $sql .= "WHERE $nazovselekt.id = " . $arr[$i][0] . " ; ";
            mysqli_query($sql);
            $result = mysqli_query($conn, $sql);
        }

        echo "The results were recorded";

    } else {
        $query = "CREATE TABLE $nazovselekt(
    id INT(100) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    meno VARCHAR(30) ";
        for ($c = 2; $c < $num; $c++) {
            $query .= ",";
            $query .= $arr[0][$c] . " " . "VARCHAR" . "(30) ";
        }
        $query .= ",";
        $query .= "Skolskyrok";

        $query .= " " . "VARCHAR" . "(30) ";
        $query .= " ); ";
        mysqli_query($query);
        $sqlcreate = mysqli_query($conn, $query);


        for ($k = 1; $k < $row; $k++) {
            $queryinsert = "INSERT INTO $nazovselekt(";

            $queryinsert .= $arr[0][0];
            for ($c = 1; $c < $num; $c++) {
                $queryinsert .= ", ";
                $queryinsert .= $arr[0][$c];
            }
            $queryinsert .= ", ";
            $queryinsert .= "Skolskyrok";


            $queryinsert .= ")";

            $queryinsert .= "VALUES(";
            $queryinsert .= $arr[$k][0];

            for ($c = 1; $c < $num; $c++) {
                $queryinsert .= ", ";
                $queryinsert .= '"';
                $queryinsert .= $arr[$k][$c];
                $queryinsert .= '"';

            }
            $queryinsert .= ",";
            $queryinsert .= '"';
            $queryinsert .= $skolskyrok;
            $queryinsert .= '"';

            $queryinsert .= " ); ";

            mysqli_query($queryinsert);
            $seqelekt = mysqli_query($conn, $queryinsert);

        }

        if ($queryinsert) {
            echo "The results were recorded";
        }
    }
    if (isset($_POST['vyberbutton'])) {


        $vyberskolskehoroku = $_POST["vyberskolskehoroku"];

        $vybernazvupredmetu = $_POST["vybernazvupredmetu"];
        $_SESSION["vyberskolskehoroku"] = $vyberskolskehoroku;
        $_SESSION["vybernazvupredmetu"] = $vybernazvupredmetu;

        $column_count = mysqli_num_rows(mysqli_query($conn, "describe $vybernazvupredmetu"));
        $query6 = "SELECT * FROM $vybernazvupredmetu where $vybernazvupredmetu.SkolskyRok = '$vyberskolskehoroku';";
        $query10 = "SELECT COLUMN_NAME  FROM INFORMATION_SCHEMA.COLUMNS WHERE  TABLE_NAME = '$vybernazvupredmetu';";

        $queryyyy = mysqli_query($conn, $query6);
        $hlavicka = mysqli_query($conn, $query10);

        echo "<h2>$vybernazvupredmetu  $vyberskolskehoroku</h2>";
        echo "<table class='blueTable'>";
        while ($row3 = mysqli_fetch_array($hlavicka)) {
            for ($o = 0; $o < $column_count; $o++) {

                if ($row3[$o] != null) {
                    echo "<th>" . $row3[$o] . "</th>";
                }
            }
        }
        echo "</tr>";


        while ($row2 = mysqli_fetch_array($queryyyy)) {

            for ($o = 0; $o < $column_count; $o++) {

                echo "<td>" . $row2[$o] . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";

    }
}
?>
<form name="specialnefunkcie" method="post" action="admin.php" enctype="multipart/form-data">
    <input type="submit" class='btn' name="Enabled" value="Clear">
    <a href="generatePDF.php?vybernazvupredmetu=<?php echo $vybernazvupredmetu ?>" class='btn' role='button' >Generate PDF</a>
</form>
<?php


$vyberskolskehoroku = $_SESSION["vyberskolskehoroku"];

$vybernazvupredmetu = $_SESSION["vybernazvupredmetu"];


if (isset($_POST['Enabled'])) {

    $query7 = "DELETE FROM $vybernazvupredmetu where $vybernazvupredmetu.SkolskyRok = '$vyberskolskehoroku';";
    $queryyyy = mysqli_query($conn, $query7);
    echo "Odstranene";

}

$conn->close();
?>




