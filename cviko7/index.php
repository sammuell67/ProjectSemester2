
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Title</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css">

</head>
<header>
    <div class="references">
        <a href="#">Lokalizácia</a>
        <a href="forecast.php">Počasie</a>
        <a href="visit.php">Navstevnosť</a>

    </div>
</header>
<body>
<span id="code">
        <?php
        $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
        echo $query['countryCode'];
        ?>
    </span>

<div id="res">

</div>
<script>
    var code = document.getElementById("code").innerHTML.trim();
    console.log(code);

    //https://api.darksky.net/forecast/77609e77fab21409f3eba840110d8405/'.$query['lat'].",".$query['lon']
    //https://api.darksky.net/forecast/77609e77fab21409f3eba840110d8405/37.8267,-122.4233
    //var url="https://openweathermap.org/data/2.5/forecast?lat="+lat+"&lon="+lon+"&APPID=d4b8ffef1c3a6b948eef14f048965b89";
    var url = "https://restcountries.eu/rest/v2/alpha/"+code;
    //Access-Control-Allow-Origin:"https://api.darksky.net/forecast/77609e77fab21409f3eba840110d8405/37.8267,-122.4233";
    console.log(url);
  $.get(url,function(data){

        //  http://openweathermap.org/img/w/10d.png

      $("#res").append("Hlavne mesto: "+data.capital
      );
    } );
</script>
</body>
</html>
<?php
echo "<div>";
require __DIR__.'/config.php';
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$pgname="index.php";
$ip = $_SERVER['REMOTE_ADDR']; // the IP address to query
$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
if($query && $query['status'] == 'success') {
    echo "Tvoja IP :".$_SERVER['REMOTE_ADDR']."<br>";
    if ($query['city']!=null) {
        echo "Mesto :" . $query['city'] . "<br>";
        $mesto=$query['city'];
    }
    else{
        echo "Mesto sa nedá lokalizovať alebo sa nachádzate na vidieku <br>";
        $mesto="nelokalizované mestá a vidiek";
    }
    echo "Tvoja GPS suradnice :"."Latitude :".$query['lat']." Longitude :".$query['lon']."<br>";
    echo "Krajina :".$query['country']."<br>";
    $country=$query['country'];
    $code=$query['countryCode'];
    $hodina =  date("Y-m-d H:i:s");
    $den =date("Y-m-d");
    $IP=$_SERVER['REMOTE_ADDR'];
    //$IP=$_SERVER['REMOTE_ADDR'];
    $log="INSERT INTO Visitors(IP,Country,Country_code,City,Page_name,Hodina,Den) VALUES ('$IP','$country','$code','$mesto','$pgname','$hodina','$den')";
    if ($conn->query($log) === TRUE){
        echo "zapisalo";
    }
//.$query['country']
    // $json = file_get_contents("https://restcountries.eu/rest/v2/alpha/".$code);
    //var_dump($query);

} else {
    echo 'Unable to get location';
}
echo "</div>"
?>