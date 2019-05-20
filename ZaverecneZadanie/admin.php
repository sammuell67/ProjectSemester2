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

<?php

session_start();
require_once('config.php');
$login = $_SESSION['ID'];

echo "<div class='topnav''>";
echo "<a class='active'>Prihlásený použivateľ : $login</a>";
echo "</div>";
?>


<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="adminformular" method="post"
      class="form-style-7" enctype="multipart/form-data">
    <h2>Nahratie výsledkov:</h2>

    Školský rok:
    <select name=skolskyrok>
        <option value="2018/19"> 2018/19</option>
        <option value="2017/18"> 2017/18</option>
        <option value="2016/17"> 2016/17</option>
        <option value="2015/16"> 2015/16</option>
        <option value="2014/15"> 2014/15</option>
    </select><br>
    Názov predmetu:
    <input type="text" name="nazovpredmetu" required>
    <br>
    Nahratie súboru s výsledkami:
    <input type="file" name="fileToUpload" accept=".csv"/>

    <br>
    Oddeľovač

    <input type="radio" name="gender" value=";" required="required">;
    <input type="radio" name="gender" value="," required="required">,

    <input type="submit" class="btn" value=Potvrď>
</form>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="vybertabulky" method="post"
      class="form-style-7" enctype="multipart/form-data">
    <h2>Zobraz výsledky</h2>

    Školský rok:
    <select name=vyberskolskehoroku>
        <option value="2018/19"> 2018/19</option>
        <option value="2017/18"> 2017/18</option>
        <option value="2016/17"> 2016/17</option>
        <option value="2015/16"> 2015/16</option>
        <option value="2014/15"> 2014/15</option>
    </select><br>
    Názov predmetu:
    <input type="text" name="vybernazvupredmetu" required>
    <br>
    <input type="submit" class="btn" name="vyberbutton" value=Potvrď>

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
echo $nazovselekt;

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
                $sql .= " ";
                $sql .= "'";
                $sql .= $arr[0][$j];
                $sql .= "'";
                $sql .= "= " . $arr[$i][$j];
                $sql .= " ";

            }
            $sql .= "WHERE $nazovselekt.id = " . $arr[$i][0] . " ); ";
            mysqli_query($sql);
            $result = mysqli_query($conn, $sql);
        }

        echo "Výsledky boli updatnuté";

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

        echo "Výsledky boli úspešne nahrané";

    }
    if (isset($_POST['vyberbutton'])) {

        $vyberskolskehoroku = $_POST["vyberskolskehoroku"];

        $vybernazvupredmetu = $_POST["vybernazvupredmetu"];

        $column_count = mysqli_num_rows(mysqli_query($conn, "describe $vybernazvupredmetu"));
        $query6 = "SELECT * FROM $vybernazvupredmetu where $vybernazvupredmetu.SkolskyRok = '$vyberskolskehoroku';";
        $query10 = "SELECT COLUMN_NAME  FROM INFORMATION_SCHEMA.COLUMNS WHERE  TABLE_NAME = '$vybernazvupredmetu';";

        echo $column_count;
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


$conn->close();
?>
