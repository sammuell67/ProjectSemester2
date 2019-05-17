<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css">

</head>
<header>
    <div class="references">
        <a href="index.php">Lokalizácia</a>
        <a href="forecast.php">Počasie</a>
        <a href="visit.php">Navstevnosť</a>

    </div>
</header>
<body>
<?php

require __DIR__.'/config.php';
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$pgname="visit.php";
$ip = $_SERVER['REMOTE_ADDR']; // the IP address to query
$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
$country=$query['country'];
$code=$query['countryCode'];
$hodina =  date("Y-m-d H:i:s");
$den =date("Y-m-d");
$IP=$_SERVER['REMOTE_ADDR'];
if ($query['city']!=null) {
    echo "Mesto :" . $query['city'] . "<br>";
    $mesto=$query['city'];
}
else{
    //echo "Mesto sa nedá lokalizovať alebo sa nachádzate na vidieku <br>";
    $mesto="nelokalizované mestá a vidiek";
}
$log="INSERT INTO Visitors(IP,Country,Country_code,City,Page_name,Hodina,Den) VALUES ('$IP','$country','$code','$mesto','$pgname','$hodina','$den')";
if ($conn->query($log) === TRUE){
    echo "zapisalo";
}
$sql="SELECT Country,Country_code, COUNT(Country) FROM `Visitors`
      GROUP BY Country,Country_code";

$best="SELECT Page_name,COUNT(Page_name) as pocet
FROM Visitors
GROUP BY Page_name ORDER BY POCET DESC LIMIT 1";
$visited = $conn->query($sql);
echo "<table><tr><th>Krajina</th><th>Vlajka</th><th>Počet návštev</th></tr>";
while ($rowsec = $visited->fetch_assoc()) {
    $kraj = $rowsec['Country'];
    $flag = strtolower($rowsec['Country_code']);
    $pocet= $rowsec['COUNT(Country)'];
echo"<tr><td>$kraj</td><td>";
echo "<img src=http://www.geonames.org/flags/x/$flag.gif width='40' height='30'>";
echo "</td><td>$pocet</td>";
}
echo "</table>";

$poceta = $conn->query($best);
$naj = $poceta->fetch_assoc();
echo "Stránka s najvyšším počtom navštev : ".$naj['Page_name']." ".$naj['pocet'];
?>
</body>
</html>
