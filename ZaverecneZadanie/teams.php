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
<div class='topnav'>
        <a href='uloha1_logout.php' role='button' >Odhlásiť</a>
        <form action='statistics.php' method='get' >
            <button class="uloha2_nav" type='submit' value="" name='statistics'>Štatistiky</button>
        </form>

    <form action='export.php' method='get' >
        <button class="uloha2_nav" type='submit' value="" name='export'>Export</button>
    </form>
</div>
<!--<div class="col text-right"><a href="uloha2_logout.php"class="btn btn-info" role="button" >Odhlásiť</a> </div>-->
<div class="uloha2">
    <form action="success.php" method="get" >
        Rok predmetu : <?php echo $_SESSION['rok'];echo nl2br ( "\n");?>
        Predmet : <?php echo $_SESSION['predmet'];echo nl2br ( "\n");?>
        Počet bodov pre tím : <?php echo $_GET["team"];
        echo nl2br ( "\n");?>
        <input class="uloha2" type="text" name="body"><br>
        <button class="uloha2" type="submit" value="Submit">Vlož</button>
    </form>
</div>
<br>
<?php
session_start();
if(!$_SESSION['admin']){
    header('location:uloha2_index.php');
}
$_SESSION['word'] = $_GET["team"];
$tim =  $_GET["team"];
$predmet = $_SESSION['predmet'] ;
$rok = $_SESSION['rok'] ;
include 'config.php';

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql2 = mysqli_query($conn, "SELECT * FROM ULOHA2 WHERE predmet ='$predmet ' AND tim='$tim' AND rok_predmetu='$rok'");

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
       // echo "<td>" .$row['suhlas'] ."</td>";
          if($row['suhlas'] == 'suhlasim') {
      echo "<td>" . "&#128077" . "</td>";
  }
  else if ($row['suhlas'] == 'nesuhlasim'){
      echo "<td>" . "&#128078" . "</td>";
  }

        echo "</tr>";
    }
}

echo "</table>";



$sql2 = mysqli_query($conn, "SELECT * FROM ULOHA2BODY WHERE predmet='$predmet' AND tim  ='$tim' AND rok_predmetu='$rok'");
while($row = mysqli_fetch_array($sql2)){
    if($row['suhlas_admin'] != "suhlasim"){
        echo "<form action='success2.php' method='get' >";
        echo "<button class='uloha2' type='submit' value='agree' name='agree'>"."Suhlasim"."</button>";
        echo "<button class='uloha2' type='submit' value='disagree' name='agree'>"."Nesuhlasim"."</button>";
        echo "</form>";
    }
    else{
        echo "Rozdelenie bodov bolo schvalene";
    }
}
?>

</body>
</html>
