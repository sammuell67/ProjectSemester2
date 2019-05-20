<!DOCTYPE HTML>
<html lang="sk">
<head>
    <meta content="text/html; charset=UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/loginstyle.css">
    <link rel="stylesheet" href="css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:700,600' rel='stylesheet' type='text/css'>
    <script type="text/javascript">
        function setInput(button) {
            button.style.visibility = "hidden";
        }
    </script>
    <?php
        session_start();
    ?>
</head>
<body>
    <form action="success.php" method="get" >
        Predmet : <?php echo $_SESSION['predmet'];echo nl2br ( "\n");?>
        Počet bodov pre tím : <?php echo $_GET["team"];
        echo nl2br ( "\n");?>
        <input type="text" name="body"><br>
        <button type="submit" value="Submit">Vlož body</button>
    </form>

<?php
session_start();
$_SESSION['word'] = $_GET["team"];
$tim =  $_GET["team"];
$predmet = $_SESSION['predmet'] ;
include 'config.php';

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql2 = mysqli_query($conn, "SELECT * FROM ULOHA2 WHERE predmet ='$predmet ' AND tim='$tim'");

echo "<table class='blueTable'>";
echo "<th>Email</th>";
echo "<th>Meno</th>";
echo "<th>Body</th>";
echo "<th>Suhlas</th>";

echo "</tr>";

while($row = mysqli_fetch_array($sql2)){
    if((int)$row['tim'] == $_GET["team"]) {

        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['meno'] . "</td>";
        echo "<td>" . $row['body'] . "</td>";
        echo "<td>" .$row['suhlas'] ."</td>";
        echo "</tr>";
    }
}
echo "</table>";



$sql2 = mysqli_query($conn, "SELECT * FROM ULOHA2BODY WHERE predmet='$predmet' AND tim  ='$tim'");
while($row = mysqli_fetch_array($sql2)){
    if($row['suhlas_admin'] != "suhlasim"){
        echo "<form action='success2.php' method='get' >";
        echo "<button type='submit' value='agree' name='agree'>"."Suhlasim"."</button>";
        echo "<button type='submit' value='disagree' name='agree'>"."Nesuhlasim"."</button>";
        echo "</form>";
    }
    else{
        echo "Rozdelenie bodov bolo schvalene";
    }
}
?>
    <form action='statistics.php' method='get' >
        <button type='submit' value="" name='statistics'>Štatistiky</button>
    </form>
</body>
</html>
