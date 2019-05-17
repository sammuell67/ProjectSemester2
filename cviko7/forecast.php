<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Title</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet"  href="css/style.css">

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
echo "<div>";
$country="";
require __DIR__.'/config.php';
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$pgname="forecast.php";
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

//$mesto=$query['city'];
$geoplugin = unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $_SERVER['REMOTE_ADDR']) );

if ( is_numeric($geoplugin['geoplugin_latitude']) && is_numeric($geoplugin['geoplugin_longitude']) ) {

    $lat = $geoplugin['geoplugin_latitude'];
    $long = $geoplugin['geoplugin_longitude'];
    //set farenheight for US
    if ($geoplugin['geoplugin_countryCode'] == 'US') {
        $tempScale = 'fahrenheit';
        $tempUnit = '&deg;F';
    } else {
        $tempScale = 'celsius';
        $tempUnit = '&deg;C';
    }
    require_once('ParseXml.class.php');

    $xml = new ParseXml();
    $xml->LoadRemote("http://api.wunderground.com/auto/wui/geo/ForecastXML/index.xml?query={$lat},{$long}", 3);
    $dataArray = $xml->ToArray();

    $html = "<h2>Mesto : " . $geoplugin['geoplugin_city'];
    echo"<div class='forecast'>";
    $html .= "</h2><table cellpadding=5 cellspacing=10><tr>";
    ;
    foreach ($dataArray['simpleforecast']['forecastday'] as $arr) {

        echo $arr['date']['weekday'];

        $html .= "<td align='center'>" . $arr['date']['weekday'] . "<br />";
        $html .= "<img src='http://icons-pe.wxug.com/i/c/a/" . $arr['icon'] . ".gif' border=0 /><br />";
        $html .= "<font color='red'>" . $arr['high'][$tempScale] . $tempUnit . " </font>";
        $html .= "<font color='blue'>" . $arr['low'][$tempScale] . $tempUnit . "</font>";
        $html .= "</td>";


    }
    $html .= "</tr></table></div>";

    echo $html;

    $json = json_decode($weather);

}
$log="INSERT INTO Visitors(IP,Country,Country_code,City,Page_name,Hodina,Den) VALUES ('$IP','$country','$code','$mesto','$pgname','$hodina','$den')";
if ($conn->query($log) === TRUE){

}
echo "</div>";s
?>
</body>
</html>
